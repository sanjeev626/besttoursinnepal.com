<script type="text/javascript">
 function callDelete(gid)
 {
	if(confirm('Are you sure to delete ?'))
	{
	window.location='?manager=team&did='+gid;
	}
 }
</script>

<?php
if(isset($_POST['btnUpdate']))
{
	$count = count($_POST['eid']);
	for($i=0;$i<$count;$i++)
	{
		$eid = $_POST['eid'][$i];
		$data='';
		$data['ordering'] = $_POST['ordering'][$i];
					
		$mydb->updateQuery('tbl_team',$data,'id='.$eid);
	}
}

if(isset($_GET['did']))
{
	$delId = $_GET['did'];
	$imagename = $mydb->getValue('filename','tbl_team','id='.$delId);
	$imagepath = "../img/team/".$imagename;		
	@unlink($imagepath);
	
	$mydb->deleteQuery('tbl_image','gid='.$delId);	
	$mess = $mydb->deleteQuery('tbl_team','id='.$delId);
}



$result = $mydb->getQuery('*','tbl_team','1 ORDER BY ordering');
$count = mysql_num_rows($result);
?>
<form action="" method="post" name="tbl_entrepreneurspitchOrdering">
  <table cellpadding="0" cellspacing="0" border="0" width="100%" class="FormTbl" style="font-size:12px;">

    <tr class="TitleBar">
      <td colspan="3" class="TtlBarHeading">Manage Member<div style="float:right"></div></td>
      <td class="TtlBarHeading" style="width:50px;"><input name="btnAdd" type="button" value="Add" class="button" onClick="window.location='<?php echo ADMINURLPATH;?>team_manage'" /></td>
    </tr>
  	<?php if(isset($_GET['message'])){?>
	<tr>
	  <td colspan="4" class="message"><?php echo $_GET['message']; ?></td>
	</tr>
	<?php } ?>    
    <?php
	if($count != 0)
	{
	?>
    <tr>
	  <td width="2%" valign="top" class="titleBarB" align="center"><strong>Order</strong></td>
	  <td class="titleBarB"><strong>Name</strong></td>
	  <td width="10%" class="titleBarB"><strong>Image</strong></td>
	  <td width="8%" class="titleBarB">&nbsp;</td>
	</tr>
	<?php
		$counter = 0;
		while($rasTeam = $mydb->fetch_array($result))
		{
		$gid = $rasTeam['id'];
		?>
	<tr>
	  <td class="titleBarA" align="center" valign="top"> <input name="eid[]" type="hidden" id="eid[]" value="<?php echo $rasTeam['id'];?>" />
      <input type="text" name="ordering[]" id="ordering[]" value="<?php echo $rasTeam['ordering'];?>" style="width:30px;" /></td>
	  <td class="titleBarA" valign="top"><?php echo stripslashes($rasTeam['name']);?></td>
	  <td class="titleBarA" valign="top"><img src="../img/team/<?php echo $rasTeam['filename'];?>" height="100" /></td>
	  <td class="titleBarA" valign="top" align="center"><a href="<?php echo ADMINURLPATH;?>team_manage&id=<?php echo $rasTeam['id'];?>"><img src="images/action_edit.gif" alt="Edit" width="24" height="24" title="Edit"></a> <a href="javascript:void(0);" onclick="callDelete('<?php echo $gid;?>')"><img src="images/action_delete.gif" alt="Delete" width="24" height="24" title="Delete"></a></td>
	</tr>
	
<?php
}
?>
	<tr>
	  <td class="titleBarA" align="center" valign="top"><input type="submit" name="btnUpdate" id="btnUpdate" value="Save" class="button" /></td>
	  <td class="titleBarA" valign="top">&nbsp;</td>
	  <td class="titleBarA" valign="top">&nbsp;</td>
	  <td class="titleBarA" valign="top" align="center">&nbsp;</td>
    </tr>
<?php
		}
		else
		{
		?>
    <tr>

      <td class="message" colspan="4">No member has been Added</td>
   	</tr>
    <?php
		}
		?>
  </table>
</form>