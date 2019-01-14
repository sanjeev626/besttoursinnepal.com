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
<script type="text/javascript">
	function callDeleteImage(id)
	{
		if(confirm('Are you sure to delete this image?'))
		{
			window.locaion='index.php?manager=package_manage&id=<?php echo $id;?>&delImid='+id;
		}
	}
</script>
<?php
	
/* generate refresh link*/	

if(isset($_GET['lid']))
{
	$lid = $_GET['lid'];
	$refreshlink='&lid='.$lid;
}

if(isset($_GET['delImid']))
{
	$imid = $_GET['delImid'];
	$imagename = $mydb->getValue('imagename','tbl_linkexchange_contentimage','id='.$imid);
	$unlink = '../img/package/'.$imagename;
	@unlink($unlink);
	$mydb->deleteQuery('tbl_linkexchange_contentimage','id='.$imid);
}

if(isset($_POST['btnSubmit']) && $_POST['btnSubmit']=='Update')
{	
	$lid = $_POST['lid'];
	$data='';	
	foreach($_POST as $key=>$value)
	{
		if($key!='btnSubmit')
			$data[$key]=$value;
	}
	$data['urlcode'] = $mydb->clean4urlcode($_POST['title']);
	
	$mydb->updateQuery('tbl_linkexchange_content',$data,'id='.$id);
	$mydb->redirect(ADMINURLPATH."linkexchangecontent&lid=".$lid."&msg=1");
}

if(isset($_POST['btnSubmit']) && $_POST['btnSubmit']=='Add')
{
	$lid = $_POST['lid'];
	$data='';
		
	foreach($_POST as $key=>$value)
	{
		if($key!='btnSubmit')
			$data[$key]=$value;
	}
	$data['urlcode'] = $mydb->clean4urlcode($_POST['title']);
	$mydb->insertQuery('tbl_linkexchange_content',$data,'id='.$id);
	$mydb->redirect(ADMINURLPATH."linkexchangecontent&lid=".$lid."&msg=2");
}
include("fckeditor/fckeditor.php") ;
$rasPackage = $mydb->getArray('*','tbl_linkexchange_content','id='.$id);
if(isset($_GET['lid']))
	$lid = $_GET['lid'];
else
	$lid = $rasPackage['lid'];
?>
<form action="" method="post" enctype="multipart/form-data" name="frmPage">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="FormTbl">
  <tr class="TitleBar">
    <td colspan="3" class="TtlBarHeading"><?php echo $btnValue;?> Link Content<div style="float:right">
      <input type="button" name="btnList" id="btnList" value="List" class="button" onClick="window.location='<?php echo ADMINURLPATH;?>linkexchangecontent&lid=<?php echo $lid;?>'" />
      <input type="submit" name="btnSubmit" id="btnSubmit" value="<?php echo $btnValue;?>" class="button" /></div></td>
  </tr>
  <?php if(isset($_GET['msg']) && $_GET['msg'] =='1'){ ?>
  <tr>
    <td colspan="3" class="adminsucmsg"><span class="TtlBarHeading">Link Content</span> info has been updated.</td>
    </tr>
  <?php } ?>
  <tr>
    <td class="TitleBarA" width="170"><strong>Link title</strong></td>
    <td width="100" colspan="2" class="TitleBarA">
    	<select name="lid" id="lid" class="inputbox">
        <option value="0">None</option>
		<?php
        $counter = 0;
        $resActivity = $mydb->getQuery('*','tbl_linkexchange');
        while($rasLinkexchange = $mydb->fetch_array($resActivity))
        {
        ?>
        <option value="<?php echo $rasLinkexchange['id'];?>" <?php if($rasLinkexchange['id']==$lid) echo 'selected';?>><?php echo $rasLinkexchange['title'];?></option>
        <?php
		}
		?>
        </select>    </td>
  </tr>
  <tr>
    <td class="TitleBarA"><strong>Title</strong></td>
    <td colspan="2" class="TitleBarA"><input name="title" type="text" value="<?php echo $rasPackage['title'];?>" class="inputbox"></td>
  </tr>
  <tr>
    <td class="TitleBarA"><strong>Link URL</strong></td>
    <td colspan="2" class="TitleBarA"><input name="url" type="url" value="<?php echo $rasPackage['url'];?>" class="inputbox"></td>
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
    <td class="TitleBarA">&nbsp;</td>
    <td colspan="2" class="TitleBarA"><input type="submit" name="btnSubmit" id="btnSubmit" value="<?php echo $btnValue;?>" class="button" /></td>
  </tr>
</table>
</form>