<?php
usort($posts, function($a, $b)
{
    return strcmp($b['pub_at'], $a['pub_at']);
});

$featured_post = reset($posts);
$parser = new \cebe\markdown\Markdown();
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once dirname(__FILE__, 2) . '/includes/head.php' ?>

<body>
    <div class="blog-page">
        <div class="main-column">
            <h2>* Latest Post</h2>
	        <h3>~ <?php echo $featured_post['title'];?></h3>
            <?php echo $parser->parse($featured_post['content']) ?>
        </div>

        <div class="container">
	        <h2>* Other Posts</h2>
            <?php
            if (count($posts) > 1) {
                $filteredPosts = array_filter($posts, function ($post) use ($featured_post) {
                    return $post['title'] !== $featured_post['title'];
                });

                foreach ($filteredPosts as $post_slug => $post_data) {
                    $title = $post_data['title'];
					$slug = Hyphenate($title);
                    echo "<a href='/blog/post/{$slug}'>~ $title</a><br/>";
                }
            } else {
                echo "<p>~ No other posts</p>";
            }
            ?>
	        <h2>* Tags</h2>
            <?php
                foreach ($uniqueTags as $tag) {
                    $title = $tag;
                    echo "<a href='/blog/tag/{$tag}'>~ $title</a><br/>";
                }
            ?>
        </div>
    </div>
    <?php include_once dirname(__FILE__, 2) . '/includes/footer.php' ?>
</body>

</html>