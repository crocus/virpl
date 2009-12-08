<?php  
$titlepage = "OnByVIRPL";
require_once("powercounter/count.php");
require_once('_scriptsphp/r_conn.php'); 
$query_Region = "SELECT * FROM tbl_region";
$Region = mysql_query($query_Region, $realtorplus) or die(mysql_error());
$row_Region = mysql_fetch_assoc($Region);
$totalRows_Region = mysql_num_rows($Region);

$query_Room= "SELECT * FROM tbl_room";
$Room = mysql_query($query_Room, $realtorplus) or die(mysql_error());
$row_Room = mysql_fetch_assoc($Room);
$totalRows_Room = mysql_num_rows($Room);

$query_Type= "SELECT * FROM tbl_type";
$Type = mysql_query($query_Type, $realtorplus) or die(mysql_error());
$row_Type = mysql_fetch_assoc($Type);
$totalRows_Type = mysql_num_rows($Type);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Заявка на приобретение недвижимости</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <div id="pfb_response" class="hide"></div>
        <div id="pfb_body" class="dintab">
            <form method="post" id="form-proposal-buy" name="form-proposal-buy" action="_scriptsphp/service_tb.php">
                <p> <span class="header">ЗАЯВКА НА ПОКУПКУ</span></p>
                <span class="redline">Все поля обязательны к заполнению.</span><br />
                <label for="header_fb" class="label l-strong"><span class="red">*</span>Заголовок объявления:</label>
                <br />
                <div><input type="text" name="header_fb" value="" style="width: 410px;" size="50"/></div><br />
                <label for="type_cod" class="label l-strong"><span class="red">*</span>Тип объекта:</label><br />
                <select  style="width: 148px;" id="type_cod" name="type_cod">
                    <?php
                    do {
                        ?>
                    <option value="<?php echo $row_Type['type_cod']?>"><?php echo $row_Type['type_s']?></option>
                    <?php
                    } while ($row_Type = mysql_fetch_assoc($Type));
                    ?>
                </select>
                <br /><br />
                <div style="position:relative; display:inline;">
                    <div style="float:left;margin-right:10px;"> <label for="room_cod" class="label l-strong"><span class="red">*</span>Количество комнат:</label><br />
                        <select  style="width: 200px;" id="room_cod" name="room_cod[]" multiple="multiple" size="7">
                            <?php
                            do {
                                ?>
                            <option value="<?php echo $row_Room['room_cod']?>"><?php echo $row_Room['room_short']?></option>
                            <?php
                            } while ($row_Room = mysql_fetch_assoc($Room));
                            ?>
                        </select></div>
                    <div style="float:left; margin-right:10px;"><label for="region_cod" class="label l-strong"><span class="red">*</span>Районы:</label><br />
                        <select style="width: 200px;"  name="region_cod[]" multiple="multiple" size="7">
                            <?php
                            do {
                                ?>
                            <option value="<?php echo $row_Region['region_cod']?>" ><?php echo $row_Region['region_name']?></option>
                            <?php
                            } while ($row_Region = mysql_fetch_assoc($Region));
                            ?>
                        </select></div>
                </div>
                <br />
                <label for="price_fb" class="label l-strong"><span class="red">*</span>Цена не более:</label><br />
                <div><input type="text" name="price_fb" value="" style="width: 148px;" size="21"> </div>
                <br />
                <label for="comm_fb" class="label l-strong"><span class="red">*</span>Текст объявления:</label>
                <br />
                <div><textarea name="comm_fb" cols="30"  style=" width:410px; height: 100px;"></textarea></div><br />
                <p>
                    <label class="label" style="font-size:medium;"><strong>Контактная информация</strong></label>
                    <br/>
                    <label for="pfb_fio" class="label"><span class="red">*</span>ФИО:</label>
                    <br/>
                    <input id="pfb_fio" name="pfb_fio" type="text" class="inform"/>
                    <br/>
                    <label for="pfb_phon" class="label"><span class="red">*</span>Телефон:</label>
                    <br/>
                    <input id="pfb_phon" name="pfb_phon" type="text" class="inform"/>
                    <br />
                    <label for="pfb_e_mail" class="label">E-mail:</label>
                    <br/>
                    <input id="pfb_e_mail" name="pfb_e_mail" type="text" class="inform"/>
                </p><br />
                <div>  <label for="pfb_capture_image" class="label" style="font-size:medium;"><span class="red">*</span>Введите код</label>
                    <br />
                    <div>
                        <input id="keystring_pfb" name="keystring_pfb"  type="text" />
                    </div><br />
                    <label style="font-size:small;">(из изображения ниже)</label>
                    <br />
                    <img id="pfb_capture_image" src="./kcaptcha/?<?php echo session_name()?>=<?php echo session_id()?>"  style="cursor:pointer;" title="Если не можете прочитать код или допустили ошибку, нажмите на изображение, код обновится." alt=""/></div>
                <div class="private-traider"><p style="paddin-left:20px; font-size:small;"><input type="checkbox" name="private_trader" id="private_trader">Я действительно являюсь <span class="red">частным лицом</span> и ознакомился с <a href="#" class="agreement">пользовательским соглашением</a></p></div>
                <div class="econtainer">
                    <h4>При размещении объявления были допущены ошибки, смотрите ниже для уточнения.</h4>
                    <ol/>
                </div>
                <input type="submit" value="Отправить заявку">
                <input type="hidden" name="MM_insert" value="form-proposal-buy"/>
                <input type="hidden" name="action_pb" value="submitted"/>
            </form>
        </div>
    </body>
    <script type="text/javascript">
        $(document).ready(function(){
        $("#type_cod option:eq(1)").attr('selected', 'selected');
            simple_tooltip("#pfb_capture_image","tooltip");
            $("#pfb_capture_image").click( function(){
                reloadImage("#pfb_capture_image");
                return false;
            });
            var options = {
                //target: "#pfb_response",
                beforeSubmit: showRequestProposalBuy,
                success: showResponseProposalBuy,
                resetForm: true,
                timeout: 3000 // тайм-аут
            };
            var econtainer = $('div.econtainer');
            var validator = $("#form-proposal-buy").validate({
                ignore: ".ignore",
                rules: {
                    header_fb: {
                        required: true,
                        maxlength: 50
                    },
                    "room_cod[]": {
                        required: true
                    },
                    "region_cod[]": {
                        required: true
                    },
                    price_fb: {
                        required: true,
                        maxlength: 9
                    },
                    comm_fb: {
                        required: true,
                        maxlength: 4000
                    },
                     private_trader: {
                    required: true
                },
                    pfb_fio: {
                        required: true
                    },
                    pfb_phon: {
                        required: true
                    },
/*                    pfb_e_mail: {
                        required: true
                    },*/
                    keystring_pfb: {
                        required: true,
                        minlength: 4,
                        cache: false,
                        remote: {
                            url: "./_scriptsphp/process.php",
                            type: "post",
                            cache: false,
                            data: {
                                keystring: function(){
                                    return $("#keystring_pfb").val();
                                }
                            }
                        }
                    }
                },
                messages: {
                    header_fb: {
                        required: "Пожалуйста, заполните заголовок.",
                        maxlength: "Слишком \"длинный\" заголовок. Пожалуйста не более 50 символов."
                    },
                    "room_cod[]": {
                        required: "Пожалуйста, выберите количество комнат."
                    },
                    "region_cod[]": {
                        required: "Пожалуйста, выберите интересующие Вас районы."
                    },
                    price_fb: {
                        required: "Пожалуйста, заполните поле цены.",
                        maxlength: "Вы со стоимостью не ошиблись? Если Вы оцениваете Ваше предложение более 999 999 999 рублей позвоните Администратору портала."
                    },
                    comm_fb: {
                        required: "Пожалуйста, наберите текст объявления.",
                        maxlength: "Текст объявления не должен содержать более 4000 символов."
                    },
                     private_trader: {
                    required: "К сожалению, если Вы не являетесь частным лицом или несогласны с <a href='#' class=\"agreement\">Пользовательским Соглашением</a>, Вы не можете добавлять объявления на Портале."
                },
                    pfb_fio: {
                        required: "Пожалуйста, укажите Ваши Фамилию Имя Отчество."
                    },
                    pfb_phon: {
                        required: "Пожалуйста, укажите телефоны для связи с Вами."
                    },
/*                    pfb_e_mail: {
                        required: "Пожалуйста, укажите Ваш электронный адрес (e-mail)."
                    },*/
                    keystring_pfb: {
                        required: "Введите код!!!",
                        minlength: "Код не может содержать менее 4 символов."
                    }
                },
                submitHandler: function(form) {
                    jQuery(form).ajaxSubmit(options);
                    return false;
                },
                success: function(label){
                    label.parent().remove();
                },
                errorContainer: econtainer,
                errorLabelContainer: $("ol", econtainer),
                wrapper: 'li',
                errorElement: "p",
                errorPlacement: function(error, element) {
                    var er = element.attr("name");
                    element.parent().append('<br /><div class="error" htmlfor="' + er + '"/>')
                    .find('div[htmlfor="' + er + '"]')
                    .addClass("e-border").css("height","auto")
                    .append(error);
                    if (er == 'keystring_pfb' ){
                        reloadImage("#pfb_capture_image");
                    }
                },
                onkeyup: false,
                onfocusout: false,
                onclick: false
            });
        });
        function showRequestProposalBuy(formData, jqForm, options) {
            // formData - массив; здесь используется $.param чтобы преобразовать его в строку для вывода в alert(),
            // (только в демонстрационных целях), но в самом плагине jQuery Form это совершается автоматически.
            // queryString = $.param(formData);
            // alert('Вот что мы передаем: \n\n' + queryString);
            return true;
        };
        function showResponseProposalBuy(responseText, statusText)  {
            var infohtml = '<div id="infomessage" class="i-message-big ui-corner-bottom"><div class="textondiv redline"></div></div>';
            $(document).find("#b_proposal").prepend(infohtml);
            $(document).find("#infomessage div:first-child").html(responseText).fadeIn("fast");
            $('#pfb_body').removeClass('show').addClass('hide');
            //$('#pfb_response').removeClass('hide').addClass('show');
        };
    </script>
</html>
<?php
mysql_free_result($Type);
mysql_free_result($Room);
mysql_free_result($Region);
?>
