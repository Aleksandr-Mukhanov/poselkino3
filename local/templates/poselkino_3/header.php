<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)die();
use Bitrix\Main\Page\Asset,
	Bitrix\Main\Loader;
Loader::includeModule("iblock");
// Loader::includeModule("sale"); // убрать после

Asset::getInstance()->addCss("/assets/css/vendor.min.css");
Asset::getInstance()->addCss("/assets/css/style.min.css");
Asset::getInstance()->addJs("/assets/js/vendor.min.js");
Asset::getInstance()->addJs("/assets/js/app.js");
Asset::getInstance()->addJs("/assets/js/jquery.cookie.js");
Asset::getInstance()->addJs("/assets/js/scripts.js");
// CJSCore::Init(array('ajax'));

// получим кол-во поселков
$cntDacha=0; $cntCottage=0;$cntAllVil=0;
$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>1,"ACTIVE"=>"Y");
$arSelect = Array("ID","PROPERTY_TYPE");
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while($arElement = $rsElements->GetNext()){ // dump($arElement);
	if($arElement["PROPERTY_TYPE_ENUM_ID"] == 1)$cntDacha++;
	if($arElement["PROPERTY_TYPE_ENUM_ID"] == 2)$cntCottage++;
	$cntAllVil++;
}

// кнопочка обновления рейтинга
$APPLICATION->AddPanelButton(
	Array(
		"ID" => "updateRating", //определяет уникальность кнопки
		"TEXT" => "Обновить рейтинг",
		"MAIN_SORT" => 300, //индекс сортировки для групп кнопок
		"SORT" => 300, //сортировка внутри группы
		"HREF" => "https://poselkino.ru/cron/rating.php", //или javascript:MyJSFunction())
		"SRC" => "https://poselkino.ru/local/templates/poselkino/img/svg/star-raiting.svg"
		),
	$bReplace = false //заменить существующую кнопку?
);

// canonical
$canonical = 'https://poselkino.ru'.$APPLICATION->GetCurDir();
$ourPage = $APPLICATION->GetCurPage(false);
if (strpos($ourPage, '/filter/') !== false) $canonical = 'https://poselkino.ru/poselki/';
if ($_REQUEST['PAGEN_1']) $canonical .= '?PAGEN_1='.$_REQUEST['PAGEN_1'];
$APPLICATION->SetPageProperty('canonical', $canonical);

// dump($_COOKIE); // разбираем куки
if(isset($_COOKIE['comparison_vil'])){
	$arComparison = explode('-',$_COOKIE['comparison_vil']);
}
if(isset($_COOKIE['favorites_vil'])){
	$arFavorites = explode('-',$_COOKIE['favorites_vil']);
}
?>
<!DOCTYPE html>
<html lang="<?=LANGUAGE_ID?>">
<head>
	<title><?$APPLICATION->ShowTitle();?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1">
	<link rel="shortcut icon" href="/assets/img/favicon/favicon.png" type="image/png">
	<meta name="yandex-verification" content="7dc43856ec298fed" />
	<meta name="yandex-verification" content="7dc43856ec298fed" />
	<?$APPLICATION->ShowHead();?>
</head>
<body>
	<div id="panel"><?$APPLICATION->ShowPanel();?></div>
	<header class="header bg-white">
		<div class="container">
			<nav class="navbar p-0 row">
				<div class="order-0 col-lg-1 col-md-4 col-sm-4 col-2 pr-md-0">
					<div class="d-flex align-items-center">
						<button class="navbar-toggler" type="button" data-target="#navbarHeader" data-expanded="false" aria-label="Переключатель навигации"><span class="navbar-toggler-ic"><span></span><span></span><span></span></span><span class="navbar-toggler-title d-none d-md-block">Меню</span></button>
					</div>
				</div>
				<div class="header__logo order-1 order-xl-2 col-xl-2 col-lg-2 col-md-4 col-sm-4 col-4 pl-lg-0 text-sm-center"><a href="/"><img src="/assets/img/site/logo.png" alt="Посёлкино"></a></div>
				<div class="order-2 order-xl-1 col-xl-4 col-lg-6 pr-0 d-none d-lg-block">
					<ul class="nav navbar-top">
						<li class="nav-item"><a class="nav-link" href="/poselki/">Все&nbsp;<span class="text-secondary"><?=$cntAllVil?></span></a></li>
						<li class="nav-item"><a class="nav-link" href="/poselki/kottedzhnye/">Коттеджные&nbsp;<span class="text-secondary"><?=$cntCottage?></span></a></li>
						<li class="nav-item"><a class="nav-link" href="/poselki/dachnye/">Дачные&nbsp;<span class="text-secondary"><?=$cntDacha?></span></a></li>
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
							<?// if($arComparison){?>
								<span class="badge badge-warning text-white heart__number" id="compHeader"><?=count($arComparison)?></span>
							<?// }?>
							<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" class="inline-svg">
							<g transform="translate(-1216.699 -36.35)">
								<path d="M0 0v16.139" class="comparison" transform="translate(1217.349 37)" />
								<path d="M0 0v16.139" class="comparison" transform="translate(1233.321 37)" />
								<path d="M0 0v13.215" class="comparison" transform="translate(1222.807 40.041)" />
								<path d="M0 0v7.641" class="comparison" transform="translate(1228.265 45.499)" />
							</g>
						</svg></a></li>
						<li class="nav-item heart"><a class="nav-link heart__link" href="/izbrannoe/" title="Избранное">
							<?// if($arFavorites){?>
								<span class="badge badge-warning text-white heart__number" id="favHeader"><?=count($arFavorites)?></span>
							<?// }?>
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
			<ul class="nav">
				<li class="nav-item"><a class="nav-link" href="/poselki/kottedzhnye/">Коттеджные поселки <?=$cntCottage?></a></li>
				<li class="nav-item"><a class="nav-link" href="/poselki/dachnye/">Дачные поселки <?=$cntDacha?></a></li>
				<li class="nav-item"><a class="nav-link" href="/o-proekte/">О проекте</a></li>
				<li class="nav-item"><a class="nav-link" href="/blog/">Блог</a></li>
				<li class="nav-item"><a class="nav-link" href="/reklama/">Реклама и сотрудничество</a></li>
				<li class="nav-item"><a class="nav-link" href="/kontakty/">Контакты</a></li>
				<li class="nav-item mt-auto mail">
					<div class="nav-item-label">E-mail:&nbsp;</div><a href="mailto:welcome@poselkino.ru">welcome@poselkino.ru</a>
				</li>
			</ul>
		</div>
	</header>
