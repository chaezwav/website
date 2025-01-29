<?php
$playing = json_decode(
    file_get_contents(ROOT_DIR . "/private/data/api/playing.json"),
    true
); ?>

<!DOCTYPE html>
<html lang="en">
<?php include_once ROOT_DIR . "/public/includes/head.php"; ?>

<head>
    <meta property="og:title" content="Koehn @ Listening">
    <meta property="og:url" content="https://koehn.lol/listening">
    <title>Koehn @ Listening</title>
</head>
<div class="body">
    <h2><i class="fa-solid fa-headphones"></i> What am I listening to as of late?</h2>
    <?php
    $most_recent = $playing["recents"][0];

    $recent_liked = $most_recent["liked"]
        ? ' <i class="fa-solid fa-heart"></i>'
        : " ";

    echo "<span class='pill highlighted'>$recent_liked <a href='$most_recent[url]'>$most_recent[artist] - $most_recent[title]</a></span></br><hr>";
    foreach (array_slice($playing["recents"], 1, 10) as $track) {
        $title = $track["title"];
        $artist = $track["artist"];
        $url = $track["url"];
        $liked = $track["liked"] ? ' <i class="fa-solid fa-heart"></i>' : " ";
        echo "<span style='color: var(--alt-color) !important'>$liked <a style='color: var(--alt-color) !important' href='$url'>$artist - $title</a></span></br>";
    }
    ?>
    <br>
    <a class='linkback' href='https://www.last.fm/user/chaezwav/library'><i class="fa-solid fa-right-long"></i> View the
        rest...</a>
</div>
<?php include_once ROOT_DIR . "/public/includes/footer.php"; ?>

</html>
