<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("TITLE", "Личный кабинет");
$APPLICATION->SetTitle("Личный кабинет");

require($_SERVER["DOCUMENT_ROOT"]."/include/profile_nav.php");

?>
<p>
	<h2>Добро пожаловать в ваш личный кабинет!</h2>
</p>
<p>
	Он состоит из нескольких разделов-вкладок.&nbsp;&nbsp;
</p>
<p>
	Во вкладке&nbsp;<a href="/personal/history/">«Заказы»</a>&nbsp;отображаются все ваши заказы.&nbsp;<br>
	Вы можете выгрузить их список в формате excel.
</p>
<p>
	Во вкладке&nbsp;<a href="/personal/profile/">«Профиль»</a>&nbsp;вы можете редактировать свои личные данные,&nbsp;<br>
	сменить пароль или указать, какие почтовые рассылки и насколько часто вы хотите от нас получать.
</p>
<p>
	Во вкладке&nbsp;<a href="http://www.oldi.ru/personal/favorite/">«Отложенное»</a>&nbsp;сохраняются все товары,&nbsp;<br>
	которые вы отметили кнопкой «Like» в карточке товара.
</p>
<br />
<br />
<table class="Oplata" width="100%">
	<tbody>		
		<tr align="center">
			<td colspan="2"><img width="100%" style="max-width: 640px;" src="/images/pug-information-main.jpg"></td>
		</tr>
	</tbody>
</table>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>