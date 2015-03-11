<?php
	 
	header("Content-type: text/html; charset=UTF-8");
	error_reporting(E_PARSE);
	//error_reporting(E_ALL);
	if (0 > version_compare(PHP_VERSION, '5')) {
		die('This file was generated for PHP 5');
	}
	
	$docroot = dirname(dirname(dirname(__FILE__)));
	
	if(isset($_GET['reset'])) {
		session_start();
		unset($_SESSION);
		session_destroy();
	}
	
	
	// get the session started
	session_start();
	
	// JSON wrapper - if not supported natively, create functions
	if(!function_exists('json_encode')) {
		require_once(dirname(__FILE__)."/class_json.php");
		function json_encode($obj) {
			$json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
			return $json->encode($obj);
		}
		
		function json_decode($str) {
			$json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
			return $json->decode($str);
		}
	}

/*
	if(!$auth_noredirect && !$_SESSION['user']) {
		?>
		<script type="text/javascript">
		top.location.href='/liquido/';
		</script>			
		<?php 
		die();
	}
*/	
	// used to create empty objects due to phps lack of object type
	class emptyClass { }
	require($docroot."/liquido_config/cfg_general.inc.php");
	require($docroot."/liquido_config/cfg_mysql.inc.php");
	require_once($docroot."/liquido/lib/class_settings.php");
	require_once($docroot."/liquido/lib/class_css.php");
	require_once($docroot."/liquido/lib/class_sprite.php");
	require_once($docroot."/liquido/lib/class_node.php");
	require_once($docroot."/liquido/lib/class_block.php");
	
	function __autoload($name) {
		
		$autoload_rules = array(
			'*ado' => '/liquido/lib/adodb/drivers/adodb-mysql.inc.php',
			'smarty' => '/liquido/lib/smarty/Smarty.class.php',
			'kis' => '/mikos/libs/class.KIS.php',
			'cpis' => '/mikos/libs/class.CPIS.php',
			'*json' => '/liquido/lib/class_json.php',
			'*pear' => false
		);
	
		$inc = dirname(dirname(dirname(__FILE__)));
		$name = strtolower($name);

		
		if(isset($autoload_rules[$name])) {
			require_once $inc.$autoload_rules[$name];
			return;
		}
		
		// if the script wasnt exited by a rule, try to find the class by ereg
		foreach($autoload_rules as $rule => $include) {
			if(substr($rule,0,1) == '*') {
				if(ereg(substr($rule, 1), $name)) {
					if($include) require_once($inc.$include);
					return;
				}
			}
		}
		
		// if the script wasnt exited by a rule, try to find the class in the libs dir
		require (dirname(__FILE__).'/class_'.$name.'.php');
		
		if (!class_exists($name, false)) {
			eval('class ' . $name . ' { ' .
			'    public function __construct() { ' .
			'        throw new Exception("Class ' . $name . ' not found."); ' .
			'    } ' .
			'}');
		}
	}
	
	
	require_once("fnc_mysql.inc.php");
	require_once("fnc_general.inc.php");
	require_once("auth.inc.php");
	
	$auth = auth();
	$L = new Liquido();
	

	$smarty = new Smarty();
	$smarty -> compile_dir = $docroot.LIQUIDO.'/templates_c';
	$smarty -> assign("docroot",$docroot);
	$smarty -> assign("LIQUIDO",LIQUIDO);
	$smarty -> assign("user",$user);
	$smarty -> assign("thiscomp",$thiscomp);
	$smarty -> assign("PHP_SELF",$PHP_SELF);
	$smarty -> assign("SKIN",LIQUIDO."/skins/".$cfg['env']['skin']);

	 
?>