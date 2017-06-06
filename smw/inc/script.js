var $ = jQuery;
$(document).ready(function() {

  if($("#homepageVideo").length) { homepageVideo(); }
  if($("a[data-action='leadership']").length) { leadershipPopup(); }
  if($('.tiled').length) { tiledGo(); }
  if($('.jobsList').length) { jobsAccordion(); }
  
  windowResize();
  $(window).resize(function() { windowResize(); });
  
  $(".current_page .navDropdown a[href^='#'],.careersNav a[href^='#']").click(function(e) {
    e.preventDefault();
    h = $(this).attr('href');
    o = $(h).offset().top - $('.fixedTop').height();

    if($w > 800) {
      if( $("body.page-template-template-services").length ) { s = 50; } else { s = 0; }
      o -= $('.current_page .navDropdownWrapper').height() + s;
    } else {
      //o -= ($("#mobile-nav .current_page .navDropdown a[href^='#'],#mobile-nav .careersNav a[href^='#']").index(this) - 1) * 20 - 92;
      // Something needs to be done here, can't figure it out.
    }
    
    $('html, body').animate({
      scrollTop: o
    }, 500);
  });
  
  $("body.single-services #headerContent li.services-menu").addClass("current_page");
  

  if($("#homepageVideo .scrolldown").length) {
    $("#homepageVideo .scrolldown").on("click",function(e) {
      e.preventDefault();
      n = $(this).parents('section').next();
      o = $(n).offset().top  - $('.fixedTop').height() ;
      $('html, body').animate({
        scrollTop: o
      }, 500);
    });
  }
  
  $(window).scroll(function() {
    windowScroll();
  });

 


  if(window.location.hash) {
    $('html, body').scrollTop(0);
  }
  
  if($('#subscribe-form').length) {
    $('#subscribe-form').on('submit',function(e) {
      e.preventDefault();
      a = $(this).attr('action');
      fname = $('input[name="FNAME"]',this).val();
      lname = $('input[name="LNAME"]',this).val();
      email = $('input[name="EMAIL"]',this).val();
      
      data = $(this).serialize();

      console.log(data);

      p = $(this).parent();
      
      e = 0;
      eMessage = "";
      if(fname == "") { e+=1; eMessage += e+". Please enter your first name.\n"; }
      if(lname == "") { e+=1; eMessage += e+". Please enter your last name.\n"; }
      if(email == "") { e+=1; eMessage += e+". Please enter your email address.\n"; }
      
      if(e > 0) {
        alert(eMessage);
      } else {
      $(this).fadeOut(250,function() {
        $('.svg-loader',p).fadeIn(250,function() {


          $.ajax({
            url:a,
            method:'post',
            data:data
          }).done(function(msg) {
            window.setTimeout(function() {
              p.append('<div class="subscribe-greeting"><p>'+msg.greeting+'</p></div>');
              $('.subscribe-greeting',p).hide();
              $('.svg-loader',p).fadeOut(250,function() {
                $('.subscribe-greeting',p).fadeIn(500);
              });
            },250);
          }).fail(function(xhr, textStatus, errorThrown) {
            console.log( "error" );
            console.log(xhr);
            console.log(textStatus);
            console.log(errorThrown);
          }).always(function() {
          });

        });
      });
      }
    });
  }

  $('.hamburgerMenu').on('click',function(e) {
    e.preventDefault();
    t = '#'+$(this).data('menu');
    $(t).toggleClass('open');
    $("html").toggleClass('mobile-nav-open');
  });
  
  $('#mobile-nav a[href*=#]').on('click',function() {
    $('#mobile-nav').removeClass('open');
    $("html").removeClass('mobile-nav-open');
  });

  if($('.filters').length) {
    $('.filters > li').on('click',function(e) {
      //e.preventDefault();
      if($('.filterDropdown',this).hasClass('open')) {
        $('.filterDropdown').removeClass('open');
      } else {
        $('.filterDropdown').removeClass('open');
        $('.filterDropdown',this).addClass('open');
      }
    });
  }
  
  $('#mobile-nav button').on('click',function(e) {
    e.preventDefault();
    if($(this).next('.navDropdownWrapper').hasClass('dropdown-open')) {
      $(this).next('.navDropdownWrapper').removeClass('dropdown-open');
    } else {
      $('#mobile-nav .navDropdownWrapper').removeClass('dropdown-open');
      $(this).next('.navDropdownWrapper').addClass('dropdown-open');
    }
  });
  	function removeClick() {
		jQuery(".share.show").removeClass("show");
		jQuery(".share-buttons.visible").removeClass("visible").stop().slideUp(250);
  	}
  	
  	jQuery(".share").on("click.newsShare", function(e){
  		e.stopPropagation();
  		
  		var $this = jQuery(this);
  		var $buttons = $this.find(".share-buttons");
		var hasClass = $buttons.hasClass("visible")   		
		
		removeClick();
  		if( !hasClass ) {
  			$buttons.stop().addClass("visible").slideDown(500);
  			$this.addClass("show");
  		}
  	});
  	
  	jQuery(document).on("click.newsShare", removeClick);
});
// $(document).ready

$(window).load(function() {
  windowResize() ;
  if( $('.slideshowContainer').length ) { slideshowInit(); }

  if(window.location.hash) {
    h = window.location.hash;
    o = $(h).offset().top - $('.fixedTop').height();

    if($w > 800) {
      if( $("body.page-template-template-services").length ) { s = 50; } else { s = 0; }
      o -= $('.current_page .navDropdownWrapper').height() + s;
    } else {
      //o -= ($("#mobile-nav .current_page .navDropdown a[href^='#'],#mobile-nav .careersNav a[href^='#']").index(this) - 1) * 20 - 92;
      // Something needs to be done here, can't figure it out.
    }
    
    $('html, body').animate({
      scrollTop: o
    }, 500);
  }

});

function windowScroll() {
  s = $(window).scrollTop();
  if(s > 10) {
    $('.navDropdownWrapper.locations').addClass('addwhite');
  } else {
    $('.navDropdownWrapper.locations').removeClass('addwhite');
  }
}

function windowResize() {
  $w = $(window).width();
  $('#feedback').html($w);
}

function slideshowInit() {
  $slideshows = {};
  $('.slideshowContainer').each(function() {
    ssid = $(this).prop('id');
    total = $('.slideshowSlider .slide',this).length;
    $slideshows[ssid] = {id: ssid, total: total, current: 0, count: 0};
  }).on('swipeleft',slideshowSwipe);

  $('.slideshowControls .prevNext li').on('click',function() {
    dir = $(this).index() ? 1 : -1;
    ssid = $(this).parent().data('slideshow');
    slideshowNexPrev(ssid,dir);
  });
  $('.slideshowControls .slideshowIndicators li').on('click',function() {
    ssid = $(this).parent().data('slideshow');
    current = $(this).index();
    slideshowJumpto(ssid,current);
  });
}

function slideshowNexPrev(ssid,dir) {
  $slideshows[ssid].count += dir;
  $slideshows[ssid].current += dir;
  if($slideshows[ssid].current < 0) { $slideshows[ssid].current = $slideshows[ssid].total - 1; }
  if($slideshows[ssid].current >= $slideshows[ssid].total) { $slideshows[ssid].current = 0; }
  slideshowAdvance(ssid);
}

function slideshowJumpto(ssid,current) {
//  if(current > $slideshows[ssid].current) {
    $slideshows[ssid].count++;
//  } else {
//    $slideshows[ssid].count--;
//  }
  $slideshows[ssid].current = current;
  slideshowAdvance(ssid);
}

function slideshowAdvance(ssid) {
  count = $slideshows[ssid].count;
  current = $slideshows[ssid].current;
  left = (count * -100) + '%';
  right = (count * 100) + '%';
  
  $('#'+ssid+' .slideshowSlider').css({left:left,right:right});
  $('#'+ssid+' .slideshowSlider .slide:eq('+current+')').css({left:right});
  $('#'+ssid+' .slideshowIndicators li').removeClass('active');
  $('#'+ssid+' .slideshowIndicators li:eq('+current+')').addClass('active');
  if($('#'+ssid+' .slideshowSlideTitles').length) {
    console.log('yes?');
    $('#'+ssid+' .slideshowSlideTitles h3').removeClass('active');
    $('#'+ssid+' .slideshowSlideTitles h3:eq('+current+')').addClass('active');
  }
}

function slideshowSwipe(e) {
  p = findAncestor(e.target,'slideshowContainer');
  ssid = p.id;
  slideshowNexPrev(ssid,1);
}

function findAncestor (el, cls) {
    while ((el = el.parentElement) && !el.classList.contains(cls));
    return el;
}

function homepageVideo() {
  $("#homepageVideo video").hide();
  
//   $(".contentLayer .jumplink a").on("click",function(e) {
//     e.preventDefault();
//     h = $(this).prop("href");
//     o = $(h).offset().top - $(".fixedTop").height();
//     $("body,html").animate({ scrollTop: o },500);
//   });
  
  $(window).load(function() {
    $("#homepageVideo video").fadeIn(500);
    $vw = $("#homepageVideo video").width();
    $vh = $("#homepageVideo video").height();
    $vr = $vh / $vw;
    
//     $(window).resize(function() { videoResize(); });
//     videoResize();
    
  });
}

function leadershipPopup() {
  $("body").append('<aside id="leadershipPopup"><div class="leadershipPopupContainer"><div class="leadershipPopupContent"></div><div class="leadershipPopupClose"><button><span>Close</span></button></div></div></aside>');
  $("a[data-action='leadership']").on('click',function(e) {
    if($(window).width() > 686) { 
      e.preventDefault();
      h = $(this).prop('href') + ' .leadershipBio';
      //o = $(this).parents('section').offset().top;
      o = $(this).offset().top - 51;
      $('#leadershipPopup .leadershipPopupContent').load(h,function() {
        $('#leadershipPopup').fadeOut(250,function() { $(this).css({ top:o }).fadeIn(250); });
      });
    }
  });
  $(".leadershipPopupClose button").on('click',function(e) {
    e.preventDefault();
    $('#leadershipPopup').fadeOut(250);
  });
}

function tiledGo() {
  $('.tiled').addClass('go');
  $(window).on('load resize',function() { tiledResize(); });
  tiledResize();
}

function tiledResize() {
  
  // DETERMINE NUMBER OF COLUMNS
  smallest = Infinity;
  largest = 0;
  container = $('.tile').parent().width();
  $('.tiled .tile').each(function() {
    w = $(this).width();
    if(w < smallest) { smallest = w; }
    if(w > largest) { largest = w; }
  });
  numcols = Math.round(container / smallest);

  columns = new Array(); 
  for(i=0;i<numcols;i++) {
    columns.push(0);
  }
  
  gutter = (container - (smallest * numcols)) / (numcols - 1); /* the space between columns */
  colwidth = gutter + smallest;
  
  // ASSIGN TILE TO CORRECT SPACE
  $('.tiled .tile').each(function() {
    w = $(this).width();
    h = $(this).height() + 30;
    s = Infinity;
    
    if(w > smallest) {
      l = numcols - 1;
    } else {
      l = numcols;
    }
    
    for(i=0;i<l;i++) {
      if(columns[i] < s) {
        scol = i;
        s = columns[i];
      }
    }
    
    $(this).css({ 
      left: scol * colwidth,
      top: columns[scol]
    });
    columns[scol] += h;
    if(w > smallest) {
      columns[scol + 1] += h;
    }
    
  });
  
  tallest = 0;
  for(i=0;i<numcols;i++) {
    if(columns[i] > tallest) {
      tallest = columns[i];
    }
  }
  
  $('.tile').parent().height(tallest);
  console.log(columns); 
}

function jobsAccordion() {
  $('.jobsList').addClass('init');
  $('.jobs-accordion h4').on('click',function() {
    $(this).toggleClass('active').next('.jobsDetail').slideToggle(250);
  });
  $('.collapse-accordion').on('click',function() { 
    $(this).parents('.jobsDetail').slideUp(250).siblings('h4').removeClass('active'); 
  });
}


/*
 * Link up group page menu to scroll and update URL
 */
function subPageMenuLink(mainContentId) {
	//
	// Save aside the height of the fixed header.
	//
	var $mainContent = $("#" + mainContentId); 
	var headerSize = parseInt($mainContent.css("margin-top"));
	var $footer = $("footer");
	var $menu = $("li.current_page .navDropdown ul");
	var linkOffsets = [];
			
	//
	// Grab all grouped pages
	//
	var $pages = $mainContent.find("section");
	
	//
	// Private function to make sure the bottom section is always 1 full window in height
	// otherwise the menu will never trigger the section as current.
	//
	function autoHeightLast()
	{
		$pages.last().css("min-height", $(window).height() - headerSize - $footer.outerHeight() - parseInt($footer.css("margin-top")));
	}
	
	//
	// Call auto height before doing any special scrolling
	//
	autoHeightLast();
	
	//
	// Make sure we reset the last section's height on resize
	//
	$(window).resize(autoHeightLast);
	
	//
	// Process the menu looking for matching pages.
	//
	$menu.find("a").each(function(){
		var targetId = null;
		var $link = $(this);
		
		//
		// Find the page that matches the current menu item iteration.
		//
		$pages.each(function(){
			var $this = $(this);
			
			if( "#" + $this.attr("id") == $link.attr("href") ) {
				targetId = $this.attr("id");
				return false;
			}
		});
		
		//
		// If a linking section was found
		//
		if( targetId != null )
		{
			var $target = $("#"+targetId);

			//
			// Store in offsets list for changing menu highlights on scroll
			//
			linkOffsets.push({menu: $link, target: $target});
		}
	});
	
	//
	// Bind the window scroll to process position and highlight
	// the visible "page".
	//
	function checkScroll(){
		//
		// Determine how far we've scrolled, plus a buffer
		//
		var offsetTop = $(window).scrollTop() + headerSize + 40;
		//
		// Default to the first item if something is off
		//
		var previous = null;
		for (var i = 0; i < linkOffsets.length; i++)
		{
			var item = linkOffsets[i];
			//
			// Is the current item we're checking past the scroll point?
			// If so, the currently selected item was the last section we
			// processed.
			//
			if( item.target.offset().top > offsetTop ) {
				break;
			}
			
			//
			// Save aside for next loop.
			//
			previous = item.menu;
		}
		
		//
		// If the section found was not already selected
		//
		if( previous == null )
		{
			//
			// Remove highlight from the currently selected
			//
			var $previousMenu = $menu.find('.current-sub-page'); 
			$previousMenu.removeClass('current-sub-page');
		}
		else
		if( !previous.hasClass('current-sub-page') )
		{
			//
			// Remove highlight from the currently selected
			//
			var $previousMenu = $menu.find('.current-sub-page'); 
			$previousMenu.removeClass('current-sub-page');
			//
			// Add highlight to our class
			//
			previous.parent().addClass('current-sub-page');
		}
	}
	
	$(window).scroll(checkScroll);
	checkScroll();
	
	return this;	
};

jQuery(document).ready(function($) {
	var i = 1;

	while (window['mapplic' + i] !== undefined) {
		var params = window['mapplic' + i];
		var selector = '#mapplic' + i;
		ajaxurl = params.ajaxurl;

		$(selector).mapplic({
			'id': params.id,
			'height': params.height,
			'deeplinking': 0			
		});

		i++;
	}
});