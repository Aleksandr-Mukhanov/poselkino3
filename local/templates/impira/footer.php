<footer class="footer">
  <div class="container-fluid">
    <div class="footer-main mb-5">
      <div class="row">
        <div class="col-lg-3 col-md-auto mb-3 mb-md-0"><a class="logo" href="/"><img src="<?=SITE_TEMPLATE_PATH?>/images/logo.svg" alt="<?=$arVillage['NAME']?>" title="<?=$arVillage['NAME']?>"/>
            <div class="logo__desc"><?=$arVillage['NAME']?></div>
          </a></div>
        <div class="col">
          <nav class="nav">
            <a class="nav__link" href="/#section-2">О поселке</a>
            <a class="nav__link" href="/#section-3">Поселок на карте</a>
            <a class="nav__link" href="/#section-4">План поселка</a>
            <a class="nav__link" href="/#section-7">Галерея</a>
            <a class="nav__link" href="/#contacts">Контакты</a>
            <a class="nav__link" href="tel:<?=$phoneClear?>"> <strong class="header-phone"><?=$phone?></strong></a>
          </nav>
        </div>
      </div>
    </div>
    <div class="footer-text">
      <div class="row">
        <div class="col-md mb-2 mb-md-0">
          <p>© <?=date('Y')?> Все права защищены</p>
        </div>
        <div class="col-auto"><a class="politic" href="/politika-konfidentsialnosti/">Политика Конфиденциальности</a></div>
      </div>
    </div>
  </div>
</footer>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть">
        <svg class="icon icon--close">
          <use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#close"></use>
        </svg></button>
      <div class="modal-body">
        <div class="text-center mb-2 mb-lg-3">
          <div class="modal-title">Забронировать участок</div>
          <div class="modal-desc">Заполните форму ниже, наши менеджеры свяжутся с вами в самое ближайшее время</div>
        </div>
        <form class="form-section row p-0 formSignToView" action="/local/ajax/sendForm.php" method="post" data-formID="view" onsubmit="ym(88004170,'reachGoal','prosmotr');return true;">
          <div class="col-12 mb-2">
            <div class="input">
              <input class="input__controll nameSignToView ym-record-keys" type="text" placeholder="Ваше имя" required/>
            </div>
          </div>
          <div class="col appeal-form__col-input lastNameSpam">
            <input class="input-el lnameSignToView" type="text" name="lname" placeholder="Ваша фамилия">
          </div>
          <div class="col-12 mb-2">
            <input class="input__controll telSignToView ym-record-keys" type="tel" placeholder="Номер телефона" required/>
          </div>
          <div class="col-12 mb-2">
            <button class="button w-100">Забронировать участок</button>
          </div>
          <div class="col-12">
            <label class="checbox" for="check-3">
              <input type="checkbox" name="check-3" id="check-3" checked="checked" />
              <div class="checbox__control"></div>
              <div class="checbox__label">Нажимая на кнопку, вы даете согласие на обработку персональных данных и соглашаетесь с <a href="/politika-konfidentsialnosti/"> Политикой Конфиденциальности</a></div>
            </label>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть">
        <svg class="icon icon--close">
          <use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#close"></use>
        </svg></button>
      <div class="modal-body">

        <div class="text-center mb-2 mb-lg-3">
          <div class="modal-title">Узнайте о спецпредложениях и скидках</div>
          <?switch ($_SERVER['HTTP_HOST']) {
            case 'podporinskie-dachi.ru':
              $phoneForm = '+7(495)859-02-09'; break;
            case 'gzelskoe-ozero.ru':
              $phoneForm = '+7(495)154-16-73'; break;
            default:
              $phoneForm = '+7(495)463-05-65'; break;
          }?>
          <div class="modal-desc">Позвоните по телефону <a href="tel:<?=str_replace(['(',')','-'],'',$phoneForm)?>"><?=$phoneForm?></a> или заполните форму ниже</div>
        </div>
        <form class="form-section row p-0 formSignToView" action="/local/ajax/sendForm.php" method="post" data-formID="view" onsubmit="ym(88004170,'reachGoal','skidka');return true;">
          <div class="col-12 mb-2">
            <div class="input">
              <input class="input__controll nameSignToView ym-record-keys" type="text" placeholder="Ваше имя" required/>
            </div>
          </div>
          <div class="col appeal-form__col-input lastNameSpam">
            <input class="input-el lnameSignToView" type="text" name="lname" placeholder="Ваша фамилия">
          </div>
          <div class="col-12 mb-2">
            <input class="input__controll telSignToView ym-record-keys" type="tel" placeholder="Номер телефона" required/>
          </div>
          <div class="col-12 mb-2">
            <button class="button w-100">Отправить</button>
          </div>
          <div class="col-12">
            <label class="checbox" for="check-4">
              <input type="checkbox" name="check-4" id="check-4" checked="checked" />
              <div class="checbox__control"></div>
              <div class="checbox__label">Нажимая на кнопку, вы даете согласие на обработку персональных данных и соглашаетесь с <a href="/politika-konfidentsialnosti/"> Политикой Конфиденциальности</a></div>
            </label>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="posInfo" data-namePos='<?=$arVillage['NAME']?>' data-codePos='<?=$arVillage['CODE']?>' data-highwayPos='<?=$shosseName?>' data-idPos='<?=$arVillage['ID']?>' data-cntPos='<?=$arVillage['PROPERTY_UP_TO_VIEW_VALUE']?>' data-siteId='<?=SITE_ID?>' data-manager='<?=$arVillage['PROPERTY_MANAGER_VALUE']?>'>
<input type="hidden" id="develInfo" data-idDevel='<?=$arDevel[0]['ID']?>' data-nameDevel='<?=$arDevel[0]['UF_NAME']?>' data-codeDevel='<?=$arDevel[0]['UF_XML_ID']?>' data-phoneDevel='<?=$phone?>'>
    </div>

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
