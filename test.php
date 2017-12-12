<?php

//add_action( 'admin_init', 'add_meta_boxes' );
//function add_meta_boxes() {
//	add_meta_box( 'some_metabox', 'Movies Relationship', 'movies_field', 'program' );
//}
//
//function movies_field() {
//global $post;
//$selected_movies = get_post_meta( $post->ID, '_movies', true );
//$all_movies = get_posts( array(
//		'post_type' => 'movies',
//		'numberposts' => -1,
//		'orderby' => 'post_title',
//		'order' => 'ASC'
//) );
//?>
<!--<input type="hidden" name="movies_nonce" value="--><?php //echo wp_create_nonce( basename( __FILE__ ) ); ?><!--" />-->
<!--<table class="form-table">-->
<!--	<tr valign="top"><th scope="row">-->
<!--			<label for="movies">Movies</label></th>-->
<!--		<td><select multiple name="movies">-->
<!--				--><?php //foreach ( $all_movies as $movie ) : ?>
<!--					<option value="--><?php //echo $movie->ID; ?><!--"--><?php //echo (in_array( $movie->ID, $selected_movies )) ? ' selected="selected"' : ''; ?><!-->--><?php //echo $movie->post_title; ?><!--</option>-->
<!--				--><?php //endforeach; ?>
<!--			</select></td></tr>-->
<!--</table>-->
<?php //}
//$m = new Main();
//$m->action('init',function (){echo '<h1>main class</h1>';});

//function themeslug_customize_register( $wp_customize ) {
//
//	$wp_customize->add_setting( 'setting_id', array(
//			'type' => 'theme_mod', // or 'option'
//			'capability' => 'edit_theme_options',
//			'theme_supports' => '', // Rarely needed.
//			'default' => '',
//			'transport' => 'refresh', // or postMessage
//			'sanitize_callback' => '',
//			'sanitize_js_callback' => '', // Basically to_json.
//	) );
//
//	$wp_customize->add_control( 'setting_id', array(
//			'type' => 'date',
//			'priority' => 10, // Within the section.
//			'section' => 'colors', // Required, core or custom.
//			'label' => __( 'Date' ),
//			'description' => __( 'This is a date control with a red border.' ),
//			'input_attrs' => array(
//					'class' => 'my-custom-class-for-js',
//					'style' => 'border: 1px solid #900',
//					'placeholder' => __( 'mm/dd/yyyy' ),
//			),
//			'active_callback' => 'is_front_page',
//	) );
//
//	$wp_customize->add_control( 'setting_id', array(
//			'label' => __( 'Custom Theme CSS' ),
//			'type' => 'textarea',
//			'section' => 'colors',
//	) );
//
//}
//add_action( 'customize_register', 'themeslug_customize_register' );

  function jk_add_menu_page(){
	  add_menu_page( 'Theme Options', 'Sunset', 'manage_options', 'jk_main_page', 'sunset_theme_create_page', null, 110 );
}

function sunset_theme_create_page(){?>

<form id="submitForm" method="post" action="options.php" class="sunset-general-form">
	<?php settings_errors(); ?>
	<?php settings_fields( 'jk-options' ); ?>
	<?php do_settings_sections( 'jk_main_page' ); ?>
	<?php submit_button( 'Save Changes', 'primary', 'btnSubmit' ); ?>
</form>
<?php }

add_action('admin_menu','jk_add_menu_page');

function jk_add_settings_fields(){
    register_setting('jk-options','jk_name');
    add_settings_section('jk-main-section','Main Section','jk_main_section_callback','jk_main_page');
    add_settings_field('jk-name','Title','jk_field_callback','jk_main_page','jk-main-section');
}

function jk_main_section_callback(){
    //echo '<h1>Main Settings</h1>';
}

function jk_field_callback(){
   $name = sanitize_text_field(get_option('jk_name'));
?>
    <input name="jk_name" value="<?php echo $name?>" type="text" />
<?php
}

add_action( 'admin_init', 'jk_add_settings_fields' );


add_action('add_meta_boxes','jk_meta_box');

function jk_meta_box(){
    add_meta_box('event-meta','New Title','jk_event_meta_box_callback','event','normal');
}

function jk_event_meta_box_callback($post){
    wp_nonce_field('save_jk_event_meta','jk_event_nonce');
    $val = get_post_meta($post->ID,'jk_custom_data',true);
    ?>
    <input name="jk_data" type="text" value="<?php echo esc_attr($val) ?>" class="input" placeholder="custom metabox">
<?php
}

add_action('save_post','save_jk_event_meta');

function save_jk_event_meta($post_id){
//    if (! isset($_POST['jk_event_nonce'])){
//        return;
//    }
    update_post_meta($post_id,'jk_custom_data',sanitize_text_field($_POST['jk_data']));

}