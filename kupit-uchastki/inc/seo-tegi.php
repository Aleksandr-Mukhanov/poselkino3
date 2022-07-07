<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
// dump($arTegs);

// получим участки
// $arOrder = Array("SORT"=>"ASC");
// $arFilterPlotsAll = Array("IBLOCK_ID"=>5,"ACTIVE"=>"Y");
// $arSelect = Array("ID","PROPERTY_VILLAGE");
// $rsElements = CIBlockElement::GetList($arOrder,$arFilterPlotsAll,false,false,$arSelect);
// while ($arElement = $rsElements->Fetch())
// {
//   $arVillageIDs_tags[] = $arElement['PROPERTY_VILLAGE_VALUE'];
// }
//
// $arVillageIDs_tags = array_unique($arVillageIDs_tags);

// получим наши поселки
$arOrder = Array("SORT" => "ASC");
$arFilterVillageTags = Array("IBLOCK_ID" => 1, "ACTIVE" => "Y", "ID" => $arVillageIDs_tags);
if ($arrFilterVillage) array_push($arFilterVillageTags, $arrFilterVillage);
$arSelect = Array("ID", "PROPERTY_5", "PROPERTY_6", "PROPERTY_PROVEDEN_GAZ", "PROPERTY_ELECTRO_DONE",'PROPERTY_PROVEDENA_VODA', "PROPERTY_33", "PROPERTY_45", "PROPERTY_47", "PROPERTY_8", "PROPERTY_20", "PROPERTY_77", "PROPERTY_79");
$rsElements = CIBlockElement::GetList($arOrder, $arFilterVillageTags, false, false, $arSelect);
while ($arElement = $rsElements->GetNext()) { // dump($arElement);

    if (!$shosse) {// шоссе
        if (array_key_exists(179, $arElement['PROPERTY_5_VALUE'])) { // Дмитровское - север
            $arTegs['north']['cnt'] += 1;
            $arTegs['north']['villages'][] = $arElement['ID'];
        }
        if (array_key_exists(191, $arElement['PROPERTY_5_VALUE'])) { // Новорязанское - восток
            $arTegs['east']['cnt'] += 1;
            $arTegs['east']['villages'][] = $arElement['ID'];
        }
        if (array_key_exists(129, $arElement['PROPERTY_5_VALUE'])) { // Симферопольское - юг
            $arTegs['south']['cnt'] += 1;
            $arTegs['south']['villages'][] = $arElement['ID'];
        }
        if (array_key_exists(205, $arElement['PROPERTY_5_VALUE'])) { // Новорижское - запад
            $arTegs['west']['cnt'] += 1;
            $arTegs['west']['villages'][] = $arElement['ID'];
        }
    }

    for ($i = 10; $i < 60; $i += 10) { // до МКАД
        if ($arElement['PROPERTY_6_VALUE'] >= $i - 20 && $arElement['PROPERTY_6_VALUE'] <= $i + 10) { // До xx км от Москвы
            $arTegs['mkad_' . $i]['cnt'] += 1;
            $arTegs['mkad_' . $i]['villages'][] = $arElement['ID'];
        }
    }

    if ($arElement['PROPERTY_PROVEDEN_GAZ_ENUM_ID'] == 17) { // Газ (проведен)
        $arTegs['gaz']['cnt'] += 1;
        $arTegs['gaz']['villages'][] = $arElement['ID'];
    }

    if ($arElement['PROPERTY_ELECTRO_DONE_ENUM_ID'] == 14) { // Электричество (проведен)
        $arTegs['elektro']['cnt'] += 1;
        $arTegs['elektro']['villages'][] = $arElement['ID'];
    }

    if ($arElement['PROPERTY_PROVEDENA_VODA_ENUM_ID'] == 20) // Водопровод (проведен)
    {
        $arTegs['voda']['cnt'] += 1;
        $arTegs['voda']['villages'][] = $arElement['ID'];
    }

    if (in_array($arElement['PROPERTY_33_ENUM_ID'], [154, 228])) { // Вид разрешенного использования - ИЖС
        $arTegs['izhs']['cnt'] += 1;
        $arTegs['izhs']['villages'][] = $arElement['ID'];
    } elseif (in_array($arElement['PROPERTY_33_ENUM_ID'], [108, 150, 123, 162])) { // Вид разрешенного использования - СНТ
        $arTegs['snt']['cnt'] += 1;
        $arTegs['snt']['villages'][] = $arElement['ID'];
    }

    if (in_array($arElement['PROPERTY_45_ENUM_ID'], [35, 36, 37, 38])) { // Лес
        $arTegs['ryadom-s-lesom']['cnt'] += 1;
        $arTegs['ryadom-s-lesom']['villages'][] = $arElement['ID'];
    }

    foreach ($arElement['PROPERTY_47_VALUE'] as $key => $value) { // Водоем
        if (in_array($key, [39, 40, 41])) {
            $arTegs['u-vody']['cnt'] += 1;
            $arTegs['u-vody']['villages'][] = $arElement['ID'];
            break;
        }
    }

    // определим класс
    if ($arElement['PROPERTY_8_VALUE'][0] && $arElement['PROPERTY_8_VALUE'][0] <= 100000) { // эконом
        $arTegs['econom']['cnt'] += 1;
        $arTegs['econom']['villages'][] = $arElement['ID'];
    }

    $dorogiKomfort = [59, 60, 61, 156, 158, 193]; // комфорт - Дороги в поселке
    if ($arElement['PROPERTY_20_ENUM_ID'] == 12 && in_array($arElement['PROPERTY_77_ENUM_ID'], $dorogiKomfort) && array_key_exists(68, $arElement['PROPERTY_79_VALUE'])) { // 12 - Электричество, 68 - Обустройство поселка: Огорожен
        $arTegs['komfort']['cnt'] += 1;
        $arTegs['komfort']['villages'][] = $arElement['ID'];
    }

} // dump($arTegs);

// формируем мультитеги
// шоссе
$arTegs['north']['name'] = 'Дмитровское ш.';
if (!$arTegs['north']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = '/kupit-uchastki/dmitrovskoe-shosse/kupit-uchastok/';
            break;
        case 'withDom': // Дома
            $urlTeg = '/kupit-uchastki/dmitrovskoe-shosse/kupit-dom/';
            break;
        default: // Поселки
            $urlTeg = '/kupit-uchastki/dmitrovskoe-shosse/';
            break;
    }
    $arTegs['north']['url'] = $urlTeg;
}
$arTegs['east']['name'] = 'Новорязанское ш.';
if (!$arTegs['east']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = '/kupit-uchastki/novoryazanskoe-shosse/kupit-uchastok/';
            break;
        case 'withDom': // Дома
            $urlTeg = '/kupit-uchastki/novoryazanskoe-shosse/kupit-dom/';
            break;
        default: // Поселки
            $urlTeg = '/kupit-uchastki/novoryazanskoe-shosse/';
            break;
    }
    $arTegs['east']['url'] = $urlTeg;
}
$arTegs['south']['name'] = 'Симферопольское ш.';
if (!$arTegs['south']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = '/kupit-uchastki/simferopolskoe-shosse/kupit-uchastok/';
            break;
        case 'withDom': // Дома
            $urlTeg = '/kupit-uchastki/simferopolskoe-shosse/kupit-dom/';
            break;
        default: // Поселки
            $urlTeg = '/kupit-uchastki/simferopolskoe-shosse/';
            break;
    }
    $arTegs['south']['url'] = $urlTeg;
}
$arTegs['west']['name'] = 'Новорижское ш.';
if (!$arTegs['west']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = '/kupit-uchastki/novorijskoe-shosse/kupit-uchastok/';
            break;
        case 'withDom': // Дома
            $urlTeg = '/kupit-uchastki/novorijskoe-shosse/kupit-dom/';
            break;
        default: // Поселки
            $urlTeg = '/kupit-uchastki/novorijskoe-shosse/';
            break;
    }
    $arTegs['west']['url'] = $urlTeg;
}

for ($i = 10; $i < 60; $i += 10) { // до МКАД
    $arTegs['mkad_' . $i]['name'] = $i . 'км от МКАД';
    if (!$arTegs['mkad_' . $i]['url']) {
        switch ($domPos) {
            case 'noDom': // Участки
                $urlTeg = '/kupit-uchastki/kupit-uchastok-do-' . $i . '-km-ot-mkad/';
                break;
            case 'withDom': // Дома
                $urlTeg = '/kupit-uchastki/kupit-dom-dachu-kottedzh-do-' . $i . '-km-ot-mkad/';
                break;
            default: // Поселки
                $urlTeg = '/kupit-uchastki/do-' . $i . '-km-ot-mkad/';
                break;
        }
        $arTegs['mkad_' . $i]['url'] = $urlTeg;
    }
}

$arTegs['gaz']['name'] = 'С газом';
if (!$arTegs['gaz']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = "/kupit-uchastki/kupit-uchastok-s-gazom/";
            break;
        case 'withDom': // Дома
            $urlTeg = "/kupit-uchastki/kupit-dom-s-gazom/";
            break;
        default: // Поселки
            $urlTeg = "/kupit-uchastki/uchastki-s-gazom/";
            break;
    }
    $arTegs['gaz']['url'] = $urlTeg;
}

$arTegs['elektro']['name'] = 'С электричеством';
if (!$arTegs['elektro']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = "/kupit-uchastki/kupit-uchastok-s-elektrichestvom/";
            break;
        case 'withDom': // Дома
            $urlTeg = "/kupit-uchastki/kupit-dom-s-elektrichestvom/";
            break;
        default: // Поселки
            $urlTeg = "/kupit-uchastki/s-elektrichestvom/";
            break;
    }
    $arTegs['elektro']['url'] = $urlTeg;
}

$arTegs['voda']['name'] = 'С водой';

$arTegs['izhs']['name'] = 'под ИЖС';
if (!$arTegs['izhs']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = "/kupit-uchastki/kupit-uchastok-izhs/";
            break;
        case 'withDom': // Дома
            $urlTeg = "/kupit-uchastki/kupit-dom-izhs/";
            break;
        default: // Поселки
            $urlTeg = "/kupit-uchastki/uchastki-izhs/";
            break;
    }
    $arTegs['izhs']['url'] = $urlTeg;
}

$arTegs['snt']['name'] = 'в СНТ';
if (!$arTegs['snt']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = "/kupit-uchastki/kupit-uchastok-snt/";
            break;
        case 'withDom': // Дома
            $urlTeg = "/kupit-uchastki/kupit-dom-snt/";
            break;
        default: // Поселки
            $urlTeg = "/kupit-uchastki/uchastki-snt/";
            break;
    }
    $arTegs['snt']['url'] = $urlTeg;
}

$arTegs['ryadom-s-lesom']['name'] = 'У леса';
if (!$arTegs['ryadom-s-lesom']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = "/kupit-uchastki/kupit-uchastok-ryadom-s-lesom/";
            break;
        case 'withDom': // Дома
            $urlTeg = "/kupit-uchastki/kupit-dom-ryadom-s-lesom/";
            break;
        default: // Поселки
            $urlTeg = "/kupit-uchastki/ryadom-s-lesom/";
            break;
    }
    $arTegs['ryadom-s-lesom']['url'] = $urlTeg;
}

$arTegs['u-vody']['name'] = 'У воды';
if (!$arTegs['u-vody']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = "/kupit-uchastki/kupit-uchastok-u-vody/";
            break;
        case 'withDom': // Дома
            $urlTeg = "/kupit-uchastki/kupit-dom-u-vody/";
            break;
        default: // Поселки
            $urlTeg = "/kupit-uchastki/u-vody/";
            break;
    }
    $arTegs['u-vody']['url'] = $urlTeg;
}

$arTegs['econom']['name'] = 'Эконом';
if (!$arTegs['econom']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = "/kupit-uchastki/kupit-uchastok-econom-class/";
            break;
        case 'withDom': // Дома
            $urlTeg = "/kupit-uchastki/kupit-dom-econom-class/";
            break;
        default: // Поселки
            $urlTeg = "/kupit-uchastki/uchastki-econom-class/";
            break;
    }
    $arTegs['econom']['url'] = $urlTeg;
}

$arTegs['komfort']['name'] = 'Комфорт';
if (!$arTegs['komfort']['url']) {
    switch ($domPos) {
        case 'noDom': // Участки
            $urlTeg = "/kupit-uchastki/kupit-uchastok-komfort-class/";
            break;
        case 'withDom': // Дома
            $urlTeg = "/kupit-uchastki/kupit-dom-komfort-class/";
            break;
        default: // Поселки
            $urlTeg = "/kupit-uchastki/uchastki-komfort-class/";
            break;
    }
    $arTegs['komfort']['url'] = $urlTeg;
}

// какие теги выводить
if (!$arTegsShow) $arTegsShow = ['north', 'east', 'south', 'west', 'mkad_30', 'mkad_50', 'gaz', 'izhs', 'snt', 'econom', 'komfort'];
// dump($arTegsShow);

if ($onlyParam) { // если не нужен url тега (3 уровень)
    // dump($arrFilterVillage);
    $tegReq = $_REQUEST['teg'];
    switch ($tegReq) {
        case 'north':
            $arrFilterVillage['=PROPERTY_5'] = [179]; // Дмитровское
            break;
        case 'east':
            $arrFilterVillage['=PROPERTY_5'] = [191]; // Новорязанское
            break;
        case 'south':
            $arrFilterVillage['=PROPERTY_5'] = [129]; // Симферопольское
            break;
        case 'west':
            $arrFilterVillage['=PROPERTY_5'] = [205]; // Новорижское
            break;
        case 'mkad_20':
            $arrFilterVillage['><PROPERTY_6'] = [0, 30];
            break;
        case 'mkad_30':
            $arrFilterVillage['><PROPERTY_6'] = [10, 40];
            break;
        case 'mkad_50':
            $arrFilterVillage['><PROPERTY_6'] = [30, 60];
            break;
        case 'gaz':
            $arrFilterVillage['=PROPERTY_24'] = [17]; // Газ (проведен)
            break;
        case 'elektro':
            $arrFilterVillage['=PROPERTY_21'] = [14]; // Электричество (проведен)
            break;
        case 'voda':
            $arrFilterVillage['=PROPERTY_27'] = [20]; // Водопровод (проведен)
            break;
        case 'izhs':
            $arrFilterVillage['=PROPERTY_33'] = [154, 228]; // Вид разрешенного использования - ИЖС
            break;
        case 'snt':
            $arrFilterVillage['=PROPERTY_33'] = [108, 150, 123, 162]; // Вид разрешенного использования - СНТ
            break;
        case 'ryadom-s-lesom':
            $arrFilterVillage['=PROPERTY_45'] = [35, 36, 37, 38]; // Лес
            break;
        case 'u-vody':
            $arrFilterVillage['=PROPERTY_47'] = [39, 40, 41]; // Водоем
            break;
        case 'econom':
            $arrFilterVillage['<=PROPERTY_8'] = 100000; // Цена за сотку
            break;
        case 'komfort':
            $arrFilterVillage['=PROPERTY_20'] = [12]; // Электричество
            $arrFilterVillage['=PROPERTY_77'] = [59, 60, 61, 156, 158, 193]; // Дороги в поселке
            $arrFilterVillage['=PROPERTY_79'] = [68]; // Обустройство поселка: Огорожен
            break;
    }
    // dump($arrFilterVillage);
}
?>
<div class="tag-list d-none d-md-flex mb-1">
    <? foreach ($arTegsShow as $teg) {
        if ($arTegs[$teg]['cnt']) {
            if ($onlyParam) {
                $arTegs[$teg]['url'] = $ourDir . '?teg=' . $teg;
            }
            // подсчитаем участки у поселков
            foreach ($arTegs[$teg]['villages'] as $villageID)
              $villagePlotsCnt[] = count($arVillagePlots[$villageID]);
            $arTagsPotsCnt = array_sum($villagePlotsCnt);
            unset($villagePlotsCnt);

            $activeTeg = ($ourDir == $arTegs[$teg]['url'] || $tegReq == $teg) ? 'class="active"' : ''; ?>
            <div class="tag-list__item">
                <a href="<?= $arTegs[$teg]['url'] ?>" <?= $activeTeg ?>><?= $arTegs[$teg]['name'] ?> <span
                            class="text-secondary"><?= $arTagsPotsCnt ?></span></a>
            </div>
        <?
        }
    } ?>
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

                                // подсчитаем участки у поселков
                                foreach ($arTegs[$teg]['villages'] as $villageID)
                                  $villagePlotsCnt[] = count($arVillagePlots[$villageID]);
                                $arTagsPotsCnt = array_sum($villagePlotsCnt);
                                unset($villagePlotsCnt);

                                $activeTeg = ($ourDir == $arTegs[$teg]['url'] || $tegReq == $teg) ? 'class="active"' : ''; ?>
                                <div class="tag-list__item">
                                    <a href="<?= $arTegs[$teg]['url'] ?>" <?= $activeTeg ?>><?= $arTegs[$teg]['name'] ?> <span
                                                class="text-secondary"><?= $arTagsPotsCnt ?></span></a>
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
