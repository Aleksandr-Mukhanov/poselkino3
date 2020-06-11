<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Избранное");
if(isset($_COOKIE['favorites_vil'])){
	$arFavorites = explode('-',$_COOKIE['favorites_vil']); // dump($arFavorites);
}
$h1 = ($arFavorites) ? 'Посёлки в избранном' : 'Нет поселков в избранном!';?>
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
	<div class="page__content-title">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-xl-7 col-lg-6">
          <h1 class="h2"><?=$h1?> <span class="text-secondary"><?$APPLICATION->ShowViewContent('COUNT_POS');?></span></h1>
        </div>
			</div>
		</div>
	</div>
	<?if ($arFavorites) {
		$arrFilter=array('ID'=>$arFavorites); // показывать только избранные
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
	<?}?>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
