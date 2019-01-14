<div class="ptit">
  <h1><span style="background:#FFF; padding:0 25px;">Best Tours in Nepal - 2019</span></h1>
</div>
<!--ptit-->

<div class="seafix">
  <div class="sea"> <a href="<?php echo SITEROOT.$mydb->getValue('urlcode','tbl_page','id=21').'.html';?>">VIEW ALL SEASONAL TRIPS</a> </div>
  
  <!--sea-->
  
  <div class="fix"> <a href="<?php echo SITEROOT.$mydb->getValue('urlcode','tbl_page','id=20').'.html';?>">FIXED DEPARTURES</a> </div>
  
  <!--fix--> 
  
</div>
<!--seafix-->

<div class="triplist">
  <?php
	$resHome = $mydb->getQuery('*','tbl_package','homepage="1"');
	while($rasHome = $mydb->fetch_array($resHome))
	{
		$packagecode 		= 	$rasHome['urlcode'];
		$aid				=	$rasHome['aid'];
		$homepackage_url	= 	SITEROOT.$mydb->getValue('urlcode','tbl_activity','id="'.$aid.'"').'/'.$rasHome['urlcode'].'.html';
		$imagepath 			= 	SITEROOT.'img/package/thumb/'.$rasHome['iconimage'];
		$title				= 	stripslashes($rasHome['title']);
 		$duration 			= 	stripslashes($rasHome['duration']);
		$cost 				= 	stripslashes($rasHome['cost']);
		$mingroupsize       = 	stripslashes($rasHome['mingroupsize']);
		if($cost>0)
			$cst = '$'.$cost;
		else
			$cst = 'ON REQUEST';
	?>
  <div class="tblock">
    <div class="tplm" style="background:url(<?php echo $imagepath;?>) no-repeat;"> <a href="<?php echo $homepackage_url;?>"></a> </div>
    <!--tplm-->
    
    <div class="trnm"><h2><a href="<?php echo $homepackage_url;?>"><?php echo $title;?></a></h2> </div>
    <!--trnm-->
    
    <div class="durprc">
      <div class="dur"> <b>Duration</b>: <?php echo $duration;?> </div>
      
      <!--dur-->
      
      <div class="prc"> <b style="color:#C00;">Price</b>: <?php echo $cst;?> </div>
      
      <!--prc--> 
      
    </div>
    
    <!--durprc--> 
    
  </div>
  <?php
  }
  ?>
  
  <!--tblock-->
  
</div>

<!--triplist--> 