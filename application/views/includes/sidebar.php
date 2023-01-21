<div class="sidebar-container">
				<div class="sidemenu-container navbar-collapse collapse fixed-menu">
					<div id="remove-scroll">
						<ul class="sidemenu page-header-fixed p-t-20" data-keep-expanded="false" data-auto-scroll="true"
							data-slide-speed="200">
							<li class="sidebar-toggler-wrapper hide">
								<div class="sidebar-toggler">
									<span></span>
								</div>
							</li>
							<li class="sidebar-user-panel">
								<div class="user-panel">
									<div class="pull-left image">
										<img src="<?php echo base_url(); ?>source/assets/img/8369.jpg" class="img-circle user-img-circle"
										alt="User Image" />
									</div>
									<div class="pull-left info">
										<p> Admin</p>
										<a title="Logout" href="<?php echo base_url('admin/Login/Logout'); ?>"><i
											class="material-icons">power_settings_new</i></a>
									</div>
								</div>
							</li>
							
							<li class="nav-item active">
								<a href="<?php echo base_url('admin/'); ?>" class="nav-link nav-toggle">
									<i class="material-icons">dashboard</i>
									<span class="title">Dashboard</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link nav-toggle">
									<i class="material-icons">local_atm</i>
									<span class="title">Cab Fare</span>
									<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
									<li class="nav-item">
										<a href="<?php echo base_url('admin/CabFare/add'); ?>" class="nav-link ">
											<span class="title">Add</span>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo base_url('admin/CabFare/cabFareListing'); ?>" class="nav-link ">
											<span class="title">List</span>
										</a>
									</li>
								</ul>
							</li>
							
							<li class="nav-item">
								<a href="#" class="nav-link nav-toggle">
									<i class="material-icons">person</i>
									<span class="title">Driver</span>
									<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
									<li class="nav-item">
										<a href="<?php echo base_url('admin/Driver/addDriver'); ?>" class="nav-link ">
											<span class="title">Add</span>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo base_url('admin/Driver/DriverListing'); ?>" class="nav-link ">
											<span class="title">List</span>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo base_url('admin/Driver/onlineDriver'); ?>" class="nav-link ">
											<span class="title">Online Driver</span>
										</a>
									</li>
								</ul>
							</li>
							
							<li class="nav-item">
								<a href="#" class="nav-link nav-toggle">
									<i class="material-icons">group</i>
									<span class="title">Owner</span>
									<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
								    <li class="nav-item">
										<a href="<?php echo base_url('admin/Owner/addOwner'); ?>" class="nav-link ">
											<span class="title">Add Owner</span>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo base_url('admin/Owner/ownerList'); ?>" class="nav-link ">
											<span class="title">Owner List</span>
										</a>
									</li>
								</ul>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link nav-toggle">
									<i class="material-icons">local_taxi</i>
									<span class="title">Trip</span>
									<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
								    <li class="nav-item">
										<a href="<?php echo base_url('admin/Trips/activeTrips'); ?>" class="nav-link ">
											<span class="title">Active Trips</span>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo base_url('admin/Trips/completedTrips'); ?>" class="nav-link ">
											<span class="title">Completed Trip</span>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo base_url('admin/Trips/cancelledTrips'); ?>" class="nav-link ">
											<span class="title">Cancelled Trip</span>
										</a>
									</li>
								</ul>
							</li>
							<li class="nav-item">
								<a href="<?php echo base_url('admin/Payments/listPayments'); ?>" class="nav-link nav-toggle">
									<i class="material-icons">Pay</i>
									<span class="title">Payments</span>
									<!--<span class="arrow"></span>-->
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo base_url('admin/SOS/'); ?>" class="nav-link nav-toggle">
									<i class="material-icons">map</i>
									<span class="title">SOS</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo base_url('admin/User/') ?>" class="nav-link nav-toggle">
									<i class="material-icons">group</i>
									<span class="title">Customer</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo base_url('admin/Dashboard/referral_master') ?>" class="nav-link nav-toggle">
									<i class="material-icons">group</i>
									<span class="title">Referral Master</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>