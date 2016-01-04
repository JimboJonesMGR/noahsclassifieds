jQuery(document).ready(function($) {
  // Rounded corners:
  
    curvyCorners({
        tl: { radius: 6 }, 
        tr: { radius: 6 }, 
        bl: { radius: 0 }, 
        br: { radius: 0 }}, '#userStatusBar'); 
        
    curvyCorners({
        tl: { radius: 4 }, 
        tr: { radius: 4 }, 
        bl: { radius: 4 }, 
        br: { radius: 4 }}, '.loginMenu');
         
    curvyCorners({
        tl: { radius: 0 }, 
        tr: { radius: 0 }, 
        bl: { radius: 6 }, 
        br: { radius: 6 }}, '#infoTextBar'); 
    curvyCorners({
        tl: { radius: 4 }, 
        tr: { radius: 4 }, 
        bl: { radius: 4 }, 
        br: { radius: 4 }}, '.friend'); 

});

var loadingAnimation = "<img class='loadingAnimation' src='themes/modern/images/loadingAnimation.gif' width=208 height=13 style='border:0px;'>";

$JQ.extend($JQ.noah, {
    addCurvyCornersToPresentationDivs: function()
    {
        // the latest version of curvycorners doesn't work on captions in Firefox from some reason:
        if( !$JQ.browser.mozilla )
        {
            /*
	        $JQ('div.template').livequery(function(){curvyCorners({
	            tl: { radius: 6 }, 
	            tr: { radius: 6 }, 
	            bl: { radius: 0 }, 
	            br: { radius: 0 }}, $JQ(this).find('caption').get(0));});*/
        }
    }
});
