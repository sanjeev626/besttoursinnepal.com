<?php
session_start();
error_reporting(0);
require_once("classes/call.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $metatitle;?></title>
<meta name="keywords" content="<?php echo $metakeywords;?>"> 
<meta name="description" content="<?php echo $metadescription;?>"> 
<meta name="robots" content="index, follow"> 
<meta name="revisit-after" content="5 Days"> 
<meta name="classification" content="Trekking/Tour Operator"> 
<meta name="Googlebot" content="index, follow"> 
<link rel="stylesheet" href="<?php echo SITEROOT;?>malung.css" />
<link rel="shortcut icon" href="favicon.ico">
<script type="text/javascript" src="<?php echo SITEROOT;?>js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="<?php echo SITEROOT;?>js/jquery.tabs.ready.js"></script>

<?php
if(isset($urlcode) && $urlcode=='book-the-trip')
{
?>
<script type="text/javascript">
	var SITEROOT = '<?php echo SITEROOT;?>calendar/';
</script>
<link type="text/css" rel="stylesheet" href="<?php echo SITEROOT;?>calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<SCRIPT type="text/javascript" src="<?php echo SITEROOT?>calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
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
		<?php } 
		
		?>
	});
</script>
<?php
}
?>

<link rel="stylesheet" href="<?php echo SITEROOT;?>prettyPhoto/css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script src="<?php echo SITEROOT;?>prettyPhoto/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>

</head>

<body>
<div class="main">
	<div class="header">
    	<div class="logo">
        
        </div><!--logo-->
        <div class="social">
        	<a href=""><img src="<?php echo SITEROOT;?>img/fb-ico.gif" title="Join Us on Facebook" /></a><a href=""><img src="<?php echo SITEROOT;?>img/tw-ico.gif" title="Follow Us" /></a><a href=""><img src="<?php echo SITEROOT;?>img/skype-ico.gif" title="Chat With Us" /></a>
        </div><!--social-->
        <div class="line">
        	<u>24h Hotline</u><br />
(+) 977 9851003529
        </div><!--line-->
        <div class="tmenu">
        	<?php include(SITEROOTDOC.'includes/navigation.php');?>
        </div><!--tmenu-->
    </div><!--header-->
    <div class="banner">
    	<?php include(SITEROOTDOC.'includes/banner.php');?>
    </div><!--banner-->
    <div class="mid">
		<?php
		if(isset($urlcode) && ($pagename!='package'))
		{
		?>
        <div class="lcont">
            <?php include(SITEROOTDOC.'includes/leftmenu.php');?>
        </div><!--lcont-->
        <?php
		}
		?>
		<?php include(SITEROOTDOC.$pagepath);?>
    </div><!--mid-->
    <div class="btm">
        <div class="soc">
        <a href="" class="fb">Facebook<br /><span class="ssc">Like us on Facebook</span></a>
        <a href="" class="tw">Twitter<br /><span class="ssc">Follow us on Twitter</span></a>
        <a href="" class="gp">Google Plus<br /><span class="ssc">Link to us on Google Plus</span></a>
        <a href="" class="yt">Youtube<br /><span class="ssc">Latest videos on Youtube</span></a>
        <a href="" class="ta">Tripadvisor<br /><span class="ssc">Trip reviews on Tripadvisor</span></a>
        </div><!--soc-->
        <div class="cop">
    	Copyright © 2014 Malung Treks &amp; Expeditions - All rights reserved. No part of this site may be reproduced without our written permission. <i>Site by - <a href="">Comply Outsourcing</a></i>
    </div><!--cop-->
	</div><!--btm-->
</div><!--main-->
</body>
</html>