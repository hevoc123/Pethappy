<?
AddEventHandler("sale", "OnSuccessCatalogImport1C", "AfterImport");

function AfterImport($arParams, $filename)
{
    if(strpos($_REQUEST['filename'], 'offers') !== false)
        update_articles();
}

AddEventHandler("sale", "OnBeforeBasketAdd", "addPropertyToBasket");

function addPropertyToBasket(&$arFields) {
    $arProps=Array();
    $temp=CIBlockElement::GetList(Array(), Array("ID"=>$arFields["PRODUCT_ID"]), false, false, Array("ID", "IBLOCK_ID", "PROPERTY_IMYIE_CML2ATTR_FASOVKA"))->GetNext();
    if($temp["IBLOCK_ID"]==4)
    {
        $arProps[]=Array(
            "NAME"=>"�������",
            "VALUE"=>$temp["PROPERTY_IMYIE_CML2ATTR_FASOVKA_VALUE"],
        );
        $arFields["PROPS"]=$arProps;
    }
    else
    {
        $temp=CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>2, "ID"=>$arFields["PRODUCT_ID"]), false, false, Array("ID", "IBLOCK_ID", "PROPERTY_IMYIE_CML2ATTR_FASOVKA"))->GetNext();
        if($temp["PROPERTY_IMYIE_CML2ATTR_FASOVKA_VALUE"]) {
            $arProps[]=Array(
                "NAME"=>"�������",
                "VALUE"=>$temp["PROPERTY_IMYIE_CML2ATTR_FASOVKA_VALUE"],
            );
            $arFields["PROPS"]=$arProps;
        }

    }
}

AddEventHandler("sale", "OnSaleCancelOrder", "setCancelStatus");

function setCancelStatus($orderID, $value, $description)
{
    if($value=="Y")
        CSaleOrder::StatusOrder($orderID, "E");
    if($value=="N")
        CSaleOrder::StatusOrder($orderID, "N");
}

AddEventHandler("sale", "OnOrderNewSendEmail", "bxModifySaleMails");

function bxModifySaleMails($orderID, &$eventName, &$arFields)
{
    $arOrder = CSaleOrder::GetByID($orderID);
    //-- �������� �������� � �����
    $props=Array();

    $db_props = CSaleOrderPropsValue::GetOrderProps($arOrder["ID"]);
    while ($arProps = $db_props->Fetch())
    {
        $props[$arProps["CODE"]]=$arProps;
    }

    CModule::IncludeModule("sale");

    $dbBasketItems = CSaleBasket::GetList(array(), array(
        "ORDER_ID" => $orderID
    ),
        false, false, array("*"));

    $i = 0;
    $arFields["NEW_ORDER_LIST"] = "";
    $total = $total_discount = 0;
    while ($arItems = $dbBasketItems->Fetch()) {
        $i++;

        $fasovka=$article="";
        $temp=CIBlockElement::GetList(Array(), Array("ID"=>$arItems["PRODUCT_ID"]), false, false, Array("ID", "IBLOCK_ID", "PROPERTY_CML2_ARTICLE", "PROPERTY_IMYIE_CML2ATTR_FASOVKA"))->GetNext();
        if($temp["IBLOCK_ID"]==4)
        {
            $fasovka=$temp["PROPERTY_IMYIE_CML2ATTR_FASOVKA_VALUE"];
            $article=$temp["PROPERTY_CML2_ARTICLE_VALUE"];
        }
        else {
            $temp = CIBlockElement::GetList(Array(), Array("IBLOCK_ID" => 2, "ID" => $arItems["PRODUCT_ID"]), false, false, Array("ID", "IBLOCK_ID", "PROPERTY_CML2_ARTICLE"))->GetNext();
            $article=$temp["PROPERTY_CML2_ARTICLE_VALUE"];
        }

        $total += $arItems["PRICE"] * $arItems["QUANTITY"];
        $total_discount += $arItems["DISCOUNT_PRICE"];

        $arFields["BASKET_INFO"].='<tr>
            <td valign="top" align="center" style="padding: 10px 0; border-bottom: 1px solid #dadada;">'.$article.'</td>
            <td valign="top" style="padding: 10px 0; border-bottom: 1px solid #dadada;"><b>'.$arItems["NAME"].'</b></td>
            <td valign="top" align="center" style="padding: 10px 0; border-bottom: 1px solid #dadada;">'.$fasovka.'</td>
            <td valign="top" align="center" style="padding: 10px 0; border-bottom: 1px solid #dadada;">'.number_format($arItems["PRICE"], 0, ".", " " ).' �.</td>
            <td valign="top" align="center" style="padding: 10px 0; border-bottom: 1px solid #dadada;">'.$arItems["QUANTITY"].'</td>
         </tr>';
    }

    $arFields["TOTAL_ITEMS"] = $i;
    $arFields["TOTAL_PRICE"] = $total;
    $arFields["TOTAL_DISCOUNT"] = $total_discount;

    $arFields["USER_PHONE"] = $props["PHONE"]["VALUE"];
    $arFields["USER_NAME"] = $props["FIO"]["VALUE"];
    if($arOrder["DELIVERY_ID"]==4)
        $arFields["DELIVERY_TYPE"]="���������";
    elseif($arOrder["DELIVERY_ID"]==5) {

        if(date('l', strtotime($props["DATE"]["VALUE"]))=="Monday") $day='�����������';
        if(date('l', strtotime($props["DATE"]["VALUE"]))=="Tuesday") $day='�������';
        if(date('l', strtotime($props["DATE"]["VALUE"]))=="Wednesday") $day='�����';
        if(date('l', strtotime($props["DATE"]["VALUE"]))=="Thursday") $day='�������';
        if(date('l', strtotime($props["DATE"]["VALUE"]))=="Friday") $day='�������';
        if(date('l', strtotime($props["DATE"]["VALUE"]))=="Saturday") $day='�������';
        if(date('l', strtotime($props["DATE"]["VALUE"]))=="Sunday") $day='�����������';

        $arFields["COMMENTS"] = $day.' > '.$props["DATE"]["VALUE"]." > ".($props["TIME"]["VALUE"]==4 ? "18:00-23:00": "10:00-18:00" );

        CSaleOrder::Update($orderID, $arFields);

        $arFields["DELIVERY_TYPE"] = "������";
    }
    elseif($arOrder["DELIVERY_ID"]=="rus_post:land")
        $arFields["DELIVERY_TYPE"]="�����";
    else
        $arFields["DELIVERY_TYPE"]="���;";

    if($arOrder["PRICE_DELIVERY"]) $arFields["PRICE_DELIVERY"] = "<tr><td class=\"mright\">��������� ��������:</td><td>".intval($arOrder["PRICE_DELIVERY"])." �.</td></tr>";
    if($arOrder["DISCOUNT_VALUE"]) $arFields["DISCOUNT_VALUE"] = "<tr><td class=\"mright\">����� ������:</td><td>".intval($arOrder["DISCOUNT_VALUE"])." �.</td></tr>";

    if($arOrder["PAY_SYSTEM_ID"]==3)
        $arFields["PAYMENT_TYPE"]="���������";
    else
        $arFields["PAYMENT_TYPE"]="������";


    if($arOrder["DELIVERY_ID"]!=4) {
        $arFields["DELIVERY_INFO"] = '    
        <b>����� ��������</b><br /><br />
        <table>';
        if ($props["LOCATION"]["VALUE"]) {
            $location = CSaleLocation::GetByID($props["LOCATION"]["VALUE"]);
            $arFields["DELIVERY_INFO"] .= '
                <tr>
                    <td class="mright">�����:</td><td>' . ($props["LOCATION"]["VALUE"] == 19 ? "������" : ($props["ZIP"]["VALUE"] ? $props["ZIP"]["VALUE"] . ", " : "") . ($location["REGION_NAME_ORIG"] ? $location["REGION_NAME_ORIG"] . ", " : "") . " " . $location["CITY_NAME"]) . '</td>
                </tr>';
        }
        if ($props["ADDRESS"]["VALUE"])
            $arFields["DELIVERY_INFO"] .= '
                <tr>
                    <td class="mright">�����:</td><td>' . $props["ADDRESS"]["VALUE"] . '</td>
                </tr>';
        if($arOrder["DELIVERY_ID"]==5)
        {
            $arFields["DELIVERY_INFO"] .= '
                <tr>
                    <td class="mright">����:</td><td>' . $props["DATE"]["VALUE"] . '</td>
                </tr>';
            $arFields["DELIVERY_INFO"] .= '
                <tr>
                    <td class="mright">�����:</td><td>' . ($props["TIME"]["VALUE"]==4 ? "c 18 �� 23": "� 10 �� 18" ). '</td>
                </tr>';
        }
    }
    else
    {
        $arFields["DELIVERY_INFO"] = '    
        <b>���������</b><br /><br />
        <table>';
        $arFields["DELIVERY_INFO"] .= '
                <tr>
                    <td class="mright">�����:</td><td>�. ������� ������� ��������, ��. ���������� �����, 1�</td>
                </tr>';
    }

    $arFields["DELIVERY_INFO"] .= '</table>';
    if($arOrder["PAYED"]=="Y") $arFields["PAYED"]="�������"; else $arFields["PAYED"]="���������";
    if($arOrder["PAY_SYSTEM_ID"]!=3) $arFields["PAYMENT"]='
    <form method="GET" action="http://pethappy.ru/include/payment.php" target="_blank">
    <input type="hidden" name="ORDER_ID" value="'.$arOrder['ID'].'">
    <input type="submit" value="��������">
    </form>
    ';
}

AddEventHandler("main", "OnAfterUserAdd", "OnAfterUserRegisterHandler");
AddEventHandler("main", "OnAfterUserRegister", "OnAfterUserRegisterHandler");
AddEventHandler("main", "OnAfterUserSimpleRegister", "OnAfterUserRegisterHandler");

function OnAfterUserRegisterHandler(&$arFields)
{
    if (intval($arFields["ID"])>0)
    {
        $toSend = Array();
        if($arFields["CONFIRM_PASSWORD"]) $toSend["PASSWORD"] = $arFields["CONFIRM_PASSWORD"];
        if($arFields["PASSWORD_CONFIRM"]) $toSend["PASSWORD"] = $arFields["PASSWORD_CONFIRM"];
        $toSend["EMAIL"] = $arFields["EMAIL"];
        $toSend["USER_ID"] = $arFields["ID"];
        $toSend["USER_IP"] = $arFields["USER_IP"];
        $toSend["USER_HOST"] = $arFields["USER_HOST"];
        $toSend["LOGIN"] = $arFields["LOGIN"];
        $toSend["NAME"] = (trim ($arFields["NAME"]) == "")? $toSend["NAME"] = htmlspecialchars('<�� �������>'): $arFields["NAME"];
        $toSend["LAST_NAME"] = (trim ($arFields["LAST_NAME"]) == "")? $toSend["LAST_NAME"] = htmlspecialchars('<�� �������>'): $arFields["LAST_NAME"];
        CEvent::SendImmediate ("MY_NEW_USER", "s1", $toSend);
    }
    return $arFields;
}

function getWord($number, $suffix)
{
    $keys = array(2, 0, 1, 1, 1, 2);
    $mod = $number % 100;
    $suffix_key = ($mod > 7 && $mod < 20) ? 2 : $keys[min($mod % 10, 5)];
    return $suffix[$suffix_key];
}

function words_limit($input_text, $limit = 50, $end_str = '')
{
    $input_text = strip_tags($input_text);
    $words = explode(' ', $input_text); // ������ �� ������ ������ ����
    if ($limit < 1 || sizeof($words) <= $limit) { // ���� ����� ������ �� ����� ��� ���������� ���� ������ ������, �� ���������� �������� ������
        return $input_text;
    }
    $words = array_slice($words, 0, $limit); // ����������� ������ �� ������ �����
    $out = implode(' ', $words);
    return $out . $end_str; //���������� ������ + ������/������ ����������
}

AddEventHandler("search", "BeforeIndex", "BeforeIndexHandler");

function BeforeIndexHandler($arFields)
{
    if (!CModule::IncludeModule("iblock")) // ���������� ������
        return $arFields;
    if ($arFields["MODULE_ID"] == "iblock") {
        $ob = CIBlockElement::GetByID($arFields["ITEM_ID"]);
        if ($res = $ob->GetNextElement()) {
            $arProp = $res->getProperties();
            if ($arProp["CML2_ARTICLE"]["VALUE"]) {
                $articles = $arProp["CML2_ARTICLE"]["VALUE"];
                if (CCatalogSKU::IsExistOffers($arFields["ITEM_ID"], 2)) {
                    $arSelect = Array("ID", "NAME", "PROPERTY_CML2_ARTICLE");
                    $arFilter = Array("IBLOCK_ID" => 4, "ACTIVE" => "Y", "PROPERTY_CML2_LINK" => $arFields["ITEM_ID"]);
                    $sres = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
                    while ($sar_res = $sres->GetNext()) {
                        $articles .= " " . $sar_res["PROPERTY_CML2_ARTICLE_VALUE"];
                    }
                }

                $arFields["TITLE"] = $arFields["TITLE"] . " " . $articles;
            }
        }

    }
    return $arFields; // ����� ��������� 
}

AddEventHandler('main', 'OnPageStart', array('CMainhandlers', 'OnPageStartHandler'));

class CMainhandlers
{
    public static function OnPageStartHandler()
    {
        if (isset($_GET['page']) && intval($_GET['page']) > 0) {
            $GLOBALS['PAGEN_1'] = $_REQUEST['PAGEN_1'] = $_GET['PAGEN_1'] = $_GET['page'];
            unset($_GET['page'], $_REQUEST['page'], $GLOBALS['page']);
        }
        $GLOBALS['APPLICATION']->reinitPath();
    }
}


AddEventHandler("main", "OnEndBufferContent", "ChangeMyContent");
function ChangeMyContent($content)
{
    if ($_GET["download"] == "Y") {
        $descriptorspec = array(
            0 => array('pipe', 'r'),
            1 => array('pipe', 'w'),
            2 => array('pipe', 'w'),
        );

        $request = "http://ph.1c-store.ru" . str_replace("download=", "print=", $_SERVER["REQUEST_URI"]);

        $filename = explode("?", basename($request));
        $filename = $filename[0];

        $process = proc_open("/usr/local/bin/wkhtmltopdf --dpi 96 '" . $request . "' -", $descriptorspec, $pipes, null, null, ['bypass_shell' => true]);

        if (is_resource($process)) {

            $stdOut = stream_get_contents($pipes[1]);
            $stdErr = stream_get_contents($pipes[2]);
            fclose($pipes[1]);
            fclose($pipes[2]);

            $exitCode = proc_close($process);

            header("Content-type:application/pdf");
            header("Content-Disposition:attachment;filename='" . $filename . ".pdf'");
            echo $stdOut;
            die();
        }

    }
}

AddEventHandler("catalog", "OnSuccessCatalogImport1C", "MyOnStoreProductSave");

define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"] . "/log.txt");
function MyOnStoreProductSave()
{

    AddMessage2Log("���� " . $_REQUEST['filename'], "my_module_id");
    if (CModule::IncludeModule('catalog') & CModule::IncludeModule('iblock') && strstr($_REQUEST['filename'], 'offers')) {

        $arSelect = Array("ID", "NAME", "CATALOG_GROUP_2");
        $arFilter = Array("IBLOCK_ID" => 2, "ACTIVE" => "Y", "INCLUDE_SUBSECTIONS" => "Y");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        while ($ar_res = $res->GetNext()) {
            $quantity = 0;
            $price = 0;
            if (CCatalogSKU::IsExistOffers($ar_res["ID"], 2)) {
                $arSelect = Array("ID", "NAME", "CATALOG_GROUP_2");
                $arFilter = Array("IBLOCK_ID" => 4, "ACTIVE" => "Y", "PROPERTY_CML2_LINK" => $ar_res["ID"]);
                $sres = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
                while ($sar_res = $sres->GetNext()) {
//					AddMessage2Log("���� ".$price, "my_module_id");
                    if (($price > $sar_res["CATALOG_PRICE_2"] || $price == 0) && $sar_res["CATALOG_QUANTITY"] > 0) {
                        AddMessage2Log("��������� ������� ���� " . $price . " ����� " . $sar_res["CATALOG_PRICE_2"], "my_module_id");
                        $price = $sar_res["CATALOG_PRICE_2"];
                    }

                    $quantity += $sar_res["CATALOG_QUANTITY"];
                }

                AddMessage2Log("���� " . $price, "my_module_id");

                if ($price > 0) {
                    /*$arFields = Array(
                        "PRODUCT_ID" => $ar_res["ID"],
                        "CATALOG_GROUP_ID" => 2,
                        "PRICE" => intval($price),
                        "CURRENCY" => "RUB"
                    );*/

                    CPrice::SetBasePrice($ar_res["ID"], $price, "RUB");
                    //CPrice::Update($ar_res["ID"], $arFields);
                }

                $arFieldsProduct = array(
                    "QUANTITY" => $quantity,
                );

                CCatalogProduct::Update($ar_res['ID'], $arFieldsProduct);

            }
        }
    }
}

function update_articles()
{

    CModule::IncludeModule("catalog");
    CModule::IncludeModule("iblock");
    CModule::IncludeModule("sale");


    $hostname = 'online.moysklad.ru';
    $username = 'admin@pethappy';
    $password = '4ca60e65db';

    $result = file_get_contents("https://$username:$password@$hostname/api/remap/1.1/entity/variant?limit=100");

    $temp = Array();

    $data = json_decode($result, true);
    $size = $data["meta"]["size"];
    $rows = $data["rows"];

    foreach ($data["rows"] as $item) {
        $temp[$item["externalCode"]] = $item["code"];
    }

    for ($i = 100; $i < $size; $i += 100) {
        $result = file_get_contents("https://$username:$password@$hostname/api/remap/1.1/entity/variant?limit=100&offset=" . $i);
        $data = json_decode($result, true);
        foreach ($data["rows"] as $item) {
            $temp[$item["externalCode"]] = $item["code"];
        }
    }

    $arItems = Array();

    $arSelect = Array("ID", "EXTERNAL_ID", "NAME");
    $arFilter = Array("IBLOCK_ID" => 4);
    $res = CIBlockElement::GetList(Array("ID" => "ASC"), $arFilter, false, false, $arSelect);
    while ($ar_res = $res->GetNext()) {
        $code = explode("#", $ar_res["EXTERNAL_ID"]);
        $arItems[$code[1]] = $ar_res["ID"];
    }

    foreach ($arItems as $code => $item) {
        CIBlockElement::SetPropertyValuesEx($item, false, array("CML2_ARTICLE" => utf8win1251($temp[$code])));
    }

    return "update_articles()";
}