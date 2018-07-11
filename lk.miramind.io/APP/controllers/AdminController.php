<?

namespace APP\controllers;
use APP\models\Panel;


// АДМИН ДОСТУП


class AdminController extends AppController {
	public $layaout = 'PANEL';
	
	
	public function statAction(){
		$panel        = new Panel;
		$panelparams = $panel->panelparams();
		extract($panelparams);
		\APP\core\base\View::setMeta('АДМИНИСТРАТОР - Статистика '.NAME.' ','Панель управления','Панель управления');		
		$this->set(compact('count'));
	}
	
	
	
	public function ticketadminAction(){
		$panel        = new Panel;
		$panelparams = $panel->panelparams();
		extract($panelparams);
		\APP\core\base\View::setMeta('АДМИНИСТРАТОР - Список тикетов '.NAME.' ','Панель управления','Панель управления');		
		$ticket     = $panel->allticket();
		$massticket = $panel->massticket($ticket);
		if (count($ticket) == 0) $error = "Список результатов на модерации пуст";		
		$this->set(compact('balance','contact','perezvon','dorabotka', 'mycamcount', 'result', 'count','massticket'));
	}
	
	public function ticketviewadminAction(){
		$panel        = new Panel;
		$panelparams = $panel->panelparams();
		extract($panelparams);
		\APP\core\base\View::setMeta('АДМИНИСТРАТОР - Просмотр тикета '.NAME.' ','Панель управления','Панель управления');		
		if(!isset($_GET['ticket'])){
			$error = "Ошибка в адресе";
		}else{
			$idticket = $_GET['ticket'];
		}
		if (isset($idticket)) {
			$ticket = $panel->showticketadmin($idticket);}
		if(!$ticket) $error = "Такого тикета не существует";	
		$idparrent = $ticket['id'];
		$subji = $panel->subjiadmin($idparrent);
		$this->set(compact('balance','contact','perezvon','dorabotka', 'mycamcount','error', 'ticket', 'subji','idparrent', 'count' ));
	}




}
?>