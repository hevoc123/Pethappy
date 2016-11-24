<?    
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");
CModule::IncludeModule("iblock");

$result=Array();

if(strlen($_POST["reviews_name"]) < 2 && !$USER->IsAuthorized())
{
	$result[0]=Array("field"=>"reviews_name", "text"=>iconv('cp1251', 'utf-8', "ФИО: Минимум 2 символа"));
}

if(!check_email($_POST["reviews_email"])  && !$USER->IsAuthorized())
{
	$result[1]=Array("field"=>"reviews_email", "text"=>iconv('cp1251', 'utf-8', "E-mail: минимум 6 символов"));
}

if(!$_POST["reviews_text"])
{
	$result[2]=Array("field"=>"reviews_text", "text"=>iconv('cp1251', 'utf-8', "Введите текст отзыва"));
}

if($result)
{
	$data["error_points"]=$result; 
	$data["html"]="";
	$data["errors"]=iconv('cp1251', 'utf-8', "Заполните все поля");
}
else
{
	if($USER->IsAuthorized())
	{
		$_POST["reviews_name"]=$USER->GetFullName();
		$_POST["reviews_email"]=$USER->GetEmail();
		
		if(strlen($_POST["reviews_name"]) < 2) $_POST["reviews_name"]=$USER->GetLogin();
	}

	$el = new CIBlockElement;

	$PROP = array();
	$PROP[62] = $_POST["rating"];
	if($USER->IsAuthorized())  $PROP[65] = $USER->GetID();
	$PROP[66] = utf8win1251($_POST["reviews_email"]);
	$PROP[67] = utf8win1251($_POST["reviews_name"]);
	
	$arLoadProductArray = Array(
	  "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
	  "IBLOCK_ID"      => 15,
	  "PROPERTY_VALUES"=> $PROP,
	  "NAME"           => utf8win1251($_POST["reviews_name"]),
	  "ACTIVE"         => "N",            // активен
	  "DATE_ACTIVE_FROM" => ConvertTimeStamp(),
	  "PREVIEW_TEXT"   => utf8win1251($_POST["reviews_text"]),
	);

	$PRODUCT_ID = $el->Add($arLoadProductArray);
	
	ob_start();
	?>
	<li>
		<h2 style="color: #4CAF50;">Ваш отзыв добавлен</h2>
	</li>
	<?
	$data["error_points"]="";
	$data["html"]=ob_get_contents();
	ob_end_clean();

	$data["html"]=iconv('cp1251', 'utf-8', $data["html"]);
}

header('Content-Type: application/json');

echo json_encode($data);