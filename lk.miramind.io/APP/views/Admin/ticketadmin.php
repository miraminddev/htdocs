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
		<td><a href='/admin/ticketviewadmin/?ticket=".$key."/'> ".$row['subj']." </a> $zag</td>
		<td>".$row['colmes']."</td>
		<td>".$status."</td>
		
		
	</tr>

";





}
	


?>
	
	
	
	
	
	

  </table>
</div>


</div>

</div>

