<?php
echo "<head><link rel='stylesheet' href='/static/css/global.css'><script src='https://kit.fontawesome.com/4c53100ac3.js' crossorigin='anonymous'></script></head>";

$mentions = file_get_contents(ROOT_DIR . "/private/data/api/mentions.json");
$parsed = json_decode($mentions, true);

$likes = array_values(array_filter($parsed, function ($mention) {
    return $mention == "likes";
}, ARRAY_FILTER_USE_KEY))[0]["https://koehn.lol/"];

$reposts = array_values(array_filter($parsed, function ($mention) {
    return $mention == "reposts";
}, ARRAY_FILTER_USE_KEY))[0]["https://koehn.lol/"];

var_dump($likes);