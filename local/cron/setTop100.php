<?$_SERVER["DOCUMENT_ROOT"] = '/var/www/u0428181/data/www/olne.ru';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
	Loader::includeModule('iblock');
	Loader::includeModule('highloadblock');
use Bitrix\Seo\SitemapTable;
use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;

echo 'ТОП 100<br>';
// автоматически ставить шильдик ТОП 100
$arElHL = getElHL(5,[],['UF_TOP100'=>true],['ID','UF_XML_ID']);
foreach ($arElHL as $value)
	$arDevelopersTOP100[] = $value['UF_XML_ID'];

$i=0;
$iBlockID = 1;
// Вытаскиваем элементы инфоблока
$arOrder = ['SORT'=>'ASC'];
$arFilter = [
  'IBLOCK_ID' => $iBlockID,
  'ACTIVE' => 'Y',
  '!PROPERTY_SALES_PHASE' => 254,
  '!PROPERTY_HIDE_POS' => 273,
  'PROPERTY_DEVELOPER_ID' => $arDevelopersTOP100,
];
$arSelect = ['ID','NAME','PROPERTY_TOP_100'];
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while ($arElement = $rsElements->Fetch())
{ // dump($arElement);
  $i++;
  if (!$arElement['PROPERTY_TOP_100_VALUE'])
    dump($arElement);
    // CIBlockElement::SetPropertyValues($arElement['ID'], $iBlockID, 554, "TOP_100");
}
echo 'Всего: '.$i.'<br>';
