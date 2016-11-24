<?    
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");

$arItems = CSaleBasket::GetByID($_REQUEST["remove"]);
$quantity=$arItems["QUANTITY"];
//var_dump($quantity);
if(CSaleBasket::Delete($_REQUEST["remove"]))
{
	Add2BasketByProductID($_REQUEST["new"], $quantity, array());
}
?>