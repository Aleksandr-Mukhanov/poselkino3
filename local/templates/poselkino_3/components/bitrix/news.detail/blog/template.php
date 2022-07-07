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
CUtil::InitJSCore(array('fx'));
// dump($arResult);
?>
<div class="content" id="<?=$this->GetEditAreaId($arResult['ID'])?>">
  <div class="content__title">
    <h1 class="mt-3 mt-sm-5"><?=$arResult["NAME"]?></h1>
		<span class="date"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span>
  </div>
  <div class="content__body mt-5">
    <div class="content__img"><img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arResult["NAME"]?>"></div>
		<?=$arResult["DETAIL_TEXT"]?>
  </div>
  <div class="content__footer mt-5">
    <div class="content__shared">
      <div class="social-card__title">
        <svg xmlns="http://www.w3.org/2000/svg" width="13.699" height="12.231" viewBox="0 0 13.699 12.231" class="inline-svg">
          <path d="M13.554,31.467,9.64,27.553a.489.489,0,0,0-.833.344v1.957H7.094q-5.451,0-6.689,3.081A6.961,6.961,0,0,0,0,35.481a9.18,9.18,0,0,0,.971,3.448l.08.183q.057.13.1.229a.869.869,0,0,0,.1.168.261.261,0,0,0,.214.13.223.223,0,0,0,.18-.076.285.285,0,0,0,.065-.191,1.557,1.557,0,0,0-.019-.2,1.581,1.581,0,0,1-.019-.18q-.038-.52-.038-.94a6.507,6.507,0,0,1,.134-1.384,4.155,4.155,0,0,1,.371-1.059,2.659,2.659,0,0,1,.612-.772,3.589,3.589,0,0,1,.806-.531,4.372,4.372,0,0,1,1.017-.325,9.694,9.694,0,0,1,1.177-.164q.593-.046,1.342-.046H8.807v1.957a.487.487,0,0,0,.833.344l3.914-3.914a.48.48,0,0,0,0-.688Z" transform="translate(0 -27.408)" fill="#919fa3" />
        </svg>&nbsp;
        Поделиться статьей:
      </div>
      <div class="ya-share2" data-services="vkontakte,twitter,odnoklassniki,telegram"></div>
    </div>
  </div>
</div>
