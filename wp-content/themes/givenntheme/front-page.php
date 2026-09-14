<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package givenntheme
 */

get_header();
?>

<header class="min-vh-100 bg-light">
   <!-- Jumbotron -->
   <div class="jumbotron d-flex flex-column justify-content-center align-items-center min-vh-100 text-center">
      <div class="mb-2" style="background: #f8f9fac7; border-radius: 100px; padding: 25px;">
         <a class="navbar-brand order-lg-1" href="<?=home_url()?>">
            <img src="<?=wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) , 'full' )[0]?>" width="100" height="100" class="" alt="logo">
         </a>
      </div>
		<h1>الموقع الأول للمقايضة وتبادل المنتجات في المملكة</h1>
		<p>قايض منتجاتك بكل سهولة وأمان.</p>
		<a href="#sections" class="btn btn-secondary px-5 py-4 fs-5">تصفح أقسام الموقع</a>
	</div>
	<!-- /Jumbotron -->
</header>

<?php
$sections = get_terms([
   'taxonomy' => 'sections',
   'hide_empty' => false,
]);

?>
<div id="sections" class="area py-5">
   <div class="container mb-4">
      <h1 class="text-center mb-5">أقسام الموقع</h1>
      <div class="row g-2">
         <?php foreach( $sections as $section ): ?>
            <div class="col-12 col-md-6 col-lg-4">
               <div class="card text-light shadow-lg" style="border: 0;">
                  <img src="<?=get_field( 'section_image', $section)?>" class="card-img" height="300" alt="...">
                  <div class="card-img-overlay d-flex flex-column justify-content-end" style="
                     box-shadow: inset 0px -130px 30px 6px #000000a3;
                     border: 15px solid transparent;
                     border-radius: 20px;
                  ">
                     <h4 class="card-title"><?=$section->name?></h4>
                     <p class="card-text"><?=$section->description?></p>
                  </div>
                  <a href="<?=home_url('section/' . $section->slug)?>" class="stretched-link"></a>
               </div>
            </div>
         <?php endforeach; ?>
      </div>
   </div>

   <ul class="circles">
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
   </ul>
</div>

<?php
// get_sidebar();
get_footer();
