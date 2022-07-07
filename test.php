<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("test");
use Bitrix\Main\Loader;
	Loader::includeModule('iblock');
	Loader::includeModule('highloadblock');
use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;

// блокировка заявок по E-mail
$arElHL = getElHL(11,[],[],['*']);
foreach ($arElHL as $value)
	$arEmails[] = $value['UF_EMAIL'];

$email = 'r.aymanov@yandex.ru';

if (!in_array($email,$arEmails)) echo 'ok';
else echo 'no';
?>
<main class="page page-contacts">
	<div class="bg-white">
		<div class="container my-5">
			<div class="row">
				<div class="col-12">
			 <? $i = 0;
			 // получим шоссе
			 // $propEnums = CIBlockPropertyEnum::GetList(
				//  ["SORT"=>"ASC","VALUE"=>"ASC"],
				//  ["IBLOCK_ID"=>1,"CODE"=>"SHOSSE"]
			 // );
			 // while($enumFields = $propEnums->GetNext()){ // dump($enumFields);
				//  $arShosse[$enumFields['XML_ID']] = $enumFields['VALUE'];
			 // } // dump($arShosse);
			 // foreach ($arShosse as $shosse => $value) {
				//  for ($i=10; $i < 60; $i+=10) { // до МКАД
				// 	 echo $urlTeg1 = '/poselki/kupit-uchastok/'.$shosse.'-shosse-do-'.$i.'-km-mkad/';
				// 	 echo '<br>';
				// 	 echo $urlTeg2 = '/poselki/kupit-dom/'.$shosse.'-shosse-do-'.$i.'-km-mkad/';
				// 	 echo '<br>';
				// 	 echo $urlTeg3 = '/poselki/'.$shosse.'-shosse-do-'.$i.'-km-mkad/';
				// 	 echo '<br>';
 			  // }
				// echo $urlTeg1 = '/poselki/kupit-uchastok/'.$shosse.'-shosse-gaz/';
				// echo '<br>';
				// echo $urlTeg2 = '/poselki/kupit-dom/'.$shosse.'-shosse-gaz/';
				// echo '<br>';
				// echo $urlTeg3 = '/poselki/'.$shosse.'-shosse-gaz/';
				// echo '<br>';
			 // }
			 // получим районы
			 // $propEnums = CIBlockPropertyEnum::GetList(
				//  ["SORT"=>"ASC","VALUE"=>"ASC"],
				//  ["IBLOCK_ID"=>1,"CODE"=>"REGION"]
			 // );
			 // while($enumFields = $propEnums->GetNext()){ // dump($enumFields);
				//  $arRegion[$enumFields['XML_ID']] = $enumFields['VALUE'];
			 // }
			 // foreach ($arRegion as $rayon => $value) {
				// echo $urlTeg1 = '/poselki/kupit-uchastok/'.$rayon.'-rayon-gaz/';
 				// echo '<br>';
 				// echo $urlTeg2 = '/poselki/kupit-dom/'.$rayon.'-rayon-gaz/';
 				// echo '<br>';
 				// echo $urlTeg3 = '/poselki/'.$rayon.'-rayon-gaz/';
 				// echo '<br>';
			 // }
			 // for ($i=10; $i < 60; $i+=10) { // до МКАД
			 // 	 echo $urlTeg1 = '/poselki/kupit-uchastok/gaz-do-'.$i.'-km-mkad/';
			 // 	 echo '<br>';
			 // 	 echo $urlTeg2 = '/poselki/kupit-dom/gaz-do-'.$i.'-km-mkad/';
			 // 	 echo '<br>';
			 // 	 echo $urlTeg3 = '/poselki/gaz-do-'.$i.'-km-mkad/';
			 // 	 echo '<br>';
			 // }
			 // for ($i=10; $i < 60; $i+=10) { // до МКАД
			 // 	 echo $urlTeg1 = '/poselki/kupit-uchastok/do-'.$i.'-km-mkad-izhs/';
			 // 	 echo '<br>';
			 // 	 echo $urlTeg2 = '/poselki/kupit-dom/do-'.$i.'-km-mkad-izhs/';
			 // 	 echo '<br>';
			 // 	 echo $urlTeg3 = '/poselki/do-'.$i.'-km-mkad-izhs/';
			 // 	 echo '<br>';
			 // }

			 $onlyShosse = ['dmitrovskoe','novoryazanskoe','simferopolskoe','novorijskoe'];
			 $urlPrice = [
		 		'do-100-tysyach/',
		 		'do-150-tysyach/',
		 		'do-200-tysyach/',
		 		'do-300-tysyach/',
		 		'do-400-tysyach/',
		 		'do-500-tysyach/',
		 		'do-600-tysyach/',
		 		'do-700-tysyach/',
		 		'do-1-milliona/',
		 		'do-1,5-milliona/',
		 		'do-2-milliona/',
		 		'do-3-milliona/',
		 		'do-4-milliona/',
		 		'do-5-milliona/',
		 		'do-1-milliona/',
		 		'do-1,5-milliona/',
		 		'do-2-milliona/',
		 		'do-3-milliona/',
		 		'do-4-milliona/',
		 		'do-5-milliona/',
		 		'do-6-milliona/',
		 		'do-7-milliona/',
		 		'do-8-milliona/',
		 		'do-9-milliona/',
		 		'do-10-milliona/',
		 		'do-15-milliona/',
		 		'do-20-milliona/',
		 		'do-30-milliona/',
		 	];

			// foreach ($urlPrice as $price) {
			// 	foreach ($onlyShosse as $shosse) {
			// 		echo $urlTeg1 = '/poselki/kupit-uchastok/'.$shosse.'-shosse-'.$price; echo '<br>';
			// 		echo $urlTeg2 = '/poselki/kupit-dom/'.$shosse.'-shosse-'.$price; echo '<br>';
			// 	}
			// }

			$commun2 = [ 'svet', 'voda', 'gaz', 'kommunikaciyami' ];

			// foreach ($commun2 as $commun) {
			// 	foreach ($onlyShosse as $shosse) {
			// 		echo $urlTeg1 = '/poselki/kupit-uchastok/'.$shosse.'-shosse-'.$commun.'/'; echo '<br>';
			// 		echo $urlTeg2 = '/poselki/kupit-dom/'.$shosse.'-shosse-'.$commun.'/'; echo '<br>';
			// 		echo $urlTeg3 = '/poselki/'.$shosse.'-shosse-'.$commun.'/'; echo '<br>';
			// 	}
			// }

			// foreach ($commun2 as $commun) {
			// 	for ($i=10; $i < 60; $i+=10) { // до МКАД
			// 		echo $urlTeg1 = '/poselki/kupit-uchastok/'.$commun.'-do-'.$i.'-km-mkad/'; echo '<br>';
			// 		echo $urlTeg2 = '/poselki/kupit-dom/'.$commun.'-do-'.$i.'-km-mkad/'; echo '<br>';
			// 		echo $urlTeg3 = '/poselki/'.$commun.'-do-'.$i.'-km-mkad/'; echo '<br>';
			// 	}
			// }

 		// получим девелоперов
	// 		 $hlblock_id = 5; // id HL
	// 		 $hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();
	// 		 $entity = HL\HighloadBlockTable::compileEntity($hlblock);
	// 		 $entity_data_class = $entity->getDataClass();
	// 		 $entity_table_name = $hlblock['TABLE_NAME'];
	// 		 $sTableID = 'tbl_'.$entity_table_name;
	//
	// 		 $rsData = $entity_data_class::getList([
	// 		   'filter' => ['*'],
	// 		   'select' => ['ID','UF_NAME','UF_XML_ID'],
	// 		 ]);
	// 		 $rsData = new CDBResult($rsData, $sTableID);
	//
	// 		 while($arRes = $rsData->Fetch()){ // dump($arRes);
	// 			 // $arDevel[]
	// 		 }
	// 		 // получим поселки
 	// $arOrder = Array("SORT"=>"ASC");
	// $arFilter = Array("IBLOCK_ID"=>1,"ACTIVE"=>"Y");
	// $arSelect = Array("ID","NAME","PROPERTY_DEVELOPER_ID");
	// $rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
	// while($arElement = $rsElements->GetNext()){ // dump($arElement);
	// 	$change = false;
	// 	switch ($arElement['PROPERTY_DEVELOPER_ID_VALUE']) {
	// 		case 'lesireka': $PROPERTY_VAL = 'les-i-reka'; $change = true; break;
	// 		case 'Pragma Kapital': $PROPERTY_VAL = 'Pragma-Kapital'; $change = true; break;
	// 		case 'Lisya gorka': $PROPERTY_VAL = 'Lisya-gorka'; $change = true; break;
	// 		case 'New Bakeevo': $PROPERTY_VAL = 'Novoe-Bakeevo'; $change = true; break;
	// 		case 'Golden Pines': $PROPERTY_VAL = 'Zolotye-Sosny'; $change = true; break;
	// 		case 'Dacha 9-18': $PROPERTY_VAL = 'Dacha-9-18'; $change = true; break;
	// 		case 'Moskovskie Dali': $PROPERTY_VAL = 'Moskovskie-Dali'; $change = true; break;
	// 		case 'AKRON Development': $PROPERTY_VAL = 'AKRON-Development'; $change = true; break;
	// 		case 'Rio Land': $PROPERTY_VAL = 'Rio-Land'; $change = true; break;
	// 		case 'Lama Village': $PROPERTY_VAL = 'Lama-Village'; $change = true; break;
	// 		case 'My Land': $PROPERTY_VAL = 'Moya-Zemlya'; $change = true; break;
	// 		case 'Ekaterininskoe podvore': $PROPERTY_VAL = 'Ekaterininskoe-podvore'; $change = true; break;
	// 		case 'Mozaik development': $PROPERTY_VAL = 'Mozaik-development'; $change = true; break;
	// 		case 'Maleevskie prostory': $PROPERTY_VAL = 'Maleevskie-prostory'; $change = true; break;
	// 		case 'Russian lands': $PROPERTY_VAL = 'Zemli-Rossii'; $change = true; break;
	// 		case 'Adva Esteyt': $PROPERTY_VAL = 'Adva-Esteyt'; $change = true; break;
	// 		case 'Dachnyy Alyans': $PROPERTY_VAL = 'Dachnyy-Alyans'; $change = true; break;
	// 		case 'Tierra Group': $PROPERTY_VAL = 'Tierra-Group'; $change = true; break;
	// 		case 'M9 Land.ru': $PROPERTY_VAL = 'M9-Land.ru'; $change = true; break;
	// 		case 'Vash poselok': $PROPERTY_VAL = 'Vash-poselok'; $change = true; break;
	// 		case 'ABVG Dacha': $PROPERTY_VAL = 'ABVG-Dacha'; $change = true; break;
	// 		case 'world of luck': $PROPERTY_VAL = 'Mir-Udach'; $change = true; break;
	// 		case 'Green Town': $PROPERTY_VAL = 'Green-Town'; $change = true; break;
	// 		case 'Zemlya MO': $PROPERTY_VAL = 'Zemlya-MO'; $change = true; break;
	// 		case 'Zemexx': $PROPERTY_VAL = 'Zemelniy-Ekspress'; $change = true; break;
	// 		case 'zemeco': $PROPERTY_VAL = 'EkoZem'; $change = true; break;
	// 		case 'Own-land': $PROPERTY_VAL = 'Svoya-Zemlya'; $change = true; break;
	// 		case 'ivanov': $PROPERTY_VAL = 'Ivanov-i-Partnery'; $change = true; break;
	// 		case 'Moscow_coast': $PROPERTY_VAL = 'Moskovskiy-Bereg'; $change = true; break;
	// 		case 'beautiful_land': $PROPERTY_VAL = 'Krasivaya-Zemlya'; $change = true; break;
	// 		case 'Own_Country': $PROPERTY_VAL = 'Svoya-Dacha'; $change = true; break;
	// 		case 'Atlas': $PROPERTY_VAL = 'Atlas-dom'; $change = true; break;
	// 		case 'Land-Msk': $PROPERTY_VAL = 'Zemli-Msk'; $change = true; break;
	// 		case 'Land_Format': $PROPERTY_VAL = 'Zemelniy-Format'; $change = true; break;
	// 		case 'native-land': $PROPERTY_VAL = 'Rodnie-Zemli'; $change = true; break;
	//
	// 		default: $change = false; break;
	// 	}
	// 	if($change){
	// 		// dump($arElement);
	// 		// $PROPERTY_VAL = 'Novoe-Bakeevo';
	// 		$PROPERTY_CODE = 'DEVELOPER_ID';
	// 		// CIBlockElement::SetPropertyValues($arElement['ID'], 1, $PROPERTY_VAL, $PROPERTY_CODE);
	// 	}
	// } // echo $i;
			 // получим поселки
 	// $arOrder = Array("SORT"=>"ASC");
	// $arFilter = Array("IBLOCK_ID"=>1,"ACTIVE"=>"Y","PROPERTY_STOIMOST_UCHASTKA"=>false);
	// $arSelect = Array("ID","NAME","PROPERTY_COST_LAND_IN_CART","PROPERTY_HOME_VALUE","PROPERTY_DOMA");
	// $rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
	// while($arElement = $rsElements->GetNext()){
	// 	$i++;
	// 	// echo '<pre>'; print_r($arElement); echo'</pre>';
	// 	if($arElement['PROPERTY_DOMA_ENUM_ID'] == 3){
	// 		$PROPERTY_VAL = [["VALUE" => $arElement['PROPERTY_COST_LAND_IN_CART'][0]],["VALUE" => $arElement['PROPERTY_COST_LAND_IN_CART'][1]]];
	// 		$PROPERTY_CODE = 'STOIMOST_UCHASTKA';
	// 		echo $arElement['NAME'].'<br>';
	// 		// CIBlockElement::SetPropertyValues($arElement['ID'], 1, $PROPERTY_VAL, $PROPERTY_CODE);
	// 	}elseif($arElement['PROPERTY_DOMA_ENUM_ID'] == 4){
	// 		$PROPERTY_VAL = [["VALUE" => $arElement['PROPERTY_HOME_VALUE'][0]],["VALUE" => $arElement['PROPERTY_HOME_VALUE'][1]]];
	// 		$PROPERTY_CODE = 'STOIMOST_UCHASTKA';
	// 		echo $arElement['NAME'].'<br>';
	// 		// CIBlockElement::SetPropertyValues($arElement['ID'], 1, $PROPERTY_VAL, $PROPERTY_CODE);
	// 	}else{
	// 		echo $arElement['NAME'].'<br>';
	// 	}
	// } echo $i;
				// сортировка urlrewrite.php
				// $i = 0;
				// foreach ($arUrlRewrite as $key => $value) {
        //   $i += 10;
        //   echo $i." => "."[<br>".
        //     "qqqq'CONDITION' => '".$value["CONDITION"]."',<br>".
        //     "qqqq'RULE' => '".$value["RULE"]."',<br>".
        //     "qqqq'ID' => '".$value["ID"]."',<br>".
        //     "qqqq'PATH' => '".$value["PATH"]."',<br>".
        //     "qqqq'SORT' => ".$i.",<br>"
        //   ."],<br>";
        // }

				// $authAmoResult = authInAmo(); // результат авторизации в АМО
				// echo "Авторизация в АМО: ".$authAmoResult;

				// передадим в АМО
				// $arLead['add'] = [
				// 	[
				// 		'name' => 'Заявка с сайта', // имя сделки
				// 		'status_id' => '28709515', // статус 'Новый лид'
				// 		'created_at' => time(),
				// 		// 'custom_fields' => []
				// 	]
				// ];
				//
				// $url = "/api/v2/leads";
				// $resultAmo = inAmo($arLead,$url);
				// $requestId = $resultAmo['_embedded']['items'][0]['id'];
				//
				// // создадим контакт в АМО
				// $arCont['add'] = [
				// 	[
				// 		'name' => 'test', // имя контакта
				// 		'leads_id' => [$requestId],
				// 		'created_at' => time(),
				// 		'custom_fields' => [
				// 			[
				// 				'id' => 426347, // Телефон
				// 				'values' => [
				// 					[
				// 						'value' => '+7 (985) 777-77-77',
				// 						'enum' => 600995 // Раб. тел.
				// 					]
				// 				]
				// 			],
				// 		]
				// 	]
				// ];
				// $url = "/api/v2/contacts";
				// $resultAmo = inAmo($arCont,$url); //dump($resultAmo);
				if(isset($_COOKIE['comparison_vil'])){
					$arComparison = explode('-',$_COOKIE['comparison_vil']);
				}
				if(isset($_COOKIE['favorites_vil'])){
					$arFavorites = explode('-',$_COOKIE['favorites_vil']);
				}
				$item['ID'] = 204;
				$arOrder = Array("SORT"=>"ASC");
				$arFilter = Array("IBLOCK_ID"=>1,"ACTIVE"=>"Y","ID"=>204);
				$arSelect = Array("ID","NAME","PROPERTY_*","IBLOCK_SECTION_ID");
				$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
				while($arElement = $rsElements->GetNext()){
					// echo '<pre>'; print_r($arElement); echo'</pre>';
					$item = $arElement;
				}
				$generalParams['COMPARISON'] = (in_array($item['ID'],$arComparison)) ? 'Y' : 'N';
				$generalParams['FAVORITES'] = (in_array($item['ID'],$arFavorites)) ? 'Y' : 'N';
				$generalParams['TEMPLATE_CARD'] = 'poselok_index';
				// dump($item);
				?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.item",
	"poselok_index",
	array(
		"RESULT" => array(
			"ITEM" => $item,
			// 'AREA_ID' => $areaIds[$item['ID']],
			"TYPE" => "CARD",
			"BIG_LABEL" => "N",
			"BIG_DISCOUNT_PERCENT" => "N",
			"BIG_BUTTONS" => "N",
			"SCALABLE" => "N",
		),
		"PARAMS" => $generalParams,
		"COMPONENT_TEMPLATE" => "poselok_index"
	),
	false
);?>
				</div>
			</div>
		</div>
	</div>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
