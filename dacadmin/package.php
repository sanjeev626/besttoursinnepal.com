<?php

if(isset($_GET['del_pid']))

{

	$did = $_GET['del_pid'];	

	$mydb->deleteQuery('tbl_itinerary','pid='.$did);	
		$mydb->deleteQuery('tbl_included','package_id='.$did);	

	$imagepath='../img/package/';

	$thumbpath='../img/package/thumb/';

	$rasFile= $mydb->getArray('packageimage,iconimage,pdffile','tbl_package','id='.$did);

	$unlinkimgname = $rasFile['packageimage'];

	if(!empty($unlinkimgname))

	{

		@unlink($imagepath.$unlinkimgname);

		@unlink($thumbpath.$unlinkimgname);

	}

	

	$unlinkiconimage = $rasFile['iconimage'];

	if(!empty($unlinkiconimage))

		@unlink($thumbpath.$unlinkiconimage);	

	

	$unlinkpdffile = $rasFile['pdffile'];

	if(!empty($unlinkpdffile))

		@unlink($imagepath.$unlinkpdffile);

	
	$resImage=$mydb->getQuery('*','tbl_image','package_id="'.$did.'" or package_image_id');
	while($rasImage= $mydb->fetch_array($resImage))
	{
		$unlinkpicname = $rasImage['imagename'];
	
		if(!empty($unlinkpicname))
	
		{
	
			@unlink($imagepath.$unlinkpicname);
	
			@unlink($thumbpath.$unlinkpicname);
	
		}
	}
	$mydb->deleteQuery('tbl_video','package_id='.$did);
	$mydb->deleteQuery('tbl_image','package_id='.$did.' or package_image_id='.$did);
	$mydb->deleteQuery('tbl_package','id='.$did);

}

if(isset($_POST['btnSave']))

{

	for($i=0;$i<count($_POST['pid']);$i++)

	{

		$pid = $_POST['pid'][$i];

		$data='';

		$data['ordering'] = $_POST['ordering'][$i];

		$mydb->updateQuery('tbl_package',$data,'id='.$pid);

	}

}

	

	if(isset($_GET['aid']))

	{

		$aid = $_GET['aid'];

		$condition =" AND aid=".$aid;

		$addlink='&aid='.$aid;

	}

		$condition .=" ORDER BY ordering";

	//echo $condition;

	$resPackage = $mydb->getQuery('*','tbl_package',"aid=".$aid.' ORDER BY ordering');

	$count = mysql_num_rows($resPackage);

	?>

<form action="" method="post" name="Package">

  <table cellpadding="0" cellspacing="0" border="0" width="100%" class="FormTbl" style="font-size:12px;">	

	<tr class="TitleBar">

	  <td colspan="4" class="TtlBarHeading">Package List <?php if(isset($_GET['aid'])){ $aid = $_GET['aid']; echo 'for '.$mydb->getValue('title','tbl_activity','id='.$aid);}?><div style="float:right"><input name="btnAdd" type="button" value="Add" class="button" onClick="window.location='<?php echo ADMINURLPATH;?>package_manage<?php echo $addlink;?>'" /></div></td>

	</tr>

	<?php 

		if(isset($_GET['msg']) && $_GET['msg'] =='1'){ ?>

    <tr>

      <td colspan="4" class="adminsucmsg">Package info has been updated.</td>

      </tr>

    <?php 

		}

		if(isset($_GET['msg']) && $_GET['msg'] =='2'){ ?>

    <tr>

      <td colspan="4" class="adminsucmsg">New Package has been added.</td>

      </tr>

    <?php 

		}

		if(isset($_GET['del_pid'])){ ?>

    <tr>

      <td colspan="4" class="adminsucmsg">Selected Package has been deleted.</td>

      </tr>

    <?php 

		}

		if($count != 0)

		{

		?>

	<tr>

	  <td width="2%" valign="top" class="titleBarB" align="center"><strong>Ordering</strong></td>

	  <td width="22%" class="titleBarB"><strong>Name</strong></td>

	  <td class="titleBarB"><strong>Description</strong></td>

	  <td width="10%" class="titleBarB">&nbsp;</td>

	</tr>

	<?php

		$counter = 0;

		while($rasPackage = $mydb->fetch_array($resPackage))

		{

		?>

	<tr>

	  <td class="titleBarA" align="center"><input type="hidden" name="pid[]" id="pid[]" value="<?php echo $rasPackage['id'];?>" />

	    <input name="ordering[]" type="text" value="<?php echo $rasPackage['ordering'];?>"  class="inputbox" style="width:60px;"/></td>

	  <td class="titleBarA"><?php echo stripslashes($rasPackage['title']);?></td>

	  <td class="titleBarA"><?php echo substr(stripslashes($rasPackage['description']),0,130);?></td>

	  <td class="titleBarA" align="center"><a href="<?php echo ADMINURLPATH;?>itinerary_manage&amp;pid=<?php echo $rasPackage['id'];?>"><img src="images/itinerary.png" alt="Itinerary" width="24" height="24" title="Manage Itinerary" /></a> <a href="<?php echo ADMINURLPATH;?>package_manage<?php echo $addlink;?>&id=<?php echo $rasPackage['id'];?>"><img src="images/action_edit.gif" alt="Edit" width="24" height="24" title="Edit"></a> <a href="javascript:void(0);" onClick="callDelete('<?php echo ADMINURLPATH;?>package&aid=<?php echo $aid;?>&del_pid=<?php echo $rasPackage['id'];?>')"><img src="images/action_delete.gif" alt="Delete" width="24" height="24" title="Delete"></a></td>

	</tr>		

	<?php

        }

		?>        

	<tr>

	  <td class="titleBarA" align="center"><input type="submit" name="btnSave" id="btnSave" value="Save" class="button" /></td>

	  <td class="titleBarA">&nbsp;</td>

	  <td class="titleBarA">&nbsp;</td>

	  <td class="titleBarA" align="center">&nbsp;</td>

	  </tr>

    <?php

		}

		?>

  </table>

</form>