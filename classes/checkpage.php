<?php

//define Admin
define("SITENAME",$mydb->getValue('title','tbl_admin','id=1'));
define("SITEEMAIL",$mydb->getValue('email','tbl_admin','id=1'));
$pagename = '';
$rasHome = $mydb->getArray('metatitle,metakeywords,metadescription','tbl_page','id=3');
$pagepath = 'includes/home.php';

if(isset($_GET['urlcode']))
{
	$urlcode = $_GET['urlcode'];

	
	if($mydb->getCount('id','tbl_activity','urlcode="'.$urlcode.'"')>0)
	{	
		$pagename = 'activity';
		$pagepath = 'includes/template_activity.php';
		$rasActivity = $mydb->getArray('id,title,description,activityimage,pagetitle,metakeywords,metadescription','tbl_activity','urlcode="'.$urlcode.'"');	
		$id = $rasActivity['id'];
		$title = $rasActivity['title'];	
		$description = $rasActivity['description'];	
		$activityimage = $rasActivity['activityimage'];		
		$metatitle = $rasActivity['pagetitle'];
		$metakeywords = $rasActivity['metakeywords'];
		$metadescription = 	$rasActivity['metadescription'];
	}
	elseif($urlcode=="testimonials")
	{		
		$testpage = $mydb->getArray('*','tbl_page','id=11');
		$metatitle = $testpage['metatitle'];
		$metakeywords = $testpage['metakeywords'];
		$metadescription = $testpage['metadescription'];
		$testcontent = stripslashes($testpage['contents']);
		$pagepath = 'includes/template_testimonial.php';
	}
	elseif($urlcode=="meet-the-team")
	{
		$rasTeamMeta = $mydb->getArray('*','tbl_page','id="7"');
		$metatitle = $rasTeamMeta['metatitle'];
		$metakeywords = $rasTeamMeta['metakeywords'];
		$metadescription = 	$rasTeamMeta['metadescription'];
		
		$title = $rasTeamMeta['page'];
		$contents = stripslashes($rasTeamMeta['contents']);
		$pagepath = 'includes/template_team.php';
	}	
	elseif($urlcode=="book-the-trip")
	{
		
		$rasPackage = $mydb->getArray('title,duration','tbl_package','id="'.$_POST['packagecode'].'"');
		$metatitle = "Booking - ".$rasPackage['title'];
		$metakeywords = "Booking";
		$metadescription = "Booking";
		$pagepath = 'includes/template_book_the_trip.php';
	}
	elseif($urlcode=="faq")
	{		
		$rasFaqsMeta = $mydb->getArray('*','tbl_page','id="5"');
		$title = $rasFaqsMeta['page'];
		$contents = stripslashes($rasFaqsMeta['contents']);

		$metatitle = $rasFaqsMeta['metatitle'];
		$metakeywords = $rasFaqsMeta['metakeywords'];
		$metadescription = 	$rasFaqsMeta['metadescription'];
		$pagepath = 'includes/template_faqs.php';
	}
	elseif($urlcode=="link-exchange")
	{
		//$rasPackage = $mydb->getArray('title,duration','tbl_package','urlcode="'.$packagecode.'"');
		$rasLink = $mydb->getArray('*','tbl_page','id="19"');
		$title = $rasLink['page'];
		$contents = stripslashes($rasLink['contents']);

		$metatitle = $rasLink['metatitle'];
		$metakeywords = $rasLink['metakeywords'];
		$metadescription = 	$rasLink['metadescription'];
		$pagepath = 'includes/template_linkexchange.php';
	}	
	elseif($urlcode=="request-custom-tour")
	{
		//$rasPackage = $mydb->getArray('title,duration','tbl_package','urlcode="'.$packagecode.'"');
		$rasRequest = $mydb->getArray('*','tbl_page','id="13"');
		$title = $rasRequest['page'];
		$contents = stripslashes($rasRequest['contents']);

		$metatitle = $rasRequest['metatitle'];
		$metakeywords = $rasRequest['metakeywords'];
		$metadescription = 	$rasRequest['metadescription'];
		$pagepath = 'includes/template_custom_tour.php';
	}
	elseif($urlcode=='fixed-departures-form')
	{
		$rasPage = $mydb->getArray('id,page,contents,metatitle,metakeywords,metadescription','tbl_page','id="20"');
		$id = $rasPage['id'];
		$title = $rasPage['page'];
		$contents = stripslashes($rasPage['contents']);
		$metatitle = $rasPage['metatitle'];
		$metakeywords = $rasPage['metakeywords'];
		$metadescription = 	stripslashes($rasPage['metadescription']);
		$pagepath = 'includes/template_fixed_departure_booking_form.php';
	}
    elseif($urlcode=="thank-you")
    {
        $pagepath = 'includes/template_thank_you.php';
    }
	elseif($mydb->getCount('id','tbl_page','urlcode="'.$urlcode.'"')>0)
	{
		$rasPage = $mydb->getArray('id,page,contents,metatitle,metakeywords,metadescription','tbl_page','urlcode="'.$urlcode.'"');

		$id = $rasPage['id'];
		$title = $rasPage['page'];
		$contents = stripslashes($rasPage['contents']);
		$metatitle = $rasPage['metatitle'];
		$metakeywords = $rasPage['metakeywords'];
		$metadescription = 	stripslashes($rasPage['metadescription']);
			
		if($urlcode=='fixed-departures')
		{
			$pagename = 'Fixed Departures';
			$pagepath = 'includes/template_fixed_departures.php';
		}
		elseif($urlcode=='seasonal-trips')
		{
			$pagename = 'Seasonal Trips';
			$pagepath = 'includes/template_seasonal_trips.php';
		}
		else
		{
			$pagename = 'page';
			$pagepath = 'includes/template_page.php';
		}
	}
	elseif($mydb->getCount('id','tbl_package','urlcode="'.$urlcode.'"')>0)
	{
		//echo 'I am here';
		$pagename = 'package';
		$rasPackage = $mydb->getArray('*','tbl_package','urlcode="'.$urlcode.'"');
		$id 				= 	$rasPackage['id'];
		$acid 				= 	$rasPackage['aid'];	
		$packagecode 		= 	$rasPackage['urlcode'];
		$imagepath 			= 	SITEROOT.'img/package/'.$rasPackage['packageimage'];
		if(!empty($rasPackage['route_map']))
			$mapdocpath		= 	SITEROOTDOC.'img/package/'.$rasPackage['route_map'];
		else
			$mapdocpath		=	'';
		$mappath 			= 	SITEROOT.'img/package/'.$rasPackage['route_map'];
		//$pdffile			=	$rasPackage['pdffile'];
		$title				= 	stripslashes($rasPackage['title']);
		$bestseason			=	stripcslashes($rasPackage['bestseason']);
 		$duration 			= 	stripslashes($rasPackage['duration']);
		$cost 				= 	stripslashes($rasPackage['cost']);
		$cost_npr			= 	stripslashes($rasPackage['cost_npr']);
		$description 		= 	stripslashes($rasPackage['description']);
		$highlights 		= 	stripslashes($rasPackage['highlights']);
		$accomodations 		= 	stripslashes($rasPackage['accomodations']);
		$itinerary 			= 	stripslashes($rasPackage['itinerary']);
		//$additionalremarks 	= 	stripslashes($rasPackage['additionalremarks']);
		$includes 			= 	stripslashes($rasPackage['includes']);
		
		$excludes 			= 	stripslashes($rasPackage['excludes']);
		$trip_notes 		= 	stripslashes($rasPackage['trip_notes']);
		$trip_reviews 		= 	stripslashes($rasPackage['trip_reviews']);
		$trip_facts 		= 	stripslashes($rasPackage['trip_facts']);
		$metatitle = $rasPackage['metatitle'];
		$metakeywords = $rasPackage['metakeywords'];
		$metadescription = 	$rasPackage['metadescription'];
		//echo $packagecode;
		$pagepath = 'includes/template_package.php';
	}	
	elseif($mydb->getCount('id','tbl_country','urlcode="'.$urlcode.'"')>0)
	{
		//echo 'I am here';
		$rasCon = $mydb->getArray('*','tbl_country','urlcode="'.$urlcode.'"');
		$id 				= 	$rasCon['id'];	
		$title				= 	stripslashes($rasCon['title']);
		$contents 		= 	stripslashes($rasCon['description']);
		$metatitle = $rasCon['title'];
		
		$description = strip_tags($rasCon['description']);
		$metakeywords = substr($description,0,100);
		$metadescription = substr($description,0,200);
		$pagepath = 'includes/template_country.php';
	}
	elseif($mydb->getCount('id','tbl_faqs','urlcode="'.$urlcode.'"')>0)
	{
		//echo 'I am here';
		$rasFaqs = $mydb->getArray('*','tbl_faqs','urlcode="'.$urlcode.'"');
		$id 				= 	$rasFaqs['id'];	
		$title				= 	stripslashes($rasFaqs['title']);
		$contents 		= 	stripslashes($rasFaqs['contents']);
		$metatitle = $rasFaqs['metatitle'];
		$metakeywords = $rasFaqs['metakeywords'];
		$metadescription = 	$rasFaqs['metadescription'];
		$pagepath = 'includes/template_faqs_details.php';
	}
	elseif($urlcode=="news-and-events")
	{
		$metatitle = "Recent News and Events - East & West International Tours and Travels";
		$metakeywords = "Recent News and Events from Nepal, Recent News and Events - East & West International Tours and Travels";
		$metadescription = "Read recent news and events from Nepal - East & West International Tours and Travels.";
		$pagepath = 'includes/news-and-events.php';
	}
	elseif($urlcode=="book-the-trip")
	{
		//$rasPackage = $mydb->getArray('title,duration','tbl_package','urlcode="'.$packagecode.'"');
		/*$metatitle = "Booking - ";
		$metakeywords = "Booking";
		$metadescription = "Booking";*/
		$pagepath = 'includes/template_book_the_trip.php';
	}
	elseif($urlcode=="request-customer-tour")
	{
		$pagepath = 'includes/template_custom_tour.php';
	}
	elseif($urlcode=="trip-reviews")
	{
		$rasReviewMeta = $mydb->getArray('*','tbl_page','id="6"');
		$metatitle = $rasReviewMeta['metatitle'];
		$metakeywords = $rasReviewMeta['metakeywords'];
		$metadescription = 	$rasReviewMeta['metadescription'];
		$pagepath = 'includes/template_trip_reviews.php';
		
		
	}
	elseif($urlcode=="tailor-made-departures")
	{
		$pagepath = 'includes/template_tailor_made_departures.php';
	}
	
}



if(empty($metatitle))
	$metatitle = stripslashes($rasHome['metatitle']);

if(empty($metakeywords))
	$metakeywords = stripslashes($rasHome['metakeywords']);

if(empty($metadescription))
	$metadescription = stripslashes($rasHome['metadescription']);

?>