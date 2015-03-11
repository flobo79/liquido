/**
 * @author flobo
 */
var Mediabrowser = new Class({
	connector:'connector.php',
	lists:{},	// container for file lists references
	details:{},	// container for file details functions
	select:{},	// container for select item functions
	startfrom:290779,
	callbacks:{},
	current:false,	// currently selected item or folder
	previous:false, // previous clicked element
	options:[],
	
	initialize:function(options) {
		this.options = typeof options != "undefined" ? options : [];
		if(typeof Modal === 'undefined') Asset.javascript('/liquido/js/class.modal.js', {id:'modal_js'});
		Asset.css('/liquido/components/medialibrary/browser/mediabrowser.css');
		this.connector = '/liquido/components/medialibrary/browser/connector.php';
		this.defaults();
	},
	
	defaults:function() {
		var _this = this;
		/* dummy to be replaced by something more sensible by the content object */
		this.select = function(id) { alert('Datei '+id+' selektiert'); };
		this.details.picture = function(pos, id){ _this.detailsImage(pos,id); };
		this.details.folder = function(pos, id){ _this.list(pos,id); };
		this.details.file = function(pos, id){ _this.detailsFile(pos,id); };
	},
	
	open:function(options) {
		this.options = typeof options != "undefined" ? options : [];
		this.win_browser = new Modal({width:600});
		var _this = this;
		$('bu_modal_close').onclick = function() { _this.win_browser .close(); };
		$$('#window_content .loading').dispose();
		this.scroll = new Fx.Scroll('window_content', {duration: 200});	
		this.list(0, this.startfrom);
	},
	
	close:function() {
		this.win_browser.close();
	},
	
	list:function(pos, id) {
		var _this = this;
		var pos = Number(pos);
		var param = typeof this.options.type != 'undefined' ? '&type='+this.options.type : '';
		
		this.request('getList='+id+param, function(res) {
			
			var box = _this.newBox(pos,'folder');
			var list = JSON.decode(res);
			_this.currentlist = list;
			
			list.each(function(e, i) {
				new Element('div',{
					id:pos+'_'+e.id+'_'+e.mime,
					html:e.name,
					events:{
						click:function() {
							var set = this.id.split('_');
							_this.previous = _this.current;
							_this.current = set[1];
							_this.currentindex = i;
							
							if(typeof _this.details[set[2]] == 'function') {
								_this.details[set[2]](Number(set[0])+1, set[1]);
							}
						}
					}
				}).inject(box, 'bottom');
			});
			
			if(typeof _this.callbacks.list === 'function') _this.callbacks.list(box);
			new Fx.Scroll('window_content', {duration: 200}).toRight();
		});
	},
	
	detailsFile:function(pos, id, file) {
		this.detailsImage(pos, id, file);
	},
	
	detailsImage:function(pos, id, file) {
		var _this = this;
		this.request('getDetails='+id+'&template=details_picture', function(res) {
			var box = _this.newBox(pos, 'picture');
				box.setStyle('opacity', 1).adopt(new Element('div', {
				html: res,
				'class': 'details_picture'
			}));
			
			$('bu_select').onclick = function(){
				if(typeof _this.options.select == 'function') {
					_this.options.select(_this.currentlist[_this.currentindex]);
				} else {
					_this.select(id, _this.currentlist[_this.currentindex], _this);
				}
				
				_this.close();
			};
			
			new Fx.Scroll('window_content', {duration: 200}).toRight().chain(function() {  });
		});
	},
	
	
	loadDetails:function(id,callback) {
		this.request('getDetails='+id, function(res) {
			if(typeof callback === 'function') {
				callback(res);	
			}
		});	
	},
	
	newBox:function(pos,type) {
		for(x = pos; this.lists[x]; x++) { this.lists[x].dispose(); }
		
		this.lists[pos] = new Element('div',{
			id:'list'+pos,
			'class':'list '+type,
			styles:{
				left:200*Number(pos)+"px",
				opacity:0
			},
			html:''
		}).inject('window_content','bottom').fade('in');
		
		this.scroll.toRight();
		
		return this.lists[pos];
	},
	
	request:function(params,callback) {
		new Request({
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
