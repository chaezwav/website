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
            <?php
            // we don't want new lines in our preview
            $text_only_spaces = preg_replace('/\s+/', ' ', $featured_post['content']);

            // truncates the text
            $text_truncated = mb_substr($text_only_spaces, 0, mb_strpos($text_only_spaces, ' ', 250));

            // prevents last word truncation
            $preview = trim(mb_substr($text_truncated, 0, mb_strrpos($text_truncated, ' '))).'...';

            echo $parser->parse($preview);
			$slug = "/blog/post/".Hyphenate($featured_post['title']);

            echo "<a class='linkback' href=$slug>→ Continue reading...</a>"
            ?>
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