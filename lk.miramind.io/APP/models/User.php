<?

namespace APP\models;



class User extends \APP\core\base\Model
{

// АТРИБУТЫ КОТОРЫЕ ЗАБИРАЕМ ПРИ РЕГИСТРАЦИИ
	public $ATR = [
		'fullname' => '',
		'email' => '',
		'password' => '',
		'password2' => '',
		'agree' => '',
	];



// Правила валидации
	public $rules = [
		'required' => [
			['fullname'],
			['email'],
			['password'],
			['password2'],
			['agree'],		
			
		],

		'email' =>[
			['email'],
		],

		'lengthMin' =>[
			['password',5],
			['password2',5],
		],


		'lengthMax' =>[
			['password',30],
			['password2',30],
			['fullname',30],
		],


//ЧТОБЫ БЫЛИ ОДИНАКОВЫЕ ПОЛЯ
		'equals' =>[
			['password', 'password2' ],
		],


	];

// Валидация на код
	public $rulesconfirm = [
		'required' =>[
			['confirm-code'],
		],

		'lengthMax' =>[
			['confirm-code',6],
		],


	];

	// ПРОВЕРКА НА УНИКАЛЬНЫЙ ЕМЕЙЛ
	public function checkUniq($table)
	{

		$uni = \R::findOne($table, 'email = ? LIMIT 1',[$this->ATR['email']]);
		if($uni){

			if($uni->email == $this->ATR['email']){
				$this->errors['uniq'][] = "Пользователь с таким E-mail уже зарегистрирован";

			}
			return false;
		}

		return true;

	}
	// ПРОВЕРКА НА УНИКАЛЬНЫЙ ЕМЕЙЛ



	
	//СБРОС ПАРОЛЯ
	public function newpass($table)
	{
				$newpass = random_str(10);
				$newpassmd5 = md5(md5($newpass));
				$tbl = \R::load($table, $_SESSION['confirm']['id']);
				$tbl->pass = password_hash($newpassmd5 , PASSWORD_DEFAULT); 
				\R::store($tbl);
				
				return $newpass;
		
	}				

	
	//СБРОС ПАРОЛЯ
	
	
	
	//ЛОГИН
	public function login($table)
	{

		$email = !empty(trim($_POST['email'])) ? trim($_POST['email']) : NULL;
		$pass = !empty(trim($_POST['password'])) ? trim($_POST['password']) : NULL;
		if ($email && $pass){
			$user = \R::findOne($table, 'email = ? LIMIT 1',[$email]);
				if($user){
					$pass = md5(md5($pass));
					if(password_verify($pass, $user->pass)){
						// АВТОРИЗАЦИЯ
							foreach ($user as $k => $v){
								$_SESSION['ulogin'][$k] = $v;
								$_SESSION['ulogin']['pass'] = "";
								
							}
						
						
						// АВТОРИЗАЦИЯ
						return true;
					}
					
					
					
				}
			
			
			
			
		}
		
		return false;
		
	}				

	
		//ЛОГИН
	
	
	
	
	
	

	// SAVEUSER
	public function saveuser($table)
	{
	

		$tbl = \R::dispense($table);


		//ФОРМИРУЕМ МАССИВ ДАННЫХ ДЛЯ РЕГИСТРАЦИИ
		$MASSREG = [
			'email' => $_SESSION['confirm']['email'],
			'pass' => $_SESSION['confirm']['password'],
			'firstname' => $_SESSION['confirm']['fullname'],
			'token' => '0',
			'lang' => 'en',
			'verify' => 'no',
			'wallet' => '',							
			'avatar' => "200x200",
			'ref' => $_SESSION['confirm']['ref'],
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



	// ПРОВЕРКА ЕСТЬ ЛИ ТАКОЙ ЕМЕЙЛ
	public function checkemail($table, $email)
	{
		$uni = \R::findOne($table, 'email = ? LIMIT 1', [$email]);
		if($uni){
			
			if($uni->email == $email){
				$_SESSION['confirm']['id'] = $uni->id;	
				 return true;
			}
		}
		
		return false;

	}
	// ПРОВЕРКА ЕСТЬ ЛИ ТАКОЙ ЕМЕЙЛ
	
	
	




}


?>