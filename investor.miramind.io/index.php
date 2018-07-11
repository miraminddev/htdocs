<?
	require_once(__DIR__.'/api/$libs.php');

	$config = config();
	$csrf = csrf();
?>
<!DOCTYPE html>
<html lang="en-EN" data-root-version="1.8.3">
	<head>
		<meta charset="UTF-8">
		<title><?= $config['contact']['title'] ?></title>
		<link rel="stylesheet" href="/assets/common.css?<?= @filemtime(__DIR__.'/assets/common.css') ?>">
		<link rel="stylesheet" href="/assets/template.css?<?= @filemtime(__DIR__.'/assets/template.css') ?>">
		<? if(preg_match('/\.(jpg|png|jpeg|ico|gif)$/', $config['contact']['logo_box'], $m)) : ?>
			<link rel="icon" type="image/<?= $m[1] ?>" sizes="90x90" href="<?= $config['contact']['logo_box'] ?>">
		<? else : ?>
			<link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon.png">
		<? endif; ?>
		<meta name="author" content="@stupidlovejoy"/>
		<meta name="copyright" content="https://smartcontract.ru"/>
	</head>
	<body>
		<? if($config['country_access']['on'] && $_SERVER['GEOIP_COUNTRY_CODE'] && in_array($_SERVER['GEOIP_COUNTRY_CODE'], preg_split('/[^a-z]+/i', strtoupper($config['country_access']['codes'])))) : ?>
			<div class="b-app__no-access"><?= $config['country_access']['message'] ?></div>
		<? else : ?>
			<div class="b-app" id="App">
				<div class="b-app__loading" v-if="!page_loaded"></div>
				<component v-if="page_loaded" :is="currentView"></component>
				<div class="b-notices"></div>
			</div>
			<?= $config['contact']['counters']; ?>
			<script>
				window.CONST = {
					DEBUG: <?= DEBUG ? 1 : 0 ?>,
					VERSION: <?= ($v = (DEBUG ? time() : ((int)@filemtime(__DIR__.'/assets/common.js') ?: time()))); ?>,
					LANG: '<?= preg_match('/^[a-z]{2}$/', $_COOKIE['lang']) ? $_COOKIE['lang'] : ($config['langs']['default'] ?: 'en') ?>',
					CSRF: '<?= $csrf; ?>',
					RECAPTCHA_KEY: '<?= RECAPTCHA_KEY; ?>',
				};
			</script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/require.js/2.3.5/require.min.js" data-cfasync="false" data-main="/assets/common.js?<?= $v ?>"></script>
		<? endif; ?>
	</body>
</html>