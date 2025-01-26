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
    <div class="blog-page">
        <div class="main-column">
            <h2># <?php echo $_SESSION['TAG']; ?></h2>
            <?php
            $filteredPosts = array_filter($filtered, function ($post) use ($tag) {
                return in_array($tag, $post['tags']);
            });

            if (!empty($filteredPosts)) {
                foreach ($filteredPosts as $post_slug => $post_data) {
                    $title = $post_data['title'];
                    echo "<a href='/post/{$post_slug}'>~ $title</a><br/>";
                }
            } else {
                echo "<p>No public posts found with this tag.</p>";
            }
            ?>
            <br>
            <a href="/blog" class="linkback">← Go back</a>
        </div>
        <div class="container">
            <h2>> Other Tags</h2>
            <?php
            $filteredTags = array_filter($uniqueTags, function ($localTag) use ($tag) {
                return $localTag != $tag;
            });

            foreach ($filteredTags as $uniqueTag) {
                $title = $uniqueTag;
                echo "<a href='/tag/{$uniqueTag}'># $title</a><br/>";
            }
            ?>
        </div>
    </div>
    </div>
    <?php include_once ROOT_DIR . '/public/includes/footer.php' ?>
</body>

</html>