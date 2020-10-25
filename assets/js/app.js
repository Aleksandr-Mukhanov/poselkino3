// Carousel photo
function getPhoto() {
  return {
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    prevArrow: "<button type='button' class='slick-prev' aria-label='Скролл влево'><svg xmlns='http://www.w3.org/2000/svg' width='12.552' height='22.81'><g id='next' transform='translate(-111.989 .567)'><path d='M123.864 10.438L113.607.181a.615.615 0 00-.87.87l9.82 9.82-9.82 9.82a.617.617 0 00.433 1.053.6.6 0 00.433-.182L123.86 11.3a.612.612 0 00.004-.862z' fill='#fff' stroke='#fff' stroke-width='1'></path></g></svg></button>",
    nextArrow: "<button type='button' class='slick-next' aria-label='Скролл вправо'><svg xmlns='http://www.w3.org/2000/svg' width='12.552' height='22.81'><g id='next' transform='translate(-111.989 .567)'><path d='M123.864 10.438L113.607.181a.615.615 0 00-.87.87l9.82 9.82-9.82 9.82a.617.617 0 00.433 1.053.6.6 0 00.433-.182L123.86 11.3a.612.612 0 00.004-.862z' fill='#fff' stroke='#fff' stroke-width='1'></path></g></svg></button>",
    touchMove: false,
    responsive: [{
      breakpoint: 768,
      settings: {
        arrows: true,
      }
    }, ]
  }
}

$(document).ready(function() {

  // Валидация
  window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');

    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
  $('select').selectric();

  autosize($('textarea'));

  // Navbar toggl
  $('.navbar-toggler').on('click', function(callback) {
    $('.header__navbar').toggleClass('show');
    $(this).attr('data-expanded', $('.navbar-toggler').attr('data-expanded') == 'true' ? 'false' : 'true');
    var noScroll = function noScroll() {
      $('body').toggleClass('no-scroll');
    };
    setTimeout(noScroll, 1000);
  });

  // Offer
  // Slider card
  function getCard() {
    return {
      infinite: true,
      slidesToShow: 3,
      slidesToScroll: 1,
      arrows: false,
      prevArrow: "<button type='button' class='slick-prev' aria-label='Скролл влево'><svg xmlns='http://www.w3.org/2000/svg' width='15.574' height='9.815' viewBox='0 0 15.574 9.815'><path d='M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z' transform='translate(0 -75.914)'></svg></button>",
      nextArrow: "<button type='button' class='slick-next' aria-label='Скролл вправо'><svg xmlns='http://www.w3.org/2000/svg' width='15.574' height='9.815' viewBox='0 0 15.574 9.815'><path d='M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z' transform='translate(0 -75.914)'></svg></button>",
      touchMove: false,
      variableWidth: true,
      responsive: [{
        breakpoint: 1366,
        settings: {
          slidesToShow: 2,
        }
      }, {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
        }
      },{
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
        }
      }, ]
    }
  }
  // Slider Address tab
  function getAddress() {
    return {
      infinite: false,
      variableWidth: true,
      prevArrow: "<button type='button' class='slick-prev' aria-label='Скролл влево'><svg xmlns='http://www.w3.org/2000/svg' width='15.574' height='9.815' viewBox='0 0 15.574 9.815'><path d='M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z' transform='translate(0 -75.914)'></svg></button>",
      nextArrow: "<button type='button' class='slick-next' aria-label='Скролл вправо'><svg xmlns='http://www.w3.org/2000/svg' width='15.574' height='9.815' viewBox='0 0 15.574 9.815'><path d='M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z' transform='translate(0 -75.914)'></svg></button>"
    }
  }
  // Slider cardHouseCarousel
  function cardHouseCarousel() {
    return {
      infinite: true,
      slidesToShow: 3,
      slidesToScroll: 1,
      arrows: false,
      prevArrow: "<button type='button' class='slick-prev' aria-label='Скролл влево'><svg xmlns='http://www.w3.org/2000/svg' width='15.574' height='9.815' viewBox='0 0 15.574 9.815'><path d='M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z' transform='translate(0 -75.914)'></svg></button>",
      nextArrow: "<button type='button' class='slick-next' aria-label='Скролл вправо'><svg xmlns='http://www.w3.org/2000/svg' width='15.574' height='9.815' viewBox='0 0 15.574 9.815'><path d='M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z' transform='translate(0 -75.914)'></svg></button>",
      touchMove: false,
      variableWidth: true,
      responsive: [{
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
        }
      }, ]
    }
  }
  $('.card-house-carousel').not('.slick-initialized').slick(cardHouseCarousel());
  $('#special_offers').not('.slick-initialized').slick(getCard());
  $('#raiting-area-home-slick').not('.slick-initialized').slick(getCard());
  $('#raiting-area-slick').not('.slick-initialized').slick(getCard());
  $('#addressTab').not('.slick-initialized').slick(getCard());
  $('#addressTab').not('.slick-initialized').slick(getAddress());
  $('#similar_houses').not('.slick-initialized').slick(getCard());
  $('#house_in_village').not('.slick-initialized').slick(getCard());

  // Счетчик
  // Поселки с высоким рэйтингом
  $('.photo__list, .card-photo__list').not('.slick-initialized').slick(getPhoto()).on('init reInit afterChange', function(event, slick, currentSlide, nextSlide) {
    var counter = $(this).parent('.photo').find('.photo__count .current');
    if (currentSlide) {
      console.log(currentSlide, counter);

      counter.text(currentSlide + 1);
    } else {
      counter.text(1);
    }
  });

  // Mobile hide filter
  $('.toggler-filter').on('click', function() {
    let text = $(this).text();

    $('.show-mobile-filter').slideToggle();
    $(this).text(text == "Скрыть фильтр" ? "Фильтр" : "Скрыть фильтр");
  });
  $("#fromPrice").inputmask({
    "mask": "99 999 999",
    "placeholder": ""
  });
  $("#toPrice").inputmask({
    "mask": "99 999 999",
    "placeholder": ""
  });

  // Tag list

  // Tab address
  // Добавляем активный класс по клику
  $('.address__tab .nav-link').on('click', function() {
    $(this).addClass('active');
    $('.address__tab .nav-link').removeClass('active');
  })

  // Показываем все адреса
  $('#showCollapseAddress').on('click', function() {
    $('.address__tab .tab-content').toggleClass('showToggle');
  });

  // Article
  function getArticle() {
    return {
      infinite: true,
      slidesToShow: 4,
      slidesToScroll: 1,
      arrows: false,
      prevArrow: "<button type='button' class='slick-prev' aria-label='Скролл влево'><svg xmlns='http://www.w3.org/2000/svg' width='15.574' height='9.815' viewBox='0 0 15.574 9.815'><path d='M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z' transform='translate(0 -75.914)'></svg></button>",
      nextArrow: "<button type='button' class='slick-next' aria-label='Скролл вправо'><svg xmlns='http://www.w3.org/2000/svg' width='15.574' height='9.815' viewBox='0 0 15.574 9.815'><path d='M.657 79.964h12.275L10 77.035a.657.657 0 0 1 .929-.929l4.05 4.05a.657.657 0 0 1 0 .929l-4.05 4.051a.657.657 0 0 1-.929-.929l2.929-2.929H.657a.657.657 0 1 1 0-1.314z' transform='translate(0 -75.914)'></svg></button>",
      touchMove: false,
      variableWidth: true,
      responsive: [{
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
        }
      }, ]
    }
  }

  $('#slider_article').not('.slick-initialized').slick(getArticle());

  // Hero
  $('.hero-info-show').on('click', function() {
    $('.hero-info').slideToggle();
  })

  // Plan
  $(".openPlan").lightGallery();

  // Work steps
  let step = $('.step'),
    stepCircle = step.find('.step-circle'),
    stepTitle = step.find('.step-title'),
    stepNext = step.find('.step-cloud__next'),
    stepPrev = step.find('.step-cloud__prev');

  stepCircle.on('click', function() {
    step.removeClass('active');
    $(this).parent('.step').addClass('active');
  });

  stepTitle.on('click', function() {
    let step = $('.step');
    step.removeClass('active');
    $(this).parent('.step').addClass('active');
  });

  stepNext.on('click', function() {
    let activeStep = $('.step.active'),
      activeStepNum = activeStep.data('step');

    if (activeStepNum !== 6) {
      activeStep.removeClass('active');
      $('.step[data-step="' + (activeStepNum + 1) + '"]').addClass('active');
    }
  });
  stepPrev.on('click', function() {
    let activeStep = $('.step.active'),
      activeStepNum = activeStep.data('step');

    if (activeStepNum !== 1) {
      activeStep.removeClass('active');
      $('.step[data-step="' + (activeStepNum - 1) + '"]').addClass('active');
    }
  });

  // Review tabs mobile scroll
  // Добавляем активный класс по клику
  $('.review-list .nav-link').on('click', function() {
    $(this).addClass('active');
    $('.review-list .nav-link').removeClass('active');
  })

  // Slider Address tab
  function getReviews() {
    return {
      infinite: false,
      variableWidth: true,
      arrows: false,
      dots: false
    }
  }
  $('#reviewList').not('.slick-initialized').slick(getReviews());

  $('.star-list label').on('click mouseover', function() {
    var value = $(this).next('input').attr('value');
    console.log(value);
    $('span.star-value__title').html(value);
  });

  $('.star-list label').on('click', function() {
    $('.star-list label').removeClass('checked');
    $(this).addClass('checked');
  });

  // Vilage Slider
  $('#village-slider').not('.slick-initialized').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    fade: true,
    prevArrow: "<button type='button' class='slick-prev main-arr' aria-label='Скролл влево'><<svg xmlns='http://www.w3.org/2000/svg' width='12.552' height='22.81'><g id='next' transform='translate(-111.989 .567)'><path d='M123.864 10.438L113.607.181a.615.615 0 00-.87.87l9.82 9.82-9.82 9.82a.617.617 0 00.433 1.053.6.6 0 00.433-.182L123.86 11.3a.612.612 0 00.004-.862z' fill='#fff' stroke='#fff' stroke-width='1'/></g></svg></button>",
    nextArrow: "<button type='button' class='slick-next main-arr' aria-label='Скролл вправо'><svg xmlns='http://www.w3.org/2000/svg' width='12.552' height='22.81'><g id='next' transform='translate(-111.989 .567)'><path d='M123.864 10.438L113.607.181a.615.615 0 00-.87.87l9.82 9.82-9.82 9.82a.617.617 0 00.433 1.053.6.6 0 00.433-.182L123.86 11.3a.612.612 0 00.004-.862z' fill='#fff' stroke='#fff' stroke-width='1'/></g></svg></button>",
  });

  $('#village-slider-thumb').not('.slick-initialized').slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    asNavFor: '#village-slider',
    dots: false,
    focusOnSelect: true,
    prevArrow: "<button type='button' class='slick-prev' aria-label='Скролл влево'><<svg xmlns='http://www.w3.org/2000/svg' width='12.552' height='22.81'><g id='next' transform='translate(-111.989 .567)'><path d='M123.864 10.438L113.607.181a.615.615 0 00-.87.87l9.82 9.82-9.82 9.82a.617.617 0 00.433 1.053.6.6 0 00.433-.182L123.86 11.3a.612.612 0 00.004-.862z' fill='#fff' stroke='#fff' stroke-width='1'/></g></svg></button>",
    nextArrow: "<button type='button' class='slick-next' aria-label='Скролл вправо'><svg xmlns='http://www.w3.org/2000/svg' width='12.552' height='22.81'><g id='next' transform='translate(-111.989 .567)'><path d='M123.864 10.438L113.607.181a.615.615 0 00-.87.87l9.82 9.82-9.82 9.82a.617.617 0 00.433 1.053.6.6 0 00.433-.182L123.86 11.3a.612.612 0 00.004-.862z' fill='#fff' stroke='#fff' stroke-width='1'/></g></svg></button>",
    responsive: [{
        breakpoint: 1199,
        settings: {
          slidesToShow: 3
        }
      },
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 3
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
          arrows: false,
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1
        }
      }
    ]
  });

  $('#mobile-nav-slider').not('.slick-initialized').slick({
    infinite: false,
    variableWidth: true,
    arrows: false,
    dots: false,
  });

  // Photo buttons steps
  $(document).on('click','.photo__buttons button',function() {
    // console.log($(this))
    $(this).toggleClass("active");
  });

  // Legal information
  $("#legalInformation").lightGallery();

  // Footer Slider
  // Carousel photo
  function getInsta() {
    return {
      infinite: true,
      variableWidth: true,
      slidesToScroll: 1,
      arrows: false,
      fots: false
    }
  }

  $('#instaSlider').not('.slick-initialized').slick(getInsta());

  // Credit
  $('.credit__slider-range .slider-range-thousands').on('change', function() {
    let valueCredit = $(this).val().replace(/(\d{1,3})(?=((\d{3})*)$)/g, " $1");
    $(this).parent().prev().find('span').text(valueCredit);
  })

  $('.credit__slider-range .slider-range-percent').on('change', function() {
    let valueCredit = $(this).val().replace('.', ',')
    $(this).parent().prev().find('span').text(valueCredit);
  })

  $('.credit__slider-range .slider-range-year').on('change', function() {
    let valueCredit = $(this).val()
    $(this).parent().prev().find('span').text(valueCredit);
  })

  // Search
  $('.icon-search').on('click', function(e) {
    e.preventDefault();
    $('.search-header').toggleClass('active');
  });

  // Archor
  $('.anchor a').on('click', function(e) {
    e.preventDefault();
    $('.anchor a').removeClass('.btn-success').addClass('.btn-outline-success');
    $(this).addClass('.btn-success').removeClass('.btn-outline-success');
    var id = $(this).attr('href'),
      top = $(id).offset().top;

    console.log('id' + id);

    $('body,html').animate({
      scrollTop: top
    }, 1500);
  });

  // Blog navigation
  $('.blog-navigation').not('.slick-initialized').slick({
    arrows: false,
    dots: false,
    infinite: false,
    variableWidth: true,
  });

  // House Modal
  $('.house-modal').on('click', function() {
    $('#houseModal').css('display', 'block');
    $('body').addClass('modal-open');
    $('body').prepend('<div class="modal-backdrop show"></div');
  });

  $('button[data-dismiss="modal"]').on('click', function() {
    $('#houseModal').css('display', 'none');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
  });

  // Phone
  $(".phone").inputmask({
    "mask": "+9 (999) 999-9999",
    // "placeholder": ""
  });

  // Range modal (Площадь дома)
  if ($("#slider-range")[0]) {
    $("#slider-range").slider({
      range: true,
      min: 0,
      max: 3000,
      values: [0, 3000],
      slide: function(event, ui) {
        $("#arrFilter_15_MIN").val(ui.values[0]);
        $("#arrFilter_15_MAX").val(ui.values[1]);
      }
    });
  }

  // Воспроизведение большого видео
  $(function() {
    $('.video svg.play').on('click', function() {
      var dataYoutube = $(this).parents('.video.radius').data('youtube');
      $(this).parents('.video.radius').html('<iframe src="https://www.youtube.com/embed/' + dataYoutube + '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>')
    });
  });

  // Интерфейс фильтра
  $('#toggleHighway, #toggleHighwayBack, #highwayDone').on('click', function() {
    $('.map-filter--highway').toggleClass('show');
    $('.map-filter__content').toggleClass('hide');
  });

  // Интерфейс фильтра
  $('#toggleAreas, #toggleAreasBack, #areasDone').on('click', function() {
    $('.map-filter--areas').toggleClass('show');
    $('.map-filter__content').toggleClass('hide');
  });

  $('.highway-direction').on('click', function() {
    var direction = $(this).data('direction');

    if ($('.map-filter--highway input[data-direction="' + direction + '"]').is(':checked')) {
      $('.map-filter--highway input[data-direction="' + direction + '"]').prop('checked', false);
    } else {
      $('.map-filter--highway input[data-direction="' + direction + '"]').prop('checked', true);
    }
  })
  $('.areas-direction').on('click', function() {
    var direction = $(this).data('direction');

    if ($('.map-filter--areas input[data-direction="' + direction + '"]').is(':checked')) {
      $('.map-filter--areas input[data-direction="' + direction + '"]').prop('checked', false);
    } else {
      $('.map-filter--areas input[data-direction="' + direction + '"]').prop('checked', true);
    }
  })

  $('.page-map .show-filter').on('click', function() {
    $(this).toggle()
    $('.page-map__filter').toggleClass('show')
  })
  $('.page-map .close-filter').on('click', function() {
    $('.page-map .show-filter').show()
    $('.page-map__filter').toggleClass('show')
  })

  $(document).on('click','.card-map .close-map', function() {
    $(this).parent('.card-map').toggle()
  })


  $('#video-gallery').lightGallery();

  $('.phone-cart__block span').on('click', function() {
    $(this).css('display', 'none')
  })

});
