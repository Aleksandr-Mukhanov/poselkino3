<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);

/*** CustomPageNav start ***/
$nPageWindow = 3; //количество отображаемых страниц
if ($arResult["NavPageNomer"] > floor($nPageWindow/2) + 1 && $arResult["NavPageCount"] > $nPageWindow)
	$nStartPage = $arResult["NavPageNomer"] - floor($nPageWindow/2);
else
	$nStartPage = 1;

if ($arResult["NavPageNomer"] <= $arResult["NavPageCount"] - floor($nPageWindow/2) && $nStartPage + $nPageWindow-1 <= $arResult["NavPageCount"])
	$nEndPage = $nStartPage + $nPageWindow - 1;
else
{
	$nEndPage = $arResult["NavPageCount"];
  if ($nEndPage - $nPageWindow + 1 >= 1) $nStartPage = $nEndPage - $nPageWindow + 1;
}
$arResult["nStartPage"] = $arResult["nStartPage"] = $nStartPage;
$arResult["nEndPage"] = $arResult["nEndPage"] = $nEndPage;
/*** CustomPageNav end ***/

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}

// dump($arResult);
if($_REQUEST['PAGEN_1'] > $arResult['NavPageCount']){ // 404 на несуществующие
	CHTTP::SetStatus("404 Not Found");
	@define("ERROR_404", "Y");
}

// $strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
// $strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");

if($arResult["bDescPageNumbering"] === true):
	$bFirst = true;
	if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
		if($arResult["bSavePage"]):
?>
			<li class="page-item pagination__arrow"><a class="page-link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>" aria-label="Предыдущая"><span aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="15.574" height="9.815" viewBox="0 0 15.574 9.815" class="inline-svg prev">
          <path d="M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z" transform="translate(0 -75.914)" /></svg></span></a></li>
<?
		else:
			if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"]+1) ):
?>
			<li class="page-item pagination__arrow"><a class="page-link" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" aria-label="Предыдущая"><span aria-hidden="true">
				<svg xmlns="http://www.w3.org/2000/svg" width="15.574" height="9.815" viewBox="0 0 15.574 9.815" class="inline-svg prev">
					<path d="M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z" transform="translate(0 -75.914)" /></svg></span></a></li>
<?
			else:
?>
			<li class="page-item pagination__arrow"><a class="page-link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>" aria-label="Предыдущая"><span aria-hidden="true">
				<svg xmlns="http://www.w3.org/2000/svg" width="15.574" height="9.815" viewBox="0 0 15.574 9.815" class="inline-svg prev">
					<path d="M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z" transform="translate(0 -75.914)" /></svg></span></a></li>
<?
			endif;
		endif;

		if ($arResult["nStartPage"] < $arResult["NavPageCount"]):
			$bFirst = false;
			if($arResult["bSavePage"]):
?>
			<li class="page-item"><a class="page-link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>">1</a></li>
<?
			else:
?>
			<li class="page-item"><a class="page-link" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">1</a></li>
<?
			endif;
			if ($arResult["nStartPage"] < ($arResult["NavPageCount"] - 1)):
?>
			<li class="page-item"><a class="page-link dotted" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=intVal($arResult["nStartPage"] + ($arResult["NavPageCount"] - $arResult["nStartPage"]) / 2)?>">...</a></li>
<?
			endif;
		endif;
	endif;
	do
	{
		$NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;

		if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
?>
		<li class="page-item"><a class="page-link active"><?=$NavRecordGroupPrint?></a></li>
<?
		elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):
?>
		<li class="page-item"><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" class="page-link"><?=$NavRecordGroupPrint?></a></li>
<?
		else:
?>
		<li class="page-item"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>" class="page-link"><?=$NavRecordGroupPrint?></a></li>
<?
		endif;

		$arResult["nStartPage"]--;
		$bFirst = false;
	} while($arResult["nStartPage"] >= $arResult["nEndPage"]);

	if ($arResult["NavPageNomer"] > 1):
		if ($arResult["nEndPage"] > 1):
			if ($arResult["nEndPage"] > 2):
?>
		<li class="page-item"><a class="page-link dotted" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nEndPage"] / 2)?>">...</a></li>
<?
			endif;
?>
		<li class="page-item"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1" class="page-link"><?=$arResult["NavPageCount"]?></a></li>
<?
		endif;

?>
		<li class="page-item pagination__arrow"><a class="page-link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>" aria-label="Следующая"><span aria-hidden="true">
      <svg xmlns="http://www.w3.org/2000/svg" width="15.574" height="9.815" viewBox="0 0 15.574 9.815" class="inline-svg next">
        <path d="M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z" transform="translate(0 -75.914)" /></svg></span></a></li>
<?
	endif;

else:
	$bFirst = true;

	if ($arResult["NavPageNomer"] > 1):
		if($arResult["bSavePage"]):
?>
			<li class="page-item pagination__arrow"><a class="page-link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>" aria-label="Предыдущая"><span aria-hidden="true">
				<svg xmlns="http://www.w3.org/2000/svg" width="15.574" height="9.815" viewBox="0 0 15.574 9.815" class="inline-svg prev">
					<path d="M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z" transform="translate(0 -75.914)" /></svg></span></a></li>
<?
		else:
			if ($arResult["NavPageNomer"] > 2):
?>
			<li class="page-item pagination__arrow"><a class="page-link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>" aria-label="Предыдущая"><span aria-hidden="true">
				<svg xmlns="http://www.w3.org/2000/svg" width="15.574" height="9.815" viewBox="0 0 15.574 9.815" class="inline-svg prev">
					<path d="M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z" transform="translate(0 -75.914)" /></svg></span></a></li>
<?
			else:
?>
			<li class="page-item pagination__arrow"><a class="page-link" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" aria-label="Предыдущая"><span aria-hidden="true">
				<svg xmlns="http://www.w3.org/2000/svg" width="15.574" height="9.815" viewBox="0 0 15.574 9.815" class="inline-svg prev">
					<path d="M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z" transform="translate(0 -75.914)" /></svg></span></a></li>
<?
			endif;

		endif;

		if ($arResult["nStartPage"] > 1):
			$bFirst = false;
			if($arResult["bSavePage"]):
?>
			<li class="page-item"><a class="page-link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1">1</a></li>
<?
			else:
?>
			<li class="page-item"><a class="page-link" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">1</a></li>
<?
			endif;
			if ($arResult["nStartPage"] > 2):
?>
			<li class="page-item"><a class="page-link dotted" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nStartPage"] / 2)?>">...</a></li>
<?
			endif;
		endif;
	endif;

	do
	{
		if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
?>
		<li class="page-item"><a class="page-link active"><?=$arResult["nStartPage"]?></a></li>
<?
		elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):
?>
		<li class="page-item"><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" class="page-link"><?=$arResult["nStartPage"]?></a></li>
<?
		else:
?>
		<li class="page-item"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>" class="page-link"><?=$arResult["nStartPage"]?></a></li>
<?
		endif;
		$arResult["nStartPage"]++;
		$bFirst = false;
	} while($arResult["nStartPage"] <= $arResult["nEndPage"]);

	if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
		if ($arResult["nEndPage"] < $arResult["NavPageCount"]):
			if ($arResult["nEndPage"] < ($arResult["NavPageCount"] - 1)):
?>
		<li class="page-item"><a class="page-link dotted" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nEndPage"] + ($arResult["NavPageCount"] - $arResult["nEndPage"]) / 2)?>">...</a></li>
<?
			endif;
?>
		<li class="page-item"><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>" class="page-link"><?=$arResult["NavPageCount"]?></a></li>
<?
		endif;
?>
		<li class="page-item pagination__arrow"><a class="page-link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>" aria-label="Следующая"><span aria-hidden="true">
      <svg xmlns="http://www.w3.org/2000/svg" width="15.574" height="9.815" viewBox="0 0 15.574 9.815" class="inline-svg next">
        <path d="M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z" transform="translate(0 -75.914)" /></svg></span></a></li>
<?
	endif;
endif;

if ($arResult["bShowAll"]):
	if ($arResult["NavShowAll"]):
?>
		<li class="page-item"><a class="page-link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=0"><?=GetMessage("nav_paged")?></a></li>
<?
	else:
?>
		<li class="page-item"><a class="page-link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=1"><?=GetMessage("nav_all")?></a></li>
<?
	endif;
endif
?>
