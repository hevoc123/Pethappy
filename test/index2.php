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
        $orders[$row[0]]["status"]=$row["1"];
        $orders[$row[0]]["payed"]=$row["16"];

        //var_dump($orders[$row[0]]);
    }
    fclose($handle);

    foreach($orders as $id=>$order)
    {
        //if($id < 6955) continue;
        $arOrder = CSaleOrder::GetByID($id);
        if ($arOrder)
        {
            $arFields=Array();
            if($order["payed"]=="Да")
                $arFields["PAYED"]="Y";
            else
                $arFields["PAYED"]="N";

            if(strstr($order["status"], "[D]"))
                $arFields["STATUS_ID"]="D";
            elseif(strstr($order["status"], "[A]"))
                $arFields["STATUS_ID"]="N";
            elseif(strstr($order["status"], "[B]"))
                $arFields["STATUS_ID"]="B";
            elseif(strstr($order["status"], "[C]"))
                $arFields["STATUS_ID"]="C";
            elseif(strstr($order["status"], "[E]")) {
                $arFields["STATUS_ID"] = "E";
                $arFields["CANCELED "] = "Y";
            }
            elseif(strstr($order["status"], "[F]"))
                $arFields["STATUS_ID"]="F";
            elseif(strstr($order["status"], "[G]"))
                $arFields["STATUS_ID"]="G";

            var_dump($id);var_dump($arFields);
            CSale Order::Update($id, $arFields);
        }
    }

}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>