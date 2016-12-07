		<?if(strstr($APPLICATION->GetCurPage() , "/categories/") || $APPLICATION->GetCurPage()=="/" || $APPLICATION->GetCurPage()=="/personal/wishlist/"):?>
				</div>
				<div class="clear"></div>
			</div>
		<?endif;?>	
		</div>
		<?
		$APPLICATION->ShowViewContent("detailtext");
		?>
	</section>

<footer>
	<div class="inner">
		<div class="for-desktop">
			<div class="footer-unit">
				<b class="title">Это интересно</b>
				<ul class="contact-us-list footer-links">
					<li><a href="/blog/korm-dlya-sobak" target="_blank">Корм для собак</a></li>
					<li><a href="/blog/korm-dlya-koshek" target="_blank">Корм для кошек</a></li>
					<li><a href="/blog/zdorove-vashego-pitomtsa" target="_blank">Здоровье Вашего питомца</a></li>
					<li><a href="/blog/prinadlezhnosti-dlya-koshachikh-tualetov" target="_blank">Принадлежности для<br /> кошачьих туалетов</a></li>
					<li class="for-social">
						<div class="social-module transparent">
							<a href="javascript:void(0)"><i class="piluli-10 g-round-footer-icon" data-pth="https://vk.com/pet_happy"></i></a>
							<? /*<a href="javascript:void(0)"><i class="piluli-12 g-round-footer-icon" data-pth="http://ok.ru/piluliru"></i></a> */ ?>
							<a href="javascript:void(0)"><i class="piluli-11 g-round-footer-icon" data-pth="https://www.facebook.com/pethappy.ru"></i></a>
						</div>
						<!-- end social-module -->
					</li>
				</ul>
				<!-- end contact-us-list -->
			</div>
			<!-- end footer-unit -->
			<div class="footer-unit">
				<b class="title">Отзывы о Магазине</b>
				<ul class="portal-list footer-links">
					<li><a href="/storereviews">Читать все отзывы</a></li>
				</ul>
				<!-- end portal-list -->
			</div>
			<div class="footer-unit">
				<b class="title">Информация</b>
				<ul class="portal-list footer-links" style="margin-right: 40px;">
					<li><a href="/pages/zootovary-optom">Для оптовиков</a></li>
					<li><a href="/pages/payment">Оплата</a></li>
					<li><a href="/pages/shipping">Доставка</a></li>
					<li><a href="/pages/returns">Политика возврата</a></li>
					<li><a href="/pages/warranty">Гарантии</a></li>
					<li><a href="/pages/contacts">Контакты</a></li>
					<li><a href="/pages/confidancial">Конфиденциальность и<br /> защита персональных данных</a></li>
				</ul>
				<!-- end portal-list -->
			</div>
			<!-- end footer-unit -->
			<div class="footer-unit pharmacy-unit">
				<b class="title">Личный кабинет</b>
				<ul class="pharmacy-list col footer-links">
					<li><a href="/personal/profile/">Профайл</a></li>
					<li><a href="/personal/history/">История заказов</a></li>
					<li><a href="/personal/wishlist/">Отложенное</a></li>
					<li><a href="/personal/cart/">Корзина</a></li>
				</ul>
				
			</div>
			<!-- end footer-unit -->
		</div>
		<!-- end for-desktop -->
		<div class="for-mobile">
			<div class="footer-unit js-toggle-wrap">
				<a href="#" class="title js-toggle-link">Это интересно</a>
				<ul class="footer-links js-toggle-block">
					<li><a href="/blog/korm-dlya-sobak" target="_blank">Корм для собак</a></li>
					<li><a href="/blog/korm-dlya-koshek" target="_blank">Корм для кошек</a></li>
					<li><a href="/blog/zdorove-vashego-pitomtsa" target="_blank">Здоровье Вашего питомца</a></li>
					<li><a href="/blog/prinadlezhnosti-dlya-koshachikh-tualetov" target="_blank">Принадлежности для<br /> кошачьих туалетов</a></li>
				</ul>
			</div>
			<!-- end footer-unit -->
			<div class="footer-unit js-toggle-wrap">
				<a href="#" class="title js-toggle-link">Отзывы о магазине</a>
				<ul class="footer-links js-toggle-block">
					<li><a href="/storereviews">Читать все отзывы</a></li>
				</ul>
				<!-- end portal-list -->
			</div>
			<!-- end footer-unit -->
			<div class="footer-unit js-toggle-wrap">
				<a href="#" class="title js-toggle-link">Информация</a>
				<ul class="footer-links js-toggle-block">
					<li><a href="/pages/zootovary-optom">Для оптовиков</a></li>
					<li><a href="/pages/payment">Оплата</a></li>
					<li><a href="/pages/shipping">Доставка</a></li>
					<li><a href="/pages/returns">Политика возврата</a></li>
					<li><a href="/pages/warranty">Гарантии</a></li>
					<li><a href="/pages/contacts">Контакты</a></li>
					<li><a href="/pages/confidancial">Конфиденциальность и<br /> защита персональных данных</a></li>
				</ul>
				<!-- end contact-us-list -->
			</div>
			<!-- end footer-unit -->
			<div class="footer-unit js-toggle-wrap">
				<a href="#" class="title js-toggle-link">Личный кабинет</a>
				<ul class="footer-links js-toggle-block">
					<li><a href="/personal/profile/">Профайл</a></li>
					<li><a href="/personal/history/">История заказов</a></li>
					<li><a href="/personal/wishlist/">Отложенное</a></li>
					<li><a href="/personal/cart/">Корзина</a></li>
				</ul>
				<!-- end contact-us-list -->
			</div>
			<!-- end footer-unit -->			
		</div>
		<!-- end for-mobile -->
		<div class="right-block" itemtype="http://schema.org/Organization" itemscope>
						<span class="address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
									г. <span itemprop="addressLocality">Москва</span>,
					<span itemprop="streetAddress">Знаменские садки 1Б</span>

							</span>
			<div class="phone table">
				<div class="cell">
					
											<span class="tel" itemprop='telephone'>8 495 649-03-03</span>
					
					<!--<span class="tel" itemprop="telephone">
													8 800 775-00-07
											</span>-->
				</div>
								<div class="cell">
					<div class="social-module transparent">
						<a href="javascript:void(0)"><i class="piluli-10 g-round-footer-icon" data-pth="https://vk.com/pet_happy"></i></a>
						<? /*<a href="javascript:void(0)"><i class="piluli-12 g-round-footer-icon" data-pth="http://ok.ru/piluliru"></i></a> */?>
						<a href="javascript:void(0)"><i class="piluli-11 g-round-footer-icon" data-pth="https://www.facebook.com/pethappy.ru"></i></a>
					</div>
					<script type="text/javascript">
						$(function () {
							$(".g-round-footer-icon").on('click touch', function () {
								var p = $(this).data("pth");
								window.location.href = p;
							}) 
						})

					</script>
				</div>
	</div>
	<!-- end phone-->
	<span class="copyright">&#169 2014 <span itemprop="name">Интернет-зоомагазин "Pethappy.ru"</span></span>
	</div><!-- end right-block -->
	</div><!-- end inner -->
</footer>
		<div class="btn-top"><a href="#">top</a></div>
</div><!-- end container -->

</div> <!-- end wrapper -->

		<!-- Yandex.Metrika counter -->
		<script type="text/javascript">
			(function (d, w, c) {
				(w[c] = w[c] || []).push(function() {
					try {
						w.yaCounter31828891 = new Ya.Metrika({
							id:31828891,
							clickmap:true,
							trackLinks:true,
							accurateTrackBounce:true,
							webvisor:true
						});
					} catch(e) { }
				});

				var n = d.getElementsByTagName("script")[0],
					s = d.createElement("script"),
					f = function () { n.parentNode.insertBefore(s, n); };
				s.type = "text/javascript";
				s.async = true;
				s.src = "https://mc.yandex.ru/metrika/watch.js";

				if (w.opera == "[object Opera]") {
					d.addEventListener("DOMContentLoaded", f, false);
				} else { f(); }
			})(document, window, "yandex_metrika_callbacks");
		</script>
		<noscript><div><img src="https://mc.yandex.ru/watch/31828891" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->
</body>
</html>