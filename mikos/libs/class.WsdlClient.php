<?php

/**
 * Wrapper fuer den PEAR::SOAP Client
 *
 * @author Henrik Westphal, <hwestphal@nwmgbr.de>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}
/**
 * Wrapper fuer den PEAR::SOAP Client
 *
 * @access public
 * @author Henrik Westphal, <hwestphal@nwmgbr.de>
 */
class WsdlClient
{
    // --- ATTRIBUTES ---
    /**
     * PEAR::SOAP Client Objekt
     *
     * @access public
     * @var object
     */
    public $client = null;

    /**
     * Optionen fuer den PEAR::SOAP-Client
     *
     * @access public
     * @var array
     */
    public $options = array();

    /**
     * Die letzte aufgetretene Fehlermeldung. Wird durch die Funktion
     * gesetzt falls ein Fehler bei der Verbindung mit dem SOAP Server auftritt.
     *
     * @access public
     * @var string
     */
    public $lastError = '';

    
    public $connected = false;
     
    /**
     * Konstruktor der Klasse
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @return void
     */ 
    public function WsdlClient()
    {
    	try
        {
			$this->client = @new SoapClient(SOAPWSDLURL,array(
				'style' => SOAP_DOCUMENT,
				'use' => SOAP_LITERAL,
				'connection_timeout' => 1,
				'trace' => true,
				'exceptions' => true,
				'local_cert' => dirname(__FILE__)."/client.pem",
			    'passphrase' => 'casawebservice'
			));
			
			$this->connected = true;
        }
        catch (SoapFault $fault)
        {
    		//$err_str = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
			//mail('kis@missionmedia.de', 'soap error', $err_str,"from: no-return@vw-club.de <www.vw-club.de>\r\n");
		
    		//trigger_error($err_str, E_USER_WARNING);
		}
    }
    
    
    /**
     * Diese Funktion fuehrt die entfernten Methoden des SOAP Servers aus und
     * die Antwort auf Fehler. Als Parameter muss der Name der Funktion sowie
     * Funktionsargumente in Form eines Arrays angegeben werden. Das Ergebnis
     * haengt vom Typ des SOAP-Ergebnisses ab (String, Array, false).
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @param string
     * @param array
     * @return object
     */
    public function execFunction($name, $inputvars)
    {
        
		
		$returnValue = null;
        $returnValue = false;
		
        if(!is_callable(array($this->client,$name)))
        {
    		$err_str = "SOAP Error: unknown function or function not callable: $name";
			mail('m.pobloth@missionmedia.de', 'soap error', $err_str,"from: no-return@vw-club.de <www.vw-club.de>\r\n");
		
    		//trigger_error($err_str, E_USER_WARNING);
		}
		
		
        try  {
	        $r = $this->client->$name($inputvars);
	        if($r->return) {
    		    $returnValue = $r->return;
			}
			elseif($r->return == null)
			{
			    $this->lastError = 'Leeres Ergebnis';
			}
		}
		
		catch (SoapFault $fault) {
			
			ob_start();
			print_r($inputvars);
			$vars = ob_get_contents();
			ob_end_clean();
			
			$err_str = "SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring}), variables: ".$vars;
			mail('m.pobloth@missionmedia.de', 'soap error', $err_str,"from: no-return@vw-club.de <www.vw-club.de>\r\n");
			
			//trigger_error($err_str, E_USER_WARNING);
			$this->lastError = $fault->faultstring;
			$this->connected = false;
		}
				
        return $returnValue;
    }

    /**
     * Short description of method __wakeup
     *
     * @access public
     * @author Henrik Westphal, <hwestphal@nwmgbr.de>
     * @return void
     */
    public function __wakeup()
    {
        // section -64--88-0-106-2491d050:10f14453553:-7ff5 begin
        $this->WsdlClient();
        // section -64--88-0-106-2491d050:10f14453553:-7ff5 end
    }

} /* end of class WsdlClient */

?>
