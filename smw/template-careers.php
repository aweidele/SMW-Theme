<?php
/* Template Name: Careers */
get_header();
  $my_wp_query = new WP_Query();
  $all_wp_pages = $my_wp_query->query(array('post_type' => 'page', 'posts_per_page' => -1, 'order' => 'ASC', 'orderby' => 'menu_order', 'post_parent' => $id));
  $childPages = get_page_children(get_the_ID(),$all_wp_pages);
?>
<div id="aboutWrapper" class="careersWrapper">
  <div>
<?php if(have_posts()): while(have_posts()): the_post(); 
	$photos = get_field('photos');
?>
  <section id="<?php echo $post->post_name; ?>">
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
    $addition_content_image = get_field('addition_content_image'); ?>
        <div class="imageWrapper"><img src="<?php echo $addition_content_image['sizes']['Large Slideshow']; ?>"></div>
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
<?php endwhile; endif; wp_reset_query(); ?>
<?php foreach($childPages as $page) { 
  $template = get_page_template_slug($page->ID);
  $photos = get_field('photos');
?>
  <section id="<?php echo $page->post_name; ?>">
    <div class="pageSectionContent">
      <div class="pageSectionCopy">
        <?php echo wpautop($page->post_content); ?>
      </div>
      <div class="pageSectionRight">
<?php switch ($template) {
  default:

    switch(get_field('additional_content',$page->ID)) {
      case 'video': ?>
        <div class="oEmbedWrapper"><?php echo get_field('additional_content_video'); ?></div>
<?php break;
      case 'image': 
      $addition_content_image = get_field('addition_content_image',$page->ID);
      ?>
        <div class="imageWrapper">
        <img src="<?php echo $addition_content_image['sizes']['Large Slideshow']; ?>"></div>
<?php break;
      case 'text': 
       echo get_field('additional_text');
       break;
       case 'slideshow': ?>
 		 <div class="slideshowContainer servicesSlideshow <?= sizeof($photos) > 1 ? 'hasPhotos' : '' ?>" id="slideshow-<?php echo $ssid; ?>">
            <div class="slideshowSlider">
<?php foreach($photos as $key => $photo) { ?>
              <div class="slide <?php if($key==0) { echo ' active'; } ?>"><img src="<?php echo $photo['sizes']['Large Slideshow']; ?>"></div>
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
}
  $more_content = get_field('more_additional_content',$page->ID);
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

  break;
  case 'template-careers-listing.php':
    $jobs = array();
    $locs = array(0=>'Unknown');
    $jobsPosts = get_posts(array(
      'post_type' => 'jobs',
      'posts_per_page' => -1,
      'post_status' => 'publish',
      'order_by' => 'menu_order'
    ));
    foreach($jobsPosts as $job) {
      $location = get_field('location',$job->ID);
      if(is_array($location) && sizeof($location)) {
        foreach($location as $loc) {
          $jobs[$loc->post_name][] = $job;
          $locs[$loc->post_name] = $loc->post_title;
        }
      }
    }
    foreach($jobs as $loc => $j) {
?>
        <div class="jobsList">
        <h3><?php echo $locs[$loc]; ?></h3>
        <ul class="jobs-accordion">
			<?php foreach($j as $job) { 
				global $job;
				$jobtitle = $job->post_title;
				$jobid = sanitize_title_with_dashes( $jobtitle );
				$joblink = get_permalink( $job->ID );
			?>
	          <li>
	          	<h4><a href="<?php echo $joblink ?>"><?php echo $job->post_title; ?></a></h4>
	            <!--<div class="jobsDetail">
					<?php echo wpautop($job->post_content); ?>
	              <p class="collapse-accordion">Collapse Job Description</p>
	            </div>-->
	          </li>
		  <?php } ?>
        </ul>
      </div><!-- end jobsList -->
<?php } ?>
<?php
  break;
} ?>
    </div><!-- end pageSectionRight -->
  </section>
<?php } ?>
  </div>
</div>
<pre><?php print_r($children); ?></pre>
<?php get_footer(); ?>