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

			<div class="screen js-screen screen-right" data-screen="cat-<?=$key?>">
				<div class="enter-block">
					<a href="#" class="back-link js-back-link">Назад</a>
				</div><!-- end enter-block -->
				<nav>
					<ul class="mobile-menu">
						<li>
							<a href="<?=$arItem["LINK"]?>" class="active"><?=$arItem["NAME"]?></a>
							<ul class="mobile-submenu">
								<?foreach($arItem["ITEMS"] as $j=>$item):?>
									<li><a href="<?=$item["LINK"]?>" ><?=$item["NAME"]?></a></li>
								<?endforeach;?>
							</ul><!-- end mobile-submenu-->
						</li>
					</ul>
				</nav>
			</div><!-- end js-screen -->
		
		
		<?endforeach?>
		
<?endif?>