// - - - - - - - - - - - - - - - - - - - - - - - - - -

function initSelect (_el) { // _el == $('.js-select-wrap')
    _el.attr('data-select-processed', 'true');

    _el.find('input[type=hidden]').val(_el.find('.js-option-list li:first').attr('data-value'));

    _el.find('.js-select').on('click', function (e) {
        e.preventDefault();
		e.stopPropagation();
        var selectWrap = $(this).closest('.js-select-wrap');
        var optionList = selectWrap.find('.js-option-list');

        if (optionList.is(':visible')) {
            optionList.slideUp('fast');
            $(this).find('.arrow').removeClass('active');
        } else {
            if ($('.js-select-wrap .js-option-list:visible').length) {
                $('.js-select-wrap .js-option-list:visible').hide();
                $('.js-select-wrap .arrow').removeClass('active');
            }

            optionList.slideDown('fast');
            $(this).find('.arrow').addClass('active');
        }
    });

    _el.find('.js-option-list li').on('click', function () {
        var ths = $(this),
            title = _el.find('.js-select .title');

        option = ths.html();
        _el.find('input[type=hidden]').val($(this).attr('data-value'));
        _el.find('input[type=hidden]').trigger('change');
        title.empty();
        title.html(option);
        ths.closest('.js-option-list').slideUp(300);
        _el.find('.arrow').removeClass('active');
        _el.find('.js-option-list li.current').removeClass('current');
        ths.addClass('current');
    });
}

function initCheckbox (_el) { // _el = $('label input[type=checkbox]')
    _el.attr('data-checkbox-processed', 'true');

    if (_el.is(':checked')) _el.closest('label').addClass('checked');

    _el.change(function () {
        if ($(this).is(':checked')) {
            _el.closest('label').addClass('checked');
        } else {
            _el.closest('label').removeClass('checked');
        }
    });
}

function initTruncation (_el) { // _el = $('.truncate-title')
    _el.attr('data-truncation-processed', 'true');

    _el.dotdotdot({
        watch: 'window'
    });
}

function initMenuPopup (_el) { // _el = $('.js-menu-popup-link, .js-menu-popup')
    _el.attr('data-menupopup-processed', 'true');

    _el.hover(function () {
        $(this).closest('.menu-popup-wrap').addClass('hovered');
    }, function () {
        $(this).closest('.menu-popup-wrap').removeClass('hovered');
    });
}

function initMenuLink (_el) { // _el = $('.js-menu-link')
    _el.attr('data-menulink-processed', 'true');


    var wrap = _el.closest('.js-menu-wrap'),
        dataAttr = _el.attr('data-cat'),
        menuOpen = wrap.find('.js-menu-open[data-cat='+dataAttr+']');
		

    _el.on('mouseenter', function (){
        wrap.find('.current').removeClass('current');
        wrap.find('.js-menu-link.active').removeClass('active');
        menuOpen.addClass('current');
        _el.addClass('active');
    }).on('mouseleave', function (){
        // menuOpen.removeClass('current');
    });
}

function initTooltip (_el) { // _el = $('.js-with-tooltip')
    _el.attr('data-tooltip-processed', 'true');

    _el.hover(function () {
        $(this).addClass('hover');
    }, function (){
        $(this).removeClass('hover');
    });
}
// ќб¤зательно смержить так!
function initRange (_el) { // _el = $('#slider-range')
    _el.attr('data-range-processed', 'true');

	var min = Number($('#fromRange b').text());
	var max = Number($('#toRange b').text());

	var cmin = Number($('.filter_prices .min-price').val());
	var cmax = Number($('.filter_prices .max-price').val());
	
	if(cmax==0) cmax=max;
	
	//alert(cmax)

    _el.slider({
        range: true,
		min: min,
		max: max,
		values: [ cmin, cmax ],

        slide: function( event, ui ) {
            //$('#fromRange b').html(ui.values[ 0 ]); 
            //$('#toRange b').html(ui.values[ 1 ]);
			
			$('.filter_prices .min-price').val(ui.values[ 0 ]);
			$('.filter_prices .max-price').val(ui.values[ 1 ]);
        }
    });
}

function initTimeSlider (_el) { // _el = $('.time-slider')
    _el.attr('data-timeslider-processed', 'true');

    var _from = _el.data('from'),
        _to = _el.data('to'),
        _dep_el_from = _el.data('el_name_from'),
        _dep_el_to = _el.data('el_name_to'),
        values = [ 0, 0.5, 1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5, 5.5, 6, 6.5, 7, 7.5, 8, 8.5, 9, 9.5, 10, 10.5, 11, 11.5, 12, 12.5, 13, 13.5, 14, 14.5, 15, 15.5, 16, 16.5, 17, 17.5, 18, 18.5, 19, 19.5, 20, 20.5, 21, 21.5, 22, 22.5, 23 ];

    function prett(n){
        n_int = parseInt(n);
        n_int = (n_int < 10) ? ('0' + n_int) : n_int;

        return (n % 1 === 0) ? (n_int + ':00') : (n_int + ':30');
    }

    var range_slider = _el.find('.time-slider__box').ionRangeSlider({
        type: 'double',
        from : 16,
        to : 30,

        values: values,

        prettify: function (n) {
            return prett(n);
        },
        onStart: function (data) {
            if($("[name=" + _dep_el_from + "]").length){
                $("[name=" + _dep_el_from + "]").val(prett(values[data.from]));
            }
            if($("[name=" + _dep_el_to + "]").length){
                $("[name=" + _dep_el_to + "]").val(prett(values[data.to]));
            }

        },
        onChange: function(data){
            if($("[name=" + _dep_el_from + "]").length){
                $("[name=" + _dep_el_from + "]").val(prett(values[data.from]));
            }
            if($("[name=" + _dep_el_to + "]").length){
                $("[name=" + _dep_el_to + "]").val(prett(values[data.to]));
            }
        }
    });
}

function initFileInput (_el) { // _el = $('.sec-order__form-file input')
    _el.attr('data-fileinput-processed', 'true');

    _el.on('change', function () {
        var _f = $(this).val().split('\\').pop();

        $(this).parent().find('a span').html(_f);
    });
}

function initXSselect (_el) { // _el = $('.select-wrap--XS select')
    _el.attr('data-xsselect-processed', 'true');

    var _ph = _el.closest('.select-wrap').find('.select-XSplaceholder'),
        _s = _el.closest('.select-wrap').parent().find('.select-wrap--notXS');

    _el.on('change', function () {
        var _v = $(this).val(),
            _l = $(this).find(":selected").html();

        _ph.html(_l);

        // Update desktop select

        var ths = _s.find('.js-option-list li[data-value="' + _v + '"]'),
            title = _s.find('.js-select .title');

        option = ths.html();
        _s.find('input[type=hidden]').val(_s.attr('data-value'));
        title.empty();
        title.html(option);
        ths.closest('.js-option-list').slideUp(300);
        _s.find('.arrow').removeClass('active');
        _s.find('.js-option-list li.current').removeClass('current');
        ths.addClass('current');
    });

    _s.find('input[type=hidden]').on('change', function () {
        _el.val($(this).val());

        _ph.html(_el.find(":selected").html());
    });
}

function initGender (_el) { // _el = $('.js-gender')
    _el.attr('data-gender-processed', 'true');

    var _s = _el.find('.js-select-wrap');

    _el.find('input[type=radio]').on('change', function () {
        var _v = $(this).val();

        if ($(this).is(':checked')) {
            // Update desktop select

            var ths = _s.find('.js-option-list li[data-value="' + _v + '"]'),
                title = _s.find('.js-select .title');

            option = ths.html();
            _s.find('input[type=hidden]').val(_s.attr('data-value'));
            title.empty();
            title.html(option);
            ths.closest('.js-option-list').slideUp(300);
            _s.find('.arrow').removeClass('active');
            _s.find('.js-option-list li.current').removeClass('current');
            ths.addClass('current');
        }
    });

    _s.find('input[type=hidden]').on('change', function () {
        _el.find('input[type=radio]').prop('checked', false);
        _el.find('input[type=radio][value=' + $(this).val() + ']').prop('checked', true);
    });
}

function initSearch (_el) { // _el = $('.search-field input')
    _el.attr('data-search-processed', 'true');

    /* _el.on('focus keyup', function () {
     if ($(this).val() != '') {
     $(this).closest('.search-field').find('.search-field__box').slideDown(100);
     } else {
     $(this).closest('.search-field').find('.search-field__box').slideUp(100);
     }
     });*/

    _el.on({
        focus: function () { $(this).closest('.search-field').addClass('focus'); },
        blur: function () {
            $(this).closest('.search-field').removeClass('focus');

            /* if ($(this).val() == '')
             $(this).closest('.search-field').find('.search-field__box').slideUp(100);*/
        }
    });

    _el.on({
        keydown: function (e) {
            var _b = $(this).closest('.search-field').find('.search-field__box'),
                _i = _b.find('.scrollbar-outer').filter('.scroll-content'),
                _f = _b.find('.search-field__box-field');

            if (e.which == 40) {
                if (_f.filter('.active').length <= 0) {
                    _f.first().addClass('active');
                } else {
                    var _o = _f.filter('.active').first(),
                        _n = _b.find(_o).nextAll('.search-field__box-field').first();

                    if (_n.length > 0) {
                        _f.filter('.active').removeClass('active');
                        _n.addClass('active');

                        // PUT TEXT FROM FIELD _n IN SEARCH BAR

                        if (_i.height() - (_n.offset().top - _i.offset().top) - _n.height() < 75)
                            _i.scrollTop(_i[0].scrollTop + _n.height() + 75);
                    }
                }
            }

            if (e.which == 38) {
                if (_f.filter('.active').length > 0) {
                    var _o = _f.filter('.active').first(),
                        _n = _b.find(_o).prevAll('.search-field__box-field').first();

                    if (_n.length > 0) {
                        _f.filter('.active').removeClass('active');
                        _n.addClass('active');

                        // PUT TEXT FROM FIELD _n IN SEARCH BAR

                        if (_n.offset().top - _i.offset().top < 75)
                            _i.scrollTop(_i[0].scrollTop - _n.height() - 75);
                    }
                }
            }
        }
    });
}

function initScrollbar (_el) { // _el = $('.scrollbar-outer')
    _el.attr('data-scrollbar-processed', 'true');

    _el.jScrollPane();
}

function initFixedScroll (_el) { // _el = $('.fixedScroll');
    _el.attr('data-fixedscroll-processed', 'true');

    if (_el.length > 0) {
        if(!_el.parent().length) // broken object check
            return false;

        _el.css({
            'position': 'absolute',
            'right': '0',
            'z-index': '9'
        });

        $(window).on('load resize scroll', function () {
            if(!_el.parent().length){ // off removed dom
                return;
            }
            var _t = $(this),
                _wT = _t.scrollTop(),
                _elT = _el.parent().offset().top;
				_fixHeader = $('.fixed-header').outerHeight();

            if (_elT - _wT < 50) {
                var _top = _wT - _elT + 50
                _fixLine = $('.fixedScroll__redline:visible').first();

                if (_fixLine.length > 0) {
                    _rl = _fixLine.offset().top;

					if (_top + _el.outerHeight() + _elT >= _rl - (30+  _fixHeader))
						_top = _rl - (30+  _fixHeader) - _el.outerHeight() - _elT;
                }


				_el.css('top', _top+_fixHeader);
            } else {
                _el.css('top', '0');
            }
        });
    }
}

function initPlaceholder (_el) { // _el = $('[placeholder]');
    _el.attr('data-placeholder-processed', 'true');

    if (isIE) {
        var _ph = _el.attr('placeholder');

        _el.data('ph', _ph);

        _el.attr('placeholder', '').focus(function () {
            if (_el.val() == _ph) {
                _el.val('');
                _el.removeClass('input--ph');
            }
        }).blur(function () {
            if (_el.val() == '' || _el.val() == _ph) {
                _el.addClass('input--ph');
                _el.val(_ph);
            }
        }).blur();
    }
}

function initTagSelect (_el) { // _el = $('.tag-select')
    _el.attr('data-tagselect-processed', 'true');

    function updateTag (_v, _p) {
        var _t = _tbox.find('[data-value="' + _v + '"]');

        if (_p) {
            _t.addClass('shown');
        } else {
            _t.removeClass('shown');
        }

        if (_tbox.find('.tag-select--tag.shown').length <= 0) {
            _tbox.addClass('empty');
        } else {
            _tbox.removeClass('empty');
        }
    }

    function appendSelect (_v, _t) {
        var _t = $('<div class="tag-select--tag" data-value="' + _v + '">' + _t + '<span></span></div>').appendTo(_tbox);

        _t.on({
            click: function () {
                var _i = _cbox.find('input[value="' + _v + '"]');

                _i.prop('checked', false);
                _i.trigger('change');
            }
        });
    }

    var _sel = _el.find('select'),
        _tbox = _el.find('[data-for-tags]'),
        _cbox = _el.find('[data-checkboxes]');

    _sel.find('option:not([disabled])').each(function () {
        var _t = $(this);

        appendSelect (_t.attr('value'), _t.html());
    });

    var selectChangeMethod = false;

    _sel.on({
        change: function () {
            selectChangeMethod = true;

            var _values = $(this).val();

            _cbox.find('input').prop('checked', false);
            _cbox.find('input').trigger('change');

            $.each(_values, function () {
                var _c = _cbox.find('input[value="' + this + '"]');

                _c.prop('checked', true);
                _c.trigger('change');
            });

            selectChangeMethod = false;
        }
    });

    _cbox.find('input').on({
        change: function () {
            var _p = $(this).prop('checked'),
                _v = $(this).attr('value'),
                _o = _sel.find('option[value="' + _v + '"]');

            updateTag (_v, _p);

            if (!selectChangeMethod) _o.prop('selected', _p);
        }
    });
}

function initUI () {
    // Select stylization
    $('.js-select-wrap').each(function () {
        if ($(this).attr('data-select-processed') != 'true')
            initSelect ($(this));
    });

    // Checkbox stylization
    $('label input[type=checkbox]').each(function () {
        if ($(this).attr('data-checkbox-processed') != 'true')
            initCheckbox ($(this));
    });

    // Text truncation
    $('.truncate-title').each(function () {
        if ($(this).attr('data-truncation-processed') != 'true')
            initTruncation ($(this));
    });

    // Menu Popup
    $('.js-menu-popup-link, .js-menu-popup').each(function () {
        if ($(this).attr('data-menupopup-processed') != 'true')
            initMenuPopup ($(this));
    });

    // Main menu functionallity
    $('.js-menu-link').each(function () {
        if ($(this).attr('data-menulink-processed') != 'true')
            initMenuLink ($(this));
    });

    // Tooltip
    $('.js-with-tooltip').each(function () {
        if ($(this).attr('data-tooltip-processed') != 'true')
            initTooltip ($(this));
    });

    // jQuery ui slider
    $('#slider-range').each(function () {
        if ($(this).attr('data-range-processed') != 'true')
            initRange ($(this));
    });

    // Time slider
    $('.time-slider').each(function () {
        if ($(this).attr('data-timeslider-processed') != 'true')
            initTimeSlider ($(this));
    });

    // File input
    $('.sec-order__form-file input').each(function () {
        if ($(this).attr('data-fileinput-processed') != 'true')
            initFileInput ($(this));
    });

    // XS Select
    $('.select-wrap--XS select').each(function () {
        if ($(this).attr('data-xsselect-processed') != 'true')
            initXSselect ($(this));
    });

    // Search
    $('.search-field input').each(function () {
        if ($(this).attr('data-search-processed') != 'true')
            initSearch ($(this));
    });

    // Scrollbar
    $('.scrollbar-outer').each(function () {
        if ($(this).attr('data-scrollbar-processed') != 'true')
            initScrollbar ($(this));
    });

    // Gender
    $('.js-gender').each(function () {
        if ($(this).attr('data-gender-processed') != 'true')
            initGender ($(this));
    });

    // Fixed scroll
    $('.fixedScroll').each(function () {
        if ($(this).attr('data-fixedscroll-processed') != 'true')
            initFixedScroll ($(this));
    });

    // IE placeholders
    $('[placeholder]').each(function () {
		if ($(this).attr('data-placeholder-processed') != 'true') {
			//initPlaceholder ($(this));
		}
    });

    // IE placeholders
    $('.tag-select').each(function () {
        if ($(this).attr('data-tagselect-processed') != 'true')
            initTagSelect ($(this));
    });
}
// - - - - - - - - - - - - - - - - - - - - - - - - - -

var isIE = false;

/* ????????? ????? ???????? ?????? | trigger when page is ready */
$(document).ready(function (){
    if ($('.fancybox').length > 0)
        $('.fancybox').fancybox({
            loop: false
        });

    //MOBILE support
    var isMobileDevice = false;
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        isMobileDevice = true;
        $('.wrapper').addClass('is-mobile');
    }

    //Layout
    var mobileBlock = $('.mobile-block');

    var userAgent = userAgent || navigator.userAgent;
    if (userAgent.indexOf("MSIE ") > -1 || userAgent.indexOf("Trident/") > -1) {
        $('html').addClass('ie');

        isIE = true;
    }

    // - - - - - - - - - - - - - - - - - - - - - - - - - -

    initUI ();

    // - - - - - - - - - - - - - - - - - - - - - - - - - -

	$("body").on("submit", ".bootstrap form", function() {
		var form_data=$(this).serialize();
		$.post("/include/addtoreminder.php", form_data, function (data) {
			$.magnificPopup.open({
			  items: {
				  src: data,
				  type: 'inline'
			  }
			});
		});
		return false;
	});
	
    $('.slider-main').slick({ dots: true });

    $('.diabet-page--slider-in').slick({
        infinite: false,
        accessibility: false,
        draggable: false,
        swipe: false,
        touchMove: false
    }).on('beforeChange', function(event, slick, currentSlide, nextSlide) {
        if (nextSlide == slick.slideCount - 1) {
            $('.diabet-page--slider .slick-arrow').remove();
        }
    });

    $('.slider-cat').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4
                }
            },
            {
                breakpoint:820,
                settings: {
                    slidesToShow: 3,
                    centerMode:true,
                    centerPadding:'30px'
                }
            },
            {
                breakpoint:600,
                settings: {
                    slidesToShow: 2,
                    centerMode: false
                }
            },
            {
                breakpoint:430,
                settings: {
                    slidesToShow: 1,
                    centerMode:true,
                    centerPadding: '70px'
                }
            }
        ]
    });

	/*WS*/
	$('.slider-vertical').each(function(){
		var self = $(this);
		$(this).slick({
			slidesToShow: self.data("slide_to_show") || 5,
        slidesToScroll: 1,
        vertical: true,
			autoplay: false
    });
	})

    $('.slider-viewed').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: false,

        responsive: [
            {
                breakpoint: 960,
                settings: {
                    variableWidth: true,
                    slidesToShow: 1
                }
            },
            {
                breakpoint:720,
                settings: {
                    variableWidth: true,
                    slidesToShow: 1
                }
            },
            {
                breakpoint: 520,
                settings: {
                    variableWidth: true,
                    slidesToShow: 1
                }
            }
        ]
    });

    $('.relinks--slider').slick({
        slidesToShow: 7,
        slidesToScroll: 1,
        infinite: false,

        responsive: [
            {
                breakpoint: 960,
                settings: {
                    variableWidth: true,
                    slidesToShow: 1
                }
            },
            {
                breakpoint:720,
                settings: {
                    variableWidth: true,
                    slidesToShow: 1
                }
            },
            {
                breakpoint:520,
                settings: {
                    variableWidth: true,
                    slidesToShow: 1
                }
            }
        ]
    });

    $('.slider-brands').slick({
        infinite: true,
        speed: 300,
        slidesToShow: 6,
        variableWidth: true,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 5,
                    centerMode: true
                }
            },
            {
                breakpoint:780,
                settings: {
                    slidesToShow: 4,
                    centerMode: false
                }
            },
            {
                breakpoint:500,
                settings: {
                    slidesToShow: 3,
                    centerMode:true
                }
            }
        ]
    });

    $('.sec-order__info-widget-vSlider').slick({
        vertical: true,
        slidesToShow: 4
    });

    $('.sec-articles__photo-slider').slick();

    $('.sec-article__slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint:520,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    // Очистка всей корзины
    $(document).on('click', ".b-clean__basket-link", function(e){
        e.preventDefault();
        var d = 100;

        if (typeof bIsMobileView !== "undefined" && bIsMobileView){
            if (confirm("Удалить все товары из корзины?")){
                $.get("/include/action_for_all.php", "action=delete_basket", function () {
                    location.reload();
                });
            }
        } else {

            swal({
                    title: "Удалить все товары из корзины?",
                    text: '',
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Да",
                    cancelButtonText: "Нет",
                    allowOutsideClick: true,
                    closeOnConfirm: true,
                    html:true
                },
                function(){
                    $.get("/include/action_for_all.php", "action=delete_basket", function () {
                        location.reload();
                    });
                });
        }

    })

    // - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Нажатие на кнопку вверх
    $('.btn-top a').on("click touchstart", function() {
        $('html, body').animate({
            scrollTop: $(".wrapper").offset().top
        }, 1000);
        return false
    });

    // Выбор модификации
	$(document).on('click', '.sec-offer-prop a', function (e) {
		e.preventDefault ();
		var price=$(this).attr("data-price");
		var maxq=$(this).attr("data-max");
		
		var inbasket=$(this).attr("data-inbasket");

		var offer_id=$(this).attr("data-id");
		var qmax=$(this).attr("data-max");
		var available=$(this).attr("data-canbuy");
		var curli=$(this).parents(".for-transform");
		var curoffer=$(this).parents(".sec-offer-prop");
		var plusminus=$(this).parents(".for-transform").find("._plusMinus"); 
		
		var incart=$(this).parents(".for-transform").find(".in_cart"); 
		var ali=$(this).parents(".for-transform").find(".presence-list li");
		
		$(this).closest(".for-transform").find(".article").hide();
		$("#offer_art_" + offer_id).show();
		
		if(parseInt(qmax) < 5)
		{
			$(ali).removeClass("green").removeClass("yellow");
			$(ali).addClass("red");
			$(ali).eq(0).show();
			$(ali).eq(1).hide();
			$(ali).eq(2).hide();
			$(ali).eq(3).hide();
			$(ali).eq(4).hide();
		}
		else if(parseInt(qmax) < 20)
		{
			$(ali).removeClass("red").removeClass("green");
			$(ali).addClass("yellow");
			$(ali).eq(0).show();
			$(ali).eq(1).show();
			$(ali).eq(2).show();
			$(ali).eq(3).hide();
			$(ali).eq(4).hide();			
		}
		else
		{
			$(ali).removeClass("red").removeClass("yellow");
			$(ali).addClass("green");
			$(ali).eq(0).show();
			$(ali).eq(1).show();
			$(ali).eq(2).show();
			$(ali).eq(3).show();
			$(ali).eq(4).show();			
		}
		
		$(plusminus).attr("data-price", price);
		$(plusminus).attr("data-sale_price", price);
		$(plusminus).attr("data-common_price", price);
		$(plusminus).attr("data-min_qty", maxq);
		$(plusminus).attr("data-id", offer_id);
		
		$(this).parents(".for-transform").find("._addCount").attr("max", qmax); 
		
		$(curli).find(".cur-price").text(price);
		$(curli).find(".bprice").text(price);
		$(curli).find(".added-offer").text($(this).text());
		
		$(curli).find(".sec-offer-prop").removeClass("curr-offer");
		$(curoffer).addClass("curr-offer");
		
		
		$(curli).find("._addToCart").attr("data-id", offer_id);
		$(curli).find("._noticeMe").attr("data-id", offer_id);
		
		console.log(inbasket);  
		
		if(parseInt(inbasket) > 0) 
		{
			$(curli).find("._addCount").val(inbasket);
			$(curli).find("._addToCart").addClass("in_cart").text("В корзине").attr('href','/personal/cart/');
		}
		else
		{
			$(curli).find("._addCount").val(1); 
			$(curli).find("._addToCart").removeClass("in_cart").text("Купить").attr('href','');
		}
			
		if(available=="N")
		{
			$(plusminus).hide();
			$(incart).hide();
			$("#q_av").hide();
			$("#q_os").show();
			$(curli).find("._addToCart").hide();
			$(curli).find("._noticeMe").show();			
		}
		else
		{
			$(plusminus).show();
			$(incart).show();
			$("#q_av").show();
			$("#q_os").hide();			
			$(curli).find("._addToCart").show();
			$(curli).find("._noticeMe").hide();				
		}

		
		
		//alert(curli);			
		//$(this).parent(".item-card").find(".cur-price").text(price);
		
	});

    $(document).on('click', 'a[href=#]', function (e) { e.preventDefault (); });

    //Js-toggle
    $(document).on('click', '.js-toggle-link', function (e) {
        e.preventDefault ();

        var ths = $(this),
            wrap = ths.closest('.js-toggle-wrap'),
            block = wrap.find('.js-toggle-block');
        block.slideToggle(300);
        ths.toggleClass('active');
    });

    // Hamburger functionality
    $(document).on('click', '.js-hamburger-link', function (e) {
        e.preventDefault ();

        var slideBlock = $('.mobile-block'),
            slideContent = $(this).closest('.wrapper'),
            screen = mobileBlock.find('.js-screen.screen-center'),
            screenTop = screen.outerHeight(),
            wrapperFixed = $('#wrapperFixed');

        slideContent.stop(true, true).animate({left: parseInt(slideContent.css('left'), 10) == 0 ? slideBlock.outerWidth()/2 : 0});
        wrapperFixed.stop(true, true).animate({left: parseInt(slideContent.css('left'), 10) == 0 ? slideBlock.outerWidth()/2 : 0});
        slideBlock.toggleClass('open');
        wrapperFixed.toggleClass('active');
        $('body').toggleClass('overflow-hidden');

        setTimeout(function (){
            slideBlock.css({ height: $('body').height() });
            initScrollbar(slideContent.find('.scrollbar-outer'));
        }, 10);
    });

    $(document).on('click touchstart', '#wrapperFixed', function (e) {
        e.preventDefault ();

        $('.js-hamburger-link').click();
    });

    // Mobile menu functionallity
    $(document).on('click', '.js-forward-link', function (e) {
        e.preventDefault ();

        var ths = $(this),
            wrap = ths.closest('.js-screen-wrap'),
            screenCenter = ths.closest('.js-screen.screen-main'),
            dataAttr = ths.attr('data-screen'),
            screenRight = wrap.find('.js-screen.screen-right[data-screen='+dataAttr+']');

        screenRight.removeClass('screen-right').addClass('screen-center');
    });

    $(document).on('click', '.js-back-link', function (e) {
        e.preventDefault ();

        var ths = $(this),
            wrap = ths.closest('.js-screen-wrap'),
            screenCenter = ths.closest('.js-screen.screen-center'),
            screenLeft = wrap.find('.js-screen.screen-left');

        screenCenter.removeClass('screen-center').addClass('screen-right');
    });

    //Add to cart
    $(document).on('click', '.js-buy-link', function (e) {
        e.preventDefault();

        var ths = $(this),
            parent = ths.closest('.for-transform');

        parent.addClass('flipped');
        parent.find('.spinbox input[type=text]').val(1);
    });

    // With-drop block
    $(document).on('click', '.js-with-drop-link', function (e) {
        e.preventDefault ();

        var ths = $(this),
            wrap = ths.closest('.js-with-drop-wrap'),
            block = wrap.find('.js-with-drop-block');

        if (block.is(':visible')) {
            block.hide();
            wrap.removeClass('open');
            ths.removeClass('open');
        } else {
            if ($('.js-with-drop-wrap .js-with-drop-block:visible').length){
                $('.js-with-drop-wrap .js-with-drop-block:visible').hide();
                $('.js-with-drop-wrap').removeClass('open');
                $('.js-with-drop-wrap .js-with-drop-link').removeClass('open');
            }

            block.fadeIn(300);
            wrap.addClass('open');
            ths.addClass('open');
        }
    });

    // Scroll-link animation
    $(document).on('click', '.js-scroll-link', function (e) {
        e.preventDefault ();

        var elementClick = $(this).attr('href'),
            destination = $(elementClick).offset().top,
            plusFastmenu = $('#fastMenu').outerHeight(), // fix класс .fixed примен¤етс¤ только при прокрутке, поэтому в обычном положении селектор дает null
            plusCardSmallFixed = $('#cardFormSmall.fixed').outerHeight(),
            cardNavFixed = $('#cardNav.fixed').outerHeight();

        if ($('#cardFormSmall').length) {
            $('html:not(:animated),body:not(:animated)').animate({ scrollTop: destination - 80 - plusFastmenu - plusCardSmallFixed - 55 }, 900);
            return false;
        } else {
            $('html:not(:animated),body:not(:animated)').animate({ scrollTop: destination - 80 - plusFastmenu - 55 }, 900);
            return false;
        }
    });

    // Dropdown func
    $(document).on('click', '.js-dropdown-link', function (e) {
        e.preventDefault ();
		e.stopPropagation ();

        if ($(this).closest('.breadcrumbs').length <= 0) {
            var ths = $(this),
                wrap = ths.closest('.js-dropdown-wrap');
            block = wrap.find('.js-dropdown-block');

            if (block.is(':visible')){
                if(wrap.hasClass('js-dropdown-fade')) {
                    block.hide();
                } else {
                    block.slideDown('fast');
                }
                block.slideUp('fast');
                ths.removeClass('open');
            } else {
                if ($('.js-dropdown-wrap .js-dropdown-block:visible').length){
                    $('.js-dropdown-wrap .js-dropdown-block:visible').hide();
                    $('.js-dropdown-wrap .js-dropdown-link').removeClass('open');
                }
                if(wrap.hasClass('js-dropdown-fade')) {
                    block.fadeIn(300);
                    console.log('aa');
                } else {
                    block.slideDown('fast');
                }

                ths.addClass('open');
            }
        }
    });

    // Filter Dropdown func
    $(document).on('click', '.js-filter-dropdown-link', function (e) {
        e.preventDefault ();

        var wrap = $(this).closest('.js-filter-dropdown-wrap'),
            block = wrap.find('.js-filter-dropdown-block');

        if (block.is(':visible')){
            block.slideUp('fast');
        } else {
            if ($('.js-filter-dropdown-wrap .js-filter-dropdown-block:visible').length){
                $('.js-filter-dropdown-wrap .js-filter-dropdown-block:visible').hide();
            }
            block.slideDown('fast');
        }
    });

    $(document).on('click', '.filter-module .js-choose-link', function (e) {
        e.preventDefault ();

        var ths = $(this),
            dropdownWrap = ths.closest('.js-filter-dropdown-wrap'),
            dropdownBlock = dropdownWrap.find('.js-filter-dropdown-block'),
            dropdownLink = dropdownWrap.find('.js-filter-dropdown-link'),
            dropdownValue = dropdownWrap.find('.js-with-value'),
            chosenValue = dropdownValue.find('.js-chosen-value'),
            dataWord = dropdownValue.attr('data-word'),
            dataPlural = dropdownValue.attr('data-plural');

        if (dropdownBlock.find('input[type="checkbox"]:checked').length == 1) {
            var oneValue = dropdownBlock.find('input[type="checkbox"]:checked').next('.js-value-to-choose').html();
            chosenValue.html(dataWord+ '&nbsp;' +oneValue);
            dropdownValue.fadeIn(300);
            dropdownLink.hide();
            dropdownBlock.hide();
        } else if (dropdownBlock.find('input[type="checkbox"]:checked').length > 1){
            var amount = dropdownBlock.find('input[type="checkbox"]:checked').length;
            chosenValue.html(amount+ '&nbsp;' +dataPlural);
            dropdownValue.fadeIn(300);
            dropdownLink.hide();
            dropdownBlock.hide();
        }
    });

    $(document).on('click', '.filter-module .js-delete-link', function (e) {
        e.preventDefault ();

        var ths = $(this),
            dropdownWrap = ths.closest('.js-filter-dropdown-wrap'),
            dropdownLink = dropdownWrap.find('.js-filter-dropdown-link'),
            dropdownValue = dropdownWrap.find('.js-with-value');

        dropdownValue.hide();
        dropdownLink.fadeIn(300);
    });

    $(document).on('click', '.filter-module .js-reset-link', function (e) {
        e.preventDefault ();

        var ths = $(this),
            filterModule = ths.closest('.filter-module');
        filterModule.find('.js-with-value').hide();
        filterModule.find('.js-filter-dropdown-link').fadeIn(300);
    });

    // Show Hide func
    $(document).on('click', '.js-show-hide-link', function (e) {
        e.preventDefault ();

        var ths = $(this),
            wrap = ths.closest('.js-show-hide-wrap'),
            block = wrap.find('.js-show-hide-block');

        block.slideToggle(300);
        ths.toggleClass('active');
    });

    // Show Hide cat
    $(document).on('click', '.js-show-cat-link', function (e) {
        e.preventDefault ();

        var ths = $(this),
            wrap = ths.closest('.js-show-cat-wrap'),
            block = wrap.find('.js-show-cat-block');

        block.slideToggle(300);
        ths.toggleClass('active');
    });

    //Heart-list behaviour
    $(document).on('click', '.js-stars a', function (e) {
        e.preventDefault ();

        var ths = $(this),
            wrap = ths.closest('.js-stars');

        ths.addClass('full checked');
        ths.prevAll('a').addClass('full checked');
        ths.nextAll('a').removeClass('full checked');
    });

    //Heart-list behaviour
    $(document).on('mouseenter', '.js-stars a', function (e) {
        e.preventDefault ();

        var ths = $(this),
            wrap = ths.closest('.js-stars');

        ths.addClass('full');
        ths.prevAll('a').addClass('full');
        ths.nextAll('a').removeClass('full');
    });

    //Heart-list behaviour
    $(document).on('mouseleave', '.js-stars a', function (e) {
        e.preventDefault ();

        var ths = $(this),
            wrap = ths.closest('.js-stars');

        wrap.find('a').removeClass('full');
        wrap.find('a.checked').addClass('full');
    });

    // js-submit-btn
    $(document).on('click', '.js-submit-btn', function (e) {
        e.preventDefault ();

        var ths = $(this),
            form = ths.closest('.js-submit-form');

        if(form.data('hide') != "N")
            form.hide();
    });

    // js-close-btn
    $(document).on('click', '.js-close-btn', function (e) {
        e.preventDefault ();

        var ths = $(this),
            block = ths.closest('.js-close-block');

        block.hide();
    });

    $(document).on('click', '.js-enter-module-link', function (e) {
        e.preventDefault ();

        var ths = $(this),
            wrap = ths.closest('.js-popup'),
            enterModule = wrap.find('.js-enter-module'),
            registerModule = wrap.find('.js-register-module'),
            repairModule = wrap.find('.js-repair-module'),
            repair2Module = wrap.find('.js-repair2-module');

        enterModule.removeClass('display-none');
        registerModule.addClass('display-none');
        repairModule.addClass('display-none');
        repair2Module.addClass('display-none');
    });

    $(document).on('click', '.js-register-module-link', function (e) {
        e.preventDefault ();

        var ths = $(this),
            wrap = ths.closest('.js-popup'),
            enterModule = wrap.find('.js-enter-module'),
            registerModule = wrap.find('.js-register-module'),
            repairModule = wrap.find('.js-repair-module'),
            repair2Module = wrap.find('.js-repair2-module');

        enterModule.addClass('display-none');
        registerModule.removeClass('display-none');
        repairModule.addClass('display-none');
        repair2Module.addClass('display-none');
    });

    $(document).on('click', '.js-repair-module-link', function (e) {
        e.preventDefault ();

        var ths = $(this),
            wrap = ths.closest('.js-popup'),
            enterModule = wrap.find('.js-enter-module'),
            registerModule = wrap.find('.js-register-module'),
            repairModule = wrap.find('.js-repair-module'),
            repair2Module = wrap.find('.js-repair2-module');

        enterModule.addClass('display-none');
        registerModule.addClass('display-none');
        repairModule.removeClass('display-none');
        repair2Module.addClass('display-none');
    });

	window.in_ajax = 0;
    $(document).on('click', '.js-repair2-module-link', function (e) {
        e.preventDefault ();
        var ths = $(this),
            wrap = ths.closest('.js-popup');

        var _ = ths.closest('form');
        var data = _.serialize();
		if(window.in_ajax == 0){
			window.in_ajax = 1;
			$.ajax({
				data:data,
				url:'/include/password_forgotten.php',
				method:'post',
				dataType:'json',
				success: function(data){
					console.log(data);
					window.in_ajax = 0;
					if(data['error']){
						wsPoperValid.init([
							_.find('[name=USER_EMAIL]'),data['error']
						]);
					}else{
						wrap.find('.js-enter-module').addClass('display-none');
						wrap.find('.js-register-module').addClass('display-none');
						wrap.find('.js-repair-module').addClass('display-none');
						wrap.find('.js-repair2-module').removeClass('display-none');
						wrap.find('.js-repair-email').removeClass('dn');

					}
				}
			});
		}

    });

    //popups
    $(document).on('click', '.js-enter-popup-link', function (e) {
        e.preventDefault ();
		e.stopPropagation ();

        $('#shadow').fadeIn(300);
        $('.enter-popup').css({top: $(window).scrollTop()+ 60}).fadeIn(300);
    });

    $(document).on('click', '.js-metro-popup-link', function (e) {
        e.preventDefault ();

        $('#shadow').fadeIn(300);
        $('.metro-popup').css({top: $(window).scrollTop()+ 60}).fadeIn(300);
    });

    $(document).on('click', '.js-address-popup-link', function (e) {
        e.preventDefault ();

        $('#shadow').fadeIn(300);
        $('.add-address-popup').css({top: $(window).scrollTop()+ 60}).fadeIn(300);
    });

    $(document).on('click', '.js-popup .js-close-popup', function (e) {
        e.preventDefault ();

        $(this).closest('.js-popup').fadeOut();
        $('#shadow').fadeOut(300);
		e.stopPropagation();
    });

    // Accordeon
    $(document).on('click', '.js-unit-link', function (e) {
        e.preventDefault ();

        var ths = $(this),
            wrap = ths.closest('.js-unit-wrap'),
            dropdown = wrap.find('.js-dropdown-unit');

        dropdown.slideToggle(300);
        ths.toggleClass('active');
    });

    // Sort-block
    $(document).on('click', '.js-sort-link', function (e) {
        e.preventDefault ();

        var ths = $(this),
            wrap = ths.closest('.js-sort-wrap');

        if (ths.hasClass('current')) {
            if (ths.hasClass('up')) {
                ths.removeClass('up');
                ths.addClass('down');
            } else if (ths.hasClass('down')) {
                ths.removeClass('down');
                ths.addClass('up');
            }
        } else {
            wrap.find('.current').removeClass('current up down');
            ths.addClass('current down');
        }
    });

    //filter-for-mobile
    $(document).on('click', '.js-mobile-title', function (e) {
        e.preventDefault ();

        var ths = $(this),
            wrap = ths.closest('.js-filter-sidebar-wrap'),
            block = wrap.find('.js-filter-for-mobile');

        block.slideToggle(300);
        ths.toggleClass('active');
    });

    // Choose metro-station
    $(document).on('click', '.js-station-link', function (e) {
        e.preventDefault ();

        var ths = $(this),
            wrap = ths.closest('.metro-field'),
            chosenList = wrap.find('.js-chosen-station-list'),
            station = ths.html(),
            dataColor = ths.attr('data-color'),
            target = chosenList.find('.to-clone').clone(true,true);

        console.log(dataColor);
        target.removeClass('to-clone');
        target.find('.metro-item').addClass(dataColor).html(station);
        target.appendTo(chosenList);
    });

    $(document).on('click', '.js-chosen-station-list a.delete-link', function (e) {
        e.preventDefault ();

        var ths = $(this),
            block = ths.closest('.js-chosen-station-list li');

        block.remove();
    });

    $(document).on('click', 'ul.card-list > li .analog-items', function (e) {
        e.preventDefault ();

        $(this).toggleClass('active');
        $(this).closest('li').find('.analog-items__box').slideToggle();
    });

    $(document).on('click', '.sec-order__form-entity-header a', function (e) {
        e.preventDefault ();

        $(this).parent().toggleClass('active');
        $(this).closest('.sec-order__form-entity').find('.sec-order__form-entity-content').slideToggle(300);
    });

    $(document).on('click', '.sec-order__delivery-tabs a', function (e) {
        e.preventDefault ();

        var _id = $(this).data('id');

        $(this).addClass('active').parent().find('.active').not(this).removeClass('active');
        $('.sec-order__delivery-box').removeClass('shown');
        $('.sec-order__delivery-box[data-id=' + _id + ']').addClass('shown');

        $(window).trigger('scroll');
    });

    $(document).on('click', '.sec-order__delivery-comment-add', function (e) {
        e.preventDefault ();

        $(this).hide();
        $(this).parent().find('textarea').show().focus();
    });

    $(document).on('click', '.sec-order__delivery-another-add', function (e) {
        e.preventDefault ();

        $(this).hide();
        $(this).parent().find('.sec-order__delivery-another-in').show().focus();
    });

    $(document).on('click', '.sec-order__delivery-farms-info .show', function (e) {
        e.preventDefault ();

        $(this).closest('.sec-order__delivery-box').find('.sec-order__delivery-farms-map').addClass('shown');
        $(this).closest('.sec-order__delivery-farms-info').addClass('shown');
    });

    $(document).on('click', '.sec-order__delivery-farms-info .hide', function (e) {
        e.preventDefault ();

        $(this).closest('.sec-order__delivery-box').find('.sec-order__delivery-farms-map').removeClass('shown');
        $(this).closest('.sec-order__delivery-farms-info').removeClass('shown');
    });

    $(document).on('click', '.js-scroll-to-el', function (e) {
        e.preventDefault ();

        var _id = $(this).attr('href');

        $('html, body').animate({ scrollTop: $(_id).offset().top - 20}, 500);
    });

    $(document).on('click', '.js-newTab', function (e) {
        e.preventDefault ();

        var _id = $(this).data('id');

        $(this).closest('.js-newTabs__items').find('.js-newTab--active').removeClass('js-newTab--active');
        $(this).addClass('js-newTab--active');

        $(this).closest('.js-newTabs').children('.js-newTabs__boxes').children('.js-newTabs__box').removeClass('js-newTabs__box--shown');
		$(this).closest('.js-newTabs').children('.js-newTabs__boxes').children('.js-newTabs__box[data-id=' + _id + ']').addClass('js-newTabs__box--shown').trigger('shown',[_id]); /*WS*/

        $(window).trigger('scroll');
    });

    $(document).on('click', '.sec-profile__order-info  a, .sec-profile__order-shower', function (e) {
        e.preventDefault ();

        $(this).closest('.sec-profile__order').toggleClass('active');
    });

    $(document).on('click', '.mobile-banner--more, .mobile-banner--xclose', function (e) {
        e.preventDefault ();

        $('.mobile-banner').each(function () {
            $(this).toggleClass('hidden');
        });
    });

    $(document).on('click', '.mobile-banner--close', function (e) {
        e.preventDefault ();

        $('.mobile-banner').remove();
    });

    // Subscribe-wrap
    $(document).on('click', '.js-subscribe-link', function (e) {
        // e.preventDefault ();

        var ths = $(this),
            wrap = ths.closest('.js-changing-wrap'),
            blockFirst = ths.closest('.js-changing-first'),
            blockSecond = wrap.find('.js-changing-second');

        blockFirst.hide();
        blockSecond.addClass('visible');
    });

    $(document).on('click', '.scrollToDiabet', function (e) {
        e.preventDefault ();

        var _id = $(this).attr('href');

        $('body, html').animate({ scrollTop: $(_id).offset().top }, 500);
    });

    // Spinbox func
    /*     $(document).on('click', '.spinbox a.minus', function (e) {
     e.preventDefault ();

     var ths = $(this),
     parent = ths.closest('.spinbox'),
     input = parent.find('input[type="text"]'),
     v = parseInt(input.val());

     if (v>1) { v--; input.val(v); }

     if (v>=2) {
     ths.removeClass('disabled');
     } else {
     ths.addClass('disabled');
     }
     });

     $(document).on('click', '.spinbox a.plus', function (e) {
     e.preventDefault ();

     var ths = $(this),
     parent = ths.closest('.spinbox'),
     minus = parent.find('a.minus'),
     input = parent.find('input[type="text"]'),
     v = parseInt(input.val());

     v++; input.val(v);

     if (v>=2) {
     minus.removeClass('disabled');
     } else {
     minus.addClass('disabled');
     }
     });
     */
    $(document).on('click', '.js-show-review-form', function (e) {
        e.preventDefault ();

        $('.review-form').show();
        $('.ws-review-form').show();
        $('.evaluation-module').hide();
        $('.js-show-review-form').hide();
    });

    $(document).on('click', '.js-mobile-social', function (e) {
        e.preventDefault ();

        $(this).hide();
        $(this).closest('li').find('.social-module').show();
    });

    // - - - - - - - - - - - - - - - - - - - - - - - - - -

    //???????????? ?? ????? ???
    $(document).click(function (e) {
        if ($('.select-wrap .option-list:visible').length && !$(e.target).closest('.select-wrap').length){
            $('.select-wrap .option-list').slideUp(300);
            $('.select-wrap .arrow').removeClass('active');
        }

        if ($('.js-with-drop-wrap .js-with-drop-block:visible').length && !$(e.target).closest('.js-with-drop-wrap').length){
            $('.js-with-drop-wrap .js-with-drop-block').hide();
            $('.js-with-drop-wrap').removeClass('open');
            $('.js-with-drop-wrap .js-with-drop-link').removeClass('open');
        }

        if ($('.js-dropdown-wrap .js-dropdown-block:visible').length && !$(e.target).closest('.js-dropdown-wrap').length){
            $('.js-dropdown-wrap .js-dropdown-block').hide(300);
            $('.js-dropdown-wrap .js-dropdown-link').removeClass('open');
        }

        if ($('.js-option-list:visible').length && !$(e.target).closest('.js-select-wrap').length){
            $('.js-option-list').slideUp(300);
        }
		/* WS */
		if($(e.target).closest('.jspHorizontalBar, .jspVerticalBar').length){
			return;
		}

        if ($('.js-popup:visible').length && !($(e.target).closest('.js-popup-wrap').length || $(e.target).closest('.popup-container').length || $(e.target).closest('a.delete-link').length)){
            $('.js-popup .close-popup').click();
        }
    });

    $(document).keyup(function (e) {
        if (e.keyCode == 27) {
            //close select
            $('.select-wrap .option-list').slideUp(300);
            $('.select-wrap .arrow').removeClass('active');

            //close with-drop-block
            $('.js-with-drop-wrap .js-with-drop-block').hide();
            $('.js-with-drop-wrap').removeClass('open');
            $('.js-with-drop-wrap .js-with-drop-link').removeClass('open');

            //close dropdown-block
            $('.js-dropdown-wrap .js-dropdown-block').hide(300);
            $('.js-dropdown-wrap .js-dropdown-link').removeClass('open');

            $('.js-option-list').slideUp(300);

            //close popups
            $('.js-popup .js-close-popup').click();
        }
    });


    // Fixed menu current state

    // Cache selectors
    var lastId,
        topMenu = $("#cardNav ul.card-nav-list"),
        topMenuHeight = topMenu.outerHeight() + 40,

    // All list items
        menuItems = topMenu.find("a.js-to-scroll"),

    // Anchors corresponding to menu items
        scrollItems = menuItems.map(function (){
            var item = $($(this).attr("href"));
            if (item.length) { return item; }
        });

    function pageScrollTo (href, animate) {
            href = href.replace(/%/g,'');
            if($(href).length > 0 ){
        var elOT = (animate && $('#cardFormSmall').length) ? $(href).offset().top : $(href).offset().top + 22;
        var offsetTop = href === "#" ? 0 : elOT - topMenuHeight + 2 - 60;

        var _sT = 0;

        if ($('#cardFormSmall').length) {
            _sT = offsetTop - $('#cardFormSmall').outerHeight();

            if (isMobileDevice)
                _sT = offsetTop + topMenuHeight;
        } else {
            _sT = offsetTop;
        }

        if (animate) {
            $('html, body').stop().animate({ scrollTop: _sT }, 900);
        } else {
            setTimeout(function() {
                window.scrollTo(0, _sT);
            }, 1);
        }
    }

	}
    /* WS */
    if (window.location.hash && !/\//i.test(window.location.hash)) {
        pageScrollTo (window.location.hash, false);
    }

    // Bind click handler to menu items
    // so we can get scroll animation
    menuItems.on('click', function (e) {
        e.preventDefault ();

        pageScrollTo ($(this).attr("href"), true);
    });

    var scrollListener = function () {
        $(window).one("scroll", function () { //unbinds itself every time it fires
            if (isMobileDevice) return;
            if (($(window).width() < 640)) return;

            var offset = $(this).scrollTop();

            if($('#cardNav.regular').length) {
                var navFixed = $('#cardNav.regular'),
                    navFixedOffset = navFixed.offset().top;

                if (offset > navFixedOffset ) {
                    navFixed.addClass('fixed');
                } else {
                    navFixed.removeClass('fixed');
                }
            }

            if($('#fastMenu.regular').length) {
                var navFixed = $('#fastMenu.regular'),
                    navFixedOffset = navFixed.offset().top - $('#cardNav').outerHeight(),
                    endOfBlock = $('#instructionUnit').offset().top + $('#instructionUnit').outerHeight() - 100; //100px - offset from the bottom of instructionUnit

                if(offset > navFixedOffset && offset < endOfBlock) {
                    navFixed.addClass('fixed');
                } else {
                    navFixed.removeClass('fixed');
                }
            }

            if($('#cardNav.with-card-small').length && $('#cardFormSmall').length) {
                var navFixed = $('#cardNav.with-card-small'),
                    navFixedOffset = navFixed.offset().top,
                    cardFixed = $('#cardFormSmall'),
                    cardFixedOffset = cardFixed.offset().top - cardFixed.outerHeight();

                if(offset > navFixedOffset ) {
                    navFixed.addClass('fixed');
                    if(offset > cardFixedOffset - 60) {
                        navFixed.addClass('fixed-offset');
                    } else {
                        navFixed.removeClass('fixed-offset');
                    }
                } else {
                    navFixed.removeClass('fixed fixed-offset');
                }
            }
            if($('#fastMenu.with-card-small').length && $('#cardFormSmall').length) {
                var navFixed = $('#fastMenu.with-card-small'),
                    navFixedOffset = navFixed.offset().top - $('#cardNav').outerHeight() - cardFixed.outerHeight(),
                    cardFixed = $('#cardFormSmall'),
                    cardFixedOffset = cardFixed.offset().top - cardFixed.outerHeight(),
                    endOfBlock = $('#instructionUnit').offset().top + $('#instructionUnit').outerHeight() - 170 - 60;

                if(offset > navFixedOffset && offset < endOfBlock) {
                    navFixed.addClass('fixed');
                    if(offset > cardFixedOffset) {
                        navFixed.addClass('fixed-offset');
                    } else {
                        navFixed.removeClass('fixed-offset');
                    }
                } else {
                    navFixed.removeClass('fixed fixed-offset');
                }
            }

            if($('#cardFormSmall').length) {
                var cardFixed = $('#cardFormSmall'),
                    cardFixedOffset = cardFixed.offset().top - $('#cardFormSmall').outerHeight();

                if (offset > cardFixedOffset - 60) {
                    cardFixed.addClass('fixed');
                } else {
                    cardFixed.removeClass('fixed');
                }
            }

            //For fixed menu current state
            // Get container scroll position
            var fromTop;
            var page_url = window.location.pathname;
            if($('#cardFormSmall').length) {
                fromTop = offset + topMenuHeight + $('#cardFormSmall').outerHeight() + 60;
            } else {
                fromTop = offset + topMenuHeight + 60;
            }

            // Get id of current scroll item
            var cur = scrollItems.map(function (){
                if ($(this).offset().top < fromTop)
                    return this;
            });

            // Get the id of the current element
            cur = cur[cur.length - 1];
            var id = cur && cur.length ? cur[0].id : "";

            if (lastId !== id) {
                lastId = id;
                // Set/remove current class

                topMenu.find("a")
                    .parent().removeClass("current")
                    .end().filter("[href=#"+id+"], [href='" + page_url + "']").parent().addClass("current");
            }

            setTimeout(scrollListener, 30); //rebinds itself after 30ms
        });
    } // end scrollListener

    scrollListener (); // Run

    $(window).on('scroll load resize', function () {
        var _t = $(this);

        if (_t.scrollTop() >= 200) {$('.search-field.notfix form').appendTo('.search-field.fix'); $('.fixed-header').addClass('shown'); }
        else {$('.search-field.fix form').appendTo('.search-field.notfix'); $('.fixed-header').removeClass('shown'); }
    });

    $(window).on('load resize', function () {
        var _t = $(this);

        if ($('.sort-block.for-desktop').length > 0) {
            var _sl = $('.js-sort-wrap'),
                _sbD = $('.sort-block.for-desktop'),
                _sbM = $('.sort-block.for-mobile');

            if (_t.width() <= 640) {
                _sl.detach().appendTo(_sbM);
            } else {
                _sl.detach().appendTo(_sbD);
            }
        }

    });
});


/* ?ругие событи¤ | optional triggers

 $(window).load(function () { //  огда страница полностью загружена

 });*/

$(window).resize(function () { //  огда изменили размеры окна браузера
    if ($('.mobile-block').hasClass('open'))
        $('.js-hamburger-link').click();
});

/*!
 *	jQuery dotdotdot 1.7.4
 *	Copyright (c) Fred Heusschen
 *	dotdotdot.frebsite.nl
 */
!function(t,e){function n(t,e,n){var r=t.children(),o=!1;t.empty();for(var i=0,d=r.length;d>i;i++){var l=r.eq(i);if(t.append(l),n&&t.append(n),a(t,e)){l.remove(),o=!0;break}n&&n.detach()}return o}function r(e,n,i,d,l){var s=!1,c="a, table, thead, tbody, tfoot, tr, col, colgroup, object, embed, param, ol, ul, dl, blockquote, select, optgroup, option, textarea, script, style",u="script, .dotdotdot-keep";return e.contents().detach().each(function (){var h=this,f=t(h);if("undefined"==typeof h)return!0;if(f.is(u))e.append(f);else{if(s)return!0;e.append(f),!l||f.is(d.after)||f.find(d.after).length||e[e.is(c)?"after":"append"](l),a(i,d)&&(s=3==h.nodeType?o(f,n,i,d,l):r(f,n,i,d,l),s||(f.detach(),s=!0)),s||l&&l.detach()}}),n.addClass("is-truncated"),s}function o(e,n,r,o,d){var c=e[0];if(!c)return!1;var h=s(c),f=-1!==h.indexOf(" ")?" ":"?",p="letter"==o.wrap?"":f,g=h.split(p),v=-1,w=-1,b=0,y=g.length-1;for(o.fallbackToLetter&&0==b&&0==y&&(p="",g=h.split(p),y=g.length-1);y>=b&&(0!=b||0!=y);){var m=Math.floor((b+y)/2);if(m==w)break;w=m,l(c,g.slice(0,w+1).join(p)+o.ellipsis),r.children().each(function (){t(this).toggle().toggle()}),a(r,o)?(y=w,o.fallbackToLetter&&0==b&&0==y&&(p="",g=g[0].split(p),v=-1,w=-1,b=0,y=g.length-1)):(v=w,b=w)}if(-1==v||1==g.length&&0==g[0].length){var x=e.parent();e.detach();var T=d&&d.closest(x).length?d.length:0;x.contents().length>T?c=u(x.contents().eq(-1-T),n):(c=u(x,n,!0),T||x.detach()),c&&(h=i(s(c),o),l(c,h),T&&d&&t(c).parent().append(d))}else h=i(g.slice(0,v+1).join(p),o),l(c,h);return!0}function a(t,e){return t.innerHeight()>e.maxHeight}function i(e,n){for(;t.inArray(e.slice(-1),n.lastCharacter.remove)>-1;)e=e.slice(0,-1);return t.inArray(e.slice(-1),n.lastCharacter.noEllipsis)<0&&(e+=n.ellipsis),e}function d(t){return{width:t.innerWidth(),height:t.innerHeight()}}function l(t,e){t.innerText?t.innerText=e:t.nodeValue?t.nodeValue=e:t.textContent&&(t.textContent=e)}function s(t){return t.innerText?t.innerText:t.nodeValue?t.nodeValue:t.textContent?t.textContent:""}function c(t){do t=t.previousSibling;while(t&&1!==t.nodeType&&3!==t.nodeType);return t}function u(e,n,r){var o,a=e&&e[0];if(a){if(!r){if(3===a.nodeType)return a;if(t.trim(e.text()))return u(e.contents().last(),n)}for(o=c(a);!o;){if(e=e.parent(),e.is(n)||!e.length)return!1;o=c(e[0])}if(o)return u(t(o),n)}return!1}function h(e,n){return e?"string"==typeof e?(e=t(e,n),e.length?e:!1):e.jquery?e:!1:!1}function f(t){for(var e=t.innerHeight(),n=["paddingTop","paddingBottom"],r=0,o=n.length;o>r;r++){var a=parseInt(t.css(n[r]),10);isNaN(a)&&(a=0),e-=a}return e}if(!t.fn.dotdotdot){t.fn.dotdotdot=function (e) {if(0==this.length)return t.fn.dotdotdot.debug('No element found for "'+this.selector+'".'),this;if(this.length>1)return this.each(function (){t(this).dotdotdot(e)});var o=this;o.data("dotdotdot")&&o.trigger("destroy.dot"),o.data("dotdotdot-style",o.attr("style")||""),o.css("word-wrap","break-word"),"nowrap"===o.css("white-space")&&o.css("white-space","normal"),o.bind_events=function (){return o.bind("update.dot",function(e,d){switch(o.removeClass("is-truncated"),e.preventDefault(),e.stopPropagation(),typeof l.height){case"number":l.maxHeight=l.height;break;case"function":l.maxHeight=l.height.call(o[0]);break;default:l.maxHeight=f(o)}l.maxHeight+=l.tolerance,"undefined"!=typeof d&&(("string"==typeof d||"nodeType"in d&&1===d.nodeType)&&(d=t("<div />").append(d).contents()),d instanceof t&&(i=d)),g=o.wrapInner('<div class="dotdotdot" />').children(),g.contents().detach().end().append(i.clone(!0)).find("br").replaceWith("  <br />  ").end().css({height:"auto",width:"auto",border:"none",padding:0,margin:0});var c=!1,u=!1;return s.afterElement&&(c=s.afterElement.clone(!0),c.show(),s.afterElement.detach()),a(g,l)&&(u="children"==l.wrap?n(g,l,c):r(g,o,g,l,c)),g.replaceWith(g.contents()),g=null,t.isFunction(l.callback)&&l.callback.call(o[0],u,i),s.isTruncated=u,u}).bind("isTruncated.dot",function(t,e){return t.preventDefault(),t.stopPropagation(),"function"==typeof e&&e.call(o[0],s.isTruncated),s.isTruncated}).bind("originalContent.dot",function(t,e){return t.preventDefault(),t.stopPropagation(),"function"==typeof e&&e.call(o[0],i),i}).bind("destroy.dot",function(t){t.preventDefault(),t.stopPropagation(),o.unwatch().unbind_events().contents().detach().end().append(i).attr("style",o.data("dotdotdot-style")||"").data("dotdotdot",!1)}),o},o.unbind_events=function (){return o.unbind(".dot"),o},o.watch=function (){if(o.unwatch(),"window"==l.watch){var e=t(window),n=e.width(),r=e.height();e.bind("resize.dot"+s.dotId,function (){n==e.width()&&r==e.height()&&l.windowResizeFix||(n=e.width(),r=e.height(),u&&clearInterval(u),u=setTimeout(function (){o.trigger("update.dot")},100))})}else c=d(o),u=setInterval(function (){if(o.is(":visible")){var t=d(o);(c.width!=t.width||c.height!=t.height)&&(o.trigger("update.dot"),c=t)}},500);return o},o.unwatch=function (){return t(window).unbind("resize.dot"+s.dotId),u&&clearInterval(u),o};var i=o.contents(),l=t.extend(!0,{},t.fn.dotdotdot.defaults,e),s={},c={},u=null,g=null;return l.lastCharacter.remove instanceof Array||(l.lastCharacter.remove=t.fn.dotdotdot.defaultArrays.lastCharacter.remove),l.lastCharacter.noEllipsis instanceof Array||(l.lastCharacter.noEllipsis=t.fn.dotdotdot.defaultArrays.lastCharacter.noEllipsis),s.afterElement=h(l.after,o),s.isTruncated=!1,s.dotId=p++,o.data("dotdotdot",!0).bind_events().trigger("update.dot"),l.watch&&o.watch(),o},t.fn.dotdotdot.defaults={ellipsis:"... ",wrap:"word",fallbackToLetter:!0,lastCharacter:{},tolerance:0,callback:null,after:null,height:null,watch:!1,windowResizeFix:!0},t.fn.dotdotdot.defaultArrays={lastCharacter:{remove:[" ","?",",",";",".","!","?"],noEllipsis:[]}},t.fn.dotdotdot.debug=function (){};var p=1,g=t.fn.html;t.fn.html=function(n){return n!=e&&!t.isFunction(n)&&this.data("dotdotdot")?this.trigger("update",[n]):g.apply(this,arguments)};var v=t.fn.text;t.fn.text=function(n){return n!=e&&!t.isFunction(n)&&this.data("dotdotdot")?(n=t("<div />").text(n).html(),this.trigger("update",[n])):v.apply(this,arguments)}}}(jQuery);

/*
 _ _      _       _
 ___| (_) ___| | __  (_)___
 / __| | |/ __| |/ /  | / __|
 \__ \ | | (__|   < _ | \__ \
 |___/_|_|\___|_|\_(_)/ |___/
 |__/

 Version: 1.6.0
 Author: Ken Wheeler
 Website: http://kenwheeler.github.io
 Docs: http://kenwheeler.github.io/slick
 Repo: http://github.com/kenwheeler/slick
 Issues: http://github.com/kenwheeler/slick/issues

 */
!function(a){"use strict";"function"==typeof define&&define.amd?define(["jquery"],a):"undefined"!=typeof exports?module.exports=a(require("jquery")):a(jQuery)}(function(a){"use strict";var b=window.Slick||{};b=function(){function c(c,d){var f,e=this;e.defaults={accessibility:!0,adaptiveHeight:!1,appendArrows:a(c),appendDots:a(c),arrows:!0,asNavFor:null,prevArrow:'<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button">Previous</button>',nextArrow:'<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button">Next</button>',autoplay:!1,autoplaySpeed:3e3,centerMode:!1,centerPadding:"50px",cssEase:"ease",customPaging:function(b,c){return a('<button type="button" data-role="none" role="button" tabindex="0" />').text(c+1)},dots:!1,dotsClass:"slick-dots",draggable:!0,easing:"linear",edgeFriction:.35,fade:!1,focusOnSelect:!1,infinite:!0,initialSlide:0,lazyLoad:"ondemand",mobileFirst:!1,pauseOnHover:!0,pauseOnFocus:!0,pauseOnDotsHover:!1,respondTo:"window",responsive:null,rows:1,rtl:!1,slide:"",slidesPerRow:1,slidesToShow:1,slidesToScroll:1,speed:500,swipe:!0,swipeToSlide:!1,touchMove:!0,touchThreshold:5,useCSS:!0,useTransform:!0,variableWidth:!1,vertical:!1,verticalSwiping:!1,waitForAnimate:!0,zIndex:1e3},e.initials={animating:!1,dragging:!1,autoPlayTimer:null,currentDirection:0,currentLeft:null,currentSlide:0,direction:1,$dots:null,listWidth:null,listHeight:null,loadIndex:0,$nextArrow:null,$prevArrow:null,slideCount:null,slideWidth:null,$slideTrack:null,$slides:null,sliding:!1,slideOffset:0,swipeLeft:null,$list:null,touchObject:{},transformsEnabled:!1,unslicked:!1},a.extend(e,e.initials),e.activeBreakpoint=null,e.animType=null,e.animProp=null,e.breakpoints=[],e.breakpointSettings=[],e.cssTransitions=!1,e.focussed=!1,e.interrupted=!1,e.hidden="hidden",e.paused=!0,e.positionProp=null,e.respondTo=null,e.rowCount=1,e.shouldClick=!0,e.$slider=a(c),e.$slidesCache=null,e.transformType=null,e.transitionType=null,e.visibilityChange="visibilitychange",e.windowWidth=0,e.windowTimer=null,f=a(c).data("slick")||{},e.options=a.extend({},e.defaults,d,f),e.currentSlide=e.options.initialSlide,e.originalSettings=e.options,"undefined"!=typeof document.mozHidden?(e.hidden="mozHidden",e.visibilityChange="mozvisibilitychange"):"undefined"!=typeof document.webkitHidden&&(e.hidden="webkitHidden",e.visibilityChange="webkitvisibilitychange"),e.autoPlay=a.proxy(e.autoPlay,e),e.autoPlayClear=a.proxy(e.autoPlayClear,e),e.autoPlayIterator=a.proxy(e.autoPlayIterator,e),e.changeSlide=a.proxy(e.changeSlide,e),e.clickHandler=a.proxy(e.clickHandler,e),e.selectHandler=a.proxy(e.selectHandler,e),e.setPosition=a.proxy(e.setPosition,e),e.swipeHandler=a.proxy(e.swipeHandler,e),e.dragHandler=a.proxy(e.dragHandler,e),e.keyHandler=a.proxy(e.keyHandler,e),e.instanceUid=b++,e.htmlExpr=/^(?:\s*(<[\w\W]+>)[^>]*)$/,e.registerBreakpoints(),e.init(!0)}var b=0;return c}(),b.prototype.activateADA=function(){var a=this;a.$slideTrack.find(".slick-active").attr({"aria-hidden":"false"}).find("a, input, button, select").attr({tabindex:"0"})},b.prototype.addSlide=b.prototype.slickAdd=function(b,c,d){var e=this;if("boolean"==typeof c)d=c,c=null;else if(0>c||c>=e.slideCount)return!1;e.unload(),"number"==typeof c?0===c&&0===e.$slides.length?a(b).appendTo(e.$slideTrack):d?a(b).insertBefore(e.$slides.eq(c)):a(b).insertAfter(e.$slides.eq(c)):d===!0?a(b).prependTo(e.$slideTrack):a(b).appendTo(e.$slideTrack),e.$slides=e.$slideTrack.children(this.options.slide),e.$slideTrack.children(this.options.slide).detach(),e.$slideTrack.append(e.$slides),e.$slides.each(function(b,c){a(c).attr("data-slick-index",b)}),e.$slidesCache=e.$slides,e.reinit()},b.prototype.animateHeight=function(){var a=this;if(1===a.options.slidesToShow&&a.options.adaptiveHeight===!0&&a.options.vertical===!1){var b=a.$slides.eq(a.currentSlide).outerHeight(!0);a.$list.animate({height:b},a.options.speed)}},b.prototype.animateSlide=function(b,c){var d={},e=this;e.animateHeight(),e.options.rtl===!0&&e.options.vertical===!1&&(b=-b),e.transformsEnabled===!1?e.options.vertical===!1?e.$slideTrack.animate({left:b},e.options.speed,e.options.easing,c):e.$slideTrack.animate({top:b},e.options.speed,e.options.easing,c):e.cssTransitions===!1?(e.options.rtl===!0&&(e.currentLeft=-e.currentLeft),a({animStart:e.currentLeft}).animate({animStart:b},{duration:e.options.speed,easing:e.options.easing,step:function(a){a=Math.ceil(a),e.options.vertical===!1?(d[e.animType]="translate("+a+"px, 0px)",e.$slideTrack.css(d)):(d[e.animType]="translate(0px,"+a+"px)",e.$slideTrack.css(d))},complete:function(){c&&c.call()}})):(e.applyTransition(),b=Math.ceil(b),e.options.vertical===!1?d[e.animType]="translate3d("+b+"px, 0px, 0px)":d[e.animType]="translate3d(0px,"+b+"px, 0px)",e.$slideTrack.css(d),c&&setTimeout(function(){e.disableTransition(),c.call()},e.options.speed))},b.prototype.getNavTarget=function(){var b=this,c=b.options.asNavFor;return c&&null!==c&&(c=a(c).not(b.$slider)),c},b.prototype.asNavFor=function(b){var c=this,d=c.getNavTarget();null!==d&&"object"==typeof d&&d.each(function(){var c=a(this).slick("getSlick");c.unslicked||c.slideHandler(b,!0)})},b.prototype.applyTransition=function(a){var b=this,c={};b.options.fade===!1?c[b.transitionType]=b.transformType+" "+b.options.speed+"ms "+b.options.cssEase:c[b.transitionType]="opacity "+b.options.speed+"ms "+b.options.cssEase,b.options.fade===!1?b.$slideTrack.css(c):b.$slides.eq(a).css(c)},b.prototype.autoPlay=function(){var a=this;a.autoPlayClear(),a.slideCount>a.options.slidesToShow&&(a.autoPlayTimer=setInterval(a.autoPlayIterator,a.options.autoplaySpeed))},b.prototype.autoPlayClear=function(){var a=this;a.autoPlayTimer&&clearInterval(a.autoPlayTimer)},b.prototype.autoPlayIterator=function(){var a=this,b=a.currentSlide+a.options.slidesToScroll;a.paused||a.interrupted||a.focussed||(a.options.infinite===!1&&(1===a.direction&&a.currentSlide+1===a.slideCount-1?a.direction=0:0===a.direction&&(b=a.currentSlide-a.options.slidesToScroll,a.currentSlide-1===0&&(a.direction=1))),a.slideHandler(b))},b.prototype.buildArrows=function(){var b=this;b.options.arrows===!0&&(b.$prevArrow=a(b.options.prevArrow).addClass("slick-arrow"),b.$nextArrow=a(b.options.nextArrow).addClass("slick-arrow"),b.slideCount>b.options.slidesToShow?(b.$prevArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"),b.$nextArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"),b.htmlExpr.test(b.options.prevArrow)&&b.$prevArrow.prependTo(b.options.appendArrows),b.htmlExpr.test(b.options.nextArrow)&&b.$nextArrow.appendTo(b.options.appendArrows),b.options.infinite!==!0&&b.$prevArrow.addClass("slick-disabled").attr("aria-disabled","true")):b.$prevArrow.add(b.$nextArrow).addClass("slick-hidden").attr({"aria-disabled":"true",tabindex:"-1"}))},b.prototype.buildDots=function(){var c,d,b=this;if(b.options.dots===!0&&b.slideCount>b.options.slidesToShow){for(b.$slider.addClass("slick-dotted"),d=a("<ul />").addClass(b.options.dotsClass),c=0;c<=b.getDotCount();c+=1)d.append(a("<li />").append(b.options.customPaging.call(this,b,c)));b.$dots=d.appendTo(b.options.appendDots),b.$dots.find("li").first().addClass("slick-active").attr("aria-hidden","false")}},b.prototype.buildOut=function(){var b=this;b.$slides=b.$slider.children(b.options.slide+":not(.slick-cloned)").addClass("slick-slide"),b.slideCount=b.$slides.length,b.$slides.each(function(b,c){a(c).attr("data-slick-index",b).data("originalStyling",a(c).attr("style")||"")}),b.$slider.addClass("slick-slider"),b.$slideTrack=0===b.slideCount?a('<div class="slick-track"/>').appendTo(b.$slider):b.$slides.wrapAll('<div class="slick-track"/>').parent(),b.$list=b.$slideTrack.wrap('<div aria-live="polite" class="slick-list"/>').parent(),b.$slideTrack.css("opacity",0),(b.options.centerMode===!0||b.options.swipeToSlide===!0)&&(b.options.slidesToScroll=1),a("img[data-lazy]",b.$slider).not("[src]").addClass("slick-loading"),b.setupInfinite(),b.buildArrows(),b.buildDots(),b.updateDots(),b.setSlideClasses("number"==typeof b.currentSlide?b.currentSlide:0),b.options.draggable===!0&&b.$list.addClass("draggable")},b.prototype.buildRows=function(){var b,c,d,e,f,g,h,a=this;if(e=document.createDocumentFragment(),g=a.$slider.children(),a.options.rows>1){for(h=a.options.slidesPerRow*a.options.rows,f=Math.ceil(g.length/h),b=0;f>b;b++){var i=document.createElement("div");for(c=0;c<a.options.rows;c++){var j=document.createElement("div");for(d=0;d<a.options.slidesPerRow;d++){var k=b*h+(c*a.options.slidesPerRow+d);g.get(k)&&j.appendChild(g.get(k))}i.appendChild(j)}e.appendChild(i)}a.$slider.empty().append(e),a.$slider.children().children().children().css({width:100/a.options.slidesPerRow+"%",display:"inline-block"})}},b.prototype.checkResponsive=function(b,c){var e,f,g,d=this,h=!1,i=d.$slider.width(),j=window.innerWidth||a(window).width();if("window"===d.respondTo?g=j:"slider"===d.respondTo?g=i:"min"===d.respondTo&&(g=Math.min(j,i)),d.options.responsive&&d.options.responsive.length&&null!==d.options.responsive){f=null;for(e in d.breakpoints)d.breakpoints.hasOwnProperty(e)&&(d.originalSettings.mobileFirst===!1?g<d.breakpoints[e]&&(f=d.breakpoints[e]):g>d.breakpoints[e]&&(f=d.breakpoints[e]));null!==f?null!==d.activeBreakpoint?(f!==d.activeBreakpoint||c)&&(d.activeBreakpoint=f,"unslick"===d.breakpointSettings[f]?d.unslick(f):(d.options=a.extend({},d.originalSettings,d.breakpointSettings[f]),b===!0&&(d.currentSlide=d.options.initialSlide),d.refresh(b)),h=f):(d.activeBreakpoint=f,"unslick"===d.breakpointSettings[f]?d.unslick(f):(d.options=a.extend({},d.originalSettings,d.breakpointSettings[f]),b===!0&&(d.currentSlide=d.options.initialSlide),d.refresh(b)),h=f):null!==d.activeBreakpoint&&(d.activeBreakpoint=null,d.options=d.originalSettings,b===!0&&(d.currentSlide=d.options.initialSlide),d.refresh(b),h=f),b||h===!1||d.$slider.trigger("breakpoint",[d,h])}},b.prototype.changeSlide=function(b,c){var f,g,h,d=this,e=a(b.currentTarget);switch(e.is("a")&&b.preventDefault(),e.is("li")||(e=e.closest("li")),h=d.slideCount%d.options.slidesToScroll!==0,f=h?0:(d.slideCount-d.currentSlide)%d.options.slidesToScroll,b.data.message){case"previous":g=0===f?d.options.slidesToScroll:d.options.slidesToShow-f,d.slideCount>d.options.slidesToShow&&d.slideHandler(d.currentSlide-g,!1,c);break;case"next":g=0===f?d.options.slidesToScroll:f,d.slideCount>d.options.slidesToShow&&d.slideHandler(d.currentSlide+g,!1,c);break;case"index":var i=0===b.data.index?0:b.data.index||e.index()*d.options.slidesToScroll;d.slideHandler(d.checkNavigable(i),!1,c);break;default:return}},b.prototype.checkNavigable=function(a){var c,d,b=this;if(c=b.getNavigableIndexes(),d=0,a>c[c.length-1])a=c[c.length-1];else for(var e in c){if(a<c[e]){a=d;break}d=c[e]}return a},b.prototype.cleanUpEvents=function(){var b=this;b.options.dots&&null!==b.$dots&&a("li",b.$dots).off("click.slick",b.changeSlide).off("mouseenter.slick",a.proxy(b.interrupt,b,!0)).off("mouseleave.slick",a.proxy(b.interrupt,b,!1)),b.$slider.off("focus.slick blur.slick"),b.options.arrows===!0&&b.slideCount>b.options.slidesToShow&&(b.$prevArrow&&b.$prevArrow.off("click.slick",b.changeSlide),b.$nextArrow&&b.$nextArrow.off("click.slick",b.changeSlide)),b.$list.off("touchstart.slick mousedown.slick",b.swipeHandler),b.$list.off("touchmove.slick mousemove.slick",b.swipeHandler),b.$list.off("touchend.slick mouseup.slick",b.swipeHandler),b.$list.off("touchcancel.slick mouseleave.slick",b.swipeHandler),b.$list.off("click.slick",b.clickHandler),a(document).off(b.visibilityChange,b.visibility),b.cleanUpSlideEvents(),b.options.accessibility===!0&&b.$list.off("keydown.slick",b.keyHandler),b.options.focusOnSelect===!0&&a(b.$slideTrack).children().off("click.slick",b.selectHandler),a(window).off("orientationchange.slick.slick-"+b.instanceUid,b.orientationChange),a(window).off("resize.slick.slick-"+b.instanceUid,b.resize),a("[draggable!=true]",b.$slideTrack).off("dragstart",b.preventDefault),a(window).off("load.slick.slick-"+b.instanceUid,b.setPosition),a(document).off("ready.slick.slick-"+b.instanceUid,b.setPosition)},b.prototype.cleanUpSlideEvents=function(){var b=this;b.$list.off("mouseenter.slick",a.proxy(b.interrupt,b,!0)),b.$list.off("mouseleave.slick",a.proxy(b.interrupt,b,!1))},b.prototype.cleanUpRows=function(){var b,a=this;a.options.rows>1&&(b=a.$slides.children().children(),b.removeAttr("style"),a.$slider.empty().append(b))},b.prototype.clickHandler=function(a){var b=this;b.shouldClick===!1&&(a.stopImmediatePropagation(),a.stopPropagation(),a.preventDefault())},b.prototype.destroy=function(b){var c=this;c.autoPlayClear(),c.touchObject={},c.cleanUpEvents(),a(".slick-cloned",c.$slider).detach(),c.$dots&&c.$dots.remove(),c.$prevArrow&&c.$prevArrow.length&&(c.$prevArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display",""),c.htmlExpr.test(c.options.prevArrow)&&c.$prevArrow.remove()),c.$nextArrow&&c.$nextArrow.length&&(c.$nextArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display",""),c.htmlExpr.test(c.options.nextArrow)&&c.$nextArrow.remove()),c.$slides&&(c.$slides.removeClass("slick-slide slick-active slick-center slick-visible slick-current").removeAttr("aria-hidden").removeAttr("data-slick-index").each(function(){a(this).attr("style",a(this).data("originalStyling"))}),c.$slideTrack.children(this.options.slide).detach(),c.$slideTrack.detach(),c.$list.detach(),c.$slider.append(c.$slides)),c.cleanUpRows(),c.$slider.removeClass("slick-slider"),c.$slider.removeClass("slick-initialized"),c.$slider.removeClass("slick-dotted"),c.unslicked=!0,b||c.$slider.trigger("destroy",[c])},b.prototype.disableTransition=function(a){var b=this,c={};c[b.transitionType]="",b.options.fade===!1?b.$slideTrack.css(c):b.$slides.eq(a).css(c)},b.prototype.fadeSlide=function(a,b){var c=this;c.cssTransitions===!1?(c.$slides.eq(a).css({zIndex:c.options.zIndex}),c.$slides.eq(a).animate({opacity:1},c.options.speed,c.options.easing,b)):(c.applyTransition(a),c.$slides.eq(a).css({opacity:1,zIndex:c.options.zIndex}),b&&setTimeout(function(){c.disableTransition(a),b.call()},c.options.speed))},b.prototype.fadeSlideOut=function(a){var b=this;b.cssTransitions===!1?b.$slides.eq(a).animate({opacity:0,zIndex:b.options.zIndex-2},b.options.speed,b.options.easing):(b.applyTransition(a),b.$slides.eq(a).css({opacity:0,zIndex:b.options.zIndex-2}))},b.prototype.filterSlides=b.prototype.slickFilter=function(a){var b=this;null!==a&&(b.$slidesCache=b.$slides,b.unload(),b.$slideTrack.children(this.options.slide).detach(),b.$slidesCache.filter(a).appendTo(b.$slideTrack),b.reinit())},b.prototype.focusHandler=function(){var b=this;b.$slider.off("focus.slick blur.slick").on("focus.slick blur.slick","*:not(.slick-arrow)",function(c){c.stopImmediatePropagation();var d=a(this);setTimeout(function(){b.options.pauseOnFocus&&(b.focussed=d.is(":focus"),b.autoPlay())},0)})},b.prototype.getCurrent=b.prototype.slickCurrentSlide=function(){var a=this;return a.currentSlide},b.prototype.getDotCount=function(){var a=this,b=0,c=0,d=0;if(a.options.infinite===!0)for(;b<a.slideCount;)++d,b=c+a.options.slidesToScroll,c+=a.options.slidesToScroll<=a.options.slidesToShow?a.options.slidesToScroll:a.options.slidesToShow;else if(a.options.centerMode===!0)d=a.slideCount;else if(a.options.asNavFor)for(;b<a.slideCount;)++d,b=c+a.options.slidesToScroll,c+=a.options.slidesToScroll<=a.options.slidesToShow?a.options.slidesToScroll:a.options.slidesToShow;else d=1+Math.ceil((a.slideCount-a.options.slidesToShow)/a.options.slidesToScroll);return d-1},b.prototype.getLeft=function(a){var c,d,f,b=this,e=0;return b.slideOffset=0,d=b.$slides.first().outerHeight(!0),b.options.infinite===!0?(b.slideCount>b.options.slidesToShow&&(b.slideOffset=b.slideWidth*b.options.slidesToShow*-1,e=d*b.options.slidesToShow*-1),b.slideCount%b.options.slidesToScroll!==0&&a+b.options.slidesToScroll>b.slideCount&&b.slideCount>b.options.slidesToShow&&(a>b.slideCount?(b.slideOffset=(b.options.slidesToShow-(a-b.slideCount))*b.slideWidth*-1,e=(b.options.slidesToShow-(a-b.slideCount))*d*-1):(b.slideOffset=b.slideCount%b.options.slidesToScroll*b.slideWidth*-1,e=b.slideCount%b.options.slidesToScroll*d*-1))):a+b.options.slidesToShow>b.slideCount&&(b.slideOffset=(a+b.options.slidesToShow-b.slideCount)*b.slideWidth,e=(a+b.options.slidesToShow-b.slideCount)*d),b.slideCount<=b.options.slidesToShow&&(b.slideOffset=0,e=0),b.options.centerMode===!0&&b.options.infinite===!0?b.slideOffset+=b.slideWidth*Math.floor(b.options.slidesToShow/2)-b.slideWidth:b.options.centerMode===!0&&(b.slideOffset=0,b.slideOffset+=b.slideWidth*Math.floor(b.options.slidesToShow/2)),c=b.options.vertical===!1?a*b.slideWidth*-1+b.slideOffset:a*d*-1+e,b.options.variableWidth===!0&&(f=b.slideCount<=b.options.slidesToShow||b.options.infinite===!1?b.$slideTrack.children(".slick-slide").eq(a):b.$slideTrack.children(".slick-slide").eq(a+b.options.slidesToShow),c=b.options.rtl===!0?f[0]?-1*(b.$slideTrack.width()-f[0].offsetLeft-f.width()):0:f[0]?-1*f[0].offsetLeft:0,b.options.centerMode===!0&&(f=b.slideCount<=b.options.slidesToShow||b.options.infinite===!1?b.$slideTrack.children(".slick-slide").eq(a):b.$slideTrack.children(".slick-slide").eq(a+b.options.slidesToShow+1),c=b.options.rtl===!0?f[0]?-1*(b.$slideTrack.width()-f[0].offsetLeft-f.width()):0:f[0]?-1*f[0].offsetLeft:0,c+=(b.$list.width()-f.outerWidth())/2)),c},b.prototype.getOption=b.prototype.slickGetOption=function(a){var b=this;return b.options[a]},b.prototype.getNavigableIndexes=function(){var e,a=this,b=0,c=0,d=[];for(a.options.infinite===!1?e=a.slideCount:(b=-1*a.options.slidesToScroll,c=-1*a.options.slidesToScroll,e=2*a.slideCount);e>b;)d.push(b),b=c+a.options.slidesToScroll,c+=a.options.slidesToScroll<=a.options.slidesToShow?a.options.slidesToScroll:a.options.slidesToShow;return d},b.prototype.getSlick=function(){return this},b.prototype.getSlideCount=function(){var c,d,e,b=this;return e=b.options.centerMode===!0?b.slideWidth*Math.floor(b.options.slidesToShow/2):0,b.options.swipeToSlide===!0?(b.$slideTrack.find(".slick-slide").each(function(c,f){return f.offsetLeft-e+a(f).outerWidth()/2>-1*b.swipeLeft?(d=f,!1):void 0}),c=Math.abs(a(d).attr("data-slick-index")-b.currentSlide)||1):b.options.slidesToScroll},b.prototype.goTo=b.prototype.slickGoTo=function(a,b){var c=this;c.changeSlide({data:{message:"index",index:parseInt(a)}},b)},b.prototype.init=function(b){var c=this;a(c.$slider).hasClass("slick-initialized")||(a(c.$slider).addClass("slick-initialized"),c.buildRows(),c.buildOut(),c.setProps(),c.startLoad(),c.loadSlider(),c.initializeEvents(),c.updateArrows(),c.updateDots(),c.checkResponsive(!0),c.focusHandler()),b&&c.$slider.trigger("init",[c]),c.options.accessibility===!0&&c.initADA(),c.options.autoplay&&(c.paused=!1,c.autoPlay())},b.prototype.initADA=function(){var b=this;b.$slides.add(b.$slideTrack.find(".slick-cloned")).attr({"aria-hidden":"true",tabindex:"-1"}).find("a, input, button, select").attr({tabindex:"-1"}),b.$slideTrack.attr("role","listbox"),b.$slides.not(b.$slideTrack.find(".slick-cloned")).each(function(c){a(this).attr({role:"option","aria-describedby":"slick-slide"+b.instanceUid+c})}),null!==b.$dots&&b.$dots.attr("role","tablist").find("li").each(function(c){a(this).attr({role:"presentation","aria-selected":"false","aria-controls":"navigation"+b.instanceUid+c,id:"slick-slide"+b.instanceUid+c})}).first().attr("aria-selected","true").end().find("button").attr("role","button").end().closest("div").attr("role","toolbar"),b.activateADA()},b.prototype.initArrowEvents=function(){var a=this;a.options.arrows===!0&&a.slideCount>a.options.slidesToShow&&(a.$prevArrow.off("click.slick").on("click.slick",{message:"previous"},a.changeSlide),a.$nextArrow.off("click.slick").on("click.slick",{message:"next"},a.changeSlide))},b.prototype.initDotEvents=function(){var b=this;b.options.dots===!0&&b.slideCount>b.options.slidesToShow&&a("li",b.$dots).on("click.slick",{message:"index"},b.changeSlide),b.options.dots===!0&&b.options.pauseOnDotsHover===!0&&a("li",b.$dots).on("mouseenter.slick",a.proxy(b.interrupt,b,!0)).on("mouseleave.slick",a.proxy(b.interrupt,b,!1))},b.prototype.initSlideEvents=function(){var b=this;b.options.pauseOnHover&&(b.$list.on("mouseenter.slick",a.proxy(b.interrupt,b,!0)),b.$list.on("mouseleave.slick",a.proxy(b.interrupt,b,!1)))},b.prototype.initializeEvents=function(){var b=this;b.initArrowEvents(),b.initDotEvents(),b.initSlideEvents(),b.$list.on("touchstart.slick mousedown.slick",{action:"start"},b.swipeHandler),b.$list.on("touchmove.slick mousemove.slick",{action:"move"},b.swipeHandler),b.$list.on("touchend.slick mouseup.slick",{action:"end"},b.swipeHandler),b.$list.on("touchcancel.slick mouseleave.slick",{action:"end"},b.swipeHandler),b.$list.on("click.slick",b.clickHandler),a(document).on(b.visibilityChange,a.proxy(b.visibility,b)),b.options.accessibility===!0&&b.$list.on("keydown.slick",b.keyHandler),b.options.focusOnSelect===!0&&a(b.$slideTrack).children().on("click.slick",b.selectHandler),a(window).on("orientationchange.slick.slick-"+b.instanceUid,a.proxy(b.orientationChange,b)),a(window).on("resize.slick.slick-"+b.instanceUid,a.proxy(b.resize,b)),a("[draggable!=true]",b.$slideTrack).on("dragstart",b.preventDefault),a(window).on("load.slick.slick-"+b.instanceUid,b.setPosition),a(document).on("ready.slick.slick-"+b.instanceUid,b.setPosition)},b.prototype.initUI=function(){var a=this;a.options.arrows===!0&&a.slideCount>a.options.slidesToShow&&(a.$prevArrow.show(),a.$nextArrow.show()),a.options.dots===!0&&a.slideCount>a.options.slidesToShow&&a.$dots.show()},b.prototype.keyHandler=function(a){var b=this;a.target.tagName.match("TEXTAREA|INPUT|SELECT")||(37===a.keyCode&&b.options.accessibility===!0?b.changeSlide({data:{message:b.options.rtl===!0?"next":"previous"}}):39===a.keyCode&&b.options.accessibility===!0&&b.changeSlide({data:{message:b.options.rtl===!0?"previous":"next"}}))},b.prototype.lazyLoad=function(){function g(c){a("img[data-lazy]",c).each(function(){var c=a(this),d=a(this).attr("data-lazy"),e=document.createElement("img");e.onload=function(){c.animate({opacity:0},100,function(){c.attr("src",d).animate({opacity:1},200,function(){c.removeAttr("data-lazy").removeClass("slick-loading")}),b.$slider.trigger("lazyLoaded",[b,c,d])})},e.onerror=function(){c.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error"),b.$slider.trigger("lazyLoadError",[b,c,d])},e.src=d})}var c,d,e,f,b=this;b.options.centerMode===!0?b.options.infinite===!0?(e=b.currentSlide+(b.options.slidesToShow/2+1),f=e+b.options.slidesToShow+2):(e=Math.max(0,b.currentSlide-(b.options.slidesToShow/2+1)),f=2+(b.options.slidesToShow/2+1)+b.currentSlide):(e=b.options.infinite?b.options.slidesToShow+b.currentSlide:b.currentSlide,f=Math.ceil(e+b.options.slidesToShow),b.options.fade===!0&&(e>0&&e--,f<=b.slideCount&&f++)),c=b.$slider.find(".slick-slide").slice(e,f),g(c),b.slideCount<=b.options.slidesToShow?(d=b.$slider.find(".slick-slide"),g(d)):b.currentSlide>=b.slideCount-b.options.slidesToShow?(d=b.$slider.find(".slick-cloned").slice(0,b.options.slidesToShow),g(d)):0===b.currentSlide&&(d=b.$slider.find(".slick-cloned").slice(-1*b.options.slidesToShow),g(d))},b.prototype.loadSlider=function(){var a=this;a.setPosition(),a.$slideTrack.css({opacity:1}),a.$slider.removeClass("slick-loading"),a.initUI(),"progressive"===a.options.lazyLoad&&a.progressiveLazyLoad()},b.prototype.next=b.prototype.slickNext=function(){var a=this;a.changeSlide({data:{message:"next"}})},b.prototype.orientationChange=function(){var a=this;a.checkResponsive(),a.setPosition()},b.prototype.pause=b.prototype.slickPause=function(){var a=this;a.autoPlayClear(),a.paused=!0},b.prototype.play=b.prototype.slickPlay=function(){var a=this;a.autoPlay(),a.options.autoplay=!0,a.paused=!1,a.focussed=!1,a.interrupted=!1},b.prototype.postSlide=function(a){var b=this;b.unslicked||(b.$slider.trigger("afterChange",[b,a]),b.animating=!1,b.setPosition(),b.swipeLeft=null,b.options.autoplay&&b.autoPlay(),b.options.accessibility===!0&&b.initADA())},b.prototype.prev=b.prototype.slickPrev=function(){var a=this;a.changeSlide({data:{message:"previous"}})},b.prototype.preventDefault=function(a){a.preventDefault()},b.prototype.progressiveLazyLoad=function(b){b=b||1;var e,f,g,c=this,d=a("img[data-lazy]",c.$slider);d.length?(e=d.first(),f=e.attr("data-lazy"),g=document.createElement("img"),g.onload=function(){e.attr("src",f).removeAttr("data-lazy").removeClass("slick-loading"),c.options.adaptiveHeight===!0&&c.setPosition(),c.$slider.trigger("lazyLoaded",[c,e,f]),c.progressiveLazyLoad()},g.onerror=function(){3>b?setTimeout(function(){c.progressiveLazyLoad(b+1)},500):(e.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error"),c.$slider.trigger("lazyLoadError",[c,e,f]),c.progressiveLazyLoad())},g.src=f):c.$slider.trigger("allImagesLoaded",[c])},b.prototype.refresh=function(b){var d,e,c=this;e=c.slideCount-c.options.slidesToShow,!c.options.infinite&&c.currentSlide>e&&(c.currentSlide=e),c.slideCount<=c.options.slidesToShow&&(c.currentSlide=0),d=c.currentSlide,c.destroy(!0),a.extend(c,c.initials,{currentSlide:d}),c.init(),b||c.changeSlide({data:{message:"index",index:d}},!1)},b.prototype.registerBreakpoints=function(){var c,d,e,b=this,f=b.options.responsive||null;if("array"===a.type(f)&&f.length){b.respondTo=b.options.respondTo||"window";for(c in f)if(e=b.breakpoints.length-1,d=f[c].breakpoint,f.hasOwnProperty(c)){for(;e>=0;)b.breakpoints[e]&&b.breakpoints[e]===d&&b.breakpoints.splice(e,1),e--;b.breakpoints.push(d),b.breakpointSettings[d]=f[c].settings}b.breakpoints.sort(function(a,c){return b.options.mobileFirst?a-c:c-a})}},b.prototype.reinit=function(){var b=this;b.$slides=b.$slideTrack.children(b.options.slide).addClass("slick-slide"),b.slideCount=b.$slides.length,b.currentSlide>=b.slideCount&&0!==b.currentSlide&&(b.currentSlide=b.currentSlide-b.options.slidesToScroll),b.slideCount<=b.options.slidesToShow&&(b.currentSlide=0),b.registerBreakpoints(),b.setProps(),b.setupInfinite(),b.buildArrows(),b.updateArrows(),b.initArrowEvents(),b.buildDots(),b.updateDots(),b.initDotEvents(),b.cleanUpSlideEvents(),b.initSlideEvents(),b.checkResponsive(!1,!0),b.options.focusOnSelect===!0&&a(b.$slideTrack).children().on("click.slick",b.selectHandler),b.setSlideClasses("number"==typeof b.currentSlide?b.currentSlide:0),b.setPosition(),b.focusHandler(),b.paused=!b.options.autoplay,b.autoPlay(),b.$slider.trigger("reInit",[b])},b.prototype.resize=function(){var b=this;a(window).width()!==b.windowWidth&&(clearTimeout(b.windowDelay),b.windowDelay=window.setTimeout(function(){b.windowWidth=a(window).width(),b.checkResponsive(),b.unslicked||b.setPosition()},50))},b.prototype.removeSlide=b.prototype.slickRemove=function(a,b,c){var d=this;return"boolean"==typeof a?(b=a,a=b===!0?0:d.slideCount-1):a=b===!0?--a:a,d.slideCount<1||0>a||a>d.slideCount-1?!1:(d.unload(),c===!0?d.$slideTrack.children().remove():d.$slideTrack.children(this.options.slide).eq(a).remove(),d.$slides=d.$slideTrack.children(this.options.slide),d.$slideTrack.children(this.options.slide).detach(),d.$slideTrack.append(d.$slides),d.$slidesCache=d.$slides,void d.reinit())},b.prototype.setCSS=function(a){var d,e,b=this,c={};b.options.rtl===!0&&(a=-a),d="left"==b.positionProp?Math.ceil(a)+"px":"0px",e="top"==b.positionProp?Math.ceil(a)+"px":"0px",c[b.positionProp]=a,b.transformsEnabled===!1?b.$slideTrack.css(c):(c={},b.cssTransitions===!1?(c[b.animType]="translate("+d+", "+e+")",b.$slideTrack.css(c)):(c[b.animType]="translate3d("+d+", "+e+", 0px)",b.$slideTrack.css(c)))},b.prototype.setDimensions=function(){var a=this;a.options.vertical===!1?a.options.centerMode===!0&&a.$list.css({padding:"0px "+a.options.centerPadding}):(a.$list.height(a.$slides.first().outerHeight(!0)*a.options.slidesToShow),a.options.centerMode===!0&&a.$list.css({padding:a.options.centerPadding+" 0px"})),a.listWidth=a.$list.width(),a.listHeight=a.$list.height(),a.options.vertical===!1&&a.options.variableWidth===!1?(a.slideWidth=Math.ceil(a.listWidth/a.options.slidesToShow),a.$slideTrack.width(Math.ceil(a.slideWidth*a.$slideTrack.children(".slick-slide").length))):a.options.variableWidth===!0?a.$slideTrack.width(5e3*a.slideCount):(a.slideWidth=Math.ceil(a.listWidth),a.$slideTrack.height(Math.ceil(a.$slides.first().outerHeight(!0)*a.$slideTrack.children(".slick-slide").length)));var b=a.$slides.first().outerWidth(!0)-a.$slides.first().width();a.options.variableWidth===!1&&a.$slideTrack.children(".slick-slide").width(a.slideWidth-b)},b.prototype.setFade=function(){var c,b=this;b.$slides.each(function(d,e){c=b.slideWidth*d*-1,b.options.rtl===!0?a(e).css({position:"relative",right:c,top:0,zIndex:b.options.zIndex-2,opacity:0}):a(e).css({position:"relative",left:c,top:0,zIndex:b.options.zIndex-2,opacity:0})}),b.$slides.eq(b.currentSlide).css({zIndex:b.options.zIndex-1,opacity:1})},b.prototype.setHeight=function(){var a=this;if(1===a.options.slidesToShow&&a.options.adaptiveHeight===!0&&a.options.vertical===!1){var b=a.$slides.eq(a.currentSlide).outerHeight(!0);a.$list.css("height",b)}},b.prototype.setOption=b.prototype.slickSetOption=function(){var c,d,e,f,h,b=this,g=!1;if("object"===a.type(arguments[0])?(e=arguments[0],g=arguments[1],h="multiple"):"string"===a.type(arguments[0])&&(e=arguments[0],f=arguments[1],g=arguments[2],"responsive"===arguments[0]&&"array"===a.type(arguments[1])?h="responsive":"undefined"!=typeof arguments[1]&&(h="single")),"single"===h)b.options[e]=f;else if("multiple"===h)a.each(e,function(a,c){b.options[a]=c});else if("responsive"===h)for(d in f)if("array"!==a.type(b.options.responsive))b.options.responsive=[f[d]];else{for(c=b.options.responsive.length-1;c>=0;)b.options.responsive[c].breakpoint===f[d].breakpoint&&b.options.responsive.splice(c,1),c--;b.options.responsive.push(f[d])}g&&(b.unload(),b.reinit())},b.prototype.setPosition=function(){var a=this;a.setDimensions(),a.setHeight(),a.options.fade===!1?a.setCSS(a.getLeft(a.currentSlide)):a.setFade(),a.$slider.trigger("setPosition",[a])},b.prototype.setProps=function(){var a=this,b=document.body.style;a.positionProp=a.options.vertical===!0?"top":"left","top"===a.positionProp?a.$slider.addClass("slick-vertical"):a.$slider.removeClass("slick-vertical"),(void 0!==b.WebkitTransition||void 0!==b.MozTransition||void 0!==b.msTransition)&&a.options.useCSS===!0&&(a.cssTransitions=!0),a.options.fade&&("number"==typeof a.options.zIndex?a.options.zIndex<3&&(a.options.zIndex=3):a.options.zIndex=a.defaults.zIndex),void 0!==b.OTransform&&(a.animType="OTransform",a.transformType="-o-transform",a.transitionType="OTransition",void 0===b.perspectiveProperty&&void 0===b.webkitPerspective&&(a.animType=!1)),void 0!==b.MozTransform&&(a.animType="MozTransform",a.transformType="-moz-transform",a.transitionType="MozTransition",void 0===b.perspectiveProperty&&void 0===b.MozPerspective&&(a.animType=!1)),void 0!==b.webkitTransform&&(a.animType="webkitTransform",a.transformType="-webkit-transform",a.transitionType="webkitTransition",void 0===b.perspectiveProperty&&void 0===b.webkitPerspective&&(a.animType=!1)),void 0!==b.msTransform&&(a.animType="msTransform",a.transformType="-ms-transform",a.transitionType="msTransition",void 0===b.msTransform&&(a.animType=!1)),void 0!==b.transform&&a.animType!==!1&&(a.animType="transform",a.transformType="transform",a.transitionType="transition"),a.transformsEnabled=a.options.useTransform&&null!==a.animType&&a.animType!==!1},b.prototype.setSlideClasses=function(a){var c,d,e,f,b=this;d=b.$slider.find(".slick-slide").removeClass("slick-active slick-center slick-current").attr("aria-hidden","true"),b.$slides.eq(a).addClass("slick-current"),b.options.centerMode===!0?(c=Math.floor(b.options.slidesToShow/2),b.options.infinite===!0&&(a>=c&&a<=b.slideCount-1-c?b.$slides.slice(a-c,a+c+1).addClass("slick-active").attr("aria-hidden","false"):(e=b.options.slidesToShow+a,
    d.slice(e-c+1,e+c+2).addClass("slick-active").attr("aria-hidden","false")),0===a?d.eq(d.length-1-b.options.slidesToShow).addClass("slick-center"):a===b.slideCount-1&&d.eq(b.options.slidesToShow).addClass("slick-center")),b.$slides.eq(a).addClass("slick-center")):a>=0&&a<=b.slideCount-b.options.slidesToShow?b.$slides.slice(a,a+b.options.slidesToShow).addClass("slick-active").attr("aria-hidden","false"):d.length<=b.options.slidesToShow?d.addClass("slick-active").attr("aria-hidden","false"):(f=b.slideCount%b.options.slidesToShow,e=b.options.infinite===!0?b.options.slidesToShow+a:a,b.options.slidesToShow==b.options.slidesToScroll&&b.slideCount-a<b.options.slidesToShow?d.slice(e-(b.options.slidesToShow-f),e+f).addClass("slick-active").attr("aria-hidden","false"):d.slice(e,e+b.options.slidesToShow).addClass("slick-active").attr("aria-hidden","false")),"ondemand"===b.options.lazyLoad&&b.lazyLoad()},b.prototype.setupInfinite=function(){var c,d,e,b=this;if(b.options.fade===!0&&(b.options.centerMode=!1),b.options.infinite===!0&&b.options.fade===!1&&(d=null,b.slideCount>b.options.slidesToShow)){for(e=b.options.centerMode===!0?b.options.slidesToShow+1:b.options.slidesToShow,c=b.slideCount;c>b.slideCount-e;c-=1)d=c-1,a(b.$slides[d]).clone(!0).attr("id","").attr("data-slick-index",d-b.slideCount).prependTo(b.$slideTrack).addClass("slick-cloned");for(c=0;e>c;c+=1)d=c,a(b.$slides[d]).clone(!0).attr("id","").attr("data-slick-index",d+b.slideCount).appendTo(b.$slideTrack).addClass("slick-cloned");b.$slideTrack.find(".slick-cloned").find("[id]").each(function(){a(this).attr("id","")})}},b.prototype.interrupt=function(a){var b=this;a||b.autoPlay(),b.interrupted=a},b.prototype.selectHandler=function(b){var c=this,d=a(b.target).is(".slick-slide")?a(b.target):a(b.target).parents(".slick-slide"),e=parseInt(d.attr("data-slick-index"));return e||(e=0),c.slideCount<=c.options.slidesToShow?(c.setSlideClasses(e),void c.asNavFor(e)):void c.slideHandler(e)},b.prototype.slideHandler=function(a,b,c){var d,e,f,g,j,h=null,i=this;return b=b||!1,i.animating===!0&&i.options.waitForAnimate===!0||i.options.fade===!0&&i.currentSlide===a||i.slideCount<=i.options.slidesToShow?void 0:(b===!1&&i.asNavFor(a),d=a,h=i.getLeft(d),g=i.getLeft(i.currentSlide),i.currentLeft=null===i.swipeLeft?g:i.swipeLeft,i.options.infinite===!1&&i.options.centerMode===!1&&(0>a||a>i.getDotCount()*i.options.slidesToScroll)?void(i.options.fade===!1&&(d=i.currentSlide,c!==!0?i.animateSlide(g,function(){i.postSlide(d)}):i.postSlide(d))):i.options.infinite===!1&&i.options.centerMode===!0&&(0>a||a>i.slideCount-i.options.slidesToScroll)?void(i.options.fade===!1&&(d=i.currentSlide,c!==!0?i.animateSlide(g,function(){i.postSlide(d)}):i.postSlide(d))):(i.options.autoplay&&clearInterval(i.autoPlayTimer),e=0>d?i.slideCount%i.options.slidesToScroll!==0?i.slideCount-i.slideCount%i.options.slidesToScroll:i.slideCount+d:d>=i.slideCount?i.slideCount%i.options.slidesToScroll!==0?0:d-i.slideCount:d,i.animating=!0,i.$slider.trigger("beforeChange",[i,i.currentSlide,e]),f=i.currentSlide,i.currentSlide=e,i.setSlideClasses(i.currentSlide),i.options.asNavFor&&(j=i.getNavTarget(),j=j.slick("getSlick"),j.slideCount<=j.options.slidesToShow&&j.setSlideClasses(i.currentSlide)),i.updateDots(),i.updateArrows(),i.options.fade===!0?(c!==!0?(i.fadeSlideOut(f),i.fadeSlide(e,function(){i.postSlide(e)})):i.postSlide(e),void i.animateHeight()):void(c!==!0?i.animateSlide(h,function(){i.postSlide(e)}):i.postSlide(e))))},b.prototype.startLoad=function(){var a=this;a.options.arrows===!0&&a.slideCount>a.options.slidesToShow&&(a.$prevArrow.hide(),a.$nextArrow.hide()),a.options.dots===!0&&a.slideCount>a.options.slidesToShow&&a.$dots.hide(),a.$slider.addClass("slick-loading")},b.prototype.swipeDirection=function(){var a,b,c,d,e=this;return a=e.touchObject.startX-e.touchObject.curX,b=e.touchObject.startY-e.touchObject.curY,c=Math.atan2(b,a),d=Math.round(180*c/Math.PI),0>d&&(d=360-Math.abs(d)),45>=d&&d>=0?e.options.rtl===!1?"left":"right":360>=d&&d>=315?e.options.rtl===!1?"left":"right":d>=135&&225>=d?e.options.rtl===!1?"right":"left":e.options.verticalSwiping===!0?d>=35&&135>=d?"down":"up":"vertical"},b.prototype.swipeEnd=function(a){var c,d,b=this;if(b.dragging=!1,b.interrupted=!1,b.shouldClick=b.touchObject.swipeLength>10?!1:!0,void 0===b.touchObject.curX)return!1;if(b.touchObject.edgeHit===!0&&b.$slider.trigger("edge",[b,b.swipeDirection()]),b.touchObject.swipeLength>=b.touchObject.minSwipe){switch(d=b.swipeDirection()){case"left":case"down":c=b.options.swipeToSlide?b.checkNavigable(b.currentSlide+b.getSlideCount()):b.currentSlide+b.getSlideCount(),b.currentDirection=0;break;case"right":case"up":c=b.options.swipeToSlide?b.checkNavigable(b.currentSlide-b.getSlideCount()):b.currentSlide-b.getSlideCount(),b.currentDirection=1}"vertical"!=d&&(b.slideHandler(c),b.touchObject={},b.$slider.trigger("swipe",[b,d]))}else b.touchObject.startX!==b.touchObject.curX&&(b.slideHandler(b.currentSlide),b.touchObject={})},b.prototype.swipeHandler=function(a){var b=this;if(!(b.options.swipe===!1||"ontouchend"in document&&b.options.swipe===!1||b.options.draggable===!1&&-1!==a.type.indexOf("mouse")))switch(b.touchObject.fingerCount=a.originalEvent&&void 0!==a.originalEvent.touches?a.originalEvent.touches.length:1,b.touchObject.minSwipe=b.listWidth/b.options.touchThreshold,b.options.verticalSwiping===!0&&(b.touchObject.minSwipe=b.listHeight/b.options.touchThreshold),a.data.action){case"start":b.swipeStart(a);break;case"move":b.swipeMove(a);break;case"end":b.swipeEnd(a)}},b.prototype.swipeMove=function(a){var d,e,f,g,h,b=this;return h=void 0!==a.originalEvent?a.originalEvent.touches:null,!b.dragging||h&&1!==h.length?!1:(d=b.getLeft(b.currentSlide),b.touchObject.curX=void 0!==h?h[0].pageX:a.clientX,b.touchObject.curY=void 0!==h?h[0].pageY:a.clientY,b.touchObject.swipeLength=Math.round(Math.sqrt(Math.pow(b.touchObject.curX-b.touchObject.startX,2))),b.options.verticalSwiping===!0&&(b.touchObject.swipeLength=Math.round(Math.sqrt(Math.pow(b.touchObject.curY-b.touchObject.startY,2)))),e=b.swipeDirection(),"vertical"!==e?(void 0!==a.originalEvent&&b.touchObject.swipeLength>4&&a.preventDefault(),g=(b.options.rtl===!1?1:-1)*(b.touchObject.curX>b.touchObject.startX?1:-1),b.options.verticalSwiping===!0&&(g=b.touchObject.curY>b.touchObject.startY?1:-1),f=b.touchObject.swipeLength,b.touchObject.edgeHit=!1,b.options.infinite===!1&&(0===b.currentSlide&&"right"===e||b.currentSlide>=b.getDotCount()&&"left"===e)&&(f=b.touchObject.swipeLength*b.options.edgeFriction,b.touchObject.edgeHit=!0),b.options.vertical===!1?b.swipeLeft=d+f*g:b.swipeLeft=d+f*(b.$list.height()/b.listWidth)*g,b.options.verticalSwiping===!0&&(b.swipeLeft=d+f*g),b.options.fade===!0||b.options.touchMove===!1?!1:b.animating===!0?(b.swipeLeft=null,!1):void b.setCSS(b.swipeLeft)):void 0)},b.prototype.swipeStart=function(a){var c,b=this;return b.interrupted=!0,1!==b.touchObject.fingerCount||b.slideCount<=b.options.slidesToShow?(b.touchObject={},!1):(void 0!==a.originalEvent&&void 0!==a.originalEvent.touches&&(c=a.originalEvent.touches[0]),b.touchObject.startX=b.touchObject.curX=void 0!==c?c.pageX:a.clientX,b.touchObject.startY=b.touchObject.curY=void 0!==c?c.pageY:a.clientY,void(b.dragging=!0))},b.prototype.unfilterSlides=b.prototype.slickUnfilter=function(){var a=this;null!==a.$slidesCache&&(a.unload(),a.$slideTrack.children(this.options.slide).detach(),a.$slidesCache.appendTo(a.$slideTrack),a.reinit())},b.prototype.unload=function(){var b=this;a(".slick-cloned",b.$slider).remove(),b.$dots&&b.$dots.remove(),b.$prevArrow&&b.htmlExpr.test(b.options.prevArrow)&&b.$prevArrow.remove(),b.$nextArrow&&b.htmlExpr.test(b.options.nextArrow)&&b.$nextArrow.remove(),b.$slides.removeClass("slick-slide slick-active slick-visible slick-current").attr("aria-hidden","true").css("width","")},b.prototype.unslick=function(a){var b=this;b.$slider.trigger("unslick",[b,a]),b.destroy()},b.prototype.updateArrows=function(){var b,a=this;b=Math.floor(a.options.slidesToShow/2),a.options.arrows===!0&&a.slideCount>a.options.slidesToShow&&!a.options.infinite&&(a.$prevArrow.removeClass("slick-disabled").attr("aria-disabled","false"),a.$nextArrow.removeClass("slick-disabled").attr("aria-disabled","false"),0===a.currentSlide?(a.$prevArrow.addClass("slick-disabled").attr("aria-disabled","true"),a.$nextArrow.removeClass("slick-disabled").attr("aria-disabled","false")):a.currentSlide>=a.slideCount-a.options.slidesToShow&&a.options.centerMode===!1?(a.$nextArrow.addClass("slick-disabled").attr("aria-disabled","true"),a.$prevArrow.removeClass("slick-disabled").attr("aria-disabled","false")):a.currentSlide>=a.slideCount-1&&a.options.centerMode===!0&&(a.$nextArrow.addClass("slick-disabled").attr("aria-disabled","true"),a.$prevArrow.removeClass("slick-disabled").attr("aria-disabled","false")))},b.prototype.updateDots=function(){var a=this;null!==a.$dots&&(a.$dots.find("li").removeClass("slick-active").attr("aria-hidden","true"),a.$dots.find("li").eq(Math.floor(a.currentSlide/a.options.slidesToScroll)).addClass("slick-active").attr("aria-hidden","false"))},b.prototype.visibility=function(){var a=this;a.options.autoplay&&(document[a.hidden]?a.interrupted=!0:a.interrupted=!1)},a.fn.slick=function(){var f,g,a=this,c=arguments[0],d=Array.prototype.slice.call(arguments,1),e=a.length;for(f=0;e>f;f++)if("object"==typeof c||"undefined"==typeof c?a[f].slick=new b(a[f],c):g=a[f].slick[c].apply(a[f].slick,d),"undefined"!=typeof g)return g;return a}});
