/**
 * @author flobo
 */

var Site = {
	start: function(){
		Site.titles();
	},
	titles: function(){
		var titles = $(document.body).getElements('h1,h2,h3,h4,h5');
 
		var valid_titles = titles.filter(function(elem){
			return elem.get('rel')!=='skip';
		});
 
		valid_titles.each(function(title){
 
			var text = title.get('html');
			var dimension = title.getSize();
			var styles = title.getStyles('text-align',
			                             'padding-top',
			                             'padding-bottom',
			                             'padding-left',
			                             'padding-right',
			                             'font-size','color',
			                             'padding-left',
			                             'line-height');
 
			var swf_width = dimension['x'].toInt() -
                                              ( styles['padding-left'].toInt() +
                                              styles['padding-right'].toInt() );
			var swf_height = dimension['y'].toInt() -
                                              ( styles['padding-top'].toInt() +
                                              styles['padding-bottom'].toInt() );
 
			var obj = new Swiff('/liquido/modules/swiff/vwheadline.swf', {
				width: swf_width ,
				height: swf_height ,
				container:title,
				params: {
					wmode: 'transparent'
				},
				vars: {
					txt: text,
					w: swf_width ,
					h: swf_height ,
					textalign: styles['text-align'],
					textcolor: styles['color'],
					offsetTop: styles['padding-top']
				}
			});
		})
	}
}
//window.addEvent('domready', Site.start);
