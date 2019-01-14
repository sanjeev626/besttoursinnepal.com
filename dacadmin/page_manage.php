<?php
$pid = $_GET['pid'];

if(isset($_POST['btnSave']))
{
	$data='';
	$data['contents'] = $_POST['contents'];	
	$data['pagetitle'] = $_POST['pagetitle'];
	$data['metakeywords'] = $_POST['metakeywords'];
	$data['metadescription'] = $_POST['metadescription'];
	
	if(isset($_FILES['pageimage']['name']) && $_FILES['pageimage']['size']>0)
	{
		$imagename = $_FILES['pageimage']['name'];
		$tmp_name=$_FILES['pageimage']['tmp_name'];
		$imagepath='../img/page/';
		$thumbpath='../img/page/thumb/';		
		$pageimage = $mydb->UploadImage($imagename,$tmp_name,$imagepath,$thumbpath);
		$data['pageimage'] = $pageimage;
	}
	
	$mess = $mydb->updateQuery('tbl_page',$data,'id='.$pid);
}

$rasPage = $mydb->getArray('*','tbl_page','id='.$pid);
?>
<br />
<form action="" method="post" name="pageEdit" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="FormTbl">
  <tr class="TitleBar">
    <td class="TtlBarHeading" colspan="4">Update Page</td>
  </tr>
  <?php if(isset($mess)){?> 
  <tr>
    <td colspan="2" class="message"><?php echo $mess; ?></td>
  </tr> 
  <?php } ?>
  <tr>
    <td><strong>Page Title</strong></td>
    <td><?php echo $rasPage['title']; ?></td>
  </tr>
  <?php if($rasPage['tlocation']=='4'){ ?>
  <tr>
    <td><strong>Page Image</strong></td>
    <td><?php $imagepath='../img/page/'.$rasPage['pageimage']; if(!empty($rasPage['pageimage']) && file_exists($imagepath)){?><img src="<?php echo $imagepath;?>" alt="Page Image" width="220px"><br/><?php }?><input type="file" name="pageimage" id="pageimage"></td>
  </tr>
  <?php } ?>
  <tr>
    <td><strong>Contents</strong></td>
    <td>
    	<?php
		$contents = stripslashes($rasPage['contents']);
		include_once SITEROOTDOC.'admin/editor/ckeditor/ckeditor.php';
		include_once SITEROOTDOC.'admin/editor/ckfinder/ckfinder.php';
		
		$ckeditor = new CKEditor();
		$ckfinder = new CKFinder();
		
		$ckeditor->basePath = SITEROOT.'admin/editor/ckeditor/';
		$ckeditor->enterMode = 'CKEDITOR.ENTER_BR';
		$ckfinder->BasePath = SITEROOT.'admin/editor/ckfinder/'; 
		
		$ckfinder->SetupCKEditorObject($ckeditor);
		
		$config = array();
		$config['uiColor'] 	= '#AEAEAE';
		$config['height'] 	= '300';
		//$config['width'] 	= '200';
		$ckeditor -> editor('contents', $contents, $config);
		?>
        <?php
		/*	//echo SITEROOT.'fckeditor/';
                include ("../fckeditor/fckeditor.php");
                $oFCKeditor = new FCKeditor('contents') ;
                $oFCKeditor->BasePath = SITEROOT.'fckeditor/' ;
                $oFCKeditor->Height = '400';
                $oFCKeditor->Width = '100%';
                $oFCKeditor->Value = stripslashes($rasPage['contents']);
                $oFCKeditor->Create() ;
		*/
            ?></td>
  </tr>
  <tr>
    <td><strong>Page Title</strong></td>
    <td><textarea name="pagetitle" id="pagetitle" cols="45" rows="5" style="width:100%"><?php echo stripslashes($rasPage['pagetitle']);?></textarea></td>
  </tr>
  <tr>
    <td><strong>Meta Keywords</strong></td>
    <td><textarea name="metakeywords" id="metakeywords" cols="45" rows="5" style="width:100%"><?php echo stripslashes($rasPage['metakeywords']);?></textarea></td>
  </tr>
  <tr>
    <td><strong>Meta Description</strong></td>
    <td><textarea name="metadescription" id="metadescription" cols="45" rows="5" style="width:100%"><?php echo stripslashes($rasPage['metadescription']);?></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="btnSave" id="btnSave" value="Save" class="button" /></td>
  </tr>
</table>
</form>
