<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Grid\Declension;

$this->setFrameMode(true);

$templateLibrary = array('popup', 'fx');

// формируем имя
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
	: $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
	: $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
	: $arResult['NAME'];

// добавим превьюшку в фото
if($arResult["PREVIEW_PICTURE"]){
	array_unshift($arResult['MORE_PHOTO'],$arResult["PREVIEW_PICTURE"]); // положим в начало
} //dump($arResult['MORE_PHOTO']);

// ссылка на ютуб Видеосъемка
$arVideo = explode('https://youtu.be/',$arResult['PROPERTIES']['VIDEO']['VALUE']); //dump($arVideo);
$arResult['PROPERTIES']['VIDEO']['CODE_YB'] = $arVideo[1];

// объекты на тер. и в радиусе 5 км
if (strtolower($arResult['PROPERTIES']['MAGAZIN']['VALUE']) == 'в поселке') $inTer['shop']='Магазин';
elseif(strtolower($arResult['PROPERTIES']['MAGAZIN']['VALUE']) == 'в радиусе 5км') $rad5km['shop']='Магазин';
if (strtolower($arResult['PROPERTIES']['APTEKA']['VALUE']) == 'в поселке') $inTer['pharmacy']='Аптека';
elseif(strtolower($arResult['PROPERTIES']['APTEKA']['VALUE']) == 'в радиусе 5км') $rad5km['pharmacy']='Аптека';
if (strtolower($arResult['PROPERTIES']['CERKOV']['VALUE']) == 'в поселке') $inTer['temple']='Церковь';
elseif(strtolower($arResult['PROPERTIES']['CERKOV']['VALUE']) == 'в радиусе 5км') $rad5km['temple']='Церковь';
if (strtolower($arResult['PROPERTIES']['SHKOLA']['VALUE']) == 'в поселке') $inTer['school']='Школа';
elseif(strtolower($arResult['PROPERTIES']['SHKOLA']['VALUE']) == 'в радиусе 5км') $rad5km['school']='Школа';
if (strtolower($arResult['PROPERTIES']['DETSAD']['VALUE']) == 'в поселке') $inTer['kindergarten']='Дет.сад';
elseif(strtolower($arResult['PROPERTIES']['DETSAD']['VALUE']) == 'в радиусе 5км') $rad5km['kindergarten']='Дет.сад';
if (strtolower($arResult['PROPERTIES']['STROYMATERIALI']['VALUE']) == 'в поселке') $inTer['shop_building']='Строймат.';
elseif(strtolower($arResult['PROPERTIES']['STROYMATERIALI']['VALUE']) == 'в радиусе 5км') $rad5km['shop_building']='Строймат.';
if (strtolower($arResult['PROPERTIES']['CAFE']['VALUE']) == 'в поселке') $inTer['cafe']='Кафе';
elseif(strtolower($arResult['PROPERTIES']['CAFE']['VALUE']) == 'в радиусе 5км') $rad5km['cafe']='Кафе';
if (strtolower($arResult['PROPERTIES']['AVTOZAPRAVKA']['VALUE']) == 'в поселке') $inTer['gas']='АЗС';
elseif(strtolower($arResult['PROPERTIES']['AVTOZAPRAVKA']['VALUE']) == 'в радиусе 5км') $rad5km['gas']='АЗС';
// dump($inTer); dump($rad5km);

// водный знак
$arWaterMark = [
	[
		"name" => "watermark",
		"position" => "bottomright", // Положение
		"type" => "image",
		//"size" => "medium",
		"coefficient" => 3,
		"file" => $_SERVER["DOCUMENT_ROOT"].'/upload/water_sign.png', // Путь к картинке
		"fill" => "resize",
	]
];
foreach ($arResult['MORE_PHOTO'] as $key => $photo){
	 $photoRes = CFile::ResizeImageGet($photo['ID'], array('width'=>3000, 'height'=>3000), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true, $arWaterMark);
	 //dump($photoRes);
	 $arResult['MORE_PHOTO'][$key]['SRC'] = $photoRes['src'];
	 unset($photoRes);
}

// отображение по Наличию домов
$housesValEnum = $arResult['PROPERTIES']['DOMA']['VALUE_ENUM_ID'];

switch ($arResult['PROPERTIES']['TYPE']['VALUE_ENUM_ID']) { // название по типу
	case 1:
			$typePos = "дачном поселке"; break;
	case 2:
			$typePos = "коттеджном поселке"; break;
	case 171:
			$typePos = "фермерстве"; break;
}

$LES = $arResult['PROPERTIES']['LES']['VALUE']; // Лес
$FOREST_KM = $arResult['PROPERTIES']['FOREST_KM']['VALUE']; // Лес расстояние, км

// выводим водоемы
$arWater = $arResult['PROPERTIES']['WATER']['VALUE']; // Водоем
foreach($arWater as $water){
	$strWater .= ($strWater) ? ', '.$water : $water;
}
// выводим почву
$arSoil = $arResult['PROPERTIES']['SOIL']['VALUE']; // Почва
foreach($arSoil as $soil){
	$strSoil .= ($strSoil) ? ', '.$soil : $soil;
}

// км от МКАД
$km_MKAD = $arResult['PROPERTIES']['MKAD']['VALUE'];
switch ($km_MKAD) {
	case $km_MKAD <= 10: $url_km_MKAD = "do-10-km-ot-mkad"; break;
	case $km_MKAD <= 15: $url_km_MKAD = "do-15-km-ot-mkad"; break;
	case $km_MKAD <= 20: $url_km_MKAD = "do-20-km-ot-mkad"; break;
	case $km_MKAD <= 25: $url_km_MKAD = "do-25-km-ot-mkad"; break;
	case $km_MKAD <= 30: $url_km_MKAD = "do-30-km-ot-mkad"; break;
	case $km_MKAD <= 35: $url_km_MKAD = "do-35-km-ot-mkad"; break;
	case $km_MKAD <= 40: $url_km_MKAD = "do-40-km-ot-mkad"; break;
	case $km_MKAD <= 45: $url_km_MKAD = "do-45-km-ot-mkad"; break;
	case $km_MKAD <= 50: $url_km_MKAD = "do-50-km-ot-mkad"; break;
	case $km_MKAD <= 55: $url_km_MKAD = "do-55-km-ot-mkad"; break;
	case $km_MKAD <= 60: $url_km_MKAD = "do-60-km-ot-mkad"; break;
	case $km_MKAD <= 65: $url_km_MKAD = "do-65-km-ot-mkad"; break;
	case $km_MKAD <= 70: $url_km_MKAD = "do-70-km-ot-mkad"; break;
	case $km_MKAD <= 75: $url_km_MKAD = "do-75-km-ot-mkad"; break;
	case $km_MKAD <= 80: $url_km_MKAD = "do-80-km-ot-mkad"; break;

	default: $url_km_MKAD = "do-80-km-ot-mkad"; break;
} // echo $url_km_MKAD;

// объекты экологии
	// склады
	$STORAGE_KM = $arResult['PROPERTIES']['STORAGE_KM']['VALUE'];
	$storage = (strtolower($arResult['PROPERTIES']['STORAGE']['VALUE']) == 'есть') ? true : false;
	// Промзона
	$INDUSTRIAL_ZONE_KM = $arResult['PROPERTIES']['INDUSTRIAL_ZONE_KM']['VALUE'];
	$industrialZone = (strtolower($arResult['PROPERTIES']['INDUSTRIAL_ZONE']['VALUE']) != 'нет' && $INDUSTRIAL_ZONE_KM <= 1) ? true : false;
	// Полигон ТБО
	$LANDFILL_KM = $arResult['PROPERTIES']['LANDFILL_KM']['VALUE'];
	$landfill = (strtolower($arResult['PROPERTIES']['LANDFILL']['VALUE']) == 'есть' && $LANDFILL_KM <= 3) ? true : false;

	$nameVil = $arResult['PROPERTIES']['TYPE']['VALUE'].' '.$name; // тип поселка

	if($housesValEnum == 3){ // Только участки
		$priceSotka = 'Сотка от <span class="split-number">'.formatPrice($arResult['PROPERTIES']['PRICE_SOTKA']['VALUE'][0]).'</span> <span class="rep_rubl">руб.</span>';
	}elseif($housesValEnum == 4 || $housesValEnum == 256){ // Участки с домами
		$priceSotka = 'Дом от <span class="split-number">'.formatPrice($arResult['PROPERTIES']['HOME_VALUE']['VALUE'][0]).'</span> <span class="rep_rubl">руб.</span>';
	}

	// выводим правильные окончания
	// отзывы
	$reviewsDeclension = new Declension('отзыв', 'отзыва', 'отзывов');
	$reviewsText = $reviewsDeclension->get($arResult['CNT_COMMENTS']);
	// просмотр
	$cntPos = $arResult['PROPERTIES']['UP_TO_VIEW']['VALUE'] + 1;
	$ourDeclension = new Declension('человек', 'человека', 'человек');
	$correctText = $ourDeclension->get($cntPos);

	// dump($_COOKIE); // разбираем куки
	if(isset($_COOKIE['comparison_vil'])){
		$arComparison = explode('-',$_COOKIE['comparison_vil']);
	}
	if(isset($_COOKIE['favorites_vil'])){
		$arFavorites = explode('-',$_COOKIE['favorites_vil']);
	}
	$comparison = (in_array($arResult['ID'],$arComparison)) ? 'Y' : 'N';
	$favorites = (in_array($arResult['ID'],$arFavorites)) ? 'Y' : 'N';
	$comp_active = ($comparison == 'Y') ? 'active' : '';
	$fav_active = ($favorites == 'Y') ? 'active' : '';
	$comp_text = ($comparison != 'Y') ? 'Добавить к сравнению' : 'Удалить из сравнения';
	$fav_text = ($favorites != 'Y') ? 'Добавить в избранное' : 'Удалить из избранного';

	$chainItem = ($_REQUEST['OFFER_TYPE'] == 'plots') ? 'Участки' : 'Дома';
	$APPLICATION->AddChainItem($nameVil,"/poselki/".$arResult['CODE']."/",true);
	$APPLICATION->AddChainItem('Отзывы',"",true);
// dump($arResult);?>

	<div class="container mt-md-5">
		<div class="row">
			<div class="order-0 col-12 d-md-none">
				<div class="page-title">
					<h1 class="h2">Отзывы о поселке <?=$name?><?=$arResult["TITLE_DOP"]?></h1>
				</div>
			</div>
			<div class="order-2 order-md-1 col-md-6">
				<div class="page-title d-none d-md-block">
					<h1 class="h2">Отзывы о поселке <?=$name?><?=$arResult["TITLE_DOP"]?></h1>
					<div class="wrap-raiting mt-4">
						<div class="card-house__raiting d-flex">
							<div class="line-raiting">
								<div class="line-raiting__star">
									<div class="line-raiting__star--wrap" style="width: <?= $arResult['ratingItogo'] * 100 / 5 ?>%;"></div>
								</div>
								<div class="line-raiting__title"><?=$arResult['ratingItogo']?></div>
							</div>
						</div>
						<div class="card-house__review review">
							<div class="d-flex justify-content-start text-left"><a href="/poselki/<?=$arResult['CODE']?>/#block_reviews">
								<svg xmlns="http://www.w3.org/2000/svg" width="18.455" height="15.821" viewBox="0 0 18.455 15.821" class="inline-svg">
									<g transform="translate(0 -36.507)">
										<path d="M17.22 39.787a8.348 8.348 0 0 0-3.357-2.4 11.972 11.972 0 0 0-4.634-.881 12.246 12.246 0 0 0-3.584.52A10.023 10.023 0 0 0 2.7 38.433a7.025 7.025 0 0 0-1.969 2.106A4.905 4.905 0 0 0 0 43.1a5 5 0 0 0 .932 2.894 7.562 7.562 0 0 0 2.549 2.266 6.546 6.546 0 0 1-.268.782q-.154.371-.278.608a4.184 4.184 0 0 1-.335.525q-.211.288-.319.407l-.355.391q-.247.273-.319.355a.72.72 0 0 0-.082.093l-.072.087-.063.092q-.052.077-.046.1a.274.274 0 0 1-.021.1.136.136 0 0 0 .005.124v.01a.518.518 0 0 0 .18.3.4.4 0 0 0 .314.092A7.73 7.73 0 0 0 3 52.1a11.256 11.256 0 0 0 4.737-2.492 14.09 14.09 0 0 0 1.493.082 11.968 11.968 0 0 0 4.634-.881 8.347 8.347 0 0 0 3.357-2.4 5.053 5.053 0 0 0 0-6.622z"
											class="cls-2" data-name="Path 7" />
									</g>
								</svg><?if($arResult["CNT_COMMENTS"]){?>
									<?=$arResult["CNT_COMMENTS"]?> <?=$reviewsText?> от жителей
								<?}else{?>
									Пока нет отзывов
								<?}?></a></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-6">
						<?if($arResult['PROPERTIES']['REGION']['VALUE']):?>
						<a class="area-link" href="/poselki/<?=$arResult['PROPERTIES']['REGION']['VALUE_XML_ID']?>-rayon/">
							<svg xmlns="http://www.w3.org/2000/svg" width="9.24" height="13.193" viewBox="0 0 9.24 13.193" class="inline-svg">
								<path d="M16.09 1.353a4.62 4.62 0 0 0-6.534 0 5.263 5.263 0 0 0-.435 6.494l3.7 5.346 3.7-5.339a5.265 5.265 0 0 0-.431-6.501zm-3.224 4.912a1.687 1.687 0 1 1 1.687-1.687 1.689 1.689 0 0 1-1.687 1.687z" transform="translate(-8.203)" />
							</svg><?=$arResult['PROPERTIES']['REGION']['VALUE'] // Район?> р-н, <?=$arResult['PROPERTIES']['SETTLEM']['VALUE'] // Ближайший населенный пункт?></a>
						<?endif;?>
						<div class="metro d-flex flex-wrap">
							<?if($arResult['PROPERTIES']['SHOSSE']['VALUE_ENUM_ID'][0]): // если есть шоссе
								$idEnumHW = $arResult['PROPERTIES']['SHOSSE']['VALUE_ENUM_ID'][0];
								$valEnumHW = $arResult['PROPERTIES']['SHOSSE']['VALUE_XML_ID'][0];
								$colorHW = getColorRoad($idEnumHW);
								$nameHW = $arResult['PROPERTIES']['SHOSSE']['VALUE'][0];
							?>
							<a class="highway-color" href="/poselki/<?=$valEnumHW?>-shosse/">
								<span class="metro-color <?=$colorHW?>"></span>
								<span class="metro-name"><?=$nameHW?> шоссе</span>
							</a>
							<?endif;?>
						</div>
						<a class="metro-other" href="/poselki/<?=$url_km_MKAD?>/"><?=$km_MKAD?> км от МКАД</a>
					</div>
					<div class="col-xl-6">
						<div class="card-house__inline d-flex">
							<div class="icon"><img class="rub mr-3" src="/assets/img/site/house-plan.svg" alt></div>
							<div class="card-house__inline-title">
								Площадь участков:&nbsp;</div>
							<div class="card-house__inline-value">от <?=$arResult['PROPERTIES']['PLOTTAGE']['VALUE'][0]?> до <?=$arResult['PROPERTIES']['PLOTTAGE']['VALUE'][1]?> соток</div>
						</div>
						<?if($housesValEnum != 3){ // Участки с домами ?>
							<div class="card-house__inline d-flex">
								<div class="icon"><img class="mr-3" src="/assets/img/site/house-plan.svg" alt></div>
								<div class="card-house__inline-title">
									Площадь домов:&nbsp;</div>
								<div class="card-house__inline-value">от <?=$arResult['PROPERTIES']['HOUSE_AREA']['VALUE'][0]?> до <?=$arResult['PROPERTIES']['HOUSE_AREA']['VALUE'][1]?> м<sup>2</sup></div>
							</div>
						<?}?>
					</div>
					<div class="col-xl-6">
						<div class="va-list-value">
							<div class="va-list-value__item">Всего участков: <?=$arResult['PROPERTIES']['COUNT_PLOTS']['VALUE'] // Количество участков, ед.?></div>
							<div class="va-list-value__item">Участков в продаже: <?=$arResult['PROPERTIES']['COUNT_PLOTS_SALE']['VALUE'] // Количество участков в продаже, ед. ?></div>
							<div class="va-list-value__item">Продано: <?=$arResult['PROPERTIES']['COUNT_PLOTS_SOLD']['VALUE'] // Количество проданных участков, ед.?></div>
						</div>
					</div>
				</div>
			</div>
			<div class="order-1 order-md-2 col-md-6">
				<div class="village-slider">
					<div class="slider__header">
						<?if($arResult['PROPERTIES']['ACTION']['VALUE']){ // вывод акции?>
							<div class="slider__label">Акция<?if($arResult['PROPERTIES']['SALE_SUM']['VALUE']){?> - <?=$arResult['PROPERTIES']['SALE_SUM']['VALUE']?>%<?}?></div>
						<?}?>
						<div class="photo__buttons">
							<button title="<?=$comp_text?>" class="comparison-click <?=$comp_active?>" data-id="<?=$arResult['ID']?>">
								<svg xmlns="http://www.w3.org/2000/svg" width="19.42" height="17.556" viewBox="0 0 19.42 17.556" class="inline-svg add-comparison">
									<g transform="translate(-1216.699 -36.35)">
										<path d="M0 0v16.139" class="s-1" transform="translate(1217.349 37)" />
										<path d="M0 0v8.468" class="s-1" transform="translate(1233.321 37)" />
										<g transform="translate(.586 .586)">
											<path d="M0 0v4.297" class="s-2" transform="translate(1232.735 48)" />
											<path d="M0 0v4.297" class="s-2" transform="rotate(90 592.368 642.516)" />
										</g>
										<path d="M0 0v13.215" class="s-1" transform="translate(1222.807 40.041)" />
										<path d="M0 0v7.641" class="s-1" transform="translate(1228.265 45.499)" />
									</g>
								</svg>
							</button>
							<button title="<?=$fav_text?>" class="favorites-click <?=$fav_active?>" data-id="<?=$arResult['ID']?>">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="21" viewBox="0 0 24 21" class="inline-svg add-heart">
									<g transform="translate(.05 -26.655)">
										<path d="M19.874 30.266a5.986 5.986 0 0 0-8.466 0l-.591.591-.6-.6a5.981 5.981 0 0 0-8.466-.009 5.981 5.981 0 0 0 .009 8.466l8.608 8.608a.614.614 0 0 0 .871 0l8.626-8.594a6 6 0 0 0 .009-8.47zm-.88 7.595L10.8 46.019l-8.169-8.172a4.745 4.745 0 1 1 6.71-6.71l1.036 1.036a.617.617 0 0 0 .875 0l1.027-1.027a4.748 4.748 0 0 1 6.715 6.715z" class="s-1" />
										<circle cx="4.5" cy="4.5" r="4.5" class="s-2" transform="translate(14.96 26.655)" />
										<g transform="translate(-1213.44 -18.727)">
											<path d="M0 0v4.297" class="s-3" transform="translate(1232.735 48)" />
											<path d="M0 0v4.297" class="s-3" transform="rotate(90 592.368 642.516)" />
										</g>
									</g>
								</svg>
							</button>
						</div>
					</div>
					<div class="village-slider__list" id="village-slider">
						<?foreach ($arResult['MORE_PHOTO'] as $key => $photo){ // Основные фото
						  $photoRes = CFile::ResizeImageGet($photo['ID'], array('width'=>1232, 'height'=>872), BX_RESIZE_IMAGE_EXACT);?>
							<div class="village-slider__item" style="background: #eee url('<?=$photoRes['src']?>') no-repeat; background-size: cover;"></div>
						<?unset($photoRes);}?>
					</div>
					<div class="village-slider__list-thumb" id="village-slider-thumb">
						<?foreach ($arResult['MORE_PHOTO'] as $key => $photo){ // Доп. фото
						  $photoRes = CFile::ResizeImageGet($photo['ID'], array('width'=>1232, 'height'=>872), BX_RESIZE_IMAGE_EXACT);?>
							<div class="village-slider__item-thumb" style="background: url('<?=$photoRes['src']?>') no-repeat; background-size: cover;" itemprop="image"></div>
					  <?unset($photoRes);}?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> <!-- bg-white -->
<div class="bg-white py-md-4 py-2" id="block_reviews">
	<div class="review-list">
		<div class="container">
			<div class="row mb-4">
				<div class="col-xl-9 col-md-8">
					<h3 class="h2">
						Отзывы&nbsp;<span class="text-secondary"><?=$arResult["CNT_COMMENTS"]?></span></h3>
				</div>
				<div class="col-xl-3 col-md-4 justify-content-end">
					<div class="review-list__average-rating text-left text-md-right">Средняя оценка пользователей:</div>
					<div class="wrap-raiting">
						<div class="card-house__raiting d-flex justify-content-md-end">
							<div class="line-raiting">
								<div class="line-raiting__star">
									<div class="line-raiting__star--wrap" style="width: <?=$arResult['RATING_TOTAL'] * 100 / 5; ?>%;"></div>
								</div>
								<div class="line-raiting__title"><?=$arResult["RATING_TOTAL"]?></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<ul class="nav nav-tabs" id="reviewList" role="tablist">
				<li class="nav-item"><a class="nav-link active" id="allReviews-tab" data-toggle="tab" href="#allReviews" role="tab" aria-controls="allReviews" aria-selected="true">Все отзывы</a></li>
				<li class="nav-item"><a class="nav-link" id="residentReviews-tab" data-toggle="tab" href="#residentReviews" role="tab" aria-controls="residentReviews" aria-selected="false">Отзывы жителей</a></li>
			</ul>
			<div class="tab-content" id="reviewListContent">
				<div class="tab-pane fade show active" id="allReviews" role="tabpanel" aria-labelledby="allReviews-tab">
					<div class="row">
						<?
						if (!$arResult["COMMENTS"]) echo '<div class="col-12"><h3>Пока здесь нет ни одного отзыва, Вы можете быть первым!</h3></div>';
						// выводим отзывы
						foreach($arResult["COMMENTS"] as $comment){
							$marker = ($comment["RESIDENT"]) ? true : false; // отзыв от жителя
						?>
						<div class="col-md-6">
							<div class="review-card" itemprop="review" itemscope itemtype="http://schema.org/Review">
								<meta itemprop="itemReviewed" content="о поселке <?=$arResult['name']?>">
								<div class="review-card__user">
									<div class="review-card__user-avatar"></div>
									<div class="name" itemprop="author"><?=$comment["FIO"]?></div>
									<div class="date" itemprop="datePublished" content="<?=$comment["DATE_SCHEMA"]?>>"><?if($marker)echo'Житель, '?><?=$comment["DATE"]?></div>
									<div class="review-star">
										<div class="line-raiting" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
											<div class="line-raiting__star">
												<div class="line-raiting__star--wrap" style="width: <?=$comment['RATING'] * 100 / 5; ?>%;"></div>
											</div>
											<div class="line-raiting__title" itemprop="ratingValue"><?=$comment["RATING"]?></div>
											<span itemprop="bestRating" class="hide">5</span>
											<span itemprop="worstRating" class="hide">1</span>
										</div>
									</div>
								</div>
								<div class="review-card__text">
									<div class="review-card__text-title advantages">
										<svg xmlns="http://www.w3.org/2000/svg" width="18.523" height="18.523" viewBox="0 0 18.523 18.523" class="inline-svg">
											<path d="M9.262,0a9.262,9.262,0,1,0,9.262,9.262A9.272,9.272,0,0,0,9.262,0Zm4.453,9.974H9.974v3.918a.712.712,0,0,1-1.425,0V9.974H4.809a.712.712,0,1,1,0-1.425h3.74V4.987a.712.712,0,1,1,1.425,0V8.549h3.74a.712.712,0,0,1,0,1.425Z" fill="#78a86d" />
										</svg>Достоинства
									</div>
									<p><?=$comment["DIGNITIES"]?></p>
								</div>
								<div class="review-card__text">
									<div class="review-card__text-title disadvantages">
										<svg xmlns="http://www.w3.org/2000/svg" width="18.523" height="18.523" viewBox="0 0 18.523 18.523" class="inline-svg">
											<path d="M9.262,0a9.262,9.262,0,1,0,9.262,9.262A9.272,9.272,0,0,0,9.262,0Zm4.453,9.974H4.809a.712.712,0,1,1,0-1.425h8.905a.712.712,0,0,1,0,1.425Z" fill="#c66574" />
										</svg>Недостатки
									</div>
									<p><?=$comment["DISADVANTAGES"]?></p>
								</div>
								<div class="review-card__text">
									<div class="review-card__text-title">Отзывы</div>
									<p itemprop="reviewBody"><?=$comment["TEXT"]?></p>
								</div>
							</div>
						</div>
						<?}?>
					</div>
				</div>
				<div class="tab-pane fade" id="residentReviews" role="tabpanel" aria-labelledby="residentReviews-tab">
					<div class="row">
						<?// выводим отзывы жителей
						foreach($arResult["COMMENTS_RES"] as $comment){?>
						<div class="col-md-6">
							<div class="review-card">
								<div class="review-card__user">
									<div class="review-card__user-avatar"></div>
									<div class="name"><?=$comment["FIO"]?></div>
									<div class="date"><?=$comment["DATE"]?></div>
									<div class="review-star">
										<div class="line-raiting">
											<div class="line-raiting__star">
												<div class="line-raiting__star--wrap" style="width: <?=$comment['RATING'] * 100 / 5; ?>%;"></div>
											</div>
											<div class="line-raiting__title"><?=$comment["RATING"]?></div>
										</div>
									</div>
								</div>
								<div class="review-card__text">
									<div class="review-card__text-title advantages">
										<svg xmlns="http://www.w3.org/2000/svg" width="18.523" height="18.523" viewBox="0 0 18.523 18.523" class="inline-svg">
											<path d="M9.262,0a9.262,9.262,0,1,0,9.262,9.262A9.272,9.272,0,0,0,9.262,0Zm4.453,9.974H9.974v3.918a.712.712,0,0,1-1.425,0V9.974H4.809a.712.712,0,1,1,0-1.425h3.74V4.987a.712.712,0,1,1,1.425,0V8.549h3.74a.712.712,0,0,1,0,1.425Z" fill="#78a86d" />
										</svg>Достоинства
									</div>
									<p><?=$comment["DIGNITIES"]?></p>
								</div>
								<div class="review-card__text">
									<div class="review-card__text-title disadvantages">
										<svg xmlns="http://www.w3.org/2000/svg" width="18.523" height="18.523" viewBox="0 0 18.523 18.523" class="inline-svg">
											<path d="M9.262,0a9.262,9.262,0,1,0,9.262,9.262A9.272,9.272,0,0,0,9.262,0Zm4.453,9.974H4.809a.712.712,0,1,1,0-1.425h8.905a.712.712,0,0,1,0,1.425Z" fill="#c66574" />
										</svg>Недостатки
									</div>
									<p><?=$comment["DISADVANTAGES"]?></p>
								</div>
								<div class="review-card__text">
									<div class="review-card__text-title">Отзывы</div>
									<p><?=$comment["TEXT"]?></p>
								</div>
							</div>
						</div>
						<?}?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="review-add">
		<div class="container">
			<div class="row">
				<div class="offset-xl-2 col-xl-8">
					<h3 class="h2 text-center">Оставить отзыв</h3>
					<form method="post" enctype="multipart/form-data" action="#" id="formSendReview">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<input class="form-control" id="review-name" type="text" name="review-name" placeholder="Ваше имя" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<input class="form-control" id="review-surname" type="text" name="review-surname" placeholder="Фамилия">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<input class="form-control" id="review-email" type="email" name="review-email" placeholder="Адрес электронной почты" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="review-star">
									<label class="you-star">Ваша оценка:</label>
									<div class="star-list">
										<label for="star-5"></label>
										<input id="star-5" name="review-raiting" type="radio" value="5">
										<label for="star-4"></label>
										<input id="star-4" name="review-raiting" type="radio" value="4">
										<label for="star-3"></label>
										<input id="star-3" name="review-raiting" type="radio" value="3">
										<label for="star-2"></label>
										<input id="star-2" name="review-raiting" type="radio" value="2">
										<label for="star-1"></label>
										<input id="star-1" name="review-raiting" type="radio" value="1">
									</div>
									<div class="star-value"><span class="star-value__title">0</span>.0</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group quality quality-advantages">
									<button type="button"><svg xmlns="http://www.w3.org/2000/svg" width="18.523" height="18.523" viewBox="0 0 18.523 18.523" class="inline-svg">
										<path d="M9.262,0a9.262,9.262,0,1,0,9.262,9.262A9.272,9.272,0,0,0,9.262,0Zm4.453,9.974H9.974v3.918a.712.712,0,0,1-1.425,0V9.974H4.809a.712.712,0,1,1,0-1.425h3.74V4.987a.712.712,0,1,1,1.425,0V8.549h3.74a.712.712,0,0,1,0,1.425Z" fill="#78a86d" />
										</svg></button>
									<input class="form-control" id="review-advantages" type="text" name="review-advantages" placeholder="Достоинства">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group quality quality-disadvantages">
									<button type="button"><svg xmlns="http://www.w3.org/2000/svg" width="18.523" height="18.523" viewBox="0 0 18.523 18.523" class="inline-svg">
											<path d="M9.262,0a9.262,9.262,0,1,0,9.262,9.262A9.272,9.272,0,0,0,9.262,0Zm4.453,9.974H4.809a.712.712,0,1,1,0-1.425h8.905a.712.712,0,0,1,0,1.425Z" fill="#c66574" />
										</svg></button>
									<input class="form-control" id="review-disadvantages" type="text" name="review-disadvantages" placeholder="Недостатки">
								</div>
							</div>
							<div class="col-12">
								<div class="review-add__textarea">
									<textarea class="form-control" id="review-text" placeholder="Введите текст отзыва" name="review-text" required></textarea>
									<div class="custom-control custom-checkbox custom-control-inline">
										<input class="custom-control-input" id="review-resident" type="checkbox" name="review-resident" value="175">
										<label class="custom-control-label" for="review-resident">Отметьте, если вы житель поселка</label>
									</div>
								</div>
							</div>
						</div>
						<div class="row align-items-center">
							<div class="col-md-8 privacy-policy-label">
								<div class="custom-control custom-checkbox custom-control-inline">
									<input class="custom-control-input" id="privacy-policy" type="checkbox" name="privacy-policy" checked required>
									<label class="custom-control-label" for="privacy-policy">
										Нажимая на кнопку, вы даете согласие на обработку персональных данных и соглашаетесь с&nbsp; <a href="/politika-konfidentsialnosti/" onclick="window.open('/politika-konfidentsialnosti/', '_blank'); return false;" title="Ознакомиться с политикой конфиденциальности">Политикой Конфиденциальности</a></label>
								</div>
							</div>
							<div class="col-md-4 mt-4 mt-md-0">
								<button class="btn btn-warning rounded-pill w-100" type="submit">Оставить отзыв</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="high-raiting">
	<div class="container">
		<h2>Скорее всего вам будут интересны данные поселки:</h2>
		<div class="block-page__offer" id="raiting-area-home-slick">
			<?global $arrFilter;
			// dump($arResult['PROPERTIES']['PRICE_SOTKA']);
			$arrFilter = [
				'!ID' => $arResult['ID'],
				'PROPERTY_DOMA' => $housesValEnum,
				'PROPERTY_SHOSSE' => $arResult['PROPERTIES']['SHOSSE']['VALUE_ENUM_ID'],
				'>=PROPERTY_MKAD' => $km_MKAD - 10,
				'<=PROPERTY_MKAD' => $km_MKAD + 10,
				'PROPERTY_GAS' => $arResult['PROPERTIES']['GAS']['VALUE_ENUM_ID'],
				'PROPERTY_PLUMBING' => $arResult['PROPERTIES']['PLUMBING']['VALUE_ENUM_ID'],
			];
			if($housesValEnum == 3){ // Только участки
				$percent = 20;
				$priceSotka1 = $arResult['PROPERTIES']['PRICE_SOTKA']['VALUE'][0];
				$priceSotka2 = $arResult['PROPERTIES']['PRICE_SOTKA']['VALUE'][1];
				$priceSotkaFrom = $priceSotka1 - ($priceSotka1 / 100 * $percent);
				$priceSotkaTo = $priceSotka2 + ($priceSotka2 / 100 * $percent);
				$arrFilter['>=PROPERTY_PRICE_SOTKA'] = $priceSotkaFrom;
				$arrFilter['<=PROPERTY_PRICE_SOTKA'] = $priceSotkaTo;
			}elseif($housesValEnum == 4 || $housesValEnum == 256){ // Участки с домами
				$percent = 20;
				$homeValue1 = $arResult['PROPERTIES']['HOME_VALUE']['VALUE'][0];
				$homeValue2 = $arResult['PROPERTIES']['HOME_VALUE']['VALUE'][1];
				$homeValueFrom = $homeValue1 - ($homeValue1 / 100 * $percent);
				$homeValueTo = $homeValue2 + ($homeValue2 / 100 * $percent);
				$arrFilter['>=PROPERTY_HOME_VALUE'] = $homeValueFrom;
				$arrFilter['<=PROPERTY_HOME_VALUE'] = $homeValueTo;
			} // dump($arrFilter);
			// $arrFilter=array('PROPERTY_DOMA'=>3,'!PROPERTY_ACTION'=>false); // показывать только акции?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:main.include",
				"",
				Array(
					"AREA_FILE_SHOW" => "file",
					"AREA_FILE_SUFFIX" => "inc",
					"EDIT_TEMPLATE" => "",
					"PATH" => "/include/section_index.php"
				)
			);?>
		</div>
	</div>
</div>
<div class="bg-white py-4">
	<div class="footer-feedback-village">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-5 px-5"><img class="w-100 lazyload footer-feedback-village__img" src="/assets/img/content/feedback-village@2x.jpg" alt></div>
				<div class="col-xl-5 col-lg-6 col-md-7 footer-feedback-village__text">
					<div class="h1">Не нашли ничего&nbsp;подходящего?</div>
					<p>Оставьте заявку, и мы подберем для вас варианты, которые должны Вам подойти</p>
					<div class="d-flex footer-feedback-village__buttons"><a class="btn btn-warning rounded-pill mr-4" href="#" data-toggle="modal" data-target="#writeToUs" data-id-button="WRITE_TO_US_FOOT">Оставить заявку</a></div>
				</div>
			</div>
		</div>
	</div>
