<div class="ltit"> Things to Remember </div>
<!--ltit-->
<div class="ttr">
  <ul>
    <?php
	$resRem = $mydb->getQuery('urlcode,title','tbl_faqs');
	while($rasRem=$mydb->fetch_array($resRem))
	{
	?>
    <li><a href="<?php echo $rasRem['urlcode'].'.html';?>"><?php echo $rasRem['title'];?></a></li>
    <?php
	}
	?>
  </ul>
</div>
<!--ttr-->