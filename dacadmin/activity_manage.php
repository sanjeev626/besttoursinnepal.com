<script type="text/javascript">
	function deleteImage(imid)
	{
		//alert(imid);
		var bool;
		bool = confirm('Are you sure to delete this image. The process is ir-reversible.');
		if(bool)
		{
			window.location='index.php?manager=activity_manage&id=<?php echo $_GET["id"];?>&delImid='+imid;
		}
	}
</script>
<?php

if(isset($_GET['id']))

{

	$btnValue='Save';

	$id = $_GET['id'];

}

else

{	

	$btnValue='Add';

	$id = 0;

}


if(isset($_GET['delImid']))
{
	$imid = $_GET['delImid'];
	$imagename = $mydb->getValue('imagename','tbl_image','id='.$imid);
	$unlink = '../img/activity/'.$imagename;
	@unlink($unlink);
	$mydb->deleteQuery('tbl_image','id='.$imid);
	$mydb->redirect(ADMINURLPATH."activity_manage&id=".$id."&msg=1");
}




if(isset($_POST['btnSubmit']) && $_POST['btnSubmit']=='Save')

{
	
	$imgcount = count($_FILES['imagename']['name']);
	for($i=0;$i<5;$i++)
	{
		$imagesize = $_FILES['imagename']['size'][$i];
		//echo $imagesize."<br>";
		if($imagesize>0)
		{
			//ready to upload
			$imagename = rand(1111,9999).$mydb->clean4imagecode(($_FILES['imagename']['name'][$i]));
			$source = $_FILES['imagename']['tmp_name'][$i];
			$dest = '../img/activity/'.$imagename;
			if(copy($source,$dest))
			{				
				$data2='';
				$data2['activity_id'] = $id;
				$data2['imagename'] = $imagename;
				$data2['imagetitle'] = $_POST['imagetitle'][$i];
				$mydb->insertQuery('tbl_image',$data2);	
			}
		}
	}
	
	if(isset($_POST['imid'])){
		for($i=0;$i<count($_POST['imid']);$i++)
		{			
			$imid = $_POST['imid'][$i];
			$data3='';
			$data3['imagetitle'] = $_POST['imagetitle'][$i];
			$mydb->updateQuery('tbl_image',$data3,'id='.$imid);
		}
	}

	$data='';

	if(isset($_FILES['activityimage']['name']) && $_FILES['activityimage']['size']>0)

	{

		$imagename = $_FILES['activityimage']['name'];

		$tmp_name=$_FILES['activityimage']['tmp_name'];

		$imagepath='../img/activity/';

		$thumbpath='../img/activity/thumb/';

		$unlinkpicname = $mydb->getValue('activityimage','tbl_activity','id='.$id);	

		$activityimage = $mydb->UploadImage($imagename,$tmp_name,$imagepath,$thumbpath,$unlinkpicname);

		$data['activityimage'] = $activityimage;

	}

	$data['cid'] = $_POST['cid'];

	$data['title'] = $_POST['title'];

	$data['description'] = $_POST['description'];

	//$data['urlcode'] = $mydb->clean4urlcode($_POST['title']).'-in-'.$country;

	$data['urlcode'] = $mydb->clean4urlcode($_POST['title']);

	$data['pagetitle'] = $_POST['pagetitle'];

	$data['excerpt'] = $_POST['excerpt'];

	$data['metakeywords'] = $_POST['metakeywords'];

	$data['metadescription'] = $_POST['metadescription'];

	$mydb->updateQuery('tbl_activity',$data,'id='.$id);

	$mydb->redirect(ADMINURLPATH."activity_manage&id=".$id."&msg=1");

}



if(isset($_POST['btnSubmit']) && $_POST['btnSubmit']=='Add')

{
	

	$data='';

	if(isset($_FILES['activityimage']['name']) && $_FILES['activityimage']['size']>0)

	{

		$imagename = $_FILES['activityimage']['name'];

		$tmp_name=$_FILES['activityimage']['tmp_name'];

		$imagepath='../img/activity/';

		$thumbpath='../img/activity/thumb/';

		$activityimage = $mydb->UploadImage($imagename,$tmp_name,$imagepath,$thumbpath);

		$data['activityimage'] = $activityimage;

	}
	
	$data['cid'] = $_POST['cid'];
	
	$data['title'] = $_POST['title'];

	$data['description'] = $_POST['description'];

	//$data['urlcode'] = $mydb->clean4urlcode($_POST['title']).'-in-'.$country;	

	$data['urlcode'] = $mydb->clean4urlcode($_POST['title']);

	$data['pagetitle'] = $_POST['pagetitle'];

	$data['excerpt'] = $_POST['excerpt'];

	$data['metakeywords'] = $_POST['metakeywords'];

	$data['metadescription'] = $_POST['metadescription'];

	$data['ordering'] = $mydb->getValue('ordering','tbl_activity','cid='.$data['cid'].' ORDER BY ordering DESC LIMIT 1')+1;
	
	//print_r($data);
	$id = $mydb->insertQuery('tbl_activity',$data);
	echo $id;

	
	for($i=0;$i<5;$i++) //for activity banner image
	{
		$imagesize = $_FILES['imagename']['size'][$i];
		//echo $imagesize."<br>";
		if($imagesize>0)
		{
			//ready to upload
			$imagename = rand(1111,9999).$mydb->clean4imagecode(($_FILES['imagename']['name'][$i]));
			$source = $_FILES['imagename']['tmp_name'][$i];
			$dest = '../img/activity/'.$imagename;
			if(copy($source,$dest))
			{				
				$data2='';
				$data2['activity_id'] = $id;
				$data2['imagename'] = $imagename;
				$data2['imagetitle'] = $_POST['imagetitle'][$i];
				$mydb->insertQuery('tbl_image',$data2);	
			}
		}
	}


	$mydb->redirect(ADMINURLPATH."activity&msg=2");

}



$rasActivity = $mydb->getArray('*','tbl_activity','id='.$id);

?>

<form action="" method="post" name="frmPage" enctype="multipart/form-data">

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="FormTbl">

  <tr class="TitleBar">

    <td colspan="2" class="TtlBarHeading"><?php echo $btnValue;?> Activity</td>

  </tr>

  <?php if(isset($_GET['msg']) && $_GET['msg'] =='1'){ ?>

  <tr>

    <td colspan="2" class="adminsucmsg">Activity info has been updated.</td>

    </tr>

  <?php } ?>
  <tr>
  	<td style="width:100px;"><strong>Country :</strong></td>

    <td>
    	<select name="cid" id="cid" class="inputbox">
		<?php
        $counter = 0;
        $resCountry= $mydb->getQuery('*','tbl_country');
        while($rasCountry = $mydb->fetch_array($resCountry))
        {
        ?>
        <option value="<?php echo $rasCountry['id'];?>" <?php if($rasActivity['cid']==$rasCountry['id']) echo 'selected';?>><?php echo $rasCountry['title'];?></option>
        <?php
		}
		?>
        </select>
    </td>
  </tr>

  <tr>

    <td style="width:100px;"><strong>Titile :</strong></td>

    <td><input name="title" type="text" value="<?php echo $rasActivity['title'];?>" class="inputbox"></td>

  </tr>

  <tr>

    <td><strong>Image :</strong></td>

    <td><?php $imagepath='../img/activity/'.$rasActivity['activityimage']; if(!empty($rasActivity['activityimage']) && file_exists($imagepath)){?><img src="<?php echo $imagepath;?>" alt="Package Image" width="220px"><br/><?php }?><input type="file" name="activityimage" id="activityimage"><strong>Note:</strong> Image Size should be in the ratio of 165px X 94px.</td></td>

  </tr>

  <tr>

    <td><strong>Description : </strong></td>

    <td>

		<?php

		include("fckeditor/fckeditor.php") ;

		$description = stripslashes($rasActivity['description']);

		

		$sBasePath = 'fckeditor/';		

		$oFCKeditor = new FCKeditor('description') ;

		$oFCKeditor->BasePath = $sBasePath ;

		$oFCKeditor->Width = '100%';

		$oFCKeditor->Height = '350px';

		$oFCKeditor->Value = $description ;

		$oFCKeditor->Create() ;

		?>

     </td>

  </tr>
  <tr>
      <td class="TitleBarA"><strong>Excerpt</strong></td>
      <td class="TitleBarA"><textarea name="excerpt" cols="45" rows="5" style="width:100%"><?php echo $rasActivity['excerpt'];?></textarea></td>
    </tr>
  <tr>
	  <td class="TitleBarA"><strong>Banner Images</strong></td>
	  <td class="TitleBarA"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="FormTbl">
        <tr>
          <td class="TitleBarB"><strong>Image Title</strong></td>
          <td class="TitleBarB"><strong>Image</strong></td>
          <td class="TitleBarB">&nbsp;</td>
        </tr>
        <?php
		if($id>0)
		{
		$resGalImage = $mydb->getQuery('*','tbl_image','activity_id='.$id);
		while($rasGalImage = $mydb->fetch_array($resGalImage))
		{
		?>
        <tr>
          <td class="TitleBarA"><input type="text" name="imagetitle[]" id="imagetitle[]" class="inputBox" style="width:500px;" value="<?php echo $rasGalImage['imagetitle'];?>"><input name="imid[]" type="hidden" value="<?php echo $rasGalImage['id'];?>"></td>
          <td class="TitleBarA"><img src="../img/activity/<?php echo $rasGalImage['imagename'];?>" width="200"></td>
          <td class="TitleBarA"><a href="javascript:deleteImage('<?php echo $rasGalImage['id'];?>');"><img src="images/action_delete.gif" alt="Delete" width="24" height="24" title="Delete"></a></td>
        </tr>
        <?php
		}
		}
		for($i=0;$i<5;$i++)
		{
		?>
        <tr>
          <td class="TitleBarA"><input type="text" name="imagetitle[]" id="imagetitle[]" class="inputBox" style="width:500px;"></td>
          <td class="TitleBarA"><input type="file" name="imagename[]" id="imagename[]"></td>
          <td class="TitleBarA">&nbsp;</td>
        </tr>
        <?php
		}
		?>
        <tr>
        	<td colspan="3"><strong>Note:</strong> Image Size should be in the ratio of 978px X 440px for the best view.</td>
        </tr>
      </table></td>
    </tr>

  <tr>

    <td><strong>Page Title :</strong></td>

    <td><textarea name="pagetitle" id="pagetitle" cols="45" rows="5" style="width:100%"><?php echo stripslashes($rasActivity['pagetitle']);?></textarea></td>

  </tr>

  <tr>

    <td><strong>Meta Keywords :</strong></td>

    <td><textarea name="metakeywords" id="metakeywords" cols="45" rows="5" style="width:100%"><?php echo stripslashes($rasActivity['metakeywords']);?></textarea></td>

  </tr>

  <tr>

    <td><strong>Meta Description :</strong></td>

    <td><textarea name="metadescription" id="metadescription" cols="45" rows="5" style="width:100%"><?php echo stripslashes($rasActivity['metadescription']);?></textarea></td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td><input type="submit" name="btnSubmit" id="btnSubmit" value="<?php echo $btnValue;?>" class="button" /></td>

  </tr>

</table>

</form>