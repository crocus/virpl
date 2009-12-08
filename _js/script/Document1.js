 result += '</div><div id="rex_redact" class="hide" style="margin-top:10px;">'+
            '<form id="rex-form" name="rex-form" action="http://">' +
            '<label for="rex_formula" class="inform">Формула:</label><input type="text" id="rex_formula" name="rex_formula" class="inform double"/>' +
            '<label for="rex_comments" class="inform">Примечание:</label><br /><textarea style="display:block; margin-bottom:5px;width:400px; height:120px;" id="rex_comments" name="rex_comments" rows="2" cols="20"></textarea><br />' +
            '<label for="rex_agent" class="inform">Агент:</label><select id="rex_agent" name="rex_agent" class="inform" size="1"/><br />' +
            //////////тест форма добавления фотографий
            '<div class="d-link"><img height="48" width="48" alt="" src="_images/digikam.png"/><a class="mlink" id="rex_photo" href="#">Редактирование фотографий</a></div>' +
            '<div id="rex_photoredactor" style="display: none"><div class="textondiv"><label class="label" style="font-size:medium;"><strong>Фотографии</strong></label><br />' +
            '<span class="delineation">Размер фотографии должен быть <span class="red">не более 2Мб</span>.</span>' +
            '<div id="rex_iupload" style="width:410px; clear:both">' +
            '<div class="textondiv" style="border: 1px solid #8B8B8B;">' +
            '<div class="tags" style="margin-top: 5px">' +
            '<label for="images_label_exchange">На фотографии:&nbsp;</label>' +
            '<select name="tag" id="images_label_exchange" >' +
            '<option value="" selected="selected" >Выберите...</option>' +
            '<option value="Дом снаружи">Дом снаружи</option>' +
            '<option value="Вид из окна">Вид из окна</option>' +
            '<option value="Интерьер">Интерьер</option>' +
            '<option value="План квартиры">План квартиры</option></select></div>' +
            '<div style="margin-top: 5px">' +
            '<input id="rex_image_but" name="rex_image_but" type="button" value="Добавить фотографию" style="width:167; height:22"/>' +
            '<input type="hidden" name="MAX_FILE_SIZE" value="2097152" />' +
            '<input id="filepath_a" name="filepath_a" type="hidden" value="" /></div></div><br />' +
            '<div><ul id="rex_image_list" class="files"></ul>' +
            '</div></div></div></div>' +
            /* конец формы добавления фотографий */
            '<div style="clear:both; margin-top: 10px;"><input type="button" id="rex_update" name="rex_update" value="Применить изменения" />' +
            '<input type="button" id="rex_delete" name="rex_delete" value="Удалить" /></form></div></div>';