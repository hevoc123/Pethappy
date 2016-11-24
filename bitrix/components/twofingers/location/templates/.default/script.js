var tf_location_cities_loaded = false;
var speed = 300;
function tfLocationPopup(path, callback) {
	TFLocationOverlay = $('.custom-popup-2014-overlay');
	TFLocationPopup = $('.custom-popup-2014');
	TFLocationOverlay.appendTo('body');
	TFLocationPopup.appendTo('body');
	$('body').children().addClass('tf_location_body_blur');
	
	TFLocationCallback = callback; TFLoctaionComponentPath = path; 
	TFLocationPopupContent = $('.custom-popup-2014-content'); TFLocationCitiesList = TFLocationPopup.find('.popup-city .inner');
	TFLocationCurrentList = TFLocationPopup.find('.current-list'); TFLocationSearch = TFLocationPopup.find('.city-search'); TFLocationNiceScroll = TFLocationPopup.find(".nice-scroll");
	TFLocationOverlay.fadeIn(speed, function() {
		TFLocationOverlay.removeClass('tf_location_body_blur');
		TFLocationPopup.removeClass('tf_location_body_blur');
		if (!tf_location_cities_loaded) {
			TFLocationPopup.addClass('loading');
			$.get(path+'/functions.php', {request: 'getcities'}, function(data) {
				TFLocationCitiesList.append('<ul class="result-list"></ul>');
				if (data.CITIES) {
					$.each(data.CITIES, function(key, city) {
						TFLocationCitiesList.find('ul').append('<li><a data-id="'+city.ID+'" href="#">'+city.NAME+'</a></li>');
					});
				}
				if (data.DEFAULT_CITIES) {
					$.each(data.DEFAULT_CITIES, function(key, city) {
						TFLocationCurrentList.append('<li><a data-id="'+city.ID+'" href="#">'+city.NAME+'</a></li>');
					});
				} else {
					TFLocationPopup.find('.popup-city').css('width', 630);
					TFLocationPopup.find('.result-list').css('width', 630);
				}
				TFLocationPopupContent.fadeIn();
				TFLocationPopup.removeClass('loading');
				TFLocationNiceScroll.getNiceScroll().resize();
				TFLocationNiceScroll.niceScroll({
					cursorwidth: 10,
					cursorcolor: '#aaa',
					cursorborderradius: 5,
					autohidemode: false,
					background: '#eee',
					horizrailenabled: false
				});
			}, 'json');
			TFLocationSearch.keyup(function() {
				TFLocationSearchRequest = $(this).val().toUpperCase();
				if (TFLocationSearchRequest.length > 0) TFLocationPopup.find('.clear_field').fadeIn();
					else TFLocationPopup.find('.clear_field').fadeOut();
				TFLocationCitiesList.find('a').each(function() {
					var city = $(this).html().toUpperCase();
					if (city.indexOf(TFLocationSearchRequest) < 0) {
						$(this).parent().hide();
					} else {
						$(this).parent().show();
					}
				});
				TFLocationNiceScroll.getNiceScroll().resize();
			});
			TFLocationPopup.find('.clear_field').click(function() {
				$(this).fadeOut();
				TFLocationSearch.val('');
				TFLocationCitiesList.find('li').show();
				TFLocationNiceScroll.getNiceScroll().resize();
			});
			tf_location_cities_loaded = true;
		}
	});
	TFLocationPopup.fadeIn(speed, function(){
		TFLocationNiceScroll.getNiceScroll().resize();
	});
	$('.custom-popup-2014-overlay, .custom-popup-2014 .custom-popup-2014-close').on('click', function(){
		TFLocationOverlay.fadeOut(speed);
		TFLocationPopup.fadeOut(speed);
		$('.tf_location_body_blur').removeClass('tf_location_body_blur')
	});
	return false;
}
function TFLocationSelected(cityID, cityNAME) {
	alert(cityID + ': ' + cityNAME);
}
$().ready(function() {
	$('.custom-popup-2014-content').delegate('li a', 'click', function() {
		$('.tf_location_link span').html($(this).html());
		selctedCityID = $(this).data('id');
		selctedCityNAME = $(this).html();
		$('.tf_location_city_input').val(selctedCityID);
		$.post(TFLoctaionComponentPath+'/functions.php', {request: 'setcity', city: selctedCityID}, function() {
			TFLocationOverlay.fadeOut(speed);
			TFLocationPopup.fadeOut(speed, function() {
				$('.tf_location_body_blur').removeClass('tf_location_body_blur')
				if ($.type(TFLocationCallback) == 'function') {
					TFLocationCallback(selctedCityID, selctedCityNAME);
				} else if ($.type(window[TFLocationCallback]) == 'function') {
					window[TFLocationCallback](selctedCityID, selctedCityNAME);
				}
			});
		});
		return false;
	});
});