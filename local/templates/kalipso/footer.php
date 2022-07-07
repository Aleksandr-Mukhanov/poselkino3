<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)die();?>
  <input type="hidden" id="posInfo" data-namePos='<?=$arVillage['NAME']?>' data-codePos='<?=$arVillage['CODE']?>' data-highwayPos='<?=$shosseName?>' data-idPos='<?=$arVillage['ID']?>' data-cntPos='<?=$arVillage['PROPERTY_UP_TO_VIEW_VALUE']?>' data-siteId='<?=SITE_ID?>' data-manager='<?=$arVillage['PROPERTY_MANAGER_VALUE']?>'>
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

    <!-- calltouch -->
    <script type="text/javascript">
    (function(w,d,n,c){w.CalltouchDataObject=n;w[n]=function(){w[n]["callbacks"].push(arguments)};if(!w[n]["callbacks"]){w[n]["callbacks"]=[]}w[n]["loaded"]=false;if(typeof c!=="object"){c=[c]}w[n]["counters"]=c;for(var i=0;i<c.length;i+=1){p(c[i])}function p(cId){var a=d.getElementsByTagName("script")[0],s=d.createElement("script"),i=function(){a.parentNode.insertBefore(s,a)},m=typeof Array.prototype.find === 'function',n=m?"init-min.js":"init.js";s.type="text/javascript";s.async=true;s.src="https://mod.calltouch.ru/"+n+"?id="+cId;if(w.opera=="[object Opera]"){d.addEventListener("DOMContentLoaded",i,false)}else{i()}}})(window,document,"ct","acjsv0co");
    </script>
    <!-- calltouch -->

    <!-- Facebook Pixel Code -->
    <script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '1573489849672695');
      fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=1573489849672695&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->

    <? // jivosite
    $shosseEnumId = array_key_first($arVillage["PROPERTY_SHOSSE_VALUE"]);
    $jivositeCode = getInfoHW($shosseEnumId)['JIVOSITE'];
    if($jivositeCode):?>
      <script src="//code-sb1.jivosite.com/widget/<?=$jivositeCode?>" async></script>
    <?endif;?>

    <?require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/counters.php';?>

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
       (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
       m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
       (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

       ym(88004170, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true
       });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/88004170" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

  </body>
</html>
