<?php
namespace APP\controllers;
use APP\models\Wform;
use APP\models\Panel;
use APP\core\Cache;

class WformController extends AppController {

	public function indexAction(){
		if($this->isAjax()){
			$data = $_POST;
			$wform = new Wform;

			//ЮЗЕР
			if (isset($_POST['changeprofile_f'])) $wform->changeprofile($data);
			if (isset($_POST['new_ticket_f'])) $wform->new_ticket($data);
			if (isset($_POST['upl_f'])) $wform->upl($data);
			if (isset($_POST['changepass_f'])) $wform->changepass($data);
			if (isset($_POST['post_close_ticket_f'])) $wform->post_close_ticket($data);
			if (isset($_POST['post_ticket_answer_f'])) $wform->post_ticket_answer($data);
			if (isset($_POST['post_wal_f'])) $wform->post_wal($data);	
			//ЮЗЕР



			//АДМИНСКИЕ ФУНКЦИИ
			if (isset($_POST['post_close_ticket_admin_f'])) $wform->post_close_ticket_admin($data);
			//АДМИНСКИЕ ФУНКЦИИ
					
					
					
					
			
		} else{
			echo "Запрос не AJAX";
		}
		$this->layaout = false;
	}


// ТУТ ФУНКЦИЯ ПО ЗАКАЧКИ ФАЙЛОВ

// ФУНКЦИЯ ПО ЗАКАЧКЕ ФАЙЛОВ




//Смена аватара
	public function fileawatarAction(){
		if($this->isAjax()){
			$this->layaout = false;
			if($_FILES['img']['size']>0) {
				if ($_FILES['img']['size'] > 500000) {
					echo "1";
					exit();
				}
				if ($_FILES['img']['size'] < 5000) {
					echo "2";
					exit();
				}
				if ($_FILES['img']['type'] != "image/jpeg") {
					echo "3";
					exit();
				}
				$imageinfo = getimagesize($_FILES['img']['tmp_name']);
				if($imageinfo['mime'] != 'image/jpeg') {
					echo "3";
					exit;
				}
				$blacklist = array(".php", ".phtml", ".php3", ".php4");
				foreach ($blacklist as $item) {
					if(preg_match("/$item\$/i", $_FILES['img']['name'])) {
						echo "4";
						exit;
					}
				}
				$src = imagecreatefromjpeg($_FILES['img']['tmp_name']);
				$w_src = imagesx($src);
				$h_src = imagesy($src);
				// Подгоняем под 200 на 200
				$image_p = imagecreatetruecolor(300, 300); // Создаем изображение
				imagecopyresampled($image_p, $src, 0, 0, 0, 0, 300, 300, $w_src, $h_src);
				// Подгоняем под 200 на 200
				$name = md5(uniqid(rand(),1));
				$urlnew = WWW."/temp/".$name.".jpg";
				imagejpeg($image_p ,$urlnew, 100); // Сохраняем
				$name = trim($name);
				echo $name;
			} else {
				echo "200x200.jpg";
			}
		} else {
			echo "Запрос не AJAX";
		}
	}
	

//Смена аватара
	
	

	public function sbrosAction(){
		$this->layaout = false;
		$wform = new Wform;
		
				
		$mails = file_get_contents("mails.log");
		$mails = explode("\n", $mails);
		$summa = file_get_contents("summa.log");
		$summa = explode("\n", $summa);
		
		foreach ($summa as $key => $val){
			$mail = $mails[$key];
			$eth = $summa[$key];
			$kurs = 540;
			$usd = $summa[$key]*$kurs;
			$token = $usd/0.01; // Без бонуса
			$token = round($token);			
			$tokenb = $token + ($token/100*50); // Без бонуса			
			$tokenb = round($tokenb);
			
			$pass = random_str(15);

		$mass['email'] = $mail;
		$mass['pass'] = $pass;
		$mass['token'] = $token;
		$mass['tokenb'] = $tokenb;
		$mass['usd'] = $usd;	
		$mass['eth'] = $eth;
		
					
		$wform->saveuser($mass);
			

			
		}
		




		
				
		
		
		
	}
}
?>