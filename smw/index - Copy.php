<?php get_header();
$ppp = get_option('page_for_posts');
$newschildren = get_children(array('post_parent' => $ppp));
 ?>
<div id="newsWrapper">
  <nav class="subnav" id="newsNav">
    <div class="subnavContainer">
      <ul>
        <li class="active"><a href="<?php echo get_permalink($ppp); ?>">News Feed</a></li>
<?php foreach($newschildren as $newsie) { ?>
        <li><a href="<?php echo get_permalink($newsie->ID); ?>"><?php echo $newsie->post_title; ?></a></li>
<?php } ?>
      </ul>
    </div>
  </nav>
<?php /*
  <section id="newsContent">
    
      <div id="newsTiles" class="tiled">
<?php 
  $i =1;
  if(have_posts()) : while(have_posts()) : the_post();
  $featured = get_field('featured');
  $isfeatured = is_array($featured) && $featured[0] == 'yes';
  $imgsize = $isfeatured ? 'Grid Slideshow Large' : 'Grid Slideshow Small';

  $postcats = wp_get_post_categories($post->ID);
  $cats = array();
  foreach($postcats as $c) {
    $cat = get_category($c);
    $cats[] = '<a href="'.get_category_link( $c ).'">'.$cat->name.'</a>';
  }
 ?>
<!-- <?php print_r($cats); ?> -->
        <article class="tile<?php if($isfeatured) { echo ' featured'; } ?>" id="post-<?php echo $post->ID; ?>">
          <div class="articleContainer">
          <img src="<?php echo get_the_post_thumbnail_url($post->post_quote_attribute->ID,$imgsize); ?>">
          <div class="overlay">
            <p class="categories"><?php echo implode(", ",$cats); ?></p>
            <h2><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
          </div>
          </div>
        </article>

<?php 
  $i++;
  endwhile; endif; wp_reset_query(); ?>
      </div>
    
  </section>
*/ ?>
</div>
<div id="feedback">feedback</div>
<?php get_footer(); ?>