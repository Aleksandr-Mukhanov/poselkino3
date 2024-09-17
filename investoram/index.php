<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Выгодные инвестиции в землю с доходностью свыше 50% годовых");

use Bitrix\Main\Page\Asset;
	Asset::getInstance()->addCss("/assets/css/lend.css");
?>
<main class="page no-margin--footer">

  <section class="first first-investor">
    <div class="container">
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
      <h1 class="first__title first-investor__title"><?$APPLICATION->ShowTitle(false);?></h1>
      <div class="first__wrap">
        <div class="first__item">
          <svg width="28" height="30" viewBox="0 0 28 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M2.87154 19.5426C2.0739 17.7081 1.75484 15.694 1.97419 13.6999C2.03401 13.1814 1.65513 12.7028 1.13666 12.643C1.09678 12.643 1.0569 12.643 1.03696 12.643C0.558369 12.643 0.139605 13.0019 0.0997227 13.5005C-0.259218 16.6911 0.558369 19.9215 2.4129 22.5538C4.24748 25.2059 6.97942 27.0804 10.1102 27.8581L9.61165 28.0974C9.13306 28.3167 8.93365 28.895 9.153 29.3736C9.37236 29.8522 9.95065 30.0516 10.4292 29.8323L13.7395 28.2569C14.1184 28.0775 14.3377 27.6587 14.2779 27.2399C14.1981 26.8212 13.8591 26.5021 13.4404 26.4423L12.0844 26.2828C10.0902 26.0634 8.19583 25.3256 6.5806 24.1291C4.94542 22.9526 3.66919 21.3772 2.87154 19.5426Z"
              fill="#78A86D" />
            <path d="M20.0212 8.236C18.2464 6.46124 15.8136 5.44424 13.301 5.44424C10.7884 5.44424 8.35559 6.4413 6.58082 8.236C4.80606 10.0108 3.78906 12.4436 3.78906 14.9562C3.78906 17.4688 4.78612 19.8816 6.58082 21.6763C8.35559 23.4511 10.7685 24.4681 13.301 24.4681C15.8136 24.4681 18.2464 23.471 20.0212 21.6763C21.7959 19.9016 22.8129 17.4688 22.8129 14.9562C22.8129 12.4436 21.8159 10.0108 20.0212 8.236Z"
              fill="#78A86D" />
            <path d="M16.2124 0.100016L12.9022 1.67537C12.5233 1.85484 12.3039 2.2736 12.3638 2.69237C12.4435 3.11113 12.7825 3.43019 13.2013 3.49001L14.5573 3.64954C16.5514 3.86889 18.4458 4.60672 20.0611 5.80318C21.6763 6.97971 22.9525 8.575 23.7502 10.4096C24.5478 12.2442 24.8669 14.2582 24.6475 16.2523C24.6276 16.5116 24.6874 16.7509 24.8469 16.9503C25.0065 17.1497 25.2258 17.2693 25.485 17.3092C25.7443 17.3292 25.9836 17.2693 26.183 17.1098C26.3824 16.9503 26.502 16.7309 26.5419 16.4717C26.9009 13.2811 26.0833 10.0506 24.2288 7.41842C22.3942 4.78619 19.6622 2.89178 16.5315 2.11407L17.03 1.87478C17.5086 1.65543 17.708 1.07713 17.4886 0.598545C17.2494 0.0601335 16.691 -0.139278 16.2124 0.100016Z"
              fill="#78A86D" />
            <path d="M10.7286 19.5027C10.6687 19.4429 10.6488 19.3632 10.6488 19.2834V17.9075H9.69162C9.61185 17.9075 9.53209 17.8875 9.47226 17.8277C9.41244 17.7479 9.37256 17.6881 9.37256 17.6083V17.2095C9.37256 17.1098 9.3925 17.05 9.45232 16.9902C9.51215 16.9303 9.59191 16.9104 9.67168 16.9104H10.6289V16.2324H9.67168C9.59191 16.2324 9.51215 16.2125 9.45232 16.1526C9.3925 16.0928 9.37256 16.013 9.37256 15.9333V15.2154C9.37256 15.1157 9.3925 15.0559 9.45232 14.996C9.51215 14.9362 9.59191 14.9163 9.67168 14.9163H10.6289V11.0278C10.6289 10.928 10.6488 10.8682 10.7086 10.8084C10.7684 10.7486 10.8283 10.7286 10.928 10.7286H14.318C15.335 10.7286 16.1525 10.9679 16.7308 11.4465C17.3091 11.9251 17.6083 12.623 17.6083 13.5403C17.6083 14.4178 17.3091 15.0758 16.7308 15.5345C16.1525 15.9931 15.3549 16.2125 14.318 16.2125H12.4634V16.8905H14.5174C14.6171 16.8905 14.6769 16.9104 14.7367 16.9702C14.7966 17.03 14.8165 17.0899 14.8165 17.1896V17.5884C14.8165 17.6682 14.7966 17.7479 14.7367 17.8077C14.6769 17.8676 14.6171 17.8875 14.5174 17.8875H12.4834V19.2634C12.4834 19.3432 12.4634 19.423 12.4036 19.4828C12.3438 19.5426 12.264 19.5626 12.1843 19.5626H10.9679C10.8681 19.5825 10.7884 19.5626 10.7286 19.5027ZM14.2781 14.8963C14.7766 14.8963 15.1356 14.7767 15.3948 14.5573C15.654 14.318 15.7737 13.979 15.7737 13.5403C15.7737 13.1016 15.654 12.7626 15.3948 12.5233C15.1555 12.284 14.7766 12.1445 14.2581 12.1445H12.4236V14.9163H14.2781V14.8963Z"
              fill="white" />
          </svg>
          <span class="first__item-txt">Высокая ликвидность земли
            в&nbsp;<?=REGION_KOY?> области</span>
        </div>
        <div class="first__item">
          <svg width="25" height="30" viewBox="0 0 25 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M8.84515 8.40002H16.3548C16.3548 8.40002 22.6452 2.67098 20.5161 1.78066C18.3871 0.890338 15.9484 2.20647 15.5419 3.50324C15.5419 3.50324 12.3677 -2.20644 10.8968 3.50324C10.8968 3.50324 2.72902 -0.948372 5.0129 4.68389C5.6516 6.25163 8.84515 8.40002 8.84515 8.40002Z"
              fill="#78A86D" />
            <path d="M16.1228 9.94839H8.76797C1.02603 16.2387 -1.35461 26.071 3.42603 28.7032C6.56152 30.4258 18.3099 30.4258 21.4454 28.7032C26.2454 26.071 23.8841 15.7548 16.1228 9.94839Z" fill="#78A86D" />
            <path d="M9.21267 24.6774C9.1546 24.6194 9.11589 24.5419 9.11589 24.4452V22.9355H8.07073C7.97396 22.9355 7.89654 22.8968 7.83847 22.8387C7.78041 22.7806 7.7417 22.7032 7.7417 22.6064V22.1806C7.7417 22.0839 7.78041 22.0064 7.83847 21.9484C7.89654 21.8903 7.97396 21.8516 8.07073 21.8516H9.11589V21.0968H8.07073C7.97396 21.0968 7.89654 21.0581 7.83847 21C7.78041 20.9419 7.7417 20.8645 7.7417 20.7677V19.9935C7.7417 19.8968 7.78041 19.8194 7.83847 19.7613C7.89654 19.7032 7.97396 19.6645 8.07073 19.6645H9.11589V15.4452C9.11589 15.3484 9.1546 15.2516 9.21267 15.1935C9.27073 15.1355 9.34815 15.0968 9.44492 15.0968H13.1611C14.2836 15.0968 15.1546 15.3677 15.7933 15.8903C16.432 16.4129 16.7417 17.1871 16.7417 18.1935C16.7417 19.1613 16.432 19.8774 15.7933 20.3806C15.1546 20.8645 14.2836 21.1161 13.1611 21.1161H11.1288V21.871H13.3546C13.4514 21.871 13.5288 21.9097 13.5869 21.9677C13.6449 22.0258 13.6836 22.1032 13.6836 22.2V22.6258C13.6836 22.7226 13.6449 22.8 13.5869 22.8581C13.5288 22.9161 13.4514 22.9548 13.3546 22.9548H11.1288V24.4645C11.1288 24.5613 11.0901 24.6387 11.032 24.6968C10.974 24.7548 10.8772 24.7935 10.7804 24.7935H9.44492C9.34815 24.7742 9.27073 24.7355 9.21267 24.6774ZM13.0836 19.6452C13.6256 19.6452 14.032 19.5097 14.303 19.2581C14.5933 19.0064 14.7288 18.6387 14.7288 18.1548C14.7288 17.6903 14.5933 17.3226 14.3223 17.0323C14.0514 16.7613 13.6449 16.6258 13.0836 16.6258H11.0901V19.6452H13.0836Z"
              fill="white" />
          </svg>
          <span class="first__item-txt">Доступный объем инвестиций 1&nbsp;-&nbsp;1,5&nbsp;млн. руб.</span>
        </div>
        <div class="first__item">
          <svg width="28" height="30" viewBox="0 0 28 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.66 28.08H27.3C27.66 28.08 27.96 28.38 27.96 28.74V29.32C27.96 29.68 27.66 29.98 27.3 29.98H0.66C0.3 29.98 0 29.68 0 29.32V28.74C0 28.38 0.3 28.08 0.66 28.08ZM4.52 11.54C4.08 11.74 3.56 11.54 3.36 11.1C3.16 10.66 3.36 10.14 3.8 9.94L21.44 2.04L20.56 1.74C20.1 1.58 19.86 1.08 20.02 0.620004C20.18 0.160004 20.68 -0.0799965 21.14 0.0800035L24.14 1.1C24.6 1.26 24.84 1.76 24.68 2.22C24.3 3.2 23.84 4.22 23.44 5.2C23.26 5.64 22.74 5.86 22.28 5.68C21.84 5.5 21.62 4.98 21.8 4.52L22.16 3.66L4.52 11.54ZM3.88 16.54H8.54C8.88 16.54 9.16 16.82 9.16 17.16V26.8C9.16 27.14 8.88 27.42 8.54 27.42H3.88C3.54 27.42 3.26 27.14 3.26 26.8V17.18C3.26 16.82 3.54 16.54 3.88 16.54ZM19.42 7.22H24.08C24.42 7.22 24.7 7.5 24.7 7.84V26.8C24.7 27.14 24.42 27.42 24.08 27.42H19.42C19.08 27.42 18.8 27.14 18.8 26.8V7.84C18.8 7.5 19.08 7.22 19.42 7.22ZM11.66 11.88H16.32C16.66 11.88 16.94 12.16 16.94 12.5V26.8C16.94 27.14 16.66 27.42 16.32 27.42H11.66C11.32 27.42 11.04 27.14 11.04 26.8V12.5C11.04 12.16 11.32 11.88 11.66 11.88Z"
              fill="#78A86D" />
          </svg>
          <span class="first__item-txt">Рост цены в&nbsp;соответствии с&nbsp;инфляцией</span>
        </div>
      </div>

      <a href="#page_block_1" class="btn btn-warning first__button first-investor__button">Поехали!</a>
    </div>


  </section>
  <section class="offer offer-investor" id="page_block_1">
    <div class="container">
      <h2 class="offer__title">Хотите первыми получать лучшие предложения по инвестициям?</h2>
      <div class="row">
        <div class="offer__left col-lg-4 col-md-5 col-sm-6">
          <div class="offer__wrap offer-investor__wrap">
            <div class="offer__subtitle offer-investor__subtitle">Заполните форму и регулярно получайте от нас самые актуальные объекты для инвестиций</div>
            <form action="" method="post" class="formOrderLend" data-form="Инвесторам">
              <div class="form-group offer__form-group">
                <input class="form-control offer__form-control nameOrderLend" id="nameOffer" type="text" placeholder="Введите ваше имя" required>
              </div>
              <div class="form-group offer__form-group">
                <input class="phone form-control offer__form-control telOrderLend" id="telOffer" type="tel" placeholder="Введите номер телефона" autocomplete="off" required inputmode="text">
              </div>
              <button class="btn btn-warning px-5 w-100 rounded-pill offer__button" type="submit">Получить предложения</button>
              <div class="custom-control custom-checkbox custom-control-inline">
                <input class="custom-control-input" id="privacy-policy-offer-1" type="checkbox" name="privacy-policy" checked required>
                <label class="custom-control-label" for="privacy-policy-offer-1">Нажимая на&nbsp;кнопку, вы&nbsp;даете согласие на&nbsp;<a href="/politika-konfidentsialnosti/" target="_blank" class="font-weight-bold offer__link" title="Ознакомиться с обработкой персональных данных">обработку
                    персональных данных</a></label>
              </div>
            </form>
          </div>
        </div>
        <div class="col-lg-8 col-md-7 offer__col">
          <div class="offer__right">
            <div class="offer__right-wrap offer-investor__right" style="background: center / cover no-repeat url(/assets/img/invest/offer-mokap.png)">
              <div class="offer__sticker offer-investor__sticker">
                <span class="offer__sticker-txt"><span class="offer__sticker-big">650+</span>
                  <small class="offer__sticker-small">поселков
                    в&nbsp;базе</small></span>
              </div>
              <p class="offer__right-txt offer-investor__right-txt">
                В&nbsp;нашей базе данных о&nbsp;продаже недвижимости <b>более 650 поселков</b> по&nbsp;<?=REGION_KOY?> области
              </p>
            </div>
          </div>

        </div>
      </div>
    </div>

  </section>
  <section class="quote">
    <div class="container quote__container">
      <div class="quote__title font_trojan">100% уверенность
        в&nbsp;своих вложениях</div>
      <div class="quote__wrap">
        <span class="quote__txt">Покупайте землю&nbsp;&mdash; ведь ее&nbsp;уже больше никто не&nbsp;производит</span>
        <svg width="144" height="90" viewBox="0 0 144 90" fill="none" xmlns="http://www.w3.org/2000/svg" class="quote__icon">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M33.1186 0C51.4131 0 66.2372 14.8676 66.2372 33.2156C66.2372 50.7692 58.8063 77.4023 48.2068 90L37.117 83.1904C37.117 83.1904 42.2093 73.4678 42.8882 64.9559C39.7951 65.9016 36.5135 66.4313 33.1186 66.4313C14.8242 66.4313 0 51.5637 0 33.2156C0 14.8676 14.8242 0 33.1186 0ZM110.559 0C128.853 0 143.677 14.8676 143.677 33.2156C143.677 50.7692 136.247 77.4023 125.647 90L114.557 83.1904C114.557 83.1904 119.649 73.4678 120.328 64.9559C117.235 65.9016 113.954 66.4313 110.559 66.4313C92.2644 66.4313 77.4402 51.5637 77.4402 33.2156C77.4779 14.8676 92.3021 0 110.559 0Z"
            fill="white" fill-opacity="0.15" />
        </svg>
        <div class="quote__author">
          <img src="/assets/img/invest/mt.png" alt="Марк Твен" width="60" height="60" class="quote__author-img">
          <span class="quote__author-name">&copy;&nbsp;Марк Твен</span>
        </div>
      </div>
    </div>

  </section>
  <section class="step step-investor">
    <div class="container">
      <h2 class="step__title step-investor__title">Мы действуем в ваших интересах</h2>
      <div class="row">
        <div class="col-6 step__left">
          <div class="step__item step-investor__item">
            <div style="background: center / contain no-repeat url(/assets/img/invest/step-7.png)" class="step__img"></div>
            <p class="step__txt">Мы работаем напрямую от собственника, что позволит получить наилучшие условия</p>
          </div>
        </div>
        <div class="col-6 step__right">
          <div class="step__item step-investor__item">
            <div style="background: center / contain no-repeat url(/assets/img/invest/step-8.png)" class="step__img"></div>
            <p class="step__txt">С нами вы сможете выбрать объекты удаленно (пришлем фото, видео информацию)</p>
          </div>
        </div>
        <div class="col-6 step__left">
          <div class="step__item step-investor__item">
            <div style="background: center / contain no-repeat url(/assets/img/invest/step-9.png)" class="step__img"></div>
            <p class="step__txt">Оперативно проведем сделку</p>
          </div>
        </div>
        <div class="col-6 step__right">
          <div class="step__item step-investor__item">
            <div style="background: center / contain no-repeat url(/assets/img/invest/step-10.png)" class="step__img"></div>
            <p class="step__txt">Наш опыт и ваши возможности — гарантия успеха</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="ben-plots ben-plots-investor">
    <div class="container">
      <div class="ben-plots__title title_h2">Предложим участки:</div>
      <div class="ben-plots__map" style="background: center / cover no-repeat url(/assets/img/invest/map.jpg)">
        <div class="ben-plots__item ben-plots-investor__item">
          <span>Прибрежные, видовые,<br>прилесные</span>
        </div>
        <div class="ben-plots__item ben-plots-investor__item">
          <span>Без пробок, на электричке</span>
        </div>
        <div class="ben-plots__item ben-plots-investor__item">
          <span>Со школой и остановкой<br>общественного транспорта</span>
        </div>
        <div class="ben-plots__item ben-plots-investor__item">
          <span>Рядом с городом</span>
        </div>
      </div>
      <ul class="ben-plots__list">
        <li class="ben-plots__list-item">Прибрежные, видовые, прилесные</li>
        <li class="ben-plots__list-item">Со школой и остановкой общественного транпорта</li>
        <li class="ben-plots__list-item">Без пробок, на электричке</li>
        <li class="ben-plots__list-item">Рядом с городом</li>
      </ul>
    </div>
  </section>
  <section class="terms terms-investor">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-6 terms__item terms-investor__item">
          <div>
            <div class="terms__title terms-investor__title terms-investor__title-left title_h2">Недвижимость индексируется
              по&nbsp;рынку с&nbsp;оглядкой на&nbsp;общую инфляцию </div>
          </div>
        </div>
        <div class="col-md-6 col-6 terms-investor__item">
          <div class="terms__img terms__img-5 ml-auto"></div>
        </div>
        <div class="col-md-6 col-6">
          <div class="terms__img terms__img-6"></div>
        </div>
        <div class="col-md-6 col-6 terms__item terms__item-right">
          <div>
            <div class="terms__title terms-investor__title terms-investor__title-right title_h2">Средний чек ваших инвестиций составит 1&nbsp;-&nbsp;1.5&nbsp;млн. руб.</div>
          </div>
        </div>
      </div>
    </div>

  </section>
  <section class="consultation consultation-investor">
    <div class="container">
      <h2 class="consultation__title consultation-investor__title">Почему нужно инвестировать
        с&nbsp;нами?</h2>
      <div class="row">
        <div class="col-md-6 col-12 consultation__left">
          <h3 class="consultation__subtitle title_h4">Что покупать?</h3>
          <p class="consultation__txt consultation-investor__txt">Земельные участки обладают рядом преимуществ, высокая ликвидность, невысокий
            средний чек, отсутствие рисков</p>
          <h3 class="consultation__subtitle title_h4">Где покупать?</h3>
          <p class="consultation__txt consultation-investor__txt">Мы&nbsp;знаем рынок загородной недвижимости по&nbsp;всему <?=REGION_SHORT?>: более 650&nbsp;поселков.
            Предложим лучшие варианты</p>
          <h3 class="consultation__subtitle title_h4">Когда покупать?</h3>
          <p class="consultation__txt consultation-investor__txt">Мы&nbsp;точно знаем лучшую точку входа в&nbsp;проект, чтобы получить максимальную выгоду</p>
          <h3 class="consultation__subtitle title_h4">Когда продавать?</h3>
          <p class="consultation__txt consultation-investor__txt">Разработаем оптимальную стратегию, исходя из&nbsp;ваших целей и&nbsp;задач</p>
          <button type="button" class="btn btn-warning consultation__button consultation-investor__button" data-toggle="modal" data-target="#openLendForm">Консультация специалиста</button>
        </div>
        <div class="offset-lg-1 col-lg-5 col-md-6 consultation__right">
          <div style="background: center / contain no-repeat url(/assets/img/invest/consultation.png)" class="consultation__img consultation-investor__img">
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="dynamics">
    <div class="container">
      <div class="row">
				<?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					Array(
						"AREA_FILE_SHOW" => "file",
						"AREA_FILE_SUFFIX" => "inc",
						"EDIT_TEMPLATE" => "",
						"PATH" => "/investoram/dynamics.php"
					)
				);?>
      </div>
    </div>
  </section>
  <section class="examples examples-investor" id="example-investor">
    <div class="container">
      <h2 class="examples__title">Примеры поселков для инвестиций</h2>
      <div class="tab-content">
        <div class="tab-pane active" id="raiting-area" role="tabpanel">
          <div class="block-page__offer" id="raiting-area-slick">
						<?
						// $arrFilter=array('PROPERTY_DOMA'=>[3,256]); // показывать только участки
						$arrFilter['PROPERTY_INVESTORAM'] = 622;
						?>
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
		 				<?//unset($arrFilter['PROPERTY_DOMA']);?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="offer offer-investor offer-investor-2">
    <div class="container">
      <h2 class="offer__title">Хотите получить предложение
        по&nbsp;инвестициям прямо сейчас?</h2>
      <div class="row">
        <div class="offer__left col-lg-4 col-md-5 col-sm-6">
          <div class="offer__wrap offer-investor__wrap">
            <div class="offer__subtitle offer-investor__subtitle">Оставьте заявку, в&nbsp;течение часа вы&nbsp;получите <b>3-4 варианта для вложений</b></div>
            <form action="" method="post" class="formOrderLend" data-form="Инвесторам">
              <div class="form-group offer__form-group">
                <input class="form-control offer__form-control nameOrderLend" id="nameOffer" type="text" placeholder="Введите ваше имя" required>
              </div>
              <div class="form-group offer__form-group">
                <input class="phone form-control offer__form-control telOrderLend" id="telOffer" type="tel" placeholder="Введите номер телефона" autocomplete="off" required inputmode="text">
              </div>
              <button class="btn btn-warning px-5 w-100 rounded-pill offer__button" type="submit">Получить предложения</button>
              <div class="custom-control custom-checkbox custom-control-inline">
                <input class="custom-control-input" id="privacy-policy-offer-2" type="checkbox" name="privacy-policy" checked required>
                <label class="custom-control-label" for="privacy-policy-offer-2">Нажимая на&nbsp;кнопку, вы&nbsp;даете согласие на&nbsp;<a href="/politika-konfidentsialnosti/" target="_blank" class="font-weight-bold offer__link" title="Ознакомиться с обработкой персональных данных">обработку
                    персональных данных</a></label>
              </div>
            </form>
          </div>
        </div>
        <div class="col-lg-8 col-md-7 offer__col">
          <div class="offer__right">
            <div class="offer__right-wrap offer-investor__right" style="background: center / cover no-repeat url(/assets/img/invest/offer-mokap.png)">
              <div class="offer__sticker offer-investor__sticker">
                <span class="offer__sticker-txt"><span class="offer__sticker-big">650+</span>
                  <small class="offer__sticker-small">поселков
                    в&nbsp;базе</small></span>
              </div>
              <p class="offer__right-txt offer-investor__right-txt">
                В&nbsp;нашей базе данных о&nbsp;продаже недвижимости <b>более 650 поселков</b> по&nbsp;<?=REGION_KOY?> области
              </p>
            </div>
          </div>

        </div>
      </div>
    </div>

  </section>

</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
