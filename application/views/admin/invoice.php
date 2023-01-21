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
                           <div class="page-title">Invoice</div>
                        </div>
                        <ol class="breadcrumb page-breadcrumb pull-right">
                           <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
                              href="index-2.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                           </li>
                           <li><a class="parent-item" href="#">Users</a>&nbsp;<i class="fa fa-angle-right"></i>
                           </li>
                           <li class="active">Invoice</li>
                        </ol>
                     </div>
                  </div>
                  <div class="tab-content tab-space">
                     <div class="tab-pane active show" id="tab2">
                        <div class="row">
                           <div class="col-md-2"></div>
                           <div class="col-md-6">
                              <div style="text-align:center;">
                                 <img src="<?php echo isset($invoice) ? base_url('pubilc/invoice/').$invoice : ''; ?>"  alt="" width="400px;" height="500px;">
                              </div>
                           </div>
                        </div>
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
      <script>
         $(document).ready(function() {
             $('#example').DataTable();
         });
      </script>
   </body>
</html>