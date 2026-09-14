<?php

/**
 * Check user role.
 * 
 * @param string $role the role name.
 * @param int $user_id the user id || the current user id.
 * 
 * @return bool true if if the role is correct, false otherwise.
 */
function is_user ($role=NULL, $user_id=NULL) {
	if(empty($user_id)){
		$user = wp_get_current_user();
	} else {
		if( is_numeric($user_id) && $user_id == (int)$user_id ) {
			$user = get_user_by('id', (int)$user_id);
		} else if(is_string($user_id) && $email = sanitize_email($user_id)) {
			$user = get_user_by('email', $email);
		} else {
			return false;
		}
	}
		
	if(!$user) return false;
		
	return in_array( $role, (array)$user->roles, true ) !== false;
}

/**
 * Remove WordPress Dashboard Widgets
 * 
 */
add_action('wp_dashboard_setup', function () {
	global $wp_meta_boxes;

	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
	remove_action('welcome_panel', 'wp_welcome_panel');
});

/**
 * Remove "work" archive page menu link from the admin toolbar.
 *
 * @param WP_Admin_Bar $wp_admin_bar WP_Admin_Bar instance.
 */ 
add_action( 'admin_bar_menu', function ( $wp_admin_bar ) {
	// Remove customize, background and header from the menu bar.	
	$wp_admin_bar->remove_node( 'archive' );
	$wp_admin_bar->remove_node( 'view' );
	$wp_admin_bar->remove_node( 'new-content' );
	$wp_admin_bar->remove_node( 'comments' );
}, 999 );

/**
 * Remove unwanted links in Users' list table rows.
 * 
 * @link https://developer.wordpress.org/reference/hooks/user_row_actions/
 */
add_action( 'user_row_actions', function ( $actions  ) {
	if ( isset( $actions['view'] ) ) {
		unset( $actions['view'] );
	}
	return $actions;
}, 10, 1 );

/**
 * Remove unwanted links in Posts list table rows.
 * 
 * @link https://developer.wordpress.org/reference/hooks/post_row_actions/
 */
add_filter( 'post_row_actions', function( $actions, $post ) {

	unset($actions['view']); // Remove "View" link.
	unset($actions['inline hide-if-no-js']); // Remove "Quick Edit" link.
	unset($actions['edit']);
	unset($actions['trash']);

	return $actions;

}, 10, 2 );

/**
 * Removes some menus from admin menu in dashboard.
 * 
 */
add_action( 'admin_menu', function (){

	if( ! is_user('administrator') ) {
		// remove_menu_page( 'index.php' );                  			//Dashboard
		remove_menu_page( 'edit.php' );                   				//Posts
		remove_menu_page( 'upload.php' );                 				//Media
		remove_menu_page( 'edit.php?post_type=page' );    				//Pages
		remove_menu_page( 'edit-comments.php' );          				//Comments
		remove_menu_page( 'themes.php' );                 				//Appearance
		remove_menu_page( 'plugins.php' );                				//Plugins
		// remove_menu_page( 'users.php' );                  			//Users
		remove_menu_page( 'tools.php' );                  				//Tools
		remove_menu_page( 'edit.php?post_type=acf-field-group' );   //ACF
		remove_menu_page( 'options-general.php' );        		   //Settings
		
		// Remove settings subpages
		// remove_submenu_page( 'options-general.php', 'options-writing.php' );
		// remove_submenu_page( 'options-general.php', 'options-reading.php' );
		// remove_submenu_page( 'options-general.php', 'options-discussion.php' );
		// remove_submenu_page( 'options-general.php', 'options-media.php' );
		// remove_submenu_page( 'options-general.php', 'options-privacy.php' );
	}
	
	if( is_user( 'owner' ) ){
		remove_submenu_page( 'edit.php?post_type=product', 'post-new.php?post_type=product' );
		remove_submenu_page( 'edit.php?post_type=report', 'post-new.php?post_type=report' );
		remove_submenu_page( 'users.php', 'user-new.php' );
		remove_menu_page( 'edit.php?post_type=message' );
	}
		
	if( is_user( 'publisher' ) ){
		remove_menu_page( 'edit.php?post_type=report' );													//Reports
		remove_submenu_page( 'edit.php?post_type=message', 'post-new.php?post_type=message' ); //New message
	}
		
	});
	
/**
 * The new logo is the site custom logo.  
 *
 */
add_action( 'login_enqueue_scripts', function() { 
?>
	<style type="text/css">
		#login h1 a, .login h1 a {
			background-image: url('<?= wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) , 'full' )[0] ?>');
			height: 65px;
			width: 100px;
			background-size: 100px 65px;
			background-repeat: no-repeat;
			padding-bottom: 30px;
		}

		#reg_passmail {
			display: none;
		}
	</style>
<?php 
});
add_filter( 'login_headerurl', function(){ return home_url(); });

/**
 * Remove unneeded profile settings
 * 
 */
if( is_admin() ){
	add_action( 'personal_options', function () {
   ?>
      <script type="text/javascript">
         jQuery( document ).ready(function( $ ){
            $( `
               #your-profile .form-table:first, 
               #your-profile h3:first, 
               .yoast, 
               .user-description-wrap, 
               .user-profile-picture, 
               .user-url-wrap,
               .user-sessions-wrap,
               h2, 
               .user-pinterest-wrap, 
               .user-myspace-wrap, 
               .user-soundcloud-wrap, 
               .user-tumblr-wrap, 
               .user-wikipedia-wrap,
               .application-passwords
               `).remove();
         } );
      </script>
   <?php
} );
}

/**
 * Show the user's posts only in the dashboard posts table.
 */
if ( is_admin() && is_user('publisher') ) {
	add_action('pre_get_posts',function ( $query ){
		if( $query->query_vars['post_type'] == 'product' ){
			$query->query_vars['author'] = get_current_user_id();
			// $query->set('author', get_current_user_id() );
		}
	});
}

// add_action('pre_get_posts',function ( $query ){
// 	if (isset($query->query_vars['post_type']) && 
// 	    ($query->query_vars['post_type'] == 'acf-field' || 
// 	     $query->query_vars['post_type'] == 'acf-field-group')) {
// 	  return;
// 	}
// });

/**
 * Show message thread to sender & receiver only.
 */
if ( is_admin() && is_user('publisher') ) {
	add_action('pre_get_posts',function ( $query ){

		if( $query->query_vars['post_type'] == 'message' ){
			/**
			 * @see https://developer.wordpress.org/reference/functions/wp_list_comments/
			 * @see https://www.cozmoslabs.com/1441-wordpress-get-comments-custom-post-type/
			 */
			$query->query_vars['meta_query'] = [[
				'key'     => '_message_receiver',
				'value'   => get_current_user_id(),
				'compare' => 'LIKE',
			]];
		}
	});
}

/**
 * Remove unwanted parts of the dashboard.
 * 
 */
add_action('admin_head', function() {
?>
	<style>
		#wp-admin-bar-wp-logo,
		#wpfooter,															/* Copyrights in footer */
		#commentstatusdiv, 												/* Comments settigns */
		[href$="post-new.php?post_type=message"], 				/* Add new message */
		.post-type-message #postbox-container-1, 					/* Message submit & status */
		.post-type-message #edit-slug-box,							/* Message slug */
		.post-type-message .subsubsub,								/* Bulk opertaions on messages */
		.post-type-product .subsubsub,								/* Bulk opertaions on product */
		#authordiv,															/* author box in the add new product page */
		#minor-publishing, 												/* Minor publishing options in add new post page */
		.default-password-nag,											/* default-password-nag */
		#dashboard-widgets-wrap, 										/* dashboard-widgets-wrap */
		#content-tmce,
		#content-html,
		.mce-toolbar-grp
		{
			display: none !important;
		}

		.post-type-message #poststuff #post-body.columns-2  	/* Message submit & status Area */
		{
			margin-left: 0 !important;
		}

		<?php if( is_user('owner') ): ?>
			#show-settings-link,
			#contextual-help-link, 
			.post-type-product .page-title-action, /* Add new button in products page */
			.users-php .page-title-action, /* Add new button in users page */
			.post-type-report .page-title-action, /* Add new button in reports page */
			#menu-posts-report .wp-submenu li:last-child, /* Taxonomy control page for report post type */
			.tablenav .alignleft.actions:not(.bulkactions), /* bulk action of roles in users page */
			.term-slug-wrap, /* Product sections' slug */
			.term-parent-wrap /* Product sections' parent */
			{
				display: none;
			}
		<?php endif; ?>

		<?php if( is_user('publisher') ): ?>
			#wp-admin-bar-wp-logo,
			#show-settings-link,
			#contextual-help-link
			{
				display: none;
			}
		<?php endif; ?>
	</style>
<?php 
});


add_action('admin_footer', function(){
?>
	<script>
		document.querySelectorAll('.post-com-count').forEach(function(e){
			e.removeAttribute('href');
		});

		const wpContentMediaButtons = document.querySelector( '#wp-content-media-buttons' );
		if( document.body.contains(wpContentMediaButtons) ){
			wpContentMediaButtons.innerHTML = '<h1 style="margin-bottom: -5px;">اكتب هنا المنتجات التي تريدها في المقابل</h1>';
		}

		const wpbodyContentH1  = document.querySelector( '.index-php #wpbody-content .wrap h1' );
		if( document.body.contains(wpbodyContentH1) ){
			wpbodyContentH1.innerHTML = '<h1>مرحبا بك في ملفك الشخصي</h1>';
		}
	</script>
<?php
});

/**
 * Get rid of a admin links in the comments
 * 
 * @see https://developer.wordpress.org/reference/hooks/comment_row_actions/
 */
add_filter( 'comment_row_actions', function ( $actions, $comment ) {
	unset($actions['approve']);
	unset($actions['unapprove']);
	unset($actions['edit']);
	unset($actions['quickedit']);
	unset($actions['reply']);
	unset($actions['spam']);
	unset($actions['delete']);
	unset($actions['trash']);
	
	return $actions;
}, 100, 2 );

/**
 *  Stop Storing IP Address in Comments.
 */
add_filter( 'pre_comment_user_ip', function ( $comment_author_ip ) {
	return '';
} );

/**
 * Disable user is currently editing warning in admin post page.
 */
add_filter( 'wp_check_post_lock_window', '__return_false' );

/**
 * Disable email notification askign for setting password after user registration.
 */
add_filter('wp_new_user_notification_email', function ( $wp_new_user_notification_email, $user ) {
	$message = '';

	$wp_new_user_notification_email['message'] = $message;

	return $wp_new_user_notification_email;
}, 10, 2);

/**
 *  Remove column from WordPress users list.
 * 
 * @see https://www.role-editor.com/remove-column-from-wordpress-users-list/
 */
add_filter( 'manage_users_columns', function ($column_headers) {
	
	unset($column_headers['posts']);

 	return $column_headers;
});


// Limit media library access
add_filter( 'posts_where', function ( $where ){
	global $current_user;

	if( is_user_logged_in() ){
		  // logged in user, but are we viewing the library?
		  if( isset( $_POST['action'] ) && ( $_POST['action'] == 'query-attachments' ) ){
			  // here you can add some extra logic if you'd want to.
			  $where .= ' AND post_author='.$current_user->data->ID;
		 }
	}

	return $where;
} );

function wpdocs_remove_customize( $wp_admin_bar ) {
	// Remove customize, background and header from the menu bar.	
	$wp_admin_bar->remove_node( 'wp-admin-bar-edit' );  
}
add_action( 'admin_bar_menu', 'wpdocs_remove_customize', 999 );

/**
 * Hide admin bar for all users except for admins
 */
add_action('after_setup_theme', function () {
	if ( !current_user_can('administrator') && !is_admin() ) {
	  show_admin_bar(false);
	}
});

//%order_meta__order_key%
