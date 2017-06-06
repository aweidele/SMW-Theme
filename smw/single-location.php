<?php get_header(); 
// Get Locations Index Page
$post_id = $post->ID;
$post_title = get_the_title();
$args = array(
    'post_type'  => 'page', 
    'meta_query' => array( 
        array(
            'key'   => '_wp_page_template', 
            'value' => 'template-location.php'
        )
    ),
    'posts_per_page' => 1
);
$index = get_posts($args);
$back = get_permalink($index[0]->ID);

$args = array(
  'post_type' => 'projects',
    'posts_per_page' => -1,
    'order_by' => 'menu_order',
  'meta_query' => array(
    array(
      'key' => 'region',
      'value' => $post_id,
      'compare' => 'LIKE'
    )
  )
);
$projects = get_posts($args);
$r = get_post_meta($projects[8]->ID);
?>
<div id="locationsWrapper">
  <div class="singleLocation">
<?php if(have_posts()) : while(have_posts()) : the_post();
  $main_image    = get_field('main_image');  
  $office_leadership = get_field('office_leadership');
  $google_map = get_field('google_map');
  $address = get_field('address');
  $related_projects = get_field('related_projects');
  $relatedNews = get_field('related_news_knowledge');
  
?>
    <section class="locationName">
      <h2><?php echo get_field('full_name'); ?></h2>
    </section>
    
    <section class="locationBanner">
      <div class="slideshowContainer" id="slideshow-<?php echo $proj->post_name; ?>">
        <div class="slideshowSlider">
<?php foreach($main_image as $photo) { ?>
            <div class="slide" style="background-image:url('<?php echo $photo['sizes']['Banner']; ?>');">
            	<img src="<?php echo $photo['sizes']['Banner']; ?>">
            </div>
<?php } ?>
        </div>
<?php if(sizeof($main_image) > 1) { ?>
        <div class="slideshowControls">
          <ul class="prevNext" data-slideshow="slideshow-<?php echo $proj->post_name; ?>">
            <li><span>Previous</span></li>
            <li><span>Next</span></li>
          </ul>
          <ul class="slideshowIndicators" data-slideshow="slideshow-<?php echo $ssid; ?>">
<?php foreach($main_image as $i => $photo) { ?>
            <li<?php if($i==0) { echo ' class="active"'; } ?>><span><?php echo $i; ?></span></li>
<?php } ?>
          </ul>
        </div>
<?php } ?>
      </div>
    </section>
    
<?php
  include( TEMPLATEPATH."/locations/location-details.php");
  
  endwhile; endif; wp_reset_query(); 
?>
</div>
<?php get_footer(); ?>