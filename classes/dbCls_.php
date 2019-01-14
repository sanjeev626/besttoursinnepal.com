<?php

class mydb{



	function opendb(){

		mysql_connect(DBSERVER,DBUSER,DBPASSW);

		mysql_select_db(DBNAME);

	}

	

	function query($sql)

	{

		$result = mysql_query($sql);

		if($result)

		{

			return $result;

		}

		else

		{

			echo mysql_error();

		}

	}



	function fetch_array($result)

	{

		return mysql_fetch_array($result);

	}

	

	function count_row($result)

	{

		return mysql_num_rows($result);

	}

	

	function insert_id()

	{

		return mysql_insert_id();

	}

	

	function redirect($url)

	{

		echo "<script language='javascript'>document.location='".$url."';</script>";

	}

	

	function insertQuery($tablename,$data,$print="0")

	{

		$counter = 0;

		$sql = "INSERT INTO $tablename SET ";

		foreach($data as $key=>$value)

		{

			++$counter;

			$sql.=$key."='".addslashes(trim($value))."'";

			if($counter<count($data))

			{

				$sql .=", ";

			}

		}

		//echo $sql."<br>";

		$this->query($sql);

		if($print==1) return $sql;

		else return $this->insert_id();		

	}

	

	function updateQuery($tablename,$data,$condition,$print="0")

	{

		$counter = 0;

		$sql = "UPDATE $tablename SET ";

		foreach($data as $key=>$value)

		{

			++$counter;

			$sql.=$key."='".addslashes(trim($value))."'";

			if($counter<count($data))

			{

				$sql .=", ";

			}

		}

			$sql .= " WHERE $condition";

		//echo $sql."<br>";

		if($print==1) 

		{

			return $sql;

			exit();

		}

		else

		{

			if($this->query($sql))

			{

				return ucfirst(str_replace("_"," ",str_replace("tbl_","",$tablename)))." info has been Updated Successfully.";

			}

			else

			{

				return "ERROR! failed to update ".$tablename." Info.";

			}

		}

	}

	

	function deleteQuery($tablename,$condition,$print="0")

	{

		$sql = "DELETE FROM $tablename WHERE $condition";

		if($print==1) return $sql;

		else

		{				

			if($this->query($sql))

			{

				return "The selected ".ucfirst(str_replace("_"," ",str_replace("tbl_","",$tablename)))." has been deleted Successfully.";

			}

			else

			{

				return "ERROR! failed to delete selected ".ucfirst(str_replace("_"," ",str_replace("tbl_","",$tablename))).".";

			}

		}

	}

	

	function getQuery($fields,$tablename,$condition="1=1",$print="0")

	{

		$sql = "SELECT $fields FROM $tablename WHERE $condition";

		//echo $sql."<br>";

		if($print==0)

		{

			$res = $this->query($sql);

			return $res;

		}

		else

		{

			return $sql;

		}

	}

	

	function getArray($fields,$tablename,$condition="1=1",$print="0")

	{

		$sql = "SELECT $fields FROM $tablename WHERE $condition";

		//echo $sql;

		if($print==1) return $sql;

		else

		{

			$res = $this->query($sql);

			$ras = $this->fetch_array($res);

			return $ras;

		}

	}

	

	function getValue($field,$tablename,$condition="1=1",$print="0")

	{

		$sql = "SELECT $field FROM $tablename WHERE $condition";

		//echo $sql;echo "<br>";

		if($print==1) return $sql;

		else

		{

			$res = $this->query($sql);

			$ras = $this->fetch_array($res);

			return $ras[$field];

		}

	}

	

	function getCount($field,$tablename,$condition="1=1",$print="0")

	{

		$sql = "SELECT $field FROM $tablename WHERE $condition";

		//echo $sql;echo "<br>";

		if($print==1) return $sql;

		else

		{

			$res = $this->query($sql);

			$count = $this->count_row($res);

			return $count;

		}

	}

	

	function sendEmail($toName,$toEmail,$fromName,$fromEmail,$subject,$message)

	{		

		// To send HTML mail, the Content-type header must be set

		$headers  = 'MIME-Version: 1.0' . "\r\n";

		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		

		// Additional headers

		$headers .= 'To: '.$toName.' <'.$toEmail.'>' . "\r\n";

		$headers .= 'From: '.$fromName.' <'.$fromEmail.'>' . "\r\n";

		

		// Mail it

		if(@mail($toEmail, $subject, $message, $headers))

			return true;

		else

			return false;

	}

	

	//Get status	

	function GetStatus($id)

	{}

	

	function changeStatus($table,$field,$id,$st)

	{

		

		if($st == 0)

			$status = 1;

		else

			$status = 0;

			

		$sql="update $table set

										$field = '$status'

										where id = '$id'

										 ";

		$result=$this->query($sql);

		return($result);

	}

	

	function getminfromtable($table,$field,$condition)

	{

		if($condition == '')

			$sql="select min($field) as minsort from $table";

		else

			$sql="select min($field) as minsort from $table where $condition";

		$result= $this->query($sql);

		$row= $this->fetch_array($result);

		return($row['minsort']);

	}

	function getmaxfromtable($table,$field,$condition)

	{

		if($condition == '')

			$sql="select max($field) as maxsort from $table";

		else

			$sql="select max($field) as maxsort from $table where $condition";

		$result= $this->query($sql);

		$row= $this->fetch_array($result);

		return($row['maxsort']);

	}

	function getnextid($table,$field,$limit,$condition)

	{

		

		$lt=$limit;

		$var2 = 0;

		if($condition == '')

			$sql="SELECT * FROM $table ORDER BY $field LIMIT 0,$lt";

		else

			$sql="SELECT * FROM $table where $condition ORDER BY $field LIMIT 0,$lt";

		//echo $sql;exit;

		$result=$this->query($sql);

		$cnt=0;

		while($row = $this->fetch_array($result))

		{

			$cnt++;

			$var1	= $row[$field];

			if($var1>$var2)

			{

				$var2 = $var1;	

			}

			

		}

		//echo $var2;exit;

			return($var2);

		

	}

	function getpreviousid($table,$field,$limit,$condition)

	{

		

		$lt=$limit-2;

		$var2 = 0;

		if($condition == '')

			$sql="SELECT * FROM $table ORDER BY $field LIMIT 0,$lt";

		else

			$sql="SELECT * FROM $table where $condition ORDER BY $field LIMIT 0,$lt";

		

		$result=$this->query($sql);

		

		while($row = $this->fetch_array($result))

		{

			

			$var1	= $row[$field];

			if($var1>$var2)

			{

				$var2 = $var1;	

			}

			

			

		}

			

		while($row = $this->fetch_array($result))

		{	

			

			$var3	= $row[$field];

			if($var2 < $var3)

			{

				$var2 = $var3;	

			}

			

		}

		return($var2);

		

	}

	function swapingproductsortby($table,$field,$pid,$sortby,$nextpid,$nextsortby)

	{

		

		$sql="update $table set $field = '$nextsortby' where id = '$pid'";

		$result= $this->query($sql);

		

		$sql="update $table set $field = '$sortby' where id = '$nextpid'";

		$result= $this->query($sql);

		

		

	}

	

	

	function getSortby($table,$id,$sortby)

	{

		$sql="select $sortby from $table where id = '$id'";

		$result= $this->query($sql);

		$row= $this->fetch_array($result);

		return($row[$sortby]);

	}

	

	function logout($what,$flag)

	{

		for($i=0;$i<count($what);$i++)

		{

			unset($_SESSION[$what[$i]]);

		}

		

		if($flag == 1)

			session_destroy();

			

		return(true);

	}

	

	//Display Number in two digits	

	function NumberDisplayTotwodigit($number)

	{

		return number_format($number, 2, '.', '');

	}

// Display Description 	

	function displaydescription($des,$number)

	{

		$string = strip_tags($des);

		$count=strlen($string);

		$count1=$count -0;

		if($number < $count)

		{

			$str=substr($string,0,$number)."...".substr($string,$count1,$count);

		}

		else

		{

			$str=$string;

		}

		return($str);



	}

	function doone($onestr) 

	{

		$tsingle = array("","one ","two ","three ","four ","five ",

		"six ","seven ","eight ","nine ");

	

		return $tsingle[$onestr] . $answer;

	}	

	

	function dotwo($twostr) 

	{

		$tdouble = array("","ten ","twenty ","thirty ","fourty ","fifty ",

		"sixty ","seventy ","eighty ","ninety ");

		$teen = array("ten ","eleven ","twelve ","thirteen ","fourteen ","fifteen ",

		"sixteen ","seventeen ","eighteen ","nineteen ");

	

		if ( substr($twostr,1,1) == '0') {

		$ret = doone(substr($twostr,0,1));

		}

		else if (substr($twostr,1,1) == '1') {

		$ret = $teen[substr($twostr,0,1)];

		}

		else {

		$ret = $tdouble[substr($twostr,1,1)] . doone(substr($twostr,0,1));

		}

		return $ret;

	}



// Number to text

	function numtotext($num) 

	{

		$tdiv = array("cents ","dollars and ","hundred ","thousand ", "hundred ", 

		"million ", "hundred ","billion ");

		$divs = array( 0,0,0,0,0,0,0);

		$pos = 0; // index into tdiv;

		//make num a string, and reverse it, because we run through it backwards

		$num=strval(strrev(number_format($num,2,'.',''))); 

		$answer = ""; // build it up from here

		while (strlen($num)) {

		if ( strlen($num) == 1 || ($pos >2 && $pos % 2 == 1))  {

		$answer = doone(substr($num,0,1)) . $answer;

			$num= substr($num,1);

		}

		else {

		$answer = dotwo(substr($num,0,2)) . $answer;

		$num= substr($num,2);

		if ($pos < 2)

			$pos++;

		}

		if (substr($num,0,1) == '.') {

		if (! strlen($answer))

			$answer = "zero ";

		$answer = "dollars and " . $answer . "cents";

		$num= substr($num,1);

		// put in "zero" dollars if there are none

		if (strlen($num) == 1 && $num == '0') {

			$answer = "zero " . $answer;

			$num= substr($num,1);

		}

		}

		// add separator

		if ($pos >= 2 && strlen($num)) {

		if (substr($num,0,1) != 0  || (strlen($num) >1 && substr($num,1,1) != 0

			&& $pos %2 == 1)  ) {

			// check for missed millions and thousands when doing hundreds

			if ( $pos == 4 || $pos == 6 ) {

				if ($divs[$pos -1] == 0)

					$answer = $tdiv[$pos -1 ] . $answer;

			}

			// standard

			$divs[$pos] = 1;

			$answer = $tdiv[$pos++] . $answer;

		}

		else {

			$pos++;

		}

		}

		}

		return $answer;

	}

	

	function dateDiff($dformat, $endDate, $beginDate)

	{

	$date_parts1=explode($dformat, $beginDate);

	$date_parts2=explode($dformat, $endDate);

	$start_date=gregoriantojd($date_parts1[0], $date_parts1[1], $date_parts1[2]);

	$end_date=gregoriantojd($date_parts2[0], $date_parts2[1], $date_parts2[2]);

	return $end_date - $start_date;

	}

	

	function CleanString($str)

	{

		$st = htmlentities(mysql_escape_string(trim($str)));

		return $st;

	}

	function OutString($str)

	{

		$st = html_entity_decode(stripslashes($str));

		return $st;

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

	

	function UploadFile($picname,$tmppicname,$savepath,$unlinkpicname='')

	{

		$exp = explode(".",$picname);

		$cnt = count($exp);

		$pic1 = $tmppicname;

		$picture = rand()."_".time().".".$exp[$cnt-1];

		$copy = copy($pic1,$savepath.$picture);

		if($unlinkpicname != '')

		{

			if(file_exists($savepath.$unlinkpicname))

				@unlink($savepath.$unlinkpicname);

		}

		if($copy)

			return $picture;

		else

			return false;		

	}	

	

	function UploadImage($imagename,$tmp_name,$imagepath,$thumbpath='',$unlinkpicname='')

	{

		$image = rand()."_".time().$imagename;

		$copy = copy($tmp_name,$imagepath.$image);

		if($unlinkpicname != '')

		{

			if(file_exists($imagepath.$unlinkpicname))

				@unlink($imagepath.$unlinkpicname);

			

			if(file_exists($thumbpath.$unlinkpicname))

				@unlink($thumbpath.$unlinkpicname);

		}

		if(!empty($thumbpath))

		{

			include "../classes/createthumbnail.php";

			$thumbObj->createThumbs($image, $imagepath, $thumbpath, '225');

		}

		if($copy)

			return $image;

		else

			return false;		

	}

	

	function CheckUserSession($userid)

	{

		if(!isset($userid) && empty($userid))

			$this->redirect("./");

	}

	

	function findexts ($filename)

	{

		$filename = strtolower($filename) ;

		$exts = split("[/\\.]", $filename) ;

		$n = count($exts)-1;

		$exts = $exts[$n];

		return $exts;

	}

	function ChangeDateFormat($date,$change_to_this_date_format)

	{

		$str = strtotime($date);

		$req = date($change_to_this_date_format,$str);

		return $req;

	} 

		

	function string2url($string)

	{

		$string = preg_replace('/[‰ƒ]/', 'ae', $string);

		$string = preg_replace('/[¸‹]/', 'ue', $string);

		$string = preg_replace('/[ˆ÷]/', 'oe', $string);

		$string = preg_replace('/[ﬂ]/', 'ss', $string);

		$specialCharacters = array(

		'#' => 'sharp',

		'$' => 'dollar',

		'%' => 'prozent', //'percent',

		'&' => 'and', //'and',

		'@' => 'at',

		'.' => 'punkt', //'dot',

		'Ä' => 'euro',

		'+' => 'plus',

		'=' => 'gleich', //'equals',

		'ß' => 'paragraph',

		);

		while (list($character, $replacement) = each($specialCharacters)) {

			$string = str_replace($character, '-' . $replacement . '-', $string);

		}

		$string = strtr($string,

		"¿¡¬√ƒ≈‡·‚„‰Â“”‘’÷ÿÚÛÙıˆ¯»… ÀËÈÍÎ«ÁÃÕŒœÏÌÓÔŸ⁄€‹˘˙˚¸ˇ—Ò",

		"AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn"

		);

		$string = preg_replace('/[^a-zA-Z0-9\-]/', '-', $string);

		$string = preg_replace('/^[\-]+/', '', $string);

		$string = preg_replace('/[\-]+$/', '', $string);

		$string = preg_replace('/[\-]{2,}/', '-', $string);

		$string = strtolower($string);

		$string = str_replace('_','-',$string);

		return $string;

	}

	

	function checkAllowedExt($filename='',$allowedimageext)

	{

		$path_info = pathinfo($filename);

    	$ext = $path_info['extension'];

		if (in_array($ext, $allowedimageext)) return true;

		else return false;

	}	

	

	function clean4urlcode($urlcode)

	{	

		$urlcode = str_replace(".","",stripslashes($urlcode));

		$urlcode = str_replace("'","",$urlcode);	

		$urlcode = str_replace('"','',$urlcode);		

		$urlcode = str_replace('?','',$urlcode);

		$urlcode = str_replace(":","-",$urlcode);

		$urlcode = str_replace(";","-",$urlcode);

		$urlcode = str_replace("<","-",$urlcode);

		$urlcode = str_replace(">","-",$urlcode);

		$urlcode = str_replace("(","-",$urlcode);

		$urlcode = str_replace(")","",$urlcode);

		$urlcode = str_replace("{","-",$urlcode);

		$urlcode = str_replace("}","",$urlcode);

		$urlcode = str_replace("[","-",$urlcode);

		$urlcode = str_replace("]","",$urlcode);

		$urlcode = str_replace("|","",$urlcode);

		$urlcode = str_replace("\\","",$urlcode);

		$urlcode = trim($urlcode);	

		$urlcode = str_replace(" ","-",stripslashes($urlcode));		

		$urlcode = str_replace("/","-",stripslashes($urlcode));	

		$urlcode = str_replace(",","",stripslashes($urlcode));				

		$urlcode = str_replace('&','and',$urlcode);	

		$urlcode = str_replace("--","-",stripslashes($urlcode));	

		$urlcode = str_replace("---","-",stripslashes($urlcode));

		$urlcode = str_replace("----","-",stripslashes($urlcode));

		$urlcode = str_replace("-----","-",stripslashes($urlcode));

		return strtolower($urlcode);

		

		/*

		

		

		$newurlcode = $urlcode;

		

		$j=0;

		$i=1;

		for($i=0;$i<5;$i++)

		while($j<20)

		{	

			$recCount = getCount('id','tbl_product','urlcode="'.$newurlcode.'"');

			echo $newurlcode.'-->'.$recCount.'<br>';

			if($recCount>0)

			{

				++$j;

				$newurlcode = $urlcode.'-'.$j;

			}

			else

			{

				$newurlcode = $urlcode;

				$j=20;

			}

		

		}

		*/

	}

	

		

	

	function clean4imagecode($imagecode)

	{	

		$imagecode = trim($imagecode);

		$imagecode = str_replace("'","",$imagecode);	

		$imagecode = str_replace('"','',$imagecode);		

		$imagecode = str_replace('?','',$imagecode);

		$imagecode = str_replace(":","-",$imagecode);

		$imagecode = str_replace(";","-",$imagecode);

		$imagecode = str_replace("<","-",$imagecode);

		$imagecode = str_replace(">","-",$imagecode);

		$imagecode = str_replace("(","-",$imagecode);

		$imagecode = str_replace(")","",$imagecode);

		$imagecode = str_replace("{","-",$imagecode);

		$imagecode = str_replace("}","",$imagecode);

		$imagecode = str_replace("[","-",$imagecode);

		$imagecode = str_replace("]","",$imagecode);

		$imagecode = str_replace("|","",$imagecode);

		$imagecode = str_replace("\\","",$imagecode);

		$imagecode = trim($imagecode);	

		$imagecode = str_replace(" ","-",stripslashes($imagecode));		

		$imagecode = str_replace("/","-",stripslashes($imagecode));	

		$imagecode = str_replace(",","",stripslashes($imagecode));				

		$imagecode = str_replace('&','and',$imagecode);	

		$imagecode = str_replace("--","-",stripslashes($imagecode));	

		$imagecode = str_replace("---","-",stripslashes($imagecode));

		$imagecode = str_replace("----","-",stripslashes($imagecode));

		$imagecode = str_replace("-----","-",stripslashes($imagecode));

		return strtolower($imagecode);

	}

	

	function getLongDate($date)

	{

		$aa = explode("-",$date);

		

		$h = mktime(0, 0, 0, $aa['1'], $aa['2'], $aa['0']);

		$day= date("l", $h) ;

		

		$month = date('F', mktime(0,0,0,$aa['1'],1));

		return $month." ".$aa['2'].", ".$aa['0'];

	}

	

	function getDayByDate($date)

	{

		$aa = explode("-",$date);

		

		$h = mktime(0, 0, 0, $aa['1'], $aa['2'], $aa['0']);

		$day= date("l", $h) ;

		return $day;

	}

	

	function getMonth()

	{

		$month = array(1=>"January",2=>"February",3=>"March",4=>"April",5=>"May",6=>"June",7=>"July",8=>"August",9=>"September",10=>"October",11=>"November",12=>"December");

		return $month;

	}

	

	function startOrdering()

	{

		global $_SESSION;

		$now_time = time();

		$get_random = rand(0,5000);

		$order_no = $now_time."scorn" + $get_random;

				

		if(empty($_SESSION[ORDERNO]))

		{

			$_SESSION[ORDERNO] = $order_no;

		}

	}

	function deleteImage($imagename,$imagepath)
	{
		@unlink($imagepath.$imagename);
	}

}

?>