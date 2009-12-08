function showPopup(flat_id){
    $.ajax({
        type: "GET",
        cache: false,
        url: "../../detail_dialog.php",
        data: "id=" + flat_id,
        success: function(response){
            var obj = eval("(" + response + ")");
            // var rObject = JSON.parse(response);
            // alert(response);
            var result = '<div class="contact"><div class="textondiv"><span>Объявление ID№:&nbsp;</span>' + obj.UUID.substr(0, 8) + '<br />' +
            'Добавлено&nbsp;' +
            customDateString(obj.flats_date) +
            '<br /><br /><span style="color:#222;border-bottom: 1px dotted">Контактная информация</span><br />' +
            '<div style="margin-top: 5px"> Разместил&nbsp;' +
            obj.agency_name +
            '<br />E-mail&nbsp;<a href="mailto:' +
            obj.agency_mail +
            '">' +
            obj.agency_mail +
            '</a><br />Телефоны&nbsp;<span style="white-space:pre-line;font-weight:bold;">' +
            obj.phon +
            '</span></div></div></div>';
            var count_r = obj.room_cod;
            switch (obj.type_s) {
                case 'дом':
                    object_type = '<span class="mark-field">Вид объекта: </span>';
                    if (count_r != 0) {
                        object_type += 'дом, ' + count_r + ' комн.';
                    }
                    else {
                        object_type += 'дом';
                    }
                    break;
                case 'квартира':
                    object_type = '<span class="mark-field">Вид квартиры: </span>';
                    if (count_r != 0) {
                        object_type += count_r + '-комнатная';
                    }
                    else {
                        object_type += 'гостинка';
                    }
                    break;
                case 'подселение':
                    object_type = '<span class="mark-field">Вид квартиры: </span>';
                    if (count_r != 0) {
                        object_type += 'подселение, ' + count_r + ' комн.';
                    }
                    else {
                        object_type += 'подселение';
                    }
                    break;
                case 'офис':
                    object_type = '<span class="mark-field">Вид помещения: </span>';
                    if (count_r != 0) {
                        object_type += 'офис, ' + count_r + ' каб.';
                    }
                    else {
                        object_type += 'офис';
                    }
                    break;
                case 'строение':
                    object_type = '<span class="mark-field">Вид объекта: </span>';
                    object_type += 'отдельностоящее строение';
                    break;
                case 'производство':
                    object_type = '<span class="mark-field">Вид объекта: </span>';
                    object_type += 'производственно-складское помещение';
                    break;
                case 'торговля':
                    object_type = '<span class="mark-field">Вид объекта: </span>';
                    object_type += 'торговое помещение, ';
                    break;
                case 'коттедж':
                    object_type = '<span class="mark-field">Вид объекта: </span>';
                    object_type += 'коттедж, ';
                    break;
                case 'под застройку':
                    object_type = '<span class="mark-field">Вид объекта: </span>';
                    object_type += 'земли поселений (под застройку)';
                    break;
                case 'дача':
                    object_type = '<span class="mark-field">Вид объекта: </span>';
                    object_type += 'садоводческий участок (дача)';
                    break;
                default:
                    object_type = '<span class="mark-field">Вид объекта: </span>';
                    object_type += count_r + '-комнатная';
                    break;
            }
            object_place = '<span class="mark-field">Расположение: </span>р-н ' + obj.region_name + ', ' +
            obj.street_name +
            '<br />';
            object_sale = '<span class="mark-field">Вид продажи: </span>' + obj.sale_name + '<br />';
            object_square = '<span class="mark-field">Площадь, (кв.м.): </span>' + obj.So;
            (obj.Sz != 0) ? object_square += ' / ' + obj.Sz : object_square += '';
            (obj.Sk != 0) ? object_square += ' / ' + obj.Sk : object_square += '';
            if (obj.flats_floor == 0) {
                obj.flats_floor = 'цоколь';
            }
            object_floor = '<span class="mark-field">Этаж, этажность, материал: </span>' + obj.flats_floor + ' / ' +
            obj.flats_floorest +
            '&nbsp;' +
            obj.material_name.toLowerCase() +
            '<br />';
            (obj.plan_name != 'Не определено') ? object_plan = '<span class="mark-field">Планировка: </span>' + obj.plan_name + '<br />' : object_plan = '';
            (obj.wc_name != 'Не определено') ? object_wc = '<span class="mark-field">Сан. узел: </span>' + obj.wc_name + '<br />' : object_wc = '';
            (obj.balcon_name != 'Не определено') ? object_bulk = '<span class="mark-field">Балкон/лоджия: </span>' + obj.balcon_name + '<br />' : object_bulk = '';
            (obj.cond_name != 'Не определено') ? object_cond = '<span class="mark-field">Состояние: </span>' + obj.cond_name + '<br />' : object_cond = '';
            (obj.side_name != '-') ? object_side = '<span class="mark-field">Сторона света: </span>' + obj.side_name + '<br />' : object_side = '';
            object_price = '<span class="mark-field">Цена: </span>' + number_format(obj.flats_price, 0, '.', ' ') + ' руб.<br />';
            result += '<div>' + object_type + '<br />' + object_place + object_sale +
            object_square +
            '<br />' +
            object_floor +
            object_plan +
            object_wc +
            object_bulk +
            object_cond +
            object_side +
            object_price;
            if (obj.flats_tel==1) {
                if (obj.flats_comments != '') {
                    obj.flats_comments += ',&nbsp;';
                }
                obj.flats_comments += 'есть телефонная точка.';
            }
            result += '<p><span class="textondiv">' + obj.flats_comments + '</span></p></div>';
            if (obj.foto > 0) {
                result += '<div><ul id="gallery_din">';
                for (var i = 0; i < obj.foto; i++) {
                    result += '<li><a href="../../base5.php?image=' + i + '" rel="lightgallery[flowers]" title="' + obj.region_name + ', ' +
                    obj.street_name +
                    '"><img src="../../base5.php?image=' +
                    i +
                    '&min=1" alt="" width="160" height="98"/></a></li>';
                }
                result += '</ul></div><br />';
            }
            result += '<p><a href="#" id="back_2" title="Назад" style ="float:right; top:20px; clear:both;">Назад</a></p>' + "<br />";
            $("#card").html(result);
            $("#gallery_din").css({
                "list-style": "none"
            });
            $("#gallery_din li").css({
                "display": "inline",
                "vertical-align": "middle"
            });
            $("#gallery_din img").css({
                "background-color": "#ECECEC",
                "padding": "5px 5px 10px",
                "border": "1px solid #333333"
            });
            $("#gallery_din img").live("mouseover", function(){
                $(this).css({
                    "background-color": "#FFF"
                });
            });
            $("#gallery_din img").live("mouseout", function(){
                $(this).css({
                    "background-color": "#ECECEC"
                });
            });
            if (jQuery("#card").css("display") == "none") {
                jQuery("#objects").hide();
                jQuery("#card").show();
            }
            $('#back_2').click(function(){
                jQuery("#objects").show();
                jQuery("#card").hide();
                return false;
            });
            // $("#photocar").carousel( { dispItems : 3, autoSlide : true } );
            initGallery();
        }
    });
};
function showPopupEx(exchange_id){
    $.ajax({
        type: "GET",
        cache: false,
        url: "../../detail_exchange.php",
        data: "id=" + exchange_id,
        success: function(response){
            var obj = eval("(" + response + ")");
            //    alert (response);
            var result = '<div><div><div class="contact"><div class="textondiv"><span>Объявление ID№:&nbsp;</span>' + obj.UUID.substr(0, 8) + '<br />' +
            'Добавлено&nbsp;' +
            customDateString(obj.Date) +
            '<br /><br /><span style="border-bottom: 1px dotted">Контактная информация</span><br />' +
            '<div style="margin-top: 5px"> Разместил&nbsp;' +
            obj.agency_name +
            '<br />E-mail&nbsp;<a href="mailto:' +
            obj.agency_mail +
            '">' +
            obj.agency_mail +
            '</a><br />Телефоны&nbsp;<strong>' +
            obj.phon +
            '</strong></div></div></div>';
            var typeExchange;
            var Type_Exchange = obj.Type_Exchange;
            switch (Type_Exchange) {
                case "0":
                    typeExchange = "Съезд:";
                    break;
                case "1":
                    typeExchange = "Разъезд:";
                    break;
                default:
                    typeExchange = "Обмениваю:";
                    break;
            }
            // var Formula = "";
            (Type_Exchange === "0") ? Formula = obj.Formula + '=' + obj.Result : Formula = obj.Result + '=' + obj.Formula;
            result += '<div style="float:left;"><span class="advertheader">' + typeExchange + '&nbsp;' + Formula + '</span><br /><br />' +
            '<span class="advertbody">' +
            obj.Description +
            '</span></div></div><br />';
            if (obj.foto > 0) {
                result += '<div class="upload-layer"><ul id="gallery_din">';
                for (var i = 0; i < obj.foto; i++) {
                    result += '<li><div style="float:left; margin:3px;"><div class="elemondiv"><a href="./base5.php?id_image='+ exchange_id + '&category=1&image=' + i + '" rel="lightgallery[flowers]" ><img src="./base5.php?id_image='+ exchange_id + '&category=1&image=' +
                    i +
                    '&min=1" alt=""/></a></div></div></li>';
                }
                result += '</ul></div><br />';
            }
            result += '<div><p><a href="#" id="back_2" title="Назад" style ="float:right;clear:both;">Назад</a></p></div>' +
            '<br />';
            $("#card-e").html(result);
            $("#gallery_din").css({
                "list-style": "none",
                "margin": "0px",
                "padding": "0px",
                "text-align": "center",
                "vertical-align": "middle"
            });
            /*  $("#gallery_din li").css({
             //   "display": "inline",
              //  "vertical-align": "middle"
            });
           $("#gallery_din img").css({
                "background-color": "#ECECEC",
                "padding": "5px 5px 10px",
                "border": "1px solid #333333"
            });  */
            $(".elemondiv").live("mouseover", function(){
                $(this).css({
                    "background-color": "#FFF"
                });
            });
            $(".elemondiv").live("mouseout", function(){
                $(this).css({
                    "background-color": "#ECECEC"
                });
            });
            if (jQuery("#card-e").css("display") == "none") {
                jQuery("#objects").hide();
                jQuery("#card-e").show();
            }
            $('#back_2').click(function(){
                jQuery("#objects").show();
                jQuery("#card-e").hide();
                return false;
            });
            initGallery();
        }
    });
};
function initGallery(){
    $(document).ready(function(){
        $(window.parent.document).scrollTo(0);
        lightgallery.init({
            animate: false,
            resizeSync: true,
            enableZoom: true,
            speed: 5,
            fadeImage: false,
            fullSize: false,
            overlayOpacity: .5,
            overlayColor: '#222',
            minPadding: 15
        //showOverlay : false
        });
    });
};
function MakeArray(n){
    this.length = n;
    return this;
};

monthNames = new MakeArray(12);
monthNames[1] = "января"
monthNames[2] = "февраля"
monthNames[3] = "марта"
monthNames[4] = "апреля"
monthNames[5] = "мая"
monthNames[6] = "июня"
monthNames[7] = "июля"
monthNames[8] = "августа"
monthNames[9] = "сентября"
monthNames[10] = "октября"
monthNames[11] = "ноября"
monthNames[12] = "декабря"
dayNames = new MakeArray(7);
dayNames[1] = "воскресенье"
dayNames[2] = "понедельник"
dayNames[3] = "вторник"
dayNames[4] = "среда"
dayNames[5] = "четверг"
dayNames[6] = "пятница"
dayNames[7] = "суббота"

function customDateString(customDate){
    currentDate = new Date(customDate);
    var theDay = dayNames[currentDate.getDay() + 1]
    var theMonth = monthNames[currentDate.getMonth() + 1]
    msie4 = ((navigator.appName == "Microsoft Internet Explorer") && (parseInt(navigator.appVersion) >= 4));
    op = (navigator.appName == "Opera");
    if (msie4 || op) {
        var theYear = currentDate.getYear()
    }
    else {
        var theYear = currentDate.getYear() + 1900
    }
    return "<span class='thetimes'>" + currentDate.getHours() + ":" + currentDate.getMinutes() + "</span>, <span class='thedate'>" + currentDate.getDate() + "</span>&nbsp;<span class='themonth'>" + theMonth +
    "</span>&nbsp;<span class='theyear'>" +
    theYear +
    "</span>";
};
function number_format(number, decimals, dec_point, thousands_sep){
    // http : // kevin.vanzonneveld.net
    // %        note 1 : For 1000.55 result with precision 1 in FF / Opera is 1, 000.5, but in IE is 1, 000.6
    // *     example 1 : number_format(1234.56);
    // *     returns 1 : '1,235'
    // *     example 2 : number_format(1234.56, 2, ',', ' ');
    // *     returns 2 : '1 234,56'
    // *     example 3 : number_format(1234.5678, 2, '.', '');
    // *     returns 3 : '1234.57'
    // *     example 4 : number_format(67, 2, ',', '.');
    // *     returns 4 : '67,00'
    // *     example 5 : number_format(1000);
    // *     returns 5 : '1,000'
    // *     example 6 : number_format(67.311, 2);
    // *     returns 6 : '67.31'
    var n = number, prec = decimals;
    n = !isFinite(+n) ? 0 : +n;
    prec = !isFinite(+prec) ? 0 : Math.abs(prec);
    var sep = (typeof thousands_sep == "undefined") ? ',' : thousands_sep;
    var dec = (typeof dec_point == "undefined") ? '.' : dec_point;
    
    var s = (prec > 0) ? n.toFixed(prec) : Math.round(n).toFixed(prec);
    // fix for IE parseFloat(0.55).toFixed(0) = 0;
    
    var abs = Math.abs(n).toFixed(prec);
    var _, i;
    
    if (abs >= 1000) {
        _ = abs.split(/\D/);
        i = _[0].length % 3 || 3;
        
        _[0] = s.slice(0, i + (n < 0)) +
        _[0].slice(i).replace(/(\d{3})/g, sep + '$1');
        
        s = _.join(dec);
    }
    else {
        s = s.replace('.', dec);
    }
    
    return s;
};
