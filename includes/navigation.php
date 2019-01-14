<?php
$rasAbout = $mydb->getArray('urlcode,excerpt,iconimage','tbl_page','id=1');
$rasTeam = $mydb->getArray('urlcode,excerpt,iconimage','tbl_page','id=7');
$rasWhy = $mydb->getArray('urlcode,excerpt,iconimage','tbl_page','id=4');
?>
<div class="tmenu">
<ul>
  <li><a href="<?php echo SITEROOT;?>">HOME</a></li>
  <li id="company"><a href="">COMPANY</a></li>
  <li id="activities"><a href="">ACTIVITIES</a></li>
  <li id="daytrips"><a href="<?php echo SITEROOT.$mydb->getValue('urlcode','tbl_activity','id=5').'.html';?>">DAY TOURS</a></li>
  <li id="bhutantours"><a href="<?php echo SITEROOT.$mydb->getValue('urlcode','tbl_activity','id=7').'.html';?>">BHUTAN TOURS</a></li>
  <li><a href="<?php echo SITEROOT.$mydb->getValue('urlcode','tbl_page','id=2').'.html';?>">CONTACT</a></li>
</ul>
</div><!--tmenu-->
<div class="menudrop">
  <div class="menublock1">
    <div class="mstitle"><a href="<?php echo SITEROOT.$rasAbout['urlcode'].'.html';?>">About Us</a></div>
    <!--mstitle-->
    <div class="msimg"> <img rel="nofollow" src="<?php echo SITEROOT;?>img/page/thumb/<?php echo $rasAbout['iconimage'];?>" /> </div>
    <!--msimg-->
    <div class="msbrief"> <?php echo stripslashes($rasAbout['excerpt']);?> </div>
    <!--msbrief-->
    <div class="more"> <a href="<?php echo SITEROOT.$rasAbout['urlcode'].'.html';?>">more in detail</a> </div>
    <!--more--> 
  </div>
  <!--menublock-->

  <div class="menublock1">
    <div class="mstitle"><a href="<?php echo SITEROOT.$rasTeam['urlcode'].'.html';?>">Meet the Team</a></div>
    <!--mstitle-->
    <div class="msimg"> <img rel="nofollow" src="<?php echo SITEROOT;?>img/page/thumb/<?php echo $rasTeam['iconimage'];?>" /> </div>
    <!--msimg-->
    <div class="msbrief"> <?php echo stripslashes($rasTeam['excerpt']);?> </div>
    <!--msbrief-->
    <div class="more"> <a href="<?php echo SITEROOT.$rasTeam['urlcode'].'.html';?>">more in detail</a> </div>
    <!--more--> 
  </div>
  <!--menublock-->

  <div class="menublock1">
    <div class="mstitle"><a href="<?php echo SITEROOT.$rasWhy['urlcode'].'.html';?>">Why Us</a></div>
    <!--mstitle-->
    <div class="msimg"> <img rel="nofollow" src="<?php echo SITEROOT;?>img/page/thumb/<?php echo $rasWhy['iconimage'];?>" /> </div>
    <!--msimg-->
    <div class="msbrief"> <?php echo stripslashes($rasWhy['excerpt']);?> </div>
    <!--msbrief-->
    <div class="more"> <a href="<?php echo SITEROOT.$rasWhy['urlcode'].'.html';?>">more in detail</a> </div>
    <!--more--> 
  </div>
  <!--menublock-->

  <div class="menublock1" style="width:180px;">
    <div class="mstitle">More About Us</div>
    <!--mstitle-->
    <div class="msbrief" style="margin-right:10px;">
      <ul>
        <li><a href="<?php echo SITEROOT.$mydb->getValue('urlcode','tbl_page','id=9').'.html';?>">Legal Documents</a></li>
        <li><a href="<?php echo SITEROOT.$mydb->getValue('urlcode','tbl_page','id=10').'.html';?>">Affiliations</a></li>
        <li><a href="<?php echo SITEROOT.$mydb->getValue('urlcode','tbl_page','id=11').'.html';?>">Testimonials</a></li>
        <li><a href="<?php echo SITEROOT.$mydb->getValue('urlcode','tbl_page','id=12').'.html';?>">Our CSR</a></li>
        <li><a href="<?php echo SITEROOT.$mydb->getValue('urlcode','tbl_page','id=5').'.html';?>">FAQs</a></li>
        <li><a href="<?php echo SITEROOT.$mydb->getValue('urlcode','tbl_page','id=13').'.html';?>">Request Custom Tour</a></li>
        <li><a href="<?php echo SITEROOT.$mydb->getValue('urlcode','tbl_page','id=16').'.html';?>">Trip Booking Conditions</a></li>
        <li><a href="<?php echo SITEROOT.$mydb->getValue('urlcode','tbl_page','id=19').'.html';?>">Link Exchange</a></li>
      </ul>
    </div>
    <!--msbrief--> 
  </div>
  <!--menublock--> 
</div>
<!--menudrop-->

<div class="menudrop1">
<?php
$resActivity = $mydb->getQuery('id,urlcode,title,activityimage','tbl_activity','cid=1 ORDER BY ordering LIMIT 5');
while($rasActivity = $mydb->fetch_array($resActivity))
{
	$aid = $rasActivity['id'];
?>
<div class="menublock">
    <div class="mstitle"><a href="<?php echo SITEROOT.$rasActivity['urlcode'].'.html';?>"><?php echo stripslashes($rasActivity['title']);?></a></div>
    <!--mstitle-->
    <div class="msimg"> <img src="<?php echo SITEROOT.'img/activity/'.$rasActivity['activityimage'];?>" /> </div>
    <!--msimg-->
    <div class="trplist">
      <ul>
        <?php
		    $resPackage = $mydb->getQuery('urlcode,title','tbl_package','aid='.$aid.' LIMIT 5');
		    while($rasPackage=$mydb->fetch_array($resPackage))
		    {
        ?>
        <li><a href="<?php echo SITEROOT.$rasActivity['urlcode'].'/'.$rasPackage['urlcode'].'.html';?>"><?php echo stripslashes($rasPackage['title']);?></a></li>
        <?php
      	}
    		?>
      </ul>
    </div>
    <!--trplist-->
    <div class="more"> <a href="<?php echo SITEROOT.$rasActivity['urlcode'].'.html';?>">view all trips</a> </div>
    <!--more--> 
  </div>
<?php
}
?>
</div>
<!--menudrop1-->


