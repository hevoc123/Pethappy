<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Авторизация");
$APPLICATION->SetPageProperty("TITLE", "Авторизация");
?><?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "new", Array(
	"COMPONENT_TEMPLATE" => ".default",
		"REGISTER_URL" => "/registration/",	// Страница регистрации
		"FORGOT_PASSWORD_URL" => "/auth/?forgotpassword=Y",	// Страница забытого пароля
		"PROFILE_URL" => "/personal/",	// Страница профиля
		"SHOW_ERRORS" => "Y",	// Показывать ошибки
	),
	false
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>