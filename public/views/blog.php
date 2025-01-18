<?php
$result = pg_query($dbconn, 'SELECT * FROM posts ORDER BY "created_at" asc');
$featured_post = pg_fetch_row($result);
$all_posts = pg_fetch_all($result);
array_shift($all_posts);


// $posts = (count($temp_posts) == 1) ? ["none"] : array_shift($temp_posts);

$parser = new \cebe\markdown\Markdown();
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once dirname(__FILE__, 2) . '/includes/head.php' ?>

<body>
    <div class="blog-page">
        <div class="main-column">
            <h2>* Latest Post</h2>
	        <h3>~ <?php echo ucwords($featured_post[6]);?></h3>
            <?php echo $parser->parse($featured_post[1]) ?>
        </div>

        <div class="container">
            <h2>* Other Posts</h2>
            <?php
            if (count($all_posts) > 0) {
                foreach ($all_posts as $post) {
					$title = Hyphenate($post['title']);
					$newTitle = ucwords($post['title']);
                    echo "<a href='/blog/$title'>~ $newTitle</a><br/>";
                }
            } else {
                echo "<p>~ No other posts</p>";
            }
            ?>
        </div>
    </div>
    <?php include_once dirname(__FILE__, 2) . '/includes/footer.php' ?>
</body>

</html>