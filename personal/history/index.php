<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("TITLE", "Мои заказы");
$APPLICATION->SetTitle("Мои заказы");

require($_SERVER["DOCUMENT_ROOT"]."/include/profile_nav.php");

?><?$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.order", 
	"new", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CUSTOM_SELECT_PROPS" => array(
		),
		"HISTORIC_STATUSES" => array(
			0 => "D",
		),
		"NAV_TEMPLATE" => "",
		"ORDERS_PER_PAGE" => "200",
		"PATH_TO_BASKET" => "/personal/cart/",
		"PATH_TO_PAYMENT" => "/personal/order/payment/",
		"PROP_1" => array(
		),
		"SAVE_IN_SESSION" => "Y",
		"SEF_MODE" => "Y",
		"SET_TITLE" => "Y",
		"STATUS_COLOR_B" => "gray",
		"STATUS_COLOR_C" => "gray",
		"STATUS_COLOR_D" => "gray",
		"STATUS_COLOR_E" => "gray",
		"STATUS_COLOR_F" => "gray",
		"STATUS_COLOR_G" => "gray",
		"STATUS_COLOR_N" => "green",
		"STATUS_COLOR_PSEUDO_CANCELLED" => "red",
		"COMPONENT_TEMPLATE" => "new",
		"SEF_FOLDER" => "/personal/history/",
		"SEF_URL_TEMPLATES" => array(
			"list" => "",
			"detail" => "detail/#ID#",
			"cancel" => "cancel/#ID#",
		)
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>