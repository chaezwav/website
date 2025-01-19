<?php

$parser = new \cebe\markdown\Markdown();
$tag = $_SESSION['TAG'];
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once dirname(__FILE__, 2) . '/includes/head.php' ?>

<body>
<div class="blog-page">
    <div class="main-column">
        <h2>* <?php echo $_SESSION['TAG']; ?></h2>
        <?php
        $filteredPosts = array_filter($posts, function ($post) use ($tag) {
            return in_array($tag, explode(PHP_EOL, $post['tags']));
        });

        foreach ($filteredPosts as $post_slug => $post_data) {
            $title = $post_data['title'];
            echo "<a href='/blog/post/{$post_slug}'>~ $title</a><br/>";
        }
        ?>
        <a href="/blog" class="linkback">← Go back</a>
    </div>
    <div class="container">
        <h2>* Other Tags</h2>
        <?php
            $filteredTags = array_filter($uniqueTags, function ($localTag) use ($tag) {
                return $localTag != $tag;
            });

            foreach ($filteredTags as $uniqueTag) {
                $title = $uniqueTag;
                echo "<a href='/blog/tag/{$uniqueTag}'>~ $title</a><br/>";
            }
        ?>
    </div>
</div>
</div>
<?php include_once dirname(__FILE__, 2) . '/includes/footer.php' ?>
</body>

</html>
