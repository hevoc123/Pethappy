<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
</head>
<body>
<? if (\Bitrix\Main\Loader::includeModule('mail')) : ?>
    <?= \Bitrix\Mail\Message::getQuoteStartMarker(true); ?>
<? endif; ?>
<?
$protocol = \Bitrix\Main\Config\Option::get("main", "mail_link_protocol", 'https', $arParams["SITE_ID"]);
$serverName = $protocol . "://" . $arParams["SERVER_NAME"];
?>
<body class="" data-bx-block-editor-block-status="content"
      style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100% !important;margin: 0;padding: 0;font-family: Arial, Helvetica, sans-serif;width: 100% !important;background: url(http://ph.1c-store.ru/images/pets_1.jpg) !important;">
<div style="width: 100%; padding-top: 15px; background: url(http://ph.1c-store.ru/images/pets_1.jpg);">
    <div class="mail-wrap" style="background: #FFFFFF;width: 640px; margin: 0 auto;">
        <center>
            <ul class="menu cleara" style="display: block;height: 35px; background: #436DAD; color: #FFF; padding: 0;margin: 0;list-style: outside none none;">
                <li style="float: left;margin-left: 20px;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;">
                    <a href="http://promuscles.ru/personal/" style="color: #FFF;font: 13px/34px Arial, sans-serif;display: block;word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;">Личный
                        кабинет</a>
                </li>
                <li style="float: left;margin-left: 20px;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;">
                    <a href="http://promuscles.ru/personal/cart/" style="color: #FFF;font: 13px/34px Arial, sans-serif;display: block;word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;">Корзина</a>
                </li>
                <li style="float: left;margin-left: 20px;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;">
                    <a href="http://promuscles.ru/news/" style="color: #FFF;font: 13px/34px Arial, sans-serif;display: block;word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;">Новости</a>
                </li>
                <li style="float: left;margin-left: 20px;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;">
                    <a href="http://promuscles.ru/contact/" style="color: #FFF;font: 13px/34px Arial, sans-serif;display: block;word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;">Контакты</a>
                </li>
                <li style="clear: both;float: left;margin-left: 20px;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;"></li>
            </ul>
            <div style="background: #F5F6F6; height: 77px;">
                <div style="float: left; padding: 15px 30px; width: 170px;">
                    <a href="http://ph.1c-store.ru" title="Интернет-зоомагазин Pethappy.ru">
                        <img style="width: 165px; height: 43px;" src="http://ph.1c-store.ru/bitrix/templates/empty/img/logo.png" alt="Интернет-зоомагазин Pethappy.ru">
                    </a>
                </div>
                <div style="float: right; padding: 15px 30px; width: 250px; font-weight: bold;">
                    <div style="float: left; width: 45px; height: 46px;">
                        <a href="http://ph.1c-store.ru" title="Интернет-зоомагазин Pethappy.ru"><img src="http://ph.1c-store.ru/images/print-phone_time.png" alt="Интернет-зоомагазин Pethappy.ru"></a>
                    </div>
                    <div style="width: 200px; float: right; text-align: left;">
                        <div style="color: rgba(240,64,54,0.8); font-size: 11px;">Заказ по телефону с 10 до 20 </div>
                        <div style="color: rgb(60,111,174); font-size: 22px; letter-spacing: 1px; line-height: 28px;">8 (495) 649-03-03</div>
                    </div>
                </div>
            </div>

            <table class="mail-grid" width="100%" border="0" cellpadding="0" cellspacing="0" align="center"
                   style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;table-layout: fixed;">
                <tbody>
                <tr>
                    <td id="bxStylistBody" class="" data-bx-block-editor-block-status="content"
                        style="padding-top: 10px;padding-bottom: 20px;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;">


                        <table class="mail-grid" width="100%" border="0" cellpadding="0" cellspacing="0"
                               style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;table-layout: fixed;">
                            <tbody>
                            <tr>
                                <td style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;">

                                    <table class="mail-grid-cell" width="100%" border="0" cellspacing="0"
                                           cellpadding="0" align="center"
                                           style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;table-layout: fixed;">
                                        <tbody>
                                        <tr>
                                            <td data-bx-block-editor-place="body"
                                                style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;">
                                                <div data-bx-block-editor-block-type="text">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                           class="bxBlockText"
                                                           style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;table-layout: fixed;">
                                                        <tbody class="bxBlockOut">
                                                        <tr>
                                                            <td valign="top" class="bxBlockInn bxBlockInnText"
                                                                style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;">
                                                                <table align="left" border="0" cellpadding="0"
                                                                       cellspacing="0" width="100%"
                                                                       style="-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;table-layout: fixed;">
                                                                    <tbody>
                                                                    <tr>

                                                                        <td valign="top"
                                                                            class="bxBlockPadding bxBlockContentText"
                                                                            style="padding-top: 9px;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;padding: 9px 18px 9px 18px;font-size: 13px;margin: 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;mso-line-height-rule: exactly;">

                                                                            <!-- ***************** END HEADER  ********************-->


                                                                            <!-- ***************** CONTENT  ********************-->
                                                                            <!-- CONTENT -->
		