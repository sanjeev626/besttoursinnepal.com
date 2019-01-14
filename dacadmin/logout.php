<?php
if($mydb->logout(array(ADMINUSER),1))
{
	$mydb->redirect('index.php');
}
?>