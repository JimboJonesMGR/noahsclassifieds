<?php
// Translation rate: 100%
// (100% means fully translated, 0% means not translated at all)

// If you edit this file, save it in UTF-8 character encoding! 
// Most text editors allow you to select the character encoding you use - even notepad.
// Saving in UTF-8 is important for Noah's Classifieds to be able to display special characters correctly.

// If you make a new translation (or make fixes in an existing one)and want to share 
// your work with other people, too, send us the language file and we will include it 
// in the next release of Noah's.

// You can read more more about the internationalization in the Noah's documentation under:
// http://www.noahsclassifieds.org/documentation/translation

// Content begins:
// Added in 6.1.0:
$lll["settings_displayFlaggedLink_".customfield_forManager]=$lll["displayFlaggedLink_".customfield_forManager]=$lll["settings_displayFriendmailLink_".customfield_forManager]=$lll["settings_displayResponseLink_".customfield_forManager]=$lll["displayFriendmailLink_".customfield_forManager]=$lll["displayResponseLink_".customfield_forManager]=$lll["customlist_displayedFor_".customfield_forManager]   =$lll["searchable_".customfield_forManager]=$lll["enableUserSearch_".customfield_forManager]=$lll["showInForm_".customfield_forManager]=$lll["showInList_".customfield_forManager]=$lll["showInDetails_".customfield_forManager]=$lll["subscriptionType_".customfield_forManager]=$lll["enableFavorities_".customfield_forManager]="managers only";
$lll["showInForm_".customfield_forAllInCreateButManagerInModify]="all in the create form, but managers only in the modify form";

// Added in 4.1.0:
$lll["settings_displayResponseLink_0"]="none";
$lll["settings_displayFriendmailLink_0"]="none";
$lll["settings_displayResponseLink_1"]="all";
$lll["settings_displayFriendmailLink_1"]="all";
$lll["settings_displayResponseLink_2"]="logged in users only";
$lll["settings_displayFriendmailLink_2"]="logged in users only";
$lll["settings_displayResponseLink_4"]="admin only";
$lll["settings_displayFriendmailLink_4"]="admin only";
$lll["settings_displayResponseLink_5"]="all but admin";
$lll["settings_displayFriendmailLink_5"]="all but admin";
$lll["showInForm_6"]="all in the create form, but admin only in the modify form";
$lll["settings_displayResponseLink"]="Display the 'Contact this user' link on the user details pages.";
$lll["settings_displayFriendmailLink"]="Display the 'Email to a friend' link on the user details pages.";
$lll["enableDisableProperties"]="Enable/disable features";


// Added in 4.0.2:
$lll["settings_downsizeWidth"]="Downsize width in pixels";
$lll["settings_downsizeWidth_expl"]="The uploaded pictures will be automatically downsized to this width. If you enter 0 both as the 'Downsize width' and 'Downsize height', the images will be stored in their original size. If you give a non-null value to only one of the dimensions, the other one will be proportionally calculated.";
$lll["settings_downsizeHeight"]="Downsize height in pixels";
$lll["settings_downsizeHeight_expl"]="The uploaded pictures will be automatically downsized to this height";


// Added in 4.0.0:
$lll["nopermission_read"]="The program has no read permission under the following directories: %s<br>You must execute the following Unix command (in Unix systems, of course):<br><i>chmod 777 &lt;replace directory name&gt;</i>";
// Changed in version 4.1.0. Old text:
//$lll["nopermission_read_expl"]="During it's operation, Noah's must read the content of these directories. You have to make sure the program has enough permission to do this.)";
// New text:
$lll["nopermission_read_expl"]="During it's operation, Noah's must read the content of these directories. You have to make sure the NOAH program has enough permission to do this.)";
$lll["settings_replytoEmail"]="'Reply to' email";
$lll["settings_replytoEmail_expl"]="This will appear as the address in the 'Reply to:' field of emails the program sends.";
$lll["settings_replytoName"]="'Reply to' name";
// Changed in version 4.1.0. Old text:
//$lll["settings_replytoName_expl"]="This will appear as the name in the ''Reply to:' field of email notifications the program sends out.";
// New text:
$lll["settings_replytoName_expl"]="This will appear as the name in the ''Reply to:' field of email notifications the NOAH program sends out.";
$lll["captchaTest"]="CAPTCHA test:";
$lll["captchaTest_1"]="You can use the CAPTCHA feature of the program, if you can see a proper CAPTCHA image below this text. If the image is not displayed, <a href='http://noahsclassifieds.org/documentation/configuration/captcha' target='_blank'>click here to learn more about the possible reasons</a>!<br><br>If the CAPTCHA feature doesn't work on your server, don't try to enable it - especially not in the login form - because it will block you from login as admin!";
$lll["settings_timeFormat"]="Time format";
$lll["settings_smtpPort"]="SMTP port";
$lll["settings_smtpPort_expl"]="Set the remote port number to connect to. Leave it blank to apply the default port.";
$lll["settings_smtpSecure"]="Use secure connection";
$lll["settings_smtpSecure_expl"]="Set the encryption level to use on the connection.<br><br>Note: PHP needs to have been compiled with OpenSSL for SSL and TLS to work.<br><br>Note: Some PHP installations will not have the TLS stream wrapper.";
$lll["settings_smtpSecure_8"]="No";
$lll["settings_smtpSecure_2"]="TLS";
$lll["settings_smtpSecure_4"]="SSL";
$lll["settings_swiftLog"]="SwiftMailer logging level";
$lll["settings_swiftLog_expl"]="If you're running into problems you may consider enabling the logging of SwiftMailer, so you can find out what's going on. The log messages will be written into 'logs/swift_log.txt'. Once you configured the notification sending properly, it is recommended to turn off logging.";
$lll["settings_swiftLog_0"]="Off";
$lll["settings_swiftLog_1"]="Errors only";
$lll["settings_swiftLog_2"]="Failed deliveries";
$lll["settings_swiftLog_3"]="Network commands";
$lll["settings_swiftLog_4"]="Everything";
$lll["settings_logoImage"]="Upload new logo image";
// Changed in version 4.1.0. Old text:
//$lll["settings_logoImage_expl"]="This can only work if the program has write access to the 'layout.tpl.php' file and the 'images' directory of the current theme!<br><br>
//(note: the original logo image is 272x56 pixels)<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_logoImage_expl"]="This can only work if the program has write access to the 'layout.tpl.php' file and the 'images' directory of the current theme!<br><br>
(note: the original logo image is 272x56 pixels)<br><br>This feature is not available in the Lite version of the program!";
$lll["settings_headerBackground"]="Upload new header background image";
// Changed in version 4.1.0. Old text:
//$lll["settings_headerBackground_expl"]="This can only work if the program has write access to the 'layout.css' file and the 'images' directory of the current theme!<br><br>
//After you changed the background image, you may have to click a Shift-Refresh to clear your browser cache, in order to see the change!<br><br>
//(note: the original header background image is 833x108 pixels)<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_headerBackground_expl"]="This can only work if the program has write access to the 'layout.css' file and the 'images' directory of the current theme!<br><br>
After you changed the background image, you may have to click a Shift-Refresh to clear your browser cache, in order to see the change!<br><br>
(note: the original header background image is 833x108 pixels)<br><br>This feature is not available in the Lite version of the program!";
$lll["noPermissionDir"]="The program has probably no write permission to the following directory: %s. The image couldn't be uploaded.";
$lll["noPermissionFile"]="The program has probably no write permission to the following file: %s";
$lll["settings_ecommerceEnabled"]="E-commerce enabled";
$lll["settings_ecommerceEnabled_0"]="Disabled";
$lll["settings_ecommerceEnabled_1"]="Enabled";
$lll["settings_ecommerceEnabled_2"]="Test mode";
$lll["settings_ecommerceEnabled_expl"]="You can hide every E-commerce related features if you disable it here. This is useful if your site is a free classifieds, but you still want to use all the non E-commerce related advantages of the top of the Noah's product line!<br><br>'Test mode' means, that you can configure all the E-commerce related features as admin just like in the Enabled mode, but the normal users will not see anything from this. You can log in, however, as special user called 'ecommtest' (pwd: a) if you want to test how the E-commerce will affect your users!";
$lll["settings_cascadingCategorySelect"]="Enable cascading category selection";
// Changed in version 4.1.0. Old text:
//$lll["settings_cascadingCategorySelect_expl"]="If you have many categories and/or an especially deep category hierarchy, than the category drop-down lists in the ad submission form and in the search form can be very long and uncomfortable to use.<br><br>
//If you enable this property, the category selection lists will always only contain categories from one level and if you select one, a further selection list appears with the sub-categories of the selected main category. And it can go this way right down to \"leaf\" element of the category tree.<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_cascadingCategorySelect_expl"]="If you have many categories and/or an especially deep category hierarchy, than the category drop-down lists in the ad submission form and in the search form can be very long and uncomfortable to use.<br><br>
If you enable this property, the category selection lists will always only contain categories from one level and if you select one, a further selection list appears with the sub-categories of the selected main category. And it can go this way right down to \"leaf\" element of the category tree.<br><br>This feature is not available in the Lite version of the program!";
$lll["settings_enablePermalinks"]="Enable permalinks";
// Changed in version 4.1.0. Old text:
//$lll["settings_enablePermalinks_expl"]="Display the category names and/or the ad titles in the URL.<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_enablePermalinks_expl"]="Display the category names and/or the ad titles in the URL.<br><br>This feature is not available in the Lite version of the program!";
$lll["settings_ommitCatPermaLink"]="Ommit category names in the URLs of ad details pages";
$lll["settings_customAdListTemplate"]="Custom ad list template";
$lll["settings_customAdListTemplate_expl"]="Per default, all lists in Noah's use the 'default_list.tpl.php' template to display their content. With this, you can override the default template file and assign a custom list template to the ad lists. You can place your custom template file either under 'themes/<theme name>/templates' or 'themes/common_templates'.<br><br>Try this as an alternative ad list template: ad_list_pictures_left.tpl.php";
$lll["settings_templateDebug"]="Template debug mode";
$lll["settings_templateDebug_expl"]="If enabled, the template variables that can be used on a page will be all displayed in a popup window.";
$lll["settings_deleteAdsOnExpiry"]="Delete ads on expiry";
$lll["settings_deleteAdsOnExpiry_expl"]="If you uncheck this, the expired ads will not be deleted - only set to Inactive.";
$lll["linksAndDefaultPages"]="Pages and link locations";
$lll["settings_homeLocation"]="Show this as the Home page";
$lll["settings_homeLocation_expl"]="If it's not the list of the main categories that you want to display as the Home page of Noah's, you can enter here an other page location. Examples: <br><br>
To display the ad listing of Category 1 on the Home, enter this: list/1<br><br>
To display the Recent ad listing on the Home, enter this: customlist/3<br><br>
Note: you can still access the page of the list of main categories using a direct link - say: http://yoursite.com/path_to_noah/list/0";
$lll["settings_redirectFirstLogin"]="Redirect after first login";
$lll["settings_redirectFirstLogin_expl"]="The page users will be redirected after their first login.<br><br>
E.g. if you have a terms page you access this way http://yoursite.com/terms, than just enter 'terms' here and that page will be the first one your users will read after their first login!";
$lll["settings_redirectLogin"]="Redirect after login";
$lll["settings_redirectLogin_expl"]="The page users will be redirected after every subsequent logins.<br><br>
E.g. enter 'user/modify_form' to redirect them to their profile form after every login!";
$lll["settings_redirectAdminLogin"]="Redirect after admin login";
$lll["settings_redirectAdminLogin_expl"]="The page admin will be redirected after login.<br><br>
E.g. enter 'control_panel' for a quick access of the control panel right after you log in as admin!";
$lll["settings_enableCombine"]="Combine CSS and JavaScript files";
$lll["settings_enableCombine_expl"]="Combined files are a way to reduce the number of HTTP requests by combining all scripts into a single script, and similarly combining all CSS into a single stylesheet.
This is a key to faster pages.<br><br>
You should only disable this during the design customization of your site. You will much easier figure out which CSS declaration to change in which CSS file if the files are separate and uncompressed.<br><br>
Note, however, that there might be servers where combining doesn't work properly: if your server has been set up to put some content (typically, ads of the hosting service) automatically on the top of the pages that are served by Php, it can mess up the combined CSS and JavaScript.";
$lll["customfield_addToSubcats"]="Add this field to all the sub categories, too";
$lll["customfield_addToSubcats_expl"]="This will add a Unique field with the same name to every sub categories of this category (if it has some). If a sub category has a field with this name already, it will be skipped.";
$lll["customfield_default_textarea"]="Default value";
$lll["customfield_customListPlacement"]="Custom placement in lists";
$lll["customfield_customListPlacement_expl"]="This property makes the list template customization more flexible. If you enable, the value of this field will be passed over to the list template, but unlike the other fields, it will not populate the 'cells', 'cellAttrs' and 'cellSpans' template variables. This makes it possible that you display the value of this field in the list in a custom way while leaving the placement of the other fields unaffected.<br><br>
The value of the field can be retrieved by name if you enable this property from the 'cellsByNames' template variable: e.g. \$this->cellsByNames[5]['Picture']";
$lll["customfield_customDetailsPlacement"]="Custom placement on the details page";
$lll["customfield_customDetailsPlacement_expl"]="This property makes the details template customization more flexible. If you enable, the value of this field will be passed over to the details template, but unlike the other fields, it will not populate the 'rows' template variables. This makes it possible that you display the value of this field on the details page in a custom way while leaving the placement of the other fields unaffected.<br><br>
The value of the field can be retrieved by name if you enable this property:e.g. \$this->['Picture']";
$lll["itemfield_ttitle_simple"]="Custom fields";
$lll["itemfield_ttitle_globalDescription"]="Configure the fields that appear in the non category specific lists.";
$lll["displayResponseLink_0"]="none";
$lll["displayFriendmailLink_0"]="none";
$lll["displayResponseLink_1"]="all";
$lll["displayFriendmailLink_1"]="all";
$lll["displayResponseLink_2"]="logged in users only";
$lll["displayFriendmailLink_2"]="logged in users only";
$lll["displayResponseLink_4"]="admin only";
$lll["displayFriendmailLink_4"]="admin only";
$lll["displayResponseLink_5"]="all but admin";
$lll["displayFriendmailLink_5"]="all but admin";
$lll["formatPrefix_expl"]="Typical examples are a currency symbol, or percentage sign. Anything you enter here will preceed the values of this custom field.";
$lll["formatPostfix"]="Postfix";
$lll["formatPostfix_expl"]="E.g. you can add units to the numbers here. Anything you enter here will follow the values of this custom field.";
$lll["precision"]="Precision";
$lll["precision_expl"]="Floating point precision - sets the number of decimal points.";
$lll["precisionSeparator"]="Precision separator";
$lll["precisionSeparator_expl"]="Sets the separator for the decimal point";
$lll["thousandsSeparator"]="Thousands separator";
$lll["format"]="Display format";
$lll["format_expl"]="Advanced users can apply a C-style sprintf format string, too.";
$lll["propagateLabel"]="Propagate the current value of this property into all the other fields with the same name!";
$lll["propagateConfirmationText"]="Click 'Ok' to propagate the current value of this property into all the other custom fields that have the same Name and Type in all the other categories!";
$lll["propagateLabel_subcat"]="Propagate the current value of this property into all the other fields with the same name under the sub categories!";
$lll["propagateConfirmationText_subcat"]="Click 'Ok' to propagate the current value of this property into all the other custom fields that have the same Name and Type in all the sub categories!";
$lll["propagateLabel_sorting"]="Propagate the sorting of this custom field list into all the other categories!";
$lll["propagateConfirmationText_sorting"]="Click 'Ok' to propagate the current sorting into all the other categories!";
$lll["propagateLabel_sorting_subcat"]="Propagate the sorting of this custom field list into all the sub categories!";
$lll["propagateConfirmationText_sorting_subcat"]="Click 'Ok' to propagate the current sorting into all the sub categories!";
$lll["propagateLabel_cat"]="Propagate the current value of this property into all the other categories that have the same Name!";
$lll["propagateConfirmationText_cat"]="Click 'Ok' to propagate the current value of this property into all the other categories that have the same Name!";
$lll["propagateLabel_cat_subcat"]="Propagate the current value of this property into all the sub categories!";
$lll["propagateConfirmationText_cat_subcat"]="Click 'Ok' to propagate the current value of this property into all the sub categories!";
$lll["itemfield_propagate_form"]="Propagate the current value of this property into all the other fields with the same name and type!";
$lll["successfullyPropagated"]="The value of the '%s' property has been successfully propagated into %s custom fields.";
$lll["sortingSuccessfullyPropagated"]="The custom field sorting has been successfully propagated.";
$lll["noPropagationOccured"]="There is no other custom field with the same Name and Type. No propagation occured.";
$lll["catSuccessfullyPropagated"]="The value of the '%s' property has been successfully propagated into %s categories.";
$lll["catNoPropagationOccured"]="There is no other category with the same Name. No propagation occured.";
$lll["orUploadValuesFromFile"]="Or select file:";
$lll["uploadValuesFromFileExpl"]="<br><br>You can also upload the possible values from a file all at once! In that case, one line in the file must represent one value (no need to use commas or other separators between the values!) You can designate the default values in the file by adding :default: to the given line. This is an example file with the countries of the world with USA set as the default value: <a href='upload/countries_example.txt'>countries</a>.";
$lll["customfield_default_textarea_expl"]="If you check in the above field, you can insert variables that will be substituted with the appropriate item values.<br><br>
You can use the following variables:
<ul>
<li>{Title}</li>
<li>{Description}</li>
<li>{Picture}</li>
<li>{Id}</li>
<li>{Category}</li>
<li>{Created}</li>
<li>{Views}</li>
<li>{Responses}</li>
<li>{Expiration}</li>
<li>{Status}</li>
<li>{and any other ad custom field...}</li>
</ul>
Tip: if you have a Picture field and you want it to appear in some other column of the listings than the last one, do the following: 
<ol>
<li>Create a new Textarea type field  with variable substitution enabled,</li>
<li>Enter this in the 'Default' property: {Picture}</li>
<li>Hide it from appearing in the forms and details page, but make it appear in lists</li>
<li>Modify the order of the custom fields so that this new one is displayed just in the position you want</li>
<li>Hide the original Picture field from the lists</li>
</ol>
";
$lll["customfield_useVariableSubstitution"]="Use variable substitution";
$lll["customfield_css"]="Custom CSS class";
$lll["customfield_css_expl"]="If you enter a CSS class name here, the TD-s of the values of this custom field will be generated with this class assigned. E.g.:<br><br>&lt;pre&gt;&lt;td class='myClass'&gt;Field value&lt;/td&gt;&lt;/pre&gt;<br><br>
You can then add a CSS declaration of this class to the 'Additional HEAD content' field of the Content form. E.g.:<pre>&lt;style type=&quot;text/css&quot; media=&quot;screen&quot;&gt;
&lt;!--
td.myClass {
    color: red;
}
--&gt;
&lt;/style&gt;</pre>";
$lll["notification_body_expl"]="Click on 'Help' to find more details about how you can configure the email body and subject!";
$lll["category_renewOnModify"]="Renew on modify and prolong";
$lll["category_renewOnModify_expl"]="Whether the posting date of an ad is updated when the ad is modified or prolonged.";
$lll["category_displayResponseLink"]="Display the 'Response to this ad' link on the ad details pages.";
$lll["category_displayFriendmailLink"]="Display the 'Email to a friend' link on the ad details pages.";
$lll["notificationLinksProperties"]="Links";
$lll["expirationAndModerationProperties"]="Expiration and moderation properties";
$lll["category_customAdMeta"]="Custom ad details page meta tags";
$lll["category_sortId"]="Sort index";
$lll["category_id"]="ID";
$lll["category_up"]="Parent ID";
$lll["category_depth"]="Depth";
$lll["alwaysUseAlternativeOrganizer"]="Always use this alternative organizer ";
$lll["updateHierarchy"]="Update hierarchy";
$lll["category_customAdMeta_expl"]="With this, you can overrule the TITLE tag and the DESCRIPTION and KEYWORDS meta tags the program generates for an ad details page. You can insert variables that will be replaced with the appropriate values. A full blown example:<br><br>&lt;title&gt;{Title} - {Site: Title prefix}: {Site: Title}&lt;/title&gt;<br />
&lt;meta name=&quot;country&quot; content=&quot;{owner: Country}&quot;&gt;<br />
&lt;meta name=&quot;state&quot; content=&quot;{owner: State}&quot;&gt;<br />
&lt;meta name=&quot;city&quot; content=&quot;{owner:City}&quot;&gt;<br />
&lt;meta name=&quot;category&quot; content=&quot;{category: Title}&quot;&gt;<br />
&lt;meta name=&quot;description&quot; content=&quot;{Description}, {Category: Description}, {Site: Description}&quot;&gt;<br />
&lt;meta name=&quot;keywords&quot; content=&quot;{Category: Keywords}&quot;&gt;<br><br>You can use the following variables:
<ul>
<li>Site global values (from the Settings form):
<ul>
<li>{site: Title}</li>
<li>{site: Title prefix}</li>
<li>{site: Description}</li>
<li>{site: Keywords}</li>
</ul></li>
<li>Category values (from the category modify form):
<ul>
<li>{category: Title}</li>
<li>{category: Description}</li>
<li>{category: Keywords}</li>
</ul></li>
<li>Fields of the owner of the ad:
<ul>
<li>{owner: Country}</li>
<li>{owner: State}</li>
<li>{owner: Address}</li>
<li>{owner: and any other user custom field...}</li>
</ul></li>
<li>Fields of the ad:
<ul>
<li>{item: Title}</li>
<li>{item: Description}</li>
<li>{item: Keywords}</li>
<li>{item: and any other ad custom field...}</li>
</ul></li>
</ul><br>
Note: in case of the ad fields, you can ommit the 'item:' prefix - e.g. {Title} stands for the title of the ad. The veriables are case insensitive.";
$lll["category_descriptionMeta"]="Meta and RSS Description";
$lll["category_descriptionMeta_expl"]="Used to populate the DESCRIPTION meta tag for SEO and the category description field of the RSS feed. If you leave it blank, the text of the above 'Description' field will be used! If the 'Description' field contains HTML, however, you should enter its HTML-stripped version into this field.";
$lll["category_customAdListTemplate"]="Custom ad list template";
$lll["category_customAdListTemplate_expl"]="Per default, all lists in Noah's use the 'default_list.tpl.php' template to display their content. With this, you can override the default template file on a per category basis. You can place your custom template file either under 'themes/<theme name>/templates' or 'themes/common_templates'.<br><br>Try this as an alternative ad list template: ad_list_pictures_left.tpl.php";
$lll["category_customAdDetailsTemplate"]="Custom ad details page template";
$lll["category_customAdDetailsTemplate_expl"]="Per default, the 'item_details.tpl.php' template is used to display the details pages of all ads in Noah's. With this, you can override the default template file on a per category basis. You can place your custom template file either under 'themes/<theme name>/templates' or 'themes/common_templates'.";
$lll["category_recursive"]="\"Deep\" listings";
$lll["category_recursive_expl"]="If this is enabled, the category listings and the search result lists of this category will contain all the ads of its sub categories, too.<br><br>
Note that this may not work in any case and whether it works or not, depends on the custom field configuration of the main and the sub categories! In Noah's, it is possible to define completely different custom fields in a sub category and in its main category. In such a case, the deep listing of the main category will lead to a wrong result, because the ads of the sub categories can't be reasonably placed in the same list as those of the main category (the columns mismatch!). Tips to avoid the column mismatch:<br>
<ul>
<li>If you create a new custom field in a category, check the 'Add this field to all the sub categories, too' option in the create form,</li>
<li>Try to set up a final custom field configuration for a category, before you create its sub categories (if you create a sub category, it \"inherits\" the fields of the main category)</li>
<li>Use the 'Clone into sub categories' option on the 'List of custom fields' page to \"harmonize\" the fields of a category with the fields of its sub categories.</li>
</ul>
";
$lll["customFieldExists"]="A custom field with this name already exists. Please, choose an other name!";
$lll["exportProperties"]="Export properties";
$lll["customlist_exportFormat"]="Enable export";
// Changed in version 4.1.0. Old text:
//$lll["customlist_exportFormat_expl"]="If you enable this, a new 'export' link will appear in the list of Custom Lists, which you can use to export the content of this custom list.<br><br>Note: this feature is not available in the Free version of the program!";
// New text:
$lll["customlist_exportFormat_expl"]="If you enable this, a new 'export' link will appear in the list of Custom Lists, which you can use to export the content of this custom list.<br><br>Note: this feature is not available in the Lite version of the program!";
$lll["customlist_exportFields"]="Export the following fields";
$lll["customlist_exportFields_expl"]="Note that you can set the order of the fields by drag and drop!";
$lll["customlist_xmlType_RSS2.0"]="RSS2.0";
$lll["customlist_xmlType_RSS1.0"]="RSS1.0";
$lll["customlist_xmlType_ATOM"]="ATOM";
$lll["customlist_xmlType"]="XML type";
$lll["export"]="export";
$lll["exportSavedAs"]="The list has been exported as %s.";
$lll["couldntOpenExportFile"]="Couldn't open the export file for writing. Check the permissions of the 'feedcreator' directory!";
$lll["customlist_customAdListTemplate"]="Custom ad list template";
$lll["customlist_customAdListTemplate_expl"]="Per default, all lists in Noah's use the 'default_list.tpl.php' template to display their content. With this, you can override the default template file and assign a custom list template to this custom ad lists. You can place your custom template file either under 'themes/<theme name>/templates' or 'themes/common_templates'.<br><br>Try this as an alternative ad list template: ad_list_pictures_left.tpl.php";
// Changed in version 4.1.0. Old text:
//$lll["freeNotSupported"]="This feature is not supported in the Free version of the program.";
// New text:
$lll["freeNotSupported"]="This feature is not supported in the Lite version of the program.";
$lll["catSubscriptions"]="Subscriptions on this category";
$lll["subscription_cat_ttitle"]="Subscriptions on this category";
$lll["subscription_ttitle"]="Subscriptions";
$lll["subscription_unsub_ttitle"]="Unsubscribed email addresses";
$lll["subscription_ttitleDescription"]="View the list of subscriptions and add new email addresses.";
$lll["subscription"]="subscription";
$lll["subscription_newitem"]="Add new subscriptions";
$lll["subscription_create_form_admin"]="Create subscriptions";
$lll["subscription_email_expl_admin"]="You can add many email addresses at once. Just put everyone in a new line.<br><br>Note: email addresses that have been already unsubscribed will be skipped!";
$lll["subscription_creationtime"]="Date";
$lll["subscription_userName"]="User";
$lll["subscription_catName"]="Category name";
$lll["subscription_cid"]="Subscribe to this category";


// Added in 3.1.3:
$lll["category_inactivateOnModify"]="Désactiver sur modification";
$lll["category_inactivateOnModify_expl"]="Décider si le statut de l'annonce bascule à nouveau sur 'en attente' lorsque le propriétaire modifie son annonce.";
$lll["clonecat_create_form"]="Cloner la catégorie";
$lll["clonecat_amount"]="Nombre de clones";
$lll["clonecat_amount_expl"]="Crée plusieurs clones - spécialement si vous clonez les sous-catégories et images aussi - Cela peut prendre du temps et vous ne devez pas fermer la fenêtre de navigation avant la fin de l'opération pour qu'elle soit appliquée !";
$lll["clonecat_name"]="Cloner avec le nom";
$lll["clonecat_name_expl"]="Si vous créez plus d'un seul clone, vous pouvez numéroter en ajoutant les symboles '%d' . Exemple: 'Voitures-%d' donnera les clones suivants: Voitures-1, Voitures-2, Voitures-3, etc.";
$lll["clonecat_recursive"]="Cloner les sous-catégories aussi";
$lll["clonecat_withPictures"]="Cloner les images de la catégorie aussi";
$lll["categoriesCloned"]="Les catégories ont été clonées avec succès.";


// Added in 3.1.2:
$lll["commonFieldAlreadyExists"]="Un champ commun avec ce nom et type éxiste déjà. Vous devez choisir un autre nom.";


// Added in 3.1.0:
$lll["checkUpdatesDescription"]="Vérifiez si une nouvelle version de Noah's Classifieds est sortie. Vous pouvez également faire la mise à jour immédiatement ou bien télécharger le pack de mise à jour en un clique !";
// Changed in version 4.1.0. Old text:
//$lll["checkconfDescription"]="Click here any time to verify if the program has been set up correctly. In case of any problems being detected, the Check page gives useful hints how to solve them.";
// New text:
$lll["checkconfDescription"]="Click here at any time to verify if the program has been set up correctly. In case of any problems being detected, the Check page gives useful hints how to solve them.";
$lll["rssDescription"]="Configurez les propriétés des flux RSS que ce programme génère.";
$lll["settings_langDir_expl"]="Si vous activez plus de langages - avec des sens de lecture différents, Vous devez specifier le sens de lecture dans le fichier de langue. Exemple : Si vous avez un fichier de langue Arabe, vous pouvez mettre une ligne similaire à celle-ci pour outrepasser le réglage : <br><br>$langDir='rtl';<br><br> Utilisez 'rtl' pour 'droite à gauche' et 'ltr' pour 'gauche à droite'.";
// Changed in version 4.0.0. Old text:
//$lll["customfield_values_expl"]="This must be a comma separated list of possible values. E.g. one,two,three";
// New text:
$lll["customfield_values_expl"]="Use this tool to add, remove or modify the possible values! You can also change their order by drag-and-drop. Set the default value(s) using the checkboxes!";
$lll["itemfield_ttitle_global"]="Les champs communs aux listes";
$lll["searchable_0"]="aucun";
$lll["searchable_1"]="tous";
$lll["customlist_displayedFor_1"]="tous";
$lll["searchable_2"]="Utilisateurs connectés seulement";
$lll["customlist_displayedFor_2"]="Utilisateurs connectés seulement";
$lll["searchable_4"]="Administrateur seulement";
$lll["customlist_displayedFor_4"]="Administrateur seulement";
$lll["customfield_isCommon"]="Scope du Champ";
$lll["customfield_isCommon_colhead"]="Scope";
$lll["common"]="Cummun";
$lll["unique"]="Unique";
$lll["customfield_isCommon_expl"]="Si vous réglez le scope sur 'commun', le champ existera dans toutes les catégories. Exemple: Si vous avez une boutique web, quelles que soient les catégories que vous réglez, un champ 'Prix' doit probablement appartenir à toutes, donc le champ 'Prix' devrait plutôt être défini comme 'commun'. Si vous créez un champ commun ou changez un champ 'unique' en champ 'commun', il apparaîtra dans toutes les catégories. Si vous effacez un champ commun, il disparaîtra immédiatement de toutes les catégories.<br><br> Bien qu'un champ soit commun, il peut être réglé indépendamment pour chaque catégories. Exemple: vous pouvez décider qu'il apparaisse dans une page de catégorie mais le cacher dans d'autres. Seul les champs 'Nom' et 'Type' sont reservés car ils doivent être de format identiques dans toutes les catégories.<br><br>Vous pouvez aussi régler votre programme d'annonces avec uniquement des champs communs ! Dans certains cas, cela peut être utile. Exemple: Si vous n'avez que des voitures dans toutes vos catégories, il est problable que toutes vos catégories soient définies avec une structure de champs similaire. Le statut 'commun' est nécessaire pour des catégories personnalisées. Exemple: la liste des annonces récentes peut contenir beaucoup de catégories différentes mais si vous avez des champs communs, vous n'avez pas besoin de restreindre l'affichage des colonnes à 'Titre', 'Description' et 'Catégorie'. Les nouveaux critères communs apparaissent donc comme colonnes supplémentaires.";
$lll["customfield_isCommon_0"]="Unique à cette catégorie";
$lll["customfield_isCommon_1"]="Commun à toutes les catégories";
$lll["userfield_create_completed"]="Le champ a été créé avec succès.";
$lll["itemfield_create_completed"]="Le champ a été créé avec succès.";
$lll["itemfield_columnIndex"]="Index de la colonne";
$lll["NotificationsDescription"]="Gérez la liste des notifications ici - les emails envoyés automatiquement par le programme sur certains événements.";
$lll["category_restartExpOnModify"]="Remise à zero de la période d'expiration sur modification";
$lll["category_restartExpOnModify_expl"]="Solution de prolongement de la période de l'annonce. Si coché et que le propriétaire modifie son annonce (et que l'administrateur l'approuve si la modération de catégorie est activée), la période d'expiration reprendra du début.";
$lll["controlPanel"]="Panneau de configuration";
$lll["controlpanel_ttitle"]="";
$lll["customlist_ttitle"]="Listes Personnalisées";
$lll["customlist"]="Liste Personnalisée";
$lll["customlist_listTitle"]="Titre";
$lll["customlist_listDescription"]="Description";
$lll["customlist_listDescription_expl"]="Quelques explications pour mieux décrire ce qu'est une liste personnalisée. Visible uniquement pour l'administrateur.";
$lll["customlist_create_form"]="Créer une liste personnalisée";
$lll["customlist_modify_form"]="Modifier une liste personnalisée";
$lll["customlist_newitem"]="Ajouter une nouvelle liste personnalisée";
$lll["checkCustomLists"]="A chaque fois que vous effacez un champ personnalisé, vérifiez toutes les listes où une condition de recherche a été fournie en cliquant sur leur Titre, car ces dernières peuvent devenir invalides si une référence au champ ci-effacé est contenue dans leur condition.";
$lll["listDisplayProperties"]="Propriété d'affichage de la liste";
$lll["customlist_primarySort"]="Tri primaire par";
$lll["customlist_primaryDir"]="Direction du tri primaire";
$lll["customlist_secondaryDir_DESC"]="Décroissant";
$lll["customlist_primaryDir_DESC"]="Décroissant";
$lll["customlist_secondaryDir_ASC"]="Croissant";
$lll["customlist_primaryDir_ASC"]="Croissant";
$lll["customlist_primaryPersistent"]="Le tri primaire est persistant";
$lll["customlist_primaryPersistent_expl"]="Si vous laissez cette case décochée, l'utilisateur peut outrepasser le tri initial de la liste en cliquant sur l'icone de tri dans l'en-tête des colonnes. Si vous cochez cette option, vous pouvez obliger certaines annonces à apparaître en tête de liste, quelles que soit l'odre de tri choisi par les utilisateurs.<br><br>Exemple: si vous avez un champ personnalisé nommé 'Niveau de sponsor' avec une valeur 'Gold', 'Silver', 'Bronze' et 'Aucun', vous pouvez créer une liste personnalisée avec un tri persistant décroissant par 'Niveau de sponsor'. Les annonces 'Gold' apparaitront en tête de liste et les 'Aucun' tout en bas.";
$lll["customlist_secondarySort"]="Tri secondaire par";
$lll["customlist_secondaryDir"]="Direction du tri secondaire";
$lll["customlist_secondaryPersistent"]="Le tri secondaire est persistant";
$lll["customlist_limit"]="Limite";
// Changed in version 3.1.2. Old text:
//$lll["customlist_limit_expl"]="You can limit the number of ads the list contains. Leave it blank for no limit. E.g. 10 means, the list will display only the first 10 ads in the given sorting order from all the matching ads.";
// New text:
$lll["customlist_limit_expl"]="Vous pouvez limiter le nombre d'annonce dans une liste. Laissez le champ vide pour aucune limite. Exemple: 10 affichera seulement les 10 premières annonces dans l'ordre de tri fourni. Si vous affichez cette liste comme un 'scrollable widget', c'est toujours une bonne idée de choisir une valeur raisonnable, pas trop haute, afin d'accélèrer le chargement des pages avec 'widgets' pour une consommation réduite des ressources coté client et serveur.";
$lll["customlist_columns"]="Selection des colonnes à afficher";
$lll["customlist_columns_expl"]="Si vous en choisissez plus d'une, vous pouvez les ordonner avec des glissés-lachés! 
Les colonnes s'afficheront dans l'ordre spécifié ici.<br><br>
Afin qu'une colonne s'affiche correctement, notez qu'il n'est pas suffisant de l'ajouter ici! 
L'utilisateur qui affiche la liste doit avoir la permission de voir cette colonne. 
La visibilité d'une colonne peut être réglée à partir de deux endroits conformément au scope du dit champ:<br><br>
&nbsp;&nbsp;1. Si vous désirez régler la visibilité de la colonne d'une liste non spécifique à une catégorie, 
vous pouvez le faire à partir de la liste des 'Champs communs' (ouvrez le formulaire 'modifier' et changez la propriété 'Afficher dans les listes pour'),<br><br>
&nbsp;&nbsp;2. Si vous désirez régler la visibilité de la colonne d'une liste spécifique à une catégorie,
vous pouvez le faire à partir de la liste des 'Champs personnalisés de cette catégorie' (ouvrez le formulaire 'modifier' et changez la propriété 'Afficher dans les listes pour')";
$lll["customlist_displayedFor"]="Afficher la liste pour";
$lll["customlist_displayedFor_expl"]="Quelle que soit votre selection ici, l'administrateur sera toujours capable de visualiser la liste en cliquant sur son Titre dans la 'Liste des listes personnalisées'.";
$lll["customlist_pages"]="Afficher sur ces pages";
// Changed in version 4.1.0. Old text:
//$lll["customlist_pages_expl"]="You can specify a page with its link. E.g. '/item/1' is the details page of ad with ID 1. Use '/' to denote the start page. You can list more pages - one in every line. You can use the '*' wildcard to match more than one pages - e.g.: '/list/*' means all the category listing pages, '/item/*' means all the ad details pages. You can exclude pages by adding the '!' prefix. A more complex example: <br><br>/user/login_form<br>/item/create_form<br>/list/*<br>!/list/1<br>!/list/2<br>/item/4<br>/item/5<br><br>The above says \"display the list on the login page, on the ad submit page, on every category listing pages except of the category with ID 1 and 2, and on the details pages of ads with ID 4 and 5!\"<br><br>This feature doesn't work in the free version!";
// New text:
$lll["customlist_pages_expl"]="You can specify a page with its link. E.g. '/item/1' is the details page of ad with ID 1. Use '/' to denote the start page. You can list more pages - one in every line. You can use the '*' wildcard to match more than one pages - e.g.: '/list/*' means all the category listing pages, '/item/*' means all the ad details pages. You can exclude pages by adding the '!' prefix. A more complex example: <br><br>/user/login_form<br>/item/create_form<br>/list/*<br>!/list/1<br>!/list/2<br>/item/4<br>/item/5<br><br>The above says \"display the list on the login page, on the ad submit page, on every category listing pages except of the category with ID 1 and 2, and on the details pages of ads with ID 4 and 5!\"<br><br>This feature does not work in the Lite version!";
$lll["customlist_categorySpecific"]="Le contenu dépend de la catégorie courante";
// Changed in version 3.1.2. Old text:
//$lll["customlist_categorySpecific_expl"]="If you check this and the custom list is just displayed on a page that is in a \"categy context\" (e.g. on a category listing page or ad details page), the custom list will only include the ads of the given category. This is usefulfif you have a custom list called say 'Featured list' and you want to make this list to be context sensitive - so that when a user is just under the Cars category, it displays the featured cars and when the user is just under the 'Dating' category, it contains the featured dating ads.";
// New text:
$lll["customlist_categorySpecific_expl"]="Si vous cochez cette case et que la liste personnalisée est affichée sur une page qui est dans un \"contexte de catégorie\" (exemple: sur une page de liste d'une catégorie ou bien sur une page de détails d'annonce), la liste personnalisée incluera uniquement les annonces de la dite catégorie.<br><br>C'est utile si vous avez une liste personnalisée nommée 'Liste vedette' et que vous désirez que cette liste soit sensible au contexte - ainsi, lorsque l'utilisateur se trouve dans la catégorie 'Voitures', il affiche les voitures en vedette et lorsqu'il est sous la catégorie 'Rencontres', il affiche les annonces de rencontres vedettes.";
$lll["customlist_recursive"]="et inclure les annonces de la catégorie courante ainsi que ses sous-catégories";
$lll["customlist_listStyle"]="Style de liste";
$lll["customlist_listStyle_0"]="Liste normale";
$lll["customlist_listStyle_1"]="Scrollable widget";
$lll["customlist_listStyle_expl"]="Visitez l'installation de démonstration http://noahsclassifieds.org/v8rss/ pour voir à quoi les styles 'Scrollable widget' ressemblent";
$lll["customlist_positionScrollable"]="Position";
$lll["customlist_positionNormal"]="Position";
$lll["customlist_positionScrollable_expl"]="L'endroit où la liste apparaît dans la page";
$lll["customlist_positionNormal_expl"]="L'endroit où la liste apparaît dans la page";
$lll["customlist_positionScrollable_0"]="Avant le contenu";
$lll["customlist_positionNormal_0"]="Avant le contenu";
$lll["customlist_positionScrollable_1"]="Après le contenu";
$lll["customlist_positionNormal_1"]="Après le contenu";
$lll["customlist_positionScrollable_4"]="Sur le coté gauche de la page.";
$lll["customlist_positionScrollable_5"]="Sur le coté droit de la page.";
$lll["customlist_positionScrollable_2"]="En haut de la page";
$lll["customlist_positionScrollable_3"]="En bas de la page";
$lll["customlist_displayInMenu"]="Assigner les points de menu";
$lll["customlist_displayInMenu_expl"]="Si vous ne désirez pas afficher la liste sur certaines pages, vous pouvez lui assigner un point de menu. L'utilisateur accèdera ainsi à la liste sur une page séparée. Exemple: Les bons vieux points de menu 'Annonces récentes', 'Annonces les plus consultées', 'Annonces en attente', 'Annonces approuvées' ne sont pour l'instant que de simples liens vers les listes personnalisées correspondantes.";
$lll["customlist_displayInMenu_0"]="Aucun";
$lll["customlist_displayInMenu_1"]="Menu de connexion";
$lll["customlist_displayInMenu_2"]="Menu utilisateur";
$lll["customlist_displayInMenu_3"]="Menu administrateur";
$lll["customlist_displayInMenu_4"]="Menu catégories";
$lll["randomOrder"]="-- Ordre aléatoire --";
$lll["noDefaultSort"]="-- Pas de tri --";
$lll["selectField"]="-- Selectionner le champ --";
$lll["currentUser"]="-- Utilisateur courant --";
$lll["customlist_ownerName_expl"]="Si vous choisissez 'Utilisateur courant', la liste contiendra seulement les annonces de l'utilisateur connecté. Exemple: ceci a été utilisé pour la configuration de la liste personnalisée 'Mes annonces'.";
$lll["customlist_loop"]="Boucler les annonces";
$lll["customlist_loop_expl"]="Si le défilement de la liste recommence quand le dernier élément est dépassé";
$lll["customlist_autoScroll"]="Defilement automatique toutes les (secondes)";
$lll["customlist_autoScroll_expl"]="Réglez sur 0 pour désactiver le défilement automatique";
$lll["customlist_cache"]="Mise en mémoire du contenu des listes toutes les (minutes)";
$lll["customlist_cache_expl"]="Afin d'afficher les pages plus rapidement, il est possible de mettre en mémoire 'cache' le contenu des listes sur le serveur. Réglez sur 0 pour désactiver cette fonctionnalité.";


// Added in 3.0.0:
// Changed in version 3.1.3. Old text:
//$lll["versionTooLow"]="Required minimum MySql version is %s. The current one is %s. Required minimum MySql version is %s. The current one is %s.";
// New text:
$lll["versionTooLow"]="La version minimum requise pour MySql est %s. Version courante : %s. La version minimum requise pour Php est %s. Version courante : %s.";
$lll["settings_joomlaLink"]="Site Joomla";
$lll["settings_joomlaLink_expl"]="Si vous avez installé le 'bridge' Joomla, vous pouvez rentrer l'URL de votre site Joomla principal ici. Si vous faites cela, le menu de connexion contiendra un point de menu nommé 'Site principal' pointant vers cette URL.";
$lll["enableUserSearch"]="Activer la recherche d'utilisateur";
$lll["enableUserSearch_expl"]="Cette fonctionnalité n'est pas disponible dans la version dévaluation";
$lll["appsettings_modify_completed"]="Le réglages ont été modifiés avec succès";
$lll["settings_langDir"]="Sens de lecture de la langue";
$lll["settings_langDir_ltr"]="Gauche à droite";
$lll["settings_langDir_rtl"]="Droite à gauche";
$lll["customfield_fixInfoText"]="Ce champ est marqué comme \"fixe\" ce qui signifie que vous ne pouvez le supprimer et ne modifier que certaines de ses propriétés.";
$lll["selectUserField"]="-- Selectionner le champ utilisateur --";
$lll["customfield_userField"]="ou selectionner un des champs utilisateur";
$lll["customfield_userField_expl"]="Au lieu de créer un nouveau champ personnalisé en lui rentrant un Nom ci-dessus, vous avez la possibilité de selectionner l'un des champs utilisateur pour l'affichage. De cette façon, les champs du propriétaire d'une annonce peuvent être directement affichés soit dans la liste d'annonces, soit dans la page de détail de l'annonce.<br><br>Exemple: vous pouvez ajouter le numéro de téléphone du propriétaire dans la page de détails de l'annonce. Ou bien si vous avez un champ personnalisé 'Code postal', vous pouvez également l'afficher. De plus, si vous spécifiez le 'code postal' comme possible critère de recherche, les utilisateurs pourront rechercher les annonces avec ce critère.";
$lll["userField"]="Champ utilisateur";
$lll["customfield_checkboxCols"]="Nombre de colonnes pour lequelles doivent figurer une boite à cocher(checkbox).";
$lll["userfield_displayLabel_expl"]="Si décoché, le label du champ ne sera pas affiché sur la page de détails de l'utilisateur et la valeur du champ s'étendra sur les labels des autres champs.";
$lll["userfield_displaylength_expl"]="Le nombre maximum de caractères affichés sur la page de liste des utilisateurs. L'aspect de la liste peut être ainsi protégé contre des valeurs trop longues dans les cellules.";
$lll["userfield_rangeSearch_expl"]="Si coché, les utilisateurs peuvent rentrer des fourchettes d'affichage des résultats de recherche. Exemple: '10-20' comme condition de recherche pour trouver les utilisateurs pour lesquels leur valeur dans ce champ est comprise entre 10 et 20.";
$lll["userfield_subType_expl"]="";
$lll["itemfield_ttitle"]="Champs personnalisés pour la catégorie '%s'";
$lll["customfield_advanced_form"]="Operations avancées";
$lll["userfield_mainPicture_expl"]=" ";
$lll["userfield_seo_expl"]="Vous pouvez spécifier quel champs personnalisé de l'utilisateur servira comme contenu des balises HTML de TITRE, DESCRIPTION et KEYWORDS, respectivement ici.";
$lll["userfield_detailsPosition_expl"]="L'emplacement des champs sur la page de détails de l'utilisateur. La 'barre de coté' correspond à la zone de droite du panneau de détails où les images résident dams le theme (moderne). Vous pouvez placer des champs au dessus de la zone de l'image ou en dessous avec ce réglage.";
$lll["customfield_showInForm"]="Afficher dans les formulaires pour";
$lll["userfield_showInForm_expl"]="Notez, dans le cas d'un champ marqué comme 'fixe', que ce réglage a une signifiaction limitée. Exemple: Si vous réglez le champ 'Nom' pour un affichage 'administrateur seulement', seul le formulaire 'modifier' de l'utilisateur est concerné (vous ne pouvez cacher le champ 'Nom' dans le formulaire d'inscription et de connexion). De la même manière, vous ne pouvez cacher le champ 'Email' du formulaire d'inscription.";
$lll["subscriptionType_0"]="aucun";
$lll["enableFavorities_0"]="aucun";
$lll["showInDetails_0"]="aucun";
$lll["showInList_0"]="aucun";
$lll["showInForm_0"]="aucun";
$lll["enableUserSearch_0"]="aucun";
$lll["subscriptionType_1"]="tous";
$lll["enableFavorities_1"]="tous";
$lll["showInDetails_1"]="tous";
$lll["showInList_1"]="tous";
$lll["showInForm_1"]="tous";
$lll["enableUserSearch_1"]="tous";
$lll["enableFavorities_2"]="Utilisateurs connectés seulement";
$lll["subscriptionType_2"]="Utilisateurs connectés seulement";
$lll["showInDetails_2"]="Utilisateurs connectés seulement";
$lll["showInList_2"]="Utilisateurs connectés seulement";
$lll["showInForm_2"]="Utilisateurs connectés seulement";
$lll["enableUserSearch_2"]="Utilisateurs connectés seulement";
$lll["showInDetails_3"]="Propriétaire de l'annonce seulement";
$lll["showInList_3"]="Propriétaire de l'annonce seulement";
$lll["showInForm_3"]="Propriétaire de l'annonce seulement";
$lll["enableFavorities_4"]="Administrateur seulement";
$lll["subscriptionType_4"]="Administrateur seulement";
$lll["showInDetails_4"]="Administrateur seulement";
$lll["showInList_4"]="Administrateur seulement";
$lll["showInForm_4"]="Administrateur seulement";
$lll["enableUserSearch_4"]="Administrateur seulement";
$lll["subscriptionType_5"]="Tous sauf l'administrateur";
$lll["enableFavorities_5"]="Tous sauf l'administrateur";
$lll["userfield_ttitle"]="Champs personnalisés pour les utilisateurs";
$lll["userfield_type_expl"]="";
$lll["methods"]="Méthodes";
$lll["clone"]="clone";
$lll["copyOfCategory"]="Copie de '%s'";
$lll["organizeNextPageDrop"]="Evénement 'Hover' quand le pointeur de la souris bouge pour placer la catégorie sur la page suivante.";
$lll["organizePreviousPageDrop"]="Evénement 'Hover' quand le pointeur de la souris bouge pour placer la catégorie sur la page précédente.";
$lll["organizeNextItems"]="catégories suivantes &raquo;";
$lll["organizePreviousItems"]="&laquo; catégories précédentes";
// Changed in version 4.1.0. Old text:
//$lll["fieldset_create_form"]="Advanced operations on the whole list of custom fields of the category (they don't work in the free version!)";
// New text:
$lll["fieldset_create_form"]="Advanced operations on the whole list of custom fields of the category (they don't work in the Lite version!)";
$lll["fieldset_deleteAll"]="Supprimer tous les champs";
// Changed in version 3.1.0. Old text:
//$lll["fieldset_deleteAll_expl"]="This will delete all the non-fix custom fields of this category at once.<br><br>Please note that deleting custom fields causes data loss, because the corresponding ad field values will be deleted, too!";
// New text:
$lll["fieldset_deleteAll_expl"]="Ceci effacera tous les champs personnalisés marqués comme 'unique' de cette catégorie.<br><br>Veuillez noter que l'effacement des champs personnalisés cause des pertes de données car les valeurs des champs des annonces correspondantes seront également effacées.";
$lll["fieldset_cloneToSubcats"]="Cloner en sous-catégories";
$lll["fieldset_cloneToSubcats_expl"]="Cette liste de champs personnalisés sera appliquée dans toutes les sous-catégories de cette catégorie.<br><br>Veuillez noter que si les sous-catégories contiennent déjà des champs personnalisés, ils seront éffacés en premier. Donc cette opération devient utile pour régler de nouvelles catégories, car des pertes de données peuvent être subies dans les catégories contenant dors et déjà des annonces.";
$lll["fieldset_cloneToCats"]="Cloner en catégories";
$lll["fieldset_cloneToCats_expl"]="Cette liste de champs personnalisés sera appliquée dans toutes les catégories selectionnées à droite (vous pouvez en selectionner plus).<br><br>Veuillez noter que si les catégories contiennent déjà des champs personnalisés, ils seront éffacés en premier. Donc cette opération deviens utile pour régler de nouvelles catégories car des pertes de données peuvent être subies dans les catégories contenant dors et déjà des annonces.";
$lll["fieldset_cloneFromCat"]="Cloner à partir d'une catégorie";
$lll["fieldset_cloneFromCat_expl"]="Ceci est la fonction opposée à l'opération précédente: elle remplacera tous les champs personnalisés existants de cette catégorie par la liste de champs d'une autre catégorie. Cela peut causer des pertes de données si cette catégorie contient déjà des annonces. <br><br>Pour être complètement clair : aucune opération de clonage ne copie ou n'ajoute de valeurs ou de catégories mais leur structure, à savoir la liste des champs personnalisés et leurs propriétés. Il est possible de déplacer une annonce d'une catégorie à une autre avec la fonction 'déplacer' sur la base d'une annonce à la fois. Si vous voulez dupliquer une catégorie complète (avec tous les champs personnalisés mais sans leurs annonces et sous-catégories), vous pouvez utiliser la fonction 'Cloner' sous le point de menu 'Organiser les catégories'.";
$lll["fieldset_deleteAll_successful"]="Les champs personnalisés ont été supprimés avec succès.";
$lll["fieldset_cloneToSubcats_successful"]="Les champs personnalisés ont été clonés vers les sous-catégories avec succès";
$lll["fieldset_cloneToCats_successful"]="Les champs personnalisés ont été clonés vers les catégories selectionnées, avec succès";
$lll["fieldset_cloneFromCat_successful"]="Les champs personnalisés des catégories selectionnées ont été clonés à cet endroit avec succès";
$lll["fields"]="champs";


// Added in 2.4.0:
$lll["settings_charLimit_expl"]="'0' veux dire illimité.";
$lll["settings_extraTopContent"]="Contenus additionnels du haut";
// Changed in version 4.1.0. Old text:
//$lll["settings_extraTopContent_expl"]="With this, you can insert custom HTML below the header section of the pages (status bar, menus).<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_extraTopContent_expl"]="With this, you can insert custom HTML below the header section of the pages (status bar, menus).<br><br>This feature is not available in the Lite version of the program!";
$lll["settings_extraBottomContent"]="Contenus additionnels du bas";
// Changed in version 4.1.0. Old text:
//$lll["settings_extraBottomContent_expl"]="With this, you can insert custom HTML above the powered footer of the pages.<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_extraBottomContent_expl"]="With this, you can insert custom HTML above the powered footer of the pages.<br><br>This feature is not available in the Lite version of the program!";
$lll["customfield_subType_expl"]="Exemple: Pour un champ 'Prix', il est sage de le régler comme nombre réel ('Float number'). De cette façon, les fonctions de tri et de fourchette de recherche par colonne de 'Prix' peuvent fonctionner correctement. Vous pouvez alors saisir le 'symbole préfixe' de devise correspondant, la précision et les séparateurs 'milliers' dans la section 'Affichage du format'.";
$lll["formatSection"]="Affichage du format";
$lll["customfield_formatPrefix"]="Préfixe";
$lll["customfield_useMarkitup"]="Utiliser l'éditeur HTML intégré au lieu d'une simple zone de texte de type 'textarea'.";
$lll["category_expirationEnabled"]="Activer l'expiration";
$lll["category_expirationOverride"]="Permettre l'outrepassement d'expiration pour";
$lll["category_allowSubmitAdAdmin"]="Seul l'administrateur peux soummettre des annonces dans cette catégorie.";
$lll["category_expirationOverride_expl"]="Si vous activez ceci, le champ 'nombre de jours avant l'expiration' de l'annonce apparaîtra dans le formulaire 'Créer' et 'Modifier' et le propriétaire pourra rentrer un nombre. Si vous spécifiez '0' dans le champ ci-dessus, ils peuvent rentrer un nombre arbitraire. Si vous spécifiez une valeur plus grande que '0', cette valeur deviendra le nombre de jours par défaut ainsi que le nombre de jours maximum qu'un propriétaire peux régler.";
$lll["category_expirationOverride_0"]="Aucun";
$lll["category_expirationOverride_2"]="Tous les utilisateurs";
$lll["category_expirationOverride_4"]="Administrateur seulement";
$lll["category_organize"]="Organiser les catégories";
$lll["exp"]="Expiration";
$lll["useDragAndDrop"]="Utilisez le glissé-laché ('drag-and-drop') pour ordonner les catégories et cliquer ensuite sur 'Sauvegarde de l'ordre'.";
$lll["organizeSaveButton"]="Sauvegarde de l'ordre";
$lll["organizeSaveMessage"]="L'ordre de la catégorie a été sauvegardé avec succès";
$lll["organizeSaveError"]="Les données n'ont pu être envoyées au serveur.";
$lll["organizeLoadError"]="Les données n'ont pu être chargées à partir du serveur.";


// Added in 2.3.0:
$lll["appFileRemoveExpl"]="Depuis la version 2.3.0, la plupart des fichiers php qui figuraient sous le dossier d'installation doivent résider sous le dossier protégé par ht-access et nommé 'app'.
                           Le dossier racine d'installation doit seulement contenir les fichiers 'index.php' et 'initdir.php'.";
$lll["appFileRemove"]="Afin de commencer à utiliser le programme, vous devez supprimer les fichiers php désormais inutiles du dossier racine d'installation : <span class='confexpl'>%s.</span><br><br><a href='%s'>Cliquez ici pour les supprimer.</a><span class='confexpl'> (Si ce message ne disparaît pas après votre clique, cela veux dire que le programme ne détiens pas un niveau de privilège suffisant pour supprimer ces fichiers. Dans ce cas, vous devrez les supprimer manuellement)</span>";
$lll["backupFileRemoveExpl"]="Pour des raisons de sécurité, les dossiers de sauvegarde créés par la mise à jour automatique doivent être supprimés. Si vous avez encore besoin de ces dossiers, sauvegardez les à un niveau supérieur à celui de votre dossier racine web.";
$lll["backupFileRemove"]="Afin de commencer à utiliser le programme, vous devez supprimer les dossiers de sauvegardes suivants du dossier racine d'installation : <span class='confexpl'>%s.</span><br><br><a href='%s'>Cliquez ici pour les supprimer</a><span class='confexpl'> (Si ce message ne disparaît pas après votre clique, cela veux dire que le programme ne détiens pas un niveau de privilège suffisant pour supprimer ces fichiers. Dans ce cas, vous devrez les supprimer manuellement)</span>";
$lll["systemConfCheck"]="Vérification de la configuration du système...";
$lll["niceURLFeature"]="Fonction de décoration de l'URL:";
$lll["niceURLFeature_1"]="Noah's Classifieds permet une décoration des URL. Cela signifie qu'un lien vers la page de détails d'une annonce peut ressembler à cela:";
$lll["niceURLFeature_2"]="au lieu de la solution courante:";
$lll["niceURLFeature_3"]="En outre, un meilleur aspect, cela favorise l'accès pour les moteurs de recherche.";
$lll["niceURLFeature_4"]="Pour activer cette fonctionnalité, vous aurez besoin d'avoir installé, au préalable, le module Apache suivant : %s . Le système n'as pu déterminer de façon sure si le module est déjà installé (Php doit être installé comme binaire CGI).";
$lll["niceURLFeature_5"]="Si %s est déjà installé, vous devriez créer un fichier dans le dossier d'installation nommé %s et mettre le texte suivant à l'intérieur, pour activer la décoration des URLs:";
// Changed in version 4.0.0. Old text:
//$lll["niceURLFeature_6"]="If after doing this, the nice url feature still doesn't work, you should also check the following in the Apache configuration file:";
// New text:
$lll["niceURLFeature_6"]="If after doing this, the nice url feature still doesn't work, you should  <a href='http://noahsclassifieds.org/documentation/configuration/rewriterules' target='_blank'>click here to learn more about the possible troubleshooting!</a>";
$lll["niceURLFeature_9"]="Pour activer cette fonctionnalité, vous aurez besoin d'avoir installé au préalable le module Apache suivant : %s . Ce module est actuellement absent.";
$lll["reg_companyName"]="Nom de la société";
$lll["reg_firstName"]="Prénom";
$lll["reg_lastName"]="Nom";
$lll["reg_email"]="Email";
$lll["reg_submit"]="Soummettre";
$lll["securityProperties"]="Réglages de sécurité";
$lll["settings_applyCaptcha"]="Appliquer la protection anti-spams (CAPTCHA) dans les formulaires suivants";
$lll["settings_applyCaptcha_1"]="'Répondre à ce commentaire' et 'envoyer ceci par Email à un ami'";
$lll["settings_applyCaptcha_2"]="Formulaire de connexion";
$lll["settings_applyCaptcha_3"]="Formulaire d'inscription";
$lll["settings_applyCaptcha_4"]="Soumission d'annonces";
$lll["customfield_displayLabel"]="Affichage du label";
$lll["customfield_displayLabel_expl"]="Si décoché, le champ label ne sera pas affiché sur la page de détails de l'annonce et la valeur du champ s'étendra aux labels des autres champs.";
$lll["customfield_detailsPosition"]="Position";
$lll["customfield_detailsPosition_expl"]="L'emplacement des champs sur la page de détails de l'annonce. La 'sidebar' (barre de coté) corresponds à la zone à droite du panneau de détails où les images résident(dans le thème 'modern'). Vous pouvez placer des champs avant ou après la zone d'image avec ce réglage.";
$lll["customfield_detailsPosition_0"]="Normal";
$lll["customfield_detailsPosition_1"]="En haut de la 'sidebar' (barre de coté)";
$lll["customfield_detailsPosition_2"]="En haut de la 'sidebar' (barre de coté)";
$lll["formProperties"]="Réglages formulaire";
$lll["listProperties"]="Réglages Liste";
$lll["detailsProperties"]="Réglages page de détails";
$lll["searchProperties"]="Réglages de recherche";
$lll["miscProperties"]="Réglages divers";
$lll["customfield_showInDetails"]="Affiché pour";

// Changed in version 4.1.0. Old text:
//$lll["mysql_found"]="MySQL has been found.";
// New text:
$lll["mysql_found"]="Success! MySQL has been found.";
// Changed in version 4.1.0. Old text:
//$lll["need_pw"]="MySQL require password for user %s.";
// New text:
$lll["need_pw"]="MySQL requires the password for user %s.";
// Changed in version 4.1.0. Old text:
//$lll["incorr_pw"]="MySQL password for %s is incorrect.";
// New text:
$lll["incorr_pw"]="The given MySQL password for %s is incorrect, please check it and try again.";
// Changed in version 4.1.0. Old text:
//$lll["mysql_not_found"]="MySQL not found! Please modify the parameters bellow to satisfy your MySQL configuration!";
// New text:
$lll["mysql_not_found"]="Oh no! MySQL not found! Please modify the parameters bellow to satisfy your MySQL configuration!";
$lll["db_installed"]="La base de données %s a été correctement installée: %s";
// Changed in version 4.1.0. Old text:
//$lll["cantcreatedb"]="Can not reach or create database. User %s has no create database permission, or cannot reach the database. Change the name of the user or give him appropriate rights!";
// New text:
$lll["cantcreatedb"]="Help! NOAH Cannot reach or create your database. User %s has no create database permission, or cannot reach the database. Change the name of the user or give it the appropriate rights!";
// Changed in version 4.1.0. Old text:
//$lll["cantconnectdb"]="Can not connect to database. May be have no rights or not exists, trying to create.";
// New text:
$lll["cantconnectdb"]=" Help! NOAH Cannot connect to database. Odds are there no rights or does not exist, trying to create.";
$lll["inst_create_table_err"]="Erreur pendant la création des tables,  %s déjà installé?";
// Changed in version 4.1.0. Old text:
//$lll["db_created"]="Database %s has been created.";
// New text:
$lll["db_created"]="Success!!! Your Database for NOAH %s has been created.";
// Changed in version 4.1.0. Old text:
//$lll["tables_installed"]="Database tables has been installed.";
// New text:
$lll["tables_installed"]="The Database tables have been correctly installed.";
// Changed in version 4.1.0. Old text:
//$lll["fill_table_err"]="Error while trying to fill tables.";
// New text:
$lll["fill_table_err"]="Oh my! An Error occurred while trying to fill tables.";
// Changed in version 4.1.0. Old text:
//$lll["tables_filled"]="Database tables has been filled with initial data.";
// New text:
$lll["tables_filled"]="Your NOAH Database tables has been filled with sample ads data.";
$lll["inst_click"]="Cliquez ici pour accéder à %s.";
// Changed in version 4.1.0. Old text:
//$lll["createTableFailed"]="Create table failed";
// New text:
$lll["createTableFailed"]="Ouch! Create table failed";
$lll["install"]="Installation";
$lll["clickToInstall"]="Cliquez sur 'Installation' pour installer %s!";
$lll["admin_ok"]="L'identifiant administrateur a été créé, Identifiant : admin, mot de passe : admin.";
// Changed in version 4.1.0. Old text:
//$lll["create_file_ok"]="Config has been successfully created.";
// New text:
$lll["create_file_ok"]="Awesome!!! Config has been successfully created.";
// Changed in version 4.1.0. Old text:
//$lll["create_file_nok"]="Config file have to be created manually.";
// New text:
$lll["create_file_nok"]="Ouch! Config file have to be created manually, it happens.";
$lll["inst_params"]="La base de données MySQL sera créée avec les paramètres suivants:";
$lll["edit_params"]="Editer les paramètres";
$lll["acceptTerms"]="J'ai lu et accepte les termes et conditions ci-dessous: <input type='checkbox' id='accept' name='accept'>";
$lll["youMustAcceptTerms"]="Vous devez d'abord accepter les termes et conditions pour pouvoir poursuivre";
$lll["hostName"]="Nom de l'Hôte";
$lll["dbHostName"]="Nom de l'Hôte";
$lll["mysqluser"]="Identifiant Mysql";
$lll["dbName"]="Nom de la base de données";
$lll["dbDbName"]="Nom de la base de données";
$lll["dbSocket"]="Socket";
$lll["formtitle"]="Configuration de MySQL";
$lll["password"]="Mot de passe";
$lll["dbPort"]="Port";
$lll["cookieok"]="Les cookies sont activés.";
// Changed in version 4.1.0. Old text:
//$lll["cookienok"]="Enable cookies and start the install process again!";
// New text:
$lll["cookienok"]="Please Enable cookies and start the install process again!";
// Changed in version 4.1.0. Old text:
//$lll["conf_file_write_err"]="Can not open config file for write";
// New text:
$lll["conf_file_write_err"]="Hmmm. The config file cannot be opened for write";
// Changed in version 4.1.0. Old text:
//$lll["compare_conf"]="Create a file with your favorite text editor named 'app/config.php' in the directory where your source is, and copy the following source code into it! Be sure not to write any newline after the last line!";
// New text:
$lll["compare_conf"]="Please Create a file with your favorite text editor named 'app/config.php' in the directory where your source is, and copy the following source code into it! Be sure not to write any new lines after the last line!";
$lll["afterwrconf"]="<u>Après</u> avoir édité le fichier Config cliquez sur le lien ci-dessous.!";
$lll["move_inst_file"]="SVP, Supprimer le fichier install.php du répertoire!";
// Changed in version 4.1.0. Old text:
//$lll["inst_ch_pw"]="Administrator settings - username: admin, password: admin, don't forget to change the password!";
// New text:
$lll["inst_ch_pw"]="Administrator settings - username: admin, password: admin, and don't forget to change the password!";
$lll["create_file_nok_ext"]="Le serveur n'a pas de permission pour créer le fichier config. Vous avez 2 choix:<br>
#1: créer un fichier vide dans le repertoire de l'application avec le nom app/config.php, et donner les droits en ecriture au serveur. sous unix:<br>touch app/config.php;chmod 777 app/config.php<br>et cliquer sur le bouton Refresh ou F5.<br>#2: Vous cliquez sur install et créez le fichier config manuellement avec votre éditeur de texte favori.<br>Le programme vous montrera le texte que vous devrez écrire dans le fichier app/config.php.";
$lll["registerNoah"]="S'enregistrer chez Noah's classified";
$lll["notRegistered"]="Pas encore inscrit";
$lll["registerNoahTitle"]="S'enregistrer chez Noah's classified";
// Changed in version 4.1.0. Old text:
//$lll["noahAlreadyRegistered"]="The product is already registered!";
// New text:
$lll["noahAlreadyRegistered"]="Your NOAH is already registered!";
$lll["noahRegistrationFalseResponse"]="Impossible d'envoyer les informations d'enregistrement au serveur Noah. Veuillez essayer ultérieurement.";
// Changed in version 4.1.0. Old text:
//$lll["noahRegistrationSuccessfull"]="Thank you. The product is now registered!";
// New text:
$lll["noahRegistrationSuccessfull"]="Thank you. Your NOAH is now registered!";
$lll["download"]="Télécharger";
$lll["u_maintitle"]="Procédure de mise à jour de Noah's Classifieds";
// Changed in version 4.1.0. Old text:
//$lll["secure_copy"]="It is recommended to make a dump of your Noah's Classifieds database before the update!";
// New text:
$lll["secure_copy"]="It is recommended to make a databse dump of your Noah's Classifieds before the update!";
$lll["ready_to_update"]="Prêt à mettre à jour la base de données %s vers la version %s?<br>";
// Changed in version 4.1.0. Old text:
//$lll["invalid_version"]="The given version is invalid: %s";
// New text:
$lll["invalid_version"]="hmm...The given version is invalid: %s";
// Changed in version 4.1.0. Old text:
//$lll["updateSuccessful"]="The update successfully completed.";
// New text:
$lll["updateSuccessful"]="The NOAH update successfully completed.";
$lll["updating"]="Mise à jour de la version %s vers la version %s...";
// Changed in version 4.1.0. Old text:
//$lll["already_installed"]="The latest software version %s is already installed.";
// New text:
$lll["already_installed"]="The latest NOAH software version %s is already installed.";
$lll["picturesDirMustbeWritable"]="Le dossier '%s' doit être autorisé en écriture pour le programme afin de faire la mise à jour. La mise à jour a échoué.";
$lll["updateAutomatic"]="Mise à jour";
$lll["updateManualZip"]="Télécharger en ZIP";
$lll["updateManualTgz"]="Télécharger en TGZ";
$lll["downloadFileNotExists"]="Le fichier de téléchargement '%s' n'éxiste pas.";
// Changed in version 4.1.0. Old text:
//$lll["updateFailed"]="Update failed, because the program has no permission to create or modify files under the installation directory.";
// New text:
$lll["updateFailed"]="The Update failed, because NOAH has no permission to create or modify files under the installation directory.";
// Changed in version 4.1.0. Old text:
//$lll["currentVersionIs"]="The current version is: %s";
// New text:
$lll["currentVersionIs"]="The current NOAH version is: %s";
// Changed in version 4.1.0. Old text:
//$lll["latestVersionIs"]="The latest version is: %s";
// New text:
$lll["latestVersionIs"]="The latest NOAH version is: %s";
// Changed in version 4.1.0. Old text:
//$lll["noNeedToUpdate"]="There is no need to update.";
// New text:
$lll["noNeedToUpdate"]="There is no need to update NOAH at this time.";
$lll["checkUpdates"]="Mises à jour";
$lll["checkUpdatesTitle"]="Verification sur le site web de Noah's Classifieds des mises à jour disponibles.";
// Changed in version 4.1.0. Old text:
//$lll["nopermission"]="The program has no write permission under the following directories: %s<br>You must execute the following Unix command (in Unix systems, of course):<br><i>chmod 777 &lt;replace directory name&gt;</i>";
// New text:
$lll["nopermission"]="The NOAH program has no write permission under the following directories: %s<br>You must execute the following Unix command (in Unix systems, of course):<br><i>chmod 777 &lt;replace directory name&gt;</i>";
$lll["nopermission_expl"]="(Noah's Classifieds essaye de sauvegarder les photos des annonces dans 'pictures/ads' et les images des cathégories dans 'pictures/cats'. Vous devez vous assurer que le programme a bien les droits suffisants pour faire cette manipulation.)";
$lll["backToIndex"]="Revenir au programme d'annonces.";
$lll["onlyFrom1.3"]="Votre version est antérieure à la 1.3. Ce script ne peut fonctionner qu'avec la version 1.3";
$lll["cantGetVersionInfo"]="Information de version non disponible, la mise à jour a échoué.";
// Changed in version 4.1.0. Old text:
//$lll["checkMailtestTitle"]="Sending out a test mail...";
// New text:
$lll["checkMailtestTitle"]="NOAH is sending out a test mail...";
$lll["triggerMailTest"]="Cliquez ici pour tester l'envoi d'emails.";
$lll["unableToConnectNoah"]="Connexion au serveur Noah impossible. Veuillez essayer plus tard, SVP.";
$lll["itemNumbersRecalculated"]="Le nombre d'éléments a été recalculé avec succès";
// Changed in version 4.1.0. Old text:
//$lll["dbPrefixExplanation"]="In case Noah's must share the database with tables of other applications, it's wise to specify a table prefix for the Noah's tables, in order to avoid table name collisions. E.g.: 'noah_'";
// New text:
$lll["dbPrefixExplanation"]="In case NOAH must share the database with tables of other applications, it's wise to specify a table prefix for the NOAH tables, in order to avoid table name collisions. E.g.: 'noah_'";
$lll["dbPrefix"]="Préfixe de table";
$lll["checkconf"]="Vérification de la configuration";
// Changed in version 4.1.0. Old text:
//$lll["mailok"]="The send mail test has been successfully completed. You must soon get a test email on %s";
// New text:
$lll["mailok"]="The send mail test has been successfully completed. You will reveive a test email on %s";
// Changed in version 4.1.0. Old text:
//$lll["mailerr"]="The following error occured during sending out a test mail:<br>%s";
// New text:
$lll["mailerr"]="Ouch! The following error occured during sending out a test mail:<br>%s";
$lll["here1"]="Cliquer ici";
$lll["confpreerr"]="Il y a des caractères avant le &lt;? dans le fichier config! SVP, effacez ces caratères (nouvelle ligne et espaces aussi)!";
$lll["confposterr"]="Il y a des caractères après le ?&gt; dans le fichier config! SVP, effacez ces caratères (nouvelle ligne et espaces aussi)!";
$lll["conffileok"]="Le fichier config semble être valide.";
// Changed in version 4.1.0. Old text:
//$lll["congrat"]="Congratulations! You have successfully installed Noah's Classifieds!";
// New text:
$lll["congrat"]="Congratulations! You have successfully installed you new Noah's Classifieds!";
$lll["confcheck"]="Vérification de la configuration du système...";
// Changed in version 4.1.0. Old text:
//$lll["confdisapp"]="If you want to begin to work with the software and you want this page to disappear";
// New text:
$lll["confdisapp"]="If you want to begin to work with on your Noah's Classifieds and you want this page to disappear";
$lll["confclicheck"]="Vous pouvez accéder à cette page de verification de la configuration quand vous le voulez en cliquant sur le lien 'Verifier' dans le menu.";
$lll["chadmemail"]="Votre adresse actuelle est admin@admin.admin. Veuillez entrer correctement votre adresse en cliquant sur le lien 'Configuration' dans le menu!";
// Changed in version 4.1.0. Old text:
//$lll["chsyspass"]="Your system email adress is not yet set. Please set it clicking on the 'Settings' link on the menubar!";
// New text:
$lll["chsyspass"]="Your system email address is not yet set. Please set it clicking on the 'Settings' link on the menubar!";
// Changed in version 4.1.0. Old text:
//$lll["chsyspass_expl"]="The program can't send out notification emails without the system email address that will populate the 'From' and 'Reply-to' fields of the notification emails.";
// New text:
$lll["chsyspass_expl"]="NOAH cannot send out notification emails without the system email address that will populate the 'From' and 'Reply-to' fields of the notification emails.";
$lll["chadmpass"]="Le mot de passe par défaut pour le compte admin n'a pas encore été changé! Veuillez SVP le changer en cliquant sur le lien 'Changement de mot de passe' dans le menu!";
$lll["settings_adminEmail"]="Email de l'administrateur";
// Changed in version 4.1.0. Old text:
//$lll["settings_adminEmail_expl"]="This will appear as the address in the 'From:' field of emails the program sends. If you leave this blank, the program may not be able send out email notifications!";
// New text:
$lll["settings_adminEmail_expl"]="This will appear as the address in the 'From:' field of emails the program sends. If you leave this blank... NOAH may not be able send out email notifications! Note that you may not use an email address in this field!";
$lll["nogd"]="Attention : votre serveur n'a pas de bibliothèque GD (GD library) d'installé.";
// Changed in version 4.1.0. Old text:
//$lll["nogd_expl"]="(This library is responsible in php programs for the image manipulation, so it might be anyway useful if you put it on your server. In our program it is called for creating thumbnail images to the full sized uploaded pictures. Without this support the program can't generate thumbnails, this way the browser have to shrink 'on-the-fly' each big image in each pages where thumbnails can appear. This method works, but it is far from effective (the page have to download every time every big image). )";
// New text:
$lll["nogd_expl"]="(This library is responsible in php programs for the image manipulation, so it might be anyway useful if you put it on your server. In our program it is called for creating thumbnail images to the full sized uploaded pictures. Without this support the program cannot generate thumbnail sized pictures, this way the browser have to shrink 'on-the-fly' each big image in each pages where thumbnails can appear. This method works, but it is far from effective (the page have to download every time every big image). )";
// Changed in version 4.1.0. Old text:
//$lll["instFileRemove"]="In order to start using the program, you have to remove the installation files (%s).<br><a href='%s'>Click here to remove them!</a><span class='confexpl'> (If this message doesn't disappear after you clicked, it means the program has no permission to remove these files. In this case, you must delete them manually!)</span>";
// New text:
$lll["instFileRemove"]="In order to start using the NOAH program, the installation files have to be removed(%s).<br><a href='%s'>Click here to remove them!</a><span class='confexpl'> (If this message doesn't disappear after you clicked, it means the program has no permission to remove these files. In this case, the files need to be manually deleted.)</span>";
$lll["rss"]="RSS";
$lll["rss_modify_form"]="Modifier le flux RSS";
$lll["rss_language"]="Langage";
$lll["rss_link"]="Lien";
// Changed in version 4.1.0. Old text:
//$lll["rss_link_expl"]="The URL of the classifeds site - e.g.: http://yoursete.com/classifieds";
// New text:
$lll["rss_link_expl"]="The URL of the classifeds site - e.g.: http://yoursite.com/classifieds";
$lll["rss_descField"]="Champ de description";
$lll["rss_descField_expl"]="L'index du champ de variable servant à la 'Description' du flux RSS d'une annonce donnée. Dans l'installation par défaut du système d'annonces, c'est le premier champ. Si vous n'avez pas ce champ, réglez l'index sur '0' et aucune description de l'annonce ne sera affichée dans le flux.";
$lll["settings"]="Configuration";
$lll["settings_modify_form"]="Personnalisation";
$lll["settings_expNoticeBefore"]="Nombre de jours pendant lesquels l'utilisateur doit être informé avant l'expiration";
$lll["settings_charLimit"]="Nombre de caractères qu'un envoi peut contenir.";
$lll["settings_blockSize"]="Annonces affichées par page";
$lll["settings_maxPicSize"]="Taille maximum pour une photo (en octets)";
$lll["settings_maxPicWidth"]="Largeur Maximum des photos (en pixels)";
$lll["settings_maxPicHeight"]="Hauteur Maximum des photos (en pixels)";
$lll["settings_maxPicHeight_expl"]="'0' signifie illimité.";
$lll["settings_maxPicWidth_expl"]="'0' signifie illimité.";
$lll["settings_maxPicSize_expl"]="'0' signifie illimité.";
$lll["settings_adminFromName"]="Nom du système";
$lll["settings_adminFromName_expl"]="Ceci apparaîtra comme nom dans le champ 'expéditeur:' des notifications email envoyées par le programme.";
$lll["settings_versionFooter"]="Version en pied de page";
$lll["settings_titlePrefix"]="Préfixe de titre";
$lll["settings_dateFormat"]="Format de date";
$lll["settings_dateFormat_expl"]="Pour plus d'information et d'exemples de specification de dates disponibles, <a href='http://php.net/manual/en/function.date.php' target='_blank'>cliquez ici</a>";
// Changed in version 3.0.0. Old text:
//$lll["settings_enableFavorities"]="Enable the 'Add to favorities' feature";
// New text:
//$lll["settings_enableFavorities"]="Enable the 'Add to favorities' feature for";
$lll["settings_enableFavorities"]="Activer la fonction 'Ajouter aux favoris' pour";
$lll["settings_enableFavorities_expl"]="Ce réglage est sans effet dans la version d'évaluation";
$lll["settings_updateCheckInterval"]="Verifier périodiquement les mises à jours Noah";
$lll["settings_updateCheckInterval_expl"]="Le programme peut vérifier automatiquement si les nouvelles versions sont disponibles, et afficher la page de mise à jour pour l'administrateur. Ce réglage spécifie la longueur de la période de vérification en jours. Pour désactiver la fonctions réglez la valeur sur '0'.";
$lll["mailProperties"]="Propriétés d'envoi d'email";
$lll["themeProperties"]="Thèmes supportés";
$lll["settings_defaultTheme"]="Thème par defaut";
$lll["settings_allowedThemes"]="Thèmes permis pour une sélection à partir de";
$lll["settings_allowedThemes_expl"]="Si vous créez un nouveau dossier sous 'themes' pour votre thème personnalisé - Exemple: 'mon_nouveau_theme'-, il apparaîtra automatiquement dans cette liste comme le nouvel élément 'Mon nouveau theme'.";
$lll["settings_allowSelectTheme"]="Permettre aux autres de changer de thème";
$lll["settings_allowSelectTheme_expl"]="En activant cette fonction un menu de sélection déroulant sera affiché sur les pages permettant le changement immédiat de thème.";
$lll["languageProperties"]="Langage supporté";
$lll["settings_defaultLanguage"]="Langage par défaut";
$lll["settings_allowedLanguages"]="Langages permis pour une sélection à partir de";
$lll["settings_allowSelectLanguage"]="Permettre aux autres de changer de langage";
$lll["settings_allowSelectLanguage_expl"]="En activant cette fonction un menu de sélection déroulant sera affiché sur les pages permettant le changement immédiat du langage.";
$lll["settings_smtpServer"]="Nom du serveur SMTP";
$lll["settings_smtpServer_expl"]="Utilisez ces champs si vous désirez que le programme envoi des notifications email au travers d'un serveur SMTP. Autrement, la fonction native 'mail()' de Php sera utilisée.";
$lll["settings_smtpUser"]="Nom d'utilisateur SMTP";
$lll["settings_smtpPass"]="Mot de passe SMTP";
$lll["settings_fallBackNative"]="Utiliser la fonction native php 'mail()' si SMTP échoue";
$lll["settings_titlePrefix_expl"]="Ce texte précèdera tout titre dans la barre de titre de la fenêtre du navigateur. Exemple: vous pouvez régler le nom de votre site.";
$lll["seoProperties"]="Optimisation pour les moteurs de recherche";
$lll["settings_mainTitle"]="Balise Titre";
$lll["settings_mainTitle_expl"]="Le contenu de TITLE, DESCRIPTION et KEYWORDS dépends habituellement de la liste de catégorie ou bien la page de détails d'annonce actuellement affichée. - Exemple: vous pouvez régler par catégorie et les utilisateurs pourraient régler cela par annonce. Ces trois champs servent par défaut pour les cas où une page n'est pas dans une catégorie ou un contexte d'annonce (Exemple: la page de départ elle même)";
$lll["settings_mainDescription"]="Balise meta description";
$lll["settings_mainKeywords"]="Balise meta keywords";
$lll["settings_helpLink"]="Lien de destination 'Aide'";
$lll["settings_helpLink_expl"]="L'URL complète pour le fichier d'aide. Avec ceci, vous pouvez définir votre propre page d'aide. Exemple:  http://votre_site/dossier_annonces/votre_aide.html";
$lll["settings_maxMediaSize"]="Taille maximale  pour le transfert de fichiers média en octets";
$lll["settings_maxMediaSize_expl"]="'0' signifie illimité.<br><br>Notez toutefois que, quel que soit votre réglage ici, il y a deux réglages Php pouvant limiter la taille maximale pour le transfert de fichiers médias.  Ces paramètres sont 'upload_max_filesize' et 'post_max_size'. Ils peuvent être réglés dans le fichier 'php.ini', ou dans le fichier de configuration d'Apache 'httpd.conf', ou par dossier dans un fichier '.htaccess'. Leur valeur par défaut est habituellement 2Mo. Vous pouvez augmenter cette valeur à 4 Mo dans un fichier .htaccess en procèdant de la manière suivante:<br><br>php_value upload_max_filesize \"4M\"<br>php_value post_max_size \"4M\" ";
// Changed in version 3.0.0. Old text:
//$lll["settings_subscriptionType"]="Auto notify";
// New text:
//$lll["settings_subscriptionType"]="Enable auto notify for";
$lll["settings_subscriptionType"]="Activer la notification pour";
$lll["settings_subscriptionType_expl"]="Les utilisateurs peuvent souscrire pour obtenir des notifications automatiques si de nouvelles annonces sont ajoutées dans une catégorie.";
$lll["settings_subscriptionType_0"]="Désactiver la notification automatique";
$lll["settings_subscriptionType_1"]="Permettre pour les utilisateurs inscrits seulement";
$lll["settings_subscriptionType_2"]="Permettre pour tous";
$lll["settings_menuPoints_expl"]="Si 'Soummettre annonce' est décoché, le point de menu ne sera visible que pour l'administrateur (seul l'administrateur pourra soummettre à ce moment là). Vous pouvez également désactiver ou ré-organiser les points de menus en supprimant ou déplaçant simplement les sections correspondantes dans le fichier de modèle 'layout.tpl.php'.";
$lll["settings_menuPoints"]="Choix dans les menus";
$lll["settings_menuPoints_2"]="Déconnexion";
$lll["settings_menuPoints_3"]="Connexion";
$lll["settings_menuPoints_4"]="S'inscrire";
$lll["settings_menuPoints_5"]="Mon profil";
$lll["settings_menuPoints_6"]="Mes Annonces";
$lll["settings_menuPoints_7"]="Ajouter une annonce";
$lll["settings_menuPoints_8"]="Annonces récentes";
$lll["settings_menuPoints_9"]="Annonces les plus consultées";
$lll["settings_menuPoints_10"]="Recherche";
$lll["settings_menuPoints_11"]="Accueil";
$lll["settings_menuPoints_12"]="Aide";
$lll["menuPointsSep"]="Personnalisation du menu";
$lll["expirationProperties"]="Propriétés d'expiration";
$lll["imageProperties"]="Limite du chargement des images";
$lll["otherProperties"]="Autres réglages";
$lll["adDisplayProperties"]="Réglage d'affichage des annonces";
$lll["settings_renewal"]="Nombre de fois ou un utilisateur peut prolonger son/ses annonce(s) expirée(s)";
$lll["settings_allowModify"]="L'utilisateur peut modifier son/ses propre(s) annonce(s)";
$lll["settings_extraHead"]="Contenus HEAD additionnels";
// Changed in version 4.1.0. Old text:
//$lll["settings_extraHead_expl"]="With this, you can insert custom HTML right before the closing HEAD tag of the pages. This is usually a good place to insert additional style sheets, or JavaScript.<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_extraHead_expl"]="With this, you can insert custom HTML right before the closing HEAD tag of the pages. This is usually a good place to insert additional style sheets, or JavaScript.<br><br>This feature is not available in the Lite version of the program!";
$lll["settings_extraBody"]="Contenus BODY additionnels";
// Changed in version 4.1.0. Old text:
//$lll["settings_extraBody_expl"]="With this, you can insert custom HTML right after the opening BODY tag of the pages. E.g. you can insert a banner above all the pages here.<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_extraBody_expl"]="With this, you can insert custom HTML right after the opening BODY tag of the pages. E.g. you can insert a banner above all the pages here.<br><br>This feature is not available in the Lite version of the program!";
$lll["settings_extraFooter"]="Contenus de pieds de pages additionnels";
// Changed in version 4.1.0. Old text:
//$lll["settings_extraFooter_expl"]="With this, you can insert custom HTML right before the closing BODY tag of the pages.<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_extraFooter_expl"]="With this, you can insert custom HTML right before the closing BODY tag of the pages.<br><br>This feature is not available in the Lite version of the program!";
$lll["customfield"]="Champ variable";
$lll["mustBeCommaSeparated"]="Les valeurs possibles du champ 'Sélection' doivent être définies sur une ligne et séparées par des virgules.";
$lll["invalidDefaultValue"]="La valeur par défaut du champ 'Sélection' doit être une des valeurs de la liste dans le champ valeur.";
$lll["description"]="Description";
$lll["descriptionDefaultLabel"]="Description";
$lll["privateField"]="Privé";
$lll["customfield_type_1"]="Texte";
$lll["customfield_type_2"]="Aire de texte";
$lll["customfield_type_3"]="Booléen";
$lll["customfield_type_4"]="Sélection";
$lll["customfield_type_6"]="Selection Multiple";
$lll["customfield_type_5"]="Séparateur";
$lll["customfield_type_7"]="Boite à cocher (Checkbox)";
$lll["customfield_type_8"]="Image";
$lll["customfield_type_10"]="Fichier media";
$lll["customfield_type_9"]="Lien Web";
$lll["customfield_type_11"]="Date";
$lll["customfield_dateDefaultNow"]="La date par défaut est aujourd'hui";
$lll["customfield_fromyear"]="Depuis l'année";
$lll["customfield_fromyear_expl"]="La fourchette du selecteur de date remplissant ce champ débutera sur l'année saisie ici.
                                   Vous pouvez rentrer une année normale comme '1971' ou bien 'now' qui correspond à l'année courante.
                                   Vous pouvez également utiliser une année relative: 'now-5' qui représentera un début de fourchette, 5 années avant l'année courante.";
$lll["customfield_toyear"]="Jusqu'à l'année";
$lll["customfield_toyear_expl"]="La fourchette du selecteur de date remplissant ce champ finira sur l'année saisie ici.
                                   Vous pouvez rentrer une année normale comme '2010' ou bien 'now' qui correspond à l'année courante.
                                   Vous pouvez également utiliser une année relative: 'now+5' qui représentera une fin de fourchette, 5 années après l'année courante.";
$lll["customfield_name"]="Nom";
$lll["customfield_type"]="Type";
$lll["customfield_default_multiple"]="Valeur par défaut";
$lll["customfield_default_text"]="Valeur par défaut";
$lll["customfield_default_bool"]="Valeur par défaut";
$lll["customfield_active"]="Actif";
$lll["customfield_separator"]="Colonne 1.";
$lll["customfield_mandatory"]="Obligatoire";
// Changed in version 3.0.0. Old text:
//$lll["customfield_showInList"]="Appears in list";
// New text:
//$lll["customfield_showInList"]="Show in lists for";
$lll["customfield_showInList"]="Afficher dans les listes pour";
$lll["customfield_values"]="Valeurs Possibles";
$lll["customfield_innewline"]="Placer sur une nouvelle ligne";
$lll["customfield_displaylength"]="Longueur d'affichage de la liste";
$lll["customfield_displaylength_expl"]="Le nombre maximum de caractères affichés sur la page de liste des annonces. L'apparence de la liste peut être restreinte pour éviter de déformer la cellule quand l'on affiche des valeurs trop longues.";
// Changed in version 3.1.0. Old text:
//$lll["customfield_searchable"]="Searchable";
// New text:
$lll["customfield_searchable"]="Afficher dans le formulaire de recherche pour";
$lll["customfield_rangeSearch"]="Permettre la fourchette de recherche";
// Changed in version 3.1.0. Old text:
//$lll["customfield_rangeSearch_expl"]="If this is checked than one can define e.g. '10-20' as a search condition to search for ads where the value of this field is between 10 and 20.";
// New text:
$lll["customfield_rangeSearch_expl"]="Si coché, l'utilisateur sera en mesure de définir par exemple '10-20' comme condition de recherche pour les annonces où la valeur de ce champ est comprise entre 10 et 20. L'utilisateur peux également définir une fourchette de date pour le cas des champs de date.";
$lll["customfield_allowHtml"]="Autoriser HTML";
// Changed in version 2.3.0. Old text:
//$lll["customfield_allowHtml_expl"]="This only allows 'save' HTML tags, however! Some tags that would impose a security risk, or ruin the layout are excluded.";
// New text:
//$lll["customfield_allowHtml_expl"]="This only allows 'safe' HTML tags, however! Some tags that would impose a security risk, or ruin the layout are excluded.";
// Changed in version 4.0.0. Old text:
//$lll["customfield_allowHtml_expl"]="This only allows 'safe' HTML tags, however! Some tags that would impose a security risk, or ruin the layout are excluded.";
// New text:
$lll["customfield_allowHtml_expl"]="This only allows 'safe' HTML tags, however! Some tags that would impose a security risk, or ruin the layout are excluded.<br><br>If you don't allow HTML, some simple rules will be still applied: line breaks in the text will be rendered as new lines, web links and email addresses will turn into clickable links.";
$lll["customfield_private"]="Garder le champ privé(non visible pour les visiteurs)";
// Changed in version 2.4.0. Old text:
//$lll["customfield_format_expl"]="You can use it a C-style sprintf format string";
// New text:
//$lll["customfield_format_expl"]="Advanced users can apply a C-style sprintf format string, too.";
$lll["customfield_subType"]="Traitement du champ comme";
$lll["customfield_subType_1"]="Texte";
$lll["customfield_subType_2"]="Nombre entier";
$lll["customfield_subType_3"]="Nombre réel";
$lll["customfield_sortable"]="Tri";
$lll["customfield_expl"]="Texte d'explication";
$lll["customfield_expl_expl"]="Texte d'aide comme celui que vous lisez maintenant, une description plus détaillée d'un champ de formulaire.";
$lll["private_field"]="(privé)";
$lll["customfield_newitem"]="Ajouter un nouveau champ personnalisé";
$lll["customfield_modify_form"]="Configuration des champs variables pour les annonces de cette catégorie";
$lll["customfield_create_form"]="Créer un champ personnalisé";
$lll["customfield_sortId"]="Trier";
$lll["customfield_sorthelp"]="Utilisez les flêches dans la colonne de 'Tri' pour ré-organiser la liste et cliquez sur le bouton de 'Sauvegarde du tri' en bas.";
$lll["customfield_savesorting"]="Sauvegarde du tri";
$lll["customfield_sortingsaved"]="Le nouveau tri du champ personnalisé a été sauvegardé avec succès.";
// Changed in version 3.0.0. Old text:
//$lll["customFields"]="List of custom fields of this category";
// New text:
//$lll["customFields"]="List of custom fields";
$lll["customFields"]="Editer les champs";
$lll["customfield_rowspan"]="Etendue des lignes";
$lll["customfield_seo"]="Optimisation pour les moteurs de recherche";
$lll["customfield_seo_0"]="Pas d'assignement";
// Changed in version 3.0.0. Old text:
//$lll["customfield_seo_1"]="Use this field as the TITLE of the ad";
// New text:
//$lll["customfield_seo_1"]="Use this field as the TITLE of the details page";
$lll["customfield_seo_1"]="Utilisez ce champ comme 'TITLE' (balise meta) de la page de détails.";
// Changed in version 3.0.0. Old text:
//$lll["customfield_seo_2"]="Use this field as the DESCRIPTION of the ad";
// New text:
//$lll["customfield_seo_2"]="Use this field as the DESCRIPTION of the details page";
$lll["customfield_seo_2"]="Utilisez ce champ comme 'DESCRIPTION' (balise meta) de la page de détails.";
// Changed in version 3.0.0. Old text:
//$lll["customfield_seo_3"]="Use this field as the KEYWORDS of the ad";
// New text:
//$lll["customfield_seo_3"]="Use this field as the KEYWORDS of the details page";
$lll["customfield_seo_3"]="Utilisez ce champ comme 'KEYWORDS' (balise meta) de la page de détails.";
// Changed in version 3.0.0. Old text:
//$lll["customfield_mainPicture"]="Use this field as the main picture of the ad";
// New text:
//$lll["customfield_mainPicture"]="Use this field as the main picture";
$lll["customfield_mainPicture"]="Utilisez ce champ pour l'image principale";
$lll["customfield_mainPicture_expl"]="Pour utiliser cette image dans une liste non spécifique à une catégorie ou un flux RSS.";
// Changed in version 2.4.0. Old text:
//$lll["customfield_seo_expl"]="You can specify here which custom field of the item will serve as the content of the HTML TITLE tag, DESCRIPTION tag and KEYWORDS tag, respectively. 
//                              Besides SEO, the content of the TITLE fields will appear in the title bar of the browser when one 
//                              displays the ad, it will be used as the title of the ad in non category specific ad lists and in RSS feeds.
//                              The fields designated as the KEYWORD will not be displayed on the ad page - it will only be visible in the create and modify forms of the ads.";
// New tex:
//$lll["customfield_seo_expl"]="You can specify here which custom field of the item will serve as the content of the HTML TITLE tag, DESCRIPTION tag and KEYWORDS tag, respectively. 
//                              Besides SEO, the content of the TITLE fields will appear in the title bar of the browser when one 
//                              displays the ad, it will be used as the title of the ad in non category specific ad lists and in RSS feeds.";
$lll["customfield_seo_expl"]="Vous pouvez spécifier ici quel champ personnalisé de l'élément servira comme contenu respectif des balises HTML TITLE, DESCRIPTION et KEYWORDS. 
                              Outre l'optimisation pour les moteurs de recherche, le contenu des champs 'TITLE' apparaîtra dans la barre de titre du navigateur lorsque l'on affiche l'annonce, et sera utilisé comme titre de l'annonce dans une liste non-spécifique à une catégorie ainsi que dans les flux RSS.";
$lll["customfield_innewline_expl"]="Au lieu de former une nouvelle colonne, ce réglage affiche la valeur du champ personnalisé dans une nouvelle ligne qui s'étend à toutes les autres colonnes horizontalement et placée en dessous.";
// Changed in version 2.3.0. Old text:
//$lll["customfield_rowspan_expl"]="Use this in conjunction with the 'Place in new line' property of other custom fields. If there are other fields which has been placed in a new line, you can specify with this setting that this fields spans over those new lines vertically.";
// New text:
//$lll["customfield_rowspan_expl"]="Use this in conjunction with the 'Place in new line' property of other custom fields. If there are other fields which has been placed in a new line, you can specify with this setting that this field spans over those new lines vertically.";
$lll["customfield_rowspan_expl"]="Utilisez ceci en conjonction avec la propriété 'Placer dans une nouvelle ligne' des autres champs personnalisés. Si il y a d'autres champs ayant été placés dans une nouvelle ligne, vous pouvez spécifier avec ce réglage, que ce champ s'étend verticalement sur ces nouvelles lignes.";
$lll["notification"]="notification";
$lll["notification_ttitle"]="Notifications";
$lll["Notifications"]="Notifications";
$lll["notification_subject"]="Objet du mail";
$lll["notification_body"]="Corps du mail";
$lll["notification_variables"]="Variables autorisées";
$lll["notification_active"]="Activer";
$lll["notification_modify_form"]="Modifier la notification";
$lll["notif_remindpass_tit"]="Contient un nouveau mot de passe si l'utilisateur a oublié l'ancien.";
$lll["notif_remindpass_subj"]="Nouveau mot de passe";
$lll["notif_initpass_tit"]="Envoyer à l'utilisateur après inscription, avec le mot de passe initial";
$lll["notif_initpass_subj"]="Mot de passe initial";
$lll["notification_cc"]="CC";
$lll["notification_cc_expl"]="Indiquer ici l'adresse email ou la notification devra être envoyée en copie carbone (CC).";
$lll["notification_active_expl"]="Vous pouvez changer ici l'envoi ou non de cette notification.";
?>