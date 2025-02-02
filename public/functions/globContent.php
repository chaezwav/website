<?php

require dirname(__DIR__, 2) . "/private/config.php";

$posts = [];
$posts2 = [];

foreach (scandir(ROOT_DIR . "/private/data/content/posts") as $post) {
    if ($post == "." || $post == "..") {
        continue;
    }
    $posts[] = pathinfo($post)["filename"];
    $posts2[] = pathinfo($post)["filename"];
}

if (!file_exists(ROOT_DIR . "/private/data/api/posts.txt")) {
    file_put_contents(
        ROOT_DIR . "/private/data/api/posts.txt",
        implode(PHP_EOL, $posts)
    );
}

$formatted = implode(PHP_EOL, $posts);

$persistedPosts = explode(PHP_EOL, file_get_contents(ROOT_DIR . "/private/data/api/posts.txt"));

if (file_get_contents(ROOT_DIR . "/private/data/api/posts.txt") !== $formatted) {
    foreach (array_diff($posts, $persistedPosts) as $post) {
        [, $front] = preg_split(
            '/^---$/m',
            file_get_contents(ROOT_DIR . "/private/data/content/posts/$post.md"),
            3
        );
        $yaml = yaml_parse($front);

        $ch = curl_init(MASTODON_INSTANCE . "/api/v1/statuses");

        $statusText = "💃 New post: " . $yaml["title"] . "\n> " . $yaml["description"] . "\n\nhttps://koehn.lol/post/$post";

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            "status" => $statusText
        ]));

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . MASTODON_TOKEN
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            echo "Error: " . curl_error($ch);
        } else {
            echo "Post successful!";
        }

        curl_close($ch);
    }

    file_put_contents(
        ROOT_DIR . "/private/data/api/posts.txt",
        $formatted
    );

    echo "Posts updated!";
}
