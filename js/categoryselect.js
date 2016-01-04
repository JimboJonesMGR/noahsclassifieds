$JQ.extend($JQ.noah, {
    addNextSelectRow: function(url, subCategoryLabel, tableId)
    {
        $JQ.noah.addNextSelectRowCore = function()
        {
            var cid = this.options[this.selectedIndex].value;
            var allowAd = $JQ(this.options[this.selectedIndex]).attr('rel');
            if( typeof allowAd=='undefined' ) allowAd=0;
            var container = $JQ(this).closest('tr');
            var rows = $JQ('#' + tableId + ' tbody').eq(0).find('tr');                    
            for( var i=rows.index(container)+1; i<rows.length; i++ ) rows.eq(i).remove();
            if( cid!=0 )
            {
                $JQ('#' + tableId + ' input:submit').hide();
                $JQ('#' + tableId + ' .submitfooter').append($JQ(loadingAnimation)); 
                $JQ.getJSON(url+cid, '', function(data){
                    $JQ('.loadingAnimation').remove();
                    if( data.fields!='' )
                    {
                        container.clone(true).insertAfter(container).find('select').html(data.fields).end()
                                                                    .find('.label').html(subCategoryLabel);                            
                    }
                    if( data.allowAd=='1' ) 
                    {
                        $JQ('#' + tableId + ' input:submit').eq(0).show();
                    }
                    else 
                    {
                        $JQ('#' + tableId + ' input:submit').eq(0).hide();
                        $JQ('#' + tableId + ' input:submit').eq(1).show();
                    }
                });
            }
            else
            {
                if( allowAd==0 ) 
                {
                    $JQ('#' + tableId + ' input:submit').eq(0).hide();
                    $JQ('#' + tableId + ' input:submit').eq(1).show();
                }     
                else
                {
                    $JQ('#' + tableId + ' input:submit').eq(0).show();
                    $JQ('#' + tableId + ' input:submit').eq(1).hide();
                }     
            }
        }
    },
    cascadingSelectOnLoad: function(tableId)
    {
        $JQ('[id^=cid]').live('change', $JQ.noah.addNextSelectRowCore);    
        $JQ('#' + tableId + ' input:submit').eq(0).click(function(e){
            var selects = $JQ(e.target).closest('form').find('select:[name=cid]');
            var select = selects[selects.length-1];
            var cid = select.options[select.selectedIndex].value;
            if( cid==0 )
            {
                select = selects[selects.length-2];
                cid = select.options[select.selectedIndex].value;
            }
            if( !cid ) return true;
            var href = location.href;
            location.href = href.replace(/\/?\d*$/, '/'+cid);
            return false;
        });
    },

    simpleCategoryReload: function()
    {
        $JQ('#cid').change(function (){
            var cid = this.options[this.selectedIndex].value;
            var href = location.href;
            location.href = href.replace(/\/?\d*$/, '/'+cid);
        });  
    }
});
