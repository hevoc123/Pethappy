<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); 

global $APPLICATION;

$aMenuLinksExt = $APPLICATION->IncludeComponent(
	"bitrix:menu.sections", 
	"", 
	array(
		"IS_SEF" => "Y",
		"SEF_BASE_URL" => "/",
		"SECTION_PAGE_URL" => "categories/#SECTION_CODE#",
		"DETAIL_PAGE_URL" => "/products/#ELEMENT_CODE#",
		"IBLOCK_TYPE" => "1c_catalog",
		"IBLOCK_ID" => "2",
		"DEPTH_LEVEL" => "2",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000000"
	),
	false
);

$aMenuLinks = array_merge($aMenuLinksExt, $aMenuLinks); 
?> 