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
<div class="layout category-page mb50">

	<aside>
		<?if(is_array($arResult["PREVIEW_PICTURE"])):?>
			<img
				class="detail_picture"
				border="0"
				style="display: block;"
				src="<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>"
				alt="<?=$arResult["PREVIEW_PICTURE"]["ALT"]?>"
				title="<?=$arResult["PREVIEW_PICTURE"]["TITLE"]?>"
				/>
		<?endif?>	
		<div style="margin: 10px 0;">
			<?if($arResult["PROPERTIES"]["COUNTRY"]["VALUE"]):?>
				<?
				$country = CIBlockElement::GetByID($arResult["PROPERTIES"]["COUNTRY"]["VALUE"])->GetNext();
				?>
				<img style="vertical-align: middle;" src="<?=CFile::GetPath($country["PREVIEW_PICTURE"]);?>" /> <?=$country["NAME"]?>
			<?endif;?>
		</div>
		<nav>
			<ul class="side-menu">
				<?
				$arFilter = Array('IBLOCK_ID'=>2, "DEPTH_LEVEL"=>1, 'PROPERTY'=>Array("CML2_MANUFACTURER"=>$arResult["ID"]));
				$db_list = CIBlockSection::GetList(Array("SORT"=>"ASC"), $arFilter, true);
				while($ar_result = $db_list->GetNext())
				{
					?>
					<li><a href="<?=$ar_result["SECTION_PAGE_URL"]?>?set_filter=Y&<?="arrFilter_18_".abs(crc32($arResult["ID"]))?>=Y"><?=$ar_result["NAME"]?></a> (<?=$ar_result["ELEMENT_CNT"]?>)
						<?
						$db_list_2 = CIBlockSection::GetList(Array("SORT"=>"ASC"), Array('IBLOCK_ID'=>2, "SECTION_ID"=>$ar_result["ID"], "DEPTH_LEVEL"=>2, 'PROPERTY'=>Array("CML2_MANUFACTURER"=>$arResult["ID"])), true);
						if($db_list_2->SelectedRowsCount()):
						?>
							<ul>
								<?
								while($ar_result_2 = $db_list_2->GetNext())
								{
								?>
									<li><a href="<?=$ar_result_2["SECTION_PAGE_URL"]?>?set_filter=Y&<?="arrFilter_18_".abs(crc32($arResult["ID"]))?>=Y"><?=$ar_result_2["NAME"]?></a> (<?=$ar_result_2["ELEMENT_CNT"]?>)</li>
								<?
								}
								?>
							</ul>
						<?endif;?>
					</li>
					<?
				}
				?>
			</ul>
		</nav>
	</aside>

	<div class="main">
		<?echo $arResult["PREVIEW_TEXT"];?>
	</div>
</div>
<?
$GLOBALS["NEW_TITLE"]=$arResult["PROPERTIES"]["H1"]["VALUE"];
?>