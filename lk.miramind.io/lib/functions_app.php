<?php 


	function api_payments_getRates($data = [], $fiat = true) {
		static $rates;

		if(!$rates) {


			if($fiat) {
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

			$rates['MIRA'] = $rates['usd'] / 100;
		}

		return [
			'success' => true,
			'rates' => $rates
		];
	}
	
	
	




?>