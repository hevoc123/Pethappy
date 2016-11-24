<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "������� ������� ��� �������� �������� ��������-�������� Pethappy.ru");
$APPLICATION->SetPageProperty("TITLE", "������� ������� ��� �������� ��������");
$APPLICATION->SetTitle("������� �������");

if( isset($_REQUEST['sort'] ) )
{
    $_SESSION['sort'] = $_REQUEST['sort'];
}


if($_SESSION['sort']=="pop_asc") 
{
	$sort_name="SHOW_COUNTER";
	$sort_type="asc";
}
elseif($_SESSION['sort']=="pop_desc")
{
	$sort_name="SHOW_COUNTER";
	$sort_type="desc";
}
elseif($_SESSION['sort']=="price_asc")
{
	$sort_name="CATALOG_PRICE_2";
	$sort_type="asc";
}
elseif($_SESSION['sort']=="price_desc")
{	
	$sort_name="CATALOG_PRICE_2";
	$sort_type="desc";
	
}
else
{
	$_SESSION['sort']="price_asc";
	$sort_name="SHOW_COUNTER";
	$sort_type="asc";
}

//var_dump($_GET);

?><?$APPLICATION->IncludeComponent(
	"bitrix:catalog", 
	"new", 
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_ELEMENT_CHAIN" => "N",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BASKET_URL" => "/personal/cart/",
		"BIG_DATA_RCM_TYPE" => "bestsell",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"COMMON_ADD_TO_BASKET_ACTION" => "",
		"COMMON_SHOW_CLOSE_POPUP" => "N",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_ADD_DETAIL_TO_SLIDER" => "N",
		"DETAIL_ADD_TO_BASKET_ACTION" => array(
			0 => "BUY",
		),
		"DETAIL_BACKGROUND_IMAGE" => "-",
		"DETAIL_BRAND_USE" => "N",
		"DETAIL_BROWSER_TITLE" => "TITLE",
		"DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",
		"DETAIL_DETAIL_PICTURE_MODE" => "IMG",
		"DETAIL_DISPLAY_NAME" => "Y",
		"DETAIL_DISPLAY_PREVIEW_TEXT_MODE" => "E",
		"DETAIL_META_DESCRIPTION" => "DESCRIPTION",
		"DETAIL_META_KEYWORDS" => "KEYWORDS",
		"DETAIL_OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"DETAIL_OFFERS_PROPERTY_CODE" => array(
			0 => "IMYIE_CML2ATTR_FASOVKA",
			1 => "CML2_ARTICLE",
			2 => "CML2_BASE_UNIT",
			3 => "MORE_PHOTO",
			4 => "CML2_MANUFACTURER",
			5 => "CML2_TRAITS",
			6 => "CML2_TAXES",
			7 => "FILES",
			8 => "CML2_ATTRIBUTES",
			9 => "CML2_BAR_CODE",
			10 => "",
		),
		"DETAIL_PROPERTY_CODE" => array(
			0 => "DESCRIPTION",
			1 => "KEYWORDS",
			2 => "TITLE",
			3 => "CML2_ARTICLE",
			4 => "CML2_BASE_UNIT",
			5 => "NAPOLNITEL",
			6 => "FLAVOUR",
			7 => "AGE",
			8 => "PORODA",
			9 => "CML2_MANUFACTURER",
			10 => "CML2_TRAITS",
			11 => "SPECIAL",
			12 => "CML2_TAXES",
			13 => "CML2_ATTRIBUTES",
			14 => "CML2_BAR_CODE",
			15 => "",
		),
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DETAIL_SET_VIEWED_IN_COMPONENT" => "N",
		"DETAIL_SHOW_MAX_QUANTITY" => "N",
		"DETAIL_USE_COMMENTS" => "N",
		"DETAIL_USE_VOTE_RATING" => "N",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "CATALOG_AVAILABLE",
		"ELEMENT_SORT_FIELD2" => $sort_name,
		"ELEMENT_SORT_ORDER" => "DESC",
		"ELEMENT_SORT_ORDER2" => $sort_type,
		"FILTER_VIEW_MODE" => "VERTICAL",
		"GIFTS_DETAIL_BLOCK_TITLE" => "�������� ���� �� ��������",
		"GIFTS_DETAIL_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_DETAIL_PAGE_ELEMENT_COUNT" => "3",
		"GIFTS_DETAIL_TEXT_LABEL_GIFT" => "�������",
		"GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE" => "�������� ���� �� �������, ����� �������� �������",
		"GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT" => "3",
		"GIFTS_MESS_BTN_BUY" => "�������",
		"GIFTS_SECTION_LIST_BLOCK_TITLE" => "������� � ������� ����� �������",
		"GIFTS_SECTION_LIST_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_SECTION_LIST_PAGE_ELEMENT_COUNT" => "3",
		"GIFTS_SECTION_LIST_TEXT_LABEL_GIFT" => "�������",
		"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
		"GIFTS_SHOW_IMAGE" => "Y",
		"GIFTS_SHOW_NAME" => "Y",
		"GIFTS_SHOW_OLD_PRICE" => "Y",
		"HIDE_NOT_AVAILABLE" => "L",
		"IBLOCK_ID" => "2",
		"IBLOCK_TYPE" => "1c_catalog",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LABEL_PROP" => "-",
		"LINE_ELEMENT_COUNT" => "3",
		"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
		"LINK_IBLOCK_ID" => "",
		"LINK_IBLOCK_TYPE" => "",
		"LINK_PROPERTY_SID" => "",
		"LIST_BROWSER_TITLE" => "UF_TITLE",
		"LIST_META_DESCRIPTION" => "UF_DESCRIPTION",
		"LIST_META_KEYWORDS" => "UF_KEYWORDS",
		"LIST_OFFERS_FIELD_CODE" => array(
			0 => "NAME",
			1 => "",
		),
		"LIST_OFFERS_LIMIT" => "0",
		"LIST_OFFERS_PROPERTY_CODE" => array(
			0 => "CML2_ARTICLE",
			1 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "DESCRIPTION",
			1 => "KEYWORDS",
			2 => "TITLE",
			3 => "CML2_ARTICLE",
			4 => "CML2_BASE_UNIT",
			5 => "NAPOLNITEL",
			6 => "FLAVOUR",
			7 => "AGE",
			8 => "PORODA",
			9 => "CML2_MANUFACTURER",
			10 => "CML2_TRAITS",
			11 => "SPECIAL",
			12 => "CML2_TAXES",
			13 => "CML2_ATTRIBUTES",
			14 => "CML2_BAR_CODE",
			15 => "",
		),
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "� �������",
		"MESS_BTN_BUY" => "������",
		"MESS_BTN_COMPARE" => "���������",
		"MESS_BTN_DETAIL" => "���������",
		"MESS_NOT_AVAILABLE" => "��� � �������",
		"OFFERS_CART_PROPERTIES" => array(
		),
		"OFFERS_SORT_FIELD" => "CATALOG_PRICE_2",
		"OFFERS_SORT_FIELD2" => "CATALOG_PRICE_2",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "asc",
		"OFFER_ADD_PICT_PROP" => "-",
		"OFFER_TREE_PROPS" => array(
		),
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "new",
		"PAGER_TITLE" => "������",
		"PAGE_ELEMENT_COUNT" => "32",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
			0 => "���� �������",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"PRODUCT_DISPLAY_MODE" => "N",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "",
		"SECTIONS_SHOW_PARENT_NAME" => "Y",
		"SECTIONS_VIEW_MODE" => "LIST",
		"SECTION_ADD_TO_BASKET_ACTION" => "ADD",
		"SECTION_BACKGROUND_IMAGE" => "-",
		"SECTION_COUNT_ELEMENTS" => "Y",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_TOP_DEPTH" => "2",
		"SEF_FOLDER" => "/categories/",
		"SEF_MODE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SHOW_DEACTIVATED" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_TOP_ELEMENTS" => "Y",
		"SIDEBAR_DETAIL_SHOW" => "Y",
		"SIDEBAR_PATH" => "",
		"SIDEBAR_SECTION_SHOW" => "Y",
		"TEMPLATE_THEME" => "blue",
		"TOP_ADD_TO_BASKET_ACTION" => "ADD",
		"TOP_ELEMENT_COUNT" => "9",
		"TOP_ELEMENT_SORT_FIELD" => "sort",
		"TOP_ELEMENT_SORT_FIELD2" => "id",
		"TOP_ELEMENT_SORT_ORDER" => "asc",
		"TOP_ELEMENT_SORT_ORDER2" => "desc",
		"TOP_LINE_ELEMENT_COUNT" => "3",
		"TOP_OFFERS_FIELD_CODE" => array(
			0 => "NAME",
			1 => "",
		),
		"TOP_OFFERS_LIMIT" => "5",
		"TOP_OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"TOP_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"TOP_VIEW_MODE" => "SECTION",
		"USE_ALSO_BUY" => "N",
		"USE_BIG_DATA" => "Y",
		"USE_COMMON_SETTINGS_BASKET_POPUP" => "N",
		"USE_COMPARE" => "N",
		"USE_ELEMENT_COUNTER" => "Y",
		"USE_FILTER" => "Y",
		"USE_GIFTS_DETAIL" => "Y",
		"USE_GIFTS_MAIN_PR_SECTION_LIST" => "Y",
		"USE_GIFTS_SECTION" => "Y",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"USE_REVIEW" => "N",
		"USE_SALE_BESTSELLERS" => "Y",
		"USE_STORE" => "N",
		"COMPONENT_TEMPLATE" => "new",
		"FILTER_NAME" => "arrFilter",
		"FILTER_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_PRICE_CODE" => array(
			0 => "���� �������",
		),
		"FILTER_OFFERS_FIELD_CODE" => array(
			0 => "NAME",
			1 => "",
		),
		"FILTER_OFFERS_PROPERTY_CODE" => array(
			0 => "IMYIE_CML2ATTR_FASOVKA",
			1 => "",
		),
		"PAGER_BASE_LINK" => "",
		"PAGER_PARAMS_NAME" => "arrPager",
		"SEF_URL_TEMPLATES" => array(
			"sections" => "",
			"section" => "#SECTION_CODE#",
			"element" => "/products/#ELEMENT_CODE#",
			"compare" => "compare.php?action=#ACTION_CODE#",
			"smart_filter" => "#SECTION_CODE#/filter/#SMART_FILTER_PATH#/apply/",
		),
		"VARIABLE_ALIASES" => array(
			"compare" => array(
				"ACTION_CODE" => "action",
			),
		)
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>