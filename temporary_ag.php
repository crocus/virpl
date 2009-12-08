<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Документ без названия</title>
</head>
<body>
<label for="t_agency" class="inform">Агентство:</label><select id="t_agency" name="t_agency" class="inform" size="1"/><br />
<label for="t_agent" class="inform">Агент:</label><select id="t_agent" name="t_agent" class="inform" size="10"/><br />
<label for="t_name" class="inform">Имя:</label><input type="text" id="t_name" name="t_name" class="inform trinity"/><br />
<label for="t_group" class="inform">Group:</label><input type="text" id="t_group" name="t_group" class="inform trinity"/><br />
<label for="t_mail" class="inform">Mail:</label><input type="text" id="t_mail" name="t_mail" class="inform trinity"/><br />
<label for="t_cod" class="inform">Kod:</label><input type="text" id="t_cod" name="t_cod" class="inform trinity"/><br />
<label for="t_login" class="inform">Login:</label><input type="text" id="t_login" name="t_login" class="inform trinity"/><br />
<label for="t_pass" class="inform">Pass:</label><input type="text" id="t_pass" name="t_pass" class="inform trinity"/><br />
<input id="t_send" name="t_send" type="button" value="Отправить агента" />
<script type="text/javascript">
$(document).ready(function(){
	  $.getJSON("../_scriptsphp/participant_reg.php", {
                parameter: "agency"
            }, function(json){
                $('#t_agency').fillSelect(json).attr('disabled', '');
            });
$('#t_agency').change(function(){
  	adjustAgents();
  }).change();
$('#t_agent').change(function(){
  		$('#t_name').val($('#t_agent option:selected').text());
		$('#t_cod').val($('#t_agent').val());
  });
     $("#t_send").click(function() {
     var obj_update = {
                    "name": $("#t_name").val(),
                    "role": 1,
					"access": $('#t_cod').val(),
                    "login": $("#t_login").val(),
                    "password": hex_md5($("#t_pass").val()),
                    "type_group": 11,
                    "parent_group": $("#t_group").val(),
					"moderated": "N",
					"blocked": "N"
                };
               $.post("../_scriptsphp/participant_reg.php", {
                    parameter: "update",
                    json_obj: $.toJSON(obj_update)
                }, function(json){
                });
   });   
});
function adjustAgents(){
  	var agencyValue = $('#t_agency option:selected').text();
  	var tmpSelect = $('#t_agent');
  	if(agencyValue.length == 0) {
  		tmpSelect.attr('disabled','disabled');
  		tmpSelect.clearSelect();
  	} else {
  		$.getJSON('../_scriptsphp/participant_reg.php',{parameter: "agent", aname: agencyValue},function(data) {
		tmpSelect.fillSelect(data).attr('disabled','');
		var c_group = $('#t_agency').val();
		$("#t_group").val(c_group);		
		});		
  	}
  };
</script>
</body>
</html>