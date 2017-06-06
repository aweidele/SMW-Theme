<?php 
/* Template Name: Associations */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
get_header();
$ppp = get_option('page_for_posts');
$newschildren = get_children(array('post_parent' => $ppp));
?>
<div id="newsWrapper">
<?php if(have_posts()): while(have_posts()): the_post(); ?>
  <section id="newsletter">
    <div class="pageSectionContent">

      <div class="pageSectionCopy">
        <?php the_content(); ?>
      </div>

      <div class="pageSectionRight">
        <p class="associationsImage"><?php the_post_thumbnail(); ?></p>
        <div class="associationsArticles">
 <?php
  $args = array(
    'post_type' => 'post',
    'posts_per_page' => -1,
    'meta_query' => array(
      array(
        'key'     => 'associations', 
        'value'   => 'yes',
        'compare' => 'LIKE'
      )
    ),
  );
  $news = new WP_Query($args);
  if($news->have_posts()): while($news->have_posts()): $news->the_post();
    showArticle(array($post,'Grid Slideshow Small',false));
  endwhile; endif; wp_reset_query(); ?>
        </div>
      </div>

    </div>
  </section>
<?php endwhile; endif; wp_reset_query(); ?>
</div>
<?php get_footer(); ?>