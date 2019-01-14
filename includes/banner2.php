<!-- jQuery library (served from Google) -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<!-- bxSlider Javascript file -->
<script src="<?php echo SITEROOT; ?>bxslider/jquery.bxslider.min.js"></script>
<!-- bxSlider CSS file -->
<link href="<?php echo SITEROOT; ?>bxslider/jquery.bxslider.css" rel="stylesheet" />
<div class="banner">      
  <?php include(SITEROOTDOC.'includes/navigation.php');?>
  <div class="tbg"><img src="<?php echo SITEROOT; ?>img/ban-bg.png" /></div><!--tbg--> 
    <ul class="bxslider">
	<?php
    //if(!isset($urlcode))
    {
	$resBanner = $mydb->getQuery('*','tbl_image','pid=3');	
    //$rasBanner = $mydb->getArray('*','tbl_image','pid=3 ORDER BY RAND() LIMIT 1');
	while($rasBanner=$mydb->fetch_array($resBanner))
	{
    if(isset($rasBanner['imagelink']) && !empty($rasBanner['imagelink'])) 
      $link = $rasBanner['imagelink']; 
    else 
      $link = 'javascript:void(0);';
    ?>
    <li>
    <div class="exp" style="background:url(<?php echo SITEROOT.'img/banner/'.$rasBanner['imagename'];?>) no-repeat;">
      <div class="tit"><?php echo $rasBanner['imagetitle'];?></div>
      <div class="vtid"><a href="<?php echo $link;?>">view this trip in detail</a></div><!--vtid-->
    </div><!--exp-->
    <div class="bbg"><img src="<?php echo SITEROOT; ?>img/ban-bg.png" /></div><!--bbg-->
    </li>
    <?php
	}
    }
    ?>     
    </ul>
      
  </div><!--banner-->
<script type="text/javascript">
$(document).ready(function(){
    $('.bxslider').bxSlider({
    adaptiveHeight: true,
    auto: true,
    /*autoControls: true,*/
    captions : true,
    pause: 5000
  });
});
</script> 
   