<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->


<!-- Mirrored from einfosoft.com/templates/templatemonster/ecab/source/light/admin/active_trips.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 May 2022 06:25:12 GMT -->
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
								<div class="page-title">Payments</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="index-2.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="#">Payments</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Payments</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card card-box">
								<div class="card-head">
									<header>Payments</header>
									<div class="tools">
										<a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
										<a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
										<a class="t-close btn-color fa fa-times" href="javascript:;"></a>
									</div>
								</div>
								<div class="card-body ">
									<div class="table-scrollable">
									 <table  id="example" class="display nowrap" style="width:100%">
											<thead>
												<tr>
													<th>Sr.No.</th>
													<th class="center">Driver Name</th>
													<th class="center">Customer Name</th>
													<th class="center">Driver Fare</th>
													<th class="center">Commission</th>
													<th class="center">Tax</th>
													<th class="center">Net Balance</th>
													<th class="center">Status</th>
													<th class="center">Date</th>
												</tr>
											</thead>
											<tbody>
											   <?php if(isset($data) && !empty($data) && is_array($data)){ ?>
											    <?php $i = 1; foreach($data as $key => $value){ ?>
												<tr class="odd gradeX">
													<td class="center"><?php echo $i; ?></td>
													<td class="center"><?php echo isset($value['drivername']) ? $value['drivername'] : ''; ?></td>
													<td class="center"><?php echo isset($value['username']) ? $value['username'] : ''; ?></td>
													<td class="center"> &#x20b9; <?php echo isset($value['payment_amount']) ? $value['payment_amount'] : ''; ?></td>
													<td class="center"> &#x20b9; <?php echo isset($value['commission']) ? $value['commission'] : ''; ?></td>
													<td class="center"> &#x20b9; <?php echo isset($value['gst']) ? $value['gst'] : ''; ?></td>
													<td class="center"> &#x20b9; <?php echo isset($value['total_balance']) ? $value['total_balance'] : ''; ?></td>
													<td>
                                                        <?php
                                                        if (isset($value['status']) && $value['status'] == 'TXN_SUCCESS') { ?>
                                                            <span class="label label-sm box-shadow-1 label-success"><?php echo isset($value['status']) ? $value['status']  : '';?></span>
                                                        <?php }else{ ?>
                                                            <span class="label label-sm box-shadow-1 label-warning"><?php echo isset($value['status']) ? $value['status']  : '';?></span>
                                                        <?php } ?>
                                                    </td>
													<td class="center"><?php echo isset($value['created_at']) ? $value['created_at'] : ''; ?></td>
												</tr>
												<?php $i++;} ?>
											   <?php } ?>
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
	<script>
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                order: [[7, 'desc']],
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
</body>


<!-- Mirrored from einfosoft.com/templates/templatemonster/ecab/source/light/admin/active_trips.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 May 2022 06:25:17 GMT -->
</html>