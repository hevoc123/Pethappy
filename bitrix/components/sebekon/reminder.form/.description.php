<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("sebekon.reminder"))
	return;

$arComponentDescription = array(
	"NAME" => GetMessage("SEBEKON_RM_REMIND_ME_FORM_COMPONENT"),
	"DESCRIPTION" => GetMessage("sebekon_RM_MODULE_DESCRIPTION"),
	"ICON" => "/images/reminder.png",
	"PATH" => array(
		"ID" => "sebekon",
		"NAME" => GetMessage("sebekon_RM_PARTNER_NAME")
	)
);

?>