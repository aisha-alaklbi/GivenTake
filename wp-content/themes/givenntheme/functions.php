<?php
/**
 * givenntheme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package givenntheme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

function dd($x){die(var_dump($x));}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function givenntheme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on givenntheme, use a find and replace
		* to change 'givenntheme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'givenntheme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'givenntheme' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'givenntheme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'givenntheme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function givenntheme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'givenntheme_content_width', 640 );
}
add_action( 'after_setup_theme', 'givenntheme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function givenntheme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'givenntheme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'givenntheme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'givenntheme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function givenntheme_scripts() {
	wp_enqueue_style( 'givenntheme-style', get_stylesheet_uri(), [], _S_VERSION );
	wp_style_add_data( 'givenntheme-style', 'rtl', 'replace' );

	wp_enqueue_style( 'cairo-font', 'https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap', [], _S_VERSION );
	wp_enqueue_style( 'line-awesome', 'https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css', [], _S_VERSION );

	// wp_enqueue_script( 'givenntheme-navigation', get_template_directory_uri() . '/js/navigation.js', [], _S_VERSION, true );
	wp_enqueue_script( 'manifest', get_template_directory_uri() . '/assets/js/manifest.js', [], _S_VERSION, true );
	wp_enqueue_script( 'vendor', get_template_directory_uri() . '/assets/js/vendor.js', [], _S_VERSION, true );
	wp_enqueue_script( 'app', get_template_directory_uri() . '/assets/js/app.js', [], _S_VERSION, true );

	// if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	// 	wp_enqueue_script( 'comment-reply' );
	// }
}
add_action( 'wp_enqueue_scripts', 'givenntheme_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Clean garbage
 */
require get_template_directory() . '/inc/cleaner.php';

/**
 * Helper function: determin if user is on registration page.
 */
function is_on_registration_page() {
	return $GLOBALS['pagenow'] == 'wp-login.php' && isset($_REQUEST['action']) && $_REQUEST['action'] == 'register';
}

/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
/*----------------------------------------------------------------------------------Start Custom Coding ---------------------------------------------------------------------------- */
/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */

/**
 * Add registration custom fields.
 */
add_action('register_form', function () {
?>
	<p>
		<label for="user_phone">رقم الجوال</label>
		<input type="text" name="user_phone" id="user_phone" class="input" value="" size="100">
	</p>

	<p>
		<label for="pass1"><?php _e( 'Password' ); ?></label>
		<input type="password" name="password" class="input password-input" size="24">
	</p>
<?php
});

add_filter('registration_errors', function ($errors) {
	if ( empty( $_POST['user_phone'] ) ) {
		$errors->add('phone-required', '<strong>Error</strong>: Please enter a phone number.');
	}
	if ( empty( $_POST['password'] ) ) {
		$errors->add('password-required', '<strong>Error</strong>: Please enter a password.');
	}

	return $errors;
});

add_action( 'user_register', function ( $user_id ) {
	if ( ! empty( $_POST['user_phone'] ) ) {
		update_user_meta( $user_id, 'user_phone', $_POST['user_phone'] );
	}
	if ( ! empty( $_POST['password'] ) ) {
		update_user_meta( $user_id, 'user_phone', $_POST['user_phone'] );
	}
} );

add_filter('random_password', function ( $password ) {
	if ( is_on_registration_page() && ! empty( $_POST['password'] ) ) {
		$password = $_POST['password'];
	}

	return $password;
});

// ============================================================================================================
// ============================================================================================================

/**
 * The markup printing for profile custom fields.
 *
 * @param $user WP_User user object
 */
function giventake_usermeta_form_fields( $user ) {

	// dd( get_user_meta( $user->ID ) );


	$user_meta = is_object( $user ) && get_user_meta( $user->ID ) ? get_user_meta( $user->ID ) : null;
	$user_meta = isset( $user_meta ) ? array_map( fn($v) => $v[0], $user_meta ) : null;

	$user_phone = $user_meta['user_phone'] ?? '';
?>
	<table class="form-table" role="presentation">
		<tbody>
			<tr>
				<th><label>رقم الجوال</label></th>
				<td><input type="text" name="user_phone" class="regular-text code" value="<?=$user_phone?>"></td>
			</tr>
		</tbody>
	</table>
<?php
}

/**
 * The save action for profile custom fields.
 *
 * @param $user_id int the ID of the current user.
 *
 * @return bool Meta ID if the key didn't exist, true on successful update, false on failure.
 */
function giventake_usermeta_form_fields_update( $user_id ) {
	// check that the current user have the capability to edit the $user_id
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	return update_user_meta( $user_id, 'user_phone', $_POST['user_phone'] ?? '' );
}

// Add the field to user's own profile editing screen.
add_action('show_user_profile', 'giventake_usermeta_form_fields');
// Save action to user's own profile editing screen update.
add_action('personal_options_update', 'giventake_usermeta_form_fields_update');

// Add the field to user profile editing screen.
add_action('edit_user_profile', 'giventake_usermeta_form_fields'); 
// Save action to user profile editing screen update.
add_action('edit_user_profile_update', 'giventake_usermeta_form_fields_update');

// Add the field to "add new user" form
add_action('user_new_form', 'giventake_usermeta_form_fields');
// Save meta from "add new user" form
add_action('user_register', 'giventake_usermeta_form_fields_update');

// ============================================================================================================
// ============================================================================================================

/**
 * Sections Custom Taxonomy.
 */
$SectionsTaxonomy = [
	'id'   => 'sections',
	'cpt'  => ['product'],
	'args' => [
		'hierarchical'       => true,
		'labels'             => [
			'name'               => 'الأقسام',
			'singular_name'      => 'القسم',
			'search_items'       => 'بحث الأقسام',
			'all_items'          => 'كل الأقسام',
			'parent_item'        => 'القسم الأب',
			'parent_item_colon'  => 'القسم الأب:',
			'edit_item'          => 'تعديل القسم', 
			'update_item'        => 'تحديث القسم',
			'add_new_item'       => 'إضافة قسم جديد',
			'new_item_name'      => 'اسم القسم الجديد',
			'menu_name'          => 'الأقسام',
		],
		'show_ui'            => true,
		'show_in_rest'       => true,
		'show_admin_column'  => true,
		'query_var'          => true,
		'rewrite'            => [ 'slug' => 'section' ],
	]
];
add_action('init', function() {
	global $SectionsTaxonomy;
	register_taxonomy($SectionsTaxonomy['id'], $SectionsTaxonomy['cpt'], $SectionsTaxonomy['args']);
});

// ProductsCPT details
$ProductsCPT = [
   'id'   => 'product',
   'args' => [
      'public'              => true, 
      'labels'              => [
         'name'                => 'المنتجات',
         'singular_name'       => 'المنتج',
         'menu_name'           => 'المنتجات',
         'parent_item_colon'   => 'المنتج الأب',
         'all_items'           => 'جميع المنتجات',
         'view_item'           => 'عرض المنتج',
         'add_new_item'        => 'إضافة منتج جديد',
         'add_new'             => 'إضافة جديد',
         'edit_item'           => 'تعديل منتج',
         'update_item'         => 'تحديث منتج',
         'search_items'        => 'بحث منتج',
         'not_found'           => 'غير موجود',
         'not_found_in_trash'  => 'غير موجود في سلة المهملات',
			'featured_image' 		 => 'صورة المنتج',
			'set_featured_image'  => 'تعيين صورة المنتج',
			'remove_featured_image'  => 'حذف صورة المنتج',
      ],
      'has_archive'         => true,
      'public'              => true,
      'menu_icon'           => 'dashicons-editor-unlink',
      'exclude_from_search' => true,
      'publicly_queryable'  => true,
      'supports'            => ['title', 'editor', 'thumbnail', 'author'],
      'show_in_rest'        => true,
		'show_ui' 				 => true
   ]
];
add_action('init', function() {
   global $ProductsCPT;
   register_post_type( $ProductsCPT['id'], $ProductsCPT['args'] );
});

/**
 * Types Custom Taxonomy.
 */
$TypesTaxonomy = [
	'id'   => 'types',
	'cpt'  => ['report'],
	'args' => [
		'hierarchical'       => true,
		'labels'             => [
			'name'               => 'النوع',
			'singular_name'      => 'النوع',
			'search_items'       => 'بحث الأنواع',
			'all_items'          => 'كل الأنواع',
			'parent_item'        => 'النوع الأب',
			'parent_item_colon'  => 'النوع الأب:',
			'edit_item'          => 'تعديل النوع', 
			'update_item'        => 'تحديث النوع',
			'add_new_item'       => 'إضافة نوع جديد',
			'new_item_name'      => 'اسم النوع الجديد',
			'menu_name'          => 'الأنواع',
		],
		'show_ui'            => true,
		'show_in_rest'       => true,
		'show_admin_column'  => true,
		'query_var'          => true,
		'rewrite'            => [ 'slug' => 'types' ],
	]
];
add_action('init', function() {
	global $TypesTaxonomy;
	register_taxonomy($TypesTaxonomy['id'], $TypesTaxonomy['cpt'], $TypesTaxonomy['args']);
});

// ReportCPT details
$ReportCPT = [
   'id'   => 'report',
   'args' => [
      'public'              => true, 
      'labels'              => [
         'name'                => 'البلاغات',
         'singular_name'       => 'البلاغ',
         'menu_name'           => 'البلاغات',
         'parent_item_colon'   => 'البلاغ الأب',
         'all_items'           => 'جميع البلاغات',
         'view_item'           => 'عرض البلاغ',
         'add_new_item'        => 'إضافة بلاغ جديد',
         'add_new'             => 'إضافة جديد',
         'edit_item'           => 'تعديل بلاغ',
         'update_item'         => 'تحديث بلاغ',
         'search_items'        => 'بحث بلاغ',
         'not_found'           => 'غير موجود',
         'not_found_in_trash'  => 'غير موجود في سلة المهملات',
      ],
      'has_archive'         => false,
      'public'              => true,
      'menu_icon'           => 'dashicons-info-outline',
      'exclude_from_search' => true,
      'publicly_queryable'  => false,
      'supports'            => ['title', 'editor'],
      'show_in_rest'        => false
   ]
];
add_action('init', function() {
   global $ReportCPT;
   register_post_type( $ReportCPT['id'], $ReportCPT['args'] );
});

// MessageCPT details
$MessageCPT = [
   'id'   => 'message',
   'args' => [
      'public'              => true, 
      'labels'              => [
         'name'                => 'الرسائل',
         'singular_name'       => 'الرسالة',
         'menu_name'           => 'الرسائل',
         'parent_item_colon'   => 'الرسالة الأب',
         'all_items'           => 'جميع الرسائل',
         'view_item'           => 'عرض الرسالة',
         'add_new_item'        => 'إضافة رسالة جديد',
         'add_new'             => 'إضافة جديد',
         'edit_item'           => 'تعديل رسالة',
         'update_item'         => 'تحديث رسالة',
         'search_items'        => 'بحث رسالة',
         'not_found'           => 'غير موجود',
         'not_found_in_trash'  => 'غير موجود في سلة المهملات',
      ],
      'has_archive'         => true,
      'public'              => true,
      'menu_icon'           => 'dashicons-email-alt',
      'exclude_from_search' => true,
      'publicly_queryable'  => true,
      'supports'            => ['title', 'comments'],
      'show_in_rest'        => true
   ]
];
add_action('init', function() {
   global $MessageCPT;
   register_post_type( $MessageCPT['id'], $MessageCPT['args'] );
});

// ============================================================================================================
// ============================================================================================================

/**
 * Reports custom columns
 */
// Manage CPT posts columns.
add_action( 'manage_report_posts_columns', function( $columns ) {

	unset($columns['title']);

	$columns['content'] = 'نص البلاغ';
	$columns['product'] = 'المنتج';

	$order = array("cb","taxonomy-types", "product", "content", "date");
	$out = array();
	foreach($order as $k) {
		$out[$k] = $columns[$k];
	}

	// dd( $out );

	return $out;
});

// Set Custom Columns Values
add_action( 'manage_report_posts_custom_column', function ( $column, $post_id ) {
	
	$content = get_post($post_id, 'ARRAY_A')['post_content'];
	$product_id = get_post_meta( $post_id, '_report_product_id', true );
	$product = get_post($product_id, 'ARRAY_A');
	$product_title = $product['post_title'];
	$product_permalink = admin_url('post.php?post=' . $product_id . '&action=edit');

	switch( $column ) {
		case 'content':
			echo nl2br( $content );
			break;
		case 'product':
			echo '<a href="'.$product_permalink.'">'.$product_title.'</a>';
			break;
	}
}, 10, 2 );

// add_action( 'manage_message_posts_columns', function( $columns ) {

// 	dd( $columns );

// 	return $out;
// });

// Set Custom Columns Values
// add_action( 'manage_message_posts_custom_column', function ( $column, $post_id ) {

// 	if( $column == 'title' ){
// 		echo '---';
// 	}

// }, 10, 2 );

// ============================================================================================================
// ============================================================================================================
/**
 * Ajax handle for reporting products.
 */
function report_product(){

	$type = $_POST['type'];
	$content = $_POST['content'];
	$product_id = $_POST['product_id'];
	$product_title = $_POST['product_title'];

	$submit_report = wp_insert_post([
		'post_content' => $content, 
		'post_title' 	=> 'بلاغ عن: ' . $product_title,
		'post_status' 	=> 'publish',
		'post_type' 	=> 'report',
		'meta_input'	 	=> [
			'_report_product_id' => $product_id
		]
	]);

	wp_set_object_terms($submit_report, [sanitize_title( $type )], 'types');

	$response = isset( $submit_report ) ? 'ok' : false;
	wp_send_json( $response, 200 );
	// wp_send_json( $response, 200, JSON_UNESCAPED_UNICODE );
}
add_action('wp_ajax_report_product', 'report_product');
add_action('wp_ajax_nopriv_report_product', 'report_product');

/**
 * Ajax handle for messaging.
 */
function message(){

	$product_title = $_POST['product_title'];
	$product_owner = $_POST['product_owner'];

	$new_message = wp_insert_post([
		'post_content' => '', 
		'post_title' 	=> 'رسالة من: ' . get_userdata( get_current_user_id() )->display_name . ' إلى: ' . get_userdata( $product_owner )->display_name . ' بخصوص: ' . $product_title,
		'post_status' 	=> 'publish',
		'post_type' 	=> 'message',
		'meta_input'	 	=> [
			// '_message_sender' => get_current_user_id(),
			'_message_receiver' => $product_owner . '-' . get_current_user_id()
		]
	]);

	if( ! is_wp_error( $new_message ) ) {
		$content = $_POST['content'];
		$current_user = wp_get_current_user();
	
		$comment_id = wp_insert_comment( [
			'comment_post_ID'      => $new_message,
			'comment_content'      => $content,
			// 'comment_parent'       => ,
			'user_id'              => $current_user->ID,
			'comment_author'       => $current_user->user_login,
			'comment_author_email' => $current_user->user_email,
			'comment_author_url'   => $current_user->user_url
		]);
	}

	$response = ! is_wp_error( $comment_id ) ? 'ok' : false;
	wp_send_json( $response, 200 );
	// wp_send_json( $response, 200, JSON_UNESCAPED_UNICODE );
}
add_action('wp_ajax_message', 'message');
add_action('wp_ajax_nopriv_message', 'message');
