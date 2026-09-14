<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package givenntheme
 */

get_header();
setup_postdata( get_the_ID() );
?>

<div class="pub-page my-5">
   <div class="container">
      <div class="row g-3">
         <!-- Page Content -->
         <div class="col-12">
            <div class="container">

               <!-- Pub Area -->
               <div class="rounded pb-1">

                  <!-- Head -->
                  <div class="container">
                     <div class="row py-2 mb-2 border rounded shadow-lg align-items-center">
                        <div class="col-12 fs-2"><?=get_the_title()?></div>
                        <div class="col">
                           <p class="card-text mb-1">
                              <span class="meta-info p-0 me-1 d-inline-block">
                                 <i class="las la-user"></i>
                                 <span class="text-decoration-none text-dark"> <?=get_userdata( get_the_author_meta('ID') )->display_name?></span>
                              </span>
                              <span class="meta-info p-0 me-1 d-inline-block">
                                 <i class="las la-calendar-day"></i> <?=get_the_date()?>
                              </span>
                           </p>
                        </div>
                     </div>
                  </div>
                  <!-- /Head -->

                  <div class="row g-1">
                     <div class="col-12 col-md-6">
                        <!-- gallery -->
                        <div class="pub-gallery">
                           <img src="<?=get_the_post_thumbnail_url()?>"
                              class="img-fluid img-thumbnail rounded mh-25" />
                        </div>
                        <!-- /gallery -->
                     </div>
                     <div class="col-12 col-md-6">
                        <!-- Pub details -->
                        <div class="container">
                           <div class="row py-2 mb-3 border bg-white rounded shadow-lg align-items-center">
                              <div class="col-12 py-3 mb-2 text-center text-bg-secondary">تفاصيل المنتج</div>
                              <div class="col-12 row">
                                 <div class="col-5 col-lg-2 option-name">صاحب المنتج</div>
                                 <div class="col-7 col-lg-10 option-value"><?=get_userdata( get_the_author_meta('ID') )->display_name?></div>
                              </div>
                              <hr class="my-2" style="border-color: #c4c4c4;">
                              <div class="col-12 row">
                                 <div class="col-5 col-lg-2 option-name">أريد المقايضة بــ</div>
                                 <div class="col-7 col-lg-10 option-value"><?=get_the_content()?></div>
                              </div>
                              <hr class="my-2" style="border-color: #c4c4c4;">
                              <div class="col-12 row text-center">
                                    <?php if( ! is_user( 'owner' ) && get_the_author_meta('ID') !== get_current_user_id() ): ?>
                                       <div class="col-6 option-name"><button class="btn btn-success" data-bs-target="#message-modal" data-bs-toggle="modal">تواصل مع صاحب المنتج</button></div>
                                       <div class="col-6 option-value"><button data-bs-target="#report-modal" data-bs-toggle="modal" class="btn btn-danger">تبليغ عن منتج مخالف</button></div>
                                    <?php endif; ?>

                                    <?php if( get_the_author_meta('ID') == get_current_user_id() ): ?>
                                       <div class="col-12 option-value"><button id="delete-post" data-url="<?=get_delete_post_link(get_the_ID())?>" data-redirect="<?=home_url()?>" class="btn btn-warning">حذف المنتج</button></div>
                                    <?php endif; ?>
                                    
                                    <?php if( is_user( 'owner' ) ): ?>
                                       <div class="col-12 option-value"><a href="<?=admin_url('edit.php?post_type=product')?>" class="btn btn-secondary">المنتجات</a></div>
                                    <?php endif; ?>
                              </div>
                           </div>
                        </div>
                        <!-- /Pub details -->
                     </div>
                  </div>
               </div>
               <!-- /Pub Area -->

            </div>
         </div>
         <!-- /Page Content -->
      </div>
   </div>
</div>

<!-- Message Modal -->
<div class="modal fade" id="message-modal" tabindex="-1" aria-labelledby="messageLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <?php if( is_user_logged_in() ): ?>
            <form id="message-form" action="<?=admin_url( 'admin-ajax.php' )?>">
               <input type="hidden" name="product_title" value="<?=get_the_title()?>">
               <input type="hidden" name="product_owner" value="<?=get_the_author_meta('ID')?>">
               <div class="modal-header bg-light">
                  <h5 class="modal-title" id="messageLabel"><i class="las la-sign-in-alt"></i> إرسال رسالة إلى: <span><?=get_userdata( get_the_author_meta('ID') )->display_name?></span></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  <div class="input-group mb-3">
                     <label class="input-group-text"><i class="las la-edit fs-4"></i></label>
                     <textarea class="form-control" name="content" rows="10" placeholder="اسأل مقدم هذا المنتج  ما تريد معرفته عن المنتج المعروض، وماذا لديك لتقايضه" required></textarea>
                  </div>
                  <div class="form-check">
                     <input class="form-check-input" type="checkbox" value="1" id="flexCheckChecked" checked required>
                     <label class="form-check-label" for="flexCheckChecked">لقد راجعت شروط هذا الموقع وتعليماته</label>
                  </div>
               </div>
               <div class="modal-footer justify-content-center">
                  <button type="submit" class="btn btn-outline-dark btn-light"><i class="las la-paper-plane fs-5"></i> أرسل الرسالة</button>
               </div>
            </form>
         <?php else: ?>
            <div class="alert alert-warning m-2" role="alert">يجب عليك تسجيل الدخول للتمكن من مراسلة صاحب المنتج!</div>
            <div class="mx-auto mb-2">
               <button class="btn btn-outline-dark" data-bs-target="#myaccount-modal" data-bs-toggle="modal"><i class="lar la-user-circle fs-5"></i> حسابي</button>
            </div>
         <?php endif; ?>
      </div>
   </div>
</div>
<!-- /Message Modal -->

<!-- Report Modal -->
<div class="modal fade" id="report-modal" tabindex="-1" aria-labelledby="reportLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <form id="report-from" action="<?=admin_url( 'admin-ajax.php' )?>">
            <input type="hidden" name="product_id" value="<?=get_the_ID()?>">
            <input type="hidden" name="product_title" value="<?=get_the_title()?>">
            <div class="modal-header bg-light">
               <h5 class="modal-title" id="reportLabel"><i class="las la-sign-in-alt"></i> تقديم بلاغ</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="input-group mb-3">
                  <label class="input-group-text"><i class="las la-question-circle fs-4"></i></label>
                  <select class="form-select" name="type" required>
                     <option value="" hidden>سبب البلاغ</option>
                     <?php foreach( get_terms(['taxonomy' => 'types','hide_empty' => false, 'orderby' => 'term_id']) as $type ): ?>
                        <option value="<?=$type->name?>"><?=$type->name?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
               <div class="input-group mb-3">
                  <label class="input-group-text"><i class="las la-edit fs-4"></i></label>
                  <textarea class="form-control" name="content" rows="10" placeholder="نص البلاغ" required></textarea>
               </div>
            </div>
            <div class="modal-footer justify-content-center">
               <button type="submit" class="btn btn-outline-dark btn-light"><i class="las la-paper-plane fs-5"></i> أرسل البلاغ</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- /Report Modal -->
<?php
get_footer();
