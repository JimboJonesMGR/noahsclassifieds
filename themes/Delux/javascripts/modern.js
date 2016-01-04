jQuery(document).ready(function($) {
  // Rounded corners:
  
    $('#userStatusBar').corner({
        tl: { radius: 6 }, 
        tr: { radius: 6 }, 
        bl: { radius: 0 }, 
        br: { radius: 0 },
        autoPad: false}); 
    $('.loginMenu').corner({
        tl: { radius: 4 }, 
        tr: { radius: 4 }, 
        bl: { radius: 4 }, 
        br: { radius: 4 },
        autoPad: false}); 
    $('#infoTextBar').corner({
        tl: { radius: 0 }, 
        tr: { radius: 0 }, 
        bl: { radius: 6 }, 
        br: { radius: 6 },
        autoPad: false}); 
    $('.friend').corner({
        tl: { radius: 4 }, 
        tr: { radius: 4 }, 
        bl: { radius: 4 }, 
        br: { radius: 4 },
        autoPad: false}); 

});

var loadingAnimation = "<img class='loadingAnimation' src='themes/modern/images/loadingAnimation.gif' width=208 height=13 style='border:0px;'>";

$JQ.extend($JQ.noah, {
    addCurvyCornersToPresentationDivs: function()
    {
        $JQ('div.template').livequery(function(){$JQ(this).corner({
            tl: { radius: 6 }, 
            tr: { radius: 6 }, 
            bl: { radius: 0 }, 
            br: { radius: 0 },
            autoPad: false});}); 
        $JQ('div.forCurvyFooter').livequery(function(){$JQ(this).corner({
            tl: { radius: 0 }, 
            tr: { radius: 0 }, 
            bl: { radius: 6 }, 
            br: { radius: 6 },
            autoPad: false});}); 
    }
});
