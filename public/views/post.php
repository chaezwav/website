<!DOCTYPE html>
<html lang="en">
<?php include_once ROOT_DIR . '/public/includes/head.php' ?>

<head>
    <meta property="og:title" content="Koehn @ <?php echo $_SESSION['POST']['title']; ?>">
    <meta property="og:url" content="https://koehn.lol/post/<?php echo $_SESSION['POST']['slug']; ?>">
    <title>Koehn @ <?php echo $_SESSION['POST']['title']; ?></title>
</head>

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
    <article class="h-entry">
        <div class="profile">
            <div class="body">
                <span>
                    <h2><?php echo $_SESSION['POST']['title']; ?><a style="text-decoration: none !important;" href=<?php echo 'https://koehn.lol/post/' . $_SESSION['POST']['slug'] . '/raw' ?>>˚</a></h2>
                </span>
                <span>
                    <p class="webring">| <?php echo $_SESSION['POST']['description']; ?></p>
                </span>
            </div>
        </div>
        <div class="body-content e-content">
            <?php echo $parser->parse($_SESSION['POST']['content']) ?>
        </div>
        <span class="metadata">
            <p>* * *</p>
            <br>
            <p>@ <a rel="author" class="p-author h-card" href="https://social.lol/@koehn">koehn</a>
                <image class="u-photo" src="/static/assets/logo.png" style="display: none;" />
            </p>
            <p>∞ <time class="dt-published"><?php $date = new DateTimeImmutable($_SESSION['POST']["pub_at"]);
            echo $date->format('Y-m-d H:m:s') ?></time></p>
            <p># <?php
            foreach (explode(PHP_EOL, $_SESSION['POST']['tags']) as $tag) {
                echo "<a class='p-category' href='/tag/$tag'>$tag</a>";
            }
            ?></p>
            <p>~ <?php
            echo "<a class='u-url' href='https://koehn.lol/post/{$_SESSION['POST']['slug']}'>permalink</a>";
            ?></p>
        </span>
    </article>
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
                echo "<p><a href='/post/{$slug}'>~ $title</a></p>";
            }
        } else {
            echo "<p>~ No other posts</p>";
        }
        ?>
    </span>
    <?php include_once ROOT_DIR . '/public/includes/footer.php' ?>
</body>

</html>