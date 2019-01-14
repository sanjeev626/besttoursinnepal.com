<div class="rcont">
<div class="tripdetail">
    <h1>Testimonials</h1>
    <div class="tdes">
        <?php echo $testcontent;?>
		<?php
        $resTest = $mydb->getQuery('*','tbl_testimonial','1 ORDER BY ordering ASC');
        while($rasTest = $mydb->fetch_array($resTest)){
        ?>
        <div class="team">
            <div class="look">
                <img src="<?php echo SITEROOT;?>img/testimonial/<?php echo $rasTest['filename'];?>" width="230" title="Dawn" />
            </div><!--look-->
            <div class="pro">
                <div class="tnm">
                <?php echo stripslashes($rasTest['title']);?>
                </div><!--tnm-->
                <div class="dg">
                <?php $rasPackage = $mydb->getArray('title,urlcode','tbl_package','id='.$rasTest['package']);?>
                <a href="<?php echo SITEROOT.$rasPackage['urlcode'];?>.html"><?php echo $rasPackage['title'];?></a>
                </div><!--dg-->
                <p>
				<?php echo stripslashes(strip_tags($rasTest['contents']));?>
                <?php echo stripslashes($rasTest['name']);?><br />
                <?php echo stripslashes($rasTest['address']);?><br /><br />
                 Visited on <?php echo stripslashes($rasTest['date']);?><br /><br />
                 </p>
            </div><!--pro-->
        </div>
        <?php
		}
		?>
        <!--team-->        
    </div><!--tdes-->           

</div><!--tripdetail-->
</div>