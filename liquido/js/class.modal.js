/**
 * this class provides functions to create and manage a floating modal window
 * 
 * @author flobo
 */

var Modal = new Class({
	windowtitle:'',
	width:400,
	height:200,
	html: '<div class="loading">loading...</div>',
	div:false,
	maskcolor:'#000',
	maskopacity:0.5,
	className:'',
	padding:0,
	callbacks:{},
	
	initialize:function(settings) {
		for(e in settings) {
			this[e] = settings[e];
		}

		var _this = this;
		var scrollpos = $(window).getScroll();
		var winsize = $(window).getSize();
		var toppos= Math.abs(((winsize.y-this.height) / 3))+scrollpos.y+10;
		
		this.div = new Element('div', {
			id:'floating_window',
			styles:{
				margin:'0 -'+(this.width/2)+'px',
				width:this.width+"px",
				position:'absolute',
				padding:this.padding+'px',
				left:'50%',
				top:toppos+'px',
				height:this.height+'px',
				zIndex:305,
				backgroundColor:'#FFF',
				overflow:'hidden'
			},
			'class':this.className,
			html:['	<div id="window_content">',
				' ',
				this.content,'</div>'].join('')
		}).inject(document.body,'top');
		
		
		this.bg = new Element('div',{
			id:'modal_bg',
			styles:{
				height:'100%',
				width:'100%',
				position:'absolute',
				backgroundColor:this.maskcolor,
				opacity:this.maskopacity,
				top:scrollpos.y+'px',
				left:0,
				margin:0,
				zIndex:300
			}
		}).inject(document.body,'top');
		
		
		this.bu_close = new Element('div',{id:'bu_modal_close'}).inject(this.div);	
		this.div.style.position='absolute';
		this.winFX = new Fx.Morph(this.bg, {duration: 200, transition:Fx.Transitions.Quint.easeOut}).start({opacity:0.4});
	},
	
	close:function() {
		var parent = this;
		if(typeof this.callbacks.close == 'function') {
			this.callbacks.close();
		}
		this.div.dispose();
		this.winFX.start({
			'opacity': 0
		}).chain(function () { $('modal_bg').dispose(); delete parent; });
	},
	 
	_logout:function() {
		if(!this.steady) {
			this.close();
		}
	},
	
	_close_modal:function() {
		if(!this.steady) {
			this.close();
		}
	}
});