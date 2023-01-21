<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->
<?php include APPPATH. 'views/includes/css.php'; ?>
<style>
 .sorting_1 a:hover{
     color:blue;
 }
</style>

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
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
                                        href="index-2.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li><a class="parent-item" href="#">Driver</a>&nbsp;<i
                                        class="fa fa-angle-right"></i>
                                </li>
                                <li class="active">List</li>
                            </ol>
                        </div>
                    </div>
                  
				   <div class="row">
                        <div class="col-md-12">
                            <div class="card card-topline-aqua">
                                <div class="card-head">
                                    <header>Owner Listing</header>
                                    <div class="tools">
                                        <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                                        <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                                        <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                                    </div>
                                </div>
                                <div class="card-body ">
                                    <button onclick="ExportToExcel('xlsx')" class="btn btn-primary">Export</button>
                                    <table  id="example" class="display nowrap" style="width:100%">
                                        <thead>
                                            <tr>
												<th>Name</th>
												<th>Mobile</th>
												<th>Email</th>
												<th>Dob</th>
												<th>Gender</th>
												<th>Join Date</th>
												<th>Status</th>
												<th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
									     <?php if (isset($ownerListing) && !empty($ownerListing)) { 
                                            foreach ($ownerListing as $key => $value) { ?>
                                                <tr>
                                                    <td><a href="<?php echo base_url('admin/Owner/viewOwner/'.$value['id']) ?>"><?= isset($value['first_name']) ? $value['first_name'] : ''; ?> &nbsp; <?= isset($value['last_name']) ? $value['last_name'] : ''; ?></a></td>
                                                    <td><?= isset($value['mobile']) ? $value['mobile'] : ''; ?></td>
                                                    <td><?= isset($value['email']) ? $value['email'] : ''; ?></td>
                                                    <td><?= isset($value['dob']) ? $value['dob'] : ''; ?></td>
                                                    <td><?= isset($value['gender']) ? $value['gender'] : ''; ?></td>                                               
                                                    <td><?= isset($value['created_at']) ? $value['created_at'] : ''; ?></td>
                                                    <td>
                                                        <?php
                                                        if (isset($value['status']) && $value['status'] == 1) { ?>
                                                            <span class="label label-sm box-shadow-1 label-success">Active</span>
                                                        <?php }else{ ?>
                                                            <span class="label label-sm box-shadow-1 label-warning">Inactive</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td><a href="<?php echo base_url('admin/Owner/addOwner/'.$value['id']); ?>"><i class="fa fa-edit"> </i> </a> 
                                                      <a href="<?php echo base_url('admin/Owner/deleteOwner/'.$value['id']); ?>"><i class="fa fa-trash delete"> </i> </a> </td>
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
    <!-- start js include path -->
    <?php include APPPATH. 'views/includes/js.php'; ?>
    <!-- end js include path -->
    <script>
        function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('saveStage');
            var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
            return dl ?
                XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
                XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
        }
    </script>
    
    <script>
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                order: [[6, 'desc']],
            });
        });
    </script>
</body>


<!-- Mirrored from einfosoft.com/templates/templatemonster/ecab/source/light/admin/advanced_table.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 May 2022 06:25:48 GMT -->
</html>