<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?if($_REQUEST['SEBEKON_RM'] && isset($_SESSION['SEBEKON_RM'][$_REQUEST['SEBEKON_RM']])):?>
<link href="/bitrix/components/sebekon/reminder.form/templates/.default/style.css" type="text/css" rel="stylesheet" />
<script src="/bitrix/js/sebekon.reminder/jquery-1.8.0.min.js" type="text/javascript" ></script>
<?$APPLICATION->IncludeComponent(
	"sebekon:reminder.form",
	"",
	$_SESSION['SEBEKON_RM'][$_REQUEST['SEBEKON_RM']],
false
);?>
<?endif;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>