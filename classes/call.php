<?php
include("connection.php");
include("dbCls.php");
include("configuration.php");
include("mailCls.php");

$mydb	= new mydb();

$mydb->opendb();
include("general.class.php");
$Mail		= new Mail();


include("checkpage.php");
?>