<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/*
 * Module: sebekon.reminder
 */
 
global $USER;
CModule::IncludeModule("sebekon.reminder");

$arResult = array();
$arResult['PRODUCT_ID'] = intval($arParams['PRODUCT_ID']);
$arResult['PRODUCT_CODE'] = trim($arParams['PRODUCT_CODE']);

if (!$arResult['PRODUCT_CODE'] && !$arResult['PRODUCT_ID'] && intval($_REQUEST['ELEMENT_ID'])>0) $arResult['PRODUCT_ID'] = $_REQUEST['ELEMENT_ID'];
if (!$arResult['PRODUCT_CODE'] && !$arResult['PRODUCT_ID'] && intval($_REQUEST['ID'])>0) $arResult['PRODUCT_ID'] = $_REQUEST['ID'];
if (!$arResult['PRODUCT_CODE'] && !$arResult['PRODUCT_ID'] && strlen($_REQUEST['ELEMENT_CODE'])>0) $arResult['PRODUCT_CODE'] = $_REQUEST['ELEMENT_CODE'];
if (!$arResult['PRODUCT_CODE'] && !$arResult['PRODUCT_ID'] && strlen($_REQUEST['CODE'])>0) $arResult['PRODUCT_CODE'] = $_REQUEST['CODE'];

if (!$arResult['PRODUCT_CODE'] && !$arResult['PRODUCT_ID']) {
	global $APPLICATION;
	$url = explode('/',$APPLICATION->GetCurPage());
	$code = $url[count($url)-1];
	if (!$code || substr($code,0,1)=='?') $code = $url[count($url)-2];
	if (is_numeric($code)) $arResult['PRODUCT_ID'] = $arParams['PRODUCT_ID'] = $code;
	else $arResult['PRODUCT_CODE'] = $arParams['PRODUCT_CODE'] = $code;
}

if (!$arResult['PRODUCT_ID'] && $arResult['PRODUCT_CODE']) {
	CModule::IncludeModule("iblock");
	$arParams["PRODUCT_ID"] = CIBlockFindTools::GetElementID(
		$arResult["PRODUCT_ID"],
		$arResult["PRODUCT_CODE"],
		false,
		false,
		array('ACTIVE'=>'Y')
	);
	$arResult['PRODUCT_ID'] = intval($arParams['PRODUCT_ID']);
}

if (!$arResult['PRODUCT_ID']) {
		if ($USER->IsAdmin()) $this->IncludeComponentTemplate();
} elseif (CSebekonReminder::checkUnRules($arResult['PRODUCT_ID'])) {
	$arResult['SEND_BY_PHONE'] = ($arParams['SEND_BY_PHONE']=='Y'?'Y':'N');
	$arResult['USE_CAPTCHA'] = ($arParams['USE_CAPTCHA']=='Y'?'Y':'N');
	$arResult['ANONYMOUS'] = ($arParams['ANONYMOUS']=='Y'?'Y':'N');
	$arResult['SITE_ID'] = SITE_ID;

	$arResult['SEBEKON_RM'] = randString(10);
	$_SESSION['SEBEKON_RM'][$arResult['SEBEKON_RM']] = $arResult;
	
	if ($arResult['PRODUCT_ID'] && CModule::IncludeModule("sebekon.reminder") && ($arParams["ANONYMOUS"]=='Y' || $USER->IsAuthorized())) {
		$this->IncludeComponentTemplate();
	}
}

?>