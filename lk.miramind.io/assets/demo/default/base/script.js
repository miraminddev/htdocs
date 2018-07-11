// let asdf = $('#amount_sum').text();
//   asdf = asdf.replace(/(\d{1,3})(?=((\d{3})*([^\d]|$)))/g, " $1 ");
//     $('#amount_sum').html(asdf);
//

$(document).ready(function() {
  let x;
  let sum = $('#amount_sum').text();
    // sum = Number.parseInt(sum.replace(/\D/g, ''));

    x = sum/20000;

    $('.progress-bar').css('width', x + "%");

    let y = x.toFixed(1);
    $('#perc').text(y + '%');
      if (y >= 60) {
        $('#amount_recieved').css('color','#fff');
      }

});
// калькулятор ЭФИР  - МИРА

$('#eth_input').keyup(function(){
    let eth = $('#eth_input').val();
    if (eth > 0) {
       $('#mira_input').val(eth * 100000);
       $('#eth_amount').text(eth);
    } else {
      $('#mira_input').val(0);
    }
});

$('#mira_input').keyup(function(){
  let mira = $('#mira_input').val();
  if (mira > 0) {
     $('#eth_input').val(mira / 100000);
     $('#eth_amount').text(mira / 100000);
  } else {
    $('#eth_input').val(0);
  }
});




$('#buy_mira').click(function(){
  $('.payment_method').fadeIn();
})

$('#close_payment').click(function(){
  $('.check_transaction').fadeIn();
})
