<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<div class="inner js-menu-wrap">
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
	<ul class="main-menu">
		<?
		foreach($temp as $key=>$arItem):?>

			<li><a href="<?=$arItem["LINK"]?>" class="js-menu-link" data-cat="cat-<?=$key?>"><?=$arItem["NAME"]?></a></li>
		
		<?endforeach?>
	</ul>

	<div class="main-menu-open-wrap js-menu-open-wrap">
		<?foreach($temp as $key=>$arItem):?>
			
				<div class="main-menu-open js-menu-open<?if($key==1):?> current<?endif?>" data-cat_id="<?=$key?>" data-cat="cat-<?=$key?>">
					<?if(count($arItem["ITEMS"]) > 0):?>
						<ul class="main-submenu">
							<?foreach($arItem["ITEMS"] as $j=>$item):?>
								<li><a href="<?=$item["LINK"]?>"><?=$item["NAME"]?></a></li>
								<?if($j > 6) break;?>
							<?endforeach;?>
							<li><a href="<?=$arItem["LINK"]?>" class="show-all-link">Смотреть все</a></li>
						</ul><!-- end main-submenu -->
					<?endif;?><? /*
					<div class="for-card col-3">
						<div class="item-card">
							<div class="for-transform">
								<figure class="front">
									<a class="img-wrap" href="/product284097/product_info.html">
										<img class="img" src="images/smacs_images/products/000/274/191/original_pentalgin_tabletki_12_sht_www_piluli_ru_eapt213162.jpg">
									</a>

									<div class="item-name"><a href="/product284097/product_info.html" class="truncate-title" style="word-wrap: break-word;">ѕенталгин таблетки, 12 шт.</a></div>
																	<div class="price-wrap">
										<span class="_price">116</span> <span class="rub">руб.</span>

																				<span class="old-price">129</span>
																		</div><!-- end price-wrap -->
									<div class="btn-wrap">
										<a href="javascript:void(0)" class="btn-reg js-buy-link _addToCart" data-id="284097"> упить</a>
										<label class="like-checkbox buttonFavorite" rel="284097"><i class="piluli-3"></i><input type="checkbox" data-checkbox-processed="true"></label>
									</div><!-- end btn-wrap -->
								</figure><!-- end front -->
								<figure class="back">
									<div class="item-name"><a href="/product284097/product_info.html" class="truncate-title" style="word-wrap: break-word;">ѕенталгин таблетки, 12 шт.</a></div>
									<span class="added-to-cart">?обавлено в <a href="/shopcart.html">корзину</a></span>
									<div class="spinbox">
										<a href="#" class="minus disabled"></a>
										<input type="text" value="1">
										<a href="#" class="plus">+</a>
									</div><!-- end spinbox -->
									<div class="actual-price">
										116 <span class="rub">руб.</span>
									</div><!-- end price-wrap -->
									<div class="btn-wrap">
										<a href="/shopcart.html" class="btn-reg">ќформить заказ</a>
									</div>
								</figure><!-- end back -->
							</div><!-- for-transform -->
						</div><!-- end item-card -->
					</div><!-- for card -->*/?>
				</div>
		<?endforeach;?>
	</div>
</div>
<?endif?>