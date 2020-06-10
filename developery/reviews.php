<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Отзывы о девелопере");
\Bitrix\Main\Loader::includeModule('highloadblock');
use Bitrix\Highloadblock as HL,
  Bitrix\Main\Entity;

	// получим id девелопера
	$hlblock_id = 5; // id HL
	$hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();
	$entity = HL\HighloadBlockTable::compileEntity($hlblock);
	$entity_data_class = $entity->getDataClass();
	$entity_table_name = $hlblock['TABLE_NAME'];
	$sTableID = 'tbl_'.$entity_table_name;

	$rsData = $entity_data_class::getList([
		'filter' => ['UF_XML_ID' => $_REQUEST["CODE"]],
    'select' => ['ID','UF_NAME']
	]);
	$rsData = new CDBResult($rsData, $sTableID);

	if($arRes = $rsData->Fetch()){ // dump($arRes);
		$idDevel = $arRes['ID'];
    $nameDevel = $arRes['UF_NAME'];
	} // dump($idDevel);
	// echo $_REQUEST["CODE"];
?>
<main class="page page-village page-va-list">
	<div class="bg-white">
		<div class="container d-none d-sm-block">
      <?$APPLICATION->IncludeComponent(
        "bitrix:breadcrumb",
        "poselkino",
        array(
          "PATH" => "",
          "SITE_ID" => "s1",
          "START_FROM" => "0",
          "COMPONENT_TEMPLATE" => "poselkino"
        ),
        false
      );?>
		</div>
    <?$APPLICATION->IncludeComponent("bitrix:highloadblock.view", "developer_reviews", Array(
    		"BLOCK_ID" => "5",	// ID инфоблока
    		"CHECK_PERMISSIONS" => "N",	// Проверять права доступа
    		"COMPOSITE_FRAME_MODE" => "N",	// Голосование шаблона компонента по умолчанию
    		"COMPOSITE_FRAME_TYPE" => "AUTO",	// Содержимое компонента
    		"LIST_URL" => "/developery/",	// Путь к странице списка записей
    		"ROW_ID" => $idDevel,	// Значение ключа записи
    		"ROW_KEY" => "ID",	// Ключ записи
    		"COMPONENT_TEMPLATE" => ".default"
    	),
    	false
    );?>
  </div>
</main>
<? // установим мета
$APPLICATION->SetPageProperty("title","Отзывы ".$nameDevel." - читать отзывы владельцев недвижимости о ".$nameDevel);
$APPLICATION->SetPageProperty("description","Отзывы ▶ Компания ".$nameDevel." ▶ Реальные отзывы про девелопера, официальный сайт – на сайте Poselkino.ru");?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
