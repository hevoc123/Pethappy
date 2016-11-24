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
<?
if (!empty($arResult['ITEMS'])) 
{
?>
<div class="clearfix" style="margin-bottom:40px;">
<ul class="cat-list <?=$arParams["ADDCLASS"]?> clearfix" id="list">
	<?foreach($arResult["ITEMS"] as $arElement):?>
	<?
	$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
	?>
	<?
	$inbasket=0;
	if(is_array($arElement["OFFERS"]) && !empty($arElement["OFFERS"]))
	{
		foreach($arElement["OFFERS"] as $key=>$arOffer)
		{
			if(in_array($arOffer["ID"], $arResult["INBASKET_ID"]))
			{
				$inbasket=$arOffer["ID"];
				$inbasket_offer=$arOffer;
			}
		}
	}
	else
	{
		if(in_array($arElement["ID"], $arResult["INBASKET_ID"]))
			$inbasket=$arResult["ID"];
	}
	
	$total_rating=0;
	$arSelect = Array("ID", "NAME", "PROPERTY_RATING");
	$arFilter = Array("IBLOCK_ID"=>13, "ACTIVE"=>"Y", "PROPERTY_CML2_LINK"=>$arElement["ID"]);
	$res = CIBlockElement::GetList(Array("DATE_ACTIVE_FROM"=>"DESC"), $arFilter, false, false, $arSelect);
	$rcount=$res->SelectedRowsCount();
	while($ar_res= $res->GetNext())
	{
		if(!$ar_res["PROPERTY_RATING_VALUE"]) $ar_res["PROPERTY_RATING_VALUE"]=5;
		$total_rating=$total_rating+$ar_res["PROPERTY_RATING_VALUE"];
	}
	$rating=ceil($total_rating/$rcount);
	?>
	<li class="item-card <?if(is_array($arElement["OFFERS"]) && !empty($arElement["OFFERS"])):?>withoffer<?endif?>" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
		<div class="for-transform<?if($inbasket):?> flipped<?endif;?>">
			<figure class="front">
				<a class="img-wrap"  data-mdacl="<?=$arElement['ID']?>"  href="<?=str_replace("/categories", "", $arElement['DETAIL_PAGE_URL'])?>"
				   title='<?=$arElement['NAME']?>'>
				    <?
						if( $arElement['PREVIEW_PICTURE']['SRC'] ):                              
					       	$renderImage = CFile::ResizeImageGet( $arElement['PREVIEW_PICTURE']["ID"], Array( "width" => "198", "height" => "168" ), BX_RESIZE_IMAGE_PROPORTIONAL, true );
				        elseif($arElement['DETAIL_PICTURE']):
							$renderImage = CFile::ResizeImageGet( $arElement['DETAIL_PICTURE'], Array( "width" => "198", "height" => "168" ), BX_RESIZE_IMAGE_PROPORTIONAL, true );
				        else:
							$renderImage = CFile::ResizeImageGet( noimageFileID, Array( "width" => "198", "height" => "168" ), BX_RESIZE_IMAGE_PROPORTIONAL, true );
				        endif;
					?>
					<img class="img _js-load-img" src="<?=$renderImage["src"]?>" alt="<?=$arElement['NAME']?>"/>
					<? /*<span class="cat-label yellow tl">Ћидер продаж</span> */ ?>
				</a>

				<div class="rating-wrap">
					<?if($rcount):?>
					<div class="stars" title="<?=$rating?>">
						<span><i class="piluli-<?=($rating >= 1 ? "13" : "15" )?>"></i></span>
						<span><i class="piluli-<?=($rating >= 2 ? "13" : "15" )?>"></i></span>
						<span><i class="piluli-<?=($rating >= 3 ? "13" : "15" )?>"></i></span>
						<span><i class="piluli-<?=($rating >= 4 ? "13" : "15" )?>"></i></span>
						<span><i class="piluli-<?=($rating >= 5 ? "13" : "15" )?>"></i></span>
					</div>
					<!-- end stars-->
					<span class="digit">(<?=$rcount?>)</span>
					<?endif;?>
				</div>
				<!-- end rating-wrap -->

				<div class="item-name">
					<a data-mdacl="<?=$arElement['ID']?>" href="<?=str_replace("/categories", "", $arElement['DETAIL_PAGE_URL'])?>" title='<?=$arElement['NAME']?>' class="truncate-title">
						<?=$arElement['NAME']?>
					</a>
				</div>
				<?
				$available=false;
				?>
				<?if(is_array($arElement["OFFERS"]) && !empty($arElement["OFFERS"])):?>
					<?$tmp=Array();?>
					<?foreach($arElement["OFFERS"] as $key=>$arOffer):?>
							<?
							if($arOffer["CAN_BUY"]) {
								$tmp=$arOffer;
								$available=true;
								break;
							}
							?>
						<?endforeach;?>
						<?
						if($tmp)
							$arOffer=$tmp;
						else
							$arOffer=$arElement["OFFERS"][0];

					?>
					<div class="sec-offers-artiles">
						<?foreach($arElement["OFFERS"] as $key=>$arOff):?>
							<span class="article sec-offers-list" style="margin: -15px 0 0 0; font-size: 11px; <?if($arOff["ID"]!=$arOffer["ID"]):?> display: none;<?endif;?>" id="offer_art_<?=$arOff["ID"]?>">Артикул: <?=(strlen($arOff["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]) > 0 ? $arOff["PROPERTIES"]["CML2_ARTICLE"]["VALUE"] : $arElement["PROPERTIES"]["CML2_ARTICLE"]["VALUE"])?></span>
						<?endforeach;?>
					</div>					
					<div class="price-wrap sec-offers-list">
						<span class="cur-price">						
						<?foreach($arOffer["PRICES"] as $code=>$arPrice):?>
							<?if($arPrice["CAN_ACCESS"]):?>
								<?=intval($arPrice["VALUE"])?>
							<?endif;?>
						<?endforeach;?>
						</span>
						<span class="rub">руб.</span>
					</div>
					<?if($arElement["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]):?><span class="main-article" id="offer_art_<?=$arElement["ID"]?>">Артикул: <?=$arElement["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?></span>
					<?else:?>
						<span class="hline"></span>					
					<?endif?>	
				<?else:?>
					<?if($arElement["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]):?><span class="article" style="margin-top: -20px; height: 20px; display: block; font-size: 11px;" id="offer_art_<?=$arElement["ID"]?>">Артикул: <?=$arElement["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?></span><?endif?>					
				<?endif;?>
				<div class="price-wrap from-price">
					<?if(is_array($arElement["OFFERS"]) && !empty($arElement["OFFERS"])):?>
						<?foreach($arElement["OFFERS"][0]["PRICES"] as $code=>$arPrice):?>
							<?if($arPrice["CAN_ACCESS"]):?>
								<span class="rub">от</span> <?=intval($arPrice["VALUE"])?>
							<?endif;?>
						<?endforeach;?>
					<?else:?>
						<?
						if($arElement["CATALOG_QUANTITY"] > 0) $available=true;
						?>
						<?foreach($arElement["PRICES"] as $code=>$arPrice):?>
							<?if($arPrice["CAN_ACCESS"]):?>
								<?=intval($arPrice["VALUE"])?>
							<?endif;?>
						<?endforeach;?>
					<?endif;?>					
					<span class="rub">руб.</span>
					<?if($arElement["PROPERTIES"]["OLD_PRICE"]["VALUE"]):?><span class="old-price"><?=$arElement["PROPERTIES"]["OLD_PRICE"]["VALUE"]?></span><?endif;?>
				</div>
				<?if(is_array($arElement["OFFERS"]) && !empty($arElement["OFFERS"])):?>
					<div class="sec-offers-list">
						<?$first=true;
						foreach($arElement["OFFERS"] as $key=>$arOf):?>
							<div class="sec-offer-prop<?if($arOf["CATALOG_QUANTITY"] > 0 && $first):?> curr-offer<?$first=false; endif; if($arOf["CATALOG_QUANTITY"] <= 0):?> not-available<?endif?>"><a href="#" data-price='<?foreach($arOf["PRICES"] as $code=>$arPrice):?><?=intval($arPrice["VALUE"])?><?endforeach;?>' data-id='<?=$arOf["ID"]?>' data-canbuy='<?=($arOf["CATALOG_QUANTITY"] > 0 ? "Y" : "N")?>' data-max='<?=$arOf["CATALOG_QUANTITY"]?>' ><?=$arOf["PROPERTIES"]["IMYIE_CML2ATTR_FASOVKA"]["VALUE"]?></a></div>
						<?endforeach;?>
					</div>
				<?endif;?>
				<!-- end price-wrap -->
				<div class="btn-wrap">
					<a href="javascript:void(0)" <?if(!$available):?>style="display: none;"<?endif;?> class="btn-reg js-buy-link _addToCart" data-id="<?=(is_array($arElement["OFFERS"]) && !empty($arElement["OFFERS"]) ? $arOffer["ID"] : $arElement["ID"])?>" >Купить</a>
					<a href="javascript:void(0)" <?if($available):?>style="display: none;"<?endif;?> class="btn-reg _noticeMe" data-id="<?=(is_array($arElement["OFFERS"]) && !empty($arElement["OFFERS"]) ? $arOffer["ID"] : $arElement["ID"])?>" >Под заказ</a>
					<label class="like-checkbox buttonFavorite <?if(in_array($arElement["ID"], $arResult["INWISHLIST"])):?>checked<?endif;?>" rel="<?=$arElement["ID"]?>" >
						<i class="piluli-3"></i>
						<input  type="checkbox" <?if(in_array($arElement["ID"], $arResult["INWISHLIST"])):?>checked="checked"<?endif;?> />
					</label>
				</div>
				<!-- end btn-wrap -->
			</figure>
			<!-- end front -->
			<figure class="back">
				<div class="rating-wrap">
					<?if($rcount):?>
					<div class="stars" title="<?=$rating?>">
						<span><i class="piluli-<?=($rating >= 1 ? "13" : "15" )?>"></i></span>
						<span><i class="piluli-<?=($rating >= 2 ? "13" : "15" )?>"></i></span>
						<span><i class="piluli-<?=($rating >= 3 ? "13" : "15" )?>"></i></span>
						<span><i class="piluli-<?=($rating >= 4 ? "13" : "15" )?>"></i></span>
						<span><i class="piluli-<?=($rating >= 5 ? "13" : "15" )?>"></i></span>
					</div>
					<!-- end stars-->
					<span class="digit">(<?=$rcount?>)</span>
					<?endif;?>
				</div>
				<!-- end rating-wrap -->
				<div class="item-name">
					<a data-mdacl="<?=$arElement["ID"]?>" href="<?=$arElement["DETAIL_PAGE_URL"]?>" title='<?=$arElement["NAME"]?>' class="truncate-title"><?=$arElement["NAME"]?></a>
				</div>
				<?if(is_array($arElement["OFFERS"]) && !empty($arElement["OFFERS"])):?>
					<?$tmp=Array();?>
					<?foreach($arElement["OFFERS"] as $key=>$arOffer):?>
						<?
						if($arOffer["CAN_BUY"]) {
							$tmp=$arOffer;
							$available=true;
							break;
						}
						?>
					<?endforeach;?>
					<?
					if($tmp)
						$arOffer=$tmp;
					else
						$arOffer=$arElement["OFFERS"][0];
					?>
					<span class="added-to-cart added-offer"><?=( $inbasket ? $inbasket_offer["PROPERTIES"]["IMYIE_CML2ATTR_FASOVKA"]["VALUE"] : $arOffer["PROPERTIES"]["IMYIE_CML2ATTR_FASOVKA"]["VALUE"])?></span>
				<?endif?>
				<span class="added-to-cart">Добавлено в <a href="/personal/cart/">корзину</a></span>

				<div class="spinbox _plusMinus recalculate" data-id="<?=$arElement["ID"]?>">
					<a href="javascript:void(0)" class="minus buttonMinus"></a>
						<input type="text" maxlength="3" max="999" class="_addCount" value="<?=( $inbasket ? $arResult["INBASKET"][$inbasket] : 1)?>"/>
					<a href="javascript:void(0)" class="plus buttonPlus">+</a>
				</div>
				<!-- end spinbox -->
				<div class="actual-price">
					<?if(is_array($arElement["OFFERS"]) && !empty($arElement["OFFERS"])):?>
						<?if($inbasket):?>
							<?foreach($inbasket_offer["PRICES"] as $code=>$arPrice):?>
								<?if($arPrice["CAN_ACCESS"]):?>
									<span class="bprice"><?=intval($arPrice["VALUE"])?></span>
								<?endif;?>
							<?endforeach;?>
						<?else:?>
							<?foreach($arOffer["PRICES"] as $code=>$arPrice):?>
								<?if($arPrice["CAN_ACCESS"]):?>
									<span class="bprice"><?=intval($arPrice["VALUE"])?></span>
								<?endif;?>
							<?endforeach;?>
						<?endif;?>
					<?else:?>
						<?foreach($arElement["PRICES"] as $code=>$arPrice):?>
							<?if($arPrice["CAN_ACCESS"]):?>
								<span class="bprice"><?=intval($arPrice["VALUE"])?></span>
							<?endif;?>
						<?endforeach;?>
					<?endif;?>
					<span class="rub">руб.</span>
				</div>
				<!-- end price-wrap -->
				<div class="btn-wrap">
					<a href="/personal/cart/" class="btn-reg">Оформить заказ</a>
				</div>
			</figure>
			<!-- end back -->
		</div>
		<!-- end for-transform -->		
	</li>
	<?endforeach;?>
</ul>
<div style="clear: both;"></div>
<?
	if ($arParams["DISPLAY_BOTTOM_PAGER"])
	{
		?><? echo $arResult["NAV_STRING"]; ?><?
	}
}
?>
<?if(strstr($APPLICATION->GetCurDir(), "wishlist")):?><div class="sec-profile__deferred-link"><a href="/personal/wishlist/?clear=Y" >Очистить отложенное</a></div><?endif?>
</div>