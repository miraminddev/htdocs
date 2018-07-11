<?
	/*! lk_api/$lk v0.0.1 | (c) 2018 stupidlovejoy@mail.ru | License: MIT */

	require_once('$libs.php');

	// Сгенерировать/проверить хешь
	function lk_hash($hash = null) {
		if(func_num_args()) {
			return preg_match('/^[a-z0-9]{8}\-[a-z0-9]{4}\-[a-z0-9]{4}\-[a-z0-9]{4}\-[a-z0-9]{12}$/i', $hash);
		}
		return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
	}

	// Сессия
	function lk_session() {
		static $session = null;

		if($session == null) {
			$session = lk_hash($_COOKIE['lk_sid']) ? db("SELECT * FROM ilk_sessions WHERE `del` = 0 AND `sid` = ?", [$_COOKIE['lk_sid']])->fetch(PDO::FETCH_ASSOC) : [];
			$req = request();

			if($session && ($session['agent'] != $req['user_agent'] || $session['ip'] != $req['ip'])) {
				db("UPDATE ilk_sessions SET `del` = ? WHERE `id` = ?", [time(), $session['id']]);
				db("INSERT INTO ilk_sessions SET `time_add` = ?, `user_id` = ?, `sid` = ?, `agent` = ?, `ip` = ?", [time(), $session['user_id'], $sid = lk_hash(), $req['user_agent'], $req['ip']]);

				$session = db("SELECT * FROM ilk_sessions WHERE `id` = ?", [db()->lastInsertId()])->fetch(PDO::FETCH_ASSOC);

				setcookie('lk_sid', $sid, time() + 86400 * 30, '/', '.'.$req['host'], false, true);
			}
		}

		return $session;
	}

	// Пользователь
	function lk_user() {
		static $user = null;
		return $user != null ? $user : ($user = ($s = lk_session()) ? db("SELECT * FROM ilk_users WHERE `id` = ?", [$s['user_id']])->fetch(PDO::FETCH_ASSOC) : []);
	}

	// Отправить письмо
	function lk_mail($to, $subject, $text, $params = []) {
		mail($to, $subject, $text, implode("\r\n", [
			'MIME-Version: 1.0',
	        'Content-type: text/'.($params['html'] ? 'html' : 'plain').'; charset=utf-8',
			'From: <'.($params['from'] ?: config()['notices']['from']).'>',
			'X-Mailer: PHP/'.phpversion()
		]));
	}