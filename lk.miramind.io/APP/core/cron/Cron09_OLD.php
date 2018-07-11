<?


// ПУТЬ ДО САЙТА / home / bitrix / ext_www / zarabotat.money /
//Подключение к БД
require "/home/bitrix/ext_www/zarabotat.money/lib/Rb.php";
$DB = require "/home/bitrix/ext_www/zarabotat.money/config/config_db.php";
\R::setup($DB['dsn'],$DB['user'],$DB['pass']);
//Подключение к БД


function datetoday($date){
$date=explode("-", $date);
$day = date("w", mktime(0, 0, 0, $date[1], $date[2], $date[0]));
return $day;
}




		// ЗАПУСК ВСЕХ ПРОЕКТОВ В 09:00
		$companies = \R::findAll("company", "WHERE status !=2"); //БЕРЕМ ВСЕХ КОТОРЫЕ НЕ НА СТОПЕ
		foreach($companies as $key=>$val)
		{
			
			
			//ПРОВЕРИМ ДНИ НЕДЕЛИ ЕСЛИ НЕ ПРОХОДИТ, ТО СТОПАЕМ СО СТАТУСОМ 3
			$segonda = datetoday(date("Y-m-d"));
			$dni     = json_decode($val['dni'], JSON_UNESCAPED_UNICODE);

			if( ($segonda == 1) ){
				if ($dni['PN'] == "on"){
					$zapusk['dni'][$val['id']] = true;
				} else{
					\R::exec ("UPDATE `company` SET `status` = '3' WHERE `id` = '".$val['id']."' ");
				}
			}

			if( ($segonda == 2) ){
	
				if ($dni['VT'] == "on"){
					$zapusk['dni'][$val['id']] = true;
				} else{
					\R::exec ("UPDATE `company` SET `status` = '3' WHERE `id` = '".$val['id']."' ");
				}
			}
			
			if( ($segonda == 3) ){
	
				if ($dni['SR'] == "on"){
					$zapusk['dni'][$val['id']] = true;
				} else{
					\R::exec ("UPDATE `company` SET `status` = '3' WHERE `id` = '".$val['id']."' ");
				}
			}
			
			if( ($segonda == 4) ){
	
				if ($dni['CHT'] == "on"){
					$zapusk['dni'][$val['id']] = true;
				} else{
					\R::exec ("UPDATE `company` SET `status` = '3' WHERE `id` = '".$val['id']."' ");
				}
			}
			
			if( ($segonda == 5) ){
	
				if ($dni['PT'] == "on"){
					$zapusk['dni'][$val['id']] = true;
				} else{
					\R::exec ("UPDATE `company` SET `status` = '3' WHERE `id` = '".$val['id']."' ");
				}
			}

			if( ($segonda == 6) ){
	
				if ($dni['SB'] == "on"){
					$zapusk['dni'][$val['id']] = true;
				} else{
					\R::exec ("UPDATE `company` SET `status` = '3' WHERE `id` = '".$val['id']."' ");
				}
			}			

			if( ($segonda == 0) ){
				if ($dni['VS'] == "on"){
					$zapusk['dni'][$val['id']] = true;
				} else{
					\R::exec ("UPDATE `company` SET `status` = '3' WHERE `id` = '".$val['id']."' ");
				}
			}
		// ПРОВЕРИМ НА ДНИ НЕДЕЛИ



// ПРОВЕРЯЕМ НА ДОСТУПНОСТЬ БАЛАНСА
		$zapusk['bal'][$val['id']] = false;
		$client      = \R::findOne("client", "WHERE `id` = ?", [$val['client_id']]);
		$balance     = $client['bal'];
		$needbalance = $val['cfc'];
		if(($balance >= $needbalance)) 	$zapusk['bal'][$val['id']] = true;
// ПРОВЕРЯЕМ НА ДОСТУПНОСТЬ БАЛАНСА			


			
			if( ($zapusk['bal'][$val['id']] === true) && ($zapusk['dni'][$val['id']] === true )) {
			\R::exec ("UPDATE `company` SET `status` = '1' WHERE `id` = '".$val['id']."' ");
			}
			
			
			if ($zapusk['bal'][$val['id']] === false){
							\R::exec ("UPDATE `company` SET `status` = '2' WHERE `id` = '".$val['id']."' ");
			}  
			
			

		}








//	file_put_contents(' / home / bitrix / ext_www / zarabotat.money / log.log', var_export($a, true));


?>
