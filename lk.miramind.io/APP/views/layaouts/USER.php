<!DOCTYPE html>
<html lang="en" >
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<?php \APP\core\base\View::getMeta()?>
		<base href="/">


		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js">
		</script>
		<script>
			WebFont.load(
				{
					google:
					{
						"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]
					},
					active: function()
					{
						sessionStorage.fonts = true;
					}
				});
		</script>
		<!--end::Web font -->
		<!--begin::Base Styles -->
		<link href="/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
		<link href="/assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
		<link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/theme-default.min.css"
    rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="/assets/demo/default/base/panel.style.css" />
		<!--end::Base Styles -->
		<link rel="shortcut icon" href="/assets/demo/default/media/img/logo/favicon.ico" />
	</head>
	<!-- end::Head -->
	<!-- end::Body -->
	<body  class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1" id="m_login" style="background-image: url(/assets/app/media/img//bg/bg-1.jpg);">
				<div class="m-grid__item m-grid__item--fluid m-login__wrapper">
					<div class="m-login__container">
						<div class="m-login__logo">
							<a href="http://miramind.io/">
								<img src="/assets/demo/demo2/media/img/logo/mira-logo.png" style="width: 50%">
							</a>
						</div>


						<?php
						if(isset($_SESSION['errors'])): ?>
						<div class="alert alert-danger alert-dismissable" role="alert">
							<h3 class="alert-heading font-size-h4 font-w400">
								ERROR
							</h3>
							<p class="mb-0">
								<?=$_SESSION['errors']; unset($_SESSION['errors']);?>
							</p>
						</div>

						<?php endif;?>

						<?=$content?>




					</div>
				</div>
			</div>
		</div>
		<!-- end:: Page -->
		<!--begin::Base Scripts -->
		<script src="/assets/vendors/base/vendors.bundle.js" type="text/javascript">
		</script>
		<script src="/assets/demo/default/base/scripts.bundle.js" type="text/javascript">
		</script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
		<script src="/assets/demo/demo2/base/script.login.js"></script>
		<!--end::Base Scripts -->

		<?php \APP\core\base\View::getCounts()?>

	</body>
	<!-- end::Body -->
</html>
