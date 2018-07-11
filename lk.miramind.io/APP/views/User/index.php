<!-- SIGN IN -->
						<div class="m-login__signin">
							<div class="m-login__head">
								<h3 class="m-login__title">
									Sign In
								</h3>
							</div>
							<form id="login-form" class="m-login__form m-form" action="/user/login/" method="post">
								<div class="form-group m-form__group">
									<input class="form-control m-input"   type="text" placeholder="Email" name="email" data-validation="email" autocomplete="off">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password" data-validation-strength="2">
								</div>
								<div class="row m-login__form-sub">
									<div class="col m--align-left m-login__form-left">
										<label class="m-checkbox  m-checkbox--light">
											<input type="checkbox" name="remember">
											Remember me
											<span></span>
										</label>
									</div>
									<div class="col m--align-right m-login__form-right">
										<a href="/user/recovery/" class="m-link">
											Forget Password ?
										</a>
									</div>
								</div>
								<div class="m-login__form-action">
									<button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary">
										Sign In
									</button> &nbsp;
									<a href="/user/register/"  class="m-link m-link--light m-login__account-link">
										<button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary">
												Sign Up
										</button>
									</a>
								</div>
								<br>
								<div class="network_login text-center">
								<p>OR</p>
								<br>
								<p>Log in using social networks</p>
								<div class="soc_icons_login">
									<a href="">
										<div class="m-demo-icon__preview">
											<i class="socicon-facebook"></i>
										</div>
									</a>
									<a href="">
										<div class="m-demo-icon__preview">
											<i class="socicon-instagram"></i>
										</div>
									</a>
									<a href="">
										<div class="m-demo-icon__preview">
											<i class="socicon-telegram"></i>
										</div>
									</a>
								</div>
								</div>
							</form>
						</div>
