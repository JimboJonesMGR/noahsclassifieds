<?php
global $license;

echo "<html><title>Noah's Classifieds - Enter License Number</title><body>";

if (isset($_POST['serial']) || isset($_GET['serial']) || ($_COOKIE['setserial']))
{
include("initdirs.php");
require(NOAH_APP . "/config.php");
include(NOAH_APP . "/constants.php");
include(NOAH_APP . "/error.php");
include(NOAH_APP . "/include.php");

gorumMain();

if (isset($_POST['serial'])) $license = htmlspecialchars($_POST['serial']);
else $license = htmlspecialchars($_GET['serial']);

  		// validate the license
		// validate the license
		$returned=licensing::validate_license(
			'ab7d027e1c2a3b38879f88f8c8e83721', 
			'http://noahsclassifieds.org/license_server', 
			'http://noahsclassifieds.org/api/index.php',
			$license
			);


    $s = "<center>";
    $s .= "<img src='".NOAH_BASE."/logo.gif' alt='NOAH'S CLASSIFIEDS'>";
 		if (!is_array($returned)) 
			{
        //echo $returned;
        $s .="<hr />";        
        $s .= "<form action='".NOAH_BASE."/serial.php' method='post'>
              <p><span style='font-size: medium;'>Noah has detected the following issue with your license #:</span></p>
              <p><span style='font-size: small;'><span style='color: #ff0000;'><em><strong>-&nbsp;$returned</strong></em></span><br /></span></p>
              <p><span style='font-size: medium;'>Please enter the correct number and click Activate to continue.</span></p>			
              <p>Your License #: <input type='text' name='serial' />
              <input type='submit' value='Activate'><p>
          </form>";
        $s .="<hr />";        
			} else
			{
        executeQuery("UPDATE @settings set serial='$license'");
        $ctrl = new AppController("user/login_form");
        $s .= "<h2>Your license # $license has been activated.<br>Please write it down for future reference.</h2>";
        $s .= "<a href='".$ctrl->makeUrl()."'>Click here to login again</a>";
      }

      $s .= "</center>";  
      echo $s;

      echo "</body></html>";
      
      
} else header('Location: index.php');
      
?>

