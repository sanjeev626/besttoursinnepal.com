<?php
if(isset($_POST['btnSubmit'])) {
    $booking_number = "BKN" . rand(11111, 99999);
    $tripcost = $_POST['tripcost'];
    $fromName = $_POST['name'];
    $fromEmail = $_POST['email'];
    //$toName = SITENAME;
    $toName = "Sports Tours & Travel";
    $toEmail = SITEEMAIL;
    //$toEmail = "masanjeev@gmail.com";

    //insert into database
    $data='';
    $data['booking_number'] = $booking_number;
    $data['client_name'] = $_POST['name'];
    $data['tripname'] = $_POST['tripname'];
    $data['tripdate'] = $_POST['chkin'];
    $mydb->insertQuery('tbl_booking',$data);
    ob_start();
    ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><strong>Trip Detail</strong></td>
  </tr>
  <tr>
    <td width="150px">Booking Number:</td>
    <td><?php echo $booking_number; ?></td>
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
    <td>Trip Cost:</td>
    <td><!--US$ --><?php echo stripslashes($_POST['tripcost']); ?></td>
  </tr>
  <tr>
    <td>Arrival Date:</td>
    <td><?php echo stripslashes($_POST['chkin']);?></td>
  </tr>
  <tr>
    <td>Departure Date:</td>
    <td><?php echo stripslashes($_POST['chkout']);?></td>
  </tr>
  <tr>
    <td>Airport Pick Up:</td>
    <td><?php echo stripslashes($_POST['apick']);?></td>
  </tr>
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
    <td>City:</td>
    <td><?php echo stripslashes($_POST['city']);?></td>
  </tr>
  <tr>
    <td>Country:</td>
    <td><?php echo stripslashes($_POST['country']);?></td>
  </tr>
  <tr>
    <td>Comments:</td>
    <td><?php echo stripslashes($_POST['comments']);?></td>
  </tr>
</table>
<?php
    $message = ob_get_clean();
    $subject = "Booking - " . stripslashes($_POST['tripname']);
    //echo $message;

    if($mydb->sendEmail($toName,$toEmail,$fromName,$fromEmail,$subject,$message))
    {
        $subject2 = "Thank you for Booking with us.";
        $mydb->sendEmail($fromName,$fromEmail,$toName,$toEmail,$subject2,$message);
        $msg = 'Your Trip inquiry has been sent to the Sales and Customer Service Division. <br><br><br>We will contact you within 24 hours.';

    }
    else
    {
        $msg = 'Email couldn\'t be sent due to some technical problem. Please Try Again';
    }

    $merchantID = "9103334686"; //9103334686
    $invoiceNumber = $booking_number;
    $productDesc = stripslashes($_POST['tripname']).' - '.stripslashes($_POST['tripdays']);
    $tripcost = $_POST['tripcost']*100;
    $amount = str_pad($tripcost, 12, '0', STR_PAD_LEFT);
    //echo $amount;
    $currencyCode = $_POST['currencyCode']; //USD = 840
    $nonSecure = 'Y';
    $signatureString = $merchantID . $invoiceNumber . $amount . $currencyCode . $nonSecure;
    $hashValue = hash_hmac('SHA256', $signatureString, '1U46HJE564KRB5G2RRHGMGLZU4XV7DMK', false);
    $hashValue = strtoupper($hashValue);
    $hashValue = urlencode($hashValue);
    $responseUrl='http://www.besttoursinnepal.com/payment-confirmation.html';
    ?>
<div class="mid">
  <div class="ptit">
    <h1><span style="background:#FFF; padding:0 25px;">Thank you for Booking with Us</span></h1>
  </div>
  <!--ptit-->
  
  <div class="lcont">
    <div class="tripbox">
      <div class="tdes">
        <?php if(isset($msg) && !empty($msg)){?>
        <p><?php echo $msg;?></p>
        <?php } ?>
        <p>Please make a Payment to confirm your Booking.</p>
      </div>
      <!--tdes-->
      
      <div class="ginfo">
        <h2>Payment Option</h2>
        <div class="reserve">
        <form name="rform" id="rform" method="post" action="https://hblpgw.2c2p.com/HBLPGW/Payment/Payment/Payment">
            <h3>Trip Detail</h3>
            <div class="seg">
              <div class="fl">
                <label for="tripname" id="lbltripname" style="width: 225px;">Booking Number or Invoice Number:</label>
                <input type="text" name="invoiceNo" id="invoiceNo" value="<?php echo $booking_number; ?>" readonly>
              </div>
              <!--fl-->
              <div class="fl">
                <label for="tripdays" id="lbltripdays">Trip Cost (US$):</label>
                <input type="text" name="tripname" id="tripname" value="<?php echo $_POST['tripcost']; ?>" readonly>
              </div>
              <!--fl-->
              <div class="fl">
                <label>&nbsp;</label>
                <input type="hidden" id="paymentGatewayID" name="paymentGatewayID" value="<?php echo $merchantID; ?>"/>
                <input type="hidden" id="productDesc" name="productDesc" value="<?php echo $productDesc; ?>"/>
                <input type="hidden" id="amount" name="amount" value="<?php echo $amount; ?>"/>
                <input type="hidden" name="currencyCode" value="<?php echo $currencyCode;?>">
                <input type="hidden" id="hashValue" name="hashValue" value="<?php echo $hashValue; ?>"/>
                <input type="hidden" id="nonSecure" name="nonSecure" value="Y"/>
                <input type="hidden" id="returnUrl" name="responseUrl" value="<?php echo $responseUrl; ?>"/>
                <button type="submit" class="btn btn-primary" id="submit" name="btnSubmit">Pay Now </button>
              </div>
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
  
</div>
<?php
}
?>