<?ob_start();?>
<ul class="sec-profile__nav"><!--Первое вертикальное меню-->
	<li <?if(strstr($APPLICATION->GetCurDir(), "/cart")):?>class="active"<?endif;?>><a href="/personal/cart/">Корзина<span class="__cart-count"><?=$GLOBALS["bcount"]?></span><i class="piluli-angle-right" aria-hidden="true"></i></a></li>
	<li <?if(strstr($APPLICATION->GetCurDir(), "/wishlist")):?>class="active"<?endif;?>><a href="/personal/wishlist/">Отложенное<span class="__favorite-count "><?=($arElements ? count($arElements) : "0")?></span><i class="piluli-angle-right" aria-hidden="true"></i></a></li>
	<?if ($USER->IsAuthorized()):?>
		<li <?if(strstr($APPLICATION->GetCurDir(), "/history")):?>class="active"<?endif;?>><a href="/personal/history/">Заказы</a></li>
		<li <?if(strstr($APPLICATION->GetCurDir(), "/profile")):?>class="active"<?endif;?>><a href="/personal/profile/">Профиль</a></li>
	<?endif;?>
</ul>
<br />
<?
$content = ob_get_contents();
$APPLICATION->AddViewContent("left_sections", $content);
ob_end_clean();
