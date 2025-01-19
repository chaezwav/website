<?php
require dirname(__FILE__, 2) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__, 2));
$dotenv->load();

$request = $_SERVER['REQUEST_URI'];
$exploded = explode('/', $request);

$viewDir = '/views/';
$postDir = 'data/posts';

$posts = array();
$keys = array();

session_start();

foreach(scandir($postDir) as $post) {
    if ($post == "." || $post == "..") continue;
    foreach(scandir("$postDir/$post") as $file) {
        if ($file == "." || $file == "..") continue;
        $posts[$post][pathinfo("$postDir/$post/$file")['filename']] = file_get_contents("$postDir/$post/$file");
    }
    $keys[] = $post;
}

$uniqueTags = array();

foreach($posts as $post)
{
    $tags = explode(PHP_EOL, $post['tags']);

    foreach($tags as $tag) {
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
        require __DIR__ . $viewDir . 'home.php';
        break;
    case '/blog':
        require __DIR__ . $viewDir . 'blog.php';
        break;
    case '/version':
        require __DIR__ . $viewDir . 'version.php';
        break;
    case '/spotify':
        require __DIR__ . $viewDir . 'spotify.php';
        break;
    case (bool)preg_match('(callback\?\S)', $request):
        require __DIR__ . $viewDir . 'render.php';
        break;
    case '/refresh':
        require __DIR__ . '/functions/refreshToken.php';
        break;
    case (bool)preg_match('(\/blog\/tag\/\S)', $request):
        if (in_array($exploded[3], $uniqueTags)) {
            $_SESSION['TAG'] = $uniqueTags[$exploded[3]];

            require __DIR__ . $viewDir . 'tag.php';
        } else {
            require __DIR__ . $viewDir . '404.php';
        }

        break;
    case (bool)preg_match('(\/blog\/post\/\S)', $request):
        if (count($posts) > 0 && in_array($exploded[3], $keys)) {
            $targetKey = $exploded[3];

            $_SESSION['POST'] = $posts[$targetKey];

            require __DIR__ . $viewDir . 'post.php';
        } else {
            require __DIR__ . $viewDir . '404.php';
        }
        break;
    default:
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
}
