<?php

$filtered = array_filter($posts, function ($post) {
    return $post['status'] === 'published';
});

usort($filtered, function ($a, $b) {
    return strcmp($b['pub_at'], $a['pub_at']);
});

$featured_post = reset($filtered);

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
    <h2>* Latest Post</h2>
    <div class="body">
        <h3><?php echo $featured_post['title']; ?></h3>
        <p class="webring">| <?php echo $featured_post['description']; ?></p>
    </div>
    <div class="body-content e-content">
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
        echo "<a class='linkback' href=$slug>→ Continue reading...</a>"
            ?>
    </div>
    <h2>* Other Posts</h2>
    <span class="metadata">
        <?php
        if (count($posts) > 1) {
            $filteredPosts = array_filter($filtered, function ($post) use ($featured_post) {
                return $post['title'] !== $featured_post['title'];
            });

            foreach ($filteredPosts as $post_data) {
                $title = $post_data['title'];
                $slug = $post_data['slug'];
                $date = new DateTimeImmutable($post_data["pub_at"]);

                $formatted = $date->format('Y-m-d');
                echo "<div class='metadata'>";
                echo "<p><a href='/post/{$slug}'>~ $title</a></p>";
                echo "<p class='webring'>$formatted</p>";
                echo "</div>";
            }
        } else {
            echo "<p>~ No other posts</p>";
        }
        ?></span>
    <h2>* Tags</h2>
    <span class="metadata">
        <p><?php
        foreach ($uniqueTags as $tag) {
            echo "<p># <a href='/tag/$tag'>$tag</a></p>";
        }
        ?></p>
    </span>

    <?php include_once ROOT_DIR . '/public/includes/footer.php' ?>
</body>

</html>