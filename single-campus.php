<?php

get_header();

while(have_posts()) {
	the_post(); ?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>);"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php the_title(); ?></h1>
            <div class="page-banner__intro">
                <p>DONT FORGET TO REPLACE ME LATER</p>
            </div>
        </div>
    </div>
    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus') ?>"><i class="fa fa-home" aria-hidden="true"></i>
                    Back To All Campuses</a> <span class="metabox__main">Posted by <?php the_author_posts_link() ?> on
								<?php the_time('d/m/Y') ?> in <?php echo get_the_category_list(', ') ?></span></p>
        </div>
        <div class="generic-content">
					<?php the_content() ?>
        </div>

        <div class="acf-map">
					<?php  $mapLocation = get_field('map_location') ; echo $mapLocation?>
            <div class="marker" data-lat="<?php echo  $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng'] ?>">
                <h3><?php the_title() ?></h3>
							<?php echo $mapLocation['address'] ?>
            </div>
        </div>

			<?php
			$relatedPrograms = new WP_Query([
					'post_per_page' => 2,
					'post_type'     => 'program',
				//order by meta value
					'order_by'      => 'title',
					'order'         => 'ASC',
					'meta_query'    =>[
							[
									'key'    => 'related_campuse',
									'compare'=> 'LIKE',
									'value'  => '"'. get_the_ID() .'"'
							]
					]
			]);?>
			<?php if ($relatedPrograms->have_posts()): ?>
          <hr class="section-break">
          <h2 class="headline headline--medium">Programs Available At This Campus</h2>
          <ul class="min-list link-list">
						<?php while ($relatedPrograms->have_posts()) : $relatedPrograms->the_post() ?>
                <li>
                    <a href="<?php the_permalink() ?>">
                        <?php the_title();?>
                    </a>
                </li>
						<?php endwhile ; wp_reset_postdata(); ?>
          </ul>
			<?php endif;?>
    </div>
<?php }
get_footer();

?>