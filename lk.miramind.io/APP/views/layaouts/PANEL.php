<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en" >
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
        <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

		<?php \APP\core\base\View::getMeta()?>

        <meta name="robots" content="noindex, nofollow">
		<base href="/">



		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
          WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
		</script>
		<!--end::Web font -->
        <!--begin::Base Styles -->
        <!--begin::Page Vendors -->
		<link href="assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Page Vendors -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
		<link href="assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/demo/demo2/base/style.bundle.css" rel="stylesheet" type="text/css" />
		<link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/theme-default.min.css"
    rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="assets/demo/demo2/base/style_new.css" />
		<!--end::Base Styles -->
		<link rel="shortcut icon" href="assets/demo/demo2/media/img/logo/favicon.ico" />

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>



	</head>
	<!-- end::Head -->
    <!-- end::Body -->




	<!-- <body  class="m-page--wide m-header--fixed m-header--fixed-mobile m-footer--push m-aside--offcanvas-default" >
		<div class="loading">
			<img src="assets/demo/demo2/media/img/ajax-loader.gif" alt=""> <br>
			<h1>LOADING...</h1>
		</div> -->
		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page" style="min-height: 100%">
			<!-- begin::Header -->
			<header id="m_header" class="m-grid__item m-header "  minimize="minimize" minimize-offset="200" minimize-mobile-offset="200" >
				<div class="m-header__top">
					<div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
						<div class="m-stack m-stack--ver m-stack--desktop">
							<!-- begin::Brand -->
							<div class="m-stack__item m-brand">
								<div class="m-stack m-stack--ver m-stack--general m-stack--inline">
									<div class="m-stack__item m-stack__item--middle m-brand__logo">
										<a href="http://miramind.io" class="m-brand__logo-wrapper">
											<img class="logo" alt="" src="assets/demo/demo2/media/img/logo/mira-logo.png"/>
										</a>
									</div>
									<div class="m-stack__item m-stack__item--middle m-brand__tools">
								<div class="m-dropdown m-dropdown--inline " >

						<a href="/" class="btn btn-outline-metal m-btn  m-btn--icon m-btn--pill balance_btn">
												<span style="color: #059ddd">
													Your Balance: <span id="mira_balance"><?=$_SESSION['ulogin']['token']?> MIRA</span>
												</span>
											</a>

										</div>
										<!-- begin::Responsive Header Menu Toggler-->
										<a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
											<span></span>
										</a>
										<!-- end::Responsive Header Menu Toggler-->
			<!-- begin::Topbar Toggler-->
										<a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
											<i class="flaticon-more"></i>
										</a>
										<!--end::Topbar Toggler-->
									</div>
								</div>
							</div>
							<!-- end::Brand -->
				<!-- begin::Topbar -->
							<div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
								<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
									<div class="m-stack__item m-topbar__nav-wrapper">
										<ul class="m-topbar__nav m-nav m-nav--inline">


											<li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
												<a href="#" class="m-nav__link m-dropdown__toggle">
													<span class="m-topbar__userpic m--hide">
														<img src="assets/app/media/img/users/user4.jpg" class="m--img-rounded m--marginless m--img-centered" alt=""/>
													</span>
													<span class="m-topbar__welcome">
														Hello,&nbsp;
													</span>
													<span class="m-topbar__username">
														<?=$_SESSION['ulogin']['firstname']?>
													</span>
												</a>
			<div class="m-dropdown__wrapper">
													<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
													<div class="m-dropdown__inner">
														<div class="m-dropdown__header m--align-center" style="background: #2c2d3a; background-size: cover;">
															<div class="m-card-user m-card-user--skin-dark">
																<div class="m-card-user__pic">
																	<img src="assets/demo/demo2/media/img/logo/mira-logo.png" class="m--img-rounded m--marginless" alt=""/>
																</div>
																<div class="m-card-user__details">
																	<span class="m-card-user__name m--font-weight-500">
																		<?=$_SESSION['ulogin']['firstname']?>
																	</span>
																	<span class="m-card-user__email m--font-weight-300">
																		<?=$_SESSION['ulogin']['email']?>
																	</span>
																</div>
															</div>
														</div>


														<div class="m-dropdown__body">
															<div class="m-dropdown__content">
																<ul class="m-nav m-nav--skin-light">
																	<li class="m-nav__section m--hide">
																		<span class="m-nav__section-text">
																			Section
																		</span>
																	</li>
																	<li class="m-nav__item">
																		<a href="/panel/profile/" class="m-nav__link">
																			<i class="m-nav__link-icon flaticon-profile-1"></i>
																			<span class="m-nav__link-title">
																				<span class="m-nav__link-wrap">
																					<span class="m-nav__link-text">
																						My Profile
																					</span>
																				</span>
																			</span>
																		</a>
																	</li>


																	<li class="m-nav__separator m-nav__separator--fit"></li>
																	<li class="m-nav__item">
												<a href="/user/logout/" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
																			Logout
																		</a>
																	</li>
																</ul>
															</div>
														</div>
													</div>
												</div>
											</li>

										</ul>
									</div>
								</div>
							</div>
							<!-- end::Topbar -->
						</div>
					</div>
				</div>
				<div class="m-header__bottom">
					<div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
						<div class="m-stack m-stack--ver m-stack--desktop">
							<!-- begin::Horizontal Menu -->
							<div class="m-stack__item m-stack__item--middle m-stack__item--fluid">
								<button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-light " id="m_aside_header_menu_mobile_close_btn">
									<i class="la la-close"></i>
								</button>

<?
$active[$this->route['action']] = 'm-menu__item--active';

?>


								<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-dark m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-light m-aside-header-menu-mobile--submenu-skin-light "  >
									<ul class="m-menu__nav  m-menu__nav--submenu-arrow ">



										<li class="m-menu__item <?=isset($active['index']) ? $active['index'] : ''; ?>" aria-haspopup="true">
											<a  href="/" class="m-menu__link ">
												<span class="m-menu__item-here"></span>
												<span class="m-menu__link-text">
													Purchase tokens
												</span>
											</a>
										</li>

										<li class="m-menu__item <?=isset($active['myinvest']) ? $active['myinvest'] : '';?> " aria-haspopup="true" >
											<a  href="/panel/myinvest/" class="m-menu__link ">
												<span class="m-menu__item-here"></span>
												<span class="m-menu__link-text">
													My investments
												</span>
											</a>
										</li>


										<li class="m-menu__item <?=isset($active['refferal']) ? $active['refferal'] : '';?>"  aria-haspopup="true">
											<a  href="/panel/refferal/" class="m-menu__link ">
												<span class="m-menu__item-here"></span>
												<span class="m-menu__link-text">
													Referral program
												</span>
											</a>
										</li>

						<li class="m-menu__item <?=isset($active['verification']) ? $active['verification'] : '';?>"  aria-haspopup="true">
											<a  href="/panel/verification/" class="m-menu__link ">
												<span class="m-menu__item-here"></span>
												<span class="m-menu__link-text">
													Verification
												</span>
											</a>
										</li>





				<li class="m-menu__item <?=isset($active['help']) ? $active['help'] : '';?>"  aria-haspopup="true">
											<a  href="/panel/help/" class="m-menu__link ">
												<span class="m-menu__item-here"></span>
												<span class="m-menu__link-text">
													Help
												</span>
											</a>
										</li>



										<li class="m-menu__item <?=isset($active['contact']) ? $active['contact'] : '';?>"  aria-haspopup="true">
											<a  href="/panel/contact/" class="m-menu__link ">
												<span class="m-menu__item-here"></span>
												<span class="m-menu__link-text">
													Contacts
												</span>
											</a>
										</li>

									</ul>
								</div>
							</div>
							<!-- end::Horizontal Menu -->
				<!--begin::Search-->
							<!--end::Search-->
						</div>
					</div>
				</div>
			</header>
			<!-- end::Header -->


		<!-- begin::Body -->
			<div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver-desktop m-grid--desktop 	m-container m-container--responsive m-container--xxl m-page__container m-body">
				<div class="m-grid__item m-grid__item--fluid m-wrapper body_wrapper">

<? if (empty($_SESSION['ulogin']['wallet'])) :?>

                <div class="row justify-content-center">
                  <div id="alert_new" class="col-md-10 col-12 text-center alert_new">
                    <h1>PLEASE FILL THE ETHERIUM ADDRESS FORM <a href="panel/myinvest">HERE</a></h1>
                  </div>
                </div>
                <br>
<?endif; ?>


									<? if (isset($error)) :?>
									<div class="note note-danger">
										<h4 class="block">ОШИБКА!</h4>
										<p> <?=$error?> </p>
									</div>
									<?else:?>
									<?=$content?>
									<?endif; ?>








		</div>
	</div>
	<!-- end:: Page -->
	<footer class="m-grid__item m-footer ">
		<div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
			<div class="m-footer__wrapper">
				<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
					<div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
						<span class="m-footer__copyright">
							2018 &copy; MIRAMIND
						</span>
					</div>
					<div class="m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--first">
						<ul class="m-footer__nav m-nav m-nav--inline m--pull-right">
							<li class="m-nav__item">
								<a href="#" class="m-nav__link">
									<span class="m-nav__link-text">
										About
									</span>
								</a>
							</li>
							<li class="m-nav__item">
								<a href="#"  class="m-nav__link">
									<span class="m-nav__link-text">
										Privacy
									</span>
								</a>
							</li>
							<li class="m-nav__item">
								<a href="#" class="m-nav__link">
									<span class="m-nav__link-text">
										T&C
									</span>
								</a>
							</li>
							<li class="m-nav__item">
								<a href="#" class="m-nav__link">
									<span class="m-nav__link-text">
										Purchase
									</span>
								</a>
							</li>
							<li class="m-nav__item m-nav__item--last">
								<a href="/panel/help/" class="m-nav__link" data-toggle="m-tooltip" title="Support Center" data-placement="left" target="_blank">
									<i class="m-nav__link-icon flaticon-info m--icon-font-size-lg3"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</footer>	            <!-- begin::Quick Sidebar -->

	<!-- end::Quick Sidebar -->
	    <!-- begin::Scroll Top -->
	<div id="m_scroll_top" class="m-scroll-top">
		<i class="la la-arrow-up"></i>
	</div>
	<!-- end::Scroll Top -->


    	<!--begin::Base Scripts -->
	<script src="assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
	<script src="assets/demo/demo2/base/scripts.bundle.js" type="text/javascript"></script>
	<!--end::Base Scripts -->
        <!--begin::Page Vendors -->
	<script src="assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
	<!--end::Page Vendors -->
        <!--begin::Page Snippets -->
	<script src="assets/app/js/dashboard.js" type="text/javascript"></script>
	<script src="https://cdn.rawgit.com/zenorocha/clipboard.js/master/dist/clipboard.min.js"></script>
	<!--end::Page Snippets -->

	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>

<script>

val.addEventListener('keyup', function(evt){
  let length = this.value.length
  if (length < 8) msgeth.textContent = 'Minimum 8 symbols'
	else if (length == 9) msgeth.textContent = ''
})

</script>


<script>
	$('#eth_input').keyup(function(){

  var x = $('#eth_input').val();


  $('#eth_amount').text(x);
    if (x > 0) {
       $('#mira_input').val(x * 100000);
    } else {
      $('#mira_input').val(0);
    }


});
</script>

<script>
new Clipboard('.btn-clipboard'); // Не забываем инициализировать библиотеку на нашей кнопке
</script>

	<script src="assets/demo/demo2/base/script.js"></script>
	<script src="/script.js"></script>


</body>
<!-- end::Body -->
</html>
