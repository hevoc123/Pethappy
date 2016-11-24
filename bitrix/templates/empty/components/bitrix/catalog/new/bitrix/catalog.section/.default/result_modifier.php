<?

$arBasketItems = array();

$dbBasketItems = CSaleBasket::GetList(
	array(),
	array(
		 "FUSER_ID" => CSaleBasket::GetBasketUserID(),
		"LID" => SITE_ID,
		 "ORDER_ID" => "NULL"
	),
	false,
	false,
	array("*")
);

$i = 0;
while ($arItems = $dbBasketItems->Fetch())
{
	$arResult["INBASKET"][$arItems["PRODUCT_ID"]]=intval($arItems["QUANTITY"]);
	$arResult["INBASKET_ID"][]=$arItems["PRODUCT_ID"];
}

if(!$USER->IsAuthorized()) {
	$arElements = unserialize($APPLICATION->get_cookie('favorites'));
}
else {
	$idUser = $USER->GetID();
	$rsUser = CUser::GetByID($idUser);
	$arUser = $rsUser->Fetch(); 
	$arElements = unserialize($arUser['UF_FAVORITES']);
}

$arResult["INWISHLIST"]=$arElements;
?>