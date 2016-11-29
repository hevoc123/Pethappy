<?
require($_SE RVER["DOCUMENT_ROOT"]."/bitrix/header.php");

global $APPLICATION;
global $USER;


$hostname = 'online.moysklad.ru';
$username = 'admin@pethappy';
$password = '4ca60e65db';


if($_GET["offset"])
    $offset=$_GET["offset"];
else
    $offset=0;

$result=file_get_contents("https://$username:$password@$hostname/api/remap/1.1/entity/customerorder?offset=".$offset."&limit=100&expand=state,positions,agent,assortment");

$temp=Array();

$data=json_decode($result, true);
$size=$data["meta"]["size"];
$rows=$data["rows"];

foreach($data["rows"] as $key=>$item)
{
    echo "<pre>"; print_r($item["code"]);

    $dtotal=0;

    foreach($item["positions"]["rows"] as $position)
    {


        if ((float)$position["discount"] > 0) {

            $price=0; $newprice=0;
            if((float)$position["discount"] == intval((float)$position["discount"])) {

            }
            else {
                echo "<br /> - "; print_r($position["discount"]);

                $dbBasketItems=CSaleBasket::GetList(Array("ID"=>"ASC"), Array("ORDER_ID"=>$item["code"]), false, false, Array("ID", "PRICE"));

                while($arItems=$dbBasketItems->Fetch())
                {
                    if((float)$arItems["PRICE"]==((float)$position["price"]/100)) {
                        $price = ((float)$position["price"] / 100 * (100 - (float)$position["discount"])) / 100;
                        echo "<br />  -- " . (float)$arItems["PRICE"] . " - " . $price;

                        $arFields = array(
                            "PRICE" => $price,
                        );

                        CSaleBasket::Update($arItems["ID"], $arFields);
                    }
                }
            }

            $total=0;

            $arFields = array(
                "PRICE" => $item["sum"]/100,
            );

            CSaleOrder::Update($item["code"], $arFields);
        }
    }
    echo "<br /> ---- ".$item["sum"]/100;

    echo "</pre>";
}

$offset+=100;

?>
    <script>
        $(document).ready(function () {
            window.location.href = "http://ph.1c-store.ru/test/getinfo.php?offset=<?=$offset?>"
        });
    </script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
