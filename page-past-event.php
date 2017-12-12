<?php get_header();
pageBanner([
		'title' => 'Past Events',
		'subtitle' => 'A Recap of our past Events'
])?>

<div class="container container--narrow page-section">
	<?php
	$today = date('Ymd');
	$query = new WP_Query([
			'paged'         => get_query_var('paged',1),
			'post_type'     => 'event',
		//order by meta value
			'meta_key'      => 'event_date',
			'order_by'      => 'meta_value_num',
			'order'         => 'ASC',
			'meta_query'    =>[
					[
							'key'    => 'event_date',
							'compare'=> '<',
							'value'  =>  $today,
							'type'   => 'numeric'
					]
			]
	]);
	while ($query->have_posts()) : $query->the_post();
        get_template_part('template-parts/content-event');
    endwhile; wp_reset_postdata()?>
	<?php echo paginate_links([
			'total' => $query->max_num_pages
	]) ?>
</div>

<?php get_footer();?>


