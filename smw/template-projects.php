<?php 
  /* Template Name: Projects */ 
  get_header();
  $view = isset($_GET['v']) ? $_GET['v'] : 'grid';
  $sort = isset($_GET['sort']) && $_GET['sort'] == 'desc' ? 'DESC' : 'ASC';
  $orderby = isset($_GET['order']) ? $_GET['order'] : 'title';
?>
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
?>
<div id="projectsWrapper">
  <nav class="subnav">
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
        <li>
          <ul class="views">
            <li class="gridview"><a href="?v=grid"><span>Grid</span></a></li>
            <li class="listview"><a href="?v=list"><span>List</span></a></li>
          </ul></li>
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
<?php switch($view) {
  case 'grid': 
  /************************ GRID VIEW ***************************************************/
   ?>
<?php if(have_posts()) : while(have_posts()) : the_post(); 
  $featured_projects = get_field('featured_projects');
  $photos = get_field('photos',$featured_projects[0]->ID);
  $ssid = uniqid();
?>
  <section id="projects-intro">
    <div class="pageSectionContent">
      <div class="pageSectionCopy">
        <?php the_content(); ?>
      </div>
      <div class="projectFeature">
          <div class="slideshowContainer <?= sizeof($photos) > 1 ? 'hasPhotos' : '' ?>" id="slideshow-<?php echo $ssid; ?>">
            <div class="slideshowSlider">
<?php foreach($photos as $key => $photo) { ?>
              <div class="slide <?php if($key==0) { echo ' active'; } ?>" style="background-image:url('<?php echo $photo['sizes']['Large Slideshow']; ?>');">
              	<a href="<?php echo get_permalink($featured_projects[0]->ID); ?>">
              		<img src="<?php echo $photo['sizes']['Large Slideshow']; ?>">
              	</a>
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
            <div class="slideshowOverlay">
              <div class="slideshowOverlayContainer"><h3><?php echo $featured_projects[0]->post_title; ?></h3></div>
            </div>
          </div>

      
      </div>
    </div>
  </section>
<?php endwhile;endif;wp_reset_query(); ?>
  
  <section id="projectsGrid">
<?php 
  $groups = groupProjects();
  foreach($groups as $projectCols) { ?>
    <div class="projectRow">
<?php foreach($projectCols as $type => $proj) { 
  $imgsize = $type == 'a' ? 'Grid Slideshow Large' : 'Grid Slideshow Small';
?>
      <div class="projectCol<?php if($type == 'a') { echo ' projectColBig'; } ?>">
<?php foreach($proj as $project) { 
  $ssid = uniqid();
?>
<!-- <?php print_r($project); ?> -->
        <article class="project" id="project-<?php echo $project['name']; ?>">
          <div class="slideshowContainer <?= sizeof($project['photos']) > 1 ? 'hasPhotos' : '' ?>" id="slideshow-<?php echo $ssid; ?>">
            <a href="<?php echo $project['permalink']; ?>">
            <div class="slideshowSlider">
<?php foreach($project['photos'] as $key => $photo) { ?>
              <div class="slide <?php if($key==0) { echo ' active'; } ?>" style="background-image:url('<?php echo $photo['sizes'][$imgsize]; ?>');">
              	<img src="<?php echo $photo['sizes'][$imgsize]; ?>">
              </div>
<?php } ?>
            </div>
            </a>
            <div class="slideshowOverlay">
              <div class="slideshowOverlayContainer"><h3><?php echo $project['title']; ?></h3></div>
            </div>
<?php if(sizeof($project['photos']) > 1) { ?>
            <div class="slideshowControls">
              <ul class="prevNext" data-slideshow="slideshow-<?php echo $ssid; ?>">
                <li><span>Previous</span></li>
                <li><span>Next</span></li>
              </ul>
              <ul class="slideshowIndicators" data-slideshow="slideshow-<?php echo $ssid; ?>">
<?php foreach($project['photos'] as $i => $photo) { ?>
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
    </div>
<?php } ?>
  </section>
<?php break;
  case 'list':
  /************************ LIST VIEW ***************************************************/ ?>
  <section id="projects-list">
    <div class="pageSectionContent">
      <div class="pageSectionCopy">
        <?php the_content(); ?>
      </div>
      <div class="projectListView">
        <div class="row">
          <div class="th sort-column" data-sort-column="project">Project</div>
          <div class="th sort-column" data-sort-column="location">Location</div>
          <div class="th sort-column" data-sort-column="industry">Industry</div>
          <div class="th sort-column" data-sort-column="service">Service</div>
        </div>
<?php
  $args = array(
    'post_type' => 'projects',
    'posts_per_page' => -1,
    'orderby' => $orderby,
    'order'   => $sort,
  );
  $projects = new WP_Query($args);
  $jslist = array();
  if($projects->have_posts()) : while($projects->have_posts()) : $projects->the_post();
    $industry = get_field('industry');
    $services = get_field('services');
    $location = get_field('location');
    
    $firstIndustry = "";
    $firstService = "";
    
    if( count($industry) > 0 ) {
    	$firstIndustry = $industry[0]->post_title;
    }
    
    if( count($services) > 0 ) {
    	$firstService = $services[0]->post_title;
    }
    
?>
        <div class="row sortable-item" data-sort-project="<?php htmlspecialchars(the_title()) ?>" data-sort-location="<?= htmlspecialchars($location) ?>" data-sort-industry="<?= htmlspecialchars($firstIndustry) ?>" data-sort-service="<?= htmlspecialchars($firstService) ?>">
          <div class="col"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></div>
          <div class="col"><?php echo $location; ?></div>
          <div class="col"><ul class="industry">
<?php foreach($industry as $ind) { ?>
            <li><a href="<?php echo get_permalink($ind->ID); ?>"><?php echo $ind->post_title; ?></a></li>
<?php } ?>
          </ul></div>
          <div class="col"><ul class="servicesIcons">
<?php foreach($services as $s) { 
  $icon = get_field('icon',$s->ID);
?>
            <li><a href="<?php echo get_permalink($s->ID); ?>"><img src="<?php echo $icon['url']; ?>"><span><?php echo $s->post_title; ?></a></span></li>
<?php } ?>
          </ul></div>
        </div>
<?php endwhile;endif;wp_reset_query(); ?>
      </div>
    </div>
  </section>
<?php break;
} ?>
</div>
<script>
  jQuery(function(){jQuery(".projectListView").sortTable();});
</script>
<?php get_footer(); 

function groupProjects() {
  global $post;
  $args = array(
    'post_type' => 'projects',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'meta_key' => 'show_project',
    'meta_value' => 'yes'
  );
  $projects = new WP_Query($args);
  $groups = array();
  $i = 0;

  if($projects->have_posts()) : while($projects->have_posts()) : $projects->the_post();
    $alternate_display_name = get_field('alternate_display_name');
    $proj = array(
      'ID'=>$post->ID,
      'name'=>$post->post_name,
      'title'=>$alternate_display_name == '' ? $post->post_title : $alternate_display_name,
      'permalink'=>get_permalink(),
      'photos'=>get_field('photos')
    );
    $sub = (($i+1)%10 == 1 || ($i+1)%10 == 0) ? 'a' : 'b';
    $groups[floor($i/5)][$sub][] = $proj;
    $i++;
  endwhile;endif;wp_reset_query();
  return $groups;
}

?>