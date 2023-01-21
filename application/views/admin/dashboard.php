<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->


<!-- Mirrored from einfosoft.com/templates/templatemonster/ecab/source/light/admin/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 May 2022 06:24:34 GMT -->
<?php include APPPATH. 'views/includes/css.php'; ?>
<!-- END HEAD -->

<body
	class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white white-sidebar-color logo-white">
	<div class="page-wrapper">
		<!-- start header -->
		<?php include APPPATH. 'views/includes/header.php'; ?>
		<!-- end header -->
		<!-- start page container -->
		<div class="page-container">
			<!-- start sidebar menu -->
			<?php include APPPATH. 'views/includes/sidebar.php'; ?>
			<!-- end sidebar menu -->
			<!-- start page content -->
			<div class="page-content-wrapper">
				<div class="page-content">
					<div class="page-bar">
						<div class="page-title-breadcrumb">
							<div class=" pull-left">
								<div class="page-title">Dashboard</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="index-2.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Dashboard</li>
							</ol>
						</div>
					</div>
					<!-- Taxi live location start -->
					<div class="row">
						<div class="col-md-12">
							<div class="card card-box">
								<div class="card-head">
									<header>Taxi Live Location</header>
									<div class="tools">
										<a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
										<a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
										<a class="t-close btn-color fa fa-times" href="javascript:;"></a>
									</div>
								</div>
								<div class="card-body ">
									<div id="map" class="height-350"></div>
								</div>
							</div>
						</div>
					</div>
					<!-- Taxi live location end -->
					<div class="row">
						
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="row state-overview">
								<div class="col-lg-3 col-md-3 col-sm-3 col-12">
									<div class="info-box card-1">
										<span class="info-box-icon push-bottom"><i
												class="material-icons">group</i></span>
										<div class="info-box-content">
											<span class="info-box-text">Today's Collection</span>
											<span class="info-box-number"><?php echo isset($today_income['today_income']) ? number_format($today_income['today_income'],2) : 0; ?></span>
											<div class="progress">
												<div class="progress-bar width-0"></div>
											</div>
										</div>
										<!-- /.info-box-content -->
									</div>
								</div>
								
								<div class="col-lg-3 col-md-3 col-sm-3 col-12">
									<div class="info-box card-1">
										<span class="info-box-icon push-bottom"><i
												class="material-icons">group</i></span>
										<div class="info-box-content">
											<span class="info-box-text">Total Collection</span>
											<span class="info-box-number"><?php echo isset($total_income['total_income']) ? number_format($total_income['total_income'],2) : 0; ?></span>
											<div class="progress">
												<div class="progress-bar width-0"></div>
											</div>
										</div>
										<!-- /.info-box-content -->
									</div>
								</div>
								
								<div class="col-lg-3 col-md-3 col-sm-12 col-12">
									<div class="info-box card-2">
										<span class="info-box-icon push-bottom"><i
												class="material-icons">person</i></span>
										<div class="info-box-content">
											<span class="info-box-text">Total Rides</span>
											<span class="info-box-number"><?php echo isset($data['ride']) ? $data['ride'] : 0; ?></span>
											<div class="progress">
												<div class="progress-bar width-0"></div>
											</div>
										</div>
										<!-- /.info-box-content -->
									</div>
								</div>
								
								<div class="col-lg-3 col-md-3 col-sm-12 col-12">
									<div class="info-box card-3">
										<span class="info-box-icon push-bottom"><i
												class="material-icons">content_cut</i></span>
										<div class="info-box-content">
											<span class="info-box-text">Today Rides</span>
											<span class="info-box-number"><?php echo isset($data['today_ride']) ? $data['today_ride'] : 0; ?></span>
											<div class="progress">
												<div class="progress-bar width-0"></div>
											</div>
										</div>
										<!-- /.info-box-content -->
									</div>
								</div>
								
								<div class="col-lg-3 col-md-3 col-sm-12 col-12">
									<div class="info-box card-4">
										<span class="info-box-icon push-bottom"><i
												class="material-icons">monetization_on</i></span>
										<div class="info-box-content">
											<span class="info-box-text">Total Users</span>
											<span class="info-box-number"><?php echo isset($data['user']) ? $data['user'] : 0; ?></span>
											<div class="progress">
												<div class="progress-bar width-0"></div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-lg-3 col-md-3 col-sm-12 col-12">
									<div class="info-box card-4">
										<span class="info-box-icon push-bottom"><i
												class="material-icons">monetization_on</i></span>
										<div class="info-box-content">
											<span class="info-box-text">Today New Users</span>
											<span class="info-box-number"><?php echo isset($data['today_new_user']) ? $data['today_new_user'] : 0; ?></span>
											<div class="progress">
												<div class="progress-bar width-0"></div>
											</div>
										</div>
									</div>
								</div>
								
								
								<div class="col-lg-3 col-md-3 col-sm-12 col-12">
									<div class="info-box card-4">
										<span class="info-box-icon push-bottom"><i
												class="material-icons">monetization_on</i></span>
										<div class="info-box-content">
											<span class="info-box-text">Total Cabs</span>
											<span class="info-box-number"><?php echo isset($data['driver']) ? $data['driver'] : 0; ?></span>
											<div class="progress">
												<div class="progress-bar width-0"></div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-lg-3 col-md-3 col-sm-12 col-12">
									<div class="info-box card-4">
										<span class="info-box-icon push-bottom"><i
												class="material-icons">monetization_on</i></span>
										<div class="info-box-content">
											<span class="info-box-text">Today Active Cabs</span>
											<span class="info-box-number"><?php echo isset($data['ride_online']) ? $data['ride_online'] : 0; ?></span>
											<div class="progress">
												<div class="progress-bar width-0"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<!-- start Payment Details -->
					<!--<div class="row">-->
					<!--	<div class="col-md-12 col-sm-12">-->
					<!--		<div class="card  card-box">-->
					<!--			<div class="card-head">-->
					<!--				<header>Driver Details</header>-->
					<!--				<div class="tools">-->
					<!--					<a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>-->
					<!--					<a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>-->
					<!--					<a class="t-close btn-color fa fa-times" href="javascript:;"></a>-->
					<!--				</div>-->
					<!--			</div>-->
					<!--			<div class="card-body ">-->
					<!--				<div class="table-wrap">-->
					<!--					<div class="table-responsive tblDriverDetail">-->
					<!--						<table class="table display product-overview mb-30" id="support_table5">-->
					<!--							<thead>-->
					<!--								<tr>-->
					<!--									<th>No</th>-->
					<!--									<th>Name</th>-->
					<!--									<th>Join Date</th>-->
					<!--									<th>Vehicle Type</th>-->
					<!--									<th>Status</th>-->
					<!--									<th>Phone</th>-->
					<!--									<th>Vehicle Number</th>-->
					<!--								</tr>-->
					<!--							</thead>-->
					<!--							<tbody>-->
					<!--								<tr>-->
					<!--									<td></td>-->
					<!--									<td></td>-->
					<!--									<td></td>-->
					<!--									<td></td>-->
					<!--									<td>-->
															
					<!--									</td>-->
					<!--									<td></td>-->
					<!--									<td></td>-->
					<!--								</tr>-->
					<!--							</tbody>-->
					<!--						</table>-->
					<!--					</div>-->
					<!--				</div>-->
					<!--			</div>-->
					<!--		</div>-->
					<!--	</div>-->
					<!--</div>-->
					<!-- end Payment Details -->
					
				</div>
			</div>
			<!-- end page content -->
		
		</div>
		<!-- end page container -->
		<!-- start footer -->
		<?php include APPPATH. 'views/includes/footer.php'; ?>
		<!-- end footer -->
	</div>
	<!-- start js include path -->
	<?php include APPPATH. 'views/includes/js.php'; ?>
	<!-- end js include path -->
</body>


<!-- Mirrored from einfosoft.com/templates/templatemonster/ecab/source/light/admin/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 May 2022 06:25:01 GMT -->
</html>