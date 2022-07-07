// время на сайте
var timeSendForm = 10; // значение, через сколько секунд возможна отправка формы
startdate = new Date();
clockStart = startdate.getTime();
function getSecs() {
  var thisTime = new Date();
	var timePassed = (thisTime.getTime() - clockStart) / 1000;
	var tSecs = Math.round(timePassed);
  var iSecs = tSecs % 60;
  return iSecs;
}

$(document).ready(function() {
  $("input[type=tel]").mask("+7 000 000 00 00");

  var swiper = new Swiper(".mySwiper", {
    slidesPerView: "auto",
    loop: true,
    spaceBetween: 30,
    centeredSlides: true,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });

  $(".open-menu").on("click" , function() {

    $("body").addClass("menu-active")
  });

  $(".menu-close").on("click" , function() {

    $("body").removeClass("menu-active")
  });


  $('.flowing-scroll').on( 'click', function(event){

    if($("body").hasClass("menu-active")) {
      $("body").removeClass("menu-active")
    }
    var el = $(this);
    var dest = el.attr('href');
    $('html').animate({
      scrollTop: $(dest).offset().top
    }, 500
    );

    return false;
  });

  //  Записаться на просмотр
  $('.formSignToView').submit(function(event){
    event.preventDefault();
    iSecs = getSecs();
  	if (iSecs < timeSendForm) {
  		alert('Вы на сайте всего: '+iSecs+' сек');
  		return false;
  	}
    name = $(this).find('.nameSignToView').val();
    lname = $(this).find('.lnameSignToView').val();
    tel = $(this).find('.telSignToView').val();
    email = $(this).find('.emailSignToView').val();
    // idButton = $('#idButton').val();
    // if (idButton == '') idButton = 'SIGN_UP_TO_VIEW';
    // yaCounter50830593.reachGoal(idButton);
    idPos = $('#posInfo').attr('data-idPos');
    namePos = $('#posInfo').attr('data-namePos');
    codePos = $('#posInfo').attr('data-codePos');
    highway = $('#posInfo').attr('data-highwayPos');
    cntPos = $('#posInfo').attr('data-cntPos');
    develId = $('#develInfo').attr('data-idDevel');
    develName = $('#develInfo').attr('data-nameDevel');
    develCode = $('#develInfo').attr('data-codeDevel');
    phoneDevel = $('#develInfo').attr('data-phoneDevel');
    siteId = $('#posInfo').attr('data-siteId');
    formID = $(this).attr('data-formID');
    manager = $('#posInfo').attr('data-manager');
    // captcha_code = $(this).find('input[name=captcha_code]').val();
    // captcha_word = $(this).find('input[name=captcha_word]').val();
    // if(idButton == 'LEAVE_REQUEST'){
    //   subject = 'Заявка с сайта Поселкино.ру';
    // }else{
    //   subject = 'Запись на просмотр';
    // }
    subject = 'Запись на просмотр с сайта ' + window.location.host;

    if(!lname){
      // $.post("/local/ajax/sendForm.php",{
      //     captcha_code: captcha_code,
      //     captcha_word: captcha_word,
      //     ourForm: 'chekCaptcha',
      //   },function(data){
      //     // console.log(captcha_code + ' - ' + captcha_word);
      //     // console.log(data);
      //     if (data == 'no') {
      //       alert('Неверная капча!');
      //     } else {
            $.post("/local/ajax/sendForm.php",{
                name: name,
                tel: tel,
                email: email,
                ourForm: 'SignToView',
                subject: subject,
                idPos: idPos,
                namePos: namePos,
                codePos: codePos,
                highway: highway,
                cntPos: cntPos,
                develId: develCode,
                develName: develName,
                phoneDevel: phoneDevel,
                siteId: siteId,
                formID: formID,
                manager: manager
              },function(data){
                $('.formSignToView').html(data);
                fbq('track', 'Lead');
              }
            );
      //     }
      //   }
      // );
    }
  });

  function prepareMap (map) {
      ymaps.ready(function() {
          var _map = map;
          if(typeof map === "function") {
              var _map = map();
          }

          var container = $(_map.container.getParentElement()),
              buttons = $('<div class="controls_zoom"><div id="zoom-in"></div><div id="zoom-out"></div></div>');

          buttons.find("#zoom-in").on("click", function(){
              _map.setZoom(_map.getZoom() + 1, {checkZoomRange: true});
          });
          buttons.find("#zoom-out").on("click", function(){
              _map.setZoom(_map.getZoom() - 1, {checkZoomRange: true});
          });
          container.append(buttons);
      });
  };

  function maps() {

      lat = $("#map").data("lat");
      lon = $("#map").data("lon");

      var myMap = new ymaps.Map('map', {
              center: [lat, lon],
              zoom: 10,
              scroll: false,
              controls: []
          }),
          myPlacemark = new ymaps.Placemark([lat, lon],{},{

          });


      myMap.events.add(['balloonopen'], function(e) {
          myMap.balloon.close();
      });

      if( innerWidth < 992) {
          myMap.behaviors.disable('drag');
      }

      myMap.geoObjects.add(myPlacemark);
      myMap.behaviors.disable('scrollZoom');
      return myMap;
  };

  if ($("div").is("#map")) {
      prepareMap(maps);
  }

});

$(document).mouseup(function(e) {

  var menu = $(".menu");
  if (menu.has(e.target).length === 0) {
      $("body").removeClass("menu-active")
  }


});
