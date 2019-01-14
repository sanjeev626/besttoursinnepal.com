<?php
class mydb{
	function opendb(){
		$con = mysqli_connect(DBSERVER,DBUSER,DBPASSW,DBNAME);
	}

	function query($sql)
	{
		$con = mysqli_connect(DBSERVER,DBUSER,DBPASSW,DBNAME);
		$result = mysqli_query($con,$sql);
		if($result)
		{
			return $result;
		}
		else
		{
			echo mysqli_error($con);
		}
	}

	function fetch_array($result)
	{
		return mysqli_fetch_array($result,MYSQLI_ASSOC);
	}

	function count_row($result)
	{
		return mysqli_num_rows($result);
	}

	function insert_id()
	{
		$con = mysqli_connect(DBSERVER,DBUSER,DBPASSW,DBNAME);
		return mysqli_insert_id($con);
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
		//echo $this->insert_id();
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

	function getSum($field,$tablename,$condition="1=1",$print="0")
	{
		//$sql = "SELECT SUM($field*quantity) AS value_sum FROM $tablename WHERE $condition";
		$sql = "SELECT SUM($field) AS value_sum FROM $tablename WHERE $condition";
		//echo $sql;echo "<br>";
		if($print==1) return $sql;
		else
		{
			$res = $this->query($sql);
			$ras = $this->fetch_array($res);
			return $ras['value_sum'];
		}
	}

	function sendEmail($toName,$toEmail,$fromName,$fromEmail,$subject,$message)
	{
		$headers = array("From: care.onlineaushadhi@gmail.com",
			"Reply-To: care.onlineaushadhi@gmail",
			"X-Mailer: PHP/" . PHP_VERSION
		);
		$headers = implode("\r\n", $headers);
		// Mail it
		if(mail($toEmail, $subject, $message, $headers))
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
		where id = '$id'";
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

	//for client section

	function logout()

	{

		$_SESSION[CLIENT]='';

		unset($_SESSION[CLIENT]);

		return(true);

	}

	//for admin section 

	function logout_admin($what,$flag)

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
		$con = mysqli_connect(DBSERVER,DBUSER,DBPASSW,DBNAME);
		$st = htmlentities(trim($str));
		$st = mysqli_real_escape_string($con,$str); 
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

		$return_password = preg_replace('/\\x13\\x00*$/', '', $plain_text);
		//echo "password = ".$password.' -- '."return password = ".$return_password;
		return $return_password;
	}

	function UploadFile($filename,$tmp_name,$thumbsize='',$unlinkfilename='',$unlinkfilepath='')

	{

		$filename=rand(1111,9999).$filename;

		//Delete existing images		

		if($unlinkfilename != '')

		{

			if(file_exists(SITEROOTDOC.$unlinkfilepath.'/'.$unlinkfilename))

				@unlink(SITEROOTDOC.$unlinkfilepath.'/'.$unlinkfilename);



			if(file_exists(SITEROOTDOC.$unlinkfilepath.'/thumb/'.$unlinkfilename))

				@unlink(SITEROOTDOC.$unlinkfilepath.'/thumb/'.$unlinkfilename);

		}



		$current_year = date('Y');

		$current_month = date('m');

		$path_year = SITEROOTDOC.UPLOADPATH.$current_year;

		$path_month = $path_year.'/'.$current_month;



		//echo 'path_year = '.$path_year.' path_month = '.$path_month;

		$filepath = $path_month; //Files to be uploaded in the month folder

		if(file_exists($path_year.'/'))

		{

			//echo 'I am here..<br>'; exit();

			if(!file_exists($path_month))

			{

				mkdir($path_month);

				chmod($path_month, 0777);



				mkdir($path_month.'/thumb');

				chmod($path_month.'/thumb', 0777);

			}

		}

		else

		{

			//Create Year Folder				

			mkdir($path_year);

			chmod($path_year, 0777);



			//Create Month Folder					

			mkdir($path_month);

			chmod($path_month, 0777);



			//Create Thumb folder	

			mkdir($path_month.'/thumb');

			chmod($path_month.'/thumb', 0777);

		}

		$filename = $this->clean4imagecode($filename);

		$copy = copy($tmp_name,$filepath.'/'.$filename);



		//make thumbnail if thumbsize provided

		if(!empty($thumbsize))

		{

			if( !class_exists( 'thumbnail', false ) )

			{

				include "../classes/createthumbnail.php";

			}

			$thumbObj->createThumbs($filename, $filepath.'/', $filepath.'/thumb/', $thumbsize);

		}



		//save in database

		$savepath = UPLOADPATH.$current_year.'/'.$current_month.'/';

		$file['filepath'] = $savepath;

		$file['filename'] = $filename;

		if($copy)

			return $file;

		else

			return false;

	}



	function UploadMultipleFile($filename,$tmp_name,$thumbsize='',$unlinkfilename='',$unlinkfilepath='')

	{

		$filename=rand(1111,9999).$filename;

		//Delete existing images		

		if($unlinkfilename != '')

		{

			if(file_exists(SITEROOTDOC.$unlinkfilepath.'/'.$unlinkfilename))

				@unlink(SITEROOTDOC.$unlinkfilepath.'/'.$unlinkfilename);



			if(file_exists(SITEROOTDOC.$unlinkfilepath.'/thumb/'.$unlinkfilename))

				@unlink(SITEROOTDOC.$unlinkfilepath.'/thumb/'.$unlinkfilename);

		}



		$current_year = date('Y');

		$current_month = date('m');

		$path_year = UPLOADPATH.$current_year;

		$path_month = $path_year.'/'.$current_month;

		$filepath = $path_month; //Files to be uploaded in the month folder

		if(file_exists($path_year.'/'))

		{

			//echo 'I am here..<br>'; exit();

			if(!file_exists($path_month))

			{

				mkdir($path_month);

				chmod($path_month, 0777);



				mkdir($path_month.'/thumb');

				chmod($path_month.'/thumb', 0777);

			}

		}

		else

		{

			//Create Year Folder				

			mkdir($path_year);

			chmod($path_year, 0777);



			//Create Month Folder					

			mkdir($path_month);

			chmod($path_month, 0777);



			//Create Thumb folder	

			mkdir($path_month.'/thumb');

			chmod($path_month.'/thumb', 0777);

		}

		$filename = $this->clean4imagecode($filename);

		$copy = copy($tmp_name,$filepath.'/'.$filename);



		//save in database

		$savepath = 'upload/'.$current_year.'/'.$current_month.'/';

		$file['filepath'] = $savepath;

		$file['filename'] = $filename;

		if($copy)

			return $file;

		else

			return false;

	}



	function removeFile($tablename,$did)

	{

		$ras = $this->getArray('image_path,image_name',$tablename,'id='.$did);

		//echo SITEROOTDOC.$ras['image_path'].$ras['image_name'];

		$unlink = SITEROOTDOC.$ras['image_path'].$ras['image_name'];

		@unlink($unlink);

		// $unlink2 = SITEROOTDOC.$ras['image_path'].'thumb/'.$ras['image_name'];

		// @unlink($unlink2);

		$message = $this->deleteQuery($tablename,'id='.$did);

		return $message;

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

		$string = preg_replace('/[äÄ]/', 'ae', $string);

		$string = preg_replace('/[üÜ]/', 'ue', $string);

		$string = preg_replace('/[öÖ]/', 'oe', $string);

		$string = preg_replace('/[ß]/', 'ss', $string);

		$specialCharacters = array(

			'#' => 'sharp',

			'$' => 'dollar',

			'%' => 'prozent', //'percent',

			'&' => 'and', //'and',

			'@' => 'at',

			'.' => 'punkt', //'dot',

			'€' => 'euro',

			'+' => 'plus',

			'=' => 'gleich', //'equals',

			'§' => 'paragraph',

		);

		while (list($character, $replacement) = each($specialCharacters)) {

			$string = str_replace($character, '-' . $replacement . '-', $string);

		}

		$string = strtr($string,

			"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ",

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

		$urlcode = str_replace("#","",$urlcode);

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



	function sendMessage($subject,$toEmail,$toName,$fromEmail,$fromName,$message)

	{

		// To send HTML mail, the Content-type header must be set

		$headers  = 'MIME-Version: 1.0' . "\r\n";

		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";



		// Additional headers

		$headers .= 'To: '.$toName.' <'.$toEmail.'>' . "\r\n";

		$headers .= 'From: '.$fromName.' <'.$fromEmail.'>' . "\r\n";



		// Mail it

		if(mail($toEmail, $subject, $message, $headers))

			return true;

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







			$thumbObj->createThumbs($image, $imagepath, $thumbpath, '231');







		}







		if($copy)







			return $image;







		else







			return false;







	}



	function setSession()

	{

		if(!isset($_SESSION['order_id'])){

			$_SESSION['order_id'] = date('Ymdhis');

		}



	}

	function setSession_admin()

	{

		if(!isset($_SESSION['order_admin']))

		{

			$_SESSION['order_admin'] = date('Ymdhis');

		}

	}



	function multipleStock($sales_id,$medicine,$quantity,$type,$refill_day)

	{

		$order_total_amount = 0;





		while($quantity>0)

		{

			$data1 = '';

			$data1['medicine_id'] = $this->getValue('id','tbl_medicine','medicine_name="'.$medicine.'"');

			$data1['medicine_name'] = $medicine;

			$data1['medicine_type']=$type;

			if($refill_day!=''){

				$data1['refill_day']=$refill_day;

			}



			$med = preg_replace('/[^A-Za-z0-9]/',"", $medicine);

			$rasStock = $this->getArray('id,sales,stock,pack,rate,sp_per_tab','tbl_stock','description="'.$med.'" AND stock>sales group by description');

			$stock_sales=$rasStock['sales'];//0

			$available = $rasStock['stock']-$rasStock['sales'];//120-0

			$pack = $rasStock['pack'];//10

			$rate_per_strip = $rasStock['rate'];//224.46

			$rate = $rate_per_strip/$pack;

			$result=$rasStock['sp_per_tab'];//$rate+$rate*0.16;



			if($available>=$quantity)

			{



				$data1['quantity'] =$quantity;//

				$sales_quantity=$quantity;

				$quantity=0;



			}

			else

			{



				$data1['quantity'] = $available;//120

				$sales_quantity=$available;//120

				$quantity1=$quantity-$available;//130-120

				$quantity=$quantity1;



			}

			$data1['sales_id']=$sales_id;

			$data1['stock_id']=$rasStock['id'];



			$data1['Rate']=round($result,2);

			$data1['total_amount']=round($data1['Rate']*$data1['quantity']);



			//print_r($data1); die();

			$this->insertQuery('tbl_order',$data1);



			$stock_val=$stock_sales+$sales_quantity;



			$id=$rasStock['id'];

			$data='';

			$data['sales']=$stock_val;



			$this->updateQuery('tbl_stock',$data,'id='.$id);







		}



		$data2='';

		$data2['review_status'] = '1';

		$data2['order_status'] = '0';

		if($refill_day!=''){

			$data2['refill_day']=$refill_day;

		}

		$this->updateQuery('tbl_sales',$data2,'id='.$sales_id);



		$this->deleteQuery('tbl_orderreview','sales_id='.$sales_id);

		$url = ADMINURLPATH.'sales';

		$this->redirect($url);

	}



	function getAlphaNum($random_string_length)

	{

		$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';

		$string = '';

		for ($i = 0; $i < $random_string_length; $i++) {

			$string .= $characters[rand(0, strlen($characters) - 1)];

		}

		return strtoupper($string);

	}





	function curl($url){



		if (!function_exists('curl_init')){

			die('cURL is not installed. Install and try again.');

		}



		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		curl_setopt($ch, CURLOPT_HEADER, false);

		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

		curl_setopt($ch, CURLOPT_REFERER, $url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$output = curl_exec($ch);

		curl_close($ch);



		return $output;

	}



	function getValueByTagName( $data, $s_tag, $e_tag) {

		$pos = strpos($data, $s_tag);

		if ($pos === false) {

			return '';

		} else {

			$s = strpos($data,$s_tag) + strlen( $s_tag);

			$e = strlen( $data);

			$data= substr($data, $s, $e);

			$s = 0;

			$e = strpos( $data,$e_tag);

			$data= substr($data, $s, $e);

			$data= substr($data, $s, $e);

			return  $data;

		}

	}



    function get_slug($string)

    {        

      // replace non letter or digits by -

      $text = preg_replace('~[^\pL\d]+~u', '-', $string);



      // transliterate

      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);



      // remove unwanted characters

      $text = preg_replace('~[^-\w]+~', '', $text);



      // trim

      $text = trim($text, '-');



      // remove duplicate -

      $text = preg_replace('~-+~', '-', $text);



      // lowercase

      $text = strtolower($text);



      if (empty($text)) {

        return 'n-a';

      }



      return $text;

    }

    function getTotalstock($medicine_id)
    {
    	$stock = $this->getSum('stock','tbl_stock',"medicine_id=".$medicine_id);
    	$sales = $this->getSum('sales','tbl_stock',"medicine_id=".$medicine_id);
    	$balance_stock = $stock-$sales;
    	return $balance_stock;
    }

    function getAvailableQuantity($stock_id)
    {
    	$rasStock = $this->getArray('stock,sales','tbl_stock',"id=".$stock_id);
    	$balance_stock = $rasStock['stock']-$rasStock['sales'];
    	return $balance_stock;
    }

    /*function getStockID($medicine_id,$quantity)
    {

    }*/

}



?>