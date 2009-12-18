var modeview = $.cookie("modeview");
var obj_AvailableAgents = "";
var thisChecked = "";
$(document).ready(function(){
	simple_tooltip(".with-checked", "tooltip");
	if (modeview == null) {
		modeview = "review";
		$.cookie("modeview", "review");
	}
	createModeView(modeview);
	$.getJSON("../_scriptsphp/session_var.php", function(json){
		var use = json.use;
		var thisChecked = json.thisChecked;
		var forprint = json.forprint;
		//var selected = new Array();
		if (thisChecked != ""){
			/*selected.push(thisChecked);
			srch = selected[0].split(",");*/
			srch = thisChecked.split(",");
			if(srch.length>0){
				$.each(srch, function(n, val) {
					$('tr[value="'+val+'"]').css("background-color", "#F6F5E4");
				});
			}
		}
		if (forprint != ""){
			/*selected.push(forprint);
			srch = selected[1].split(",");*/
			srch = forprint.split(",");
			if(srch.length>0){
				$.each(srch, function(n, val) {
					$('tr[value="'+val+'"]').css("background-color", "#E3F2E1").find("input.ocheck").attr('checked', 'checked');
				});
			}
		}
		/*srch = selected.join(",").split(",");
		if(srch.length>0){
		$.each(srch, function(n, val) {
		$('tr[value="'+val+'"]').css("background-color", "#E3F2E1").find("input.ocheck").attr('checked', 'checked');
		});
		}*/
		/*		if (thisChecked != ""){
		selected.push(thisChecked);
		}
		if (forprint != ""){
		selected.push(forprint);
		}
		srch = selected.join(",").split(",");
		if(srch.length>0){
		$.each(srch, function(n, val) {
		$('tr[value="'+val+'"]').css("background-color", "#E3F2E1").find("input.ocheck").attr('checked', 'checked');
		});
		}*/
		$("#marga").val(json.margin);
		if (use == 1) {
			if (parseInt(json.role) <= 1) {
				bind_id = json.id;
			}	else {
				bind_id = json.group;
			}
			$(":radio[name=report]").change(function(){
				var report = $(":radio[name=report]").filter(":checked").val();
				$.cookie("report", report);
			}).change();
			if($.cookie("inquery") === bind_id) {
				$('.trs-exchanges').removeClass("hide").addClass("show");
				agent_t = $.ajax({
					url: "../_scriptsphp/get_parameters.php",
					data: "parameter=agent",
					async: false
				}).responseText;
				obj_AvailableAgents = eval("(" + agent_t + ")");
			}
		}
	});

	$("#type_report").change(function () {
		var value_s = "";
		$("#type_report option:selected").each(function () {
			value_s = $(this).val();
			switch(value_s){
				case "0":
					$("#link-report").attr("href",$("#s-page").val());
					break;
				case "1":
					$("#link-report").attr("href",$("#sel-page").val());
					break;
				case "2":
					$("#link-report").attr("href",$("#a-page").val());
					break;
			}
		});
	}).change();

	$(".show-popup").click(function(){
		var cell = $(this);
		setTimeout(function () {		
			if (jQuery.active) {
				//alert ('bla');
				cell.parent("tr").block_row({  
					message: '<img src="../_images/ajax-loader3.gif" class="loader" style="padding-left:5px;vertical-align: middle;" width="24" height="24" alt="" />',
					css: { 
						border: 'none', 
						backgroundColor: 'transparent'
					},
					overlayCSS: { backgroundColor: '#E6E6E6' } 
				}); 
			}
		}, 300);
		showPopup(cell.parent("tr").attr("value"));	
		cell.parent("tr").unblock_row();		
		return false;
	});
	$("#check-all").click(function(){
		$("#o_lent").find(".ocheck").each(function(){
			$(this).attr("checked", "checked").parents("tr").css("background-color", "#E3F2E1");
		});
		return false;
	});
	$("#uncheck-all").click(function(){
		$("#o_lent").find(".ocheck").each(function(){
			$(this).removeAttr("checked").parents("tr").css("background-color", "#fff");
		});
		return false;
	});
	$('input:checkbox').click(function() {
		$(this).check('toggle');
		if(this.checked) {
			$(this).parents("tr").css("background-color", "#E3F2E1");
		} else {
			$(this).parents("tr").css("background-color", "#fff");
		}
	});
	$("#delete-checked").click(function(){
		var checkstate = getStateChekboxes();
		$.get("../_scriptsphp/chb_statesess.php", {
			checkstates: $.toJSON(checkstate),
			action: "a_delete"
		}, function(count){
			if (count !== 0) {
				var url = window.location.href;
				var croped_url = (url.indexOf("?") != -1) ? url.substr(url.indexOf("?") + 1) : "";
				var simple_url = (url.indexOf("?") != -1) ? url.substr(0, url.indexOf("?") + 1) : url;
				if (croped_url.match("totalRows_Recordset1")) {
					var returnVal;
					var aQuery = croped_url.split("&");
					for (var i = 0; i < aQuery.length; i++) {
						if (escape(unescape(aQuery[i].split("=")[0])) == "totalRows_Recordset1") {
							returnVal = aQuery[i].split("=")[1];
						}
					}
					croped_url = croped_url.replace("totalRows_Recordset1=" + returnVal, "totalRows_Recordset1=" + (parseInt(returnVal) - parseInt(count)));
				}
				if (croped_url != "") {
					window.location.href = simple_url + croped_url;
				}
				else {
					window.location.href = simple_url;
				}
			}

		});
		return false;
	});
	$("#edit-checked").click(function(){
		var checkstate = getStateChekboxes();
		var isCheked = checkstate.selected;
		var checked_array  = new Array();
		checked_array = isCheked.split(",");
		var count = checked_array.length;
		var marga = $("#marga").val();
		$.get("../_scriptsphp/chb_statesess.php", {
			checkstates: $.toJSON(checkstate),
			marga: marga,
			action: "a_update"
		}, function(data){
			window.location.reload();
		});
	});
	$("#print-check").click(function(){
		var checkstate = getStateChekboxes();
		$.get("../_scriptsphp/chb_statesess.php", {
			checkstates: $.toJSON(checkstate),
			action: "a_print"
		}, function(data){
			$("#type_report option:eq(1)").attr('selected', 'selected');
			$("#type_report").change();
			//			window.location.reload();
		});
	});
	$("#reload-uncheck").click(function(){
		$.get("../_scriptsphp/trimming_checked.php", function(data){
			window.location.reload();
		});
	});
});
/**
* Отмеченные объекты
*/
function getStateChekboxes(){
	var unselected = new Array();
	var selected = new Array();
	$(".ocheck").each(function(){
		var parens_val = $(this).parents("tr").attr("value");
		if(!$(this).is(":checked")){
			unselected.push(parens_val);
		} else {
			selected.push(parens_val);
		}
	});
	var stateChekboxes = {
		selected: selected.join(","),
		unselected: unselected.join(",")
	};
	return stateChekboxes;
}
