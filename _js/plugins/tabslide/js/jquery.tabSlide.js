/*
 * jQuery slideNews v1.0.0 
 *
 * Copyright (c) 2008 Taranets Aleksey
 * www: markup-javascript.com
 * Licensed under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 */
jQuery.fn.slideNews = function(_options){
	// defaults options
	var _options = jQuery.extend({
		btPrev: 'a.link-prev',
		btNext: 'a.link-next',
		tabsNews: 'ul.tabs a',
		holderList: 'div',
		scrollElParent: 'ul',
		scrollEl: 'li',
		duration: 1000,
		autoSlide: false
	},_options)

	return this.each(function(){
		var _this = $(this);
		var _lenghtSlide = $(_options.scrollEl, $(_options.holderList, _this)).length;
		var _gWidth = $(_options.holderList, _this).innerWidth();
		var _liWidth = $(_options.scrollEl, $(_options.holderList, _this)).outerWidth();
		var _liSum = $(_options.scrollEl, $(_options.holderList, _this)).length * _liWidth;
		var _rightArrow = $(_options.btNext,  _this);
		var _leftArrow = $(_options.btPrev,  _this);
		var _tabs = $(_options.tabsNews,  _this);
		var _scrollEl = $(_options.scrollElParent, $(_options.holderList, _this));
		var _margin = 0;
		var _duration = _options.duration;
		var f = 0;
		var _step = _gWidth;
		var _slideTimer = false;
		
		_this.hover(function(){
			if (_slideTimer) clearTimeout(_slideTimer);
		}, function(){
			if (_options.autoSlide) _slideTimer = setTimeout(function(){_this.autoSlide()}, _options.autoSlide);
		});
		_this.bind('mousemove', function(){if (_slideTimer) clearTimeout(_slideTimer);});
		
		_this.nextSlide = function() {
			if (_slideTimer) clearTimeout(_slideTimer);
			if (_liSum - _gWidth  <= _margin + _step) {
				if (f == 0) {_margin = _liSum - _gWidth; f = 1;} 
				else {_margin = 0;f = 0;}
			} else _margin = _margin + _step;
			$(_scrollEl).animate({marginLeft: -_margin+"px"}, {queue:false, duration: _duration, easing: 'easeOutExpo'});
			$(_tabs).removeClass("active");
			$(_tabs).eq(_lenghtSlide-(_liSum-_margin)/_liWidth).addClass("active");
			if (_options.autoSlide) _slideTimer = setTimeout(function(){_this.autoSlide()}, _options.autoSlide);
			return false;
		}
		if (_options.btNext) {
			$(_rightArrow).click(_this.nextSlide);
		}
		if (_options.btPrev) {
			$(_leftArrow).click(function(){
				if (_slideTimer) clearTimeout(_slideTimer);
				_margin = _margin - _step;
				if (_margin < 0) _margin = _liSum - _liWidth;
				$(_scrollEl).animate({marginLeft: -_margin + "px"}, {queue:false, duration: _duration, easing: 'easeOutExpo'});
				$(_tabs).removeClass("active");
				$(_tabs).eq(_lenghtSlide-(_liSum-_margin)/_liWidth).addClass("active");
				if (_options.autoSlide) _slideTimer = setTimeout(function(){_this.autoSlide()}, _options.autoSlide);
				return false;
			});
		}
		if (_options.tabsNews) {
			$(_tabs).click(function(){
				if (_slideTimer) clearTimeout(_slideTimer);
				$(_tabs).removeClass("active");
				var _gn = $(_tabs).index($(this));
				_margin = _step*_gn;
				$(_scrollEl).animate({marginLeft: -_margin + "px"}, {queue:false, duration: _duration, easing: 'easeOutExpo'});
				$(this).addClass("active");
				if (_options.autoSlide) _slideTimer = setTimeout(function(){_this.autoSlide()}, _options.autoSlide);
				return false;
			});
		}
		if (_options.autoSlide) {
			_this.autoSlide = function() {
				_this.nextSlide();
			}
			_slideTimer = setTimeout(function(){_this.autoSlide()}, _options.autoSlide);
		}
	});
}
