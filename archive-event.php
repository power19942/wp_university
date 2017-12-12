<?php get_header();
pageBanner([
        'title' => 'All Events',
        'subtitle'=> 'My New Events'
])?>

<div class="container container--narrow page-section">
	<?php while (have_posts()) : the_post();
        get_template_part('template-parts/content-event');
    endwhile;?>
	<?php echo paginate_links() ?>
</div>

<?php get_footer();?>


