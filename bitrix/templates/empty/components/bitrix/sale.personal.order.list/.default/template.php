<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if(!empty($arResult['ERRORS']['FATAL'])):?>

	<?foreach($arResult['ERRORS']['FATAL'] as $error):?>
		<?=ShowError($error)?>
	<?endforeach?>

	<?$component = $this->__component;?>
	<?if($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED])):?>
		<?$APPLICATION->AuthForm('', false, false, 'N', false);?>
	<?endif?>

<?else:?>

	<?if(!empty($arResult['ERRORS']['NONFATAL'])):?>

		<?foreach($arResult['ERRORS']['NONFATAL'] as $error):?>
			<?=ShowError($error)?>
		<?endforeach?>

	<?endif?>

	<div class="bx_my_order_switch">

		<?$nothing = !isset($_REQUEST["filter_history"]) && !isset($_REQUEST["show_all"]);?>

		<?if($nothing || isset($_REQUEST["filter_history"])):?>
			<a class="bx_mo_link" href="<?=$arResult["CURRENT_PAGE"]?>?show_all=Y"><?=GetMessage('SPOL_ORDERS_ALL')?></a>
		<?endif?>

		<?if($_REQUEST["filter_history"] == 'Y' || $_REQUEST["show_all"] == 'Y'):?>
			<a class="bx_mo_link" href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=N"><?=GetMessage('SPOL_CUR_ORDERS')?></a>
		<?endif?>

		<?if($nothing || $_REQUEST["filter_history"] == 'N' || $_REQUEST["show_all"] == 'Y'):?>
			<a class="bx_mo_link" href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=Y"><?=GetMessage('SPOL_ORDERS_HISTORY')?></a>
		<?endif?>

	</div>

	<?if(!empty($arResult['ORDERS'])):?>

		<?foreach($arResult["ORDER_BY_STATUS"] as $key => $group):?>

			<?foreach($group as $k => $order):?>

				<?if($k=false):?>
					<div class="bx_my_order_status_desc">
						<h2><?=GetMessage("SPOL_STATUS")?> "<?=$arResult["INFO"]["STATUS"][$key]["NAME"] ?>"</h2>
						<div class="bx_mos_desc"><?=$arResult["INFO"]["STATUS"][$key]["DESCRIPTION"] ?></div>
					</div>
				<?endif?>

				<div class="sec-profile__orders" id="orders_list">
					<div class="sec-profile__order ">
						<div class="sec-profile__order-shower"><i class="piluli-angle-down"></i></div>
						<div class="clearfix" style="overflow: auto;">
							<div class="sec-profile__order-info left">
								<a href="#" class="name">Заказ № <?=$order["ORDER"]["ACCOUNT_NUMBER"]?></a>
								<span class="date"><?=$order["ORDER"]["DATE_INSERT_FORMATED"];?></span>

							</div>
							<div class="sec-profile__order-status left">
								<?if($order["ORDER"]["PAYED"] == "Y"):?>
									<i class="piluli-check-circle"></i>Оплачен
								<?elseif($order["ORDER"]["CANCELED"] == "Y"):?>
									<i class="piluli-times-circle"></i>Отменен
								<?else:?>
									<?
									switch ($order["ORDER"]["STATUS_ID"])
									{
										case "E":
											?>
											<i class="piluli-times-circle"></i>Отменен
											<?
											break;
										case "B":
											?>
											<i class="piluli-spinner"></i>Формируется к отправке
											<?
											break;
										case "C":
											?>
											<i class="piluli-spinner"></i>Отправлен
											<?
											break;
										case "F":
											?>
											<i class="piluli-spinner"></i>Заказ собран и ожидает Вас
											<?
											break;
										case "G":
											?>
											<i class="piluli-spinner"></i>Заказ передан в региональный отдел
											<?
											break;
										case "N":
											?>
											<i class="piluli-spinner"></i>Принят
											<?
											break;
										case "D":
											?>
											<i class="piluli-check-circle"></i>Выполнен
											<?
											break;
										default :
											?>
												<i class="piluli-spinner"></i>Принят
											<?

									}
									?>
								<?endif;?>
							</div>

							<div class="sec-profile__order-price left">
								<strong><?=intval($order["ORDER"]["PRICE"])?></strong> руб.
							</div>

							<div class="sec-profile__order-tools left">
								<a href="<?=$order["ORDER"]["URL_TO_COPY"]?>" class=""><i class="piluli-repeat"></i>Повторить заказ</a>
							</div>
						</div>

						<table class="sec-profile__order-sub">
							<tbody>
							<?
							$i=1;
							?>
							<?foreach ($order["BASKET_ITEMS"] as $key=>$item):?>
							<tr>
								<td><a href="<?=$item["DETAIL_PAGE_URL"]?>"><i><?=$i?>.</i><?=$item['NAME']?>.</a></td>
								<td><?=$item['QUANTITY']?> x <?=intval($item["PRICE"])?> руб.</td>
								<td><a href="<?=$item["DETAIL_PAGE_URL"]?>">Написать отзыв</a></td>
							</tr>
							<?$i++;?>
							<?endforeach?>
							</tbody>
						</table>
						<div class="sec-profile__order-additional">
							<div>Стоимость товара: <span><?=$order["ORDER"]["FORMATED_PRICE"]?></span></div>
							<div>
							<? // PAY SYSTEM ?>
							<? $paySystemList = array();?>
							<?foreach($order["PAYMENT"] as $payment):?>
								<?$paySystemList[] = $arResult['INFO']['PAY_SYSTEM'][$payment['PAY_SYSTEM_ID']]['NAME'];?>
							<?endforeach;?>

							<?if(!empty($paySystemList)):?>
								<strong><?=GetMessage('SPOL_PAYSYSTEM')?>:</strong> <?=implode(', ', $paySystemList)?> <br />
							<?endif?>

							<? // DELIVERY SYSTEM ?>
							<? $deliveryServiceList = array(); ?>
							<?foreach ($order['SHIPMENT'] as $shipment):?>
								<? $deliveryServiceList[] = $arResult['INFO']['DELIVERY'][$shipment['DELIVERY_ID']]['NAME'];?>
							<?endforeach;?>

							<?if(!empty($deliveryServiceList)):?>
								<strong><?=GetMessage('SPOL_DELIVERY')?>:</strong> <?=implode(', ', $deliveryServiceList)?> <br />
							<?endif?>
							</div>
							<?
							$dbOrderProps = CSaleOrderPropsValue::GetList(
									array("SORT" => "ASC"),
									array("ORDER_ID" => $order["ORDER"]["ID"], "CODE"=>array("LOCATION", "ADDRESS"))
							);
							while ($arOrderProps = $dbOrderProps->GetNext()):
								echo $arOrderProps["VALUE"]." ";
							endwhile;							
							?>
						</div>
					</div>
					<div class="mt20"></div>
				</div>
			<?endforeach?>
		<?endforeach?>

		<?if(strlen($arResult['NAV_STRING'])):?>
			<?=$arResult['NAV_STRING']?>
		<?endif?>

	<?else:?>
		<?=GetMessage('SPOL_NO_ORDERS')?>
	<?endif?>

<?endif?>