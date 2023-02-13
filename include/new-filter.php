<form class="row hero__form" action="" method="post" id="filterIndex">
  <div class="form-wrap">
    <div class="col-6 col-sm-4 col-md-2 col-xl-2 pr-2 pr-xl-3 col-type">
      <select class="select-bg-white changeFilterType filterCalc" name="FILTER_TYPE">
        <option value="filterVillage" selected>Поселки</option>
        <option value="filterPlots">Участки</option>
        <option value="filterHouse">Дома</option>
      </select>
    </div>
    <div class="col-6 col-sm-5 col-md-2 col-xl-1 pl-2 pl-xl-3 pr-xl-0">
      <button class="btn btn-outline-warning btn-highway rounded-pill w-100 Highway" type="button" data-toggle="modal" data-target="#highwayModal">Шоссе</button>
    </div>
    <div class="col-12 col-sm-4 col-md-3 col-xl-3 col-inline">
      <div class="form-group form-group-inline">
        <label>от МКАД, км</label>
      </div>
      <div class="row">
        <div class="col-6 pr-2">
          <input placeholder="От" type="text" name="MKAD_MIN" class="form-control km filterCalc"/>
        </div>
        <div class="col-6 pl-2">
          <input placeholder="До" type="text" name="MKAD_MAX" class="form-control km mr-0 filterCalc"/>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-4 col-md-3 col-xl-4 col-inline">
      <div class="form-group form-group-inline">
        <label>
          Стоимость, <span class="rub">a</span>
        </label>
      </div>
      <div class="row">
        <div class="col-6 pr-2">
          <input placeholder="От" type="text" name="COST_LAND_IN_CART_MIN" class="form-control filterCalc"/>
        </div>
        <div class="col-6 pr-2">
          <input placeholder="До" type="text" name="COST_LAND_IN_CART_MAX" class="form-control filterCalc"/>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-4 col-md-2 pl-sm-0">
      <input class="btn btn-warning w-100" id="filterSend" type="submit" value="Подобрать" disabled>
    </div>
  </div>

  <div class="col-12">
    <button class="w-100 btn btn-secondary other-parameters rounded-pill" type="button" data-toggle="modal" data-target="#townshipModal">
      Дополнительные параметры
    </button>
  </div>

  <!-- Modal Шоссе -->
  <div class="modal fade highway" id="highwayModal" tabindex="-1" role="dialog" aria-labelledby="highwayLongTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="d-flex w-100 justify-content-between align-items-center">
            <div class="text-uppercase chart" id="highwayModalLabel">Шоссе</div>
            <button class="close add-filter__close" type="button" data-dismiss="modal" aria-label="Close">
              <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M17.4375 0.5625L0.5625 17.4375" stroke="#9DABB2" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M0.5625 0.5625L17.4375 17.4375" stroke="#9DABB2" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round"></path>
              </svg>
            </button>
          </div>
        </div>
        <div class="modal-body">
          <div class="row">
            <?
              use Bitrix\Main\Loader;
              	Loader::includeModule('highloadblock');
              use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;

              // получим шоссе
              $arShosse['sever']['NAME'] = 'Север';
              $arShosse['sever-vostok']['NAME'] = 'Северо-Восток';
              $arShosse['sever-zapad']['NAME'] = 'Северо-Запад';
              $arShosse['ug']['NAME'] = 'Юг';
              $arShosse['ug-vostok']['NAME'] = 'Юго-Восток';
              $arShosse['ug-zapad']['NAME'] = 'Юго-Запад';
              $arShosse['vostok']['NAME'] = 'Восток';
              $arShosse['zapad']['NAME'] = 'Запад';
              $arShosse['other']['NAME'] = 'Другие';

              $arHighway = getElHL(16,[],[],['ID','UF_XML_ID','UF_NAME']);
              foreach ($arHighway as $highway) {
                switch ($highway['UF_XML_ID']) {
                  case 'dmitrovskoe':
                      $arShosse['sever']['SHOSSE'][] = $highway;
                      break;
                  case 'rogachevskoe':
                      $arShosse['sever']['SHOSSE'][] = $highway;
                      break;
                  case 'leningradskoe':
                      $arShosse['sever']['SHOSSE'][] = $highway;
                      break;
                  case 'yaroslavskoe':
                      $arShosse['sever-vostok']['SHOSSE'][] = $highway;
                      break;
                  case 'novorijskoe':
                      $arShosse['sever-zapad']['SHOSSE'][] = $highway;
                      break;
                  case 'pyatnickoe':
                      $arShosse['sever-zapad']['SHOSSE'][] = $highway;
                      break;
                  case 'volokolamskoe':
                      $arShosse['sever-zapad']['SHOSSE'][] = $highway;
                      break;
                  case 'varshavskoe':
                      $arShosse['ug']['SHOSSE'][] = $highway;
                      break;
                  case 'simferopolskoe':
                      $arShosse['ug']['SHOSSE'][] = $highway;
                      break;
                  case 'egorievskoe':
                      $arShosse['ug-vostok']['SHOSSE'][] = $highway;
                      break;
                  case 'kashirskoe':
                      $arShosse['ug']['SHOSSE'][] = $highway;
                      break;
                  case 'novoryazanskoe':
                      $arShosse['ug-vostok']['SHOSSE'][] = $highway;
                      break;
                  case 'kievskoe':
                      $arShosse['ug-zapad']['SHOSSE'][] = $highway;
                      break;
                  case 'kalujskoe':
                      $arShosse['ug-zapad']['SHOSSE'][] = $highway;
                      break;
                  case 'shelkovskoe':
                      $arShosse['vostok']['SHOSSE'][] = $highway;
                      break;
                  case 'gorkovskoe':
                      $arShosse['vostok']['SHOSSE'][] = $highway;
                      break;
                  case 'nosovihinskoe':
                      $arShosse['vostok']['SHOSSE'][] = $highway;
                      break;
                  case 'minskoe':
                      $arShosse['zapad']['SHOSSE'][] = $highway;
                      break;
                  case 'rublevo-uspenskoe':
                      $arShosse['zapad']['SHOSSE'][] = $highway;
                      break;
                  case 'mozhayskoe':
                      $arShosse['zapad']['SHOSSE'][] = $highway;
                      break;
                  default:
                      $arShosse['other']['SHOSSE'][] = $highway;
                      break;
                }
              }
              foreach ($arShosse as $shosse) {?>
                <div class="col-sm-6 col-lg-4 mb-4">
                  <div class="highway-block__title chart"><?=$shosse['NAME']?></div>
                  <?foreach ($shosse['SHOSSE'] as $highway):?>
                    <div class="custom-control custom-checkbox custom-control-inline align-items-center">
                      <input type="checkbox" value="<?=$highway["UF_XML_ID"]?>" name="SHOSSE" class="custom-control-input changeHighway" id="<?=$highway["UF_XML_ID"]?>"/>
                      <label class="custom-control-label" data-role="label_<?=$highway["UF_XML_ID"]?>" for="<?=$highway["UF_XML_ID"]?>"><?=$highway['UF_NAME']?></label>
                    </div>
                  <?endforeach;?>
                </div>
              <?}?>
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

  <!-- Modal Район-->
  <div class="modal fade region" id="regionModal" tabindex="-1" role="dialog" aria-labelledby="regionLongTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="d-flex w-100 justify-content-between align-items-center">
            <div class="text-uppercase chart" id="regionModalLabel">Район</div>
            <button class="close add-filter__close" type="button" data-dismiss="modal" aria-label="Close">
              <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M17.4375 0.5625L0.5625 17.4375" stroke="#9DABB2" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M0.5625 0.5625L17.4375 17.4375" stroke="#9DABB2" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round"></path>
              </svg>
            </button>
          </div>
        </div>
        <div class="modal-body">
          <div class="row">
            <?$arRegionHL = getElHL(17,['UF_NAME'=>'ASC'],[],['ID','UF_XML_ID','UF_NAME']);
            foreach ($arRegionHL as $region) {
              $firstLetter = mb_strtoupper(mb_substr($region['UF_NAME'], 0, 1));
              if ($firstLetter != $prevLetter) $prevLetter = $firstLetter;
              $arRegion[$firstLetter][] = $region;
            }
            foreach ($arRegion as $key => $value) {?>
              <div class="col-sm-6 col-lg-4 mb-4">
                <div class="highway-block__title chart"><?=$key?></div>
                <?foreach ($value as $ar) {?>
                  <div class="custom-control custom-checkbox custom-control-inline align-items-center">
                    <input type="checkbox" value="<?=$ar['UF_XML_ID']?>" name="REGION" id="<?=$ar['UF_XML_ID']?>" class="custom-control-input changeAreas">
                    <label class="custom-control-label " data-role="label_<?=$ar['UF_XML_ID']?>" for="<?=$ar['UF_XML_ID']?>"><?=$ar['UF_NAME']?></label>
                  </div>
                <?}?>
              </div>
            <?}?>
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

  <!-- Modal Поселки -->
  <div class="modal fade add-filter__modal" id="townshipModal" tabindex="-1" role="dialog"
    aria-labelledby="townshipModalLongTitle" aria-hidden="true">
    <div class="modal-dialog add-filter__modal-xxl" role="document">
        <div class="modal-content add-modal__content">
          <div class="add-filter__header">
            <h5 class="modal-title add-filter__title" id="townshipModalLongTitle">Дополнительные параметры
            </h5>
            <button type="button" class="close add-filter__close" data-dismiss="modal" aria-label="Close">
              <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M17.4375 0.5625L0.5625 17.4375" stroke="#9DABB2" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round" />
                <path d="M0.5625 0.5625L17.4375 17.4375" stroke="#9DABB2" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </button>
          </div>
          <div class="modal-body add-filter__modal-body">
            <div class="add-filter__modal-top">
              <div class="add-filter__region">
                <a class="btn btn-outline-warning rounded-pill w-100 add-filter__region-txt"
                  href="#regionModal" data-toggle="modal" data-target="#regionModal">Районы МО</a>
              </div>
              <div class="add-filter__search">
                <div class="add-filter__search-group">
                  <input class="form-control add-filter__search-input searchWord" type="text"
                    name="search_term_string" placeholder="Поиск по ключевым словам">
                  <div class="input-group-append">
                    <button class="btn btn-outline-success add-filter__search-button searchButton" type="button">Поиск
                    </button>
                  </div>
                </div>
              </div>
              <div class="add-filter__size">
                <label class="add-filter__size-label">Участок, сот.</label>
                <input placeholder="От" type="text" class="form-control add-filter__size-input filterCalc" name="PLOTTAGE_MIN">
                <input placeholder="До" type="text" class="form-control add-filter__size-input filterCalc" name="PLOTTAGE_MAX">
              </div>
              <div class="add-filter__distance-st">
                <label for="RAILWAY_KM" class="add-filter__distance-st-label">Расстояние&nbsp;<br>до
                  бл.станции, км</label>
                <input type="text" class="form-control add-filter__distance-st-input filterCalc" name="RAILWAY_KM" id="RAILWAY_KM">
              </div>
              <div class="add-filter__modal-center">
                <div class="custom-checkbox custom-control-inline align-items-center h-100 add-filter__checkbox">
                  <input type="checkbox" class="custom-control-input filterCalc" value="dacha"
                    name="TYPE_PERMITTED" id="dacha1">
                  <label class="custom-control-label add-filter__checkbox-label"
                    data-role="label_dacha1" for="dacha1">Дачный</label>
                </div>
                <div class="custom-checkbox custom-control-inline align-items-center h-100 add-filter__checkbox">
                  <input type="checkbox" class="custom-control-input filterCalc" value="cottage"
                    name="TYPE_PERMITTED" id="ihs1">
                  <label class="custom-control-label add-filter__checkbox-label" data-role="label_ihs1"
                    for="ihs1">ИЖС</label>
                </div>
                <div class="custom-checkbox custom-control-inline align-items-center h-100 add-filter__checkbox">
                  <input type="checkbox" class="custom-control-input filterCalc" value="Y" name="INS" id="INS1">
                  <label class="custom-control-label add-filter__checkbox-label" data-role="label_INS1" for="INS1">Доступна рассрочка</label>
                </div>
                <div class="custom-checkbox custom-control-inline align-items-center h-100 add-filter__checkbox">
                  <input type="checkbox" class="custom-control-input filterCalc" value="Y" name="ACTION" id="ACTION">
                  <label class="custom-control-label add-filter__checkbox-label" data-role="label_ACTION" for="ACTION">Поселки с акциями</label>
                </div>
              </div>
            </div>

            <div class="hero add-filter__hero">
              <div class="extra-options">
                <div class="row extra-options__parameters add-filter__extra-options">
                  <div class="order-lg-1 col-md-3 col-lg-2 col-sm-4 col-4 add-modal__order">
                    <div class="extra-options__parameters-title">Коммуникация</div>
                    <div class="extra-options__parameters-input">
                      <input type="checkbox" class="sr-only filterCalc" value="Y"
                        name="ELECTRO" id="ELECTRO">
                      <label class="d-flex w-100 align-items-center"
                        data-role="label_ELECTRO"
                        for="ELECTRO"><span class="icon icon--svet">
                          <svg xmlns="http://www.w3.org/2000/svg" width="23.032" height="24"
                            viewBox="0 0 23.032 24" class="inline-svg">
                            <g transform="translate(-9.8)">
                              <path
                                d="M24.052,20.973v.7a1.112,1.112,0,0,1-.943,1.1l-.173.637A.793.793,0,0,1,22.17,24H20.457a.793.793,0,0,1-.765-.588l-.168-.637a1.117,1.117,0,0,1-.948-1.106v-.7a.674.674,0,0,1,.677-.677h4.123A.682.682,0,0,1,24.052,20.973Zm3.175-9.452a5.883,5.883,0,0,1-1.659,4.1,5.422,5.422,0,0,0-1.452,2.943.978.978,0,0,1-.968.825H19.479a.968.968,0,0,1-.963-.82,5.482,5.482,0,0,0-1.462-2.953,5.912,5.912,0,1,1,10.173-4.1Zm-5.244-3.58a.667.667,0,0,0-.667-.667,4.271,4.271,0,0,0-4.267,4.267.667.667,0,1,0,1.333,0,2.937,2.937,0,0,1,2.933-2.933A.664.664,0,0,0,21.983,7.941Zm-.667-4.272A.667.667,0,0,0,21.983,3V.667a.667.667,0,0,0-1.333,0V3A.667.667,0,0,0,21.316,3.669Zm-7.847,7.847a.667.667,0,0,0-.667-.667H10.467a.667.667,0,1,0,0,1.333H12.8A.664.664,0,0,0,13.469,11.516Zm18.7-.667H29.83a.667.667,0,1,0,0,1.333h2.336a.667.667,0,1,0,0-1.333ZM14.827,17.067l-1.654,1.654a.665.665,0,0,0,.938.943l1.654-1.654a.665.665,0,0,0-.938-.943Zm12.509-10.9A.666.666,0,0,0,27.8,5.97l1.654-1.654a.667.667,0,1,0-.943-.943L26.862,5.027a.665.665,0,0,0,0,.943A.677.677,0,0,0,27.336,6.163Zm-12.509-.2a.665.665,0,0,0,.938-.943L14.111,3.368a.667.667,0,1,0-.943.943ZM27.8,17.067a.667.667,0,1,0-.943.943l1.654,1.654a.665.665,0,1,0,.938-.943Z"
                                class="color-fill"></path>
                            </g>
                          </svg></span><span class="text"><span>Свет</span></span></label>
                    </div>
                    <div class="extra-options__parameters-input">
                      <input type="checkbox" class="sr-only filterCalc" value="Y"
                        name="PLUMBING" id="PLUMBING">
                      <label class="d-flex w-100 align-items-center"
                        data-role="label_PLUMBING"
                        for="PLUMBING"><span class="icon icon--voda">
                          <svg xmlns="http://www.w3.org/2000/svg" width="15.782"
                            height="22.051" viewBox="0 0 15.782 22.051" class="inline-svg">
                            <g transform="translate(-35.275 0)">
                              <g transform="translate(35.275 0)">
                                <path
                                  d="M44.09.76c-.6-1.031-1.244-1-1.848,0-2.772,4.123-6.967,10.308-6.967,13.4a7.891,7.891,0,1,0,15.782,0C51.057,11.033,46.862,4.883,44.09.76Zm4.763,16.919a6.749,6.749,0,0,1-2.381,2.31.955.955,0,0,1-.924-1.671,4.705,4.705,0,0,0,1.706-1.635,4.634,4.634,0,0,0,.711-2.275.943.943,0,0,1,1.884.107A7.042,7.042,0,0,1,48.853,17.679Z"
                                  transform="translate(-35.275 0)" class="color-fill">
                                </path>
                              </g>
                            </g>
                          </svg></span><span class="text"><span>Вода</span></span></label>
                    </div>
                    <div class="extra-options__parameters-input">
                      <input type="checkbox" class="sr-only filterCalc" value="Y"
                        name="GAS" id="GAS">
                      <label class="d-flex w-100 align-items-center"
                        data-role="label_GAS"
                        for="GAS"><span class="icon icon--gaz">
                          <svg xmlns="http://www.w3.org/2000/svg" width="17.883"
                            height="23.844" viewBox="0 0 17.883 23.844" class="inline-svg">
                            <g transform="translate(-64 0)">
                              <g transform="translate(64 0)">
                                <path
                                  d="M81.832,13.96C81.559,10.4,79.9,8.176,78.442,6.209,77.09,4.389,75.922,2.817,75.922.5a.5.5,0,0,0-.27-.442.492.492,0,0,0-.516.038,12.633,12.633,0,0,0-4.663,6.739,22,22,0,0,0-.511,5.038c-2.026-.433-2.485-3.463-2.49-3.5A.5.5,0,0,0,66.764,8c-.106.051-2.607,1.322-2.753,6.4-.01.169-.011.338-.011.507a8.951,8.951,0,0,0,8.941,8.941.069.069,0,0,0,.02,0h.006A8.952,8.952,0,0,0,81.883,14.9C81.883,14.654,81.832,13.96,81.832,13.96Zm-8.89,8.889a3.086,3.086,0,0,1-2.98-3.175c0-.06,0-.12,0-.194a4.027,4.027,0,0,1,.314-1.577,1.814,1.814,0,0,0,1.64,1.188.5.5,0,0,0,.5-.5,9.937,9.937,0,0,1,.191-2.259,4.8,4.8,0,0,1,1.006-1.9,6.4,6.4,0,0,0,1.024,1.879,5.659,5.659,0,0,1,1.273,3.1c.006.085.013.171.013.263A3.086,3.086,0,0,1,72.941,22.849Z"
                                  transform="translate(-64 0)" class="color-fill">
                                </path>
                              </g>
                            </g>
                          </svg></span><span class="text"><span>Газ</span></span></label>
                    </div>
                  </div>
                  <div class="order-lg-2 col-md-6 col-lg-3 col-xl-2 col-sm-8 col-8 add-filter__par-2">
                    <div class="extra-options__parameters-title mb-3">Дороги в поселке</div>
                    <div class="row">
                      <div class="col-sm-6 col-lg-12 col-6 add-modal100">
                        <div class="extra-options__parameters-input">
                          <input type="checkbox" class="sr-only filterCalc" value="asph_crumb"
                            name="ROADS_IN_VIL" id="ROADS_IN_VIL1">
                          <label class="d-flex w-100 align-items-center"
                            data-role="label_ROADS_IN_VIL1"
                            for="ROADS_IN_VIL1">
                            <span class="icon icon--asphkr"><svg
                                xmlns="http://www.w3.org/2000/svg" width="25.494"
                                height="19.831" viewBox="0 0 25.494 19.831"
                                class="inline-svg">
                                <path
                                  d="M15.668,65.8a3.187,3.187,0,1,0-3.187,3.187A3.186,3.186,0,0,0,15.668,65.8Zm-4.239,0a1.053,1.053,0,1,1,1.052,1.053A1.052,1.052,0,0,1,11.429,65.8Z"
                                  transform="translate(-6.877 -49.158)" fill="#4a7aff"
                                  class="color-fill"></path>
                                <path
                                  d="M63,33.634v6.5a6.276,6.276,0,0,1,1.052-.043,3.811,3.811,0,0,1,3.426,1.7,1.362,1.362,0,0,1,.985-.423H71.65v-4.78l-1.935-2.959Zm7.284,5.008H66.642V35h2.731l.91,1.451Z"
                                  transform="translate(-46.611 -27.716)"
                                  fill="#4a7aff" class="color-fill"></path>
                                <path
                                  d="M1.337,30.418s7.512,1.393,8.508,5.008h3.442s.427-2.276,2.191-2.9V24.955h8.009l1.323-1.821H14.568l-1.252,2.731H0v1.821H1.366Z"
                                  transform="translate(0 -19.947)" fill="#4a7aff"
                                  class="color-fill"></path>
                                <path
                                  d="M82.705,66.885a.5.5,0,0,0-.455.455v.91a.455.455,0,0,0,.455.455h3.187a.456.456,0,0,0,.455-.455v-.91a.456.456,0,0,0-.455-.455Z"
                                  transform="translate(-60.854 -52.317)"
                                  fill="#4a7aff" class="color-fill"></path>
                                <path
                                  d="M61.171,65.8c0-.043,0-.085-.006-.127a3.106,3.106,0,1,0,.006.127Zm-4.239,0a1.053,1.053,0,1,1,1.052,1.053A1.052,1.052,0,0,1,56.932,65.8Z"
                                  transform="translate(-40.543 -49.158)"
                                  fill="#4a7aff" class="color-fill"></path>
                                <path
                                  d="M18.038,13.853,17.563,12.7H16.2L15,10.884H13.238L11.36,13.16H9.918l-1.29,1.366H7.642L6.125,15.892H17.051Z"
                                  transform="translate(-4.532 -10.884)" fill="#4a7aff"
                                  class="color-fill"></path>
                              </svg>
                            </span>
                            <span class="text"><span>Асф. кр.</span></span>
                          </label>
                        </div>
                        <div class="extra-options__parameters-input">
                          <input type="checkbox" class="sr-only filterCalc" value="asphalt"
                            name="ROADS_IN_VIL" id="ROADS_IN_VIL2">
                          <label class="d-flex w-100 align-items-center"
                            data-role="label_ROADS_IN_VIL2"
                            for="ROADS_IN_VIL2">
                            <span class="icon icon--asphalt"><svg
                                xmlns="http://www.w3.org/2000/svg" width="29.999"
                                height="17.912" viewBox="0 0 29.999 17.912"
                                class="inline-svg">
                                <g transform="translate(0 -106.273)">
                                  <path
                                    d="M27.4,113.989a3.179,3.179,0,0,1,.032.427.886.886,0,0,1-.221.6,5.738,5.738,0,0,0-10.37,1.356H10.58a3.331,3.331,0,0,0-.318-.707l6.264.007a5.445,5.445,0,0,1,2.058-2.836H15.842l-2.118-6.172a.514.514,0,0,0-.5-.387H7.739a.514.514,0,0,0-.514.514v6.387a.507.507,0,0,0,.043.2v.61H6.045a3.391,3.391,0,0,0-2.426,1.019,4.647,4.647,0,1,0,5.676,4.53c0-.093-.008-.184-.014-.276h.453A4.272,4.272,0,0,1,9.2,121.9H17.36a7.193,7.193,0,0,1-1.4-2.636h.764a5.739,5.739,0,0,0,10.931.924,3.18,3.18,0,0,0-.257-6.2ZM4.648,122.642a3.1,3.1,0,1,1,3.1-3.105A3.108,3.108,0,0,1,4.648,122.642Zm3.605-9.982V107.3h4.573l1.924,5.358Zm14.076,1.179a4.193,4.193,0,0,1,3.44,1.8,17.969,17.969,0,0,1-3.345.113,2.462,2.462,0,0,0-.347-.026H19.557a2.446,2.446,0,0,0-.813.14A4.2,4.2,0,0,1,22.329,113.839Zm0,8.395a4.206,4.206,0,0,1-4.015-2.973H19.1a2.159,2.159,0,0,0,.217-.012c.08.007.16.012.242.012h2.521c.087,0,.174-.006.259-.015a3.165,3.165,0,0,0,2.358,1.053H25.86A4.2,4.2,0,0,1,22.329,122.234Z"
                                    fill="#6aa3a5" class="color-fill"></path>
                                </g>
                              </svg>
                            </span>
                            <span class="text"><span>Асфальт</span></span>
                          </label>
                        </div>
                        <div class="extra-options__parameters-input">
                          <input type="checkbox" class="sr-only filterCalc" value="plate"
                            name="ROADS_IN_VIL" id="ROADS_IN_VIL3">
                          <label class="d-flex w-100 align-items-center"
                            data-role="label_ROADS_IN_VIL3"
                            for="ROADS_IN_VIL3">
                            <span class="icon icon--betonniePliti"><svg
                                xmlns="http://www.w3.org/2000/svg" width="32.279"
                                height="14.797" viewBox="0 0 32.279 14.797"
                                class="inline-svg">
                                <path
                                  d="M1124.235,447.06l19.645-6.654,12.634,3.666v3.666l-20.391,7.464-11.888-3.777Z"
                                  transform="translate(-1124.235 -440.406)"
                                  class="color-fill"></path>
                              </svg>
                            </span>
                            <span class="text"><span>Бетонные плиты</span></span>
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-6 col-lg-12 col-6 add-modal100">
                        <div class="extra-options__parameters-input">
                          <input type="checkbox" class="sr-only filterCalc" value="brick"
                            name="ROADS_IN_VIL" id="ROADS_IN_VIL4">
                          <label class="d-flex w-100 align-items-center"
                            data-role="label_ROADS_IN_VIL4"
                            for="ROADS_IN_VIL4">
                            <span class="icon icon--bitiyKirpich"><svg
                                xmlns="http://www.w3.org/2000/svg" width="26.034"
                                height="16.567" viewBox="0 0 26.034 16.567"
                                class="inline-svg">
                                <g transform="translate(0 -85.333)">
                                  <g transform="translate(2.367 88.883)">
                                    <g transform="translate(0 0)">
                                      <path
                                        d="M49.175,149.333H43.258a.592.592,0,0,0-.592.592v1.183a.592.592,0,0,0,.592.592h5.917a.592.592,0,0,0,.592-.592v-1.183A.592.592,0,0,0,49.175,149.333Z"
                                        transform="translate(-42.666 -149.333)"
                                        class="color-fill"></path>
                                    </g>
                                  </g>
                                  <g transform="translate(10.65 88.883)">
                                    <g transform="translate(0 0)">
                                      <path
                                        d="M198.509,149.333h-5.917a.592.592,0,0,0-.592.592v1.183a.592.592,0,0,0,.592.592h5.917a.592.592,0,0,0,.592-.592v-1.183A.592.592,0,0,0,198.509,149.333Z"
                                        transform="translate(-192 -149.333)"
                                        class="color-fill"></path>
                                    </g>
                                  </g>
                                  <g transform="translate(16.567 92.433)">
                                    <g transform="translate(0 0)">
                                      <path
                                        d="M305.176,213.333h-5.917a.592.592,0,0,0-.592.592v1.183a.592.592,0,0,0,.592.592h5.917a.592.592,0,0,0,.592-.592v-1.183A.592.592,0,0,0,305.176,213.333Z"
                                        transform="translate(-298.667 -213.333)"
                                        class="color-fill"></path>
                                    </g>
                                  </g>
                                  <g transform="translate(18.934 95.983)">
                                    <g transform="translate(0 0)">
                                      <path
                                        d="M347.842,277.333h-5.917a.592.592,0,0,0-.592.592v1.183a.592.592,0,0,0,.592.592h5.917a.592.592,0,0,0,.592-.592v-1.183A.592.592,0,0,0,347.842,277.333Z"
                                        transform="translate(-341.333 -277.333)"
                                        class="color-fill"></path>
                                    </g>
                                  </g>
                                  <g transform="translate(0 99.534)">
                                    <g transform="translate(0 0)">
                                      <path
                                        d="M6.509,341.333H.592a.592.592,0,0,0-.592.592v1.183a.592.592,0,0,0,.592.592H6.509a.592.592,0,0,0,.592-.592v-1.183A.592.592,0,0,0,6.509,341.333Z"
                                        transform="translate(0 -341.333)"
                                        class="color-fill"></path>
                                    </g>
                                  </g>
                                  <g transform="translate(10.65 95.983)">
                                    <g transform="translate(0 0)">
                                      <path
                                        d="M198.509,277.333h-5.917a.592.592,0,0,0-.592.592v1.183a.592.592,0,0,0,.592.592h5.917a.592.592,0,0,0,.592-.592v-1.183A.592.592,0,0,0,198.509,277.333Z"
                                        transform="translate(-192 -277.333)"
                                        class="color-fill"></path>
                                    </g>
                                  </g>
                                  <g transform="translate(16.567 99.534)">
                                    <g transform="translate(0 0)">
                                      <path
                                        d="M305.176,341.333h-5.917a.592.592,0,0,0-.592.592v1.183a.592.592,0,0,0,.592.592h5.917a.592.592,0,0,0,.592-.592v-1.183A.592.592,0,0,0,305.176,341.333Z"
                                        transform="translate(-298.667 -341.333)"
                                        class="color-fill"></path>
                                    </g>
                                  </g>
                                  <g transform="translate(8.284 99.534)">
                                    <g transform="translate(0 0)">
                                      <path
                                        d="M155.842,341.333h-5.917a.592.592,0,0,0-.592.592v1.183a.592.592,0,0,0,.592.592h5.917a.592.592,0,0,0,.592-.592v-1.183A.592.592,0,0,0,155.842,341.333Z"
                                        transform="translate(-149.333 -341.333)"
                                        class="color-fill"></path>
                                    </g>
                                  </g>
                                  <g transform="translate(2.367 95.983)">
                                    <g transform="translate(0 0)">
                                      <path
                                        d="M49.175,277.333H43.258a.592.592,0,0,0-.592.592v1.183a.592.592,0,0,0,.592.592h5.917a.592.592,0,0,0,.592-.592v-1.183A.592.592,0,0,0,49.175,277.333Z"
                                        transform="translate(-42.666 -277.333)"
                                        class="color-fill"></path>
                                    </g>
                                  </g>
                                  <g transform="translate(8.284 92.433)">
                                    <g transform="translate(0 0)">
                                      <path
                                        d="M155.842,213.333h-5.917a.592.592,0,0,0-.592.592v1.183a.592.592,0,0,0,.592.592h5.917a.592.592,0,0,0,.592-.592v-1.183A.592.592,0,0,0,155.842,213.333Z"
                                        transform="translate(-149.333 -213.333)"
                                        class="color-fill"></path>
                                    </g>
                                  </g>
                                  <g transform="translate(8.284 85.333)">
                                    <g transform="translate(0 0)">
                                      <path
                                        d="M155.842,85.333h-5.917a.592.592,0,0,0-.592.592v1.183a.592.592,0,0,0,.592.592h5.917a.592.592,0,0,0,.592-.592V85.925A.592.592,0,0,0,155.842,85.333Z"
                                        transform="translate(-149.333 -85.333)"
                                        class="color-fill"></path>
                                    </g>
                                  </g>
                                </g>
                              </svg>
                            </span>
                            <span class="text"><span>Битый кирпич</span></span>
                          </label>
                        </div>
                        <div class="extra-options__parameters-input">
                          <input type="checkbox" class="sr-only filterCalc" value="gravel"
                            name="ROADS_IN_VIL" id="ROADS_IN_VIL5">
                          <label class="d-flex w-100 align-items-center"
                            data-role="label_ROADS_IN_VIL5"
                            for="ROADS_IN_VIL5">
                            <span class="icon icon--gruntovka"><svg
                                xmlns="http://www.w3.org/2000/svg" width="18.04"
                                height="18.28" viewBox="0 0 18.04 18.28"
                                class="inline-svg">
                                <g transform="translate(-1.98 -3.683)">
                                  <g transform="translate(0.019 0)">
                                    <g transform="translate(0 0)">
                                      <path
                                        d="M53.195,406.049a9.752,9.752,0,0,1-4.184.271,7.843,7.843,0,0,1-3.278-1.177v4.244c0,.185.119.341.259.341H63.514c.14,0,.259-.156.259-.341v-.926c-.123-.119-1.534-1.416-5.421-2.472A9.364,9.364,0,0,0,53.195,406.049Z"
                                        transform="translate(-43.772 -387.765)"
                                        class="color-fill"></path>
                                      <path
                                        d="M53.195,309.228a9.751,9.751,0,0,1-4.184.271,7.844,7.844,0,0,1-3.278-1.177V311.3c0,.009.009.017.011.026.017.052.375,1.01,3.4,1.549a8.976,8.976,0,0,0,3.872-.264,10.145,10.145,0,0,1,5.536-.051,16.5,16.5,0,0,1,5.215,2.228V311.64c-.125-.12-1.537-1.417-5.421-2.472A9.371,9.371,0,0,0,53.195,309.228Z"
                                        transform="translate(-43.772 -295.097)"
                                        class="color-fill"></path>
                                      <path
                                        d="M53.195,203.887a9.757,9.757,0,0,1-4.184.272,7.845,7.845,0,0,1-3.278-1.177v3.348c0,.009.009.017.011.026.017.052.375,1.01,3.4,1.549a8.982,8.982,0,0,0,3.873-.264,10.147,10.147,0,0,1,5.536-.052,16.508,16.508,0,0,1,5.215,2.228V206.3c-.123-.119-1.534-1.416-5.421-2.472A9.37,9.37,0,0,0,53.195,203.887Z"
                                        transform="translate(-43.772 -194.275)"
                                        class="color-fill"></path>
                                      <path
                                        d="M49.148,91.289a8.977,8.977,0,0,0,3.872-.264,10.144,10.144,0,0,1,5.536-.052A16.5,16.5,0,0,1,63.771,93.2V87.1c-.024-.007-.049-.011-.073-.018l-2.451-.758a10.353,10.353,0,0,0-7.278.43L53.2,87.1a11.134,11.134,0,0,1-7.465.568v2.047c0,.009.009.017.011.026C45.76,89.793,46.118,90.75,49.148,91.289Z"
                                        transform="translate(-43.771 -82.178)"
                                        class="color-fill"></path>
                                    </g>
                                  </g>
                                </g>
                              </svg>
                            </span>
                            <span class="text"><span>Грунтовка</span></span>
                          </label>
                        </div>
                        <div class="extra-options__parameters-input">
                          <input type="checkbox" class="sr-only filterCalc" value="stone"
                            name="ROADS_IN_VIL" id="ROADS_IN_VIL6">
                          <label class="d-flex w-100 align-items-center"
                            data-role="label_ROADS_IN_VIL6"
                            for="ROADS_IN_VIL6">
                            <span class="icon icon--sheben"><svg
                                xmlns="http://www.w3.org/2000/svg" width="27.931"
                                height="19.233" viewBox="0 0 27.931 19.233"
                                class="inline-svg">
                                <g transform="translate(0 -64.055)">
                                  <path
                                    d="M.993,282.351l.529.052a1.557,1.557,0,0,0,1.436-.8l.1-.208a1.757,1.757,0,0,0,0-1.564,1.474,1.474,0,0,0-1.275-.577,2.65,2.65,0,0,0-1.31.546A2.3,2.3,0,0,0,0,281.255,1.127,1.127,0,0,0,.993,282.351Z"
                                    transform="translate(0 -206.082)"
                                    class="color-fill"></path>
                                  <path
                                    d="M70.239,293.68a3.17,3.17,0,0,1,1.252,1.038l1.232,1.727a1.791,1.791,0,0,0,1.566.665l1.161-.173a1.429,1.429,0,0,0,1.13-1.134l.315-2.172a1.553,1.553,0,0,0-.73-1.469l-2.042-1.126a2.317,2.317,0,0,0-1.791-.089l-.644.275a3.884,3.884,0,0,0-1.463,1.227l-.111.17C69.812,293.079,69.869,293.556,70.239,293.68Z"
                                    transform="translate(-66.273 -217.035)"
                                    class="color-fill"></path>
                                  <path
                                    d="M47.244,202.076l-1.517-.121a1.423,1.423,0,0,0-1.349.731,1.836,1.836,0,0,0,.23,1.619l.071.1c.321.444.768,1.131.992,1.525a1.1,1.1,0,0,0,1.337.355l.62-.242a4.262,4.262,0,0,0,1.514-1.095,1.353,1.353,0,0,0,0-1.541l-.319-.44A2.465,2.465,0,0,0,47.244,202.076Z"
                                    transform="translate(-41.97 -132.812)"
                                    class="color-fill"></path>
                                  <path
                                    d="M.46,225.377A2.666,2.666,0,0,1,1.7,224.8c.428-.069.548-.509.264-.979l-.21-.349a2.077,2.077,0,0,0-1.135-.948c-.341-.051-.619.356-.619.9v1.4C0,225.38.207,225.626.46,225.377Z"
                                    transform="translate(0 -152.309)"
                                    class="color-fill"></path>
                                  <path
                                    d="M148.3,247.989a2.032,2.032,0,0,0-1.595.641.767.767,0,0,0,.282,1.2l2.711,1.415a2.806,2.806,0,0,1,1.159,1.132,1.014,1.014,0,0,0,1.231.39l2.016-.592a.652.652,0,0,0,.364-1.082l-1.4-1.888a2.579,2.579,0,0,0-1.586-.9Z"
                                    transform="translate(-138.877 -176.443)"
                                    class="color-fill"></path>
                                  <path
                                    d="M212.911,345.447l1.511-.007a2.831,2.831,0,0,0,1.708-.7l1.27-1.25a1.1,1.1,0,0,0,.072-1.466l-2.546-3.051a1.721,1.721,0,0,0-1.6-.515l-3.1.807a1.648,1.648,0,0,0-1.117,1.237l-.085.553a2.4,2.4,0,0,0,.512,1.73l1.717,1.924A2.527,2.527,0,0,0,212.911,345.447Z"
                                    transform="translate(-198.102 -262.159)"
                                    class="color-fill"></path>
                                  <path
                                    d="M316.908,286.506a.838.838,0,0,0,1.226.037l1.161-.915a.766.766,0,0,0,.009-1.247l-.754-.612a1.681,1.681,0,0,0-1.665-.181l-.094.047c-.49.246-.716.727-.5,1.067a1.408,1.408,0,0,1,.283.884A1.479,1.479,0,0,0,316.908,286.506Z"
                                    transform="translate(-299.715 -210.056)"
                                    class="color-fill"></path>
                                  <path
                                    d="M360.794,333.2l.414.08a4.172,4.172,0,0,0,1.705-.04,1.236,1.236,0,0,0,.678-1.226l-.045-.945a1.847,1.847,0,0,0-.948-1.428l-1.645-.789a1.737,1.737,0,0,0-1.678.193l-.931.747a.955.955,0,0,0-.125,1.378l.942,1.087A3.38,3.38,0,0,0,360.794,333.2Z"
                                    transform="translate(-339.311 -252.965)"
                                    class="color-fill"></path>
                                  <path
                                    d="M411.046,247.9l-1.936-.494a2.469,2.469,0,0,0-1.8.33l-1.037.738a2.691,2.691,0,0,0-.962,1.525,1.305,1.305,0,0,0,.774,1.323l1.482.612a2.84,2.84,0,0,0,1.849.01l1.665-.632a1.68,1.68,0,0,0,1.009-1.367v-.795A1.448,1.448,0,0,0,411.046,247.9Z"
                                    transform="translate(-384.164 -175.845)"
                                    class="color-fill"></path>
                                  <path
                                    d="M298.393,222.316c.462-.3.4-.645-.129-.776l-2.241-.552a2.383,2.383,0,0,0-1.765.363l-2.162,1.634c-.438.331-.72.805-.627,1.053s.576.263,1.073.032l1.077-.5c.5-.231,1.024-.329,1.17-.217s.616.448,1.045.748.865.223.97-.172a2.646,2.646,0,0,1,1.03-1.255Z"
                                    transform="translate(-276.25 -150.814)"
                                    class="color-fill"></path>
                                  <path
                                    d="M403.714,157.394l-3.758-.808a1.436,1.436,0,0,0-1.468.667l-.8,1.469a.728.728,0,0,0,.493,1.109l1.6.381c.534.127,1.4.361,1.925.52l2.034.591a.763.763,0,0,0,1.037-.709V158.6A1.38,1.38,0,0,0,403.714,157.394Z"
                                    transform="translate(-376.841 -89.79)"
                                    class="color-fill"></path>
                                  <path
                                    d="M264.135,138.726l-.2-.729a2.417,2.417,0,0,0-1.181-1.366l-1.4-.623a2.483,2.483,0,0,0-1.813.02l-.6.285a1.554,1.554,0,0,0-.822,1.42l.051.63a.783.783,0,0,0,1.038.715l.493-.144a4.175,4.175,0,0,1,1.92-.015l1.83.5C263.972,139.568,264.284,139.255,264.135,138.726Z"
                                    transform="translate(-244.644 -70.157)"
                                    class="color-fill"></path>
                                  <path
                                    d="M262.3,203.721l-.625.217a1.325,1.325,0,0,0-.942,1.013,1.784,1.784,0,0,0,.451,1.122c.248.24.8.152,1.223-.2l1.689-1.385c.424-.348.406-.738-.041-.866A3.433,3.433,0,0,0,262.3,203.721Z"
                                    transform="translate(-247.132 -134.331)"
                                    class="color-fill"></path>
                                  <path
                                    d="M150.6,189.765l-3.947,1.015c-.531.137-.727.476-.435.755a3.069,3.069,0,0,0,1.523.617l2.479.277a1.007,1.007,0,0,0,1.107-.88l.122-1.042A.639.639,0,0,0,150.6,189.765Z"
                                    transform="translate(-138.468 -121.234)"
                                    class="color-fill"></path>
                                  <path
                                    d="M135.014,105.881a1.592,1.592,0,0,0-1.215-1.118l-1.781-.266a1.311,1.311,0,0,0-1.348.782l-1.119,2.879a1.721,1.721,0,0,0-.14,1.2c.122.15.652.147,1.179-.008l3.946-1.154a1.067,1.067,0,0,0,.729-1.251Z"
                                    transform="translate(-122.603 -40.43)"
                                    class="color-fill"></path>
                                  <path
                                    d="M380.577,144.683l-.282.083a1.1,1.1,0,0,0-.762,1.236c.107.525.454.588.771.14l.655-.927C381.275,144.768,381.1,144.528,380.577,144.683Z"
                                    transform="translate(-359.719 -78.487)"
                                    class="color-fill"></path>
                                </g>
                              </svg>
                            </span>
                            <span class="text"><span>Щебень</span></span>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="order-sm-5 col-sm-8 order-md-5 order-lg-3 col-md-6 col-lg-2 add-filter__par-3">
                    <div class="row">
                      <div class="col-sm-6 col-lg-12 col-4 add-modal50">
                        <div class="extra-options__parameters-title">Как добраться</div>
                        <div class="extra-options__parameters-input">
                          <input type="checkbox" class="sr-only filterCalc" value="Y"
                            name="BUS" id="BUS">
                          <label class="d-flex w-100 align-items-center"
                            data-role="label_BUS"
                            for="BUS"><span class="icon icon--bus">
                              <svg xmlns="http://www.w3.org/2000/svg" width="33.298"
                                height="17.762" viewBox="0 0 33.298 17.762"
                                class="inline-svg">
                                <path
                                  d="M.555,16.027h2.83A2.765,2.765,0,0,0,8.325,17.12a2.766,2.766,0,0,0,4.939-1.093h11.21a2.775,2.775,0,0,0,5.439,0h2.83a.555.555,0,0,0,.555-.555V11.259a7.2,7.2,0,0,0-.2-1.669l-1.212-5.1a2.226,2.226,0,0,0-2.177-1.785H13.107L12.154.8a.555.555,0,0,0-.5-.307H3.885a.555.555,0,0,0-.5.307L2.432,2.708H.555A.555.555,0,0,0,0,3.263V15.472A.555.555,0,0,0,.555,16.027Zm5.55,1.11a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,6.1,17.137Zm4.44,0a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,10.544,17.137Zm16.649,0a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,27.194,17.137Zm4.828-7.291c.006.026.008.051.013.077H27.748V6.038h3.369ZM4.228,1.6h7.084l.555,1.11H3.673ZM1.11,3.818h28.6a1.119,1.119,0,0,1,1.093.912l.05.2H1.11Zm25.529,2.22V9.923h-3.33V6.038Zm-4.44,0V9.923h-3.33V6.038Zm-4.44,0V9.923h-3.33V6.038Zm-4.44,0V9.923H9.989V6.038Zm-4.44,0V9.923H5.55V6.038Zm-7.77,0H4.44V9.923H1.11Zm0,7.215H2.22v-1.11H1.11v-1.11H32.175c0,.075.013.15.013.226v.884h-1.11v1.11h1.11v1.665H29.913a.147.147,0,0,0-.009-.029,2.745,2.745,0,0,0-.144-.462c-.022-.056-.051-.1-.076-.154a2.872,2.872,0,0,0-.16-.294c-.035-.056-.076-.106-.115-.158a2.862,2.862,0,0,0-.2-.238c-.047-.049-.095-.1-.145-.142a2.624,2.624,0,0,0-.234-.193q-.083-.061-.166-.116a2.955,2.955,0,0,0-.278-.149c-.059-.028-.116-.055-.177-.083a2.755,2.755,0,0,0-.333-.1c-.056-.014-.107-.033-.164-.044a2.631,2.631,0,0,0-1.054,0c-.056.011-.111.03-.164.044a2.768,2.768,0,0,0-.333.1c-.061.024-.118.056-.177.083a2.927,2.927,0,0,0-.278.149q-.083.055-.166.116a2.592,2.592,0,0,0-.234.193c-.05.046-.1.092-.145.142a2.954,2.954,0,0,0-.2.238c-.039.052-.079.1-.115.158a2.829,2.829,0,0,0-.16.294c-.025.052-.056.1-.076.154a2.767,2.767,0,0,0-.144.462.137.137,0,0,1-.009.029h-11.2a.147.147,0,0,0-.009-.029,2.787,2.787,0,0,0-.144-.462c-.022-.056-.051-.1-.076-.154a2.871,2.871,0,0,0-.16-.294c-.035-.056-.076-.106-.115-.158a2.907,2.907,0,0,0-.2-.238c-.047-.049-.095-.1-.145-.142a2.624,2.624,0,0,0-.234-.193q-.083-.061-.167-.116a2.923,2.923,0,0,0-.277-.149c-.059-.028-.116-.055-.177-.083a2.727,2.727,0,0,0-.33-.1c-.056-.014-.107-.033-.166-.044a2.583,2.583,0,0,0-1.033,0l-.086.016a2.767,2.767,0,0,0-.451.14l-.082.036a2.791,2.791,0,0,0-.42.228l-.022.017a2.789,2.789,0,0,0-.357.295l-.056.051a2.778,2.778,0,0,0-.235.272,2.827,2.827,0,0,0-.242-.278c-.018-.018-.036-.034-.056-.051a2.81,2.81,0,0,0-.357-.295l-.022-.017a2.8,2.8,0,0,0-.42-.228L7.146,12.9a2.792,2.792,0,0,0-.451-.14l-.086-.016a2.581,2.581,0,0,0-1.033,0c-.056.011-.111.03-.164.044a2.716,2.716,0,0,0-.333.1c-.061.024-.118.056-.177.083a2.91,2.91,0,0,0-.275.149c-.055.037-.111.075-.166.116a2.627,2.627,0,0,0-.234.193c-.05.046-.1.092-.145.142a2.832,2.832,0,0,0-.2.238c-.039.052-.079.1-.115.158a2.809,2.809,0,0,0-.16.294c-.025.052-.056.1-.076.154a2.732,2.732,0,0,0-.144.462.147.147,0,0,1-.009.029H1.11Zm0,0"
                                  transform="translate(0 -0.488)" fill="#3c4b5a">
                                </path>
                                <path d="M230.4,202.09h11.1v1.11H230.4Zm0,0"
                                  transform="translate(-217.079 -190.435)"
                                  fill="#3c4b5a"></path>
                              </svg></span><span
                              class="text"><span>Автобус</span></span></label>
                        </div>
                        <div class="extra-options__parameters-input">
                          <input type="checkbox" class="sr-only filterCalc" value="Y"
                            name="TRAIN" id="TRAIN">
                          <label class="d-flex w-100 align-items-center"
                            data-role="label_TRAIN"
                            for="TRAIN"><span class="icon icon--train">
                              <svg xmlns="http://www.w3.org/2000/svg" width="33.298"
                                height="13.319" viewBox="0 0 33.298 13.319"
                                class="inline-svg">
                                <path
                                  d="M250.156,139.33h2.22a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33A.555.555,0,0,0,250.156,139.33Zm.555-3.33h1.11v2.22h-1.11Zm0,0"
                                  transform="translate(-235.172 -132.671)"
                                  fill="#3c4b5a"></path>
                                <path
                                  d="M137.173,139.33a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33a.555.555,0,0,0,.555.555ZM135.509,136h1.11v2.22h-1.11Zm0,0"
                                  transform="translate(-126.629 -132.671)"
                                  fill="#3c4b5a"></path>
                                <path
                                  d="M60.376,139.33a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33a.555.555,0,0,0,.555.555ZM58.711,136h1.11v2.22h-1.11Zm0,0"
                                  transform="translate(-54.272 -132.671)"
                                  fill="#3c4b5a"></path>
                                <path
                                  d="M2.22,138.775v-3.33a.555.555,0,0,0-.555-.555H0V136H1.11v2.22H0v1.11H1.665A.555.555,0,0,0,2.22,138.775Zm0,0"
                                  transform="translate(0 -132.671)" fill="#3c4b5a">
                                </path>
                                <path d="M364.8,192.488h2.22v1.11H364.8Zm0,0"
                                  transform="translate(-343.712 -186.939)"
                                  fill="#3c4b5a"></path>
                                <path d="M460.8,230.887h1.11V232H460.8Zm0,0"
                                  transform="translate(-434.162 -223.117)"
                                  fill="#3c4b5a"></path>
                                <path d="M518.4,230.887h1.11V232H518.4Zm0,0"
                                  transform="translate(-488.43 -223.117)"
                                  fill="#3c4b5a"></path>
                                <path
                                  d="M15.242,96.488H0V97.6H12.209v6.66H0v1.11H12.209v1.11H0v1.11H2.775a2.2,2.2,0,0,0,.308,1.11H0v1.11H33.3V108.7H26.885a2.2,2.2,0,0,0,.308-1.11H29.72a3.578,3.578,0,0,0,2.291-6.327l-3.718-3.1a7.23,7.23,0,0,0-4.62-1.673h-8.43ZM4.995,108.7a1.11,1.11,0,0,1-1.11-1.11H6.1A1.11,1.11,0,0,1,4.995,108.7Zm3.33,0a1.11,1.11,0,0,1-1.11-1.11h2.22A1.11,1.11,0,0,1,8.325,108.7Zm4.995-3.33h5.55v1.11h-5.55Zm-3.083,3.33a2.2,2.2,0,0,0,.308-1.11H22.754a2.2,2.2,0,0,0,.309,1.11Zm14.738,0a1.11,1.11,0,0,1-1.11-1.11h2.22A1.11,1.11,0,0,1,24.974,108.7Zm3.573-8.879,2.664,2.22H25.973a.555.555,0,0,1-.427-.2l-1.682-2.02h4.683Zm-8.567,5.55h5.55v-1.11h-5.55V97.6h3.693a6.118,6.118,0,0,1,3.508,1.11H23.864a1.11,1.11,0,0,0-.852,1.82l1.685,2.02a1.661,1.661,0,0,0,1.277.6h6.049a2.439,2.439,0,0,1-2.3,3.33H19.979Zm-1.11-7.77v6.66h-5.55V97.6Z"
                                  transform="translate(0 -96.488)" fill="#3c4b5a">
                                </path>
                              </svg></span><span
                              class="text"><span>Электричка</span></span></label>
                        </div>
                      </div>
                      <div class="col-sm-6 col-lg-12 col-8 add-modal50">
                        <div class="extra-options__parameters-title mt-lg-5">Безопасность</div>
                        <div class="extra-options__parameters-input">
                          <input type="checkbox" class="sr-only filterCalc" value="fenced"
                            name="ARRANGE" id="ARRANGE1">
                          <label class="d-flex w-100 align-items-center"
                            data-role="label_ARRANGE1"
                            for="ARRANGE1">
                            <span class="icon icon--ogorozjen"><svg
                                xmlns="http://www.w3.org/2000/svg" width="22.974"
                                height="21.967" viewBox="0 0 22.974 21.967"
                                class="inline-svg">
                                <g transform="translate(0 -6.247)">
                                  <g transform="translate(0 6.247)">
                                    <rect width="1.904" height="2.188"
                                      transform="translate(6.206 6.28)"
                                      class="color-fill">
                                    </rect>
                                    <rect width="1.904" height="2.188"
                                      transform="translate(14.864 6.28)"
                                      class="color-fill">
                                    </rect>
                                    <rect width="1.904" height="2.188"
                                      transform="translate(6.206 16.781)"
                                      class="color-fill">
                                    </rect>
                                    <rect width="1.904" height="2.188"
                                      transform="translate(14.864 16.781)"
                                      class="color-fill"></rect>
                                    <path
                                      d="M3.3,6.516a.547.547,0,0,0-.942,0L.077,10.372A.537.537,0,0,0,0,10.65V27.666a.547.547,0,0,0,.547.547H5.112a.547.547,0,0,0,.546-.547V10.65a.546.546,0,0,0-.076-.278Z"
                                      transform="translate(0 -6.247)"
                                      class="color-fill"></path>
                                    <path
                                      d="M110.694,6.729a.568.568,0,0,0-.941,0l-2.283,3.857a.546.546,0,0,0-.076.278V27.88a.547.547,0,0,0,.546.547h4.567a.547.547,0,0,0,.546-.547V10.864a.542.542,0,0,0-.076-.278Z"
                                      transform="translate(-98.737 -6.461)"
                                      class="color-fill"></path>
                                    <path
                                      d="M220.384,10.586,218.1,6.729a.569.569,0,0,0-.942,0l-2.282,3.857a.545.545,0,0,0-.076.278V27.88a.547.547,0,0,0,.546.547h4.565a.548.548,0,0,0,.547-.547V10.864A.538.538,0,0,0,220.384,10.586Z"
                                      transform="translate(-197.487 -6.461)"
                                      class="color-fill"></path>
                                  </g>
                                </g>
                              </svg>
                            </span>
                            <span class="text"><span>Огорожен</span></span>
                          </label>
                        </div>
                        <div class="extra-options__parameters-input">
                          <input type="checkbox" class="sr-only filterCalc" value="security"
                            name="ARRANGE" id="ARRANGE2">
                          <label class="d-flex w-100 align-items-center"
                            data-role="label_ARRANGE2"
                            for="ARRANGE2">
                            <span class="icon icon--ohrana"><svg
                                xmlns="http://www.w3.org/2000/svg" width="19.974"
                                height="23.456" viewBox="0 0 19.974 23.456"
                                class="inline-svg">
                                <g transform="translate(0 0.001)">
                                  <path
                                    d="M124.911,158.457a4.469,4.469,0,1,0,4.469,4.469A4.474,4.474,0,0,0,124.911,158.457Zm2.653,3.627-3.2,3.2a.688.688,0,0,1-.973,0l-1.224-1.224a.688.688,0,0,1,.973-.973l.737.737,2.715-2.715a.688.688,0,0,1,.973.973Zm0,0"
                                    transform="translate(-114.924 -151.199)"
                                    class="color-fill"></path>
                                  <path
                                    d="M19.951,6.363V6.345c-.01-.225-.017-.464-.021-.729a2.486,2.486,0,0,0-2.341-2.435A9.647,9.647,0,0,1,11.023.413L11.008.4a1.5,1.5,0,0,0-2.04,0L8.952.413A9.648,9.648,0,0,1,2.387,3.181,2.486,2.486,0,0,0,.046,5.616c0,.263-.011.5-.021.729v.042c-.052,2.75-.118,6.173,1.027,9.279A11.812,11.812,0,0,0,3.885,20.08,14.824,14.824,0,0,0,9.43,23.36a1.715,1.715,0,0,0,.227.062,1.679,1.679,0,0,0,.66,0,1.716,1.716,0,0,0,.228-.062,14.833,14.833,0,0,0,5.54-3.282,11.829,11.829,0,0,0,2.834-4.415C20.068,12.547,20,9.118,19.951,6.363ZM9.987,17.573a5.846,5.846,0,1,1,5.846-5.846A5.852,5.852,0,0,1,9.987,17.573Zm0,0"
                                    transform="translate(0)" class="color-fill">
                                  </path>
                                </g>
                              </svg>
                            </span>
                            <span class="text"><span>Охрана</span></span>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="order-sm-4 col-sm-4 order-md-3 order-lg-5 order-xl-4 col-md-3 col-lg-2 add-filter__par-4 col-4">
                    <div class="extra-options__parameters-title">Природа</div>
                    <div class="extra-options__parameters-input">
                      <input class="sr-only filterCalc" type="checkbox" id="WATER" name="WATER">
                      <label class="d-flex w-100 align-items-center" for="WATER"><span
                          class="icon icon--vodoem">
                          <svg xmlns="http://www.w3.org/2000/svg" width="23.111"
                            height="14.182" viewBox="0 0 23.111 14.182" class="inline-svg">
                            <g transform="translate(0 -98.909)">
                              <g transform="translate(0 98.909)">
                                <g>
                                  <path
                                    d="M20.686,100.11a5.278,5.278,0,0,0-6.7,0,3.561,3.561,0,0,1-2.425.9,3.561,3.561,0,0,1-2.426-.9,5.078,5.078,0,0,0-3.352-1.2,5.078,5.078,0,0,0-3.352,1.2,3.561,3.561,0,0,1-2.426.9V103.9a3.561,3.561,0,0,0,2.426-.9,5.078,5.078,0,0,1,3.352-1.2A5.078,5.078,0,0,1,9.13,103a3.561,3.561,0,0,0,2.426.9,3.561,3.561,0,0,0,2.425-.9,5.278,5.278,0,0,1,6.7,0,3.561,3.561,0,0,0,2.425.9V101.01A3.561,3.561,0,0,1,20.686,100.11Z"
                                    transform="translate(0 -98.909)"
                                    class="color-fill"></path>
                                </g>
                              </g>
                              <g transform="translate(0 108.101)">
                                <g>
                                  <path
                                    d="M19.759,303.446a3.719,3.719,0,0,0-4.851,0,5.077,5.077,0,0,1-3.352,1.2,5.078,5.078,0,0,1-3.352-1.2,3.562,3.562,0,0,0-2.426-.9,3.561,3.561,0,0,0-2.426.9A5.078,5.078,0,0,1,0,304.647v2.889a5.078,5.078,0,0,0,3.352-1.2,3.561,3.561,0,0,1,2.426-.9,3.561,3.561,0,0,1,2.426.9,5.078,5.078,0,0,0,3.352,1.2,5.077,5.077,0,0,0,3.352-1.2,3.719,3.719,0,0,1,4.851,0,5.077,5.077,0,0,0,3.352,1.2v-2.889A5.077,5.077,0,0,1,19.759,303.446Z"
                                    transform="translate(0 -302.546)"
                                    class="color-fill"></path>
                                </g>
                              </g>
                              <g transform="translate(0 103.374)">
                                <g>
                                  <path
                                    d="M19.759,198.718a3.719,3.719,0,0,0-4.851,0,5.077,5.077,0,0,1-3.352,1.2,5.078,5.078,0,0,1-3.352-1.2,3.561,3.561,0,0,0-2.426-.9,3.561,3.561,0,0,0-2.426.9A5.077,5.077,0,0,1,0,199.919v3.152a3.561,3.561,0,0,0,2.426-.9,5.078,5.078,0,0,1,3.352-1.2,5.078,5.078,0,0,1,3.352,1.2,3.561,3.561,0,0,0,2.426.9,3.561,3.561,0,0,0,2.425-.9,5.278,5.278,0,0,1,6.7,0,3.561,3.561,0,0,0,2.425.9v-3.152A5.077,5.077,0,0,1,19.759,198.718Z"
                                    transform="translate(0 -197.818)"
                                    class="color-fill"></path>
                                </g>
                              </g>
                            </g>
                          </svg></span><span class="text"><span>Водоем</span></span></label>
                    </div>
                    <div class="extra-options__parameters-input">
                      <input class="sr-only filterCalc" type="checkbox" id="LES" name="LES">
                      <label class="d-flex w-100 align-items-center" for="LES"><span
                          class="icon icon--les">
                          <svg xmlns="http://www.w3.org/2000/svg" width="17.38"
                            height="24.833" viewBox="0 0 17.38 24.833" class="inline-svg">
                            <path
                              d="M72.266,7.657a4.88,4.88,0,0,0-.51-.475,2.01,2.01,0,0,0-1.871-2.747c-.065,0-.13,0-.194.009a4.838,4.838,0,0,0-8.9-2.2,3.412,3.412,0,0,0-3.306,5.4l-.012.013a4.841,4.841,0,0,0,3.549,8.133,4.93,4.93,0,0,0,.743-.056l1.787,2.76-.871,5.642a.6.6,0,0,0,.133.486.623.623,0,0,0,.476.211h3.186a.623.623,0,0,0,.476-.211.6.6,0,0,0,.133-.486l-.856-5.547,1.84-2.842a4.932,4.932,0,0,0,.652.044,4.841,4.841,0,0,0,3.549-8.133Zm-7.349,9.29-1.254-1.938a4.829,4.829,0,0,0,1.2-1.123,4.826,4.826,0,0,0,1.275,1.167Z"
                              transform="translate(-56.177)" class="color-fill"></path>
                          </svg></span><span class="text"><span>Лес</span></span></label>
                    </div>
                    <div class="extra-options__parameters-input">
                      <input type="checkbox" class="sr-only filterCalc" value="Y"
                        name="PLYAZH" id="PLYAZH">
                      <label class="d-flex w-100 align-items-center"
                        data-role="label_PLYAZH"
                        for="PLYAZH"><span class="icon icon--plyaj">
                          <svg xmlns="http://www.w3.org/2000/svg" width="21.889"
                            height="21.799" viewBox="0 0 21.889 21.799" class="inline-svg">
                            <g transform="translate(0 -0.093)">
                              <path
                                d="M21.565,18.948a.947.947,0,0,0-.744-.229,25.544,25.544,0,0,1-4.17.2,11.6,11.6,0,0,1-3-.558L10.325,8.835a37.7,37.7,0,0,1,7.317-1.6.943.943,0,0,0,.734-1.372A9.638,9.638,0,0,0,7.571.953L7.491.725A.942.942,0,0,0,6.29.146L6.274.151a.943.943,0,0,0-.579,1.2l.079.228A9.636,9.636,0,0,0,.368,12.113a.943.943,0,0,0,1.44.615A34.44,34.44,0,0,1,8.528,9.46l2.8,8.012c-2.261-.958-4.424-1.961-7.28-1.526A6.96,6.96,0,0,0,.237,18.28.95.95,0,0,0,0,18.9V20.95a.946.946,0,0,0,.947.943H20.942a.947.947,0,0,0,.948-.943v-1.3A.952.952,0,0,0,21.565,18.948Z"
                                class="color-fill"></path>
                            </g>
                          </svg></span><span class="text"><span>Пляж</span></span></label>
                    </div>
                  </div>
                  <div class="order-sm-3 col-sm-8 order-md-4 order-lg-4 order-xl-5 col-md-6 col-lg-3 col-xl-4 add-filter__par-5 col-8">
                    <div class="extra-options__parameters-title mb-3">Инфраструктура</div>
                    <div class="row">
                      <div class="col-sm-6 col-lg-12 col-xl-6 col-6 add-modal100">
                        <div class="extra-options__parameters-input">
                          <input class="sr-only filterCalc" type="checkbox" id="magazin"
                            name="MAGAZIN">
                          <label class="d-flex w-100 align-items-center" for="magazin"><span
                              class="icon icon--magazin">
                              <svg xmlns="http://www.w3.org/2000/svg" width="20.645"
                                height="20.616" viewBox="0 0 20.645 20.616"
                                class="inline-svg">
                                <g transform="translate(0 -0.338)">
                                  <g transform="translate(0 0.338)">
                                    <g transform="translate(0 0)">
                                      <path
                                        d="M19.964,230.45h0v-4.225a2.181,2.181,0,0,1-1.374.062v4.163H16.918V227.8a.452.452,0,0,0-.452-.452H14.937a.452.452,0,0,0-.452.452v2.647H12.451v-.424a.452.452,0,0,0-.452-.452H10.27a.452.452,0,0,0-.452.452v.424H7.212v-1.186a.453.453,0,0,0-.452-.452H4.183a.452.452,0,0,0-.452.452v1.186H2.722v-4.194a2.354,2.354,0,0,1-.687.113,2.353,2.353,0,0,1-.687-.113v4.194h0A1.006,1.006,0,0,0,.34,231.456v4.8a1,1,0,0,0,1.005,1.005H19.964a1.006,1.006,0,0,0,1.006-1.005v-4.8A1.007,1.007,0,0,0,19.964,230.45Z"
                                        transform="translate(-0.326 -216.642)"
                                        class="color-fill"></path>
                                      <path
                                        d="M101.684,110.245a.324.324,0,0,0-.325.324v2.359a1.695,1.695,0,0,0,3.39,0v-2.359a.325.325,0,0,0-.325-.324Z"
                                        transform="translate(-97.059 -105.582)"
                                        class="color-fill"></path>
                                      <path
                                        d="M202.669,110.245a.325.325,0,0,0-.325.324v2.359a1.695,1.695,0,0,0,3.39,0v-2.359a.325.325,0,0,0-.325-.324Z"
                                        transform="translate(-193.76 -105.582)"
                                        class="color-fill"></path>
                                      <path
                                        d="M303.669,110.245a.325.325,0,0,0-.325.324v2.359a1.7,1.7,0,0,0,3.391,0v-2.359a.325.325,0,0,0-.325-.324Z"
                                        transform="translate(-290.475 -105.582)"
                                        class="color-fill"></path>
                                      <path
                                        d="M.324,4.15h20a.325.325,0,0,0,.193-.585L16.264.4A.327.327,0,0,0,16.07.338H4.575A.326.326,0,0,0,4.381.4L.131,3.565a.325.325,0,0,0,.193.585Z"
                                        transform="translate(0 -0.338)"
                                        class="color-fill"></path>
                                      <path
                                        d="M2.035,114.622a1.7,1.7,0,0,0,1.7-1.7v-2.359a.325.325,0,0,0-.325-.324H.665a.325.325,0,0,0-.325.324v2.359A1.7,1.7,0,0,0,2.035,114.622Z"
                                        transform="translate(-0.326 -105.581)"
                                        class="color-fill"></path>
                                      <path
                                        d="M407.428,110.245h-2.74a.324.324,0,0,0-.325.324v2.359a1.695,1.695,0,0,0,3.39,0v-2.359A.325.325,0,0,0,407.428,110.245Z"
                                        transform="translate(-387.208 -105.582)"
                                        class="color-fill"></path>
                                    </g>
                                  </g>
                                </g>
                              </svg></span><span
                              class="text"><span>Магазин</span></span></label>
                        </div>
                        <div class="extra-options__parameters-input">
                          <input class="sr-only filterCalc" type="checkbox" id="cerkov"
                            name="CERKOV">
                          <label class="d-flex w-100 align-items-center" for="cerkov"><span
                              class="icon icon--cerkov">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24.723"
                                height="23.043" viewBox="0 0 24.723 23.043"
                                class="inline-svg">
                                <g transform="translate(0 -10.535)">
                                  <path d="M253.381,206.25v7.434H257.9V208.86Z"
                                    transform="translate(-233.173 -180.106)"
                                    class="color-fill"></path>
                                  <path d="M0,213.618H4.515v-7.44L0,208.794Z"
                                    transform="translate(0 -180.04)"
                                    class="color-fill"></path>
                                  <path
                                    d="M66.619,107.094v9.937h4.629v-4.213a2.393,2.393,0,0,1,2.393-2.393h.053a2.393,2.393,0,0,1,2.393,2.393v4.213h4.629v-9.937l-7.049-5.847Z"
                                    transform="translate(-61.306 -83.478)"
                                    class="color-fill"></path>
                                  <path
                                    d="M27.5,22.582l1.2,1.451L37.67,16.64l8.972,7.393,1.2-1.451-9.61-7.919V12.9h1.725V11.784H38.228V10.535H37.112v1.249H35.387V12.9h1.725v1.762Z"
                                    transform="translate(-25.309)"
                                    class="color-fill"></path>
                                </g>
                              </svg></span><span
                              class="text"><span>Церковь</span></span></label>
                        </div>
                        <div class="extra-options__parameters-input">
                          <input class="sr-only filterCalc" type="checkbox" id="school"
                            name="SHKOLA">
                          <label class="d-flex w-100 align-items-center" for="school"><span
                              class="icon icon--school">
                              <svg xmlns="http://www.w3.org/2000/svg" width="22.308"
                                height="20.576" viewBox="0 0 22.308 20.576"
                                class="inline-svg">
                                <g transform="translate(0 -18.463)">
                                  <path
                                    d="M21.962,23.151a1.768,1.768,0,0,0-.791-.576,2.158,2.158,0,0,1-.067.764L17.086,36.561a.963.963,0,0,1-.469.556,1.486,1.486,0,0,1-.75.208H3.5q-1.607,0-1.929-.938a.611.611,0,0,1,.014-.576.59.59,0,0,1,.509-.2H13.737a2.469,2.469,0,0,0,1.721-.462,5.231,5.231,0,0,0,.958-2.056l3.67-12.137a1.911,1.911,0,0,0-.241-1.741,1.765,1.765,0,0,0-1.527-.75H8.124a3.725,3.725,0,0,0-.683.12l.013-.04a2.8,2.8,0,0,0-.636-.074.9.9,0,0,0-.482.154,1.551,1.551,0,0,0-.355.315,2.306,2.306,0,0,0-.261.429q-.127.261-.214.482t-.2.469a3.019,3.019,0,0,1-.221.408q-.08.107-.228.281t-.241.308a.754.754,0,0,0-.12.241.872.872,0,0,0,.027.355,1.1,1.1,0,0,1,.04.341,5.079,5.079,0,0,1-.368,1.293,5.522,5.522,0,0,1-.569,1.132q-.054.067-.295.3a1.072,1.072,0,0,0-.295.408q-.054.067-.007.375a1.934,1.934,0,0,1,.034.429A5.488,5.488,0,0,1,2.726,27.4a8.2,8.2,0,0,1-.563,1.232,2.2,2.2,0,0,1-.228.308,1.127,1.127,0,0,0-.228.375,1.181,1.181,0,0,0,.007.375,1.048,1.048,0,0,1-.007.4,7.271,7.271,0,0,1-.4,1.226,8.944,8.944,0,0,1-.6,1.226,3.224,3.224,0,0,1-.221.315,3.269,3.269,0,0,0-.221.315.834.834,0,0,0-.107.281.666.666,0,0,0,.04.261A.743.743,0,0,1,.234,34q-.014.187-.054.5t-.04.361a2.43,2.43,0,0,0,.027,1.7A3.764,3.764,0,0,0,1.5,38.322a3.278,3.278,0,0,0,1.989.716H15.854a2.674,2.674,0,0,0,1.641-.583,2.764,2.764,0,0,0,1.025-1.44L22.2,24.879A1.894,1.894,0,0,0,21.962,23.151Zm-14.253.027.281-.857a.6.6,0,0,1,.221-.3.561.561,0,0,1,.342-.127H16.7a.292.292,0,0,1,.268.127.349.349,0,0,1,.027.3l-.282.857a.6.6,0,0,1-.221.3.561.561,0,0,1-.341.127H8a.292.292,0,0,1-.268-.127A.349.349,0,0,1,7.709,23.178ZM6.6,26.607l.281-.857a.6.6,0,0,1,.221-.3.56.56,0,0,1,.342-.127h8.144a.292.292,0,0,1,.268.127.349.349,0,0,1,.027.3l-.281.857a.6.6,0,0,1-.221.3.56.56,0,0,1-.342.127H6.892a.292.292,0,0,1-.268-.127A.349.349,0,0,1,6.6,26.607Z"
                                    transform="translate(0)" class="color-fill">
                                  </path>
                                </g>
                              </svg></span><span
                              class="text"><span>Школа</span></span></label>
                        </div>
                        <div class="extra-options__parameters-input">
                          <input class="sr-only filterCalc" type="checkbox" id="detsad"
                            name="DETSAD">
                          <label class="d-flex w-100 align-items-center" for="detsad"><span
                              class="icon icon--detsad">
                              <svg xmlns="http://www.w3.org/2000/svg" width="20.767"
                                height="23.632" viewBox="0 0 20.767 23.632"
                                class="inline-svg">
                                <g transform="translate(-31.04)">
                                  <path
                                    d="M346.369,377.44c-1.35,1.35-1.569,3.326-.49,4.406,1.179,1.179,3.207.71,4.406-.49,1.349-1.35,1.569-3.326.49-4.406C349.62,375.794,347.6,376.21,346.369,377.44Z"
                                    transform="translate(-299.654 -358.902)"
                                    class="color-fill"></path>
                                  <path
                                    d="M36.621,381.792c1.08-1.08.86-3.056-.489-4.406-1.224-1.223-3.239-1.658-4.406-.489-1.079,1.08-.859,3.057.489,4.406C33.416,382.5,35.438,382.975,36.621,381.792Z"
                                    transform="translate(0 -358.847)"
                                    class="color-fill"></path>
                                  <path
                                    d="M62.034,225.444a5.046,5.046,0,0,1,2.387.664,13.45,13.45,0,0,1,2.237-5.062,7.046,7.046,0,0,1-1.81-1.446A5.72,5.72,0,0,0,61,224.788a4.976,4.976,0,0,0,.068.786A4.017,4.017,0,0,1,62.034,225.444Z"
                                    transform="translate(-28.577 -209.464)"
                                    class="color-fill"></path>
                                  <path
                                    d="M330.2,219.6a7.045,7.045,0,0,1-1.81,1.446,13.451,13.451,0,0,1,2.237,5.062,5.054,5.054,0,0,1,2.386-.662,4.035,4.035,0,0,1,.967.13,4.97,4.97,0,0,0,.068-.788A5.72,5.72,0,0,0,330.2,219.6Z"
                                    transform="translate(-283.627 -209.464)"
                                    class="color-fill"></path>
                                  <path
                                    d="M167.826,263.287a6.682,6.682,0,0,1-4.022,0,12.035,12.035,0,0,0-2.353,5.365,4.748,4.748,0,0,1,1.136,5.586,10.124,10.124,0,0,0,6.455,0,4.75,4.75,0,0,1,1.136-5.586A12.033,12.033,0,0,0,167.826,263.287Zm-1.319,7.326h-1.385v-1.385h1.385Zm0-2.769h-1.385v-1.385h1.385Z"
                                    transform="translate(-124.391 -251.135)"
                                    class="color-fill"></path>
                                  <path
                                    d="M78.769,5.539a5.539,5.539,0,1,0,11.077,0,2.769,2.769,0,1,0-2.22-4.41,5.442,5.442,0,0,0-6.637,0,2.766,2.766,0,1,0-2.22,4.41Zm7.616-2.077H87.77V4.846H86.385Zm.692,3.462C87.077,8.088,85.861,9,84.308,9s-2.769-.912-2.769-2.077,1.216-2.077,2.769-2.077S87.077,5.758,87.077,6.923ZM80.846,3.462h1.385V4.846H80.846Z"
                                    transform="translate(-42.885)"
                                    class="color-fill"></path>
                                  <ellipse cx="1.385" cy="0.692" rx="1.385" ry="0.692"
                                    transform="translate(40.039 6.231)"
                                    class="color-fill"></ellipse>
                                </g>
                              </svg></span><span class="text"><span>Дет.
                                сад</span></span></label>
                        </div>
                      </div>
                      <div class="col-sm-6 col-lg-12 col-xl-6 col-6 add-modal100">
                        <div class="extra-options__parameters-input">
                          <input class="sr-only filterCalc" type="checkbox" id="cafe"
                            name="CAFE">
                          <label class="d-flex w-100 align-items-center" for="cafe"><span
                              class="icon icon--cafe">
                              <svg xmlns="http://www.w3.org/2000/svg" width="15.212"
                                height="24.339" viewBox="0 0 15.212 24.339"
                                class="inline-svg">
                                <g transform="translate(-48)">
                                  <path
                                    d="M48.507,0A.507.507,0,0,0,48,.507v21.8a2.028,2.028,0,1,0,4.057,0V14.2h1.521a.507.507,0,0,0,.507-.507c0-5.175-.034-8.453-.705-10.549C52.674.939,51.217,0,48.507,0Z"
                                    transform="translate(0 0)" class="color-fill">
                                  </path>
                                  <path
                                    d="M110.085,0V6.085h-1.014V0h-2.028V6.085h-1.014V0H104V7.1a4.064,4.064,0,0,0,3.042,3.928V14.7h-.507a.507.507,0,0,0-.507.507v7.1a2.028,2.028,0,1,0,4.057,0v-7.1a.507.507,0,0,0-.507-.507h-.507V11.027A4.064,4.064,0,0,0,112.113,7.1V0Z"
                                    transform="translate(-48.901 0)"
                                    class="color-fill"></path>
                                </g>
                              </svg></span><span
                              class="text"><span>Кафе</span></span></label>
                        </div>
                        <div class="extra-options__parameters-input">
                          <input class="sr-only filterCalc" type="checkbox" id="azs"
                            name="AVTOZAPRAVKA">
                          <label class="d-flex w-100 align-items-center" for="azs"><span
                              class="icon icon--azs">
                              <svg xmlns="http://www.w3.org/2000/svg" width="18.201"
                                height="20.801" viewBox="0 0 18.201 20.801"
                                class="inline-svg">
                                <g transform="translate(-16)">
                                  <path
                                    d="M22.067,1.733H21.2V.433A.433.433,0,0,0,20.767,0H17.3a.433.433,0,0,0-.433.433v1.3H16V3.467h6.067Z"
                                    class="color-fill"></path>
                                  <path
                                    d="M37.867,0H36.575a3.481,3.481,0,0,0-3.333,2.514L32.4,5.461a.433.433,0,0,1-.477.31l-3.216-.448a.433.433,0,0,1-.373-.429v-.56H24v14.3A2.167,2.167,0,0,0,26.167,20.8h13a2.167,2.167,0,0,0,2.167-2.167V3.467A3.467,3.467,0,0,0,37.867,0ZM36.747,16.721l-1.226,1.226L33.175,15.6H32.159l-2.346,2.346-1.226-1.226,2.346-2.346V13.36l-2.346-2.346,1.226-1.226,2.346,2.346h1.015l2.346-2.346,1.226,1.226L34.4,13.36v1.015Zm1.492-9.7-2.525-.365a.433.433,0,0,1-.361-.523l.713-3.19a.433.433,0,0,1,.423-.339H38.3a.433.433,0,0,1,.433.433V6.588a.433.433,0,0,1-.5.429Z"
                                    transform="translate(-7.133)"
                                    class="color-fill"></path>
                                </g>
                              </svg></span><span
                              class="text"><span>АЗС</span></span></label>
                        </div>
                        <div class="extra-options__parameters-input">
                          <input class="sr-only filterCalc" type="checkbox" id="apteka"
                            name="APTEKA">
                          <label class="d-flex w-100 align-items-center" for="apteka"><span
                              class="icon icon--apteka">
                              <svg xmlns="http://www.w3.org/2000/svg" width="23.333"
                                height="20" viewBox="0 0 23.333 20" class="inline-svg">
                                <g transform="translate(0 -16.5)">
                                  <path
                                    d="M22.155,21.449H16.667V17.712A1.187,1.187,0,0,0,15.488,16.5H8.013a1.245,1.245,0,0,0-1.246,1.212v3.737H1.246A1.241,1.241,0,0,0,0,22.662V35.288A1.241,1.241,0,0,0,1.246,36.5H22.155a1.184,1.184,0,0,0,1.178-1.212V22.662a1.184,1.184,0,0,0-1.178-1.212ZM8.384,18.116H15.05v3.333H8.384Zm7.475,12.525H13.333v2.525H10V30.641H7.475V27.308H10V24.783h3.333v2.525h2.525Z"
                                    class="color-fill"></path>
                                </g>
                              </svg></span><span
                              class="text"><span>Аптека</span></span></label>
                        </div>
                        <div class="extra-options__parameters-input">
                          <input class="sr-only filterCalc" type="checkbox" id="stroimat"
                            name="STROYMATERIALI">
                          <label class="d-flex w-100 align-items-center" for="stroimat"><span
                              class="icon icon--stroimat">
                              <svg xmlns="http://www.w3.org/2000/svg" width="26.219"
                                height="22.515" viewBox="0 0 26.219 22.515"
                                class="inline-svg">
                                <g transform="translate(0 -34.608)">
                                  <g transform="translate(0 34.608)">
                                    <path
                                      d="M220.591,131.521,205.364,141.9v6.706l15.227-10.6Z"
                                      transform="translate(-194.372 -126.334)"
                                      class="color-fill"></path>
                                    <path
                                      d="M9.788,251.836.025,247.919,0,255.348l9.788,3.668Z"
                                      transform="translate(0 -236.502)"
                                      class="color-fill"></path>
                                    <path
                                      d="M16.573,48.835,31.928,38.348l-10.051-3.74L6.464,44.652Zm4.579-5.5-4.017,2.75a2.138,2.138,0,0,1-1.946.257l-.856-.447c-.459-.239-.364-.73.2-1.1l3.891-2.551a2.274,2.274,0,0,1,1.815-.274l.919.348C21.676,42.514,21.682,42.969,21.152,43.331Zm5.192-5.424.971.254c.551.144.632.519.167.838L23.967,41.4a2.369,2.369,0,0,1-1.884.285l-.928-.333c-.5-.179-.491-.585,0-.908l3.43-2.248A2.489,2.489,0,0,1,26.344,37.908Zm-9.011,1.415,3.315-2.067a2.367,2.367,0,0,1,1.616-.281l.847.222c.48.126.513.464.061.756l-3.4,2.2a2.247,2.247,0,0,1-1.721.276l-.8-.288C16.815,39.985,16.859,39.619,17.333,39.323Zm-6.362,3.968L14.7,40.965a2.158,2.158,0,0,1,1.662-.266l.8.3c.451.17.415.576-.1.906L13.212,44.4a2.022,2.022,0,0,1-1.77.254l-.735-.383C10.312,44.062,10.435,43.625,10.971,43.291Z"
                                      transform="translate(-6.118 -34.608)"
                                      class="color-fill"></path>
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
          </div>
          <div class="modal-footer add-filter__footer">
            <div class="add-filter__footer-wrap">
              <button class="btn btn-lg btn-warning add-filter__footer-button" type="submit">Подобрать</button>
              <button class="btn btn-link filter__button-clear add-filter__button-reset" type="reset">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                  xmlns="http://www.w3.org/2000/svg" class="add-filter__button-reset-svg">
                  <path d="M15 5L5 15" stroke="#919FA3" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                  <path d="M5 5L15 15" stroke="#919FA3" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>Сбросить фильтр
              </button>
            </div>
          </div>
        </div>

    </div>
  </div>

  <!-- Modal Участки -->
  <div class="modal fade add-filter__modal" id="plotsModal" tabindex="-1" role="dialog"
    aria-labelledby="plotsModalLongTitle" aria-hidden="true">
    <div class="modal-dialog add-filter__modal-xxl" role="document">
      <div class="modal-content add-modal__content">
        <div class="add-filter__header">
          <h5 class="modal-title add-filter__title" id="plotsModalLongTitle">Дополнительные параметры</h5>
          <button type="button" class="close add-filter__close" data-dismiss="modal" aria-label="Close">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path d="M17.4375 0.5625L0.5625 17.4375" stroke="#9DABB2" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" />
              <path d="M0.5625 0.5625L17.4375 17.4375" stroke="#9DABB2" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>
        </div>
        <div class="modal-body add-filter__modal-body">
          <div class="add-filter__modal-top">
            <div class="add-filter__region">
              <a class="btn btn-outline-warning rounded-pill w-100 add-filter__region-txt"
                href="#regionModal" data-toggle="modal" data-target="#regionModal">Районы МО</a>
            </div>
            <div class="add-filter__search">
              <div class="add-filter__search-group">
                <input class="form-control add-filter__search-input searchWord" type="text"
                  name="search_term_string" placeholder="Поиск по ключевым словам">
                <div class="input-group-append">
                  <button class="btn btn-outline-success add-filter__search-button searchButton" type="button">Поиск
                  </button>
                </div>
              </div>
            </div>
            <div class="add-filter__size">
              <label class="add-filter__size-label">Участок, сот.</label>
              <input placeholder="От" type="text"
                class="form-control add-filter__size-input filterCalc" name="PLOTTAGE_MIN">
              <input placeholder="До" type="text"
                class="form-control add-filter__size-input filterCalc" name="PLOTTAGE_MAX">
            </div>

            <div class="add-filter__modal-center plots__modal-center">
              <div class="custom-checkbox custom-control-inline align-items-center h-100 add-filter__checkbox plots__checkbox">
                <input type="checkbox" class="custom-control-input filterCalc" value="dacha"
                  name="TYPE_PERMITTED" id="dacha2">
                <label class="custom-control-label add-filter__checkbox-label"
                  data-role="label_dacha2" for="dacha2">Дачный</label>
              </div>
              <div class="custom-checkbox custom-control-inline align-items-center h-100 add-filter__checkbox plots__checkbox">
                <input type="checkbox" class="custom-control-input filterCalc" value="cottage"
                  name="TYPE_PERMITTED" id="ihs2">
                <label class="custom-control-label add-filter__checkbox-label" data-role="label_ihs2"
                  for="ihs2">ИЖС</label>
              </div>
              <div
                class="custom-checkbox custom-control-inline align-items-center h-100 add-filter__checkbox plots__checkbox">
                <input type="checkbox" class="custom-control-input filterCalc" value="Y"
                  name="INS" id="INS2">
                <label class="custom-control-label add-filter__checkbox-label"
                  data-role="label_INS2"
                  for="INS2">Доступна рассрочка</label>
              </div>

            </div>
          </div>

          <div class="hero add-filter__hero plots__hero">
            <div class="extra-options">
              <div
                class="row extra-options__parameters add-filter__extra-options plots__extra-options">
                <div
                  class="order-lg-1 col-md-3 col-lg-2 col-sm-4 col-4 add-modal__order plots__order">
                  <div class="extra-options__parameters-title">Коммуникация</div>
                  <div class="extra-options__parameters-input">
                    <input type="checkbox" class="sr-only filterCalc" value="Y"
                      name="ELECTRO" id="ELECTRO2">
                    <label class="d-flex w-100 align-items-center"
                      data-role="label_ELECTRO2"
                      for="ELECTRO2"><span class="icon icon--svet">
                        <svg xmlns="http://www.w3.org/2000/svg" width="23.032" height="24"
                          viewBox="0 0 23.032 24" class="inline-svg">
                          <g transform="translate(-9.8)">
                            <path
                              d="M24.052,20.973v.7a1.112,1.112,0,0,1-.943,1.1l-.173.637A.793.793,0,0,1,22.17,24H20.457a.793.793,0,0,1-.765-.588l-.168-.637a1.117,1.117,0,0,1-.948-1.106v-.7a.674.674,0,0,1,.677-.677h4.123A.682.682,0,0,1,24.052,20.973Zm3.175-9.452a5.883,5.883,0,0,1-1.659,4.1,5.422,5.422,0,0,0-1.452,2.943.978.978,0,0,1-.968.825H19.479a.968.968,0,0,1-.963-.82,5.482,5.482,0,0,0-1.462-2.953,5.912,5.912,0,1,1,10.173-4.1Zm-5.244-3.58a.667.667,0,0,0-.667-.667,4.271,4.271,0,0,0-4.267,4.267.667.667,0,1,0,1.333,0,2.937,2.937,0,0,1,2.933-2.933A.664.664,0,0,0,21.983,7.941Zm-.667-4.272A.667.667,0,0,0,21.983,3V.667a.667.667,0,0,0-1.333,0V3A.667.667,0,0,0,21.316,3.669Zm-7.847,7.847a.667.667,0,0,0-.667-.667H10.467a.667.667,0,1,0,0,1.333H12.8A.664.664,0,0,0,13.469,11.516Zm18.7-.667H29.83a.667.667,0,1,0,0,1.333h2.336a.667.667,0,1,0,0-1.333ZM14.827,17.067l-1.654,1.654a.665.665,0,0,0,.938.943l1.654-1.654a.665.665,0,0,0-.938-.943Zm12.509-10.9A.666.666,0,0,0,27.8,5.97l1.654-1.654a.667.667,0,1,0-.943-.943L26.862,5.027a.665.665,0,0,0,0,.943A.677.677,0,0,0,27.336,6.163Zm-12.509-.2a.665.665,0,0,0,.938-.943L14.111,3.368a.667.667,0,1,0-.943.943ZM27.8,17.067a.667.667,0,1,0-.943.943l1.654,1.654a.665.665,0,1,0,.938-.943Z"
                              class="color-fill"></path>
                          </g>
                        </svg></span><span class="text"><span>Свет</span></span></label>
                  </div>
                  <div class="extra-options__parameters-input">
                    <input type="checkbox" class="sr-only filterCalc" value="Y"
                      name="PLUMBING" id="PLUMBING2">
                    <label class="d-flex w-100 align-items-center"
                      data-role="label_PLUMBING2"
                      for="PLUMBING2"><span class="icon icon--voda">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15.782"
                          height="22.051" viewBox="0 0 15.782 22.051" class="inline-svg">
                          <g transform="translate(-35.275 0)">
                            <g transform="translate(35.275 0)">
                              <path
                                d="M44.09.76c-.6-1.031-1.244-1-1.848,0-2.772,4.123-6.967,10.308-6.967,13.4a7.891,7.891,0,1,0,15.782,0C51.057,11.033,46.862,4.883,44.09.76Zm4.763,16.919a6.749,6.749,0,0,1-2.381,2.31.955.955,0,0,1-.924-1.671,4.705,4.705,0,0,0,1.706-1.635,4.634,4.634,0,0,0,.711-2.275.943.943,0,0,1,1.884.107A7.042,7.042,0,0,1,48.853,17.679Z"
                                transform="translate(-35.275 0)" class="color-fill">
                              </path>
                            </g>
                          </g>
                        </svg></span><span class="text"><span>Вода</span></span></label>
                  </div>
                  <div class="extra-options__parameters-input">
                    <input type="checkbox" class="sr-only filterCalc" value="Y"
                      name="GAS" id="GAS2">
                    <label class="d-flex w-100 align-items-center"
                      data-role="label_GAS2"
                      for="GAS2"><span class="icon icon--gaz">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17.883"
                          height="23.844" viewBox="0 0 17.883 23.844" class="inline-svg">
                          <g transform="translate(-64 0)">
                            <g transform="translate(64 0)">
                              <path
                                d="M81.832,13.96C81.559,10.4,79.9,8.176,78.442,6.209,77.09,4.389,75.922,2.817,75.922.5a.5.5,0,0,0-.27-.442.492.492,0,0,0-.516.038,12.633,12.633,0,0,0-4.663,6.739,22,22,0,0,0-.511,5.038c-2.026-.433-2.485-3.463-2.49-3.5A.5.5,0,0,0,66.764,8c-.106.051-2.607,1.322-2.753,6.4-.01.169-.011.338-.011.507a8.951,8.951,0,0,0,8.941,8.941.069.069,0,0,0,.02,0h.006A8.952,8.952,0,0,0,81.883,14.9C81.883,14.654,81.832,13.96,81.832,13.96Zm-8.89,8.889a3.086,3.086,0,0,1-2.98-3.175c0-.06,0-.12,0-.194a4.027,4.027,0,0,1,.314-1.577,1.814,1.814,0,0,0,1.64,1.188.5.5,0,0,0,.5-.5,9.937,9.937,0,0,1,.191-2.259,4.8,4.8,0,0,1,1.006-1.9,6.4,6.4,0,0,0,1.024,1.879,5.659,5.659,0,0,1,1.273,3.1c.006.085.013.171.013.263A3.086,3.086,0,0,1,72.941,22.849Z"
                                transform="translate(-64 0)" class="color-fill">
                              </path>
                            </g>
                          </g>
                        </svg></span><span class="text"><span>Газ</span></span></label>
                  </div>
                </div>
                <div
                  class="order-sm-5 col-sm-4 order-md-5 order-lg-3 col-md-3 col-lg-2 col-4 add-filter__par-3 plots__par-3">
                  <div class="row">
                    <div class="col-sm-12 col-lg-12 col-md-12 col-12 add-modal50 plots100">
                      <div class="extra-options__parameters-title">Как добраться</div>
                      <div class="extra-options__parameters-input">
                        <input type="checkbox" class="sr-only filterCalc" value="Y"
                          name="BUS" id="BUS2">
                        <label class="d-flex w-100 align-items-center"
                          data-role="label_BUS2"
                          for="BUS2"><span class="icon icon--bus">
                            <svg xmlns="http://www.w3.org/2000/svg" width="33.298"
                              height="17.762" viewBox="0 0 33.298 17.762"
                              class="inline-svg">
                              <path
                                d="M.555,16.027h2.83A2.765,2.765,0,0,0,8.325,17.12a2.766,2.766,0,0,0,4.939-1.093h11.21a2.775,2.775,0,0,0,5.439,0h2.83a.555.555,0,0,0,.555-.555V11.259a7.2,7.2,0,0,0-.2-1.669l-1.212-5.1a2.226,2.226,0,0,0-2.177-1.785H13.107L12.154.8a.555.555,0,0,0-.5-.307H3.885a.555.555,0,0,0-.5.307L2.432,2.708H.555A.555.555,0,0,0,0,3.263V15.472A.555.555,0,0,0,.555,16.027Zm5.55,1.11a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,6.1,17.137Zm4.44,0a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,10.544,17.137Zm16.649,0a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,27.194,17.137Zm4.828-7.291c.006.026.008.051.013.077H27.748V6.038h3.369ZM4.228,1.6h7.084l.555,1.11H3.673ZM1.11,3.818h28.6a1.119,1.119,0,0,1,1.093.912l.05.2H1.11Zm25.529,2.22V9.923h-3.33V6.038Zm-4.44,0V9.923h-3.33V6.038Zm-4.44,0V9.923h-3.33V6.038Zm-4.44,0V9.923H9.989V6.038Zm-4.44,0V9.923H5.55V6.038Zm-7.77,0H4.44V9.923H1.11Zm0,7.215H2.22v-1.11H1.11v-1.11H32.175c0,.075.013.15.013.226v.884h-1.11v1.11h1.11v1.665H29.913a.147.147,0,0,0-.009-.029,2.745,2.745,0,0,0-.144-.462c-.022-.056-.051-.1-.076-.154a2.872,2.872,0,0,0-.16-.294c-.035-.056-.076-.106-.115-.158a2.862,2.862,0,0,0-.2-.238c-.047-.049-.095-.1-.145-.142a2.624,2.624,0,0,0-.234-.193q-.083-.061-.166-.116a2.955,2.955,0,0,0-.278-.149c-.059-.028-.116-.055-.177-.083a2.755,2.755,0,0,0-.333-.1c-.056-.014-.107-.033-.164-.044a2.631,2.631,0,0,0-1.054,0c-.056.011-.111.03-.164.044a2.768,2.768,0,0,0-.333.1c-.061.024-.118.056-.177.083a2.927,2.927,0,0,0-.278.149q-.083.055-.166.116a2.592,2.592,0,0,0-.234.193c-.05.046-.1.092-.145.142a2.954,2.954,0,0,0-.2.238c-.039.052-.079.1-.115.158a2.829,2.829,0,0,0-.16.294c-.025.052-.056.1-.076.154a2.767,2.767,0,0,0-.144.462.137.137,0,0,1-.009.029h-11.2a.147.147,0,0,0-.009-.029,2.787,2.787,0,0,0-.144-.462c-.022-.056-.051-.1-.076-.154a2.871,2.871,0,0,0-.16-.294c-.035-.056-.076-.106-.115-.158a2.907,2.907,0,0,0-.2-.238c-.047-.049-.095-.1-.145-.142a2.624,2.624,0,0,0-.234-.193q-.083-.061-.167-.116a2.923,2.923,0,0,0-.277-.149c-.059-.028-.116-.055-.177-.083a2.727,2.727,0,0,0-.33-.1c-.056-.014-.107-.033-.166-.044a2.583,2.583,0,0,0-1.033,0l-.086.016a2.767,2.767,0,0,0-.451.14l-.082.036a2.791,2.791,0,0,0-.42.228l-.022.017a2.789,2.789,0,0,0-.357.295l-.056.051a2.778,2.778,0,0,0-.235.272,2.827,2.827,0,0,0-.242-.278c-.018-.018-.036-.034-.056-.051a2.81,2.81,0,0,0-.357-.295l-.022-.017a2.8,2.8,0,0,0-.42-.228L7.146,12.9a2.792,2.792,0,0,0-.451-.14l-.086-.016a2.581,2.581,0,0,0-1.033,0c-.056.011-.111.03-.164.044a2.716,2.716,0,0,0-.333.1c-.061.024-.118.056-.177.083a2.91,2.91,0,0,0-.275.149c-.055.037-.111.075-.166.116a2.627,2.627,0,0,0-.234.193c-.05.046-.1.092-.145.142a2.832,2.832,0,0,0-.2.238c-.039.052-.079.1-.115.158a2.809,2.809,0,0,0-.16.294c-.025.052-.056.1-.076.154a2.732,2.732,0,0,0-.144.462.147.147,0,0,1-.009.029H1.11Zm0,0"
                                transform="translate(0 -0.488)" fill="#3c4b5a">
                              </path>
                              <path d="M230.4,202.09h11.1v1.11H230.4Zm0,0"
                                transform="translate(-217.079 -190.435)"
                                fill="#3c4b5a"></path>
                            </svg></span><span
                            class="text"><span>Автобус</span></span></label>
                      </div>
                      <div class="extra-options__parameters-input">
                        <input type="checkbox" class="sr-only filterCalc" value="Y"
                          name="TRAIN" id="TRAIN2">
                        <label class="d-flex w-100 align-items-center"
                          data-role="label_TRAIN2"
                          for="TRAIN2"><span class="icon icon--train">
                            <svg xmlns="http://www.w3.org/2000/svg" width="33.298"
                              height="13.319" viewBox="0 0 33.298 13.319"
                              class="inline-svg">
                              <path
                                d="M250.156,139.33h2.22a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33A.555.555,0,0,0,250.156,139.33Zm.555-3.33h1.11v2.22h-1.11Zm0,0"
                                transform="translate(-235.172 -132.671)"
                                fill="#3c4b5a"></path>
                              <path
                                d="M137.173,139.33a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33a.555.555,0,0,0,.555.555ZM135.509,136h1.11v2.22h-1.11Zm0,0"
                                transform="translate(-126.629 -132.671)"
                                fill="#3c4b5a"></path>
                              <path
                                d="M60.376,139.33a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33a.555.555,0,0,0,.555.555ZM58.711,136h1.11v2.22h-1.11Zm0,0"
                                transform="translate(-54.272 -132.671)"
                                fill="#3c4b5a"></path>
                              <path
                                d="M2.22,138.775v-3.33a.555.555,0,0,0-.555-.555H0V136H1.11v2.22H0v1.11H1.665A.555.555,0,0,0,2.22,138.775Zm0,0"
                                transform="translate(0 -132.671)" fill="#3c4b5a">
                              </path>
                              <path d="M364.8,192.488h2.22v1.11H364.8Zm0,0"
                                transform="translate(-343.712 -186.939)"
                                fill="#3c4b5a"></path>
                              <path d="M460.8,230.887h1.11V232H460.8Zm0,0"
                                transform="translate(-434.162 -223.117)"
                                fill="#3c4b5a"></path>
                              <path d="M518.4,230.887h1.11V232H518.4Zm0,0"
                                transform="translate(-488.43 -223.117)"
                                fill="#3c4b5a"></path>
                              <path
                                d="M15.242,96.488H0V97.6H12.209v6.66H0v1.11H12.209v1.11H0v1.11H2.775a2.2,2.2,0,0,0,.308,1.11H0v1.11H33.3V108.7H26.885a2.2,2.2,0,0,0,.308-1.11H29.72a3.578,3.578,0,0,0,2.291-6.327l-3.718-3.1a7.23,7.23,0,0,0-4.62-1.673h-8.43ZM4.995,108.7a1.11,1.11,0,0,1-1.11-1.11H6.1A1.11,1.11,0,0,1,4.995,108.7Zm3.33,0a1.11,1.11,0,0,1-1.11-1.11h2.22A1.11,1.11,0,0,1,8.325,108.7Zm4.995-3.33h5.55v1.11h-5.55Zm-3.083,3.33a2.2,2.2,0,0,0,.308-1.11H22.754a2.2,2.2,0,0,0,.309,1.11Zm14.738,0a1.11,1.11,0,0,1-1.11-1.11h2.22A1.11,1.11,0,0,1,24.974,108.7Zm3.573-8.879,2.664,2.22H25.973a.555.555,0,0,1-.427-.2l-1.682-2.02h4.683Zm-8.567,5.55h5.55v-1.11h-5.55V97.6h3.693a6.118,6.118,0,0,1,3.508,1.11H23.864a1.11,1.11,0,0,0-.852,1.82l1.685,2.02a1.661,1.661,0,0,0,1.277.6h6.049a2.439,2.439,0,0,1-2.3,3.33H19.979Zm-1.11-7.77v6.66h-5.55V97.6Z"
                                transform="translate(0 -96.488)" fill="#3c4b5a">
                              </path>
                            </svg></span><span
                            class="text"><span>Электричка</span></span></label>
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="order-sm-4 col-sm-4 order-md-3 order-lg-5 order-xl-4 col-md-3 col-lg-2 add-filter__par-4 col-4 plots__par-4">
                  <div class="extra-options__parameters-title">Природа</div>
                  <div class="extra-options__parameters-input">
                    <input class="sr-only filterCalc" type="checkbox" id="WATER2" name="WATER">
                    <label class="d-flex w-100 align-items-center" for="WATER2"><span
                        class="icon icon--vodoem">
                        <svg xmlns="http://www.w3.org/2000/svg" width="23.111"
                          height="14.182" viewBox="0 0 23.111 14.182" class="inline-svg">
                          <g transform="translate(0 -98.909)">
                            <g transform="translate(0 98.909)">
                              <g>
                                <path
                                  d="M20.686,100.11a5.278,5.278,0,0,0-6.7,0,3.561,3.561,0,0,1-2.425.9,3.561,3.561,0,0,1-2.426-.9,5.078,5.078,0,0,0-3.352-1.2,5.078,5.078,0,0,0-3.352,1.2,3.561,3.561,0,0,1-2.426.9V103.9a3.561,3.561,0,0,0,2.426-.9,5.078,5.078,0,0,1,3.352-1.2A5.078,5.078,0,0,1,9.13,103a3.561,3.561,0,0,0,2.426.9,3.561,3.561,0,0,0,2.425-.9,5.278,5.278,0,0,1,6.7,0,3.561,3.561,0,0,0,2.425.9V101.01A3.561,3.561,0,0,1,20.686,100.11Z"
                                  transform="translate(0 -98.909)"
                                  class="color-fill"></path>
                              </g>
                            </g>
                            <g transform="translate(0 108.101)">
                              <g>
                                <path
                                  d="M19.759,303.446a3.719,3.719,0,0,0-4.851,0,5.077,5.077,0,0,1-3.352,1.2,5.078,5.078,0,0,1-3.352-1.2,3.562,3.562,0,0,0-2.426-.9,3.561,3.561,0,0,0-2.426.9A5.078,5.078,0,0,1,0,304.647v2.889a5.078,5.078,0,0,0,3.352-1.2,3.561,3.561,0,0,1,2.426-.9,3.561,3.561,0,0,1,2.426.9,5.078,5.078,0,0,0,3.352,1.2,5.077,5.077,0,0,0,3.352-1.2,3.719,3.719,0,0,1,4.851,0,5.077,5.077,0,0,0,3.352,1.2v-2.889A5.077,5.077,0,0,1,19.759,303.446Z"
                                  transform="translate(0 -302.546)"
                                  class="color-fill"></path>
                              </g>
                            </g>
                            <g transform="translate(0 103.374)">
                              <g>
                                <path
                                  d="M19.759,198.718a3.719,3.719,0,0,0-4.851,0,5.077,5.077,0,0,1-3.352,1.2,5.078,5.078,0,0,1-3.352-1.2,3.561,3.561,0,0,0-2.426-.9,3.561,3.561,0,0,0-2.426.9A5.077,5.077,0,0,1,0,199.919v3.152a3.561,3.561,0,0,0,2.426-.9,5.078,5.078,0,0,1,3.352-1.2,5.078,5.078,0,0,1,3.352,1.2,3.561,3.561,0,0,0,2.426.9,3.561,3.561,0,0,0,2.425-.9,5.278,5.278,0,0,1,6.7,0,3.561,3.561,0,0,0,2.425.9v-3.152A5.077,5.077,0,0,1,19.759,198.718Z"
                                  transform="translate(0 -197.818)"
                                  class="color-fill"></path>
                              </g>
                            </g>
                          </g>
                        </svg></span><span class="text"><span>Водоем</span></span></label>
                  </div>
                  <div class="extra-options__parameters-input">
                    <input class="sr-only filterCalc" type="checkbox" id="LES2" name="LES">
                    <label class="d-flex w-100 align-items-center" for="LES2"><span
                        class="icon icon--les">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17.38"
                          height="24.833" viewBox="0 0 17.38 24.833" class="inline-svg">
                          <path
                            d="M72.266,7.657a4.88,4.88,0,0,0-.51-.475,2.01,2.01,0,0,0-1.871-2.747c-.065,0-.13,0-.194.009a4.838,4.838,0,0,0-8.9-2.2,3.412,3.412,0,0,0-3.306,5.4l-.012.013a4.841,4.841,0,0,0,3.549,8.133,4.93,4.93,0,0,0,.743-.056l1.787,2.76-.871,5.642a.6.6,0,0,0,.133.486.623.623,0,0,0,.476.211h3.186a.623.623,0,0,0,.476-.211.6.6,0,0,0,.133-.486l-.856-5.547,1.84-2.842a4.932,4.932,0,0,0,.652.044,4.841,4.841,0,0,0,3.549-8.133Zm-7.349,9.29-1.254-1.938a4.829,4.829,0,0,0,1.2-1.123,4.826,4.826,0,0,0,1.275,1.167Z"
                            transform="translate(-56.177)" class="color-fill"></path>
                        </svg></span><span class="text"><span>Лес</span></span></label>
                  </div>
                  <div class="extra-options__parameters-input">
                    <input type="checkbox" class="sr-only filterCalc" value="Y"
                      name="PLYAZH" id="PLYAZH2">
                    <label class="d-flex w-100 align-items-center"
                      data-role="label_PLYAZH2"
                      for="PLYAZH2"><span class="icon icon--plyaj">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21.889"
                          height="21.799" viewBox="0 0 21.889 21.799" class="inline-svg">
                          <g transform="translate(0 -0.093)">
                            <path
                              d="M21.565,18.948a.947.947,0,0,0-.744-.229,25.544,25.544,0,0,1-4.17.2,11.6,11.6,0,0,1-3-.558L10.325,8.835a37.7,37.7,0,0,1,7.317-1.6.943.943,0,0,0,.734-1.372A9.638,9.638,0,0,0,7.571.953L7.491.725A.942.942,0,0,0,6.29.146L6.274.151a.943.943,0,0,0-.579,1.2l.079.228A9.636,9.636,0,0,0,.368,12.113a.943.943,0,0,0,1.44.615A34.44,34.44,0,0,1,8.528,9.46l2.8,8.012c-2.261-.958-4.424-1.961-7.28-1.526A6.96,6.96,0,0,0,.237,18.28.95.95,0,0,0,0,18.9V20.95a.946.946,0,0,0,.947.943H20.942a.947.947,0,0,0,.948-.943v-1.3A.952.952,0,0,0,21.565,18.948Z"
                              class="color-fill"></path>
                          </g>
                        </svg></span><span class="text"><span>Пляж</span></span></label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer add-filter__footer plots__footer">
          <div class="add-filter__footer-wrap">
            <button class="btn btn-lg btn-warning add-filter__footer-button" type="submit">Подобрать</button>
            <button class="btn btn-link filter__button-clear add-filter__button-reset" type="reset">
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg" class="add-filter__button-reset-svg">
                <path d="M15 5L5 15" stroke="#919FA3" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" />
                <path d="M5 5L15 15" stroke="#919FA3" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>Сбросить фильтр
            </button>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Modal Дома -->
  <div class="modal fade add-filter__modal" id="houseModal" tabindex="-1" role="dialog"
    aria-labelledby="houseModalLongTitle" aria-hidden="true">
    <div class="modal-dialog add-filter__modal-xxl" role="document">
      <div class="modal-content add-modal__content">
        <div class="add-filter__header">
          <h5 class="modal-title add-filter__title" id="houseModalLongTitle">Дополнительные параметры</h5>
          <button type="button" class="close add-filter__close" data-dismiss="modal" aria-label="Close">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path d="M17.4375 0.5625L0.5625 17.4375" stroke="#9DABB2" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" />
              <path d="M0.5625 0.5625L17.4375 17.4375" stroke="#9DABB2" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>
        </div>
        <div class="modal-body add-filter__modal-body house__modal-body">
          <div class="add-filter__modal-top">
            <div class="add-filter__region">
              <a class="btn btn-outline-warning rounded-pill w-100 add-filter__region-txt"
                href="#regionModal" data-toggle="modal" data-target="#regionModal">Районы МО</a>
            </div>
            <div class="add-filter__search">
              <div class="add-filter__search-group">
                <input class="form-control add-filter__search-input searchWord" type="text"
                  name="search_term_string" placeholder="Поиск по ключевым словам">
                <div class="input-group-append">
                  <button class="btn btn-outline-success add-filter__search-button searchButton" type="button">Поиск
                  </button>
                </div>
              </div>
            </div>
            <div class="house__area">
              <label class="house__area-label">Площадь,<br>м<sup>2</sup></label>
              <input class="form-control house__area-input filterCalc" placeholder="От" type="text" name="HOUSE_AREA_MIN">
              <input class="form-control house__area-input filterCalc" placeholder="До" type="text" name="HOUSE_AREA_MAX">
            </div>
            <div class="house__floor">
              <label for="house-floor" class="house__floor-label">Этажей в доме</label>
              <input type="text" class="form-control house__floor-input" name="arrFilter_71_MAX" id="house-floor">
            </div>
            <div class="add-filter__modal-center plots__modal-center house__modal-center">
              <div class="custom-checkbox custom-control-inline align-items-center h-100 add-filter__checkbox house__checkbox">
                <input type="checkbox" value="built" name="READY_STAGE"
                  id="READY_STAGE"
                  class="custom-control-input filterCalc">
                <label class="custom-control-label add-filter__checkbox-label"
                  data-role="label_READY_STAGE"
                  for="READY_STAGE">Построен</label>
              </div>
              <div class="custom-checkbox custom-control-inline align-items-center h-100 add-filter__checkbox house__checkbox">
                <input type="checkbox" value="line_up" name="READY_STAGE"
                  id="READY_STAGE2"
                  class="custom-control-input filterCalc">
                <label class="custom-control-label add-filter__checkbox-label"
                  data-role="label_READY_STAGE2"
                  for="READY_STAGE2">Строится</label>
              </div>
              <div class="custom-checkbox custom-control-inline align-items-center h-100 add-filter__checkbox house__checkbox">
                <input type="checkbox" value="project" name="READY_STAGE"
                  id="READY_STAGE3"
                  class="custom-control-input filterCalc">
                <label class="custom-control-label add-filter__checkbox-label"
                  data-role="label_READY_STAGE3"
                  for="READY_STAGE3">Проект</label>
              </div>
              <div class="custom-checkbox custom-control-inline align-items-center h-100 add-filter__checkbox house__checkbox">
                <input type="checkbox" value="withoutDec" name="HOUSE_DECOR"
                  id="HOUSE_DECOR"
                  class="custom-control-input filterCalc">
                <label class="custom-control-label add-filter__checkbox-label"
                  data-role="label_HOUSE_DECOR" for="HOUSE_DECOR">Без отделки</label>
              </div>
              <div class="custom-checkbox custom-control-inline align-items-center h-100 add-filter__checkbox house__checkbox">
                <input type="checkbox" value="withDecor" name="HOUSE_DECOR"
                  id="HOUSE_DECOR2"
                  class="custom-control-input filterCalc">
                <label class="custom-control-label add-filter__checkbox-label"
                  data-role="label_HOUSE_DECOR2" for="HOUSE_DECOR2">С отделкой</label>
              </div>
              <div class="custom-checkbox custom-control-inline align-items-center h-100 add-filter__checkbox plots__checkbox add-filter__checkbox house__checkbox house__checkbox-last">
                <input type="checkbox" class="custom-control-input filterCalc" value="Y" name="INS" id="INS3">
                <label class="custom-control-label add-filter__checkbox-label"
                  data-role="label_INS3"
                  for="INS3">Доступна рассрочка</label>
              </div>
            </div>
          </div>
          <div class="house__material">
            <div class="house__material-title">Материал дома</div>
            <div class="d-flex flex-wrap">
              <div class="checkbox-house house__material-checkbox">
                <input type="checkbox" value="log" name="MATERIAL_HOUSE"
                  id="MATERIAL_HOUSE"  class="sr-only filterCalc">
                <label class="radio house__material-label" data-role="label_MATERIAL_HOUSE"
                  for="MATERIAL_HOUSE">Бревно</label>
              </div>
              <div class="checkbox-house house__material-checkbox">
                <input type="checkbox" value="beam" name="MATERIAL_HOUSE"
                  id="MATERIAL_HOUSE2"  class="sr-only filterCalc">
                <label class="radio house__material-label" data-role="label_MATERIAL_HOUSE2"
                  for="MATERIAL_HOUSE2">Брус</label>
              </div>
              <div class="checkbox-house house__material-checkbox">
                <input type="checkbox" value="aerocrete" name="MATERIAL_HOUSE"
                  id="MATERIAL_HOUSE3"  class="sr-only filterCalc">
                <label class="radio house__material-label"
                  data-role="label_MATERIAL_HOUSE3"
                  for="MATERIAL_HOUSE3">Газобетон</label>
              </div>
              <div class="checkbox-house house__material-checkbox">
                <input type="checkbox" value="carcass" name="MATERIAL_HOUSE"
                  id="MATERIAL_HOUSE4"  class="sr-only filterCalc">
                <label class="radio house__material-label"
                  data-role="label_MATERIAL_HOUSE4"
                  for="MATERIAL_HOUSE4">Каркасный</label>
              </div>
              <div class="checkbox-house house__material-checkbox">
                <input type="checkbox" value="brick" name="MATERIAL_HOUSE"
                  id="MATERIAL_HOUSE5"  class="sr-only filterCalc">
                <label class="radio house__material-label"
                  data-role="label_MATERIAL_HOUSE5"
                  for="MATERIAL_HOUSE5">Кирпич</label>
              </div>
              <div class="checkbox-house house__material-checkbox">
                <input type="checkbox" value="monolith" name="MATERIAL_HOUSE"
                  id="MATERIAL_HOUSE6"  class="sr-only filterCalc">
                <label class="radio house__material-label" data-role="label_MATERIAL_HOUSE6"
                  for="MATERIAL_HOUSE6">Монолит</label>
              </div>
              <div class="checkbox-house house__material-checkbox">
                <input type="checkbox" value="foam_block" name="MATERIAL_HOUSE"
                  id="MATERIAL_HOUSE7"  class="sr-only filterCalc">
                <label class="radio house__material-label"
                  data-role="label_MATERIAL_HOUSE7"
                  for="MATERIAL_HOUSE7">Пеноблоки</label>
              </div>
              <div class="checkbox-house house__material-checkbox">
                <input type="checkbox" value="other" name="MATERIAL_HOUSE"
                  id="MATERIAL_HOUSE8"  class="sr-only filterCalc">
                <label class="radio house__material-label"
                  data-role="label_MATERIAL_HOUSE8"
                  for="MATERIAL_HOUSE8">Другое</label>
              </div>
            </div>
          </div>
          <div class="hero add-filter__hero house__hero">
            <div class="extra-options">
              <div
                class="row extra-options__parameters add-filter__extra-options plots__extra-options">
                <div
                  class="order-lg-1 col-md-3 col-lg-2 col-sm-4 col-4 add-modal__order plots__order">
                  <div class="extra-options__parameters-title">Коммуникация</div>
                  <div class="extra-options__parameters-input">
                    <input type="checkbox" class="sr-only filterCalc" value="Y"
                      name="ELECTRO" id="ELECTRO_HOUSE">
                    <label class="d-flex w-100 align-items-center"
                      data-role="label_ELECTRO_HOUSE"
                      for="ELECTRO_HOUSE"><span class="icon icon--svet">
                        <svg xmlns="http://www.w3.org/2000/svg" width="23.032" height="24"
                          viewBox="0 0 23.032 24" class="inline-svg">
                          <g transform="translate(-9.8)">
                            <path
                              d="M24.052,20.973v.7a1.112,1.112,0,0,1-.943,1.1l-.173.637A.793.793,0,0,1,22.17,24H20.457a.793.793,0,0,1-.765-.588l-.168-.637a1.117,1.117,0,0,1-.948-1.106v-.7a.674.674,0,0,1,.677-.677h4.123A.682.682,0,0,1,24.052,20.973Zm3.175-9.452a5.883,5.883,0,0,1-1.659,4.1,5.422,5.422,0,0,0-1.452,2.943.978.978,0,0,1-.968.825H19.479a.968.968,0,0,1-.963-.82,5.482,5.482,0,0,0-1.462-2.953,5.912,5.912,0,1,1,10.173-4.1Zm-5.244-3.58a.667.667,0,0,0-.667-.667,4.271,4.271,0,0,0-4.267,4.267.667.667,0,1,0,1.333,0,2.937,2.937,0,0,1,2.933-2.933A.664.664,0,0,0,21.983,7.941Zm-.667-4.272A.667.667,0,0,0,21.983,3V.667a.667.667,0,0,0-1.333,0V3A.667.667,0,0,0,21.316,3.669Zm-7.847,7.847a.667.667,0,0,0-.667-.667H10.467a.667.667,0,1,0,0,1.333H12.8A.664.664,0,0,0,13.469,11.516Zm18.7-.667H29.83a.667.667,0,1,0,0,1.333h2.336a.667.667,0,1,0,0-1.333ZM14.827,17.067l-1.654,1.654a.665.665,0,0,0,.938.943l1.654-1.654a.665.665,0,0,0-.938-.943Zm12.509-10.9A.666.666,0,0,0,27.8,5.97l1.654-1.654a.667.667,0,1,0-.943-.943L26.862,5.027a.665.665,0,0,0,0,.943A.677.677,0,0,0,27.336,6.163Zm-12.509-.2a.665.665,0,0,0,.938-.943L14.111,3.368a.667.667,0,1,0-.943.943ZM27.8,17.067a.667.667,0,1,0-.943.943l1.654,1.654a.665.665,0,1,0,.938-.943Z"
                              class="color-fill"></path>
                          </g>
                        </svg></span><span class="text"><span>Свет</span></span></label>
                  </div>
                  <div class="extra-options__parameters-input">
                    <input type="checkbox" class="sr-only filterCalc" value="Y"
                      name="PLUMBING" id="PLUMBING_HOUSE">
                    <label class="d-flex w-100 align-items-center"
                      data-role="label_PLUMBING_HOUSE"
                      for="PLUMBING_HOUSE"><span class="icon icon--voda">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15.782"
                          height="22.051" viewBox="0 0 15.782 22.051" class="inline-svg">
                          <g transform="translate(-35.275 0)">
                            <g transform="translate(35.275 0)">
                              <path
                                d="M44.09.76c-.6-1.031-1.244-1-1.848,0-2.772,4.123-6.967,10.308-6.967,13.4a7.891,7.891,0,1,0,15.782,0C51.057,11.033,46.862,4.883,44.09.76Zm4.763,16.919a6.749,6.749,0,0,1-2.381,2.31.955.955,0,0,1-.924-1.671,4.705,4.705,0,0,0,1.706-1.635,4.634,4.634,0,0,0,.711-2.275.943.943,0,0,1,1.884.107A7.042,7.042,0,0,1,48.853,17.679Z"
                                transform="translate(-35.275 0)" class="color-fill">
                              </path>
                            </g>
                          </g>
                        </svg></span><span class="text"><span>Вода</span></span></label>
                  </div>
                  <div class="extra-options__parameters-input">
                    <input type="checkbox" class="sr-only filterCalc" value="Y"
                      name="GAS" id="GAS_HOUSE">
                    <label class="d-flex w-100 align-items-center"
                      data-role="label_GAS_HOUSE"
                      for="GAS_HOUSE"><span class="icon icon--gaz">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17.883"
                          height="23.844" viewBox="0 0 17.883 23.844" class="inline-svg">
                          <g transform="translate(-64 0)">
                            <g transform="translate(64 0)">
                              <path
                                d="M81.832,13.96C81.559,10.4,79.9,8.176,78.442,6.209,77.09,4.389,75.922,2.817,75.922.5a.5.5,0,0,0-.27-.442.492.492,0,0,0-.516.038,12.633,12.633,0,0,0-4.663,6.739,22,22,0,0,0-.511,5.038c-2.026-.433-2.485-3.463-2.49-3.5A.5.5,0,0,0,66.764,8c-.106.051-2.607,1.322-2.753,6.4-.01.169-.011.338-.011.507a8.951,8.951,0,0,0,8.941,8.941.069.069,0,0,0,.02,0h.006A8.952,8.952,0,0,0,81.883,14.9C81.883,14.654,81.832,13.96,81.832,13.96Zm-8.89,8.889a3.086,3.086,0,0,1-2.98-3.175c0-.06,0-.12,0-.194a4.027,4.027,0,0,1,.314-1.577,1.814,1.814,0,0,0,1.64,1.188.5.5,0,0,0,.5-.5,9.937,9.937,0,0,1,.191-2.259,4.8,4.8,0,0,1,1.006-1.9,6.4,6.4,0,0,0,1.024,1.879,5.659,5.659,0,0,1,1.273,3.1c.006.085.013.171.013.263A3.086,3.086,0,0,1,72.941,22.849Z"
                                transform="translate(-64 0)" class="color-fill">
                              </path>
                            </g>
                          </g>
                        </svg></span><span class="text"><span>Газ</span></span></label>
                  </div>
                </div>
                <div
                  class="order-sm-5 col-sm-4 order-md-5 order-lg-3 col-md-3 col-lg-2 col-4 add-filter__par-3 plots__par-3">
                  <div class="row">
                    <div class="col-sm-12 col-lg-12 col-md-12 col-12 add-modal50 plots100">
                      <div class="extra-options__parameters-title">Как добраться</div>
                      <div class="extra-options__parameters-input">
                        <input type="checkbox" class="sr-only filterCalc" value="Y"
                          name="BUS" id="BUS_HOUSE">
                        <label class="d-flex w-100 align-items-center"
                          data-role="label_BUS_HOUSE"
                          for="BUS_HOUSE"><span class="icon icon--bus">
                            <svg xmlns="http://www.w3.org/2000/svg" width="33.298"
                              height="17.762" viewBox="0 0 33.298 17.762"
                              class="inline-svg">
                              <path
                                d="M.555,16.027h2.83A2.765,2.765,0,0,0,8.325,17.12a2.766,2.766,0,0,0,4.939-1.093h11.21a2.775,2.775,0,0,0,5.439,0h2.83a.555.555,0,0,0,.555-.555V11.259a7.2,7.2,0,0,0-.2-1.669l-1.212-5.1a2.226,2.226,0,0,0-2.177-1.785H13.107L12.154.8a.555.555,0,0,0-.5-.307H3.885a.555.555,0,0,0-.5.307L2.432,2.708H.555A.555.555,0,0,0,0,3.263V15.472A.555.555,0,0,0,.555,16.027Zm5.55,1.11a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,6.1,17.137Zm4.44,0a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,10.544,17.137Zm16.649,0a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,27.194,17.137Zm4.828-7.291c.006.026.008.051.013.077H27.748V6.038h3.369ZM4.228,1.6h7.084l.555,1.11H3.673ZM1.11,3.818h28.6a1.119,1.119,0,0,1,1.093.912l.05.2H1.11Zm25.529,2.22V9.923h-3.33V6.038Zm-4.44,0V9.923h-3.33V6.038Zm-4.44,0V9.923h-3.33V6.038Zm-4.44,0V9.923H9.989V6.038Zm-4.44,0V9.923H5.55V6.038Zm-7.77,0H4.44V9.923H1.11Zm0,7.215H2.22v-1.11H1.11v-1.11H32.175c0,.075.013.15.013.226v.884h-1.11v1.11h1.11v1.665H29.913a.147.147,0,0,0-.009-.029,2.745,2.745,0,0,0-.144-.462c-.022-.056-.051-.1-.076-.154a2.872,2.872,0,0,0-.16-.294c-.035-.056-.076-.106-.115-.158a2.862,2.862,0,0,0-.2-.238c-.047-.049-.095-.1-.145-.142a2.624,2.624,0,0,0-.234-.193q-.083-.061-.166-.116a2.955,2.955,0,0,0-.278-.149c-.059-.028-.116-.055-.177-.083a2.755,2.755,0,0,0-.333-.1c-.056-.014-.107-.033-.164-.044a2.631,2.631,0,0,0-1.054,0c-.056.011-.111.03-.164.044a2.768,2.768,0,0,0-.333.1c-.061.024-.118.056-.177.083a2.927,2.927,0,0,0-.278.149q-.083.055-.166.116a2.592,2.592,0,0,0-.234.193c-.05.046-.1.092-.145.142a2.954,2.954,0,0,0-.2.238c-.039.052-.079.1-.115.158a2.829,2.829,0,0,0-.16.294c-.025.052-.056.1-.076.154a2.767,2.767,0,0,0-.144.462.137.137,0,0,1-.009.029h-11.2a.147.147,0,0,0-.009-.029,2.787,2.787,0,0,0-.144-.462c-.022-.056-.051-.1-.076-.154a2.871,2.871,0,0,0-.16-.294c-.035-.056-.076-.106-.115-.158a2.907,2.907,0,0,0-.2-.238c-.047-.049-.095-.1-.145-.142a2.624,2.624,0,0,0-.234-.193q-.083-.061-.167-.116a2.923,2.923,0,0,0-.277-.149c-.059-.028-.116-.055-.177-.083a2.727,2.727,0,0,0-.33-.1c-.056-.014-.107-.033-.166-.044a2.583,2.583,0,0,0-1.033,0l-.086.016a2.767,2.767,0,0,0-.451.14l-.082.036a2.791,2.791,0,0,0-.42.228l-.022.017a2.789,2.789,0,0,0-.357.295l-.056.051a2.778,2.778,0,0,0-.235.272,2.827,2.827,0,0,0-.242-.278c-.018-.018-.036-.034-.056-.051a2.81,2.81,0,0,0-.357-.295l-.022-.017a2.8,2.8,0,0,0-.42-.228L7.146,12.9a2.792,2.792,0,0,0-.451-.14l-.086-.016a2.581,2.581,0,0,0-1.033,0c-.056.011-.111.03-.164.044a2.716,2.716,0,0,0-.333.1c-.061.024-.118.056-.177.083a2.91,2.91,0,0,0-.275.149c-.055.037-.111.075-.166.116a2.627,2.627,0,0,0-.234.193c-.05.046-.1.092-.145.142a2.832,2.832,0,0,0-.2.238c-.039.052-.079.1-.115.158a2.809,2.809,0,0,0-.16.294c-.025.052-.056.1-.076.154a2.732,2.732,0,0,0-.144.462.147.147,0,0,1-.009.029H1.11Zm0,0"
                                transform="translate(0 -0.488)" fill="#3c4b5a">
                              </path>
                              <path d="M230.4,202.09h11.1v1.11H230.4Zm0,0"
                                transform="translate(-217.079 -190.435)"
                                fill="#3c4b5a"></path>
                            </svg></span><span
                            class="text"><span>Автобус</span></span></label>
                      </div>
                      <div class="extra-options__parameters-input">
                        <input type="checkbox" class="sr-only filterCalc" value="Y"
                          name="TRAIN" id="TRAIN_HOUSE">
                        <label class="d-flex w-100 align-items-center"
                          data-role="label_TRAIN_HOUSE"
                          for="TRAIN_HOUSE"><span class="icon icon--train">
                            <svg xmlns="http://www.w3.org/2000/svg" width="33.298"
                              height="13.319" viewBox="0 0 33.298 13.319"
                              class="inline-svg">
                              <path
                                d="M250.156,139.33h2.22a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33A.555.555,0,0,0,250.156,139.33Zm.555-3.33h1.11v2.22h-1.11Zm0,0"
                                transform="translate(-235.172 -132.671)"
                                fill="#3c4b5a"></path>
                              <path
                                d="M137.173,139.33a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33a.555.555,0,0,0,.555.555ZM135.509,136h1.11v2.22h-1.11Zm0,0"
                                transform="translate(-126.629 -132.671)"
                                fill="#3c4b5a"></path>
                              <path
                                d="M60.376,139.33a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33a.555.555,0,0,0,.555.555ZM58.711,136h1.11v2.22h-1.11Zm0,0"
                                transform="translate(-54.272 -132.671)"
                                fill="#3c4b5a"></path>
                              <path
                                d="M2.22,138.775v-3.33a.555.555,0,0,0-.555-.555H0V136H1.11v2.22H0v1.11H1.665A.555.555,0,0,0,2.22,138.775Zm0,0"
                                transform="translate(0 -132.671)" fill="#3c4b5a">
                              </path>
                              <path d="M364.8,192.488h2.22v1.11H364.8Zm0,0"
                                transform="translate(-343.712 -186.939)"
                                fill="#3c4b5a"></path>
                              <path d="M460.8,230.887h1.11V232H460.8Zm0,0"
                                transform="translate(-434.162 -223.117)"
                                fill="#3c4b5a"></path>
                              <path d="M518.4,230.887h1.11V232H518.4Zm0,0"
                                transform="translate(-488.43 -223.117)"
                                fill="#3c4b5a"></path>
                              <path
                                d="M15.242,96.488H0V97.6H12.209v6.66H0v1.11H12.209v1.11H0v1.11H2.775a2.2,2.2,0,0,0,.308,1.11H0v1.11H33.3V108.7H26.885a2.2,2.2,0,0,0,.308-1.11H29.72a3.578,3.578,0,0,0,2.291-6.327l-3.718-3.1a7.23,7.23,0,0,0-4.62-1.673h-8.43ZM4.995,108.7a1.11,1.11,0,0,1-1.11-1.11H6.1A1.11,1.11,0,0,1,4.995,108.7Zm3.33,0a1.11,1.11,0,0,1-1.11-1.11h2.22A1.11,1.11,0,0,1,8.325,108.7Zm4.995-3.33h5.55v1.11h-5.55Zm-3.083,3.33a2.2,2.2,0,0,0,.308-1.11H22.754a2.2,2.2,0,0,0,.309,1.11Zm14.738,0a1.11,1.11,0,0,1-1.11-1.11h2.22A1.11,1.11,0,0,1,24.974,108.7Zm3.573-8.879,2.664,2.22H25.973a.555.555,0,0,1-.427-.2l-1.682-2.02h4.683Zm-8.567,5.55h5.55v-1.11h-5.55V97.6h3.693a6.118,6.118,0,0,1,3.508,1.11H23.864a1.11,1.11,0,0,0-.852,1.82l1.685,2.02a1.661,1.661,0,0,0,1.277.6h6.049a2.439,2.439,0,0,1-2.3,3.33H19.979Zm-1.11-7.77v6.66h-5.55V97.6Z"
                                transform="translate(0 -96.488)" fill="#3c4b5a">
                              </path>
                            </svg></span><span
                            class="text"><span>Электричка</span></span></label>
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="order-sm-4 col-sm-4 order-md-3 order-lg-5 order-xl-4 col-md-3 col-lg-2 add-filter__par-4 col-4 plots__par-4">
                  <div class="extra-options__parameters-title">Природа</div>
                  <div class="extra-options__parameters-input">
                    <input class="sr-only filterCalc" type="checkbox" id="WATER_HOUSE" name="WATER">
                    <label class="d-flex w-100 align-items-center" for="WATER_HOUSE"><span
                        class="icon icon--vodoem">
                        <svg xmlns="http://www.w3.org/2000/svg" width="23.111"
                          height="14.182" viewBox="0 0 23.111 14.182" class="inline-svg">
                          <g transform="translate(0 -98.909)">
                            <g transform="translate(0 98.909)">
                              <g>
                                <path
                                  d="M20.686,100.11a5.278,5.278,0,0,0-6.7,0,3.561,3.561,0,0,1-2.425.9,3.561,3.561,0,0,1-2.426-.9,5.078,5.078,0,0,0-3.352-1.2,5.078,5.078,0,0,0-3.352,1.2,3.561,3.561,0,0,1-2.426.9V103.9a3.561,3.561,0,0,0,2.426-.9,5.078,5.078,0,0,1,3.352-1.2A5.078,5.078,0,0,1,9.13,103a3.561,3.561,0,0,0,2.426.9,3.561,3.561,0,0,0,2.425-.9,5.278,5.278,0,0,1,6.7,0,3.561,3.561,0,0,0,2.425.9V101.01A3.561,3.561,0,0,1,20.686,100.11Z"
                                  transform="translate(0 -98.909)"
                                  class="color-fill"></path>
                              </g>
                            </g>
                            <g transform="translate(0 108.101)">
                              <g>
                                <path
                                  d="M19.759,303.446a3.719,3.719,0,0,0-4.851,0,5.077,5.077,0,0,1-3.352,1.2,5.078,5.078,0,0,1-3.352-1.2,3.562,3.562,0,0,0-2.426-.9,3.561,3.561,0,0,0-2.426.9A5.078,5.078,0,0,1,0,304.647v2.889a5.078,5.078,0,0,0,3.352-1.2,3.561,3.561,0,0,1,2.426-.9,3.561,3.561,0,0,1,2.426.9,5.078,5.078,0,0,0,3.352,1.2,5.077,5.077,0,0,0,3.352-1.2,3.719,3.719,0,0,1,4.851,0,5.077,5.077,0,0,0,3.352,1.2v-2.889A5.077,5.077,0,0,1,19.759,303.446Z"
                                  transform="translate(0 -302.546)"
                                  class="color-fill"></path>
                              </g>
                            </g>
                            <g transform="translate(0 103.374)">
                              <g>
                                <path
                                  d="M19.759,198.718a3.719,3.719,0,0,0-4.851,0,5.077,5.077,0,0,1-3.352,1.2,5.078,5.078,0,0,1-3.352-1.2,3.561,3.561,0,0,0-2.426-.9,3.561,3.561,0,0,0-2.426.9A5.077,5.077,0,0,1,0,199.919v3.152a3.561,3.561,0,0,0,2.426-.9,5.078,5.078,0,0,1,3.352-1.2,5.078,5.078,0,0,1,3.352,1.2,3.561,3.561,0,0,0,2.426.9,3.561,3.561,0,0,0,2.425-.9,5.278,5.278,0,0,1,6.7,0,3.561,3.561,0,0,0,2.425.9v-3.152A5.077,5.077,0,0,1,19.759,198.718Z"
                                  transform="translate(0 -197.818)"
                                  class="color-fill"></path>
                              </g>
                            </g>
                          </g>
                        </svg></span><span class="text"><span>Водоем</span></span></label>
                  </div>
                  <div class="extra-options__parameters-input">
                    <input class="sr-only filterCalc" type="checkbox" id="LES_HOUSE" name="LES">
                    <label class="d-flex w-100 align-items-center" for="LES_HOUSE"><span
                        class="icon icon--les">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17.38"
                          height="24.833" viewBox="0 0 17.38 24.833" class="inline-svg">
                          <path
                            d="M72.266,7.657a4.88,4.88,0,0,0-.51-.475,2.01,2.01,0,0,0-1.871-2.747c-.065,0-.13,0-.194.009a4.838,4.838,0,0,0-8.9-2.2,3.412,3.412,0,0,0-3.306,5.4l-.012.013a4.841,4.841,0,0,0,3.549,8.133,4.93,4.93,0,0,0,.743-.056l1.787,2.76-.871,5.642a.6.6,0,0,0,.133.486.623.623,0,0,0,.476.211h3.186a.623.623,0,0,0,.476-.211.6.6,0,0,0,.133-.486l-.856-5.547,1.84-2.842a4.932,4.932,0,0,0,.652.044,4.841,4.841,0,0,0,3.549-8.133Zm-7.349,9.29-1.254-1.938a4.829,4.829,0,0,0,1.2-1.123,4.826,4.826,0,0,0,1.275,1.167Z"
                            transform="translate(-56.177)" class="color-fill"></path>
                        </svg></span><span class="text"><span>Лес</span></span></label>
                  </div>
                  <div class="extra-options__parameters-input">
                    <input type="checkbox" class="sr-only filterCalc" value="Y"
                      name="PLYAZH" id="PLYAZH_HOUSE">
                    <label class="d-flex w-100 align-items-center"
                      data-role="label_PLYAZH_HOUSE"
                      for="PLYAZH_HOUSE"><span class="icon icon--plyaj">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21.889"
                          height="21.799" viewBox="0 0 21.889 21.799" class="inline-svg">
                          <g transform="translate(0 -0.093)">
                            <path
                              d="M21.565,18.948a.947.947,0,0,0-.744-.229,25.544,25.544,0,0,1-4.17.2,11.6,11.6,0,0,1-3-.558L10.325,8.835a37.7,37.7,0,0,1,7.317-1.6.943.943,0,0,0,.734-1.372A9.638,9.638,0,0,0,7.571.953L7.491.725A.942.942,0,0,0,6.29.146L6.274.151a.943.943,0,0,0-.579,1.2l.079.228A9.636,9.636,0,0,0,.368,12.113a.943.943,0,0,0,1.44.615A34.44,34.44,0,0,1,8.528,9.46l2.8,8.012c-2.261-.958-4.424-1.961-7.28-1.526A6.96,6.96,0,0,0,.237,18.28.95.95,0,0,0,0,18.9V20.95a.946.946,0,0,0,.947.943H20.942a.947.947,0,0,0,.948-.943v-1.3A.952.952,0,0,0,21.565,18.948Z"
                              class="color-fill"></path>
                          </g>
                        </svg></span><span class="text"><span>Пляж</span></span></label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer add-filter__footer house__footer">
          <div class="add-filter__footer-wrap">
            <button class="btn btn-lg btn-warning add-filter__footer-button" type="submit">Подобрать</button>
            <button class="btn btn-link filter__button-clear add-filter__button-reset" type="reset">
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg" class="add-filter__button-reset-svg">
                <path d="M15 5L5 15" stroke="#919FA3" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" />
                <path d="M5 5L15 15" stroke="#919FA3" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>Сбросить фильтр
            </button>
          </div>
        </div>
      </div>

    </div>
  </div>

</form>

<!-- Button trigger modal Поселки -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#townshipModal">
  Поселки
</button> -->

<!-- Button trigger modal Участки -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#plotsModal">
  Участки
</button> -->

<!-- Button trigger modal Дома -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#houseModal">
  Дома
</button> -->

<!-- Button trigger modal Шоссе -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#highwayModal">
  Шоссе
</button> -->

<!-- Button trigger modal Район -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#regionModal">
  Район
</button> -->
