<?php
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
$lll["db_installed"]="Cơ sở dữ liệu đã được cài đặt: %s";
// Changed in version 4.1.0. Old text:
//$lll["cantcreatedb"]="Can not reach or create database. User %s has no create database permission, or cannot reach the database. Change the name of the user or give him appropriate rights!";
// New text:
$lll["cantcreatedb"]="Help! NOAH Cannot reach or create your database. User %s has no create database permission, or cannot reach the database. Change the name of the user or give it the appropriate rights!";
// Changed in version 4.1.0. Old text:
//$lll["cantconnectdb"]="Can not connect to database. May be have no rights or not exists, trying to create.";
// New text:
$lll["cantconnectdb"]=" Help! NOAH Cannot connect to database. Odds are there no rights or does not exist, trying to create.";
$lll["inst_create_table_err"]="Sự cố trong khi đang cố gắng tạo ra bảng biểu, %s đã được cài đặt?";
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
$lll["inst_click"]="Nhần vào đây để truy cập %s.";
// Changed in version 4.1.0. Old text:
//$lll["createTableFailed"]="Create table failed";
// New text:
$lll["createTableFailed"]="Ouch! Create table failed";
$lll["install"]="Cài đặt";
$lll["clickToInstall"]="Bấm vào 'Cài đặt' để cài đặt %s!";
$lll["admin_ok"]="Thành viên Quản trị viên đã được tạo ra, tên thành viên: admin, mật khẩu: admin.";
// Changed in version 4.1.0. Old text:
//$lll["create_file_ok"]="Config has been successfully created.";
// New text:
$lll["create_file_ok"]="Awesome!!! Config has been successfully created.";
// Changed in version 4.1.0. Old text:
//$lll["create_file_nok"]="Config file have to be created manually.";
// New text:
$lll["create_file_nok"]="Ouch! Config file have to be created manually, it happens.";
$lll["inst_params"]="MySQL cơ sở dữ liệu sẽ được tạo ra với các tham số như sau:";
$lll["edit_params"]="Đổi các tham số";
$lll["acceptTerms"] = "Tôi đã đọc qua và chấp nhận các điều khoản và điều kiện dưới đây: <input type='checkbox' id='accept' name='accept'>";
$lll["youMustAcceptTerms"] = "Bạn phải chấp nhận các điều khoản và điều kiện để tiếp tục sử dụng!";
$lll["dbHostName"]=$lll["hostName"]="Tên máy Lưu trữ";
$lll["mysqluser"]="Mysql tên người sử dụng";
$lll["dbDbName"]=$lll["dbName"]="Tên cơ sở dữ liệu";
$lll["dbSocket"]="Socket";
$lll["formtitle"]="Cài đặt MySQL";
$lll["password"]="Mật mã";
$lll["dbPort"]="Port";
$lll["cookieok"]="Cookie được bật.";

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
$lll["afterwrconf"]="<u>Sau khi</u> viết cấu hình tập tin, bấm vào liên kết bên dưới!";
$lll["move_inst_file"]="Xin vui lòng xóa các tập tin install.php trong mục này!";
// Changed in version 4.1.0. Old text:
//$lll["inst_ch_pw"]="Administrator settings - username: admin, password: admin, don't forget to change the password!";
// New text:
$lll["inst_ch_pw"]="Administrator settings - username: admin, password: admin, and don't forget to change the password!";
$lll["create_file_nok_ext"]="Máy chủ phục vụ không có sự cho phép tạo ra một tập tin cấu hình. Bạn có hai sự lựa chọn:<br>\n#1: Tạo một tập tin trống rỗng với tên app/config.php, và cung cấp cho các máy chủ được phép ghi vào bên trong.  Dưới unix:<br>touch app/config.php;chmod 777 app/config.php<br>và bấm vào nút Reload/Refresh.<br>#2: Bạn có thể cài đặt để tạo các tập tin cấu hình bằng phép không tự động.<br>Chương trình sẽ xuất hiện chữ ghi vào tập tin app/config.php.";
$lll["versionTooLow"]="Yêu cầu tối thiểu Mysql phiên bản là %s. Hiện tại là %s. Tối thiểu yêu cầu Php phiên bản là %s. Phiên bản hiện tại là %s.";

// register:
$lll["registerNoah"]="Đăng ký";
$lll["notRegistered"]="Chưa đăng ký"; 
$lll["registerNoahTitle"]="Đăng ký bản quyền Noah Classifieds"; 
// Changed in version 4.1.0. Old text:
//$lll["noahAlreadyRegistered"]="The product is already registered!";
// New text:
$lll["noahAlreadyRegistered"]="Your NOAH is already registered!";
$lll["noahRegistrationFalseResponse"]="Không thể gửi dữ liệu đăng ký đến máy chủ Noah. Xin vui lòng, hãy thử lại sau!"; 
// Changed in version 4.1.0. Old text:
//$lll["noahRegistrationSuccessfull"]="Thank you. The product is now registered!";
// New text:
$lll["noahRegistrationSuccessfull"]="Thank you. Your NOAH is now registered!";


// update:
$lll["download"]="Tải xuống";
$lll["u_maintitle"]="Noah's Classifieds mới cập nhật tiến hành";
// Changed in version 4.1.0. Old text:
//$lll["secure_copy"]="It is recommended to make a dump of your Noah's Classifieds database before the update!";
// New text:
$lll["secure_copy"]="It is recommended to make a databse dump of your Noah's Classifieds before the update!";
$lll["ready_to_update"]="Sẵn sàng để cập nhật mói với cơ sở dữ liệu %s phiên bản %s?<br>";
// Changed in version 4.1.0. Old text:
//$lll["invalid_version"]="The given version is invalid: %s";
// New text:
$lll["invalid_version"]="hmm...The given version is invalid: %s";
// Changed in version 4.1.0. Old text:
//$lll["updateSuccessful"]="The update successfully completed.";
// New text:
$lll["updateSuccessful"]="The NOAH update successfully completed.";
$lll["updating"]="Cập nhập từ phiên bản %s đến phiên bản %s...";
// Changed in version 4.1.0. Old text:
//$lll["already_installed"]="The latest software version %s is already installed.";
// New text:
$lll["already_installed"]="The latest NOAH software version %s is already installed.";
$lll["picturesDirMustbeWritable"]="Các '%s' thư mục phải được ghi vào chương trình để thực hiện cập nhật! Cập nhật không thành công.";
$lll["updateAutomatic"]="Cập nhật";
$lll["updateManualZip"]="ZIP tải xuống";
$lll["updateManualTgz"]="TGZ tải xuống";
$lll["downloadFileNotExists"]="Tải xuống tập tin '%s' không tồn tại.";
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
$lll["checkUpdates"]="Cập nhật"; 
$lll["checkUpdatesDescription"]="Kiểm tra nếu có một phiên bản mới hơn được phát hành. Bạn có thể cập nhật ngay lập tức, hoặc tải phần mểm mới xuống!"; 
$lll["checkUpdatesTitle"]="Kiểm tra trang mạng của Noah's Classifieds nếu có cập nhật mới phát hành"; 
// Changed in version 4.1.0. Old text:
//$lll["nopermission"]="The program has no write permission under the following directories: %s<br>You must execute the following Unix command (in Unix systems, of course):<br><i>chmod 777 &lt;replace directory name&gt;</i>";
// New text:
$lll["nopermission"]="The NOAH program has no write permission under the following directories: %s<br>You must execute the following Unix command (in Unix systems, of course):<br><i>chmod 777 &lt;replace directory name&gt;</i>";
$lll["nopermission_expl"]="Trong thời gian hoạt động của nó, Noah's Classifieds đã để lưu các tập tin trong một số thư mục con, để đăng tải hình ảnh, sự cố đăng nhập hoặc tạo ra các tập tin bộ nhớ cache. Bạn phải đảm bảo rằng các chương trình đã có được sự cho phép để làm việc này.)";
$lll["backToIndex"]="Trở lại Classifieds.";
$lll["onlyFrom1.3"]="Phiên bản của bạn cũ hơn 1.3. Cập nhật mới được phát hành cho phiên bản mới hơn 1.3!";
$lll["cantGetVersionInfo"]="Không thể nhận được thông tin phiên bản. Cập nhật không thành công.";


// checking configuration:
// Changed in version 4.1.0. Old text:
//$lll["checkMailtestTitle"]="Sending out a test mail...";
// New text:
$lll["checkMailtestTitle"]="NOAH is sending out a test mail...";
$lll["triggerMailTest"]="Nhấn vào đây để kiểm tra Email gởi đi."; 
$lll["unableToConnectNoah"]="Không thể kết nối đến máy chủ của Noah. Xin vui lòng, hãy thử lại sau!"; 
$lll["itemNumbersRecalculated"]="Những mục số đã được tính toán lại thành công"; 
// Changed in version 4.1.0. Old text:
//$lll["dbPrefixExplanation"]="In case Noah's must share the database with tables of other applications, it's wise to specify a table prefix for the Noah's tables, in order to avoid table name collisions. E.g.: 'noah_'";
// New text:
$lll["dbPrefixExplanation"]="In case NOAH must share the database with tables of other applications, it's wise to specify a table prefix for the NOAH tables, in order to avoid table name collisions. E.g.: 'noah_'";
$lll["dbPrefix"]="bảng tiền tố.";
$lll["checkconf"]="Kiểm tra";
// Changed in version 4.1.0. Old text:
//$lll["checkconfDescription"]="Click here any time to verify if the program has been set up correctly. In case of any problems being detected, the Check page gives useful hints how to solve them.";
// New text:
$lll["checkconfDescription"]="Click here at any time to verify if the program has been set up correctly. In case of any problems being detected, the Check page gives useful hints how to solve them.";
// Changed in version 4.1.0. Old text:
//$lll["mailok"]="The send mail test has been successfully completed. You must soon get a test email on %s";
// New text:
$lll["mailok"]="The send mail test has been successfully completed. You will reveive a test email on %s";
// Changed in version 4.1.0. Old text:
//$lll["mailerr"]="The following error occured during sending out a test mail:<br>%s";
// New text:
$lll["mailerr"]="Ouch! The following error occured during sending out a test mail:<br>%s";
$lll["here1"]="Nhấn vào";
$lll["confpreerr"]="Có một số chữ trước khi cái &lt;? trong tập tin cấu hình! Xin vui lòng cắt bỏ các kiểu chữ như (nhiều dòng hay chiếm nhiều chỗ quá)!";
$lll["confposterr"]="Có một số chữ sau khi cái &lt;? trong tập tin cấu hình! Xin vui lòng cắt bỏ các kiểu chữ như (nhiều dòng hay chiếm nhiều chỗ quá)!";
$lll["conffileok"]="Tập tin cấu hình có vẻ là ok.";
// Changed in version 4.1.0. Old text:
//$lll["congrat"]="Congratulations! You have successfully installed Noah's Classifieds!";
// New text:
$lll["congrat"]="Congratulations! You have successfully installed you new Noah's Classifieds!";
$lll["confcheck"]="Hệ thống cấu hình đang kiểm tra...";
// Changed in version 4.1.0. Old text:
//$lll["confdisapp"]="If you want to begin to work with the software and you want this page to disappear";
// New text:
$lll["confdisapp"]="If you want to begin to work with on your Noah's Classifieds and you want this page to disappear";
$lll["confclicheck"]="Bạn có thể truy cập kiểm tra trang này bất cứ lúc nào bạn muốn, bạn chỉ nhấp vào nút 'Kiểm tra' liên kết trên.";
$lll["chadmemail"]="Hiện tại địa chỉ thư điện tử của bạn admin@admin.admin. Xin hãy đặt sửa lại cho đúng trong nút'Hồ sơ của bạn' ở liên kết trên.";
// Changed in version 4.1.0. Old text:
//$lll["chsyspass"]="Your system email adress is not yet set. Please set it clicking on the 'Settings' link on the menubar!";
// New text:
$lll["chsyspass"]="Your system email address is not yet set. Please set it clicking on the 'Settings' link on the menubar!";
// Changed in version 4.1.0. Old text:
//$lll["chsyspass_expl"]="The program can't send out notification emails without the system email address that will populate the 'From' and 'Reply-to' fields of the notification emails.";
// New text:
$lll["chsyspass_expl"]="NOAH cannot send out notification emails without the system email address that will populate the 'From' and 'Reply-to' fields of the notification emails.";
$lll["chadmpass"]="Mặc định: Ban Quảng Lý mật mã chưa đổi! Xin vui lòng thay đổi nó bằng cắch nhấp vào nút 'Hồ sơ của bạn' ỡ liên kết trên.";
$lll["settings_adminEmail"]="Hệ thống thư điện tử";
// Changed in version 4.1.0. Old text:
//$lll["settings_adminEmail_expl"]="This will appear as the address in the 'From:' field of emails the program sends. If you leave this blank, the program may not be able send out email notifications!";
// New text:
$lll["settings_adminEmail_expl"]="This will appear as the address in the 'From:' field of emails the program sends. If you leave this blank... NOAH may not be able send out email notifications! Note that you may not use an email address in this field!";
$lll["nogd"]="Cảnh báo: máy chủ của bạn không có'GD libray' được cài đặt.";
// Changed in version 4.1.0. Old text:
//$lll["nogd_expl"]="(This library is responsible in php programs for the image manipulation, so it might be anyway useful if you put it on your server. In our program it is called for creating thumbnail images to the full sized uploaded pictures. Without this support the program can't generate thumbnails, this way the browser have to shrink 'on-the-fly' each big image in each pages where thumbnails can appear. This method works, but it is far from effective (the page have to download every time every big image). )";
// New text:
$lll["nogd_expl"]="(This library is responsible in php programs for the image manipulation, so it might be anyway useful if you put it on your server. In our program it is called for creating thumbnail images to the full sized uploaded pictures. Without this support the program cannot generate thumbnail sized pictures, this way the browser have to shrink 'on-the-fly' each big image in each pages where thumbnails can appear. This method works, but it is far from effective (the page have to download every time every big image). )";
// Changed in version 4.1.0. Old text:
//$lll["instFileRemove"]="In order to start using the program, you have to remove the installation files (%s).<br><a href='%s'>Click here to remove them!</a><span class='confexpl'> (If this message doesn't disappear after you clicked, it means the program has no permission to remove these files. In this case, you must delete them manually!)</span>";
// New text:
$lll["instFileRemove"]="In order to start using the NOAH program, the installation files have to be removed(%s).<br><a href='%s'>Click here to remove them!</a><span class='confexpl'> (If this message doesn't disappear after you clicked, it means the program has no permission to remove these files. In this case, the files need to be manually deleted.)</span>";
$lll["appFileRemoveExpl"]="Từ phiên bản 2.3.0, hầu hết các tập tin mà php được sử dụng để được trực tiếp theo tiến trình cài đặt thư mục, phải nằm dưới htaccess-protected 'app' của tiểu thư mục. Tiến trình cài đặt thư mục gốc chỉ có thể chứa 'index.php' và 'initdir.php'.";
$lll["appFileRemove"]="Để bắt đầu sử dụng chương trình, bạn phải xóa bỏ php không cần thiết từ tiến trình cài đặt gốc: <span class='confexpl'>%s.</span><br><br><a href='%s'>Nhấn vào đây để xóa bỏ chúng!</a><span class='confexpl'> (Nếu tin nhắn này không biến mất sau khi bạn nhấp vào, có nghĩa là chương trình không cho phép loại bỏ những tập tin này. Trong trường hợp này, bạn phải xóa chúng bằng phương pháp không tự động!)</span>";
$lll["backupFileRemoveExpl"]="Do sự bảo mật, sao lưu của các thư mục được tạo ra bằng tự động cập nhật phải bị xóa đi. Nếu bạn vẫn còn cần, thì sao chép lại bạn gốc!";
$lll["backupFileRemove"]="Để bắt đầu sử dụng chương trình, bạn cần phải loại bỏ các sao lưu các thư mục gốc từ tiến trình cài đặt:<span class='confexpl'>%s.</span><br><br><a href='%s'>Nhấn vào đây để xóa bỏ chúng!</a><span class='confexpl'> (Nếu tin nhắn này không biến mất sau khi bạn nhấp vào, có nghĩa là chương trình không cho phép loại bỏ những tập tin này. Trong trường hợp này, bạn phải xóa chúng bằng phương pháp không tự động!)</span>";
$lll["systemConfCheck"]="Hệ thống kiểm tra cấu hình ...";
$lll["niceURLFeature"]="URL tính năng khá:";
$lll["niceURLFeature_1"]="Noah's Classifieds hỗ trợ bằng cách sử dụng các URL khá.  Ví dụ điều này cho rằng các liên kết của rao vặt thông tin chi tiết có thể xem xét như thế này:";
$lll["niceURLFeature_2"]="thay vì giải pháp hiện giờ:";
$lll["niceURLFeature_3"]="Bên cạnh những cái cũ thì tốt, cũng nói cho rằng có công cụ kiếm thật thân thiện.";
$lll["niceURLFeature_4"]="Vì vậy, URL tốt có tính năng hoạt động Apache được gọi %s phải được cài đặt. Nó có thể không được tìm cho dù nó được cài đặt hiện thời (Php có thể được cài đặt như là một CGI nhị phân).";
$lll["niceURLFeature_5"]="Nếu %s đã được cài đặt, bạn nên tạo một tập tin dưới Classifieds gọi là thư mục cài đặt %s và đặt nó trong văn bản sau đây, để kích hoạt tính năng tốt đẹp URL:";
$lll["niceURLFeature_6"]="Nếu sau khi làm điều này, các tính năng url khá vẫn không hoạt động được, bạn cũng nên kiểm tra sau đây trong tập tin cấu hình của Apache:";
$lll["niceURLFeature_7"]="%s ghi đè lên cho Classifieds webroot được kích hoạt,";
$lll["niceURLFeature_8"]="%s cho Classifieds webroot được kích hoạt,";
$lll["niceURLFeature_9"]="Vì vậy, URL khá của tính năng hoạt động Apache được gọi là %s phải được cài đặt. Nó không phải cài đặt hiện tại..";
// Product registration:
$lll["reg_companyName"]="Tên công ty";
$lll["reg_firstName"]="Tên";
$lll["reg_lastName"]="Tên họ";
$lll["reg_email"]="Email";
$lll["reg_submit"]="Đệ Trình";
// RSS feed:
$lll["rss"]="RSS";
$lll["rssDescription"]="Thiết lập các nguồn cấp dữ liệu RSS của chương trình tạo ra.";
$lll["rss_modify_form"]="Chỉnh sửa nguồn cấp dữ liệu RSS";
$lll["rss_language"]="Ngôn ngữ";
$lll["rss_link"]="Liên kết";
// Changed in version 4.1.0. Old text:
//$lll["rss_link_expl"]="The URL of the classifeds site - e.g.: http://yoursete.com/classifieds";
// New text:
$lll["rss_link_expl"]="The URL of the classifeds site - e.g.: http://yoursite.com/classifieds";
$lll["rss_descField"]="Mô tả lĩnh vực";
$lll["rss_descField_expl"]="Lĩnh vực phục vụ như là 'Mô tả' của một quảng cáo, trong các nguồn cấp dữ liệu RSS. Classifieds cài đặt mặc định, nó là Lĩnh vực đầu tiên. Nếu bạn không có lĩnh vực nào, để '0 ', và không có rao vặt diễn giải trung bày trong nguồn cấp dữ liệu RSS.";

//globalsettings
$lll["settings"]="cài Đặt";
$lll["settings_modify_form"]="Trung Tâm Hệ Thống Cài Đặt";
$lll["settings_expNoticeBefore"]="Số ngày thành viên được thông báo trước khi hết hạn";
$lll["settings_charLimit"]="Số lượng chữ trong khi đặt rao vặt";
$lll["settings_charLimit_expl"]="'0' có nghĩa không giới hạn.";
$lll["settings_blockSize"]="Rao vặt trưng bày trên mỗi trang ";
$lll["settings_maxPicSize"]="Tối đa kích thước hình ảnh trong bytes";
$lll["settings_maxPicWidth"]="Chiều rộng tối đa hình ảnh trong pixels";
$lll["settings_maxPicHeight"]="Chiều cao tối đa hình ảnh trong pixels";
$lll["settings_maxPicSize_expl"]=$lll["settings_maxPicWidth_expl"]=$lll["settings_maxPicHeight_expl"]="'0' có nghĩa không giới hạn.";
$lll["settings_adminFromName"]="Tên hệ thống Email";
$lll["settings_adminFromName_expl"]="'Gởi tư:' Đây là đầu mục email khi bạn gửi được gởi đi.";
$lll["settings_versionFooter"]="Phiên bản phần dưới";
$lll["settings_titlePrefix"]="Đầu đề tiền tố"; 
$lll["settings_dateFormat"]="Ngày định dạng"; 
$lll["settings_dateFormat_expl"]="Thêm các thông tin và các ví dụ trong ngày cụ thể, <a href='http://php.net/manual/en/function.date.php' target='_blank'>bấm vào</a>"; 
$lll["settings_enableFavorities"]="Cho phép đặt vào danh sách Thích"; 
$lll["settings_enableFavorities_expl"]="Chức năng này không có trong phiên bản thử nghiệm!"; 
$lll["settings_updateCheckInterval"]="Coi có cập nhật mới phát hành của Noah"; 
$lll["settings_updateCheckInterval_expl"]="Chương trình này tự động kiểm tra các cập nhật mới nhất vừa phổ biến và được phát hành ra. Phần cập nhật sẽ có ngay ở trang Ban Quản Lý. Nếu bạn muốn vô hiệu hóa tính năng này, hãy đặt nó vào 0!";
$lll["mailProperties"]="Hệ Thống Chuyển Thư"; 
$lll["themeProperties"]="Hỗ Trợ Chủ Đề"; 
$lll["settings_defaultTheme"]="Chọn phong cách"; 
$lll["settings_allowedThemes"]="Cho phép chủ đề chọn từ"; 
$lll["settings_allowedThemes_expl"]="Nếu bạn tạo một tiểu mục dưới 'chủ đề' cho cách riêng- e.g. 'Chủ_đề_của_tôi', nó sẽ trung bày ngay trong mục mới với 'chủ đề của tôi!"; 
$lll["settings_allowSelectTheme"]="Cho phép thay đối chủ đề"; 
$lll["settings_allowSelectTheme_expl"]="Nếu được kích hoạt, một chọn lựa kéo xuống sẽ trung bày trên các trang mạng, cho phép thay đổi chương trình chủ đề ngay."; 
$lll["languageProperties"]="Hỗ Trợ Ngôn Ngữ"; 
$lll["settings_defaultLanguage"]="Ngôn ngữ mặc định"; 
$lll["settings_allowedLanguages"]="Được phép chọn ngôn ngữ từ"; 
$lll["settings_allowSelectLanguage"]="Được phép mọi người chọn ngôn ngữ khác"; 
$lll["settings_allowSelectLanguage_expl"]="Nếu được kích hoạt, một chọn lựa kéo xuống sẽ trung bày trên các trang mạng, cho phép thay đổi chương trình ngôn ngữ ngay."; 
$lll["settings_smtpServer"]="SMTP tên máy chủ"; 
$lll["settings_smtpServer_expl"]="Sử dụng lĩnh vực này, nếu bạn muốn chương trình gởi thông báo qua hệ thống email qua máy chủ SMTP. Còn không thư PHP chức năng sẽ thế sử dụng."; 
$lll["settings_smtpUser"]="Tên dùng SMTP"; 
$lll["settings_smtpPass"]="Mật mã SMTP"; 
$lll["settings_fallBackNative"]="Thư trả lại nếu SMTP vô hiệu"; 
$lll["settings_titlePrefix_expl"]="Hàng chữ này sẽ có trên tiêu ðề của trình duyệt.  Bạn có thể đổi nó thành tên trang mạng cho bạn."; 
$lll["seoProperties"]="Hệ Thống Từ Khóa"; 
$lll["settings_mainTitle"]="Tiêu đề từ khóa"; 
$lll["settings_mainTitle_expl"]="Nội dung của TIÊU ĐỀ, MÔ TẢ và TỪ KHÓA luôn phụ thuộc vào mục danh sách hay trang rao vặt hiện tại được thấy chi tiết.
                                  bạn có thể định nghĩa cho mỗi mục và cho mỗi thành viên cho mỗi rao vặt.tuy nhiên, ba lĩnh vực này, phục vụ như là giá trị chính cho những trường hợp, 
                                  khi một trang web chỉ là không ở trong một mục hay hoặc các bối cảnh. (trang mạng của chính nó v.v...)"; 
$lll["settings_mainDescription"]="Mô tả meta từ khóa tag"; 
$lll["settings_mainKeywords"]="Từ khoá meta khóa tag"; 
$lll["settings_helpLink"]="Điểm liên kết trợ giúp";
$lll["settings_helpLink_expl"]="URL đầy đủ của các tập tin trợ giúp. With this, bạn có thể định nghĩa trang Trợ giúp riêng. v.v..: http://yoursite/classifieds_dir/customhelp.html";
$lll["settings_maxMediaSize"]="Tối đa kích thước tập tin có thể tải lên trong bytes";
$lll["settings_maxMediaSize_expl"]="'0' nghĩa vô hạn.<br><br>Tuy nhiên, bất cứ thiết lập ở đây, có hai cách PHP cài đặt hạn chế tối đa tập tin có thể tải lên. chúng là 'upload_max_filesize' và 'post_max_size'. Chúng có thể cài đặt ở tập tin 'php.ini', hay trong tập tin 'httpd.conf', hay trong tập tin '.htaccess' file mỗi thư mục. Phần mặc định chỉ được dùng 2MB. Bạn có thể chấp nhận tới 50MB tập tin .htaccess:<br><br>php_value upload_max_filesize \"50M\"<br>php_value post_max_size \"50M\" ";
$lll["settings_subscriptionType"]="Thông báo kích hoạt tính năng tự động ";
$lll["settings_subscriptionType_expl"]="Thành viên có thể đăng ký để nhận thông báo tự động, nếu các quảng cáo mới được gửi đi trong mục.<br><br>Chức năng này không có trong phiên bản thử nghiệm!";
$lll["settings_menuPoints_expl"]="Nếu nút 'Đăng rao vặt' không đánh dấu, chỉ có Ban Quản lý được thấy thôi (Chỉ Ban Quảng lý được đệ trình rao vặt). Bạn cũng có thể vô hiệu hóa hay coi lại bản trình đơn, chỉ cần loại bỏ hoặc di chuyển các phần tương ứng trong phần 'layout.tpl.php' trong bản mẫu tập tin!";
$lll["settings_menuPoints"]="Chọn điểm";
$lll["settings_menuPoints_".Settings_showLogout]="Đăng xuất";
$lll["settings_menuPoints_".Settings_showLogin]="Đăng nhập";
$lll["settings_menuPoints_".Settings_showRegister]=$lll["registerNoah"];
$lll["settings_menuPoints_".Settings_showMyProfile]="Coi hồ sơ";
$lll["settings_menuPoints_".Settings_showMyAds]="Rao Vặt";
$lll["settings_menuPoints_".Settings_showMostPopularAds]="Phổ biến nhất";
$lll["settings_menuPoints_".Settings_showSearch]="Kiếm";
$lll["settings_menuPoints_".Settings_showHome]="Trang chủ";
$lll["settings_menuPoints_".Settings_displayHelp]="Giúp";
$lll["menuPointsSep"]="Cách bố trí";
$lll["expirationProperties"]="Hệ Thống gia hạn";
$lll["imageProperties"]="Hệ Thống Tải Lên";
$lll["otherProperties"]="Hệ Thống Cài Đặt khác";
$lll["adDisplayProperties"]="Hệ Thống Cài Đặt";
$lll["settings_renewal"]="Số lần thành viên được phép gia hạn rao vặt của họ";
$lll["settings_allowModify"]="Thành viên được phép thay đổi rao vặt của chính họ";
$lll["settings_extraHead"]="Thêm nội dung MỞ ĐẤU";
// Changed in version 4.1.0. Old text:
//$lll["settings_extraHead_expl"]="With this, you can insert custom HTML right before the closing HEAD tag of the pages. This is usually a good place to insert additional style sheets, or JavaScript.<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_extraHead_expl"]="With this, you can insert custom HTML right before the closing HEAD tag of the pages. This is usually a good place to insert additional style sheets, or JavaScript.<br><br>This feature is not available in the Lite version of the program!";
$lll["settings_extraBody"]="Thêm nội dung THÂN BÀI";
// Changed in version 4.1.0. Old text:
//$lll["settings_extraBody_expl"]="With this, you can insert custom HTML right after the opening BODY tag of the pages. E.g. you can insert a banner above all the pages here.<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_extraBody_expl"]="With this, you can insert custom HTML right after the opening BODY tag of the pages. E.g. you can insert a banner above all the pages here.<br><br>This feature is not available in the Lite version of the program!";
$lll["settings_extraTopContent"]="Thêm nội dung MỞ ĐẤU";
// Changed in version 4.1.0. Old text:
//$lll["settings_extraTopContent_expl"]="With this, you can insert custom HTML below the header section of the pages (status bar, menus).<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_extraTopContent_expl"]="With this, you can insert custom HTML below the header section of the pages (status bar, menus).<br><br>This feature is not available in the Lite version of the program!";
$lll["settings_extraBottomContent"]="Thêm nội dung PHẦN ĐUÔI";
// Changed in version 4.1.0. Old text:
//$lll["settings_extraBottomContent_expl"]="With this, you can insert custom HTML above the powered footer of the pages.<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_extraBottomContent_expl"]="With this, you can insert custom HTML above the powered footer of the pages.<br><br>This feature is not available in the Lite version of the program!";
$lll["settings_extraFooter"]="Thêm nội dung PHẦN ĐUÔI";
// Changed in version 4.1.0. Old text:
//$lll["settings_extraFooter_expl"]="With this, you can insert custom HTML right before the closing BODY tag of the pages.<br><br>This feature is not available in the Free version of the program!";
// New text:
$lll["settings_extraFooter_expl"]="With this, you can insert custom HTML right before the closing BODY tag of the pages.<br><br>This feature is not available in the Lite version of the program!";
$lll["securityProperties"]="Cài đặt bảo mật";
$lll["settings_applyCaptcha"]="Hệ thống (CAPTCHA) trong các hình thức";
$lll["settings_applyCaptcha_".Settings_response]="'Trả lời rao vặt' and 'Email cho bạn bè'";
$lll["settings_applyCaptcha_".Settings_login]="Hình thức Đăng nhập ";
$lll["settings_applyCaptcha_".Settings_register]="Hình thức Đăng ký";
$lll["settings_applyCaptcha_".Settings_submitAd]="Đệ trình rao vặt";
$lll["settings_joomlaLink"]="Mạng Joomla";
$lll["settings_joomlaLink_expl"]="Nếu bạn cài đặt Joomla bridge, bạn có thể viết URL cho trang mạng chính của Joomla ở đây. Nếu làm như thế, đăng nhập sẽ chứa đựng ở 'trang chính' trong nối kết đến URL.";
$lll["enableUserSearch"]="Cho phép thành viên tìm kiếm";
$lll["enableUserSearch_expl"]="Chức năng này không có trong phiên bản thử nghiệm!";
$lll["appsettings_modify_completed"]="Cài đặt đã được sửa đổi thành công.";
$lll["settings_langDir"]="Phương lối ngôn ngữ";
$lll["settings_langDir_expl"]="Nếu bạn cho phép nhiều ngôn ngữ - với hướng từ trái qua phải và từ phải qua trái, Bạn nên chọn hướng ngôn ngữ củ chính nó. Nếu bạn có tập tin tiếng Árập, bạn viết xuống như thế này để cho phép chèn lên trong trường hợp cài đặt tiếng ẢRập:<br><br>\$langDir='rtl';<br><br>Use 'rtl' cho 'phải qua trái' và 'ltr' cho 'trái qua phải'!";
$lll["settings_langDir_ltr"]="Trái qua phải";
$lll["settings_langDir_rtl"]="Phải qua trái";

// Custom Fields
$lll["customfield"]="Đặt Nhóm";
$lll["customfield_fixInfoText"]="Đây là nhóm \"fix\" nghĩa là bạn có thể xóa bõ đi, và bạn có thể thay đổi sở hữu của chúng.";
$lll["mustBeCommaSeparated"]="Sự lựa chọn giá trị của các nhóm phải được tách biệt strings ra bằng dấu phẩy.";
$lll["invalidDefaultValue"]="Sự lựa chọn giá trị chính của các nhóm phải được tách biệt strings ra bằng dấu phẩy, liệt kê trong giá trị của nhóm.";
$lll["descriptionDefaultLabel"]=$lll["description"]="Mô tả";
$lll["privateField"]="Riêng tư";
$lll["customfield_type"."_".customfield_text]="Chữ";
$lll["customfield_type"."_".customfield_textarea]="Theo Chữ";
$lll["customfield_type"."_".customfield_bool]="Boolean";
$lll["customfield_type"."_".customfield_selection]="Chọn";
$lll["customfield_type"."_".customfield_multipleselection]="Chọn Lựa";
$lll["customfield_type"."_".customfield_separator]="Ngăn cách";
$lll["customfield_type"."_".customfield_checkbox]="đặt dấu";
$lll["customfield_type"."_".customfield_picture]="ảnh";
$lll["customfield_type"."_".customfield_media]="Bộ Truyền Thông";
$lll["customfield_type"."_".customfield_url]="Mạng nối";
$lll["customfield_type"."_".customfield_date]="Ngày";
$lll["customfield_dateDefaultNow"]="Ngày  mặc định là ngày hiện tại";
$lll["customfield_fromyear"]="Từ Năm";
$lll["customfield_fromyear_expl"]="Phạm vi ngày chọn lựa trong vùng, nhóm này sẽ đi từ trong năm nay. 
                                   Bạn có ghi một năm thực tế như '1971 ', hoặc bạn có ghi 'ngay bây giờ' đứng cho năm hiện tại.
                                   Bạn cũng có thể sử dụng một năm tương đối: 'bây giờ-5' có nghĩa là phạm vi sẽ bắt đầu từ cách đây 5 năm!";
$lll["customfield_toyear"]="Tới năm";
$lll["customfield_toyear_expl"]="Phạm vi ngày chọn lựa trong vùng, nhóm này sẽ đi từ trong năm nay. 
                                   Bạn có ghi một năm thực tế như '2010', hoặc bạn có ghi 'ngay bây giờ' đứng cho năm hiện tại.
                                   Bạn cũng có thể sử dụng một năm tương đối: 'bây giờ-5' có nghĩa là phạm vi sẽ kết thúc trong 5 năm kể từ bây giờ!!";
$lll["customfield_name"]="Tên";
$lll["selectUserField"]="--Chọn Nhóm Thành Viên--";
$lll["customfield_userField"]="hay là chọn một nhóm thành viên";
$lll["customfield_userField_expl"]="Thay vì tạo ra một nhóm tùy chỉnh hoàn toàn mới, bằng cách ghi tên cho nó ở trên, bạn có thể chọn một trong những nhóm được trung bày. Bằng cách này, các nhóm người sở hữu của quảng cáo họ có thể được trưng bày trực tiếp trong danh sách, hoặc rao vặt hay rao vặt chi tiết. <br><br> w.w... bạn có thể điền số điện thoại của người sở hữu của các rao vặt đến trang rao vặt chi tiết. Hoặc nếu bạn có một tùy ý chỉnh 'Zip code' nhóm thành viên, bạn cũng có thể trình bày nó.  Hơn nữa, nếu bạn ghi rõ Mã bưu điện nhu là công cụ 'tìm kiếm', các thành viên sẽ có thể tìm kiếm cho các rao vặt của mã vùng!";
$lll["userField"]="Nhóm thành viên";
$lll["customfield_type"]="Loại";
$lll["customfield_default_bool"]=
$lll["customfield_default_text"]=
$lll["customfield_default_multiple"]="Giá trị mặc định";
$lll["customfield_default_multiple_expl"]="Điều này phải được tách biệt bằng dấu phẩy một danh sách có thể có giá trị, vi dụ như một, hai, ba...";
$lll["customfield_active"]="Hoạt động";
$lll["customfield_separator"]="Cột %s";
$lll["customfield_mandatory"]="Bắt buộc";
$lll["customfield_checkboxCols"]="Số lượng các cột để xuật hiện trong các hộp kiểm tra";
$lll["customfield_showInList"]="Danh sách trưng bày cho";
$lll["customfield_values"]="giá trị Có thể có";
$lll["customfield_values_expl"]="Điều này phải được tách biệt bằng dấu phẩy một danh sách có thể có giá trị, vi dụ như một, hai, ba...";
$lll["customfield_innewline"]="Đặt trong dòng mới";
$lll["customfield_displayLabel"]="Nhãn trưng bày";
$lll["customfield_displayLabel_expl"]="Nếu kiểm tra hết, các nhãn hiệu nhóm sẽ không được trung bày trên trang rao vặt chi tiết, và các nhóm có giá trị sẽ xóa đi nhãn của các nhóm rao vặt khác.";
$lll["userfield_displayLabel_expl"]="Nếu kiểm tra hết, các nhãn hiệu nhóm sẽ không được trung bày trên trang thành viên chi tiết, và các nhóm có giá trị sẽ xóa đi nhãn của các nhóm thành viên khác.";
$lll["customfield_displaylength"]="Độ dài danh sách trung bày";
$lll["customfield_displaylength"."_expl"]="Số lượng tối đa các chữ được trung bày trên danh sách của trang rao vặt. Sự trung bày của các danh sách cho thấy có thể được bảo vệ chống lại sự trung bày nhóm quá dài trong bộ nhóm.";
$lll["userfield_displaylength"."_expl"]="Số lượng tối đa các chữ được trung bày trên danh sách của trang thành viên. Sự trung bày của các danh sách cho thấy có thể được bảo vệ chống lại sự trung bày nhóm quá dài trong bộ nhóm.";
$lll["customfield_searchable"]="trung bày trong hình thức tìm kiếm cho";
$lll["customfield_rangeSearch"]="Phạm vi cho phép tìm kiếm";
$lll["customfield_rangeSearch_expl"]="Nếu điều này được kiểm tra hơn một có thể xác định v.v... '10-20'như là một điều kiện tìm kiếm đển các rao vặt của nhóm này có giá trị là từ 10 đến 20. Hoặc có thể ghi một loạt các ngày trong trường hợp nhóm Ngày.";
$lll["userfield_rangeSearch_expl"]="Nếu điều này được kiểm tra hơn một có thể xác định v.v... '10-20'như là một điều kiện tìm kiếm đển các thành viên của nhóm này có giá trị là từ 10 đến 20.";
$lll["customfield_allowHtml"]="Cho phép HTML";
$lll["customfield_allowHtml_expl"]="Đây chỉ cho phép 'an toàn' HTML từ khóa tags, tuy nhiên! Một số từ khóa tag có thể gây hại nguy cơ cho hệ thống bảo mật, hoặc phá huỷ cách bố trí trang mạng.";
$lll["customfield_private"]="Cho phép giữ riêng tư";
$lll["customfield_subType"]="Đối xử nhóm này như";
$lll["customfield_subType_expl"]="Nếu bạn có một nhóm 'Giá', cách tốt nhất để cài nó như là một 'số tiếp', cho nên phân loại của các cột Giá và phạm vi tìm kiếm theo mức giá đang hoạt động. Sau đó bạn có thể nhập các biểu tượng tiền tệ tiền tố cần thiết, chính xác và hàng ngàn cài đặt phân chia  dưới dạng 'Định dạng trưng bày'.";
$lll["userfield_subType_expl"]="";
$lll["customfield_subType_".customfield_alnum]="Chữ";
$lll["customfield_subType_".customfield_integer]="Số nguyên";
$lll["customfield_subType_".customfield_float]="Số tiếp";
$lll["customfield_sortable"]="Cho phép phân loại của nhóm này";
$lll["customfield_expl"]="Giải thích văn bản";
$lll["customfield_expl"."_expl"]="Trợ giúp văn bản như chỉ là một thành viên đang đọc! Mô tả chi tiết hơn một hình thức của nhóm.";
$lll["private_field"]="(private)";
$lll["itemfield_ttitle"]="Điều chỉnh thể loại của nhóm '%s'";
$lll["itemfield_ttitle_global"]="Điều chỉnh nhóm chung";
$lll["customfield_newitem"]="Thêm điều chỉnh nhóm mới";
$lll["customfield_modify_form"]="Đỏi điều chỉnh nhóm";
$lll["customfield_create_form"]="Tạo điều chỉnh nhóm";
$lll["customfield_sortId"]="Phân loại";
$lll["customfield_sorthelp"]="Sử dụng biểu tượng mũi tên 'Sắp xếp' cột phân loại lại danh sách, sau đó bấm vào 'Lưu các phân loại' nút ở phía dưới!";
$lll["customfield_savesorting"]="Lưu các phân loại";
$lll["customfield_advanced_form"]="Bộ Đầu Não";
$lll["customfield_sortingsaved"]="Phân loại điều chỉnh nhóm mới đã được lưu thành công.";
$lll["customFields"]="Danh sách điều chỉnh nhóm";
$lll["customfield_rowspan"]="Hàng Spans";
$lll["customfield_seo"]=$lll["seoProperties"];
$lll["customfield_seo_0"]="Không chuyển";
$lll["customfield_seo_".customfield_title]="Sử dụng nhóm này như là ĐẦU ĐỀ của chi tiết trang.";
$lll["customfield_seo_".customfield_description]="Sử dụng nhóm này như là MÔ TẢ của chi tiết trang.";
$lll["customfield_seo_".customfield_keywords]="Sử dụng nhóm này như là TỪ KHÓA của chi tiết trang.";
$lll["customfield_mainPicture"]="Sử dụng nhóm này như là hình chính";
$lll["customfield_mainPicture_expl"]="Sử dụng ảnh này trong danh sách vô thể loại thuộc nguồn cấp dữ liệu RSS.";
$lll["userfield_mainPicture_expl"]=" ";
$lll["customfield_seo_expl"]="Bạn có thể điều ở đây các điều chỉnh mục của nhóm sẽ phục vụ như là nội dung của tag HTML ĐẦU ĐỀ, MÔ TẢ TỪ KHÓA tag tương ứng nhau. Bên cạnh đó SEO, nội dung của ĐẦU ĐỀ nhóm sẽ xuất hiện trên đầu đề của trình duyệt một khi rao vặt trưng bày, nó sẽ được sử dụng như đầu đề của rao vặt trong mục rao vặt không cùng thể loại ở danh sách nguồn cấp dữ liệu RSS.";
$lll["userfield_seo_expl"]="Bạn có thể điều ở đây các điều chỉnh mục của thành viên sẽ phục vụ như là nội dung của tag HTML ĐẦU ĐỀ, MÔ TẢ TỪ KHÓA tag tương ứng nhau."; 
$lll["customfield_innewline_expl"]="Thay vì tạo thành một cột mới, cài đặt này làm cho các điều chỉnh nhóm làm điều chỉnh các giá trị mục xuất hiện trong một dòng mới, sẽ thay đồi hết tất cả các cột khác theo chiều ngang và được đặt chúng dưới đây.";
$lll["customfield_rowspan_expl"]="Sử dụng này cùng với những lối 'Đặt trong dòng mới' ở bộ phận điều chỉnh nhóm. Nếu có những nhóm khác đã được đặt một trong dòng mới, bạn có thể cài đặt này nhóm này thay hết trên những tuyến đường mới theo chiều dọc.";
$lll["customfield_detailsPosition"]="Vị trí";
$lll["customfield_detailsPosition_expl"]="Các vị trí của nhóm rao vặt trên trang chi tiết, The 'sidebar' khu vực chi tiết bên tay phải nơi hình ảnh được đổi dạng (nơi kiểu hiện đại). Bạn có thể đặt các nhóm trên khu vực hình ảnh, hoặc dưới chúng với cách cài đặt này.";
$lll["userfield_detailsPosition_expl"]="Các vị trí của nhóm thành viên trên trang chi tiết, The 'sidebar' khu vực chi tiết bên tay phải nơi hình ảnh được đổi dạng (nơi kiểu hiện đại). Bạn có thể đặt các nhóm trên khu vực hình ảnh, hoặc dưới chúng với cách cài đặt này.";
$lll["customfield_detailsPosition_".customfield_normal]="Thường";
$lll["customfield_detailsPosition_".customfield_topright]="Phia trên của sidebar";
$lll["customfield_detailsPosition_".customfield_bottomright]="Phia trên của sidebar";
$lll["formProperties"]="Hình thức cài đặt";
$lll["listProperties"]="Danh sách cài đặt";
$lll["detailsProperties"]="Trang chi tiêt cài đặt";
$lll["searchProperties"]="Tìm cài đặt";
$lll["miscProperties"]="Tồng cài đặt";
$lll["customfield_showInForm"]="hình thức xuất hiện cho";
$lll["userfield_showInForm_expl"]="Lưu ý rằng trong trường hợp nhóm thành viên sửa chữa, cài đặt này có một giới hạn! Nếu bạn cài đặt nhóm 'Tên' được trưng bày cho Ban Quản Lý dùng thôi hay sửa đổi hình thức (tức là bạn không thể dấu 'Tên'nhóm khi đăng ký hay đăng nhập). Tương tự như vậy, bạn không thể dấu nhóm 'Email' ờ mẫu đăng ký.";
$lll["customfield_showInDetails"]="Trưng bày cho";
$lll["searchable_".customfield_forNone]=$lll["enableUserSearch_".customfield_forNone]=$lll["showInForm_".customfield_forNone]=$lll["showInList_".customfield_forNone]=$lll["showInDetails_".customfield_forNone]=$lll["enableFavorities_".customfield_forNone]=$lll["subscriptionType_".customfield_forNone]="không";
$lll["customlist_displayedFor_".customfield_forAll]=$lll["searchable_".customfield_forAll]=$lll["enableUserSearch_".customfield_forAll]=$lll["showInForm_".customfield_forAll]=$lll["showInList_".customfield_forAll]=$lll["showInDetails_".customfield_forAll]=$lll["enableFavorities_".customfield_forAll]=$lll["subscriptionType_".customfield_forAll]="tất cả";
$lll["customlist_displayedFor_".customfield_forLoggedin]=$lll["searchable_".customfield_forLoggedin]=$lll["enableUserSearch_".customfield_forLoggedin]=$lll["showInForm_".customfield_forLoggedin]=$lll["showInList_".customfield_forLoggedin]=$lll["showInDetails_".customfield_forLoggedin]=$lll["subscriptionType_".customfield_forLoggedin]=$lll["enableFavorities_".customfield_forLoggedin]="Chỉ cho thành viên đăng nhập";
$lll["showInForm_".customfield_forOwner]=$lll["showInList_".customfield_forOwner]=$lll["showInDetails_".customfield_forOwner]="Chỉ cho chủ rao vặt";
$lll["customlist_displayedFor_".customfield_forAdmin]=$lll["searchable_".customfield_forAdmin]=$lll["enableUserSearch_".customfield_forAdmin]=$lll["showInForm_".customfield_forAdmin]=$lll["showInList_".customfield_forAdmin]=$lll["showInDetails_".customfield_forAdmin]=$lll["subscriptionType_".customfield_forAdmin]=$lll["enableFavorities_".customfield_forAdmin]="Chỉ cho Ban Quản Lý";
$lll["enableFavorities_".customfield_forAllButAdmin]=$lll["subscriptionType_".customfield_forAllButAdmin]="Tất cả nhưng ngoài Ban Quản Lý";
$lll["formatSection"]="Trưng bày định dạng";
$lll["customfield_formatPrefix"]="Tiền tố";
$lll["customfield_formatPrefix_expl"]="Một ví dụ điển hình biểu tượng tiền tệ hoặc dấu phần trăm. Bất cứ khi bạn ghi vào đây sẽ tiên các giá trị của các nhóm điều chỉnh này.";
$lll["customfield_formatPostfix"]="Hậu tố";
$lll["customfield_formatPostfix_expl"]="Bạn có thể thêm vào những con số đơn vị ở đây. Bất cứ thứ gì bạn ghi vào đây sẽ thực hiện theo các giá trị của nhóm điều chỉnh này.";
$lll["customfield_precision"]="Chính xác";
$lll["customfield_precision_expl"]="Điểm chính xác thứ tự - cài đặt bộ số thập điểm.";
$lll["customfield_precisionSeparator"]="Phân chia chính xác";
$lll["customfield_precisionSeparator_expl"]="Cài phân chia cho bộ số thập điểm.";
$lll["customfield_thousandsSeparator"]="Phân chia phần ngàn";
$lll["customfield_format"]="Trưng bày định dạng";
$lll["customfield_format_expl"]="Thành viên nâng cao cũng có thể áp dụng dạng chuổi C-sprintf.";
$lll["customfield_useMarkitup"]="Sử dụng nhập HTML đơn giản, thay vì textarea đơn giản";
$lll["customfield_isCommon"]="Phạm vi nhóm";
$lll["customfield_isCommon_colhead"]="Phạm vi";
$lll["common"]="Thông thường";
$lll["unique"]="Độc đáo";
$lll["customfield_isCommon_expl"]="Nếu bạn cài đặt phạm vi để phổ biến, các nhóm sẽ tồn tại trong mỗi mục. Ví dụ: nếu bạn có một trang web bán hàng, bất cứ chuyên mục bạn thiết lập, một nhóm 'Giá' phải thuộc về tất cả thuộc về chúng, vì thế 'Giá' là cách tốt nhất để xác định nhóm phổ biến. Nếu bạn tạo một nhóm phổ biến, hoặc thay đổi một nhóm phổ biến duy nhất, nó sẽ xuất hiện trong tất cả các nhóm - không chỉ là nơi bạn có tạo ra nó. Nếu bạn xóa nhóm phổ biến, nó sẽ biến mất tất cả các mục cùng một lúc. <br> <br> Thậm chí nếu nhóm được phổ biến, nó có thể khác nhau trong thiết lập của các mục. E.g. bạn có thể đặt nó để xuất hiện trên chi tiết trên trang rao vặt trong cùng một mục, nhưng nó ẩn nấu trong mục khác. Chỉ có 'Tên' và 'Loại phải được bằng như trong tất cả các mục. <br><br> Bạn thậm chí có thể thiết lập các chương trình Classifieds để cho tất cả các nhón được phổ biến! Trong một số trường hợp, nó có lý, nếu bạn có xe ô tô và chỉ có các xe ô tô trong mỗi nhóm, có lẽ tất cả các mục có cùng một danh sách điều chỉnh nhóm. điễm mạnh của các nhóm phổ biến sẽ trưng bày xác định tại danh sách điều chỉnh rao vặt! v.v... Những danh sách rao vặt 'Mới Nhất'có chứa danh sách các rao vặt từ nhiều mục khác nhau, nhưng nếu bạn có chung nhóm, bạn cần giới hạn trưng bày các cột 'Đầu đề','Mô tả', và 'Chuyên mục' trong bất kỳ danh sách chi tiết -bạn có thể chọn bất kỳ nhóm phổ biến được nằm trong cột danh sách!";
$lll["customfield_isCommon_0"]="Duy nhất cho mục này";
$lll["customfield_isCommon_1"]="Phổ biến đến tất cả các mục";
$lll["itemfield_create_completed"]=$lll["userfield_create_completed"]="Nhóm điều chỉnh đã được tạo thành công.";
$lll["itemfield_columnIndex"]="Cột index";
// Custom fields of users:
$lll["userfield_ttitle"]="Nhóm điều chỉnh của thành viên";
$lll["userfield_type"."_expl"] = "";

// Notifications:
$lll["notification"]="Thông báo";
$lll["Notifications"]=$lll["notification_ttitle"]="Thông báo";
$lll["NotificationsDescription"]="Quản lý các danh sách các thông báo ở đây - Hệ thống Email sẽ tự động gửi đi theo hành động.";
$lll["notification_subject"]="Chủ đề Email";
$lll["notification_body"]="Thân bài Email";
$lll["notification_variables"]="Cho phép các biến";
$lll["notification_active"]="Hoạt động";
$lll["notification_modify_form"]="Sửa thông báo";
$lll["notif_remindpass_tit"]="Chứa mật mã mới nếu thành viên đã quên mật mã cũ.";
$lll["notif_remindpass_subj"]="Mật mã mới";
$lll["notif_initpass_tit"]="Mật mã tự nhiên gởi tới thành viên mới sau khi đăng ký.";
$lll["notif_initpass_subj"]="Mật mã tự nhiên";
$lll["notification_cc"]="CC";
$lll["notification_cc_expl"]="Thông báo email sẽ gởi đi như bản sao carbon.";
$lll["notification_active_expl"]="Bạn có thể bật và tắt thư gửi thông báo ở đây.";
//Category:
$lll["category_expirationEnabled"]="Kích hoạt hết hạn";
$lll["category_expirationOverride"]="Cho phép gia hạn cho";
$lll["category_allowSubmitAdAdmin"]="Chỉ có Ban Quản lý đệ trình rao vặt trong mục này.";
$lll["category_expirationOverride_expl"]="Nếu bạn kích hoạt tính năng này, 'Số ngày trước khi rao vặt hết hạn' sẽ xuất hiện trong nhóm rao vặt vừa tạo ra/ sửa đổi hình thức hết hạn sẽ xuất hiện ở trang tạo hay sử rao vặt. Nếu bạn chỉ định'0' trong nhóm nói trên, chúng có thể nhập được số độc đoán. Nếu bạn chỉ định số lớn hơn null, thì nó sẽ phục vụ như là mặc định, và trong một nhóm nhu số tối đa của ngày được chủ sở hữu có ghi nhập.";
$lll["category_expirationOverride_".customfield_forNone]="Không";
$lll["category_expirationOverride_".customfield_forLoggedin]="Tất cả thành viên";
$lll["category_expirationOverride_".customfield_forAdmin]="Ban Quản Lý dùng";
$lll["category_organize"]="Xắp xếp Mục";
$lll["category_restartExpOnModify"]="Sửa đổi Khởi động gia hạn";
$lll["category_restartExpOnModify_expl"]="Sử dụng này như là một thay thế của gia hạn rao vặt. Nếu được kiểm tra và chủ sở hữu sửa đổi rao vặt của mình (và được Ban Quảng Lý chấp thuận, nếu nó được kích hoạt), rao vặt sẽ bắt đầu gia hạn lại.";
$lll["category_showDescription"]="Mô tả trưng bày";
$lll["category_showDescription_expl"]="Có trường hợp bạn không muốn trưng bày nội dung của mục, nhưng vẫn muốn rằng phần MÔ TẢ meta từ khóa của các nhóm trên trang mạng được phổ biến.";
$lll["category_inactivateOnModify"]="Inactivate on modify";
$lll["category_inactivateOnModify_expl"]="Cho dù rao vặt được phê duyệt thì vẫ chờ chấp nhận lại, nếu thành viên thêm bớt rao vặt của mình.";
$lll["methods"]="Phương pháp";
$lll["clone"]="chép";
$lll["exp"]="Gia hạn";
$lll["useDragAndDrop"]="Dùng phương pháp kéo và thả để duy chuyển mục sau đó bấm vào 'Lưu trữ sắp xếp'!";
$lll["organizeSaveButton"]="Lưu trữ sắp xếp";
$lll["organizeSaveMessage"]="Xắp xếp mục luư trữ thành công";
$lll["organizeSaveError"]="Không thể gửi dữ liệu đến máy chủ.";
$lll["organizeLoadError"]="Không thể tải dữ liệu từ máy chủ.";
$lll["copyOfCategory"]="Sao chép của '%s'";
$lll["organizeNextPageDrop"]="Đưa con chuột ở đây khi kéo và đặt vào chỗ các mục trong các trang tiếp theo.";
$lll["organizePreviousPageDrop"]="Đưa con chuột ở đây khi kéo và đặt vào chỗ các mục trong các trang trước.";
$lll["organizeNextItems"]="Mục tiếp &raquo;";
$lll["organizePreviousItems"]="&laquo; mục trước";
// Fieldset:
// Changed in version 4.1.0. Old text:
//$lll["fieldset_create_form"]="Advanced operations on the whole list of custom fields of the category (they don't work in the free version!)";
// New text:
$lll["fieldset_create_form"]="Advanced operations on the whole list of custom fields of the category (they don't work in the Lite version!)";
$lll["fieldset_deleteAll"]="Xóa hết các nhóm";
$lll["fieldset_deleteAll_expl"]="Điều này sẽ xóa tất cả các mục duy nhất của điều chỉnh nhóm cùng một lúc.<br><br>Xin lưu ý: xóa bỏ điều chỉnh nhóm, nó sẽ gây nguyên nhân xóa hết dữ liệu, bởi vì các lĩnh vực rao vặt tương ứng giá trị cũng sẽ bị xóa bỏ luôn!";
$lll["fieldset_cloneToSubcats"]="Chép vào các tiểu mục";
$lll["fieldset_cloneToSubcats_expl"]="Danh sách điều chỉnh nhóm sẽ được áp dụng trong tất cả các tiểu mục của thể loại này.<br><br>Xin lưu ý rằng: nếu các tiểu mục đã có điều chỉnh nhóm, chúng sẽ bị xóa đầu tiên! Như vậy, hoạt động này chủ yếu hữu ích cho việc thiết lập các mục mới, bởi vì nó có thể gây ra việc mất dữ liệu trong mục mà đã có rao vặt.";
$lll["fieldset_cloneToCats"]="Chép vào các mục";
$lll["fieldset_cloneToCats_expl"]="Danh sách các điều chỉnh nhóm sẽ được áp dụng trong mọi thể loại mà bạn chọn ở bên phải. (bạn có thể chọn nhiều hơn!).<br><br>Xin lưu ý rằng: nếu các tiểu mục đã có điều chỉnh nhóm, chúng sẽ bị xóa đầu tiên! Như vậy, hoạt động này chủ yếu hữu ích cho việc thiết lập các mục mới, bởi vì nó có thể gây ra việc mất dữ liệu trong mục mà đã có rao vặt.";
$lll["fieldset_cloneFromCat"]="Chép từ các mục";
$lll["fieldset_cloneFromCat_expl"]="Đây là ngược lại với hoạt động trước: nó sẽ thay thế tất cả các điều chỉnh nhóm của mục này với các danh sách nhóm của một thể loại khác. Điều này cũng được áp dụng với trang này: nó có thể gây ra mất dữ liệu nếu mục rao vặt này đã được đăng!<br><br>Để cho rõ ràng: không một hoạt động chép nào thực sự sao chép các rao vặt hoặc các giá trị rao vặt! Và cũng không sao chép các mục! Chúng sao chép danh sách điều chỉnh nhóm với tất cả các lĩnh vực thuộc về chúng. Chuyền dời các rao vặt từ một này đến mục khác trong có thể với phương pháp 'di chuyển' đơn giản cho mỗi rao vặt. Nếu bạn muốn sao chép của toàn bộ danh mục (với tất cả các điều chỉnh nhóm, nhưng mà không có rao vặt và tiểu mục của chúng!), Bạn có thể sử dụng phương pháp 'chép' ở nút 'Xắp xếp mục'.";
$lll["fieldset_deleteAll_successful"]="Điều chỉnh nhóm đã xóa thành công!";
$lll["fieldset_cloneToSubcats_successful"]="Điều chỉnh nhóm chép thành công đến các tiểu mục";
$lll["fieldset_cloneToCats_successful"]="Điều chỉnh nhóm chép thành công đến các mục";
$lll["fieldset_cloneFromCat_successful"]="Điều chỉnh nhóm của mục được chọn vừa chép thành công!";
$lll["fields"]="nhóm";
// ControlPanel:
$lll["controlPanel"]="Bảng điều khiển";
$lll["controlpanel_ttitle"]="";
// Custom lists:
$lll["customlist_ttitle"]="Danh sách điểu chỉnh";
$lll["customlist"]="Danh sách điểu chỉnh";
$lll["customlist_listTitle"]="Đầu đề";
$lll["customlist_listDescription"]="Mô tả";
$lll["customlist_listDescription_expl"]="Một số lưu ý rằng có thể diễn tả về danh sách điều chỉnh như thế nào. Chỉ có Ban Quản Lý nhìn thấy.";
$lll["customlist_create_form"]="Tạo danh sách điều chỉnh";
$lll["customlist_modify_form"]="sửa danh sách điều chỉnh";
$lll["customlist_newitem"]="Thêm danh sách điều chỉnh";
$lll["checkCustomLists"]="Bất cứ khi nào bạn xóa một nhóm điều chỉnh, kiểm tra tất cả các danh sách điều chỉnh, một khi công cụ tìm kiếm nhấp vào 'Đầu đề' của chúng, bởi vì chúng trở nên không hợp lệ, nếu chúng chỉ muốn xòa nhóm điều chỉnh theo điều kiện của chúng!";
$lll["listDisplayProperties"]="Nơi trưng bày danh sách";
$lll["customlist_primarySort"]="Xắp xếp thứ nhất bởi";
$lll["customlist_primaryDir"]="Xắp xếp thứ nhất theo";
$lll["customlist_primaryDir_DESC"]=$lll["customlist_secondaryDir_DESC"]="Xuống";
$lll["customlist_primaryDir_ASC"]=$lll["customlist_secondaryDir_ASC"]="Lên";
$lll["customlist_primaryPersistent"]="Xắp xếp thứ nhất chắc chắn";
$lll["customlist_primaryPersistent_expl"]="Nếu bạn không bỏ dấu, thành viên có thể ghi đè lên sự xắp xếp của danh sách bằng cách nhấp vào biểu tượng phân loại trong danh sách các cột đầu đề. Nếu bạn đánh dấu vào, tuy nhiên, bạn có thể buộc các rao vặt xuất hiện trên đầu đề danh sách, tuy nhiên những thành viên được sắp xếp trong danh sách.<br><br> Chẳng hạn, nếu bạn có một nhóm điều chỉnh được gọi là 'tài trợ cấp' theo các giá trị mức độ cho, ví dụ như phân theo loại 'vàng', 'Bạc', 'Đồng' và 'Không', bạn có thể tạo một danh sách với phân loại của độ 'tài trợ cấp'. Phân loại 'vàng' thì cao nhất, chúng sẽ luôn luôn xuất hiện trên đầu, dưới và ngay chổ không cho rao vặt của danh sách.";
$lll["customlist_secondarySort"]="Xắp xếp thứ nhì bởi";
$lll["customlist_secondaryDir"]="Xắp xếp thứ nhì theo";
$lll["customlist_secondaryPersistent"]="Xắp xếp thứ nhì chắc chắn";
$lll["customlist_limit"]="Giới hạn";
$lll["customlist_limit_expl"]="Bạn có thể giới hạn số lượng rao vặt trong danh sách. Để ltrống cho không giới hạn. E.g. số 10 Có nghĩa là, danh sách chỉ trưng bày 10 trong danh sách, chúng được phân loại theo sự cho phép trưng bày.  Trong trường hợp xuất hiên trên rao vặt chạy, nên cho số cànng nhỏ càng tốt để rao vặt chạy xuật hiện nhanh hơn khi liên thông với máy chủ!";
$lll["customlist_columns"]="Chọn cột cho trưng bày";
$lll["customlist_columns_expl"]="Nếu chọn hơn một, bạn có thể xắp xếp lại bằng phương pháp kéo-và-bỏ! Các cột sẽ trưng bày theo thứ tự chỉ định ở đây. <br> <br> Vì vậy,một cột mà thực sự trưng bày trong một danh sách, lưu ý rằng nó không đủ đề bạn thêm nó vào đây! Những thành viên cho trưng bày danh sách phải được cho phép cột xuất hiện!
The visibility of a column can be set from two places depending on the scope of the given field:<br><br>
1. Nếu bạn muốn cài đặt, tầm nhìn của một cột đó là không nằm trong danh sách. Cụ thể, bạn có thể làm điều đó ở liên kết danh sách 'điều chỉnh nhóm chung (mơ sửa đổi trong liên kết 'danh sách để cho thấy'),<br><br>
2. Nếu bạn muốn cài đặt, tầm nhìn của một cột đó là nằm trong danh sách. Cụ thể, bạn có thể làm điều đó ở liên kết danh sách 'danh sách of điều chỉnh nhóm of mục này' (sửa đổi hình thức mở và chỉnh sửa 'Hiển thị trong danh sách cho' bất động sản).";
$lll["customlist_displayedFor"]="Trưng bày danh sách cho";
$lll["customlist_displayedFor_expl"]="Dù bạn chọn ở đây, Ban Quản Lý sẽ luôn luôn xem thấy danh sách bằng cách nhấp vào Đầu đề trong mục ờ 'Danh sách các điều chỉnh danh sách'!";
$lll["customlist_pages"]="Trưng bày những trang này";
// Changed in version 4.1.0. Old text:
//$lll["customlist_pages_expl"]="You can specify a page with its link. E.g. '/item/1' is the details page of ad with ID 1. Use '/' to denote the start page. You can list more pages - one in every line. You can use the '*' wildcard to match more than one pages - e.g.: '/list/*' means all the category listing pages, '/item/*' means all the ad details pages. You can exclude pages by adding the '!' prefix. A more complex example: <br><br>/user/login_form<br>/item/create_form<br>/list/*<br>!/list/1<br>!/list/2<br>/item/4<br>/item/5<br><br>The above says \"display the list on the login page, on the ad submit page, on every category listing pages except of the category with ID 1 and 2, and on the details pages of ads with ID 4 and 5!\"<br><br>This feature doesn't work in the free version!";
// New text:
$lll["customlist_pages_expl"]="You can specify a page with its link. E.g. '/item/1' is the details page of ad with ID 1. Use '/' to denote the start page. You can list more pages - one in every line. You can use the '*' wildcard to match more than one pages - e.g.: '/list/*' means all the category listing pages, '/item/*' means all the ad details pages. You can exclude pages by adding the '!' prefix. A more complex example: <br><br>/user/login_form<br>/item/create_form<br>/list/*<br>!/list/1<br>!/list/2<br>/item/4<br>/item/5<br><br>The above says \"display the list on the login page, on the ad submit page, on every category listing pages except of the category with ID 1 and 2, and on the details pages of ads with ID 4 and 5!\"<br><br>This feature does not work in the Lite version!";
$lll["customlist_categorySpecific"]="Nội dung phụ thuộc vào hiện tại";
$lll["customlist_categorySpecific_expl"]="Nếu bạn kiểm tra và các điều chỉnh danh đựoc trình bày sách trang ở trong \"thể loại bối cảnh\" (ví dụ, trên danh sách điều chỉnh hay các trang chi tiết), các danh sách điều chỉnh sẽ chỉ bao gồm các rao vặt củ mục đặt ra.<br><br> Điều này rất hữu ích, nếu bạn có một danh sách điều chỉnh gọi là 'danh sách đặc trưng' và bạn muốn tạo danh sách này được trong bối cảnh nhạy cảm - vì vậy mà khi thành viên đặt dưới mục 'xe Ô tô', nó sẽ trưng bày rao vặt  đặc trưng cho 'xe ô tô', và khi thành viên đặt dưới mục'Hẹn hò', nó sẽ chứa các rao vặt đặc trưng cho 'hẹn hò'";
$lll["customlist_recursive"]="và bao gồm các rao vặt từ các mục hiện tại và toàn bộ tiều mục";
$lll["customlist_listStyle"]="Danh sách phong cách";
$lll["customlist_listStyle_".customlist_normal]="Danh sách thường";
$lll["customlist_listStyle_".customlist_scrollable]="Chạy Cuộn";
$lll["customlist_listStyle_expl"]="Để xem 'Chạy Cuộn' rao vặt như thế nào, xem thử nghiệm ờ đây: http://noahsclassifieds.org/v8rss/";
$lll["customlist_positionNormal"]=$lll["customlist_positionScrollable"]="Vị trí";
$lll["customlist_positionNormal_expl"]=$lll["customlist_positionScrollable_expl"]="Nơi xuất hiện danh sách trên trang mạng";
$lll["customlist_positionNormal_".customlist_aboveContent]=$lll["customlist_positionScrollable_".customlist_aboveContent]="Ở trên các nội dung";
$lll["customlist_positionNormal_".customlist_belowContent]=$lll["customlist_positionScrollable_".customlist_belowContent]="Ở dưới các nội dung";
$lll["customlist_positionScrollable_".customlist_left]="Ở phía bên trái của trang mạng";
$lll["customlist_positionScrollable_".customlist_right]="Ở phía bên phải của trang mạng";
$lll["customlist_positionScrollable_".customlist_top]="Ở phía bên đầu của trang mạng";
$lll["customlist_positionScrollable_".customlist_bottom]="Ở phía bên dướ của trang mạng";
$lll["customlist_displayInMenu"]="Chỉ định trình đơn trong trình đơn";
$lll["customlist_displayInMenu_expl"]="Nếu bạn không muốn danh sách được trưng bày trên một số trang mạng hiện tại, bạn có thể chỉ định một trình đơn vào nó, để cho thành viên truy cập vào các danh sách riêng trên các trang mạng. Ví dụ: thể hiện trên trang 'rao vặt mới nhất', 'rao vặt Phổ biến', 'Chờ chấp thuận' và 'chấp thuận rao vặt' trình đơn điểm là từ bây giờ sẽ liên kết chúng vào danh sách điều chỉnh!";
$lll["customlist_displayInMenu_0"]="Không";
$lll["customlist_displayInMenu_".customlist_loginMenu]="Đăng nhập trình đơn";
$lll["customlist_displayInMenu_".customlist_userMenu]="Thành viên trình đơn";
$lll["customlist_displayInMenu_".customlist_adminMenu]="Ban Quản Lý trình đơn";
$lll["customlist_displayInMenu_".customlist_categoryMenu]="Mục trình đơn";
$lll["randomOrder"]="--ngẫu nhiên--";
$lll["noDefaultSort"]="--Không thứ tự--";
$lll["selectField"]="--chọn nhóm--";
$lll["currentUser"]="--thành viên hiện tại--";
$lll["customlist_ownerName_expl"]="Nếu bạn chọn 'Thành viên hiện tại', trong danh sách sẽ luôn luôn chứa các rao vặt của những thành viên nào hiện đang đăng nhập. ví dụ: điều này đã được sử dụng trong các thiết lập ở danh sách điềy chỉnh 'Rao vặt của tôi'!";
$lll["customlist_loop"]="Vòng rao vặt";
$lll["customlist_loop_expl"]="Cho dù Chạy Cuộn được bắt đầu khi mục cuối bị chuyển đi vượt quá!";
$lll["customlist_autoScroll"]="Tự động cuộn trong vòng mỗi (giây)";
$lll["customlist_autoScroll_expl"]="Dùng 0 để vô hoạt động bộ Tự động cuộn";
$lll["customlist_cache"]="Bắt chụp nội dung danh sách và nội dung mới trong mỗi (phút)";
$lll["customlist_cache_expl"]="Vì vậy, mà các trang trưng bày danh sách điều chỉnh có thề chạy nhanh hơn, nó có thể bắt chụp nội dung của các danh sách trên máy chủ. 0 để vô hiệu hóa sự bắt chụp!";
$lll["commonFieldAlreadyExists"]="Một nhóm phổ biến với tên này và các dạng đã tồn tại. Xin vui lòng, hãy chọn một tên khác!";
// CloneCat:
$lll["clonecat_create_form"]="Mục chép";
$lll["clonecat_amount"]="Số chép";
$lll["clonecat_amount_expl"]="Tạo nhiều bộ chép - đặc biệt cũng là nếu bạn chép các tiểu mục và hình ảnh - có thể mất một thời gian dài, và bạn không nên đóng trình duyệt trong thời gian đó!";
$lll["clonecat_name"]="Clone with name";
$lll["clonecat_name_expl"]="Nếu bạn tạo nhiều hơn một bộ chép, bạn có thể áp dụng đánh số vào tên của chúng và chèn '%d' ở đây. Ví dụ: 'Ô tô-%d' sẽ cho kết quả chép như sau: Ô tô-1, Ô tô-2, Ô tô-3, v.v...";
$lll["clonecat_recursive"]="Cũng chép tiều mục";
$lll["clonecat_withPictures"]="Cũng chép mục ảnh";
$lll["categoriesCloned"]="Các mục đã được chép thành công!";
?>
