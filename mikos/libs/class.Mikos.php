<?php

/**
 * Mikos Applikation
 *
 * @author Henrik Westphal, <hwestphal@nwmgbr.de>
 * @author Florian Bosselmann, <bosselmann@gmail.com>
 * @author Matthias Reisch <reisch@missionmedia.de>
 */

require_once dirname(__FILE__).'/adodb/adodb.inc.php';
//require_once dirname(__FILE__).'/adodb/drivers/adodb-'.LOCALDBTYPE.'.inc.php';

if(!class_exists('smarty')) require_once dirname(__FILE__).'/smarty/Smarty.class.php';
require_once dirname(__FILE__).'/class.WsdlClient.php';

class Mikos {
    // --- ATTRIBUTES ---

    /**
     * Wrapper-Objekt
     *
     * @access public
     * @var WsdlClient
     */
    public $srv = null;

    /**
     * Die vom SOAP-Server zugewiesene Session-ID. Wird durch den Konstruktor
     * und fuer weitere Funktionsaufrufe verwendet.
     *
     * @access public
     * @var string
     */
    public $sessionId = '';

    /**
     * Short description of attribute memberId
     *
     * @access public
     * @var int
     */
    public $memberId = 0;

    /**
     * Short description of attribute partnerId
     *
     * @access public
     * @var int
     */
    public $partnerId = 0;
    /**
     * Kundeninformationen die bei erfolgreichem Login vom SOAP Server
     * werden
     *
     * @access public
     * @var array
     */
    public $custInfo = array();

    /**
     * Parameter-Informationen aller vom SOAP-Server angebotenen Funktionen.
     * zum automatischen einfuegen des sessionId-Parameters benoetigt.
     *
     * @access public
     * @var array
     */
    public $functions = array();

    /**
     * Haelt fest ob der Kunde (die Mikos-Klasse) auf dem Server eingelogged
     *
     * @access public
     * @var boolean
     */
    public $loggedIn = false;

    /**
     * Container für von Mikos generierten Html Code
     * 
     * @var unknown_type
     */
    public $output = "";
    
	/**
	* stores if the server connectivity has been checked
	*/
	public $servercheck = false;
	
	
	
    /**
     * Konstruktor 
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @author Florian Bosselmann, <bosselmann@gmail.com>
     * @param string
     * @param string
     * @return void
     */
    public function Mikos ()
    {
       if (0 > version_compare(PHP_VERSION, '5')) {
			die('This file was generated for PHP 5');
		}
		
		/** connect to local database */
		$this->db = ADONewConnection(LOCALDBTYPE);
		$this->db->Connect(LOCALDBHOST, LOCALDBUSER, LOCALDBPASS, LOCALDBNAME);
		
		
		/**
		* create smarty object for template output
		* smarty delimeters are [{ }] to enable putting 
		* javascript functions in templates
		*/
		$this->smarty=new Smarty;
		$this->smarty->left_delimiter='[{';
		$this->smarty->right_delimiter='}]';
		$this->smarty->plugins_dir[0] = dirname(__FILE__).'/smarty/plugins';
		$this->smarty->template_dir = WEBPAGE_DIR.'/templates';
		$this->smarty->compile_dir = WEBPAGE_DIR.'/templates_c';
		$this->smarty->cache = false;
		$this->smarty->compile_check = true;
		$this->init = true;

		
		if(!$this->servercheck) {
			$srv = new WsdlClient();
			if($srv->connected) {
				
				// get available functions from soap server
				$this->parseWsdlFunctions($srv);
				
				/** 
				 * try to call the soap server to see if it is alive 
				 */
				try {
					$foo = $srv->client->__soapCall('loginMember', array('memberNumber' => '9999999999999'));
					$this->connected = true;
					
				} catch (SoapFault $fault) {
					$fault = split(":", $fault->faultstring);
					if(trim($fault[1]) != 'member could not be found') {
						$this->lastError = $fault->faultstring;
						$this->connected = false;
						
						echo "<!-- ".$this->lastError." -->";
		        	} else {
						$this->connected = true;
					}
				}
				
				$this->servercheck = true;
			} else {
				$this->servercheck = true;
				$this->connected = false;
			}
		}
    }
	
    
    
    /**
     * Short description of method parseWsdlFunctions
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @return void
     */
    public function parseWsdlFunctions($srv)
    {
		$types = array();
		
		$tps = $srv->client->__getTypes();
		foreach($tps as $t)
		{
			if(preg_match('#struct (\w+) {#', $t, $matches))
			{
				$typename = $matches[1];
				$types[$typename] = array();
				$tmp = explode("\n",$t);
				foreach($tmp as $row)
				{
					if(preg_match('#^ \w+ (\w+);$#', $row, $matches))
					{
						$types[$typename][] = $matches[1];
					}
				}
			}
		}
		
		$fcn = $srv->client->__getFunctions();
		foreach($fcn as $f)
		{
			if(preg_match('#\w+ (\w+)\((\w+) \$\w+\)#', $f, $matches))
			{
				$this->functions[$matches[1]] = array('params' => array_flip($types[$matches[2]]));
			}
		}
    }

    /**
     * Diese Funktion ist ein Wrapper fuer die execFunction-Funktion der
     * Hilft den sessionId-Parameter einzufuegen falls dieser nicht angegeben
     * und prueft die Server-Antwort ob die sessionId noch gueltig ist.
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param string
     * @param array
     * @return void
     */
    public function call($name, $inputvars = array())
    {
    	
		/** invoke WSDL Wrapper */
		$srv = new WsdlClient();
	
		if(!array_key_exists($name,$this->functions) && $srv->connected)
	    {
	        	trigger_error('Unknown function: '.$name,E_USER_WARNING);
				return false;
		}
				
		$pd = array_diff_key($this->functions[$name]['params'],$inputvars);
		if(count($pd) > 0) {
			if(array_key_exists('sessionId',$pd))
			{
					$inputvars['sessionId'] = $this->sessionId;
					unset($pd['sessionId']);
			}
		
			if(array_key_exists('memberId',$pd))
			{
					$inputvars['memberId'] = $this->custInfo->id;
					unset($pd['memberId']);
			}
		
			if(count($pd) > 0 && $name != 'getMvBBookingsList')
			{
					//trigger_error('Some arguments are missing: '.implode(', ',array_keys($pd)),E_USER_WARNING);
					//return false;
			}
		}
	
		$sr = $srv->execFunction($name, $inputvars);
		if ($sr) 
		{
			$this->writeProtocol($name, $inputvars, $sr, 'success');	
			return $sr;
		}
	    else
	    {
	        if (strpos($srv->lastError,'Invalid sessionId') > 0)
	        {
	        	$this->mikos_logout();
			}
		
			$errorreport = "MIKOS SERVER ERROR: (".date('l dS \of F Y h:i:s A').")
			
	method: $name
	parameter: ";
			
				ob_start();
					print_r($inputvars);
					$params = ob_get_contents();
					ob_end_clean();
				$errorreport .= $params."

	SOAP SERVER RESPONSE:
		".$srv->lastError;
		
			$this->writeProtocol($name, $inputvars, $srv->lastError, 'failure');
			
			//mail("bosselmann@gmail.com","MIKOS ERROR", $srv->lastError,"");
			mail("m.pobloth@missionmedia.de","MIKOS ERROR", $srv->lastError,"");
			//trigger_error('<!-- SOAP Error: method \''.$name.'\' '.$this->srv->lastError." -->",E_USER_WARNING);
			return false;
        }
    }

    /**
     * Meldet einen Member-User am Server an.
     *
     * @access public
     * @author Bosselmann
     * @param string
     * @param string
     * @return boolean
     */
    public function login_member ($memberNumber)
    {
        $returnValue = (bool) false;
        if($this->sessionId = $this->call('loginMember', array('memberNumber' => $memberNumber)))
		{
			$this->loggedIn = true;
			$returnValue = true;
			$this->custInfo = $this->call('CMGetCustomerDetails');
			
			// DEBUG START
			//$dump = "<pre>".print_r($this->custInfo, true)."</pre>";
			//mail("m.reisch@missionmedia.de","MIKOS DUMP", $dump, "");
			// DEBUG END
			
			if($this->custInfo) {
				$this->custInfo->lastLogin = $this->db->getRow("select * from login_protocoll where memberNumber = '".$memberNumber."' order by timestamp desc LIMIT 1");
				
				$this->loginWriteProtocoll('kis', $this->custInfo->id, '', $memberNumber);
			}
		}
        return (bool) $returnValue;
    }
	
    /**
     * Meldet einen Partner-User am Server an ( Zur Identifikation dient die PartnerBNR ).
     *
     * @access public
     * @author Mathias Reisch, <m.reisch@missionmedia.de>
     * @param string
     * @param string
     * @return boolean
     */
    public function login_partner ( $bnr, $partnerId )
    {
		$returnValue = (bool) false;
        if($this->sessionId = $this->call('loginDealer', array('partnerBnr' => $bnr)))
		{
    		$this->loggedIn = true;
			$returnValue = true;
			$this->custInfo = $this->call('getPartnerById', array('sessionId' => $this->sessionId, 'id' => $partnerId ));
			
			if($this->custInfo) {
				$this->custInfo->lastLogin = $this->db->getRow("select * from login_protocoll where ID = '".$this->custInfo->id."' and BRN = '".$BNR."' LIMIT 1");
				$this->loginWriteProtocoll('cpis', $partnerId, $bnr, '');
			}
			
		} else {
			echo "login failed :-(";
		}
        return (bool) $returnValue;
    }


    /**
     * Meldet einen User am Server ab (es wird nur die Session-ID geloescht).
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @return void
     */
    public function mikos_logout()
    {
        $this->sessionId = '';
        $this->memberId = 0;
        $this->loggedIn = false;
        $this->custInfo = array();
    }

    /**
     * Prueft $this->loggedIn, wenn false wird per Header-Redirect auf die
     * verwiesen
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @return void
     */
    public function requireLogin()
    {
        if($this->loggedIn == false)
        {
			header('Location: '.URL_LOGIN);
		}
    }
	/**
     * Schreibt einen mikos call in eine datenbank zur analyse
     *
     * @access public
     * @author Florian B.
     * @return void
     */

	private function writeProtocol($name, $inputvars, $return, $result) {
		$report = array();
		$report['callname'] = $name;

		ob_start();
		
		$report['callparams'] = is_object($inputvars) ? $this->implode_with_keys('; ', $this->parseObjectList($inputvars)) : $this->implode_with_keys('; ', $inputvars);
		$report['type'] = $this->type;
		if(is_array($this->custInfo)) $report['custInfo'] = $this->implode_with_keys('; ', $this->custInfo);
		$report['member'] = $this->custInfo->localID;
		$report['result'] = $result;
		$report['datum'] = microtime();
		$report['return'] = is_object($return) ? $this->implode_with_keys('; ', $return) : $return;
		
		$sql = "insert into protocol set ".$this->implode_with_keys(', ',$report,"'");
		$this->db->execute($sql);
	}
	
	private function implode_with_keys($glue, $array, $valwrap='') {
       foreach($array AS $key => $value) {
   			$return = "`".$key."`=";
		
			if(is_array($value)) {
				//$return .= $this->implode_with_keys("; ",$value);
				
			} elseif (is_object($value)) {
				ob_start();
				print_r($value);
				$return .= ob_get_contents();
				ob_end_clean();
				
			} else {
				$return .= $valwrap.$value.$valwrap;
			}
			$ret[] = $return;
       	}
		
       	if(is_array($ret)) return implode($glue, $ret);
    }

	public function parseObjectList($result) {
		$list = array();
		$o = isset($result->return) ? $result->return : $result;
	
		while(is_object($o))
		{
		  	$next = $o->next;
		  	unset($o->next);
		  	$o->debug = $this->createDebugOutput($o);
		  	$list[] = $o;
		  	$o = $next;
		}
		
		return $list;
	}
	
    /**
    * auto detects and converts a string to utf8
    *
    * since mikos does something strange with strings we
    * try to get them right again.
    */	
	public function checkEncoding($str) {
	   return mb_convert_encoding($str, "UTF-8", mb_detect_encoding($str));
	}

    /**
    * an alternate method to detect
    * wheter a string is utf8 or not
    * !!! INSERTED HERE FOR LATER USE !!!
    */
    function is_utf8($string)
    {
        // From http://w3.org/International/questions/qa-forms-utf-8.html
        return preg_match('%^(?:
        [\x09\x0A\x0D\x20-\x7E] # ASCII
        | [\xC2-\xDF][\x80-\xBF] # non-overlong 2-byte
        | \xE0[\xA0-\xBF][\x80-\xBF] # excluding overlongs
        | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
        | \xED[\x80-\x9F][\x80-\xBF] # excluding surrogates
        | \xF0[\x90-\xBF][\x80-\xBF]{2} # planes 1-3
        | [\xF1-\xF3][\x80-\xBF]{3} # planes 4-15
        | \xF4[\x80-\x8F][\x80-\xBF]{2} # plane 16
        )*$%xs', $string);
    }
    
	/**
	 * This method writes login statistics
	 * 
	 * @return nothing
	 * @param $from Object either kis or cpis
	 * @param $UID Object[optional]
	 * @param $MBR Object[optional]
	 */
	private function loginWriteProtocoll($type, $UID = 0, $BNR=0, $memberNumber=0) {
		$sql = "insert into login_protocoll set 
			`timestamp` = ".time().",
			`type` = '$type', 
			`ID` = '$UID',
			`BNR` = '$BNR', 
			`memberNumber` = '$memberNumber',
			`sessid` = '".session_id()."'";
		$this->db->execute($sql);
	}
	
	
} /* end of class Mikos */

?>
