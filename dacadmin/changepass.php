<?php
if(isset($_POST['mode']) && $_POST['mode'] == 'changeadminpassword')
{	
	$pass 		= $mydb->CleanString($_POST['pass']);
	$new_pass 	= $mydb->md5_encrypt($mydb->CleanString($_POST['new_pass']), SECRETPASSWORD);
	
	$dbpass = $mydb->md5_decrypt($mydb->getValue("pass","tbl_admin","id = '".$_SESSION[ADMINUSER]."'"), SECRETPASSWORD);
	$table = "tbl_admin";
	$data='';
	$data['pass'] = $new_pass;
		
	$LastModifiedDate	= date("Y-m-d h:i:s");
	if($dbpass == $pass)
	{
		$mydb->updateQuery($table,$data,"id = '".$_SESSION[ADMINUSER]."'");
		$mydb->redirect(ADMINURLPATH."changepass&msg=1");
	}
	else
	{
		$mydb->redirect(ADMINURLPATH."changepass&msg=0");
	}
}
?>

<form method="post" action="" enctype="multipart/form-data" name="f">
  <table width="100%" cellpadding="0" cellspacing="0" border="0" class="FormTbl">
    <tr class="TitleBar">
      <td class="TtlBarHeading" colspan="3">Change Admin Password</td>
    </tr>
    <?php if (isset($_GET['msg']) && $_GET['msg']==1) {?>
    <tr>
      <td colspan="3" class="adminsucmsg">Your password has been changed.</td>
    </tr>
    <?php } else if (isset($_GET['msg']) && $_GET['msg']==0){ ?>
    <tr>
      <td colspan="3" class="adminerrmsg">Old password did not match.</td>
    </tr>
    <?php } ?>
    <tr class="TitleBarA">
      <td width="17%"  height="50"><strong>Old Password:</strong> </td>
      <td><input type="password" name="pass" value="" class="inputBox"/></td>
    </tr>
    <tr class="TitleBarB">
      <td  height="50"><strong>New Password:</strong> </td>
      <td><input type="password" name="new_pass" value="" class="inputBox" /></td>
    </tr>
    <tr class="TitleBarA">
      <td  height="50"><strong>Confirm Password:</strong> </td>
      <td><input type="password" name="confirm_pass" value=""  class="inputBox"/></td>
    </tr>
    <tr>
      <td><input name="mode" type="hidden" id="mode" />
      </td>
      <td><input type="submit" name="Button" value="Change" onclick="this.form.mode.value='changeadminpassword';return CheckPassword(this.form);" class="button" onmouseout="this.className='button'" onmouseover="this.className='button'"  /></td>
    </tr>
  </table>
</form>
