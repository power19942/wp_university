<?php

require get_theme_file_path('/inc/search-route.php');
require get_theme_file_path('/inc/like-route.php');

function university_custom_rest(){
    register_rest_field('post','authorName',[
      'get_callback'  => function(){
        return get_the_author();
      }
    ]);

    register_rest_field('note','userNoteCount',[
      'get_callback'  => function(){
        return count_user_posts(get_current_user_id(),'note');
      }
    ]);
}

add_action('rest_api_init','university_custom_rest');

//add_filter('show_admin_bar', '__return_false');
function pageBanner(Array $args = []){
		if (!$args['title']){
				$args['title']  = get_the_title();
		}
		if (!$args['subtitle']){
				$args['subtitle']  = get_field('page_banner_subtitle');
		}
		if (!$args['background']){
			if (get_field('page_banner_background_image')['sizes']['pageBanner'])
				$args['background']  = get_field('page_banner_background_image')['sizes']['pageBanner'];
			else
				$args['background'] = get_theme_file_uri('/images/ocean.jpg') ;
		}
	?>
	<div class="page-banner">
		<div class="page-banner__bg-image" style="background-image: url(
		<?php echo $args['background'] ?>);"></div>
		<div class="page-banner__content container container--narrow">
			<h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
			<div class="page-banner__intro">
				<p><?php echo $args['subtitle'] ?></p>
			</div>
		</div>
	</div>
<?php }

function university_files() {
  wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyBGNzZuo4krh59vUZ_kthU52n8aX1R_2hg', NULL, '1.0', true);
  wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);
  wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  wp_enqueue_style('university_main_styles', get_stylesheet_uri());
	wp_localize_script('main-university-js','universityData',[
	  'root_url'  => get_site_url(),
      'nonce'     => wp_create_nonce('wp_rest')
    ]);
}

add_action('wp_enqueue_scripts', 'university_files');

function university_feature(){
  register_nav_menu('headerMenu','Header Menu');
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_image_size('professorLandscape',400,260,true);
  add_image_size('professorPortrait',480,650,true);
  add_image_size('pageBanner',1500,350,true);
}

add_action('after_setup_theme','university_feature');

function university_adjust_queries($query){
	if(!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()){
		$today  = date('Ymd');
		$query->set('meta_key','event_date');
		$query->set('order_by','meta_value_num');
		$query->set('order','ASC');
		$query->set('meta_query',[
				[
						'key' => 'event_date',
						'compare' => '>=',
						'value' => $today,
						'type' => 'numeric',
				]
		]);
	}

	if(!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()){
		$query->set('order_by','title');
		$query->set('order','ASC');
	}

	if(!is_admin() AND is_post_type_archive('campus') AND $query->is_main_query()){
		$query->set('posts_per_page',-1);
	}
}

add_action('pre_get_posts','university_adjust_queries');
//add_filter('the_posts',pageBanner(),1)
//  add_filter('acf/fields/google_map/api','')

add_action('admin_init','redirect_subs_to_frontend');

function redirect_subs_to_frontend(){
    $user = wp_get_current_user();
    if  (count($user->roles) == 1 ANd $user->roles[0] == 'subscriber'){
        wp_redirect(site_url('/'));
        exit();
    }
}

add_action('admin_init','hide_admin_bar');

function hide_admin_bar(){
    $user = wp_get_current_user();
    if  (count($user->roles) == 1 ANd $user->roles[0] == 'subscriber'){
        show_admin_bar(false);
    }
}

//customize Login Screen
add_filter('login_headerurl','ourHeaderUrl');

function ourHeaderUrl(){
    return esc_url(site_url('/')) ;
}

add_action('login_enqueue_scripts','ourLoginCSS');

function ourLoginCSS(){
    wp_enqueue_style('university_main_styles',get_stylesheet_uri());
}


add_filter('login_headertitle','ourLoginTitle');

function ourLoginTitle(){
    return get_bloginfo('name');
}

//force note to be private
  add_filter('wp_insert_post_data','make_note_private',10,2);

function make_note_private($data,$postarr){
    if ($data['post_type'] == 'note'){
        if (count_user_posts(get_current_user_id(),'note' ) > 4 AND
            !$postarr['ID']){
            die('You Have Reached Your Note Limit');
        }
	    $data['post_content'] = sanitize_textarea_field($data['post_content']);
    }

    if ($data['post_type'] == 'note' and $data['post_status'] != 'trash')
        $data['post_status']  =  'private';

	return $data;
}

//  require_once 'test.php';
