<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->
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
								<div class="page-title">Dashboard 
								</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="index-2.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Dashboard</li>
							</ol>
						</div>
					</div>
				
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="row state-overview">
								<div class="col-lg-4 col-md-4 col-sm-3 col-12">
									<div class="info-box card-1">
										<span class="info-box-icon push-bottom"><i
												class="material-icons">group</i></span>
										<div class="info-box-content">
											<span class="info-box-text">Today Income</span>
											<span class="info-box-number"><?php echo isset($total_income) ? $total_income :'0';?></span>
											<div class="progress">
												<div class="progress-bar width-0"></div>
											</div>
										</div>
										<!-- /.info-box-content -->
									</div>
								</div>
								
								<div class="col-lg-4 col-md-4 col-sm-3 col-12">
									<div class="info-box card-1">
										<span class="info-box-icon push-bottom"><i
												class="material-icons">group</i></span>
										<div class="info-box-content">
											<span class="info-box-text">Total Income</span>
											<span class="info-box-number"><?php echo isset($total_income) ? $total_income :'0';?></span>
											<div class="progress">
												<div class="progress-bar width-0"></div>
											</div>
										</div>
										<!-- /.info-box-content -->
									</div>
								</div>
								
								<div class="col-lg-4 col-md-4 col-sm-12 col-12">
									<div class="info-box card-2">
										<span class="info-box-icon push-bottom"><i
												class="material-icons">person</i></span>
										<div class="info-box-content">
											<span class="info-box-text">Total Cancelled</span>
											<span class="info-box-number"><?php echo isset($total_cancelled) ? $total_cancelled :'0';?></span>
											<div class="progress">
												<div class="progress-bar width-0"></div>
											</div>
										</div>
										<!-- /.info-box-content -->
									</div>
								</div>
								
								<div class="col-lg-4 col-md-4 col-sm-12 col-12">
									<div class="info-box card-3">
										<span class="info-box-icon push-bottom"><i
												class="material-icons">person</i></span>
										<div class="info-box-content">
											<span class="info-box-text">Today Cancelled</span>
											<span class="info-box-number"><?php echo isset($total_cancelled) ? $total_cancelled :'0';?></span>
											<div class="progress">
												<div class="progress-bar width-0"></div>
											</div>
										</div>
										<!-- /.info-box-content -->
									</div>
								</div>
							
								
								<div class="col-lg-4 col-md-4 col-sm-12 col-12">
									<div class="info-box card-2">
										<span class="info-box-icon push-bottom"><i
												class="material-icons">person</i></span>
										<div class="info-box-content">
											<span class="info-box-text">Weekly Trip</span>
											<span class="info-box-number"><?php echo isset($total_trip) ? $total_trip :'0';?></span>
											<div class="progress">
												<div class="progress-bar width-0"></div>
											</div>
										</div>
										<!-- /.info-box-content -->
									</div>
								</div>
								
								<div class="col-lg-4 col-md-4 col-sm-12 col-12">
									<div class="info-box card-2">
										<span class="info-box-icon push-bottom"><i
												class="material-icons">person</i></span>
										<div class="info-box-content">
											<span class="info-box-text">Total Trip</span>
											<span class="info-box-number"><?php echo isset($total_trip) ? $total_trip :'0';?></span>
											<div class="progress">
												<div class="progress-bar width-0"></div>
											</div>
										</div>
										<!-- /.info-box-content -->
									</div>
								</div>
								
							
								<!--<div class="col-lg-3 col-md-3 col-sm-12 col-12">-->
								<!--	<div class="info-box card-4">-->
								<!--		<span class="info-box-icon push-bottom"><i-->
								<!--				class="material-icons">local_taxi</i></span>-->
								<!--		<div class="info-box-content">-->
								<!--			<span class="info-box-text">Total Cab</span>-->
								<!--			<span class="info-box-number">0</span>-->
								<!--			<div class="progress">-->
								<!--				<div class="progress-bar width-0"></div>-->
								<!--			</div>-->
								<!--		</div>-->
								<!--	</div>-->
								<!--</div>-->
								
								<!--<div class="col-lg-3 col-md-3 col-sm-12 col-12">-->
								<!--	<div class="info-box card-4">-->
								<!--		<span class="info-box-icon push-bottom"><i-->
								<!--				class="material-icons">local_taxi</i></span>-->
								<!--		<div class="info-box-content">-->
								<!--			<span class="info-box-text">Today Cab</span>-->
								<!--			<span class="info-box-number">0</span>-->
								<!--			<div class="progress">-->
								<!--				<div class="progress-bar width-0"></div>-->
								<!--			</div>-->
								<!--		</div>-->
								<!--	</div>-->
								<!--</div>-->
							</div>
						</div>
					</div>

					 <!--chart start -->
					<div class="row">
						<div class="col-md-12">
							<div class="card card-box">
								<div class="card-head">
									<header>Chart Survey</header>
									<div class="tools">
										<a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
										<a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
										<a class="t-close btn-color fa fa-times" href="javascript:;"></a>
									</div>
								</div>
								<div class="card-body no-padding height-9">
									<div class="row text-center">
										<div class="col-sm-3 col-6">
											<h4 class="margin-0 fw-bold">0</h4>
											<p class="text-muted"> Today's Income</p>
										</div>
										<div class="col-sm-3 col-6">
											<h4 class="margin-0 fw-bold">0</h4>
											<p class="text-muted">This Week's Income</p>
										</div>
										<div class="col-sm-3 col-6">
											<h4 class="margin-0 fw-bold">0</h4>
											<p class="text-muted">This Month's Income</p>
										</div>
										<div class="col-sm-3 col-6">
											<h4 class="margin-0 fw-bold">0</h4>
											<p class="text-muted">This Year's Income</p>
										</div>
									</div>
									<div class="row">
										<div id="line_chart" class="full-width"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Chart end -->
					
					<!--	<div class="row">-->
					<!--	<div class="col-md-12 col-sm-12">-->
					<!--		<div class="card  card-box">-->
					<!--			<div class="card-head">-->
					<!--				<header>Vehicle Details</header>-->
					<!--				<div class="tools">-->
					<!--					<a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>-->
					<!--					<a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>-->
					<!--					<a class="t-close btn-color fa fa-times" href="javascript:;"></a>-->
					<!--				</div>-->
					<!--			</div>-->
					<!--			<div class="card-body ">-->
					<!--			    <div class="row p-b-20">-->
     <!--                                   <div class="col-md-2 col-sm-2 col-2">-->
     <!--                                       <div class="btn-group">-->
     <!--                                           <a href="<?php echo base_url('admin/Owner/addVehicle'); ?>"><button class="btn btn-info">Add Vehicle</button></a>-->
     <!--                                        </div>-->
     <!--                                   </div>-->
     <!--                               </div>  -->
					<!--				<div class="table-wrap">-->
					<!--					<div class="table-responsive tblDriverDetail">-->
					<!--						<table class="table display product-overview mb-30" id="support_table5">-->
					<!--							<thead>-->
					<!--								<tr>-->
					<!--									<th>No</th>-->
					<!--									<th>Name</th>-->
					<!--									<th>Model</th>-->
					<!--									<th>Join Date</th>-->
					<!--									<th>Status</th>-->
														<!--<th>Phone</th>-->
														<!--<th>Vehicle Number</th>-->
														<!--<th>Edit</th>-->
					<!--								</tr>-->
					<!--							</thead>-->
					<!--							<tbody>-->
					<!--							    <?php  if(!empty($vehicle) && isset($vehicle)){ ?>-->
					<!--							    <?php $i=1; foreach($vehicle as $key => $value) { ?>-->
					<!--								<tr>-->
					<!--									<td><?php echo $i; ?></td>-->
					<!--									<td><a href="<?php echo base_url('admin/Owner/viewVehicle/');?><?=  isset($value['id']) ? $value['id'] : ''; ?>"><?php echo isset($value['cab_type_name']) ? $value['cab_type_name'] : '' ;?></a></td>-->
					<!--									<td><?php echo isset($value['cab_model_name']) ? $value['cab_model_name'] : '' ;?></td>-->
					<!--									<td><?php echo isset($value['updated_at']) ? $value['updated_at'] : '' ;?></td>-->
					<!--									<td>-->
					<!--									   <?php if(isset($value['status']) && $value['status'] == 1){ ?>-->
					<!--										<span class="label label-sm box-shadow-1 label-success">Enable</span>-->
					<!--									   <?php }else{ ?>-->
					<!--									    <span class="label label-sm box-shadow-1 label-warning">Disable</span>-->
					<!--									   <?php } ?>-->
					<!--									</td>-->
					<!--								</tr>-->
					<!--							<?php $i++; } } ?>-->
					<!--							</tbody>-->
					<!--						</table>-->
					<!--					</div>-->
					<!--				</div>-->
					<!--			</div>-->
					<!--		</div>-->
					<!--	</div>-->
					<!--</div>-->
					
					
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
					<!--			    <div class="row p-b-20">-->
     <!--                                   <div class="col-md-2 col-sm-2 col-2">-->
     <!--                                       <div class="btn-group">-->
     <!--                                           <a href="<?php echo base_url('admin/Owner/addDriver'); ?>"><button class="btn btn-info">Add Driver</button></a>-->
     <!--                                        </div>-->
     <!--                                   </div>-->
     <!--                               </div>  -->
					<!--				<div class="table-wrap">-->
					<!--					<div class="table-responsive tblDriverDetail">-->
					<!--						<table class="table display product-overview mb-30" id="support_table5">-->
					<!--							<thead>-->
					<!--								<tr>-->
					<!--									<th>No</th>-->
					<!--									<th>Name</th>-->
					<!--									<th>Join Date</th>-->
					<!--									<th>Phone</th>-->
					<!--									<th>Status</th>-->
														<!--<th>Vehicle Number</th>-->
														<!--<th>Edit</th>-->
					<!--								</tr>-->
					<!--							</thead>-->
					<!--							<tbody>-->
					<!--							    <?php  if(!empty($driver) && isset($driver)){ ?>-->
					<!--							    <?php $i=1; foreach($driver as $key => $value) { ?>-->
					<!--								<tr>-->
					<!--									<td><?php echo $i; ?></td>-->
					<!--									<td><a href="<?php echo base_url('admin/Owner/viewDriver/');?><?=  isset($value['id']) ? $value['id'] : ''; ?>"><?php echo isset($value['first_name']) ? $value['first_name'] : '' ;?></a></td>-->
					<!--									<td><?php echo isset($value['created_at']) ? $value['created_at'] : '' ;?></td>-->
					<!--									<td><?php echo isset($value['mobile']) ? $value['mobile'] : '';  ?></td>-->
					<!--									<td>-->
     <!--                                                      <?php if(isset($value['driver_current_status']) && $value['driver_current_status'] == "online"){ ?>-->
					<!--										<span class="label label-sm box-shadow-1 label-success">Enable</span>-->
					<!--									   <?php }else{ ?>-->
					<!--									    <span class="label label-sm box-shadow-1 label-warning">Disable</span>-->
					<!--									   <?php } ?>-->
					<!--									</td>-->
					<!--								</tr>-->
					<!--							<?php $i++; } } ?>-->
					<!--							</tbody>-->
					<!--						</table>-->
					<!--					</div>-->
					<!--				</div>-->
					<!--			</div>-->
					<!--		</div>-->
					<!--	</div>-->
					<!--</div>-->
					<!-- end Payment Details -->
					
					
					<!--<div class="row">-->
					<!--	<div class="col-lg-12 col-md-12 col-sm-12 col-12">-->
					<!--		<div class="card-box ">-->
					<!--			<div class="card-head">-->
					<!--				<header>Guest Review</header>-->
					<!--				<div class="tools">-->
					<!--					<a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>-->
					<!--					<a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>-->
					<!--					<a class="t-close btn-color fa fa-times" href="javascript:;"></a>-->
					<!--				</div>-->
					<!--			</div>-->
					<!--			<div class="card-body ">-->
									<!--<div class="row">-->
									<!--	<ul class="docListWindow small-slimscroll-style">-->
									<!--		<li>-->
									<!--			<div class="row">-->
									<!--				<div class="col-md-8 col-sm-8">-->
									<!--					<div class="prog-avatar">-->
									<!--						<img src="../../assets/img/user/user1.jpg" alt="" width="40"-->
									<!--							height="40">-->
									<!--					</div>-->
									<!--					<div class="details">-->
									<!--						<div class="title">-->
									<!--							<a href="#">Rajesh Mishra</a>-->
									<!--							<p class="rating-text">Awesome!!! Highly recommend</p>-->
									<!--						</div>-->
									<!--					</div>-->
									<!--				</div>-->
									<!--				<div class="col-md-6 col-sm-4 rating-style">-->
									<!--					<i class="material-icons">star</i>-->
									<!--					<i class="material-icons">star</i>-->
									<!--					<i class="material-icons">star</i>-->
									<!--					<i class="material-icons">star_half</i>-->
									<!--					<i class="material-icons">star_border</i>-->
									<!--				</div>-->
									<!--			</div>-->
									<!--		</li>-->
									<!--	</ul>-->
									<!--	<div class="full-width text-center p-t-10">-->
									<!--		<a href="#" class="btn purple btn-outline btn-circle margin-0">View All</a>-->
									<!--	</div>-->
									<!--</div>-->
					<!--			</div>-->
					<!--		</div>-->
					<!--	</div>-->
					<!--</div>-->
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
</html>