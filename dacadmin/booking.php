<?php
if(isset($_POST['btnSave']))
{
	//print_r($data);
  $tid = $_POST['bid'];
	$data='';
	$data['payment_status'] = $_POST['payment_status'];
  $is_delete = $_POST['is_delete'];
  if($is_delete=="Y"){
    $mydb->deleteQuery('tbl_booking','id='.$tid);
  }
  else{
    $data = array("payment_status"=>$_POST['payment_status']);
    $mydb->updateQuery('tbl_booking',$data,'id='.$tid);
  }
	$url = ADMINURLPATH."booking&message=Payment Status updated successfully.";
	$mydb->redirect($url);
}

?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="FormTbl">
  <tr>
    <td>
    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="FormTbl" style="font-size:12px;">
        <?php if(isset($_GET['message'])){?>
        <tr>
          <td colspan="8" class="message"><?php echo $_GET['message']; ?></td>
        </tr>
        <?php } ?>        
        <tr class="TitleBar">
          <td class="TtlBarHeading" colspan="8">Booking Information</td>
        </tr>
        <tr class="TitleBar">
          <td>SN</td>
          <td>Trip Date</td>
          <td>Booking Number</td>
          <td>Client Name</td>
          <td>Trip name</td>
          <td>Payment Status</td>
          <td>Delete ?</td>         
          <td>Option</td>
        </tr>
        <?php
		$counter=0;		
		$resBook = $mydb->getQuery('*','tbl_booking','1 ORDER BY tripdate DESC');
		while($rasBook=$mydb->fetch_array($resBook))
		{
		$id = $rasBook['id'];
		?>
    	<form action="" method="post">
        <tr class="TitleBarB">
          <td><?php echo ++$counter; ?></td>
          <td>
          	<input name="bid" type="hidden" value="<?php echo $rasBook['id']; ?>" />
          	<?php echo $rasBook['tripdate'];?>
          </td>
          <td><?php echo $rasBook['booking_number']; ?></td>
          <td><?php echo stripslashes($rasBook['client_name']);?></td>
          <td><?php echo $rasBook['tripname'];?></td>
          <td>
          	<select name="payment_status" id="payment_status">
          	  <option value="N" <?php if($rasBook['payment_status']=='N') echo "selected"; ?>>No</option>
          	  <option value="Y" <?php if($rasBook['payment_status']=='Y') echo "selected"; ?>>Yes</option>
          	</select>
          </td> 
          <td>
            <select name="is_delete" id="is_delete">
              <option value="N" selected>No</option>
              <option value="Y">Yes</option>
            </select>
          </td>          
          <td><input type="submit" name="btnSave" id="btnSave" value="Save" class="button" /></td>
        </tr>
    	</form> 
        <?php
		}
		?>
      </table> 
    </td>
  </tr>
</table>
