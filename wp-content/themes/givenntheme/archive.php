<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package givenntheme
 */

get_header();

$section_name = wp_strip_all_tags( explode( ' ', get_the_archive_title() )[1] );
?>
<div class="pub-page my-5">
	<div class="container">
		<div class="row g-3">
			<!-- Page Content -->
			<div class="col-12">
				<div class="container">

					<!-- Pub Area -->
					<div class="border rounded pb-1 mb-2 shadow" style="border-color: #e5e5e5 !important;">
						<!-- Add new Pub -->
						<div class="container">
							<div class="row py-2 mb-3 rounded shadow-lg align-items-center">
								<div class="col"><?php the_archive_title( '<h1 class="m-0 p-0">', '</h1>' ); ?><br> <?php the_archive_description( '<div class="m-0 p-0">', '</div>' );?></div>
								<div class="col text-end">
									<?php if( is_user_logged_in() ): ?>
										<?php if( is_user( 'publisher' ) ): ?>
											<a href="<?=admin_url('post-new.php?post_type=product')?>" class="btn btn-success"><i class="las la-plus-circle"></i> أضف منتجا</a>
										<?php endif; ?>
									<?php else: ?>
										<button class="btn btn-success" data-bs-target="#product-modal" data-bs-toggle="modal"><i class="las la-plus-circle"></i> أضف منتجا</button>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<!-- /Add new Pub -->

						<!-- Pub list -->
						<div class="container mb-3">
							<div class="row g-3">
								<?php
								// dd(get_the_archive_title());
									$products = new WP_Query([
										'post_type'       => ['product'],
										'tax_query' => array(
											array(
												'taxonomy' => 'sections',
												'field'    => 'name',
												'terms'    => [$section_name],
											),
										),
										'posts_per_page'  => 15,
										'post_status'     => 'publish',
										'order'           => 'DESC',
									]);
								?>
								<?php if ( $products->have_posts() ) : ?>
									<?php
									while ( $products->have_posts() ) : $products->the_post();
									?>
										<div class="col-12 col-sm-6 col-lg-4">
											<div class="card border-0 shadow">
												<img src="<?=get_the_post_thumbnail_url()?>" class="card-img-top w-100 rounded-top" style="height: 295px;" alt="...">
												<div class="card-body py-3 pb-2 px-3">
													<span class="card-title"
														style="text-align: justify;font-size:0.95rem; font-weight: 600;">
														<?=get_the_title()?>
													</span>
													<p class="card-text mb-1">
														<span class="meta-info p-0 me-1 d-inline-block">
															<i class="las la-user"></i>
															<span class="text-decoration-none text-dark"> <?=get_userdata( get_the_author_meta('ID') )->display_name?></span>
														</span>
														<span class="meta-info p-0 me-1 d-inline-block">
															<i class="las la-calendar-day"></i> <?=get_the_date()?>
														</span>
													</p>
													<a href="<?=get_the_permalink()?>" class="stretched-link"></a>
												</div>
											</div>
										</div>
									<?php endwhile; wp_reset_postdata(); ?>
								<?php else:
									get_template_part( 'template-parts/content', 'none' );
								endif;
								?>
								

							</div>
						</div>
						<!-- /Pub list -->

					</div>
					<!-- /Pub Area -->

				</div>
			</div>
			<!-- /Page Content -->
		</div>
	</div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="product-modal" tabindex="-1" aria-labelledby="messageLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
			<div class="alert alert-warning m-2" role="alert">يجب عليك تسجيل الدخول للتمكن من إضافة منتج!</div>
			<div class="mx-auto mb-2">
				<button class="btn btn-outline-dark" data-bs-target="#myaccount-modal" data-bs-toggle="modal"><i class="lar la-user-circle fs-5"></i> حسابي</button>
			</div>
      </div>
   </div>
</div>
<!-- /Add Product Modal -->

<?php
get_footer();
