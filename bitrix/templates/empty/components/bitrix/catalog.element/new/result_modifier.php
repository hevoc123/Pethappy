<?
$arResult["LIKETHIS"]=Array();

$search=42;

$nav = CIBlockSection::GetNavChain(2, $arResult["IBLOCK_SECTION_ID"]);
while($ar_res=$nav->Fetch()):
	if($ar_res["ID"]==42)
		$search=42;
	if($ar_res["ID"]==60)
		$search=60;
endwhile;

$arSelect = Array("ID", "NAME", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "DETAIL_PICTURE", "CATALOG_GROUP_2");
$arFilter = Array("IBLOCK_ID"=>2, "!ID"=>$arResult["ID"], "SECTION_ID"=>$search, "INCLUDE_SUBSECTIONS"=>"Y", "!SECTION_ID"=>$arResult["IBLOCK_SECTION_ID"], "CATALOG_AVAILABLE"=>"Y");
$res = CIBlockElement::GetList(Array("RAND"=>"DESC"), $arFilter, false, Array("nTopCount"=>3), $arSelect);
while($ar_res = $res->GetNext())
{	
	$arResult["LIKETHIS"][]=$ar_res;
}
?>