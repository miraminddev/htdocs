<div class="row">
<div class="col-md-6">
	
	
	<div class="panel panel-default">
<div class="panel-heading"><b><?=$ticket['subj']?></b></div>

<?
	$userinfo = \R::findOne("users", "WHERE id = ?",[$ticket['idu']]);
	$avt = $userinfo['firstname']; 
?>

<div class="alert alert-info">
#<?=$ticket['idu']?>=<b><?=$avt?></b><br><?=$ticket['message']?> </div>
                                                            
                                                            
<?



foreach ($subji as $row) {
	
	if 	($row['idu']==$ticket['idu'])
	{
		$author = $avt;

	}

	
	
	else {

		$author = "АДМИНИСТРАЦИЯ";
	}
	
	
echo "  <b>$author</b><br>".$row['message']." ";


echo "<hr>";

}
?>




  
  </div>
  
  
  </div>
  
  
  
<?
if ($ticket['status']==1){
	echo '
<div class="col-md-6">
 <b>Ответить</b>
<p><textarea class="form-control"  placeholder="Сообщение" id="message" cols=80 rows=5 required="required" ></textarea></p>
<p><input class="form-control" type="hidden" value="'.$idparrent.'" id="idt"></p>
<p><button class="btn btn-primary" onclick="post_ticket_answer()" >Написать ответ</button> | <button class="btn btn-success" onclick="post_close_ticket_admin()" >Закрыть тикет</button> | <button class="btn btn-danger" onclick="history.back();return false;" >Назад</button></p>
  </div>
   
';
} else{
	
	echo '
	
	<div class="col-md-6">
<h2>ТИКЕТ ЗАКРЫТ</h2>
<p><button class="btn btn-danger" onclick="history.back();return false;" >Назад</button></p>
  </div>
	
	';
	
}





?>



  

</div>