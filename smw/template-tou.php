<?php
/* Template Name: Terms of Use */
get_header('anniversary');
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
    <h1 style="background-image: url('<?php echo get_option('smw_anniversary_logo'); ?>')"><a href="<?php echo get_home_url(); ?>"><span>SM&W 30 Years</span></a></h1>
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
    <div class="contentContainer">
<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
  <section id="<?php echo $post->post_name; ?>">
        <h2><?php the_title(); ?></h2>
<?php the_content(); ?>
  </section>
<?php
endwhile;
endif;
?>
  </div>
</div>

<?php get_footer('anniversary'); ?>