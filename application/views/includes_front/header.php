<!DOCTYPE html>
      <html lang="zxx">
<head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
            <link rel="stylesheet" href="<?php echo base_url();?>assets/css/animate.css">
            <link rel="stylesheet" href="<?php echo base_url();?>assets/css/swiper.min.css">
            <link rel="stylesheet" href="<?php echo base_url();?>assets/css/font.css">
            <link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.min.css">
            <link rel="stylesheet" href="<?php echo base_url();?>assets/css/comman.css">
            <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style7.css">
            <link rel="shortcut icon" type="image/ico" href="assets/images/index7/fav.png" />
            <title>Aapni Taxi</title>
         </head>

         <style>
         .modal-content{
            padding:10px;
         }
         </style>
         <body>
            <!-- Preloader Box -->
            <div class="preloader_wrapper preloader_active preloader_open">
               <div class="preloader_holder">
                  <div class="preloader d-flex justify-content-center align-items-center h-100">
                     <span></span>
                     <span></span>
                     <span></span>
                  </div>
               </div>
            </div>
            <!--===Header Start===-->
            <div class="cs_top_header_wrapper">
               <div class="container">
                  <div class="row">
                     <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                        <div class="cs_top_header_info">
                           <div class="cs_top_header_info_call">
                              <p><img src="<?php echo base_url();?>assets/images/index7/call.svg" class="img-fluid" alt="images">Call Us Now - <span>(+91) 7300006336</span></p>
                           </div>
                           <div class="cs_top_header_info_mail">
                              <p><img src="<?php echo base_url();?>assets/images/index7/envelope.svg" class="img-fluid" alt="images">Email Us Now - <span> support@aapnitaxi.com</span></p>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                        <div class="cs_top_header_info_btn">
                           <a href="#" class="home_btn" data-toggle="modal" data-target="#exampleModal2">Register free </a> |
                         <a href="#" class="home_btn" data-toggle="modal" data-target="#exampleModal1"> Sign in</a>
                        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                           <div class="modal-dialog">
                              <div class="modal-content">
       <div class="modal-header">
         <h3 style="color:black">Login Here</h3>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          
         <form action="" method="post">
            <input type="hidden" name="vendor_id">
               <div class="sign-form" style="text-align: center;">
                  <div class="form-group">
                     <input type="text" class="form-control" id="email" placeholder="Email" name="email">
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control" id="password" placeholder="password" name="password">
                  </div>
                     <button type="submit" name="submit" value="submit" class="btn btn-primary" style="background: #fca901;border: #fca901">Login</button>
               </div>
         </form>
       </div>
      </div>
    </div>  

    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                           <div class="modal-dialog">
                              <div class="modal-content">
       <div class="modal-header">
         <h3 style="color:black">Register Here</h3>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          
         <form action="<?php echo base_url(); ?>Dashboard/registerUser" method="post">
            <input type="hidden" name="vendor_id">
               <div class="sign-form" style="text-align: center;">
                  <div class="form-group">
                     <input type="text" class="form-control" id="name" placeholder="Name" name="name">
                  </div>
                  <div class="form-group">
                     <input type="email" class="form-control" id="email" placeholder="Email" name="email">
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control" id="contact" placeholder="Contact" name="contact">
                  </div> 
                  <div class="form-group">
                     <input type="text" class="form-control" id="password" placeholder="password" name="password">
                  </div>
                     <button type="submit" name="submit" value="submit" class="btn btn-primary" style="background: #fca901;border: #fca901">Sign up</button>
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
            <!--===Main Header Start===-->
            <div class="cs_header_wrapper">
               <div class="container">
                  <div class="row align-items-center">
                     <div class="col-lg-3 col-md-4 col-sm-4 col-5">
                        <div class="cs_logo">
                           <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/images/index7/aapni_taxi1.png
" style="height: 80px;width: 100px;" alt="logo" /></a>
                        </div>
                     </div>
                     <div class="col-lg-9 col-md-8 col-sm-8 col-7">
                        <div class="cs_main_menu main_menu_parent">
                           <!-- Header Menus -->
                           <div class="cs_nav_items main_menu_wrapper text-right">
                              <ul class="cs_menu_list">
                                 <li class="has_submenu active">
                                    <a href="<?php echo base_url();?>Dashboard/index/">Home</a>
                                 </li>
                                 <li><a href="<?php echo base_url();?>Dashboard/about">About Us</a></li>
                                 <li><a href="<?php echo base_url();?>Dashboard/contact">Contact</a></li>
                              </ul>
                           </div>
                           <div class="cs_search_wrap menu_btn_wrap">
                              <ul class="display_flex">
                                 <li>
                                    <a href="javascript:void(0);" class="menu_btn">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    </a>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>