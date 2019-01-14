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
		$noservice='';
		$data['pid']=$pid;

		$data['day']=$_POST['day'];

		$data['place']=$_POST['place'];

		if(isset($_POST['service']) && $_POST['service']!=NULL)
			{
				$service= $_POST['service'][0];
				$noservice = implode($service,'---');
			}
			
		$data['services']=$noservice;
		$data['description']=$_POST['description'];
		//print_r($data);

		$mydb->insertQuery('tbl_itinerary',$data);

	}	

	if(isset($_POST['nday'])){

		for($i=0;$i<count($_POST['nday']);$i++)
		{
	
			$data='';
			$noservice='';
	
			$data['pid']=$pid;
	
			$data['day']=$_POST['nday'][$i];
	
			$data['place']=$_POST['nplace'][$i];
			
			if(isset($_POST['nservice']) && $_POST['nservice']!=NULL)
			{
				$service= $_POST['nservice'][$i];
				$noservice = implode($service,'---');
			}
	
			$data['services']=$noservice;
	
			$data['description']=$_POST['description'.$i];
			
			$mydb->insertQuery('tbl_itinerary',$data);
	
		}
	}

	

	if(isset($_POST['itid']))

	{
		
		

		for($i=0;$i<count($_POST['itid']);$i++)

		{		

			$itid = $_POST['itid'][$i];

			$data='';
			$noservice='';

			$data['day']=$_POST['dayOld'][$i];

			$data['place']=$_POST['placeOld'][$i];
			
			if(isset($_POST['serviceOld']) && $_POST['serviceOld']!=NULL)
			{
				$service= $_POST['serviceOld'][$i];
				$noservice = implode($service,'---');
			}
			//echo $noservice;
			
	
			$data['services']=$noservice;

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
	
	$flag=0;
	
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
          <?php 
		  $services='';	
		  $services=explode('---',$rasItinerary['services']);
		  ?>
            <td class="TitleBarB"><strong>Service :</strong>
            <?php for($i=0;$i<3;$i++){?>
            <br /><input type="text" class="inputbox" name="serviceOld[<?php echo $flag;?>][]" value="<?php echo $services[$i];?>" id="serviceOld[<?php echo $flag;?>][]" >
            <?php }?>
              </td>

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
	$flag++;

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

            <td class="TitleBarB"><strong>Service :</strong><br />
            <?php for($j=0;$j<3;$j++){?>
            <input type="text" class="inputbox" name="nservice[<?php echo $i;?>][]" id="nservice[<?php echo $i;?>][]"><br />
 <?php }?>
              <table id="table-<?php echo $i?>" border="0" cellspacing="0" cellpadding="0">
              </table>
              
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

            <td class="TitleBarB"><strong>Service :</strong><br>
            <?php for($j=0;$j<3;$j++){?>
            <input type="text" class="inputbox" name="service[0][]" id="service[0][]"><br />
            <?php }?>
            </td>

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

<script>
var numrows = 0;

function draw_desp(id){
	numrows++;
	var tb1=document.getElementById("table-"+id)
	var targetnumrows=numrows;
	i=numrows;
	
	var linebreak = "<br />"
	
	var row = tb1.insertRow(tb1.rows.length);

	var cell=row.insertCell(0);
	var despfield1 = document.createElement("input");
	despfield1.setAttribute("id","service"+(numrows+i));
	despfield1.setAttribute("name","service["+id+"][]");
	despfield1.setAttribute("type","textbox");
	despfield1.setAttribute("class","inputbox");
	cell.appendChild(despfield1);	
	//<input type="text" class="inputbox" name="service['+i+'][]" id="service['+i+'][]">
	
}

function delete_rows(id)
{
	var tbl = document.getElementById("table-"+id);
	if(tbl.rows.length>0)
		tbl.deleteRow(tbl.rows.length-1);
	else
		alert('No More Rows to Delete');
} 


window.onload=draw_desp;
</script>


