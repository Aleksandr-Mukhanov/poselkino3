<?php header('Content-Type: text/html; charset=utf-8');
// Отключаем статистику Bitrix
define("NO_KEEP_STATISTIC", true);
$_SERVER["DOCUMENT_ROOT"] = '/var/www/u0428181/data/www/olne.ru';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
// устанавливаем тип ответа как xml документ
// header('Content-Type: application/xml; charset=utf-8');

use Bitrix\Main\Loader;
	Loader::includeModule('iblock');
	Loader::includeModule('highloadblock');
use Bitrix\Seo\SitemapTable;
use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;

// получим шоссе SHOSSE
	$codeProp = 'SHOSSE';
	$propEnums = CIBlockPropertyEnum::GetList(
		["SORT"=>"ASC","VALUE"=>"ASC"],
		["IBLOCK_ID"=>1,"CODE"=>$codeProp]
	);
	while($enumFields = $propEnums->GetNext()){ // dump($enumFields);
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/'.$enumFields['XML_ID'].'-shosse/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/'.$enumFields['XML_ID'].'-shosse/kupit-uchastok/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/'.$enumFields['XML_ID'].'-shosse/kupit-dom/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
		$arShosse[$enumFields['XML_ID']] = $enumFields['VALUE'];
	}

// получим районы REGION
	$codeProp = 'REGION';
	$propEnums = CIBlockPropertyEnum::GetList(
		["SORT"=>"ASC","VALUE"=>"ASC"],
		["IBLOCK_ID"=>1,"CODE"=>$codeProp]
	);
	while($enumFields = $propEnums->GetNext()){ // dump($enumFields);
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/'.$enumFields['XML_ID'].'-rayon/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/'.$enumFields['XML_ID'].'-rayon/kupit-uchastok/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/'.$enumFields['XML_ID'].'-rayon/kupit-dom/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
		$arRegion[$enumFields['XML_ID']] = $enumFields['VALUE'];
	}

// км от МКАД
	$i = 0;
	for($x=10; $x<=80; $x+=5){ $i++;
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/do-'.$x.'-km-ot-mkad/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-uchastok-do-'.$x.'-km-ot-mkad/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-dom-dachu-kottedzh-do-'.$x.'-km-ot-mkad/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
	}
	$xml_content .= '<url><loc>https://poselkino.ru/poselki/do-100-km-ot-mkad/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
	$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-uchastok-do-100-km-ot-mkad/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
	$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-dom-dachu-kottedzh-do-100-km-ot-mkad/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
	$xml_content .= '<url><loc>https://poselkino.ru/poselki/do-120-km-ot-mkad/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
	$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-uchastok-do-120-km-ot-mkad/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
	$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-dom-dachu-kottedzh-do-120-km-ot-mkad/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';

// Цена
	$urlPrice = [
		'/poselki/kupit-uchastok-do-100-tys-rub/',
		'/poselki/kupit-uchastok-do-150-tys-rub/',
		'/poselki/kupit-uchastok-do-200-tys-rub/',
		'/poselki/kupit-uchastok-do-300-tys-rub/',
		'/poselki/kupit-uchastok-do-400-tys-rub/',
		'/poselki/kupit-uchastok-do-500-tys-rub/',
		'/poselki/kupit-uchastok-do-600-tys-rub/',
		'/poselki/kupit-uchastok-do-700-tys-rub/',
		'/poselki/kupit-uchastok-do-1-mln-rub/',
		'/poselki/kupit-uchastok-do-1,5-mln-rub/',
		'/poselki/kupit-uchastok-do-2-mln-rub/',
		'/poselki/kupit-uchastok-do-3-mln-rub/',
		'/poselki/kupit-uchastok-do-4-mln-rub/',
		'/poselki/kupit-uchastok-do-5-mln-rub/',
		'/poselki/kupit-dom-do-1-mln-rub/',
		'/poselki/kupit-dom-do-1,5-mln-rub/',
		'/poselki/kupit-dom-do-2-mln-rub/',
		'/poselki/kupit-dom-do-3-mln-rub/',
		'/poselki/kupit-dom-do-4-mln-rub/',
		'/poselki/kupit-dom-do-5-mln-rub/',
		'/poselki/kupit-dom-do-6-mln-rub/',
		'/poselki/kupit-dom-do-7-mln-rub/',
		'/poselki/kupit-dom-do-8-mln-rub/',
		'/poselki/kupit-dom-do-9-mln-rub/',
		'/poselki/kupit-dom-do-10-mln-rub/',
		'/poselki/kupit-dom-do-15-mln-rub/',
		'/poselki/kupit-dom-do-20-mln-rub/',
		'/poselki/kupit-dom-do-30-mln-rub/',
	];

	foreach ($urlPrice as $key => $value) {
		$xml_content .= '<url><loc>https://poselkino.ru'.$value.'</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
	} // echo $xml_content;

// Площадь
	for ($i=2; $i <= 20; $i++) { // участки
		if($i == 2 || $i == 3 || $i == 4){
			$nameSot = 'сотки'; $urlSot = 'sotki';
		}else{
			$nameSot = 'соток'; $urlSot = 'sotok';
		}
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-uchastok-'.$i.'-'.$urlSot.'/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
	}
	$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-uchastok-25-sotok/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
	for ($i=30; $i <= 100; $i+=10) {
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-uchastok-'.$i.'-sotok/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
	}
	for ($i=2; $i <= 20; $i++) { // дома
    if($i == 2 || $i == 3 || $i == 4){
      $nameSot = 'сотки'; $urlSot = 'sotki';
    }else{
      $nameSot = 'соток'; $urlSot = 'sotok';
    }
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-dom-na-'.$i.'-sotkah/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
	}
	$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-dom-na-25-sotkah/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
	for ($i=30; $i <= 100; $i+=10) {
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-dom-na-'.$i.'-sotkah/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
	}

// остальные url
	$urlOther = [
		'/poselki/kupit-dom-100-kv-m/',
		'/poselki/kupit-dom-120-kv-m/',
		'/poselki/kupit-dom-150-kv-m/',
		'/poselki/kupit-dom-200-kv-m/',
		'/poselki/kupit-dom-250-kv-m/',
		'/poselki/kupit-dom-300-kv-m/',
		'/poselki/kupit-dom-400-kv-m/',
		'/poselki/kupit-dom-500-kv-m/',
		'/poselki/econom-class/',
		'/poselki/biznes-class/',
		'/poselki/komfort-class/',
		'/poselki/elit-class/',
		'/poselki/premium-class/',
		'/poselki/kupit-uchastok-econom-class/',
		'/poselki/kupit-uchastok-biznes-class/',
		'/poselki/kupit-uchastok-komfort-class/',
		'/poselki/kupit-uchastok-elit-class/',
		'/poselki/kupit-uchastok-premium-class/',
		'/poselki/kupit-dom-econom-class/',
		'/poselki/kupit-dom-biznes-class/',
		'/poselki/kupit-dom-komfort-class/',
		'/poselki/kupit-dom-elit-class/',
		'/poselki/kupit-dom-premium-class/',
		'/poselki/s-elektrichestvom/',
		'/poselki/s-vodoprovodom/',
		'/poselki/s-gazom/',
		'/poselki/s-kommunikaciyami/',
		'/poselki/kupit-uchastok-s-elektrichestvom/',
		'/poselki/kupit-uchastok-s-vodoprovodom/',
		'/poselki/kupit-uchastok-s-gazom/',
		'/poselki/kupit-uchastok-s-kommunikaciyami/',
		'/poselki/kupit-dom-s-elektrichestvom/',
		'/poselki/kupit-dom-s-vodoprovodom/',
		'/poselki/kupit-dom-s-gazom/',
		'/poselki/kupit-dom-s-kommunikaciyami/',
		'/poselki/snt/',
		'/poselki/izhs/',
		'/poselki/ryadom-zhd-stanciya/',
		'/poselki/ryadom-avtobusnaya-ostanovka/',
		'/poselki/kupit-uchastok-snt/',
		'/poselki/kupit-uchastok-izhs/',
		'/poselki/kupit-uchastok-ryadom-zhd-stanciya/',
		'/poselki/kupit-dom-snt/',
		'/poselki/kupit-dom-izhs/',
		'/poselki/kupit-dom-ryadom-zhd-stanciya/',
		'/poselki/ryadom-s-lesom/',
		'/poselki/u-vody/',
		'/poselki/u-ozera/',
		'/poselki/u-reki/',
		'/poselki/kupit-uchastok-ryadom-s-lesom/',
		'/poselki/kupit-uchastok-u-vody/',
		'/poselki/kupit-uchastok-u-ozera/',
		'/poselki/kupit-uchastok-u-reki/',
		'/poselki/kupit-dom-ryadom-s-lesom/',
		'/poselki/kupit-dom-u-vody/',
		'/poselki/kupit-dom-u-ozera/',
		'/poselki/kupit-dom-u-reki/',
		'/poselki/kottedzhnye/',
		'/poselki/kupit-kottedzhnyj-uchastok/',
		'/poselki/kupit-kottedzh/',
		'/poselki/dachnye/',
		'/poselki/kupit-dachnyj-uchastok/',
		'/poselki/kupit-dachnyj-dom/',
		'/poselki/kupit-letnij-dom/',
		'/poselki/kupit-zimnij-dom/',
		'/poselki/s-infrastrukturoj/',
		'/poselki/kupit-uchastok-s-infrastrukturoj/',
		'/poselki/kupit-dom-s-infrastrukturoj/',
		'/poselki/s-ohranoj/',
		'/poselki/kupit-uchastok-s-ohranoj/',
		'/poselki/kupit-dom-s-ohranoj/',
		'/poselki/s-dorogami/',
		'/poselki/kupit-uchastok-s-dorogami/',
		'/poselki/kupit-dom-s-dorogami/',
		'/poselki/kupit-uchastok/',
		'/poselki/kupit-dom/',
	];
	foreach ($urlOther as $key => $value) {
		$xml_content .= '<url><loc>https://poselkino.ru'.$value.'</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
	} // echo $xml_content;

// запись в файл sitemap-seo-pages.xml
	$fp = fopen('../sitemap/sitemap-seo-pages.xml', 'w+');
	$xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$xml_content.'</urlset>';
	fwrite($fp,$xml);
	fclose($fp);
	unset($xml_content);

// получим статические страницы
  $ID = 1;
  $dbSitemap = SitemapTable::getById($ID);
  $arSitemap = $dbSitemap->fetch();
  $arSitemap['SETTINGS'] = unserialize($arSitemap['SETTINGS']);
  // dump($arSitemap['SETTINGS']);

  // получим список директорий
  $list = \CSeoUtils::getDirStructure(
    $arSitemap['SETTINGS']['logical'] == 'Y',
    $arSitemap['SITE_ID'],
    $arCurrentDir['ITEM_PATH']
  );
  // dump($list);

  foreach($list as $dir)
  {
		if ($dir['DATA']['TYPE'] == 'F') continue; // пропустим статические файлы

    $dirKey = "/".ltrim($dir['DATA']['ABS_PATH'], "/");

		if(!isset($arSitemap['SETTINGS']['DIR'][$dirKey])
			|| $arSitemap['SETTINGS']['DIR'][$dirKey] == 'Y')
		{
			$arDirList[] = [
				'URL' => $dirKey.'/',
				'DATE' => date('c',$dir['DATA']['TIMESTAMP'])
			];
		}
  }
  // dump($arDirList);

	foreach ($arDirList as $key => $value) {
		$xml_content .= '<url><loc>https://poselkino.ru'.$value['URL'].'</loc><lastmod>'.$value['DATE'].'</lastmod><priority>0.5</priority></url>';
	}

// получим девелоперов
	$hlblock_id = 5; // id HL
	$hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();
	$entity = HL\HighloadBlockTable::compileEntity($hlblock);
	$entity_data_class = $entity->getDataClass();
	$entity_table_name = $hlblock['TABLE_NAME'];
	$sTableID = 'tbl_'.$entity_table_name;

	$rsData = $entity_data_class::getList([
	  'filter' => ['*'],
	  'select' => ['UF_XML_ID'],
	]);
	$rsData = new CDBResult($rsData, $sTableID);

	while($arRes = $rsData->Fetch()){ // dump($arRes);
		$xml_content .= '<url><loc>https://poselkino.ru/developery/'.$arRes['UF_XML_ID'].'/</loc><lastmod>'.date('c').'</lastmod><priority>0.5</priority></url>';
	} // dump($arDeveloper);

// запись в файл sitemap-static-pages.xml
	$fp = fopen('../sitemap/sitemap-static-pages.xml', 'w+');
	$xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$xml_content.'</urlset>';
	fwrite($fp,$xml);
	fclose($fp);
	unset($xml_content);

// получим инфоблоки
	foreach ($arSitemap['SETTINGS']['IBLOCK_ACTIVE'] as $key => $value) {
		if ($value == 'Y') $arIblocksId[] =  $key;
	} // dump($arIblocksId);

	foreach($arIblocksId as $iblock_id)
	{
		// Список разделов
 		$res = CIBlockSection::GetList(
    	array(),
    	Array(
       	"IBLOCK_ID" => $iblock_id,
       	"ACTIVE" => "Y" ,
    	),
  		false,
  		array(
    		"ID",
    		"TIMESTAMP_X",
    		"SECTION_PAGE_URL",
    	));
 		while($ob = $res->GetNext())
 		{
			$arURL[] = array(
		   	'NAME' => $ob['NAME'],
		   	'URL' => $ob['SECTION_PAGE_URL'],
				'DATE' => date('c',strtotime($ob['TIMESTAMP_X']))
			);
 		}
		//Список элементов
 		$res = CIBlockElement::GetList(
    	array(),
    	Array(
       	"IBLOCK_ID" => $iblock_id,
       	"ACTIVE_DATE" => "Y",
       	"ACTIVE" => "Y" ,
    	),
  		false,
  		false,
  		array(
	  		"ID",
	  		"NAME",
	  		"DETAIL_PAGE_URL",
				"TIMESTAMP_X"
  	));
 		while($ob = $res->GetNext())
 		{
			$arURL[] = array(
		   	'NAME' => $ob['NAME'],
		   	'URL' => $ob['DETAIL_PAGE_URL'],
				'DATE' => date('c',strtotime($ob['TIMESTAMP_X']))
			);
 		}
	} // dump($arURL);

	foreach ($arURL as $key => $value) {
		$xml_content .= '<url><loc>https://poselkino.ru'.$value['URL'].'</loc><lastmod>'.$value['DATE'].'</lastmod><priority>0.8</priority></url>';
	}

// запись в файл sitemap-iblocks-pages.xml
	$fp = fopen('../sitemap/sitemap-iblocks-pages.xml', 'w+');
	$xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$xml_content.'</urlset>';
	fwrite($fp,$xml);
	fclose($fp);
	unset($xml_content);

// сформируем теги
// шоссе до МКАД и газ
	foreach ($arShosse as $shosse => $value) {
		for ($i=10; $i < 60; $i+=10) { // до МКАД
			$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-uchastok/'.$shosse.'-shosse-do-'.$i.'-km-mkad/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
			$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-dom/'.$shosse.'-shosse-do-'.$i.'-km-mkad/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
			$xml_content .= '<url><loc>https://poselkino.ru/poselki/'.$shosse.'-shosse-do-'.$i.'-km-mkad/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
		}
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-uchastok/'.$shosse.'-shosse-gaz/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-dom/'.$shosse.'-shosse-gaz/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/'.$shosse.'-shosse-gaz/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
	}
// район до МКАД и газ
	foreach ($arRegion as $rayon => $value) {
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-uchastok/'.$rayon.'-rayon-gaz/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-dom/'.$rayon.'-rayon-gaz/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/'.$rayon.'-rayon-gaz/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
	}
// до МКАД газ
	for ($i=10; $i < 60; $i+=10) {
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-uchastok/gaz-do-'.$i.'-km-mkad/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-dom/gaz-do-'.$i.'-km-mkad/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/gaz-do-'.$i.'-km-mkad/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
	}
// до МКАД ИЖС
	for ($i=10; $i < 60; $i+=10) {
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-uchastok/do-'.$i.'-km-mkad-izhs/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-dom/do-'.$i.'-km-mkad-izhs/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
		$xml_content .= '<url><loc>https://poselkino.ru/poselki/do-'.$i.'-km-mkad-izhs/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
	}

// стоимость
	$onlyShosse = ['dmitrovskoe','novoryazanskoe','simferopolskoe','novorijskoe'];
	$urlPriceShosse = [
	 'do-100-tysyach',
	 'do-150-tysyach',
	 'do-200-tysyach',
	 'do-300-tysyach',
	 'do-400-tysyach',
	 'do-500-tysyach',
	 'do-600-tysyach',
	 'do-700-tysyach',
	 'do-1-milliona',
	 'do-1,5-milliona',
	 'do-2-milliona',
	 'do-3-milliona',
	 'do-4-milliona',
	 'do-5-milliona',
	 'do-1-milliona',
	 'do-1,5-milliona',
	 'do-2-milliona',
	 'do-3-milliona',
	 'do-4-milliona',
	 'do-5-milliona',
	 'do-6-milliona',
	 'do-7-milliona',
	 'do-8-milliona',
	 'do-9-milliona',
	 'do-10-milliona',
	 'do-15-milliona',
	 'do-20-milliona',
	 'do-30-milliona',
	];
	$noUrlPriceShosse = [
	 'do-100-tysyach',
 	 'do-150-tysyach',
 	 'do-200-tysyach',
 	 'do-300-tysyach',
 	 'do-400-tysyach',
 	 'do-500-tysyach',
 	 'do-600-tysyach',
 	 'do-700-tysyach',
	];

	foreach ($urlPriceShosse as $price) {
		foreach ($onlyShosse as $shosse) {
			$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-uchastok/'.$shosse.'-shosse-'.$price.'/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
			if(!in_array($price,$noUrlPriceShosse)){
				$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-dom/'.$shosse.'-shosse-'.$price.'/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
			}
		}
	}

// коммуникации и шоссе
	$commun2 = ['svet','voda','gaz','kommunikatsii'];

	foreach ($commun2 as $commun) {
		foreach ($onlyShosse as $shosse) {
			$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-uchastok/'.$shosse.'-shosse-'.$commun.'/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
			$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-dom/'.$shosse.'-shosse-'.$commun.'/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
			$xml_content .= '<url><loc>https://poselkino.ru/poselki/'.$shosse.'-shosse-'.$commun.'/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
		}
	}
// коммуникации и МКАД
	foreach ($commun2 as $commun) {
		for ($i=10; $i < 60; $i+=10) { // до МКАД
			$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-uchastok/'.$commun.'-do-'.$i.'-km-mkad/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
			$xml_content .= '<url><loc>https://poselkino.ru/poselki/kupit-dom/'.$commun.'-do-'.$i.'-km-mkad/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
			$xml_content .= '<url><loc>https://poselkino.ru/poselki/'.$commun.'-do-'.$i.'-km-mkad/</loc><lastmod>'.date('c').'</lastmod><priority>1</priority></url>';
		}
	}

// запись в файл sitemap-tegi-pages.xml
	$fp = fopen('../sitemap/sitemap-tegi-pages.xml', 'w+');
	$xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$xml_content.'</urlset>';
	fwrite($fp,$xml);
	fclose($fp);
	unset($xml_content);

	$arSitemapPage = [
		'sitemap-seo-pages.xml',
		'sitemap-static-pages.xml',
		'sitemap-iblocks-pages.xml',
		'sitemap-tegi-pages.xml',
	];
	foreach ($arSitemapPage as $sitemap) {
		$xml_content .= '<sitemap><loc>https://poselkino.ru/sitemap/'.$sitemap.'</loc></sitemap>';
	}

// запись в файл
	$fp = fopen('../sitemap.xml', 'w+');
	$xml = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$xml_content.'</sitemapindex>';
	fwrite($fp,$xml);
	fclose($fp);
?>
