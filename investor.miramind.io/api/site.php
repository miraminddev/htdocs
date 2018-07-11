<?
	/*! lk_api/site v0.0.1 | (c) 2018 stupidlovejoy@mail.ru | License: MIT */

	require_once('$libs.php');
	require_once('$lk.php');

	// Получить данные по сайту
	function api_site_get($data) {
		$config = config();

		return [
			'site' => [
				'contract' => $config['contract'],
				'contact' => $config['contact'],
				'social' => $config['social'],
				'links' => $config['links'],
				'refferals' => $config['refferals'],
				'prices' => array_merge([
					'collected_value' => (double)db("SELECT SUM(`amount` * `course_pay`) FROM ilk_payments WHERE `time_pay` > 0")->fetchColumn()
				], $config['prices']),
				'ico_steps' => $config['ico_steps'],
				'help' => $config['help'],
				'langs' => $config['langs'],
				'notices' => lk_user()['role'] == 'admin' ? $config['notices'] : [],
				'country_access' => $config['country_access'],
			],
			'success' => true
		];
	}

	// Обратная связь
	function api_site_feedback($data) {
		if(mb_strlen($theme = trim($data['theme']), 'UTF-8') < 3) return 'Invalid theme';
		if(mb_strlen($message = trim($data['message']), 'UTF-8') < 3) return 'Invalid message';

		lk_mail(
			config()['notices']['feedback'],
			'Feedback',
			"User:\n".lk_user()['email']." [".lk_user()['id']."]\n\nTheme:\n".$theme."\n\nMessage:\n".$message
		);

		return ['success' => true];
	}

	// Админ -> Установить настройки
	function api_site_setSettings($data) {
		if($user = lk_user()) {
			if($user['role'] == 'admin') {
				$config = config();

				if(!in_array($section = $data['section'], ['contact', 'contract', 'links', 'help', 'ico_steps', 'social', 'prices', 'refferals', 'notices', 'langs', 'country_access'])) return 'Invalid section';

				if(!DEBUG && $section == 'contract') return 'Editing contract data is only available in debug mode';

				if(!in_array($section, ['ico_steps', 'links', 'help'])) {
					foreach($config[$section] as $k => $v) {
						$config[$section][$k] = (string)$data['data'][$k];
					}
				}
				else $config[$section] = $data['data'];

				file_put_contents(__DIR__.'/../langs/config/'.lang().'.json', json_encode([
					'links' => $config['links'],
					'refferals' => $config['refferals'],
					'help' => $config['help'],
				], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

				unset($config['links'], $config['refferals'], $config['help']);

				file_put_contents(__DIR__.'/../config.json', json_encode($config, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

				return ['success' => true];
			}
			else return 'Permission denied';
		}
		else return 'Not authorized';
	}

	// Админ -> Загрузить файл
	function api_site_uploadFile($data) {
		if($user = lk_user()) {
			if(is_uploaded_file($source = $_FILES['file']['tmp_name'])) {
				if(preg_match('/^(.+)\.(txt|doc|docx|xls|xlsx|pdf|rtf|jpeg|jpg|png|bmp|gif|ico)$/i', $name = trim($_FILES['file']['name']), $type)) {
					if(!is_dir(($rd = __DIR__.'/../').($dir = '/docs/'.($user['role'] == 'admin' ? '' : 'users/')))) mkdir($rd.$dir, 0777, true);

					$file = preg_replace(['/[^a-z0-9\-]/', '/[\-]{2,}/'], ['', '-'], str_replace(explode('|', 'а|б|в|г|д|е|ё|ж|з|и|й|к|л|м|н|о|п|р|с|т|у|ф|х|ц|ч|ш|щ|ы|э|ю|я|.|,|_| '), explode('|', 'a|b|v|g|d|e|e|zh|z|i|i|k|l|m|n|o|p|r|s|t|u|f|h|c|ch|sh|sh|i|e|yu|ya|-|-|-|-'), mb_strtolower(trim($data['name'] ?: $type[1])))).'_'.date('d-m').'_'.sprintf('%04x', mt_rand(0, 0xffff)).'.'.($type = strtolower($type[2]));

					while(file_exists($rd.$dir.$file)) $file = preg_replace('/(_\d+)?\.'.$type.'$/', '_'.(++$i).'.'.$type, $file);

					move_uploaded_file($source, $rd.$dir.$file);
					$info = @getimagesize($rd.$dir.$file);

					return [
						'success' => true,
						'file' => [
							'url' => $dir.$file,
							'path' => $dir,
							'file' => $file,
							'name' => $name,
							'md5' => md5_file($rd.$dir.$file),
							'size' => filesize($rd.$dir.$file),
							'type' => $type,
							'width' => (int)$info[0],
							'height' => (int)$info[1],
						]
					];
				}
				else return 'An error occurred while loading the file: the server does not support downloading this type of file';
			}
			else return 'An error occurred while loading the file: the file was not sent to the server';
		}
		else return 'Not authorized';
	}

	// Админ -> Получить язык
	function api_site_getLang($data) {
		if($user = lk_user()) {
			if($user['role'] == 'admin') {
				$default = array_merge(
					(array)json_decode(@file_get_contents(__DIR__.'/../langs/ru.json'), true),
					(array)json_decode(@file_get_contents(__DIR__.'/../langs/'.lang().'.json'), true)
				);
				$lang = [];
				foreach($default as $k => $v) {
					$lang[] = [$k, $v];
				}

				return [
					'lang' => $lang,
					'success' => true
				];
			}
			else return 'Permission denied';
		}
		else return 'Not authorized';
	}

	// Админ -> Установить языки
	function api_site_setLang($data) {
		if($user = lk_user()) {
			if($user['role'] == 'admin') {
				if(is_array($data['lang'])) {
					$lang = [];
					foreach($data['lang'] as $v) {
						$lang[trim($v[0])] = trim($v[1]);
					}
					
					if(!$lang['symbol']) return 'Invalid language symbol';
					if($lang['symbol'] != lang()) return 'Error. The language has been changed in the parallel tab.';

					file_put_contents(__DIR__.'/../langs/'.lang().'.json', json_encode($lang, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

					return ['success' => true];
				}
				else return 'Invalid param `lang`';
			}
			else return 'Permission denied';
		}
		else return 'Not authorized';
	}

	// Админ -> Получить CSS
	function api_site_getCSS($data) {
		if($user = lk_user()) {
			if($user['role'] == 'admin') {
				return [
					'css' => @file_get_contents(__DIR__.'/../assets/template.css'),
					'success' => true
				];
			}
			else return 'Permission denied';
		}
		else return 'Not authorized';
	}

	// Админ -> Установить CSS
	function api_site_setCSS($data) {
		if($user = lk_user()) {
			if($user['role'] == 'admin') {
				file_put_contents(__DIR__.'/../assets/template.css', $data['css']);

				return ['success' => true];
			}
			else return 'Permission denied';
		}
		else return 'Not authorized';
	}

	// Админ -> Экспорт настроек
	function api_site_exportConfigCallback($data) {
		if($user = lk_user()) {
			if($user['role'] == 'admin') {
				$get = function($name) {
					static $rd = __DIR__.'/../';

					return json_decode(file_get_contents($rd.$name), true);
				};

				$res = [
					'config.json' => $get('config.json')
				];

				foreach(scandir($d = __DIR__.'/../langs/config/') as $v) {
					if(is_file($d.$v))
						$res['langs/'.$v] = $get('langs/config/'.$v);
				}

				return $res;
			}
			else return 'Permission denied';
		}
		else return 'Not authorized';
	}