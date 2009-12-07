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
	createTapeMode();
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

	$(".show-popup").live('click', function(){
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
		}, 1000);
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
	$('input:checkbox').live ('click', function() {
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
	////////////////////////////////////////////////////	
	//Display Loading Image
	/*function Display_Load()
	{
	$("#loading").fadeIn(900,0);
	$("#loading").html("<img src='../_images/ajax-loader3.gif' />");
	}*/
	//Hide Loading Image
	/*function Hide_Load()
	{
	$("#loading").fadeOut('slow');
	};*/

	//Default Starting Page Results
	$("#pagination li:first")
	.css({'color' : '#FF0084'}).css({'border' : 'none'});
	//	Display_Load();
	$("#content-table").load("base2.php?pageNum_Recordset1=0");

	//Pagination Click
	$("#pagination li").live('click',function(){
		//		Display_Load();
		//CSS Styles
		$("#pagination li")
		.css({'border' : 'solid #dddddd 1px'})
		.css({'color' : '#0063DC'});

		$(this)
		.css({'color' : '#FF0084'})
		.css({'border' : 'none'});

		//Loading Data
		var pageNum = this.id - 1;
		$("#content-table").load("base2.php?pageNum_Recordset1=" + pageNum);
	});
	//////////////////////////////////
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

function createTapeMode(queryString){
	$.getJSON("../base2.php",{query: queryString }, function(json){
		var dataArray = json.data;
		var tapeView ='<table id="o_lent" class="lenta d_table">';
		$.each(dataArray, function(index, data){
			tapeView += '<tr value="'+ data['flats_cod'] + '">';
			tapeView += ' <td class="check" style="vertical-align:middle; width:30px;"><input class="ocheck" name="mcheck[]" type="checkbox"/></td>';
			tapeView +='<td class="align_c show-popup" style=" width:90px;">' +
			(( data['foto'] != 0) ? '<img src="base5.php?id_image='+ data['flats_cod'] + '&amp;category=0&amp;image=0&amp;min=1&amp;percent=0.12" alt="" /></td>':'');
			tapeView += '<td class="align_r" style="width:100px;"><span class="lentprice">' + data["flats_price"] + ' руб.</span></td></tr>';


		});
		tapeView += '</table>';
		tapeView += createPaginator(json.maxRows_Recordset1,json.totalPages_Recordset1,json.pageNum_Recordset1);

		$("#objects").html(tapeView);
	});
}
function createPaginator(maxRows_Recordset1, totalPages_Recordset1, pageNum_Recordset1){
	var pages ='';
	if (totalPages_Recordset1 > 10){
		//Left block
		var pages_start = 1;
		var pages_max = pageNum_Recordset1 >= 5 ? 3 : 5;
		for(var j = pages_start; j <= pages_max; j++){

			pages += '<a href="#" id="'+j + '">'+j+'</a';
		}
		pages += '<span>... </span>';

		//Middle block
		if(pageNum_Recordset1 > 4 && pageNum_Recordset1 < (totalPages_Recordset1 - 3)){
			pages_start = pageNum_Recordset1 - 1;
			pages_max = pageNum_Recordset1 + 1;
			for(var j = pages_start; j <= pages_max; j++){

				pages += '<a href="#" id="'+ j + '">'+j+'</a';;
				//pages += '<li id="'+(j+1) + '">'+(j+1)+'</li>';
			}
			pages += '<span>... </span>';
		}

		//Right block
		pages_start = pageNum_Recordset1 <= totalPages_Recordset1 - 4 ? totalPages_Recordset1 - 2 : totalPages_Recordset1 - 4;
		pages_max = totalPages_Recordset1;
		for(var j = pages_start; j <= pages_max; j++){
			pages += '<a href="#" id="'+j + '">'+j+'</a';
		}
	} else  {
		for (var j = 1; j <= totalPages_Recordset1; $j++){
			//pages += '<li id="'+ j + '">'+ j +'</li>';
			pages += '<a href="#" id="'+j + '">'+j+'</a';
		}
	}
	var paginator = '<div id="pagination">' + pages +'</div>';
	return paginator;
}
