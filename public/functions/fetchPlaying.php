<?php
require dirname(__DIR__, 2) . "/private/config.php";

$key = LASTFM_API_KEY;
$ch_1 = curl_init("https://ws.audioscrobbler.com/2.0/?method=user.getrecenttracks&user=chaezwav&api_key={$key}&format=json");
$ch_2 = curl_init("https://ws.audioscrobbler.com/2.0/?method=user.getlovedtracks&user=chaezwav&api_key={$key}&format=json");
curl_setopt($ch_1, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch_2, CURLOPT_RETURNTRANSFER, true);

$mh = curl_multi_init();
curl_multi_add_handle($mh, $ch_1);
curl_multi_add_handle($mh, $ch_2);

$running = null;
do {
	curl_multi_exec($mh, $running);
} while ($running);

curl_multi_remove_handle($mh, $ch_1);
curl_multi_remove_handle($mh, $ch_2);
curl_multi_close($mh);

$recents = curl_multi_getcontent($ch_1);
$likes = curl_multi_getcontent($ch_2);

$parsed_recents = json_decode($recents, true)["recenttracks"]["track"][0];
$parsed_likes = json_decode($likes, true)["lovedtracks"]["track"];

$loved_urls = [];
foreach ($parsed_likes as $track) {
	$loved_urls[] = $track["url"];
}

$formatted_loved = implode(PHP_EOL, $loved_urls);

if ($formatted_loved !== file_get_contents(ROOT_DIR . "/public/data/api/lovedtracks.txt")) {
	file_put_contents(ROOT_DIR . "/public/data/api/lovedtracks.txt", $formatted_loved);
}

$other_songs = array_slice(json_decode($recents, true)["recenttracks"]["track"], 0, 10);

if (empty($parsed_recents["@attr"])) {
	$string = "nothing";
	$uri = "/";
	$status = "false";
} else {
	$title = $parsed_recents["name"];
	$artist = $parsed_recents["artist"]["#text"];
	$string = "$artist - $title";
	$uri = $parsed_recents['url'];
	$status = $parsed_recents["@attr"]["nowplaying"];
}

$recents = [];
$likes = [];

$parsedLikes = explode(PHP_EOL, file_get_contents(ROOT_DIR . "/public/data/api/lovedtracks.txt"));
foreach ($parsedLikes as $like) {
	$likes[$like] = $like;
}

foreach ($other_songs as $track) {
	$liked = (in_array($track["url"], $likes)) ? "true" : "false";
	$recentTrack = $track["name"];
	$recentArtis = $track["artist"]["#text"];
	$recentUrl = $track["url"];
	$recent = "{ \"title\": \"$recentTrack\", \"artist\": \"$recentArtis\", \"url\": \"$recentUrl\", \"liked\": $liked }";
	array_push($recents, $recent);
}

$final_recents = implode(", ", $recents);

$file = ROOT_DIR . "/public/data/api/playing.json";
$final = "{ \"url\": \"$uri\", \"status\": $status, \"string\": \"$string\", \"recents\": [$final_recents] }";

file_put_contents($file, $final);