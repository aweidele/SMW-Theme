<?php
/* Template Name: AIA */
get_header();
$ppp = get_option('page_for_posts');
$newschildren = get_children(array('post_parent' => $ppp));
?>
<div id="newsWrapper">
<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
  <section id="aiaContent">
    <div class="pageSectionContent">
      <div class="pageSectionCopy">
        <?php the_content(); ?>
      </div>
      <div class="AIACourses">
        <div class="featureImage"><img src="<?php echo get_the_post_thumbnail_url($post->ID); ?>"></div>
        <?php echo get_field('right_column'); ?>
      </div>
    </div>
  </section>
<?php endwhile; endif; wp_reset_query(); ?>
</div>
<?php get_footer(); ?>