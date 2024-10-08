<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
	Loader::includeModule('highloadblock');
use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;

$arMetaInfo = getMetaInfo($arrFilter);

// формирование мета-тегов
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
    $arRes[$key] = str_replace(['#NAME#','#NAME_KOMU#','#NAME_KOM#','#MIN_PRICE#','#CNT_POS#'],[$arNames['NAME'],$arNames['NAME_KOMU'],$arNames['NAME_KOM'],$arMetaInfo['minPrice'],$arMetaInfo['cntPos']],$value);
  } // dump($arRes);

	if (DOMEN == 'kaluga') {
		$newTitle = str_replace(['Московской'],['Калужской'],$arRes['UF_TITLE']);
	  $newDesc = $arRes['UF_DESC'];
	  $h1 = str_replace(['Московской','Подмосковье'],['Калужской','Калужской области'],$arRes['UF_H1']);
	  $h2 = ($arRes['UF_H2']) ? '<h2>'.$arRes['UF_H2'].'</h2>' : '';
	  $SEO_text = $arRes['UF_TEXT'];
	} else {
		$newTitle = $arRes['UF_TITLE'];
	  $newDesc = $arRes['UF_DESC'];
	  $h1 = $arRes['UF_H1'];
	  $h2 = ($arRes['UF_H2']) ? '<h2>'.$arRes['UF_H2'].'</h2>' : '';
	  $SEO_text = $arRes['UF_TEXT'];
	}

}else{ // выведем шаблонные

  if(is_numeric($mkadKM)){
    $newTitle = 'Коттеджный поселок '.$mkadKM.' км от '.ROAD.' – купить коттедж до '.$mkadKM.' км от '.ROAD;
    $newDesc = '▶Коттеджные поселки в '.$mkadKM.' км от '.ROAD.' ▶ Полная база коттеджных поселков и коттеджей на расстоянии до '.$mkadKM.' км от '.REGION_CITY.' ★★★ Независимый рейтинг  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
    $h1 = 'Коттеджные поселки '.$mkadKM.' км от '.ROAD.' и коттеджи';
    $h2 = "";
    $SEO_text = "";
    $urlAll = "/poselki/do-".$mkadKM."-km-ot-".ROAD_URL."/";
    $urlNoDom = "/poselki/kupit-uchastok-do-".$mkadKM."-km-ot-".ROAD_URL."/";
    $urlWithDom = "/poselki/kupit-dom-dachu-kottedzh-do-".$mkadKM."-km-ot-".ROAD_URL."/";
    if ($pagen) $pageTitleDesc = 'Поселки до '.$mkadKM.' км от '.ROAD;
  }
  if(is_numeric($plottage)){
    $newTitle = 'Купить дом '.$plottage.' кв м – коттеджи и дома '.num2str($plottage).' кв метров в '.REGION_SHORT_WHERE.', цены';
    $newDesc = '▶ Дома, коттеджи 🏠 '.$plottage.' квадратных метров в поселках '.REGION_SHORT_WHAT.' ➤Цены от '.$arMetaInfo['minPrice'].' руб. ➤Кол-во объявлений - '.$arMetaInfo['cntPos'].' ✔Стоимость коммуникаций ✔Актуальные фото ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Независимый рейтинг ✔Честный обзор';
    $h1 = 'Коттеджи и дома '.$plottage.' кв. м';
    $h2 = '';
    $SEO_text = '';
    if ($pagen) $pageTitleDesc = 'Дом площадью '.$plottage.' кв м';
  }
}

if($shosse){ // если странички шоссе
  // $newTitle = 'Коттеджный поселок '.$arNames['NAME'].' шоссе - с домами и ценами';
  // $newDesc = '▶'.$arNames['NAME'].' шоссе ▶ Полная база коттеджных поселков по '.$arNames['NAME_KOMU'].' направлению ★★★ Независимый рейтинг!  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  // $h1 = 'Коттеджные поселки '.$arNames['NAME'].' шоссе';
	$newTitle = 'Коттеджные поселки по '.$arNames['NAME_KOMU'].' шоссе (направлению)';
  $newDesc = '▶'.$arNames['NAME'].' шоссе ▶ Полная база коттеджных и дачных поселков по '.$arNames['NAME_KOMU'].' направлению ★★★ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $h1 = 'Коттеджные поселки по '.$arNames['NAME_KOMU'].' шоссе - ';
  // $h2 = '<h2 class="h1">Поселки по '.$arNames['NAME_KOMU'].' шоссе в '.REGION_KOY.' области</h2>';
}
if($rayon){ // если странички района
  // $newTitle = 'Коттеджный поселок '.$arNames['NAME'].' район – купить коттедж в '.$arNames['NAME_KOM'].' районе';
  // $newDesc = '▶'.$arNames['NAME'].' район ▶ Полная база коттеджных поселков и коттеджей в '.$arNames['NAME_KOM'].' районе ★★★ Независимый рейтинг  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  // $h1 = 'Коттеджные поселки в '.$arNames['NAME_KOM'].' районе и коттеджи';
	$newTitle = 'Коттеджные поселки в '.$arNames['NAME_KOM'].' районе';
  $newDesc = '▶'.$arNames['NAME'].' район ▶ Полная база коттеджных и дачных поселков в '.$arNames['NAME_KOM'].' районе ★★★ Независимый рейтинг ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $h1 = 'Коттеджные поселки в '.$arNames['NAME_KOM'].' районе - ';
  // $h2 = '<h2 class="h1">Поселки в '.$arNames['NAME_KOMU'].' районе '.REGION_KOY.' области</h2>';
}

if($shosse && $domPos){ // если выбор шоссе и участок/дом
  switch ($domPos) {
    case 'noDom': // Участки
      $newTitle = 'Купить участок по '.$arNames['NAME_KOMU'].' шоссе недорого';
      $newDesc = '▶Участки по '.$arNames['NAME_KOMU'].' шоссе ▶ Полная база земельных участков на '.$arNames['NAME_KOM'].' направлении ★★★ Независимый рейтинг!  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
      $h1 = 'Участки по '.$arNames['NAME_KOMU'].' шоссе';
      $h2 = "";
      $SEO_text = "";
      if ($pagen) $pageTitleDesc = $arNames['NAME'].' шоссе участки';
      break;
    case 'withDom': // Дома
      $newTitle = 'Купить дом по '.$arNames['NAME_KOMU'].' шоссе. Купить коттедж по '.$arNames['NAME_KOMU'].' шоссе под ключ';
      $newDesc = '▶Дома и коттеджи по '.$arNames['NAME_KOMU'].' шоссе ▶ Полная база домов на '.$arNames['NAME_KOM'].' направлении ★★★ Независимый рейтинг!  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
      $h1 = 'Дома и коттеджи на '.$arNames['NAME_KOM'].' шоссе';
      $h2 = "";
      $SEO_text = "";
      if ($pagen) $pageTitleDesc = $arNames['NAME'].' шоссе дома';
      break;
  }
}

if($rayon && $domPos){ // если выбор район и участок/дом
  switch ($domPos) {
    case 'noDom': // Участки
      $newTitle = 'Купить участок в '.$arNames['NAME_KOM'].' районе - недорого без посредников';
      $newDesc = '▶Участки в '.$arNames['NAME_KOM'].' районе ▶ Полная база земельных участков в '.$arNames['NAME_KOM'].' районе '.REGION_KOY.' области ★★★ Независимый рейтинг  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
      $h1 = 'Земельный участок в '.$arNames['NAME_KOM'].' районе';
      $h2 = "";
      $SEO_text = "";
      if ($pagen) $pageTitleDesc = $arNames['NAME'].' район участки';
      break;
    case 'withDom': // Дома
      $newTitle = 'Купить дом в '.$arNames['NAME_KOM'].' районе – недорого';
      $newDesc = '▶'.$arNames['NAME'].' район - дома ▶ Полная база домов в '.$arNames['NAME_KOM'].' районе ★★★ Независимый рейтинг  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
      $h1 = 'Дома в '.$arNames['NAME_KOM'].' районе';
      $h2 = "";
      $SEO_text = "";
      if ($pagen) $pageTitleDesc = $arNames['NAME'].' район участки';
      break;
  }
}

if(is_numeric($mkadKM) && $domPos){ // если выбор км до МКАД и участок/дом
  switch ($domPos) {
    case 'noDom': // Участки
      $newTitle = 'Земельный участок '.$mkadKM.' км от '.ROAD.' – купить участок до '.$mkadKM.' км от '.ROAD;
      $newDesc = '▶Купить землю в '.$mkadKM.' км от '.ROAD.' ▶ Полная база земельных участков на расстоянии до '.$mkadKM.' км от '.REGION_CITY.' ★★★ Независимый рейтинг  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
      $h1 = 'Участки '.$mkadKM.' км от '.ROAD;
      $h2 = "";
      $SEO_text = "";
      if ($pagen) $pageTitleDesc = 'Купить участок до '.$mkadKM.' км от '.ROAD;
      break;
    case 'withDom': // Дома
      $newTitle = 'Купить дом в '.$mkadKM.' км от '.ROAD.' недорого';
      $newDesc = '▶Купить дома в '.$mkadKM.' км от '.ROAD.' ▶ Полная база домов на расстоянии до '.$mkadKM.' км от '.REGION_CITY.' ★★★ Независимый рейтинг  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
      $h1 = 'Дома '.$mkadKM.' км от '.REGION_CITY;
      $h2 = "";
      $SEO_text = "";
      if ($pagen) $pageTitleDesc = 'Купить дом дачу коттедж до '.$mkadKM.' км от '.ROAD;
      break;
  }
  $urlAll = "/poselki/do-".$mkadKM."-km-ot-".ROAD_URL."/";
  $urlNoDom = "/poselki/kupit-uchastok-do-".$mkadKM."-km-ot-".ROAD_URL."/";
  $urlWithDom = "/poselki/kupit-dom-dachu-kottedzh-do-".$mkadKM."-km-ot-".ROAD_URL."/";
}

if($priceURL && $domPos){ // выбор стоимость и участок/дом
  $lowCost = ($priceType == 'tys') ? 'Недорогие земельные' : 'Земельные';
  switch ($domPos) {
    case 'noDom': // Участки
      $newTitle = 'Купить участок за '.$priceURL.' '.$nameBCFull.' рублей – участки за '.num2str($priceURL).' '.$nameBCFullMln.' в '.REGION_SHORT_WHERE;
      $newDesc = '▶ Недорогие земельные участки ▶ за '.$priceURL.' '.$nameBCFull.' рублей в поселках '.REGION_SHORT_WHAT.' ➤Кол-во объявлений - '.$arMetaInfo['cntPos'].' ✔Стоимость коммуникаций ✔Актуальные фото ✔Видео с квадрокоптера ✔Подробное описание ✔Отзывы покупателей ✔Честный рейтинг ✔Независимый обзор';
      $h1 = 'Участки за '.$priceURL.' '.$nameBCFull.' рублей';
      $h2 = "";
      $SEO_text = "";
      $urlNoDom = "/poselki/kupit-uchastok-do-".$priceURL."-".$priceType."-rub/";
      $urlWithDom = "";
      if ($pagen) $pageTitleDesc = 'Купить участок до '.$priceURL.' '.$nameBCFull.' рублей';
      break;
    case 'withDom': // Дома
      $priceURL2 = ($priceURL == '1,5') ? 'полтора миллиона' : num2str($priceURL).' '.$nameBCFullMln;
      $newTitle = 'Купить дом за '.$priceURL.' '.$nameBCFull.' рублей – коттедж с участком, дом за '.$priceURL2.' в '.REGION_SHORT_WHERE;
      $newDesc = '▶ Дома, коттеджи 🏠 за '.$priceURL.' '.$nameBCFull.' рублей в поселках '.REGION_SHORT_WHAT.' ➤Кол-во объявлений - '.$arMetaInfo['cntPos'].' ✔Стоимость коммуникаций ✔Актуальные фото ✔Видео с квадрокоптера ✔Подробное описание ✔Отзывы покупателей ✔Честный рейтинг ✔Независимый обзор';
      $h1 = 'Коттеджи и дома за '.$priceURL.' '.$nameBCFull.' рублей';
      $h2 = "";
      $SEO_text = "";
      $urlNoDom = "";
      $urlWithDom = "/poselki/kupit-dom-do-".$priceURL."-mln-rub/";
      if ($pagen) $pageTitleDesc = 'Дома до '.$priceURL.' '.$nameBCFullMln.' рублей';
      break;
  }
}

if(is_numeric($areaUrl) && $domPos){ // если площадь и участок/дом
  switch ($domPos) {
    case 'noDom': // Участки
      $areaUrl2 = ($areaUrl == 2) ? 'две' : num2str($areaUrl);
      $newTitle = 'Участок '.$areaUrl.' '.$nameArea.' – купить '.$areaUrl2.' '.$nameArea.' земли в '.REGION_SHORT_WHERE.', цены';
      $newDesc = '▶ Земельные участки '.$areaUrl.' '.$nameArea.' ▶ в поселках '.REGION_SHORT_WHAT.' ➤Дачные, садовые, СНТ, ИЖС ➤Цены от '.$arMetaInfo['minPrice'].' руб. ➤Кол-во объявлений - '.$arMetaInfo['cntPos'].' ✔Стоимость коммуникаций ✔Актуальные фото ✔Видео с квадрокоптера ✔Подробное описание ✔Отзывы покупателей ✔Честный рейтинг ✔Независимый обзор';
      $h1 = 'Участки '.$areaUrl.' '.$nameArea;
      $h2 = "";
      $SEO_text = "";
      if ($pagen) $pageTitleDesc = 'Участок '.$areaUrl.' '.$nameArea;
      break;
    case 'withDom': // Дома
      $nameArea2 = ($areaUrl == 2 || $areaUrl==3 || $areaUrl==4) ? 'сотки' : 'соток';
      $areaUrl2 = ($areaUrl == 2) ? 'две' : num2str($areaUrl);
      $newTitle = 'Купить дом на '.$areaUrl.' '.$nameArea.' – коттедж с участком '.$areaUrl2.' '.$nameArea2.' в '.REGION_SHORT_WHERE;
      $newDesc = '▶ Дома, коттеджи 🏠 на участке '.$areaUrl.' '.$nameArea2.' в поселках '.REGION_SHORT_WHAT.' ➤ Цены от '.$arMetaInfo['minPrice'].' руб. ➤Кол-во объявлений - '.$arMetaInfo['cntPos'].' ✔Стоимость коммуникаций ✔Актуальные фото ✔Видео с квадрокоптера ✔Подробное описание ✔Отзывы покупателей ✔Честный рейтинг ✔Независимый обзор';
      $h1 = 'Коттеджи и дома на '.$areaUrl.' сотках';
      $h2 = "";
      $SEO_text = "";
      if ($pagen) $pageTitleDesc = 'Дом с участком '.$areaUrl.' '.$nameArea2;
      break;
  }
  $areaTypeDom = ($areaUrl == 2 || $areaUrl==3 || $areaUrl==4) ? 'sotki' : 'sotok';
  $urlNoDom = "/poselki/kupit-uchastok-".$areaUrl."-".$areaTypeDom."/";
  $urlWithDom = "/poselki/kupit-dom-na-".$areaUrl."-sotkah/";
}

if($classCode){ // если выборка по классу

  // $newTitle = 'Готовые коттеджные и дачные поселки '.$nameClass.'-класса от застройщика в '.REGION_SHORT_WHERE.' - Поселкино';
	$nameClassTitle = ($classCode == 'elit') ? 'элит' : $nameClass;
	$newTitle = 'Коттеджные поселки '.$nameClassTitle.' класса в '.REGION_SHORT_WHERE.' - поселок '.$nameClassTitle.' класса с готовыми домами в '.REGION_KOY.' области';
  $newDesc = 'Готовые коттеджные и дачные поселки '.$nameClass.'-класса от застройщика в '.REGION_KOY.' области ➤Цены от '.$arMetaInfo['minPrice'].' руб. ➤Кол-во объявлений - '.$arMetaInfo['cntPos'].' ✔Стоимость коммуникаций ✔Актуальные фото ✔Видео с квадрокоптера ✔Подробное описание ✔Отзывы покупателей ✔Честный рейтинг ✔Независимый обзор';
  $h1 = 'Коттеджные и дачные поселки '.$nameClass.'-класса в '.REGION_SHORT_WHERE;
  $h2 = "";
  $SEO_text = "";
  if ($pagen) $pageTitleDesc = 'Поселки '.$nameClass.' класса';
  if($domPos){ // если выборка ещё и по домам
    switch ($domPos) {
      case 'noDom': // Участки
        // $newTitle = 'Купить участок, землю '.$nameClass.'-класса в '.REGION_SHORT_WHERE.' - Поселкино';
				if($classCode == 'econom' || $classCode == 'premium')
					$newTitle = 'Участок '.$nameClassTitle.' класса в '.REGION_SHORT_WHERE.' - купить '.$nameClassTitle.' участок в '.REGION_KOY.' области';
				elseif($classCode == 'elit')
					$newTitle = 'Участок элит класса в '.REGION_SHORT_WHERE.' - купить элитный участок в '.REGION_KOY.' области';
				else
					$newTitle = 'Участок '.$nameClassTitle.' класса в '.REGION_SHORT_WHERE.' - купить участок '.$nameClassTitle.' класса в '.REGION_KOY.' области';
        $newDesc = 'Земельные участки '.$nameClass.'-класса в поселках '.REGION_KOY.' области ➤Цены от '.$arMetaInfo['minPrice'].' руб. ➤'.$arMetaInfo['cntPos'].' объявлений ✔Стоимость коммуникаций ✔Актуальные фото ✔Видео с квадрокоптера ✔Подробное описание ✔Отзывы покупателей ✔Честный рейтинг ✔Независимый обзор';
        $h1 = 'Продажа земельных участков '.$nameClass.'-класса в '.REGION_SHORT_WHERE;
        $h2 = "";
        $SEO_text = "";
        if ($pagen) $pageTitleDesc = 'Участки '.$nameClass.' класса';
        break;
      case 'withDom': // Дома
        // $newTitle = 'Купить дом, коттедж, дачу '.$nameClass.'-класса в '.REGION_SHORT_WHERE.' - Поселкино';
				if($classCode == 'econom' || $classCode == 'premium')
					$newTitle = 'Дом '.$nameClassTitle.' класса в '.REGION_SHORT_WHERE.' - купить '.$nameClassTitle.' дом в '.REGION_KOY.' области';
				elseif($classCode == 'elit')
					$newTitle = 'Дом элит класса в '.REGION_SHORT_WHERE.' - купить элитный дом в '.REGION_KOY.' области';
				else
					$newTitle = 'Дом '.$nameClassTitle.' класса в '.REGION_SHORT_WHERE.' - купить дом '.$nameClassTitle.' класса в '.REGION_KOY.' области';
        $newDesc = 'Дома, коттеджи, дачи '.$nameClass.'-класса в поселках '.REGION_KOY.' области ➤Цены от '.$arMetaInfo['minPrice'].' руб. ➤Кол-во объявлений - '.$arMetaInfo['cntPos'].' ✔Стоимость коммуникаций ✔Актуальные фото ✔Видео с квадрокоптера ✔Подробное описание ✔Отзывы покупателей ✔Честный рейтинг ✔Независимый обзор';
        $h1 = 'Продажа домов и коттеджей '.$nameClass.'-класса в '.REGION_SHORT_WHERE;
        $h2 = "";
        $SEO_text = "";
        if ($pagen) $pageTitleDesc = 'Дома '.$nameClass.' класса';
        break;
    }
  }
  $urlAll = "/poselki/".$classCode."-class/";
  $urlNoDom = "/poselki/kupit-uchastok-".$classCode."-class/";
  $urlWithDom = "/poselki/kupit-dom-".$classCode."-class/";
}

if($commun){ // коммуникации
  switch ($commun) {
    case 'elektrichestvom':
      $newTitle = 'Коттеджные поселки с электричеством (светом) в '.REGION_SHORT_WHERE.'. Купить коттедж с электричеством';
      $newDesc = '▶ Коттеджные поселки с электричеством в '.REGION_SHORT_WHERE.' ▶ Полная база коттеджей со светом в '.REGION_KOY.' области ★★★ Независимый рейтинг  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота!';
      $h1 = 'Поселки с электричеством';
      if ($pagen) $pageTitleDesc = 'Поселки с электричеством';
      if($domPos){ // если выборка ещё и по домам
        switch ($domPos) {
          case 'noDom': // Участки
            $newTitle = 'Купить участок с электричеством (светом) в '.REGION_SHORT_WHERE.' недорого';
            $newDesc = '▶ Недорого купить участок с электричеством в '.REGION_SHORT_WHERE.' ▶ Полная база участков со светом в '.REGION_KOY.' области ★★★ Независимый рейтинг  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота!';
            $h1 = 'Участки с электричеством (светом)';
            if ($pagen) $pageTitleDesc = 'Купить участок с электричеством';
            break;
          case 'withDom': // Дома
            $newTitle = 'Купить дом с электричеством (светом) в '.REGION_SHORT_WHERE.' недорого';
            $newDesc = '▶ Недорого купить дом с электричеством в '.REGION_SHORT_WHERE.' ▶ Полная база домов со светом в '.REGION_KOY.' области ★★★ Независимый рейтинг  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота!';
            $h1 = 'Дома с электричеством (светом)';
            if ($pagen) $pageTitleDesc = 'Купить дом с электричеством';
            break;
        }
      }
      break;
    case 'vodoprovodom':
      $newTitle = 'Коттеджные поселки с водой (водопроводом) в '.REGION_SHORT_WHERE.'. Купить коттедж с водопроводом';
      $newDesc = '▶ Коттеджные поселки с водопроводом в '.REGION_SHORT_WHERE.' ▶ Полная база коттеджей с водой в '.REGION_KOY.' области ★★★ Независимый рейтинг  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота!';
      $h1 = 'Поселки с водопроводом';
      if ($pagen) $pageTitleDesc = 'Поселки с водопроводом';
      if($domPos){ // если выборка ещё и по домам
        switch ($domPos) {
          case 'noDom': // Участки
            $newTitle = 'Купить участок с водой (водопроводом) в '.REGION_SHORT_WHERE.' недорого';
            $newDesc = '▶ Недорого купить участок с водой в '.REGION_SHORT_WHERE.' ▶ Полная база участков с водопроводом в '.REGION_KOY.' области ★★★ Независимый рейтинг  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота!';
            $h1 = 'Участки с водой (водопроводом)';
            if ($pagen) $pageTitleDesc = 'Купить участок с водопроводом';
            break;
          case 'withDom': // Дома
            $newTitle = 'Купить дом с водой (водопроводом) в '.REGION_SHORT_WHERE.' недорого';
            $newDesc = '▶ Недорого купить дом с водой в '.REGION_SHORT_WHERE.' ▶ Полная база домов с водопроводом в '.REGION_KOY.' области ★★★ Независимый рейтинг  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота!';
            $h1 = 'Дома с водой (водопроводом)';
            if ($pagen) $pageTitleDesc = 'Купить дом с водопроводом';
            break;
        }
      }
      break;
    case 'gazom':
      $newTitle = 'Коттеджные поселки с газом в '.REGION_SHORT_WHERE.'. Купить коттедж с газом';
      $newDesc = '▶ Коттеджные поселки с газом в '.REGION_SHORT_WHERE.' ▶ Полная база коттеджей с газом в '.REGION_KOY.' области ★★★ Независимый рейтинг  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота!';
      $h1 = 'Поселки с газом';
      if($domPos){ // если выборка ещё и по домам
        switch ($domPos) {
          case 'noDom': // Участки
            $newTitle = 'Купить участок с газом в '.REGION_SHORT_WHERE.' недорого';
            $newDesc = '▶ Недорого купить участок с газом в '.REGION_SHORT_WHERE.' ▶ Полная база участков с газопроводом в '.REGION_KOY.' области ★★★ Независимый рейтинг  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота!';
            $h1 = 'Купить участок с газом';
            break;
          case 'withDom': // Дома
            $newTitle = 'Купить дом с газом в '.REGION_SHORT_WHERE.' недорого';
            $newDesc = '▶ Недорого купить дом с газом в '.REGION_SHORT_WHERE.' ▶ Полная база домов с газопроводом в '.REGION_KOY.' области ★★★ Независимый рейтинг  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота!';
            $h1 = 'Купить дом с газом';
            break;
        }
      }
      if ($pagen) $pageTitleDesc = $h1;
      break;
    case 'kommunikaciyami':
      $newTitle = 'Коттеджные поселки с коммуникациями в '.REGION_SHORT_WHERE.'. Купить коттедж с коммуникациями';
      $newDesc = '▶ Коттеджные поселки с коммуникациями в '.REGION_SHORT_WHERE.' ▶ Полная база коттеджей с коммуникациями в '.REGION_KOY.' области ★★★ Независимый рейтинг  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота!';
      $h1 = 'Поселки с коммуникациями';
      if($domPos){ // если выборка ещё и по домам
        switch ($domPos) {
          case 'noDom': // Участки
            $newTitle = 'Купить участок с коммуникациями в '.REGION_SHORT_WHERE.' недорого';
            $newDesc = '▶ Недорого купить участок с коммуникациями в '.REGION_SHORT_WHERE.' ▶ Полная база участков с коммуникациями в '.REGION_KOY.' области ★★★ Независимый рейтинг  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота!';
            $h1 = 'Купить участок с коммуникациями';
            break;
          case 'withDom': // Дома
            $newTitle = 'Купить дом с коммуникациями в '.REGION_SHORT_WHERE.' недорого';
            $newDesc = '▶ Недорого купить дом с коммуникациями в '.REGION_SHORT_WHERE.' ▶ Полная база домов с коммуникациями в '.REGION_KOY.' области ★★★ Независимый рейтинг  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота!';
            $h1 = 'Купить дом с коммуникациями';
            break;
        }
      }
      if ($pagen) $pageTitleDesc = $h1;
      break;
  }
  $h2 = "";
  $SEO_text = "";
  $urlAll = "/poselki/s-".$commun."/";
  $urlNoDom = "/poselki/kupit-uchastok-s-".$commun."/";
  $urlWithDom = "/poselki/kupit-dom-s-".$commun."/";
}
?>
