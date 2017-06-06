<?php get_header();

/*
$ppp = get_option('page_for_posts');
$newschildren = get_children(array('post_parent' => $ppp));
$intro = get_post($ppp);

$i = -3;
$news = array();
$categories = get_categories();
$tags = get_tags();
$authors = array();
if(have_posts()) : while(have_posts()) : the_post();
  $sub = $i >= 0 && (($i+1)%10 == 1 || ($i+1)%10 == 0) ? 'a' : 'b';
  $imgsize = $sub == 'a' ? 'Grid Slideshow Large' : 'Grid Slideshow Small';
  $t = get_post_meta($post->ID,'tweet');
  $tweet = (is_array($t) && sizeof($t) && $t[0] == 1) ? true : false;

  $news[floor($i/5)][$sub][] = array($post, $imgsize, $tweet);
  
  $author = get_field('author');
  if(is_object($author)) { 
    $authors[] = $author;
  }
  
  $i++;
endwhile; endif; wp_reset_query();
*/
$results = array();
if(have_posts()) : while(have_posts()) : the_post();
  $p = $post;
  $p->photos = get_field('photos');
  $results[$p->post_type][] = $p;
endwhile; endif; wp_reset_query();
 ?>
  <div class="searchResults">
  <section id="searchProjects">
    <h1 style="margin-bottom: 1em;">Search results for “<?php single_tag_title(); ?> ”</h1>



<?php /***************************** PROJECTS RESULTS ****************************/ ?>
<?php if(isset($results['projects']) && sizeof($results['projects'])) { ?>
    <h3 class="search-results-section-title">Projects</h2>
    <div class="search-results-section">
<?php foreach($results['projects'] as $project) { 
  $ssid = uniqid();?>
        <article class="project" id="project-<?php echo $project->post_name; ?>">
          <div class="slideshowContainer <?= sizeof($project->photos) > 1 ? 'hasPhotos' : '' ?>" id="slideshow-<?php echo $ssid; ?>">
            <a href="<?php echo get_permalink($project->ID); ?>">
            <div class="slideshowSlider">
<?php foreach($project->photos as $key => $photo) { ?>
              <div class="slide <?php if($key==0) { echo ' active'; } ?>"><img src="<?php echo $photo['sizes']['Grid Slideshow Small']; ?>"></div>
<?php } ?>
            </div>
            <div class="slideshowOverlay">
              <div class="slideshowOverlayContainer"><h3><?php echo $project->post_title; ?></h3></div>
            </div>
            </a>
<?php if(sizeof($project->photos) > 1) { ?>
            <div class="slideshowControls">
              <ul class="prevNext" data-slideshow="slideshow-<?php echo $ssid; ?>">
                <li><span>Previous</span></li>
                <li><span>Next</span></li>
              </ul>
              <ul class="slideshowIndicators" data-slideshow="slideshow-<?php echo $ssid; ?>">
<?php foreach($project->photos as $i => $photo) { ?>
                <li<?php if($i==0) { echo ' class="active"'; } ?>><span><?php echo $i; ?></span></li>
<?php } ?>
              </ul>
            </div>
<?php } ?>
          </div>
        </article>
<?php } ?>
    </div>
<?php } ?>


<?php /***************************** NEWS RESULTS ****************************/ ?>
<?php if(isset($results['post']) && sizeof($results['post'])) { ?>
    <h3 class="search-results-section-title">News & Knowledge</h2>
    <div class="search-results-section">

<?php foreach($results['post'] as $news) { 
  $ssid = uniqid();
  $article = array($news,'Grid Slideshow Small',false);
  showArticle($article);
 } ?>
    </div>
<?php } ?>
  </section>
  </div>
  <?php get_footer(); ?>