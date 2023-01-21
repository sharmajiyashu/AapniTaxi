<!DOCTYPE html>
<html lang="en">
<?php include APPPATH. 'views/includes/css.php'; ?>
<body>
	<div class="limiter">
		<div class="container-login100 page-background">
			<div class="wrap-login100">
				<form class="login100-form validate-form" action="#" method="POST">
					<span class="login100-form-logo">
						<img alt="" src="<?php echo base_url(); ?>source/assets/img/taxi.png">
					</span>
					<p class="text-center txt-small-heading">
						Forgot Your Password? Let Us Help You.
					</p>
					<div class="wrap-input100 validate-input" data-validate="Enter username">
						<input class="input100" type="text" name="username"
							placeholder="Enter Your Register Email Address">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Send
						</button>
					</div>
					<div class="text-center p-t-27">
						<a class="txt1" href="<?php echo base_url('admin/Login'); ?>">
							Login?
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