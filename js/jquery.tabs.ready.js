// JavaScript Document
$(document).ready(function() {
 
 
	$("li#company").hover(
		function(){$(".menudrop").css('display','block')},
		function(){$(".menudrop").css('display','none')}
	);			
	$(".menudrop").hover(
	function(){$(this).css('display','block')},
	function(){$(this).css('display','none')}
	);
									
	$("li#activities").hover(
		function(){$(".menudrop1").css('display','block')},
		function(){$(".menudrop1").css('display','none')}
	);			
	$(".menudrop1").hover(
		function(){$(this).css('display','block')},
		function(){$(this).css('display','none')}
	);
									
									
	$("li#bhutantours").hover(
		function(){$(".menudrop2").css('display','block')},
		function(){$(".menudrop2").css('display','none')}
	);			
	$(".menudrop2").hover(
		function(){$(this).css('display','block')},
		function(){$(this).css('display','none')}
	);
 
	//Trip Action
	$(".tabContent1").hide(); //Hide all content
	$("ul.tabNavigation1 li:first").addClass("active").show(); //Activate first tab
	$(".tabContent1:first").show(); //Show first tab content
	
	//On Click Event
	$("ul.tabNavigation1 li").click(function() {
		$("ul.tabNavigation1 li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tabContent1").hide(); //Hide all tab content
		var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active content
		return false;
	}); 
});