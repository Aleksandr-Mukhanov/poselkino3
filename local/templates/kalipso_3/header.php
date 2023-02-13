<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)die();
use Bitrix\Main\Page\Asset,
  Bitrix\Main\Loader;
  Loader::includeModule("iblock");

  Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/style/swiper.min.css');
  Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/style/bootstrap.min.css');
  Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/style/bootstrap-select.css');
  Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/style/jquery.fancybox.min.css');
  Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/style/app.css');
  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/jquery-3.2.1.min.js');
  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/swiper.min.js');
  Asset::getInstance()->addJs('https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=1c914fae-c0ca-40d5-9641-9cbd355e4f55');
  Asset::getInstance()->addJs('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js');
  Asset::getInstance()->addJs('https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js');
  Asset::getInstance()->addJs('https://yastatic.net/share2/share.js');
  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/bootstrap.min.js');
  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/bootstrap-select.min.js');
  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/jquery.mask.min.js');
  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/jquery.fancybox.min.js');
  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/main.js');
  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/scripts.js');

  // получим наш поселок
  switch (SITE_SERVER_NAME) {
    case 'orlinye-holmy.ru': $villageID = 3058; $yandex_verification=''; break;
    case 'socolinaya-gora.ru': $villageID = 6; $yandex_verification=''; break;
    case 'svyataja-gora.ru': $villageID = 9; $yandex_verification=''; break;
    case 'swiss-dolina.ru': $villageID = 3046; $yandex_verification=''; break;
    case 'uzhnye-ozera.ru': $villageID = 3050; $yandex_verification=''; break;
    case 'fisher-poselok.ru': $villageID = 3215; $yandex_verification=''; break;
    case 'zem-polyana.ru': $villageID = 3211; $yandex_verification=''; break;
    case 'regata-kp.ru': $villageID = 3221; $yandex_verification=''; break;
    case 'sosnovyi-bor.ru': $villageID = 16; $yandex_verification=''; break;
    case 'elizarovo-kp.ru': $villageID = 1879; $yandex_verification=''; break;
    case 'поселок-грильяж.рф': $villageID = 3142; $yandex_verification=''; break;
    case 'stepigino.ru': $villageID = 3213; $yandex_verification=''; break;
    case 'dolyna-ozer.ru': $villageID = 19; $yandex_verification=''; break;
    case 'velikie-ozera.ru': $villageID = 18; $yandex_verification=''; break;
    case 'rusavkino-zarechnoe.ru': $villageID = 3204; $yandex_verification=''; break;
    case 'usadba-v-lesu.ru': $villageID = 1849; $yandex_verification=''; break;
    case 'homytovo.ru': $villageID = 3255; $yandex_verification=''; break;
    case 'novaya-volodarka.ru': $villageID = 3272; $yandex_verification=''; break;
    case 'red-poselok.ru': $villageID = 3269; $yandex_verification=''; break;
    case 'ilinskoe-kp.ru': $villageID = 3277; $yandex_verification=''; break;
    case 'favorit-kp.ru': $villageID = 3284; $yandex_verification=''; break;
    case 'kp-vihrovo.ru': $villageID = 1324; $yandex_verification=''; break;
    // case '': $villageID = ; $yandex_verification=''; break;
  }

  $arOrder = Array('SORT'=>'ASC');
  $arFilter = Array('IBLOCK_ID'=>1,'ID'=>$villageID);
  $arSelect = Array('ID','NAME','CODE','PREVIEW_PICTURE','PREVIEW_TEXT','PROPERTY_PLAN_IMG','PROPERTY_PLAN_IMG_2','PROPERTY_AREA_VIL','PROPERTY_COUNT_PLOTS','PROPERTY_COUNT_PLOTS_SOLD','PROPERTY_COUNT_PLOTS_SALE','PROPERTY_PLOTTAGE','PROPERTY_COST_LAND_IN_CART','PROPERTY_PRICE_ARRANGE','PROPERTY_INS_TERMS','PROPERTY_ELECTRO_KVT','PROPERTY_GAS','PROPERTY_PROVEDEN_GAZ','PROPERTY_ART_WELLS_DEPTH','PROPERTY_FOREST_KM','PROPERTY_WATER_KM','PROPERTY_MKAD','PROPERTY_SETTLEM','PROPERTY_SETTLEM_KM','PROPERTY_TOWN','PROPERTY_TOWN_KM','PROPERTY_RAILWAY','PROPERTY_RAILWAY_KM','PROPERTY_COORDINATES','PROPERTY_AUTO_NO_JAMS','PROPERTY_TRAIN_ID_YANDEX','PROPERTY_TRAIN_TRAVEL_TIME','PROPERTY_TRAIN_VOKZAL','PROPERTY_TRAIN_PRICE','PROPERTY_TRAIN_PRICE_TAXI','PROPERTY_BUS_VOKZAL','PROPERTY_BUS_TIME_KM','PROPERTY_PRICE_SOTKA','PROPERTY_PRICE_SOTKA_2','PROPERTY_RATING','PROPERTY_LAND_CAT','PROPERTY_TYPE_USE','PROPERTY_LEGAL_FORM','PROPERTY_SRC_MAP','PROPERTY_SCRIN_EGRN','PROPERTY_DOP_FOTO','PROPERTY_UP_TO_VIEW','PROPERTY_DEVELOPER_ID','PROPERTY_SHOSSE','PROPERTY_REGION','PROPERTY_ROADS_IN_VIL','PROPERTY_ROADS_TO_VIL','PROPERTY_TYPE','PROPERTY_LES','PROPERTY_WATER','PROPERTY_LANDSCAPE','PROPERTY_SOIL','PROPERTY_LEND_TEXT','PROPERTY_PLAN_IMG_IFRAME','PROPERTY_PLAN_IMG_IFRAME_2','PROPERTY_ON_SITE','PROPERTY_ARRANGE','PROPERTY_PHONE','PROPERTY_MANAGER','PROPERTY_LINK_ELEMENTS');
  $rsElements = \CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
  $arVillage = $rsElements->GetNext(); // dump($arVillage);
  $shosseName = array_values($arVillage["PROPERTY_SHOSSE_VALUE"])[0];
  $shosseNameKom = str_replace('кое','ком',array_values($arVillage["PROPERTY_SHOSSE_VALUE"])[0]);
  $shosseNameKomu = str_replace('кое','кому',array_values($arVillage["PROPERTY_SHOSSE_VALUE"])[0]);
  $regionName = $arVillage["PROPERTY_REGION_VALUE"];
  $roadsInName = getRoadName($arVillage["PROPERTY_ROADS_IN_VIL_VALUE"]);
  $roadsToName = getRoadName($arVillage["PROPERTY_ROADS_TO_VIL_VALUE"]);
  $typeVillage = $arVillage['PROPERTY_TYPE_VALUE'];

  $LES = $arVillage['PROPERTY_LES_VALUE']; // Лес
  $FOREST_KM = $arVillage['PROPERTY_FOREST_KM_VALUE']; // Лес расстояние, км
  if (mb_strtolower($LES) == 'нет') $LES = 'Рядом нет';

  // выводим водоемы
  $arWater = $arVillage['PROPERTY_WATER_VALUE']; // Водоем
  if (!$arWater) $arWater = 'Рядом нет';

  // выводим почву
  $arSoil = $arVillage['PROPERTY_SOIL_VALUE']; // Почва
  if (!$arSoil) $arSoil = 'Информации нет';

  $landscape = $arVillage['PROPERTY_LANDSCAPE_VALUE']; // Ландшафт
  if (!$landscape) $landscape = 'Информации нет';

  // получим девелопера
  $arDevel = array_values(getElHL(5,[],['UF_XML_ID'=>$arVillage['PROPERTY_DEVELOPER_ID_VALUE'][0]],['ID','UF_NAME','UF_XML_ID','UF_ADDRESS','UF_PHONE','UF_SCHEDULE'])); // dump($arDevel);
  $phone = ($arVillage["PROPERTY_PHONE_VALUE"]) ? $arVillage["PROPERTY_PHONE_VALUE"] : $arDevel[0]['UF_PHONE'];

  $priceSotka = ($arVillage['PROPERTY_PRICE_SOTKA_2_VALUE']) ? $arVillage['PROPERTY_PRICE_SOTKA_2_VALUE'] : $arVillage['PROPERTY_PRICE_SOTKA_VALUE'][0];

  $mainUrl = '/var/www/u0428181/data/www/olne.ru';
  // капча
  // include_once($mainUrl."/bitrix/modules/main/classes/general/captcha.php");
  // $cpt = new CCaptcha();
  // $captchaPass = COption::GetOptionString("main", "captcha_password", "");
  // if(strlen($captchaPass) <= 0)
  // {
  //   $captchaPass = randString(10);
  //   COption::SetOptionString("main", "captcha_password", $captchaPass);
  // }
  // $cpt->SetCodeCrypt($captchaPass);

  include_once ($mainUrl.'/include/sites/phone.php');
?>
<!DOCTYPE html>
<html lang="<?=LANGUAGE_ID?>" prefix="og: http://ogp.me/ns#">
  <head>
    <title><?$APPLICATION->ShowTitle();?></title>
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=no, user-scalable=0"/>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <meta property="og:title" content="<?=$APPLICATION->ShowProperty("title");?>"/>
    <meta property="og:description" content="<?=$APPLICATION->ShowProperty("description");?>"/>
    <meta property="og:image" content="<?='https://'.SITE_SERVER_NAME.SITE_TEMPLATE_PATH?>/images/logo.svg"/>
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="<?=$arVillage['NAME']?>" />
    <meta property="og:url" content= "<?='https://'.SITE_SERVER_NAME.$APPLICATION->GetCurDir();?>" />
    <meta name="yandex-verification" content="<?=$yandex_verification?>" />
    <?$APPLICATION->ShowHead();?>
  </head>
  <body>
    <div id="panel"><?$APPLICATION->ShowPanel();?></div>
<?if (CSite::InDir('/index.php')) { // если на главной
      // $prevSrc = CFile::GetPath($arVillage['PREVIEW_PICTURE']);
      $prevSrc = CFile::ResizeImageGet($arVillage['PREVIEW_PICTURE'], array('width'=>1920, 'height'=>870), BX_RESIZE_IMAGE_PROPORTIONAL_ALT); // dump($prevSrc);
      ?>
    <div class="block_1" style="background-image: url(<?=$prevSrc['src']?>);">
      <div class="header-index">
<?}else{?>
    <div id="site">
<?}?>
        <header class="header">
          <div class="container header__container">
            <div class="header__logo"><a class="logo" href="/"><img class="logo__img" src="/logo.svg" alt="<?=$arVillage['NAME']?>" title="<?=$arVillage['NAME']?>"/></a></div>
            <nav class="nav header__nav" role="navigation">
              <?$APPLICATION->IncludeComponent("bitrix:menu", "top_menu", Array(
              	"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
              		"CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
              		"COMPOSITE_FRAME_MODE" => "A",	// Голосование шаблона компонента по умолчанию
              		"COMPOSITE_FRAME_TYPE" => "AUTO",	// Содержимое компонента
              		"DELAY" => "N",	// Откладывать выполнение шаблона меню
              		"MAX_LEVEL" => "1",	// Уровень вложенности меню
              		"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
              		"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
              		"MENU_CACHE_TYPE" => "A",	// Тип кеширования
              		"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
              		"ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
              		"USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
              		"COMPONENT_TEMPLATE" => ".default"
              	),
              	false
              );?>
            </nav>
            <div class="header__phone"><a class="phone" href="tel:<?=str_replace(['','(',')','-'],'',$phone)?>"><span class="icon-phone phone__icon"></span> <?=$phone?></a></div>
            <button class="js-mobile-toggle header__toggle"><span class="header__toggle-line"></span><span class="header__toggle-line"></span><span class="header__toggle-line"></span></button>
          </div>
        </header>
<?if (CSite::InDir('/index.php')) { // если на главной
  $IHS = ($arVillage['PROPERTY_TYPE_USE_VALUE'] == 'Индвидуальное жилищное строительство') ? 'ИЖС ' : '';?>
        <div class="container b1-container">
          <div class="row">
            <div class="col-lg-9">
              <h1 class="title">Участки <?=$IHS?>в&nbsp;коттеджном поселке <?=$arVillage['NAME']?> на&nbsp;<?=$shosseNameKom?> шоссе</h1>
            </div>
          </div>
          <div class="row b1-list">
            <div class="col-lg-2 col-md col-6">
              <div class="b1-item">
                <div class="b1-item__icon">
                  <svg class="icon icon-01_1scr">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-01_1scr"></use>
                  </svg>
                </div><span><?=$regionName?> район</span>
              </div>
            </div>
            <div class="col-lg-2 col-md col-6">
              <div class="b1-item">
                <div class="b1-item__icon">
                  <svg class="icon icon-02_1scr">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-02_1scr"></use>
                  </svg>
                </div><span><?=$arVillage['PROPERTY_MKAD_VALUE']?> км. от МКАД</span>
              </div>
            </div>
            <div class="col-lg-2 col-md col-6">
              <div class="b1-item">
                <div class="b1-item__icon">
                  <svg class="icon icon-03_1scr">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-03_1scr"></use>
                  </svg>
                </div><span>Сотка от <?=formatPriceSite($priceSotka)?> ₽</span>
              </div>
            </div>
            <!-- <div class="col-lg-3 col-md col-6">
              <div class="b1-item">
                <div class="b1-item__icon">
                  <svg class="icon icon-04_1scr">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-04_1scr"></use>
                  </svg>
                </div><span>Рейтинг <?=$arVillage['PROPERTY_RATING_VALUE']?> на poselkino.ru</span>
              </div>
            </div> -->
          </div><a class="btn btn--large btn--theme_green" href="#takeLook">Узнать о скидках</a>
        </div>
      </div>
      <div class="shape"><span class="icon icon-arrow-right"></span></div>
    </div>
<?}?>
