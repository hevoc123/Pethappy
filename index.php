<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetPageProperty("description", "������ ������� Pethappy.ru ���������� ��� �������� ��������� ��� ����� � ����� �� ��������� ���� � ������. ���� ����������� �������� ��������. ������, ��������� ������� ������.");
$APPLICATION->SetPageProperty("TITLE", "��������-������� ���������� Pethappy.ru : ������ ���� �������� | ����� ����� ������� ������ | ���������� ������ ������");
$APPLICATION->SetPageProperty("keywords", "�������� ����, ������ ��� ��������, �������� ������� ����������, ������ ����������� ��� ��������");
$APPLICATION->SetTitle("�������");
?><?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"main_sec",
	Array(
		"ADD_SECTIONS_CHAIN" => "Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COUNT_ELEMENTS" => "Y",
		"IBLOCK_ID" => "2",
		"IBLOCK_TYPE" => "1c_catalog",
		"SECTION_CODE" => "",
		"SECTION_FIELDS" => array("",""),
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array("",""),
		"SHOW_PARENT_NAME" => "Y",
		"TOP_DEPTH" => "2",
		"VIEW_MODE" => "LINE"
	),
$component,
Array(
	'HIDE_ICONS' => 'Y'
)
);?>

<div id="slider_banner">	
	<div class="slider-main">
		<?
		$result="";
		$arSelect = Array("ID", "NAME", "PREVIEW_PICTURE", "PROPERTY_LINK");
		$arFilter = Array("IBLOCK_ID"=>8, "ACTIVE"=>"Y");
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		while($ar_res = $res->GetNext())
		{
		?>
			<div class="slide">
				<a href="<?=$ar_res["PROPERTY_LINK_VALUE"]?>">
					<img src="<?=CFile::GetPath($ar_res["PREVIEW_PICTURE"]);?>">
				</a>
			</div>
		<?
		$result.='<div data-mdac="'.$ar_res["ID"].'" style="display: none"></div>';
		}
		?>
	</div>
	<?echo $result;?>
</div> 
<?
		$tmp_selected=$tmp_elem=Array();
		$res = CIBlockElement::GetList(Array("ID"=>"DESC"), Array("IBLOCK_ID"=>4, ">CATALOG_QUANTITY"=>0, ">CATALOG_PRICE_2" => 0), false, Array("nTopCount"=>30), Array("PROPERTY_CML2_LINK"));
		while($ar_res = $res->GetNext())
		{
			$tmp_selected[]=$ar_res["PROPERTY_CML2_LINK_VALUE"];
		}	
		
		$tmp_selected=array_unique($tmp_selected);

		/*if(!empty($tmp_selected))	
			$GLOBALS["arrFilter"][]=array(
						"LOGIC" => "OR",
						array(">CATALOG_QUANTITY"=>0),
						array("ID" => $tmp_selected),
					);
		else
		{
			$GLOBALS["arrFilter"][">CATALOG_QUANTITY"]=0;
		}*/
		
		//$GLOBALS["arrFilter"]=Array();
		
		$res = CIBlockElement::GetList(Array("ID"=>"DESC"), Array("IBLOCK_ID"=>2, ">CATALOG_QUANTITY"=>0, ">CATALOG_PRICE_2" => 0), false, Array("nTopCount"=>30), Array("ID", "NAME"));
		while($ar_res = $res->GetNext())
		{
			$tmp_elem[]=$ar_res["ID"];
		}
		
		$GLOBALS["arrFilter"]["ID"]=array_merge($tmp_elem, $tmp_selected);
		
		$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"main_new", 
	array(
		"TEMPLATE_THEME" => "blue",
		"PRODUCT_SUBSCRIPTION" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "Y",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"SHOW_CLOSE_POPUP" => "N",
		"MESS_BTN_BUY" => "������",
		"MESS_BTN_ADD_TO_BASKET" => "� �������",
		"MESS_BTN_SUBSCRIBE" => "�����������",
		"MESS_BTN_DETAIL" => "���������",
		"MESS_NOT_AVAILABLE" => "��� � �������",
		"AJAX_MODE" => "N",
		"IBLOCK_TYPE" => "1c_catalog",
		"IBLOCK_ID" => "2",
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"ELEMENT_SORT_FIELD" => "RAND",
		"ELEMENT_SORT_ORDER" => "desc",
		"ELEMENT_SORT_FIELD2" => "RAND",
		"ELEMENT_SORT_ORDER2" => "desc",
		"FILTER_NAME" => "arrFilter",
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"BROWSER_TITLE" => "-",
		"SET_META_KEYWORDS" => "N",
		"META_KEYWORDS" => "-",
		"SET_META_DESCRIPTION" => "Y",
		"META_DESCRIPTION" => "-",
		"ADD_SECTIONS_CHAIN" => "N",
		"DISPLAY_COMPARE" => "N",
		"SET_STATUS_404" => "N",
		"PAGE_ELEMENT_COUNT" => "16",
		"LINE_ELEMENT_COUNT" => "4",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "ves",
			2 => "",
		),
		"OFFERS_LIMIT" => "5",
		"PRICE_CODE" => array(
			0 => "���� �������",
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "N",
		"BASKET_URL" => "/personal/cart/",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"USE_PRODUCT_QUANTITY" => "N",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => array(
		),
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_NOTES" => "",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "������",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"HIDE_NOT_AVAILABLE" => "N",
		"CONVERT_CURRENCY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"COMPONENT_TEMPLATE" => "main_new",
		"OFFERS_FIELD_CODE" => array(
			0 => "NAME",
			1 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "CML2_ARTICLE",
			1 => "",
		),
		"OFFERS_SORT_FIELD" => "CATALOG_PRICE_2",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "desc",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"ADD_PICT_PROP" => "MORE_PHOTO",
		"LABEL_PROP" => "-",
		"OFFER_ADD_PICT_PROP" => "-",
		"OFFER_TREE_PROPS" => array(
			0 => "CML2_MANUFACTURER",
		),
		"MESS_BTN_COMPARE" => "��������",
		"OFFERS_CART_PROPERTIES" => array(
		),
		"BACKGROUND_IMAGE" => "-",
		"SEF_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"SET_LAST_MODIFIED" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N"
	),
	false
);?>
<?php
$detailtext = <<<EOT
<div class="grey-bg">
	<div class="inner">
		<div class="bottom-text">
			<p align="center"><strong>��� ������� ������������� �����?</strong></p><br />
			<p align="justify">� ���������� � ���� ������� ��� ����� ����� ��������� � ������ ������� ������ ������ � ���, ��� ������� �������? ���� ������ ��������������� ������������ ���������, ��������� ����������� ��� ���������� � ��������� ������������ ������ ��������. ����������� ��������� ������� �������� �������� �������� ���� (Grandorf, GO! Natural Holistic, Now Natural Holistic, Savarra, Barking Heads). � ������ ��� ������ ������ ����������� ������������ �����������, ��������� � ���� �����. ��������, ������ ���� �������, �������, ��������, ����. ��� �������� ���������, �������������� �������� ��������� ������������ ��������������. ������� ����������� �����, ����� � �����: ���������, �������, ��������, ��������, ���, ������; ������� ��������������� ����� ���������; ������ � ��������� ��������� �, �, �, D. �������� ���������� ��� ��������� �������� ������� ���������, �������� ��������� ��������� �������, ������� ������. � ������� ������ �������� ������ ���������� ������ ������� �����-6, �����-3, ���������� � ����������. &nbsp;��� ���������� ��� �������� � ����������� ��������.</p>
			<p align="justify">&nbsp;</p>
			<p><strong>������������ � �������!</strong></p>
			<p style="text-align: justify;">�������� ���� �� �������� ���������� ������� � ������������, ���������� �����, ����������. � ��� ��� ��������, ���, ������������ � ����������. �� �������� ��������� �����������, ���� ����� �������� (����� ��� ����) ������ � ������ ��������, ������ ���������� �����, ���������, ���������. ������������� �� �������� ������ ����� �� ������������� �������������� ��������� ��������� �������������� � ����������� ������������. ����� ��� ������ ��������������. ����� ����� ������ ������������� ��� �������� ����� ��������, ����������� �������� � ��������� ����������. ���������� �� � ����������, ��� ���������� ���������� ��������. ������ ������� ������ � ��������� ���������� ����� ���� ������ �������.</p>
			<p style="text-align: justify;">����� ����������� ��� ����� � ����� ������ ����� � ��������� � ������ ��������� �������� (��� ������ � �����; �������� ������; �������; ���������� � �������� �����; ��������, ���������� ���������, ���������� ����� ��� ������� ������ �������� �� ���������).</p>
			<p style="text-align: justify;">������������ ����� �������� �������� ���������� ��������������, ������� �������� �������� ������������ �� ��� ��������. ����������� ������� �������� � ����� �������, ����� ������� ������.</p>
			<p style="text-align: justify;">��� ���� ������������� ��� ����������� ���������� ���� ��������, ������� ��� �� ��������� � ��� ����������� ��������� ���� �����!</p>
		</div>
	</div>
</div>
EOT;

$APPLICATION->AddViewContent("detailtext", $detailtext);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
