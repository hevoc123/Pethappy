$(document).ready(function () {
	
	function a_getCookie(name) {
		var matches = document.cookie.match(new RegExp(
			"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
		));
		return matches ? decodeURIComponent(matches[1]) : undefined;
	}
        
	function a_setCookie(name, value, options) {
		options = options || {expires: 3600*24*30,path:'/'};
		
		var expires = options.expires;
		
		if (typeof expires == "number" && expires) {
			var d = new Date();
			d.setTime(d.getTime() + expires*1000);
			expires = options.expires = d;
		}
		if (expires && expires.toUTCString) { 
			options.expires = expires.toUTCString();
		}
		
		value = encodeURIComponent(value);
		
		var updatedCookie = name + "=" + value;
		
		for(var propName in options) {
			updatedCookie += "; " + propName;
			var propValue = options[propName];    
			if (propValue !== true) { 
			updatedCookie += "=" + propValue;
			}
		}
		
		document.cookie = updatedCookie;
	}

	/*
	 * login / register solver
	 */

	/*
	 * login / register tabs
	 */
	$(document).on('click', '#b-inside-tab-register', function(e){
		e.preventDefault();
		$('.b-inside__w-login').hide();
		$('.b-inside__w-register').show();
	})
	$(document).on('click', '#b-inside-tab-login', function(e){
		e.preventDefault();
		$('.b-inside__w-register').hide();
		$('.b-inside__w-login').show();
	})

	//default cookie
	a_setCookie('popup_tab','enter');
	
	var p = {
		win: $(window),
		ovr: $('.login_popup_privacy_overlay'),
		pop: $('.login_popup_privacy'),
		content: $('.login_popup_privacy_content'), 
		cls: $('.login_popup_privacy_close'),
		prv: $('.popup_login_show_privacy'),
		redraw: function () {
			var W = p.win.width(),
				H = p.win.height(),
				newW = Math.min(800, Math.max(200, W - 20)),
				newH = Math.max(200, H - 180); 

			p.pop.css({
				width: newW,
				height: newH
			});

			p.pop.css({
				margin: '-' + (p.pop.outerHeight() / 2) + 'px 0 0 -' + (p.pop.outerWidth() / 2) + 'px'
			});

			p.content.css('height', newH - 18 - 57 - 2);

		},
		init: function () {
			p.redraw();
			p.win.resize(p.redraw);
			p.cls.click(function () { p.ovr.fadeOut(100, 'linear'); });
			p.prv.click(function () { p.ovr.fadeIn(100, 'linear'); });
		}
	};

	var f = {
		current_form: 'signin',
		btn_signin: $('#b-inside-tab-login'),
		btn_signup:	$('#b-inside-tab-register'),
		pop_shower: $('.__pm-auth-btn'),
		pop_closer: $('.popup_login_closer'),
        out_popup: $('.popup_shadow_s'),
		pop_object: $('.popup.popup_login'),
		pop_shadow: $('.popup_shadow'),
		soc_buttons: $('.login_popup_soc'),
		diffpass: $('#pass_no_pass'),
		isntfree: $('.login_popup_notfree'),
		ajax: {
			reg_email: null
		},
		submit: function (e) {
			var form = $(this);

			//if (form.attr('id') == 'popup_login_signin') f.validate_signin();
			var fields = form.find('[data-validation]');

			for (var i = 0; i < fields.length; i++) {
				if (!$(fields[i]).hasClass('lpti-ok')) {
					e.preventDefault();
					return false;							
				}
			}

            //  в этой ветке нажатие на кнопку. Тут все и проверяем.
            //проверяем верный логин или пароль на авторизации. Отправляем проверять. Если нет Возвращаем сразу в
            // попап авторизации без переходов как было ранеее
            //записываем логин и пароль
            var log_autoriz = $('#log_autoriz').val();
            var pass_autoriz = $('#pass_autoriz').val();
            $.ajax({
                url: "/ajax/check_email",
                type: "POST",
                //async:false, если true ответ ajax е успеет прийти и всегда будет работать одна ветка.
                async:false,
                cache:false,
                    data: 'log_auto='+log_autoriz+'&pass_auto='+pass_autoriz,
                success:function(data) {
                    if(trim(data) == 'no'){
                        //если ответ пришел no ставляем на этой страничке авторизации. и меняем кнопку на забыли пароль
                        //заодно ичищаю поля логин и пароль если не верно

                        /*$('#log_autoriz').val('').('lpti-error');
                        $('#pass_autoriz').val('').('lpti-error');*/
                        //$('#log_autoriz').val('').removeClass('lpti-ok').addClass("lpti-error");
                        $('#pass_autoriz').val('').removeClass('lpti-ok').addClass("lpti-error");
                            e.preventDefault();

                    }
                }

            });

		},
		validate: function (e) {
			var field = $(this),
				name = field.attr('name'),
				val = field.val().trim();

            $('#pas2').val($('#pas1').val());
            $('#pas2').addClass('lpti-ok');

			// Если поле пустое, иконку ошибки отображать не надо
			field[val.length ? 'removeClass' : 'addClass']('lpti-hideerror');

			if (f.current_form == 'signin') {
				if (name == 'email_address') {
					field.removeClass('lpti-ok').removeClass('lpti-error').addClass(((val.length < 5) || !val.match(/^[a-zA-Z0-9_\.\-]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z0-9]+|[0-9\+\-\(\)]+$/)) ? 'lpti-error' : 'lpti-ok');
				} else if (name == 'password') {
					field.removeClass('lpti-ok').removeClass('lpti-error').addClass(val.length ? 'lpti-ok' : 'lpti-error');
				}
                //кнопки "забыли пароль" или "запомнить" чекбокс, смена кнопок
                if(val.length > 0){
                    $('#get_over').css("display", "none");
                    $('#remember').css("display", "inline");
                }else{
                    $('#get_over').css("display", "inline");
                    $('#remember').css("display", "none");
                }

			} else {
				if (e.type == 'keyup') {
					if (name == 'popup_mail') {
						if ((val.length < 5) || !val.match(/^[a-zA-Z0-9_\.\-]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z0-9]+$/)) {
							f.isntfree.stop(true).fadeOut(100, 'linear');
							field.removeClass('lpti-ok').addClass('lpti-error');
						} else {
							
							field.removeClass('lpti-error').addClass('lpti-ok');
						}
					} else if (name == 'popup_name') {
						if (val.length < 2) {
							field.removeClass('lpti-ok').addClass('lpti-error');
						} else {
							field.removeClass('lpti-error').addClass('lpti-ok');
						}
					} else if (name == 'popup_phone') {
						// checking phone type '+7 (920) 111-1111'
						if ((val.length < 6) || val.match(/[^0-9-)(+ ]/)) {
							field.removeClass('lpti-ok').addClass('lpti-error');
						} else {
							field.removeClass('lpti-error').addClass('lpti-ok');
						}							
					} else if (name == 'popup_password' || name == 'password') {
						if (!val.length) {
							field.removeClass('lpti-ok').addClass('lpti-error');
						} else {
							field.removeClass('lpti-error').addClass('lpti-ok');
						}
					} /*else if (name == 'popup_confirmation') {
						var val2 = $('#popup_login_signup [name="popup_password"]').val();
                        console.log(val);
						if (val.length && (val == val2)) {
							field.removeClass('lpti-error').addClass('lpti-ok');
							f.diffpass.stop(true).animate({
								opacity: 0,
								left: 190
							}, 50, 'linear');
						} else {
							field.removeClass('lpti-ok').addClass('lpti-error');
							f.diffpass.stop(true).animate({
								opacity: 1,
								left: 180
							}, 50, 'linear');					
						}												
					}*/
				} else if (e.type == 'focusout') {
					field.trigger('keyup');

					if (name == 'popup_mail') {
						if (!field.hasClass('lpti-error')) {
							if (f.ajax.reg_email !== null) {
								try {
									f.ajax.reg_email.abort();
									f.ajax.reg_email = null;
								} catch (e) {}
							}

							field.removeClass('lpti-ok').addClass('lpti-wait');

							f.ajax.reg_email = $.ajax({
			                    url: "/ajax/check_email",
			                    type: "POST",
			                    data: {
			                        email: val
			                    },
			                    dataType: "JSON"
			                }).success(function(data) {
			                    if (data.isFree) {
									field.addClass('lpti-ok');
									f.isntfree.stop(true).fadeOut(100, 'linear');
			                    } else {
									field.addClass('lpti-error');
									f.isntfree.stop(true).fadeIn(100, 'linear');
			                    }
			                }).error(function() {
								field.addClass('lpti-error');
			                    for (var i in arguments) {
			                        console.log(arguments[i]);
			                    }                    
			                }).always(function() {
								field.removeClass('lpti-wait');
			                });
						}
					}
				}
			}
		},
		validate_signin: function () {
			// Так как доктайп xHTML, тег "autocomplete" у форм не поддерживается,
			// в связи с чем отключить автозаполнение форм нельзя. А форма логина
			// часто заполняется автоматически. Эта функция служит для валидации
			// автозаполненной формы логина перед отправкой.
			/*$('#popup_login_signin .lpti').each(function () {
				$(this).focus().blur();
			});*/
		},
		toggle_popup: function (action) {
			if (action == 'show') {
				$('.usl_dost').hide();
				f.pop_shadow.show();
				f.pop_object.css(
					'top', 
					Math.max(15, 
						Math.min(100, 
							(
								(
									$(window).height() * ('devicePixelRatio' in window ? window.devicePixelRatio : 1)
								) - 610
							) / 2
						)
					) + 'px'
				).stop(true).fadeIn(150);
			} else {
				f.pop_object.stop(true).fadeOut(150, function () { f.pop_shadow.hide(); });
			}
		},
		init: function () {
			// При отправке форм
			//$('#popup_login_signin, #popup_login_signup').submit(f.submit);

			// Клик на таб Войти
			f.btn_signin.click(function () {
				a_setCookie('popup_tab','enter');
				f.current_form = 'signin';
			});

			// Клик на таб регистрация
			f.btn_signup.click(function () {
				a_setCookie('popup_tab','reg');
				f.current_form = 'signup';
			});

			// Валидация полей
			$('.b-inside__wrap-input [data-validation]')
				.on('focusout keyup', f.validate)
				.on('focusin', function (e) {
					$(this).removeClass('lpti-wait');
				});

			// Показать попап
			f.pop_shower.click(function () { f.toggle_popup('show'); });

			// Скрыть попап
            f.pop_closer.click(function () { f.toggle_popup('hide'); });
			f.out_popup.click(function () { f.toggle_popup('hide'); });
			

		}
	};

	var l = {
		get_base_domain: function () {
			return ((location.hostname.indexOf('pilu.li') > -1) ? location.hostname : 'pethappy.ru');
		},
		funcs: {

		},
		click: function () {
			var name = $(this).attr('data-soc-name');
			if (name in l.funcs) {
				$.cookie(
					'social_auth_base_domain',
					location.hostname,
					{
						domain: ((location.hostname.indexOf('pilu.li') > -1) ? '.pilu.li' : '.pethappy.ru'),
						expires: new Date((new Date()).getTime() + 5 * 60 * 1000), // 30 min
						path: '/'
					}
				);

				$.cookie(
					'social_auth_base_url_path',
					location.pathname + location.search,
					{
						domain: ((location.hostname.indexOf('pilu.li') > -1) ? '.pilu.li' : '.pethappy.ru'),
						expires: new Date((new Date()).getTime() + 5 * 60 * 1000), // 30 min
						path: '/'
					}
				);

				l.funcs[name](encodeURIComponent('http://' + l.get_base_domain() + '/social_auth_token_receiver.php?sid=' + name));
			}
		},
		init: function () {
			$(document).on('click','.login_popup_soc_btn', l.click);
		}
	}

	// Popup init
	p.init();

	// Form init
	f.init();

	// Login/reg init
	l.init();


	$(document).keydown(function(e){
		if(e.which == 27){
			f.toggle_popup('hide');
			$('.usl_dost').show();
		}
	});
});
