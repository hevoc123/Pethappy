<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */

$this->setFrameMode(true);

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");

ob_start();

$colorSchemes = array(
	"green" => "bx-green",
	"yellow" => "bx-yellow",
	"red" => "bx-red",
	"blue" => "bx-blue",
);
if(isset($colorSchemes[$arParams["TEMPLATE_THEME"]]))
{
	$colorScheme = $colorSchemes[$arParams["TEMPLATE_THEME"]];
}
else
{
	$colorScheme = "";
}
?>

<div class="ws-pagi <?=$colorScheme?>">
	<div class="pagination">
<?if($arResult["bDescPageNumbering"] === true):?>

	<?if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
		<?if($arResult["bSavePage"]):?>
			<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><?echo GetMessage("round_nav_back")?></a>
			<li class=""><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><span>1</span></a></li>
		<?else:?>
			<?if (($arResult["NavPageNomer"]+1) == $arResult["NavPageCount"]):?>
				<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><span><?echo GetMessage("round_nav_back")?></span></a>
			<?else:?>
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><span><?echo GetMessage("round_nav_back")?></span></a>
			<?endif?>
			<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><span>1</span></a>
		<?endif?>
	<?else:?>
			<a href="#" class="prev disabled"><i class="piluli-35">
			<li class="bx-active"><span>1</span></li>
	<?endif?>

	<?
	$arResult["nStartPage"]--;
	while($arResult["nStartPage"] >= $arResult["nEndPage"]+1):
	?>
		<?$NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;?>

		<?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
			<li class="bx-active"><span><?=$NavRecordGroupPrint?></span></li>
		<?else:?>
			<li class=""><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><span><?=$NavRecordGroupPrint?></span></a></li>
		<?endif?>

		<?$arResult["nStartPage"]--?>
	<?endwhile?>

	<?if ($arResult["NavPageNomer"] > 1):?>
		<?if($arResult["NavPageCount"] > 1):?>
			<li class=""><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1"><span><?=$arResult["NavPageCount"]?></span></a></li>
		<?endif?>
			<li class="bx-pag-next"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><span><?echo GetMessage("round_nav_forward")?></span></a></li>
	<?else:?>
		<?if($arResult["NavPageCount"] > 1):?>
			<li class="bx-active"><span><?=$arResult["NavPageCount"]?></span></li>
		<?endif?>
			<li class="bx-pag-next"><span><?echo GetMessage("round_nav_forward")?></span></li>
	<?endif?>

<?else:?>

	<?if ($arResult["NavPageNomer"] > 1):?>
		<?if($arResult["bSavePage"]):?>
			<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>" class="prev"><i class="piluli-35"></i></a>				
			<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1">1</a>
		<?else:?>
			<?if ($arResult["NavPageNomer"] > 2):?>
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>" class="prev"><i class="piluli-35"></i></a>
			<?else:?>
				<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><i class="piluli-35"></i></a>
			<?endif?>
			<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">1</a>
			<span href="#" class="more"><span style="display:none;">2</span>...</span>
		<?endif?>
	<?else:?>
			<a href="#" class="prev disabled"><i class="piluli-35"></i></a>
			<a href="#" class="current disabled">1</a>
	<?endif?>

	<?
	$arResult["nStartPage"]++;
	while($arResult["nStartPage"] <= $arResult["nEndPage"]-1):
	?>
		<?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
			<a href="#" class="current disabled"><?=$arResult["nStartPage"]?></a>
		<?else:?>
			<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$arResult["nStartPage"]?></a>
		<?endif?>
		<?$arResult["nStartPage"]++?>
	<?endwhile?>

	<?if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
		<?if($arResult["NavPageCount"] > 1):?>
			<span href="#" class="more"><span style="display:none;">2</span>...</span>
			<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=$arResult["NavPageCount"]?></a>
		<?endif?>
			<a class="next" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><i class="piluli-36"></i></a>
	<?else:?>
		<?if($arResult["NavPageCount"] > 1):?>
			<a href="#" class="current disabled"><?=$arResult["NavPageCount"]?></a>
		<?endif?>
			<a href="#" class="next disabled"><i class="piluli-36"></i></a>
	<?endif?>
<?endif?>

<?if ($arResult["bShowAll"]):?>
	<?if ($arResult["NavShowAll"]):?>
			<li class="bx-pag-all"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=0" rel="nofollow"><span><?echo GetMessage("round_nav_pages")?></span></a></li>
	<?else:?>
			<li class="bx-pag-all"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=1" rel="nofollow"><span><?echo GetMessage("round_nav_all")?></span></a></li>
	<?endif?>
<?endif?>
	</div>
</div>
<?
$paging = ob_get_contents();
$paging = preg_replace_callback('/href="([^"]+)"/is', function($matches) {
							$url = $matches[1];
							$newUrl = '';
							if ($arUrl = parse_url($url)) {
								$newUrl .= $arUrl['path'];
								/*if (substr($newUrl, -1) != '/') {
									$newUrl .= '/';
								}*/
								$newUrl = preg_replace('#(pagen[\d]+/)#is', '', $newUrl);
								parse_str(htmlspecialcharsback($arUrl['query']), $arQuery);
								foreach ($arQuery as $k => $v) {
									if (in_array($k, array('SECTION_CODE'))) {
										unset($arQuery[$k]);
									} elseif (substr($k, 0, 5)=='PAGEN') {
										//$newUrl .= 'pagen'.intval($v).'/';
										$arQuery['page'] = intval($v);
										unset($arQuery[$k]);
									}
								}
								$buildQuery = http_build_query($arQuery, '', '&amp;');
								if (strlen($buildQuery)) {
									$newUrl .= '?'.$buildQuery;
								}
							}
							return 'href="'.$newUrl.'"';
						}, $paging);
ob_end_clean();
echo $paging;
?>