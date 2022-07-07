<?
$APPLICATION->SetTitle("Как добраться до КП “".$arVillage['NAME']."”");
$APPLICATION->SetPageProperty("title", "Коттеджный поселок “".$arVillage['NAME']."” на карте");
$APPLICATION->SetPageProperty("description", "Как добраться в поселок “".$arVillage['NAME']."” автомобилем или общественным транспортом? Сколько ехать до поселка на автобусе или электричке?");?>
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
    <h1 class="title--size_1 section-title page__title get_there__title"><?$APPLICATION->ShowTitle(false);?></h1>
    <div class="get_there">
      <div class="get_there__main">
        <div class="row">
          <div class="col-lg-11">
            <p>Поселок <?=$arVillage['NAME']?> находится по <?=$shosseNameKomu?> шоссе в <?=$arVillage['PROPERTY_MKAD_VALUE']?> км от МКАД. Добраться можно на собственном и общественном транспорте - есть возможность доехать на электричке. Транспортная доступность поселка, позволяет выбрать вам любой удобный транспорт</p>
          </div>
        </div>
      </div>
      <div class="get_there__card">
        <div class="row">
          <div class="col-xl-7 get_there__map">
            <div class="card__picture">
              <?$arCoordinates = explode(',',$arVillage['PROPERTY_COORDINATES_VALUE']);?>
              <div class="get-map" id="map" data-lon="<?=trim($arCoordinates[1])?>" data-lat="<?=trim($arCoordinates[0])?>"></div>
            </div>
          </div>
          <div class="col-xl-5">
            <div class="get_there-list">
              <div class="row">
                <div class="col-md-6">
                  <div class="get_there_item">
                    <div class="get_there_item__icon">
                      <svg class="icon icon-001">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-001">     </use>
                      </svg>
                    </div>
                    <div class="get_there_item__desc"><?=$arVillage['PROPERTY_MKAD_VALUE']?> км. от МКАД</div>
                    <div class="get_there_item__main"><?=$shosseName?> шоссе</div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="get_there_item">
                    <div class="get_there_item__icon">
                      <svg class="icon icon-002">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-002">     </use>
                      </svg>
                    </div>
                    <div class="get_there_item__desc">Ближайший населенный пункт:</div>
                    <div class="get_there_item__main"><?=$arVillage['PROPERTY_SETTLEM_VALUE'] // Ближайший населенный пункт?>. Расстояние <?$SETTLEM_KM = $arVillage['PROPERTY_SETTLEM_KM_VALUE'];?><?=($SETTLEM_KM < 1) ? ($SETTLEM_KM*1000).' м' : $SETTLEM_KM.' км' // Ближайший населенный пункт расстояние, км?></div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="get_there_item">
                    <div class="get_there_item__icon">
                      <svg class="icon icon-003">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-003">     </use>
                      </svg>
                    </div>
                    <div class="get_there_item__desc">Ближайший город:</div>
                    <div class="get_there_item__main"><?=$arVillage['PROPERTY_TOWN_VALUE'] // Ближайший город?>. Расстояние <?$TOWN_KM = $arVillage['PROPERTY_TOWN_KM_VALUE'];?><?=($TOWN_KM < 1) ? ($TOWN_KM*1000).' м' : $TOWN_KM.' км' // Ближайший город расстояние, км?></div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="get_there_item">
                    <div class="get_there_item__icon">
                      <svg class="icon icon-004">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-004">     </use>
                      </svg>
                    </div>
                    <div class="get_there_item__desc">Ближайшая ж/д станция:</div>
                    <div class="get_there_item__main"><?=$arVillage['PROPERTY_RAILWAY_VALUE'] // Ближайший ж/д станция?>. Расстояние до станции <?$RAILWAY_KM = $arVillage['PROPERTY_RAILWAY_KM_VALUE'];?><?=($RAILWAY_KM < 1) ? ($RAILWAY_KM*1000).' м' : $RAILWAY_KM.' км' //Ближайшая ж/д станция расстояние до поселка, км?></div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="get_there_item">
                    <div class="get_there_item__icon">
                      <svg class="icon icon-005">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-005">     </use>
                      </svg>
                    </div>
                    <div class="get_there_item__desc">Координаты поселка:</div>
                    <div class="get_there_item__main" id="coordMap"><?=$arVillage['PROPERTY_COORDINATES_VALUE'] // Координаты поселка?></div>
                  </div>
                </div>
              </div><a class="btn btn--large btn--theme_blue" id="bildRoute" href="">Построить маршрут</a>
            </div>
          </div>
        </div>
      </div>
      <div class="get_there__listing">
        <h2 class="content__sub-title">Легко добраться</h2>
        <div class="row">
          <div class="col-md-4">
            <div class="get_item">
              <div class="get_item__icon">
                <svg class="icon icon-car">
                  <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-car"> </use>
                </svg>
              </div>
              <div class="get_item__content">
                <div class="get_item__title">На автомобиле <?=$arVillage['PROPERTY_AUTO_NO_JAMS_VALUE'] // Авто (Время в пути от МКАД без пробок)?></div>
                <div class="get_item__desc">
                  <p>от МКАДа без пробок</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="get_item">
              <div class="get_item__icon">
                <svg class="icon icon-train">
                  <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-train"> </use>
                </svg>
              </div>
              <div class="get_item__content">
                <?
          				$trainIdYandex = $arVillage['PROPERTY_TRAIN_ID_YANDEX_VALUE']; // Электричка (ID станции прибытия)
          			?>
                <div class="get_item__title">На электричке <?=$arVillage['PROPERTY_TRAIN_TRAVEL_TIME_VALUE'] // Электричка (время в пути)?></div>
                <div class="get_item__desc">
                  <p>от вокзала: <?=$arVillage['PROPERTY_TRAIN_VOKZAL_VALUE'] // Электричка (вокзал)?></p>
                  <p>Стоимость одного проезда:  <strong><?=$arVillage['PROPERTY_TRAIN_PRICE_VALUE'] // Электричка (стоимость проезда)?> ₽</strong></p>
                  <p>Стоимость такси: <strong><?=$arVillage['PROPERTY_TRAIN_PRICE_TAXI_VALUE'] // Электричка (стоимость такси)?> ₽</strong></p><a class="link" target="_blank" href="https://rasp.yandex.ru/station/<?=$trainIdYandex?>?span=day&type=suburban&event=departure">Посмотреть расписание</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="get_item">
              <div class="get_item__icon">
                <svg class="icon icon-bus">
                  <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-bus"> </use>
                </svg>
              </div>
              <div class="get_item__content">
                <div class="get_item__title">На автобусе</div>
                <div class="get_item__desc">
                  <p>ст. отправления <?=$arVillage['PROPERTY_BUS_VOKZAL_VALUE']; // Автобус (вокзал)?>, <br><?$BUS_TIME_KM = $arVillage['PROPERTY_BUS_TIME_KM_VALUE'];?><?=($BUS_TIME_KM < 1) ? ($BUS_TIME_KM*1000).' м' : $BUS_TIME_KM.' км' // Автобус (расстояние от остановки, км)?> от остановки</p>
                </div>
              </div>
            </div>
          </div>
        </div>
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
