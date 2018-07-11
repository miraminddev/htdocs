<?php
    header("Content-type: text/html; charset=utf-8");
//**********************************************
function complete_mail() {
    
    // функция корректировки полученных в _POST переменных
    function rightVar($Var){
        $Var = htmlspecialchars($Var);
        $Var = stripslashes($Var);
        $Var = trim($Var);
        return $Var;
    }
  if (isset($_POST['ok'])){	
		$name=$_POST['name'];
		$phone=$_POST['phone'];	
		$formname=$_POST['form-name'];	
	}
	
  $mess = "Клиент <b>$name</b>, телефон <b>$phone</b> ожидает обратный звонок";
	
    
    usleep(1500000);
    
    require_once('config_smtp.php');    
    require_once ('../phpmailer/PHPMailerAutoload.php');
    
    $mailer = new PHPMailer();
    //$mailer->IsSMTP();
    //$mailer->Host = $__smtp['host'];
    //$mailer->SMTPDebug  = $__smtp['debug'];
    //$mailer->SMTPAuth = $__smtp['auth'];
    //$mailer->Port = $__smtp['port'];
    //$mailer->Username = $__smtp['username'];
    //$mailer->Password = $__smtp['password']; 
    $mailer->addAddress($__smtp['to']);
   // $mailer->addAddress('nika.i.tima@gmail.com');
    $mailer->SetFrom($__smtp['username'], 'myagkiymir.uz');
    $mailer->IsHTML(true);
    $mailer->Subject = "$formname";
    $mailer->Body = $mess;
    if (!$mailer->Send()){
        echo var_dump($__smtp['address']);
        die ('Mailer Error: '.$mailer->ErrorInfo);
    } else {
        echo "Ваше сообщение отправлено";
    }
}

if (empty($_POST['js'])){   
    complete_mail();
}

  ?>