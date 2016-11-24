$(function ($) {
	
	var CF = { // Category Filters
		
		url: '/ajaxfilters/category',
		ajax_processing : 0,
		group_sorting : false, // групповая сортировка
		$result_area: $('#filter_results'), // область результатов
		$submit: $('#filter_submit'), // кнопка применить фильтр
		filters: {
			forms: [],
			pStart: parseInt($('#p_start > b').text()),
			pEnd: parseInt($('#p_end > b').text()),
			orderby: '6d',
			sortall: new Array()
		},
		query: {
			CAT: $('#filter_results').data('cid') || -1,
			OPTS : new Array,
			products_order : '6d',
			type_list : 'card'
		},
		
		get_filters: function () {
			
			// формы
			this.filters.forms = $('#filter_forms').find('input[type="checkbox"]').serializeArray();
			// цена от
			this.filters.pStart = parseInt($('#fromRange > b').text());
			// цена до
			this.filters.pEnd = parseInt($('#toRange > b').text());
			// id категории
			this.filters.cid = this.$result_area.data('cid');
			// строка запроса (для старых фильтров в некоторых категориях)
			this.filters.get = this.$result_area.data('qs');
			// новые фильтры тегами
			this.filters.tags = $('#filter_tags').find('input[type="checkbox"]').serializeArray();
			
			this.filters.sortall = new Array(); //clear
			// передаем только выбранные виды сортировки повторно
			var $current = $('.__filter_orderby').find('a.current');
			if(this.group_sorting){
				// в групповой сортировке передаем все текущие сортировки
				$current.each(function(i,v){
					CF.filters.sortall.push($(v).data('sort'));
				});
			} else {
				// в обычной сортировке передаем текущую сортировку только если она совпадает с выбранной (для переключения)
				// иначе применяется новая сортировка
				if($current.length && $current.first().data('sort') == this.filters.orderby){
					this.filters.sortall.push(this.filters.orderby);
				}
			}

			if (this.query.CAT !== false) this.filters.filterData = this.query;

			return this.filters;
		},
		
		/* отправка всех фильтров на обработку */
		ajax: function(__callback){
			
			if (CF.ajax_processing) return false;

			CF.ajax_processing = 1;
			CF.$submit.addClass('ws-miniloader');
			$.post(CF.url, CF.get_filters(), function(response){
				CF.ajax_processing = 0;
				CF.$submit.removeClass('ws-miniloader');
				return __callback(response);
			});
		},
	};

	// global
	window.CF = CF;
	
	if (window.isCatFilter) { // инициализируем только на странице с фильтрацией
		
		// инициализируем фильтр с параметрами из атрибутов
		$.each($('#filter_init').data(), function(k,v){	CF.filters[k] = v; });
		window.filters = CF.filters;

		CF.$submit.on('click', function (e) {
			e.preventDefault();
			$('#filter_kill').show();
			CF.ajax(function (response) {

				if (response.html) {
					CF.$result_area.hide().empty().html(response.html);
				}
				if (response.links) {
					$('.__filter_orderby').html(response.links);
				}
				if(response.consolelog){
					console.log(response.consolelog);
				}
				if(response.page && response.page != CF.filters.page){
					CF.filters.page = parseInt(response.page);
				}
				CF.$result_area.fadeIn(150);
				window.Common.reinit();
			});
		});

		$("#price_range").slider({
			range: true,
			min: CF.filters.pStart,
			max: CF.filters.pEnd,
			values: [CF.filters.pStart, CF.filters.pEnd],
			slide: function (event, ui) {
				CF.filters.pStart = ui.values[ 0 ];
				CF.filters.pEnd = ui.values[ 1 ];
				CF.filters.page = 1; // при изменении цен сбрасываем фильтр пагинации (limit\offset)
				$("#p_start > b").text(ui.values[ 0 ]);
				$("#p_end > b").text(ui.values[ 1 ]);
			}
		});
		
		// сброс пагинации при выборе любого чекбока на странице
		$('#content').on('click', 'input[type=checkbox]', function(){
			CF.filters.page = 1;
		});

		CF.$result_area.on('click', '.pagination [data-page]', function (e) {

			e.preventDefault();
			var page = $(this).data('page');
			if (page) {
				CF.filters.page = parseInt(page);
				CF.$submit.trigger('click');
				$('html, body').stop().animate({scrollTop: CF.$result_area.offset().top - 120}, 300);
			}
		});

		$('#filter_kill').on('click', function (e) {
			e.preventDefault();
			window.location.reload();
		}); 

		$('.__filter_orderby').on('click', 'a', function (e) {
			
			e.preventDefault();
			CF.filters.orderby = $(e.currentTarget).data('sort');
			CF.$submit.trigger('click');
		});

		$('#filter_links input[type=checkbox]').change(function () {
			CF.query.OPTS = new Array;
			$('#filter_links input[type=checkbox]').each(function () {
				if ($(this).prop("checked")) {
					CF.query.OPTS.push($(this).attr("name"));
				} 
			});
		});

		/*$('.filter_attribute_block .catalog_filter_item').on('click', function () {
			ga('send', 'event', 'categories_filter', 'click', 'filter_attr');
		});*/
	}

});