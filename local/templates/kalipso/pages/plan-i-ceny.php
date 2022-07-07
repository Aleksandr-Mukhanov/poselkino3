<?
$APPLICATION->SetTitle("План и цены в КП “".$arVillage['NAME']."”");
$APPLICATION->SetPageProperty("title", "План и цены участков в поселке “".$arVillage['NAME']."”");
$APPLICATION->SetPageProperty("description", "План и стоимость участков в коттеджном поселке “".$arVillage['NAME']."” на ".$shosseNameKom." шоссе. Сотка от ".formatPriceSite($arVillage['PROPERTY_PRICE_SOTKA_VALUE'][0])." руб, возможна рассрочка.");
// dump($arVillage);
$planIFrame = $arVillage['PROPERTY_PLAN_IMG_IFRAME_VALUE'];
$planIMG = CFile::GetPath($arVillage['PROPERTY_PLAN_IMG_VALUE']);
if ($planIFrame) $planIMG = $planIFrame;
$frame = ($planIFrame) ? 'data-iframe="true"' : '';
$planIMG_res = CFile::ResizeImageGet($arVillage['PROPERTY_PLAN_IMG_VALUE'], array('width'=>766, 'height'=>526), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);?>
<section class="page">
  <div class="container page__container">
    <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "kalipso", Array(
    	"COMPOSITE_FRAME_MODE" => "A",	// Голосование шаблона компонента по умолчанию
    		"COMPOSITE_FRAME_TYPE" => "AUTO",	// Содержимое компонента
    		"PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
    		"SITE_ID" => "v1",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
    		"START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
    	),
    	false
    );?>
    <h1 class="title--size_1 section-title page__title"><?$APPLICATION->ShowTitle(false);?></h1>
    <div class="card">
      <div class="row card__row">
        <div class="row__col-7 card__col-picture">
					<div class="card__picture">
						<a href="<?=$planIMG?>" data-fancybox <?=$frame?>>
							<picture>
								<source type="image/webp" srcset="<?=$planIMG_res['src']?>">
									<img src="<?=$planIMG_res['src']?>" alt="План и цены КП <?=$arVillage['NAME']?>" title="План и цены поселок <?=$arVillage['NAME']?>" loading="lazy" decoding="async">
							</picture></a>
          </div>
        </div>
        <div class="row__col-5 card__col-content">
          <div class="card__content">
            <div class="info-count card__info-count">
              <div class="row info-count__row">
                <div class="row__col-6 info-count__col">
                  <div class="info-count-item">
                    <div class="info-count-item__number"><?=$arVillage['PROPERTY_AREA_VIL_VALUE']?> Га</div>
                    <div class="info-count-item__description">Общая площадь поселка</div>
                  </div>
                </div>
                <div class="row__col-6 info-count__col">
                  <div class="info-count-item">
                    <div class="info-count-item__number"><?=$arVillage['PROPERTY_COUNT_PLOTS_VALUE']?></div>
                    <div class="info-count-item__description">Количество участков</div>
                  </div>
                </div>
                <div class="row__col-6 info-count__col">
                  <div class="info-count-item">
                    <div class="info-count-item__number"><?=$arVillage['PROPERTY_COUNT_PLOTS_SOLD_VALUE']?></div>
                    <div class="info-count-item__description">Участков продано</div>
                  </div>
                </div>
                <div class="row__col-6 info-count__col">
                  <div class="info-count-item">
                    <div class="info-count-item__number"><?=$arVillage['PROPERTY_COUNT_PLOTS_SALE_VALUE']?></div>
                    <div class="info-count-item__description">Участков в продаже</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="info-list card__info-list">
              <div class="info-list__line">
                <div class="info-list__description">
                  <div class="info-list__picture"><img class="info-list__icon" src="<?=SITE_TEMPLATE_PATH?>/images/icon/info-area.png" alt=""></div>
                  <div class="info-list__title">Площадь участков:</div>
                </div>
                <div class="info-list__text">от <?=$arVillage['PROPERTY_PLOTTAGE_VALUE'][0]?> до <?=$arVillage['PROPERTY_PLOTTAGE_VALUE'][1]?> соток</div>
              </div>
              <div class="info-list__line">
                <div class="info-list__description">
                  <div class="info-list__picture"><img class="info-list__icon" src="<?=SITE_TEMPLATE_PATH?>/images/icon/info-price.png" alt=""></div>
                  <div class="info-list__title">Стоимость участков:</div>
                </div>
                <div class="info-list__text">от <?=formatPriceSite($arVillage['PROPERTY_COST_LAND_IN_CART_VALUE'][0])?> ₽ до <?=formatPriceSite($arVillage['PROPERTY_COST_LAND_IN_CART_VALUE'][1])?> ₽</div>
              </div>
              <div class="info-list__line">
                <div class="info-list__description">
                  <div class="info-list__picture"><img class="info-list__icon" src="<?=SITE_TEMPLATE_PATH?>/images/icon/info-arrangement.png" alt=""></div>
                  <div class="info-list__title">Цена за обустройство:</div>
                </div>
                <div class="info-list__text"><?=$arVillage['PROPERTY_PRICE_ARRANGE_VALUE']?></div>
              </div>
              <div class="info-list__line">
                <div class="info-list__description">
                  <div class="info-list__picture"><img class="info-list__icon" src="<?=SITE_TEMPLATE_PATH?>/images/icon/info-installment.png" alt=""></div>
                  <div class="info-list__title">Доступна рассрочка:</div>
                </div>
                <div class="info-list__text"><?=$arVillage['PROPERTY_INS_TERMS_VALUE']?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- page END-->
<?require_once $mainUrl.'/include/sites/appeal-form.php';?>
<!-- text-block BEGIN-->
<section class="text-block">
  <div class="container text-block__container">
    <div class="content text-block__content">
      <a class="btn btn--theme_blue" href="/">На главную</a>
    </div>
  </div>
</section>
<!-- text-block END-->
