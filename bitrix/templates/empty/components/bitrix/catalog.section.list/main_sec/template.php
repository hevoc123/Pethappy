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
?>
<?$this->SetViewTarget("left_sections");?>
<nav>
	<ul class="side-menu">
<?
foreach ($arResult['SECTIONS'] as &$arSection)
{
	$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
	$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
	//var_dump($arSection);
	//if($arSection["DEPTH_LEVEL"]==1):
		?>
		<li id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
			<a href="<? echo $arSection['SECTION_PAGE_URL']; ?>"><? echo $arSection['NAME']; ?></a>
		</li>
	<?
	//endif;
}
?>
	</ul>
</nav>
<?$this->EndViewTarget();//конец буферизации?>
