document.documentElement.className = document.documentElement.className.replace(/\bno-js\b/g, "") + "js"

if (window.location.hash) { setTimeout(function () { window.scrollTo(0, 0); }, 2); }

AOS.init();

jQuery(document).ready(function ($) {

    /*-----------------------------------------------------------------------------GLOBAL ON LOAD----*/

    var LazyLoading = (function () {
        var instance = new LazyLoad();

        function lazyBGImages() {
            var $bgImages = $('[data-bg]:not(.lazy)');
            if ($bgImages.length) {
                $bgImages.each(function () {
                    $(this).addClass('lazy');
                });
            }
            instance.update();
        }

        function update() {
            lazyBGImages();
        }

        lazyBGImages();

        return {
            update: update
        }
    }());

    var allFiltersDropdowns = (function () {
        // Dropdown Button Blick
        $(document).on('click', '.filter-dd__trigger', function () {
            var $this = $(this);
        if ($this.hasClass('active')) {
                $this.removeClass('active');
                $this.parent().find(".filter-dd__list").slideUp(250);
            } else {
                $(".filter-dd__trigger").removeClass('active');
                $(".filter-dd__list").slideUp(250);
                $this.addClass('active');
                $this.parent().find(".filter-dd__list").slideDown(250);
            }
            
        });

        // Buttons within the dropdown
        $(document).on('click', '.filter-dd__list span', function () {
        $(this).closest('.filter-dd__list').find('span').removeClass('active');
        $(this).addClass('active');
        var text = $(this).text();
        var filterName = $(this).closest('.filter-dd').find('.filter-dd__trigger span');
        $(filterName).html(text);
        $(this).closest('.filter-dd').find(".filter-dd__trigger").removeClass('active');
        $(this).closest('.filter-dd').find(".filter-dd__list").slideUp(250);

            $('html, body').animate({
                scrollTop: $('.archive-content').offset().top + $('header.gheader').height() - 350
            }, 1000);

        });

    }());

    var resourceFilters = (function () {
        // Save the original content when the page loads
        originalContent = $('.resource-posts').html();

        // Filter button click event
        $('#filter-button').on('click', function() {

            //Resources
            var postName1 = $('.solutions-choice .filter-dd__list span.active').data('post-name');
            var postName2 = $('.spend-areas-choice .filter-dd__list span.active').data('post-name');
            var postName3 = $('.industries-choice .filter-dd__list span.active').data('post-name');
            var post_type = $('.content-type-choice .filter-dd__list span.active').data('post-type');

            $(".filter-dd__trigger").removeClass('active');
            $(".filter-dd__list").slideUp(250);

            filterPosts(postName1, postName2, postName3, post_type);

            $('.resource-posts').parent().find(".load-more-container").addClass("hide");


        });

        // Clear button click event
        $('#clear-button').on('click', function() {
            // Clear all selected filters and reset the filtered posts container
            $('.filter-dd__list').find('span').removeClass('active');
            $('.solutions-choice .filter-dd__trigger span').text('Solutions');
            $('.spend-areas-choice .filter-dd__trigger span').text('Spend Areas');
            $('.industries-choice .filter-dd__trigger span').text('Industries');
            $('.content-type-choice .filter-dd__trigger span').text('Content');
            $('.resource-posts').html(originalContent);

            $(".filter-dd__trigger").removeClass('active');
            $(".filter-dd__list").slideUp(250);

            $('.resource-posts').parent().find(".load-more-container").removeClass("hide");

            LazyLoading.update();
        });    

        //Resources Archive
        function filterPosts(postName1, postName2, postName3, post_type) {
            $.ajax({
                url: ajaxURL,
                type: 'POST',
                data: {
                    action: 'filter_posts',
                    post_name_1: postName1,
                    post_name_2: postName2,
                    post_name_3: postName3,
                    post_type: post_type
                },
                success: function(response) {
                    // Handle the response and display filtered posts
                    $('.resource-posts').html(response);
                    LazyLoading.update();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

        } 

     }());


    var caseStudyFilters = (function () {

        // Filter button click event
        $('#filter-case-studies').on('click', function() {
            //Resources
            var postName1 = $('.solutions-choice .filter-dd__list span.active').data('post-name');
            var postName2 = $('.spend-areas-choice .filter-dd__list span.active').data('post-name');
            var postName3 = $('.industries-choice .filter-dd__list span.active').data('post-name');

            $(".filter-dd__trigger").removeClass('active');
            $(".filter-dd__list").slideUp(250);

            filterCaseStudies(postName1, postName2, postName3);

            $('.resource-posts').parent().find(".load-more-container").addClass("hide");


        });

        //Case Studies Archive
        function filterCaseStudies(postName1, postName2, postName3) {
            $.ajax({
                url: ajaxURL,
                type: 'POST',
                data: {
                    action: 'filter_case_studies',
                    post_name_1: postName1,
                    post_name_2: postName2,
                    post_name_3: postName3
                },
                success: function(response) {
                    // Handle the response and display filtered posts
                    $('.resource-posts').html(response);
                    LazyLoading.update();
                    console.log(postName1 + postName2 + postName3);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

        } 

    
    }());

    var SmoothScroll = (function () {
        var $anchorLinks = $('a[href^="#"]').not('a[href="#"]');

        $('a[href="#"]').click(
            function (e) { e.preventDefault(); return; }
        );

        function goTo(target) {
            if (target === "" || !$(target).length) { return; }
            var scrollPos = typeof target === 'number' ? target : $(target).offset().top;

            if (window.innerWidth >= 720) {
                scrollPos -= $('header').outerHeight();
            } else {
                scrollPos -= $('header').outerHeight() * 2;
            }

            $('html, body').stop().animate({
                'scrollTop': scrollPos - 32
            }, 1200, 'swing', function () {
                if (typeof target === 'string') {

                    if (window.location.hash) {
                        // window.location.hash = target;
                    }
                }
            });
        }

        if (window.location.hash) {
            setTimeout(function () {
                goTo(window.location.hash);
            }, 500);
        }

        if ($anchorLinks.length) {
            $anchorLinks.on('click', function (e) {
                if (!$("#" + this.hash.replace('#', '')).length) { return; }
                e.preventDefault();
                goTo(this.hash);
            });
        }

        return { to: goTo }
    }());

    var Forms = (function () {
        var InputMasks = (function () {
            var $masks = $('[data-mask]');
            if (!$masks.length) { return; }

            /**
             * Key Codes:
             * 8    - backspace
             * 13   - enter
             * 16   - shift
             * 18   - alt
             * 20   - caps
             * 27   - esc
             * 37   - left arrow
             * 38   - up arrow
             * 39   - right arrow
             * 40   - down arrow
             * 46   - delete
             **/
            var exclude_keys = [8, 13, 16, 18, 20, 27, 37, 38, 39, 40, 46];

            $('[data-mask]').keyup(function (e) {
                //console.log(e.keyCode);
                if (exclude_keys.indexOf(e.keyCode) > -1) { return; }

                switch (this.dataset.mask) {
                    case 'digits':
                        var x = this.value.replace(/\D/g, '');
                        this.value = x;
                        break;
                    case 'phone':
                        var x = this.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
                        //console.log(x);
                        this.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
                        break;
                    case 'ssn': {
                        var x = this.value.replace(/\D/g, '').match(/^(\d{0,3})(\d{0,2})(\d{0,4})/);
                        this.value = !x[2] ? x[1] : x[1] + '-' + x[2] + '-' + x[3];
                    }
                }
            });
        }());

        //Plugin used for form validation
        var parselyOptions = {
            classHandler: function (parsleyField) {
                var $element = parsleyField.$element;
                if ($element.parent().hasClass('select-menu')) {
                    return $element.parent();
                }
                return $element;
            },
            errorsContainer: function (parsleyField) {
                var $element = parsleyField.$element;
                var $fieldContainer = $element.closest('.form-field');
                if ($fieldContainer) {
                    return $fieldContainer;
                }
            }
        };

        //Global function to set form state classes
        var formStates = (function () {
            $formInputs = $('form :input');
            if (!$formInputs.length) { return; }

            $formSelectMenus = $('.select-menu select, .ginput_container_select select');

            function isGFormInput($el) {
                return $el.parent().hasClass('ginput_container') ? $el.parent().parent() : $el;
            }

            function setFilled($input) {
                $input.addClass('filled');
            }

            function removeFilled($input) {
                $input.removeClass('filled');
            }

            function setFocused() {
                $(this).addClass('focused');
            }

            function removeFocused() {
                $(this).removeClass('focused');
            }

            function checkInput(e) {
                if (this.type == 'button' ||
                    this.type == 'range' ||
                    this.type == 'submit' ||
                    this.type == 'radio' ||
                    this.type == 'checkbox' ||
                    this.type == 'reset') { return; }

                var $this = $(this);
                var $parent = $this.parent();
                var is_selectMenu = $parent.hasClass('select-menu') || $parent.hasClass('ginput_container_select');

                var $input = is_selectMenu ? $parent : $this;

                switch (this.type) {
                    case 'select-one':
                    case 'select-multiple':
                        if (this.value !== '') {
                            setFilled($input);
                        } else {
                            removeFilled($input);
                        }
                        break;
                    default:
                        if (this.value !== '') {
                            setFilled($input);
                        } else {
                            removeFilled($input);
                        }
                        break;
                }
            }

            $formInputs.each(checkInput);
            $formInputs.on('change', checkInput);
            $formInputs.on('focus', setFocused);
            $formInputs.on('blur', removeFocused);
            $formSelectMenus.on('focus', setFocused);
            $formSelectMenus.on('blur', removeFocused);

        }());
        return { options: parselyOptions }
    }());

    //Global function top open / close lightboxes
    var PDMLightbox = (function () {
        //Lightbox reset - This lightbox is empty and present on all pages
        var $lightbox = $('.pdm-lightbox--reset');

        //it's content can be filled from various sources
        //after close, the content is wiped
        var $lightbox_content = $('.pdm-lightbox--reset .pdm-lightbox__content');

        $('body').on('click', '[data-lightbox-iframe],[data-lightbox-content],[data-lightbox-target],.lightbox-trigger', function (e) {

            e.preventDefault();

            var iframe = $(this).data('lightbox-iframe');

            if (iframe) {
                var youtubePattern = /(?:http?s?:\/\/)?(?:www\.)?youtu(be\.com\/|\.be\/)(embed\/(.+)(\?.+)?|watch\?v=(.+)(\&.+)?)/g;
                var vimeoPattern = /(?:http?s?:\/\/)?:\/\/(www\.|player\.)?vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|video\/|)(\d+)(?:|\/\?)/g;

                if (youtubePattern.test(iframe)) {
                    classes += ' youtube-vid'

                    replacement = '<div class="spacer"><iframe width="560" height="315" frameborder="0" allowfullscreen src="//www.youtube.com/embed/$3?rel=0&autoplay=1&modestbranding=1&iv_load_policy=3" /></div>';

                    iframe = iframe.replace(youtubePattern, replacement);

                }

                if (vimeoPattern.test(iframe)) {

                    classes += ' vimeo-vid'

                    replacement = '<div class="spacer"><iframe width="560" height="315" frameborder="0" allowfullscreen src="//player.vimeo.com/video/$3?rel=0&autoplay=1&modestbranding=1&iv_load_policy=3" /></div>';

                    iframe = iframe.replace(vimeoPattern, replacement);

                }

                $lightbox_content.html('<div class="video-embed">' + iframe + '</div>');
            } else {
                if ($(this).data('lightbox-content')) {
                    var content = $(this).data('lightbox-content');
                } else if ($(this).data('lightbox-target')) {
                    var target = $(this).data('lightbox-target');
                    var content = $('#' + target).html();
                } else {
                    var content = $(this).next('.lightbox-content').html();
                }
                $lightbox_content.html(content);
            }

            var classes = $(this).data('lightbox-classes');
            $lightbox.addClass('active').addClass(classes);

        });

        function closeModal($lightbox) {
            $lightbox.removeClass('active');
            $('body').removeClass('noScroll');
            //wait before removing classes till lightbox closses
            if ($lightbox.hasClass('pdm-lightbox--reset')) {
                setTimeout(function () {
                    $lightbox.find('.pdm-lightbox__content').empty();
                    $lightbox.attr('class', 'pdm-lightbox pdm-lightbox--reset');
                }, 750);
            }
        }

        function openModal($lightbox) {
            $lightbox.addClass('active');
            $('body').addClass('noScroll');
        }

        function updateModal($lightbox, $content) {
            $lightbox.find('.pdm-lightbox__content').html($content);
        }

        $('.pdm-lightbox').on('click', function (e) {
            if (e.target == this) {
                closeModal($(this));
            }
        });

        $('.pdm-lightbox__close').click(function (e) {
            e.stopPropagation();
            closeModal($(this).closest('.pdm-lightbox'));
        });
        return {
            close: closeModal,
            open: openModal,
            update: updateModal
        };
    }());

    //******************************************************Everything under this is optional, feel free to delete

    var Header = (function () {
        var $body = $('body');
        var $header = $('header.gheader');
        var $nav = $header.find('nav.global');
        var $adminBar = $('#wpadminbar');

        var header_height = $header.innerHeight();
        if ($adminBar.length) { header_height += $adminBar.innerHeight(); }
        if (window.innerWidth < 960) { $nav.css({ marginTop: header_height }); }

        var BurgerMenu = (function () {
            var $burgerMenu = $header.find('.menu-burger');

            var $text = $burgerMenu.find('.menu-burger__text');

            function activate() {
                $burgerMenu.addClass('active').attr('title', 'Close');
                $text.text('Close');
                $nav.addClass('active');
                $body.addClass('no-scroll');

                var styles = { position: 'fixed' };
                if ($adminBar.length) { styles.top = $adminBar.innerHeight(); }

                $header.css(styles);
                $body.css({ marginTop: $header.innerHeight() });
            }

            function reset() {
                $burgerMenu.removeClass('active').attr('title', 'Menu');
                $text.text('Menu');
                $nav.removeClass('active').find('.active').removeClass('active');
                $body.removeClass('no-scroll');

                var styles = { position: 'sticky' };
                if ($adminBar.length) { styles.top = $adminBar.innerHeight() };

                $header.css(styles);
                $body.css({ marginTop: 0 });
            }

            $burgerMenu.click(function () {
                var $this = jQuery(this);
                // if ($this.hasClass('active')) { console.log('----- IFF -----'); reset(); } else { console.log('----- else -----');
                //  activate(); }
            });

            return {
                close: reset,
                open: activate
            }
        }());

        /*var DropdownMenus = (function () {
            var $menus = $('.menu');
            var $dropmenus = $menus.find('.menu-item__dropdown');
            var $mobileArrow = $dropmenus.find('.mobile-arrow');

            function toggleDropdown(e) {
                e.preventDefault();
                // alert('--------- toggle ----------');
                var $this = jQuery(this);
                var $menuItem = $this.parent();

                // $menuItem.addClass('my-custom-class');
                // alert('---- menuitem ------' + $menuItem);
                // if ($menuItem.hasClass('active')) {
                //     $menuItem.removeClass('active');
                // } else {
                //     $menuItem.addClass('active');
                // }

                if (!$menuItem.hasClass('active')) {
                    $menuItem.addClass('active');
                }
            }

            $mobileArrow.click(toggleDropdown);
        }());*/


        // var DropdownMenus = (function () {
        //     var $menus = $('.menu');
        //     var $dropmenus = $menus.find('.menu-item__dropdown');
        //     var $mobileArrow = $dropmenus.find('.mobile-arrow');

        //     function toggleDropdown(e) {
        //         e.preventDefault();

        //         var $this = $(this);
        //         var $menuItem = $this.parent();

        //         if ($menuItem.hasClass('active')) {
        //             $menuItem.removeClass('active');
        //         } else {
        //             $menuItem.addClass('active');
        //         }
        //     }

        //     $mobileArrow.click(toggleDropdown);
        // }());

        /*--------------------------------------*/
        /*jQuery('.global.menu.menu--main .mobile-arrow').click(function (e) {
            e.stopPropagation(); // Prevent event bubbling

            var parentLi = jQuery(this).closest('li.menu-item'); // Get parent menu item
            var submenu = parentLi.find('.menu-item__submenu').first(); // Get the submenu

            if (submenu.is(':visible')) {
                parentLi.removeClass('active');
                submenu.slideUp(); // Hide submenu
            } else {
                jQuery('.global.menu ul#menu-main-menu li.menu-item').removeClass('active'); // Close all others
                jQuery('.menu-item__submenu').slideUp(); // Hide all submenus

                parentLi.addClass('active');
                submenu.slideDown(); // Show submenu
            }
        });

        // Close submenu when clicking outside
        jQuery(document).click(function () {
            jQuery('.global.menu ul#menu-main-menu li.menu-item').removeClass('active');
            jQuery('.menu-item__submenu').slideUp();
        });

        // Prevent closing submenu when clicking inside it
        jQuery('.menu-item__submenu').click(function (e) {
            e.stopPropagation();
        });*/

        /*--------------------------------------*/


        var StickyHeader = (function () {
            if (!$header.hasClass('sticky')) { return; }

            if (window.scrollY) {
                $header.addClass('sticky--scrolled');
            }

            $(window).on('scroll', function () {

                if (window.scrollY) {
                    $header.addClass('sticky--scrolled');

                } else if (window.scrollY === 0) {
                    $header.removeClass('sticky--scrolled');
                }

                if ($adminBar.length) {
                    $header.css({ top: $adminBar.innerHeight() });
                }

            });
        }());

        window.addEventListener('resize', function () {
            $header.css({ position: 'sticky' });
            BurgerMenu.close();

            var styles = { marginTop: window.innerWidth < 960 ? header_height : 0 };

            $nav.css(styles);
        });

    }());

    var LoadMore = (function () {
        
        var $loadMoreButton = $('#load-more-button');
        if (!$loadMoreButton.length) { return; }

        
        var page = 2;
        var max_pages = 1; // Initialize max_pages with a default value of 1
        var $postList = $('.blog-posts');
    
        $loadMoreButton.on('click', function() {
            // Fetch more posts via AJAX
            var data = {
                action: 'load_more_posts',
                page: page,
                post_types: $(this).attr("data-type"),
            };

    
            $.ajax({
                url: ajaxurl, // Use the WordPress AJAX endpoint
                type: 'POST',
                data: data,
                dataType: 'json', // Use 'json' to automatically parse the response as JSON
                beforeSend: function() {
                    $loadMoreButton.text('Loading...'); // Display a loading message on the button
                },
                success: function(response) {
                    if (response.success) {
                        $postList.append(response.data.content); // Append the new posts to the existing list
                        page++;
                        //console.log(response.data.content);
    
                        if (page > response.data.max_pages) {
                            $loadMoreButton.hide(); // Hide the button if there are no more posts
                        } else {
                            $loadMoreButton.text('Load More'); // Restore the button text
                        }
                    }
                },
                error: function() {
                    // Handle error if needed
                },
            });
        });
    }());


/* ========================================================================================================================

    Click Blocks

======================================================================================================================== */

    var hoverBlocks = (function () {
        var $sections = $('.hover-block');
        if (!$sections.length) { return; }

        $sections.each(function () {
            $section = $(this);
            var $triggers = $section.find('.hover-trigger');
            var $content = $section.find('.hover-content');

            // First General content filtered
            $( $content ).each(function( index ) {
                var ID = this.dataset.id;
                if(ID != 1) {
                    $(this).addClass("hidden");
                }
            });

            $triggers.click(function () {
                var ID = this.dataset.id;
                $triggers.removeClass('active');
                $triggers.removeClass('remove-border');
                $(this).addClass('active');
                $(this).next().addClass('remove-border');
                /*$(this).prev().addClass('remove-border');*/
                $content.addClass('hidden').filter(function (i, el) {
                    var ids = el.dataset.id.split(',');
                    if (ids.indexOf(ID) >= 0) {
                        $(el).removeClass('hidden');
                    }
                });
                
            });

        });        

    }());

    var tabs = (function () {
        var $sections = $('.tabs');
        if (!$sections.length) { return; }

        $sections.each(function () {
            $section = $(this);
            var $triggers = $section.find('.hover-trigger');
            var $content = $section.find('.hover-content');

            $triggers.click(function(){
                $triggers.removeClass("active");
                $(this).addClass("active");

                $content.removeClass("active");
                $content.eq($(this).index()).addClass('active');
            });
        });        
    }());

    var dropdownButton = (function () {

        var $dropdown = $('.jumplink_galleries__wrap .dropdown');
        if (!$dropdown.length) { return; }

        var $dropdownitem = $dropdown.find(".dropdown-item");
        var $dropdowntoggle = $dropdown.find(".dropdown-toggle");
        var $dropdownmenu = $dropdown.find(".dropdown-menu");

        $dropdowntoggle.click(function() {
          $(this).siblings( $dropdownmenu ).toggle();
        });
      
        $dropdownitem.click(function() {
          var value = $(this).text();
          $dropdowntoggle.text(value);
          $dropdownmenu.hide();
        });

    }()); 

    var serviceButtonTabs = (function () {

        var $dropdown = $('.service_button_tabs .dropdown');
        if (!$dropdown.length) { return; }

        var $dropdownitem = $dropdown.find(".dropdown-item");
        var $dropdowntoggle = $dropdown.find(".dropdown-toggle");
        var $dropdownmenu = $dropdown.find(".dropdown-menu");

        $dropdowntoggle.click(function() {
          $(this).siblings( $dropdownmenu ).toggle();
        });
      
        $dropdownitem.click(function() {
          var value = $(this).text();
          $dropdowntoggle.text(value);
          $dropdownmenu.hide();
        });

    }()); 
    var testimonialCarousel = (function () {

        var $carousel = $('.carousel-sect-testimonial');
        if (!$carousel.length) { return; }

        // Initialize Flickity
        var flkty = new Flickity('.carousel-sect-testimonial', {
            // Add your Flickity options here
            pageDots: true, // Disable default pagination dots
            cellAlign: 'center',
            initialIndex: 1,
        });
        
        // Get the custom navigation buttons
        var prevButton = document.querySelector('.prev-button');
        var nextButton = document.querySelector('.next-button');
        
        // Add event listeners to the buttons
        prevButton.addEventListener('click', function() {
            flkty.previous();
        });
        nextButton.addEventListener('click', function() {
            flkty.next();
        });

        $(".flickity-page-dots").appendTo( $(".custom-dots") );
        
    }()); 
    
    var tabCarousel = (function () {

        var $carousel = $('.tabs__carousel');
        if (!$carousel.length) { return; }

        // Initialize Flickity
        var flkty = new Flickity('.tabs__carousel', {
            // Add your Flickity options here
            prevNextButtons: false, // Disable default 
            pageDots: false, // Disable default pagination dots
            cellAlign: 'center',
            contain: true,
            wrapAround: true,
            autoPlay: false,
            groupCells: 1 // Set the number of cells to group
        });
        
        // Get the custom navigation buttons
        var prevButton = document.querySelector('.tabsprev-button');
        var nextButton = document.querySelector('.tabsnext-button');
        
        // Add event listeners to the buttons
        prevButton.addEventListener('click', function() {
            flkty.previous();
        });
        nextButton.addEventListener('click', function() {
            flkty.next();
        });

        $(".flickity-page-dots").appendTo( $(".custom-dots") );
        
    }()); 


    var imgCarousel = (function () {

        var $carousel = $('.image-slider__carousel');
        if (!$carousel.length) { return; }

        // Initialize Flickity
        var flkty = new Flickity('.image-slider__carousel', {
            // Add your Flickity options here
            prevNextButtons: false, // Disable default 
            pageDots: true, // Disable default pagination dots
            cellAlign: 'center',
            contain: true,
            wrapAround: true,
            autoPlay: false,
            adaptiveHeight: true,
            groupCells: 1 // Set the number of cells to group
        });

        // Get the custom navigation buttons
        var prevButton = document.querySelector('.img-slider_prev-button');
        var nextButton = document.querySelector('.img-slider_next-button');
        
        // Add event listeners to the buttons
        prevButton.addEventListener('click', function() {
            flkty.previous();
        });
        nextButton.addEventListener('click', function() {
            flkty.next();
        });
        
    }()); 

   

    // var jumpLink = (function () {

    //     var $jumplink = $('.archive-industry__links-sticky');
    //     if (!$jumplink.length) { return; }

    //     $jumplink.find("a").click(function(){
    //         $(".archive-industry__links-sticky a").removeClass("active");
    //         $(this).addClass("active");
    //     });
  

    // }());
    
    // jQuery('.archive-industry__links-sticky').find("a:first-child").addClass("active");

    jQuery(document).on("scroll", onScroll);
 
        jQuery('.archive-industry__links-sticky a[href^="#"]').on('click', function (e) {
            e.preventDefault();
            jQuery(document).off("scroll");

            jQuery('.archive-industry__links-sticky a').each(function () {
                jQuery(this).removeClass('active');
            })
            jQuery(this).addClass('active');

            var target = this.hash;
            $target = jQuery(target);
            jQuery('html, body').stop().animate({
                'scrollTop': $target.offset().top+2
            }, 500, 'swing', function () {
                window.location.hash = target;
                jQuery(document).on("scroll", onScroll);
            });
        });

    function onScroll(event){
        var scrollPosition = jQuery(document).scrollTop();
        
        jQuery('.archive-industry__links-sticky a').each(function () {
            var currentLink = jQuery(this);
            var refElement = jQuery(currentLink.attr("href"));
            if (refElement.position().top <= scrollPosition && refElement.position().top + refElement.height() <= scrollPosition) {
                jQuery('.archive-industry__links-sticky a').removeClass("active");
                currentLink.addClass("active");
            }
            else{
                currentLink.removeClass("active");
            }
        });
    }

    var Counter = (function () {
        var $count = $('.count');
        if (!$count.length) { return; }
    
        // Function to format numbers with commas
        function formatNumberWithCommas(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    var initialCounterValue = $(entry.target).text();
                    //console.log("Initial Counter Value:", initialCounterValue);
    
                    $(entry.target).prop('Counter', 0).animate({
                        Counter: initialCounterValue
                    }, {
                        duration: 1500,
                        easing: 'swing',
                        step: function (now) {
                            $(entry.target).text(formatNumberWithCommas(Math.ceil(now)));
                        }
                    });
                    observer.unobserve(entry.target);
                }
            });
        });
    
        $count.each(function () {
            observer.observe(this);
        });
    }());
    

});


//     jQuery(function ($) {
//         console.log('Accordion script loaded');

//         var $accordions = $('.accordion');
//         if (!$accordions.length) return;

//         //Show content for already active accordions on load
//         // $accordions.each(function () {
//         //     if ($(this).hasClass('active')) {
//         //         $(this).find('.accordion__content').show();
//         //     }
//         // });

//         // // Click event for toggling accordions
//         // $accordions.find('.accordion__trigger').click(function (e) {
//         //     var $this = $(this);
//         //     var $accordion = $this.closest('.accordion'); // Get clicked accordion
//         //     var $content = $accordion.find('.accordion__content');
//         //     var $siblings = $accordion.siblings('.accordion'); // Get all other accordions

//         //     if ($accordion.hasClass('active')) {
//         //         // Close the clicked accordion
//         //         $accordion.removeClass('active');
//         //         $content.slideUp('slow');
//         //     } else {
//         //         // Close all other accordions
//         //         $siblings.removeClass('active').find('.accordion__content').slideUp('slow');

//         //         // Open the clicked accordion
//         //         $accordion.addClass('active');
//         //         $content.slideDown('slow');
//         //     }
//         // });
//     });
