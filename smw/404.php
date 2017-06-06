<?php get_header(); ?>
<div id="newsWrapper">
  <div class="newsDetail">
    <div class="container404">
      <h1>404 Error</h1>
      <p>Sorry, the page you were looking for could not be found.</p>
      <p><a href="<?php echo get_home_url(); ?>">Return to Home ></a></p>
      
      <div class="filter-search search404">
        <form role="search" method="get" id="searchform" class="searchform" action="http://staging.smwllc.flywheelsites.com/">
          <label class="screen-reader-text" for="s">Search for:</label>
          <input type="text" value="" name="s" id="s" placeholder="Search" />
          <button><span class="buttontext">Search</span><span class="icon-search"></span></button>
        </form>
      </div>

    </div>
  </div>
</div>
<?php get_footer(); ?>