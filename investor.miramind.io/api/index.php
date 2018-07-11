<?
	/*! lk_api v0.0.1 | (c) 2018 stupidlovejoy@mail.ru | License: MIT */

	require_once('$libs.php');
	require_once('$cons.php');

	if(preg_match('~/api/([a-z]+)\.([a-z]+)/?$~i', parse_url($_SERVER['REQUEST_URI'])['path'], $method) && file_exists($method[1].'.php')) {
		if((preg_match('/^[a-z0-9]{32}$/i', $csrf = $_COOKIE['csrf']) && $_SERVER['HTTP_X_CSRF_TOKEN'] == hash('sha256', $csrf.':'.SECRET)) || preg_match('/callback/i', $method[2])) {
			require_once($method[1].'.php');

			if(function_exists($fn = 'api_'.$method[1].'_'.$method[2])) {
				result($fn($_REQUEST));
			}
			else result('Method not found');
		}
		else result('Invalid CSRF token. Please refresh page');
	}
	else result('Method not found');