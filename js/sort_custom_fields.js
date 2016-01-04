function move( obj, id, dir )
{
  $JQ('#itemfield-sortfield_form .submitfooter a').hide();
  var hiddenTag = $JQ('#i'+id);
  var increment = dir=='up' || dir=='top' ? -1 : +1; 
  var currentTr = $JQ(obj).parent().parent();  // az aktualis TR
  // kijeloljuk az eppen mozgatott sort:
  currentTr.siblings().find('td').removeClass("sortingHighlight");
  currentTr.find('td').addClass("sortingHighlight");
  if( dir=='up' ) var immediateSiblingTr = currentTr.prev();
  else if( dir=='down' ) var immediateSiblingTr = currentTr.next();
  else if( dir=='top' ) var immediateSiblingTr = currentTr.prevAll('tr');
  else var immediateSiblingTr = currentTr.nextAll('tr');
            
  // a legelso elemnel feljebb, ill. a legalsonal lejjebb nem lehet mozgatni:
  if( immediateSiblingTr.length==0 ) return;
  else if( immediateSiblingTr.length>1 )
  {
    if( dir=='top' ) immediateSiblingTr = immediateSiblingTr.slice(-1);  // az elso TR
    else immediateSiblingTr = immediateSiblingTr.slice(-1);  // az utolso TR
  }
  // a kozvetlen szomszed erteke hatarozza meg az uj erteket:
  var newValue = parseInt(immediateSiblingTr.find('span').html()) + increment;
  // megvaltoztatjuk a lethatatlan es a lathato erteket is:
  hiddenTag.val(newValue);
  $JQ(obj).siblings("span").html(newValue);
  
  if( dir=='up' )
  {
    // megkeressuk azt a TR-t, ami utan az aktualisat be kell szurni:
    var siblingTr = immediateSiblingTr.prev();
    var lastValidTr = immediateSiblingTr;
    while( siblingTr.length>0 && parseInt(siblingTr.find('span').html()) > newValue )
    {
      lastValidTr = siblingTr;
      siblingTr = siblingTr.prev();
    }
    if( siblingTr.length>0 ) siblingTr.after(currentTr);
    else lastValidTr.before(currentTr);
  }
  else if( dir=='down' )
  {
    // megkeressuk azt a TR-t, ami ele az aktualisat be kell szurni:
    var siblingTr = immediateSiblingTr.next();
    while( siblingTr.length>0 && parseInt(siblingTr.find('span').html()) < newValue )
    {
      siblingTr = siblingTr.next();
    }
    if( siblingTr.length>0 ) siblingTr.before(currentTr);
    else immediateSiblingTr.after(currentTr);  // ha utolsonak szurjuk be
  }
  else if( dir=='top' )
  {
    immediateSiblingTr.before(currentTr);
  }
  else
  {
    //immediateSiblingTr.dump();
    immediateSiblingTr.after(currentTr);
  }
}

