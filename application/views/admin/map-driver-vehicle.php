<!DOCTYPE html>
<html lang="en">
   <!-- BEGIN HEAD -->
   <?php include APPPATH. 'views/includes/css.php'; ?>
   <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

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
                           <div class="page-title">All Cab Fare</div>
                        </div>
                        <ol class="breadcrumb page-breadcrumb pull-right">
                           <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
                              href="index-2.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                           </li>
                           <li><a class="parent-item" href="#">Cab Fare</a>&nbsp;<i class="fa fa-angle-right"></i>
                           </li>
                           <li class="active">All Cab Fare</li>
                        </ol>
                     </div>
                  </div>
                  <div class="tab-content tab-space">
                     <div class="tab-pane active show" id="tab1">
                         
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-topline-red">
                                        <div class="card-head">
                                            <header>Map Driver</header>
                                            <div class="tools">
                                                <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                                                <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                                                <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                                            </div>
                                        </div>
                                        <form action="<?php echo base_url('admin/Owner/mapDriverVehicle'); ?>" method="POST">
                                        <div class="card-body ">
                                            <div class="row p-b-20">
                                                <div class="col-md-2 col-sm-2 col-2">
                                                    <div class="btn-group">
                                                        <button class="btn btn-info" id="submit" name="submit">
                                                            Submit 
                                                        </button>
                                                    </div>
                                                </div>
                                               
                                                <div class="col-md-3 col-sm-3 col-3">
                                                    <div class="btn-group">
                                                        <select name="cab_id" id="cab_id" class="form-control">
                                                            <option value="">Select Vehicle Type</option>
                                                        <?php if(isset($vehicleDetails) && !empty($vehicleDetails)){ ?>
                                                        <?php foreach($vehicleDetails as $key => $value){ ?>
                                                            <option value="<?php echo $value['id']; ?>"><?php echo $value['cab_type_name']; ?></option>
                                                        <?php } } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table table-striped table-bordered table-hover table-checkable order-column full-width" id="example4">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <label class="rt-chkbox rt-chkbox-single rt-chkbox-outline">
                                                                <input type="checkbox" class="group-checkable"
                                                                    data-set="#sample_1 .checkboxes" />
                                                                <span></span>
                                                            </label>
                                                        </th>
                                                        <th> Username </th>
                                                        <th> Start Time </th>
                                                        <th> End Time </th>
                                                        <th> Email </th>
                                                        <th> Status </th>
                                                        <th> Joined </th>
                                                        <th> Actions </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                 <?php if(isset($driverListing) && !empty($driverListing)){ ?>
                                                 <?php foreach($driverListing as $key => $value){ ?>
                                                   
                                                    <tr class="odd gradeX">
                                                        <td>
                                                            <label class="rt-chkbox rt-chkbox-single rt-chkbox-outline">
                                                                <input type="checkbox" class="checkboxes checkbox1" name="alldriver[]" value="<?php echo $value['id']; ?>" />
                                                                <span></span>
                                                            </label>
                                                        </td>
                                                        <td><?php echo $value['first_name']; ?><?php echo $value['last_name']; ?></td>
                                                        <td><input class="mdl-textfield__input checkbox1" type="text" id="time" name="shift_start_time[]"></td>
                                                        <td><input class="mdl-textfield__input checkbox1" type="text" id="time" name="shift_end_time[]"></td>
                                                        <td>
                                                            <a href="mailto:<?php echo $value['email']; ?>"><?php echo $value['email']; ?></a>
                                                        </td>
                                                        <td>
                                                            <span class="label label-sm label-success"> Approved </span>
                                                        </td>
                                                        <td><?php echo date('d-M-Y',strtotime($value['created_at'])); ?></td>
                                                        <td class="valigntop">
                                                            <div class="btn-group">
                                                                <button
                                                                    class="btn btn-xs deepPink-bgcolor dropdown-toggle no-margin"
                                                                    type="button" data-bs-toggle="dropdown"
                                                                    aria-expanded="false"> Remove
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                 <?php } } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- end page content -->
            <!-- start chat sidebar -->
            <div class="chat-sidebar-container" data-close-on-body-click="false">
               <div class="chat-sidebar">
                  <ul class="nav nav-tabs">
                     <li class="nav-item">
                        <a href="#quick_sidebar_tab_1" class="nav-link active tab-icon" data-bs-toggle="tab">Theme
                        </a>
                     </li>
                     <li class="nav-item">
                        <a href="#quick_sidebar_tab_2" class="nav-link tab-icon" data-bs-toggle="tab"> Settings
                        </a>
                     </li>
                  </ul>
                  <div class="tab-content">
                     <div class="tab-pane chat-sidebar-settings in show active animated shake" role="tabpanel"
                        id="quick_sidebar_tab_1">
                        <div class="slimscroll-style">
                           <div class="theme-light-dark">
                              <h6>Sidebar Theme</h6>
                              <button type="button" data-theme="white"
                                 class="btn lightColor btn-outline btn-circle m-b-10 theme-button">Light
                              Sidebar</button>
                              <button type="button" data-theme="dark"
                                 class="btn dark btn-outline btn-circle m-b-10 theme-button">Dark
                              Sidebar</button>
                           </div>
                           <div class="theme-light-dark">
                              <h6>Sidebar Color</h6>
                              <ul class="list-unstyled">
                                 <li class="complete">
                                    <div class="theme-color sidebar-theme">
                                       <a href="#" data-theme="white"><span class="head"></span><span
                                          class="cont"></span></a>
                                       <a href="#" data-theme="dark"><span class="head"></span><span
                                          class="cont"></span></a>
                                       <a href="#" data-theme="blue"><span class="head"></span><span
                                          class="cont"></span></a>
                                       <a href="#" data-theme="indigo"><span class="head"></span><span
                                          class="cont"></span></a>
                                       <a href="#" data-theme="cyan"><span class="head"></span><span
                                          class="cont"></span></a>
                                       <a href="#" data-theme="green"><span class="head"></span><span
                                          class="cont"></span></a>
                                       <a href="#" data-theme="red"><span class="head"></span><span
                                          class="cont"></span></a>
                                    </div>
                                 </li>
                              </ul>
                              <h6>Header Brand color</h6>
                              <ul class="list-unstyled">
                                 <li class="theme-option">
                                    <div class="theme-color logo-theme">
                                       <a href="#" data-theme="logo-white"><span class="head"></span><span
                                          class="cont"></span></a>
                                       <a href="#" data-theme="logo-dark"><span class="head"></span><span
                                          class="cont"></span></a>
                                       <a href="#" data-theme="logo-blue"><span class="head"></span><span
                                          class="cont"></span></a>
                                       <a href="#" data-theme="logo-indigo"><span class="head"></span><span
                                          class="cont"></span></a>
                                       <a href="#" data-theme="logo-cyan"><span class="head"></span><span
                                          class="cont"></span></a>
                                       <a href="#" data-theme="logo-green"><span class="head"></span><span
                                          class="cont"></span></a>
                                       <a href="#" data-theme="logo-red"><span class="head"></span><span
                                          class="cont"></span></a>
                                    </div>
                                 </li>
                              </ul>
                              <h6>Header color</h6>
                              <ul class="list-unstyled">
                                 <li class="theme-option">
                                    <div class="theme-color header-theme">
                                       <a href="#" data-theme="header-white"><span class="head"></span><span
                                          class="cont"></span></a>
                                       <a href="#" data-theme="header-dark"><span class="head"></span><span
                                          class="cont"></span></a>
                                       <a href="#" data-theme="header-blue"><span class="head"></span><span
                                          class="cont"></span></a>
                                       <a href="#" data-theme="header-indigo"><span class="head"></span><span
                                          class="cont"></span></a>
                                       <a href="#" data-theme="header-cyan"><span class="head"></span><span
                                          class="cont"></span></a>
                                       <a href="#" data-theme="header-green"><span class="head"></span><span
                                          class="cont"></span></a>
                                       <a href="#" data-theme="header-red"><span class="head"></span><span
                                          class="cont"></span></a>
                                    </div>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                     <!-- Start Setting Panel -->
                     <div class="tab-pane chat-sidebar-settings animated slideInUp" id="quick_sidebar_tab_2">
                        <div class="chat-sidebar-settings-list slimscroll-style">
                           <div class="chat-header">
                              <h5 class="list-heading">Layout Settings</h5>
                           </div>
                           <div class="chatpane inner-content ">
                              <div class="settings-list">
                                 <div class="setting-item">
                                    <div class="setting-text">Sidebar Position</div>
                                    <div class="setting-set">
                                       <select
                                          class="sidebar-pos-option form-control input-inline input-sm input-small ">
                                          <option value="left" selected="selected">Left</option>
                                          <option value="right">Right</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="setting-item">
                                    <div class="setting-text">Header</div>
                                    <div class="setting-set">
                                       <select
                                          class="page-header-option form-control input-inline input-sm input-small ">
                                          <option value="fixed" selected="selected">Fixed</option>
                                          <option value="default">Default</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="setting-item">
                                    <div class="setting-text">Sidebar Menu </div>
                                    <div class="setting-set">
                                       <select
                                          class="sidebar-menu-option form-control input-inline input-sm input-small ">
                                          <option value="accordion" selected="selected">Accordion</option>
                                          <option value="hover">Hover</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="setting-item">
                                    <div class="setting-text">Footer</div>
                                    <div class="setting-set">
                                       <select
                                          class="page-footer-option form-control input-inline input-sm input-small ">
                                          <option value="fixed">Fixed</option>
                                          <option value="default" selected="selected">Default</option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="chat-header">
                                 <h5 class="list-heading">Account Settings</h5>
                              </div>
                              <div class="settings-list">
                                 <div class="setting-item">
                                    <div class="setting-text">Notifications</div>
                                    <div class="setting-set">
                                       <div class="switch">
                                          <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect"
                                             for="switch-1">
                                          <input type="checkbox" id="switch-1" class="mdl-switch__input"
                                             checked>
                                          </label>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="setting-item">
                                    <div class="setting-text">Show Online</div>
                                    <div class="setting-set">
                                       <div class="switch">
                                          <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect"
                                             for="switch-7">
                                          <input type="checkbox" id="switch-7" class="mdl-switch__input"
                                             checked>
                                          </label>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="setting-item">
                                    <div class="setting-text">Status</div>
                                    <div class="setting-set">
                                       <div class="switch">
                                          <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect"
                                             for="switch-2">
                                          <input type="checkbox" id="switch-2" class="mdl-switch__input"
                                             checked>
                                          </label>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="setting-item">
                                    <div class="setting-text">2 Steps Verification</div>
                                    <div class="setting-set">
                                       <div class="switch">
                                          <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect"
                                             for="switch-3">
                                          <input type="checkbox" id="switch-3" class="mdl-switch__input"
                                             checked>
                                          </label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="chat-header">
                                 <h5 class="list-heading">General Settings</h5>
                              </div>
                              <div class="settings-list">
                                 <div class="setting-item">
                                    <div class="setting-text">Location</div>
                                    <div class="setting-set">
                                       <div class="switch">
                                          <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect"
                                             for="switch-4">
                                          <input type="checkbox" id="switch-4" class="mdl-switch__input"
                                             checked>
                                          </label>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="setting-item">
                                    <div class="setting-text">Save Histry</div>
                                    <div class="setting-set">
                                       <div class="switch">
                                          <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect"
                                             for="switch-5">
                                          <input type="checkbox" id="switch-5" class="mdl-switch__input"
                                             checked>
                                          </label>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="setting-item">
                                    <div class="setting-text">Auto Updates</div>
                                    <div class="setting-set">
                                       <div class="switch">
                                          <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect"
                                             for="switch-6">
                                          <input type="checkbox" id="switch-6" class="mdl-switch__input"
                                             checked>
                                          </label>
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
            <!-- end chat sidebar -->
         </div>
         <!-- end page container -->
         <!-- start footer -->
         <?php include APPPATH. 'views/includes/footer.php'; ?>
         <!-- end footer -->
      </div>
      <?php include APPPATH. 'views/includes/js.php'; ?>
      <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
      <script type="text/javascript">
         $(".delete").on('click',()=>{
           var r = confirm("Are you sure to delete this Cab fare ?");
           if (r == true) {
             return true;
           } else {
             return false;
           }
         });
         $(document).ready(function(){
            $('input.timepicker').timepicker({});
         });
      </script>
      <!--<script>-->
      <!--  $("#submit").on('click',function(){-->
            
      <!--      var cab_type = $("#cab_id").val();-->
      <!--      if(cab_type == ''){-->
      <!--         alert('Please Select Vehicle Type');-->
      <!--      }-->
      <!--      var driver_id = $('input[name="alldriver[]"]:checked');-->
      <!--      if(driver_id.length == 0){-->
      <!--        alert('Please Select Driver');-->
      <!--      }-->
            
      <!--    var grid = document.getElementById("example4");-->
      <!--    var checkBoxes = grid.getElementsByClassName("checkbox1");-->
           
        <!--//      var message = "Id Name                  Country\n";-->
        <!--//     for (var i = 0; i < checkBoxes.length; i++) {-->
        <!--//          console.log(checkBoxes[i]);-->
        <!--//         if (checkBoxes[i].checked) {-->
        <!--//         var row = checkBoxes[i].parentNode.parentNode;-->
                
               
        <!--//     }-->
        <!--//     }-->
 
      <!--  });-->
      <!--</script>-->
      
   </body>
</html>