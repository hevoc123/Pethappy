<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$count=0;
foreach($arResult["CATEGORIES"] as $category_id => $arCategory) {
    foreach($arCategory["ITEMS"] as $i => $arItem)
    {
			$count++;
			if($category_id === "all") $arResult["ALL"]=$arItem["URL"];
    }
}
	
$arResult["COUNT"]=$count;
	
$PREVIEW_WIDTH = intval($arParams["PREVIEW_WIDTH"]);
if ($PREVIEW_WIDTH <= 0)
	$PREVIEW_WIDTH = 75;

$PREVIEW_HEIGHT = intval($arParams["PREVIEW_HEIGHT"]);
if ($PREVIEW_HEIGHT <= 0)
	$PREVIEW_HEIGHT = 75;

$arParams["PRICE_VAT_INCLUDE"] = $arParams["PRICE_VAT_INCLUDE"] !== "N";

$arCatalogs = array();
if (CModule::IncludeModule("catalog"))
{
	$rsCatalog = CCatalog::GetList(array(
		"sort" => "asc",
	));
	while ($ar = $rsCatalog->Fetch())
	{
		if ($ar["PRODUCT_IBLOCK_ID"])
			$arCatalogs[$ar["PRODUCT_IBLOCK_ID"]] = 1;
		else
			$arCatalogs[$ar["IBLOCK_ID"]] = 1;
	}
}

$arResult["ELEMENTS"] = array();
$arResult["SEARCH"] = array();
foreach($arResult["CATEGORIES"] as $category_id => $arCategory)
{
	foreach($arCategory["ITEMS"] as $i => $arItem)
	{
		//if($i > 4) break;
		if(isset($arItem["ITEM_ID"]))
		{
			$arResult["SEARCH"][] = &$arResult["CATEGORIES"][$category_id]["ITEMS"][$i];
			if (
				$arItem["MODULE_ID"] == "iblock"
				&& array_key_exists($arItem["PARAM2"], $arCatalogs)
				&& substr($arItem["ITEM_ID"], 0, 1) !== "S"
			)
			{
				$arResult["ELEMENTS"][$arItem["ITEM_ID"]] = $arItem["ITEM_ID"];
			}
		}
	}
}

if (!empty($arResult["ELEMENTS"]) && CModule::IncludeModule("iblock"))
{
	$arConvertParams = array();
	if ('Y' == $arParams['CONVERT_CURRENCY'])
	{
		if (!CModule::IncludeModule('currency'))
		{
			$arParams['CONVERT_CURRENCY'] = 'N';
			$arParams['CURRENCY_ID'] = '';
		}
		else
		{
			$arCurrencyInfo = CCurrency::GetByID($arParams['CURRENCY_ID']);
			if (!(is_array($arCurrencyInfo) && !empty($arCurrencyInfo)))
			{
				$arParams['CONVERT_CURRENCY'] = 'N';
				$arParams['CURRENCY_ID'] = '';
			}
			else
			{
				$arParams['CURRENCY_ID'] = $arCurrencyInfo['CURRENCY'];
				$arConvertParams['CURRENCY_ID'] = $arCurrencyInfo['CURRENCY'];
			}
		}
	}

	$obParser = new CTextParser;

	$arSelect = array(
		"ID",
		"IBLOCK_ID",
		"NAME",
		"PREVIEW_TEXT",
		"PREVIEW_PICTURE",
		"DETAIL_PICTURE",
		"DETAIL_PAGE_URL",
		"CATALOG_GROUP_2",
		"PROPERTY_FACTOR"
	);
	$arFilter = array(
		"IBLOCK_LID" => SITE_ID,
		"IBLOCK_ACTIVE" => "Y",
		"ACTIVE_DATE" => "Y",
		"ACTIVE" => "Y",
		"CHECK_PERMISSIONS" => "Y",
		"MIN_PERMISSION" => "R",
	);
	
	$arFilter["=ID"] = $arResult["ELEMENTS"];
	$rsElements = CIBlockElement::GetList(array("CATALOG_QUANTITY"=>"DESC"), $arFilter, false, false, $arSelect);
	while($arElement = $rsElements->GetNext())
	{
		//$arElement["PRICES"] = CIBlockPriceTools::GetItemPrices($arElement["IBLOCK_ID"], $arResult["PRICES"], $arElement, $arParams['PRICE_VAT_INCLUDE'], $arConvertParams);
		//var_dump($arElement["PRICES"]);
		if($arParams["PREVIEW_TRUNCATE_LEN"] > 0)
			$arElement["PREVIEW_TEXT"] = $obParser->html_cut($arElement["PREVIEW_TEXT"], $arParams["PREVIEW_TRUNCATE_LEN"]);

		$arResult["ELEMENTS"][$arElement["ID"]] = $arElement;
	}
}
foreach($arResult["SEARCH"] as $i=>$arItem)
{
	//switch($arItem["MODULE_ID"])
	//{
	//	case "iblock":
			if(array_key_exists($arItem["ITEM_ID"], $arResult["ELEMENTS"]))
			{
				$arElement = &$arResult["ELEMENTS"][$arItem["ITEM_ID"]];

				//var_dump($arItem["ITEM_ID"]);
				
				if ($arParams["SHOW_PREVIEW"] == "Y")
				{
					if ($arElement["PREVIEW_PICTURE"] > 0)
						$arElement["PICTURE"] = CFile::ResizeImageGet($arElement["PREVIEW_PICTURE"], array("width"=>$PREVIEW_WIDTH, "height"=>$PREVIEW_HEIGHT), BX_RESIZE_IMAGE_PROPORTIONAL, true);
					elseif ($arElement["DETAIL_PICTURE"] > 0)
						$arElement["PICTURE"] = CFile::ResizeImageGet($arElement["DETAIL_PICTURE"], array("width"=>$PREVIEW_WIDTH, "height"=>$PREVIEW_HEIGHT), BX_RESIZE_IMAGE_PROPORTIONAL, true);
				}
			}
	//		break;
	//}

	$arResult["SEARCH"][$i]["ICON"] = true;
}

foreach($arResult["ELEMENTS"] as $i => &$arItem) {
	if(CCatalogSKU::IsExistOffers($arItem["ID"])) {
		$res = CIBlockElement::GetList(Array("CATALOG_QUANTITY"=>"DESC"), Array("IBLOCK_ID"=>4, "PROPERTY_CML2_LINK"=>$arItem["ID"]), false, Array("nTopCount"=>1), Array("ID", "NAME", "CATALOG_GROUP_2"));
		if($ar_res = $res->GetNext())
		{
			$arItem["PRICE"]=$ar_res["CATALOG_PRICE_2"];
			$arItem["QUANTITY"]+=$ar_res["CATALOG_QUANTITY"];
		}
	}
	else 
	{
		$res = CIBlockElement::GetList(Array("CATALOG_QUANTITY"=>"DESC"), Array("IBLOCK_ID"=>2, "ID"=>$arItem["ID"]), false, Array("nTopCount"=>1), Array("ID", "NAME", "CATALOG_GROUP_2"));
		while($ar_res = $res->GetNext())
		{
			//var_dump($ar_res);
			$arItem["PRICE"]=$ar_res["CATALOG_PRICE_2"];
			$arItem["QUANTITY"]+=$ar_res["CATALOG_QUANTITY"];
		}
	}
}

function compare ($v1, $v2) {
	/* Сравниваем значение по ключу date_reg */
	if ($v1["QUANTITY"] == $v2["QUANTITY"]) return 0;
	return ($v1["QUANTITY"] < $v2["QUANTITY"])? 1: -1;
}

uasort($arResult["ELEMENTS"], "compare");

?>