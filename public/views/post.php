<!DOCTYPE html>
<html lang="en">
<?php include_once ROOT_DIR . '/public/includes/head.php' ?>

<body>
    <a href="/blog" class="linkback">← Go back</a>
    <a style="text-decoration: none !important; color: var(--tertiary-color) !important; cursor: text;"><?php
    $string = $_SESSION['POST']['status'];

    switch ($string) {
        case 'unlisted':
            echo "∆ $string";
            break;
        case 'draft':
            echo "∏ $string";
            break;
        case 'private':
            echo "∇ $string";
            break;
        default:
            echo "";
            break;
    } ?>
    </a>
    <br>
    <div class="post">
        <div class="profile">
            <div class="body">
                <span>
                    <h2><?php echo $_SESSION['POST']['title']; ?><a style="text-decoration: none !important;" href=<?php echo 'https://koehn.lol/blog/' . $_SESSION['POST']['slug'] . '/raw' ?>>˚</a></h2>
                </span>
                <span>
                    <p class="webring">| <?php echo $_SESSION['POST']['description']; ?></p>
                </span>
            </div>
        </div>
        <div class="body-content">
            <?php echo $parser->parse($_SESSION['POST']['content']) ?>
        </div>
        <span class="metadata">
            <p>* * *</p>
            <br>
            <p>@ koehn</p>
            <p>∞ <?php $date = new DateTimeImmutable($_SESSION['POST']["pub_at"]);
            echo $date->format('Y-m-d') ?></p>
            <p># <?php
            foreach (explode(PHP_EOL, $_SESSION['POST']['tags']) as $tag) {
                echo "<a href='/blog/tag/$tag'>$tag</a>";
            }
            ?></p>
        </span>
    </div>
    <h2>Other Posts</h2>
    <span class="metadata">
        <?php
        if (count($posts) > 1) {
            $filtered = array_filter($posts, function ($post) {
                return $post['status'] === 'published';
            });

            $filteredPosts = array_filter($filtered, function ($post) {
                return $post != $_SESSION['POST'];
            });

            foreach ($filteredPosts as $post_slug => $post_data) {
                $title = $post_data['title'];
                $slug = $post_data['slug'];
                echo "<p><a href='/blog/{$slug}'>~ $title</a></p>";
            }
        } else {
            echo "<p>~ No other posts</p>";
        }
        ?>
    </span>
    <?php include_once ROOT_DIR . '/public/includes/footer.php' ?>
</body>

</html>