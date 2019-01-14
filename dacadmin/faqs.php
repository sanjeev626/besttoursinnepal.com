<?php
if(isset($_GET['del_fid'])){

	$del_fid = $_GET['del_fid'];

	$mydb->deleteQuery('tbl_faqs','id='.$del_fid);

	$redirect = ADMINURLPATH.'faqs&msg=Selected faqs has been deleted succcessfully.';

	$mydb->redirect($redirect);

}

$result = $mydb->getQuery('*','tbl_faqs','1 ORDER BY id DESC');

?>

<table cellpadding="0" cellspacing="0" border="0" width="100%" class="FormTbl">
  <tr class="TitleBar">
    <td class="TtlBarHeading" colspan="4">FAQs
      <div style="float:right">
        <input name="btnAdd" type="button" value="Add" class="button" onClick="window.location='<?php echo ADMINURLPATH;?>faqs_manage'" />
      </div></td>
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
    <td width="35%" class="TitleBarB"><strong>Question</strong></td>
    <td class="TitleBarB"><strong>Answer</strong></td>
    <td width="8%" class="TitleBarB">&nbsp;</td>
  </tr>
  <?php

    $counter = 0;

    while($rasNews = $mydb->fetch_array($result))

    {

    ?>
  <tr>
    <td class="TitleBarA" align="center" valign="top"><?php echo ++$counter;?></td>
    <td class="TitleBarA" valign="top"><?php echo stripslashes($rasNews['title']);?></td>
    <td class="TitleBarA" valign="top"><?php echo substr(stripslashes($rasNews['contents']),0,300); if(strlen(stripslashes($rasNews['contents']))>300) echo '...';?></td>
    <td class="TitleBarA" align="center" valign="top"><a href="<?php echo ADMINURLPATH; ?>faqs_manage&fid=<?php echo $rasNews['id'];?>"><img src="images/action_edit.gif" alt="Edit" width="24" height="24" title="Edit"></a> <a href="javascript:void(0);" onClick="callDelete('<?php echo ADMINURLPATH;?>faqs&del_fid=<?php echo $rasNews['id'];?>')"><img src="images/action_delete.gif" alt="Delete" width="24" height="24" title="Delete"></a></td>
  </tr>
  <?php

    }

}

    ?>
</table>
