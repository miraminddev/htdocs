
$.validate({
  form: '#private_sale_form',
  modules : 'date, security'
});

function colorImage1(x){
  x.src = x.src.replace("main", "active");
};

function colorImage2(y){
  y.src = y.src.replace("active", "main");
};


$('#form_input').blur(function() {
  var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,6}\.)?[a-z]{2,6}$/i;
  if($(this).val() && !pattern.test($(this).val())) {
    $('#valid').text('Incorrect e-mail ! Try again !').css({'color':'red','opacity':'1'});
    $('#sub_btn').attr('disabled','disabled');
  } else {
    if(pattern.test($(this).val())) {
      $('#valid').text('Correct !').css({'color':'#00ff53','opacity':'1'});
    }
    if ($('#valid').text() == 'Correct !') {
      $('#sub_btn').removeAttr('disabled','disabled');
      $('#sub_btn').attr({'data-target':'#offerTyModal','data-toggle':'modal'});

    }
  }
});

$('#sub_btn').click(function(){
  if ($('#valid').text() == 'Correct !') {

  	var mail = $("#form_input").val();

    $('#form_input').val('Thank you!').attr('disabled','disabled');
    $('#valid').css('opacity','0');



    var str = '&mail=' + mail + '&type=podpiska';
     $.ajax (
    {
      url : '/send-mail.php',
      type: 'POST',
      data: str,
      cache: false,
      success: function( result ) {

    //    alert(result);


      }
    })
  } else{
  	    $('#valid').text('Incorrect e-mail ! Try again !').css({'color':'red','opacity':'1'});

  }



});


$('#sub_btn2').click(function(){


  	var mail = $("#private_mail").val();
    var name = $("#private_name").val();
    var phone = $("#private_phone").val();

    var str = '&mail=' + mail + '&name=' + name + '&phone=' + phone + '&type=forma';
   // alert(str);
    
     $.ajax (
    {
      url : '/send-mail.php',
      type: 'POST',
      data: str,
      cache: false,
      success: function( result ) {
      	alert(result);
      }
    })

});
