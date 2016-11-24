<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require($_SERVER["DOCUMENT_ROOT"]."/test/phpquery.php");
$APPLICATION->SetTitle("Title");
CModule::IncludeModule("iblock");

$html = file_get_contents('http://pethappy.ru/news?page=0');
//var_dump($html);
$document = phpQuery::newDocument($html);

$hentry = $doc ument->find('li.news-item');

foreach ($hentry as $li) {
	$item = pq($li);
	//var_dump($item);
	$name = utf8win1251($item->find('.news-title a')->text());
	$img="http://pethappy.ru/".$item->find(".news-img img")->attr("src");
	$date = $item->find('.news-date')->text();
	$descr = utf8win1251(strip_tags($item->find('.news-descr')->html()));
	
	$url = "http://pethappy.ru/".$item->find('.news-title a')->attr("href");
	
	$code=str_replace("news/", "", $item->find('.news-title a')->attr("href"));
		
	var_dump($code);
	
	$html = file_get_contents($url);
	
	$ddocument = phpQuery::newDocument($html);
	
	$ddesc = utf8win1251($ddocument->find('.news-descr')->html());
		  
	$dimg=$ddocument->find('.news-descr img')->attr("src");
		
	$pic=file_get_contents("http://pethappy.ru/".$dimg);
	file_put_contents($_SERVER["DOCUMENT_ROOT"].'/upload/'.basename($dimg), $pic);
	
	$ddesc=str_replace("userfiles/", "/upload/", $ddesc);
	
	$pic = file_get_contents($img);
	file_put_contents($_SERVER["DOCUMENT_ROOT"].'/test/temp.jpg', $pic);
	
	$el = new CIBlockElement;
	
	$arLoadProductArray = Array(
	  "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
	  "IBLOCK_ID"      => 11,
	  "CODE" => $code,
	  "DATE_ACTIVE_FROM" => ConvertTimeStamp(strtotime($date), "FULL"),
	  "NAME"           => trim($name),
	  "PREVIEW_TEXT"   => trim($descr),
	  "DETAIL_TEXT"    => $ddesc,
	  "DETAIL_TEXT_TYPE"    => "html",
	  "PREVIEW_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].'/test/temp.jpg'),
 	  "ACTIVE"         => "Y",            // активен
	  );

	$id = $el->Add($arLoadProductArray); 
	//die();
	  
}
?>