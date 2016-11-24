<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/*
 * Module: sebekon.reminder
 */
 
 global $USER;
?>
<?if(!$arResult['PRODUCT_ID']):?>
<?if($USER->IsAdmin()):?>
	<div class="bootstrap">
		<div class="alert alert-error">
			<?=GetMessage('SEBEKON_RM_NO_PRODUCT_ID')?>
		</div>
	</div>
<?endif;?>
<?else:?>
<a name="reminder"></a>
<div class="bootstrap">
	<form method="POST" action="<?=$APPLICATION->GetCurPageParam()?>#reminder">
	<legend><?=GetMessage('SEBEKON_RM_FORM_TITLE')?></legend>
		<?if($arResult['SUCCESS']):?>
			<div class="alert alert-success">
			<?=$arParams['SUCCESS_MESSAGE']?>
			</div>
		<?else:?>			
			<?if(count($arResult['ERRORS'])>0):?>
				<div class="alert alert-error">
				<?=implode('<br/>',$arResult['ERRORS'])?>
				</div>
			<?endif;?>		
			<label><?=GetMessage('SEBEKON_RM_HELP')?></label>
			<?if($arParams['SEND_BY_PHONE']=='Y'):?>
			<div class="form-inline">
				<input size="25" value="<?=$arResult['PHONE']?>" type="text" name="PHONE" placeholder="<?=GetMessage('SEBEKON_RM_PLACEHOLDER_PHONE')?>">				
				<a class="btn" onclick="$('#input_action').val('phone'); $(this).parents('form').submit();"><?=GetMessage('SEBEKON_RM_SEND_BY_PHONE')?></a>
			</div>				
			<div class="clearfix"></div>
			<br/>
			<?endif;?>			
			<div class="form-inline">
			<input size="25" value="<?=$arResult['EMAIL']?>" type="text" name="EMAIL" placeholder="<?=GetMessage('SEBEKON_RM_PLACEHOLDER_EMAIL')?>">
			<a class="btn" onclick="$(this).parents('form').submit();"><?=GetMessage('SEBEKON_RM_SEND_BY_EMAIL')?></a>
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
			<input type="hidden" name="PRODUCT_ID" value="<?=$arResult['PRODUCT_ID']?>">
			<input type="hidden" name="action" value="email" id="input_action">	
			<input type="hidden" name="SEBEKON_RM" value="<?=htmlspecialchars($_REQUEST['SEBEKON_RM'])?>">
		<?endif;?>
	</form>
</div>
<?endif;?>