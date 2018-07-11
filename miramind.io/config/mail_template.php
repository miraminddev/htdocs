<?
if (empty($_SESSION['confirm']['firstname'])) $_SESSION['confirm']['firstname'] = "";
if (empty($_SESSION['confirm']['email'])) $_SESSION['confirm']['email'] = "";
if (empty($_SESSION['confirm']['password2'])) $_SESSION['confirm']['password2'] = "";
if (empty($_SESSION['confirm']['code'])) $_SESSION['confirm']['code'] = "";
if (empty($_SESSION['mailresult']['ci'])) $_SESSION['mailresult']['ci'] = "";
if (empty($_SESSION['mailresult']['b'])) $_SESSION['mailresult']['b'] = "";
if (empty($_SESSION['mailresult']['commentt'])) $_SESSION['mailresult']['commentt'] = "";




if (empty($_SESSION['ulogin']['fio'])) $_SESSION['ulogin']['fio'] = "";
if (empty($_SESSION['subj'])) $_SESSION['subj'] = "";
if (empty($_SESSION['ulogin']['tel'])) $_SESSION['ulogin']['tel'] = "";
if (empty($_SESSION['confirm']['recode'])) $_SESSION['confirm']['recode'] = "";
if (empty($_SESSION['confirm']['remail'])) $_SESSION['confirm']['remail'] = "";


if (empty($_SESSION['viplata']['idv'])) $_SESSION['viplata']['idv'] = "";

if (empty($_SESSION['confirm']['newpass'])) $_SESSION['confirm']['newpass'] = "";


if (empty($_SESSION['acceptcompany']['firstname'])) $_SESSION['acceptcompany']['firstname'] = "";
if (empty($_SESSION['acceptcompany']['company'])) $_SESSION['acceptcompany']['company'] = "";

if (empty($_SESSION['mailresult']['namecompany'])) $_SESSION['mailresult']['namecompany'] = "";


if (empty($_SESSION['mail']['nameproject'])) $_SESSION['mail']['nameproject'] = "";



return
[
	'register' =>
	[
		'subject' => 'Успешная регистрация '.NAME.'',

		'html' => 'Добро пожаловать в сервис заработка для операторов на телефоне '.NAME.'<br>
		Всю информацию по работе вы получите при входе в систему<br>
		Страница для входа http://'.DOMAIN.'/user/<br>
		<b>Ваш Логин:</b> '.$_SESSION['confirm']['email'].'<br>
		<b>Ваш Пароль:</b> '.$_SESSION['confirm']['password2'].'<br>
',
	],



	'code' =>
	[
		'subject' => 'Код подвтерждения регистрации '.NAME.'',

		'html' => '
		<p>Код подтверждения регистрации: <h2>'.$_SESSION['confirm']['code'].'</h2></p>
		Страница подтверждения регистрации:<br> http://'.DOMAIN.'/user/confirmRegister/
		',
	],




	'codeRecovery' =>
	[
		'subject' => 'Сборс пароля в '.NAME.'',


		'html' => '
		На сервисе '.NAME.' была активирована функция сборса пароля.<br>
		Введите код подтверждения на сайте и вам будет отправлен новый пароль.<br>
		Код подтверждения E-mail: <b>'.$_SESSION['confirm']['recode'].'</b>
		Страница подтверждения: http://'.DOMAIN.'/user/confirmRecovery/ <br>
		
		Если вы не запускали функцию сборса пароля на сайте '.DOMAIN.' свяжитесь, пожалуйста, с администрацией.<br>
		',
	],
	
	
	
	'newpass' =>
	[
		'subject' => 'Ваш новый пароль в '.NAME.'',

		'html' => '
		<p>Логин для входа: '.$_SESSION['confirm']['remail'].' </p>
		<p><b>Ваш новый пароль: '.$_SESSION['confirm']['newpass'].' </b></p>
		Страница для входа http://'.DOMAIN.'/user/<br>	
		',
	],
	


 	'ticketanswer' =>
	[
		'subject' => ' Получен новый ответ на тикет - '.NAME.'',

		'html' => '	
		В личном кабинете появился новый ответ на ранее написанный тикет.<br>
		Посмотреть ответ: <a href="//'.DOMAIN.'/panel/ticket">'.DOMAIN.'/panel/ticket</a><br>
		',
	],
	
	       





];


?>