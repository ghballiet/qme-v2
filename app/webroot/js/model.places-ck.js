// Draws places in the model SVG, using the D3 JavaScript drawing
// library.
// 
// @author Glen Hunt <glenrhunt@gmail.com>
// @see http://d3js.org
function Place(a,b){this.svg=a;this.data=b}Place.prototype.draw=function(){var a=this.svg.selectAll("g.place").data(this.data).enter().append("g").attr("class",function(a){return"place place"+a.id}).attr("opacity",1).attr("data-id",function(a){return a.id}).attr("data-parent",function(a){return a.parent?a.parent:null}).attr("transform",function(a){return"translate("+a.x+","+a.y+")"}).call(this.drag);a.append("rect").attr("width",function(a){return a.width}).attr("height",function(a){return a.height});a.append("text").attr("text-anchor","middle").attr("x",function(a){return a.width/2}).attr("dy","1.6em").text(function(a){return a.name});a.append("circle").attr("r",7).attr("cx",function(a){return a.width}).attr("cy",function(a){return a.height}).attr("group",function(a){return"place"+a.id}).call(this.dragHandle);$(".place").each(function(){var a=$(this).data();if(a.parent&&$(".place"+a.parent).length>0){var b=$(".place"+a.parent);b.append($(this))}})};Place.prototype.dragPlace=function(){var a=this,b=d3.behavior.drag().on("dragstart",function(){d3.select(this).call(a.startDrag)}).on("drag",function(a,b){a.x+=d3.event.dx;a.y+=d3.event.dy;d3.select(this).attr("transform","translate("+a.x+","+a.y+")")}).on("dragend",function(){d3.select(this).call(a.startDrag)});return b};Place.prototype.dragHandle=function(){var a=this,b=d3.behavior.drag().on("dragstart",function(){}).on("drag",function(b,c){var d=d3.select(this),e=d.attr("group"),f=a.svg.select("."+e+" rect"),g=a.svg.select("."+e+" text"),h=parseInt(f.attr("width"))+d3.event.dx,i=parseInt(f.attr("height"))+d3.event.dy,j=parseInt(d.attr("cx"))+d3.event.dx,k=parseInt(d.attr("cy"))+d3.event.dy,l=parseInt(d.attr("r"));if(h>50&&i>50){d.attr("cx",j).attr("cy",k);f.attr("height",i).attr("width",h);g.attr("x",h/2)}}).on("dragend",function(b,c){var d=d3.select(this),e=d.attr("group"),f=a.svg.select("."+f),g=a.svg.select("."+e+" rect"),h=parseInt(g.attr("height")),i=parseInt(g.attr("width")),j=g.datum();j.height=h;j.width=i;g.datum(j);g.call(a.save)});return b};Place.prototype.startDrag=function(){};Place.prototype.endDrag=function(){};Place.prototype.save=function(a){var b=a.datum(),c={Place:b},d="../../update_place";$.post(d,c,function(a){})};