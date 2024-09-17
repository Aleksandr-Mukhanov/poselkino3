<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

\Bitrix\Main\Loader::includeModule('highloadblock');
use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;

$params = [
  "max_len" => "100", // обрезает символьный код до 100 символов
  "change_case" => "L", // буквы преобразуются к нижнему регистру
  "replace_space" => "-", // меняем пробелы на тире
  "replace_other" => "-", // меняем левые символы на тире
  "delete_repeat_replace" => "true", // удаляем повторяющиеся символы
  "use_google" => "false", // отключаем использование google
];

$str = file_get_contents("import.csv");
$arr = explode("\n",$str); // dump($arr);

function trim_and_del ($val){
  $val = trim($val); // убираем пробелы
  $val = str_replace('"','',$val); // убираем кавычки
  return $val;
}

foreach($arr as $item){

  $arItem = array_map("trim_and_del",explode(";",$item)); // dump($arItem);

  if($item)
  {
    $hlblock_id = 26; // id HL
  	$hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();
  	$entity = HL\HighloadBlockTable::compileEntity($hlblock);
  	$entity_data_class = $entity->getDataClass();
  	$entity_table_name = $hlblock['TABLE_NAME'];
  	$sTableID = 'tbl_'.$entity_table_name;
    $data = [
      "UF_NAME" => $arItem[0],
      "UF_XML_ID" => CUtil::translit($arItem[0], "ru", $params),
    ]; // dump($data);

    // $result = $entity_data_class::add($data);
  }

}
