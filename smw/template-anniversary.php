<?php
/* Template Name: Anniversary */
get_header('anniversary');


// get all the pages
$my_wp_query = new WP_Query();
$all_wp_pages = $my_wp_query->query(array('post_type' => 'page','orderby' => 'menu_order','order'=>'ASC','posts_per_page'=>-1));

// get the page childred
$children = get_page_children( $post->ID, $all_wp_pages );

?>

<div class="fixedTop">
  <nav id="externalNav">
    <ul>
      <li class="navHome"><a href="http://www.smwllc.com/index.php">smwllc.com</a></li>
      <li class="facebook"><a href="https://www.facebook.com/shen.milsom.wilke.llc/" target="_blank"><span>Facebook</span></a></li>
      <li class="twitter"><a href="https://twitter.com/shenmilsomwilke" target="_blank"><span>Twitter</span></a></li>
      <li class="linkedin"><a href="https://www.linkedin.com/company/shen-milsom-&-wilke" target="_blank"><span>LinkedIn</span></a></li>
    </ul>
  </nav>
  <header>
    <h1 style="background-image: url('<?php echo get_option('smw_anniversary_logo'); ?>')"><a href="#<?php echo $children[0]->post_name; ?>"><span>SM&W 30 Years</span></a></h1>
    <h2><?php echo get_option('smw_anniv_tagline'); ?></h2>
  </header>
  <label for="mobileMenuToggle" id="mobileMenuToggleButton"><span>Menu</span></label>
  <input type="checkbox" id="mobileMenuToggle">
  <nav id="internalNav">
    <div class="internalNavContainer">
      <ul>
<?php foreach($children as $i => $child) { ?>
        <li<?php if($i==0) { echo ' class="active"'; } ?>><a href="#<?php echo $child->post_name; ?>"><?php echo $child->post_title; ?></a></li>
<?php } ?>
      </ul>
    </div>
  </nav>
</div>
<div id="mainContent">
<?php foreach($children as $i => $child) {
  $type = get_field('secondary_content',$child->ID);
  if($type == 'video' || $type == 'gallery') {
?>

  <section id="<?php echo $child->post_name; ?>">
    <div class="contentContainer">
      <div class="col1">
        <h2><?php 
          $section_header = get_field('section_header',$child->ID);
          if($section_header != '' ) {
            echo $section_header;
          } else {
            echo $child->post_title;
          }
        ?></h2>
        <?php echo wpautop($child->post_content); ?>
<?php /*
        <ul class="share">
          <li class="facebook"><a href=""><span>Facebook</span></a></li>
          <li class="twitter"><a href=""><span>Twitter</span></a></li>
          <li class="linkedin"><a href=""><span>LinkedIn</span></a></li>
        </ul>
*/ ?>
      </div>
      <div class="col2">
<?php if($type == 'gallery') {
  $gallery = get_field('gallery',$child->ID);
?>

        <div class="slideshowContainer">
          <div class="slideshowSlides">
            <ul>
<?php foreach($gallery as $i=>$slide) { ?>
              <li<?php if($i==0) { echo ' class="active"'; } ?> id="slide_<?php echo $i; ?>">
                <img src="<?php echo $slide['sizes']['Anniversary Slideshow']; ?>">
                <span class="caption"><span><?php echo $slide['caption']; ?></span></span>
              </li>
<?php } ?>
            </ul>
            <div class="spacer"><img src="<?php echo $slide['sizes']['Anniversary Slideshow']; ?>"></div>
            <div class="controls">
              <p class="prev"><a href="#"><span>Previous</span></a></p>
              <p class="next"><a href="#"><span>Next</span></a></p>
            </div>
          </div>
          <ul class="slideThumbs">
<?php foreach($gallery as $i=>$slide) { ?>
            <li><a href="#slide_<?php echo $i; ?>" title="<?php echo $slide['caption']; ?>"><img src="<?php echo $slide['sizes']['Anniversary Slideshow Thumb']; ?>"></a></li>
<?php } ?>
          </ul>
        </div>

<?php } else if($type == 'video') { 
  $video = get_field('video',$child->ID);
?>
        <div class="oEmbedWrapper"><?php echo $video; ?></div>
        
<?php } ?>
      </div>
    </div>
  </section>
<?php } else { ?>
  <section id="<?php echo $child->post_name; ?>" class="share">
<?php if(isset($_GET['submitted']) && $_GET['submitted'] == true) { ?>
    <div class="contentContainer">
      <h2>Thank you for your submission.</h2>
    </div>
<?php } else { ?>
  <form action="<?php echo get_stylesheet_directory_uri(); ?>/action.php" method="POST" id="shareForm">
  <input type="hidden" name="action" value="share">
  <input type="hidden" name="redirect" value="<?php echo get_permalink($post->ID); ?>">
  <input type="hidden" name="section" value="<?php echo $child->post_name; ?>">
  <input type="hidden" name="to" value="<?php echo get_option('smw_email'); ?>">
    <div class="contentContainer">
      <h2>Share in the Celebration</h2>
      <p class="intro">Share your favorite Shen Milsom & Wilke memory:
      <div class="shareForm">
        <div class="contactFields">
          <p><label for="shareName">Full Name</label>
            <input id="shareName" name="full_name" type="text" placeholder="Enter Name"></p>
          <p><label for="shareEmail">Email</label>
            <input id="shareEmail" name="email" type="email" placeholder="Enter Email"></p>
          <p><label for="shareCompany">Company</label>
            <input id="shareCompany" name="company" type="text" placeholder="Enter Company"></p>
        </div>
        <div class="contactMessage">
          <p><label for="shareMessage">Message</label>
            <textarea placeholder="Enter your message" id="shareMessage" name="message"></textarea></p>
          <p class="checkbox">
            <input type="checkbox" id="agree">
            <label for="agree"><span>I agree with the SM&W <a href="<?php echo get_permalink(55); ?>" target="_blank">Terms of Use.</a></span></label>
          </p>
          <p class="submitButton"><button>Submit</button></p>
        </div>
    </div>
    </div>
  </form>
<?php } ?>
  </section>

<?php }} ?>
</div>
<?php get_footer('anniversary'); ?>
