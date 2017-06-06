<?php get_header(); 
$projlist = array();
$args = array(
  'posts_per_page'   => -1,
  'post_type' => 'services',
  'orderby' => 'title',
  'order'   => 'ASC',
);
$all = get_posts($args);
foreach($all as $a) {
  $projlist[] = $a->ID;
}
  $current = array_search($post->ID,$projlist);
  $next = $current < sizeof($projlist) - 1 ? $current + 1 : 0;
  $prev = $current > 0 ? $current - 1 : sizeof($projlist) - 1;
?>
<div id="servicesWrapper">
  <nav class="subnav">
    <div class="newsNextPrev">
      <ul>
        <li><a href="<?php echo get_permalink($projlist[$prev]); ?>">Previous</a></li>
        <li><a href="<?php echo get_permalink($projlist[$next]); ?>">Next</a></li>
      </ul>
    </div>
  </nav>
<?php if(have_posts()) : while(have_posts()) : the_post(); 
  $post_id = $post->ID;
  
  $relatedNews = get_field('related_news_knowledge');
  $principalArray = array();
  $principals = get_field('principals');
  $quoteattribute = get_field('quote_attribute');
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
  $icon = get_field('icon');
  $brochure = get_field('brochure');
  
?>
  <section id="services-<?php echo $post->post_name; ?>">
    <div class="pageSectionContent">
      <div class="pageSectionCopy">
        <h2><?php the_title(); ?></h2>
        <?php the_content(); ?>
      </div>
      <div class="pageSectionRight">
        <div class="servicesQuote" style="background-image: url(<?php echo get_the_post_thumbnail_url($post->ID,'Services Background'); ?>)">
        <div class="servicesQuoteText">
          <p><?php echo get_field('quote'); ?></p>
		<?php if( $quoteattribute ): ?>
		          <p class="quoteAttribution">—<?php echo $quoteattribute ?></p>
		<?php endif; ?>
<?php if(is_array($brochure) && sizeof($brochure)) { ?>
          <p class="viewProjects"><a href="<?php echo $brochure['url']; ?>" target="_blank">Download Brochure</a></p>
<?php } ?>
        </div>
        <div class="servicesQuoteAttribute">
<?php foreach($principalArray as $principal) { ?>

            <div class="leadershipCard">
              <a href="<?php echo $principal['permalink']; ?>">
                <p class="leadershipPortrait"><img src="<?php echo $principal['thumbnail']; ?>"></p>
                <p><strong><?php echo $principal['name']; ?></strong></p>
                <p><?php echo $principal['title']; ?></p>
              </a>
              <p><a href="tel:<?php echo $principal['phone']; ?>">+<?php echo str_replace('-',' ',$principal['phone']); ?></a></p>
              <ul class="leadershipContact">
                <li class="email"><a href="mailto:<?php echo $principal['email']; ?>"><span><?php echo $principal['email']; ?></span></a></li>
                <li class="linkedin"><a href="<?php echo $principal['linkedin']; ?>" target="_blank"><span><?php echo $principal['linkedin']; ?></span></a></li>
              </ul>
            </div>

<?php } ?>
        </div>
        <div class="servicesQuoteOverlay"></div>
          <ul class="servicesIcons">
            <li><img src="<?php echo $icon['url']; ?>"><span><?php the_title(); ?></span></li>
          </ul>
      </div>
      </div>
    </div>
  </section>
<?php endwhile;endif;wp_reset_query(); ?>
<?php /******** LIST OF PROJECTS ********/ ?>

<?php
$postnumber = 
$args = array(
  'post_type' => 'projects',
  'posts_per_page' => get_field('projectnumber'),
  'meta_query' => array(
    array(
      'key' => 'services',
      'value' => sprintf(':"%s";', $post_id),
      'compare' => 'LIKE'
    )
  )
);
$projects = new WP_Query($args);
if($projects->have_posts()): ?>
  <section id="industryProjects">
    <h3><?= get_the_title() ?> Projects</h3>
    <div>
    
    <?php $posts = get_field('featured_projects'); if( $posts ): ?>
    
	    <?php foreach( $posts as $post): setup_postdata($post); 
		    
		    $ssid = uniqid();
			$photos = get_field('photos');
		    
	    ?>
	    	 <article class="project" id="<?php echo $post->post_name; ?>">
		          <div class="slideshowContainer <?= sizeof($photos) > 1 ? 'hasPhotos' : '' ?>" id="slideshow-<?php echo $ssid; ?>">
		            <a href="<?php echo get_permalink(); ?>">
		            <div class="slideshowSlider">
		<?php foreach($photos as $key=>$photo) { ?>
		              <div class="slide<?php if($key==0) { echo ' active'; } ?>" style="background-image:url('<?php echo $photo['sizes']['Grid Slideshow Small']; ?>');">
		              	<img src="<?php echo $photo['sizes']['Grid Slideshow Small']; ?>">
		              </div>
		<?php } ?>
		            </div>
		            </a>
		            <div class="slideshowOverlay">
		              <div class="slideshowOverlayContainer"><h3><?php 
		              $title = get_field("alternate_display_name", $post->ID);
		              if( !$title ) {
		              	$title = $post->post_title;
		              }              
		              echo $title; 
		              
		               ?></h3></div>
		            </div>
		<?php if(sizeof($photos) > 1) { ?>
		            <div class="slideshowControls">
		              <ul class="prevNext" data-slideshow="slideshow-<?php echo $ssid; ?>">
		                <li><span>Previous</span></li>
		                <li><span>Next</span></li>
		              </ul>
		              <ul class="slideshowIndicators" data-slideshow="slideshow-<?php echo $ssid; ?>">
		<?php foreach($photos as $i=>$photo) { ?>
		                <li<?php if($i==0) { echo ' class="active"'; } ?>><span><?php echo $i; ?></span></li>
		<?php } ?>
		              </ul>
		            </div>
		<?php } ?>
		          </div>
		        </article>
	    <?php endforeach; ?>
	    <?php wp_reset_postdata(); ?>
	<?php endif; ?>
    </div>
  </section>
<?php if(is_array($relatedNews)) { ?>
  <section class="industryRelated">
    <h3>Related News &amp; Knowledge</h3>
    <div>
 <?php
	$imgsize = "Grid Slideshow Small"; 
	foreach($relatedNews as $i => $article) { 
      include( TEMPLATEPATH."/news/news-article.php");
	}
?>
    </div>
  </section>
<?php } ?>
<?php endif;wp_reset_query(); ?>

</div>
<?php get_footer(); ?>