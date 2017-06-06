<div class="locationContent pageSectionContent">
      <section class="locationStaff">
<?php if($address != '' || ($google_map != '' && is_array($google_map)) ) { ?>
        <h3 class='address-header'>Address</h3>
<?php }

if($google_map != '' && is_array($google_map)) { ?>
        <div class="locationMapContainer"><iframe src="https://www.google.com/maps/embed/v1/place?q=<?php echo urlencode($google_map['address']); ?>&zoom=13&key=AIzaSyC687T-pSk8U3iz7_agbPG7-hCbkax7jxU"></iframe></div>
<?php }
 if($address != '') { ?>
        <p class="location-address"><a href="https://www.google.com/maps/place/<?php echo urlencode($google_map['address']); ?>" target="_blank"><?php echo $address; ?></a></p>
<?php }

if($google_map != '' && is_array($google_map)) {  ?>
        <p class="mapLink"><a href="https://www.google.com/maps/place/<?php echo urlencode($google_map['address']); ?>" target="_blank">View Map</a></p>
<?php } ?>

<?php foreach($office_leadership as $leadership) { 
  $office_leader = $leadership['leadership'];
  $office_leader->thumbnail = get_the_post_thumbnail_url($office_leader->ID,'Leadership Thumb');
  $l = get_field('leadership',$office_leader->ID);
?>      
        <div class="locationLeader">
	        <h3><?php echo $leadership['subhead']; ?></h3>
	        <div class="leadershipCard">
 <?php if($l[0] == 'yes') { ?>
	              <a href="<?php echo get_permalink($office_leader->ID); ?>">
<?php } ?>
	                <p class="leadershipPortrait"><img src="<?php echo $office_leader->thumbnail; ?>"></p>
	                <p><strong><?php echo $office_leader->post_title; ?></strong></p>
	                <p><?php echo get_field('title',$office_leader->ID); ?></p>
 <?php if($l[0] == 'yes') { ?>
	              </a>
<?php } ?>
	              <?php if( get_field('phone',$office_leader->ID) ): ?><p><a href="tel:<?php echo get_field('phone',$office_leader->ID); ?>">+<?php echo str_replace('-',' ',get_field('phone',$office_leader->ID)); ?></a></p><?php endif; ?>
	              <ul class="leadershipContact">
	                <?php if( get_field('email',$office_leader->ID) ): ?><li class="email"><a href="mailto:<?php echo get_field('email',$office_leader->ID); ?>"><span><?php echo get_field('email',$office_leader->ID); ?></span></a></li><?php endif; ?>
	                 <?php if( get_field('linkedin',$office_leader->ID) ): ?><li class="linkedin"><a href="<?php echo get_field('linkedin',$office_leader->ID); ?>" target="_blank"><span><?php echo get_field('linkedin',$office_leader->ID); ?></span></a></li><?php endif; ?>
	              </ul>
        	</div>
        </div>
<?php } ?>
      </section>
      
	<div class="locationRelated">
    	<h3><?= $post_title ?> Projects</h3>
        <section class="locationRelatedItems" id="relatedProjects">
<!--<?php foreach($projects as $i => $proj) { 
  $photos = get_field('photos',$proj->ID);
  $featured = get_field('featured_on_locations_page',$proj->ID);
  if(is_array($featured) && $featured[0] == 'yes') {
?>
    <article id="related-<?php echo $proj->post_name; ?>">
      <div class="slideshowContainer <?= sizeof($photos) > 1 ? 'hasPhotos' : '' ?>" id="slideshow-<?php echo $proj->post_name; ?>">
      	<a href="<?php echo get_permalink($proj->ID); ?>">
        <div class="slideshowSlider">
<?php foreach($photos as $photo) { ?>
            <div class="slide"><img src="<?php echo $photo['sizes']['Homepage Slideshow Thumb']; ?>"></div>
<?php } ?>
        </div>
        </a>
<?php if(sizeof($photos) > 1) { ?>
        <div class="slideshowControls">
          <ul class="prevNext" data-slideshow="slideshow-<?php echo $proj->post_name; ?>">
            <li><span>Previous</span></li>
            <li><span>Next</span></li>
          </ul>
          <ul class="slideshowIndicators" data-slideshow="slideshow-<?php echo $expID; ?>">
<?php foreach($photos as $i => $p) { ?>
            <li<?php if($i==0) { echo ' class="active"'; } ?>><span><?php echo $i; ?></span></li>
<?php } ?>
          </ul>
        </div>
        
<?php } ?>
		<div class="slideshowOverlay">
          <div class="slideshowOverlayContainer"><h3><?php 
              $title = get_field("alternate_display_name", $proj->ID);
              if( !$title ) {
              	$title = $proj->post_title;
              }              
              echo $title; 
               ?></h3>
          </div>
        </div>
      </div>
    </article>
<?php }
} ?>-->

<?php if(is_array($related_projects) && sizeof($related_projects)) { ?>

<?php foreach($related_projects as $project) { 
  $ssid = uniqid(); 
  $projPhotos = get_field('photos',$project->ID)
  ?>
        <article class="project" id="project-<?php echo $project->post_name; ?>">
          <div class="slideshowContainer <?= sizeof($projPhotos) > 1 ? 'hasPhotos' : '' ?>" id="slideshow-<?php echo $ssid; ?>">
            <a href="<?php echo get_permalink($project->ID); ?>">
            <div class="slideshowSlider">
<?php foreach($projPhotos as $key => $photo) { ?>
              <div class="slide <?php if($key==0) { echo ' active'; } ?>" style="background-image:url('<?php echo $photo['sizes']['Grid Slideshow Small']; ?>');">
              	<img src="<?php echo $photo['sizes']['Grid Slideshow Small']; ?>">
              </div>
<?php } ?>
            </div>
            </a>
            <div class="slideshowOverlay">
              <div class="slideshowOverlayContainer"><h4><?php 
              $title = get_field("alternate_display_name", $project->ID);
              if( !$title ) {
              	$title = $project->post_title;
              }              
              echo $title; 
              
               ?></h4></div>
            </div>
<?php if(sizeof($projPhotos) > 1) { ?>
            <div class="slideshowControls">
              <ul class="prevNext" data-slideshow="slideshow-<?php echo $ssid; ?>">
                <li><span>Previous</span></li>
                <li><span>Next</span></li>
              </ul>
              <ul class="slideshowIndicators" data-slideshow="slideshow-<?php echo $ssid; ?>">
<?php foreach($projPhotos as $i => $photo) { ?>
                <li<?php if($i==0) { echo ' class="active"'; } ?>><span><?php echo $i; ?></span></li>
<?php } ?>
              </ul>
            </div>
<?php } ?>
          </div>
        </article>
<?php } ?>

<?php } ?>



        </section>
      </div>
<?php if( $relatedNews ) { ?>
      <div class="locationRelated">
        <h3><?= $post_title ?> News &amp; Knowledge</h3>
        <section class="locationRelatedItems" id="relatedNews">
<?php
	$imgsize = "Grid Slideshow Small"; 
	foreach($relatedNews as $i => $article) { 
      include( TEMPLATEPATH."/news/news-article.php");
	}
?>
        </section>
      </div>
<?php } ?>

  </div>
