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
				$(this).append("<p>���ֻ��ſ���</p>");
			}
			else{
				$(this).append("<p>���ֻ����ѱ�ʹ��</p>");
			}*/
			
		}
	)

});