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
                        <div class="page-title-breadcrumb">
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
                                        href="index-2.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li><a class="parent-item" href="#">Driver</a>&nbsp;<i
                                        class="fa fa-angle-right"></i>
                                </li>
                                <li class="active">Online Driver List</li>
                            </ol>
                        </div>
                    </div>
                  
				   <div class="row">
                        <div class="col-md-12">
                            <div class="card card-topline-aqua">
                                <div class="card-head">
                                    <header>Online Driver Listing</header>
                                </div>
                                <div class="card-body ">
                                    <a href="<?php echo base_url('admin/Driver/exportDriverOnline'); ?>" class="btn btn-primary">Export</a>
                                    <table id="example" class="display" style="width:100%">
                                        <thead>
                                            <tr>
												<th>Name</th>
												<th>Mobile</th>
												<th>Email</th>
												<th>Dob</th>
												<th>Gender</th>
												<th>D L</th>
												<th>Show Locations</th>
												<th>Join Date</th>
												<th>Status</th>
												<th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
									     <?php if (isset($driverListing) && !empty($driverListing)) { 
                                            foreach ($driverListing as $key => $value) { ?>
                                                <tr>
                                                    <td><a href="<?php echo base_url();?>admin/Driver/DriverDashboard/<?php echo isset($value['id']) ? $value['id'] :''; ?>"><?= isset($value['first_name']) ? $value['first_name'] : ''; ?> &nbsp; <?= isset($value['last_name']) ? $value['last_name'] : ''; ?></a> </td>
                                                    <td><?= isset($value['mobile']) ? $value['mobile'] : ''; ?></td>
                                                    <td><?= isset($value['email']) ? $value['email'] : ''; ?></td>
                                                    <td><?= isset($value['dob']) ? $value['dob'] : ''; ?></td>
                                                    <td><?= isset($value['gender']) ? $value['gender'] : ''; ?></td>                                               
                                                    <td><?= isset($value['driving_licence_number']) ? $value['driving_licence_number'] : ''; ?></td>
													<td><button type="button" class="btn btn-primary"   onclick="show_location(<?php echo $value['latitude']; ?>,<?php echo $value['longitude']; ?>)" data-bs-whatever="@mdo">Show Location</button></td>
                                                    <td><?= isset($value['created_at']) ? $value['created_at'] : ''; ?></td>
                                                    <td>
                                                        <?php
                                                        if (isset($value['status']) && $value['status'] == '1') { ?>
                                                            <a href="<?php echo base_url('admin/Driver/changeStatusDriver/');?><?=  isset($value['id']) ? $value['id'] : ''; ?>/Active"><span class="label label-sm box-shadow-1 label-success">Active</span></a>
                                                        <?php }else{ ?>
                                                            <a href="<?php echo base_url('admin/Driver/changeStatusDriver/');?><?=  isset($value['id']) ? $value['id'] : ''; ?>/Inactive"><span class="label label-sm box-shadow-1 label-warning">Inactive</span></a>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                      <a href="<?php echo base_url('admin/Driver/viewDriver/');?><?=  isset($value['id']) ? $value['id'] : ''; ?>"><i class="fa fa-eye"> </i></a> 
                                                      <a href="<?php echo base_url('admin/Driver/addDriver/'.$value['id']); ?>"><i class="fa fa-edit"> </i> </a> 
                                                      <a href="<?php echo base_url('admin/Driver/deleteDriver/'.$value['id']); ?>"><i class="fa fa-trash delete"> </i> </a> 
                                                    </td>
                                                  </tr>
                                              <?php }  } ?>
                                        </tbody>
                                    </table>
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
	
	
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-body">
				  <div class="mb-3"id="show_location_driver"></div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
    </div>
	
    <!-- start js include path -->
    <?php include APPPATH. 'views/includes/js.php'; ?>
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
        
        $('.delete').click(function () {
            return confirm("Are you sure driver delete ?");
        });
		
		function show_location(lat_driver,lang_driver) {
			
			$("#show_location_driver").html('');
			
			$.ajax({
				url: '<?php echo base_url('admin/Driver/getLocationName'); ?>',
				type: "POST",
				cache: false,
				data:{
					'latitude':lat_driver,
					'longitude':lang_driver
				},
				success: function(resp){
					console.log(resp);
					$("#show_location_driver").html('<span>'+resp+'</span>');
				}
		    });
            $("#exampleModal").modal("show");
        };
    </script>
    <!-- end js include path -->
</body>
</html>