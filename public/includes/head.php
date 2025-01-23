<?php

$status = json_decode(file_get_contents(ROOT_DIR . "/public/data/api/status.json"), true);
$playing = json_decode(file_get_contents(ROOT_DIR . "/public/data/api/playing.json"), true);
?>

<head>
	<title>Koehn's Website</title>
	<meta name="description" content="A personal journey.">
	<link rel="stylesheet" href="/static/css/global.css">
	<link rel="apple-touch-icon" href="/static/favicon.svgg">
	<link rel="shortcut icon" href="/static/favicon.svg?v=<?php echo md5_file(ROOT_DIR . '/static/favicon.svg') ?>" />
	<meta name="fediverse:creator" content="@koehn@social.lol" />
	<meta property="og:type" content="website">
	<meta property="og:title" content="Koehn Humphries">
	<meta property="og:description" content="A personal journey.">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<div class="h-card">
		<div class="profile">
			<div class="body">
				<span><a class="webring"
						style="color: <?php echo $playing['status'] ? 'var(--spotify-color)' : 'var(--tertiary-color)' ?> !important;"
						href=<?php echo $playing['url'] ?>>♪ <?php echo $playing['string'] ?>
					</a></span>
				<span>
					<a class="u-url u-uid" style="display: none;" href="/">
						<img alt="koehn.lol" class="u-photo p-logo" src="/static/favicon.svg" width="80">
					</a>
					<a href="/">૮ >⸝⸝⸝< ა</a>
							<h2 class="p-name" style="display: none;">Koehn</h2>
							<a class="u-email" href="mailto:koehn@omg.lol" rel="me" style='display: none;'></a>
							<a href="https://git.sr.ht/~chaezwav/" class="u-url item" rel="me">@sr.ht</a>
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