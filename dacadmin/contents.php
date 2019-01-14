<script type="text/javascript">
 function callDelete(cid,dprid)
 {
	if(confirm('Are you sure to delete ?'))
	{
		window.location='?manager=contents&cid='+cid+'&did='+dprid;
	}
 }
</script>
<?php
if(isset($_POST['btnsvOrder']))
{
	$count = count($_POST['pid']);
	for($i=0;$i<$count;$i++)
	{
		$productObj->updateOrdering($_POST['pid'][$i],$_POST['ordering'][$i]);
	}
}

if(isset($_GET['did']))
{
	$delId = $_GET['did'];
	$mess = $mydb->deleteQuery('tbl_contents','id='.$delId);
}

$cid = $_GET['cid'];
//$result = $productObj->getproductBycId($cid);
$result = $mydb->getQuery('*','tbl_contents','cid='.$cid);
$count = mysql_num_rows($result);
//if($count != 0)
{
?>
<div class="adminContent">
  <div class="adminContentinner">
	<form action="" method="post" name="productOrdering">
	  <table cellpadding="0" cellspacing="0" border="0" width="100%" class="FormTbl">
	  <tr class="TitleBar">
        <td class="TtlBarHeading" colspan="4"><?php echo $mydb->getValue('name','tbl_category','id='.$cid); ?> :: Content List<div style="float:right;"><input name="btnAddPro" type="button" value="Add Content" class="button" onMouseOut="this.className='button'" onMouseOver="this.className='button'" onclick="window.location='?manager=contents_manage&cid=<?php echo $cid;?>'" /></div></td>
      </tr>    
		<?php if(isset($_GET['message'])){?>
        <tr>
         <td colspan="4" class="message"><?php echo $_GET['message']; ?></td>
        </tr>
        <?php } ?> 
		<?php
		$cid = $_GET['cid'];
		$counter = 0;
		while($rasContent = $mydb->fetch_array($result))
		{
			if($counter%2==0) $trclass = "TitleBarA";
			else $trclass = "TitleBarB";
		?>
		<tr class="<?php echo $trclass;?>">
		  <td width="5%" align="center"><?php echo ++$counter;?></td>
		  <td width="150px;"><?php echo stripslashes($rasContent['contenttitle']);?></td>
		  <td><?php echo stripslashes($rasContent['contents']);?></td>
		  <td style="width:80px;"><a href="<?php echo ADMINURLPATH;?>contents_manage&cid=<?php echo $cid;?>&id=<?php echo $rasContent['id'];?>"><img src="images/action_edit.gif" alt="Edit" width="24" height="24" title="Edit"></a>&nbsp;<a href="" onclick="callDelete('<?php echo $cid;?>','<?php echo $rasContent['id'];?>');"><img src="images/action_delete.gif" alt="Delete" width="24" height="24" title="Delete"></a></td>
	    </tr>
		<?php
		}
		?>
	  </table>
	</form>
  </div>
</div>
<?php
}
?>