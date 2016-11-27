<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
CModule::IncludeModule("iblock"); CModule::IncludeModule("sale");
/*
$data = array();
if (($handle = fopen($_SERVER["DOCUMENT_ROOT"]."/upload/products_20161109114220.csv", 'r')) !== FALSE)
{
	$i=0;
	
	while (($row = fgetcsv($handle, 0, ";")) !== FALSE)
	{
		$i++;
		if($i==1) continue;
		
		$arSelect = Array("ID", "NAME");
		
		//var_dump($row[1]);
		$arFilter = Array("IBLOCK_ID"=>2, "NAME"=>$row[1]);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount"=>1), $arSelect);
		if($ar_res = $res->GetNext())
		{
			/*$more_photos=Array();
									
			$temp=explode(";", $row[20]);
			
			foreach($temp as $i=>$tmp) 
			{
				$basename=$tmp;
				
				if($i==0)
				{				
					if(!strstr($tmp, "http")) $tmp="http://pethappy.ru/pictures/product/big/".$basename;
					
					$tmp=str_replace(".j", "_big.j", $tmp);
					$tmp=str_replace(".p", "_big.p", $tmp);				
					
					//var_dump($tmp);
					
					$out = file_get_contents($tmp);  
					$person_photo = $_SERVER["DOCUMENT_ROOT"].'/temp/'.$basename;
					$img_sc = file_put_contents($person_photo, $out);

					$el = new CIBlockElement;
					
					$arLoadProductArray = Array(
						"MODIFIED_BY"    => 1,
						"DETAIL_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].'/temp/'.$basename)
					);
					
					if($res = $el->Update($ar_res["ID"], $arLoadProductArray))
					 echo "New ID: ".$ar_res["ID"]." ".$basename."<br />";
					else
					  echo "Error: ".$el->LAST_ERROR."<br />";
				}
				else
					if(strlen($tmp) > 0)
					{
						
						if(!strstr($tmp, "http")) $tmp="http://pethappy.ru/pictures/product/big/".$basename;
						
						$tmp=str_replace(".j", "_big.j", $tmp);
						$tmp=str_replace(".p", "_big.p", $tmp);
												
						$out = file_get_contents($tmp);  
						$person_photo = $_SERVER["DOCUMENT_ROOT"].'/temp/'.$basename;
						$img_sc = file_put_contents($person_photo, $out);  
						
						$more_photos["n".($i-1)]=Array("VALUE"=>CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].'/temp/'.$basename));
					}
			}
			
			if(!empty($more_photos))
			{
				CIBlockElement::SetPropertyValuesEx($ar_res["ID"], false, array("MORE_PHOTO" => $more_photos));  
			}
			
		}		
	}
	fclose($handle);
}
//return $data;*/
?>
    <span style="display: block;font-size: 18px; color: #436DAD; margin: 0;">Заказ №1234</span>
    Дата заказа 23.11.2016 13:44<br />
    Тип доставки: <b><?if($arOrder["DELIVERY_ID"]==4):?>Самовывоз<?elseif($arOrder["DELIVERY_ID"]==5):?>Курьер<?elseif($arOrder["DELIVERY_ID"]=="rus_post:land"):?>Почта<?else:?>ПЭК<?endif?></b><br />
    Оплата: <b><?if($arOrder["PAY_SYSTEM_ID"]==3):?>Наличными<?else:?>Картой<?endif;?> (<?=( $arOrder["PAYED"]=="Y" ? "оплачен" : "не оплачен")?>)</b><br />

    <hr />

    <table>
        <tr>
            <td style="padding-right: 25px;" valign="top" width="50%">
                <b>Информация о заказе</b><br /><br />
                <table>
                    <tr>
                        <td style="padding-right: 15px;">Имя:</td><td><?=$props["FIO"]["VALUE"]?></td>
                    </tr>
                    <tr>
                        <td style="padding-right: 15px;">Телефон:</td><td><?=$props["PHONE"]["VALUE"]?></td>
                    </tr>
                    <tr>
                        <td style="padding-right: 15px;">E-mail:</td><td><?=$props["EMAIL"]["VALUE"]?></td>
                    </tr>
                </table>
            </td>
            <td valign="top">
                <?if(true || $props["LOCATION"]["VALUE"] || $props["ADDRESS"]["VALUE"]):?>
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
    <span style="display: block; font: normal normal 16px 'textbooknewreg', Arial, Helvetica, sans-serif;">Содержание заказа</span>
    <table width="100%" style="margin-top: 15px;" class="items">
        <thead>
        <tr>
            <th style="border-bottom: 1px solid #dadada; height: 35px;">Артикул</th>
            <th style="width: 280px; border-bottom: 1px solid #dadada; height: 35px;">Название</th>
            <th style="border-bottom: 1px solid #dadada; height: 35px;">Фасовка</th>
            <th style="border-bottom: 1px solid #dadada; height: 35px;">Цена</th>
            <th style="border-bottom: 1px solid #dadada; height: 35px;">Кол-во</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $dbItems=CSaleBasket::GetList(Array("NAME"=>"ASC"), Array("ORDER_ID"=>6956));
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
                <td valign="top" align="center" style="padding: 10px 0; border-bottom: 1px solid #dadada;"><?=$article?></td>
                <td valign="top" style="padding: 10px 0; border-bottom: 1px solid #dadada;"><b><?=$arItems["NAME"]?></b></td>
                <td valign="top" align="center" style="padding: 10px 0; border-bottom: 1px solid #dadada;"><?=$fasovka?></td>
                <td valign="top" align="center" style="padding: 10px 0; border-bottom: 1px solid #dadada;"><?=number_format($arItems["PRICE"], 0, ".", " " )?> р.</td>
                <td valign="top" align="center" style="padding: 10px 0; border-bottom: 1px solid #dadada;"><?=$arItems["QUANTITY"]?></td>
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

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>