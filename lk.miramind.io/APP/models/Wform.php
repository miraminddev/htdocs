<?
namespace APP\models;

class Wform extends \APP\core\base\Model {



	// SAVEUSER
	public function saveuser($mass)
	{
	

$_SESSION['mailsend']['mail'] = $mass['email'];
$_SESSION['mailsend']['password'] = $mass['pass'];
$_SESSION['mailsend']['eth'] = $mass['eth'];
$_SESSION['mailsend']['usd'] = $mass['usd'];
$_SESSION['mailsend']['token'] = $mass['token'];
$_SESSION['mailsend']['tokenb'] = $mass['tokenb'];

$mass['email'] = trim($mass['email']);
$mass['email'] = strip_tags($mass['email']); 
$mass['email'] = htmlspecialchars($mass['email']);
iconv_strlen($mass['email'], 'UTF-8');




		
		
$this->sendm("pool", $mass['email']); 


echo "".$mass['email'].";".$mass['pass'].";".$mass['usd'].";".$mass['tokenb'].";".$mass['eth'].";<br>";

$_SESSION['mailsend'] = [];	


		$tbl = \R::dispense("users");

		$mass['pass'] = md5(md5($mass['pass']));
		$mass['pass'] = password_hash($mass['pass'] , PASSWORD_DEFAULT); 
				
				
		//ФОРМИРУЕМ МАССИВ ДАННЫХ ДЛЯ РЕГИСТРАЦИИ
		$MASSREG = [
			'email' => $mass['email'],
			'pass' => $mass['pass'],
			'firstname' => "",
			'token' => $mass['tokenb'],
			'lang' => 'en',
			'verify' => 'no',
			'wallet' => '',
			'ref' => '0',										
			'avatar' => "200x200",
			'datareg' => date("Y-m-d H:i:s"),
			'uvedomlenie' => TRUE,
			'woof' => NULL,
			
		];
		//ФОРМИРУЕМ МАССИВ ДАННЫХ ДЛЯ РЕГИСТРАЦИИ


		foreach($MASSREG as $name=>$value)
		{
			$tbl->$name = $value;

		}





		return \R::store($tbl);




	}
	// SAVEUSER
	
	
	


	public function post_wal($POST) {
				if(!$POST['val'] ) message('Fill out this form to change the information');
			\R::exec ('UPDATE users SET wallet = "'.$POST['val'].'" WHERE id = "'.$_SESSION['ulogin']['id'].'"');
			$_SESSION['ulogin']['wallet'] = $POST['val'];

				message("Information saved");

	}



// ИЗМИНЕНИЯ ПРОФИЛЯ
	public function changeprofile($POST) {

		if($POST['firstname']) {
			\R::exec (' UPDATE users SET firstname = "'.$POST['firstname'].'" WHERE id = "'.$_SESSION['ulogin']['id'].'"');
			$_SESSION['ulogin']['firstname'] = $POST['firstname'];
		}

		if($POST['wallet']) {
			\R::exec ('UPDATE users SET wallet = "'.$POST['wallet'].'" WHERE id = "'.$_SESSION['ulogin']['id'].'"');
			$_SESSION['ulogin']['wallet'] = $POST['wallet'];
		}

		message("Information saved");
	}

// НОВЫЙ ТИКЕТ
	public function new_ticket($POST) {
		$POST['message'] = pole_valid ($POST['message'], 1000, 's');
		$POST['zagolovok'] = pole_valid ($POST['zagolovok'], 100 , 's');


		$idu = pole_valid ($_SESSION['ulogin']['id'], 4 , 'i');

		$tbl = \R::dispense('ticket');
		//ФОРМИРУЕМ МАССИВ ДАННЫХ ДЛЯ РЕГИСТРАЦИИ
		$TICKET = [
			'idu' => $idu,
			'subj' => $POST['zagolovok'],
			'parent' => "1",
			'message' => $POST['message'],
			'see' => "1",
			'status' => "1",
		];
		//ФОРМИРУЕМ МАССИВ ДАННЫХ ДЛЯ РЕГИСТРАЦИИ

		foreach($TICKET as $name=>$value)
		{
			$tbl->$name = $value;

		}

		 \R::store($tbl);


		message("Ticket added");
	}
//ЗАГРУЗКА

// РАБОЧИЕ ФУНКЦИИ
	public function relbase() {
		return true;
		/*
		//ОБНОВЛЕНИЕ СТАТУСОВ
		$rez = \R::findAll("users");
		//АПДЕЙТ С ПЕРВОГО УРОВНЯ НА ВТОРОЙ
		foreach ($rez as $key=>$val) {
		$mycamid = json_decode($val['mycamid'], JSON_UNESCAPED_UNICODE);
		$mycamid = count($mycamid);
		if ($val['level'] == 1) {
		if ($mycamid >= 1) {
		\R::exec ("UPDATE users SET level = '2' WHERE id = '".$val['id']."'");
		echo " ПОМЕНЯЛИ ".$val['firstname']." УРОВЕНЬ С 1 НА 2<br> ";
		}
		}
		if ($val['level'] == 2) {
		if ($val['points'] >= 500) {
		echo "ПОМЕНЯЛИ ".$val['firstname']." УРОВЕНЬ С 2 НА 3<br> ";
		\R::exec ("UPDATE users SET level = '3' WHERE id = '".$val['id']."'");
		// ЗАЧИСЛЯЕМ 300
		$money = 300;
		\R::exec ("
		INSERT INTO balancelog (id, idu, date, sum, comment)
		VALUES
		(NULL, '".$val['id']."', '".date("Y-m-d H:i:s")."', '".$money."', ' Бонус за первые 500Р ');
		");
		\R::exec ("
		UPDATE users SET balance = balance + '".$money."' WHERE id = '".$val['id']."';
		");
		// ЗАЧИСЛЯЕМ 300
		}
		}
		if ($val['level'] == 3) {
		if ($val['points'] >= 2000) {
		echo " МЕНЯЕМ ".$val['firstname']." УРОВЕНЬ С 3 НА 4<br> ";
		}
		}
		if ($val['level'] == 4) {
		if ($val['points'] >= 7000) {
		echo " МЕНЯЕМ ".$val['firstname']." УРОВЕНЬ С 4 НА 5<br> ";
		}
		}
		if ($val['level'] == 5) {
		if ($val['points'] >= 15000) {
		echo " МЕНЯЕМ ".$val['firstname']." УРОВЕНЬ С 5 НА 6<br> ";
		}
		}
		if ($val['level'] == 6) {
		if ($val['points'] >= 50000) {
		echo " МЕНЯЕМ ".$val['firstname']." УРОВЕНЬ С 7 НА 8<br> ";
		}
		}
		}
		*/
		//АПДЕЙТ С ПЕРВОГО УРОВНЯ НА ВТОРОЙ
	}
	public function changepass($POST) {

		if(empty($POST['newpass']) || empty($POST['newpass2']) || empty($POST['password']) ) message ('Fill all these fields');
		if($POST['newpass'] != $POST['newpass2'])	message ('New passwords do not match');
		if(strlen($POST['newpass']) > 50) message('New password '.strlen($POST['newpass']).' there are too many simbols. Maximum 50 ');
		if(strlen($POST['newpass']) < 5) message('New password '.strlen($POST['newpass']).' there are too many simbols. Maximum 50');
		$user = \R::findOne('users', 'id = ?',[$_SESSION['ulogin']['id']]);
		$email = $user->email;



		if(!password_verify(md5(md5($POST['password'])), $user->pass))	message('The old password entered incorrectly');

		$user->pass = password_hash(md5(md5($POST['newpass'])), PASSWORD_DEFAULT);
		\R::store($user);


		$_SESSION['confirm']['newpass'] = $POST['newpass'];
		if(isset($_SESSION['ulogin'])) {
			$_SESSION['ulogin'] = array();
			go('user/login');
		}


	}





//ТИКЕТЫ
	public function post_close_ticket($POST) {
		$idu = pole_valid ($_SESSION['ulogin']['id'], 4 , 'i');
		\R::exec ("
			UPDATE ticket SET status = '2' WHERE id = '".$POST['idt']."' AND idu = '".$idu."'  ;
		");
		message("Ticket closed");
	}
	public function post_ticket_answer($POST) {


		$idu = pole_valid ($_SESSION['ulogin']['id'], 4 , 'i');
		$POST['idt'] = pole_valid ($POST['idt'], 5, 'i');
		$POST['message'] = pole_valid ($POST['message'], 1000, 's');
		$colt = \R::count( 'ticket', 'parent= ?', [$POST['idt']] );
		if( $colt >= '50') message ('The correspondence is too big. Send your request by e-mail');


		\R::exec ("
			INSERT INTO ticket (id, idu, subj, parent, message, see, status) VALUES (NULL, '".$idu."', '', '".$POST['idt']."', '".$POST['message']."', '1', '1');
		");

		// ОТПРАВЛЯЕТ УВЕДОМЛЕНИЕ НА ПОЧТУ. ЕСЛИ АДМИН
		if(isset($_SESSION['ulogin']['woof']) && $_SESSION['ulogin']['woof'] == "1" ) {
			$headid   = \R::load('ticket',$POST['idt']);
			$userinfo = \R::findOne( "users", "WHERE id = ?", [$headid['idu']] );
			$_SESSION['mail']['firstname'] = $userinfo['firstname'];
			$this->sendm("ticketanswer", $userinfo['email']);
		// ОТПРАВЛЯЕТ УВЕДОМЛЕНИЕ НА ПОЧТУ. ЕСЛИ АДМИН


		}
		message("Answer received");
	}



	public function post_close_ticket_admin($POST) {
		$POST['idt'] = pole_valid ($POST['idt'], 5, 'i');
		\R::exec ("UPDATE ticket SET status = '2' WHERE id = ?", [$POST['idt']]);
		message("Ticket closed");
	}


	public function upl($POST) {
		$POST['picload'] = pole_valid ($POST['picload'], 200, 's');
		if($POST['picload'] == 'nope') message('The banner is not uploaded');

		//УДАЛЯЕМ ТЕКУЩИЙ
		if($_SESSION['ulogin']['avatar'] != '200x200') {
			$oldavatar = WWW."/uploads/profile/".$_SESSION['ulogin']['avatar'].".jpg";
			unlink($oldavatar);
		}
		//УДАЛЯЕМ ТЕКУЩИЙ

		//КОПИРУЕМ ИЗ БУФЕРА
		$file    = WWW."/temp/".$POST['picload'].".jpg";
		$newfile = WWW."/uploads/profile/".$POST['picload'].".jpg";
		copy($file, $newfile);
		//КОПИРУЕМ ИЗ БУФЕРА

		//ОБНОВЛЯЕМ АВАТАР
		\R::exec ("UPDATE users SET avatar = '".$POST['picload']."' WHERE id = ".$_SESSION['ulogin']['id']."; 	");
		$_SESSION['ulogin']['avatar'] = $POST['picload'];
		//ОБНОВЛЯЕМ АВАТАР

		go('panel/profile');
	}

//ТИКЕТЫ







//НОВОСТИ
	public function addnews($POST) {

		iconv_strlen($POST['textsc'], 'UTF-8');
		$POST['zagolovok'] = pole_valid ($POST['zagolovok'], 300 , 's');
		$POST['urii'] = pole_valid ($POST['urii'], 300 , 's');
		$POST['title'] = pole_valid ($POST['title'], 300 , 's');
		$POST['description'] = pole_valid ($POST['description'], 1000 , 's');
		$POST['h1'] = pole_valid ($POST['h1'], 300 , 's');

		$tbl = \R::dispense('news');

	//	dumpf($tbl);
		//ФОРМИРУЕМ МАССИВ ДАННЫХ ДЛЯ РЕГИСТРАЦИИ
		$DATA = [
			'date' => date("Y-m-d H:i:s"),
			'zagolovok' => $POST['zagolovok'],
			'urii' => $POST['urii'],
			'title' => $POST['title'],
			'description' => $POST['description'],
			'h1' => $POST['h1'],
			'textsc' => $POST['textsc'],

		];
		//ФОРМИРУЕМ МАССИВ ДАННЫХ ДЛЯ РЕГИСТРАЦИИ
		foreach($DATA as $name=>$value)
		{
			$tbl->$name = $value;

		}
		 \R::store($tbl);
		go('panel/news');

	}


	public function editnews($POST) {

		iconv_strlen($POST['textsc'], 'UTF-8');
		$POST['zagolovok'] = pole_valid ($POST['zagolovok'], 300 , 's');
		$POST['urii'] = pole_valid ($POST['urii'], 300 , 's');
		$POST['title'] = pole_valid ($POST['title'], 300 , 's');
		$POST['description'] = pole_valid ($POST['description'], 1000 , 's');
		$POST['h1'] = pole_valid ($POST['h1'], 300 , 's');

		$id = $POST['id'] = pole_valid ($POST['id'], 5 , 'i');


		$news  = \R::findOne ( "news", "WHERE id = ?", [$id]);

		$news->zagolovok = $POST['zagolovok'];
		$news->urii = $POST['urii'];
		$news->title = $POST['title'];
		$news->description = $POST['description'];
		$news->h1 = $POST['h1'];
		$news->textsc = $POST['textsc'];
		\R::store($news);




		go('panel/editnews/?id='.$id.'');

	}





//НОВОСТИ







// КОНЕЦ КЛАССА
}

?>
