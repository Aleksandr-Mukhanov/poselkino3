<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
<form class="row hero__form" name="<? echo $arResult["FILTER_NAME"] . "_form" ?>"
      action="<? echo $arResult["FORM_ACTION"] ?>" method="get">
    <? foreach ($arResult["HIDDEN"] as $arItem): ?>
        <input type="hidden" name="<? echo $arItem["CONTROL_NAME"] ?>" id="<? echo $arItem["CONTROL_ID"] ?>"
               value="<? echo $arItem["HTML_VALUE"] ?>"/>
    <? endforeach; ?>
    <div class="form-wrap">
        <div class="col-6 col-sm-4 col-md-2 col-xl-2 pr-2 pr-xl-3 col-type">
            <div class="hide">
                <? foreach ($arResult["ITEMS"][2]["VALUES"] as $val => $ar): // dump($ar); // Наличие домов?>
                    <input
                            type="checkbox"
                            value="<? echo $ar["HTML_VALUE"] ?>"
                            name="<? echo $ar["CONTROL_NAME"] ?>"
                            id="<? echo $ar["CONTROL_ID"] ?>"
                        <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                            onclick="smartFilter.click(this)"
                    /> <?= $ar["VALUE"]; ?>
                <? endforeach; ?>
            </div>
            <select id="filter-type" class="select-bg-white changeTypeSelect">
                <option value="" id="allTypeSelect">Все</option>
                <option class="house-modal"
                        value="arrFilter_2_4088798008" <? if ($arResult["ITEMS"][2]["VALUES"][4]['CHECKED']) echo "selected"; ?>>
                    Дом
                </option>
                <option value="arrFilter_2_1842515611" <? if ($arResult["ITEMS"][2]["VALUES"][3]['CHECKED']) echo "selected"; ?>>
                    Участок
                </option>
            </select>
        </div>
        <div class="col-6 col-sm-5 col-md-2 col-xl-1 pl-2 pl-xl-3 pr-xl-0">
            <? $activeHighway = '';// ставим активность если надо
            foreach ($arResult["ITEMS"][5]["VALUES"] as $val => $ar) { //dump($ar); // Шоссе
                if ($ar["CHECKED"]) $activeHighway = 'active';
            } ?>
            <button class="btn btn-outline-warning btn-highway rounded-pill w-100 Highway <?= $activeHighway ?>" type="button"
                    data-toggle="modal" data-target="#highwayModal">Шоссе
            </button>
        </div>
        <div class="col-12 col-sm-4 col-md-3 col-xl-3 col-inline">
            <? $arItem = $arResult["ITEMS"][6]; //dump($arItem); // Удаленность от МКАД
            $placeholderMin = ($arItem["VALUES"]["MIN"]["HTML_VALUE"]) ? $arItem["VALUES"]["MIN"]["HTML_VALUE"] : 'От';
            $placeholderMax = ($arItem["VALUES"]["MAX"]["HTML_VALUE"]) ? $arItem["VALUES"]["MAX"]["HTML_VALUE"] : 'До'; ?>
            <div class="form-group form-group-inline">
                <label>от <?=ROAD?>, км</label>
            </div>
            <div class="row">
                <div class="col-6 pr-2">
                    <input
                            placeholder="<?= $placeholderMin ?>"
                            data-min-val='<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>'
                            data-max-val='<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>'
                            type="text"
                            class="form-control km"
                            name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                            id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                            value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                            onkeyup="smartFilter.keyup(this)"
                    />
                </div>
                <div class="col-6 pl-2">
                    <input
                            placeholder="<?= $placeholderMax ?>"
                            data-min-val='<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>'
                            data-max-val='<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>'
                            type="text"
                            class="form-control km mr-0"
                            name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                            id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                            value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                            onkeyup="smartFilter.keyup(this)"
                    />
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4 col-md-3 col-xl-4 col-inline">
            <div class="form-group form-group-inline">
                <label>
                    Стоимость, <span class="rub">a</span>
                </label>
            </div>
            <div class="cost_land">
                <div class="row">
                    <? // $arItem = $arResult["ITEMS"][13]; //dump($arItem); // Стоимость в фильтр
                    $arItem = $arResult["ITEMS"][120]; // dump($arItem); // Стоимость участка (в карточку)
                    $placeholderMin = ($arItem["VALUES"]["MIN"]["HTML_VALUE"]) ? $arItem["VALUES"]["MIN"]["HTML_VALUE"] : 'От';
                    $placeholderMax = ($arItem["VALUES"]["MAX"]["HTML_VALUE"]) ? $arItem["VALUES"]["MAX"]["HTML_VALUE"] : 'До';
                    ?>
                    <div class="col-6 pr-2">
                        <input
                                placeholder="<?= $placeholderMin ?>"
                                data-min-val='<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>'
                                data-max-val='<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>'
                                type="text"
                                class="form-control"
                                name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                value="<? if ($arItem["VALUES"]["MIN"]["HTML_VALUE"]) echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                onkeyup="smartFilter.keyup(this)"
                        />
                    </div>
                    <div class="col-6 pl-2">
                        <input
                                placeholder="<?= $placeholderMax ?>"
                                data-min-val='<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>'
                                data-max-val='<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>'
                                type="text"
                                class="form-control"
                                name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                value="<? if ($arItem["VALUES"]["MAX"]["HTML_VALUE"]) echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                onkeyup="smartFilter.keyup(this)"
                        />
                    </div>
                </div>
            </div>
            <div class="cost_home">
                <div class="row">
                    <? // Стоимость домов
                    $arItem = $arResult["ITEMS"][17]; // dump($arItem);
                    $placeholderMin = ($arItem["VALUES"]["MIN"]["HTML_VALUE"]) ? $arItem["VALUES"]["MIN"]["HTML_VALUE"] : 'От';
                    $placeholderMax = ($arItem["VALUES"]["MAX"]["HTML_VALUE"]) ? $arItem["VALUES"]["MAX"]["HTML_VALUE"] : 'До';
                    ?>
                    <div class="col-6 pr-2">
                        <input
                                placeholder="<?= $placeholderMin ?>"
                                data-min-val='<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>'
                                data-max-val='<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>'
                                type="text"
                                class="form-control"
                                name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                value="<? if ($arItem["VALUES"]["MIN"]["HTML_VALUE"]) echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                onkeyup="smartFilter.keyup(this)"
                        />
                    </div>
                    <div class="col-6 pl-2">
                        <input
                                placeholder="<?= $placeholderMax ?>"
                                data-min-val='<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>'
                                data-max-val='<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>'
                                type="text"
                                class="form-control"
                                name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                value="<? if ($arItem["VALUES"]["MAX"]["HTML_VALUE"]) echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                onkeyup="smartFilter.keyup(this)"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4 col-md-2 pl-sm-0">
            <input class="btn btn-warning w-100" type="submit" id="set_filter" name="set_filter" value="Подобрать"
                   disabled>
        </div>
    </div>
    <div class="col-12">
        <button class="w-100 btn btn-secondary other-parameters rounded-pill" type="button" data-toggle="modal"
                data-target="#searchParamsModal">Дополнительные параметры
        </button>
    </div>
    <!-- Модальное окно с доп. параметрами-->
    <div class="modal" id="searchParamsModal" tabindex="-1" role="dialog" aria-labelledby="searchParamsModalLabelTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-xxl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <div class="text-uppercase chart" id="searchParamsModalLabelTitle">Дополнительные параметры
                        </div>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="filter row">
                        <div class="col-xl-3 col-lg-4 col-sm-6 mt-4 mt-md-0">
                            <div class="filter__size d-flex">
                                <div class="form-group form-group-inline mr-lg-0">
                                    <? $arItem = $arResult["ITEMS"][11]; //dump($arItem); // Площадь участка
                                    $placeholderMin = ($arItem["VALUES"]["MIN"]["HTML_VALUE"]) ? $arItem["VALUES"]["MIN"]["HTML_VALUE"] : 'от';
                                    $placeholderMax = ($arItem["VALUES"]["MAX"]["HTML_VALUE"]) ? $arItem["VALUES"]["MAX"]["HTML_VALUE"] : 'до'; ?>
                                    <label>Участок, сот.</label>
                                    <input
                                            placeholder="<?= $placeholderMin ?>"
                                            data-min-val='<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>'
                                            data-max-val='<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>'
                                            type="text"
                                            class="form-control"
                                            name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                            id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                            value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                            onkeyup="smartFilter.keyup(this)"
                                    />
                                    <input
                                            placeholder="<?= $placeholderMax ?>"
                                            data-min-val='<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>'
                                            data-max-val='<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>'
                                            type="text"
                                            class="form-control"
                                            name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                            id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                            value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                            onkeyup="smartFilter.keyup(this)"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="order-3 col-12">
                            <div class="extra-options">
                                <div class="row align-items-end">
                                    <div class="col-xl-7 col-lg-6 col-md-5 mt-40">
                                        <div class="d-flex align-items-center search-group" itemscope
                                             itemtype="https://schema.org/WebSite">
                                            <meta itemprop="url" content="https://poselkino.ru/">
                                            <div class="input-group" itemprop="potentialAction" itemscope
                                                 itemtype="https://schema.org/SearchAction">
                                                <meta itemprop="target"
                                                      content="https://poselkino.ru/poisk/?q={search_term_string}">
                                                <label class="d-flex" for="searchWord">Поиск&nbsp;<br>по ключевым словам</label>
                                                <input itemprop="query-input" class="form-control" id="searchWord"
                                                       type="text" name="search_term_string">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-success" type="button"
                                                            id="searchButton">Поиск
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <? $activeAreas = '';// ставим активность если надо
                                    foreach ($arResult["ITEMS"][4]["VALUES"] as $val => $ar) { //dump($ar); // Шоссе
                                        if ($ar["CHECKED"]) $activeAreas = 'active';
                                    } ?>
                                    <div class="col-xl-2 col-lg-2 col-md-2 mt-4 mt-lg-0"><a
                                                class="btn btn-outline-warning rounded-pill w-100 Areas <?= $activeAreas ?>"
                                                href="#regionModal" data-toggle="modal" data-target="#regionModal">Районы
                                            МО</a></div>
                                    <div class="col-xl-3 col-lg-4 mt-40 col-md-5">
                                        <div class="d-flex align-items-center justify-content-md-end search-group distance-station">
                                            <label class="d-flex mr-2"
                                                   for="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>">Расстояние&nbsp;<br>до
                                                ближайшей станции</label>
                                            <? $arItem = $arResult["ITEMS"][71]; //dump($arItem); // Ближайший город расстояние, км?>
                                            <input
                                                    data-min-val='<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>'
                                                    data-max-val='<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>'
                                                    type="text"
                                                    class="form-control distance-station"
                                                    name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                                    id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                                    value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                                    onkeyup="smartFilter.keyup(this)"
                                            />
                                            <b class="distance-station-km">Км</b>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-8 mt-40">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <?/* foreach ($arResult["ITEMS"][1]["VALUES"] as $val => $ar): //dump($ar); // Тип поселка
                                                if ($ar["URL_ID"] == 'dacha') $ar["VALUE"] = 'Дачный';
                                                if ($ar["URL_ID"] == 'cottage') $ar["VALUE"] = 'ИЖС';
                                                ?>
                                                <div class="custom-control custom-checkbox custom-control-inline align-items-center h-100">
                                                    <input
                                                            type="checkbox"
                                                            class="custom-control-input"
                                                            value="<? echo $ar["HTML_VALUE"] ?>"
                                                            name="<? echo $ar["CONTROL_NAME"] ?>"
                                                            id="<? echo $ar["CONTROL_ID"] ?>"
                                                        <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                            onclick="smartFilter.click(this)"
                                                    />
                                                    <label class="custom-control-label <? echo $ar["DISABLED"] ? 'disabled' : '' ?>"
                                                           data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                                           for="<? echo $ar["CONTROL_ID"] ?>"><?= $ar["VALUE"]; ?></label>
                                                </div>
                                            <? endforeach; */?>
                                            <div class="custom-control custom-checkbox custom-control-inline align-items-center h-100">
                          						        <input
                          						          type="checkbox"
                          											class="custom-control-input"
                          						          value="dacha"
                          						          name="type_permitted"
                          						          id="dacha"
                          						          <? echo $arResult["ITEMS"][33]["VALUES"][108]["CHECKED"] ? 'checked="checked"' : '' ?>
                          						        />
                          							      <label class="custom-control-label" data-role="label_dacha" for="dacha">Дачный</label>
                          									</div>
                          									<div class="custom-control custom-checkbox custom-control-inline align-items-center h-100">
                          						        <input
                          						          type="checkbox"
                          											class="custom-control-input"
                          						          value="ihs"
                          						          name="type_permitted"
                          						          id="ihs"
                          						          <? echo $arResult["ITEMS"][33]["VALUES"][228]["CHECKED"] ? 'checked="checked"' : '' ?>
                          						        />
                          							      <label class="custom-control-label" data-role="label_ihs" for="ihs">ИЖС</label>
                          									</div>
                          									<div class="hide">
                          										<?foreach($arResult["ITEMS"][33]["VALUES"] as $val => $ar): // Вид разрешенного использования?>
                          							        <input
                          							          type="checkbox"
                          							          value="<? echo $ar["HTML_VALUE"] ?>"
                          							          name="<? echo $ar["CONTROL_NAME"] ?>"
                          							          id="<? echo $ar["CONTROL_ID"] ?>"
                          							          <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                          							          onclick="smartFilter.click(this)"
                          							        />
                          								    <?endforeach;?>
                          									</div>
                                            <? foreach ($arResult["ITEMS"][116]["VALUES"] as $val => $ar): //dump($ar); // Акция?>
                                                <div class="custom-control custom-checkbox custom-control-inline align-items-center h-100">
                                                    <input
                                                            type="checkbox"
                                                            class="custom-control-input"
                                                            value="<? echo $ar["HTML_VALUE"] ?>"
                                                            name="<? echo $ar["CONTROL_NAME"] ?>"
                                                            id="<? echo $ar["CONTROL_ID"] ?>"
                                                        <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                            onclick="smartFilter.click(this)"
                                                    />
                                                    <label class="custom-control-label <? echo $ar["DISABLED"] ? 'disabled' : '' ?>"
                                                           data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                                           for="<? echo $ar["CONTROL_ID"] ?>">Поселки с акциями</label>
                                                </div>
                                            <? endforeach; ?>
                                            <?foreach($arResult["ITEMS"][159]["VALUES"] as $val => $ar): //dump($ar); // Рассрочка?>
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
                            										<label class="custom-control-label <? echo $ar["DISABLED"] ? 'disabled': '' ?>" data-role="label_<?=$ar["CONTROL_ID"]?>" for="<? echo $ar["CONTROL_ID"] ?>">Доступна рассрочка</label>
                            									</div>
                            								<?endforeach;?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row extra-options__parameters">
                                    <div class="order-lg-1 col-md-3 col-lg-2 col-sm-4">
                                        <div class="extra-options__parameters-title">Коммуникация</div>
                                        <? foreach ($arResult["ITEMS"][20]["VALUES"] as $val => $ar): //dump($ar); // Электричество
                                            if ($ar["URL_ID"] == 'y'):?>
                                                <div class="extra-options__parameters-input">
                                                    <input
                                                            type="checkbox"
                                                            class="sr-only"
                                                            value="<? echo $ar["HTML_VALUE"] ?>"
                                                            name="<? echo $ar["CONTROL_NAME"] ?>"
                                                            id="<? echo $ar["CONTROL_ID"] ?>"
                                                        <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                            onclick="smartFilter.click(this)"
                                                    />
                                                    <label class="d-flex w-100 align-items-center <? echo $ar["DISABLED"] ? 'disabled' : '' ?>"
                                                           data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                                           for="<? echo $ar["CONTROL_ID"] ?>"><span
                                                                class="icon icon--svet">
														<svg xmlns="http://www.w3.org/2000/svg" width="23.032"
                                                             height="24" viewBox="0 0 23.032 24" class="inline-svg">
															<g transform="translate(-9.8)">
																<path d="M24.052,20.973v.7a1.112,1.112,0,0,1-.943,1.1l-.173.637A.793.793,0,0,1,22.17,24H20.457a.793.793,0,0,1-.765-.588l-.168-.637a1.117,1.117,0,0,1-.948-1.106v-.7a.674.674,0,0,1,.677-.677h4.123A.682.682,0,0,1,24.052,20.973Zm3.175-9.452a5.883,5.883,0,0,1-1.659,4.1,5.422,5.422,0,0,0-1.452,2.943.978.978,0,0,1-.968.825H19.479a.968.968,0,0,1-.963-.82,5.482,5.482,0,0,0-1.462-2.953,5.912,5.912,0,1,1,10.173-4.1Zm-5.244-3.58a.667.667,0,0,0-.667-.667,4.271,4.271,0,0,0-4.267,4.267.667.667,0,1,0,1.333,0,2.937,2.937,0,0,1,2.933-2.933A.664.664,0,0,0,21.983,7.941Zm-.667-4.272A.667.667,0,0,0,21.983,3V.667a.667.667,0,0,0-1.333,0V3A.667.667,0,0,0,21.316,3.669Zm-7.847,7.847a.667.667,0,0,0-.667-.667H10.467a.667.667,0,1,0,0,1.333H12.8A.664.664,0,0,0,13.469,11.516Zm18.7-.667H29.83a.667.667,0,1,0,0,1.333h2.336a.667.667,0,1,0,0-1.333ZM14.827,17.067l-1.654,1.654a.665.665,0,0,0,.938.943l1.654-1.654a.665.665,0,0,0-.938-.943Zm12.509-10.9A.666.666,0,0,0,27.8,5.97l1.654-1.654a.667.667,0,1,0-.943-.943L26.862,5.027a.665.665,0,0,0,0,.943A.677.677,0,0,0,27.336,6.163Zm-12.509-.2a.665.665,0,0,0,.938-.943L14.111,3.368a.667.667,0,1,0-.943.943ZM27.8,17.067a.667.667,0,1,0-.943.943l1.654,1.654a.665.665,0,1,0,.938-.943Z"
                                                                      class="color-fill"/>
															</g>
														</svg></span><span class="text"><span>Свет</span></span></label>
                                                </div>
                                            <?endif;
                                        endforeach; ?>
                                        <? foreach ($arResult["ITEMS"][26]["VALUES"] as $val => $ar): //dump($ar); // Водопровод
                                            if ($ar["URL_ID"] == 'y'):?>
                                                <div class="extra-options__parameters-input">
                                                    <input
                                                            type="checkbox"
                                                            class="sr-only"
                                                            value="<? echo $ar["HTML_VALUE"] ?>"
                                                            name="<? echo $ar["CONTROL_NAME"] ?>"
                                                            id="<? echo $ar["CONTROL_ID"] ?>"
                                                        <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                            onclick="smartFilter.click(this)"
                                                    />
                                                    <label class="d-flex w-100 align-items-center <? echo $ar["DISABLED"] ? 'disabled' : '' ?>"
                                                           data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                                           for="<? echo $ar["CONTROL_ID"] ?>"><span
                                                                class="icon icon--voda">
														<svg xmlns="http://www.w3.org/2000/svg" width="15.782"
                                                             height="22.051" viewBox="0 0 15.782 22.051"
                                                             class="inline-svg">
															<g transform="translate(-35.275 0)">
																<g transform="translate(35.275 0)">
																	<path d="M44.09.76c-.6-1.031-1.244-1-1.848,0-2.772,4.123-6.967,10.308-6.967,13.4a7.891,7.891,0,1,0,15.782,0C51.057,11.033,46.862,4.883,44.09.76Zm4.763,16.919a6.749,6.749,0,0,1-2.381,2.31.955.955,0,0,1-.924-1.671,4.705,4.705,0,0,0,1.706-1.635,4.634,4.634,0,0,0,.711-2.275.943.943,0,0,1,1.884.107A7.042,7.042,0,0,1,48.853,17.679Z"
                                                                          transform="translate(-35.275 0)"
                                                                          class="color-fill"/>
																</g>
															</g>
														</svg></span><span class="text"><span>Вода</span></span></label>
                                                </div>
                                            <?endif;
                                        endforeach; ?>
                                        <? foreach ($arResult["ITEMS"][23]["VALUES"] as $val => $ar): //dump($ar); // Газ
                                            if ($ar["URL_ID"] == 'y'):?>
                                                <div class="extra-options__parameters-input">
                                                    <input
                                                            type="checkbox"
                                                            class="sr-only"
                                                            value="<? echo $ar["HTML_VALUE"] ?>"
                                                            name="<? echo $ar["CONTROL_NAME"] ?>"
                                                            id="<? echo $ar["CONTROL_ID"] ?>"
                                                        <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                            onclick="smartFilter.click(this)"
                                                    />
                                                    <label class="d-flex w-100 align-items-center <? echo $ar["DISABLED"] ? 'disabled' : '' ?>"
                                                           data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                                           for="<? echo $ar["CONTROL_ID"] ?>"><span
                                                                class="icon icon--gaz">
														<svg xmlns="http://www.w3.org/2000/svg" width="17.883"
                                                             height="23.844" viewBox="0 0 17.883 23.844"
                                                             class="inline-svg">
															<g transform="translate(-64 0)">
																<g transform="translate(64 0)">
																	<path d="M81.832,13.96C81.559,10.4,79.9,8.176,78.442,6.209,77.09,4.389,75.922,2.817,75.922.5a.5.5,0,0,0-.27-.442.492.492,0,0,0-.516.038,12.633,12.633,0,0,0-4.663,6.739,22,22,0,0,0-.511,5.038c-2.026-.433-2.485-3.463-2.49-3.5A.5.5,0,0,0,66.764,8c-.106.051-2.607,1.322-2.753,6.4-.01.169-.011.338-.011.507a8.951,8.951,0,0,0,8.941,8.941.069.069,0,0,0,.02,0h.006A8.952,8.952,0,0,0,81.883,14.9C81.883,14.654,81.832,13.96,81.832,13.96Zm-8.89,8.889a3.086,3.086,0,0,1-2.98-3.175c0-.06,0-.12,0-.194a4.027,4.027,0,0,1,.314-1.577,1.814,1.814,0,0,0,1.64,1.188.5.5,0,0,0,.5-.5,9.937,9.937,0,0,1,.191-2.259,4.8,4.8,0,0,1,1.006-1.9,6.4,6.4,0,0,0,1.024,1.879,5.659,5.659,0,0,1,1.273,3.1c.006.085.013.171.013.263A3.086,3.086,0,0,1,72.941,22.849Z"
                                                                          transform="translate(-64 0)"
                                                                          class="color-fill"/>
																</g>
															</g>
														</svg></span><span class="text"><span>Газ</span></span></label>
                                                </div>
                                            <?endif;
                                        endforeach; ?>
                                    </div>
                                    <div class="order-lg-2 col-md-6 col-lg-3 col-xl-2 col-sm-8">
                                        <div class="extra-options__parameters-title mb-3">Дороги в поселке</div>
                                        <div class="row">
                                            <div class="col-sm-6 col-lg-12">
                                                <? $i = 0;
                                                foreach ($arResult["ITEMS"][77]["VALUES"] as $val => $ar): // dump($ar); // Дороги в поселке
                                                    if ($ar["URL_ID"] == 'no') continue;
                                                    else $icon = 'road-' . $ar["URL_ID"];
                                                    $iconSVG = file_get_contents('https://' . $_SERVER['HTTP_HOST'] . '/assets/img/svg/' . $icon . '.svg');
                                                    switch ($ar["URL_ID"]) {
                                                        case "asph_crumb":
                                                            $iconClass = 'asphkr';
                                                            break; // Асф. кр.
                                                        case "asphalt":
                                                            $iconClass = 'asphalt';
                                                            break; // Асфальт
                                                        case "plate":
                                                            $iconClass = 'betonniePliti';
                                                            break; // Бетонные плиты
                                                        case "brick":
                                                            $iconClass = 'bitiyKirpich';
                                                            break; // Битый кирпич
                                                        case "gravel":
                                                            $iconClass = 'gruntovka';
                                                            break; // Грунтовка
                                                        case "stone":
                                                            $iconClass = 'sheben';
                                                            break; // Щебень
                                                    }
                                                    $i++;
                                                    ?>
                                                    <div class="extra-options__parameters-input">
                                                        <input
                                                                type="checkbox"
                                                                class="sr-only"
                                                                value="<? echo $ar["HTML_VALUE"] ?>"
                                                                name="<? echo $ar["CONTROL_NAME"] ?>"
                                                                id="<? echo $ar["CONTROL_ID"] ?>"
                                                            <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                                onclick="smartFilter.click(this)"
                                                        />
                                                        <label class="d-flex w-100 align-items-center <? echo $ar["DISABLED"] ? 'disabled' : '' ?>"
                                                               data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                                               for="<? echo $ar["CONTROL_ID"] ?>">
                                                            <span class="icon icon--<?= $iconClass ?>"><?= $iconSVG ?></span>
                                                            <span class="text"><span><?= $ar["VALUE"]; ?></span></span>
                                                        </label>
                                                    </div>
                                                    <? if ($i == 3) echo '</div><div class="col-sm-6 col-lg-12">'; ?>
                                                <? endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-sm-5 col-sm-8 order-md-5 order-lg-3 col-md-6 col-lg-2">
                                        <div class="row">
                                            <div class="col-sm-6 col-lg-12">
                                                <div class="extra-options__parameters-title">Как добраться</div>
                                                <? foreach ($arResult["ITEMS"][66]["VALUES"] as $val => $ar): //dump($ar); // Автобус
                                                    if ($ar["URL_ID"] == 'y'):?>
                                                        <div class="extra-options__parameters-input">
                                                            <input
                                                                    type="checkbox"
                                                                    class="sr-only"
                                                                    value="<? echo $ar["HTML_VALUE"] ?>"
                                                                    name="<? echo $ar["CONTROL_NAME"] ?>"
                                                                    id="<? echo $ar["CONTROL_ID"] ?>"
                                                                <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                                    onclick="smartFilter.click(this)"
                                                            />
                                                            <label class="d-flex w-100 align-items-center <? echo $ar["DISABLED"] ? 'disabled' : '' ?>"
                                                                   data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                                                   for="<? echo $ar["CONTROL_ID"] ?>"><span
                                                                        class="icon icon--bus">
																<svg xmlns="http://www.w3.org/2000/svg" width="33.298"
                                                                     height="17.762" viewBox="0 0 33.298 17.762"
                                                                     class="inline-svg">
																	<path d="M.555,16.027h2.83A2.765,2.765,0,0,0,8.325,17.12a2.766,2.766,0,0,0,4.939-1.093h11.21a2.775,2.775,0,0,0,5.439,0h2.83a.555.555,0,0,0,.555-.555V11.259a7.2,7.2,0,0,0-.2-1.669l-1.212-5.1a2.226,2.226,0,0,0-2.177-1.785H13.107L12.154.8a.555.555,0,0,0-.5-.307H3.885a.555.555,0,0,0-.5.307L2.432,2.708H.555A.555.555,0,0,0,0,3.263V15.472A.555.555,0,0,0,.555,16.027Zm5.55,1.11a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,6.1,17.137Zm4.44,0a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,10.544,17.137Zm16.649,0a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,27.194,17.137Zm4.828-7.291c.006.026.008.051.013.077H27.748V6.038h3.369ZM4.228,1.6h7.084l.555,1.11H3.673ZM1.11,3.818h28.6a1.119,1.119,0,0,1,1.093.912l.05.2H1.11Zm25.529,2.22V9.923h-3.33V6.038Zm-4.44,0V9.923h-3.33V6.038Zm-4.44,0V9.923h-3.33V6.038Zm-4.44,0V9.923H9.989V6.038Zm-4.44,0V9.923H5.55V6.038Zm-7.77,0H4.44V9.923H1.11Zm0,7.215H2.22v-1.11H1.11v-1.11H32.175c0,.075.013.15.013.226v.884h-1.11v1.11h1.11v1.665H29.913a.147.147,0,0,0-.009-.029,2.745,2.745,0,0,0-.144-.462c-.022-.056-.051-.1-.076-.154a2.872,2.872,0,0,0-.16-.294c-.035-.056-.076-.106-.115-.158a2.862,2.862,0,0,0-.2-.238c-.047-.049-.095-.1-.145-.142a2.624,2.624,0,0,0-.234-.193q-.083-.061-.166-.116a2.955,2.955,0,0,0-.278-.149c-.059-.028-.116-.055-.177-.083a2.755,2.755,0,0,0-.333-.1c-.056-.014-.107-.033-.164-.044a2.631,2.631,0,0,0-1.054,0c-.056.011-.111.03-.164.044a2.768,2.768,0,0,0-.333.1c-.061.024-.118.056-.177.083a2.927,2.927,0,0,0-.278.149q-.083.055-.166.116a2.592,2.592,0,0,0-.234.193c-.05.046-.1.092-.145.142a2.954,2.954,0,0,0-.2.238c-.039.052-.079.1-.115.158a2.829,2.829,0,0,0-.16.294c-.025.052-.056.1-.076.154a2.767,2.767,0,0,0-.144.462.137.137,0,0,1-.009.029h-11.2a.147.147,0,0,0-.009-.029,2.787,2.787,0,0,0-.144-.462c-.022-.056-.051-.1-.076-.154a2.871,2.871,0,0,0-.16-.294c-.035-.056-.076-.106-.115-.158a2.907,2.907,0,0,0-.2-.238c-.047-.049-.095-.1-.145-.142a2.624,2.624,0,0,0-.234-.193q-.083-.061-.167-.116a2.923,2.923,0,0,0-.277-.149c-.059-.028-.116-.055-.177-.083a2.727,2.727,0,0,0-.33-.1c-.056-.014-.107-.033-.166-.044a2.583,2.583,0,0,0-1.033,0l-.086.016a2.767,2.767,0,0,0-.451.14l-.082.036a2.791,2.791,0,0,0-.42.228l-.022.017a2.789,2.789,0,0,0-.357.295l-.056.051a2.778,2.778,0,0,0-.235.272,2.827,2.827,0,0,0-.242-.278c-.018-.018-.036-.034-.056-.051a2.81,2.81,0,0,0-.357-.295l-.022-.017a2.8,2.8,0,0,0-.42-.228L7.146,12.9a2.792,2.792,0,0,0-.451-.14l-.086-.016a2.581,2.581,0,0,0-1.033,0c-.056.011-.111.03-.164.044a2.716,2.716,0,0,0-.333.1c-.061.024-.118.056-.177.083a2.91,2.91,0,0,0-.275.149c-.055.037-.111.075-.166.116a2.627,2.627,0,0,0-.234.193c-.05.046-.1.092-.145.142a2.832,2.832,0,0,0-.2.238c-.039.052-.079.1-.115.158a2.809,2.809,0,0,0-.16.294c-.025.052-.056.1-.076.154a2.732,2.732,0,0,0-.144.462.147.147,0,0,1-.009.029H1.11Zm0,0"
                                                                          transform="translate(0 -0.488)"
                                                                          fill="#3c4b5a"/>
																	<path d="M230.4,202.09h11.1v1.11H230.4Zm0,0"
                                                                          transform="translate(-217.079 -190.435)"
                                                                          fill="#3c4b5a"/>
																</svg></span><span
                                                                        class="text"><span>Автобус</span></span></label>
                                                        </div>
                                                    <?endif;
                                                endforeach; ?>
                                                <? foreach ($arResult["ITEMS"][59]["VALUES"] as $val => $ar): //dump($ar); // Электричка
                                                    if ($ar["URL_ID"] == 'y'):?>
                                                        <div class="extra-options__parameters-input">
                                                            <input
                                                                    type="checkbox"
                                                                    class="sr-only"
                                                                    value="<? echo $ar["HTML_VALUE"] ?>"
                                                                    name="<? echo $ar["CONTROL_NAME"] ?>"
                                                                    id="<? echo $ar["CONTROL_ID"] ?>"
                                                                <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                                    onclick="smartFilter.click(this)"
                                                            />
                                                            <label class="d-flex w-100 align-items-center <? echo $ar["DISABLED"] ? 'disabled' : '' ?>"
                                                                   data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                                                   for="<? echo $ar["CONTROL_ID"] ?>"><span
                                                                        class="icon icon--train">
																<svg xmlns="http://www.w3.org/2000/svg" width="33.298"
                                                                     height="13.319" viewBox="0 0 33.298 13.319"
                                                                     class="inline-svg">
																	<path d="M250.156,139.33h2.22a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33A.555.555,0,0,0,250.156,139.33Zm.555-3.33h1.11v2.22h-1.11Zm0,0"
                                                                          transform="translate(-235.172 -132.671)"
                                                                          fill="#3c4b5a"/>
																	<path d="M137.173,139.33a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33a.555.555,0,0,0,.555.555ZM135.509,136h1.11v2.22h-1.11Zm0,0"
                                                                          transform="translate(-126.629 -132.671)"
                                                                          fill="#3c4b5a"/>
																	<path d="M60.376,139.33a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33a.555.555,0,0,0,.555.555ZM58.711,136h1.11v2.22h-1.11Zm0,0"
                                                                          transform="translate(-54.272 -132.671)"
                                                                          fill="#3c4b5a"/>
																	<path d="M2.22,138.775v-3.33a.555.555,0,0,0-.555-.555H0V136H1.11v2.22H0v1.11H1.665A.555.555,0,0,0,2.22,138.775Zm0,0"
                                                                          transform="translate(0 -132.671)"
                                                                          fill="#3c4b5a"/>
																	<path d="M364.8,192.488h2.22v1.11H364.8Zm0,0"
                                                                          transform="translate(-343.712 -186.939)"
                                                                          fill="#3c4b5a"/>
																	<path d="M460.8,230.887h1.11V232H460.8Zm0,0"
                                                                          transform="translate(-434.162 -223.117)"
                                                                          fill="#3c4b5a"/>
																	<path d="M518.4,230.887h1.11V232H518.4Zm0,0"
                                                                          transform="translate(-488.43 -223.117)"
                                                                          fill="#3c4b5a"/>
																	<path d="M15.242,96.488H0V97.6H12.209v6.66H0v1.11H12.209v1.11H0v1.11H2.775a2.2,2.2,0,0,0,.308,1.11H0v1.11H33.3V108.7H26.885a2.2,2.2,0,0,0,.308-1.11H29.72a3.578,3.578,0,0,0,2.291-6.327l-3.718-3.1a7.23,7.23,0,0,0-4.62-1.673h-8.43ZM4.995,108.7a1.11,1.11,0,0,1-1.11-1.11H6.1A1.11,1.11,0,0,1,4.995,108.7Zm3.33,0a1.11,1.11,0,0,1-1.11-1.11h2.22A1.11,1.11,0,0,1,8.325,108.7Zm4.995-3.33h5.55v1.11h-5.55Zm-3.083,3.33a2.2,2.2,0,0,0,.308-1.11H22.754a2.2,2.2,0,0,0,.309,1.11Zm14.738,0a1.11,1.11,0,0,1-1.11-1.11h2.22A1.11,1.11,0,0,1,24.974,108.7Zm3.573-8.879,2.664,2.22H25.973a.555.555,0,0,1-.427-.2l-1.682-2.02h4.683Zm-8.567,5.55h5.55v-1.11h-5.55V97.6h3.693a6.118,6.118,0,0,1,3.508,1.11H23.864a1.11,1.11,0,0,0-.852,1.82l1.685,2.02a1.661,1.661,0,0,0,1.277.6h6.049a2.439,2.439,0,0,1-2.3,3.33H19.979Zm-1.11-7.77v6.66h-5.55V97.6Z"
                                                                          transform="translate(0 -96.488)"
                                                                          fill="#3c4b5a"/>
																</svg></span><span class="text"><span>Электричка</span></span></label>
                                                        </div>
                                                    <?endif;
                                                endforeach; ?>
                                            </div>
                                            <div class="col-sm-6 col-lg-12">
                                                <div class="extra-options__parameters-title mt-lg-5">Безопасность</div>
                                                <? foreach ($arResult["ITEMS"][79]["VALUES"] as $val => $ar): //dump($ar); // Обустройство поселка
                                                    if ($ar["URL_ID"] != 'no'):
                                                        if ($ar["URL_ID"] == 'security') $icon = 'ohrana';
                                                        if ($ar["URL_ID"] == 'fenced') $icon = 'ogorozjen';
                                                        $iconSVG = file_get_contents('https://' . $_SERVER['HTTP_HOST'] . '/assets/img/svg/' . $icon . '.svg'); ?>
                                                        <div class="extra-options__parameters-input">
                                                            <input
                                                                    type="checkbox"
                                                                    class="sr-only"
                                                                    value="<? echo $ar["HTML_VALUE"] ?>"
                                                                    name="<? echo $ar["CONTROL_NAME"] ?>"
                                                                    id="<? echo $ar["CONTROL_ID"] ?>"
                                                                <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                                    onclick="smartFilter.click(this)"
                                                            />
                                                            <label class="d-flex w-100 align-items-center <? echo $ar["DISABLED"] ? 'disabled' : '' ?>"
                                                                   data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                                                   for="<? echo $ar["CONTROL_ID"] ?>">
                                                                <span class="icon icon--<?= $icon ?>"><?= $iconSVG ?></span>
                                                                <span class="text"><span><?= $ar["VALUE"]; ?></span></span>
                                                            </label>
                                                        </div>
                                                    <?endif;
                                                endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-sm-4 col-sm-4 order-md-3 order-lg-5 order-xl-4 col-md-3 col-lg-2">
                                        <div class="extra-options__parameters-title">Природа</div>
                                        <div class="extra-options__parameters-input">
                                            <div class="hide">
                                                <? foreach ($arResult["ITEMS"][47]["VALUES"] as $val => $ar): //dump($ar); // Водоем
                                                    if ($ar["URL_ID"] != 'no'):?>
                                                        <input
                                                                type="checkbox"
                                                                value="<? echo $ar["HTML_VALUE"] ?>"
                                                                name="<? echo $ar["CONTROL_NAME"] ?>"
                                                                id="<? echo $ar["CONTROL_ID"] ?>"
                                                            <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                                onclick="smartFilter.click(this)"
                                                        /> <?= $ar["VALUE"]; ?>
                                                    <?endif;
                                                endforeach; ?></div>
                                            <input class="sr-only iconDouble" type="checkbox" id="vodoem"
                                                   data-id1="<?= $arResult["ITEMS"][47]["VALUES"][39]["CONTROL_ID"] ?>"
                                                   data-id2="<?= $arResult["ITEMS"][47]["VALUES"][40]["CONTROL_ID"] ?>"
                                                   data-id3="<?= $arResult["ITEMS"][47]["VALUES"][41]["CONTROL_ID"] ?>">
                                            <label class="d-flex w-100 align-items-center" for="vodoem"><span
                                                        class="icon icon--vodoem">
													<svg xmlns="http://www.w3.org/2000/svg" width="23.111"
                                                         height="14.182" viewBox="0 0 23.111 14.182" class="inline-svg">
														<g transform="translate(0 -98.909)">
															<g transform="translate(0 98.909)">
																<g>
																	<path d="M20.686,100.11a5.278,5.278,0,0,0-6.7,0,3.561,3.561,0,0,1-2.425.9,3.561,3.561,0,0,1-2.426-.9,5.078,5.078,0,0,0-3.352-1.2,5.078,5.078,0,0,0-3.352,1.2,3.561,3.561,0,0,1-2.426.9V103.9a3.561,3.561,0,0,0,2.426-.9,5.078,5.078,0,0,1,3.352-1.2A5.078,5.078,0,0,1,9.13,103a3.561,3.561,0,0,0,2.426.9,3.561,3.561,0,0,0,2.425-.9,5.278,5.278,0,0,1,6.7,0,3.561,3.561,0,0,0,2.425.9V101.01A3.561,3.561,0,0,1,20.686,100.11Z"
                                                                          transform="translate(0 -98.909)"
                                                                          class="color-fill"/>
																</g>
															</g>
															<g transform="translate(0 108.101)">
																<g>
																	<path d="M19.759,303.446a3.719,3.719,0,0,0-4.851,0,5.077,5.077,0,0,1-3.352,1.2,5.078,5.078,0,0,1-3.352-1.2,3.562,3.562,0,0,0-2.426-.9,3.561,3.561,0,0,0-2.426.9A5.078,5.078,0,0,1,0,304.647v2.889a5.078,5.078,0,0,0,3.352-1.2,3.561,3.561,0,0,1,2.426-.9,3.561,3.561,0,0,1,2.426.9,5.078,5.078,0,0,0,3.352,1.2,5.077,5.077,0,0,0,3.352-1.2,3.719,3.719,0,0,1,4.851,0,5.077,5.077,0,0,0,3.352,1.2v-2.889A5.077,5.077,0,0,1,19.759,303.446Z"
                                                                          transform="translate(0 -302.546)"
                                                                          class="color-fill"/>
																</g>
															</g>
															<g transform="translate(0 103.374)">
																<g>
																	<path d="M19.759,198.718a3.719,3.719,0,0,0-4.851,0,5.077,5.077,0,0,1-3.352,1.2,5.078,5.078,0,0,1-3.352-1.2,3.561,3.561,0,0,0-2.426-.9,3.561,3.561,0,0,0-2.426.9A5.077,5.077,0,0,1,0,199.919v3.152a3.561,3.561,0,0,0,2.426-.9,5.078,5.078,0,0,1,3.352-1.2,5.078,5.078,0,0,1,3.352,1.2,3.561,3.561,0,0,0,2.426.9,3.561,3.561,0,0,0,2.425-.9,5.278,5.278,0,0,1,6.7,0,3.561,3.561,0,0,0,2.425.9v-3.152A5.077,5.077,0,0,1,19.759,198.718Z"
                                                                          transform="translate(0 -197.818)"
                                                                          class="color-fill"/>
																</g>
															</g>
														</g>
													</svg></span><span class="text"><span>Водоем</span></span></label>
                                        </div>
                                        <div class="extra-options__parameters-input">
                                            <div class="hide">
                                                <? foreach ($arResult["ITEMS"][45]["VALUES"] as $val => $ar): //dump($ar); // Лес
                                                    if ($ar["URL_ID"] != 'no'):?>
                                                        <input
                                                                type="checkbox"
                                                                value="<? echo $ar["HTML_VALUE"] ?>"
                                                                name="<? echo $ar["CONTROL_NAME"] ?>"
                                                                id="<? echo $ar["CONTROL_ID"] ?>"
                                                            <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                                onclick="smartFilter.click(this)"
                                                        /> <?= $ar["VALUE"]; ?> лес
                                                    <?endif;
                                                endforeach; ?></div>
                                            <input class="sr-only iconDouble" type="checkbox" id="les"
                                                   data-id1="<?= $arResult["ITEMS"][45]["VALUES"][35]["CONTROL_ID"] ?>"
                                                   data-id2="<?= $arResult["ITEMS"][45]["VALUES"][36]["CONTROL_ID"] ?>"
                                                   data-id3="<?= $arResult["ITEMS"][45]["VALUES"][37]["CONTROL_ID"] ?>"
                                                   data-id4="<?= $arResult["ITEMS"][45]["VALUES"][38]["CONTROL_ID"] ?>">
                                            <label class="d-flex w-100 align-items-center" for="les"><span
                                                        class="icon icon--les">
													<svg xmlns="http://www.w3.org/2000/svg" width="17.38"
                                                         height="24.833" viewBox="0 0 17.38 24.833" class="inline-svg">
														<path d="M72.266,7.657a4.88,4.88,0,0,0-.51-.475,2.01,2.01,0,0,0-1.871-2.747c-.065,0-.13,0-.194.009a4.838,4.838,0,0,0-8.9-2.2,3.412,3.412,0,0,0-3.306,5.4l-.012.013a4.841,4.841,0,0,0,3.549,8.133,4.93,4.93,0,0,0,.743-.056l1.787,2.76-.871,5.642a.6.6,0,0,0,.133.486.623.623,0,0,0,.476.211h3.186a.623.623,0,0,0,.476-.211.6.6,0,0,0,.133-.486l-.856-5.547,1.84-2.842a4.932,4.932,0,0,0,.652.044,4.841,4.841,0,0,0,3.549-8.133Zm-7.349,9.29-1.254-1.938a4.829,4.829,0,0,0,1.2-1.123,4.826,4.826,0,0,0,1.275,1.167Z"
                                                              transform="translate(-56.177)" class="color-fill"/>
													</svg></span><span class="text"><span>Лес</span></span></label>
                                        </div>
                                        <? foreach ($arResult["ITEMS"][48]["VALUES"] as $val => $ar): //dump($ar); // Пляж для купания
                                            if ($ar["URL_ID"] == 'y'):?>
                                                <div class="extra-options__parameters-input">
                                                    <input
                                                            type="checkbox"
                                                            class="sr-only"
                                                            value="<? echo $ar["HTML_VALUE"] ?>"
                                                            name="<? echo $ar["CONTROL_NAME"] ?>"
                                                            id="<? echo $ar["CONTROL_ID"] ?>"
                                                        <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                            onclick="smartFilter.click(this)"
                                                    />
                                                    <label class="d-flex w-100 align-items-center <? echo $ar["DISABLED"] ? 'disabled' : '' ?>"
                                                           data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                                           for="<? echo $ar["CONTROL_ID"] ?>"><span
                                                                class="icon icon--plyaj">
														<svg xmlns="http://www.w3.org/2000/svg" width="21.889"
                                                             height="21.799" viewBox="0 0 21.889 21.799"
                                                             class="inline-svg">
															<g transform="translate(0 -0.093)">
																<path d="M21.565,18.948a.947.947,0,0,0-.744-.229,25.544,25.544,0,0,1-4.17.2,11.6,11.6,0,0,1-3-.558L10.325,8.835a37.7,37.7,0,0,1,7.317-1.6.943.943,0,0,0,.734-1.372A9.638,9.638,0,0,0,7.571.953L7.491.725A.942.942,0,0,0,6.29.146L6.274.151a.943.943,0,0,0-.579,1.2l.079.228A9.636,9.636,0,0,0,.368,12.113a.943.943,0,0,0,1.44.615A34.44,34.44,0,0,1,8.528,9.46l2.8,8.012c-2.261-.958-4.424-1.961-7.28-1.526A6.96,6.96,0,0,0,.237,18.28.95.95,0,0,0,0,18.9V20.95a.946.946,0,0,0,.947.943H20.942a.947.947,0,0,0,.948-.943v-1.3A.952.952,0,0,0,21.565,18.948Z"
                                                                      class="color-fill"/>
															</g>
														</svg></span><span class="text"><span>Пляж</span></span></label>
                                                </div>
                                            <?endif;
                                        endforeach; ?>
                                    </div>
                                    <div class="order-sm-3 col-sm-8 order-md-4 order-lg-4 order-xl-5 col-md-6 col-lg-3 col-xl-4">
                                        <div class="extra-options__parameters-title mb-3">Инфраструктура</div>
                                        <div class="row">
                                            <div class="col-sm-6 col-lg-12 col-xl-6">
                                                <div class="extra-options__parameters-input">
                                                    <div class="hide"><? foreach ($arResult["ITEMS"][81]["VALUES"] as $val => $ar): //dump($ar); // Магазин?>
                                                            <input
                                                                    type="checkbox"
                                                                    value="<? echo $ar["HTML_VALUE"] ?>"
                                                                    name="<? echo $ar["CONTROL_NAME"] ?>"
                                                                    id="<? echo $ar["CONTROL_ID"] ?>"
                                                                <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                                    onclick="smartFilter.click(this)"
                                                            /> <?= $ar["VALUE"]; ?>
                                                        <? endforeach; ?></div>
                                                    <input class="sr-only iconDouble" type="checkbox" id="magazin"
                                                           data-id1="<?= $arResult["ITEMS"][81]["VALUES"][72]["CONTROL_ID"] ?>"
                                                           data-id2="<?= $arResult["ITEMS"][81]["VALUES"][113]["CONTROL_ID"] ?>">
                                                    <label class="d-flex w-100 align-items-center" for="magazin"><span
                                                                class="icon icon--magazin">
																<svg xmlns="http://www.w3.org/2000/svg" width="20.645"
                                                                     height="20.616" viewBox="0 0 20.645 20.616"
                                                                     class="inline-svg">
																	<g transform="translate(0 -0.338)">
																		<g transform="translate(0 0.338)">
																			<g transform="translate(0 0)">
																				<path d="M19.964,230.45h0v-4.225a2.181,2.181,0,0,1-1.374.062v4.163H16.918V227.8a.452.452,0,0,0-.452-.452H14.937a.452.452,0,0,0-.452.452v2.647H12.451v-.424a.452.452,0,0,0-.452-.452H10.27a.452.452,0,0,0-.452.452v.424H7.212v-1.186a.453.453,0,0,0-.452-.452H4.183a.452.452,0,0,0-.452.452v1.186H2.722v-4.194a2.354,2.354,0,0,1-.687.113,2.353,2.353,0,0,1-.687-.113v4.194h0A1.006,1.006,0,0,0,.34,231.456v4.8a1,1,0,0,0,1.005,1.005H19.964a1.006,1.006,0,0,0,1.006-1.005v-4.8A1.007,1.007,0,0,0,19.964,230.45Z"
                                                                                      transform="translate(-0.326 -216.642)"
                                                                                      class="color-fill"/>
																				<path d="M101.684,110.245a.324.324,0,0,0-.325.324v2.359a1.695,1.695,0,0,0,3.39,0v-2.359a.325.325,0,0,0-.325-.324Z"
                                                                                      transform="translate(-97.059 -105.582)"
                                                                                      class="color-fill"/>
																				<path d="M202.669,110.245a.325.325,0,0,0-.325.324v2.359a1.695,1.695,0,0,0,3.39,0v-2.359a.325.325,0,0,0-.325-.324Z"
                                                                                      transform="translate(-193.76 -105.582)"
                                                                                      class="color-fill"/>
																				<path d="M303.669,110.245a.325.325,0,0,0-.325.324v2.359a1.7,1.7,0,0,0,3.391,0v-2.359a.325.325,0,0,0-.325-.324Z"
                                                                                      transform="translate(-290.475 -105.582)"
                                                                                      class="color-fill"/>
																				<path d="M.324,4.15h20a.325.325,0,0,0,.193-.585L16.264.4A.327.327,0,0,0,16.07.338H4.575A.326.326,0,0,0,4.381.4L.131,3.565a.325.325,0,0,0,.193.585Z"
                                                                                      transform="translate(0 -0.338)"
                                                                                      class="color-fill"/>
																				<path d="M2.035,114.622a1.7,1.7,0,0,0,1.7-1.7v-2.359a.325.325,0,0,0-.325-.324H.665a.325.325,0,0,0-.325.324v2.359A1.7,1.7,0,0,0,2.035,114.622Z"
                                                                                      transform="translate(-0.326 -105.581)"
                                                                                      class="color-fill"/>
																				<path d="M407.428,110.245h-2.74a.324.324,0,0,0-.325.324v2.359a1.695,1.695,0,0,0,3.39,0v-2.359A.325.325,0,0,0,407.428,110.245Z"
                                                                                      transform="translate(-387.208 -105.582)"
                                                                                      class="color-fill"/>
																			</g>
																		</g>
																	</g>
																</svg></span><span
                                                                class="text"><span>Магазин</span></span></label>
                                                </div>
                                                <div class="extra-options__parameters-input">
                                                    <div class="hide"><? foreach ($arResult["ITEMS"][83]["VALUES"] as $val => $ar): //dump($ar); // Церковь?>
                                                            <input
                                                                    type="checkbox"
                                                                    value="<? echo $ar["HTML_VALUE"] ?>"
                                                                    name="<? echo $ar["CONTROL_NAME"] ?>"
                                                                    id="<? echo $ar["CONTROL_ID"] ?>"
                                                                <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                                    onclick="smartFilter.click(this)"
                                                            /> <?= $ar["VALUE"]; ?>
                                                        <? endforeach; ?></div>
                                                    <input class="sr-only iconDouble" type="checkbox" id="cerkov"
                                                           data-id1="<?= $arResult["ITEMS"][83]["VALUES"][76]["CONTROL_ID"] ?>"
                                                           data-id2="<?= $arResult["ITEMS"][83]["VALUES"][115]["CONTROL_ID"] ?>">
                                                    <label class="d-flex w-100 align-items-center" for="cerkov"><span
                                                                class="icon icon--cerkov">
																<svg xmlns="http://www.w3.org/2000/svg" width="24.723"
                                                                     height="23.043" viewBox="0 0 24.723 23.043"
                                                                     class="inline-svg">
																	<g transform="translate(0 -10.535)">
																		<path d="M253.381,206.25v7.434H257.9V208.86Z"
                                                                              transform="translate(-233.173 -180.106)"
                                                                              class="color-fill"/>
																		<path d="M0,213.618H4.515v-7.44L0,208.794Z"
                                                                              transform="translate(0 -180.04)"
                                                                              class="color-fill"/>
																		<path d="M66.619,107.094v9.937h4.629v-4.213a2.393,2.393,0,0,1,2.393-2.393h.053a2.393,2.393,0,0,1,2.393,2.393v4.213h4.629v-9.937l-7.049-5.847Z"
                                                                              transform="translate(-61.306 -83.478)"
                                                                              class="color-fill"/>
																		<path d="M27.5,22.582l1.2,1.451L37.67,16.64l8.972,7.393,1.2-1.451-9.61-7.919V12.9h1.725V11.784H38.228V10.535H37.112v1.249H35.387V12.9h1.725v1.762Z"
                                                                              transform="translate(-25.309)"
                                                                              class="color-fill"/>
																	</g>
																</svg></span><span
                                                                class="text"><span>Церковь</span></span></label>
                                                </div>
                                                <div class="extra-options__parameters-input">
                                                    <div class="hide"><? foreach ($arResult["ITEMS"][84]["VALUES"] as $val => $ar): //dump($ar); // Школа?>
                                                            <input
                                                                    type="checkbox"
                                                                    value="<? echo $ar["HTML_VALUE"] ?>"
                                                                    name="<? echo $ar["CONTROL_NAME"] ?>"
                                                                    id="<? echo $ar["CONTROL_ID"] ?>"
                                                                <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                                    onclick="smartFilter.click(this)"
                                                            /> <?= $ar["VALUE"]; ?>
                                                        <? endforeach; ?></div>
                                                    <input class="sr-only iconDouble" type="checkbox" id="school"
                                                           data-id1="<?= $arResult["ITEMS"][84]["VALUES"][78]["CONTROL_ID"] ?>"
                                                           data-id2="<?= $arResult["ITEMS"][84]["VALUES"][116]["CONTROL_ID"] ?>">
                                                    <label class="d-flex w-100 align-items-center" for="school"><span
                                                                class="icon icon--school">
																<svg xmlns="http://www.w3.org/2000/svg" width="22.308"
                                                                     height="20.576" viewBox="0 0 22.308 20.576"
                                                                     class="inline-svg">
																	<g transform="translate(0 -18.463)">
																		<path d="M21.962,23.151a1.768,1.768,0,0,0-.791-.576,2.158,2.158,0,0,1-.067.764L17.086,36.561a.963.963,0,0,1-.469.556,1.486,1.486,0,0,1-.75.208H3.5q-1.607,0-1.929-.938a.611.611,0,0,1,.014-.576.59.59,0,0,1,.509-.2H13.737a2.469,2.469,0,0,0,1.721-.462,5.231,5.231,0,0,0,.958-2.056l3.67-12.137a1.911,1.911,0,0,0-.241-1.741,1.765,1.765,0,0,0-1.527-.75H8.124a3.725,3.725,0,0,0-.683.12l.013-.04a2.8,2.8,0,0,0-.636-.074.9.9,0,0,0-.482.154,1.551,1.551,0,0,0-.355.315,2.306,2.306,0,0,0-.261.429q-.127.261-.214.482t-.2.469a3.019,3.019,0,0,1-.221.408q-.08.107-.228.281t-.241.308a.754.754,0,0,0-.12.241.872.872,0,0,0,.027.355,1.1,1.1,0,0,1,.04.341,5.079,5.079,0,0,1-.368,1.293,5.522,5.522,0,0,1-.569,1.132q-.054.067-.295.3a1.072,1.072,0,0,0-.295.408q-.054.067-.007.375a1.934,1.934,0,0,1,.034.429A5.488,5.488,0,0,1,2.726,27.4a8.2,8.2,0,0,1-.563,1.232,2.2,2.2,0,0,1-.228.308,1.127,1.127,0,0,0-.228.375,1.181,1.181,0,0,0,.007.375,1.048,1.048,0,0,1-.007.4,7.271,7.271,0,0,1-.4,1.226,8.944,8.944,0,0,1-.6,1.226,3.224,3.224,0,0,1-.221.315,3.269,3.269,0,0,0-.221.315.834.834,0,0,0-.107.281.666.666,0,0,0,.04.261A.743.743,0,0,1,.234,34q-.014.187-.054.5t-.04.361a2.43,2.43,0,0,0,.027,1.7A3.764,3.764,0,0,0,1.5,38.322a3.278,3.278,0,0,0,1.989.716H15.854a2.674,2.674,0,0,0,1.641-.583,2.764,2.764,0,0,0,1.025-1.44L22.2,24.879A1.894,1.894,0,0,0,21.962,23.151Zm-14.253.027.281-.857a.6.6,0,0,1,.221-.3.561.561,0,0,1,.342-.127H16.7a.292.292,0,0,1,.268.127.349.349,0,0,1,.027.3l-.282.857a.6.6,0,0,1-.221.3.561.561,0,0,1-.341.127H8a.292.292,0,0,1-.268-.127A.349.349,0,0,1,7.709,23.178ZM6.6,26.607l.281-.857a.6.6,0,0,1,.221-.3.56.56,0,0,1,.342-.127h8.144a.292.292,0,0,1,.268.127.349.349,0,0,1,.027.3l-.281.857a.6.6,0,0,1-.221.3.56.56,0,0,1-.342.127H6.892a.292.292,0,0,1-.268-.127A.349.349,0,0,1,6.6,26.607Z"
                                                                              transform="translate(0)"
                                                                              class="color-fill"/>
																	</g>
																</svg></span><span
                                                                class="text"><span>Школа</span></span></label>
                                                </div>
                                                <div class="extra-options__parameters-input">
                                                    <div class="hide"><? foreach ($arResult["ITEMS"][85]["VALUES"] as $val => $ar): //dump($ar); // Дет.сад?>
                                                            <input
                                                                    type="checkbox"
                                                                    value="<? echo $ar["HTML_VALUE"] ?>"
                                                                    name="<? echo $ar["CONTROL_NAME"] ?>"
                                                                    id="<? echo $ar["CONTROL_ID"] ?>"
                                                                <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                                    onclick="smartFilter.click(this)"
                                                            /> <?= $ar["VALUE"]; ?>
                                                        <? endforeach; ?></div>
                                                    <input class="sr-only iconDouble" type="checkbox" id="detsad"
                                                           data-id1="<?= $arResult["ITEMS"][85]["VALUES"][80]["CONTROL_ID"] ?>"
                                                           data-id2="<?= $arResult["ITEMS"][85]["VALUES"][117]["CONTROL_ID"] ?>">
                                                    <label class="d-flex w-100 align-items-center" for="detsad"><span
                                                                class="icon icon--detsad">
																<svg xmlns="http://www.w3.org/2000/svg" width="20.767"
                                                                     height="23.632" viewBox="0 0 20.767 23.632"
                                                                     class="inline-svg">
																	<g transform="translate(-31.04)">
																		<path d="M346.369,377.44c-1.35,1.35-1.569,3.326-.49,4.406,1.179,1.179,3.207.71,4.406-.49,1.349-1.35,1.569-3.326.49-4.406C349.62,375.794,347.6,376.21,346.369,377.44Z"
                                                                              transform="translate(-299.654 -358.902)"
                                                                              class="color-fill"/>
																		<path d="M36.621,381.792c1.08-1.08.86-3.056-.489-4.406-1.224-1.223-3.239-1.658-4.406-.489-1.079,1.08-.859,3.057.489,4.406C33.416,382.5,35.438,382.975,36.621,381.792Z"
                                                                              transform="translate(0 -358.847)"
                                                                              class="color-fill"/>
																		<path d="M62.034,225.444a5.046,5.046,0,0,1,2.387.664,13.45,13.45,0,0,1,2.237-5.062,7.046,7.046,0,0,1-1.81-1.446A5.72,5.72,0,0,0,61,224.788a4.976,4.976,0,0,0,.068.786A4.017,4.017,0,0,1,62.034,225.444Z"
                                                                              transform="translate(-28.577 -209.464)"
                                                                              class="color-fill"/>
																		<path d="M330.2,219.6a7.045,7.045,0,0,1-1.81,1.446,13.451,13.451,0,0,1,2.237,5.062,5.054,5.054,0,0,1,2.386-.662,4.035,4.035,0,0,1,.967.13,4.97,4.97,0,0,0,.068-.788A5.72,5.72,0,0,0,330.2,219.6Z"
                                                                              transform="translate(-283.627 -209.464)"
                                                                              class="color-fill"/>
																		<path d="M167.826,263.287a6.682,6.682,0,0,1-4.022,0,12.035,12.035,0,0,0-2.353,5.365,4.748,4.748,0,0,1,1.136,5.586,10.124,10.124,0,0,0,6.455,0,4.75,4.75,0,0,1,1.136-5.586A12.033,12.033,0,0,0,167.826,263.287Zm-1.319,7.326h-1.385v-1.385h1.385Zm0-2.769h-1.385v-1.385h1.385Z"
                                                                              transform="translate(-124.391 -251.135)"
                                                                              class="color-fill"/>
																		<path d="M78.769,5.539a5.539,5.539,0,1,0,11.077,0,2.769,2.769,0,1,0-2.22-4.41,5.442,5.442,0,0,0-6.637,0,2.766,2.766,0,1,0-2.22,4.41Zm7.616-2.077H87.77V4.846H86.385Zm.692,3.462C87.077,8.088,85.861,9,84.308,9s-2.769-.912-2.769-2.077,1.216-2.077,2.769-2.077S87.077,5.758,87.077,6.923ZM80.846,3.462h1.385V4.846H80.846Z"
                                                                              transform="translate(-42.885)"
                                                                              class="color-fill"/>
																		<ellipse cx="1.385" cy="0.692" rx="1.385"
                                                                                 ry="0.692"
                                                                                 transform="translate(40.039 6.231)"
                                                                                 class="color-fill"/>
																	</g>
																</svg></span><span
                                                                class="text"><span>Дет. сад</span></span></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-lg-12 col-xl-6">
                                                <div class="extra-options__parameters-input">
                                                    <div class="hide"><? foreach ($arResult["ITEMS"][87]["VALUES"] as $val => $ar): // dump($val); // Кафе?>
                                                            <input
                                                                    type="checkbox"
                                                                    value="<? echo $ar["HTML_VALUE"] ?>"
                                                                    name="<? echo $ar["CONTROL_NAME"] ?>"
                                                                    id="<? echo $ar["CONTROL_ID"] ?>"
                                                                <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                                    onclick="smartFilter.click(this)"
                                                            /> <?= $ar["VALUE"]; ?>
                                                        <? endforeach; ?></div>
                                                    <input class="sr-only iconDouble" type="checkbox" id="cafe"
                                                           data-id1="<?= $arResult["ITEMS"][87]["VALUES"][84]["CONTROL_ID"] ?>"
                                                           data-id2="<?= $arResult["ITEMS"][87]["VALUES"][119]["CONTROL_ID"] ?>">
                                                    <label class="d-flex w-100 align-items-center" for="cafe"><span
                                                                class="icon icon--cafe">
																<svg xmlns="http://www.w3.org/2000/svg" width="15.212"
                                                                     height="24.339" viewBox="0 0 15.212 24.339"
                                                                     class="inline-svg">
																	<g transform="translate(-48)">
																		<path d="M48.507,0A.507.507,0,0,0,48,.507v21.8a2.028,2.028,0,1,0,4.057,0V14.2h1.521a.507.507,0,0,0,.507-.507c0-5.175-.034-8.453-.705-10.549C52.674.939,51.217,0,48.507,0Z"
                                                                              transform="translate(0 0)"
                                                                              class="color-fill"/>
																		<path d="M110.085,0V6.085h-1.014V0h-2.028V6.085h-1.014V0H104V7.1a4.064,4.064,0,0,0,3.042,3.928V14.7h-.507a.507.507,0,0,0-.507.507v7.1a2.028,2.028,0,1,0,4.057,0v-7.1a.507.507,0,0,0-.507-.507h-.507V11.027A4.064,4.064,0,0,0,112.113,7.1V0Z"
                                                                              transform="translate(-48.901 0)"
                                                                              class="color-fill"/>
																	</g>
																</svg></span><span class="text"><span>Кафе</span></span></label>
                                                </div>
                                                <div class="extra-options__parameters-input">
                                                    <div class="hide"><? foreach ($arResult["ITEMS"][88]["VALUES"] as $val => $ar): //dump($ar); // АЗС?>
                                                            <input
                                                                    type="checkbox"
                                                                    value="<? echo $ar["HTML_VALUE"] ?>"
                                                                    name="<? echo $ar["CONTROL_NAME"] ?>"
                                                                    id="<? echo $ar["CONTROL_ID"] ?>"
                                                                <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                                    onclick="smartFilter.click(this)"
                                                            /> <?= $ar["VALUE"]; ?>
                                                        <? endforeach; ?></div>
                                                    <input class="sr-only iconDouble" type="checkbox" id="azs"
                                                           data-id1="<?= $arResult["ITEMS"][88]["VALUES"][86]["CONTROL_ID"] ?>"
                                                           data-id2="<?= $arResult["ITEMS"][88]["VALUES"][120]["CONTROL_ID"] ?>">
                                                    <label class="d-flex w-100 align-items-center" for="azs"><span
                                                                class="icon icon--azs">
																<svg xmlns="http://www.w3.org/2000/svg" width="18.201"
                                                                     height="20.801" viewBox="0 0 18.201 20.801"
                                                                     class="inline-svg">
																	<g transform="translate(-16)">
																		<path d="M22.067,1.733H21.2V.433A.433.433,0,0,0,20.767,0H17.3a.433.433,0,0,0-.433.433v1.3H16V3.467h6.067Z"
                                                                              class="color-fill"/>
																		<path d="M37.867,0H36.575a3.481,3.481,0,0,0-3.333,2.514L32.4,5.461a.433.433,0,0,1-.477.31l-3.216-.448a.433.433,0,0,1-.373-.429v-.56H24v14.3A2.167,2.167,0,0,0,26.167,20.8h13a2.167,2.167,0,0,0,2.167-2.167V3.467A3.467,3.467,0,0,0,37.867,0ZM36.747,16.721l-1.226,1.226L33.175,15.6H32.159l-2.346,2.346-1.226-1.226,2.346-2.346V13.36l-2.346-2.346,1.226-1.226,2.346,2.346h1.015l2.346-2.346,1.226,1.226L34.4,13.36v1.015Zm1.492-9.7-2.525-.365a.433.433,0,0,1-.361-.523l.713-3.19a.433.433,0,0,1,.423-.339H38.3a.433.433,0,0,1,.433.433V6.588a.433.433,0,0,1-.5.429Z"
                                                                              transform="translate(-7.133)"
                                                                              class="color-fill"/>
																	</g>
																</svg></span><span class="text"><span>АЗС</span></span></label>
                                                </div>
                                                <div class="extra-options__parameters-input">
                                                    <div class="hide"><? foreach ($arResult["ITEMS"][82]["VALUES"] as $val => $ar): //dump($ar); // Аптека?>
                                                            <input
                                                                    type="checkbox"
                                                                    value="<? echo $ar["HTML_VALUE"] ?>"
                                                                    name="<? echo $ar["CONTROL_NAME"] ?>"
                                                                    id="<? echo $ar["CONTROL_ID"] ?>"
                                                                <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                                    onclick="smartFilter.click(this)"
                                                            /> <?= $ar["VALUE"]; ?>
                                                        <? endforeach; ?></div>
                                                    <input class="sr-only iconDouble" type="checkbox" id="apteka"
                                                           data-id1="<?= $arResult["ITEMS"][82]["VALUES"][74]["CONTROL_ID"] ?>"
                                                           data-id2="<?= $arResult["ITEMS"][82]["VALUES"][114]["CONTROL_ID"] ?>">
                                                    <label class="d-flex w-100 align-items-center" for="apteka"><span
                                                                class="icon icon--apteka">
																<svg xmlns="http://www.w3.org/2000/svg" width="23.333"
                                                                     height="20" viewBox="0 0 23.333 20"
                                                                     class="inline-svg">
																	<g transform="translate(0 -16.5)">
																		<path d="M22.155,21.449H16.667V17.712A1.187,1.187,0,0,0,15.488,16.5H8.013a1.245,1.245,0,0,0-1.246,1.212v3.737H1.246A1.241,1.241,0,0,0,0,22.662V35.288A1.241,1.241,0,0,0,1.246,36.5H22.155a1.184,1.184,0,0,0,1.178-1.212V22.662a1.184,1.184,0,0,0-1.178-1.212ZM8.384,18.116H15.05v3.333H8.384Zm7.475,12.525H13.333v2.525H10V30.641H7.475V27.308H10V24.783h3.333v2.525h2.525Z"
                                                                              class="color-fill"/>
																	</g>
																</svg></span><span
                                                                class="text"><span>Аптека</span></span></label>
                                                </div>
                                                <div class="extra-options__parameters-input">
                                                    <div class="hide"><? foreach ($arResult["ITEMS"][86]["VALUES"] as $val => $ar): //dump($ar); // Строймат?>
                                                            <input
                                                                    type="checkbox"
                                                                    value="<? echo $ar["HTML_VALUE"] ?>"
                                                                    name="<? echo $ar["CONTROL_NAME"] ?>"
                                                                    id="<? echo $ar["CONTROL_ID"] ?>"
                                                                <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                                    onclick="smartFilter.click(this)"
                                                            /> <?= $ar["VALUE"]; ?>
                                                        <? endforeach; ?></div>
                                                    <input class="sr-only iconDouble" type="checkbox" id="stroimat"
                                                           data-id1="<?= $arResult["ITEMS"][86]["VALUES"][82]["CONTROL_ID"] ?>"
                                                           data-id2="<?= $arResult["ITEMS"][86]["VALUES"][118]["CONTROL_ID"] ?>">
                                                    <label class="d-flex w-100 align-items-center" for="stroimat"><span
                                                                class="icon icon--stroimat">
																<svg xmlns="http://www.w3.org/2000/svg" width="26.219"
                                                                     height="22.515" viewBox="0 0 26.219 22.515"
                                                                     class="inline-svg">
																	<g transform="translate(0 -34.608)">
																		<g transform="translate(0 34.608)">
																			<path d="M220.591,131.521,205.364,141.9v6.706l15.227-10.6Z"
                                                                                  transform="translate(-194.372 -126.334)"
                                                                                  class="color-fill"/>
																			<path d="M9.788,251.836.025,247.919,0,255.348l9.788,3.668Z"
                                                                                  transform="translate(0 -236.502)"
                                                                                  class="color-fill"/>
																			<path d="M16.573,48.835,31.928,38.348l-10.051-3.74L6.464,44.652Zm4.579-5.5-4.017,2.75a2.138,2.138,0,0,1-1.946.257l-.856-.447c-.459-.239-.364-.73.2-1.1l3.891-2.551a2.274,2.274,0,0,1,1.815-.274l.919.348C21.676,42.514,21.682,42.969,21.152,43.331Zm5.192-5.424.971.254c.551.144.632.519.167.838L23.967,41.4a2.369,2.369,0,0,1-1.884.285l-.928-.333c-.5-.179-.491-.585,0-.908l3.43-2.248A2.489,2.489,0,0,1,26.344,37.908Zm-9.011,1.415,3.315-2.067a2.367,2.367,0,0,1,1.616-.281l.847.222c.48.126.513.464.061.756l-3.4,2.2a2.247,2.247,0,0,1-1.721.276l-.8-.288C16.815,39.985,16.859,39.619,17.333,39.323Zm-6.362,3.968L14.7,40.965a2.158,2.158,0,0,1,1.662-.266l.8.3c.451.17.415.576-.1.906L13.212,44.4a2.022,2.022,0,0,1-1.77.254l-.735-.383C10.312,44.062,10.435,43.625,10.971,43.291Z"
                                                                                  transform="translate(-6.118 -34.608)"
                                                                                  class="color-fill"/>
																		</g>
																	</g>
																</svg></span><span
                                                                class="text"><span>Строймат.</span></span></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="order-3 order-lg-6 col-12 mt-4 pt-1">
                            <div class="d-flex flex-wrap justify-content-start">
                                <input class="btn btn-lg btn-warning mr-4" type="submit" id="set_dop_filter"
                                       name="set_dop_filter" value="Подобрать" disabled>
                                <button class="btn btn-link filter__button-clear p-0" type="reset"
                                        onclick="smartFilter.click(this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12.669" height="12.669"
                                         viewBox="0 0 12.669 12.669" class="inline-svg">
                                        <path d="M12.24 2.5L8.4 6.336l3.839 3.839a1.462 1.462 0 1 1-2.067 2.068L6.334 8.4 2.5 12.242a1.462 1.462 0 0 1-2.072-2.067l3.839-3.839L.428 2.5A1.462 1.462 0 0 1 2.495.43l3.839 3.839L10.173.43A1.462 1.462 0 0 1 12.24 2.5z"/>
                                    </svg>
                                    Сбросить фильтр
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Модальное окно Дома-->
    <div class="modal" id="houseModal">
        <div class="modal-dialog modal-xl modal-house" role="document">
            <div class="modal-content p-15">
                <div class="modal-header">
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <div class="text-uppercase chart">Тип дома</div>
                        <button class="close btn-sm" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex flex-wrap">
                                <? foreach ($arResult["ITEMS"][102]["VALUES"] as $val => $ar): //dump($ar); // Материал домов?>
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
                        <div class="col-lg-5 col-md-6">
                            <div class="modal-area-home">
                                <div class="modal-area-home__input">
                                    <div class="d-flex align-items-center">
                                        <? $arItem = $arResult["ITEMS"][15]; //dump($arItem); // Площадь домов?>
                                        <div class="modal-area-home__title">Площадь дома кв. м.</div>
                                        <input
                                                placeholder="<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>"
                                                data-min-val='<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>'
                                                data-max-val='<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>'
                                                type="text"
                                                name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                                id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                                value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                                onkeyup="smartFilter.keyup(this)"
                                        />
                                        <input
                                                placeholder="<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>"
                                                data-min-val='<? echo $arItem["VALUES"]["MIN"]["VALUE"] ?>'
                                                data-max-val='<? echo $arItem["VALUES"]["MAX"]["VALUE"] ?>'
                                                type="text"
                                                name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                                id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                                value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                                onkeyup="smartFilter.keyup(this)"
                                        />
                                    </div>
                                </div>
                                <div class="modal-area-home__range" id="slider-range"></div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-6 mt-3 mt-md-0">
                            <div class="d-flex flex-wrap">
                                <? foreach ($arResult["ITEMS"][104]["VALUES"] as $val => $ar): //dump($ar); // Дома с отделкой?>
                                    <div class="custom-control custom-checkbox custom-control-inline align-items-center h-100">
                                        <input
                                                type="checkbox"
                                                value="<? echo $ar["HTML_VALUE"] ?>"
                                                name="<? echo $ar["CONTROL_NAME"] ?>"
                                                id="<? echo $ar["CONTROL_ID"] ?>"
                                            <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                onclick="smartFilter.click(this)"
                                                class="custom-control-input"
                                        />
                                        <label class="custom-control-label <? echo $ar["DISABLED"] ? 'disabled' : '' ?>"
                                               data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                               for="<? echo $ar["CONTROL_ID"] ?>"><?= $ar["VALUE"]; ?></label>
                                    </div>
                                <? endforeach; ?>
                            </div>
                        </div>
                        <? if ($arResult["ITEMS"][103]["VALUES"]): ?>
                            <div class="col-xl-12 mt-4 mb-4">
                                <p class="mb-0 text-secondary">Готовность:</p>
                                <div class="d-flex flex-wrap">
                                    <? foreach ($arResult["ITEMS"][103]["VALUES"] as $val => $ar): //dump($ar); // Стадия готовности?>
                                        <div class="custom-control custom-checkbox custom-control-inline align-items-center h-100">
                                            <input
                                                    type="checkbox"
                                                    value="<? echo $ar["HTML_VALUE"] ?>"
                                                    name="<? echo $ar["CONTROL_NAME"] ?>"
                                                    id="<? echo $ar["CONTROL_ID"] ?>"
                                                <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                    onclick="smartFilter.click(this)"
                                                    class="custom-control-input"
                                            />
                                            <label class="custom-control-label <? echo $ar["DISABLED"] ? 'disabled' : '' ?>"
                                                   data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                                   for="<? echo $ar["CONTROL_ID"] ?>"><?= $ar["VALUE"]; ?></label>
                                        </div>
                                    <? endforeach; ?>
                                </div>
                            </div>
                        <? endif; ?>
                        <div class="col-12 mb-4">
                            <button class="btn btn-warning" type="button" data-dismiss="modal">Готово</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно Шоссе-->
    <div class="modal" id="highwayModal" tabindex="-1" role="dialog" aria-labelledby="highwayModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <div class="text-uppercase chart" id="highwayModalLabel">Шоссе</div>
                        <button class="close btn-sm" type="button" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
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
                        foreach ($arResult["ITEMS"][5]["VALUES"] as $val => $ar) {
                            // echo $ar['VALUE'].' - '.$ar['URL_ID'].'<br>';
                            switch ($ar['URL_ID']) {
                                case 'dmitrovskoe':
                                    $arShosse['sever']['SHOSSE'][] = $ar;
                                    break;
                                case 'rogachevskoe':
                                    $arShosse['sever']['SHOSSE'][] = $ar;
                                    break;
                                case 'leningradskoe':
                                    $arShosse['sever']['SHOSSE'][] = $ar;
                                    break;
                                case 'yaroslavskoe':
                                    $arShosse['sever-vostok']['SHOSSE'][] = $ar;
                                    break;
                                case 'novorijskoe':
                                    $arShosse['sever-zapad']['SHOSSE'][] = $ar;
                                    break;
                                case 'pyatnickoe':
                                    $arShosse['sever-zapad']['SHOSSE'][] = $ar;
                                    break;
                                case 'volokolamskoe':
                                    $arShosse['sever-zapad']['SHOSSE'][] = $ar;
                                    break;
                                case 'varshavskoe':
                                    $arShosse['ug']['SHOSSE'][] = $ar;
                                    break;
                                case 'simferopolskoe':
                                    $arShosse['ug']['SHOSSE'][] = $ar;
                                    break;
                                case 'egorievskoe':
                                    $arShosse['ug-vostok']['SHOSSE'][] = $ar;
                                    break;
                                case 'kashirskoe':
                                    $arShosse['ug']['SHOSSE'][] = $ar;
                                    break;
                                case 'novoryazanskoe':
                                    $arShosse['ug-vostok']['SHOSSE'][] = $ar;
                                    break;
                                case 'kievskoe':
                                    $arShosse['ug-zapad']['SHOSSE'][] = $ar;
                                    break;
                                case 'kalujskoe':
                                    $arShosse['ug-zapad']['SHOSSE'][] = $ar;
                                    break;
                                case 'shelkovskoe':
                                    $arShosse['vostok']['SHOSSE'][] = $ar;
                                    break;
                                case 'gorkovskoe':
                                    $arShosse['vostok']['SHOSSE'][] = $ar;
                                    break;
                                case 'nosovihinskoe':
                                    $arShosse['vostok']['SHOSSE'][] = $ar;
                                    break;
                                case 'minskoe':
                                    $arShosse['zapad']['SHOSSE'][] = $ar;
                                    break;
                                case 'rublevo-uspenskoe':
                                    $arShosse['zapad']['SHOSSE'][] = $ar;
                                    break;
                                case 'mozhayskoe':
                                    $arShosse['zapad']['SHOSSE'][] = $ar;
                                    break;
                                default:
                                    $arShosse['other']['SHOSSE'][] = $ar;
                                    break;
                            }
                        } ?>
                        <? foreach ($arShosse as $key => $value) { ?>
                            <div class="col-sm-6 col-lg-4 mb-4">
                                <div class="highway-block__title chart"
                                     onclick="smartFilter.click(this)"><?= $value['NAME'] ?></div>
                                <? foreach ($value['SHOSSE'] as $val => $ar): //dump($ar); // Шоссе?>
                                    <div class="custom-control custom-checkbox custom-control-inline align-items-center">
                                        <input
                                                type="checkbox"
                                                value="<? echo $ar["HTML_VALUE"] ?>"
                                                name="<? echo $ar["CONTROL_NAME"] ?>"
                                                id="<? echo $ar["CONTROL_ID"] ?>"
                                            <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                onclick="smartFilter.click(this)"
                                                class="custom-control-input changeHighway"
                                        />
                                        <label class="custom-control-label <? echo $ar["DISABLED"] ? 'disabled' : '' ?>"
                                               data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                               for="<? echo $ar["CONTROL_ID"] ?>"><?= $ar["VALUE"]; ?></label>
                                    </div>
                                <? endforeach; ?>
                            </div>
                        <? } ?>
                        <div class="col-12">
                            <button class="btn btn-warning" type="button" data-dismiss="modal" aria-label="Закрыть">
                                Готово
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно Районов-->
    <div class="modal" id="regionModal" tabindex="-1" role="dialog" aria-labelledby="regionModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <div class="text-uppercase chart" id="regionModalLabel">Район</div>
                        <button class="close btn-sm" type="button" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <? // Группируем районы по первым буквам названий
                        $prevLetter = '';
                        foreach ($arResult["ITEMS"][4]["VALUES"] as $key => $value) {
                            $firstLetter = mb_strtoupper(mb_substr($value['VALUE'], 0, 1));
                            if ($firstLetter != $prevLetter) $prevLetter = $firstLetter;
                            $arRegion[$firstLetter][] = $value;
                        } // dump($arRegion);?>
                        <? foreach ($arRegion as $key => $value) { ?>
                            <div class="col-sm-6 col-lg-4 mb-4">
                                <div class="highway-block__title chart"><?= $key ?></div>
                                <? foreach ($value as $val => $ar): //dump($ar); // Шоссе?>
                                    <div class="custom-control custom-checkbox custom-control-inline align-items-center">
                                        <input
                                                type="checkbox"
                                                value="<? echo $ar["HTML_VALUE"] ?>"
                                                name="<? echo $ar["CONTROL_NAME"] ?>"
                                                id="<? echo $ar["CONTROL_ID"] ?>"
                                            <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                onclick="smartFilter.click(this)"
                                                class="custom-control-input changeAreas"
                                        />
                                        <label class="custom-control-label <? echo $ar["DISABLED"] ? 'disabled' : '' ?>"
                                               data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                               for="<? echo $ar["CONTROL_ID"] ?>"><?= $ar["VALUE"]; ?></label>
                                    </div>
                                <? endforeach; ?>
                            </div>
                        <? } ?>
                        <div class="col-12">
                            <button class="btn btn-warning" type="button" data-dismiss="modal" aria-label="Закрыть">
                                Готово
                            </button>
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
