<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

global $APPLICATION;
global $USER;

$password_min_length = 6;
$password_chars = array(
    "abcdefghijklnmopqrstuvwxyz",
    "ABCDEFGHIJKLNMOPQRSTUVWXYZ",
    "0123456789",
);

$APPLICATION->Set Title("Title");
CModule::Includ eModule("iblock");

$users=Array();

$order = array('sort' => 'asc');
$tmp = 'sort';

$rsUsers = CUser::GetList($order, $tmp);
while ($arUser=$rsUsers->Fetch())
{
    $users[$arUser["EMAIL"]]=$arUser["ID"];
}

$db_sales = CSaleOrder::GetList(array("ID" => "ASC"), Array(">ID"=>6793), false, false, Array("ID")) ;
while ($ar_sales = $db_sales->Fetch())
{
    $USER_ID=0;
    $db_vals = CSaleOrderPropsValue::GetList(
        array("SORT" => "ASC"),
        array(
            "ORDER_ID" => $ar_sales["ID"],
            "ORDER_PROPS_ID" => 2
        )
    );

    if ($arVals = $db_vals->Fetch()) {

        $EMAIL=$arVals["VALUE"];

        if($users[$EMAIL]) {

            $USER_ID=$users[$EMAIL];

        }
        else
        {

            $def_group = COption::GetOptionString("main", "new_user_registration_def_group", "");
            if($def_group!="")
            {
                $GROUP_ID = explode(",", $def_group);
                $arPolicy = $USER->GetGroupPolicy($GROUP_ID);
            }
            else
            {
                $arPolicy = $USER->GetGroupPolicy(array());
            }

            $password_min_length = intval($arPolicy["PASSWORD_LENGTH"]);
            if($password_min_length <= 0)
                $password_min_length = 6;

            if($arPolicy["PASSWORD_PUNCTUATION"] === "Y")
                $password_chars[] = ",.<>/?;:'\"[]{}\|`~!@#\$%^&*()-_+=";
            $NEW_PASSWORD = $NEW_PASSWORD_CONFIRM = randString($password_min_length+2, $password_chars);


            $NAME = CSaleOrderPropsValue::GetList(
                array("SORT" => "ASC"),
                array(
                    "ORDER_ID" => $ar_sales["ID"],
                    "ORDER_PROPS_ID" => 1
                )
            )->Fetch();

            $NAME=$NAME["VALUE"];

            $PHONE = CSaleOrderPropsValue::GetList(
                array("SORT" => "ASC"),
                array(
                    "ORDER_ID" => $ar_sales["ID"],
                    "ORDER_PROPS_ID" => 3
                )
            )->Fetch();

            $PHONE=$PHONE["VALUE"];

            $user = new CUser;

            $arUserFields=Array(
                "LOGIN" => $EMAIL,
                "NAME" => $NAME,
                "LAST_NAME" => "",
                "PASSWORD" => $NEW_PASSWORD,
                "PASSWORD_CONFIRM" => $NEW_PASSWORD_CONFIRM,
                "EMAIL" => $EMAIL,
                "GROUP_ID" => $GROUP_ID,
                "PERSONAL_PHONE" => $PHONE,
                "ACTIVE" => "Y",
                "LID" => "s1",
            );

            $USER_ID = $user->Add($arUserFields);

            $users[$EMAIL]=$USER_ID;

            print_r($arUserFields);

        }

        if ($USER_ID) {
            $FUSER_ID=CSaleUser::GetList(array('USER_ID' => $USER_ID));

            if(!$FUSER_ID['ID'])
                $FUSER_ID['ID']=CSaleUser::_Add(array("USER_ID" => $USER_ID));

            $FUSER_ID=$FUSER_ID['ID'];

            $arFields = array(
                "FUSER_ID"=>$FUSER_ID,
                "USER_ID" => $USER_ID,
            );

            CSaleOrder::Update($ar_sales["ID"], $arFields);
        }
        else
        {
            var_dump($ar_sales["ID"]); var_dump($EMAIL); die();
        }
    }
}

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
