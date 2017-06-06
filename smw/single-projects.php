<?php get_header(); ?>
<div id="projectsWrapper">
<?php 

$projlist = array();
$args = array(
  'posts_per_page'   => -1,
  'post_type' => 'projects'
);
$all = get_posts($args);
foreach($all as $a) {
  $projlist[] = $a->ID;
}

if(have_posts()): while(have_posts()) : the_post();
  $services                = get_field('services');
  $industry                = get_field('industry');
  $location				   = get_field('location');
  $photos                  = get_field('photos');
  $project_size            = get_field('project_size');
  $completion              = get_field('completion');
  $project_team            = get_field('project_team');
  $project_quote           = get_field('project_quote');
  $project_quote_attribute = get_field('project_quote_attribute');
  $project_quote_photo     = get_field('project_quote_photo');
  $related_projects        = get_field('related_projects');
  $related_news	           = get_field('related_news_knowledge');
  $tags                    = wp_get_post_terms( $post->ID, 'project_tags' );
  
  $current = array_search($post->ID,$projlist);
  $next = $current < sizeof($projlist) - 1 ? $current + 1 : 0;
  $prev = $current > 0 ? $current - 1 : sizeof($projlist) - 1;
  
?>
  <section id="singleProjectHeader">
    <div class="singleProjectTitle">
      <h2><?php the_title(); ?></h2>
        <div class="newsSub">
      <?php 
      if( $location ) {
      	echo '<p>'.$location.'</p>';
      }
      ?>
      	
          <nav class="newsNextPrev">
            <ul>
              <li><a href="<?php echo get_permalink($projlist[$prev]); ?>">Previous</a></li>
              <li><a href="<?php echo get_permalink($projlist[$next]); ?>">Next</a></li>
            </ul>
            <a href="http://www.smwllc.com/projects">« BACK TO PROJECTS</a>
          </nav>
        </div>
    </div>
  </section>
  <section id="singleProjectSlideshow">
    <div class="projectSlideshow">
		<?php if( get_field("hero_video") ) { ?>
		<div class="oEmbedWrapper"><?php echo get_field('hero_video'); ?></div>
		<?php } else { ?>
	    <?php $ssid = uniqid(); ?>
	          <div class="slideshowContainer <?= sizeof($photos) > 1 ? 'hasPhotos' : '' ?>" id="slideshow-<?php echo $ssid; ?>">
	            <div class="slideshowSlider">
	<?php foreach($photos as $key => $photo) { ?>
	              <div class="slide <?php if($key==0) { echo ' active'; } ?>" style="background-image:url('<?php echo $photo['sizes']['Large Slideshow']; ?>');" >
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
	<?php } ?>
	</div>
	
    <div class="servicesList">
      <ul class="servicesIcons">
<?php foreach($services as $s) { 
  $icon = get_field('icon',$s->ID);
?>
        <li><a href="<?php echo get_permalink($s->ID); ?>"><img src="<?php echo $icon['url']; ?>"><span><?php echo $s->post_title; ?></a></span></li>
<?php } ?>
      </ul>
    </div>
  </section>
  <section id="singleProjectCopy">
    <div class="mainCopy">
      <h3>SM&W Contribution</h3>
      <?php the_content(); ?>
<?php if(sizeof($industry)) { ?>
      <aside>
        <h3>Industry</h3>
        <ul>
<?php foreach($industry as $ind) { ?>
          <li><a href="<?php echo get_permalink($ind->ID); ?>"><?php echo $ind->post_title; ?></a></li>
<?php } ?>
        </ul>
      </aside>
<?php }
  if($project_team != '') { ?>
      <aside>
        <h3>Project Team</h3>
        <p><?php echo $project_team; ?></p>
      </aside>
<?php }
  if($project_size != '') { ?>
      <aside>
        <h3>Project Size</h3>
        <p>Area: <?php echo $project_size; ?></p>
      </aside>
<?php
}
if($completion != '') { ?>
      <aside>
        <h3>Completion</h3>
        <p><?php echo $completion; ?></p>
      </aside>
<?php } if(sizeof($tags)) { ?>
      <aside>
        <h3>Tags</h3>
        <ul>
<?php foreach($tags as $tag) { ?>
          <li><a href="<?php echo get_term_link($tag->term_id); ?>"><?php echo $tag->name; ?></a></li>
<?php } ?>
        </ul>
      </aside>
<?php } ?>
		<div class="sharebox">
	    	<h3>Share this project:</h3>
	    	<?php 
				$url = get_permalink($post->ID);
				$title = get_the_title($post->ID);
				echo do_shortcode('[easy-social-share buttons="facebook,twitter,linkedin,mail" counters=0 style="button" point_type="simple" url="'.$url.'" text="'.$title.'"]'); 
?> 
	    </div>
    </div>
    
    <div class="projectQuote">
<?php if(is_array($project_quote_photo)) { ?>
      <p class="projectQuotePhoto"><img src="<?php echo $project_quote_photo['sizes']['Project Quote Photo']; ?>"></p>
<?php } if($project_quote != '') { ?>
      <blockquote>
        <p><?php echo $project_quote; ?></p>
<?php if($project_quote_attribute != '') { ?>
        <cite>—<?php echo $project_quote_attribute; ?></cite>
<?php } ?>
      </blockquote>
<?php } ?>
    </div>
  </section>
<?php if(is_array($related_projects) && sizeof($related_projects)) { ?>
  <section id="singleProjectRelated">
    <div class="relatedProjects">
      <h3>Related Projects</h3>
      <div>
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
      </div>
    </div>
  </section>
<?php } ?>

<?php if(is_array($related_news)) { ?>
  <section class="singleProjectRelated">
    <div class="relatedProjects">
      <h3>Related News &amp; Knowledge</h3>
      <div>
 <?php
      $imgsize = "Grid Slideshow Small"; 
	  foreach($related_news as $i => $article) { 
        include( TEMPLATEPATH."/news/news-article.php");
	  }
?>
      </div>
    </div>
  </section>
<?php } ?>

<?php endwhile; endif; wp_reset_query(); ?>
</div>
<?php get_footer(); ?>