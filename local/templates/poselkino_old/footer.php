<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)die();?>
		<footer>
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="top-footer">
							<div class="title">
								Если вам удалось обнаружить ошибки
								<br>
								или неактуальную информацию, сообщите нам
							</div>
							<div class="link-page">
								<a href="#" data-modal='send-error'>
									Сообщить
								</a>
							</div>
						</div>
						<div class="bottom-footer">
							<div class="item">
								<div class="logo">
									<a href="/"><img src="<?=SITE_TEMPLATE_PATH?>/img/logo-nav.png" alt="Поселкино" title="Поселкино"></a>
								</div>
								<div class="copirait">
									© <?=date('Y')?>
									<br>
									Все права защищены
								</div>
							</div>
							<div class="item">
								<ul>
									<li>
										<a href="/poselki/kottedzhnye/">
											Коттеджные поселки
										</a>
									</li>
									<li>
										<a href="/poselki/dachnye/">
											Дачные поселки
										</a>
									</li>
									<li>
										<a href="/poselki/#shosse_rayon">
											По шоссе
										</a>
									</li>
									<li>
										<a href="/poselki/#shosse_rayon">
											По районам
										</a>
									</li>
									<li>
										<a href="/#byFilter">
											По направлению
										</a>
									</li>
									<li>
										<a href="/o-proekte/">
											О проекте
										</a>
									</li>
									<li>
										<a href="/sitemap/">
											Карта сайта
										</a>
									</li>
								</ul>
							</div>
							<div class="item">
								<ul>
									<li>
										<a href="/blog/">
											Блог
										</a>
									</li>
									<li>
										<a href="/reklama/" onclick="window.open('/reklama/', '_blank'); return false;">
											Реклама и сотрудничество
										</a>
									</li>
									<li>
										<a href="/politika-konfidentsialnosti/" onclick="window.open('/politika-konfidentsialnosti/', '_blank'); return false;">
											Политика обработки персональных данных
										</a>
									</li>
									<li>
										<a href="/polzovatelskoe-soglashenie/" onclick="window.open('/polzovatelskoe-soglashenie/', '_blank'); return false;">
											Пользовательское
											соглашение
										</a>
									</li>
									<li>
										<a href="/kontakty/">
											Контакты
										</a>
									</li>
								</ul>
							</div>
							<div class="item">
								<div class="title">
									Контакты:
								</div>
								<div class="email-link" itemscope itemtype="http://schema.org/LocalBusiness">
									<meta itemprop="name" content="Поселкино">
									<meta itemprop="telephone" content="+7 (926) 223-00-71">
									<span itemprop="url" class="hide">https://poselkino.ru/</span>
									<meta itemprop="openingHours" content="Mo-Fr 09:00-21:00">
									<span itemprop="logo" class="hide">https://poselkino.ru/local/templates/poselkino/img/logo-nav.png</span>
									<span itemprop="image" class="hide">https://poselkino.ru/local/templates/poselkino/img/logo-nav.png</span>
									<a href="mailto:welcome@poselkino.ru">
										<span itemprop="email">welcome@poselkino.ru</span>
									</a>
									<span itemprop="priceRange" class="hide">RUB</span>
									<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" class="hide">
										<span itemprop="addressCountry">Россия</span>
										<span itemprop="addressLocality">Балашиха</span>
										<span itemprop="addressRegion">Московска область</span>
										<span itemprop="postalCode">143900</span>
								    <span itemprop="streetAddress">проспект Ленина, 32Д, корп. 2</span>
								  </div>
								</div>
								<div class="write-us">
									<a href="#" data-modal='write-to-us' data-id-button='WRITE_TO_US_FOOT'>
										Написать нам
									</a>
								</div>
								<div class="social-block-footer">
									<ul class="ul-social">
										<li>
											<a href="https://vk.com/poselkino/" class="vk"></a>
										</li>
										<li>
											<a href="https://www.facebook.com/poselkino/" class="facebook"></a>
										</li>
										<li>
											<a href="https://www.instagram.com/poselkino/" class="instagram"></a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>
	</div>
		<!-- fixed block -->
		<div class="fixed-block">
			<div class="item">
				<div class="scroll-top">
					<div></div>
					наверх
					<br>
					к фильтру
				</div>
			</div>
		</div>
		<div class="fixed-block-comparison">
			<div class="item">
				<?$APPLICATION->IncludeComponent(
					"bitrix:catalog.compare.list",
					"poselkino",
					array(
						"ACTION_VARIABLE" => "action",
						"AJAX_MODE" => "N",
						"AJAX_OPTION_ADDITIONAL" => "",
						"AJAX_OPTION_HISTORY" => "N",
						"AJAX_OPTION_JUMP" => "N",
						"AJAX_OPTION_STYLE" => "Y",
						"COMPARE_URL" => "/sravnenie/?DIFFERENT=Y",
						"DETAIL_URL" => "",
						"IBLOCK_ID" => "1",
						"IBLOCK_TYPE" => "content",
						"NAME" => "CATALOG_COMPARE_LIST",
						"POSITION" => "bottom right",
						"POSITION_FIXED" => "Y",
						"PRODUCT_ID_VARIABLE" => "id",
						"COMPONENT_TEMPLATE" => ".default"
					),
					false
				);?>
			</div>
		</div>
		<!-- modal window -->
		<input type="hidden" id="idButton">
		<div class="success-cppy">
			Ссылка скопирована в буфер обмена
		</div>
		<div class="modal-window" data-modal='write-to-us'>
			<div class="window">
				<div class="close-win"></div>
				<div class="h3">
					Написать нам
				</div>
				<div class="h4">
					В форме обратной связи Вы можете задать
					нам любой вопрос
				</div>
				<form action="#" class="form-write" id="formToUs">
					<label>
						<input type="text" placeholder="Ваше имя *" required id="nameToUs">
					</label>
					<label>
						<input type="tel" class="tel" placeholder="Номер телефона *" id="telToUs" required>
					</label>
					<label>
						<input type="email" placeholder="Адрес электронной почты *" id="emailToUs" required>
					</label>
					<label>
						<textarea placeholder="Текст обращения *" id="textToUs" required></textarea>
					</label>
					<div class="submit">
						<input type="submit" value="Отправить" id="sendToUs">
					</div>
					<p>
						Нажимая на кнопку, вы даете согласие на обработку
						персональных данных и соглашаетесь c
						<a href="/politika-konfidentsialnosti/">
							Политикой
							Конфиденциальности
						</a>
					</p>
				</form>
			</div>
		</div>
		<div class="modal-window" data-modal='sung-up-view'>
			<div class="window">
				<div class="close-win"></div>
				<div class="h3">
					Записаться на просмотр
				</div>
				<div class="text">
					Мы передадим ваши контактные данные представителям поселка
				</div>
				<form action="#" class="form-write" id="formSignToView">
					<label>
						<input type="text" placeholder="Ваше имя *" id="nameSignToView" required>
					</label>
					<label>
						<input type="tel" class="tel" placeholder="Номер телефона *" id="telSignToView" required>
					</label>
					<div class="submit">
						<input type="submit" value="Отправить">
					</div>
					<p>
						Нажимая на кнопку, вы даете согласие на обработку
						персональных данных и соглашаетесь c
						<a href="/politika-konfidentsialnosti/">
							Политикой
							Конфиденциальности
						</a>
					</p>
				</form>
			</div>
		</div>
		<div class="modal-window" data-modal='send-error'>
		  <div class="window">
		    <div class="close-win"></div>
		    <div class="h3">
		      Нашли ошибку? Помогите нам стать лучше!
		    </div>
		    <form action="#" class="form-write" id="formSendError">
		      <label>
		        <textarea placeholder="Что не так *" id="textPosEr" required></textarea>
		      </label>
		      <div class="submit">
		        <input type="submit" value="Отправить">
		      </div>
		      <p>
		        Нажимая на кнопку, вы даете согласие на обработку
		        персональных данных и соглашаетесь c
		        <a href="/politika-konfidentsialnosti/">
		          Политикой
		          Конфиденциальности
		        </a>
		      </p>
		    </form>
		  </div>
		</div>
		<!-- modal window -->
		<!-- script -->
			<?use Bitrix\Main\Page\Asset;
			// functions
			Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/function.js");
			// slick
			Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/plugins/slick.min.js");
			Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/plugins/slick-include.js");
			// fancybox
			Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/plugins/jquery.fancybox.min.js");
			Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/plugins/fancybox-include.js");
			// google charts
			// Asset::getInstance()->addJs("https://www.gstatic.com/charts/loader.js");
			// Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/google.charts.js");
			// owl carousel
			Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/plugins/owl.carousel.js");
			Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/plugins/owl.carousel-include.js");
			// auto-resize-textarea
			Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/plugins/auto-resize-textarea.js");
			// jquery-ui
			Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/plugins/jquery-ui.js");
			Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/plugins/jquery-ui-include.js");
			Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/plugins/jquery.ui.touch-punch.min.js");
			// Asset::getInstance()->addJs("//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js");
			// маска на телефон
			Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/plugins/mask-number.js");
			Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/plugins/mask-number-include.js");
			// ya-share2
			Asset::getInstance()->addJs("//yastatic.net/es5-shims/0.0.2/es5-shims.min.js");
			Asset::getInstance()->addJs("//yastatic.net/share2/share.js");
			// Яндекс.Карты
			Asset::getInstance()->addJs("https://api-maps.yandex.ru/2.1/?lang=ru_RU");
			// lazy load
			Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/plugins/lazy-load.js");
			// my scripts
			Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/scripts.js");
			// my swipe
			Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/plugins/swipe.js");
			?>
			<!-- Global site tag (gtag.js) - Google Ads: 783230785 -->
			<script async src="https://www.googletagmanager.com/gtag/js?id=AW-783230785"></script>
			<script>
				window.dataLayer = window.dataLayer || [];
				function gtag(){dataLayer.push(arguments);}
				gtag('js', new Date());

				gtag('config', 'AW-783230785');
				gtag('config', 'UA-140318130-1');
			</script>
			<script>
				gtag('event', 'page_view', {
				'send_to': 'AW-783230785',
				'user_id': 'replace with value'
				});
			</script>
			<!-- Facebook Pixel Code -->
			<script>
			!function(f,b,e,v,n,t,s)
			{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
			n.callMethod.apply(n,arguments):n.queue.push(arguments)};
			if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
			n.queue=[];t=b.createElement(e);t.async=!0;
			t.src=v;s=b.getElementsByTagName(e)[0];
			s.parentNode.insertBefore(t,s)}(window, document,'script',
			'https://connect.facebook.net/en_US/fbevents.js');
			fbq('init', '2471989892881253');
			fbq('track', 'PageView');
			</script>
			<!-- End Facebook Pixel Code -->
			<!-- Yandex.Metrika counter -->
			<script type="text/javascript">
			    (function (d, w, c) {
			        (w[c] = w[c] || []).push(function() {
			            try {
			                w.yaCounter50830593 = new Ya.Metrika2({
			                    id:50830593,
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
			        s.src = "https://mc.yandex.ru/metrika/tag.js";

			        if (w.opera == "[object Opera]") {
			            d.addEventListener("DOMContentLoaded", f, false);
			        } else { f(); }
			    })(document, window, "yandex_metrika_callbacks2");
			</script>
			<!-- /Yandex.Metrika counter -->
	</body>
</html>
