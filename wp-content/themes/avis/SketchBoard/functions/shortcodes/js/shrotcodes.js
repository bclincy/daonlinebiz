/* ---------------------------------------------------------------------------
 * NUMBERPROGRESSBAR JQUERY FUNCTION
* --------------------------------------------------------------------------- */

(function($) {
  var NumberProgressBar = function(element, options) {
	var settings = $.extend ({
	  duration: 8000,
	  style: 'basic',
	  min: 0,
	  max: 100,
	  current: 0,
	  shownQuery: '.avis-number-pb-shown',
	  numQuery: '.avis-number-pb-num'
	}, options || {});

	this.duration = settings.duration;
	if (settings.style == 'percentage') {
	  this.style = 'percentage';
	  this.min   = 0;
	  this.max   = 100;
	}  
	this.current = (settings.current >= this.min && settings.current <= this.max) ? settings.current : this.min;
	this.interval = this.max - this.min;
	this.last = this.min;
	this.$element = $(element);
	this.$shownBar = this.$element.find(settings.shownQuery);
	this.$num = this.$element.find(settings.numQuery);

	this.reach(this.current);
  }

  NumberProgressBar.prototype.calDestination = function(dest) {
	return (dest < this.min) ? this.min : ( (dest > this.max) ? this.max : dest )
  }

  NumberProgressBar.prototype.calDuration = function() {
	return this.duration * Math.abs(this.current - this.last) / this.interval;
  }

  NumberProgressBar.prototype.shuffle = function(callback) {
	var dest = Math.round(Math.random() * this.interval) + this.min;
	this.reach(dest, null, callback);
  }

  NumberProgressBar.prototype.calPercentage = function() {
	return (this.current - this.min) / this.interval * 100
  }

  NumberProgressBar.prototype.numStyle = function(num) {
	var n = Math.ceil(num);
	var s = "";
	switch (this.style) {
	  case 'percentage': s = n + '%';			break;
	  case 'step'	  : s = n + '/' + this.max; break;
	  default		  : s = n;
	}
	return s;
  }

  NumberProgressBar.prototype.reach = function(dest, duration, callback) {
	this.current = this.calDestination(dest);
	this.moveShown(duration);
	this.moveNum(duration, callback);
	this.last = this.current;
  }

  NumberProgressBar.prototype.moveShown = function(duration) {
	this.$shownBar.velocity({
	  width: this.calPercentage() + '%'
	}, {
	  duration: duration || this.calDuration()
	})
  }

  NumberProgressBar.prototype.moveNum = function(duration, callback) {
	var self = this;
	var duration = duration || this.calDuration();

	this.$num.velocity({
	  left: (this.calPercentage()) + '%'
	}, {
	  duration: duration,
	  complete: callback
	});

	// number
	$({num: this.last}).animate({
	  num: this.current
	}, {
	  queue: true,
	  duration: duration,
	  step: function() {
		self.$num.text(self.numStyle(this.num));
	  },
	  complete: function() {
		self.$num.text(self.numStyle(self.current));
	  }
	})
  }

  $.fn.NumberProgressBar = function(options) {
	return this.each(function () {
	  var element = $(this);
	  if (element.data('avis-number-pb')) return;
	  element.data('avis-number-pb', new NumberProgressBar(this, options));
	})
  }

  $.fn.reach = function(dest, options) {
	var settings = $.extend ({
	  duration : null,
	  complete : null
	}, options || {});
	return this.each(function() {
	  var element = $(this);
	  var progressbar = element.data('avis-number-pb');
	  if (!progressbar) return;
	  if (typeof dest === "undefined") {
		progressbar.shuffle(settings.complete);
	  } else {
		progressbar.reach(dest, settings.duration, settings.complete);
	  }
	})
  }

})(jQuery);


jQuery(document).ready(function() {
	jQuery(".success .close-notification").click(function() {
		jQuery(".success.canhide").fadeOut("slow")
	});
	jQuery(".fail .close-notification").click(function() {
		jQuery(".fail.canhide").fadeOut("slow")
	});
	jQuery(".info .close-notification").click(function() {
		jQuery(".info.canhide").fadeOut("slow")
	});
	jQuery(".warning .close-notification").click(function() {
		jQuery(".warning.canhide").fadeOut("slow")
	});
	jQuery(".download .close-notification").click(function() {
		jQuery(".download.canhide").fadeOut("slow")
	});
	jQuery(".chat .close-notification").click(function() {
		jQuery(".chat.canhide").fadeOut("slow")
	});
	jQuery(".task .close-notification").click(function() {
		jQuery(".task.canhide").fadeOut("slow")
	})
});

jQuery(document).ready(function() {
	jQuery(".tooltip").tipTip();
});

jQuery(document).ready(function() {
	jQuery("#back-to-top,#backtop").hide();
	jQuery(window).scroll(function() {
		if (jQuery(this).scrollTop() > 100) {
			jQuery("#back-to-top,#backtop").fadeIn()
		} else {
			jQuery("#back-to-top,#backtop").fadeOut()
		}
	});
	jQuery("#back-to-top,#backtop").click(function() {
		jQuery("html, body").animate({
			scrollTop: 0
		}, "slow")
	})
});

(function(e) {
	e.fn.avis_accordian = function(t) {
		var n = {
			autoplay: 1,
			hoverpause: 1,
			itemno: "3",
			effect: 2,
			tspeed: "100",
			tdelay: "3000",
			togacc: 1
		};
		var t = e.extend(n, t);
		var r = e(this);
		var i = r.find("div.avis_acc_title");
		var s = r.find("div.avis_acc_content");
		var o = i.eq(t.itemno - 1);
		var u = s.eq(t.itemno - 1);
		var a = i.length;
		var f = t.itemno - 1;
		var l, c;
		var h;
		return this.each(function() {
			o.addClass("active").show();
			u.show();
			i.click(function(r) {
				if (t.togacc) {
					if (jQuery(this).hasClass("active")) {
						jQuery(this).removeClass("active");
						switch (t.effect) {
							case 1:
							case "fade":
								e(this).next("div.avis_acc_content").fadeOut(t.tspeed);
								break;
							case 2:
							case "slide":
								e(this).next("div.avis_acc_content").slideUp(t.tspeed);
								break
						}
					} else {
						jQuery(this).addClass("active");
						switch (t.effect) {
							case 1:
							case "fade":
								e(this).next("div.avis_acc_content").fadeIn(t.tspeed);
								break;
							case 2:
							case "slide":
								e(this).next("div.avis_acc_content").slideDown(t.tspeed);
								break
						}
					}
				} else {
					if (!jQuery(this).hasClass("active")) {
						i.removeClass("active");
						e(this).addClass("active");
						if (t.autoplay) {
							c = jQuery(this).index();
							if (c == 0) f = 0;
							else f = c / 2;
							if (!t.hoverpause) {
								clearInterval(h);
								setTimeout(n, 0)
							}
						}
						switch (t.effect) {
							case 1:
							case "fade":
								s.fadeOut(t.tspeed);
								e(this).next("div.avis_acc_content").fadeIn(t.tspeed);
								break;
							case 2:
							case "slide":
								s.slideUp(t.tspeed);
								e(this).next("div.avis_acc_content").slideDown(t.tspeed);
								break
						}
					}
				}
				return false
			});
			if (a > 1 && t.autoplay && !t.togacc) {
				function n() {
					h = setInterval(function() {
						switch (t.effect) {
							case 1:
							case "fade":
								i.eq(f).removeClass("active");
								s.eq(f).fadeOut(t.tspeed);
								f = f + 1 == a ? 0 : f + 1;
								i.eq(f).addClass("active");
								s.eq(f).fadeIn(t.tspeed);
								break;
							case 2:
							case "slide":
								i.eq(f).removeClass("active");
								s.eq(f).slideUp(t.tspeed);
								f = f + 1 == a ? 0 : f + 1;
								i.eq(f).addClass("active");
								s.eq(f).slideDown(t.tspeed);
								break
						}
					}, t.tdelay)
				}
				n();
				if (t.hoverpause) {
					r.hover(function() {
						clearInterval(h)
					}, function() {
						setTimeout(n, 0)
					})
				}
			}
		})
	}
})(jQuery);

//sketchtab jQuery Function

(function( $ ){
  $.fn.avis_tab= function( options ) { 
	var defaults = {
		'orient' : 'h',   // set orientation for tab structure horizontal/vertical (h/v).
		'itemno' : '1',   // set which item will be displayed by default (1,2,3,4,....).
		'effect' :  1,	// set transition effect 1-fade,2-slide.
		'tspeed' : '500'  // set transition speed
	};

	// Declare All Required Vb's

	var options = $.extend(defaults, options);
	var obj = $(this);
	var ske_tab_item = obj.find("ul.avis_tabs li");
	var ske_tab_content = obj.find(".avis_tab_content");
	var ske_tab_item_first = ske_tab_item.eq(options.itemno-1);
	var ske_tab_content_first = ske_tab_content.eq(options.itemno-1);

	// Return Function Output

	return this.each(function() {
		if(options.orient == "h"){obj.addClass('avis_tab_h');} //check orientation and add .ske_tab_h class 
		else if(options.orient == "v"){obj.addClass('avis_tab_v clearfix');} //check orientation and add .ske_tab_v class 
		ske_tab_content.hide(); //Hide all content
		ske_tab_item_first.addClass("active").show(); //Activate first tab
		ske_tab_content_first.show(); //Show first tab content
		//On Click Event

		ske_tab_item.click(function() {

			ske_tab_item.removeClass("active"); //Remove any "active" class
			$(this).addClass("active"); //Add "active" class to selected tab
			ske_tab_content.hide(); //Hide all tab content
			var k = $(this).index(); //get the tab item index
			var ske_wdth = ske_tab_content.width();
			switch(options.effect)
			{
				case 1: case 'fade':	// Fade
					ske_tab_content.eq(k).fadeIn(options.tspeed); //fade in the active content
					break;
				case 2: case 'slide':   // Slide
					ske_tab_content.eq(k).animate({'left':-ske_wdth},0).show().animate({'left':'0'},options.tspeed); //slide in the active content
					break;
			}
			return false;
		}); 
	});
  };
})( jQuery );
(function(e) {
	e.fn.avis_toggle = function(t) {
		var n = {
			state: "open",
			effect: 1,
			tspeed: "100"
		};
		var t = e.extend(n, t);
		var r = e(this);
		var i = r.find("h3.avis_tog_title");
		var s = r.find("div.avis_tog_content");
		return this.each(function() {
			if (t.state == "open") i.addClass("active");
			else if (t.state == "close") s.hide();
			i.click(function() {
				if (jQuery(this).hasClass("active")) {
					jQuery(this).removeClass("active");
					switch (t.effect) {
						case 1:
						case "fade":
							s.fadeOut(t.tspeed);
							break;
						case 2:
						case "slide":
							s.slideUp(t.tspeed);
							break
					}
				} else {
					switch (t.effect) {
						case 1:
						case "fade":
							s.fadeIn(t.tspeed);
							break;
						case 2:
						case "slide":
							s.slideDown(t.tspeed);
							break
					}
					jQuery(this).addClass("active")
				}
				return false
			})
		})
	}
})(jQuery)

