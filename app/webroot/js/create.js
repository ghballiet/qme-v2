$(document).ready(function() {
  $('#QmodelName').keypress(function(e) {
    var str = String.fromCharCode(e.which);
    if(str.match(/\W/g) != null && str != '-' && str != ' ')
      e.preventDefault();
    var val = $(this).val().toLowerCase();
    val = val.replace(/\s+/g, ' ').trim();
    val = val.replace(/ /g, '-');
    $('#QmodelShortName').val(val);
  });
});
