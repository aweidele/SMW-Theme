<?php 
  
?>
<footer>
  <div id="footerContent">
    <nav id="footerNav">
      <ul>
<?php smw_nav('footer-menu'); ?>
        <li><ul class="social">
          <li class="facebook"><a href="<?php echo get_option('smw_fb'); ?>" target="_blank"><span>Facebook</span></a></li>
          <li class="twitter"><a href="<?php echo get_option('smw_tw'); ?>" target="_blank"><span>Twitter</span></a></li>
        <li class="instagram"><a href="<?php echo get_option('smw_in'); ?>" target="_blank"><span>Instagram</span></a></li>
          <li class="linkedin"><a href="<?php echo get_option('smw_li'); ?>" target="_blank"><span>LinkedIn</span></a></li>
        </ul></li>
      </ul>
    </nav>
    <ul class="copyInfo">
      <li>&copy; <?php echo date('Y').' '.get_option('smw_copyright'); ?></li>
    </ul>
  </div>
</footer>

<nav id="mobile-nav">
      <ul>
<?php smw_nav('primary-menu',$post->ID,true,true); ?>
<?php smw_nav('top-menu-mobile',$post->ID,true,true); ?>
      </ul>
</nav>
<div id="feedback">feedback</div>
<?php wp_footer();
 ?>

<style type="text/css">
body.single { margin-bottom: 0 !important; }
</style>

</body>
</html>