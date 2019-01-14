<?php
if(isset($_GET['del_aid']))
{
	$did = $_GET['del_aid'];
	$mydb->deleteQuery('tbl_linkexchange_content','lid='.$did);
	$mydb->deleteQuery('tbl_linkexchange','id='.$did);
}


	$resLinkexchange = $mydb->getQuery('*','tbl_linkexchange');
	$count = mysql_num_rows($resLinkexchange);
	?>
	<form action="" method="post" name="Link Exchange">
	  <table cellpadding="0" cellspacing="0" border="0" width="100%" class="FormTbl" style="font-size:12px;">	
		<tr class="TitleBar">
		  <td colspan="4" class="TtlBarHeading">Manage Link Exchange <div style="float:right"><input name="btnAdd" type="button" value="Add" class="button" onClick="window.location='<?php echo ADMINURLPATH;?>linkexchange_manage'" /></div></td>
		</tr>
		<?php 
		if(isset($_GET['msg']) && $_GET['msg'] =='1'){ ?>
        <tr>
          <td colspan="4" class="adminsucmsg">Link Exchange info has been updated.</td>
          </tr>
        <?php 
		}
		if(isset($_GET['msg']) && $_GET['msg'] =='2'){ ?>
        <tr>
          <td colspan="4" class="adminsucmsg">New Link Exchange has been added.</td>
          </tr>
        <?php 
		}
		if(isset($_GET['del_aid'])){ ?>
        <tr>
          <td colspan="4" class="adminsucmsg">Selected Link Exchange has been deleted.</td>
          </tr>
        <?php 
		}
		if($count != 0)
		{
		?>
		<tr>
		  <td width="2%" valign="top" class="titleBarB" align="center"><strong>S.N</strong></td>
		  <td width="17%" class="titleBarB"><strong>Name</strong></td>
		  <td class="titleBarB"><strong>Description</strong></td>
		  <td width="11%" class="titleBarB">&nbsp;</td>
		</tr>
		<?php
		$counter = 0;
		while($rasLinkexchange = $mydb->fetch_array($resLinkexchange))
		{
		if($counter%2==0)
			$tdclass='titleBarA';
		else
			$tdclass='titleBarB';
		?>
		<tr>
		  <td class="<?php echo $tdclass;?>" align="center" valign="top"><?php echo ++$counter;?></td>
		  <td class="<?php echo $tdclass;?>" valign="top"><?php echo stripslashes($rasLinkexchange['title']);?></td>
		  <td class="<?php echo $tdclass;?>" valign="top"><?php echo stripslashes($rasLinkexchange['description']);?></td>
		  <td class="<?php echo $tdclass;?>" valign="top" align="center"><a href="<?php echo ADMINURLPATH;?>linkexchangecontent&lid=<?php echo $rasLinkexchange['id'];?>"><img src="images/link.png" alt="Link" width="24" height="24" title="Link"></a> <a href="<?php echo ADMINURLPATH;?>linkexchange_manage&id=<?php echo $rasLinkexchange['id'];?>"><img src="images/action_edit.gif" alt="Edit" width="24" height="24" title="Edit"></a> <a href="javascript:void(0);" onClick="callDelete('<?php echo ADMINURLPATH;?>linkexchange&del_aid=<?php echo $rasLinkexchange['id'];?>')"><img src="images/action_delete.gif" alt="Delete" width="24" height="24" title="Delete"></a></td>
		</tr>		
		<?php
        }
		}
		?>
  	  </table>
	</form>
	