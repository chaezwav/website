<?php
require dirname(__DIR__, 2) . "/private/config.php";

$ch = curl_init("https://api.omg.lol/address/koehn/statuses/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);

$parsed_data = json_decode($result, true)["response"]["statuses"][0];

$file = ROOT_DIR . "/private/data/api/status.json";
$string = "{ \"url\": \"$parsed_data[external_url]\", \"content\": \"$parsed_data[content]\", \"emoji\": \"$parsed_data[emoji]\" }";

if (!file_exists($file) || file_get_contents($file) !== $string) {
    file_put_contents($file, $string);
}