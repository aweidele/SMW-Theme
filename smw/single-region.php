<?php get_header(); 
$post_title = $post->post_title;
$title = get_field('region_label');
$map = get_field('map_id');
$args = array(
  'post_type'=>array('services','industry','region'),
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

?>
<div id="projectsWrapper">
  <nav class="subnav">
    <div class="subnavContainer">
      <ul class="filters">
        <li>Filter by:</li>
        <li>Industry
          <ul>
<?php foreach($filters['industry'] as $f) { ?>
            <li><a href="<?php echo $f['permalink']; ?>"><?php echo $f['title']; ?></a></li>
<?php } ?>
          </ul>
        </li>
        <li>Service
          <ul>
<?php foreach($filters['services'] as $f) { ?>
            <li><a href="<?php echo $f['permalink']; ?>"><?php echo $f['title']; ?></a></li>
<?php } ?>
          </ul>
        </li>
        <li>Region
          <ul>
<?php foreach($filters['region'] as $f) { ?>
            <li><a href="<?php echo $f['permalink']; ?>"><?php echo $f['title']; ?></a></li>
<?php } ?>
          </ul>
        </li>
      </ul>
      <ul class="views">
        <li class="gridview"><a href="?v=grid"><span>Grid</span></a></li>
        <li class="listview"><a href="?v=list"><span>List</span></a></li>
        <li class="locationview"><a href="?v=location"><span>Location</span></a></li>
      </ul>
    </div>
  </nav>
  <section id="regionMap">
    <div class="locationsMap">
      <?php echo do_shortcode('[mapplic id="'.$map.'" h="650"]'); ?>
    </div>
  </section>
<?php
$args = array(
  'post_type' => 'projects',
  'meta_key' => 'region',
  'meta_value' => $post->ID
//   'meta_query' => array(
//     array(
//       'key' => 'industry',
//       'value' => $post_id,
//       'compare' => 'LIKE'
//     )
//   )
);
$projects = new WP_Query($args);
if($projects->have_posts()): ?>
  <section id="regionProjects">
    <h2><?php echo $title != "" ? $title : $post_title; ?></h2>
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
            <div class="slideshowControls">
              <ul class="prevNext" data-slideshow="slideshow-<?php echo $ssid; ?>">
                <li><span>Previous</span></li>
                <li><span>Next</span></li>
              </ul>
              <ul class="slideshowIndicators" data-slideshow="slideshow-<?php echo $ssid; ?>">
<?php for($i=0;$i>sizeof($photos);$i++) { ?>
                <li<?php if($i==0) { echo ' class="active"'; } ?>><span><?php echo $i; ?></span></li>
<?php } ?>
              </ul>
            </div>
          </div>
        </article>

<?php endwhile; ?>
  </section>
<?php endif;wp_reset_query(); ?>
</div>
<?php get_footer(); ?>