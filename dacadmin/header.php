<div class="siteTtlAdmin" style="float:left;">
<div style="float:left; padding:20px;">
<a href="index.php" style="text-decoration:none; color:#CCCCCC; font-size:28px;"><?php echo stripslashes($mydb->getValue("title", "tbl_admin",'id=1')); ?> :: Control Panel</a>
</div>
<div style="float:right; padding:20px;"><a href="<?php echo ADMINURLPATH; ?>logout" id="logout"><img src="images/logout.png" alt="Log Out" title="Log Out" /></a></div>
</div>
<div style="clear:both"></div>