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

        // ��������� � ���������� � matches
        matches = order_id.match(phoneRegexPattern);
        // matches = ["(701) 856-36-56", "701", "856-36-56"]

        // ����������:
        oid = matches[1];

        $("#adm-title").after('<a href="print_orders.php?OID[]=' + oid + '" style="display: inline-block; margin-right: 20px; margin-bottom: 20px; width: 150px;" class="adm-btn adm-btn-save" title="������ �������">������ �������</a>');

        var city=$(".adm-detail-content-cell-l:contains('�����')").next("td.adm-detail-content-cell-r").find("div").text();
        var address=$(".adm-detail-content-cell-l:contains('�����')").next("td.adm-detail-content-cell-r").find("div").text();
        $(".adm-detail-content-cell-l:contains('�����')").next("td.adm-detail-content-cell-r").find("div").append(' <a target="_blank" href="https://yandex.ru/maps/?text='+encodeURIComponent(city)+' '+encodeURIComponent(address)+'">�� �����</a>');
        //alert(encodeURIComponent(address));
        <?endif;?>
    });
</script>