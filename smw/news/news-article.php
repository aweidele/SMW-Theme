<?php
	
    global $post;
	$url = get_permalink($article->ID);
	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($article->ID),$imgsize);
	
    $postcats = wp_get_post_categories($article->ID);
    $cats = array();
    foreach($postcats as $c) {
      $cat = get_category($c);
      $cats[] = $cat->name;
    }
    $author = get_field('author');
    $meta = get_post_meta($post->ID);
    
    $gridItem = 'grid-item';
    
    if( $imgsize == 'Grid Slideshow Large' ) {
    	$gridItem .= ' grid-item--width2';
    }
	
	if( isset($firstItem) && $firstItem ) {
		$gridItem .= ' first-grid-item';	
	}
	
?>
  <article class="<?=$gridItem ?> newsTile<?php if($tweet) { echo ' tweet'; } ?>" id="tile-<?php echo $article->post_name; ?>">
<?php if(!$tweet) { ?>
      <a href="<?php echo $url; ?>"><img src="<?php echo $thumb[0]; ?>">
      <div class="overlay">
        <div class="overlayContainer">
          <p class="category"><?php echo implode(',',$cats); ?></p>
          <h3><?php echo $article->post_title; ?></h3>
        </div>
      </div>
      </a>
    <div class="share"><div class="share-buttons-wrap"><div class="share-buttons"><?php
    // Plugin doesn't provide a great API
    global $post;
    $original = $post;
    $post = $article;
    $essb = ESSBCore::get_instance();
    echo $essb->generate_share_buttons('bottom', 'share', array('only_share' => true));
    $post = $original;
    ?></div></div></div>
<?php } else { ?>
      <a href="<?php echo get_option('smw_tw'); ?>" target="_blank">
    <div class="tweetContainer">
      <div class="tweetContent">
          <p class="category">@shenmilsomwilke</p>
          <h3><?php echo $article->post_content; ?></h3>
      </div>
    </div>
      </a>
<?php } ?>
  </article>
