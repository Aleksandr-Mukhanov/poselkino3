<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?if(count($arResult["SEARCH"])>0){
	foreach($arResult["SEARCH"] as $arItem){ //dump($arItem);
		$arIdVil[]=$arItem["ITEM_ID"];
	}
	//dump($arIdVil);
}
$arResult["arrFilter"] = $arIdVil;?>
