(function($) {

    'use strict';
	
	/* jQuery Settings Table
	
		# Cache jQuery Selector
		# Paraxify Function
		# Header search box show
		# Auto active class adding with navigation
		# Put slider space for nav not in mini screen
		# dropdown submenu on hover in desktop and dropdown sub menu on click in mobile //for navbar all
		# Toogle fixed-top class in header when window scroll 200px //for fixed-header
		# Fact Counter For Achivement Counting //for fact-counting
		# MixIt-up tab calling //for mixitup
		# Our Partner Logos Slider Auto //for partner-slider
		# Single carousel slide
		# Single Text Carusel
		# Three Block Slide
		# Three Block Slide no margin
		# Four Block Slide
		# Single Product Image Slide //for single shop slider
		# Start When document is Scrollig, do //for fact-counting & fixed-header
		# Contact Form Validation
		# Elements Animation for //fact-counting
		# bootstrap selectpiker //for bootstrap-select
		# Single Accordean //foe accordean
		# Scroll top by clicking arrow up //for scroll-top
		
	*/
	
    //Cache jQuery Selector
    var $window = $(window),
        $header = $('header'), // for fixed-header & for navbar all
        $navigation = $('#navbarSupportedContent'), //for navbar all
        $dropdown = $('.dropdown-toggle'), //for navbar all
        $mix_tab = $('.mix-tab'), //for mixitup
        $brand = $('.partner-slider'), //for partner-slider
        $single_carousel = $('.single-carousel'),
		$single_carusel_text	= $('.text-carusel'),
        $three_item = $('.3block-carousel'),
        $three_item_no_margin = $('.3block-carousel-nomargin'),
        $four_item = $('.4block-carousel'),
        $contact = $('#contact-form');
		
		
	//Parallax - START CODE
	if($('.paraxify').length){
		$(function() {
			$window .on("load resize scroll", function() {
				paraxify('.paraxify');
			});
		});
	}
	
	// Slider push menu visible
	if(document.querySelector('.push-nav-toggle') !== null) {
		var $this = $('.push-nav-toggle'),
			$close = $('.slide-nav-close'),
			$sidenav = $('.nav-leftpush-overlay .navbar-expand-lg .navbar-slide-push');
			
		$this.on('click', function(event){
			event.preventDefault();
			$sidenav.addClass('visible');
			$('#page_wrapper').addClass('overlay');
			event.stopPropagation();
		});
		
		
		$sidenav.on('click', function(event) {
			event.stopPropagation();
		});
		
		$window.on('click', function(e) {
			$sidenav.removeClass('visible');
			$('#page_wrapper').removeClass('overlay');
		});
		
		$close.on('click', function(e) {
			$sidenav.removeClass('visible');
			$('#page_wrapper').removeClass('overlay');
		});
		
	}

    // Click Search Icon and Open Search Field	//for header search
	if(document.querySelector('.search-pop') !== null) {
		var $srcicon = $('.search-pop span'),
			$srcfield = $('.search-form');
		$srcicon.on('click', function(event) {
			event.preventDefault();
			$srcfield.addClass('visible');
			event.stopPropagation();
		});

		$srcfield.on('click', function(event) {
			event.stopPropagation();
		});

		$window.on('click', function(e) {
			$srcfield.removeClass('visible');
		});
	}


    // Auto active class adding with navigation //for navbar all
    $window.on('load', function() {
        var current = location.pathname;
        var $path = current.substring(current.lastIndexOf('/') + 1);
        $('#navbarSupportedContent li a').each(function(e) {
            var $this = $(this);
            // if the current path is like this link, make it active
            if ($path == $this.attr('href')) {
                $this.parent('li').addClass('active');
            } else if ($path == '') {
                $('.navbar-nav li:first-child').addClass('active');
            }
        })
    });

    // Put slider space for nav not in mini screen //for navbar all
    if (document.querySelector('.nav-on-top') !== null) {
        var get_height = jQuery('.nav-on-top').height();
        if (get_height > 0 && $window.width() > 991) {
            jQuery('.nav-on-top').next().css('margin-top', get_height);
        }
        $window.on('resize', function() {
            $header.removeClass('fixed-top');
            var get_height = jQuery('.nav-on-top').height();
            if ($window.width() < 991) {
                jQuery('.nav-on-top').next().css('margin-top', '0');
            } else {
                jQuery('.nav-on-top').next().css('margin-top', get_height);
            }
        });
    }
    if (document.querySelector('.nav-on-banner') !== null) {
        var get_height = jQuery('.nav-on-banner').height();
        if (get_height > 0 && $window.width() > 991) {
            jQuery('.nav-on-banner').next().css('padding-top', get_height);
        }
        $window.on('resize', function() {
            $header.removeClass('fixed-top');
            var get_height = jQuery('.nav-on-banner').height();
            if ($window.width() < 991) {
                jQuery('.nav-on-banner').next().css('padding-top', '0');
            } else {
                jQuery('.nav-on-banner').next().css('padding-top', get_height);
            }
        });
    }


    // dropdown submenu on hover in desktop and dropdown sub menu on click in mobile //for navbar all
    $navigation.each(function() {
        $dropdown.on('click', function(e) {
            if ($window.width() < 1100) {
                if ($(this).parent('.dropdown').hasClass('visible')) {
                    $(this).parent('.dropdown').children('.dropdown-menu').first().stop(true, true).slideUp(300);
                    $(this).parent('.dropdown').removeClass('visible');
                    //window.location = $(this).attr('href');
                } else {
                    e.preventDefault();
                    $(this).parent('.dropdown').siblings('.dropdown').children('.dropdown-menu').slideUp(300);
                    $(this).parent('.dropdown').siblings('.dropdown').removeClass('visible');
                    $(this).parent('.dropdown').children('.dropdown-menu').slideDown(300);
                    $(this).parent('.dropdown').addClass('visible');
                }
                e.stopPropagation();
            }
        });

        $('body').on('click', function(e) {
            $dropdown.parent('.dropdown').removeClass('visible');
        });

        $window.on('resize', function() {
            if ($window.width() > 991) {
                $('.dropdown-menu').removeAttr('style');
                $('.dropdown ').removeClass('visible');
            }
        });
    });
	
	

    // Toogle fixed-top class in header when window scroll 200px //for fixed-header
    function headerStyle() {
        if ($header.length) {
            var windowpos = $window.scrollTop();
            if (windowpos >= 200) {
                $header.addClass('fixed-top');
            } else {
                $header.removeClass('fixed-top');
            }
        }
    }


    // Fact Counter For Achivement Counting //for fact-counting
    function factCounter() {
        if ($('.fact-counter').length) {
            $('.fact-counter .count.animated').each(function() {
                var $t = $(this),
                    n = $t.find(".count-num").attr("data-stop"),
                    r = parseInt($t.find(".count-num").attr("data-speed"), 10);

                if (!$t.hasClass("counted")) {
                    $t.addClass("counted");
                    $({
                        countNum: $t.find(".count-text").text()
                    }).animate({
                        countNum: n
                    }, {
                        duration: r,
                        easing: "linear",
                        step: function() {
                            $t.find(".count-num").text(Math.floor(this.countNum));
                        },
                        complete: function() {
                            $t.find(".count-num").text(this.countNum);
                        }
                    });
                }

                //set skill building height
                var size = $(this).children('.progress-bar').attr('aria-valuenow');
                $(this).children('.progress-bar').css('width', size + '%');

            });
        }
    }
	

    // MixIt-up tab calling //for mixitup
    if ($mix_tab.length) {
        var containerEl = document.querySelector('.mix-element');
        var mixer = mixitup(containerEl);
    }

    // Our Partner Logos Slider Auto //for partner-slider
    if ($brand.length) {
        $brand.owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            dots: true,
            smartSpeed: 500,
            autoplay: 4000,
            responsive: {
                0: {
                    items: 2
                },
                480: {
                    items: 3
                },
                600: {
                    items: 3
                },
                800: {
                    items: 4
                },
                1200: {
                    items: 6
                }
            }
        });
    }



    // Single carousel slide
    if ($single_carousel.length) {
        $single_carousel.owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            dots: true,
            smartSpeed: 500,
            autoplay: false,
            responsive: {
                0: {
                    items: 1
                }
            }
        });
    }
	
	
	// Single Text Carusel
	if ($single_carusel_text.length) {
		$single_carusel_text.owlCarousel({
			loop:false,
			margin:30,
			nav:false,
			dots: true,
			smartSpeed: 500,
			autoplay: false,
			responsive:{
				0:{
					items:1
				},
				480:{
					items:1
				},
				600:{
					items:1
				},
				800:{
					items:1
				},
				1200:{
					items:1
				}
			}
		});    		
	}
	
	
    // Three Block Slide
    if ($three_item.length) {
        $three_item.owlCarousel({
            loop: false,
            margin: 30,
            nav: true,
            dots: true,
            smartSpeed: 500,
            autoplay: false,
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 1
                },
                600: {
                    items: 2
                },
                800: {
                    items: 3
                },
                1200: {
                    items: 3
                }
            }
        });
    }
	
	// Three Block Slide no margin
    if ($three_item_no_margin.length) {
        $three_item_no_margin.owlCarousel({
            loop: false,
            margin: 0,
            nav: true,
            dots: true,
            smartSpeed: 500,
            autoplay: false,
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 1
                },
                600: {
                    items: 2
                },
                800: {
                    items: 3
                },
                1200: {
                    items: 3
                }
            }
        });
    }

    // Four Block Slide
    if ($four_item.length) {
        $four_item.owlCarousel({
            loop: false,
            margin: 30,
            nav: true,
            dots: true,
            smartSpeed: 500,
            autoplay: false,
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 1
                },
                600: {
                    items: 2
                },
                800: {
                    items: 3
                },
                1200: {
                    items: 4
                }
            }
        });
    }
	
	// Single Product Image Slide //for single shop slider
    if ($(".full-img-sweep").length) {
        $('.full-img-sweep').layerSlider({
            sliderVersion: '6.0.0',
            responsiveUnder: 0,
            layersContainer: 0,
            slideBGSize: 'auto',
            autoStart: 'false',
            showCircleTimer: 'false',
            skin: 'noskin',
            thumbnailNavigation: 'always',
            skinsPath: 'assets/skins/'
        });
    }

	
	// Start When document is Scrollig, do //for fact-counting & fixed-header
    $(window).on('scroll', function() {
        headerStyle();
        factCounter();
    });
	
	
	// Contact Form Validation
	if($contact.length){
		$contact.validate({  //#contact-form contact form id
			rules: {
				firstname: {
					required: true    // Field name here
				},
				email: {
					required: true, // Field name here
					email: true
				},
				subject: {
					required: true
				},
				message: {
					required: true
				}
			},
			
			messages: {
                firstname: "Please enter your First Name", //Write here your error message that you want to show in contact form
                email: "Please enter valid Email", //Write here your error message that you want to show in contact form
                subject: "Please enter your Subject", //Write here your error message that you want to show in contact form
				message: "Please write your Message" //Write here your error message that you want to show in contact form
            },

            submitHandler: function (form) {
                $('#send').attr({'disabled' : 'true', 'value' : 'Sending...' });
                $.ajax({
                    type: "POST",
                    url: "email.php",
                    data: $(form).serialize(),
                    success: function () {
                        $('#send').removeAttr('disabled').attr('value', 'Send');
                        $( "#success").slideDown( "slow" );
                        setTimeout(function() {
                        $( "#success").slideUp( "slow" );
                        }, 5000);
                        form.reset();
                    },
                    error: function() {
                        $('#send').removeAttr('disabled').attr('value', 'Send');
                        $( "#error").slideDown( "slow" );
                        setTimeout(function() {
                        $( "#error").slideUp( "slow" );
                        }, 5000);
                    }
                });
                return false; // required to block normal submit since you used ajax
            }

		});
	}
	

    // Elements Animation for //fact-counting
    if ($('.wow').length) {
        var wow = new WOW({
            boxClass: 'wow', // animated element css class (default is wow)
            animateClass: 'animated', // animation css class (default is animated)
            offset: 0, // distance to the element when triggering the animation (default is 0)
            mobile: true, // trigger animations on mobile devices (default is true)
            live: true // act on asynchronously loaded content (default is true)
        });
        wow.init();
    }


    // bootstrap selectpiker //for bootstrap-select
    if ($(".selectpicker").length) {
        $(function() {
            $('.selectpicker').selectpicker();
        });
    }


    // Single Accordean //foe accordean
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            /* Toggle between adding and removing the "active" class,
            to highlight the button that controls the panel */
            this.classList.toggle("active");

            /* Toggle between hiding and showing the active panel */
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight) {
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
            }
        });
    }


    // Scroll top by clicking arrow up //for scroll-top
    $window.scroll(function() {
        if ($(this).scrollTop() > 500) {
            $('#scroll').fadeIn();
        } else {
            $('#scroll').fadeOut();
        }
    });
    $('#scroll').click(function() {
        $("html, body").animate({
            scrollTop: 0
        }, 1000);
        return !1;
    });



})(jQuery);