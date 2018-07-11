<?


   require_once( 'sendpulseInterface.php' );
   require_once( 'sendpulse.php' );
   define( 'API_USER_ID', 'e3a52b4091b34385f6b5fdaf2a25be3a' );
   define( 'API_SECRET', 'eddcae62eed298eafd63b1ea9b97744e' );
   define( 'TOKEN_STORAGE', 'file' );

 $SPApiProxy = new SendpulseApi( API_USER_ID, API_SECRET, TOKEN_STORAGE );



if($_POST){


	if($_POST['type'] = "podpiska"){

			if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {





// ЗАПИСЫВАЕМ ЕГО ПОЧТУ К СЕБЕ В БАЗУ ДАННЫХ
// ПУТЬ ДО САЙТА / home / bitrix / ext_www / zarabotat.money /
//Подключение к БД
require "/home/bitrix/ext_www/miramind.io/lib/Rb.php";
$DB = require "/home/bitrix/ext_www/miramind.io/config/config_db.php";
\R::setup($DB['dsn'],$DB['user'],$DB['pass']);
//Подключение к БД

		$tbl = \R::findOne('basemail', 'mailadress = ? LIMIT 1',[$_POST['mail']]);

if(!$tbl){

		$tbl = \R::dispense('basemail');
		//ФОРМИРУЕМ МАССИВ ДАННЫХ ДЛЯ РЕГИСТРАЦИИ
		$TICKET = [
			'mailadress' => $_POST['mail'],
			'date' => date("Y-m-d H:i:s"),

		];
		//ФОРМИРУЕМ МАССИВ ДАННЫХ ДЛЯ РЕГИСТРАЦИИ

		foreach($TICKET as $name=>$value)
		{
			$tbl->$name = $value;

		}

		 \R::store($tbl);
// ЗАПИСЫВАЕМ ЕГО ПОЧТУ К СЕБЕ В БАЗУ ДАННЫХ

			}



$html = file_get_contents("mail_templates/ty_letter/index.html");


	//ОТПРАВКА ПОЧТЫ КЛИЕНТУ
	    $email = array(
        'html' => $html,
        'text' => 'text',
        'subject' => 'Thank You',
        'from' => array(
            'name' => 'MIRA - Artificial Mind by MIRAMIND',
            'email' => 'nore@miramind.io'
        ),
        'to' => array(
            array(
                'name' => 'POST',
                'email' => $_POST['mail'],
            )
        ),

    );

    $SPApiProxy->smtpSendMail($email);
  	//ОТПРАВКА ПОЧТЫ КЛИЕНТУ

  //  var_dump($email);


				} else{
		
			echo "E-mail is incorrect";

				}


	}




	if($_POST['type'] = "forma"){

			if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {





	//ОТПРАВКА ПОЧТЫ КЛИЕНТУ
	    $email = array(
        'html' => '
        ИМЯ: '.$_POST['name'].'
        ТЕЛЕФОН: '.$_POST['phone'].'
        ПОЧТА: '.$_POST['mail'].'
        
        
        ',
        'text' => 'text',
        'subject' => 'Thank You',
        'from' => array(
            'name' => 'MIRA - Artificial Mind by MIRAMIND',
            'email' => 'nore@miramind.io'
        ),
        'to' => array(
            array(
                'name' => 'POST',
                'email' => 'private@miramind.io',
            )
        ),

    );

    $SPApiProxy->smtpSendMail($email);
  	//ОТПРАВКА ПОЧТЫ КЛИЕНТУ

  //  var_dump($email);


				} else{
		
			echo "E-mail is incorrect";

				}


	}
	
	
















}



?>
