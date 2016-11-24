<?

AddEventHandler("sale", "OnOrderNewSendEmail", "bxModifySaleMails");

function bxModifySaleMails($orderID, &$eventName, &$arFields)
{
  $arOrder = CSaleOrder::GetByID($orderID);
  //-- получаем телефоны и адрес
  $order_props = CSaleOrderPropsValue::GetOrderProps($orderID);
  
  while ($arProps = $order_props->Fetch())
  {
  	
    if ($arProps["CODE"] == "PHONE")
    {
       $phone=htmlspecialchars($arProps["VALUE"]);
    }
    if ($arProps["CODE"] == "FIO")
    {
      $fio=htmlspecialchars($arProps["VALUE"]);
    }
    if ($arProps["CODE"] == "EMAIL")
    {
      $email=htmlspecialchars($arProps["VALUE"]);
    }
		
    if ($arProps["CODE"] == "ADDRESS")
    {
      $street="Адрес: ".$arProps["VALUE"];
    }
	
    if ($arProps["CODE"] == "LOCATION")
    {
      $city=$arProps["VALUE"];
    }  	
  }

  //-- получаем название службы доставки
  $arDeliv = CSaleDelivery::GetByID($arOrder["DELIVERY_ID"]);
  $delivery_name = "";
  if ($arDeliv)
  {
    $delivery_name = $arDeliv["NAME"];
  }
  //-- получаем название платежной системы   
  $arPaySystem = CSalePaySystem::GetByID($arOrder["PAY_SYSTEM_ID"]);
  $pay_system_name = "";
  if ($arPaySystem)
  {
    $pay_system_name = $arPaySystem["NAME"];
  }
  
  	CModule::IncludeModule("sale");
  	$arBasketItems = array();
	
	$dbBasketItems = CSaleBasket::GetList(array(), array(
	     "ORDER_ID" => $orderID 
	),
	false, false, array("*"));
	
	$i = 0; $arFields["NEW_ORDER_LIST"]=""; $total=$total_discount=0;
	while ($arItems = $dbBasketItems->Fetch())
	{
		$i++;
		$total+=$arItems["PRICE"]*$arItems["QUANTITY"];
		$total_discount+=$arItems["DISCOUNT_PRICE"];
		
		$arFields["NEW_ORDER_LIST"].='<tr>
		<td style="border: 1px solid #ddd8bc; padding: 5px;">'.$arItems["ID"].'</td>
		<td style="border: 1px solid #ddd8bc; padding: 5px;">
		'.$arItems["NAME"].'</td>
		<td style="border: 1px solid #ddd8bc; padding: 5px;">'.$arItems["QUANTITY"].'</td>
		<td style="border: 1px solid #ddd8bc; padding: 5px;">'.SaleFormatCurrency($arItems["PRICE"], "RUB").'</td>
		<td style="border: 1px solid #ddd8bc; padding: 5px;">'.SaleFormatCurrency($arItems["DISCOUNT_PRICE"], "RUB").'</td>
		<td style="border: 1px solid #ddd8bc; padding: 5px;">'.SaleFormatCurrency($arItems["QUANTITY"]*$arItems["PRICE"], "RUB").'</td></tr>';
	}

	  $arFields["TOTAL_ITEMS"] =  $i;
	  $arFields["TOTAL_PRICE"] =  $total;
	  $arFields["TOTAL_DISCOUNT"] =  $total_discount;
	
	  $arFields["USER_PHONE"] =  $phone;
	  $arFields["USER_FIO"] =  $fio;
	  $arFields["DELIVERY_TYPE"]= $delivery_name;
	  $arFields["PRICE_DELIVERY"]= intval($arOrder["PRICE_DELIVERY"]);
	  $arFields["DISCOUNT_VALUE"]= intval($arOrder["DISCOUNT_VALUE"]);
	  $arFields["ORDER_DELIVERY_PROPERTY"].= "Способ оплаты - ".$pay_system_name."<br />";	
	  $city=CSaleLocation::GetByID($city, "RU");	  
	  $arFields["LOCATION"]=$city["CITY_NAME_LANG"];	  
	  $arFields["ADDRESS"].= $street.$home.$korpus.$flat."<br />";
	  if($arFields["DELIVERY_TYPE"]!="Доставка курьером") $arFields["ADDRESS"]=$arFields["DELIVERY_TYPE"];

	  $new_price=intval($arOrder["PRICE"])-intval($arOrder["SUM_PAID"]);
	  $arFields["PRICE"]=$new_price." руб";
  
}


function getWord($number, $suffix) { 
    $keys = array(2, 0, 1, 1, 1, 2);
    $mod = $number % 100;
    $suffix_key = ($mod > 7 && $mod < 20) ? 2: $keys[min($mod % 10, 5)];
    return $suffix[$suffix_key]; 
}

function words_limit($input_text, $limit = 50, $end_str = '') {
    $input_text = strip_tags($input_text);
    $words = explode(' ', $input_text); // создаём из строки массив слов
    if ($limit < 1 || sizeof($words) <= $limit) { // если лимит указан не верно или количество слов меньше лимита, то возвращаем исходную строку
        return $input_text;
    }
    $words = array_slice($words, 0, $limit); // укорачиваем массив до нужной длины
    $out = implode(' ', $words);
    return $out.$end_str; //возвращаем строку + символ/строка завершения
}

AddEventHandler("search", "BeforeIndex", "BeforeIndexHandler");

function BeforeIndexHandler($arFields)
{
    if(!CModule::IncludeModule("iblock")) // подключаем модуль
		return $arFields;
    if($arFields["MODULE_ID"] == "iblock")
    {	
		$ob = CIBlockElement::GetByID($arFields["ITEM_ID"]);
		if($res = $ob->GetNextElement())
		{
			$arProp=$res->getProperties();
			if($arProp["CML2_ARTICLE"]["VALUE"])
			{
				$articles=$arProp["CML2_ARTICLE"]["VALUE"];
				if(CCatalogSKU::IsExistOffers($arFields["ITEM_ID"], 2))
				{
					$arSelect = Array("ID", "NAME", "PROPERTY_CML2_ARTICLE");
					$arFilter = Array("IBLOCK_ID"=>4, "ACTIVE"=>"Y", "PROPERTY_CML2_LINK"=>$arFields["ITEM_ID"]);
					$sres = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
					while($sar_res = $sres->GetNext())
					{
						$articles.=" ".$sar_res["PROPERTY_CML2_ARTICLE_VALUE"];
					}
				}
				
				$arFields["TITLE"]= $arFields["TITLE"]." ".$articles; 
			}
		}
	
    }
    return $arFields; // вернём изменения 
} 
   
AddEventHandler('main', 'OnPageStart', array('CMainhandlers', 'OnPageStartHandler'));

class CMainhandlers {
	public static function OnPageStartHandler() { 
		if (isset($_GET['page']) && intval($_GET['page'])>0) {
			 $GLOBALS['PAGEN_1'] = $_REQUEST['PAGEN_1'] = $_GET['PAGEN_1'] = $_GET['page'];
			 unset($_GET['page'], $_REQUEST['page'], $GLOBALS['page']);
		}
		$GLOBALS['APPLICATION']->reinitPath();
    }
}


AddEventHandler("main", "OnEndBufferContent", "ChangeMyContent");
function ChangeMyContent($content)
{
	if($_GET["download"]=="Y")
	{
		$descriptorspec = array(
			0 => array('pipe', 'r'), 
			1 => array('pipe', 'w'),
			2 => array('pipe', 'w'),
		);
				
		$request="http://ph.1c-store.ru".str_replace("download=", "print=", $_SERVER["REQUEST_URI"]);
		
		$filename=explode("?", basename($request));
		$filename=$filename[0];
				
		$process = proc_open("/usr/local/bin/wkhtmltopdf --dpi 96 '".$request."' -", $descriptorspec, $pipes, null, null, ['bypass_shell' => true]);

		if (is_resource($process)) {
			
			$stdOut = stream_get_contents($pipes[1]);
			$stdErr = stream_get_contents($pipes[2]);
			fclose($pipes[1]);
			fclose($pipes[2]);

			$exitCode= proc_close($process);

			header("Content-type:application/pdf");
			header("Content-Disposition:attachment;filename='".$filename.".pdf'");
			echo $stdOut; die();
		}

	}
}

AddEventHandler("catalog", "OnSuccessCatalogImport1C", "MyOnStoreProductSave");

define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");
function MyOnStoreProductSave(){   

	AddMessage2Log("Файл ".$_REQUEST['filename'], "my_module_id");
    if(CModule::IncludeModule('catalog') & CModule::IncludeModule('iblock') && strstr($_REQUEST['filename'], 'offers')){
		
		$arSelect = Array("ID", "NAME", "CATALOG_GROUP_2");
		$arFilter = Array("IBLOCK_ID"=>2, "ACTIVE"=>"Y", "INCLUDE_SUBSECTIONS"=>"Y");
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		while($ar_res = $res->GetNext())
		{
			$quantity=0;
			$price=0;
			if(CCatalogSKU::IsExistOffers($ar_res["ID"], 2))
			{
				$arSelect = Array("ID", "NAME", "CATALOG_GROUP_2");
				$arFilter = Array("IBLOCK_ID"=>4, "ACTIVE"=>"Y", "PROPERTY_CML2_LINK"=>$ar_res["ID"]);
				$sres = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
				while($sar_res = $sres->GetNext())
				{
//					AddMessage2Log("Цена ".$price, "my_module_id");
					if(($price > $sar_res["CATALOG_PRICE_2"] || $price==0) && $sar_res["CATALOG_QUANTITY"] > 0) 
					{
						AddMessage2Log("Сработало условие было ".$price." стало ".$sar_res["CATALOG_PRICE_2"], "my_module_id");
						$price=$sar_res["CATALOG_PRICE_2"];
					}
					
					$quantity+=$sar_res["CATALOG_QUANTITY"];
				}
				
				AddMessage2Log("Цена ".$price, "my_module_id");
				
				if($price > 0)
				{
					/*$arFields = Array(
						"PRODUCT_ID" => $ar_res["ID"],
						"CATALOG_GROUP_ID" => 2,
						"PRICE" => intval($price),
						"CURRENCY" => "RUB"
					);*/
					
					CPrice::SetBasePrice($ar_res["ID"], $price, "RUB");
					//CPrice::Update($ar_res["ID"], $arFields);					
				}
			
				$arFieldsProduct = array(
					"QUANTITY" => $quantity,
				); 
				
				CCatalogProduct::Update($ar_res['ID'],$arFieldsProduct);
				
			}   
		}
    }   
}

function update_articles()
{

	CModule::IncludeModule("catalog");
	CModule::IncludeModule("iblock");
	CModule::IncludeModule("sale");


	$hostname = 'online.moysklad.ru';
	$username = 'admin@pethappy';
	$password = '4ca60e65db';
		
	$result=file_get_contents("https://$username:$password@$hostname/api/remap/1.1/entity/variant?limit=100");

	$temp=Array();

	$data=json_decode($result, true);
	$size=$data["meta"]["size"];
	$rows=$data["rows"];

	foreach($data["rows"] as $item)
	{
		$temp[$item["externalCode"]]=$item["code"];
	}

	for($i=100;$i < $size; $i+=100)
	{
		$result=file_get_contents("https://$username:$password@$hostname/api/remap/1.1/entity/variant?limit=100&offset=".$i);
		$data=json_decode($result, true);
		foreach($data["rows"] as $item)
		{
			$temp[$item["externalCode"]]=$item["code"];
		}
	}

	$arItems=Array();

	$arSelect = Array("ID", "EXTERNAL_ID", "NAME");
	$arFilter = Array("IBLOCK_ID"=>4);
	$res = CIBlockElement::GetList(Array("ID"=>"ASC"), $arFilter, false, false, $arSelect);
	while($ar_res = $res->GetNext())
	{
		$code=explode("#", $ar_res["EXTERNAL_ID"]);
		$arItems[$code[1]]=$ar_res["ID"];
	}
		
	foreach($arItems as $code=>$item)
	{
		CIBlockElement::SetPropertyValuesEx($item, false, array("CML2_ARTICLE" => utf8win1251($temp[$code])));
	}
	
	return "update_articles()";
}