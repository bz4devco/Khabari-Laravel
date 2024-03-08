$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
window.onscroll = function () {
  if (window.pageYOffset > 200) {
    up.className = "";

  } else {
    up.className = "hide";
  }
}


$('.copy-code').tooltip({
  trigger: 'click',
  placement: 'bottom'
});

function setTooltip(message) {
  $('.copy-code').tooltip('hide')
    .attr('data-original-title', message)
    .tooltip('show');
}

function hideTooltip() {
  setTimeout(function () {
    $('.copy-code').tooltip('hide');
  }, 1000);
}
var clipboard = new Clipboard('.copy-code');

clipboard.on('success', function (e) {
  setTooltip('کپی شد');
  hideTooltip();
});
clipboard.on('error', function (e) {
  setTooltip('خطا');
  hideTooltip();
});
