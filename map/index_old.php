<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Карта поселков");

$shosse = $_REQUEST['SHOSSE_CODE'];
$rayon = $_REQUEST['RAYON_CODE'];
$typePos = $_REQUEST['TYPE_CODE'];
$domPos = $_REQUEST['DOMA_CODE'];
$mkadKM = $_REQUEST['MKAD_KM'];
$priceURL = $_REQUEST['PRICE_URL'];
$priceType = $_REQUEST['PRICE_TYPE'];
$areaUrl = $_REQUEST['AREA_URL'];
$areaType = $_REQUEST['AREA_TYPE'];
$classCode = $_REQUEST['CLASS_CODE'];
$commun = $_REQUEST['COMMUN'];
$typeURL = $_REQUEST['TYPE_URL'];
$plottage = $_REQUEST['PLOTTAGE'];

// переопределим
global $APPLICATION;
$dir = $APPLICATION->GetCurDir();
if (strpos($dir, 'kupit-uchastok') !== false) $domPos = 'noDom';
if (strpos($dir, 'kupit-dom') !== false) $domPos = 'withDom';
if (strpos($dir, 's-elektrichestvom') !== false) $commun = 'elektrichestvom';
if (strpos($dir, 's-vodoprovodom') !== false) $commun = 'vodoprovodom';
if (strpos($dir, 's-gazom') !== false) $commun = 'gazom';
if (strpos($dir, 's-kommunikaciyami') !== false) $commun = 'kommunikaciyami';
if (strpos($dir, 'snt') !== false) $typeURL = 'snt';
if (strpos($dir, 'izhs') !== false) $typeURL = 'izhs';
if (strpos($dir, 'ryadom-s-lesom') !== false) $typeURL = 'ryadom-s-lesom';
if (strpos($dir, 'u-vody') !== false) $typeURL = 'u-vody';
if (strpos($dir, 'u-ozera') !== false) $typeURL = 'u-ozera';
if (strpos($dir, 'u-reki') !== false) $typeURL = 'u-reki';
if (strpos($dir, 'ryadom-zhd-stanciya') !== false) $typeURL = 'ryadom-zhd-stanciya';
if (strpos($dir, 'ryadom-avtobusnaya-ostanovka') !== false) $typeURL = 'ryadom-avtobusnaya-ostanovka';
if (strpos($dir, 'kupit-letnij-dom') !== false) $typeURL = 'kupit-letnij-dom';
if (strpos($dir, 'kupit-zimnij-dom') !== false) $typeURL = 'kupit-zimnij-dom';
if (strpos($dir, 's-infrastrukturoj') !== false) $typeURL = 's-infrastrukturoj';
if (strpos($dir, 's-ohranoj') !== false) $typeURL = 's-ohranoj';
if (strpos($dir, 's-dorogami') !== false) $typeURL = 's-dorogami';

$h1 = 'Карта поселков';
$newTitle = false; $newDesc = false;

\Bitrix\Main\Loader::includeModule('highloadblock');
use Bitrix\Highloadblock as HL,
	Bitrix\Main\Entity;

if ($shosse || $rayon || $typePos || $domPos || $mkadKM || $priceURL || $areaUrl || $classCode || $commun || $typeURL || $plottage) { // странички шоссе или район

	if ($shosse) {
		if(!getNamesList($shosse,'SHOSSE')['ID']){
			CHTTP::SetStatus("404 Not Found");
			@define("ERROR_404", "Y");
		}
    $arrFilter['=PROPERTY_5'][] = getNamesList($shosse,'SHOSSE')['ID'];
    $arNames = getNamesList($shosse,'SHOSSE');
    $UF_Code = $shosse;
		$APPLICATION->AddChainItem($arNames['NAME'].' шоссе',"/poselki/".$shosse."-shosse/",true);
		$urlAll = '/poselki/'.$shosse.'-shosse/';
		$urlNoDom = '/poselki/'.$shosse.'-shosse/kupit-uchastok/';
		$urlWithDom = '/poselki/'.$shosse.'-shosse/kupit-dom/';
  }
  if ($rayon) {
		if(!getNamesList($rayon,'REGION')['ID']){
			CHTTP::SetStatus("404 Not Found");
			@define("ERROR_404", "Y");
		}
    $arrFilter['=PROPERTY_4'][] = getNamesList($rayon,'REGION')['ID'];
    $arNames = getNamesList($rayon,'REGION');
    $UF_Code = $rayon;
		$APPLICATION->AddChainItem($arNames['NAME'].' район',"/poselki/".$rayon."-rayon/",true);
		$urlAll = '/poselki/'.$rayon.'-rayon/';
		$urlNoDom = '/poselki/'.$rayon.'-rayon/kupit-uchastok/';
		$urlWithDom = '/poselki/'.$rayon.'-rayon/kupit-dom/';
  }
	if ($typePos) { // выбор по типу
		switch ($typePos) {
			case 'dachnye':
				$arrFilter['=PROPERTY_1'] = [1];
				$nameType = 'Дачные';
				$urlNoDom = '/poselki/kupit-dachnyj-uchastok/';
				$urlWithDom = '/poselki/kupit-dachnyj-dom/';
				break;
			case 'kottedzhnye':
				$arrFilter['=PROPERTY_1'] = [2];
				$nameType = 'Коттеджные';
				$urlNoDom = '/poselki/kupit-kottedzhnyj-uchastok/';
				$urlWithDom = '/poselki/kupit-kottedzh/';
				break;
		}
		$UF_Code = $typePos;
		$APPLICATION->AddChainItem($nameType.' поселки',"/poselki/".$typePos."/",true);
		$urlAll = '/poselki/'.$typePos.'/';
  }
	if ($domPos) { // если выбор с домом или без
		switch ($domPos) {
			case 'noDom':
				$arrFilter['=PROPERTY_2'] = [3,256];
				$UF_Code = 'kupit-uchastok';
				$propFilter = 'PROPERTY_120';
				$nameDomPos = 'Участки';
				$APPLICATION->AddChainItem('Участки',"/poselki/kupit-uchastok/",true);
				break;
			case 'withDom':
				$arrFilter['=PROPERTY_2'] = [4,256];
				$UF_Code = 'kupit-dom';
				$propFilter = 'PROPERTY_17';
				$nameDomPos = 'Дома';
				$APPLICATION->AddChainItem('Дома',"/poselki/kupit-dom/",true);
				break;
		}
	}
	if($typePos && $domPos){ // если и по типу и по дому - мета из HL
		if($typePos == 'dachnye' && $domPos == 'noDom')$UF_Code = 'kupit-dachnyj-uchastok';
		if($typePos == 'dachnye' && $domPos == 'withDom')$UF_Code = 'kupit-dachnyj-dom';
		if($typePos == 'kottedzhnye' && $domPos == 'noDom')$UF_Code = 'kupit-kottedzhnyj-uchastok';
		if($typePos == 'kottedzhnye' && $domPos == 'withDom')$UF_Code = 'kupit-kottedzh';
	}
	if ($mkadKM) { // выбор по км от мкад
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
			$arrFilter['><PROPERTY_6'] = [$mkadKM_ot,$mkadKM_do];
			// dump($arrFilter);
			$APPLICATION->AddChainItem('До '.$mkadKM.' км от МКАД',"/poselki/do-".$mkadKM."-km-ot-mkad/",true);
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
			$arrFilter['><PROPERTY_15'] = [$plottage_ot,$plottage_do]; // Площадь домов
			// dump($arrFilter);
			$APPLICATION->AddChainItem('Купить дом '.$plottage.' кв.м.',"/poselki/kupit-dom-".$plottage."-kv-m/",true);
			$UF_Code = "kupit-dom-".$plottage."-kv-m";
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
			$nameBC = 'тыс'; $nameBCFull = 'тысяч';
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
			$nameBC = 'млн'; // $nameBCFull = 'миллионов';
			$million = new Declension('миллион', 'миллиона', 'миллионов');
			$nameBCFull = $million->get($priceURL);
		}

		$arrFilter['><'.$propFilter] = [$price_ot,$price_do];
		$APPLICATION->AddChainItem($nameDomPos.' '.$priceURL.' '.$nameBC.' руб',"/poselki/".$UF_Code."-do-".$priceURL."-".$priceType."-rub/",true);
		// dump($arrFilter);
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
			$arrFilter['><PROPERTY_11'] = [$area_ot,$area_do]; // dump($arrFilter);

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
		}else{
			CHTTP::SetStatus("404 Not Found");
			@define("ERROR_404", "Y");
		}
	}

	if($classCode){ // выборка по классу econom / biznes / komfort / elit / premium
		// echo 'ddd: '.$classCode;
		switch ($classCode) {
			case 'econom':
				$arrFilter['<=PROPERTY_8'] = 100000; // Цена за сотку
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
		}
		$APPLICATION->AddChainItem($nameClass2.' класса','',true);
	}

	if($commun){ // коммуникации
		// echo 'ddd: '.$commun;
		switch ($commun) {
			case 'elektrichestvom':
				$arrFilter['=PROPERTY_21'] = [14]; // Электричество (проведен)
				$APPLICATION->AddChainItem('Со светом','',true);
				break;
			case 'vodoprovodom':
				$arrFilter['=PROPERTY_27'] = [20]; // Водопровод (проведен)
				$APPLICATION->AddChainItem('С водой','',true);
				break;
			case 'gazom':
				$arrFilter['=PROPERTY_24'] = [17]; // Газ (проведен)
				$APPLICATION->AddChainItem('С газом','',true);
				break;
			case 'kommunikaciyami':
				$arrFilter['=PROPERTY_21'] = [14]; // Электричество (проведен)
				$arrFilter['=PROPERTY_24'] = [17]; // Газ (проведен)
				$APPLICATION->AddChainItem('С коммуникациями','',true);
				break;
		}
	}

	if($typeURL){ // другие URL
		switch ($typeURL) {
			case 'snt': // СНТ
				$arrFilter['=PROPERTY_33'] = [108,150,123,162]; // Вид разрешенного использования
				$inChainItem = 'СНТ';
				break;
			case 'izhs': // СНТ
				$arrFilter['=PROPERTY_33'] = [154,228]; // Вид разрешенного использования
				$inChainItem = 'ИЖС';
				break;
			case 'ryadom-s-lesom':
				$arrFilter['=PROPERTY_45'] = [35,36,37,38]; // Лес
				$inChainItem = 'Рядом с лесом';
				break;
			case 'u-vody':
				$arrFilter['=PROPERTY_47'] = [39,40,41]; // Водоем
				$inChainItem = 'У воды';
				break;
			case 'u-ozera':
				$arrFilter['=PROPERTY_47'] = [40]; // Водоем = Озеро
				$inChainItem = 'У озера';
				break;
			case 'u-reki':
				$arrFilter['=PROPERTY_47'] = [39]; // Водоем = Река
				$inChainItem = 'У реки';
				break;
			case 'ryadom-zhd-stanciya':
				$arrFilter['<=PROPERTY_71'] = 5; // Ближайшая ж/д станция расстояние до поселка, км
				$inChainItem = 'Рядом Ж/Д станция';
				break;
			case 'ryadom-avtobusnaya-ostanovka':
				$arrFilter['<=PROPERTY_67'] = 3; // Автобус (расстояние от остановки, км)
				$inChainItem = 'Рядом автобусная остановка';
				break;
			case 'kupit-letnij-dom':
				// $arrFilter['<=PROPERTY_67'] = 3; // Автобус (расстояние от остановки, км)
				$inChainItem = 'Купить летний дом';
				break;
			case 'kupit-zimnij-dom':
				// $arrFilter['<=PROPERTY_67'] = 3; // Автобус (расстояние от остановки, км)
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
		}
		$UF_Code = ($domPos) ? $UF_Code.'-'.$typeURL : $typeURL; // для выборки
		$urlAll = "/poselki/".$typeURL."/";
		// if($typeURL != 'ryadom-avtobusnaya-ostanovka'){
			$urlNoDom = "/poselki/kupit-uchastok-".$typeURL."/";
			$urlWithDom = "/poselki/kupit-dom-".$typeURL."/";
		// }
		$APPLICATION->AddChainItem($inChainItem,'',true);
	}

  $hlblock_id = 6; // id HL
  $hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();
  $entity = HL\HighloadBlockTable::compileEntity($hlblock);
  $entity_data_class = $entity->getDataClass();
  $entity_table_name = $hlblock['TABLE_NAME'];
  $sTableID = 'tbl_'.$entity_table_name;

  $rsData = $entity_data_class::getList([
    'filter' => ['UF_CODE' => $UF_Code]
  ]);
  $rsData = new CDBResult($rsData, $sTableID);

  if($arRes = $rsData->Fetch()){ // dump($arRes);

    foreach ($arRes as $key => $value) { // заменим по склонениям
      $arRes[$key] = str_replace(['#NAME#','#NAME_KOMU#','#NAME_KOM#'],[$arNames['NAME'],$arNames['NAME_KOMU'],$arNames['NAME_KOM']],$value);
    } // dump($arRes);

    $newTitle = $arRes['UF_TITLE'];
    $newDesc = $arRes['UF_DESC'];
    $h1 = $arRes['UF_H1'];
    $newH2 = $arRes['UF_H2'];
    $newText = $arRes['UF_TEXT'];
  }else{ // выведем шаблонные
    if($shosse){
      $newTitle = 'Коттеджные поселки и дачные поселки по '.$arNames['NAME_KOMU'].' шоссе';
      $newDesc = 'Коттеджные и дачные поселки на '.$arNames['NAME_KOM'].' шоссе с фото, видео, отзывами и рейтингом. Купить земельный участок, дачу или дом в поселке по '.$arNames['NAME_KOMU'].' шоссе.';
      $h1 = 'Коттеджные и дачные поселки '.$arNames['NAME'].' шоссе';
      $newH2 = 'Поселки по '.$arNames['NAME_KOMU'].' шоссе в Московской области';
    }
    if($rayon){
      $newTitle = 'Коттеджные поселки и дачные поселки в '.$namesRayon['NAME_KOMU'].' районе';
      $newDesc = 'Рейтинг коттеджных и дачных поселков в '.$namesRayon['NAME_KOMU'].' районе Московской области. Фото, видео, отзывы и цены в поселках Подмосковья.';
      $h1 = 'Коттеджные и дачные поселки '.$namesRayon['NAME'].' район';
      $newH2 = 'Поселки в '.$namesRayon['NAME_KOMU'].' районе Московской области';
    }
  }
}

if($newTitle)$APPLICATION->SetPageProperty("title", $newTitle);
if($newDesc)$APPLICATION->SetPageProperty("description", $newDesc);
?>
<section class="section-categories">
  <div class="container-fluid">
    <div class="title-page">
      <h1 class="small-h3">
        <i class="fs1 raiting" aria-hidden="true" data-icon="&#xe0f2;"></i>
        <?=$h1?>
      </h1>
    </div>
	  <div class="block-filter">
			<?$APPLICATION->IncludeComponent(
				"bitrix:catalog.smart.filter",
				"poselkino",
				array(
					"CACHE_GROUPS" => "Y",
					"CACHE_TIME" => "36000000",
					"CACHE_TYPE" => "N",
					"CONVERT_CURRENCY" => "N",
					"DISPLAY_ELEMENT_COUNT" => "Y",
					"FILTER_NAME" => "arrFilter",
					"FILTER_VIEW_MODE" => "horizontal",
					"HIDE_NOT_AVAILABLE" => "N",
					"IBLOCK_ID" => "1",
					"IBLOCK_TYPE" => "content",
					"PAGER_PARAMS_NAME" => "arrPager",
					"POPUP_POSITION" => "left",
					"SAVE_IN_SESSION" => "N",
					"SECTION_CODE" => "",
					"SECTION_CODE_PATH" => "",
					"SECTION_DESCRIPTION" => "-",
					"SECTION_ID" => $_REQUEST["SECTION_ID"],
					"SECTION_TITLE" => "-",
					"SEF_MODE" => "Y",
					"SEF_RULE" => "/poselki/filter/#SMART_FILTER_PATH#/apply/map/#showPoselki",
					"SMART_FILTER_PATH" => $_REQUEST["SMART_FILTER_PATH"],
					"TEMPLATE_THEME" => "green",
					"XML_EXPORT" => "N",
					"COMPONENT_TEMPLATE" => "poselkino"
				),
				false
			);?>
	  </div>
			<?// если была фильтрация, то вернем
			if($posNoDom)$arrFilter['=PROPERTY_2'] = [3,256];
			if($posWithDom)$arrFilter['=PROPERTY_2'] = [4,256];
      // dump($arrFilter);?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:catalog.section",
				"map",
				array(
					"ACTION_VARIABLE" => "action",
					"ADD_PICT_PROP" => "DOP_FOTO",
					"ADD_PROPERTIES_TO_BASKET" => "N",
					"ADD_SECTIONS_CHAIN" => "N",
					"ADD_TO_BASKET_ACTION" => "ADD",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_ADDITIONAL" => "",
					"AJAX_OPTION_HISTORY" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"BACKGROUND_IMAGE" => "-",
					"BASKET_URL" => "/personal/basket.php",
					"BROWSER_TITLE" => "-",
					"CACHE_FILTER" => "N",
					"CACHE_GROUPS" => "Y",
					"CACHE_TIME" => "36000000",
					"CACHE_TYPE" => "A",
					"COMPATIBLE_MODE" => "N",
					"COMPONENT_TEMPLATE" => "poselkino",
					"CONVERT_CURRENCY" => "N",
					"CUSTOM_FILTER" => "",
					"DETAIL_URL" => "/poselki/#ELEMENT_CODE#/",
					"DISABLE_INIT_JS_IN_COMPONENT" => "N",
					"DISPLAY_BOTTOM_PAGER" => "Y",
					"DISPLAY_COMPARE" => "N",
					"DISPLAY_TOP_PAGER" => "N",
					"ELEMENT_SORT_FIELD" => "sort",
					"ELEMENT_SORT_FIELD2" => "id",
					"ELEMENT_SORT_ORDER" => "asc",
					"ELEMENT_SORT_ORDER2" => "desc",
					"ENLARGE_PRODUCT" => "STRICT",
					"FILTER_NAME" => "arrFilter",
					"HIDE_NOT_AVAILABLE" => "N",
					"HIDE_NOT_AVAILABLE_OFFERS" => "N",
					"IBLOCK_ID" => "1",
					"IBLOCK_TYPE" => "content",
					"INCLUDE_SUBSECTIONS" => "Y",
					"LABEL_PROP" => array(
					),
					"LAZY_LOAD" => "N",
					"LINE_ELEMENT_COUNT" => "3",
					"LOAD_ON_SCROLL" => "N",
					"MESSAGE_404" => "",
					"MESS_BTN_ADD_TO_BASKET" => "В корзину",
					"MESS_BTN_BUY" => "Купить",
					"MESS_BTN_DETAIL" => "Подробнее",
					"MESS_BTN_SUBSCRIBE" => "Подписаться",
					"MESS_NOT_AVAILABLE" => "Нет в наличии",
					"META_DESCRIPTION" => "-",
					"META_KEYWORDS" => "-",
					"OFFERS_LIMIT" => "5",
					"PAGER_BASE_LINK_ENABLE" => "N",
					"PAGER_DESC_NUMBERING" => "N",
					"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
					"PAGER_SHOW_ALL" => "N",
					"PAGER_SHOW_ALWAYS" => "N",
					"PAGER_TEMPLATE" => "poselkino_nav",
					"PAGER_TITLE" => "Товары",
					"PAGE_ELEMENT_COUNT" => "999",
					"PARTIAL_PRODUCT_PROPERTIES" => "N",
					"PRICE_CODE" => array(
					),
					"PRICE_VAT_INCLUDE" => "N",
					"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
					"PRODUCT_ID_VARIABLE" => "id",
					"PRODUCT_PROPERTIES" => array(
					),
					"PRODUCT_PROPS_VARIABLE" => "prop",
					"PRODUCT_QUANTITY_VARIABLE" => "quantity",
					"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false}]",
					"PRODUCT_SUBSCRIPTION" => "N",
					"PROPERTY_CODE" => array(
						0 => "TYPE",
						1 => "DOMA",
						2 => "OBLAST",
						3 => "REGION",
						4 => "SHOSSE",
						5 => "MKAD",
						6 => "SALES_PHASE",
						7 => "PLOTTAGE",
						8 => "STOIMOST_UCHASTKA",
						9 => "HOUSE_AREA",
						10 => "HOME_VALUE",
						11 => "COORDINATES",
						12 => "",
					),
					"PROPERTY_CODE_MOBILE" => array(
					),
					"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
					"RCM_TYPE" => "personal",
					"SECTION_CODE" => "",
					"SECTION_CODE_PATH" => "",
					"SECTION_ID" => "",
					"SECTION_ID_VARIABLE" => "SECTION_ID",
					"SECTION_URL" => "/poselki/",
					"SECTION_USER_FIELDS" => array(
						0 => "",
						1 => "",
					),
					"SEF_MODE" => "Y",
					"SEF_RULE" => "",
					"SET_BROWSER_TITLE" => "Y",
					"SET_LAST_MODIFIED" => "N",
					"SET_META_DESCRIPTION" => "Y",
					"SET_META_KEYWORDS" => "Y",
					"SET_STATUS_404" => "Y",
					"SET_TITLE" => "Y",
					"SHOW_404" => "Y",
					"SHOW_ALL_WO_SECTION" => "Y",
					"SHOW_CLOSE_POPUP" => "N",
					"SHOW_DISCOUNT_PERCENT" => "N",
					"SHOW_FROM_SECTION" => "N",
					"SHOW_MAX_QUANTITY" => "N",
					"SHOW_OLD_PRICE" => "N",
					"SHOW_PRICE_COUNT" => "1",
					"SHOW_SLIDER" => "N",
					"SLIDER_INTERVAL" => "3000",
					"SLIDER_PROGRESS" => "N",
					"TEMPLATE_THEME" => "green",
					"USE_ENHANCED_ECOMMERCE" => "N",
					"USE_MAIN_ELEMENT_SECTION" => "N",
					"USE_PRICE_COUNT" => "N",
					"USE_PRODUCT_QUANTITY" => "N"
				),
				false
			);?>
	</div>
</section>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
