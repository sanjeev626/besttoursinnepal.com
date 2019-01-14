<?php
if(isset($_GET['nid']))
{
	$nid = $_GET['nid'];
	$do = "Update";
	$btn = "btnUpdate";
}
else
{
	$nid = 0;
	$do = "Add";
	$btn = "btnAdd";
}

if(isset($_POST['btnAdd']))
{
	$data='';
	$data['title'] = $_POST['title'];	
	$data['urlcode'] = $mydb->clean4urlcode($_POST['title']);
	$data['contents'] = $_POST['contents'];	
	$data['metatitle'] = $_POST['metatitle'];
	$data['metakeywords'] = $_POST['metakeywords'];
	$data['metadescription'] = $_POST['metadescription'];	
	$mess = $mydb->insertQuery('tbl_news',$data);
	
	$mydb->redirect(ADMINURLPATH."news_manage&msg=New News added Successfully.");
}

if(isset($_POST['btnUpdate']))
{
	$data='';
	$data['title'] = $_POST['title'];	
	$data['urlcode'] = $mydb->clean4urlcode($_POST['title']);
	$data['contents'] = $_POST['contents'];	
	$data['metatitle'] = $_POST['metatitle'];
	$data['metakeywords'] = $_POST['metakeywords'];
	$data['metadescription'] = $_POST['metadescription'];	
	$mess = $mydb->updateQuery('tbl_news',$data,'id='.$nid);
}

$rasNews = $mydb->getArray('*','tbl_news','id='.$nid);
?>
<form action="" method="post" name="pageEdit" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="FormTbl">
  <tr class="TitleBar">
    <td class="TtlBarHeading" colspan="4"><?php echo $do;?> News</td>
  </tr>
  <?php if(isset($mess)){?> 
  <tr>
    <td colspan="2" class="message"><?php echo $mess; ?></td>
  </tr> 
  <?php } ?>
  <tr>
    <td style="width:150px;"><strong> Title</strong></td>
    <td><input name="title" type="text" class="InputBox" value="<?php echo stripslashes($rasNews['title']); ?>" /></td>
  </tr>
  <tr>
    <td><strong>Contents</strong></td>
    <td><span class="TitleBarA">
      <?php
		$contents = stripslashes($rasNews['contents']);
		
		include("fckeditor/fckeditor.php") ;
		$sBasePath = 'fckeditor/';
		
		$oFCKeditor = new FCKeditor('contents') ;
		$oFCKeditor->BasePath = $sBasePath ;
		$oFCKeditor->Width = '100%' ;
		$oFCKeditor->Height = '350px' ;
		$oFCKeditor->Value = $contents ;
		$oFCKeditor->Create() ;
		?>
    </span></td>
  </tr>
  <tr>
    <td><strong>Meta Title</strong></td>
    <td><textarea name="metatitle" id="metatitle" cols="45" rows="5" style="width:100%"><?php echo stripslashes($rasNews['metatitle']);?></textarea></td>
  </tr>
  <tr>
    <td><strong>Meta Keywords</strong></td>
    <td><textarea name="metakeywords" id="metakeywords" cols="45" rows="5" style="width:100%"><?php echo stripslashes($rasNews['metakeywords']);?></textarea></td>
  </tr>
  <tr>
    <td><strong>Meta Description</strong></td>
    <td><textarea name="metadescription" id="metadescription" cols="45" rows="5" style="width:100%"><?php echo stripslashes($rasNews['metadescription']);?></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="<?php echo $btn;?>" id="<?php echo $btn;?>" value="<?php echo $do;?>" class="button" /></td>
  </tr>
</table>
</form>
