<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetPageProperty("description", "Единая база загородной недвижимости. Обзор коттеджных и дачных поселков в Московской области ✔Отзывы покупателей ✔Независимый рейтинг ✔Честный обзор ✔Стоимость коммуникаций ✔Актуальные фото ✔Видео с квадрокоптера ✔Экология местности ✔Юридическая чистота");
$APPLICATION->SetPageProperty("title", "Продажа загородной недвижимости в Московской области | Поселкино");
$APPLICATION->SetTitle("Главная");

// получим кол-во отзывов
	$cntAllOtz=0;
	$arOrder = Array("SORT"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>2,"ACTIVE"=>"Y");
	$arSelect = Array("ID");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
	while($arElement = $rsElements->GetNext()){
		//dump($arElement);
		$cntAllOtz++;
	}

	global $arrFilter;
?>
<section class="section-title-main">
	<div class="container-fluid">
		<h1>Найдите лучший поселок для жизни</h1>
		<h2>Независимый обзор дачных и коттеджных поселков в Московской области</h2>
		<div class="form-main">
				<input type="text" placeholder="Удобный поиск поселков">
			<input type="submit" value="Начать поиск">
		</div>
		<div class="items-count">
			<div class="item">
				<div class="wr-item">
					<div class="number">
						 <?=$cntAllVil?>
					</div>
					<div class="text">
						 проверенных <br>
						 поселков
					</div>
				</div>
			</div>
			<div class="item">
				<div class="wr-item">
					<div class="number">
						 <?=$cntAllOtz?>
					</div>
					<div class="text">
						 отзывов <br>
						 от жителей
					</div>
				</div>
			</div>
			<div class="item">
				<div class="wr-item">
					<div class="number">
						 68
					</div>
					<div class="text">
						 параметров <br>
						 оценки
					</div>
				</div>
			</div>
		</div>
		<div class="wr-filter">
					<div class="close-filter"></div>
					<div class="block-filter">
						<?$APPLICATION->IncludeComponent(
							"bitrix:catalog.smart.filter",
							"poselkino",
							Array(
								"CACHE_GROUPS" => "Y",
								"CACHE_TIME" => "36000000",
								"CACHE_TYPE" => "A",
								"COMPONENT_TEMPLATE" => ".default",
								"CONVERT_CURRENCY" => "N",
								"DISPLAY_ELEMENT_COUNT" => "Y",
								"FILTER_NAME" => "arrFilter",
								"FILTER_VIEW_MODE" => "horizontal",
								"HIDE_NOT_AVAILABLE" => "N",
								"IBLOCK_ID" => "1",
								"IBLOCK_TYPE" => "content",
								"PAGER_PARAMS_NAME" => "arrPager",
								"POPUP_POSITION" => "left",
								"SAVE_IN_SESSION" => "N",
								"SECTION_CODE" => "",
								"SECTION_CODE_PATH" => "",
								"SECTION_DESCRIPTION" => "-",
								"SECTION_ID" => $_REQUEST["SECTION_ID"],
								"SECTION_TITLE" => "-",
								"SEF_MODE" => "Y",
								"SEF_RULE" => "/poselki/filter/#SMART_FILTER_PATH#/apply/#showPoselki",
								"SMART_FILTER_PATH" => $_REQUEST["SMART_FILTER_PATH"],
								"TEMPLATE_THEME" => "green",
								"XML_EXPORT" => "N"
							)
						);?>
					</div>
				 </div><!-- wr-filter -->
	</div>
</section>
<section class="section-links">
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<div class="title-reviews">
				<div class="item houses-swich">
 					<a href="/poselki/filter/doma-is-nodom/apply/" class="active">Только участок</a>
					<a href="/poselki/filter/doma-is-withdom/apply/">Участок с домом</a>
				</div>
			</div>
			<div class="houses-items" id="byFilter">
				<div class="links-item houses-item">
					<div class="item">
						<h4>
						Популярные шоссе </h4>
						<ul>
							<li><a href="/poselki/novoryazanskoe-shosse/kupit-uchastok/">Новорязанское</a></li>
							<li><a href="/poselki/dmitrovskoe-shosse/kupit-uchastok/">Дмитровское</a></li>
							<li><a href="/poselki/simferopolskoe-shosse/kupit-uchastok/">Симферопольское</a></li>
							<li><a href="/poselki/yaroslavskoe-shosse/kupit-uchastok/">Ярославское</a></li>
						</ul>
					</div>
					<div class="item">
						<h4>
						Популярные районы МО </h4>
						<ul>
							<li><a href="/poselki/ramenskiy-rayon/kupit-uchastok/">Раменский</a></li>
							<li><a href="/poselki/chehovskiy-rayon/kupit-uchastok/">Чеховский</a></li>
							<li><a href="/poselki/domodedovskiy-rayon/kupit-uchastok/">Домодедовский</a></li>
							<li><a href="/poselki/sergievo-posadskiy-rayon/kupit-uchastok/">Сергиево-Посадский</a></li>
						</ul>
					</div>
					<div class="item">
						<h4>
						Популярные направления </h4>
						<ul>
							<li> <a href="/poselki/filter/doma-is-nodom/side-is-ugv/apply/">
							Юго-Восточное </a> </li>
							<li> <a href="/poselki/filter/doma-is-nodom/side-is-ug/apply/">
							Южное </a> </li>
						</ul>
					</div>
				</div>
				<div class="links-item houses-item">
					<div class="item">
						<h4>
						Популярные шоссе </h4>
						<ul>
							<li><a href="/poselki/novoryazanskoe-shosse/kupit-dom/">Новорязанское</a></li>
							<li><a href="/poselki/dmitrovskoe-shosse/kupit-dom/">Дмитровское</a></li>
							<li><a href="/poselki/simferopolskoe-shosse/kupit-dom/">Симферопольское</a></li>
							<li><a href="/poselki/yaroslavskoe-shosse/kupit-dom/">Ярославское</a></li>
						</ul>
					</div>
					<div class="item">
						<h4>
						Популярные районы МО </h4>
						<ul>
							<li><a href="/poselki/ramenskiy-rayon/kupit-dom/">Раменский</a></li>
							<li><a href="/poselki/chehovskiy-rayon/kupit-dom/">Чеховский</a></li>
							<li><a href="/poselki/domodedovskiy-rayon/kupit-dom/">Домодедовский</a></li>
							<li><a href="/poselki/sergievo-posadskiy-rayon/kupit-dom/">Сергиево-Посадский</a></li>
						</ul>
					</div>
					<div class="item">
						<h4>
						Популярные направления </h4>
						<ul>
							<li> <a href="/poselki/filter/doma-is-withdom/side-is-ug/apply/">
							Южное </a> </li>
							<li> <a href="/poselki/filter/doma-is-withdom/side-is-ugv/apply/">
							Юго-Восточное </a> </li>
						</ul>
					</div>
				</div>
			</div>
			<div class="test-block">
				<div class="items-test">
					<div class="item">
						<div class="icon"></div>
						<div class="text">
							 Пройдите тест и определите поселок, который подходит вам больше всех
						</div>
					</div>
					<div class="item">
						<div class="link-page">
 							<a href="/test/">Пройти тест</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</section>
<section class="section-main">
<div class="container-fluid">
	<div class="title-page">
		<h3>
			<i class="fs1 raiting" aria-hidden="true" data-icon="&#xe0f2;"></i>
			Поселки с высоким рейтингом
		</h3>
		<a href="/poselki/?sort=rating#showPoselki">Все ТОП поселки</a>
	</div>
	<div class="title-reviews">
		<div class="item houses-swich">
			<a href="#" class="active">Только участок</a>
			<a href="#">Участок с домом</a>
		</div>
	</div>
	<div class="houses-items">
		<div class="houses-item">
			 <?$arrFilter=array('PROPERTY_DOMA'=>[3,256]); // показывать только участки?>
			 <?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					Array(
						"AREA_FILE_SHOW" => "file",
						"AREA_FILE_SUFFIX" => "inc",
						"EDIT_TEMPLATE" => "",
						"PATH" => "/include/section_index.php"
					)
				);?>
				<?unset($arrFilter['PROPERTY_DOMA']);?>
		</div>
		<div class="houses-item">
			 <?$arrFilter=array('PROPERTY_DOMA'=>[4,256]); // показывать участки с домами?>
			 <?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					Array(
						"AREA_FILE_SHOW" => "file",
						"AREA_FILE_SUFFIX" => "inc",
						"EDIT_TEMPLATE" => "",
						"PATH" => "/include/section_index.php"
					)
				);?>
				<?unset($arrFilter['PROPERTY_DOMA']);?>
		</div>
	</div>
	<div class="header-inner hide">
		<div class="items-header">
			<div class="logo">
				<a href="#"> <img class="lazy" src="#" data-original="/local/templates/poselkino/img/logo.png" alt=""> </a>
			</div>
			<div class="title">
				 Собственный дом по цене квартиры!
			</div>
			<div class="sale">
				<i class="icone-sale"></i>
				Летние <br>
				 скидки!
			</div>
		</div>
	</div>
	<div class="bannerIndex">
		<a href="http://findzem.ru/" target="_blank"></a>
		<div class="items">
			<div class="logo">
				<img class="lazy" src="#" data-original="/local/templates/poselkino/img/Logo02_white.svg" alt="#" title="#">
			</div>
			<div class="h1">
				 Подберем земельный участок бесплатно за 1 день
			</div>
			<div class="tagline">
				 Подобрать участок
			</div>
		</div>
	</div>
	<div class="title-page">
		<h2 class="h3"> <i class="fs1 raiting" aria-hidden="true" data-icon=""></i>
		Спецпредложения </h2>
	</div>
	<div class="title-reviews">
		<div class="item houses-swich">
			<a href="#" class="active">Только участок</a>
			<a href="#">Участок с домом</a>
		</div>
	</div>
	<div class="houses-items">
		<div class="houses-item">
			 <?$arrFilter=array('PROPERTY_DOMA'=>[3,256],'!PROPERTY_ACTION'=>false); // показывать только акции?> <?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					Array(
						"AREA_FILE_SHOW" => "file",
						"AREA_FILE_SUFFIX" => "inc",
						"EDIT_TEMPLATE" => "",
						"PATH" => "/include/section_index.php"
					)
				);?>
				<?unset($arrFilter);?>
		</div>
		<div class="houses-item">
			 <?$arrFilter=array('PROPERTY_DOMA'=>[4,256],'!PROPERTY_ACTION'=>false); // показывать только акции?> <?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					Array(
						"AREA_FILE_SHOW" => "file",
						"AREA_FILE_SUFFIX" => "inc",
						"EDIT_TEMPLATE" => "",
						"PATH" => "/include/section_index.php"
					)
				);?>
				<?unset($arrFilter);?>
		</div>
	</div>
	<div class="show-more">
		<a href="/poselki/filter/action-is-y/apply/">Посмотреть все предложения</a>
	</div>
</div>
</section>
<section class="section-links">
	<div class="container-fluid">
		<?$APPLICATION->IncludeComponent(
			 "bitrix:main.include",
			 "",
			 Array(
				 "AREA_FILE_SHOW" => "file",
				 "AREA_FILE_SUFFIX" => "inc",
				 "EDIT_TEMPLATE" => "",
				 "PATH" => "/include/block_url.php"
			 )
		 );?>
	</div>
</section>
<!-- <section class="section-links section-links-two">
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<div class="title-reviews">
				<div class="item houses-swich">
 					<a href="#" class="active">Только участок</a>
					<a href="#">Участок с домом</a>
				</div>
			</div>
			<div class="houses-items">
				<div class="links-item houses-item">
					<div class="item">
						<h4>
						Стоимость участка </h4>
						<ul>
							<li> <a href="/poselki/kupit-uchastok-do-250-tys-rub/">
							100 000 – 250 000 руб </a> </li>
							<li> <a href="/poselki/kupit-uchastok-do-500-tys-rub/">
							250 000 – 500 000 руб </a> </li>
							<li> <a href="/poselki/kupit-uchastok-do-1-mln-rub/">
							500 000 – 1 000 000 руб </a> </li>
							<li> <a href="/poselki/kupit-uchastok-do-5-mln-rub/">
							свыше 1 000 000 руб </a> </li>
						</ul>
					</div>
					<div class="item">
						<h4>
						Площадь участка </h4>
						<ul>
							<li> <a href="/poselki/kupit-uchastok-10-sotok/">
							6 – 10 соток </a> </li>
							<li> <a href="/poselki/kupit-uchastok-15-sotok/">
							10 – 15 соток </a> </li>
							<li> <a href="/poselki/kupit-uchastok-25-sotok/">
							15 – 25 соток </a> </li>
							<li> <a href="/poselki/kupit-uchastok-100-sotok/">
							свыше 25 соток </a> </li>
						</ul>
					</div>
				</div>
				<div class="links-item houses-item">
					<div class="item">
						<h4>
						Удаленность от МКАД </h4>
						<ul>
							<li> <a href="/poselki/do-20-km-ot-mkad/">
							До 20 км </a> </li>
							<li> <a href="/poselki/do-30-km-ot-mkad/">
							До 30 км </a> </li>
							<li> <a href="/poselki/do-40-km-ot-mkad/">
							До 40 км </a> </li>
							<li> <a href="/poselki/do-50-km-ot-mkad/">
							До 50 км </a> </li>
						</ul>
					</div>
					<div class="item">
						<h4>
						Стоимость участка </h4>
						<ul>
							<li> <a href="/poselki/filter/doma-is-nodom/stoimost_uchastka-from-100000-to-250000/apply/">
							100 000 – 250 000 руб </a> </li>
							<li> <a href="/poselki/filter/doma-is-nodom/stoimost_uchastka-from-250000-to-500000/apply/">
							250 000 – 500 000 руб </a> </li>
							<li> <a href="/poselki/filter/doma-is-nodom/stoimost_uchastka-from-500000-to-1000000/apply/">
							500 000 – 1 000 000 руб </a> </li>
							<li> <a href="/poselki/filter/doma-is-nodom/stoimost_uchastka-from-1000000/apply/">
							свыше 1 000 000 руб </a> </li>
						</ul>
					</div>
					<div class="item">
						<h4>
						Площадь участка </h4>
						<ul>
							<li> <a href="/poselki/kupit-dom-na-10-sotkah/">
							6 – 10 соток </a> </li>
							<li> <a href="/poselki/kupit-dom-na-15-sotkah/">
							10 – 15 соток </a> </li>
							<li> <a href="/poselki/kupit-dom-na-25-sotkah/">
							15 – 25 соток </a> </li>
							<li> <a href="/poselki/kupit-dom-na-100-sotkah/">
							свыше 25 соток </a> </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</section> -->
<section class="section-img-map">
<div class="container-fluid">
			<div class="title-page" id="aboutProject">
				<h3> <i class="fs1 parameters" aria-hidden="true" data-icon="f"></i>
				65 параметров оценки каждого поселка </h3>
			</div>
			<div class="img-map">
 			<img class="lazy" src="#" data-original="/local/templates/poselkino/img/img-map.png" alt="">
				<div class="mark color-white" style="top: 34.8%; left: 11.5%;">
					<div class="show-mark">
						 Юридическая <br>
						 проверка
					</div>
					<div class="hide-mark">
						 Мы заказываем документы из гос. органов для каждого поселка
					</div>
				</div>
				<div class="mark" style="top: 8.5%; left: 42.1%;">
					<div class="show-mark">
						 Аэросъемка
					</div>
					<div class="hide-mark">
						 Мы делаем аэросъемку каждого посёлка с помощью профессионального оборудования
					</div>
				</div>
				<div class="mark" style="top: 8.5%; left: 76.2%;">
					<div class="show-mark">
						 Экология
					</div>
					<div class="hide-mark">
						 Мы анализируем экологическую обстановку в местах, где расположены поселки
					</div>
				</div>
				<div class="mark color-white" style="top: 50.5%; left: 53%;">
					<div class="show-mark">
						 Отзывы от <br>
						 жильцов
					</div>
					<div class="hide-mark">
						 Наши специалисты собирают реальные отзывы от жителей при посещении поселков
					</div>
				</div>
				<div class="mark" style="top: 37.5%; left: 78.3%;">
					<div class="show-mark">
						 Коммуникации
					</div>
					<div class="hide-mark">
						 Мы публикуем фактическую информацию о коммуникациях, подведенных в поселки
					</div>
				</div>
				<div class="mark color-white" style="top: 81.7%; left: 84.7%;">
					<div class="show-mark">
						 Реальная <br>
						 стоимость <br>
						 земли
					</div>
					<div class="hide-mark">
						 Мы рассчитываем стоимость участка с учетом всех дополнительных затрат
					</div>
				</div>
			</div>
			<div class="img-map-mobile">
				<div class="item">
					 Юридическая <br>
					 проверка <i class="fs1 parameters" aria-hidden="true" data-icon=""></i>
					<div class="modal-item">
						 Мы заказываем документы из гос. органов для каждого поселка
					</div>
				</div>
				<div class="item">
					 Реальная стоимость <br>
					 земли <i class="fs1 parameters" aria-hidden="true" data-icon=""></i>
					<div class="modal-item">
						 Мы заказываем документы из гос. органов для каждого поселка
					</div>
				</div>
				<div class="item">
					 Коммуникации <i class="fs1 parameters" aria-hidden="true" data-icon=""></i>
					<div class="modal-item">
						 Мы заказываем документы из гос. органов для каждого поселка
					</div>
				</div>
				<div class="item">
					 Экология <i class="fs1 parameters" aria-hidden="true" data-icon=""></i>
					<div class="modal-item">
						 Мы заказываем документы из гос. органов для каждого поселка
					</div>
				</div>
				<div class="item">
					 Аэросъемка <i class="fs1 parameters" aria-hidden="true" data-icon=""></i>
					<div class="modal-item">
						 Мы заказываем документы из гос. органов для каждого поселка
					</div>
				</div>
				<div class="item">
					 Отзывы от <br>
					 жильцов <i class="fs1 parameters" aria-hidden="true" data-icon=""></i>
					<div class="modal-item">
						 Мы заказываем документы из гос. органов для каждого поселка
					</div>
				</div>
			</div>
			<h4>О проекте</h4>
			<p>
				Портал Поселкино.ру - это единая база&nbsp;дачных и коттеджных поселков Московского региона. Мы собрали подробную информацию о каждом поселке, посчитали полную стоимость за участок, сделали аэросъемку, взяли отзывы у жителей, уточнили самые оптимальные маршруты проезда, проверили юридическую чистоту, установили объекты, влияющие на экологию, и разместили все это в понятном и привычном для каждого интерфейсе.
			</p>
			<p>
				Мы независимы от собственников поселков или девелоперских компаний, мы не заинтересованы продать вам конкретный объект недвижимости. Мы стараемся дать максимально объективную оценку и сделать простым и удобным поиск будущего участка. Теперь у пользователя нашего сайта есть возможность найти тот участок, который будет подходить всем требованиям и пожеланиям, с оптимальной и честной стоимостью, прозрачной историей регистрации, необходимыми коммуникациями, инфраструктурой и удобным расположением.
			</p>
</div>
</section>
<section class="section-post">
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<div class="title-page">
				<h3> <i class="posts"></i>
				Статьи, которые будут вам интересны </h3>
			</div>
			<div class="title-reviews has-mobile-swich">
				<div class="item">
 				<a href="/blog/novosti/" class="active">
					Новости </a> <a href="/blog/pro-uchastki/">
					Про участки </a> <a href="/blog/pro-doma/">
					Про дома </a> <a href="/blog/obzor-rynka/">
					Обзор рынка </a>
				</div>
			</div>
			 <?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"blog_index",
	Array(
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
		"FIELD_CODE" => array(0=>"",1=>"",),
		"FILE_404" => "",
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "100",
		"PROPERTY_CODE" => array(0=>"",1=>"",),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "N",
		"SHOW_404" => "Y",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N"
	)
);?>
			<div class="show-more">
 <a href="/blog/">
				Все новости и статьи </a>
			</div>
		</div>
	</div>
</div>
</section>
<section class="section-carusel">
	<div class="container-fluid">
			<h3>Девелоперы</h3>
			<?$APPLICATION->IncludeComponent(
				"bitrix:highloadblock.list",
				"devolopers",
				Array(
					"BLOCK_ID" => "5",
					"CHECK_PERMISSIONS" => "N",
					"DETAIL_URL" => "",
					"FILTER_NAME" => "",
					"PAGEN_ID" => "page",
					"ROWS_PER_PAGE" => "",
					"SORT_FIELD" => "ID",
					"SORT_ORDER" => "DESC"
				)
			);?>
	</div>
</section>
<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');?>
