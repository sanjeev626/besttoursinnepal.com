<?php
session_start();
error_reporting(0);
require_once("classes/call.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Best Tours in Nepal</title>
<meta name="keywords" content="Best Tours in Nepal, Best Tour in Nepal, Nepal Best Tours, Best Tours Nepal"> 
<meta name="description" content="Get the best deals for the best tours in Nepal with the best in this business."> 
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
if(isset($urlcode) && ($urlcode=='book-the-trip' || $urlcode=='fixed-departures-form'))
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
<!-- Added by Sanjyv ends here -->
</head>
<body>
<div class="main">
<div class="header">
  <div class="logo"></div><!--logo-->
    <div class="social">
      <ul>
          <li id="fb"><a href=""></a></li>
            <li id="tw"><a href=""></a></li>
            <li id="gp"><a href=""></a></li>
            <li id="yt"><a href=""></a></li>
            <li id="ta"><a href=""></a></li>
            <li id="sk"><a href=""></a></li>
        </ul>
    </div><!--social-->
    <div class="qcontact">
      <div class="ttel">+977 - 9851091661
        </div><!--ttel-->
        <div class="rct"><a href="<?php echo SITEROOT.$mydb->getValue('urlcode','tbl_page','id=13').'.html';?>">Request Custom Tour</a>
        </div><!--rct-->
    </div><!--qcontact-->
</div><!--header-->
<!--banner-->
<?php include (SITEROOTDOC.'includes/banner2.php');?>
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
          Copyright © 2015 Sports Tours and Travel. All rights reserved. Site - <a href="">www.besttoursinnepal.com</a> - By - <a href="">Comply Outsourcing</a><br />
No part of this publication may be reproduced, stored or transmitted in any form, without a written permission.
        </div><!--cpt-->
    </div><!--bottom-->

</div><!--main-->
</body>
</html>