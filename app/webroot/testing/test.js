$(document).ready(function() {
  var dragGroup = d3.behavior.drag()
    .on('dragstart', function(d, i) {
      d3.select(this).call(fadeOut);
      d3.select('.link').remove();
    })
    .on('drag', function(d, i) {
      d.x += d3.event.dx;
      d.y += d3.event.dy;
      d3.select(this).attr('transform', 'translate(' + d.x + ',' + d.y + ')');
    })
    .on('dragend', function() {
      d3.select(this).call(fadeIn);
      drawLinks();
    });
  
  var dragEntity = d3.behavior.drag()
    .on('dragstart', function(d, i) {
      d3.select(this).call(fadeOut);
      d3.select('.link').remove();
    })
    .on('drag', function(d, i) {
      d.x += d3.event.dx;
      d.y += d3.event.dy;
      item = d3.select(this);
      item.attr('transform', 'translate(' + d.x + ',' + d.y + ')');
      item.attr('x', d.x);
      item.attr('y', d.y);
    })
    .on('dragend', function() {
      d3.select(this).call(fadeIn);
      drawLinks();
    });
  
  function fadeOut(item) {
    item.attr('opacity', 0.5);
  }
  
  function updateLinks(id, x, y) {
    var startLinks = getStartLinks(id);
    var endLinks = getEndLinks(id);
  }
  
  function getStartLinks(id) {
    return d3.select('.link[data-start="' + id + '"]');
  }
  
  function getEndLinks(id) {
    return d3.select('.link[data-end="' + id + '"]');
  }
  
  function fadeIn(item) {
    item.transition().duration(200).attr('opacity', 1.0);
  }
  
  var svg = d3.select('#canvas').append('svg');
  
  function drawPlace(parent, json) {
    var data = parent.selectAll('g.place').data(json);
    var place = data.enter().append('g')
        .attr('class', 'place')
        .attr('data-id', function(d) { return d.id; })
        .attr('data-name', function(d) { return d.name; })
        .attr('opacity', 1.0)
        .call(dragGroup);

    place.append('rect')
      .attr('width', function(d) { return d.width; })
      .attr('height', function(d) { return d.height; })
      .attr('x', function(d) { return d.x; })
      .attr('y', function(d) { return d.y; });
    
    place.append('text')
      .attr('text-anchor', 'middle')
      .attr('x', function(d) { return d.x + (d.width / 2) })
      .attr('y', function(d) { return d.y; })
      .attr('dy', '1.2em')
      .text(function(d) { return d.name; });
    
    // draw entities
    var entities = place.filter(function(d) { return d.entities; });
    if(entities[0].length > 0)
      entities.call(drawEntities, entities.datum().entities);
    
    // draw children places
    var parents = place.filter(function(d) { return d.children; });
    if(parents[0].length > 0)
      parents.call(drawPlace, parents.datum().children);
  }
  
  function drawEntities(parent, json) {
    var data = parent.selectAll('g.entity').data(json);
    var entity = data.enter().append('g')
      .attr('class', function(d) { return 'entity ' + d.type; })
      .attr('data-id', function(d) { return d.id; })
      .attr('data-name', function(d) { return d.name; })
      .attr('opacity', 1.0)
      .call(dragEntity);

    entity.append('rect')
      .attr('width', function(d) { return d.width; })
      .attr('height', function(d) { return d.height; });
      // .attr('x', function(d) { return d.x; })
      // .attr('y', function(d) { return d.y; });
    
    entity.append('text')
      .attr('text-anchor', 'middle')
      .attr('x', function(d) { return 50; })
      // .attr('y', function(d) { return d.y; })
      .attr('dy', '1.2em')
      .text(function(d) { return d.name; });
  }
  
  function getCentroid(id) {
    var data = d3.select('.entity[data-id="' + id + '"]').datum();
    var x = data.x;
    var y = data.y;
    var w = data.width;
    var h = data.height;
    var cx = data.x + (data.width / 2);
    var cy = data.y + (data.height / 2);
    return { x: cx, y: cy };
  }
  
  function drawLink(json) {
    var diagonal = d3.svg.diagonal()
      .source(function(d, i) {
        return getCentroid(d.start);
      })
      .target(function(d, i) {
        return getCentroid(d.end);
      });
    

    var data = svg.selectAll('path.link').data(json);
    var link = data.enter().append('path')
      .attr('class', function(d) { return 'link ' + d.type; })
      .attr('data-start', function(d) { return d.start; })
      .attr('data-end', function(d) { return d.end; })
      .attr('d', diagonal);
  }
      
  function doDrawing() {  
    d3.json('data.json', function(json) {
      drawPlace(svg, json.entities);
    });
    
    drawLinks();
  }
  
  function drawLinks() {
    d3.json('data.json', function(json) {
      drawLink(json.links);
    });
  }
  
  doDrawing();
});