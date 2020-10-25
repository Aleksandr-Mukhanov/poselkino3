<?
if(file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/amo.php"))
	require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/amo.php");

// тест вывод
function dump($el){
	global $USER;
	if($USER->IsAdmin()){
		echo "<pre>";print_r($el);echo "</pre>";
	}
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
	}
	return $color;
}

// получим названия шоссе
function getNameRoad($idRoad){
	$property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>1, "CODE"=>"SHOSSE"));
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
function getNamesList($codeRoad,$codeProp){
	$property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>1, "CODE"=>$codeProp,"XML_ID" => $codeRoad));
	if($enum_fields = $property_enums->GetNext()){
		$nameKomu = str_replace(['кое','кий','кой'],'кому',$enum_fields["VALUE"]); // склонение
		$nameKom = str_replace(['кое','кий','кой'],'ком',$enum_fields["VALUE"]); // склонение
		$namesRoad = [
			"ID" => $enum_fields['ID'],
			"NAME" => $enum_fields['VALUE'],
			"NAME_KOMU" => $nameKomu,
			"NAME_KOM" => $nameKom,
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
