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
$arResult['SITE_ID'] = SITE_ID;
if ($arParams['SITE_ID'] && $arResult['SITE_ID']!=$arParams['SITE_ID']) {
	$arResult['SITE_ID'] = $arParams['SITE_ID'];
}

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

if (CModule::IncludeModule("sebekon.reminder") && ($arParams["ANONYMOUS"]=='Y' || $USER->IsAuthorized())) {
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
		
	} elseif (CSebekonReminder::checkUnRules($arResult['PRODUCT_ID'], $arResult['SITE_ID'])) {
			
		if (trim($arParams['SUCCESS_MESSAGE'])=='') $arParams['SUCCESS_MESSAGE'] = GetMessage('SEBEKON_RM_SUCCESS');
		$arResult['ERRORS'] = array();
		$arResult['SUCCESS'] = false;
		
		if ($_REQUEST['action']!='' ) {
			
			$arResult['PHONE'] = $_REQUEST['PHONE'];
			$arResult['EMAIL'] = $_REQUEST['EMAIL'];
            $arResult['FIO'] = utf8win1251($_REQUEST['FIO']);
            $arResult['QUANTITY'] = $_REQUEST['QUANTITY'];
			$arResult['NAME'] = '';
			if (!CSebekonReminder::is_phone($arResult['PHONE'])) $arResult['ERRORS'][] = GetMessage('SEBEKON_RM_WRONG_PHONE');
			if (!CSebekonReminder::is_email($arResult['EMAIL'])) $arResult['ERRORS'][] = GetMessage('SEBEKON_RM_WRONG_MAIL');
			$arResult['NAME'] = GetMessage('SEBEKON_RM_BY_MAIL');


			// check captcha
			if ($arParams["USE_CAPTCHA"] == "Y")
			{
				if (!$APPLICATION->CaptchaCheckCode($_REQUEST["captcha_word"], $_REQUEST["captcha_sid"]))
				{
					$arResult["ERRORS"][] = GetMessage("SEBEKON_RM_FORM_WRONG_CAPTCHA");
				}
			}
			
			if (count($arResult['ERRORS'])==0) {
				$res = CSebekonReminder::Add($arResult);			
				if ($res!==true) {
					$arResult['ERRORS'][] = $res;
				} else {
					$arResult['SUCCESS'] = true;
				}			
			}
		}
		
		// prepare captcha
		if ($arParams["USE_CAPTCHA"] == "Y" && $arParams["ID"] <= 0)
		{
			$arResult["CAPTCHA_CODE"] = htmlspecialchars($APPLICATION->CaptchaGetCode());
		}
		$this->IncludeComponentTemplate();
	}
}


?>