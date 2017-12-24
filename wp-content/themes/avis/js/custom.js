var $j = jQuery.noConflict();
/* ---------------------------------------------------- */
/*	PARALLAX											*/
/* ---------------------------------------------------- */
jQuery.fn.parallax = function(xpos, speedFactor) {
'use strict';
var firstTop, methods = {};
return this.each(function(idx, value) {
var $this = jQuery(value), firstTop = $this.offset().top;
if (arguments.length < 1 || xpos === null)
xpos = "50%";
if (arguments.length < 2 || speedFactor === null)
speedFactor = 0.1;
methods = {
update: function() {
var pos = jQuery(window).scrollTop();
$this.each(function() {
$this.css('backgroundPosition', xpos + " " + Math.round((firstTop - pos) * speedFactor) + "px");
});
},
init: function() {
this.update();
jQuery(window).on('scroll', methods.update);
}
}
return methods.init();
});
};

jQuery(document).ready(function ($) {
	'use strict';
	jQuery('#about-section-box').parallax("center", 0.2);
});

//MOBILE MENU -----------------------------------------
//-----------------------------------------------------
jQuery(document).ready(function(){
	'use strict';
	jQuery('#menu-main').superfish();
	jQuery('#menu-main li.current-menu-item,#menu-main li.current_page_item,#menu-main li.current-menu-parent,#menu-main li.current-menu-ancestor,#menu-main li.current_page_ancestor').each(function(){
		jQuery(this).prepend('<span class="item_selected"></span>');
	});
});
jQuery(document).ready(function() {
	'use strict';
	jQuery('#menu-main li:has(ul)').each(function() {
		jQuery(this).addClass('has_child').append('<span class="this_child"></span>');
	});
	
	jQuery('#menu-main.avis-mob-menu li.menu-item-has-children .this_child').live('click', function(){
		if(jQuery(this).hasClass('active')){
			jQuery(this).removeClass('active');
			jQuery(this).prev('ul').stop(true,true).slideUp();
		}
		else{
			jQuery(this).addClass('active');
			jQuery(this).prev('ul').stop(true,true).slideDown();
		}
	});
});
(function( $ ) {
'use strict';
	$.fn.sktmobilemenu = function(options) { 
	var defaults = {
		'fwidth': 700
	};

		//call in the default otions
		var options = $.extend(defaults, options);
		var obj = $(this);
		return this.each(function() {
			if($(window).width() < options.fwidth) {
				sktMobileRes();
			}

			$(window).resize(function() {
				if($(window).width() < options.fwidth) {
					sktMobileRes();
				}
			});
			function sktMobileRes() {
				jQuery('#menu-main').superfish('destroy');
				obj.addClass('avis-mob-menu').hide();
				obj.parent().css('position','relative');
					if(obj.prev('.sktmenu-toggle').length === 0) {
						obj.before('<div class="sktmenu-toggle" id="responsive-nav-button"></div>');
					}
				obj.parent().find('.sktmenu-toggle').removeClass('active');
			}

			obj.parent().on('click','.sktmenu-toggle',function() {
				if(!$(this).hasClass('active')){
					$(this).addClass('active');
					$(this).next('ul').stop(true,true).slideDown();
				}
				else{
					$(this).removeClass('active');
					$(this).next('ul').stop(true,true).slideUp();
				}
			});
		});
};
})( jQuery );



jQuery(document).ready(function(){
	'use strict';
	jQuery( ".sf-with-ul" ).append( '<span class="caret"></span>' );
});

jQuery(window).load(function(){ 
	if(jQuery('#skenav .avis-mob-menu').length > 0){		
		jQuery('#skenav .avis-mob-menu').css('width',jQuery('.row-fluid').width());
	}
});


jQuery(window).load(function(){
	'use strict';
	
});

jQuery(document).ready(function ($) {
'use strict';
jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({
hook: 'data-rel',
animation_speed:'normal',
theme:'light_square',
slideshow:3000,
show_title:false,
autoplay_slideshow: false,
social_tools: false		
});
jQuery("a[rel^='prettyPhoto']").prettyPhoto({
animation_speed:'normal',
theme:'light_square',
slideshow:3000,
show_title:false,
autoplay_slideshow: false,
social_tools: false		
});
document.getElementById('s') && document.getElementById('s').focus();
});

/*===========================================================*/
/*	PORTFOLIO MASONRY SCRIPT
/*===========================================================*/	

var $container = jQuery('#container-isotop');

jQuery(window).load( function() {
	if(jQuery(window).width() > 1199) {
		$container.masonry({
			columnWidth: 380,
			itemSelector: '.item',
			gutter:5.5
		});
		$container.css({'visibility':'visible'});
	}
	if(jQuery(window).width() >= 1025 && jQuery(window).width() <= 1199) {
		$container.masonry({
			columnWidth: 380,
			itemSelector: '.item',
			gutter:5.5
		});
		$container.css({'visibility':'visible'});
	}
	if(jQuery(window).width() >= 767 && jQuery(window).width() <= 1024) {
		$container.masonry({
			columnWidth: 354,
			itemSelector: '.item',
			gutter:5.5
		});
		$container.css({'visibility':'visible'});
	}
	if(jQuery(window).width() >= 500 && jQuery(window).width() <= 766) {
		$container.masonry({
			columnWidth: 354,
			itemSelector: '.item',
			gutter:5.5
		});
		$container.css({'visibility':'visible'});
	}
	if(jQuery(window).width() < 500) {
		$container.masonry({
			columnWidth: 291,
			itemSelector: '.item',
			gutter:5.5
		});
		$container.css({'visibility':'visible'});
	}
});

jQuery(window).resize(function(){

	if(jQuery(window).width() > 1199) {
		$container.masonry({
			columnWidth: 370,
			itemSelector: '.item',
			gutter:5.5
		});
		$container.css({'visibility':'visible'});
	}
	if(jQuery(window).width() >= 1025 && jQuery(window).width() <= 1199) {
		$container.masonry({
			columnWidth: 326,
			itemSelector: '.item',
			gutter:5.5
		});
		$container.css({'visibility':'visible'});
	}
	if(jQuery(window).width() >= 767 && jQuery(window).width() <= 1024) {
		$container.masonry({
			columnWidth: 354,
			itemSelector: '.item',
			gutter:5.5
		});
		$container.css({'visibility':'visible'});
	}
	if(jQuery(window).width() >= 500 && jQuery(window).width() <= 766) {
		$container.masonry({
			columnWidth: 354,
			itemSelector: '.item',
			gutter:5.5
		});
		$container.css({'visibility':'visible'});
	}
	if(jQuery(window).width() < 500) {
		$container.masonry({
			columnWidth: 291,
			itemSelector: '.item',
			gutter:5.5
		});
		$container.css({'visibility':'visible'});
	}
});


//BACK TO TOP -----------------------------------------
//-----------------------------------------------------
jQuery(document).ready( function() {
'use strict';
jQuery('#back-to-top,#backtop').hide();
jQuery(window).scroll(function() {
if (jQuery(this).scrollTop() > 100) {
jQuery('#back-to-top,#backtop').fadeIn();
} else {
jQuery('#back-to-top,#backtop').fadeOut();
}
});
jQuery('#back-to-top,#backtop').click(function(){
jQuery('html, body').animate({scrollTop:0}, 'slow');
});
});
jQuery(window).load(function() {
'use strict';
var max = -1;
jQuery(".flexslider .slides li").each(function() {
var h = jQuery(this).height();
max = h > max ? h : max;
jQuery('.flexslider').css({'min-height': max});
});
});
jQuery(window).resize(function() {
'use strict';
var max = -1;
jQuery(".flexslider .slides li").each(function() {
var h = jQuery(this).height();
max = h > max ? h : max;
jQuery('.flexslider').css({'min-height': max});
});
});

//WAYPOINTS MAGIC -----------------------------------------
//---------------------------------------------------------
if ( typeof window['vc_waypoints'] !== 'function' ) {
	function vc_waypoints() {
	if (typeof jQuery.fn.waypoint !== 'undefined') {
		$j('.fade_in_hide').waypoint(function() {
				$j(this).addClass('avis_start_animation');
			}, { offset: '90%' });
			$j('.avis_animate_when_almost_visible').waypoint(function() {
				$j(this).addClass('avis_start_animation');
			}, { offset: '90%' });
		}
	}
}
jQuery(document).ready(function($) {
'use strict';
vc_waypoints();

jQuery('.avis-counter').waypoint(function() {

	var counter = jQuery(this).find('.avis-counter-number'),
		count = parseInt(counter.text(), 10),
		prefix = '',
		suffix = '',
		number = 0;

	if (jQuery(this).data('count')) {
		count = parseInt(jQuery(this).data('count'), 10);
	}
	if (jQuery(this).data('prefix')) {
		prefix = jQuery(this).data('prefix');
	}
	if (jQuery(this).data('suffix')) {
		suffix = jQuery(this).data('suffix');
	}

	var	step = Math.ceil(count/25),
	handler = setInterval(function() {
	number += step;
	counter.text(prefix+number+suffix);
		if (number >= count) {
			counter.text(prefix+count+suffix);
			window.clearInterval(handler);
		}
	}, 40);


 }, {offset:'85%', triggerOnce: true});
 }); 
//------------------------------------------------------------
 
jQuery(document).ready(function($) {
	'use strict';
	
	//SEARCH BOX
	jQuery('.search-strip, .hsearch .hsearch-close').click(function() {
		jQuery('.hsearch .row-fluid').toggle(500, "easeInQuad" );
		jQuery('body').toggleClass('overflowhide');
	});

	//Contact Map Overly
	var actualHt = jQuery("#map_canvas").height();
	jQuery('a#contact-gmap-toggle').on('click', function(){
		jQuery('#map_canvas .contact-map-overlay').toggle('slide', function(){jQuery('.gmap-close').fadeIn(1000);});
	});
	jQuery('.gmap-close').on('click', function(){
		jQuery('#map_canvas .contact-map-overlay').toggle('slide', function(){jQuery('.gmap-close').fadeOut('fast'); });
		 
	});

});

// jQuery for header flags

jQuery(document).ready(function($) {
	'use strict';
	jQuery('#header-top .dropdown-toggle').on('click', function(){
		jQuery('#header-top .dropdown-menu.langs').fadeToggle( "fast", "linear" );
	});
});

jQuery(document).ready(function($) {
	'use strict';
	jQuery( "#full-division-box a.medium-button" ).hover(
	  function() {
		jQuery('.action-button,.medium-button').addClass('call-hover');
	  }, function() {
		jQuery('.action-button,.medium-button').removeClass('call-hover');
	  }
	);
});
