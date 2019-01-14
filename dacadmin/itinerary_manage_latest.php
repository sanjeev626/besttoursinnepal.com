<?php
if(isset($_GET['pid']))
{
	$btnValue='Update';
	$pid = $_GET['pid'];
}

if(isset($_GET['del_iid']))
{
	$del_iid = $_GET['del_iid'];
	$mydb->deleteQuery('tbl_itinerary','id='.$del_iid);
}

if(isset($_POST['btnSubmit']) && $_POST['btnSubmit']=='Update')

{	

	if(isset($_POST['day']) && !empty($_POST['day']))

	{

		$data='';

		$data['pid']=$pid;

		$data['day']=$_POST['day'];

		$data['place']=$_POST['place'];

		$data['food']=$_POST['food'];

		$data['description']=$_POST['description'];

		$mydb->insertQuery('tbl_itinerary',$data);

	}	

	if(isset($_POST['nday'])){
		

		for($i=0;$i<count($_POST['nday']);$i++)
		{
	
			$data='';
	
			$data['pid']=$pid;
	
			$data['day']=$_POST['nday'][$i];
	
			$data['place']=$_POST['nplace'][$i];
			
			if(isset($_POST['service']) && $_POST['service']!=NULL)
			{
				$service= $_POST['service'];
				$noservice = implode($service[$i],'/*/');
			}
			else 
			$noservice = '';
	
			$data['services']=$noservice;
	
			$data['description']=$_POST['description'.$i];
	
			//$mydb->insertQuery('tbl_itinerary',$data);
	
		}
	}

	

	if(isset($_POST['itid']))

	{

		for($i=0;$i<count($_POST['itid']);$i++)

		{		

			$itid = $_POST['itid'][$i];

			$data='';

			$data['day']=$_POST['dayOld'][$i];

			$data['place']=$_POST['placeOld'][$i];

			$data['food']=$_POST['foodOld'][$i];

			$data['description']=$_POST['descriptionOld'.$itid];

			$mydb->updateQuery('tbl_itinerary',$data,'id='.$itid);

		}

	}

	//$mydb->redirect(ADMINURLPATH."itinerary_manage&pid=".$pid."&msg=1");

}

include("fckeditor/fckeditor.php") ;



$count = $mydb->getCount('id','tbl_itinerary','pid='.$pid);

if($count==0)

{

?>

<form action="" method="post" enctype="multipart/form-data" name="frmPage">

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="FormTbl">

  <tr>

    <td class="TitleBarB"><strong>Enter no of days : </strong>

      <input name="nod" type="text" class="inputbox" style="width:50px;" value="<?php if(isset($_POST['nod'])) echo $_POST['nod'];?>" /> <input type="submit" name="Add" id="Add" value="Add" class="button" /></td>

  </tr>

</table>

</form>

<?php

}

?>

<form action="" method="post" enctype="multipart/form-data" name="frmPage">

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="FormTbl">

  <tr class="TitleBar">

    <td colspan="3" class="TtlBarHeading">Manage Itinerary for <?php echo $mydb->getValue('title','tbl_package','id='.$pid);?></td>

  </tr>

  <?php if(isset($_GET['msg']) && $_GET['msg'] =='1'){ ?>

  <tr>

    <td colspan="3" class="adminsucmsg">Itinerary info has been updated.</td>

    </tr>

  <?php } ?>

  <tr>

    <td colspan="3">

    <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <?php

	$resItinerary = $mydb->getQuery('*','tbl_itinerary','pid='.$pid);

	while($rasItinerary = $mydb->fetch_array($resItinerary))

	{

	?>

      <tr>

        <td style="vertical-align:top; width:300px;" class="TitleBarA">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td class="TitleBarB"><strong>Day :</strong><br><input name="dayOld[]" type="text" class="inputbox" value="<?php echo $rasItinerary['day'];?>"></td>

          </tr>

          <tr>

            <td class="TitleBarB"><strong>Title :</strong><br>
              <input name="placeOld[]" type="text" class="inputbox" value="<?php echo $rasItinerary['place'];?>"></td>

          </tr>

          <tr>

            <td class="TitleBarB"><strong>Service :</strong><br />
              <input name="foodOld[]" type="text" class="inputbox" value="<?php echo $rasItinerary['food'];?>"></td>

          </tr>

          <tr>

            <td class="TitleBarB" style="text-align:right;"><input name="itid[]" type="hidden" value="<?php echo $rasItinerary['id'];?>"><a href="javascript:void(0);" onClick="callDelete('<?php echo ADMINURLPATH;?>itinerary_manage&pid=<?php echo $_GET['pid'];?>&del_iid=<?php echo $rasItinerary['id'];?>')"><img src="images/action_delete.gif" alt="Remove" width="24" height="24" title="Remove"></a></td>

          </tr>

        </table>        </td>

        <td class="TitleBarA">

        <?php

		$itid = $rasItinerary['id'];

		$description = stripslashes($rasItinerary['description']);

		$sBasePath = 'fckeditor/';

		

		$oFCKeditor = new FCKeditor('descriptionOld'.$itid);

		$oFCKeditor->BasePath = $sBasePath ;

		$oFCKeditor->Width = '100%' ;

		$oFCKeditor->Height = '270px' ;

		$oFCKeditor->Value = $description ;

		$oFCKeditor->Create() ;

		?>

        </td>

        </tr>

    <?php

	}

	if(isset($_POST['nod']) && $_POST['nod']>0)

	{

	$nod=$_POST['nod'];

	?>

    <tr>

        <td colspan="2"></td>

    </tr>

    <tr>

        <td colspan="2" class="TitleBarB"><strong>Add New</strong></td>

    </tr>

    <?php

		for($i=0;$i<$nod;$i++)

		{	

		?>

    	<tr>

        <td style="vertical-align:top; width:300px;" class="TitleBarA">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td class="TitleBarB"><strong>Day :</strong><br><input name="nday[]" type="text" class="inputbox" value="Day <?php echo $i+1;?>"></td>

          </tr>

          <tr>

            <td class="TitleBarB"><strong>Title :</strong><br><input name="nplace[]" type="text" class="inputbox">
            </td>

          </tr>

          <tr>

            <td class="TitleBarB"><strong>Service :</strong>
              <a href="#" id="addservice-<?php echo $i;?>" class="button" onclick="addServices('<?php echo $i;?>');">Add</a>&nbsp;<a href="#" id="removeservice-<?php echo $i;?>" class="button" onclick="removeServices('<?php echo $i;?>');">Remove</a><br /><br />
              <div id="services-<?php echo $i;?>"></div>
            </td>

          </tr>

        </table>

        </td>

        <td class="TitleBarA">

        <?php	

		$sBasePath = 'fckeditor/';

		

		$oFCKeditor = new FCKeditor('description'.$i) ;

		$oFCKeditor->BasePath = $sBasePath ;

		$oFCKeditor->Width = '100%' ;

		$oFCKeditor->Height = '270px' ;

		$oFCKeditor->Value = '' ;

		$oFCKeditor->Create() ;

		?>        </td>

        </tr>

	<?php

		}

    }

	if($count>0)

	{

	?>

    <tr>

        <td colspan="2"></td>

    </tr>

    <tr>

        <td colspan="2" class="TitleBarB"><strong>Add New</strong></td>

    </tr>

    <tr>

        <td style="vertical-align:top; width:300px;" class="TitleBarA">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td class="TitleBarB"><strong>Day :</strong><br><input name="day" type="text" class="inputbox"></td>

          </tr>

          <tr>

            <td class="TitleBarB"><strong>Title :</strong><br><input name="place" type="text" class="inputbox"></td>

          </tr>

          <tr>

            <td class="TitleBarB"><strong>Service :</strong><br><input name="food" type="text" class="inputbox"></td>

          </tr>

        </table>

        </td>

        <td class="TitleBarA">

        <?php	

		$sBasePath = 'fckeditor/';

		

		$oFCKeditor = new FCKeditor('description') ;

		$oFCKeditor->BasePath = $sBasePath ;

		$oFCKeditor->Width = '100%' ;

		$oFCKeditor->Height = '270px' ;

		$oFCKeditor->Value = '' ;

		$oFCKeditor->Create() ;

		?>        </td>

        </tr>

    <?php

	}

	if($count>0 || (isset($_POST['nod']) && $_POST['nod']>0))

	{

    ?>

    <tr>

      <td class="TitleBarA">&nbsp;</td>

    <td colspan="2" class="TitleBarA"><input type="submit" name="btnSubmit" id="btnSubmit" value="<?php echo $btnValue;?>" class="button" /></td>

    </tr>

    <?php

	}

	?>

    </table>
    </td>

  </tr>

</table>






</form>

<script type="text/javascript">
	function addServices(i){
		//var services = ('#services-'+i);
		//alert(i);

		//$('#services-'+i).attr('style','display:none');
		$('#services-'+i).append('<div><input type="text" class="inputbox" name="service['+i+'][]" id="service['+i+'][]"></div>');
	
	}
	
	function removeServices(i){
		alert(i);	
	}
	
</script>
