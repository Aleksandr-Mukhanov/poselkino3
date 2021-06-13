<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)die();?>
  <input type="hidden" id="posInfo" data-namePos='<?=$arVillage['NAME']?>' data-codePos='<?=$arVillage['CODE']?>' data-idPos='<?=$arVillage['ID']?>' data-cntPos='<?=$arVillage['PROPERTY_UP_TO_VIEW_VALUE']?>' data-siteId='<?=SITE_ID?>'>
  <input type="hidden" id="develInfo" data-idDevel='<?=$arDevel[0]['ID']?>' data-nameDevel='<?=$arDevel[0]['UF_NAME']?>' data-codeDevel='<?=$arDevel[0]['UF_XML_ID']?>' data-phoneDevel='<?=$phone?>'>
    <footer class="footer">
      <div class="container footer__container">
        <div class="row footer__row footer-top">
          <div class="row__col-3 footer__col-logo">
            <a class="logo" href="/"><img class="logo__img" src="/logo.svg" alt="<?=$arVillage['NAME']?>" title="<?=$arVillage['NAME']?>"></a>
            <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,twitter,viber,whatsapp,skype,telegram"></div>
          </div>
          <div class="row__col-6 footer__col-nav">
            <?$APPLICATION->IncludeComponent("bitrix:menu", "bottom_menu", Array(
              "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
                "CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
                "COMPOSITE_FRAME_MODE" => "A",	// Голосование шаблона компонента по умолчанию
                "COMPOSITE_FRAME_TYPE" => "AUTO",	// Содержимое компонента
                "DELAY" => "N",	// Откладывать выполнение шаблона меню
                "MAX_LEVEL" => "1",	// Уровень вложенности меню
                "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
                "MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
                "MENU_CACHE_TYPE" => "A",	// Тип кеширования
                "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                "ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
                "USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                "COMPONENT_TEMPLATE" => ".default",
                "VILLAGE_NAME" => $arVillage['NAME'],
              ),
              false
            );?>
          </div>
          <div class="row__col-3 footer__col-contacts"><a class="phone" href="tel:<?=str_replace(['','(',')','-'],'',$phone)?>"><span class="icon-phone phone__icon"></span> <?=$phone?></a>
            <div class="recommendation footer__recommendation">Данный поселок рекомендует<br>независимый агрегатор <a class="recommendation__link" href="https://poselkino.ru/" rel="dofollow" target="_blank">Poselkino.ru</a></div>
          </div>
        </div>
        <div class="row footer__row footer-bottom">
          <div class="row__col-6 footer__col-copyright">
            <div class="copyright">© <?=date('Y')?> Все права защищены</div>
          </div>
          <div class="row__col-3 footer__col-terms"><a class="footer__link" href="/polzovatelskoe-soglashenie/">Пользовательское соглашение</a></div>
          <div class="row__col-3 footer__col-privacy"><a class="footer__link" href="/politika-konfidentsialnosti/">Политика Конфиденциальности</a></div>
        </div>
      </div>
      <!-- footer END -->
      <!-- site END -->
      <!-- main ↓ -->
    </footer>
<?if (!CSite::InDir('/index.php')) { // если не на главной?>
  </div>
<?}?>
    <div class="modal fade" id="thanks" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="close" data-dismiss="modal" aria-label="Close"></div>
          <div class="modal-body">
            <div class="center">
              <div class="modal-title">Спасибо за обращение</div>
              <p>Ваша заявка успешно отправлена!<br>Представитель поселка свяжется с Вами в самое ближайшее время)</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/counters.php';?>
  </body>
</html>
