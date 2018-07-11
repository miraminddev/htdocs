<?php
namespace APP\core\base;
use lib\Rb;
abstract
class Model {

	public static $countsql = 0;
	public static $queries = [];
	public static $lastid;
	public $ATR = [];
	public $errors = [];
	public $rules = [];
	public function __construct() {

		require "lib/Rb.php";
		$DB = require WWW."/config/config_db.php";
		\R::setup($DB['dsn'],$DB['user'],$DB['pass']);
//		\R::fancyDebug( TRUE ); //дебаг
		\R::freeze(FALSE); // Снимаем комментарий когда нужно создать таблицу
	}

	// ЗАГРУЗКА ДАННЫХ ИЗ ФОРМЫ
	public function load($data) {
		foreach($this->ATR as $name => $val) {
			if(isset($data[$name])) $this->ATR[$name] = $data[$name];
		}
	}
	// ЗАГРУЗКА ДАННЫХ ИЗ ФОРМЫ

	public function loaduser($table,$iduser) {
		return \R::load($table, $iduser);
	}




	// ПРОВЕРКА ДАННЫХ
	public function validate($data) {
		$v = new \Valitron\Validator($data);
		$v->rules($this->rules);
		if($v->validate()) {
			return true;
		}
		$this->errors = $v->errors();
		return false;
	}
	// ПРОВЕРКА ДАННЫХ

	// Красивый вывод ошибок валидации
	public function getErrorsVali() {
		$errors = "<ul>";
		foreach($this->errors as $error) {
			foreach($error as $item) {
				$errors .= "<li>".$item."</li>";
			}
		}
		$errors .= "</ul>";
		$_SESSION['errors'] = $errors;
	}
	// Красивый вывод ошибок валидации





	//ОТПРАВКА E - MAIL
	public function sendm($type, $komu) {
		$SPApiProxy = new \SendpulseApi( API_USER_ID, API_SECRET, TOKEN_STORAGE );

		$PISMA = require "config/mail_template.php";
		$html = file_get_contents("config/mailhtml.php");  if(!isset($komu)) {
			$_SESSION['errors']= "Ошибка при отправлении письма. Обратитесь к администратору";
			return false;
		}

		if(!isset($type)) {
			$_SESSION['errors']= "Ошибка при отправлении письма. Обратитесь к администратору";
			return false;
		}

		if(!isset($PISMA[$type])) {
			$_SESSION['errors']= "Такого письма не существует";
			return false;
		}

		$footer = "<br>С Уважением, ".NAME."<br>";

		if (isset($_SESSION['mail']['firstname'])) {
			$html = str_replace("{ZAGOLOVOK}", "Здравствуйте, ".$_SESSION['mail']['firstname']."!", $html);
		}else{
			$html = str_replace("{ZAGOLOVOK}", "Здравствуйте!", $html);
		}

		$html = str_replace("{CONTENT}", $PISMA[$type]['html'], $html);
		$html = str_replace("{FOOTER}", $footer, $html);

		$email = array(
			'html'   => $html,
			'text'   => 'text',
			'subject'=> $PISMA[$type]['subject'],
			'from'    => array(
				'name' => NAME,
				'email'=> BASEMAIL
			),
			'to'      => array(
				array(
					'name' => NAME,
					'email'=> $komu
				)
			),

		);

		$SPApiProxy->smtpSendMail($email);
		return true;
	}
	//ОТПРАВКА E - MAIL
}
?>