<link rel="stylesheet" type="text/css" href="dropdown/chrometheme/chromestyle.css" />

<script type="text/javascript" src="dropdown/chromejs/chrome.js">

/***********************************************
* Chrome CSS Drop Down Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>

<div class="chromestyle" id="chromemenu">
    <ul>
        <li><a href="index.php" title="Return Home">HOME</a></li>
        <li><a rel="dropmenu1" href="javascript:void(0);" title="CHANGE CONFIGURATION">CONFIG</a></li>
        <li><a rel="dropmenu2" href="<?php echo ADMINURLPATH; ?>pages" title="PAGES">PAGES</a></li>        
        <li><a href="<?php echo ADMINURLPATH; ?>country" title="MANAGE COUNTRY">COUNTRY</a></li>
        <li><a rel="dropmenu3" href="<?php echo ADMINURLPATH; ?>activity" title="MANAGE ACTIVITY">ACTIVITY</a></li>
        <li><a href="<?php echo ADMINURLPATH; ?>team" title="MANAGE ">MEMBERS</a></li>
        <li><a href="<?php echo ADMINURLPATH; ?>testimonial" title="MANAGE TESTIMONIAL">TESTIMONIAL</a></li> 
        <li><a href="<?php echo ADMINURLPATH; ?>linkexchange" title="LINK EXCHANGE">LINK EXCHANGE</a></li>
        <li><a href="<?php echo ADMINURLPATH; ?>faqs" title="MANAGE FAQs">FAQs</a></li>
        <li><a href="<?php echo ADMINURLPATH; ?>booking" title="MANAGE BOOKING">BOOKING</a></li>
    </ul>
</div>

<!--1st drop down menu -->                                                   
    <div id="dropmenu1" class="dropmenudiv">
    <a href="<?php echo ADMINURLPATH; ?>config">Change Config</a>
    <a href="<?php echo ADMINURLPATH; ?>changepass">Change Password</a>
</div>
<div id="dropmenu2" class="dropmenudiv">
<?php
$result = $mydb->getQuery('*','tbl_page','1 ORDER BY ordering');
while($rasPage = $mydb->fetch_array($result))
{
?>
    <a href="<?php echo ADMINURLPATH; ?>pagesUpdate&pid=<?php echo $rasPage['id'];?>"><?php echo $rasPage['page'];?></a>
<?php
}
?>
</div>
<div id="dropmenu3" class="dropmenudiv">
<?php
$result = $mydb->getQuery('*','tbl_activity','1 ORDER BY ordering');
while($rasActivity = $mydb->fetch_array($result))
{
?>
    <a href="<?php echo ADMINURLPATH; ?>package&aid=<?php echo $rasActivity['id'];?>"><?php echo $rasActivity['title'];?></a>
<?php
}
?>
</div>
<script type="text/javascript">
	cssdropdown.startchrome("chromemenu");
</script>