(function( $ ) {

    $.fn.piluli_stylize = function(options ) {

        var css_is_loaded = 0;

        var settings = $.extend( {
            'css_file'         : '/bitrix/templates/empty/styles/widget.css'
        }, options);

        var check_load_css = function(){
            if (!$('body').data('piluli_stylize-inited')){
                $('head').append('<link>');
                var css_f = $('head').children(':last');
                css_f.attr({
                    rel:  "stylesheet",
                    type: "text/css",
                    href: settings.css_file
                });
                $('body').data('piluli_stylize-inited', 1);
            }
        }

        /**********************
         // чекбокс для фильтра
         ***********************/
        var checkbox_filter = function(self){

            if (self.css('display') == 'none'){
                return;
            }
            if (self.data('widget_inited')){
                return;
            }
            self.data('widget_inited', 1);

            self.wrap( '<div class="style-filter_checkbox"></div>' );
            var _w  = self.parent();

            if (self.is(':checked')){
                _w.addClass('checked');
            }
            if (self.is(':disabled')){
                _w.addClass('disabled');
            }

            self.change(function(){
                if ($(this).is(':checked')){
                    _w.addClass('checked');
                }else{
                    _w.removeClass('checked');
                }
            })

            _w.on('click',function(event){
                event.preventDefault();
                self.click();
            })

            self.on('click', function (event) {
                event.stopPropagation();
            })

        }

        /**********************
         // большие чекбоксы
         **********************/
        var checkbox_large = function(self){

            if (self.css('display') == 'none'){
                return;
            }
            if (self.data('widget_inited')){
                return;
            }
            self.data('widget_inited', 1);

            self.wrap( '<div class="style-large_checkbox"></div>' );
            var _w  = self.parent();

            if (self.is(':checked')){
                _w.addClass('checked');
            }
            if (self.is(':disabled')){
                _w.addClass('disabled');
            }

            self.change(function(){
                if ($(this).is(':checked')){
                    _w.addClass('checked');
                }else{
                    _w.removeClass('checked');
                }
            })

            _w.on('click',function(event){
                event.preventDefault();
                self.click();
            })

            self.on('click', function (event) {
                event.stopPropagation();
            })

        }

        /**********************
         // классически чекбоксы
         **********************/
        var checkbox = function(self){

            if (self.css('display') == 'none'){
                return;
            }
            if (self.data('widget_inited')){
                return;
            }
            self.data('widget_inited', 1);

            self.wrap( '<div class="style_checkbox"></div>' );
            var _w  = self.parent();

            if (self.is(':checked')){
                _w.addClass('checked');
            }
            if (self.is(':disabled')){
                _w.addClass('disabled');
            }

            self.bind('change', function(){
                if ($(this).is(':checked')){
                    _w.addClass('checked');
                }else{
                    _w.removeClass('checked');
                }
            })

            _w.on('click',function(event){
                event.preventDefault();
                self.click();
            })

            self.on('click', function (event) {
                event.stopPropagation();
            })

        }

        /**********************
         // табы из radio (используются в корзине)
         **********************/
        var radio_tabs = function(self){
            if (self.data('widget_inited')){
                return;
            }
            self.data('widget_inited', 1);

            self.wrap( '<div class="confirm-tab-item"></div>' );
            var _w  = self.parent();

            _w.append(self.data("user_type_name"));

            if (self.is(':checked')){
                _w.addClass('confirm-active_tab');
            }


            self.bind('change', function(){
                $('.confirm-tab-item input[type="radio"]').each(function(){
                    if ($(this).is(':checked')) {
                        $(this).closest('.confirm-tab-item').addClass('confirm-active_tab');
                    } else {
                        $(this).closest('.confirm-tab-item').removeClass('confirm-active_tab');
                    }
                });
            })

            _w.on('click',function(event){
                event.preventDefault();
                self.click();
            })

            self.on('click', function (event) {
                event.stopPropagation();
            })
        }

        /**********************
         // табы из radio (используются в корзине)
         **********************/
        var radio_shopcart_tabs = function(self){
            if (self.data('widget_inited')){
                return;
            }
            self.data('widget_inited', 1);

            self.wrap( '<div class="confirm-tab-item"></div>' );
            var _w  = self.parent();

            _w.append("<table><tr><td><div class='confirm-tab-item-inner'>" + self.data("label") + "</div></td></tr></table>");


            if (self.is(':checked')){
                _w.addClass('confirm-active_tab');
            }
            if (self.is(':disabled')){
                _w.addClass('disabled');
            }

            self.bind('change', function(){
                $('.confirm-tab-item input[type="radio"]').each(function(){
                    if ($(this).is(':checked')) {
                        $(this).closest('.confirm-tab-item').addClass('confirm-active_tab');
                    } else {
                        $(this).closest('.confirm-tab-item').removeClass('confirm-active_tab');
                    }
                });
            })

            _w.on('click touchstart',function(event){

                event.preventDefault();
                self.click();
            })

            self.on('click', function (event) {
                event.stopPropagation();
            })
        }

        /**********************
         // табы из radio (общие)
         **********************/
        var radio_tabs_common = function(self){
            if (self.data('widget_inited')){
                return;
            }
            self.data('widget_inited', 1);

            self.wrap( '<div class="tab-common-item"></div>' );
            var _w  = self.parent();
            var _b = _w.closest('.b-tabs-common');

            _w.append(self.data("label"));


            _b.find('.tab-common-item input[type="radio"]').each(function(ind){
                var relClass = $(this).data("rel-note");
                if ($(this).is(':checked')) {
                    $(this).closest('.tab-common-item').addClass('active_tab-common');
                    $('.' + relClass).eq(ind).show();
                } else {
                    $(this).closest('.tab-common-item').removeClass('active_tab-common');
                    $('.' + relClass).eq(ind).hide();
                }
            });

            self.bind('change', function(){
                _b.find('.tab-common-item input[type="radio"]').each(function(ind){
                    var relClass = $(this).data("rel-note");
                    if ($(this).is(':checked')) {
                        $(this).closest('.tab-common-item').addClass('active_tab-common');
                        $('.' + relClass).eq(ind).show();
                    } else {
                        $(this).closest('.tab-common-item').removeClass('active_tab-common');
                        $('.' + relClass).eq(ind).hide();
                    }
                });
            })

            _w.on('click',function(event){
                event.preventDefault();
                self.click();
            })

            self.on('click', function (event) {
                event.stopPropagation();
            })
        }
        /****************
         // табы из radio для доставки в подмосковье (используются в корзине)
         **********************/
        var radio_tabs_delivery = function(self){
            if (self.data('widget_inited')){
                return;
            }
            self.data('widget_inited', 1);

            self.wrap( '<div class="undermoscow_delivery-tab"></div>' );
            var _w  = self.parent();

            _w.append("<div class='undermoscow_delivery-tab-info'>" + self.data("delivery_info") + "</div>");
            _w.append("<div class='undermoscow_delivery-tab-price'>" + self.data("delivery_price") + "<span> руб.</span></div>");

            /*
             * mobile version options
             */
            if(typeof self.data('is_mobile') !== 'undefined'){
                _w.append("<div class='undermoscow_delivery-tab-arrow'><i class=\"fa fa-long-arrow-right\"></i></div>");
            }

            if (self.is(':checked')){
                _w.addClass('undermoscow_delivery-tab-active_tab');
            }

            self.bind('change', function(){
                $('.b-confirm_deliver-list-item-undermoscow-w input[type="radio"]').each(function(){
                    if ($(this).is(':checked')) {
                        $(this).closest('.undermoscow_delivery-tab').addClass('undermoscow_delivery-tab-active_tab');
                    } else {
                        $(this).closest('.undermoscow_delivery-tab').removeClass('undermoscow_delivery-tab-active_tab');
                    }
                });
            })

            _w.on('click',function(event){
                event.preventDefault();
                self.click();
            })

            self.on('click', function (event) {
                event.stopPropagation();
            })
        }


        /**********************
         // классически radio
         **********************/
        var radio = function(self){

            if (self.css('display') == 'none'){
                return;
            }
            if (self.data('widget_inited')){
                return;
            }
            self.data('widget_inited', 1);
            self.data('widget_radio_main', 1);

            self.wrap( '<div class="style-radio"></div>' );
            var _w  = self.parent();

            if (self.is(':checked')){
                _w.addClass('checked');
            }
            if (self.is(':disabled')){
                _w.addClass('disabled');
            }

            self.bind('change', function(){
                $('input[type="radio"]').each(function(){
                    if($(this).data('widget_radio_main')) {
                        if ($(this).is(':checked')) {
                            $(this).closest('.style-radio').addClass('checked');
                        } else {
                            $(this).closest('.style-radio').removeClass('checked');
                        }
                    }
                });
                //_w.addClass('checked');
            })

            _w.on('click',function(event){
                event.preventDefault();
                self.click();
            })

            self.on('click', function (event) {
                event.stopPropagation();
            })

        }

        /**********************
         // выбор периода оповещение (цикличные товары)
         **********************/
        cyclical_intervals = function(self){
            if (self.css('display') == 'none'){
                return;
            }
            if (self.data('widget_inited')){
                return;
            }
            self.data('widget_inited', 1);
            self.css({"visibility": "hidden", "width" : "1px", "height": "1px", "display": "none"});
            var cur_opt = self.find("option:selected");
            var class_name = self.attr('class');

            self.wrap("<div class='remind-me__select left'></div>");
            var _w = self.closest('.remind-me__select');
            _w.append("<a href='#' class='remind-me__select-title clearfix'><span class='title'>" + cur_opt.data("short") + "</span><i class='piluli-caret-down'></i></a>");
            _w.append("<ul class='remind-me__select-options'></ul>");
            var _list = _w.find('.remind-me__select-options');
            self.find("option").each(function(index){
                var current_class = "";
                if ($(this).is(":selected")){
                    current_class = " current";
                }
                _list.append("<li class='" + current_class + "' data-ind='" + index + "'>" + $(this).text() + "</div>");
            })


            _w.find('.remind-me__select-title').on('click', function(e){
                var wnd = $(this).next();
                wnd.toggle(0);
                e.preventDefault();
                e.stopPropagation();
            })

            self.change(function(){
                _w.find('.title').text($(this).find("option:selected").data("short"));
                $(this).find("option").each(function(index){
                    if ($(this).is(":selected")){
                        _w.find('.remind-me__select-options li').filter("[data-ind='" + index + "']").addClass('current');
                    }else{
                        _w.find('.remind-me__select-options li').filter("[data-ind='" + index + "']").removeClass('current');
                    }

                })
            })

            _w.find('.remind-me__select-options li').on('click', function(e){
                var ind = parseInt($(this).data("ind"));
                self.find("option").each(function(index){
                    if(ind == index){
                        $(this).prop('selected', true);
                        self.trigger('change');
                        _w.find('.remind-me__select-options').hide();
                    }
                })
                e.stopPropagation();
            })

            _w.find('.remind-me__select-options').on('click', function (e) {
                e.stopPropagation();
            })

            $(document).click(function(){
                _w.find('.remind-me__select-options').hide();
            })

        }

        /**********************
         // выпадающий список с возможностью ввода произвольного значения
         // выбор только одного значения
         **********************/
        source_list = function(self){
            var self = self;
            if(!self.data('list_source').length || !self.data('selected_item_name_id').length || self.data('is_init')){
                return false
            }
            self.attr('autocomplete', 'off');
            self.data('is_init', 1);
            var ignore_update = false;
            var data_list = [];
            var source = self.data('list_source');
            var ext_source_param = self.data('ext') || 0;
            var selected_item_point = $('input[name="' + self.data('selected_item_name_id') + '"]');
            var selected_id = selected_item_point.val() || 0;
			var default_text = self.data('def_text') || '';
            var arrow = self.closest('div').find('i.piluli-angle-down');
            var tmpl = "<ul id = 'source_list_widget' class='source_list_widget_wnd'>\
                        <ul>\
                            ";

            if(!$("#source_list_widget").length){
                $('body').append(tmpl);
            }
            var w = $("#source_list_widget");
            w.html("");
            w.hide();
            self.data('pil_widget_autocompl_init', 0);

            var cache_key = self.attr('name');
            if(typeof window._piluli_wdg_storage !== 'undefined' && typeof window._piluli_wdg_storage[cache_key] !== 'undefined'){
                self.data('pil_widget_autocompl_init', 1);
                data_list = window._piluli_wdg_storage[cache_key];
            }else {
                if(typeof window._piluli_wdg_storage === 'undefined'){
                    window._piluli_wdg_storage = {};
                }
                window._piluli_wdg_storage[cache_key] = new Array();
                data_list = window._piluli_wdg_storage[cache_key];
                $.ajax({
                    url: source,
                    method: "GET",
                    data: {},
                    dataType: "json"
                }).done(function (msg) {
                    if (typeof msg !== 'undefined' && msg.length) {
                        w.html("");
                        $.each(msg, function (index, value) {
                            data_list.push({
                                id: value.id,
                                name: value.name,
                                ext_id: typeof value.ext_id !== 'undefined' ? value.ext_id : 0,
                                ref_id: typeof value.metro_id !== 'undefined' ? value.metro_id : 0,
                                ref_name: typeof value.metro_name !== 'undefined' ? value.metro_name : ""
                            });
                        });
                        self.data('pil_widget_autocompl_init', 1);
                        if(typeof window._piluli_wdg_storage === 'undefined'){
                            window._piluli_wdg_storage = {};
                        }
                        window._piluli_wdg_storage[cache_key] = data_list;
                    }
                })
            }

            function drawList(){
                if ( parseInt(self.data('pil_widget_autocompl_init')) != 1){
                    return false;
                }
                w.html("");
				/*
                if(self.val().length < 3){
                    w.hide();
                    return;
                }
				*/

                // coordinate for list
                var left = self.offset().left;
                var top = self.offset().top;
                var height = self.outerHeight();
                var width = self.outerWidth();
                w.css({left: left + 'px', top: (top + height) + 'px', width: width - 2 });

                if(data_list.length){
                    w.html("");
                    var ext_id = 0;
                    if(ext_source_param){
                        ext_id = $('input[name="' + ext_source_param + '"]').val();
                    };
                    var i = 0;
                    w.append('<div class="scrollbar-outer"><div>');
                    var w_scr = w.find(".scrollbar-outer");
                    $.each(data_list, function(index, value){
                        if(i >= 9){
                            return;
                        }
                        if((value.name.toLowerCase().indexOf(self.val().toLowerCase()) >= 0 && ext_id == value.ext_id)){
                            w_scr.append("<li data-id='" + value.id + "' data-value='" + value.name + "'>" + value.name + "</li>");
                            i++;
                        }
                    });

					if(w.find('li').length && default_text){
						w_scr.prepend('<li class="select-default_text">' + default_text + '</li>');
					}
                    w.show();
                   w_scr.jScrollPane({});

                    w.find('li').on('mousedown touchstart', function(){
                        ignore_update = true;
                    })

                    w.find('li').click(function(e){
						if($(this).hasClass('select-default_text')){
							return;
						}
                        e.stopPropagation();
                        chooseItem($(this));
                        ignore_update = false;
                    })

                    w.find('li').hover(
                        function() {
                            $( this ).css({'width': '400px'});
                        }, function() {
                            $( this ).css({'width': 'auto'});
                        }
                    )
                }
            }

            function chooseItem(item){
                selected_item_point.val(item.data("id"));
                selected_item_point.trigger("change");
                self.val(item.data("value"));
                self.trigger('change');
                self.trigger('choose'); // special event type for choosing position from points List
                w.hide();
            }

            self.blur(function(e){
                if(!ignore_update) {
                    self.trigger('choose');
                }
            })

            self.keydown(function(e){
                var code = e.keyCode || e.which;
                if(code == 13){
                    e.preventDefault();
                    e.stopPropagation();
                    w.find('.active_item').trigger('click');
                    return;
                }
            })

            self.keyup(function(e){
                var code = e.keyCode || e.which;
                // key down
                if(code == 40) {
                    if (w.find('li:not(.select-default_text)').length) {
                        if (w.find('.active_item').length) {
                            if(w.find('li:not(.select-default_text)').index( w.find('.active_item') ) < (w.find('li:not(.select-default_text)').length) - 1){
                                var cur_index = w.find('li:not(.select-default_text)').index( w.find('.active_item') );
                                w.find('li').removeClass('active_item');
                                w.find('li:not(.select-default_text)').eq(cur_index + 1).addClass('active_item');
                            }
                        } else{
                            w.find('li:not(.select-default_text)').first().addClass('active_item');
                        }
                    }
                    return;
                    //key up
                }else if(code == 38){
                    if (w.find('.active_item').length) {
                        if(w.find('li:not(.select-default_text)').index( w.find('.active_item') ) > 0 ){
                            var cur_index = w.find('li:not(.select-default_text)').index( w.find('.active_item') );
                            w.find('li').removeClass('active_item');
                            w.find('li:not(.select-default_text)').eq(cur_index - 1).addClass('active_item');
                        }
                    }
                    return;
                }
                drawList();
                selected_item_point.val("");
                $.each(data_list, function(index, value){
                    if(value.name.toLowerCase() == self.val().toLowerCase()){
                        selected_item_point.val(value.id);
                    }
                });
                selected_item_point.trigger("change");
            })


            self.click(function(){
                drawList();
            })

            arrow.click(function(){
                self.click();
                self.focus();
            })

            $(document).click(function(e){
                if ($(e.target).closest("#source_list_widget").attr("id") == "source_list_widget"
                        || (typeof ($(e.target).closest('div').find('input[type="text"]').attr('data-list_source')) !== 'undefined')
                        || $(e.target).hasClass('scrollbar-outer')
                        || $(e.target).hasClass('scroll-bar')
                        || $(e.target).closest('.scroll-element').hasClass('scrollbar-outer')){
                    e.stopPropagation();
                }else{
                    w.hide();
                }
            });

        }


        /**********************
         // стилизованный select
         **********************/
        select_list = function(self){
            if (self.css('display') == 'none'){
                return;
            }
            if (self.data('widget_inited')){
                return;
            }
            self.data('widget_inited', 1);
            self.css({"visibility": "hidden", "width" : "1px", "height": "1px"});
            var cur_opt = self.find("option:selected");
            var class_name = self.attr('class');
            var size = parseInt(self.attr('size')) || 6;
            var disabled = self.attr('disabled');

            if (typeof disabled !== typeof undefined && disabled !== false) {
                class_name += " disabled";
            }
            self.wrap("<span class='style-select " + class_name + "'></span>");
            var _w = self.closest('.style-select');
            _w.append("<span class='style-select-title'><span class='style-select-title-text'>" + (cur_opt.data('text') || cur_opt.html()) + "</span><i class='fa piluli-angle-down'></i></span>");
            _w.append("<div class='style-select_w'><div class='style-select-list'></div></div>");
            var _list = _w.find('.style-select-list');
            self.find("option").each(function(index){
                var current_class = "";
                if ($(this).is(":selected")){
                    current_class = " current";
                }
                if($(this).is("[data-text]")){
                    _list.append("<div class='style-select-list-item" + current_class + "' data-ind='" + index + "'>" + $(this).data('text') + "</div>");
                }else{
                    _list.append("<div class='style-select-list-item" + current_class + "' data-ind='" + index + "'>" + $(this).html() + "</div>");
                }

            })




            function close_list(self){
                $('.style-select').each(function(){
                    if (self && $(this).is(self)){
                        return;
                    }
                    $(this).find('.style-select_w').hide();
                   // $(this).find('.style-select-title .fa').removeClass('piluli-angle-down').addClass('piluli-angle-down');

                })
            }

            _w.find('.style-select-title').on('click', function(e){
                var disabled = self.attr('disabled');
                if (typeof disabled !== typeof undefined && disabled !== false) {
                    return;
                }
                var wnd = $(this).next();
                wnd.toggle(0);
                close_list(_w);
                if(wnd.is(':visible')){
                    if(self.find("option").length > size){
                        _list.addClass('scrollbar-outer');
                        //initUI();
                    }
                    wnd.jScrollPane({});
                    //_w.find('.style-select-title .fa').removeClass('piluli-angle-down').addClass('piluli-angle-up');
                }
                e.stopPropagation();
            })

            self.change(function(){
                _w.find('.style-select-title-text').text($(this).find("option:selected").html());
                $(this).find("option").each(function(index){
                    if ($(this).is(":selected")){
                        _w.find('.style-select-list-item').filter("[data-ind='" + index + "']").addClass('current');
                    }else{
                        _w.find('.style-select-list-item').filter("[data-ind='" + index + "']").removeClass('current');
                    }

                })
            })

            _w.find('.style-select-list-item').on('click', function(e){
                var ind = parseInt($(this).data("ind"));
                self.find("option").each(function(index){
                    if(ind == index){
                        $(this).prop('selected', true);
                        self.trigger('change');
                        //_w.find('.style-select_w').hide();
                        close_list();
                    }
                })
                e.stopPropagation();
            })

            _w.find('.style-select_w').on('click', function (e) {
                e.stopPropagation();
            })

            $(document).click(function(){
                //_w.find('.style-select_w').hide();
                close_list();
            })

        }


        /***************************************************************
         *   MAIN
         ***************************************************************/
        return this.each(function() {

            check_load_css();
            var self = $(this);

            // определяем тип элемента интерфейса
            if (self.attr('type') === 'checkbox' && self.hasClass('pililu_stylize') && self.data('pililu_stylize-filter')){
                // чекбокс для фильтра
                checkbox_filter(self);
            }else if(self.attr('type') === 'checkbox' && self.hasClass('pililu_stylize') && self.data('pililu_stylize-large')) {
                // большой чекбокс
                checkbox_large(self);
            }else if(self.attr('type') === 'checkbox' && self.hasClass('pililu_stylize')){
                // классический чекбокс
                checkbox(self);
            }else if(self.attr('type') === 'radio' && self.closest('.b-tabs-common').hasClass('b-tabs-common')){
                //class="b-tabs-common" - делаем табы из radio (обычные)
                radio_tabs_common(self);
            }else if(self.attr('type') === 'radio' && self.closest('.confirm-tab-w').hasClass('confirm-tab-w')){
                //class="confirm-tab-w" - делаем табы из radio
                radio_tabs(self);
            }else if(self.attr('type') === 'radio' && self.closest('.confirm-tab-shopcart').hasClass('confirm-tab-shopcart')){
                //class="confirm-tab-shopcart" - делаем табы из radio (корзина)
                radio_shopcart_tabs(self);
            }else if(self.attr('type') === 'radio' && self.closest('.b-confirm_deliver-list-item-undermoscow-w').hasClass('b-confirm_deliver-list-item-undermoscow-w')){
                //class="b-confirm_deliver-list-item-undermoscow-w" - делаем табы из radio для выбора доставки в подмосковье
                radio_tabs_delivery(self);
            }else if(self.attr('type') === 'radio'){
                // классический чекбокс
                radio(self);
            }else if(self.data("cyclical_intervals")){
                cyclical_intervals(self);
            }else if(self.attr('type') === 'text' && self.data('list_source')){
                source_list(self);
            }else if(self.is('select') && self.hasClass('stylized')){
                select_list(self);
            }
        });

    };
})(jQuery);

$(function(){
    $('input, select').piluli_stylize();
})