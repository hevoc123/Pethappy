<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
set_time_limit(0);
CModule::IncludeModule("iblock"); CModule::IncludeModule("sale");

$orders=Array();
$data = array();
if (($handle = fopen($_SERVER["DOCUMENT_ROOT"]."/upload/orders2.csv", 'r')) !== FALSE)
{
    $i=0;

    while (($row = fgetcsv($handle, 0, ";")) !== FALSE)
    {
        $i++;
        if($i==1) continue;
        $orders[$row[0]]["delivery"]=$row["12"];
        $orders[$row[0]]["address"]=$row["13"];
        $orders[$row[0]]["comment"]=$row["15"];

        //var_dump($orders[$row[0]]);
    }
    fclose($handle);

    foreach($orders as $id=>$order)
    {
        $arOrder = CSaleOrder::GetByID($id);
        if ($arOrder)
        {
            /*$arFields = array(
                "COMMENTS" => $order["comment"],
            );

            if(strstr($order["delivery"], "Самовывоз")) $arFields["DELIVERY_ID"]=4;
            if(strstr($order["delivery"], "Курьером")) $arFields["DELIVERY_ID"]=5;
            if(strstr($order["delivery"], "по России")) $arFields["DELIVERY_ID"]='rus_post:land';

            //var_dump( $arFields);

            CSaleOrder::Update($id, $arFields);*/

            $order["address"]=str_replace("Россия, Москва, ", "", $order["address"]);

            $arFields = array(
                "ORDER_ID" => $id,
                "ORDER_PROPS_ID" => 6,
                "NAME" => "Адрес",
                "CODE" => "ADDRESS",
                "VALUE" => $order["address"]
            );

            var_dump($arFields);

            $db_vals = CSaleOrde rPropsValue::GetList(
                array("SORT" => "ASC"),
                array(
                    "ORDER_ID" => $id,
                    "ORDER_PROPS_ID" => 6
                )
            );
            if ($arVals = $db_vals->Fetch())
                CSaleOrderPropsValue::Update($arVals["ID"], $arFields);
        }
    }

}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>