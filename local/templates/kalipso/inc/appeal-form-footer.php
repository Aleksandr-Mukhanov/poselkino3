<!-- appeal BEGIN-->
<section class="appeal">
  <div class="container appeal__container">
    <h2 class="title--size_2 appeal__title">Забронировать земельный участок</h2>
    <form class="appeal-form formSignToView" action="/local/ajax/sendForm.php" method="post">
      <div class="title--size_4 appeal-form__title">Позвоните по телефону <a href="tel:<?=str_replace(['','(',')','-'],'',$phone)?>"><strong><?=$phone?></strong></a>, или заполните форму ниже</div>
      <div class="row appeal-form__row">
        <div class="col appeal-form__col-input">
          <input class="input-el nameSignToView" type="text" name="name" required placeholder="Ваше имя">
        </div>
        <div class="col appeal-form__col-input">
          <input class="input-el telSignToView" type="tel" name="phone" required placeholder="Номер телефона">
        </div>
        <div class="col appeal-form__col-input">
          <input class="input-el emailSignToView" type="email" name="address" placeholder="Адрес электронной почты">
        </div>
        <div class="col appeal-form__col-submit">
          <input class="btn btn--theme_green appeal-form__btn" type="submit" value="Записаться на просмотр">
        </div>
        <div class="col appeal-form__col-privacy">
          <label class="privacy appeal-form__privacy">
            <input class="privacy__input" type="checkbox" name="privacy" value="privacy" required checked><span class="privacy__icon"></span> Нажимая на кнопку, вы даете согласие на обработку персональных данных и соглашаетесь с <a class="privacy__link" href="/politika-konfidentsialnosti/">Политикой Конфиденциальности</a>
          </label>
        </div>
      </div>
    </form>
  </div>
</section>
<!-- appeal END-->
