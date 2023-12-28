<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();
   for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
   k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(91825752, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/91825752" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<script>
  <?
    $marquizID = '65326c6346345800253ff225';
    $marquizTitle = 'Подберите участок в поселке';
    $marquizText = 'Лапино';
  ?>

  (function(w, d, s, o){
    var j = d.createElement(s); j.async = true; j.src = '//script.marquiz.ru/v2.js';j.onload = function() {
      if (document.readyState !== 'loading') Marquiz.init(o);
      else document.addEventListener("DOMContentLoaded", function() {
        Marquiz.init(o);
      });
    };
    d.head.insertBefore(j, d.head.firstElementChild);
  })(window, document, 'script', {
      host: '//quiz.marquiz.ru',
      region: 'eu',
      id: '<?=$marquizID?>',
      autoOpen: false,
      autoOpenFreq: 'once',
      openOnExit: false,
      disableOnMobile: false
    }
  );

  (function(t, p) {window.Marquiz ? Marquiz.add([t, p]) : document.addEventListener('marquizLoaded', function() {Marquiz.add([t, p])})})('Pop', {id: '<?=$marquizID?>', title: '<?=$marquizTitle?>', text: '<?=$marquizText?>', delay: 10, textColor: '#ffffff', bgColor: '#fbb358', svgColor: '#ffffff', closeColor: '#ffffff', bonusCount: 1, bonusText: 'Вам доступен бонус', type: 'side', position: 'position_bottom-left', rounded: true, shadow: 'rgba(251, 179, 88, 0)', blicked: true})
</script>
