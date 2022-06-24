(function ($) {
    "use strict";

    $(document).ready(function () {

        var $window = $(window),
            $body = $('body'),
            isRtl = $body.hasClass('rtl');

        /*-----------------------------------------------------------------------------------*/
        /* For RTL Languages
         /*-----------------------------------------------------------------------------------*/
        if ($body.hasClass('rtl')) {
            $('.contact-number .fa-phone, .contact-number .fa-whatsapp, .more-details .fa-caret-right').addClass('fa-flip-horizontal');
        }

        /*-----------------------------------------------------------------------------------*/
        /* Cross Browser
         /*-----------------------------------------------------------------------------------*/
        $('.property-item .features span:last-child').css('border', 'none');
        $('.dsidx-prop-title').css('margin', '0 0 15px 0');
        $('.dsidx-prop-summary a img').css('border', 'none');

        /*-----------------------------------------------------------------------------------*/
        /* Main Menu Dropdown Control
        /*-----------------------------------------------------------------------------------*/
        $('ul.rh_menu__main_menu li').on({
            mouseenter: function () {
                $(this).children('ul').stop(true, true).slideDown(200);
            },
            mouseleave: function () {
                $(this).children('ul').stop(true, true).delay(50).slideUp(600);
            }
        });

        // Responsive Menu.
        $('.rh_menu__hamburger').on('click', function () {
            $('ul.rh_menu__responsive').slideToggle();
        });

        var sub_menu_parent = $('.rh_menu__responsive ul.sub-menu').parent();
        sub_menu_parent.prepend('<i class="fas fa-caret-down rh_menu__indicator"></i>');

        // Second Level
        $('ul.rh_menu__responsive > li .rh_menu__indicator').on('click', function (e) {
            e.preventDefault();
            $(this).parent().children('ul.sub-menu').slideToggle();
            $(this).toggleClass('rh_menu__indicator_up');
        });

        /*-----------------------------------------------------------------------------------*/
        /*	Autofocus user login
        /*-----------------------------------------------------------------------------------*/
        $('.user-nav .last').on('click', function () {
            setTimeout(function () {
                if ($('#username').hasClass('focus-class')) {
                    $('.focus-class').focus();
                }
            }, 500);
        });

        /*-----------------------------------------------------------------------------------*/
        /*	Hamburger
         /*-----------------------------------------------------------------------------------*/
        /**
         * forEach implementation for Objects/NodeLists/Arrays, automatic type loops and context options
         *
         * @private
         * @author Todd Motto
         * @link https://github.com/toddmotto/foreach
         * @param {Array|Object|NodeList} collection - Collection of items to iterate, could be an Array, Object or NodeList
         * @callback requestCallback      callback   - Callback function for each iteration.
         * @param {Array|Object|NodeList} scope=null - Object/NodeList/Array that forEach is iterating over, to use as the this value when executing callback.
         * @returns {}
         */
        var forEach = function (t, o, r) {
            if ("[object Object]" === Object.prototype.toString.call(t)) for (var c in t) Object.prototype.hasOwnProperty.call(t, c) && o.call(r, t[c], c, t); else for (var e = 0, l = t.length; l > e; e++) o.call(r, t[e], e, t)
        };

        var hamburgers = document.querySelectorAll(".hamburger");
        if (hamburgers.length > 0) {
            forEach(hamburgers, function (hamburger) {
                hamburger.addEventListener("click", function () {
                    this.classList.toggle("is-active");
                }, false);
            });
        }

        /*-----------------------------------------------------------------------------------*/
        /*	Flex Slider
        /*-----------------------------------------------------------------------------------*/
        if (jQuery().flexslider) {
            // Flex Slider for Homepage
            $('#home-flexslider .flexslider').flexslider({
                animation: "fade",
                slideshowSpeed: 7000,
                animationSpeed: 1500,
                directionNav: true,
                controlNav: false,
                keyboardNav: true,
                start: function (slider) {
                    slider.removeClass('loading');
                }
            });

            // Flex Slider for Featured Properties - Homepage
            $('#rh_featured_properties .rh_featured_properties__slider').flexslider({
                 slideshowSpeed: 5000,
                 animationSpeed: 1000,
                 directionNav: false,
                 slideshow: false,
                 controlNav: true,
                 keyboardNav: true,
                start: function (slider) {
                    slider.removeClass('loading');
                    $('.flexslider .clone').children().removeAttr("data-fancybox");
                }
            });
            
            // Flex Slider for Property Single Videos.
            const singlePropertyVideosSlider = $('.rh_wrapper_property_videos_slider'),
                singlePropertyVideosSliderItems = singlePropertyVideosSlider.find('.slides li');
            if( (singlePropertyVideosSliderItems.length > 1 ) ){
                singlePropertyVideosSlider.flexslider({
                    animation: "slide",
                    slideshow: false,
                    directionNav: true,
                    controlNav: false,
                    start: function (slider) {
                        slider.resize();
                        $('.flexslider .clone').children().removeAttr("data-fancybox");
                    },
                });
            }else {
                singlePropertyVideosSliderItems.css('display', 'block');
            }

            // Remove Flex Slider Navigation for Smaller Screens Like IPhone Portrait
            $('.slider-wrapper, .listing-slider').on({
                mouseenter: function () {
                    var mobile = $body.hasClass('probably-mobile');
                    if (!mobile) {
                        $('.flex-direction-nav').stop(true, true).fadeIn('slow');
                    }
                },
                mouseleave: function () {
                    $('.flex-direction-nav').stop(true, true).fadeOut('slow');
                }
            });

            // Flex Slider for Detail Page
            $('#property-detail-flexslider .flexslider').flexslider({
                animation: "slide",
                directionNav: true,
                controlNav: "thumbnails",
                start: function (slider) {
                    slider.resize();
                    $('.flexslider .clone').children().removeAttr("data-fancybox");
                }
            });

            // Flex Slider Gallery Post
            $('.listing-slider').flexslider({
                animation: "slide",
                prevText: '<i class="fas fa-angle-left"></i>',
                nextText: '<i class="fas fa-angle-right"></i>',
            });

            /* Property detail page slider variation two */
            $('#property-carousel-two').flexslider({
                animation: "slide",
                controlNav: false,
                animationLoop: false,
                slideshow: false,
                itemWidth: 120,
                itemMargin: 10,
                // move: 1,
                asNavFor: '#property-slider-two'
            });
            $('#property-slider-two').flexslider({
                animation: "slide",
                directionNav: true,
                controlNav: false,
                animationLoop: false,
                slideshow: false,
                sync: "#property-carousel-two",
                start: function (slider) {
                    slider.removeClass('loading');
                    $('.flexslider .clone').children().removeAttr("data-fancybox");
                }
            });
        }

        /*-----------------------------------------------------------------------------------*/
        /*	jCarousel
        /*-----------------------------------------------------------------------------------*/
        if (jQuery().jcarousel) {
            // Jcarousel for Detail Page
            jQuery('#property-detail-flexslider .flex-control-nav').jcarousel({
                vertical: true,
                scroll: 1
            });
        }

        /*-----------------------------------------------------------------------------------*/
        /*	Carousel - Elastislide
         /*-----------------------------------------------------------------------------------*/
        var param = {
            speed: 500,
            imageW: 245,
            minItems: 1,
            margin: 30,
            onClick: function ($object) {
                window.location = $object.find('a').first().attr('href');
                return true;
            }
        };

        function cstatus(a, b, c) {
            var temp = a.children("li");
            temp.last().attr('style', 'margin-right: 0px !important');
            if (temp.length > c) {
                b.elastislide(param);
            }
        }

        if (jQuery().elastislide) {
            var fp = $('.featured-properties-carousel .es-carousel-wrapper ul'),
                fpCarousel = $('.featured-properties-carousel .carousel');
            cstatus(fp, fpCarousel, 4);
        }

        /*-------------------------------------------------------*/
        /*	 Focus and Blur events with input elements
        /* -----------------------------------------------------*/
        var addFocusAndBlur = function ($input, $val) {
            $input.focus(function () {
                if ($(this).value == $val) {
                    $(this).value = '';
                }
            });

            $input.blur(function () {
                if ($(this).value == '') {
                    $(this).value = $val;
                }
            });
        };

        // Attach the events
        addFocusAndBlur(jQuery('#principal'), 'Principal');
        addFocusAndBlur(jQuery('#interest'), 'Interest');
        addFocusAndBlur(jQuery('#payment'), 'Payment');
        addFocusAndBlur(jQuery('#texes'), 'Texes');
        addFocusAndBlur(jQuery('#insurance'), 'Insurance');
        addFocusAndBlur(jQuery('#pmi'), 'PMI');
        addFocusAndBlur(jQuery('#extra'), 'Extra');

        /*-----------------------------------------------------------------------------------*/
        /*	Apply Bootstrap Classes on Comment Form Fields to Make it Responsive
         /*-----------------------------------------------------------------------------------*/
        $('#respond #submit, #dsidx-contact-form-submit').addClass('real-btn');
        $('.lidd_mc_form input[type=submit]').addClass('real-btn');
        $('.pages-nav > a').addClass('real-btn');
        $('.dsidx-search-button .submit').addClass('real-btn');
        $('.wpcf7-submit').addClass('real-btn');

        /*----------------------------------------------------------------------------------*/
        /* Contact Form AJAX validation and submission
         /* Validation Plugin : http://bassistance.de/jquery-plugins/jquery-plugin-validation/
         /* Form Ajax Plugin : http://www.malsup.com/jquery/form/
         /*---------------------------------------------------------------------------------- */
        if (jQuery().validate && jQuery().ajaxSubmit) {

            var submitButton = $('#submit-button'),
                ajaxLoader = $('#ajax-loader'),
                messageContainer = $('#message-container'),
                errorContainer = $("#error-container");

            var formOptions = {
                beforeSubmit: function () {
                    submitButton.attr('disabled', 'disabled');
                    ajaxLoader.fadeIn('fast');
                    messageContainer.fadeOut('fast');
                    errorContainer.fadeOut('fast');
                },
                success: function (ajax_response, statusText, xhr, $form) {
                    var response = $.parseJSON(ajax_response);
                    ajaxLoader.fadeOut('fast');
                    submitButton.removeAttr('disabled');
                    if (response.success) {
                        $form.resetForm();
                        messageContainer.html(response.message).fadeIn('fast');

                        setTimeout(function () {
                            messageContainer.fadeOut('slow')
                        },5000);

                        // call reset function if it exists
                        if (typeof inspiryResetReCAPTCHA == 'function') {
                            inspiryResetReCAPTCHA();
                        }

                        if( typeof CFOSData !== 'undefined' ){
                            setTimeout(function(){
                                window.location.replace(CFOSData.redirectPageUrl);
                            },1000);
                        }

                        if( typeof contactFromData !== 'undefined' ){
                            setTimeout(function(){
                                window.location.replace(contactFromData.redirectPageUrl);
                            },1000);
                        }

                    } else {
                        errorContainer.html(response.message).fadeIn('fast');
                    }
                }
            };

            // Contact page form
            $('#contact-form .contact-form').validate({
                errorLabelContainer: errorContainer,
                submitHandler: function (form) {
                    $(form).ajaxSubmit(formOptions);
                }
            });

            // Contact page form
            $('.cfos_contact_form').validate({
                errorLabelContainer: errorContainer,
                submitHandler: function (form) {
                    $(form).ajaxSubmit(formOptions);
                }
            });

            // Agent single page form
            $('#agent-single-form').validate({
                errorLabelContainer: errorContainer,
                submitHandler: function (form) {
                    $(form).ajaxSubmit(formOptions);
                }
            });
        }



        /* ---------------------------------------------------- */
        /*	Gallery Hover Effect
        /* ---------------------------------------------------- */
        $('.gallery-item figure').on({
            mouseenter: function () {
                var $currentFigure = $(this);
                var $mediaContainer = $currentFigure.find('.media_container');
                var $media = $mediaContainer.find('a');
                var $margin = -($media.first().height() / 2);
                $media.css('margin-top', $margin);
                var linkWidth = $media.first().width();
                var targetPosition = ($mediaContainer.width() / 2) - (linkWidth + 2);
                $mediaContainer.stop().fadeIn(300);
                $mediaContainer.find('a.link').stop().animate({'right': targetPosition}, 300);
                $mediaContainer.find('a.zoom').stop().animate({'left': targetPosition}, 300);
            },
            mouseleave: function () {
                var $currentFigure = $(this);
                var $mediaContainer = $currentFigure.find('.media_container');
                $mediaContainer.stop().fadeOut(300);
                $mediaContainer.find('a.link').stop().animate({'right': '0'}, 300);
                $mediaContainer.find('a.zoom').stop().animate({'left': '0'}, 300);
            }
        });

        /* ---------------------------------------------------- */
        /*  Sizing Header Outer Strip
        /* ---------------------------------------------------- */
        function outer_strip() {
            var $item = $('.outer-strip'),
                $c_width = $('.header-wrapper .container').width(),
                $w_width = $(window).width(),
                $i_width = ($w_width - $c_width) / 2;

            if ($body.hasClass('rtl')) {
                $item.css({
                    left: -$i_width,
                    width: $i_width
                });
            } else {
                $item.css({
                    right: -$i_width,
                    width: $i_width
                });
            }
        }

        outer_strip();
        $window.on('resize', function () {
            outer_strip();
        });

        /* ---------------------------------------------------- */
        /*	Notification Hide Function
         /* ---------------------------------------------------- */
        $(".icon-remove").on('click', function () {
            $(this).parent().fadeOut(300);
        });

        /*-----------------------------------------------------------------------------------*/
        /*	Image Hover Effect
         /*-----------------------------------------------------------------------------------*/
        if (jQuery().transition) {
            $('.zoom_img_box img').on({
                mouseenter: function () {
                    $(this).stop(true, true).transition({
                        scale: 1.1
                    }, 300);
                },
                mouseleave: function () {
                    $(this).stop(true, true).transition({
                        scale: 1
                    }, 150);
                }
            });
        }

        /*-----------------------------------------------------------------------------------*/
        /*	Grid and Listing Toggle View
         /*-----------------------------------------------------------------------------------*/
        if ($('.listing-grid-layout').hasClass('property-toggle')) {
            $('.listing-layout  .property-item-grid').hide();
            $('a.grid').on('click', function () {
                $('.listing-layout').addClass('property-grid');
                $('.property-item-grid').show();
                $('.property-item-list').hide();
                $('a.grid').addClass('active');
                $('a.list').removeClass('active');
            });
            $('a.list').on('click', function () {
                $('.listing-layout').removeClass('property-grid');
                $('.property-item-grid').hide();
                $('.property-item-list').show();
                $('a.grid').removeClass('active');
                $('a.list').addClass('active');
            });
        }

        /*-----------------------------------------------------------------------------------*/
        /* Calendar Widget Border Fix
         /*-----------------------------------------------------------------------------------*/
        var $calendar = $('.sidebar .widget #wp-calendar');
        if ($calendar.length > 0) {
            $calendar.each(function () {
                $(this).closest('.widget').css('border', 'none').css('background', 'transparent');
            });
        }

        var $single_listing = $('.sidebar .widget .dsidx-widget-single-listing');
        if ($single_listing.length > 0) {
            $single_listing.each(function () {
                $(this).closest('.widget').css('border', 'none').css('background', 'transparent');
            });
        }

        /*-----------------------------------------------------------------------------------*/
        /*	Tags Cloud
         /*-----------------------------------------------------------------------------------*/
        $('.tagcloud').addClass('clearfix');
        $('.tagcloud a').removeAttr('style');

        /* dsIDXpress */
        $('#dsidx-top-search #dsidx-search-form table td').removeClass('label');
        $('.dsidx-tag-pre-foreclosure br').replaceWith(' ');

        /*-----------------------------------------------------------------------------------*/
        /* Properties Sorting
         /*-----------------------------------------------------------------------------------*/
        function insertParam(key, value) {
            key = encodeURI(key);
            value = encodeURI(value);

            var kvp = document.location.search.substr(1).split('&');

            var i = kvp.length;
            var x;
            while (i--) {
                x = kvp[i].split('=');

                if (x[0] == key) {
                    x[1] = value;
                    kvp[i] = x.join('=');
                    break;
                }
            }

            if (i < 0) {
                kvp[kvp.length] = [key, value].join('=');
            }

            //this will reload the page, it's likely better to store this until finished
            document.location.search = kvp.join('&');
        }

        $('#sort-properties').on('change', function () {
            var key = 'sortby';
            var value = $(this).val();
            insertParam(key, value);
        });


        /*-----------------------------------------------------------------------------------*/
        /* Remove my property
		/*-----------------------------------------------------------------------------------*/
        $('a.remove-my-property').on('click', function (event) {
            event.preventDefault();
            var $this = $(this);
            var property_item = $this.closest('.my-property');
            var loader = $this.find('.loader');
            var remover = $this.find('.remove');
            var ajax_response = property_item.find('.ajax-response');

            remover.hide();
            loader.css('display', 'inline-block');
            $this.css('cursor', 'default');

            var remove_property_request = $.ajax({
                url: $this.attr('href'),
                type: "POST",
                data: {
                    property_id: $this.data('property-id'),
                    action: "remove_my_property"
                },
                dataType: "json"
            });

            remove_property_request.done(function (response) {
                loader.hide();
                if (response.success) {
                    property_item.remove();
                } else {
                    remover.show();
                    $this.css('cursor', 'pointer');
                    ajax_response.text(response.message);
                }
            });

            remove_property_request.fail(function (jqXHR, textStatus) {
                loader.hide();
                remover.show();
                $this.css('cursor', 'pointer');
                ajax_response.text("Request Failed: " + textStatus);
            });
        });

        /*-----------------------------------------------------------------------------------*/
        /* Sticky-kit
         /* URL: https://github.com/leafo/sticky-kit
         /*-----------------------------------------------------------------------------------*/
        var makeSticky = function () {
            var screenWidth = $(window).width();
            if (768 <= screenWidth) {
                $('.compare-properties-column .property-thumbnail').stick_in_parent()
                    .on("sticky_kit:stick", function (e) {
                        $('.compare-template .compare-properties-column > p:nth-child(odd)').css({
                            'background': '#eeeeee'
                        });
                        $('.compare-template .compare-properties-column > p:nth-child(even)').css({
                            'background': '#ffffff'
                        });
                        var heightThumbnail = $('.compare-properties-column .property-thumbnail').height();
                        $('.compare-properties-column > div:nth-child(2)').css({
                            'height': heightThumbnail
                        });
                    })
                    .on("sticky_kit:unstick", function (e) {
                    });
                $('.compare-feature-column .property-thumbnail').stick_in_parent()
                    .on("sticky_kit:stick", function (e) {
                        $('.compare-template .compare-feature-column > p:nth-child(odd)').css({
                            'background': '#eeeeee'
                        });
                        $('.compare-template .compare-feature-column > p:nth-child(even)').css({
                            'background': '#ffffff'
                        });
                        var heightEmptyThumbnail = $('.compare-properties-column .property-thumbnail').height();
                        $('.compare-feature-column > div:nth-child(2)').css({
                            'height': heightEmptyThumbnail
                        });
                    })
                    .on("sticky_kit:unstick", function (e) {
                    });
            } else {
                $('.compare-properties-column .property-thumbnail').trigger("sticky_kit:detach");
                $('.compare-feature-column .property-thumbnail').trigger("sticky_kit:detach");
            }
        };
        makeSticky();
        // Execute again when browser resizes.
        $window.on('resize', function () {
            makeSticky();
        });


        /*-----------------------------------------------------------------------------------*/
        /* Optima Express IDX Support
         /*-----------------------------------------------------------------------------------*/
        $(".ihf-grid-result-container .ihf-grid-result-photocount")
            .contents()
            .filter(function () {
                return this.nodeType !== 1;
            })
            .wrap("<span></span>");

        $('.ihf-grid-result-mlsnum-proptype').parent().parent().find('.col-xs-3').hide();
        $('.ihf-grid-result-mlsnum-proptype').parent().parent().find('.col-xs-9').toggleClass('col-xs-12');
        $('#ihf-main-container .ihf-detail-back-to-results a').html('<span class="fas fa-angle-left"></span><span class="rh_back-link"> Back to Results</span>');
        $("#ihf-sort-values").parent().on('click', function() {
            $("#ihf-sort-values").fadeToggle();
        });
        $("#ihf-main-container").on('mouseleave', function() {
            $("#ihf-sort-values").fadeOut();
        });

        /*-------------------------------------------------------*/
        /*	Advanced Search Button - Search Form Over Image Variation
         /* -----------------------------------------------------*/
        $('.SFOI__advanced-expander').on('click', function (e) {

            var upDownArrow = $(this).find('i');
            var advancedFieldsWrapper = $(this).parent('.SFOI__form-wrapper').find('.SFOI__advanced-fields-wrapper');

            if (upDownArrow.hasClass('fa-angle-down')) {
                advancedFieldsWrapper.slideDown();
                upDownArrow.removeClass('fa-angle-down').addClass('fa-angle-up');
            } else {
                advancedFieldsWrapper.slideUp();
                upDownArrow.removeClass('fa-angle-up').addClass('fa-angle-down');
            }
        });

        /*-------------------------------------------------------*/
        /*	More Options in Search Form
         /* -----------------------------------------------------*/
        $('.more-option-trigger > a').on('click', function (e) {
            e.preventDefault();
            var triggerIcon = $(this).find('i');
            var moreOptionsWrapper = $('.more-options-wrapper');
            if (triggerIcon.hasClass('fa-plus-square')) {
                triggerIcon.removeClass('fa-plus-square').addClass('fa-minus-square');
                // moreOptionsWrapper.removeClass('collapsed');
                moreOptionsWrapper.slideDown(200);
            } else if (triggerIcon.hasClass('fa-minus-square')) {
                triggerIcon.removeClass('fa-minus-square').addClass('fa-plus-square');
                // moreOptionsWrapper.addClass('collapsed');
                moreOptionsWrapper.slideUp(200);
            }
        });

        /*-------------------------------------------------------*/
        /*	More Fields in Search Form
         /* -----------------------------------------------------*/
        $('.more-fields-trigger > a').on('click', function (e) {
            var triggerIcon = $(this).find('i');
            var triggerSpan = $(this).find('span');
            var moreFieldsWrapper = $('.more-fields-wrapper');
            if (triggerIcon.hasClass('fa-plus-square-o')) {
                triggerIcon.removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
                moreFieldsWrapper.removeClass('collapsed');
                triggerSpan.text(localized.less_search_fields);
            } else if (triggerIcon.hasClass('fa-minus-square-o')) {
                triggerIcon.removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
                moreFieldsWrapper.addClass('collapsed');
                triggerSpan.text(localized.more_search_fields);

            }
            e.preventDefault();
        });

        /*-----------------------------------------------------------------------------------*/
        /*	Scroll to Top
         /*-----------------------------------------------------------------------------------*/
        $(function () {
            var scroll_anchor = $('#scroll-top'),
                post_nav = $('.inspiry-post-nav');

            $window.on('scroll', function () {
                if ($(window).width() > 980) {
                    if ($(this).scrollTop() > 250) {
                        scroll_anchor.fadeIn('fast');
                        post_nav.fadeIn('fast');
                        return;
                    }
                }
                scroll_anchor.fadeOut('fast');
                post_nav.fadeOut('fast');
            });

            scroll_anchor.on('click', function (event) {
                event.preventDefault();
                $('html, body').animate({scrollTop: 0}, 'slow');
            });
        });

        /*-----------------------------------------------------------------------------------*/
        /* Home page properties pagination
         /*-----------------------------------------------------------------------------------*/
        var homePropertiesSection = $('#home-properties-section');

        // if homepage
        if (homePropertiesSection.length && homePropertiesSection.hasClass('ajax-pagination')) {

            $(document).on('click', '#home-properties-section-wrapper .pagination > a', function (e) {
                e.preventDefault();
                var homePropertiesContainer = $('#home-properties-section-wrapper', homePropertiesSection);
                var paginationLinks = $('.pagination > a', homePropertiesSection);
                var svgLoader = $('.svg-loader', homePropertiesSection);
                var currentButton = $(this);
                svgLoader.slideDown('fast');
                homePropertiesContainer.fadeTo('slow', 0.5);
                paginationLinks.removeClass('current');
                //  currentButton.addClass('current');
                homePropertiesContainer.load(
                    currentButton.attr('href') + ' ' + '#home-properties-section-inner',
                    function (response, status, xhr) {
                        if (status == 'success') {
                            homePropertiesContainer.fadeTo('slow', 1);
                            svgLoader.slideUp('fast');

                            $('html, body').animate({
                                scrollTop: homePropertiesSection.find('#home-properties-section-wrapper').offset().top-32
                            }, 1000);

                        } else {
                            homePropertiesContainer.fadeTo('slow', 1);
                        }
                    }
                );
            });
        }

        /*-----------------------------------------------------------------*/
        /* Sticky Header
        /*-----------------------------------------------------------------*/
        function classicStickyHeader() {
            if (window.innerWidth > 979) {
                const stickyHeader = $('.rh_classic_sticky_header'),
                      getHeaderHeight = $('.header-wrapper').outerHeight();

                $(document).on('scroll', function () {
                    if ($window.scrollTop() > getHeaderHeight) {
                        stickyHeader.addClass('sticked');
                    } else {
                        stickyHeader.removeClass('sticked');
                    }
                });
            }
        }

        classicStickyHeader();
        $(window).on('resize',classicStickyHeader);

        /*-----------------------------------------------------------------*/
        /* Property Floor Plans
         /*-----------------------------------------------------------------*/
        $('.floor-plans-accordions .floor-plan:first-child').addClass('current')
            .children('.floor-plan-content').css('display', 'block').end()
            .find('i.fas').removeClass('fa-plus').addClass('fa-minus');

        $('.floor-plan-title').on('click', function () {
            var parent_accordion = $(this).closest('.floor-plan');
            if (parent_accordion.hasClass('current')) {
                $(this).find('i.fas').removeClass('fa-minus').addClass('fa-plus');
                parent_accordion.removeClass('current').children('.floor-plan-content').slideUp(300);
            } else {
                $(this).find('i.fas').removeClass('fa-plus').addClass('fa-minus');
                parent_accordion.addClass('current').children('.floor-plan-content').slideDown(300);
            }
            var siblings = parent_accordion.siblings('.floor-plan');
            siblings.find('i.fas').removeClass('fa-minus').addClass('fa-plus');
            siblings.removeClass('current').children('.floor-plan-content').slideUp(300);
        });

        /*-----------------------------------------------------------------*/
        /* Support for Mortgage Calculator - https://wordpress.org/plugins/mortgage-calculator/
         /*-----------------------------------------------------------------*/
        $('#mc-submit').addClass('real-btn');

        /*-----------------------------------------------------------------*/
        /* Support for Inspiry Memberships
         /*-----------------------------------------------------------------*/
        if ($('#ims-btn-close')) {
            $('#ims-btn-close').attr('data-dismiss', 'modal');
        }

        /*-----------------------------------------------------------------------------------*/
        /*  Property Ratings
         /*-----------------------------------------------------------------------------------*/
        if (jQuery().barrating) {
            $('#rate-it').barrating({
                theme: 'fontawesome-stars',
                initialRating: 5,
            });
        }

        /*-----------------------------------------------------------------------------------*/
        /*  Advance Search Form
        /*-----------------------------------------------------------------------------------*/
        var advanceSearch = $('.rh_classic_advance_search_form .option-bar');
        var j = 0;
        var i = 0;

        advanceSearch.each(function () {
            if (i < 6) {
                if ($(this).hasClass('hide-fields')) {
                    j++;
                }
            }
            i++;
        });

        var advanceSearchFields = $('.rh_classic_advance_search_form .rh-search-field.option-bar:not(.hide-fields):nth-of-type(-n+' + (j + 5) + ')');
        advanceSearchFields.removeClass('small').addClass('large');

        if ($('.rh_classic_advance_search_form .rh_field_one_others').hasClass('large')) {
            $('.rh_classic_advance_search_form .rh_field_one_rent').addClass('large').removeClass('small');
        } else if ($('.rh_classic_advance_search_form .rh_field_one_rent').hasClass('large')) {
            $('.rh_classic_advance_search_form .rh_field_one_others').addClass('large').removeClass('small');
        }

        if ($('.rh_classic_advance_search_form .rh_field_two_others').hasClass('large')) {
            $('.rh_classic_advance_search_form .rh_field_two_rent').addClass('large').removeClass('small');
        } else if ($('.rh_classic_advance_search_form .rh_field_two_rent').hasClass('large')) {
            $('.rh_classic_advance_search_form .rh_field_two_others').addClass('large').removeClass('small');
        }

        var advanceSearchFieldsCollapsed = $('.rh_classic_advance_search_form .rh-search-field.option-bar.small:not(.hide-fields):nth-of-type(n+' + (j + 6) + ')');

        if($('.advance-search.widget .more-fields-wrapper').hasClass('collapsed')){
            advanceSearchFieldsCollapsed.detach().prependTo('.more-fields-wrapper');
        }

        var advanceFieldsSFOI = $('.SFOI__top-fields-container .rh-search-field.option-bar:nth-of-type(n+4)');
        advanceFieldsSFOI.detach().prependTo('.SFOI__advanced-fields-container');

        if ( $('.SFOI__advanced-fields-container').children().length == 0 ) {
            $('.SFOI__advanced-expander').hide();
        }else{
            $('.SFOI__advanced-expander').show();
        }

        $('.SFOI__form .rh_field_one_rent').insertAfter($('.SFOI__form .rh_field_one_others'));
        $('.SFOI__form .rh_field_two_rent').insertAfter($('.SFOI__form .rh_field_two_others'));

        $window.on('load', function () {
            /*-----------------------------------------------------------------------------------*/
            /* Compare Listings
            /*-----------------------------------------------------------------------------------*/
            var assignHeights = function () {
                // Add heights to the first column elements.
                var columnHeight = -1;
                var headingHeight = -1;
                var priceHeight = -1;

                $('.compare-template .span2 .property-thumbnail img').each(function () {
                    if ($(this).attr("complete", "complete")) {
                        headingHeight = headingHeight > $(this).parents('.property-thumbnail').find('.property-title').height() ? headingHeight : $(this).parents('.property-thumbnail').find('.property-title').height();
                        priceHeight = priceHeight > $(this).parents('.property-thumbnail').find('.property-price').height() ? priceHeight : $(this).parents('.property-thumbnail').find('.property-price').height();
                    } else {
                        $(this).on('load', function () {
                            headingHeight = headingHeight > $(this).parents('.property-thumbnail').find('.property-title').height() ? headingHeight : $(this).parents('.property-thumbnail').find('.property-title').height();
                            priceHeight = priceHeight > $(this).parents('.property-thumbnail').find('.property-price').height() ? priceHeight : $(this).parents('.property-thumbnail').find('.property-price').height();
                        });
                    }
                });

                $('.compare-template .property-thumbnail .property-title').css({
                    height: headingHeight
                });

                $('.compare-template .property-thumbnail .property-price').css({
                    height: priceHeight
                });

                $('.compare-template .span2 .property-thumbnail img').each(function () {
                    if ($(this).attr("complete", "complete")) {
                        columnHeight = columnHeight > $(this).parents('.property-thumbnail').outerHeight() ? columnHeight : $(this).parents('.property-thumbnail').outerHeight();
                    } else {
                        $(this).on('load', function () {
                            columnHeight = columnHeight > $(this).parents('.property-thumbnail').outerHeight() ? columnHeight : $(this).parents('.property-thumbnail').outerHeight();
                        });
                    }
                });

                $('.compare-template .span2 .property-thumbnail').css({
                    height: columnHeight
                });
            };
            assignHeights();

            var screenWidth = $(window).width();

            $('.compare-template .compare-feature-column').fadeTo(600, 1);
            $('.compare-template .compare-properties-column').fadeTo(600, 1);

            // Add equal heights to all the rows of all the columns
            var rowHeight = -1;

            $('.compare-template .span2 p').each(function () {
                rowHeight = rowHeight > $(this).height() ? rowHeight : $(this).height();
            });

            if (768 <= screenWidth) {
                $('.compare-template .span2 > p').css({
                    height: rowHeight
                });
            }

            var imageHeight = -1;
            $('.home-features-section .span3 .feature-img').each(function () {
                if ($(this).prop("complete", "complete")) {
                    imageHeight = imageHeight > $(this).outerHeight() ? imageHeight : $(this).outerHeight();
                } else {
                    $(this).on('load', function () {
                        imageHeight = imageHeight > $(this).outerHeight() ? imageHeight : $(this).outerHeight();
                    });
                }
            });

            $('.home-features-section .span3 .feature-img').css({
                height: imageHeight
            });
        });

        /*-----------------------------------------------------------------------------------*/
        /* Fixes - Advance Search form fields disabling issue on hitting browser back button.
         /*-----------------------------------------------------------------------------------*/
        $window.on("pageshow", function (event) {
            if (event.originalEvent.persisted) {
                window.location.reload()
            }
        });

        function parallax() {
            var docHeight = $(document).height();
            var scrolled = $window.scrollTop();

            var parallaxSpeed = (100 - (400 * (scrolled / docHeight)));

            $('.rh_parallax_sfoi').css('background-position', 'center ' + parallaxSpeed + '%');
        }

        $window.on('scroll', function () {
            parallax();
        });
    });

    /*-------------------------------------------------------*/
    /*  Stick Half Map
    /*------------------------------------------------------*/
    function setHalfMapFixed( bodyClass) {

        if($('body').hasClass(bodyClass)){

            var parentBodyClass = $('.'+bodyClass); // body class

            var getHeaderHeight = parentBodyClass.find('.inspiry_half_map_header_wrapper').height(); // get banner height


            thisContentHeight = 0;
            if ($( ".rh_content_above_footer" ) && $( ".rh_content_above_footer" ).length ) {
                var thisContentHeight = $('.rh_content_above_footer').outerHeight(true);
            }

            var adminbarMargin = 0;
            if($('body').hasClass('admin-bar')){
                adminbarMargin = 32;
            }

            var thisMapWrapper = parentBodyClass.find('#map-head');// map wrapper

            var getLoadOffSet = $(document).scrollTop(); // get header offset on time of document load



            thisMapWrapper.css('top',adminbarMargin + Math.max(0 ,getHeaderHeight - getLoadOffSet));

            var thisStickyFooter = parentBodyClass.find('.rh_sticky_wrapper_footer'); // footer wrapper

            var getFooterHeight = thisStickyFooter.height(); //get footer height



            var footerFromTop = thisStickyFooter.offset().top - window.innerHeight; // get offset of footer from top


            if(getLoadOffSet + thisContentHeight + 55 > footerFromTop){
                thisMapWrapper.css('top',footerFromTop - getLoadOffSet - thisContentHeight - 55);
            }

            $(document).on('scroll',function () {
                var getOffSet = $(document).scrollTop(); // get scroll off set



                var currentOffSet = getHeaderHeight - getOffSet;

                currentOffSet =  Math.max(0,currentOffSet); //set current offset of the map to scroll till map reached top


                thisMapWrapper.css('top',adminbarMargin+currentOffSet);

                var setOffSet =  getOffSet + thisContentHeight + 55 ; // get current offset value of footer on scroll


                if(setOffSet > footerFromTop){
                    thisMapWrapper.css('top',footerFromTop - setOffSet);
                }

            });

        }
    }

    /*-------------------------------------------------------*/
    /*	Isotope
    /*------------------------------------------------------*/
    function inspiryIsotopeGallery() {
        var container = $('.isotope'),
            filters   = $('#filter-by'),
            filterItems = filters.find('li'),
            filterLinks = filters.find('a');

        /* to fix floating bugs due to variation in height */
        setTimeout(function () {
            container.isotope({
                filter: "*",
                layoutMode: 'fitRows',
                itemSelector: '.isotope-item',
                animationEngine: 'best-available'
            });
        }, 1000);

        filterLinks.on('click', function (event) {
            var selector = $(this);
            event.preventDefault();
            container.isotope({filter: '.' + selector.attr('data-filter') });
            selector.addClass('active');
            filterLinks.removeClass('active');
            filterItems.removeClass('current-cat');
        });
    }

    // Code to run on window load.
    $(window).on('load',  function () {
        setHalfMapFixed('inspiry_half_map_fixed');

        if (jQuery().isotope) {
            inspiryIsotopeGallery();
        }
    });
    $(window).on('resize',function() {
        setHalfMapFixed('inspiry_half_map_fixed');
    });


    /**
     * Forgot Form
     */
    $(document).on('ready', function () {
        $('.login-register #forgot-form').slideUp('fast');
        $('.login-register .toggle-forgot-form').on('click', function (event) {
            event.preventDefault();
            $('.login-register #forgot-form').slideToggle('fast');
        });
    });

})(jQuery);