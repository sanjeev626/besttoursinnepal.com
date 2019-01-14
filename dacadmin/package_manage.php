<script type="text/javascript">
	function deleteImage(imid)
	{
		//alert(imid);
		var bool;
		bool = confirm('Are you sure to delete this image. The process is ir-reversible.');
		if(bool)
		{
			window.location='index.php?manager=package_manage&id=<?php echo $_GET["id"];?>&aid=<?php echo $_GET['aid'];?>&delImid='+imid;
		}
	}
	
	function deleteMap(pid)
	{
		//alert(imid);
		var bool;
		bool = confirm('Are you sure to delete this map. The process is ir-reversible.');
		if(bool)
		{
			window.location='index.php?manager=package_manage&id=<?php echo $_GET["id"];?>&aid=<?php echo $_GET['aid'];?>&delMap='+pid;
		}
	}
	function deleteVideo(vid)
	{
		//alert(imid);
		var bool;
		bool = confirm('Are you sure to delete this video link?');
		if(bool)
		{
			window.location='index.php?manager=package_manage&id=<?php echo $_GET["id"];?>&aid=<?php echo $_GET['aid'];?>&delVid='+vid;
		}
	}
	
	function deleteIncluded(iid)
	{
		//alert(imid);
		var bool;
		bool = confirm('Are you sure to delete this. The process is ir-reversible.');
		if(bool)
		{
			window.location='index.php?manager=package_manage&id=<?php echo $_GET["id"];?>&aid=<?php echo $_GET['aid'];?>&delInc='+iid;
		}
	}
</script>

<?php
if(isset($_GET['id']))
{
	$btnValue='Update';
	$id = $_GET['id'];
}
else
{	
	$btnValue='Add';
	$id = 0;
}
?>
<?php
	
/* generate refresh link*/	

if(isset($_GET['aid']))
{
	$aid = $_GET['aid'];
	$refreshlink='&aid='.$aid;
}

if(isset($_GET['delMap']))
{
	$pid = $_GET['delMap'];
	$map= $mydb->getValue('map','tbl_package','id='.$pid);
	$unlink = '../img/package/'.$map;
	@unlink($unlink);
	$data['map'] = '';
	$mydb->updateQuery('tbl_package',$data,'id='.$pid);
	
}
if(isset($_GET['delVid']))
{
	$delVid = $_GET['delVid'];
	$mydb->deleteQuery('tbl_video','id='.$delVid);
}

if(isset($_GET['delInc']))
{
	$delInc = $_GET['delInc'];
	$mydb->deleteQuery('tbl_included','id='.$delInc);
}

if(isset($_GET['delImid']))
{
	$imid = $_GET['delImid'];
	$imagename = $mydb->getValue('imagename','tbl_image','id='.$imid);
	$unlink = '../img/package/'.$imagename;
	@unlink($unlink);
	$mydb->deleteQuery('tbl_image','id='.$imid);
	$mydb->redirect(ADMINURLPATH."package_manage&aid=".$aid."&id=".$id."&msg=1");
}

if(isset($_POST['btnSubmit']) && $_POST['btnSubmit']=='Update')
{
	//print_r($_FILES['packageeximage']);
	if(isset($_FILES['packageeximage']))
	{
	$excount = count($_FILES['packageeximage']['name']);
	for($i=0;$i<$excount;$i++)
	{
		if($_FILES['packageeximage']['size'][$i]>0)
		{
			$data='';
			$imagename = rand(111,999).$mydb->clean4imagecode($_FILES['packageeximage']['name'][$i]);
			$tmp_name=$_FILES['packageeximage']['tmp_name'][$i];
			$imagepath='../img/package/'.$imagename;
			copy($tmp_name,$imagepath);
			$data['package_id'] = $id;
			$data['imagename'] = $imagename;
			$mydb->insertQuery('tbl_packageimage',$data);
		}
	}
	}
	
	$data='';
	
	if(isset($_FILES['iconimage']['name']) && $_FILES['iconimage']['size']>0)
	{
		$imagename = $mydb->clean4imagecode($_FILES['iconimage']['name']);
		$tmp_name=$_FILES['iconimage']['tmp_name'];
		$imagepath='../img/package/thumb/';	
		$unlinkpicname = $mydb->getValue('iconimage','tbl_package','id='.$id);	
		$iconimage = $mydb->UploadImage($imagename,$tmp_name,$imagepath,'',$unlinkpicname);
		$data['iconimage'] = $iconimage;
	}	
	
	if(isset($_FILES['route_map']['name']) && $_FILES['route_map']['size']>0)
	{
		$imagename = $mydb->clean4imagecode($_FILES['route_map']['name']);
		$tmp_name=$_FILES['route_map']['tmp_name'];
		$imagepath='../img/package/';
		$unlinkpicname = $mydb->getValue('route_map','tbl_package','id='.$id);		
		$packageimage = $mydb->UploadImage($imagename,$tmp_name,$imagepath,'',$unlinkpicname);
		$data['route_map'] = $packageimage;
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
			$dest = '../img/package/'.$imagename;
			if(copy($source,$dest))
			{				
				$data2='';
				$data2['package_id'] = $id;
				$data2['imagename'] = $imagename;
				$data2['imagetitle'] = $_POST['imagetitle'][$i];
				$mydb->insertQuery('tbl_image',$data2);	
			}
		}
	}
	
	if(isset($_POST['pkimid'])){
		for($i=0;$i<count($_POST['pkimid']);$i++)
		{			
			$imid = $_POST['pkimid'][$i];
			$data3='';
			$data3['imagetitle'] = $_POST['pakimagetitle'][$i];
			$mydb->updateQuery('tbl_image',$data3,'id='.$imid);
		}
	}
	for($i=0;$i<5;$i++)
	{
		$pakimagesize = $_FILES['pakimagename']['size'][$i];
		//echo $imagesize."<br>";
		if($pakimagesize>0)
		{
			//ready to upload
			$pakimagename = rand(1111,9999).$mydb->clean4imagecode(($_FILES['pakimagename']['name'][$i]));
			$source = $_FILES['pakimagename']['tmp_name'][$i];
			$dest = '../img/package/'.$pakimagename;
			if(copy($source,$dest))
			{				
				$data2='';
				$data2['package_image_id'] = $id;
				$data2['imagename'] = $pakimagename;
				$data2['imagetitle'] = $_POST['imagetitle'][$i];
				$mydb->insertQuery('tbl_image',$data2);	
			}
		}
	}
	
	if(isset($_POST['vid'])){
		for($i=0;$i<count($_POST['vid']);$i++)
		{
			$vid = $_POST['vid'][$i];
			$data4='';
			$data4['link']=$_POST['oldlink'][$i];
			$mydb->updateQuery('tbl_video',$data4,'id='.$vid);
		}
	}
	for($i=0;$i<5;$i++)
	{
		$data4='';
		if($_POST['link'][$i]!=NULL){
		$data4['package_id'] = $id;	
		$data4['link'] = $_POST['link'][$i];		
		$mydb->insertQuery('tbl_video', $data4);
		}
	}
	
	if(isset($_POST['incid']))
	{
		for($i=0;$i<count($_POST['incid']);$i++)
		{
			$data5='';
			$iid = $_POST['incid'][$i];
			$data5['title'] = $_POST['oldinctitle'][$i];	
			$data5['description'] = $_POST['oldincdesc'][$i];
			$mydb->updateQuery('tbl_included',$data5,'id='.$iid);
		}
	}
	
	for($i=0;$i<3;$i++)
	{
		$data5='';
		if(isset($_POST['inctitle'][$i]) && $_POST['inctitle'][$i]!=NULL){
			$data5['package_id'] = $id;
			$data5['title'] = $_POST['inctitle'][$i];
			$data5['description'] = $_POST['incdesc'][$i];
			$mydb->insertQuery('tbl_included',$data5);
		}		
	}
	
	foreach($_POST as $key=>$value)
	{
		if($key!='btnSubmit' && $key!='imagetitle' && $key!='imid' && $key!='pakimagetitle' && $key!='pkimid' && $key!='vid' && $key!='oldlink' && $key!='link' && $key!='incid' && $key!='oldinctitle' && $key!='oldincdesc' && $key!='inctitle' && $key!='incdesc')
			$data[$key]=$value;
	}
	$data['urlcode'] = $mydb->clean4urlcode($_POST['title']);
	$data['ordering']= $mydb->getValue('ordering','tbl_package','aid='.$data['aid'].' ORDER BY ordering DESC LIMIT 1')+1;
	$refreshlink.='&id='.$id;
	//print_r($data); exit();
	$mydb->updateQuery('tbl_package',$data,'id='.$id);
	$mydb->redirect(ADMINURLPATH."package_manage&aid=".$data['aid']."&id=".$id."&msg=1");
}

if(isset($_POST['btnSubmit']) && $_POST['btnSubmit']=='Add')
{
	$aid = $_POST['aid'];
	//$rid = $_POST['rid'];
	$data='';
	if(isset($_FILES['iconimage']['name']) && $_FILES['iconimage']['size']>0)
	{
		$imagename = $mydb->clean4imagecode($_FILES['iconimage']['name']);
		$tmp_name=$_FILES['iconimage']['tmp_name'];
		$imagepath='../img/package/thumb/';		
		$iconimage = $mydb->UploadImage($imagename,$tmp_name,$imagepath);
		$data['iconimage'] = $iconimage;
	}
	
	if(isset($_FILES['route_map']['name']) && $_FILES['route_map']['size']>0)
	{
		$imagename = $mydb->clean4imagecode($_FILES['route_map']['name']);
		$tmp_name=$_FILES['route_map']['tmp_name'];
		$imagepath='../img/package/';	
		$packageimage = $mydb->UploadImage($imagename,$tmp_name,$imagepath);
		$data['route_map'] = $packageimage;
	}
	
	
	
	foreach($_POST as $key=>$value)
	{
		if($key!='btnSubmit' && $key!='imagetitle' && $key!='imid' && $key!='pakimagetitle' && $key!='pkimid' && $key!='vid' && $key!='oldlink' && $key!='link' && $key!='incid' && $key!='oldinctitle' && $key!='oldincdesc' && $key!='inctitle' && $key!='incdesc')
			$data[$key]=$value;
	}
	$data['ordering'] = $mydb->getValue('ordering','tbl_package','aid='.$aid.' ORDER BY ordering DESC LIMIT 1')+1;
	$data['urlcode'] = $mydb->clean4urlcode($_POST['title']);
	
	$package_id=$mydb->insertQuery('tbl_package',$data,'id='.$id);
	
	for($i=0;$i<5;$i++) //for package images
	{
		$pakimagesize = $_FILES['pakimagename']['size'][$i];
		//echo $imagesize."<br>";
		if($pakimagesize>0)
		{
			//ready to upload
			$pakimagename = rand(1111,9999).$mydb->clean4imagecode(($_FILES['pakimagename']['name'][$i]));
			$source = $_FILES['pakimagename']['tmp_name'][$i];
			$dest = '../img/package/'.$pakimagename;
			if(copy($source,$dest))
			{				
				$data2='';
				$data2['package_image_id'] = $package_id;
				$data2['imagename'] = $pakimagename;
				$data2['imagetitle'] = $_POST['pakimagetitle'][$i];
				$mydb->insertQuery('tbl_image',$data2);	
			}
		}
	}
	
	for($i=0;$i<5;$i++) //for package banner image
	{
		$imagesize = $_FILES['imagename']['size'][$i];
		//echo $imagesize."<br>";
		if($imagesize>0)
		{
			//ready to upload
			$imagename = rand(1111,9999).$mydb->clean4imagecode(($_FILES['imagename']['name'][$i]));
			$source = $_FILES['imagename']['tmp_name'][$i];
			$dest = '../img/package/'.$imagename;
			if(copy($source,$dest))
			{				
				$data2='';
				$data2['package_id'] = $package_id;
				$data2['imagename'] = $imagename;
				$data2['imagetitle'] = $_POST['imagetitle'][$i];
				$mydb->insertQuery('tbl_image',$data2);	
			}
		}
	}
	for($i=0;$i<5;$i++)
	{
		$data4='';
		if($_POST['link'][$i]!=NULL){
			$data4['link'] = $_POST['link'][$i];
			$data4['package_id'] = $package_id;
			$mydb->insertQuery('tbl_video',$data4);
		}
	}
	
	for($i=0;$i<3;$i++)
	{
		$data5='';
		if($_POST['inctitle'][$i]!=NULL){
			$data5['package_id'] = $package_id;
			$data5['title'] = $_POST['inctitle'][$i];
			$data5['description'] = $_POST['incdesc'][$i];
			$mydb->insertQuery('tbl_included',$data5);

		}
		
	}
	
	$mydb->redirect(ADMINURLPATH."package".$refreshlink."&msg=2");
}


include("fckeditor/fckeditor.php") ;
$rasPackage = $mydb->getArray('*','tbl_package','id='.$id);
?>
<form action="" method="post" enctype="multipart/form-data" name="frmPage">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="FormTbl">
  <tr class="TitleBar">
    <td colspan="3" class="TtlBarHeading"><?php echo $btnValue;?> Package<div style="float:right">
      <input type="button" name="btnList" id="btnList" value="List" class="button" onClick="window.location='<?php echo ADMINURLPATH;?>package<?php echo $refreshlink;?>'" />
      <input type="submit" name="btnSubmit" id="btnSubmit" value="<?php echo $btnValue;?>" class="button" /></div></td>
  </tr>
  <?php if(isset($_GET['msg']) && $_GET['msg'] =='1'){ ?>
  <tr>
    <td colspan="3" class="adminsucmsg">Package info has been updated.</td>
    </tr>
  <?php } ?>
  <tr>
    <td class="TitleBarA" width="170"><strong>Activity</strong></td>
    <td width="100" colspan="2" class="TitleBarA">
    	<select name="aid" id="aid" class="inputbox">
		<?php
        $counter = 0;
        $resActivity = $mydb->getQuery('*','tbl_activity');
        while($rasActivity = $mydb->fetch_array($resActivity))
        {
		if(isset($_GET['aid']))
			$aid = $_GET['aid'];
		else
			$aid = $rasPackage['aid'];
        ?>
        <option value="<?php echo $rasActivity['id'];?>" <?php if($rasActivity['id']==$aid) echo 'selected';?>><?php echo $rasActivity['title'];?></option>
        <?php
		}
		?>
        </select>    </td>
  </tr>
  <tr>
    <td class="TitleBarA"><strong>Name</strong></td>
    <td colspan="2" class="TitleBarA"><input name="title" type="text" value="<?php echo $rasPackage['title'];?>" class="inputbox"></td>
  </tr>
  <tr>
    <td class="TitleBarA"><strong>Duration</strong></td>
    <td colspan="2" class="TitleBarA"><input name="duration" type="text" value="<?php echo $rasPackage['duration'];?>" class="inputbox"></td>
  </tr>
  <tr>
    <td class="TitleBarA"><strong>Cost(USD)</strong></td>
    <td colspan="2" class="TitleBarA"><input name="cost" type="text" value="<?php echo $rasPackage['cost'];?>" class="inputbox"></td>
  </tr>
  <tr>
    <td class="TitleBarA"></td>
    <td colspan="2" class="TitleBarA"><strong>OR</strong></td>
  </tr>
  <tr>
    <td class="TitleBarA"><strong>Cost(NRs)</strong></td>
    <td colspan="2" class="TitleBarA"><input name="cost_npr" type="text" value="<?php echo $rasPackage['cost_npr'];?>" class="inputbox"></td>
  </tr>
  <tr>
    <td class="TitleBarA"><strong>Min. Group Size</strong></td>
    <td colspan="2" class="TitleBarA"><input name="mingroupsize" type="text" value="<?php echo $rasPackage['mingroupsize'];?>" class="inputbox"></td>
  </tr>
  <tr>
    <td class="TitleBarA"><strong>Best Season</strong></td>
    <td colspan="2" class="TitleBarA"><input name="bestseason" type="text" value="<?php echo $rasPackage['bestseason'];?>" class="inputbox"></td>
  </tr>
  <?php /*?>
  <tr>
    <td class="TitleBarA"><strong>Area</strong></td>
    <td colspan="2" class="TitleBarA"><input name="area" type="area" value="<?php echo $rasPackage['area'];?>" class="inputbox"></td>
  </tr>
  <tr>
    <td class="TitleBarA"><strong>Label as New Trip</strong></td>
    <td colspan="2" class="TitleBarA"><label>
      <select name="newtrip" id="newtrip">
      	<option value="0">No</option>
      	<option value="1" <?php if($rasPackage['newtrip']=='1') echo 'selected';?>>Yes</option>
      </select>
    </label></td>
  </tr>
  <tr>
    <td class="TitleBarA"><strong> Recommended Trip</strong></td>
    <td colspan="2" class="TitleBarA"><label>
      <select name="recommended" id="recommended">
      	<option value="0">No</option>
      	<option value="1" <?php if($rasPackage['recommended']=='1') echo 'selected';?>>Yes</option>
      </select>
    </label></td>
  </tr>
  <tr>
    <td class="TitleBarA"><strong> Best Seller</strong></td>
    <td colspan="2" class="TitleBarA"><label>
      <select name="bestseller" id="bestseller">
      	<option value="0">No</option>
      	<option value="1" <?php if($rasPackage['bestseller']=='1') echo 'selected';?>>Yes</option>
      </select>
    </label></td>
  </tr>
  <?php */?>
  <tr>
    <td class="TitleBarA"><strong> Show in Homepage</strong></td>
    <td colspan="2" class="TitleBarA"><label>
      <select name="homepage" id="homepage">
      	<option value="0">No</option>
      	<option value="1" <?php if($rasPackage['homepage']=='1') echo 'selected';?>>Yes</option>
      </select>
    </label></td>
  </tr>  
  <tr>
    <td class="TitleBarA"><strong>Is Fixed Departure</strong></td>
    <td colspan="2" class="TitleBarA">
    <input type="radio" name="is_fixed_departure" value="1" id="is_fixed_departure_0" <?php if($rasPackage['is_fixed_departure']=='1') echo 'checked="checked"';?>> Yes &nbsp;&nbsp;&nbsp;
    <input type="radio" name="is_fixed_departure" value="0" id="is_fixed_departure_1" <?php if($rasPackage['is_fixed_departure']=='0') echo 'checked="checked"';?>> No
    </td>
  </tr>
  <tr>
    <td class="TitleBarA"><strong>Is Seasonal Trip</strong></td>
    <td colspan="2" class="TitleBarA">
    <input type="radio" name="is_seasonal_trip" value="1" id="is_seasonal_trip_0" <?php if($rasPackage['is_seasonal_trip']=='1') echo 'checked="checked"';?>> Yes &nbsp;&nbsp;&nbsp;
    <input type="radio" name="is_seasonal_trip" value="0" id="is_seasonal_trip_1" <?php if($rasPackage['is_seasonal_trip']=='0') echo 'checked="checked"';?>> No
    </td>
  </tr>
  <tr>
    <td class="TitleBarA"><strong>Fixed Dates</strong></td>
    <td colspan="2" class="TitleBarA"><input name="fixed_dates" id="fixed_dates" type="text"  value="<?php echo $rasPackage['fixed_dates'];?>" class="inputbox" style="width:100%;"></td>
  </tr>
  <tr>
    <td class="TitleBarA"><strong>Excerpt</strong></td>
    <td class="TitleBarA" colspan="2"><textarea name="excerpt" id="excerpt" cols="45" rows="5" style="width:100%"><?php echo stripslashes($rasPackage['excerpt']);?></textarea></td>
  </tr>
  <tr>
    <td class="TitleBarA"><strong>Description</strong></td>
    <td colspan="2" class="TitleBarA"><?php
		$description = stripslashes($rasPackage['description']);
		
		$sBasePath = 'fckeditor/';
		
		$oFCKeditor = new FCKeditor('description') ;
		$oFCKeditor->BasePath = $sBasePath ;
		$oFCKeditor->Width = '100%' ;
		$oFCKeditor->Height = '350px' ;
		$oFCKeditor->Value = $description ;
		$oFCKeditor->Create() ;
		?>        </td>
  </tr>
  <tr>
    <td class="TitleBarA"><strong>Icon Image</strong></td>
    <td class="TitleBarA"><?php $iconpath='../img/package/thumb/'.$rasPackage['iconimage']; if(!empty($rasPackage['iconimage']) && file_exists($iconpath)){?><img src="<?php echo $iconpath;?>" alt="Package Image" width="220px"><br/><?php }?><input type="file" name="iconimage" id="iconimage"> 
    <strong>Note:</strong> Image Size should be in the ratio of 335px X 193px.</td>
  </tr>
  <tr>
    <td class="TitleBarA"><strong>Route Map</strong></td>
    <td class="TitleBarA"><?php $route_map_path=SITEROOTDOC.'img/package/'.$rasPackage['route_map']; if(!empty($rasPackage['route_map']) && file_exists($route_map_path)){?><img src="<?php echo SITEROOT.'img/package/'.$rasPackage['route_map'];?>" alt="Package Image" width="220px"><br/><?php }?><input type="file" name="route_map" id="route_map"> 
    <!--<strong>Note:</strong> Image Size should be in the ratio of 335px X 193px.--></td>
  </tr>
  <tr>
	  <td class="TitleBarA"><strong>Package Images</strong></td>
	  <td class="TitleBarA"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="FormTbl">
        <tr>
          <td class="TitleBarB"><strong>Image Title</strong></td>
          <td class="TitleBarB"><strong>Image</strong></td>
          <td class="TitleBarB">&nbsp;</td>
        </tr>
        <?php
		if($id>0)
		{
		$resPakImage = $mydb->getQuery('*','tbl_image','package_image_id='.$id);
		while($rasPakImage = $mydb->fetch_array($resPakImage))
		{
		?>
        <tr>
          <td class="TitleBarA"><input type="text" name="pakimagetitle[]" id="pakimagetitle[]" class="inputBox" style="width:500px;" value="<?php echo $rasPakImage['imagetitle'];?>"><input name="pkimid[]" type="hidden" value="<?php echo $rasPakImage['id'];?>"></td>
          <td class="TitleBarA"><img src="../img/package/<?php echo $rasPakImage['imagename'];?>" width="200"></td>
          <td class="TitleBarA"><a href="javascript:deleteImage('<?php echo $rasPakImage['id'];?>');"><img src="images/action_delete.gif" alt="Delete" width="24" height="24" title="Delete"></a></td>
        </tr>
        <?php
		}
		}
		for($i=0;$i<5;$i++)
		{
		?>
        <tr>
          <td class="TitleBarA"><input type="text" name="pakimagetitle[]" id="pakimagetitle[]" class="inputBox" style="width:500px;"></td>
          <td class="TitleBarA"><input type="file" name="pakimagename[]" id="pakimagename[]"></td>
          <td class="TitleBarA">&nbsp;</td>
        </tr>
        <?php
		}
		?>
        <tr>
        	<td colspan="3"><strong>Note:</strong> All images size should be same.</td>
        </tr>
      </table></td>
    </tr>
  <tr>
	  <td class="TitleBarA"><strong>Video</strong></td>
	  <td class="TitleBarA"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="FormTbl">
        <tr>
          <td class="TitleBarB"><strong>Youtube Video Link</strong></td>
          
          <td class="TitleBarB">&nbsp;</td>
        </tr>
        <?php
		if($id>0)
		{
		$resVideo = $mydb->getQuery('*','tbl_video','package_id='.$id);
		while($rasVideo = $mydb->fetch_array($resVideo))
		{
		?>
        <tr>
          <td class="TitleBarA"><input type="text" name="oldlink[]" id="oldlink[]" class="inputBox" style="width:500px;" value="<?php echo $rasVideo['link'];?>"><input name="vid[]" type="hidden" value="<?php echo $rasVideo['id'];?>"></td>
          <td class="TitleBarA"><a href="javascript:deleteVideo('<?php echo $rasVideo['id'];?>');"><img src="images/action_delete.gif" alt="Delete" width="24" height="24" title="Delete"></a></td>
        </tr>
        <?php
		}
		}
		for($i=0;$i<5;$i++)
		{
		?>
        <tr>
          <td class="TitleBarA"><input type="text" name="link[]" id="link[]" class="inputBox" style="width:500px;"></td>
          <td class="TitleBarA">&nbsp;</td>
        </tr>
        <?php
		}
		?>
      </table></td>
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
		$resGalImage = $mydb->getQuery('*','tbl_image','package_id='.$id);
		while($rasGalImage = $mydb->fetch_array($resGalImage))
		{
		?>
        <tr>
          <td class="TitleBarA"><input type="text" name="imagetitle[]" id="imagetitle[]" class="inputBox" style="width:500px;" value="<?php echo $rasGalImage['imagetitle'];?>"><input name="imid[]" type="hidden" value="<?php echo $rasGalImage['id'];?>"></td>
          <td class="TitleBarA"><img src="../img/package/<?php echo $rasGalImage['imagename'];?>" width="200"></td>
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
        	<td colspan="3"><strong>Note:</strong> Image Size should be in the ratio of 980px X 401px for the best view.</td>
        </tr>
      </table></td>
    </tr>
  <?php /*?><tr>
    <td class="TitleBarA"><strong>Map</strong></td>
    <td colspan="2" class="TitleBarA"><?php $mappath='../img/package/'.$rasPackage['map']; if(!empty($rasPackage['map']) && file_exists($mappath)){?><img src="<?php echo $mappath;?>" alt="Map" width="220px" style="padding-bottom:2px;"><a href="javascript:deleteMap('<?php echo $rasPackage['id'];?>');"><img style="position:relative; left:-23px; top:0px;" src="images/action_delete.gif" alt="Delete" width="24" height="24" title="Delete"></a><br/><?php }?><input type="file" name="map" id="map"></td>
  </tr><?php */?>
  <tr>
    <td class="TitleBarA"><strong>Highlights</strong></td>
    <td colspan="2" class="TitleBarA"><?php
		$highlights = stripslashes($rasPackage['highlights']);
		
		
		$sBasePath = 'fckeditor/';
		
		$oFCKeditor = new FCKeditor('highlights') ;
		$oFCKeditor->BasePath = $sBasePath ;
		$oFCKeditor->Width = '100%' ;
		$oFCKeditor->Height = '350px' ;
		$oFCKeditor->Value = $highlights ;
		$oFCKeditor->Create() ;
		?></td>
  </tr>
  <?php /*?><tr>
    <td class="TitleBarA"><strong>Accomodations</strong></td>
    <td colspan="2" class="TitleBarA"><?php
		$accomodations = stripslashes($rasPackage['accomodations']);
		
		
		$sBasePath = 'fckeditor/';
		
		$oFCKeditor = new FCKeditor('accomodations') ;
		$oFCKeditor->BasePath = $sBasePath ;
		$oFCKeditor->Width = '100%' ;
		$oFCKeditor->Height = '350px' ;
		$oFCKeditor->Value = $accomodations ;
		$oFCKeditor->Create() ;
		?></td>
  </tr><?php */?>
  <tr>
    <td class="TitleBarA"><strong>Itinerary</strong></td>
    <td colspan="2" class="TitleBarA">&nbsp;</td>
  </tr>
  <tr>
    <td class="TitleBarA"><strong>Includes</strong></td>
    <td colspan="2" class="TitleBarA"><?php
		$includes= stripslashes($rasPackage['includes']);
		
		
		$sBasePath = 'fckeditor/';
		
		$oFCKeditor = new FCKeditor('includes') ;
		$oFCKeditor->BasePath = $sBasePath ;
		$oFCKeditor->Width = '100%' ;
		$oFCKeditor->Height = '350px' ;
		$oFCKeditor->Value = $includes;
		$oFCKeditor->Create() ;
		?></td>
  </tr>
  <tr>
    <td class="TitleBarA"><strong>Excludes</strong></td>
    <td colspan="2" class="TitleBarA"><?php
		$excludes= stripslashes($rasPackage['excludes']);
		
		
		$sBasePath = 'fckeditor/';
		
		$oFCKeditor = new FCKeditor('excludes') ;
		$oFCKeditor->BasePath = $sBasePath ;
		$oFCKeditor->Width = '100%' ;
		$oFCKeditor->Height = '350px' ;
		$oFCKeditor->Value = $excludes;
		$oFCKeditor->Create() ;
		?></td>
  </tr>
  <tr>
    <td class="TitleBarA"><strong>Trip Notes</strong></td>
    <td colspan="2" class="TitleBarA"><?php
		$trip_notes= stripslashes($rasPackage['trip_notes']);
		
		
		$sBasePath = 'fckeditor/';
		
		$oFCKeditor = new FCKeditor('trip_notes') ;
		$oFCKeditor->BasePath = $sBasePath ;
		$oFCKeditor->Width = '100%' ;
		$oFCKeditor->Height = '350px' ;
		$oFCKeditor->Value = $trip_notes;
		$oFCKeditor->Create() ;
		?></td>
  </tr>
  <?php /*?><tr>
    <td class="TitleBarA"><strong>Trip Reviews</strong></td>
    <td colspan="2" class="TitleBarA"><?php
		$trip_reviews= stripslashes($rasPackage['trip_reviews']);
		
		
		$sBasePath = 'fckeditor/';
		
		$oFCKeditor = new FCKeditor('trip_reviews') ;
		$oFCKeditor->BasePath = $sBasePath ;
		$oFCKeditor->Width = '100%' ;
		$oFCKeditor->Height = '350px' ;
		$oFCKeditor->Value = $trip_reviews;
		$oFCKeditor->Create() ;
		?></td>
  </tr>
  <tr>
	  <td class="TitleBarA"><strong>What's Included</strong></td>
	  <td class="TitleBarA">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="FormTbl">
	  <tr>
          <td class="TitleBarB"><strong>Title</strong></td>
          <td class="TitleBarB"><strong>Description</strong></td>
          <td class="TitleBarB">&nbsp;</td>
      </tr>	
		<?php
		if($id>0)
		{
		$resInc = $mydb->getQuery('*','tbl_included','package_id='.$id);
		while($rasInc= $mydb->fetch_array($resInc))
		{
		?>
        <tr>
          <td class="TitleBarA" width="300px;"><input type="text" name="oldinctitle[]" id="oldinctitle[]" class="inputBox" style="width:300px;" value="<?php echo $rasInc['title'];?>"><input name="incid[]" type="hidden" value="<?php echo $rasInc['id'];?>"></td>
          <td class="TitleBarA">
		  <?php
		    //echo $rasInc['description'];
			$inc_description= stripslashes($rasInc['description']);			
		  ?>
          <textarea name="oldincdesc[]" id="oldincdesc[]" class="form-textarea" style="width:100%; resize:none;"><?php echo $inc_description;?></textarea>
          </td>
          <td class="TitleBarA"><a href="javascript:deleteIncluded('<?php echo $rasInc['id'];?>');"><img src="images/action_delete.gif" alt="Delete" width="24" height="24" title="Delete"></a></td>
        </tr>
        <?php
		}
		}
		for($i=0;$i<3;$i++)
		{
		?>
        <tr>
          <td class="TitleBarA" width="300px"><input type="text" name="inctitle[]" id="inctitle[]" class="inputBox" style="width:300px;"></td>
          <td class="TitleBarA">
          <textarea name="incdesc[<?php echo $i;?>]" id="incdesc[<?php echo $i;?>]" class="form-textarea" style="width:100%; resize:none;"></textarea>
          </td>
          <td class="TitleBarA">&nbsp;</td>
        </tr>
        <?php
		}
		?>
      </table></td>
    </tr> <?php */?> 
  <tr>
    <td class="TitleBarA"><strong>Page Title</strong></td>
    <td class="TitleBarA" colspan="2"><textarea name="metatitle" id="metatitle" cols="45" rows="5" style="width:100%"><?php echo stripslashes($rasPackage['metatitle']);?></textarea></td>
  </tr>
  <tr>
    <td class="TitleBarA"><strong>Meta Keywords</strong></td>
    <td class="TitleBarA" colspan="2"><textarea name="metakeywords" id="metakeywords" cols="45" rows="5" style="width:100%"><?php echo stripslashes($rasPackage['metakeywords']);?></textarea></td>
  </tr>
  <tr>
    <td class="TitleBarA"><strong>Meta Description</strong></td>
    <td class="TitleBarA" colspan="2"><textarea name="metadescription" id="metadescription" cols="45" rows="5" style="width:100%"><?php echo stripslashes($rasPackage['metadescription']);?></textarea></td>
  </tr>
  <tr>
    <td class="TitleBarA">&nbsp;</td>
    <td colspan="2" class="TitleBarA"><input type="submit" name="btnSubmit" id="btnSubmit" value="<?php echo $btnValue;?>" class="button" /></td>
  </tr>
</table>
</form>