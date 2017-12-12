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
	<ul class="container container--narrow page-section">
		<div class="metabox metabox--position-up metabox--with-home-link">
			<p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program') ?>"><i class="fa fa-home" aria-hidden="true"></i>
					Back To All Programs</a> <span class="metabox__main">Posted by <?php the_author_posts_link() ?> on
					<?php the_time('d/m/Y') ?> in <?php echo get_the_category_list(', ') ?></span></p>
		</div>
		<div class="generic-content">
			<?php the_field('main_body_content') ?>
		</div>

			<?php
			$relatedProfessors = new WP_Query([
					'post_per_page' => 2,
					'post_type'     => 'professor',
				//order by meta value
					'order_by'      => 'title',
					'order'         => 'ASC',
					'meta_query'    =>[
							[
									'key'    => 'related_programs',
									'compare'=> 'LIKE',
									'value'  => '"'. get_the_ID() .'"'
							]
					]
			]);?>
			<?php if ($relatedProfessors->have_posts()): ?>
          <hr class="section-break">
          <h2 class="headline headline--medium"><?php echo get_the_title()?> Professors</h2>
                <ul class="professor-cards">
                    <?php while ($relatedProfessors->have_posts()) : $relatedProfessors->the_post() ?>
                        <li class="professor-card__list-item">
                            <a class="professor-card" href="<?php the_permalink() ?>">
                                <img src="<?php the_post_thumbnail_url('professorLandscape') ?>" class="professor-card__image">
                                <span class="professor-card__name"><?php the_title() ?></span>
                            </a>
                        </li>
                    <?php endwhile ; wp_reset_postdata(); ?>
                </ul>
			<?php endif;?>

			<?php
			$today = date('Ymd');
			$homePageEvents = new WP_Query([
					'post_per_page' => 2,
					'post_type'     => 'event',
				//order by meta value
					'meta_key'      => 'event_date',
					'order_by'      => 'meta_value_num',
					'order'         => 'ASC',
					'meta_query'    =>[
					        [
									'key'    => 'event_date',
									'compare'=> '>=',
									'value'  =>  $today,
									'type'   => 'numeric'
							],
                        [
		                        'key'    => 'related_programs',
		                        'compare'=> 'LIKE',
		                        'value'  => '"'. get_the_ID() .'"'
                        ]
					]
			]);?>
            <?php if ($homePageEvents->have_posts()): ?>
            <hr class="section-break">
			<h2 class="headline headline--medium">Upcoming <?php echo get_the_title()?> Events</h2>
			<?php while ($homePageEvents->have_posts()) : $homePageEvents->the_post();
		            get_template_part('template-parts/content-event');
			endwhile ;
            endif;
            ?>

      <?php
        wp_reset_postdata();
        $relatedCampuses = get_field('related_campuse');
        if ($relatedCampuses) :
      ?>
        <h2 class="headline headline--medium"><?php echo get_the_title() ?> is Available At These Campuses</h2>
          <ul class="min-list link-list"></ul>
          <?php foreach ($relatedCampuses as $campus) :?>
                <li><a href="<?php echo get_the_permalink($campus)?>"><?php echo get_the_title($campus) ?></a></li>
        <?php endforeach; endif ?>
        </ul>

	</div>
<?php }

get_footer();

?>