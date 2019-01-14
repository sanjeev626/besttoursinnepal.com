<form action="<?php echo SITEROOT;?>book-the-trip.html" method="post" name="frmBook"><input name="packagecode" type="hidden" value="<?php echo $id;?>"></form>

<div class="ptit">
  <h1> <span style="background:#FFF; padding:0 25px;"><?php echo $title;?></span> </h1>
</div>
<!--ptit-->

<div class="ttb">
  <div class="td"> <span style="color:#53a8ff;">TRIP DURATION</span><br />
    <span style="font-size:18px;"><?php echo $duration;?></span> </div>
  <!--td-->
  
  <div class="tc"> <span style="color:#c83a00;">TRIP COST</span><br />
    <span style="font-size:24px;">
    <?php
      if($cost>0)
      {
          $cost = $cost;
          $currencyCode = 'US$ ';
      }
      elseif($cost_npr>0)
      {
          $cost = $cost_npr;
          $currencyCode = 'Nrs ';
      }
      else
      {
          $cost = 'PRICE ON REQUEST';
          $currencyCode = '';
      }
      echo $currencyCode.' '.$cost;?>
    </span> </div>
  <!--tc-->
  
  <div class="bs"> <span style="color:#30cb00;">MINIMUM GROUP SIZE</span><br />
    <span style="font-size:18px;"><?php echo $mydb->getValue('mingroupsize','tbl_package','id='.$id);?></span> </div>
  <!--bs--> 
  
</div>
<!--ttb-->

<div class="lcont">
  <div class="ptb">
    <div class="stit"> Pre-Trip Briefing </div>
    <!--stit-->
    
    <div class="bbtn1"> <a href="javascript:void(0);" onclick="frmBook.submit();"></a> </div>
    <!--btn1--> 
    
  </div>
  <!--ptb-->
  
  <div class="tripbox">
    <div class="tdes">
      <p> <?php echo $description;?> </p>
    </div>
    <!--tdes-->
    
    <div class="alldetail">
      <ul class="tabNavigation1">
        <li id="iti"><a href="#itinerary">Itinerary</a></li>
        <li id="inc"><a href="#includes">What's Included / Excluded</a></li>
        <li id="exc"><a href="#highlights">Highlights</a></li>
        <li id="rev"><a href="#notes">Trip Notes</a></li>
        <li id="not"><a href="#imgvi">Images / Videos</a></li>
        <li id="rev"><a href="#reviews">Trip Reviews</a></li>
      </ul>
      <!--tabNavigation1-->
      
      <div class="tabContainers1">
        <div id="itinerary" class="tabContent1">
          <h2> Itinerary - <?php echo $title;?> </h2>
          <?php
			$resItinerary = $mydb->getQuery('*','tbl_itinerary','pid='.$id);
			while($rasItinerary = $mydb->fetch_array($resItinerary))
			{
			?>
          <div class="daydetail">
            <div class="dayc">
              <P> <?php echo $rasItinerary['day'];?>
              <p> 
            </div>
            <!--dayc-->
            
            <div class="dayinfo">
              <div class="desd">
                <p> <?php echo stripslashes($rasItinerary['place']);?> </p>
              </div>
              <!--desd-->
              
              <div class="desinfo">
                <p> <?php echo stripslashes($rasItinerary['description']);?> </p>
              </div>
              <!--desinfo-->
              
              <div class="dayser">
                <?php

				$ser = stripslashes($rasItinerary['services']);

				$services = explode('---',$ser);

				for($i=0;$i<count($services);$i++)

				{

				?>
                <div class="tick"> <?php echo $services[$i];?></div>
                <?php

				}

				?>
              </div>
              <!--dayser--> 
              
            </div>
            <!--dayinfo--> 
            
          </div>
          <!--daydetail-->
          
          <?php

                          }

                          ?>
        </div>
        <div id="includes" class="tabContent1">
          <h2>Cost Includes -<?php echo $title;?> </h2>
          <div class="un"> <?php echo $includes;?> </div>
          <!--un-->
          
          <h2>Cost Excludes -<?php echo $title;?></h2>
          <div class="un"> <?php echo $excludes;?> </div>
          <!--un--> 
          
        </div>
        <div id="highlights" class="tabContent1">
          <h2>Trip Highlights -<?php echo $title;?></h2>
          <div class="un"> <?php echo $highlights;?> </div>
          <!--un--> 
          
        </div>
        <div id="notes" class="tabContent1">
          <h2>Trip Notes -<?php echo $title;?></h2>
          <div class="un">
            <p> <?php echo $trip_notes;?> </p>
          </div>
          <!--un--> 
          
        </div>
        <div id="imgvi" class="tabContent1">
          <h2>Images - <?php echo $title;?></h2>
          <div class="un">
            <div class="pics">
              <?php $resImages = $mydb->getQuery('*','tbl_image','package_image_id="'.$id.'"');

                                    while($rasImages = $mydb->fetch_array($resImages))

                                    {

                                    ?>
              <div class="tmg"><a href="<?php echo SITEROOT.'img/package/'. $rasImages['imagename'];?>" rel="prettyPhoto[Gallery2]"><img src="<?php echo SITEROOT.'img/package/'. $rasImages['imagename'];?>" title="<?php echo $rasImages['imagetitle'];?>" width="122" /></a></div>
              <!--tmg-->
              
              <?php 

                                    }

                                    ?>
            </div>
            <!--pics--> 
            
          </div>
          <!--un-->
          
          <h2>Videos -<?php echo $title;?></h2>
          <div class="un">
            <div class="pics">
              <?php 

                            $resVideo = $mydb->getQuery('*','tbl_video','package_id="'.$id.'"');

                            while($rasVideo = $mydb->fetch_array($resVideo))

                            {

                                $title = $rasVideo['title'];

                                $youtube = new YouTube($rasVideo['link']);

                                $youtube_image = $youtube->ShowImg($rasVideo['link'], 2, $title);

                            ?>
              <div class="tmg"> <a href="<?php echo $rasVideo['link'];?>" rel="prettyPhoto" title=""><?php echo $youtube_image;?></a> </div>
              <!--tmg-->
              
              <?php

                                    }

                                ?>
            </div>
            <!--pics--> 
            
          </div>
          <!--un--> 
          
        </div>
        <div id="reviews" class="tabContent1">
          <h2>Trip Reviews -<?php echo $title;?></h2>
          <div class="un">
            <p> <?php echo $trip_reviews;?> </p>
          </div>
          <!--un--> 
          
        </div>
        <!--reviews--> 
        
      </div>
      <!--tabContainers1--> 
      
    </div>
    <!--alldetail-->
    
    <div class="bbtn2"> <a href="javascript:void(0);" onclick="frmBook.submit();"></a> </div>
    <!--btn1--> 
    
  </div>
  <!--tripbox--> 
  
</div>
<!--lcont-->

<div class="rcont">
  <div class="tfacts">
    <div class="ftit">Trip Facts</div>
    <!--ftit-->
    
    <div class="fdet">
      <p> <?php echo $trip_facts;?> </p>
    </div>
    <!--fdet--> 
    
  </div>
  <!--tfacts-->
  
  <div class="bbtn3"> <a href="javascript:void(0);" onclick="frmBook.submit();"></a> </div>
  <!--bbtn3-->
  
  <?php if($mydb->getCount('id','tbl_image','package_image_id="'.$id.'"')>0){?>
  <div class="tref">
    <div class="trtit"> Trip Reflection<br />
      <span style="font-size:13px;"><u><?php echo $title;?></u></span> </div>
    <!--trtit-->
    
    <div class="trim">
      <?php 
					$resImages = $mydb->getQuery('*','tbl_image','package_image_id="'.$id.'" LIMIT 4');
                    while($rasImages = $mydb->fetch_array($resImages))
                    {
					?>
      <a href="<?php echo SITEROOT.'img/package/'. $rasImages['imagename'];?>" rel="prettyPhoto[Gallery2]"><img src="<?php echo SITEROOT.'img/package/'. $rasImages['imagename'];?>" title="<?php echo $rasImages['imagetitle'];?>" style="max-width:104px; max-height:80px;"/></a>
      <?php
                    }
                    ?>
    </div>
    <!--trim--> 
    
  </div>
  <!--tref-->
  <div style="clear:both;"> </div>
  <div class="bbtn3"> <a href="javascript:void(0);" onclick="frmBook.submit();"></a> </div>
  <?php } ?>
  <!--bbtn3-->
  <?php
  if(file_exists($mapdocpath))
  {
  ?>
  <div class="trm">

        <div class="tmtit">

            Trip Route Map<br />

            <span style="font-size:13px;"><u><?php echo $title;?></u></span>

        </div><!--tmtit-->

        <div class="tmap">

            <a href=""><img src="<?php echo $mappath;?>" title="Map - <?php echo $title;?>" /></a>

        </div><!--tmap-->

    </div><!--tmap-->
  <div class="bbtn3"> <a href="javascript:void(0);" onclick="frmBook.submit();"></a></div>
  <?php }?>
  <!--bbtn3--> 
  
</div>
<!--rcont-->