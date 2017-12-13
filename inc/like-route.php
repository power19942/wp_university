<?php

add_action('rest_api_init','universityLikeRoutes');

function universityLikeRoutes(){
	register_rest_route('university/v1','manageLike',[
			'methods'  => WP_REST_Server::CREATABLE ,
			'callback'=> 'createLike'
	]);
	register_rest_route('university/v1','manageLike',[
			'methods'  => WP_REST_Server::DELETABLE ,
			'callback'=> 'deleteLike'
	]);
}

function createLike(){
	wp_insert_post([
			'post_type' => 'like',
			'post_status' => 'publish',
			'post_title' => '',
			'post_content' => 'hello',
	]);
}

function deleteLike(){
	return 'delete';
}