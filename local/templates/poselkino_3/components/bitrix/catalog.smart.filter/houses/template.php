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
							foreach ($arResult["ITEMS"][HOUSE_PROP_REGION]["VALUES"] as $val => $ar) //dump($ar); // Район
								if ($ar["CHECKED"]) $activeAreas = 'active';
						?>
				 		<a class="btn btn-outline-warning rounded-pill w-100 Areas <?=$activeAreas?>" href="#regionModal" data-toggle="modal" data-target="#regionModal">Районы МО</a>
				 	</div>

					<div class="filter__highway">
						<?$activeHighway = '';// ставим активность если надо
			       foreach($arResult["ITEMS"][HOUSE_PROP_SHOSSE]["VALUES"] as $val => $ar){ //dump($ar); // Шоссе
			        if ($ar["CHECKED"]) $activeHighway = 'active';
			       }?>
						<button class="btn btn-outline-warning rounded-pill Highway <?=$activeHighway?>" type="button" data-toggle="modal" data-target="#highwayModal">Шоссе</button>
					</div>

				</div>
			</div>
			<div class="order-1 col-xl-3 col-lg-4 col-sm-6 mt-4 mt-sm-0">
				<div class="filter__mkad">
					<div class="form-group form-group-inline justify-content-sm-end justify-content-lg-start">
						<?$arItem = $arResult["ITEMS"][386]; //dump($arItem); // Удаленность от МКАД
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
							$arItem = $arResult["ITEMS"][148]; // dump($arItem); // Цена
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
							$arItem = $arResult["ITEMS"][146]; //dump($arItem); // Площадь дома
				      $placeholderMin = ($arItem["VALUES"]["MIN"]["HTML_VALUE"]) ? $arItem["VALUES"]["MIN"]["HTML_VALUE"]: 'от';
				      $placeholderMax = ($arItem["VALUES"]["MAX"]["HTML_VALUE"]) ? $arItem["VALUES"]["MAX"]["HTML_VALUE"]: 'до';
						?>
						<label>Площадь, м<sup>2</sup></label>
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
						<div class="col-lg-12 mt-40">
							<div class="d-flex align-items-center flex-wrap">
								<?foreach($arResult["ITEMS"][145]["VALUES"] as $val => $ar): //dump($ar); // Этап строительства?>
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
								<?foreach($arResult["ITEMS"][144]["VALUES"] as $val => $ar): //dump($ar); // Отделка
						      // if($ar["URL_ID"] == 'dacha')$ar["VALUE"] = 'Дачный';
						      // if($ar["URL_ID"] == 'cottage')$ar["VALUE"] = 'ИЖС';
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
								<?foreach($arResult["ITEMS"][184]["VALUES"] as $val => $ar): //dump($ar); // Рассрочка?>
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
										<label class="custom-control-label <? echo $ar["DISABLED"] ? 'disabled': '' ?>" data-role="label_<?=$ar["CONTROL_ID"]?>" for="<? echo $ar["CONTROL_ID"] ?>">Рассрочка</label>
									</div>
								<?endforeach;?>
							</div>
						</div>
					</div>
					<div class="row extra-options__parameters mt-4">
						<div class="col-12">
								<div class="d-flex flex-wrap">
										<? foreach ($arResult["ITEMS"][143]["VALUES"] as $val => $ar): //dump($ar); // Материал домов?>
												<div class="checkbox-house">
														<input
																		type="checkbox"
																		value="<? echo $ar["HTML_VALUE"] ?>"
																		name="<? echo $ar["CONTROL_NAME"] ?>"
																		id="<? echo $ar["CONTROL_ID"] ?>"
																<? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
																		onclick="smartFilter.click(this)"
																		class="sr-only"
														/>
														<label class="radio <? echo $ar["DISABLED"] ? 'disabled' : '' ?>"
																	 data-role="label_<?= $ar["CONTROL_ID"] ?>"
																	 for="<? echo $ar["CONTROL_ID"] ?>"><?= $ar["VALUE"]; ?></label>
												</div>
										<? endforeach; ?>
								</div>
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

		          foreach($arResult["ITEMS"][HOUSE_PROP_SHOSSE]["VALUES"] as $val => $ar){
		            // echo $ar['VALUE'].' - '.$ar['URL_ID'].'<br>';
								if (HOUSE_PROP_SHOSSE == 369) // СПБ
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
			        foreach ($arResult["ITEMS"][HOUSE_PROP_REGION]["VALUES"] as $key => $value) {
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
