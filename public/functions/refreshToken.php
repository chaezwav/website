<?php

require dirname(__FILE__, 3) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__, 3));
$dotenv->load();

$refreshToken = file_get_contents(dirname(__FILE__, 3) . '/refresh_token');

$authOptions = [
    'url' => 'https://accounts.spotify.com/api/token',
    'form' => [
        'grant_type' => 'refresh_token',
        'refresh_token' => $refreshToken,
        'client_id' => $_ENV['SPOTIFY_ID'],
    ],
    'headers' => [
        'Content-Type' => 'application/x-www-form-urlencoded',
        'Authorization' => 'Basic ' . base64_encode($_ENV['SPOTIFY_ID']. ':' . $_ENV['SPOTIFY_SECRET'])
    ]
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $authOptions['url']);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($authOptions['form']));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: ' . $authOptions['headers']['Content-Type'],
    'Authorization: ' . $authOptions['headers']['Authorization']
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute cURL request
$response = curl_exec($ch);

// Close cURL session
curl_close($ch);

// Decode JSON response
$response_data = json_decode($response, true);
file_put_contents(dirname(__FILE__, 3) . '/spotify_key', $response_data['access_token']);

if (!empty($response_data['refresh_token'])) {
    file_put_contents(dirname(__FILE__, 3) . '/refresh_token', $response_data['refresh_token']);
}

header('Location: /');

echo 'refreshed token';