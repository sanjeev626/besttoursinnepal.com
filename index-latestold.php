<?php
session_start();
error_reporting(0);
require_once("classes/call.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="google-site-verification" content="yyUWbeSBhpCTncEXKGNg07D3uWCKvYozDGJXw_Pw60U" />
<meta name="msvalidate.01" content="A1CFB2F43206928317B016C8CD9C1B48" />
<title><?php echo $metatitle;?></title>
<meta name="keywords" content="<?php echo $metakeywords;?>"> 
<meta name="description" content="<?php echo $metadescription;?>"> 
<meta name="robots" content="index, follow"> 
<meta name="revisit-after" content="5 Days"> 
<meta name="classification" content="Trekking/Tour Operator"> 
<meta name="Googlebot" content="index, follow"> 
<link rel="stylesheet" href="<?php echo SITEROOT;?>surraj.css" />
<link rel="shortcut icon" href="favicon.ico">
<script type="text/javascript" src="<?php echo SITEROOT;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo SITEROOT;?>js/jquery.tabs.ready.js"></script>
<!-- Added by Sanjyv -->
<?php
if(isset($urlcode) && ($urlcode=='book-the-trip' || $urlcode=='fixed-departures-form' || $urlcode=='request-custom-tour'))
{
?>
    <script type="text/javascript">
        var SITEROOT = '<?php echo SITEROOT;?>calendar/';
    </script>
    <link type="text/css" rel="stylesheet" href="<?php echo SITEROOT;?>calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></link>
    <script type="text/javascript" src="<?php echo SITEROOT?>calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
<?php
}
if(isset($urlcode) && ($urlcode=='book-the-trip' || $urlcode=='custom-estimate' || $urlcode=='contact' || $urlcode=='request-custom-tour'))
{
?>
    <link rel="stylesheet" href="<?php echo SITEROOT;?>css/validationEngine.jquery.css" type="text/css"/>
    <script src="<?php echo SITEROOT;?>js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SITEROOT;?>js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script>
        $(document).ready(function(){
            // binds form submission and fields to the validation engine
            <?php 
            if($urlcode=='book-the-trip'){?>
                $("#frmBook").validationEngine();
            <?php } 
            if($urlcode=='custom-estimate'){?>
                $("#frmEstimates").validationEngine();
            <?php }  
            if($urlcode=='contact'){?>
                $("#frmContact").validationEngine();
            <?php }  
            if($urlcode=='request-custom-tour'){?>
                $("#frmCustom").validationEngine();
            <?php } ?>
        });
    </script>
<?php
}
?>
    <link rel="stylesheet" href="<?php echo SITEROOT;?>prettyPhoto/css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
    <script src="<?php echo SITEROOT;?>prettyPhoto/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
<link rel="shortcut icon" href="<?php echo SITEROOT;?>img/favicon.ico" type="image/x-icon"/>
<link rel="icon" href="<?php echo SITEROOT;?>img/favicon.ico" type="image/x-icon">
<!-- Added by Sanjyv ends here -->
</head>
<body>
<div class="main">
<div class="header">
  <div class="logo"></div><!--logo-->
    <div class="social">
      <ul>
          <li id="fb"><a href="https://www.facebook.com/whentotravelnepal/"></a></li>
            <li id="tw"><a href=""></a></li>
            <li id="gp"><a href=""></a></li>
            <li id="yt"><a href=""></a></li>
            <li id="ta"><a href=""></a></li>
            <li id="sk"><a href=""></a></li>
        </ul>
    </div><!--social-->
    <div class="qcontact">
      <div class="ttel">+977 - 9851091661 (Milan)
        </div><!--ttel-->
        <div class="wapp">+977 - 9818408000 (Milan)
        </div><!--wapp-->
        <div class="rct"><a href="<?php echo SITEROOT.$mydb->getValue('urlcode','tbl_page','id=13').'.html';?>">Request Custom Tour</a>
        </div><!--rct-->
    </div><!--qcontact-->
</div><!--header-->
<!--banner-->
<?php
if(isset($urlcode) && ($urlcode=='book-the-trip' || $urlcode=='fixed-departures-form' || $urlcode=='request-custom-tour'))
{
    include (SITEROOTDOC.'includes/banner-with-no-slider.php');
}
else
{    
    include (SITEROOTDOC.'includes/banner.php');
}
?>
<!--banner ends-->
<div class="mid">
  <?php include(SITEROOTDOC.$pagepath);?>
</div><!--mid-->

       <div class="bottom">
      <div class="affacc">
          <div class="aff">
              <img src="<?php echo SITEROOT;?>img/ntb-logo.jpg" title="Nepal Tourism Board" />
                <img src="<?php echo SITEROOT;?>img/natta-logo.jpg" title="Nepal Association of Travel and Tour Agents" />
                <img src="<?php echo SITEROOT;?>img/vitof-logo.jpg" title="Village Tourism  Forum" />
            </div><!--aff-->
            <div class="acc">
              <img src="<?php echo SITEROOT;?>img/visa-mastercard.jpg" title="We accept Visa and Master Card" />
            </div><!--acc-->
        </div><!--affacc-->
        <div class="cpt">
          Copyright © 2018 Sports Tours and Travel. All rights reserved. Site - <a href="<?php echo SITEROOT;?>">www.besttoursinnepal.com</a><br />
No part of this publication may be reproduced, stored or transmitted in any form, without a written permission.
        </div><!--cpt-->
    </div><!--bottom-->

</div><!--main-->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-82767257-1', 'auto');
  ga('send', 'pageview');

</script>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5b0d056b10b99c7b36d468a2/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

</body>
</html>