<?php
		
		//***  um die Datenbank anzupassen	********//*
		$dbhost = "localhost";     
		$dbname = "club";      
		$dbuser = "root";	
		$dbpass = "flobo";
		$dbprefix = "vwc";
		$driver = 'mysqli';		
												
		//definition der benutzten tabellen   !!  depricated !!
		$cfgtabletemplateschanges	= $dbprefix."_liquido_templates_changes";
		$cfgtablecontentschanges 	= $dbprefix."_liquido_contents_changes";		
		$cfgtablecontents 			= $dbprefix."_liquido_contents";
		$cfgtablecontentobjects 	= $dbprefix."_liquido_contentobjects";
		$cfgtablecontentimgs		= $dbprefix."_liquido_contentimgs";
		$cfgtablenlcontentobjects 	= $dbprefix."_liquido_nl_contentobjects";
		$cfgtablenlcontentimgs		= $dbprefix."_liquido_nl_contentimgs";
		$cfgtablenlcontents 		= $dbprefix."_liquido_nl_contents";
		$cfgtablenlareas	 		= $dbprefix."_liquido_nl_areas";
		$cfgtablenlabos	 			= $dbprefix."_liquido_nl_abos";
		$cfgtablenlabogroups		= $dbprefix."_liquido_nl_abogroups";		
		$cfgtablecomponents			= $dbprefix."_liquido_components";
		$cfgtablesceduler 			= $dbprefix."_liquido_sceduler";
		$cfgtableeditorgroups		= $dbprefix."_liquido_editorgroups";
		$cfgtableeditors 			= $dbprefix."_liquido_editors";
		$cfgtablemedialib			= $dbprefix."_liquido_medialib";
		$cfgtablesessions 			= $dbprefix."_liquido_sessions";
		$cfgtabletemplates 			= $dbprefix."_liquido_templates";
		$cfgtablecontainer			= $dbprefix."_liquido_temp_container";
		$cfgtableclasses			= $dbprefix."_liquido_temp_classes";
		$cfgtablestructures			= $dbprefix."_liquido_temp_structures";


		$cfgtable['templateschanges']	= $dbprefix."_liquido_templates_changes";
		$cfgtable['contentschanges'] 	= $dbprefix."_liquido_contents_changes";		
		$cfgtable['contents'] 			= $dbprefix."_liquido_contents";
		$cfgtable['contentobjects'] 	= $dbprefix."_liquido_contentobjects";
		$cfgtable['contentimgs']		= $dbprefix."_liquido_contentimgs";
		$cfgtable['nlcontentobjects'] 	= $dbprefix."_liquido_contentobjects";
		$cfgtable['nlcontentimgs']		= $dbprefix."_liquido_contentimgs";
		$cfgtable['nlcontents'] 		= $dbprefix."_liquido_contents";
		$cfgtable['nlareas']	 		= $dbprefix."_liquido_nl_areas";
		$cfgtable['nlabos']	 			= $dbprefix."_liquido_nl_abos";
		$cfgtable['nlabogroups']		= $dbprefix."_liquido_nl_abogroups";		
		$cfgtable['nlpublishs']	 		= $dbprefix."_liquido_nl_publishs";
		$cfgtable['nllinktracking']	 	= $dbprefix."_liquido_nl_linktracking";
		$cfgtable['nl_bounce_emails']	= $dbprefix."_liquido_nl_bounce_emails";
		$cfgtable['nl_bounce_filters']	= $dbprefix."_liquido_nl_bounce_filers";
		$cfgtable['nl_bounce_filterrules'] = $dbprefix."_liquido_nl_bounce_filterrules";
		$cfgtable['nl_bounce_where']	= $dbprefix."_liquido_nl_bounce_where";		
		$cfgtable['components']			= $dbprefix."_liquido_components";
		$cfgtable['sceduler'] 			= $dbprefix."_liquido_sceduler";
		$cfgtable['editorgroups']		= $dbprefix."_liquido_editorgroups";
		$cfgtable['editors'] 			= $dbprefix."_liquido_editors";
		$cfgtable['medialib']			= $dbprefix."_liquido_medialib";
		$cfgtable['sessions'] 			= $dbprefix."_liquido_sessions";
		$cfgtable['templates'] 			= $dbprefix."_liquido_templates";
		$cfgtable['container']			= $dbprefix."_liquido_temp_container";
		$cfgtable['classes']			= $dbprefix."_liquido_temp_classes";
		$cfgtable['structures']			= $dbprefix."_liquido_temp_structures";

		// tabellenfelder
		$cfgfields['templates'] 		= "parent,title,info,width,date,code,author";
		$cfgfields['temp_classes'] 		= "tpl,obj,title,info,date,code,p1,p2,p3,author";
		$cfgfields['temp_structures'] 	= "tpl,obj,title,info,date,code,p1,p2,p3,author";
		$cfgfields['contentobjects'] 	= "rank,parent,type,layout,text,text2,text3,text4,text5,smalltext1,smalltext2,smalltext3,link,author,date,del,contents_css";
		$cfgfields['contents'] 			= "title,rank,template,info,type,parent,del,date,author,width,locked,public,cleanURL,promoteAsRSS";
		$cfgfields['nl_contentobjects']	= "rank,parent,type,layout,text,text2,text3,text4,text5,smalltext1,smalltext2,smalltext3,link,author,date,del,contents_css";
		$cfgfields['nl_contents'] 		= "promoteAsRss,title,rank,template,info,type,parent,area,del,date,author,width,locked,public";
		$cfgfields['nl_areas'] 			= "rank,title,info,status,public,date,author,locked";
		
		// changetables
		$cfgtables['changetables'] = array("contents","nlcontents");
?>