var base_url = window.location.origin;
//Dashboard 1 Morris-chart
$(function () {
    "use strict";
	// Morris bar chart
    var agent = $('.agent').val();
    var month = $('.inq_month').val();
     $.ajax({
        url: base_url+"/inquiry/inq_bar_graph",
        data:{
            agent : agent,
            month : month
        },
        type:"post",
        dataType:"json",
        success: function(output){
            function parseSVG(s) {
                var div= document.createElementNS('http://www.w3.org/1999/xhtml', 'div');
                div.innerHTML= '<svg xmlns="http://www.w3.org/2000/svg">'+s+'</svg>';
                var frag= document.createDocumentFragment();
                while (div.firstChild.firstChild)
                    frag.appendChild(div.firstChild.firstChild);
                return frag;
            }
            var dat = output.results ;
            Morris.Bar({
                element: 'morris-bar-chart',
                data: dat,
                xkey: 'name',
                ykeys: ['mature', 'unmature','open','closed'],
                labels: ['Mature', 'Un Mature', 'Open', 'Closed'],
                barColors:['#00c292', '#e46e76','#03a9f3','#f7d873'],
                hideHover: 'auto',
                gridLineColor: '#eef0f2',
                resize: true,
                labelTop: true
            });
            var items = $("#morris-bar-chart").find( "svg" ).find("rect");
            var counter = 0;
            var newarray = [];
            $.each(dat,function(index,secarr){
                $.each(secarr,function(index2,v){
                    if(index2 !== 'name'){
                        newarray[counter] = v ;
                        counter++;
                    }
                });
            });
            $.each(items,function(index,v){
                var value = newarray[index];
                var newY = parseFloat( $(this).attr('y') - 20 );
                var halfWidth = parseFloat( $(this).attr('width') / 2 );
                var newX = parseFloat( $(this).attr('x') ) +  halfWidth;
                var res = '<text style="text-anchor: middle; font: 12px sans-serif;" x="'+newX+'" y="'+newY+'" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" font-size="12px" font-family="sans-serif" font-weight="normal" transform="matrix(1,0,0,1,0,6.875)"><tspan dy="3.75">'+value+'</tspan></text>';
                $("#morris-bar-chart").find( "svg" ).append(parseSVG(res));
            });
        }
    });
});
$(document).ready(function() {
	var sparklineLogin = function() { 
        var agent = $('.agent').val();
        var month = $('.inq_month').val();
		$.ajax({
            url: base_url+"/inquiry/inq_report_graph",
            data:{
            	agent : agent,
                month : month
            },
            type:"post",
            dataType:"json",
            success: function(output){
            	$("#mature_graph").sparkline(output.mature, {
			        type: 'line',
			        width: '100%',
			        height: '50',
			        lineColor: '#00c292',
			        fillColor: '#00c292',
                    minSpotColor:'#03a9f3',
                    maxSpotColor: '#03a9f3',
			        highlightLineColor: 'rgba(0, 0, 0, 0.2)',
			        highlightSpotColor: '#00c292'
			    });
			    $("#unmature_graph").sparkline(output.un_mature, {
			        type: 'line',
			        width: '100%',
			        height: '50',
			        lineColor: '#e46e76',
			        fillColor: '#e46e76',
			        minSpotColor:'#03a9f3',
			        maxSpotColor: '#03a9f3',
			        highlightLineColor: 'rgba(0, 0, 0, 0.2)',
			        highlightSpotColor: '#e46e76'
			    });
			    $("#open_graph").sparkline(output.open, {
			        type: 'line',
			        width: '100%',
			        height: '50',
			        lineColor: '#03a9f3',
			        fillColor: '#03a9f3',
                    minSpotColor:'#03a9f3',
                    maxSpotColor: '#03a9f3',
			        highlightLineColor: 'rgba(0, 0, 0, 0.2)',
			        highlightSpotColor: '#03a9f3'
			    });
                $("#cls_graph").sparkline(output.closed, {
                    type: 'line',
                    width: '100%',
                    height: '50',
                    lineColor: '#f7d873',
                    fillColor: '#f7d873',
                    minSpotColor:'#03a9f3',
                    maxSpotColor: '#03a9f3',
                    highlightLineColor: 'rgba(0, 0, 0, 0.2)',
                    highlightSpotColor: '#f7d873'
                });
            }
        });
    }
    var sparkResize; 
    $(window).resize(function(e) {
        clearTimeout(sparkResize);
        sparkResize = setTimeout(sparklineLogin, 500);
    });
    sparklineLogin();
});