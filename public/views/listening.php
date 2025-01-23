<?php
$playing = json_decode(file_get_contents(ROOT_DIR . "/public/data/api/playing.json"), true);
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once ROOT_DIR . '/public/includes/head.php' ?>

<head>
    <meta property="og:title" content="Koehn @ Listening">
    <meta property="og:url" content="https://koehn.lol/listening">
    <title>Koehn @ Listening</title>
</head>
<div class="body">
    <h2>@ What am I listening to as of late?</h2>
    <?php
    $most_recent = $playing["recents"][0];

    $recent_liked = $most_recent["liked"] ? " ✦" : "";

    echo "<span style='color: var(--primary-color) !important;'>♪$recent_liked</span> <a href='$most_recent[url]'>$most_recent[artist] - $most_recent[title]</a></br><hr>";
    ;

    foreach (array_slice($playing["recents"], 1, 10) as $track) {
        $title = $track["title"];
        $artist = $track["artist"];
        $url = $track["url"];
        $liked = $track["liked"] ? " ✦" : "";
        echo "<span>♪$liked</span> <a href='$url' style='color: var(--spotify-color) !important'>$artist - $title</a></br>";
    }
    ?>
    <br>
    <a class='linkback' href='https://www.last.fm/user/chaezwav/library'>→ View the rest...</a>
    <p class='linkback'>✦ = loved track</p>
</div>
<?php include_once ROOT_DIR . '/public/includes/footer.php' ?>

</html>