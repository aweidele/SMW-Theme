<?php
get_header();
$ppp = get_option('page_for_posts');
$newschildren = get_children(array('post_parent' => $ppp));
$intro = get_post($ppp);

$catargs = array(
	'exclude' => array(453)
);
$categories = get_categories($catargs);
$tags = get_tags();
$authors = getAuthors();

 ?>
<div id="newsWrapper">
  <nav class="subnav">
    <div class="subnavContainer">
      <ul class="filters">
      	<li>Filter by:</li>
        <li class="with-icon">Type<span class="icon-angle-down"></span>
          <div class="filterDropdown">
            <div class="filterDropdownContent">
              <ul class="splitList">
<?php for($i=0;$i<ceil(sizeof($categories)/2);$i++) { ?>
                <li><a href="<?php echo get_category_link( $categories[$i]->term_id ); ?>"><?php echo $categories[$i]->name; ?></a></li>
<?php } ?>
              </ul>
              <ul class="splitList">
<?php for($i=ceil(sizeof($categories)/2);$i<sizeof($categories);$i++) { ?>
                <li><a href="<?php echo get_category_link( $categories[$i]->term_id ); ?>"><?php echo $categories[$i]->name; ?></a></li>
<?php } ?>
              </ul>
            </div>
          </div>
        </li>
        
        <li class="with-icon">Author<span class="icon-angle-down"></span>
          <div class="filterDropdown">
            <div class="filterDropdownContent">
              <ul class="splitList">
<?php for($i=0;$i<ceil(sizeof($authors)/2);$i++) { ?>
                <li><a href="<?php echo get_permalink($ppp); ?>?a=<?php echo $authors[$i]->id; ?>"><?php echo $authors[$i]->post_title; ?></a></li>
<?php } ?>
              </ul>
              <ul class="splitList">
<?php for($i=ceil(sizeof($authors)/2);$i<sizeof($authors);$i++) { ?>
                <li><a href="<?php echo get_permalink($ppp); ?>?a=<?php echo $authors[$i]->id; ?>"><?php echo $authors[$i]->post_title; ?></a></li>
<?php } ?>
            </div>
          </div>
        </li>
      </ul>
      <ul class="filter-search-right">
        <li class="filter-search"><form role="search" method="get" id="searchform" class="searchform" action="<?php echo get_home_url(); ?>">
          <div>
            <label class="screen-reader-text" for="s">Search for:</label>
					<input type="text" value="" name="s" id="s" placeholder="Search News & Knowledge" />
					<input type="hidden" name="post_type" value="post" />
            <button><span class="buttontext">Search</span><span class="icon-search"></span></button>
          </div>
        </form></li>
      </ul>
    </div>
  </nav>
  <section id="newsTiles">
  	  <div class="gutter-sizer"></div>
      <article class="grid-item grid-sizer">
        <div class="newsIntroContainer">
          <h2>News & Knowledge</h2>
          <p><?= get_field("news_knowledge_press_inquiries", $ppp) ?></p>
        </div>
        
      </article>
<?php 
if(have_posts()) {
	$i = 0;
	$firstItem = true;
	while(have_posts()) 
	{
		the_post();
		$t = get_post_meta($post->ID,'tweet');
  		$tweet = (is_array($t) && sizeof($t) && $t[0] == 1) ? true : false;
  
		$article = $post;
		
		$large = false;
		
		if ($i == 3) { 
			$large = true;
		} else {
			$mod = ($i - 8) % 10;
			
			if( $mod == 0 || $mod == 3 ) {
				$large = true;
			} 
		}
		
		$imgsize = $large ? 'Grid Slideshow Large' : 'Grid Slideshow Small';
  
    	include( TEMPLATEPATH."/news/news-article.php");
    	
    	$i++;
    	$firstItem = false;
	}
}
?>
  </section>
  <script>
  var $grid = jQuery('#newsTiles');
  $grid.packery({
	  	columnWidth: '.grid-sizer',
		itemSelector: '.grid-item',
		gutter: '.gutter-sizer',
		rowHeight: '.first-grid-item',
		percentPosition: true
	});
	$grid.imagesLoaded().progress( function() {
  		$grid.packery();
	});</script>
 
</div>
<?php get_footer(); ?>