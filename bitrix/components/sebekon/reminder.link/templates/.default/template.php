<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/*
 * Module: sebekon.reminder
 */
 
 $link = $templateFolder."/ajax.php?SEBEKON_RM={$arResult['SEBEKON_RM']}";
 global $USER;
?>
<?if(!$arResult['PRODUCT_ID']):?>
<?if($USER->IsAdmin()):?>
	<div class="bootstrap">
		<div class="alert alert-error">
			<?=GetMessage('SEBEKON_RM_NO_PRODUCT_ID')?>
		</div>
	</div>
<?endif;?>
<?else:?>
<a href="<?=$link?>" onclick="window.open('<?=$link?>','reminderWindow','location=1,status=1,scrollbars=1,width=600,height=500'); return false;"><?=GetMessage('SEBEKON_RM_REMIND_ME')?></a>
<?endif;?>