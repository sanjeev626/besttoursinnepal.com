<?php
  if(!isset($urlcode))
  {
    $imagepathonly = SITEROOT.'img/banner/';
    $cond = 'pid=3';
    $resBanner = $mydb->getQuery('*','tbl_image',$cond);
  }
  else
  {    
    if(isset($pagename))
    {
      if($pagename=="package")
      {
        $link = '';
        $cond = 'package_id='.$id;
        $resBanner = $mydb->getQuery('*','tbl_image',$cond); 
        $imagepathonly = SITEROOT.'img/package/';
      } 
      elseif ($pagename == 'activity') {
        $link = '';
        $aid = $id;
        $cond = 'aid="'.$aid.'" GROUP BY package_id ORDER BY package_id';
        $resBanner = $mydb->getQuery('ti.imagetitle,ti.imagelink,ti.imagename,ti.package_id,tp.urlcode,tp.title','tbl_package tp INNER JOIN tbl_image ti  ON tp.id=ti.package_id',$cond); 
        $imagepathonly = SITEROOT.'img/package/';      
      }   
      else
      {
        $imagepathonly = SITEROOT.'img/banner/';
        $cond = 'pid=3';
        $resBanner = $mydb->getQuery('*','tbl_image',$cond);         
      }

    }
  }
?>
<div style="display:none;"><?php echo $cond;?></div>
<!-- jQuery library (served from Google) -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<!-- bxSlider Javascript file -->
<script src="<?php echo SITEROOT; ?>bxslider/jquery.bxslider.min.js"></script>
<!-- bxSlider CSS file -->
<link href="<?php echo SITEROOT; ?>bxslider/jquery.bxslider.css" rel="stylesheet" />
<div class="Navigate">
    <?php include(SITEROOTDOC.'includes/navigation.php');?>
</div><!--navigate-->
<div class="banner">      
  
  <div class="tbg"><img src="<?php echo SITEROOT; ?>img/ban-bg.png" /></div><!--tbg-->  
    <ul class="bxslider">
    <?php
    //$resBanner = $mydb->getQuery('*','tbl_image',$cond); 
    //$rasBanner = $mydb->getArray('*','tbl_image','pid=3 ORDER BY RAND() LIMIT 1');
    while($rasBanner=$mydb->fetch_array($resBanner))
    {
      if(isset($rasBanner['imagelink']) && !empty($rasBanner['imagelink']))
      {
        $link = $rasBanner['imagelink'];      
        $imagetitle = $rasBanner['imagetitle'];
        $imagepath = $imagepathonly.$rasBanner['imagename'];
      }
      elseif ($pagename == 'activity')
      {
        $link = SITEROOT.$urlcode.'/'.$rasBanner['urlcode'].'.html';        
        $imagetitle = $rasBanner['imagetitle'];
        $imagepath = $imagepathonly.$rasBanner['imagename'];
      }     
      else
      {
        $link = '';
        $imagetitle = $rasBanner['imagetitle'];
        $imagepath = $imagepathonly.$rasBanner['imagename'];
      }
    ?>
    <li>
    <div class="exp">
        <img src="<?php echo $imagepath;?>" alt="<?php echo $imagetitle;?>" title="<?php echo $imagetitle;?>" />
      <div class="tit"><?php echo $imagetitle;?></div>
      <div class="vtid"><?php if(!empty($link)){?><a href="<?php echo $link;?>">view this trip in detail</a><?php } ?></div><!--vtid-->
    </div><!--exp-->
    <div class="bbg"><img src="<?php echo SITEROOT; ?>img/ban-bg.png" /></div><!--bbg--> 
    </li> 
    <?php
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
   