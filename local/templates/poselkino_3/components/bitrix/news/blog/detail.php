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

use Bitrix\Main\Page\Asset;
 // Яндекс.Поделиться
 Asset::getInstance()->addJs("//yastatic.net/es5-shims/0.0.2/es5-shims.min.js");
 Asset::getInstance()->addJs("//yastatic.net/share2/share.js");
?>
<div class="container mt-3 mt-md-5 mb-0 mb-md-5">
	<div class="row">
	  <div class="offset-xl-2 col-xl-8 offset-md-1 col-md-10">
	    <div class="bg-white py-4 py-md-5 shadow-contet">
	      <div class="row">
	        <div class="offset-1 col-10">
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
	          <div class="d-block d-sm-none">
	            <a class="back" href="/blog/">
	              <svg xmlns="http://www.w3.org/2000/svg" width="15.174" height="9.415" viewBox="0 0 15.174 9.415" class="inline-svg">
	                <g transform="translate(0 -75.914)">
	                  <path d="M14.517,79.964H2.243l2.929-2.929a.657.657,0,1,0-.929-.929l-4.05,4.05a.657.657,0,0,0,0,.929l4.05,4.051a.657.657,0,1,0,.929-.929L2.243,81.278H14.517a.657.657,0,1,0,0-1.314Z" transform="translate(0 0)" fill="#3c4b5a" />
	                </g>
	              </svg>Вернуться назад</a>
	          </div>
						<?$ElementID = $APPLICATION->IncludeComponent(
							"bitrix:news.detail",
							"blog",
							Array(
								"DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
								"DISPLAY_NAME" => $arParams["DISPLAY_NAME"],
								"DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
								"DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
								"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
								"IBLOCK_ID" => $arParams["IBLOCK_ID"],
								"FIELD_CODE" => $arParams["DETAIL_FIELD_CODE"],
								"PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
								"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
								"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
								"META_KEYWORDS" => $arParams["META_KEYWORDS"],
								"META_DESCRIPTION" => $arParams["META_DESCRIPTION"],
								"BROWSER_TITLE" => $arParams["BROWSER_TITLE"],
								"SET_CANONICAL_URL" => $arParams["DETAIL_SET_CANONICAL_URL"],
								"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
								"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
								"SET_TITLE" => "Y",
								"MESSAGE_404" => $arParams["MESSAGE_404"],
								"SET_STATUS_404" => $arParams["SET_STATUS_404"],
								"SHOW_404" => $arParams["SHOW_404"],
								"FILE_404" => $arParams["FILE_404"],
								"INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
								"ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
								"ACTIVE_DATE_FORMAT" => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
								"CACHE_TYPE" => $arParams["CACHE_TYPE"],
								"CACHE_TIME" => $arParams["CACHE_TIME"],
								"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
								"USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
								"GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
								"DISPLAY_TOP_PAGER" => $arParams["DETAIL_DISPLAY_TOP_PAGER"],
								"DISPLAY_BOTTOM_PAGER" => $arParams["DETAIL_DISPLAY_BOTTOM_PAGER"],
								"PAGER_TITLE" => $arParams["DETAIL_PAGER_TITLE"],
								"PAGER_SHOW_ALWAYS" => "N",
								"PAGER_TEMPLATE" => $arParams["DETAIL_PAGER_TEMPLATE"],
								"PAGER_SHOW_ALL" => $arParams["DETAIL_PAGER_SHOW_ALL"],
								"CHECK_DATES" => $arParams["CHECK_DATES"],
								"ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
								"ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
								"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
								"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
								"IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
								"SEARCH_PAGE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["search"],
								"USE_SHARE" => $arParams["USE_SHARE"],
								"SHARE_HIDE" => $arParams["SHARE_HIDE"],
								"SHARE_TEMPLATE" => $arParams["SHARE_TEMPLATE"],
								"SHARE_HANDLERS" => $arParams["SHARE_HANDLERS"],
								"SHARE_SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
								"SHARE_SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
								"ADD_ELEMENT_CHAIN" => (isset($arParams["ADD_ELEMENT_CHAIN"]) ? $arParams["ADD_ELEMENT_CHAIN"] : ''),
								"USE_RATING" => $arParams["USE_RATING"],
								"MAX_VOTE" => $arParams["MAX_VOTE"],
								"VOTE_NAMES" => $arParams["VOTE_NAMES"],
								"MEDIA_PROPERTY" => $arParams["MEDIA_PROPERTY"],
								"SLIDER_PROPERTY" => $arParams["SLIDER_PROPERTY"],
								"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
								"STRICT_SECTION_CHECK" => $arParams["STRICT_SECTION_CHECK"],
							),
							$component
						);?>
					</div>
				</div>
			</div>
			<div class="content__tag-line">
				<span>#</span>
				<? /* получим все разделы */
        $dbGroups = CIBlockElement::GetElementGroups($ElementID,true,["NAME","CODE"]);
        while($arGroups = $dbGroups->Fetch())
        	$GROUPS[] = $arGroups;

        foreach($GROUPS as $label){?>
					<a href="/blog/?tag=<?=$label["CODE"]?>"><?=$label["NAME"]?></a>
				<?}?>
			</div>
		</div>
	</div>
</div>

<div class="feedback-sale-form blog__feedback">
    <div class="container">
        <div class="feedback-form">
            <div class="feedback-form__title pt-0 text-center text-lg-left">
                <h2><?$APPLICATION->ShowViewContent('blog_feedback__name');?></h2>
                <!-- <p>Подпишитесь на обновление цены участков</p> -->
            </div>
            <div class="feedback-form__body">
                <form class="formSignToView" data-formID="blog_poselkino">
                    <div class="row">
                        <div class="col-lg-4 d-none d-lg-block">
                            <div class="form-group">
                                <input class="form-control nameSignToView" id="form-sale-name" type="text" name="form-sale-name" placeholder="Ваше имя" required>
                            </div>
                        </div>
                        <div class="col-lg-4 d-none d-lg-block">
                            <div class="form-group">
                                <input class="form-control phone telSignToView" id="form-sale-phone" type="text" name="form-sale-name" placeholder="Номер телефона" autocomplete="off" required inputmode="text">
                            </div>
                        </div>
                        <div class="col-lg-4 text-center">
                            <button class="btn btn-warning rounded-pill btn-submit d-none d-lg-inline" type="submit"><?$APPLICATION->ShowViewContent('blog_feedback__btn');?></button>
                            <button class="btn btn-warning rounded-pill btn-submit d-inline d-lg-none" type="button" data-toggle="modal" data-target="#modalFeedbackSale"><?$APPLICATION->ShowViewContent('blog_feedback__btn');?></button>
                        </div>
                        <div class="col-lg-12 d-none d-lg-block">
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input class="custom-control-input" id="form-sale-policy" type="checkbox" name="form-sale-policy" checked="checked" required>
                                <label class="custom-control-label" for="form-sale-policy">
                                    Нажимая на кнопку, вы даете согласие на обработку персональных данных и соглашаетесь с&nbsp;
                                    <a href="/politika-konfidentsialnosti/" class="font-weight-bold" onclick="window.open('/politika-konfidentsialnosti/', '_blank'); return false;" title="Ознакомиться с политикой конфиденциальности">Политикой Конфиденциальности</a>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFeedbackSale" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-light">
            <div class="modal-header">
                <div class="d-flex w-100 justify-content-between align-items-center">
                    <h5 class="text-uppercase" id="writeToUsLabel">Подписаться на обновление цены участков</h5>
                    <button class="close btn-sm" type="button" data-dismiss="modal" aria-label="Close">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.0044 14.8471C15.3949 14.4566 15.3949 13.8235 15.0044 13.4329L9.34785 7.77641L15.0045 2.11975C15.395 1.72923 15.395 1.09606 15.0045 0.705538C14.614 0.315014 13.9808 0.315014 13.5903 0.705538L7.93364 6.3622L2.27644 0.705003C1.88592 0.314478 1.25275 0.314478 0.862229 0.705003C0.471705 1.09553 0.471705 1.72869 0.862229 2.11922L6.51942 7.77641L0.862379 13.4335C0.471855 13.824 0.471855 14.4571 0.862379 14.8477C1.2529 15.2382 1.88607 15.2382 2.27659 14.8477L7.93364 9.19063L13.5901 14.8471C13.9807 15.2377 14.6138 15.2377 15.0044 14.8471Z" fill="#808080"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <form class="formSignToView" data-formID="blog_poselkino">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <input class="form-control nameSignToView" id="form-sale-name" type="text" name="form-sale-name" placeholder="Ваше имя" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <input class="form-control phone telSignToView" id="form-sale-phone" type="text" name="form-sale-name" placeholder="Номер телефона" autocomplete="off" required inputmode="text">
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-warning rounded-pill btn-submit w-100" type="submit">Подписаться</button>
                        </div>
                        <div class="col-12">
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input class="custom-control-input" id="form-sale-policy" type="checkbox" name="form-sale-policy" checked="checked" required>
                                <label class="custom-control-label" for="form-sale-policy">
                                    Нажимая на кнопку, вы даете согласие на обработку персональных данных и соглашаетесь с&nbsp;
                                    <a href="/politika-konfidentsialnosti/" class="font-weight-bold" onclick="window.open('/politika-konfidentsialnosti/', '_blank'); return false;" title="Ознакомиться с политикой конфиденциальности">Политикой Конфиденциальности</a>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?global $otherFilter;
$otherFilter = [
	"!ID" => $ElementID // не показывать имеющийся
];?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"blog_other",
	Array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"NEWS_COUNT" => $arParams["NEWS_COUNT"],

		"SORT_BY1" => $arParams["SORT_BY1"],
		"SORT_ORDER1" => $arParams["SORT_ORDER1"],
		"SORT_BY2" => $arParams["SORT_BY2"],
		"SORT_ORDER2" => $arParams["SORT_ORDER2"],

		"FILTER_NAME" => "otherFilter", //$arParams["FILTER_NAME"],
		"FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
		"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
		"CHECK_DATES" => $arParams["CHECK_DATES"],
		"STRICT_SECTION_CHECK" => $arParams["STRICT_SECTION_CHECK"],
		"IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
		"SEARCH_PAGE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["search"],

		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_FILTER" => $arParams["CACHE_FILTER"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],

		"PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
		"ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"MESSAGE_404" => $arParams["MESSAGE_404"],
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"SHOW_404" => $arParams["SHOW_404"],
		"FILE_404" => $arParams["FILE_404"],
		"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
		"INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
		"ADD_SECTIONS_CHAIN" => "N", //$arParams["ADD_SECTIONS_CHAIN"],
		"HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],

		"PARENT_SECTION" => $arResult["VARIABLES"]["SECTION_ID"],
		"PARENT_SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"INCLUDE_SUBSECTIONS" => "Y",

		"DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
		"DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
		"MEDIA_PROPERTY" => $arParams["MEDIA_PROPERTY"],
		"SLIDER_PROPERTY" => $arParams["SLIDER_PROPERTY"],

		"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
		"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
		"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
		"PAGER_TITLE" => $arParams["PAGER_TITLE"],
		"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
		"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
		"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
		"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
		"PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
		"PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
		"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],

		"USE_RATING" => $arParams["USE_RATING"],
		"DISPLAY_AS_RATING" => $arParams["DISPLAY_AS_RATING"],
		"MAX_VOTE" => $arParams["MAX_VOTE"],
		"VOTE_NAMES" => $arParams["VOTE_NAMES"],

		"USE_SHARE" => $arParams["LIST_USE_SHARE"],
		"SHARE_HIDE" => $arParams["SHARE_HIDE"],
		"SHARE_TEMPLATE" => $arParams["SHARE_TEMPLATE"],
		"SHARE_HANDLERS" => $arParams["SHARE_HANDLERS"],
		"SHARE_SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
		"SHARE_SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],

		"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
	),
	$component
);?>
<?if($arParams["USE_CATEGORIES"]=="Y" && $ElementID):
	global $arCategoryFilter;
	$obCache = new CPHPCache;
	$strCacheID = $componentPath.LANG.$arParams["IBLOCK_ID"].$ElementID.$arParams["CATEGORY_CODE"];
	if(($tzOffset = CTimeZone::GetOffset()) <> 0)
		$strCacheID .= "_".$tzOffset;
	if($arParams["CACHE_TYPE"] == "N" || $arParams["CACHE_TYPE"] == "A" && COption::GetOptionString("main", "component_cache_on", "Y") == "N")
		$CACHE_TIME = 0;
	else
		$CACHE_TIME = $arParams["CACHE_TIME"];
	if($obCache->StartDataCache($CACHE_TIME, $strCacheID, $componentPath))
	{
		$rsProperties = CIBlockElement::GetProperty($arParams["IBLOCK_ID"], $ElementID, "sort", "asc", array("ACTIVE"=>"Y","CODE"=>$arParams["CATEGORY_CODE"]));
		$arCategoryFilter = array();
		while($arProperty = $rsProperties->Fetch())
		{
			if(is_array($arProperty["VALUE"]) && count($arProperty["VALUE"])>0)
			{
				foreach($arProperty["VALUE"] as $value)
					$arCategoryFilter[$value]=true;
			}
			elseif(!is_array($arProperty["VALUE"]) && strlen($arProperty["VALUE"])>0)
				$arCategoryFilter[$arProperty["VALUE"]]=true;
		}
		$obCache->EndDataCache($arCategoryFilter);
	}
	else
	{
		$arCategoryFilter = $obCache->GetVars();
	}
	if(count($arCategoryFilter)>0):
		$arCategoryFilter = array(
			"PROPERTY_".$arParams["CATEGORY_CODE"] => array_keys($arCategoryFilter),
			"!"."ID" => $ElementID,
		);
		?>
		<hr /><h3><?=GetMessage("CATEGORIES")?></h3>
		<?foreach($arParams["CATEGORY_IBLOCK"] as $iblock_id):?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:news.list",
				$arParams["CATEGORY_THEME_".$iblock_id],
				Array(
					"IBLOCK_ID" => $iblock_id,
					"NEWS_COUNT" => $arParams["CATEGORY_ITEMS_COUNT"],
					"SET_TITLE" => "N",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"FILTER_NAME" => "arCategoryFilter",
					"CACHE_FILTER" => "Y",
					"DISPLAY_TOP_PAGER" => "N",
					"DISPLAY_BOTTOM_PAGER" => "N",
				),
				$component
			);?>
		<?endforeach?>
	<?endif?>
<?endif?>
