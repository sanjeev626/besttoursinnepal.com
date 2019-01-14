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
	
	$data['urlcode'] = $mydb->clean4urlcode($_POST['title']);	
	$data['ordering'] = $mydb->getValue('ordering','tbl_member','1 ORDER BY ordering DESC LIMIT 1')+1;	
	
	$imagesize = $_FILES['filename']['size'];
	if($imagesize>0)
	{		
		$filename = rand(1111,9999).$mydb->clean4urlcode(($_FILES['filename']['name']));
		$source = $_FILES['filename']['tmp_name'];
		$dest = '../im/member/'.$filename;
		if(copy($source,$dest))
		{
			$data['filename'] = $filename;
		}
	}		
	
	$gid = $mydb->insertQuery('tbl_member',$data);	

	if($gid>0)
	{
		$message = "New Member Has been added.";
	}
	else
	{
		$message = "ERROR!! Failed to add Member.";
	}
	
	$url = ADMINURLPATH."member_manage&message=".$message;
	$mydb->redirect($url);
}

if(isset($_POST['btnDo']) && $_POST['btnDo']=='Update')
{	
	foreach($_POST as $key=>$value)
	{
		if($key!="btnDo") 
		$data[$key]=$value;
	}
	$data['urlcode'] = $mydb->clean4urlcode($_POST['title']);
	
	if(isset($_FILES['filename']['name']) && $_FILES['filename']['size']>0)
	{
		//ready to upload
		$filename = rand(1111,9999).$mydb->clean4urlcode($_FILES['filename']['name']);
		$source = $_FILES['filename']['tmp_name'];
		$dest = '../im/member/'.$filename;
		if(copy($source,$dest))
		{	
			$data['filename'] = $filename;
		}
	}	
	
	$message = $mydb->updateQuery('tbl_member',$data,'id='.$gid);
	
	$url = ADMINURLPATH."member_manage&id=".$gid."&message=".$message;
	$mydb->redirect($url);
}
$rasMember = $mydb->getArray('*','tbl_member','id='.$gid);
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
	  <td class="TitleBarA"><?php if(isset($rasMember['filename']) && !empty($rasMember['filename'])){?><img src="../im/member/<?php echo $rasMember['filename'];?>" width="120" /><br /><?php }?><input type="file" name="filename" id="filename" class="inputBox" /></td>
    </tr>
	<tr>
	  <td width="17%" align="right" class="TitleBarA"><strong>Member name : </strong></td>
	  <td class="TitleBarA"><input name="title" id="title" type="text" value="<?php echo $rasMember['title'];?>" class="inputBox" style="width:100%"/></td>
	</tr>
	<tr>
	  <td align="right" class="TitleBarA"><strong>Post :</strong></td>
	  <td class="TitleBarA"><input name="memberposition" id="memberposition" type="text" value="<?php echo $rasMember['memberposition'];?>" class="inputBox" style="width:50%"/></td>
    </tr>
	<tr>
	  <td align="right" class="TitleBarA"><strong>Contact No.: </strong></td>
	  <td class="TitleBarA"><input name="contactno" id="contactno" type="text" value="<?php echo $rasMember['memberposition'];?>" class="inputBox" style="width:50%"/></td>
    </tr>
	<tr>
	  <td align="right" class="TitleBarA"><strong>Address : </strong></td>
	  <td class="TitleBarA"><input name="address" id="address" type="text" value="<?php echo $rasMember['address'];?>" class="inputBox" style="width:50%"/></td>
    </tr>
	<tr>
	  <td align="right" class="TitleBarA"><strong>Email : </strong></td>
	  <td class="TitleBarA"><input name="email" id="email" type="text" value="<?php echo $rasMember['email'];?>" class="inputBox" style="width:50%"/></td>
    </tr>
	<tr>
	  <td align="right" class="TitleBarA"><strong>Experience : </strong></td>
	  <td class="TitleBarA"><input name="experience" id="experience" type="text" value="<?php echo $rasMember['experience'];?>" class="inputBox" style="width:50%"/></td>
    </tr>
	<tr>
	  <td align="right" class="TitleBarA"><strong>Description : </strong></td>
	  <td class="TitleBarA"><?php
// Automatically calculates the editor base path based on the _samples directory.
// This is usefull only for these samples. A real application should use something like this:
// $oFCKeditor->BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.
$contents = stripslashes($rasMember['contents']);
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
	  <td align="right" class="TitleBarA"><strong>Member type:</strong></td>
	  <td class="TitleBarA" style="padding-bottom:15px;">
	    <select name="membertype" id="membertype" class="inputBox">
        	<option value="0" selected="selected">None</option>
            <?php
			$resMemtype = $mydb->getQuery('*','tbl_membertype');
			while($rasMemtype = $mydb->fetch_array($resMemtype))
			{
			?>
            <option value="<?php echo $rasMemtype['id'];?>" <?php if($rasMember['membertype']==$rasMemtype['id']) echo 'selected';?>><?php echo $rasMemtype['title'];?></option>
            <?php
			}
			?>
        </select>	  </td>
    </tr>
	<tr>
	  <td align="right" class="TitleBarA">&nbsp;</td>
	  <td class="TitleBarA" style="padding-bottom:15px;"><input name="btnDo" type="submit" value="<?php echo $do;?>" class="button" /></td>
	</tr>
  </table>
</form>