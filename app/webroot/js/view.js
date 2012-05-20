$(document).ready(function() {
  $('.modal .btn-primary').live('click', function(e) {
    var form = $(this).parent().parent().find('form');
    form.submit();
  });
  
  $('.toggle_text').toggle(function(e) {
    e.preventDefault();
    // hide the text
    $('.right').setWidth(12);
    $('.left').hideDiv();
    $(this).html('Show Text');
  }, function(e) {
    e.preventDefault();
    // show the text
    $('.right').setWidth(9);
    $('.left').setWidth(3).showDiv();
    $(this).html('Hide Text');
  });
  
  $('.toggle_model').toggle(function(e) {
    e.preventDefault();
    // hide the graphics
    $('.left').setWidth(12);
    $('.right').hideDiv();
    $(this).html('Show Graphics');
  }, function(e) {
    e.preventDefault();
    // show the graphics
    $('.left').setWidth(3);
    $('.right').setWidth(9).showDiv();
    $(this).html('Hide Graphics');
  });
  
  $('.toggle_facts').toggle(function(e) {
    e.preventDefault();
    // show facts, hide text, split between model and facts
    $('.left').hideDiv();
    $('.facts').setWidth(6).showDiv();
    $('.right').setWidth(6);
    $(this).html('Hide Facts');
  }, function(e) {
    e.preventDefault();
    $('.left').setWidth(3).showDiv();
    $('.facts').hideDiv();
    $('.right').setWidth(9);
    $(this).html('Show Facts');
  });
  
  $.fn.setWidth = function(width) {
    var i = 0;
    for(i=1; i<=12; i++)
      $(this).removeClass('span' + i);
    $(this).addClass('span' + width.toString());
    return $(this);
  }
  
  $.fn.showDiv = function() {
    $(this).removeClass('hidden');
    return $(this);
  }
  
  $.fn.hideDiv = function() {
    $(this).addClass('hidden');
    return $(this);
  }
});