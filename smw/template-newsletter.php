<?php
/* Template Name: Newsletter */
get_header();

$ppp = get_option('page_for_posts');
$newschildren = get_children(array('post_parent' => $ppp));

?>
<div id="newsWrapper">
<?php if(have_posts()): while(have_posts()): the_post(); ?>
  <section id="newsletter">
    <div class="pageSectionContent">
      <div class="pageSectionCopy">
        <?php the_content(); ?>
      </div>
      <div class="pageSectionRight">
      <style type="text/css">
		<!--
		.display_archive {font-family: arial,verdana; font-size: 12px;}
		.campaign {line-height: 125%; margin: 5px;}
		//-->
      </style>
	  <script language="javascript" src="//smwllc.us3.list-manage.com/generate-js/?u=28d34a9e4c1ffc599294e4e4d&fid=1&show=10" type="text/javascript"></script>
<?php
$args = array(
  'post_type' => 'newsletter',
  'posts_per_page' => 1
);
$newsletter = new WP_Query($args);
if($newsletter->have_posts()) : while($newsletter->have_posts()) : $newsletter->the_post();
 // the_content();
endwhile; endif; wp_reset_query(); ?>
      </div>
    </div>
  </section>
<?php endwhile; endif; wp_reset_query(); ?>
</div>
<?php get_footer(); ?>