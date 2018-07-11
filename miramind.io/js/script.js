// AOS.init({
//   duration: 800
// });

$(function() {
        $('.lazy').Lazy();
    });

// 'use strict';
function r(f){/in/.test(document.readyState)?setTimeout('r('+f+')',9):f()}
r(function(){
    if (!document.getElementsByClassName) {
        // Поддержка IE8
        var getElementsByClassName = function(node, classname) {
            var a = [];
            var re = new RegExp('(^| )'+classname+'( |$)');
            var els = node.getElementsByTagName("*");
            for(var i=0,j=els.length; i<j; i++)
                if(re.test(els[i].className))a.push(els[i]);
            return a;
        }
        var videos = getElementsByClassName(document.body,"youtube");
    } else {
        var videos = document.getElementsByClassName("youtube");
    }

    var nb_videos = videos.length;
    for (var i=0; i<nb_videos; i++) {
        // Находим постер для видео, зная ID нашего видео
        // videos[i].style.backgroundImage = 'url(http://i.ytimg.com/vi/' + videos[i].id + '/sddefault.jpg)';

        // Размещаем над постером кнопку Play, чтобы создать эффект плеера
        var play = document.createElement("div");
        play.setAttribute("class","play");
        videos[i].appendChild(play);

        videos[i].onclick = function() {
            // Создаем iFrame и сразу начинаем проигрывать видео, т.е. атрибут autoplay у видео в значении 1
            var iframe = document.createElement("iframe");
            var iframe_url = "https://www.youtube.com/embed/" + this.id + "?autoplay=1&autohide=1";
            if (this.getAttribute("data-params")) iframe_url+='&'+this.getAttribute("data-params");
            iframe.setAttribute("src",iframe_url);
            iframe.setAttribute("frameborder",'0');

            // Высота и ширина iFrame будет как у элемента-родителя
            iframe.style.width  = this.style.width;
            iframe.style.height = this.style.height;

            // Заменяем начальное изображение (постер) на iFrame
            this.parentNode.replaceChild(iframe, this);
        }
    }
});

$(window).on('load', function () {
    var $preloader = $('#p_prldr'),
        $svg_anm   = $preloader.find('.svg_anm');
    $svg_anm.fadeOut();
    $preloader.delay(700).fadeOut('slow');
});

$.validate({
  form: '#faq_form, #subscribe',
  modules : 'date, security'
});

$(document).ready(function() {
   $('a[href^="#"]').click(function () {
     elementClick = $(this).attr("href");
     destination = $(elementClick).offset().top - 76;

       $('body,html').animate( { scrollTop: destination }, 1100 );

     return false;
   });
 });


 $('.faq_tabs').click(function(){
   if ($(this).children('.hidden_faq').hasClass('hidden')) {
     $(this).children('.hidden_faq').addClass('visible');
     $(this).children('.hidden_faq').removeClass('hidden');
     $(this).find('.faq_img').css('transform','rotate(180deg)');
   } else {
     $(this).children('.hidden_faq').addClass('hidden');
     $(this).children('.hidden_faq').removeClass('visible');
     $(this).find('.faq_img').css('transform','rotate(0deg)');
   }

   //  if ($('.faq_tabs').not(this).children('.hidden_faq').hasClass('visible')) {
   //   $(this).children('.hidden_faq').removeClass('visible');
   //   $(this).children('.hidden_faq').addClass('hidden');
   // }
 })

if ($(window).width() <= 768) {
  $('.economy_img').attr('src','img/triangle.png');
  $('.advantages_img').attr('src','img/advantages_schema_mobile.png');
  $('.economy_title').css('display','block');
  $('.economy').css('top','100px');
  $('.advantages').css('top','100px');
  $('.road').css('margin-top','-50px');
}
