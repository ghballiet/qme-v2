$(document).ready(function() {
  $('span.help-inline.error').each(function() {
    $(this).parents('div.control-group').addClass('error');
  });
});