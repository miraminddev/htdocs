<?
// nl2br($_SESSION['ulogin']['aboutme'] - Вывод без пробелов
?>

								<div class="container">
									<div class="row">
										<div class="col-md-12">
											<h1>Account Settings</h1>
										</div>
									</div>
									
<!--									
									<div class="row">
										<div class="col-md-12 kyc">
											<span style="font-size: 1.3em">KYC: &nbsp;</span>
											<a href="/panel/verification/" target="_blank"><button class="btn btn-info"> Go to Verification </button></a>
										</div>
									</div>
	-->								
									
									<div class="row tab-pane justify-content-center" id="tab_1_3">
										<div class="col-md-6 col-xs-10 profile_block">
										<div class="form-group">
											<label class="control-label">Current password</label>
	<input id="password" type="password" class="form-control" />
										</div>
										<div class="form-group">
											<label class="control-label">New password</label>
	<input id="newpass" type="password" name="pass_confirmation" class="form-control"  />
										</div>
										<div class="form-group">
											<label class="control-label">New password</label>
	<input id="newpass2" type="password" name="pass" class="form-control"  />
										</div>
										<div class="margin-top-10">
											<button onclick="changepass()" class="btn btn-info"> Change password </button>
										</div>
									</div>
									
									
									<br>
									<div class="col-md-6 col-xs-10 profile_block profile_block2">
										<div class="form-group">
											<label class="control-label">Full Name</label>
				<input id="firstname" value="<?=$_SESSION['ulogin']['firstname']?>" type="text" class="form-control" data-validation="length alphanumeric"
		 data-validation-length="3-30"
		 data-validation-error-msg="Full name has to be an alphanumeric value (3-30 chars)" />
										</div>

										<div class="form-group">
											<label class="control-label">Ethereum address</label>
						<input id="wallet" type="text" value="<?=$_SESSION['ulogin']['wallet']?>" class="form-control" />
										</div>
										<div class="margin-top-10">
											<button onclick="changeprofile()" class="btn btn-info"> Save changes </button>
										</div>
									</div>
								</div>
							</div>

		<hr>



