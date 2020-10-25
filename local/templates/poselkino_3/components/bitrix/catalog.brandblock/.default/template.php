<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
// dump($arParams['CODE_DEVEL']);
$i=0;?>
<div class="d-flex flex-wrap flex-md-nowrap text-cener justify-content-center mt-3 mt-md-5 align-items-center">
  <?foreach ($arResult["BRAND_BLOCKS"] as $blockId => $arBB){?>
    <div class="d-block d-md-none mb-4 mb-md-0 w-100 text-center width-md-auto">
      <a class="developer-logo mt-3 mt-md-0" href="/developery/<?=$arParams['CODE_DEVEL'][$i]?>/" target="_blank" itemprop="manufacturer"><img src="<?=$arBB['PICT']['SRC']?>" alt="<?=$arBB['NAME'] // Девелопер ID?>"></a>
    </div>
    <?/*?><a class="btn btn-warning rounded-pill mb-3" href="#" data-toggle="modal" data-target="#feedbackModal" data-id-button='LEAVE_REQUEST' data-title='Перезвоните мне'>Связаться с девелопером</a><?*/?>
    <a class="d-none d-md-inline developer-logo mt-3 mt-md-0" href="/developery/<?=$arParams['CODE_DEVEL'][$i]?>/" target="_blank"><img src="<?=$arBB['PICT']['SRC']?>" alt="<?=$arBB['NAME'] // Девелопер ID?>"></a>
    <input type="hidden" id="develInfo" data-develId='<?=$arParams['CODE_DEVEL'][$i]?>' data-develName='<?=$arBB['NAME']?>'>
  <?$i++;}?>
</div>
