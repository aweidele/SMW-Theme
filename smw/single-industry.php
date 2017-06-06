<?php get_header(); ?>
<?php
$args = array(
  'post_type'=>array('services','industry','location'),
  'posts_per_page'=>-1,
  'orderby' => 'title',
  'order'   => 'ASC',
);
$filter = new WP_Query($args);
$filters = array();
if($filter->have_posts()) : while($filter->have_posts()) : $filter->the_post();
  $filters[$post->post_type][] = array(
    'title'=>$post->post_title,
    'permalink'=>get_permalink()
  );
endwhile;endif;wp_reset_query();

$projlist = array();
$args = array(
  'posts_per_page'   => -1,
  'post_type' => 'industry',
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
<div id="industryWrapper">
  <nav class="subnav">
    <div class="newsNextPrev">
      <ul>
        <li><a href="<?php echo get_permalink($projlist[$prev]); ?>">Previous</a></li>
        <li><a href="<?php echo get_permalink($projlist[$next]); ?>">Next</a></li>
      </ul>
    </div>
    <div class="subnavContainer">
      <ul class="filters">
        <li>Filter by:</li>
        <li class="with-icon">Market<span class="icon-angle-down"></span>
          <div class="filterDropdown">
            <div class="filterDropdownContent">
              <ul class="splitList">
<?php for($i=0;$i<ceil(sizeof($filters['industry'])/2);$i++) { ?>
                <li><a href="<?php echo $filters['industry'][$i]['permalink']; ?>"><?php echo $filters['industry'][$i]['title']; ?></a></li>
<?php } ?>
              </ul>    
              <ul class="splitList">
<?php for($i=ceil(sizeof($filters['industry'])/2);$i<sizeof($filters['industry']);$i++) { ?>
                <li><a href="<?php echo $filters['industry'][$i]['permalink']; ?>"><?php echo $filters['industry'][$i]['title']; ?></a></li>
<?php } ?>
              </ul>       
            </div>
          </div>
        </li>

        <li class="with-icon">Service<span class="icon-angle-down"></span>
          <div class="filterDropdown">
            <div class="filterDropdownContent">
              <ul class="splitList">
<?php for($i=0;$i<ceil(sizeof($filters['services'])/2);$i++) { ?>
                <li><a href="<?php echo $filters['services'][$i]['permalink']; ?>"><?php echo $filters['services'][$i]['title']; ?></a></li>
<?php } ?>
              </ul>    
              <ul class="splitList">
<?php for($i=ceil(sizeof($filters['services'])/2);$i<sizeof($filters['services']);$i++) { ?>
                <li><a href="<?php echo $filters['services'][$i]['permalink']; ?>"><?php echo $filters['services'][$i]['title']; ?></a></li>
<?php } ?>
              </ul>       
            </div>
          </div>
        </li>
        <li class="with-icon">Region<span class="icon-angle-down"></span>
          <div class="filterDropdown">
            <div class="filterDropdownContent">
              <ul class="splitList">
<?php for($i=0;$i<ceil(sizeof($filters['location'])/2);$i++) { ?>
                <li><a href="<?php echo $filters['location'][$i]['permalink']; ?>"><?php echo $filters['location'][$i]['title']; ?></a></li>
<?php } ?>
              </ul>    
              <ul class="splitList">
<?php for($i=ceil(sizeof($filters['location'])/2);$i<sizeof($filters['location']);$i++) { ?>
                <li><a href="<?php echo $filters['location'][$i]['permalink']; ?>"><?php echo $filters['location'][$i]['title']; ?></a></li>
<?php } ?>
              </ul>       
            </div>
          </div>
        </li>
      </ul>
      <ul class="filter-search-right">
        <li class="filter-search"><form role="search" method="get" id="searchform" class="searchform" action="<?php echo get_home_url(); ?>">
          <div>
            <label class="screen-reader-text" for="s">Search for:</label>
            <input type="text" value="" name="s" id="s" placeholder="Search Projects" />
            <input type="hidden" name="post_type" value="projects" />
            <button><span class="buttontext">Search</span><span class="icon-search"></span></button>
          </div>
        </form></li>
      </ul>
    </div>
  </nav>
  <section id="industryContent">
<?php if(have_posts()) : while(have_posts()) : the_post();
  $subheading = get_field('subheading');
  $leadership = get_field('industry_leader');
  
  $relatedNews = get_field('related_news_knowledge');
  $industry_leader = $leadership[0];
  $industry_leader->thumbnail = get_the_post_thumbnail_url($industry_leader->ID,'Leadership Thumb');
  $brochure = get_field('brochure');
  $post_id = $post->ID;
  $post_title = $post->post_title;
?>
    <div class="pageSectionCopy">
      <h2><?php
        if($subheading != '') {
          echo $subheading;
        } else {
          the_title();
        }
      ?></h2>
      <?php the_content(); ?>
    </div>
    
    <div class="pageSectionRight">
      <div class="industryQuote" style="background-image: url(<?php echo get_the_post_thumbnail_url($post->ID,'Services Background'); ?>)">
      <div class="industryQuoteText">
        <p><?php echo get_field('quote'); ?></p>
<?php if(get_field('quote_attribution') != '') { ?>
        <p class="quoteAttribution">—<?php echo get_field('quote_attribution'); ?></p>
<?php } 
if(is_array($brochure) && sizeof($brochure)) { ?>
        <p class="downloadBrochure"><a href="<?php echo $brochure['url']; ?>" title="<?php echo $brochure['title']; ?>">Download Brochure</a></p>
<?php } ?>
      </div>
      <div class="industryLeader">
        <div class="leadershipCard">
          <a href="<?php echo get_permalink($industry_leader->ID); ?>" data-action="leadership">
            <p class="leadershipPortrait"><img src="<?php echo $industry_leader->thumbnail; ?>"></p>
            <p><strong><?php echo $industry_leader->post_title; ?></strong></p>
            <p><?php echo get_field('title',$industry_leader->ID); ?></p>
          </a>
          <p><a href="tel:<?php echo get_field('phone',$industry_leader->ID); ?>"><?php echo str_replace('-',' ',get_field('phone',$industry_leader->ID)); ?></a></p>
          <ul class="leadershipContact">
            <li class="email"><a href="mailto:<?php echo get_field('email',$industry_leader->ID); ?>"><span><?php echo get_field('email',$industry_leader->ID); ?></span></a></li>
            <li class="linkedin"><a href="<?php echo get_field('linkedin',$industry_leader->ID); ?>" target="_blank"><span><?php echo get_field('linkedin',$industry_leader->ID); ?></span></a></li>
          </ul>
        </div>
      </div>
      <div class="industryQuoteOverlay"></div>
    </div>
    </div>
<?php endwhile;endif;wp_reset_query(); ?>
  </section>
<?php
$args = array(
  'post_type' => 'projects',
  'meta_query' => array(
    array(
      'key' => 'industry',
      'value' => sprintf(':"%s";', $post_id),
      'compare' => 'LIKE'
    )
  )
);
$projects = new WP_Query($args);
if($projects->have_posts()): ?>
  <section id="industryProjects" class="industryRelated">
    <h3><?php echo $post_title; ?> Projects</h3>
    <div>
<?php while($projects->have_posts()) : $projects->the_post(); 
  $ssid = uniqid();
  $photos = get_field('photos');
?>

        <article class="project" id="project-new-york-presbyterian-hospitalweill-cornell-medical-college-ophthalmology-center-2">
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
              </ul>
            </div>
<?php } ?>
          </div>
        </article>

<?php endwhile; ?>
    </div>
  </section>
<?php if(is_array($relatedNews)) { ?>
  <section class="industryRelated">
    <h3>Related News &amp; Knowledge</h3>
 <?php
	$imgsize = "Grid Slideshow Small"; 
	foreach($relatedNews as $i => $article) { 
      include( TEMPLATEPATH."/news/news-article.php");
	}
?>
  </section>
<?php } ?>
<?php endif;wp_reset_query(); ?>
</div>
<?php get_footer(); ?>