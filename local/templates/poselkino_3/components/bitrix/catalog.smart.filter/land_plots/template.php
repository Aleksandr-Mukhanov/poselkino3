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
// dump($arResult["ITEMS"]);
?>
	<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get">
	  <?foreach($arResult["HIDDEN"] as $arItem):?>
			<input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
	  <?endforeach;?>
		<div class="filter row">
			<div class="order-0 col-xl-3 col-lg-12 col-sm-6">
				<div class="d-flex">

				 	<div class="filter__region">
						<?$activeAreas = ''; // ставим активность если надо
							foreach ($arResult["ITEMS"][PLOTS_PROP_REGION]["VALUES"] as $val => $ar) //dump($ar); // Район
								if ($ar["CHECKED"]) $activeAreas = 'active';
						?>
				 		<a class="btn btn-outline-warning rounded-pill w-100 Areas <?=$activeAreas?>" href="#regionModal" data-toggle="modal" data-target="#regionModal">Районы МО</a>
				 	</div>

					<div class="filter__highway">
						<?$activeHighway = '';// ставим активность если надо
			       foreach($arResult["ITEMS"][PLOTS_PROP_SHOSSE]["VALUES"] as $val => $ar){ //dump($ar); // Шоссе
			        if ($ar["CHECKED"]) $activeHighway = 'active';
			       }?>
						<button class="btn btn-outline-warning rounded-pill Highway <?=$activeHighway?>" type="button" data-toggle="modal" data-target="#highwayModal">Шоссе</button>
					</div>

				</div>
			</div>
			<div class="order-1 col-xl-3 col-lg-4 col-sm-6 mt-4 mt-sm-0">
				<div class="filter__mkad">
					<div class="form-group form-group-inline justify-content-sm-end justify-content-lg-start">
						<?$arItem = $arResult["ITEMS"][195]; //dump($arItem); // Удаленность от МКАД
			      $placeholderMin = ($arItem["VALUES"]["MIN"]["HTML_VALUE"]) ? $arItem["VALUES"]["MIN"]["HTML_VALUE"]: 'от';
			      $placeholderMax = ($arItem["VALUES"]["MAX"]["HTML_VALUE"]) ? $arItem["VALUES"]["MAX"]["HTML_VALUE"]: 'до';?>
						<label>от <?=ROAD?>, км</label>
						<input
		          placeholder="<?=$placeholderMin?>"
		          data-min-val='<?echo $arItem["VALUES"]["MIN"]["VALUE"]?>'
		          data-max-val='<?echo $arItem["VALUES"]["MAX"]["VALUE"]?>'
		          type="text"
		          class="form-control"
		          name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
		          id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
		          value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
		          onkeyup="smartFilter.keyup(this)"
		          />
						<input
		          placeholder="<?=$placeholderMax?>"
		          data-min-val='<?echo $arItem["VALUES"]["MIN"]["VALUE"]?>'
		          data-max-val='<?echo $arItem["VALUES"]["MAX"]["VALUE"]?>'
		          type="text"
		          class="form-control mr-0"
		          name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
		          id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
		          value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
		          onkeyup="smartFilter.keyup(this)"
		          />
					</div>
				</div>
			</div>
			<div class="order-2 col-xl-4 col-lg-4 col-sm-6 mt-4 mt-md-0">
				<div class="filter__price">
					<div class="form-group form-group-inline justify-content-lg-start">
						<?
							$arItem = $arResult["ITEMS"][140]; // dump($arItem); // Цена участка
			        $placeholderMin = ($arItem["VALUES"]["MIN"]["HTML_VALUE"]) ? $arItem["VALUES"]["MIN"]["HTML_VALUE"]: 'от';
			        $placeholderMax = ($arItem["VALUES"]["MAX"]["HTML_VALUE"]) ? $arItem["VALUES"]["MAX"]["HTML_VALUE"]: 'до';
			      ?>
						<label>Стоимость, <span class="rub_currency">&#8381;</span></label>
						<input
		          placeholder="<?=$placeholderMin?>"
		          data-min-val='<?echo $arItem["VALUES"]["MIN"]["VALUE"]?>'
		          data-max-val='<?echo $arItem["VALUES"]["MAX"]["VALUE"]?>'
		          type="text"
		          class="form-control cost_land"
		          name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
		          id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
		          value="<?if($arItem["VALUES"]["MIN"]["HTML_VALUE"])echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
		          onkeyup="smartFilter.keyup(this)"
		          />
						<input
		          placeholder="<?=$placeholderMax?>"
		          data-min-val='<?echo $arItem["VALUES"]["MIN"]["VALUE"]?>'
		          data-max-val='<?echo $arItem["VALUES"]["MAX"]["VALUE"]?>'
		          type="text"
		          class="form-control cost_land"
		          name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
		          id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
		          value="<?if($arItem["VALUES"]["MAX"]["HTML_VALUE"])echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
		          onkeyup="smartFilter.keyup(this)"
		          />
					</div>
				</div>
			</div>
			<div class="order-3 col-xl-2 pl-xl-0 col-lg-4 col-sm-6 mt-4 mt-md-0">
				<div class="filter__size d-flex justify-content-sm-end">
					<div class="form-group form-group-inline mr-lg-0">
						<?
							$arItem = $arResult["ITEMS"][139]; //dump($arItem); // Площадь участка
				      $placeholderMin = ($arItem["VALUES"]["MIN"]["HTML_VALUE"]) ? $arItem["VALUES"]["MIN"]["HTML_VALUE"]: 'от';
				      $placeholderMax = ($arItem["VALUES"]["MAX"]["HTML_VALUE"]) ? $arItem["VALUES"]["MAX"]["HTML_VALUE"]: 'до';
						?>
						<label>Участок, сот.</label>
						<input
		          placeholder="<?=$placeholderMin?>"
		          data-min-val='<?echo $arItem["VALUES"]["MIN"]["VALUE"]?>'
		          data-max-val='<?echo $arItem["VALUES"]["MAX"]["VALUE"]?>'
		          type="text"
		          class="form-control"
		          name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
		          id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
		          value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
		          onkeyup="smartFilter.keyup(this)"
		          />
						<input
		          placeholder="<?=$placeholderMax?>"
		          data-min-val='<?echo $arItem["VALUES"]["MIN"]["VALUE"]?>'
		          data-max-val='<?echo $arItem["VALUES"]["MAX"]["VALUE"]?>'
		          type="text"
		          class="form-control"
		          name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
		          id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
		          value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
		          onkeyup="smartFilter.keyup(this)"
		          />
					</div>
				</div>
			</div>
			<div class="order-3 col-12">
				<div class="extra-options">
					<div class="row">
						<div class="col-lg-8 mt-40">
							<div class="d-flex align-items-center flex-wrap">
								<?foreach($arResult["ITEMS"][196]["VALUES"] as $val => $ar): //dump($ar); // Тип поселка
						      if($ar["URL_ID"] == 'dacha')$ar["VALUE"] = 'Дачный';
						      if($ar["URL_ID"] == 'cottage')$ar["VALUE"] = 'ИЖС';
						    ?>
						      <div class="custom-control custom-checkbox custom-control-inline align-items-center h-100">
						        <input
						          type="checkbox"
											class="custom-control-input"
						          value="<? echo $ar["HTML_VALUE"] ?>"
						          name="<? echo $ar["CONTROL_NAME"] ?>"
						          id="<? echo $ar["CONTROL_ID"] ?>"
						          <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
						          onclick="smartFilter.click(this)"
						        />
							      <label class="custom-control-label <? echo $ar["DISABLED"] ? 'disabled': '' ?>" data-role="label_<?=$ar["CONTROL_ID"]?>" for="<? echo $ar["CONTROL_ID"] ?>"><?=$ar["VALUE"];?></label>
									</div>
						    <?endforeach;?>
								<?foreach($arResult["ITEMS"][192]["VALUES"] as $val => $ar): //dump($ar); // Акция?>
									<div class="custom-control custom-checkbox custom-control-inline align-items-center h-100">
										<input
											type="checkbox"
											class="custom-control-input"
											value="<? echo $ar["HTML_VALUE"] ?>"
											name="<? echo $ar["CONTROL_NAME"] ?>"
											id="<? echo $ar["CONTROL_ID"] ?>"
											<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
											onclick="smartFilter.click(this)"
										/>
										<label class="custom-control-label <? echo $ar["DISABLED"] ? 'disabled': '' ?>" data-role="label_<?=$ar["CONTROL_ID"]?>" for="<? echo $ar["CONTROL_ID"] ?>">Участки с акциями</label>
									</div>
								<?endforeach;?>
							</div>
						</div>
					</div>
					<div class="row extra-options__parameters">
						<div class="order-lg-1 col-md-3 col-lg-2 col-sm-4">
							<div class="extra-options__parameters-title">Коммуникация</div>
							<?foreach($arResult["ITEMS"][197]["VALUES"] as $val => $ar): //dump($ar); // Электричество
				        if($ar["URL_ID"] == 'y'):?>
								<div class="extra-options__parameters-input">
									<input
				            type="checkbox"
										class="sr-only"
				            value="<? echo $ar["HTML_VALUE"] ?>"
				            name="<? echo $ar["CONTROL_NAME"] ?>"
				            id="<? echo $ar["CONTROL_ID"] ?>"
				            <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
				            onclick="smartFilter.click(this)"
				          />
									<label class="d-flex w-100 align-items-center <? echo $ar["DISABLED"] ? 'disabled': '' ?>" data-role="label_<?=$ar["CONTROL_ID"]?>" for="<? echo $ar["CONTROL_ID"] ?>"><span class="icon icon--svet">
										<svg xmlns="http://www.w3.org/2000/svg" width="23.032" height="24" viewBox="0 0 23.032 24" class="inline-svg">
											<g transform="translate(-9.8)">
												<path d="M24.052,20.973v.7a1.112,1.112,0,0,1-.943,1.1l-.173.637A.793.793,0,0,1,22.17,24H20.457a.793.793,0,0,1-.765-.588l-.168-.637a1.117,1.117,0,0,1-.948-1.106v-.7a.674.674,0,0,1,.677-.677h4.123A.682.682,0,0,1,24.052,20.973Zm3.175-9.452a5.883,5.883,0,0,1-1.659,4.1,5.422,5.422,0,0,0-1.452,2.943.978.978,0,0,1-.968.825H19.479a.968.968,0,0,1-.963-.82,5.482,5.482,0,0,0-1.462-2.953,5.912,5.912,0,1,1,10.173-4.1Zm-5.244-3.58a.667.667,0,0,0-.667-.667,4.271,4.271,0,0,0-4.267,4.267.667.667,0,1,0,1.333,0,2.937,2.937,0,0,1,2.933-2.933A.664.664,0,0,0,21.983,7.941Zm-.667-4.272A.667.667,0,0,0,21.983,3V.667a.667.667,0,0,0-1.333,0V3A.667.667,0,0,0,21.316,3.669Zm-7.847,7.847a.667.667,0,0,0-.667-.667H10.467a.667.667,0,1,0,0,1.333H12.8A.664.664,0,0,0,13.469,11.516Zm18.7-.667H29.83a.667.667,0,1,0,0,1.333h2.336a.667.667,0,1,0,0-1.333ZM14.827,17.067l-1.654,1.654a.665.665,0,0,0,.938.943l1.654-1.654a.665.665,0,0,0-.938-.943Zm12.509-10.9A.666.666,0,0,0,27.8,5.97l1.654-1.654a.667.667,0,1,0-.943-.943L26.862,5.027a.665.665,0,0,0,0,.943A.677.677,0,0,0,27.336,6.163Zm-12.509-.2a.665.665,0,0,0,.938-.943L14.111,3.368a.667.667,0,1,0-.943.943ZM27.8,17.067a.667.667,0,1,0-.943.943l1.654,1.654a.665.665,0,1,0,.938-.943Z" class="color-fill" />
											</g>
										</svg></span><span class="text"><span>Свет</span></span></label>
								</div>
							<?endif;
				      endforeach;?>
							<?foreach($arResult["ITEMS"][198]["VALUES"] as $val => $ar): //dump($ar); // Водопровод
				        if($ar["URL_ID"] == 'y'):?>
								<div class="extra-options__parameters-input">
									<input
				            type="checkbox"
										class="sr-only"
				            value="<? echo $ar["HTML_VALUE"] ?>"
				            name="<? echo $ar["CONTROL_NAME"] ?>"
				            id="<? echo $ar["CONTROL_ID"] ?>"
				            <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
				            onclick="smartFilter.click(this)"
				          />
									<label class="d-flex w-100 align-items-center <? echo $ar["DISABLED"] ? 'disabled': '' ?>" data-role="label_<?=$ar["CONTROL_ID"]?>" for="<? echo $ar["CONTROL_ID"] ?>"><span class="icon icon--voda">
										<svg xmlns="http://www.w3.org/2000/svg" width="15.782" height="22.051" viewBox="0 0 15.782 22.051" class="inline-svg">
											<g transform="translate(-35.275 0)">
												<g transform="translate(35.275 0)">
													<path d="M44.09.76c-.6-1.031-1.244-1-1.848,0-2.772,4.123-6.967,10.308-6.967,13.4a7.891,7.891,0,1,0,15.782,0C51.057,11.033,46.862,4.883,44.09.76Zm4.763,16.919a6.749,6.749,0,0,1-2.381,2.31.955.955,0,0,1-.924-1.671,4.705,4.705,0,0,0,1.706-1.635,4.634,4.634,0,0,0,.711-2.275.943.943,0,0,1,1.884.107A7.042,7.042,0,0,1,48.853,17.679Z" transform="translate(-35.275 0)" class="color-fill" />
												</g>
											</g>
										</svg></span><span class="text"><span>Вода</span></span></label>
								</div>
							<?endif;
				      endforeach;?>
							<?foreach($arResult["ITEMS"][199]["VALUES"] as $val => $ar): //dump($ar); // Газ
				        if($ar["URL_ID"] == 'y'):?>
								<div class="extra-options__parameters-input">
									<input
				            type="checkbox"
										class="sr-only"
				            value="<? echo $ar["HTML_VALUE"] ?>"
				            name="<? echo $ar["CONTROL_NAME"] ?>"
				            id="<? echo $ar["CONTROL_ID"] ?>"
				            <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
				            onclick="smartFilter.click(this)"
				          />
									<label class="d-flex w-100 align-items-center <? echo $ar["DISABLED"] ? 'disabled': '' ?>" data-role="label_<?=$ar["CONTROL_ID"]?>" for="<? echo $ar["CONTROL_ID"] ?>"><span class="icon icon--gaz">
										<svg xmlns="http://www.w3.org/2000/svg" width="17.883" height="23.844" viewBox="0 0 17.883 23.844" class="inline-svg">
											<g transform="translate(-64 0)">
												<g transform="translate(64 0)">
													<path d="M81.832,13.96C81.559,10.4,79.9,8.176,78.442,6.209,77.09,4.389,75.922,2.817,75.922.5a.5.5,0,0,0-.27-.442.492.492,0,0,0-.516.038,12.633,12.633,0,0,0-4.663,6.739,22,22,0,0,0-.511,5.038c-2.026-.433-2.485-3.463-2.49-3.5A.5.5,0,0,0,66.764,8c-.106.051-2.607,1.322-2.753,6.4-.01.169-.011.338-.011.507a8.951,8.951,0,0,0,8.941,8.941.069.069,0,0,0,.02,0h.006A8.952,8.952,0,0,0,81.883,14.9C81.883,14.654,81.832,13.96,81.832,13.96Zm-8.89,8.889a3.086,3.086,0,0,1-2.98-3.175c0-.06,0-.12,0-.194a4.027,4.027,0,0,1,.314-1.577,1.814,1.814,0,0,0,1.64,1.188.5.5,0,0,0,.5-.5,9.937,9.937,0,0,1,.191-2.259,4.8,4.8,0,0,1,1.006-1.9,6.4,6.4,0,0,0,1.024,1.879,5.659,5.659,0,0,1,1.273,3.1c.006.085.013.171.013.263A3.086,3.086,0,0,1,72.941,22.849Z" transform="translate(-64 0)" class="color-fill" />
												</g>
											</g>
										</svg></span><span class="text"><span>Газ</span></span></label>
								</div>
							<?endif;
				      endforeach;?>
						</div>

						<div class="order-sm-5 col-sm-8 order-md-5 order-lg-3 col-md-6 col-lg-2">
							<div class="row">
								<div class="col-sm-6 col-lg-12">
									<div class="extra-options__parameters-title">Как добраться</div>
									<?foreach($arResult["ITEMS"][200]["VALUES"] as $val => $ar): //dump($ar); // Автобус
						        if($ar["URL_ID"] == 'y'):?>
						        <div class="extra-options__parameters-input">
											<input
						            type="checkbox"
												class="sr-only"
						            value="<? echo $ar["HTML_VALUE"] ?>"
						            name="<? echo $ar["CONTROL_NAME"] ?>"
						            id="<? echo $ar["CONTROL_ID"] ?>"
						            <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
						            onclick="smartFilter.click(this)"
						          />
											<label class="d-flex w-100 align-items-center <? echo $ar["DISABLED"] ? 'disabled': '' ?>" data-role="label_<?=$ar["CONTROL_ID"]?>" for="<? echo $ar["CONTROL_ID"] ?>"><span class="icon icon--bus">
												<svg xmlns="http://www.w3.org/2000/svg" width="33.298" height="17.762" viewBox="0 0 33.298 17.762" class="inline-svg">
													<path d="M.555,16.027h2.83A2.765,2.765,0,0,0,8.325,17.12a2.766,2.766,0,0,0,4.939-1.093h11.21a2.775,2.775,0,0,0,5.439,0h2.83a.555.555,0,0,0,.555-.555V11.259a7.2,7.2,0,0,0-.2-1.669l-1.212-5.1a2.226,2.226,0,0,0-2.177-1.785H13.107L12.154.8a.555.555,0,0,0-.5-.307H3.885a.555.555,0,0,0-.5.307L2.432,2.708H.555A.555.555,0,0,0,0,3.263V15.472A.555.555,0,0,0,.555,16.027Zm5.55,1.11a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,6.1,17.137Zm4.44,0a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,10.544,17.137Zm16.649,0a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,27.194,17.137Zm4.828-7.291c.006.026.008.051.013.077H27.748V6.038h3.369ZM4.228,1.6h7.084l.555,1.11H3.673ZM1.11,3.818h28.6a1.119,1.119,0,0,1,1.093.912l.05.2H1.11Zm25.529,2.22V9.923h-3.33V6.038Zm-4.44,0V9.923h-3.33V6.038Zm-4.44,0V9.923h-3.33V6.038Zm-4.44,0V9.923H9.989V6.038Zm-4.44,0V9.923H5.55V6.038Zm-7.77,0H4.44V9.923H1.11Zm0,7.215H2.22v-1.11H1.11v-1.11H32.175c0,.075.013.15.013.226v.884h-1.11v1.11h1.11v1.665H29.913a.147.147,0,0,0-.009-.029,2.745,2.745,0,0,0-.144-.462c-.022-.056-.051-.1-.076-.154a2.872,2.872,0,0,0-.16-.294c-.035-.056-.076-.106-.115-.158a2.862,2.862,0,0,0-.2-.238c-.047-.049-.095-.1-.145-.142a2.624,2.624,0,0,0-.234-.193q-.083-.061-.166-.116a2.955,2.955,0,0,0-.278-.149c-.059-.028-.116-.055-.177-.083a2.755,2.755,0,0,0-.333-.1c-.056-.014-.107-.033-.164-.044a2.631,2.631,0,0,0-1.054,0c-.056.011-.111.03-.164.044a2.768,2.768,0,0,0-.333.1c-.061.024-.118.056-.177.083a2.927,2.927,0,0,0-.278.149q-.083.055-.166.116a2.592,2.592,0,0,0-.234.193c-.05.046-.1.092-.145.142a2.954,2.954,0,0,0-.2.238c-.039.052-.079.1-.115.158a2.829,2.829,0,0,0-.16.294c-.025.052-.056.1-.076.154a2.767,2.767,0,0,0-.144.462.137.137,0,0,1-.009.029h-11.2a.147.147,0,0,0-.009-.029,2.787,2.787,0,0,0-.144-.462c-.022-.056-.051-.1-.076-.154a2.871,2.871,0,0,0-.16-.294c-.035-.056-.076-.106-.115-.158a2.907,2.907,0,0,0-.2-.238c-.047-.049-.095-.1-.145-.142a2.624,2.624,0,0,0-.234-.193q-.083-.061-.167-.116a2.923,2.923,0,0,0-.277-.149c-.059-.028-.116-.055-.177-.083a2.727,2.727,0,0,0-.33-.1c-.056-.014-.107-.033-.166-.044a2.583,2.583,0,0,0-1.033,0l-.086.016a2.767,2.767,0,0,0-.451.14l-.082.036a2.791,2.791,0,0,0-.42.228l-.022.017a2.789,2.789,0,0,0-.357.295l-.056.051a2.778,2.778,0,0,0-.235.272,2.827,2.827,0,0,0-.242-.278c-.018-.018-.036-.034-.056-.051a2.81,2.81,0,0,0-.357-.295l-.022-.017a2.8,2.8,0,0,0-.42-.228L7.146,12.9a2.792,2.792,0,0,0-.451-.14l-.086-.016a2.581,2.581,0,0,0-1.033,0c-.056.011-.111.03-.164.044a2.716,2.716,0,0,0-.333.1c-.061.024-.118.056-.177.083a2.91,2.91,0,0,0-.275.149c-.055.037-.111.075-.166.116a2.627,2.627,0,0,0-.234.193c-.05.046-.1.092-.145.142a2.832,2.832,0,0,0-.2.238c-.039.052-.079.1-.115.158a2.809,2.809,0,0,0-.16.294c-.025.052-.056.1-.076.154a2.732,2.732,0,0,0-.144.462.147.147,0,0,1-.009.029H1.11Zm0,0" transform="translate(0 -0.488)" fill="#3c4b5a" />
													<path d="M230.4,202.09h11.1v1.11H230.4Zm0,0" transform="translate(-217.079 -190.435)" fill="#3c4b5a" />
												</svg></span><span class="text"><span>Автобус</span></span></label>
										</div>
									<?endif;
						      endforeach;?>
									<?foreach($arResult["ITEMS"][201]["VALUES"] as $val => $ar): //dump($ar); // Электричка
						        if($ar["URL_ID"] == 'y'):?>
						        <div class="extra-options__parameters-input">
											<input
						            type="checkbox"
												class="sr-only"
						            value="<? echo $ar["HTML_VALUE"] ?>"
						            name="<? echo $ar["CONTROL_NAME"] ?>"
						            id="<? echo $ar["CONTROL_ID"] ?>"
						            <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
						            onclick="smartFilter.click(this)"
						          />
											<label class="d-flex w-100 align-items-center <? echo $ar["DISABLED"] ? 'disabled': '' ?>" data-role="label_<?=$ar["CONTROL_ID"]?>" for="<? echo $ar["CONTROL_ID"] ?>"><span class="icon icon--train">
												<svg xmlns="http://www.w3.org/2000/svg" width="33.298" height="13.319" viewBox="0 0 33.298 13.319" class="inline-svg">
													<path d="M250.156,139.33h2.22a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33A.555.555,0,0,0,250.156,139.33Zm.555-3.33h1.11v2.22h-1.11Zm0,0" transform="translate(-235.172 -132.671)"
														fill="#3c4b5a" />
													<path d="M137.173,139.33a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33a.555.555,0,0,0,.555.555ZM135.509,136h1.11v2.22h-1.11Zm0,0" transform="translate(-126.629 -132.671)"
														fill="#3c4b5a" />
													<path d="M60.376,139.33a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33a.555.555,0,0,0,.555.555ZM58.711,136h1.11v2.22h-1.11Zm0,0" transform="translate(-54.272 -132.671)" fill="#3c4b5a" />
													<path d="M2.22,138.775v-3.33a.555.555,0,0,0-.555-.555H0V136H1.11v2.22H0v1.11H1.665A.555.555,0,0,0,2.22,138.775Zm0,0" transform="translate(0 -132.671)" fill="#3c4b5a" />
													<path d="M364.8,192.488h2.22v1.11H364.8Zm0,0" transform="translate(-343.712 -186.939)" fill="#3c4b5a" />
													<path d="M460.8,230.887h1.11V232H460.8Zm0,0" transform="translate(-434.162 -223.117)" fill="#3c4b5a" />
													<path d="M518.4,230.887h1.11V232H518.4Zm0,0" transform="translate(-488.43 -223.117)" fill="#3c4b5a" />
													<path d="M15.242,96.488H0V97.6H12.209v6.66H0v1.11H12.209v1.11H0v1.11H2.775a2.2,2.2,0,0,0,.308,1.11H0v1.11H33.3V108.7H26.885a2.2,2.2,0,0,0,.308-1.11H29.72a3.578,3.578,0,0,0,2.291-6.327l-3.718-3.1a7.23,7.23,0,0,0-4.62-1.673h-8.43ZM4.995,108.7a1.11,1.11,0,0,1-1.11-1.11H6.1A1.11,1.11,0,0,1,4.995,108.7Zm3.33,0a1.11,1.11,0,0,1-1.11-1.11h2.22A1.11,1.11,0,0,1,8.325,108.7Zm4.995-3.33h5.55v1.11h-5.55Zm-3.083,3.33a2.2,2.2,0,0,0,.308-1.11H22.754a2.2,2.2,0,0,0,.309,1.11Zm14.738,0a1.11,1.11,0,0,1-1.11-1.11h2.22A1.11,1.11,0,0,1,24.974,108.7Zm3.573-8.879,2.664,2.22H25.973a.555.555,0,0,1-.427-.2l-1.682-2.02h4.683Zm-8.567,5.55h5.55v-1.11h-5.55V97.6h3.693a6.118,6.118,0,0,1,3.508,1.11H23.864a1.11,1.11,0,0,0-.852,1.82l1.685,2.02a1.661,1.661,0,0,0,1.277.6h6.049a2.439,2.439,0,0,1-2.3,3.33H19.979Zm-1.11-7.77v6.66h-5.55V97.6Z" transform="translate(0 -96.488)" fill="#3c4b5a" />
												</svg></span><span class="text"><span>Электричка</span></span></label>
										</div>
									<?endif;
						      endforeach;?>
								</div>

							</div>
						</div>

						<div class="order-sm-4 col-sm-4 order-md-3 order-lg-5 order-xl-4 col-md-3 col-lg-2">
							<div class="extra-options__parameters-title">Природа</div>
							<div class="extra-options__parameters-input">
								<div class="hide">
									<?foreach($arResult["ITEMS"][202]["VALUES"] as $val => $ar): //dump($ar); // Водоем
					        if($ar["URL_ID"] != 'no'):?>
				          <input
				            type="checkbox"
				            value="<? echo $ar["HTML_VALUE"] ?>"
				            name="<? echo $ar["CONTROL_NAME"] ?>"
				            id="<? echo $ar["CONTROL_ID"] ?>"
				            <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
				            onclick="smartFilter.click(this)"
				          /> <?=$ar["VALUE"];?>
					      <?endif;
					      endforeach;?></div>
								<input class="sr-only iconDouble" type="checkbox" id="vodoem" data-id1="<?=$arResult["ITEMS"][202]["VALUES"][293]["CONTROL_ID"]?>" data-id2="<?=$arResult["ITEMS"][202]["VALUES"][294]["CONTROL_ID"]?>" data-id3="<?=$arResult["ITEMS"][202]["VALUES"][295]["CONTROL_ID"]?>">
								<label class="d-flex w-100 align-items-center" for="vodoem"><span class="icon icon--vodoem">
									<svg xmlns="http://www.w3.org/2000/svg" width="23.111" height="14.182" viewBox="0 0 23.111 14.182" class="inline-svg">
										<g transform="translate(0 -98.909)">
											<g transform="translate(0 98.909)">
												<g>
													<path d="M20.686,100.11a5.278,5.278,0,0,0-6.7,0,3.561,3.561,0,0,1-2.425.9,3.561,3.561,0,0,1-2.426-.9,5.078,5.078,0,0,0-3.352-1.2,5.078,5.078,0,0,0-3.352,1.2,3.561,3.561,0,0,1-2.426.9V103.9a3.561,3.561,0,0,0,2.426-.9,5.078,5.078,0,0,1,3.352-1.2A5.078,5.078,0,0,1,9.13,103a3.561,3.561,0,0,0,2.426.9,3.561,3.561,0,0,0,2.425-.9,5.278,5.278,0,0,1,6.7,0,3.561,3.561,0,0,0,2.425.9V101.01A3.561,3.561,0,0,1,20.686,100.11Z"
														transform="translate(0 -98.909)" class="color-fill" />
												</g>
											</g>
											<g transform="translate(0 108.101)">
												<g>
													<path d="M19.759,303.446a3.719,3.719,0,0,0-4.851,0,5.077,5.077,0,0,1-3.352,1.2,5.078,5.078,0,0,1-3.352-1.2,3.562,3.562,0,0,0-2.426-.9,3.561,3.561,0,0,0-2.426.9A5.078,5.078,0,0,1,0,304.647v2.889a5.078,5.078,0,0,0,3.352-1.2,3.561,3.561,0,0,1,2.426-.9,3.561,3.561,0,0,1,2.426.9,5.078,5.078,0,0,0,3.352,1.2,5.077,5.077,0,0,0,3.352-1.2,3.719,3.719,0,0,1,4.851,0,5.077,5.077,0,0,0,3.352,1.2v-2.889A5.077,5.077,0,0,1,19.759,303.446Z"
														transform="translate(0 -302.546)" class="color-fill" />
												</g>
											</g>
											<g transform="translate(0 103.374)">
												<g>
													<path d="M19.759,198.718a3.719,3.719,0,0,0-4.851,0,5.077,5.077,0,0,1-3.352,1.2,5.078,5.078,0,0,1-3.352-1.2,3.561,3.561,0,0,0-2.426-.9,3.561,3.561,0,0,0-2.426.9A5.077,5.077,0,0,1,0,199.919v3.152a3.561,3.561,0,0,0,2.426-.9,5.078,5.078,0,0,1,3.352-1.2,5.078,5.078,0,0,1,3.352,1.2,3.561,3.561,0,0,0,2.426.9,3.561,3.561,0,0,0,2.425-.9,5.278,5.278,0,0,1,6.7,0,3.561,3.561,0,0,0,2.425.9v-3.152A5.077,5.077,0,0,1,19.759,198.718Z"
														transform="translate(0 -197.818)" class="color-fill" />
												</g>
											</g>
										</g>
									</svg></span><span class="text"><span>Водоем</span></span></label>
							</div>
							<div class="extra-options__parameters-input">
								<div class="hide">
									<?foreach($arResult["ITEMS"][203]["VALUES"] as $val => $ar): //dump($ar); // Лес
					        if($ar["URL_ID"] != 'no'):?>
				          <input
				            type="checkbox"
				            value="<? echo $ar["HTML_VALUE"] ?>"
				            name="<? echo $ar["CONTROL_NAME"] ?>"
				            id="<? echo $ar["CONTROL_ID"] ?>"
				            <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
				            onclick="smartFilter.click(this)"
				          /> <?=$ar["VALUE"];?> лес
					      <?endif;
					      endforeach;?></div>
								<input class="sr-only iconDouble" type="checkbox" id="les" data-id1="<?=$arResult["ITEMS"][203]["VALUES"][296]["CONTROL_ID"]?>" data-id2="<?=$arResult["ITEMS"][203]["VALUES"][297]["CONTROL_ID"]?>" data-id3="<?=$arResult["ITEMS"][203]["VALUES"][298]["CONTROL_ID"]?>" data-id4="<?=$arResult["ITEMS"][203]["VALUES"][299]["CONTROL_ID"]?>">
								<label class="d-flex w-100 align-items-center" for="les"><span class="icon icon--les">
									<svg xmlns="http://www.w3.org/2000/svg" width="17.38" height="24.833" viewBox="0 0 17.38 24.833" class="inline-svg">
										<path d="M72.266,7.657a4.88,4.88,0,0,0-.51-.475,2.01,2.01,0,0,0-1.871-2.747c-.065,0-.13,0-.194.009a4.838,4.838,0,0,0-8.9-2.2,3.412,3.412,0,0,0-3.306,5.4l-.012.013a4.841,4.841,0,0,0,3.549,8.133,4.93,4.93,0,0,0,.743-.056l1.787,2.76-.871,5.642a.6.6,0,0,0,.133.486.623.623,0,0,0,.476.211h3.186a.623.623,0,0,0,.476-.211.6.6,0,0,0,.133-.486l-.856-5.547,1.84-2.842a4.932,4.932,0,0,0,.652.044,4.841,4.841,0,0,0,3.549-8.133Zm-7.349,9.29-1.254-1.938a4.829,4.829,0,0,0,1.2-1.123,4.826,4.826,0,0,0,1.275,1.167Z"
											transform="translate(-56.177)" class="color-fill" />
									</svg></span><span class="text"><span>Лес</span></span></label>
							</div>
							<?foreach($arResult["ITEMS"][204]["VALUES"] as $val => $ar): //dump($ar); // Пляж для купания
				        if($ar["URL_ID"] == 'y'):?>
								<div class="extra-options__parameters-input">
									<input
				            type="checkbox"
										class="sr-only"
				            value="<? echo $ar["HTML_VALUE"] ?>"
				            name="<? echo $ar["CONTROL_NAME"] ?>"
				            id="<? echo $ar["CONTROL_ID"] ?>"
				            <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
				            onclick="smartFilter.click(this)"
				          />
									<label class="d-flex w-100 align-items-center <? echo $ar["DISABLED"] ? 'disabled': '' ?>" data-role="label_<?=$ar["CONTROL_ID"]?>" for="<? echo $ar["CONTROL_ID"] ?>"><span class="icon icon--plyaj">
										<svg xmlns="http://www.w3.org/2000/svg" width="21.889" height="21.799" viewBox="0 0 21.889 21.799" class="inline-svg">
											<g transform="translate(0 -0.093)">
												<path d="M21.565,18.948a.947.947,0,0,0-.744-.229,25.544,25.544,0,0,1-4.17.2,11.6,11.6,0,0,1-3-.558L10.325,8.835a37.7,37.7,0,0,1,7.317-1.6.943.943,0,0,0,.734-1.372A9.638,9.638,0,0,0,7.571.953L7.491.725A.942.942,0,0,0,6.29.146L6.274.151a.943.943,0,0,0-.579,1.2l.079.228A9.636,9.636,0,0,0,.368,12.113a.943.943,0,0,0,1.44.615A34.44,34.44,0,0,1,8.528,9.46l2.8,8.012c-2.261-.958-4.424-1.961-7.28-1.526A6.96,6.96,0,0,0,.237,18.28.95.95,0,0,0,0,18.9V20.95a.946.946,0,0,0,.947.943H20.942a.947.947,0,0,0,.948-.943v-1.3A.952.952,0,0,0,21.565,18.948Z"
													class="color-fill" />
											</g>
										</svg></span><span class="text"><span>Пляж</span></span></label>
								</div>
							<?endif;
				      endforeach;?>
						</div>

					</div>
				</div>
			</div>
			<div class="order-3 order-lg-6 col-12 mt-4 pt-1">
				<div class="d-flex flex-wrap justify-content-start">
					<input class="btn btn-lg btn-warning mr-4" type="submit" id="set_filter" name="set_filter" value="Подобрать" disabled>
					<input type="submit" id="set_dop_filter" name="set_dop_filter" value="Подобрать" class="hide" disabled>
					<button class="btn btn-link filter__button-clear p-0" type="reset" id="del_filter" name="del_filter" onclick="smartFilter.click(this)">
						<svg xmlns="http://www.w3.org/2000/svg" width="12.669" height="12.669" viewBox="0 0 12.669 12.669" class="inline-svg">
							<path d="M12.24 2.5L8.4 6.336l3.839 3.839a1.462 1.462 0 1 1-2.067 2.068L6.334 8.4 2.5 12.242a1.462 1.462 0 0 1-2.072-2.067l3.839-3.839L.428 2.5A1.462 1.462 0 0 1 2.495.43l3.839 3.839L10.173.43A1.462 1.462 0 0 1 12.24 2.5z" />
						</svg>Сбросить фильтр
					</button>
				</div>
			</div>
		</div>

		<!-- Модальное окно Шоссе-->
		<div class="modal" id="highwayModal" tabindex="-1" role="dialog" aria-labelledby="highwayModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-xl" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <div class="d-flex w-100 justify-content-between align-items-center">
		          <div class="text-uppercase chart" id="highwayModalLabel">Шоссе</div>
		          <button class="close btn-sm" type="button" data-dismiss="modal" aria-label="Close">
								<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd" clip-rule="evenodd" d="M15.0044 14.8471C15.3949 14.4566 15.3949 13.8235 15.0044 13.4329L9.34785 7.77641L15.0045 2.11975C15.395 1.72923 15.395 1.09606 15.0045 0.705538C14.614 0.315014 13.9808 0.315014 13.5903 0.705538L7.93364 6.3622L2.27644 0.705003C1.88592 0.314478 1.25275 0.314478 0.862229 0.705003C0.471705 1.09553 0.471705 1.72869 0.862229 2.11922L6.51942 7.77641L0.862379 13.4335C0.471855 13.824 0.471855 14.4571 0.862379 14.8477C1.2529 15.2382 1.88607 15.2382 2.27659 14.8477L7.93364 9.19063L13.5901 14.8471C13.9807 15.2377 14.6138 15.2377 15.0044 14.8471Z" fill="#808080"/>
								</svg>
		          </button>
		        </div>
		      </div>
		      <div class="modal-body">
		        <div class="row">
							<? // переберем шоссе
		          $arShosse['sever']['NAME'] = 'Север';
		          $arShosse['sever-vostok']['NAME'] = 'Северо-Восток';
		          $arShosse['sever-zapad']['NAME'] = 'Северо-Запад';
		          $arShosse['ug']['NAME'] = 'Юг';
		          $arShosse['ug-vostok']['NAME'] = 'Юго-Восток';
		          $arShosse['ug-zapad']['NAME'] = 'Юго-Запад';
		          $arShosse['vostok']['NAME'] = 'Восток';
		          $arShosse['zapad']['NAME'] = 'Запад';
		          $arShosse['other']['NAME'] = 'Другие';

		          foreach($arResult["ITEMS"][PLOTS_PROP_SHOSSE]["VALUES"] as $val => $ar){
		            // echo $ar['VALUE'].' - '.$ar['URL_ID'].'<br>';
								if (PLOTS_PROP_SHOSSE == 369) // СПБ
								{
									switch ($ar['URL_ID']) {
										case 'primorskoe':
												$arShosse['sever-zapad']['SHOSSE'][] = $ar;
												break;
										case 'zsd':
												$arShosse['sever-zapad']['SHOSSE'][] = $ar;
												break;
										case 'beloostrovskoe':
												$arShosse['sever-zapad']['SHOSSE'][] = $ar;
												break;
										case 'aleksandrovskoe':
												$arShosse['sever-zapad']['SHOSSE'][] = $ar;
												break;

										case 'vyborgskoe':
												$arShosse['sever']['SHOSSE'][] = $ar;
												break;
										case 'gorskoe':
												$arShosse['sever']['SHOSSE'][] = $ar;
												break;
										case 'novopriozerskoe':
												$arShosse['sever']['SHOSSE'][] = $ar;
												break;
										case 'priozerskoe':
												$arShosse['sever']['SHOSSE'][] = $ar;
												break;

										case 'ryabovskoe':
												$arShosse['sever-vostok']['SHOSSE'][] = $ar;
												break;
										case 'doroga-zhizni':
												$arShosse['sever-vostok']['SHOSSE'][] = $ar;
												break;

										case 'murmanskoe':
												$arShosse['vostok']['SHOSSE'][] = $ar;
												break;
										case 'petrozavodskoe':
												$arShosse['vostok']['SHOSSE'][] = $ar;
												break;

										case 'moskovskoe':
												$arShosse['ug-vostok']['SHOSSE'][] = $ar;
												break;

										case 'kievskoe':
												$arShosse['ug']['SHOSSE'][] = $ar;
												break;
										case 'pulkovskoe':
												$arShosse['ug']['SHOSSE'][] = $ar;
												break;
										case 'volkhonskoe':
												$arShosse['ug']['SHOSSE'][] = $ar;
												break;

										case 'e20':
												$arShosse['ug-zapad']['SHOSSE'][] = $ar;
												break;
										case 'ropshinskoe':
												$arShosse['ug-zapad']['SHOSSE'][] = $ar;
												break;
										case 'anninskoe':
												$arShosse['ug-zapad']['SHOSSE'][] = $ar;
												break;
										case 'gatchinskoe':
												$arShosse['ug-zapad']['SHOSSE'][] = $ar;
												break;
										case 'krasnoselskoe':
												$arShosse['ug-zapad']['SHOSSE'][] = $ar;
												break;

										case 'levashovskoe':
												$arShosse['zapad']['SHOSSE'][] = $ar;
												break;
										case 'gostilitskoe':
												$arShosse['zapad']['SHOSSE'][] = $ar;
												break;

										default:
												$arShosse['other']['SHOSSE'][] = $ar;
												break;
									}
								}
								else
								{
			            switch ($ar['URL_ID']) {
			              case 'dmitrovskoe': $arShosse['sever']['SHOSSE'][] = $ar; break;
			              case 'rogachevskoe': $arShosse['sever']['SHOSSE'][] = $ar; break;
			              case 'leningradskoe': $arShosse['sever']['SHOSSE'][] = $ar; break;
			              case 'yaroslavskoe': $arShosse['sever-vostok']['SHOSSE'][] = $ar; break;
			              case 'novorijskoe': $arShosse['sever-zapad']['SHOSSE'][] = $ar; break;
			              case 'pyatnickoe': $arShosse['sever-zapad']['SHOSSE'][] = $ar; break;
			              case 'volokolamskoe': $arShosse['sever-zapad']['SHOSSE'][] = $ar; break;
			              case 'varshavskoe': $arShosse['ug']['SHOSSE'][] = $ar; break;
			              case 'simferopolskoe': $arShosse['ug']['SHOSSE'][] = $ar; break;
			              case 'egorievskoe': $arShosse['ug-vostok']['SHOSSE'][] = $ar; break;
			              case 'kashirskoe': $arShosse['ug']['SHOSSE'][] = $ar; break;
			              case 'novoryazanskoe': $arShosse['ug-vostok']['SHOSSE'][] = $ar; break;
			              case 'kievskoe': $arShosse['ug-zapad']['SHOSSE'][] = $ar; break;
			              case 'kalujskoe': $arShosse['ug-zapad']['SHOSSE'][] = $ar; break;
			              case 'shelkovskoe': $arShosse['vostok']['SHOSSE'][] = $ar; break;
			              case 'gorkovskoe': $arShosse['vostok']['SHOSSE'][] = $ar; break;
			              case 'nosovihinskoe': $arShosse['vostok']['SHOSSE'][] = $ar; break;
			              case 'minskoe': $arShosse['zapad']['SHOSSE'][] = $ar; break;
			              case 'rublevo-uspenskoe': $arShosse['zapad']['SHOSSE'][] = $ar; break;
			              case 'mozhayskoe': $arShosse['zapad']['SHOSSE'][] = $ar; break;
			              default: $arShosse['other']['SHOSSE'][] = $ar; break;
			            }
								}
		          }?>
							<?foreach ($arShosse as $key => $value) {?>
								<div class="col-sm-6 col-lg-4 mb-4">
			            <div class="highway-block__title chart"><?=$value['NAME']?></div>
									<?foreach($value['SHOSSE'] as $val => $ar): //dump($ar); // Шоссе?>
										<div class="custom-control custom-checkbox custom-control-inline align-items-center">
											<input
												type="checkbox"
												value="<? echo $ar["HTML_VALUE"] ?>"
												name="<? echo $ar["CONTROL_NAME"] ?>"
												id="<? echo $ar["CONTROL_ID"] ?>"
												<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
												onclick="smartFilter.click(this)"
												class="custom-control-input changeHighway"
											/>
		                	<label class="custom-control-label <? echo $ar["DISABLED"] ? 'disabled': '' ?>" data-role="label_<?=$ar["CONTROL_ID"]?>" for="<? echo $ar["CONTROL_ID"] ?>"><?=$ar["VALUE"];?></label>
										</div>
		              <?endforeach;?>
			          </div>
		          <?}?>
		          <div class="col-12">
		            <button class="btn btn-warning" type="button" data-dismiss="modal" aria-label="Закрыть">Готово</button>
		          </div>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- Модальное окно Районов-->
		<div class="modal fade" id="regionModal" tabindex="-1" role="dialog" aria-labelledby="regionModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <div class="d-flex w-100 justify-content-between align-items-center">
		          <div class="text-uppercase chart" id="regionModalLabel">Район</div>
		          <button class="close btn-sm" type="button" data-dismiss="modal" aria-label="Close">
								<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd" clip-rule="evenodd" d="M15.0044 14.8471C15.3949 14.4566 15.3949 13.8235 15.0044 13.4329L9.34785 7.77641L15.0045 2.11975C15.395 1.72923 15.395 1.09606 15.0045 0.705538C14.614 0.315014 13.9808 0.315014 13.5903 0.705538L7.93364 6.3622L2.27644 0.705003C1.88592 0.314478 1.25275 0.314478 0.862229 0.705003C0.471705 1.09553 0.471705 1.72869 0.862229 2.11922L6.51942 7.77641L0.862379 13.4335C0.471855 13.824 0.471855 14.4571 0.862379 14.8477C1.2529 15.2382 1.88607 15.2382 2.27659 14.8477L7.93364 9.19063L13.5901 14.8471C13.9807 15.2377 14.6138 15.2377 15.0044 14.8471Z" fill="#808080"/>
								</svg>
		          </button>
		        </div>
		      </div>
		      <div class="modal-body">
		        <div class="row">
							<? // Группируем районы по первым буквам названий
			        $prevLetter = '';
			        foreach ($arResult["ITEMS"][PLOTS_PROP_REGION]["VALUES"] as $key => $value) {
			          $firstLetter = mb_strtoupper(mb_substr($value['VALUE'], 0, 1));
			          if ($firstLetter != $prevLetter) $prevLetter = $firstLetter;
			          $arRegion[$firstLetter][] = $value;
			        } // dump($arRegion);?>
							<?foreach ($arRegion as $key => $value) {?>
								<div class="col-sm-6 col-lg-4 mb-4">
			            <div class="highway-block__title chart"><?=$key?></div>
									<?foreach($value as $val => $ar): //dump($ar); // Шоссе?>
										<div class="custom-control custom-checkbox custom-control-inline align-items-center">
											<input
												type="checkbox"
												value="<? echo $ar["HTML_VALUE"] ?>"
												name="<? echo $ar["CONTROL_NAME"] ?>"
												id="<? echo $ar["CONTROL_ID"] ?>"
												<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
												onclick="smartFilter.click(this)"
												class="custom-control-input changeAreas"
											/>
		                	<label class="custom-control-label <? echo $ar["DISABLED"] ? 'disabled': '' ?>" data-role="label_<?=$ar["CONTROL_ID"]?>" for="<? echo $ar["CONTROL_ID"] ?>"><?=$ar["VALUE"];?></label>
										</div>
		              <?endforeach;?>
			          </div>
		          <?}?>
		          <div class="col-12">
		            <button class="btn btn-warning" type="button" data-dismiss="modal" aria-label="Закрыть">Готово</button>
		          </div>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>

	</form>

<script type="text/javascript">
	var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>
