<div class="lcont">
    <div class="tripdetail">
        <h1><?php echo $title;?></h1>
        <div class="tdes">
            <?php echo $contents;?>
        </div><!--tdes-->  
        <div>
        </div>
    </div><!--tripdetail-->
</div><!--lcont-->
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