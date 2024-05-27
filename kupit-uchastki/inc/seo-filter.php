<?
use Bitrix\Main\Grid\Declension;
$arrFilterVillage['IBLOCK_ID'] = 1;
$onlyShosse = ['dmitrovskoe','novoryazanskoe','simferopolskoe','novorijskoe','kashirskoe'];
$nameShosseDir = ['north','east','south','west'];

if ($shosse)
{
  if (!getNamesList($shosse,'SHOSSE')['ID']) {
    CHTTP::SetStatus("404 Not Found");
    @define("ERROR_404", "Y");
  }

  $arrFilterVillage['PROPERTY_SHOSSE'] = getNamesList($shosse,'SHOSSE')['ID'];

  $arNames = getNamesList($shosse,'SHOSSE');
  $APPLICATION->AddChainItem($arNames['NAME'].' шоссе','/kupit-uchastki/'.$shosse.'-shosse/',false);

  $urlAll = '/poselki/'.$shosse.'-shosse/';
  $urlNoDom = '/kupit-uchastki/'.$shosse.'-shosse/';
  $urlWithDom = '/poselki/'.$shosse.'-shosse/kupit-dom/';

  $newTitle = 'Купить участок по '.$arNames['NAME_KOMU'].' шоссе, цены';
  $newDesc = '▶Продажа земельных участков по направлению '.$arNames['NAME'].' шоссе. ▶Независимый рейтинг ▶Видео с квадрокоптера ▶Экология местности ▶Отзывы покупателей ▶Юридическая чистота ▶Стоимость коммуникаций!';
  $newH1 = 'Земельные участки по '.$arNames['NAME_KOMU'].' шоссе';

  // url для км от МКАД
  for ($i=10; $i < 60; $i+=10) { // до МКАД
    $urlTeg = '/kupit-uchastki/'.$shosse.'-shosse-do-'.$i.'-km-mkad/';
    $arTegs['mkad_'.$i]['url'] = $urlTeg;
  }
  // url для С газом
  $urlTeg = "/kupit-uchastki/".$shosse."-shosse-gaz/";
  $arTegs['gaz']['url'] = $urlTeg;

  $arNameTeg = ['gaz','voda','do-1-milliona','do-2-milliona','izhs','snt','ryadom-s-lesom','u-vody'];
  foreach ($arNameTeg as $nameTeg) {
    $urlTeg = '/kupit-uchastki/'.$shosse.'-shosse-'.$nameTeg.'/';
    $arTegs[$nameTeg]['url'] = $urlTeg;
  }

  // теги для шоссе
  $arTegsShow = ['mkad_20','mkad_30','mkad_50','gaz','voda','izhs','snt','ryadom-s-lesom','u-vody'];
}

if ($rayon)
{
  if (!getNamesList($rayon,'REGION')['ID']) {
    CHTTP::SetStatus("404 Not Found");
    @define("ERROR_404", "Y");
  }

  $arrFilterVillage['PROPERTY_REGION'] = getNamesList($rayon,'REGION')['ID'];

  $arNames = getNamesList($rayon,'REGION');
  $APPLICATION->AddChainItem($arNames['NAME'].' район','/kupit-uchastki/'.$rayon.'-rayon/',true);

  $urlAll = '/poselki/'.$rayon.'-rayon/';
  $urlNoDom = '/kupit-uchastki/'.$rayon.'-rayon/';
  $urlWithDom = '/poselki/'.$rayon.'-rayon/kupit-dom/';

  $newTitle = 'Купить участок в '.$arNames['NAME_KOM'].' районе, цены';
  $newDesc = '▶Продажа земельных участков в '.$arNames['NAME_KOM'].' районе Московской области. ▶Независимый рейтинг ▶Видео с квадрокоптера ▶Экология местности ▶Отзывы покупателей ▶Юридическая чистота ▶Стоимость коммуникаций!';
  $newH1 = 'Земельные участки в '.$arNames['NAME_KOM'].' районе';

  // url для С газом
  $urlTeg = "/kupit-uchastki/".$rayon."-rayon-gaz/";
  $arTegs['gaz']['url'] = $urlTeg;
  // теги для района
  $arTegsShow = ['gaz','izhs','snt','ryadom-s-lesom','u-vody','econom','komfort'];
}

if ($mkadKM)
{
  if(is_numeric($mkadKM))
  {
    switch ($mkadKM) {
      case $mkadKM == 10: $url_km_MKAD = "do-10-km-ot-mkad"; break;
      case $mkadKM == 15: $url_km_MKAD = "do-15-km-ot-mkad"; break;
      case $mkadKM == 20: $url_km_MKAD = "do-20-km-ot-mkad"; break;
      case $mkadKM == 25: $url_km_MKAD = "do-25-km-ot-mkad"; break;
      case $mkadKM == 30: $url_km_MKAD = "do-30-km-ot-mkad"; break;
      case $mkadKM == 35: $url_km_MKAD = "do-35-km-ot-mkad"; break;
      case $mkadKM == 40: $url_km_MKAD = "do-40-km-ot-mkad"; break;
      case $mkadKM == 45: $url_km_MKAD = "do-45-km-ot-mkad"; break;
      case $mkadKM == 50: $url_km_MKAD = "do-50-km-ot-mkad"; break;
      case $mkadKM == 55: $url_km_MKAD = "do-55-km-ot-mkad"; break;
      case $mkadKM == 60: $url_km_MKAD = "do-60-km-ot-mkad"; break;
      case $mkadKM == 65: $url_km_MKAD = "do-65-km-ot-mkad"; break;
      case $mkadKM == 70: $url_km_MKAD = "do-70-km-ot-mkad"; break;
      case $mkadKM == 75: $url_km_MKAD = "do-75-km-ot-mkad"; break;
      case $mkadKM == 80: $url_km_MKAD = "do-80-km-ot-mkad"; break;
      case $mkadKM == 100: $url_km_MKAD = "do-100-km-ot-mkad"; break;
      case $mkadKM == 120: $url_km_MKAD = "do-120-km-ot-mkad"; break;

      default: CHTTP::SetStatus("404 Not Found"); @define("ERROR_404", "Y"); break;
    }

    $mkadKM_ot = $mkadKM - 20; // от - 20
    if($mkadKM_ot < 0)$mkadKM_ot = 0;
    $mkadKM_do = $mkadKM + 10; // до + 10

    $arrFilterPlots['><PROPERTY_MKAD'] = [$mkadKM_ot,$mkadKM_do];

    $APPLICATION->AddChainItem('Участки до '.$mkadKM.' км от МКАД','',true);

    $newTitle = 'Выбрать земельный участок до '.$mkadKM.' от МКАД - Поселкино';
    $newDesc = '▶Продажа земельных участков до '.$mkadKM.' от МКАД с коммуникациями и инфраструктурой. ▶Независимый рейтинг ▶Видео с квадрокоптера ▶Экология местности ▶Отзывы покупателей ▶Юридическая чистота ▶Стоимость коммуникаций!';
    $newH1 = 'Земельные участки до '.$mkadKM.' км от МКАД';

    // url для Шоссе
    foreach ($onlyShosse as $key => $val) {
      $urlTeg = '/kupit-uchastki/'.$val.'-shosse-do-'.$mkadKM.'-km-mkad/';
      $arTegs[$nameShosseDir[$key]]['url'] = $urlTeg;
    }
    // теги для км от МКАД
    $arTegsShow = ['north','east','south','west','gaz','izhs','snt','les','voda','econom','komfort'];
  }
  else{
    CHTTP::SetStatus("404 Not Found");
    @define("ERROR_404", "Y");
  }
}

if ($priceURL) // выборка по цене
{
  if ($priceType == 'tys') { // тысячи
    $our_price = $priceURL;
    $price = $our_price * 1000;
    if($our_price < 100){
      $price_ot = $price - 50000;
      $price_do = $price + 50000;
    }elseif($our_price < 500){
      $price_ot = $price - 100000;
      $price_do = $price + 100000;
    }else{
      $price_ot = $price - 200000;
      $price_do = $price + 200000;
    }
    $nameBC = 'тыс'; $nameBCFull = $nameBCFullMln = $nameBCFullMln2 = 'тысяч';
    $priceType2 = 'tysyach';
  } else { // миллионы
    $our_price = str_replace(',','.',$priceURL);
    $price = $our_price * 1000000;
    if($our_price < 10){
      $price_ot = $price - 500000;
      $price_do = $price + 500000;
    }elseif($our_price < 15){
      $price_ot = $price - 2000000;
      $price_do = $price + 2000000;
    }else{
      $price_ot = $price - 3000000;
      $price_do = $price + 3000000;
    }
    $nameBC = $nameBCFull = 'млн'; // $nameBCFull = 'миллионов';
    $million = new Declension('миллион', 'миллиона', 'миллионов');
    $nameBCFullMln = $million->get($priceURL);
    $million2 = new Declension('миллиона', 'миллионов', 'миллионов');
    $nameBCFullMln2 = $million2->get($priceURL);
    $priceType2 = 'milliona';
  }

  // $arrFilterVillage['><PROPERTY_120'] = [$price_ot,$price_do];
  $arrFilterPlots['><PROPERTY_PRICE'] = [$price_ot,$price_do]; // для фильтрации участков

  $APPLICATION->AddChainItem('Участки за '.$priceURL.' '.$nameBC.' руб','',true);

  $newTitle = 'Купить земельный участок за '.$priceURL.' '.$nameBC.' рублей в Подмосковье';
  $newDesc = '▶Недорогие земельные участки за '.$priceURL.' '.$nameBC.' рублей в поселках Подмосковья. ▶Независимый рейтинг ▶Видео с квадрокоптера ▶Экология местности ▶Отзывы покупателей ▶Юридическая чистота ▶Стоимость коммуникаций!';
  $newH1 = 'Земельные участки за '.$priceURL.' '.$nameBC.' руб';

  // url для Шоссе
  foreach ($onlyShosse as $key => $val) {
    $urlTeg = '/kupit-uchastki/'.$val.'-shosse-do-'.$priceURL.'-'.$priceType2.'/';
    $arTegs[$nameShosseDir[$key]]['url'] = $urlTeg;
  }
  // теги для цены
  $arTegsShow = ['north','east','south','west','gaz','elektro','izhs','snt','les','voda'];
}

if ($areaUrl) // выборка по площади
{
  if (is_numeric($areaUrl)) {
    switch ($areaUrl) {
      case $areaUrl < 10:
        $area_ot = $areaUrl-1;
        $area_do = $areaUrl+1;
        break;
      case $areaUrl <= 12:
        $area_ot = $areaUrl-2;
        $area_do = $areaUrl+2;
        break;
      case $areaUrl <= 15:
        $area_ot = $areaUrl-3;
        $area_do = $areaUrl+3;
        break;
      case $areaUrl < 20:
        $area_ot = $areaUrl-4;
        $area_do = $areaUrl+4;
        break;
      case $areaUrl < 30:
        $area_ot = $areaUrl-5;
        $area_do = $areaUrl+5;
        break;
      case $areaUrl < 70:
        $area_ot = $areaUrl-10;
        $area_do = $areaUrl+10;
        break;
      case $areaUrl <= 100:
        $area_ot = $areaUrl-20;
        $area_do = $areaUrl+20;
        break;
    }
    if ($area_ot < 0) $area_ot = 0;

    // $arrFilterVillage['><PROPERTY_11'] = [$area_ot,$area_do];
    $arrFilterPlots['><PROPERTY_PLOTTAGE'] = [$area_ot,$area_do]; // для фильтрации оферов

    switch ($areaType) { // склонение
      case 'sotok':
        $nameArea = 'соток';break;
      case 'sotki':
        $nameArea = 'сотки';break;
      case 'sotkah':
        $nameArea = 'сотках';break;
    }

    $APPLICATION->AddChainItem('Участки площадью '.$areaUrl.' '.$nameArea,'',true);

    $newTitle = 'Купить земельный участок '.$areaUrl.' '.$nameArea.' - Поселкино';
    $newDesc = '▶Продажа земельных участков площадью '.$areaUrl.' '.$nameArea.' в Московской области с коммуникациями. ▶Независимый рейтинг ▶Видео с квадрокоптера ▶Экология местности ▶Отзывы покупателей ▶Юридическая чистота ▶Стоимость коммуникаций!';
    $newH1 = 'Земельные участки площадью '.$areaUrl.' '.$nameArea;

    // теги для площади
    $arTegsShow = ['north','east','south','west','gaz','izhs','snt','les','voda','econom','komfort'];
  }else{
    CHTTP::SetStatus("404 Not Found");
    @define("ERROR_404", "Y");
  }
}

if ($classCode) // выборка по классу econom / biznes / komfort / elit / premium
{
  switch ($classCode) {
    case 'econom':
      $arrFilterVillage['<=PROPERTY_8'] = 100000; // Цена за сотку
      $nameClass = 'эконом';$nameClass2 = 'Эконом';
      break;
    case 'komfort':
      $arrFilterVillage['=PROPERTY_20'] = [12]; // Электричество
      $arrFilterVillage['=PROPERTY_77'] = [59,60,61,156,158,193]; // Дороги в поселке
      $arrFilterVillage['=PROPERTY_79'] = [68]; // Обустройство поселка: Огорожен
      $nameClass = 'комфорт';$nameClass2 = 'Комфорт';
      break;
    case 'biznes':
      $arrFilterVillage['=PROPERTY_20'] = [12]; // Электричество
      $arrFilterVillage['=PROPERTY_23'] = [15]; // Газ
      $arrFilterVillage['=PROPERTY_77'] = [59,60,61,156,158,193]; // Дороги в поселке
      $arrFilterVillage['=PROPERTY_79'] = [68]; // Обустройство поселка: Огорожен
      $nameClass = 'бизнес';$nameClass2 = 'Бизнес';
      break;
    case 'elit':
      $arrFilterVillage['=PROPERTY_20'] = [12]; // Электричество
      $arrFilterVillage['=PROPERTY_23'] = [15]; // Газ
      $arrFilterVillage['=PROPERTY_26'] = [18]; // Водопровод
      $arrFilterVillage['=PROPERTY_77'] = [59,156,193]; // Дороги в поселке: Асфальт, Асф. кр., Асфальтовая крошка
      $arrFilterVillage['=PROPERTY_79'] = [67,68]; // Обустройство поселка: Охрана, Огорожен
      $arrFilterVillage['>=PROPERTY_8'] = 150000; // Цена за сотку
      $nameClass = 'элитного';$nameClass2 = 'Элитного';
      break;
    case 'premium':
      $arrFilterVillage['=PROPERTY_2'] = [4,256]; // Наличие домов
      $arrFilterVillage['>=PROPERTY_17'] = 10000000; // Стоимость домов
      $arrFilterVillage['=PROPERTY_20'] = [12]; // Электричество
      $arrFilterVillage['=PROPERTY_23'] = [15]; // Газ
      $arrFilterVillage['=PROPERTY_26'] = [18]; // Водопровод
      $arrFilterVillage['=PROPERTY_77'] = [59]; // Дороги в поселке: Асфальт
      $arrFilterVillage['=PROPERTY_79'] = [67,68]; // Обустройство поселка: Охрана, Огорожен
      $nameClass = 'премиум';$nameClass2 = 'Премиум';
      break;
    default:
      CHTTP::SetStatus("404 Not Found");
      @define("ERROR_404", "Y");
      break;
  }

  $APPLICATION->AddChainItem('Участки '.$nameClass2.' класса','',true);

  $newTitle = 'Купить земельный участок '.$nameClass2.' класса в Подмосковье';
  $newDesc = '▶Продажа земельных участков '.$nameClass2.' класса в Московской области с коммуникациями. ▶Независимый рейтинг ▶Видео с квадрокоптера ▶Экология местности ▶Отзывы покупателей ▶Юридическая чистота ▶Стоимость коммуникаций!';
  $newH1 = 'Земельные участки '.$nameClass2.' класса';

  // теги для класса
  $arTegsShow = ['north','east','south','west','mkad_20','mkad_30','mkad_50','gaz','les','voda'];
}

if ($commun) // коммуникации
{
  switch ($commun) {
    case 'elektrichestvom':
      $arrFilterVillage['=PROPERTY_21'] = [14]; // Электричество (проведен)
      $communTxt = 'с электричеством';
      $commun2 = 'svet';
      break;
    case 'vodoprovodom':
      $arrFilterVillage['=PROPERTY_27'] = [20]; // Водопровод (проведен)
      $communTxt = 'с водой';
      $commun2 = 'voda';
      break;
    case 'gazom':
      $arrFilterVillage['=PROPERTY_24'] = [17]; // Газ (проведен)
      $communTxt = 'с газом';
      $commun2 = 'gaz';
      break;
    case 'kommunikaciyami':
      $arrFilterVillage['=PROPERTY_21'] = [14]; // Электричество (проведен)
      $arrFilterVillage['=PROPERTY_24'] = [17]; // Газ (проведен)
      $communTxt = 'с коммуникациями';
      $commun2 = 'kommunikatsii';
      break;
    default:
      CHTTP::SetStatus("404 Not Found");
      @define("ERROR_404", "Y");
      break;
  }

  $APPLICATION->AddChainItem('Участки '.$communTxt,'',true);

  $newTitle = 'Купить земельный участок '.$communTxt.' в Подмосковье';
  $newDesc = '▶Продажа земельных участков '.$communTxt.' в Московской области. ▶Независимый рейтинг ▶Видео с квадрокоптера ▶Экология местности ▶Отзывы покупателей ▶Юридическая чистота ▶Стоимость коммуникаций!';
  $newH1 = 'Земельные участки '.$communTxt;

  // url для Шоссе
  foreach ($onlyShosse as $key => $val) {
    $urlTeg = '/kupit-uchastki/'.$val.'-shosse-'.$commun2.'/';
    $arTegs[$nameShosseDir[$key]]['url'] = $urlTeg;
  }
  // теги для коммуникаций
  $arTegsShow = ['north','east','south','west','mkad_20','mkad_30','mkad_50','les','voda','econom','komfort'];
}

if ($typeURL) // другие URL
{
  switch ($typeURL) {
    case 'snt':
      $arrFilterVillage['=PROPERTY_33'] = [108,150,123,162]; // Вид разрешенного использования
      $inChainItem = 'в СНТ';
      break;
    case 'izhs':
      $arrFilterVillage['=PROPERTY_33'] = [154,228]; // Вид разрешенного использования
      $inChainItem = 'под ИЖС';
      break;
    case 'ryadom-s-lesom':
      $arrFilterVillage['=PROPERTY_45'] = [35,36,37,38]; // Лес
      $inChainItem = 'рядом с лесом';
      break;
    case 'u-vody':
      $arrFilterVillage['=PROPERTY_47'] = [39,40,41]; // Водоем
      $inChainItem = 'у воды';
      break;
    case 'u-ozera':
      $arrFilterVillage['=PROPERTY_47'] = [40]; // Водоем = Озеро
      $inChainItem = 'У озера';
      break;
    case 'u-reki':
      $arrFilterVillage['=PROPERTY_47'] = [39]; // Водоем = Река
      $inChainItem = 'У реки';
      break;
    case 'ryadom-zhd-stanciya':
      $arrFilterVillage['<=PROPERTY_71'] = 5; // Ближайшая ж/д станция расстояние до поселка, км
      $inChainItem = 'рядом с Ж/Д станцией';
      break;
    case 'ryadom-avtobusnaya-ostanovka':
      $arrFilterVillage['<=PROPERTY_67'] = 3; // Автобус (расстояние от остановки, км)
      $inChainItem = 'Рядом автобусная остановка';
      break;
    default:
      CHTTP::SetStatus("404 Not Found");
      @define("ERROR_404", "Y");
      break;
  }

  $APPLICATION->AddChainItem('Участки '.$inChainItem,'',true);

  $newTitle = 'Купить земельный участок '.$inChainItem.' в Подмосковье';
  $newDesc = '▶Продажа земельных участков '.$inChainItem.' в Московской области. ▶Независимый рейтинг ▶Видео с квадрокоптера ▶Экология местности ▶Отзывы покупателей ▶Юридическая чистота ▶Стоимость коммуникаций!';
  $newH1 = 'Земельные участки '.$inChainItem;

  // теги для ВРИ
  if($typeURL == 'snt' || $typeURL == 'izhs'){
    if($typeURL == 'izhs'){
      // url для км от МКАД
      for ($i=10; $i < 60; $i+=10) { // до МКАД
        $urlTeg = '/kupit-uchastki/do-'.$i.'-km-mkad-izhs/';
        $arTegs['mkad_'.$i]['url'] = $urlTeg;
      }
    }
    $arTegsShow = ['north','east','south','west','mkad_30','mkad_50','gaz','les','voda','econom','komfort'];
  }
}
?>
