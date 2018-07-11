<?

namespace APP\controllers;
use APP\models\Main;
use APP\models\Panel;
use APP\core\Cache;




class MainController extends AppController {
	
	public $layaout = 'MAIN';

	public function indexAction(){
	   
	   
	   
		
\APP\core\base\View::setMeta('MIRAMIND - Next generation of Artificial Intelligence' );	


//ЕСЛИ ЧЕЛОВЕК ЗАЛОГИНЕН
		if(isset($_SESSION['ulogin']['id'])) redir("/panel");	 
//ЕСЛИ ЧЕЛОВЕК ЗАЛОГИНЕН

		
			 
 		// ПЕРЕДАЧА ДАННЫХ
		$this->set(compact(''));
		// ПЕРЕДАЧА ДАННЫХ
		
		
	}



	
	
	
	
}




?>