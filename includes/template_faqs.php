<div class="lcont">
        	<div class="tripdetail">
            	<h1>FAQs - Frequently Asked Questions</h1>
                <div>
                	<p>
                   
Please read FAQs section before travelling to Nepal.
                    </p>
                    
					<?php 
                    $result=$mydb->getQuery('*','tbl_faqs');
                    while($rasFaqs = $mydb->fetch_array($result))
                    {						
                        $faqcontents = stripslashes($rasFaqs['contents']);
                        $faqcontents = substr($faqcontents,0,230);
                    ?>
                    <div class="faqt">
                	<h2><a href="<?php echo SITEROOT.$rasFaqs['urlcode'].'.html';?>"><?php echo stripslashes($rasFaqs['title']);?></a></h2>
                    <?php echo $faqcontents;?>
                    <br /><br />
                    <a href="<?php echo SITEROOT.$rasFaqs['urlcode'].'.html';?>">read more</a>
                </div><!--faqt-->
                
					<?php 
					} 
					?>
                </div><!--tdes-->
                         

            </div><!--tripdetail-->
        </div>

<!--lcont-->
<div class="rcont">

<?php
$resActivity = $mydb->getQuery('id,urlcode,title,activityimage','tbl_activity','cid=1 ORDER BY ordering LIMIT 5');
while($rasActivity = $mydb->fetch_array($resActivity))
{
	$aid = $rasActivity['id'];
?>
<a href="<?php echo SITEROOT.$rasActivity['urlcode'].'.html';?>"><?php echo stripslashes($rasActivity['title']);?></a>
    
    
    <div class="trplist">
      <ul>
        <?php
		    $resPackage = $mydb->getQuery('urlcode,title','tbl_package','aid='.$aid.' LIMIT 100');
		    while($rasPackage=$mydb->fetch_array($resPackage))
		    {
        ?>
        <li><a href="<?php echo SITEROOT.$rasActivity['urlcode'].'/'.$rasPackage['urlcode'].'.html';?>"><?php echo stripslashes($rasPackage['title']);?></a></li>
        <?php
      	}
    		?>
      </ul>
    </div><!--trplist-->
    
  
<?php
}
?>

</div><!--rcont-->