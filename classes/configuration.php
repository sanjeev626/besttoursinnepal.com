<?php
// client
define("ACTIONNAME","manager");
define("URLPATH","index.php?".ACTIONNAME."=");
if($_SERVER['HTTP_HOST'] == 'besttoursinnepal.dac' || $_SERVER['HTTP_HOST'] == '127.0.0.1')
{
	define("SITEROOT","http://besttoursinnepal.dac/");
	define("SITEROOTADMIN","http://besttoursinnepal.dac/dacadmin");
	define("SITEROOTDOC",$_SERVER['DOCUMENT_ROOT']."/");
}
else
{
	define("SITEROOT","http://www.besttoursinnepal.com/");
	define("SITEROOTADMIN",SITEROOT."dacadmin");
	define("SITEROOTDOC",$_SERVER['DOCUMENT_ROOT']."/");
}

define("FILEPATH","includes/");
define("PAGING","dashboard/");
define("IMAGEPATH","images/");

define("USERID","sanjeevdbclientuser");
$allowedimageext = array ("jpg", "jpeg", "gif", "png");
$allowedextfile = array ("pdf", "doc", "docx", "txt", "xls");

// admin
define("SITEADMINHEADER","besttoursinnepal.com");
define("SITEADMINFOOTER","2014 nepal holiday tours");

define("ADMINACTIONNAME","manager");
define("ADMINURLPATH","index.php?".ADMINACTIONNAME."=");
define("ADMINUSER","sanjeevdbdfg546gfddgdfg");
define("SECRETPASSWORD","sanjeevsinghdbementendc");
?>