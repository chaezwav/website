<?php
$connstring = sprintf("host=%s port=%s user=%s password=%s dbname=%s", $_ENV['DB_HOST'], $_ENV['DB_PORT'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);
$dbconn = pg_connect($connstring)
    or die('Could not connect: ' . pg_last_error());

$result = pg_query($dbconn, 'SELECT * FROM posts ORDER BY "created_at" asc');
$featured_post = pg_fetch_row($result);
$all_posts = pg_fetch_all($result);
array_shift($all_posts);


// $posts = (count($temp_posts) == 1) ? ["none"] : array_shift($temp_posts);

$parser = new \cebe\markdown\Markdown();

function parseArray(string $output)
{
    if ($output === '{}') {
        return [];
    }
    return mb_split(',', mb_substr($output, 1, -1));
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once dirname(__FILE__, 2) . '/includes/head.php' ?>

<body>
    <div class="blog-page">
        <div class="main-column">
            <h2>* <?php echo $featured_post[6]; ?></h2>
            <?php echo $parser->parse($featured_post[1]) ?>
        </div>

        <div class="container">
            <h2>* Metadata</h2>
            <div class="metadata">
                <p>~ <?php echo $featured_post[0] ?></p>
                <p><?php
                switch ($featured_post[5]) {
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

                echo " $featured_post[5]"

                    ?>
                </p>

                <p>
                    ∞ <?php
                    echo $featured_post[2]

                        ?>
                </p>


                <?php
                foreach (parseArray($featured_post[4]) as $tag) {
                    echo "<p># <a href='/tag?name=$tag'>$tag</a></p>";
                }
                ?>

            </div>
            <h2>* Other Posts</h2>
            <?php
            if (count($all_posts) > 0) {
                foreach ($all_posts as $post) {
                    echo "<a href='/post?id={$post['id']}'>~ $post[title]</a><br/>";
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