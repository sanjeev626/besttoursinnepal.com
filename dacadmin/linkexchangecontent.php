<?php
if(isset($_GET['del_pid']))
{
	$did = $_GET['del_pid'];	
	$mydb->deleteQuery('tbl_linkexchange_content','id='.$did);
}
if(isset($_POST['btnSave']))
{
	for($i=0;$i<count($_POST['pid']);$i++)
	{
		$pid = $_POST['pid'][$i];
		$data='';
		$data['ordering'] = $_POST['ordering'][$i];
		$mydb->updateQuery('tbl_package',$data,'id='.$pid);
	}
}

$id = $_GET['lid'];

$resLinkcontent = $mydb->getQuery('*','tbl_linkexchange_content',"lid=".$id);
$count = mysql_num_rows($resLinkcontent);
?>
<form action="" method="post" name="Link Contents">
  <table cellpadding="0" cellspacing="0" border="0" width="100%" class="FormTbl" style="font-size:12px;">	
	<tr class="TitleBar">
	  <td colspan="4" class="TtlBarHeading">Link Contents List <?php if(isset($_GET['lid'])){ $lid = $_GET['lid']; echo 'for '.$mydb->getValue('title','tbl_linkexchange','id='.$lid);}?><div style="float:right"><input name="btnAdd" type="button" value="Add" class="button" onClick="window.location='<?php echo ADMINURLPATH;?>linkexchangecontent_manage&lid=<?php echo $id;?>'" /></div></td>
	</tr>
	<?php 
		if(isset($_GET['msg']) && $_GET['msg'] =='1'){ ?>
    <tr>
      <td colspan="4" class="adminsucmsg">Link Contents info has been updated.</td>
      </tr>
    <?php 
		}
		if(isset($_GET['msg']) && $_GET['msg'] =='2'){ ?>
    <tr>
      <td colspan="4" class="adminsucmsg">New Link Contents has been added.</td>
      </tr>
    <?php 
		}
		if(isset($_GET['del_pid'])){ ?>
    <tr>
      <td colspan="4" class="adminsucmsg">Selected Link Contents has been deleted.</td>
      </tr>
    <?php 
		}
		if($count != 0)
		{
		?>
	<tr>
	  <td width="2%" valign="top" class="titleBarB" align="center"><strong>S.N</strong></td>
	  <td width="22%" class="titleBarB"><strong>Name</strong></td>
	  <td class="titleBarB"><strong>Description</strong></td>
	  <td width="10%" class="titleBarB">&nbsp;</td>
	</tr>
	<?php
		$counter = 0;
		while($rasLinkcontent = $mydb->fetch_array($resLinkcontent))
		{
		?>
	<tr>
	  <td class="titleBarA" align="center"><?php echo ++$counter;?></td>
	  <td class="titleBarA"><?php echo stripslashes($rasLinkcontent['title']);?></td>
	  <td class="titleBarA"><?php echo substr(stripslashes($rasLinkcontent['description']),0,130);?></td>
	  <td class="titleBarA" align="center"><a href="<?php echo ADMINURLPATH;?>linkexchangecontent_manage&id=<?php echo $rasLinkcontent['id'];?>"><img src="images/action_edit.gif" alt="Edit" width="24" height="24" title="Edit"></a> <a href="javascript:void(0);" onClick="callDelete('<?php echo ADMINURLPATH;?>linkexchangecontent&lid=<?php echo $id;?>&del_pid=<?php echo $rasLinkcontent['id'];?>')"><img src="images/action_delete.gif" alt="Delete" width="24" height="24" title="Delete"></a></td>
	</tr>		
	<?php
        }
		}
		?>
  </table>
</form>