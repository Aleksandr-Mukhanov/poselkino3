<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
echo 'ok<br>';

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

$id = '1ixXs-GFnBLZ9V91dzUaimCeG6lYqWTnvzJU97yZPV8U';
$gid = '0';

$csv = file_get_contents('https://docs.google.com/spreadsheets/d/' . $id . '/export?format=csv&gid=' . $gid);
$csv = explode("\r\n", $csv);
$array = array_map('str_getcsv', $csv);

print_r($array);
