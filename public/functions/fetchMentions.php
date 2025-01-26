<?php
require dirname(__DIR__, 2) . "/private/config.php";

$token = WEBMENTION_TOKEN;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://webmention.io/api/mentions.jf2?domain=koehn.lol&token=$token");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$output = curl_exec($ch);
curl_close($ch);

$mentions = json_decode($output, true)["children"];

$likes = [];
$replies = [];
$reposts = [];

foreach ($mentions as $mention) {
    switch ($mention["wm-property"]) {
        case "like-of":
            $likes[$mention['wm-target']][] = $mention;
            break;
        case "in-reply-to":
            $replies[$mention['wm-target']][] = $mention;
            break;
        case "repost-of":
            $reposts[$mention['wm-target']][] = $mention;
            break;
        default:
            break;
    }
}

$formatted_likes = [];
foreach ($likes as $url => $mentions) {
    $formatted_likes[$url][] = array_values($mentions);
}

$formatted_reposts = [];
foreach ($reposts as $url => $mentions) {
    $formatted_reposts[$url][] = array_values($mentions);
}

$formatted_replies = [];
foreach ($replies as $url => $mentions) {
    $formatted_replies[$url][] = array_values($mentions);
}

$json = json_encode([
    "likes" => $formatted_likes,
    "reposts" => $formatted_reposts,
    "replies" => $formatted_replies
]);
$file = ROOT_DIR . "/private/data/api/mentions.json";

file_put_contents($file, $json);