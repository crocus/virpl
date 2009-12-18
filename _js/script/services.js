// JavaScript Document
function getOffset(elem) {
	if (elem.getBoundingClientRect) {
		// "правильный" вариант
		return getOffsetRect(elem)
	} else {
		// пусть работает хоть как-то
		return getOffsetSum(elem)
	}
}

function getOffsetSum(elem) {
	var top=0, left=0
	while(elem) {
		top = top + parseInt(elem.offsetTop)
		left = left + parseInt(elem.offsetLeft)
		elem = elem.offsetParent
	}

	return {top: top, left: left}
}

function getOffsetRect(elem) {
	// (1)
	var box = elem.getBoundingClientRect()

	// (2)
	var body = document.body
	var docElem = document.documentElement

	// (3)
	var scrollTop = window.pageYOffset || docElem.scrollTop || body.scrollTop
	var scrollLeft = window.pageXOffset || docElem.scrollLeft || body.scrollLeft

	// (4)
	var clientTop = docElem.clientTop || body.clientTop || 0
	var clientLeft = docElem.clientLeft || body.clientLeft || 0

	// (5)
	var top  = box.top +  scrollTop - clientTop
	var left = box.left + scrollLeft - clientLeft

	return { top: Math.round(top), left: Math.round(left) }
}

/*
end offset
*/
function domReady(f){
	if (domReady.done) {
		domReady.done = false;
		return f();
	}

	if (domReady.timer) {
		domReady.ready.push(f);
	}
	else {
		if (window.addEventListener)
			window.addEventListener('load', isDOMReady, false);
		else
			if (window.attachEvent)
			window.attachEvent('onload', isDOMReady);

		domReady.ready = [f];
		domReady.timer = setInterval(isDOMReady, 13);
	}
};

function isDOMReady(){
	if (domReady.done)
		return false;

	if (document && document.getElementsByTagName && document.getElementById && document.body) {
		clearInterval(domReady.timer);
		domReady.timer = null;

		for (var i = 0; i < domReady.ready.length; i++)
			domReady.ready[i]();

		domReady.ready = null;
		domReady.done = true;
	}
};
function initGallery(){
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
};
function simple_tooltip(target_items, name){
	$(target_items).each(function(i){
		$("body").append("<div class='" + name + "' id='" + name + i + "'><p>" + $(this).attr('title') + "</p></div>");
		var my_tooltip = $("#" + name + i);

		$(this).removeAttr("title").mouseover(function(){
			my_tooltip.css({
				opacity: 0.8,
				display: "none"
			}).fadeIn(400);
		}).mousemove(function(kmouse){
			my_tooltip.css({
				left: kmouse.pageX + 15,
				top: kmouse.pageY + 15
			});
		}).mouseout(function(){
			my_tooltip.fadeOut(400);
		});
	});
};
/*function reloadImage(image) {
$.ajax({
url: "./kcaptcha/reload_ids.php",
cache: false,
success: function(session_id){
$(image).attr("src", "./kcaptcha/?PHPSESSID=" + session_id);
}
});
};*/
function reloadImage(image) {
	//$(image).attr("src", "./_images/loading.gif");
	$(image).attr({
		src: "./_images/loading.gif",
		alt: "Loading..."
	});

	var hash = $.cookie("PHPSESSID");
	var rand = hex_md5(Date()).substr(10, 8);
	$(image).attr("src", function() {
		return "./kcaptcha/?image=" + rand + "&PHPSESSID=" + hash;
	});
}
function adjustStreet(c_city, c_street){
	var cityValue = $('#' + c_city).val();
	var tmpSelect = $('#' + c_street);
	if(cityValue.length == 0) {
		tmpSelect.attr('disabled','disabled');
		tmpSelect.clearSelect();
	} else {
		$.getJSON('./_scriptsphp/get_parameters.php',{
			parameter: "street",
			id: cityValue
		},function(data) {
			tmpSelect.fillSelect(data).attr('disabled','');
		});
	}
}
(function($){
	// ??????? select
	jQuery.fn.check = function(mode) {
		// если mode не определен, используем 'on' по умолчанию
		var mode = mode || 'on';

		// В функцию неявно передана коллекция выбранных элементов.
		// Поэтому с этой коллекцией можно работать, как с любой другой
		// коллекцией элементов в jQuery
		// В нашем случае мы воспользуемся методом each()
		return this.each(function()
		{
			switch(mode) {
				case 'on':
					this.checked = true;
					break;
				case 'off':
					this.checked = false;
					break;
				case 'toggle':
					(this.checked)?!this.checked:this.checked;
					break;
			}
		});
	};
	$.fn.clearSelect = function(){
		return this.each(function(){
			if (this.tagName == 'SELECT') {
				this.options.length = 0;
				$(this).attr('disabled', 'disabled');
			}
		});
	};
	// ????????? select
	$.fn.fillSelect = function(dataArray){
		return this.clearSelect().each(function(){
			if (this.tagName == 'SELECT') {
				var currentSelect = this;
				$.each(dataArray, function(index, data){
					var option = new Option(data.Name, data.Id);
					if ($.support.cssFloat) {
						currentSelect.add(option, null);
					}
					else {
						currentSelect.add(option);
					}
				});
			}
		});
	};
	$.fn.jTruncate = function(options) {

		var defaults = {
			length: 300,
			minTrail: 20,
			moreText: "more",
			lessText: "less",
			ellipsisText: "...",
			moreAni: "",
			lessAni: ""
		};

		var options = $.extend(defaults, options);

		return this.each(function() {
			obj = $(this);
			var body = obj.html();

			if(body.length > options.length + options.minTrail) {
				var splitLocation = body.indexOf(' ', options.length);
				if(splitLocation != -1) {
					// truncate tip
					var str1 = body.substring(0, splitLocation);
					var str2 = body.substring(splitLocation, body.length - 1);
					obj.html(str1 + '<span class="truncate_ellipsis">' + options.ellipsisText +
					'</span>' + '<span class="truncate_more">' + str2 + '</span>');
					obj.find('.truncate_more').css("display", "none");

					// insert more link
					obj.append(
					'<div class="clearboth">' +
					'<a href="#" class="truncate_more_link">' + options.moreText + '</a>' +
					'</div>'
					);

					// set onclick event for more/less link
					var moreLink = $('.truncate_more_link', obj);
					var moreContent = $('.truncate_more', obj);
					var ellipsis = $('.truncate_ellipsis', obj);
					moreLink.click(function() {
						if(moreLink.text() == options.moreText) {
							moreContent.show(options.moreAni);
							moreLink.text(options.lessText);
							ellipsis.css("display", "none");
						} else {
							moreContent.hide(options.lessAni);
							moreLink.text(options.moreText);
							ellipsis.css("display", "inline");
						}
						return false;
					});
				}
			} // end if

		});
	};
	$.fn.mTruncate = function(options) {	   
		var defaults = {
			length: 100,
			minTrail: 10,
			ellipsisText: "..."
		};
		var options = $.extend(defaults, options);
		return this.each(function() {
			obj = $(this);
			var body = obj.html();

			if(body.length > options.length + options.minTrail) {
				var splitLocation = body.indexOf(' ', options.length);
				if(splitLocation != -1) {
					// truncate tip
					var str1 = body.substring(0, splitLocation);
					obj.html(str1 + '<span class="truncate_ellipsis">' + options.ellipsisText + '</span>');
				}
			} // end if
		});
	};
	/*мультиселект плагин*/
	$.fn.simpleMultiSelect = function(options){
		var settings = $.extend({
			highlight : '#B4B4B4',
			border : '#777',
			width : 198,
			height : 96,
			classesOnly : false,
			container : 'sms-container',
			pseudoSelect : 'sms-pseudo-select',
			selected : 'sms-selected',
			unselected : 'sms-unselected'
		}, options);
		return this.each(function(){
			// wrapping select in a div so that the select and 
			// pseudo select will be siblings
			$(this).wrap('<div class="' + settings.container + '"></div>');
			var divselect = $('<div class="' + settings.pseudoSelect + '"></div>');
			$('option', this).each(function(){
				var op = $(this);
				var dv = $('<div/>').text(op.text()).data('selected', op.attr('selected'));
				// highlight pseudo option on load
				toggleSelected(dv, settings);
				dv.click(function(){
					// we still have references to op and dv here ...
					if(op.attr('selected')){
						//de-select
						op.removeAttr('selected');
						dv.data('selected', false);
						toggleSelected(dv, settings);
					}else{
						//select
						op.attr('selected', true);
						dv.data('selected', true);
						toggleSelected(dv, settings);
					}
				});
				divselect.append(dv);
			});
			if(!settings.classesOnly){
				divselect.css({
					width : settings.width,
					height : settings.height,
					cursor : "default",
					overflow : "auto",
					border : "1px solid " + settings.border
				});
			}
			$(this).after(divselect).hide();
		});
	};
	$.fn.smsNone = function(){
		return this.each(function(){
			siblingDivSet(this).each(function(){
				var psop = $(this);
				if(psop.data('selected')){
					psop.click();
				}
			});
		});
	};
	$.fn.smsAll = function(){
		return this.each(function(){
			siblingDivSet(this).each(function(){
				var psop = $(this);
				if(!psop.data('selected')){
					psop.click();
				}
			});
		});
	}
	function toggleSelected(elem, config){
		var sel = elem.data('selected');
		if(config.classesOnly){
			elem.toggleClass(config.selected, sel);
			elem.toggleClass(config.unselected, !sel);
		}else{
			if(sel){
				elem.css({'background-color' : config.highlight});
			}else{
				elem.css({'background-color' : 'transparent'});
			}
		}
	}
	function siblingDivSet(sel){
		// expects a select object, return jquery set
		return $(sel).siblings('div').children('div');
	}
	/* конец мультиселекта*/
	$.fn.makeFAQ = function(options) {
		var defaults = {
			//indexTitle: "Index",    // Change to whatever you want to be displayed
			faqHeader: ":header",   // default grabs any header element - h1,h2, etc...
			//displayIndex: true,      // Display Index
			initState: "expanded"      // default state
		};
		var options = $.extend(defaults, options);
		return this.each(function() {
			// load the parent object only once
			var $obj = $(this);
			/*// wrap parent in faqRoot div
			$obj.wrap("<div id='faqRoot'></div>");

			// Add index div
			if(options.displayIndex) {
			$obj.before("<div id='faqindex'><h2>" + options.indexTitle + "</h2><ul></ul></div>");
			};*/

			// Get header children using the obj ID
			var $faqEntries = $obj.children(options.faqHeader);
			// counting integer - ensures unique id names
			var i = 0;
			// enumerate through each entry and perform several tasks
			$faqEntries.each(function () {
				// load object only once
				var $entry = $(this);
				// Get entry name
				var entryName = $entry.text();
				// strip whitespaces and special characters
				var entryNameSafe = entryName.replace(/\W/g,"") + i;
				// Increment counter
				i++;
				/*
				// build index line for entry
				var itemHTML = "<li><a id='" + entryNameSafe.toString() + "Index' href='#" + entryNameSafe.toString() + "' >" + entryName + "</a></li>";
				// append the index line to the index
				$('#faqindex ul').append(itemHTML);

				// add click event for index entry
				if(options.displayIndex) {
				$('#' + entryNameSafe.toString() + 'Index').click( function(){ 
				// slide down the selected index before jumping to the bookmark    
				$('#' + entryNameSafe.toString()).next('span').slideDown('fast');
				// make sure it gets the faqopened class
				$('#' + entryNameSafe.toString()).addClass('faqopened');
				});
				};
				*/
				// add class to faq entry content
				$entry.next("div").addClass('faqcontent');

				// add title, name and id to entry
				$entry.attr({
					title: "Кликните чтобы свернуть/развернуть",
					name: entryNameSafe,
					id: entryNameSafe
				})
				// add class
				//.addClass("faqclosed")
				.addClass("faqopened")
				// Add click event to entry
				.click( function() {
					$entry.next('div').slideToggle('fast');
					//$entry.toggleClass('faqopened');
					$entry.toggleClass("faqclosed")
					.toggleClass("faqopened");
				})
				// Collapse the span tag of the entry
				.next('div').css({
					//display: "none"
					display: "block"
				});
			}); // end enumeration of each faq entry
		}); // end this each
	}; // end function
	$.fn.maxlength = function(options) {
		// определяем параметры по умолчанию и прописываем указанные при обращении
		var settings = jQuery.extend({
			maxChars: 10, // максимальное колличество символов
			leftChars: "character left" // текст в конце строки информера
		}, options);
		// выполняем плагин для каждого объекта
		return this.each(function() {
			// определяем объект
			var me = $(this);
			// определяем динамическую переменную колличества оставшихся для ввода символов
			var l = settings.maxChars;
			// определяем события на которые нужно реагировать
			me.bind('keydown keypress keyup',function(e) {
				// если строка больше maxChars урезаем её
				if(me.val().length>settings.maxChars) me.val(me.val().substr(0,settings.maxChars));
				// определяем колличество оставшихся для ввода сиволов
				l = settings.maxChars - me.val().length;
				// отображаем значение в информере
				me.next('div').html(l + ' ' + settings.leftChars);
			});
			// вставка информера после объекта
			me.after('<div class="maxlen">' + settings.maxChars + ' ' + settings.leftChars + '</div>');
		});
	};
	$.fn.idleTimeout = function(options) {
		var defaults = {
			inactivity: 1200000, //20 Minutes
			noconfirm: 10000, //10 Seconds
			sessionAlive: 30000, //10 Minutes
			redirect_url: '/',
			click_reset: true,
			alive_url: '/',
			logout_url: '/'

		}

		//##############################
		//## Private Variables
		//##############################
		var opts = $.extend(defaults, options);
		var liveTimeout, confTimeout, sessionTimeout;
		var modal = "<div id='modal_pop'><p>Подтвердите Ваше желание остаться в Личном кабинете.</p></div>";
		//##############################
		//## Private Functions
		//##############################
		var start_liveTimeout = function()
		{
			clearTimeout(liveTimeout);
			clearTimeout(confTimeout);
			liveTimeout = setTimeout(logout, opts.inactivity);

			if(opts.sessionAlive)
				{
				clearTimeout(sessionTimeout);
				sessionTimeout = setTimeout(keep_session, opts.sessionAlive);
			}
		}

		var logout = function()
		{

			confTimeout = setTimeout(redirect, opts.noconfirm);
			$(modal).dialog({
				buttons: {"Остаться в кабинете":  function(){
						$(this).dialog('close');
						stay_logged_in();
				}},
				modal: true,
				title: 'Автовыход из Личного кабинета'
			});

		}

		var redirect = function()
		{
			if(opts.logout_url)
				{
				$.get(opts.logout_url);
			}
			window.location.href = opts.redirect_url;
		}

		var stay_logged_in = function(el)
		{
			start_liveTimeout();
			if(opts.alive_url)
				{
				$.get(opts.alive_url);
			}
		}

		var keep_session = function()
		{
			$.get(opts.alive_url);
			clearTimeout(sessionTimeout);
			sessionTimeout = setTimeout(keep_session, opts.sessionAlive);
		} 

		//###############################
		//Build & Return the instance of the item as a plugin
		// This is basically your construct.
		//###############################
		return this.each(function() {
			obj = $(this);
			start_liveTimeout();
			if(opts.click_reset)
				{
				$(document).bind('click', start_liveTimeout);
			}
			if(opts.sessionAlive)
				{
				keep_session();
			}
		});

	};
	/* block row*/
	$.fn.block_row = function(opts) {
		var row = $(this);
		var height = row.height();
		var offset = row.offset();
		var top = offset.top;
		var left = offset.left;
		$(document.body).append('<div class="holderByBlock" style="position:absolute; top:'+ top + 'px; left:'+ left + 'px; width: 100%; height: ' + height + 'px; overflow: hidden;"></div>');
		$('div.holderByBlock').block(opts); 
	};

	$.fn.unblock_row = function(opts) {
		var row = $(this);
		$('div.holderByBlock').unblock();
		setTimeout(function () {
			$('div.holderByBlock').remove();
		}, 500);
	};
	/* end block row*/
})(jQuery);