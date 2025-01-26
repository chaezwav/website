<!DOCTYPE html>
<html lang="en">
<?php include_once ROOT_DIR . '/public/includes/head.php'; ?>
<?php
$mentions = file_get_contents(ROOT_DIR . "/private/data/api/mentions.json");
$parsed = json_decode($mentions, true);

$likes = array_values(array_filter($parsed, function ($mention) {
    return $mention == "likes";
}, ARRAY_FILTER_USE_KEY))[0]["https://koehn.lol/post/{$_SESSION['POST']['slug']}"];

if (empty($likes)) {
    $likes = [];
}

$reposts = array_values(array_filter($parsed, function ($mention) {
    return $mention == "reposts";
}, ARRAY_FILTER_USE_KEY))[0]["https://koehn.lol/post/{$_SESSION['POST']['slug']}"];

if (empty($reposts)) {
    $reposts = [];
}

$replies = array_values(array_filter($parsed, function ($mention) {
    return $mention == "replies";
}, ARRAY_FILTER_USE_KEY))[0]["https://koehn.lol/post/{$_SESSION['POST']['slug']}"];

if (empty($replies)) {
    $replies = [];
}
?>

<head>
    <meta property="og:title" content="Koehn @ <?php echo $_SESSION['POST']['title']; ?>">
    <meta property="og:url" content="https://koehn.lol/post/<?php echo $_SESSION['POST']['slug']; ?>">
    <title>Koehn @ <?php echo $_SESSION['POST']['title']; ?></title>
</head>

<body>
    <a href="/blog" class="linkback"><i class="fa-solid fa-left-long"></i> Go back</a>
    <a style="text-decoration: none !important; color: var(--tertiary-color) !important; cursor: text;"><?php
    $string = $_SESSION['POST']['status'];

    switch ($string) {
        case 'unlisted':
            echo "<i class='fa-solid fa-eye-low-vision'></i> $string";
            break;
        case 'draft':
            echo "<i class='fa-solid fa-file-pen'></i> $string";
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
                        <span>
                            <h2><?php echo $_SESSION['POST']['title']; ?><a style="text-decoration: none !important;"
                                    href=<?php echo 'https://koehn.lol/post/' . $_SESSION['POST']['slug'] . '/raw' ?>>˚</a>
                            </h2>
                        </span>
                        <span>
                            <p class="webring">| <?php echo $_SESSION['POST']['description']; ?></p>
                        </span>
                    </div>
                </div>

                <div class="e-content">
                    <?php echo $parser->parse($_SESSION['POST']['content']) ?>
                </div>
            </article>
            <br>
            <span style='display: flex; gap: 1rem;'>
                <a class="pill highlighted"><i class='fa-solid fa-heart'></i>
                    <?php echo count(array_values($likes)) ?></a>
                <a class='pill highlighted'><i class='fa-solid fa-repeat'></i>
                    <?php echo count(array_values($reposts)) ?></a>
                <a class='pill' href="/feed.xml"><i class='fa-solid fa-feed'></i></a>
            </span>
            <?php

            if (count($replies) > 0) {
                echo "<div class='mentions-section'>";
                foreach ($replies[0] as $reply) {
                    echo "<div class='profile mention'>";
                    echo "<div class='body'>";
                    echo "<span style='display: flex; gap: 1rem;'><img width=30 height=30 src='{$reply['author']['photo']}'/><h3>{$reply['author']['name']}</h3></span>";
                    echo "<span><p>{$reply['content']['text']}</p></span>";
                    echo "</div>";
                    echo "</div>";
                }
                echo "</div>";
            }
            ?>
        </div>


        <div class="sidebar">
            <h2>Metadata</h2>

            <span class="metadata">
                <p><i class="fa-regular fa-at"></i> <a rel="author" class="p-author h-card"
                        href="https://social.lol/@koehn">koehn</a>
                    <image class="u-photo" src="/static/assets/logo.png" style="display: none;" />
                </p>
                <p><i class="fa-regular fa-clock"></i> <time class="dt-published"><?php $date = new DateTimeImmutable($_SESSION['POST']["pub_at"]);
                echo $date->format('Y-m-d') ?></time></p>
                <p><i class="fa-solid fa-tag"></i> <span class="tags"><?php
                foreach ($_SESSION['POST']['tags'] as $tag) {
                    echo "<a class='p-category' href='/tag/$tag'>$tag</a>";
                }
                ?></span>
                </p>
                <p><i class="fa-solid fa-paperclip"></i> <?php
                echo "<a class='u-url' href='https://koehn.lol/post/{$_SESSION['POST']['slug']}'>permalink</a>";
                ?></p>
                <p><i class="fa-solid fa-hashtag"></i>
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
                        echo "<p><i class='fa-regular fa-file-lines'></i> <a href='/post/{$slug}'>$post[title]</a></p>";
                    }
                } else {
                    echo "<p><i class='fa-regular fa-ban'></i> No other posts</p>";
                }
                ?>
            </span>
        </div>
    </div>
    <?php include_once ROOT_DIR . '/public/includes/footer.php' ?>
</body>

</html>