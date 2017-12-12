<?php
  
  get_header();

  while(have_posts()) {
    the_post();
    pageBanner();
    ?>

      <div class="container container--narrow page-section">
          <div class="metabox metabox--position-up metabox--with-home-link">
              <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event') ?>"><i class="fa fa-home" aria-hidden="true"></i>
                      Back To Event Page</a> <span class="metabox__main">Posted by <?php the_author_posts_link() ?> on
                  <?php the_time('d/m/Y') ?> in <?php echo get_the_category_list(', ') ?></span></p>
          </div>
          <div class="generic-content">
            <?php the_content() ?>
          </div>
          <?php
          $relatedProgram = get_field('related_programs');
          if ($relatedProgram) : ?>
              <hr class="section-break">
              <h2 class="headline headline--medium">Related Programs</h2>
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