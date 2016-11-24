<?
//var_dump($arResult);
$arFilter = Array('IBLOCK_ID'=>10, 'ID'=>$arResult["SECTION"]["PATH"][0]["ID"]);
$db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, false, Array("ID", "NAME", "UF_*"));
while($ar_result = $db_list->GetNext())
{
	$APPLICATION->SetPageProperty("title", $ar_result["UF_TITLE"]);
	$APPLICATION->SetPageProperty("description", $ar_result["UF_DESCRIPTION"]);
	$APPLICATION->SetPageProperty("keywords", $ar_result["UF_KEYWORDS"]);
	//var_dump($ar_result);
	//echo $ar_result['ID'].' '.$ar_result['NAME'].': '.$ar_result['ELEMENT_CNT'].'<br>';
}
