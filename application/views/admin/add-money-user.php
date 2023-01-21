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
                     
                     <div class="page-title-breadcrumb">
                        <div class=" pull-left">
                           <div class="page-title">Add Money User</div>
                        </div>
                        <ol class="breadcrumb page-breadcrumb pull-right">
                           <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index-2.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                           </li>
                           <li><a class="parent-item" href="#">Drivers</a>&nbsp;<i class="fa fa-angle-right"></i>
                           </li>
                           <li class="active">Add Money User</li>
                        </ol>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="card-box">
                           <div class="card-head">
                              <header>Add Money User</header>
                              <button id="panel-button"
                                 class="mdl-button mdl-js-button mdl-button--icon pull-right"
                                 data-upgraded=",MaterialButton">
                              <i class="material-icons">more_vert</i>
                              </button>
                           </div>
                           
                           <form method="POST" enctype="multipart/form-data" action="<?= base_url('admin/User/addMoneyUser/'); ?>/<?= isset($data['id']) ? $data['id'] : ''; ?>">
                               <div class="card-body row">
                                 
                                
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
$(document).ready(function(){

});
</script>
