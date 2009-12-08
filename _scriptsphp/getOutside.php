<?php
require_once('session.inc');
session_start();
if(isset($_SESSION['user'])&& !empty($_SESSION['user'])) {
} else {
$iscontact = '<div><label class="label" style="font-size:medium;"><strong>Контактная информация</strong></label><br />
							<label for="fio" class="label"><span class="red">*</span>ФИО:</label>
							<br/>
							<input id="fio" name="fio" type="text" class="inform"/>
							<br/>
							<label for="phon" class="label"><span class="red">*</span>Телефон:</label>
							<br/>
							<input id="phon" name="phon" type="text" class="inform"/>
							<br />
							<label for="e_mail" class="label">E-mail:</label>
							<br/>
							<input id="e_mail" name="e_mail" type="text" class="inform"/></div>';
							
$confirm = '<p style="paddin-left:20px; font-size:small;">'.
'<input type="checkbox" name="private_trader" id="private_trader">Я действительно являюсь '.
'<span class="red">частным лицом</span> и ознакомился с <a href="#" class="agreement">пользовательским соглашением</a></p>';
$capture = '<label for="capture_image" class="label" style="font-size:medium;"><span class="red">*</span>Введите код</label>
							<br />
							<div>
								<input id="keystring" name="keystring"  type="text" />
								<br />
							</div>
							<br />
							<label style="font-size:small;">(из изображения ниже)</label>
							<br />
							<img id="capture_image" src="./kcaptcha/?<?php echo session_name()?>=<?php echo session_id()?>"  style="cursor:pointer;" title="Если не можете прочитать код или допустили ошибку, нажмите на изображение, код обновится." alt=""/>';
}
?>
