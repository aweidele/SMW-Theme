<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=10" />
<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico">

<title><?php 
  if (is_front_page()) { 
    echo get_bloginfo('name');
    if (get_bloginfo('description')!="") { echo " | ".get_bloginfo('description'); }
  } else {
    wp_title ( ' | ', true,'right' );
    echo get_bloginfo('name');
  } ?></title>
<?php wp_head(); ?>
<script src="https://use.typekit.net/ngd7xng.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>
</head>
<body <?php body_class(); ?>>
<div class="fixedTop">
  <nav id="topNav">
    <div class="topNavContainer">
      <ul>
<?php smw_nav('top-menu'); ?>
        <li><ul class="social">
          <li class="facebook"><a href="<?php echo get_option('smw_fb'); ?>" target="_blank"><span>Facebook</span></a></li>
          <li class="twitter"><a href="<?php echo get_option('smw_tw'); ?>" target="_blank"><span>Twitter</span></a></li>
          <li class="instagram"><a href="<?php echo get_option('smw_in'); ?>" target="_blank"><span>Instagram</span></a></li>
          <li class="linkedin"><a href="<?php echo get_option('smw_li'); ?>" target="_blank"><span>LinkedIn</span></a></li>
        </ul></li>
        <li class="search-box">
          <div class="search-form">
            <form role="search" method="get" id="searchform" class="searchform" action="<?php echo get_home_url(); ?>">
              <label class="screen-reader-text" for="s">Search for:</label>
              <input type="text" value="" name="s" id="s" placeholder="Search" />
              <button><span class="buttontext">Search</span><span class="icon-search"></span></button>
            </form>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <header>
    <div id="headerContent">
      <h1 style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/SMW-logo.svg');background-size:172px;"><a href="<?php echo get_home_url(); ?>"><span><?php echo get_bloginfo('name'); ?></span></a></h1>
      <button class="hamburgerMenu" data-menu="mobile-nav" id="hamburger-menu"><span>Menu</span></button>
      <nav id="main-nav">
        <ul>
			<?php smw_nav('primary-menu',$post->ID,true); ?>
        </ul>
      </nav>
      <?php $currentTemplate = get_page_template_slug($post->ID); 
      if($currentTemplate == "template-careers.php") {
      
        $my_wp_query = new WP_Query();
        $all_wp_pages = $my_wp_query->query(array('post_type' => 'page', 'posts_per_page' => -1, 'order' => 'ASC', 'orderby' => 'menu_order', 'post_parent' => $id));
        $childPages = get_page_children(get_the_ID(),$all_wp_pages);
      
?>
	<div class="navDropdownWrapper careersNav">
		<div class="navDropdownCenterer">
			<div class="navDropdown">      
				<ul>
					<li>
						<a href="#<?php echo $post->post_name; ?>"><?php echo $post->post_title; ?></a></li>
					<?php foreach($childPages as $page) { ?>
					    <li>
					    <a href="#<?php echo $page->post_name; ?>"><?php echo $page->post_title; ?></a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>

<?php } ?>
    </div>
  </header>
</div>
