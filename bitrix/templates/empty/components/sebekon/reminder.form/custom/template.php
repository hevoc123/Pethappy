<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/*
 * Module: sebekon.reminder
 */
 
 global $USER;
?>
		<div id="sku-modal" class="white_popup_block reminder">
			<div class="popup_header">
				<?
				$elem = CIBlockElement::GetByID($_REQUEST["ID"])->GetNext();
				?>
				<h2 class="h2-title">Заказать</h2>
				<br />
				<b><?=$elem["NAME"]?></b>
			</div>
			<div class="popup_wrap" id="sku_select">
				<a href="/personal/cart/" class="icon-custom icon-mail"></a>
			
<?if(!$arResult['PRODUCT_ID']):?>
	<?if($USER->IsAdmin()):?>
		<div class="bootstrap">
			<div class="alert alert-error" style="background-color: #ffffff; color: #f1665e; border: none;">
				<?=GetMessage('SEBEKON_RM_NO_ID')?>
			</div>
		</div>
	<?endif;?>
<?else:?>
<a name="reminder"></a>
<div class="bootstrap">
	<form method="POST" action="<?=$APPLICATION->GetCurPageParam()?>#reminder">
		<?if($arResult['SUCCESS']):?>
			<div class="alert alert-success">
			<?=$arParams['SUCCESS_MESSAGE']?>
			</div>
		<?else:?>			
			<?if(count($arResult['ERRORS'])>0):?>
				<div class="alert alert-error">
				<?=implode('<br/>',$arResult['ERRORS'])?>
				</div>
			<?else:?>
				<label>После получения Вашей заявки, наши менеджеры сообщат Вам сроки поставки и точную цену товара. В письме также будет ссылка на оформление заказа, которая будет действовать в течение 24 часов. С ее помощью Вы сможете сделать заказ, тем самым завершив процедуру оформления.</label>
			<?endif;?>

			<div class="form-inline">
				<input size="25" class="grey-text-field"  value="<?=$arResult['FIO']?>" type="text" name="FIO" placeholder="Имя">
			</div>

			<div class="form-inline">
				<input size="25" class="grey-text-field"  value="<?=$arResult['PHONE']?>" type="text" name="PHONE" placeholder="<?=GetMessage('SEBEKON_RM_PLACEHOLDER_PHONE')?>">
			</div>

			<div class="form-inline">
				<input size="25" class="grey-text-field" value="<?=$arResult['EMAIL']?>" type="text" name="EMAIL" placeholder="<?=GetMessage('SEBEKON_RM_PLACEHOLDER_EMAIL')?>">
			</div>

			<div class="form-inline">
				<input size="15" class="grey-text-field" style="width: 110px" value="<?=$arResult['QUANTITY']?>" type="text" name="QUANTITY" placeholder="Количество">
				<a class="btn-reg reminder_btn" onclick="$(this).parents('form').submit();">Отправить заказ</a>
			</div>

			<?if($arParams["USE_CAPTCHA"] == "Y" && $arParams["ID"] <= 0):?>			
			<div class="clearfix"></div>
			<br/>
				<div class="form-inline">
					<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
					<input type="text" name="captcha_word" maxlength="50" value="" placeholder="<?=GetMessage('SEBEKON_RM_FORM_CAPTCHA_PROMPT')?>">
					<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" style="margin-bottom: -17px;"/>
				</div>
			<?endif?>
			<input type="hidden" name="ID" value="<?=$arResult['PRODUCT_ID']?>">
			<input type="hidden" name="action" value="email" id="input_action">	
			<input type="hidden" name="SEBEKON_RM" value="<?=htmlspecialchars($_REQUEST['SEBEKON_RM'])?>">
		<?endif;?>
	</form>
</div>
<?endif;?>

			</div>
		</div>