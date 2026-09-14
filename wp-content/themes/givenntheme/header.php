<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package givenntheme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<nav class="navbar navbar-expand-sm main-navbar py-lg-0">
   <div class="container">
      <?php if( is_front_page() ): ?>
         <button class="btn btn-secondary" data-bs-target="#search-modal" data-bs-toggle="modal"><i class="las la-search fs-5"></i> البحث</button>
      <?php else: ?>
         <a href="<?=home_url()?>" class="text-uppercase fs-3 text-reset text-decoration-none" style="letter-spacing: 3px;"><?=bloginfo( 'name' )?></a>
      <?php endif; ?>
      <div class="ps-2 order-lg-3">
         <!-- <button class="btn btn-secondary ms-auto" data-bs-target="#addpub-modal" data-bs-toggle="modal">
            <i class="las la-plus-circle fs-5"></i> أعلن الآن!
         </button> -->
      </div>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
         aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse order-lg-2" id="navbarNavDropdown">
         <!-- <ul class="navbar-nav">
            <li class="nav-item">
               <a class="nav-link _active" aria-current="page" href="cars.html"><i class="las la-car"></i>عنصر</a>
            </li>
         </ul> -->
         <!-- <span class="navbar-text ms-auto">
            <button class="btn btn-secondary" data-bs-target="#search-modal" data-bs-toggle="modal"><i class="las la-search fs-5"></i> البحث</button>
         </span> -->
         <span class="navbar-text ms-auto">
            <ul class="navbar-nav flex-row justify-content-center">
               <!-- <li class="nav-item pe-2">
                  <button class="btn btn-secondary" data-bs-target="#search-modal" data-bs-toggle="modal"><i class="las la-search fs-5"></i></button>
               </li> -->
               <li class="nav-item">
                  <?php if( ! is_user_logged_in() ): ?>
                     <button class="btn btn-outline-dark" data-bs-target="#myaccount-modal" data-bs-toggle="modal"><i class="lar la-user-circle fs-5"></i> حسابي</button>
                  <?php else: ?>
                     <div class="dropdown">
                        <button class="btn btn-secondary ms-auto dropdown-toggle" id="dropdownMenuButton1"
                           data-bs-toggle="dropdown" aria-expanded="false">
                           <i class="las la-user fs-5"></i> حسابي
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                           <li><a class="dropdown-item" href="<?=admin_url()?>"><i class="las la-user-circle fs-5"></i> <?=wp_get_current_user()->data->display_name?></a></li>
                           <li>
                              <hr class="dropdown-divider">
                           </li>
                           <?php if( is_user( 'publisher' ) ): ?>
                              <li><a class="dropdown-item" href="<?=admin_url('edit.php?post_type=message')?>"><i class="las la-envelope fs-5"></i> الرسائل</a></li>
                              <li><a class="dropdown-item" href="<?=admin_url('edit.php?post_type=product')?>"><i class="las la-suitcase-rolling fs-5"></i> منتجاتي</a></li>
                              <?php else: ?>
                                 <li><a class="dropdown-item" href="<?=admin_url('edit.php?post_type=report')?>"><i class="las la-exclamation-circle fs-5"></i> البلاغات</a></li>
                                 <li><a class="dropdown-item" href="<?=admin_url('edit.php?post_type=product')?>"><i class="las la-suitcase-rolling fs-5"></i> المنتجات</a></li>
                           <?php endif; ?>
                           <li><a class="dropdown-item" href="<?=admin_url('profile.php')?>"><i class="las la-user-edit fs-5"></i> تعديل الحساب</a></li>
                           <li>
                              <hr class="dropdown-divider">
                           </li>
                           <li><a class="dropdown-item" href="<?=wp_logout_url()?>"><i class="las la-sign-out-alt fs-5"></i> تسجيل الخروج</a></li>
                        </ul>
                     </div>
                  <?php endif; ?>
               </li>
            </ul>
         </span>
      </div>
   </div>
</nav>

<!-- My Account Modal -->
<div class="modal fade" id="myaccount-modal" tabindex="-1" aria-labelledby="myaccountLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header bg-light">
            <h5 class="modal-title" id="myaccountLabel"><i class="las la-user-circle"></i> حسابي
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row g-2">
               <div class="col-6 text-center">
                  <a href="<?=wp_login_url()?>" class="btn btn-white p-5 w-100 border shadow-lg"><i class="las la-user-check d-block fs-1"></i> تسجيل الدخول</a>
               </div>
               <div class="col-6 text-center">
                  <a href="<?=wp_registration_url()?>" class="btn btn-white border p-5 w-100 shadow-lg"><i class="las la-user-plus d-block fs-1"></i> تسجيل حساب</a></div>
            </div>
         </div>
         <!-- <div class="modal-footer justify-content-center"></div> -->
      </div>
   </div>
</div>
<!-- /My Account Modal -->

<!-- Search Modal -->
<div class="modal fade" id="search-modal" tabindex="-1" aria-labelledby="myaccountLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header bg-light">
            <h5 class="modal-title" id="myaccountLabel"><i class="las la-user-circle"></i> البحث عن منتج..</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form role="search" method="get" class="text-center" action="<?= home_url( '/' ); ?>">
               <label>
                  <span class="screen-reader-text">البحث عن:</span>
                  <input type="search" class="form-control form-control-lg w-100" placeholder="اكتب اسم المنتج.." value="<?= get_search_query() ?>" name="s" minlength="3" required>   
               </label>
               <input type="submit" class="btn btn-secondary btn-lg" value="بحث">
            </form>
         </div>
         <!-- <div class="modal-footer justify-content-center"></div> -->
      </div>
   </div>
</div>
<!-- /Search Modal -->
