$JQ = jQuery.noConflict();
$JQ.noah = {
    themeSelectorWidget: function(what, base)
    {
        $JQ('#'+what+'SelectorWidget').change(function(){
            var newSelection = this.options[this.selectedIndex].value;
            if( newSelection!=0 )
            {
                createCookie('noah'+what,newSelection,500);
                document.location=base;
            }
        });
    }
};
