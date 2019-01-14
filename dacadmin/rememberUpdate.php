<script type="text/javascript">
	function deleteImage(imid)
	{
		//alert(imid);
		var bool;
		bool = confirm('Are you sure to delete this image. The process is ir-reversible.');
		if(bool)
		{
			window.location='index.php?manager=rememberUpdate&pid=<?php echo $_GET["pid"];?>&delImid='+imid;
		}
	}
</script>
<?php
if(isset($_POST['btnSave']))
{
	$pid = $_GET['pid'];
	$data='';
	//print_r($_POST);
	//print_r($_FILES);
	if(isset($_FILES['iconimage']['name']) && $_FILES['iconimage']['size']>0)
	{
		$imagename = $mydb->clean4imagecode($_FILES['iconimage']['name']);
		$tmp_name=$_FILES['iconimage']['tmp_name'];
		$imagepath='../img/page/thumb/';		
		$iconimage = $mydb->UploadImage($imagename,$tmp_name,$imagepath);
		$data['iconimage'] = $iconimage;
	}
	
	
	foreach($_POST as $key=>$value)
	{
		if($key!='btnSave' && $key!="imagetitle" && $key!="imagelink" && $key!="imagename" && $key!="imagetitleOld" && $key!="imagelinkOld" && $key!="imid" && $key!="docimagetitle" && $key!="docimagename" && $key!="doctitleOld" && $key!="docimid")
			$data[$key]=$value;
	}
	
	$data['urlcode'] = $mydb->clean4urlcode($_POST['title']);

	$mydb->updateQuery('tbl_remember',$data,'id='.$pid);

	//update Old images and title
	if(isset($_POST['imid']))
	{
		for($i=0;$i<count($_POST['imid']);$i++)
		{			
			$imid = $_POST['imid'][$i];
			$data3='';
			$data3['imagetitle'] = $_POST['imagetitleOld'][$i];
			if($pid==3) 
			$data3['imagelink'] = $_POST['imagelinkOld'][$i];
			$mydb->updateQuery('tbl_image',$data3,'id='.$imid);
		}
	}
	

	//print_r($_FILES);
	if(isset($_FILES['imagename']['name']))
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
				//echo $imagename;
				
				$source = $_FILES['imagename']['tmp_name'][$i];
				$dest = '../img/banner/'.$imagename;
				if(copy($source,$dest))
				{				
					$data2='';
					$data2['pid'] = $pid;
					$data2['imagename'] = $imagename;
					$data2['imagetitle'] = $_POST['imagetitle'][$i];
					if($pid==3)
					$data2['imagelink'] = $_POST['imagelink'][$i];
					
					$mydb->insertQuery('tbl_image',$data2);	
				}
			}
		}
	}
	
	
	if(isset($_POST['docimid'])) //for legal documents
	{
		for($i=0;$i<count($_POST['docimid']);$i++)
		{			
			$imid = $_POST['docimid'][$i];
			$data3='';
			$data3['imagetitle'] = $_POST['doctitleOld'][$i];
			$mydb->updateQuery('tbl_image',$data3,'id='.$imid);
		}
	}
	
	if(isset($_FILES['docimagename']['name']))//for legal documents
	{
		$imgcount = count($_FILES['docimagename']['name']);
		for($i=0;$i<$imgcount;$i++)
		{
			$imagesize = $_FILES['docimagename']['size'][$i];
			//echo $imagesize."<br>";
			if($imagesize>0)
			{
				$imagename = rand(1111,9999).$mydb->clean4imagecode(($_FILES['docimagename']['name'][$i]));
				//echo $imagename;	
				$source = $_FILES['docimagename']['tmp_name'][$i];
				$dest = '../img/page/'.$imagename;
				if(copy($source,$dest))
				{				
					$data2='';
					$data2['page_image_id'] = $pid;
					$data2['imagename'] = $imagename;
					$data2['imagetitle'] = $_POST['docimagetitle'][$i];
					
					$mydb->insertQuery('tbl_image',$data2);	
				}
			}
		}
	}
}



if(isset($_GET['delImid']) && $_GET['delImid']>0)
{	
	$delImid = $_GET['delImid'];
	$imagename=$mydb->getValue('imagename','tbl_image','id='.$delImid);
	$imagepath='../img/banner/'.$imagename;
	@unlink($imagepath);
	$mydb->deleteQuery('tbl_image','id='.$delImid);
}

if(isset($_GET['pid']))
{
	$pid = $_GET['pid'];
	$rasPage = $mydb->getArray('*','tbl_remember','id='.$pid);
	$contents = stripslashes($rasPage['contents']);
?>

<form action="" method="post" name="pageEdit" enctype="multipart/form-data">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="FormTbl">
    <tr class="TitleBar">
      <td class="TtlBarHeading" colspan="4">Update Things to remember</td>
    </tr>
    <tr>
      <td class="TitleBarA" style="width:130px;"><strong>Title</strong></td>
      <td class="TitleBarA"><input name="title" type="text" value="<?php echo $rasPage['title']; ?>" class="inputbox" /></td>
    </tr>
    <?php



  if($pid!=3)

  {



  ?>
    <tr>
      <td class="TitleBarA"><strong>Contents</strong></td>
      <td class="TitleBarA"><?php



		include("fckeditor/fckeditor.php") ;
		$sBasePath = 'fckeditor/';
		$oFCKeditor = new FCKeditor('contents') ;
		$oFCKeditor->BasePath = $sBasePath ;
		$oFCKeditor->Width = '100%' ;
		$oFCKeditor->Height = '350px' ;
		$oFCKeditor->Value = $contents ;
		$oFCKeditor->Create() ;



		?></td>
    </tr>
    <?php
  }
  ?>
  	  <tr>
      <td class="TitleBarA"><strong>Excerpt</strong></td>
      <td class="TitleBarA"><textarea name="excerpt" cols="45" rows="5" style="width:100%"><?php echo $rasPage['excerpt'];?></textarea></td>
    </tr>
      <tr>
        <td class="TitleBarA"><strong> Image</strong></td>
        <td class="TitleBarA"><?php $iconpath='../img/page/thumb/'.$rasPage['iconimage']; if(!empty($rasPage['iconimage']) && file_exists($iconpath)){?><img src="<?php echo $iconpath;?>" alt="Page Image" width="150px"><br/><?php }?><input type="file" name="iconimage" id="iconimage"> <strong>Note:</strong> Image Size should be in the ratio of 150px X 94px.</td>
        </tr>
      <tr>
      <td class="TitleBarA"><strong>Page Title</strong></td>
      <td class="TitleBarA" colspan="2"><textarea name="metatitle" id="metatitle" cols="45" rows="5" style="width:100%"><?php echo stripslashes($rasPage['metatitle']);?></textarea></td>
    </tr>
    <tr>
      <td class="TitleBarA"><strong>Meta Keywords</strong></td>
      <td class="TitleBarA" colspan="2"><textarea name="metakeywords" id="metakeywords" cols="45" rows="5" style="width:100%"><?php echo stripslashes($rasPage['metakeywords']);?></textarea></td>
    </tr>
    <tr>
      <td class="TitleBarA"><strong>Meta Description</strong></td>
      <td class="TitleBarA" colspan="2"><textarea name="metadescription" id="metadescription" cols="45" rows="5" style="width:100%"><?php echo stripslashes($rasPage['metadescription']);?></textarea></td>
    </tr>
    <tr>
      <td class="TitleBarA">&nbsp;</td>
      <td class="TitleBarA"><input type="submit" name="btnSave" id="btnSave" value="Save" class="button" /></td>
    </tr>
  </table>
</form>
<?php
}



?>
