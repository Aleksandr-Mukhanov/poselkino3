<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Девелопер");
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
<main class="page page-developer-info">
	<div class="bg-white page-va-list__info">
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
    <?$APPLICATION->IncludeComponent("bitrix:highloadblock.view", "developer_detail", Array(
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
if($_REQUEST['PAGEN_1']){
  $title = $nameDevel." - страница ".$_REQUEST['PAGEN_1'];
  $description = $title.' - сайт Поселкино';
}else{
  $title = $nameDevel." - отзывы, участки и поселки компании в Подмосковье";
  $description = "Все 🏠 доступные поселки ▶ Компания ".$nameDevel." ▶ Реальные отзывы, адрес девелопера и контакты, официальный сайт – на сайте Poselkino.ru";
}
$APPLICATION->SetPageProperty("title",$title);
$APPLICATION->SetPageProperty("description",$description);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
