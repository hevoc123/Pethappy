<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
set_time_limit(0);
CModule::IncludeModule("iblock"); CModule::IncludeModule("sale");

$orders=Array();
$data = array();
if (($handle = fopen($_SERVER["DOCUMENT_ROOT"]."/upload/last.csv", 'r')) !== FALSE)
{
    $i=0;

    while (($row = fgetcsv($handle, 0, ";")) !== FALSE)
    {
        $i++;
        if($i==1) continue;
        $orders[$row[0]]["payed"]=$row["16"];
    }
    fclose($handle);

    foreach($orders as $id=>$order)
    {
        if($order["payed"]==" Да")
        {
            var_dump($id); var_dump($order["payed"]);
            if (!CSale Order::PayOrder($id, "Y", false, false, 0, array()))
            {
                echo "Ошибка обновления заказа"; //die();
            }

        }

        /*$arOrder = CSaleOrder::GetByID($id);
        if ($arOrder)
        {
            $arFields = array(
                "VALUE" => $order["name"]
            );

            $db_vals = CSaleOrd erPropsValue::GetList(
                array("SORT" => "ASC"),
                array(
                    "ORDER_ID" => $id,
                    "ORDER_PROPS_ID" => 1
                )
            );
            if ($arVals = $db_vals->Fetch())
                CSaleOrderPropsValue::Update($arVals["ID"], $arFields);

            $arFields = array(
                "VALUE" => $order["phone"]
            );

            $db_vals = CSaleOrderPropsValue::GetList(
                array("SORT" => "ASC"),
                array(
                    "ORDER_ID" => $id,
                    "ORDER_PROPS_ID" => 3
                )
            );
            if ($arVals = $db_vals->Fetch())
                CSaleOrderPropsValue::Update($arVals["ID"], $arFields);

        }*/
    }

}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>