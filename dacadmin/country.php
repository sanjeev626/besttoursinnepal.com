<script type="text/javascript">

 function callDelete(gid)

 {

	if(confirm('Are you sure to delete ?'))

	{

	window.location='?manager=country&did='+gid;

	}

 }

</script>

<?php

if(isset($_POST['btnUpdate']))

{

	$count = count($_POST['eid']);

	for($i=0;$i<$count;$i++)

	{

		$eid = $_POST['eid'][$i];

		$data='';

		$data['ordering'] = $_POST['ordering'][$i];

					

		$mydb->updateQuery('tbl_country',$data,'id='.$eid);

	}

}



if(isset($_GET['did']))

{

	$delId = $_GET['did'];

	$resImage = $mydb->getQuery('imagename','tbl_image','gid='.$delId);

	while($rasImage= $mydb->fetch_array($resImage))

	{

		$imagename = $rasImage['imagename'];

		$imagepath = "../uploads/country/";		

		$mydb->deleteImage($imagename,$imagepath);
	
	}
		$resActivity = $mydb->getQuery('*','tbl_activity','cid='.$delId);	
		
		while($rasActivity = $mydb->fetch_array($resActivity))
		{
		$unlinkimg = $rasActivity['activityimage'];
		if($unlinkimg!=NULL){
			//echo "test";
			@unlink('../img/activity/'.$unlinkimg);
			@unlink('../img/activity/thumb/'.$unlinkimg);
		}
		
		$resPackage=$mydb->getQuery('id,iconimage,map','tbl_package','aid='.$rasActivity['id']);
		{
			
			while($rasPackage = $mydb->fetch_array($resPackage))
			{
				
				if($rasPackage['iconimage']!=NULL)
				{
					@unlink('../img/package/thumb/'.$rasPackage['iconimage']);
				}
				if($rasPackage['map']!=NULL)
				{
					@unlink('../img/package/'.$rasPackage['map']);				
				}
				$resImages = $mydb->getQuery('imagename','tbl_image','package_id='.$rasPackage['id']);
				while($rasImages=$mydb->fetch_array($resImages))
				{
					@unlink('../img/package/'.$rasImages['imagename']);
				}
			}
			
		}
		$mydb->deleteQuery('tbl_package','aid='.$rasActivity['id']);
		}
		
		$mydb->deleteQuery('tbl_activity','cid='.$delId);

	
	
	

	$mydb->deleteQuery('tbl_image','gid='.$delId);	

	$mess = $mydb->deleteQuery('tbl_country','id='.$delId);
	$mydb->redirect(ADMINURLPATH.'country');

}



$result = $mydb->getQuery('*','tbl_country','1 ORDER BY ordering');

$count = mysql_num_rows($result);

?>

<form action="" method="post" name="tbl_entrepreneurspitchOrdering">

  <table cellpadding="0" cellspacing="0" border="0" width="100%" class="FormTbl" style="font-size:12px;">

    <tr class="TitleBar">

      <td colspan="3" class="TtlBarHeading">Manage country<div style="float:right"></div></td>

      <td class="TtlBarHeading" style="width:50px;"><input name="btnAdd" type="button" value="Add" class="button" onClick="window.location='<?php echo ADMINURLPATH;?>country_manage'" /></td>

    </tr>

    <?php

	if($count != 0)

	{

	?>

    <tr>

	  <td width="2%" valign="top" class="titleBarB" align="center"><strong>Order</strong></td>

	  <td width="10%" class="titleBarB"><strong>Title</strong></td>

	  <td width="10%" class="titleBarB"><strong>Image</strong></td>

	  <td width="8%" class="titleBarB">&nbsp;</td>

	</tr>

	<?php

		$counter = 0;

		while($rascountry = $mydb->fetch_array($result))

		{

		$pid = $rascountry['id'];

		?>

	<tr>

	  <td class="titleBarA" align="center" valign="top"> <input name="eid[]" type="hidden" id="eid[]" value="<?php echo $rascountry['id'];?>" />

      <input type="text" name="ordering[]" id="ordering[]" value="<?php echo $rascountry['ordering'];?>" style="width:30px;" /></td>

	  <td class="titleBarA" valign="top"><?php echo stripslashes($rascountry['title']);?></td>

	  <td class="titleBarA" valign="top"><img src="../img/country/<?php echo $mydb->getValue('imagename','tbl_image','gid='.$pid);?>" height="60" /></td>

	  <td class="titleBarA" valign="top" align="center"><a href="<?php echo ADMINURLPATH;?>country_manage&id=<?php echo $rascountry['id'];?>"><img src="images/action_edit.gif" alt="Edit" width="24" height="24" title="Edit"></a> <a href="javascript:void(0);" onclick="callDelete('<?php echo $pid;?>')"><img src="images/action_delete.gif" alt="Delete" width="24" height="24" title="Delete"></a></td>

	</tr>

	

<?php

}

?>

	<tr>

	  <td class="titleBarA" align="center" valign="top"><input type="submit" name="btnUpdate" id="btnUpdate" value="Save" class="button" /></td>

	  <td class="titleBarA" valign="top">&nbsp;</td>

	  <td class="titleBarA" valign="top">&nbsp;</td>

	  <td class="titleBarA" valign="top" align="center">&nbsp;</td>

    </tr>

<?php

		}

		else

		{

		?>

    <tr>



      <td class="message" colspan="4">No country has been Added</td>

   	</tr>

    <?php

		}

		?>

  </table>

</form>