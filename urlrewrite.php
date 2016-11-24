<?
$arUrlRewrite = array(
	array(
		"CONDITION" => "#^={\$arResult[\"FOLDER\"].\$arResult[\"URL_TEMPLATES\"][\"smart_filter\"]}\\??(.*)#",
		"RULE" => "&\$1",
		"ID" => "bitrix:catalog.smart.filter",
		"PATH" => "/bitrix/templates/empty/components/bitrix/catalog/new/section.php",
	),
	array(
		"CONDITION" => "#^/products/([a-zA-Z0-9_-]+)/rating#",
		"RULE" => "ELEMENT_CODE=\$1",
		"ID" => "",
		"PATH" => "/reviews/index.php",
	),
	array(
		"CONDITION" => "#^/products/([a-zA-Z0-9_-]+)(.*)#",
		"RULE" => "ELEMENT_CODE=\$1",
		"ID" => "",
		"PATH" => "/products/index.php",
	),
	array(
		"CONDITION" => "#^/bitrix/services/ymarket/#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/bitrix/services/ymarket/index.php",
	),
	array(
		"CONDITION" => "#^/personal/history/#",
		"RULE" => "",
		"ID" => "bitrix:sale.personal.order",
		"PATH" => "/personal/history/index.php",
	),
	array(
		"CONDITION" => "#^/manufacturers/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/manufacturers/index.php",
	),
	array(
		"CONDITION" => "#^/categories/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/categories/index.php",
	),
	array(
		"CONDITION" => "#^/news/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/news/index.php",
	),
	array(
		"CONDITION" => "#^/blog/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/blog/index.php",
	),
);

?>