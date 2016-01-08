$(document).ready(

function () {

    $(".typeNumber").click(
		function () {
			var value = $(this).children().html();
			$("#orderList").load("./orderListByType/type/" + value);
		}
    );
	/*
    $(".number").ready(
		function () {
			var id = $(this).parent().attr("id");
			var count = 0;
			$(this).val(count);
		}
    );
	*/
    $(".number").change(
		function () {
			var id = $(this).parent().attr("id");
			var count = $(this).val();
			//alert(count);
			$(this).parent().next().next().load("./ajaxCount/id/" + id + "/count/" + count);
		}
    );
    /*
    $(".addNum").click(
    function(){
    var id=$(this).next().attr("id");
    var number=Number($(this).next().children().val())+1;
    $(this).parent().children(".ajaxChange").load("./ajaxAdd/id/" + id +"/number/" + number);
    $(this).next().children(".number").val(number+"");
}
    );

    $(".decNum").click(////////////////////////////
    function(){
    var id=$(this).prev().children().html();
    var number=Number($(this).next().children("#"+id).val())-1;
    $(this).parent().children(".ajaxChange").load("./ajaxDec/id/" + id +"/number/" + number);
    $(this).next().children(".number").val(number+"");
}
    );
    */
});
