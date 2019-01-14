<?php
if(isset($_GET['tid']))
{
	$btn = "btnUpdate";
	$do = "Update";
	$tid = $_GET['tid'];
}
else
{
	$btn = "btnAdd";
	$do = "Add";
	$tid = 0;
}

if (isset($_POST['btnAdd']))
{
	$data="";
	$data['ordering'] = $mydb->getValue('ordering','tbl_testimonial','1 ORDER BY ordering DESC LIMIT 1')+1;
	$data['package'] = $_POST['package'];
	$data['name'] = $_POST['name'];
	$data['address'] = $_POST['address'];
	$data['date'] = $_POST['date'];
	$data['contents'] = $_POST['contents'];
	$data['title'] = $_POST['title'];	
	
	$imagesize = $_FILES['filename']['size'];
	if($imagesize>0)
	{		
		$filename = rand(1111,9999).$mydb->clean4imagecode(($_FILES['filename']['name']));
		$source = $_FILES['filename']['tmp_name'];
		$dest = '../img/testimonial/'.$filename;
		if(copy($source,$dest))
		{
			$data['filename'] = $filename;
		}
	}
	
	$tid = $mydb->insertQuery('tbl_testimonial',$data);
	$url = ADMINURLPATH."testimonial&message=New testimonial Added successfully.";
	$mydb->redirect($url);
}

if (isset($_POST['btnUpdate']))
{
	$data="";
	$data['package'] = $_POST['package'];
	$data['name'] = $_POST['name'];
	$data['address'] = $_POST['address'];
	$data['date'] = $_POST['date'];
	$data['title'] = $_POST['title'];
	$data['contents'] = $_POST['contents'];
	//$data['date'] = $_POST['date'];	
	
	$imagesize = $_FILES['filename']['size'];
	if($imagesize>0)
	{		
		$filename = rand(1111,9999).$mydb->clean4imagecode(($_FILES['filename']['name']));
		$source = $_FILES['filename']['tmp_name'];
		$dest = '../img/testimonial/'.$filename;
		if(copy($source,$dest))
			{
			$data['filename'] = $filename;
		}
	}
	
	$tid = $mydb->updateQuery('tbl_testimonial',$data,'id='.$tid);
	$url = ADMINURLPATH."testimonial&message=testimonial updated successfully.";
	$mydb->redirect($url);
}

if(isset($_POST['btnSave']))
{
	for($i=0;$i<count($_POST['tid']);$i++)
	{
		$data='';
		$tid = $_POST['tid'][$i];
		$data['ordering'] = $_POST['ordering'][$i];
		$mydb->updateQuery('tbl_testimonial',$data,'id='.$tid);
	}
	$url = ADMINURLPATH."testimonial&message=Testimonial ordering updated successfully.";
	$mydb->redirect($url);
}

if(isset($_GET['did']))
{
	$did = $_GET['did'];
	$mydb->deleteQuery('tbl_testimonial','id='.$did);
	$url = ADMINURLPATH."testimonial&message=Selected testimonial deleted successfully.";
	$mydb->redirect($url);
}

?>
<script type="text/javascript">
	function DeleteData(deleteurl)
	{
		if(confirm('Are you sure to delete this testimonial? The process is irreversible.'))
		{
			window.location=deleteurl;
		}
	}
</script>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="FormTbl">
  <tr>
    <td>
    <form action="" method="post">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="FormTbl" style="font-size:12px;">
        <tr class="TitleBar">
          <td class="TtlBarHeading" colspan="5">Testimonial</td>
        </tr>
        <?php if(isset($_GET['message'])){?>
        <tr>
          <td colspan="5" class="message"><?php echo $_GET['message']; ?></td>
        </tr>
        <?php } ?>
        <?php
		$counter=0;		
		$resTest = $mydb->getQuery('*','tbl_testimonial','1 ORDER BY ordering ASC');
		while($rasTest=$mydb->fetch_array($resTest))
		{
		$id = $rasTest['id'];
		?>
        <tr class="TitleBarB">
          <td style="width:10px; vertical-align:top;"><input name="ordering[]" type="text" value="<?php echo $rasTest['ordering']; ?>" style="width:40px;" /><input name="tid[]" type="hidden" value="<?php echo $rasTest['id']; ?>" /></td>
          <td><?php echo stripslashes($rasTest['contents']);?></td>
          <td style="width:120px; vertical-align:top;"><?php echo 'By : '.$rasTest['name'];?></td>
          <?php /*?><td><?php echo 'on '.$rasTest['test_date'];?></td><?php */?>
          <td style="width:50px; vertical-align:top;"><a href="<?php echo ADMINURLPATH;?>testimonial&tid=<?php echo $rasTest['id']; ?>"><img src="images/action_edit.gif" alt="Edit" width="24" height="24" title="Edit"></a><a href="javascript:void(0);" onclick="DeleteData('<?php echo ADMINURLPATH.'testimonial&did='.$id;?>');"><img src="images/action_delete.gif" alt="Delete" width="24" height="24" title="Delete"></a></td>
        </tr>
        <?php
		}
		?>
        <tr class="TitleBarB">
          <td style="width:10px;"><input type="submit" name="btnSave" id="btnSave" value="Save" class="button" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td style="width:50px;">&nbsp;</td>
        </tr>
      </table>
    </form>  
    </td>
  </tr>
  <tr>
    <td><?php
	 //echo $tid;
	 $rasTest = $mydb->getArray('*','tbl_testimonial','id='.$tid);
	 ?>
      <form  name="form1" method="post" action="" enctype="multipart/form-data" class="AdvancedForm">
        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="FormTbl">
          <tr class="TitleBar">
            <td class="TtlBarHeading" colspan="3"><?php echo $do;?> Testimonial</td>
          </tr>
          <tr class="TitleBarB">
            <td width="15%"><strong>Package :</strong></td>
            <td>
            <select name="package" id="package"  class="inputBox">
            <option value="0" disabled="disabled">Select package</option>
            <?php
			$pid = $rasTest['package'];
			$resPackage = $mydb->getQuery('id,title','tbl_package','1 ORDER BY title');
			while($rasPackage=$mydb->fetch_array($resPackage))
			{
			?>
            <option value="<?php echo $rasPackage['id'];?>" <?php if($rasPackage['id']==$pid) echo 'selected';?> ><?php echo $rasPackage['title'];?></option>
            <?php
			}
			?>
            </select></td>
          </tr>
          <tr class="TitleBarB">
            <td><strong>Name :</strong></td>
            <td><input type="text" name="name" id="name" value="<?php echo stripslashes($rasTest['name']);?>" class="inputBox" /></td>
          </tr>
          <tr class="TitleBarB">
            <td><strong>Address :</strong></td>
            <td><input type="text" name="address" id="address" value="<?php echo stripslashes($rasTest['address']);?>" class="inputBox" /></td></tr>
          <tr class="TitleBarB">
            <td><strong>Title :</strong></td>
            <td><input type="text" name="title" id="title" value="<?php echo stripslashes($rasTest['title']);?>" class="inputBox" /></td></tr>
          <tr class="TitleBarB">
            <td><strong>Visited On :</strong></td>
            <td><input type="text" name="date" id="date" value="<?php echo stripslashes($rasTest['date']);?>" class="inputBox" /></td>
          </tr>
          <tr class="TitleBarB">
            <td><strong>Content:</strong></td>
            <td><?php /*?><textarea name="contents" cols="" rows="10" style="width:50%"><?php echo stripslashes($rasTest['contents']);?></textarea><?php */?>
              <?php
			  	$contents = stripslashes($rasTest['contents']);
				include("fckeditor/fckeditor.php") ;
				
				$sBasePath = 'fckeditor/';
				
				$oFCKeditor = new FCKeditor('contents') ;
				$oFCKeditor->BasePath = $sBasePath ;
				$oFCKeditor->Width = '100%' ;
				$oFCKeditor->Height = '350px' ;
				$oFCKeditor->Value = $contents ;
				$oFCKeditor->Create() ;
				?>
            </td>
          </tr>
          <tr class="TitleBarB">
          	<td><strong>Image:</strong></td>
            <td><?php if(isset($rasTest['filename']) && !empty($rasTest['filename'])){?><img src="../img/testimonial/<?php echo $rasTest['filename'];?>" width="150" /><br /><?php }?><input type="file" class="inputBox" name="filename" /> 
            <strong>Note:</strong>Image Size should be in the ratio of 650px X 342px.</td>
            </tr>
          <?php /*?><tr class="TitleBarA">
            <td><strong>Date:</strong></td>
            <td><input type="text" name="test_date" id="test_date" value="<?php echo stripslashes($rasTest['test_date']);?>" class="inputBox" /></td>
          </tr><?php */?>
          <tr>
            <td>&nbsp;</td>
            <td><input name="<?php echo $btn;?>" type="submit" value="<?php echo $do;?>" class="button" onMouseOut="this.className='button'" onMouseOver="this.className='button'" /></td>
          </tr>
        </table>
    </form></td>
  </tr>
</table>
