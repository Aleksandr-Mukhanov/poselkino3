<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)die();
use Bitrix\Main\Page\Asset,
  Bitrix\Main\Loader;
    Loader::includeModule("iblock");

  Asset::getInstance()->addCss('https://fonts.googleapis.com/css2?family=Fira+Sans+Extra+Condensed&family=Inter:wght@400;500;700&family=Oswald:wght@400;600&display=swap');
  Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/style/libs.min.css');
  Asset::getInstance()->addCss(SITE_TEMPLATE_PATH.'/style/main.css');
  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/libs.min.js');
  Asset::getInstance()->addJs('https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=1c914fae-c0ca-40d5-9641-9cbd355e4f55');
  Asset::getInstance()->addJs(SITE_TEMPLATE_PATH.'/js/script.js');

  // получим наш поселок
  switch (SITE_SERVER_NAME) {
    case 'kp-koledino.ru': $villageID = 3487; break;
    case 'kp-skurygino.ru': $villageID = 3596; break;
    case 'hodaevskie-dachi.ru': $villageID = 3598; break;
    // case '': $villageID = ; break;
  }

  $arOrder = Array('SORT'=>'ASC');
  $arFilter = Array('IBLOCK_ID'=>1,'ID'=>$villageID);
  $arSelect = Array('ID','NAME','CODE','PREVIEW_PICTURE','PREVIEW_TEXT','PROPERTY_PLAN_IMG','PROPERTY_AREA_VIL','PROPERTY_COUNT_PLOTS','PROPERTY_COUNT_PLOTS_SOLD','PROPERTY_COUNT_PLOTS_SALE','PROPERTY_PLOTTAGE','PROPERTY_COST_LAND_IN_CART','PROPERTY_PRICE_ARRANGE','PROPERTY_INS_TERMS','PROPERTY_ELECTRO_KVT','PROPERTY_GAS','PROPERTY_PROVEDEN_GAZ','PROPERTY_ART_WELLS_DEPTH','PROPERTY_WATER_KM','PROPERTY_MKAD','PROPERTY_SETTLEM','PROPERTY_SETTLEM_KM','PROPERTY_TOWN','PROPERTY_TOWN_KM','PROPERTY_RAILWAY','PROPERTY_RAILWAY_KM','PROPERTY_COORDINATES','PROPERTY_AUTO_NO_JAMS','PROPERTY_TRAIN_ID_YANDEX','PROPERTY_TRAIN_TRAVEL_TIME','PROPERTY_TRAIN_VOKZAL','PROPERTY_TRAIN_PRICE','PROPERTY_TRAIN_PRICE_TAXI','PROPERTY_BUS_VOKZAL','PROPERTY_BUS_TIME_KM','PROPERTY_PRICE_SOTKA','PROPERTY_RATING','PROPERTY_LAND_CAT','PROPERTY_TYPE_USE','PROPERTY_LEGAL_FORM','PROPERTY_SRC_MAP','PROPERTY_SCRIN_EGRN','PROPERTY_DOP_FOTO','PROPERTY_UP_TO_VIEW','PROPERTY_DEVELOPER_ID','PROPERTY_SHOSSE','PROPERTY_REGION','PROPERTY_ROADS_IN_VIL','PROPERTY_LES','PROPERTY_WATER','PROPERTY_LEND_TEXT','PROPERTY_PLAN_IMG_IFRAME','PROPERTY_ON_SITE','PROPERTY_ARRANGE','PROPERTY_PHONE','PROPERTY_MANAGER','PROPERTY_VIDEO','PROPERTY_ON_TERRITORY'); // ,'PROPERTY_'
  $rsElements = \CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
  $arVillage = $rsElements->GetNext(); // dump($arVillage);

  $shosseName = array_values($arVillage["PROPERTY_SHOSSE_VALUE"])[0];
  $shosseNameKom = str_replace('кое','ком',array_values($arVillage["PROPERTY_SHOSSE_VALUE"])[0]);
  $shosseNameKomu = str_replace('кое','кому',array_values($arVillage["PROPERTY_SHOSSE_VALUE"])[0]);

  $regionName = $arVillage["PROPERTY_REGION_VALUE"];
  $roadsInName = getRoadName($arVillage["PROPERTY_ROADS_IN_VIL_VALUE"]);

  $LES = $arVillage['PROPERTY_LES_VALUE']; // Лес
  $arWater = $arVillage['PROPERTY_WATER_VALUE']; // Водоем

  // получим девелопера
  $arDevel = array_values(getElHL(5,[],['UF_XML_ID'=>$arVillage['PROPERTY_DEVELOPER_ID_VALUE'][0]],['ID','UF_NAME','UF_XML_ID','UF_ADDRESS','UF_PHONE','UF_SCHEDULE'])); // dump($arDevel);
  $phone = ($arVillage["PROPERTY_PHONE_VALUE"]) ? $arVillage["PROPERTY_PHONE_VALUE"] : $arDevel[0]['UF_PHONE'];
  $phoneClear = str_replace(['','(',')','-'],'',$phone);

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

  $prevSrc = CFile::ResizeImageGet($arVillage['PREVIEW_PICTURE'], array('width'=>1920, 'height'=>920), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);

  $arVideo = explode('https://youtu.be/',$arVillage['PROPERTY_VIDEO_VALUE']);
  $arCoordinates = explode(',',$arVillage['PROPERTY_COORDINATES_VALUE']);

  // получим участки
  $arPlots = getElHL(15,['UF_SORT'=>'ASC'],['UF_VILLAGE'=>$arVillage['ID']],['*']);

  include_once ($mainUrl.'/include/sites/phone.php');
?>
<!DOCTYPE html>
<html lang="<?=LANGUAGE_ID?>" prefix="og: http://ogp.me/ns#">

<head>
  <title><?$APPLICATION->ShowTitle()?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <link rel="shortcut icon" href="/favicon.png" type="image/png">

  <meta property="og:title" content="<?=$APPLICATION->ShowProperty("title");?>"/>
  <meta property="og:description" content="<?=$APPLICATION->ShowProperty("description");?>"/>
  <meta property="og:image" content="<?='https://'.SITE_SERVER_NAME.SITE_TEMPLATE_PATH?>/images/logo.svg"/>
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="<?=$arVillage['NAME']?>" />
  <meta property="og:url" content= "<?='https://'.SITE_SERVER_NAME.$APPLICATION->GetCurDir();?>" />

  <?$APPLICATION->ShowHead()?>
</head>

<body>
  <div id="panel"><?$APPLICATION->ShowPanel();?></div>
  <div class="wrapper">
    <header class="header">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-xl-3 col"><a class="logo" href="/"><img src="<?=SITE_TEMPLATE_PATH?>/images/logo.svg" alt="<?=$arVillage['NAME']?>" title="<?=$arVillage['NAME']?>" />
              <div class="logo__desc"><?=$arVillage['NAME']?></div>
            </a></div>
          <div class="col d-xl-block d-none">
            <nav class="nav">
              <a class="nav__link flowing-scroll" href="/#section-2">О поселке</a>
              <a class="nav__link flowing-scroll" href="/#section-3">Поселок на карте</a>
              <a class="nav__link flowing-scroll" href="/#section-4">План поселка</a>
              <a class="nav__link flowing-scroll" href="/#section-7">Галерея</a>
              <a class="nav__link flowing-scroll" href="/#contacts">Контакты</a>
            </nav>
          </div>
          <div class="col-auto col">
            <div class="d-flex head-flex"><a class="header-phone" href="tel:<?=$phoneClear?>"><?=$phone?></a>
              <div class="open-menu d-xl-none d-block">
                <svg class="icon">
                  <use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#menu"></use>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
    <div class="menu">
      <div class="menu__header">
        <div class="mb-2 menu-head"><a class="logo" href="/"><img src="<?=SITE_TEMPLATE_PATH?>/images/logo.svg" alt="<?=$arVillage['NAME']?>" title="<?=$arVillage['NAME']?>" />
            <div class="logo__desc"><?=$arVillage['NAME']?></div>
          </a>
          <div class="menu-close">
            <svg class="icon icon--close">
              <use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#close"></use>
            </svg>
          </div>
        </div>
        <nav class="nav nav--menu">
          <a class="nav__link flowing-scroll" href="/#section-2">О поселке</a>
          <a class="nav__link flowing-scroll" href="/#section-3">Поселок на карте</a>
          <a class="nav__link flowing-scroll" href="/#section-4">План поселка</a>
          <a class="nav__link flowing-scroll" href="/#section-7">Галерея</a>
          <a class="nav__link flowing-scroll" href="/#contacts">Контакты</a>
        </nav>
      </div>
      <div class="menu__footer">
        <div class="mb-3"><a class="header-phone" href="tel:<?=$phoneClear?>"><?=$phone?></a></div>
        <!-- <ul class="social">
          <li class="social__item"><a class="social__link" href="">
              <svg class="icon social__icon">
                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#instagram"></use>
              </svg></a></li>
          <li class="social__item"><a class="social__link" href="">
              <svg class="icon social__icon">
                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#telegram"></use>
              </svg></a></li>
          <li class="social__item"><a class="social__link" href="">
              <svg class="icon social__icon">
                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#twitter"></use>
              </svg></a></li>
          <li class="social__item"><a class="social__link" href="">
              <svg class="icon social__icon">
                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#facebook"></use>
              </svg></a></li>
        </ul> -->
      </div>
    </div>
