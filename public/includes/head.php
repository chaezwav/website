<?php

// $status = json_decode(file_get_contents(ROOT_DIR . "/private/data/api/status.json"), true);
$playing = json_decode(
	file_get_contents(ROOT_DIR . "/private/data/api/playing.json"),
	true
); ?>

<head>
	<meta name="description" content="A personal journey. @koehn@social.lol">
	<link rel="stylesheet" href="/static/css/global.css">
	<link rel="apple-touch-icon" href="/static/assets/<?php echo CHANNEL; ?>.png">
	<link rel="icon" type="image/png" href="/static/assets/<?php echo CHANNEL; ?>-favicon.png?v=<?php echo md5_file(
																									ROOT_DIR . "/static/assets/{CHANNEL}-favicon.png"
																								); ?>" />
	<meta name="fediverse:creator" content="@koehn@social.lol" />
	<meta property="og:type" content="website">
	<meta property="og:description" content="A personal journey. @koehn@social.lol">
	<meta property="og:image" content="/static/assets/banner.jpg">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#101010">
	<script defer src='https://monitor.koehn.lol/script.js' data-website-id=<?php echo TRACKING_ID; ?>>
	</script>
</head>

<body>
	<?php if (CHANNEL == "dev"): ?>
		<div class="alert">
			<p>🚨 You're viewing the development build. Expect bugs. Checkout the stable channel: <a style="color: var(--background-color) !important;"
					href="https://koehn.lol">https://koehn.lol</a></p>
		</div>
	<?php endif; ?>

	<div class="h-card">
		<div class="profile">
			<div class="body">
				<span style="color: <?php echo $playing["status"]
										? "var(--alt-color)"
										: "var(--tertiary-color)"; ?> !important;">🎧 <a style="color: <?php echo $playing["status"]
																											? "var(--alt-color)"
																											: "var(--tertiary-color)"; ?> !important;" class="webring" href="/listening"><?php echo $playing["string"]; ?>
					</a></span>
				<span>
					<a class="u-url u-uid" style="display: none;" href="/">
						<img alt="koehn.lol" class="u-photo p-logo" src="/static/assets/logo.png" width="80">
					</a>
					<a href="/" id="home">公園</a>
					<h2 class="p-name" style="display: none;">Koehn</h2>
					<a class="u-email" href="mailto:koehn@omg.lol" rel="me" style='display: none;'></a>
					<a href="https://github.com/chaezwav/" class="u-url item" rel="me">@github</a>
					<a href="https://social.lol/@koehn" class="u-url item" rel="me">@mastodon</a>
					<a href="https://open.spotify.com/user/31bgkq6mpcoha246l7rxxpmc3uta?si=5de1f780c2ea45b5"
						class="u-url item" rel="me">@spotify</a>
				</span>
			</div>
		</div>
	</div>
	<hr>
</body>