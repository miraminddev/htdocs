<?php
  if($_FILES['csv']['size']>0) {
  	  dumpf($_FILES['csv']);
  	  
		if ($_FILES['csv']['size'] > 5000000) {
			echo "1";
			exit();
		}


		if ($_FILES['csv']['size'] < 500) {
			echo "2";
			exit();
		}
		
		
		if ($_FILES['csv']['type'] != "application/octet-stream") {

			
			echo "3";
			exit();

			
		}




  $blacklist = array(".php", ".phtml", ".php3", ".php4");
 foreach ($blacklist as $item) {
  if(preg_match("/$item\$/i", $_FILES['csv']['name'])) {
   echo "4";
   exit;
   }
  }
  
if(!preg_match("/.csv\$/i", $_FILES['csv']['name'])) {
   echo "4";
   exit;
	}
 
	

$name = md5(uniqid(rand(),1));

	$urlnew = "temp_load/".$name.".csv";
	copy($_FILES['csv']['tmp_name'], $urlnew); // Копируем из общего котла в тизерку

	$name = trim($name);
	
	echo $name;


  	
  	} else{
		
		
		 	echo "200x200.jpg";
		 	
	}
  	
 

  
?>
 