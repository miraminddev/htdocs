<?

// КОНФИГ
define('WWW', __DIR__);
define('ROOT',dirname(__DIR__) );
define('LAYOUT', 'default' );
define('NAME', 'MIRAMIND' );
define('BASEMAIL', 'hello@miramind.io' );
define('DOMAIN', 'lk.miramind.io' );
define('ERRORS', '1' ); // 0 - нет 1 - ОТОБРАЖАЮТСЯ

require( 'lib/functions.php' ); //ОБЩИЕ ФУНКЦИИ
require( 'lib/functions_app.php' ); //ФУНКЦИИ ПРИЛОЖЕНИЯ


// ЗАГРУЗКА КЛАССА ДЛЯ ОТПРАКИ E-MAIL
 define( 'API_USER_ID', 'e3a52b4091b34385f6b5fdaf2a25be3a' );
 define( 'API_SECRET', 'eddcae62eed298eafd63b1ea9b97744e' );
 define( 'TOKEN_STORAGE', 'file' );
 require_once( 'lib/sendpulseInterface.php' );
 require_once( 'lib/sendpulse.php' );
 // $SPApiProxy = new \SendpulseApi( API_USER_ID, API_SECRET, TOKEN_STORAGE ); Так вызывается в приложении
// ЗАГРУЗКА КЛАССА ДЛЯ ОТПРАВКИ E-MAIL


	define('DEBUG', false);
//ETH
	define('ETH_NETWORK', DEBUG ? 'https://rinkeby.infura.io:443/metamask' : 'https://mainnet.infura.io:443/metamask');
	define('ETH_NETWORK_ID', DEBUG ? 4 : 1);
//ETH

//PAYBEAR
	define('PAYBEAR_API', DEBUG ? 'https://develop.smartcontract.ru/paybear/create/?currency=%s&callback=%s&token=%s' : 'https://api.paybear.io/v2/%s/payment/%s?token=%s');
	define('PAYBEAR_PUBLIC', 'pubd80e42ce803f591ff97776b30c69dbb9');
	define('PAYBEAR_PRIVATE', 'secfbbbdc9c5f8b01adb2459acd28be3375');
//PAYBEAR	
	
	

//ВАЛИДАТОР
require_once( 'lib/Valitron/Validator.php' );
use Valitron\Validator as V;
V::langDir(__DIR__.'/lib/Valitron/lang'); // always set langDir before lang.
//V::lang('ru');
//ВАЛИДАТОР



use APP\core\Router;


session_start();

$router = new Router;



// ДОПОЛНИТЕЛЬНЫЕ ПРАВИЛА ПУТЕЙ
$router->add( 'login/', ['controller'=>'User', 'action'=>'index']);
$router->add( 'user/login', ['controller'=>'User', 'action'=>'index']);
$router->add( '^page/(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller'=>'Page']);
$router->add( '^page/(?P<alias>[a-z-]+)$', ['controller'=>'Page', 'action'=>'view']);
// ДОПОЛНИТЕЛЬНЫЕ ПРАВИЛА ПУТЕЙ


//ДЕФОЛТНЫЕ ПРАВИЛА
$router->add( '^$', ['controller'=>'User', 'action'=>'index']);
$router->add( '^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');
//ДЕФОЛТНЫЕ ПРАВИЛА

$router->run(); // ЗАПУСКАЕМ РОУТЕР


























?>