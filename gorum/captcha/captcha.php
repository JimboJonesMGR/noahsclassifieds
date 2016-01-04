<?php

require('php-captcha.inc.php');
$dir = opendir("fonts");
$fonts = array();
while( ($file = readdir($dir)) !== false) 
{
    if( preg_match('/\.ttf$/', $file) ) $fonts[] = "fonts/$file";
}
$captcha = new PhpCaptcha($fonts);

/* You can use the following functions to customize the CAPTCHA:

   1. SetWidth(int iWidth) - set the width of the CAPTCHA image. Defaults to 200px.
   2. SetHeight(int iHeight) - set the height of the CAPTCHA image. Defaults to 50px.
   3. SetNumChars(int iNumChars) - set the number of characters to display. Defaults to 5.
   4. SetNumLines(int iNumLines) - set the number of interference lines to draw. Defaults to 70.
   5. DisplayShadow(bool bShadow) - specify whether or not to display character shadows.
   6. SetOwnerText(sting sOwnerText) - owner text to display at bottom of CAPTCHA image, discourages attempts to break your CAPTCHA through display on porn and other unsavoury sites.
   7. SetCharSet(variant vCharSet) - specify the character set to select characters from. If left blank defaults to A-Z. Can be specified as an array of chracters e.g. array('1', 'G', '3') or as a string of characters and character ranges e.g. 'a-z,A-Z,0,3,7'.
   8. CaseInsensitive(bool bCaseInsensitive) - specify whether or not to save user code preserving case. If setting to "false" you need to pass "false" as the second parameter to the "Validate" function when checking the user entered code.
   9. SetBackgroundImages(variant vBackgroundImages) - specify one (a string) or more (an array) images to display instead of noise lines. If more than one image is specified the library selects one at random.
  10. SetMinFontSize(int iMinFontSize) - specify the minimum font size to display. Defaults to 16.
  11. SetMaxFontSize(int iMaxFontSize) - specify the maximum font size to display. Defaults to 25.
  12. UseColour(bool bUseColour) - if true displays noise lines and characters in randomly selected colours.
  13. SetFileType(string sFileType) - specify the output format jpeg, gif or png. Defaults to jpeg.

E.g.: 
$captcha->setWidth(300);
$captcha->SetNumChars(6);
$captcha->DisplayShadow(FALSE);
$captcha->DisplayShadow(FALSE);

If you want different fonts, you can put them in the 'fonts' sub directory - they will be applied automatically.
*/

$captcha->Create();

?>
