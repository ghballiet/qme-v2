$(document).ready(function() {
  // click event for places
  $('ul.nav li.place a').live('click', function(e) {
    e.preventDefault();
    $(this).editPlace();
  });
  
  // click event for entities
  $('ul.nav li.entity a').live('click', function(e) {
    e.preventDefault();
    $(this).editEntity();
  });
  
  // click event for links
  
  $.fn.editPlace = function() {
    var data = $(this).data();
    var name = $('#edit_place #PlaceName');
    var parent = $('#edit_place #PlaceParentId');    
    var id = $('#edit_place #PlaceId');
    
    // copy over place data (without the current place, since places
    // cannot be located within themselves)
    var options = $('#add_place #PlaceParentId option[value!="' + 
      data.id + '"]').clone();
    parent.html(options);

    id.val(data.id);
    name.val(data.name);    
    parent.val(data.parent == '' ? 0 : data.parent);
    
    // update the delete url
    var delete_url = $('#edit_place .btn-delete').attr('href');
    delete_url = delete_url.replace(/\/delete_place.*/,
      '/delete_place/' + data.id);
    $('#edit_place .btn-delete').attr('href', delete_url);
        
    $('#edit_place').modal();
  }
  
  $.fn.editEntity = function() {
    var data = $(this).data();
    console.log(data);
    var name = $('#edit_entity #EntityName');    
    var place = $('#edit_entity #EntityPlaceId');
    var type = $('#edit_entity #EntityType');
    var id = $('#edit_entity #EntityId');
    
    id.val(data.id);
    name.val(data.name);
    place.val(data.placeId);
    type.val(data.type);
    
    // update the delete url
    var delete_url = $('#edit_entity .btn-delete').attr('href');
    delete_url = delete_url.replace(/\/delete_entity.*/, 
      '/delete_entity/' + data.id);
    $('#edit_entity .btn-delete').attr('href', delete_url);
    
    $('#edit_entity').modal();
  }
});