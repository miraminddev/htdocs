<?php
namespace APP\models;
use APP\core\Cache;
class Panel extends \APP\core\base\Model {



// БАЗОВЫЕ ФУНКЦИИ

// ДАННЫЕ КОТОРЫЕ ВЕШАЕМ В КОНТРОЛЛЕР
	public function panelparams() {
		$panelparams['iduser'] = $_SESSION['ulogin']['id'];
		$panelparams['user'] = $this->loaduser('users', $panelparams['iduser']);
		
		if (isset($_SESSION['ulogin']['woof']) && $_SESSION['ulogin']['woof'] == "1") {
			
			//ИЗВЛЕКАТЬ ДАННЫЕ ДЛЯ АДМИНА ЕСЛИ НАДО
			//$panelparams['count'] = $this->moderatecount();
			
			
		}
		return $panelparams;
	}
// ДАННЫЕ КОТОРЫЕ ВЕШАЕМ В КОНТРОЛЛЕР	
	
// БАЗОВЫЕ ФУНКЦИИ	

		


// ТИКЕТЫ НАЧАЛО	
	
	public function subjiadmin($parrentid) {
		$subji = \R::findAll('ticket', 'WHERE parent = ?', [$parrentid]);
		\R::exec(" UPDATE ticket SET see = '2' WHERE parent = '" . $parrentid . "'; ");
		return $subji;
	}
	
	public function subji($parrentid) {
		$subji = \R::findAll('ticket', 'WHERE parent = ?', [$parrentid]);
		\R::exec(" UPDATE ticket SET see = '2' WHERE parent = '" . $parrentid . "'; ");
		return $subji;
	}



	public function rates() {
			
			foreach((array)json_decode(@file_get_contents('https://api.coinmarketcap.com/v1/ticker/?limit=50'), true) as $v) {
				if(in_array($k = strtolower($v['symbol']), ['eth', 'btc', 'bch', 'btg', 'dash', 'etc','ltc'])) {
					$rates[$k] = (double)$v['price_usd'];
				}
			}
			return $rates;
	}
	
	
 

			


	
			
	
		
	public function showticket($iduser, $idticket) {
		$showticket = \R::findOne('ticket', 'WHERE id = ? AND idu =? AND parent =1', [$idticket, $iduser]);
		return $showticket;
	}
	public function showticketadmin($idticket) {
		$showticket = \R::findOne('ticket', 'WHERE id = ? AND parent =1', [$idticket]);
		return $showticket;
	}
	
	public function massticket($ticket) {
		$massticket = [];
		foreach ($ticket as $key => $val) {
			if ($val['parent'] == 1) {
				$massticket[$key]['status'] = $val['status'];
				$massticket[$key]['subj'] = $val['subj'];
				$massticket[$key]['new'] = \R::count('ticket', 'parent = ? AND see = 1', [$key]);
				$massticket[$key]['colmes'] = \R::count('ticket', 'parent = ?', [$key]);
			}
		}
		return $massticket;
	}		


	public function ticket($iduser) {
		$ticket = \R::find('ticket', 'WHERE idu = ? ORDER BY  status, id  DESC', [$iduser]);
		return $ticket;
	}

	public function allticket() {
		$ticket = \R::find('ticket', 'ORDER BY  status, id  DESC');
		return $ticket;
	}


	
// ТИКЕТЫ КОНЕЦ
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
// КОНЕЦ КЛАССА	
	
}
?>
