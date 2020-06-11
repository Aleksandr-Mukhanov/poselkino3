<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

global $arrFilter;
  $arrFilter['!PROPERTY_SALES_PHASE'] = [254]; // уберем проданные
  $arrFilter['!PROPERTY_HIDE_POS'] = 273; // метка убрать из каталога

$APPLICATION->SetTitle("Поселки в Московской области");
$APPLICATION->SetPageProperty("title", "Поселки в Московской области – лучшие поселки на карте Подмосковья");
$APPLICATION->SetPageProperty("description", "Поселки в Московской области ➤Цены от ".getMetaInfo($arrFilter)['minPrice']." руб.➤Кол-во объявлений - ".getMetaInfo($arrFilter)['cntPos']." ✔Независимый рейтинг ✔Честный обзор ✔Стоимость коммуникаций ✔Актуальные фото ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота");

// dump($_REQUEST);
$shosse = $_REQUEST['SHOSSE_CODE'];
$rayon = $_REQUEST['RAYON_CODE'];
$typePos = $_REQUEST['TYPE_CODE'];
$domPos = $_REQUEST['DOMA_CODE'];
$mkadKM = $_REQUEST['MKAD_KM'];
$priceURL = $_REQUEST['PRICE_URL'];
$priceType = $_REQUEST['PRICE_TYPE'];
$areaUrl = $_REQUEST['AREA_URL'];
$areaType = $_REQUEST['AREA_TYPE'];
$classCode = $_REQUEST['CLASS_CODE'];
$commun = $_REQUEST['COMMUN'];
$typeURL = $_REQUEST['TYPE_URL'];
$plottage = $_REQUEST['PLOTTAGE'];
$pagen = $_REQUEST['PAGEN_1'];
$ourDir = $APPLICATION->GetCurDir();

$newTitle = false; $newDesc = false;
$h1 = 'Поселки в Московской области';
$h2 = '<h2 class="h1">Земельные участки под дом и дачу с хорошим месторасположением</h2>';
$SEO_text = '<p>База коттеджных и дачных поселков в Московской области. Каталог позволяет найти участки по нужным шоссе и районам, по площади и стоимости, по удаленности от МКАД и коммуникациям. Каждый поселок имеет свой рейтинг, оценку пользователей и отзывы.</p><p>Вы можете узнать всю необходимую информацию об интересующем вас поселке, не выходя из дома. На сайте есть фото и видео обзоры поселков, юридическая информация и объекты неблагоприятной экологии.</p>';
$urlAll = '/poselki/';
$urlNoDom = '/poselki/kupit-uchastok/';
$urlWithDom = '/poselki/kupit-dom/';
if ($pagen) $pageTitleDesc = 'Поселки';

if ($shosse || $rayon || $typePos || $domPos || $mkadKM || $priceURL || $areaUrl || $classCode || $commun || $typeURL || $plottage) { // странички шоссе или район

  require_once $_SERVER["DOCUMENT_ROOT"].'/poselki/seo-filter.php';

	require_once $_SERVER["DOCUMENT_ROOT"].'/poselki/seo-meta.php';

	require_once $_SERVER["DOCUMENT_ROOT"].'/poselki/seo-text.php';

	require_once $_SERVER["DOCUMENT_ROOT"].'/poselki/seo-multi-tegi.php';
}

// dump($arrFilter);
if($pagen && $pageTitleDesc){ // дописываем страницу в пагинации
	$h1 = $pageTitleDesc.' - Страница '.$pagen;
	$newTitle = $newDesc = $pageTitleDesc.' - Страница '.$pagen.' | сайт Посёлкино';
}
?>
<main class="page page-search">
  <div class="page-search__filter bg-white">
    <div class="container">
      <div class="d-block d-sm-none">
        <div class="bg-white py-2 d-flex"><a class="btn btn-outline-warning w-100 toggler-filter mr-3 mr-sm-0" href="#">Фильтры
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="7" viewBox="0 0 12 7" class="inline-svg">
            <g transform="rotate(-90 59.656 59.156)">
              <path d="M113.258 5.441l4.915-4.915a.308.308 0 1 0-.436-.436L112.6 5.225a.307.307 0 0 0 0 .436l5.134 5.132a.31.31 0 0 0 .217.091.3.3 0 0 0 .217-.091.307.307 0 0 0 0-.436z" />
            </g>
          </svg></a><a class="d-block d-sm-none btn btn-outline-warning show-map" href="#">
          <svg xmlns="http://www.w3.org/2000/svg" width="9.24" height="13.193" viewBox="0 0 9.24 13.193" class="inline-svg">
            <path d="M16.09 1.353a4.62 4.62 0 0 0-6.534 0 5.263 5.263 0 0 0-.435 6.494l3.7 5.346 3.7-5.339a5.265 5.265 0 0 0-.431-6.501zm-3.224 4.912a1.687 1.687 0 1 1 1.687-1.687 1.689 1.689 0 0 1-1.687 1.687z" transform="translate(-8.203)" />
          </svg></a></div>
      </div>
      <div class="show-mobile-filter" style="display: none;">
        <?$APPLICATION->IncludeComponent(
        	"bitrix:catalog.smart.filter",
        	"poselkino",
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
        <? // dump($arrFilter);
        if($newTitle)$APPLICATION->SetPageProperty("title", $newTitle);
        if($newDesc)$APPLICATION->SetPageProperty("description", $newDesc);
        ?>
      </div>
    </div>
  </div>
  <div class="d-none d-md-block">
    <div class="page__breadcrumbs">
      <div class="container">
        <div class="row align-items-center">
          <div class="order-1 order-sm-0 col-xl-5 col-lg-4">
            <?$APPLICATION->IncludeComponent(
              "bitrix:breadcrumb",
              "poselkino",
              array(
                "PATH" => "",
                "SITE_ID" => "s1",
                "START_FROM" => "0",
                "COMPONENT_TEMPLATE" => "poselkino"
              ),
              false
            );?>
          </div>
          <div class="order-0 order-sm-1 col-xl-7 col-lg-8">
            <div class="d-flex justify-content-lg-end">

              <a class="toggler-filter btn btn-warning d-none d-sm-block" href="#">Фильтр</a>
              <a class="d-none d-sm-flex btn btn-outline-warning ml-4 show-map" href="<?=$ourDir?>map/">
                <svg xmlns="http://www.w3.org/2000/svg" width="9.24" height="13.193" viewBox="0 0 9.24 13.193" class="inline-svg">
                  <path d="M16.09 1.353a4.62 4.62 0 0 0-6.534 0 5.263 5.263 0 0 0-.435 6.494l3.7 5.346 3.7-5.339a5.265 5.265 0 0 0-.431-6.501zm-3.224 4.912a1.687 1.687 0 1 1 1.687-1.687 1.689 1.689 0 0 1-1.687 1.687z" transform="translate(-8.203)" />
                </svg>&nbsp;<span class="d-none d-sm-inline">Показать на карте</span></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="d-block d-md-none my-4">

  </div>

  <div class="page__content-title">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-xl-7 col-lg-6">
          <h1 class="h2"><?=$h1?> <span class="text-secondary"><?$APPLICATION->ShowViewContent('COUNT_POS');?></span></h1>
        </div>
        <div class="col-xl-5 col-lg-6 filter__tab d-none d-sm-block">
          <ul class="nav justify-content-lg-end mt-lg-0 mt-2">
            <? // корректируем фильтр по домам
      			// dump($arrFilter);
      			$posNoDom = false;$posWithDom = false;
      			if($arrFilter['=PROPERTY_2'][0] == 3)$posNoDom = true;
      			if($arrFilter['=PROPERTY_2'][0] == 4)$posWithDom = true;
      			?>
            <?if(!$priceURL && !$areaUrl): // убираем для цены и площади?>
              <li class="nav-item"><a class="nav-link btn <?=(!$posNoDom && !$posWithDom)?'btn-success':'btn-outline-secondary';?> rounded-pill" href="<?=htmlspecialcharsbx($urlAll)?>">Поселки</a></li>
            <?endif;?>
     			  <?if($urlWithDom): // убираем у цены, если участки?>
              <li class="nav-item"><a class="nav-link btn <?=($posWithDom)?'btn-success':'btn-outline-secondary';?> rounded-pill" href="<?=htmlspecialcharsbx($urlWithDom)?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="17.323" height="15.8" viewBox="0 0 17.323 15.8" class="inline-svg">
                  <path d="M16.524 29.385q-.558 0-1.109.036-.186-.128-.4-.258v-1.35a1.5 1.5 0 0 0 1-1.415v-2a1.5 1.5 0 0 0-3 0v2a1.5 1.5 0 0 0 1 1.415v.8a12.065 12.065 0 0 0-3.009-1V26.01a.5.5 0 0 0 .468-.868l-2.671-2a.5.5 0 0 0-.6 0l-2.671 2A.5.5 0 0 0 6 26.01v1.606a12.066 12.066 0 0 0-3.009 1v-.8A1.5 1.5 0 0 0 4 26.4v-2a1.5 1.5 0 1 0-3 0v2a1.5 1.5 0 0 0 1 1.415v1.35q-.209.13-.4.258-.543-.037-1.1-.038a.5.5 0 0 0-.5.5V37.9a.5.5 0 0 0 .5.5h16.024a.5.5 0 0 0 .5-.5v-8.016a.5.5 0 0 0-.5-.499zm-.5 8.013h-2.253a11 11 0 0 0-1.816-3.028 12.807 12.807 0 0 0-2.48-2.26 14.967 14.967 0 0 1 6.55-1.72zm-3.335 0H7.632a7.556 7.556 0 0 0-2.569-3.49A7.524 7.524 0 0 0 1 32.406v-2.015c5.242.168 9.9 2.971 11.693 7.007zm-8.358 0H1v-3.992A6.6 6.6 0 0 1 6.564 37.4H4.332zm9.686-13a.5.5 0 1 1 1.006 0v2a.5.5 0 1 1-1.006 0zm-7.011.894l1.5-1.128 1.5 1.128v2.176A13.2 13.2 0 0 0 9 27.394v-.749a.5.5 0 0 0-1 0v.749c-.347.013-.682.038-1.006.074zM2 24.4a.5.5 0 1 1 1 0v2a.5.5 0 1 1-1 0zm6.512 3.984a11.459 11.459 0 0 1 5.272 1.229 15.351 15.351 0 0 0-5.272 1.884 15.351 15.351 0 0 0-5.272-1.884 11.459 11.459 0 0 1 5.271-1.234z" transform="translate(.15 -22.745)" />
                </svg>Дома</a></li>
            <?endif;?>
       			<?if($urlNoDom): // убираем у цены, если дома?>
              <li class="nav-item"><a class="nav-link btn <?=($posNoDom)?'btn-success':'btn-outline-secondary';?> rounded-pill" href="<?=htmlspecialcharsbx($urlNoDom)?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16.523" height="16.523" viewBox="0 0 16.523 16.523" class="inline-svg">
                  <path d="M16.523 1.614v13.3a1.615 1.615 0 0 1-1.614 1.614h-1.57a.645.645 0 1 1 0-1.291h1.571a.323.323 0 0 0 .323-.323V8.939h-5.7a.645.645 0 0 1 0-1.291h5.7V1.614a.323.323 0 0 0-.323-.323H7.618v1.893a.645.645 0 0 1-1.291 0V1.291H1.614a.323.323 0 0 0-.323.323v6h5.036V5.723a.645.645 0 0 1 1.291 0V10.8a.645.645 0 1 1-1.291 0V8.907H1.291v6a.323.323 0 0 0 .323.323h4.713v-1.891a.645.645 0 0 1 1.291 0v1.893H10.8a.645.645 0 1 1 0 1.291H1.614A1.615 1.615 0 0 1 0 14.909V1.614A1.615 1.615 0 0 1 1.614 0h13.3a1.615 1.615 0 0 1 1.609 1.614zm0 0" />
                </svg>Участки</a></li>
            <?endif;?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="page__content-tag-list">
    <div class="container">
      <div class="d-block d-md-none">
        <div class="btn btn-outline-warning w-100 rounded-pill" data-target="open-tags">
          <strong>Уточнить поиск</strong>
        </div>
      </div>
      <div class="align-items-end my-40 row">
        <div class="col-lg">
          <?require_once $_SERVER["DOCUMENT_ROOT"].'/poselki/seo-tegi.php';?>
        </div>
        <div class="col-lg-auto">
          <div class="page__sort">
            <div class="text-secondary">Сортировать:</div>
            <div class="ml-2">
              <select class="select-success select-bold hover-white" id="sortinng">
                <option value="sort" <?if($_REQUEST['sort'] == 'sort')echo 'selected'?>>По релевантности</option>
                <option value="rating" <?if($_REQUEST['sort'] == 'rating')echo 'selected'?>>По рейтингу</option>
                <option value="cost_ask" <?if($_REQUEST['sort'] == 'cost_ask')echo 'selected'?>>Сначала дешевле</option>
                <option value="cost_desc" <?if($_REQUEST['sort'] == 'cost_desc')echo 'selected'?>>Сначала дороже</option>
                <option value="mkad" <?if($_REQUEST['sort'] == 'mkad')echo 'selected'?>>Удаленность от МКАД</option>
              </select>
            </div>
          </div>
        </div>
      </div>


    </div>
  </div>

  <?if(!$posNoDom && !$posWithDom): // показываем Все ?>
		<?$APPLICATION->IncludeComponent(
    	"bitrix:main.include", "",
    	array(
    		"AREA_FILE_SHOW" => "file",
    		"AREA_FILE_SUFFIX" => "inc",
    		"EDIT_TEMPLATE" => "",
    		"PATH" => "/include/section_cards.php",
    	),
    	false
    );?>
	<?endif;?>
	<?if($posNoDom): // показываем Участки ?>
		<?$arrFilter['=PROPERTY_2'] = [3,256]; // показывать только участки и дома и участки ?>
		<?$APPLICATION->IncludeComponent(
    	"bitrix:main.include", "",
    	array(
    		"AREA_FILE_SHOW" => "file",
    		"AREA_FILE_SUFFIX" => "inc",
    		"EDIT_TEMPLATE" => "",
    		"PATH" => "/include/section_cards.php",
    	),
    	false
    );?>
		<?unset($arrFilter['=PROPERTY_2']); // сбрасываем ?>
	<?endif;?>
	<?if($posWithDom): // показываем Дома ?>
		<?$arrFilter['=PROPERTY_2'] = [4,256]; // показывать дома и дома и участки ?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:main.include", "",
			Array(
				"AREA_FILE_SHOW" => "file",
				"AREA_FILE_SUFFIX" => "inc",
				"EDIT_TEMPLATE" => "",
				"PATH" => "/include/section_cards.php"
			)
		);?>
		<?unset($arrFilter['=PROPERTY_2']); // сбрасываем ?>
	<?endif;?>
  <div class="bg-white page__map-wrapper">
    <div class="container">
      <div class="map-link__full d-flex justify-content-center flex-wrap">
        <div class="map-link__full-title">
          <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="31.844" height="45.466" viewBox="0 0 31.844 45.466" class="inline-svg">
              <path d="M35.385,4.664a15.922,15.922,0,0,0-22.519,0C7.3,10.229,6.61,20.7,11.369,27.043L24.126,45.466l12.738-18.4A17.294,17.294,0,0,0,40.046,16.7,17.169,17.169,0,0,0,35.385,4.664ZM24.273,21.589a5.812,5.812,0,1,1,5.812-5.812A5.82,5.82,0,0,1,24.273,21.589Z" transform="translate(-8.203)" />
            </svg></div>
          <div class="h1">Поиск по карте</div>
        </div><a class="btn btn-success rounded-pill" href="<?=$ourDir?>map/">Посмотреть на карте</a>
      </div>
    </div>
  </div>
  <div class="block-page">
    <div class="container">
      <div class="block-page__title block-page__title--icon">
        <div class="icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="23.751" height="21.602" viewBox="0 0 23.751 21.602" class="inline-svg">
            <g transform="translate(225.776 -396.448)" opacity="0.5">
              <path d="M19.67,2.7c3.766,0,5.306-2.859,5.306-5.443a4.968,4.968,0,0,0-5.2-5.031,5.131,5.131,0,0,0-5.388,5.443A5.093,5.093,0,0,0,19.67,2.7Zm.137-1.237c-1.539,0-2.419-2.172-2.419-4.151,0-2.089.6-3.849,2.2-3.849,1.649,0,2.392,2.172,2.392,4.151C21.979-.3,21.374,1.461,19.807,1.461ZM9.663,2.808c.137-.027.165-.082.275-.33l8.055-20.04a3.975,3.975,0,0,0,.3-.825c0-.082-.082-.165-.275-.165-.715,0-5.965.632-11.243.632a5.27,5.27,0,0,0-5.553,5.443,5,5,0,0,0,5.2,5.058,5.223,5.223,0,0,0,5.388-5.443,4.945,4.945,0,0,0-1.512-3.6v-.055c.825-.082,4.069-.3,5.8-.412-.247.577-5.828,13.608-8.494,19.655-.137.33,0,.357.3.3ZM6.64-8.656c-1.622,0-2.392-2.2-2.392-4.178,0-2.034.66-3.849,2.227-3.849,1.512,0,2.337,1.814,2.337,4.178C8.811-10.36,8.234-8.656,6.64-8.656Z" transform="translate(-227 415)" fill="#919fa3" />
            </g>
          </svg>
        </div>
        <h2>Спецпредложения</h2>
      </div>
      <div class="block-page__offer" id="special_offers">
        <? // если была фильтрация по шоссе и районам
    		if ($arrFilter["=PROPERTY_4"]) $addFilter["=PROPERTY_4"] = $arrFilter["=PROPERTY_4"];
    		if ($arrFilter["=PROPERTY_5"]) $addFilter["=PROPERTY_5"] = $arrFilter["=PROPERTY_5"];
    		$arrFilter=array('!PROPERTY_ACTION'=>false); // показывать только акции
    		if ($addFilter) array_push($arrFilter,$addFilter); //dump($arrFilter);?>
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

  <div class="bg-white seo-text">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <?if(!$pagen){
  					echo $h2.$SEO_text;
  				}?>
        </div>
      </div>
    </div>
  </div>

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
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
