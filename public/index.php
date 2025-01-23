<?php
require dirname(__DIR__, 1) . "/private/config.php";
require ROOT_DIR . "/vendor/autoload.php";

$parser = new \cebe\markdown\Markdown();

$request = $_SERVER['REQUEST_URI'];
$exploded = explode('/', $request);

$viewDir = '/views/';
$postDir = 'data/posts';
$tempDir = 'data/temp';

$posts = [];
$keys = [];

session_start();

foreach (scandir($postDir) as $post) {
    if ($post == "." || $post == "..")
        continue;
    foreach (scandir("$postDir/$post") as $file) {
        if ($file == "." || $file == "..")
            continue;
        $posts[$post][pathinfo("$postDir/$post/$file")['filename']] = file_get_contents("$postDir/$post/$file");
    }
    $keys[] = $post;
}

$uniqueTags = [];

foreach ($posts as $post) {
    $tags = explode(PHP_EOL, $post['tags']);

    foreach ($tags as $tag) {
        if (!in_array($tag, $uniqueTags)) {
            $uniqueTags["$tag"] = $tag;
        }
    }
}

function Hyphenate($string)
{
    return implode("-", explode(' ', strtolower($string)));
}

switch ($request) {
    case '':
    case '/':
        echo "<head><script defer src='https://monitor.koehn.lol/script.js'
		data-website-id='9d5f0600-18f9-4478-80eb-fb9f840e0c0d'></script></head>";
        require __DIR__ . $viewDir . 'home.php';
        break;
    case '/blog':
        echo "<head><script defer src='https://monitor.koehn.lol/script.js'
		data-website-id='9d5f0600-18f9-4478-80eb-fb9f840e0c0d'></script></head>";
        require __DIR__ . $viewDir . 'blog.php';
        break;
    case (bool) preg_match('(\/tag\/\S)', $request):
        echo "<head><script defer src='https://monitor.koehn.lol/script.js'
		data-website-id='9d5f0600-18f9-4478-80eb-fb9f840e0c0d'></script></head>";
        if (in_array($exploded[2], $uniqueTags)) {
            $_SESSION['TAG'] = $uniqueTags[$exploded[2]];

            require __DIR__ . $viewDir . 'tag.php';
        } else {
            require __DIR__ . $viewDir . '404.php';
        }

        break;
    case (bool) preg_match('(\/post\/\S)', $request):
        echo "<head><script defer src='https://monitor.koehn.lol/script.js'
		data-website-id='9d5f0600-18f9-4478-80eb-fb9f840e0c0d'></script></head>";
        if (count($posts) > 0 && in_array($exploded[2], $keys)) {
            $targetKey = $exploded[2];

            $_SESSION['POST'] = $posts[$targetKey];

            if (!empty($exploded[3]) && $exploded[3] == 'raw') {
                echo "<h2>" . $_SESSION['POST']['title'] . "</h2>";
                echo "<p>" . $_SESSION['POST']['description'] . "</p>";
                echo "<p>" . $parser->parse($_SESSION['POST']['content']) . "</p>";
                break;
            } else if (!empty($exploded[3])) {
                header("Location: /post/$exploded[2]");
            }

            require __DIR__ . $viewDir . 'post.php';
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
        echo "<head><script defer src='https://monitor.koehn.lol/script.js'
		data-website-id='9d5f0600-18f9-4478-80eb-fb9f840e0c0d'></script></head>";
        require __DIR__ . $viewDir . 'listening.php';
        break;
    default:
        echo "<head><script defer src='https://monitor.koehn.lol/script.js'
		data-website-id='9d5f0600-18f9-4478-80eb-fb9f840e0c0d'></script></head>";
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
}
