<?
##############################################
# Bitrix: SiteManager                        #
# Copyright (c) 2002-2006 Bitrix             #
# http://www.bitrixsoft.com                  #
# mailto:admin@bitrixsoft.com                #
##############################################
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/include.php");

$saleModulePermissions = $APPLICATION->GetGroupRight("sale");
if ($saleModulePermissions == "D")
	$APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));

ClearVars("l_");

$LOCAL_SITE_LIST_CACHE = array();
$LOCAL_PERSON_TYPE_CACHE = array();
$LOCAL_PAYED_USER_CACHE = array();
$LOCAL_PAY_SYSTEM_CACHE = array();
$LOCAL_DELIVERY_CACHE = array();
$LOCAL_STATUS_CACHE = array();

IncludeModuleLangFile(__FILE__);

$arAccessibleSites = array();
$dbAccessibleSites = CSaleGroupAccessToSite::GetList(
		array(),
		array("GROUP_ID" => $GLOBALS["USER"]->GetUserGroupArray()),
		false,
		false,
		array("SITE_ID")
	);
	
while ($arAccessibleSite = $dbAccessibleSites->Fetch())
{
	if (!in_array($arAccessibleSite["SITE_ID"], $arAccessibleSites))
		$arAccessibleSites[] = $arAccessibleSite["SITE_ID"];
}

$bExport = false;
if($_REQUEST["mode"] == "excel")
	$bExport = true;

error_reporting(E_ALL);
ini_set('display_errors', FALSE);
ini_set('mbstring.func_overload', 0);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('Europe/London');
/** Include PHPExcel_IOFactory */
require_once($_SERVER["DOCUMENT_ROOT"]."/include/Classes/PHPExcel/IOFactory.php");

if (!file_exists($_SERVER["DOCUMENT_ROOT"]."/include/orders_to_excel_new.xls")) {
	exit("Please run 05featuredemo.php first." . EOL);
}
	//die("123");
$objPHPExcel = PHPExcel_IOFactory::load($_SERVER["DOCUMENT_ROOT"]."/include/orders_to_excel_new.xls");

$dbOrderList = CSaleOrder::GetList(
	Array("ID"=>"ASC"),
	Array("ID"=>$_GET["OID"]),
	false,
	false,
	Array()
);

$j=0;
$tmpItems=Array();

while ($arOrder = $dbOrderList->Fetch())
{
	$props=Array();

	$db_props = CSaleOrderPropsValue::GetOrderProps($arOrder["ID"]);
	while ($arProps = $db_props->Fetch())
	{
		$props[$arProps["CODE"]]=$arProps;
	}

	$j=intval($arOrder["ID"]);
	$tmpItems[$j]["ID"]=$arOrder["ID"];

	$tmpItems[$j]["TIME"]=$props["TIME"]["VALUE"];
	$tmpItems[$j]["TIME_FROM"]=$time[0];
	$tmpItems[$j]["TIME_TO"]=$time[1];

	$tmpItems[$j]["FIO"]=$props["FIO"]["VALUE"];
    $arLocs = CSaleLocation::GetByID($props["LOCATION"]["VALUE"], LANGUAGE_ID);
    $tmpItems[$j]["LOCATION"]=$arLocs;
	$tmpItems[$j]["ADDRESS"]=$props["ADDRESS"]["VALUE"];
	$tmpItems[$j]["PHONE"]=$props["PHONE"]["VALUE"];

	if($arOrder["PAYED"]=="Y") $tmpItems[$j]["TOTAL"]=0; else $tmpItems[$j]["TOTAL"]=$arOrder["PRICE"];//$arOrder["PRICE"];
	$tmpItems[$j]["PRICE"]=$arOrder["PRICE"]-$arOrder["PRICE_DELIVERY"];

	$tmpItems[$j]["COMMENTS"]=$arOrder["COMMENTS"];

    if($props["TIME"]["VALUE"]==4) {
        $tmpItems[$j]["FROM"]="18:00";
        $tmpItems[$j]["TO"]="23:00";
    }
    else {
        $tmpItems[$j]["FROM"]="10:00";
        $tmpItems[$j]["TO"]="18:00";
    }

}

ksort($tmpItems);

//$objPHPExcel->getActiveSheet()->insertNewRowBefore(9, $j);

$i=8;
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', date("d.m.Y", strtotime("today")));

	/*$by="TIME";

	$sort_num=Array();

	foreach($tmpItems as $c=>$key) {
		$sort_num[] = $key[$by];
	}

	array_multisort($sort_num, SORT_ASC, $tmpItems);*/


foreach($tmpItems as $key=>$item) {
	
	$i++;
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$i, $i-8)
	         	
				
				->setCellValue('C'.$i, mb_convert_encoding($item["ID"], "UTF-8", "windows-1251")) 
				
				->setCellValue("N".$i, mb_convert_encoding($item["TIME_FROM"]." ", "UTF-8", "windows-1251"))
				->setCellValue("O".$i, mb_convert_encoding($item["TIME_TO"]." ", "UTF-8", "windows-1251"))
				
				->setCellValue("B".$i, date("d.m.Y", strtotime("+1 day")))
				->setCellValue("D".$i, mb_convert_encoding(($item["LOCATION"]["CITY_NAME_LANG"] ? $item["LOCATION"]["CITY_NAME_LANG"] : "ћосква"), "UTF-8", "windows-1251"))

				->setCellValue("E".$i, mb_convert_encoding($item["ADDRESS"], "UTF-8", "windows-1251"))					
				->setCellValue("G".$i, mb_convert_encoding($item["PHONE"], "UTF-8", "windows-1251"))		
				->setCellValue("F".$i, mb_convert_encoding($item["FIO"], "UTF-8", "windows-1251"))		
				->setCellValue("K".$i, mb_convert_encoding($item["TOTAL"], "UTF-8", "windows-1251"))
				
				//->setCellValue("O".$i, mb_convert_encoding($item["PRICE"], "UTF-8", "windows-1251"))
				->setCellValue("M".$i, mb_convert_encoding($item["COMMENTS"], "UTF-8", "windows-1251"))
				->setCellValue("I".$i, mb_convert_encoding("«оотовары", "UTF-8", "windows-1251"))
                ->setCellValue("N".$i, mb_convert_encoding($item["FROM"], "UTF-8", "windows-1251"))
                ->setCellValue("O".$i, mb_convert_encoding($item["TO"], "UTF-8", "windows-1251"))
				; 
$style_wrap = array(
	//рамки
	'borders'=>array(
		//внешн€€ рамка
		'outline' => array(
			'style'=>PHPExcel_Style_Border::BORDER_THICK
		),
		//внутренн€€
		'allborders'=>array(
			'style'=>PHPExcel_Style_Border::BORDER_THIN,
			'color' => array(
				'rgb'=>'696969'
			)
		)
	)
);

//	$objPHPExcel->setActiveSheetIndex(0)->getStyle("A".$i.":Q".$i)->applyFromArray($style_wrap);        
}
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="orders_new.xlsx"');
header('Cache-Control: max-age=0');
$objWriter->save('php://output');
?>