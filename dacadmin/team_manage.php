<?php
if(isset($_GET['id']))
{
	$gid = $_GET['id'];
	$do = "Update";
}
else
{
	$gid = 0;
	$do = "Add";
}

if(isset($_POST['btnDo']) && $_POST['btnDo']=='Add')
{
	foreach($_POST as $key=>$value)
	{
		if($key!="btnDo" && $key!="imagetitle") 
		$data[$key]=$value;
	}
	
	//$data['urlcode'] = $mydb->clean4urlcode($_POST['name']);	
	$data['ordering'] = $mydb->getValue('ordering','tbl_team','1 ORDER BY ordering DESC LIMIT 1')+1;	
	
	$imagesize = $_FILES['filename']['size'];
	if($imagesize>0)
	{		
		$filename = rand(1111,9999).$mydb->clean4imagecode(($_FILES['filename']['name']));
		$source = $_FILES['filename']['tmp_name'];
		$dest = '../img/team/'.$filename;
		if(copy($source,$dest))
		{
			$data['filename'] = $filename;
		}
	}		
	
	$gid = $mydb->insertQuery('tbl_team',$data);	

	if($gid>0)
	{
		$message = "New Member Has been added.";
	}
	else
	{
		$message = "ERROR!! Failed to add Member.";
	}
	
	$url = ADMINURLPATH."team&message=".$message;
	$mydb->redirect($url);
}

if(isset($_POST['btnDo']) && $_POST['btnDo']=='Update')
{	
	foreach($_POST as $key=>$value)
	{
		if($key!="btnDo") 
		$data[$key]=$value;
	}
	//$data['urlcode'] = $mydb->clean4urlcode($_POST['name']);
	
	if(isset($_FILES['filename']['name']) && $_FILES['filename']['size']>0)
	{
		//ready to upload
		$filename = rand(1111,9999).$mydb->clean4imagecode($_FILES['filename']['name']);
		$source = $_FILES['filename']['tmp_name'];
		$dest = '../img/team/'.$filename;
		if(copy($source,$dest))
		{	
			$data['filename'] = $filename;
		}
	}	
	
	$message = $mydb->updateQuery('tbl_team',$data,'id='.$gid);
	
	$url = ADMINURLPATH."team_manage&id=".$gid."&message=".$message;
	$mydb->redirect($url);
}
$rasTeam = $mydb->getArray('*','tbl_team','id='.$gid);
?>
<form action="" method="post" enctype="multipart/form-data" name="MemberInsert" onSubmit="return call_validate(this,0,this.length);">
  <table cellpadding="2" cellspacing="0" border="0" width="100%" class="FormTbl">
	<tr class="TitleBar">
      <td class="TtlBarHeading" colspan="2"><?php echo $do;?> Member</td>
    </tr>		
	<?php if(isset($_GET['message'])){?>
	<tr>
	  <td colspan="2" class="message"><?php echo $_GET['message']; ?></td>
	</tr>
	<?php } ?>    
	<tr>
	  <td align="right" class="TitleBarA"><strong>Photo:</strong></td>
	  <td class="TitleBarA"><?php if(isset($rasTeam['filename']) && !empty($rasTeam['filename'])){?><img src="../img/team/<?php echo $rasTeam['filename'];?>" width="120" /><br /><?php }?><input type="file" name="filename" id="filename" class="inputBox" />
      <strong>Note:</strong>Image Size should be in the ratio of 235px X 315px.</td>
    </tr>
	<tr>
	  <td width="17%" align="right" class="TitleBarA"><strong>Member name : </strong></td>
	  <td class="TitleBarA"><input name="name" id="name" type="text" value="<?php echo $rasTeam['name'];?>" class="inputBox" style="width:50%"/></td>
	</tr>
	<tr>
	  <td align="right" class="TitleBarA"><strong>Post :</strong></td>
	  <td class="TitleBarA"><input name="position" id="position" type="text" value="<?php echo $rasTeam['position'];?>" class="inputBox" style="width:50%"/></td>
    </tr>
    <tr>
	  <td align="right" class="TitleBarA"><strong>Experience :</strong></td>
	  <td class="TitleBarA"><input name="experience" id="experience" type="text" value="<?php echo $rasTeam['experience'];?>" class="inputBox" style="width:50%"/></td>
    </tr>
	<tr>
	  <td align="right" class="TitleBarA"><strong>Contact No.: </strong></td>
	  <td class="TitleBarA"><input name="contact" id="contact" type="text" value="<?php echo $rasTeam['contact'];?>" class="inputBox" style="width:50%"/></td>
    </tr>
	<tr>
	  <td align="right" class="TitleBarA"><strong>Address : </strong></td>
	  <td class="TitleBarA"><input name="address" id="address" type="text" value="<?php echo $rasTeam['address'];?>" class="inputBox" style="width:50%"/></td>
    </tr>
	<tr>
	  <td align="right" class="TitleBarA"><strong>Email : </strong></td>
	  <td class="TitleBarA"><input name="email" id="email" type="text" value="<?php echo $rasTeam['email'];?>" class="inputBox" style="width:50%"/></td>
    </tr>
	
	<tr>
	  <td align="right" class="TitleBarA"><strong>Description : </strong></td>
	  <td class="TitleBarA"><?php
// Automatically calculates the editor base path based on the _samples directory.
// This is usefull only for these samples. A real application should use something like this:
// $oFCKeditor->BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.
$contents = stripslashes($rasTeam['contents']);
include("fckeditor/fckeditor.php") ;
//$sBasePath = $_SERVER['PHP_SELF'] ;
//$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "tadmin" ) ) ;

$sBasePath = 'fckeditor/';

$oFCKeditor = new FCKeditor('contents') ;
$oFCKeditor->BasePath = $sBasePath ;

//$oFCKeditor->Config['SkinPath'] = $sBasePath.'editor/skins/office2003/';
//$oFCKeditor->Config['SkinPath'] = $sBasePath . 'editor/skins/' . preg_replace("/[^a-z0-9]/i", "", 'office2003') . '/' ;
$oFCKeditor->Width = '100%' ;
$oFCKeditor->Height = '350px' ;
$oFCKeditor->Value = $contents ;
$oFCKeditor->Create() ;
?></td>
    </tr>
	<tr>
	  <td align="right" class="TitleBarA">&nbsp;</td>
	  <td class="TitleBarA" style="padding-bottom:15px;"><input name="btnDo" type="submit" value="<?php echo $do;?>" class="button" /></td>
	</tr>
  </table>
</form>