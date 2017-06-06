var $ = jQuery;
$(document).ready(function() { 

  if($('.slideshowContainer').length) {
    $slideSpeed = 3000 + 1000;
    slideshowGo();
  }
  
  $("a[href*=#]").click(function(e) {
    e.preventDefault();
    href = $(this).prop('href');
    hash = href.substr(href.indexOf('#'));
    $("html, body").animate({
      scrollTop: $(hash).offset().top - $(".fixedTop").height()
    },500);
  });
  
  $(".internalNavContainer a").click(function(e) {
    $("#mobileMenuToggle").prop('checked', false);
  });
  
  $("#shareForm").submit(function(e) {
    if($('#shareForm input[name="full_name"]').val() == '' || $('#shareForm input[name="email"]').val() == '' || $('#shareForm textarea[name="message"]').val() == '') {
      e.preventDefault();
      alert('Please complete the required fields.');
    } else if (!$("#agree").prop('checked')) {
      e.preventDefault();
      alert('Please accept the Terms of Use');
    }
  });
  
  window_resize();
  $(window).resize(function() {
    window_resize();
  });
  
  $(window).scroll(function() {
    s = $(window).scrollTop();
    t = s + $('.fixedTop').height();

    active = 0;
    $.each($startpoints,function(i,v) {
      if(t >= v) {
        active = i;
      }
    });

    if(s >= ($dh-$h)) { active = $startpoints.length - 1; }

    $("#internalNav li").removeClass('active');
    $("#internalNav li:eq("+active+")").addClass('active');
    $('#feedback').html(s+'/'+t+'<br>'+active+'<br>'+$h+' - '+$dh+' = '+($dh-$h));
  });

});

$(window).load(function() {
  window_resize();
});

function slideshowGo() {
  if($('.slideshowSlides li').length > 1) {
    $slide = 0;
    $t = setTimeout(function() { slideshowNext(0); },$slideSpeed);
    $('.slideshowSlides a').on('click',function(e) {
      e.preventDefault();
      clearTimeout($t);
      c = $(this).parents('p').attr('class');
      if(c=='prev') {
        $slide -= 2;
      }
      slideshowNext();
    });
    $('.slideThumbs a').on('click',function(e) {
      e.preventDefault();
      clearTimeout($t);
      $slide = $(this).parent().index();
      $('.slideshowSlides li').removeClass('active');
      $('.slideshowSlides li:eq('+$slide+')').addClass('active');
      $t = setTimeout(function() { slideshowNext(); },$slideSpeed);
    });
  }
}

function slideshowNext() {
  numSlides = $('.slideshowSlides li').length - 1;
  $slide++;
  if($slide > numSlides) {
    $slide = 0;
  }
  if($slide < 0) { $slide = numSlides; }
  console.log($slide);
  $('.slideshowSlides li').removeClass('active');
  $('.slideshowSlides li:eq('+$slide+')').addClass('active');
  $t = setTimeout(function() { slideshowNext(); },$slideSpeed);
}

function window_resize() {
  console.log('window_resize()');
  $h = $(window).height();
  $dh = $(document).height();
  
  $startpoints = new Array();
  $("#mainContent section").each(function() {
    $startpoints.push( Math.floor($(this).offset().top) );
  });
  console.log($startpoints);
}