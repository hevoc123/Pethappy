<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;
if(!CModule::IncludeModule("sebekon.reminder"))
	return;


$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
		'PRODUCT_ID' => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("SEBEKON_RM_PRODUCT_PARAM"),
			"TYPE" => "S",
			"MULTIPLE" => "N"
		),
		'PRODUCT_CODE' => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("SEBEKON_RM_PRODUCT_CODE_PARAM"),
			"TYPE" => "S",
			"MULTIPLE" => "N"
		),
		'SEND_BY_PHONE' => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage('SEBEKON_RM_SEND_BY_PHONE_PARAM'),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y"
		),
		"USE_CAPTCHA" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("SEBEKON_RM_USE_CAPTCHA"),
			"TYPE" => "CHECKBOX",
		),
		"ANONYMOUS" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("SEBEKON_RM_ANONYMOUS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y"
		)
	)
);
?>
