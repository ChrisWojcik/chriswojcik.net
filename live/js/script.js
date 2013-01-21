/*!
 * Filename:     script.js
 * Author:       Chris Wojcik
 * Website:      www.chriswojcik.net
 */

// Namespace object
var WOJ = WOJ || {};

// "Sticky" navigation bar using "position: fixed"
WOJ.navigation = (function() {
    "use strict";

    // Cache DOM objects
    var stickyNav = $('#sticky-nav');
    var mainNav   = $('.main-nav');

    var showStickyNav; // Will stickyNav be displayed?
    var scrollOffset; // Account for the height of the stickyNav when scrolling

        // StickyNav only displayed on larger devices (Spotty mobile support)
        if (Modernizr.mq('only all and (min-device-width: 1024px)')) {
            showStickyNav = true;
            scrollOffset = stickyNav.outerHeight() - 2; // Don't be TOO exact
        } else {
            showStickyNav = false;
            scrollOffset = 0;
    }
    
    // Setup and event handlers
    var init = function() {

        // Hide the StickyNav by default
        stickyNav.hide();

        if (showStickyNav) {
            mainNav.find('li:first-child a').addClass('current');
            setWayPoints();                
        }

        // Smooth animated scrolling for navigation bar
        mainNav.on('click', 'a', scrollToHref);

        // Smooth scrolling for clicking on the logo
        $('#logo').find('a').on('click', scrollToHref);
    };
    
    // Using jQuery Waypoints
    var setWayPoints = function() {

        // Set throttle setting close to the fade animation duration to prevent
        // the nav bar from cycling while scrolling
        $.waypoints.settings.scrollThrottle = 450;

        // Reveal the sticky nav if twice its height down the page
        $('#home').waypoint({
            handler: function(event, direction) {
                fadeInOutStickyNav(direction);
            },
            offset: scrollOffset * -2
        });

        // Set a waypoint at each section to 
        // cycle the current selection on the nav bar
        $('section').waypoint({
            handler: function(event, direction) {
                changeCurrentLink($(this), direction);
            },
            offset: scrollOffset * 2
        });
    };
    
    // Scroll to the top of an element
    var scrollToHref = function(e) {
        $('html, body').stop(); // Stop any ongoing scrolling immediately
        $.scrollTo(
            $(this).attr("href"),
            {
                duration: 500,
                offset: {'left': 0, 'top': scrollOffset * -1}
            }
        );
        e.preventDefault();
    };

    // Handler for show/hiding the stickyNav as the user scrolls down/up
    var fadeInOutStickyNav = function(direction) {
        if (direction === "down") {
            stickyNav.stop(true, true).fadeIn(400);
        } else {
            stickyNav.stop(true, true).fadeOut(250);
        }
    };

    // Handler for changing the "current" link as the user scrolls through sections
    var changeCurrentLink = function(section, direction) {
        var activeSection = section;
        if (direction === "up") {
            activeSection = activeSection.prev();
        }
        var activeLink = mainNav.find('a[href="#' + activeSection.attr("id") + '"]');
        mainNav.find('a').removeClass('current');
        activeLink.addClass('current');
    };
    
    return {
        scrollOffset: scrollOffset,
        init: init
    };        
})();

// Interactive Portfolio Gallery
WOJ.portfolioGallery = (function() {
    "use strict";

    // Cache DOM Objects
    var featuredProject = $('#featured-project');
    var projects        = $('.project');
    var projectsGallery = projects.find('.thumbnail-gallery');
    var otherProjects   = $('#other-projects');
    var otherGallery    = otherProjects.find('.thumbnail-gallery');

    var animating = false; // Used to prevent simultaneous animations

    // Grab the scroll offset
    var scrollOffset = WOJ.navigation.scrollOffset;

    // CSS Properties - for the switching out the featured image
    var visibleImg = {position: 'relative', zIndex: 2};
    var hiddenImg  = {position: 'absolute', top: 0, left: 0, zIndex: 1};
    
    // Setup and event handlers
    var init = function() {

        // Hide all but the first project, and show the other projects nav
        projects.not(':first-child').hide();
        otherProjects.show();

        // Scroll up to the top and fade in the selected project
        otherGallery.on('click', 'a', function(e) {
            var link    = $(this),
                hash    = link.attr('href'),
                project = $(hash);

            // Only run the animation if not the currently featured project
            if (!link.hasClass('current') && !animating) {

                animating = true;
                otherGallery.find('a').removeClass('current');
                link.addClass('current');

                revealProject(project, 600, function() {
                    animating = false;
                });
            }

            e.preventDefault();
        });

        // Fade in other images when clicking on thumbnails
        projectsGallery.on('click', 'a', function(e) {
            var link       = $(this),
                newSrc     = link.attr('href'),
                figure     = link.closest('.project').find('figure'),
                currentImg = figure.find('img');

            // Only run if we're clicking on a thumbnail of a different img
            if ((currentImg.attr('src') !==  newSrc) && !animating) {
                animating = true;
                switchFeaturedImg(currentImg, newSrc, figure, function() {
                    animating = false;
                });
            }

            e.preventDefault();
        });
    };

    // Scroll to the top of the projects area, fade out, and fade in a new one
    var revealProject = function(project, fadeTime, callback) {

        $.scrollTo(
            featuredProject,
            {
                duration: 300,
                offset: {'left': 0, 'top': scrollOffset * -1},
                onAfter : function() {
                    featuredProject.find('.current').removeClass('current')
                        .fadeOut(fadeTime, function() {
                            project.addClass('current').fadeIn(fadeTime);                            
                            if (typeof(callback) === "function") {  
                                callback();  
                            }
                        });
                }
            }
        );
    };

    var switchFeaturedImg = function(currentImg, newSrc, parent, callback) {
        currentImg.css(visibleImg);

        // Absolutely position a new image behind the old one
        var newImg = currentImg.clone()
            .css(hiddenImg).attr('src', newSrc).appendTo(parent);

        // Fade out the original image and then remove it from the DOM
        currentImg.fadeOut(500, function() {
            newImg.css(visibleImg);
            $(this).remove();            
            if (typeof(callback) === "function") {  
                callback();  
            }
        });        
    };        

    return {
        init: init
    };
})();

// Form validation and submission via ajax
WOJ.contactForm = (function() {
    "use strict";
    
    // cache DOM elements
    var submitMessage     = $('#submit-message');
    var messageContainer  = submitMessage.find('span');
    var loading           = $('#loading');
    
    var init = function() {

        $('#contact-form').validate({

            // Override a few defaults
            errorElement: 'span',
            messages: {
                email: {
                    required: "This field is required.",
                    email: "Invalid email address."
                }
            },
            errorPlacement: function(error, element) {
                error.insertBefore(element);
            },

            // Override to submit the form via ajax
            submitHandler: function(form) {
                var options = {
                    beforeSubmit: function() {
                        loading.show();
                    },
                    success: function() {
                        showSuccess('Thank you! Your email has been submitted.');
                        loading.hide();
                    },
                    error: function() {
                        showFailure("We're sorry, your email could not be sent. Please try again later.");
                        loading.hide();
                    },
                    clearForm: true,
                    resetForm: true
                };
                $(form).ajaxSubmit(options);
            },
            invalidHandler: function() {
                showFailure('There were some problems with your submission.');
            }
        });
    };

    var showSuccess = function(message) {
        messageContainer.text(message);
        messageContainer.attr('class', 'success');
        submitMessage.removeClass('hidden');
    };

    var showFailure = function(message) {
        messageContainer.text(message);
        messageContainer.attr('class', 'failure');
        submitMessage.removeClass('hidden');
    };    
    
    return {
        init: init
    };
})();

// On document.ready
$(function() {
    "use strict";
    
    // Add css hook for no media query support
    if (!Modernizr.mq('only all')) {
        $('html').addClass('no-mq');
    }
    
    // Preload images
    $.preloadImages('http://localhost/portfolio-beanstalk/img/bartlet-2.jpg',
                    'http://localhost/portfolio-beanstalk/img/bartlet-3.jpg',
                    'http://localhost/portfolio-beanstalk/img/ranger-2.jpg',
                    'http://localhost/portfolio-beanstalk/img/rrca-2.jpg',
                    'http://localhost/portfolio-beanstalk/img/rrca-3.jpg',
                    'http://localhost/portfolio-beanstalk/img/ajax-loader.gif');
                    
    WOJ.navigation.init();
    WOJ.portfolioGallery.init();
    WOJ.contactForm.init();
});

// Replace the logo on retina displays
$(window).on("load", function() {
    "use strict";
    
    var pixelRatio = !!window.devicePixelRatio ? window.devicePixelRatio : 1,
        logoimg    = $('#logo').find('img');

    if (pixelRatio > 1) {
        logoimg.attr('src', logoimg.attr('src').replace(".", "@2x."));
    }
});