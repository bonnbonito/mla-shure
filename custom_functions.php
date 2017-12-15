<?php
/**
 * Bonn Starter Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package MLAShure
 */

require_once( get_template_directory() . '/inc/libs/class-tgm-plugin-activation.php' );
include( get_template_directory() . '/inc/register-plugins.php' );

add_action( 'tgmpa_register', 'mlashure_register_required_plugins' );


function mlashure_addmore_scripts() {
	/*
	 * Enqueue custom scripts and styles
	 */

	if (!is_admin()) {
		wp_deregister_script('jquery');
		wp_register_script('jquery', '//code.jquery.com/jquery-3.1.1.min.js', false, '3.1.1');
		wp_enqueue_script('jquery');
	}

	wp_enqueue_style( 'mlashure_opensans', '//fonts.googleapis.com/css?family=Open+Sans' );
	wp_enqueue_style( 'mlashure_semantic-css', get_template_directory_uri() . '/assets/semantic/semantic.min.css' );
	wp_enqueue_style( 'mlashure_mmenu-css', get_template_directory_uri() . '/css/mmenu.css' );
	wp_enqueue_style( 'mlashure_lightbox-css', get_template_directory_uri() . '/css/lightbox.css' );
	wp_enqueue_style( 'mlashure-style', get_stylesheet_uri() );
	wp_register_style( 'mlashure_jsscocials_style', '//cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css' );
	wp_register_style( 'mlashure_jsscocials_style_flat', '//cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-flat.css' );

	wp_register_script( 'mlashure_mmenu-js', get_template_directory_uri() . '/js/mmenu.min.js', array('jquery'), 'v5.6.5', true );
	wp_register_script( 'mlashure_lightbox-js', get_template_directory_uri() . '/js/lightbox.js', 'jquery', 'v2.8.2', true );
	wp_register_script( 'mlashure_fastclick', get_template_directory_uri() . '/js/fastclick.js', '', '1.0.6' );
	wp_register_script( 'mlashure_jssocials', '//cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.min.js', array('jquery'), '1.4.0', false );

	wp_enqueue_script( 'mlashure_semantic-js', get_template_directory_uri() . '/assets/semantic/semantic.min.js', array('jquery'), '2.2.10', true );

	wp_enqueue_script( 'mlashure_fastclick' );
	wp_enqueue_script( 'mlashure_mmenu-js' );
	wp_enqueue_script( 'mlashure_tether', '//cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js', array('jquery'), '1.4.0', true );
	wp_enqueue_script( 'mlashure_theme-js', get_template_directory_uri() . '/js/theme.js', array('jquery','mlashure_mmenu-js', 'mlashure_semantic-js'), false, true );


	wp_localize_script( 'mlashure_theme-js', 'MLA',array(
		'ajax_url'                  =>  admin_url( 'admin-ajax.php' ),
		'home_url'                  =>  home_url( '/' ),
		'post_id'										=> get_the_ID(),
		// 'course_name'								=> get_field('course_name')->post_name,
		'course_name'								=> get_course_name(),
		'next_video'								=> get_the_permalink( get_field('next')	),
		'dashboard_url' 						=> home_url('/dashboard'),
		'ajax_nonce' 								=> wp_create_nonce('ajax_nonce'),
	));

}

add_action( 'wp_enqueue_scripts', 'mlashure_addmore_scripts' );

function get_course_name() {

	if (get_post_type() != 'video_course') {
		return;
	}

	return get_field('course_name')->post_name;

}



/* Parse the video uri/url to determine the video type/source and the video id */
	function parse_video_uri( $url ) {

		// Parse the url
		$parse = parse_url( $url );

		// Set blank variables
		$video_type = '';
		$video_id = '';

		// Url is http://youtu.be/xxxx
		if ( $parse['host'] == 'youtu.be' ) {

			$video_type = 'youtube';

			$video_id = ltrim( $parse['path'],'/' );

		}

		// Url is http://www.youtube.com/watch?v=xxxx
		// or http://www.youtube.com/watch?feature=player_embedded&v=xxx
		// or http://www.youtube.com/embed/xxxx
		if ( ( $parse['host'] == 'youtube.com' ) || ( $parse['host'] == 'www.youtube.com' ) ) {

			$video_type = 'youtube';

			parse_str( $parse['query'] );

			$video_id = $v;

			if ( !empty( $feature ) )
				$video_id = end( explode( 'v=', $parse['query'] ) );

			if ( strpos( $parse['path'], 'embed' ) == 1 )
				$video_id = end( explode( '/', $parse['path'] ) );

		}

		// Url is http://www.vimeo.com
		if ( ( $parse['host'] == 'vimeo.com' ) || ( $parse['host'] == 'www.vimeo.com' ) ) {

			$video_type = 'vimeo';

			$video_id = ltrim( $parse['path'],'/' );

		}
		$host_names = explode(".", $parse['host'] );
		$rebuild = ( ! empty( $host_names[1] ) ? $host_names[1] : '') . '.' . ( ! empty($host_names[2] ) ? $host_names[2] : '');
		// Url is an oembed url wistia.com
		if ( ( $rebuild == 'wistia.com' ) || ( $rebuild == 'wi.st.com' ) ) {

			$video_type = 'wistia';

			if ( strpos( $parse['path'], 'medias' ) == 1 )
					$video_id = end( explode( '/', $parse['path'] ) );

		}

		// If recognised type return video array
		if ( !empty( $video_type ) ) {

			$video_array = array(
				'type' => $video_type,
				'id' => $video_id
			);

			return $video_array;

		} else {

			return false;

		}

	}

//Checkbox done Watching

function shure_done_watching() {

	$output                 =   array( 'status' => 1 );

	$userID = get_current_user_id();

	update_user_meta($userID, 'finish-' . $_POST['post_id'], $_POST['done']);
	update_user_meta($userID, 'next-' . $_POST['course_name'], $_POST['done']);

	$output                 =   array( 'status' => 2, 'done' => $_POST['done'] );

	wp_send_json( $output );

}

add_action( 'wp_ajax_shure_done_watching', 'shure_done_watching' );


function shure_video_end() {

	$output                 =   array( 'status' => 1 );

	$userID = get_current_user_id();

	update_user_meta($userID, 'finish-' . $_POST['post_id'], 1);

	$output                 =   array( 'status' => 2, 'done' => 1 );

	wp_send_json( $output );

}

add_action( 'wp_ajax_shure_video_end', 'shure_video_end' );

//Front page login

function shure_user_login() {

	$output                                 =   [ 'status' => 1 ];
	$nonce                                  =   isset($_POST['_wpnonce']) ? $_POST['_wpnonce'] : '';

	if( !wp_verify_nonce( $nonce, 'shure_login' ) ){
		wp_send_json( $output );
	}

	if( !isset( $_POST['email'], $_POST['password'] ) ){
		wp_send_json( $output );
	}

	$email = sanitize_email($_POST['email']);
	$pass = sanitize_text_field($_POST['password']);

	$user = get_user_by('email', $email);

	$userlog                              =   wp_signon([
		'user_login'                        =>  $user->data->user_login,
		'user_password'                     =>  $pass,
		'remember'                          =>  true
	], false );

		if( is_wp_error($userlog) ){
			wp_send_json( $output );
		}

	$output['status']                       =   2;
	wp_send_json( $output );

}

add_action( 'wp_ajax_nopriv_shure_user_login', 'shure_user_login' );


//Front page logout

function shure_logout(){
	$output                                 =   [ 'status' => 1 ];

	$nonce =   isset($_POST['_wpnonce']) ? $_POST['_wpnonce'] : '';

	if( !wp_verify_nonce( $nonce, 'ajax_nonce' ) ){
		wp_send_json( $output );
	}

	wp_logout();
	ob_clean();

	$output['status']                       =   2;
	wp_send_json( $output );

}

add_action( 'wp_ajax_shure_logout', 'shure_logout' );

//add first video custom field

function shure_first_video( $id ) {

	return get_field('course_tree', $id)[0]['videos'][0]['course_video']->ID;

}

function shure_total_course_videos($id) {

	$videoArr = [];

	$rows = get_field('course_tree', $id);

	if($rows) {

		foreach($rows as $row)
		{
			$vid = count($row['videos']);
			array_push($videoArr, $vid);
		}
	}
	return array_sum($videoArr);
}

function get_user_finish_course_videos($id) {

	$finishedVideos = [];

	$rows = get_field('course_tree', $id);


	if($rows) {

		foreach($rows as $row) {
			$vids = $row['videos'];

			if ($vids) {
				foreach ($vids as $vid) {
					$fin = get_user_meta( get_current_user_id(), 'finish-' .$vid['course_video']->ID, true );
					if ($fin == 1) {
						array_push($finishedVideos, $vid['course_video']->ID);
					}
				}
			}
		}
	}

	return count($finishedVideos);
}


// Add course tree to user
function shure_add_user_course($new_value) {
		$user_id = get_current_user_id();
    // Get the existing meta for 'meta_key'
    $meta = get_user_meta($user_id, 'enrolled_courses', false);

		//push if not in array
		if (!in_array($new_value, $meta)) {
			$meta[] = $new_value;
		}

    // Write the user meta record with the new value in it
    update_user_meta($user_id, 'enrolled_courses', $meta);
}



// Output link of course

 function shure_course_continue($id) {
	 $user = get_current_user_id();
	 $returnId = '';

	 $rows = get_field('course_tree', $id);

	 	if($rows) {

	 		foreach($rows as $row) {
	 			$vids = $row['videos'];
	 			if ($vids) {
	 				foreach ($vids as $vid) {
	 					$fin = get_user_meta( get_current_user_id(), 'finish-' .$vid['course_video']->ID, true );
	 					if ($fin != 1) {
	 						$returnId = $vid['course_video']->ID;
							break;
	 					}
	 				}
	 			}
	 		}
	 	}
		return $returnId;
 }

 function shure_course_start($id) {
	$user = get_current_user_id();
	$fresh = true;

	$rows = get_field('course_tree', $id);

	 if($rows) {
		 foreach($rows as $row) {
			 $vids = $row['videos'];
			 if ($vids) {
				 foreach ($vids as $vid) {
					 $fin = get_user_meta( get_current_user_id(), 'finish-' .$vid['course_video']->ID, true );
					 if ($fin == 1) {
						 $fresh = false;
					 }
				 }
			 }
		 }
	 }
	 return $fresh;
 }



 // Get Key Stages
function shure_step1() {

	$output                                 =   [ 'status' => 1 ];

	$nonce =   isset($_POST['_wpnonce']) ? $_POST['_wpnonce'] : '';

	if( !wp_verify_nonce( $nonce, 'ajax_nonce' ) ){
		wp_send_json( $output );
	}

	$key_stages = get_terms( 'key_stage', array(
    'orderby'    => 'name',
    'hide_empty' => 0
	));

	ob_start();


	foreach ($key_stages as $key => $value ) { ?>
		<div class="four wide column">
				<button class="ui button fluid lightblue <?php echo $key; ?>" id="<?php echo $value->slug; ?>"><?php echo $value->name; ?></button>
				<br>
		</div>
		<div class="column"></div>

	<?php }

	$output                                 =   [ 'status' => 2 ];
	$output['contents'] = ob_get_clean();

	wp_send_json( $output );

}

add_action( 'wp_ajax_shure_step1', 'shure_step1' );
add_action( 'wp_ajax_nopriv_shure_step1', 'shure_step1' );

function shure_step2() {

	$output                                 =   [ 'status' => 1 ];

	$nonce =   isset($_POST['_wpnonce']) ? $_POST['_wpnonce'] : '';

	if( !wp_verify_nonce( $nonce, 'ajax_nonce' ) ){
		wp_send_json( $output );
	}

	$enrolled = get_user_meta(get_current_user_id(), 'enrolled_courses', true);

	$integerIDs = array_map('intval', $enrolled);

	$query = new WP_Query( array(
		'post_type' => 'course_tree',
		'post__not_in' => $integerIDs,
		'tax_query' => array(
	    array(
	      'taxonomy' => 'key_stage',
	      'field'    => 'slug',
	      'terms'    => $_POST['key_stage'],
	    ),
	  ),
	) );

	if ( $query->have_posts() ) :
		ob_start(); ?>
		<div class="ui cards centered">
		<?php while ( $query->have_posts() ) : $query->the_post(); ?>

			<div class="card">
		    <div class="content">
		      <div class="header"><?php the_title(); ?></div>
		      <div class="description">
		        <?php the_field('subtitle'); ?>
		      </div>
		    </div>
				<div class="extra content">
					<div class="ui checkbox">
					  <input class="courseId" type="checkbox" name="course[]" value="<?php the_ID(); ?>" id="<?php the_ID(); ?>" data-price="<?php echo (get_field('price') ? get_field('price') : 0) ?>">
					  <label for="<?php the_ID(); ?>"><?php echo (get_field('price') ? get_field('price') : 'FREE') ?></label>
					</div>
				</div>
		  </div>

		<?php endwhile; ?>
		</div>
		<div class="clear-row">
			<div class="text-center">
				<button type="button" name="gostep2" id="gostep2" class="ui secondary labeled icon button "><i class="angle left icon"></i> Go Back</button>
			</div>
		</div>
		<?php wp_reset_postdata();
	else: ?>
	<div class="ui error message">
	  <div class="header">
	    There are no courses available yet...
	  </div>
	</div>
	<div class="clear-row">
		<div class="text-center">
			<button type="button" name="gostep2" id="gostep2" class="ui secondary labeled icon button "><i class="angle left icon"></i> Go Back</button>
		</div>
	</div>
	<?php endif;

	$content = ob_get_clean();
	$output                                 =   [ 'status' => 2 ];
	$output['content']                      =   $content;
	wp_send_json( $output );


}

add_action( 'wp_ajax_shure_step2', 'shure_step2' );
add_action( 'wp_ajax_nopriv_shure_step2', 'shure_step2' );



function shure_enroll_courses() {
	global $wpdb;
	$table_name = $wpdb->prefix . "enroll";
	$output                                 =   [ 'status' => 1 ];

	$nonce =   isset($_POST['_wpnonce']) ? $_POST['_wpnonce'] : '';

	$receipt = isset($_POST['receipt']) ? $_POST['receipt'] : 'Not Available';

	if( !wp_verify_nonce( $nonce, 'ajax_nonce' ) ){
		wp_send_json( $output );
	}

	$enrolled = get_user_meta(get_current_user_id(), 'enrolled_courses', true);

  if ( empty($enrolled) ) {
      $enrolled = [];
  }

	foreach ($_POST['courses'] as $course) {
		if (!in_array($course, $enrolled)) {
			$enrolled[] = $course;
			update_user_meta(get_current_user_id(), 'enrolled_courses', $enrolled);
			$prepared_date = date( 'Y-m-d H:i:s' );

			$price = get_field('price', $course) ? get_field('price', $course) : 0;

			if ($receipt == 0) {
				$receipt = 'Not Available';
			}


			$wpdb->insert(
        $table_name,
        array(
            'course_tree' => $course,
            'user_id' => get_current_user_id(),
						'time'		=> $prepared_date,
            'receipt' => $receipt,
            'price' => $price
        )
    );

		}
	}

	$output                                 =   [ 'status' => 2 ];
	wp_send_json( $output );
}

add_action( 'wp_ajax_shure_enroll_courses', 'shure_enroll_courses' );


/*
 * Create Account
 *
 */

function shure_create_account(){
	$output                                 =   [ 'status' => 1 ];
	$nonce                                  =   isset($_POST['_wpnonce']) ? $_POST['_wpnonce'] : '';

	if( !wp_verify_nonce( $nonce, 'shure_login' ) ){
		$output['error'] = 'Error creating account';
		wp_send_json( $output );
	}

	if( !isset( $_POST['email'], $_POST['password'], $_POST['confirm_pass'] ) ){
		$output['error'] = 'Emails and Passwords are required';
		wp_send_json( $output );
	}

	$fname                                  =   sanitize_text_field( $_POST['fname'] );
	$lname                                  =   sanitize_text_field( $_POST['lname'] );
	$email                                  =   sanitize_email( $_POST['email'] );
	$pass                                   =   sanitize_text_field( $_POST['password'] );
	$confirm_pass                           =   sanitize_text_field( $_POST['confirm_pass'] );
	$nicename                               =   sanitize_title($fname . ' ' . $lname);

	if( email_exists( $email ) ){
		$output['error'] = 'Email already exists';
		wp_send_json( $output );
	}

	if ($pass != $confirm_pass) {
		$output['error'] = 'Passwords does not match';
		wp_send_json( $output );
	}

	// wp_create_user(), wp_insert_user()
	$user_id                                =   wp_insert_user([
		'user_login'                        =>  $email,
		'user_pass'                         =>  $pass,
		'user_email'                        =>  $email,
		'user_nicename'                     =>  $nicename
	]);

	if( is_wp_error( $user_id ) ){
		wp_send_json( $output );
	}

	update_user_meta( $user_id, 'first_name', $fname );
	update_user_meta( $user_id, 'last_name', $lname );
	update_user_meta( $user_id, 'nickname', $fname );

	$user                                   =   get_user_by( 'id', $user_id );
	wp_set_current_user( $user_id, $user->user_login );
	wp_set_auth_cookie( $user_id, false );
	do_action( 'wp_login', $user->user_login, $user );

	$output['status']                       =   2;
	wp_send_json( $output );
}

add_action( 'wp_ajax_nopriv_shure_create_account', 'shure_create_account' );
