<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
//$this->setFrameMode(true);
CModule::IncludeModule("sale");
$arBasketItems = array();

$dbBasketItems = CSaleBasket::GetList(
	array(),
	array(
		 "FUSER_ID" => CSaleBasket::GetBasketUserID(),
		"LID" => SITE_ID,
		 "ORDER_ID" => "NULL"
	),
	false,
	false,
	array("*")
);

$i = 0;
while ($arItems = $dbBasketItems->Fetch())
{
	$arResult["INBASKET"][$arItems["PRODUCT_ID"]]=intval($arItems["QUANTITY"]);
	$arResult["INBASKET_ID"][]=$arItems["PRODUCT_ID"];
}
?>

<?if( $arResult['DETAIL_PICTURE']['SRC'] ):?>                                                                         
<?
	//$renderImage = CFile::ResizeImageGet( $arResult['DETAIL_PICTURE']['ID'], Array( "width" => "375", "height" => "339" ), BX_RESIZE_IMAGE_PROPORTIONAL, true, $arFilter_watermark );
	$renderImage_small = CFile::ResizeImageGet( $arResult['DETAIL_PICTURE']['ID'], Array( "width" => "162", "height" => "180" ), BX_RESIZE_IMAGE_PROPORTIONAL, true );
	$renderImage_big = CFile::ResizeImageGet( $arResult['DETAIL_PICTURE']['ID'], Array( "width" => 300, "height" => 300 ), BX_RESIZE_IMAGE_PROPORTIONAL, true, $arFilter_watermark );
else:
	//$renderImage = CFile::ResizeImageGet( noimageFileID, Array( "width" => "375", "height" => "339" ), BX_RESIZE_IMAGE_PROPORTIONAL, true, $arFilter_watermark );
	$renderImage_small = CFile::ResizeImageGet( noimageFileID, Array( "width" => "162", "height" => "180" ), BX_RESIZE_IMAGE_PROPORTIONAL, true );
	$renderImage_big = CFile::ResizeImageGet( noimageFileID, Array( "width" => "300", "height" => "300" ), BX_RESIZE_IMAGE_PROPORTIONAL, true, $arFilter_watermark );
endif;?>

<img style="float:right; text-align:right; padding: 0 0 20px 20px;" align="left" src="<?=$renderImage_big["src"]?>" title="" alt="" class="b-photo__img">
<h3><?=iconv("windows-1251", "UTF-8", $arResult["NAME"]);?></h3>
