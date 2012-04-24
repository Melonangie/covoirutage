// JavaScript Document
$(document).ready(function(){
	$("#directions_panel1").css("display","none");
	$("#directions_panel").css("display","none");
	
$("#preroute").click(function(){
$("#directions_panel").css("display","inline");
$("#directions_panel1").css("display","none");
});

$("#relroute").click(function(){
$("#directions_panel").css("display","none");
$("#directions_panel1").css("display","inline");
});

});

