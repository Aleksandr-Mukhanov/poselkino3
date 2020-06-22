<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult['ERROR'])){
	ShowError($arResult['ERROR']);
	return false;
}

global $USER_FIELD_MANAGER;
global $arrFilter;
// dump($arResult['row']);
$photoRes = CFile::ResizeImageGet($arResult['row']['UF_FILE'], array('width'=>417, 'height'=>250), BX_RESIZE_IMAGE_EXACT); //dump($photoRes);?>
	<div class="container developer__info">
		<div class="row">
			<div class="col-sm-4 d-none d-sm-block"><a href="#"><img class="logo" src="<?=$photoRes['src']?>" alt="<?=$arResult['row']['UF_NAME']?>"></a></div>
			<div class="col-sm-8">
				<h1 class="title">Отзывы о компании <?=$arResult['row']['UF_NAME']?></h1>
				<div class="subtitle font-weight-bold">Компания <?=$arResult['row']['UF_NAME']?>: отзывы, рейтинг поселки</div>
				<div class="d-sm-none"><a href="#"><img class="logo" src="<?=$photoRes['src']?>" alt="<?=$arResult['row']['UF_NAME']?>"></a></div>
				<div class="row d-none d-lg-flex">
					<div class="col-lg-4 info-col">
						<div class="title">Юридическое лицо:</div>
						<div class="value font-weight-bold"><?=($arResult['row']['UF_LEGAL_ENTITY'])?$arResult['row']['UF_LEGAL_ENTITY']:'нет данных'?></div>
					</div>
					<div class="col-lg-4 info-col">
						<div class="title">Рейтинг компании:</div>
						<div class="value font-weight-bold"><?=($arResult['RATING_TOTAL'])?$arResult['RATING_TOTAL']:'нет данных'?></div>
					</div>
					<div class="col-lg-4 info-col">
						<div class="title">Поселков в продаже:</div>
						<div class="value font-weight-bold"><?=$arResult["CNT_POS_SALE"]?></div>
					</div>
					<div class="col-lg-4 info-col">
						<div class="title">Сколько лет на рынке:</div>
						<div class="value font-weight-bold"><?=($arResult['row']['UF_HOW_YEARS'])?$arResult['row']['UF_HOW_YEARS'].' лет':'нет данных'?></div>
					</div>
					<div class="col-lg-4 info-col">
						<div class="title">Средний рейтинг поселков:</div>
						<div class="value font-weight-bold"><?=$arResult["POS_RATING"]?></div>
					</div>
					<div class="col-lg-4 info-col">
						<div class="title">Всего отзывов:</div>
						<div class="value font-weight-bold"><?=($arResult['CNT_COMMENTS'])?$arResult['row']['CNT_COMMENTS'].' <a href="#showComments">Посмотреть</a>':'нет данных'?></div>
					</div>
				</div>
				<div class="address d-none d-lg-block">
					<div class="title d-inline">Адрес:</div>&nbsp;
					<div class="d-inline font-weight-bold"><?=($arResult['row']['UF_ADDRESS'])?$arResult['row']['UF_ADDRESS']:'нет данных'?></div>
				</div>
				<div class="row developer__info--bottom d-none d-lg-flex">
					<div class="col-lg-4"><a class="btn btn-warning rounded-pill w-100" href="#formSendReview">Оставить отзыв</a></div>
					<div class="col-lg-5">
						<div class="text mt-3 mt-md-0 text-center text-md-left">Мы передадим ваши контактные данные представителям поселка </div>
					</div>
				</div>
			</div>
			<!-- Дублирование кода выше, для адаптива-->
			<div class="col-12">
				<div class="row d-lg-none">
					<div class="col-sm-4 info-col">
						<div class="title">Юридическое лицо:</div>
						<div class="value font-weight-bold"><?=($arResult['row']['UF_LEGAL_ENTITY'])?$arResult['row']['UF_LEGAL_ENTITY']:'нет данных'?></div>
					</div>
					<div class="col-sm-4 info-col">
						<div class="title">Рейтинг компании:</div>
						<div class="value font-weight-bold"><?=($arResult['RATING_TOTAL'])?$arResult['RATING_TOTAL']:'нет данных'?></div>
					</div>
					<div class="col-sm-4 info-col">
						<div class="title">Поселков в продаже:</div>
						<div class="value font-weight-bold"><?=$arResult["CNT_POS_SALE"]?></div>
					</div>
					<div class="col-sm-4 info-col">
						<div class="title">Сколько лет на рынке:</div>
						<div class="value font-weight-bold"><?=($arResult['row']['UF_HOW_YEARS'])?$arResult['row']['UF_HOW_YEARS'].' лет':'нет данных'?></div>
					</div>
					<div class="col-sm-4 info-col">
						<div class="title">Средний рейтинг поселков:</div>
						<div class="value font-weight-bold"><?=$arResult["POS_RATING"]?></div>
					</div>
					<div class="col-sm-4 info-col">
						<div class="title">Всего отзывов:</div>
						<div class="value font-weight-bold"><?=($arResult['CNT_COMMENTS'])?$arResult['row']['CNT_COMMENTS'].' <a href="#showComments">Посмотреть</a>':'нет данных'?></div>
					</div>
				</div>
				<div class="address d-lg-none">
					<div class="title d-inline">Адрес:</div>&nbsp;
					<div class="d-inline font-weight-bold"><?=($arResult['row']['UF_ADDRESS'])?$arResult['row']['UF_ADDRESS']:'нет данных'?></div>
				</div>
				<div class="row developer__info--bottom d-lg-none">
					<div class="col-md-4"><a class="btn btn-warning rounded-pill w-100" href="#formSendReview">Оставить отзыв</a></div>
					<div class="col-md-5">
						<div class="text mt-3 mt-md-0 text-center text-md-left">Мы передадим ваши контактные данные представителям поселка </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> <!-- bg-white -->
<div class="bg-white py-md-4 py-2">
	<div class="pb-5">
		<div class="review-list">
			<div class="container">
				<div class="row mb-4">
					<div class="col-xl-9 col-md-8" id="showComments">
						<h3 class="h2">Отзывы&nbsp;<span class="text-secondary"><?=$arResult['CNT_COMMENTS']?></span></h3>
					</div>
					<div class="col-xl-3 col-md-4 justify-content-end">
						<div class="review-list__average-rating text-left text-md-right">Средняя оценка пользователей:</div>
						<div class="wrap-raiting">
							<div class="card-house__raiting d-flex justify-content-md-end">
								<div class="line-raiting">
									<div class="line-raiting__star">
										<div class="line-raiting__star--wrap" style="width: <?=$arResult['RATING_TOTAL'] * 100 / 5?>%;"></div>
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
									<input type="hidden" id="develInfo" nameDevel='<?=$arResult['row']['UF_NAME']?>' codeDevel='<?=$arResult['row']['UF_XML_ID']?>' idDevel='<?=$arResult['row']['ID']?>'>
									<button class="btn btn-warning rounded-pill w-100" type="submit">Оставить отзыв</button>
								</div>
							</div>
						</form>
					</div>
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
			$arrFilter = [
				'ACTIVE' => 'Y',
				'PROPERTY_DEVELOPER_ID' => $arResult['row']['UF_XML_ID']
			];?>
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
