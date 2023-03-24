<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

// определим шоссе
$arHighway = [
  [
    'id' => 376,
    'name' => 'Московское',
    'code' => 'moskovskoe'
  ],[
    'id' => 372,
    'name' => 'Киевское',
    'code' => 'kievskoe'
  ],[
    'id' => 548,
    'name' => 'Новоприозерское',
    'code' => 'novopriozerskoe'
  ],[
    'id' => 377,
    'name' => 'Мурманское',
    'code' => 'murmanskoe'
  ]
];

// получим наши поселки
$arOrder = Array('SORT' => 'ASC');
$arFilter = Array('IBLOCK_ID' => IBLOCK_ID,'ACTIVE' => 'Y','!PROPERTY_SALES_PHASE' => [PROP_SOLD_ID],'!PROPERTY_HIDE_POS' => PROP_HIDE_ID);
if ($arrFilter) array_push($arFilter, $arrFilter); // dump($arrFilter);
$arSelect = Array('ID','NAME','PROPERTY_SHOSSE','PROPERTY_MKAD','PROPERTY_PROVEDEN_GAZ','PROPERTY_ELECTRO_DONE','PROPERTY_PROVEDENA_VODA','PROPERTY_TYPE_USE','PROPERTY_LES','PROPERTY_WATER','PROPERTY_PRICE_SOTKA','PROPERTY_ELECTRO','PROPERTY_ROADS_IN_VIL','PROPERTY_ARRANGE','PROPERTY_DOMA','PROPERTY_HOME_VALUE','PROPERTY_COST_LAND_IN_CART');
$rsElements = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
while ($arElement = $rsElements->GetNext())
{
    if (!$shosse) {// шоссе
        if (array_key_exists($arHighway[0]['id'], $arElement['PROPERTY_SHOSSE_VALUE'])) { // Дмитровское - север
            $arTegs['north']['cnt'] += 1;
        }
        if (array_key_exists($arHighway[1]['id'], $arElement['PROPERTY_SHOSSE_VALUE'])) { // Новорязанское - восток
            $arTegs['east']['cnt'] += 1;
        }
        if (array_key_exists($arHighway[2]['id'], $arElement['PROPERTY_SHOSSE_VALUE'])) { // Симферопольское - юг
            $arTegs['south']['cnt'] += 1;
        }
        if (array_key_exists($arHighway[3]['id'], $arElement['PROPERTY_SHOSSE_VALUE'])) { // Новорижское - запад
            $arTegs['west']['cnt'] += 1;
        }
    }

    for ($i = 10; $i < 60; $i += 10) { // до КАД
        if ($arElement['PROPERTY_MKAD_VALUE'] >= $i - 20 && $arElement['PROPERTY_MKAD_VALUE'] <= $i + 10) { // До xx км от Москвы
            $arTegs['mkad_' . $i]['cnt'] += 1;
        }
    }

    if ($arElement['PROPERTY_PROVEDEN_GAZ_ENUM_ID'] == 398) // Газ (проведен)
      $arTegs['gaz']['cnt'] += 1;

    if ($arElement['PROPERTY_ELECTRO_DONE_ENUM_ID'] == 394) // Электричество (проведен)
      $arTegs['elektro']['cnt'] += 1;

    if ($arElement['PROPERTY_PROVEDENA_VODA_ENUM_ID'] == 403) // Водопровод (проведен)
      $arTegs['voda']['cnt'] += 1;

    if (in_array($arElement['PROPERTY_TYPE_USE_ENUM_ID'], [433, 429])) { // Вид разрешенного использования - ИЖС
        $arTegs['izhs']['cnt'] += 1;
    } elseif (in_array($arElement['PROPERTY_TYPE_USE_ENUM_ID'], [424, 430, 432, 431])) { // Вид разрешенного использования - СНТ
        $arTegs['snt']['cnt'] += 1;
    }

    if (in_array($arElement['PROPERTY_LES_ENUM_ID'], [454, 455, 457, 458])) { // Лес
        $arTegs['ryadom-s-lesom']['cnt'] += 1;
    }

    foreach ($arElement['PROPERTY_WATER_VALUE'] as $key => $value) { // Водоем
        if (in_array($key, [459, 460, 461])) {
            $arTegs['u-vody']['cnt'] += 1;
            break;
        }
    }

    // определим класс
    if ($arElement['PROPERTY_PRICE_SOTKA_VALUE'][0] && $arElement['PROPERTY_PRICE_SOTKA_VALUE'][0] <= 100000) { // эконом
        $arTegs['econom']['cnt'] += 1;
    }

    $dorogiKomfort = [478, 479, 480, 482, 483, 484]; // комфорт - Дороги в поселке
    if ($arElement['PROPERTY_ELECTRO_ENUM_ID'] == 392 && in_array($arElement['PROPERTY_ROADS_IN_VIL_ENUM_ID'], $dorogiKomfort) && array_key_exists(492, $arElement['PROPERTY_ARRANGE_VALUE'])) { // 392 - Электричество, 492 - Обустройство поселка: Огорожен
        $arTegs['komfort']['cnt'] += 1;
    }

    // по стоимости
    // dump($arElement);
    if($arElement['PROPERTY_DOMA_ENUM_ID'] == PROP_NO_DOM || $arElement['PROPERTY_DOMA_ENUM_ID'] == PROP_HOUSE_PLOT){ // участки
      if ($arElement['PROPERTY_COST_LAND_IN_CART_VALUE'][0] && $arElement['PROPERTY_COST_LAND_IN_CART_VALUE'][0] <= 1000000)
        $arTegs['do-1-milliona']['cnt'] += 1;
    } else if($arElement['PROPERTY_DOMA_ENUM_ID'] == PROP_WITH_DOM || $arElement['PROPERTY_DOMA_ENUM_ID'] == PROP_HOUSE_PLOT){ // дома
      if ($arElement['PROPERTY_HOME_VALUE_VALUE'][0] && $arElement['PROPERTY_HOME_VALUE_VALUE'][0] <= 2000000)
        $arTegs['do-2-milliona']['cnt'] += 1;
    }
} // dump($arTegs);

// формируем мультитеги
// шоссе
$arTegs['north']['name'] = $arHighway[0]['name']. ' ш.';
if (!$arTegs['north']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = '/poselki/'.$arHighway[0]['code'].'-shosse/kupit-uchastok/';
            break;
        case 'withDom': // Дома
            $urlTeg = '/poselki/'.$arHighway[0]['code'].'-shosse/kupit-dom/';
            break;
        default: // Поселки
            $urlTeg = '/poselki/'.$arHighway[0]['code'].'-shosse/';
            break;
    }
    $arTegs['north']['url'] = $urlTeg;
}
$arTegs['east']['name'] = $arHighway[1]['name']. ' ш.';
if (!$arTegs['east']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = '/poselki/'.$arHighway[1]['code'].'-shosse/kupit-uchastok/';
            break;
        case 'withDom': // Дома
            $urlTeg = '/poselki/'.$arHighway[1]['code'].'-shosse/kupit-dom/';
            break;
        default: // Поселки
            $urlTeg = '/poselki/'.$arHighway[1]['code'].'-shosse/';
            break;
    }
    $arTegs['east']['url'] = $urlTeg;
}
$arTegs['south']['name'] = $arHighway[2]['name']. ' ш.';
if (!$arTegs['south']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = '/poselki/'.$arHighway[2]['code'].'-shosse/kupit-uchastok/';
            break;
        case 'withDom': // Дома
            $urlTeg = '/poselki/'.$arHighway[2]['code'].'-shosse/kupit-dom/';
            break;
        default: // Поселки
            $urlTeg = '/poselki/'.$arHighway[2]['code'].'-shosse/';
            break;
    }
    $arTegs['south']['url'] = $urlTeg;
}
$arTegs['west']['name'] = $arHighway[3]['name']. ' ш.';
if (!$arTegs['west']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = '/poselki/'.$arHighway[3]['code'].'-shosse/kupit-uchastok/';
            break;
        case 'withDom': // Дома
            $urlTeg = '/poselki/'.$arHighway[3]['code'].'-shosse/kupit-dom/';
            break;
        default: // Поселки
            $urlTeg = '/poselki/'.$arHighway[3]['code'].'-shosse/';
            break;
    }
    $arTegs['west']['url'] = $urlTeg;
}

for ($i = 10; $i < 60; $i += 10) { // до КАД
    $arTegs['mkad_' . $i]['name'] = $i . 'км от КАД';
    if (!$arTegs['mkad_' . $i]['url']) {
        switch ($domPos) {
            case 'noDom': // Участки
                $urlTeg = '/poselki/kupit-uchastok-do-' . $i . '-km-ot-kad/';
                break;
            case 'withDom': // Дома
                $urlTeg = '/poselki/kupit-dom-dachu-kottedzh-do-' . $i . '-km-ot-kad/';
                break;
            default: // Поселки
                $urlTeg = '/poselki/do-' . $i . '-km-ot-kad/';
                break;
        }
        $arTegs['mkad_' . $i]['url'] = $urlTeg;
    }
}

$arTegs['gaz']['name'] = 'С газом';
if (!$arTegs['gaz']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = "/poselki/kupit-uchastok-s-gazom/";
            break;
        case 'withDom': // Дома
            $urlTeg = "/poselki/kupit-dom-s-gazom/";
            break;
        default: // Поселки
            $urlTeg = "/poselki/s-gazom/";
            break;
    }
    $arTegs['gaz']['url'] = $urlTeg;
}

$arTegs['elektro']['name'] = 'С электричеством';
if (!$arTegs['elektro']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = "/poselki/kupit-uchastok-s-elektrichestvom/";
            break;
        case 'withDom': // Дома
            $urlTeg = "/poselki/kupit-dom-s-elektrichestvom/";
            break;
        default: // Поселки
            $urlTeg = "/poselki/s-elektrichestvom/";
            break;
    }
    $arTegs['elektro']['url'] = $urlTeg;
}

$arTegs['voda']['name'] = 'С водой';

$arTegs['izhs']['name'] = 'ИЖС';
if (!$arTegs['izhs']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = "/poselki/kupit-uchastok-izhs/";
            break;
        case 'withDom': // Дома
            $urlTeg = "/poselki/kupit-dom-izhs/";
            break;
        default: // Поселки
            $urlTeg = "/poselki/izhs/";
            break;
    }
    $arTegs['izhs']['url'] = $urlTeg;
}

$arTegs['snt']['name'] = 'СНТ';
if (!$arTegs['snt']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = "/poselki/kupit-uchastok-snt/";
            break;
        case 'withDom': // Дома
            $urlTeg = "/poselki/kupit-dom-snt/";
            break;
        default: // Поселки
            $urlTeg = "/poselki/snt/";
            break;
    }
    $arTegs['snt']['url'] = $urlTeg;
}

$arTegs['ryadom-s-lesom']['name'] = 'У леса';
if (!$arTegs['ryadom-s-lesom']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = "/poselki/kupit-uchastok-ryadom-s-lesom/";
            break;
        case 'withDom': // Дома
            $urlTeg = "/poselki/kupit-dom-ryadom-s-lesom/";
            break;
        default: // Поселки
            $urlTeg = "/poselki/ryadom-s-lesom/";
            break;
    }
    $arTegs['ryadom-s-lesom']['url'] = $urlTeg;
}

$arTegs['u-vody']['name'] = 'У воды';
if (!$arTegs['u-vody']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = "/poselki/kupit-uchastok-u-vody/";
            break;
        case 'withDom': // Дома
            $urlTeg = "/poselki/kupit-dom-u-vody/";
            break;
        default: // Поселки
            $urlTeg = "/poselki/u-vody/";
            break;
    }
    $arTegs['u-vody']['url'] = $urlTeg;
}

$arTegs['econom']['name'] = 'Эконом';
if (!$arTegs['econom']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = "/poselki/kupit-uchastok-econom-class/";
            break;
        case 'withDom': // Дома
            $urlTeg = "/poselki/kupit-dom-econom-class/";
            break;
        default: // Поселки
            $urlTeg = "/poselki/econom-class/";
            break;
    }
    $arTegs['econom']['url'] = $urlTeg;
}

$arTegs['komfort']['name'] = 'Комфорт';
if (!$arTegs['komfort']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = "/poselki/kupit-uchastok-komfort-class/";
            break;
        case 'withDom': // Дома
            $urlTeg = "/poselki/kupit-dom-komfort-class/";
            break;
        default: // Поселки
            $urlTeg = "/poselki/komfort-class/";
            break;
    }
    $arTegs['komfort']['url'] = $urlTeg;
}

$arTegs['do-1-milliona']['name'] = 'До 1 млн. руб.';
$arTegs['do-2-milliona']['name'] = 'До 2 млн. руб.';

// какие теги выводить
if (!$arTegsShow) $arTegsShow = ['north', 'east', 'south', 'west', 'mkad_30', 'mkad_50', 'gaz', 'izhs', 'snt', 'econom', 'komfort'];
// dump($arTegsShow);

if ($onlyParam) { // если не нужен url тега (3 уровень)
    // dump($arrFilter);
    $tegReq = $_REQUEST['teg'];
    switch ($tegReq) {
        case 'north':
            $arrFilter['=PROPERTY_SHOSSE'] = [$arHighway[0]['id']]; // Дмитровское
            break;
        case 'east':
            $arrFilter['=PROPERTY_SHOSSE'] = [$arHighway[1]['id']]; // Новорязанское
            break;
        case 'south':
            $arrFilter['=PROPERTY_SHOSSE'] = [$arHighway[2]['id']]; // Симферопольское
            break;
        case 'west':
            $arrFilter['=PROPERTY_SHOSSE'] = [$arHighway[3]['id']]; // Новорижское
            break;
        case 'mkad_20':
            $arrFilter['><PROPERTY_MKAD'] = [0, 30];
            break;
        case 'mkad_30':
            $arrFilter['><PROPERTY_MKAD'] = [10, 40];
            break;
        case 'mkad_50':
            $arrFilter['><PROPERTY_MKAD'] = [30, 60];
            break;
        case 'gaz':
            $arrFilter['=PROPERTY_PROVEDEN_GAZ'] = [398]; // Газ (проведен)
            break;
        case 'elektro':
            $arrFilter['=PROPERTY_ELECTRO_DONE'] = [394]; // Электричество (проведен)
            break;
        case 'voda':
            $arrFilter['=PROPERTY_PROVEDENA_VODA'] = [403]; // Водопровод (проведен)
            break;
        case 'izhs':
            $arrFilter['=PROPERTY_TYPE_USE'] = [429, 433]; // Вид разрешенного использования - ИЖС
            break;
        case 'snt':
            $arrFilter['=PROPERTY_TYPE_USE'] = [424, 430, 431, 432]; // Вид разрешенного использования - СНТ
            break;
        case 'ryadom-s-lesom':
            $arrFilter['=PROPERTY_LES'] = [454, 455, 457, 458]; // Лес
            break;
        case 'u-vody':
            $arrFilter['=PROPERTY_WATER'] = [459, 460, 461]; // Водоем
            break;
        case 'econom':
            $arrFilter['<=PROPERTY_PRICE_SOTKA'] = 100000; // Цена за сотку
            break;
        case 'komfort':
            $arrFilter['=PROPERTY_ELECTRO'] = [392]; // Электричество
            $arrFilter['=PROPERTY_ROADS_IN_VIL'] = [478, 479, 480, 482, 483, 484]; // Дороги в поселке
            $arrFilter['=PROPERTY_ARRANGE'] = [492]; // Обустройство поселка: Огорожен
            break;
    }
    // dump($arrFilter);
}
?>
<div class="tag-list d-none d-md-flex mb-1">
  <? foreach ($arTegsShow as $teg) {
    if ($arTegs[$teg]['cnt']) {
      if ($onlyParam)
        $arTegs[$teg]['url'] = $ourDir . '?teg=' . $teg;

    $activeTeg = ($ourDir == $arTegs[$teg]['url'] || $tegReq == $teg) ? 'class="active"' : '';
  ?>
    <div class="tag-list__item">
      <a href="<?= $arTegs[$teg]['url'] ?>" <?=$activeTeg?>><?=$arTegs[$teg]['name']?> <span class="text-secondary"><?= $arTegs[$teg]['cnt'] ?></span></a>
    </div>
  <?
    }
  }
  ?>
</div>
<div class="d-flex d-md-none mb-1">
    <div class="dropdown w-100">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-outline-warning rounded-pill w-100" data-toggle="modal" data-target="#modalTags">
            Уточнить поиск
        </button>

        <!-- Modal -->
        <div class="modal fade" id="modalTags" tabindex="-1" role="dialog" aria-labelledby="Уточнить поиск" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div class="text-uppercase chart" id="exampleModalLabel">Уточнить поиск</div>
                            <button type="button" class="close  btn-sm" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <? foreach ($arTegsShow as $teg) {
                            if ($arTegs[$teg]['cnt']) {
                                if ($onlyParam) {
                                    $arTegs[$teg]['url'] = $ourDir . '?teg=' . $teg;
                                }
                                $activeTeg = ($ourDir == $arTegs[$teg]['url'] || $tegReq == $teg) ? 'class="active"' : ''; ?>
                                <div class="tag-list__item">
                                    <a href="<?= $arTegs[$teg]['url'] ?>" <?= $activeTeg ?>>
                                      <?= $arTegs[$teg]['name'] ?>
                                      <span class="text-secondary"><?= $arTegs[$teg]['cnt'] ?></span>
                                    </a>
                                </div>
                                <?
                            }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
