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

$(document).ready(function(){

  // построить маршрут
  $('#bildRoute').click(function(){
    coordMap = $('#coordMap').text(); //alert(sort);
    // location.href = 'https://yandex.ru/maps/?rtext=~'+coordMap+'&rtt=auto';
    window.open('https://yandex.ru/maps/?rtext=~'+coordMap+'&rtt=auto','_blank');
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

  // отправка отзыва
	$('#formSendReview').submit(function(event){
		event.preventDefault();
		idPos = $('#posInfo').attr('data-idPos');
		namePos = $('#posInfo').attr('data-namePos');
		codeDevel = $('#develInfo').attr('data-codeDevel');
		nameDevel = $('#develInfo').attr('data-nameDevel');
		name = $(this).find('input[name=review-name]').val();
		fname = $(this).find('input[name=review-surname]').val();
		email = $(this).find('input[name=review-email]').val();
		star = $(this).find('select[name=review-raiting]').val();
		dignities = $(this).find('input[name=review-advantages]').val();
		disadvantages = $(this).find('input[name=review-disadvantages]').val();
		comment = $(this).find('textarea[name=review-text]').val();
		resident = $(this).find('input[name=review-resident]:checked').val();
		// alert(comment);
		$.post("/local/ajax/sendForm.php",{
				ourForm: 'SendReview',
				idPos: idPos,
				namePos: namePos,
				codeDevel: codeDevel,
				nameDevel: nameDevel,
				name: name,
				fname: fname,
				email: email,
				star: star,
				dignities: dignities,
				disadvantages: disadvantages,
				comment: comment,
				resident: resident,
			},function(data){
				$('#formSendReview').html(data);
			}
		);
	});
});
