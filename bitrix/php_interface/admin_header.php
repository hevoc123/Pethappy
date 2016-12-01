<?
CUtil::InitJSCore();
CJSCore::Init(array("jquery"));
?>
<script>
    $(document).ready(function() {
        <?
        if($APPLICATION->GetCurPage() == "/bitrix/admin/sale_order_view.php"):
        ?>
        phoneRegexPattern = /\((\d+)\)\s?(.*)/;

        var order_id = $(".adm-bus-orderinfoblock-title").text();

        // Тестируем и результаты в matches
        matches = order_id.match(phoneRegexPattern);
        // matches = ["(701) 856-36-56", "701", "856-36-56"]

        // Собственно:
        oid = matches[1];

        $("#adm-title").after('<a href="print_orders.php?OID[]=' + oid + '" style="display: inline-block; margin-right: 20px; margin-bottom: 20px; width: 150px;" class="adm-btn adm-btn-save" title="Печать заказов">Печать заказов</a>');

        var city=$(".adm-detail-content-cell-l:contains('Город')").next("td.adm-detail-content-cell-r").find("div").text();
        var address=$(".adm-detail-content-cell-l:contains('Адрес')").next("td.adm-detail-content-cell-r").find("div").text();
        $(".adm-detail-content-cell-l:contains('Адрес')").next("td.adm-detail-content-cell-r").find("div").append(' <a target="_blank" href="https://yandex.ru/maps/?text='+encodeURIComponent(city)+' '+encodeURIComponent(address)+'">На карте</a>');
        //alert(encodeURIComponent(address));
        <?endif;?>
    });
</script>