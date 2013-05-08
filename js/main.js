/*!
 * Filename:     script.js
 * Author:       Chris Wojcik
 * Website:      www.chriswojcik.net
 * 
 * Dependencies: jQuery, Modernizr, plugins.js
 */

(function (window, document, $, Modernizr, undefined) {
    "use strict";
    
    // Namespace object
    var WOJ = WOJ || {};
    
    WOJ.init = function() {
        
        // Fixed nav bar will only be displayed at desktop screen sizes
        if (Modernizr.mq('only all and (min-device-width: 1024px)')) {
            this.showStickyNav = true;
            this.scrollOffset = $('#sticky-nav').outerHeight() - 2;
        } else {
            this.showStickyNav = false;
            this.scrollOffset = 0;
        }
        
        // Add CSS hook for no media query support
        if (!Modernizr.mq('only all')) {
            $('html').addClass('no-mq');
        }
        
        // Preload images
        this.utils.preloadImgs('img/bartlet-2.jpg',
                               'img/bartlet-3.jpg',
                               'img/ranger-2.jpg',
                               'img/rrca-2.jpg',
                               'img/rrca-3.jpg',
                               'img/ajax-loader.gif');
        
        // Run the page
        this.onePageNav.init();
        this.portfolioGallery.init();
        this.contactForm.init();  
                               
        // Replace the logo on retina displays
        $(window).on("load", function() {
    
            var pixelRatio = !!window.devicePixelRatio ? window.devicePixelRatio : 1,
                logoimg    = $('#logo').find('img');

            if (pixelRatio > 1) {
                logoimg.attr('src', logoimg.attr('src').replace(".", "@2x."));
            }
        });
    };
    
    WOJ.utils = {
        
        preloadImgs: function() {
            var Images = [],
                i;
            for (i = 0; arguments.length > i; i+=1)  {
                Images[i] = document.createElement("img");
                Images[i].src = arguments[i];
            }
        },
        
        // Smooth animated scrolling to top of element (using plugin)
        scrollTo: function($el, duration, callback) {
            $('html, body').stop(); // Stop any ongoing scrolling immediately
            $.scrollTo(
                $el,
                {duration: duration,
                  offset: {'left': 0, 'top': WOJ.scrollOffset * -1},
                  onAfter: (typeof callback === 'function') ? 
                    callback : null
                }
            );
        }
    };
    
    WOJ.onePageNav = {
        
        init: function() {            
            
            this.cacheElements();
            this.bindEvents();
            this.$stickyNav.hide(); // Hide by default
            
            if (WOJ.showStickyNav) {
                this.$mainNav.find('li:first-child a').addClass('current');
                this.setWaypoints();                
            }
        },
        
        cacheElements: function() {
            this.$stickyNav = $('#sticky-nav');
            this.$mainNav   = $('.main-nav');
        },
        
        bindEvents: function() {
            this.$mainNav.on('click', 'a', $.proxy(this.handleClick, this));
            $('#logo').find('a').on('click', $.proxy(this.handleClick, this));
        },
        
        handleClick: function(e) {
            WOJ.utils.scrollTo($(e.currentTarget).attr("href"), 500);
            e.preventDefault();
        },
        
        // Using jQuery Waypoints
        setWaypoints: function() {
            
            var self = this;
            
            // Set throttle setting close to the fade duration to prevent
            // the nav bar from cycling while scrolling
            $.waypoints.settings.scrollThrottle = 450;

            // Reveal the sticky nav if twice its height down the page
            $('#home').waypoint({
                handler: $.proxy(self.fadeInOutStickyNav, self),
                offset: WOJ.scrollOffset * -2
            });

            // Set a waypoint at each section to cycle the current selection on 
            // the nav bar
            $('section').waypoint({
                handler: $.proxy(self.changeSelectedLink, self),
                offset: WOJ.scrollOffset * 2
            });
        },
        
        // Handler for show/hiding the stickyNav as the user scrolls down/up
        fadeInOutStickyNav: function(e, direction) {
            if (direction === "down") {
                this.$stickyNav.stop(true, true).fadeIn(400);
            } else {
                this.$stickyNav.stop(true, true).fadeOut(250);
            }
        },
        
        // Handler for changing the "current" link as the user scrolls
        changeSelectedLink: function(e, direction) {
            
            var $activeSection = $(e.currentTarget),
                $activeLink;
                
            if (direction === "up") {
                $activeSection = $activeSection.prev();
            }
            
            $activeLink = this.$mainNav.find('a[href="#' + 
                $activeSection.attr("id") + '"]');
            
            this.$mainNav.find('a').removeClass('current');
            $activeLink.addClass('current');
        }
    };
    
    WOJ.portfolioGallery = {
        
        init: function() {            
            this.animating = false; // Used to prevent simultaneous animations
            this.cacheElements();
            this.bindEvents();
            this.$projects.not(':first-child').hide();
            this.$otherProjects.show();  
        },
        
        cacheElements: function() {
            this.$featuredProject    = $('#featured-project');
            this.$projects           = $('.project');
            this.$thumbnailGalleries = this.$projects.find('.thumbnail-gallery');
            this.$otherProjects      = $('#other-projects');
            this.$otherGallery       = this.$otherProjects.find('.thumbnail-gallery');
        },
        
        bindEvents: function() {            
            this.$otherGallery.on('click', 'a', $.proxy(this.swapProjects, 
                this));
            this.$thumbnailGalleries.on('click', 'a', $.proxy(this.swapImgs, 
                this));
        },
        
        // Swap out the currently featured portfolio project
        swapProjects: function(e) {
            
            var self     = this,
                link     = $(e.currentTarget),
                $project = $(link.attr('href'));

            // Only run the animation if not the currently featured project
            if (!link.hasClass('current') && !self.animating) {
                
                self.animating = true;
                
                self.$otherGallery.find('a').removeClass('current');
                link.addClass('current');
                
                // Scroll to the top of the projects area
                WOJ.utils.scrollTo(
                    self.$featuredProject, 300, function() {
                        
                        // Fade out current project
                        self.$featuredProject.find('.current')
                            .removeClass('current')
                            .fadeOut(600, function() {
                                
                                // And fade in the new one
                                $project.addClass('current')
                                    .fadeIn(600, function() {
                                        self.animating = false;
                                    });
                            });
                    }
                );
            }
            e.preventDefault();
        },
        
        // Swap out the featured image when clicking on another thumbnail
        swapImgs: function(e) {
            var self         = this,
                link         = $(e.currentTarget),
                newSrc       = link.attr('href'),
                $figure      = link.closest('.project').find('figure'),
                $currentImg  = $figure.find('img'),                
                $newImg      = $currentImg.clone(),
                visibleProps = {position: 'relative', zIndex: 2},
                hiddenProps  = {position: 'absolute', top: 0, left: 0, zIndex: 1};

            // Only run if we're clicking on a thumbnail of a different img
            if (($currentImg.attr('src') !==  newSrc) && !self.animating) {
                
                self.animating = true;
                $currentImg.css(visibleProps);

                // Absolutely position a new image behind the old one
                $newImg.css(hiddenProps)
                    .attr('src', newSrc)
                    .appendTo($figure.find('a'));
                
               // Fade out the original image and then remove it from the DOM
                $currentImg.fadeOut(500, function() {
                    $newImg.css(visibleProps);
                    $(this).remove();            
                    self.animating = false;
                });                 
            }
            e.preventDefault();
        }
        
    };
    
    WOJ.contactForm = {
        
        init: function() {
            this.successMsg = "Thank you! Your email has been submitted.";
            this.invalidMsg = "There were some problems with your submission.";
            this.errorMsg   = "We're sorry, your email could not be sent. " + 
                "Please try again later.";
            this.cacheElements();
            this.validate();            
        },
        
        cacheElements: function() {
            this.$submitMessage    = $('#submit-message');
            this.$messageContainer = this.$submitMessage.find('span');
            this.$loading          = $('#loading');
            this.$form             = $('#contact-form');
        },
        
        validate: function() {
            
            var self = this;
            
            self.$form.validate({
                
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
                            self.$loading.show();
                        },
                        success: function() {
                            self.showMessage("success", self.successMsg);
                            self.$loading.hide();
                            setTimeout(function() {
                                self.$submitMessage.fadeOut(700);
                            }, 8000);
                        },
                        error: function() {
                            self.showMessage("failure", self.errorMsg);
                            self.$loading.hide();
                        },
                        clearForm: true,
                        resetForm: true
                    };
                    $(form).ajaxSubmit(options);
                },
                
                invalidHandler: function() {
                    self.showMessage("failure", self.invalidMsg);
                }
            });
        },
        
        showMessage: function(type, message) {
            this.$messageContainer.text(message);
            this.$messageContainer.attr('class', type);
            this.$submitMessage.show();
        }
    };
    
    WOJ.init();
    
})(window, document, jQuery, Modernizr);