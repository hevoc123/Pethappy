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
if($arResult["VARIABLES"]["ELEMENT_CODE"]=='index.php'):
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
						var result=$(response).find(".ajax_container").html();
						$(document).find('.ajax_container').html('<button type="button" class="btn-reg mb20" onclick="location.reload()">Сбросить результат поиска</button>' + result);
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
<?
$chars=Array();

$arSelect = Array("ID", "NAME");
$arFilter = Array("IBLOCK_ID"=>6, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ar_res = $res->GetNext())
{
	$chars[$ar_res["NAME"]{0}]++;
}

if($_POST["s"])
	$GLOBALS["arrFilter"]["NAME"]=$_POST["s"]."%";
?>
<div class="brands">

	<div class="brands--atabs clearfix">
		<a href="javascript:void(0)" class="lettersall active">Все</a>
		<a href="javascript:void(0)" class="all_num">0-9</a>
		<a href="javascript:void(0)" class="all_eng">A-Z</a>
		<a href="javascript:void(0)" class="all_rus">А-Я</a>
	</div>

	<div class="brands--filter">
		<div class="brands--filter-list">
			<span class="__all_num dn">
				<a <?if($chars[1]):?>href="#49" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>1</a>
				<a <?if($chars[2]):?>href="#50" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>2</a>
				<a <?if($chars[3]):?>href="#51" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>3</a>
				<a <?if($chars[4]):?>href="#52" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>4</a>
				<a <?if($chars[5]):?>href="#53" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>5</a>
				<a <?if($chars[6]):?>href="#54" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>6</a>
				<a <?if($chars[7]):?>href="#55" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>7</a>
				<a <?if($chars[8]):?>href="#56" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>8</a>
				<a <?if($chars[9]):?>href="#57" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>9</a>
			</span>
			<span class="__all_eng">
				<a <?if($chars["A"]):?>href="#65" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>A</a>
				<a <?if($chars["B"]):?>href="#66" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>B</a>
				<a <?if($chars["C"]):?>href="#67" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>C</a>
				<a <?if($chars["D"]):?>href="#68" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>D</a>
				<a <?if($chars["E"]):?>href="#69" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>E</a>
				<a <?if($chars["F"]):?>href="#70" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>F</a>
				<a <?if($chars["G"]):?>href="#71" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>G</a>
				<a <?if($chars["H"]):?>href="#72" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>H</a>
				<a <?if($chars["I"]):?>href="#73" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>I</a>
				<a <?if($chars["J"]):?>href="#74" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>J</a>
				<a <?if($chars["K"]):?>href="#75" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>K</a>
				<a <?if($chars["L"]):?>href="#76" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>L</a>
				<a <?if($chars["M"]):?>href="#77" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>M</a>
				<a <?if($chars["N"]):?>href="#78" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>N</a>
				<a <?if($chars["O"]):?>href="#79" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>O</a>
				<a <?if($chars["P"]):?>href="#80" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>P</a>
				<a <?if($chars["Q"]):?>href="#81" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>Q</a>
				<a <?if($chars["R"]):?>href="#82" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>R</a>
				<a <?if($chars["S"]):?>href="#83" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>S</a>
				<a <?if($chars["T"]):?>href="#84" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>T</a>
				<a <?if($chars["U"]):?>href="#85" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>U</a>
				<a <?if($chars["V"]):?>href="#86" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>V</a>
				<a <?if($chars["W"]):?>href="#87" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>W</a>
				<a <?if($chars["X"]):?>href="#88" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>X</a>
				<a <?if($chars["Y"]):?>href="#89" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>Y</a>
				<a <?if($chars["Z"]):?>href="#90" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>Z</a>
			</span>
			<span class="__all_rus dn">
				<a <?if($chars["А"]):?>href="#192" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>А</a>
				<a <?if($chars["Б"]):?>href="#193" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>Б</a>
				<a <?if($chars["В"]):?>href="#194" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>В</a>
				<a <?if($chars["Г"]):?>href="#195" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>Г</a>
				<a <?if($chars["Д"]):?>href="#196" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>Д</a>
				<a <?if($chars["Е"]):?>href="#197" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>Е</a>
				<a <?if($chars["Ё"]):?>href="#168" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>Ё</a>
				<a <?if($chars["Ж"]):?>href="#198" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>Ж</a>
				<a <?if($chars["З"]):?>href="#199" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>З</a>
				<a <?if($chars["И"]):?>href="#200" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>И</a>
				<a <?if($chars["Й"]):?>href="#201" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>Й</a>
				<a <?if($chars["К"]):?>href="#202" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>К</a>
				<a <?if($chars["Л"]):?>href="#203" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>Л</a>
				<a <?if($chars["М"]):?>href="#204" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>М</a>
				<a <?if($chars["Н"]):?>href="#205" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>Н</a>
				<a <?if($chars["О"]):?>href="#206" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>О</a>
				<a <?if($chars["П"]):?>href="#207" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>П</a>
				<a <?if($chars["Р"]):?>href="#208" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>Р</a>
				<a <?if($chars["С"]):?>href="#209" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>С</a>
				<a <?if($chars["Т"]):?>href="#210" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>Т</a>
				<a <?if($chars["У"]):?>href="#211" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>У</a>
				<a <?if($chars["Ф"]):?>href="#212" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>Ф</a>
				<a <?if($chars["Х"]):?>href="#213" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>Х</a>
				<a <?if($chars["Ц"]):?>href="#214" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>Ц</a>
				<a <?if($chars["Ч"]):?>href="#215" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>Ч</a>
				<a <?if($chars["Ш"]):?>href="#216" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>Ш</a>
				<a <?if($chars["Щ"]):?>href="#217" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>Щ</a>
				<a <?if($chars["Э"]):?>href="#221" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>Э</a>
				<a <?if($chars["Ю"]):?>href="#222" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>Ю</a>
				<a <?if($chars["Я"]):?>href="#223" class="b-form__navigation-link tab_letters"<?else:?>style="color: #d0d0d0"<?endif;?>>Я</a>
			</span>
		</div>
		<div class="clear"></div>
		<div class="brands--filter-form">
			<form class="search-alpha" id="s_form" method="post" action="/manufacturers/">
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
<?else:?>
	<?$ElementID = $APPLICATION->IncludeComponent(
		"bitrix:news.detail",
		"",
		Array(
			"DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
			"DISPLAY_NAME" => $arParams["DISPLAY_NAME"],
			"DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
			"DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"FIELD_CODE" => $arParams["DETAIL_FIELD_CODE"],
			"PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
			"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
			"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
			"META_KEYWORDS" => $arParams["META_KEYWORDS"],
			"META_DESCRIPTION" => $arParams["META_DESCRIPTION"],
			"BROWSER_TITLE" => $arParams["BROWSER_TITLE"],
			"SET_CANONICAL_URL" => $arParams["DETAIL_SET_CANONICAL_URL"],
			"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
			"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
			"SET_TITLE" => $arParams["SET_TITLE"],
			"MESSAGE_404" => $arParams["MESSAGE_404"],
			"SET_STATUS_404" => $arParams["SET_STATUS_404"],
			"SHOW_404" => $arParams["SHOW_404"],
			"FILE_404" => $arParams["FILE_404"],
			"INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
			"ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
			"ACTIVE_DATE_FORMAT" => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
			"GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
			"DISPLAY_TOP_PAGER" => $arParams["DETAIL_DISPLAY_TOP_PAGER"],
			"DISPLAY_BOTTOM_PAGER" => $arParams["DETAIL_DISPLAY_BOTTOM_PAGER"],
			"PAGER_TITLE" => $arParams["DETAIL_PAGER_TITLE"],
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_TEMPLATE" => $arParams["DETAIL_PAGER_TEMPLATE"],
			"PAGER_SHOW_ALL" => $arParams["DETAIL_PAGER_SHOW_ALL"],
			"CHECK_DATES" => $arParams["CHECK_DATES"],
			"ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
			"ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
			"IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
			"USE_SHARE" => $arParams["USE_SHARE"],
			"SHARE_HIDE" => $arParams["SHARE_HIDE"],
			"SHARE_TEMPLATE" => $arParams["SHARE_TEMPLATE"],
			"SHARE_HANDLERS" => $arParams["SHARE_HANDLERS"],
			"SHARE_SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
			"SHARE_SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
			"ADD_ELEMENT_CHAIN" => (isset($arParams["ADD_ELEMENT_CHAIN"]) ? $arParams["ADD_ELEMENT_CHAIN"] : '')
		),
		$component
	);?>
	<p><a href="<?=$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"]?>"><?=GetMessage("T_NEWS_DETAIL_BACK")?></a></p>
	<?if($arParams["USE_RATING"]=="Y" && $ElementID):?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:iblock.vote",
		"",
		Array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"ELEMENT_ID" => $ElementID,
			"MAX_VOTE" => $arParams["MAX_VOTE"],
			"VOTE_NAMES" => $arParams["VOTE_NAMES"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
		),
		$component
	);?>
	<?endif?>
	<?if($arParams["USE_CATEGORIES"]=="Y" && $ElementID):
		global $arCategoryFilter;
		$obCache = new CPHPCache;
		$strCacheID = $componentPath.LANG.$arParams["IBLOCK_ID"].$ElementID.$arParams["CATEGORY_CODE"];
		if(($tzOffset = CTimeZone::GetOffset()) <> 0)
			$strCacheID .= "_".$tzOffset;
		if($arParams["CACHE_TYPE"] == "N" || $arParams["CACHE_TYPE"] == "A" && COption::GetOptionString("main", "component_cache_on", "Y") == "N")
			$CACHE_TIME = 0;
		else
			$CACHE_TIME = $arParams["CACHE_TIME"];
		if($obCache->StartDataCache($CACHE_TIME, $strCacheID, $componentPath))
		{
			$rsProperties = CIBlockElement::GetProperty($arParams["IBLOCK_ID"], $ElementID, "sort", "asc", array("ACTIVE"=>"Y","CODE"=>$arParams["CATEGORY_CODE"]));
			$arCategoryFilter = array();
			while($arProperty = $rsProperties->Fetch())
			{
				if(is_array($arProperty["VALUE"]) && count($arProperty["VALUE"])>0)
				{
					foreach($arProperty["VALUE"] as $value)
						$arCategoryFilter[$value]=true;
				}
				elseif(!is_array($arProperty["VALUE"]) && strlen($arProperty["VALUE"])>0)
					$arCategoryFilter[$arProperty["VALUE"]]=true;
			}
			$obCache->EndDataCache($arCategoryFilter);
		}
		else
		{
			$arCategoryFilter = $obCache->GetVars();
		}
		if(count($arCategoryFilter)>0):
			$arCategoryFilter = array(
				"PROPERTY_".$arParams["CATEGORY_CODE"] => array_keys($arCategoryFilter),
				"!"."ID" => $ElementID,
			);
			?>
			<hr /><h3><?=GetMessage("CATEGORIES")?></h3>
			<?foreach($arParams["CATEGORY_IBLOCK"] as $iblock_id):?>
				<?$APPLICATION->IncludeComponent(
					"bitrix:news.list",
					$arParams["CATEGORY_THEME_".$iblock_id],
					Array(
						"IBLOCK_ID" => $iblock_id,
						"NEWS_COUNT" => $arParams["CATEGORY_ITEMS_COUNT"],
						"SET_TITLE" => "N",
						"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
						"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
						"FILTER_NAME" => "arCategoryFilter",
						"CACHE_FILTER" => "Y",
						"DISPLAY_TOP_PAGER" => "N",
						"DISPLAY_BOTTOM_PAGER" => "N",
					),
					$component
				);?>
			<?endforeach?>
		<?endif?>
	<?endif?>
	<?if($arParams["USE_REVIEW"]=="Y" && IsModuleInstalled("forum") && $ElementID):?>
	<hr />
	<?$APPLICATION->IncludeComponent(
		"bitrix:forum.topic.reviews",
		"",
		Array(
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"MESSAGES_PER_PAGE" => $arParams["MESSAGES_PER_PAGE"],
			"USE_CAPTCHA" => $arParams["USE_CAPTCHA"],
			"PATH_TO_SMILE" => $arParams["PATH_TO_SMILE"],
			"FORUM_ID" => $arParams["FORUM_ID"],
			"URL_TEMPLATES_READ" => $arParams["URL_TEMPLATES_READ"],
			"SHOW_LINK_TO_FORUM" => $arParams["SHOW_LINK_TO_FORUM"],
			"DATE_TIME_FORMAT" => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
			"ELEMENT_ID" => $ElementID,
			"AJAX_POST" => $arParams["REVIEW_AJAX_POST"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"URL_TEMPLATES_DETAIL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
		),
		$component
	);?>
	<?endif?>
	<?$APPLICATION->SetTitle($GLOBALS["NEW_TITLE"]);?>
<?
endif;
?>	