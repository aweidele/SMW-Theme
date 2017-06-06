<?php
/* Template Name: Locations */
get_header();
the_post();

$defaultLocation = get_field("default_location");
$scriptOutput = "";
?>
<div id="locationsWrapper">
  <section class="locationsMap">
      <?php echo do_shortcode('[mapplic id="6" h="670"]'); ?>
  </section>
  <?php
  $args = array(
	'post_type'        => 'location',
	'posts_per_page' => -1,
	'order_by' => 'menu_order'
	);
	
  $loc = get_posts($args);
  
  foreach($loc as $locationPost) {
	$relatedNews = get_field('related_news_knowledge', $locationPost->ID);
	$office_leadership = get_field('office_leadership', $locationPost->ID);
	
	$post_title = get_the_title($locationPost);
	
    $google_map = get_field('google_map', $locationPost->ID);
    
    if( $google_map ) {
    	$scriptOutput .= "value = getDistanceFromLatLon(latitude, longitude, " . $google_map['lat'] . ", " . $google_map['lng'] . ");";
    	$scriptOutput .= "if( !current || value < current ) { current = value; selected = $locationPost->ID; }";
    }
    	
	$args = array(
	  'post_type' => 'projects',
	    'posts_per_page' => -1,
	    'order_by' => 'menu_order',
	  'meta_query' => array(
	    array(
	      'key' => 'region',
	      'value' => $locationPost->ID,
	      'compare' => 'LIKE'
	    )
	  )
	);
	
	$projects = get_posts($args);

	echo "<div id='location_$locationPost->ID' class='location-child' ";
	
    if( $locationPost->ID != $defaultLocation->ID )  	
    {
    	echo "style='display:none;'";
    }
    echo ">";
    include( TEMPLATEPATH."/locations/location-detailsalt.php");
    echo "</div>";
  }
  ?>
</div>
<script>
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(loadLocation);
  }
  function loadLocation(position) {
  	var latitude = position.coords.latitude;
  	var longitude = position.coords.longitude;
  	var selected = false;
  	var current = false;
  	var value;
  	
  	<?= $scriptOutput ?>
  	
  	if( selected ) {
  	  jQuery('.location-child').hide();
  	  jQuery('#location_' + selected).show();
  	}
  }
  
  function getDistanceFromLatLon(lat1,lon1,lat2,lon2) {
    var R = 6371; // Radius of the earth in km
    var dLat = deg2rad(lat2-lat1);  // deg2rad below
    var dLon = deg2rad(lon2-lon1); 
    var a = 
      Math.sin(dLat/2) * Math.sin(dLat/2) +
      Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
      Math.sin(dLon/2) * Math.sin(dLon/2)
    ; 
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
    
    return c;
  }

  function deg2rad(deg) {
  	return deg * (Math.PI/180)
  }
</script>
<?php get_footer(); ?>