<?
namespace APP\controllers;
use APP\core\Cache;
use APP\models\Panel;
use APP\models\Project;
use APP\models\Add;


// ЛИЧНЫЙ КАБИНЕТ

class PanelController extends AppController {
	public $layaout = 'PANEL';
	
	public function indexAction() {
		//ЗАГРУЗКА БАЗОВЫХ ПАРАМЕТРОВ
		$panel = new Panel;
		/*
		$panelparams = $panel->panelparams();
		extract($panelparams);
		*/   
    
//$ab = curlJSONget("https://api.coinmarketcap.com/v2/ticker/");

		$rates = $panel->rates();





//$_SESSION['ulogin']['woof'] = 1;
//show($_SESSION['ulogin']);


		\APP\core\base\View::setMeta('BETA - ' . NAME . ' ');

		$this->set(compact('count','rates'));
		// ПЕРЕДАЧА ДАННЫХ
		
	}
	

	



		
	
	
	
	
	public function ticketAction() {
		//ЗАГРУЗКА БАЗОВЫХ ПАРАМЕТРОВ
		$panel = new Panel;
		$panelparams = $panel->panelparams();
		extract($panelparams);
		$razdel = "Тикеты";
				
		//ЗАГРУЗКА БАЗОВЫХ ПАРАМЕТРОВ
		$ticket = $panel->ticket($iduser);
		$massticket = $panel->massticket($ticket);
		// ПЕРЕДАЧА ДАННЫХ
		$this->set(compact('razdel', 'massticket'));
		// ПЕРЕДАЧА ДАННЫХ
		
	}
	public function ticketviewAction() {
		//ЗАГРУЗКА БАЗОВЫХ ПАРАМЕТРОВ
		$panel = new Panel;
		$panelparams = $panel->panelparams();
		extract($panelparams);
		$razdel = "Тикеты";

		
		
		//ЗАГРУЗКА БАЗОВЫХ ПАРАМЕТРОВ
		if (!isset($_GET['ticket'])) {
			$error = "Ошибка в адресе";
		}
		else {
			$idticket = $_GET['ticket'];
		}
		if (isset($idticket)) {
			$ticket = $panel->showticket($iduser, $idticket);
		}
		if (!$ticket) $error = "Такого тикета не существует";
		$idparrent = $ticket['id'];
		$subji = $panel->subji($idparrent);
		// ПЕРЕДАЧА ДАННЫХ
		$this->set(compact('razdel', 'error', 'ticket', 'subji', 'idparrent'));
		

		// ПЕРЕДАЧА ДАННЫХ
		
	}


	public function profileAction() {
		//ЗАГРУЗКА БАЗОВЫХ ПАРАМЕТРОВ
		$panel = new Panel;
		$panelparams = $panel->panelparams();
		extract($panelparams);
		$razdel = "Профиль";

		//ЗАГРУЗКА БАЗОВЫХ ПАРАМЕТРОВ
		\APP\core\base\View::setMeta('BETA - ' . NAME . ' ');
		// ПЕРЕДАЧА ДАННЫХ
		$this->set(compact('razdel'));
		// ПЕРЕДАЧА ДАННЫХ
		
	}
	


	public function refferalAction() {
		//ЗАГРУЗКА БАЗОВЫХ ПАРАМЕТРОВ
		$panel = new Panel;
		$panelparams = $panel->panelparams();
		extract($panelparams);
		$razdel = "Referral program";

		//ЗАГРУЗКА БАЗОВЫХ ПАРАМЕТРОВ
		\APP\core\base\View::setMeta('BETA - ' . NAME . ' ');
		// ПЕРЕДАЧА ДАННЫХ
		$this->set(compact('razdel'));
		// ПЕРЕДАЧА ДАННЫХ
		
	}



	public function myinvestAction() {
		//ЗАГРУЗКА БАЗОВЫХ ПАРАМЕТРОВ
		$panel = new Panel;
		$panelparams = $panel->panelparams();
		extract($panelparams);
		$razdel = "My investments";

		//ЗАГРУЗКА БАЗОВЫХ ПАРАМЕТРОВ
		\APP\core\base\View::setMeta('BETA - ' . NAME . ' ');
		// ПЕРЕДАЧА ДАННЫХ
		$this->set(compact('razdel'));
		// ПЕРЕДАЧА ДАННЫХ
		
	}
	
	
	

	public function verificationAction() {
		//ЗАГРУЗКА БАЗОВЫХ ПАРАМЕТРОВ
		$panel = new Panel;
		$panelparams = $panel->panelparams();
		extract($panelparams);
		$razdel = "Help";

		//ЗАГРУЗКА БАЗОВЫХ ПАРАМЕТРОВ
		\APP\core\base\View::setMeta('BETA - ' . NAME . ' ');
		// ПЕРЕДАЧА ДАННЫХ
		$this->set(compact('razdel'));
		// ПЕРЕДАЧА ДАННЫХ
		
	}
	
	
	
	public function helpAction() {
		//ЗАГРУЗКА БАЗОВЫХ ПАРАМЕТРОВ
		$panel = new Panel;
		$panelparams = $panel->panelparams();
		extract($panelparams);
		$razdel = "Help";

		//ЗАГРУЗКА БАЗОВЫХ ПАРАМЕТРОВ
		\APP\core\base\View::setMeta('BETA - ' . NAME . ' ');
		// ПЕРЕДАЧА ДАННЫХ
		$this->set(compact('razdel'));
		// ПЕРЕДАЧА ДАННЫХ
		
	}
	

	public function contactAction() {
		//ЗАГРУЗКА БАЗОВЫХ ПАРАМЕТРОВ
		$panel = new Panel;
		$panelparams = $panel->panelparams();
		extract($panelparams);
		$razdel = "Contact";

		//ЗАГРУЗКА БАЗОВЫХ ПАРАМЕТРОВ
		\APP\core\base\View::setMeta('BETA - ' . NAME . ' ');
		// ПЕРЕДАЧА ДАННЫХ
		$this->set(compact('razdel'));
		// ПЕРЕДАЧА ДАННЫХ
		
	}
	
	
		
	
		
			
	
	
			


	
	
	
	
}
?>
