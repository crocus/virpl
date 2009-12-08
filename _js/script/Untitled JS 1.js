/**
 * @author root
 */
$("#add_advert_form").validate({
    rules: {
        formula: {
			required: true
		},
        keystring: {
            required: true,
            cache: false,
            remote: {
                url: "./_scriptsphp/process.php",
                type: "post",
                data: {
                    keystring: function(){
                        return $("#keystring").val();
                    }
                },
                success: function(response){
                    if (response == "false") {
                        $("#capture_image").trigger('click');
                    }
                }
            }
        }
    },
    /*    errorPlacement: function(error, element){
     if (element.attr("name") == 'keystring') {
     //$("#capture_image").trigger('click');
     //label.insertAfter(element)
     error.appendTo(element.parent().find("label[@for='keystring']").find("kbd"));
     }
     var er = element.attr("name");
     error.appendTo(element.parent().find("label[for='" + er + "']"));
     },*/
    messages: {
        keystring: "Вы допустили ошибку в написании кода с картинки. \n Возможно Вы набирали код русскими буквами?"
    },
    submitHandler: function(form){
        jQuery(form).ajaxSubmit();
        return false;
    },
    success: function(){
        $('#exchange-request').removeClass('show').addClass('hide');
    },
    onkeyup: false,
    onfocusout: false,
    onclick: false
});

$('#add_advert_form').submit(function(){
    jQuery(form).ajaxSubmit(options);
    return false;
});
$("#capture_image").click(function(){
    $.ajax({
        url: "./kcaptcha/reload_ids.php",
        cache: false,
        success: function(session_id){
            $("#capture_image").attr("src", "./kcaptcha/?<?php echo session_name()?>=" + session_id);
        }
    });
    return false;
});
	jQuery.validator.addMethod("captcha", function( value, element ) {
		 $.ajax({
   type: "POST",
   url: "./_scriptsphp/process.php",
  data: "keystring=sd4",              
  success: function(response){
        if (response == false) {
			alert( "Data Saved: " + response );
             $("#capture_image").trigger('click');
			 result = false;
              } else {
				result = true;  
			  }
   }
 });
return result;
	}, "Your password must be at least 6 characters long and contain at least one number and one character.");