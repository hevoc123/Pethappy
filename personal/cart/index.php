<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("ROBOTS", "noindex, follow");
$APPLICATION->SetPageProperty("TITLE", "�������");
$APPLICATION->SetPageProperty("description", "������� �� Pethappy.ru");
$APPLICATION->SetTitle("�������");
?><?$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket", 
	"new", 
	array(
		"ACTION_VARIABLE" => "basketAction",
		"AUTO_CALCULATION" => "Y",
		"COLUMNS_LIST" => array(
			0 => "NAME",
			1 => "DISCOUNT",
			2 => "WEIGHT",
			3 => "DELETE",
			4 => "DELAY",
			5 => "TYPE",
			6 => "PRICE",
			7 => "QUANTITY",
		),
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"GIFTS_BLOCK_TITLE" => "�������� ���� �� ��������",
		"GIFTS_CONVERT_CURRENCY" => "N",
		"GIFTS_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_HIDE_NOT_AVAILABLE" => "N",
		"GIFTS_MESS_BTN_BUY" => "�������",
		"GIFTS_MESS_BTN_DETAIL" => "���������",
		"GIFTS_PAGE_ELEMENT_COUNT" => "4",
		"GIFTS_PLACE" => "BOTTOM",
		"GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",
		"GIFTS_PRODUCT_QUANTITY_VARIABLE" => "",
		"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
		"GIFTS_SHOW_IMAGE" => "Y",
		"GIFTS_SHOW_NAME" => "Y",
		"GIFTS_SHOW_OLD_PRICE" => "N",
		"GIFTS_TEXT_LABEL_GIFT" => "�������",
		"HIDE_COUPON" => "N",
		"OFFERS_PROPS" => array(
		),
		"PATH_TO_ORDER" => "/personal/order/",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"QUANTITY_FLOAT" => "N",
		"SET_TITLE" => "Y",
		"TEMPLATE_THEME" => "blue",
		"USE_GIFTS" => "N",
		"USE_PREPAYMENT" => "N",
		"COMPONENT_TEMPLATE" => "new"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>