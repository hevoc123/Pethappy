<?
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");
CModule::IncludeModule("iblock");

if($_REQUEST["action"]=="update_product")
{
	$arBasketItems = array();

	$dbBasketItems = CSaleBasket::GetList(array("ID" => "ASC"), array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "PRODUCT_ID"=>$_REQUEST["product_id"],"ORDER_ID" => "NULL"));
	if($arItems = $dbBasketItems->Fetch())
	{
		$arFields = array(
		   //"PRODUCT_ID" => $_REQUEST["product_id"],
		   "QUANTITY" => $_REQUEST["quantity"],
		);

		CSaleBasket::Update($arItems["ID"], $arFields); 
	}
	else
	{
		Add2BasketByProductID($_REQUEST["product_id"], $_REQUEST["quantity"]); 
	}
}

if($_REQUEST["action"]=="delete_product")
{
	$arBasketItems = array();

	$dbBasketItems = CSaleBasket::GetList(array("ID" => "ASC"), array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "PRODUCT_ID"=>$_REQUEST["product_id"],"ORDER_ID" => "NULL"));
	if($arItems = $dbBasketItems->Fetch())
	{
		CSaleBasket::Delete($arItems["ID"]);
	}
}

echo CSaleBasket::GetList(array("ID" => "ASC"), array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "ORDER_ID" => "NULL"))->SelectedRowsCount();
