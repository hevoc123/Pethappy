<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
use Bitrix\Sale\DiscountCouponsManager;

if (!empty($arResult["ERROR_MESSAGE"]))
	ShowError($arResult["ERROR_MESSAGE"]);

$bDelayColumn  = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn  = false;
$bPriceType    = false;

if ($normalCount > 0):
?>
<?
if(!$USER->IsAuthorized()) {
	$arElements = unserialize($APPLICATION->get_cookie('favorites'));
}
else {
	$idUser = $USER->GetID();
	$rsUser = CUser::GetByID($idUser);
	$arUser = $rsUser->Fetch(); 
	$arElements = unserialize($arUser['UF_FAVORITES']);
}
?>
<div class="sec-cart__box left">

	<div class="right" style="margin-top: 54px;"><a href="#" class="b-clean__basket-link">Очистить корзину</a></div>

	<h1>Ваша корзина</h1>
	
	<ul class="sec-cart__box-categories clearfix">
		<li>Корзина</li>
		<li><a href="/personal/wishlist/">Отложенное <span class="__favorite-count"><?=count($arElements)?></span></a></li>
	</ul>
	
	<div class="sec-cart__box-table b-shopcart-product_list" id="shopcart_products_list">
		<div class="sec-cart__box-table">
		
			<ul class="card-list">
				<?foreach($arResult["ITEMS"]["AnDelCanBuy"] as $key=>$item):?>
					<?//var_dump($item);
					$temp=CIBlockElement::GetList(Array(), Array("ID"=>$item["PRODUCT_ID"]), false, false, Array("ID", "IBLOCK_ID", "PROPERTY_CML2_LINK", "PROPERTY_CML2_LINK.DETAIL_PAGE_URL", "PROPERTY_CML2_LINK.PROPERTY_CML2_MANUFACTURER", "PROPERTY_IMYIE_CML2ATTR_FASOVKA"))->GetNext();
					if($temp["IBLOCK_ID"]==4)
					{
						$fasovka=$temp["PROPERTY_IMYIE_CML2ATTR_FASOVKA_VALUE"];
						$realID=$temp["PROPERTY_CML2_LINK_VALUE"];
						$brand=CIBlockElement::GetByID($temp["PROPERTY_CML2_LINK_PROPERTY_CML2_MANUFACTURER_VALUE"])->GetNext();
						//var_dump($temp);
						$item["DETAIL_PAGE_URL"]=$temp["PROPERTY_CML2_LINK_DETAIL_PAGE_URL"];
					}
					else
					{
						$temp=CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>2, "ID"=>$item["PRODUCT_ID"]), false, false, Array("ID", "IBLOCK_ID", "PROPERTY_CML2_MANUFACTURER"))->GetNext();
						$brand=CIBlockElement::GetByID($temp["PROPERTY_CML2_MANUFACTURER_VALUE"])->GetNext();
						$realID=$item["PRODUCT_ID"];
					}
					
					if(!$item["DETAIL_PICTURE_SRC"])
					{
						$item["DETAIL_PICTURE_SRC"]=CFile::GetPath(noimageFileID);
					}
					?>
					<li class="sec-cart__box-item for-transform" data-product_id="<?=$item["PRODUCT_ID"]?>" data-index_position="<?=$key?>">
						<div class="remove-item with-hint">
							<a href="#" class="cart-item-close-button" data-id="<?=$item["PRODUCT_ID"]?>"><i class="piluli-54"></i></a>
							<span class="hint">Удалить</span>
						</div>
						<div class="leftcol">
							<div class="img-wrap">
								<a href="<?=$item["DETAIL_PAGE_URL"]?>"><img src="<?=$item["DETAIL_PICTURE_SRC"]?>" alt="<?=$item["NAME"]?>"></a>
									<label class="like-checkbox with-hint buttonFavorite" rel="<?=$realID?>"><i class="piluli-3"></i><input type="checkbox" data-checkbox-processed="true"><span class="hint">Отложить</span></label>
							</div>
							<div class="details">
								<a href="<?=$item["DETAIL_PAGE_URL"]?>" class="title"><?=$item["NAME"]?></a>
								<div class="in-presence for-mobile">
									<span class="text">Есть в наличии</span>
									<?
									if($item["AVAILABLE_QUANTITY"] < 5)
										$color="red";
									elseif($item["AVAILABLE_QUANTITY"] < 20)
										$color="yellow";
									else
										$color="green";
									?>
									<ul class="presence-list">
										<li class="<?=$color?>" style=""></li>
										<li class="<?=$color?>" style="<?if($color=="red"):?>display: none;<?endif;?>"></li>
										<li class="<?=$color?>" style="<?if($color=="red"):?>display: none;<?endif;?>"></li>
										<li class="<?=$color?>" style="<?if($color=="red" || $color=="yellow"):?>display: none;<?endif;?>"></li>
										<li class="<?=$color?>" style="<?if($color=="red" || $color=="yellow"):?>display: none;<?endif;?>"></li>
									</ul><!-- end presence-list -->
								</div>
								<ul class="details-list">
									<?if($fasovka):?>
										<li>Фасовка: <?=$fasovka?></li>					
									<?endif;?>								
									<li>Производитель: <a href="<?=$brand["DETAIL_PAGE_URL"]?>"><?=$brand["NAME"]?></a></li>					
								</ul><!-- end details-list -->
							</div>
							<div class="clear"></div>
						</div>
						<div class="rightcol rightcol--alt product_item-price_buy-b">
							<ul class="details-list for-mobile">
								<?if($fasovka):?>
									<li>Фасовка: <?=$fasovka?></li>					
								<?endif;?>		
								<li>Производитель: <a href="<?=$brand["DETAIL_PAGE_URL"]?>"><?=$brand["NAME"]?></a></li>
							</ul><!-- end details-list -->
							<div class="spinbox"> 
								<a href="#" class="minus <?if($item["QUANTITY"] < 2):?>disabled<?endif;?>"></a>
								<input type="text" value="<?=$item["QUANTITY"]?>" data-id="<?=$item["PRODUCT_ID"]?>" max="<?=$item["AVAILABLE_QUANTITY"]?>" maxlength="2" id="QUANTITY_INPUT_<?=$arItem["ID"]?>" name="QUANTITY_INPUT_<?=$arItem["ID"]?>" class="_addCount">
								<a href="#" class="plus">+</a>
							</div><!-- end spinbox -->
							<div class="price-wrap ">
								<?=$item["PRICE"]?> <span class="rub">руб.</span>
							</div><!-- end price-wrap -->
								<div class="in-presence">
									<span class="text">Есть в наличии</span>
									<ul class="presence-list">
										<li class="<?=$color?>" style=""></li>
										<li class="<?=$color?>" style="<?if($color=="red"):?>display: none;<?endif;?>"></li>
										<li class="<?=$color?>" style="<?if($color=="red"):?>display: none;<?endif;?>"></li>
										<li class="<?=$color?>" style="<?if($color=="red" || $color=="yellow"):?>display: none;<?endif;?>"></li>
										<li class="<?=$color?>" style="<?if($color=="red" || $color=="yellow"):?>display: none;<?endif;?>"></li>
									</ul><!-- end presence-list -->
								</div>
						</div>
						<div class="clear"></div>
						<input id="check_342771" type="checkbox" value="342771" name="cart_delete[]" class="q_check" style="display:none;">
						<input type="hidden" value="342771" name="products_id[]">
					</li>
				<?endforeach;?>
			</ul>
			<?if(count($arResult["ITEMS"]["nAnCanBuy"]) > 0):?>
			<ul class="card-list">
				<?foreach($arResult["ITEMS"]["nAnCanBuy"] as $key=>$item):?>
					<?//var_dump($item);
					$temp=CIBlockElement::GetList(Array(), Array("ID"=>$item["PRODUCT_ID"]), false, false, Array("ID", "IBLOCK_ID", "PROPERTY_CML2_LINK", "PROPERTY_CML2_LINK.DETAIL_PAGE_URL", "PROPERTY_CML2_LINK.PROPERTY_CML2_MANUFACTURER", "PROPERTY_IMYIE_CML2ATTR_FASOVKA"))->GetNext();
					if($temp["IBLOCK_ID"]==4)
					{
						$fasovka=$temp["PROPERTY_IMYIE_CML2ATTR_FASOVKA_VALUE"];
						$realID=$temp["PROPERTY_CML2_LINK_VALUE"];
						$brand=CIBlockElement::GetByID($temp["PROPERTY_CML2_LINK_PROPERTY_CML2_MANUFACTURER_VALUE"])->GetNext();
						//var_dump($temp);
						$item["DETAIL_PAGE_URL"]=$temp["PROPERTY_CML2_LINK_DETAIL_PAGE_URL"];
					}
					else
					{
						$temp=CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>2, "ID"=>$item["PRODUCT_ID"]), false, false, Array("ID", "IBLOCK_ID", "PROPERTY_CML2_MANUFACTURER"))->GetNext();
						$brand=CIBlockElement::GetByID($temp["PROPERTY_CML2_MANUFACTURER_VALUE"])->GetNext();
						$realID=$item["PRODUCT_ID"];
					}

					if(!$item["DETAIL_PICTURE_SRC"])
					{
						$item["DETAIL_PICTURE_SRC"]=CFile::GetPath(noimageFileID);
					}
					//var_dump($item);
					?>				
					<li style="opacity: 0.7" class="sec-cart__box-item for-transform" data-product_id="<?=$item["PRODUCT_ID"]?>" data-index_position="<?=$key?>">
						<div class="remove-item with-hint">
							<a href="#" class="cart-item-close-button" data-id="<?=$item["PRODUCT_ID"]?>"><i class="piluli-54"></i></a>
							<span class="hint">Удалить</span>
						</div>
						<div class="leftcol">
							<div class="img-wrap">
								<a href="<?=$item["DETAIL_PAGE_URL"]?>"><img src="<?=$item["DETAIL_PICTURE_SRC"]?>" alt="<?=$item["NAME"]?>"></a>
									<label class="like-checkbox with-hint buttonFavorite" rel="<?=$realID?>"><i class="piluli-3"></i><input type="checkbox" data-checkbox-processed="true"><span class="hint">Отложить</span></label>
							</div>
							<div class="details">
								<a href="<?=$item["DETAIL_PAGE_URL"]?>" class="title"><?=$item["NAME"]?></a>
								<div class="in-presence for-mobile">
									<span class="text">Нет наличии</span>
								</div>
								<ul class="details-list">
									<?if($fasovka):?>
										<li>Фасовка: <?=$fasovka?></li>					
									<?endif;?>								
									<li>Производитель: <a href="<?=$brand["DETAIL_PAGE_URL"]?>"><?=$brand["NAME"]?></a></li>					
								</ul><!-- end details-list -->
							</div>
							<div class="clear"></div>
						</div>
						<div class="rightcol rightcol--alt product_item-price_buy-b">
							<ul class="details-list for-mobile">
								<?if($fasovka):?>
									<li>Фасовка: <?=$fasovka?></li>					
								<?endif;?>		
								<li>Производитель: <a href="<?=$brand["DETAIL_PAGE_URL"]?>"><?=$brand["NAME"]?></a></li>
							</ul><!-- end details-list -->
							<div class="price-wrap ">
								<?=$item["PRICE"]?> <span class="rub">руб.</span>
							</div><!-- end price-wrap -->
								<div class="in-presence">
									<span class="text">Нет в наличии</span>
								</div>
							<a href="javascript:void(0)" style="margin-bottom: 15px;" class="btn-reg _noticeMe" data-id="<?=$item["PRODUCT_ID"]?>">Уведомить</a>								
						</div>
						<div class="clear"></div>
						<input id="check_342771" type="checkbox" value="342771" name="cart_delete[]" class="q_check" style="display:none;">
						<input type="hidden" value="342771" name="products_id[]">
					</li>
				<?endforeach;?>
			</ul>
			<?endif;?>

			
		</div>
	</div>
</div>
<?//var_dump($arResult);?>

<div class="sec-cart__info right" id="shopcart_product_list_right">
	<div class="sec-cart__info-box fixedScroll" data-fixedscroll-processed="true" style="position: absolute; right: 0px; z-index: 9; top: 0px;">
		<div class="sec-cart__info-header clearfix">
			<div class="left"><i class="piluli-2"></i><span><?=count($arResult["ITEMS"]["AnDelCanBuy"])?></span></div>
			<div class="left">Ваш заказ</div>
		</div>

		<div class="sec-cart__info-content">
			<div class="sec-cart__info-field clearfix">
				<div class="sec-cart__info-field-left left"><?=count($arResult["ITEMS"]["AnDelCanBuy"])?> <?=getWord(count($arResult["ITEMS"]["AnDelCanBuy"]), array("товар", "товара", "товаров"))?></div>
				<div class="sec-cart__info-field-right right">
					<div class="sec-cart__info-field-price"><?=$arResult["PRICE_WITHOUT_DISCOUNT"]?></div>
				</div>
			</div>

			<!--
			<div class="sec-cart__info-scrollbox scrollbar-outer">
				
					<div class="sec-cart__info-field clearfix">
						<div class="sec-cart__info-field-left left">Максилак капсулы, 10 шт.</span></div>
						<div class="sec-cart__info-field-right right">
							<div class="sec-cart__info-field-price"><span>404</span> руб.</div>
							<div class="sec-cart__info-field-count">?1</div>
						</div>
					</div>
				
					<div class="sec-cart__info-field clearfix">
						<div class="sec-cart__info-field-left left">Позитив 300 мг капсулы 60 шт.</span></div>
						<div class="sec-cart__info-field-right right">
							<div class="sec-cart__info-field-price"><span>919</span> руб.</div>
							<div class="sec-cart__info-field-count">?1</div>
						</div>
					</div>
				
			</div>
			-->

			<div class="sec-cart__info-scrollbox-hr"></div>

			<div class="sec-cart__info-code">
				<div class="sec-cart__info-code-title">Скидка по промо-коду</div>
				
				<input type="text" placeholder="Введите код" name="coupon_value">
				<button class="btn-reg btn-dark coupon_apply_btn" onclick="return false;">Применить</button>
			</div>

			
				<!-- <div class="sec-cart__info-field sec-cart__info-field--sale clearfix">
					<div class="sec-cart__info-field-left left"><i></i>Скидка</div>
					<div class="sec-cart__info-field-right right">
						<div class="sec-cart__info-field-price">– <span>148</span> руб.</div>
					</div>
				</div> -->
			

			

			<div class="sec-cart__info-total clearfix">
				<div class="sec-cart__info-total-left left"><div>Итого:</div></div>
				<div class="sec-cart__info-total-right right"><span><?=number_format( $arResult["allSum"], 0, ".", " ")?></span> руб.</div>
			</div>

			<div class="sec-cart__info-order">
				<div id="lowsum" class="tooltip__hint tooltip__hint--alert" style="top: 235px; height: 75px; width: 180px;">
					<div class="tooltip-message">Для оформления  заказа стоимость товаров в корзине должна превышать 500 руб.</div>
					<div class="tooltip__arrow">?</div>
				</div>
				<a href="/personal/order/" <?if($arResult["allSum"] < 500):?>onclick="$('#lowsum').show(); return false;"<?endif;?> class="btn-reg btn-red">Оформить заказ</a>
			</div>
		</div>
	</div>
</div>
<?
else:
?>
<div id="basket_items_list">
	<table>
		<tbody>
			<tr>
				<td style="text-align:center">
					<div class=""><?=GetMessage("SALE_NO_ITEMS");?></div>
				</td>
			</tr>
			<tr>
				<td>
					<img src="/images/pet_dental.jpg" />
				</td>
			</tr>
		</tbody>
	</table>
</div>
<?
endif;
?>