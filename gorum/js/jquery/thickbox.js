/*
 * Thickbox 3.1 - One Box To Rule Them All.
 * By Cody Lindley (http://www.codylindley.com)
 * Copyright (c) 2007 cody lindley
 * Licensed under the MIT License: http://www.opensource.org/licenses/mit-license.php
 
 * This version modified by thoppe http://www.tomhoppe.com to allow for larger image handling, click navigation, and better ui
 
*/
		  
var tb_pathToImage = "themes/modern/images/loadingAnimation.gif";
var x; // horizontal mouse position

//on page load call tb_init
jQuery(document).ready(function($) {
	tb_init('a.thickbox, area.thickbox, input.thickbox');//pass where to apply thickbox
	imgLoader = new Image();// preload image
	imgLoader.src = tb_pathToImage;
});

//add thickbox to href & area elements that have a class of .thickbox
function tb_init(domChunk){
	$JQ(domChunk).click(function(){
	var t = this.title || this.name || null;
	var a = this.href || this.alt;
	var g = this.rel || false;
	tb_show(t,a,g);
	this.blur();
	return false;
	});
}

function tb_show(caption, url, imageGroup) {//function called when the user clicks on a thickbox link

	try {
				
		if(document.getElementById("TB_overlay") === null){
			$JQ("body").append("<div id='TB_overlay'></div><div id='TB_window'></div>");
			$JQ("#TB_overlay").click(tb_remove);
		}
		
		if(tb_detectMacXFF()){
			$JQ("#TB_overlay").addClass("TB_overlayMacFFBGHack");//use png overlay so hide flash
		}else{
			$JQ("#TB_overlay").addClass("TB_overlayBG");//use background and opacity
		}
		
		if(caption===null){caption="";}
		$JQ("body").append("<div id='TB_load'><img src='"+imgLoader.src+"' /></div>");//add loader to the page
		$JQ('#TB_load').show();//show loader
		
		var baseURL;
	   if(url.indexOf("?")!==-1){ //ff there is a query string involved
			baseURL = url.substr(0, url.indexOf("?"));
	   }else{ 
	   		baseURL = url;
	   }
	   
	   var urlString = /\.jpg$|\.jpeg$|\.png$|\.gif$|\.bmp$/;
	   var urlType = baseURL.toLowerCase().match(urlString);

		if(urlType == '.jpg' || urlType == '.jpeg' || urlType == '.png' || urlType == '.gif' || urlType == '.bmp'){//code to show images
				
			TB_PrevCaption = "";
			TB_PrevURL = "";
			TB_PrevHTML = "";
			TB_NextCaption = "";
			TB_NextURL = "";
			TB_NextHTML = "";
			TB_imageCount = "";
			TB_FoundURL = false;
			
			if(imageGroup){
				TB_TempArray = $JQ("a[rel="+imageGroup+"]").get();
				for (TB_Counter = 0; ((TB_Counter < TB_TempArray.length) && (TB_NextHTML === "")); TB_Counter++) {
					var urlTypeTemp = TB_TempArray[TB_Counter].href.toLowerCase().match(urlString);
						if (!(TB_TempArray[TB_Counter].href == url)) {						
							if (TB_FoundURL) {
								TB_NextCaption = TB_TempArray[TB_Counter].title;
								TB_NextURL = TB_TempArray[TB_Counter].href;
								TB_NextHTML = "<span id='TB_next'>&nbsp;&nbsp;<a href='#'>Next &gt;</a></span>";
							} else {
								TB_PrevCaption = TB_TempArray[TB_Counter].title;
								TB_PrevURL = TB_TempArray[TB_Counter].href;
								TB_PrevHTML = "<span id='TB_prev'>&nbsp;&nbsp;<a href='#'>&lt; Prev</a></span>";
							}
						} else {
							TB_FoundURL = true;
							TB_imageCount = "&nbsp;&nbsp;Image " + (TB_Counter + 1) +" of "+ (TB_TempArray.length);											
						}
				}
			}

			imgPreloader = new Image();
			imgPreloader.onload = function(){		
			imgPreloader.onload = null;
			
			var imageWidth = imgPreloader.width;
			var imageHeight = imgPreloader.height;
			
			TB_WIDTH = imageWidth + 34;
			TB_HEIGHT = imageHeight + 60;
			
			captionInsert = "";
			
			if (caption) {captionInsert = "<div id='TB_caption'>" + caption + "</div>";}
			
			$JQ("#TB_window").hide();

			$JQ("#TB_window").append("<div id='TB_secondLine'>" + TB_PrevHTML + TB_imageCount + TB_NextHTML + "</div><div id='TB_closeWindow'><a href='#' id='TB_closeWindowButton' title='Close'>click to close</a> or Esc Key</div><img class='TB_Image' id='TB_Image' src='"+url+"' width='"+imageWidth+"' height='"+imageHeight+"' alt='"+caption+"'/><div class='navText' id='closeText' style='left:"+(imageWidth-58)+"px'>Close</div><div class='navText' id='prevText'>Previous</div><div class='navText' id='nextText' style='left:"+(imageWidth-58)+"px'>Next</div>"+captionInsert); 
			
			$JQ("#TB_window").fadeIn("fast");

			$JQ("#TB_closeWindowButton").click(tb_remove);
			
			function goNext(){
					$JQ("#TB_window").remove();
					$JQ("body").append("<div id='TB_window'></div>");
					tb_show(TB_NextCaption, TB_NextURL, imageGroup);	
					return false;	
				}
				
			function goPrev(){
					if($JQ(document).unbind("click",goPrev)){$JQ(document).unbind("click",goPrev);}
					$JQ("#TB_window").remove();
					$JQ("body").append("<div id='TB_window'></div>");
					tb_show(TB_PrevCaption, TB_PrevURL, imageGroup);
					return false;	
				}
				
			function goToImage(e,theObject){

				x = e.pageX - theObject.parentNode.offsetLeft - 18;
			
				if (x > (imageWidth/2)) {
					if (!(TB_NextHTML == "")) {		
						goNext();
					}
					else {
						tb_remove();	
					}
				}
				else {
					if (!(TB_PrevHTML == "")) {		
						goPrev();
					}
					else {
						if (TB_NextHTML != "") {
							goNext();	
						}
						else {
							tb_remove();	
						}
					}
				}
				
				
			}
			
			function showAction(e,theObject,fade) {
				if (e && theObject) {
					x = e.pageX - theObject.parentNode.offsetLeft - 18;
				}
				if(imageGroup) {
					if(x) {
						if (fade == 0) {
							if (x > (imageWidth/2)) {
								if (!(TB_NextHTML == "")) {		
									$JQ("#nextText").show();
								}
								else {
									$JQ("#closeText").show();
								}
							}
							else {
								if (!(TB_PrevHTML == "")) {		
									$JQ("#prevText").show();	
								}
								else {
									$JQ("#nextText").show();
								}				
							}	
						}
						else {
							if (x > (imageWidth/2)) {
								if (!(TB_NextHTML == "")) {		
									$JQ("#nextText").fadeIn("fast");
									$JQ("#prevText").fadeOut("fast");
									$JQ("#closeText").fadeOut("fast");
								}
								else {
									$JQ("#closeText").fadeIn("fast");
									$JQ("#prevText").fadeOut("fast");	
								}
							}
							else {
								if (!(TB_PrevHTML == "")) {		
									$JQ("#nextText").fadeOut("fast");
									$JQ("#prevText").fadeIn("fast");	
									$JQ("#closeText").fadeOut("fast");
								}
								else {
									$JQ("#nextText").fadeIn("fast");
									$JQ("#closeText").fadeOut("fast");
								}				
							}	
						}
					}
				}
				/* commenting out in case I want to edit back
				else {
					if (x) {
						$JQ("#closeText").fadeIn("fast");
					}					
				}
				*/
				
			}
				
			if ((!(TB_PrevHTML == "")) && (imageGroup)) {
				$JQ("#TB_prev").click(goPrev);
			}
			if ((!(TB_NextHTML == "")) && (imageGroup)) {		
				$JQ("#TB_next").click(goNext);
			}

			document.onkeydown = function(e){ 	
				if (e == null) { // ie
					keycode = event.keyCode;
				} else { // mozilla
					keycode = e.which;
				}
				if(keycode == 27){ // close
					tb_remove();
				} else if(keycode == 190){ // display previous image
					if(!(TB_NextHTML == "")){
						document.onkeydown = "";
						goNext();
					}
				} else if(keycode == 188){ // display next image
					if(!(TB_PrevHTML == "")){
						document.onkeydown = "";
						goPrev();
					}
				}	
			};
			
			tb_position();
			
			$JQ("#TB_load").remove();
			
			showAction();
			
			$JQ("#TB_Image").click(function(e){goToImage(e,this);});	
			$JQ("#TB_Image").mousemove(function(e){showAction(e,this);});
			
			$JQ("#nextText").mousemove(function(e){showAction(e,this,0);});
			$JQ("#nextText").click(function(e){goToImage(e,this);});
			
			$JQ("#prevText").mousemove(function(e){showAction(e,this,0);});
			$JQ("#prevText").click(function(e){goToImage(e,this);});
			
			$JQ("#closeText").mousemove(function(e){showAction(e,this,0);});
			$JQ("#closeText").click(function(e){goToImage(e,this);});	
			
			$JQ("#TB_Image").mouseout(function(e){$JQ("#nextText").css({display:"none"});$JQ("#prevText").css({display:"none"});$JQ("#closeText").css({display:"none"});});
			
			$JQ("#TB_window").css({display:"block"}); //for safari using css instead of show
			};
			
			imgPreloader.src = url;
		}

		if(!params['modal']){
			document.onkeyup = function(e){ 	
				if (e == null) { // ie
					keycode = event.keyCode;
				} else { // mozilla
					keycode = e.which;
				}
				if(keycode == 27){ // close
					tb_remove();
				}	
			};
		}
		
	} catch(e) {
		//nothing here
	}
}

//helper functions below

function tb_remove() {
 	$JQ("#TB_imageOff").unbind("click");
	$JQ("#TB_closeWindowButton").unbind("click");
	$JQ("#TB_window").fadeOut("fast",function(){$JQ('#TB_window,#TB_overlay,#TB_HideSelect').trigger("unload").unbind().remove();});
	$JQ("#TB_load").remove();
	if (typeof document.body.style.maxHeight == "undefined") {//if IE 6
		$JQ("body","html").css({height: "auto", width: "auto"});
		$JQ("html").css("overflow","");
	}
	document.onkeydown = "";
	document.onkeyup = "";
	return false;
}

function tb_position() {
var de = document.documentElement;

if (de&&de.clientWidth < TB_WIDTH) {
	$JQ("#TB_window").css({left: '20px', width: TB_WIDTH + 'px', marginRight:'20px'});
}
else {
	$JQ("#TB_window").css({marginLeft: '-' + parseInt((TB_WIDTH / 2),10) + 'px', width: TB_WIDTH + 'px'});
}

if (de&&de.clientHeight < TB_HEIGHT) {
	$JQ("#TB_window").css({top: (document.documentElement.scrollTop + 20) + 'px'});
}
else {
	$JQ("#TB_window").css({top: parseInt(document.documentElement.scrollTop + ((de.clientHeight - TB_HEIGHT) / 2)) + 'px'});
}
}

function tb_parseQuery ( query ) {
   var Params = {};
   if ( ! query ) {return Params;}// return empty object
   var Pairs = query.split(/[;&]/);
   for ( var i = 0; i < Pairs.length; i++ ) {
      var KeyVal = Pairs[i].split('=');
      if ( ! KeyVal || KeyVal.length != 2 ) {continue;}
      var key = unescape( KeyVal[0] );
      var val = unescape( KeyVal[1] );
      val = val.replace(/\+/g, ' ');
      Params[key] = val;
   }
   return Params;
}

function tb_getPageSize(){
	var de = document.documentElement;
	var w = window.innerWidth || self.innerWidth || (de&&de.clientWidth) || document.body.clientWidth;
	var h = window.innerHeight || self.innerHeight || (de&&de.clientHeight) || document.body.clientHeight;
	arrayPageSize = [w,h];
	return arrayPageSize;
}

function tb_detectMacXFF() {
  var userAgent = navigator.userAgent.toLowerCase();
  if (userAgent.indexOf('mac') != -1 && userAgent.indexOf('firefox')!=-1) {
    return true;
  }
}



