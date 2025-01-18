<?php
require dirname(__FILE__, 2) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__, 2));
$dotenv->load();

$connstring = sprintf("host=%s port=%s user=%s password=%s dbname=%s", $_ENV['DB_HOST'], $_ENV['DB_PORT'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);
$dbconn = pg_connect($connstring)
or die('Could not connect: ' . pg_last_error());

$result = pg_query($dbconn, 'SELECT * FROM posts');
$allPosts = pg_fetch_all($result);
$postNames = array_column($allPosts, 'title');

$request = $_SERVER['REQUEST_URI'];
$viewDir = '/views/';

$exploded = explode('/', $request);

function Dehyphenate($string) {
    return implode(' ', explode('-', $string));
}

function Hyphenate($string) {
    return implode("-", explode(' ', strtolower($string)));
}

function parseArray(string $output)
{
    if ($output === '{}') {
        return [];
    }
    return mb_split(',', mb_substr($output, 1, -1));
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
    case (bool)preg_match('(\/blog\/\S)', $request):
        $hyphenatedNames = array();

        foreach ($postNames as $name) {
            $hyphenatedNames[] = Hyphenate($name);
        }

        if (count($hyphenatedNames) > 0 && in_array($exploded[2], $hyphenatedNames)) {
            $targetKey = 'title';
            $targetValue = Dehyphenate($exploded[2]);

            $newPosts = array();

            foreach ($allPosts as $post) {
                $post[$targetKey] = strtolower($post[$targetKey]);
                $newPosts[] = $post;
            }

            $filteredArray = array_filter($newPosts, function($obj) use ($targetKey, $targetValue) {
                return isset($obj[$targetKey]) && $obj[$targetKey] === $targetValue;
            });

            $newPost = array_shift($filteredArray);

            require __DIR__ . $viewDir . 'post.php';
        } else {
            require __DIR__ . $viewDir . '404.php';
        }
        break;
    default:
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
}
