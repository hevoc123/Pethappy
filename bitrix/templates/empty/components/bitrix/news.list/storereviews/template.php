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
<div id="reviews_tabs">
    <div id="tab_reviews_customers" class="dn" style="display: block;">
		<a href="#" class="btn-reg js-show-review-form mb30">Оставить отзыв</a>				
		<form action="/include/add_review_store.php" method="POST" class="ws-review-form dn" id="commentform">
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
		</script>
		
		<ul class="reviews-list">
		<?if($arParams["DISPLAY_TOP_PAGER"]):?>
			<?=$arResult["NAV_STRING"]?><br />
		<?endif;?>
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
			<li id="<?=$this->GetEditAreaId($arItem['ID']);?>" data-rid="<?=$arItem['ID']?>" class="wsc-row" itemscope="" itemtype="http://schema.org/Review">
				<?
				$rating=$arItem["PROPERTIES"]["RATING"]["VALUE"];
				?>
				<div class="reviews-head">
					<meta itemprop="itemReviewed" content="Интернет-магазин Pethappy.ru">
					<span class="author" itemprop="author"><?=$arItem["NAME"]?></span>
					<span class="date"><?=$arItem["DATE_ACTIVE_FROM"]?></span>
					<?if($rating):?>
					<span class="stars">
						<span><i class="piluli-<?=($rating >= 1 ? "13" : "15" )?>"></i></span>
						<span><i class="piluli-<?=($rating >= 2 ? "13" : "15" )?>"></i></span>
						<span><i class="piluli-<?=($rating >= 3 ? "13" : "15" )?>"></i></span>
						<span><i class="piluli-<?=($rating >= 4 ? "13" : "15" )?>"></i></span>
						<span><i class="piluli-<?=($rating >= 5 ? "13" : "15" )?>"></i></span>
					</span>
					<?endif;?>
				</div><!-- end reviews-head -->
				
				<p itemprop="reviewBody"><?=$arItem["PREVIEW_TEXT"]?></p>
				
				<div class="evaluate-review">
					<a href="#" class="reply-link <?if($USER->IsAuthorized()):?>wsc-answer-link<?else:?>__show-enter-form<?endif;?>" data-id="<?=$arItem["ID"]?>">Ответить<i class="piluli-46"></i></a>
					<div class="next-row">
						<?/*<a href="#" class="reply-link __show-enter-form">Ответить<i class="piluli-46"></i></a>*/ ?>
						<div class="social-module light">
							<!-- component.comments comments-v_shared_btns START -->
							<a class="vk" href="#" title="Расшарить Вконтакте" onclick="window.open('http://vkontakte.ru/share.php?url=<?=urlencode("http://pethappy.ru/storereviews");?>&amp;title=<?=urlencode(iconv('windows-1251', 'utf-8', "Интернет-магазин зоотоваров Pethappy.ru"))?>&amp;image=<?=urlencode("http://pethappy.ru/bitrix/templates/empty/img/logo.png")?>&amp;description=<?=urlencode(iconv('windows-1251', 'utf-8',$arItem["PREVIEW_TEXT"]))?>','', 'scrollbars=yes,resizable=no,width=560,height=350,top='+Math.floor((screen.height - 350)/2-14)+',left='+Math.floor((screen.width - 560)/2-5)); return false;">
								<i class="piluli-10"></i>
							</a>
							<a class="fb" href="#" title="Расшарить в Facebook" onclick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?=urlencode(iconv('windows-1251', 'utf-8', "Интернет-магазин зоотоваров Pethappy.ru"))?>&amp;p[summary]=<?=urlencode(iconv('windows-1251', 'utf-8',$arItem["PREVIEW_TEXT"]))?>&amp;p[url]=<?=urlencode("http://pethappy.ru/storereviews");?>&amp;p[images][0]=<?=urlencode("http://pethappy.ru/bitrix/templates/empty/img/logo.png")?>','sharer', 'toolbar=0,status=0,width=560,height=350,top='+Math.floor((screen.height - 350)/2-14)+',left='+Math.floor((screen.width - 560)/2-5));return false; ">
								<i class="piluli-11"></i>
							</a>
							<a class="ok" href="#" title="Расшарить в Одноклассники" onclick="window.open('http://www.odnoklassniki.ru/dk?st.cmd=addShare&amp;st.s=1&amp;st._surl=<?=urlencode("http://pethappy.ru/storereviews");?>&amp;st.comments=<?=urlencode(iconv('windows-1251', 'utf-8',$arItem["PREVIEW_TEXT"]))?>', '', 'scrollbars=yes,resizable=no,width=620,height=450,top='+Math.floor((screen.height - 450)/2-14)+',left='+Math.floor((screen.width - 620)/2-5)); return false;">
								<i class="piluli-12"></i>
							</a>
							<!-- component.comments comments-v_shared_btns END -->
						</div>
					</div><!-- end next-row-->
				</div>
				<?
				$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "PREVIEW_TEXT", "PROPERTY_NAME", "PROPERTY_RATING", "PROPERTY_USER");
				$arFilter = Array("IBLOCK_ID"=>15, "ACTIVE"=>"Y", "PROPERTY_OTVET"=>$arItem["ID"]);
				$res = CIBlockElement::GetList(Array("DATE_ACTIVE_FROM"=>"DESC"), $arFilter, false, false, $arSelect);
				if($res->SelectedRowsCount() > 0):
				while($ar_res= $res->GetNext())
				{
					$rating=($ar_res["PROPERTY_RATING_VALUE"] ? $ar_res["PROPERTY_RATING_VALUE"] : 5 );
					?>
					<div class="reply-unit">
						<div class="reviews-head">
							<span class="author"><?=$ar_res["NAME"]?></span>
							<span class="reply-to"><i class="piluli-46"></i> <?=$arItem["NAME"]?></span>
							<span class="date"><?=$ar_res["DATE_ACTIVE_FROM"]?></span>
						</div>
						<p><?=$ar_res["PREVIEW_TEXT"]?></p>
					</div>
					<?
				}
				endif;
				?>
			</li>
		<?endforeach;?>
		</ul>
		<!-- component.comments comments-v_answer_form START -->
		<div id="wsc-donor" style="display:none!important">
			<div class="wsc-form-answer reply-unit textarea-field">
				<div class="textarea-heading">
					<div class="pseudo_h5">Оставьте комментарий к отзыву</div>
						<div class="evaluate-review">
					
						</div>
							</div>
				<label class="for-textarea"><textarea cols="30" rows="10" name="text_ans"></textarea></label>
				<div class="btn-wrap"><a href="javascript:void(0)" class="btn-reg">Отправить</a></div>
			</div>
		</div>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
			<br /><?=$arResult["NAV_STRING"]?>
		<?endif;?>		
	</div>
</div>
<br />