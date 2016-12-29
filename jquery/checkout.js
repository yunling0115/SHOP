$(document).ready(function OnReady() {
	$("#step1").hide();
	$("#step1").fadeIn(300);
	$("#checked_Y").click(function() {
		$("#submit_request").prop("disabled", false);
	});
	$("#checked_N").click(function() {
		$("#submit_request").prop("disabled", true);
	});
	$("form").submit(function(e) {
		if (Validate()==false) {
			e.preventDefault();
		}
	});
	$("#exmonth").blur(Validate);
	$("#exyear").blur(Validate);
	$("#cardname").blur(Validate);
	$("#cardno").blur(Validate);
})

/* ---------------------------------------------------------------------------------------------------------------------------------------------- */

function Validate() {
	var error = $("#Message");
	error.html("");
	var exmonth = $("#exmonth option:selected").val();
	var exyear = $("#exyear option:selected").val();
	var cardno = $("#cardno").val();
	var cardname = $("#cardname").val();
	var cardnopatt = /^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/;
	var cardnamepatt = /^[A-Za-z0-9\.\' \-]{4,10}$/;
	if (cardno.length==0) {error.html("Please Enter Your Card Number");}
	else if (cardnopatt.test(cardno)==false) {error.html("Please Enter A Valid Card Number");}
	else if (cardname.length==0) {error.html("Please Enter Cardholder's Name");}
	else if (cardnamepatt.test(cardname)==false) {error.html("Please Enter A Valid Cardholer's Name");}
	else if (exmonth=="mm") {error.html("Please Select Expiration Month");}
	else if (exyear=="yyyy") {error.html("Please Select Expiration Year");}
	else {error.html("");}
	if (error.html()=="") {return true;}
	else {return false;}
}