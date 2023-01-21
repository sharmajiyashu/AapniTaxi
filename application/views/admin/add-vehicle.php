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
                           <div class="page-title">Add Vehicle</div>
                        </div>
                        <ol class="breadcrumb page-breadcrumb pull-right">
                           <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index-2.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                           </li>
                           <li><a class="parent-item" href="#">Owner</a>&nbsp;<i class="fa fa-angle-right"></i>
                           </li>
                           <li class="active">Add Vehicle</li>
                        </ol>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="card-box">
                           <div class="card-head">
                              <header>Add Vehicle</header>
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
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="flush-headingSeven">
                                 <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSeven" aria-expanded="false" aria-controls="flush-collapseSeven">
                                 Vehicel Details
                                 </button>
                              </h2>
                              <div id="flush-collapseSeven" class="accordion-collapse collapse" aria-labelledby="flush-headingSeven" data-bs-parent="#accordionFlushExample">
                                <form method="post" action="<?= base_url('admin/Owner/vehicelDetails'); ?>/<?= isset($data['id']) ? $data['id'] : ''; ?>" enctype="multipart/form-data">
                                 <input type="hidden" name="cab_type_name" value="cab">
                                 <input type="hidden" name="cab_type_id" value="3">
                                 <input type="hidden" name="owner_id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
                                 
                                 <div class="card-body row">
                                     <div class="col-lg-6 p-t-20">
                                       <div
                                          class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                          <input class="mdl-textfield__input" type="text" id="owner_name" name="owner_name" value="<?= isset($data['owner_name']) ? $data['owner_name'] : ''; ?>">
                                          <label class="mdl-textfield__label">Brand Name</label>
                                       </div>
                                    </div>
                                    <div class="col-lg-6 p-t-20">
                                       <div
                                          class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                          <input class="mdl-textfield__input" type="text" id="cab_model_name" name="cab_model_name" value="<?= isset($data['cab_model_name']) ? $data['cab_model_name'] : ''; ?>">
                                          <label class="mdl-textfield__label">Cab Model Name</label>
                                       </div>
                                    </div>
                                    
                                    <div class="col-lg-6 p-t-20">
                                       <div
                                          class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                          <input class="mdl-textfield__input" type="text" id="registration_number" name="registration_number" value="<?= isset($data['registration_number']) ? $data['registration_number'] : ''; ?>">
                                          <label class="mdl-textfield__label">Registration Number</label>
                                          <div><font color="#f00000" size="2px"><?php if (isset($error['registration_number'])) echo $error['registration_number']; ?></font></div>
                                       </div>
                                    </div>
                                   
                                    <!--<div class="col-lg-6 p-t-20">-->
                                    <!--   <div-->
                                    <!--      class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">-->
                                    <!--      <input class="mdl-textfield__input" type="text" id="engine_number" name="engine_number" value="<?= isset($data['engine_number']) ? $data['engine_number'] : ''; ?>">-->
                                    <!--      <label class="mdl-textfield__label">Engine Number</label>-->
                                    <!--      <div><font color="#f00000" size="2px"><?php if (isset($error['engine_number'])) echo $error['engine_number']; ?></font></div>-->
                                    <!--   </div>-->
                                    <!--</div>-->
                                   
                                    <!--<div class="col-lg-6 p-t-20">-->
                                    <!--   <div-->
                                    <!--      class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">-->
                                    <!--      <input class="mdl-textfield__input" type="text" id="chassis_number" name="chassis_number" value="<?= isset($data['chassis_number']) ? $data['chassis_number'] : ''; ?>">-->
                                    <!--      <label class="mdl-textfield__label">Chassis Number</label>-->
                                    <!--      <div><font color="#f00000" size="2px"><?php if (isset($error['chassis_number'])) echo $error['chassis_number']; ?></font></div>-->
                                    <!--   </div>-->
                                    <!--</div>-->
                                    
                                    <div class="col-lg-6 p-t-20">
                                       <div
                                          class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                          <input class="mdl-textfield__input" type="text" id="rc" name="rc"  value="<?= isset($data['rc']) ? $data['rc'] : ''; ?>">
                                          <label class="mdl-textfield__label">Registration Certificated</label>
                                       </div>
                                    </div>
                                    <div class="col-lg-6 p-t-20">
                                       <div
                                          class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                          <input class="mdl-textfield__input" type="text" id="rc_expiry_date" name="rc_expiry_date"  value="<?= isset($data['rc_expiry_date']) ? $data['rc_expiry_date'] : ''; ?>">
                                          <label class="mdl-textfield__label">RC Expiry Date</label>
                                       </div>
                                    </div>
                                    <!--<div class="col-lg-6 p-t-20">-->
                                    <!--   <div-->
                                    <!--      class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">-->
                                    <!--       <select name="is_insurance" class="mdl-textfield__input">-->
                                    <!--           <option value="">Select Insurance</option>-->
                                    <!--           <option value="Yes" <?php if (isset($data['is_insurance']) && $data['is_insurance'] == 'Yes') echo "selected"; ?> >Yes</option>-->
                                    <!--           <option value="No" <?php if (isset($data['is_insurance']) && $data['is_insurance'] == 'No') echo "selected"; ?> >No</option>-->
                                    <!--        </select>-->
                                    <!--        <div><font color="#f00000" size="2px"><?php if (isset($error['is_insurance'])) echo $error['is_insurance']; ?></font></div>-->
                                    <!--   </div>-->
                                    <!--</div>-->
                                    <!--<div class="col-lg-6 p-t-20">-->
                                    <!--   <div-->
                                    <!--      class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">-->
                                    <!--      <input class="mdl-textfield__input" type="text" id="insurance_number" name="insurance_number" value="<?= isset($data['insurance_number']) ? $data['insurance_number'] : ''; ?>">-->
                                    <!--      <label class="mdl-textfield__label">Insurance Number</label>-->
                                    <!--   </div>-->
                                    <!--</div>-->
                                    <!--<div class="col-lg-6 p-t-20">-->
                                    <!--   <div-->
                                    <!--      class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">-->
                                    <!--      <input class="mdl-textfield__input" type="text" id="insurance_expiry_date" name="insurance_expiry_date" value="<?= isset($data['insurance_expiry_date']) ? $data['insurance_expiry_date'] : ''; ?>">-->
                                    <!--      <label class="mdl-textfield__label">Insurance Expiry Date</label>-->
                                    <!--   </div>-->
                                    <!--</div>-->
                                    <!--<div class="col-lg-6 p-t-20">-->
                                    <!--   <div-->
                                    <!--      class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">-->
                                    <!--       <select name="is_fitness" class="mdl-textfield__input">-->
                                    <!--           <option value="">Select Fitness</option>-->
                                    <!--           <option value="Yes" <?php if (isset($data['is_fitness']) && $data['is_fitness'] == 'Yes') echo "selected"; ?> >Yes</option>-->
                                    <!--           <option value="No" <?php if (isset($data['is_fitness']) && $data['is_fitness'] == 'No') echo "selected"; ?> >No</option>-->
                                    <!--        </select>-->
                                    <!--        <div><font color="#f00000" size="2px"><?php if (isset($error['is_fitness'])) echo $error['is_fitness']; ?></font></div>-->
                                    <!--   </div>-->
                                    <!--</div>-->
                                    <!--<div class="col-lg-6 p-t-20">-->
                                    <!--   <div-->
                                    <!--      class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">-->
                                    <!--      <input class="mdl-textfield__input" type="text" id="fitness_number" name="fitness_number" value="<?= isset($data['fitness_number']) ? $data['fitness_number'] : ''; ?>">-->
                                    <!--      <label class="mdl-textfield__label">Fitness Number</label>-->
                                    <!--   </div>-->
                                    <!--</div>-->
                                    <!--<div class="col-lg-6 p-t-20">-->
                                    <!--   <div-->
                                    <!--      class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">-->
                                    <!--      <input class="mdl-textfield__input" type="text" id="fitness_expiry_date" name="fitness_expiry_date"  value="<?= isset($data['fitness_expiry_date']) ? $data['fitness_expiry_date'] : ''; ?>">-->
                                    <!--      <label class="mdl-textfield__label">Fitness Expiry Date</label>-->
                                    <!--   </div>-->
                                    <!--</div>-->
                                    <!--<div class="col-lg-6 p-t-20">-->
                                    <!--   <div-->
                                    <!--      class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">-->
                                    <!--       <select name="is_puc" class="mdl-textfield__input">-->
                                    <!--           <option value="">Select Permitted</option>-->
                                    <!--           <option value="Yes" <?php if (isset($data['is_puc']) && $data['is_puc'] == 'Yes') echo "selected"; ?> >Yes</option>-->
                                    <!--           <option value="No" <?php if (isset($data['is_puc']) && $data['is_puc'] == 'No') echo "selected"; ?> >No</option>-->
                                    <!--        </select>-->
                                    <!--        <div><font color="#f00000" size="2px"><?php if (isset($error['is_puc'])) echo $error['is_puc']; ?></font></div>-->
                                    <!--   </div>-->
                                    <!--</div>-->
                                    <!--<div class="col-lg-6 p-t-20">-->
                                    <!--   <div-->
                                    <!--      class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">-->
                                    <!--      <input class="mdl-textfield__input" type="text" id="puc_number" name="puc_number" value="<?= isset($data['puc_number']) ? $data['puc_number'] : ''; ?>">-->
                                    <!--      <label class="mdl-textfield__label">Permitted Number</label>-->
                                    <!--   </div>-->
                                    <!--</div>-->
                                    <!--<div class="col-lg-6 p-t-20">-->
                                    <!--   <div-->
                                    <!--      class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">-->
                                    <!--      <input class="mdl-textfield__input" type="text" id="puc_expiry_date" name="puc_expiry_date"  value="<?= isset($data['puc_expiry_date']) ? $data['puc_expiry_date'] : ''; ?>">-->
                                    <!--      <label class="mdl-textfield__label">PUC Expiry Date</label>-->
                                    <!--   </div>-->
                                    <!--</div>-->
                                  
                                    <div class="col-lg-6 p-t-20">
                                       <div
                                          class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width">
                                          <input class="mdl-textfield__input" type="text" id="manufacture_year" name="manufacture_year" value="<?= isset($data['manufacture_year']) ? $data['manufacture_year'] : ''; ?>">
                                          <label class="mdl-textfield__label">Manufacture Year</label>
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
                              <h2 class="accordion-header" id="flush-headingEight">
                                 <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseEight" aria-expanded="false" aria-controls="flush-collapseEight">
                                 Vehicel Document
                                 </button>
                              </h2>
                              <div id="flush-collapseEight" class="accordion-collapse collapse" aria-labelledby="flush-headingEight" data-bs-parent="#accordionFlushExample">
                                <form method="post" action="<?= base_url('admin/Owner/vehicelDocumentImage/'); ?><?= isset($_GET['id']) ? $_GET['id'] : ''; ?>" enctype="multipart/form-data">
                                 <div class="card-body row">
                                   <div class="col-lg-6 p-t-20">
                                            <label>Rc Front Image</label>
                                          <div
                                             class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width mdl-textfield--file">
                                             <input type="file" class="form-control" id="rc_front_image" name="rc_front_image" >
                                          </div>
                                       </div>
                                       
                                        <div class="col-lg-6 p-t-20">
                                        <label>Rc Back Image</label>
                                          <div
                                             class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width mdl-textfield--file">
                                             <input type="file" class="form-control" id="rc_back_image" name="rc_back_image" >
                                          </div>
                                       </div>
                                       
                                       
                                        <div class="col-lg-6 p-t-20">
                                        <label>Insurance Image</label>
                                          <div
                                             class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width mdl-textfield--file">
                                             <input type="file" class="form-control" id="insurance_image" name="insurance_image" >
                                          </div>
                                       </div>
                                      
                                       
                                       <!-- <div class="col-lg-6 p-t-20">-->
                                       <!-- <label>Fitness Image</label>-->
                                       <!--   <div-->
                                       <!--      class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width mdl-textfield--file">-->
                                       <!--      <input type="file" class="form-control" id="fitness_image" name="fitness_image" >-->
                                       <!--   </div>-->
                                       <!--</div>-->
                                      
                                        <div class="col-lg-6 p-t-20">
                                        <label>Permitted Image</label>
                                          <div
                                             class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label txt-full-width mdl-textfield--file">
                                             <input type="file" class="form-control" id="puc_image" name="puc_image" >
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

<script>
$("")
</script>