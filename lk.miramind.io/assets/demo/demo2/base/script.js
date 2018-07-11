// let asdf = $('#amount_sum').text();
//   asdf = asdf.replace(/(\d{1,3})(?=((\d{3})*([^\d]|$)))/g, " $1 ");
//     $('#amount_sum').html(asdf);
//

$.validate({
  form: '#verify_form, #tab_1_3',
  modules : 'date, security'
});

$(window).on('load', function () {
    var $preloader = $('.loading');
    //     $svg_anm   = $preloader.find('.svg_anm');
    // $svg_anm.fadeOut();
    $preloader.fadeOut('slow');
});

let miraJune = $('#mira_june').text();
$('#mira_rate').text(miraJune);

var today = new Date();
$('#now_date').text(today.toLocaleDateString());

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
// калькулятор ЭФИР  - МИРА id="eth_price"

$('#eth_input').keyup(function(){
    let eth = $('#eth_input').val();
    let ethRate = $('#eth_price').text();
    if (eth > 0) {
       $('#mira_input').val((eth * (ethRate * 100)).toFixed(2));
       $('#eth_amount').text(eth);
    } else {
      $('#mira_input').val(0);
    }
});

$('#mira_input').keyup(function(){
  let mira = $('#mira_input').val();
  let ethRate = $('#eth_price').text();
  if (mira > 0) {
     $('#eth_input').val((mira / (ethRate * 100)).toFixed(2));
     $('#eth_amount').text((mira / (ethRate * 100)).toFixed(2));
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


$('#crypto_instructions').click(function (){
  $('#insturct_hidden').fadeIn();
})

$('#close_instructions').click(function (){
  $('#insturct_hidden').fadeOut();
})
