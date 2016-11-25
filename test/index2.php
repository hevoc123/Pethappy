<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
CModule::IncludeModule("iblock");
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

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>