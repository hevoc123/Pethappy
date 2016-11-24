<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">

	<!-- Адаптируем страницу для мобильных устройств -->
	<meta name="viewport" content="width=360, maximum-scale=1.0, user-scalable=0">
	<meta name="format-detection" content="telephone=no">

	<meta name="revisit-after" content="1 day">
	<link rel="icon" href="/favicon.ico" type="image/x-icon"/>
	<title><?$APPLICATION->ShowTitle();?></title>
	<?$APPLICATION->ShowHead();?>
	<!-- Иконка сайта для устройств от Apple, рекомендуемый размер 114x114, прозрачность не поддерживается -->
	<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
	<?
    CJSCore::Init(array("jquery"));
	?>
	<?$APPLICATION->AddHeadScript("/bitrix/templates/empty/scripts/jquery-ui.min.js");?>
	<?$APPLICATION->AddHeadScript("/bitrix/templates/empty/scripts/widget.js");?>
	<?$APPLICATION->AddHeadScript("/bitrix/templates/empty/scripts/jquery.maskedinput.min.js");?>
	<?$APPLICATION->AddHeadScript("/bitrix/templates/empty/scripts/jquery.mousewheel.js");?>
	<?$APPLICATION->AddHeadScript("/bitrix/templates/empty/scripts/mwheelIntent.js");?>
	<?$APPLICATION->AddHeadScript("/bitrix/templates/empty/scripts/jquery.jscrollpane.min.js");?>
	<?$APPLICATION->AddHeadScript("/bitrix/templates/empty/scripts/scripts.js");?>
	<?$APPLICATION->AddHeadScript("/bitrix/templates/empty/js/social_auth_popup.js");?>
	<?$APPLICATION->AddHeadScript("/bitrix/templates/empty/blind/h_page_blocks.js");?>	
	
	<?$APPLICATION->AddHeadScript("/bitrix/templates/empty/scripts/common.js");?>
	
	<?$APPLICATION->AddHeadScript("/bitrix/templates/empty/js/owox.js");?>
	<?$APPLICATION->AddHeadScript("/bitrix/templates/empty/plugins/slick.min.js");?>
	<?$APPLICATION->AddHeadScript("/bitrix/templates/empty/js/jquery.magnific-popup.min.js");?>
	<?$APPLICATION->AddHeadScript("/bitrix/templates/empty/scripts/jquery.fancybox.pack.js");?>
	
	<?$APPLICATION->SetAdditionalCSS("/bitrix/templates/empty/styles/bootstrap.min.css");?>
	<?$APPLICATION->SetAdditionalCSS("/bitrix/templates/empty/plugins/fancybox/jquery.fancybox.css");?>
	<?$APPLICATION->SetAdditionalCSS("/bitrix/templates/empty/styles/style.css");?>
	<?$APPLICATION->SetAdditionalCSS("/bitrix/templates/empty/styles/ws.css");?>
	<?$APPLICATION->SetAdditionalCSS("/bitrix/templates/empty/css/magnific-popup.css");?>
	<?$APPLICATION->SetAdditionalCSS("/bitrix/templates/empty/css/jquery.fancybox.css");?>
	<!-- Подключаем файлы стилей -->

	<style>
		.header_footer_background	{background: #F5F6F6; height: 110px;}
		.content			{margin:30px auto; width: 1000px; min-height: 390px;}
		.footer 			{position: relative; bottom: 0; width: 100%;}
		.footer_empty 		{position: fixed; bottom: 0; width: 100%;}
		.clear				{clear:both;}
		.logo				{float:left; padding:30px; width: 300px;}
		.logo_img			{width:165px; height:43px;}
		.phone_box			{float:right; padding:30px; width:255px; font-weight: bold;}
		.phone_img			{float:left; width:45px; height:46px;}
		.phone_text			{width:200px; float: right; text-align: right;}
		.phone_text .text	{color:rgba(240,64,54,0.8); font-size:11px; }
		.phone_text .phone	{color:rgb(60,111,174); font-size:22px; letter-spacing: 1px; line-height:28px; }
		.btn-action_print	{width: 100px; height: 35px; background: rgba(240,64,54,0.8); outline: none; border: 1px solid #DE5645;
							border-radius: 1px; color: #FFFFFF; font-size: 19px; padding-bottom: 4px; float: right; margin-right: 300px;}

		@media print {
			@page  				{margin:30px;}
			* 					{color: #000 !important; text-shadow: none !important; box-shadow: none !important; /*background: transparent !important;*/}
			.content			{min-height: 1000px;}
			.footer_print 		{position: relative !important; bottom: 0; width: 100%;}
			.btn-action_print	{display:none;}
			a, a:visited		{text-decoration: underline;}
			a[href]:after		{content: "";}
			/*a[href]:after 	{content: " (" attr(href) ")";}*/
			abbr[title]:after	{content: " (" attr(title) ")"; }
			a:after, a[href^="javascript:"]:after, a[href^="#"]:after { content: "";}
			img 				{ page-break-inside: avoid;}
			p, h2, h3 			{ orphans: 3; widows: 3;}
			h2, h3 				{ page-break-after: avoid;}
		}
	</style>
	
</head>

<body>
<?
CModule::IncludeModule("catalog"); CModule::IncludeModule("sale"); CModule::IncludeModule("iblock");
$dbBasketItems = CSaleBasket::GetList(array("NAME" => "ASC", "ID" => "ASC"), array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL"), false, false, array("ID", "QUANTITY"));
$bcount=$dbBasketItems->SelectedRowsCount();
?>
<?//$APPLICATION->ShowPanel();?>
	<div class="header_footer_background">
		<div class="logo">
			<a href="/" title="Интернет-зоомагазин Pethappy.ru"><img class="logo_img" src="/bitrix/templates/empty/img/logo.png" alt="Интернет-зоомагазин Pethappy.ru"></a>
		</div>
		<div class="phone_box">
			<div class="phone_img">
				<? /*<a href="/" title="Интернет-зоомагазин Pethappy.ru"><img src="/images/print-phone_time.png" alt="Интернет-зоомагазин Pethappy.ru"></a>*/ ?>
			</div>
			<div class="phone_text">
				<div class="text">Заказ по телефону с 10 до 20 </div>
				<div class="phone">8 (495) 649-03-03</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
	<div id="content" class="content" style="min-height: 650px;">