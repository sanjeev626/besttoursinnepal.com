// JavaScript Document
function callDelete(url)
{
	var bool;
	bool = confirm('Are you sure to delete ?');
	if(bool)
		window.location=url;
}