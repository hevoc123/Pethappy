<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?><?$APPLICATION->IncludeComponent("bitrix:main.register", "new", Array(
	"AUTH" => "Y",	// ������������� ������������ �������������
		"REQUIRED_FIELDS" => array(	// ����, ������������ ��� ����������
			0 => "EMAIL",
			1 => "PERSONAL_PHONE",
		),
		"SET_TITLE" => "Y",	// ������������� ��������� ��������
		"SHOW_FIELDS" => array(	// ����, ������� ���������� � �����
			0 => "EMAIL",
			1 => "NAME",
			2 => "PERSONAL_PHONE",
		),
		"SUCCESS_PAGE" => "/personal/",	// �������� ��������� �����������
		"USER_PROPERTY" => "",	// ���������� ���. ��������
		"USER_PROPERTY_NAME" => "",	// �������� ����� ���������������� �������
		"USE_BACKURL" => "Y",	// ���������� ������������ �� �������� ������, ���� ��� ����
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>