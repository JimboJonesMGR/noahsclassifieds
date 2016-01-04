<?php
defined('_NOAH') or die('Restricted access');
function appFillTables()
{
    global $lll,$gorumuser,$fixCss, $withShoppingCart;
    global $gorumroll, $ommitNotifications, $noahVersion, $versionFooterText, $paypalMarketingText;

    ini_set("max_execution_time", 0);
    $ommitNotifications = TRUE;  // so that the install scipt doesn't send out notifications       
    $gorumroll = new Roll();

    $g = new GlobalStat;
    $g->id=1;
    $g->instver=$noahVersion;
    create($g);
    
    executeQuery("
    INSERT INTO @settings (
        `id`, 
        `menuPoints`, 
        `allowedThemes`, 
        `allowedLanguages`, 
        `titlePrefix`, 
        `blockSize`, 
        `showExplanation`, 
        `dateFormat`,
        `timeFormat`,
        `versionFooter`,
        `extraBody`) VALUES 
        (1, '1,2,3,4,5,6,7,8,9,10,11,12','classic,modern', 'en', '[Noah''s Classifieds]', 20, 0, 'Y-m-d', 'Y-m-d H:i',
    '$versionFooterText', '$paypalMarketingText');");
 
    ItemField::addDefaultCustomFields();
    
    $v = new UserField;
    $v->cid = 0;
    $v->name = $lll["item_id"];
    $v->showInForm = customfield_forNone;
    $v->type = customfield_text;
    $v->subType = customfield_integer;
    $v->sortable = TRUE;
    $v->columnIndex = "id";
    $v->searchable = customfield_forNone;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forNone;
    $v->sortId = 900;
    $v->create(TRUE);
    
    $v = new UserField;
    $v->cid = 0;
    $v->name = "Name";
    $v->type = customfield_text;
    $v->showInList = customfield_forAll;
    $v->mandatory = TRUE;
    $v->searchable = customfield_forAll;
    $v->sortable = TRUE;
    $v->columnIndex = "name";
    $v->thousandsSeparator="";
    $v->sortId = 1000;
    $v->allowHtml = TRUE;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Email";
    $v->type = customfield_text;
    $v->showInList = customfield_forAdmin;
    $v->showInDetails = customfield_forAdmin;
    $v->showInForm = customfield_forAdmin;
    $v->mandatory = TRUE;
    $v->searchable = customfield_forAdmin;
    $v->sortable = TRUE;
    $v->allowHtml = TRUE;
    $v->columnIndex = "email";
    $v->sortId = 1100;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Active";
    $v->type = customfield_bool;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forAdmin;
    $v->showInForm = customfield_forAdmin;
    $v->searchable = customfield_forAdmin;
    $v->sortable = TRUE;
    $v->columnIndex = "active";
    $v->sortId = 1150;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Manager";
    $v->type = customfield_bool;
    $v->showInList = customfield_forAdmin;
    $v->showInDetails = customfield_forAdmin;
    $v->showInForm = customfield_forAdmin;
    $v->searchable = customfield_forAdmin;
    $v->sortable = TRUE;
    $v->columnIndex = "isManager";
    $v->expl = "Managers have the right to create sub-categories and moderate ads.";
    $v->sortId = 1160;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Change password";
    $v->type = customfield_separator;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forNone;
    $v->columnIndex = "changePassword";
    $v->sortId = 1200;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Password";
    $v->type = customfield_text;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forNone;
    $v->columnIndex = "password";
    $v->sortId = 1300;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Repeat password";
    $v->type = customfield_text;
    $v->default = "";
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forNone;
    $v->columnIndex = "passwordCopy";
    $v->sortId = 1400;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Remember password";
    $v->type = customfield_bool;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forNone;
    $v->columnIndex = "rememberPassword";
    $v->sortId = 1500;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Password reminder";
    $v->type = customfield_url;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forNone;
    $v->showInForm = customfield_forAll;
    $v->columnIndex = "remindPasswordLink";
    $v->sortId = 1550;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Credits";
    $v->type = customfield_text;
    $v->subType = customfield_integer;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forAdmin;
    $v->showInForm = customfield_forAdmin;
    $v->searchable = customfield_forAdmin;
    $v->columnIndex = "credits";
    $v->expl = "This field is usually set by the program automatically. E.g. if one buys a credit package, the credits will be added to his/her credit pool. As admin, however, you have the possibility to set this field directly.";
    $v->rangeSearch = TRUE;
    $v->sortId = 1554;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Expiration date";
    $v->type = customfield_date;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forAdmin;
    $v->showInForm = customfield_forAdmin;
    $v->searchable = customfield_forAdmin;
    $v->expl = "This field is usually set by the program automatically. E.g. if one buys a subscription, his/her expiration time changes accordingly. As admin, however, you have the possibility to set this field directly.";
    $v->columnIndex = "expirationTime";
    $v->rangeSearch = TRUE;
    $v->sortId = 1557;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "First name";
    $v->type = customfield_text;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forAll;
    $v->searchable = customfield_forAll;
    $v->sortId = 1560;
    $v->ecommAssignment = 10;//ecomm_firstName;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Last name";
    $v->type = customfield_text;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forAll;
    $v->searchable = customfield_forAll;
    $v->sortId = 1570;
    $v->ecommAssignment = 20;//ecomm_lastName;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "About me";
    $v->type = customfield_textarea;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forAll;
    $v->searchable = customfield_forAll;
    $v->sortId = 1580;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Location";
    $v->type = customfield_separator;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forLoggedin;
    $v->searchable = customfield_forLoggedin;
    $v->sortId = 1600;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Street";
    $v->type = customfield_text;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forLoggedin;
    $v->searchable = customfield_forLoggedin;
    $v->sortId = 1700;
    $v->ecommAssignment = 30;//ecomm_address;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Post code";
    $v->type = customfield_text;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forLoggedin;
    $v->searchable = customfield_forLoggedin;
    $v->sortId = 1800;
    $v->ecommAssignment = 60;//ecomm_zip;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "City";
    $v->type = customfield_text;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forLoggedin;
    $v->searchable = customfield_forLoggedin;
    $v->sortId = 1900;
    $v->ecommAssignment = 40;//ecomm_city;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "State";
    $v->type = customfield_selection;
    $v->values = "Other,Alabama,Alaska,Arizona,Arkansas,California,Colorado,Connecticut,District of Columbia,Delaware,Florida,Georgia,Hawaii,Iowa,Idaho,Illinois,Indiana,Kansas,Kentucky,Louisiana,Maine,Maryland,Massachusetts,Michigan,Minnesota,Mississippi,Missouri,Montana,Nebraska,Nevada,New Hampshire,New Jersey,New Mexico,New York,North Carolina,North Dakota,Ohio,Oklahoma,Oregon,Pennsylvania,Rhode Island,South Carolina,South Dakota,Tennessee,Texas,Utah,Vermont,Virginia,Washington,West Virginia,Wisconsin,Wyoming";
    $v->default = array("Other");
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forLoggedin;
    $v->searchable = customfield_forLoggedin;
    $v->sortId = 2000;
    $v->ecommAssignment = 50;//ecomm_state;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Country";
    $v->type = customfield_selection;
    $v->values = "Afghanistan,Albania,Algeria,Andorra,Angola,Antigua and Barbuda,Argentina,Armenia,Australia,Austria,Azerbaijan,Bahamas,, The,Bahrain,Bangladesh,Barbados,Belarus,Belgium,Belize,Benin,Bhutan,Bolivia,Bosnia and Herzegovina,Botswana,Brazil,Brunei Darussalam,Bulgaria,Burkina Faso,Burma,Burundi,Cambodia,Cameroon,Canada,Cape Verde,Central African Republic,Chad,Chile,China,Colombia,Comoros,Congo (Brazzaville),Congo (Kinshasa),Costa Rica,Cote d'Ivoire,Croatia,Cuba,Cyprus,Czech Republic,Denmark,Djibouti,Dominica,Dominican Republic,East Timor (see Timor-Leste),Ecuador,Egypt,El Salvador,Equatorial Guinea,Eritrea,Estonia,Ethiopia,Fiji,Finland,France,Gabon,Gambia,, The,Georgia,Germany,Ghana,Greece,Grenada,Guatemala,Guinea,Guinea-Bissau,Guyana,Haiti,Holy See,Honduras,Hong Kong,Hungary,Iceland,India,Indonesia,Iran,Iraq,Ireland,Israel,Italy,Jamaica,Japan,Jordan,Kazakhstan,Kenya,Kiribati,Korea,, North,Korea,, South,Kosovo,Kuwait,Kyrgyzstan,Laos,Latvia,Lebanon,Lesotho,Liberia,Libya,Liechtenstein,Lithuania,Luxembourg,Macau,Macedonia,Madagascar,Malawi,Malaysia,Maldives,Mali,Malta,Marshall Islands,Mauritania,Mauritius,Mexico,Micronesia,Moldova,Monaco,Mongolia,Montenegro,Morocco,Mozambique,Namibia,Nauru,Nepal,Netherlands,Netherlands Antilles,New Zealand,Nicaragua,Niger,Nigeria,North Korea,Norway,Oman,Pakistan,Palau,Palestinian Territories,Panama,Papua New Guinea,Paraguay,Peru,Philippines,Poland,Portugal,Qatar,Romania,Russia,Rwanda,Saint Kitts and Nevis,Saint Lucia,Saint Vincent and the Grenadines,Samoa,San Marino,Sao Tome and Principe,Saudi Arabia,Senegal,Serbia,Seychelles,Sierra Leone,Singapore,Slovakia,Slovenia,Solomon Islands,Somalia,South Africa,South Korea,Spain,Sri Lanka,Sudan,Suriname,Swaziland,Sweden,Switzerland,Syria,Taiwan,Tajikistan,Tanzania,Thailand,Timor-Leste,Togo,Tonga,Trinidad and Tobago,Tunisia,Turkey,Turkmenistan,Tuvalu,Uganda,Ukraine,United Arab Emirates,United Kingdom,United States,Uruguay,Uzbekistan,Vanuatu,Venezuela,Vietnam,Yemen,Zambia,Zimbabwe";
    $v->default = array("United States");
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forLoggedin;
    $v->searchable = customfield_forLoggedin;
    $v->sortId = 2100;
    $v->ecommAssignment = 70;//ecomm_country;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Age";
    $v->type = customfield_text;
    $v->subType = customfield_integer;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forLoggedin;
    $v->searchable = customfield_forLoggedin;
    $v->rangeSearch = TRUE;
    $v->sortId = 2200;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Married";
    $v->type = customfield_bool;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forLoggedin;
    $v->searchable = customfield_forLoggedin;
    $v->sortId = 2300;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Date of birth";
    $v->type = customfield_date;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forLoggedin;
    $v->rangeSearch = TRUE;
    $v->searchable = customfield_forLoggedin;
    $v->sortId = 2400;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Picture";
    $v->type = customfield_picture;
    $v->mainPicture = TRUE;
    $v->showInList = customfield_forAll;
    $v->showInDetails = customfield_forAll;
    $v->searchable = customfield_forAll;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Picture 2";
    $v->type = customfield_picture;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forAll;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Picture 3";
    $v->type = customfield_picture;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forAll;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Other";
    $v->type = customfield_separator;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forAdmin;
    $v->showInForm = customfield_forNone;
    $v->searchable = customfield_forAdmin;
    $v->sortId = 2200;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Registration";
    $v->type = customfield_date;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forAdmin;
    $v->showInForm = customfield_forNone;
    $v->columnIndex = "creationtime";
    $v->searchable = customfield_forAdmin;
    $v->rangeSearch = TRUE;
    $v->sortId = 2300;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Last log in";
    $v->type = customfield_date;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forAdmin;
    $v->showInForm = customfield_forNone;
    $v->columnIndex = "lastClickTime";
    $v->searchable = customfield_forAdmin;
    $v->sortId = 2400;
    $v->create(TRUE);

    $v = new UserField;
    $v->cid = 0;
    $v->name = "Ads of this user";
    $v->type = customfield_url;
    $v->showInList = customfield_forNone;
    $v->showInDetails = customfield_forAll;
    $v->showInForm = customfield_forNone;
    $v->columnIndex = "viewAdsLink";
    $v->sortId = 2500;
    $v->create(TRUE);

    $demoText = "This is a test user only, whose sole purpose is to demonstrate the feature of adding and using user custom fields. It is supposed to be deleted from the live program.";
    // Tesztjuzerek:
    $u = new User;
    $u->activateVariableFields();
    $u->id = "10";
    $u->name="john";
    $u->email="";
    $u->active=1;
    $u->password=getPassword("a");
    $u->set("First name", "John");
    $u->set("Last name", "Wayne");
    $u->set("State", "Arizona");  // Arizona
    $u->set("Country", "United States");// USA
    $u->set("City", "Chicago");
    $u->set("Post code", "55555");
    $u->set("Street", "Apple st. 15");
    $u->set("Married", TRUE);
    $u->set("Age", 77);
    $u->set("Date of birth", new Date("1931-10-23"));
    $u->set("About me", $demoText);
    $u->set("Picture", "jpg");
    create($u);

    $u = new User;
    $u->activateVariableFields();
    $u->id = "20";
    $u->name="jack";
    $u->email="";
    $u->active=1;
    $u->password=getPassword("a");
    $u->set("First name", "Jack");
    $u->set("Last name", "Lemmon");
    $u->set("State", "Arizona");  // Arizona
    $u->set("Country", "United States");// USA
    $u->set("Post code", "55551");
    $u->set("City", "New York");
    $u->set("Street", "Orange st. 25");
    $u->set("Married", TRUE);
    $u->set("Age", 66);
    $u->set("Date of birth", new Date("1942-11-13"));
    $u->set("About me", $demoText);
    $u->set("Picture", "jpg");
    create($u);

    $u = new User;
    $u->activateVariableFields();
    $u->id = "30";
    $u->name="al";
    $u->email="";
    $u->active=1;
    $u->password=getPassword("a");
    $u->set("First name", "Al");
    $u->set("Last name", "Pachino");
    $u->set("State", "Alaska");
    $u->set("Country", "United States");// USA
    $u->set("Post code", "45551");
    $u->set("Street", "Peach st. 25");
    $u->set("City", "Chicago");
    $u->set("Married", FALSE);
    $u->set("Age", 55);
    $u->set("Date of birth", new Date("1953-01-18"));
    $u->set("About me", $demoText);
    $u->set("Picture", "jpg");
    create($u);

    $u = new User;
    $u->activateVariableFields();
    $u->id = "40";
    $u->name="mel";
    $u->email="";
    $u->active=1;
    $u->password=getPassword("a");
    $u->set("First name", "Mel");
    $u->set("Last name", "Gibson");
    $u->set("State", "Alaska");  // Arizona
    $u->set("Country", "United States");// USA
    $u->set("Post code", "45551");
    $u->set("City", "Washington");
    $u->set("Street", "Banana st. 25");
    $u->set("Married", FALSE);
    $u->set("Age", 53);
    $u->set("Date of birth", new Date("1948-11-13"));
    $u->set("About me", $demoText);
    $u->set("Picture", "jpg");
    create($u);

    // Cronjobok ( a constants.php-ban felvett id-kkel itt objektumokat
    // krealunk):
    $c = new CronJob;
    $c->id = Cronjob_checkExpiration;
    $c->title = "Check advertisement expirations";
    $c->frequency=24; //hours
    $c->function = "checkExpiration();";
    create($c);

    $c = new CronJob;
    $c->id = Cronjob_deleteExpired;
    $c->title = "Delete expired advertisements";
    $c->frequency=24; //hours
    $c->function = "deleteExpiredAds();";
    create($c);

    $c = new CronJob;
    $c->id = Cronjob_deleteInactiveUsers;
    $c->title = "Delete inactive guests";
    $c->frequency=24; //hours
    $c->function = "deleteInactiveGuests();";
    create($c);

    /*
    $c = new CronJob;
    $c->id = Cronjob_downloadOodle;
    $c->title = "Download Oodle Ads";
    $c->frequency=4; //hours
    $c->function = "downloadOodle();";
    create($c);
    */
    
    
    // Notificationok ( a constants.php-ban felvett id-kkel itt
    // objektumokat krealunk):
    $n = new Notification;
    $n->id = Notification_initialPassword;
    $n->title = $lll["notif_initpass_tit"];
    $n->subject=$lll["notif_initpass_subj"];
    $n->body="notifications/email_initial_password.html";
    $n->active=TRUE;
    $n->langDependent=TRUE;
    create($n);

    $n = new Notification;
    $n->id = Notification_remindPassword;
    $n->title = $lll["notif_remindpass_tit"];
    $n->subject=$lll["notif_remindpass_subj"];
    $n->body="notifications/email_remind_password.html";
    $n->active=TRUE;
    $n->langDependent=TRUE;
    create($n);

    $n = new Notification;
    $n->id = Notification_adCreated;
    $n->title = "Sent to admin upon ad creation or modification";
    $n->subject="Ad creation, or modification";
    $n->body="notifications/email_ad_created.html";
    $n->active=TRUE;
    $n->langDependent=FALSE;
    create($n);

    $n = new Notification;
    $n->id = Notification_adDeleted;
    $n->title = "Sent to the owner when his ad has been deleted";
    $n->subject="Ad expiration";
    $n->body="notifications/email_ad_deleted.html";
    $n->langDependent=FALSE;
    create($n);

    $n = new Notification;
    $n->id = Notification_adExpired;
    $n->title = "Sent to the owner when his ad is about to expire";
    $n->subject="Ad expiration warning";
    $n->body="notifications/email_ad_expired.html";
    $n->langDependent=FALSE;
    create($n);

    $n = new Notification;
    $n->id = Notification_adApproved;
    $n->title = "Sent to the owner when his ad have been approved";
    $n->subject="Ad approval";
    $n->body="notifications/email_ad_approved.html";
    $n->langDependent=FALSE;
    create($n);

    $n = new Notification;
    $n->id = Notification_adReply;
    $n->title = "Reply to a posting";
    $n->subject="Reply to your posting";
    $n->body="notifications/email_ad_replied.html";
    $n->langDependent=TRUE;
    create($n);

    $n = new Notification;
    $n->id = Notification_adToAFriend;
    $n->title = "Mail to a friend";
    $n->subject="Check this out";
    $n->body="notifications/email_to_friend.html";
    $n->langDependent=TRUE;
    create($n);

    $n = new Notification;
    $n->id = Notification_autoNotify;
    $n->title = "Auto notify email";
    $n->subject="Auto notify: a new ad has been submitted";
    $n->body="notifications/email_subscription.html";
    $n->langDependent=FALSE;
    create($n);
    
    $n = new Notification;
    $n->id = Notification_adCreatedOwner;
    $n->title = "Sent to the owner when he creates an ad";
    $n->subject="You have created an ad";
    $n->body="notifications/email_ad_created_owner.html";
    $n->active = 0;
    $n->langDependent=FALSE;
    create($n);

    $n = new Notification;
    $n->id = Notification_adFlagged;
    $n->title = "Ad Flagged";
    $n->subject="Ad Flagged";
    $n->body="notifications/email_flagged.html";
    $n->langDependent=FALSE;
    create($n);

   
    /*
    for( $j=1; $j<101; $j++ )
    {
        $c2 = new AppCategory;
        $c2->up = 0;
        $c2->sortId = 100*$j;
        $c2->name = $c2->wholeName = "Category $j";
        create($c2);
    }
    */
    // Tesztkategoriak:
    global $fatherCatList;
    $carC = new AppCategory;
    $carC->name="Cars";
    $carC->description="A lot of cars, different classes, little and large ones, different manufacturers, you can check for the price as well...";
    $carC->up=0;
    $carC->picture="jpg";
    $carC->create(TRUE);

    $v = new ItemField;
    $v->cid = $carC->id;
    $v->name = "Title";
    $v->type = customfield_text;
    $v->seo = customfield_title;
    $v->showInList = customfield_forAll;
    $v->mandatory = TRUE;
    $v->searchable = customfield_forAll;
    $v->sortable = TRUE;
    $v->isCommon = FALSE;
    $v->create(TRUE);
    $v = new ItemField;
    $v->cid = $carC->id;
    $v->name = "Description";
    $v->type = customfield_textarea;
    $v->seo = customfield_description;
    $v->showInList = customfield_forAll;
    $v->innewline=TRUE;
    $v->searchable = customfield_forAll;
    $v->allowHtml = TRUE;
    $v->useMarkitup = TRUE;
    $v->isCommon = FALSE;
    $v->create(TRUE);
    $v = new ItemField;
    $v->cid = $carC->id;
    $v->name = "Consumption";
    $v->type = customfield_text;
    $v->subType = customfield_float;
    $v->formatPostfix = ' l/mile';
    $v->showInList = customfield_forAll;
    $v->searchable = customfield_forAll;
    $v->sortable = TRUE;
    $v->isCommon = FALSE;
    $v->create(TRUE);
    $v = new ItemField;
    $v->cid = $carC->id;
    $v->name = "Broken";
    $v->type = customfield_bool;
    $v->showInList = customfield_forAll;
    $v->searchable = customfield_forAll;
    $v->sortable = TRUE;
    $v->isCommon = FALSE;
    $v->create(TRUE);
    $v = new ItemField;
    $v->cid = $carC->id;
    $v->name = "Price";
    $v->type = customfield_text;
    $v->subType = customfield_float;
    $v->formatPrefix = '$ ';
    $v->showInList = customfield_forAll;
    $v->searchable = customfield_forAll;
    $v->sortable = TRUE;
    $v->isCommon = FALSE;
    $v->create(TRUE);
    $v = new ItemField;
    $v->cid = $carC->id;
    $v->name = "Picture";
    $v->isCommon = 1;
    $v->type = customfield_picture;
    $v->mainPicture = 1;
    $v->searchable = customfield_forAll;
    $v->showInList = customfield_forAll;
    $v->rowspan = TRUE;
    $v->userField = FALSE;
    $v->create(TRUE);
    $v = new ItemField;
    $v->cid = $carC->id;
    $v->name = "Pic2";
    $v->type = customfield_picture;
    $v->isCommon = FALSE;
    $v->create(TRUE);
    $v = new ItemField;
    $v->cid = $carC->id;
    $v->isCommon = FALSE;
    $v->name = "Pic3";
    $v->type = customfield_picture;
    $v->create(TRUE);
    $v = new ItemField;
    $v->cid = $carC->id;
    $v->name = "Pic4";
    $v->type = customfield_picture;
    $v->isCommon = FALSE;
    $v->create(TRUE);
    $v = new ItemField;
    $v->cid = $carC->id;
    $v->name = "Pic5";
    $v->type = customfield_picture;
    $v->isCommon = FALSE;
    $v->create(TRUE);
    $v = new ItemField;
    $v->cid = $carC->id;
    $v->name = "Pic6";
    $v->type = customfield_picture;
    $v->isCommon = FALSE;
    $v->create(TRUE);
    $v = new ItemField;
    $v->cid = $carC->id;
    $v->name = "Pic7";
    $v->type = customfield_picture;
    $v->isCommon = FALSE;
    $v->create(TRUE);
    $v = new ItemField;
    $v->cid = $carC->id;
    $v->name = "Pic8";
    $v->type = customfield_picture;
    $v->isCommon = FALSE;
    $v->create(TRUE);
    $v = new ItemField;
    $v->cid = $carC->id;
    $v->name = "Pic9";
    $v->type = customfield_picture;
    $v->isCommon = FALSE;
    $v->create(TRUE);    

    $fatherCatList = 0;
    $hardC = new AppCategory;
    $hardC->name="Hardware";
    $hardC->description="Find hardware into your computer, from memory to CD-Rom, from hard disk to monitor, whatever you want...";
    $hardC->up=0;
    $hardC->picture="jpg";
    $hardC->create(TRUE);

    $v = new ItemField;
    $v->cid = $hardC->id;
    $v->name = "Title";
    $v->type = customfield_text;
    $v->seo = customfield_title;
    $v->showInList = customfield_forAll;
    $v->mandatory = TRUE;
    $v->searchable = customfield_forAll;
    $v->sortable = TRUE;
    $v->isCommon = FALSE;
    $v->userField = FALSE;
    $v->create(TRUE);
    $v = new ItemField;
    $v->cid = $hardC->id;
    $v->name = "Description";
    $v->type = customfield_textarea;
    $v->seo = customfield_description;
    $v->showInList = customfield_forAll;
    $v->innewline=TRUE;
    $v->searchable = customfield_forAll;
    $v->allowHtml = TRUE;
    $v->useMarkitup = TRUE;
    $v->isCommon = FALSE;
    $v->userField = FALSE;
    $v->create(TRUE);
    $v = new ItemField;
    $v->cid = $hardC->id;
    $v->name = "Type";
    $v->type = customfield_selection;
    $v->showInList = customfield_forAll;
    $v->values="Pc,Mac";
    $v->default=array("Pc");
    $v->searchable = customfield_forAll;
    $v->sortable = TRUE;
    $v->isCommon = FALSE;
    $v->userField = FALSE;
    $v->create(TRUE);
    $v = new ItemField;
    $v->cid = $hardC->id;
    $v->name = "Price";
    $v->type = customfield_text;
    $v->subType = customfield_float;
    $v->formatPrefix = '$ ';
    $v->showInList = customfield_forAll;
    $v->searchable = customfield_forAll;
    $v->sortable = TRUE;
    $v->isCommon = FALSE;
    $v->userField = FALSE;
    $v->create(TRUE);
    
    $fatherCatList = 0;
    $cottC = new AppCategory;
    $cottC->name="Cottages";
    $cottC->description="Find a house for your family! Nice weekends, fishing in the lake, climbing to the mountains, near to your...";
    $cottC->up=0;
    $cottC->picture="jpg";
    $cottC->create(TRUE);

    $v = new ItemField;
    $v->cid = $cottC->id;
    $v->name = "Title";
    $v->type = customfield_text;
    $v->seo = customfield_title;
    $v->showInList = customfield_forAll;
    $v->mandatory = TRUE;
    $v->searchable = customfield_forAll;
    $v->sortable = TRUE;
    $v->isCommon = FALSE;
    $v->userField = FALSE;
    $v->create(TRUE);
    $v = new ItemField;
    $v->cid = $cottC->id;
    $v->name = "Description";
    $v->type = customfield_textarea;
    $v->seo = customfield_description;
    $v->showInList = customfield_forAll;
    $v->innewline=TRUE;
    $v->searchable = customfield_forAll;
    $v->allowHtml = TRUE;
    $v->useMarkitup = TRUE;
    $v->isCommon = FALSE;
    $v->userField = FALSE;
    $v->create(TRUE);
    $v = new ItemField;
    $v->cid = $cottC->id;
    $v->name = "Price";
    $v->type = customfield_text;
    $v->subType = customfield_float;
    $v->formatPrefix = '$ ';
    $v->showInList = customfield_forAll;
    $v->searchable = customfield_forAll;
    $v->sortable = TRUE;
    $v->isCommon = FALSE;
    $v->userField = FALSE;
    $v->create(TRUE);
    
    $fatherCatList = 0;
    $datC = new AppCategory;
    $datC->name="Dating";
    $datC->description="Are you searching for your partner for a long time? The search is over, thousands are looking for love here...";
    $datC->up=0;
    $datC->picture="jpg";
    $datC->allowAd=FALSE;
    $datC->create(TRUE);

    $v = new ItemField;
    $v->cid = $datC->id;
    $v->name = "Title";
    $v->type = customfield_text;
    $v->seo = customfield_title;
    $v->showInList = customfield_forAll;
    $v->mandatory = TRUE;
    $v->searchable = customfield_forAll;
    $v->isCommon = FALSE;
    $v->userField = FALSE;
    $v->create(TRUE);
    $v = new ItemField;
    $v->cid = $datC->id;
    $v->name = "About me";
    $v->seo = customfield_description;
    $v->type = customfield_textarea;
    $v->showInList = customfield_forAll;
    $v->innewline=TRUE;
    $v->searchable = customfield_forAll;
    $v->allowHtml = TRUE;
    $v->useMarkitup = TRUE;
    $v->isCommon = FALSE;
    $v->userField = FALSE;
    $v->create(TRUE);
    $v = new ItemField;
    $v->cid = $datC->id;
    $v->name = "Searching for a";
    $v->type = customfield_selection;
    $v->showInList = customfield_forAll;
    $v->values="Man,Woman,Couple";
    $v->default=array("Man");
    $v->searchable = customfield_forAll;
    $v->sortable = TRUE;
    $v->isCommon = FALSE;
    $v->userField = FALSE;
    $v->create(TRUE);
    $v = new ItemField;
    $v->cid = $datC->id;
    $v->name = "About the partner";
    $v->type = customfield_textarea;
    $v->showInList = customfield_forAll;
    $v->searchable=customfield_forAll;
    $v->innewline=TRUE;
    $v->searchable = customfield_forAll;
    $v->allowHtml = TRUE;
    $v->useMarkitup = TRUE;
    $v->isCommon = FALSE;
    $v->userField = FALSE;
    $v->create(TRUE);
    $v = new ItemField;
    $v->cid = $datC->id;
    $v->name = "Purpose";
    $v->type = customfield_selection;
    $v->showInList = customfield_forAll;
    $v->values="Friendship,Marriage,Sex";
    $v->default=array("Friendship");
    $v->searchable = customfield_forAll;
    $v->sortable = TRUE;
    $v->isCommon = FALSE;
    $v->userField = FALSE;
    $v->create(TRUE);

    $fatherCatList = 0;
    $ecoC = new AppCategory;
    $ecoC->name="Economy cars";
    $ecoC->description="If you don't want to pay much at your petrol station and you dont't want problems during parking, search here.";
    $ecoC->up=$carC->id;
    $ecoC->picture="jpg";
    $ecoC->create(TRUE);

    $fatherCatList = 0;
    $jeepC = new AppCategory;
    $jeepC->name="Pickups";
    $jeepC->description="You always have been dreaming about a nice picup? Check it out here...";
    $jeepC->up=$carC->id;
    $jeepC->picture="jpg";
    $jeepC->create(TRUE);

    $fatherCatList = 0;
    $diskC = new AppCategory;
    $diskC->name="Hard disks";
    $diskC->up=$hardC->id;
    $diskC->create(TRUE);

    $fatherCatList = 0;
    $softC = new AppCategory;
    $softC->name="Memory chips";
    $softC->up=$hardC->id;
    $softC->create(TRUE);

    $fatherCatList = 0;
    $menC = new AppCategory;
    $menC->name="Men";
    $menC->up=$datC->id;
    $menC->create(TRUE);

    $fatherCatList = 0;
    $womC = new AppCategory;
    $womC->name="Women";
    $womC->up=$datC->id;
    $womC->create(TRUE);

    $featured = new ItemField;
    $featured->cid = $carC->id;
    $featured->name = "Promotion level";
    $featured->isCommon = 1;
    $featured->userField = FALSE;
    $featured->type = customfield_multipleselection;
    $featured->values = "None,Gold,Silver,Bronze";
    $featured->default = array("None");
    $featured->searchable = customfield_forAdmin;
    $featured->showInForm = customfield_forAdmin;
    $featured->showInList = customfield_forNone;
    $featured->expl = "This is an example common field that has been set up so that only admin can see and set it. It is used in the search conditions of the demo 'Featured ads' custom lists to fill those lists with the Gold, Silver and Bronze level featured ads.";
    $featured->searchable = customfield_forAdmin;
    $featured->create(TRUE);

    // Teszthirdetesek:
    $n = new Item;
    $n->cid = $ecoC->id;
    $n->col_0 = "Susuki Swift";
    $n->col_1 = "4 wheelsssss, 4 seats, low consumpion car for sale, 4 years old, in good condition";
    $n->col_2 = "10";
    $n->col_3 = TRUE;
    $n->col_4 = "5000";
    $n->{$featured->columnIndex}="Gold,Silver,Bronze";
    $n->ownerId=10;//$john->id;
    $n->status=1;
    $n->create(TRUE);
    
    $n = new Item;
    $n->cid = $ecoC->id;
    $n->col_0 = "Toyota Yaris";
    $n->col_1 = "3 wheels, 5 seats, high consumpion car for sale, 2 years old, broken";
    $n->col_2 = "20";
    $n->col_3 = FALSE;
    $n->col_4 = "50000";
    $n->ownerId=10;//$john->id;
    $n->status=TRUE;
    $n->{$featured->columnIndex}="Gold,Silver,Bronze";
    $n->create(TRUE);

    $n = new Item;
    $n->cid = $ecoC->id;
    $n->col_0 = "Fiat";
    $n->col_1 = "3 seats, metalgreen, high consumpion car for sale, 2 years old, broken";
    $n->col_2 = "12";
    $n->col_3 = TRUE;
    $n->col_4 = "52000";
    $n->ownerId=10;//$james->id;
    $n->status=TRUE;
    $n->{$featured->columnIndex}="Gold,Silver,Bronze";
    $n->create(TRUE);

    $n = new Item;
    $n->cid = $carC->id;
    $n->col_0 = "Audi TT";
    $n->col_1 = "4 seats, metal, high consumpion car for sale, 4 years old, broken";
    $n->col_2 = "13";
    $n->col_3 = FALSE;
    $n->col_4 = "6000";
    $n->col_16 = "jpg";
    $n->col_17 = "jpg";
    $n->col_18 = "jpg";
    $n->col_19 = "jpg";
    $n->col_20 = "jpg";
    $n->col_21 = "jpg";
    $n->col_22= "jpg";
    $n->col_23 = "jpg";
    $n->col_24 = "jpg";
    $n->ownerId=10;//$james->id;
    $n->status=TRUE;
    $n->{$featured->columnIndex}="Gold,Silver,Bronze";
    $n->create(TRUE);

    $n = new Item;
    $n->cid = $carC->id;
    $n->col_0 = "Ferrari 308";
    $n->col_1 = "2 seats, metalred, high consumpion car for sale, 10 years old, in good condition";
    $n->col_2 = "30";
    $n->col_3 = FALSE;
    $n->col_4 = "54000";
    $n->col_16 = "jpg";
    $n->ownerId=10;//$john->id;
    $n->status=TRUE;
    $n->{$featured->columnIndex}="Gold,Silver,Bronze";
    $n->create(TRUE);

    global $item_typ;
    include("item_typ.php");
    $n = new Item;
    $n->cid = $hardC->id;
    $n->col_17 = "Asus motherboard";
    $n->col_18 = "With Intel Pentium 4 processor and integrated sound card";
    $n->col_19 = "Pc";
    $n->col_20 = "4000";
    $n->ownerId=10;//$john->id;
    $n->status=TRUE;
    $n->{$featured->columnIndex}="Gold,Silver,Bronze";
    $n->create(TRUE);

    $n = new Item;
    $n->cid = $hardC->id;
    $n->col_17 = "Matrox G400 video card";
    $n->col_18 = "A very fast card for low price";
    $n->col_19 = "Mac";
    $n->col_20 = "2000";
    $n->ownerId=10;//$james->id;
    $n->status=TRUE;
    $n->{$featured->columnIndex}="Gold,Silver,Bronze";
    $n->create(TRUE);

    $n = new Item;
    $n->cid = $hardC->id;
    $n->col_17 = "Olympus C2000 Zoom digital camera";
    $n->col_18 = "2.1 M, 1600x1200 maxiimal resolution, 3x optical zoom, aperture priority, shutter priority, and more";
    $n->col_19 = "Pc";
    $n->col_20 = "1000";
    $n->ownerId=10;//$john->id;
    $n->status=TRUE;
    $n->{$featured->columnIndex}="Gold,Silver,Bronze";
    $n->create(TRUE);

    include("item_typ.php");
    $n = new Item;
    $n->cid = $menC->id;
    $n->col_17 = "30 years old engineer";
    $n->col_18 = "I am a years old engineer";
    $n->col_19 = "Woman";
    $n->col_20 = "I am searching for a wife who is good in bed and kitchen";
    $n->col_21 = "Marriage";
    $n->col_16 = "jpg";
    $n->ownerId=10;//$john->id;
    $n->status=TRUE;
    $n->{$featured->columnIndex}="Gold,Silver,Bronze";
    $n->create(TRUE);

    $n = new Item;
    $n->cid = $menC->id;
    $n->col_17 = "Don't live me alone!";
    $n->col_18 = "I am very handsome, I have a good job, but I am very shy with women.";
    $n->col_19 = "Woman";
    $n->col_20 = "I want a girl who chain my heart";
    $n->col_21 = "Marriage";
    $n->col_16 = "jpg";
    $n->ownerId=10;//$john->id;
    $n->status=TRUE;
    $n->{$featured->columnIndex}="Gold,Silver,Bronze";
    $n->create(TRUE);

    $n = new Item;
    $n->cid = $womC->id;
    $n->col_17 = "18 years old girl";
    $n->col_18 = "I am a 18 years old girl with nice hair";
    $n->col_19 = "Man";
    $n->col_20 = "I am searching for a real men";
    $n->col_21 = "Sex";
    $n->col_16 = "jpg";
    $n->ownerId=10;//$john->id;
    $n->status=TRUE;
    $n->{$featured->columnIndex}="Gold,Silver,Bronze";
    $n->create(TRUE);

    include("item_typ.php");
    $n = new Item;
    $n->cid = $cottC->id;
    $n->ownerId=10;//$john->id;
    $n->status=TRUE;
    $n->col_17 = "Unique Home for Sale by Owner";
    $n->col_18 = "Wood Blinds, tiled main areas and wood floors in rooms. Crown moldings. 4 bedroom 3 bath. Upgraded master bath. Will accept offers.";
    $n->{$featured->columnIndex}="Gold,Silver,Bronze";
    $n->create(TRUE);
    
    $n = new Item;
    $n->cid = $cottC->id;
    $n->ownerId=10;//$john->id;
    $n->status=TRUE;
    $n->col_17 = "Land for Sale by Owner";
    $n->col_18 = "The home was designed and constructed in 1998 by the owner on a 150 x 160 landscaped lot to enjoy the panoramic view of the golf course
<br>A 600s/f 12' ceiling patio and a 400s/f sunroom were added in 2003 facing East and the golf course (Hidden from the evening sun) for a total of 3165s/f AC and 5600s/f under roof
 <br>Entertaining is a breeze with two large entertaining areas as the sunroom flows into the large living area, kitchen/dining and the outside patio
 <br>Gleaming hard wood floors, built-in bookshelves, gas fireplace and wet bar compliment the living areas
 <br>The master suite, complete with gas fireplace, has adjoining room to be use as an exercise area, study or additional sleeping area
 <br>A large walk in cedar lined closet adjoins the master bath
 <br>Three bedrooms with two and a half bathrooms. The third bedroom/study features a queen size Murphey bed and built-in book- shelves";
    $n->{$featured->columnIndex}="Gold,Silver,Bronze";
    $n->create(TRUE);
    
    $n = new Item;
    $n->cid = $cottC->id;
    $n->ownerId=10;//$john->id;
    $n->status=TRUE;
    $n->col_17 = "Unique Home for Sale by Owner";
    $n->col_18 = "The Oldest Summer Resort in Australia.
<br><br>
Build your trophy home in Waterfall Bay on beautiful Lake Winnettou.
190 feet of water frontage, boathouse with clear, deep water dock. Westerly exposure with million dollar breathtaking sunsets. 180 degree view of lake and mountains, premier location. Walking distance to all amenities. This property is a real gem!
<br><br>
3 million or best offer. For sale by owner. Serious inquiries only. ";
    $n->{$featured->columnIndex}="Gold,Silver,Bronze";
    $n->create(TRUE);
    
    $n = new Item;
    $n->cid = $cottC->id;
    $n->ownerId=10;//$john->id;
    $n->status=TRUE;
    $n->col_17 = "Townhouse for Sale by Owner";
    $n->col_18 = "This building has passed all city codes for occupancy for a day care center, 35 kids per shift ages infants to 12 yrs 6:00am to 11:00pm.1,000 sq. ft. of play area, w/new paved lot, five car parking in back, plus handicap stall Land has been added to this building for the parking.Inside 1,300 sq. ft. New air conditioning, heating system, and ventilation. The lower 1654 daycare center have been completely gutted and remodeled The upper 1656 Tenants have been there 10 yrs and is on rent assistant. Have all ten years of maintenance records ";
    $n->{$featured->columnIndex}="Gold,Silver,Bronze";
    $n->create(TRUE);
    
    $n = new Item;
    $n->cid = $cottC->id;
    $n->ownerId=10;//$john->id;
    $n->status=TRUE;
    $n->col_17 = "Mix use/Commercial for Sale by Owner";
    $n->col_18 = "WOW! Don't miss this one! Beautiful new condo in a wonderful gated community with full amenities off US1 (Federal) . Close to the beach. Light and Bright. Partial water view. Split Bedrooms with Walk-In Closets. Master Bath with Roman Tub. Large Designer Kitchen with lots of counterspace and GE Appliances. Neutral carpet and tile. Washer/Dryer in unit. Low maintenance includes DSL and Direct TV. Bike to the beach or a short drive to XY Avenue. A great new home or investment property! ";
    $n->{$featured->columnIndex}="Gold,Silver,Bronze";
    $n->create(TRUE);
    
    $n = new Item;
    $n->cid = $cottC->id;
    $n->ownerId=10;//$john->id;
    $n->status=TRUE;
    $n->col_17 = "Must See Home for Sale by Owner";
    $n->col_18 = "New hardwood floors throughout 1st floor. Partially finished basement. Newly renovated kitchen and bath. Large wrap-around deck overlooking spacious backyard with Koi Pond! Adjacent subdivided lot for VALUABLE off-street parking and the ability to bulid on. Newer roof and hot water heater. Location close to local park, public transportation, and shopping. ";
    $n->{$featured->columnIndex}="Gold,Silver,Bronze";
    $n->create(TRUE);
    
    /*
    for( $i=1; $i<6; $i++)
    {
        $n = new Item;
        $n->cid = $cottC->id;
        $n->ownerId=10;//$john->id;
        $n->status=TRUE;
        $n->col_17 = "Unique Home for Sale by Owner";
        $n->{$featured->columnIndex}="Gold,Silver,Bronze";
        $n->create(TRUE);
    }
    */
    if( class_exists('rss') ) Rss::initialize();
    
    // setting up the Custom Lists
    CustomList::addCustomColumns();   
    CustomList::addDefaultCustomLists();
    $ecomm = EComm::createObject();
    $ecomm->initialize();
    
    /*
    G::load( $cats, "select * from category where up=0" );
    $num=20;
    foreach( $cats as $cat )
    {
        for( $i=0; $i<$num; $i++ )
        {
            $c = new AppCategory;
            $c->up = $cat->id;
            $c->name = "Category $i";
            create($c);
            for( $j=0; $j<$num; $j++ )
            {
                $c2 = new AppCategory;
                $c2->up = $c->id;
                $c2->name = "Category $i/$j";
                create($c2);
            }        
        }        
    }
    */
}

?>
