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

$arBasketItems = array();

$dbBasketItems = CSaleBasket::GetList(
	array(),
	array(
		 "FUSER_ID" => CSaleBasket::GetBasketUserID(),
		"LID" => SITE_ID,
		 "ORDER_ID" => "NULL"
	),
	false,
	false,
	array("*")
);

$i = 0;
while ($arItems = $dbBasketItems->Fetch())
{
	$arResult["INBASKET"][$arItems["PRODUCT_ID"]]=intval($arItems["QUANTITY"]);
	$arResult["INBASKET_ID"][]=$arItems["PRODUCT_ID"];
}

$total_rating=0;
$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "PREVIEW_TEXT", "PROPERTY_NAME", "PROPERTY_RATING", "PROPERTY_YES", "PROPERTY_NO", "PROPERTY_USER");
$arFilter = Array("IBLOCK_ID"=>13, "ACTIVE"=>"Y", "PROPERTY_CML2_LINK"=>$arResult["ID"]);
$res = CIBlockElement::GetList(Array("DATE_ACTIVE_FROM"=>"DESC"), $arFilter, false, false, $arSelect);

$rcount=$res->SelectedRowsCount();

while($ar_res= $res->GetNext())
{
	if(!$ar_res["PROPERTY_RATING_VALUE"]) $ar_res["PROPERTY_RATING_VALUE"]=5;
	$total_rating=$total_rating+$ar_res["PROPERTY_RATING_VALUE"];
}

$rating=ceil($total_rating/$rcount);
?>

<nav id="cardNav" class="card-nav with-card-small">
		<div class="card-nav-fixed">
		<ul class="card-nav-list">
			<li class=""><a href="#instructionUnit" class="js-to-scroll">Описание</a></li>
			<?if($rcount):?>
			<li>
				<a href="<?=$arResult["DETAIL_PAGE_URL"]?>/rating">
					<span class="stars" title="<?=$rating?>">
						<span><i class="piluli-<?=($rating >= 1 ? "13" : "15" )?>"></i></span>
						<span><i class="piluli-<?=($rating >= 2 ? "13" : "15" )?>"></i></span>
						<span><i class="piluli-<?=($rating >= 3 ? "13" : "15" )?>"></i></span>
						<span><i class="piluli-<?=($rating >= 4 ? "13" : "15" )?>"></i></span>
						<span><i class="piluli-<?=($rating >= 5 ? "13" : "15" )?>"></i></span>
					</span>
					Отзывы<span class="digit"><?=$rcount;?></span>
				</a>
			</li>
			<?else:?>
			<li class="">
				<a href="<?=$arResult["DETAIL_PAGE_URL"]?>/rating">
					Написать отзыв
				</a>
			</li>
			<?endif;?>
		</ul><!-- end card-nav-list -->
	</div><!-- end card-nav-fixed -->
</nav>


<div class="card-form-wrap product_item-price_buy-b _fixedCard clearfix">
	<div class="card-form">
		<div class="leftcol">
			<div class="img-wrap">
				<?if( $arResult['DETAIL_PICTURE']['SRC'] ):?>                                                                         
				<?
//					$renderImage = CFile::ResizeImageGet( $arResult['DETAIL_PICTURE']['ID'], Array( "width" => "375", "height" => "339" ), BX_RESIZE_IMAGE_PROPORTIONAL, true, $arFilter_watermark );
					$renderImage_small = CFile::ResizeImageGet( $arResult['DETAIL_PICTURE']['ID'], Array( "width" => "162", "height" => "180" ), BX_RESIZE_IMAGE_PROPORTIONAL, true );
					$renderImage_big = CFile::ResizeImageGet( $arResult['DETAIL_PICTURE']['ID'], Array( "width" => $arResult["DETAIL_PICTURE"]["WIDTH"] - 1, "height" => $arResult["DETAIL_PICTURE"]["HEIGHT"] - 1 ), BX_RESIZE_IMAGE_PROPORTIONAL, true, $arFilter_watermark );
				else:
					//$renderImage = CFile::ResizeImageGet( noimageFileID, Array( "width" => "375", "height" => "339" ), BX_RESIZE_IMAGE_PROPORTIONAL, true, $arFilter_watermark );
					$renderImage_small = CFile::ResizeImageGet( noimageFileID, Array( "width" => "162", "height" => "180" ), BX_RESIZE_IMAGE_PROPORTIONAL, true );
					$renderImage_big = CFile::ResizeImageGet( noimageFileID, Array( "width" => "600", "height" => "400" ), BX_RESIZE_IMAGE_PROPORTIONAL, true, $arFilter_watermark );
				endif;?>
				<a href="<?=$renderImage_big["src"]?>" class="fancybox">
					<img src="<?=$renderImage_small["src"]?>" title="<?=$arResult["NAME"]?>" alt="<?=$arResult["NAME"]?>" class="b-photo__img">
				</a>
				<!--span class="cat-label profit">Выгода <br/> <span>9%</span></span-->
				<label class="like-checkbox with-hint buttonFavorite" rel="<?=$arResult["ID"]?>"><i class="piluli-3"></i><input type="checkbox"><span class="hint">Отложить</span></label>
			</div>
		</div>
		<div class="rightcol for-transform">
			<ul class="details-list for-mobile">
				<?
				$available=false;
				?>
				<?if(is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"])):?>
					<?$tmp=Array();?>
					<?foreach($arResult["OFFERS"] as $key=>$arOffer):?>
						<?
						//var_dump($arOffer["CATALOG_QUANTITY"]);
						if($arOffer["CATALOG_QUANTITY"] > 0) {
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
						$arOffer=$arResult["OFFERS"][0];
					?>
					
					<?foreach($arResult["OFFERS"] as $key=>$arOff):?>
						<?if($arOff["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]):?><li class="article" id="offer_art_<?=$arOff["ID"]?>" <?if($arOff["ID"]!=$arOffer["ID"]):?>style="display: none;"<?endif;?>>Артикул: <?=$arOff["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?></li><?endif;?>
					<?endforeach;?>
				<?else:?>
					<?if($arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]):?><li>Артикул: <?=$arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?></li><?endif;?>
				<?endif;?>
				
				
				<?if($arResult["DISPLAY_PROPERTIES"]["CML2_MANUFACTURER"]["DISPLAY_VALUE"]):?><li>Производитель:  <?=$arResult["DISPLAY_PROPERTIES"]["CML2_MANUFACTURER"]["DISPLAY_VALUE"]?></li><?endif;?>
				<?/*if($arResult["PROPERTIES"]["FLAVOUR"]["VALUE"]):?>
					<?foreach($arResult["PROPERTIES"]["FLAVOUR"]["VALUE"] as $prop):?>
						<li>Вкус: <?=$prop?></li>
					<?endforeach;?>
				<?endif;?>
				<?if($arResult["PROPERTIES"]["AGE"]["VALUE"]):?><li><?=$arResult["PROPERTIES"]["AGE"]["VALUE"]?></li><?endif;?>				
				<?if($arResult["PROPERTIES"]["PORODA"]["VALUE"]):?><li>Для породы: <?=$arResult["PROPERTIES"]["PORODA"]["VALUE"]?></li><?endif;?>				
				<?if($arResult["PROPERTIES"]["SPECIAL"]["VALUE"]):?><li>Серия: <?=$arResult["PROPERTIES"]["SPECIAL"]["VALUE"]?></li><?endif;?>
				<?if($arResult["PROPERTIES"]["NAPOLNITEL"]["VALUE"]):?><li>Наполнитель: <?=$arResult["PROPERTIES"]["NAPOLNITEL"]["VALUE"]?></li><?endif;?>
				<? /*<li>Срок годности: до 01.08.2018</li>*/ ?>
			</ul>
			
			<div class="price-wrap">
				<span class="text">Цена</span>
				<span itemprop="price" class="product_item_price_digit cur-price">
					<?if(is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"])):?>
						<?if($_GET["size"]):?>
							<?foreach($arResult["OFFERS"] as $key=>$arOff):?>
								<?if($_GET["size"]==$arOff["ID"]):?>
									<?foreach($arOff["PRICES"] as $code=>$arPrice):?>
										<?if($arPrice["CAN_ACCESS"]):?>
											<?=round($arPrice["VALUE"])?>
										<?endif;?>
									<?endforeach;?>
								<?endif;?>
							<?endforeach;?>
						<?else:?>
							<?foreach($arOffer["PRICES"] as $code=>$arPrice):?>
								<?if($arPrice["CAN_ACCESS"]):?>
									<?=round($arPrice["VALUE"])?>
								<?endif;?>
							<?endforeach;?>
						<?endif;?>
					<?else:?>
						<?
						//var_dump($arResult["CATALOG_QUANTITY"]);
						if($arResult["CATALOG_QUANTITY"] > 0) $available=true;
						?>
						<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
							<?if($arPrice["CAN_ACCESS"]):?>
								<?=round($arPrice["VALUE"])?>
							<?endif;?>
						<?endforeach;?>
					<?endif;?>
				</span>				
				<span class="rub">руб.</span>
				<? /*<span class="old-price">261&nbsp;</span>*/ ?>
			</div>

			<?$curid=(is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"]) ? $arOffer["ID"] : $arResult["ID"]);?>
			
			<?if(is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"])):?>
				<div class="sec-offers-list" style="display: block;">
					<?
					$first=true;
					if($_GET["size"]) $first=false;
					foreach($arResult["OFFERS"] as $key=>$arOff):?>
						<div class="sec-offer-prop<?if(($arOff["CATALOG_QUANTITY"] > 0 && $first) || ($_GET["size"]==$arOff["ID"] && $_GET["size"]) ):?> curr-offer<?$first=false; endif; if($arOff["CATALOG_QUANTITY"] <= 0):?> not-available<?endif?>">
							<a href="#" data-inbasket='<?=( in_array($arOff["ID"], $arResult["INBASKET_ID"]) ? $arResult["INBASKET"][$arOff["ID"]] : 0 )?>' data-price='<?foreach($arOff["PRICES"] as $code=>$arPrice):?><?=round($arPrice["VALUE"])?><?endforeach;?>' data-id='<?=$arOff["ID"]?>' data-max='<?=$arOff["CATALOG_QUANTITY"]?>' data-canbuy='<?=($arOff["CATALOG_QUANTITY"] > 0 ? "Y" : "N")?>' >
								<?=$arOff["PROPERTIES"]["IMYIE_CML2ATTR_FASOVKA"]["VALUE"]?>
							</a>
						</div>
					<?endforeach;?> 
				</div>
			<?endif;?>
			<div class="btn-wrap header_recalculate">
				<?
				if($_GET["size"])
				{
					foreach($arResult["OFFERS"] as $key=>$arOff)
					{
						if($_GET["size"]==$arOff["ID"] && $arOff["CATALOG_QUANTITY"] < 1) {
							$hide = 'style="display: none;"';
							$available=false;
							$arOffer=$arOff;
						}
					}
				}
				?>
				<div class="spinbox small  _plusMinus recalculate" <?=$hide?> data-id="<?=$curid?>" data-price="<?=(is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"]) ? $arOffer["CATALOG_PRICE_2"] : $arResult["CATALOG_PRICE_2"])?>" data-min_qty="0" data-sale_price="<?=(is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"]) ? $arOffer["CATALOG_PRICE_2"] : $arResult["CATALOG_PRICE_2"])?>" data-common_price="<?=(is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"]) ? $arOffer["CATALOG_PRICE_2"] : $arResult["CATALOG_PRICE_2"])?>">
					<a href="javascript:void(0)" class="minus buttonMinus"></a>
					<input type="text" maxlength="3" max="<?=(is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"]) ? $arOffer["CATALOG_QUANTITY"] : $arResult["CATALOG_QUANTITY"])?>" class="_addCount" value="<?=( in_array($curid, $arResult["INBASKET_ID"]) ? $arResult["INBASKET"][$curid] : 1 )?>">
					<a href="javascript:void(0)" class="plus buttonPlus">+</a>
				</div><!-- end spinbox -->
				<?
				//var_dump($curid);
				//var_dump(in_array($curid, $arResult["INBASKET_ID"]));
				?>
				<a href="javascript:void(0)" <?if(!$available):?>style="display: none;"<?endif;?> class="btn-reg transform _addToCart <?=( in_array($curid, $arResult["INBASKET_ID"]) ? "in_cart" : "" )?>" data-id="<?=$curid?>"><?=( in_array($curid, $arResult["INBASKET_ID"]) ? "В корзине" : "Купить" )?></a>
				
				<a href="javascript:void(0)" style="<?if($available):?>display: none;<?endif;?> margin-bottom: 15px;" class="btn-reg _noticeMe" data-id="<?=$curid;?>" >Под заказ</a>
					
				<label class="like-checkbox buttonFavorite" rel="<?=$arResult["ID"]?>"><i class="piluli-3"></i><input type="checkbox"><span class="visible-hint">Отложить</span></label>
			</div>
		
			<div class="in-presence" <?if(!$available):?>style="display: none;"<?endif;?> id="q_av">
				<span class="text">Есть в наличии</span>
				<?
				if(is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"]) )
				{
					if($arOffer["CATALOG_QUANTITY"] < 5)
						$color="red";
					elseif($arOffer["CATALOG_QUANTITY"] < 20)
						$color="yellow";
					else
						$color="green";
				}
				else
				{
					if($arResult["CATALOG_QUANTITY"] < 5)
						$color="red";
					elseif($arResult["CATALOG_QUANTITY"] < 20)
						$color="yellow";
					else
						$color="green";					
				}
				?>
				<ul class="presence-list"> 
					<li class="<?=$color?>" style=""></li>
					<li class="<?=$color?>" style="<?if($color=="red"):?>display: none;<?endif;?>"></li>
					<li class="<?=$color?>" style="<?if($color=="red"):?>display: none;<?endif;?>"></li>
					<li class="<?=$color?>" style="<?if($color=="red" || $color=="yellow"):?>display: none;<?endif;?>"></li>
					<li class="<?=$color?>" style="<?if($color=="red" || $color=="yellow"):?>display: none;<?endif;?>"></li>
				</ul><!-- end presence-list -->
			</div>
					
			<div class="in-presence" <?if($available):?>style="display: none;"<?endif;?> id="q_os">
				<span class="text">Нет в наличии</span>
			</div>
			
			<div class="delivery">
				<?
				$hour=date("H");
				//var_dump($hour);
				?>
				<?if($hour > 20):?>
					<a href="/delivery">Доставка</a> — послезавтра, бесплатно от 2000 руб.
				<?else:?>
					<a href="/delivery">Доставка</a> — завтра, бесплатно от 2000 руб.
				<?endif;?>
			</div>					
		</div>

		<div id="instructionUnit" class="instruction-unit show-cat-wrap js-show-cat-wrap">
			<h2><?=$arResult["NAME"]?>, описание:</h2>
			<ul class="action-list">
				<li><a href="javascript:void(0)" id="download_version"><i class="piluli-38"></i><span class="regular">Сохранить в PDF</span><span class="for-mobile">Скачать PDF</span></a></li>
				<li><a href="javascript:void(0)" id="print_version"><i class="piluli-39"></i>Напечатать</a></li>
				<li>
					<div class="social-module social-likes social-likes_visible" data-counters="no">
											
					<script type="text/javascript">(function(w,doc) {
					if (!w.__utlWdgt ) {
						w.__utlWdgt = true;
						var d = doc, s = d.createElement('script'), g = 'getElementsByTagName';
						s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
						s.src = ('https:' == w.location.protocol ? 'https' : 'http')  + '://w.uptolike.com/widgets/v1/uptolike.js';
						var h=d[g]('body')[0];
						h.appendChild(s);
					}})(window,document);
					</script>
					<div data-background-alpha="0.0" data-buttons-color="#ffffff" data-counter-background-color="#ffffff" data-share-counter-size="10" data-top-button="false" data-share-counter-type="disable" data-share-style="1" data-mode="share" data-like-text-enable="false" data-mobile-view="true" data-icon-color="#ffffff" data-orientation="horizontal" data-text-color="#000000" data-share-shape="round" data-sn-ids="fb.vk.tw.ok.gp.mr." data-share-size="30" data-background-color="#ffffff" data-preview-mobile="false" data-mobile-sn-ids="fb.vk.tw.wh.ok.vb." data-pid="1583200" data-counter-background-alpha="1.0" data-following-enable="false" data-exclude-show-more="true" data-selection-enable="false" class="uptolike-buttons" ></div>
										
					</div><!-- end social-module -->
				</li>
				<li>				
					<span class="regular">Поделиться в соцсетях</span>
					<a href="#" class="for-mobile js-mobile-social"><i class="piluli-50"></i><span>Поделиться в соцсетях</span></a>
				</li>
			</ul>
			<div class="js-show-cat-block">
				<?=$arResult["DETAIL_TEXT"]?>
			</div>
		</div>

	</div>
	
	<div class="advert-block">
		<div id="relatedUnit">
			<div class="pseudo_h3">C этим товаром покупают</div>	
			<div class="slider-vertical js-ws-vertical-slider slick-initialized" >
				<?
				foreach($arResult["LIKETHIS"] as $arItem):
					if( $arItem['DETAIL_PICTURE'] )
						$renderImage_small = CFile::ResizeImageGet( $arItem['DETAIL_PICTURE'], Array( "width" => "70", "height" => "109" ), BX_RESIZE_IMAGE_PROPORTIONAL, true );
					else
						$renderImage_small = CFile::ResizeImageGet( noimageFileID, Array( "width" => "70", "height" => "109" ), BX_RESIZE_IMAGE_PROPORTIONAL, true );
					?>
					<div class="slide">
						<div class="slide-item">
							<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="img-wrap"><img src="<?=$renderImage_small["src"]?>" alt="<?=$arItem["NAME"]?>" /></a>
							<div class="details">
								<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="title"><?=$arItem["NAME"]?></a>
								<div class="price-wrap"><?=intval($arItem["CATALOG_PRICE_2"])?> <span class="rub">руб.</span></div>
								<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="btn-reg _addToCart" data-id="<?=$arItem["ID"]?>">Купить</a>
							</div>
						</div>
					</div>
					<?
				endforeach;
				?>		
			</div>
		</div>
	</div>
	
	
</div>

<script>
	$(function () {
		$('#print_version').on('click', function () {
			var link_q = document.location.href;
			if (link_q.match(/[?]/) == '?') {
				var loc = window.location.href.split('&');
				window.open(loc[0] + '&print=Y');
			} else {
				var loc = window.location.href.split('?');
				window.open(loc[0] + '?print=Y');
			}
		});
		$('#download_version').on('click', function () {
			var link_q = document.location.href;
			if (link_q.match(/[?]/) == '?') {
				var loc = window.location.href.split('&');
				window.open(loc[0] + '&download=Y');
			} else {
				var loc = window.location.href.split('?');
				window.open(loc[0] + '?download=Y');
			}
		});

		var o_top = parseInt($("#cardNav ul.card-nav-list").outerHeight()) + 60 + 15;
		$('#fastMenu .fast-menu-fixed').css({'top': o_top});
	});

</script>
