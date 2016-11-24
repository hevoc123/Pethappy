<?
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

	if(intval($_GET['id']) > 0)
    {	
		$new=Array();
		$action=intval($_GET['active']);
		
		if(!$USER->IsAuthorized()) {
			$arElements = unserialize($APPLICATION->get_cookie('favorites'));
				
			if(!$action)
			{
				foreach($arElements as $itemID)
				{
					if($itemID!=$_GET['id'])
						$new[] = $itemID;
				}
				$arElements=$new;
			}
			else
			{
				$arElements[] = $_GET['id'];
			}
			$arElements=array_unique($arElements);
			$APPLICATION->set_cookie("favorites",serialize($arElements));
		}
		else {
			$idUser = $USER->GetID();
			$rsUser = CUser::GetByID($idUser);
			$arUser = $rsUser->Fetch();
			$arElements = unserialize($arUser['UF_FAVORITES']);
			if(!$action)
			{
				foreach($arElements as $itemID)
				{
					if($itemID!=$_GET['id'])
						$new[] = $itemID;
				}
				$arElements=$new;
			}
			else
			{
				$arElements[] = $_GET['id'];
			}
			
			$arElements=array_unique($arElements);
			$USER->Update($idUser, Array("UF_FAVORITES"=>serialize($arElements)));
		}      
    }
?>