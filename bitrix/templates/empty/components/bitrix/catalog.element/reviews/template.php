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
?>

<div class="card-form-wrap product_item-price_buy-b _fixedCard clearfix">
	<div class="card-form" style="max-width: none;">
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
						<?foreach($arOffer["PRICES"] as $code=>$arPrice):?>
							<?if($arPrice["CAN_ACCESS"]):?>
								<?=round($arPrice["VALUE"])?>
							<?endif;?>
						<?endforeach;?>
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
					<?$first=true;
					foreach($arResult["OFFERS"] as $key=>$arOff):?>
						<div class="sec-offer-prop<?if($arOff["CATALOG_QUANTITY"] > 0 && $first):?> curr-offer<?$first=false; endif; if($arOff["CATALOG_QUANTITY"] <= 0):?> not-available<?endif?>">
							<a href="#" data-inbasket='<?=( in_array($arOff["ID"], $arResult["INBASKET_ID"]) ? $arResult["INBASKET"][$arOff["ID"]] : 0 )?>' data-price='<?foreach($arOff["PRICES"] as $code=>$arPrice):?><?=round($arPrice["VALUE"])?><?endforeach;?>' data-id='<?=$arOff["ID"]?>' data-max='<?=$arOff["CATALOG_QUANTITY"]?>' data-canbuy='<?=($arOff["CATALOG_QUANTITY"] > 0 ? "Y" : "N")?>' >
								<?=$arOff["PROPERTIES"]["IMYIE_CML2ATTR_FASOVKA"]["VALUE"]?>
							</a>
						</div>
					<?endforeach;?> 
				</div>
			<?endif;?>
					

			<div class="btn-wrap header_recalculate">
				<div class="spinbox small  _plusMinus recalculate" data-id="<?=$curid?>" data-price="<?=(is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"]) ? $arOffer["CATALOG_PRICE_2"] : $arResult["CATALOG_PRICE_2"])?>" data-min_qty="0" data-sale_price="<?=(is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"]) ? $arOffer["CATALOG_PRICE_2"] : $arResult["CATALOG_PRICE_2"])?>" data-common_price="<?=(is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"]) ? $arOffer["CATALOG_PRICE_2"] : $arResult["CATALOG_PRICE_2"])?>">
					<a href="javascript:void(0)" class="minus buttonMinus"></a>
					<input type="text" maxlength="3" max="<?=(is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"]) ? $arOffer["CATALOG_QUANTITY"] : $arResult["CATALOG_QUANTITY"])?>" class="_addCount" value="<?=( in_array($curid, $arResult["INBASKET_ID"]) ? $arResult["INBASKET"][$curid] : 1 )?>">
					<a href="javascript:void(0)" class="plus buttonPlus">+</a>
				</div><!-- end spinbox -->
				<?
				//var_dump($curid);
				//var_dump(in_array($curid, $arResult["INBASKET_ID"]));
				?>
				<a href="javascript:void(0)" <?if(!$available):?>style="display: none;"<?endif;?> class="btn-reg _addToCart <?=( in_array($curid, $arResult["INBASKET_ID"]) ? "in_cart" : "" )?>" data-id="<?=$curid?>"><?=( in_array($curid, $arResult["INBASKET_ID"]) ? "В корзине" : "Купить" )?></a> 
				
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
					
		</div>

		<div id="instructionUnit" class="instruction-unit show-cat-wrap js-show-cat-wrap">
			<h2>Отзывы о продукте <a href="<?=$arResult["DETAIL_PAGE_URL"]?>"><?=$arResult["NAME"]?></a>:</h2>
			<div id="reviews_tabs">

            <div id="tab_reviews_customers" class="dn" style="display: block;">

                <!-- component.comments comments-v_review_form_default START -->	<a href="#" class="btn-reg js-show-review-form mb30">Оставить отзыв</a>

				<form action="/include/add_review.php" method="POST" class="ws-review-form dn" id="commentform">
					<div>
						<div class="review-form__title">Оставить отзыв</div>

							<input type="hidden" name="products_id" value="<?=$arResult["ID"]?>">
							<?if(!$USER->IsAuthorized()):?>
							<div class="review-form__field ws-fio-input">
								<input type="text" placeholder="ФИО" name="reviews_name" style="background: transparent;">
							</div>

							<div class="review-form__field">
								<input type="text" placeholder="Электронная почта" name="reviews_email">
							</div>
							<?endif;?>

						<div class="review-form__field">
							<textarea placeholder="Ваш отзыв" name="reviews_text"></textarea>
						</div>
						<div class="review-form__field" style="max-width: 300px;">	
									</div>

						<div class="review-form__tools">
							<div class="review-form__rating left">
								<span class="review-form__rating-label">Поставьте оценку</span>

								<div class="stars js-stars">
									<a class="full" href="#"><i class="piluli-13"></i><i class="piluli-15"></i></a>
									<a class="full" href="#"><i class="piluli-13"></i><i class="piluli-15"></i></a>
									<a class="full" href="#"><i class="piluli-13"></i><i class="piluli-15"></i></a>
									<a class="full" href="#"><i class="piluli-13"></i><i class="piluli-15"></i></a>
									<a class="full" href="#"><i class="piluli-15"></i><i class="piluli-13"></i></a>
								</div>
							</div>

							<div class="review-form__submit right">
								<a href="#" class="btn-reg __send_review">Отправить отзыв</a>
							</div>
							
							<div style="padding:0 0 20px"></div>
						</div>
					</div>
				</form>
	
				<script>
					$(function(){
						var fid = '#commentform';
						$(fid).on('click', 'input', function(){
							$(fid).find('input').each(function(){
								wsPoperValid.hidePoper($(this));
							});
						});
					});
				</script><!-- component.comments comments-v_review_form_default END -->
				<ul class="reviews-list">				
                <?
				$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "PREVIEW_TEXT", "PROPERTY_NAME", "PROPERTY_RATING", "PROPERTY_YES", "PROPERTY_NO", "PROPERTY_USER");
				$arFilter = Array("IBLOCK_ID"=>13, "ACTIVE"=>"Y", "PROPERTY_CML2_LINK"=>$arResult["ID"]);
				$res = CIBlockElement::GetList(Array("DATE_ACTIVE_FROM"=>"DESC"), $arFilter, false, false, $arSelect);
				if($res->SelectedRowsCount() > 0):
				while($ar_res= $res->GetNext())
				{
						$rating=($ar_res["PROPERTY_RATING_VALUE"] ? $ar_res["PROPERTY_RATING_VALUE"] : 5 );
				?>
						<!-- component.comments comments-v_comment_item START -->
						<li id="review_<?=$ar_res["ID"]?>" data-rid="<?=$ar_res["ID"]?>"  data-pid="<?=$arResult["ID"]?>" class="wsc-row" itemscope="" itemtype="http://schema.org/Review">
							<div class="reviews-head">
								<meta itemprop="itemReviewed" content="Интернет-магазин Pethappy.ru">
								<span class="author" itemprop="author"><?=$ar_res["PROPERTY_NAME_VALUE"]?></span>
								<span class="date"><?=$ar_res["DATE_ACTIVE_FROM"]?></span>
								<span class="stars">
									<span><i class="piluli-<?=($rating >= 1 ? "13" : "15" )?>"></i></span>
									<span><i class="piluli-<?=($rating >= 2 ? "13" : "15" )?>"></i></span>
									<span><i class="piluli-<?=($rating >= 3 ? "13" : "15" )?>"></i></span>
									<span><i class="piluli-<?=($rating >= 4 ? "13" : "15" )?>"></i></span>
									<span><i class="piluli-<?=($rating >= 5 ? "13" : "15" )?>"></i></span>
								</span>
							</div><!-- end reviews-head -->
							<p itemprop="reviewBody"><?=$ar_res["~PREVIEW_TEXT"]?></p>
							<div class="evaluate-review">
								<span class="title">Опыт полезен?</span>
								<div class="evaluate-link-wrap">
									<div class="evaluate-link-unit">
										<a href="#" class="evaluate-link plus __reviewPlus"><i class="piluli-44 "></i></a><span class="digit"><?=($ar_res["PROPERTY_YES_VALUE"] ? $ar_res["PROPERTY_YES_VALUE"] : "0" )?></span>
									</div>
									<div class="evaluate-link-unit">
										<a href="#" class="evaluate-link minus __reviewMinus"><i class="piluli-45 "></i></a><span class="digit"><?=($ar_res["PROPERTY_NO_VALUE"] ? $ar_res["PROPERTY_NO_VALUE"] : "0" )?></span>
									</div>
								</div>
								<div class="next-row">
									<?/*<a href="#" class="reply-link __show-enter-form">Ответить<i class="piluli-46"></i></a>*/ ?>
									<div class="social-module light">
										<!-- component.comments comments-v_shared_btns START -->
										<a class="vk" href="#" title="Расшарить Вконтакте" onclick="window.open('http://vkontakte.ru/share.php?url=<?=urlencode("http://pethappy.ru".$arResult["DETAIL_PAGE_URL"]."/rating");?>&amp;title=<?=urlencode(iconv('windows-1251', 'utf-8',$arResult["NAME"]))?>&amp;image=<?=urlencode("http://pethappy.ru/bitrix/templates/empty/img/logo.png")?>&amp;description=<?=urlencode(iconv('windows-1251', 'utf-8',$ar_res["PREVIEW_TEXT"]))?>','', 'scrollbars=yes,resizable=no,width=560,height=350,top='+Math.floor((screen.height - 350)/2-14)+',left='+Math.floor((screen.width - 560)/2-5)); return false;">
											<i class="piluli-10"></i>
										</a>
										<a class="fb" href="#" title="Расшарить в Facebook" onclick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?=urlencode(iconv('windows-1251', 'utf-8',$arResult["NAME"]))?>&amp;p[summary]=<?=urlencode(iconv('windows-1251', 'utf-8',$ar_res["PREVIEW_TEXT"]))?>&amp;p[url]=<?=urlencode("http://pethappy.ru".$arResult["DETAIL_PAGE_URL"]."/rating");?>&amp;p[images][0]=<?=urlencode("http://pethappy.ru/bitrix/templates/empty/img/logo.png")?>','sharer', 'toolbar=0,status=0,width=560,height=350,top='+Math.floor((screen.height - 350)/2-14)+',left='+Math.floor((screen.width - 560)/2-5));return false; ">
											<i class="piluli-11"></i>
										</a>
										<a class="ok" href="#" title="Расшарить в Одноклассники" onclick="window.open('http://www.odnoklassniki.ru/dk?st.cmd=addShare&amp;st.s=1&amp;st._surl=<?=urlencode("http://pethappy.ru".$arResult["DETAIL_PAGE_URL"]."/rating");?>&amp;st.comments=<?=urlencode(iconv('windows-1251', 'utf-8',$ar_res["PREVIEW_TEXT"]))?>', '', 'scrollbars=yes,resizable=no,width=620,height=450,top='+Math.floor((screen.height - 450)/2-14)+',left='+Math.floor((screen.width - 620)/2-5)); return false;">
											<i class="piluli-12"></i>
										</a>
										<!-- component.comments comments-v_shared_btns END -->
									</div>
								</div><!-- end next-row-->
							</div><!-- end evaluate-review -->
						</li>
					<!-- component.comments comments-v_comment_item END -->
				<?
				}
				endif;?>
				</ul>				
				<? /*<!-- component.comments comments-v_answer_form START -->
				<div id="wsc-donor" style="display:none!important">
					<div class="wsc-form-answer reply-unit textarea-field">
						<div class="textarea-heading">
							<div class="pseudo_h5">Оставьте комментарий к отзыву</div>
											<div class="evaluate-review">
									<span class="title">Опыт полезен?</span>
									<div class="evaluate-link-wrap">
										<div class="evaluate-link-unit">
											<a href="#" class="evaluate-link plus __reviewPlus">
												<i class="piluli-44"></i>
											</a>
											<span class="digit">5</span>
										</div>
										<div class="evaluate-link-unit">
											<a href="#" class="evaluate-link minus __reviewMinus">
												<i class="piluli-45"></i>
											</a>
											<span class="digit">16</span>
										</div>
									</div>
								</div>
									</div>
						<label class="for-textarea"><textarea cols="30" rows="10" name="text_ans"></textarea></label>
						<div class="btn-wrap"><a href="javascript:void(0)" class="btn-reg">Отправить</a></div>
					</div>
				</div>*/ ?>


			<!-- component.comments comments-v_answer_form END -->
            </div>
					
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
