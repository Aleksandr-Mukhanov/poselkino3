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
?>
<div class="slider-article" id="slider_article">
  <?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
  <a class="article-card" href="<?=$arItem["DETAIL_PAGE_URL"]?>" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
    <div class="article-card__img" style="background: #eee url(<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>); background-size: cover; background-position: center center;"></div>
    <div class="article-card__content">
      <div class="article-card__title"><?=$arItem["NAME"]?></div>
      <div class="article-card__text"><?=$arItem["PREVIEW_TEXT"]?></div>
    </div>
    <div class="article-card__footer">
      <div class="article-card__date"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></div>
      <div class="article-card__share">
        <svg xmlns="http://www.w3.org/2000/svg" width="10.838" height="10.931" viewBox="0 0 10.838 10.931" class="inline-svg">
          <g transform="translate(-2.006)" opacity="0.5">
            <g transform="translate(2.006)">
              <path d="M10.851,6.947A1.979,1.979,0,0,0,9.3,7.711L5.913,5.981a1.979,1.979,0,0,0,.076-.515A1.963,1.963,0,0,0,5.9,4.907L9.266,3.185a1.983,1.983,0,1,0-.405-1.194,1.97,1.97,0,0,0,.077.517L5.555,4.238a1.99,1.99,0,1,0,.029,2.419L8.951,8.379a1.967,1.967,0,0,0-.091.56,1.992,1.992,0,1,0,1.992-1.992Z"
                transform="translate(-2.006)" fill="#919fa3" />
            </g>
          </g>
        </svg>
        228
      </div>
    </div>
  </a>
  <?endforeach;?>
</div>
