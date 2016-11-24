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
?>

<ul class="bonuses-full-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?foreach($arResult["ITEMS"] as $key=>$arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	if($arItem['PREVIEW_PICTURE'])
		$file = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width'=>155, 'height'=>1024), BX_RESIZE_IMAGE_PROPORTIONAL, true);
	elseif($arItem['DETAIL_PICTURE'])
		$file = CFile::ResizeImageGet($arItem['DETAIL_PICTURE'], array('width'=>155, 'height'=>1024), BX_RESIZE_IMAGE_PROPORTIONAL, true);
	?>
	<li id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<a class="img-wrap cp" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=$file["src"]?>" /></a>
		<div class="details">
			<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>" class="title">
				<?echo $arItem["NAME"]?>
			</a>
			<small><?echo $arItem["PREVIEW_TEXT"];?></small>
		</div>
	</li>
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</ul>
