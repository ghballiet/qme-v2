$(document).ready(function() { 
  var json = {
    places: [
      { id: 1, name: 'cell', x: 20, y: 30, width: 500, height: 400 },
      { id: 2, name: 'lysosome', parent: 1, x: 40, y: 50, width: 200, height: 250 },
      { id: 3, name: 'cytoplasm', parent: 1, x: 200, y: 50, width: 200, height: 250 },
      { id: 4, name: 'nucleus', parent: 3, x: 20, y: 20, width: 150, height: 150 }
    ],
    entities: [
      { id: 1, name: 'mitochondria', type: 'transient', x: 20, y: 20, location: 4 },
      { id: 2, name: 'ribosome', type: 'stable', x: 20, y: 20, location: 2 },
      { id: 3, name: 'ROS', type: 'transient', x: 30, y: 30, location: 3 }
    ],
    links: [
      { id: 1, start: { id: 1, pos: {} }, end: { id: 2, pos: {} }, type: 'increases' }, 
      { id: 2, start: { id: 2, pos: {} }, end: { id: 3, pos: {} }, type: 'decreases' }
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
    clearLinks();
  }
  
  
  function endDrag(item) {
    fadeIn(item);
    drawLinks();
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
      
      // update the attributes
      item.attr('cx', cx).attr('cy', cy);
      rect.attr('height', height).attr('width', width);
      text.attr('x', width / 2);
    });
  
  var dragEntity = d3.behavior.drag()
    .on('dragstart', function() {
      clearLinks();
    })
    .on('drag', function(d, i) {
      d.x += d3.event.dx;
      d.y += d3.event.dy;
      d3.select(this).attr('transform', 'translate(' + d.x + ',' + d.y + ')');
    })
    .on('dragend', function() {
      drawLinks();
    });
    
  // ---- entry point ----
  function init() {
    svg = d3.select('#canvas').append('svg');
    
    // draw the shapes
    drawPlaces();
    drawEntities();
    drawMarkers();
    drawLinks();
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
      .attr('r', 7)
      .attr('cx', function(d) { return d.width; })
      .attr('cy', function(d) { return d.height; })
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
    var entity_width = 100;
    var entity_height = 30;

    var entity = svg.selectAll('g.entitiy').data(json.entities)
      .enter().append('g')
        .attr('class', function(d) { return 'entity entity' + d.id + ' ' + d.type; })
        .attr('opacity', 1.0)
        .attr('data-id', function(d) { return d.id; })
        .attr('data-location', function(d) { return d.location; })
        .attr('transform', function(d) { return 'translate(' + d.x + ',' + d.y + ')'; })
        .call(dragEntity);
    
    entity.append('rect')
      .attr('width', entity_width)
      .attr('height', entity_height);
    
    entity.append('text')
      .attr('text-anchor', 'middle')
      .attr('x', entity_width / 2)
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
  
  function drawMarkers() {
    // draws the triangles used as endpoints for lines
    // markers don't inherit styles, so we have to add one per type
    svg.append('defs').selectAll('marker')
      .data(['increases', 'decreases', 'does-not-change'])
      .enter().append('marker')
        .attr('id', String)
        .attr('viewBox', '0 -5 10 10')
        .attr('refX', 0)
        .attr('refY', 0)
        .attr('markerWidth', 4)
        .attr('markerHeight', 4)
        .attr('orient', 'auto')
      .append('path')
        .attr('d', 'M0,-5L10,0L0,5');
  }
  
  function drawLinks() {
    // start by replacing the start and end coordinates in the data
    // with the centroid    
    for(var i in json.links) {
      var link = json.links[i];
      var start_id = link.start.id;
      var end_id = link.end.id;
      var start_centroid = getCentroid(start_id);
      var end_centroid = getCentroid(end_id);
      var start_node = $('.entity[data-id="' + start_id + '"]');
      var end_node = $('.entity[data-id="' + end_id + '"]');
      
      // now, compute the entry and exit points depending upon the 
      // relative positions of the centroids
      if(start_centroid.y <= end_centroid.y) {
        // use the bottom
        var y = start_node.offset().top + parseInt(start_node.attr('height'));
        start_centroid.y = y;        
      } else {
        start_centroid.y = start_node.offset().top;
      }
      
      // update the json data
      link.start.pos = start_centroid;
      link.end.pos = end_centroid;
    }
        
    // build the line factory
    var diagonal = d3.svg.diagonal()
      .source(function(d, i) { return d.start.pos; })
      .target(function(d, i) { return d.end.pos; });
    
    var link = svg.selectAll('path.link').data(json.links)
      .enter().append('path')
      .attr('class', function(d) { return 'link ' + d.type; })
      .attr('data-start', function(d) { return d.start.id; })
      .attr('data-end', function(d) { return d.end.id; })
      .attr('data-type', function(d) { return d.type; })
      .attr('opacity', 0.0)
      .attr('d', diagonal)
      .attr('marker-end', function(d) { return 'url(#' + d.type + ')'; });
  }
  
  function clearLinks() {
    d3.selectAll('path.link').remove();
  }
  
  function getCentroid(id) {
    var selector = '.entity[data-id="' + id + '"]';
    var entity = d3.select(selector);
    var rect = d3.select(selector + ' rect');
    var data = entity.datum();
    var x = $(selector).offset().left - 12;
    var y = $(selector).offset().top - 12;
    var w = parseInt(rect.attr('width'));
    var h = parseInt(rect.attr('height'));
    
    // compute the centroid
    var cx = x + (w / 2);
    var cy = y + (h / 2);    
    return { x: cx, y: cy };
  }
  
  init();
});