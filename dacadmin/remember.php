<?php
$result = $mydb->getQuery('*','tbl_remember','1 ORDER BY ordering');
$count = mysql_num_rows($result);
if($count != 0)
{
?>
  <table cellpadding="0" cellspacing="0" border="0" width="100%" class="FormTbl">
  <tr class="TitleBar">
    <td class="TtlBarHeading" colspan="4">Page List</td>
  </tr>
    <tr>
      <td width="5%" align="center" class="TitleBarB"><strong>S.N</strong></td>
      <td width="20%" class="TitleBarB"><strong> Title</strong></td>
      <td class="TitleBarB"><strong>Contents</strong></td>
      <td width="5%" class="TitleBarB">&nbsp;</td>
    </tr>
    <?php
    $counter = 0;
    while($rasProduct = $mydb->fetch_array($result))
    {
    ?>
    <tr>
      <td class="TitleBarA" align="center"><?php echo ++$counter;?></td>
      <td class="TitleBarA"><?php echo stripslashes($rasProduct['title']);?></td>
      <td class="TitleBarA"><?php echo substr(strip_tags($rasProduct['contents']),0,300); if(strlen(stripslashes($rasProduct['contents']))>300) echo '...';?></td>
      <td class="TitleBarA" align="center"><a href="<?php echo ADMINURLPATH; ?>rememberUpdate&pid=<?php echo $rasProduct['id'];?>"><img src="images/action_edit.gif" alt="Edit" width="24" height="24" title="Edit"></a></td>
    </tr>
    <?php
    }
    ?>
  </table>
<?php
}
?>