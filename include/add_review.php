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

	$product=CIBlockElement::GetByID($_POST["products_id"])->GetNext();
	
	$el = new CIBlockElement;

	$PROP = array();
	$PROP[50] = $_POST["products_id"];
	$PROP[51] = $_POST["rating"];
	$PROP[52] = 0;
	$PROP[53] = 0;
	if($USER->IsAuthorized())  $PROP[54] = $USER->GetID();
	$PROP[55] = utf8win1251($_POST["reviews_email"]);
	$PROP[56] = utf8win1251($_POST["reviews_name"]);
	
	$arLoadProductArray = Array(
	  "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
	  "IBLOCK_ID"      => 13,
	  "PROPERTY_VALUES"=> $PROP,
	  "NAME"           => utf8win1251($product["NAME"]),
	  "ACTIVE"         => "N",            // активен
	  "DATE_ACTIVE_FROM" => ConvertTimeStamp(),
	  "PREVIEW_TEXT"   => utf8win1251($_POST["reviews_text"]),
	);

	$PRODUCT_ID = $el->Add($arLoadProductArray);
	
	ob_start();
	?>
	<li id="review_<?=$PRODUCT_ID?>" data-rid="<?=$PRODUCT_ID?>"  data-pid="<?=$_POST["products_id"]?>" class="wsc-row" itemscope="" itemtype="http://schema.org/Review">
		<div class="reviews-head">
			<meta itemprop="itemReviewed" content="Интернет-магазин Pethappy.ru">
			<span class="author" itemprop="author"><?=$ar_res["PROPERTY_NAME_VALUE"]?></span>
			<span class="date"><?=ConvertTimeStamp()?></span>
			<span class="stars">
				<span><i class="piluli-<?=($_POST["rating"] >= 1 ? "13" : "15" )?>"></i></span>
				<span><i class="piluli-<?=($_POST["rating"] >= 2 ? "13" : "15" )?>"></i></span>
				<span><i class="piluli-<?=($_POST["rating"] >= 3 ? "13" : "15" )?>"></i></span>
				<span><i class="piluli-<?=($_POST["rating"] >= 4 ? "13" : "15" )?>"></i></span>
				<span><i class="piluli-<?=($_POST["rating"] >= 5 ? "13" : "15" )?>"></i></span>
			</span>
		</div><!-- end reviews-head -->
		<p itemprop="reviewBody"><?=$_POST["reviews_text"]?></p>
		<div class="evaluate-review">
			<span class="title">Опыт полезен?</span>
			<div class="evaluate-link-wrap">
				<div class="evaluate-link-unit">
					<a href="#" class="evaluate-link plus __reviewPlus"><i class="piluli-44 "></i></a><span class="digit">0</span>
				</div>
				<div class="evaluate-link-unit">
					<a href="#" class="evaluate-link minus __reviewMinus"><i class="piluli-45 "></i></a><span class="digit">0</span>
				</div>
			</div>
			<div class="next-row">
				<?/*<a href="#" class="reply-link __show-enter-form">Ответить<i class="piluli-46"></i></a>*/ ?>
				<div class="social-module light">
					<!-- component.comments comments-v_shared_btns START -->
					<a class="vk" href="#" title="Расшарить Вконтакте" onclick="window.open('http://vkontakte.ru/share.php?url=<?=urlencode("http://pethappy.ru".$product["DETAIL_PAGE_URL"]."/rating");?>&amp;title=<?=urlencode(iconv('windows-1251', 'utf-8',$product["NAME"]))?>&amp;image=<?=urlencode("http://pethappy.ru/bitrix/templates/empty/img/logo.png")?>&amp;description=<?=urlencode(iconv('windows-1251', 'utf-8',$ar_res["PREVIEW_TEXT"]))?>','', 'scrollbars=yes,resizable=no,width=560,height=350,top='+Math.floor((screen.height - 350)/2-14)+',left='+Math.floor((screen.width - 560)/2-5)); return false;">
						<i class="piluli-10"></i>
					</a>
					<a class="fb" href="#" title="Расшарить в Facebook" onclick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?=urlencode(iconv('windows-1251', 'utf-8',$product["NAME"]))?>&amp;p[summary]=<?=urlencode(iconv('windows-1251', 'utf-8',$ar_res["PREVIEW_TEXT"]))?>&amp;p[url]=<?=urlencode("http://pethappy.ru".$product["DETAIL_PAGE_URL"]."/rating");?>&amp;p[images][0]=<?=urlencode("http://pethappy.ru/bitrix/templates/empty/img/logo.png")?>','sharer', 'toolbar=0,status=0,width=560,height=350,top='+Math.floor((screen.height - 350)/2-14)+',left='+Math.floor((screen.width - 560)/2-5));return false; ">
						<i class="piluli-11"></i>
					</a>
					<a class="ok" href="#" title="Расшарить в Одноклассники" onclick="window.open('http://www.odnoklassniki.ru/dk?st.cmd=addShare&amp;st.s=1&amp;st._surl=<?=urlencode("http://pethappy.ru".$product["DETAIL_PAGE_URL"]."/rating");?>&amp;st.comments=<?=urlencode(iconv('windows-1251', 'utf-8',$ar_res["PREVIEW_TEXT"]))?>', '', 'scrollbars=yes,resizable=no,width=620,height=450,top='+Math.floor((screen.height - 450)/2-14)+',left='+Math.floor((screen.width - 620)/2-5)); return false;">
						<i class="piluli-12"></i>
					</a>
					<!-- component.comments comments-v_shared_btns END -->
				</div>
			</div><!-- end next-row-->
		</div><!-- end evaluate-review -->
	</li>
	<?
	$data["error_points"]="";
	$data["html"]=ob_get_contents();
	ob_end_clean();

	$data["html"]=iconv('cp1251', 'utf-8', $data["html"]);
}

header('Content-Type: application/json');

echo json_encode($data);