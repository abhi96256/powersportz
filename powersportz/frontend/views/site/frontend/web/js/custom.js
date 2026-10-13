jQuery(document).ready(function() {
    jQuery(window).load(function() {});
    var owl1 = $("#first-carousel");
    // owl1.owlCarousel({
    //     itemsCustom: [
    //         [0, 1],
    //         [450, 1],
    //         [600, 2],
    //         [700, 2],
    //         [1000, 3],
    //         [1200, 4],
    //         [1400, 4],
    //         [1600, 4]
    //     ],
    //     lazyLoad: true,
    //     // touchDrag  : true,
    //     // mouseDrag  : true
    // });
    owl1.owlCarousel({
            loop:true,
            autoWidth:false,
            nav:false,
            responsiveClass:true,
            responsive:{
                0:{
                    items:1,
                    nav:true,
                    margin:15
                   
                },
                600:{
                    items:1,
                    nav:true,
                    margin:15
                },
                991:{
                    items:4,
                    nav:true,
                    loop:false
                },
                1000:{
                    items:4,
                    nav:true,
                    loop:false
                }
            },
            dots:false
        }).on('changed.owl.carousel', function(event) {
       console.log(event);
        $(window).scrollTop($(window).scrollTop() + 1);
        $(window).scrollTop($(window).scrollTop() - 1);
    });
    $(".next1").click(function() {
        owl1.trigger('owl.next');
        $(window).scrollTop($(window).scrollTop() + 1);
        $(window).scrollTop($(window).scrollTop() - 1);
    })
    $(".prev1").click(function() {
        owl1.trigger('owl.prev');
        $(window).scrollTop($(window).scrollTop() + 1);
        $(window).scrollTop($(window).scrollTop() - 1);
    }) 
    var secondCarousel = $("#second-carousel");
    secondCarousel.owlCarousel({
        // itemsCustom: [
        //     [0, 1],
        //     [450, 1],
        //     [600, 2],
        //     [700, 2],
        //     [1000, 3],
        //     [1200, 4],
        //     [1400, 4],
        //     [1600, 4]
        // ],
        // lazyLoad: true
        loop:true,
           loop:true,
            autoWidth:false,
            nav:false,
            responsiveClass:true,
            responsive:{
                0:{
                    items:1,
                    nav:true,
                    margin:15
                   
                },
                600:{
                    items:1,
                    nav:true,
                    margin:15
                },
                991:{
                    items:4,
                    nav:true,
                    loop:false
                },
                1000:{
                    items:4,
                    nav:true,
                    loop:false
                }
            },
            dots:false
    }).on('changed.owl.carousel', function(event) {
       
        $(window).scrollTop($(window).scrollTop() + 1);
        $(window).scrollTop($(window).scrollTop() - 1);
    });
    $(".next2").click(function() {
        secondCarousel.trigger('owl.next');
        $(window).scrollTop($(window).scrollTop() + 1);
        $(window).scrollTop($(window).scrollTop() - 1);
    })
    $(".prev2").click(function() {
        secondCarousel.trigger('owl.prev');
        $(window).scrollTop($(window).scrollTop() + 1);
        $(window).scrollTop($(window).scrollTop() - 1);
    })
    var thirdCarousel = $("#third-carousel");
    thirdCarousel.owlCarousel({
        // itemsCustom: [
        //     [0, 1],
        //     [450, 1],
        //     [600, 2],
        //     [700, 2],
        //     [1000, 3],
        //     [1200, 4],
        //     [1400, 4],
        //     [1600, 4]
        // ],
        // lazyLoad: true
        loop:true,
           loop:true,
            autoWidth:false,
            nav:false,
            responsiveClass:true,
            responsive:{
                0:{
                    items:1,
                    nav:true,
                    margin:15
                   
                },
                600:{
                    items:1,
                    nav:true,
                    margin:15
                },
                991:{
                    items:4,
                    nav:true,
                    loop:false
                },
                1000:{
                    items:4,
                    nav:true,
                    loop:false
                }
            },
            dots:false
    }).on('changed.owl.carousel', function(event) {
       
        $(window).scrollTop($(window).scrollTop() + 1);
        $(window).scrollTop($(window).scrollTop() - 1);
    });
    $(".next3").click(function() {
        thirdCarousel.trigger('owl.next');
        $(window).scrollTop($(window).scrollTop() + 1);
        $(window).scrollTop($(window).scrollTop() - 1);
    })
    $(".prev3").click(function() {
        thirdCarousel.trigger('owl.prev');
        $(window).scrollTop($(window).scrollTop() + 1);
        $(window).scrollTop($(window).scrollTop() - 1);
    })
    var fourCarousel = $("#four-carousel");
    fourCarousel.owlCarousel({
        // itemsCustom: [
        //     [0, 1],
        //     [450, 1],
        //     [600, 2],
        //     [700, 2],
        //     [1000, 3],
        //     [1200, 4],
        //     [1400, 4],
        //     [1600, 4]
        // ],
        // lazyLoad: true
        loop:true,
           loop:true,
            autoWidth:false,
            nav:false,
            responsiveClass:true,
            responsive:{
                0:{
                    items:1,
                    nav:true,
                    margin:15
                   
                },
                600:{
                    items:1,
                    nav:true,
                    margin:15
                },
                991:{
                    items:4,
                    nav:true,
                    loop:false
                },
                1000:{
                    items:4,
                    nav:true,
                    loop:false
                }
            },
            dots:false
    }).on('changed.owl.carousel', function(event) {
      //  console.log(event);
        $(window).scrollTop($(window).scrollTop() + 1);
        $(window).scrollTop($(window).scrollTop() - 1);
    });
    $(".next4").click(function() {
        fourCarousel.trigger('owl.next');
        $(window).scrollTop($(window).scrollTop() + 1);
        $(window).scrollTop($(window).scrollTop() - 1);
    })
    $(".prev4").click(function() {
        fourCarousel.trigger('owl.prev');
        $(window).scrollTop($(window).scrollTop() + 1);
        $(window).scrollTop($(window).scrollTop() - 1);
    })

    function searchMiddle() {
        var h, id;
        h = window.innerHeight;
        id = $(".search-pp");
        id.css({
            top: h / 3
        });
    }
    $(window).bind({
        load: function() {
            searchMiddle();
        },
        resize: function() {
            searchMiddle();
        }
    });
    $(".change-pass h3").click(function(e) {
        $(".change-pass").children(".form-group").slideToggle("slow");
    });
});
var doc = document.documentElement;
doc.setAttribute('data-useragent', navigator.userAgent);
$(document).ready(function($) {
    "use strict";
    $(function() {
        var url = window.location.href;
        $(".ddsmoothmenu a").each(function() {
            if (url == (this.href)) {
                $(this).closest("li").addClass("active");
                $(this).parents('li').addClass('parent-active');
            }
        });
    });
    $(window).load(function() {
        $("#preloader").delay(500).fadeOut(1000);
        $(".preload-logo").addClass('fadeOutLeft');
        $(".back-logo").addClass('fadeOutRight');
        $(".preload-gif").addClass('fadeOutUp');
    });
    $("#owl-featured").owlCarousel({
        items: 3,
        itemsCustom: false,
        itemsDesktop: [1199, 2],
        itemsDesktopSmall: [980, 2],
        itemsTablet: [630, 1],
        itemsTabletSmall: false,
        itemsMobile: [479, 1],
        singleItem: false,
        itemsScaleUp: false,
        responsive: true,
        responsiveRefreshRate: 200,
        responsiveBaseWidth: window,
        autoPlay: false,
        stopOnHover: false,
        navigation: true,
    });
    $(".wr-channel-slide").owlCarousel({
        items: 1,
        itemsCustom: false,
        itemsDesktop: [1199, 1],
        itemsDesktopSmall: [980, 1],
        itemsTablet: [630, 1],
        itemsTabletSmall: false,
        itemsMobile: [479, 1],
        singleItem: false,
        itemsScaleUp: false,
        responsive: true,
        responsiveRefreshRate: 200,
        responsiveBaseWidth: window,
        autoPlay: false,
        stopOnHover: false,
        navigation: true,
    });
    $(".wr-channel-slide-2nd").owlCarousel({
        items: 1,
        itemsCustom: false,
        itemsDesktop: [1199, 1],
        itemsDesktopSmall: [980, 1],
        itemsTablet: [630, 1],
        itemsTabletSmall: false,
        itemsMobile: [479, 1],
        singleItem: false,
        itemsScaleUp: false,
        responsive: true,
        responsiveRefreshRate: 200,
        responsiveBaseWidth: window,
        autoPlay: false,
        stopOnHover: false,
        navigation: true,
    });
    jQuery(".spo-responsive-trigger").on('click', (function(e) {
        jQuery("ul.left-menu.open").slideToggle();
        e.preventDefault();
        jQuery(this).parent().find("ul.wr-res-menu").slideToggle(300);
        if (jQuery(this).hasClass("active")) {
            jQuery(this).removeClass('active');
        } else {
            jQuery(this).addClass('active');
        }
    }));
    jQuery(".hd-aside-search").on('click', (function(e) {
        e.preventDefault();
        jQuery(this).parent().find(".header-search-input").slideToggle(300);
        if (jQuery(this).hasClass("active")) {
            jQuery(this).removeClass('active');
        } else {
            jQuery(this).addClass('active');
        }
    }));
    jQuery(".v2menu").on('click', (function(e) {
        e.preventDefault();
        jQuery(this).parent().find(".v2-menu").slideToggle(300);
        if (jQuery(this).hasClass("active")) {
            jQuery(this).removeClass('active');
        } else {
            jQuery(this).addClass('active');
        }
    }));
    ddsmoothmenu.init({
        mainmenuid: "templatemo_menu",
        orientation: 'h',
        classname: 'ddsmoothmenu',
        contentsource: "markup"
    });
    $(window).scroll(function() {
        if ($(document).scrollTop() >= 90) {
            $('.home-t-h header').removeClass("transparent");
            if ($('.home-t-h header').hasClass('white-header')) {
                $('.spo-logo').addClass('black-logo');
            }
        } else {
            $('.home-t-h header').addClass("transparent");
        }
    });
});
(function($) {
    "use strict";
    $('.toggle dd').hide();
    $('.toggle dt').on('click', (function() {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $(this).next().slideUp(300);
        } else {
            $(this).addClass('active');
            $(this).next().slideDown(300);
        }
        return false;
    }));
})(jQuery);
$(document).ready(function() {
    "use strict";
    $('article.video').siPlayer(false);
});
$.fn.siPlayer = function(autoplay) {
    return $(this).each(function(k, v) {
        var $player = $(v);
        var $video = $player.find('video');
        var src = $video.get(0).currentSrc;
        var _video = $video.get(0);
        var o = {
            duration: 0,
            seek: null,
            isPaused: true,
            isFinished: false,
            position: 0,
            loadingText: "Patience, Padawan...",
            shift: null
        };
        var $el = {
            controls: $('<div/>').addClass('control-bar'),
            buttons: $('<div/>').addClass('button-bar'),
            play: $('<i/>').addClass('play'),
            pause: $('<i/>').addClass('pause hidden'),
            replay: $('<i/>').addClass('replay hidden'),
            volume: $('<div/>').addClass('volume'),
            toggle: $('<i/>').addClass('toggle').html('&#61480;'),
            rail: $('<div/>').addClass('rail'),
            audible: $('<div/>').addClass('audible'),
            inaudible: $('<div/>').addClass('inaudible'),
            grip: $('<div/>').addClass('grip'),
            time: $('<span/>').addClass('time'),
            total: $('<span/>').addClass('total'),
            divider: $('<span/>').html(' / '),
            current: $('<span/>').addClass('current'),
            fullscreen: $('<i/>').addClass('fullscreen').html("&#61541"),
            seek: $('<div/>').addClass('seek'),
            buffer: $('<div/>').addClass('buffer'),
            watched: $('<div/>').addClass('watched'),
            handle: $('<i/>').addClass('handle'),
            largePlay: $('<span/>').addClass('large-play').html("&#61515;"),
            spinner: $('<span/>').addClass('spinner'),
            loading: $('<div/>').addClass('loading').text(o.loadingText).attr('title', o.loadingText + ' retrieving video data')
        };
        var funcs = {
            init: function() {
                o.duration = _video.duration;
                if (o.duration > 0) {
                    funcs.setTime();
                    funcs.getBuffered();
                    funcs.clearLoading();
                }
                funcs.ui();
                events();
                if (autoplay) {
                    setTimeout(function() {
                        $el.play.trigger('mouseup.play');
                    }, 1000);
                } else {
                    setTimeout(function() {
                        $el.largePlay.removeClass('hidden');
                    }, 800);
                }
            },
            ui: function() {
                $player.append($el.controls);
                $el.controls.append($el.buttons, $el.seek);
                $el.buttons.append($el.play, $el.pause, $el.replay, $el.volume, $el.time, $el.fullscreen);
                $el.volume.append($el.toggle, $el.rail);
                $el.rail.append($el.inaudible, $el.audible, $el.grip);
                $el.seek.append($el.buffer, $el.watched);
                $el.watched.append($el.handle);
                $el.time.append($el.current, $el.divider, $el.total);
                $video.addClass('visible');
            },
            fullscreen: function() {
                if ($player.get(0).requestFullScreen) {
                    $player.get(0).requestFullScreen();
                } else if ($player.get(0).mozRequestFullScreen) {
                    $player.get(0).mozRequestFullScreen();
                } else if ($player.get(0).webkitRequestFullScreen) {
                    $player.get(0).webkitRequestFullScreen();
                }
            },
            loadFail: function() {
                $el.loading.addClass('error').text("I've got a bad feeling about this...");
                funcs.init();
            },
            getPos: function(time) {
                time = time || _video.currentTime;
                var pixels = ($el.seek.width() / o.duration) * time;
                return {
                    time: time,
                    pixels: pixels
                };
            },
            toHHMMSS: function(secs) {
                var secs = parseInt(secs, 10);
                var hours = Math.floor(secs / 3600);
                var minutes = Math.floor((secs - (hours * 3600)) / 60);
                var seconds = secs - (hours * 3600) - (minutes * 60);
                if (hours < 10) {
                    hours = "0" + hours;
                }
                if (minutes < 10) {
                    minutes = "" + minutes;
                }
                if (seconds < 10) {
                    seconds = "0" + seconds;
                }
                var time;
                if (hours === "00") {
                    time = minutes + ':' + seconds;
                } else {
                    time = hours + ':' + minutes + ':' + seconds;
                }
                return time;
            },
            setTime: function() {
                var current = funcs.toHHMMSS(funcs.getPos().time.toString());
                var total = funcs.toHHMMSS(o.duration.toString());
                $el.current.text(current);
                $el.total.text(total);
            },
            setVolume: function(e) {
                if (!$(e.target).is($el.grip)) {
                    if ($(e.target).is($el.rail) || $(e.target).is($el.rail.find("*"))) {
                        var x = e.offsetX || e.originalEvent.layerX;
                        var perc = Math.floor(x / $el.rail.width() * 100);
                        $el.grip.css({
                            left: +perc + "%"
                        });
                        var vol = _video.volume;
                        if (perc > 1 && perc < 99) {
                            vol = perc / 100;
                        }
                        _video.volume = vol;
                        if (perc < 3) {
                            funcs.toggleMute(true);
                        } else {
                            funcs.toggleMute(false)
                        }
                    }
                }
            },
            toggleMute: function(on) {
                if (on !== undefined) {
                    if (on) {
                        $video.prop('muted', false);
                        $el.toggle.html('&#61480;');
                    } else {
                        $video.prop('muted', true);
                        $el.toggle.html('&#61478;')
                    }
                }
                if ($video.prop('muted')) {
                    $video.prop('muted', false);
                    $el.toggle.html('&#61480;');
                } else {
                    $video.prop('muted', true);
                    $el.toggle.html('&#61478;');
                }
            },
            reachEnd: function() {
                _video.pause();
                o.isPaused = true;
                o.isFinished = true;
                o.handleFocus = false;
                $el.play.addClass('hidden');
                $el.pause.addClass('hidden');
                $el.replay.removeClass('hidden');
                $el.largePlay.removeClass('hidden');
                clearTimeout(o.seek);
            },
            play: function() {
                _video.play();
                o.isPaused = false;
                $el.play.addClass('hidden');
                $el.largePlay.addClass('hidden');
                $el.pause.removeClass('hidden');
                funcs.clearLoading();
                clearTimeout(o.seek);
                o.seek = setInterval(function() {
                    var w = funcs.getPos();
                    $el.watched.width(w.pixels);
                    if (w.time >= o.duration) {
                        funcs.reachEnd();
                    }
                    funcs.setTime();
                    funcs.getBuffered();
                }, 100);
            },
            pause: function() {
                _video.pause();
                o.isPaused = true;
                $el.pause.addClass('hidden');
                $el.replay.addClass('hidden');
                $el.play.removeClass('hidden');
                $el.largePlay.removeClass('hidden');
                clearTimeout(o.seek);
            },
            replay: function() {
                o.isFinished = false;
                o.isPaused = false;
                $el.pause.addClass('hidden');
                $el.replay.addClass('hidden');
                $el.play.removeClass('hidden');
                $el.largePlay.removeClass('hidden');
                $el.watched.animate({
                    'width': '0'
                }, {
                    duration: 330,
                    complete: function() {
                        _video.currentTime = 0;
                        $el.play.trigger('mouseup.play');
                    }
                });
            },
            seek: function(x, time) {
                x = x || 0;
                if (!time) {
                    var perc = x / $el.seek.width() * 100;
                    var pos = o.duration / 100 * perc;
                    _video.currentTime = pos;
                } else {
                    _video.currentTime = x;
                }
                funcs.setTime();
                var w = funcs.getPos();
                $el.watched.width(w.pixels);
                if (o.isFinished) {
                    funcs.pause();
                    o.isFinished = false;
                }
                if (w.time >= o.duration) {
                    funcs.reachEnd();
                }
            },
            handleDrag: function(x) {
                if (!o.isPaused) {
                    funcs.pause();
                    o.resume = true;
                }
                var perc = x / $el.seek.width() * 100;
                var pos = o.duration / 100 * perc;
                var w = funcs.getPos(pos);
                $el.watched.width(w.pixels);
                funcs.seek(x);
            },
            getBuffered: function() {
                var buffered = 0;
                if (_video.buffered.length > 0) {
                    buffered = _video.buffered.end(0);
                    $el.buffer.width(funcs.getPos(buffered).pixels);
                }
                return buffered;
            },
            clearLoading: function() {
                $el.spinner.addClass('hidden');
                $el.loading.addClass('hidden');
                $video.removeClass('hidden');
                setTimeout(function() {
                    $el.spinner.remove();
                    $el.loading.remove();
                }, 1000);
            }
        };
        var events = function() {
            var t;
            $(window).on({
                'keydown': function(e) {
                    if (o.handleFocus) {
                        var seek = 0;
                        if (e.keyCode === 39) {
                            seek = 0.1;
                        } else if (e.keyCode === 37) {
                            seek = -0.1;
                        }
                        if (e.shiftKey) {
                            seek = seek * 10;
                        }
                        funcs.pause();
                        var time = funcs.getPos().time + seek;
                        funcs.seek(time, true);
                    }
                }
            });
            $player.on({
                'mousedown.player': function(e) {
                    var $what = $el.seek.add($el.handle).add($el.seek.find("*"));
                    if ($(e.target).is($what)) {
                        o.handleDragging = true;
                        o.handleFocus = true;
                    } else {
                        o.handleFocus = false;
                    }
                },
                'mouseup.player': function(e) {
                    o.handleDragging = false;
                    if (o.resume) {
                        funcs.play();
                        o.resume = false;
                    }
                },
                'mousemove.player': function(e) {
                    if (o.handleDragging) {
                        var x = e.offsetX || e.originalEvent.layerX;
                        if ($(e.target).is($el.controls.find("*"))) {
                            if ($(e.target).is($el.time.add($el.time.find("*")))) {
                                x += $el.time.get(0).offsetLeft;
                            } else if ($(e.target).is($el.volume.add($el.volume.find("*")))) {
                                x += $el.volume.get(0).offsetLeft;
                            } else {
                                x += e.target.offsetLeft;
                            }
                        }
                        o.lastDrag = x;
                        funcs.handleDrag(x);
                    }
                },
                'mouseleave.player': function(e) {
                    if (o.handleDragging) {
                        var x;
                        if (o.lastDrag > $player.width() * 0.5) {
                            x = $player.width();
                        } else if (o.lastDrag < $player.width() * 0.5) {
                            x = 0;
                        }
                        o.lastDrag = x;
                        o.handleDragging = false;
                        funcs.handleDrag(x);
                    }
                }
            });
            $video.on({
                'mouseenter.video': function(e) {
                    clearTimeout(t);
                    $player.addClass('active');
                },
                'mouseleave.video': function(e) {
                    clearTimeout(t);
                    t = setTimeout(function() {
                        $player.removeClass('active');
                        $el.controls.removeClass('active');
                    }, 700);
                },
                'mousemove.video': function(e) {
                    $player.addClass('active');
                    clearTimeout(t);
                    t = setTimeout(function() {
                        $player.removeClass('active');
                        $el.controls.removeClass('active');
                    }, 2000);
                },
                'click.video': function() {
                    if (o.isFinished) {
                        $el.replay.trigger('mouseup.replay');
                    } else if (o.isPaused) {
                        $el.play.trigger('mouseup.play');
                    } else {
                        $el.pause.trigger('mouseup.pause');
                    }
                }
            });
            $el.handle.on({
                'mouseover': function(e) {
                    $el.handle.addClass('active');
                },
                'mouseout': function(e) {
                    $el.handle.removeClass('active');
                },
                'mousedown': function(e) {
                    o.handleFocus = true;
                }
            });
            $el.controls.on({
                'mouseenter.controls': function(e) {
                    clearTimeout(t);
                    $player.addClass('active');
                    $el.controls.addClass('active');
                },
                'mouseleave.controls': function(e) {
                    clearTimeout(t);
                    t = setTimeout(function() {
                        $player.removeClass('active');
                        $el.controls.removeClass('active');
                    }, 700);
                }
            });
            $el.play.on({
                'mouseup.play': function(e) {
                    funcs.play();
                }
            });
            $el.largePlay.on({
                'click.play': function() {
                    if (o.isFinished) {
                        $el.replay.trigger('mouseup.replay');
                    } else if (o.isPaused) {
                        $el.play.trigger('mouseup.play');
                    } else {
                        $el.pause.trigger('mouseup.pause');
                    }
                }
            });
            $el.pause.on({
                'mouseup.pause': function(e) {
                    funcs.pause();
                }
            });
            $el.replay.on({
                'mouseup.replay': function(e) {
                    funcs.replay();
                }
            });
            $el.volume.on({
                'mouseup.volume': function(e) {
                    if ($(e.target).is($el.toggle)) {
                        funcs.toggleMute();
                    }
                },
                'mousedown.volume': function(e) {
                    if (!$(e.target).is($el.toggle)) {
                        funcs.setVolume(e);
                    }
                },
                'mouseenter.volume': function(e) {
                    clearTimeout(o.shift);
                    $el.time.addClass('shift');
                    $el.volume.addClass('shift');
                },
                'mouseleave.volume': function(e) {
                    o.shift = setTimeout(function() {
                        $el.time.removeClass('shift');
                        $el.volume.removeClass('shift');
                    }, 1000);
                }
            });
            $el.fullscreen.on({
                'mouseup': function(e) {
                    funcs.fullscreen();
                }
            });
            $el.seek.on({
                'mouseup.seek': function(e) {
                    if (!$(e.target).is($el.handle)) {
                        var x = e.offsetX || e.originalEvent.layerX;
                        funcs.seek(x);
                    }
                }
            });
        };
        $el.loading.appendTo($player);
        $el.spinner.appendTo($player);
        $el.largePlay.appendTo($player).addClass("hidden");
        var loop = 0;
        var ready = setInterval(function() {
            var state = _video.readyState;
            loop++;
            if (state > 1) {
                clearInterval(ready);
                o.duration = _video.duration;
                funcs.setTime();
                funcs.getBuffered();
                funcs.init();
            }
            if (state < 1 && loop > 30) {
                clearInterval(ready);
                funcs.loadFail();
            }
        }, 500);
    });
    timers = new Array();
    oldSetTimeout = window.setTimeout;
    window.setTimeout = function(code, interval) {
        timers.push(oldSetTimeout(code, interval));
    }

    function resetTimeouts() {
        timers = new Array();
    }

    function clearTimeouts() {
        for (var i = 0; i < timers.length; i++) {
            clearTimeout(timers[i]);
        }
        resetTimeouts();
    }
};
jQuery("#togglebtn").on("click", function() {
    jQuery(".left-menu").toggleClass("open");
});
jQuery(document).ready(function($) {
    jQuery("#myElement").click(function() {
        videosec();
    });
});

function videosec() {
    var attra = jQuery(".jw-video").attr("src");
    if (attra == undefined) {
        jQuery(".details-vedio,.favourite-icon").css("display", "none");
        jQuery(".error-video-msg").css("display", "block");
    } else {
        jQuery(".error-video-msg").css("display", "none");
    }
}
jQuery(document).ready(function() {});