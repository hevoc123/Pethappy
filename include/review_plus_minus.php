<?    
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");
CModule::IncludeModule("iblock");

if($_REQUEST["pid"] && $_REQUEST["rid"] && $_REQUEST["type"])
{
	$count=0;
	$review = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>13, "ID"=>$_REQUEST["pid"]), false, false, Array("ID", "NAME", "PROPERTY_YES", "PROPERTY_NO"))->GetNext();
	
	$CODE="YES";
	if($_REQUEST["type"]=="plus")
	{
		$CODE="YES";
		$count=$review["PROPERTY_YES_VALUE"];
	}
	else
	{
		$CODE="NO";
		$count=$review["PROPERTY_NO_VALUE"];
	}
		
	$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");
	$arFilter = Array("IBLOCK_ID"=>14, ">=DATE_CREATE"=>ConvertTimeStamp(time()-86400, "FULL"), "PROPERTY_LINK"=>$_REQUEST["rid"], "PROPERTY_ID"=>$_SERVER["REMOTE_ADDR"]);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	if($res->SelectedRowsCount() > 0)
	{
		$result["status"]="error_ip_isset";
		$result["helpful_count"]=$count;
	}
	else
	{
		$el = new CIBlockElement;

		$PROP = array();
		$PROP[57] = $_SERVER["REMOTE_ADDR"];
		$PROP[58] = $_REQUEST["rid"];

		$arLoadProductArray = Array(
		  "MODIFIED_BY"    => 1,
		  "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
		  "IBLOCK_ID"      => 14,
		  "PROPERTY_VALUES"=> $PROP,
		  "NAME"           => $_REQUEST["pid"]." ".$_REQUEST["rid"]." ".$_REQUEST["type"],
		  "ACTIVE"         => "Y",            // активен
		);

		if($PRODUCT_ID = $el->Add($arLoadProductArray))
		{
			$result["status"]="ok";
			$result["helpful_count"]=$count+1;
			CIBlockElement::SetPropertyValuesEx($_REQUEST["rid"], false, array( $CODE => $result["helpful_count"]));
		}
		else
		{
			$result["status"]="error_upd";
			$result["helpful_count"]=$count;
		}
	}
	
	echo json_encode($result);
}
