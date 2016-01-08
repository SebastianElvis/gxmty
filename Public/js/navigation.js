$(document).ready(function(){
	
	$("#mainPage").click(
		function(){
			$("#hpContent").load("../Index/mainPage");
		}
	);
	
	$("#oldBook").click(
		function(){
			$("#hpContent").load("../OldBook/index");
		}
	);

	$("#myInfo").click(
		function(){
			$("#hpContent").load("../MyInfo/index");
		}
	);
	
});