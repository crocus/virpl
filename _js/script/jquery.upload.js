(function($){
    var myChecker = function(element, option){
        this.init(element, option);
    };
    myChecker.prototype = {
        // конструктор
        init: function(element, option){
           var me = this;
           me.id = option;
           var formdivid = 'upformdiv' + me.id;
          me.upform = $(formdivid);
            var formContent = '<div id="' + formdivid +'" class="upload-form">'
        + '<div style="padding: 10px">'
        +  '<input type="file" name="up" accept="image/jpeg,image/png,image/gif"/>'
         +  '<div class="tags" style="margin-top: 5px"> На фотографии:&nbsp;'
        +' <select name="tag" id="images_newlabel_"> '
        +'      <option value="" selected="selected"></option> '
         + '     <option value="interior">Интерьер</option> '
          + '    <option value="exterior">Дом снаружи</option> '
          +'    <option value="view">Вид из окна</option> '
           + '   <option value="map">План квартиры</option> '
           + ' </select>'
         + ' </div> '
         + ' <div style="margin-top: 5px">'
          + '  <input type="submit" value="Добавить фотографию" />  '
        + '  </div>'
       + ' </div> '
      + ' </div>';

      $(element).append(formContent)
      .fadeIn("slow");
      var top = element.offset().top + "px";
      var left = element.offset().left + "px";
      me.upform.css({'top' : top, 'left' : left});
    // alert (top+ "__" + left);
     //   me.upform.siblings().css("visibility", "hidden");
         var len = $(element).siblings().length;
            //.css({'background-color' : '#CCCCCC', 'color' : 'green'});
          //   alert (len);
        },
        // функция которая включает или отключает checkbox в зависимости от условия
        check: function(element, condition){
      /*      if (condition)
                $(element).attr({
                    checked: "checked"
                });
            else
                $(element).removeAttr("checked");
           */
        }
    };
    $.fn.uploader = function(options){
        // настройки по умолчанию
        var options = $.extend({
            bgColor: '#D5D5D5',
            maxImage: 6
        }, options);
        
        return this.each(function(){
            $(this).css({
                'display': 'block',
                'width': '430px',
                'height': '280px',
                'background-color': options.bgColor,
                'border': '1px solid #808080',
            });
            for (var i = 0; i < options.maxImage; i++) {
                var container = '<div id ="container_' + i + '" class="upload-container"><div style="padding-top: 5px; text-align: center;"><a href="#" id="image_' + i + '" class="upload-a">Добавить фотографию</a></div></div>';
                $(this).append(container);
            };
       $(document.body).bind('click', function(event){
        var isUpform = false;
       var zaw = $($(event.srcElement)).parents();
        $(zaw).each(function(element){
            if ($(element).is('upload-form') || $(element).is('upcontainer')) {
                isUpform = true;
                var tmp =  $(element).attr("id");
                  alert(tmp);
                return true;
            }
        });

        if (!isUpform) {
           // hideContainers();
           alert ("need hide");
        }

    });
            getidbyclick(this);
        });
        function getidbyclick(cont){
            var elements = $('div.upload-container > div > a', cont);
            $.each(elements, function(index, element){
                var me = element;
                me.idx = index;
                $(me).click(function(){
                    var id = $(me).attr("id");
                    var box = $($(me).parent()).parent();
                   // alert(id + "  " + me.idx);
                    new myChecker(box, me.idx)
                    return false;
                });
            });
        };
       function hideContainers (){
        $('.upload-form').each(function(elem){
            $(elem).hide();
        });
    };
            };
})(jQuery);
