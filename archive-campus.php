<?php get_header();
pageBanner([
		'title'  => 'Campuses',
		'subtitle'  => '',
])?>

<div class="container container--narrow page-section">
	<div class="acf-map">
		<?php while (have_posts()) : the_post(); $mapLocation = get_field('map_location');?>
			<div class="marker" data-lat="<?php echo  $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng'] ?>">
                <a href="<?php the_permalink() ?>"><h3><?php the_title() ?></h3></a>
                <?php echo $mapLocation['address'] ?>
            </div>
		<?php endwhile; ?>
	</div>
</div>

<?php get_footer();?>


