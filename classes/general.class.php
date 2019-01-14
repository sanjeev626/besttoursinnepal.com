<?php

class general extends mydb{

	function Pager($task,$option,$id,$MaxPage,$CounterStart,$StartRow,$PageNo,$PageSize,$CounterEnd){

		$paging = "";

		 //Print First & Previous Link is necessary

        if($CounterStart != 1){

            $PrevStart = $CounterStart - 1;

            $paging .= "<a href=index.php?task=$task&option=$option&id=$id&PageNo=1><< Start</a> ";

            $paging .= "<a href=index.php?task=$task&option=$option&id=$id&PageNo=$PrevStart>< Previous </a>";

        }

        $c = 0;

        //Print Page No

        for($c=$CounterStart;$c<=$CounterEnd;$c++){

            if($c < $MaxPage){

                if($c == $PageNo){

                    if($c % $PageSize == 0){

                        $paging .=  "$c ";

                    }else{

                        $paging .=  "$c ,";

                    }

                }elseif($c % $PageSize == 0){

                    $paging .=  "<a href=index.php?task=$task&option=$option&id=$id&PageNo=$c>$c</a> ";

                }else{

                    $paging .=  "<a href=index.php?task=$task&option=$option&id=$id&PageNo=$c>$c</a> ,";

                }//END IF

            }else{

                if($PageNo == $MaxPage){

                    $paging .=  "$c ";

                    break;

                }else{

                    $paging .=  "<a href=index.php?task=$task&option=$option&id=$id&PageNo=$c>$c</a> ";

                    break;

                }//END IF

            }//END IF

       }//NEXT

      if($CounterEnd < $MaxPage){

          $NextPage = $CounterEnd + 1;

          $paging .=  "<a href=index.php?task=$task&option=$option&id=$id&PageNo=$NextPage>Next ></a> ";

      }

      //Print Last link if necessary

      if($CounterEnd < $MaxPage){

       $LastRec = $RecordCount % $PageSize;

        if($LastRec == 0){

            $LastStartRecord = $RecordCount - $PageSize;

        }

        else{

            $LastStartRecord = $RecordCount - $LastRec;

        }      

        $paging .=  "<a href=index.php?task=$task&option=$option&id=$id&PageNo=$MaxPage>End >></a>";

        }

		return $paging;

	}

	//PAGER INFORMATION

	function PagingInformation($RecordCount,$PageNo){

		return "Results $RecordCount  - You are at page $PageNo";

	}

	//CSV PARSE

	function parseCSVComments($comments) {

	  $comments = str_replace('"', '""', $comments); 

	  if(eregi(",", $comments) or eregi("\n", $comments)) { 

		return '"'.$comments.'"'; 

	  } else {

		return $comments; 

	  }

	}

	//LIMIT TEXT DISPLAY

	function TextDisplay($text,$num){

		if ($num) {

			$texts = explode( ' ', $text );

			$count = count( $texts );

			if($count > $num){

				$text = '';

				for( $i=0; $i < $num; $i++ ) {

					$text .= ' '. $texts[$i];

				}

				$text .= '...';

			}

		}

		return $text;

	}

	//RETURNS unixtime STAMP FOR A GIVEN DATE TIME FROM DB

	function dttm2unixtime($dttm2timestamp_in){

		$date_time = explode(" ", $dttm2timestamp_in);

		$date = explode("-",$date_time[0]); 

		$time = explode(":",$date_time[1]); 

		unset($date_time);

		list($year, $month, $day) = $date;

		list($hour,$minute,$second) = $time;

		return mktime(intval($hour), intval($minute), intval($second), intval($month), intval($day), intval($year));

	}

	//PARAMETER DATE ONLY, NO TIME

	function SimpleDate($dttm2timestamp_in){

		$date_time = explode(" ", $dttm2timestamp_in);

		$date = explode("-",$date_time[0]); 

		unset($date_time);

		list($year, $month, $day) = $date;

		return mktime(intval(0), intval(0), intval(0), intval($month), intval($day), intval($year));

	}

	//DATE DIFERENCE

	function Date_Diff($date1, $date2){

		 $s = strtotime($date2)-strtotime($date1);

		 $d = intval($s/86400); 

		 $s -= $d*86400;

		 $h = intval($s/3600);

		 $s -= $h*3600;

		 $m = intval($s/60); 

		 $s -= $m*60;

		 return $d."/".$h;

	}	

	//FIRST DAY OF MONTH

	function FirstDayofmonth(){

	 	$res = mysql_fetch_array($this->Execute_Query("SELECT ((PERIOD_ADD(EXTRACT(YEAR_MONTH FROM CURDATE()),0)*100)+1) as FirstDayOfTheMonth"));

		return $res["FirstDayOfTheMonth"];

	}

	//LAST DAY OF MONTH

	function LastDayofMonth(){

		$res = mysql_fetch_array($this->Execute_Query("SELECT (SUBDATE(ADDDATE(CURDATE(),INTERVAL 1 MONTH),INTERVAL DAYOFMONTH(CURDATE())DAY)) AS LastDayOfTheMonth"));

		return $res["LastDayOfTheMonth"];

	}

	//LINK ACTION 

	function LinkAction($getid,$dbid){

		if($getid == $dbid) { $action = IMAGEARROW; }

		else { $action = IMAGEEDIT; }

		return $action;

	}

	//STATUS IMAGE 

	function StatusImage($status){

		if($status == "Y") { $img = PUBLISHED; $status = "Published"; }

		else { $img = LOCKED; $status = "Locked";}

		return $img;

	}

	//EMAIL VALIDATION

	function ValidateEmailAddress($email){

		if(!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)){

			return false;

		}

		//Split it into sections to make life easier

		$email_array = explode("@", $email);

		$local_array = explode(".", $email_array[0]);

		for($i = 0; $i < sizeof($local_array); $i++){

			if(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])){

				return false;

			}

		}  

		if(!ereg("^\[?[0-9\.]+\]?$", $email_array[1])){ // Check if domain is IP. If not, it should be valid domain name

			$domain_array = explode(".", $email_array[1]);

			if(sizeof($domain_array) < 2){

				return false; // Not enough parts to domain

			}

			for($i = 0; $i < sizeof($domain_array); $i++){

				if(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])){

					return false;

				}

			}

		}

		return true;

	}

    //ENCRYPTION/DECRYPTION

    function get_rnd_iv($iv_len){

	   $iv = '';

	   while ($iv_len-- > 0) {

		   $iv .= chr(mt_rand() & 0xff);

	   }

	   return $iv;

    }

	//ENCRYPTION

    function md5_encrypt($plain_text, $password, $iv_len = 16){

	   $plain_text .= "\x13";

	   $n = strlen($plain_text);

	   if ($n % 16) $plain_text .= str_repeat("\0", 16 - ($n % 16));

	   $i = 0;

	   $enc_text = $this->get_rnd_iv($iv_len);

	   $iv = substr($password ^ $enc_text, 0, 512);

	   while ($i < $n) {

		   $block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));

		   $enc_text .= $block;

		   $iv = substr($block . $iv, 0, 512) ^ $password;

		   $i += 16;

	   }

	   return base64_encode($enc_text);

   }

   //DECRYPTION

   function md5_decrypt($enc_text, $password, $iv_len = 16)

   {

	   $enc_text = base64_decode($enc_text);

	   $n = strlen($enc_text);

	   $i = $iv_len;

	   $plain_text = '';

	   $iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);

	   while ($i < $n) {

		   $block = substr($enc_text, $i, 16);

		   $plain_text .= $block ^ pack('H*', md5($iv));

		   $iv = substr($block . $iv, 0, 512) ^ $password;

		   $i += 16;

	   }

	   return preg_replace('/\\x13\\x00*$/', '', $plain_text);

	}

   //GENERATE RAMDOM TEXT

    function Randomtext($nameLength){

	 	 $NameChars = '012346789abcdefghijklmnopqrstuvwxyz';

		 $Vouel = 'aeiou';

		 $Name = "";

		 for ($index = 1; $index <= $nameLength; $index++){ 

			if ($index % 3 == 0){

		  		$randomNumber = rand(1,strlen($Vouel));

		  		$Name .= substr($Vouel,$randomNumber-1,1); 

			}

			else{

		 	    $randomNumber = rand(1,strlen($NameChars));

		  		$Name .= substr($NameChars,$randomNumber-1,1);

	   		} 

	 	}

	    return $Name;

	}

	//DATE

	function HeaderDate(){

		$arrDay = array ("Sunday", "Monday", "Tuesday", "Wednusday", "Thrusday", "Friday","Saturday");

		return $arrDay[date(w)].", ".date("F j, Y"); 

	}

	//PAGING INFO

	function PagingInfo(){

		if(isset($_POST["txtdisplay"])){

			$PageSize=$_POST["txtdisplay"];

		}

		else{

			$PageSize = 20;

		}

		$StartRow = 0;

		//Set the page no

		if(empty($_GET['PageNo'])){

			if($StartRow == 0){

				$PageNo = $StartRow + 1;

			}

		}else{

			$PageNo = $_GET['PageNo'];

			$StartRow = ($PageNo - 1) * $PageSize;

		}

		//Set the counter start

		if($PageNo % $PageSize == 0){

			$CounterStart = $PageNo - ($PageSize - 1);

		}else{

			$CounterStart = $PageNo - ($PageNo % $PageSize) + 1;

		}

		//Counter End

		$CounterEnd = $CounterStart + ($PageSize - 1);

	}

	//GET IMAGE FILE TYPE

	function GetFileType($filename){

		$arr = split("\.",$filename);

		$type = strtoupper($arr[count($arr)-1]);

		if ($type == "JPEG")

			$type = "JPG";

		if ($type=="JPG" || $type =="GIF" || $type=="PNG")

			return $type;

		else

			return false;

	}

	//GET VIDEO FILE TYPE

	function GetFileTypeVideo($filename){

		$arr = split("\.",$filename);

		$type = strtoupper($arr[count($arr)-1]);

		if ($type=="wmv" || $type =="avi" || $type =="mov")

			return $type;

		else

			return false;

	}

	function GetFileTypeSWFfile($filename){

		$arr = split("\.",$filename);

		$type = strtoupper($arr[count($arr)-1]);

		if ($type == "SWF")

			return true;

		else

			return false;

	}

	//RESIZE IMAGE

	function ResizeImage($file,$originalpath,$destinationpath,$width,$height){

		$new_w = $width;

		$new_h = $height;	

		if ($handle = opendir($originalpath)) {

			$file = $file;

			$file_type = $this->getFileType($file);

			if ($file_type == false){

				//echo "<br> -->Not an Image file.<BR>";

				//continue;

			}

			$filename = $originalpath."".$file;

			switch($file_type){

				case "GIF":

					$src_img=@imagecreatefromgif($filename);

					break;

				case "JPG":

					$src_img=imagecreatefromjpeg($filename);

					break;		

				case "PNG":

					$src_img=imagecreatefrompng($filename);

					break;		

				default:

					continue;

			}

			$old_w 		= 	imagesx($src_img);

			$old_h 		= 	imagesy($src_img);

			$dst_img 	=	imageCreateTrueColor($new_w,$new_h); 

			imagecopyresampled($dst_img,$src_img,0,0,0,0,$new_w,$new_h,$old_w,$old_h);

			$thumbnail = $destinationpath."".$file;

			switch($file_type){

				case "GIF":

					$src_img=@imagegif($dst_img,$thumbnail);

					break;

				case "JPG":

					$src_img=imagejpeg($dst_img,$thumbnail);

					break;		

				case "PNG":

					$src_img=imagepng($dst_img,$thumbnail);

					break;		

				default:

					continue;

			}

		}

		closedir($handle); 

	}

	//TIME

	function GetTime($timestamp){

		return date('M d Y h:i:s A',$timestamp+(5*60*60)+(45*60));

	}

	//Mail link

	function MailLink($email){

		return "<a href='mailto:".$email."'>".$email."</a>";

	}

	

	function selectmenu($menuname,$rs,$value='',$width='',$class='',$extra=''){

		$str= "<select name=\"$menuname\" class=".$class." ".$extra.">" ;

		$str.="<option value='na' style='width:".$width."px;'>Select</option>";	

		while($ras = $this->fetch_array($rs))

		{

			if($ras[0]==$value){$selected="selected=\"selected\"";}else{$selected="";}

			$str.="<option value=\"".$ras[0]."\" ".$selected." style='width:".$width."px;' class=".$class.">".$ras[1]."</option>";

		}		

		$str.= "</select>";

		return $str;		

	}

	

	function selectmenuoption($menuname,$option='',$value='',$width='',$class=''){

		$str= "<select name=\"$menuname\" class=".$class.">";

		for($i=0;$i<count($option);$i++)

		{

			if($option['value'][$i]==$value){$selected="selected=\"selected\"";}else{$selected="";}

			$str.="<option value=\"".$option['value'][$i]."\" ".$selected." style='width:".$width."px;' class=".$class.">".$option['title'][$i]."</option>";

		}		

		$str.= "</select>";

		return $str;		

	}

	

	function textbox($name,$id,$value='',$class='',$extra=''){

		$str= "<input name='".$name."' id='".$id."' type='text' class='".$class."' value='".$value."' ".$extra.">";

		return $str;		

	}

	

	function passbox($name,$id,$value='',$class='',$extra=''){

		$str= "<input name='".$name."' id='".$id."' type='password' class='".$class."' value='".$value."' ".$extra.">";

		return $str;		

	}

	

	function inputbox($name,$id,$type,$value='',$class='',$extra=''){

		$str= "<input name='".$name."' id='".$id."' type='".$type."' class='".$class."' value='".$value."' ".$extra."/>";

		return $str;		

	}

	

	function button($name,$id,$type,$value,$class='',$onclick='')

	{

		$str= "<input name='".$name."' id='".$id."' type='".$type."' value='".$value."' class='".$class."' onclick='".$onclick."' />";

		return $str;

	}

	

	function filefield($name,$id,$class='',$extra=''){

		$str= "<input name='".$name."' id='".$id."' type='file' class='".$class."' ".$extra.">";

		return $str;		

	}

	

	function createImage($src,$alt='',$width='',$class='',$onclick='')

	{

		$str= "<img src='".$src."' alt='".$alt."' width='".$width."px;'' class='".$class."' onclick='".$onclick."' border='0' />";

		return $str;

	}

	

	function textarea($name,$id,$value='',$rows,$cols,$class='',$extra='')

	{

		$str= "<textarea name='".$name."' cols='".$cols."' rows='".$rows."' ".$extra.">".$value."</textarea>";

		return $str;

	}

	

	function ahref($href='',$value,$class='',$onclick='')

	{

		$str = "<a href='".$href."' onclick='".$onclick."' class='".$class."'>".$value."</a>";

		return $str;

	}

	function getTotalWeight()
	{
		$total=0;		
		$resCart = $this->getQuery('pid,quantity','tbl_cart','orderno='.$_SESSION[ORDERNO]);
		while($rasCart=$this->fetch_array($resCart))
		{
			$pid = $rasCart['pid'];
			$quantity = $rasCart['quantity'];
			$weight = $this->getValue('weight','tbl_product','id='.$pid);
			$total+=$quantity*$weight;
		}
		return number_format($total,2);
	}
	
	
	function getTotal()
	{
		$total=0;
		
		$resCart = $this->getQuery('pid,quantity','tbl_cart','orderno='.$_SESSION[ORDERNO]);
		while($rasCart=$this->fetch_array($resCart))
		{
			$pid = $rasCart['pid'];
			$quantity = $rasCart['quantity'];
			$price = number_format(($this->getValue('price','tbl_product','id='.$pid)/$_SESSION['CURRENCY']),2);
			$total+=$quantity*$price;
		}
		return number_format($total,2);
	}
	
	function countCartProducts()
	{		
		$count = $this->getCount('id','tbl_cart','orderno='.$_SESSION[ORDERNO]);
		return $count;
	}
	
	function getShippingPrice($smid,$weight)
	{
		$priceperkg = $this->getValue('peiceperkg','tbl_shippingprice','smid = '.$smid.' AND '.$weight.' BETWEEN fromweight AND toweight');
		$price = $priceperkg/$_SESSION['CURRENCY'];
		return number_format($price,2);
	}

}//CLASS ENDS



$generalObj = new general();

?>