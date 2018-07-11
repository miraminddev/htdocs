<?
	/*! lk_api/$libs v0.0.1 | (c) 2018 stupidlovejoy@mail.ru | License: MIT */

	require_once('$cons.php');

	// Вывод результата
	function result($data) {
		header('Content-Type: application/json; charset=utf-8');
		exit(json_encode(is_string($data) ? ['error' => $data] : $data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	}

	// Получить язык
	function lang() {
		static $lang = 'ru';
		if(($t = $_COOKIE['lang']) && preg_match('/^[a-z]{2}$/', $t) && file_exists(__DIR__.'/../langs/'.$t.'.json')) {
			$lang = $t;
		}
		return $lang;
	}

	// Текущий запрос
	function request() {
		return [
			'host' => $_SERVER['SERVER_NAME'],
			'user_agent' => $_SERVER['HTTP_USER_AGENT'],
			'ip' => $_SERVER['REMOTE_ADDR']
		];
	}

	// Получить CSRF
	function csrf($update = false) {
		if($update || !preg_match('/^[a-f0-9]{32}$/i', $csrf = $_COOKIE['csrf'])) {
			setcookie('csrf', $csrf = md5(mt_rand()), time() + 86400, '/', '.'.request()['host'], false, true);
		}
		return hash('sha256', $csrf.':'.SECRET);
	}

	// Конфиг
	function config() {
		static $config;
		if(!$config) {
			$config = (array)json_decode(file_get_contents(__DIR__.'/../config.json'), true);
			if(file_exists($t = __DIR__.'/../langs/config/'.lang().'.json')) {
				$config = array_merge($config, (array)json_decode(file_get_contents($t), true));
			}
		}
		return $config;
	}

	// Запрос к базе данных
	function db($query = '', $params = [], $flags = 0, $arg = null, $args = null) {
		static $connection;

		if(!$connection) {
			try {
				$connection = new PDO('mysql:host='.MYSQL_HOST.'; dbname='.MYSQL_NAME, MYSQL_USER, MYSQL_PASS);
				$connection->query("SET NAMES 'utf8'");
			}
			catch(PDOException $e) { result('Error connecting to database'); }
		}

		if($query) {
			if(is_array($params) && count($params)) {
				$res = $connection->prepare($query);
				$res->execute(array_map(function($v) { return (string)$v; }, $params));
				return $res;
			}
			return call_user_func_array([$connection, 'query'], $args !== null ? [$query, $flags, $arg, $args] : ($arg !== null ? [$query, $flags, $arg] : [$query, $flags]));
		}
		else return $connection;
	}

	// MySQL хранилище
	function storage($key, $val = null, $time = 0) {
		if(func_num_args() >= 2) {
			db("INSERT INTO `ilk_storage` (`key`, `val`, `time`) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE `val` = VALUES(`val`), `time` = VALUES(`time`)", [$key, $val, (int)$time]);
			return $val;
		}
		else return db("SELECT `val` FROM `ilk_storage` WHERE `key` = ? AND (`time` = 0 OR `time` >= ?)", [$key, time()])->fetchColumn();
	}