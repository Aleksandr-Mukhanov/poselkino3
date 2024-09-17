<?
$APPLICATION->SetTitle("Инфраструктура в КП “".$arVillage['NAME']."”");
$APPLICATION->SetPageProperty("title", "Инфраструктура коттеджного поселка “".$arVillage['NAME']."”");
$APPLICATION->SetPageProperty("description", "Инфраструктура и обустройство в поселке “".$arVillage['NAME']."”. Свет, газ, охрана, ".$roadsInName['WHAT']." в поселке. Рядом магазин, школа и ж/д станция.");?>
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
    <h1 class="title--size_1 section-title page__title infrastructure__title"><?$APPLICATION->ShowTitle(false);?></h1>
    <div class="content">
      <div class="text-block__content">
        <p><?=$arVillage['PROPERTY_LEND_TEXT_VALUE']['TEXT'] // Что надо знать??></p>
      </div>
      <div class="row infrastructure-list">
        <div class="col-lg-3 col-md-6">
          <div class="infrastructure-item">
            <div class="infrastructure-item__icon">
              <svg class="icon icon-light">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-light"></use>
              </svg>
            </div>
            <div class="infrastructure-item__name">Электроэнергия <br><?=$arVillage['PROPERTY_ELECTRO_KVT_VALUE']?> кВт на уч.</div>
          </div>
        </div>
        <?if($arVillage['PROPERTY_GAS_ENUM_ID'] == 15): // есть газ?>
          <div class="col-lg-3 col-md-6">
            <div class="infrastructure-item">
              <div class="infrastructure-item__icon">
                <svg class="icon icon-light">
                  <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-fire"></use>
                </svg>
              </div>
              <div class="infrastructure-item__name">Газ <br><?=$arVillage['PROPERTY_PROVEDEN_GAZ_VALUE']?></div>
            </div>
          </div>
  			<?endif;?>
        <?if($arVillage['PROPERTY_ART_WELLS_DEPTH_VALUE']):?>
          <div class="col-lg-3 col-md-6">
            <div class="infrastructure-item">
              <div class="infrastructure-item__icon">
                <svg class="icon icon-water">
                  <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-water"></use>
                </svg>
              </div>
              <div class="infrastructure-item__name">Водоснабжение от скважины глубиной <?=$arVillage['PROPERTY_ART_WELLS_DEPTH_VALUE']?>м</div>
            </div>
          </div>
        <?endif;?>
        <div class="col-lg-3 col-md-6">
          <div class="infrastructure-item">
            <div class="infrastructure-item__icon">
              <svg class="icon icon-shop">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-shop"></use>
              </svg>
            </div>
            <div class="infrastructure-item__name">Магазины, стройматериалы <br>на территории поселка</div>
          </div>
        </div>
        <?if(in_array('Охрана', $arVillage['PROPERTY_ARRANGE_VALUE'])): // Обустройство поселка: Охрана?>
        <div class="col-lg-3 col-md-6">
          <div class="infrastructure-item">
            <div class="infrastructure-item__icon">
              <svg class="icon icon-video">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-video"></use>
              </svg>
            </div>
            <div class="infrastructure-item__name">Безопасность — <br>охрана и КПП на въезде</div>
          </div>
        </div>
        <?endif;?>
        <div class="col-lg-3 col-md-6">
          <div class="infrastructure-item">
            <div class="infrastructure-item__icon">
              <svg class="icon icon-road">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-road"></use>
              </svg>
            </div>
            <div class="infrastructure-item__name"><?=$roadsToName['WHAT']?> <br>до поселка</div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="infrastructure-item">
            <div class="infrastructure-item__icon">
              <svg class="icon icon-road_02">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-road_02"></use>
              </svg>
            </div>
            <div class="infrastructure-item__name"><?=$roadsInName['WHAT']?> <br>в поселке</div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="infrastructure-item">
            <div class="infrastructure-item__icon">
              <svg class="icon icon-lake">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-lake"></use>
              </svg>
            </div>
            <div class="infrastructure-item__name">Водоем на расстоянии <br><?=$arVillage['PROPERTY_WATER_KM_VALUE']*1000?> метров</div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="infrastructure-item">
            <div class="infrastructure-item__icon">
              <svg class="icon icon-forest">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-forest"></use>
              </svg>
            </div>
            <div class="infrastructure-item__name">Лес на расстоянии <br><?=$arVillage['PROPERTY_FOREST_KM_VALUE']*1000?> метров</div>
          </div>
        </div>
        <!-- <div class="col-lg-3 col-md-6">
          <div class="infrastructure-item">
            <div class="infrastructure-item__icon">
              <svg class="icon icon-beach">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-beach"></use>
              </svg>
            </div>
            <div class="infrastructure-item__name">Пляж</div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="infrastructure-item">
            <div class="infrastructure-item__icon">
              <svg class="icon icon-school">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-school"></use>
              </svg>
            </div>
            <div class="infrastructure-item__name">Школа и детский сад</div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="infrastructure-item">
            <div class="infrastructure-item__icon">
              <svg class="icon icon-cafe">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-cafe"></use>
              </svg>
            </div>
            <div class="infrastructure-item__name">Кафе</div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="infrastructure-item">
            <div class="infrastructure-item__icon">
              <svg class="icon icon-church">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-church"></use>
              </svg>
            </div>
            <div class="infrastructure-item__name">Церковь</div>
          </div>
        </div> -->
      </div>
      <?//if($USER->IsAdmin()){?>
        <?if($arVillage['ON_TERRITORY']){?>
          <br><br>
          <h2>Что есть на территории поселка:</h2>
          <div class="row infrastructure-list">
            <?foreach ($arVillage['ON_TERRITORY'] as $code => $value) {?>
              <div class="col-lg-3 col-md-6">
                <div class="infrastructure-item">
                  <div class="infrastructure-item__icon on_territory">
                    <?=file_get_contents('https://poselkino.ru/assets/img/svg_sites/'.$code.'.svg');?>
                  </div>
                  <div class="infrastructure-item__name"><?=$value?></div>
                </div>
              </div>
            <?}?>
          </div>
        <?}?>
        <?if($arVillage['IN_RADIUS_5_KM']){?>
          <br><br>
          <h2>Что есть в радиусе 5 км:</h2>
          <div class="row infrastructure-list">
            <?foreach ($arVillage['IN_RADIUS_5_KM'] as $code => $value) {?>
              <div class="col-lg-3 col-md-6">
                <div class="infrastructure-item">
                  <div class="infrastructure-item__icon on_territory">
                    <?=file_get_contents('https://poselkino.ru/assets/img/svg_sites/'.$code.'.svg');?>
                  </div>
                  <div class="infrastructure-item__name"><?=$value?></div>
                </div>
              </div>
            <?}?>
          </div>
        <?}?>
      <?//}?>
    </div>
  </div>
</section>
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
