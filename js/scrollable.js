$JQ.extend($JQ.noah, {
    globalScrollableOnLoad: function()
    {
        $JQ('div.items, a.next, a.prev').show(); 
        if( $JQ('div.items .item').length > 4 ) $JQ('a.next, a.prev').show(); 
        // centering the navi:
        $JQ('div.item').hover(function(){
            $JQ(this).find('.title').addClass('activeTitle');
            $JQ(this).find('.inner, .label, .cell, .picture').addClass('activeDesc');
        }, function() {
            $JQ(this).find('.title').removeClass('activeTitle');
            $JQ(this).find('.inner, .label, .cell, .picture').removeClass('activeDesc');
        });
        $JQ('.item .inner').jScrollPane();
    },
    scrollableOnLoad: function(id, elementName, scrollableParams)
    {
        eval('var paramObject = {'+scrollableParams+'};');
        var naviDiv = $JQ('#scrollable' + id + '_' + elementName).scrollable(paramObject).find('div.navi');
        naviDiv.css('width', (naviDiv.find('span').length * 14) + 'px').center({horizontal: true, vertical: false}); 
    },
    advanceScrollable: function( which )
    {                
        var api = $JQ('#scrollable' + which).scrollable();
        var status = api.getStatus(); 
        if( status.size>status.total ) return;  // too few elements
        var dir = eval('autoScrollDir' + which);
        if( dir=='right' )
        {
            if( status.index == status.total - status.size )
            {
                eval('autoScrollDir' + which + ' = \"left\";');
                api.prev();
            }
            else api.next();
        }
        else
        {
            if( status.index == 0 )
            {
                eval('autoScrollDir' + which + ' = \"right\";');
                api.next();
            }
            else api.prev();
        }
    },
    autoscrollOnLoad: function( id, elementName, autoScroll )
    {                
        eval('autoScrollDir' + id + '_' + elementName + ' = "right";');
        setInterval( '$JQ.noah.advanceScrollable("' + id + '_' + elementName + '")', 1000 * autoScroll);
    }
});
