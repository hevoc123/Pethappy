<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Pethappy.ru - Оплата");
$APPLICATION->SetTitle("Оплата");

$APPLICATION->AddChainItem("Оплата", "");
?>
 <table class="Oplata">
	<tbody>
		<tr>
			<td><strong>Наличные при получении</strong> (вы делаете заказ, оставляете контактную информацию, указываете в пункте Оплата – «Наличными», при этом варианте оплата осуществляется курьеру при привозе заказа)<br>
			&nbsp;</td>
		</tr>
	</tbody>
</table>		
 <table class="Oplata" width="100%">
	<tbody>		
		<tr align="center">
			<td colspan="2"><img width="100%" style="max-width: 600px;" src="/images/dog-money.jpg"></td>
		</tr>
	</tbody>
</table>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>