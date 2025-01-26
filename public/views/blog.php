<?php

$filtered = array_filter($posts, function ($post) {
    return $post['status'] === 'published';
});

function compare_pub_at($a, $b)
{
    global $filtered;
    return strcmp($filtered[$b]['pub_at'], $filtered[$a]['pub_at']);
}

// Using uksort to sort the array by pub_at
uksort($filtered, 'compare_pub_at');

$featured_post = array_values($filtered)[0] + ['slug' => array_keys($filtered)[0]];
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once ROOT_DIR . '/public/includes/head.php' ?>

<head>
    <meta property="og:title" content="Koehn @ Blog">
    <meta property="og:url" content="https://koehn.lol/blog">
    <title>Koehn @ Blog</title>
</head>

<body>
    <div class="container">
        <div class="body-content e-content">
            <div class="post-header">
                <br>
                <h2>Latest Post</h2>
                <h3><?php echo $featured_post['title']; ?></h3>
                <p class="webring">| <?php echo $featured_post['description']; ?></p>
            </div>
            <p class="webring"><?php
            $featured = new DateTimeImmutable($featured_post["pub_at"]);
            $formatted = $featured->format('Y-m-d');
            echo $formatted;
            ?></p>
            <?php
            // truncates the text
            $text_truncated = mb_substr($featured_post['content'], 0, mb_strpos($featured_post['content'], ' ', 150));

            // prevents last word truncation
            $preview = trim(mb_substr($text_truncated, 0, mb_strrpos($text_truncated, ' '))) . '...';

            echo $parser->parse($preview);
            $slug = "/post/" . $featured_post['slug'];
            echo "<br>";
            echo "<a class='linkback' href=$slug><i class='fa-solid fa-right-long'></i> Continue reading...</a>"
                ?>
        </div>
        <div>
            <h2>Other Posts</h2>
            <span class="metadata">
                <?php
                if (count($filtered) > 1) {
                    $local = array_filter($filtered, function ($post) {
                        return $post['status'] === 'published';
                    });

                    $localPosts = array_filter($local, function ($post, $key) {
                        global $featured_post;

                        return $key !== $featured_post['slug'];
                    }, ARRAY_FILTER_USE_BOTH);

                    foreach ($localPosts as $slug => $post) {
                        echo "<p><i class='fa-regular fa-file-lines'></i> <a href='/post/{$slug}'>$post[title]</a></p>";
                    }
                } else {
                    echo "<p><i class='fa-regular fa-ban'></i> No other posts</p>";
                }
                ?></span>
            <h2>Tags</h2>
            <span class="metadata">
                <p><?php
                foreach ($uniqueTags as $tag) {
                    echo "<p><i class='fa-solid fa-tag'></i> <a href='/tag/$tag'>$tag</a></p>";
                }
                ?></p>
            </span>
        </div>
    </div>
    <?php include_once ROOT_DIR . '/public/includes/footer.php' ?>
</body>

</html>