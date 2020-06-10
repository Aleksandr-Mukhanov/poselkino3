<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)die();
use Bitrix\Main\Page\Asset,
	Bitrix\Main\Context,
	Bitrix\Main\Loader;
Loader::includeModule("iblock");
Loader::includeModule("sale");

// делаем title при пагинации
// $context = Context::getCurrent();
// $arRequest = $context->getRequest()->toArray();
// $pagenavTitle = array_key_exists('PAGEN_1', $arRequest) ? ' - страница '.$arRequest['PAGEN_1'] : '';
// if(array_key_exists('PAGEN_1', $arRequest)){
// 	$description = $APPLICATION->GetProperty("description");
// 	$GLOBALS['APPLICATION']->SetPageProperty('description', $description . ' - cтраница ' . intval($arRequest['PAGEN_1']));
// }

// получим кол-во поселков
$cntDacha=0; $cntCottage=0;$cntAllVil=0;
$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>1,"ACTIVE"=>"Y");
$arSelect = Array("ID","PROPERTY_TYPE");
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while($arElement = $rsElements->GetNext()){
	//dump($arElement);
	if($arElement["PROPERTY_TYPE_ENUM_ID"] == 1)$cntDacha++;
	if($arElement["PROPERTY_TYPE_ENUM_ID"] == 2)$cntCottage++;
	$cntAllVil++;
}

// получим кол-во в избранном
$dbBasketItems = CSaleBasket::GetList(
	array(
		"NAME" => "ASC",
		"ID" => "ASC"
	),
	array(
		"FUSER_ID" => CSaleBasket::GetBasketUserID(),
		"LID" => SITE_ID,
		"ORDER_ID" => "NULL",
		"DELAY" => "Y",
	),
	false,
	false,
	array("ID", "PRODUCT_ID")
);

while ($arItems = $dbBasketItems->Fetch()) { //dump($arItems);
	$arBasketItems[$arItems["ID"]] = $arItems["PRODUCT_ID"];
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

$canonical = ($_REQUEST['PAGEN_1']) ? '?PAGEN_1='.$_REQUEST['PAGEN_1'] : '';
?>
<!DOCTYPE html>
<html lang="<?=LANGUAGE_ID?>">
	<head>
		<title><?$APPLICATION->ShowTitle();?><?//=$pagenavTitle?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="canonical" href="<?='https://poselkino.ru'.$APPLICATION->GetCurDir()?><?=$canonical?>" />
		<link rel="shortcut icon" href="/favicon.png" type="image/png" />
		<meta name="yandex-verification" content="7dc43856ec298fed" />
		<meta name="yandex-verification" content="7dc43856ec298fed" />
		<?$APPLICATION->ShowHead();?>
		<?
		// Asset::getInstance()->addJs("https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js");
		Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/jquery/jquery-2.1.4.min.js");
		Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/style.css");
		CJSCore::Init(array('ajax'));
		?>
	</head>
	<body>
	  <div class="wrapper">
		<div id="panel"><?$APPLICATION->ShowPanel();?></div>
		<nav>
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="items-nav">
							<div class="item">
								<div class="logo">
									<a href="/">
										<img src="<?=SITE_TEMPLATE_PATH?>/img/logo-nav.png" alt="Посёлкино" title="Посёлкино">
									</a>
								</div>
								<div class="list-count">
									<div class="list">
										Поселки:
									</div>
									<div class="list">
										<a href="/poselki/">Все <mark><?=$cntAllVil?></mark></a>
									</div>
									<div class="list">
										<a href="/poselki/kottedzhnye/">Коттеджные <mark><?=$cntCottage?></mark></a>
									</div>
									<div class="list">
										<a href="/poselki/dachnye/">Дачные <mark><?=$cntDacha?></mark></a>
									</div>
								</div>
							</div>
							<div class="item">
								<div class="block-nav">
									<?$APPLICATION->IncludeComponent(
										"bitrix:catalog.compare.list",
										"compareHead",
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
									<div class="favorit white">
										<a href="/izbrannoe/" <?//if(count($arBasketItems)>0)echo 'class="active"';?> id="fav_A">
											<i class="like"></i>
											<mark id="izbDesc"><?=count($arBasketItems)?></mark>
										</a>
									</div>
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
									<div class="click-nav">
										<div></div>
										<div></div>
										<div></div>
									</div>
								</div>
							</div>
						</div>
						<div class="drob-nav">
							<ul class="links">
								<li>
									<a href="/o-proekte/">
										О проекте
									</a>
								</li>
								<li>
									<a href="/blog/">
										Блог
									</a>
								</li>
								<li>
									<a href="/reklama/">
										Реклама и сотрудничество
									</a>
								</li>
								<li>
									<a href="/kontakty/">
										 Контакты
									</a>
								</li>
							</ul>
							<div class="count-item">
								<div class="item">
									<a href="/poselki/kottedzhnye/">
										Коттеджные поселки <mark><?=$cntCottage?></mark>
									</a>
								</div>
								<div class="item">
									<a href="/poselki/dachnye/">
										Дачные поселки <mark><?=$cntDacha?></mark>
									</a>
								</div>
								<div class="item">
									<div class="email">
										E-mail: <a href="mailto:welcome@poselkino.ru">welcome@poselkino.ru</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</nav>
		<?if($APPLICATION->GetCurPage(false) !== '/'):?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:breadcrumb",
				"poselkino",
				array(
					"PATH" => "",
					"SITE_ID" => "s1",
					"START_FROM" => "0",
					"COMPONENT_TEMPLATE" => "poselkino"
				),
				false
			);?>
		<?endif;?>
