<!DOCTYPE html>
<html lang="en">
<?php include_once ROOT_DIR . '/public/includes/head.php'; ?>

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
            echo "🫣 $string";
            break;
        case 'draft':
            echo "📝 $string";
            break;
        default:
            break;
    } ?>
    </a>
    <div class="container">
        <div class="body-content">
            <article class="h-entry">
                <div class="profile">
                    <div class="body">
                        <br>
                        <div class="post-header">
                            <h2><?php echo $_SESSION['POST']['title']; ?><a style="text-decoration: none !important;"
                                    href=<?php echo 'https://koehn.lol/post/' . $_SESSION['POST']['slug'] . '/raw' ?>>˚</a></h2>
                            <p class="webring">| <?php echo $_SESSION['POST']['description']; ?></p>
                        </div>
                    </div>
                </div>

                <div class="e-content">
                    <?php echo $parser->parse($_SESSION['POST']['content']) ?>
                </div>
            </article>
        </div>

        <div class="sidebar">
            <h2>Metadata</h2>

            <span class="metadata">
                <p>😖 <a rel="author" class="p-author h-card" href="https://social.lol/@koehn">koehn</a>
                    <image class="u-photo" src="/static/assets/logo.png" style="display: none;" />
                </p>
                <p>⏰ <time class="dt-published"><?php $date = new DateTimeImmutable($_SESSION['POST']["pub_at"]);
                echo $date->format('Y-m-d') ?></time></p>
                <p>🏷️ <span class="tags"><?php
                foreach ($_SESSION['POST']['tags'] as $tag) {
                    echo "<a class='p-category' href='/tag/$tag'>$tag</a>";
                }
                ?></span>
                </p>
                <p>🔗 <?php
                echo "<a class='u-url' href='https://koehn.lol/post/{$_SESSION['POST']['slug']}'>permalink</a>";
                ?></p>
                <p>#️⃣
                    <a href="https://koehn.lol/post/<?php echo $_SESSION['POST']['slug'] ?>/hash"><?php
                       echo substr(md5_file(ROOT_DIR . "/private/data/content/posts/{$_SESSION['POST']['slug']}.md"), 0, 8) . '...';
                       ?></a>
                </p>
                <br>
            </span>

            <h2>Other Posts</h2>
            <span class="metadata">
                <?php
                if (count($posts) > 1) {
                    $filtered = array_filter($posts, function ($post) {
                        return $post['status'] === 'published';
                    });

                    $filteredPosts = array_filter($filtered, function ($post, $key) {
                        return $key !== $_SESSION['POST']['slug'];
                    }, ARRAY_FILTER_USE_BOTH);

                    foreach ($filteredPosts as $slug => $post) {
                        echo "<p>📄 <a href='/post/{$slug}'>$post[title]</a></p>";
                    }
                } else {
                    echo "<p>🚫 No other posts</p>";
                }
                ?>
            </span>
        </div>
    </div>
    <?php include_once ROOT_DIR . '/public/includes/footer.php' ?>
</body>

</html>