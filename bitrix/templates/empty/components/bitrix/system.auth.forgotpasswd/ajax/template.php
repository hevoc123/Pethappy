<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if($_REQUEST["USER_EMAIL"]) {
	$rsUser = CUser::GetByLogin($_REQUEST["USER_EMAIL"]);
	$arUser = $rsUser->Fetch();
	if ($arUser) {
        $data["result"]=iconv('cp1251', 'utf-8', "������� Email ��������� ��� �����������");
		echo json_encode($data);
	} else {
		if(check_email($_REQUEST["USER_EMAIL"]))
			$data["error"]=iconv('cp1251', 'utf-8', "�� ���������� ������ Email");
		else
            $data["error"]=iconv('cp1251', 'utf-8', "������������ � ����� Email �� ������");

		echo json_encode($data);
	}
}
else
{
    $data["error"]=iconv('cp1251', 'utf-8', "������� Email ��������� ��� �����������");
	echo json_encode($data);
}