<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
if(!empty($arResult["CATEGORIES"])):
?>

	<div class="" style="display:block;">
		<div class="header-search__sub__container">
			<?//var_dump($arResult["CATEGORIES"]);?>
			<div class="header-search__sub__count"><h3>Найдено <?=count($arResult["ELEMENTS"])?> товаров</h3></div>
			<table class="cart-sub__table">
					<?$j=0;?>
					<?foreach($arResult["ELEMENTS"] as $i => $arItem):?>
						<?
						$j++;
						if($j > 4) break;
						?>
					<tr>	

							<td class="cart-sub__img">
								<?if($arItem["DETAIL_PICTURE"]):?>
									<?
										$file=CFile::ResizeImageGet($arItem["DETAIL_PICTURE"], array('width'=>84, 'height'=>84), BX_RESIZE_IMAGE_PROPORTIONAL, true);
									?>
									<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=$file["src"]?>" /></a>
								<?else:?>
									<?
									$renderImage = CFile::ResizeImageGet( noimageFileID, Array( "width" => "198", "height" => "168" ), BX_RESIZE_IMAGE_PROPORTIONAL, true );
									?>
									<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img height="84" src="<?=$renderImage["src"]?>" alt="" /></a>
								<?endif;?>
							</td>

							<td class="cart-sub__text">
								<a class="item-title-search" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
								<div class="price-wrap" style="margin: 7px 0 0 0;"><?if($arItem["PRICE"] > 0):?><?=number_format($arItem["PRICE"], 0, ",", " ");?><span class="rub"> руб.</span><?else:?>Звоните!<?endif;?></div>
							</td>

							<td class="cart-sub__options">
								<div class="controls cleara">
									<?//var_dump($arItem["QUANTITY"]);?>
									<?if($arItem["QUANTITY"] > 0):?>
										<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" rel="<?=$arItem["ID"]?>" class="btn-reg">Купить</a>
									<?else:?>
										Нет в наличии
									<?endif;?>
								</div>							
							</td>
					</tr>
					<?endforeach;?>
			</table>
			<button title="Close (Esc)" style="color: black;" type="button" class="mfp-close">&#215;</button>
			<div class="header-search__sub__all"><a href="<?=$arResult["ALL"]?>">показать все товары</a></div>
		</div>
	</div>
<?else:?>
<div style="color: black;">Уточните параметры поиска</div>
<?endif;
//echo "<pre>",htmlspecialcharsbx(print_r($arResult,1)),"</pre>";
?>