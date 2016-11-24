<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/colors.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME']
);
?>
<script>
/*
$(document).ready(function () {
	$(".smartfilter input").live("change", function () {
		var elem=$(this).parents("span");
		var height=$(elem).height();
		height=parseInt(height)/2+25;
		var data=$(".smartfilter").serialize();
		var url=$(".smartfilter").attr("action");
		$.get(url, data + "&ajax=Y&set_filter=Подобрать", function (result) {
			$(".find").remove();
			<?if($USER->isAdmin()):?>
			var count=parseInt(result);
			<?else:?>
			var count=parseInt(result);
			<?endif;?>
			console.log(result);
			if(count > 0)
				$(elem).append('<div class="find" style="margin-top: -'+height+'px ">Найдено: '+count+': <a href="javascript:$(\'#set_filter\').click();">Показать</a> </div>');
			else
				$(elem).append('<div class="find" style="margin-top: -'+height+'px ">Найдено: '+count+'</div>');
		});
	});

	$("a.bx_ui_slider_handle").live("mouseup", function () {
		var elem=$(this).parents("span");
		var height=$(elem).height();
		height=parseInt(height)/2+25;
		var data=$(".smartfilter").serialize();
		var url=$(".smartfilter").attr("action");
		$.get(url, data + "&ajax=Y&set_filter=Подобрать", function (result) {
			<?if($USER->isAdmin()):?>
			var count=parseInt($(result).text());
			<?else:?>
			var count=parseInt(result);
			<?endif;?>
			console.log(result);
			$(".find").remove();
			if(count > 0)
				$(elem).append('<div class="find" style="margin-top: -'+height+'px ">Найдено: '+count+': <a href="javascript:$(\'#set_filter\').click();">Показать</a> </div>');
			else
				$(elem).append('<div class="find" style="margin-top: -'+height+'px ">Найдено: '+count+'</div>');
		});
	});
});*/
</script>
<div class="filter-sidebar js-filter-sidebar-wrap <?=$templateData["TEMPLATE_CLASS"]?>" id="filter_group">
	<a href="#" class="mobile-title  auto640 js-mobile-title" data-open="#mobile_group">Фильтр товаров <i class="piluli-51"></i> <i class="piluli-52"></i></a>
	<div class="filter-for-mobile js-filter-for-mobile" id="mobile_group">
		<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter">
			<?foreach($arResult["HIDDEN"] as $arItem):?>
			<input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
			<?endforeach;
			foreach($arResult["ITEMS"] as $key=>$arItem):
				$key = md5($key);
				if(isset($arItem["PRICE"])):
					if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
						continue;
					?>
					<div class="unit js-unit-wrap">
						<a href="#" class="unit-link active  js-unit-link" data-open="#filter_forms">Цена <i class="piluli-51"></i> <i class="piluli-52"></i></a>
						<div class="dropdown-unit js-dropdown-unit" style="display: block;">
						
							<div class="slider-range-wrap">
							
								<span class="from-range" id="fromRange">от <b id="curMinPrice_<?=$key?>"><?echo intval($arItem["VALUES"]["MIN"]["VALUE"]);?></b> руб.</span>
								<span class="to-range" id="toRange">до <b id="curMaxPrice_<?=$key?>"><?echo intval($arItem["VALUES"]["MAX"]["VALUE"]);?></b> руб.</span>
								
								<div id="slider-range"></div>
								
								<? /*
								<div class="bx_ui_slider_track" id="drag_track_<?=$key?>">
									<div class="bx_ui_slider_range" style="left: 0; right: 0%;"  id="drag_tracker_<?=$key?>"></div>
									<a class="bx_ui_slider_handle left"  href="javascript:void(0)" style="left:0;" id="left_slider_<?=$key?>"></a>
									<a class="bx_ui_slider_handle right" href="javascript:void(0)" style="right:0%;" id="right_slider_<?=$key?>"></a>
								</div>
								<div class="bx_filter_param_area">
									<div class="bx_filter_param_area_block" id="curMinPrice_<?=$key?>"><?
											echo intval($arItem["VALUES"]["MIN"]["VALUE"]);
									?> р.</div>
									<div class="bx_filter_param_area_block" id="curMaxPrice_<?=$key?>"><?
										echo intval($arItem["VALUES"]["MAX"]["VALUE"]);
									?> р.</div>
									<div style="clear: both;"></div>
								</div>		*/ ?>
								
						
								<div class="bx_filter_param_area filter_prices">
									<div class="bx_filter_param_area_block"><div class="bx_input_container">
									<span class="input-wrap"> от
											<input
												class="min-price"
												type="text"
												name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
												id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
												value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
												size="5"
												onkeyup="smartFilter.keyup(this)"
												placeholder="<?=intval($arItem["VALUES"]["MIN"]["VALUE"])?>"
											/></span>
									</div></div>
									<div class="bx_filter_param_area_block"><div class="bx_input_container">
										<span class="input-wrap"> до
											<input
												class="max-price"
												type="text"
												name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
												id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
												value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
												size="5"
												onkeyup="smartFilter.keyup(this)"
												placeholder="<?=intval($arItem["VALUES"]["MAX"]["VALUE"])?>"
											/></span>
									</div></div>
									<div style="clear: both;"></div>
								</div>
							</div>								
						</div>
					</div>
					<?
					$arJsParams = array(
						"leftSlider" => 'left_slider_'.$key,
						"rightSlider" => 'right_slider_'.$key,
						"tracker" => "drag_tracker_".$key,
						"trackerWrap" => "drag_track_".$key,
						"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
						"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
						"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
						"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
						"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
						"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
						"precision" => 2
					);
					?>
					<script type="text/javascript">
						BX.ready(function(){
							var trackBar<?=$key?> = new BX.Iblock.SmartFilter.Vertical(<?=CUtil::PhpToJSObject($arJsParams)?>);
						});
					</script>
				<?endif;
			endforeach;

			foreach($arResult["ITEMS"] as $key=>$arItem):
				if($arItem["PROPERTY_TYPE"] == "N" ):
					if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
						continue;
					?>
					
					<div class="unit js-unit-wrap">
						<a href="#" class="unit-link active  js-unit-link" data-open="#filter_forms"><?=$arItem["NAME"]?> <i class="piluli-51"></i> <i class="piluli-52"></i></a>
						
						<div class="bx_filter_param_area">
							<div class="bx_filter_param_area_block"><div class="bx_input_container">
								<input
									class="min-price"
									type="text"
									name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
									id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
									value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
									size="5"
									onkeyup="smartFilter.keyup(this)"
									placeholder="<?=intval($arItem["VALUES"]["MIN"]["VALUE"])?>"
								/>
								</div></div>
							<div class="bx_filter_param_area_block"><div class="bx_input_container">
								<input
									class="max-price"
									type="text"
									name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
									id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
									value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
									size="5"
									onkeyup="smartFilter.keyup(this)"
									placeholder="<?=intval($arItem["VALUES"]["MAX"]["VALUE"])?>"
								/>
							</div></div>
							<div style="clear: both;"></div>
						</div>
						<div class="bx_ui_slider_track" id="drag_track_<?=$key?>">
							<div class="bx_ui_slider_range" style="left: 0; right: 0%;"  id="drag_tracker_<?=$key?>"></div>
							<a class="bx_ui_slider_handle left"  href="javascript:void(0)" style="left:0;" id="left_slider_<?=$key?>"></a>
							<a class="bx_ui_slider_handle right" href="javascript:void(0)" style="right:0%;" id="right_slider_<?=$key?>"></a>
						</div>
						<div class="bx_filter_param_area">
							<div class="bx_filter_param_area_block" id="curMinPrice_<?=$key?>"><?=$arItem["VALUES"]["MIN"]["VALUE"]?></div>
							<div class="bx_filter_param_area_block" id="curMaxPrice_<?=$key?>"><?=$arItem["VALUES"]["MAX"]["VALUE"]?></div>
							<div style="clear: both;"></div>
						</div>
					</div>
					
					<?
					$arJsParams = array(
						"leftSlider" => 'left_slider_'.$key,
						"rightSlider" => 'right_slider_'.$key,
						"tracker" => "drag_tracker_".$key,
						"trackerWrap" => "drag_track_".$key,
						"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
						"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
						"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
						"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
						"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
						"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
						"precision" => 0
					);
					?>
					<script type="text/javascript">
						BX.ready(function(){
							var trackBar<?=$key?> = new BX.Iblock.SmartFilter.Vertical(<?=CUtil::PhpToJSObject($arJsParams)?>);
						});
					</script>
				<?elseif(!empty($arItem["VALUES"]) && !isset($arItem["PRICE"])):?>
					<?
					$open=false;
					foreach($arItem["VALUES"] as $val => $ar)
					{
						//var_dump($ar["CHECKED"]); 
						if($ar["CHECKED"]) $open=true;
					}
					?>
					<div class="unit js-unit-wrap <?if($open):?>active<?endif;?>">
						<a href="#" class="unit-link js-unit-link <?if($open):?>active<?endif;?>" data-open="#filter_forms"><?=$arItem["NAME"]?> <i class="piluli-51"></i> <i class="piluli-52"></i></a>
						 
						<div class="dropdown-unit js-dropdown-unit" id="filter_forms" <?if($open):?>style="display: block;"<?endif;?>>
							<ul class="checkbox-list">
								<?foreach($arItem["VALUES"] as $val => $ar):?>
									<li>
										<label for="<?echo $ar["CONTROL_ID"]?>" class="checkbox">
											<input
												type="checkbox"
												value="<?echo $ar["HTML_VALUE"]?>"
												name="<?echo $ar["CONTROL_NAME"]?>"
												id="<?echo $ar["CONTROL_ID"]?>"
												<?echo $ar["CHECKED"]? 'checked="checked"': ''?>
												onclick="smartFilter.click(this)"
											/>
											<a href="#"><?echo $ar["VALUE"];?></a>
										
										</label>
									</li>
								<?endforeach;?>
							</ul>
						</div>
					</div>
					
				<?endif;
			endforeach;?>
			<div style="clear: both;"></div>
			<div class="btn-wrap">
				<input class="btn-reg bx_filter_search_button" type="submit" id="set_filter" name="set_filter" value="<?=GetMessage("CT_BCSF_SET_FILTER")?>" />
				<input class="bx_filter_search_button" type="submit" id="del_filter" name="del_filter" value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>" style="display: none;" />
				<a href="javascript:void(0);" id="filter_kill" onclick="$('#del_filter').click(); return false;" class="btn-link">Сбросить фильтры</a>
				<div style="display: none;" class="bx_filter_popup_result left" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="di splay:none"';?> style="display: inline-block;">
					<?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
					<span class="arrow"></span>
					<a href="<?echo $arResult["FILTER_URL"]?>"><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
				</div>
			</div>
		</form>
		<div style="clear: both;"></div>
	</div>
</div>
<script>
	var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>');
</script>