// Hi! My name is loadprocess!
// I'am jQuery plugin, part of jQuery Trivial, for show information about
// loading just tell me what you want to do on loading and after that
// and i do that
//
// My bio:
// version: 0.3b (1 April, 2009)
// license: MIT
//
// My creator name is Alexander Koss (kossnocorp@gmail.com)
// Meet at the http://github.com/kossnocorp/jquery-loadprocess


$(function() {

	//

	$.fn.loadprocess = function(settings) {

		// count of current processes

		$.fn.loadprocess.count = 1;

		//

		$.fn.loadprocess.defaults = $.fn.loadprocess.sets = {
			load_start: null,
			load_end: null
		};

		$.fn.loadprocess.sets = $.extend($.fn.loadprocess.defaults, settings);

		//

		$.fn.loadprocess.loading = function() {
			$.fn.loadprocess.count++;
			if($.fn.loadprocess.sets.load_start) $.fn.loadprocess.sets.load_start();
		};

		//

		$.fn.loadprocess.loadend = function() {
			$.fn.loadprocess.count--;
			if($.fn.loadprocess.count == 0 && $.fn.loadprocess.sets.load_end) $.fn.loadprocess.sets.load_end();
		}

		//

		$().ajaxStart($.fn.loadprocess.loading);
		$().bind('loadprocess_loading', $.fn.loadprocess.loading)
		$().ajaxComplete($.fn.loadprocess.loadend);
		$().bind('ready', $.fn.loadprocess.loadend);
		$().bind('loadprocess_loadend', $.fn.loadprocess.loadend)
		//
	};

	// catch load functions

	$.fn.extend({
		load_origin: $.fn.load,
		load: function(url, params, callback) {
			$().trigger('loadprocess_loading');

			if(typeof url !== 'string') {
				
				return $(this).load_origin(function() {
					$().trigger('loadprocess_loadend');
					url();
				});

			} else {

				return $(this).load_origin(url, params, function(responseText, status, res) {
					$().trigger('loadprocess_loadend');
					callback(responseText, status, res);
				});
			}
		}
	});
});