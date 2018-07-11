<?
	/*! lk_api/$eth v0.0.1.min | (c) 2018 stupidlovejoy@mail.ru | License: MIT */
	
	require_once('$cons.php');

	// Преобразовать данные в HEX
	function eth_toHex($val) {
        return is_array($val) ? array_map('eth_toHex', $val) : (!ctype_xdigit($val) ? bin2hex($val) : (ctype_digit($val) ? dechex($val) : $val));
	}

	// Убрать\добавить префикс HEX-строки
	function eth_hexPrefix($hex, $add = true) {
		return substr($hex, 0, 2) === '0x' ? ($add ? $hex : substr($hex, 2)) : ($add ? '0x'.$hex : $hex);
	}

	// Собрать данные в сроку для data
	function eth_data($data = []) {
        return eth_hexPrefix(implode('', array_map(function($v) {
        	$s = (is_array($v) ? (int)$v[1] : 64) ?: 64;
        	$v = eth_hexPrefix(is_array($v) ? $v[0] : $v, false);
        	return str_pad(eth_toHex($v), $s, '0', STR_PAD_LEFT);
        }, $data)));
	}

	// Запрос к RPC
	function eth_rpc($method, $params = []) {
		static $query_id = 0;

		return json_decode(file_get_contents(ETH_NETWORK, false, stream_context_create(['http' => ['method' => 'POST', 'headers' => 'Content-Type: application/json', 'content' => json_encode(['jsonrpc' => '2.0', 'id' => $query_id++, 'method' => $method, 'params' => (array)$params])]])), true);
	}

	// Запрос к сети без транзакции
	function eth_call($to, $data = '') {
        return eth_rpc('eth_call', [['to' => $to, 'data' => $data], 'latest']);
	}