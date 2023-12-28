<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
// dump($arResult['row']['UF_XML_ID']);
// Получим поселки девелопера
  $cntPos=0;$cntPosSale=0;$ratingPos=0;
	$arOrder = Array("SORT"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>1,"PROPERTY_DEVELOPER_ID"=>$arResult['row']['UF_XML_ID']);
	$arSelect = Array("ID","PROPERTY_SALES_PHASE","PROPERTY_RATING");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
	while($arElement = $rsElements->GetNext()){ // dump($arElement);
    $cntPos++;
    $arResult["CNT_POS"] = $cntPos;
    if ($arElement['PROPERTY_SALES_PHASE_ENUM_ID'] != 254) $cntPosSale++;
    $ratingPos += $arElement["PROPERTY_RATING_VALUE"];
    $arResult['idPos'][] = $arElement["ID"];
	}
  $arResult["POS_RATING"] = ($cntPos) ? $arResult["POS_RATING"] = round($ratingPos / $cntPos,1) : 'нет данных';
  $arResult["CNT_POS_SALE"] = ($cntPosSale) ? $cntPosSale : 'нет данных';

  // узнаем отзывы
	$cntCom = 0;$ratingSum = 0;
	$arOrder = Array("SORT"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>2,"ACTIVE"=>"Y","PROPERTY_DEVELOPER"=>$arResult['row']['UF_XML_ID']);
	$arSelect = Array("ID","ACTIVE_FROM","PREVIEW_TEXT","PROPERTY_RATING","PROPERTY_DIGNITIES","PROPERTY_DISADVANTAGES","PROPERTY_FIO","PROPERTY_RESIDENT");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,['nTopCount'=>4],$arSelect);
	while($arElement = $rsElements->GetNext()){ //dump($arElement);
		$cntCom++; // кол-во отзывов
		$arDateTime = explode(' ',$arElement["ACTIVE_FROM"]);
		$arDate = explode('.',$arDateTime[0]);
		$arTime = explode(':',$arDateTime[1]);
		// оценка
		$rating = ($arElement["PROPERTY_RATING_VALUE"]) ? $arElement["PROPERTY_RATING_VALUE"] : 4;
		$arComments[] = [
			"FIO" => $arElement["PROPERTY_FIO_VALUE"],
			"DATE" => $arDateTime[0].' '.$arTime[0].':'.$arTime[1],
			"DATE_SCHEMA" => $arDate[2].'-'.$arDate[1].'-'.$arDate[0],
			"RATING" => $rating,
			"DIGNITIES" => $arElement["PROPERTY_DIGNITIES_VALUE"],
			"DISADVANTAGES" => $arElement["PROPERTY_DISADVANTAGES_VALUE"],
			"TEXT" => $arElement["PREVIEW_TEXT"],
			"RESIDENT" => $arElement["PROPERTY_RESIDENT_VALUE"],
		];

		// соберем отзывы от жителя
		if($arElement["PROPERTY_RESIDENT_VALUE"]){
			$arCommentsRes[] = [
				"FIO" => $arElement["PROPERTY_FIO_VALUE"],
				"DATE" => $arDateTime[0].' '.$arTime[0].':'.$arTime[1],
				"RATING" => $rating,
				"DIGNITIES" => $arElement["PROPERTY_DIGNITIES_VALUE"],
				"DISADVANTAGES" => $arElement["PROPERTY_DISADVANTAGES_VALUE"],
				"TEXT" => $arElement["PREVIEW_TEXT"],
				"RESIDENT" => $arElement["PROPERTY_RESIDENT_VALUE"],
			];
		}

		// общая оценка
		$ratingSum = $ratingSum + $rating;
	} //dump($ratingSum);

	$ratingTotal = ($cntCom>0) ? $ratingSum / $cntCom : 'нет данных';

  $APPLICATION->AddChainItem($arResult['row']['UF_NAME'],'',true);

  $arResult["CNT_COMMENTS"] = $cntCom;
  $arResult["RATING_TOTAL"] = round((int)$ratingTotal,1);
  $arResult["COMMENTS"] = $arComments;
  $arResult["COMMENTS_RES"] = $arCommentsRes;
?>
