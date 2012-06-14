// Draws places in the model SVG, using the D3 JavaScript drawing
// library.
// 
// @author Glen Hunt <glenrhunt@gmail.com>
// @see http://d3js.org



function Place(svg, data) {
  this.svg = svg;
  this.data = data;
}



// actually draws the places
Place.prototype.draw = function() {
  var place = this.svg.selectAll('g.place').data(this.data)
    .enter().append('g')
    .attr('class', function(d) { return 'place place' + d.id; })
    .attr('opacity', 1.0)
    .attr('data-id', function(d) { return d.id; })
    .attr('data-parent', function(d) { return d.parent ? d.parent : null; })
    .attr('transform', function(d) { return 'translate(' + d.x + ',' + d.y + ')'; })
    .call(this.drag);

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
    .call(this.dragHandle);
  
  // reorganize the places (so that they're "in" the appropriate
  // spots)
  $('.place').each(function() {
    var data = $(this).data();
    if(data.parent && $('.place' + data.parent).length > 0) {
      var parent = $('.place' + data.parent);
      parent.append($(this));
    }
  });
}



// drag behavior for places
Place.prototype.dragPlace = function() {
  var place = this;
  var behavior = d3.behavior.drag()
    .on('dragstart', function() {
      d3.select(this).call(place.startDrag);
    })
    .on('drag', function(d, i) {
      d.x += d3.event.dx;
      d.y += d3.event.dy;
      d3.select(this).attr('transform', 'translate(' + d.x + ',' + d.y + ')');
    })
    .on('dragend', function() {
      d3.select(this).call(place.startDrag);
    });
  return behavior; 
}



// drag behavior for place handles
Place.prototype.dragHandle = function() {
  var place = this;
  var behavior = d3.behavior.drag()
    .on('dragstart', function() {
    })
    .on('drag', function(d, i) {
      // select the right items
      var item = d3.select(this);
      var group = item.attr('group');
      var rect = place.svg.select('.' + group + ' rect');
      var text = place.svg.select('.' + group + ' text');

      // compute the new values
      var width = parseInt(rect.attr('width')) + d3.event.dx;
      var height = parseInt(rect.attr('height')) + d3.event.dy;
      var cx = parseInt(item.attr('cx')) + d3.event.dx;
      var cy = parseInt(item.attr('cy')) + d3.event.dy;
      var r = parseInt(item.attr('r'));
      
      if(width > 50 && height > 50) {
        // update the attributes
        item.attr('cx', cx).attr('cy', cy);
        rect.attr('height', height).attr('width', width);
        text.attr('x', width / 2);        
      }
    })
    .on('dragend', function(d, i) {
      var item = d3.select(this);
      var group_id = item.attr('group');
      var group = place.svg.select('.' + group);
      var rect = place.svg.select('.' + group_id + ' rect');
      var height = parseInt(rect.attr('height'));
      var width = parseInt(rect.attr('width'));
      var data = rect.datum();
      data.height = height;
      data.width = width;
      rect.datum(data);
      rect.call(place.save);
    });
  return behavior;
}


// called when a place is starting to be dragged (but before any
// actual movement occurs)
Place.prototype.startDrag = function() {
  // fade out
  // clear links (so they can be redrawn later)
}


// called when a place is done being dragged (on mouse up)
Place.prototype.endDrag = function() {
  // fade in
  // redraw links
}


// saves a place to the database
Place.prototype.save = function(item) {
  var data = item.datum();
  var arr = { Place: data };
  var url = '../../update_place';
  // startSaving();
  $.post(url, arr, function(response) {
    // endSaving();
    // console.log(response);
  });
}
