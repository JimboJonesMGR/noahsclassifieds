<?php
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
$lll["category_inactivateOnModify"]="Inactivate on modify";
$lll["category_inactivateOnModify_expl"]="Whether an approved ad becomes pending again if the owner of the ad modifies it.";
$lll["clonecat_create_form"]="Clone category";
$lll["clonecat_amount"]="Number of clones";
$lll["clonecat_amount_expl"]="Creating many clones - especially if you clone the sub categories and pictures, too - can take quite a long time and you should not close the browser during that!";
$lll["clonecat_name"]="Clone with name";
$lll["clonecat_name_expl"]="If you are creating more than one clones, you can apply numbering in their names if you insert '%d' here. E.g. 'Cars-%d' will result in the following clones: Cars-1, Cars2, Cars-3, etc.";
$lll["clonecat_recursive"]="Clone sub categories, too";
$lll["clonecat_withPictures"]="Clone the category pictures, too";
$lll["categoriesCloned"]="The categories have been successfully cloned.";


// Added in 3.1.2:
$lll["commonFieldAlreadyExists"]="A common field with this name and type already exists. Please, choose an other name!";


// Added in 3.1.0:
$lll["checkUpdatesDescription"]="Check out if a newer version of Noah's Classifieds has been released. You can even perform the update immediately, or download the update package with a single click!";
// Changed in version 4.1.0. Old text:
//$lll["checkconfDescription"]="Click here any time to verify if the program has been set up correctly. In case of any problems being detected, the Check page gives useful hints how to solve them.";
// New text:
$lll["checkconfDescription"]="Click here at any time to verify if the program has been set up correctly. In case of any problems being detected, the Check page gives useful hints how to solve them.";
$lll["rssDescription"]="Set up the properties of the RSS feed the program generates.";
$lll["settings_langDir_expl"]="If you enable more languages - some with left to right direction and some with right to left, you should rather specify the direction in the lang file itself! E.g. if you have an Arabian language file, you can put a line like this in it, in order to override this setting in case of the Arabian language:<br><br>$langDir='rtl';<br><br>Use 'rtl' for 'right to left' and 'ltr' for 'left to right'!";
// Changed in version 4.0.0. Old text:
//$lll["customfield_values_expl"]="This must be a comma separated list of possible values. E.g. one,two,three";
// New text:
$lll["customfield_values_expl"]="Use this tool to add, remove or modify the possible values! You can also change their order by drag-and-drop. Set the default value(s) using the checkboxes!";
$lll["itemfield_ttitle_global"]="Common custom fields";
$lll["searchable_0"]="none";
$lll["searchable_1"]="all";
$lll["customlist_displayedFor_1"]="all";
$lll["searchable_2"]="logged in users only";
$lll["customlist_displayedFor_2"]="logged in users only";
$lll["searchable_4"]="admin only";
$lll["customlist_displayedFor_4"]="admin only";
$lll["customfield_isCommon"]="Scope of the field";
$lll["customfield_isCommon_colhead"]="Scope";
$lll["common"]="Common";
$lll["unique"]="Unique";
$lll["customfield_isCommon_expl"]="If you set the scope to common, the field will exist in every categories. E.g.: if you have a web shop, whatever categories you set up, a 'Price' field must probably belong to all of them, so the 'Price' is best to define as a common field. If you create a common field, or change a unique field to common, it will suddenly appear in all categories - not just there where you created it. If you delete a common field, it will dissappear from all the categories at once.<br><br>Even if a field is common, it can be differently set up in different categories. E.g. you can set it to appear on the ad details page in one category, but hide it in an other category. Only the 'Name' and the 'Type' properties have to be really equal in all categories.<br><br>You can even set up your classifieds program so that all the fields are common! In some cases, it can make a good sense: e.g. if you have cars and only cars in every categories, probably all the categories have just the same list of custom fileds. The strength of the common fields will really show up in defining custom ad lists! E.g. the 'Recent ads' list can contain ads from many different categories, but if you have common fields, you need not be restricted to show only the 'Title', 'Description', and 'Category' columns in the list any more - you can choose any common field to be a column in the list!";
$lll["customfield_isCommon_0"]="Unique to this category";
$lll["customfield_isCommon_1"]="Common to all the categories";
$lll["userfield_create_completed"]="The custom field has been successfully created.";
$lll["itemfield_create_completed"]="The custom field has been successfully created.";
$lll["itemfield_columnIndex"]="Column index";
$lll["NotificationsDescription"]="Manage the list of notifications here - the emails the program sends out automatically on certain actions.";
$lll["category_restartExpOnModify"]="Restart expiration on modify";
$lll["category_restartExpOnModify_expl"]="You can use this as an alternative of the ad prolonging. If checked and the owner modifies his or her ad (and admin approves it if moderation has been enabled), the ad expiration will start again.";
$lll["controlPanel"]="Control panel";
$lll["controlpanel_ttitle"]="";
$lll["customlist_ttitle"]="Custom lists";
$lll["customlist"]="Custom list";
$lll["customlist_listTitle"]="Title";
$lll["customlist_listDescription"]="Description";
$lll["customlist_listDescription_expl"]="Some notes that can better describe what this custom list is all about. Only visible for admin.";
$lll["customlist_create_form"]="Create custom list";
$lll["customlist_modify_form"]="Modify custom list";
$lll["customlist_newitem"]="Add new custom list";
$lll["checkCustomLists"]="Whenever you delete a custom field, check all the custom lists where a search condition has been supplied by clicking on their Title, because they may become invalid if they referred to the just deleted custom field in their condition!";
$lll["listDisplayProperties"]="List display properties";
$lll["customlist_primarySort"]="Primary sort by";
$lll["customlist_primaryDir"]="Primary sort direction";
$lll["customlist_secondaryDir_DESC"]="Descending";
$lll["customlist_primaryDir_DESC"]="Descending";
$lll["customlist_secondaryDir_ASC"]="Ascending";
$lll["customlist_primaryDir_ASC"]="Ascending";
$lll["customlist_primaryPersistent"]="Primary sort is persistent";
$lll["customlist_primaryPersistent_expl"]="If you leave this unchecked, the users can override the initial sorting of the list by clicking on the sorting icons in the list column headers. If you check this, however, you can force specific ads to always appear say on the top of the list however the users sort the list.<br><br>E.g. if you have a custom field called 'Sponsoring level' with values say 'Gold', 'Silver', 'Bronze' and 'None', you can create a custom list with a persistent sorting by 'Sponsoring level' descending. The Gold ads will always appear on the top of the list then and the non-sponsored ads on the bottom of the list.";
$lll["customlist_secondarySort"]="Secondary sort by";
$lll["customlist_secondaryDir"]="Secondary sort direction";
$lll["customlist_secondaryPersistent"]="Secondary sort is persistent";
$lll["customlist_limit"]="Limit";
// Changed in version 3.1.2. Old text:
//$lll["customlist_limit_expl"]="You can limit the number of ads the list contains. Leave it blank for no limit. E.g. 10 means, the list will display only the first 10 ads in the given sorting order from all the matching ads.";
// New text:
$lll["customlist_limit_expl"]="You can limit the number of ads the list contains. Leave it blank for no limit. E.g. 10 means, the list will display only the first 10 ads in the given sorting order from all the matching ads. If you display this list as a scrollable widget, it is always a good idea to set a reasonable, not too high limit, so that the pages with widgets load faster and have less resource consumption both on the cient and on the server side!";
$lll["customlist_columns"]="Select columns to display";
$lll["customlist_columns_expl"]="If you select more than one, you can re-arrange them by drag-and-drop! 
The columns will be displayed in the order you specify here.<br><br>
So that a column is really displayed in a list, note that it is not enough that you add it here! 
The user who displays the list must have also permission to see that column! 
The visibility of a column can be set from two places depending on the scope of the given field:<br><br>
&nbsp;&nbsp;1. If you want to set the visibility of a column that is in a non-category specific list, 
you can do it from the 'Common custom fields' list (open the modify form and edit the 'Show in lists for' property),<br><br>
&nbsp;&nbsp;2. If you want to set the visibility of a column that is in a category specific list, 
you can do it from the 'List of custom fields of this category' list (open the modify form and edit the 'Show in lists for' property)";
$lll["customlist_displayedFor"]="Display list for";
$lll["customlist_displayedFor_expl"]="Whatever you select here, admin will always be able to view the list by clicking on its Title in the 'List of custom lists'!";
$lll["customlist_pages"]="Display on these pages";
// Changed in version 4.1.0. Old text:
//$lll["customlist_pages_expl"]="You can specify a page with its link. E.g. '/item/1' is the details page of ad with ID 1. Use '/' to denote the start page. You can list more pages - one in every line. You can use the '*' wildcard to match more than one pages - e.g.: '/list/*' means all the category listing pages, '/item/*' means all the ad details pages. You can exclude pages by adding the '!' prefix. A more complex example: <br><br>/user/login_form<br>/item/create_form<br>/list/*<br>!/list/1<br>!/list/2<br>/item/4<br>/item/5<br><br>The above says \"display the list on the login page, on the ad submit page, on every category listing pages except of the category with ID 1 and 2, and on the details pages of ads with ID 4 and 5!\"<br><br>This feature doesn't work in the free version!";
// New text:
$lll["customlist_pages_expl"]="You can specify a page with its link. E.g. '/item/1' is the details page of ad with ID 1. Use '/' to denote the start page. You can list more pages - one in every line. You can use the '*' wildcard to match more than one pages - e.g.: '/list/*' means all the category listing pages, '/item/*' means all the ad details pages. You can exclude pages by adding the '!' prefix. A more complex example: <br><br>/user/login_form<br>/item/create_form<br>/list/*<br>!/list/1<br>!/list/2<br>/item/4<br>/item/5<br><br>The above says \"display the list on the login page, on the ad submit page, on every category listing pages except of the category with ID 1 and 2, and on the details pages of ads with ID 4 and 5!\"<br><br>This feature does not work in the Lite version!";
$lll["customlist_categorySpecific"]="Content depends on the current category";
// Changed in version 3.1.2. Old text:
//$lll["customlist_categorySpecific_expl"]="If you check this and the custom list is just displayed on a page that is in a \"categy context\" (e.g. on a category listing page or ad details page), the custom list will only include the ads of the given category. This is usefulfif you have a custom list called say 'Featured list' and you want to make this list to be context sensitive - so that when a user is just under the Cars category, it displays the featured cars and when the user is just under the 'Dating' category, it contains the featured dating ads.";
// New text:
$lll["customlist_categorySpecific_expl"]="If you check this and the custom list is just displayed on a page that is in a \"category context\" (e.g. on a category listing page or ad details page), the custom list will only include the ads of the given category. <br><br>This is useful if you have a custom list called say 'Featured list' and you want to make this list to be context sensitive - so that when a user is just under the Cars category, it displays the featured cars and when the user is just under the 'Dating' category, it contains the featured dating ads.";
$lll["customlist_recursive"]="and includes ads from the current category AND any of its subcategories";
$lll["customlist_listStyle"]="List style";
$lll["customlist_listStyle_0"]="Normal list";
$lll["customlist_listStyle_1"]="Scrollable widget";
$lll["customlist_listStyle_expl"]="Visit the demo installation http://noahsclassifieds.org/v8rss/ to see how the 'Scrollable widget' style looks like!";
$lll["customlist_positionScrollable"]="Position";
$lll["customlist_positionNormal"]="Position";
$lll["customlist_positionScrollable_expl"]="The place where the list appears on the page";
$lll["customlist_positionNormal_expl"]="The place where the list appears on the page";
$lll["customlist_positionScrollable_0"]="Above the content";
$lll["customlist_positionNormal_0"]="Above the content";
$lll["customlist_positionScrollable_1"]="Below the content";
$lll["customlist_positionNormal_1"]="Below the content";
$lll["customlist_positionScrollable_4"]="On the left side of the page";
$lll["customlist_positionScrollable_5"]="On the right side of the page";
$lll["customlist_positionScrollable_2"]="On the top of the page";
$lll["customlist_positionScrollable_3"]="On the bottom of the page";
$lll["customlist_displayInMenu"]="Assign menu point in menu";
$lll["customlist_displayInMenu_expl"]="If you don't want that the list is displayed on some of the existing pages, you can assign a menu point to it, so that the users access the list on its separate page. E.g.: the good old 'Recent ads', 'Popular ads', 'Pending ads' and 'Approved ads' menu points are from now on just links to the corresponding custom lists!";
$lll["customlist_displayInMenu_0"]="None";
$lll["customlist_displayInMenu_1"]="Login menu";
$lll["customlist_displayInMenu_2"]="User menu";
$lll["customlist_displayInMenu_3"]="Admin menu";
$lll["customlist_displayInMenu_4"]="Category menu";
$lll["randomOrder"]="-- Random order --";
$lll["noDefaultSort"]="-- No sorting --";
$lll["selectField"]="-- Select field --";
$lll["currentUser"]="-- Current user --";
$lll["customlist_ownerName_expl"]="If you select 'Current user', the list will always only contain the ads of the currently logged in user. E.g. this has been used in the setup of the 'My ads' custom list!";
$lll["customlist_loop"]="Loop ads";
$lll["customlist_loop_expl"]="Whether scrolling starts over when last item is exceeded";
$lll["customlist_autoScroll"]="Auto scroll in every (seconds)";
$lll["customlist_autoScroll_expl"]="Use 0 to disable auto scroll";
$lll["customlist_cache"]="Cache list content and renew the cache in every (minutes)";
$lll["customlist_cache_expl"]="So that pages that display custom lists can be faster, it is possible to cache the content of the list on the server. Use 0 to disable caching!";


// Added in 3.0.0:
// Changed in version 3.1.3. Old text:
//$lll["versionTooLow"]="Required minimum MySql version is %s. The current one is %s. Required minimum MySql version is %s. The current one is %s.";
// New text:
$lll["versionTooLow"]="Required minimum MySql version is %s. The current one is %s. Required minimum Php version is %s. The current one is %s.";
$lll["settings_joomlaLink"]="Joomla site";
$lll["settings_joomlaLink_expl"]="If you have installed a Joomla bridge, you can enter the URL of your main Joomla site here. If you do that, the login menu will contain a 'Main site' menu point that links to the URL.";
$lll["enableUserSearch"]="Enable user search";
$lll["enableUserSearch_expl"]="This feature is not available in the Evaluation version!";
$lll["appsettings_modify_completed"]="The settings have been successfully modified";
$lll["settings_langDir"]="Language direction";
$lll["settings_langDir_ltr"]="Left to right";
$lll["settings_langDir_rtl"]="Right to left";
$lll["customfield_fixInfoText"]="This is a \"fix\" field which means that you can't delete it and you can only change some of its properties.";
$lll["selectUserField"]="-- Select user field --";
$lll["customfield_userField"]="or select one of the user fields";
$lll["customfield_userField_expl"]="Instead of creating a completely new custom field by entering a Name for it above, you have the option to select one of the user fields for display. This way, the fields of the owner of an ad can be displayed directly in either the ad list or on the ad details page. <br><br>E.g. you can add the phone number of the owner of the ad to the ad details page. Or if you have a custom 'Zip code' user field, you can display it, too. Moreover, if you specify the Zip code as 'Searchable', users will be able to search for ads by zip code!";
$lll["userField"]="User field";
$lll["customfield_checkboxCols"]="Number of columns to display the checkboxes in";
$lll["userfield_displayLabel_expl"]="If checked off, the field label will not be displayed on the user details page and the field value will span over the labels of the other fields.";
$lll["userfield_displaylength_expl"]="The maximum number of characters that are displayed on the user list page. The appearance of the list view can be protected against displaying very long fields in a cell.";
$lll["userfield_rangeSearch_expl"]="If this is checked than one can define e.g. '10-20' as a search condition to search for user where the value of this field is between 10 and 20.";
$lll["userfield_subType_expl"]="";
$lll["itemfield_ttitle"]="Custom fields of category '%s'";
$lll["customfield_advanced_form"]="Advanced operations";
$lll["userfield_mainPicture_expl"]=" ";
$lll["userfield_seo_expl"]="You can specify here which custom field of the user will serve as the content of the HTML TITLE tag, DESCRIPTION tag and KEYWORDS tag, respectively.";
$lll["userfield_detailsPosition_expl"]="The placement of the fields on the user details page. The 'sidebar' is the right area of the details panel where the pictures reside (in the modern theme). You can place fields above the pictures area, or below them with this setting.";
$lll["customfield_showInForm"]="Show in forms for";
$lll["userfield_showInForm_expl"]="Note that in case of fix user fields, this setting has a limited meaning only! E.g. if you set the 'Name' field to be displayed for admin only, it only refers to the user modify form (i.e. you can't hide the 'Name' field from the registration and the login forms). Similarly, you can't hide the 'Email' field from the registration form.";
$lll["subscriptionType_0"]="none";
$lll["enableFavorities_0"]="none";
$lll["showInDetails_0"]="none";
$lll["showInList_0"]="none";
$lll["showInForm_0"]="none";
$lll["enableUserSearch_0"]="none";
$lll["subscriptionType_1"]="all";
$lll["enableFavorities_1"]="all";
$lll["showInDetails_1"]="all";
$lll["showInList_1"]="all";
$lll["showInForm_1"]="all";
$lll["enableUserSearch_1"]="all";
$lll["enableFavorities_2"]="logged in users only";
$lll["subscriptionType_2"]="logged in users only";
$lll["showInDetails_2"]="logged in users only";
$lll["showInList_2"]="logged in users only";
$lll["showInForm_2"]="logged in users only";
$lll["enableUserSearch_2"]="logged in users only";
$lll["showInDetails_3"]="owner of the ad only";
$lll["showInList_3"]="owner of the ad only";
$lll["showInForm_3"]="owner of the ad only";
$lll["enableFavorities_4"]="admin only";
$lll["subscriptionType_4"]="admin only";
$lll["showInDetails_4"]="admin only";
$lll["showInList_4"]="admin only";
$lll["showInForm_4"]="admin only";
$lll["enableUserSearch_4"]="admin only";
$lll["subscriptionType_5"]="all but admin";
$lll["enableFavorities_5"]="all but admin";
$lll["userfield_ttitle"]="Custom fields of the users";
$lll["userfield_type_expl"]="";
$lll["methods"]="Methods";
$lll["clone"]="clone";
$lll["copyOfCategory"]="Copy of '%s'";
$lll["organizeNextPageDrop"]="Hover the mouse here when dragging to place the category in the next page.";
$lll["organizePreviousPageDrop"]="Hover the mouse here when dragging to place the category in the previous page.";
$lll["organizeNextItems"]="next categories &raquo;";
$lll["organizePreviousItems"]="&laquo; previous categories";
// Changed in version 4.1.0. Old text:
//$lll["fieldset_create_form"]="Advanced operations on the whole list of custom fields of the category (they don't work in the free version!)";
// New text:
$lll["fieldset_create_form"]="Advanced operations on the whole list of custom fields of the category (they don't work in the Lite version!)";
$lll["fieldset_deleteAll"]="Delete all fields";
// Changed in version 3.1.0. Old text:
//$lll["fieldset_deleteAll_expl"]="This will delete all the non-fix custom fields of this category at once.<br><br>Please note that deleting custom fields causes data loss, because the corresponding ad field values will be deleted, too!";
// New text:
$lll["fieldset_deleteAll_expl"]="This will delete all the unique custom fields of this category at once.<br><br>Please note that deleting custom fields causes data loss, because the corresponding ad field values will be deleted, too!";
$lll["fieldset_cloneToSubcats"]="Clone into sub categories";
$lll["fieldset_cloneToSubcats_expl"]="This list of custom fields will be applied in every sub categories of this category.<br><br>Please note that if the sub categories have custom fields already, they will be deleted first! So, this operation is mainly useful for setting up new categories, because it may cause data loss in categories that have ads already.";
$lll["fieldset_cloneToCats"]="Clone into categories";
$lll["fieldset_cloneToCats_expl"]="This list of custom fields will be applied in every category you select on the right (you can select more!).<br><br>Please note that if the categories have custom fields already, they will be deleted first! So, this operation is mainly useful for setting up new categories, because it may cause data loss in categories that have ads already.";
$lll["fieldset_cloneFromCat"]="Clone from category";
$lll["fieldset_cloneFromCat_expl"]="This is the opposite of the previous operation: it will replace all the existing custom fields of this category with the field list of an other category. The same is applied to this one, too: it can cause data loss if if this category has ads already!<br><br>Just to make it completely clear: none of the cloning operations actually copy ads or ad values! And they don't copy categories either! They copy custom field lists with all their properties. Relocating ads from one category into an other is possible with the 'move' feature on a per advertisement basis. If you want to create duplicates of whole categories (with all their custom fields, but without their ads and sub categories!), you can use the 'clone' feature under the 'Organize categories' menu point.";
$lll["fieldset_deleteAll_successful"]="The custom fields have been successfully deleted";
$lll["fieldset_cloneToSubcats_successful"]="The custom fields have been successfully cloned to the sub categories";
$lll["fieldset_cloneToCats_successful"]="The custom fields have been successfully cloned to the selected categories";
$lll["fieldset_cloneFromCat_successful"]="The custom fields of the selected category have been successfully cloned here";
$lll["fields"]="fields";


// Added in 2.4.0:
$lll["settings_charLimit_expl"]="'0' means no limit.";
$lll["settings_extraTopContent"]="Additional top content";
// Changed in version 4.1.0. Old text:
//$lll["settings_extraTopContent_expl"]="With this, you can insert custom HTML below the header section of the pages (status bar, menus).<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_extraTopContent_expl"]="With this, you can insert custom HTML below the header section of the pages (status bar, menus).<br><br>This feature is not available in the Lite version of the program!";
$lll["settings_extraBottomContent"]="Additional bottom content";
// Changed in version 4.1.0. Old text:
//$lll["settings_extraBottomContent_expl"]="With this, you can insert custom HTML above the powered footer of the pages.<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_extraBottomContent_expl"]="With this, you can insert custom HTML above the powered footer of the pages.<br><br>This feature is not available in the Lite version of the program!";
$lll["customfield_subType_expl"]="E.g. if you have a 'Price' field, it is wise to set it as a 'Float number', so that the sorting by the Price column and range search by the price field can properly work. You can then enter the necessary currency symbol prefix, precision and thousands separator settings under the 'Display formatting' section.";
$lll["formatSection"]="Display Formatting";
$lll["customfield_formatPrefix"]="Prefix";
$lll["customfield_useMarkitup"]="Use embedded HTML editor instead of a simple textarea";
$lll["category_expirationEnabled"]="Enable expiration";
$lll["category_expirationOverride"]="Allow expiration override for";
$lll["category_allowSubmitAdAdmin"]="Only admin can submit ads in this category";
$lll["category_expirationOverride_expl"]="If you enable this, the 'Number of days before the ad expire' field will appear in the ad create/modify form and the owner can enter a number. If you specified '0' in the above field, they can enter an arbitrary number. If you specified anything greater than null, it will serve as the default and in one as the maximum number of days the owner can enter.";
$lll["category_expirationOverride_0"]="None";
$lll["category_expirationOverride_2"]="All users";
$lll["category_expirationOverride_4"]="Admin only";
$lll["category_organize"]="Organize categories";
$lll["exp"]="Expiration";
$lll["useDragAndDrop"]="Use drag-and-drop to reorganize the categories then click on 'Save order'!";
$lll["organizeSaveButton"]="Save order";
$lll["organizeSaveMessage"]="The category order has been successfully saved";
$lll["organizeSaveError"]="Could not send the data to the server.";
$lll["organizeLoadError"]="Could not load the data from the server.";


// Added in 2.3.0:
$lll["appFileRemoveExpl"]="From version 2.3.0, most of the php files that used to be directly under the installation directory, must reside under the htaccess-protected 'app' sub directory.
                           The installation root directory may only contain 'index.php' and 'initdir.php'.";
$lll["appFileRemove"]="In order to start using the program, you have to remove the following unnecessary php files from the installation root: <span class='confexpl'>%s.</span><br><br><a href='%s'>Click here to remove them!</a><span class='confexpl'> (If this message doesn't disappear after you clicked, it means the program has no permission to remove these files. In this case, you must delete them manually!)</span>";
$lll["backupFileRemoveExpl"]="From security reasons, the backup directories created by the automatic updates have to be deleted. If you still need them, save them somewhere above your web root!";
$lll["backupFileRemove"]="In order to start using the program, you have to remove the following backup directories from the installation root: <span class='confexpl'>%s.</span><br><br><a href='%s'>Click here to remove them!</a><span class='confexpl'> (If this message doesn't disappear after you clicked, it means the program has no permission to remove these files. In this case, you must delete them manually!)</span>";
$lll["systemConfCheck"]="System configuration checking...";
$lll["niceURLFeature"]="Nice URL feature:";
$lll["niceURLFeature_1"]="Noah's Classifieds supports using nice URLs. This means for example that the link of an ad details page can look like this:";
$lll["niceURLFeature_2"]="instead of the current solution:";
$lll["niceURLFeature_3"]="Besides that the former one is nicer, it is also said to be more search engine friendly.";
$lll["niceURLFeature_4"]="So that the nice URL feature works the Apache module called %s must be installed. It can't be find out for sure whether it is installed currently (Php is probably installed as a CGI binary).";
$lll["niceURLFeature_5"]="If %s is already installed, you should create a file under the classifieds installation directory called %s and put the following text in it, in order to enable nice URLs:";
// Changed in version 4.0.0. Old text:
//$lll["niceURLFeature_6"]="If after doing this, the nice url feature still doesn't work, you should also check the following in the Apache configuration file:";
// New text:
$lll["niceURLFeature_6"]="If after doing this, the nice url feature still doesn't work, you should  <a href='http://noahsclassifieds.org/documentation/configuration/rewriterules' target='_blank'>click here to learn more about the possible troubleshooting!</a>";
$lll["niceURLFeature_9"]="So that the nice URL feature works the Apache module called %s must be installed. It's not installed currently.";
$lll["reg_companyName"]="Company name";
$lll["reg_firstName"]="First name";
$lll["reg_lastName"]="Last name";
$lll["reg_email"]="Email";
$lll["reg_submit"]="Submit";
$lll["securityProperties"]="Security settings";
$lll["settings_applyCaptcha"]="Apply Spam protection (CAPTCHA) in the following forms";
$lll["settings_applyCaptcha_1"]="'Reply to this posting' and 'Email this to a friend'";
$lll["settings_applyCaptcha_2"]="Login form";
$lll["settings_applyCaptcha_3"]="Register form";
$lll["settings_applyCaptcha_4"]="Ad submission";
$lll["customfield_displayLabel"]="Display label";
$lll["customfield_displayLabel_expl"]="If checked off, the field label will not be displayed on the ad details page and the field value will span over the labels of the other fields.";
$lll["customfield_detailsPosition"]="Position";
$lll["customfield_detailsPosition_expl"]="The placement of the fields on the ad details page. The 'sidebar' is the right area of the details panel where the pictures reside (in the modern theme). You can place fields above the pictures area, or below them with this setting.";
$lll["customfield_detailsPosition_0"]="Normal";
$lll["customfield_detailsPosition_1"]="Top of the sidebar";
$lll["customfield_detailsPosition_2"]="Bottom of the sidebar";
$lll["formProperties"]="Form settings";
$lll["listProperties"]="List settings";
$lll["detailsProperties"]="Details page settings";
$lll["searchProperties"]="Search settings";
$lll["miscProperties"]="Miscellaneous settings";
$lll["customfield_showInDetails"]="Displayed for";


// Installation:
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
$lll["db_installed"]="Base de Datos instalada: %s";
// Changed in version 4.1.0. Old text:
//$lll["cantcreatedb"]="Can not reach or create database. User %s has no create database permission, or cannot reach the database. Change the name of the user or give him appropriate rights!";
// New text:
$lll["cantcreatedb"]="Help! NOAH Cannot reach or create your database. User %s has no create database permission, or cannot reach the database. Change the name of the user or give it the appropriate rights!";
// Changed in version 4.1.0. Old text:
//$lll["cantconnectdb"]="Can not connect to database. May be have no rights or not exists, trying to create.";
// New text:
$lll["cantconnectdb"]=" Help! NOAH Cannot connect to database. Odds are there no rights or does not exist, trying to create.";
$lll["inst_create_table_err"]="Error al tratar de crear Tablas, %s ya está instalado?";
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
$lll["inst_click"]="Presíone aquí para accesar %s.";
// Changed in version 4.1.0. Old text:
//$lll["createTableFailed"]="Create table failed";
// New text:
$lll["createTableFailed"]="Ouch! Create table failed";
$lll["install"]="Instalar";
$lll["clickToInstall"]="Presíone en 'Instalar' para continuar con %s!";
$lll["admin_ok"]="Administrador ha sido creado, Nombre: ADMIN, Contraseña: ADMIN.";
// Changed in version 4.1.0. Old text:
//$lll["create_file_ok"]="Config has been successfully created.";
// New text:
$lll["create_file_ok"]="Awesome!!! Config has been successfully created.";
// Changed in version 4.1.0. Old text:
//$lll["create_file_nok"]="Config file have to be created manually.";
// New text:
$lll["create_file_nok"]="Ouch! Config file have to be created manually, it happens.";
$lll["inst_params"]="Base de Datos MySQL será creada con los siguientes parámetros:";
$lll["edit_params"]="Editar parámetros";
$lll["acceptTerms"] = "He leído y Aceptado los Términos y Condiciones: <input type='checkbox' id='accept' name='accept'>";
$lll["youMustAcceptTerms"] = "Para continuar debe aceptar los Términos y Condiciones";
$lll["dbHostName"]=$lll["hostName"]="Nombre Host";
$lll["mysqluser"]="Usuario MySQL";
$lll["dbDbName"]=$lll["dbName"]="Nombre Base de Datos";
$lll["dbSocket"]="Socket";
$lll["formtitle"]="Configuración MySQL";
$lll["password"]="Contraseña";
$lll["dbPort"]="Puerto";
$lll["cookieok"]="Cookies Activadas";
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
$lll["afterwrconf"]="<u>Después</u> de escribir el Archivo CONFIG presione el vínculo de abajo";
$lll["move_inst_file"]="Por favor remueva el archivo INSTALL.PHP del directorio!";
// Changed in version 4.1.0. Old text:
//$lll["inst_ch_pw"]="Administrator settings - username: admin, password: admin, don't forget to change the password!";
// New text:
$lll["inst_ch_pw"]="Administrator settings - username: admin, password: admin, and don't forget to change the password!";
$lll["create_file_nok_ext"]="El Servidor no tiene permisos de crear el Archivo CONFIG. Tiene 2 opciones:<br>\n#1: Crear un archivo vacío llamado APP/CONFIG.PHP en el directorio del programa y asignarle derechos CHMOD 777 (Unix) y recargué página y continue proceso de instalación.<br>#2: Proceda a instalar y cree el Archivo APP/CONFIG.PHP manualmente el programa le mostrará que Código insertar en ese Archivo, suba via FTP el archivo al directorio donde se encuentra el programa y prosiga con la instalación.";
// Register:
$lll["registerNoah"]="Registrarse";
$lll["notRegistered"]="No registrado"; 
$lll["registerNoahTitle"]="Registrar Clasificados Noah"; 
// Changed in version 4.1.0. Old text:
//$lll["noahAlreadyRegistered"]="The product is already registered!";
// New text:
$lll["noahAlreadyRegistered"]="Your NOAH is already registered!";
$lll["noahRegistrationFalseResponse"]="Incapaz de enviar datos de registro al servidor de Clasificados Noah. Favor intentar mas tarde!"; 
// Changed in version 4.1.0. Old text:
//$lll["noahRegistrationSuccessfull"]="Thank you. The product is now registered!";
// New text:
$lll["noahRegistrationSuccessfull"]="Thank you. Your NOAH is now registered!";
// Update:
$lll["download"]="Bajar";
$lll["u_maintitle"]="Procéso de acualización de Clasificados Noah";
// Changed in version 4.1.0. Old text:
//$lll["secure_copy"]="It is recommended to make a dump of your Noah's Classifieds database before the update!";
// New text:
$lll["secure_copy"]="It is recommended to make a databse dump of your Noah's Classifieds before the update!";
$lll["ready_to_update"]="Listo para actualizar %s a la versión %s?<br>";
// Changed in version 4.1.0. Old text:
//$lll["invalid_version"]="The given version is invalid: %s";
// New text:
$lll["invalid_version"]="hmm...The given version is invalid: %s";
// Changed in version 4.1.0. Old text:
//$lll["updateSuccessful"]="The update successfully completed.";
// New text:
$lll["updateSuccessful"]="The NOAH update successfully completed.";
$lll["updating"]="Actualizando de la versión %s a la versión %s...";
// Changed in version 4.1.0. Old text:
//$lll["already_installed"]="The latest software version %s is already installed.";
// New text:
$lll["already_installed"]="The latest NOAH software version %s is already installed.";
$lll["picturesDirMustbeWritable"]="El directorio '%s' debe ser accesible para llevar acabo la actualización! Falló actualización.";
$lll["updateAutomatic"]="Actualización";
$lll["updateManualZip"]="Bajar Archivo ZIP";
$lll["updateManualTgz"]="Bajar Archivo TGZ";
$lll["downloadFileNotExists"]="No existe Archivo '%s'.";
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
$lll["checkUpdates"]="Actualizar"; 
$lll["checkUpdatesTitle"]="Revisando sitio Clasificados Noah por actualizaciones disponibles";
// Changed in version 4.1.0. Old text:
//$lll["nopermission"]="The program has no write permission under the following directories: %s<br>You must execute the following Unix command (in Unix systems, of course):<br><i>chmod 777 &lt;replace directory name&gt;</i>";
// New text:
$lll["nopermission"]="The NOAH program has no write permission under the following directories: %s<br>You must execute the following Unix command (in Unix systems, of course):<br><i>chmod 777 &lt;replace directory name&gt;</i>";
$lll["nopermission_expl"]="Durante su operación, Clasificados Noah tiene que guardar archivos en ciertos sub-directorios, para subir imagenes, registrar errores o crear archivos de caché; asegurate que el programa tenga los permisos correspondientes.)";
$lll["backToIndex"]="Regresar a Clasificados.";
$lll["onlyFrom1.3"]="Tienes una versión anterior a v1.3 Esta actualización solo trabaja con v1.3 en adelante!";
$lll["cantGetVersionInfo"]="No se pudo obtener información de la versión. Falló actualización.";
// checking configuration:
// Changed in version 4.1.0. Old text:
//$lll["checkMailtestTitle"]="Sending out a test mail...";
// New text:
$lll["checkMailtestTitle"]="NOAH is sending out a test mail...";
$lll["triggerMailTest"]="Presíone aquí para probar E-mail de prueba."; 
$lll["unableToConnectNoah"]="Incapaz de conectar al Servidor de Noah, favor intentar mas tarde!"; 
$lll["itemNumbersRecalculated"]="Los números de los Artículos han sido recalculados"; 
// Changed in version 4.1.0. Old text:
//$lll["dbPrefixExplanation"]="In case Noah's must share the database with tables of other applications, it's wise to specify a table prefix for the Noah's tables, in order to avoid table name collisions. E.g.: 'noah_'";
// New text:
$lll["dbPrefixExplanation"]="In case NOAH must share the database with tables of other applications, it's wise to specify a table prefix for the NOAH tables, in order to avoid table name collisions. E.g.: 'noah_'";
$lll["dbPrefix"]="Préfijo de Tabla";
$lll["checkconf"]="Checar";
// Changed in version 4.1.0. Old text:
//$lll["mailok"]="The send mail test has been successfully completed. You must soon get a test email on %s";
// New text:
$lll["mailok"]="The send mail test has been successfully completed. You will reveive a test email on %s";
// Changed in version 4.1.0. Old text:
//$lll["mailerr"]="The following error occured during sending out a test mail:<br>%s";
// New text:
$lll["mailerr"]="Ouch! The following error occured during sending out a test mail:<br>%s";
$lll["here1"]="Presione aquí";
$lll["confpreerr"]="Existen ciertos caracteres antes de &lt;? en el archivo de Configuración! Favor eliminar estos caracteres(nuevas lineas y espacios también)!";
$lll["confposterr"]="Existen ciertos caracteres después de ?&gt; en el archivo de Configuración! Favor eliminar estos caracteres(nuevas lineas y espacios también)!";
$lll["conffileok"]="El Archivo Configuración parece estar correcto.";
// Changed in version 4.1.0. Old text:
//$lll["congrat"]="Congratulations! You have successfully installed Noah's Classifieds!";
// New text:
$lll["congrat"]="Congratulations! You have successfully installed you new Noah's Classifieds!";
$lll["confcheck"]="Revisando sistema de Configuración...";
// Changed in version 4.1.0. Old text:
//$lll["confdisapp"]="If you want to begin to work with the software and you want this page to disappear";
// New text:
$lll["confdisapp"]="If you want to begin to work with on your Noah's Classifieds and you want this page to disappear";
$lll["confclicheck"]="Puedes accesar el aréa de Configuración en cualquier momento al presionar el vínculo 'Checar' en la barra de menú.";
$lll["chadmemail"]="El E-mail actual es admin@admin.com, Favor actualizarlo en el aréa 'Perfíl' en la barra de menú";
// Changed in version 4.1.0. Old text:
//$lll["chsyspass"]="Your system email adress is not yet set. Please set it clicking on the 'Settings' link on the menubar!";
// New text:
$lll["chsyspass"]="Your system email address is not yet set. Please set it clicking on the 'Settings' link on the menubar!";
// Changed in version 4.1.0. Old text:
//$lll["chsyspass_expl"]="The program can't send out notification emails without the system email address that will populate the 'From' and 'Reply-to' fields of the notification emails.";
// New text:
$lll["chsyspass_expl"]="NOAH cannot send out notification emails without the system email address that will populate the 'From' and 'Reply-to' fields of the notification emails.";
$lll["chadmpass"]="La Contraseña determinada (ADMIN) aún no ha sido cambiada! Favor de cambiarla en el aréa 'Perfíl' de la barra de menú";
$lll["settings_adminEmail"]="E-mail de Sistema";
// Changed in version 4.1.0. Old text:
//$lll["settings_adminEmail_expl"]="This will appear as the address in the 'From:' field of emails the program sends. If you leave this blank, the program may not be able send out email notifications!";
// New text:
$lll["settings_adminEmail_expl"]="This will appear as the address in the 'From:' field of emails the program sends. If you leave this blank... NOAH may not be able send out email notifications! Note that you may not use an email address in this field!";
$lll["nogd"]="Alerta: Su Servidor no tiene instalada una Librería GD.";
// Changed in version 4.1.0. Old text:
//$lll["nogd_expl"]="(This library is responsible in php programs for the image manipulation, so it might be anyway useful if you put it on your server. In our program it is called for creating thumbnail images to the full sized uploaded pictures. Without this support the program can't generate thumbnails, this way the browser have to shrink 'on-the-fly' each big image in each pages where thumbnails can appear. This method works, but it is far from effective (the page have to download every time every big image). )";
// New text:
$lll["nogd_expl"]="(This library is responsible in php programs for the image manipulation, so it might be anyway useful if you put it on your server. In our program it is called for creating thumbnail images to the full sized uploaded pictures. Without this support the program cannot generate thumbnail sized pictures, this way the browser have to shrink 'on-the-fly' each big image in each pages where thumbnails can appear. This method works, but it is far from effective (the page have to download every time every big image). )";
// Changed in version 4.1.0. Old text:
//$lll["instFileRemove"]="In order to start using the program, you have to remove the installation files (%s).<br><a href='%s'>Click here to remove them!</a><span class='confexpl'> (If this message doesn't disappear after you clicked, it means the program has no permission to remove these files. In this case, you must delete them manually!)</span>";
// New text:
$lll["instFileRemove"]="In order to start using the NOAH program, the installation files have to be removed(%s).<br><a href='%s'>Click here to remove them!</a><span class='confexpl'> (If this message doesn't disappear after you clicked, it means the program has no permission to remove these files. In this case, the files need to be manually deleted.)</span>";
// RSS feed:
$lll["rss"]="RSS";
$lll["rss_modify_form"]="Modificar Canales RSS";
$lll["rss_language"]="Lenguaje";
$lll["rss_link"]="Vínculo";
// Changed in version 4.1.0. Old text:
//$lll["rss_link_expl"]="The URL of the classifeds site - e.g.: http://yoursete.com/classifieds";
// New text:
$lll["rss_link_expl"]="The URL of the classifeds site - e.g.: http://yoursite.com/classifieds";
$lll["rss_descField"]="Descripción de campo";
$lll["rss_descField_expl"]="El indíce del campo de la variable que funciona como la 'Descripción' asignada en un Anuncio y su Canal RSS. En la instalación básica de Noah, es el 1er campo. Si no tiene ese campo? fijélo en '0', y ningúna descripción será mostrada en la Canal RSS.";
//globalsettings
$lll["settings"]="Configuraciones";
$lll["settings_modify_form"]="Modificar configuración";
$lll["settings_expNoticeBefore"]="Días antés en el que el Usuario debe ser informado de la expiración";
$lll["settings_charLimit"]="Número de caracteres que un Anuncio puede tener";
$lll["settings_blockSize"]="Anuncios mostrados por página";
$lll["settings_maxPicSize"]="Tamaño máximo en bytes para una Imagén";
$lll["settings_maxPicWidth"]="Tamaño máximo en pixels para ancho de Imagén";
$lll["settings_maxPicHeight"]="Tamaño máximo en pixels para alto de Imagén";
$lll["settings_maxPicSize_expl"]=$lll["settings_maxPicWidth_expl"]=$lll["settings_maxPicHeight_expl"]="'0' significa ilimitado.";
$lll["settings_adminFromName"]="Nombre del Sistema";
$lll["settings_adminFromName_expl"]="Este aparecerá en el campo 'De:' en los e-mails de notificaciones y/o alertas que el programa envíe.";
$lll["settings_versionFooter"]="Versión de Pie";
$lll["settings_titlePrefix"]="Prefijo de Título"; 
$lll["settings_dateFormat"]="Formato de Fecha"; 
$lll["settings_dateFormat_expl"]="Para mas información y ejemplos de formatos de fecha, <a href='http://php.net/manual/en/function.date.php' target='_blank'>presíone aquí</a>"; 
// Changed in version 3.0.0. Old text:
//$lll["settings_enableFavorities"]="Enable the 'Add to favorities' feature";
// New text:
//$lll["settings_enableFavorities"]="Enable the 'Add to favorities' feature for";
$lll["settings_enableFavorities"]="Enable the 'Add to favorities' feature for";
$lll["settings_enableFavorities_expl"]="Esta función no tiene efecto en la versión de 'Evaluación'"; 
$lll["settings_updateCheckInterval"]="Checar por actualizaciones de Noah periodicamente"; 
$lll["settings_updateCheckInterval_expl"]="El programa puede checar por actualizaiones automaticamente y cuando una nueva versión este disponible, 
                                           muestra en el aréa de Administración los datos necesarios para actualizar. Esta función especifíca el tiempo en días que el programa checa por nuevas actualizaciones.
                                           si désea desactivar esta función, fije el valor a '0'"; 
$lll["mailProperties"]="Propiedades de envio de E-mail"; 
$lll["themeProperties"]="Apoyo de Temas"; 
$lll["settings_defaultTheme"]="Tema Personalizado"; 
$lll["settings_allowedThemes"]="Temas permitidos para seleccionar";
$lll["settings_allowedThemes_expl"]="Si creo un nuevo sub-directorio dentro de 'THEMES' para su propio Tema - Ejemplo: 'mi_nuevo_tema', aparecerá automaticamente en la lista como 'Mi Nuevo Tema'!"; 
$lll["settings_allowSelectTheme"]="Permitir cambiar Tema"; 
$lll["settings_allowSelectTheme_expl"]="Si lo activa, un Menú Selector será mostrado en todas las páginas permitiendo cambiar el Tema inmediatamente."; 
$lll["languageProperties"]="Lenguaje de Ayuda"; 
$lll["settings_defaultLanguage"]="Lenguaje Personalizado"; 
$lll["settings_allowedLanguages"]="Lenguajes permitidos a seleccionar"; 
$lll["settings_allowSelectLanguage"]="Permitir cambiar lenguaje"; 
$lll["settings_allowSelectLanguage_expl"]="Si lo activa, un Menú Selector será mostrado en todas las páginas permitiendo cambiar el Tema inmediatamente."; 
$lll["settings_smtpServer"]="Nombre de servidor SMTP"; 
$lll["settings_smtpServer_expl"]="Puede usar estos campos si desea que el programa envíe E-mails vía el servidor SMTP, de lo contrario el sistema original PHP será usado para enviar E-mails.";
$lll["settings_smtpUser"]="Usuario SMTP"; 
$lll["settings_smtpPass"]="Contraseña SMTP"; 
$lll["settings_fallBackNative"]="Regresar a sistema original si SMTP fallá"; 
$lll["settings_titlePrefix_expl"]="Este texto precederá cualquier Titulo en el navegador. Ejemplo: Puede fijarlo con el nombre de su Sitio."; 
$lll["seoProperties"]="Optimización de motores de Búsqueda"; 
$lll["settings_mainTitle"]="Etiqueta de Titulo"; 
$lll["settings_mainTitle_expl"]="El contenido de el TITULO, DESCRIPCION y PALABRAS CLAVES generalemente dependen en que Categoría o 
                                 detalles de Anuncio estan siendo mostrados - Ejemplo: Puede definirlo por Categoría mientras los Usuarios
                                 pueden definirlo por Anuncio. Estos trés elementos operán como determinados en aquéllos casos donde la página 
                                 no es una Categoría o información de Anuncio (Ejemplo: Página inicial)"; 
$lll["settings_mainDescription"]="Etiqueta descriptiva";
$lll["settings_mainKeywords"]="Etiqueta de palabras clave";
$lll["settings_helpLink"]="Vínculo hacía 'Ayuda'";
$lll["settings_helpLink_expl"]="Introduzca la dirección completa hacia el archivo de 'Ayuda' en donde puede proveer su propia página de Ayuda. Ejemplo: http://www.tusitio.com/clasificados/ayuda.html";
$lll["settings_maxMediaSize"]="Tamaño máximo en bytes que se pueden subir en Archivos de media";
$lll["settings_maxMediaSize_expl"]="'0' siginifica ilimitado.<br><br>Nota: Cualquier valor que fijé aquí, estará sujetos a los parámetros fijados por la configuración del programa. Estos se encuentran en 'upload_max_filesize' y 'post_max_size'. Pueden encontrase en los archivos 'php.ini', 'httpd.conf', o en el '.htaccess' el valor determinado es generalmente 2MB. Puede incrementar los valores digamos a 50MB en el archivo .htaccess de la siguiente manera:<br><br>php_value upload_max_filesize \"50M\"<br>php_value post_max_size \"50M\" ";
// Changed in version 3.0.0. Old text:
//$lll["settings_subscriptionType"]="Auto notify";
// New text:
//$lll["settings_subscriptionType"]="Enable auto notify for";
$lll["settings_subscriptionType"]="Enable auto notify for";
$lll["settings_subscriptionType_expl"]="Los Usuarios se pueden subscribir y recibir notificaciones automáticas si Anuncios nuevos son publicados en cierta Categorias.<br><br>Esta función no esta disponible en la versión de Evaluación!";
$lll["settings_menuPoints_expl"]="Si 'Introducir Anuncio' esta deseleccionada, El Menú será solo visible al Administrador (solamente el podrá publicar Anuncios también). Puede desactivar o reoganizar opciones de Menú modifícando las secciones correspondientes en el archivo 'layout.tpl.php'";
$lll["settings_menuPoints"]="Opciones de Menú";
$lll["settings_menuPoints_".Settings_showLogout]="Salir";
$lll["settings_menuPoints_".Settings_showLogin]="Accesar";
$lll["settings_menuPoints_".Settings_showRegister]=$lll["registerNoah"];
$lll["settings_menuPoints_".Settings_showMyProfile]="Ver Perfíl";
$lll["settings_menuPoints_".Settings_showMyAds]="Mis Anuncios";
$lll["settings_menuPoints_".Settings_showSubmitAd]="Introducir Anuncio";
$lll["settings_menuPoints_".Settings_showSearch]="Buscar";
$lll["settings_menuPoints_".Settings_showHome]="Inicio";
$lll["settings_menuPoints_".Settings_displayHelp]="Ayuda";
$lll["menuPointsSep"]="Modificar Diseño";
$lll["expirationProperties"]="Propiedades de Expiración";
$lll["imageProperties"]="Limites al tamaño de Imagenes";
$lll["otherProperties"]="Otras Configuraciones";
$lll["adDisplayProperties"]="Configuración para ver Anuncio";
$lll["settings_renewal"]="Cantidad de ocasiones en que el Usuario esta autorizado a prolongar sus Anuncios expirados";
$lll["settings_allowModify"]="Se autoriza al Usuario modificar sus Anuncios";
$lll["settings_extraHead"]="Contenido de TITULO adicional";
// Changed in version 4.1.0. Old text:
//$lll["settings_extraHead_expl"]="With this, you can insert custom HTML right before the closing HEAD tag of the pages. This is usually a good place to insert additional style sheets, or JavaScript.<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_extraHead_expl"]="With this, you can insert custom HTML right before the closing HEAD tag of the pages. This is usually a good place to insert additional style sheets, or JavaScript.<br><br>This feature is not available in the Lite version of the program!";
$lll["settings_extraBody"]="Contenido de MENSAJE adicional";
// Changed in version 4.1.0. Old text:
//$lll["settings_extraBody_expl"]="With this, you can insert custom HTML right after the opening BODY tag of the pages. E.g. you can insert a banner above all the pages here.<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_extraBody_expl"]="With this, you can insert custom HTML right after the opening BODY tag of the pages. E.g. you can insert a banner above all the pages here.<br><br>This feature is not available in the Lite version of the program!";
$lll["settings_extraFooter"]="Contenido de PIE adicional";
// Changed in version 4.1.0. Old text:
//$lll["settings_extraFooter_expl"]="With this, you can insert custom HTML right before the closing BODY tag of the pages.<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_extraFooter_expl"]="With this, you can insert custom HTML right before the closing BODY tag of the pages.<br><br>This feature is not available in the Lite version of the program!";
// Custom Fields
$lll["customfield"]="Campo adaptado";
$lll["mustBeCommaSeparated"]="Los valores posibles de la selección de tipo de campos deben ser definidos como cadenas separados por comas";
$lll["invalidDefaultValue"]="El valor por defecto de una selección de tipo de campo debe ser una de las cadenas separadas por comas que figuran en los posibles valores de campo.";
$lll["descriptionDefaultLabel"]=$lll["description"]="Descripción";
$lll["privateField"]="Privado";
$lll["customfield_type"."_".customfield_text]="Texto";
$lll["customfield_type"."_".customfield_textarea]="Aréa de Texto";
$lll["customfield_type"."_".customfield_bool]="Boolean";
$lll["customfield_type"."_".customfield_selection]="Selección";
$lll["customfield_type"."_".customfield_multipleselection]="Selección Multiple";
$lll["customfield_type"."_".customfield_separator]="Separador";
$lll["customfield_type"."_".customfield_checkbox]="Checado";
$lll["customfield_type"."_".customfield_picture]="Imagén";
$lll["customfield_type"."_".customfield_media]="Archivo de Media";
$lll["customfield_type"."_".customfield_url]="Vínculo Web";
$lll["customfield_type"."_".customfield_date]="Fecha";
$lll["customfield_dateDefaultNow"]="Fecha determinada es la fecha actual";
$lll["customfield_fromyear"]="del Año"; 
$lll["customfield_fromyear_expl"]="El rango del Selector de Fechas que ocupa este campo comenzará a partir de este año. 
                                   Puede introducir un número de Año como: '1971', o puede entrar 'NOW' que operá como el Año corriente.
                                   También puede usar un Año relativo: 'now-5' significa que buscará de ahora y 5 años atrás!";
$lll["customfield_toyear"]="al Año";
$lll["customfield_toyear_expl"]="El rango del Selector de Fechas que ocupa este campo buscará hasta este año.
                                 Puede introducir un número de Año como: '2010', o puede entrar 'NOW' que operá como el Año corriente.
                                 También puede usar un Año relativo: 'now+5' significa que buscará de ahora y 5 años adelante";
$lll["customfield_name"]="Nombre";
$lll["customfield_type"]="Clase";
$lll["customfield_type"."_expl"]="Nota: Para evitar conflíctos de Clase, si alguna vez áctivo esta columna y existén artículos en ella, Ya no puede cambiar la Clase de nuevo. Si insiste en cambiar la Clase de todas maneras, tiene primero que remover todos los artículos.";
$lll["customfield_default_bool"]=
$lll["customfield_default_text"]=
$lll["customfield_default_multiple"]="Valor por defecto";
$lll["customfield_active"]="Activo";
$lll["customfield_separator"]="Columna %s";
$lll["customfield_mandatory"]="Obligatorio";
// Changed in version 3.0.0. Old text:
//$lll["customfield_showInList"]="Appears in list";
// New text:
//$lll["customfield_showInList"]="Show in lists for";
$lll["customfield_showInList"]="Show in lists for";
$lll["customfield_values"]="Valores posibles";
$lll["customfield_innewline"]="Colocar en nueva línea";
$lll["customfield_displaylength"]="Largo de Lista mostrado";
$lll["customfield_displaylength"."_expl"]="Cantidad máxima de caracteres mostrados en la lista de Anuncios. La apariencia de la Lista puede ser adecuada para no mostrar grandes campos en las celdas.";
// Changed in version 3.1.0. Old text:
//$lll["customfield_searchable"]="Searchable";
// New text:
$lll["customfield_searchable"]="Show in the search form for";
$lll["customfield_searchable"."expl"]="Si es activado, Usuarios pueden buscar por atributos usando un rango de números como '10-20'";
$lll["customfield_rangeSearch"]="Rango de búsqueda permitido";
// Changed in version 3.1.0. Old text:
//$lll["customfield_rangeSearch_expl"]="If this is checked than one can define e.g. '10-20' as a search condition to search for ads where the value of this field is between 10 and 20.";
// New text:
$lll["customfield_rangeSearch_expl"]="If this is checked than one can define e.g. '10-20' as a search condition to search for ads where the value of this field is between 10 and 20. Or one can enter a range of dates in case of Date fields.";
$lll["customfield_allowHtml"]="Permitir HTML";
// Changed in version 2.3.0. Old text:
//$lll["customfield_allowHtml_expl"]="This only allows 'save' HTML tags, however! Some tags that would impose a security risk, or ruin the layout are excluded.";
// New text:
//$lll["customfield_allowHtml_expl"]="This only allows 'safe' HTML tags, however! Some tags that would impose a security risk, or ruin the layout are excluded.";
// Changed in version 4.0.0. Old text:
//$lll["customfield_allowHtml_expl"]="This only allows 'safe' HTML tags, however! Some tags that would impose a security risk, or ruin the layout are excluded.";
// New text:
$lll["customfield_allowHtml_expl"]="This only allows 'safe' HTML tags, however! Some tags that would impose a security risk, or ruin the layout are excluded.<br><br>If you don't allow HTML, some simple rules will be still applied: line breaks in the text will be rendered as new lines, web links and email addresses will turn into clickable links.";
$lll["customfield_private"]="Permitir mantenerlo Privado";
$lll["customfield_format"."_expl"]="Puede utilizar este formato Estilo-C";
$lll["customfield_subType"]="Considerar este campo como";
$lll["customfield_subType_".customfield_alnum]="Texto";
$lll["customfield_subType_".customfield_integer]="Número Integral";
$lll["customfield_subType_".customfield_float]="Número Relativo";
$lll["customfield_sortable"]="Permítir organizar basado en este Campo";
$lll["customfield_expl"]="Texto Explicatorio";
$lll["customfield_expl"."_expl"]="Texto de ayuda, como el que esta leyendo! Una descripción más detallada de una forma o función de Campo.";
$lll["private_field"]="(privado)";
$lll["customfield_newitem"]="Adherir nuevo campo personalizado";
$lll["customfield_modify_form"]="Modificar campo personalizado";
$lll["customfield_create_form"]="Crear campo personalizado";
$lll["customfield_sortId"]="Ordenar";
$lll["customfield_sorthelp"]="Use los iconos de flechas en la columna 'Ordenar' para re-organizar la lista, entonces presione 'Guardar Ordén' al final de la página!";
$lll["customfield_savesorting"]="Guardar Ordén";
$lll["customfield_sortingsaved"]="El nuevo campo organizar ha sido grabado.";
// Changed in version 3.0.0. Old text:
//$lll["customFields"]="List of custom fields of this category";
// New text:
//$lll["customFields"]="List of custom fields";
$lll["customFields"]="List of custom fields";
$lll["customfield_rowspan"]="Cubre las Filas"; 
$lll["customfield_seo"]=$lll["seoProperties"];
$lll["customfield_seo_0"]="Sin taréa";
$lll["customfield_seo_".customfield_title]="Usar este campo como el TITULO del Anuncio";
$lll["customfield_seo_".customfield_description]="Usar este campo como la DESCRIPCION del Anuncio";
$lll["customfield_seo_".customfield_keywords]="Usar este campo como la PALABRA CLAVE del Anuncio";
// Changed in version 3.0.0. Old text:
//$lll["customfield_mainPicture"]="Use this field as the main picture of the ad";
// New text:
//$lll["customfield_mainPicture"]="Use this field as the main picture";
$lll["customfield_mainPicture"]="Use this field as the main picture";
$lll["customfield_mainPicture_expl"]="Imagén para utilizar en Categorias no especifícas y Canales RSS."; 
// Changed in version 2.4.0. Old text:
//$lll["customfield_seo_expl"]="You can specify here which custom field of the item will serve as the content of the HTML TITLE tag, DESCRIPTION tag and KEYWORDS tag, respectively. 
//                              Besides SEO, the content of the TITLE fields will appear in the title bar of the browser when one 
//                              displays the ad, it will be used as the title of the ad in non category specific ad lists and in RSS feeds.
//                              The fields designated as the KEYWORD will not be displayed on the ad page - it will only be visible in the create and modify forms of the ads.";
// New tex:
//$lll["customfield_seo_expl"]="You can specify here which custom field of the item will serve as the content of the HTML TITLE tag, DESCRIPTION tag and KEYWORDS tag, respectively. 
//                              Besides SEO, the content of the TITLE fields will appear in the title bar of the browser when one 
//                              displays the ad, it will be used as the title of the ad in non category specific ad lists and in RSS feeds.";
$lll["customfield_seo_expl"]="You can specify here which custom field of the item will serve as the content of the HTML TITLE tag, DESCRIPTION tag and KEYWORDS tag, respectively. 
                              Besides SEO, the content of the TITLE fields will appear in the title bar of the browser when one 
                              displays the ad, it will be used as the title of the ad in non category specific ad lists and in RSS feeds.";
$lll["customfield_innewline_expl"]="En lugar de formar una nueva columna, esta configuración hace que el valor del campo personalizado aparezca en una nueva línea que se extiende sobre todos los demás columnas horizontalmente y esta colocada debajo.";
// Changed in version 2.3.0. Old text:
//$lll["customfield_rowspan_expl"]="Use this in conjunction with the 'Place in new line' property of other custom fields. If there are other fields which has been placed in a new line, you can specify with this setting that this fields spans over those new lines vertically.";
// New text:
//$lll["customfield_rowspan_expl"]="Use this in conjunction with the 'Place in new line' property of other custom fields. If there are other fields which has been placed in a new line, you can specify with this setting that this field spans over those new lines vertically.";
$lll["customfield_rowspan_expl"]="Use this in conjunction with the 'Place in new line' property of other custom fields. If there are other fields which has been placed in a new line, you can specify with this setting that this field spans over those new lines vertically.";
// Notifications:
$lll["notification"]="notificación";
$lll["Notifications"]=$lll["notification_ttitle"]="Notificaciones";
$lll["notification_subject"]="Asunto:";
$lll["notification_body"]="Mensaje:";
$lll["notification_variables"]="variables permitidas";
$lll["notification_active"]="Activo";
$lll["notification_modify_form"]="Modificar notificación";
$lll["notif_remindpass_tit"]="Contiene una nueva Contraseña si el Usuario olvído la anterior.";
$lll["notif_remindpass_subj"]="Nueva Contraseña";
$lll["notif_initpass_tit"]="Enviar al Usuario después de Registrarse, contiene la Contraseña inicial.";
$lll["notif_initpass_subj"]="Contraseña inicial";
$lll["notification_cc"]="CC";
$lll["notification_cc_expl"]="Especifíque aquí la dirección de E-mail que recibirá copia de este mensaje.";
$lll["notification_active_expl"]="Puede activar/desactivar el envío de esta notificaión aquí.";
?>