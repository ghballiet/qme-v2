$(document).ready(function() {
  $('.modal .btn-primary').live('click', function(e) {
    var form = $(this).parent().parent().find('form');
    form.submit();
  });
  
  $('.toggle_text').toggle(function(e) {
    e.preventDefault();
    // hide the text
    $('.right').removeClass('span9').addClass('span12');    
    $('.left').addClass('hidden');
    $(this).html('Show Text');
  }, function(e) {
    e.preventDefault();
    // show the text
    $('.right').removeClass('span12').addClass('span9');    
    $('.left').removeClass('hidden');
    $(this).html('Hide Text');
  });
  
  $('.toggle_model').toggle(function(e) {
    e.preventDefault();
    // hide the graphics
    $('.left').removeClass('span3').addClass('span12');
    $('.right').addClass('hidden');
    $(this).html('Show Graphics');
  }, function(e) {
    e.preventDefault();
    // show the graphics
    $('.left').removeClass('span12').addClass('span3');
    $('.right').removeClass('hidden');
    $(this).html('Hide Graphics');
  });
});