<?
if(file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/amo.php"))
	require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/amo.php");

// тест вывод
function dump($el){
	global $USER;
	// if($USER->IsAdmin()){
		echo "<pre>";print_r($el);echo "</pre>";
	// }
}

// вывод ошибки
function mesEr($txt){
	echo '<p class="mesEr">'.$txt.'</p>';
}
// вывод ок
function mesOk($txt){
	echo '<p class="mesOk">'.$txt.'</p>';
}

// формат цены
function formatPrice($price){
	$newPrice = number_format($price, 0, ',', '');
	return $newPrice;
}
function formatPriceSite($price){
	$newPrice = number_format($price, 0, ',', ' ');
	return $newPrice;
}
// формат цены с точками
function formatPricePoint($price){
	$newPrice = number_format($price, 0, ',', '.');
	return $newPrice;
}

// сопопоставим id
switch ($_SERVER['HTTP_HOST']) {
	case 'spb.poselkino.ru':
		define('IBLOCK_ID', 7); // инфоблок Поселков
		define('SHOW_PLOTS', 'N'); // показывать участки
		define('ROAD', 'КАД'); // шоссе
		define('PROP_SOLD_ID', 388); // проданные в SALES_PHASE
		define('PROP_HIDE_ID', 310); // убрать из каталога в HIDE_POS
		define('PROP_NO_DOM', 316); // Участки в DOMA
		define('PROP_WITH_DOM', 317); // Дома в DOMA
		define('PROP_HOUSE_PLOT', 318); // Дома и участки в DOMA
		define('PROP_DACHA', 311); // Дачный поселок в TYPE
		define('PROP_COTTAGE', 312); // Коттеджный поселок в TYPE
		define('PROP_FARMING', 313); // Фермерство в TYPE
		define('PROP_ELECTRO_Y', 392); // Электричество в ELECTRO
		define('PROP_GAS_Y', 397); // Газ в GAS
		define('PROP_PLUMBING_Y', 402); // Водопровод в PLUMBING
		break;
	default:
		define('IBLOCK_ID', 1); // инфоблок Поселков
		define('SHOW_PLOTS', 'Y'); // показывать участки
		define('ROAD', 'МКАД'); // шоссе
		define('PROP_SOLD_ID', 254); // проданные в SALES_PHASE
		define('PROP_HIDE_ID', 273); // убрать из каталога в HIDE_POS
		define('PROP_NO_DOM', 3); // Участки в DOMA
		define('PROP_WITH_DOM', 4); // Дома в DOMA
		define('PROP_HOUSE_PLOT', 256); // Дома и участки в DOMA
		define('PROP_DACHA', 1); // Дачный поселок в TYPE
		define('PROP_COTTAGE', 2); // Коттеджный поселок в TYPE
		define('PROP_FARMING', 171); // Фермерство в TYPE
		define('PROP_ELECTRO_Y', 12); // Электричество в ELECTRO
		define('PROP_GAS_Y', 15); // Газ в GAS
		define('PROP_PLUMBING_Y', 18); // Водопровод в PLUMBING
		break;
}

// ресайз фото
function ResizeIMG($fileID,$width=580,$height=358)
{
	// водный знак
	$arWaterMark = [
		[
			"name" => "watermark",
			"position" => "bottomright", // Положение
			"type" => "image",
			//"size" => "medium",
			"coefficient" => 3,
			"file" => $_SERVER["DOCUMENT_ROOT"].'/upload/water_sign.png', // Путь к картинке
			"fill" => "resize",
		]
	];

	// ресайз фото
	$photoRes = \CFile::ResizeImageGet($fileID, ['width'=>$width, 'height'=>$height], BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true, $arWaterMark);
	$photoRes['id'] = $fileID;

	return $photoRes;
}

// отправка СМС
function sendSMS($tel,$text)
{
	if(file_exists($_SERVER["DOCUMENT_ROOT"]."/local/libs/smsru_php/sms.ru.php"))
		require_once($_SERVER["DOCUMENT_ROOT"]."/local/libs/smsru_php/sms.ru.php");

	$smsru = new SMSRU('57F9E134-D93C-78F0-25E3-161BFE0F8246'); // API KEY

	$data = new stdClass();
	$data->to = $tel;
	$data->text = $text;
	$data->partner_id = 251650;
	$sms = $smsru->send_one($data);

	return $sms;
}

// получение кол-ва и мин и макс цены
function getMetaInfo($arrFilter){
	// получим кол-во поселков и цены
	$minPrice = 999999999;
	$maxPrice = 1;
	$cntPos = 0;
	$arOrder = Array("SORT"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>1,"ACTIVE"=>"Y");
	if($arrFilter)array_push($arFilter,$arrFilter); // dump($arFilter);
	$arSelect = Array("ID","NAME","PROPERTY_COST_LAND_IN_CART","PROPERTY_HOME_VALUE");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
	while($arElement = $rsElements->GetNext()){ // dump($arElement);
		$cntPos++;
		// минимальная цена
		$minPriceUch = $arElement['PROPERTY_COST_LAND_IN_CART_VALUE'][0];
		$minPriceDom = $arElement['PROPERTY_HOME_VALUE_VALUE'][0];
		if($minPriceUch && $minPrice > $minPriceUch)$minPrice = $minPriceUch;
		if($minPriceDom && $minPrice > $minPriceDom)$minPrice = $minPriceDom;
		// максимальная цена
		$maxPriceUch = $arElement['PROPERTY_COST_LAND_IN_CART_VALUE'][1];
		$maxPriceDom = $arElement['PROPERTY_HOME_VALUE_VALUE'][1];
		if($maxPriceUch && $maxPrice < $maxPriceUch)$maxPrice = $maxPriceUch;
		if($maxPriceDom && $maxPrice < $maxPriceDom)$maxPrice = $maxPriceDom;
	} // echo '$minPrice: '.$minPrice.'$cntPos: '.$cntPos;

	return $metaInfo[] = [ 'minPrice' => formatPrice($minPrice),'maxPrice' => formatPrice($maxPrice),'cntPos' => $cntPos ];
}

// получение кол-ва и мин и макс цены Участков
function getMetaInfoPlots($arrFilter){
	// получим поселки
	$minPrice = 999999999;
	$maxPrice = 1;
	$cntPos = 0;
	$arOrder = ["SORT"=>"ASC"];
	$arSelect = ["ID"];
	$rsElements = CIBlockElement::GetList($arOrder,$arrFilter,false,false,$arSelect);
	while ($arElement = $rsElements->GetNext())
		$arVillageIDs[] = $arElement['ID'];

	// получим участки
	$arOrder = ["SORT"=>"ASC"];
	$arFilterPlots = ["IBLOCK_ID"=>5,"ACTIVE"=>"Y",'PROPERTY_VILLAGE'=>$arVillageIDs];
	$arSelect = ["ID","NAME","PROPERTY_PRICE"];
	$rsElements = CIBlockElement::GetList($arOrder,$arFilterPlots,false,false,$arSelect);
	while ($arElement = $rsElements->GetNext())
	{
		$cntPos++;
		$plotPrice = $arElement['PROPERTY_PRICE_VALUE'];
		if ($plotPrice && $minPrice > $plotPrice) $minPrice = $plotPrice;
		if ($plotPrice && $maxPrice < $plotPrice) $maxPrice = $plotPrice;
	}

	return $metaInfo[] = [ 'minPrice' => formatPrice($minPrice),'maxPrice' => formatPrice($maxPrice),'cntPos' => $cntPos ];
}

// получение цвета шоссе
function getColorRoad($id_enum){
	switch ($id_enum) {
		case 201: $color = 'one'; break; // Киевское
		case 130: $color = 'two'; break; // Каширское
		case 211: $color = 'two'; break; // Волоколамское
		case 188: $color = 'two'; break; // Ленинградское
		case 190: $color = 'two'; break; // Таракановское
		case 249: $color = 'two'; break; // Лихачевское
		case 199: $color = 'three'; break; // Щелковское
		case 266: $color = 'three'; break; // Рублёво-Успенское
		case 251: $color = 'four'; break; // Минское
		case 253: $color = 'four'; break; // Можайское
		// case 129: $color = 'five'; break; //
		case 221: $color = 'six'; break; // Ярославское
		case 207: $color = 'six'; break; // Калужское
		case 243: $color = 'six'; break; // Фряновское
		case 191: $color = 'seven'; break; // Новорязанское
		case 137: $color = 'seven'; break; // Егорьевское
		case 245: $color = 'seven'; break; // Пятницкое
		case 178: $color = 'seven'; break; // Рогачёвское
		case 205: $color = 'seven'; break; // Новорижское
		case 198: $color = 'eight'; break; // Горьковское
		case 196: $color = 'eight'; break; // Носовихинское
		case 179: $color = 'nine'; break; // Дмитровское
		case 129: $color = 'nine'; break; // Симферопольское
		case 265: $color = 'nine'; break; // Варшавское
		case 179: $color = 'ten'; break; // Дмитровское
		// case 129: $color = 'eleven'; break; //
		// case 129: $color = 'twelve'; break; //
		// СПБ
		case 379: $color = 'two'; break; // Приморское
		case 374: $color = 'two'; break; // Левашовское
		case 369: $color = 'two'; break; // Гостилицкое
		case 547: $color = 'seven'; break; // ЗСД
		case 364: $color = 'seven'; break; // Белоостровское
		case 362: $color = 'seven'; break; // Александровское
		case 366: $color = 'three'; break; // Выборгское
		case 368: $color = 'three'; break; // Горское
		case 380: $color = 'three'; break; // Приозерское
		case 548: $color = 'three'; break; // Новоприозерское
		case 376: $color = 'three'; break; // Московское
		case 372: $color = 'three'; break; // Киевское
		case 381: $color = 'three'; break; // Пулковское
		case 365: $color = 'three'; break; // Волхонское
		case 383: $color = 'one'; break; // Рябовское
		case 370: $color = 'one'; break; // Дорога жизни
		case 549: $color = 'one'; break; // Е20
		case 382: $color = 'one'; break; // Ропшинское
		case 363: $color = 'one'; break; // Аннинское
		case 367: $color = 'one'; break; // Гатчинское
		case 373: $color = 'one'; break; // Красносельское
		case 377: $color = 'six'; break; // Мурманское
		case 378: $color = 'six'; break; // Петрозаводское
	}
	return $color;
}

// код jivosite от шоссе
function getInfoHW($idEnum){
	switch ($idEnum) {
		case 201: $color = 'one'; $jivosite = ''; break; // Киевское
		case 130: $color = 'two'; $jivosite = 'nTstbLwJ2I'; break; // Каширское
		case 211: $color = 'two'; $jivosite = ''; break; // Волоколамское
		case 188: $color = 'two'; $jivosite = 'PBbaYrBnyt'; break; // Ленинградское
		case 190: $color = 'two'; $jivosite = ''; break; // Таракановское
		case 249: $color = 'two'; $jivosite = ''; break; // Лихачевское
		case 199: $color = 'three'; $jivosite = 'nTstbLwJ2I'; break; // Щелковское
		case 266: $color = 'three'; $jivosite = ''; break; // Рублёво-Успенское
		case 251: $color = 'four'; $jivosite = ''; break; // Минское
		case 253: $color = 'four'; $jivosite = ''; break; // Можайское
		case 221: $color = 'six'; $jivosite = 'PBbaYrBnyt'; break; // Ярославское
		case 207: $color = 'six'; $jivosite = 'nTstbLwJ2I'; break; // Калужское
		case 243: $color = 'six'; $jivosite = ''; break; // Фряновское
		case 191: $color = 'seven'; $jivosite = 'nTstbLwJ2I'; break; // Новорязанское
		case 137: $color = 'seven'; $jivosite = 'nTstbLwJ2I'; break; // Егорьевское
		case 245: $color = 'seven'; $jivosite = ''; break; // Пятницкое
		case 178: $color = 'seven'; $jivosite = 'PBbaYrBnyt'; break; // Рогачёвское
		case 205: $color = 'seven'; $jivosite = 'PBbaYrBnyt'; break; // Новорижское
		case 198: $color = 'eight'; $jivosite = 'nTstbLwJ2I'; break; // Горьковское
		case 196: $color = 'eight'; $jivosite = 'nTstbLwJ2I'; break; // Носовихинское
		case 129: $color = 'nine'; $jivosite = 'nTstbLwJ2I'; break; // Симферопольское
		case 265: $color = 'nine'; $jivosite = 'nTstbLwJ2I'; break; // Варшавское
		case 179: $color = 'ten'; $jivosite = 'PBbaYrBnyt'; break; // Дмитровское
		// СПБ
		case 379: $color = 'two'; $jivosite = ''; break; // Приморское
		case 374: $color = 'two'; $jivosite = ''; break; // Левашовское
		case 369: $color = 'two'; $jivosite = ''; break; // Гостилицкое
		case 547: $color = 'seven'; $jivosite = ''; break; // ЗСД
		case 364: $color = 'seven'; $jivosite = ''; break; // Белоостровское
		case 362: $color = 'seven'; $jivosite = ''; break; // Александровское
		case 366: $color = 'three'; $jivosite = ''; break; // Выборгское
		case 368: $color = 'three'; $jivosite = ''; break; // Горское
		case 380: $color = 'three'; $jivosite = ''; break; // Приозерское
		case 548: $color = 'three'; $jivosite = ''; break; // Новоприозерское
		case 376: $color = 'three'; $jivosite = ''; break; // Московское
		case 372: $color = 'three'; $jivosite = ''; break; // Киевское
		case 381: $color = 'three'; $jivosite = ''; break; // Пулковское
		case 365: $color = 'three'; $jivosite = ''; break; // Волхонское
		case 383: $color = 'one'; $jivosite = ''; break; // Рябовское
		case 370: $color = 'one'; $jivosite = ''; break; // Дорога жизни
		case 549: $color = 'one'; $jivosite = ''; break; // Е20
		case 382: $color = 'one'; $jivosite = ''; break; // Ропшинское
		case 363: $color = 'one'; $jivosite = ''; break; // Аннинское
		case 367: $color = 'one'; $jivosite = ''; break; // Гатчинское
		case 373: $color = 'one'; $jivosite = ''; break; // Красносельское
		case 377: $color = 'six'; $jivosite = ''; break; // Мурманское
		case 378: $color = 'six'; $jivosite = ''; break; // Петрозаводское
		default: $color = 'nine'; $jivosite = ''; break; // Остальные
	}
	$arInfoHW = [
		'COLOR' => $color,
		'JIVOSITE' => $jivosite
	];
	return $arInfoHW;
}

// получим названия шоссе
function getNameRoad($idRoad){
	$property_enums = CIBlockPropertyEnum::GetList(
		Array("DEF"=>"DESC", "SORT"=>"ASC"),
		Array("IBLOCK_ID"=>IBLOCK_ID, "CODE"=>"SHOSSE")
	);
	while($enum_fields = $property_enums->GetNext())
	{
	  // echo $enum_fields["ID"]." - ".$enum_fields["VALUE"]."<br>";
		$newName = str_replace('кое','кому',$enum_fields["VALUE"]); // склонение
		$arNameRoads[$enum_fields["ID"]] = $newName;
	}

	return $arNameRoads[$idRoad];
}

function getRoadName($value){
	switch ($value) {
		case 'Асфальт': $arRoadName['WHAT'] = 'Асфальтированная дорога'; break;
		case 'Щебень': $arRoadName['WHAT'] = 'Дорога из щебня'; break;
		case 'Битый кирпич': $arRoadName['WHAT'] = 'Дорога из битого кирпича'; break;
		case 'Грунтовка': $arRoadName['WHAT'] = 'Грунтовая дорога'; break;
		case 'Асф. кр.': $arRoadName['WHAT'] = 'Дорога из асфальтовой крошки'; break;
		case 'Бетонные плиты': $arRoadName['WHAT'] = 'Дорога из бетонных плит'; break;
		default: $arRoadName['WHAT'] = 'Нет дороги'; break;
	}

	return $arRoadName;
}

// получим названия из списка для отдельных страниц
function getNamesList($codeRoad,$codeProp,$iblockID = 1){
	$iblockID = IBLOCK_ID;
	$property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblockID, "CODE"=>$codeProp,"XML_ID" => $codeRoad));
	if($enum_fields = $property_enums->GetNext()){
		$nameKomu = str_replace(['кое','кий','кой'],'кому',$enum_fields["VALUE"]); // склонение
		$nameKom = str_replace(['кое','кий','кой'],'ком',$enum_fields["VALUE"]); // склонение
		$nameKogo = str_replace(['кое','кий','кой'],'кого',$enum_fields["VALUE"]); // склонение
		$namesRoad = [
			"ID" => $enum_fields['ID'],
			"NAME" => $enum_fields['VALUE'],
			"NAME_KOMU" => $nameKomu,
			"NAME_KOM" => $nameKom,
			"NAME_KOGO" => $nameKogo,
		];
	}

	return $namesRoad;
}

// замена областей
function shortNameObl($idEnumObl){
	switch ($idEnumObl) {
		case 127: // Московская обл.
			$shortName = 'МО';
			break;

		default:
			$shortName = 'МО';
			break;
	}
	return $shortName;
}

// получение координат поселка
function curl_get_coordinates($adresItem){
	// адрес, к которому обращаемс¤
	$url = 'https://geocode-maps.yandex.ru/1.x/?format=json&geocode='.$adresItem;

	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	$data = curl_exec($curl);
	curl_close($curl);

	// ѕреобразуем json в обычный массив
	$response = json_decode($data, true); //dump($response);
	// ѕолучаем из массива координаты дл¤ карты.
	$point = $response['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
	// ѕочему то координаты отдаютс¤ не в том пор¤дке. ƒл¤ карты нужно помен¤ть местами широту и долготу плюс мен¤ем пробел на зап¤тую
	$point = explode(' ', $point);
	$point = implode(', ', array_reverse($point)); //dump($point);
	return $point;
}

// Склоняем словоформу
function morph($n, $f1, $f2, $f5) {
	$n = abs(intval($n)) % 100;
	if ($n>10 && $n<20) return $f5;
	$n = $n % 10;
	if ($n>1 && $n<5) return $f2;
	if ($n==1) return $f1;
	return $f5;
}

// сумма прописью
function num2str($num) {
	$nul='ноль';
	$ten=array(
		array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
		array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
	);
	$a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
	$tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
	$hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
	$unit=array( // Units
		array('копейка' ,'копейки' ,'копеек',	 1),
		array('рубль'   ,'рубля'   ,'рублей'    ,0),
		array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
		array('миллион' ,'миллиона','миллионов' ,0),
		array('миллиард','милиарда','миллиардов',0),
	);
	//
	list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
	$out = array();
	if (intval($rub)>0) {
		foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
			if (!intval($v)) continue;
			$uk = sizeof($unit)-$uk-1; // unit key
			$gender = $unit[$uk][3];
			list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
			// mega-logic
			$out[] = $hundred[$i1]; # 1xx-9xx
			if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
			else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
			// units without rub & kop
			if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
		} //foreach
	}
	else $out[] = $nul;
	// $out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
	// $out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
	return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}

// получение элементов HL-блока
function getElHL($idHL,$order,$filter,$select){

	$hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById($idHL)->fetch();
	$entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
	$entity_data_class = $entity->getDataClass();
	$entity_table_name = $hlblock['TABLE_NAME'];
	$sTableID = 'tbl_'.$entity_table_name;

	$rsData = $entity_data_class::getList([
		'order' => $order,
	  'filter' => $filter,
		'select' => $select
	]);
	$rsData = new CDBResult($rsData, $sTableID);

	while($arRes = $rsData->Fetch()){
		$arElements[$arRes['ID']] = $arRes;
	}
	return $arElements;
}

AddEventHandler('iblock', 'OnBeforeIBlockElementAdd', array('MyClass', 'OnBeforeIBlockElementHandler'));
AddEventHandler('iblock', 'OnBeforeIBlockElementUpdate', array('MyClass', 'OnBeforeIBlockElementHandler'));

class MyClass
{
  public function OnBeforeIBlockElementHandler(&$arFields)
  {
		// dump($arFields);die();
		if($arFields['PROPERTY_VALUES'][58])
		{
			foreach ($arFields['PROPERTY_VALUES'][58] as $value) {
				$point = $value['VALUE'];
				$point = str_replace([' ',chr(0xC2).chr(0xA0)],'',$point);
				// проверка на правильность координат по регулярки
				$pattern = '/^([0-9]{2}\.[0-9]+,[0-9]{2}\.[0-9]+)?$/';
				if(!preg_match($pattern, $point)){
					global $APPLICATION;
          $APPLICATION->throwException('Не правильно введены координаты поселка! Нужно в формате: 99.99,99.99');
          return false;
				}
			}
		}

		if ($arFields['IBLOCK_ID'] == 1) // История стоимость сотки
		{
			$firstKey = array_key_first($arFields['PROPERTY_VALUES'][8]);
			$priceMin = $arFields['PROPERTY_VALUES'][8][$firstKey]['VALUE'];

			$idHL = 19;
			$hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById($idHL)->fetch();
			$entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
			$entity_data_class = $entity->getDataClass();
			$entity_table_name = $hlblock['TABLE_NAME'];
			$sTableID = 'tbl_'.$entity_table_name;

			$rsData = $entity_data_class::getList([
				'order' => ['ID'=>'DESC'],
			  'filter' => ['UF_VILLAGE' => $arFields['ID']],
				'select' => ['UF_PRICE']
			]);
			$rsData = new CDBResult($rsData, $sTableID);
			if ($arRes = $rsData->Fetch())
				$priceMinOld = $arRes['UF_PRICE'];

			if (!$priceMinOld || $priceMinOld != $priceMin)
			{
				$data =[
					"UF_VILLAGE" => $arFields['ID'],
			    "UF_PRICE" => $priceMin,
					"UF_DATE" => date('d.m.Y')
				];
				$result = $entity_data_class::add($data);
			}
		}
  }
}

// обработка 404 ошибки
AddEventHandler('main', 'OnEpilog', '_Check404Error', 1);
function _Check404Error(){
	if (defined('ERROR_404') && ERROR_404 == 'Y') {
		global $APPLICATION;
		$APPLICATION->RestartBuffer();
		include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/header.php';
		include $_SERVER['DOCUMENT_ROOT'] . '/404.php';
		include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/footer.php';
	}
}

// скрываем админку
// AddEventHandler("main", "OnEndBufferContent", "noAdminBitrix");
// function noAdminBitrix(&$content){
// 	if (CSite::InDir('/bitrix/') && !CSite::InGroup([1,5,6])) LocalRedirect("/404.php");
// }

// мое удаление
function DeleteElement($ID){
	global $DB, $APPLICATION;

  $isOrderConverted = \Bitrix\Main\Config\Option::get("main", "~sale_converted_15", 'Y');

  $ID = intval($ID);
  if (0 >= $ID)
      return false;

  if ($isOrderConverted != 'N')
  {
      /** @var \Bitrix\Sale\Result $r */
      $r = \Bitrix\Sale\Compatible\BasketCompatibility::delete($ID);
      if (!$r->isSuccess(true))
      {
          foreach($r->getErrorMessages() as $error)
          {
              $APPLICATION->ThrowException($error);
          }

          return false;
      }

      //return true;
  }

  $rsBaskets = CSaleBasket::GetList(
      array(),
      array('ID' => $ID),
      false,
      false,
      array(
          'ID',
          'ORDER_ID',
          'PRODUCT_ID',
          'NAME',
          'SUBSCRIBE',
          'FUSER_ID',
          'TYPE',
          'SET_PARENT_ID'
      )
  );
  if (!($arBasket = $rsBaskets->Fetch()))
      return false;

  foreach(GetModuleEvents("sale", "OnBeforeBasketDelete", true) as $arEvent)
      if (ExecuteModuleEventEx($arEvent, array($ID))===false)
          return false;

  if (CSaleBasketHelper::isSetParent($arBasket))
  {
      $rsSetItems = CSaleBasket::GetList(
          array(),
          array("SET_PARENT_ID" => $ID, "TYPE" => ""),
          false,
          false,
          array(
              'ID',
              'ORDER_ID',
              'PRODUCT_ID',
              'NAME',
              'SUBSCRIBE',
              'FUSER_ID',
              'TYPE',
              'SET_PARENT_ID'
          )
      );
      while ($arSetItem = $rsSetItems->GetNext())
      {
          CSaleBasket::Delete($arSetItem["ID"]);
      }
  }

  if (0 < intval($arBasket["ORDER_ID"]))
      CSaleOrderChange::AddRecord($arBasket["ORDER_ID"], "BASKET_REMOVED", array("PRODUCT_ID" => $arBasket["PRODUCT_ID"], "NAME" => $arBasket["NAME"]));

  $DB->Query("DELETE FROM b_sale_basket_props WHERE BASKET_ID = ".$ID, true);

  if(intval($_SESSION["SALE_BASKET_NUM_PRODUCTS"][SITE_ID]) > 0 && !CSaleBasketHelper::isSetItem($arBasket))
      $_SESSION["SALE_BASKET_NUM_PRODUCTS"][SITE_ID]--;

  $DB->Query("DELETE FROM b_sale_store_barcode WHERE BASKET_ID = ".$ID, true);

  $DB->Query("DELETE FROM b_sale_basket WHERE ID = ".$ID, true);

  if ('Y' == $arBasket['SUBSCRIBE'] && array_key_exists('NOTIFY_PRODUCT', $_SESSION))
  {
      $intUserID = CSaleUser::GetUserID($arBasket['FUSER_ID']);
      if ($intUserID && array_key_exists($intUserID, $_SESSION['NOTIFY_PRODUCT']))
      {
          if (array_key_exists($arBasket['PRODUCT_ID'], $_SESSION['NOTIFY_PRODUCT'][$intUserID]))
          {
              unset($_SESSION['NOTIFY_PRODUCT'][$intUserID][$arBasket['PRODUCT_ID']]);
          }
      }
  }

  foreach(GetModuleEvents("sale", "OnBasketDelete", true) as $arEvent)
      ExecuteModuleEventEx($arEvent, array($ID));

  return true;
}
?>
