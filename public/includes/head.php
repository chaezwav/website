<?php

$status = json_decode(file_get_contents(ROOT_DIR . "/private/data/api/status.json"), true);
$playing = json_decode(file_get_contents(ROOT_DIR . "/private/data/api/playing.json"), true);
?>

<head>
	<meta name="description" content="A personal journey. @koehn@social.lol">
	<link rel="stylesheet" href="/static/css/global.css">
	<link rel="apple-touch-icon" href="/static/assets/favicon.png">
	<link rel="icon" type="image/png"
		href="/static/assets/favicon.png?v=<?php echo md5_file(ROOT_DIR . '/static/assets/favicon.png') ?>" />
	<meta name="fediverse:creator" content="@koehn@social.lol" />
	<meta property="og:type" content="website">
	<meta property="og:description" content="A personal journey. @koehn@social.lol">
	<meta property="og:image" content="/static/assets/banner.jpg">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#101010">
	<script defer src='https://monitor.koehn.lol/script.js'
		data-website-id='9d5f0600-18f9-4478-80eb-fb9f840e0c0d'></script>
	<script src="https://kit.fontawesome.com/4c53100ac3.js" crossorigin="anonymous"></script>
	<link rel="webmention" href="https://webmention.io/koehn.lol/webmention" />
	<link rel="pingback" href="https://webmention.io/mxb.dev/xmlrpc">
</head>

<body>
	<div class="h-card">
		<div class="profile">
			<div class="body">
				<span
					style="color: <?php echo $playing['status'] ? 'var(--spotify-color)' : 'var(--tertiary-color)' ?> !important;"><i
						class="fa-solid fa-headphones"></i> <a
						style="color: <?php echo $playing['status'] ? 'var(--spotify-color)' : 'var(--tertiary-color)' ?> !important;"
						class="webring" href="/listening"><?php echo $playing['string'] ?>
					</a></span>
				<span>
					<a class="u-url u-uid" style="display: none;" href="/">
						<img alt="koehn.lol" class="u-photo p-logo" src="/static/assets/logo.png" width="80">
					</a>
					<a href="/">公園</a>
					<h2 class="p-name" style="display: none;">Koehn</h2>
					<a class="u-email" href="mailto:koehn@omg.lol" rel="me" style='display: none;'></a>
					<a href="https://github.com/chaezwav/" class="u-url item" rel="me">@github</a>
					<a href="https://social.lol/@koehn" class="u-url item" rel="me">@mastodon</a>
					<a href="https://open.spotify.com/user/31bgkq6mpcoha246l7rxxpmc3uta?si=5de1f780c2ea45b5"
						class="u-url item" rel="me">@spotify</a>
				</span>
				<span>
					<a class="webring" href=<?php echo $status["url"] ?>><?php echo $status["string"] ?></a>
				</span>
			</div>
		</div>
	</div>
	<hr>
</body>