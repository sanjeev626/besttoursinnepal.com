<?php
	if(isset($_POST['mode']) && $_POST['mode'] == "changeconfiguration")
	{
		$data = "";
		$data['title'] = $_POST['title'];
		$data['email'] = $_POST['email'];
		$mydb->updateQuery("tbl_admin",$data,"id=1");
		$mydb->redirect(ADMINURLPATH."config&msg=1");
	}
	
	$rasConfig = $mydb->getArray("title,email", "tbl_admin","id=1");
?>

<form name="form1" method="post" action="">
  <table width="100%" cellpadding="0" cellspacing="0" border="0" class="FormTbl">
    <tr class="TitleBar">
      <td class="TtlBarHeading" colspan="3">Manage Site Configuration</td>
    </tr>
    <input name="mode" type="hidden" id="mode" />
    <?php if(isset($_GET['msg']) && $_GET['msg'] =='1'){ ?>
    <tr>
      <td colspan="5" class="adminsucmsg">Content has been updated.</td>
    </tr>
    <?php } ?>
    <tr class="TitleBarB">
      <td width="12%" height="50"><strong>Title:</strong> </td>
      <td width="88%"><input name="title" type="text" id="title" size="40" value="<?php echo $rasConfig['title'];?>" class="inputBox">
      </td>
    </tr>
    <tr class="TitleBarA">
      <td width="12%" height="50"><strong>Email:</strong> </td>
      <td width="88%"><input name="email" type="text" id="email" size="40" value="<?php echo $rasConfig['email'];?>" class="inputBox">
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Button" value="Save" onclick="this.form.mode.value='changeconfiguration';return CheckSiteConfiguration(this.form);" class="button" onmouseout="this.className='button'" onmouseover="this.className='button'"  />
      </td>
    </tr>
  </table>
</form>
