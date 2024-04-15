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
CUtil::InitJSCore(array('fx'));
// dump($arResult['PROPERTIES']);
?>
<div class="content" id="<?=$this->GetEditAreaId($arResult['ID'])?>">
  <div class="content__title">
    <h1 class="mt-3 mt-sm-5"><?=$arResult["NAME"]?></h1>
		<span class="date"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span>
  </div>
  <div class="content__body">
    <div class="content__img">
      <img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arResult["NAME"]?>">
    </div>
		<?=$arResult["DETAIL_TEXT"]?>
    <?if($USER->IsAuthorized()){?>

    <?}?>

    <?if($USER->IsAuthorized()){?>
    <?if($arResult['PROPERTIES']['QUOTE']['VALUE']):?>
      <blockquote>
        <svg width="29" height="20" viewBox="0 0 29 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M5.32749 13.0504C4.70938 14.6102 3.73237 16.1543 2.424 17.6405C2.00764 18.1134 1.95479 18.7885 2.29257 19.3202C2.55268 19.7292 2.99017 19.9622 3.45341 19.9622C3.58393 19.9622 3.71674 19.9438 3.84772 19.9057C6.6207 19.0955 13.089 16.2177 13.2627 7.01918C13.3298 3.46724 10.7319 0.415777 7.3491 0.0720216C5.48466 -0.114567 3.61931 0.491137 2.23696 1.74068C0.852772 2.9916 0.0586548 4.77744 0.0586548 6.64095C0.0586548 9.74987 2.26545 12.4686 5.32749 13.0504ZM3.49891 3.13727C4.37804 2.34269 5.48466 1.91944 6.65792 1.91944C6.82382 1.91944 6.9911 1.92771 7.15884 1.94517C9.57474 2.19011 11.4291 4.40335 11.3803 6.98332C11.2604 13.3482 7.81417 16.2136 4.96031 17.4953C5.86334 16.2738 6.5729 15.0173 7.0775 13.7439C7.27418 13.248 7.24156 12.6938 6.98834 12.2232C6.72317 11.7296 6.25029 11.3795 5.69193 11.2623C3.51821 10.8078 1.94101 8.86383 1.94101 6.64094C1.94101 5.30915 2.50902 4.03204 3.49891 3.13727Z" fill="#78A86D"/>
          <path d="M17.3234 19.3201C17.5835 19.7291 18.021 19.9621 18.4842 19.9621C18.6147 19.9621 18.7471 19.9437 18.8785 19.9056C21.6515 19.0954 28.1193 16.2176 28.293 7.01911C28.3592 3.46717 25.7618 0.415701 22.3785 0.0719556C20.5118 -0.117842 18.6496 0.49061 17.2673 1.74061C15.8831 2.99153 15.089 4.77738 15.089 6.64089C15.089 9.7498 17.2958 12.4685 20.3574 13.0504C19.7388 14.6115 18.7618 16.1556 17.4539 17.6409C17.0375 18.1142 16.9851 18.7889 17.3234 19.3201ZM22.1074 13.7447C22.304 13.2489 22.2719 12.6947 22.0191 12.2241C21.7535 11.73 21.2811 11.3799 20.7222 11.2622C18.5485 10.8077 16.9713 8.86378 16.9713 6.64089C16.9713 5.30862 17.5393 4.03197 18.5292 3.13721C19.4079 2.34263 20.5145 1.91937 21.6882 1.91937C21.8537 1.91937 22.021 1.92764 22.1892 1.9451C24.6046 2.19005 26.4594 4.40329 26.4107 6.98325C26.2912 13.3486 22.8445 16.2135 19.9906 17.4952C20.8932 16.2746 21.6018 15.0182 22.1074 13.7447Z" fill="#78A86D"/>
        </svg>
        <body>
          <h3><?=$arResult['PROPERTIES']['QUOTE']['VALUE']?></h3>
        </body>
      </blockquote>
    <?endif;?>
    <?if($arResult['PROPERTIES']['QUOTE_PHOTO']['VALUE']):?>
      <blockquote>
        <header>
          <div class="user-info">
            <?if($arResult['PROPERTIES']['USER_PHOTO']['VALUE']):?>
              <div class="user-avatar">
                <img src="<?=CFile::GetPath($arResult['PROPERTIES']['USER_PHOTO']['VALUE'])?>" alt="avatar">
              </div>
            <?endif;?>
            <?if($arResult['PROPERTIES']['USER_NAME']['VALUE']):?>
              <div class="user">
                <div class="user-name"><?=$arResult['PROPERTIES']['USER_NAME']['VALUE']?></div>
                <div class="user-info"><?=$arResult['PROPERTIES']['USER_INFO']['VALUE']?></div>
              </div>
            <?endif;?>
          </div>
        </header>
        <body>
          <p>
            <b>Сферы интересов:</b> <?=$arResult['PROPERTIES']['QUOTE_PHOTO']['VALUE']?>
          </p>
        </body>
      </blockquote>
    <?endif;?>
    <?if($arResult['PROPERTIES']['FAQ_QUESTION']['VALUE']):?>
      <div class="faq">
        <div class="faq-question">
          <svg width="28" height="26" viewBox="0 0 28 26" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M10.6943 14.7269H4.90566C4.35623 14.7269 3.92453 14.2952 3.92453 13.7457C3.92453 13.2061 4.35623 12.7646 4.90566 12.7646H9.5366C9.26189 12.1759 9.04604 11.5578 8.88906 10.9103H4.90566C4.35623 10.9103 3.92453 10.4688 3.92453 9.92913C3.92453 9.38951 4.35623 8.948 4.90566 8.948H8.60453C8.59472 8.7812 8.59472 8.62422 8.59472 8.45743C8.59472 7.28988 8.79094 6.17139 9.14415 5.12158H3.53207C1.57962 5.12158 0 6.71102 0 8.65366V18.8378C0 20.6529 1.3834 22.1638 3.15924 22.3405V24.4106C3.15924 24.9895 3.48302 25.4997 4.00302 25.7548C4.20906 25.8529 4.43472 25.902 4.65057 25.902C4.98415 25.902 5.30792 25.794 5.57283 25.5782L7.78038 23.8416C8.97736 22.8899 10.4883 22.3601 12.0287 22.3601H18.8181C20.7608 22.3601 22.3502 20.7804 22.3502 18.8378V18.3276C21.3004 18.6808 20.1819 18.8771 19.0143 18.8771C15.6196 18.8771 12.5977 17.2484 10.6943 14.7269ZM11.1751 18.5533H4.90566C4.35623 18.5533 3.92453 18.1118 3.92453 17.5721C3.92453 17.0325 4.35623 16.591 4.90566 16.591H11.1751C11.7147 16.591 12.1562 17.0325 12.1562 17.5721C12.1562 18.1118 11.7147 18.5533 11.1751 18.5533Z" fill="#78A86D"/>
            <path d="M19.0143 0C14.3441 0 10.557 3.79698 10.557 8.45736C10.557 13.1275 14.3441 16.9147 19.0143 16.9147C23.6747 16.9147 27.4717 13.1275 27.4717 8.45736C27.4717 3.79698 23.6747 0 19.0143 0ZM19.0045 13.9026C18.4649 13.9026 18.0234 13.4611 18.0234 12.9215C18.0234 12.3819 18.4551 11.9404 18.9947 11.9404H19.0045C19.5441 11.9404 19.9857 12.3819 19.9857 12.9215C19.9857 13.4611 19.5441 13.9026 19.0045 13.9026ZM19.9955 9.36981V9.9683C19.9955 10.5079 19.554 10.9494 19.0143 10.9494C18.4747 10.9494 18.0332 10.5079 18.0332 9.9683V8.57509C18.0332 8.03547 18.4747 7.59396 19.0143 7.59396C19.4755 7.59396 19.8581 7.22113 19.8581 6.75019C19.8581 6.28906 19.4755 5.91623 19.0143 5.91623C18.5532 5.91623 18.1706 6.28906 18.1706 6.75019C18.1706 7.29962 17.7291 7.73132 17.1894 7.73132C16.6498 7.73132 16.2083 7.29962 16.2083 6.75019C16.2083 5.20981 17.4641 3.95396 19.0143 3.95396C20.5547 3.95396 21.8204 5.20981 21.8204 6.75019C21.8204 7.95698 21.0551 8.96755 19.9955 9.36981Z" fill="#78A86D"/>
          </svg>
          <?=$arResult['PROPERTIES']['FAQ_QUESTION']['VALUE']?>
        </div>
        <?if($arResult['PROPERTIES']['FAQ_ANSWER']['VALUE']):?>
          <div class="faq-answer">
            <h3>Мнение эксперта:</h3>
            <p>
              <?=$arResult['PROPERTIES']['FAQ_ANSWER']['VALUE']?>
            </p>
          </div>
        <?endif;?>
      </div>
    <?endif;?>
    <?}?>

    <?if($arResult['PROPERTIES']['DROP_DOWN_TEXT']['VALUE']):?>
      <div class="d-flex w-100 mt-5 justify-content-between">
        <button class="btn btn-secondary rounded-pill w-100" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
          Смотреть также
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="7" viewBox="0 0 12 7" class="ml-3 inline-svg">
            <g transform="rotate(-90 59.656 59.156)">
              <path d="M113.258 5.441l4.915-4.915a.308.308 0 1 0-.436-.436L112.6 5.225a.307.307 0 0 0 0 .436l5.134 5.132a.31.31 0 0 0 .217.091.3.3 0 0 0 .217-.091.307.307 0 0 0 0-.436z"></path>
            </g>
          </svg>
        </button>
      </div>
      <div class="collapse mt-4" id="collapseExample">
        <?=$arResult['PROPERTIES']['DROP_DOWN_TEXT']['~VALUE']['TEXT']?>
      </div>
    <?endif;?>
  </div>
  <div class="content__footer">
    <div class="content__shared">
      <div class="social-card__title">
        <svg xmlns="http://www.w3.org/2000/svg" width="13.699" height="12.231" viewBox="0 0 13.699 12.231" class="inline-svg">
          <path d="M13.554,31.467,9.64,27.553a.489.489,0,0,0-.833.344v1.957H7.094q-5.451,0-6.689,3.081A6.961,6.961,0,0,0,0,35.481a9.18,9.18,0,0,0,.971,3.448l.08.183q.057.13.1.229a.869.869,0,0,0,.1.168.261.261,0,0,0,.214.13.223.223,0,0,0,.18-.076.285.285,0,0,0,.065-.191,1.557,1.557,0,0,0-.019-.2,1.581,1.581,0,0,1-.019-.18q-.038-.52-.038-.94a6.507,6.507,0,0,1,.134-1.384,4.155,4.155,0,0,1,.371-1.059,2.659,2.659,0,0,1,.612-.772,3.589,3.589,0,0,1,.806-.531,4.372,4.372,0,0,1,1.017-.325,9.694,9.694,0,0,1,1.177-.164q.593-.046,1.342-.046H8.807v1.957a.487.487,0,0,0,.833.344l3.914-3.914a.48.48,0,0,0,0-.688Z" transform="translate(0 -27.408)" fill="#919fa3" />
        </svg>&nbsp;
        Поделиться статьей:
      </div>
      <div class="ya-share2" data-services="vkontakte,twitter,odnoklassniki,telegram"></div>
    </div>
  </div>
</div>
<?
  $this->SetViewTarget('blog_feedback__name');
    echo $formName = ($arResult['PROPERTIES']['FORM_NAME']['VALUE']) ? $arResult['PROPERTIES']['FORM_NAME']['VALUE']: 'Хотите первыми узнавать об&nbsp;акциях и&nbsp;спецпредложениях по&nbsp;поселку?';
  $this->EndViewTarget();
  $this->SetViewTarget('blog_feedback__btn');
    echo $btnName = ($arResult['PROPERTIES']['BTN_NAME']['VALUE']) ? $arResult['PROPERTIES']['BTN_NAME']['VALUE']: 'Хочу знать о скидках';
  $this->EndViewTarget();

  // Блок рекомендуемых поселков в конце:
  if ($arResult['PROPERTIES']['BLOCK_VIL_RECOM']['VALUE'])
  {
    global $arrFilter;
    $arrFilter['ID'] = $arResult['PROPERTIES']['BLOCK_VIL_RECOM']['VALUE'];
  }
?>
