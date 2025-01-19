<?php // Replace with the actual access token

// Set up the request headers
session_start();
$token = $_SESSION['token'];

$headers = [
    "Authorization: Bearer $token",
];

// Initialize cURL
$ch = curl_init("https://api.spotify.com/v1/me/player/currently-playing");
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the request and decode the response
$response = curl_exec($ch);
curl_close($ch);

$response_data = json_decode($response, true);
?>


<head>
	<title>Hi</title>
	<link rel="stylesheet" href="/static/css/global.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
	<link rel="icon" type="image/x-icon" href="/static/favicon.svg">
</head>

<body>
<div class="profile">
	<a class="image" href="/">
		<img alt="koehn.lol" src="/static/icon.svg" width="80">
	</a>
	<div class="body">
		<h2>koehn</h2>
		<p>Hi again</p>
	</div>
</div>
<hr>
<a style="color: #79e09e !important;" href=<?php echo $response_data['item']['uri'] ?>>♪ <?php echo $response_data['item']['artists'][0]['name'] ?> - <?php echo $response_data['item']['name'] ?></a>
</body>