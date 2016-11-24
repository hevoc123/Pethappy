<?    
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");
CModule::IncludeModule("iblock");
use Bitrix\Main\Mail\Event;

if($_REQUEST["phone_call"])
{
	$el = new CIBlockElement;
	
	$arLoadProductArray = Array(
	  "MODIFIED_BY"    => 1,
	  "IBLOCK_ID"      => 12,
	  "NAME" => $_REQUEST["phone_call"]." - ".utf8win1251($_REQUEST["name_call"]),
	);
	
	$PRODUCT_ID = $el->Add($arLoadProductArray);
	
	Event::send(array(
		"EVENT_NAME" => "CALLBACK_FORM",
		"LID" => "s1",
		"C_FIELDS" => array(
			"PHONE" => $_REQUEST["phone_call"],
			"NAME" => utf8win1251($_REQUEST["name_call"]),
		),
	)); 

}
