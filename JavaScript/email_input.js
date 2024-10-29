var wHeight = $(window).height();
var distance = 0;

$('li').height(wHeight);

$('a').on('click', function(event) {
  event.preventDefault();
});

$('.next-arrow').on('click', function() {
  distance = $(window).scrollTop();
  $("html, body").animate({
    scrollTop: distance + wHeight
  }, 600);
});

$('.back-arrow').on('click', function() {
  distance = $(window).scrollTop();
  $("html, body").animate({
    scrollTop: distance - wHeight
  }, 600);
});