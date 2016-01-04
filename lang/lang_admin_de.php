<?php
// lang_de_php 22.11.2008
// German translation: JOOM!WEB Webservice Olaf Dryja 
// Email: info@joomweb.de
// Website: http://joomweb.de

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
$lll["db_installed"]="Die Datenbank wurde installiert: %s";
// Changed in version 4.1.0. Old text:
//$lll["cantcreatedb"]="Can not reach or create database. User %s has no create database permission, or cannot reach the database. Change the name of the user or give him appropriate rights!";
// New text:
$lll["cantcreatedb"]="Help! NOAH Cannot reach or create your database. User %s has no create database permission, or cannot reach the database. Change the name of the user or give it the appropriate rights!";
// Changed in version 4.1.0. Old text:
//$lll["cantconnectdb"]="Can not connect to database. May be have no rights or not exists, trying to create.";
// New text:
$lll["cantconnectdb"]=" Help! NOAH Cannot connect to database. Odds are there no rights or does not exist, trying to create.";
$lll["inst_create_table_err"]="Fehler! Es konnten keine Tabellen erstellt werden, %s ist bereits installiert?";
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
$lll["inst_click"]="Klicken Sie hier für den Zugang zu %s.";
// Changed in version 4.1.0. Old text:
//$lll["createTableFailed"]="Create table failed";
// New text:
$lll["createTableFailed"]="Ouch! Create table failed";
$lll["install"]="Installieren";
$lll["clickToInstall"]="Klicken Sie auf 'Installieren' für die Installation von %s!";
$lll["admin_ok"]="Der Administrator Benutzer wurde erstellt, der Benutzername ist: admin, das Passwort lautet: admin.";
// Changed in version 4.1.0. Old text:
//$lll["create_file_ok"]="Config has been successfully created.";
// New text:
$lll["create_file_ok"]="Awesome!!! Config has been successfully created.";
// Changed in version 4.1.0. Old text:
//$lll["create_file_nok"]="Config file have to be created manually.";
// New text:
$lll["create_file_nok"]="Ouch! Config file have to be created manually, it happens.";
$lll["inst_params"]="Die MySQL Datenbank wurde mit folgenden Parametern erstellt:";
$lll["edit_params"]="Parameter bearbeiten";
$lll["acceptTerms"] = "Ich habe die Bedingungen gelesen und akzeptiere diese: <input type='checkbox' id='accept' name='Akzeptieren'>";
$lll["youMustAcceptTerms"] = "Sie müssen die Bedingungen erst akzeptieren um weiter machen zu können!";
$lll["dbHostName"]=$lll["hostName"]="Hostname";
$lll["mysqluser"]="MySQL Benutzername";
$lll["dbDbName"]=$lll["dbName"]="Datenbankname";
$lll["dbSocket"]="Sockel";
$lll["formtitle"]="MySQL Einstellungen";
$lll["password"]="PassworT";
$lll["dbPort"]="Port";
$lll["cookieok"]="Cookies sind aktiviert.";
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
$lll["afterwrconf"]="<u>Nach dem</u> schreiben der Konfigurationsdatei klicken Sie auf den Link zum fortsetzen!";
$lll["move_inst_file"]="Bitte löschen Sie die Datei install.php aus Ihrem Grundverzeichnis!";
// Changed in version 4.1.0. Old text:
//$lll["inst_ch_pw"]="Administrator settings - username: admin, password: admin, don't forget to change the password!";
// New text:
$lll["inst_ch_pw"]="Administrator settings - username: admin, password: admin, and don't forget to change the password!";
$lll["create_file_nok_ext"]="Der Server hat keine Rechte zum erstellen einer Konfigurationsdatei. Sie haben zwei Möglichkeiten:<br>\n#1: Erstellen Sie eine leere Datei im Verzeichnis 'app' mit dem Namen 'config.php', und geben den Server die Schreibrechte für diese Datei. Unter Unix Systemen:<br> die Datei app/config.php auswählen;Chmod 777 für die Datei app/config.php wählen<br>und klicken Sie im Browser auf neu laden bzw. aktualisieren.<br>#2: Sie klicken auf Installieren und erstellen die '/app/config.php' manuell mit Ihrem bevorzugten Editor als leere Datei und kopieren die Code Ausgabe der Installation in diese Datei.";
// Changed in version 3.1.3. Old text:
//$lll["versionTooLow"]="Required minimum MySql version is %s. The current one is %s. Required minimum MySql version is %s. The current one is %s.";
// New text:
$lll["versionTooLow"]="Required minimum MySql version is %s. The current one is %s. Required minimum Php version is %s. The current one is %s.";
// Registrierung:
$lll["registerNoah"]="Registrieren";
$lll["notRegistered"]="Nicht registriert"; 
$lll["registerNoahTitle"]="Registrieren von Noah's Kleinanzeigen"; 
// Changed in version 4.1.0. Old text:
//$lll["noahAlreadyRegistered"]="The product is already registered!";
// New text:
$lll["noahAlreadyRegistered"]="Your NOAH is already registered!";
$lll["noahRegistrationFalseResponse"]="Die Registrierdaten konnten nicht an den Noah's Server gesendet werden. Bitte versuchen Sie es später wieder!"; 
// Changed in version 4.1.0. Old text:
//$lll["noahRegistrationSuccessfull"]="Thank you. The product is now registered!";
// New text:
$lll["noahRegistrationSuccessfull"]="Thank you. Your NOAH is now registered!";
// Aktualisierung:
$lll["download"]="Download";
$lll["u_maintitle"]="Noah's Kleinanzeigen Aktualisierungs-Prozess";
// Changed in version 4.1.0. Old text:
//$lll["secure_copy"]="It is recommended to make a dump of your Noah's Classifieds database before the update!";
// New text:
$lll["secure_copy"]="It is recommended to make a databse dump of your Noah's Classifieds before the update!";
$lll["ready_to_update"]="Sind Sie bereit zum aktualisieren der Datenbank %s zur Version %s?<br>";
// Changed in version 4.1.0. Old text:
//$lll["invalid_version"]="The given version is invalid: %s";
// New text:
$lll["invalid_version"]="hmm...The given version is invalid: %s";
// Changed in version 4.1.0. Old text:
//$lll["updateSuccessful"]="The update successfully completed.";
// New text:
$lll["updateSuccessful"]="The NOAH update successfully completed.";
$lll["updating"]="Aktualisierung von Version %s zu Version %s...";
// Changed in version 4.1.0. Old text:
//$lll["already_installed"]="The latest software version %s is already installed.";
// New text:
$lll["already_installed"]="The latest NOAH software version %s is already installed.";
$lll["picturesDirMustbeWritable"]="Die '%s' Verzeichnisse müssen durch das Programm beschreibbar sein damit eine Aktualisierung durchgeführt werden kann! Aktualisierung fehlerhaft.";
$lll["updateAutomatic"]="Aktualisierung";
$lll["updateManualZip"]="Download ZIP";
$lll["updateManualTgz"]="Download TGZ";
$lll["downloadFileNotExists"]="Download Datei '%s' existiert nicht.";
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
$lll["checkUpdates"]="Aktualisierungen"; 
$lll["checkUpdatesTitle"]="Überprüfe die Noah's Kleinanzeigen Webseite auf vorhandene Aktualisierungen"; 
// Changed in version 4.1.0. Old text:
//$lll["nopermission"]="The program has no write permission under the following directories: %s<br>You must execute the following Unix command (in Unix systems, of course):<br><i>chmod 777 &lt;replace directory name&gt;</i>";
// New text:
$lll["nopermission"]="The NOAH program has no write permission under the following directories: %s<br>You must execute the following Unix command (in Unix systems, of course):<br><i>chmod 777 &lt;replace directory name&gt;</i>";
$lll["nopermission_expl"]="Während der Ausführung hat Noah's Kleinanzeigen Dateien in verschiedenen Unterverzeichnissen gespeichert, in der Reihenfolge zum hoch laden von Bildern, Log Fehler oder Erstellung von Dateien. Stellen Sie sicher, dass das Programm entsprechende Rechte dazu hat.)";
$lll["backToIndex"]="Zurück zu den Kleinanzeigen.";
$lll["onlyFrom1.3"]="Sie haben eine Version die älter als 1.3 ist. Das Aktualisierungsscript arbeiten nur ab der Version 1.3!";
$lll["cantGetVersionInfo"]="Habe keine Versions Informationen. Die Aktualisierung ist fehlerhaft.";
// Konfiguration überprüfen:
// Changed in version 4.1.0. Old text:
//$lll["checkMailtestTitle"]="Sending out a test mail...";
// New text:
$lll["checkMailtestTitle"]="NOAH is sending out a test mail...";
$lll["triggerMailTest"]="Klicken Sie hier, um eine Test E-Mail abzusenden."; 
$lll["unableToConnectNoah"]="Es gab keinen Kontakt zum Noah's Server. Bitte versuchen Sie es später wieder!"; 
$lll["itemNumbersRecalculated"]="Die Nummern der Inhalte wurden erfolgreich neu erstellt"; 
// Changed in version 4.1.0. Old text:
//$lll["dbPrefixExplanation"]="In case Noah's must share the database with tables of other applications, it's wise to specify a table prefix for the Noah's tables, in order to avoid table name collisions. E.g.: 'noah_'";
// New text:
$lll["dbPrefixExplanation"]="In case NOAH must share the database with tables of other applications, it's wise to specify a table prefix for the NOAH tables, in order to avoid table name collisions. E.g.: 'noah_'";
$lll["dbPrefix"]="Tabellen Präfix";
$lll["checkconf"]="Überprüfen";
// Changed in version 4.1.0. Old text:
//$lll["mailok"]="The send mail test has been successfully completed. You must soon get a test email on %s";
// New text:
$lll["mailok"]="The send mail test has been successfully completed. You will reveive a test email on %s";
// Changed in version 4.1.0. Old text:
//$lll["mailerr"]="The following error occured during sending out a test mail:<br>%s";
// New text:
$lll["mailerr"]="Ouch! The following error occured during sending out a test mail:<br>%s";
$lll["here1"]="Klicken Sie hier";
$lll["confpreerr"]="Es gibt einige Zeichen vor &lt;? in der Konfigurationsdatei! Bitte löschen Sie diese Zeichen (Zeilenumbrüche und Leerzeichen)!";
$lll["confposterr"]="Es gibt einige Zeichen nach ?&gt; Konfigurationsdatei! Bitte löschen Sie diese Zeichen (Zeilenumbrüche und Leerzeichen)!";
$lll["conffileok"]="Die Konfigurationsdatei schein in Ordnung zu sein.";
// Changed in version 4.1.0. Old text:
//$lll["congrat"]="Congratulations! You have successfully installed Noah's Classifieds!";
// New text:
$lll["congrat"]="Congratulations! You have successfully installed you new Noah's Classifieds!";
$lll["confcheck"]="System Konfiguration überprüfen...";
// Changed in version 4.1.0. Old text:
//$lll["confdisapp"]="If you want to begin to work with the software and you want this page to disappear";
// New text:
$lll["confdisapp"]="If you want to begin to work with on your Noah's Classifieds and you want this page to disappear";
$lll["confclicheck"]="Sie können diese Konfigurations - Überprüfungsseite jederzeit über den Link 'Überprüfen' im Menü aufrufen.";
$lll["chadmemail"]="Ihre derzeitige E-Mail Adresse ist  admin@admin.admin. Bitte geben Sie hier eine korrekte Adresse unter dem Link 'Mein Profil' im Menü an!";
// Changed in version 4.1.0. Old text:
//$lll["chsyspass"]="Your system email adress is not yet set. Please set it clicking on the 'Settings' link on the menubar!";
// New text:
$lll["chsyspass"]="Your system email address is not yet set. Please set it clicking on the 'Settings' link on the menubar!";
// Changed in version 4.1.0. Old text:
//$lll["chsyspass_expl"]="The program can't send out notification emails without the system email address that will populate the 'From' and 'Reply-to' fields of the notification emails.";
// New text:
$lll["chsyspass_expl"]="NOAH cannot send out notification emails without the system email address that will populate the 'From' and 'Reply-to' fields of the notification emails.";
$lll["chadmpass"]="Das Standard Passwort des Administrators ist nicht verändert worden! Bitte klicken Sie dazu auf 'Mein Profil' im Menü um das zu ändern!";
$lll["settings_adminEmail"]="System E-Mail";
// Changed in version 4.1.0. Old text:
//$lll["settings_adminEmail_expl"]="This will appear as the address in the 'From:' field of emails the program sends. If you leave this blank, the program may not be able send out email notifications!";
// New text:
$lll["settings_adminEmail_expl"]="This will appear as the address in the 'From:' field of emails the program sends. If you leave this blank... NOAH may not be able send out email notifications! Note that you may not use an email address in this field!";
$lll["nogd"]="Warnung: Ihre Server hat keine GD Bibliothek installiert.";
// Changed in version 4.1.0. Old text:
//$lll["nogd_expl"]="(This library is responsible in php programs for the image manipulation, so it might be anyway useful if you put it on your server. In our program it is called for creating thumbnail images to the full sized uploaded pictures. Without this support the program can't generate thumbnails, this way the browser have to shrink 'on-the-fly' each big image in each pages where thumbnails can appear. This method works, but it is far from effective (the page have to download every time every big image). )";
// New text:
$lll["nogd_expl"]="(This library is responsible in php programs for the image manipulation, so it might be anyway useful if you put it on your server. In our program it is called for creating thumbnail images to the full sized uploaded pictures. Without this support the program cannot generate thumbnail sized pictures, this way the browser have to shrink 'on-the-fly' each big image in each pages where thumbnails can appear. This method works, but it is far from effective (the page have to download every time every big image). )";
// Changed in version 4.1.0. Old text:
//$lll["instFileRemove"]="In order to start using the program, you have to remove the installation files (%s).<br><a href='%s'>Click here to remove them!</a><span class='confexpl'> (If this message doesn't disappear after you clicked, it means the program has no permission to remove these files. In this case, you must delete them manually!)</span>";
// New text:
$lll["instFileRemove"]="In order to start using the NOAH program, the installation files have to be removed(%s).<br><a href='%s'>Click here to remove them!</a><span class='confexpl'> (If this message doesn't disappear after you clicked, it means the program has no permission to remove these files. In this case, the files need to be manually deleted.)</span>";
$lll["appFileRemoveExpl"]="Von Version 2.3.0, werde die meisten php Dateien im Installationsverzeichnis durch eine 'htaccess' Datei vor dem Zugriff in den Unterverzeichnissen geschützt.
                           Das Root-Verzeichnis beinhaltet nur die 'index.php' und 'initdir.php'.";
$lll["appFileRemove"]="Wenn Sie das Programm starten möchten, löschen Sie unnötige Dateien aus dem Installation Verzeichnis: <span class='confexpl'>%s.</span><br><br><a href='%s'>Klicken Sie hier zum entfernen!</a><span class='confexpl'> (Falls diese Nachricht nach dem anklicken nicht verschwindet, hat das Programm keine Berechtigung Dateien zu entfernen. In diesem Fall müssen Sie die Datei manuell entfernen!)</span>";
$lll["backupFileRemoveExpl"]="Aus Gründen der Sicherheit, sollten die Sicherung Verzeichnisse, die durch die automatische Aktualisierung angelegt werden, müssen gelöscht werden. Sollten Sie diese noch benötigen, speichern Sie diese in einem anderen Verzeichnis Ihres Web-Root's!";
$lll["backupFileRemove"]="Wenn Sie das Programm starten möchten, löschen Sie folgende Sicherungs Verzeichnisse aus Ihrem Root-Verzeichnis: <span class='confexpl'>%s.</span><br><br><a href='%s'>Klicken Sie hier zum entfernen!</a><span class='confexpl'> (Falls diese Nachricht nach dem anklicken nicht verschwindet, hat das Programm keine Berechtigung Dateien zu entfernen. In diesem Fall müssen Sie die Datei manuell entfernen!)</span>";
$lll["systemConfCheck"]="System Konfiguration wurde erfolgreich geprüft...";
$lll["niceURLFeature"]="Suchmaschinefreundliche URL's:";
$lll["niceURLFeature_1"]="Noah's Kleinanzeigen unterstützt suchmaschinenfreundliche URL's. Dies bedeutet zum Beispiel, dass der Link von einer Anzeigen-Info-Seite wie folgt aussehen kann:";
$lll["niceURLFeature_2"]="statt der aktuellen Lösung:";
$lll["niceURLFeature_3"]="Neben dem Effekt das die URL schöner aussieht ist Sie auch Suchmaschinenfreundlicher.";
$lll["niceURLFeature_4"]="Die suchmaschinenfreundlichen URL's arbeiten mit dem Apache Modul %s, dieses muss installiert und aktiviert sein. Konnte nicht erkenn od diese Modul installiert ist (PHP ist wahrscheinlich als CGI installiert).";
$lll["niceURLFeature_5"]="Wenn %s bereits installiert ist, sollte Sie eine Datei im Installationsverzeichnis mit dem Namen %s und setzen Sie den folgen Text ein, um suchmaschinenfreundlich URL's zu erhalten:";
// Changed in version 4.0.0. Old text:
//$lll["niceURLFeature_6"]="If after doing this, the nice url feature still doesn't work, you should also check the following in the Apache configuration file:";
// New text:
$lll["niceURLFeature_6"]="If after doing this, the nice url feature still doesn't work, you should  <a href='http://noahsclassifieds.org/documentation/configuration/rewriterules' target='_blank'>click here to learn more about the possible troubleshooting!</a>";
$lll["niceURLFeature_9"]="Die suchmaschinenfreundlichen URL's funktionieren nur mit dem Apache Modul %s. Dies muss installiert und aktiviert sein. es ist nicht korrekt installiert oder aktiviert.";
// Produkt Registrierung:
$lll["reg_companyName"]="Firmenname";
$lll["reg_firstName"]="Vorname";
$lll["reg_lastName"]="Nachname";
$lll["reg_email"]="E-Mail";
$lll["reg_submit"]="Absenden";
// RSS feed:
$lll["rss"]="RSS";
$lll["rss_modify_form"]="RSS Feed bearbeiten";
$lll["rss_language"]="Sprache";
$lll["rss_link"]="Link";
// Changed in version 4.1.0. Old text:
//$lll["rss_link_expl"]="The URL of the classifeds site - e.g.: http://yoursete.com/classifieds";
// New text:
$lll["rss_link_expl"]="The URL of the classifeds site - e.g.: http://yoursite.com/classifieds";
$lll["rss_descField"]="Beschreibung";
$lll["rss_descField_expl"]="Der Index für das variablen Feld, dient als Beschreibung für den RSS Feed. In der Standard Kleinanzeigen Installation, ist dies das erste Feld. Falls Sie noch nicht über ein solches Feld verfügen, setzen Sie dies auf '0', es werden keine Beschreibungen zu den Anzeigen in den RSS Feed übernommen.";
//Globale Einstellungen
$lll["settings"]="Einstellungen";
$lll["settings_modify_form"]="Einstellungen bearbeiten";
$lll["settings_expNoticeBefore"]="Anzahl der Tage, ab wann der Benutzer über den Ablauf seiner Anzeige informiert werden soll";
$lll["settings_charLimit"]="Anzahl der Zeichen die ein Beitrag enthalten darf";
$lll["settings_charLimit_expl"]="'0' ist ohne jedes Limit.";
$lll["settings_blockSize"]="Anzahl der Anzeigen pro Seite";
$lll["settings_maxPicSize"]="Maximale Bildgröße in Pixel";
$lll["settings_maxPicWidth"]="Maximale Bildbreite in Pixel";
$lll["settings_maxPicHeight"]="Maximale Bildhöhe in Pixel";
$lll["settings_maxPicSize_expl"]=$lll["settings_maxPicWidth_expl"]=$lll["settings_maxPicHeight_expl"]="'0' ist ohne jedes Limit.";
$lll["settings_adminFromName"]="Systemname";
$lll["settings_adminFromName_expl"]="Dieser Name wird in dem 'Von:' Feld der Programm E-Mail Benachrichtigung eingetragen.";
$lll["settings_versionFooter"]="Versionshinweis";
$lll["settings_titlePrefix"]="Titel Präfix"; 
$lll["settings_dateFormat"]="Datum umformatieren"; 
$lll["settings_dateFormat_expl"]="Für weitere Informationen zu den Datumsformaten finden Sie unter, <a href='http://php.net/manual/en/function.date.php' target='_blank'>PHP NET - Datumsfunktionen</a>"; 
$lll["settings_enableFavorities"]="Aktivieren von 'Zu den Favoriten hinzufügen' Features für"; 
$lll["settings_enableFavorities_expl"]="Diese Einstellungen hat keine Auswirkung auf die Evaluation Version"; 
$lll["settings_updateCheckInterval"]="Überprüfung auf Noah's Aktualisierungs-Perioden"; 
$lll["settings_updateCheckInterval_expl"]="Das Programm überprüft automatisch nach neuen Aktualisierungen und 
                                              zeigt dies auf der Aktualisierungsseite des Administrators. Legen Sie hier die Einstellungen für den Aktualisierungszyklus fest.
                                              Wenn Sie dieses Feature deaktivieren wollen setzen Sie den Wert auf 0!"; 
$lll["mailProperties"]="E-Mail Eigenschaften"; 
$lll["themeProperties"]="Themen Unterstützung"; 
$lll["settings_defaultTheme"]="Standard Thema"; 
$lll["settings_allowedThemes"]="Erlaubt das auswählen von Themen"; 
$lll["settings_allowedThemes_expl"]="Wenn Sie ein neues Unterverzeichnis erstellen unter 'themes', für Ihre eigen Themen - z.B. 'mein_neues_thema', erfolgt automatisch ein neuer Eintrag in der Themenliste 'Mein neues Thema'!"; 
$lll["settings_allowSelectTheme"]="Benutzer können Themen verändern"; 
$lll["settings_allowSelectTheme_expl"]="Wenn dieses aktiviert ist, wird ein Drop-Down Auswahl-Menü auf der Seite angezeigt, zum ändern des Seiten Themas."; 
$lll["languageProperties"]="Sprachunterstützung"; 
$lll["settings_defaultLanguage"]="Standardsprache"; 
$lll["settings_allowedLanguages"]="Auswahl von Sprachen erlauben"; 
$lll["settings_allowSelectLanguage"]="Benutzer können die Sprache ändern"; 
$lll["settings_allowSelectLanguage_expl"]="Wenn dieses aktiviert ist, wird ein Drop-Down Auswahl-Menü auf der Seite angezeigt, zum ändern der Seiten Sprache."; 
$lll["settings_smtpServer"]="SMTP Servername"; 
$lll["settings_smtpServer_expl"]="Verwenden Sie diese Felder, wenn Sie wollen, dass das Programm die Benachrichtigungs-E-Mails über einen SMTP-Server sendet. Andernfalls, wird die PHP-Mail-Funktion verwendet."; 
$lll["settings_smtpUser"]="SMTP Benutzername"; 
$lll["settings_smtpPass"]="SMTP Passwort"; 
$lll["settings_fallBackNative"]="Gehen Sie zurück zum nativen E-Mail Dienst falls SMTP nicht funktioniert"; 
$lll["settings_titlePrefix_expl"]="Dieser Text wird vor jedem Titel in der Titelleiste des Browsers angezeigt. z.B.: Geben sie den Namen der Webseite ein."; 
$lll["seoProperties"]="Suchmaschinen Optimierung"; 
$lll["settings_mainTitle"]="Titel Tag"; 
$lll["settings_mainTitle_expl"]="Der Inhalt des TITELS, der BESCHREIBUNG und der KENNWÖRTER hängt in der Regel mit der Kategorie Liste oder 
                                 der angezeigten Anzeigenseite zusammen, dass heißt Sie können die nach Kategorie und Benutzer 
                                 sowie angezeigte Anzeige definieren. Diese drei Felder, enthalten die Standardwerte, wenn die Seiten 
                                 nicht in einer Kategorie sind oder Kontext stehen (.B. wie die Startseite selbst)"; 
$lll["settings_mainDescription"]="Meta Tag Beschreibung"; 
$lll["settings_mainKeywords"]="Meta Tag Kennwörter"; 
$lll["settings_helpLink"]="'Hilfe' Link Ziel";
$lll["settings_helpLink_expl"]="Die volle URL zur Hilfe. Mit dieser Eingabe können Sie eine benutzerdefinierte Hilfeseite aufrufen. z.B.: http://yoursite/classifieds_dir/customhelp.html";
$lll["settings_maxMediaSize"]="Maximale Dateigröße für Medien Dateien zum hoch laden";
$lll["settings_maxMediaSize_expl"]="'0' ist ohne ein Limit.<br><br>Anmerkung: Jedoch gibt es hier zwei Einstellungen für die maximale Größe zum hochladen von Dateien. Einmal 'upload_max_filesize' und 'post_max_size'. Sie kann entweder in der 'php.ini'-Datei, oder in der 'httpd.conf', oder in der '. htaccess' -Datei pro Verzeichnis eingestellt werden. Der Standardwert beträgt 2MB. Sie können die Werte in der 'htaccess' Datei bis 50MB, mit :<br><br>php_value upload_max_filesize \"50M\"<br>php_value post_max_size \"50M\" festlegen. ";
$lll["settings_subscriptionType"]="Aktiveren der automatischen Benachrichtigung für";
$lll["settings_subscriptionType_expl"]="Benutzer können sich anmelden für eine automatische Benachrichtigungen, wenn neue Anzeigen in einer Kategorie der Wahl eingestellt werden.<br><br>Diese Feature ist nicht in der Evaluation Version vorhanden!";
$lll["settings_menuPoints_expl"]="Wenn 'Anzeige absenden' nicht markiert ist, ist der Menüpunkt nur für den Administrator sichtbar (Nur der Administrator kann Anzeigen absenden). Sie können dies auch deaktivieren oder reorganisieren, in dem Sie einfach den entsprechenden Bereich in der 'layout.tpl.php' verschieben oder entfernen!";
$lll["settings_menuPoints"]="Menüpunkte";
$lll["settings_menuPoints_".Settings_showLogout]="Abmelden";
$lll["settings_menuPoints_".Settings_showLogin]="Anmelden";
$lll["settings_menuPoints_".Settings_showRegister]=$lll["registerNoah"];
$lll["settings_menuPoints_".Settings_showMyProfile]="Mein Profil anzeigen";
$lll["settings_menuPoints_".Settings_showMyAds]="Meine Anzeigen";
$lll["settings_menuPoints_".Settings_showSubmitAd]="Anzeige absenden";
$lll["settings_menuPoints_".Settings_showSearch]="Suche";
$lll["settings_menuPoints_".Settings_showHome]="Startseite";
$lll["settings_menuPoints_".Settings_displayHelp]="Hilfe";
$lll["menuPointsSep"]="Layout-Anpassung";
$lll["expirationProperties"]="Ablauf Eigenschaften";
$lll["imageProperties"]="Beschränkung für das Bilder hoch laden";
$lll["otherProperties"]="Andere Einstellungen";
$lll["adDisplayProperties"]="Anzeigen Anzeige-Einstellungen";
$lll["settings_renewal"]="Anzahl der Verlängerungen von Benutzer Anzeigen oder abgelaufen Anzeigen";
$lll["settings_allowModify"]="Der Benutzer darf seine Anzeigen verändern";
$lll["settings_extraHead"]="Zusätzliche HEAD Inhalte";
// Changed in version 4.1.0. Old text:
//$lll["settings_extraHead_expl"]="With this, you can insert custom HTML right before the closing HEAD tag of the pages. This is usually a good place to insert additional style sheets, or JavaScript.<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_extraHead_expl"]="With this, you can insert custom HTML right before the closing HEAD tag of the pages. This is usually a good place to insert additional style sheets, or JavaScript.<br><br>This feature is not available in the Lite version of the program!";
$lll["settings_extraBody"]="Zusätzliche BODY Inhalte";
// Changed in version 4.1.0. Old text:
//$lll["settings_extraBody_expl"]="With this, you can insert custom HTML right after the opening BODY tag of the pages. E.g. you can insert a banner above all the pages here.<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_extraBody_expl"]="With this, you can insert custom HTML right after the opening BODY tag of the pages. E.g. you can insert a banner above all the pages here.<br><br>This feature is not available in the Lite version of the program!";
$lll["settings_extraTopContent"]="Zusätzlicher Inhalt Oben";
// Changed in version 4.1.0. Old text:
//$lll["settings_extraTopContent_expl"]="With this, you can insert custom HTML below the header section of the pages (status bar, menus).<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_extraTopContent_expl"]="With this, you can insert custom HTML below the header section of the pages (status bar, menus).<br><br>This feature is not available in the Lite version of the program!";
$lll["settings_extraBottomContent"]="Zusätzlicher Inhalt Unten";
// Changed in version 4.1.0. Old text:
//$lll["settings_extraBottomContent_expl"]="With this, you can insert custom HTML above the powered footer of the pages.<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_extraBottomContent_expl"]="With this, you can insert custom HTML above the powered footer of the pages.<br><br>This feature is not available in the Lite version of the program!";
$lll["settings_extraFooter"]="Zusätzlicher Inhalt im Fussbereich";
// Changed in version 4.1.0. Old text:
//$lll["settings_extraFooter_expl"]="With this, you can insert custom HTML right before the closing BODY tag of the pages.<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_extraFooter_expl"]="With this, you can insert custom HTML right before the closing BODY tag of the pages.<br><br>This feature is not available in the Lite version of the program!";
$lll["securityProperties"]="Sicherheitseinstellungen";
$lll["settings_applyCaptcha"]="Hinzufügen von Spamschutz (CAPTCHA) in den folgenden Formen";
$lll["settings_applyCaptcha_".Settings_response]="in 'Antworten zu den Beiträgen' und 'E-Mail zu einem Freund senden'";
$lll["settings_applyCaptcha_".Settings_login]="im Anmeldeformular";
$lll["settings_applyCaptcha_".Settings_register]="im Registrierungsformular";
$lll["settings_applyCaptcha_".Settings_submitAd]="in Anzeige einreichen";
$lll["settings_joomlaLink"]="Joomla Webseite";
$lll["settings_joomlaLink_expl"]="Wenn sie die Joomla! Brücke installiert haben, können Sie die URL Ihrer Joomla! Seite hier eingeben. Wenn Sie das tun, wird das Anmeldemenü um einen 'Meine Seite' Menüpunkt erweitert, mit dem Link zur URL.";
$lll["enableUserSearch"]="Benutzersuche aktivieren";
$lll["enableUserSearch_expl"]="Diese Funktion ist nicht verfügbar in der Evalutions-Version des Programms!";
$lll["appsettings_modify_completed"]="Die Einstellungen wurden erfolgreich bearbeitet.";
$lll["settings_langDir"]="Sprach-Ausrichtung";
$lll["settings_langDir_ltr"]="Links nach rechts";
$lll["settings_langDir_rtl"]="Rechts nach links";
// Benutzerdefinierte Felder
$lll["customfield"]="Benuzerdefiniertes Feld";
$lll["customfield_fixInfoText"]="Dies ist ein \ 'fix\'-Feld, was bedeutet, dass Sie es nicht löschen können sondern man kann nur einige der Eigenschaften ändern.";
$lll["mustBeCommaSeparated"]="Die möglichen Werte des Auswahl Feldes müssen ausgefüllt werden. Definieren sie dies durch Komma getrennte Zeichenketten";
$lll["invalidDefaultValue"]="Der Standardwert des Auswahl Feldes muss durch ein Komma getrennte Zeichenkette, in der Wert Feld Liste eingetragen werden.";
$lll["descriptionDefaultLabel"]=$lll["description"]="Beschreibung";
$lll["privateField"]="Privat";
$lll["customfield_type"."_".customfield_text]="Text";
$lll["customfield_type"."_".customfield_textarea]="Textbereich";
$lll["customfield_type"."_".customfield_bool]="Boolean";
$lll["customfield_type"."_".customfield_selection]="Auswahl";
$lll["customfield_type"."_".customfield_multipleselection]="Mehrfach Auswahl";
$lll["customfield_type"."_".customfield_separator]="Trenner";
$lll["customfield_type"."_".customfield_checkbox]="Auswahlkästchen";
$lll["customfield_type"."_".customfield_picture]="Bilder";
$lll["customfield_type"."_".customfield_media]="Medien Dateien";
$lll["customfield_type"."_".customfield_url]="Web Link";
$lll["customfield_type"."_".customfield_date]="Datum";
$lll["customfield_dateDefaultNow"]="Standard Datum ist der heutige Tag";
$lll["customfield_fromyear"]="Von Jahr";
$lll["customfield_fromyear_expl"]="Der Bereich der Datumsauswahl beginnend mit diesem Jahr. 
                                   Geben Sie die Aktuelle Jahreszahl ein z.B. '1971', oder geben Sie 'now' ein als Stand von dem aktuellen Jahr.
                                   Sie können auch ein relatives Jahr eingeben: 'now-5' dann entspricht dies dem jetzigen Zeitpunkt vor 5 Jahren!";
$lll["customfield_toyear"]="Zu Jahr";
$lll["customfield_toyear_expl"]="Der bereich der Datumsauswahl endend mit einem bestimmten Jahr.
                                   Geben Sie die Aktuelle Jahreszahl ein z.B. '2010', der geben Sie 'now' ein als Stand von dem aktuellen Jahr.
                                   Sie können auch ein relatives Jahr eingeben: 'now+5' dann entspricht dies dem jetzigen Zeitpunkt in 5 Jahren!";
$lll["customfield_name"]="Name";
$lll["selectUserField"]="-- Benutzerfeld Auswahl --";
$lll["customfield_userField"]="oder wählen Sie die Benutzerfelder";
$lll["customfield_userField_expl"]="Statt der Schaffung eines völlig neuen benutzerdefiniertes Feld, können sie auch den Namen eines Benutzers Feldes angeben. Dieser Weg, den Bereichen des Inhabers eines Anzeige auszuwählen, kann entweder direkt in der Anzeigen-Liste oder auf der Anzeigen-Info-Seite angezeigt werden. <br><br>E.g. you can add the phone number of the owner of the ad to the ad details page. Or if you have a custom 'Zip code' user field, you can display it, too. Moreover, if you specify the Zip code as 'Searchable', users will be able to search for ads by zip code!";
$lll["userField"]="Benutzerfeld";
$lll["customfield_type"]="Typ";
$lll["customfield_default_bool"]=
$lll["customfield_default_text"]=
$lll["customfield_default_multiple"]="Standard Wert";
$lll["customfield_active"]="Aktiv";
$lll["customfield_separator"]="Spalte %s";
$lll["customfield_mandatory"]="Pflichtfeld";
$lll["customfield_checkboxCols"]="Anzahl der Spalten, für das Kontrollkästchen";
$lll["customfield_showInList"]="Anzeigen in der Liste für";
$lll["customfield_values"]="Mögliche Werte";
$lll["customfield_innewline"]="Platz in neuer Zeile";
$lll["customfield_displayLabel"]="Ettiketten anzeigen";
$lll["customfield_displayLabel_expl"]="Wenn diese Option ausgeschaltet ist, wird die Feldbezeichnung nicht angezeigt, in der Anzeigen-Info-Seite und dem Feld Wert wird sich über die Etiketten der anderen Felder legen.";
$lll["userfield_displayLabel_expl"]="Wenn diese Option ausgeschaltet ist, wird die Feldbezeichnung nicht angezeigt, in der Benutzer-Detail-Seite und dem Feld Wert wird sich über die Etiketten der anderen Felder legen.";
$lll["customfield_displaylength"]="Angezeigte Listen Länge";
$lll["customfield_displaylength"."_expl"]="Die maximale Anzahl von Zeichen in einer Liste. Das Erscheinungsbild der Liste, kann gegen die Anzeige sehr lange Felder in einer Zelle geschützt werden.";
$lll["userfield_displaylength"."_expl"]="Die maximale Anzahl von Zeichen die angezeigt wird in der Benutzer-Detail-Liste. Das Erscheinungsbild der Liste, kann gegen die Anzeige sehr lange Felder in einer Zelle geschützt werden.";
// Changed in version 3.1.0. Old text:
//$lll["customfield_searchable"]="Searchable";
// New text:
$lll["customfield_searchable"]="Show in the search form for";
$lll["customfield_searchable"."expl"]="Wenn diese Option aktiviert ist, können Benutzer eine Suche nach diesem Attribut mit einer Reihe von Zahlen wie '10-20' durchführen";
$lll["customfield_rangeSearch"]="Bereichsuche zulassen";
// Changed in version 3.1.0. Old text:
//$lll["customfield_rangeSearch_expl"]="If this is checked than one can define e.g. '10-20' as a search condition to search for ads where the value of this field is between 10 and 20.";
// New text:
$lll["customfield_rangeSearch_expl"]="If this is checked than one can define e.g. '10-20' as a search condition to search for ads where the value of this field is between 10 and 20. Or one can enter a range of dates in case of Date fields.";
$lll["userfield_rangeSearch_expl"]="Wenn dies aktiviert ist können Sie Bereiche definieren, wie z.B. '10-20', als Suchbedingung für die Suche nach Anzeigen, wenn der Wert dieses Feldes zwischen 10 und 20 liegt.";
$lll["customfield_allowHtml"]="Erlaube HTML";
// Changed in version 4.0.0. Old text:
//$lll["customfield_allowHtml_expl"]="This only allows 'safe' HTML tags, however! Some tags that would impose a security risk, or ruin the layout are excluded.";
// New text:
$lll["customfield_allowHtml_expl"]="This only allows 'safe' HTML tags, however! Some tags that would impose a security risk, or ruin the layout are excluded.<br><br>If you don't allow HTML, some simple rules will be still applied: line breaks in the text will be rendered as new lines, web links and email addresses will turn into clickable links.";
$lll["customfield_private"]="Privates erlauben";
$lll["customfield_subType"]="Behandeln Sie diese Feld als";
$lll["customfield_subType_expl"]="z.B. wenn Sie ein 'Preis' Feld haben, ist es ratsam eine 'Dezimal Zahl' einzusetzen, so dass die Sortierung in der Preis-Spalte und Reihe eine Suche nach dem Preis Feld richtig erfolgt und arbeitet. Sie können dann das erforderlichen Währungssymbol, die Nachkommawerte und das Tausende Trennzeichen in der 'Anzeige Formatierung' einstellen.";
$lll["userfield_subType_expl"]="";
$lll["customfield_subType_".customfield_alnum]="Text";
$lll["customfield_subType_".customfield_integer]="Integer Zahl";
$lll["customfield_subType_".customfield_float]="Dezimal Zahl";
$lll["customfield_sortable"]="Ermöglicht die Sortierung des Feldes";
$lll["customfield_expl"]="Erläuterungstext";
$lll["customfield_expl"."_expl"]="Hilfe Text wie Sie gerade einen lesen! Eine ausführlichere Beschreibung für ein Formularfeld.";
$lll["private_field"]="(Privates)";
$lll["itemfield_ttitle"]="Benutzerdefinierte Felder der Kategorie '%s'";
$lll["customfield_newitem"]="Neues benutzerdefiniertes Feld hinzufügen";
$lll["customfield_modify_form"]="Benutzerdefiniertes Feld bearbeiten";
$lll["customfield_create_form"]="Benutzerdefiniertes Feld erstellen";
$lll["customfield_sortId"]="Sortierung";
$lll["customfield_sorthelp"]="Benutze die Pfeilsortierung in der Spalte 'Sortierung' um die Reihenfolge der Liste zu ändern. Anschließend klicken Sie auf 'Sortierung speichern' am Ende!";
$lll["customfield_savesorting"]="Sortierung speichern";
$lll["customfield_advanced_form"]="Erweiterte Optionen";
$lll["customfield_sortingsaved"]="Das neue benutzerdefinierte Feld wurde erfolgreich gespeichert.";
$lll["customFields"]="Liste der benutzerdefinierten Felder";
$lll["customfield_rowspan"]="Zeilen Einstellung";
$lll["customfield_seo"]=$lll["seoProperties"];
$lll["customfield_seo_0"]="Keine Zuordnung";
$lll["customfield_seo_".customfield_title]="In diesem Feld wie der TITEL der Info-Seite";
$lll["customfield_seo_".customfield_description]="In diesem Feld wie die BESCHREIBUNG in der Detail Seite";
$lll["customfield_seo_".customfield_keywords]="In diesem Feld wie die KENNWORTER in der Detail Seite";
$lll["customfield_mainPicture"]="Verwenden Sie dieses Feld für wichtige Bilder";
$lll["customfield_mainPicture_expl"]="Verwenden Sie dieses Bild nicht in den Kategorie spezifischen listen und RSS Feeds.";
$lll["userfield_mainPicture_expl"]=" ";
$lll["customfield_seo_expl"]="Sie können hier die benutzerdefinierten Felder als Teil des Inhaltes dem HTML TITEL Tag, der BESCHREIBUNGS Tags und des KENNWORT Tags hinzufügen, bzw. 
                              bei SEO, den Inhalt des TITEL Feldes in der Titelleiste des Browsers erscheinen lassen, wenn die Anzeige angezeigt wird, aber 
                              es wird nicht benutzt um den Titel der Anzeige in den Kategorie spezifischen Listen und in RSS Feeds anzuzeigen.";
$lll["userfield_seo_expl"]="Sie können hier die benutzerdefinierten Felder  der Benutze als Teil des Inhaltes dem HTML TITEL Tag, der BESCHREIBUNGS Tags und des KENNWORT Tags hinzufügen, bzw."; 
$lll["customfield_innewline_expl"]="Statt der Bildung einer neuen Spalte, ermöglicht diese Einstellung, den benutzerdefinierte Feld Wert in einer neuen Zeile, die sich dann über alle anderen Spalten horizontal befindet und darunter.";
$lll["customfield_rowspan_expl"]="Verwenden Sie diese in Verbindung mit dem 'Platz in neue Zeile' als Eigentum von anderen benutzerdefinierten Feldern. Wenn es andere Felder gibt, werden diese in eine neue Zeile gelegt, so können Sie mit dieser Einstellung erreichen, dass dieses Feld vertikal in einer neuen Zeile liegt.";
$lll["customfield_detailsPosition"]="Position";
$lll["customfield_detailsPosition_expl"]="Die Platzierung der Felder auf den Anzeigen-Details-Seiten. Die 'Seitenleiste' ist der richtige Bereich vom Detail-Bereich, wo die Bilder liegen (in der modernen Thema). Mit dieser Einstellung können Sie die Felder über den Bilder Bereich, oder unter diesen legen.";
$lll["userfield_detailsPosition_expl"]="Die Platzierung der Felder auf den Benutzer-Details-Seiten. Die 'Seitenleiste' ist der richtige Bereich vom Detail-Bereich, wo die Bilder liegen (in der modernen Thema). Mit dieser Einstellung können Sie die Felder über den Bilder Bereich, oder unter diesen legen..";
$lll["customfield_detailsPosition_".customfield_normal]="Normal";
$lll["customfield_detailsPosition_".customfield_topright]="Oben in der Seitenleiste";
$lll["customfield_detailsPosition_".customfield_bottomright]="Unten in der Seitenleiste";
$lll["formProperties"]="Formular Einstellungen";
$lll["listProperties"]="Listen-Einstellungen";
$lll["detailsProperties"]="Einstellungen der Detailseite";
$lll["searchProperties"]="Such Einstellungen";
$lll["miscProperties"]="Verschiedene Einstellungen";
$lll["customfield_showInForm"]="Zeige Formulare für";
$lll["userfield_showInForm_expl"]="Beachten Sie, dass im Falle der Festsetzung der Benutzer Felder, hat diese Einstellung nur eine begrenzte Bedeutung! Z.B. Wenn Sie das Feld 'Name' nehmen, das angezeigt werden soll nur für den Administrator, so bezieht es sich nur auf den Benutzer im geänderten Formular (d.h. Sie können nicht das Feld 'Name' verbergen in der Registrierung und im Anmelde-Formular). Ebenso können Sie nicht das 'Email' Feld aus dem Anmeldeformular ausblenden.";
$lll["customfield_showInDetails"]="Anzeigen für";
$lll["enableUserSearch_".customfield_forNone]=$lll["showInForm_".customfield_forNone]=$lll["showInList_".customfield_forNone]=$lll["showInDetails_".customfield_forNone]=$lll["enableFavorities_".customfield_forNone]=$lll["subscriptionType_".customfield_forNone]="nichts";
$lll["enableUserSearch_".customfield_forAll]=$lll["showInForm_".customfield_forAll]=$lll["showInList_".customfield_forAll]=$lll["showInDetails_".customfield_forAll]=$lll["enableFavorities_".customfield_forAll]=$lll["subscriptionType_".customfield_forAll]="alle";
$lll["enableUserSearch_".customfield_forLoggedin]=$lll["showInForm_".customfield_forLoggedin]=$lll["showInList_".customfield_forLoggedin]=$lll["showInDetails_".customfield_forLoggedin]=$lll["subscriptionType_".customfield_forLoggedin]=$lll["enableFavorities_".customfield_forLoggedin]="nur für angemeldete Benutzer";
$lll["showInForm_".customfield_forOwner]=$lll["showInList_".customfield_forOwner]=$lll["showInDetails_".customfield_forOwner]="Nur für die Inhaber der Anzeige";
$lll["enableUserSearch_".customfield_forAdmin]=$lll["showInForm_".customfield_forAdmin]=$lll["showInList_".customfield_forAdmin]=$lll["showInDetails_".customfield_forAdmin]=$lll["subscriptionType_".customfield_forAdmin]=$lll["enableFavorities_".customfield_forAdmin]="nur der Administrator";
$lll["enableFavorities_".customfield_forAllButAdmin]=$lll["subscriptionType_".customfield_forAllButAdmin]="alle ohne Administrator";
$lll["formatSection"]="Anzeige Formatierungen";
$lll["customfield_formatPrefix"]="Präfix";
$lll["customfield_useMarkitup"]="Verwenden Sie den eingebetteten HTML-Editor statt eines einfachen Textbereiches";
// Benutzerdefinierte Felder der Benutzer:
$lll["userfield_ttitle"]="Benutzerdefiniertes Feld der Benutzer";
$lll["userfield_type"."_expl"] = "";
// Benachrichtigungen:
$lll["notification"]="Benachrichtigung";
$lll["Notifications"]=$lll["notification_ttitle"]="Benachrichtigungen";
$lll["notification_subject"]="E-Mail Betreff";
$lll["notification_body"]="E-Mail Textbereich";
$lll["notification_variables"]="Variablen erlauben";
$lll["notification_active"]="Aktiv";
$lll["notification_modify_form"]="Benachrichtigung bearbeiten";
$lll["notif_remindpass_tit"]="Enthält ein neues Passwort, wenn der Benutzer sein altes vergessen hat.";
$lll["notif_remindpass_subj"]="Neues Passwort";
$lll["notif_initpass_tit"]="Sendet nach der Registrierung dem Benutzer das erste Passwort";
$lll["notif_initpass_subj"]="Erstes-Passwort";
$lll["notification_cc"]="an";
$lll["notification_cc_expl"]="Geben Sie hier die E-Mail-Adresse ein, an wen die Meldung als Kopie gesendet werden soll.";
$lll["notification_active_expl"]="Sie können hier das Versenden der Benachrichtung ein- und ausschalten.";
//Kategorie:
$lll["category_expirationEnabled"]="Ablaufzeit aktivieren";
$lll["category_expirationOverride"]="Erlaube die Ablaufzeit zu überschreiben für";
$lll["category_allowSubmitAdAdmin"]="Nur der Administrator kann Anzeigen zur Kategorie hinzufügen";
$lll["category_expirationOverride_expl"]="Wenn Sie das Feld 'Anzahl der Tage bevor die Anzeige abläuft' aktivieren kann der Inhaber im Erstellen/Bearbeiten Formular eine Anzahl eingeben. Wenn Sie '0' in das Feld eingeben, ist dass für bliebige viele Tage. Wenn Sie aber spezifisch größer als '0' eingeben, dies der Standard und es ist die maximale Anzahl, die der Inhaber der Anzeige eingeben kann.";
$lll["category_expirationOverride_".customfield_forNone]="Nichts";
$lll["category_expirationOverride_".customfield_forLoggedin]="Alle Benutzer";
$lll["category_expirationOverride_".customfield_forAdmin]="Nur für Administrator";
$lll["category_organize"]="Kategorien Organisieren";
$lll["methods"]="Methode";
$lll["clone"]="Kopiere";
$lll["exp"]="Verfallstag";
$lll["useDragAndDrop"]="Verwenden Sie Drag-and-Drop zum reorganisieren der Kategorien und klicken Sie dann auf 'Speichern'!";
$lll["organizeSaveButton"]="Reihenfolge speichern";
$lll["organizeSaveMessage"]="Die Kategorie-Reihenfolge wurde erfolgreich gespeichert.";
$lll["organizeSaveError"]="Konnte nicht die Daten zum Server senden.";
$lll["organizeLoadError"]="Konnte nicht die Daten vom Server laden.";
$lll["copyOfCategory"]="Kopiere in '%s'";
$lll["organizeNextPageDrop"]="Wenn Sie hier mit der Maus über die Kategorie ziehen, kommen Sie in die nächste Seite.";
$lll["organizePreviousPageDrop"]="Wenn Sie hier mit der Maus über die Kategorie ziehen, kommen Sie in die vorhergehende Seite.";
$lll["organizeNextItems"]="Nächste Kategorien &raquo;";
$lll["organizePreviousItems"]="&laquo; Vorangegangenen Kategorien";
// Felder Set:
// Changed in version 4.1.0. Old text:
//$lll["fieldset_create_form"]="Advanced operations on the whole list of custom fields of the category (they don't work in the free version!)";
// New text:
$lll["fieldset_create_form"]="Advanced operations on the whole list of custom fields of the category (they don't work in the Lite version!)";
$lll["fieldset_deleteAll"]="Lösche alle Felder";
// Changed in version 3.1.0. Old text:
//$lll["fieldset_deleteAll_expl"]="This will delete all the non-fix custom fields of this category at once.<br><br>Please note that deleting custom fields causes data loss, because the corresponding ad field values will be deleted, too!";
// New text:
$lll["fieldset_deleteAll_expl"]="This will delete all the unique custom fields of this category at once.<br><br>Please note that deleting custom fields causes data loss, because the corresponding ad field values will be deleted, too!";
$lll["fieldset_cloneToSubcats"]="Kopiere in Unterkategorien";
$lll["fieldset_cloneToSubcats_expl"]="Diese Liste der benutzerdefinierten Felder ist in jeder der Unterkategorien von dieser Kategorie.<br><br>Bitte beachten Sie, dass wenn die Unterkategorien bereits benutzerdefinierte Felder haben, diese zuerst gelöscht werden! Also, diese Operationen sind vor allem nützlich, für die Einrichtung neuer Kategorien, aber es kann auch zu Datenverlust führen in den bereits vorhandenen Kategorien mit Anzeigen.";
$lll["fieldset_cloneToCats"]="Kopiere in Kategorien";
$lll["fieldset_cloneToCats_expl"]="Diese Liste der benutzerdefinierten Felder ist in jeder Kategorie, sie könne diese rechts auswählen (Mehrfachauswahl ist möglich!).<br><br>Bitte beachten Sie, dass wenn die Unterkategorien bereits benutzerdefinierte Felder haben, diese zuerst gelöscht werden! Also, diese Operationen sind vor allem nützlich, für die Einrichtung neuer Kategorien, aber es kann auch zu Datenverlust führen in den bereits vorhandenen Kategorien mit Anzeigen.";
$lll["fieldset_cloneFromCat"]="Kopie von der Kategorie";
$lll["fieldset_cloneFromCat_expl"]="Das ist das Gegenteil der vorangegangenen Operation: es wird alle bestehenden benutzerdefinierten Felder dieser Kategorie mit den benutzerdefinierten Feldern der Listen einer andere Kategorie ersetzen. Das gleiche trifft hier zu, es kann zu Datenverlust führen von bereits existierenden Kategorien mit Anzeigen!<br><br>Nur, um es völlig klar zu sagen: keine der Kopien ist tatsächlich die Kopie der Anzeigen oder Anzeigen-Werte! Und um die Kategorien nicht zu kopieren machen Sie entweder, eine Kopie der Feldlisten mit all den Eigenschaften, dann ist eine Verlagerung der Anzeigen in eine andere Kategorie auf der Grundlage von 'Verschieben' der Anzeigen in der Ansicht möglich. Wenn Sie möchten, erstellen Sie Duplikate von ganzen Gruppen (mit all ihren benutzerdefinierte Felder, aber ohne ihre Anzeigen und Unter-Kategorien!), Sie können die 'Kopier'-Funktion im Rahmen des Menüpunktes 'Kategorien Organisieren' durchführen.";
$lll["fieldset_deleteAll_successful"]="Das benutzerdefinierte Feld wurde erfolgreich gelöscht";
$lll["fieldset_cloneToSubcats_successful"]="Die benutzerdefinierten Felder wurden erfolgreich in Unterkategorien kopiert";
$lll["fieldset_cloneToCats_successful"]="Die benutzerdefinierten Felder wurden erfolgreich in die ausgewählten Kategorien kopiert";
$lll["fieldset_cloneFromCat_successful"]="Die benutzerdefinierten Felder der ausgewählten Kategorie wurden erfolgreich hier her kopiert.";
?>
