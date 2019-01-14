<div class="rcont">
        	<div class="tripdetail">
            	<h1>Link Exchange</h1>
                <div class="tdes">
                	<p><i>Please use this link</i><br />
<br />
<b>Title</b>: Sports Tours and Travel<br />
<br />
<b>Description</b>: Sports Tours and Travel - highly dedicated team ready to deliver a best tailor made tours to make your trip a life time memory experience.<br />
<br />
<b>Website</b>: <a target="_new" href="http://www.besttoursinnepal.com">http://www.besttoursinnepal.com</a></p>
                    <div id="changelink">
                    <div class="linklist">
            	<h2>Category</h2>
                	<ul>
						<?php $link = $mydb->getQuery('*','tbl_linkexchange','1');
                        $counter=1;
                        while($rasLink = $mydb->fetch_array($link))
                        {                        
                        ?>
                        <li><a <?php if($counter==1)echo 'class="active"'; else echo 'class="default"';?> href="javascript:void(0)" onClick="linkchange('<?php echo $rasLink['id'];?>');"><?php echo $rasLink['title'];?></a></li>
                        <?php
						$counter++;
						}
						?>  
                    </ul>
                    
						<?php 
						$linkContent= $mydb->getQuery('*','tbl_linkexchange_content','lid=(select min(id) from tbl_linkexchange)');
						while($raslinkContent=$mydb->fetch_array($linkContent))
						{
						?>
                        <div class="lk">
                            <p>
								<?php echo $raslinkContent['title'];?><br /><br />
                         
                                                <a href="<?php echo $raslinkContent['url'];?>"><?php echo $raslinkContent['url'];?></a><br /><br />
                              
                              	<?php echo stripslashes($raslinkContent['description']);?>
                            </p>
                        </div><!--lk-->
                		<?php
						}
						?>
            </div>
            		</div>
                    <!--linklist-->
                    
                </div><!--tdes-->           

            </div><!--tripdetail-->
        </div>




<script type="text/javascript">
function linkchange(lid){
	//alert(lid);
	//$('#changelink').html('loading...');
	
	$('#changelink').load('<?php echo SITEROOT;?>includes/ajax_linkexchange.php',{'lid':lid});


	}
</script>
