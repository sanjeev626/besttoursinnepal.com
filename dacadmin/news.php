<?php
if(isset($_GET['del_nid'])){
	$del_nid = $_GET['del_nid'];
	$mydb->deleteQuery('tbl_news','id='.$del_nid);
	$redirect = ADMINURLPATH.'news&msg=Selected news has been deleted succcessfully.';
	$mydb->redirect($redirect);
}
$result = $mydb->getQuery('*','tbl_news','1 ORDER BY id DESC');
?>
  <table cellpadding="0" cellspacing="0" border="0" width="100%" class="FormTbl">
  <tr class="TitleBar">
    <td class="TtlBarHeading" colspan="4">News & Event List<div style="float:right"><input name="btnAdd" type="button" value="Add" class="button" onClick="window.location='<?php echo ADMINURLPATH;?>news_manage'" /></div></td>
  </tr>
  <?php
  if(isset($_GET['msg']))
  { 
  ?>
    <tr>
      <td colspan="4" class="adminsucmsg"><?php echo $_GET['msg'];?></td>
    </tr>
   <?php 
   }
  
$count = mysql_num_rows($result);
if($count != 0)
{
?>
    <tr>
      <td width="5%" align="center" class="TitleBarB"><strong>S.N</strong></td>
      <td width="20%" class="TitleBarB"><strong>News & Event Title</strong></td>
      <td class="TitleBarB"><strong>Contents</strong></td>
      <td width="10%" class="TitleBarB">&nbsp;</td>
    </tr>
    <?php
    $counter = 0;
    while($rasNews = $mydb->fetch_array($result))
    {
    ?>
    <tr>
      <td class="TitleBarA" align="center"><?php echo ++$counter;?></td>
      <td class="TitleBarA"><?php echo stripslashes($rasNews['title']);?></td>
      <td class="TitleBarA"><?php echo substr(stripslashes($rasNews['contents']),0,300); if(strlen(stripslashes($rasNews['contents']))>300) echo '...';?></td>
      <td class="TitleBarA" align="center"><a href="<?php echo ADMINURLPATH; ?>news_manage&nid=<?php echo $rasNews['id'];?>"><img src="images/action_edit.gif" alt="Edit" width="24" height="24" title="Edit"></a> <a href="javascript:void(0);" onClick="callDelete('<?php echo ADMINURLPATH;?>news&del_nid=<?php echo $rasNews['id'];?>')"><img src="images/action_delete.gif" alt="Delete" width="24" height="24" title="Delete"></a></td>
    </tr>
    <?php
    }
}
    ?>
  </table>