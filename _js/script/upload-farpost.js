var uploaderControl = function(element, controller, id){
    var me = this;    
    me.element = $(element);
    me.controller = controller;
    me.id = id;  
    me.changed = function(){
    };   
    me.showUpForm = function(){
        if (me.image) 
            return;
        
        var formdivid = 'upformdiv' + me.id;
        
        if (!$(formdivid)) {
        
            var upformContent = me.controller.formTemplate.replace(/some_iframe/g, "iframe" + me.id);
            
            var formdivid = 'upformdiv' + me.id;
            
            $(document.body).insert({
                bottom: '<form id="' + formdivid + '" method="post" class="upform" action="' + me.controller.uploadAction + '?ajax=1" target="iframe' + me.id + '" enctype="multipart/form-data" style="display: none" >' + upformContent + '</form>'
            })
            
            me.upform = $(formdivid);
            
            
            
            me.upform.action += '&id=' + me.id;
            
            me.formHidden = me.upform.select('.imageid').first();
            
            
            
            me.select = me.upform.select('select').first();
            
            if (me.tagDiscount && me.select) {
                me.select.value = me.tagDiscount.tag;
            }
            
            
            me.upform.observe('submit', function(){
                me.controller.uploading();
                
                me.uplayer.hide();
                me.loadinglayer.show();
                me.controller.hideContainers();
            });
            
        }
        
        
        me.upform.show();
        
        
        //me.upcontainer.style.width = me.upform.getDimensions().width+"px";
        me.upform.style.top = me.upcontainer.positionedOffset().top + "px";
        me.upform.style.left = me.upcontainer.positionedOffset().left + "px";
        me.upform.style.height = me.upcontainer.getDimensions().height + 2 + "px";      
        me.upcontainer.style.visibility = 'hidden';      
    }   
    me.updateImage = function(image){
    
        me.image = image;
        
        if (image) {
            me.imagelayer.show();
            me.uplayer.hide();
            me.loadinglayer.hide();
            
            me.upimage.src = image.url;
            
            var deletelink = me.imagelayer.select('a').first();
            
            deletelink.href += image.id;
            
            var radio = me.imagelayer.select('input.masterImageRadio').first();
            
            
            
            if (me.controller.masterImageId == image.id) {
                radio.checked = true;
            }
            else 
                if (me.id == 0 && !me.controller.masterImage) {
                    radio.checked = true;
                }
            
            radio.value = image.id;
            radio.observe('click', function(){          
                $$('input[name="masterImageId"]').each(function(element){
                    //element.checked = false;
                    //alert(element.value);
                    //element.hide();
                });
            })
            
            radio.id = 'radio' + me.image.id;
            radio.value = me.image.id;
            
            deletelink.observe('click', function(event){
                if (confirm('Вы действительно хотите удалить фотографию?')) {
                    new baza.Request(deletelink.href, {
                        loadingElement: deletelink,
                        onSuccess: function(transport){
                            var data = transport.responseText.evalJSON();
                            
                            if (data.status == '200') {
                                me.removeImage();
                            }
                            else {
                                alert(data.message);
                            }
                        }
                        
                        
                    });
                    
                    
                }
                
                
                preventDefaultEvent(event);
            });
            
            
            if (image.tag != '' && me.controller.tags != null) {
                me.label.update(me.controller.tags[image.tag]);
                
            }
            
            me.hidden.name = me.controller.name + '[' + image.id + ']';
        }
        
        me.changed();
        
        //me.upcontainer.removeClassName('loading');
    
    
    
    
    }
    
    me.removeImage = function(){
        me.image = null;
        
        me.imagelayer.hide();
        me.uplayer.show();
        me.loadinglayer.hide();
        me.hidden.name = "x";
        
        me.changed();
        
    }
    
    
    me.setImage = function(image){
        me.image = image;
    }
    
    
    
    
    me.render = function(){
        var preparedTemplate = me.controller.imageTemplate;
        
        me.element.insert({
            bottom: preparedTemplate
        });
        
        me.upcontainer = me.element.select('.upcontainer').first();
        
        me.imagelayer = me.element.select('.imagelayer').first();
        me.uplayer = me.element.select('.uplayer').first();
        me.loadinglayer = me.element.select('.loadinglayer').first();
        
        me.uplink = me.uplayer.select('a').first();
        
        me.upimage = me.element.select('.upimage').first();
        
        me.hidden = me.element.select('input[type="hidden"]').first();
        
        me.label = me.element.select('.label').first();
        
        
        if (me.tagDiscount) {
            me.uplink.innerHTML = me.tagDiscount.label;
            
            var annotation = me.element.select('.comment').first();
            
            annotation.update(me.tagDiscount.annotation);
            
        }
        
        me.uplink.observe('click', function(){
            me.controller.hideContainers();
            me.showUpForm();
            
        });
        
        
        if (me.image) {
            me.updateImage(me.image);
            
            
        }
    }
    
    
    me.noImageLoaded = function(){
    
        me.loadinglayer.hide();
        me.uplayer.show();
    }
    //$(document.body).observe('click', me.hideContainers);
}

var uploaderController = function(element, formTemplate, imageTemplate){

    var me = this;
    me.element = $(element);
    me.images = [];
    me.maxImages = 5;
    me.visibleImages = null;
    me.name = 'image';  
    me.controls = [];   
    me.formTemplate = $(formTemplate).innerHTML;
    me.imageTemplate = $(imageTemplate).innerHTML;
    $$('.upform').each(function(element){
        element.hide();
        element.remove();
    });
    
    $(document.body).observe('click', function(event){
        var isUpform = false;
        event.element().ancestors().each(function(element){
            if (element.hasClassName('upform') || element.hasClassName('upcontainer')) {
                isUpform = true;
                return true;
            }
        });
        
        if (!isUpform) {
            me.hideContainers();
        }
        
    });
    
    me.addControl = function(){
        var i = me.controls.length;     
        var element = me.freeElement;     
        var maxControls = Math.max(me.maxImages, me.images.length);     
        if (me.visibleImages < maxControls && i >= me.visibleImages) {
            var element = me.paidElement;
        }            
        element.insert({
            bottom: '<div id="up' + i + '"></div>'
        });  
        me.controls[i] = new uploaderControl('up' + i, this, i);
        
        if (me.images[i]) {
            me.controls[i].setImage(me.images[i]);
        }
        
        if (me.tagsDiscounts && me.tagsDiscounts[i]) {
            me.controls[i].tagDiscount = me.tagsDiscounts[i];
        }
        
        
        if (me.discountController) {
            me.discountController.addDiscount(new imagesUploadExDiscountField(me.controls[i], 'image'));
        }
        
        me.controls[i].render();
    }
    
    me.render = function(){
        var originalHtml = me.element.innerHTML;
        
        me.element.update("<div id='freeImages'></div><div class='clear'></div><div id='paidImages'><div class='comment'>Эти фотографии будут отображаться только при оплате публикации объявления.</div></div>");
        
        me.freeElement = $('freeImages');
        me.paidElement = $('paidImages');
        
        try {
        
            var maxControls = Math.max(me.maxImages, me.images.length);
            
            for (var i = 0; i < maxControls; i++) {
                me.addControl();
            }
        } 
        catch (e) {
            alert(e);
            me.element.update(originalHtml);
            
        }
        
        me.freeElement.insert({
            bottom: "<div class='clear'></div>"
        });
        
        if (me.visibleImages < maxControls) {
            me.paidElement.insert({
                bottom: "<div class='clear'></div>"
            });
            me.paidElement.style.display = "block";
        }
    }
    
    me.uploading = function(){
        if (me.uploadingCallback) {
            me.uploadingCallback();
        }
    }
    
    me.uploaded = function(){
        if (me.uploadedCallback) {
            me.uploadedCallback();
        }
    }
    
    me.updateControl = function(i, image){
    
        me.controls[parseInt(i)].updateImage(image);
        
        me.addEmptyControls();
        me.uploaded();
    }
    
    me.addEmptyControls = function(){
        var isEmptyControl = false;
        var controlsCount = 0;
        
        me.controls.each(function(control){
            if (control && !control.image) {
                isEmptyControl = true;
                controlsCount++;
                throw $break;
            }
        })
 
        if (!isEmptyControl && me.controls.length < me.maxImages) {
            me.addControl();
        }
    }
    
    
    
    me.hideContainers = function(event){
        $$('.upform').each(function(element){
            element.hide();
        });
        
        $$('.upcontainer').each(function(element){
            element.style.width = "120px";
            element.style.visibility = "visible";
        });
    }
    
    
    me.addImage = function(image){
        me.images[me.images.length] = image;
    }
    
    me.setTags = function(tags){
        me.tags = tags;
    }
    
    me.noImageLoaded = function(i){
        me.controls[i].noImageLoaded();
    }
    
    me.wrongImage = function(i){
        me.controls[i].noImageLoaded();
        alert('Фотография должна быть формата jpeg, gif или png.');
        
    }
    
    me.setTagsDiscounts = function(tagsDiscounts){
        me.tagsDiscounts = tagsDiscounts;
    }
    
    me.setDiscountController = function(controller){
        me.discountController = controller;
    }
};
