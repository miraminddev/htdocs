<?
	/*! lk_api/payments v0.0.1 | (c) 2018 stupidlovejoy@mail.ru | License: MIT */

	require_once('$cons.php');
	require_once('$libs.php');
	require_once('$lk.php');

	// Получить список платежей
	function api_payments_get($data) {
		if($user = lk_user()) {
			return [
				'success' => true,
				'payments' => db("SELECT id,time_add,currency,amount,course_add,tokens,IF(time_pay > 0, IF(time_accruals > 0, 'accrued', 'pay'), 'wait') status FROM ilk_payments WHERE `user_id` = ? ORDER BY time_add DESC", [$user['id']])->fetchAll(PDO::FETCH_ASSOC)
			];
		}
		else return 'Not authorized';
	}

	// Получить цены валют
	function api_payments_getRates($data = [], $fiat = true) {
		static $rates;

		if(!$rates) {
			$config = config();

			if($fiat || in_array($config['prices']['price_currency'], ['usd', 'rub', 'eur'])) {
				$fiat = (array)json_decode(@file_get_contents('https://www.cbr-xml-daily.ru/daily_json.js'), true);
				$rates['usd'] = 1;
				$rates['rub'] = 1 / $fiat['Valute']['USD']['Value'];
				$rates['eur'] = $fiat['Valute']['EUR']['Value'] / $fiat['Valute']['USD']['Value'];
			}

			foreach((array)json_decode(@file_get_contents('https://api.coinmarketcap.com/v1/ticker/?limit=30'), true) as $v) {
				if(in_array($k = strtolower($v['symbol']), ['eth', 'btc', 'bch', 'btg', 'ltc', 'dash', 'etc'])) {
					$rates[$k] = (double)$v['price_usd'];
				}
			}

			$rates[strtolower($config['contract']['token_symbol'])] = $rates[$config['prices']['price_currency']] / $config['prices']['price_rate'];
		}

		return [
			'success' => true,
			'rates' => $rates
		];
	}

	// Создать платеж
	function api_payments_create($data) {
		if($user = lk_user()) {
			$config = config();

			if(!in_array($currency = $data['currency'], ['eth', 'btc', 'ltc', 'bch', 'btg', 'dash', 'etc'])) return 'Invalid currency';
			if($sale = (int)db("SELECT SUM(`tokens`) FROM ilk_payments WHERE `time_pay` > 0")->fetchColumn()) {
				foreach((array)$config['ico_steps'] as $v) {
					if($v['cap'] > 0 && $sale >= $v['cap']) return 'All tokens sold out';
				}
			}

			$invoice = (array)json_decode(@file_get_contents(sprintf(PAYBEAR_API, $currency, urlencode(BASE_URL.'api/payments.callback/?hash='.($hash = lk_hash()).'&sign='.hash('sha256', $hash.':'.SECRET)), PAYBEAR_PRIVATE)), true)['data'];

			if($invoice['address']) {
				$amount = (double)$data['amount'] ?: 0;
				$rates = api_payments_getRates([], false)['rates'];
				$bonus = ((double)$config['prices']['bonus_percent'] / 100) + 1;

				db("INSERT INTO ilk_payments SET `time_add` = ?, `user_id` = ?, `invoice` = ?, `address` = ?, `currency` = ?, `course_add` = ?, `tokens` = ?, `amount` = ?", [time(), $user['id'], $invoice['invoice'], $invoice['address'], $currency, $rates[$currency], $amount * ($rates[$currency] / $rates[strtolower($config['contract']['token_symbol'])]) * $bonus, $amount]);

				return [
					'success' => true,
					'address' => $invoice['address']
				];
			}
			else return 'Payment create error';
		}
		else return 'Not authorized';
	}

	// Колл-бэк платежа
	function api_payments_callback($data) {
		$config = config();

		if(hash('sha256', $data['hash'].':'.SECRET) == $data['sign']) {
			$input = (array)json_decode(@file_get_contents('php://input'), true);

			if($item = db("SELECT * FROM ilk_payments WHERE `invoice` = ?", [$input['invoice']])->fetch(PDO::FETCH_ASSOC)) {
				if($input['confirmations'] >= $input['maxConfirmations']) {
					$amount = $input['inTransaction']['amount'] / (10 ** $input['inTransaction']['exp']);
					$rates = api_payments_getRates([], false)['rates'];
					$bonus = ((double)$config['prices']['bonus_percent'] / 100) + 1;

					db("UPDATE ilk_payments SET `time_pay` = ?, `course_pay` = ?, `tokens` = ?, `tx` = ?, `confirms` = ?, `amount` = ? WHERE `id` = ?", [
						$item['time_pay'] ?: time(),
						$item['time_pay'] && $item['course_pay'] ? $item['course_pay'] : ($item['course_add'] && $item['time_add'] > time() - 900 ? $item['course_add'] : $rates[$item['currency']]),
						$item['time_pay'] && $item['tokens'] ? $item['tokens'] : (
							$amount * ($rates[$item['currency']] / $rates[strtolower($config['contract']['token_symbol'])]) * $bonus
						),
						$input['inTransaction']['hash'], $input['confirmations'], $amount, $item['id']
					]);
					
					if($config['refferals']['on'] && $config['refferals']['bonus'] > 0) {
						if($user = db("SELECT id,referral_id FROM ilk_users WHERE `referral_id` > 0 AND `id` = ?", [$item['user_id']])->fetch(PDO::FETCH_ASSOC)) {
							$payment = db("SELECT * FROM ilk_payments WHERE `id` = ?", [$item['id']])->fetch(PDO::FETCH_ASSOC);
							unset($payment['id']);
							$payment['user_id'] = $user['referral_id'];
							$payment['invoice'] = $payment['invoice'].'_ref';
							$payment['tokens'] = $payment['tokens'] / 100 * $config['refferals']['bonus'];
							$payment['amount'] = $payment['amount'] / 100 * $config['refferals']['bonus'];

							if($old_payment = db("SELECT id FROM ilk_payments WHERE `invoice` = ?", [$payment['invoice']])->fetch(PDO::FETCH_ASSOC)) {
								db("UPDATE ilk_payments SET `".implode('` = ?, `', array_keys($payment))."` = ? WHERE `id` = ?", array_merge(array_values($payment), [$old_payment['id']]));
							}
							else db("INSERT INTO ilk_payments SET `".implode('` = ?, `', array_keys($payment))."` = ?", array_values($payment));
						}
					}

					die($item['invoice']);
				}
				else die('waiting for confirmations');
			}
			else die('invoice not found');
		}
		else die('Invalid signature');
	}

	// Админ -> Создать платеж
	function api_payments_createAdmin($data) {
		if($user = lk_user()) {
			if($user['role'] == 'admin') {
				$config = config();

				if(!preg_match('/^[a-z]{2,5}$/', $currency = $data['currency'])) return 'Invalid currency';

				if(preg_match('/^.+@.+\..+$/i', $data['user'])) {
					if(filter_var($email = $data['user'], FILTER_VALIDATE_EMAIL) === false) return 'Invalid email address';
					if($id = db("SELECT id FROM ilk_users WHERE `email` = ?", [$email])->fetchColumn()) return 'Email address already exists. User ID: '.$id;
					if(!preg_match('/^0x[a-f0-9]{40}$/i', $data['address'])) return 'Invalid wallet address';

					db("INSERT INTO ilk_users SET `time_add` = ?, `email` = ?, `wallet_address` = ?", [time(), $email, $data['address']]);

					$user_id = db()->lastInsertId();
				}
				else if(preg_match('/^\d+$/', $data['user']) && (int)$data['user']) $user_id = (int)$data['user'];
				else return 'Invalid user';

				$amount = (double)$data['amount'] ?: 0;
				$rates = api_payments_getRates()['rates'];

				db("INSERT INTO ilk_payments SET `time_add` = ?, `time_pay` = ?, `user_id` = ?, `invoice` = ?, `address` = ?, `currency` = ?, `course_add` = ?, `course_pay` = ?, `tokens` = ?, `amount` = ?", [time(), time(), $user_id, lk_hash(), 'Private sale (ID:'.$user['id'].')', $currency, $rates[$currency], $rates[$currency], $amount * ($rates[$currency] / $rates[strtolower($config['contract']['token_symbol'])]), $amount]);

				return [
					'payment' => api_payments_search(['id' => db()->lastInsertId()])['payments'][0],
					'success' => true
				];
			}
			else return 'Permission denied';
		}
		else return 'Not authorized';
	}

	// Админ -> Поиск платежей
	function api_payments_search($data) {
		if($user = lk_user()) {
			if($user['role'] == 'admin') {
				$query = "1";
				$params = [];

				if($t = (int)$data['id']) { $query .= " AND `id` = ?"; $params[] = $t; }
				if($data['date_from'] && ($t = strtotime($data['date_from']))) { $query .= " AND `time_add` >= ?"; $params[] = $t; }
				if($data['date_to'] && ($t = strtotime($data['date_to']))) { $query .= " AND `time_add` <= ?"; $params[] = $t; }
				if($t = trim($data['search'])) { $query .= " AND (`tx` LIKE ? OR `invoice` LIKE ? OR `address` LIKE ? OR `currency` LIKE ?)"; $params[] = $t = '%'.$t.'%'; $params[] = $t; $params[] = $t; $params[] = $t; }
				if($t = $data['status']) {
					$query .= $t == 'pay' ? " AND `time_pay` > 0 AND `time_accruals` = 0" : (
						$t == 'accrued' ? " AND `time_accruals` > 0" : (
							$t == 'wait' ? " AND `time_pay` = 0 AND `time_accruals` = 0" : ""
						)
					);
				}

				return [
					'payments' => db("
						SELECT
							id,time_add,time_pay,time_accruals,currency,amount,course_add,course_pay,tokens,tx,
							(SELECT CONCAT(name, ' ', lastname) FROM ilk_users WHERE id = ilk_payments.user_id) fio,
							(SELECT email FROM ilk_users WHERE id = ilk_payments.user_id) email,
							(SELECT verify FROM ilk_users WHERE id = ilk_payments.user_id) verify,
							(SELECT wallet_address FROM ilk_users WHERE id = ilk_payments.user_id) wallet_address,
							IF(time_pay > 0, IF(time_accruals > 0, 'accrued', 'pay'), 'wait') status
						FROM ilk_payments
						WHERE $query
						ORDER BY id ASC
					", $params)->fetchAll(PDO::FETCH_ASSOC),
					'success' => true
				];
			}
			else return 'Permission denied';
		}
		else return 'Not authorized';
	}

	// Админ -> Начислить токены
	function api_payments_accrueTokens($data) {
		if($user = lk_user()) {
			if($user['role'] == 'admin') {
				if($item = db("SELECT * FROM ilk_payments WHERE `id` = ?", [$data['id']])->fetch(PDO::FETCH_ASSOC)) {
					$amount = (double)$data['amount'];

					db("UPDATE ilk_payments SET `time_accruals` = ?, `course_accruals` = ?, `tokens` = ? WHERE `id` = ?", [
						time(),
						api_payments_getRates()['rates'][$item['currency']],
						$amount,
						$item['id']
					]);

					return [
						'payment' => api_payments_search(['id' => $item['id']])['payments'][0],
						'success' => true
					];
				}
				else return 'Payment not found';
			}
			else return 'Permission denied';
		}
		else return 'Not authorized';
	}

	// Админ -> Поиск по платежам с выгрузкой в CSV
	function api_payments_searchCsvCallback($data) {
		if($user = lk_user()) {
			if($user['role'] == 'admin') {
				$payments = api_payments_search($data)['payments'];

				header('Content-Type: application/csv; charset=utf-8'); 
				header('Content-Disposition: attachment; filename=payments_export.csv');

				echo '"'.implode('";"', array_keys((array)$payments[0])).'"'.PHP_EOL;
				foreach($payments as $payment) {
					echo '"'.implode('";"', array_map(function($v) { return is_string($v) ? iconv('utf-8', 'windows-1251', $v) : json_encode($v); }, $payment)).'"'.PHP_EOL;
				}

				exit;
			}
			else return 'Permission denied';
		}
		else return 'Not authorized';
	}