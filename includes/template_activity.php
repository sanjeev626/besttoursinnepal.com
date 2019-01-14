<div class="ptit">
  <h1><span style="background:#FFF; padding:0 25px;"><?php echo $title;?></span></h1>
</div>
<!--ptit-->

<div class="lcont">
  <div class="tripbox">
    <div class="tdes"> <?php echo stripslashes($description);?> </div>
    <!--tdes-->
    
    <div class="ginfo">
      <h2>Recommended <?php echo $title;?></h2>
      <?php $resPackage = $mydb->getQuery('*','tbl_package','aid='.$id);


            while($rasPackage = $mydb->fetch_array($resPackage)){
            ?>
      <div class="atrips">
        <div class="ticoimg">
          <?php 
                                if(!empty($rasPackage['iconimage']) && file_exists(SITEROOTDOC.'img/package/thumb/'.$rasPackage['iconimage']))
                                    {
                                        $imagepath = SITEROOT.'img/package/thumb/'.$rasPackage['iconimage'];?>
          <img src="<?php echo $imagepath;?>" title="<?php echo $title;?>" style="max-width:180px;" />
          <?php
                                    }
                            ?>
        </div>
        <!--ticoimg-->
        <div class="tripinfo">
          <div class="desd">
            <h3> <a href="<?php echo SITEROOT.$urlcode.'/'.$rasPackage['urlcode'].'.html'; ?>"><?php echo stripslashes($rasPackage['title']);?></a> </h3>
          </div>
          <!--desd-->
          <div class="tfs">
            <div class="bs"> Best Season:<?php echo stripslashes($rasPackage['bestseason']);?> </div>
            <!--bs-->
            <div class="bs"> Min. Group Size:<?php echo stripslashes($rasPackage['mingroupsize']);?> </div>
          </div>
          <!--tfs-->
          <div class="desinfo">
            <p><?php echo stripcslashes($rasPackage['excerpt']);?></p>
          </div>
          <!--desinfo-->
          <div class="tdtpb">
            <div class="nd"><?php echo stripslashes($rasPackage['duration']);?></div>
            <div class="tpr">
              <?php if($rasPackage['cost']>0) echo 'USD '.$rasPackage['cost']; else echo 'PRICE ON REQUEST';?>
            </div>
            <!--tpr-->
            <div class="btt"><a href="<?php echo SITEROOT.$urlcode.'/'.$rasPackage['urlcode'].'.html'; ?>">TRIP DETAIL</a></div>
          </div>
          <!--tdtpb--> 
          
        </div>
        <!--tripinfo--> 
      </div>
      <!--atrips-->
      <?php
                            }
                                ?>
    </div>
    <!--ginfo--> 
    
  </div>
  <!--tripbox--> 
</div>
<!--lcont-->

<div class="rcont">
  <div class="rplugins">
    <div id="TA_selfserveprop585" class="TA_selfserveprop"><ul id="SEm4Jv9" class="TA_links vgHf02adCp7X"><li id="IatzWLdKmX" class="gguivk8"><a target="_blank" href="http://www.tripadvisor.com/"><img src="http://www.tripadvisor.com/img/cdsi/img2/branding/150_logo-11900-2.png" alt="TripAdvisor"/></a></li></ul></div><script src="http://www.jscache.com/wejs?wtype=selfserveprop&uniq=585&locationId=4064555&lang=en_US&rating=true&nreviews=5&writereviewlink=true&popIdx=true&iswide=false&border=true&display_version=2"></script>
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