							<div class="m-login__head">
								<h3 class="m-login__title">
									Sign Up
								</h3>
								<div class="m-login__desc">
									Enter your details to create your account:
								</div>
							</div>
							<form id="register-form" action="/user/register/" method="post" class="m-login__form m-form">
								<div class="form-group m-form__group">
<input class="form-control m-input" type="text" placeholder="Fullname" name="fullname" data-validation="length alphanumeric"
		 data-validation-length="3-12" data-validation-error-msg="User name has to be an alphanumeric value (3-12 chars)" value="<?=isset($_SESSION['form_data']['fullname']) ? h($_SESSION['form_data']['fullname']) : '';?>">
								</div>


								<div class="form-group m-form__group">
<input class="form-control m-input" type="text" placeholder="Email" name="email" value="<?=isset($_SESSION['form_data']['email']) ? h($_SESSION['form_data']['email']) : '';?>" autocomplete="off" data-validation="email" data-validation-error-msg="You did not enter a valid e-mail">
								</div>


								<div class="form-group m-form__group">
									<input id="password_main" class="form-control m-input" type="password" placeholder="Password" name="password">
								</div>
								<div class="form-group m-form__group">
	<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirm Password" name="password2">
								</div>
								<div class="row form-group m-form__group m-login__form-sub">
									<div class="col m--align-left">
										<label class="m-checkbox m-checkbox--light">
											<input type="checkbox" name="agree">
											I Agree the
											<a href="#" class="m-link m-link--focus">
												terms and conditions
											</a>
											.
											<span></span>
										</label>
										<span class="m-form__help"></span>
									</div>
								</div>
								<div class="m-login__form-action">
									<button id="m_login_signup_submit" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
										Sign Up
									</button>
									&nbsp;&nbsp;
									<a href="/user/" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">
										Cancel
									</a>
								</div>
							</form>

<?php if (isset($_SESSION['form_data']) ) unset($_SESSION['form_data'])?>
