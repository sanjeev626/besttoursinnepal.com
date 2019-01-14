<?php
if($_SERVER['HTTP_HOST'] == 'besttoursinnepal.dac' || $_SERVER['HTTP_HOST'] == '127.0.0.1')
{
	define("DBSERVER","localhost");
	define("DBUSER","root");
	define("DBPASSW",'');
	define("DBNAME","besttoursinnepal");
}
else
{
	define("DBSERVER","localhost");
	define("DBUSER","clprj026_best");
	define("DBPASSW",'lCa{D5U!MVPE');
	define("DBNAME","clprj026_best");
}
?>