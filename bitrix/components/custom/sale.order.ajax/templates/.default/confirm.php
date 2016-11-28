<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (!empty($arResult["ORDER"]))
{
	if ($arParams["SET_TITLE"] == "Y")
		$APPLICATION->SetTitle(Bitrix\Main\Localization\Loc::getMessage("SOA_ORDER_COMPLETE"));
	?>
	<div class="success_order">
			<h2 class="h1-title">������� �� �����!</h2>
			<p class="p-text">��� ����� ������� ������, ����� ������ ������ �<span class="order_num"><?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?></span> <br>��� ������������� ������ � ���� �������� ��� ��������</p>
			
				����� ������: <b><?=floatval($arResult["ORDER"]["PRICE"]-$arResult["ORDER"]["PRICE_DELIVERY"])?> ���</b><br>
				<?if(floatval($arResult["ORDER"]["PRICE_DELIVERY"]) > 1):?>
					��������� ��������: <b><?=floatval($arResult["ORDER"]["PRICE_DELIVERY"])?> ���</b><br>
				<?endif;?>
				<br>
				����� � ������: <span class="total order_num" id="total_forpay_text"><?=floatval($arResult["ORDER"]["PRICE"])?> ���</span><br>
				
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
    if ($arParams["SET_TITLE"] == "Y")
        $APPLICATION->SetTitle("������");
	?>
	<b><?=GetMessage("SOA_ERROR_ORDER")?></b><br /><br />

	<table class="sale_order_full_table">
		<tr>
			<td>
				�������������, ����� ������������� ���� ������<br />
			</td>
		</tr>
	</table>
    <table width="100%">
        <tbody>
        <tr>
            <td style="text-align: center">
                <img style="max-width: 425px; width: 100%;" src="/images/password.jpg">
            </td>
        </tr>
        </tbody>
    </table>
	<?
}
?>