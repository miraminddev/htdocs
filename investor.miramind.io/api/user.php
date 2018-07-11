<?
	/*! lk_api/user v0.0.1 | (c) 2018 stupidlovejoy@mail.ru | License: MIT */

	require_once('$cons.php');
	require_once('$libs.php');
	require_once('$lk.php');
	require_once('$eth.php');

	// Получить часть данных пользователя
	function api_user_getChunk($data) {
		if($user = lk_user()) {
			$list = [
				'id', 'time_add', 'referral_id', 'role', 'email', 'email_confirmed', 'name', 'lastname', 'patronymic', 'sex', 'birthday', 'city', 'address', 'zipcode', 'doc_city', 'doc_number', 'doc_date', 'photo', 'wallet_address', 'verify', 'verify_msg',
				'doc_scans' => function($v) { return (array)json_decode($v, true); },
				'address_scans' => function($v) { return (array)json_decode($v, true); },
			];

			$fields = array_filter((array)$data['fields'], function($v) use(&$list) {
				return in_array($v, $list) || (!is_numeric($v) && isset($list[$v]));
			});

			$row = $fields ? db("SELECT `".implode("`,`", $fields)."` FROM ilk_users WHERE `id` = ?", [$user['role'] == 'admin' && ($t = (int)$data['id']) ? $t : $user['id']])->fetch(PDO::FETCH_ASSOC) : [];

			foreach($list as $k => $v) {
				if(!is_string($v) && is_callable($v) && isset($row[$k])) $row[$k] = $v($row[$k]);
			}

			return [
				'success' => true,
				'user' => $row
			];
		}
		else return 'Not authorized';
	}

	// Установить часть данных пользователя
	function api_user_setChunk($data) {
		if($user = lk_user()) {
			$filters = [
				'admin' => function() use(&$user) { return function($v, $err) use(&$user) { $err($user['role'] != 'admin', 'Permission denied'); return $v; }; },
				'length' => function($l, $m) { return function($v, $err) use(&$l, &$m) { $err(mb_strlen($v, 'UTF-8') < $l, $m); return $v; }; },
			];

			$list = [
				'referral_id' => $filters['admin'](),
				'role' => $filters['admin'](),
				'email' => $filters['admin'](),
				'email_confirmed' => $filters['admin'](),
				'name' => $filters['length'](2, 'Invalid name'),
				'lastname' => $filters['length'](2, 'Invalid lastname'),
				'patronymic' => $filters['length'](2, 'Invalid patronymic'),
				'sex' => function($v, $err) { $err(!in_array($v, ['male', 'female']), 'Invalid sex'); return $v; },
				'birthday' => function($v, $err) { $err(!strtotime($v), 'Invalid birthday'); return date('Y-m-d', strtotime($v)); },
				'city' => $filters['length'](2, 'Invalid city'),
				'address' => $filters['length'](2, 'Invalid address'),
				'zipcode' => $filters['length'](2, 'Invalid zipcode'),
				'doc_city' => $filters['length'](2, 'Invalid doc. city'),
				'doc_number' => $filters['length'](2, 'Invalid doc. number'),
				'doc_date' => function($v, $err) { $err(!strtotime($v), 'Invalid doc. date'); return date('Y-m-d', strtotime($v)); },
				'photo' => $filters['length'](2, 'Invalid photo'),
				'wallet_address' => function($v, $err) { $err(!preg_match('/^0x[a-f0-9]{40}$/i', $v), 'Invalid wallet address'); return $v; },
				'verify' => $filters['admin'](),
				'verify_msg' => $filters['admin'](),
				'doc_scans' => function($v, $err) { return json_encode((array)$v); },
				'address_scans' => function($v, $err) { return json_encode((array)$v); },
			];

			$id = $user['role'] == 'admin' && ($t = (int)$data['id']) ? $t : $user['id'];

			foreach((array)$data['fields'] as $field) {
				if(isset($list[$field])) {
					$row[$field] = $list[$field]($data['data'][$field], function($rule, $msg) use(&$err) {
						if($rule) $err = $msg;
					});
					if($err) return $err;
				}
			}

			if($row && count($row)) {
				db("UPDATE ilk_users SET `".implode('` = ?, `', array_keys($row))."` = ? WHERE `id` = ?", array_merge(array_values($row), [$id]));
			}

			return [
				'success' => true,
				'user' => api_user_getChunk(['fields' => $data['fields'], 'id' => $id])['user']
			];
		}
		else return 'Not authorized';
	}


	// Получить данные пользователя
	function api_user_get($data) {
		if($user = lk_user()) {
			return [
				'user' => [
					'id' => $user['id'],
					'email' => $user['email'],
					'name' => $user['name'],
					'lastname' => $user['lastname'],
					'role' => $user['role'],
					'pass' => $user['pass'] ? true : false,
					'wallet_address' => $user['wallet_address'],
					'verify' => $user['verify'],
					'verify_msg' => $user['verify_msg'],
					'referral_link' => BASE_URL.'?referral='.$user['id'].':'.substr(md5($user['id']), 0, 4)
				],
				'success' => true
			];
		}
		else return 'Not authorized';
	}

	// Получить Ethereum данные пользователя
	function api_user_getEth($data) {
		if($user = lk_user()) {
			$config = config();

			return [
				'user_eth' => [
					'address' => $user['wallet_address'],
					'tokens' => (double)db("SELECT SUM(tokens) FROM ilk_payments WHERE time_pay > 0 AND user_id = ?", [$user['id']])->fetchColumn(), //$user['wallet_address'] && $config['contract']['token_address'] ? hexdec(eth_call($config['contract']['token_address'], eth_data([['70a08231', 8], $user['wallet_address']]))['result']) / 1e18 : 0,
					//'balance' => $user['wallet_address'] ? hexdec(eth_rpc('eth_getBalance', [$user['wallet_address'], 'latest'])['result']) : 0,
					'contract_in_pause' => (int)eth_hexPrefix(eth_call($config['contract']['crowdsale_address'], eth_data([['5c975abb', 8]]))['result'], false) ? true : false
				],
				'success' => true
			];
		}
		else return 'Not authorized';
	}

	// Получить рефераллы
	function api_user_getReferrals($data) {
		if($user = lk_user()) {
			return [
				'users' => db("SELECT id,time_add,email,name,lastname FROM ilk_users WHERE `referral_id` = ?", [$user['id']])->fetchAll(PDO::FETCH_ASSOC),
				'success' => true
			];
		}
		else return 'Not authorized';
	}

	// Получить сессии
	function api_user_getSessions($data) {
		if($user = lk_user()) {
			return [
				'sessions' => db("SELECT id,del,time_add,agent,ip FROM ilk_sessions WHERE `user_id` = ? ORDER BY time_add DESC", [$user['id']])->fetchAll(PDO::FETCH_ASSOC),
				'success' => true
			];
		}
		else return 'Not authorized';
	}

	// Изменить пароль
	function api_user_changePass($data) {
		if($user = lk_user()) {
			if($user['pass'] && !password_verify(trim($data['pass']), $user['pass'])) return 'Invalid password';
			if(mb_strlen($pass = trim($data['new_pass']), 'UTF-8') < 8) return 'Invalid new password. Minimum 8 chars';

			db("UPDATE ilk_users SET `pass` = ? WHERE `id` = ?", [password_hash($pass, PASSWORD_DEFAULT), $user['id']]);

			return ['success' => true];
		}
		else return 'Not authorized';
	}

	// Админ -> Поиск по пользователям
	function api_user_search($data) {
		if($user = lk_user()) {
			if($user['role'] == 'admin') {
				$query = "1";
				$params = [];

				if($data['date_from'] && ($t = strtotime($data['date_from']))) { $query .= " AND `time_add` >= ?"; $params[] = $t; }
				if($data['date_to'] && ($t = strtotime($data['date_to']))) { $query .= " AND `time_add` <= ?"; $params[] = $t; }
				if($t = trim($data['search'])) { $query .= " AND (`id` = ? OR `email` LIKE ? OR CONCAT(`name`, ' ', `lastname`) LIKE ? OR `wallet_address` LIKE ?)"; $params[] = $t; $params[] = $t = '%'.$t.'%'; $params[] = $t; $params[] = $t; }
				if($t = $data['role']) { $query .= " AND `role` = ?"; $params[] = $t; }
				if($t = $data['verify']) { $query .= " AND `verify` = ?"; $params[] = $t; }

				return [
					'users' => array_map(function($v) {
						$v['doc_scans'] = (array)json_decode($v['doc_scans'], true);
						$v['address_scans'] = (array)json_decode($v['address_scans'], true);
						return $v;
					}, db("
						SELECT
							id,time_add,email,lang,name,lastname,patronymic,sex,birthday,city,address,zipcode,doc_city,doc_number,doc_date,doc_scans,address_scans,photo,role,wallet_address,verify,verify_msg,
							(SELECT SUM(`tokens`) FROM ilk_payments WHERE user_id = ilk_users.id AND time_pay > 0) tokens
						FROM ilk_users
						WHERE $query
						ORDER BY time_add DESC
					", $params)->fetchAll(PDO::FETCH_ASSOC)),
					'success' => true
				];
			}
			else return 'Permission denied';
		}
		else return 'Not authorized';
	}

	// Админ -> Поиск по пользователям с выгрузкой в CSV
	function api_user_searchCsvCallback($data) {
		if($user = lk_user()) {
			if($user['role'] == 'admin') {
				$users = api_user_search($data)['users'];

				header('Content-Type: application/csv; charset=utf-8'); 
				header('Content-Disposition: attachment; filename=users_export.csv');

				echo '"'.implode('";"', array_keys((array)$users[0])).'"'.PHP_EOL;
				foreach($users as $user) {
					echo '"'.implode('";"', array_map(function($v) { return is_string($v) ? iconv('utf-8', 'windows-1251', $v) : json_encode($v); }, $user)).'"'.PHP_EOL;
				}

				exit;
			}
			else return 'Permission denied';
		}
		else return 'Not authorized';
	}