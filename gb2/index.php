<!--
	Пример гостевой книги с динамическим обновлением содержимого.
	(с) Михаил Пестречихин, 2009
	http://useful.pestr.ru/ 
-->

<?php
	header ("Content-Type: text/html; charset=utf-8");
	header ("Cache-control: no-cache");	
	
	include ("dbconnect.php");
?>

<html>
<head>
<script type="text/javascript" src="../_js/jquery/jquery-1.3.2.min.js"></script>
</head>

<body>

<h1>Гостевая книга</h1>
	
<div id="messages">
</div>
	
<br>
<h3>Добавить сообщение</h3>
<!-- форма отправки сообщения -->

<!-- проверка заполнения формы -->
<script>

</script>

<!-- код формы -->
<form id="myForm">
<table border="0">
	<tr>
		<td width="160">
			Имя пользователя:
		</td>
		<td>
			<input id="username" name="username" style="width: 300px;">
		</td>
	</tr>
	<tr>
		<td width="160" valign="top">
			Сообщение:
		</td>
		<td>
			<textarea id="msg" name="msg" style="width: 300px;"></textarea>
		</td>
	</tr>		
	<tr>
		<td width="160">
			&nbsp;
		</td>
		<td>
			<input id="btn" type="submit" value="Отправить сообщение">
		</td>
	</tr>
</table>
</form>

<script>

	function splash()
	{
		if (document.myForm.username.value  =='')
			{
				alert ("Заполните имя пользователя!");
				return false;	
			}
			
		if (document.myForm.msg.value  =='')
			{
				alert ("Заполните текст сообщения!");
				return false;	
			}
		
		return true;   
	}

	// загрузка сообщений из БД в контейнер messages
	function show_messages()
	{
		$.ajax({
			url: "show.php",
			cache: false,
			success: function(html){
				$("#messages").html(html);
			}
		});
	}
		
	$(document).ready(function(){

		show_messages();
		
		// контроль и отправка данных на сервер в фоновом режиме при нажатии на кнопку "отправить сообщение"
		$("#myForm").submit(function(){
		
			var name = $("#username").val();
			var msg  = $("#msg").val();
			if (name =='')
			{
				alert ("Заполните имя пользователя!");
				return false;
			}
			if (msg =='')
			{
				alert ("Заполните текст сообщения!");
				return false;
			}

			$.ajax({
				type: "POST",
				url: "action.php",
				data: "username="+name+"&msg="+msg+"&action=add",
				success: function(msg){
					show_messages();
			   }
			});
			
			return false;
		});
		
	});

</script>	


</body>
</html>