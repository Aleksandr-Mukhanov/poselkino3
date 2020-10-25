<?
$APPLICATION->SetTitle("Отзывы о КП “".$arVillage['NAME']."”");
$APPLICATION->SetPageProperty("title", "Отзывы о коттеджном поселке “".$arVillage['NAME']."”");

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

use Bitrix\Main\Grid\Declension;
// выводим правильное окончание
$reviewsDeclension = new Declension('отзыв', 'отзыва', 'отзывов');
$reviewsText = $reviewsDeclension->get($cntCom);
$reviewsText = ($cntCom) ? $cntCom . ' ' . $reviewsText : 'нет отзывов';

$APPLICATION->SetPageProperty("description", "Отзывы покупателей и жильцов о поселке “".$arVillage['NAME']."” - ".$reviewsText.". Что нужно знать перед тем как купить участок в “".$arVillage['NAME']."”?");
?>
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
    <div class="card-rev card-rev__light">
      <div class="row align-items-start">
        <div class="col-md">
          <p>В этом разделе собраны отзывы реальных людей. Все тексты публикуются с согласия авторов без изменений и сокращений.</p>
        </div>
        <div class="col-md-auto"> <a class="btn btn--large btn--theme_blue" href="#" data-toggle="modal" data-target="#addReviews">Добавить отзыв</a></div>
      </div>
    </div>
    <div class="row row__review">
      <?foreach ($arComments as $comment) {?>
        <div class="col-md-6">
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
            <div class="review__source">Источник отзыва: <a href="https://poselkino.ru/poselki/<?=$arVillage['CODE']?>/" rel="nofollow"target="_blank">poselkino.ru</a></div>
          </div>
        </div>
      <?}?>
    </div>
  </div>
</section>
<?require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/appeal-form.php';?>
<!-- text-block BEGIN-->
<section class="text-block">
  <div class="container text-block__container">
    <div class="content text-block__content">
      <a class="btn btn--theme_blue" href="/">На главную</a>
    </div>
  </div>
</section>
<!-- text-block END-->
<div class="modal fade" id="addReviews" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="close" data-dismiss="modal" aria-label="Close"></div>
			<div class="modal-body">
				<div class="modal-title">Написать отзыв</div>
				<form action="" id="formSendReview">
					<div class="row">
						<div class="col-lg-6">
							<input class="input-el" type="text" name="review-name" placeholder="Имя" required>
						</div>
						<div class="col-lg-6">
							<input class="input-el" type="text" name="review-surname" placeholder="Фамилия" required>
						</div>
						<div class="col-lg-6">
							<input class="input-el" type="email" name="review-email" placeholder="E-mail" required>
						</div>
						<div class="col-lg-6">
							<select class="my-select" name="review-raiting" title="Ваша оценка поселку" required>
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
							</select>
						</div>
						<div class="col-lg-6">
							<input class="input-el positive" type="text" name="review-advantages" placeholder="Достоинства" required>
						</div>
						<div class="col-lg-6">
							<input class="input-el negative" type="text" name="review-disadvantages" placeholder="Недостатки" required>
						</div>
						<div class="col-12">
							<textarea class="textarea-el" name="review-text" placeholder="Текст отзыва" required></textarea>
						</div>
						<div class="col-12 mb-4">
							<div class="center">
								<button class="btn btn--large btn--theme_green">Добавить отзыв</button>
							</div>
						</div>
						<div class="col-12">
							<label class="privacy appeal-form__privacy">
								<input class="privacy__input" type="checkbox" name="privacy" value="privacy" required checked><span class="privacy__icon"></span> Нажимая на кнопку, вы даете согласие на обработку персональных данных и соглашаетесь с <a class="privacy__link" href="/politika-konfidentsialnosti/">Политикой Конфиденциальности</a>
							</label>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
