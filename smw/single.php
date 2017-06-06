<?php get_header();
$ppp = get_option('page_for_posts');
$newschildren = get_children(array('post_parent' => $ppp));

$newslist = array();
$args = array(
  'posts_per_page'   => -1,
  'post_type' => 'post'
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
  $related_news = get_field('related_news_knowledge');
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
          <li>
            <ul>
<?php foreach($postcats as $c) { 
  $cat = get_category($c);
?>
              <li><?php echo '<a href="'.get_category_link( $c ).'">'.$cat->name.'</a>'; ?></li>
<?php } ?>
            </ul>
          </li>
          <li><?php the_date('M d, Y'); ?></li>
        </ul>
        <nav class="newsNextPrev">
          <ul>
            <li><a href="<?php echo get_permalink($newslist[$prev]); ?>">Previous</a></li>
            <li><a href="<?php echo get_permalink($newslist[$next]); ?>">Next</a></li>
         </ul>
        </nav>
        </div>
        <?php if ( $photos ): ?>
        	 <?php $ssid = uniqid(); ?>
        	<div class="slideshowContainer <?= sizeof($photos) > 1 ? 'hasPhotos' : '' ?>" id="slideshow-<?php echo $ssid; ?>">
	            <div class="slideshowSlider">
					<?php foreach($photos as $key => $photo) { ?>
					              <div class="slide <?php if($key==0) { echo ' active'; } ?>" style="background-image:url('<?php echo $photo['sizes']['Large Slideshow']; ?>');" >
					              	<img src="<?php echo $photo['sizes']['Large Slideshow']; ?>">
					              </div>
					<?php } ?>
					            </div>
					<?php if(sizeof($photos) > 1) { ?>
					            <div class="slideshowControls">
					              <ul class="prevNext" data-slideshow="slideshow-<?php echo $ssid; ?>">
					                <li><span>Previous</span></li>
					                <li><span>Next</span></li>
					              </ul>
					              <ul class="slideshowIndicators" data-slideshow="slideshow-<?php echo $ssid; ?>">
					<?php foreach($photos as $i => $photo) { ?>
					                <li<?php if($i==0) { echo ' class="active"'; } ?>><span><?php echo $i; ?></span></li>
					<?php } ?>
					              </ul>
					            </div>
					<?php } ?>
	          </div>
        	
        <?php else: ?>
        	<div class="featureImage"><img src="<?php echo get_the_post_thumbnail_url($post->ID,'Large Slideshow'); ?>"></div>
        <?php endif; ?>
        
      </div>
    </section>
    <section class="newsContent">
<?php if(is_object($author) || is_array($authors) || is_array($guestauthors) || is_array($sidebar_image)) { ?>
      <div class="newsCopy">
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
			 	<div class="additionalcontent">
			 		<?php the_field('following_content'); ?>
			 	</div>
          <?php endif; ?>
      </div>
      <div class="newsAuthor">
          <?php if(is_array($sidebar_image)) { ?>
          	<?php $images = get_field('sidebar_image'); if( $images ): ?>
          		<?php foreach( $images as $image ): ?>
		  			<p class="sidebarPhoto"><img src="<?php echo $image['sizes']['Project Quote Photo']; ?>"></p>
		  		<?php endforeach; ?>
		  	<?php endif; ?>
          <?php } ?>
<?php if(is_array($authors)) { ?>
          <h3>Author<?php if(sizeof($authors > 2)) { echo 's'; } ?></h3>
<?php foreach($authors as $author) { ?>
          <div class="leadershipCard">
            <a href="<?php echo get_permalink($author->ID); ?>">
              <p class="leadershipPortrait"><img src="<?php echo get_the_post_thumbnail_url($author->ID,'Leadership Thumb'); ?>"></p>
              <p><strong><?php echo $author->post_title; ?></strong></p>
              <p><?php echo get_field('title',$author->ID); ?></p>
            </a>
            <p><a href="tel:<?php echo get_field('phone',$author->ID); ?>">+<?php echo str_replace('-',' ',get_field('phone',$author->ID)); ?></a></p>
            <ul class="leadershipContact">
              <li class="email"><a href="mailto:<?php echo get_field('email',$author->ID); ?>"><span><?php echo get_field('email',$author->ID); ?></span></a></li>
              <li class="linkedin"><a href="<?php echo get_field('linkedin',$author->ID); ?>" target="_blank"><span><?php echo get_field('linkedin',$author->ID); ?></span></a></li>
            </ul>
          </div>
<?php } ?>

<?php if( have_rows('guest_authors') ): ?>
	<h3>Guest Author</h3>
	<?php while( have_rows('guest_authors') ): the_row(); 
		// vars
		$image = get_sub_field('guest_author_image');
		$name = get_sub_field('guest_author_name');
		$title = get_sub_field('guest_author_title');
		$company = get_sub_field('company');
	?>
		<div class="leadershipCard">
			<p class="leadershipPortrait"><img src="<?php echo $image; ?>" /></p>
			<p><strong><?php echo $name; ?></strong></p>
			<p><?php echo $title; ?></p>
			<p><?php echo $company; ?></p>
		</div>
	<?php endwhile; ?>
<?php endif; ?>

<?php } else if(is_object($author)) { ?>
          <h3>Author</h3>
          <div class="leadershipCard">
            <a href="<?php echo get_permalink($author->ID); ?>">
              <p class="leadershipPortrait"><img src="<?php echo get_the_post_thumbnail_url($author->ID,'Leadership Thumb'); ?>"></p>
              <p><strong><?php echo $author->post_title; ?></strong></p>
              <p><?php echo get_field('title',$author->ID); ?></p>
            </a>
            <p><a href="tel:<?php echo get_field('phone',$author->ID); ?>">+<?php echo str_replace('-',' ',get_field('phone',$author->ID)); ?></a></p>
            <ul class="leadershipContact">
              <li class="email"><a href="mailto:<?php echo get_field('email',$author->ID); ?>"><span><?php echo get_field('email',$author->ID); ?></span></a></li>
              <li class="linkedin"><a href="<?php echo get_field('linkedin',$author->ID); ?>" target="_blank"><span><?php echo get_field('linkedin',$author->ID); ?></span></a></li>
            </ul>
          </div>
         <?php if( have_rows('guest_authors') ): ?>
			<h3>Guest Author</h3>
			<?php while( have_rows('guest_authors') ): the_row(); 
				// vars
				$image = get_sub_field('guest_author_image');
				$name = get_sub_field('guest_author_name');
				$title = get_sub_field('guest_author_title');
				$company = get_sub_field('company');
			?>
				<div class="leadershipCard">
					<p class="leadershipPortrait"><img src="<?php echo $image; ?>" /></p>
					<p><strong><?php echo $name; ?></strong></p>
					<p><?php echo $title; ?></p>
					<p><?php echo $company; ?></p>
				</div>
			<?php endwhile; ?>
		<?php endif; ?>
<?php } else if(is_array($guestauthors)) { ?>
	 <?php if( have_rows('guest_authors') ): 
		 $rows = get_field('guest_authors');
		 $count = count($rows);
		 if ( $count > 1 ) { ?>
		 	<h3>Guest Authors</h3>
		 <?php } else { ?>
		 	<h3>Guest Author</h3>
		 <?php } ?>
			
			<?php while( have_rows('guest_authors') ): the_row(); 
				// vars
				$image = get_sub_field('guest_author_image');
				$name = get_sub_field('guest_author_name');
				$title = get_sub_field('guest_author_title');
				$company = get_sub_field('company');
			?>
				<div class="leadershipCard">
					<p class="leadershipPortrait"><img src="<?php echo $image; ?>" /></p>
					<p><strong><?php echo $name; ?></strong></p>
					<p><?php echo $title; ?></p>
					<p><?php echo $company; ?></p>
				</div>
			<?php endwhile; ?>
		<?php endif; ?>
<?php } ?>
      </div>
<?php } else { ?>
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
			 	<div class="additionalcontent">
			 		<?php the_field('following_content'); ?>
			 	</div>
          <?php endif; ?>
      </div>
<?php } ?>
    </section>
  </article>
<?php if(is_array($related)) { ?>
  <section class="newsRelated">
    <h3>Related Projects</h3>
    <div class="newsRelatedList">
<?php foreach($related as $r) { 
  $ssid = uniqid();
  $photos = get_field('photos',$r->ID); ?>

        <article class="project" id="<?php echo $r->post_name; ?>">
          <div class="slideshowContainer <?= sizeof($photos) > 1 ? 'hasPhotos' : '' ?>" id="slideshow-<?php echo $ssid; ?>">
            <a href="<?php echo get_permalink($r->ID); ?>">
            <div class="slideshowSlider">
<?php foreach($photos as $key=>$photo) { ?>
              <div class="slide<?php if($key==0) { echo ' active'; } ?>" style="background-image:url(<?php echo $photo['sizes']['Grid Slideshow Small']; ?>);">
              	<img src="<?php echo $photo['sizes']['Grid Slideshow Small']; ?>">
              </div>
<?php } ?>
            </div>
            </a>
            <div class="slideshowOverlay">
              <div class="slideshowOverlayContainer"><h4><a href="<?php echo get_permalink($r->ID); ?>"><?php echo $r->post_title; ?></a></h4></div>
            </div>
<?php if(sizeof($photos) > 1) { ?>
            <div class="slideshowControls">
              <ul class="prevNext" data-slideshow="slideshow-<?php echo $ssid; ?>">
                <li><span>Previous</span></li>
                <li><span>Next</span></li>
              </ul>
              <ul class="slideshowIndicators" data-slideshow="slideshow-<?php echo $ssid; ?>">
<?php for($i=0;$i>sizeof($photos);$i++) { ?>
                <li<?php if($i==0) { echo ' class="active"'; } ?>><span><?php echo $i; ?></span></li>
<?php } ?>
              </ul>
            </div>
<?php } ?>
          </div>
        </article>

<?php } ?>
    </div>
  </section>
<?php } ?>

<?php if(is_array($related_news)) { ?>
  <section class="singleProjectRelated">
    <div class="relatedProjects">
      <h3>Related News &amp; Knowledge</h3>
      <div>
 <?php
      $imgsize = "Grid Slideshow Small"; 
	  foreach($related_news as $i => $article) { 
        include( TEMPLATEPATH."/news/news-article.php");
	  }
?>
      </div>
    </div>
  </section>
<?php } ?>

</div>
<?php 
endwhile; endif; wp_reset_query();
get_footer(); ?>