<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if ($arParams["SET_TITLE"] == "Y")
	$APPLICATION->SetTitle(Bitrix\Main\Localization\Loc::getMessage("SOA_ORDER_COMPLETE"));

if (!empty($arResult["ORDER"]))
{
	//var_dump($arResult["ORDER"]);
	?>
	<div class="success_order">
			<h2 class="h1-title">Спасибо за заказ!</h2>
			<p class="p-text">Ваш заказ успешно принят, номер вашего заказа №<span class="order_num"><?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?></span> <br>для подтверждения заказа с вами свяжется наш менеджер</p>
			
				Сумма заказа: <b><?=floatval($arResult["ORDER"]["PRICE"]-$arResult["ORDER"]["PRICE_DELIVERY"])?> руб</b><br>
				<?if(floatval($arResult["ORDER"]["PRICE_DELIVERY"]) > 1):?>
					Стоимость доставки: <b><?=floatval($arResult["ORDER"]["PRICE_DELIVERY"])?> руб</b><br>
				<?endif;?>
				<br>
				Итого к оплате: <span class="total order_num" id="total_forpay_text"><?=floatval($arResult["ORDER"]["PRICE"])?> руб</span><br>
				
				<div class="ordering-green-header" style="margin: 20px 0"></div>
					<?
					if (!empty($arResult["PAY_SYSTEM"]))
					{
						?>
							<?
							if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0)
							{
								?>

										<?
										$service = \Bitrix\Sale\PaySystem\Manager::getObjectById($arResult["ORDER"]['PAY_SYSTEM_ID']);

										if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y" && $arResult["PAY_SYSTEM"]["IS_CASH"] != "Y")
										{
											?>
											<script language="JavaScript">
												window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))?>&PAYMENT_ID=<?=$arResult['ORDER']["PAYMENT_ID"]?>');
											</script>
											<?= GetMessage("SOA_PAY_LINK", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&PAYMENT_ID=".$arResult['ORDER']["PAYMENT_ID"]))?>
											<?
											if (CSalePdf::isPdfAvailable() && $service->isAffordPdf())
											{
												?><br />
												<?= GetMessage("SOA_PAY_PDF", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&pdf=1&DOWNLOAD=Y")) ?>
												<?
											}
										}
										else
										{
											if ($arResult["PS_ERROR"] === true)
												echo '<span style="color:red;">'.GetMessage("SOA_ORDER_PS_ERROR").'</span>';
											else
												echo $arResult["PAY_SYSTEM"]["BUFFERED_OUTPUT"];
										}
										?>
								<?
							}
							?>
						<?
					}
					else if ($arResult["PS_ERROR"] === true)
					{
						echo '<span style="color:red;">'.GetMessage("SOA_ORDER_PS_ERROR").'</span>';
					}
					?>
				
	</div>	
			
	<?
}
else
{
	?>
	<b><?=GetMessage("SOA_ERROR_ORDER")?></b><br /><br />

	<table class="sale_order_full_table">
		<tr>
			<td>
				<?=GetMessage("SOA_ERROR_ORDER_LOST", Array("#ORDER_ID#" => $arResult["ACCOUNT_NUMBER"]))?>
				<?=GetMessage("SOA_ERROR_ORDER_LOST1")?>
			</td>
		</tr>
	</table>
	<?
}
?>