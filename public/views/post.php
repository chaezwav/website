<?php

$parser = new \cebe\markdown\Markdown();
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once dirname(__FILE__, 2) . '/includes/head.php' ?>

<body>
<div class="blog-page">
    <div class="main-column">
        <h2>* <?php echo $_SESSION['POST']['title']; ?></h2>
        <?php echo $parser->parse($_SESSION['POST']['content']) ?>
	    <a href="/blog" class="linkback">← Go back</a>
    </div>

    <div class="container">
        <h2>* Metadata</h2>
        <div class="metadata">
            <p><?php
                switch ($_SESSION['POST']['status']) {
                    case 'published':
                        echo '≈';
                        break;
                    case 'unlisted':
                        echo '~';
                        break;
                    case 'draft':
                        echo '»';
                        break;
                    case 'private':
                        echo '*';
                        break;
                }

                echo " {$_SESSION['POST']['status']}"

                ?>
            </p>

            <p>
                ∞ <?php
                echo $_SESSION['POST']["pub_at"]

                ?>
            </p>


            <?php
            foreach (explode(PHP_EOL, $_SESSION['POST']['tags']) as $tag) {
                echo "<p># <a href='/blog/tag/$tag'>$tag</a></p>";
            }
            ?>

        </div>
        <h2>* Other Posts</h2>
		<?php
        if (count($posts) > 1) {
			$filteredPosts = array_filter($posts, function ($post) {
				return $post != $_SESSION['POST'];
			});

            foreach ($filteredPosts as $post_slug => $post_data) {
				$title = $post_data['title'];
                echo "<a href='/blog/post/{$post_slug}'>~ $title</a><br/>";
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
