$(document).ready(function(){

	$("#verifyPhone").focusout(
		function(event){
			var phone;
			var isValid;
			phone=$("#inputPhone").html();
			/*
			$.getJSON(
				'../MyInfo/checkRegisterPhone',
				{'phone' : phone},
				function(data){
					isValid=data.status;
				}
			);
			
			if(isValid == true){
				$(this).append("<p>此手机号可用</p>");
			}
			else{
				$(this).append("<p>此手机号已被使用</p>");
			}*/
			
		}
	)

});