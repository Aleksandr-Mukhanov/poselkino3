<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult['ERROR']))
{
	echo $arResult['ERROR'];
	return false;
}

// dump($arResult);
?>
<div class="owl-carousel owl-nav owl-devoloper">
	<?foreach ($arResult['rows'] as $key => $val) { // dump($val)
		$arFile = explode('"',$val['UF_FILE']); // dump($arFile);?>
		<div class="item">
			<img class="lazy" src="#" data-original="<?=$arFile[1]?>" alt="<?=$val['UF_NAME']?>" title="<?=$val['UF_NAME']?>">
		</div>
	<?}?>
</div>
