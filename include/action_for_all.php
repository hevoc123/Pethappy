<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?> 
<?

$dbBasketItems = CSaleBasket::GetList(
		array(),
		array(
				"FUSER_ID" => CSaleBasket::GetBasketUserID(),
				"LID" => SITE_ID,
				"ORDER_ID" => "NULL",
			),
		false,
		false,
		array("ID", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "DELAY", "CAN_BUY", "CURRENCY")
	);
	
while($arBasket = $dbBasketItems->Fetch())
{
	if($_REQUEST["action"] == "delete_basket")
	{
		if ($arBasket["DELAY"] == "N")
			if(!CSaleBasket::Delete($arBasket["ID"])) echo "error";
	}
	
	if($_REQUEST["action"] == "delete_delay")
	{
		if ($arBasket["DELAY"] == "Y")		
			CSaleBasket::Delete($arBasket["ID"]);
	}	
	
	elseif($_REQUEST["action"] == "shelve")
	{
		if ($arBasket["DELAY"] == "N" && $arBasket["CAN_BUY"] == "Y")
			CSaleBasket::Update($arBasket["ID"], Array("DELAY" => "Y"));
	}
	elseif($_REQUEST["action"] == "add")
	{
		if ($arBasket["DELAY"] == "Y" && $arBasket["CAN_BUY"] == "Y")
			CSaleBasket::Update($arBasket["ID"], Array("DELAY" => "N"));
	}
}

LocalRedirect("/personal/cart/");
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>