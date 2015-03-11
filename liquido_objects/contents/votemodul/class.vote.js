/**
 * @author flobo
 */

var Vote = new Class({
	id:false,
	connector:'/liquido/modules/votemodul/module.inc.php';
	initialize:function(id) {
			id:id,
			saveVote:function() {
				// send vote to server
				var value = '';
				var _this = this;
				$(this.id+'_vote_answers').getElements('input[name=a'+this.id+']').each(function(i){
					if (i.checked) {
						value = i.value;
					}
				});
				L.request('module:votemodul:setVote',{vote:value,id:this.id},function(res) {
					var r = JSON.decode(res);
					for(e in r.av) {
						$(_this.id+"_"+e.substr(1)).fade('out');
					};
					$('<?php echo $result['id'] ?>_vote_result').fade('out');
					setTimeout(function() {
						for(e in r.av) {
							$(_this.id+"_"+e.substr(1)).set('html','<b>'+r.av[e]+'%</b>').fade('in');
						};
						$('<?php echo $result['id'] ?>_vote_result').set('html','Vielen Dank für Ihre Stimmenabgabe.<br />Insgesamt wurde '+r.sum+' abgestimmt.<br>').fade('in');
						
					},250);
					
					Cookie.write('vote<?php echo $result['id'] ?>','1');
				});
				// update html
			},
			
			init:function () {
				if (cookie) {
					var _this = this;
					L.request('module:votemodul:getStat',{id:this.id},function(res) {
						var r = JSON.decode(res);
						for(e in r.av) {
							$(_this.id+"_"+e.substr(1)).set('html','<b>'+r.av[e]+'%</b>');
						};
						$('<?php echo $result['id'] ?>_vote_result').set('html','Sie haben bereits abgestimmt.<br />Stimmen insgesamt: '+r.sum+'.<br>');	
						$('<?php echo $result['id'] ?>_vote_answers').style.display='block';
						$('<?php echo $result['id'] ?>_vote_result').style.display='block';
					});
				} else {
					$('<?php echo $result['id'] ?>_vote_result').style.display='block';
					$('<?php echo $result['id'] ?>_vote_answers').style.display='block';
				}
			}
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
})