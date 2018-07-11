<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
	integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous"/>
  <link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/theme-default.min.css"
  rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="css/style.css?<?=rand(1,99999999)?>">
  <link rel="stylesheet" href="css/style_new.css?<?=rand(1,99999999)?>">
  <title>MIRAMIND - Next generation of Artificial Intelligence</title>
</head>
<body>

  <div class="modal fade" id="offerTyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel3">Thank You!</h5>
        </button>
      </div>
      <div class="modal-body" style="text-align: center">
          <h4>We will contact you shortly!</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-hex btn-secondary" data-dismiss="modal"><p>Close</p></button>
      </div>
    </div>
  </div>
  </div>

  <div class="modal fade" id="private_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel3">Enter your E-mail, Name and Phone number below</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body" style="text-align: center">
        <form id="private_sale_form">
          <input id="private_name" class="modal_input" type="text" name="" value="" placeholder="Name *" data-validation="length alphanumeric"
		 data-validation-length="3-12"
		 data-validation-error-msg="User name has to be an alphanumeric value (3-12 chars)" required>
          <input id="private_phone" class="modal_input" type="text" name="" value="" placeholder="Phone number *" required>
          <input id="private_mail" class="modal_input" type="email" name="" value="" placeholder="E-mail *" data-validation="email" required>
        </form>
      </div>
      <div class="modal-footer">
        <button id="sub_btn2" type="button" class="btn-hex btn-secondary" data-dismiss="modal" data-target='#offerTyModal' data-toggle='modal'><p>Send</p></button>
        <button id="sub_btn3" type="button" class="btn-hex btn-secondary" data-dismiss="modal" ><p>Close</p></button>
      </div>
    </div>
  </div>
  </div>

<div class="wrapper">
  <div class="container text-center">
  <div class="title_block">
    <h1><span class="top-h1">miramind</span> <br><span class="artificial_title">global intelligence</span></h1>
    <!-- <span class="title_p">the future generation in artificial intelligence</span> -->
  </div>
  <div class="row soti text-center">
    <div class="personal">
      <div class="info">
        <img class="big top" src="img/openaiapi.png" alt="">
      </div>
    </div>
    <div class="enterprise">
      <div class="info">
        <img class="big bottom" src="img/computingpower.png" alt="">
      </div>
    </div>
  </div>
  <div class="row soti-small text-center">
    <div class="m2m">
      <div class="info">
        <img class="small" src="img/datalab.png" alt="">
      </div>
    </div>
    <div class="virtual">
      <div class="info">
        <img class="small" src="img/aistore.png" alt="">
      </div>
    </div>
  </div>
    <div class="row bottom1 text-center">
      <div class="bottom_sale">
      <div class="sale">
        <h2>coming soon...</h2>
        <!-- <div id="timer" class="time"></div>
        <div class="timer_info">
          <p>days</p>
          <p>hours</p>
          <p>minutes</p> <a href="" id="get-offer" class="btn sale-btn" data-target="#offerModal" data-toggle="modal"><span>GET OFFER</span></a>
          <p>seconds</p>
        </div> -->
        <div class="sub_form">
          <span class="sub_text">Subscribe to our newsletter</span>
          <form id="subscribe">
            <label><input id="form_input" type="email" placeholder="Your e-mail" required></label>
            <div id="valid">...</div>
            <button type="button" id="sub_btn" class="btn-hex">
              <p class="form_span">JOIN</p>
            </button>
          </form>
      </div>

      <div class="row private_sale_btn">
        <div class="col-12" style="padding-bottom: 20px">
          <button type="button" id="sub_btn" class="btn-hex2" style="" data-target='#private_modal' data-toggle='modal'>
            <p class="form_span private_span" style="font-size: 1.5em">take part in private sale</p>
          </button>
        </div>
      </div>

      <!-- <div class="m-form__actions m-form__actions--solid">
                     <div class="row justify-content-center">
                       <div class="col-12 text-center">
                         <br>
                         <div class="b-paytx__sub-title">
                              <b><span style="font-size: 1.5em;">MIRAMIND Private Sale Address:</span></b><br>
                             <p id="pay_code" style="color: #059ddd; word-break: break-all; font-size: 1.5em">0xE643B894e4918d4624293bd9ec86BA32a8c43c52</p> &nbsp;
                              <div class="eth_summ" style="padding-top: 30px">
                                <b><span style="font-size: 1.5em;">MIRAMIND Token Address (to show up in your wallet):</span></b> <br>
                                <span style="color: #059ddd; word-break: break-all; font-size: 1.5em">0x8bcd8dafc917bfe3c82313e05fc9738aeb72d555</span> &nbsp;
                              </div>
                              <div>
                             </div>
                          </div>
                         </div>
                        </div>
                    </div>
                    <br> -->
        <div class="socials">
        <div class="social">
          <a id="tlg" class="soc" href="http://t.me/miramind" target="_blank">
            <!-- <img class="main" src="img/telegram_main_icon.png" alt="telegram"> -->
          </a>
        </div>
        <div class="social">
          <a id="fb" class="soc" href="https://www.facebook.com/Miramind.io/" target="_blank">
            <!-- <img id="fb" class="main" src="img/facebook_main_icon.png" alt="facebook"> -->
          </a>
        </div>
        <div class="social">
          <a id="inst" class="soc" href="https://www.instagram.com/miramind.io/" target="_blank">
            <!-- <img class="main" src="img/insta_main_icon.png" alt="instagram"> -->
          </a>
        </div>
      </div>
      </div>
    </div>
    </div>
    <div class="row text-center">
        <div class="logo">
          <img src="img/mira_bottom_logo.png" alt="miramind-logo">
          <p>miramind</p>
        </div>
    </div>
    <div class="row coockies text-center">
      <div class="col-4 col-md-4">
        <a href="cookie_disclaimer.pdf" target="_blank">Cookie disclaimer</a>
      </div>
      <div class="col-4 col-md-4">
        <a href="terms_of_use.pdf" target="_blank">Terms of Use</a>
      </div>
      <div class="col-4 col-md-4">
        <a href="user_agreement.pdf" target="_blank">User Agreement</a>
      </div>
    </div>
  </div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>



<script src="js/script.js"></script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119234043-1"></script>
<script>
 window.dataLayer = window.dataLayer || [];
 function gtag(){dataLayer.push(arguments);}
 gtag('js', new Date());

 gtag('config', 'UA-119234043-1');
</script>




</body>
</html>
