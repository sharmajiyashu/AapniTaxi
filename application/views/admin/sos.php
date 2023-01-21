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
								<div class="page-title">SOS</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="index-2.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="#">SOS</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">SOS</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card card-box">
								<div class="card-head">
									<header>SOS</header>
									<div class="tools">
										<a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
										<a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
										<a class="t-close btn-color fa fa-times" href="javascript:;"></a>
									</div>
								</div>
								<div class="card-body ">
									<div class="table-scrollable">
										<table id="tableExport" class="display">
											<thead>
												<tr>
													<th>#</th>
													<th>Customer Name</th>
													<th>Driver Name</th>
													<th>Location Name</th>
												</tr>
											</thead>
											<tbody>
											   <?php if(isset($data) && !empty($data)){ 
											         $i=1; foreach($data as $key => $value) { ?>
												<tr>
													<td><?php echo $i; ?></td>
													<td><?php echo isset($value['username']) ? $value['username'] : ''; ?></td>
													<td><?php echo isset($value['drivername']) ? $value['drivername'] : ''; ?></td>
													<td><?php echo isset($value['source_name']) ? $value['source_name'] : ''; ?></td>
													<td><?php echo isset($value['destination_name']) ? $value['destination_name'] : ''; ?></td>
												</tr>
											<?php $i++; } } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
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