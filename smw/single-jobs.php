<?php get_header();
$ppp = get_option('page_for_posts');
$newschildren = get_children(array('post_parent' => $ppp));

$newslist = array();
$args = array(
  'posts_per_page'   => -1,
  'post_type' => 'jobs'
);
$all = get_posts($args);
foreach($all as $a) {
  $newslist[] = $a->ID;
}

if(have_posts()) : while(have_posts()) : the_post(); 

  $postcats = wp_get_post_categories($post->ID);
  $author = get_field('author');
  $authors = get_field('authors');
  $guestauthors = get_field('guest_authors');
  $leadership = get_field('leadership',$author->ID);
  $related = get_field('related_projects');
  $sidebar_image = get_field('sidebar_image');
  $photos = get_field('slideshow');
?>
<div id="newsWrapper">
<?php 
  $current = array_search($post->ID,$newslist);
  $next = $current < sizeof($newslist) - 1 ? $current + 1 : 0;
  $prev = $current > 0 ? $current - 1 : sizeof($newslist) - 1;
?>
  <article id="news-<?php echo $post->post_name; ?>">
    <section class="newsDetail">
      <div class="newsSectionContent">
        <h2><?php the_title(); ?></h2>
        <div class="newsSub">
        <ul class="newsInfo">
          <li><?php the_date('M d, Y'); ?></li>
        </ul>
        <nav class="newsNextPrev">
          <ul>
            <li><a href="<?php echo get_permalink($newslist[$prev]); ?>">Previous</a></li>
            <li><a href="<?php echo get_permalink($newslist[$next]); ?>">Next</a></li>
         </ul>
        </nav>
        </div>
        
      </div>
    </section>
    <section class="newsContent">
      <div class="newsSectionContent">
          <?php the_content(); ?>
          <?php if( get_field('columns') ): ?>
          	<?php if( have_rows('add_column') ): ?>
          		<?php $my_fields = get_field_object('add_column');
			  			$count = (count($my_fields['value'])); ?>
	          	<div class="usercolumns col-<?php echo $count; ?>">
	          		<?php while( have_rows('add_column') ): the_row(); 
						$content = get_sub_field('column');
					?>
						<div class="column">
							<?php echo $content; ?>
						</div>
					<?php endwhile; ?>
	          	</div>
			 <?php endif; ?>
			 	<?php the_field('following_content'); ?>
          <?php endif; ?>
          <div class="sharebox">
         	 <h3><strong>Share this job:</strong></h3>
	          <?php 
				$url = get_permalink($post->ID);
				$title = get_the_title($post->ID);
				echo do_shortcode('[easy-social-share buttons="facebook,twitter,linkedin,mail" counters=0 style="button" point_type="simple" url="'.$url.'" text="'.$title.'"]'); 
				?>  
          </div>
          
      </div>
    </section>
  </article>
</div>
<?php 
endwhile; endif; wp_reset_query();
get_footer(); ?>