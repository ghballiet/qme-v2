$(document).ready(function() {
  $('.modal .btn-primary').live('click', function(e) {
      var form = $(this).parent().parent().find('form');
      form.submit();
      // var data = {};
      // var url = null;
      //   
      // $.map(form.serializeArray(), function(n, i) {
      //   if(n.name.match(/data\[.*\]\[url\]/))
      //     url = n.value;
      //   else
      //     data[n.name] = n.value;
      // });
      // 
      // $.post(url, data, function(response) {
      //   console.log(response);
      // });
    });
});