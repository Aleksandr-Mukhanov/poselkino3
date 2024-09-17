<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?if(count($arResult["SEARCH"])>0){
	foreach($arResult["SEARCH"] as $arItem){
		$arIdVil[]=$arItem["ITEM_ID"];
	}
}
$arResult["arrFilter"] = $arIdVil;?>
