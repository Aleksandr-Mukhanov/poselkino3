<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;
use Bitrix\Main\Grid\Declension;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var CatalogSectionComponent $component
 */

// dump($item['DISPLAY_PROPERTIES']['TYPE']);

$ourDir = $APPLICATION->GetCurDir();

$domPos = $_REQUEST['DOMA_CODE'];

if ($item['PROPERTIES']['NAME_OTHER']['VALUE']) $productTitle = $item['PROPERTIES']['NAME_OTHER']['VALUE'];

// тип поселка
$idTypePos = $item['DISPLAY_PROPERTIES']['TYPE']['VALUE_ENUM_ID'];
if ($domPos) {
    // добавления участка, дома в название
    switch ($domPos) {
        case 'noDom':
            $nameDomPos = 'Участки в ';
            break;
        case 'withDom':
            $nameDomPos = 'Дома в ';
            break;
        default:
            $nameDomPos = '';
            break;
    }
    // свое склонение
    switch ($idTypePos) {
        case PROP_DACHA:
            $nameTypePos = 'дачном поселке';
            break;
        case PROP_COTTAGE:
            $nameTypePos = 'коттеджном поселке';
            break;
        case PROP_FARMING:
            $nameTypePos = 'фермерстве';
            break;
        default:
            $nameTypePos = '';
            break;
    }

    $nameDomPos = $nameDomPos . ' ' . $nameTypePos;
} else {
    switch ($idTypePos) {
        case PROP_DACHA:
            $nameTypePos = 'Дачный поселок';
            break;
        case PROP_COTTAGE:
            $nameTypePos = 'Коттеджный поселок';
            break;
        case PROP_FARMING:
            $nameTypePos = 'Фермерство';
            break;
        default:
            $nameTypePos = '';
            break;
    }

    $nameDomPos = $nameTypePos;
}

// добавим превьюшку в фото
if ($item["PREVIEW_PICTURE"]) {
    array_unshift($item['PROPERTIES']['DOP_FOTO']['VALUE'], $item["PREVIEW_PICTURE"]["ID"]); // положим в начало
} // dump($item['PROPERTIES']['DOP_FOTO']['VALUE']);

// водный знак
$arWaterMark = [
    [
        "name" => "watermark",
        "position" => "bottomright", // Положение
        "type" => "image",
        "size" => "real",
        "file" => $_SERVER["DOCUMENT_ROOT"] . '/upload/water_sign.png', // Путь к картинке
        "fill" => "exact",
    ]
];

$ratingItogo = $item['PROPERTIES']['RATING']['VALUE'];

// км от МКАД
$km_MKAD = $item['DISPLAY_PROPERTIES']['MKAD']['VALUE'];
switch ($km_MKAD) {
    case $km_MKAD <= 10:
        $url_km_MKAD = "do-10-km-ot-mkad";
        break;
    case $km_MKAD <= 15:
        $url_km_MKAD = "do-15-km-ot-mkad";
        break;
    case $km_MKAD <= 20:
        $url_km_MKAD = "do-20-km-ot-mkad";
        break;
    case $km_MKAD <= 25:
        $url_km_MKAD = "do-25-km-ot-mkad";
        break;
    case $km_MKAD <= 30:
        $url_km_MKAD = "do-30-km-ot-mkad";
        break;
    case $km_MKAD <= 35:
        $url_km_MKAD = "do-35-km-ot-mkad";
        break;
    case $km_MKAD <= 40:
        $url_km_MKAD = "do-40-km-ot-mkad";
        break;
    case $km_MKAD <= 45:
        $url_km_MKAD = "do-45-km-ot-mkad";
        break;
    case $km_MKAD <= 50:
        $url_km_MKAD = "do-50-km-ot-mkad";
        break;
    case $km_MKAD <= 55:
        $url_km_MKAD = "do-55-km-ot-mkad";
        break;
    case $km_MKAD <= 60:
        $url_km_MKAD = "do-60-km-ot-mkad";
        break;
    case $km_MKAD <= 65:
        $url_km_MKAD = "do-65-km-ot-mkad";
        break;
    case $km_MKAD <= 70:
        $url_km_MKAD = "do-70-km-ot-mkad";
        break;
    case $km_MKAD <= 75:
        $url_km_MKAD = "do-75-km-ot-mkad";
        break;
    case $km_MKAD <= 80:
        $url_km_MKAD = "do-80-km-ot-mkad";
        break;

    default:
        $url_km_MKAD = "do-80-km-ot-mkad";
        break;
} // echo $url_km_MKAD;

// dump($arParams);
$comp_active = ($arParams['COMPARISON'] == 'Y') ? 'active' : '';
$fav_active = ($arParams['FAVORITES'] == 'Y') ? 'active' : '';
$comp_text = ($arParams['COMPARISON'] == 'Y') ? 'Удалить из сравнения' : 'Добавить к сравнению';
$fav_text = ($arParams['FAVORITES'] == 'Y') ? 'Удалить из избранного' : 'Добавить в избранное';

// выводим правильное окончание
$reviewsDeclension = new Declension('отзыв', 'отзыва', 'отзывов');
$reviewsText = $reviewsDeclension->get($arResult["COMMENTS"][$item["ID"]]) . ' от жителей';
$reviewsText = ($arResult["COMMENTS"][$item["ID"]]) ? $arResult["COMMENTS"][$item["ID"]] . ' ' . $reviewsText : 'Нет отзывов';

// отображение по Наличию домов
$housesValEnum = $item['DISPLAY_PROPERTIES']['DOMA']['VALUE_ENUM_ID'];
?>
<div class="d-flex flex-wrap bg-white card-grid">
    <div class="card-house__photo photo">
        <div class="slider__header">
            <? if ($item['PROPERTIES']['ACTION']['VALUE']) { ?>
                <div class="slider__label">
                    Акция<? if ($item['PROPERTIES']['SALE_SUM']['VALUE']) { ?> - <?= $item['PROPERTIES']['SALE_SUM']['VALUE'] ?>%<? } ?></div>
            <? } ?>
            <div class="photo__buttons">
                <button title="<?= $comp_text ?>" class="comparison-click <?= $comp_active ?>"
                        data-id="<?= $item['ID'] ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19.42" height="17.556" viewBox="0 0 19.42 17.556"
                         class="inline-svg add-comparison">
                        <g transform="translate(-1216.699 -36.35)">
                            <path d="M0 0v16.139" class="s-1" transform="translate(1217.349 37)"/>
                            <path d="M0 0v8.468" class="s-1" transform="translate(1233.321 37)"/>
                            <g transform="translate(.586 .586)">
                                <path d="M0 0v4.297" class="s-2" transform="translate(1232.735 48)"/>
                                <path d="M0 0v4.297" class="s-2" transform="rotate(90 592.368 642.516)"/>
                            </g>
                            <path d="M0 0v13.215" class="s-1" transform="translate(1222.807 40.041)"/>
                            <path d="M0 0v7.641" class="s-1" transform="translate(1228.265 45.499)"/>
                        </g>
                    </svg>
                </button>
                <button title="<?= $fav_text ?>" class="favorites-click <?= $fav_active ?>"
                        data-id="<?= $item['ID'] ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="21" viewBox="0 0 24 21"
                         class="inline-svg add-heart">
                        <g transform="translate(.05 -26.655)">
                            <path d="M19.874 30.266a5.986 5.986 0 0 0-8.466 0l-.591.591-.6-.6a5.981 5.981 0 0 0-8.466-.009 5.981 5.981 0 0 0 .009 8.466l8.608 8.608a.614.614 0 0 0 .871 0l8.626-8.594a6 6 0 0 0 .009-8.47zm-.88 7.595L10.8 46.019l-8.169-8.172a4.745 4.745 0 1 1 6.71-6.71l1.036 1.036a.617.617 0 0 0 .875 0l1.027-1.027a4.748 4.748 0 0 1 6.715 6.715z"
                                  class="s-1"/>
                            <circle cx="4.5" cy="4.5" r="4.5" class="s-2" transform="translate(14.96 26.655)"/>
                            <g transform="translate(-1213.44 -18.727)">
                                <path d="M0 0v4.297" class="s-3" transform="translate(1232.735 48)"/>
                                <path d="M0 0v4.297" class="s-3" transform="rotate(90 592.368 642.516)"/>
                            </g>
                        </g>
                    </svg>
                </button>
            </div>
        </div>
        <a class="stretched-link" href="<?= $item['DETAIL_PAGE_URL'] ?>" style="cursor: pointer;"></a>
        <div class="card-photo__list">
            <? foreach ($item['PROPERTIES']['DOP_FOTO']['VALUE'] as $key => $photo) { // Фото
                $photoRes = CFile::ResizeImageGet($photo, array('width' => 580, 'height' => 358), BX_RESIZE_IMAGE_EXACT); ?>
                <div class="card-photo__item"
                     style="background: url(<?= $photoRes['src'] ?>) center center / cover no-repeat; width: 495px;"></div>
            <? } ?>
        </div>
        <div class="photo__count">
            <span class="current">1</span> / <span
                    class="count"><?= count($item['PROPERTIES']['DOP_FOTO']['VALUE']) ?></span>
        </div>
    </div>
    <div class="card-house__content">
        <div class="content-wrap">
            <div class="wrap-title">
                <div class="card-house__title">
                    <a href="<?= $item['DETAIL_PAGE_URL'] ?>"
                       style="cursor: pointer;"><?= $nameDomPos ?> <?= $productTitle ?></a>
                </div>
                <? if ($item['DISPLAY_PROPERTIES']['REGION']['VALUE']): ?>
                    <div class="card-house__area">
                      <?if($ourDir == '/poselki/'.$item['DISPLAY_PROPERTIES']['REGION']['VALUE_XML_ID'].'-rayon/'):?>
                        <a><?= $item['DISPLAY_PROPERTIES']['REGION']['VALUE']?> район</a>
                      <?else:?>
                        <a href="/poselki/<?=$item['DISPLAY_PROPERTIES']['REGION']['VALUE_XML_ID']?>-rayon/"><?= $item['DISPLAY_PROPERTIES']['REGION']['VALUE']?> район</a>
                      <?endif;?>
                    </div>
                <? endif; ?>
            </div>
            <div class="wrap-raiting">
                <div class="card-house__raiting">
                    <div class="line-raiting">
                        <div class="line-raiting__star">
                            <div class="line-raiting__star--wrap" style="width: <?= $ratingItogo * 100 / 5 ?>%;"></div>
                        </div>
                        <div class="line-raiting__title"><?= $ratingItogo ?></div>
                    </div>
                </div>
                <div class="card-house__review review hide__mob">
                    <div class="d-flex"><a href="<?= $item['DETAIL_PAGE_URL'] ?>#block_reviews">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18.455" height="15.821"
                                 viewBox="0 0 18.455 15.821" class="inline-svg">
                                <g transform="translate(0 -36.507)">
                                    <path d="M17.22 39.787a8.348 8.348 0 0 0-3.357-2.4 11.972 11.972 0 0 0-4.634-.881 12.246 12.246 0 0 0-3.584.52A10.023 10.023 0 0 0 2.7 38.433a7.025 7.025 0 0 0-1.969 2.106A4.905 4.905 0 0 0 0 43.1a5 5 0 0 0 .932 2.894 7.562 7.562 0 0 0 2.549 2.266 6.546 6.546 0 0 1-.268.782q-.154.371-.278.608a4.184 4.184 0 0 1-.335.525q-.211.288-.319.407l-.355.391q-.247.273-.319.355a.72.72 0 0 0-.082.093l-.072.087-.063.092q-.052.077-.046.1a.274.274 0 0 1-.021.1.136.136 0 0 0 .005.124v.01a.518.518 0 0 0 .18.3.4.4 0 0 0 .314.092A7.73 7.73 0 0 0 3 52.1a11.256 11.256 0 0 0 4.737-2.492 14.09 14.09 0 0 0 1.493.082 11.968 11.968 0 0 0 4.634-.881 8.347 8.347 0 0 0 3.357-2.4 5.053 5.053 0 0 0 0-6.622z"
                                          class="cls-2" data-name="Path 7"/>
                                </g>
                            </svg><?= $reviewsText ?></a></div>
                </div>
            </div>
        </div>
        <div class="card-house__metro mt-2 mt-lg-3">
          <? if ($item['DISPLAY_PROPERTIES']['SHOSSE']['VALUE_ENUM_ID'][0]): // если есть шоссе
              $idEnumHW = $item['DISPLAY_PROPERTIES']['SHOSSE']['VALUE_ENUM_ID'][0];
              $valEnumHW = $item['DISPLAY_PROPERTIES']['SHOSSE']['VALUE_XML_ID'][0];
              $colorHW = getColorRoad($idEnumHW);
              $nameHW = $item['DISPLAY_PROPERTIES']['SHOSSE']['VALUE'][0];
              ?>
              <div class="d-flex flex-wrap w-100 mt-1 mt-lg-2">
                <?if($ourDir == '/poselki/'.$valEnumHW.'-shosse/'): $closeTag = '</span>';?>
                  <span class="metro z-index-1 highway-color mr-3">
                <?else: $closeTag = '</a>';?>
                  <a class="metro z-index-1 highway-color mr-3" href="/poselki/<?=$valEnumHW?>-shosse/">
                <?endif;?>
                    <span class="metro-color <?= $colorHW ?>"></span>
                    <span class="metro-name"><?= $nameHW ?> шоссе</span>
                  <?=$closeTag?>
                <a class="metro ml-0 z-index-1" href="/poselki/<?= $url_km_MKAD ?>/">
                  <span class="metro-other"><?= $km_MKAD ?> км от <?=ROAD?></span>
                </a>
              </div>
          <? endif; ?>
          <? if ($item['DISPLAY_PROPERTIES']['SHOSSE']['VALUE_ENUM_ID'][1]): // если есть 2-е шоссе
              $idEnumHW = $item['DISPLAY_PROPERTIES']['SHOSSE']['VALUE_ENUM_ID'][1];
              $valEnumHW = $item['DISPLAY_PROPERTIES']['SHOSSE']['VALUE_XML_ID'][1];
              $colorHW = getColorRoad($idEnumHW);
              $nameHW = $item['DISPLAY_PROPERTIES']['SHOSSE']['VALUE'][1];
          ?>
              <div class="d-flex w-100 mt-1 mt-lg-2">
                <a class="metro z-index-1 pl-0 highway-color" href="/poselki/<?=$valEnumHW?>-shosse/">
                  <span class="metro-color <?= $colorHW ?>"></span>
                  <span class="metro-name"><?= $nameHW ?> шоссе</span>
                </a>
              </div>
          <? endif; ?>
          <? if ($item['PROPERTIES']['SHOSSE_DOP']['VALUE'][0]): // если есть доп. шоссе
              $valEnumHW = $item['PROPERTIES']['SHOSSE_DOP']['VALUE'][0];
              $idEnumHW = getNamesList($valEnumHW,'SHOSSE')['ID'];
              $colorHW = getColorRoad($idEnumHW);
              $nameHW = getNamesList($valEnumHW,'SHOSSE')['NAME'];
          ?>
              <div class="d-flex w-100 mt-1 mt-lg-2">
                <a class="metro z-index-1 pl-0 highway-color" href="/poselki/<?=$valEnumHW?>-shosse/">
                  <span class="metro-color <?= $colorHW ?>"></span>
                  <span class="metro-name"><?= $nameHW ?> шоссе</span>
                </a>
              </div>
          <? endif; ?>
        </div>
        <div class="card-house__price mt-1 mt-lg-2">
            <? if ($housesValEnum == PROP_NO_DOM) { // Только участки ?>
                <div class="card-house__price-title"><span class="rub">a</span>Сотка:&nbsp;</div>
                <div class="card-house__price-number">от <span
                            class="split-number"><?= formatPrice($item['PROPERTIES']['PRICE_SOTKA']['VALUE'][0]) ?></span>
                    <span class="rep_rubl">руб.</span></div>
            <? } elseif ($housesValEnum == PROP_WITH_DOM || $housesValEnum == PROP_HOUSE_PLOT) { // Участки с домами ?>
                <div class="card-house__price-title"><span class="rub">a</span>Дома:&nbsp;</div>
                <div class="card-house__price-number">от <span
                            class="split-number"><?= formatPrice($item['PROPERTIES']['HOME_VALUE']['VALUE'][0]) ?></span>
                    <span class="rep_rubl">руб.</span></div>
            <? } ?>
        </div>
        <hr>
        <div class="row d-none d-md-flex">
            <div class="col-md-8 pl-1">
                <div class="card-house__inline">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17.323" height="15.8" viewBox="0 0 17.323 15.8"
                         class="inline-svg">
                        <path d="M16.524 29.385q-.558 0-1.109.036-.186-.128-.4-.258v-1.35a1.5 1.5 0 0 0 1-1.415v-2a1.5 1.5 0 0 0-3 0v2a1.5 1.5 0 0 0 1 1.415v.8a12.065 12.065 0 0 0-3.009-1V26.01a.5.5 0 0 0 .468-.868l-2.671-2a.5.5 0 0 0-.6 0l-2.671 2A.5.5 0 0 0 6 26.01v1.606a12.066 12.066 0 0 0-3.009 1v-.8A1.5 1.5 0 0 0 4 26.4v-2a1.5 1.5 0 1 0-3 0v2a1.5 1.5 0 0 0 1 1.415v1.35q-.209.13-.4.258-.543-.037-1.1-.038a.5.5 0 0 0-.5.5V37.9a.5.5 0 0 0 .5.5h16.024a.5.5 0 0 0 .5-.5v-8.016a.5.5 0 0 0-.5-.499zm-.5 8.013h-2.253a11 11 0 0 0-1.816-3.028 12.807 12.807 0 0 0-2.48-2.26 14.967 14.967 0 0 1 6.55-1.72zm-3.335 0H7.632a7.556 7.556 0 0 0-2.569-3.49A7.524 7.524 0 0 0 1 32.406v-2.015c5.242.168 9.9 2.971 11.693 7.007zm-8.358 0H1v-3.992A6.6 6.6 0 0 1 6.564 37.4H4.332zm9.686-13a.5.5 0 1 1 1.006 0v2a.5.5 0 1 1-1.006 0zm-7.011.894l1.5-1.128 1.5 1.128v2.176A13.2 13.2 0 0 0 9 27.394v-.749a.5.5 0 0 0-1 0v.749c-.347.013-.682.038-1.006.074zM2 24.4a.5.5 0 1 1 1 0v2a.5.5 0 1 1-1 0zm6.512 3.984a11.459 11.459 0 0 1 5.272 1.229 15.351 15.351 0 0 0-5.272 1.884 15.351 15.351 0 0 0-5.272-1.884 11.459 11.459 0 0 1 5.271-1.234z"
                              transform="translate(.15 -22.745)"/>
                    </svg>
                    <div class="card-house__inline-title">Участки:&nbsp;</div>
                    <div class="card-house__inline-value">
                      от <?= round($item['DISPLAY_PROPERTIES']['PLOTTAGE']['VALUE'][0]) ?>
                      до <?= round($item['DISPLAY_PROPERTIES']['PLOTTAGE']['VALUE'][1]) ?> соток
                    </div>
                </div>
                <div class="card-house__inline">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16.523" height="16.523" viewBox="0 0 16.523 16.523"
                         class="inline-svg">
                        <path d="M16.523 1.614v13.3a1.615 1.615 0 0 1-1.614 1.614h-1.57a.645.645 0 1 1 0-1.291h1.571a.323.323 0 0 0 .323-.323V8.939h-5.7a.645.645 0 0 1 0-1.291h5.7V1.614a.323.323 0 0 0-.323-.323H7.618v1.893a.645.645 0 0 1-1.291 0V1.291H1.614a.323.323 0 0 0-.323.323v6h5.036V5.723a.645.645 0 0 1 1.291 0V10.8a.645.645 0 1 1-1.291 0V8.907H1.291v6a.323.323 0 0 0 .323.323h4.713v-1.891a.645.645 0 0 1 1.291 0v1.893H10.8a.645.645 0 1 1 0 1.291H1.614A1.615 1.615 0 0 1 0 14.909V1.614A1.615 1.615 0 0 1 1.614 0h13.3a1.615 1.615 0 0 1 1.609 1.614zm0 0"/>
                    </svg>
                    <? if ($housesValEnum == PROP_NO_DOM) { // если только участок?>
                        <div class="card-house__inline-title">Стоимость:&nbsp;</div>
                        <div class="card-house__inline-value">от&nbsp;
                          <span class="split-number"><?= $item['PROPERTIES']['COST_LAND_IN_CART']['VALUE'][0] ?></span>
                          <span class="rep_rubl">руб.</span>
                        </div>
                    <? } else { ?>
                        <div class="card-house__inline-title">Дома:&nbsp;</div>
                        <div class="card-house__inline-value">
                          от <?= round($item['DISPLAY_PROPERTIES']['HOUSE_AREA']['VALUE'][0]) ?>
                          до <?= round($item['DISPLAY_PROPERTIES']['HOUSE_AREA']['VALUE'][1]) ?> м<sup>2</sup>
                        </div>
                    <? } ?>
                </div>
            </div>
            <div class="col-md-4 justify-content-end text-right">
              <a class="card-house__view btn btn-outline-warning w-100 rounded-pill" href="<?= $item['DETAIL_PAGE_URL'] ?>">Подробнее</a>
            </div>
        </div>
    </div>
    <div class="container d-md-none">
        <div class="row align-items-center">
            <div class="col-sm-8">
                <div class="card-house__inline">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17.323" height="15.8" viewBox="0 0 17.323 15.8"
                         class="inline-svg">
                        <path d="M16.524 29.385q-.558 0-1.109.036-.186-.128-.4-.258v-1.35a1.5 1.5 0 0 0 1-1.415v-2a1.5 1.5 0 0 0-3 0v2a1.5 1.5 0 0 0 1 1.415v.8a12.065 12.065 0 0 0-3.009-1V26.01a.5.5 0 0 0 .468-.868l-2.671-2a.5.5 0 0 0-.6 0l-2.671 2A.5.5 0 0 0 6 26.01v1.606a12.066 12.066 0 0 0-3.009 1v-.8A1.5 1.5 0 0 0 4 26.4v-2a1.5 1.5 0 1 0-3 0v2a1.5 1.5 0 0 0 1 1.415v1.35q-.209.13-.4.258-.543-.037-1.1-.038a.5.5 0 0 0-.5.5V37.9a.5.5 0 0 0 .5.5h16.024a.5.5 0 0 0 .5-.5v-8.016a.5.5 0 0 0-.5-.499zm-.5 8.013h-2.253a11 11 0 0 0-1.816-3.028 12.807 12.807 0 0 0-2.48-2.26 14.967 14.967 0 0 1 6.55-1.72zm-3.335 0H7.632a7.556 7.556 0 0 0-2.569-3.49A7.524 7.524 0 0 0 1 32.406v-2.015c5.242.168 9.9 2.971 11.693 7.007zm-8.358 0H1v-3.992A6.6 6.6 0 0 1 6.564 37.4H4.332zm9.686-13a.5.5 0 1 1 1.006 0v2a.5.5 0 1 1-1.006 0zm-7.011.894l1.5-1.128 1.5 1.128v2.176A13.2 13.2 0 0 0 9 27.394v-.749a.5.5 0 0 0-1 0v.749c-.347.013-.682.038-1.006.074zM2 24.4a.5.5 0 1 1 1 0v2a.5.5 0 1 1-1 0zm6.512 3.984a11.459 11.459 0 0 1 5.272 1.229 15.351 15.351 0 0 0-5.272 1.884 15.351 15.351 0 0 0-5.272-1.884 11.459 11.459 0 0 1 5.271-1.234z"
                              transform="translate(.15 -22.745)"/>
                    </svg>
                    <div class="card-house__inline-title">Участки:&nbsp;</div>
                    <div class="card-house__inline-value">
                      от <?= round($item['DISPLAY_PROPERTIES']['PLOTTAGE']['VALUE'][0]) ?>
                      до <?= round($item['DISPLAY_PROPERTIES']['PLOTTAGE']['VALUE'][1]) ?> соток
                    </div>
                </div>
                <div class="card-house__inline">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16.523" height="16.523" viewBox="0 0 16.523 16.523"
                         class="inline-svg">
                        <path d="M16.523 1.614v13.3a1.615 1.615 0 0 1-1.614 1.614h-1.57a.645.645 0 1 1 0-1.291h1.571a.323.323 0 0 0 .323-.323V8.939h-5.7a.645.645 0 0 1 0-1.291h5.7V1.614a.323.323 0 0 0-.323-.323H7.618v1.893a.645.645 0 0 1-1.291 0V1.291H1.614a.323.323 0 0 0-.323.323v6h5.036V5.723a.645.645 0 0 1 1.291 0V10.8a.645.645 0 1 1-1.291 0V8.907H1.291v6a.323.323 0 0 0 .323.323h4.713v-1.891a.645.645 0 0 1 1.291 0v1.893H10.8a.645.645 0 1 1 0 1.291H1.614A1.615 1.615 0 0 1 0 14.909V1.614A1.615 1.615 0 0 1 1.614 0h13.3a1.615 1.615 0 0 1 1.609 1.614zm0 0"/>
                    </svg>
                    <? if ($housesValEnum == PROP_NO_DOM) { // если только участок?>
                        <div class="card-house__inline-title">Стоимость:&nbsp;</div>
                        <div class="card-house__inline-value">от&nbsp;
                          <span class="split-number"><?= $item['PROPERTIES']['COST_LAND_IN_CART']['VALUE'][0] ?></span>
                          <span class="rep_rubl">руб.</span>
                        </div>
                    <? } else { ?>
                        <div class="card-house__inline-title">Дома:&nbsp;</div>
                        <div class="card-house__inline-value">
                          от <?= round($item['DISPLAY_PROPERTIES']['HOUSE_AREA']['VALUE'][0]) ?>
                          до <?= round($item['DISPLAY_PROPERTIES']['HOUSE_AREA']['VALUE'][1]) ?> м<sup>2</sup>
                        </div>
                    <? } ?>
                </div>
            </div>
            <div class="col-sm-4 mt-1 mt-sm-0 pb-3 mb-0 mb-sm-3">
              <a class="btn btn-outline-warning w-100 rounded-pill" href="<?=$item['DETAIL_PAGE_URL']?>">Подробнее</a>
            </div>
        </div>
    </div>
</div>
