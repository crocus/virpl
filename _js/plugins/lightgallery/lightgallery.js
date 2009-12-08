/**
 * lightgallery.js v1.2.3
 * Author: Dmitri Ischenko - ischenkodv@gmail.com
 * Freely distributable under MIT-style license.
 */
var lightgallery = (function(){

// local variables
var dx,
	dy,
	options = {
		showOverlay		: true,
		overlayColor	: '#000',
		overlayOpacity	: .85,
		zoomStep		: .2,
		animate			: true,
		framesNumber	: 20,
		speed			: 30,
		resizeSync		: false,	// resize container both vertically and horizontally at the same time
		enableZoom		: true,
		fadeImage		: true,
		alias			: 'lightgallery',
		fullSize		: false,
		minPadding		: 15		// minimal distance between container and window
	},
	langVars = { // Language variables
		next	: 'Next',
		prev	: 'Previous',
		zoomIn	: 'Zoom In',
		zoomOut	: 'Zoom Out',
		fullSize: 'Full Size',
		fitScreen: 'Fit screen',
		close	: 'Close',
		image	: 'Image',
		of	: 'of'
	},

	/* container and its elements */
	container,		// container which holds image;
	titleBar,		// title bar
	prevBtn,		// "previous" button
	nextBtn,		// "next" button
	imgIndex,		// index of images
	fullSizeBtn,	// button which show image full size

	loaderImage,	// image loader
	picture,		// image
	gallery,
	isOpen,			// if gallery open?
	current,		// index of the current image showing
	
	/* overlay */
	overlay,
	overlayWidth,	// width of the overlay
	overlayHeight,	// height of the overlay
	
	/* constants */
	hidden = 'hidden',
	visible = 'visible',
	block = 'block',
	none = 'none',
	DIV = 'div',
	
	images = [];	// list of images

var G = {

	/**
	 * Set language variables
	 * @param {Object} oVars - language variables
	 */
	setLangVars : function(vars){
		extend(langVars, vars);
	},


	/**
	 * Initialize gallery
	 * @param {object} options - gallery options
	 */
	init : function(opts){
		extend(options, opts);
		options.fullSize = options.fullSize ? 1:0;

		// get images
		images = [];
		var	imgs = document.getElementsByTagName('a'),
			regx = new RegExp('^'+options.alias+'\\[([a-zA-Z]+)\\]|'+options.alias+'$'),
			r;		// variable to hold RegEx matches
		
		// filter images that match specified RegEx expression
		for (var i=0, len=imgs.length; i<len; i++) {
			if(!imgs[i].__is_init__ && imgs[i].rel && (r = imgs[i].rel.match(regx))){
				addEvent(imgs[i],'click', G.showImage);
				if(r = r[1]){
					imgs[i].__gallery__ = r;
					if(!images[r])
						images[r] = [];

					imgs[i].__index__ = images[r].push(imgs[i]) - 1;
				}
				imgs[i].__is_init__ = true;
			}
		}

		// create overlay and container and add it to body
		var b=document.getElementsByTagName('body')[0];
		
		if (options.showOverlay){
			b.appendChild( overlay = _(DIV,{
				id:'LG_overlay',
				events:{click: G.close}
				})
			);
		}
		
		b.appendChild( container = createContainer() );

		if (b.attachEvent)
			addEvent(b,'keypress',keyPressHandler);	// for IE
		else
			addEvent(window,'keypress',keyPressHandler);

		// create new Image element to load images
		(loaderImage = _('img')).onload=function(){
			hideLoadingIcon();
			loaderImage.__is_loaded__=true;
			picture.setAttribute("src", loaderImage.src);
			setContPos(options.fullSize);
			G.preload(current);
		}

		// define the difference between container and image size
		dy = container.offsetHeight;
		dx = 0;
		
		// set default color and opacity for overlay
		css(overlay, {
			background:(options.overlayColor)
		});
		setOpacity(overlay, options.overlayOpacity);
	},

	/**
	 * Open (show) gallery
	 */
	open : function(){
		// set overlay size and show it using fade in effect
		var	ar = getPageSize();

		if (overlay){
			css(overlay, {
				width:(G.overlayWidth = ar[0]) + "px",
				height: (G.overlayHeight = ar[1]) + "px", display:block
			});
			fadeIn(overlay, 0, options.overlayOpacity*100, 9);
		}

		// display container
		picture.style.display=block;
		setContPos();
		css(container, {visibility:visible, display:block});
		isOpen = true;
	},

	/**
	 * Close gallery
	 */
	close : function(){
		if (overlay){
			overlay.style.display = none;
		}
		css(container, {visibility:hidden,display:none});
		isOpen = false;

		loaderImage.src=picture.src='';
		loaderImage.__is_loaded__=false;
	},

	zoomIn : function(){
		G.Zoom(1 + options.zoomStep);
	},

	zoomOut : function(){
		G.Zoom(1 - options.zoomStep);
	},

	zoomNormal : function(){
		if(this.$disabled)
			return;

		G.Zoom(
			picture.width == loaderImage.width && picture.height == loaderImage.height ? 0 : 1
		);
	},

	Zoom : function(coef){
		hideContent();
		setContPos(coef)
	},

	/**
	 * Preload adjacent images
	 * @param {Object} index - index of the image in the gallery
	 */
	preload : function(index){
		//if(window.opera) return;

		var gal = images[gallery];
		if(!gal)
			return;
		(new Image).src = (gal[index+1]) ? gal[index+1].href : '';
		(new Image).src = (gal[index-1]) ? gal[index-1].href : '';
	},

	/**
	 * Shows image when user click it
	 * @param {Object} e - event object
	 */
	showImage : function(e){
		var i = this.__index__, e = e || window.event;
		stopDefault(e);

		if (this.__gallery__ && i > -1) {
			gallery = this.__gallery__;
			G.show(i);
		} else {
			G.showSingle(this);
		}
	},

	/**
	 * Show single image
	 * @param {Element} elem - reference to element
	 */
	showSingle : function(elem){
		if(!isOpen)
			G.open();

		hideContent();
		showLoadingIcon();
		loaderImage.__is_loaded__=false;

		loaderImage.src=elem.href;
		titleBar.innerHTML = elem.title;
		imgIndex.innerHTML = '';
		prevBtn.style.visibility = hidden;
		nextBtn.style.visibility = hidden;
	},

	/**
	 * Show image from the gallery
	 * @param {Number} index - index of the image
	 */
	show : function(index){
		if(!index && gallery === null)
			return;

		if(!isOpen)
			G.open();

		var gal = images[gallery],
			ns = nextBtn.style,
			ps = prevBtn.style;

		if(index < 0 || index > gal.length-1)
			return;

		hideContent();
		showLoadingIcon();

		loaderImage.__is_loaded__=false;
		loaderImage.src=gal[index].href;
		titleBar.innerHTML = gal[index].title;
		imgIndex.innerHTML = langVars.image+' '+(index+1)+' '+langVars.of+' '+gal.length;

		if(index === 0){
			setOpacity(prevBtn, 0);
			nextBtn.$active = !(prevBtn.$active = false);
			ps.visibility = hidden;
			ns.visibility = visible;
		}else if(index === gal.length-1){
			setOpacity(nextBtn, 0);
			nextBtn.$active = !(prevBtn.$active = true);
			ps.visibility = visible;
			ns.visibility = hidden;
		}else if(index > 0 || index < gal.length-1){
			prevBtn.$active = nextBtn.$active = true;
			ps.visibility = ns.visibility = visible;
		}
		current = index;
		window.focus();
	},

	// show next image
	next : function(){
		if(current < images[gallery].length-1)
			G.show(++current);
	},

	// show previous image
	prev : function(){
		if(current > 0)
			G.show(--current)
	}
}

/**
 * Set the size and position of the container
 * @param {Number} vScale - scale of the image: 1 - full size, >1 - zoom in, <1 - zoom out
 */
function setContPos(vScale){
	// define references and variables
	var	notFitScreen, fsTitle, w,h,
		padding = options.minPadding*2,
		framesNumber = options.framesNumber,
		ar = getPageSize(),

		// size of the container plus padding
		contWidth = loaderImage.width + dx + padding,
		contHeight = loaderImage.height + dy + padding,

		// size of the viewport
		wScr = ar[2],
		hScr = ar[3],

		// proportions
		dim_scr = wScr/hScr,
		dim_pic = contWidth/contHeight;

	// define width and height of the container
	if (loaderImage.__is_loaded__ && !vScale) {
		// set size of the container according to the size of the viewport
		if (contWidth > wScr || contHeight > hScr) {
			if (dim_pic > dim_scr) {
				contWidth = wScr;
				contHeight = wScr*contHeight/contWidth;
			} else {
				contWidth = hScr*contWidth/contHeight;
				contHeight = hScr;
			}
		}
		picture.width = (w = contWidth-padding) - dx;
		picture.height = (h = contHeight-padding) - dy;
	} else if (vScale==1) {
		// show image in real size
		w = (picture.width = loaderImage.width) + dx;
		h = (picture.height = loaderImage.height) + dy;
	} else if (vScale < 1 || vScale > 1) {
		// zoom image according to vScale
		w = (picture.width *= vScale) + dx;
		h = (picture.height *= vScale) + dy;
	}else{
		w = h = 300;	// default size
		var disableAnimate = true;
	}


	// enable/disable the full size button
	if ( notFitScreen = ( contWidth > wScr || contHeight > hScr ) ) {
		fsTitle = langVars.fitScreen;
		fsClass = 'LG_fitScreen';
	} else {
		fsTitle = langVars.fullSize;
		fsClass = 'LG_zoomNormal';
	}

	fullSizeBtn.$disabled = false;
	if (picture.width == loaderImage.width) {
		// it is real size of the image
		if (notFitScreen) {
			fullSizeBtn.className = fsClass;
			fullSizeBtn.setAttribute('title', fsTitle);
		} else {
			fullSizeBtn.className = 'LG_zoom_disabled';
			fullSizeBtn.$disabled = true;
		}
	} else {
		fullSizeBtn.className = 'LG_zoomNormal';
		fullSizeBtn.setAttribute('title', langVars.fullSize);
	}

	// here we set the minimal width of the container to 300px
	w = Math.max(w,300);
	
	// size of the container including padding
	var pWidth = w + padding,
		pHeight = h + padding;

	// if image is more than current document we need to resize overlay
	css(overlay, {
		width:	( pWidth > G.overlayWidth ? w + padding : G.overlayWidth) + 'px',
		height:	( pHeight > G.overlayHeight ? h + padding : G.overlayHeight) + 'px'
	});

	// correct coords according to scroll bars position
	var	scr = getScrollXY(),
		y = (hScr>pHeight ? (hScr - h)/2 : options.minPadding) + scr[1],
		x = (wScr>pWidth ? (wScr - w)/2 : options.minPadding) + scr[0],

		// set the width of the prev/next buttons as 1/3 of the picture width
		nw = (w/3) + 'px',
		nh = (h - dy - 10) + 'px';

	css(nextBtn, {width:nw, height:nh});
	css(prevBtn, {width:nw, height:nh});

	if(options.animate && !disableAnimate){
		var anime = new Movie(container, framesNumber, options.speed);
		if (options.resizeSync) {
			anime.addThread('width', null, w, 0, framesNumber)
			.addThread('left', null, x, 0, framesNumber)
			.addThread('height', null, h, 0, framesNumber)
			.addThread('top', null, y, 0, framesNumber);
		} else {
			var middle = Math.ceil(framesNumber / 2);
			anime.addThread('width', null, w, 0, middle)
			.addThread('left', null, x, 0, middle)
			.addThread('height', null, h, middle, framesNumber)
			.addThread('top', null, y, middle, framesNumber);
		}
		anime.addAction(function(){
			showContent()
		},options.framesNumber-1);
		anime.run();
	}else{
		css(container, {top: y+"px", left: x+"px", width: w+"px", height: h+"px"});
		showContent();
	}
}

/**
 * Show container content
 */
function showContent(){
	var	nodes = container.childNodes,
		showLoop = function(){
				for (var i=nodes.length; --i>-1;)
					nodes[i].style.display = block;
			};
	if(options.fadeImage){
		(new Movie(picture, 8, options.speed))
			.addThread('opacity', 0, 100)
			.addAction(showLoop, 0)
			.run();
	}else{
		showLoop();
		setOpacity(picture, 100);
	}
}

/**
 * Hide container content
 */
function hideContent(){
	for (var i=container.childNodes.length; --i>-1;)
		container.childNodes[i].style.display = none;

	setOpacity(picture, 0);
}

function showLoadingIcon(){
	container.className='LG_loading';
}

function hideLoadingIcon(){
	container.className = '';
}

/**
 * Create container
 */
function createContainer(){
	var zoomIn, zoomOut;
	if (options.enableZoom) {
		zoomIn = _(DIV, {
			'class': 'LG_zoomIn',
			title: langVars.zoomIn,
			events: {
				click: G.zoomIn
			}
		});
		zoomOut = _(DIV, {'class':'LG_zoomOut',title:langVars.zoomOut,
			events:{click:G.zoomOut}
		})
	}
	return _(DIV, {id:'LG_container'},
				_(DIV,0,
						zoomIn, zoomOut,
						fullSizeBtn = _(DIV, {'class': 'LG_zoomNormal',title: langVars.fullSize,
								events: {click: G.zoomNormal}
							}),
						imgIndex = _(DIV, {'class':'LG_imgIndex'}),
						_(DIV,{'class':'LG_closeBtn',title:langVars.close,
								events:{'click':G.close}
							}),_('br',{clear:'all'})
					),
					picture = _('img', {id:'LG_pic',width:300,height:300}),
					titleBar = _(DIV, {'class':'LG_titleBar'}),
					prevBtn = _(DIV, {'class':'LG_prevLink',title:langVars.prev,
										events:{
											click:G.prev,
											mouseover:showBtn,
											mouseout:hideBtn
										}
									}),
					nextBtn = _(DIV,{'class':'LG_nextLink',title:langVars.next,
										events:{
											click:G.next,
											mouseover:showBtn,
											mouseout:hideBtn
										}
									})
	)
}

function keyPressHandler(e){
	if(!isOpen)
		return;
	var	e=e||window.event,
		code=e.keyCode?e.keyCode:(e.which?e.which:e.charCode);
	switch(code){
		case 110:G.next();break;		// n key
		case 98: G.prev();break;		// b key
		case 102: G.zoomNormal();break;	// f key
		case 43: G.zoomIn();break;		// +
		case 45: G.zoomOut();break;		// -
		case 27: G.close();				// Esc key
	}

	stopDefault(e);
}

function showBtn(){
	if (this.$active)
		fadeIn(this,0,100)
}

function hideBtn(){
	if (this.$active)
		fadeOut(this,100,0)
}

function fadeIn(elem, levelStart, levelEnd, frames, speed){
	fade(elem, levelStart || 0, levelEnd || 100, frames, speed);
}
function fadeOut(elem, levelStart, levelEnd, frames, speed){
	fade(elem, levelStart || 100, levelEnd || 0, frames, speed);
}
function fade(elem, levelStart, levelEnd, frames, speed){
	if (options.animate)
		(new Movie(elem, frames || 5, speed || 40)).addThread('opacity', levelStart, levelEnd).run();
	else
		setOpacity(elem, levelEnd);
}

function stopDefault(e){
	if(e.preventDefault)
		e.preventDefault();
	else
		e.returnValue=false;
}

/**
 * Add event listener
 */
function addEvent(el, type, fn) {
	if (window.addEventListener) {
		addEvent = function(el, type, fn) {
			el.addEventListener(type, fn, false);
		}
	} else if (window.attachEvent) {
		addEvent = function(el, type, fn) {
			var f = function() {
				fn.call(el, window.event);
			}
			el.attachEvent('on' + type, f);
		}
	}
	return addEvent(el,type,fn);
}

/**
 * Extends object with properties of another object
 * @param object target
 * @param object source
 */
function extend (target, source) {
	for (var i in source)
		target[i] = source[i];
}

function css(elem, styles){
	if (elem){
		extend(elem.style, styles);
	}
}

/**
 * Get the page and viewport size
 * @return {Array}
 */
function getPageSize(){
	var xScroll, yScroll, windowWidth, windowHeight, b = document.body, de = document.documentElement;
	if (window.innerHeight && window.scrollMaxY) {
		xScroll = b.scrollWidth;
		yScroll = window.innerHeight + window.scrollMaxY;
	} else if (b.scrollHeight > b.offsetHeight){ // all but Explorer Mac
		xScroll = b.scrollWidth;
		yScroll = b.scrollHeight;
	} else if (de && de.scrollHeight > de.offsetHeight){ // Explorer 6 strict mode
		xScroll = de.scrollWidth;
		yScroll = de.scrollHeight;
	} else { // Explorer Mac...would also work in Mozilla and Safari
		xScroll = b.offsetWidth;
		yScroll = b.offsetHeight;
	}

	if (self.innerHeight) { // all except Explorer
		windowWidth = self.innerWidth;
		windowHeight = self.innerHeight;
	} else if (de && de.clientHeight) { // Explorer 6 Strict Mode
		windowWidth = de.clientWidth;
		windowHeight = de.clientHeight;
	} else if (b) { // other Explorers
		windowWidth = b.clientWidth;
		windowHeight = b.clientHeight;
	}

	// for small pages with total height less then height of the viewport
	var pageHeight = yScroll < windowHeight? windowHeight : yScroll;

	// for small pages with total width less then width of the viewport
	var pageWidth = xScroll < windowWidth? windowWidth : xScroll;

	return [pageWidth,pageHeight,windowWidth,windowHeight]
}

/**
 * Get coords of scroll bars
 * @return {Array} - [coord horizontal, coord vertical]
 */
function getScrollXY() {
	var scrOfX = 0, scrOfY = 0, b = document.body, de = document.documentElement;
	if( typeof( window.pageYOffset ) == 'number' ) {
		//Netscape compliant
		scrOfY = window.pageYOffset;
		scrOfX = window.pageXOffset;
	} else if( b && ( b.scrollLeft || b.scrollTop ) ) {
		//DOM compliant
		scrOfY = b.scrollTop;
		scrOfX = b.scrollLeft;
	} else if( de && ( de.scrollLeft || de.scrollTop ) ) {
		//IE6 Strict
		scrOfY = de.scrollTop;
		scrOfX = de.scrollLeft;
	}
	return [ scrOfX, scrOfY ];
}

/**
 * Get elements style
 * @param {Object} elem - element
 * @param {Object} name - name of the style to get
 */
function getStyle(elem, name) {
	var d = document.defaultView;
	if (elem.style[name])
		return elem.style[name];	

	else if (elem.currentStyle)
		return elem.currentStyle[name];

	else if (d && d.getComputedStyle) {
		name = name.replace(/([A-Z])/g,"-$1");
		name = name.toLowerCase();

		var s = d.getComputedStyle(elem,"");
		return s && s.getPropertyValue(name);
	}
	return null;
}

/**
 * Cross-browser function to set element opacity
 * @param {Element} elem - element
 * @param {Number} level - level of opacity, percent
 */
function setOpacity() {
	setOpacity = arguments[0].filters ?
		function(elem,level){elem.style.filter = "alpha(opacity="+level+")"} :
		function(elem,level){elem.style.opacity = level / 100}
	setOpacity(arguments[0],arguments[1]);
}

/**
 * Create HTML element
 * @param {String} tag - tag name
 * @param {Object} attr - attributes to set, ex: {'name':'someClass',value:'the value'}
 */
function _(tag, attr){

	var elem = document.createElement(tag);

	if (attr){
		for (var name in attr){
			if(name == 'events'){
				for(var j in attr[name])
					addEvent(elem, j, attr[name][j]);
			}else{
				var value = attr[name];
				if ( typeof value != "undefined" ) {
					if(name == 'class' || name == 'for'){
						name = { "for": "htmlFor", "class": "className" }[name] || name;
						elem[name] = value;
					} else
						elem.setAttribute(name, value);
				}
			}
		}
	}

	for(var i=2, len=arguments.length; i<len; i++){
		switch (typeof arguments[i]) {
			case 'string':elem.innerHTML += arguments[i];break;
			case 'object':elem.appendChild(arguments[i]);break;
		}
	}

	return elem;
}

/**
 * Class which makes and run animations
 * @param {Element} elem - target element
 * @param {Number} num_frames - number of frames
 * @param {Number} speed - time between each frame, msec
 */
function Movie(elem, num_frames, speed){
	if (!elem)
		return null;

	this.elem = elem;
	this.numFrames = num_frames || 0;
	this.frames = [];		// frames array
	this.speed = speed || 10;
}

/**
 * Add thread - the chain of actions to do on the element
 * @param {String} style - style name
 * @param {Number} startValue - value at the beginning of animation
 * @param {Number} endValue - end value
 * @param {Number} startFrame - frame, from which the animation of thread begin
 * @param {Number} endFrame - frame, which ends the animation
 */
Movie.prototype = {
addThread : function(style, startValue, endValue, startFrame, endFrame){
	if (!style || endValue === 'undefined' || endValue === null) return;

	if(style !== 'opacity')
		startValue = parseFloat(getStyle(this.elem, style));

	startFrame = startFrame || 0;
	endFrame = endFrame || this.numFrames;

	var	elem = this.elem,						// reference to current element
		F = this.frames,						// reference to frames collection
		count = (endFrame - startFrame) || 1,	// number of frames, should be at least 1
		step = (startValue-endValue)/count;

	for (startFrame; startFrame<endFrame; startFrame++){
		if (!F[startFrame])
			F[startFrame] = new MovieFrame;
		F[startFrame].addStyle([elem,style,startValue -= step]);
	}
	return this;
},

/**
 * Creation of the anonimous function that changes the style
 * @param {Element} elem - target element
 * @param {String} name - style name
 * @param {Number} value - style value
 */
/*createAction : function(elem, name, value){
	return name == 'opacity'?
		function(){setOpacity(elem, value)} :
		function(){elem.style[name] = value+'px'}
},*/

/**
 * Add action to the frame specified
 * @param {Function} func - reference to the function or anonimous function
 * @param {Number} frameNumber - number of frame to put the action in
 */
addAction : function(func, frameNumber){
	this.frames[frameNumber].addAction(func);
	return this;
},

/**
 * The step - run the next frame
 */
step : function(){
	var frame = this.frames.shift();

	if (frame)
		frame.exec();
	else
		clearInterval(this.interval);
},

/**
 * Show the animation
 */
run : function(){
	clearInterval(this.interval);
	this.step();

	var t = this;
	if (this.numFrames>1)
		this.interval = setInterval(function(){t.step()}, this.speed);
}
}



/**
 * Class "movie frame" contains list of actions to run
 */
function MovieFrame(){
	this.actions = [];
	this.styles = [];
}

MovieFrame.prototype = {
	/**
	 * Add action to the frame
	 * @param {Function} f - anonimous function or reference to the function
	 */
	addAction : function(f){
		this.actions.push(f)
	},

	/**
	 * This function adds one particular style to change
	 * @param {Array} aStyle - object which has this form {array,style,value}
	 */
	addStyle : function(aStyle){
		this.styles.push(aStyle);
	},

	/**
	 * Executes all actions of the frame
	 */
	exec : function(){
		var s = this.styles, act, i;
		for (i=s.length; --i>-1;){
			if(s[i][1]=='opacity')
				setOpacity(s[i][0],s[i][2]);
			else
				s[i][0].style[s[i][1]]=s[i][2]+'px';
		}

		if(act = this.actions.shift()) act();
	}
}

return G;
})();
