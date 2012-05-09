$(document).ready(function() {
  $('#QmodelName').keyup(function(e) {
    var str = String.fromCharCode(e.keyCode);
    if(str.match(/\W/g) != null && str != '-' && str != ' ')
      e.preventDefault();
    var val = $(this).val();
    val = val.toLowerCase();
    val = val.replace(/\s+/g, ' ').trim();
    val = val.replace(/ /g, '-');
    $('#QmodelShortName').val(val);
  });
});