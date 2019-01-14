<?php
if(isset($_POST['btn_Submit']))
{
	$fromName = $_POST['name'];
	$fromEmail = $_POST['email'];
	$toName = SITENAME;
	$toEmail = SITEEMAIL;
	ob_start();
	
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><strong>Trip Detail</strong></td>
  </tr>
  <tr>
    <td width="150px">Trip Name:</td>
    <td><?php echo stripslashes($_POST['tripname']);?></td>
  </tr>
  <tr>
    <td>Trip Duration:</td>
    <td><?php echo stripslashes($_POST['tripdays']);?></td>
  </tr>
  <tr>
    <td>Group Size:</td>
    <td><?php echo stripslashes($_POST['groupsize']);?></td>
  </tr>
  <tr>
    <td>Travel Date:</td>
    <td><?php echo stripslashes($_POST['chkin']);?></td>
  </tr>
  <tr>
    <td>Airport Pick Up:</td>
    <td><?php echo stripslashes($_POST['apick']);?></td>
  </tr>
  
  <tr>
  <tr>
    <td colspan="2" style="padding-top:20px;"><strong>Personal Detail</strong></td>
  </tr>
  <tr>
    <td>Name:</td>
    <td><?php echo stripslashes($_POST['name']);?></td>
  </tr>
  <tr>
    <td>Email:</td>
    <td><?php echo stripslashes($_POST['email']);?></td>
  </tr>
  <tr>
    <td>Contact No:</td>
    <td><?php echo stripslashes($_POST['tel']);?></td>
  </tr>
  <tr>
  <tr>
    <td>City:</td>
    <td><?php echo stripslashes($_POST['city']);?></td>
  </tr>
  <tr>
  <tr>
    <td>Country:</td>
    <td><?php echo stripslashes($_POST['country']);?></td>
  </tr>
  <tr>
    <td>Comments:</td>
    <td><?php echo stripslashes($_POST['comments']);?></td>
  </tr>
  <tr>
    <td>Message Received from:</td>
    <td><?php echo stripslashes($_SERVER['REMOTE_ADDR']);?></td>
  </tr>
</table>

<?php
  $message = ob_get_clean();	
  $subject = "Custom Tour - ".stripslashes($_POST['tripname']);
  if($mydb->sendEmail($toName,$toEmail,$fromName,$fromEmail,$subject,$message))
  {
  	$msg = '<p style="color:#060">Your information has been sent. We will get back to you soon.</p>';	
  }
  else
  {
  	$msg = '<p style="color:#F00;">Email couldn\'t be sent due to some technical problem</p>';	
  }
}
?>



      <div class="ptit">
        <h1><span style="background:#FFF; padding:0 25px;"><?php echo $title;?></span></h1>
        </div><!--ptit-->
        
        
        
        <div class="lcont">
          
            <div class="tripbox">
              <div class="tdes">
              <p>
                  Note: All the fields mentioned in inquiry form is mandatory. Please submit your correct details and help us make your holiday trips a special one to remember.
                </p>
            </div><!--tdes-->
            
            <div class="ginfo">
            
            <h2>Submit Inquiry Form</h2>
    <div class="reserve">
        <form name="rform" id="rform" method="post" action="">
            <?php if(isset($msg)) echo $msg; ?>
                <h3>Trip Detail</h3>
                <div class="seg">
                  <div class="fl">
                      <label for="tripname" id="lbltripname">Trip Name:</label>
                        <input type="text" name="tripname" id="tripname" value="" />
                    </div><!--fl-->
                    <div class="fl">
                      <label for="tripdays" id="lbltripdays">Trip Duration:</label>
                        <input type="text" name="tripdays" id="tripdays" value="" />
                    </div><!--fl-->
                    
                    <div class="fl">
                      <label for="groupsize" id="lblgroupsize">Group Size:</label>
                        <select id="groupsize"  value="" name="groupsize">
                            <option>Just Me</option>
                            <option>Couple</option>
                            <option>1-5</option>
                            <option>5-10</option>
                            <option>10 or more</option>
                            
                
                      </select>

                    </div><!--fl-->
                    
                  <div class="fl">
                      <label for="chkin" id="lblchkin">Travel Date:</label>
                        <input type="text" name="chkin" id="chkin" value="" readonly="readonly" /> <img src="calendar/images/calendar.gif" width="19" height="19" alt="CAL" title="Select Arrival Date" onclick="displayCalendar(document.forms[0].chkin,'yyyy-mm-dd',this)" style="cursor:pointer;" />
                    </div><!--fl-->
                    
                    <div class="fl">
                      <label for="apick" id="lblapick">Airport Pick Up:</label>
                        <input type="radio" id="desired" value="desired" name="apick" /> Desired <span style="margin-right:15px;"></span><input type="radio" id="desired" value="required" name="apick" /> Required
                    </div><!--fl-->
                    
                </div><!--seg-->
                <div style="margin-bottom:25px;"></div>
                <h3>Personal Detail</h3>
                <div class="seg">
                  <div class="fl">
                      <label for="name" id="lblname">Name:</label>
                        <input type="text" name="name" id="name" />
                    </div><!--fl-->
                    <div class="fl">
                      <label for="email" id="lblemail">Email:</label>
                        <input type="text" name="email" id="email" />
                    </div><!--fl-->
                    <div class="fl">
                      <label for="tel" id="lbltel">Contact No.:</label>
                        <input type="text" name="tel" id="tel" />
                    </div><!--fl-->
                    
                    
                    <div class="fl">
                      <label for="city" id="lblcity">City:</label>
                        <input type="text" name="city" id="city" />
                    </div><!--fl-->
                    <div class="fl">
                      <label for="country" id="lblcountry">Country:</label>
                        <input type="text" name="country" id="country" />
                    </div><!--fl-->
                    <div class="fl">
                      <label for="comments" id="lblcomments">Any Comments:</label>
                        <textarea name="comments" id="comments" rows="8"></textarea>
                    </div><!--fl-->
                    <div class="fl">
                      <label>&nbsp;</label>
                        <input type="submit" id="submit" name="btn_Submit" />
                    </div><!--fl-->
                </div><!--seg-->
                </form>  
    </div><!--reserve-->
            
            </div><!--ginfo-->
            
            </div><!--tripbox-->
          
        </div><!--lcont-->
        
        <div class="rcont">
          
            
            <div class="rplugins">
              <div id="TA_rated976" class="TA_rated"><ul id="9piyW3iR4" class="TA_links LHrdMXvs"><li id="PxSJWhz8OVDt" class="cZz3PT4WCby"><a target="_blank" href="http://www.tripadvisor.com/"><img src="http://www.tripadvisor.com/img/cdsi/img2/badges/ollie-11424-2.gif" alt="TripAdvisor"/></a></li></ul></div><script src="http://www.jscache.com/wejs?wtype=rated&uniq=976&locationId=4064555&lang=en_US&display_version=2"></script>
            </div><!--rplugins-->
            
            
            
            <div class="rplugins">
              <a class="twitter-timeline" href="https://twitter.com/sportsnepaltour" data-widget-id="345091354642247680">Tweets by @sportsnepaltour</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            </div><!--rplugins-->
            
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
            </div><!--rplugins-->
            
        </div><!--rcont-->
        
