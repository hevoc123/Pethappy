<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$APPLICATION->SetTitle("Войти");
?>
<div class="sec-xs-auth">

<?
if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
	ShowMessage($arResult['ERROR_MESSAGE']);
?>

<?if($arResult["FORM_TYPE"] == "login"):?>

<form name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
<?if($arResult["BACKURL"] <> ''):?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?endif?>
<?foreach ($arResult["POST"] as $key => $value):?>
	<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
<?endforeach?>
	<input type="hidden" name="AUTH_FORM" value="Y" />
	<input type="hidden" name="TYPE" value="AUTH" />
	<p>Авторизация покупателя:</p>
	<label class="for-input">
		<input class="b-form-input-text" type="text" name="USER_LOGIN" maxlength="50" id="log_autoriz" value="<?=$arResult["USER_LOGIN"]?>" size="17" placeholder="Электронная почта" /></td>
	</label>
	<label class="for-input">
		<input class="b-form-input-text" type="password" name="USER_PASSWORD" id="pass_autoriz" maxlength="50" size="17" autocomplete="off" placeholder="Пароль" />
	</label>

	<input type="checkbox" style="display: none;" checked="checked" id="USER_REMEMBER_frm" name="USER_REMEMBER" value="Y" /></td>
		
	<?if ($arResult["CAPTCHA_CODE"]):?>
		<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
		<p><img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /></p>
		<input type="text" class="b-form-input-text" name="captcha_word" maxlength="50" value="" placeholder="Код с картинки" /></td>
	<?endif?>

	<input type="submit" style="display: none;" name="Login" value="<?=GetMessage("AUTH_LOGIN_BUTTON")?>" />
	
	<p><noindex><a href="/auth/forgot/" class="forgotpass-link">Забыли пароль?</a></noindex></p>
	
	<div class="btn-wrap">
		<a href="javascript:void(0)" onclick="$(this).closest('form').submit()" class="btn-reg js-submit-btn">Войти</a>
		<a href="<?=$arResult["AUTH_REGISTER_URL"]?>" rel="nofollow" class="btn-link">Зарегистрироваться</a>
	</div>

	<?if($arResult["AUTH_SERVICES"]):?>
			<tr>
				<td colspan="2">
					<div class="bx-auth-lbl"><?=GetMessage("socserv_as_user_form")?></div>
					<?
					$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "icons", 
						array(
							"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
							"SUFFIX"=>"form",
						), 
						$component, 
						array("HIDE_ICONS"=>"Y")
					);
					?>
				</td>
			</tr>
	<?endif?>

</form>

<?if($arResult["AUTH_SERVICES"]):?>
	<?
	$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "", 
		array(
			"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
			"AUTH_URL"=>$arResult["AUTH_URL"],
			"POST"=>$arResult["POST"],
			"POPUP"=>"Y",
			"SUFFIX"=>"form",
		), 
		$component, 
		array("HIDE_ICONS"=>"Y")
	);
	?>
<?endif?>
<?
else:
	LocalRedirect("/personal/");
?>
<?endif?>
</div>
<table width="100%">
	<tbody>		
		<tr align="center">
			<td colspan="2"><img width="100%" style="max-width: 600px;" src="/images/dog-login.jpg"></td>
		</tr>
	</tbody>
</table>
	