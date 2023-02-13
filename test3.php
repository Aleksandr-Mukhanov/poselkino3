<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
echo 'ok<br>';

// передадим в АМО
$name = 'тест';
$namePos = 'Фишер';
$_POST['develName'] = 'тестовый';

$arLead['add'] = [
	[
		'name' => $name.' ('.$namePos.') - с сайта', // имя сделки
		'status_id' => '28709515', // статус 'Новый лид'
		'created_at' => time(),
		'custom_fields' => [
			[
				'id' => 650157, // Девелопер
				'values' => [
					[
						'value' => $_POST['develName']
					]
				]
			],
		]
	]
];

// $url = "/api/v2/leads";
// $resultAmo = inAmo($arLead,$url);
// dump($resultAmo);

use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;
	Loader::includeModule('highloadblock');
  Loader::includeModule('iblock');

$hlblock_id = 17; // id HL
$hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();
$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();

$property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC"), Array("IBLOCK_ID"=>1, "CODE"=>"REGION"));
while($enum_fields = $property_enums->GetNext())
{
  dump($enum_fields);
  $data =[
		"UF_NAME" => $enum_fields['VALUE'],
    "UF_XML_ID" => $enum_fields['XML_ID'],
	];
  // dump($data);
	// $result = $entity_data_class::add($data);
}

// сортировка urlrewrite.php
// $i = 0;
// foreach ($arUrlRewrite as $value) {
//   $i += 10;
//   echo $i." => "."[<br>".
//     "qqqq'CONDITION' => '".$value["CONDITION"]."',<br>".
//     "qqqq'RULE' => '".$value["RULE"]."',<br>".
//     "qqqq'ID' => '".$value["ID"]."',<br>".
//     "qqqq'PATH' => '".$value["PATH"]."',<br>".
//     "qqqq'SORT' => ".$i.",<br>"
//   ."],<br>";
// }

// $tel = '+7(985)291-31-17';
// $text = 'Вам пришла заявка на почту, зарегистрируйте клиента';
// $result = sendSMS($tel,$text);
// dump($result);

// use Bitrix\Main\Loader;
// 	Loader::includeModule('iblock');
// 	Loader::includeModule('highloadblock');
// use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;
//
// $arElHL = getElHL(13,[],['UF_XML_ID'=>'Иван К.'],['*']);
// $arManager = array_values($arElHL)[0];
// dump($arManager);

// $id = '1ixXs-GFnBLZ9V91dzUaimCeG6lYqWTnvzJU97yZPV8U';
// $gid = '0';
//
// $csv = file_get_contents('https://docs.google.com/spreadsheets/d/' . $id . '/export?format=csv&gid=' . $gid);
// $csv = explode("\r\n", $csv);
// $array = array_map('str_getcsv', $csv);
//
// print_r($array);
