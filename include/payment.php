<?
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
?><?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.payment",
	"",
Array()
);?>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script>
	$(document).ready(function () {
		$(".vampirus_yandex_submit_button").click();
	});
</script>