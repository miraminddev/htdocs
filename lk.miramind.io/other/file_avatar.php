<?php
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
$urlnew = "temp_load/".$name.".jpg";
imagejpeg ($image_p ,$urlnew, 100); // Сохраняем




//	copy($_FILES['img']['tmp_name'], $urlnew); // Копируем из общего котла в тизерку
	$name = trim($name);
	
	echo $name;


  	
  	} else{
		
		
		 	echo "200x200.jpg";
		 	
	}
  	
 

  
?>
 