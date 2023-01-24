<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->
<?php include APPPATH. 'views/includes/css.php'; ?>
<!-- END HEAD -->

<style>
    .driver_detail{
        box-shadow: 2px 2px 2px 2px lightgray;
        padding: 20px 20px 20px 20px;
    }
</style>
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
								<div class="page-title">Referral</div>
							</div>
							
						</div>
					</div>
					<div class="tab-content tab-space">
						<div class="tab-pane active show" id="tab2">
							<div class="row">
							<?php if(isset($getData) && !empty($getData)){ ?>
								<div class="col-md-8 offset-2">
									<div class="card">
										<div class="m-b-20">
											<div class="doctor-profile">
												<div class="profile-header bg-b-purple">
												    <div class="row">
												    <div class="col-md-6">
												        <img src="<?php echo isset($getData['profile_pic']) ? base_url('pubilc/driver/').$getData['profile_pic'] : base_url().'source/assets/img/5444.jpg'; ?>" class="user-img" alt="" width="100px;" height="100px;" style="margin-top:20px;">
												    </div>
												    
												    <div class="col-md-6">
												        <div class="user-name"><?php echo strtoupper($getData['first_name']); ?><?php echo strtoupper($getData['last_name']); ?></div>
													<div class="name-center"><?php echo isset($trip) ? $trip : 0; ?> Trips</div>
													<div class="col-md-12 col-sm-12 rating-style">
													   
													   <?php 
													   $rating = isset($rating['rating']) ? round($rating['rating']) : 0;
													   if($rating == 1){ ?>
													    <i class="material-icons">star</i>
													    <i class="material-icons">star_border</i>
													    <i class="material-icons">star_border</i>
													    <i class="material-icons">star_border</i>
													    <i class="material-icons">star_border</i>
													   <?php }elseif($rating == 2){ ?>
													    <i class="material-icons">star</i>
													    <i class="material-icons">star</i>
													    <i class="material-icons">star_border</i>
													    <i class="material-icons">star_border</i>
													    <i class="material-icons">star_border</i>
													   <?php }else if($rating == 3){ ?>
													    <i class="material-icons">star</i>
													    <i class="material-icons">star</i>
													    <i class="material-icons">star</i>
													    <i class="material-icons">star_border</i>
													    <i class="material-icons">star_border</i>
													   <?php }else if($rating == 4){ ?>
													    <i class="material-icons">star</i>
													    <i class="material-icons">star</i>
													    <i class="material-icons">star</i>
													    <i class="material-icons">star</i>
													    <i class="material-icons">star_border</i>
													   <?php }else if($rating == 5){ ?>
													    <i class="material-icons">star</i>
													    <i class="material-icons">star</i>
													    <i class="material-icons">star</i>
													    <i class="material-icons">star</i>
													    <i class="material-icons">star</i>
													   <?php }else{ ?>
													    <i class="material-icons">star_border</i>
													    <i class="material-icons">star_border</i>
													    <i class="material-icons">star_border</i>
													    <i class="material-icons">star_border</i>
													    <i class="material-icons">star_border</i>
													   <?php } ?>
												    </div>
												    <div>
													<p style="color:black;">
														<i class="fa fa-phone"></i><a style="color:black;" href="tel:<?php echo isset($getData['mobile']) ? $getData['mobile'] : ''; ?>">
														<?php echo isset($getData['mobile']) ? $getData['mobile'] : ''; ?></a>
													</p>
												    </div>
												</div>
										    </div>
											</div>
											<div class="row" style="margin-top:30px;">
												
											    <div class="col-md-6"><p class="driver_detail">Total Cancelled Trip</p></div>
											    <div class="col-md-6"><p class="driver_detail"><?php echo isset($cancelled) ? $cancelled : 0;  ?></p></div>
											    
											    <div class="col-md-6"><p class="driver_detail">Wallet</p></div>
											    <div class="col-md-6"><p class="driver_detail"><?php echo isset($wallet['wallet_amount']) ? $wallet['wallet_amount'] : 0; ?></p></div>
											    
											    <div class="col-md-6"><p class="driver_detail">Add Money To Wallet</p></div>
											    <div class="col-md-6"><p class="driver_detail"><button type="button" class="btn btn-primary" user_id="<?php echo isset($getData['user_id']) ? $getData['user_id'] : ''; ?>" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo" id="mybtn">Add Money</button></p></div>
											    
											    </div>	
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
							</div>
						</div>
					</div>
				
				   <div class="row">
                        <div class="col-md-12">
                            <div class="card card-topline-aqua">
                                <div class="card-head">
                                    <header>Referral Master</header>
                                    <div class="tools">
                                        <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                                        <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                                        <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                                    </div>
                                </div>
                                <div class="card-body ">
                                    <table  id="example" class="display" style="width:100%">
                                        <thead>
                                            <tr>
												<th>Referral Type</th>
												<th>Amount</th>
												<th>Change</th>												
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php
										 	foreach($data as $key=>$val){ ?>
												<tr>
													<?php
														if($val['type'] == 'referral_bonus'){ ?>
															<td>User Referral Bonus</td>
														<?php }elseif($val['type'] == 'driver_referral_bonus'){
															echo "<td>Driver Referral Bonus</td>";
														}else{
															echo '<td>'.$val['type'].'</td>';
														}
													?>	
													<form action="<?php echo base_url('admin/Dashboard/changeRefferalAmount')?>" method="post">
														<input type="hidden" name="id" value="<?php echo isset($val['id']) ? $val['id'] :''; ?>">
														<td><input type="text" name="amount" class="mdl-textfield__input" value="<?php echo isset($val['amount']) ? $val['amount'] :''; ?>"></td>
														<td><button>Submit</button></td>                                                
													</form>																									
													
												</tr>
											<?php } 
										  ?>
                                            
                                        
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
        <form action="<?php echo base_url('admin/User/addMoneyToWallet'); ?>" method="POST">
      <div class="modal-body">
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Amount:</label>
            <input type="number" class="form-control" id="amount" name="amount">
            <input type="hidden" class="form-control" name="user_id" id="user_id" value="">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>
	
	<!-- start js include path -->
<?php include APPPATH. 'views/includes/js.php'; ?>
	<!-- end js include path -->
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
    
    $("#mybtn").on('click',function(){
       var user_id = $(this).attr('user_id');
       $("#user_id").val(user_id);
    });
</script>

<script>
$(document).ready(function(){
   const exampleModal = document.getElementById('exampleModal')
    exampleModal.addEventListener('show.bs.modal', event => {
      // Button that triggered the modal
      const button = event.relatedTarget
      // Extract info from data-bs-* attributes
      const recipient = button.getAttribute('data-bs-whatever')
      // If necessary, you could initiate an AJAX request here
      // and then do the updating in a callback.
      //
      // Update the modal's content.
      const modalTitle = exampleModal.querySelector('.modal-title')
      const modalBodyInput = exampleModal.querySelector('.modal-body input')
    
      modalTitle.textContent = `New message to ${recipient}`
      modalBodyInput.value = recipient
    })
});
</script>







</body>
</html>