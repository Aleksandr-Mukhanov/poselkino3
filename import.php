<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("import");

use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;
	Loader::includeModule('highloadblock');
  Loader::includeModule('iblock');

$hlblock_id = 21; // id HL
$hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();
$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();

$property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC"), Array("IBLOCK_ID"=>7, "CODE"=>"SHOSSE"));
while($enum_fields = $property_enums->GetNext())
{
  // dump($enum_fields);
  $data =[
		"UF_NAME" => $enum_fields['VALUE'],
    "UF_XML_ID" => $enum_fields['XML_ID'],
	];
  dump($data);
	// $result = $entity_data_class::add($data);
}?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
