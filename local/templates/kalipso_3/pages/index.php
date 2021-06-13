<?
$APPLICATION->SetTitle($arVillage['NAME']);
$APPLICATION->SetPageProperty("title", "Коттеджный поселок ".$arVillage['NAME'].", ".$regionName." район - официальный сайт");
$APPLICATION->SetPageProperty("description", "Купить земельный участок в КП ".$arVillage['NAME']." от ".formatPriceSite($arVillage['PROPERTY_PRICE_SOTKA_VALUE'][0])." руб. за сотку. ".$shosseName." шоссе, ".$arVillage['PROPERTY_MKAD_VALUE']." км от МКАД. ИЖС, охрана, свет, газ, ".$regionName." район");
// узнаем отзывы
	$cntCom = 0;$ratingSum = 0;
	$arOrder = Array("ACTIVE_FROM"=>"DESC");
	$arFilter = Array("IBLOCK_ID"=>2,"ACTIVE"=>"Y","PROPERTY_VILLAGE"=>$villageID);
	$arSelect = Array("ID","ACTIVE_FROM","PREVIEW_TEXT","PROPERTY_RATING","PROPERTY_DIGNITIES","PROPERTY_DISADVANTAGES","PROPERTY_FIO","PROPERTY_RESIDENT");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,['nTopCount'=>4],$arSelect);
	while($arElement = $rsElements->GetNext()){ // dump($arElement);
		$cntCom++; // кол-во отзывов
		$arDateTime = explode(' ',$arElement["ACTIVE_FROM"]);
		$arDate = explode('.',$arDateTime[0]);
		$arTime = explode(':',$arDateTime[1]);
		// оценка
		$rating = ($arElement["PROPERTY_RATING_VALUE"]) ? $arElement["PROPERTY_RATING_VALUE"] : 4;
		$arComments[] = [
			"FIO" => $arElement["PROPERTY_FIO_VALUE"],
			"DATE" => $arDateTime[0].' '.$arTime[0].':'.$arTime[1],
			"DATE_SCHEMA" => $arDate[2].'-'.$arDate[1].'-'.$arDate[0],
			"RATING" => $rating,
			"DIGNITIES" => $arElement["PROPERTY_DIGNITIES_VALUE"],
			"DISADVANTAGES" => $arElement["PROPERTY_DISADVANTAGES_VALUE"],
			"TEXT" => $arElement["PREVIEW_TEXT"],
			"RESIDENT" => $arElement["PROPERTY_RESIDENT_VALUE"],
		];
	}
$showAddIcon = false; // показ доп. иконки
?>
<div class="advantages">
  <div class="container">
    <div class="row">
      <div class="col-lg col-md-6">
        <div class="infrastructure-item">
          <div class="infrastructure-item__icon">
            <svg class="icon icon-light">
              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-light"></use>
            </svg>
          </div>
          <div class="infrastructure-item__name">Электроэнергия <br><?=$arVillage['PROPERTY_ELECTRO_KVT_VALUE']?>&nbsp;кВт на&nbsp;уч.</div>
        </div>
      </div>
			<?if($arVillage['PROPERTY_GAS_ENUM_ID'] == 15): // есть газ?>
				<div class="col-lg col-md-6">
	        <div class="infrastructure-item">
	          <div class="infrastructure-item__icon">
	            <svg class="icon icon-light">
	              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-fire"></use>
	            </svg>
	          </div>
	          <div class="infrastructure-item__name">Газ <br><?=$arVillage['PROPERTY_PROVEDEN_GAZ_VALUE']?></div>
	        </div>
	      </div>
			<?else: $showAddIcon = true;?>
			<?endif;?>
			<?if($arVillage['PROPERTY_TYPE_USE_VALUE'] == 'Индвидуальное жилищное строительство'):?>
      <div class="col-lg col-md-6">
        <div class="infrastructure-item">
          <div class="infrastructure-item__icon">
            <svg class="icon icon-igs">
              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-igs"></use>
            </svg>
          </div>
          <div class="infrastructure-item__name"><?=$arVillage['PROPERTY_TYPE_USE_VALUE']?></div>
        </div>
      </div>
			<?else:?>
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
			<?endif;?>
			<?if(in_array('Охрана', $arVillage['PROPERTY_ARRANGE_VALUE'])): // Обустройство поселка: Охрана?>
	      <div class="col-lg col-md-6">
	        <div class="infrastructure-item">
	          <div class="infrastructure-item__icon">
	            <svg class="icon icon-video">
	              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-video"></use>
	            </svg>
	          </div>
	          <div class="infrastructure-item__name">Безопасность — <br>охрана и КПП на въезде</div>
	        </div>
	      </div>
			<?else: $showAddIcon = true;?>
			<?endif;?>
			<?if($showAddIcon): // доп иконка?>
				<div class="col-lg col-md-6">
	        <div class="infrastructure-item">
	          <div class="infrastructure-item__icon">
	            <svg class="icon icon-shop">
	              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-shop"></use>
	            </svg>
	          </div>
	          <div class="infrastructure-item__name">Инфраструктура — <br>магазины, стройматериалы</div>
	        </div>
	      </div>
			<?endif;?>
    </div>
  </div>
</div>
<section class="block_2">
  <div class="container">
    <h2 class="title--size_2 section-title page__title">"<?=$arVillage['NAME']?>" - поселок №1 для вашего выбора</h2>
    <div class="b2_card">
      <div class="row">
        <div class="col-xl-7 col-lg-6">
          <div class="b2_card__video">
            <picture>
              <?
              // if($arVillage['PROPERTY_SCRIN_EGRN_VALUE']){ // Скрин ЕГРН онлайн
      				// 	$egrnIMG_res = CFile::ResizeImageGet($arVillage['PROPERTY_SCRIN_EGRN_VALUE'], array('width'=>765, 'height'=>500), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
      				// 	$egrnIMG = CFile::GetPath($arVillage['PROPERTY_SCRIN_EGRN_VALUE']);
      				// }else{
      				// 	$egrnIMG_res['src'] = SITE_TEMPLATE_PATH.'/images/video_bg.jpg';
      				// }
              $egrnIMG_res = CFile::ResizeImageGet($arVillage['PREVIEW_PICTURE'], array('width'=>1000, 'height'=>1000), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
              ?>
              <source type="image/webp" srcset="<?=$egrnIMG_res['src']?>"><img src="<?=$egrnIMG_res['src']?>" title="Коттеджный поселок <?=$arVillage['NAME']?>" alt="Фото коттеджный поселок <?=$arVillage['NAME']?>" loading="lazy" decoding="async">
            </picture>
          </div>
        </div>
        <div class="col-xl-5 col-lg-6">
          <div class="b2_card__main">
            <h3>Юридическая информация</h3>
            <p>Категория земель: <strong><?=$arVillage['PROPERTY_LAND_CAT_VALUE'] // Категория земель?></strong></p>
            <p>Вид разрешенного использования: <strong><?=$arVillage['PROPERTY_TYPE_USE_VALUE'] // Вид разрешенного использования?></strong></p>
            <p>Юридическая форма: <strong><?=$arVillage['PROPERTY_LEGAL_FORM_VALUE'] // Юридическая форма?></strong></p>
            <p><a class="link" href="<?=$arVillage['PROPERTY_SRC_MAP_VALUE'] // Ссылка на публичную карту?>" target="_blank">Поселок на карте Росреестра</a></p>
            <a class="phone phone--b2" href="tel:<?=str_replace(['','(',')','-'],'',$phone)?>"><span class="icon-phone phone__icon"></span> <?=$phone?></a>
          </div>
        </div>
      </div>
    </div>
    <h2 class="title--size_2 section-title page__title">Фотографии КП “<?=$arVillage['NAME']?>”</h2>
  </div>
  <div class="object-slider">
    <div class="swiper-container">
      <div class="swiper-wrapper">
        <?foreach ($arVillage['PROPERTY_DOP_FOTO_VALUE'] as $key => $photo) { // dump($photo);
          $photoRes = CFile::ResizeImageGet($photo, array('width'=>2000, 'height'=>2000), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);?>
       	 <div class="swiper-slide"><img src="<?=$photoRes['src']?>" alt="Фото <?=$key+1?> поселок <?=$arVillage['NAME']?>" title="КП <?=$arVillage['NAME']?>" loading="lazy" decoding="async"></div>
        <?}?>
      </div>
    </div>
    <!-- Add Arrows-->
    <div class="object-slider-btns">
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>
  </div>
</section>
<section class="advantages advantages--2">
  <div class="container">
    <h2 class="advantages-title">Инфраструктура поселка “<?=$arVillage['NAME']?>”</h2>
    <div class="row infrastructure-list">
			<?if($arVillage['PROPERTY_GAS_ENUM_ID'] == 15): // есть газ?>
				<div class="col-lg-3 col-md-6">
	        <div class="infrastructure-item">
	          <div class="infrastructure-item__icon">
	            <svg class="icon icon-road">
	              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-fire"></use>
	            </svg>
	          </div>
	          <div class="infrastructure-item__name">Газ <br><?=$arVillage['PROPERTY_PROVEDEN_GAZ_VALUE']?></div>
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
			<?if($arVillage['PROPERTY_GAS_ENUM_ID'] != 15): // нет газа?>
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
			<?endif;?>
    </div>
    <div class="center"><a class="btn btn--large btn--theme_blue" href="/infrastruktura/">Вся инфраструктура</a></div>
  </div>
</section>
<section class="index-plan">
  <div class="container">
    <h2 class="title--size_2 section-title page__title">Планы и цены “<?=$arVillage['NAME']?>”</h2>
    <div class="card">
      <div class="row card__row">
        <div class="row__col-7 card__col-picture">
					<?
					$planIFrame = $arVillage['PROPERTY_PLAN_IMG_IFRAME_VALUE'];
					$planIMG = CFile::GetPath($arVillage['PROPERTY_PLAN_IMG_VALUE']);
					if ($planIFrame) $planIMG = $planIFrame;
					$frame = ($planIFrame) ? 'data-iframe="true"' : '';
					$planIMG_res = CFile::ResizeImageGet($arVillage['PROPERTY_PLAN_IMG_VALUE'], array('width'=>766, 'height'=>526), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
					?>
					<div class="card__picture">
						<a href="<?=$planIMG?>" data-fancybox <?=$frame?>>
							<picture>
								<source type="image/webp" srcset="<?=$planIMG_res['src']?>">
									<img src="<?=$planIMG_res['src']?>" alt="План и цены КП <?=$arVillage['NAME']?>" title="План и цены поселок <?=$arVillage['NAME']?>" loading="lazy" decoding="async">
							</picture></a></div>
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
            </div>
            <div class="d-none d-xl-block"><a class="btn btn--large btn--theme_blue" href="/plan-i-ceny/">План и цены</a></div>
          </div>
        </div>
      </div>
    </div>
    <div class="d-block d-xl-none">
      <div class="center"><a class="btn btn--large btn--theme_blue" href="/plan-i-ceny/">План и цены</a></div>
    </div>
  </div>
</section>
<?if($arVillage['PROPERTY_ON_SITE_VALUE']):?>
	<section class="text-block">
		<div class="container text-block__container">
			<div class="content text-block__content">
				<h2 class="section-title">Описание поселка “<?=$arVillage['NAME']?>”</h2>
				<p><?=$arVillage['PREVIEW_TEXT']?></p>
			</div>
		</div>
	</section>
<?endif?>
<?require_once $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/inc/appeal-form.php';?>
<section class="ecology-index">
  <div class="container">
    <h2 class="title--size_2 ecology__title page__title section-title">Экология и природа</h2>
    <div class="row">
      <div class="col-md-6 col-lg-3">
        <div class="ecology"><img src="<?=SITE_TEMPLATE_PATH?>/images/ecology-1.jpg" alt="">
          <div class="ecology__main">
            <div class="ecology__name">Лес</div>
            <div class="ecology__type"><?=$LES?></div>
            <div class="ecology__distance">расстояние <?=$arVillage['PROPERTY_FOREST_KM_VALUE']*1000?> м.</div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="ecology"><img src="<?=SITE_TEMPLATE_PATH?>/images/ecology-2.jpg" alt="">
          <div class="ecology__main">
            <div class="ecology__name">Ландшафт</div>
            <div class="ecology__type"><?=$landscape?></div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="ecology"><img src="<?=SITE_TEMPLATE_PATH?>/images/ecology-3.jpg" alt="">
          <div class="ecology__main">
            <div class="ecology__name">Водоем</div>
            <div class="ecology__type"><?=implode($arWater,', ')?></div>
            <div class="ecology__distance">расстояние <?=$arVillage['PROPERTY_WATER_KM_VALUE']*1000?> м.</div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="ecology"><img src="<?=SITE_TEMPLATE_PATH?>/images/ecology-4.jpg" alt="">
          <div class="ecology__main">
            <div class="ecology__name">Почва</div>
            <div class="ecology__type"><?=implode($arSoil,', ')?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="location">
  <div class="container">
    <h2 class="title--size_2 page__title">Удобное расположение</h2>
    <p>Поселок <?=$arVillage['NAME']?> находится по <?=$shosseNameKomu?> шоссе в <?=$arVillage['PROPERTY_MKAD_VALUE']?> км от МКАД. Добраться можно на собственном и общественном транспорте - есть возможность доехать на электричке. Транспортная доступность поселка, позволяет выбрать вам любой удобный транспорт</p>
    <?$arCoordinates = explode(',',$arVillage['PROPERTY_COORDINATES_VALUE']);?>
    <div class="location-map" id="map" data-lon="<?=trim($arCoordinates[1])?>" data-lat="<?=trim($arCoordinates[0])?>"></div>
    <div class="row mb-4">
      <div class="col-md-4">
        <div class="get_item">
          <div class="get_item__icon">
            <svg class="icon icon-car">
              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-car"> </use>
            </svg>
          </div>
          <div class="get_item__content">
            <div class="get_item__title">На автомобиле <?=$arVillage['PROPERTY_AUTO_NO_JAMS_VALUE'] // Авто (Время в пути от МКАД без пробок)?></div>
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
            <div class="get_item__title">На электричке <?=$arVillage['PROPERTY_TRAIN_TRAVEL_TIME_VALUE'] // Электричка (время в пути)?></div>
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
            <div class="get_item__title">На автобусе, <?$BUS_TIME_KM = $arVillage['PROPERTY_BUS_TIME_KM_VALUE'];?><?=($BUS_TIME_KM < 1) ? ($BUS_TIME_KM*1000).' м' : $BUS_TIME_KM.' км' // Автобус (расстояние от остановки, км)?> от остановки</div>
          </div>
        </div>
      </div>
    </div>
    <div class="center"><a class="btn btn--large btn--theme_blue" href="/na-karte/">Как добраться</a></div>
  </div>
</section>
<section class="reviews-index">
  <div class="container">
    <h2 class="title--size_2 page__title section-title">Отзывы о поселке “<?=$arVillage['NAME']?>”</h2>
    <div class="row mb-3 row--reviews">
      <?foreach ($arComments as $comment) {?>
        <div class="col-xl-4 col-md-6">
          <div class="review">
            <div class="review__header">
              <div class="review__avatar">
                <svg class="icon icon-user">
                  <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#icon-user"></use>
                </svg>
              </div>
              <div class="review__info">
                <div class="review__name"><?=$comment["FIO"]?>
                  <div class="review__appraisal"><?=$comment["RATING"]?></div>
                </div>
                <div class="review__date"><?=$comment["DATE"]?></div>
              </div>
            </div>
            <div class="review__desc">
              <div class="review__text">
                <div class="review__status success">Достоинства:</div>
                <p><?=$comment["DIGNITIES"]?></p>
              </div>
              <div class="review__text">
                <div class="review__status warning">Недостатки:</div>
                <p><?=$comment["DISADVANTAGES"]?></p>
              </div>
              <div class="review__text">
                <div class="review__status">Отзыв:</div>
                <p><?=$comment["TEXT"]?></p>
              </div>
            </div>
            <!-- <div class="review__source">Источник отзыва: <a href="https://poselkino.ru/poselki/<?=$arVillage['CODE']?>/" rel="dofollow" target="_blank">poselkino.ru</a></div> -->
						<div class="review__source">Источник отзыва: poselkino.ru</div>
          </div>
        </div>
      <?}?>
    </div>
    <div class="center"><a class="btn btn--large btn--theme_blue" href="/otzyvy/">Все отзывы</a></div>
  </div>
</section>
<?require_once $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/inc/appeal-form-footer.php';?>
