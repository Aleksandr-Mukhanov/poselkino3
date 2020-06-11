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
// dump($arResult);
?>
			<div class="col-12 pl-lg-0">
				<ul class="nav flex blog-navigation">
					<li class="nav-item mt-3 mt-lg-0"><a class="btn <?=(CSite::InDir('/blog/index.php')) ? 'btn-warning' : 'btn-outline-secondary';?> rounded-pill px-5 ml-xl-3 ml-lg-2 ml-0 mr-2" href="/blog/" title="Все">Все</a></li>
					<?foreach($arResult["LABELS"] as $label){?>
						<?$active = (CSite::InDir($label["SECTION_PAGE_URL"])) ? 'btn-warning' : 'btn-outline-secondary';?>
						<li class="nav-item mt-3 mt-lg-0"><a class="btn <?=$active?> rounded-pill px-5 ml-xl-3 ml-lg-2 ml-0 mr-2" href="<?=$label["SECTION_PAGE_URL"]?>" title="<?=$label["NAME"]?>"><?=$label["NAME"]?></a></li>
					<?}?>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="bg-gray py-2 py-md-5">
	<div class="container">
		<div class="row blog-list">
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
			<div class="col-xl-3 col-md-4 col-sm-6" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<a class="article-card blog-item" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
					<div class="article-card__img" style="background: #eee url(<?=$arItem['PREVIEW_PICTURE']['SRC']?>); background-size: cover; background-position: center center;"></div>
					<div class="article-card__content">
						<div class="article-card__title"><?=$arItem["NAME"]?></div>
						<div class="article-card__text"><?=$arItem["PREVIEW_TEXT"];?></div>
					</div>
					<div class="article-card__footer">
						<div class="article-card__date"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></div>
						<div class="article-card__share">
							<svg xmlns="http://www.w3.org/2000/svg" width="10.838" height="10.931" viewBox="0 0 10.838 10.931" class="inline-svg">
								<g transform="translate(-2.006)" opacity="0.5">
									<g transform="translate(2.006)">
										<path d="M10.851,6.947A1.979,1.979,0,0,0,9.3,7.711L5.913,5.981a1.979,1.979,0,0,0,.076-.515A1.963,1.963,0,0,0,5.9,4.907L9.266,3.185a1.983,1.983,0,1,0-.405-1.194,1.97,1.97,0,0,0,.077.517L5.555,4.238a1.99,1.99,0,1,0,.029,2.419L8.951,8.379a1.967,1.967,0,0,0-.091.56,1.992,1.992,0,1,0,1.992-1.992Z" transform="translate(-2.006)" fill="#919fa3" />
									</g>
								</g>
							</svg>
							<?=($arItem["SHOW_COUNTER"]) ? $arItem["SHOW_COUNTER"] : 0?>
						</div>
					</div>
				</a>
			</div>
		<?endforeach;?>
		</div>
	</div>
	<div class="container mt-5">
		<div class="page__pagination">
			<div class="container">
				<nav aria-label="Постраничная навигация">
					<?=$arResult["NAV_STRING"]?>
				</nav>
			</div>
		</div>
	</div>
