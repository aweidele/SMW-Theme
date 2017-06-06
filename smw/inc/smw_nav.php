<?php
function smw_get_menu_items($menu_name){
  if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
    $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
    return wp_get_nav_menu_items($menu->term_id);
  }
}

function smw_nav($menu_name,$postID=null,$subnav=false,$button=false) {
  global $post;
  $currentTemplate = get_page_template_slug($post->ID);
  $postPage = get_option('page_for_posts');
  $nav = smw_get_menu_items($menu_name);
  foreach($nav as $n) {
    $template = get_page_template_slug($n->object_id);
    if($n->post_status == 'publish') {
      $cssClass = implode(' ', $n->classes);
      
      echo '  <li class="menu-' . $n->ID . " $cssClass";
      $currentPage = (
        $postID == $n->object_id || 
        ($n->object_id == $postPage && 
          (is_home() || $post->post_parent == $postPage)
        ) || (
          $template == 'template-location.php' && $post->post_type == 'location' && !is_404() && (is_post_type_archive('location') || is_single())
        )
      );

      if($currentPage) { echo ' current_page '; }
      
      if($currentTemplate == 'template-contact.php' && $template == 'template-location.php') {
        echo ' menu_show';
      }
      
      echo '">';
      if($button && $template == 'template-location.php') {
        echo '<a href="javascript: void(0)">'.$n->title."</a>";
      } else {
        echo '<a href="'.$n->url.'">'.$n->title."</a>";
      }
      if($subnav) { 
        if($button) {
          echo '<button></button>';
        }
        smw_subnav($n->object_id,$currentPage); 
      }
      echo "</li>\n";
    }
  }

}

function smw_subnav($post_id,$currentPage=false) {
  global $post;
  $thispost = get_post($post_id);
  $template = get_page_template_slug($thispost);
  $postPage = get_option('page_for_posts');
  
  $preWrap = '<div class="navDropdownWrapper';
  if($template == 'template-location.php') { $preWrap .= ' locations'; }
  if($template == 'template-projects.php') { $preWrap .= ' projects'; }
  $preWrap .= '"><div class="navDropdownCenterer"><div class="navDropdown">';
  $postWrap = '</div></div></div>';

/****************** ABOUT DROPDOWN *****************************************************/
if($template == 'template_about.php') { 
      $my_wp_query = new WP_Query();
      $all_wp_pages = $my_wp_query->query(array('post_type' => 'page', 'posts_per_page' => -1, 'order' => 'ASC', 'orderby' => 'menu_order', 'post_parent' => $post_id));
      $childPages = get_page_children($post_id,$all_wp_pages);
      echo $preWrap;
?>
      <ul>
        <li><a href="<?php if(!$currentPage) { echo get_permalink($post_id); } ?>#about">Who We Are</a></li>
<?php foreach($childPages as $c) {
  if($c->post_status == 'publish') {
 ?>
        <li><a href="<?php if(!$currentPage) { echo get_permalink($post_id); } ?>#<?php echo $c->post_name; ?>"><?php echo $c->post_title; ?></a></li>
<?php 
  }
} ?>
      </ul>
<?php 
	  echo $postWrap;



 
/****************** SERVICES DROPDOWN ****************************************************/
} else if($template == 'template-services.php') {
$args = array(
  'post_type' => 'services',
  'posts_per_page' => -1
);
$services = new WP_Query($args);
if($services->have_posts()) : 
      echo $preWrap;
?>
      <ul>
<?php while($services->have_posts()) : $services->the_post(); ?>
        <li><a href="<?php if(!$currentPage) { echo get_permalink($post_id); } ?>#<?php echo $post->post_name; ?>"><?php echo $post->post_title; ?></a></li>
<?php endwhile; ?>
      </ul>
<?php echo $postWrap; endif; wp_reset_query();
} else if($template == 'template-projects.php') {
  $args = array(
    'post_type'=>array('industry'),
    'posts_per_page'=>-1,
    'orderby' => 'title',
    'order'   => 'ASC',
  );
  $filter = new WP_Query($args);
  $filters = array();
  if($filter->have_posts()) :
      echo $preWrap;
?>
      <ul>
<?php while($filter->have_posts()) : $filter->the_post(); ?>
        <li><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></li>
<?php endwhile; ?>
      </ul>
<?php echo $postWrap; endif; wp_reset_query();
} 
 
 
/****************** NEWS DROPDOWN *******************************************************/
else if($post_id == $postPage) { 
$ppp = get_option('page_for_posts');
$the_post_ID = $post->ID;
$newschildren = get_children(array('post_parent' => $ppp));

      echo $preWrap;
      ?>
      <ul>
        <li<?php if ( is_home()  ) echo ' class="current"'; ?>><a href="<?php echo get_permalink($ppp); ?>">News Feed</a></li>
<?php foreach($newschildren as $newsie) { 
  if($newsie->post_status == 'publish') {
?>
        <li<?php if ( $newsie->ID == $the_post_ID ) echo ' class="current"'; ?>><a href="<?php echo get_permalink($newsie->ID); ?>"><?php echo $newsie->post_title; ?></a></li>
<?php 
  }
} ?>
      </ul>
<?php 
	  echo $postWrap;



 
/****************** LOCATIONS DROPDOWN ****************************************************/
} else if($template == 'template-location.php') {
  $args = array(
    'post_type'        => 'location',
    'posts_per_page' => -1,
    'order_by' => 'menu_order'
  );
  $the_post_ID = $post->ID;
  $loc = get_posts($args);
  
      echo $preWrap;
?>
        <ul>
<?php foreach($loc as $location) { ?>
          <li<?php if ( $location->ID == $the_post_ID ) echo ' class="current"'; ?>><a href="<?php echo get_permalink($location->ID); ?>"><?php echo $location->post_title; ?></a></li>
<?php } ?>
        </ul>
      
<?php echo $postWrap; 
 
/****************** CAREERS DROPDOWN ****************************************************/
} else if($template == 'template-careers.php') {
      $my_wp_query = new WP_Query();
      $all_wp_pages = $my_wp_query->query(array('post_type' => 'page', 'posts_per_page' => -1, 'order' => 'ASC', 'orderby' => 'menu_order', 'post_parent' => $post_id));
      $childPages = get_page_children($post_id,$all_wp_pages);
      echo $preWrap;
?>
      <ul>
        <li><a href="<?php if(!$currentPage) { echo get_permalink($post_id); } ?>#<?php echo $thispost->post_name; ?>">Careers at SM&W</a></li>
<?php foreach($childPages as $c) {
  if($c->post_status == 'publish') {
 ?>
        <li><a href="<?php if(!$currentPage) { echo get_permalink($post_id); } ?>#<?php echo $c->post_name; ?>"><?php echo $c->post_title; ?></a></li>
<?php 
  }
} ?>
      </ul>

<?php echo $postWrap; } 
} ?>