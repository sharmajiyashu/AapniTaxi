<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->
<?php include APPPATH. 'views/includes/css.php'; ?>

<body
	class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white white-sidebar-color logo-white">
	<div class="page-wrapper">
		<?php include APPPATH. 'views/includes/header.php'; ?>

		<!-- start page container -->
		<div class="page-container">
			<?php include APPPATH. 'views/includes/sidebar.php'; ?>
			<!-- start page content -->
			<div class="page-content-wrapper">
				<div class="page-content">
					<div class="page-bar">
					<?php if ($this->session->flashdata('success')) { ?>
						<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<?= $this->session->flashdata('success') ?>
						</div>
					<?php } ?>
						<div class="page-title-breadcrumb">
							<div class=" pull-left">
								<div class="page-title">Add Cab Fare</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="index-2.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="#">Cab Fare</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Add</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="card-box">
								<div class="card-head">
									<header>Add Cab Fare</header>
									<button id="panel-button"
										class="mdl-button mdl-js-button mdl-button--icon pull-right"
										data-upgraded=",MaterialButton">
										<i class="material-icons">more_vert</i>
									</button>
									<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
										data-mdl-for="panel-button">
										<li class="mdl-menu__item"><i class="material-icons">assistant_photo</i>Action
										</li>
										<li class="mdl-menu__item"><i class="material-icons">print</i>Another action
										</li>
										<li class="mdl-menu__item"><i class="material-icons">favorite</i>Something else
											here</li>
									</ul>
								</div>
								<form method="POST" action="<?= base_url('admin/CabFare/add'); ?>/<?= isset($data['id']) ? $data['id'] : ''; ?>">
								<div class="card-body row">
									<div class="col-lg-12">
									</div>
									
									<input type="hidden" id="city_name" city_id="<?= isset($data['city_id']) ? $data['city_id'] : ''; ?>" value="<?= isset($data['citi_name']) ? $data['citi_name'] : ''; ?>">
									<div class="col-lg-6 p-t-20">
										<div
											class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
											<select name="state" class="mdl-textfield__input" id="state_id" >
												 <option value="">Select State</option>
												 <?php if(!empty($allState)) :
													foreach($allState as $key => $val) : ?>
												 <option value="<?= $val['id']; ?>" <?php if(isset($data['state_id']) && $val['id'] == $data['state_id']) echo 'selected';  ?> ><?= $val['name']; ?></option>
												 <?php endforeach; endif; ?>
											</select>
										</div>
									</div>
									<div class="col-lg-6 p-t-20">
										<div
											class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
											<div class="form-group">
											  <select name="city" class="mdl-textfield__input" id="city_id" >
												 <option value="">Select City</option>
											  </select>
											<label class="mdl-textfield__label">Select City</label>
										   </div>
										</div>
									</div>
									<div class="col-lg-6 p-t-20">
										<div
											class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
											<div class="form-group">
											  <select name="vehicle_type" class="mdl-textfield__input" id="vehicle_type" >
												 <option value="">Select Cab Type</option>
												 <?php if(!empty($allCabType)) :
													foreach($allCabType as $key => $val) : ?>
												 <option value="<?= $val['id']; ?>" <?php if(isset($data['vehicle_type']) && $val['id'] == $data['vehicle_type']) echo 'selected';  ?> ><?= $val['name']; ?></option>
												 <?php endforeach; endif; ?>
											  </select>
										    </div>
                           
										</div>
									</div>
									<div class="col-lg-6 p-t-20">
										<div
											class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
											 <input type="text" class="mdl-textfield__input" id="minimum_fare" name="minimum_fare" value="<?= isset($data['minimum_fare']) ? $data['minimum_fare'] : ''; ?>">
											<label class="mdl-textfield__label">Minimum Fare</label>
											<div><font color="#f00000" size="2px"><?php if (isset($error['minimum_fare'])) echo $error['minimum_fare']; ?></font></div>
										</div>
									</div>
									<div class="col-lg-6 p-t-20">
										<div
											class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
											<input type="text" class="mdl-textfield__input" id="fare_after_5_km" name="fare_after_5_km"  value="<?= isset($data['fare_after_5_km']) ? $data['fare_after_5_km'] : ''; ?>">
										<label class="mdl-textfield__label">Fare After 5 km</label>
											<div><font color="#f00000" size="2px"><?php if (isset($error['fare_after_5_km'])) echo $error['fare_after_5_km']; ?></font></div>
										</div>
									</div>
									<div class="col-lg-6 p-t-20">
										<div
											class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
											<input type="text" class="mdl-textfield__input" id="waiting_ride_charges" name="waiting_ride_charges" value="<?= isset($data['waiting_ride_charges']) ? $data['waiting_ride_charges'] : ''; ?>">
										   <label class="mdl-textfield__label">Waiting Ride Charges</label>
											<div><font color="#f00000" size="2px"><?php if (isset($error['waiting_ride_charges'])) echo $error['waiting_ride_charges']; ?></font></div>
										</div>
									</div>
									<div class="col-lg-6 p-t-20">
										<div
											class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
											<input type="text" class="mdl-textfield__input" id="night_charges" name="night_charges" value="<?= isset($data['night_charges']) ? $data['night_charges'] : ''; ?>">
										    <label class="mdl-textfield__label">Night Charges</label>
											<div><font color="#f00000" size="2px"><?php if (isset($error['night_charges'])) echo $error['night_charges']; ?></font></div>
										</div>
									</div>
							       
									<div class="col-lg-6 p-t-20">
										<div
											class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
											<input type="text" class="mdl-textfield__input" id="applicable_night_ride" name="applicable_night_ride" value="<?= isset($data['applicable_night_ride']) ? $data['applicable_night_ride'] : ''; ?>">
											<label class="mdl-textfield__label">Applicable Night Ride</label>
											<div><font color="#f00000" size="2px"><?php if (isset($error['applicable_night_ride'])) echo $error['applicable_night_ride']; ?></font></div>
										</div>
									</div>
								   
									<div class="col-lg-2 p-t-20">
											<input type="radio"  class="mdl-radio__button" id="yes" name="is_applicable_night"  value="Yes"<?php if(isset($data['is_applicable_night']) && $data['is_applicable_night'] == 'Yes') echo 'checked';  ?>>
											<span class="mdl-radio__label">Yes</span>
									</div>
									
									<div class="col-lg-2 p-t-20">
											<input type="radio" class="mdl-radio__button" id="no" name="is_applicable_night"  value="No"<?php if(isset($data['is_applicable_night']) && $data['is_applicable_night'] == 'No') echo 'checked';  ?>>
											<span class="mdl-radio__label">No</span>
									</div>
									
									
									
									<div class="col-lg-2 p-t-20">
											<input type="radio" class="mdl-radio__button" id="yes" name="is_strike"  value="Yes"<?php if(isset($data['is_strike']) && $data['is_strike'] == 'Yes') echo 'checked';  ?>>
											<span class="mdl-radio__label">Yes</span>
									</div>
									
									<div class="col-lg-2 p-t-20">
											<input type="radio" class="mdl-radio__button"  id="no" name="is_strike"  value="No"<?php if(isset($data['is_strike']) && $data['is_strike'] == 'No') echo 'checked';  ?>>
											<span class="mdl-radio__label">No</span>
									</div>
									
									
									<div class="col-lg-6 p-t-20">
										<div
											class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fix-height txt-full-width">
											 <input type="text" class="mdl-textfield__input" id="strike_charge" name="strike_charge" value="<?= isset($data['strike_charge']) ? $data['strike_charge'] : ''; ?>">
											<label class="mdl-textfield__label">Strike Charge</label>
											<div><font color="#f00000" size="2px"><?php if (isset($error['strike_charge'])) echo $error['strike_charge']; ?></font></div>
										</div>
									</div>
									
									<div class="col-lg-12 p-t-20 text-center">
										<button type="submit"
											class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink">Submit</button>
										<button type="button"
											class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-default">Cancel</button>
									</div>
								</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end page content -->
			<!-- start chat sidebar -->
			<div class="chat-sidebar-container" data-close-on-body-click="false">
				<div class="chat-sidebar">
					<ul class="nav nav-tabs">
						<li class="nav-item">
							<a href="#quick_sidebar_tab_1" class="nav-link active tab-icon" data-bs-toggle="tab">Theme
							</a>
						</li>

						<li class="nav-item">
							<a href="#quick_sidebar_tab_2" class="nav-link tab-icon" data-bs-toggle="tab"> Settings
							</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane chat-sidebar-settings in show active animated shake" role="tabpanel"
							id="quick_sidebar_tab_1">
							<div class="slimscroll-style">
								<div class="theme-light-dark">
									<h6>Sidebar Theme</h6>
									<button type="button" data-theme="white"
										class="btn lightColor btn-outline btn-circle m-b-10 theme-button">Light
										Sidebar</button>
									<button type="button" data-theme="dark"
										class="btn dark btn-outline btn-circle m-b-10 theme-button">Dark
										Sidebar</button>
								</div>
								<div class="theme-light-dark">
									<h6>Sidebar Color</h6>
									<ul class="list-unstyled">
										<li class="complete">
											<div class="theme-color sidebar-theme">
												<a href="#" data-theme="white"><span class="head"></span><span
														class="cont"></span></a>
												<a href="#" data-theme="dark"><span class="head"></span><span
														class="cont"></span></a>
												<a href="#" data-theme="blue"><span class="head"></span><span
														class="cont"></span></a>
												<a href="#" data-theme="indigo"><span class="head"></span><span
														class="cont"></span></a>
												<a href="#" data-theme="cyan"><span class="head"></span><span
														class="cont"></span></a>
												<a href="#" data-theme="green"><span class="head"></span><span
														class="cont"></span></a>
												<a href="#" data-theme="red"><span class="head"></span><span
														class="cont"></span></a>
											</div>
										</li>
									</ul>
									<h6>Header Brand color</h6>
									<ul class="list-unstyled">
										<li class="theme-option">
											<div class="theme-color logo-theme">
												<a href="#" data-theme="logo-white"><span class="head"></span><span
														class="cont"></span></a>
												<a href="#" data-theme="logo-dark"><span class="head"></span><span
														class="cont"></span></a>
												<a href="#" data-theme="logo-blue"><span class="head"></span><span
														class="cont"></span></a>
												<a href="#" data-theme="logo-indigo"><span class="head"></span><span
														class="cont"></span></a>
												<a href="#" data-theme="logo-cyan"><span class="head"></span><span
														class="cont"></span></a>
												<a href="#" data-theme="logo-green"><span class="head"></span><span
														class="cont"></span></a>
												<a href="#" data-theme="logo-red"><span class="head"></span><span
														class="cont"></span></a>
											</div>
										</li>
									</ul>
									<h6>Header color</h6>
									<ul class="list-unstyled">
										<li class="theme-option">
											<div class="theme-color header-theme">
												<a href="#" data-theme="header-white"><span class="head"></span><span
														class="cont"></span></a>
												<a href="#" data-theme="header-dark"><span class="head"></span><span
														class="cont"></span></a>
												<a href="#" data-theme="header-blue"><span class="head"></span><span
														class="cont"></span></a>
												<a href="#" data-theme="header-indigo"><span class="head"></span><span
														class="cont"></span></a>
												<a href="#" data-theme="header-cyan"><span class="head"></span><span
														class="cont"></span></a>
												<a href="#" data-theme="header-green"><span class="head"></span><span
														class="cont"></span></a>
												<a href="#" data-theme="header-red"><span class="head"></span><span
														class="cont"></span></a>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<!-- Start Setting Panel -->
						<div class="tab-pane chat-sidebar-settings animated slideInUp" id="quick_sidebar_tab_2">
							<div class="chat-sidebar-settings-list slimscroll-style">
								<div class="chat-header">
									<h5 class="list-heading">Layout Settings</h5>
								</div>
								<div class="chatpane inner-content ">
									<div class="settings-list">
										<div class="setting-item">
											<div class="setting-text">Sidebar Position</div>
											<div class="setting-set">
												<select
													class="sidebar-pos-option form-control input-inline input-sm input-small ">
													<option value="left" selected="selected">Left</option>
													<option value="right">Right</option>
												</select>
											</div>
										</div>
										<div class="setting-item">
											<div class="setting-text">Header</div>
											<div class="setting-set">
												<select
													class="page-header-option form-control input-inline input-sm input-small ">
													<option value="fixed" selected="selected">Fixed</option>
													<option value="default">Default</option>
												</select>
											</div>
										</div>
										<div class="setting-item">
											<div class="setting-text">Sidebar Menu </div>
											<div class="setting-set">
												<select
													class="sidebar-menu-option form-control input-inline input-sm input-small ">
													<option value="accordion" selected="selected">Accordion</option>
													<option value="hover">Hover</option>
												</select>
											</div>
										</div>
										<div class="setting-item">
											<div class="setting-text">Footer</div>
											<div class="setting-set">
												<select
													class="page-footer-option form-control input-inline input-sm input-small ">
													<option value="fixed">Fixed</option>
													<option value="default" selected="selected">Default</option>
												</select>
											</div>
										</div>
									</div>
									<div class="chat-header">
										<h5 class="list-heading">Account Settings</h5>
									</div>
									<div class="settings-list">
										<div class="setting-item">
											<div class="setting-text">Notifications</div>
											<div class="setting-set">
												<div class="switch">
													<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect"
														for="switch-1">
														<input type="checkbox" id="switch-1" class="mdl-switch__input"
															checked>
													</label>
												</div>
											</div>
										</div>
										<div class="setting-item">
											<div class="setting-text">Show Online</div>
											<div class="setting-set">
												<div class="switch">
													<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect"
														for="switch-7">
														<input type="checkbox" id="switch-7" class="mdl-switch__input"
															checked>
													</label>
												</div>
											</div>
										</div>
										<div class="setting-item">
											<div class="setting-text">Status</div>
											<div class="setting-set">
												<div class="switch">
													<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect"
														for="switch-2">
														<input type="checkbox" id="switch-2" class="mdl-switch__input"
															checked>
													</label>
												</div>
											</div>
										</div>
										<div class="setting-item">
											<div class="setting-text">2 Steps Verification</div>
											<div class="setting-set">
												<div class="switch">
													<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect"
														for="switch-3">
														<input type="checkbox" id="switch-3" class="mdl-switch__input"
															checked>
													</label>
												</div>
											</div>
										</div>
									</div>
									<div class="chat-header">
										<h5 class="list-heading">General Settings</h5>
									</div>
									<div class="settings-list">
										<div class="setting-item">
											<div class="setting-text">Location</div>
											<div class="setting-set">
												<div class="switch">
													<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect"
														for="switch-4">
														<input type="checkbox" id="switch-4" class="mdl-switch__input"
															checked>
													</label>
												</div>
											</div>
										</div>
										<div class="setting-item">
											<div class="setting-text">Save Histry</div>
											<div class="setting-set">
												<div class="switch">
													<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect"
														for="switch-5">
														<input type="checkbox" id="switch-5" class="mdl-switch__input"
															checked>
													</label>
												</div>
											</div>
										</div>
										<div class="setting-item">
											<div class="setting-text">Auto Updates</div>
											<div class="setting-set">
												<div class="switch">
													<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect"
														for="switch-6">
														<input type="checkbox" id="switch-6" class="mdl-switch__input"
															checked>
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end chat sidebar -->
		</div>
		<!-- end page container -->
		<!-- start footer -->
	  <?php include APPPATH. 'views/includes/footer.php'; ?>
		<!-- end footer -->
	</div>
	<!-- start js include path -->
	    <?php include APPPATH. 'views/includes/js.php'; ?>
		
		<script>
   $("#state_id").on('change',function(){
	  $('#city_id').html(''	);
      var state_id = $(this).val()
       $.ajax({
      		type: "POST",
      		url: "<?php echo base_url('admin/CabFare/getCity'); ?>",
      		data: {state_id : state_id},
      		cache: false,
      		success: function(data) {
      		  var obj = JSON.parse(data);
      		 	$.each(obj, function( index, value ) {
      		          $("#city_id").append('<option value="'+ value.id +'">'+ value.name +'</option>');
      		 	});
      		},
      	});
   });
   
   $(document).ready(function(){
     var city_name = $("#city_name").val(); 
     var city_id = $("#city_name").attr('city_id'); 
     $("#city_id").html('<option value="'+city_id+'">'+ city_name +'</option>');  
   });
</script>

	<!-- end js include path -->
</body>


<!-- Mirrored from einfosoft.com/templates/templatemonster/ecab/source/light/admin/add_driver.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 May 2022 06:25:19 GMT -->
</html>