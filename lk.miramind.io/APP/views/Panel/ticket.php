<div class="row">
  <div class="col-md-6">
  
<div class="panel panel-default">
  
  <!-- Table -->
  <table class="table">
    
    	<tr>
    	<td><b>Номер</b></td>
		<td><b>Тема</b></td>
		<td><b>Ответов</b></td>
		<td><b>Статус</b></td>
	</tr>
	
	
	<?
//show($ticket);	



	
foreach ($massticket as $key=>$row){
	
	
	
if ($row['status']=='1'){
	$status = "ОТКРЫТ";
$close = "";
}

if ($row['status']=='2'){
	 $status = "ЗАКРЫТ";
	 $close = "class='active'";
	}


$idt = $key;

if ($row['new'] >=1) $zag='<span class="label label-danger">Сообщение</span>'; else $zag='';




echo "

    	<tr $close> 
    	<td>#".$key."</td>
		<td><a href='/panel/ticketview/?ticket=".$key."/'> ".$row['subj']." </a> $zag</td>
		<td>".$row['colmes']."</td>
		<td>".$status."</td>
		
		
	</tr>

";





}
	


?>
	
	
	
	
	
	

  </table>
</div>


</div>
  <div class="col-md-6">
  	
  	
  	  <b>Открыть новый тикет</b>
<p>Тема:
<br><input class="form-control" size="90" maxlength="100" type="text" placeholder="Вопрос" id="zagolovok" required="required"></p>
<p>Вопрос:<br>
<textarea  class="form-control" placeholder="Сообщение" id="message" cols=100 rows=7 required="required" ></textarea></p>

<p><button class="btn btn-primary" onclick="post_ticket()" >Открыть тикет</button></p>
  	
  </div>
</div>

