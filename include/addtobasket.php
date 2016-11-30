<?    
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");
CModule::IncludeModule("iblock");
if($_REQUEST["ID"])
{
	$ob = CIBlockElement::GetByID($_REQUEST["ID"])->GetNextElement();
	$elFields=$ob->GetFields();
	$elProp=$ob->GetProperties();
	
	
	if($_REQUEST["q"]) 
		$quantity=intval($_REQUEST["q"]);
	else 
		$quantity=1;

    $arProps=Array();
	$res = CIBlockElement::GetList(Array("ID"=>"DESC"), Array("ID"=>$_REQUEST["ID"]), false, false, Array("ID", "NAME", "CATALOG_GROUP_2", "PROPERTY_IMYIE_CML2ATTR_FASOVKA"));
	while($ar_res = $res->GetNext())
	{
		$av_q=$ar_res["CATALOG_QUANTITY"];
	}
	
	$dbBasketItems = CSaleBasket::GetList(array("NAME" => "ASC", "ID" => "ASC"), array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL", "PRODUCT_ID"=>$_REQUEST["ID"]), false,	false, array("ID", "QUANTITY"));
	while ($arItems = $dbBasketItems->Fetch())
	{
		$in_basket=$arItems["QUANTITY"];
	}
	
	if(($in_basket + $quantity) <= $av_q)
		Add2BasketByProductID($_REQUEST["ID"], $quantity, array());
	else 
		$text="¬ы выбрали максимально доступное количество";
	
	$dbBasketItems = CSaleBasket::GetList(array("NAME" => "ASC", "ID" => "ASC"), array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL"), false, false, array("ID", "QUANTITY"));
	
	echo $dbBasketItems->SelectedRowsCount();
}
?>