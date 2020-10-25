
$(document).ready(function(){
    $("input[name='phone']").mask("+0 (000) 000-00-00");

    // toggle mobile
    $('.js-mobile-toggle').click(function(){
        $('body').toggleClass('is-hidden');
        $(this).toggleClass('is-active');
        $('.header__nav').toggleClass('is-show');
    });

    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,

        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
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
    if ($("select").is(".my-select")) {
        $('.my-select').selectpicker();
    }



    $(".appeal-form").submit(function() {
        $("#thanks").modal('show');
        return false;
    });
});
