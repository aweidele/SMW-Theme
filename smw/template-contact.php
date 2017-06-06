<?php
/* Template Name: Contact */
get_header();
?>
<div id="locationsWrapper">
  <section class="contactMap">
      <?php echo do_shortcode('[mapplic id="6" h="940"]'); ?>
<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
    <div class="contactMainWrapper"><div class="contactMain"><div class="contactMainContent">
    <?php 
    	the_content(); 
    	smw_subscribe_shortcode();
    ?>

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

    </div></div></div>
<?php endwhile; endif; wp_reset_query(); ?>
  </section>
</div>
<?php get_footer(); ?>