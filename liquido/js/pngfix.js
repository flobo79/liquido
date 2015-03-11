/*
 
Correctly handle PNG transparency in Win IE 5.5 & 6.
author:
	Shaun Freeman.
	http://www.shaunfreeman.co.uk
	
based on:
	http://homepage.ntlworld.com/bobosola.
	http://clientside.cnet.com/wiki/cnet-libraries/01-browser-fixes

Use in:
	<head>
	
Options:
	el: element with the png to fix, defaults to document.body.
	cssImages: HTMLCollections, arrays of elements, elements, or strings as selectors with png's to fix, defauls to null.
	initializeOnLoad: set to fix png's on page load, defaults to true.
	
Example 1:

	<script type="text/javascript" src="mootools.js"></script>
	<!--[if IE]>
		<script type="text/javascript" src="pngfix.js"></script>
		<script>
			var supBrowser = (Browser.Engine.trident && !Browser.Engine.trident5 && document.body.filters) ? true : false;
			if (supBrowser) {
				window.addEvent('domready', function(){
					new pngFix({cssBgElements: ['#top']});
				});
			}
		</script>
	<![endif]-->

Example 2:

	<script type="text/javascript" src="mootools.js"></script>
	
	<script>
		var supBrowser = (Browser.Engine.trident && !Browser.Engine.trident5 && document.body.filters) ? true : false;
		if (supBrowser) {
			window.addEvent('domready', function(){
				new Asset.javascript('pngfix.js');
			}).chain(function(){
				new pngFix({cssBgElements: ['#top']});
			});
		}
	</script>
*/

var pngFix = new Class({
	Implements: [Options],
	options: {
		el: document.body,
		cssBgElements: null,
		initializeOnLoad: true
	},
	initialize: function(options) {
		if (options) this.setOptions(options);
		if (this.options.initializeOnLoad) this.fixPNGElements(this.options.el);
		if (this.options.cssBgElements) this.bgImgFix(this.options.cssBgElements);
	},
	fixPNGElements: function(element) {
		var allImages = $(element).getElements('img');
		allImages.each(function(img) {
			this.fixPNGImg(img);
		}.bind(this));
	},
	fixPNGImg: function(img) {
		var imgProps = img.getProperties('id', 'src', 'title', 'alt', 'align');
		if (imgProps.src.test('.png', 'i')) {
			var imgStyles = img.getStyles();
			var imgDisplay = 'inline-block';
			if (imgProps.align == 'left') var imgFloat = 'left';
			if (imgProps.align == 'right') var imgFloat = 'right';	
			if (img.getParent().getProperty('href')) var imgCursor = 'hand';
			var replacement = new Element('span', {
				'id': (imgProps.id) ? imgProps.id : '',
				'class': (img.className) ? img.className : '',
				'title': (imgProps.title) ? imgProps.title : (imgProps.alt) ? imgProps.alt : '',
				'styles': {
					'display': imgDisplay,
					'width': img.getWidth() + 'px',
					'height': img.getHeight() + 'px',
					'cursor': imgCursor,
					'float': (imgFloat) ? imgFloat : '',
					'filter': "progid:DXImageTransform.Microsoft.AlphaImageLoader (src='" + imgProps.src + "', sizingMethod='scale');"	
				},
				'src': imgProps.src
			}).setStyles(imgStyles).cloneEvents(img).replaces(img);
		}
	},
	bgImgFix: function(bgElements) {
		var cssImages = $$(bgElements);
		cssImages.each(function(img) {
			var imgURL = img.getStyle('background-image');
			if (imgURL.test(/\((.+)\)/)){
				img.setStyles({
					'background-image': 'none',
					'filter': "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod='crop', src=" + imgURL.match(/\((.+)\)/)[1] + ")"
				});
			};
		});
	}
});

var noPNGSupport = (typeof document.body.filters != 'undefined') ? true : false;

if (noPNGSupport) new pngFix({cssBgElements: ['#top']});
