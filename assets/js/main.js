(function ($) {
    "use strict";

    $(window).load(function () {

        $('body.loadpage:before').hide();
        if ($('body').hasClass('loadpage')) {
            $('body').removeClass('loadpage');
        }

        $('body').find('.section').each(function () {
            var $section = $(this);
            new Waypoint({
                element: $section[0],
                handler: function (direction) {
                    //console.log(this);
                    var $element = $(this.element);
                    $element.find('.animated').each(function () {
                        var $animate = $(this).attr('data-animate');
                        if (typeof $animate !== "undefined") {
                            $(this).addClass($animate);
                        }
                        ;

                    });
                },
                offset: '70%',
            });
        });


        // Header Style 3
        if ($('body.style-v3').length > 0) {
            var $menu = $('body.style-v3').find('#navbar .navbar-nav'),
                //index = Math.round($item_menu.length/2),
                //$parent = $item_menu.slice(index, index + 1),
                $logo = $('body.style-v3').find('#logo');
            $logo.imagesLoaded(function () {
                $menu.css({"padding-right": $logo.find('img').outerWidth() / 2 + 30})
                    .next().css({"padding-left": $logo.find('img').outerWidth() / 2 + 30, "padding-right": 0});

                $logo.find('a').css({"margin-left": -$logo.find('img').outerWidth() / 2});
            });

        } // End Header Style 3

    });


    $(document).ready(function () {

        // Hover Menu
        $('.navbar-nav > li .mega-menu').addClass('animated animation-duration-5');
        $('.navbar-nav > li .dropdown').addClass('animated animation-duration-5');

        $(".navbar-nav > li").hover(function () {
            $(this).children().addClass('fadeInUpMenu');
        }, function () {
            $(this).children().removeClass('fadeInUpMenu');
        });

        // Nivo Slider;
        var $slider = $('#banner .slider-wrapper');
        if ($slider.length > 0) {
            $slider.imagesLoaded(function () {
                $slider.find('.nivoSlider').nivoSlider({
                    pauseTime: 10000,
                    beforeChange: function () {
                    },
                    afterChange: function () {
                        $slider.find('.nivo-caption').find('.animated').each(function () {
                            $(this).addClass($(this).attr('data-animate'));
                        });
                    },
                    slideshowEnd: function () {
                    },
                    lastSlide: function () {
                    },
                    afterLoad: function () {
                        $slider.find('.nivo-caption').find('.animated').each(function () {
                            $(this).addClass($(this).attr('data-animate'));
                        });
                    },
                });

            });
        }// End Nivo


        // Services
        var $check_click = false;
        $('.section.services').on('click', 'li.service:not(.active)', function (e) {
            e.preventDefault();

            var $this = $(this);

            if (!$this.hasClass('active')) {
                $('.section.services').find('li.service').removeClass('active');
                $this.addClass('active');

                $('.section.services').find('li.service .animated').addClass('bullets');
                $this.find('.animated').removeClass('bullets');

            }

            $check_click = true;
        });

        $('.section.services').on('click', 'li.service.active', function (e) {

            $check_click = true;
        });

        $('.section.services').on('click', function (e) {
            if ($check_click == false) {
                e.preventDefault();
                $('#services-item').find('li.service').removeClass('active');
            }
            $check_click = false;
        });


        // Load Menus
        var $menus = $('.menus');
        if ($menus.length > 0) {

            // filter items
            $menus.find('.filter').on('click', 'button', function () {
                var $this = $(this), filterValue = $this.attr('data-filter');
                var $clickedMenu = $(this).closest('.menus');

                $this.addClass('active');
                $this.siblings('.active').removeClass('active');

                if (filterValue == '*') filterValue = '.menu-item';

                $clickedMenu.find('.menu-item').not(filterValue).fadeOut(1000);
                $clickedMenu.find(filterValue).fadeIn(1000);

                return false;
            });
        }


        // Flickity slider
        if ($('.gallery-about').length > 0) {
            $('.gallery-about .gallery-flickity').imagesLoaded(function () {
                $('.gallery-about .gallery-flickity').flickity({
                    freeScroll: true,
                    contain: true,
                    // disable previous & next buttons and dots
                    prevNextButtons: false,
                    pageDots: false,
                });
            });
        }

        function gallery_flickity($gallery) {

            if ($gallery.length > 0) {
                $gallery.imagesLoaded(function () {
                    $gallery.flickity({
                        // options
                        wrapAround: true,
                        imagesLoaded: true,
                        resize: false,
                        arrowShape: {
                            x0: 25,
                            x1: 60, y1: 35,
                            x2: 70, y2: 35,
                            x3: 35
                        }
                    });
                });
            }
        }

        // Load Gallery
        $('.widget-gallery').on('click', 'a.gallery-ajax', function (e) {
            e.preventDefault();

            var $this = $(this),
                $url = $this.attr('data-url'),
                $modal = $($this.attr('data-target'));

            $modal.addClass('animated');

            if ($modal.find('.gallery').length < 1) {

                $(document).ajaxStart(function () {
                    $('body').addClass('loadpage');
                });
                $(document).ajaxStop(function () {
                    $('body').removeClass('loadpage');
                });

                $.ajax({
                    url: $url,
                    cache: false,
                }).done(function (html) {

                    var $element = $(html).find('.gallery');

                    $modal.find('.modal-body').html($element);

                    // This Share
                    //stButtons.locateElements();

                    gallery_flickity($modal.find('.gallery-flickity'));

                })

                    .fail(function () {
                        location.reload();
                    })
                    .always(function (html) {
                        var $gallery = $modal.find('.gallery'),
                            settle = 1;

                        $gallery.on('settle', function () {
                            if (settle == 1) {
                                $('body').removeClass('loadpage');
                                $modal.addClass('fadeInDown');
                            }
                            settle++;
                        });
                    });

            } else {
                $modal.addClass('fadeInDown');
            }

        });

        var $galleries = $('#galleries');
        if ($galleries.length > 0) {

            // filter items
            $galleries.find('.filter').on('click', 'button', function () {
                var $this = $(this),
                    filterValue = $this.attr('data-filter'),
                    $item = $galleries.find('[class^="col"].active');

                $this.addClass('active');
                $this.siblings('.active').removeClass('active');

                $item.css('height', $item.find('.inner')
                    .innerHeight())
                    .removeClass('active');

                if (filterValue == '*') filterValue = '.gallery-item';

                $galleries.find('.gallery-item').not(filterValue).fadeOut(1000);
                $galleries.find(filterValue).fadeIn(1000);

                return false;
            });


            // Close gallery
            $galleries.on('click', '.gallery-v1 .close', function (e) {
                e.preventDefault();

                var $this = $(this),
                    $parent = $this.parents('.gallery-item');

                $parent.css('height', $parent.find('.inner')
                    .innerHeight())
                    .removeClass('active');

            });

            // Load detail
            $galleries.on('click', 'a.gallery-ajax', function (e) {
                e.preventDefault();

                var $this = $(this);
                var $parent = $this.parents('.gallery-item');
                var $url = $this.attr('data-url');

                if ($this.parents('.galleries-v2').length > 0) {

                    var $modal = $parent.find('.modal');

                    if ($modal.length > 0)
                        $modal.addClass('animated');

                    if ($parent.find('.modal-body .gallery').length < 1) {

                        $(document).ajaxStart(function () {
                            $('body').addClass('loadpage');
                        });
                        $(document).ajaxStop(function () {
                            //$('body').removeClass('loadpage');
                        });

                        $.ajax({
                            url: $url,
                            cache: false,
                        }).done(function (html) {

                            var $element = $(html).find('.gallery');

                            $parent.find('.modal-body').html($element);

                            // This Share
                            //stButtons.locateElements();

                            gallery_flickity($parent.find('.gallery-flickity'));

                        })

                            .fail(function () {
                                location.reload();
                            })
                            .always(function (html) {
                                var $gallery = $modal.find('.gallery'),
                                    settle = 1;

                                $gallery.on('settle', function () {
                                    if (settle == 1) {
                                        $('body').removeClass('loadpage');
                                        $modal.addClass('fadeInDown');
                                    }
                                    settle++;
                                });
                            });

                    } else {

                        $modal.addClass('fadeInDown');
                    }

                } else {

                    if ($parent.hasClass('active')) {
                        return false;

                    } else {

                        $parent.siblings('.active').css('height', $parent.find('.inner')
                            .innerHeight())
                            .removeClass('active');
                    }

                    if ($parent.find('.gallery').length < 1) {

                        $parent.css('height', $parent.find('.inner').innerHeight());

                        $(document).ajaxStart(function () {
                            $('body').addClass('loadpage');
                        });
                        $(document).ajaxStop(function () {
                            $('body').removeClass('loadpage');
                        });

                        $.ajax({
                            url: $url,
                            cache: false,
                        }).done(function (html) {
                            var $element = $(html);

                            $parent.append($element);

                            //This Share
                            //stButtons.locateElements();

                            // Flickity slider
                            gallery_flickity($parent.find('.gallery-flickity'));

                        })
                            .fail(function () {
                                location.reload();
                            })
                            .always(function (html) {
                                var $gallery = $parent.find('.gallery'),
                                    settle = 1;

                                $gallery.on('settle', function () {
                                    if (settle == 1) {

                                        $('body').removeClass('loadpage');

                                        var $height = $gallery.innerHeight() + $parent.innerHeight();

                                        $parent.css("height", $height).addClass('active');
                                    }
                                    settle++;
                                });

                            });

                    } else {
                        var $gallery = $parent.find('.gallery'),
                            $height = $gallery.innerHeight() + $parent.innerHeight();

                        $parent.css("height", $height).addClass('active');
                    }
                }

            });
        }

        $('.js-submit-registration').click(function (event) {
            event.preventDefault();
            var $form = $(this).closest('.registration-form');
            $form.submit();
            $(this).blur();
        });

        $('.js-registration-form').submit(function(event) {
            event.preventDefault();

            var $form = $(this);
            if (!this.reportValidity || this.reportValidity()) {
                $.ajax({
                    type: "POST",
                    data: $form.serialize(),
                    url: $form.prop('action'),
                    cache: false
                }).done(function (json) {
                    var alertClass;
                    if (json.status === 'success') {
                        alertClass = 'success';
                        $form.find('.js-submit-registration').attr('disabled', true);
                    } else {
                        alertClass = 'danger';
                    }
                    if ($form.find('.alert').length < 1) {
                        $form.append('<div role="alert" class="alert alert-' + alertClass + ' alert-dismissible"><strong>' + json.message + '</strong>' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                            '<span aria-hidden="true">&times;</span>\n' +
                            '</button></div>');
                        $form.find('.alert').hide().toggle(350);
                    } else {
                        $form.find('.alert').removeClass('alert-success').removeClass('alert-danger').addClass('alert-' + alertClass);
                        $form.find('.alert').html('<strong>' + json.message + '</strong>').hide().toggle(350);
                    }
                });
            }
            return false;
        });
    });


    // Filter Sticky
    // var $filter = $('#filter'),
    //     $footer = $('#seasonspecials'),
    //     $check = false;
    // if ($filter.length > 0) {
    //     new Waypoint.Sticky({
    //         element: $filter,
    //         wrapper: '<div class="filter-sticky" />',
    //         stuckClass: 'filter-stuck',
    //         offset: '10%',
    //         handler: function (direction) {
    //             console.log(this.id + ' triggers at ' + this.waypoint.triggerPoint);
    //         }
    //     });
    //
    //     new Waypoint({
    //         element: $footer[0],
    //         handler: function (direction) {
    //             console.log(this.element.id + ' triggers at ' + this.triggerPoint);
    //             if (direction == 'down' && $filter.hasClass('filter-stuck')) {
    //                 $filter.removeClass('filter-stuck');
    //                 $check = true;
    //
    //             } else if ($check && direction == 'up') {
    //                 $filter.addClass('filter-stuck');
    //                 $check = false;
    //
    //             } else $check = false;
    //         },
    //         offset: '0',
    //     });
    // }


    // Style v2 Header Sticky
    var $header_inner = $('.style-v2 .header-inner, .style-v3 .header-inner');
    if ($header_inner.length > 0) {
        new Waypoint.Sticky({
            element: $header_inner[0],
            wrapper: '<div class="header-sticky" />',
            stuckClass: 'header-stuck',
            offset: '0'
        });
    }

})(jQuery);


var mtheme_maps = {
        LatLng: "51.5042389, -0.1061977",
        desc_contact: "<p> Email: noreply@gmail.com<br>Phone: +800 - 568 - 8989<br>96 Isabella ST, London, SE 1 8DD</p>"
    },

    $map_canvas = document.getElementById("map-canvas");

if (typeof mtheme_maps !== "undefined" && $map_canvas != null) {

    function initialize() {

        var grayStyles = [/*{
			featureType : "all",
			stylers : [ {
				saturation : -100
			}, {
				lightness : 47
			}, {
				gamma : 0.34
			} ]
		},*/];

        var $LatLng = mtheme_maps.LatLng.split(", ");

        var mapOptions = {
            center: new google.maps.LatLng($LatLng[0], $LatLng[1]),
            zoom: 13,
            styles: grayStyles,
        };

        var map = new google.maps.Map(document.getElementById("map-canvas"),
            mapOptions);

        var marker = new google.maps.Marker({
            map: map,
            position: map.getCenter(),
            icon: '../assets/imgs/icon-map.png',

        });

        var infowindow = new google.maps.InfoWindow();
        infowindow.setContent(mtheme_maps.desc_contact);
        google.maps.event.addListener(marker, 'click', function () {
            infowindow.open(map, marker);
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize());
}