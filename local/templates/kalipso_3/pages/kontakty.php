<?
$APPLICATION->SetTitle("Контакты КП “".$arVillage['NAME']."”");
$APPLICATION->SetPageProperty("title", "Телефон и адрес коттеджного поселка “".$arVillage['NAME']."”");
$APPLICATION->SetPageProperty("description", "Телефон офиса продаж ".$phone.", адрес поселка: ".$regionName." район, рядом с ".$arVillage['PROPERTY_SETTLEM_VALUE'].". Офис продаж: ".$arDevel[0]['UF_ADDRESS'].".");?>
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
    <div class="contacts row">
      <div class="col-lg-4">
        <div class="contacts__info" itemscope itemtype="http://schema.org/Organization">
          <meta itemprop="name" content="<?=$arVillage['NAME']?>">
          <div class="contacts-item" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"><strong>Адрес поселка:</strong>
            <p>Россия, Московская область, <span itemprop="addressLocality"><?=$regionName?> район</span><br><?=$arVillage['PROPERTY_SETTLEM_VALUE']?>, <span itemprop="streetAddress">коттеджный поселок <?=$arVillage['NAME']?></span></p>
          </div>
          <div class="contacts-item"><strong>Офис продаж:</strong>
            <p><?=$arDevel[0]['UF_ADDRESS']?><br><?=$arDevel[0]['UF_SCHEDULE']?></p>
          </div>
          <div class="contacts-item">
            <div class="mb-1">
              <a class="contacts-phone" href="tel:<?=str_replace(['','(',')','-'],'',$phone)?>" itemprop="telephone"><?=$phone?></a>
            </div>
            <a class="contacts-email" href="mailto:info@<?=SITE_SERVER_NAME?>" itemprop="email">info@<?=SITE_SERVER_NAME?></a>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <?$arCoordinates = explode(',',$arVillage['PROPERTY_COORDINATES_VALUE']);?>
        <div class="contacts-map" id="map" data-lon="<?=trim($arCoordinates[1])?>" data-lat="<?=trim($arCoordinates[0])?>"></div>
      </div>
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
