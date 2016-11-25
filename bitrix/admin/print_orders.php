<?
##############################################
# Bitrix: SiteManager                        #
# Copyright (c) 2002-2006 Bitrix             #
# http://www.bitrixsoft.com                  #
# mailto:admin@bitrixsoft.com                #
##############################################
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sale/include.php");

$saleModulePermissions = $APPLICATION->GetGroupRight("sale");
if ($saleModulePermissions == "D")
    $APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));

ClearVars("l_");

$LOCAL_SITE_LIST_CACHE = array();
$LOCAL_PERSON_TYPE_CACHE = array();
$LOCAL_PAYED_USER_CACHE = array();
$LOCAL_PAY_SYSTEM_CACHE = array();
$LOCAL_DELIVERY_CACHE = array();
$LOCAL_STATUS_CACHE = array();

IncludeModuleLangFile(__FILE__);

$arAccessibleSites = array();
$dbAccessibleSites = CSaleGroupAccessToSite::GetList(
    array(),
    array("GROUP_ID" => $GLOBALS["USER"]->GetUserGroupArray()),
    false,
    false,
    array("SITE_ID")
);

while ($arAccessibleSite = $dbAccessibleSites->Fetch())
{
    if (!in_array($arAccessibleSite["SITE_ID"], $arAccessibleSites))
        $arAccessibleSites[] = $arAccessibleSite["SITE_ID"];
}

$bExport = false;
if($_REQUEST["mode"] == "excel")
    $bExport = true;

CModule::IncludeModule("iblock");CModule::IncludeModule("sale");
?>

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

    <?$APPLICATION->SetAdditionalCSS("/bitrix/templates/empty/styles/bootstrap.min.css");?>
    <?$APPLICATION->SetAdditionalCSS("/bitrix/templates/empty/plugins/fancybox/jquery.fancybox.css");?>
    <?$APPLICATION->SetAdditionalCSS("/bitrix/templates/empty/styles/style.css");?>
    <?$APPLICATION->SetAdditionalCSS("/bitrix/templates/empty/styles/ws.css");?>
    <?$APPLICATION->SetAdditionalCSS("/bitrix/templates/empty/css/magnific-popup.css");?>
    <?$APPLICATION->SetAdditionalCSS("/bitrix/templates/empty/css/jquery.fancybox.css");?>

    <style>
        .header_footer_background	{background: #F5F6F6; height: 110px;}
        .content			{margin:30px auto; width: 1000px; min-height: 390px;}
        .footer 			{position: relative; bottom: 0; width: 100%;}
        .footer_empty 		{position: fixed; bottom: 0; width: 100%;}
        .clear				{clear:both;}
        .logo				{float:left; padding:30px; width: 300px;}
        .logo_img			{width:165px; height:43px;}
        .phone_box			{float:right; padding:30px; width:250px; font-weight: bold;}
        .phone_img			{float:left; width:45px; height:46px;}
        .phone_text			{width:200px; float: right; text-align: left;}
        .phone_text .text	{color:rgba(240,64,54,0.8); font-size:11px; }
        .phone_text .phone	{color:rgb(60,111,174); font-size:22px; letter-spacing: 1px; line-height:28px; }
        .btn-action_print	{width: 100px; height: 35px; background: rgba(240,64,54,0.8); outline: none; border: 1px solid #DE5645;
            border-radius: 1px; color: #FFFFFF; font-size: 19px; padding-bottom: 4px; float: right; margin-right: 300px;}
        .mright {padding-right: 15px;}
        td {line-height: 25px;}
        th {border-bottom: 1px solid #dadada; height: 35px;}
        hr {
            display: block;
            height: 1px;
            border: 0;
            border-top: 1px solid #dadada;
            margin: 1em 0;
            padding: 0;
            font-size: 0;
            line-height: 0;
        }

        table.items td {
            padding: 10px 0;
            border-bottom: 1px solid #dadada; height: 35px;
        }

        table.total td {
            border: none;
            padding: 0 15px 0 0;
            height: auto;
        }

        table.items tfoot td {
            border: none;
        }

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
            .pagebreak {page-break-after: always;}
        }
    </style>

</head>

<body>
<?php
$dbOrderList = CSaleOrder::GetList(
    Array("ID"=>"ASC"),
    Array("ID"=>$_GET["OID"]),
    false,
    false,
    Array()
);

$j=0;
$tmpItems=Array();

while ($arOrder = $dbOrderList->Fetch()) {

    //var_dump($arOrder);
    $props=Array();

    $db_props = CSaleOrderPropsValue::GetOrderProps($arOrder["ID"]);
    while ($arProps = $db_props->Fetch())
    {
        $props[$arProps["CODE"]]=$arProps;
    }
    ?>
    <div class="header_footer_background" style="height: 150px; background: none;">
        <div class="logo">
            <h2 style="margin: 0;">№<?=$arOrder["ID"]?></h2>
            Дата заказа <?=$arOrder["DATE_INSERT"]?><br />
            Тип доставки: <b><?if($arOrder["DELIVERY_ID"]==4):?>Самовывоз<?elseif($arOrder["DELIVERY_ID"]==5):?>Курьер<?elseif($arOrder["DELIVERY_ID"]=="rus_post:land"):?>Почта<?else:?>ПЭК<?endif?></b><br />
            Оплата: <b><?if($arOrder["PAY_SYSTEM_ID"]==3):?>Наличными<?else:?>Картой<?endif;?> (<?=( $arOrder["PAYED"]=="Y" ? "оплачен" : "не оплачен")?>)</b><br />
        </div>
        <div class="phone_box">
            <div>
                <a href="/" title="Интернет-зоомагазин Pethappy.ru"><img class="logo_img" src="/bitrix/templates/empty/img/logo.png" alt="Интернет-зоомагазин Pethappy.ru"></a>
            </div>
            <div class="phone_img">
                <a href="/" title="Интернет-зоомагазин Pethappy.ru"><img src="/images/print-phone_time.png" alt="Интернет-зоомагазин Pethappy.ru"></a>
            </div>
            <div class="phone_text">
                <div class="text">Заказ по телефону с 10 до 20</div>
                <div class="phone">8 (495) 649-03-03</div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <hr />
    <div id="content" class="content" style="min-height: 650px; padding: 0 30px; ">
        <table>
            <tr>
                <td style="padding-right: 25px;" width="30%">
                    <b>Информация о заказе</b><br /><br />
                    <table>
                        <tr>
                          <td class="mright">Имя:</td><td><?=$props["FIO"]["VALUE"]?></td>
                        </tr>
                        <tr>
                          <td class="mright">Телефон:</td><td><?=$props["PHONE"]["VALUE"]?></td>
                        </tr>
                        <tr>
                          <td class="mright">E-mail:</td><td><?=$props["EMAIL"]["VALUE"]?></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <?if($props["LOCATION"]["VALUE"] || $props["ADDRESS"]["VALUE"]):?>
                        <b>Адрес доставки</b><br /><br />
                        <table>
                          <?if($props["LOCATION"]["VALUE"]):?>
                              <tr>
                                  <?php
                                  $location=CSaleLocation::GetByID($props["LOCATION"]["VALUE"]);
                                  ?>
                                  <td class="mright">Город:</td><td><?=( $props["LOCATION"]["VALUE"]==19 ? "Москва" : ( $props["ZIP"]["VALUE"] ?  $props["ZIP"]["VALUE"].", " : "").( $location["REGION_NAME_ORIG"] ? $location["REGION_NAME_ORIG"].", " : "")." ".$location["CITY_NAME"]);?></td>
                              </tr>
                          <?endif;?>
                          <?if($props["ADDRESS"]["VALUE"]):?>
                              <tr>
                                  <td class="mright">Адрес:</td><td><?=$props["ADDRESS"]["VALUE"]?></td>
                              </tr>
                          <?endif?>
                        </table>
                    <?endif?>
                </td>
            </tr>
        </table>
        <br />
        <h4>Содержание заказа</h4>
        <table width="100%" style="margin-top: 25px;" class="items">
            <thead>
                <tr>
                    <th>Артикул</th>
                    <th style="width: 580px">Название</th>
                    <th>Фасовка</th>
                    <th>Цена</th>
                    <th>Кол-во</th>
                    <th>Стоимость</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $dbItems=CSaleBasket::GetList(Array("NAME"=>"ASC"), Array("ORDER_ID"=>$arOrder["ID"]));
            while ($arItems=$dbItems->Fetch()) {

                $fasovka=$article="";
                $temp=CIBlockElement::GetList(Array(), Array("ID"=>$arItems["PRODUCT_ID"]), false, false, Array("ID", "IBLOCK_ID", "PROPERTY_CML2_ARTICLE", "PROPERTY_IMYIE_CML2ATTR_FASOVKA"))->GetNext();
                if($temp["IBLOCK_ID"]==4)
                {
                    $fasovka=$temp["PROPERTY_IMYIE_CML2ATTR_FASOVKA_VALUE"];
                    $article=$temp["PROPERTY_CML2_ARTICLE_VALUE"];
                }
                else {
                    $temp = CIBlockElement::GetList(Array(), Array("IBLOCK_ID" => 2, "ID" => $item["PRODUCT_ID"]), false, false, Array("ID", "IBLOCK_ID", "PROPERTY_CML2_ARTICLE"))->GetNext();
                    $article=$temp["PROPERTY_CML2_ARTICLE_VALUE"];
                }
            ?>
                <tr>
                    <td align="center"><?=$article?></td>
                    <td><b><?=$arItems["NAME"]?></b></td>
                    <td align="center"><?=$fasovka?></td>
                    <td align="center"><?=number_format($arItems["PRICE"], 0, ".", " " )?> р.</td>
                    <td align="center"><?=$arItems["QUANTITY"]?></td>
                    <td align="center"><?=number_format($arItems["PRICE"]*$arItems["QUANTITY"], 0, ".", " " )?> р.</td>
                </tr>
            <?php
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" align="right">
                        <table class="total">
                            <tr>
                                <td style="mright">Стоимость заказа:</td><td><?=number_format($arOrder["PRICE"]-$arOrder["PRICE_DELIVERY"], 0, ".", " ")?> р.</td>
                            </tr>
                            <?if($arOrder["PRICE_DELIVERY"]):?>
                            <tr>
                                <td class="mright">Стоимость доставки:</td><td><?=number_format($arOrder["PRICE_DELIVERY"], 0, ".", " ")?> р.</td>
                            </tr>
                            <?endif;?>
                            <tr>
                                <td class="mright"><b>Итого:</b></td><td><b><?=number_format($arOrder["PRICE"], 0, ".", " ")?> р.</b></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="pagebreak"></div>
    <?php
}
?>
</body>
</html>