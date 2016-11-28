$(function(){
//перемещение баннера

    setTimeout('moveBanner()',5000);

    //попытка убрать Яндекс советник
    setTimeout(
        function (){
            if($('[style="top: -1px !important; display: table !important; opacity: 1 !important;"]').length){
                $('[style="top: -1px !important; display: table !important; opacity: 1 !important;"]').remove();
            }
        }
        , 3000);


    ie_paceholder();

    window.cartNum = $('.__cart-count'); //в меню. количество товаров в корзине

    //События для мобильного баннера
    $("._closeMobileBanner").on("click",function(){
        setCookie('hide_mobile_banner',1);
    });
    $('#mobileBannerSms').on('submit',function(e){
        e.preventDefault();
        var phone = $("#mobileBannerPhone").val();
        var errors = 0;
        if(phone.length == ""){
            errors = 1;
            wsPoperValid.init([
                $("#mobileBannerPhone"),"Введите телефон"
            ]);
        }
        if(!errors){
            $.ajax({
                type: 'POST',
                url: '/ajax/sendMobileAppLinkInSms',
                cache: false,
                data: {'phone': phone},
                success: function(data){
                    // console.log(data);
                    setCookie('hide_mobile_banner',1);
                    $('._mobileBanner').hide(200);
                },
                error: function(data){
                    //console.log(data);
                }
            });
        }


    });

    $('body').on('submit', '#popup_login_signin', function(e){
        e.preventDefault();
        var $form = $(this);
        $form.find('.btn-reg').addClass('ws-miniloader');
        $.post('/include/login.php', $form.serialize(), function(res){
			console.log(res);
            if(res.status && res.status == 1){
                window.location.href = '/personal/';
            } else {
                $form.find('.ws-miniloader').removeClass('ws-miniloader');
                if(res.fields){
                    $form.find('.lpti-error').removeClass('lpti-error');
                    $.each(res.fields, function(f, mess){
                        var $f = $form.find('[name='+f+']');
                        if($f.length){
                            wsPoperValid.init([
                                $f,mess
                            ]);
                        }
                    });
                }
                if(res.message) {
                    $form.before($(res.message).hide().fadeIn(200));
                }
            }
        })

    });

	$(".title-search-result .mfp-close").live("click", function () {
		$(".title-search-result").hide();
	});

    //подписка на рассылки
    $('._resubscribe').on('click',function(){
        var ths = $(this),
            wrap = ths.closest('.js-changing-wrap'),
            blockFirst = wrap.find('.js-changing-first'),
            blockSecond = wrap.find('.js-changing-second');

        blockFirst.show();
        blockSecond.removeClass('visible');
    });
    $('#subscribe').click(function () {
        $('#subscribe_email,#subscribe_name').removeClass('lpti-error');
        $('.subscribe-wrap').find('.tooltip__hint').remove();
        var email = $('#subscribe_email').val();
        var name = $('#subscribe_name').val();
        if (email == '') {
            $('#subscribe_email').addClass('lpti-error');
            return false;
        }
        if(!validateEmail(email)){
            $('#subscribe_email').addClass('lpti-error');
            return false;
        }
        if (name == '') {
            $('#subscribe_name').addClass('lpti-error');
            return false;
        }
        var ths = $(this),
            wrap = ths.closest('.js-changing-wrap'),
            blockFirst = ths.closest('.js-changing-first'),
            blockSecond = wrap.find('.js-changing-second');
        $.ajax({
            type: 'POST',
            url: '/ajax/subscribe',
            cache: false,
            data: {'email': email, 'name':name},
            dataType: 'json',
            success: function(data){
                if(data.status == 'ok'){
                    $('.subscribed-block .email').text(email);
                    blockFirst.hide();
                    blockSecond.addClass('visible');
                }else if(data.status == 'error'){
                    //setPopover($('#' + data.field),data.mess,'top','error');
                    $('#'+data.field).addClass('lpti-error');
                    $('#'+data.field).parent().append('<div class="tooltip__hint tooltip__hint--alert">'+data.mess+'<div class="tooltip__arrow">&#9660;</div></div>');
                    $('#'+data.field).parent().find('div').show();

                }
            },
            error: function(data){
                //console.log(data);
            }
        });
        return false;
    });

    $('.wrapper')
        .on('click', '._show_more', function (e) {
            var _this = $(this),page=_this.attr('page');

            $.ajax({
                dataType:	"html",
                type: 		"POST",
                data: {link: _this.data('link'),act_link: _this.data('act_link'),region: _this.data('region'),count: _this.data('count')},
                url:		"/ajax/"+_this.data('action') + '?page='+page,
                beforeSend: function () {
                    _this.addClass('ws-miniloader');
                }
            }).done(function(html){
                if(html){
                    _this.removeClass('ws-miniloader');
                    _this.parent().find('.reg-table').append(html);
                    _this.attr('page',parseInt(page)+1);
                    if((_this.data('count_all') - ((parseInt(page)) * _this.data('count'))) <= 0){
                        _this.remove();
                    }
                    else if((_this.data('count_all') - ((parseInt(page)) * _this.data('count'))) < _this.data('count')){
                        _this.text('Показать ещё '+(_this.data('count_all') - (parseInt(page) * _this.data('count'))));
                    }

                }
            });
        })
		.on("mousedown", "._noticeMe", function(e) {
			e.preventDefault();
            e.stopPropagation();
            var id = $(this).data('id');

			$.get("/include/addtoreminder.php", "ID="+id, function (data) {
				$.magnificPopup.open({
				  items: {
					  src: data,
					  type: 'inline'
				  }
				});
			});
		})
        // кнопки КУПИТЬ
        // добавляем data-id и класс __addToCart
        .on('mousedown', '._addToCart', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var id = $(this).data('id');

           /* if($(this).hasClass("transform"))
            {
                $(this).text('В корзине').removeAttr('onclick').addClass('in_cart').removeClass('_addToCart').attr('href', '/personal/cart/');
            }*/

			$.get("/include/addtobasket.php", "ID="+id, function (result) {
				$(".__cart-count").text(result);
				$(".__cart-count").removeClass("hidden");
			});
			
			    if($(this).closest('.front').length){
        var wrap = $(this).closest('.front');
        var name = wrap.find('.item-name').text();
        var price = $(this).data('price') || parseInt(wrap.find('._price').text());
        //dataLayerAddToCart(id,name,price,'','',count);
    } else if($(this).closest('.card-form').length){
        var wrap = $(this).closest('.card-form');
        var name = $('h1').text();
        var price = $(this).data('price') || parseInt(wrap.find('.product_item_price_digit').text());
        //dataLayerAddToCart(id,name,price,'','',count);
    } else if($(this).closest('.product_item-price_buy-b').length){
        var price = $(this).data('price') || parseInt($(this).closest('.product_item-price_buy-b').find('.product_item_price_digit').text());
    }
 
 
    if(!$(this).closest('.front').length)if ($(this).closest('._fixedCard').length) {
        var price_buy_block = $('._fixedCard');
        if (!price_buy_block.find('._addToCart').hasClass('in_cart')) {
            price_buy_block.find('._addToCart').one("click", function (e) {
                e.preventDefault();
            });
        }
        price_buy_block.find('._addToCart').text('В корзине').removeAttr('onclick').addClass('in_cart').removeClass('_addToCart').attr('href', '/personal/cart/');

    } else {
        if (!$(this).hasClass('in_cart')) {
            $(this).one("click", function (e) {
                e.preventDefault();
            });
        }
        $(this).text('В корзине').removeAttr('onclick').addClass('in_cart').removeClass('_addToCart').attr('href', '/personal/cart/');
    }

            if($(this).hasClass('remember_b'))  $(this).text('В корзине').removeAttr('mousedown').addClass('btn-blue')/*.attr('href','/shopcart.html')*/;
 

			//alert(id);
			/*
			var _w = $(this).closest('.header_recalculate').find('._plusMinus');
            var count = 1;
            var variation_id = parseInt($(this).data('variation_id')) || 0;

            if (_w.length && _w.find('input._addCount')) {
                _w.addClass('recalculate');
                count = _w.find('input._addCount').val();
            }else if($(this).is("[data-count]")){
                count = $(this).data('count'); // если не нашли инпута смотрим у самой кнопки
            }

            if($(this).closest('.front').length){
                var wrap = $(this).closest('.front');
                var name = wrap.find('.item-name').text();
                var price = parseInt(wrap.find('._price').text());
                dataLayerAddToCart(id,name,price,'','',count);
            } else if($(this).closest('.card-form').length){
                var wrap = $(this).closest('.card-form');
                var name = $('h1').text();
                var price = parseInt(wrap.find('.product_item_price_digit').text());
                dataLayerAddToCart(id,name,price,'','',count);
            }



            if(!$(this).closest('.front').length){
                if($(this).closest('._fixedCard').length){
                    var  price_buy_block = $('._fixedCard');
                    if( !price_buy_block.find('._addToCart').hasClass('in_cart')){
                        price_buy_block.find('._addToCart').one( "click", function(e) {
                            e.preventDefault();
                        });
                    }
                    price_buy_block.find('._addToCart').text('В корзине').removeAttr('onclick').addClass('in_cart').removeClass('_addToCart').attr('href', '/shopcart.html');

                }else{
                    if( !$(this).hasClass('in_cart')) {
                        $(this).one("click", function (e) {
                            e.preventDefault();
                        });
                    }
                    $(this).text('В корзине').removeAttr('onclick').addClass('in_cart').removeClass('_addToCart').attr('href', '/shopcart.html');
                }
            }

            if($(this).hasClass('remember_b'))  $(this).text('В корзине').removeAttr('mousedown').addClass('btn-blue')/*.attr('href','/shopcart.html')*/;
			/*
            recalculateShopCart(id, count, this, variation_id);

            try {
                rrApi.addToBasket(id);
            } catch(e) {}
			*/
        })
        // Добавление в избранное
        .on('mousedown', '.buttonFavorite', function(){

            var
                t = $(this),
                t_id = $(this).id,
                b = t.hasClass('checked'),
                p_id = t.attr('rel'),
                c = $('.__favorite-count').eq(0).text();
            if(b){
                if(! $(this).closest('.slick-slide').length)
                    $('.buttonFavorite[rel=' + p_id + ']').not(this).find('input').removeAttr('checked').change();
                $.ajax({
                    dataType:	"html",
                    type: 		"POST",
                    url:		"/include/deffered.php?id="+p_id+"&active=0"
                }).done(function(){
                    if($('._favorite_list').length){
                        loadAxaxContent('#list','defferedList');
                    }
                });

            }else{
                if(! $(this).closest('.slick-slide').length)
                    $('.buttonFavorite[rel=' + p_id + ']').not(this).find('input').prop("checked", true).change();

                $.ajax({
                    dataType:	"html",
                    type: 		"POST",
                    url:		"/include/deffered.php?id="+p_id+"&active=1"
                }).done(function(){

                    if($('._favorite_list').length){
                        loadAxaxContent('#list','defferedList');
                    }
                });;
            }
            $('.__favorite-count').html($('.__favorite-count').html()*1 + (b?-1:1)).removeClass('hidden').show();

            /* if(b && t.closest('._favorite_list').length){
             t.closest('.item-card').hide(200).remove();
             }*/



            if(t.children('span').length){
                if(!b){
                    t.children('span').text('Отложено');
                    $('.buttonFavorite[rel=' + p_id + ']').not(this).children('span').text('Отложено');
                }
                else{
                    t.children('span').text('Отложить');
                    $('.buttonFavorite[rel=' + p_id + ']').not(this).children('span').text('Отложить');
                }
            }
            return false;
        })// уменьшить колво в корзине для товара
        .on('mousedown', '.buttonMinus', function(){
            var $item = $(this).closest('._plusMinus');
			var offer = $(this).parents(".for-transform").find(".curr-offer a");

            var value_field = $item.find('._addCount');
            var count = parseInt(value_field.val()) - 1
            var variation = parseInt($item.data('variation_id'));

            if($(this).closest('.product_item-price_buy-b').hasClass('product_item-price_buy-b')){
                var price_buy_block = $(this).closest('.product_item-price_buy-b');

                /*if(price_buy_block.hasClass('_fixedCard')){
                    price_buy_block = $('.product_item-price_buy-b');
                    value_field = price_buy_block.find('._addCount');
                }*/
            }else{
                var price_buy_block = null;
            }
            /*var discount_qty = parseInt($item.data('min_qty')) || 0;
            var discount_price = $item.data('sale_price') || 0;
            var discount_common_price = parseInt($item.data('common_price')) || 0;
            if(discount_qty && discount_price && discount_common_price && price_buy_block){
                if (count >= discount_qty){
                    price_buy_block.find('.product_item_price_digit').html(discount_price);
                }else{
                    price_buy_block.find('.product_item_price_digit').html(discount_common_price);
                }
            }*/

            if(count == 0){
				$(offer).attr("data-inbasket", '0');
                cartDelete($item.data('id'),$(this), variation);
                if($(this).closest('.for-transform').length)
                    $(this).closest('.for-transform').removeClass('flipped');

                if(price_buy_block){
                    if(price_buy_block.find('.in_cart').length){
                       $(this).parents(".for-transform").find('.in_cart').removeClass('in_cart').text('Купить').removeAttr('href');
                    }
                }

                return false;
            }

			$(offer).attr("data-inbasket", count);

            ///count = count < 1 ? 1 : count;
            value_field.val(count);
            if($item.hasClass('recalculate')){
                recalculateShopCart($item.data('id'), count, $(this), variation);

            }
        })
        // увеличить колво товара в корзине
        .on('mousedown', '.buttonPlus', function(){
			//alert();
            var $item = $(this).closest('._plusMinus');
			var offer = $(this).parents(".for-transform").find(".curr-offer a");

            var value_field = $item.find('._addCount');
            var mq = $item.find('._addCount').attr("max");
            var count = parseInt(value_field.val()) + 1;
            var variation = parseInt($item.data('variation_id'));

            if($(this).closest('.product_item-price_buy-b').hasClass('product_item-price_buy-b')){
                var price_buy_block = $(this).closest('.product_item-price_buy-b');
                if(price_buy_block.hasClass('_fixedCard')){
                    price_buy_block = $('.product_item-price_buy-b');
                    value_field = price_buy_block.find('._addCount');
                }
            }else{
                var price_buy_block = null;
            }

            /*var discount_qty = parseInt($item.data('min_qty')) || 0;
            var discount_price = $item.data('sale_price') || 0;
            var discount_common_price = parseInt($item.data('common_price')) || 0;
            if(discount_qty && discount_price && discount_common_price && price_buy_block){
                if (count >= discount_qty){
                    price_buy_block.find('.product_item_price_digit').html(discount_price);
                }else{
                    price_buy_block.find('.product_item_price_digit').html(discount_common_price);
                }
            }*/

            if(price_buy_block){
                if(price_buy_block.find('._addToCart').length){
					$(this).parents(".for-transform").find('._addToCart').text('В корзине').removeAttr('onclick').addClass('in_cart').attr('href','/personal/cart/');
                }
            }

            if(count >= mq)
            {
                wsPoperValid.init([
                    value_field, 'Выбрано максимальное количество'
                ]);

                setTimeout(function () {wsPoperValid.removePoper(value_field)}, 2000);
            }

            count = count > (value_field.attr('max')) ? (value_field.attr('max')) : count;
            value_field.val(count);
			$(offer).attr("data-inbasket", count);
            if($item.hasClass('recalculate')){
                recalculateShopCart($item.data('id'),count,$(this),variation);
            }
        })
        // изменение колва товара через инпут
        .on('change', 'input._addCount', function(){
            var _ = $(this);
			var qmax = $(this).attr("max");
            var $item = _.closest('._plusMinus');
            var variation = parseInt($item.data('variation_id'));
            var expr = /^\d+$/g;
            if(!expr.test(_.val())){ _.val(1); }
			if(qmax <= parseInt(_.val())) {_.val(qmax);}
            if($(this).closest('.product_item-price_buy-b').hasClass('product_item-price_buy-b')){
                var price_buy_block = $(this).closest('.product_item-price_buy-b');
                if(price_buy_block.hasClass('_fixedCard')){
                    price_buy_block = $('.product_item-price_buy-b');
                    price_buy_block.find('input._addCount').val(_.val());
                }
            }else{
                var price_buy_block = null;
            }


            if($item.hasClass('recalculate')){
                recalculateShopCart($item.data('id'),parseInt(_.val()),$(this), variation);
            }
        })
        // +1 к отзыву (оценка полезности)
        .on('mousedown', '.__reviewPlus', function(e){
            e.stopPropagation();
            Common.review_plus_minus($(this), e);
        })
        // -1 к отзыву (оценка полезности)
        .on('mousedown', '.__reviewMinus', function(e){
            e.stopPropagation();
            Common.review_plus_minus($(this), e);
        })
        // +1 к медсправочнику (оценка полезности)
        .on('mousedown', '.__reviewPlusMed', function(e){
            e.stopPropagation();
            Common.review_plus_minus_med($(this), e);
        })
        // -1 к медсправочнику (оценка полезности)
        .on('mousedown', '.__reviewMinusMed', function(e){
            e.stopPropagation();
            Common.review_plus_minus_med($(this), e);
        })
        // +1 к аптеке (оценка полезности)
        .on('mousedown', '.__reviewPlusDrugstore', function(e){
            e.stopPropagation();
            Common.review_plus_minus_drugstore($(this), e);
        })
        // -1 к аптеке (оценка полезности)
        .on('mousedown', '.__reviewMinusDrugstore', function(e){
            e.stopPropagation();
            Common.review_plus_minus_drugstore($(this), e);
        })
        .on('mousedown', '.wsc-answer-link',function (e) {
            e.preventDefault();
            e.stopPropagation();
            var _ = $(this);
            var $li = _.closest('li');
            var plus = $li.find('.__reviewPlus').siblings('.digit').text();
            var minus = $li.find('.__reviewMinus').siblings('.digit').text();
            var answerform = _.closest('.wsc-row').find('.wsc-form-answer');
            if (answerform.length) {
                answerform.toggleClass('visible');
                if (answerform.hasClass('visible')) {
                    answerform.hide();
                } else {
                    answerform.fadeIn(100);
                }
            } else {
                var html = donor('.wsc-form-answer');
                var id = _.data('id');
                var place = _.data('place');
                html.find('.btn-reg').on('mousedown', function (e) {
                    e.preventDefault();
                    var $t = html.find('textarea');
                    var $n = html.find('input[type=text]');
                    var $b = $(this);
                    if ($t.val() != '' && id) {
                        $.ajax({
                            url: '/include/addAnswer.php',
                            type: 'POST',
                            data: {id: id, text: $t.val()},
                            beforeSend: function () {
                                $b.addClass('ws-miniloader');
                            },
                            success: function (data) {
                                $b.removeClass('ws-miniloader');
                                if (data.html) {
                                    html.html(data.html);
                                    $b.fadeOut(100);
                                }
                                if (data.error)
                                    console.log( data.error);
                            }
                        });
                    } else {
                        alert('Введите сообщение');
                    }
                });
                _.closest('li').append(html.fadeIn(100));
            }
            _.parent().find('.wsc-form-answer').find('textarea').focus();

            return false;
        });

    $( document ).on('click', '.__show-enter-form', function(e){
        e.preventDefault ();
        e.stopPropagation();
        $('#shadow').fadeIn(300);
        $('.enter-popup').css({position:'fixed'}).fadeIn(300);
    });

    $( document ).on( "click", "#submit_callback", function(e){
        e.preventDefault();
        var errors = 0;
        var name = $("#name_callback").val();
        var phone = $("#phone_callback").val();
        // phone = phone.replace(/[^\d;]/g, '');
        //var error_log = "";
        var re = /^[0-9+]*$/;

        // проверяем заполнил ли пользователь поля
        if(name.length == ""){
            errors = 1;

            wsPoperValid.init([
                $("#name_callback"),"Введите имя"
            ]);
        }
        if(phone.length == ""){
            errors = 1;
            wsPoperValid.init([
                $("#phone_callback"),"Введите телефон"
            ]);
        }


        /*  if (!re.test(phone)){
         error_log += "Неверный телефон";
         errors = 1;
         }*/

// выводим на экран то чего не заполниили
        /* if(error_log != ""){
         $("#error_log").text("");
         $("#submit_callback").after("<div id='error_log' class='text-danger'>"+error_log+"</div>");
         }*/

//отправляем форму
        if(errors == 0){
            // $("#error_log").text("");
            $.ajax({
                type: "POST",
                url: '/include/callback_phone.php',
                cache: false,
                data: 'name_call='+name+'&phone_call='+phone,
                beforeSend: function() {
                    $("#hourglass").css("display", "inline-block");
                },
                success: function(data){
					setTimeout( function(){
						$('#callback_phone').html("<p class='b-callback__header'>Ваша заявка принята</p><p class='b-callback__about'>Ожидайте звонка оператора.</p>");
					}, 1000 );
                }
            });

        }

    });

    $('.js-ws-vertical-slider').each(function(){
        var count = $(this).children('div.slide').length;
        if(count > 5){
            $(this).slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                vertical: true,
                autoplay: true
            });
        }
    });

    // дропформа
    $('.__dropform')
        .on('click', 'a[data-dropform]', function (e) {
            e.preventDefault();
            var _ = $(this);
            var container = _.data('dropform');
            if (container) {
                container = $(container);
                if (_.hasClass('open')) {
                    container.slideUp(200);
                    _.removeClass('open');
                } else {
                    container.slideDown(200);
                    _.addClass('open');
                }
            }
        }).on('click', '.__close', function (e) {
            e.preventDefault();
            var _ = $(this).closest('.__dropform');
            _.find('a[data-dropform]').removeClass('open');
            _.find('.ws-dropform').slideUp(200);
        });

    $('.phone_mask').mask("+7 (999) 999-9999");

    $( document ).on( "click", "._validatePopupReg", function(e){
        e.preventDefault();
        var $btn = $(this);
        var $form = $btn.closest('form');
        if(/msie 9/.test(window.navigator.userAgent.toLowerCase())){
            clearPlaceholders($form);
        }
        $.ajax({
            url: '/include/validatePopupReg.php',
            beforeSend: function() {
                $btn.text('Проверка');
                $form.find('.text-danger').remove();
                $('.lpti-error').removeClass('lpti-error');
                $('small.text-danger').remove();

            },
            data: $form.serializeArray(),
            dataType: 'json',
            type: 'POST'
        }).done(function(response) {
            if(!$.isEmptyObject(response)){
                $.each(response,  function(key, val){
                    wsPoperValid.init([
                        $('[name='+key+']'),val
                    ]);
                    //$('[name='+key+']').addClass('lpti-error').before("<small class='text-danger'>"+val+"</small>");
                });
                $btn.text('Зарегистрироваться');
                // $form.find('div.__messages').html(response);
                return false;
            }
            else{
                $form.submit();
            }
        });
    });

    /*Автозаполнение поиска*/

    $.widget("custom.catcomplete", $.ui.autocomplete, {
        _renderItem: function (ul, item) {

            /*
             * <span class="img"><img src="/assets/mobile/img/img_product_search_1.png" width="40" height="40" alt=""></span>
             <span class="name">Максилак капсулы, 10 шт.</span>
             <span class="price"><span class="old">318</span><span class="number">227</span> руб.</span>
             * */
            /*  return $("<li>")
             .attr("data-value", item.value)
             .append("<a class='" + $var_class + "'>"  + $var_img + "<span class='name'>" + item.label + "</span>" + "<span class='price'>" + item.price + " р.</span></a>")
             .data("item", item)
             .appendTo(ul);*/

            if (item.block == 'product') {
                return $("<li></li>").data("ui-autocomplete-item", {
                    label: item.label,
                    value: item.value,
                    block:item.block,
                    link:item.link

                }).append("<a class='search-field__box-field withPrice' onclick='internal_ga_selector([\'_trackEvent\', \'poiskovaya_podskazka\', \'perehod_na_tovar_po_poiskovoi_podskazke\', \'product"+ item.link +"\'])' >"  +
                    /*$var_img + */item.label + (item.price?"<div class='price'><strong>" + item.price + "</strong> руб.</div>":"")+"</a>").appendTo(ul);
            } else if (item.block == 'permanents') {
                return $("<li></li>").data("ui-autocomplete-item", {
                    label: item.label,
                    value: item.value,
                    block:item.block,
                    link:item.link
                }).append("<a class='search-field__box-field withPrice' onclick='internal_ga_selector([\'_trackEvent\', \'poiskovaya_podskazka\', \'perehod_na_ss_po_poiskovoi_podskazke\', \'"+ item.link +"\'])' >"  +
                    /*$var_img + */item.label + (item.price?"<div class='price'>от <strong>" + item.price + "</strong> руб.</div>":"")+"</a>").appendTo(ul);
            }else if (item.block == 'brands') {
                return $("<li></li>").data("ui-autocomplete-item", {
                    label: item.label,
                    value: item.value,
                    block:item.block,
                    link:item.link
                }).append("<a class='search-field__box-field withPrice' onclick='internal_ga_selector([\'_trackEvent\', \'poiskovaya_podskazka\', \'perehod_na_brend_po_poiskovoi_podskazke\', \'"+ item.link +"\'])' >"  +
                item.label + "</a>").appendTo(ul);
            }else if (item.block == 'categories') {
                return $("<li></li>").data("ui-autocomplete-item", {
                    label: item.label,
                    value: item.value,
                    block:item.block,
                    link:item.link
                }).append("<a class='search-field__box-field withPrice' onclick='internal_ga_selector([\'_trackEvent\', \'poiskovaya_podskazka\', \'perehod_na_categoriyu_po_poiskovoi_podskazke\', \'cat"+ item.link +"\'])' >"  +
                item.label + "</a>").appendTo(ul);
            }else if (item.block == 'mnn') {
                return $("<li></li>").data("ui-autocomplete-item", {
                    label: item.label,
                    value: item.value,
                    block:item.block,
                    link:item.link
                }).append("<a class='search-field__box-field withPrice' onclick='internal_ga_selector([\'_trackEvent\', \'poiskovaya_podskazka\', \'perehod_na_mnn_po_poiskovoi_podskazke\', \'"+ item.link +"\'])' >"  +
                item.label + "</a>").appendTo(ul);
            }else if (item.block == 'articles') {
                return $("<li></li>").data("ui-autocomplete-item", {
                    label: item.label,
                    value: item.value,
                    block:item.block,
                    link:item.link
                }).append("<a class='search-field__box-field withPrice' onclick='internal_ga_selector([\'_trackEvent\', \'poiskovaya_podskazka\', \'perehod_na_articles_po_poiskovoi_podskazke\', \'"+ item.link +"\'])' >"  +
                item.label + "</a>").appendTo(ul);
            }else if (item.block == 'analogs') {
                return $("<li></li>").data("ui-autocomplete-item", {
                    label: item.label,
                    value: item.value,
                    block:item.block,
                    link:item.link
                }).append("<a class='search-field__box-field withPrice' onclick='internal_ga_selector([\'_trackEvent\', \'poiskovaya_podskazka\', \'perehod_na_analog_po_poiskovoi_podskazke\', \'product"+ item.link +"\'])' >"  +
                    /*$var_img + */item.label + (item.price?"<div class='price' >от <strong style='color:rgba(88, 89, 91, 0.9);'>" + item.price + "</strong> руб.</div>":"")+"</a>").appendTo(ul);
            }


        },
        _renderMenu: function (ul, items) {
            var self = this,
                currentCategory = "";
            $.each(items, function (index, item) {
                if (item.category != currentCategory) {
                    ul.append("<li class='search-field__box-head'>" + item.category + "</li>");
                    currentCategory = item.category;
                }

                self._renderItem(ul, item);

            });


        }


    });
    var search = $('#m_search');
    var searchback = $('#searchback');

    $( document ).on( "click", ".adh_bgr", function(e){
        var lnk_bg = $(this).data('bg_link');
        var lnk_forward = $(this).data('forward_link');
        if (lnk_forward.length > 1){
            document.location.href=decodeURIComponent(lnk_forward);
            return;
        }
        if (lnk_bg.length > 1){
            var im = $('<img src="'+decodeURIComponent(lnk_bg)+'" style="position:absolute;left:-9999px;top:-9999px;display:none;">');
            $('body').append(im);
        }
    });


    $( document ).on( "click", ".__send_review",function(e){
        e.preventDefault();
        var _ = $(this);
        var $form = _.closest('form');
        var url = $form.attr('action');
        var method = (typeof($form.attr('method')=='undefined'))?'POST':$form.attr('method');
        var rating = ($form.find('.js-stars a.full').length > 0)?$form.find('.js-stars a.full').length:0;
        var data = $form.serialize()+'&rating='+rating;
        $.ajax({
            dataType: "json",
            type:method,
            url:url,
            data:data,
            success:function(data){
                if(data['error_points'] != ''){
                    for(var i in data['error_points']){
                        var $selector ='';
                        if(data['error_points'][i]['field'] == 'g-recaptcha-response'){
                            $selector = '#g-recaptcha';
                        }else{
                            $selector = '[name="'+data['error_points'][i]['field']+'"]';
                        }
                        wsPoperValid.init([
                            $form.find($selector),data['error_points'][i]['text']
                        ]); break;
                    }
                }else{
                    //console.log(data);
                    $form.hide();
                    $('ul[class="reviews-list"]').prepend(data['html']);
                }
            }
        });
    });

    //initPixelCounter();
    if($('.ws-fio-input input').length > 0){
        Common.section_placeholder($('.ws-fio-input input'));
    }

    if($('#ws_feedback_ajax_form').length > 0){
        var _ = $('#ws_feedback_ajax_form');
        var url = _.attr('action');
        var ajax = _.data('ajax');
        var method = _.attr('method');

        _.on('submit',function(e){
            if(ajax){
                e.preventDefault();
                e.stopPropagation();
                var data = _.serialize();
                $.ajax({
                    data:data,
                    url:url,
                    method:method,
                    type:'json',
                    success: function(data){
                        if(data['error_points'] != ''){
                            for(var i in data['error_points']){
                                console.log(1);
                                var $selector ='';
                                if(data['error_points'][i]['field'] == 'g-recaptcha-response'){
                                    $selector = '#g-recaptcha';
                                }else{
                                    $selector = '[name="'+data['error_points'][i]['field']+'"]';
                                }
                                console.log($selector);
                                wsPoperValid.init([
                                    _.find($selector),data['error_points'][i]['text']
                                ]); break;
                            }
                        }else{
                            _.hide().after(data['html']);
                        }
                    }
                });
                return false;
            }else{
                // вдруг требуется отправка перезагрузкой.
                return true;
            }
        });

    }


});

$(document).on('click','.ws_call_back',function(e){
    e.preventDefault();
    e.stopPropagation();
    $(window).scrollTop(0);
    $('.callback-link').trigger('click');
    $('#name_callback').focus();
});

function trim(sStr){
    sStr += '';
    return sStr.replace(/^\s*(.*?)\s*$/gi,'$1');
};

/*!
 * jQuery Cookie Plugin v1.4.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2006, 2014 Klaus Hartl
 * Released under the MIT license// для товаров
 */
(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD (Register as an anonymous module)
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // Node/CommonJS
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function ($) {

    var pluses = /\+/g;

    function encode(s) {
        return config.raw ? s : encodeURIComponent(s);
    }

    function decode(s) {
        return config.raw ? s : decodeURIComponent(s);
    }

    function stringifyCookieValue(value) {
        return encode(config.json ? JSON.stringify(value) : String(value));
    }

    function parseCookieValue(s) {
        if (s.indexOf('"') === 0) {
            // This is a quoted cookie as according to RFC2068, unescape...
            s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
        }

        try {
            // Replace server-side written pluses with spaces.
            // If we can't decode the cookie, ignore it, it's unusable.
            // If we can't parse the cookie, ignore it, it's unusable.
            s = decodeURIComponent(s.replace(pluses, ' '));
            return config.json ? JSON.parse(s) : s;
        } catch(e) {}
    }

    function read(s, converter) {
        var value = config.raw ? s : parseCookieValue(s);
        return $.isFunction(converter) ? converter(value) : value;
    }

    var config = $.cookie = function (key, value, options) {

        // Write

        if (arguments.length > 1 && !$.isFunction(value)) {
            options = $.extend({}, config.defaults, options);

            if (typeof options.expires === 'number') {
                var days = options.expires, t = options.expires = new Date();
                t.setMilliseconds(t.getMilliseconds() + days * 864e+5);
            }

            return (document.cookie = [
                encode(key), '=', stringifyCookieValue(value),
                options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                options.path    ? '; path=' + options.path : '',
                options.domain  ? '; domain=' + options.domain : '',
                options.secure  ? '; secure' : ''
            ].join(''));
        }

        // Read

        var result = key ? undefined : {},
        // To prevent the for loop in the first place assign an empty array
        // in case there are no cookies at all. Also prevents odd result when
        // calling $.cookie().
            cookies = document.cookie ? document.cookie.split('; ') : [],
            i = 0,
            l = cookies.length;

        for (; i < l; i++) {
            var parts = cookies[i].split('='),
                name = decode(parts.shift()),
                cookie = parts.join('=');

            if (key === name) {
                // If second argument (value) is a function it's a converter...
                result = read(cookie, value);
                break;
            }

            // Prevent storing a cookie that we couldn't decode.
            if (!key && (cookie = read(cookie)) !== undefined) {
                result[name] = cookie;
            }
        }

        return result;
    };

    config.defaults = {};

    $.removeCookie = function (key, options) {
        // Must not alter options, thus extending a fresh object...
        $.cookie(key, '', $.extend({}, options, { expires: -1 }));
        return !$.cookie(key);
    };

}));
/*
function dataLayerAddToCart(id,name,price,brand,category,quantity){
    dataLayer.push({
        "ecommerce": {
            "add": {
                "products": [
                    {
                        "id": id,
                        "name": name,
                        "price": price,
                        "brand": brand,
                        "category": category,
                        "quantity": quantity
                    }
                ]
            }
        }
    });

}
function dataLayerDeleteFromoCart(id,name){
    dataLayer.push({
        "ecommerce": {
            "remove": {
                "products": [
                    {
                        "id": id,
                        "name": name
                    }
                ]
            }
        }
    });

}
*/
function recalculateShopCart(product_id, quantity, _this, variation_id) {
    if (product_id && quantity) {
        var data_to_send = "product_id="+product_id + "&quantity=" + quantity;

		console.log(data_to_send);
        $.ajax({
            //dataType: "json",
            type: "POST",
            url: "/include/recalculate_cart.php?action=update_product",
            data: data_to_send
        }).done(function (response) {
            var expr = /\d+/g;
            var btn = $(_this);
            // по id самый быстрый селектор
            if (response) $('.__cart-count').text(response).removeClass('hidden').show();

        });
    } else {
        $.post('/include/recalculate_cart.php?action=update_widget', {a: 'b'}, function (response) {
            if (response){
                window.cartNum.text(response);
            }
        });
    }
}
function cartDelete(product_id,_this, variation){
    if (product_id) {
        var data_to_send = "product_id="+product_id;

        $.ajax({
            //dataType: "json",
            type: "POST",
            url: "/include/recalculate_cart.php?action=delete_product",
            data: data_to_send
        }).done(function (response) {
            var expr = /\d+/g;
            var btn = $(_this).closest('.ws-ih-extra').find('.ws-btn.blue');

            if (response || response == 0) $('.__cart-count').text(response).show();

            if(!btn.is('button')) btn.text('Купить').removeClass('in_cart').removeAttr('href');
        });
    }
}
function validateEmail(email){
    var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
    if(pattern.test(email)) return true;
    else return false;
}

var Common = {

    url : {
        rev_plus_minus : '/include/review_plus_minus.php',
        rev_plus_minus_med : '/include/review_plus_minus_med.php',
        rev_plus_minus_drugstore : '/include/review_plus_minus_drugstore.php',
        capcha : '/capcha_reviews/drawtep.php'
    },

    reinit: function(){

//        /$('.bs-title').tooltip();

        return this;
    },

    /* автозаполнение полей при смене контроллеров в корзине из куки */
    autoval_inputs: function(model_assoc) {

        // переданый список полей будет записан по соответствию в модель корзины
        // остальные поля сработают простым назначением свойства val()
        var assoc = model_assoc || {};
        var set = {};
        $.each(window.$cookie, function(i,v){
            var _inp = $('input[name="'+i+'"]');
            if(_inp.length && _inp.val().length == 0){

                if(i in assoc){
                    set[assoc[i]] = v;
                }

                _inp.val(v);
            }
        });

        if(Object.keys(set).length && m_ShopCart){
            m_ShopCart.set(set, {silent: true});
        }
    },

    // считаем номер звезды в контейнере по событию
    // w_star размер 1 звезды
    // count максимальное кол-во звезд
    get_star_num: function($this, event, w_star, count){

        if (!event) {event = window.event; event.target = event.srcElement}

        var oLeft = (event.offsetX === undefined)
            ? event.pageX-$this.offset().left // FF+Opera
            : event.offsetX; // other
        if(Math.ceil(oLeft/w_star)==1){
            var num = Math.round(oLeft/w_star);
        }else{
            var num = Math.ceil(oLeft/w_star);
        }
        if (num < 0 || num > count) num = count;
        return num;
    },

    review_plus_minus: function(_, e){
        e && e.preventDefault();
        var _li = _.closest('.wsc-row');
        var helpful_type = _.hasClass('__reviewPlus')?'plus':'minus';
        $.ajax({
            type: 'POST',
            url: this.url.rev_plus_minus,
            cache: false,
            data: "pid="+ _li.data('pid') +"&rid="+ _li.data('rid') +"&type="+ helpful_type,
            dataType: 'json',
            success: function(data){
                if(data.status == 'ok'){
                    _.next('.digit').text(data.helpful_count);
                }else if(data.status == 'error_upd'){
                    //console.log(data);
                }else if(data.status == 'error_ip_isset'){
                    alert('Сегодня вы уже оценили полезность этого отзыва.');
                }
            },
            error: function(data){
                //console.log(data);
            }
        });
    },

    review_plus_minus_med: function(_, e){
        e && e.preventDefault();
        var _li = _.closest('.wsc-row');
        var _medlink = _.closest('.wsc-after').data('med');
        var helpful_type = _.hasClass('__reviewPlusMed')?'plus':'minus';
        $.ajax({
            type: 'POST',
            url: this.url.rev_plus_minus_med,
            cache: false,
            data: "rid="+ _li.data('rid') +"&type="+ helpful_type+'&link='+_medlink,
            dataType: 'json',
            success: function(data){
                if(data.status == 'ok'){
                    _.next('.digit').text(data.helpful_count);
                }else if(data.status == 'error_upd'){
                    //console.log(data);
                }else if(data.status == 'error_ip_isset'){
                    alert('Сегодня вы уже оценили полезность этого отзыва.');
                }
            },
            error: function(data){
                //console.log(data);
            }
        });
    },

    review_plus_minus_drugstore: function(_, e){
        e && e.preventDefault();
        var _li = _.closest('.wsc-row');
        var helpful_type = _.hasClass('__reviewPlusDrugstore')?'plus':'minus';
        $.ajax({
            type: 'POST',
            url: this.url.rev_plus_minus_drugstore,
            cache: false,
            data: "pid="+ _li.data('pid') +"&rid="+ _li.data('rid') +"&type="+ helpful_type,
            dataType: 'json',
            success: function(data){
                if(data.status == 'ok'){
                    _.next('.digit').text(data.helpful_count);
                }else if(data.status == 'error_upd'){
                    //console.log(data);
                }else if(data.status == 'error_ip_isset'){
                    alert('Сегодня вы уже оценили полезность этого отзыва.');
                }
            },
            error: function(data){
                //console.log(data);
            }
        });
    },
    /*
     * Инициализация контейнера звезд с указанием ширины звезды
     */
    rating_init: function(container, width, count){

        $(container).on('mousemove', function(e){

            var $this = $(this);
            var num = Common.get_star_num($this, e, width, count);

            var result = $('#vote_result').val();

            if (result == 0) {
                $this.find('.full').css('width', num*width);
            }
        });

        $(container).on('click touchend', function(e){

            var $this = $(this);
            var num = Common.get_star_num($this, e, width, count);
            $('#vote_result').val(num);
            $this.find('.full').css('width', num*width);
        });
    },

    /*
     * Инициализация контейнера звезд с указанием ширины звезды (универсальная - перейти на неё!)
     */
    rating_universal: function(container, width, count){

        $(container).on('mousemove', function(e){

            var _ = $(this);
            var num = Common.get_star_num(_, e, width, count);
            var result = _.find('input').val();

            if (result == 0) {
                _.find('.full').css('width', num*width);
            }
        });

        $(container).on('click touchend', function(e){

            var _ = $(this);
            var num = Common.get_star_num(_, e, width, count);
            _.find('input').val(num);
            _.find('.full').css('width', num*width);
        });
    },

    /* перезагрузка капчи которая лежит в том же контейнере рядом */
    refresh_capcha: function(id_btn){
        $(id_btn).on('click touchend', function(){
            var rand = Math.round(Math.random()*999);
            $('.__capcha_img').fadeOut(100).attr('src', Common.url.capcha+'?r='+rand).attr('alt','capcha').fadeIn(200);
        });
    },
    answer_for_reviews: function(){
        $( document ).on( "click", "#answers_form_submit_button", function(e){
            e.preventDefault();

            var $btn = $(this);
            var $f = $btn.parent().parent();

            $f.find('.alert').fadeOut('200').remove();
            $.ajax({
                url: $f.attr('action'),
                beforeSend: function() {
                    $f.find('alert').fadeOut(200).remove();
                },
                data: $f.serializeArray(),
                dataType : 'json',
                type: 'POST'
            }).done(function(response) {
                if(response.html) {
                    $f.html(response.html);
                    setTimeout(function(){
                        $('#answer_for_'+$btn.data('id'))
                    }, 5000);
                }
                if(response.error) {
                    $btn.before(response.error);
                }
            });
        })
    },

    show_loader: function(container, speed){

        var $loader = $(container).find('div.ws-loader');
        var speed = speed || 200;

        if ($loader.length) {
            $loader.fadeIn(speed);
        } else {
            $loader = $('<div>').addClass('ws-loader');
            $(container).prepend($loader.hide().fadeIn(speed));
        }

        return true;
    },

    hide_loader: function(container, remove){

        var $loader = $(container).find('div.ws-loader');

        $loader.fadeOut(100);
        if(remove) $loader.delay(100).remove();

        return true;
    },

    scrollTo: function(selector, speed, timeout, offset){
        if (selector.length == 1) {
            /*console.log('Scroll to: '+selector.offset().top);*/
            var speed = parseInt(speed) || 300;
            var timeout = parseInt(timeout) || 0;
            var offset = parseInt(offset) || -120;
            $('html, body').stop().delay(timeout).animate({scrollTop: selector.offset().top + offset}, speed);
        }
    },

    setEqualHeight: function (columns)
    {
        var tallestcolumn = 0;
        columns.each(
            function()
            {
                currentHeight = $(this).height();
                if(currentHeight > tallestcolumn)
                {
                    tallestcolumn = currentHeight;
                }
            }
        );
        columns.height(tallestcolumn);
    },

    /* Установка ошибочного состояния для инпута */
    setError : function(elem, text){
        setPopover(elem, text, 'top', 'error');
        elem.addClass('error');
        elem.one('click', function(){elem.removeClass('error')});
    },

    init_slick: function(selector){
        selector.slick({
            infinite: false,
            slidesToShow: 5,
            arrows: false,
            slidesToScroll: 1,
            speed: 400,
            initialSlide: 0,
            variableWidth: true
        });
        selector.parent().find('.slick-prev').on('click', function(){
            selector.slick('slickPrev');
        });
        selector.parent().find('.slick-next').on('click', function(){
            selector.slick('slickNext');
        });

        $('.b-good__list').hover(function(){$(this).find('.slick-prev,.slick-next').fadeIn()},function(){$(this).find('.slick-prev,.slick-next').fadeOut()});
    },

    common_rdr : function (ln){	document.location.href = ln; },
    prfl : function (n){ document.location.href = '/product/'+n+'/analog'; },
    prfls : function (n){ document.location.href = '/product/'+n; },

    // секционная подсказка по аттрибуту placeholder
    section_placeholder: function(selector){

        var _ = $(selector);
        var $div = _.parent().find('.fakeplaceholder');
        if($div.length == 0 || $div.data('words').length < 1){
            $div = $('<div class="animate-all">').addClass('fakeplaceholder').hide();
            $div.data('placeholder', _.attr('placeholder'));
            $div.data('color', $div.css('color'));
            $div.data('words', _.attr('placeholder').split(/[\s]+/));
        }
        var words = $div.data('words');

        function convert(){
            var text = _.val().split(/[\s]+/);
            text = text.slice(0,3);
            var compile = [];
            $.each(words, function(i,v){
                if(i in text && text[i].length){
                    compile[i] = '<span>'+text[i]+'</span>';
                }
                else compile[i] = v; // default
            });
            $div.html(compile.join('&nbsp;'));
        }

        _.off()
            .on('input', function(){
                convert();
            }).on('change', function(){
                convert();
            });

        convert();
        _.attr('placeholder', '').css({background: 'transparent'});
        _.parent().prepend($div.fadeIn(50));
    }
};
function donor(element) {

    return $('#wsc-donor').find(element).clone().hide();
}
function isValidEmailPil(email)
{
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}


$(function(){
    $('.tabs_wrapper .tab').on({
        click: function (e) {
            e.preventDefault();
            e.stopPropagation();
            var _ = $(this);
            _.closest('.tabs_wrapper').find('.tab').removeClass('active');
            _.closest('.tabs_wrapper').find('.tab_content').hide();
            _.addClass('active').closest('.tabs_wrapper').find('#'+_.data('id')).show();
            return false;
        }
    });

    if($('.tabs_wrapper .tab').length){
        $('.tabs_wrapper .tab:first').trigger('click');
    }

    /*
     <div class="__tabs" data-container="#tabs">
     <a href="#tab1" class="active">1</a>
     <a href="#tab2">2</a>
     </div>
     <div id="tabs">
     <div id="tab1">text1</div>
     <div id="tab2">text2</div>
     </div>
     */
    function ws_tabs_open_tab(_, scroll){
        var _ = $(_);
        scroll = scroll || false;
        var $all_tabs = _.closest('.__tabs').find('a');
        var $container = _.closest('.__tabs').data('container');
        var selector = _.attr('href') || _.data('tab');

        if(selector && $(selector).length){
            $container = $($container);
            $container.children().addClass('dn').attr('style', false);
            $all_tabs.removeClass('active');
            _.addClass('active');
            $(selector).fadeIn(300);
            if(scroll){
                Common && Common.scrollTo($(selector), 300, 0, -200);
            }
        }
    }

    $('body').on('click', '.__tabs a', function(e){
        var _ = $(this);
        var href = _.attr('href');
        if(href.indexOf('/') >= 0){document.location.href = href; return false;}
        if(href.indexOf('#') >= 0 || _.hasClass('active')){
            e.preventDefault();
            ws_tabs_open_tab(this, true);
        }
    });

    $('.__tabs a.active').each(function(){
        var _ = $(this);
        var selector = _.attr('href') || _.data('tab');
        if(selector.indexOf('/') >= 0){return false}
        if(selector && $(selector).length && $(selector).hasClass('dn')){
            ws_tabs_open_tab(this, false);
        }
    });

    /* открывашки гармошки в фильтрах */
    function opener_open(_, show){
        var _container = $(_.data('open'));
        var show = show || false;
        if(_container.length){
            _container.addClass('__open');
            _.addClass('active');
            if(show === true){
                _container.show();
            } else {
                _container.slideDown(200);
            }
        }
    }
    function opener_close(_){
        var _container = $(_.data('open'));
        if(_container.length){
            _container.removeClass('__open');
            _.removeClass('active');
            _container.slideUp(200);
        }
    }

    $('body').on('click', '.__opener', function(e){
        e.preventDefault();
        var _ = $(this);
        if(_.hasClass('active')){
            opener_close(_);
        } else {
            opener_open(_);
        }
    });
    $(window).on('resize load', function(){
        if($(this).width() > 640) {
            $('.__opener.auto640').each(function(){
                opener_open($(this), true);
            });
        }
    });
    $('.__opener.active').each(function(){
        opener_open($(this), true);
    });

    window.cache_scrolls = $('.__scroll');
    window.cache_scrolls.on('click', function(e){
        var dop_offset = 0;

        var _ = $(this);
        var to = _.data('to') || _.attr('href');
        if($('#commentform:hidden').height && (to == "#related" || to == "#sertificates")){
            dop_offset = $('#commentform:hidden').height();
        }
        var offset = _.data('offset') || -100;
        offset = dop_offset + offset;
        var speed = _.data('speed') || 300;
        to = $(to);
        if(to){
            e.preventDefault();
            window.cache_scrolls.removeClass('active');
            _.addClass('active');
            window.Common.scrollTo($(to), speed, false, offset);
        }
    });
});
function splitNumber(iNumber , sSplitter){
    iNumber += '';


    iNumber = iNumber.replace(/[^\d\.]/gi,'');
    iNumber = Math.round(iNumber * 1) + '';

    if(!sSplitter){
        sSplitter = ' ';
    }

    var
        iPos = iNumber.length - 3,
        sRes = ''
        ;
    while(iPos > 0){
        sRes = sSplitter + iNumber.substr(iPos,3) + sRes;
        iPos -= 3;
    }
    sRes = iNumber.substr(0,iPos+3) + sRes;

    return sRes;
};
function printPrice(pr){

    pr = pr + '';
    var sDot = '';
    if(pr.indexOf('.') != -1){
        pr = pr * 1;
        pr = pr.toFixed(2) + '';

        sDot = pr.substr(pr.indexOf('.'));
    } else {
        sDot = '.00'
    }

    //pr = splitNumber(pr,'&nbsp;') + '<span class="kop">'+sDot+'</span>';
    pr = splitNumber(pr,'&nbsp;');

    pr = pr.replace(/\./gi,',');

    pr = pr.replace(/\,/gi,'');

    return pr;
}


function setCookie(name, value, options) {
    options = options || {};

    var expires = options.expires;

    if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }

    value = encodeURIComponent(value);

    var updatedCookie = name + "=" + value;

    for (var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }

    document.cookie = updatedCookie;
}

function loadAxaxContent(block,method){
	console.log(method);
    $.ajax({
        dataType:	"html",
        type: 		"POST",
        url:		"/include/"+method + ".php"
    }).done(function(response){
        if(response){
            $(block).html(response);

        }
    });
}
//////////////////////////////////////////////////////
function clearPlaceholders($form){

    if(/msie/.test(window.navigator.userAgent.toLowerCase())){

        var $inputs = $form.find('input[type="text"],input[type="password"]'); //однострочные только текстовые
        var $textareas = $form.find('textarea');

        $.each($inputs, function(){
            if($(this).val() == $(this).attr('placeholder')) $(this).val('');
        });
        $.each($textareas, function(){
            if($(this).text() == $(this).attr('placeholder')) $(this).text('');
        });
    }
}
function ie_paceholder(){
    //return false;
    if(/msie/.test(window.navigator.userAgent.toLowerCase())){
        var $inputs = $('input'); //однострочные только текстовые
        var $textareas = $('form textarea');
        // однострочные
        $.each($inputs, function(id, one){
            var $one = $(one);
            var placeholder = $one.attr('placeholder');
            if(placeholder) {
                if($one.val() == '') $one.val(placeholder).css('color', '#aaa').addClass('pl'); //первая встреча
                $one.on('focus', function(){
                    if($one.val() == placeholder) $one.val('').css('color', '#484849').removeClass('pl'); //если не заполняли
                }).on('blur', function(){
                    if($one.val() == '') $one.val(placeholder).css('color', '#aaa').addClass('pl'); //если не заполнили
                });
            }
        });
        // многострочные

        $.each($textareas, function(id, one){
            var $one = $(one);
            var placeholder = $one.attr('placeholder');
            if(placeholder) {
                if($one.text == '') $one.text(placeholder).css('color', '#aaa').addClass('pl');
                $one.on('focus', function(){
                    if($one.text() == placeholder) $one.text('').css('color', '#484849').removeClass('pl');
                }).on('blur', function(){
                    if($one.text() == '') $one.text(placeholder).css('color', '#aaa').addClass('pl');
                });
            }
        });

        $('form').on('submit', function(){
            var $form = $(this);
            clearPlaceholders($form);
            setTimeout(function(){
                $form.find('input').trigger('blur');
                $form.find('textarea').trigger('blur');
            }, 100);
        });
    }
}

var wsPoperValid = {

    wrap : '<div class="hashws" style="position:relative"></div>',

	init : function (itemList){

		if(typeof(itemList) == 'object'){
			if(typeof(itemList[1])!='string'){
				for(var i in itemList){
					wsPoperValid.addPoper(itemList[i][0],itemList[i][1]);
				}
			}else{
				wsPoperValid.addPoper(itemList[0],itemList[1]);
			}
		}else{
			console.log('Недрпустимый формат входящих параметров. Нужем массив ["jQuery","сообщение"] или массив таких массивов');
		}

	},

    addPoper : function ($i,mess){

        if($i.hasClass('invalid')){
            wsPoperValid.removePoper($(this));
        }
        $i.addClass('invalid');

        if(typeof($i.closest('.ws-fio-input')) != 'undefined'){
            $i.closest('.ws-fio-input').css({'overflow':'inherit'});
        }

        $i.wrap(this.wrap).closest('div').append('<div class="tooltip__hint tooltip__hint--alert">'+mess+'<div class="tooltip__arrow">&#9660;</div></div>').find('div').show();
        $i.bind('focus',function(){
            wsPoperValid.removePoper($(this));
			$(this).focus();
        });
        $i.bind('click',function(){
            if(typeof($i.closest('.ws-fio-input')) != 'undefined'){
                $i.closest('.ws-fio-input').css({'overflow':'hidden'});
            }
            wsPoperValid.removePoper($(this));
        });
    },

	hidePoper : function($this){
		$this.closest('div').find('.tooltip__hint').hide();
	},

    removePoper : function ($i){
        $i.removeClass('invalid').closest('div').find('.tooltip__hint').remove();
        $i.unwrap(this.wrap);
        $i.unbind('focus');
        $i.unbind('click');
    }
};

// for recaptcha
if($('#g-recaptcha').lendht > 0  || $('#g-recaptcha_product').lendht > 0){
    var onloadCallback = function() {
        // main(first)
        grecaptcha.render('g-recaptcha', {
            'sitekey' : '6LdjHBQTAAAAAGQ1FRQxjxiEaKnsEpxR_ZPrmTP-',
            callback: function(){
                console.log('капча прошла успешно');
            }
        });
        // the second recaptcha product (http://www.piluli.ru/product/some_prf)
        grecaptcha.render('g-recaptcha_product', {
            'sitekey' : '6LdjHBQTAAAAAGQ1FRQxjxiEaKnsEpxR_ZPrmTP-',
            'size' : 'compact',
        });
    };
}


function moveBanner(){
    var _width = $(window).width();
    if($('.movedBanner').length &&  $('#mobileMovedBanner').length){
        var _wrap = $('.movedBanner');
        var html = $('.movedBanner').html();
        if(_width < 850){
            $('#mobileMovedBanner').html(html);
            $('.movedBanner').html('');
        }
        $(window).resize(function(){
            if($(window).width() > 850 && _width < 850){
                _width = 900;
                $('#mobileMovedBanner').html('');
                _wrap.html(html);
            }
            else if($(window).width() < 850 && _width > 850){
                _width = 800;
                $('#mobileMovedBanner').html(html);
                _wrap.html('');

            }
        });

    }



}
$.fn.highLightSearch = function( search, replace, text_only ) {
    return this.each(function(){
        var node = this.firstChild,
            val,
            new_val,
            remove = [];
        if ( node ) {
            do {
                if ( node.nodeType === 3 ) {
                    val = node.nodeValue;
                    new_val = val.replace( search, '<strong>$&</strong>' );
                    if ( new_val !== val ) {
                        if ( !text_only && /</.test( new_val ) ) {
                            $(node).before( new_val );
                            remove.push( node );
                        } else {
                            node.nodeValue = new_val;
                        }
                    }
                }
            } while ( node = node.nextSibling );
        }
        remove.length && $(remove).remove();
    });
};

// для товаров
function counterclickproducts_lnk(n,id){
    var patt = /^\d{1,}$/;
    var link_flag = patt.exec(n);
    if (link_flag){
        var href = encodeURIComponent(document.location.href);
        console.log('/counterclick.html?cat=products&id='+n+'&href='+href);
        document.location.href = '/counterclick.html?cat=products&id='+n+'&href='+href;
    }else{
        $.getJSON("/ajax/get_url_adhands",{url_adhands:n}, function(json){
            if (json.ans){
                console.log('y');
                document.location.href = n;
            }else{
                console.log('n');
                console.log(json.h);
                if(id){
                    var href = encodeURIComponent(document.location.href);
                    document.location.href = '/counterclick.html?cat=products&id='+id+'&href='+href;
                }

            }
        });
    }
};
// для товаров(акционных) с которых переход на статью
function counterclickproducts_lnk_to_articles(n, tpath, act){
    var href = encodeURIComponent(document.location.href);
    document.location.href = '/counterclick.html?cat=products&id='+n+'&artpath='+tpath+'&artact='+act+'&href='+href;
}
// для аналогов
function counterclickanalogproducts_lnk(n){
    var patt = /^\d{1,}$/;
    var link_flag = patt.exec(n);
    if (link_flag){
        var href = encodeURIComponent(document.location.href);
        document.location.href = '/counterclick.html?cat=analog&id='+n+'&href='+href;
    }else{
        document.location.href = n;
    }
};
// для СС аналогов
function counterclickanalog_ss_lnk(n,f){
    var href = encodeURIComponent(document.location.href);
    document.location.href = '/counterclick.html?cat=prf_analog&id='+n+'&formid='+f+'&href='+href;
};
// если товар(одновременно обычный) и товар-аналог
function counterclick_prod_and_analog_lnk(n){
    var href = encodeURIComponent(document.location.href);
    document.location.href = '/counterclick.html?cat=products&cat2=analog&id='+n+'&href='+href;
};
// сопутств
function counterclick_accompanyings_products_lnk(n,id){
    var patt = /^\d{1,}$/;
    var link_flag = patt.exec(n);
    if (link_flag){
        var href = encodeURIComponent(document.location.href);
        document.location.href = '/counterclick.html?cat=accompanyings&id='+n+'&href='+href;
    }else{
        $.getJSON("/ajax/get_url_adhands",{url_adhands:n}, function(json){
            if (json.ans){
                console.log('y');
                document.location.href = n;
            }else{
                console.log('n');
                if(id){
                    var href = encodeURIComponent(document.location.href);
                    document.location.href = '/counterclick.html?cat=accompanyings&id='+id+'&href='+href;
                }

            }
        });
    }
};
// для статьей
function pixelcounter(tpath, act){
    var patt = /^\d{1,}$/;
    var link_flag = patt.exec(act);
    if (link_flag){
        var href = encodeURIComponent(document.location.href);
        document.location.href = '/counterclick.html?cat=articles&artpath='+tpath+'&artact='+act+'&href='+href;
    }else{
        $.getJSON("/ajax/get_url_adhands",{url_adhands:act}, function(json){
            if (json.ans){
                console.log('y');
                document.location.href = act;
            }else{
                console.log('n');
                if(tpath){
                    var href = encodeURIComponent(document.location.href);
                    document.location.href = '/counterclick.html?cat=articles&artpath='+tpath+'&artact='+act+'&href='+href;
                }

            }
        });
    }
}
// для статьей для отображение красивой ссылки в тексте самой статьи
function rdr(a,id,cat){
    var href = encodeURIComponent(document.location.href);
    cat = cat || 'links';
    a.href = "/counterclick.html?cat=" + cat + "&id=" + id +'&href='+href;
}
/* подгрузка картинок при скроллинге
 $(function(){

 inWindow($('._js-load-img')).each(function(){
 var src = $(this).data('src');
 if(src) $(this).attr('src',$(this).data('src')).removeClass('_js-load-img');
 });
 $(window).scroll(function(){
 inWindow($('._js-load-img')).each(function(){
 var src = $(this).data('src');
 if(src) $(this).animate({ opacity: 0 }, 100).attr('src',$(this).data('src')).animate({ opacity: 1 }, 100).removeClass('_js-load-img');

 });
 });
 })*/