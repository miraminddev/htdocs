<?


// ВЫКЛЮЧАТЬ ОШИБКИ error_reporting(E_ERROR);


$er = ERRORS;

if($er == 1){
//ВЫВОД ОШИБОК
ini_set('display_errors',1);
error_reporting(E_ALL);
//ВЫВОД ОШИБОК
} else{
	error_reporting(E_ERROR);
	
}


function not_found() { // ЕСЛИ НЕ НАЙДЕНА СТРАНЦИА
if (isset($_SESSION['ulogin'])){
	 echo "<script>document.location.href='/panel';</script>\n";
	 exit();
	 }
	 else{
	 http_response_code(404);
	 include ("404.php");
	 exit();
	 
	 }
} // ЕСЛИ НЕ НАЙДЕНА СТРАНЦИА






 // Функция вывода сообщений в обработчике форм
function message( $text ) {
	exit('{ "message" : "'.$text.'"}');
}
// Функция вывода сообщений в обработчике форм

// Функция редирект при возвращении из формы через ajax
function go( $url ) {
	exit('{ "go" : "'.$url.'"}');
}
// Функция редирект при возвращении из формы через ajax



// Функция редирект при возвращении из формы через ajax
function go2( $url ) {
	exit('
	<script>
	window.location.href="/" + "'.$url.'";
	</script>
	');

}
// Функция редирект при возвращении из формы через ajax




function redir($http = FALSE){
	if($http){
		$redirect = $http;
	}else{
	$redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
	}
	header("Location: $redirect");
	exit();
	
}


// Екзит из интерфейса
function off( $mes ) {
	echo ( '
	
	<div class="note note-danger">
    <h4 class="block">ALERT!</h4>
 <p> '.$mes.' </p>
     </div>
                                                        
                                                        

	
		 ') ;
		 exit;
	
		 
		 
}
// Функция красивого ексита



// СООБЩЕНИЕ ЧЕРЕЗ PHP
function mes ( $mess ) {
	echo ( '
	<script>
		alert(" '.$mess. '");
	</script>
		 ') ;
}
// СООБЩЕНИЕ ЧЕРЕЗ PHP



function dumpf($PARAM){
	 file_put_contents('log.log', var_export($PARAM, true), FILE_APPEND); 
	
}


function hurl($url){
	
	$url = str_replace("http://", "", $url); // Убираем http
	$url = str_replace("https://", "", $url); // Убираем https
	$url = str_replace("www.", "", $url); // Убираем https

	return $url;
}

// Генерируем рандом символы 30 шт  
 function random_str( $num = 30 ) {
	return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $num);
}
// Генерируем рандом символы 30 шт  


function show($par){
	
echo "<pre>";
   print_r($par);
echo "</pre>";

}



// ФУНКЦИЯ ЗАГРУЗКИ КЛАССОВ
spl_autoload_register(function ($class) {
   $path = str_replace( '\\', '/', $class.'.php' );
   if (file_exists($path)){
   	require $path;
   }
   
});
// ФУНКЦИЯ ЗАГРУЗКИ КЛАССОВ



function h($str){
	return htmlspecialchars($str, ENT_QUOTES);
}


function teleph($tel){
	
			
		$tel = str_replace("'", "", $tel); // Убираем +
		$tel = str_replace("+", "", $tel); // Убираем +
		$tel = str_replace("(", "", $tel); // Убираем (
		$tel = str_replace(")", "", $tel); // Убираем )
		$tel = str_replace("-", "", $tel); // Убираем )
		$tel = str_replace(".", "", $tel); // Убираем .
		$tel = str_replace(" ", "", $tel); // Убираем пробелы
		$tel = trim($tel);

		if ($tel['0'] == '8'){
			$tel = substr($tel, 1);  

		}


		if ($tel['0'] != '7') $tel = "7".$tel."";
		

		
		
		return $tel;
	
	
}



// КОНВЕРТИРУЕТ ДАТУ В ДЕНЬ НЕДЕЛИ
function datetoday($date){
$date=explode("-", $date);
$day = date("w", mktime(0, 0, 0, $date[1], $date[2], $date[0]));
return $day;
}
// КОНВЕРТИРУЕТ ДАТУ В ДЕНЬ НЕДЕЛИ

// КОНВЕРТИРУЕТ ДАТУ В ДЕНЬ НЕДЕЛИ
function datetochar($date){
$date=explode("-", $date);
$day = date("w", mktime(0, 0, 0, $date[1], $date[2], $date[0]));

if ($day == '1') $day = "Понедельник";
if ($day == '2') $day = "Вторник";
if ($day == '3') $day = "Среда";
if ($day == '4') $day = "Четверг";
if ($day == '5') $day = "Пятница";
if ($day == '6') $day = "Суббота";
if ($day == '0') $day = "Воскресенье";

return $day;
}
// КОНВЕРТИРУЕТ ДАТУ В ДЕНЬ НЕДЕЛИ

	function pole_valid($pole, $num, $type) {
	if (!$pole) message('Поле пустое и не заполненно.');
	if ($type == "i") {
		$pole = intval($pole);
		if (strlen($pole) > $num) message('Текст '.strlen($pole).' символов слишком большой. Нужно не более '.$num.' ');
	}
	if ($type == "s") {
		if (strlen($pole) > $num) message('Текст '.strlen($pole).' символов слишком большой. Нужно не более '.$num.'');
		$pole = trim($pole);
		$pole = strip_tags($pole);
		$pole = htmlspecialchars($pole);
		iconv_strlen($pole, 'UTF-8');
		$pole = str_replace("\\", "-", $pole); // Убираем http
	}
	if ($type == "u") {
		if (strlen($pole) > $num) message('Текст '.strlen($pole).' символов слишком большой. Нужно не более '.$num.'');
		$pole = trim($pole);
		$pole = strip_tags($pole);
		$pole = htmlspecialchars($pole);
		iconv_strlen($pole, 'UTF-8');
	}
	return $pole;
}




function GetImageFromUrl($link) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, 0);
	curl_setopt($ch,CURLOPT_URL,$link);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result=curl_exec($ch);
	curl_close($ch);
	return $result;
}


function APARSER($parser,$parset,$query){

$aparser = 'http://159.253.21.43:9091/API';
$request = json_encode(array(
    'action' => 'oneRequest',
        'data' => array (
        'resultsUnique' => 'yes',
        'parser' => $parser,
        'preset' => $parset,
        'query' => $query
    ),
    'password' => '113322'
));
$ch = curl_init($aparser);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: ' . strlen($request)));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain; charset=UTF-8'));
$response = curl_exec($ch);
curl_close($ch);
$response = json_decode($response, true);

return $response;
	
	
}






function curlJSONget ($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, 0);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$response = curl_exec($ch);
	curl_close($ch);
	$response = json_decode($response,TRUE);
	return ($response);
	
	
}


   
   



?>