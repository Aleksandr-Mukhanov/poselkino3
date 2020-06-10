<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
// dump($arTegs);
// получим наши поселки
$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>1,"ACTIVE"=>"Y");
if($arrFilter)array_push($arFilter,$arrFilter); // dump($arrFilter);
$arSelect = Array("ID","PROPERTY_5","PROPERTY_6","PROPERTY_PROVEDEN_GAZ","PROPERTY_ELECTRO_DONE","PROPERTY_33","PROPERTY_45","PROPERTY_47","PROPERTY_8","PROPERTY_20","PROPERTY_77","PROPERTY_79");
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while($arElement = $rsElements->GetNext()){ // dump($arElement);

  if(!$shosse){// шоссе
    if(array_key_exists(179,$arElement['PROPERTY_5_VALUE'])){ // Дмитровское - север
      $arTegs['north']['cnt'] += 1;
    }
    if(array_key_exists(191,$arElement['PROPERTY_5_VALUE'])){ // Новорязанское - восток
      $arTegs['east']['cnt'] += 1;
    }
    if(array_key_exists(129,$arElement['PROPERTY_5_VALUE'])){ // Симферопольское - юг
      $arTegs['south']['cnt'] += 1;
    }
    if(array_key_exists(205,$arElement['PROPERTY_5_VALUE'])){ // Новорижское - запад
      $arTegs['west']['cnt'] += 1;
    }
  }

  for ($i=10; $i < 60; $i+=10) { // до МКАД
    if($arElement['PROPERTY_6_VALUE'] >= $i-20 && $arElement['PROPERTY_6_VALUE'] <= $i+10){ // До xx км от Москвы
      $arTegs['mkad_'.$i]['cnt'] += 1;
    }
  }

  if($arElement['PROPERTY_PROVEDEN_GAZ_ENUM_ID'] == 17){ // Газ (проведен)
    $arTegs['gaz']['cnt'] += 1;
  }

  if($arElement['PROPERTY_ELECTRO_DONE_ENUM_ID'] == 14){ // Электричество (проведен)
    $arTegs['elektro']['cnt'] += 1;
  }

  if(in_array($arElement['PROPERTY_33_ENUM_ID'],[154,228])){ // Вид разрешенного использования - ИЖС
    $arTegs['izhs']['cnt'] += 1;
  }elseif(in_array($arElement['PROPERTY_33_ENUM_ID'],[108,150,123,162])){ // Вид разрешенного использования - СНТ
    $arTegs['snt']['cnt'] += 1;
  }

  if(in_array($arElement['PROPERTY_45_ENUM_ID'],[35,36,37,38])){ // Лес
    $arTegs['les']['cnt'] += 1;
  }

  foreach ($arElement['PROPERTY_47_VALUE'] as $key => $value) { // Водоем
    if(in_array($key,[39,40,41])){
      $arTegs['voda']['cnt'] += 1; break;
    }
  }

  // определим класс
  if($arElement['PROPERTY_8_VALUE'][0] && $arElement['PROPERTY_8_VALUE'][0] <= 100000){ // эконом
    $arTegs['econom']['cnt'] += 1;
  }

  $dorogiKomfort = [59,60,61,156,158,193]; // комфорт - Дороги в поселке
  if($arElement['PROPERTY_20_ENUM_ID'] == 12 && in_array($arElement['PROPERTY_77_ENUM_ID'],$dorogiKomfort) && array_key_exists(68,$arElement['PROPERTY_79_VALUE'])){ // 12 - Электричество, 68 - Обустройство поселка: Огорожен
    $arTegs['komfort']['cnt'] += 1;
  }

} // dump($arTegs);

// формируем мультитеги
// шоссе
$arTegs['north']['name'] = 'Дмитровское ш.';
if(!$arTegs['north']['url']){
  switch ($domPos) {
    case 'noDom': // Участки
      $urlTeg = '/poselki/dmitrovskoe-shosse/kupit-uchastok/';
      break;
    case 'withDom': // Дома
      $urlTeg = '/poselki/dmitrovskoe-shosse/kupit-dom/';
      break;
    default: // Поселки
      $urlTeg = '/poselki/dmitrovskoe-shosse/';
      break;
  }
  $arTegs['north']['url'] = $urlTeg;
}
$arTegs['east']['name'] = 'Новорязанское ш.';
if(!$arTegs['east']['url']){
  switch ($domPos) {
    case 'noDom': // Участки
      $urlTeg = '/poselki/novoryazanskoe-shosse/kupit-uchastok/';
      break;
    case 'withDom': // Дома
      $urlTeg = '/poselki/novoryazanskoe-shosse/kupit-dom/';
      break;
    default: // Поселки
      $urlTeg = '/poselki/novoryazanskoe-shosse/';
      break;
  }
  $arTegs['east']['url'] = $urlTeg;
}
$arTegs['south']['name'] = 'Симферопольское ш.';
if(!$arTegs['south']['url']){
  switch ($domPos) {
    case 'noDom': // Участки
      $urlTeg = '/poselki/simferopolskoe-shosse/kupit-uchastok/';
      break;
    case 'withDom': // Дома
      $urlTeg = '/poselki/simferopolskoe-shosse/kupit-dom/';
      break;
    default: // Поселки
      $urlTeg = '/poselki/simferopolskoe-shosse/';
      break;
  }
  $arTegs['south']['url'] = $urlTeg;
}
$arTegs['west']['name'] = 'Новорижское ш.';
if(!$arTegs['west']['url']){
  switch ($domPos) {
    case 'noDom': // Участки
      $urlTeg = '/poselki/novorijskoe-shosse/kupit-uchastok/';
      break;
    case 'withDom': // Дома
      $urlTeg = '/poselki/novorijskoe-shosse/kupit-dom/';
      break;
    default: // Поселки
      $urlTeg = '/poselki/novorijskoe-shosse/';
      break;
  }
  $arTegs['west']['url'] = $urlTeg;
}

for ($i=10; $i < 60; $i+=10) { // до МКАД
  $arTegs['mkad_'.$i]['name'] = $i.'км от МКАД';
  if(!$arTegs['mkad_'.$i]['url']){
    switch ($domPos) {
      case 'noDom': // Участки
        $urlTeg = '/poselki/kupit-uchastok-do-'.$i.'-km-ot-mkad/';
        break;
      case 'withDom': // Дома
        $urlTeg = '/poselki/kupit-dom-dachu-kottedzh-do-'.$i.'-km-ot-mkad/';
        break;
      default: // Поселки
        $urlTeg = '/poselki/do-'.$i.'-km-ot-mkad/';
        break;
    }
    $arTegs['mkad_'.$i]['url'] = $urlTeg;
  }
}

$arTegs['gaz']['name'] = 'С газом';
if(!$arTegs['gaz']['url']){
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
if(!$arTegs['elektro']['url']){
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

$arTegs['izhs']['name'] = 'ИЖС';
if(!$arTegs['izhs']['url']){
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
if(!$arTegs['snt']['url']){
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

$arTegs['les']['name'] = 'У леса';
if(!$arTegs['les']['url']){
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
  $arTegs['les']['url'] = $urlTeg;
}

$arTegs['voda']['name'] = 'У воды';
if(!$arTegs['voda']['url']){
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
  $arTegs['voda']['url'] = $urlTeg;
  // $arTegs['voda']['url'] = $ourDir.'?teg=voda';
}

$arTegs['econom']['name'] = 'Эконом';
if(!$arTegs['econom']['url']){
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
if(!$arTegs['komfort']['url']){
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

// какие теги выводить
if (!$arTegsShow) $arTegsShow = ['north','east','south','west','mkad_30','mkad_50','gaz','izhs','snt','econom','komfort'];
// dump($arTegsShow);

if($onlyParam){ // если не нужен url тега (3 уровень)
  // dump($arrFilter);
  $tegReq = $_REQUEST['teg'];
  switch ($tegReq) {
    case 'north':
      $arrFilter['=PROPERTY_5'] = [179]; // Дмитровское
      break;
    case 'east':
      $arrFilter['=PROPERTY_5'] = [191]; // Новорязанское
      break;
    case 'south':
      $arrFilter['=PROPERTY_5'] = [129]; // Симферопольское
      break;
    case 'west':
      $arrFilter['=PROPERTY_5'] = [205]; // Новорижское
      break;
    case 'mkad_20':
      $arrFilter['><PROPERTY_6'] = [0,30];
      break;
    case 'mkad_30':
      $arrFilter['><PROPERTY_6'] = [10,40];
      break;
    case 'mkad_50':
      $arrFilter['><PROPERTY_6'] = [30,60];
      break;
    case 'gaz':
      $arrFilter['=PROPERTY_24'] = [17]; // Газ (проведен)
      break;
    case 'elektro':
      $arrFilter['=PROPERTY_21'] = [14]; // Электричество (проведен)
      break;
    case 'izhs':
      $arrFilter['=PROPERTY_33'] = [154,228]; // Вид разрешенного использования - ИЖС
      break;
    case 'snt':
      $arrFilter['=PROPERTY_33'] = [108,150,123,162]; // Вид разрешенного использования - СНТ
      break;
    case 'les':
      $arrFilter['=PROPERTY_45'] = [35,36,37,38]; // Лес
      break;
    case 'voda':
      $arrFilter['=PROPERTY_47'] = [39,40,41]; // Водоем
      break;
    case 'econom':
      $arrFilter['<=PROPERTY_8'] = 100000; // Цена за сотку
      break;
    case 'komfort':
      $arrFilter['=PROPERTY_20'] = [12]; // Электричество
      $arrFilter['=PROPERTY_77'] = [59,60,61,156,158,193]; // Дороги в поселке
      $arrFilter['=PROPERTY_79'] = [68]; // Обустройство поселка: Огорожен
      break;
  }
  // dump($arrFilter);
}
?>
<div class="tag-list">
<?foreach ($arTegsShow as $teg) {
  if($arTegs[$teg]['cnt']){
    if($onlyParam){
      $arTegs[$teg]['url'] = $ourDir.'?teg='.$teg;
    }
    $activeTeg = ($ourDir == $arTegs[$teg]['url'] || $tegReq == $teg) ? 'class="active"' : '';?>
    <div class="tag-list__item">
      <a href="<?=$arTegs[$teg]['url']?>" <?=$activeTeg?>><?=$arTegs[$teg]['name']?> <span class="text-secondary"><?=$arTegs[$teg]['cnt']?></span></a>
    </div>
<?}
}?>
</div>
