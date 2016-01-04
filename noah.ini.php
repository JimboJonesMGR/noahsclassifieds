<?php
defined('_NOAH') or die('Restricted access');
/******************************************************************************************************************
Initialization file used by autoinstall.php
*******************************************************************************************************************/

$installParameters = array(
    
// Database host name:
"hostName"=>"localhost",

// Database user name:
"dbUser"=>"root",

// Database password:
"dbUserPw"=>"",

// Classifieds database name:
"dbName"=>"classdevel",

// Table prefix. If the classifieds database is happened to be shared with other programs, 
// this can be handy to avoid name collisions between table names. If the database is used by Noah's only, however, 
// simply leave this blank.
"dbPrefix"=>"noah_",

// Database port: if you leave this blank, the default will be used:
"dbPort"=>"",

// Database socket: if you leave this blank, the default will be used:
"dbSocket"=>"",
        
// Noah's install directory. By default, it will be installed in the same directory where the autoinstall.php script is called from.
// A caution for those who call autoinstall.php from the command line: the directory where the script is called from is 
// not necessarily the same as it resides in!
"noahDir"=>".",

//**********************************************************************************************************************************
// The following parameters can be also set later through the admin interface of the program:

// This will appear as the address in the 'From:' field of emails the program sends. 
// If you leave this blank, the program may not be able send out email notifications!
"adminEmail"=>"",

// This will appear as the name in the 'From:' field of email notifications the program sends out:
"adminFromName"=>"",

// Use the following parameters if you want that the program sends out the notification emails through an SMTP server. 
// Otherwise, the native Php mail function will be used.

// SMTP server name:
"smtpServer"=>"",

// SMTP user name:
"smtpUser"=>"",

// SMTP password
"smtpPass"=>"",

// Fall back on native mail if SMTP fails
"fallBackNative"=>FALSE,
);

?>
