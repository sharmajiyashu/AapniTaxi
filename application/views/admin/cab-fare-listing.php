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
                              <div class="card-box">
                                 <div class="card-head">
                                    <button id="panel-button"
                                       class="mdl-button mdl-js-button mdl-button--icon pull-right"
                                       data-upgraded=",MaterialButton">
                                    <i class="material-icons">more_vert</i>
                                    </button>
                                    <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                                       data-mdl-for="panel-button">
                                       <li class="mdl-menu__item"><i
                                          class="material-icons">assistant_photo</i>Action</li>
                                       <li class="mdl-menu__item"><i class="material-icons">print</i>Another
                                          action
                                       </li>
                                       <li class="mdl-menu__item"><i
                                          class="material-icons">favorite</i>Something else here</li>
                                    </ul>
                                 </div>
                                 <div class="card-body ">
                                    <div class="table-scrollable">
                                       <table class="table table-hover table-checkable order-column full-width"
                                          id="example4">
                                          <thead>
                                             <tr>
                                                <th>Sr. No</th>
                                                <th class="center">Cab Name </th>
                                                <th class="center">State Name </th>
                                                <th class="center">City Name </th>
                                                <th class="center">Minimum Fare</th>
                                                <th class="center">Fare After 5 Km</th>
                                                <th class="center">Waiting Ride Charges</th>
                                                <th class="center">Night Charges</th>
                                                <th class="center">Is Applicable Night</th>
                                                <th class="center">Applicable Night Ride</th>
                                                <th class="center">Is Strike</th>
                                                <th class="center">Strike Charge</th>
                                                <th class="center">Action</th>
                                             </tr>
                                          </thead>
                                          <tbody>
										    <?php if (isset($category) && !empty($category)) { $i=1;
											  foreach ($category as $key => $value) { ?>
                                             <tr class="odd gradeX">
											    <td><?php echo $i; ?></td>
                                                <td><?= isset($value['vehicle_name']) ? $value['vehicle_name'] : ''; ?> </td>
												<td><?= isset($value['state_name']) ? $value['state_name'] : ''; ?> </td>
												<td><?= isset($value['citi_name']) ? $value['citi_name'] : ''; ?> </td>
												<td><?= isset($value['minimum_fare']) ? $value['minimum_fare'] : ''; ?> </td>
												<td><?= isset($value['fare_after_5_km']) ? $value['fare_after_5_km'] : ''; ?></td>
												<td><?= isset($value['waiting_ride_charges']) ? $value['waiting_ride_charges'] : ''; ?></td>
												<td><?= isset($value['night_charges']) ? $value['night_charges'] : ''; ?></td>
												<td><?= isset($value['is_applicable_night']) ? $value['is_applicable_night'] : ''; ?></td>
												<td><?= isset($value['applicable_night_ride']) ? $value['applicable_night_ride'] : ''; ?></td>
												<td><?= isset($value['is_strike']) ? $value['is_strike'] : ''; ?></td>
												<td><?= isset($value['strike_charge']) ? $value['strike_charge'] : ''; ?></td>
                                                <td class="center">
                                                   <a href="<?php echo base_url('admin/CabFare/add/'.$value['id']); ?>" class="btn btn-tbl-edit btn-xs">
                                                   <i class="fa fa-pencil"></i>
                                                   </a>
                                                   <!-- <a class="btn btn-tbl-delete btn-xs" href="<?php echo base_url('admin/CabFare/deleteCabFare/'.$value['id']); ?>">
                                                   <i class="fa fa-trash-o "></i>
                                                   </a> -->
                                                </td>
										    <?php $i++; } } ?>
                                             </tr>
                                          </tbody>
                                       </table>
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
      <script type="text/javascript">
         $(".delete").on('click',()=>{
           var r = confirm("Are you sure to delete this Cab fare ?");
           if (r == true) {
             return true;
           } else {
             return false;
           }
         });
      </script>
   </body>
</html>