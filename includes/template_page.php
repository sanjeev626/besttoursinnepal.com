<div class="ptit">
  <h1><span style="background:#FFF; padding:0 25px;"><?php echo $title;?></span></h1>
</div>
<!--ptit-->

<div class="lcont">
  <div class="tripbox"> <?php echo $contents;?>
    <?php if($mydb->getCount('id','tbl_image','page_image_id="'.$id.'"')>0){?>
    
    <!-- for legal document images--> 
    
    <br />
    <br />
    <h1>Documents</h1>
    <div class="legal">
      <ul>
        <?php

        $cnt = 0;

        $resImg = $mydb->getQuery('*','tbl_image','page_image_id="'.$id.'"');

        while($rasImg = $mydb->fetch_array($resImg))

        {

            ++$cnt;

        ?>
        <li style="list-style:none; margin-right:20px; float:left; <?php if($cnt%5==0) echo 'margin-right:0px;'; ?>" ><a href="<?php echo SITEROOT.'img/page/'.$rasImg['imagename'];?>" rel="prettyPhoto[gallery2]"><img src="<?php echo SITEROOT.'img/page/'.$rasImg['imagename'];?>" title="<?php echo $rasImg['imagetitle'];?>" style="max-width:129px; max-height:175px;" /><br />
          <span><?php echo $rasImg['imagetitle'];?></span></a></li>
        <?php

        }

        ?>
      </ul>
    </div>
    <?php } ?>
  </div>
  <!--tripbox--> 
  
</div>
<!--lcont-->

<div class="rcont">
  <div class="rplugins">
    <div id="TA_rated976" class="TA_rated">
      <ul id="9piyW3iR4" class="TA_links LHrdMXvs">
        <li id="PxSJWhz8OVDt" class="cZz3PT4WCby"><a target="_blank" href="http://www.tripadvisor.com/"><img src="http://www.tripadvisor.com/img/cdsi/img2/badges/ollie-11424-2.gif" alt="TripAdvisor"/></a></li>
      </ul>
    </div>
    <script src="http://www.jscache.com/wejs?wtype=rated&uniq=976&locationId=4064555&lang=en_US&display_version=2"></script> 
  </div>
  <!--rplugins-->
  
  <div class="rplugins"> <a class="twitter-timeline" href="https://twitter.com/sportsnepaltour" data-widget-id="345091354642247680">Tweets by @sportsnepaltour</a> 
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> 
  </div>
  <!--rplugins-->
  
  <div class="rplugins">
    <div id="fb-root"></div>
    <script>(function(d, s, id) {

  var js, fjs = d.getElementsByTagName(s)[0];

  if (d.getElementById(id)) return;

  js = d.createElement(s); js.id = id;

  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";

  fjs.parentNode.insertBefore(js, fjs);

}(document, 'script', 'facebook-jssdk'));</script>
    <div class="fb-follow" data-href="https://www.facebook.com/pages/Sports-Tours-and-Travel/391212987618615" data-width="220" data-colorscheme="light" data-layout="standard" data-show-faces="true"></div>
  </div>
  <!--rplugins--> 
  
</div>
<!--rcont--> 

<script type="text/javascript" charset="utf-8">

	$(document).ready(function(){

	$("a[rel^='prettyPhoto']").prettyPhoto({social_tools:false,deeplinking:false});

	});

</script>