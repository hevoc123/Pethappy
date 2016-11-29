<?
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
require($_SERVER["DOCUMENT_ROOT"]."/test/phpquery.php");
CJSCore::Init(array("jquery"));
?>
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<?
if($_GET["offset"])
	$offset=$_GET["offset"];
else
	$offset=0;

CModule::IncludeModule("catalog");
CModule::IncludeModule("iblock");
CModule::IncludeModule("sale");
	
	$orders=Array();
	$data = array();
	if (($handle = fopen($_SERVER["DOCUMENT_ROOT"]."/upload/orders.csv", 'r')) !== FALSE)
	{
		$i=0;
		
		while (($row = fgetcsv($handle, 0, ";")) !== FALSE)
		{
			$i++;
			if($i==1) continue;
			$orders[$row[0]]["delivery"]=$row["12"];
			$orders[$row[0]]["address"]=$row["13"];
			$orders[$row[0]]["comment"]=$row["15"];
		}
		fclose($handle);
		
		/*foreach($orders as $id=>$order)
		{
			$arOrder = CSaleOrder::GetByID($id);
			if ($arOrder)
			{
			   $arFields = array(
				  "COMMENTS" => utf8win1251($order["comment"]),
			   );
			   CSaleOrder::Update($ID, $arFields);
			   
			   $arFields = array(
				   "ORDER_ID" => $ORDER_ID,
				   "ORDER_PROPS_ID" => 6,
				   "NAME" => "Адрес",
				   "CODE" => "ADDRESS",
				   "VALUE" => $item["agent"]["phone"]
				);

				CSaleOrderPropsValue::Add($arFields);
			}
		}*/

	}


	$password_min_length = 6;
	$password_chars = array(
		"abcdefghijklnmopqrstuvwxyz",
		"ABCDEFGHIJKLNMOPQRSTUVWXYZ",
		"0123456789",
	);

    $users=Array();

    $order = array('sort' => 'asc');
    $tmp = 'sort';

    $rsUsers = CUser::GetList($order, $tmp);
    while ($arUser=$rsUsers->Fetch())
    {
        $users[$arUser["EMAIL"]]=$arUser["ID"];
    }
		
	$hostname = 'online.moysklad.ru';
	$username = 'admin@pethappy';
	$password = '4ca60e65db';
		
	$result=file_get_contents("https://$username:$password@$hostname/api/remap/1.1/entity/customerorder?offset=".$offset."&limit=10&expand=state,positions,agent,assortment");

	$temp=Array();

	$data=json_decode($result, true);
	$size=$data["meta"]["size"];
	$rows=$data["rows"];

	var_dump($size);
	
	foreach($data["rows"] as $key=>$item)
	{
        $USER_ID=0;

        if($users[$item["agent"]["email"]]) {

            $USER_ID=$users[$item["agent"]["email"]];

        }
		else
		{
            $def_group = COption::GetOptionString("main", "new_user_registration_def_group", "");
            if($def_group!="")
            {
                $GROUP_ID = explode(",", $def_group);
                $arPolicy = $USER->GetGroupPolicy($GROUP_ID);
            }
            else
            {
                $arPolicy = $USER->GetGroupPolicy(array());
            }

            $password_min_length = intval($arPolicy["PASSWORD_LENGTH"]);
            if($password_min_length <= 0)
                $password_min_length = 6;

            if($arPolicy["PASSWORD_PUNCTUATION"] === "Y")
                $password_chars[] = ",.<>/?;:'\"[]{}\|`~!@#\$%^&*()-_+=";
            $NEW_PASSWORD = $NEW_PASSWORD_CONFIRM = randString($password_min_length+2, $password_chars);

			$user = new CUser;
			$USER_ID = $user->Add(Array(
				"LOGIN" => $item["agent"]["email"],
				"NAME" => utf8win1251($item["agent"]["name"]),
				"PASSWORD" => $NEW_PASSWORD,
				"PASSWORD_CONFIRM" => $NEW_PASSWORD_CONFIRM,
				"EMAIL" => $item["agent"]["email"],
				"GROUP_ID" => $GROUP_ID,
				"PERSONAL_PHONE" => $item["agent"]["phone"],
				"ACTIVE" => "Y",
				"LID" => "s1",
				)
			);

            $users[$item["agent"]["email"]]=$USER_ID;
		}
				
		$state=utf8win1251($item["state"]["name"]);
		
		$STATUS_ID="N"; $CANCELED="N"; $PAYED="N";
		
		if($state=="[A] Заказ принят") {$STATUS_ID="N"; $CANCELED="N";}
		if($state=="[B] Формируется к отправке") {$STATUS_ID="B"; $CANCELED="N";}
		if($state=="[C] Отправлен") {$STATUS_ID="C"; $CANCELED="N";}
		if($state=="[D] Выполнен") {$STATUS_ID="D"; $CANCELED="N";}
		if($state=="[E] Заказ отменен") {$STATUS_ID="E"; $CANCELED="Y";}
		if($state=="[F] Заказ собран и ожидает Вас") {$STATUS_ID="F"; $CANCELED="N";}
		if($state=="[G] Заказ передан в региональный отдел") {$STATUS_ID="G"; $CANCELED="N";}
		
		//if($item["sum"]==$item["payedSum"]) $PAYED="Y";
		
		print_r($USER_ID); echo "ЮЗЕР ИД <br />";

        if ($USER_ID) {
            $FUSER_ID = CSaleUser::GetList(array('USER_ID' => $USER_ID));

            if (!$FUSER_ID['ID'])
                $FUSER_ID['ID'] = CSaleUser::_Add(array("USER_ID" => $USER_ID));

            $FUSER_ID = $FUSER_ID['ID'];
        }

        $DELIVERY_ID = 4;
        $PRICE_DELIVERY = 0;
		
		CSaleBasket::DeleteAll($FUSER_ID, False);
   
   		foreach($item["positions"]["rows"] as $position) 
		{
			if($position["assortment"]["meta"]["href"]=="https://online.moysklad.ru/api/remap/1.1/entity/service/f4165cb8-5269-11e5-90a2-8ecb003250a2") 
			{
				$DELIVERY_ID=5;
				$PRICE_DELIVERY=$position["price"]/100;
				
				continue;
			}
			
			if($position["assortment"]["meta"]["href"]=="https://online.moysklad.ru/api/remap/1.1/entity/service/4eb43d08-5602-11e5-7a07-673d002752c3") 
			{
				$DELIVERY_ID='rus_post:land';
				$PRICE_DELIVERY=$position["price"]/100;
				
				continue;
			}			
				
				
			$url=str_replace("online", $username.":".$password."@online", $position["assortment"]["meta"]["href"]);

			$result=file_get_contents($url."?expand=product");
			$product=json_decode($result, true);

			if($product["externalCode"])
			{
				
				$arSelect = Array("ID", "NAME", "DETAIL_PAGE_URL", "PROPERTY_IMYIE_CML2ATTR_FASOVKA");
				$arFilter = Array("IBLOCK_ID"=>2, "XML_ID"=>$product["externalCode"]);
				$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount"=>1), $arSelect);
				if($ar_res = $res->GetNext())
				{
					print_r($ar_res["NAME"]); echo "<br />";
					
					$arFields=Array();
					$arFields = array(
						"FUSER_ID"=>$FUSER_ID,
						"PRODUCT_ID" => $ar_res["ID"],
						"PRODUCT_PRICE_ID" => 0,
						"PRICE" => $position["price"]/100,
						"CURRENCY" => "RUB",
						"WEIGHT" => 0,
						"QUANTITY" => $position["quantity"],
						"LID" => "s1",
						"DELAY" => "N",
						"CAN_BUY" => "Y", 
						"DETAIL_PAGE_URL"=>$ar_res["DETAIL_PAGE_URL"],
						"NAME" => $ar_res["NAME"],
						"CALLBACK_FUNC" => "",
						"MODULE" => "sale",
						"NOTES" => "",
						"ORDER_CALLBACK_FUNC" => "",
						"PRODUCT_XML_ID" => $product["externalCode"],
						"CATALOG_XML_ID"=>"bd72d8f9-55bc-11d9-848a-00112f43529a#",						
					  );

					CSaleBasket::Add($arFields);
				
				}
				
				$arFilter = Array("IBLOCK_ID"=>4, "XML_ID"=>$product["product"]["externalCode"]."#".$product["externalCode"]);
				$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount"=>1), Array("ID", "NAME", "DETAIL_PAGE_URL", "PROPERTY_IMYIE_CML2ATTR_FASOVKA", "PROPERTY_CML2_LINK.DETAIL_PAGE_URL"));
				if($ar_res = $res->GetNext())
				{
					
					print_r($ar_res["NAME"]); echo "<br />";
					
					$arFields=Array();
					$arFields = array(
						"FUSER_ID"=>$FUSER_ID,
						"PRODUCT_ID" => $ar_res["ID"],
						"PRODUCT_PRICE_ID" => 0,
						"PRICE" => $position["price"]/100,
						"CURRENCY" => "RUB",
						"WEIGHT" => 0,
						"QUANTITY" => $position["quantity"],
						"LID" => "s1",
						"DELAY" => "N",
						"CAN_BUY" => "Y", 
						"DETAIL_PAGE_URL"=>$ar_res["PROPERTY_CML2_LINK_DETAIL_PAGE_URL"],
						"NAME" => $ar_res["NAME"],
						"CALLBACK_FUNC" => "",
						"MODULE" => "catalog",
						"NOTES" => "",
						"ORDER_CALLBACK_FUNC" => "",
						"PRODUCT_XML_ID" => $product["product"]["externalCode"]."#".$product["externalCode"],
						"CATALOG_XML_ID"=>"bd72d8f9-55bc-11d9-848a-00112f43529a#",
					);
					
					$arProps = array();

					$arProps[] = array(
						"NAME" => "Фасовка",
						"VALUE" => $ar_res["PROPERTY_IMYIE_CML2ATTR_FASOVKA_VALUE"],
					);

					$arFields["PROPS"] = $arProps;

					CSaleBasket::Add($arFields);
				
				}
			}
		}

		$arFields=Array();
		$arFields = array(
		   "LID" => "s1",
		   "PERSON_TYPE_ID" => 1,
		   "PAYED" => $PAYED,
		   "CANCELED" => $CANCELED,
		   "STATUS_ID" => $STATUS_ID,
		   "PRICE" => $item["sum"]/100,
		   "CURRENCY" => "RUB",
		   "USER_ID" => IntVal($USER_ID),
		   "PAY_SYSTEM_ID" => 3,
		   "PRICE_DELIVERY" => $PRICE_DELIVERY,
		   "DELIVERY_ID" => $DELIVERY_ID,
		   "DISCOUNT_VALUE" => 0,
		   "COMMENTS" => $orders[$item["code"]]["comment"],
		   "USER_DESCRIPTION" => utf8win1251($item["description"]),
		   "DATE_INSERT" => ConvertTimeStamp(strtotime($item["moment"]), 'FULL', 's1'),
		   "DATE_UPDATE" => ConvertTimeStamp(strtotime($item["updated"]), 'FULL', 's1'),
		);
		
		//var_dump($arFields); die();

		$ORDER_ID = CSaleOrder::Add($arFields);
		$ORDER_ID = IntVal($ORDER_ID);
		
		CSaleBasket::OrderBasket($ORDER_ID, $FUSER_ID, "s1");
		
		$arFields = array(
		   "ORDER_ID" => $ORDER_ID,
		   "ORDER_PROPS_ID" => 1,
		   "NAME" => "Контактное лицо",
		   "CODE" => "FIO",
		   "VALUE" => utf8win1251($item["agent"]["name"])
		);

		CSaleOrderPropsValue::Add($arFields);

		$arFields = array(
		   "ORDER_ID" => $ORDER_ID,
		   "ORDER_PROPS_ID" => 2,
		   "NAME" => "E-Mail",
		   "CODE" => "EMAIL",
		   "VALUE" => $item["agent"]["email"]
		);

		CSaleOrderPropsValue::Add($arFields);		
		
		$arFields = array(
		   "ORDER_ID" => $ORDER_ID,
		   "ORDER_PROPS_ID" => 3,
		   "NAME" => "Телефон",
		   "CODE" => "PHONE",
		   "VALUE" => $item["agent"]["phone"]
		);

		CSaleOrderPropsValue::Add($arFields);
		
		$arFields = array(
		   "ORDER_ID" => $ORDER_ID,
		   "ORDER_PROPS_ID" => 6,
		   "NAME" => "Адрес",
		   "CODE" => "ADDRESS",
		   "VALUE" => str_replace("Россия, Москва, ", "", $orders[$item["code"]]["address"])
		);

		CSaleOrderPropsValue::Add($arFields);
		
		if($item["code"]==$ORDER_ID) {
			print_r($ORDER_ID); echo "Все ок ордер ид <br />";
		}
		else
		{
			print_r($item["code"]); echo "Все хуево ордер ид ".$ORDER_ID."<br />";
			die();
		}

		//if($key > 10) die();
	}

	$offset+=10;
?>
<script>
	$(document).ready(function () {
		window.location.href = "http://ph.1c-store.ru/test/index.php?offset=<?=$offset?>"
	});
</script>