<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("TITLE", "Отложенные");
$APPLICATION->SetTitle("Отложенные");
?>
<?
if($_REQUEST["clear"]=="Y")
{
	if(!$USER->IsAuthorized()) {
		$APPLICATION->set_cookie("favorites",serialize(Array()));
	}
	else {
		$idUser = $USER->GetID();
		$USER->Update($idUser, Array("UF_FAVORITES"=>serialize(Array())));
	}
}

if(!$USER->IsAuthorized()) {
	$arElements = unserialize($APPLICATION->get_cookie('favorites'));
}
else {
	$idUser = $USER->GetID();
	$rsUser = CUser::GetByID($idUser);
	$arUser = $rsUser->Fetch(); 
	$arElements = unserialize($arUser['UF_FAVORITES']);
}

$GLOBALS["arrFilter"]["ID"]=$arElements;

require($_SERVER["DOCUMENT_ROOT"]."/include/profile_nav.php");

if($arElements):
?>
<?
$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"main_new", 
	array(
		"TEMPLATE_THEME" => "blue",
		"PRODUCT_SUBSCRIPTION" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "Y",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"SHOW_CLOSE_POPUP" => "N",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"AJAX_MODE" => "N",
		"IBLOCK_TYPE" => "1c_catalog",
		"IBLOCK_ID" => "2",
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"ELEMENT_SORT_FIELD" => "NAME",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_FIELD2" => "RAND",
		"ELEMENT_SORT_ORDER2" => "desc",
		"FILTER_NAME" => "arrFilter",
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"BROWSER_TITLE" => "-",
		"SET_META_KEYWORDS" => "N",
		"META_KEYWORDS" => "-",
		"SET_META_DESCRIPTION" => "Y",
		"META_DESCRIPTION" => "-",
		"ADD_SECTIONS_CHAIN" => "N",
		"DISPLAY_COMPARE" => "N",
		"SET_STATUS_404" => "N",
		"PAGE_ELEMENT_COUNT" => "16",
		"LINE_ELEMENT_COUNT" => "4",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "ves",
			2 => "",
		),
		"OFFERS_LIMIT" => "5",
		"PRICE_CODE" => array(
			0 => "Цена продажи",
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "N",
		"BASKET_URL" => "/personal/cart/",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"USE_PRODUCT_QUANTITY" => "N",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => array(
		),
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_NOTES" => "",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"HIDE_NOT_AVAILABLE" => "N",
		"CONVERT_CURRENCY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"COMPONENT_TEMPLATE" => "main_new",
		"OFFERS_FIELD_CODE" => array(
			0 => "NAME",
			1 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "CML2_ARTICLE",
			1 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "desc",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"ADD_PICT_PROP" => "MORE_PHOTO",
		"LABEL_PROP" => "-",
		"OFFER_ADD_PICT_PROP" => "-",
		"OFFER_TREE_PROPS" => array(
			0 => "CML2_MANUFACTURER",
		),
		"MESS_BTN_COMPARE" => "Сравнить",
		"OFFERS_CART_PROPERTIES" => array(
		),
		"BACKGROUND_IMAGE" => "-",
		"SEF_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"SET_LAST_MODIFIED" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"ADDCLASS"=>"_favorite_list"
	),
	false
);?>
<?
else:
?>

<table width="100%">
		<tbody>
			<tr>
				<td style="text-align: center">
					<div class="empty_cart">
						<h1 class="h1-title">Ваш список отложенного пуст!</h1>
						<p class="p-text">Нажмите на сердечко понравившихся товаров, чтобы их отложить</p>
					</div>
				</td>
			</tr>
			<tr>
				<td style="text-align: center">
					<img style="max-width: 316px; max-height: 480px;" src="/images/empty-food.jpg">
				</td>
			</tr>
		</tbody>
	</table>

<?
	endif;
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");