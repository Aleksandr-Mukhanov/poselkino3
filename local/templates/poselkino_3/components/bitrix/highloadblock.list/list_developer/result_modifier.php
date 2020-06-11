<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
// dump($arResult);
// Получим поселки девелопера
	$arOrder = Array("SORT"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>1);
	$arSelect = Array("ID","PROPERTY_SALES_PHASE","PROPERTY_RATING","PROPERTY_DEVELOPER_ID");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
	while($arElement = $rsElements->GetNext()){ // dump($arElement);
    $develCode = $arElement['PROPERTY_DEVELOPER_ID_VALUE'];

    $arResult['DEVEL'][$develCode]['CNT_POS']++;

    if ($arElement['PROPERTY_SALES_PHASE_ENUM_ID'] != 254) $arResult['DEVEL'][$develCode]['CNT_POS_SALE']++; // поселков в продаже

    $arResult['DEVEL'][$develCode]['RATING_POS'] += $arElement["PROPERTY_RATING_VALUE"];
	}

  // узнаем отзывы
	$arOrder = Array("SORT"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>2,"ACTIVE"=>"Y");
	$arSelect = Array("ID","PROPERTY_RATING","PROPERTY_DEVELOPER");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
	while($arElement = $rsElements->GetNext()){ // dump($arElement);
    $develCode = $arElement['PROPERTY_DEVELOPER_VALUE'];
    // кол-во отзывов
    $arResult['DEVEL'][$develCode]['CNT_COMMENTS']++;
		// оценка
		$rating = ($arElement["PROPERTY_RATING_VALUE"]) ? $arElement["PROPERTY_RATING_VALUE"] : 0;
    $arResult['DEVEL'][$develCode]['RATING_SUM'] += $rating;
	}
	// dump($arResult['DEVEL']);
?>
