<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Восстановление пароля");
$APPLICATION->SetPageProperty("TITLE", "Восстановление пароля");

if($_REQUEST["change_password"]=="yes")
    $APPLICATION->IncludeComponent("bitrix:system.auth.changepasswd", "", Array());
else
    $APPLICATION->IncludeComponent("bitrix:system.auth.forgotpasswd", "", Array());
?>
    <table width="100%">
        <tbody>
        <tr>
            <td style="text-align: center">
                <img style="max-width: 425px; width: 100%;" src="/images/password.jpg">
            </td>
        </tr>
        </tbody>
    </table>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>