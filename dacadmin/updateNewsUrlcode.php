<?php
$resNews = $mydb->getQuery('*','tbl_news','1 ORDER BY id DESC');
while($rasNews = $mydb->fetch_array($resNews))
{
	$id = $rasNews['id'];
	$title = $rasNews['title'];
	$data['urlcode'] = $mydb->clean4urlcode($title);
	$mydb->updateQuery('tbl_news',$data,'id='.$id);	
	echo $title.' Updated<br>';
}
?>