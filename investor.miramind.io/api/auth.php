<?
	/*! lk_api/auth v0.0.1 | (c) 2018 stupidlovejoy@mail.ru | License: MIT */

	require_once('$cons.php');
	require_once('$libs.php');
	require_once('$lk.php');

	// Авторизоваться
	function auth_login($user_id) {
		if($session = lk_session()) {
			db("UPDATE ilk_sessions SET `del` = ? WHERE `id` = ?", [time(), $session['id']]);
		}

		$req = request();

		db("INSERT INTO ilk_sessions SET `time_add` = ?, `user_id` = ?, `sid` = ?, `agent` = ?, `ip` = ?", [time(), $user_id, $sid = lk_hash(), $req['user_agent'], $req['ip']]);
		setcookie('lk_sid', $sid, time() + 86400 * 30, '/', '.'.$req['host'], false, true);

		return $sid;
	}

	// Вход
	function api_auth_login($data) {
		if(filter_var($email = $data['email'], FILTER_VALIDATE_EMAIL) === false) return 'Invalid email address';
		if(!($pass = trim($data['pass']))) return 'Invalid password';
		if(RECAPTCHA_SECRET && (!($captcha = json_decode(@file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.RECAPTCHA_SECRET.'&response='.urlencode($data['captcha'])))) || !$captcha->success)) return 'Invalid captcha';

		if(($user = db("SELECT id,email_confirmed,pass FROM ilk_users WHERE `email` = ?", [$email])->fetch(PDO::FETCH_ASSOC)) && password_verify($pass, $user['pass'])) {
			if(!$user['email_confirmed']) return 'Email address not verified. <a href="javascript:App.api(\'auth.sendConfirmMail\', {email: \''.str_replace(['"', "'"], ['', ''], $email).'\'}, function(err, res) { if(err) return err; App.success(App.lang(\'Email sent\')) })">Send a re-verification letter</a>';

			auth_login($user['id']);

			return ['success' => true];
		}

		return 'Invalid email address and/or password';
	}

	// Вход по подписи
	function api_auth_callback($data) {
		if(hash('sha256', $data['id'].':'.$data['time'].':'.SECRET) == $data['sign']) {
			if(time() < $data['time'] + 86400) {
				if($user = db("SELECT * FROM ilk_users WHERE `id` = ?", [$data['id']])->fetch(PDO::FETCH_ASSOC)) {
					db("UPDATE ilk_users SET `email_confirmed` = 1 WHERE `id` = ?", [$user['id']]);

					if($data['restore']) {
						db("UPDATE ilk_users SET `pass` = '' WHERE `id` = ?", [$user['id']]);
					}
					
					auth_login($user['id']);

					if($r = $data['redirect']) {
						header('Location: '.(parse_url($r)['host'] == request()['host'] ? $r : '/')) or die;
					}
					else return ['success' => true];
				}
				else return 'User not found';
			}
			else return 'Signature time out';
		}
		else return 'Invalid signature';
	}

	// Регистрация
	function api_auth_register($data) {
		if(filter_var($email = $data['email'], FILTER_VALIDATE_EMAIL) === false) return 'Invalid email address';
		if($data['name'] && mb_strlen($name = $data['name'], 'UTF-8') < 2) return 'Invalid name';
		if($data['lastname'] && mb_strlen($lastname = $data['lastname'], 'UTF-8') < 3) return 'Invalid lastname';
		if(($user = db("SELECT id,email_confirmed FROM ilk_users WHERE `email` = ?", [$email])->fetch(PDO::FETCH_ASSOC))) return 'Email address already exists. Use password restore'; //  && $user['email_confirmed']
		if(mb_strlen($pass = trim($data['pass']), 'UTF-8') < 8) return 'Invalid password. Minimum 8 chars';
		if(RECAPTCHA_SECRET && (!($captcha = json_decode(@file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.RECAPTCHA_SECRET.'&response='.urlencode($data['captcha'])))) || !$captcha->success)) return 'Invalid captcha';
		if($data['referral'] && ($referral = explode(':', $data['referral'])) && substr(md5($referral[0]), 0, 4) == $referral[1]) $referral_id = $referral[0];

		$config = config();
		$lang = preg_match('/^[a-z]{2}$/', $_COOKIE['lang']) ? $_COOKIE['lang'] : ($config['langs']['default'] ?: 'en');

		if($user['id']) {
			db("UPDATE ilk_users SET `lang` = ?, `name` = ?, `lastname` = ?, `pass` = ?, `referral_id` = ? WHERE `id` = ?", [$lang, $name, $lastname, password_hash($pass, PASSWORD_DEFAULT), $user['id'], $referral_id]);
		}
		else db("INSERT INTO ilk_users SET `time_add` = ?, `email` = ?, `lang` = ?, `name` = ?, `lastname` = ?, `pass` = ?, `referral_id` = ?", [time(), $email, $lang, $name, $lastname, password_hash($pass, PASSWORD_DEFAULT), $referral_id]);

		auth_login($id = $user['id'] ?: db()->lastInsertId()); // No email confirmed

		lk_mail(
			$email,
			'Registration',
			"To complete the registration, click on the link:\n".BASE_URL.'api/auth.callback/?id='.$id.'&time='.($time = time()).'&sign='.hash('sha256', $id.':'.$time.':'.SECRET).'&redirect='.BASE_URL
		);

		return ['success' => true];
	}

	// Отправить письмо подтвеждения регистрации
	function api_auth_sendConfirmMail($data) {
		if(!($user = db("SELECT id,email FROM ilk_users WHERE `email` = ?", [$data['email']])->fetch(PDO::FETCH_ASSOC))) return 'Invalid email address';

		lk_mail(
			$user['email'],
			'Registration',
			"To complete the registration, click on the link:\n".BASE_URL.'api/auth.callback/?id='.$user['id'].'&time='.($time = time()).'&sign='.hash('sha256', $user['id'].':'.$time.':'.SECRET).'&redirect='.BASE_URL
		);

		return ['success' => true];
	}

	// Выход
	function api_auth_logout($data) {
		if($session = lk_session()) {
			db("UPDATE ilk_sessions SET `del` = ? WHERE `id` = ?", [time(), $session['id']]);
			setcookie('lk_sid', null, time(), '/', '.'.request()['host'], false, true);

			return ['success' => true];
		}
		else return 'Not authorized';
	}

	// Восстановить пароль
	function api_auth_restore($data) {
		if(RECAPTCHA_SECRET && (!($captcha = json_decode(@file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.RECAPTCHA_SECRET.'&response='.urlencode($data['captcha'])))) || !$captcha->success)) return 'Invalid captcha';
			
		if(filter_var($email = $data['email'], FILTER_VALIDATE_EMAIL) !== false && ($user = db("SELECT id,email FROM ilk_users WHERE `email` = ?", [$email])->fetch(PDO::FETCH_ASSOC))) {
			$config = config();

			lk_mail(
				$user['email'],
				'Password recovery',
				"To recover your password, click on the link:\n".BASE_URL.'api/auth.callback/?id='.$user['id'].'&time='.($time = time()).'&sign='.hash('sha256', $user['id'].':'.$time.':'.SECRET).'&restore=1&redirect='.BASE_URL.'#profile'
			);

			return ['success' => true];
		}

		return 'Invalid email address';
	}