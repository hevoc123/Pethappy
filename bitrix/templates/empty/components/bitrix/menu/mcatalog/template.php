<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>

<?
$temp=Array();
$i=0;
foreach($arResult as $arItem):
	if($arItem["DEPTH_LEVEL"] == 1)
	{
		$i++;
		$temp[$i]["NAME"]=$arItem["TEXT"];
		$temp[$i]["LINK"]=$arItem["LINK"];
		$temp[$i]["SELECTED"]=$arItem["SELECTED"];
	}
	else
	{
		$item=Array();
		$item["NAME"]=$arItem["TEXT"];
		$item["LINK"]=$arItem["LINK"];
		$item["SELECTED"]=$arItem["SELECTED"];
		$temp[$i]["ITEMS"][]=$item;
	}
endforeach;

$previousLevel = 0;
?>

		<?
		foreach($temp as $key=>$arItem):?>
			<li><a href="<?=$arItem["LINK"]?>" class="js-forward-link" data-screen="cat-<?=$key?>"><?=$arItem["NAME"]?></a></li>
		<?endforeach?>

<?endif?>
