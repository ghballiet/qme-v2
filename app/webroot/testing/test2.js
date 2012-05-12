$(document).ready(function() { 
  var json = {
    places: [
      { id: 1, name: 'cell', x: 20, y: 30, width: 500, height: 400 },
      { id: 2, name: 'lysosome', parent: 1, x: 40, y: 50, width: 200, height: 250 },
      { id: 3, name: 'cytoplasm', parent: 1, x: 200, y: 50, width: 200, height: 250 },
      { id: 4, name: 'nucleus', parent: 3, x: 20, y: 20, width: 150, height: 150 }
    ],
    entities: [
      { id: 1, name: 'mitochondria', type: 'transient', x: 20, y: 20, location: 4 }
    ]
  }
  var svg = null;
  
  function fadeOut(item) {
    item.attr('opacity', 0.5);
  }
  
  function fadeIn(item) {
    item.transition().duration(200).attr('opacity', 1.0);
  }

  function startDrag(item) {
    fadeOut(item);
  }
  
  
  function endDrag(item) {
    fadeIn(item);
  }
  

  // ---- draggable ----
  var dragPlace = d3.behavior.drag()
    .on('dragstart', function() {
      d3.select(this).call(startDrag);
    })
    .on('drag', function(d, i) {
      d.x += d3.event.dx;
      d.y += d3.event.dy;
      d3.select(this).attr('transform', 'translate(' + d.x + ',' + d.y + ')');
    })
    .on('dragend', function() {
      d3.select(this).call(endDrag);
    });
  
  var dragHandle = d3.behavior.drag()
    .on('dragstart', function() {
    })
    .on('drag', function(d, i) {
      // select the right items
      var item = d3.select(this);
      var group = item.attr('group');
      var rect = d3.select('.' + group + ' rect');
      var text = d3.select('.' + group + ' text');

      // compute the new values
      var width = parseInt(rect.attr('width')) + d3.event.dx;
      var height = parseInt(rect.attr('height')) + d3.event.dy;
      var cx = parseInt(item.attr('cx')) + d3.event.dx;
      var cy = parseInt(item.attr('cy')) + d3.event.dy;
      var r = parseInt(item.attr('r'));
      
      // make sure we're within reasonable limits
      if(width < r + 5 || height < r + 5)
        return false;
      
      // update the attributes
      item.attr('cx', cx).attr('cy', cy);
      rect.attr('height', height).attr('width', width);
      text.attr('x', width / 2);
    });
  
  var dragEntity = d3.behavior.drag()
    .on('dragstart', function() {
      
    })
    .on('drag', function(d, i) {
      
    })
    .on('dragend', function() {
      
    });
    
  // ---- entry point ----
  function init() {
    svg = d3.select('#canvas').append('svg');
    
    // draw the shapes
    drawPlaces();
    drawEntities();
  }
  
  function drawPlaces() {
    var place = svg.selectAll('g.place').data(json.places)
      .enter().append('g')
        .attr('class', function(d) { return 'place place' + d.id; })
        .attr('opacity', 1.0)
        .attr('data-id', function(d) { return d.id; })
        .attr('data-parent', function(d) { return d.parent ? d.parent : null; })
        .attr('transform', function(d) { return 'translate(' + d.x + ',' + d.y + ')'; })
        .call(dragPlace);

    place.append('rect')
      .attr('width', function(d) { return d.width; })
      .attr('height', function(d) { return d.height; })

    place.append('text')
      .attr('text-anchor', 'middle')
      .attr('x', function(d) { return d.width / 2 })
      .attr('dy', '1.6em')
      .text(function(d) { return d.name; });
  
    place.append('circle')
      .attr('r', 10)
      .attr('cx', function(d) { return d.width - 15; })
      .attr('cy', function(d) { return d.height - 15; })
      .attr('group', function(d) { return 'place' + d.id; })
      .call(dragHandle);
      
    // reorganize the places
    $('.place').each(function() {
      var data = $(this).data();
      if(data.parent && $('.place' + data.parent).length > 0) {
        var parent = $('.place' + data.parent);
        parent.append($(this));
      }
    });        
  }
  
  function drawEntities() {
    var entity = svg.selectAll('g.entitiy').data(json.entities)
      .enter().append('g')
        .attr('class', function(d) { return 'entity entity' + d.id + ' ' + d.type; })
        .attr('opacity', 1.0)
        .attr('data-id', function(d) { return d.id; })
        .attr('data-location', function(d) { return d.location; })
        .attr('transform', function(d) { return 'translate(' + d.x + ',' + d.y + ')'; })
        .call(dragEntity);
    
    entity.append('rect')
      .attr('width', 200)
      .attr('height', 50);
    
    entity.append('text')
      .attr('text-anchor', 'middle')
      .attr('x', 100)
      .attr('dy', '1.6em')
      .text(function(d) { return d.name; });
    
    // reorganize the entities
    $('.entity').each(function() {
      var data = $(this).data();
      if($('.place' + data.location).length > 0) {
        var parent = $('.place' + data.location);
        parent.append($(this));
      }
    });
  }
  
  init();
});