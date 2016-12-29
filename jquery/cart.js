$(document).ready(function OnReady() {
	$("#step1").hide();
	$("#step2").hide();
	$("#step3").hide();
	$("#step4").hide();
	$("#step1").fadeIn(300);
	$("#checked_Y").click(function() {
		$("#submit_request").prop("disabled", false);
	});
	$("#checked_N").click(function() {
		$("#submit_request").prop("disabled", true);
	});
	for(var i=1;i<=18;i++) {
		$("#id"+i).click(SelectForm);
	}
	$("#reset").click(ClearForm);
})

/* ---------------------------------------------------------------------------------------------------------------------------------------------- */

// 1. Complete html content step by step

function SelectForm() {
	$(".SEC_checkbox").parent().parent().remove();
	$("#select_all").parent().parent().remove();
	$("#step2").hide();
	$("#step3").hide();
	$("#step4").hide();
	var index = $(this).val();
	var forms = new Array();
	for (i=0; i<forms_all.length; i++) {
		var reg_index = forms_all[i].split("|")[0];
		if (reg_index==index.toString()) {forms[forms.length]=forms_all[i];}
	}
	while ($("#form_table tr").length>0) {$("#form_table").closest("tr").remove();}
	var $table = $("#form_table");
	if (forms.length>0) {
		var string = "<tr><td><input style='width:70px' type='button' id='select_all' value='select all'/></td>"
					+ "<td><strong>Name</strong></td> <td><strong>Price</strong></td>"
					+ "<td><strong>Sales</strong></td> <td><strong>Description</strong></td></tr>";
		$table.append(string);
	}
	for (i=0; i<forms.length; i++) {
		var j = i+1;
		var string = "<tr><td width='100'><input type='checkbox' id='check"+j+"' name='check"+j+"' class='SEC_checkbox' value='"+forms[i].split('|')[1]+"'/></td>"
					+ "<td width='100'>"+forms[i].split('|')[1]+"</td>" 
					+ "<td width='100'>"+forms[i].split('|')[3]+"</td>" 
					+ "<td width='100'>"+forms[i].split('|')[4]+"</td>" 
					+ "<td>"+forms[i].split('|')[2]+"</td></tr>";
		$table.append(string);		
	}
	$("#step2").fadeIn(300);
	$("#showstep3").hide();
	$(".SEC_checkbox").change(function() {
		ShowStep3();
	});
	$("#select_all").click(function() {
		if ($("#select_all").val()=='select all') {$(".SEC_checkbox").prop("checked",true); $("#select_all").val("clear all"); }	
		else {$(".SEC_checkbox").prop("checked",false); $("#select_all").val("select all"); }
		ShowStep3();
	});
}

function ShowStep3() {
	$("#step3").hide();
	$("#step4").hide();
	ValidateForm();
	$("#step3").fadeIn(300);
	$("#step4").fadeIn(300);
}

function ClearForm() {
	$(".SEC_checkbox").parent().parent().remove();
	$("#select_all").parent().parent().remove();
	$("#step1").hide();
	$("#step2").hide();
	$("#step3").hide();
	$("#step4").hide();
	$("#step1").fadeIn(300);
}

// 2. Get Chosen and Recomended Form, at the same time, Do Validation

var formname_text = ""; 
var formname_chosen = new Array();
var formname_text_ajax = "";

function ValidateForm() { 	
	// return the list of forms chosen
	formname_text = "";
	formname_chosen.length = 0;
	var rowsCount = $("#form_table tr").length;
	if (rowsCount>0) {
		for (i=1; i<rowsCount; i++) {
			if ($("#check"+i).prop('checked')==true) {
				var j = i+1;
				var value = $('#form_table tr:nth-child('+j+') td:nth-child(2)').html();
				formname_chosen[formname_chosen.length]=value;
				if (formname_text=="") {
					formname_text = value;
					formname_text_ajax = "'"+value+"'";
				}
				else {
					formname_text = formname_text+", "+value;
					formname_text_ajax = formname_text_ajax+", "+"'"+value+"'";
				}
			}	
		}
	}
	// write your selection and recomend for you
	$("#chosen_form").html(formname_text);
	Recommend();
	if (formname_chosen.length>0) {			
		return true;
	}
	else {
		return false;
	}
}

// 3. AJAX to show recommendations
function Recommend() {
	//$("#recommend_form");
	$.post(
		'http://cs-server.usc.edu:9184/myhomework5/index.php/recommend',
		{'formname_text_ajax': formname_text_ajax},
		function(result) {
			if (result) $("#recommend_form").html(result);
		}
	);
}

