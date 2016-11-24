<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>


<script type="text/javascript">
	$(function () {
		$(document).on('click', '#s_form button', function(e) {
			e.preventDefault();
			$('#s_form button[type="button"]').remove();
			if($('#s_form input').val().length < 3){
				wsPoperValid.init([
					$('#s_form input'),"Впишите минимум 3 символа!"
				]);
				return false;
			}


			var $btn = $(this);
			var $f = $('#s_form');

			$.ajax({
				url: $f.attr('action'),
				beforeSend: function() {
					$btn.addClass('ws-miniloader');
				},
				data: $f.serializeArray(),
				/*dataType : 'json',*/
				type: 'POST',
				success: function(response) {
					if(response) {
						$('.b-spisok').html('<button type="button" class="btn-reg mb20" onclick="location.reload()">Сбросить результат поиска</button>' + response);
					}
					$btn.removeClass('ws-miniloader');
				}
			});

		});


		var $letters = $('a.tab_letters');
		var $lettersTop = $('#letters_top').find('a.tab_letters');

		function selected_letters(count) {
			var selected = [];
			$lettersTop.filter('.active').each(function (i, elem) {
				selected.push($(elem).attr('href'));
			});
			//console.log(selected.length);
			if (count) return selected.length;
			return selected;
		}

		function show_eng() {
			$('.__letter_group').hide();
			$('#65,#66,#67,#68,#69,#70,#71,#72,#73,#74,#75,#76,#77,#78,#79,#80,#81,#82,#83,#84,#85,#86,#87,#88,#89,#90').parent().show();
		}

		function show_rus() {
			$('.__letter_group').hide();
			$('#192,#193,#194,#195,#196,#197,#168,#198,#199,#200,#201,#202,#203,#204,#205,#206,#207,#208,#209,#210,#211,#212,#213,#214,#215,#216,#217,#218,#219,#220,#221,#222,#223').parent().show();
		}


		$('a.tab_letters').on('click touchend', function (e) {
			var $this = $(this);
			e.preventDefault();
			var id = $this.attr('href');

			if ($this.hasClass('active')) { // снимаем активность и скрываем
				$letters.filter('a[href=' + id + ']').removeClass('active');
				$(id).parent().hide();
				$letters.removeClass('active');
				if (selected_letters(1) == 0) {
					$('a.lettersall').addClass('active');
					$('.b-spisok__top').show();
				}
			} else { // ставим активность и отображаем
				$letters.removeClass('active');
				$letters.filter('a[href=' + id + ']').addClass('active');
				$('.b-spisok__top').hide();
				$('a.lettersall').removeClass('active');
				/*$.each(selected_letters(), function(i, href){
				 $(href).parent().show();
				 });*/
				$(id).parent().show();
				$('a.all_num').removeClass('active');
			}
		});

		$('a.lettersall').on('click touchend', function () {
			$letters.removeClass('active');
			$('a.all_num, a.all_eng, a.all_rus').removeClass('active');
			$('a.lettersall').addClass('active');
			$('.__all_num, .__all_eng, .__all_rus').show();
		});


		$('a.all_eng').on('click', function () {
			console.log("rabotaet");
			//show_eng();
			$letters.removeClass('active');
			$('a.all_eng').addClass('active');
			$('a.lettersall, a.all_num, a.all_rus').removeClass('active');
			$('.__all_eng').show();
			$('.__all_rus, .__all_num').hide();
		});

		$('a.all_rus').on('click', function () {
			//show_rus();
			console.log("rabotaet");
			$letters.removeClass('active');
			$('a.all_rus').addClass('active');
			$('a.lettersall, a.all_num, a.all_eng').removeClass('active');
			$('.__all_rus').show();
			$('.__all_eng, .__all_num').hide();
		});

		$('a.all_num').on('click', function () {
			console.log("rabotaet");
			$letters.removeClass('active');
			$('a.all_num').addClass('active');
			$('a.lettersall, a.all_eng, a.all_rus').removeClass('active');
			$('.__all_num').show();
			$('.__all_eng, .__all_rus').hide();
		});
	});
</script>

<div class="">

	<div class="brands--atabs clearfix">
		<a href="javascript:void(0)" class="lettersall active">Все</a>
		<a href="javascript:void(0)" class="all_num">0-9</a>
		<a href="javascript:void(0)" class="all_eng">A-Z</a>
		<a href="javascript:void(0)" class="all_rus">А-Я</a>
	</div>

	<div class="brands--filter">
		<div class="brands--filter-list">
			<span class="__all_num dn">
				<a href="#49" class="b-form__navigation-link tab_letters">1</a>
				<a href="#51" class="b-form__navigation-link tab_letters">3</a>
				<a href="#52" class="b-form__navigation-link tab_letters">4</a>
				<a href="#53" class="b-form__navigation-link tab_letters">5</a>
				<a href="#54" class="b-form__navigation-link tab_letters">6</a>
				<a href="#57" class="b-form__navigation-link tab_letters">9</a>
			</span>
			<span class="__all_eng">
				<a href="#65" class="b-form__navigation-link tab_letters">A</a>
				<a href="#66" class="b-form__navigation-link tab_letters">B</a>
				<a href="#67" class="b-form__navigation-link tab_letters">C</a>
				<a href="#68" class="b-form__navigation-link tab_letters">D</a>
				<a href="#69" class="b-form__navigation-link tab_letters">E</a>
				<a href="#70" class="b-form__navigation-link tab_letters">F</a>
				<a href="#71" class="b-form__navigation-link tab_letters">G</a>
				<a href="#72" class="b-form__navigation-link tab_letters">H</a>
				<a href="#73" class="b-form__navigation-link tab_letters">I</a>
				<a href="#74" class="b-form__navigation-link tab_letters">J</a>
				<a href="#75" class="b-form__navigation-link tab_letters">K</a>
				<a href="#76" class="b-form__navigation-link tab_letters">L</a>
				<a href="#77" class="b-form__navigation-link tab_letters">M</a>
				<a href="#78" class="b-form__navigation-link tab_letters">N</a>
				<a href="#79" class="b-form__navigation-link tab_letters">O</a>
				<a href="#80" class="b-form__navigation-link tab_letters">P</a>
				<a href="#81" class="b-form__navigation-link tab_letters">Q</a>
				<a href="#82" class="b-form__navigation-link tab_letters">R</a>
				<a href="#83" class="b-form__navigation-link tab_letters">S</a>
				<a href="#84" class="b-form__navigation-link tab_letters">T</a>
				<a href="#85" class="b-form__navigation-link tab_letters">U</a>
				<a href="#86" class="b-form__navigation-link tab_letters">V</a>
				<a href="#87" class="b-form__navigation-link tab_letters">W</a>
				<a href="#88" class="b-form__navigation-link tab_letters">X</a>
				<a href="#89" class="b-form__navigation-link tab_letters">Y</a>
				<a href="#90" class="b-form__navigation-link tab_letters">Z</a>
			</span>
			<span class="__all_rus dn">
				<a href="#192" class="b-form__navigation-link tab_letters">А</a>
				<a href="#193" class="b-form__navigation-link tab_letters">Б</a>
				<a href="#194" class="b-form__navigation-link tab_letters">В</a>
				<a href="#195" class="b-form__navigation-link tab_letters">Г</a>
				<a href="#196" class="b-form__navigation-link tab_letters">Д</a>
				<a href="#197" class="b-form__navigation-link tab_letters">Е</a>
				<a style="color: #424242">Ё</a>
				<a href="#198" class="b-form__navigation-link tab_letters">Ж</a>
				<a href="#199" class="b-form__navigation-link tab_letters">З</a>
				<a href="#200" class="b-form__navigation-link tab_letters">И</a>
				<a href="#201" class="b-form__navigation-link tab_letters">Й</a>
				<a href="#202" class="b-form__navigation-link tab_letters">К</a>
				<a href="#203" class="b-form__navigation-link tab_letters">Л</a>
				<a href="#204" class="b-form__navigation-link tab_letters">М</a>
				<a href="#205" class="b-form__navigation-link tab_letters">Н</a>
				<a href="#206" class="b-form__navigation-link tab_letters">О</a>
				<a href="#207" class="b-form__navigation-link tab_letters">П</a>
				<a href="#208" class="b-form__navigation-link tab_letters">Р</a>
				<a href="#209" class="b-form__navigation-link tab_letters">С</a>
				<a href="#210" class="b-form__navigation-link tab_letters">Т</a>
				<a href="#211" class="b-form__navigation-link tab_letters">У</a>
				<a href="#212" class="b-form__navigation-link tab_letters">Ф</a>
				<a href="#213" class="b-form__navigation-link tab_letters">Х</a>
				<a style="color: #424242">Ц</a>
				<a href="#215" class="b-form__navigation-link tab_letters">Ч</a>
				<a href="#216" class="b-form__navigation-link tab_letters">Ш</a>
				<a style="color: #424242">Щ</a>
				<a style="color: #424242">Ъ</a>
				<a style="color: #424242">Ы</a>
				<a style="color: #424242">Ь</a>
				<a href="#221" class="b-form__navigation-link tab_letters">Э</a>
				<a href="#222" class="b-form__navigation-link tab_letters">Ю</a>
				<a href="#223" class="b-form__navigation-link tab_letters">Я</a>
			</span>
		</div>
		<div class="clear"></div>
		<div class="brands--filter-form">
			<form class="search-alpha" id="s_form" method="post" action="/ajax/s_brand">
				<input type="text" class="b-header__middle-search-input ui-autocomplete-input" name="s" placeholder="Введите название бренда">
				<button class="btn-reg">Найти</button>
			</form>
		</div>
	</div>


<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"",
	Array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"NEWS_COUNT" => $arParams["NEWS_COUNT"],
		"SORT_BY1" => $arParams["SORT_BY1"],
		"SORT_ORDER1" => $arParams["SORT_ORDER1"],
		"SORT_BY2" => $arParams["SORT_BY2"],
		"SORT_ORDER2" => $arParams["SORT_ORDER2"],
		"FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
		"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
		"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
		"SET_TITLE" => $arParams["SET_TITLE"],
		"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
		"MESSAGE_404" => $arParams["MESSAGE_404"],
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"SHOW_404" => $arParams["SHOW_404"],
		"FILE_404" => $arParams["FILE_404"],
		"INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
		"ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_FILTER" => $arParams["CACHE_FILTER"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
		"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
		"PAGER_TITLE" => $arParams["PAGER_TITLE"],
		"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
		"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
		"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
		"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
		"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
		"PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
		"PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
		"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
		"DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
		"DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
		"PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
		"ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
		"USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
		"GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
		"FILTER_NAME" => $arParams["FILTER_NAME"],
		"HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
		"CHECK_DATES" => $arParams["CHECK_DATES"],

		"PARENT_SECTION" => $arResult["VARIABLES"]["SECTION_ID"],
		"PARENT_SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
	),
	$component
);?>

</div>