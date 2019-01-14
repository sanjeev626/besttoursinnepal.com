<script type="text/javascript">
function CheckLoginThenGo(f)
{
	if(login(f))
	{
		AdminLogin('ajax_process.php?for=adminlogin',f.username.value,f.password.value);
	}
}

function CheckForgetPassThenGo(f2)
{
	if(checkforgetpass(f2))
	{
		ForgotPass('ajax_process.php?for=forgotpass',divResponse,f2.femail.value);
	}
}
</script>
<?php
if(isset($_POST['username']))
{
	$getpass 		= $mydb->CleanString($_POST['password']);
	$getusername 	= $mydb->CleanString($_POST['username']);
	//print_r($_POST);

	if($mydb->count_row($mydb->getQuery("*","tbl_admin","username = '".$getusername."'")) == 1)
	{
		$dbpass = $mydb->md5_decrypt($mydb->getValue("pass","tbl_admin","username = '".$getusername."'"), SECRETPASSWORD);
		if($dbpass == $getpass)
		{
			$_SESSION[ADMINUSER] = $mydb->getValue("id","tbl_admin","username = '".$getusername."'");

			$redirectUrl = SITEROOT.'dacadmin/index.php';
			$querystring = $_SERVER['QUERY_STRING'];
			if(!empty($querystring))
				$redirectUrl = $redirectUrl.'?'.$querystring;
			$mydb->redirect($redirectUrl);
		}
		else
		{
				echo "no";
		}
	}
	else
		echo "<div class='message' style='width:350px;'>Invalid Username/Password/Usertype Combination</div>";
}
?>

<div class="ie_width" align="center">
  <div id="invalid" style="display:none" class="adminerrmsg"><img src="../images/icon_error.png" alt="" style="vertical-align:middle; padding:0 5px 3px 0" />Password did not match.</div>
  <div id="nousermsg" style="display:none" class="adminerrmsg"><img src="../images/icon_error.png" alt="" style="vertical-align:middle; padding:0 5px 3px 0" />Such user does not exists.</div>
  <div id="form_wrapper" class="form_wrapper">
    <form method="post" action="" name="f1" class="login active">
      <table width="100%" cellpadding="0" cellspacing="0" border="0" class="adminLoginTbl" align="center">
        <tr>
          <td style="padding:0" colspan="2"><table width="100%" cellpadding="0" cellspacing="0" border="0" class="adminLogForm">
              <tr>
                <td><label>Username:</label></td>
              </tr>
              <tr>
                <td><input type="text" name="username" id="username" value="" class="inputBox"  /></td>
              </tr>
              <tr>
                <td align="center"><div id="loading" style="display:none;" align="center">Loading...<img src="../images/loading.gif" height="11" width="16" /></div></td>
              </tr>
              <tr>
                <td><label>Password:</label></td>
              </tr>
              <tr>
                <td><input type="password" name="password" id="password" value="" class="inputBox"  /></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td width="69%" style="padding:10px 0 20px 20px; vertical-align:bottom"><a href="#" rel="forgot_password" class="forgot linkform">Forgot Your Password?</a></td>
          <td width="31%" align="right" style="padding:0 20px 10px 0;"><input name="btnlogin" class="button" onmouseout="this.className='button'" onmouseover="this.className='button'" type="submit" id="btnlogin" value="Login" onclick="f1.submit();" /></td>
        </tr>
      </table>
    </form>
    <form method="post" action="" name="f2" style="display: none;" class="forgot_password">
      <table width="100%" cellpadding="0" cellspacing="0" border="0" class="adminLoginTbl">
        <tr>
          <td style="padding:0"><table width="100%" cellpadding="0" cellspacing="0" border="0" class="adminLogForm">
              <tr>
                <td><label>Enter your Email:</label></td>
              </tr>
              <tr>
                <td><input type="text" name="femail" id="femail" value="" class="inputBox"  /></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td align="right" style="padding:10px 20px;"><input name="btnsendpassword" class="button" onmouseout="this.className='button'" onmouseover="this.className='button'" type="button" id="btnsendpassword" value="Send Password" onclick="CheckForgetPassThenGo(this.form);"/></td>
        </tr>
        <tr>
          <td class="noacc" align="right" style="padding:10px 30px 10px 0"><a href="#" rel="login" class="forgot linkform">Suddenly Remembered.Login Here</a></td>
        </tr>
      </table>
    </form>
  </div>
  <div class="clear"></div>
</div>
