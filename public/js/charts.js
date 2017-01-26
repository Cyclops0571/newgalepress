$(document).ready(function(){        
    
 
    
    
    
    function labelFormatter(label, series) {
        return "<div style='text-shadow: 1px 2px 1px rgba(0,0,0,0.2); font-size: 11px; text-align:center; padding:2px; color: #FFF; line-height: 13px;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
    }
    
    function showTooltip(x, y, contents) {
        $('<div class="ftooltip">' + contents + '</div>').css({
            position: 'absolute',
            'z-index': '10',
            display: 'none',
            top: y - 20,
            left: x,            
            padding: '3px',
            'background-color': 'rgba(0,0,0,0.5)',
            'font-size': '11px',
            'border-radius': '3px',
            color: '#FFF'            
        }).appendTo("body").fadeIn(200);
    }    

    var previousPoint = null;
    
 
    $("#chart_bar_1,#chart_bar_2,#chart_line_1,#dash_chart_1,#dash_chart_2,#chart_user_1").bind("plothover", function (event, pos, item) {
        
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));

        if (item) {
            if (previousPoint != item.dataIndex) {
                previousPoint = item.dataIndex;

                $(".ftooltip").remove();
                var x = item.datapoint[0].toFixed(2),
                    y = item.datapoint[1].toFixed(2);

                showTooltip(item.pageX, item.pageY,
                            item.series.label + ": " + y);
            }
        }else {
            $(".ftooltip").remove();
            previousPoint = null;            
        }

    });    
    
    
});

$(window).resize(function(){

});