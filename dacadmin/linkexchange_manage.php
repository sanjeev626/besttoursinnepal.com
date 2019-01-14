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

if(isset($_POST['btnSubmit']) && $_POST['btnSubmit']=='Save')
{
	$data='';	
	$data['title'] = $_POST['title'];
	//$data['description'] = $_POST['description'];
	$data['urlcode'] = $mydb->clean4urlcode($_POST['title']);
	//$data['pagetitle'] = $_POST['pagetitle'];
	//$data['metakeywords'] = $_POST['metakeywords'];
	//$data['metadescription'] = $_POST['metadescription'];
	$mydb->updateQuery('tbl_linkexchange',$data,'id='.$id);
	$mydb->redirect(ADMINURLPATH."linkexchange&msg=1");
}

if(isset($_POST['btnSubmit']) && $_POST['btnSubmit']=='Add')
{
	$data='';
	$data['title'] = $_POST['title'];
	//$data['description'] = $_POST['description'];
	$data['urlcode'] = $mydb->clean4urlcode($_POST['title']);
	//$data['pagetitle'] = $_POST['pagetitle'];
	//$data['metakeywords'] = $_POST['metakeywords'];
	//$data['metadescription'] = $_POST['metadescription'];
	$mydb->insertQuery('tbl_linkexchange',$data);
	$mydb->redirect(ADMINURLPATH."linkexchange&cid=".$_GET['cid']."&msg=2");
}

$rasLinkexchange = $mydb->getArray('*','tbl_linkexchange','id='.$id);
?>
<form action="" method="post" name="frmPage" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="FormTbl">
  <tr class="TitleBar">
    <td colspan="2" class="TtlBarHeading"><?php echo $btnValue;?> Link Exchange</td>
  </tr>
  <?php if(isset($_GET['msg']) && $_GET['msg'] =='1'){ ?>
  <tr>
    <td colspan="2" class="adminsucmsg">Link Exchange info has been updated.</td>
    </tr>
  <?php } ?>
  <tr>
    <td style="width:100px;"><strong>Titile :</strong></td>
    <td><input name="title" type="text" value="<?php echo $rasLinkexchange['title'];?>" class="inputbox"></td>
  </tr>
  <?php /*?><tr>
    <td><strong>Image :</strong></td>
    <td><?php $imagepath='../img/linkexchange/'.$rasLinkexchange['linkexchangeimage']; if(!empty($rasLinkexchange['linkexchangeimage']) && file_exists($imagepath)){?><img src="<?php echo $imagepath;?>" alt="Package Image" width="220px"><br/><?php }?><input type="file" name="linkexchangeimage" id="linkexchangeimage"></td>
  </tr><?php */?>
  <tr>
    <?php /*?><td><strong>Description : </strong></td>
    <td>
		<?php
		include("fckeditor/fckeditor.php") ;
		$description = stripslashes($rasLinkexchange['description']);
		
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
    <td><strong>Page Title :</strong></td>
    <td><textarea name="pagetitle" id="pagetitle" cols="45" rows="5" style="width:100%"><?php echo stripslashes($rasLinkexchange['pagetitle']);?></textarea></td>
  </tr>
  <tr>
    <td><strong>Meta Keywords :</strong></td>
    <td><textarea name="metakeywords" id="metakeywords" cols="45" rows="5" style="width:100%"><?php echo stripslashes($rasLinkexchange['metakeywords']);?></textarea></td>
  </tr>
  <tr>
    <td><strong>Meta Description :</strong></td>
    <td><textarea name="metadescription" id="metadescription" cols="45" rows="5" style="width:100%"><?php echo stripslashes($rasLinkexchange['metadescription']);?></textarea></td><?php */?>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="btnSubmit" id="btnSubmit" value="<?php echo $btnValue;?>" class="button" /></td>
  </tr>
</table>
</form>