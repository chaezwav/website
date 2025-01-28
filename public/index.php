<?php
require dirname(__DIR__, 1) . "/private/config.php";
require ROOT_DIR . "/vendor/autoload.php";

$parser = new \cebe\markdown\Markdown();

$request = $_SERVER['REQUEST_URI'];
$exploded = explode('/', $request);

$viewDir = '/views/';
$postDir = '/private/data/content/posts';
$tempDir = 'temp';

$posts = [];
$keys = [];

session_start();

foreach (scandir(ROOT_DIR . $postDir) as $post) {
    if ($post == "." || $post == "..")
        continue;
    [, $front, $rest] = preg_split('/^---$/m', file_get_contents(ROOT_DIR . "/private/data/content/posts/$post"), 3);
    $yaml = yaml_parse($front);
    $posts[pathinfo($post)['filename']] = $yaml + ['content' => $rest];
}

$uniqueTags = [];

foreach ($posts as $post) {
    $tags = $post['tags'];

    foreach ($tags as $tag) {
        if (!$uniqueTags[(string) $tag]) {
            $uniqueTags[(string) $tag] = $tag;
        }
    }
}

switch ($request) {
    case '':
    case '/':
        require __DIR__ . $viewDir . 'home.php';
        break;
    case '/blog':
        require __DIR__ . $viewDir . 'blog.php';
        break;
    case (bool) preg_match('(\/tag\/\S)', $request):
        if (in_array($exploded[2], $uniqueTags)) {
            $_SESSION['TAG'] = $uniqueTags[$exploded[2]];

            require __DIR__ . $viewDir . 'tag.php';
        } else {
            require __DIR__ . $viewDir . '404.php';
        }

        break;
    case (bool) preg_match('(\/post\/\S)', $request):
        if (count($posts) > 0 && key_exists($exploded[2], $posts)) {
            $key = $exploded[2];
            $_SESSION['POST'] = $posts[$key] + ['slug' => $key];

            if (!empty($exploded[3]) && $exploded[3] == 'raw') {
                echo "<h2>" . $_SESSION['POST']['title'] . "</h2>";
                echo "<p>" . $_SESSION['POST']['description'] . "</p>";
                echo "<p>" . $parser->parse($_SESSION['POST']['content']) . "</p>";
                break;
            } else if (!empty($exploded[3] && $exploded[3] == 'hash')) {
                echo "<p>" . md5_file(ROOT_DIR . "/private/data/content/posts/$key.md") . "</p>";
                break;
            } else {
                require __DIR__ . $viewDir . 'post.php';
            }
        } else {
            require __DIR__ . $viewDir . '404.php';
        }
        break;
    case (bool) preg_match('(\/tmp\/\S)', $request):
        $files = [];

        foreach (scandir($tempDir) as $script) {
            if ($script == "." || $script == "..")
                continue;
            $files[] = $script;
        }


        if (count($files) > 0 && in_array($exploded[2], $files)) {
            $targetKey = $exploded[2];

            require __DIR__ . $viewDir . 'tmp.php';
        } else {
            require __DIR__ . $viewDir . '404.php';
        }
        break;
    case "/feed.xml":
        require __DIR__ . $viewDir . 'rss.php';
        break;
    case "/listening":
        require __DIR__ . $viewDir . 'listening.php';
        break;
    case "/note":
        echo "parked";
        break;
    default:
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
}
