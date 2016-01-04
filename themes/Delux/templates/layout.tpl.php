<?php defined('_NOAH') or die('Restricted access'); ?>
<?php include(NOAH_APP . "/config.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="<?php echo $this->language ?>" dir="<?php echo $this->langDir ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
        <base href='<?php echo $this->baseUrl ?>'>

        <?php /* Search Engine Optimization section: */ ?>
        <?php if ($this->get("customMetaTags")): ?>a
        <?php echo $this->get("customMetaTags") ?>
        <?php else: ?>
                <title><?php echo $this->titlePrefix ?><?php if ($this->title)
                    echo ' - ' . $this->title; ?></title>
            <meta name='description' content='<?php echo $this->description ?>'>
            <meta name='keywords' content='<?php echo $this->keywords ?>'>
        <?php endif; ?>
        <?php /* JavaScript section (without this, pages won't work properly!): */ ?>
        <?php echo $this->jsIncludes /* includes external JavaScript and CSS files */ ?>
                <script type="text/javascript">        
                    function showResult(str)        
                    {        
                        if (str.length==0)        
                        {        
                            document.getElementById("livesearch").innerHTML="";        
                            document.getElementById("livesearch").style.border="0px";        
                            return;        
                        }        
                        if (window.XMLHttpRequest)        
                        {// code for IE7+, Firefox, Chrome, Opera, Safari        
                            xmlhttp=new XMLHttpRequest();        
                        }        
                        else        
                        {// code for IE6, IE5        
                            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");        
                        }        
                        xmlhttp.onreadystatechange=function()        
                        {        
                            if (xmlhttp.readyState==4 && xmlhttp.status==200)        
                            {        
                                document.getElementById("livesearch").innerHTML=xmlhttp.responseText;        
        
                            }        
                        }        
                        xmlhttp.open("GET","livesearch.php?q="+str,true);        
                        xmlhttp.send();        
                    }        
                </script>        
        <?php echo $this->javaScript /* inserts internal JavaScrip code */ ?>
        <?php echo $this->extraHead /* inserts the 'Additional HEAD content' from the Settings form */ ?>
            </head>        
            <body>        
        <?php echo $this->extraBody /* inserts the 'Additional BODY content' from the Settings form */ ?>

                <div id="wrapper">        
                    <div id="header_links">        
        
                <?php if (count($this->categoryMenu)): ?>
    
                <?php include $this->loadTemplate("menu_category.tpl.php"); /* This includes category menu points */ ?>
    
                <?php endif; ?>
                <?php if (count($this->adminMenu)): ?>
                <?php include $this->loadTemplate("menu_admin.tpl.php"); /* This includes user/admin menu points */ ?>
                <?php endif; ?><a>&nbsp;</a>
                    </div>        
                    <div id="logo" class="left">        
                        <a href="<?php echo $this->baseUrl ?>" id="logolink">
                            <img src='<?php echo $this->imagesDir ?>/logo.png?logoImage' border="0" width="247px" alt="">
                        </a>        
                    </div>        
                    <div id="b728x90" class="left">        
                        <script type="text/javascript"><!--        
                            google_ad_client = "pub-9116025020258772";        
                            google_ad_slot = "9786065209";        
                            google_ad_width = 728;        
                            google_ad_height = 90;        
                            //-->        
                        </script>        
                        <script type="text/javascript"        
                                src="http://pagead2.googlesyndication.com/pagead/show_ads.js">        
                        </script>        
                    </div>        
                    <div class="clear"></div>        
            <?php include $this->loadTemplate("menu_login.tpl.php"); /* This includes an other template file that contains the user menu points */ ?>
            
                        <div class="clear"></div>            
            
                        <div id="login">            
                <?php if (!empty($this->loginMenu["register"])): ?>
                            <a href='<?php echo $this->loginMenu["register"]["link"] ?>' class="reg_btn left">
                    <?php echo $this->loginMenu["register"]["label"] ?></a><?php endif; ?>
        
                <?php if (!empty($this->loginMenu["logout"])): ?>
                                <a href='<?php echo $this->loginMenu["logout"]["link"] ?>' class="reg_btn left">
                    <?php echo $this->loginMenu["logout"]["label"] ?></a>
            
                <?php endif; ?>
                                <span id="first_text" class="left" style="width: 150px;"><?php echo $this->userStatus ?></span>
                <?php if (!empty($this->loginMenu["login"])): ?>
                                    <form method='POST' action='index.php' id='gorumForm' ENCTYPE='multipart/form-data'>                    
                                        <input type='hidden' id='list' name='list' value='user'>                    
                                        <input type='hidden' id='method' name='method' value='login'>                    
                                        <span id="input_username" class="left"><input type="text" name="name" onfocus="this.value=''" value="Username" /></span>                    
                    
                                        <span id="input_password" class="left"><input type="password" name="password" onfocus="this.value=''" value="Pass" /></span>                    
                                        <input type="submit" name="gsubmit" id="input_submit" value="Log in!" class="left" />                    
                                        <span id="secound_text" class="left">may be you <a href="index.php?user/remind_password_form/">forgot your password?</a></span>                    
                                    </form>                    
                <?php endif; ?>
                <?php if (count($this->userMenu)): ?>
                                        <div class="menu" >                        
                    <?php include $this->loadTemplate("menu_user.tpl.php"); /* This includes an other template file that contains the user menu points */ ?>
                                    </div>                    
                <?php endif; ?>
                                    </div>                        
                        
                        
                                    <div class="clear"></div>                        
                        
                                    <div class="left" style="width: 670px;margin:20px 0 0 0;">                        
                        
                                        <div id="search_bg">                        
                        
                                            <form method="post" action="index.php">                        
                                                <input type='hidden' id='list' name='list' value='itemsearch'>                        
                                                <input type='hidden' id='method' name='method' value='create'>                        
                                                <input type="text" onfocus="if(this.value=='Search...') this.value=''" name="str" AUTOCOMPLETE='off' onkeyup="showResult(this.value)" class="left" value="Search..." />                        
                        
                                                <input type="submit" id="srch_submit" name="search" value="Search!" />                        
                                                <div id="livesearch" class="searchresult"></div>                        
                        
                                            </form>                        
                        
                                        </div>                        
                                        <br/>                        
                <?php echo $this->extraTopContent /* inserts the 'Additional top content' from the Settings form */ ?>
                <?php if ($this->infoText): ?>
                                            <div class='error'><?php echo $this->infoText ?></div>
                <?php endif; ?>
                <?php if ($this->get("navBar")): ?>
                                                <div class="kategorii">                                
                    <?php echo $this->get("navBar") ?>
                                            </div>                            
                <?php endif; ?>
                                                <center style="padding-bottom:5px;">                                
                    <?php $this->displayContent("customListAboveContent") /* inserts custom lists where 'Above content' has been selected in the 'Position' field */ ?>
                                            </center>                            
                <?php $this->displayContent() ?>
                <?php $this->displayContent("customListBelowContent", putWhiteSpaceAbove) /* inserts custom lists where 'Below content' has been selected in the 'Position' field */ ?>
                <?php echo $this->extraBottomContent /* inserts the 'Additional bottom content' from the Settings form */ ?>
                                            </div>                                
                                            <div class="left" style="width: 310px;margin:10px 0 0 10px;">                                
                                
                                                <div class="b300x250">                                
                    <?php if ($this->languageSelector || $this->themeSelector): ?>
                    <?php echo $this->languageSelector ?>
                    <?php echo $this->themeSelector ?>
                                                    <br/>                                
                    <?php endif; ?>
                                                    <img border="0" src="http://hostgator.com/banners/hostgator-300x250.gif" width="300" height="250">                                
                                                    <br/>                                
                                                    <script src="http://widgets.twimg.com/j/2/widget.js"></script>                                
                                                    <script>                                
                                                        new TWTR.Widget({                                
                                                            version: 2,                                
                                                            type: 'profile',                                
                                                            rpp: 40,                                
                                                            interval: 4000,                                
                                                            width: 300,                                
                                                            height: 300,                                
                                                            theme: {                                
                                                                shell: {                                
                                                                    background: '#F9F9F9',                                
                                                                    color: '#000000'                                
                                                                },                                
                                                                tweets: {                                
                                                                    background: '#EEEEEE',                                
                                                                    color: '#2E2E2E',                                
                                                                    links: '#E65709'                                
                                                                }                                
                                                            },                                
                                                            features: {                                
                                                                scrollbar: false,                                
                                                                loop: true,                                
                                                                live: true,                                
                                                                hashtags: true,                                
                                                                timestamp: true,                                
                                                                avatars: true,                                
                                                                behavior: 'preloaded'                                
                                                            }                                
                                                        }).render().setUser('toptweets').start();                                
                                                    </script>                                
                                                </div>                                
                                                <div class="clear"></div>                                
                                                <div class="b300x250">                                
                    <?php $this->displayContent("customListRight") /* inserts custom lists where 'On the right side of the page' has been selected in the 'Position' field */ ?>
                                
                                
                                                </div>                                
                                            </div>                                
                                            <div class="clear"></div>                                
                                            <div class="footer">                                
                                
                <?php
                                                    $query1 = "SELECT name,permalink FROM " . $dbPrefix . "category WHERE up=0 ORDER BY itemNum DESC";
                                                    $result1 = mysql_query($query1) or die(mysql_error());
                                                    while ($row = mysql_fetch_array($result1)) {
                ?>
                                                        <a href="index.php?<?php echo $row['permalink']; ?>" target="_blank" title="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></a> |
                                        
                <?php
                                                    }
                ?>
                                                </div>                                    
                                    
                                                <div class="footer">                                    
                                                    <b>About Site:</b>                                    
                                                    <a href="#">Sitemap</a>                                    
                                                    <a href="#">Terms of Use</a>                                    
                                                    <a href="#">Privacy</a>                                    
                                                    <a href="#">Help</a>                                    
                <?php if (isset($this->rssFeed)): ?>
                <?php foreach ($this->rssFeed as $item): ?>
                                                            <a href='<?php echo $item["link"] ?>' class='<?php echo $item["linkClass"] ?>'>
                    <?php echo $item["label"] ?>
                                                        </a>                                        
                <?php endforeach; ?>
                <?php endif; ?>
                                                            <br />                                            
                                            
                                                            <br />                                            
                                                            <b>About listings:</b>                                            
                                                            <a href="index.php?item/create_form/">Submit ..</a>                                            
                                                            <a href="index.php?customlist/3">Recent ads</a>                                            
                                                            <a href="index.php?customlist/4">Popular ads</a>                                            
                                            
                                            
                                                            <p id="copyrights">Create by: <a href="http://www.noahthemes.com" target="_blank">noahthemes.com</a></p></div>                                            
                                            
                                                    </div>     
                
        <?php echo $this->extraFooter /* inserts the 'Additional footer content' from the Settings form */ ?>
                                                            <center>                                                    
            <?php $this->displayContent("customListBottom", putWhiteSpaceAbove) /* inserts custom lists where 'On the bottom of the page' has been selected in the 'Position' field */ ?>
        </center>
    </body>

</html>