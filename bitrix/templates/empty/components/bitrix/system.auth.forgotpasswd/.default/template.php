<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?

ShowMessage($arParams["~AUTH_RESULT"]);
if($_POST["USER_EMAIL"]) {

    $rsUser = CUser::GetByLogin($_POST["USER_EMAIL"]);
    $arUser = $rsUser->Fetch();
     if ($arUser) {
        ?>
        На указанный вами адрес отправлено письмо со ссылкой для смены пароля
        <?
    } else {
        ?>
        <span style="color: #F1665E">Учетная запись с таким E-mail не найдена</span><br /><br />
        <?
        goto template;
    }

}
else {
    template:

    if($_POST){
        ?>
        <span style="color: #F1665E">Введите Email указанный при регистрации</span><br /><br />
        <?
    }

    ?>
    <form name="bform" method="post" target="_top" action="<?= $arResult["AUTH_URL"] ?>">
        <?
        if (strlen($arResult["BACKURL"]) > 0) {
            ?>
            <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
            <?
        }
        ?>
        <input type="hidden" name="AUTH_FORM" value="Y">
        <input type="hidden" name="TYPE" value="SEND_PWD">
        <p>
            <?= GetMessage("AUTH_FORGOT_PASSWORD_1") ?>
        </p>

        <table class="data-table bx-forgotpass-table">
            <thead>
            <thead>
            <tr>
                <td colspan="2"><h3>Шаг 1. Запрос на смену пароля</h3></td>
            </tr>
            <tr>
                <td colspan="2" style="padding-bottom: 15px;"><b><?= GetMessage("AUTH_GET_CHECK_STRING") ?></b></td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="vertical-align: middle; padding-right: 15px;"><?= GetMessage("AUTH_EMAIL") ?></td>
                <td>
                    <input type="text" name="USER_EMAIL" maxlength="255"/>
                </td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2" style="padding-top: 15px;">
                    <a href="javascript:void(0)" onclick="$(this).closest('form').submit()"
                       class="btn-reg js-submit-btn"><?= GetMessage("AUTH_SEND") ?></a>
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
    <script type="text/javascript">
        document.bform.USER_LOGIN.focus();
    </script>
    <?php
}
