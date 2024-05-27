<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Избранное");

$activeBtnVil = 'btn-success';
$activeBtnPlots = 'btn-outline-secondary';

if (isset($_COOKIE['favorites_vil'])) {
	$arFavoritesVil = explode('-',$_COOKIE['favorites_vil']);
}

if (isset($_COOKIE['favorites_plots'])) {
	$arFavoritesPlots = explode('-',$_COOKIE['favorites_plots']);
	if (!$arFavoritesVil) {
		$activeBtnPlots = 'btn-success';
		$activeBtnVil = 'btn-outline-secondary';
	}
}

$h1 = ($arFavoritesVil) ? 'Посёлки в избранном' : 'Нет поселков в избранном!';
$h1Plots = ($arFavoritesPlots) ? 'Участки в избранном' : 'Нет участков в избранном!';
$h1House = ($arFavoritesPlots) ? 'Дома в избранном' : 'Нет домов в избранном!';
// $h1 = 'Избранное';
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.chooseFav .nav-link').on('click', function() {
			$('.card-photo__list').slick('resize');
		});
	})
</script>
<main class="page page-search">
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
            <div class="page__sort mr-lg-3 mr-auto">
              <div class="text-secondary">Сортировать:</div>
              <div class="ml-4">
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
	</div>
	<div class="page__content-title mb-4">
    <div class="container">
      <!-- <div class="row align-items-center">
        <div class="col-xl-7 col-lg-6">
          <h1 class="h2"><?=$h1?> <span class="text-secondary"><?$APPLICATION->ShowViewContent('COUNT_POS');?></span></h1>
        </div>
			</div> -->
			<div class="row">
				<div class="col-md-12 filter__tab">
					<?//if($USER->IsAdmin()):?>
						<ul class="nav mt-lg-0 mt-2 chooseFav">
							<li class="nav-item">
								<a class="nav-link btn rounded-pill <?=$activeBtnVil?>" href="#favorites_villages">Поселки</a>
							</li>
							<li class="nav-item">
								<a class="nav-link btn rounded-pill <?=$activeBtnPlots?>" href="#favorites_plots">
									<svg xmlns="http://www.w3.org/2000/svg" width="16.523" height="16.523" viewBox="0 0 16.523 16.523" class="inline-svg">
										<path d="M16.523 1.614v13.3a1.615 1.615 0 0 1-1.614 1.614h-1.57a.645.645 0 1 1 0-1.291h1.571a.323.323 0 0 0 .323-.323V8.939h-5.7a.645.645 0 0 1 0-1.291h5.7V1.614a.323.323 0 0 0-.323-.323H7.618v1.893a.645.645 0 0 1-1.291 0V1.291H1.614a.323.323 0 0 0-.323.323v6h5.036V5.723a.645.645 0 0 1 1.291 0V10.8a.645.645 0 1 1-1.291 0V8.907H1.291v6a.323.323 0 0 0 .323.323h4.713v-1.891a.645.645 0 0 1 1.291 0v1.893H10.8a.645.645 0 1 1 0 1.291H1.614A1.615 1.615 0 0 1 0 14.909V1.614A1.615 1.615 0 0 1 1.614 0h13.3a1.615 1.615 0 0 1 1.609 1.614zm0 0"/>
									</svg>
									Участки
								</a>
							</li>
						</ul>
					<?//endif;?>
				</div>
			</div>
		</div>
	</div>
	<div class="block_favorites">
		<div id="favorites_villages" class="<?=(!$arFavoritesVil && $arFavoritesPlots)?'hide':''?>">
			<div class="container">
	      <div class="row align-items-center">
	        <div class="col-xl-7 col-lg-6">
	          <h1 class="h2"><?=$h1?> <span class="text-secondary"><?$APPLICATION->ShowViewContent('COUNT_POS');?></span></h1>
	        </div>
				</div>
			</div>
			<?if ($arFavoritesVil) {
				$arrFilter = array('ID'=>$arFavoritesVil); // показывать только избранные
			?>
				<?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					Array(
						"AREA_FILE_SHOW" => "file",
						"AREA_FILE_SUFFIX" => "inc",
						"EDIT_TEMPLATE" => "",
						"PATH" => "/include/section_cards.php"
					)
				);?>
			<?}else{?>
				<div class="container">
					<p>Поселков нет в избранном!</p>
				</div>
			<?}?>
		</div>
		<div id="favorites_plots" class="<?=(!$arFavoritesPlots || $arFavoritesVil)?'hide':''?>">
			<div class="container">
	      <div class="row align-items-center">
	        <div class="col-xl-7 col-lg-6">
	          <h1 class="h2"><?=$h1Plots?> <span class="text-secondary"><?$APPLICATION->ShowViewContent('COUNT_PLOTS');?></span></h1>
	        </div>
				</div>
			</div>
			<?if ($arFavoritesPlots) {
				global $arrFilterPlots;
				$arrFilterPlots = ['ID'=>$arFavoritesPlots]; // показывать только избранные
			?>
				<?$APPLICATION->IncludeComponent(
					"bitrix:news.list",
					"plots",
					array(
						"ACTIVE_DATE_FORMAT" => "d.m.Y",
						"ADD_SECTIONS_CHAIN" => "N",
						"AJAX_MODE" => "N",
						"AJAX_OPTION_ADDITIONAL" => "",
						"AJAX_OPTION_HISTORY" => "N",
						"AJAX_OPTION_JUMP" => "N",
						"AJAX_OPTION_STYLE" => "Y",
						"CACHE_FILTER" => "Y",
						"CACHE_GROUPS" => "N",
						"CACHE_TIME" => "36000000",
						"CACHE_TYPE" => "A",
						"CHECK_DATES" => "Y",
						"DETAIL_URL" => "",
						"DISPLAY_BOTTOM_PAGER" => "N",
						"DISPLAY_DATE" => "N",
						"DISPLAY_NAME" => "Y",
						"DISPLAY_PICTURE" => "Y",
						"DISPLAY_PREVIEW_TEXT" => "Y",
						"DISPLAY_TOP_PAGER" => "N",
						"FIELD_CODE" => array(
							0 => "",
							1 => "",
						),
						"FILTER_NAME" => "arrFilterPlots", // фильтр акционных участков
						"HIDE_LINK_WHEN_NO_DETAIL" => "N",
						"IBLOCK_ID" => "5",
						"IBLOCK_TYPE" => "content",
						"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
						"INCLUDE_SUBSECTIONS" => "N",
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
						"PREVIEW_TRUNCATE_LEN" => "",
						"PROPERTY_CODE" => array(
							0 => "NUMBER",
							1 => "",
						),
						"SET_BROWSER_TITLE" => "N",
						"SET_LAST_MODIFIED" => "N",
						"SET_META_DESCRIPTION" => "N",
						"SET_META_KEYWORDS" => "N",
						"SET_STATUS_404" => "N",
						"SET_TITLE" => "N",
						"SHOW_404" => "N",
						"SORT_BY1" => "ACTIVE_FROM",
						"SORT_BY2" => "SORT",
						"SORT_ORDER1" => "DESC",
						"SORT_ORDER2" => "ASC",
						"STRICT_SECTION_CHECK" => "N",
						"COMPONENT_TEMPLATE" => "plots"
					),
					false
				);?>
			<?}else{?>
				<div class="container">
					<p>Участков нет в избранном!</p>
				</div>
			<?}?>
		</div>
	</div>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
