<?php

require_once("../classes/call.php");
$lid=$_POST['lid'];

?>
<div class="linklist">
            	<h2>Category</h2>
                	<ul>
                    <?php $link = $mydb->getQuery('*','tbl_linkexchange','1');
						while($rasLink = $mydb->fetch_array($link))
						{		
					?>
                    	<li><a <?php if($lid==$rasLink['id'])echo 'class="active"'; else echo 'class="default"';?> href="javascript:void(0)" onClick="linkchange(<?php echo $rasLink['id'];?>);"><?php echo $rasLink['title'];?></a></li>
                        
					<?php 
					}?>
                           
                    </ul>
                    <?php $linkContent= $mydb->getQuery('*','tbl_linkexchange_content','lid="'.$lid.'"');
					while($raslinkContent=$mydb->fetch_array($linkContent))
					{
					?>
            	<div class="lk">
                	<p><?php echo $raslinkContent['title'];?><br /><br />
               	 
                	               	    <a href="<?php echo $raslinkContent['url'];?>"><?php echo $raslinkContent['url'];?></a><br /><br />
                	  
                	  <?php echo stripslashes($raslinkContent['description']);?>
              	    </p>
            	</div><!--lk-->
                <?php }?>
            </div>
