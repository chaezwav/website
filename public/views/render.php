<?php
$clientId = $_ENV['SPOTIFY_ID'];
$clientSecret = $_ENV['SPOTIFY_SECRET'];
$redirectUri = 'http://localhost:80/callback';

$code = $_GET['code'] ?? null;
$state = $_GET['state'] ?? null;

$authOptions = [
    'url' => 'https://accounts.spotify.com/api/token',
    'form' => [
        'code' => $code,
        'redirect_uri' => $redirectUri,
        'grant_type' => 'authorization_code'
    ],
    'headers' => [
        'Content-Type' => 'application/x-www-form-urlencoded',
        'Authorization' => 'Basic ' . base64_encode($clientId . ':' . $clientSecret)
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

// Execute the request and decode the response
$response = curl_exec($ch);
curl_close($ch);
$response_data = json_decode($response, true);

session_start();

$_SESSION['token'] = $response_data['access_token'];
header('Location: /');
exit;