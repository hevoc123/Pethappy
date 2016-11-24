<?
require_once( $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php' );
CModule::IncludeModule("catalog");



$APPLICATION->IncludeComponent("sebekon:reminder.form", "custom", Array(
		"SUCCESS_MESSAGE" => "",
		"PRODUCT_ID" => $_GET["ID"],
		"PRODUCT_CODE" => "",
		"SEND_BY_PHONE" => "Y",
		"USE_CAPTCHA" => "N",
		"ANONYMOUS" => "Y",
	),
	false
);
?>