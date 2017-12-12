<?php

get_header();

while(have_posts()) {
	the_post();
	pageBanner();
	?>
	<div class="container container--narrow page-section">
		<div class="generic-content">
			<div class="row group">
			    <div class="one-third">
					<?php the_post_thumbnail('professorPortrait') ?>
			    </div><div class="two-third">
					<?php the_content() ?>
			    </div>
			</div>
		</div>
		<?php
		$relatedProgram = get_field('related_programs');
		if ($relatedProgram) : ?>
			<hr class="section-break">
			<h2 class="headline headline--medium">Subject Taught</h2>
			<ul class="link-list min-list">
				<?php foreach ($relatedProgram as $program) :?>
					<li><a href="<?php echo get_the_permalink($program) ?>"><?php echo get_the_title($program) ?></a></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

	</div>
<?php }

get_footer();

?>