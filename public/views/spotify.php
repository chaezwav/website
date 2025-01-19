<?php

$clientId = $_ENV['SPOTIFY_ID'];
$clientSecret = $_ENV['SPOTIFY_SECRET'];

$encoded_credentials = base64_encode("$clientId:$clientSecret");

$scope = 'user-read-currently-playing';
$state = uniqid();

$query_params = http_build_query([
    'response_type' => 'code',
    'client_id' => $clientId,
    'scope' => $scope,
    'redirect_uri' => 'http://localhost:80/callback',
    'state' => $state
]);

header('Location: https://accounts.spotify.com/authorize?' . $query_params);
die();
