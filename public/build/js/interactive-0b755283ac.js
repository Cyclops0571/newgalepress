/*! http://mths.be/placeholder v2.1.0 by @mathias */
(function(factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD
		define(['jquery'], factory);
	} else {
		// Browser globals
		factory(jQuery);
	}
}(function($) {

	// Opera Mini v7 doesn’t support placeholder although its DOM seems to indicate so
	var isOperaMini = Object.prototype.toString.call(window.operamini) == '[object OperaMini]';
	var isInputSupported = 'placeholder' in document.createElement('input') && !isOperaMini;
	var isTextareaSupported = 'placeholder' in document.createElement('textarea') && !isOperaMini;
	var valHooks = $.valHooks;
	var propHooks = $.propHooks;
	var hooks;
	var placeholder;

	if (isInputSupported && isTextareaSupported) {

		placeholder = $.fn.placeholder = function() {
			return this;
		};

		placeholder.input = placeholder.textarea = true;

	} else {

		var settings = {};

		placeholder = $.fn.placeholder = function(options) {

			var defaults = {customClass: 'placeholder'};
			settings = $.extend({}, defaults, options);

			var $this = this;
			$this
				.filter((isInputSupported ? 'textarea' : ':input') + '[placeholder]')
				.not('.'+settings.customClass)
				.bind({
					'focus.placeholder': clearPlaceholder,
					'blur.placeholder': setPlaceholder
				})
				.data('placeholder-enabled', true)
				.trigger('blur.placeholder');
			return $this;
		};

		placeholder.input = isInputSupported;
		placeholder.textarea = isTextareaSupported;

		hooks = {
			'get': function(element) {
				var $element = $(element);

				var $passwordInput = $element.data('placeholder-password');
				if ($passwordInput) {
					return $passwordInput[0].value;
				}

				return $element.data('placeholder-enabled') && $element.hasClass('placeholder') ? '' : element.value;
			},
			'set': function(element, value) {
				var $element = $(element);

				var $passwordInput = $element.data('placeholder-password');
				if ($passwordInput) {
					return $passwordInput[0].value = value;
				}

				if (!$element.data('placeholder-enabled')) {
					return element.value = value;
				}
				if (value === '') {
					element.value = value;
					// Issue #56: Setting the placeholder causes problems if the element continues to have focus.
					if (element != safeActiveElement()) {
						// We can't use `triggerHandler` here because of dummy text/password inputs :(
						setPlaceholder.call(element);
					}
				} else if ($element.hasClass(settings.customClass)) {
					clearPlaceholder.call(element, true, value) || (element.value = value);
				} else {
					element.value = value;
				}
				// `set` can not return `undefined`; see http://jsapi.info/jquery/1.7.1/val#L2363
				return $element;
			}
		};

		if (!isInputSupported) {
			valHooks.input = hooks;
			propHooks.value = hooks;
		}
		if (!isTextareaSupported) {
			valHooks.textarea = hooks;
			propHooks.value = hooks;
		}

		$(function() {
			// Look for forms
			$(document).delegate('form', 'submit.placeholder', function() {
				// Clear the placeholder values so they don't get submitted
				var $inputs = $('.'+settings.customClass, this).each(clearPlaceholder);
				setTimeout(function() {
					$inputs.each(setPlaceholder);
				}, 10);
			});
		});

		// Clear placeholder values upon page reload
		$(window).bind('beforeunload.placeholder', function() {
			$('.'+settings.customClass).each(function() {
				this.value = '';
			});
		});

	}

	function args(elem) {
		// Return an object of element attributes
		var newAttrs = {};
		var rinlinejQuery = /^jQuery\d+$/;
		$.each(elem.attributes, function(i, attr) {
			if (attr.specified && !rinlinejQuery.test(attr.name)) {
				newAttrs[attr.name] = attr.value;
			}
		});
		return newAttrs;
	}

	function clearPlaceholder(event, value) {
		var input = this;
		var $input = $(input);
		if (input.value == $input.attr('placeholder') && $input.hasClass(settings.customClass)) {
			if ($input.data('placeholder-password')) {
				$input = $input.hide().nextAll('input[type="password"]:first').show().attr('id', $input.removeAttr('id').data('placeholder-id'));
				// If `clearPlaceholder` was called from `$.valHooks.input.set`
				if (event === true) {
					return $input[0].value = value;
				}
				$input.focus();
			} else {
				input.value = '';
				$input.removeClass(settings.customClass);
				input == safeActiveElement() && input.select();
			}
		}
	}

	function setPlaceholder() {
		var $replacement;
		var input = this;
		var $input = $(input);
		var id = this.id;
		if (input.value === '') {
			if (input.type === 'password') {
				if (!$input.data('placeholder-textinput')) {
					try {
						$replacement = $input.clone().attr({ 'type': 'text' });
					} catch(e) {
						$replacement = $('<input>').attr($.extend(args(this), { 'type': 'text' }));
					}
					$replacement
						.removeAttr('name')
						.data({
							'placeholder-password': $input,
							'placeholder-id': id
						})
						.bind('focus.placeholder', clearPlaceholder);
					$input
						.data({
							'placeholder-textinput': $replacement,
							'placeholder-id': id
						})
						.before($replacement);
				}
				$input = $input.removeAttr('id').hide().prevAll('input[type="text"]:first').attr('id', id).show();
				// Note: `$input[0] != input` now!
			}
			$input.addClass(settings.customClass);
			$input[0].value = $input.attr('placeholder');
		} else {
			$input.removeClass(settings.customClass);
		}
	}

	function safeActiveElement() {
		// Avoid IE9 `document.activeElement` of death
		// https://github.com/mathiasbynens/jquery-placeholder/pull/99
		try {
			return document.activeElement;
		} catch (exception) {}
	}

}));

(function() {
function Equalizer() {
}

var klass = Equalizer.prototype;
var self = Equalizer;
SCF.Equalizer = Equalizer;

self.init = function() {
    self.bindEvents();
};

self.bindEvents = function() {
    $(self.bar).each(function() {
        // Get a default value for all bars
        var scaleInitialHeight = $(this).find(self.scale).height();

        // Slider mechanics
        $(this).slider({
            slide: function(event, ui){
                var scaleHeight = ui.value;

                $(this).find(self.scale).css({
                    'height': scaleHeight
                });
            },
            max: 114,
            orientation: 'vertical',
            value: scaleInitialHeight
        });
    });
};

// vars
self.element = ".equalizer";
self.bar = self.element + " .equalizer-bar";
self.scale = ".equalizer-scale";

}());

(function() {
function Appreciate() {
}

var klass = Appreciate.prototype;
var self = Appreciate;
SCF.Appreciate = Appreciate;

self.init = function() {
    self.bindEvents();
};

self.bindEvents = function() {
    $(self.element).click(function() {
        $(this).toggleClass("tnx");
    });
}

// vars
self.element = ".appreciate";

}());

(function () {
    function Commutator() {
    }

    var klass = Commutator.prototype;
    var self = Commutator;
    SCF.Commutator = Commutator;

    self.init = function () {
	self.bindEvents();
    };

    self.bindEvents = function () {
	$(self.element).mousedown(function () {
	    if ($(this).hasClass("off")) {
		$(this).removeClass("off").addClass("on");
	    } else {
		$(this).addClass("off").removeClass("on");
	    }
	});
    };

// vars
    self.element = ".commutator";

}());

(function() {
function Datepicker() {
}

var klass = Datepicker.prototype;
var self = Datepicker;
SCF.Datepicker = Datepicker;

self.init = function() {
    self.bindEvents();
};

self.bindEvents = function() {
    $(self.element).datepicker({
        showButtonPanel: true,
        minDate: -20,
        maxDate: "+1M +10D",
        dayNamesMin: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        firstDay: 1
    });
};

// vars
self.element = ".datepicker-placeholder";

}());

(function() {
function Pagination() {
}

var klass = Pagination.prototype;
var self = Pagination;
SCF.Pagination = Pagination;

self.init = function() {
    self.bindEvents();
};

self.bindEvents = function() {
    $(self.paginationLink).click(function() {
        $(this).siblings().removeClass("active");
        $(this).addClass("active");
    });
}

// vars
self.element = ".pagination";
self.paginationLink = self.element + " li";

}());

(function() {
function Scrollbox() {
}

var klass = Scrollbox.prototype;
var self = Scrollbox;
SCF.Scrollbox = Scrollbox;

self.init = function() {
    self.bindEvents();
};

self.bindEvents = function() {
    $(self.element).each(function() {
        // Get a default value for all bars
        var scaleInitialWidth = $(this).find(self.scale).width();
        var scrollboxWidth = $(this).find(self.hitbox).width();
		var maxPercentage = 200;
		
        // Slider mechanics
        $(this).find(self.hitbox).slider({
            slide: function(event, ui){
				
                var scaleWidth = ui.value;
				var percentage = scaleWidth / scrollboxWidth * maxPercentage;
				
                $(this).next(self.scale).css({
                    'width': scaleWidth
                });
				
				$(this).nextAll(self.value).html(percentage.toFixed(0) + '%');
            },
            max: scrollboxWidth,
            value: scaleInitialWidth
        });
    });
};

// vars
self.element = ".js-scrollbox";
self.scale = ".scale";
self.hitbox = ".hitbox";
self.value = ".value";

}());

(function() {
function Slideshow(element) {
    this.element     = element;
    this.slides      = this.element + " .js-slideshow-slides";
    this.slide       = this.element + " .js-slideshow-slide";
    this.nextSlide   = this.element + " .js-slideshow-next-slide";
    this.prevSlide   = this.element + " .js-slideshow-prev-slide";
    this.slidesCount = $(this.slide).size();
    this.slideWidth  = $(this.slide).width();
    this.slidesWidth = this.slideWidth * this.slidesCount;
}

var klass = Slideshow.prototype;
var self = Slideshow;
SCF.Slideshow = Slideshow;

klass.init = function() {
    this.setSlidesWidth();
    this.bindEvents();
};

klass.bindEvents = function() {
    var _this = this;

    $(this.nextSlide).click(function() {
        _this.showNextSlide();
    });

    $(this.prevSlide).click(function() {
        _this.showPrevSlide();
    });
}

klass.setSlidesWidth = function() {
    $(this.slides).width(this.slidesWidth);
}

klass.showNextSlide = function() {
    var _this = this;
    var currentSlidesPosition = $(this.slides).position().left;
    var slideShiftWidth       = currentSlidesPosition - this.slideWidth;
    var lastSlidePosition     = (1 - this.slidesCount) * this.slideWidth;

    $(this.slides).css("left", slideShiftWidth);

    if (currentSlidesPosition <= lastSlidePosition) {
        $(_this.slides).css("left", 0);
    }
};

klass.showPrevSlide = function() {
    var _this = this;
    var currentSlidesPosition = $(this.slides).position().left;
    var slideShiftWidth       = currentSlidesPosition + this.slideWidth;
    var firstSlidePosition    = this.slideWidth - this.slidesWidth;

    $(this.slides).css("left", (slideShiftWidth));

    if (currentSlidesPosition >= 0) {
        $(_this.slides).css("left", firstSlidePosition);
    }
};

}());

(function() {
function Tabbox(element) {
    this.element = element;
    this.tabboxStuff = this.element + " .tabbox-stuff";
    this.tabboxTabs = this.element + " .tabbox-tabs";
    this.tabboxTab = this.tabboxTabs + " li";
    this.activeTabIndex = null;
}

var klass = Tabbox.prototype;
var self = Tabbox;
SCF.Tabbox = Tabbox;

klass.init = function() {
    this.storeActiveTabIndex();
    this.openCorrectTabContent();
    this.bindEvents();
};

klass.bindEvents = function() {
    var _this = this;

    $(this.tabboxTab).click(function() {
        _this.switchTabs(this);
    });
};

klass.openCorrectTabContent = function() {
    $(this.tabboxStuff).addClass("hidden");
    $(this.tabboxStuff).eq(this.activeTabIndex).removeClass("hidden");
};

klass.storeActiveTabIndex = function() {
    var _this = this;

    $(this.tabboxTab).each(function(index) {
        if ($(this).hasClass("active")) {
            _this.activeTabIndex = index;
        }
    });
};

klass.switchTabs = function(tab) {
    $(this.tabboxTab).removeClass("active");
    $(tab).addClass("active");
    this.storeActiveTabIndex();
    this.openCorrectTabContent();
}

}());

(function() {
function Starbar(element, rating) {
    this.element = element;
    this.rating = rating;
    this.star = this.element + " .star";
}

var klass = Starbar.prototype;
var self = Starbar;
SCF.Starbar = Starbar;

klass.init = function() {
    this.setDefaultRating();
    this.bindEvents();
};

klass.bindEvents = function() {
    var _this = this;

    $(this.star).hover(function() {
        _this.fillRatingUntil(this);
    }, function() {
        _this.setDefaultRating();
    });

    $(this.star).click(function() {
        $(_this.star).unbind();
    });
};

klass.setDefaultRating = function() {
    var last = $(this.star).eq(this.rating - 1);
    this.clearRating();
    this.fillRatingUntil(last);
};

klass.clearRating = function() {
    $(this.star).removeClass("full focus");
};

klass.fillRatingUntil = function(star) {
    this.clearRating();
    $(star).addClass("full focus");
    $(star).prevAll().addClass("full focus");
};

}());

(function() {
function Checkbox(element) {
    this.element = element;
}

var klass = Checkbox.prototype;
var self = Checkbox;
SCF.Checkbox = Checkbox;

klass.init = function() {
    this.bindEvents();
};

klass.bindEvents = function() {
    var _this = this;

    $(this.element).click(function() {

        $(this).toggleClass("checked");
		
		if($(this).children("input[type='hidden']").length > 0)
		{
			$(this).children("input[type='hidden']").val("");
			
			if($(this).hasClass("checked"))
			{
				$(this).children("input[type='hidden']").val("1");	
			}
		}
    });
}

}());

(function() {
function Radio(radioGroup) {
    this.radioGroup = radioGroup;
    this.radio = this.radioGroup + " .js-radio";
}

var klass = Radio.prototype;
var self = Radio;
SCF.Radio = Radio;

klass.init = function() {
    this.bindEvents();
};

klass.bindEvents = function() {
    var _this = this;

    $(this.radio).click(function() {
        $(_this.radio).removeClass("checked");
        $(this).addClass("checked");
		
		if($(_this.radioGroup).children("input[type='hidden']").length > 0)
		{
			$(_this.radioGroup).children("input[type='hidden']").val($(this).attr("optionvalue"));
		}
    });
}

}());

(function() {
function Player(element) {
    this.element          = element;
    this.volumeScale      = this.element + " .js-volume-scale";
    this.volumeBar        = this.element + " .js-volume-bar";
}

var klass = Player.prototype;
var self = Player;
SCF.Player = Player;

klass.init = function() {
    this.bindEvents();
};

klass.bindEvents = function() {
    var _this = this;

    $(this.element).click(function() {
        _this.toggleVolume();
    });

    $(this.volumeScale).mousedown(function(event) {
        $(this).mousemove(function(event) {
            _this.setVolume(event);
        });

        $(this).mouseup(function(event) {
            $(this).unbind("mousemove");
            _this.collapseVolume();
        });
    });

    $(this.volumeScale).click(function(event) {
        _this.setVolume(event);
    });
}

klass.setVolume = function(event) {
    var offsetLeftValue  = $(this.volumeScale).offset().left;
    var trackPosition    = event.pageX - offsetLeftValue - 12;
    var volumeScaleWidth = $(this.volumeScale).width() * 1.06;
    var volumeBarWidth   = trackPosition * 100 / volumeScaleWidth;
    $(this.volumeBar).width(volumeBarWidth + "%");
}

klass.toggleVolume = function() {
    var _this = this;

    if ($(this.element).hasClass("opened")) {
        _this.collapseVolume();
    } else {
        _this.expandVolume();
    }
};

klass.expandVolume = function() {
    $(this.element).addClass("opened");
};

klass.collapseVolume = function() {
    var _this = this;

    setTimeout(function() {
        $(_this.element).removeClass("opened");
    }, 300);
};

}());

(function() {
function CurrentlyPlaying(element) {
    this.element    = element;
    this.scale      = this.element + " .js-currently-playing-scale";
    this.hitbox     = this.element + " .js-currently-playing-hitbox";
}

var klass = CurrentlyPlaying.prototype;
var self = CurrentlyPlaying;
SCF.CurrentlyPlaying = CurrentlyPlaying;

klass.init = function() {
    this.bindEvents();
};

klass.bindEvents = function() {
    var _this = this;
    var scaleInitialWidth = $(this.scale).width();
    var scrollboxWidth = $(this.hitbox).width();

    // Slider mechanics
    $(this.hitbox).slider({
        slide: function(event, ui){
            var scaleWidth = ui.value;

            $(_this.scale).css({
                'width': scaleWidth
            });
        },
        max: scrollboxWidth,
        value: scaleInitialWidth
    });
}

}());

/**
 * jQuery Cookie plugin
 *
 * Copyright (c) 2010 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */
jQuery.cookie = function (key, value, options) {

    // key and at least value given, set cookie...
    if (arguments.length > 1 && String(value) !== "[object Object]") {
        options = jQuery.extend({}, options);

        if (value === null || value === undefined) {
            options.expires = -1;
        }

        if (typeof options.expires === 'number') {
            var days = options.expires, t = options.expires = new Date();
            t.setDate(t.getDate() + days);
        }

        value = String(value);

        return (document.cookie = [
            encodeURIComponent(key), '=',
            options.raw ? value : encodeURIComponent(value),
            options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
            options.path ? '; path=' + options.path : '',
            options.domain ? '; domain=' + options.domain : '',
            options.secure ? '; secure' : ''
        ].join(''));
    }

    // key and possibly options given, get cookie...
    options = value || {};
    var result, decode = options.raw ? function (s) { return s; } : decodeURIComponent;
    return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null;
};

//# sourceMappingURL=interactive.js.map
