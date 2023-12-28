<?php header('Content-Type: text/html; charset=utf-8');
$_SERVER["DOCUMENT_ROOT"] = '/var/www/u0428181/data/www/olne.ru';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
	Loader::includeModule('iblock');

  // Получим поселки
	$arOrder = Array("NAME"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>1,"ACTIVE"=>"Y");
	$arSelect = Array("ID","NAME","PROPERTY_MKAD","PROPERTY_ELECTRO_DONE","PROPERTY_PROVEDEN_GAZ","PROPERTY_PROVEDENA_VODA","PROPERTY_LAND_CAT","PROPERTY_TYPE_USE","PROPERTY_INDUSTRIAL_ZONE","PROPERTY_INDUSTRIAL_ZONE_KM","PROPERTY_LANDFILL","PROPERTY_LANDFILL_KM","PROPERTY_FLOOD","PROPERTY_LES","PROPERTY_WATER","PROPERTY_PLYAZH","PROPERTY_SOIL","PROPERTY_SETTLEM_KM","PROPERTY_RAILWAY_KM","PROPERTY_BUS_TIME_KM","PROPERTY_ROADS_IN_VIL","PROPERTY_ROADS_TO_VIL","PROPERTY_ARRANGE","PROPERTY_MAGAZIN","PROPERTY_ART_WELLS_DEPTH","PROPERTY_TYPE","PROPERTY_RATING");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
	while($arResult = $rsElements->GetNext()){
		// dump($arResult);
    // подсчет рейтинга
    $ourRating = 0; $elRating = 0;
    $MKAD = $arResult["PROPERTY_MKAD_VALUE"];
    $ELECTRO_DONE = $arResult["PROPERTY_ELECTRO_DONE_ENUM_ID"];
    $PROVEDEN_GAZ = $arResult["PROPERTY_PROVEDEN_GAZ_ENUM_ID"];
    $PROVEDENA_VODA = $arResult["PROPERTY_PROVEDENA_VODA_ENUM_ID"];
    $LAND_CAT = $arResult["PROPERTY_LAND_CAT_ENUM_ID"];
    $TYPE_USE = $arResult["PROPERTY_TYPE_USE_ENUM_ID"];
    // $INDUSTRIAL_ZONE = strtolower($arResult["PROPERTY_INDUSTRIAL_ZONE_VALUE"]);
		$INDUSTRIAL_ZONE = $arResult["PROPERTY_INDUSTRIAL_ZONE_ENUM_ID"];
    $INDUSTRIAL_ZONE_KM = $arResult["PROPERTY_INDUSTRIAL_ZONE_KM_VALUE"];
    // $LANDFILL = strtolower($arResult["PROPERTY_LANDFILL_VALUE"]);
		$LANDFILL = $arResult["PROPERTY_LANDFILL_ENUM_ID"];
    $LANDFILL_KM = $arResult["PROPERTY_LANDFILL_KM_VALUE"];
    // $FLOOD = strtolower($arResult["PROPERTY_FLOOD_VALUE"]);
		$FLOOD = $arResult["PROPERTY_FLOOD_ENUM_ID"];
    // $LES = strtolower($arResult["PROPERTY_LES_VALUE"]);
		$LES = $arResult["PROPERTY_LES_ENUM_ID"];
    $WATER = $arResult["PROPERTY_WATER_VALUE"];
    // $PLYAZH = strtolower($arResult["PROPERTY_PLYAZH_VALUE"]);
		$PLYAZH = $arResult["PROPERTY_PLYAZH_ENUM_ID"];
    $SOIL = $arResult["PROPERTY_SOIL_VALUE"]; // тут по своему
    $SETTLEM_KM = $arResult["PROPERTY_SETTLEM_KM_VALUE"];
    $RAILWAY_KM = $arResult["PROPERTY_RAILWAY_KM_VALUE"];
    $BUS_TIME_KM = $arResult["PROPERTY_BUS_TIME_KM_VALUE"];
    $ROADS_IN_VIL = $arResult["PROPERTY_ROADS_IN_VIL_ENUM_ID"];
    $ROADS_TO_VIL = $arResult["PROPERTY_ROADS_TO_VIL_ENUM_ID"];
    $ARRANGE = count($arResult["PROPERTY_ARRANGE_VALUE"]);
    $MAGAZIN = $arResult["PROPERTY_MAGAZIN_ENUM_ID"];
    $ART_WELLS_DEPTH = $arResult["PROPERTY_ART_WELLS_DEPTH_VALUE"];

    if($arResult["PROPERTY_TYPE_ENUM_ID"] == 2){ // Коттеджный поселок

			switch($MKAD){ // Удаленность от МКАД, км
				case $MKAD < 21: $elRating = 5; break;
				case $MKAD < 41: $elRating = 4; break;
				case $MKAD < 71: $elRating = 3; break;
				default: $elRating = 2; break;
			} // echo "MKAD: ".$MKAD.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($ELECTRO_DONE){ // Электричество (проведен)
				case 13: $elRating = 0; break; // Не проведен
				case 14: $elRating = 5; break; // Проведен
				case 147: $elRating = 3; break; // Перспектива
				default: $elRating = 0; break;
			} // echo "ELECTRO_DONE: ".$ELECTRO_DONE.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($PROVEDEN_GAZ){ // Газ (проведен)
				case 16: $elRating = 1.6; break; // Не проведен
				case 17: $elRating = 4; break; // Проведен
				case 104: $elRating = 2.4; break; // Перспектива
				default: $elRating = 0; break;
			} // echo "PROVEDEN_GAZ: ".$PROVEDEN_GAZ.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($PROVEDENA_VODA){ // Водопровод  (проведен)
				case 19: $elRating = 0; break; // Перспектива
				case 20: $elRating = 2.5; break; // Проведен
				case 106: $elRating = 2; break; // Не проведен
				default: $elRating = 2; break;
			} // echo "PROVEDENA_VODA: ".$PROVEDENA_VODA.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($LAND_CAT){ // Категория земель
				case 107: $elRating = 2.4; break; // С/х назначение
				case 153: $elRating = 4; break; // Населенный пункт
				default: $elRating = 0; break;
			} // echo "LAND_CAT: ".$LAND_CAT.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($TYPE_USE){ // Вид разрешенного использования
				case 154: $elRating = 4; break; // Индвидуальное жилищное строительство
				case 228: $elRating = 4; break; // Для жилищного строительства
				case 108: $elRating = 3.2; break; // Для дачного строительства
				case 150: $elRating = 3.2; break; // Для дачного строительства с правом возведения жилого дома и проживания в нем
				default: $elRating = 1.6; break;
			} // echo "TYPE_USE: ".$TYPE_USE.": ".$elRating."<br>";
			$ourRating += $elRating;

			if($INDUSTRIAL_ZONE != 110){	// если есть Промзона
				switch($INDUSTRIAL_ZONE_KM){ // Промзона (удаленность)
					case $INDUSTRIAL_ZONE_KM < 5: $elRating = 0.8; break;
					case $INDUSTRIAL_ZONE_KM < 10: $elRating = 1.6; break;
					case $INDUSTRIAL_ZONE_KM < 20: $elRating = 2.4; break;
					case $INDUSTRIAL_ZONE_KM < 30: $elRating = 3.2; break;
					default: $elRating = 4; break;
				}
			}else{
				$elRating = 4;
			} // echo "INDUSTRIAL_ZONE_KM: ".$INDUSTRIAL_ZONE_KM.": ".$elRating."<br>";
			$ourRating += $elRating;

			if($LANDFILL != 111){	// если есть Полигон ТБО
				switch($LANDFILL_KM){ // Полигон ТБО (удаленность)
					case $LANDFILL_KM < 5: $elRating = 1; break;
					case $LANDFILL_KM < 10: $elRating = 2; break;
					case $LANDFILL_KM < 20: $elRating = 3; break;
					case $LANDFILL_KM < 30: $elRating = 4; break;
					default: $elRating = 5; break;
				}
			}else{
				$elRating = 5;
			} // echo "LANDFILL_KM: ".$LANDFILL_KM.": ".$elRating."<br>";
			$ourRating += $elRating;

			$elRating = ($FLOOD != 132) ? 2.1 : 3.5 ; // Паводок
			// echo "FLOOD: ".$FLOOD.": ".$elRating."<br>";
			$ourRating += $elRating;

			$elRating = ($LES != 143) ? 4.5 : 2.7 ; // Лес
			// echo "LES: ".$LES.": ".$elRating."<br>";
			$ourRating += $elRating;

			$elRating = (!array_key_exists(152,$WATER)) ? 4 : 3.2 ; // Водоем
			// echo "WATER: ".dump($WATER).": ".$elRating."<br>";
			$ourRating += $elRating;

			$elRating = ($PLYAZH != 144) ? 2.5 : 2 ; // Пляж для купания
			// echo "PLYAZH: ".$PLYAZH.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($SOIL){ // Почва
				case array_key_exists(45,$SOIL): $elRating = 3; break; // Чернозем
				case array_key_exists(46,$SOIL): $elRating = 3; break; // Песок
				case array_key_exists(47,$SOIL): $elRating = 2.4; break; // Суглинок
				default: $elRating = 2.4; break;
			} // echo "SOIL: ".dump($SOIL).": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($SETTLEM_KM){ // Ближайший населенный пункт расстояние, км
				case $SETTLEM_KM <= 5: $elRating = 3; break;
				case $SETTLEM_KM <= 10: $elRating = 2.4; break;
				default: $elRating = 1.8; break;
			} // echo "SETTLEM_KM: ".$SETTLEM_KM.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($RAILWAY_KM){ // Ближайшая ж/д станция расстояние до поселка, км
				case $RAILWAY_KM <= 5: $elRating = 4; break;
				default: $elRating = 3.2; break;
			} // echo "RAILWAY_KM: ".$RAILWAY_KM.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($BUS_TIME_KM){ // Автобус (расстояние от остановки, км)
				case $BUS_TIME_KM <= 2: $elRating = 3.5; break;
				default: $elRating = 2.8; break;
			} // echo "BUS_TIME_KM: ".$BUS_TIME_KM.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($ROADS_IN_VIL){ // Дороги в поселке
				case 59: $elRating = 4.5; break; // Асфальт
				case 60: $elRating = 3.6; break; // Щебень
				case 156: $elRating = 3.6; break; // Асф. кр.
				case 158: $elRating = 2.7; break; // Бетонные плиты
				default: $elRating = 1.8; break;
			} // echo "ROADS_IN_VIL: ".$ROADS_IN_VIL.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($ROADS_TO_VIL){ // Дороги до поселка
				case 63: $elRating = 4.5; break; // Асфальт
				case 64: $elRating = 3.6; break; // Щебень
				case 159: $elRating = 3.6; break; // Асф. кр.
				case 145: $elRating = 2.7; break; // Бетонные плиты
				default: $elRating = 1.8; break;
			} // echo "ROADS_TO_VIL: ".$ROADS_TO_VIL.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($ARRANGE){ // Обустройство поселка
				case 2: $elRating = 3.5; break; // 2 значения
				case 1: $elRating = 2.8; break; // 1 значение
				default: $elRating = 2.1; break;
			} // echo "ARRANGE: ".$ARRANGE.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($MAGAZIN){ // Магазин
				case 72: $elRating = 3.5; break; // В поселке
				case 113: $elRating = 2.8; break; // В радиусе 5км
				default: $elRating = 0.7; break;
			} // echo "MAGAZIN: ".$MAGAZIN.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($ART_WELLS_DEPTH){ // Артезианские скважины на участках глубина, м
				case $ART_WELLS_DEPTH <= 40: $elRating = 3; break;
				case $ART_WELLS_DEPTH <= 60: $elRating = 2.4; break;
				default: $elRating = 1.8; break;
			} // echo "ART_WELLS_DEPTH: ".$ART_WELLS_DEPTH.": ".$elRating."<br>";
			$ourRating += $elRating;

    }elseif($arResult["PROPERTY_TYPE_ENUM_ID"] == 1){ // Дачный поселок

			switch($MKAD){ // Удаленность от МКАД, км
				case $MKAD < 41: $elRating = 5; break;
				case $MKAD < 61: $elRating = 4; break;
				case $MKAD < 81: $elRating = 3; break;
				default: $elRating = 2; break;
			} // echo "MKAD: ".$MKAD.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($ELECTRO_DONE){ // Электричество (проведен)
				case 13: $elRating = 0; break; // Не проведен
				case 14: $elRating = 5; break; // Проведен
				case 147: $elRating = 3; break; // Перспектива
				default: $elRating = 0; break;
			} // echo "ELECTRO_DONE: ".$ELECTRO_DONE.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($PROVEDEN_GAZ){ // Газ (проведен)
				case 16: $elRating = 2.4; break; // Не проведен
				case 17: $elRating = 4; break; // Проведен
				case 104: $elRating = 3.2; break; // Перспектива
				default: $elRating = 0; break;
			} // echo "PROVEDEN_GAZ: ".$PROVEDEN_GAZ.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($PROVEDENA_VODA){ // Водопровод  (проведен)
				case 19: $elRating = 0; break; // Перспектива
				case 20: $elRating = 2.5; break; // Проведен
				case 106: $elRating = 2; break; // Не проведен
				default: $elRating = 2; break;
			} // echo "PROVEDENA_VODA: ".$PROVEDENA_VODA.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($LAND_CAT){ // Категория земель
				case 107: $elRating = 3.2; break; // С/х назначение
				case 153: $elRating = 4; break; // Населенный пункт
				default: $elRating = 0; break;
			} // echo "LAND_CAT: ".$LAND_CAT.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($TYPE_USE){ // Вид разрешенного использования
				case 108: $elRating = 4; break; // Для дачного строительства
				case 150: $elRating = 4; break; // Для дачного строительства с правом возведения жилого дома и проживания в нем
				case 154: $elRating = 4; break; // Индвидуальное жилищное строительство
				case 228: $elRating = 4; break; // Для жилищного строительства
				case 123: $elRating = 3.2; break; // Для садоводства
				case 162: $elRating = 2.4; break; // Для огородничества
				default: $elRating = 1.6; break;
			} // echo "TYPE_USE: ".$TYPE_USE.": ".$elRating."<br>";
			$ourRating += $elRating;

			if($INDUSTRIAL_ZONE != 110){	// если есть Промзона
				switch($INDUSTRIAL_ZONE_KM){ // Промзона (удаленность)
					case $INDUSTRIAL_ZONE_KM < 5: $elRating = 0.8; break;
					case $INDUSTRIAL_ZONE_KM < 10: $elRating = 1.6; break;
					case $INDUSTRIAL_ZONE_KM < 20: $elRating = 2.4; break;
					case $INDUSTRIAL_ZONE_KM < 30: $elRating = 3.2; break;
					default: $elRating = 4; break;
				}
			}else{
				$elRating = 4;
			} // echo "INDUSTRIAL_ZONE: ".$INDUSTRIAL_ZONE_KM.": ".$elRating."<br>";
			$ourRating += $elRating;

			if($LANDFILL != 111){	// если есть Полигон ТБО
				switch($LANDFILL_KM){ // Полигон ТБО (удаленность)
					case $LANDFILL_KM < 5: $elRating = 1; break;
					case $LANDFILL_KM < 10: $elRating = 2; break;
					case $LANDFILL_KM < 20: $elRating = 3; break;
					case $LANDFILL_KM < 30: $elRating = 4; break;
					default: $elRating = 5; break;
				}
			}else{
				$elRating = 5;
			} // echo "LANDFILL: ".$LANDFILL_KM.": ".$elRating."<br>";
			$ourRating += $elRating;

			$elRating = ($FLOOD != 132) ? 2.1 : 3.5 ; // Паводок
			// echo "FLOOD: ".$FLOOD.": ".$elRating."<br>";
			$ourRating += $elRating;

			$elRating = ($LES != 143) ? 4.5 : 2.7 ; // Лес
			// echo "LES: ".$LES.": ".$elRating."<br>";
			$ourRating += $elRating;

			$elRating = (!array_key_exists(152,$WATER)) ? 4 : 3.2 ; // Водоем
			// echo "WATER: ".$WATER.": ".$elRating."<br>";
			$ourRating += $elRating;

			$elRating = ($PLYAZH != 144) ? 2.5 : 2 ; // Пляж для купания
			// echo "PLYAZH: ".$PLYAZH.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($SOIL){ // Почва
				case array_key_exists(45,$SOIL): $elRating = 3; break; // Чернозем
				case array_key_exists(46,$SOIL): $elRating = 2.4; break; // Песок
				case array_key_exists(47,$SOIL): $elRating = 1.8; break; // Суглинок
				default: $elRating = 1.8; break;
			} // echo "SOIL: ".$SOIL.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($SETTLEM_KM){ // Ближайший населенный пункт расстояние, км
				case $SETTLEM_KM <= 10: $elRating = 3; break;
				case $SETTLEM_KM <= 15: $elRating = 2.4; break;
				default: $elRating = 1.8; break;
			} // echo "SETTLEM_KM: ".$SETTLEM_KM.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($RAILWAY_KM){ // Ближайшая ж/д станция расстояние до поселка, км
				case $RAILWAY_KM <= 3: $elRating = 4; break;
				case $RAILWAY_KM <= 5: $elRating = 3.2; break;
				default: $elRating = 2.4; break;
			} // echo "RAILWAY_KM: ".$RAILWAY_KM.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($BUS_TIME_KM){ // Автобус (расстояние от остановки, км)
				case $BUS_TIME_KM <= 1: $elRating = 3.5; break;
				case $BUS_TIME_KM <= 2: $elRating = 2.8; break;
				default: $elRating = 2.1; break;
			} // echo "BUS_TIME_KM: ".$BUS_TIME_KM.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($ROADS_IN_VIL){ // Дороги в поселке
				case 59: $elRating = 4.5; break; // Асфальт
				case 60: $elRating = 4.5; break; // Щебень
				case 156: $elRating = 4.5; break; // Асф. кр.
				case 158: $elRating = 4.5; break; // Бетонные плиты
				default: $elRating = 2.7; break;
			} // echo "ROADS_IN_VIL: ".$ROADS_IN_VIL.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($ROADS_TO_VIL){ // Дороги до поселка
				case 63: $elRating = 4.5; break; // Асфальт
				case 64: $elRating = 4.5; break; // Щебень
				case 159: $elRating = 4.5; break; // Асф. кр.
				case 145: $elRating = 4.5; break; // Бетонные плиты
				default: $elRating = 2.7; break;
			} // echo "ROADS_TO_VIL: ".$ROADS_TO_VIL.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($ARRANGE){ // Обустройство поселка
				case 2: $elRating = 3.5; break; // 2 значения
				case 1: $elRating = 3.5; break; // 1 значение
				default: $elRating = 2.8; break;
			} // echo "ARRANGE: ".$ARRANGE.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($MAGAZIN){ // Магазин
				case 72: $elRating = 3.5; break; // В поселке
				case 113: $elRating = 2.1; break; // В радиусе 5км
				default: $elRating = 0.7; break;
			} // echo "MAGAZIN: ".$MAGAZIN.": ".$elRating."<br>";
			$ourRating += $elRating;

			switch($ART_WELLS_DEPTH){ // Артезианские скважины на участках глубина, м
				case $ART_WELLS_DEPTH <= 40: $elRating = 3; break;
				case $ART_WELLS_DEPTH <= 60: $elRating = 2.4; break;
				default: $elRating = 1.8; break;
			} // echo "ART_WELLS_DEPTH: ".$ART_WELLS_DEPTH.": ".$elRating."<br>";
			$ourRating += $elRating;
    }
		$maxBal = 80.5;
		$procBal = $ourRating * 100 / $maxBal;
		$patiBall = $procBal * 5 / 100;
		$ratingItogo = round($patiBall,1);

    echo $arResult['NAME'].': '.$ratingItogo.'<br>';
    $idEl = $arResult['ID'];
    $IBLOCK_ID = 1;
    $PROPERTY_VAL = $ratingItogo;
    $PROPERTY_CODE = 'RATING';
    if($arResult["PROPERTY_RATING_VALUE"] != $ratingItogo){
      CIBlockElement::SetPropertyValues($idEl, $IBLOCK_ID, $PROPERTY_VAL, $PROPERTY_CODE);
    }
	}
?>
