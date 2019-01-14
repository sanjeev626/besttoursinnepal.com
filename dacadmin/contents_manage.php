<script type="text/javascript">
	function selfiletype(val)
	{
		if(val=='image')
		{
			document.getElementById('imagetype').style.display='block';
			document.getElementById('videotype').style.display='none';
		}
		if(val=='video')
		{
			document.getElementById('imagetype').style.display='none';
			document.getElementById('videotype').style.display='block';
		}
	}
</script>
<script type="text/javascript">
/* <![CDATA[ */
jQuery(function(){
	jQuery("#name").validate({
		expression: "if (VAL) return true; else return false;",
		message: "Name is Required field"
	});
	jQuery("#price").validate({
		expression: "if (!isNaN(VAL) && VAL) return true; else return false;",
		message: "Please enter a valid price."
	});
	jQuery("#weight").validate({
		expression: "if (!isNaN(VAL) && VAL) return true; else return false;",
		message: "Please enter a valid weight."
	});	
	jQuery('.AdvancedForm').validated(function(){
		document.frmProfile.submit();
	});
});
/* ]]> */
</script>
<?php
include("../classes/category.class.php");
//for breadcrumb

if(isset($_GET['id']))
{
	$pid = $_GET['id'];
	$do = "Update";
}
else
{
	$pid = 0;
	$do = "Add";
}

$cid = $_GET['cid'];


if(isset($_POST['btnDo']) && $_POST['btnDo']=='Add')
{
	//print_r($data);
	$cid = $_GET['cid'];
	$data['cid']=$cid;
	
	foreach($_POST as $key=>$value)
	{
		if($key!="btnDo") 
		$data[$key]=$value;
	}
	
	$data['urlcode'] = $mydb->clean4urlcode(trim($_POST['contenttitle']));
	
	$pid = $mydb->insertQuery('tbl_contents',$data);	

	if($pid>0)
	{		
		$message = "New contents Has been added.";
	}
	
	$url = ADMINURLPATH."contents&cid=".$cid."&message=".$message;
	$mydb->redirect($url);
}

if(isset($_POST['btnDo']) && $_POST['btnDo']=='Update')
{	
	foreach($_POST as $key=>$value)
	{
		if($key!="btnDo") 
		$data[$key]=$value;
	}
	$data['urlcode'] = $mydb->clean4urlcode(trim($_POST['contenttitle']));
	//print_r($data);
	$message = $mydb->updateQuery('tbl_contents',$data,'id='.$pid);	
	
	$url = ADMINURLPATH."contents&cid=".$cid."&message=".$message;
	$mydb->redirect($url);
}
$rascontents = $mydb->getArray('*','tbl_contents','id='.$pid);
$contents = stripslashes($rascontents['contents']);
?>
	<form action="" method="post" enctype="multipart/form-data" name="contentsInsert" onSubmit="return call_validate(this,0,this.length);">
	  <table cellpadding="2" cellspacing="0" border="0" width="100%" class="FormTbl">
	  
		<tr class="TitleBar">
        <td class="TtlBarHeading" colspan="2"><?php echo $do;?> contents :: <?php echo $mydb->getValue('name','tbl_category','id='.$cid); ?></td>
      </tr>		
		<?php if(isset($_GET['message'])){?>
		<tr>
		  <td colspan="2" class="message"><?php echo $_GET['message']; ?></td>
		</tr>
		<?php } ?>
		<tr>
		  <td width="17%" align="right" class="TitleBarA"><strong>Title : </strong></td>
		  <td class="TitleBarA"><input name="contenttitle" id="contenttitle" type="text" value="<?php echo $rascontents['contenttitle'];?>"/></td>
		</tr>
		<tr>
		  <td align="right" class="TitleBarA"><strong>Contents : </strong></td>
		  <td class="TitleBarA">
		  <?php
			include("fckeditor/fckeditor.php") ;			
			$sBasePath = 'fckeditor/';			
			$oFCKeditor = new FCKeditor('contents') ;
			$oFCKeditor->BasePath = $sBasePath ;
			$oFCKeditor->Width = '100%' ;
			$oFCKeditor->Height = '500px' ;
			$oFCKeditor->Value = $contents ;
			$oFCKeditor->Create() ;
		   ?>
           </td>
		</tr>
		<tr>
		  <td align="right">&nbsp;</td>
		  <td style="padding-bottom:15px;"><input name="btnDo" type="submit" value="<?php echo $do;?>" class="button" /></td>
		</tr>
	  </table>
</form>