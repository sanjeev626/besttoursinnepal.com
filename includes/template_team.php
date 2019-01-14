<style type="text/css">
.team {
	overflow: hidden;
	margin: 20px 0;
	padding-bottom: 20px;
	border-bottom: 1px dotted #efefef;
}
.look {
	overflow: hidden;
	float: left;
	border: 1px solid #efefef;
	padding: 3px;
}
.look img {
	margin: 0;
	border: none;
}
.pro {
	overflow: hidden;
	float: left;
	width: 400px;
	margin-left: 30px;
}
.tnm {
	font-size: 16px;
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
	color: #000;
	padding-bottom: 10px;
}
.tnm a {
	display: block;
	color: #F63;
}
.tnm a:hover {
	color: #06F;
}
.dg {
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	margin-bottom: 15px;
	border: 1px dotted #999;
	padding: 0 5px;
	overflow: hidden;
}
.dg a {
	text-decoration: none;
	color: #F30;
}
.dg a:hover {
	color: #06F;
}
</style>
<div class="ptit">
  <h1><span style="background:#FFF; padding:0 25px;"><?php echo $title;?></span></h1>
</div>
<!--ptit-->

<div class="lcont">
  <div class="tripbox">
    <div class="tdes">
      <p style="padding-bottom:15px;"><?php echo $contents;?></p>
      <?php 
	  $result=$mydb->getQuery('*','tbl_team','1 order by ordering');
		while($rasMember = $mydb->fetch_array($result))
		{
		?>
      <div class="team">
        <div class="look"> <img src="<?php echo SITEROOT;?>img/team/<?php echo $rasMember['filename'];?>" title="<?php echo $rasMember['name'];?>" style="max-height:280px; max-width:230px;" /> </div>
        <!--look-->
        
        <div class="pro">
          <div class="tnm"> <strong><?php echo $rasMember['name'];?></strong> </div>
          <!--tnm-->
          
          <div class="dg"> <?php echo $rasMember['position'];?> </div>
          <!--dg--> 
          
          <?php echo stripslashes($rasMember['contents']);?> </div>
        <!--pro--> 
        
      </div>
      <!--team-->
      
      <?php

		}

		?>
    </div>
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