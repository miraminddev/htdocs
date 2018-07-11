<?

// ПУТЬ ДО САЙТА / home / bitrix / ext_www / zarabotat.money /
$ADR = "/home/bitrix/ext_www/ftizer";

//Подключение к БД
require $ADR."/lib/Rb.php";
$DB = require $ADR."/config/config_db.php";
\R::setup($DB['dsn'],$DB['user'],$DB['pass']);
//Подключение к БД

//ОЧИСТКА ТЕМПОВЫХ ФАЙЛОВ
    if (file_exists($ADR.'/temp/')) {
        foreach (glob($ADR.'/temp/*') as $file) {
            unlink($file);
        }
    }
 //ОЧИСТКА ТЕМПОВЫХ ФАЙЛОВ
 
    
    
    
		// ЗАПУСК КРОНА В 19:00 ТОРМОЗ КОМПАНИИ ПО ВРЕМЕНИ
		$companies = \R::findAll("company", "WHERE status !=2 AND timecall = 'standart' "); //БЕРЕМ ВСЕХ КОТОРЫЕ НЕ НА СТОПЕ
		foreach($companies as $key=>$val)
		{
			\R::exec ("UPDATE `company` SET `status` = '4' WHERE `id` = '".$val['id']."' ");
			
		}
		
		

?>
