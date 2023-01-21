<!DOCTYPE html>
<html lang="en">
   <!-- BEGIN HEAD -->
   <?php include APPPATH. 'views/includes/css.php'; ?>
   <style>
      .mdl-textfield__input{
          text-transform:uppercase !important;
      }
   </style>
   <!-- END HEAD -->
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
                           <div class="page-title">Add Driver</div>
                        </div>
                        <ol class="breadcrumb page-breadcrumb pull-right">
                           <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index-2.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                           </li>
                           <li><a class="parent-item" href="#">Drivers</a>&nbsp;<i class="fa fa-angle-right"></i>
                           </li>
                           <li class="active">Add Driver</li>
                        </ol>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="card-box">
                           <div class="card-head">
                              <header>Add Driver</header>
                              <button id="panel-button"
                                 class="mdl-button mdl-js-button mdl-button--icon pull-right"
                                 data-upgraded=",MaterialButton">
                              <i class="material-icons">more_vert</i>
                              </button>
                              <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                                 data-mdl-for="panel-button">
                                 <li class="mdl-menu__item"><i class="material-icons">assistant_photo</i>Action </li>
                                 <li class="mdl-menu__item"><i class="material-icons">print</i>Another action </li>
                                 <li class="mdl-menu__item"><i class="material-icons">favorite</i>Something else here</li>
                              </ul>
                           </div>
                           <div class="accordion accordion-flush" id="accordionFlushExample">
                              <div class="accordion-item">
                                 <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    Basic Information
                                    </button>
                                 </h2>
                                 <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <form method="POST" enctype="multipart/form-data" action="<?= base_url('admin/Owner/basicDetail_driver'); ?>/<?= isset($data['id']) ? $data['id'] : ''; ?>">
                                       <input type="hidden" name="owner_id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
                                       <div class="card-body row">
                                          <div class="col-lg-6 p-t-20">
                                             <div
                                                class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                                <input class="mdl-textfield__input" type="text" id="first_name" name="first_name"  value="<?= isset($data['first_name']) ? $data['first_name'] : ''; ?>">
                                                <label class="mdl-textfield__label">First Name</label>
                                                <div><font color="#f00000" size="2px"><?php if (isset($error['first_name'])) echo $error['first_name']; ?></font></div>
                                             </div>
                                          </div>
                                          <div class="col-lg-6 p-t-20">
                                             <div
                                                class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                                <input class="mdl-textfield__input" type="text" id="last_name" name="last_name"  value="<?= isset($data['last_name']) ? $data['last_name'] : ''; ?>">
                                                <label class="mdl-textfield__label">Last Name</label>
                                                <div><font color="#f00000" size="2px"><?php if (isset($error['last_name'])) echo $error['last_name']; ?></font></div>
                                             </div>
                                          </div>
                                          <div class="col-lg-6 p-t-20">
                                             <div
                                                class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                                <input class="mdl-textfield__input" type="email" id="email" name="email"  value="<?= isset($data['email']) ? $data['email'] : ''; ?>">
                                                <label class="mdl-textfield__label">Email</label>
                                                <span class="mdl-textfield__error">Enter Valid Email Address!</span>
                                                <div><font color="#f00000" size="2px"><?php if (isset($error['email'])) echo $error['email']; ?></font></div>
                                             </div>
                                          </div>
                                          <div class="col-lg-6 p-t-20">
                                             <div
                                                class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                                <input class="mdl-textfield__input" type="text" pattern="-?[0-9]*(\.[0-9]+)?" id="mobile" name="mobile" value="<?= isset($data['mobile']) ? $data['mobile'] : ''; ?>">
                                                <label class="mdl-textfield__label" for="text5">Mobile Number</label>
                                                <span class="mdl-textfield__error">Number required!</span>
                                                <div><font color="#f00000" size="2px"><?php if (isset($error['mobile'])) echo $error['mobile']; ?></font></div>
                                             </div>
                                          </div>
                                          <div class="col-lg-6 p-t-20">
                                             <div
                                                class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                                <input class="mdl-textfield__input" type="text" id="date" name="dob" value="<?= isset($data['dob']) ? $data['dob'] : ''; ?>">
                                                <label class="mdl-textfield__label">Date of Birth</label>
                                                <div><font color="#f00000" size="2px"><?php if (isset($error['dob'])) echo $error['dob']; ?></font></div>
                                             </div>
                                          </div>
                                          <div class="col-lg-6 p-t-20">
                                             <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fix-height txt-full-width">
                                                <select class="mdl-textfield__input" name="gender" id="gender">
                                                   <option value=" ">Select Gender</option>
                                                   <option value="Male"<?php if (isset($data['gender']) && $data['gender'] == 'Male') echo "selected"; ?>>Male</option>
                                                   <option value="Female"<?php if (isset($data['gender']) && $data['gender'] == 'Female') echo "selected"; ?>>Female</option>
                                                </select>
                                                <div><font color="#f00000" size="2px"><?php if (isset($error['gender'])) echo $error['gender']; ?></font></div>
                                             </div>
                                          </div>
                                          <div class="col-lg-6 p-t-20">
                                             <div
                                                class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width mdl-textfield--file">
                                                <input type="file" class="form-control" id="" name="profile_pic" >
                                                <div><font color="#f00000" size="2px"><?php if (isset($error['profile_pic'])) echo $error['profile_pic']; ?></font></div>
                                             </div>
                                          </div>
                                          
                                         <?php 
                                             if(isset($data['profile_pic'])){
                                              ?>
                                               <div class="col-lg-6 p-t-20">
                                                   <img src="<?php echo base_url(); ?>pubilc/driver/<?php echo isset($data['profile_pic']) ? $data['profile_pic'] : ''; ?>" width="100px" height="100px">
                                               </div>
                                         <?php   } ?>
                                          
                                          
                                          <div class="col-lg-12 p-t-20 text-center">
                                             <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink">Submit</button>
                                             <button type="cancel" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-default">Cancel</button>
                                          </div>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                              <div class="accordion-item">
                                 <h2 class="accordion-header" id="flush-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                    Address Details
                                    </button>
                                 </h2>
                                 <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                    <form method="post" action="<?= base_url('admin/Owner/addressDetail_driver'); ?>/<?= isset($data['id']) ? $data['id'] : ''; ?>" >
                                       <div class="card-body row">
                                          <div class="col-lg-6 p-t-20">
                                             <div
                                                class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                                <input class="mdl-textfield__input" type="text" id="present_address" name="present_address" value="<?= isset($data['present_address']) ? $data['present_address'] : ''; ?>">
                                                <label class="mdl-textfield__label">Present Address</label>
                                                <div><font color="#f00000" size="2px"><?php if (isset($error['present_address'])) echo $error['present_address']; ?></font></div>
                                             </div>
                                          </div>
                                          <div class="col-lg-6 p-t-20">
                                             <div
                                                class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                                <input class="mdl-textfield__input" type="text" id="permanent_address" name="permanent_address" value="<?= isset($data['permanent_address']) ? $data['permanent_address'] : ''; ?>" >
                                                <label class="mdl-textfield__label">Permanent Address</label>
                                                <div><font color="#f00000" size="2px"><?php if (isset($error['permanent_address'])) echo $error['permanent_address']; ?></font></div>
                                             </div>
                                          </div>
                                          
                                          <div class="col-lg-12 p-t-20 text-center">
                                             <button type="submit"
                                                class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink">Submit</button>
                                             <button type="cancel"
                                                class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-default">Cancel</button>
                                          </div>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                              <div class="accordion-item">
                                 <h2 class="accordion-header" id="flush-headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                    Driving Licence Detail
                                    </button>
                                 </h2>
                                 <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                    <form method="post" enctype="multipart/form-data" action="<?= base_url('admin/Owner/drivingLicence_driver'); ?>/<?= isset($data['id']) ? $data['id'] : ''; ?>">
                                       <div class="card-body row">
                                         
                                          <div class="col-lg-6 p-t-20">
                                             <div
                                                class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                                <input class="mdl-textfield__input" type="text" id="driving_licence_number" name="driving_licence_number" value="<?= isset($data['driving_licence_number']) ? $data['driving_licence_number'] : ''; ?>" >
                                                <label class="mdl-textfield__label">Driving Licence Number</label>
                                                <div><font color="#f00000" size="2px"><?php if (isset($error['driving_licence_number'])) echo $error['driving_licence_number']; ?></font></div>
                                             </div>
                                          </div>
                                          <div class="col-lg-6 p-t-20">
                                             <div
                                                class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                                <input class="mdl-textfield__input" type="text" id="date1" name="dl_expiry_date" value="<?= isset($data['dl_expiry_date']) ? $data['dl_expiry_date'] : ''; ?>">
                                                <label class="mdl-textfield__label">Driving Expiry Date</label>
                                                <div><font color="#f00000" size="2px"><?php if (isset($error['dl_expiry_date'])) echo $error['dl_expiry_date']; ?></font></div>
                                             </div>
                                          </div>
                                        
                                         <div class="col-lg-6 p-t-20">
                                             <div
                                                class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width mdl-textfield--file">
                                                <input type="file" class="form-control" id="" name="licence_front_image">
                                                <div><font color="#f00000" size="2px"><?php if (isset($error['licence_front_image'])) echo $error['licence_front_image']; ?></font></div>
                                             </div>
                                          </div>
                                          
                                           <div class="col-lg-6 p-t-20">
                                             <div
                                                class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width mdl-textfield--file">
                                                <input type="file" class="form-control" id="" name="licence_back_image">
                                                <div><font color="#f00000" size="2px"><?php if (isset($error['licence_back_image'])) echo $error['licence_back_image']; ?></font></div>
                                             </div>
                                          </div>
                                          
                                           <?php 
                                             if(isset($data['licence_front_image'])){
                                               ?>
                                               <div class="col-lg-6 p-t-20">
                                                   <img src="<?php echo base_url(); ?>pubilc/driver/<?php echo isset($data['licence_front_image']) ? $data['licence_front_image'] : ''; ?>" width="100px" height="100px">
                                               </div>
                                          <?php   } ?>
                                          
                                           <?php 
                                             if(isset($data['licence_back_image'])){
                                               ?>
                                               <div class="col-lg-6 p-t-20">
                                                   <img src="<?php echo base_url(); ?>pubilc/driver/<?php echo isset($data['licence_back_image']) ? $data['licence_back_image'] : ''; ?>" width="100px" height="100px">
                                               </div>
                                          <?php   } ?>
                                          
                                          <div class="col-lg-12 p-t-20 text-center">
                                             <button type="submit"
                                                class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink">Submit</button>
                                             <button type="cancel"
                                                class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-default">Cancel</button>
                                          </div>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                              <div class="accordion-item">
                                 <h2 class="accordion-header" id="flush-headingSix">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSive">
                                    Document Details
                                    </button>
                                 </h2>
                                 <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">
                                    <form method="post" action="<?= base_url('admin/Owner/documentDetails_driver'); ?>/<?= isset($data['id']) ? $data['id'] : ''; ?>" enctype="multipart/form-data">
                                    <div class="card-body row">
                                       <div class="col-lg-6 p-t-20">
                                          <div
                                             class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                             <input class="mdl-textfield__input" type="text" id="uid_number" name="uid_number" value="<?= isset($data['uid_number']) ? $data['uid_number'] : ''; ?>">
                                             <label class="mdl-textfield__label">Aadhar Number</label>
                                             <div><font color="#f00000" size="2px"><?php if (isset($error['uid_number'])) echo $error['uid_number']; ?></font></div>
                                          </div>
                                       </div>
                                       <div class="col-lg-6 p-t-20"></div>
                                       <div class="col-lg-6 p-t-20">
                                          <div
                                             class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width mdl-textfield--file">
                                             <input type="file" class="form-control" id="uid_image" name="uid_image" >
                                          </div>
                                       </div>
                                       
                                        <div class="col-lg-6 p-t-20">
                                          <div
                                             class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width mdl-textfield--file">
                                             <input type="file" class="form-control" id="uid_image_back" name="uid_image_back" >
                                          </div>
                                       </div>
                                       
                                        <?php 
                                         if(isset($data['uid_front_image'])){
                                           ?>
                                           <div class="col-lg-6 p-t-20">
                                               <img src="<?php echo base_url(); ?>pubilc/driver/<?php echo isset($data['uid_front_image']) ? $data['uid_front_image'] : ''; ?>" width="100px" height="100px">
                                           </div>
                                          <?php   } ?>
                                          
                                           <?php 
                                         if(isset($data['uid_back_image'])){
                                         ?>
                                           <div class="col-lg-6 p-t-20">
                                               <img src="<?php echo base_url(); ?>pubilc/driver/<?php echo isset($data['uid_back_image']) ? $data['uid_back_image'] : ''; ?>" width="100px" height="100px">
                                           </div>
                                          <?php   } ?>
                                       
                                        <div class="col-lg-6 p-t-20">
                                          <div
                                             class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                             <input class="mdl-textfield__input" type="text" id="pan_number" name="pan_number" value="<?= isset($data['pan_number']) ? $data['pan_number'] : ''; ?>">
                                             <label class="mdl-textfield__label">Pan Number</label>
                                             <div><font color="#f00000" size="2px"><?php if (isset($error['pan_number'])) echo $error['pan_number']; ?></font></div>
                                          </div>
                                       </div>
                                       
                                        <div class="col-lg-6 p-t-20"></div>
                                      
                                       <div class="col-lg-6 p-t-20">
                                          <div
                                             class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width mdl-textfield--file">
                                             <input type="file" class="form-control" id="pan_image" name="pan_image" >
                                             <div><font color="#f00000" size="2px"><?php if (isset($error['pan_image'])) echo $error['pan_image']; ?></font></div>
                                          </div>
                                       </div>
                                       
                                       <div class="col-lg-6 p-t-20">
                                          <div
                                             class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width mdl-textfield--file">
                                             <input type="file" class="form-control" id="pan_image" name="pan_image_back" >
                                             <div><font color="#f00000" size="2px"><?php if (isset($error['pan_image_back'])) echo $error['pan_image_back']; ?></font></div>
                                          </div>
                                       </div>
                                       
                                        <?php 
                                         if(isset($data['pan_image'])){
                                           ?>
                                           <div class="col-lg-6 p-t-20">
                                               <img src="<?php echo base_url(); ?>pubilc/driver/<?php echo isset($data['pan_image']) ? $data['pan_image'] : ''; ?>" width="100px" height="100px">
                                           </div>
                                        <?php   } ?>
                                        
                                        <?php 
                                         if(isset($data['pan_image_back'])){
                                          ?>
                                           <div class="col-lg-6 p-t-20">
                                               <img src="<?php echo base_url(); ?>pubilc/driver/<?php echo isset($data['pan_image_back']) ? $data['pan_image_back'] : ''; ?>" width="100px" height="100px">
                                           </div>
                                        <?php   } ?>
                                       
                                       
                                       <div class="col-lg-12 p-t-20 text-center">
                                          <button type="submit"
                                             class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 m-r-20 btn-pink">Submit</button>
                                          <button type="cancel"
                                             class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-default">Cancel</button>
                                       </div>
                                    </div>
                                  </form>
                                 </div>
                              </div>
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