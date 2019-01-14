<?php
	$res = $mydb->getQuery('id,title','tbl_package');
	while($ras=$mydb->fetch_array($res))
	{
		$data='';
		$id = $ras['id'];
		$title = $ras['title'];
		$urlcode = $mydb->clean4urlcode($title);
		$data['urlcode'] = $urlcode;
		$mydb->updateQuery('tbl_package',$data,'id='.$id);
	}
?>