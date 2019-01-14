    	<div class="ptit">
    		<h1><span style="background:#FFF; padding:0 25px;">Fixed Departures - 2018 / 2019</span></h1>
            <p><?php echo stripslashes($mydb->getValue('contents','tbl_page','id=20'));?></p>
        </div><!--ptit-->
        <div class="triplist">
        	<?php
			$resFixed = $mydb->getQuery('*','tbl_package','is_fixed_departure="1"');
			while($rasFixed=$mydb->fetch_array($resFixed))
			{							
				$aid = $rasFixed['aid'];
				//$rid = $rasFixed['rid'];
				
				//$country = $mydb->getValue('urlcode','tbl_country','id='.$cid);
				$activity = $mydb->getValue('urlcode','tbl_activity','id='.$aid);		
				//$region = $mydb->getValue('urlcode','tbl_regionandroute','id='.$rid);
				
				$package = $rasFixed['urlcode'];
				$packageurl = SITEROOT;
				if(!empty($country))
					$packageurl.=$country;
				if(!empty($activity))
					$packageurl.=$activity;			
				if($rid>0) 
						$packageurl.='/'.$region;
				$packageurl.='/'.$package.'.html';
			?>      
            <div class="tblock">
            	<div class="tplm" style="background:url(<?php echo SITEROOT;?>img/package/thumb/<?php echo $rasFixed['iconimage'];?>) no-repeat;">
            <form id="frmJoin" method="post" action="<?php echo SITEROOT;?>fixed-departures-form.html">
                <input type="hidden" name="packageid" value="<?php echo $rasFixed['id'];?>"/> 
                	<a href="<?php echo $packageurl; ?>"></a>   
            </form>
                </div><!--tplm-->
                <div class="trnm">
                	<h2><a href="<?php echo $packageurl; ?>"><?php echo stripslashes($rasFixed['title']);?></a></h2>
                </div><!--trnm-->
                <div class="durprc">
                	<div class="dur">
                	<b>Fixed Dates</b>: <?php echo $rasFixed['fixed_dates'];?>
                    </div><!--dur-->
                	<div class="dur">
                	<b>Duration</b>: <?php echo $rasFixed['duration'];?>
                    </div><!--dur-->
					<div class="prc">
                    <b style="color:#C00;">Price</b>: <?php if($rasFixed['cost']>0) echo '$'.$rasFixed['cost'].' per person'; else echo '[ON REQUEST]';?>
                    </div><!--prc-->
                </div><!--durprc-->
            </div><!--tblock-->
            
			<?php
            }
            ?>
        </div><!--triplist-->