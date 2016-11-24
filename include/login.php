<?
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");
CModule::IncludeModule("iblock");
use Bitrix\Main\Mail\Event; 

header('Content-Type: application/json');

$result=Array();

if($_POST["email_address"])
{
	if(!check_email( utf8win1251($_POST["email_address"])))
		$result["fields"]["email_address"]=iconv('cp1251', 'utf-8', "Не правильный формат E-mail");
	else
	{
		$rsUser = CUser::GetByLogin(utf8win1251($_POST["email_address"]));
		$arUser=$rsUser->Fetch();
		if(!$arUser)
		{
			$result["fields"]["email_address"]=iconv('cp1251', 'utf-8', "Пользователь с таким E-mail не найден");	
		}
	}
}
else
	$result["fields"]["email_address"]=iconv('cp1251', 'utf-8', "E-mail: минимум 6 символов");

if($_POST["password"] && $_POST["email_address"])
{
	$arAuthResult = $USER->Login(utf8win1251($_POST["email_address"]), utf8win1251($_POST["password"]), "Y", "Y");
	//var_dump($arAuthResult);	
	
	if($arAuthResult["TYPE"]=="ERROR")
	{
		$result["fields"]["password"]=iconv('cp1251', 'utf-8', $arAuthResult["MESSAGE"]);
	}
	else
		$result["status"]=1;
}

//var_dump($result);
if($result)
{
	
	if(!$result["status"]) $result["status"]=0; 
	echo json_encode($result);
}

