<?
require_once( '/home/bitrix/ext_www/zarabotat.money/lib/sendpulseInterface.php' );
require_once( '/home/bitrix/ext_www/zarabotat.money/lib/sendpulse.php' );
require "/home/bitrix/ext_www/zarabotat.money/lib/Rb.php";
$DB = require "/home/bitrix/ext_www/zarabotat.money/config/config_db.php";
\R::setup($DB['dsn'],$DB['user'],$DB['pass']);
\R::exec ("UPDATE contact SET status = '0' WHERE status = '1'");

function allring() {
	$date   = date("Y-m-d");
	$mass   = \R::getAll ("SELECT users_id FROM result WHERE date = ? AND status = 1 AND (type = 1 OR type = 2) GROUP BY users_id", [$date]);
	$ladder = [];
	$final  = [];
	foreach($mass as $row) {
		$totalresult = \R::count( 'result', 'WHERE users_id = ? AND date = ? AND status = 1 AND (type = 1 OR type = 2)', [$row['users_id'],$date]);
		$ladder[$row['users_id']] = $totalresult;
	}
	arsort($ladder);
	$i = 0;
	foreach($ladder as $key => $val) {
		$i++;
		if($i <= 5)
		{
			$userinfo = \R::findOne ( "users", "WHERE id = ?", [$key]);
			$final[$i]['totalresult'] = $val;
			$final[$i]['firstname'] = $userinfo['firstname'];
			$final[$i]['avatar'] = $userinfo['avatar'];
			$final[$i]['aboutme'] = $userinfo['aboutme'];
			$final[$i]['id'] = $userinfo['id'];
		}
	}
	return $final;
}
function sendmail($body,$mailto) {
	$SPApiProxy = new \SendpulseApi( 'e3a52b4091b34385f6b5fdaf2a25be3a', 'eddcae62eed298eafd63b1ea9b97744e', 'file' );
	$html = file_get_contents("/home/bitrix/ext_www/zarabotat.money/config/mailhtml.php");
	$html = str_replace("{ZAGOLOVOK}", "Здравствуйте!", $html);
	$html = str_replace("{CONTENT}", $body, $html);
	$html = str_replace("{FOOTER}", "С Уважением, ZARABOTAT.MONEY <br>Рабочий SKYPE-ЧАТ: <a href='https://join.skype.com/bHRgsYdFVPkh'>https://join.skype.com/bHRgsYdFVPkh</a><br>", $html);
	$email = array(
		'html'   => $html,
		'text'   => 'text',
		'subject'=> 'Пополнение баланса ZARABOTAT.MONEY',
		'from'    => array(
			'name' => 'info@zarabotat.money',
			'email'=> 'info@zarabotat.money'
		),
		'to'      => array(
			array(
				'name' => $mailto,
				'email'=> $mailto
			)
		),
	);
	$SPApiProxy->smtpSendMail($email);
}
function countCallbyDay() {
	$jobDayArr = \R::findAll("job", "WHERE day = ? ", [date("Y-m-d")]);
	foreach ($jobDayArr as $key => $jobDayRow) {
		$jobDayRow_pplArr = json_decode($jobDayRow['ppl'], JSON_UNESCAPED_UNICODE);
		foreach($jobDayRow_pplArr as $key => $jobDayRow_pplRow) {
			$countCallbyDay = \R::count('contact', 'WHERE users_id = ? AND datacall = ? AND status != 0', [$jobDayRow_pplRow,date("Y-m-d")]);
			$countLeadbyDay = \R::count('result', 'WHERE users_id = ? AND date = ? AND status = 1', [$jobDayRow_pplRow,date("Y-m-d")]);
			if(($countCallbyDay >= 150) && ($countLeadbyDay >= 1)) {
				$userMake150 = \R::getRow( "SELECT email, firstname, id FROM users WHERE id = ?", [$jobDayRow_pplArr[$key]]);
				$userMake150["countCall"] = $countCallbyDay;
				\R::exec ("INSERT INTO balancelog (id, idu, date, sum, comment) VALUES (NULL, ?, ?, '400', 'Бонус за 150 звонков')", [$userMake150['id'],date("Y-m-d")]);
				\R::exec ("UPDATE users SET balance = balance + '400' WHERE id = ?", [$userMake150['id']]);
				$mailto = $userMake150["email"];
				$textPisma_html = "Вы сегодня сделали <b>".$userMake150["countCall"]." звонков</b>. Ваш баланс увеличен на 400 рублей.<br>";
				sendmail($textPisma_html,$mailto);
			}
		}
	}
}
countCallbyDay();

$allring = allring();
foreach($allring as $key => $val)
{
	if($key == 1) {
		$money = '250';
		\R::exec ("
			INSERT INTO balancelog (id, idu, date, sum, comment)
			VALUES
			(NULL, '".$val['id']."', '".date("Y-m-d H:i:s")."', '".$money."', ' Бонус за кол-во звонков ');
		");
		\R::exec ("UPDATE users SET balance = balance + '".$money."' WHERE id = '".$val['id']."';");
	}
	if($key == 2) {
		$money = '100';
		\R::exec ("
			INSERT INTO balancelog (id, idu, date, sum, comment)
			VALUES
			(NULL, '".$val['id']."', '".date("Y-m-d H:i:s")."', '".$money."', ' Бонус за кол-во звонков ');
		");
		\R::exec ("
			UPDATE users SET balance = balance + '".$money."' WHERE id = '".$val['id']."';
		");
	}
	if($key == 3) {
		$money = '50';
		\R::exec ("
			INSERT INTO balancelog (id, idu, date, sum, comment)
			VALUES
			(NULL, '".$val['id']."', '".date("Y-m-d H:i:s")."', '".$money."', ' Бонус за кол-во звонков ');
		");

		\R::exec ("
			UPDATE users SET balance = balance + '".$money."' WHERE id = '".$val['id']."';
		");
	}
}

// ОЧИЩЕНИЕ joincompany от отказных заявок
$rez = \R::findAll("joincompany", "WHERE status=3");
foreach ($rez as $val){
	echo " ".$val['record']."<br> - УДАЛЕН ";	
	unlink("/home/bitrix/ext_www/zarabotat.money/temp_zayavki/".$val['record']."");
	\R::exec ("DELETE FROM joincompany WHERE id = ".$val['id']."");		
}
// ОЧИЩЕНИЕ joincompany от отказных заявок		
	
?>
