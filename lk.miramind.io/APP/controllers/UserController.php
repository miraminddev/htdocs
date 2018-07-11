<?

namespace APP\controllers;
use APP\models\User;


class UserController extends AppController
{

	public $layaout = 'USER'; //Перераспределяем массив layaout


	public function registerAction()
	{

		if( isset($_SESSION['ulogin']['id']) ) redir('/panel/');

		if(!empty($_POST))
		{
			$user = new User; //Вызываем Моудль
			$data = $_POST;

			$user->load($data); // Берем из POST только те параметры которые нам нужны
			
			
			if(!$user->validate($data) || !$user->checkUniq('users') )
			{
				$_SESSION['form_data'] = $user->ATR; //Сохраняем в сессию, чтобы у поьзователю было удобнее
				$user->getErrorsVali(); //Записываем ошибки в сессию
				redir();
			}
			else
			{

				//Тут все круто
				$passorig = $user->ATR['password'];
				$user->ATR['password'] = password_hash(md5(md5($user->ATR['password'])), PASSWORD_DEFAULT); // Хеш пароля
				$_SESSION['confirm'] = $user->ATR; //Базовые параметры

				//Доп. Параметры в сессию
				$_SESSION['confirm']['code'] = $code = random_str(5); //Код подтверждения
				if(isset($_COOKIE['ref'])){
					$_SESSION['confirm']['ref'] = $_COOKIE['ref'];}
					else{
				$_SESSION['confirm']['ref'] = '0';
				} //ID реферала
				//Доп. Параметры в сессию
			
				$_SESSION['mail']['firstname'] = $_SESSION['confirm']['fullname'];				
				$user->sendm("code", $user->ATR['email']); // Отправка на почту кода подтверждения

			//	mes ('ВНИМАНИЕ! Не закрывайте страницу браузера. Код подтверждения отправлен на почту. ');
				go2('user/confirmRegister/');

			}// ИДЕМ НА КОНФИРМ






		}










	}


	public function indexAction()
	{

		if( isset($_SESSION['ulogin']['id']) ) redir('/panel/');


		if(!empty($_POST)){
			$user = new User;
			if($user->login('users')){
				//АВТОРИЗАЦИЯ
				redir('/panel/');


				//АВТОРИЗАЦИЯ
			}
			else
			{
				$_SESSION['errors'] = "Логин/Пароль введены не верно";

			}




		}

	}




	public function regokAction()
	{

		if( isset($_SESSION['ulogin']['id']) ) redir('/panel/');


		if(!empty($_POST)){
			$user = new User;
			if($user->login('users')){
				//АВТОРИЗАЦИЯ
				redir('/panel/');


				//АВТОРИЗАЦИЯ
			}
			else
			{
				$_SESSION['errors'] = "Логин/Пароль введены не верно";

			}




		}

	}
	
	
	
	



	public function logoutAction()
	{

		if(isset($_SESSION['ulogin'])){
			$_SESSION['ulogin'] = array();
			redir('/');
		}


	}







	public function confirmRegisterAction()
	{


		//Проверка на сессию кода
		if( !isset($_SESSION['confirm']['code']) )
		{
			mes ('Код подтверждения устарел. Необходимо зарегистрироваться повторно.');
			go2('user/register/');

		}
		//Проверка на сессию кода

		if(!empty($_POST['confirm-code']))
		{
			if($_POST['confirm-code'] == $_SESSION['confirm']['code'])
			{
				$user = new User;
				// ПИШЕМ В БАЗУ ДАННЫХ
				if($user->saveuser('users'))
				{	
					$_SESSION['mail']['firstname'] = $_SESSION['confirm']['fullname'];
					$user->sendm("register", $_SESSION['confirm']['email']);
					$_SESSION = array();
					mes ('Успешная регистрация! Данные для входа отправленны на почту!');
					go2('user/');

				}
				else
				{
					$_SESSION['errors'] = "Ошибка базы данных. Попробуйте позже.";

				}
				// ПИШЕМ В БАЗУ ДАННЫХ


			}
			else
			{

				$_SESSION['errors'] = "Код не совпдает с кодом в E-mail";

			}


		}









	}


	public function recoveryAction()
	{
		if(!empty($_POST)){

			$user = new User;
			
			if(filter_var($_POST['reminder-email'], FILTER_VALIDATE_EMAIL)){

				if($user->checkemail('users', $_POST['reminder-email'])){
					
					$_SESSION['confirm']['recode'] = random_str(5);
					$_SESSION['confirm']['remail'] = $_POST['reminder-email'];

					$user->sendm("codeRecovery", $_POST['reminder-email']); // Отправка на почту кода подтверждения
					go2('user/confirmRecovery/');



				}
				else
				{

					$_SESSION['errors'] = "Пользователя с таким E-mail не существует";

				}







			}
			else
			{

				$_SESSION['errors'] = "E-mail указан не корректно";
			}



		}






	}



	// Страница ввода кода при сбросе пароля
	public function confirmRecoveryAction()
	{

		if( !isset($_SESSION['confirm']['recode']) )
		{
			mes ('Код подтверждения устарел. Необходимо выполнить процедуру повторно.');
			go2('user/recovery/');

		}

		if(!empty($_POST['confirm-code']))
		{


			if($_POST['confirm-code'] == $_SESSION['confirm']['recode'])
			{

				$user    = new User;
				$newpass = $user->newpass('users');
				if(!empty($newpass))
				{



					$_SESSION['confirm']['newpass'] = $newpass;

					$user->sendm("newpass", $_SESSION['confirm']['remail']);
					$_SESSION = array();
					mes ('Новый пароль отправлен на почту!');
					go2('user/');




				}
				else
				{
					$_SESSION['errors'] = "Ошибка базы данных. Попробуйте позже.";
				}






			}
			else
			{

				$_SESSION['errors'] = "Код не совпдает с кодом в E-mail";

			}
		}





	}
	// Страница ввода кода при сбросе пароля




	public function refAction()
	{
		if(!empty($_GET['partner']))
		{

			if( !preg_match('/^[0-9]{1,5}$/', $_GET['partner']) )  exit('Неправильная реф.ссылка');
			setcookie('ref', $_GET['partner'], strtotime('+15 days'), '/');
			header('Location: /');



		}
		else
		{
			exit ('Неправильная реф.ссылка');

		}



	}


	public function formAction()
	{
		if(!empty($_POST)){
			
		$_SESSION['form_data']['signup-email'] = $_POST['email'];
		$_SESSION['form_data']['signup-telephon'] = $_POST['telephone'];
		$_SESSION['form_data']['signup-username'] = $_POST['username'];
		redir('/user/register/');
		}

		exit();
	}







}




?>