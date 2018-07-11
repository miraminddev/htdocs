<?

namespace APP\core\base;

abstract class Controller {
	
	
	public $route = [];
	public $view;
	public $layaout;
	public $data=[];

	
	public function __construct($route){
		
		$this->route = $route;
		$this->view = $route['action'];
// 2 - БАН
// 1 - АДМИН
// 3 - МОДЕРАТОР


// РАСПРЕДЕЛЕНЕ ПРАВ (ПОКА ПРОСТОЕ)

	//Если с сессией зашел в логин или на главную
		if (empty($_SESSION['ulogin']) && $route['controller'] != "Main"  && $route['controller'] != "User"  ){
				 redir('/');
	
		}
	//Если с сессией зашел в логин или на главную



	//Проверка на БАН
		if(!empty($_SESSION['ulogin']['woof']) && $_SESSION['ulogin']['woof'] == "2"){
			$_SESSION['ulogin'] = array();
			exit('Ваш аккаунт забанен. Обращайтесь в тех. поддержку');
		}
	//Проверка на БАН


//РАСПРЕДЕЛЕНИЕ ПРАВ НА АНДИНА
	if ($route['controller'] == "Admin"){

		
		if( empty($_SESSION['ulogin']['woof']) || $_SESSION['ulogin']['woof'] != "1" ){
				redir('/panel');
			
		}	



	}	
		
		
		
		
		
		
// РАСПРЕДЕЛЕНЕ ПРАВ (ПОКА ПРОСТОЕ)	




	}//КОНЕЦ КОНСТРУКТОРА

	
	
	public function getView(){

		$vObj = new View($this->route, $this->layaout, $this->view );
		
		$vObj->render($this->data);
		
	}
	
	public function set($data){
		$this->data = $data;	
	
	}


function isAjax ()
{
	if (
		isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
		&& $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") 
		return true;
	return false;
}




	
	
	
}

?>