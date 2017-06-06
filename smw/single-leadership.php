<?php get_header(); 
$biolist = array();
$args = array(
  'posts_per_page'   => -1,
  'post_type' => 'leadership',
  'cat' => 453
);
$all = get_posts($args);
foreach($all as $a) {
  $biolist[] = $a->ID;
}
?>
<div id="leadershipWrapper">
<?php if(have_posts()): while(have_posts()): the_post(); 
$originalId = $post->ID;
$phone = get_field('phone');
$email = get_field('email');
$linkedin = get_field('linkedin');
?>
  <section class="leadershipBio">
    <div class="leadershipLeft">
      <div class="leadershipCard">
        <a href="<?php echo get_permalink(); ?>" class="popupModal">
          <p class="leadershipPortrait"><img src="<?php echo get_the_post_thumbnail_url($post->post_quote_attribute->ID,'Leadership Thumb'); ?>"></p>
          <p><strong><?php echo $post->post_title; ?></strong></p>
          <p><?php echo get_field('title'); ?></p>
        </a>
<?php if($phone != '') { ?>
        <p><a href="tel:<?php echo $phone; ?>"><?php echo str_replace('-',' ',$phone); ?></a></p>
<?php } ?>
        <ul class="leadershipContact">
<?php if($email != '') { ?>
          <li class="email"><a href="mailto:<?php echo $email; ?>"><span><?php echo $email; ?></span></a></li>
<?php } if($linkedin != '') {?>
          <li class="linkedin"><a href="<?php echo $linkedin; ?>" target="_blank"><span><?php echo $linkedin; ?></span></a></li>
<?php } ?>
        </ul>
      </div>
    </div>
    <div class="leadershipCopy">
<?php the_content(); ?>
    </div>
    <div class="leadershipNextPrev">
<?php
  $current = array_search($post->ID,$biolist);
  $next = $current < sizeof($biolist) - 1 ? $current + 1 : 0;
  $prev = $current > 0 ? $current - 1 : sizeof($biolist) - 1;
?>
      <ul>
        <li><a href="<?php echo get_permalink($biolist[$prev]); ?>">Previous</a></li>
        <li><a href="<?php echo get_permalink($biolist[$next]); ?>">Next</a></li>
      </ul>
    </div>
  </section>
<?php endwhile; endif; wp_reset_query(); ?>
  <section class="leadershipList">
    <h3>Our Leadership</h3>
    <div class="leadershipCards">
<?php
  $args = array(
    'post_type'=>'ourpeople',
    'posts_per_page' => -1,
    'cat' => 453
  );
  $leadership = new WP_Query($args);
  if($leadership->have_posts()): while($leadership->have_posts()) : $leadership->the_post();
    // Write our one next/previous cause wordpress's is needlessly complicated 
    if( $firstPost == null ) {
    	$firstPost = $post;
    }
    if( !$found ) {
    	if( $post->ID == $originalId ) {
    		$found = true;
    		$previousPost = $currentPost;
    	}
    } else if( $nextPost == null ) {
    	$nextPost = $post;
    }
    $currentPost = $post;
  ?>

          <div class="leadershipCard">
            <a href="<?php echo get_permalink(); ?>">
              <p class="leadershipPortrait"><img src="<?php echo get_the_post_thumbnail_url($post->post_quote_attribute->ID,'Leadership Thumb'); ?>"></p>
              <p><strong><?php echo $post->post_title; ?></strong></p>
              <p><?php echo get_field('title'); ?></p>
            </a>

          </div>

<?php endwhile;endif; wp_reset_query(); ?>
   </div>
 </section>
</div>
<?php get_footer(); ?>