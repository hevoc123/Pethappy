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
<div class="ajax_container">
	<div class="b-spisok__top">
		<?foreach($arResult["ITEMS"] as $key=>$arItem):?>
			<?
			if($key==0 || $lastchar!=$arItem["NAME"]{0}):
			?>
				</div>
				<div class="b-spisok__top">
					<div class="brands--grid-title" id="<?=ord($arItem["NAME"]{0});?>"><?=$arItem["NAME"]{0}?></div>
			<?
			endif;
			
			$lastchar=$arItem["NAME"]{0};
			
			if( $arItem['PREVIEW_PICTURE'] )
				$renderImage_small = CFile::ResizeImageGet( $arItem['PREVIEW_PICTURE'], Array( "width" => "147", "height" => "127" ), BX_RESIZE_IMAGE_PROPORTIONAL, true );
			else
				$renderImage_small = CFile::ResizeImageGet( noimageFileID, Array( "width" => "147", "height" => "127" ), BX_RESIZE_IMAGE_PROPORTIONAL, true );
			?>
			<a class="brands--grid-item" href="<?=$arItem['DETAIL_PAGE_URL']?>">
				<div>
					<img class="b-brand__pikcha" title="<?=$arItem["NAME"]?>" alt="<?=$arItem["NAME"]?>" src="<?=$renderImage_small["src"]?>">
				</div>
				<?=$arItem["NAME"]?>
			</a>
		<?endforeach;?>
	</div>
</div>