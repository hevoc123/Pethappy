<?
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");
CModule::IncludeModule("iblock");
use Bitrix\Main\Mail\Event;

$result=Array();

if(strlen($_POST["popup_name"]) < 2)
{
	$result["popup_name"]=iconv('cp1251', 'utf-8', "ФИО: Минимум 2 символа");
}

if(!check_email($_POST["popup_mail"]))
{
	$result["popup_mail"]=iconv('cp1251', 'utf-8', "E-mail: минимум 6 символов");
}

if(!$_POST["popup_phone"])
{
	$result["popup_phone"]=iconv('cp1251', 'utf-8', "Введите номер телефона полностью");
}

if(!$_POST["popup_password"])
{
	$result["popup_password"]=iconv('cp1251', 'utf-8', "Минимум 5 латинских символов");
}
//var_dump($result);
if($result)
	echo json_encode($result);
else 
{
	$new = new CUser;
	$arFields = Array(
	  "NAME"              => utf8win1251($_POST["popup_name"]),
	  "EMAIL"             => utf8win1251($_POST["popup_mail"]),
	  "LOGIN"             => utf8win1251($_POST["popup_mail"]),
	  "ACTIVE"            => "Y",
	  "GROUP_ID"          => array(3,4),
	  "PASSWORD"          => utf8win1251($_POST["popup_password"]),
	  "CONFIRM_PASSWORD"  => utf8win1251($_POST["popup_password"]),
	  "PERSONAL_PHONE " => $_POST["popup_phone"]
	);

	$NID = $new->Add($arFields);
	if (intval($NID) > 0)
	{
		$USER->Authorize($NID);
	}
}
