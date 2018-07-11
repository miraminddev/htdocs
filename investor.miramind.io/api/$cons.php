<?
	/*! lk_api/$cons v0.0.1 | (c) 2018 stupidlovejoy@mail.ru | License: MIT */

	define('DEBUG', false);
	define('LOCAL', preg_match('/\.new/', $_SERVER['SERVER_NAME']) ? true : false);

	define('BASE_URL', $_SERVER['HTTP_X_FORWARDED_PROTO'].'://'.$_SERVER['SERVER_NAME'].'/');
	define('SECRET', 'f958a8579fde4c268b24be22f0328176');

	define('MYSQL_HOST', '127.0.0.1');
	define('MYSQL_NAME', 'dbinvestor');
	define('MYSQL_USER', 'userinvestor');
	define('MYSQL_PASS', '+F@b{6}]J3RNjlt');

	define('ETH_NETWORK', DEBUG ? 'https://rinkeby.infura.io:443/metamask' : 'https://mainnet.infura.io:443/metamask');
	define('ETH_NETWORK_ID', DEBUG ? 4 : 1);

	define('PAYBEAR_API', DEBUG ? 'https://develop.smartcontract.ru/paybear/create/?currency=%s&callback=%s&token=%s' : 'https://api.paybear.io/v2/%s/payment/%s?token=%s');
	define('PAYBEAR_PUBLIC', 'pubd80e42ce803f591ff97776b30c69dbb9');
	define('PAYBEAR_PRIVATE', 'secfbbbdc9c5f8b01adb2459acd28be3375');

	define('RECAPTCHA_KEY', '');
	define('RECAPTCHA_SECRET', '');