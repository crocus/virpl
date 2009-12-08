(function($){
var uploaderControl = function(element, controller, id) {
	var current = this;    
    current.element = $(element);
    current.controller = controller;
    current.id = id;  
    current.changed = function(){
    };
	current.showUpForm = function(){
        if (current.image) 
            return;      
        var formdivid = 'upformdiv' + current.id;       
        if (!$(formdivid)) {       
            var upformContent = current.controller.formTemplate.replace(/some_iframe/g, "iframe" + current.id);           
            var formdivid = 'upformdiv' + current.id;
            
            $(document.body).insert({
                bottom: '<form id="' + formdivid + '" method="post" class="upform" action="' + current.controller.uploadAction + '?ajax=1" target="iframe' + current.id + '" enctype="multipart/form-data" style="display: none" >' + upformContent + '</form>'
            })
            
            current.upform = $(formdivid);

            current.upform.action += '&id=' + current.id;
            
            current.formHidden = current.upform.select('.imageid').first();
 
            current.select = current.upform.select('select').first();
            
            if (current.tagDiscount && current.select) {
                current.select.value = current.tagDiscount.tag;
            }
                      
            current.upform.submit(function(){
                current.controller.uploading();            
                current.uplayer.hide();
                current.loadinglayer.show();
                current.controller.hideContainers();
            });
            
        }       
        current.upform.show();
        
        
        //me.upcontainer.style.width = me.upform.getDimensions().width+"px";
        current.upform.style.top = current.upcontainer.positionedOffset().top + "px";
        current.upform.style.left = current.upcontainer.positionedOffset().left + "px";
        current.upform.style.height = current.upcontainer.getDimensions().height + 2 + "px";      
        current.upcontainer.css("visibility", "hidden");      
    }   
    
  }
var uploaderController  = function(element, formTemplate, imageTemplate){
    var current = this;
    current.element = $(element);
    current.images = [];
    current.maxImages = 5;
    current.visibleImages = null;
    current.name = 'image';  
    current.controls = [];   
    current.formTemplate = $(formTemplate).html;
    current.imageTemplate = $(imageTemplate).html;
    $('.upform').each(function(element){
        element.hide();
        element.remove();
    });
    
    $(document.body).click(function(event){
        var isUpform = false;
        event.element().parents().each(function(element){
            if (element.is('upform') || element.is('upcontainer')) {
                isUpform = true;
                return true;
            }
        });
        
        if (!isUpform) {
            me.hideContainers();
        }
        
    });
    
    current.addControl = function(){
        var i = current.controls.length;     
        var element = current.freeElement;     
        var maxControls = Math.max(current.maxImages, current.images.length);     
        if (current.visibleImages < maxControls && i >= current.visibleImages) {
            var element = current.paidElement;
        }            
        element.insert({
            bottom: '<div id="up' + i + '"></div>'
        });  
        current.controls[i] = new uploaderControl('up' + i, this, i);
        
        if (current.images[i]) {
            current.controls[i].setImage(current.images[i]);
        }
        
        if (current.tagsDiscounts && current.tagsDiscounts[i]) {
            current.controls[i].tagDiscount = current.tagsDiscounts[i];
        }
        
        
        if (current.discountController) {
            current.discountController.addDiscount(new imagesUploadExDiscountField(current.controls[i], 'image'));
        }
        
        current.controls[i].render();
    }
    
    
    
    current.uploading = function(){
        if (current.uploadingCallback) {
            current.uploadingCallback();
        }
    }
    
    current.uploaded = function(){
        if (current.uploadedCallback) {
            current.uploadedCallback();
        }
    }
    
    current.updateControl = function(i, image){   
        current.controls[parseInt(i)].updateImage(image); 
        current.addEmptyControls();
        current.uploaded();
    }
    
    current.addEmptyControls = function(){
        var isEmptyControl = false;
        var controlsCount = 0;
        
        current.controls.each(function(control){
            if (control && !control.image) {
                isEmptyControl = true;
                controlsCount++;
                throw $break;
            }
        })
 
        if (!isEmptyControl && current.controls.length < current.maxImages) {
            current.addControl();
        }
    }
    
    
    
    current.hideContainers = function(event){
        $('.upform').each(function(element){
            element.hide();
        });
        
        $('.upcontainer').each(function(element){
            element.css("width","120px");
            element.css("visibility", "visible");
        });
    }
       
    current.addImage = function(image){
        current.images[current.images.length] = image;
    }
    
    current.setTags = function(tags){
        current.tags = tags;
    }
    
    current.noImageLoaded = function(i){
        current.controls[i].noImageLoaded();
    }
    
    current.wrongImage = function(i){
        current.controls[i].noImageLoaded();
        alert('Фотография должна быть формата jpeg, gif или png.');
        
    }
    
    current.setTagsDiscounts = function(tagsDiscounts){
        current.tagsDiscounts = tagsDiscounts;
    }
    
    current.setDiscountController = function(controller){
        current.discountController = controller;
    }
};  
  })(jQuery);