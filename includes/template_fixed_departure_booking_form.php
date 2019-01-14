<?php

//re-Captcha Starts Here

require_once(SITEROOTDOC.'recaptchalib.php');



// Get a key from https://www.google.com/recaptcha/admin/create

$publickey = "6LfK6dYSAAAAAC6XsO2UZu7ywH1teAS1dx3Yz-x5";

$privatekey = "6LfK6dYSAAAAANCi8Xg9YES5Np24lMKPtBDt_TqD";



# the response from reCAPTCHA

$resp = null;

# the error code from reCAPTCHA, if any

$error = null;

//re-Captcha Ends Here



if(isset($_POST['packageid']) && !empty($_POST['packageid']))

{
  $packageid = $_POST['packageid'];
  $rasPackage = $mydb->getArray('*','tbl_package','id="'.$packageid.'"');

}



if(isset($_POST['btnSubmit']))

{

  if ($_POST["recaptcha_response_field"]) 

  {

        

    $sent=0;

    $resp = recaptcha_check_answer ($privatekey,

                                        $_SERVER["REMOTE_ADDR"],

                                        $_POST["recaptcha_challenge_field"],

                                        $_POST["recaptcha_response_field"]);

        if ($resp->is_valid) 

    {

          ob_start();

      include (SITEROOTDOC."includes/emailbooking_template.php");

      $message = ob_get_clean();

      //echo $message;

      

      $toName = $_POST['name'];

      $toEmail = $_POST['email'];

      $fromName = $mydb->getValue('title','tbl_config','id=1');

      $fromEmail = $mydb->getValue('email','tbl_admin','id=1');

      

      //To the customer

      $subject = "Thank You for booking with us";
                        $fromName1 = $fromName;
                        $fromEmail1 = $fromEmail;
      $messagetocustomer = "Thank You for booking with us.<br><br> Please find the booking details below.<br>";

      $messagetocustomer .= $message;

      $mail1 = $mydb->sendEmail($toName,$toEmail,$fromName1,$fromEmail1,$subject,$messagetocustomer);

      

      

      //To the Website owner

      $subject = "There is a new Fixed Departure booking in ".$fromName.' from '.$toName;

      $messagetoowner = $subject.'<br>Please find the customer details below';

      $messagetoowner .= $message;

      $mail2 = $mydb->sendEmail($fromName,$fromEmail,$toName,$toEmail,$subject,$messagetoowner);

      if($mail1 && $mail2)

      {

        $sent=1;

        $message='Thank You for booking with us';

      }

        }

    else 

    {

      # set the error code so that we can display it

      $message = $resp->error;

        }

  }

}



?>
<div class="ptit">
    		<h1><span style="background:#FFF; padding:0 25px;">Fixed Departures Booking</span></h1>
        </div><!--ptit-->
        
<div class="lcont">
    <div class="tripbox">
      <div class="tdes">
        <p> Note: All the fields mentioned in inquiry form is mandatory. Please submit your correct details and help us make your holiday trips a special one to remember. </p>
      </div>
      <!--tdes-->
      
      <div class="ginfo">
        <h2>Submit Inquiry Form</h2>
        <div class="reserve">
          <form name="rform" id="rform" method="post" action="">
            <?php if(isset($msg)) echo $msg; ?>
            <h3>Trip Detail</h3>
            <div class="seg">
              <div class="fl">
                <label for="tripname" id="lbltripname">Trip Name:</label>
                <input type="text" name="tripname" id="tripname" value="<?php echo $rasPackage['title'];?>" readonly="readonly" />
              </div>
              <!--fl-->
              <div class="fl">
                <label for="tripdays" id="lbltripdays">Trip Duration:</label>
                <input type="text" name="tripdays" id="tripdays" value="<?php echo $rasPackage['duration'];?>" readonly="readonly" />
              </div>
              <!--fl-->
              <div class="fl">
                  <?php
				  	$fixed_dates = $rasPackage['fixed_dates'];
					$fd = explode(',',$fixed_dates);					
				  ?>
                <label for="tripdays" id="lbltripdays">Joining Date:</label>
                <select name="joiningdate" id="joiningdate">
                    <?php
					for($i=0;$i<count($fd);$i++)
					{
						$ffd = trim($fd[$i]);
						if(!empty($ffd))
						{
					?>
                    <option value="<?php echo $ffd;?>"><?php echo $ffd;?></option>
                    <?php
						}
					}
					?>
                  </select>
              </div>
              <!--fl-->
              
              <div class="fl">
                <label for="groupsize" id="lblgroupsize">Group Size:</label>
                <select id="groupsize"  value="" name="groupsize">
                  <option>Just Me</option>
                  <option>Couple</option>
                  <option>1-5</option>
                  <option>5-10</option>
                  <option>10 or more</option>
                </select>
              </div>
              <!--fl-->
              </div>
            <h3>Flight Information</h3>
              <div class="seg">
              <div class="fl">
                <label for="chkin" id="lblchkin">Arrival Date:</label>
                <input type="text" name="chkin" id="chkin" value="" readonly="readonly" />
                <img src="calendar/images/calendar.gif" width="19" height="19" alt="CAL" title="Select Arrival Date" onclick="displayCalendar(document.forms[0].chkin,'yyyy-mm-dd',this)" style="cursor:pointer;" /> </div>
              <!--fl-->
              <div class="fl">
                <label for="chkout" id="lblchkout">Departure Date:</label>
                <input type="text" name="chkout" id="chkout" value="" readonly="readonly" />
                <img src="calendar/images/calendar.gif" width="19" height="19" alt="CAL" title="Select Departure Date" onclick="displayCalendar(document.forms[0].chkout,'yyyy-mm-dd',this)" style="cursor:pointer;" /> </div>
              <!--fl-->
              <div class="fl">
                <label for="apick" id="lblapick">Airport Pick Up:</label>
                <input type="radio" id="desired" value="desired" name="apick" />
                Desired <span style="margin-right:15px;"></span>
                <input type="radio" id="desired" value="required" name="apick" />
                Required </div>
              <!--fl--> 
              
            </div>
            <!--seg-->
            <div style="margin-bottom:25px;"></div>
            <h3>Personal Detail</h3>
            <div class="seg">
              <div class="fl">
                <label for="name" id="lblname">Name:</label>
                <input type="text" name="name" id="name" />
              </div>
              <!--fl-->
              <div class="fl">
                <label for="email" id="lblemail">Email:</label>
                <input type="text" name="email" id="email" />
              </div>
              <!--fl-->
              <div class="fl">
                <label for="tel" id="lbltel">Contact No.:</label>
                <input type="text" name="tel" id="tel" />
              </div>
              <!--fl-->
              
              <div class="fl">
                <label for="city" id="lblcity">City:</label>
                <input type="text" name="city" id="city" />
              </div>
              <!--fl-->
              <div class="fl">
                <label for="country" id="lblcountry">Country:</label>
                <input type="text" name="country" id="country" />
              </div>
              <!--fl-->
              <div class="fl">
                <label for="comments" id="lblcomments">Any Comments:</label>
                <textarea name="comments" id="comments" rows="8"></textarea>
              </div>
              <!--fl-->
              
              <div class="fl">
                <label>&nbsp;</label>
                <?php echo recaptcha_get_html($publickey, $error); ?>
              </div>
              <div class="fl">
                <label>&nbsp;</label>
                <input type="submit" id="btnSubmit" name="btnSubmit" />
              </div>
              <!--fl--> 
            </div>
            <!--seg-->
          </form>
        </div>
        <!--reserve--> 
        
      </div>
      <!--ginfo--> 
      
    </div>
    <!--tripbox--> 
    
  </div>
  <!--lcont-->
  
  <div class="rcont">
    <div class="rplugins">
      <div id="TA_rated976" class="TA_rated">
        <ul id="9piyW3iR4" class="TA_links LHrdMXvs">
          <li id="PxSJWhz8OVDt" class="cZz3PT4WCby"><a target="_blank" href="http://www.tripadvisor.com/"><img src="http://www.tripadvisor.com/img/cdsi/img2/badges/ollie-11424-2.gif" alt="TripAdvisor"/></a></li>
        </ul>
      </div>
      <script src="http://www.jscache.com/wejs?wtype=rated&uniq=976&locationId=4064555&lang=en_US&display_version=2"></script> 
    </div>
    <!--rplugins-->
    
    <div class="rplugins"> <a class="twitter-timeline" href="https://twitter.com/sportsnepaltour" data-widget-id="345091354642247680">Tweets by @sportsnepaltour</a> 
      <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> 
    </div>
    <!--rplugins-->
    
    <div class="rplugins">
      <div id="fb-root"></div>
      <script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
      <div class="fb-follow" data-href="https://www.facebook.com/pages/Sports-Tours-and-Travel/391212987618615" data-width="220" data-colorscheme="light" data-layout="standard" data-show-faces="true"></div>
    </div>
    <!--rplugins--> 
    
  </div>
  <!--rcont-->