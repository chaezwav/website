<?php

$parser = new \cebe\markdown\Markdown();

$query = sprintf("SELECT * FROM posts WHERE title != '%s'", $newPost['title']);

$result = pg_query($dbconn, $query);
$filteredPosts = pg_fetch_all($result);
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once dirname(__FILE__, 2) . '/includes/head.php' ?>

<body>
<a href="/blog" class="linkback">~ Go back</a>
<div class="blog-page">
    <div class="main-column">
        <h2>* <?php echo ucwords($newPost['title']); ?></h2>
        <?php echo $parser->parse($newPost['content']) ?>
    </div>

    <div class="container">
        <h2>* Metadata</h2>
        <div class="metadata">
            <p>~ <?php echo $newPost['id'] ?></p>
            <p><?php
                switch ($newPost['publication_status']) {
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

                echo " {$newPost['publication_status']}"

                ?>
            </p>

            <p>
                ∞ <?php
                echo $newPost["created_at"]

                ?>
            </p>


            <?php
            foreach (parseArray($newPost['tags']) as $tag) {
                echo "<p># <a href='/tag?name=$tag'>$tag</a></p>";
            }
            ?>

        </div>
        <h2>* Other Posts</h2>
        <?php
        if (count($filteredPosts) > 0) {
            foreach ($filteredPosts as $post) {
                $title = Hyphenate($post['title']);
				$newTitle = ucwords($post['title']);
                echo "<a href='/blog/{$title}'>~ $newTitle</a><br/>";
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
