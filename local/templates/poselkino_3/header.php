<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)die();
use Bitrix\Main\Page\Asset,
	Bitrix\Main\Loader;
Loader::includeModule("iblock");

Asset::getInstance()->addCss("/assets/css/fancybox.css");
Asset::getInstance()->addCss("/assets/css/vendor.min.css");
Asset::getInstance()->addCss("/assets/css/style.min.css");

Asset::getInstance()->addJs("/assets/js/fancybox.umd.js");
Asset::getInstance()->addJs("/assets/js/vendor.min.js");
Asset::getInstance()->addJs("/assets/js/app.js");
Asset::getInstance()->addJs("/assets/js/jquery.cookie.js");
Asset::getInstance()->addJs("/assets/js/scripts.js");

// получим кол-во поселков
$cntAllVil=0;
$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>IBLOCK_ID,"ACTIVE"=>"Y");
$arFilter['!PROPERTY_SALES_PHASE'] = [PROP_SOLD_ID]; // уберем проданные
$arFilter['!PROPERTY_HIDE_POS'] = PROP_HIDE_ID; // метка убрать из каталога
$arFilter['PROPERTY_OBLAST'] = PROP_OBLAST; // метка области

$arSelect = Array("ID");
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while($arElement = $rsElements->Fetch())
	$cntAllVil++;

// получим кол-во участков
$cntAllPlots = 0;
$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>5,"ACTIVE"=>"Y");
if (!in_array($_SERVER['HTTP_HOST'],SITES_DIR)) $arFilter['!PROPERTY_AREA'] = 552; // исключим СПБ
$arSelect = Array("ID");
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while($arElement = $rsElements->Fetch())
	$cntAllPlots++;

// получим кол-во домов
$cntAllHouse = 0;
$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>6,"ACTIVE"=>"Y");
$arSelect = Array("ID");
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while($arElement = $rsElements->Fetch())
	$cntAllHouse++;

// кнопочка обновления рейтинга
$APPLICATION->AddPanelButton(
	Array(
		"ID" => "updateRating", //определяет уникальность кнопки
		"TEXT" => "Обновить рейтинг",
		"MAIN_SORT" => 300, //индекс сортировки для групп кнопок
		"SORT" => 300, //сортировка внутри группы
		"HREF" => "https://poselkino.ru/cron/rating.php", //или javascript:MyJSFunction())
		"SRC" => "https://poselkino.ru/local/templates/poselkino_old/img/svg/star-raiting.svg"
		),
	$bReplace = false //заменить существующую кнопку?
);

// canonical
$canonical = 'https://'.$_SERVER['HTTP_HOST'].$APPLICATION->GetCurDir();
$ourPage = $APPLICATION->GetCurPage(false);
if (strpos($ourPage, '/filter/') !== false) $canonical = 'https://'.$_SERVER['HTTP_HOST'].'/poselki/';
if ($ourPage == '/poselki/kupit-uchastok/') $canonical = 'https://'.$_SERVER['HTTP_HOST'].'/kupit-uchastki/';
if ($ourPage == '/doma/' || $ourPage == '/poselki/kupit-dom/') $canonical = 'https://'.$_SERVER['HTTP_HOST'].'/kupit-dom/';
if ($_REQUEST['PAGEN_1'] && !$_REQUEST['teg']) $canonical .= '?PAGEN_1='.$_REQUEST['PAGEN_1'];
$APPLICATION->SetPageProperty('canonical', $canonical);

if ($_REQUEST['teg']) $APPLICATION->SetPageProperty('robots', 'noindex, follow');

$sumComparison = 0; $sumFavorites=0;
// dump($_COOKIE); // разбираем куки
if(isset($_COOKIE['comparison_vil'])){
	$arComparison = explode('-',$_COOKIE['comparison_vil']);
	$sumComparison += count($arComparison);
}

if(isset($_COOKIE['favorites_vil'])){
	$arFavorites = explode('-',$_COOKIE['favorites_vil']);
	$sumFavorites += count($arFavorites);
}

if(isset($_COOKIE['comparison_plots'])){
	$arComparisonPlots = explode('-',$_COOKIE['comparison_plots']);
	$sumComparison += count($arComparisonPlots);
}

if(isset($_COOKIE['favorites_plots'])){
	$arFavoritesPlots = explode('-',$_COOKIE['favorites_plots']);
	$sumFavorites += count($arFavoritesPlots);
}

if(isset($_COOKIE['comparison_houses'])){
	$arComparisonHouses = explode('-',$_COOKIE['comparison_houses']);
	$sumComparison += count($arComparisonHouses);
}

if(isset($_COOKIE['favorites_houses'])){
	$arFavoritesHouses = explode('-',$_COOKIE['favorites_houses']);
	$sumFavorites += count($arFavoritesHouses);
}
?>
<!DOCTYPE html>
<html lang="<?=LANGUAGE_ID?>">
<head>
	<title><?$APPLICATION->ShowTitle();?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1">
	<link rel="shortcut icon" href="/favicon.svg" type="image/svg+xml">
	<link rel="shortcut icon" href="/favicon.png" type="image/png">
	<link rel="apple-touch-icon" href="/favicon.png"/>
	<meta name="yandex-verification" content="7dc43856ec298fed" />
	<meta name="facebook-domain-verification" content="t9usvm7ssxhfyexr5yotrpgupfwvi9" />
	<?$APPLICATION->ShowHead();?>
</head>
<body>
	<div id="panel"><?$APPLICATION->ShowPanel();?></div>
	<?if(!CSite::InDir('/test/')):?>
	<header class="header bg-white">
		<div class="container">
			<nav class="navbar p-0 row">
				<div class="order-0 col-lg-1 col-md-4 col-sm-4 col-2 pr-md-0">
					<div class="d-flex align-items-center">
						<button class="navbar-toggler" type="button" data-target="#navbarHeader" data-expanded="false" aria-label="Переключатель навигации"><span class="navbar-toggler-ic"><span></span><span></span><span></span></span><span class="navbar-toggler-title d-none d-md-block">Меню</span></button>
					</div>
				</div>
				<div class="header__logo order-1 order-xl-2 col-xl-2 col-lg-2 col-md-4 col-sm-4 col-4 pl-lg-0 text-sm-center"><a href="/"><img src="/assets/img/logo_site.svg" alt="Посёлкино" width="160" height="25"></a></div>
				<div class="order-2 order-xl-1 col-xl-4 col-lg-6 pr-0 d-none d-lg-block">
					<ul class="nav navbar-top" itemscope itemtype="http://www.schema.org/SiteNavigationElement">
						<li class="nav-item" itemprop="name"><a class="nav-link" itemprop="url" href="/poselki/">Все поселки <span class="text-secondary"><?=$cntAllVil?></span></a></li>
						<li class="nav-item" itemprop="name"><a class="nav-link" itemprop="url" href="/poselki/map/">На карте</a></li>
						<?if(SHOW_PLOTS == 'Y'):?>
							<li class="nav-item"><a class="nav-link" href="/kupit-uchastki/">Участки <span class="text-secondary"><?=$cntAllPlots?></span></a></li>
						<?endif;?>
						<!-- <li class="nav-item"><a class="nav-link" href="/doma/">Дома&nbsp;<span class="text-secondary"><?=$cntAllHouse?></span></a></li> -->
					</ul>
				</div>
				<div class="order-3 col-xl-5 col-lg-3 col-sm-4 col-6 text-right">
					<ul class="header__nav-icons nav ml-auto justify-content-end w-100">
						<li class="nav-item">
							<?$APPLICATION->IncludeComponent(
								"bitrix:search.form",
								"poselkino",
								array(
									"PAGE" => "#SITE_DIR#poisk/",
									"USE_SUGGEST" => "Y",
									"COMPONENT_TEMPLATE" => "poselkino"
								),
								false
							);?>
						</li>
						<li class="nav-item"><a class="nav-link" href="/sravnenie/" title="Сравнение">
							<span class="badge badge-warning text-white heart__number" id="compHeader"><?=$sumComparison?></span>
							<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" class="inline-svg">
							<g transform="translate(-1216.699 -36.35)">
								<path d="M0 0v16.139" class="comparison" transform="translate(1217.349 37)" />
								<path d="M0 0v16.139" class="comparison" transform="translate(1233.321 37)" />
								<path d="M0 0v13.215" class="comparison" transform="translate(1222.807 40.041)" />
								<path d="M0 0v7.641" class="comparison" transform="translate(1228.265 45.499)" />
							</g>
						</svg></a></li>
						<li class="nav-item heart"><a class="nav-link heart__link" href="/izbrannoe/" title="Избранное">
							<span class="badge badge-warning text-white heart__number" id="favHeader"><?=$sumFavorites?></span>
							<svg xmlns="http://www.w3.org/2000/svg" width="21.72" height="19.107" viewBox="0 0 21.72 19.107" class="inline-svg">
							<g transform="translate(.05 -28.451)">
								<path d="M19.874 30.266a5.986 5.986 0 0 0-8.466 0l-.591.591-.6-.6a5.981 5.981 0 0 0-8.466-.009 5.981 5.981 0 0 0 .009 8.466l8.608 8.608a.614.614 0 0 0 .871 0l8.626-8.594a6 6 0 0 0 .009-8.47zm-.88 7.595L10.8 46.019l-8.169-8.172a4.745 4.745 0 1 1 6.71-6.71l1.036 1.036a.617.617 0 0 0 .875 0l1.027-1.027a4.748 4.748 0 0 1 6.715 6.715z" class="heart" />
							</g>
						</svg></a></li>
					</ul>
				</div>
			</nav>
		</div>
		<div class="header__navbar collapse navbar-collapse" id="navbarHeader">
			<button class="navbar-toggler w-100" type="button" data-target="#navbarHeader" data-expanded="false" aria-label="Переключатель навигации"><span class="navbar-toggler-ic"><span></span><span></span><span></span></span><span class="navbar-toggler-title">Меню</span></button>
			<ul class="nav" itemscope itemtype="http://www.schema.org/SiteNavigationElement">
				<li class="nav-item" itemprop="name"><a class="nav-link" itemprop="url" href="/poselki/">Все поселки <?=$cntAllVil?></a></li>
				<li class="nav-item" itemprop="name"><a class="nav-link" itemprop="url" href="/poselki/map/">Поселки на карте</a></li>
				<?if(SHOW_PLOTS == 'Y'):?>
					<li class="nav-item"><a class="nav-link" href="/kupit-uchastki/">Участки <?=$cntAllPlots?></a></li>
				<?endif;?>
				<?if(SHOW_HOUSES == 'Y'):?>
					<li class="nav-item"><a class="nav-link" href="/kupit-dom/">Дома <?=$cntAllHouse?></a></li>
				<?endif;?>
				<?if($_SERVER['HTTP_HOST']=='poselkino.ru'):?>
					<li class="nav-item" itemprop="name"><a class="nav-link" itemprop="url" href="/poselki/promyshlennye/">Промышленные поселки</a></li>
				<?endif;?>
				<li class="nav-item" itemprop="name"><a class="nav-link" itemprop="url" href="https://poselkino.ru/stroitelyam/">Застройщикам</a></li>
				<li class="nav-item" itemprop="name"><a class="nav-link" itemprop="url" href="https://poselkino.ru/investoram/">Инвесторам</a></li>
				<li class="nav-item" itemprop="name"><a class="nav-link" itemprop="url" href="https://poselkino.ru/o-proekte/">О проекте</a></li>
				<li class="nav-item" itemprop="name"><a class="nav-link" itemprop="url" href="https://poselkino.ru/vakansii/">Вакансии</a></li>
				<li class="nav-item" itemprop="name"><a class="nav-link" itemprop="url" href="https://poselkino.ru/blog/">Блог</a></li>
				<li class="nav-item" itemprop="name"><a class="nav-link" itemprop="url" href="https://poselkino.ru/reklama/">Реклама и сотрудничество</a></li>
				<li class="nav-item" itemprop="name"><a class="nav-link" itemprop="url" href="https://poselkino.ru/kontakty/">Контакты</a></li>
				<li class="nav-item mt-auto mail">
					<div class="nav-item-label">E-mail:&nbsp;</div><a href="mailto:welcome@poselkino.ru">welcome@poselkino.ru</a>
				</li>
			</ul>
		</div>
	</header>
	<div class="bg-white pb-2">
		<div class="telegram">
			<div class="telegram__container">
				<div class="telegram__wrap">
					<a href="https://t.me/poselkino_news" class="telegram_button" target="_blank">
						<svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M0.884691 6.6054L17.7346 0.0798657C18.5167 -0.203917 19.1997 0.271492 18.9463 1.45928L18.9477 1.45782L16.0787 15.034C15.8661 15.9965 15.2967 16.2306 14.5001 15.7771L10.131 12.5429L8.02369 14.582C7.79068 14.8161 7.59407 15.0135 7.1426 15.0135L7.45281 10.5476L15.5501 3.20001C15.9025 2.88843 15.4714 2.7129 15.0069 3.02301L5.00032 9.35106L0.686628 7.99944C-0.249802 7.70103 -0.270191 7.05886 0.884691 6.6054Z" fill="white"/>
						</svg>
						Подпишись&nbsp;на&nbsp;канал
					</a>
					<div class="telegram__text hide__mob">
						Подпишитесь на Телеграм канал Поселкино.ру и следите за скидками и горячими предложениями
					</div>
					<img src="/assets/img/tg-bg.svg" alt="tg">
				</div>
			</div>
		</div>
	</div>
	<?endif;?>
