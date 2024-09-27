<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Grid\Declension;
$onlyShosse = ['moskovskoe','kievskoe','novopriozerskoe','murmanskoe'];
$nameShosseDir = ['north','east','south','west'];

global $arrFilter;

if ($shosse) { // шоссе
  if(!getNamesList($shosse,ROAD_CODE)['ID']){
    CHTTP::SetStatus("404 Not Found");
    @define("ERROR_404", "Y");
  }
  $arrFilter['=PROPERTY_'.ROAD_CODE][] = getNamesList($shosse,ROAD_CODE)['ID'];
  $arNames = getNamesList($shosse,ROAD_CODE);
  $UF_Code = $shosse;
  $APPLICATION->AddChainItem($arNames['NAME'].' шоссе',"/poselki/".$shosse."-shosse/",true);
  $urlAll = '/poselki/'.$shosse.'-shosse/';
  $urlNoDom = '/kupit-uchastki/'.$shosse.'-shosse/';
  $urlWithDom = '/poselki/'.$shosse.'-shosse/kupit-dom/';
  if ($pagen) $pageTitleDesc = 'Поселки '.$arNames['NAME'].' шоссе'; // если пагинация

  // url для км от МКАД
  for ($i=10; $i < 60; $i+=10) { // до МКАД
    switch ($domPos) {
      case 'noDom': // Участки
        $urlTeg = '/kupit-uchastki/'.$shosse.'-shosse-do-'.$i.'-km-mkad/';
        break;
      case 'withDom': // Дома
        $urlTeg = '/poselki/kupit-dom/'.$shosse.'-shosse-do-'.$i.'-km-mkad/';
        break;
      default: // Поселки
        $urlTeg = '/poselki/'.$shosse.'-shosse-do-'.$i.'-km-mkad/';
        break;
    }
    $arTegs['mkad_'.$i]['url'] = $urlTeg;
  }

  $arNameTeg = ['gaz','voda','do-1-milliona','do-2-milliona','izhs','snt','ryadom-s-lesom','u-vody'];
  foreach ($arNameTeg as $nameTeg) {
    switch ($domPos) {
      case 'noDom': // Участки
        $urlTeg = '/kupit-uchastki/'.$shosse.'-shosse-'.$nameTeg.'/';
        break;
      case 'withDom': // Дома
        $urlTeg = '/poselki/kupit-dom/'.$shosse.'-shosse-'.$nameTeg.'/';
        break;
      default: // Поселки
        $urlTeg = '/poselki/'.$shosse.'-shosse-'.$nameTeg.'/';
        break;
    }
    if (!$domPos) $urlTeg = str_replace('/poselki/','/kupit-uchastki/',$urlTeg); // у поселков нет
    $arTegs[$nameTeg]['url'] = $urlTeg;
  }

  // теги для шоссе
  $arTegsShow = ['mkad_20','mkad_30','mkad_50','gaz','voda','izhs','snt','ryadom-s-lesom','u-vody'];
  array_push($arTegsShow,'do-1-milliona','do-2-milliona'); // было только участки и дома
}

if ($rayon) { // район
  if(!getNamesList($rayon,REGION_CODE)['ID']){
    CHTTP::SetStatus("404 Not Found");
    @define("ERROR_404", "Y");
  }
  $arrFilter['=PROPERTY_'.REGION_CODE][] = getNamesList($rayon,REGION_CODE)['ID'];
  $arNames = getNamesList($rayon,REGION_CODE);
  $UF_Code = $rayon;
  $APPLICATION->AddChainItem($arNames['NAME'].' район',"/poselki/".$rayon."-rayon/",true);
  $urlAll = '/poselki/'.$rayon.'-rayon/';
  $urlNoDom = '/kupit-uchastki/'.$rayon.'-rayon/';
  $urlWithDom = '/poselki/'.$rayon.'-rayon/kupit-dom/';
  if ($pagen) $pageTitleDesc = $arNames['NAME'].' район поселки'; // если пагинация

  // url для С газом
  switch ($domPos) {
    case 'noDom': // Участки
      $urlTeg = "/kupit-uchastki/".$rayon."-rayon-gaz/";
      break;
    case 'withDom': // Дома
      $urlTeg = "/poselki/kupit-dom/".$rayon."-rayon-gaz/";
      break;
    default: // Поселки
      $urlTeg = "/poselki/".$rayon."-rayon-gaz/";
      break;
  }
  $arTegs['gaz']['url'] = $urlTeg;

  // url для СНТ
  switch ($domPos) {
    case 'noDom': // Участки
      $urlTeg = "/poselki/kupit-uchastok-snt-".$rayon."-rayon/";
      break;
    case 'withDom': // Дома
      $urlTeg = "/poselki/kupit-dom-snt-".$rayon."-rayon/";
      break;
    default: // Поселки
      $urlTeg = "/poselki/".$rayon."-rayon-snt/";
      break;
  }
  $arTegs['snt']['url'] = $urlTeg;

  // теги для района
  $arTegsShow = ['gaz','izhs','snt','ryadom-s-lesom','u-vody','econom','komfort'];
}

if ($typePos) { // выбор по типу
  switch ($typePos) {
    case 'dachnye':
      $arrFilter['=PROPERTY_TYPE'] = [PROP_DACHA];
      $nameType = 'Дачные';
      $urlNoDom = '/poselki/kupit-dachnyj-uchastok/';
      $urlWithDom = '/poselki/kupit-dachnyj-dom/';
      break;
    case 'kottedzhnye':
      $arrFilter['=PROPERTY_TYPE'] = [PROP_COTTAGE];
      $nameType = 'Коттеджные';
      $urlNoDom = '/poselki/kupit-kottedzhnyj-uchastok/';
      $urlWithDom = '/poselki/kupit-kottedzh/';
      break;
    default:
      CHTTP::SetStatus("404 Not Found");
      @define("ERROR_404", "Y");
      break;
  }
  $UF_Code = $typePos;
  $APPLICATION->AddChainItem($nameType.' поселки',"/poselki/".$typePos."/",true);
  $urlAll = '/poselki/'.$typePos.'/';
  if ($pagen) $pageTitleDesc = $nameType.' поселки'; // если пагинация
}

if ($domPos) { // если выбор с домом или без
  switch ($domPos) {
    case 'noDom':
      $arrFilter['=PROPERTY_DOMA'] = [PROP_NO_DOM,PROP_HOUSE_PLOT];
      $UF_Code = 'kupit-uchastok';
      $propFilter = 'PROPERTY_COST_LAND_IN_CART';
      $nameDomPos = 'Купить участок';
      $APPLICATION->AddChainItem('Участки',"/kupit-uchastki/",true);
      break;
    case 'withDom':
      $arrFilter['=PROPERTY_DOMA'] = [PROP_WITH_DOM,PROP_HOUSE_PLOT];
      $UF_Code = 'kupit-dom';
      $propFilter = 'PROPERTY_HOME_VALUE';
      $nameDomPos = 'Купить дом';
      $APPLICATION->AddChainItem('Дома',"/poselki/kupit-dom/",true);
      break;
    default:
      CHTTP::SetStatus("404 Not Found");
      @define("ERROR_404", "Y");
      break;
  }
  if ($pagen) $pageTitleDesc = $nameDomPos; // если пагинация
}

if($typePos && $domPos){ // если и по типу и по дому - мета из HL
  if($typePos == 'dachnye' && $domPos == 'noDom'){
    $UF_Code = 'kupit-dachnyj-uchastok';
    if ($pagen) $pageTitleDesc = 'Участки в дачных поселках';
  }
  if($typePos == 'dachnye' && $domPos == 'withDom'){
    $UF_Code = 'kupit-dachnyj-dom';
    if ($pagen) $pageTitleDesc = 'Дачи';
  }
  if($typePos == 'kottedzhnye' && $domPos == 'noDom'){
    $UF_Code = 'kupit-kottedzhnyj-uchastok';
    if ($pagen) $pageTitleDesc = 'Участки в коттеджных поселках';
  }
  if($typePos == 'kottedzhnye' && $domPos == 'withDom'){
    $UF_Code = 'kupit-kottedzh';
    if ($pagen) $pageTitleDesc = 'Коттеджи';
  }
}

if ($mkadKM) { // выбор по км от МКАД
  if(is_numeric($mkadKM)){
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
    $arrFilter['><PROPERTY_MKAD'] = [$mkadKM_ot,$mkadKM_do];
    // dump($arrFilter);
    $APPLICATION->AddChainItem('До '.$mkadKM.' км от МКАД',"/poselki/do-".$mkadKM."-km-ot-mkad/",true);
    // url для Шоссе
    foreach ($onlyShosse as $key => $val) {
      switch ($domPos) {
        case 'noDom': // Участки
          $urlTeg = '/kupit-uchastki/'.$val.'-shosse-do-'.$mkadKM.'-km-mkad/';
          break;
        case 'withDom': // Дома
          $urlTeg = '/poselki/kupit-dom/'.$val.'-shosse-do-'.$mkadKM.'-km-mkad/';
          break;
        default: // Поселки
          $urlTeg = '/poselki/'.$val.'-shosse-do-'.$mkadKM.'-km-mkad/';
          break;
      }
      $arTegs[$nameShosseDir[$key]]['url'] = $urlTeg;
    }
    // url для С газом
    switch ($domPos) {
      case 'noDom': // Участки
        $urlTeg = "/kupit-uchastki/gaz-do-".$mkadKM."-km-mkad/";
        break;
      case 'withDom': // Дома
        $urlTeg = "/poselki/kupit-dom/gaz-do-".$mkadKM."-km-mkad/";
        break;
      default: // Поселки
        $urlTeg = "/poselki/gaz-do-".$mkadKM."-km-mkad/";;
        break;
    }
    $arTegs['gaz']['url'] = $urlTeg;
    // url для ИЖС
    switch ($domPos) {
      case 'noDom': // Участки
        $urlTeg = "/kupit-uchastki/do-".$mkadKM."-km-mkad-izhs/";
        break;
      case 'withDom': // Дома
        $urlTeg = "/poselki/kupit-dom/do-".$mkadKM."-km-mkad-izhs/";
        break;
      default: // Поселки
        $urlTeg = "/poselki/do-".$mkadKM."-km-mkad-izhs/";
        break;
    }
    $arTegs['izhs']['url'] = $urlTeg;
    // теги для км от МКАД
    $arTegsShow = ['north','east','south','west','gaz','izhs','snt','ryadom-s-lesom','u-vody','econom','komfort'];
  }else{
    CHTTP::SetStatus("404 Not Found");
    @define("ERROR_404", "Y");
  }
}

if($plottage){ // площадь дома
  if(is_numeric($plottage)){
    switch ($plottage) {
      case $plottage == 100: $url_km_MKAD = "kupit-dom-100-kv-m"; break;
      case $plottage == 120: $url_km_MKAD = "kupit-dom-120-kv-m"; break;
      case $plottage == 150: $url_km_MKAD = "kupit-dom-150-kv-m"; break;
      case $plottage == 200: $url_km_MKAD = "kupit-dom-200-kv-m"; break;
      case $plottage == 250: $url_km_MKAD = "kupit-dom-250-kv-m"; break;
      case $plottage == 300: $url_km_MKAD = "kupit-dom-300-kv-m"; break;
      case $plottage == 400: $url_km_MKAD = "kupit-dom-400-kv-m"; break;
      case $plottage == 500: $url_km_MKAD = "kupit-dom-500-kv-m"; break;

      default: CHTTP::SetStatus("404 Not Found"); @define("ERROR_404", "Y"); break;
    }

    if($plottage == 100){
      $plottage_ot = $plottage - 20; // от
      $plottage_do = $plottage + 20; // до
    }elseif($plottage == 120){
      $plottage_ot = $plottage - 20; // от
      $plottage_do = $plottage + 30; // до
    }elseif($plottage == 150){
      $plottage_ot = $plottage - 30; // от
      $plottage_do = $plottage + 30; // до
    }else{
      $plottage_ot = $plottage - 50; // от
      $plottage_do = $plottage + 50; // до
    }
    $arrFilter['><PROPERTY_HOUSE_AREA'] = [$plottage_ot,$plottage_do]; // Площадь домов
    // dump($arrFilter);
    $APPLICATION->AddChainItem('Купить дом '.$plottage.' кв.м.',"/poselki/kupit-dom-".$plottage."-kv-m/",true);
    $UF_Code = "kupit-dom-".$plottage."-kv-m";
    // теги для площади
    $arTegsShow = ['north','east','south','west','gaz','izhs','snt','ryadom-s-lesom','u-vody','econom','komfort'];
  }else{
    CHTTP::SetStatus("404 Not Found");
    @define("ERROR_404", "Y");
  }
}

if($priceURL){ // выборка по цене
  if($priceType == 'tys'){ // тысячи
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
  }else{ // миллионы
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

  $arrFilter['><'.$propFilter] = [$price_ot,$price_do];
  $APPLICATION->AddChainItem($nameDomPos.' '.$priceURL.' '.$nameBC.' руб',"/poselki/".$UF_Code."-do-".$priceURL."-".$priceType."-rub/",true);
  // dump($arrFilter);
  // url для Шоссе
  foreach ($onlyShosse as $key => $val) {
    switch ($domPos) {
      case 'noDom': // Участки
        $urlTeg = '/kupit-uchastki/'.$val.'-shosse-do-'.$priceURL.'-'.$priceType2.'/';
        break;
      case 'withDom': // Дома
        $urlTeg = '/kupit-dom/'.$val.'-shosse-do-'.$priceURL.'-'.$priceType2.'/';
        break;
    }
    $arTegs[$nameShosseDir[$key]]['url'] = $urlTeg;
  }
  // теги для цены
  $arTegsShow = ['north','east','south','west','gaz','elektro','izhs','snt','ryadom-s-lesom','u-vody'];
}

if($areaUrl){ // выборка по площади
  if(is_numeric($areaUrl)){
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
    if($area_ot < 0)$area_ot = 0;
    $arrFilter['><PROPERTY_PLOTTAGE'] = [$area_ot,$area_do]; // dump($arrFilter);

    switch ($areaType) { // склонение
      case 'sotok':
        $nameArea = 'соток';break;
      case 'sotki':
        $nameArea = 'сотки';break;
      case 'sotkah':
        $nameArea = 'сотках';break;
    }
    if($domPos == 'withDom')$nameDomPos = 'Дома на';
    $APPLICATION->AddChainItem($nameDomPos.' '.$areaUrl.' '.$nameArea,'',true);
    // теги для площади
    $arTegsShow = ['north','east','south','west','gaz','izhs','snt','ryadom-s-lesom','u-vody','econom','komfort'];
  }else{
    CHTTP::SetStatus("404 Not Found");
    @define("ERROR_404", "Y");
  }
}

if($classCode){ // выборка по классу econom / biznes / komfort / elit / premium
  // echo 'ddd: '.$classCode;
  switch ($classCode) {
    case 'econom':
      $arrFilter['<=PROPERTY_PRICE_SOTKA'] = 100000; // Цена за сотку
      $nameClass = 'эконом';$nameClass2 = 'Эконом';
      break;
    case 'komfort':
      $arrFilter['=PROPERTY_20'] = [12]; // Электричество
      $arrFilter['=PROPERTY_77'] = [59,60,61,156,158,193]; // Дороги в поселке
      $arrFilter['=PROPERTY_79'] = [68]; // Обустройство поселка: Огорожен
      $nameClass = 'комфорт';$nameClass2 = 'Комфорт';
      break;
    case 'biznes':
      $arrFilter['=PROPERTY_20'] = [12]; // Электричество
      $arrFilter['=PROPERTY_23'] = [15]; // Газ
      $arrFilter['=PROPERTY_77'] = [59,60,61,156,158,193]; // Дороги в поселке
      $arrFilter['=PROPERTY_79'] = [68]; // Обустройство поселка: Огорожен
      $nameClass = 'бизнес';$nameClass2 = 'Бизнес';
      break;
    case 'elit':
      $arrFilter['=PROPERTY_20'] = [12]; // Электричество
      $arrFilter['=PROPERTY_23'] = [15]; // Газ
      $arrFilter['=PROPERTY_26'] = [18]; // Водопровод
      $arrFilter['=PROPERTY_77'] = [59,156,193]; // Дороги в поселке: Асфальт, Асф. кр., Асфальтовая крошка
      $arrFilter['=PROPERTY_79'] = [67,68]; // Обустройство поселка: Охрана, Огорожен
      $arrFilter['>=PROPERTY_8'] = 150000; // Цена за сотку
      $nameClass = 'элитного';$nameClass2 = 'Элитного';
      break;
    case 'premium':
      $arrFilter['=PROPERTY_2'] = [4,256]; // Наличие домов
      $arrFilter['>=PROPERTY_17'] = 10000000; // Стоимость домов
      $arrFilter['=PROPERTY_20'] = [12]; // Электричество
      $arrFilter['=PROPERTY_23'] = [15]; // Газ
      $arrFilter['=PROPERTY_26'] = [18]; // Водопровод
      $arrFilter['=PROPERTY_77'] = [59]; // Дороги в поселке: Асфальт
      $arrFilter['=PROPERTY_79'] = [67,68]; // Обустройство поселка: Охрана, Огорожен
      $nameClass = 'премиум';$nameClass2 = 'Премиум';
      break;
    default:
      CHTTP::SetStatus("404 Not Found");
      @define("ERROR_404", "Y");
      break;
  }
  $APPLICATION->AddChainItem($nameClass2.' класса','',true);
  // теги для класса
  $arTegsShow = ['north','east','south','west','mkad_20','mkad_30','mkad_50','gaz','ryadom-s-lesom','u-vody'];
}

if($commun){ // коммуникации
  // echo 'ddd: '.$commun;
  switch ($commun) {
    case 'elektrichestvom':
      $arrFilter['=PROPERTY_21'] = [14]; // Электричество (проведен)
      $APPLICATION->AddChainItem('Со светом','',true);
      $commun2 = $commun3 = 'svet';
      break;
    case 'vodoprovodom':
      $arrFilter['=PROPERTY_27'] = [20]; // Водопровод (проведен)
      $APPLICATION->AddChainItem('С водой','',true);
      $commun2 = 'u-vody'; $commun3 = 'voda';
      break;
    case 'gazom':
      $arrFilter['=PROPERTY_24'] = [17]; // Газ (проведен)
      $APPLICATION->AddChainItem('С газом','',true);
      $commun2 = $commun3 = 'gaz';
      break;
    case 'kommunikaciyami':
      $arrFilter['=PROPERTY_21'] = [14]; // Электричество (проведен)
      $arrFilter['=PROPERTY_24'] = [17]; // Газ (проведен)
      $APPLICATION->AddChainItem('С коммуникациями','',true);
      $commun2 = $commun3 = 'kommunikatsii';
      break;
    default:
      CHTTP::SetStatus("404 Not Found");
      @define("ERROR_404", "Y");
      break;
  }
  // url для Шоссе
  foreach ($onlyShosse as $key => $val) {
    switch ($domPos) {
      case 'noDom': // Участки
        $urlTeg = '/kupit-uchastki/'.$val.'-shosse-'.$commun2.'/';
        break;
      case 'withDom': // Дома
        $urlTeg = '/kupit-dom/'.$val.'-shosse-'.$commun2.'/';
        break;
      default: // Поселки
        $urlTeg = '/poselki/'.$val.'-shosse-'.$commun2.'/';
        break;
    }
    $arTegs[$nameShosseDir[$key]]['url'] = $urlTeg;
  }
  // url для км от МКАД
  for ($i=10; $i < 60; $i+=10) { // до МКАД
    switch ($domPos) {
      case 'noDom': // Участки
        $urlTeg = '/kupit-uchastki/'.$commun3.'-do-'.$i.'-km-mkad/';
        break;
      case 'withDom': // Дома
        $urlTeg = '/kupit-dom/'.$commun3.'-do-'.$i.'-km-mkad/';
        break;
      default: // Поселки
        $urlTeg = '/poselki/'.$commun3.'-do-'.$i.'-km-mkad/';
        break;
    }
    $arTegs['mkad_'.$i]['url'] = $urlTeg;
  }
  // теги для коммуникаций
  $arTegsShow = ['north','east','south','west','mkad_20','mkad_30','mkad_50','ryadom-s-lesom','u-vody','econom','komfort'];
}

if($typeURL){ // другие URL
  switch ($typeURL) {
    case 'snt': // СНТ
      $arrFilter['=PROPERTY_33'] = [108,150,123,162]; // Вид разрешенного использования
      $inChainItem = 'СНТ';
      if ($pagen) { // если пагинация
        switch ($domPos) {
          case 'noDom': $pageTitleDesc = 'Участки СНТ'; break;
          case 'withDom': $pageTitleDesc = 'Дома СНТ'; break;
          default: $pageTitleDesc = 'Поселки СНТ'; break;
        }
      }
      break;
    case 'izhs': // ИЖС
      $arrFilter['=PROPERTY_33'] = [154,228]; // Вид разрешенного использования
      $inChainItem = 'ИЖС';
      if ($pagen) { // если пагинация
        switch ($domPos) {
          case 'noDom': $pageTitleDesc = 'Купить участок ИЖС'; break;
          case 'withDom': $pageTitleDesc = 'Купить дом ИЖС'; break;
          default: $pageTitleDesc = 'Поселки ИЖС'; break;
        }
      }
      break;
    case 'ryadom-s-lesom':
      $arrFilter['=PROPERTY_45'] = [35,36,37,38]; // Лес
      $inChainItem = 'Рядом с лесом';
      if ($pagen) { // если пагинация
        switch ($domPos) {
          case 'noDom': $pageTitleDesc = 'Участки с лесом'; break;
          case 'withDom': $pageTitleDesc = 'Дома с лесом'; break;
          default: $pageTitleDesc = 'Поселки с лесом'; break;
        }
      }
      break;
    case 'u-vody':
      $arrFilter['=PROPERTY_47'] = [39,40,41]; // Водоем
      $inChainItem = 'У воды';
      if ($pagen) { // если пагинация
        switch ($domPos) {
          case 'noDom': $pageTitleDesc = 'Купить участок у воды'; break;
          case 'withDom': $pageTitleDesc = 'Купить дом у воды'; break;
          default: $pageTitleDesc = 'Поселки у воды'; break;
        }
      }
      break;
    case 'u-ozera':
      $arrFilter['=PROPERTY_47'] = [40]; // Водоем = Озеро
      $inChainItem = 'У озера';
      if ($pagen) { // если пагинация
        switch ($domPos) {
          case 'noDom': $pageTitleDesc = 'Купить участок у озера'; break;
          case 'withDom': $pageTitleDesc = 'Купить дом у озера'; break;
          default: $pageTitleDesc = 'Поселки у озера'; break;
        }
      }
      break;
    case 'u-reki':
      $arrFilter['=PROPERTY_47'] = [39]; // Водоем = Река
      $inChainItem = 'У реки';
      if ($pagen) { // если пагинация
        switch ($domPos) {
          case 'noDom': $pageTitleDesc = 'Купить участок у реки'; break;
          case 'withDom': $pageTitleDesc = 'Купить дом у реки'; break;
          default: $pageTitleDesc = 'Поселки у реки'; break;
        }
      }
      break;
    case 'ryadom-zhd-stanciya':
      $arrFilter['<=PROPERTY_RAILWAY_KM'] = 5; // Ближайшая ж/д станция расстояние до поселка, км
      $inChainItem = 'Рядом Ж/Д станция';
      if ($pagen) { // если пагинация
        switch ($domPos) {
          case 'noDom': $pageTitleDesc = 'Купить участок рядом жд станция'; break;
          case 'withDom': $pageTitleDesc = 'Купить дом рядом жд станция'; break;
          default: $pageTitleDesc = 'Поселки рядом жд станция'; break;
        }
      }
      break;
    case 'ryadom-avtobusnaya-ostanovka':
      $arrFilter['<=PROPERTY_BUS_TIME_KM'] = 3; // Автобус (расстояние от остановки, км)
      $inChainItem = 'Рядом автобусная остановка';
      if ($pagen) { // если пагинация
        switch ($domPos) {
          case 'noDom': $pageTitleDesc = 'Купить участок рядом автобусная остановка'; break;
          case 'withDom': $pageTitleDesc = 'Купить дом рядом автобусная остановка'; break;
          default: $pageTitleDesc = 'Поселки рядом автобусная остановка'; break;
        }
      }
      break;
    case 'promyshlennye':
      $arrFilter['PROPERTY_1'] = 301; // Промышленный поселок
      $inChainItem = 'Промышленные поселки';
      $newTitle = 'Промышленные поселки в Ленинградской области';
      $h1 = 'Промышленные поселки в Ленинградской области';
      break;
    case 'kupit-letnij-dom':
      // $arrFilter['<=PROPERTY_BUS_TIME_KM'] = 3; // Автобус (расстояние от остановки, км)
      $inChainItem = 'Купить летний дом';
      break;
    case 'kupit-zimnij-dom':
      // $arrFilter['<=PROPERTY_BUS_TIME_KM'] = 3; // Автобус (расстояние от остановки, км)
      $inChainItem = 'Купить зимний дом';
      break;
    case 's-infrastrukturoj':
      $arrFilter['=PROPERTY_81'] = [72,113]; // магазин
      $arrFilter['=PROPERTY_84'] = [78,116]; // школа
      $arrFilter['<=PROPERTY_71'] = 2; // Ближайшая ж/д станция расстояние до поселка, км
      $inChainItem = 'С инфраструктурой';
      break;
    case 's-ohranoj':
      $arrFilter['=PROPERTY_79'] = [67]; // обустройство - охрана
      $inChainItem = 'С охраной';
      break;
    case 's-dorogami':
      $arrFilter['=PROPERTY_78'] = [63,64,65,145,159]; // дороги до поселка
      $inChainItem = 'С дорогами';
      break;
    default:
      CHTTP::SetStatus("404 Not Found");
      @define("ERROR_404", "Y");
      break;
  }
  $UF_Code = ($domPos) ? $UF_Code.'-'.$typeURL : $typeURL; // для выборки
  $urlAll = "/poselki/".$typeURL."/";
  // if($typeURL != 'ryadom-avtobusnaya-ostanovka'){
    $urlNoDom = "/kupit-uchastki/".$typeURL."/";
    $urlWithDom = "/kupit-dom/".$typeURL."/";
  // }
  if($typeURL == 'kupit-letnij-dom' || $typeURL == 'kupit-zimnij-dom'){
    $urlAll = '/poselki/';
    $urlNoDom = false;
    $urlWithDom = '/poselki/'.$typeURL.'/';
  }
  $APPLICATION->AddChainItem($inChainItem,'',true);
  // теги для ВРИ
  if($typeURL == 'snt' || $typeURL == 'izhs'){
    if($typeURL == 'izhs'){
      // url для км от МКАД
      for ($i=10; $i < 60; $i+=10) { // до МКАД
        switch ($domPos) {
          case 'noDom': // Участки
            $urlTeg = '/kupit-uchastki/do-'.$i.'-km-mkad-izhs/';
            break;
          case 'withDom': // Дома
            $urlTeg = '/kupit-dom/do-'.$i.'-km-mkad-izhs/';
            break;
          default: // Поселки
            $urlTeg = '/poselki/do-'.$i.'-km-mkad-izhs/';
            break;
        }
        $arTegs['mkad_'.$i]['url'] = $urlTeg;
      }
    }
    $arTegsShow = ['north','east','south','west','mkad_30','mkad_50','gaz','ryadom-s-lesom','u-vody','econom','komfort'];
  }
}

if($developerCode){ // по девелоперу
  $arrFilter['=PROPERTY_DEVELOPER_ID'] = $developerCode; // Вид разрешенного использования
}
?>
