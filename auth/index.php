<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("�����������");
$APPLICATION->SetPageProperty("TITLE", "�����������");
?><?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "new", Array(
	"COMPONENT_TEMPLATE" => ".default",
		"REGISTER_URL" => "/registration/",	// �������� �����������
		"FORGOT_PASSWORD_URL" => "/auth/?forgotpassword=Y",	// �������� �������� ������
		"PROFILE_URL" => "/personal/",	// �������� �������
		"SHOW_ERRORS" => "Y",	// ���������� ������
	),
	false
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>