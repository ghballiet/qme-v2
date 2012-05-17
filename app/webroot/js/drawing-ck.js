$(document).ready(function(){function b(){d3.select("circle.saving").transition().duration(250).attr("opacity",1)}function c(){d3.select("circle.saving").transition().duration(250).attr("opacity",0)}function d(a){a.attr("opacity",.5)}function e(a){a.transition().duration(200).attr("opacity",1)}function f(a){d(a);r()}function g(a){e(a);h(a);q()}function h(a){var d=a.datum(),e={Place:d},f="../../update_place";b();$.post(f,e,function(a){c()})}function i(a){var d=a.datum(),e={Entity:d},f="../../update_entity";b();$.post(f,e,function(a){c()})}function m(){a=d3.select("#canvas").append("svg");var b=a.selectAll("circle.saving").data([{cx:15,cy:15,r:5}]).enter().append("circle").attr("class","saving").attr("opacity",0).attr("cx",function(a){return a.cx}).attr("cy",function(a){return a.cy}).attr("r",function(a){return a.r});n();o();p();q()}function n(){var b=a.selectAll("g.place").data(json.places).enter().append("g").attr("class",function(a){return"place place"+a.id}).attr("opacity",1).attr("data-id",function(a){return a.id}).attr("data-parent",function(a){return a.parent?a.parent:null}).attr("transform",function(a){return"translate("+a.x+","+a.y+")"}).call(j);b.append("rect").attr("width",function(a){return a.width}).attr("height",function(a){return a.height});b.append("text").attr("text-anchor","middle").attr("x",function(a){return a.width/2}).attr("dy","1.6em").text(function(a){return a.name});b.append("circle").attr("r",7).attr("cx",function(a){return a.width}).attr("cy",function(a){return a.height}).attr("group",function(a){return"place"+a.id}).call(k);$(".place").each(function(){var a=$(this).data();if(a.parent&&$(".place"+a.parent).length>0){var b=$(".place"+a.parent);b.append($(this))}})}function o(){var b=100,c=30,d=a.selectAll("g.entitiy").data(json.entities).enter().append("g").attr("class",function(a){return"entity entity"+a.id+" "+a.type}).attr("opacity",1).attr("data-id",function(a){return a.id}).attr("data-location",function(a){return a.location}).attr("transform",function(a){return"translate("+a.x+","+a.y+")"}).call(l);d.append("rect").attr("width",b).attr("height",c);d.append("text").attr("text-anchor","middle").attr("x",b/2).attr("dy","1.6em").text(function(a){return a.name});$(".entity").each(function(){var a=$(this).data();if($(".place"+a.location).length>0){var b=$(".place"+a.location);b.append($(this))}})}function p(){a.append("defs").selectAll("marker").data(["increases","decreases","does-not-change"]).enter().append("marker").attr("id",String).attr("viewBox","0 -5 10 10").attr("refX",0).attr("refY",0).attr("markerWidth",4).attr("markerHeight",4).attr("orient","auto").append("path").attr("d","M0,-5L10,0L0,5")}function q(){var b=$("#canvas").offset().left,c=$("#canvas").offset().top;for(var d in json.links){var e=json.links[d],f=e.start.id,g=e.end.id,h=s(f),i=s(g),j='.entity[data-id="'+f+'"]',k='.entity[data-id="'+g+'"]',l=$(j),m=$(k),n=d3.select(j+" rect"),o=d3.select(k+" rect"),p=l.offset().left-b,q=l.offset().top-c,r=m.offset().left-b,t=m.offset().top-c,u=parseInt(n.attr("height")),v=parseInt(n.attr("width")),w=parseInt(o.attr("height")),x=parseInt(o.attr("width")),y=d3.svg.diagonal().source(function(a,b){return a.start.pos}).target(function(a,b){return a.end.pos}),z=Math.abs(q-t)-w,A=Math.abs(p-r)-x;z<0&&(z=0);A<0&&(A=0);if(z<50)if(h.x<=i.x){h.x=p+v;i.x=r}else{h.x=p;i.x=r+x}else if(h.y<=i.y){h.y=q+u;i.y=t}else{h.y=q;i.y=t+w}json.links[d].start.pos=h;json.links[d].end.pos=i}var e=a.selectAll("line.link").data(json.links).enter().append("line").attr("class",function(a){return"link "+a.type}).attr("data-start",function(a){return a.start.id}).attr("data-start",function(a){return a.start.id}).attr("data-end",function(a){return a.end.id}).attr("data-type",function(a){return a.type}).attr("x1",function(a){return a.start.pos.x}).attr("x2",function(a){return a.end.pos.x}).attr("y1",function(a){return a.start.pos.y}).attr("y2",function(a){return a.end.pos.y}).attr("marker-end",function(a){return"url(#"+a.type+")"})}function r(){d3.selectAll("line.link").remove()}function s(a){var b='.entity[data-id="'+a+'"]',c=d3.select(b),d=d3.select(b+" rect"),e=c.datum(),f=$(b).offset().left,g=$(b).offset().top,h=parseInt(d.attr("width")),i=parseInt(d.attr("height")),j=f+h/2-7,k=g+i/2;return{x:j,y:k}}var a=null,j=d3.behavior.drag().on("dragstart",function(){d3.select(this).call(f)}).on("drag",function(a,b){a.x+=d3.event.dx;a.y+=d3.event.dy;d3.select(this).attr("transform","translate("+a.x+","+a.y+")")}).on("dragend",function(){d3.select(this).call(g)}),k=d3.behavior.drag().on("dragstart",function(){}).on("drag",function(a,b){var c=d3.select(this),d=c.attr("group"),e=d3.select("."+d+" rect"),f=d3.select("."+d+" text"),g=parseInt(e.attr("width"))+d3.event.dx,h=parseInt(e.attr("height"))+d3.event.dy,i=parseInt(c.attr("cx"))+d3.event.dx,j=parseInt(c.attr("cy"))+d3.event.dy,k=parseInt(c.attr("r"));c.attr("cx",i).attr("cy",j);e.attr("height",h).attr("width",g);f.attr("x",g/2)}).on("dragend",function(a,b){var c=d3.select(this),d=c.attr("group"),e=d3.select("."+e),f=d3.select("."+d+" rect"),g=parseInt(f.attr("height")),i=parseInt(f.attr("width")),j=f.datum();j.height=g;j.width=i;f.datum(j);f.call(h)}),l=d3.behavior.drag().on("dragstart",function(){d3.select(this).call(d);r()}).on("drag",function(a,b){a.x+=d3.event.dx;a.y+=d3.event.dy;d3.select(this).attr("transform","translate("+a.x+","+a.y+")")}).on("dragend",function(){d3.select(this).call(e).call(i);q()});m()});