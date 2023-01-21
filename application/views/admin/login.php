<!DOCTYPE html>
<html lang="en">
<?php include APPPATH. 'views/includes/css.php'; ?>
<body>
	<div class="limiter">
		<div class="container-login100 page-background">
			<div class="wrap-login100">
				<form class="login100-form validate-form" action="<?php echo base_url('admin/Login'); ?>" method="POST">
					<span class="login100-form-logo">
						<img alt="" src="<?php echo base_url(); ?>source/assets/img/taxi.png">
					</span>
					<span class="login100-form-title p-b-34 p-t-27">
						Log in
					</span>
					<div class="wrap-input100 validate-input" data-validate="Enter username">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>
					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>
					<div class="contact100-form-checkbox">
						<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
						<label class="label-checkbox100" for="ckb1">
							Remember me
						</label>
					</div>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name="login_submit">
							Login
						</button>
					</div>
					<div class="text-center p-t-50">
						<a class="txt1" href="<?php echo base_url('admin/Login/forgotPassword'); ?>">
							Forgot Password?
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- start js include path -->
	<?php include APPPATH. 'views/includes/js.php'; ?>
	<!-- end js include path -->
</body>
</html>