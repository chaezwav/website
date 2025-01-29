<?php
$tag = $_SESSION['TAG'];

$filtered = array_filter($posts, function ($post) {
    return $post['status'] === 'published';
});
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once ROOT_DIR . '/public/includes/head.php' ?>

<head>
    <meta property="og:title" content="Koehn @ <?php echo $_SESSION['TAG']; ?>">
    <meta property="og:url" content="https://koehn.lol/tag/<?php echo $_SESSION['TAG']; ?>">
    <title>Koehn @ <?php echo $_SESSION['TAG']; ?></title>
</head>

<body>
    <div class="container">
        <div class="body-content e-content">
            <br>
            <div class="post-header">
                <h2><?php echo $_SESSION['TAG']; ?></h2>
            </div>
            <br>
            <?php
            $filteredPosts = array_filter($filtered, function ($post) use ($tag) {
                return in_array($tag, $post['tags']);
            });

            if (!empty($filteredPosts)) {
                foreach ($filteredPosts as $post_slug => $post_data) {
                    $title = $post_data['title'];
                    echo "<a href='/post/{$post_slug}'><i class='fa-regular fa-file-lines'></i> $title</a><br/>";
                }
            } else {
                echo "<p><i class='fa-regular fa-ban'></i> No public posts found with this tag.</p>";
            }
            ?>
            <br>
            <a href="/blog" class="linkback">← Go back</a>
        </div>
        <div>
            <h2>Other Tags</h2>
            <span class="metadata">
                <?php
                $filteredTags = array_filter($uniqueTags, function ($localTag) use ($tag) {
                    return $localTag != $tag;
                });

                foreach ($filteredTags as $uniqueTag) {
                    $title = $uniqueTag;
                    echo "<a href='/tag/{$uniqueTag}'><i class='fa-solid fa-tag'></i> $title</a><br/>";
                }
                ?></span>
        </div>
    </div>
    <?php include_once ROOT_DIR . '/public/includes/footer.php' ?>
</body>