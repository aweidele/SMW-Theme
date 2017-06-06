<?php
/* Template Name: Homepage */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'inc/Mobile-Detect-2.8.22/Mobile_Detect.php';
$detect = new Mobile_Detect();
get_header();
?>
<div id="homepageWrapper">
<?php 
$homepage_sections = get_field('homepage_sections');
foreach($homepage_sections as $k => $section) {
  switch($section['section_content']) {
    case "video":
      homepageVideo($section,$detect);
      break;
    case "services":
      homepageServices($section);
      break;

    case "expertise";
      homepageMarkets($section);
      break;

    case "locations";
      homepageLocations($section);
      break;

    case "contact";
      homepageContact($section);
      break;
  }
} ?>
</div>
<?php get_footer(); ?>
<?php 



/***** VIDEO SECTION ********************************************************************/
function homepageVideo($section,$detect) { 
  $slideshow = $section['homepage_mobile_background'];
  $bgimg = $slideshow[0]['sizes']['Mobile Background'];
?>

  <!-- VIDEO -->
  <section id="homepageVideo">
<?php if ($detect->isMobile()) { ?>
    <div class="slideshowLayer">
      <img src="<?php echo $bgimg; ?>">
    </div>
<?php } else { ?>
    <div class="videoLayer">
      <video autoplay loop muted>
        <source src="/SPLASH/timelapse.mp4" type="video/mp4">
      </video>
    </div>
<?php } ?>
    <div class="dotLayer"></div>
    <div class="contentLayer">
      <div class="contentLayerContent">
        <p><?php echo $section['section_blurb']; ?></p>
        <p class="jumplink"><a href="<?php echo get_permalink($section['jump_button_link']); ?>"><?php echo $section['jump_button_text']; ?></a></p>
      </div>
    </div>
    <div class="scrolldown">
      <p>Scroll Down</p>
    </div>
  </section>
  <!-- END VIDEO -->

<?php }



/***** SERVICES SECTION *****************************************************************/
function homepageServices($section) { ?>

  <!-- SERVICES -->
  <section id="homepageServices">
    <h2><?php echo $section['section_title']; ?></h2>
    <p class="sectionStatement"><?php echo $section['section_blurb']; ?></p>
    <div class="servicesTiles">

<?php
  $args = array(
    'post_type' => 'services',
    'posts_per_page' => -1,
  );
  $servicesQuery = new WP_Query($args);
  if($servicesQuery->have_posts()) : while($servicesQuery->have_posts()) : $servicesQuery->the_post();
    $icon = get_field('icon');
    $icon_background = get_field('icon_background');
?>
      <article>
        <a href="<?php echo get_permalink(); ?>">
        <p class="icon">
          <span class="icon_init"><img src="<?php echo $icon['url']; ?>"></span>
        </p>
        <p class="blurb"><?php echo get_field('homepage_blurb'); ?></p>
        <p class="readmore"><span>Learn More ></span></p>
        </a>
      </article>
<?php endwhile; endif; wp_reset_query(); ?>

    </div>
  </section>
  <!-- END SERVICES -->

<?php } 



/***** MARKETS SECTION ******************************************************************/
function homepageMarkets($section) {
  global $post;
  $args = array(
    'post_type' => 'industry',
    'posts_per_page' => -1,
    'order_by' => 'menu_order'
  );
  $marketQuery = new WP_Query($args);
?>

  <!-- EXPERTISE -->
  <section id="homepageExpertise">
    <h2><?php echo $section['section_title']; ?></h2>
    <p class="sectionStatement"><?php echo $section['section_blurb']; ?></p>
    <div class="expertiseTiles">
<?php if($marketQuery->have_posts()) : while($marketQuery->have_posts()) : $marketQuery->the_post(); 
  $featured_projects = get_field('featured_projects');
?>

    <article id="market-<?php echo $post->post_name; ?>">
      <h3><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
<?php if(is_array($featured_projects) && sizeof($featured_projects)) { ?>
      <div class="slideshowContainer" id="slideshow-<?php echo $post->post_name; ?>">
        <div class="slideshowSlider">

<?php foreach($featured_projects as $project) { 
  $photos = get_field('photos',$project->ID);
?>
            <div class="slide" style="background-image:url('<?php echo $photos[0]['sizes']['Homepage Slideshow Thumb']; ?>');">
            	<img src="<?php echo $photos[0]['sizes']['Homepage Slideshow Thumb']; ?>">
            </div>
<?php } ?>

        </div>
        
        <div class="slideshowOverlay">
          <div class="slideshowOverlayContainer">
            <div class="slideshowSlideTitles" id="slideshowSlideTitles-<?php echo $post->post_name; ?>">
<?php foreach($featured_projects as $i => $project) { ?>
              <h3<?php if($i==0) { echo ' class="active"'; } ?>><a href="<?php echo get_permalink($project->ID); ?>"><?php 
              $title = get_field("alternate_display_name", $project->ID);
              if( !$title ) {
              	$title = $project->post_title;
              }              
              echo $title; 
              
              ?></a></h3>
<?php } ?>
            </div>
          </div>
        </div>
<?php if(sizeof($featured_projects) > 1) { ?>
        <div class="slideshowControls">
          <ul class="prevNext" data-slideshow="slideshow-<?php echo $post->post_name; ?>">
            <li><span>Previous</span></li>
            <li><span>Next</span></li>
          </ul>
          <ul class="slideshowIndicators" data-slideshow="slideshow-<?php echo $expID; ?>" style="display: none;">
<?php foreach($featured_projects as $i => $project) { ?>
            <li<?php if($i==0) { echo ' class="active"'; } ?> data-slideTitle="<?php echo $project->post_title; ?>"><span><?php echo $i; ?></span></li>
<?php } ?>
          </ul>
        </div>
<?php } ?>
      </div>
<?php } ?>
    </article>

<?php endwhile; endif; wp_reset_query(); ?>


    </div>
  </section>
<?php }



/***** LOCATIONS SECTION ****************************************************************/
function homepageLocations($section) { ?>

  <!-- LOCATIONS -->
  <section id="homepageLocations">
    <div class="homepageLocationCopy">
      <h2><?php echo $section['section_title']; ?></h2>
      <p class="sectionStatement"><?php echo $section['section_blurb']; ?></p>
    </div>
    <div class="locationsMap">
      <?php echo do_shortcode('[mapplic id="6" h="970"]'); ?>
    </div>
  </section>
  <!-- END LOCATIONS -->

<?php } 



/***** CONTACT SECTION ******************************************************************/
function homepageContact($section) { ?>

  <!-- CONTACT -->
  <section id="homepageContact">
    <h2><?php echo $section['section_title']; ?></h2>
    <p class="sectionStatement"><?php echo $section['section_blurb']; ?></p>
    <div class="contactColumn">
<?php echo $section['contact_column_1']; ?>
    </div>
    <div class="contactColumn">
<?php echo $section['contact_column_2']; ?>
    </div>  
    <div class="contactColumn">
      <div class="contactForm">
<?php echo $section['contact_column_3']; ?>
<!-- Begin MailChimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
<style type="text/css">
	#mc_embed_signup form {
		padding: 0;		
	}
</style>
<div>
<form action="//smwllc.us3.list-manage.com/subscribe/post?u=28d34a9e4c1ffc599294e4e4d&amp;id=caa7a9940a" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
	<p><input type="text" value=""  id="mce-FNAME"name="FNAME" class="required" id="mce-FNAME" placeholder="First Name"></p>
	<p><input type="text" value="" id="mce-LNAME" name="LNAME" class="required" id="mce-LNAME" placeholder="Last Name"></p>
	<p><input type="text" value=""  id="mce-EMAIL"name="EMAIL" class="required email" id="mce-EMAIL" placeholder="E-mail Address"></p>
	<p><button type="submit" name="subscribe">Subscribe</button></p>
</form>
</div>
<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[0]='EMAIL';ftypes[0]='email';fnames[3]='MMERGE3';ftypes[3]='text';fnames[4]='DV_VAR_4';ftypes[4]='text';fnames[5]='DV_VAR_5';ftypes[5]='text';fnames[6]='DV_VAR_6';ftypes[6]='text';fnames[7]='DV_VAR_7';ftypes[7]='text';fnames[8]='DV_VAR_8';ftypes[8]='text';fnames[9]='DV_VAR_9';ftypes[9]='text';fnames[10]='DV_VAR_10';ftypes[10]='text';fnames[11]='DV_VAR_11';ftypes[11]='text';fnames[12]='MMERGE12';ftypes[12]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
<!--End mc_embed_signup-->
      <div class="svg-loader">
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
<style type="text/css">

</style>
<rect x="24" width="2" height="16" id="rect1"/>
<rect x="15.5" y="2.3" transform="matrix(0.866 -0.5 0.5 0.866 -2.9282 9.6269)" width="2" height="16" id="rect2"/>
<rect x="9.3" y="8.5" transform="matrix(0.5 -0.866 0.866 0.5 -9.1506 17.1506)" width="2" height="16" id="rect3"/>
<rect x="7" y="17" transform="matrix(4.547480e-11 -1 1 4.547480e-11 -17 33)" width="2" height="16" id="rect4"/>
<rect x="9.3" y="25.5" transform="matrix(-0.5 -0.866 0.866 -0.5 -13.5955 59.1506)" width="2" height="16" id="rect5"/>
<rect x="15.5" y="31.7" transform="matrix(-0.866 -0.5 0.5 -0.866 10.9282 82.3731)" width="2" height="16" id="rect6"/>
<rect x="24" y="34" transform="matrix(-1 -8.913061e-11 8.913061e-11 -1 50 84)" width="2" height="16" id="rect7"/>
<rect x="32.5" y="31.7" transform="matrix(-0.866 0.5 -0.5 -0.866 82.3731 57.3731)" width="2" height="16" id="rect8"/>
<rect x="38.7" y="25.5" transform="matrix(-0.5 0.866 -0.866 -0.5 88.5955 15.8494)" width="2" height="16" id="rect9"/>
<rect x="41" y="17" transform="matrix(-1.336959e-10 1 -1 -1.336959e-10 67 -17)" width="2" height="16" id="rect10"/>
<rect x="38.7" y="8.5" transform="matrix(0.5 0.866 -0.866 0.5 34.1506 -26.1506)" width="2" height="16" id="rect11"/>
<rect x="32.5" y="2.3" transform="matrix(0.866 0.5 -0.5 0.866 9.6269 -15.3731)" width="2" height="16" id="rect12"/>
</svg>
        </div>
      </div>
<?php
//  $fb = get_option('smw_fb');
//  $fbtext = get_option('smw_fbtext');
//  $tw = get_option('smw_tw');
//  $twtext = get_option('smw_twtext');
//  $li = get_option('smw_li');
//  $litext = get_option('smw_litext');
//  $in = get_option('smw_in');
//  $intext = get_option('smw_intext');
//  
//  if($fb != '' || $tw != '' || $li != '') {
//    echo "  <ul class=\"socailLinks\">\n";
//    if($fb != '') { echo "    <li><a href=\"$fb\" target=\"_blank\">".($fbtext != '' ? $fbtext : 'Facebook')."</a></li>\n"; }
//    if($tw != '') { echo "    <li><a href=\"$tw\" target=\"_blank\">".($twtext != '' ? $twtext : 'Twitter')."</a></li>\n"; }
//    if($in != '') { echo "    <li><a href=\"$in\" target=\"_blank\">".($intext != '' ? $intext : 'Instagram')."</a></li>\n"; }
//    if($li != '') { echo "    <li><a href=\"$li\" target=\"_blank\">".($litext != '' ? $litext : 'LinkedIn')."</a></li>\n"; }
//    echo "  </ul>\n";
//  }
?>
    </div>
  </section>
  <!-- END CONTACT -->

<?php } ?>