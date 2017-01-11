'use strict';

// core module
var Ottavio = (function(){
    var
        events = [],
        isMobile = { //  mobile detection utility
            Android: function() {
                return navigator.userAgent.match(/Android/i);
            },
            BlackBerry: function() {
                return navigator.userAgent.match(/BlackBerry/i);
            },
            iOS: function() {
                return navigator.userAgent.match(/iPhone|iPad|iPod/i);
            },
            Opera: function() {
                return navigator.userAgent.match(/Opera Mini/i);
            },
            Windows: function() {
                return navigator.userAgent.match(/IEMobile/i);
            },
            any: function() {
                return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
            }
        },
        init = function() {
            for (var e in events){
                events[e]();
            }
        },
        refresh = function() {
           $(window).trigger('debouncedresize.slitslider').trigger('resize');
        };
    return {
        events: events,
        isMobile: isMobile,
        init: init,
        refresh: refresh
    };
})();
// end core module

// slitslider module
Ottavio.slider = (function(){
    var $navArrows = $('#nav-arrows'),
        $nav = $('#nav-dots > span'),
        $obj  = $('#slider'),
        slitslider = $obj.slitslider({
            speed : 3800,
            onBeforeChange: function(slide, pos) {
                $nav.removeClass('nav-dot-current');
                $nav.eq(pos).addClass('nav-dot-current');
            }
        }),
        init = function() {
            initEvents();
        },
        initEvents = function() {

            // add navigation events
            $navArrows.children(':last').on('click', function() {
                slitslider.next();
                return false;
            });
            $navArrows.children(':first').on('click', function() {
                slitslider.previous();
                return false;
            });
            $nav.each(function(i) {
                $(this).on('click', function() {
                    var $dot = $(this);
                    if (!slitslider.isActive()) {
                        $nav.removeClass('nav-dot-current');
                        $dot.addClass('nav-dot-current');
                    }
                    slitslider.jump(i + 1);
                    return false;
                });
            });
            // everything ready, show the container
            $obj.css('display','block')
        },
        refresh = function() {
           $(window).trigger('debouncedresize.slitslider').trigger('resize');
        },
        nextSlide = function() {
           slitslider.next();
        };
    return {
        init: init,
        refresh: refresh,
        nextSlide: nextSlide
    };
})();
Ottavio.events.push(Ottavio.slider.init);


// search bar module
Ottavio.searchButton = function() {
    var h = '54px';
    if ($('.search_button').length) {
        $('.search_button').click(function(a) {
            a.preventDefault();
            if (0 === $('.h_search_form').height()) {
                $('.h_search_form input[type="text"]').focus();
                $('.h_search_form').stop().animate({
                    height: h
                }, 150);
            } else {
                $('.h_search_form').stop().animate({
                    height: '0'
                }, 150);
            }
            $(window).scroll(function() {
                if (0 !== $('.h_search_form').height()) {
                    $('.h_search_form').stop().animate({
                        height: '0'
                    }, 150);
                }
            });
            $('.h_search_close').click(function(a) {
                a.preventDefault();
                $('.h_search_form').stop().animate({
                    height: '0'
                }, 150);
            });
        });
    }
};
Ottavio.events.push(Ottavio.searchButton);
// end search bar module


// pie chart module
Ottavio.pieChart = function(obj){
    var time = 2500;
    $(obj).fadeIn('slow').easyPieChart({
        //barColor: '#1abc9c',
        barColor: $('.bg-primary').css('backgroundColor'),
        trackColor: false,
        scaleColor: false,
        scaleLength: 0,
        lineCap: 'square',
        lineWidth: 5,
        size: 120,
        animate: { duration: time, enabled: true },
        onStart: function(){
            $(obj).find('.sectorsImg').css('display','inline-block');
        }
    });
};
Ottavio.events.push(Ottavio.pieChart);
// end pie chart module

// slider control module
Ottavio.sliderControl = function(){
    var $obj = $('.filter_price');
    if ($obj.length > 0) {
        var $display = $obj.parent().find('.price_current');
        $obj.slider({
            tooltip:'hide'
        }).on('slide', function(slideEvt) {
            $display.text( slideEvt.value.join(' - ') );
        });
    }
};
Ottavio.events.push(Ottavio.sliderControl);
// end slider control module


// accordion icons module
Ottavio.accordionIcon = function(){
    var
        $target = $('div.panel-collapse'),
        toggleIcon = function(e){
            $(e.target)
                .prev('.accordion-heading')
                .find('.accordion-icon')
                .toggleClass('fa-minus fa-plus');
            };
    $target
        .on('hidden.bs.collapse', toggleIcon)
        .on('shown.bs.collapse', toggleIcon);
};
Ottavio.events.push(Ottavio.accordionIcon);
// end accordion icons module


// scroll effects module
Ottavio.scrollController = function() {
    var
        controller = new ScrollMagic(),
        windowHeight = $(window).innerHeight(),
        $mainNavigation = $('#main-navigation'),
        $onePageMenu = $('#one-page-menu'),
        $backToTop = $('#back_to_top'),
        $parallax = $('.parallax'),
        $fadingTitle = $('.fading-title'),
        $charts = $('#charts-wrapper'),
        $timer = $('#timer-wrapper');

    function getWindowHeight() {
        return windowHeight;
    }

    controller.scrollTo(function (newpos) {
        TweenMax.to(window, 0.8, {scrollTo: {y: newpos, autoKill:false}});
    });

    // adds 'opaque' class to navigation when scrolling down
    if ($mainNavigation.length > 0) {

        if ($('#contactForm').length > 0 || $('.form-horizontal').length > 0 || $('#blog-frame').length > 0 || $('#tryit').length > 0 || $('#blog-frame-news').length > 0 || $('#blog-frame-tutorials').length > 0)
            $mainNavigation.addClass('opaque');
        else
        {
            new ScrollScene({ offset: $mainNavigation.height() })
            .setClassToggle($mainNavigation, 'opaque')
            .addTo(controller);
        }
    }

    // handles 'back to top' button
    if ($backToTop.length > 0) {
        var h = getWindowHeight();
        new ScrollScene({ offset: h })
            .addTo(controller)
            .on('enter', function() {
                $backToTop.fadeIn('fast');
            })
            .on('leave', function() {
                $backToTop.fadeOut('slow');
            });
        $backToTop.click(function(e){
            e.preventDefault();
            controller.scrollTo(0);
        });
    }

    // navigation behaviour on one page layout
    if ($onePageMenu.length > 0) {
        $onePageMenu.find('a[href^=#]').each(function(){
            var
                _this = $(this),
                _target = _this.attr('href'),
                _duration = $(_target).outerHeight();

            // highlights the proper navigation link when the relevant area is in the viewport
            new ScrollScene({triggerElement: _target, triggerHook: 'onCenter', duration:_duration })
                .setClassToggle(_this.parent(), 'active')
                .addTo(controller);

            _this.click(function(e){
                if (_target.length > 0) {
                    e.preventDefault();

                    // smooth scrolling
                    controller.scrollTo(_target);

                    // if supported by the browser, handles the Back button
                    if (window.history && window.history.pushState) {
                        history.pushState('', document.title, _target);
                    }
                }
            });
        });
    }

    // parallax background
    if ($parallax.length > 0) {
        var testMobile = Ottavio.isMobile.any();
        if (testMobile === null) {
            $parallax.each(function(){
                var
                    _this = $(this),
                    _duration = _this.outerHeight() + getWindowHeight();
                    //bgPosMovement = 'center ' + (-Math.abs(_duration*0.35)) + 'px';
                _this.css({ backgroundSize:'110%'});
                new ScrollScene( {triggerElement: _this, duration: _duration, triggerHook: 'onEnter'} )
                    .setTween( TweenMax.to(_this, 1, {backgroundPosition:'100% 50%', ease: Linear.easeNone}) )
                    .addTo( controller );
            });
        }
    }

    // fades and shifts page title when scrolling down
    if ($fadingTitle.length > 0){
        $fadingTitle.each(function(){
            var
                _this = $(this),
                _element = _this.find('.section-title').first(),
                _duration = _this.outerHeight() + getWindowHeight(),
                offset = _duration*0.35,
                alpha = 1 / (_duration);

            new ScrollScene( {triggerElement: _this, duration: _duration, triggerHook: 'onLeave'} )
                .setTween( TweenMax.to(_element, 1, {marginTop: offset+'px', marginBottom: -Math.abs(offset)+'px', opacity:alpha}) )
                .addTo( controller );
        });
    }

    // start charts plotting when scrolled into view
    if ($charts.length > 0) {
        new ScrollScene( {triggerElement: $charts} )
            .addTo( controller )
            .on('start', function() {
                Ottavio.pieChart('.chart');
            });


    }

    // start charts plotting when scrolled into view
    if ($timer.length > 0) {
        new ScrollScene( {triggerElement: $timer} )
            .addTo( controller )
            .on('enter', function() {
                $('.timer').countTo();
            });
    }

    // updates windowHeight on resize
    $(window).on('resize', function () {
        windowHeight = $(window).innerHeight();
    });
};
Ottavio.events.push(Ottavio.scrollController);
// end scroll effects module


// isotope module
Ottavio.isotope = function(){
  var $container = $('.isotope').isotope({
    itemSelector: '.element-item',
    layoutMode: 'fitRows'
  });

  // filter functions
  var filterFns = {
    // show if number is greater than 50
    numberGreaterThan50: function() {
      var number = $(this).find('.number').text();
      return parseInt( number, 10 ) > 50;
    },
    // show if name ends with -ium
    ium: function() {
      var name = $(this).find('.name').text();
      return name.match( /ium$/ );
    }
  };

  // bind filter button click
  $('#filters').on( 'click', 'button', function() {
    var filterValue = $( this ).attr('data-filter');
    // use filterFn if matches value
    filterValue = filterFns[ filterValue ] || filterValue;
    $container.isotope({ filter: filterValue });
    $('.element-item').css('border-right','1px solid #d7d7d7');
    $('.clientSeperator').css('display','none');
  });
  
  // change is-checked class on buttons
  $('.button-group').each( function( i, buttonGroup ) {
    var $buttonGroup = $( buttonGroup );
    $buttonGroup.on( 'click', 'button', function() {
      $buttonGroup.find('.is-checked').removeClass('is-checked');
      $( this ).addClass('is-checked');
    });
  });

    $container.isotope( 'on', 'layoutComplete',
      function( isoInstance, laidOutItems ) {
        //console.log( laidOutItems.length);
        var sepID=1;
        for (var i = 1; i <= laidOutItems.length; i++) {
            if(i%3==0 && i>2)
            {
                laidOutItems[i-1].element.style.border="none";
                $('#seperator'+sepID).css('display','block');
                sepID++;
            }
        };
      }
    );
    $container.isotope( 'arrange');
  // console.log($('.container').width()/3);
  // $('.element-item').css('width',($('.container').width()/3)-40);
};
Ottavio.events.push(Ottavio.isotope);
// end isotope module


// google maps module
Ottavio.gmaps = function(){
    var
        $elem = $('#map-canvas'),
        options = window.mapOptions || {},
        apiLoad = function() {
            $.getScript('https://maps.googleapis.com/maps/api/js?v=3.exp&callback=Ottavio.gmaps')
                //.done(function (script, textStatus) { })
                .fail(function (jqxhr) {
                    console.error('Could not load Google Maps: ' + jqxhr);
                });
        },
        initMap = function(){
            if ($.fn.gMap !== undefined) {
                $elem.gMap(options);
            } else {
                console.error('jQuery.gMap not available!');
            }
        };

    if (window.google && google.maps) {
        initMap();
    } else {
        apiLoad();
    }
    return {
        init: initMap
    };
};
Ottavio.events.push(Ottavio.gmaps);
// end google maps module



// Ajax portfolio module
Ottavio.portfolio = function(){
    var
        obj               = '#portfolio-gallery',
        $obj              = $(obj),
        hash              = '',
        url               = '',
        page              = '',
        wrapperHeight     = '',
        ajaxLoading       = false,
        pageRefresh       = true,
        content           = false,
        current           = '',
        next              = '',
        prev              = '',
        target            = '',
        scrollPosition    = '',
        projectIndex      = '',
        projectLength     = '',
        loadingError      = '<div class="alert alert-warning">content not available.</div>',
        portfolioGrid     = $('.portfolio', $obj),
        loader            = $('.loader', $obj),
        projectContainer  = $('.ajax-content-inner', $obj),
        messageContainer  = $('.status-message', $obj),
        exitProject       = $('.closeProject', $obj),
        nextLink          = $('.nextProject', $obj),
        prevLink          = $('.prevProject', $obj),
        projectNav        = $('.project-navigation', $obj),
        easing            = 'easeOutExpo',
        folderName        = $obj.data('folder');

    $(window).bind( 'hashchange', function() {
        hash = $(window.location).attr('hash');
        var root = '#!'+ folderName +'/';
        var rootLength = root.length;

        if (hash.substr(0, rootLength) !== root){
            return;

        } else {
            var
                correction = 50,
                headerH = $('nav').outerHeight() + correction;

            hash = $(window.location).attr('hash');
            url = hash.replace(/[#\!]/g, '' );

            portfolioGrid.find('.item.current').removeClass('current' );

            /* url pasted in address bar (or page refresh) */
            if (pageRefresh === true && hash.substr(0, rootLength) === root) {
                $('html, body').stop().animate({ scrollTop: (projectContainer.offset().top-20)+'px'}, 800, easing, function(){
                    loadProject();
                });

                /* click on portfolio grid or project navigation */
            } else if(pageRefresh === false && hash.substr(0,rootLength) === root) {
                $('html,body').stop().animate({scrollTop: (projectContainer.offset().top-headerH)+'px'}, 800, easing, function(){
                    if (content === false) {
                        loadProject();
                    } else {
                        projectContainer.animate({opacity:0, height:wrapperHeight}, loadProject );
                    }
                    projectNav.fadeOut('100');
                    exitProject.fadeOut('100');
                });

                /* click on browser back button (no refresh)  */
            } else if (hash === '' && pageRefresh === false || hash.substr(0,rootLength) !== root && pageRefresh === false || hash.substr(0,rootLength) !== root && pageRefresh === true) {
                scrollPosition = hash;
                $('html, body').stop().animate({scrollTop: scrollPosition+'px'}, 1000, deleteProject );
            }

            /* add active class to selected project  */
            portfolioGrid.find('.item a[href="#!' + url + '"]' ).parents('li').addClass( 'current' );
        }
        return false;
    });

    function loadProject(){
        loader.fadeIn();
        messageContainer.animate({
            opacity:0,
            height:'0px'
        }).empty();
        if (!ajaxLoading) {
            ajaxLoading = true;
            projectContainer.load( url + ' .ajaxpage', function(xhr, statusText){
                if (statusText === 'success') {
                    page =  $('.ajaxpage', obj);
                    $('.ajaxpage', obj).waitForImages(function() {
                        hideLoader();
                        ajaxLoading = false;
                    });
                    $('.owl-carousel', $obj).owlCarousel();
                    projectNav.fadeIn();
                }
                if (statusText === 'error') {
                    projectContainer
                        .animate({
                            opacity:0,
                            height:'0px'
                        })
                        .empty();
                    messageContainer
                        .html( loadingError )
                        .animate( {
                            opacity: 1,
                            height: (messageContainer.find('.alert').outerHeight(true)+'px')
                        });
                    hideLoader();
                    ajaxLoading = false;
                }
            });
        }
    }

    function hideLoader(){
        loader.fadeOut('fast', function(){
            showProject();
        });
    }

    function showProject(){
        if (content === false){
            wrapperHeight = projectContainer.children('.ajaxpage').outerHeight() + 'px';
            projectContainer.animate({opacity:1, height:wrapperHeight}, function(){
                scrollPosition = $('html, body').scrollTop();
                exitProject.fadeIn();
                content = true;
            });
        } else {
            wrapperHeight = projectContainer.children('.ajaxpage').outerHeight() + 'px';
            projectContainer.animate({opacity:1, height:wrapperHeight}, function(){
                scrollPosition = $('html, body').scrollTop();
                exitProject.fadeIn();
            });
        }

        projectIndex = portfolioGrid.find('.item.current').index();
        projectLength = $('.item', obj).length-1;

        if (projectIndex === projectLength) {
            nextLink.addClass('disabled');
            prevLink.removeClass('disabled');

        } else if (projectIndex === 0){
            nextLink.addClass('disabled');
            prevLink.removeClass('disabled');

        } else {
            nextLink.removeClass('disabled');
            prevLink.removeClass('disabled');
        }
    }

    function deleteProject(closeURL){
        projectNav.fadeOut(100);
        exitProject.fadeOut(100);
        projectContainer.animate({opacity:0, height:'0px'}).empty();
        messageContainer.animate({opacity:0, height:'0px'}).empty();

        if (typeof closeURL !== 'undefined' && closeURL !== '') {
            document.location = '#_';
        }
        portfolioGrid.find('.item.current').removeClass('current' );
    }

    /* link to next project */
    nextLink.on('click',function () {
        current = portfolioGrid.find('.item.current');
        next = current.next('.item');
        target = $(next).find('a.ajax_load').attr('href');
        $(this).attr('href', target);
        if (next.length === 0) {
            return false;
        }
        current.removeClass('current');
        next.addClass('current');
    });

    /* link to previous project */
    prevLink.on('click',function () {
        current = portfolioGrid.find('.item.current');
        prev = current.prev('.item');
        target = $(prev).find('a.ajax_load').attr('href');
        $(this).attr('href', target);
        if (prev.length === 0) {
            return false;
        }
        current.removeClass('current');
        prev.addClass('current');
    });

    /* close project */
    exitProject.on('click',function () {
        deleteProject( $(this).find('a').attr('href') );
        loader.fadeOut();
        return false;
    });

    // if passed in by the url, load the required portfolio detail
    $(window).trigger( 'hashchange' );

    pageRefresh = false;
};
Ottavio.events.push(Ottavio.portfolio);
// end Ajax portfolio module



// Contacts form module
Ottavio.contactForm = function(){
    var
        $form = $('#contactForm'),
        $msgSuccess = $('#successMessage'),
        $msgFailure = $('#failureMessage'),
        $msgIncomplete = $('#incompleteMessage'),
        messageDelay = 2000;

    $form.validate({
        invalidHandler: function(event, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {
                $msgIncomplete.show();
            } else {
                $msgIncomplete.fadeOut();
            }
        },
        submitHandler: function(form) {
            var
                _form = $(form),
                data = _form.serialize(),
                action = _form.attr('action');

            data += '&ajax=true';
            $msgIncomplete.fadeOut();
            _form.fadeOut();

            $.post(action, data)
                .done(function(response){
                    if (response === 'success'){
                        $msgSuccess.fadeIn().delay(messageDelay).fadeOut();

                        var _fbq = window._fbq || (window._fbq = []);
                        if (!_fbq.loaded) {
                          var fbds = document.createElement('script');
                          fbds.async = true;
                          fbds.src = '//connect.facebook.net/en_US/fbds.js';
                          var s = document.getElementsByTagName('script')[0];
                          s.parentNode.insertBefore(fbds, s);
                          _fbq.loaded = true;
                        }

                        window._fbq = window._fbq || [];
                        window._fbq.push(['track', '6022106543310', {'value':'0.00','currency':'USD'}]);


                        _form.trigger('reset');
                    } else {
                        $msgFailure.fadeIn().delay(messageDelay).fadeOut();
                    }
                })
                .fail(function() {
                    $msgFailure.fadeIn().delay(messageDelay).fadeOut();

                })
                .always(function(){
                    _form.delay(messageDelay+500).fadeIn();
                });
            return false;
        }
    });
};
Ottavio.events.push(Ottavio.contactForm);
// end Contacts form module


// newsletters form module
Ottavio.newsletterForm = function(){
    $("#newsletterForm").validate({
        submitHandler: function(form) {

            $('.alert').removeClass('hide');

            setTimeout(function(){
                $('.alert').addClass('hide');
            },3000)

            $.ajax({
                type: "POST",
                url: $("#newsletterForm").attr("action"),
                data: {
                    "email": $("#newsletterForm #email").val()
                },
                dataType: "json",
                success: function (data) {
                    if (data.response == "success") {

                        $("#newsletterSuccess").removeClass("hidden");
                        $("#newsletterError").addClass("hidden");

                        $("#newsletterForm #email")
                            .val("")
                            .blur()
                            .closest(".control-group")
                            .removeClass("success")
                            .removeClass("error");

                    } else {

                        $("#newsletterError").html(data.message);
                        $("#newsletterError").removeClass("hidden");
                        $("#newsletterSuccess").addClass("hidden");

                        $("#newsletterForm #email")
                            .blur()
                            .closest(".control-group")
                            .removeClass("success")
                            .addClass("error");
                    }
                }
            });

        },
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        errorPlacement: function(error, element) {  
            
        },
        highlight: function (element) {
            $(element)
                .closest(".control-group")
                .removeClass("success")
                .addClass("error");
        },
        success: function (element) {
            $(element)
                .closest(".control-group")
                .removeClass("error")
                .addClass("success");
        }
    });
};
Ottavio.events.push(Ottavio.newsletterForm);
// end newsletters form module


// search form module
Ottavio.searchForm = function(){
    $("#searchForm").validate({
            rules: {
                q: {
                    required: true
                }
            },
            errorPlacement: function(error, element) {  
                
            },
            highlight: function (element) {
                $(element)
                    .closest(".control-group")
                    .removeClass("success")
                    .addClass("error");
            },
            success: function (element) {
                $(element)
                    .closest(".control-group")
                    .removeClass("error")
                    .addClass("success");
            }
        });
};
Ottavio.events.push(Ottavio.searchForm);
// end search form module



$(document).ready(function() {
    // loading overlay
    $('body').queryLoader2({
        barColor: 'transparent',
        backgroundColor: '#fff',
        percentage: false,
        barHeight: 1,
        minimumTime: 200,
        fadeOutTime: 1000,
        onComplete: function(){
            if($('#slider').length>0){
                Ottavio.slider.nextSlide();
                $("#videoSlide").delay(500).fadeIn(2500);
            }
        }

    });
    $('#load').fadeOut().remove();

    setTimeout(function(){
        $(window).trigger('resize');
    },1000);


    if($('#circle-diagram').length) {
        circleDiagram('circle-diagram', 500, 500, '#circle-diagram-data');
    }

    $('.dropdown-menu input, .dropdown-menu label').click(function(e) {
        e.stopPropagation();
    });

    $('input, textarea').placeholder();

    // Start TouchSpin function
    $('input.qty').TouchSpin();

    // Start FitVids function
    $('body').fitVids();
    $('.background-video video').fillparent();

    // Swiper function
    $('.swiper-container').swiper({
        slidesPerView: 'auto'
    });

    // Start OwlCarousel
    $('.owl-carousel').owlCarousel({
      autoPlay : true
    });

    // PrettyPhoto initialization
    $('a[data-rel]').each(function() {
        $(this).attr('rel', $(this).data('rel'));
    });
    $('a[data-rel^=prettyPhoto]').prettyPhoto({
        slideshow: 5000,
        autoplay_slideshow: false,
        social_tools: false
    });

    // Start WOW animations
    if (!Ottavio.isMobile.iOS()) {
        new WOW().init();
    }
    
    // $( ".sectors" ).hover(
    //   function() {
    //     $(this).find('img').before("<img src='/images/website/sectors/shadow.png' class='sectorsImgShadow'>");
    //   }, function() {
    //     $(this).find('img.sectorsImgShadow').remove();
    //   }
    // );

    // $('body').on('click', function(e) {
    //     if(e.target.id=="videoSlide"){
    //         if ($('#home-video')[0].paused)
    //             $('#home-video')[0].play();
    //         else
    //             $('#home-video')[0].pause();
    //     }
    // });

    // $( ".sectors" ).parent().find('p').hover(
    //   function() {
    //     $(this).parent().parent().find('img').before("<img src='/images/website/sectors/shadow.png' class='sectorsImgShadow'>");
    //   }, function() {
    //     $(this).parent().parent().find('img.sectorsImgShadow').remove();
    //   }
    // );

    // init Theme functions
    Ottavio.init();

}).on('click','.navbar-toggle',function() {
    // toggle navigation
    $('.navbar-collapse').toggleClass('in');

}).on('click','.navbar-collapse.in',function(e) {
    // close navigation on click
    if( $(e.target).is('a') ) {
        $('.navbar-collapse').toggleClass('in');
    }

});

$(window).resize(function () {
    if ($(window).width() > 768) {
        $('.collapse').removeClass('in');
    }
});
