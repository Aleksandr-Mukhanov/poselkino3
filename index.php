<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetPageProperty("description", "Единая база загородной недвижимости. Обзор коттеджных и дачных поселков в Московской области ✔Отзывы покупателей ✔Независимый рейтинг ✔Честный обзор ✔Стоимость коммуникаций ✔Актуальные фото ✔Видео с квадрокоптера ✔Экология местности ✔Юридическая чистота");
$APPLICATION->SetPageProperty("title", "Продажа загородной недвижимости в Московской области | Поселкино");
$APPLICATION->SetTitle("Главная");

// получим кол-во отзывов
$cntAllOtz = 0;
$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>2,"ACTIVE"=>"Y");
$arSelect = Array("ID");
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while($arElement = $rsElements->GetNext()){ // dump($arElement);
	$cntAllOtz++;
}

global $arrFilter;
	$arrFilter['!PROPERTY_SALES_PHASE'] = [254]; // уберем проданные
	$arrFilter['!PROPERTY_HIDE_POS'] = 273; // метка убрать из каталога
?>
<main class="page page-home">
  <!-- Hero-->
  <div class="bg-white">
    <div class="container hero">
      <div class="row">
        <div class="col-12">
          <div class="hero-wrap">
            <div class="row align-items-center align-items-sm-start hero-wrap__title">
              <div class="col-9 col-sm-8 col-md-6">
                <h1>Найди лучший поселок для&nbsp;жизни</h1>
              </div>
              <div class="col-3 text-center d-flex d-sm-none"><svg xmlns="http://www.w3.org/2000/svg" width="26.216" height="26.216" viewBox="0 0 26.216 26.216" class="inline-svg hero-info-show">
                  <path d="M13.108,0A13.108,13.108,0,1,0,26.216,13.108,13.123,13.123,0,0,0,13.108,0Zm.853,20.885c-.623.1-1.862.363-2.491.415a1.534,1.534,0,0,1-1.342-.7,1.638,1.638,0,0,1-.2-1.5l2.478-6.813H9.831a3.08,3.08,0,0,1,2.425-2.864,9.485,9.485,0,0,1,2.491-.413,1.976,1.976,0,0,1,1.342.7,1.638,1.638,0,0,1,.2,1.5l-2.478,6.813h2.575a2.9,2.9,0,0,1-2.424,2.862Zm.786-12.693a1.639,1.639,0,1,1,1.639-1.639,1.639,1.639,0,0,1-1.639,1.639Z" />
                </svg></div>
              <div class="col-12 col-sm-4 col-md-3">
                <div class="hero-info">
                  <p>Независимый обзор дачных и&nbsp;коттеджных поселков в&nbsp;Московской области</p>
                </div>
              </div>
            </div>
						<?$APPLICATION->IncludeComponent(
		        	"bitrix:catalog.smart.filter",
		        	"poselkino_index",
		        	array(
		        		"CACHE_GROUPS" => "Y",
		        		"CACHE_TIME" => "36000000",
		        		"CACHE_TYPE" => "N",
		        		"CONVERT_CURRENCY" => "N",
		        		"DISPLAY_ELEMENT_COUNT" => "Y",
		        		"FILTER_NAME" => "arrFilter",
		        		"FILTER_VIEW_MODE" => "horizontal",
		        		"HIDE_NOT_AVAILABLE" => "N",
		        		"IBLOCK_ID" => "1",
		        		"IBLOCK_TYPE" => "content",
		        		"PAGER_PARAMS_NAME" => "arrPager",
		        		"POPUP_POSITION" => "left",
		        		"SAVE_IN_SESSION" => "N",
		        		"SECTION_CODE" => "",
		        		"SECTION_CODE_PATH" => "",
		        		"SECTION_DESCRIPTION" => "-",
		        		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		        		"SECTION_TITLE" => "-",
		        		"SEF_MODE" => "Y",
		        		"SEF_RULE" => "/poselki/filter/#SMART_FILTER_PATH#/apply/",
		        		"SMART_FILTER_PATH" => $_REQUEST["SMART_FILTER_PATH"],
		        		"TEMPLATE_THEME" => "green",
		        		"XML_EXPORT" => "N",
		        		"COMPONENT_TEMPLATE" => "poselkino"
		        	),
		        	false
		        );?>
            <div class="row">
              <div class="col-4 hero__count">
                <div class="hero__count-num"><?=$cntAllVil?></div>
                <div class="hero__count-title">проверенных<br>поселков</div>
              </div>
              <div class="col-4 hero__count">
                <div class="hero__count-num"><?=$cntAllOtz?></div>
                <div class="hero__count-title">отзывов<br>от жителей</div>
              </div>
              <div class="col-4 hero__count">
                <div class="hero__count-num">68</div>
                <div class="hero__count-title">параметров <br>оценки</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Поселки с высоким рейтингом-->
  <div class="high-raiting">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-xl-8 col-md-7 col-sm-6">
          <div class="block-page__title block-page__title--icon mt-3">
            <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="19.481" height="18.578" viewBox="0 0 19.481 18.578" class="inline-svg">
                <path d="M10.2.758l2.478 5.865 6.344.545a.5.5 0 0 1 .285.876L14.5 12.213l1.442 6.2a.5.5 0 0 1-.745.541l-5.456-3.286-5.452 3.288a.5.5 0 0 1-.745-.541l1.442-6.2L.173 8.043a.5.5 0 0 1 .285-.876L6.8 6.622 9.28.758a.5.5 0 0 1 .921 0z" />
              </svg></div>
            <h2>Поселки с высоким рейтингом</h2>
          </div>
        </div>
        <div class="col-xl-4 col-md-5 col-sm-6">
          <div class="d-flex justify-content-end">
            <ul class="nav tab-switcher" role="tablist">
              <li><a id="raiting-area-tab" class="active" data-toggle="tab" href="#raiting-area" role="tab" aria-controls="raiting-area" aria-selected="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="17.323" height="15.8" viewBox="0 0 17.323 15.8" class="inline-svg">
                  <path d="M16.524 29.385q-.558 0-1.109.036-.186-.128-.4-.258v-1.35a1.5 1.5 0 0 0 1-1.415v-2a1.5 1.5 0 0 0-3 0v2a1.5 1.5 0 0 0 1 1.415v.8a12.065 12.065 0 0 0-3.009-1V26.01a.5.5 0 0 0 .468-.868l-2.671-2a.5.5 0 0 0-.6 0l-2.671 2A.5.5 0 0 0 6 26.01v1.606a12.066 12.066 0 0 0-3.009 1v-.8A1.5 1.5 0 0 0 4 26.4v-2a1.5 1.5 0 1 0-3 0v2a1.5 1.5 0 0 0 1 1.415v1.35q-.209.13-.4.258-.543-.037-1.1-.038a.5.5 0 0 0-.5.5V37.9a.5.5 0 0 0 .5.5h16.024a.5.5 0 0 0 .5-.5v-8.016a.5.5 0 0 0-.5-.499zm-.5 8.013h-2.253a11 11 0 0 0-1.816-3.028 12.807 12.807 0 0 0-2.48-2.26 14.967 14.967 0 0 1 6.55-1.72zm-3.335 0H7.632a7.556 7.556 0 0 0-2.569-3.49A7.524 7.524 0 0 0 1 32.406v-2.015c5.242.168 9.9 2.971 11.693 7.007zm-8.358 0H1v-3.992A6.6 6.6 0 0 1 6.564 37.4H4.332zm9.686-13a.5.5 0 1 1 1.006 0v2a.5.5 0 1 1-1.006 0zm-7.011.894l1.5-1.128 1.5 1.128v2.176A13.2 13.2 0 0 0 9 27.394v-.749a.5.5 0 0 0-1 0v.749c-.347.013-.682.038-1.006.074zM2 24.4a.5.5 0 1 1 1 0v2a.5.5 0 1 1-1 0zm6.512 3.984a11.459 11.459 0 0 1 5.272 1.229 15.351 15.351 0 0 0-5.272 1.884 15.351 15.351 0 0 0-5.272-1.884 11.459 11.459 0 0 1 5.271-1.234z" transform="translate(.15 -22.745)" />
                </svg>Участок</a></li>
              <li><a id="raiting-area-home-tab" data-toggle="tab" href="#raiting-area-home" role="tab" aria-controls="raiting-area-home" aria-selected="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="16.523" height="16.523" viewBox="0 0 16.523 16.523" class="inline-svg">
                  <path d="M16.523 1.614v13.3a1.615 1.615 0 0 1-1.614 1.614h-1.57a.645.645 0 1 1 0-1.291h1.571a.323.323 0 0 0 .323-.323V8.939h-5.7a.645.645 0 0 1 0-1.291h5.7V1.614a.323.323 0 0 0-.323-.323H7.618v1.893a.645.645 0 0 1-1.291 0V1.291H1.614a.323.323 0 0 0-.323.323v6h5.036V5.723a.645.645 0 0 1 1.291 0V10.8a.645.645 0 1 1-1.291 0V8.907H1.291v6a.323.323 0 0 0 .323.323h4.713v-1.891a.645.645 0 0 1 1.291 0v1.893H10.8a.645.645 0 1 1 0 1.291H1.614A1.615 1.615 0 0 1 0 14.909V1.614A1.615 1.615 0 0 1 1.614 0h13.3a1.615 1.615 0 0 1 1.609 1.614zm0 0" />
                </svg>Участок с домом</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="tab-content">
        <div class="tab-pane active" id="raiting-area" role="tabpanel">
          <div class="block-page__offer" id="raiting-area-slick">
						<?$arrFilter=array('PROPERTY_DOMA'=>[3,256]); // показывать только участки?>
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
		 				<?unset($arrFilter['PROPERTY_DOMA']);?>
          </div>
        </div>
        <div class="tab-pane" id="raiting-area-home" role="tabpanel">
          <div class="block-page__offer" id="raiting-area-home-slick">
						<?$arrFilter=array('PROPERTY_DOMA'=>[4,256]); // показывать участки с домами?>
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
		 				<?unset($arrFilter['PROPERTY_DOMA']);?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Портал Поселкино.ру-->
  <div class="about about-home-portal bg-white">
    <div class="container">
      <div class="row">
        <div class="col-12 d-sm-none">
          <h3 class="about-home-portal__title h2">Портал Поселкино.ру</h3>
          <div class="about-home-portal__subtitle">Единая база дачных и коттеджных поселков Московского региона. </div>
        </div>
        <div class="col-sm-6 col-xl-5">
          <div class="video">
            <div class="video__background-color"></div>
            <div class="video__background" id="openVideo">
							<a href="https://www.youtube.com/watch?v=QCxjM_KyQEY" data-poster="/assets/img/site/logo-white.png">
	              <svg xmlns="http://www.w3.org/2000/svg" width="102" height="102" viewBox="0 0 102 102" class="inline-svg play">
	                <g transform="translate(-314 -1783)">
	                  <g>
	                    <circle cx="31" cy="31" r="31" transform="translate(334 1803)" class="circle-main-stroke" />
	                    <circle cx="27" cy="27" r="27" transform="translate(338 1807)" class="circle-main" />
	                    <g>
	                      <g transform="translate(324 1793)" fill="none" class="circle-line" stroke-linecap="round" stroke-width="1" stroke-dasharray="45">
	                        <circle cx="41" cy="41" r="41" stroke="none" />
	                        <circle cx="41" cy="41" r="40.5" fill="none" />
	                      </g>
	                      <g transform="translate(314 1783)" fill="none" class="circle-line" stroke-linecap="round" stroke-width="1" stroke-dasharray="45 10">
	                        <circle cx="51" cy="51" r="51" stroke="none" />
	                        <circle cx="51" cy="51" r="50.5" fill="none" />
	                      </g>
	                    </g>
	                    <path class="triangle" d="M17.779,8.1,6.13.071A.4.4,0,0,0,5.5.4V16.47a.4.4,0,0,0,.63.331l11.65-8.034a.4.4,0,0,0,0-.661Z" transform="translate(354.774 1826.564)" />
	                  </g>
	                </g>
	              </svg><img class="logo-white" src="/assets/img/site/logo-white.png" alt="Поселкино"></a>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-xl-7 about-home-portal__block-right">
          <div class="d-none d-sm-block">
            <h3 class="about-home-portal__title h1">Портал Поселкино.ру</h3>
            <div class="about-home-portal__subtitle">Единая база дачных и коттеджных поселков Московского региона. </div>
          </div>
          <div class="about-home-portal__text">
            <p>Мы независимы от собственников поселков или девелоперских компаний, мы не заинтересованы продать вам конкретный объект недвижимости. Мы стараемся дать максимально объективную оценку и сделать простым и удобным поиск будущего участка.
            </p>
            <p>Теперь у пользователя нашего сайта есть возможность найти тот участок, который будет подходить всем требованиям и пожеланиям.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Тест-->
  <div class="test test-home">
    <div class="container">
      <div class="test-home__wrap">
        <div class="row">
          <div class="col-sm-4 col-lg-4 text-center"><img class="test-home__img" src="/assets/img/site/test-img@2x.jpg" alt></div>
          <div class="col-sm-3 col-lg-2">
            <div class="d-flex align-items-center justify-content-center"><svg xmlns="http://www.w3.org/2000/svg" width="137.656" height="98.903" viewBox="0 0 137.656 98.903" class="inline-svg">
                <g transform="translate(507.352 -144.68) rotate(110)">
                  <path d="M304.056,292.334c11.11,30.609-10,35.854,6.2,39.068,7.237,1.83,15.664.059,21.481,5.945,7.417,7.317.693,17.042-2.143,25.151-2.126,6.082-5.374,17.373.444,23.257,5.671,5.308,13.434-.379,19.2-1.862,16.3-3.576,17.424,12.742,16.631,24.015"
                    transform="translate(-1.347 -0.955)" fill="none" stroke="#919fa3" stroke-miterlimit="10" stroke-width="1" stroke-dasharray="5" />
                  <path d="M0,20.6C4.433,13.928,7.268,5.818,13.154,0c1.631,6.345,4.565,12.972,7.35,19.022" transform="translate(289.428 289.108) rotate(-20)" fill="none" stroke="#919fa3" stroke-miterlimit="10" stroke-width="1" />
                </g>
              </svg></div>
          </div>
          <div class="col-sm-5 col-lg-4">
            <div class="h1">Пройдите тест</div>
            <p>И определите поселок, котороый подходит вам больше всех</p><a class="btn btn-warning rounded-pill" href="/test/">Пройти тест</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Как мы работаем-->
  <div class="about about-home-work bg-white">
    <div class="container">
      <h3 class="h1 text-md-center">Как мы работаем</h3>
      <p class="text-md-center text-secondary">Мы собрали подробную информацию о каждом поселке</p>
    </div>
    <div class="container mt-5 mt-md-0">
      <div class="work-steps d-none d-md-flex">
        <div class="step step--top active " data-step="1">
          <div class="step-title" style="width: 125px;">Юридическая<br>проверка</div>
          <div class="step-circle"></div>
          <div class="step-cloud">
            <div class="step-cloud__text">Мы заказываем документы из гос. органов для каждого поселка</div>
            <div class="step-cloud__footer">
              <div class="step-cloud__prev">
                <svg xmlns="http://www.w3.org/2000/svg" width="15.574" height="9.815" viewBox="0 0 15.574 9.815">
                  <path d="M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z" transform="translate(0 -75.914)" />
                </svg>
              </div>
              <div class="step-cloud__num">01<span>/ 06</span></div>
              <div class="step-cloud__next">
                <svg xmlns="http://www.w3.org/2000/svg" width="15.574" height="9.815" viewBox="0 0 15.574 9.815">
                  <path d="M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z" transform="translate(0 -75.914)" />
                </svg>
              </div>
            </div>
          </div>
        </div>
        <div class="step step--bottom " data-step="2">
          <div class="step-title" style="width: 325px;">Экология</div>
          <div class="step-circle"></div>
          <div class="step-cloud">
            <div class="step-cloud__text">Мы анализируем экологическую обстановку в местах, где расположены поселки</div>
            <div class="step-cloud__footer">
              <div class="step-cloud__prev">
                <svg xmlns="http://www.w3.org/2000/svg" width="15.574" height="9.815" viewBox="0 0 15.574 9.815">
                  <path d="M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z" transform="translate(0 -75.914)" />
                </svg>
              </div>
              <div class="step-cloud__num">02<span>/ 06</span></div>
              <div class="step-cloud__next">
                <svg xmlns="http://www.w3.org/2000/svg" width="15.574" height="9.815" viewBox="0 0 15.574 9.815">
                  <path d="M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z" transform="translate(0 -75.914)" />
                </svg>
              </div>
            </div>
          </div>
        </div>
        <div class="step step--top " data-step="3">
          <div class="step-title" style="width: 145px;">Отзывы<br>от жильцов</div>
          <div class="step-circle"></div>
          <div class="step-cloud">
            <div class="step-cloud__text">Наши специалисты собирают реальные отзывы от жителей при посещении поселков</div>
            <div class="step-cloud__footer">
              <div class="step-cloud__prev">
                <svg xmlns="http://www.w3.org/2000/svg" width="15.574" height="9.815" viewBox="0 0 15.574 9.815">
                  <path d="M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z" transform="translate(0 -75.914)" />
                </svg>
              </div>
              <div class="step-cloud__num">03<span>/ 06</span></div>
              <div class="step-cloud__next">
                <svg xmlns="http://www.w3.org/2000/svg" width="15.574" height="9.815" viewBox="0 0 15.574 9.815">
                  <path d="M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z" transform="translate(0 -75.914)" />
                </svg>
              </div>
            </div>
          </div>
        </div>
        <div class="step step--left " data-step="4">
          <div class="step-title" style="width: 125px;">Реальная<br>стоимость<br>земли</div>
          <div class="step-circle"></div>
          <div class="step-cloud">
            <div class="step-cloud__text">Мы рассчитываем стоимость участка с учетом всех дополнительных затрат</div>
            <div class="step-cloud__footer">
              <div class="step-cloud__prev">
                <svg xmlns="http://www.w3.org/2000/svg" width="15.574" height="9.815" viewBox="0 0 15.574 9.815">
                  <path d="M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z" transform="translate(0 -75.914)" />
                </svg>
              </div>
              <div class="step-cloud__num">04<span>/ 06</span></div>
              <div class="step-cloud__next">
                <svg xmlns="http://www.w3.org/2000/svg" width="15.574" height="9.815" viewBox="0 0 15.574 9.815">
                  <path d="M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z" transform="translate(0 -75.914)" />
                </svg>
              </div>
            </div>
          </div>
        </div>
        <div class="step step--right " data-step="5">
          <div class="step-title" style="width: 163px;">Коммуникации</div>
          <div class="step-circle"></div>
          <div class="step-cloud">
            <div class="step-cloud__text">Мы публикуем фактическую информацию о коммуникациях, подведенных в поселки</div>
            <div class="step-cloud__footer">
              <div class="step-cloud__prev">
                <svg xmlns="http://www.w3.org/2000/svg" width="15.574" height="9.815" viewBox="0 0 15.574 9.815">
                  <path d="M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z" transform="translate(0 -75.914)" />
                </svg>
              </div>
              <div class="step-cloud__num">05<span>/ 06</span></div>
              <div class="step-cloud__next">
                <svg xmlns="http://www.w3.org/2000/svg" width="15.574" height="9.815" viewBox="0 0 15.574 9.815">
                  <path d="M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z" transform="translate(0 -75.914)" />
                </svg>
              </div>
            </div>
          </div>
        </div>
        <div class="step step--right " data-step="6">
          <div class="step-title" style="width: 141px;">Аэросъемка</div>
          <div class="step-circle"></div>
          <div class="step-cloud">
            <div class="step-cloud__text">Мы делаем аэросъемку каждого посёлка с помощью профессионального оборудования</div>
            <div class="step-cloud__footer">
              <div class="step-cloud__prev">
                <svg xmlns="http://www.w3.org/2000/svg" width="15.574" height="9.815" viewBox="0 0 15.574 9.815">
                  <path d="M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z" transform="translate(0 -75.914)" />
                </svg>
              </div>
              <div class="step-cloud__num">06<span>/ 06</span></div>
              <div class="step-cloud__next">
                <svg xmlns="http://www.w3.org/2000/svg" width="15.574" height="9.815" viewBox="0 0 15.574 9.815">
                  <path d="M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z" transform="translate(0 -75.914)" />
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="work-steps__mobile d-flex d-md-none">
        <div class="accordion">
          <div id="stepOne">
            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Юридическая проверка</button>
          </div>
          <div class="collapse show" id="collapseOne">
            <p>Мы заказываем документы из гос. органов для каждого поселка</p>
          </div>
          <div id="stepTwo">
            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Экология</button>
          </div>
          <div class="collapse" id="collapseTwo">
            <p>Мы анализируем экологическую обстановку в местах, где расположены поселки</p>
          </div>
          <div id="stepThreer">
            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Отзывы от жильцов</button>
          </div>
          <div class="collapse" id="collapseThree">
            <p>Наши специалисты собирают реальные отзывы от жителей при посещении поселков</p>
          </div>
          <div id="stepFour">
            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">Реальная стоимость земли</button>
          </div>
          <div class="collapse" id="collapseFour">
            <p>Мы рассчитываем стоимость участка с учетом всех дополнительных затрат</p>
          </div>
          <div id="stepFive">
            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">Коммуникации</button>
          </div>
          <div class="collapse" id="collapseFive">
            <p>Мы публикуем фактическую информацию о коммуникациях, подведенных в поселки</p>
          </div>
          <div id="stepSix">
            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">Аэросъемка</button>
          </div>
          <div class="collapse" id="collapseSix">
            <p>Мы делаем аэросъемку каждого посёлка с помощью профессионального оборудования</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Статьи-->
  <div class="article article-home">
    <div class="container">
      <div class="row">
        <div class="order-1 col-lg-9 col-md-8 col-sm-8">
          <div class="block-page__title block-page__title--icon">
            <h3 class="h1">Статьи, которые<br>будут вам интересны</h3>
          </div>
        </div>
        <div class="order-3 order-sm-2 col-xl-3 col-md-4 col-sm-4">
          <div class="d-flex align-items-end h-100"><a class="w-100 rounded-pill btn btn-outline-secondary" href="/blog/" title="Смотреть все статьи">Смотреть все статьи</a></div>
        </div>
        <div class="order-2 order-sm-3 col-12 px-3">
					<?$APPLICATION->IncludeComponent(
					 	"bitrix:news.list",
					 	"blog_index",
					 	Array(
					 		"ACTIVE_DATE_FORMAT" => "d.m.Y",
					 		"ADD_SECTIONS_CHAIN" => "N",
					 		"AJAX_MODE" => "N",
					 		"AJAX_OPTION_ADDITIONAL" => "",
					 		"AJAX_OPTION_HISTORY" => "N",
					 		"AJAX_OPTION_JUMP" => "N",
					 		"AJAX_OPTION_STYLE" => "Y",
					 		"CACHE_FILTER" => "N",
					 		"CACHE_GROUPS" => "Y",
					 		"CACHE_TIME" => "36000000",
					 		"CACHE_TYPE" => "A",
					 		"CHECK_DATES" => "Y",
					 		"DETAIL_URL" => "",
					 		"DISPLAY_BOTTOM_PAGER" => "N",
					 		"DISPLAY_DATE" => "Y",
					 		"DISPLAY_NAME" => "Y",
					 		"DISPLAY_PICTURE" => "Y",
					 		"DISPLAY_PREVIEW_TEXT" => "Y",
					 		"DISPLAY_TOP_PAGER" => "N",
					 		"FIELD_CODE" => array(0=>"",1=>"",),
					 		"FILE_404" => "",
					 		"FILTER_NAME" => "",
					 		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
					 		"IBLOCK_ID" => "3",
					 		"IBLOCK_TYPE" => "content",
					 		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
					 		"INCLUDE_SUBSECTIONS" => "Y",
					 		"MESSAGE_404" => "",
					 		"NEWS_COUNT" => "20",
					 		"PAGER_BASE_LINK_ENABLE" => "N",
					 		"PAGER_DESC_NUMBERING" => "N",
					 		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
					 		"PAGER_SHOW_ALL" => "N",
					 		"PAGER_SHOW_ALWAYS" => "N",
					 		"PAGER_TEMPLATE" => ".default",
					 		"PAGER_TITLE" => "Новости",
					 		"PARENT_SECTION" => "",
					 		"PARENT_SECTION_CODE" => "",
					 		"PREVIEW_TRUNCATE_LEN" => "100",
					 		"PROPERTY_CODE" => array(0=>"",1=>"",),
					 		"SET_BROWSER_TITLE" => "N",
					 		"SET_LAST_MODIFIED" => "N",
					 		"SET_META_DESCRIPTION" => "N",
					 		"SET_META_KEYWORDS" => "N",
					 		"SET_STATUS_404" => "Y",
					 		"SET_TITLE" => "N",
					 		"SHOW_404" => "Y",
					 		"SORT_BY1" => "ACTIVE_FROM",
					 		"SORT_BY2" => "SORT",
					 		"SORT_ORDER1" => "DESC",
					 		"SORT_ORDER2" => "ASC",
					 		"STRICT_SECTION_CHECK" => "N"
					 	)
					 );?>
        </div>
      </div>
    </div>
  </div>
	<?$APPLICATION->IncludeComponent(
		 "bitrix:main.include",
		 "",
		 Array(
			 "AREA_FILE_SHOW" => "file",
			 "AREA_FILE_SUFFIX" => "inc",
			 "EDIT_TEMPLATE" => "",
			 "PATH" => "/include/block_url.php"
		)
	);?>
  <div class="bg-white">
    <div class="footer-feedback">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="footer-feedback__wrap">
              <div class="row align-items-center text-center text-lg-left">
                <div class="offset-lg-1 col-lg-6 offset-xl-2 col-xl-5">
                  <h3>Нашли ошибку или неактуальную информацию?</h3>
                </div>
                <div class="col-xl-3 col-lg-4 px-3 mt-3 mt-lg-0"><a class="btn btn-outline-secondary rounded-pill" href="#" data-toggle="modal" data-target="#sendError" data-id-button="SEND_ERROR">Сообщить об ошибке</a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');?>
