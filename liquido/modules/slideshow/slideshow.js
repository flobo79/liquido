/**
 * @author flobo
 */
Slideshow = new Class({
	id:false,
	browser:false,
	connector:'/liquido/modules/slideshow/connector.php',
	gallery:false,
	box:false,
	autostart:false,
	timer:false,
	delay:5000,
	currentItem:0,
	autostart:false,
	
	initialize:function(obj) {
		this.id = obj.id;
		this.gallery = obj.gallery;
		if(obj.delay) { this.delay = obj.delay; }
		if(obj.autostart) { this.autostart = obj.autostart; }
	
		var id = obj.id;
		var gallery = obj.gallery;
		var _this = this;
		var window = false;
		var childs = [];
		var box = $('obj'+id);
		
		if (typeof Modal == 'undefined') {
			Asset.javascript('/liquido/js/class.modal.js');
		}
		
		
		if(typeof compose != 'undefined' && compose === true) {
			// in compose modus Mediabrowser is loaded and can be used by the slideshow
			if(typeof Mediabrowser !== 'undefined') {
				_this.browser = new Mediabrowser();
				_this.browser.connector = '../medialibrary/browser/connector.php';
				_this.browser.details.picture = function() { _this.browser.current = _this.browser.previous; };
				_this.browser.callbacks.list = function (box) {
					if (box.id != 'list0') {
						var el = new Element('div', {
							html: ' + Als Slideshow verwenden',
							events: {
								click: function(){
									_this.setGallery(box.id);
								}
							}
						}).inject(box);
					}
				};
			}
		}
		
		_this.box = $('ss_list_'+id);
		
		if (gallery) {
			/* load json_data from .data box and decode it to data */
			_this.childs = JSON.decode(_this.box.getElement('.data').innerHTML);
			
			/* add life to images */
			$$('#ss_list_'+id+'>div').addEvent('click',function(e) {
				_this.openGallery(e.target.getParent().id.substr(1));
			});
		}
		
		_this.box.style.display='block';
	},
	
	openGallery:function(id) {
		_this = this;
		
		this.slideshow = new Modal({
			maskopacity:0,
			width:700,
			height:450,
			className:'Slideshow',
			callbacks: {
				close:_this.stopSlideshow	
			}
		});
		
		this.slideshow.content = this.slideshow.div.getElement('#window_content');
		
		// to make the background of the window opaque, not the window itself
		if (this.$i(id).mime != 'flv') {
			var win_bg = new Element('div', {
				styles: {
					opacity: 0.8,
					zIndex:400,
					backgroundColor: '#000',
					position: 'absolute',height:'450px',width:'690px',top:'10px'
				}
			}).inject(this.slideshow.div,'top');
		} else {
			var win_bg = new Element('div', {
				styles: {
					opacity: 0.8,
					zIndex:400,
					backgroundColor: '#000',
					position: 'absolute',height:'450px',width:'690px',top:'10px'
				}
			}).inject(this.slideshow.div,'top');
			$('window_content').setStyles({top:'40px'});
		}
		
		$('floating_window').setStyles({opacity:1, backgroundColor:'transparent' });
		$('bu_modal_close').onclick = function(){ 
			_this.stopSlideshow() 
			_this.slideshow.close(); 
		};
		
		var listcontrols;
		
		if (this.$i(id).mime != 'flv') {
		
			listcontrols = new Element('div',{
				id:this.id+'ss_controls',
				'class':'ss_controls',
				styles:{
					opacity:'.8'
				},
				html:"<div class=\"ss_controls_info\"> "+
				"Klicken Sie auf + oder - um die Slideshow zu beschleunigen oder zu verlangsamen"+
				"</div><div class=\"ss_controls_box\"> <div id=\"ss_controls_play\" onclick=\"currentGallery.play();\"> </div>"+
				"<div id=\"ss_controls_minus\" onclick=\"currentGallery.minus();\">-</div>"+
				"<div id=\"ss_controls_sec\">"+(this.delay/1000)+"</div>"+
				"<div id=\"ss_controls_plus\" onclick=\"currentGallery.plus();\">+</div></div>"
			});
			this.slideshow.content.adopt(listcontrols);
		}
		
		if (this.$i(id).mime != 'flv') {
			FXcontrols = new Fx.Morph(listcontrols, {duration:300});
			$('window_content').addEvents({
				mouseenter:function() {
					FXcontrols.cancel(); FXcontrols.start({opacity:'0.8'});
					//FXthumbs.cancel(); FXthumbs.start({opacity:'0.8'});
				},
				mouseleave:function() { 
					FXcontrols.cancel(); FXcontrols.start({opacity:'0.01'});
					//FXthumbs.cancel(); FXthumbs.start({opacity:'0.01'});
				}
			});
		}
			
		this.view = new Element('div',{id:'ss_view',
			html: ''
		}).inject(_this.slideshow.content);
		
		
		if(typeof pngfix === 'function') {
			pngfix(this.slideshow.div);
		}
		
		if(typeof id != 'undefined') {
			this.showItem(id);
		}
		
		if(this.autostart) { this.play(); }
		
		currentGallery = this;
	},
	
	play:function() {
		this.timer ? this.stopSlideshow() : this.startSlideshow();
	},
	
	startSlideshow:function() {
		this.timer = setInterval(this.nextPicture, this.delay);
		if($('ss_controls_play'))
			$('ss_controls_play').addClass('stop');
	},
	
	stopSlideshow:function() {
		if ((this.timer)) {
			clearInterval(this.timer);
			this.timer = false;
		}
		if($('ss_controls_play'))
			$('ss_controls_play').removeClass('stop');
	},
	
	plus:function() {
		this.delay = Number(this.delay) + 1000;
		$('ss_controls_sec').innerHTML = this.delay / 1000;
	},
	
	minus:function() {
		if(Number(this.delay) > 1000) {
			this.delay = Number(this.delay)-1000;
		}
		$('ss_controls_sec').innerHTML = this.delay / 1000;
	},
	
	slideshowTimer:function() {
		

	},
	
	nextPicture:function() {
		currentGallery.currentItem = (typeof currentGallery.childs[currentGallery.currentItem+1] != "undefined" ? currentGallery.currentItem+1 : 0);
		currentGallery.showItem(currentGallery.childs[currentGallery.currentItem]['id']);
	},
	
	showItem:function(id) {
		var item = this.$i(id);
		var _this = this;
		this.currentItem = item.index;
		this.view.empty();
		switch(item.mime) { 
			case 'picture':
				this.view.adopt(new Element('div',{
					styles:{
						background:'transparent url(/liquido_medialib/'+item.id+'/large.jpg) center no-repeat',
						height:'100%',
						width:'100%'
					}
				}));
				break;
			case 'flv':
				var obj = new Swiff('/liquido/modules/flvplayer/player.swf', {
				    id: 'movie',
				    width: 480,
				    height: 350,
					container:_this.view,
				    params: {
				        wmode: 'opaque',
				        bgcolor: '#FFF',
						allowfullscreen:true,
						player:'flv'
				    },
				    vars: {
				        file:'/liquido_medialib/'+item.id+'/'+item.id+'.flv',
						size:false,
						autostart:true
				    },
				    callBacks: {
				        //load: myOnloadFunc
				    }
				});
				break;
			case 'mp3':
				var obj = new Swiff('/liquido/modules/flvplayer/player.swf', {
				    id: 'movie',
				    width: 480,
				    height: 350,
					container:_this.view,
				    params: {
				        wmode: 'opaque',
				        bgcolor: '#FFF'
				    },
				    vars: {
				        file:'/liquido_medialib/'+item.id+'/'+item.id+'.mp3',
						size:false,
						autostart:true
				    },
				    callBacks: {
				        //load: myOnloadFunc
				    }
				});
				break;
			default:
			
				break;
		}		
	},
	
	// returns an item from the childs array
	$i:function(id) {
		var item = false;
		this.childs.each(function(e,i) {
			if(e.id == id) {
				item = e;
				item.index = i;
			}
		});
		return item;
	},
	openGallerybrowser:function() {
		if (this.browser) {
			this.browser.open();
		}
	},
	
	
	/** selected a gallery in compose mode */
	setGallery:function() {
		var setid = this.browser.current;
		var _this = this;
		this.browser.close();
		this.gallery = setid;
		
		this.request('setFolder='+setid+"&obj="+this.id, function(res) {
			var res = JSON.decode(res);
			$(_this.id+'_settings').getElement('.gal_name').innerHTML = res.data.name;
			$('ss_list_'+_this.id).set('html', res.html).setStyle('display', 'block').fade('in');
		});
		
	},
	
	updateThumblist:function (num) {
		var number = typeof num != 'undefined' ? num : "";
		var _this = this;
		this.request('setFolder='+this.gallery+"&obj="+_this.id+"&number="+number, function(res) {
			var res = JSON.decode(res);
			$(_this.id+'_settings').getElement('.gal_name').innerHTML = res.data.name;
			$('ss_list_'+_this.id).innerHTML = res.html;
		});
	},
	
	request:function(params,callback) {
		var r = new Request({
			url:this.connector,
			method: 'post',
			data:params,
			onFailure:alert,
			onComplete: function(res, text){
				var regex = new RegExp("^error:*");
				
				if (res == 'logout') {
					top.location.href = 'index.php';
					
				}
				else 
					if (regex.exec(res)) {
						alert(res);
						
					}
					else {
						if ($type(callback) == 'function') {
							callback(res, text);
						}
					}
			}
		}).send();
	}
});
