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
$this->setFrameMode(true);

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
	$renderImage_big = CFile::ResizeImageGet( $arResult['DETAIL_PICTURE']['ID'], Array( "width" => $arResult["DETAIL_PICTURE"]["WIDTH"] - 1, "height" => $arResult["DETAIL_PICTURE"]["HEIGHT"] - 1 ), BX_RESIZE_IMAGE_PROPORTIONAL, true, $arFilter_watermark );
else:
	//$renderImage = CFile::ResizeImageGet( noimageFileID, Array( "width" => "375", "height" => "339" ), BX_RESIZE_IMAGE_PROPORTIONAL, true, $arFilter_watermark );
	$renderImage_small = CFile::ResizeImageGet( noimageFileID, Array( "width" => "162", "height" => "180" ), BX_RESIZE_IMAGE_PROPORTIONAL, true );
	$renderImage_big = CFile::ResizeImageGet( noimageFileID, Array( "width" => "600", "height" => "400" ), BX_RESIZE_IMAGE_PROPORTIONAL, true, $arFilter_watermark );
endif;?>

<img style="float:right; width: 400px; text-align:right; padding: 0 0 20px 20px;" src="<?=$renderImage_big["src"]?>" title="<?=$arResult["NAME"]?>" alt="<?=$arResult["NAME"]?>" class="b-photo__img">
<button class="btn-action_print" id="print">Печать</button>	
<!--span class="cat-label profit">Выгода <br/> <span>9%</span></span-->
<h3><?=$arResult["NAME"]?></h3>
<ul style="list-style-type: none; margin-left: 0px;">
	<?if($arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]):?><li>Артикул: <?=$arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?></li><?endif;?>
	<?if($arResult["DISPLAY_PROPERTIES"]["CML2_MANUFACTURER"]["DISPLAY_VALUE"]):?><li>Производитель:  <?=$arResult["DISPLAY_PROPERTIES"]["CML2_MANUFACTURER"]["DISPLAY_VALUE"]?></li><?endif;?>
	<?if($arResult["PROPERTIES"]["FLAVOUR"]["VALUE"]):?>
		<?foreach($arResult["PROPERTIES"]["FLAVOUR"]["VALUE"] as $prop):?>
			<li>Вкус: <?=$prop?></li>
		<?endforeach;?>
	<?endif;?>
	<?if($arResult["PROPERTIES"]["AGE"]["VALUE"]):?><li><?=$arResult["PROPERTIES"]["AGE"]["VALUE"]?></li><?endif;?>				
	<?if($arResult["PROPERTIES"]["PORODA"]["VALUE"]):?><li>Для породы: <?=$arResult["PROPERTIES"]["PORODA"]["VALUE"]?></li><?endif;?>								
	<?if($arResult["PROPERTIES"]["SPECIAL"]["VALUE"]):?><li>Серия: <?=$arResult["PROPERTIES"]["SPECIAL"]["VALUE"]?></li><?endif;?>												
	<?if($arResult["PROPERTIES"]["NAPOLNITEL"]["VALUE"]):?><li>Наполнитель: <?=$arResult["PROPERTIES"]["NAPOLNITEL"]["VALUE"]?></li><?endif;?>																
	<? /*<li>Срок годности: до 01.08.2018</li>*/ ?>
</ul>
<h4>Цены</h4> 
<?if(is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"])):?>
	
	<table class="sec-layout__table" style="width: 50%">
		<thead>
			<tr>
				<th>Упаковка</th>
				<th>Цена</th>
			</tr>
		</thead>	
		<tbody>
		<?foreach($arResult["OFFERS"] as $key=>$arOff):?>
			<?foreach($arOff["PRICES"] as $code=>$arPrice):?>
				<tr>
					<td><?=$arOff["PROPERTIES"]["IMYIE_CML2ATTR_FASOVKA"]["VALUE"]?></td><td><strong><?=round($arPrice["VALUE"])?></strong> руб</td>
				</tr>
			<?endforeach;?>
		<?endforeach;?>
		</tbody>
	</table><br/>
<?else:?>
	<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
		
			<?=round($arPrice["VALUE"])?>
		
	<?endforeach;?>
<?endif;?>
		
<?=$arResult["DETAIL_TEXT"]?>
