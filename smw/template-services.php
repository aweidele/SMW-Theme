<?php
/* Template Name: Services */
get_header();
$serviceArray = array();
$args = array(
  'post_type' => 'services',
  'posts_per_page' => -1
);
$services = new WP_Query($args);
if($services->have_posts()) : while($services->have_posts()) : $services->the_post();
  $principalArray = array();
  $principals = get_field('principals');
  foreach($principals as $p) {
    $principalArray[] = array(
      'permalink' => get_permalink($p->ID),
      'thumbnail' => get_the_post_thumbnail_url($p->ID,'Leadership Thumb'),
      'name' => $p->post_title,
      'title' => get_field('title',$p->ID),
      'phone' => get_field('phone',$p->ID),
      'email' => get_field('email',$p->ID),
      'linkedin' => get_field('linkedin',$p->ID)
    );
  }
  $post->post_quote = get_field('quote');
  $post->quote_attribute = get_field('quote_attribute');
  $post->principals = $principalArray;
  $post->post_thumbnail = get_the_post_thumbnail_url($post->ID,'Services Background');
  $post->post_icon = get_field('icon');
  $post->featured_projects = get_field('featured_projects');
  $post->brochure = get_field('brochure');
  $serviceArray[] = $post;
endwhile;endif;wp_reset_query();
?>
<div id="servicesWrapper">

  <div>
<?php if(have_posts()) : while(have_posts()) : the_post(); 
	$photos = get_field('photos');
?>
  <section id="services-intro">
    <div class="pageSectionContent">
      <div class="pageSectionCopy">
        <?php the_content(); ?>
      </div>
      <div class="pageSectionRight">
<?php switch(get_field('additional_content')) {
  case 'video': ?>
        <div class="oEmbedWrapper"><?php echo get_field('additional_content_video'); ?></div>
<?php break;
  case 'image': 
    $image = get_field('addition_content_image');
  ?>
        <div class="imageWrapper"><img src="<?php echo $image['sizes']['Large Slideshow']; ?>"></div>
<?php break;
  case 'text': 
       echo get_field('additional_text');
 break; 
 	case 'slideshow': ?>
 		 <div class="slideshowContainer servicesSlideshow <?= sizeof($photos) > 1 ? 'hasPhotos' : '' ?>" id="slideshow-<?php echo $ssid; ?>">
            <div class="slideshowSlider">
<?php foreach($photos as $key => $photo) { ?>
              <div class="slide <?php if($key==0) { echo ' active'; } ?>" style="background-image:url('<?php echo $photo['sizes']['Large Slideshow']; ?>');">
              	<img src="<?php echo $photo['sizes']['Large Slideshow']; ?>">
              </div>
<?php } ?>
            </div>
<?php if(sizeof($photos) > 1) { ?>
            <div class="slideshowControls">
              <ul class="prevNext" data-slideshow="slideshow-<?php echo $ssid; ?>">
                <li><span>Previous</span></li>
                <li><span>Next</span></li>
              </ul>
              <ul class="slideshowIndicators" data-slideshow="slideshow-<?php echo $ssid; ?>">
<?php foreach($photos as $i => $photo) { ?>
                <li<?php if($i==0) { echo ' class="active"'; } ?>><span><?php echo $i; ?></span></li>
<?php } ?>
              </ul>
            </div>
<?php } ?>
          </div>
 <?php break;
 	
} ?>
<?php
  $more_content = get_field('more_additional_content');
  if(sizeof($more_content)) {
    foreach($more_content as $content) {
      switch($content['additional_content_type']) {
        case 'video': ?>
        <div class="oEmbedWrapper"><?php echo $content['additional_content_video']; ?></div>
<?php break;
        case 'image': ?>
        <div class="imageWrapper"><img src="<?php echo $content['additional_content_image']['sizes']['Large Slideshow']; ?>" alt="<?php echo $content['additional_content_image']['title']; ?>"></div>
<?php break;
        case 'text':  ?>
        <div class="textWrapper"><?php echo wpautop($content['additional_content_text']); ?></div>
<?php break;
      }
    }
  }
?>
      </div>
    </div>
  </section>
<?php endwhile;endif;wp_reset_query(); ?>
<?php foreach($serviceArray as $key => $service) { 
?>
  <section id="<?php echo $service->post_name; ?>">
    <div class="pageSectionContent">
      <div class="pageSectionCopy">
        <h2><?php echo $service->post_title; ?></h2>
        <?php echo wpautop($service->post_content); ?>
      </div>
      <div class="pageSectionRight">
          <div class="servicesQuote" style="background-image: url(<?php echo $service->post_thumbnail; ?>)">
          <div class="servicesQuoteText">
            <p><?php echo $service->post_quote; ?></p>
<?php if($service->quote_attribute != "") { ?>
            <p class="quoteAttribution">—<?php echo $service->quote_attribute; ?></p>
<?php } ?>
            <p class="viewProjects"><a href="<?php echo get_permalink($service->ID); ?>">View Projects</a></p>
<?php  /* if(is_array($service->brochure) && sizeof($service->brochure)) { ?>
            <p class="viewProjects"><a href="<?php echo $service->brochure['url']; ?>" target="_blank">Download Brochure</a></p>
<?php } */ ?>
          </div>
          <div class="servicesQuoteAttribute">

<?php foreach($service->principals as $principal) { ?>

            <div class="leadershipCard">
              <a href="<?php echo $principal['permalink']; ?>">
                <p class="leadershipPortrait"><img src="<?php echo $principal['thumbnail']; ?>"></p>
                <p><strong><?php echo $principal['name']; ?></strong></p>
                <p><?php echo $principal['title']; ?></p>
              </a>
              <p><a href="tel:<?php echo $principal['phone']; ?>"><?php echo str_replace('-',' ',$principal['phone']); ?></a></p>
              <ul class="leadershipContact">
                <li class="email"><a href="mailto:<?php echo $principal['email']; ?>"><span><?php echo $principal['email']; ?></span></a></li>
                <li class="linkedin"><a href="<?php echo $principal['linkedin']; ?>" target="_blank"><span><?php echo $principal['linkedin']; ?></span></a></li>
              </ul>
            </div>

<?php } ?>
          </div>
          <p class="viewProjects mobilebtn"><a href="<?php echo get_permalink($service->ID); ?>">View Projects</a></p>
          <div class="servicesQuoteOverlay"></div>
          <ul class="servicesIcons">
            <li><a href="<?php echo get_permalink($service->ID); ?>"><img src="<?php echo $service->post_icon['url']; ?>"><span><?php echo $service->post_title; ?></span></a></li>
          </ul>
        </div><!-- -->
      </div>
    </div>

  </section>

<?php } ?>
  </div>
</div>

<script>
  jQuery(function(){
  	subPageMenuLink("servicesWrapper");
  });
</script>
<?php get_footer(); ?>