<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">

	<!-- Адаптируем страницу для мобильных устройств -->
	<meta name="viewport" content="width=360, maximum-scale=1.0, user-scalable=0">
	<meta name="format-detection" content="telephone=no">
	<meta name="yandex-verification" content="7112b1741a55e2ff" />
	<meta name="revisit-after" content="1 day">
	<link rel="icon" href="/favicon.ico" type="image/x-icon"/>
	<title><?$APPLICATION->ShowTitle();?></title>
	<?$APPLICATION->ShowHead();?>

	<!-- Иконка сайта для устройств от Apple, рекомендуемый размер 114x114, прозрачность не поддерживается -->
	<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
	<?
    CJSCore::Init(array("jquery"));
	?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/scripts/jquery-ui.min.js");?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/scripts/widget.js");?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/scripts/jquery.maskedinput.min.js");?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/scripts/jquery.mousewheel.js");?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/scripts/mwheelIntent.js");?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/scripts/jquery.jscrollpane.min.js");?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/scripts/scripts.js");?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/social_auth_popup.js");?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/blind/h_page_blocks.js");?>	
	
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/scripts/common.js");?>
	
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/owox.js");?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/plugins/slick.min.js");?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.magnific-popup.min.js");?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/scripts/jquery.fancybox.pack.js");?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/scripts/sweetalert.min.js");?>
	
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/plugins/fancybox/jquery.fancybox.css");?>
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/styles/style.css");?>
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/styles/ws.css");?>
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/magnific-popup.css");?>
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/font-awesome.min.css");?>
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/jquery.fancybox.css");?>
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/sweetalert.css");?>
	<!-- Подключаем файлы стилей -->

	<!-- Скрипты -->
	
</head>

<body>
<?
CModule::IncludeModule("catalog"); CModule::IncludeModule("sale"); CModule::IncludeModule("iblock");
$dbBasketItems = CSaleBasket::GetList(array("NAME" => "ASC", "ID" => "ASC"), array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "CAN_BUY"=>"Y", "LID" => SITE_ID, "ORDER_ID" => "NULL"), false, false, array("ID", "QUANTITY"));
$bcount=$dbBasketItems->SelectedRowsCount();
$GLOBALS["bcount"]=$bcount;
?>
<?$APPLICATION->ShowPanel();?>
	<div class="fixed-header">
		<div class="inner clearfix">
			<a href="/" class="fixed-header__logo left">
				<img src="/bitrix/templates/empty/img/logo.png" alt="" style="width: 100%; max-width: 130px; margin-top: 8px;">
			</a>
	
			<div class="search-field fix left">
			</div><!-- end search-field -->
			<?
			if(!$USER->IsAuthorized()) {
				$arElements = unserialize($APPLICATION->get_cookie('favorites'));
			}
			else {
				$idUser = $USER->GetID();
				$rsUser = CUser::GetByID($idUser);
				$arUser = $rsUser->Fetch(); 
				$arElements = unserialize($arUser['UF_FAVORITES']);
			}


			?>
			<div class="header-links right">
				<a href="/personal/wishlist/"><i class="piluli-1"></i><span class="<?if(!$arElements):?>hidden<?endif;?> __favorite-count"><?=count($arElements)?></span><b>Отложенное</b></a> 
				<a href="/personal/cart/"><i class="piluli-2"></i><span class="<?if($bcount==0):?>hidden<?endif;?> __cart-count"><?=$bcount?></span><b>Корзина</b></a>
			</div>
		</div>
	</div>
	<div class="wrapper">
		<span id="wrapperFixed" class="wrapper-fixed"></span>
		<div class="mobile-block js-screen-wrap">
			<div class="scrollbar-outer">
				<div class="screen js-screen screen-main">
					<div class="enter-block">
							<a href="/auth/">Вход</a>
							<a href="/registration/">Регистрация</a>
							<div class="header-links">
								<a href="/personal/wishlist/"><i class="piluli-1"></i><span class="<?if(!$arElements):?>hidden<?endif;?> __favorite-count"><?=count($arElements)?></span></a>
								<a href="/personal/cart/"><i class="piluli-2"></i><span class="<?if($bcount==0):?>hidden<?endif;?> __cart-count"><?=$bcount?></span></a>
							</div>
					</div><!-- end enter-block -->
					<nav>
						<ul class="mobile-menu">
							<li>
								<a href="/categories/" class="active">Каталог товаров</a>
								<ul class="mobile-submenu">
									<?$APPLICATION->IncludeComponent("bitrix:menu", "mcatalog", Array(
										"ROOT_MENU_TYPE" => "catalog",	// Тип меню для первого уровня
										"MENU_CACHE_TYPE" => "A",	// Тип кеширования
										"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
										"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
										"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
										"MAX_LEVEL" => "1",	// Уровень вложенности меню
										"CHILD_MENU_TYPE" => "catalog",	// Тип меню для остальных уровней
										"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
										"DELAY" => "N",	// Откладывать выполнение шаблона меню
										"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
										"MENU_THEME" => "site",
										"COMPONENT_TEMPLATE" => "vertical_multilevel"
										),
										false
									);?>
								</ul>
							</li>
							<li><a href="/pages/shipping">Доставка</a></li>
							<li><a href="/pages/payment">Оплата</a></li>
							
							<?$APPLICATION->IncludeComponent("bitrix:menu", "main", Array( 
								"ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
								"MENU_CACHE_TYPE" => "A",	// Тип кеширования
								"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
								"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
								"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
								"MAX_LEVEL" => "1",	// Уровень вложенности меню
								"CHILD_MENU_TYPE" => "catalog",	// Тип меню для остальных уровней
								"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
								"DELAY" => "N",	// Откладывать выполнение шаблона меню
								"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
								"MENU_THEME" => "site",
								"COMPONENT_TEMPLATE" => "vertical_multilevel"
								),
								false
							);?>						
						</ul>
					</nav>
				</div><!-- end js-screen -->
				
				<?$APPLICATION->IncludeComponent("bitrix:menu", "scatalog", Array(
					"ROOT_MENU_TYPE" => "catalog",	// Тип меню для первого уровня
						"MENU_CACHE_TYPE" => "A",	// Тип кеширования
						"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
						"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
						"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
						"MAX_LEVEL" => "2",	// Уровень вложенности меню
						"CHILD_MENU_TYPE" => "catalog",	// Тип меню для остальных уровней
						"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
						"DELAY" => "N",	// Откладывать выполнение шаблона меню
						"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
						"MENU_THEME" => "site",
						"COMPONENT_TEMPLATE" => "vertical_multilevel"
					),
					false
				);?>
				
				<footer>
					<div class="for-mobile">
						<?/*<div class="footer-unit js-toggle-wrap">
							<a href="#" class="title js-toggle-link">Интернет-зоомагазин</a>
							<ul class="footer-links js-toggle-block">
								<li><a href="/pages/about">О магазине</a></li>
								<li><a href="/storereviews">Отзывы</a></li>								
							</ul>
						</div><!-- end footer-unit -->
						<div class="footer-unit js-toggle-wrap">
							<a href="#" class="title js-toggle-link">Доставка и оплата</a>
							<ul class="footer-links js-toggle-block">
								<li><a href="/pages/shipping">Доставка</a></li>
								<li><a href="/pages/payment">Оплата</a></li>
								<li><a href="/pages/returns">Политика возврата</a></li>
							</ul><!-- end portal-list -->
						</div><!-- end footer-unit -->*/?>
						<div class="footer-unit js-toggle-wrap">
							<a href="#" class="title js-toggle-link">Личный кабинет</a>
							<ul class="footer-links js-toggle-block">
								<li><a href="/personal/">Профайл</a></li>
								<li><a href="/personal/history/">История заказов</a></li>
								<li><a href="/personal/wishlist/">Отложенное</a></li>		
								<li><a href="/personal/cart/">Корзина</a></li>										
							</ul><!-- end contact-us-list -->
						</div><!-- end footer-unit -->
					</div><!-- end for-mobile -->
					<div class="right-block">
						<span class="address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
							г. <span itemprop="addressLocality">Москва</span>,
							<span itemprop="streetAddress">Знаменские садки 1Б</span>
						</span>
						<div class="phone table">
							<div class="cell">
								
									
									<span class="tel" itemprop='telephone'>8 495 649-03-03</span>
													<? /*<span class="tel" itemprop="telephone">
															8 800 775-00-07
													</span>*/ ?>
								
							</div>
							<div class="cell">
								<div class="social-module transparent">
									<i class="piluli-10 g-round-footer-icon" data-pth="https://vk.com/piluliru"></i>
									<i class="piluli-12 g-round-footer-icon" data-pth="http://ok.ru/piluliru"></i>
									<i class="piluli-11 g-round-footer-icon" data-pth="https://www.facebook.com/Piluliru"></i>
								</div>
							</div>
						</div><!-- end phone-->
						<span class="copyright">&#169 2016 Интернет-магазин "Pethappy.ru"</span>
					</div><!-- end right-block -->
				</footer>
			</div><!-- end scrollbar-outer -->
		</div><!-- end mobile-block -->
	

<div class="container">
		

	<header>
		<div class="header-head">
			<div class="inner">
				<div class="table">
					<div class="cell leftcol">
						<?$APPLICATION->IncludeComponent("twofingers:location", "new", Array(), false);?>
						<div class="top-menu">
							<a href="/pages/shipping" class="top-menu-link">Доставка</a>&nbsp
							<a href="/pages/payment" class="top-menu-link">Оплата</a>
						</div><!-- end top-menu -->							
					</div>
					<div class="cell rightcol">
						<div class="callback">
							<span class="phone">
								<a class="g-bold none-active">8 495 649-03-03</a>
							</span>
							<div class="callback-wrap js-dropdown-wrap">
								<a href="#" class="callback-link js-dropdown-link"><span class="text">Заказать звонок</span><i class="piluli-18"></i></a>
								<div class="callback-block js-dropdown-block js-submit-form js-close-block" id="callback_phone">
								
									<a href="#" class="close-btn js-close-btn"><i class="piluli-54"></i></a>
									<h2>Обратный звонок</h2>
									<p>Укажите ваш номер телефона и имя. Мы  Вам перезвоним через 2 минуты.</p>
									<label class="for-input"><span class="input-label">Как вас зовут?</span>
										<input type="text" name="name_call" id="name_callback" class="invalid">
									</label>
									<label class="for-input"><span class="input-label">Мобильный телефон</span><input type="text" class="phone_mask" placeholder="+7" id="phone_callback" name="phone_call"></label>
									<a href="javascript:void(0)" style='vertical-align: text-bottom;' class="btn-reg" id="submit_callback">Я жду звонка</a> 
									<div id="hourglass" style="display: none; height: 30px; padding: 0px 10px 0; vertical-align: text-bottom;"><img src="/images/hourglass.svg" style="width: 30px;"></div>
								</div><!-- end callback-block -->
							</div><!-- end callback-wrap -->
						</div><!-- end callback -->
						<?
						if ($USER->IsAuthorized()):
						?>
							<div class="dropdown-wrap js-dropdown-wrap">
								<a href="#" class="dropdown-link js-dropdown-link">Личный кабинет <i class="piluli-52"></i></a>
								<div class="dropdown-block  js-dropdown-block">
									<ul class="dropdown-list">
										<li><a href="/personal/">Личные данные</a></li>
										<li><a href="/personal/history/">Заказы</a></li>
										<li><a href="/auth/?logout=yes">Выход</a></li>
									</ul><!-- end dropdown-list -->
								</div><!-- end drodown-block -->
							</div>
						<?else:?>
							<div class="enter-wrap js-popup-wrap">
								<a href="#" class="enter-link js-enter-popup-link">Вход и регистрация <i class="piluli-52"></i></a>
							</div>
						<?endif;?>
					</div>
				</div>
			</div><!-- end inner -->
		</div><!-- end header-head -->
		<div class="header-body">
			<div class="inner">
				<a href="/" class="logo">
					<img src="<?=SITE_TEMPLATE_PATH?>/img/logo.png" alt="" />
					<? /*<span>Интернет-магазин №1</span>*/ ?>
				</a><!-- end logo -->

					<?$APPLICATION->IncludeComponent("bitrix:search.title", "catalog1", Array(
						"CATEGORY_0" => array(	// Ограничение области поиска
								0 => "iblock_1c_catalog",
							),
							"CATEGORY_0_TITLE" => "",	// Название категории
							"CHECK_DATES" => "N",	// Искать только в активных по дате документах
							"CONTAINER_ID" => "title-search",	// ID контейнера, по ширине которого будут выводиться результаты
							"INPUT_ID" => "title-search-input",	// ID строки ввода поискового запроса
							"NUM_CATEGORIES" => "1",	// Количество категорий поиска
							"ORDER" => "date",	// Сортировка результатов
							"PAGE" => "#SITE_DIR#search/index.php",	// Страница выдачи результатов поиска (доступен макрос #SITE_DIR#)
							"SHOW_INPUT" => "Y",	// Показывать форму ввода поискового запроса
							"SHOW_OTHERS" => "N",	// Показывать категорию "прочее"
							"TOP_COUNT" => "5",	// Количество результатов в каждой категории
							"USE_LANGUAGE_GUESS" => "Y",	// Включить автоопределение раскладки клавиатуры
							"COMPONENT_TEMPLATE" => "catalog",
							"PRICE_CODE" => array(	// Тип цены
								0 => "Цена продажи",
							),
							"PRICE_VAT_INCLUDE" => "Y",	// Включать НДС в цену
							"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода
							"SHOW_PREVIEW" => "Y",	// Показать картинку
							"PREVIEW_WIDTH" => "75",	// Ширина картинки
							"PREVIEW_HEIGHT" => "75",	// Высота картинки
							"CONVERT_CURRENCY" => "N",	// Показывать цены в одной валюте
							"CATEGORY_0_iblock_1c_catalog" => array(	// Искать в информационных блоках типа "iblock_1c_catalog"
								0 => "2",
							)
						),
						false
					);?>

				<div class="header-links">
					<a href="/personal/wishlist/"><i class="piluli-1"></i><span class="<?if(!$arElements):?>hidden<?endif;?> __favorite-count"><?=count($arElements)?></span><b>Отложенное</b></a>
					<a href="/personal/cart/"><i class="piluli-2"></i><span class="<?if($bcount==0):?>hidden<?endif;?> __cart-count"><?=$bcount?></span><b>Корзина</b></a>
				</div>
				<nav>
					<ul class="nav-menu">
						<?$APPLICATION->IncludeComponent("bitrix:menu", "main", Array(
							"ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
								"MENU_CACHE_TYPE" => "A",	// Тип кеширования
								"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
								"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
								"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
								"MAX_LEVEL" => "1",	// Уровень вложенности меню
								"CHILD_MENU_TYPE" => "catalog",	// Тип меню для остальных уровней
								"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
								"DELAY" => "N",	// Откладывать выполнение шаблона меню
								"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
								"MENU_THEME" => "site",
								"COMPONENT_TEMPLATE" => "vertical_multilevel"
							),
							false
						);?>						
					</ul><!-- end nav-menu-->
				</nav>
			</div><!-- end inner -->
			<div class="menu-popup-wrap js-menu-popup-wrap">
				<div class="inner">
					<a href="/categories/" class="menu-popup-link js-menu-popup-link"><span class="text">Каталог товаров<i class="arrow piluli-52"></i></span></a>
				</div>
				<div class="main-menu-popup js-menu-popup">
					<div class="for-bg">
						<?$APPLICATION->IncludeComponent("bitrix:menu", "dcatalog", Array(
							"ROOT_MENU_TYPE" => "catalog",	// Тип меню для первого уровня
								"MENU_CACHE_TYPE" => "A",	// Тип кеширования
								"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
								"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
								"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
								"MAX_LEVEL" => "2",	// Уровень вложенности меню
								"CHILD_MENU_TYPE" => "catalog",	// Тип меню для остальных уровней
								"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
								"DELAY" => "N",	// Откладывать выполнение шаблона меню
								"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
								"MENU_THEME" => "site",
								"COMPONENT_TEMPLATE" => "vertical_multilevel"
							),
							false
						);?>
					</div>
				</div><!-- end main-menu-popup -->
			</div>
		</div><!-- end header-body -->
	</header>

	<section class="popup enter-popup js-popup" id="authReg">
		<section class="popup enter-popup js-popup" style="top: 60px;/* display: none; */">
			<div class="popup-container">
				<a href="#" class="close-popup js-close-popup"><i class="piluli-54"></i></a>
				<div class="table js-enter-module">
					<div class="leftcol cell">
						<form method="post" action="/personal/" name="login" id="popup_login_signin">
							<h1>Войти</h1>
							<? /*<p>Мгновенный вход, используя: </p>

							<div class="social-module">
								<a href="#" class="vk login_popup_soc_btn" data-soc-name="vk"><i class="piluli-10"></i></a>
								<a href="#" class="ok login_popup_soc_btn" data-soc-name="ok"><i class="piluli-12"></i></a>
								<a href="#" class="fb login_popup_soc_btn" data-soc-name="fb"><i class="piluli-11"></i></a>
							</div><!-- end social-module -->*/ ?>
							<p>Авторизация покупателя:</p>
							<label class="for-input"><input data-validation="true" id="log_autoriz" type="text" name="email_address" class="lpti" placeholder="Email"></label>
							<label class="for-input"><input class="lpti" data-validation="true" id="pass_autoriz" type="password" name="password" placeholder="Пароль"></label>
							<p><a href="#" class="forgotpass-link js-repair-module-link">Забыли пароль?</a></p>
							<input type="hidden" name="type_of_client" value="1">
							<div class="btn-wrap">
								<button type="submit" class="btn-reg">Войти</button>
								<a href="#" class="btn-link js-register-module-link" id="b-inside-tab-register">Зарегистрироваться</a>
							</div><!-- end btn-wrap -->
						</form>
					</div>
					<div class="rightcol cell">
						<h2>Ваш личный кабинет на Pethappy.ru:</h2> 
						<ul class="account-features-list">
							<!--li class="table">
								<div class="cell"><i class="piluli-58"></i></div>
								<div class="cell">Доступ к накопительным скидкам до 5%</div>
							</li-->
							<li class="table">
								<div class="cell"><i class="piluli-57"></i></div>
								<div class="cell">Повтор заказа</div>
							</li>
							<li class="table">
								<div class="cell"><i class="piluli-55"></i></div>
								<div class="cell">Специальные предложения в праздники</div>
							</li>
							<li class="table">
								<div class="cell"><i class="piluli-56"></i></div>
								<div class="cell">Быстрое оформление заказа</div>
							</li>
						</ul><!-- end account-features-list -->
					</div>
				</div><!-- end table -->
				<div class="table display-none js-register-module">
					<div class="leftcol cell">
						<form method="post" action="/personal/" name="create_account" id="popup_login_signup" autocomplete="off">
							<h1>Регистрация</h1>
							<? /*<p>Мгновенная регистрация, используя: </p>
							<div class="social-module">
								<a href="#" class="vk login_popup_soc_btn" data-soc-name="vk"><i class="piluli-10"></i></a>
								<a href="#" class="ok login_popup_soc_btn" data-soc-name="ok"><i class="piluli-12"></i></a>
								<a href="#" class="fb login_popup_soc_btn" data-soc-name="fb"><i class="piluli-11"></i></a>
							</div><!-- end social-module -->*/ ?>
							<p>Или заполните форму покупателя:</p>
							<label class="for-input"><input class="lpti" name="popup_name" type="text" placeholder="ФИО" autocomplete="off"></label>
							<label class="for-input"><input type="text" name="popup_mail" class="lpti" placeholder="Электронная почта" autocomplete="off"></label>
							<label class="for-input"><input type="text" placeholder="Мобильный телефон" value="" name="popup_phone" class="lpti phone_mask" autocomplete="off"></label>
							<label class="for-input"><input type="password" placeholder="Пароль" name="popup_password" class="lpti" autocomplete="off"></label>
							<p class="note">Регистрируясь на нашем сайте, вы подтверждаете, что ознакомлены с <a class="fancybox fancybox.ajax" href="/blind/privacy.php"> Политикой конфиденциальности</a></p>
							<input type="hidden" name="type_of_client" value="1">
							<div class="btn-wrap">
								<button type="submit" class="btn-reg _validatePopupReg">Зарегистрироваться</button>
								<a href="#" class="btn-link js-enter-module-link" id="b-inside-tab-login">Войти</a>
							</div><!-- end btn-wrap -->
						</form>
					</div>
					<div class="rightcol cell">
						<h2>Почему стоит пройти регистрацию на Pethappy.ru?</h2>
						<ul class="account-features-list">
							<!--li class="table">
								<div class="cell"><i class="piluli-58"></i></div>
								<div class="cell">Доступ к накопительным скидкам до 5%</div>
							</li-->
							<li class="table">
								<div class="cell"><i class="piluli-57"></i></div>
								<div class="cell">Повтор заказа</div>
							</li>
							<li class="table">
								<div class="cell"><i class="piluli-55"></i></div>
								<div class="cell">Специальные предложения в праздники</div>
							</li>
							<li class="table">
								<div class="cell"><i class="piluli-56"></i></div>
								<div class="cell">Быстрое оформление заказа</div>
							</li>
						</ul><!-- end account-features-list -->
					</div>
				</div>
				<div class="table display-none js-repair-module">
					<div class="leftcol cell">
						<form action="/auth/forgot/">
							<input type="hidden" name="backurl" value="/auth/forgot/">
							<input type="hidden" name="AUTH_FORM" value="Y">
							<input type="hidden" name="TYPE" value="SEND_PWD">
							<br>

							<h1>Забыли пароль?</h1>
							<p>Если Вы забыли свой пароль, введите<br>e-mail, указанный при регистрации.</p><p>На него будет выслана инструкция по восстановлению пароля.</p>

							<br>

							<label class="for-input"><input name="USER_EMAIL" type="text" placeholder="Электронная почта"></label>

							<br>

							<div class="btn-wrap">
								<a href="#" class="btn-reg js-repair2-module-link">Восстановить пароль</a>
								<a href="#" class="btn-link js-enter-module-link">Войти</a>
							</div><!-- end btn-wrap -->
						</form>
					</div>
					<div class="rightcol cell">
						<h2>Ваш личный кабинет на Pethappy.ru:</h2>
						<ul class="account-features-list">
							<!--li class="table">
								<div class="cell"><i class="piluli-58"></i></div>
								<div class="cell">Доступ к накопительным скидкам до 5%</div>
							</li-->
							<li class="table">
								<div class="cell"><i class="piluli-57"></i></div>
								<div class="cell">Повтор заказа в 1 клик</div>
							</li>
							<li class="table">
								<div class="cell"><i class="piluli-55"></i></div>
								<div class="cell">Специальные предложения в праздники</div>
							</li>
							<li class="table">
								<div class="cell"><i class="piluli-56"></i></div>
								<div class="cell">Быстрое оформление заказа</div>
							</li>
						</ul><!-- end account-features-list -->
					</div>
				</div>

				<div class="table display-none js-repair2-module">
					<div class="leftcol cell">
						<form action="#">
							<br>
							<br>
							<br>

							<h1>Восстановление пароля</h1>
							<p class="js-repair-email dn">На указанный вами адрес отправлено письмо со ссылкой для смены пароля</p>
							<p class="js-repair-phone dn">На Ваш телефон придет смс с временным паролем. После успешной авторизации пароль станет постоянным.</p>

							<br>

							<div class="btn-wrap">
								<a href="#" class="btn-reg js-close-popup">Отлично</a>
								<a href="#" class="btn-link js-enter-module-link">Войти</a>
							</div><!-- end btn-wrap -->
						</form>
					</div>
					<div class="rightcol cell">
						<h2>Ваш личный кабинет на Pethappy.ru:</h2>
						<ul class="account-features-list">
							<!--li class="table">
								<div class="cell"><i class="piluli-58"></i></div>
								<div class="cell">Доступ к накопительным скидкам до 5%</div>
							</li-->
							<li class="table">
								<div class="cell"><i class="piluli-57"></i></div>
								<div class="cell">Повтор заказа в 1 клик</div>
							</li>
							<li class="table">
								<div class="cell"><i class="piluli-55"></i></div>
								<div class="cell">Специальные предложения в праздники</div>
							</li>
							<li class="table">
								<div class="cell"><i class="piluli-56"></i></div>
								<div class="cell">Быстрое оформление заказа</div>
							</li>
						</ul><!-- end account-features-list -->
					</div>
				</div>
				<div class="clear"></div>

			</div><!-- end container -->
		</section>
	</section><!-- end popup -->

	<section class="content">
		<div class="inner">
			<?if($APPLICATION->GetCurPage()!="/" && $APPLICATION->GetCurPage()!="/personal/cart/" ):?>
				<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "new", Array(
	"PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
		"SITE_ID" => "s1",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
		"START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
	),
	false
);?>
			<?endif;?>
			<?if($APPLICATION->GetCurPage()!="/" && $APPLICATION->GetCurPage()!="/personal/cart/" ):?><h1><?$APPLICATION->ShowTitle(false);?></h1><?endif;?>
			
			<?if(strstr($APPLICATION->GetCurPage() , "/categories/") || $APPLICATION->GetCurPage()=="/" || (strstr($APPLICATION->GetCurPage(), "/personal/") && !strstr($APPLICATION->GetCurPage(), "/cart/") && !strstr($APPLICATION->GetCurPage(), "/order/"))):?>
			
			<div class="layout">
				<aside>
					<?$APPLICATION->ShowViewContent('filter');?>
					<?$APPLICATION->ShowViewContent('left_sections');?>
					
					<a href="http://clck.yandex.ru/redir/dtype=stred/pid=47/cid=2508/*http://market.yandex.ru/shop/305626/reviews"><img alt="Читайте отзывы покупателей и оценивайте качество магазина на Яндекс.Маркете" border="0" src="http://clck.yandex.ru/redir/dtype=stred/pid=47/cid=2507/*http://grade.market.yandex.ru/?id=305626&action=image&size=3" width="240" /></a>

					<?if(!strstr($APPLICATION->GetCurPage(), "/personal/")):?>
					<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"main_news", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "11",
		"IBLOCK_TYPE" => "Settings",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "5",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"COMPONENT_TEMPLATE" => "main_news"
	),
	false
);?>
<?endif;?>
				</aside>
				<div class="main">
				
				
			<?endif;?>