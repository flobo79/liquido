<?php

/**
 * Project:     VW Club Community Modul
 * File:        class.CPIS.php
 *
 * This library is meant to be a universal Connector to the MIKOS partner
 * Database of Volkswagen and provides functions 
 *
 *
 * @link http://www.vw-club.de/
 * @copyright 2007 mission media
 * @author Mathias Reisch <m.reisch@missionmedia.de>, 
 * @author Florian Bosselmann <flobo@ultradigital.de>
 * @package Cpis
 * @version 1.0
 */
 

header('content-type: text/html; charset=utf-8');
require_once (dirname(dirname(__FILE__))."/config.inc.php");	
require_once (dirname(__FILE__).'/class.Mikos.php');
require_once (dirname(__FILE__)."/adodb/adodb.inc.php");
//if(!class_exists('Smarty')) require_once (dirname(__FILE__)."/smarty/Smarty.class.php");

/**
 * 
 * @package CPIS
 */
class CPIS extends Mikos {

	/** this var is used by the inheriting class to identify itself */
	public $type = "CPIS";

    /**
     * The class constructor.
     */
	public function CPIS () {
		// construct Mikos
		$this->Mikos();
		
		// path to this class
		$this->classpath = dirname(__FILE__);

		// if user is logged in load his customer info into smarty
		if($this->loggedIn) {
			$this->smarty->assign('custInfo',$cpis->custInfo);
		}
		
		if(isset($_GET['cpis']) && $_GET['cpis'] == 'logout') {
			$this->doLogout();
		}
		
		// if cpis recieves a do[action] try to execute it
		if($_POST && array_key_exists('cpis_action',$_POST) && method_exists($cpis,"do".$_POST['cpis_action'])) {
			$this->$_POST['cpis_action']($_POST);
		}
	}
	
	/**
	* find user account in local database and uses its information to connect
	* to Mikos Database.
	*
	* @param string $username the username of the customer
	* @param string $password the password of the customer
	* @author Mathias Reisch <m.reisch@missionmedia.de>, Florian Bosselmann <flobo@ultradigital.de>
	*/
	
	public function doLogin ($data) {
		$output = array();
		
		if($data['username'] != "" && $data['password'] != "") {
			
			// find user in local database
			$query = "select  *  from  cpis_partner where username = '".$this->quote_smart(($data['username']))."' LIMIT 1";
			$user = $this->db->getRow($query);
			
			if($user['ID']) {
				// if account is blocked
				if($user['timeOut'] > time()) {
					$output[] = "$('output').innerHTML='Benutzerkonto gesperrt für ".(($user['timeOut'] - time()) / 60)." Minuten.';";
				}
				
				// check if user account is active
				elseif ($user['status'] == 0)
				{
					$output[] = "$('output').innerHTML='Dieses Konto ist deaktiviert.';";
					$output[] = "$('password').setValue = '';";
					$output[] = "$('output').addClass('response_error');";
				}
				
				#
				# check if password is correct
				#
				elseif ($user['password'] != md5($data['password'])) 
				{
					// if user exeeded allowed login fails - block user for 
					if($user['failedLogins'] == (LOGIN_ATTEMPTS-1)) {
						$this->db->execute("update cpis_partner set failedLogins = 0, `timeOut` = '".(time()+LOGIN_TIMEOUT)."' where `ID` = '".$user['ID']."' LIMIT 1");
						$output[] = "$('output').innerHTML='Fehler: Zu viele Fehlversuche. Dieser Zugang wurde für ".(LOGIN_TIMEOUT / 60)." Minuten gesperrt.';";
						
					} else {
						// write fail to database
						$this->db->execute("update `cpis_partner` set `failedLogins` = `failedLogins`+1 where`ID` = '".$user['ID']."' LIMIT 1");
						
						$output[] = "$('output').innerHTML='Passwort falsch';";
						$output[] = "$('password').setValue = '';";
						$output[] = "$('output').addClass('response_error');";
					}	
				} 
				
				// try to login to MIKOS Database
				else 
				{
					if($this->login_partner ($user['partnerBNR'], $user['partnerID'])) 
					{
						if($this->custInfo->isValid) 
						{
							if($this->custInfo->isActive) 
							{
								// append local user data to mikos user data in session
								$this->custInfo->localID = $user['ID'];
								$this->custInfo->partnerBNR = $user['partnerBNR'];
								$this->custInfo->webStatus = $user['status'];
								if(!$this->custInfo->email) { $this->custInfo->email =$this->checkEncoding($user['email']); }
								$this->custInfo->webSite =$this->checkEncoding($user['webSite']);
							
								// load employees from mikos and local database
								$this->myEmployees = $this->parseObjectList($this->call('getPaPersonListByPartner',array('partnerId'=>$this->custInfo->id))); 
								foreach($this->myEmployees as $k => $data) 
								{
									// check if user exists in local database
									$localentry = $this->db->getRow("select * from `cpis_partner` where `paMemberId` = '".$data->id."' LIMIT 1");
									if($localentry['ID']) 
									{
										$this->myEmployees[$k]->secretQuestion = $localentry['secretQuestion'];
										$this->myEmployees[$k]->secretAnswer = $localentry['secretAnswer'];
										$this->myEmployees[$k]->username = $localentry['username'];
										$this->myEmployees[$k]->password = $localentry['password'];
										$this->myEmployees[$k]->status = $localentry['status'];
									}
									
									// otherwise create account
									else 
									{
										$this->db->query("insert into `cpis_partner` set 
											`partnerID` = '".$this->custInfo->id."',
											`paMemberId` = '".$data->id."',
											`gender` = '".$data->gender."',
											`title` = '".$data->fronttitle."',
											`firstName` = '".$data->firstname."',
											`lastName` = '".$data->surname."',
											`email` = '".$user->email."',
											`webSite` = '".$user->webSite."',
											`position` = '".$data->pasttitle."',
											`partnerBNR` = '".$this->custInfo->partnerBNR."'
										");
									}
								}
								
								// reset failed login attempts
								$this->db->execute("update cpis_partner set failedLogins = 0, `timeOut` = '0' where `ID` = '".$this->custInfo->localID."' LIMIT 1");
								
								// tell frontend what's happening
								$output[] = "$('output').innerHTML='Login erfolgreich, bitte warten...';";
								$output[] = "document.location.href='".URL_CPIS_START."';";
								
									
							} else {
								// send error message to provider
								$output[] = "$('output').innerHTML='Benutzerkonto nicht aktiv';";
								$output[] = "$('output').addClass('response_error');";
								$this->mikos_logout();
							} 
						
						} else {
							// send error message to provider
							$output[] = "$('output').innerHTML='Benutzerkonto nicht aktiv';";
							$output[] = "$('output').addClass('response_error');";
							$this->mikos_logout();
						}
						
					} else {
					
						// send error message to provider
						$output[] = "$('output').innerHTML='MIKOS: Benutzerdaten nicht synchron';";
						$output[] = "$('output').addClass('response_error');";
						//mail(MAILTO_ERROR, 'mikos error', 'Benutzer versuchte sich einzuloggen, aber Benutzerdaten waren nicht synchron','');
						
					}
				}
			}
			else
			{
				$output[] = "$('output').innerHTML='Benutzerkonto nicht gefunden';";
				$output[] = "$('output').addClass('response_error');";
			}
			
		}
		else 
		{
			$output[] = "$('output').innerHTML='Bitte Benutzername und Passwort eingeben';";
			$output[] = "$('output').addClass('response_error');";
		}
		
		$this->jsreturn($output);
	}
	
	
	
	/**
	* ends a user session and redirects user to login page
	* defined by constant URL_CPIS_LOGIN in config file
	* 
	* @author Florian Bosselmann, <flobo@ultradigital.de>
	* @access public
	*/
	public function doLogout () {
		// keeps the session data, but logs out 
		
		unset($_GET, $_POST);
		$this->mikos_logout();
		header("location:".URL_CPIS_LOGIN);
	}
	
	/**
	* recieves updated user details and save them to mikos
	*
	* @access public
	* @parameter $data expects Array containing child Array 'custInfo' containing user data
 	* @author Florian Bosselmann, <flobo@ultradigital.de>
	*/
	public function doEditMyData($data) {
		$report[] = "report for function doEditMyData";
		$output = array();
		$mandatory = split(",",STR_PARTNERDATA_MANDATORY);
		foreach($mandatory as $field)
		{
			if(!$data[$field]) {
				$output[] = "$('".$field."').addClass('redBorder');";
			}
		}
		
		if (!(ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-ZäöüÄÖÜ0-9-]+\.)+([a-zA-Z]{2,4})$",$data['email'] ) ) ) {
			$output[] = "$('email').addClass('redBorder').title='e-Mail :: ".REG_MSG_EMAIL_SYNTAX."';";
		}
		
		if($data['newpassword']) {
			$oldpass = $this->db->getRow("select password from cpis_partner where ID = ".$this->custInfo->localID." LIMIT 1");
			if(md5($data['oldpassword']) != $oldpass['password']) {
				$output[] = "$('oldpassword').addClass('redBorder');";
			} elseif ($data['newpassword'] == "") {
				$output[] = "$('newpassword').addClass('redBorder');";
			} elseif ($data['newpassword'] != $data['newpassword2']) {
				$output[] = "$('newpassword2').addClass('redBorder');";
			} else {
				$setnewpassword = true;
			}
		}
		
		if($output[0]) 
		{
			$output[] = "$('output').innerHTML='Bitte überprüfen Sie die rot markierten Felder';";
			$output[] = "$('output').addClass('response_error');";
			
		} 
		else 
		{
			// check if www address has a http://
			if($data['webSite'] && !ereg("^http://", $data['webSite'])) {
				$data['webSite'] = "http://".$data['webSite'];
			}
			$data['webSite'] = ($data['webSite']);
			
			$set = '';
			
			$changes = array();
			// append all known attributes to custInfo Object
			foreach($this->custInfo as $key => $value) 
			{
				// check for a changed property (needed for mail further down the source code)
				if( $this->custInfo->$key != $data[$key] )
				{
					$changes[$key] = $data[$key];
				}

				if(array_key_exists($key, $data)) 
				{ 
					$this->custInfo->$key = ($data[$key]);
					$output[] = "$('d_$key').innerHTML='$data[$key]'; ";
					$set .= ", ".$this->quote_smart($key)." = '".$this->quote_smart($data[$key])."'";
				}
			}
			
			// update local database
			if($setnewpassword) {
				$set .= ", password = '".md5($data['newpassword'])."'";
			}
			
			// add email address to local db
			$set .= ", `email` = '".$this->quote_smart($data['email'])."'";
			
			$sql = "update cpis_partner set ID = ".$this->custInfo->localID." $set where ID = ".$this->custInfo->localID." LIMIT 1";
			$this->db->execute($sql);
			$report[] = $sql;
			// create packet for sending to server
			
			$stripvars = array('localID','webStatus','partnerBNR');
			$packet = clone $this->custInfo;
			foreach($stripvars as $varname) 	{
				unset($packet->$varname);
			}
			
			$packet->isDtaBlock = $packet->isDtaBlock == '1' ? true : false;
			
			// send data to mikos server
			if($this->call('updatePartnerById',array('paMemberDetails' => $packet))) 
			{

				// send information mail to CSC
				$mailtext  = "Der Händler mit der BNR ".$this->custInfo->partnerBNR." hat seine Daten wie folgt geändert:\n\n";
				foreach( $changes as $key => $value)
				{
					$mailtext .= $key." = ".$value."\n";
				}
				$mailtext .= "\nBitte überprüfen Sie die Daten auf Logik und Format.\n";
				
				// send mail if we are on web7
				if(LIVE) {
					$to = 'clubpartnerbetreuung@volkswagen-club.de';
					$subject = ("Der Händler ".$this->custInfo->partnerBNR." hat seine Daten geändert");
					$message = ($mailtext);
					$from = "no-reply@vw-club.de\n Content-Type: text/plain; charset=UTF-8\n";
					
					require_once(dirname(dirname(dirname(__FILE__))).'/liquido/lib/helper/PGPMail.php');
					$mail = new PGPMail($to, $subject,$message , $from, PGP_KEY_PARTNERBETREUUNG);
					$mail->send();
					
					mail($to, $subject, $message, 'From: '.$from);
				}

				// if sending was successfull create a javascript object of the new data
				$jsObject = '{  ';
                foreach($this->custInfo as $field => $value) {
             	   $jsObject .= $field.":'".($value)."',";
                }
	           	$jsObject = substr($jsObject,0,-1).'};';
	            $output[] = "mydatastr=".$jsObject;

				$output[] = "$('output').innerHTML='Daten gespeichert.';";
				$output[] = "$('d_webSite').innerHTML='<a href=\"$data[webSite]\" target=\"_blank\">".($data['webSite'])."</a>'; ";
				$output[] = "$('d_email').innerHTML='<a href=\"mailto:$data[email]\">$data[email]</a>'; ";
				$output[] = "myInt = setInterval(function() { $('Edit').style.display='none'; clearInterval(myInt); },1000);  ";

			} 
			else 
			{	
				$jsObject = '{  ';
                foreach($this->custInfo as $field => $value) {
             	   $jsObject .= $field.":'".($value)."',";
                }
	           	$jsObject = substr($jsObject,0,-1).'};';
	            $output[] = "mydatastr=".$jsObject;
				$output[] = "$('output').innerHTML='Fehler beim Aktualisieren Ihrer Kundendaten. (mikos)';";
				$output[] = "$('output').addClass('response_error');";
			}
		}

		foreach($report as $v) {
			$mailtext .= $v."\n";
		}
		
		$this->jsreturn($output);
	}
	
	
	
	/**
	* creates a new Employer in the local database
	*
	* @access public
	* @param array $data filled with information of the worker to create
 	* @author Mathias Reisch, <m.reisch@missionmedia.de>
	*/
	
	public function doCreateEmployee ($data ) {

		// indicates whether the employee data has been entered completely or not
		$mandatory = split(",",STR_EMPLOYEE_MANDATORY);
		foreach($mandatory as $field) {
			if(!$data[$field]) $output[] = "$('d_".$field."').addClass('redBorder');";
		}
		
		if($data['password'] != $data['password2']) { $output[] = "$('d_password2').toggleClass('redBorder');"; }
		
		if (!(ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Zäöü0-9-]+\.)+([a-zA-Z]{2,4})$",$data['email'] ) ) ) {
			$output[] = "$('d_email').addClass('redBorder').title='e-Mail :: ".REG_MSG_EMAIL_SYNTAX."';";
		}
		
		// check username
		if($data['username']) {
			$test = $this->db->getRow("select * from cpis_partner where username = '".$this->quote_smart($data['username'])."' limit 1");
			if($test['ID']) 
			{
				$output[] = "$('d_username').toggleClass('redBorder');";
				$output[] = "$('output').innerHTML += 'Bitte verwenden Sie einen anderen Benutzernamen.';"; 
			}
			unset($test);
		}
		
		// gender is stored as bool in mikos !&$$!&$
		$data['gender']--;
		
		// if everything went well, proceed
		if( !$output[0] ) {
			$packet = $data;

			$localvars = array('username','password','secretQuestion','secretAnswer','status','debug','password2','cpis_action','class','id');
			foreach($localvars as $v) {
				unset($packet[$v]);
			}
			
			$packet['salutation'] = $packet['gender'] == 0 ? 'Frau' : 'Herr';
			$packet['partnerId'] = $this->custInfo->id;
			$packet['mandantId'] = "1"; //$this->custInfo->mandantId;
			
			// send to mikos
			if($this->call('insertPaPersonDetail',array('paPersonDetail' => $packet))) {
				// reload employees list
				$this->myEmployees = $this->parseObjectList($this->call('getPaPersonListByPartner',array('partnerId'=>$this->custInfo->id))); 
				
				// ammend information from local db
				foreach($this->myEmployees as $k => $entry) {
					$localentry = $this->db->getRow("select * from `cpis_partner` where paMemberId = '".$entry->id."' LIMIT 1");
					
					if(!$localentry['ID']) {
						echo $query = "INSERT INTO
							cpis_partner
						SET
							`partnerId` = '".$this->custInfo->id."',
							`gender` = '".$this->quote_smart($data['gender'])."',
							`paMemberId` = '".$this->quote_smart($entry->id)."',
							`title` = '".$this->quote_smart($data['title'])."',
							`firstName` = '".$this->quote_smart($data['firstname'])."',
							`lastName` = '".$this->quote_smart($data['surname'])."',
							`username` = '".$this->quote_smart($data['username'])."',
							`password` = '".$this->quote_smart(md5($data['password']))."',
							`position` = '".$this->quote_smart($data['position'])."',
							`phoneNumber` = '".$this->quote_smart($data['phoneNumber'])."',
							`mobileNumber` = '".$this->quote_smart($data['mobileNumber'])."',
							`email` = '".$this->quote_smart($data['email'])."',
							`showDetails` = '".$this->quote_smart($data['showDetails'])."',
							`status` = '".$this->quote_smart($data['status'])."',
							`isActive` = '1',
							 secretQuestion = '".$this->quote_smart($data['secretQuestion'])."',
						     secretAnswer = '".$this->quote_smart($data['secretAnswer'])."',
							`partnerBNR` = '".$this->custInfo->partnerBNR."'";

						// write entry to local database
						$this->db->execute($query);

						// send mail to CSC
				     $mailtext  = "Der Händler ".$this->custInfo->partnerBNR." hat folgenden Mitarbeiter im CPIS angelegt:\n\n";
				     $mailtext .= "Titel: ".$data['title']."\n";
					 $mailtext .= "Name: ".$data['surname']."\n";
				     $mailtext .= "Vorname: ".$data['firstname']."\n";
					 $mailtext .= "Benutzername: ".$data['username']."\n";
					 $mailtext .= "Position: ".$data['position']."\n";
					 $mailtext .= "E-Mail: ".$data['email']."\n";
					 $mailtext .= "Telefon: ".$data['phoneNumber']."\n";
					 $mailtext .= "Mobilnummer: ".$data['mobileNumber']."\n";
					 $mailtext .= "FAX: ".$data['fax']."\n";
				     $mailtext .= "Geheime Frage: ".$data['secretQuestion']."\n";
					 $mailtext .= "Geheime Antwort: ".$data['secretAnswer']."\n";
					 $mailtext .= "Status: ".$data['status']."\n";
			     
				     // send mail only if we are on web7
					 if(LIVE) {
					 	mail ("clubpartnerbetreuung@volkswagen-club.de",("Mitarbeiter angelegt von Händler ".$this->custInfo->partnerBNR), ($mailtext),"From: no-reply@vw-club.de\n Content-Type: text/plain; charset=UTF-8\n");
					 }
					 
						// and once again
						$localentry = $this->db->getRow("select * from `cpis_partner` where paMemberId = '".$entry->id."' LIMIT 1");
					}
					
					$this->myEmployees[$k]->secretQuestion = $localentry['secretQuestion'];
					$this->myEmployees[$k]->secretAnswer = $localentry['secretAnswer'];
					$this->myEmployees[$k]->username = $localentry['username'];
					$this->myEmployees[$k]->password = $localentry['password'];
					$this->myEmployees[$k]->status = $localentry['status'];
				}
				
				$this->smarty->assign('myEmployees',$this->myEmployees);
				$newList = $this->smarty->fetch ("paMyEmployeesList.html");
			  	$newList = str_replace(array("\n","\r"), array(chr(13),"","",""), $newList);	// remove all returns for javascript
				$output[] = "$('myEmployees').innerHTML = '$newList'; ";
			
				$jsObject = $this->getMyEmployeesGetJsObject();
				$output[] = "myEmployeesList=".$jsObject;
				$output[] = "myEmployeesApplyActions(); ";	// to activate row buttons
				$output[] = "myInt = setInterval(function() { $('editEmployee').style.display='none'; $('mikos_editEmployee').reset(); clearInterval(myInt); },1000);  ";
			}
			
		} else {
			$output[] = "$('output').addClass('response_error'); ";
			$output[] = "$('output').innerHTML += 'Bitte korrigieren Sie die rot markierten Felder';";
		}
		
		// output notice
		$this->jsreturn($output);
	}
	
	function getMyEmployeesGetJsObject() {
		$employeeFields = array('gender','status','id','fronttitle','firstname','surname','pasttitle','phone','mobile','fax','email','username','password','secretQuestion','secretAnswer');
		$jsObject = '{  ';
		foreach($this->myEmployees as $employee) {
			$jsObject .= "employee".$employee->id.":{";
			foreach($employeeFields as $field) {
				$jsObject .= $field.":'".$employee->$field."',";
			}
			$jsObject = substr($jsObject,0,-1)."},";
		}
		$jsObject = substr($jsObject,0,-1).'};';
		return $jsObject;
	}

	/*
	* output buffer availdable with $_SESSION['cpis']->display();
	*
	* @parameter $data list of parameters
	*/
	public function doEditEmployee($data) {

		$mandatory = split(",",STR_EMPLOYEE_MANDATORY);
		foreach($mandatory as $field) {
			if(!$data[$field]) $output[] = "$('d_".$field."').toggleClass('redBorder');";
		}
		
		if($data['password'] && ($data['password'] != $data['password2'])) { $output[] = "$('d_password2').toggleClass('redBorder');"; }
		
		// check username
		if($data['username']) {
			$test = $this->db->getRow("select * from cpis_partner where username = '".$this->quote_smart($data['username'])."' and paMemberId != '".$data['id']."' limit 1");
			if($test['ID']) {
				$output[] = "$('d_username').toggleClass('redBorder');";
				$output[] = "$('output').innerHTML += 'Bitte verwenden Sie einen anderen Benutzernamen.';"; 
			}
		}
		// gender is stored as bool in mikos !&$$!&$
		$data['gender']--;
		
		
		// if everything went well, proceed
		if(!$output[0] ) {
				foreach ($this->myEmployees as $e => $getemp) {
				if($getemp->id == $data['id']) {
					foreach($getemp as $k => $v) {
						$this->myEmployees[$e]->$k = mb_convert_encoding($data[$k],'UTF-8','auto');
					}
					
					$packet = clone $getemp;
					break; 
				}
			}
		
			if($packet) {
				// create packet for mikos by deleting all local vars
				$localvars = array('username','password','password2','secretQuestion','secretAnswer','status','debug');
				foreach($localvars as $v) {
					unset($packet->$v);
				}
				
				$packet->salutation = $packet->gender == 0 ? 'Frau' : 'Herr';
				$packet->mandantId = "1"; //$this->custInfo->mandantId;

				// send packet to mikos
        		$mRet = $this->call('updatePaPersonDetail',array('paPersonDetail' => $packet));
/*        
				$mmMailtext = print_r($mRet, true). "\n" .
				              print_r($data, true). "\n" .
                      print_r($packet, true) ."\n\n";
        		mail("m.pobloth@missionmedia.de", "DEBUG BNR ". $this->custInfo->partnerBNR, $mmMailtext, "");
*/
				// update local database
				$query = "UPDATE
					cpis_partner
				SET
					gender = '".$this->quote_smart($data['gender'])."',
					title = '".$this->quote_smart($data['fronttitle'])."',
					firstName = '".$this->quote_smart($data['firstname'])."',
					lastName = '".$this->quote_smart($data['surname'])."',
					username = '".$this->quote_smart($data['username'])."',
					password = '".md5($this->quote_smart($data['password']))."',
					position = '".$this->quote_smart($data['pasttitle'])."',
					phoneNumber = '".$this->quote_smart($data['phone'])."',
					mobileNumber = '".$this->quote_smart($data['mobile'])."',
					fax = '".$this->quote_smart($data['fax'])."',
					secretQuestion = '".$this->quote_smart($data['secretQuestion'])."',
					secretAnswer = '".$this->quote_smart($data['secretAnswer'])."',
					email = '".$this->quote_smart($data['email'])."',
					showDetails = '".$this->quote_smart($data['showDetails'])."',
					`status` = '".$this->quote_smart($data['status'])."'
				WHERE 
					paMemberId = ".$data['id']." LIMIT 1";
				
				$this->db->execute($query);

				// send mail to CSC
			     $mailtext  = "Der Händler ".$this->custInfo->partnerBNR." hat folgenden Mitarbeiter im CPIS bearbeitet:\n\n";
			     $mailtext .= "Titel: ".$data['fronttitle']."\n";
				 $mailtext .= "Name: ".$data['surname']."\n";
			     $mailtext .= "Vorname: ".$data['firstname']."\n";
				 $mailtext .= "Benutzername: ".$data['username']."\n";
				 $mailtext .= "Position: ".$data['pasttitle']."\n";
				 $mailtext .= "E-Mail: ".$data['email']."\n";
				 $mailtext .= "Telefon: ".$data['phone']."\n";
				 $mailtext .= "Mobilnummer: ".$data['mobile']."\n";
				 $mailtext .= "FAX: ".$data['fax']."\n";
			     $mailtext .= "Geheime Frage: ".$data['secretQuestion']."\n";
				 $mailtext .= "Geheime Antwort: ".$data['secretAnswer']."\n";
				 $mailtext .= "Status: ".$data['status']."\n";
			     
			     // send mail only if we are on web7
				 if(ereg("/web7/", $_SERVER['DOCUMENT_ROOT'])) {
				 	mail ("clubpartnerbetreuung@volkswagen-club.de",("Mitarbeiter bearbeitet von Händler ".$this->custInfo->partnerBNR), ($mailtext),"From: no-reply@vw-club.de\n Content-Type: text/plain; charset=UTF-8\n");
				 }
				
				
				// update webpage
				$this->smarty->assign('myEmployees',$this->myEmployees);
				$newList = $this->smarty->fetch ("paMyEmployeesList.html");
  				
				// create new js object
				$jsObject = $this->getMyEmployeesGetJsObject();
				$this->smarty->assign( 'jsObject', $jsObject);

				$output[] = "myEmployeesList=".$jsObject;
				$output[] = "$('myEmployees').innerHTML = '".str_replace(array("\n","\r"), array(chr(13),"","",""),$newList)."'; ";
				$output[] = "myEmployeesApplyActions();";	// to activate row buttons
				$output[] = "$('output').innerHTML='Änderungen gespeichert'; ";
				$output[] = "myInt = setInterval(function() { $('editEmployee').style.display='none'; $('output').empty(); $$('.redBorder').removeClass('redBorder'); clearInterval(myInt); },1000);  ";	

			}
		} else {
			$output[] = "$('output').innerHTML='Bitte korrigieren Sie die rot markierten Felder';";
		}
		
		// output notice
		$this->jsreturn($output);
	}

	/**
	* Deletes an Employee
	*
	* @access public
	* @param {object} data containing id of employee to be deleted
	* @author Florian Bosselmann
	*/
	public function doDeleteEmployee ($data) {
		
		if($data['id']) {		
			echo "delete from cpis_partner where ID = '".$this->quote_smart($data['id'])."' LIMIT 1";
			$this->db->execute("delete from cpis_partner where ID = '".$this->quote_smart($data['id'])."' LIMIT 1");
			
			$this->myEmployees = $this->db->getArray("select * from cpis_partner where partnerBNR = ".$this->custInfo->partnerBNR);
			$this->smarty->assign('myEmployees',$this->myEmployees);
			$newList = $this->smarty->fetch ("paMyEmployeesList.html");
		  	
			$output[] = "$('myEmployees').innerHTML = '".str_replace(array("\n","\r"), array(chr(13),"","",""),$newList)."'; ";
			$output[] = "myEmployeesApplyActions();";	// to activate row buttons
			$output[] = "myInt = setInterval(function() { $('editEmployee').style.display='none'; clearInterval(myInt); },1000);  ";
			$output[] = "$('mikos_editEmployee').reset();";
			
			$this->jsreturn($output);
		}
	}


	
	/**
	* Creates a Request for a new Membership
	*
	* @access public
	* @param {Array} $data filled with information of the worker to create
 	* @author Florian Bosselmann, <flobo@ultradigital.de>
	*/
	public function doCreateMember ( $data ) {
		// indicates whether the employee data has been entered completely or not
		$mandatory = split(",",STR_MEMBER_MANDATORY);
		foreach($mandatory as $field) {
			if($field && !$data[$field]) $output[] = "$('".$field."').addClass('redBorder');";
		}
		 
		// check if all mandatory car information are given
		$carfields = split(",",STR_MEMBERCAR_MANDATORY);
		foreach($carfields as $field) {
			if($field && !$data[$field]) $output[] = "$('$field').addClass('redBorder'); ";
		}
		
		// check date formats for
		$datefields = "birthday,carDeliveryDate,carInspectionGeneralDt,carInspectionExhaustDt,carInspectionDt";
		$datefields = split(",", $datefields);
		foreach($datefields as $datefield) {
			if(isset($data[$datefield]) && $data[$datefield] != '') {
				if(!$this->checkMyDate($data[$datefield])) {  $output[] = "$('$datefield').addClass('redBorder'); "; }
			}
		}
		
		// check license plate
		//if(!eregi("^[a-z]{0,3}\-[a-z]{0,3} [0-9]{0,4}",$data['carLicenceNr'])) { $output[] = "$('carLicenceNr').addClass('redBorder'); "; }
		
		// check buildYear
		if($data['carBuildYear'] && !ereg("^[0-9]{4}$",$data['carBuildYear'])) { $output[] = "$('carBuildYear').addClass('redBorder'); "; }
	
		// check odometer
		if($data['carKmState'] && !ereg("^[0-9]{0,10}$",$data['carKmState'])) { $output[] = "$('carKmState').addClass('redBorder'); "; }
		
		// check dates
		if($data['carInspectionGeneralDt']) {
			$carDeliveryDate = explode('.',$data['carDeliveryDate']); 
			$carDeliveryDate = mktime(0,0,0,$carDeliveryDate[1],$carDeliveryDate[0],$carDeliveryDate[2]);
			
			// HU Date
			if($data['carInspectionGeneralDt']) {
				$carInspectionGeneralDt = explode('.',$data['carInspectionGeneralDt']); 
				$carInspectionGeneralDt = mktime(0,0,0,$carInspectionGeneralDt[1],$carInspectionGeneralDt[0],$carInspectionGeneralDt[2]);
				if($carInspectionGeneralDt < $carDeliveryDate) $output[] = "$('carInspectionGeneralDt').addClass('redBorder').title = 'Hauptuntersuchung::Datum darf nicht vor dem Auslieferungstermin liegen';";
			}
			
			// AU Date
			if($data['carInspectionExhaustDt']) {
				$carInspectionExhaustDt = explode('.',$data['carInspectionExhaustDt']); 
				$carInspectionExhaustDt = mktime(0,0,0,$carInspectionExhaustDt[1],$carInspectionExhaustDt[0],$carInspectionExhaustDt[2]);
				if($carInspectionExhaustDt < $carDeliveryDate) $output[] = "$('carInspectionExhaustDt').addClass('redBorder').title = 'Abgasuntersuchung::Datum darf nicht vor dem Auslieferungstermin liegen';";
			}
			
			// Inspection Date
			if($data['carInspectionDt']) {
				$carInspectionDt = explode('.',$data['carInspectionDt']); 
				$carInspectionDt = mktime(0,0,0,$carInspectionDt[1],$carInspectionDt[0],$carInspectionDt[2]);
				if($carInspectionDt < $carDeliveryDate) $output[] = "$('carInspectionDt').addClass('redBorder').title = 'Inspektion::Datum darf nicht vor dem Auslieferungstermin liegen';";
			}
		}
		
		// check email address syntax
		if ($data['email'] != "") {
			if (!(ereg("^[_a-zA-Z0-9]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9äöüÄÖÜ-]+\.)+([a-zA-Z]{2,4})$", $data['email'] ) ) ) {
				$output[] = "$('email').addClass('redBorder').title='e-Mail :: ".REG_MSG_EMAIL_SYNTAX."';";
			}
		}
		
		// check cityname - only letters allowed
		if(!preg_match("/^[a-zA-ZäöüÄÖÜß -]*$/",$data['city'])) $output[] = "$('city').addClass('redBorder').addClass('tip').title = 'Ortsname::Ortsnamen dürfen keine Zahlen enthalten';";
		
		// check zip code - 5 digit number
		if(!ereg("^[0-9]{5}$",$data['zip'])) $output[] = "$('zip').addClass('redBorder').addClass('tip').title = 'Postleitzahl::Muss eine 5-stellige Zahl sein.';";
		
		// if everything went well, proceed
		if(!$output[0] ) {
			// skip unneeded vars
			unset($data['cpis_action']);
			unset($data['class']);
			
			// container for request
			$memberRequest = array();
			
			// put all given data to request container
			foreach($data as $field => $value) {
				$memberRequest[$field] = $data[$field];
			}
			
			// set gender
			$memberRequest['gender'] = $data['gender'] == 'Frau' ? 0 : 1;
			$memberRequest['salutation'] = $memberRequest['gender'] == 0 ? 'Frau' : 'Herr';	
			
			// add country name
			$countries = split(",",STR_COUNTRIES);
			$memberRequest['country'] = $countries[$data['countryName']];
		
			// adding additional fields to request object
			$memberRequest['partnerId'] = $this->custInfo->id;
			
			// Matze: 22.01.2008. Laut Dr. Siemers muss die mandantId = 1 sein, damit die Händlerbeauftragung gültig ist.
			$memberRequest['mandantId'] = "1";
			
			// set contractTypeId
			$memberRequest['contractTypeId'] = "1";
			$memberRequest['contractTypeName'] = "Vollbetreuung";
		
			// send request to server
			if($result = $this->call( 'createMemberRequest', array( 'MemberRequest' => $memberRequest, 'sessionId' => $this->sessionId))) {
				  // send mail only if we are on web7
				 if(LIVE) {
				     // send information mail to CSC
				     $mailtext  = "Der Händler ".$this->custInfo->partnerBNR." hat folgendes Mitglied über CPIS eingemeldet:\n\n";
				     $mailtext .= "Anrede: ".$memberRequest['gender']."\n";
					 $mailtext .= "Name: ".$memberRequest['surname']."\n";
				     $mailtext .= "Vorname: ".$memberRequest['firstname']."\n";
					 $mailtext .= "Zusatz: ".$memberRequest['nameAdd']."\n";
					 $mailtext .= "Telefon: ".$memberRequest['phone']."\n";
					 $mailtext .= "E-Mail: ".$memberRequest['email']."\n";
					 $mailtext .= "Straße: ".$memberRequest['street']." ".$memberRequest['houseNumber'].$memberRequest['houseNumberAdd']."\n";
					 $mailtext .= "Ort: ".$memberRequest['zip']." ".$memberRequest['city']."\n";
					 $mailtext .= "Land: ".$memberRequest['country']."\n";
					 $mailtext .= "Geburtstag: ".$memberRequest['birthday']."\n";
				     $mailtext .= "gewünschte Betreuungsart: ".$memberRequest['contracttype']."\n\n";
					 $mailtext .= "--- Fahrzeugdaten --- \n";
					 $mailtext .= "Hersteller: ".$memberRequest['carBrand']."\n";
					 $mailtext .= "Modell: ".$memberRequest['carModel']."\n";
					 $mailtext .= "Typ: ".$memberRequest['carType']."\n";
					 $mailtext .= "Fahrgestellnummer: ".$memberRequest['carvinNr']."\n";
					 $mailtext .= "Modellgruppe: ".$memberRequest['carModelGroup']."\n";
					 $mailtext .= "Modellschlüssel: ".$memberRequest['carModelKey']."\n";
					 $mailtext .= "Farbschlüssel: ".$memberRequest['carColorKey']."\n";
					 $mailtext .= "Baujahr: ".$memberRequest['carBuildYear']."\n";
					 $mailtext .= "Auslieferungsdatum: ".$memberRequest['carDeliveryDate']."\n";
					 $mailtext .= "KFZ-Kennzeichen: ".$memberRequest['carLicenseNr']."\n";
					 $mailtext .= "nächste HU: ".$memberRequest['carInspectionGeneralDt']."\n";
					 $mailtext .= "nächste AU: ".$memberRequest['carInspectionExhaustDt']."\n";
					 $mailtext .= "nächste Inspektion: ".$memberRequest['carInspectionDt']."\n";
					 $mailtext .= "Kilometerstand: ".$memberRequest['carKmState']."\n\n";
				     $mailtext .= CPIS_CREATE_MEMBER_NOTICE_TEXT."\n";
				     
			   		mail (CPIS_CREATE_MEMBER_NOTICE_TO,(CPIS_CREATE_MEMBER_NOTICE_SUBJECT.$this->custInfo->partnerBNR), ($mailtext),"From: no-reply@vw-club.de\n Content-Type: text/plain; charset=UTF-8\n");
				 }


				// reload member requests
				$myMemberRequests = $this->parseObjectList($this->call('listMemberRequests',array('partnerBnr' => $this->custInfo->partnerBNR,'mandantId'=>1)));
				$this->smarty->assign( 'myMemberRequests',$myMemberRequests );
				
				// create new list and remove all newlines for javascript
				$newList = $this->smarty->fetch ("paMyMemberList.html");
		  		$newList = str_replace(array("\n","\r",chr(13)),array("","",""), $newList);

				$output[] = "$('myRequestsList').innerHTML = '$newList'; ";
				$output[] = "$('output').removeClass('ajax_wait').innerHTML = 'Mitgliedsanfrage wurde gesendet.';";
				$output[] = "myInt = window.setTimeout(function() { $('editMember').style.display='none'; $$('.redBorder').removeClass('redBorder'); $('output').empty(); $$('input').each(function(e,i) { if(e.type == 'text' || e.type=='password') { e.value=''; }}); },2000);  ";
			
			} else {
				$output[] = "$('output').addClass('response_error').innerHTML='Fehler beim Übertragen an Datenbankserver.';";
			}
		
		} else 	{
			$output[] = "$('output').addClass('response_error').removeClass('ajax_wait'); updateTips();";
			$output[] = "$('output').innerHTML='Bitte korrigieren Sie die rot markierten Felder';";
		}
		
		// output output
		$this->jsreturn($output);
	}
	

	/**
	* loads login form into output buffer
	* output buffer availdable with $_SESSION['cpis']->display();
	*/
	public function showLoginForm () {
		$this->output = $this->smarty->fetch('paLogin.html');
	}
	
	/**
	* displays the partners details of the current customer 
	* template: paMyData.html
	*
	* @access public
 	* @author Florian Bosselmann, <flobo@ultradigital.de>
	*/
	public function showMyData () {
		$this->requireLogin();

        $jsObject = '{  ';
        foreach($this->custInfo as $field => $value) {
           	$jsObject .= $field.":'".($value)."',";
        }
        
        $this->smarty->assign('custInfo', $this->custInfo);
		$jsObject = substr($jsObject,0,-1).'};';
		$this->smarty->assign('mydatastr', $jsObject);
		
		$this->output = $this->smarty->fetch('paMyData.html');
	}

	/**
	* displays a input form to edit the customer details of the current customer
	* template: myDetailsEdit.html
	*
	* @access public
 	* @author Florian Bosselmann, <flobo@ultradigital.de>
	*/
	public function showMyDataEdit () {
		
		$this->requireLogin();
		$this->smarty->assign('countries',split(",",STR_COUNTRIES));
		$this->output = $this->smarty->fetch('paMyDataEdit.html');
	}
	
	/**
	* displays a list of the partners employers
	* template: paMyEmployers.html
	*
	* @access public
 	* @author Mathias Reisch <m.reisch@missionmedia.de>
	* @author Florian Bosselmann, <flobo@ultradigital.de>
	*/
	public function showMyEmployees () {
		$this->requireLogin();

		$jsObject = $this->getMyEmployeesGetJsObject();
    $this->smarty->assign('custInfo', $this->custInfo);		
		$this->smarty->assign( 'jsObject', "var myEmployeesList=".$jsObject);
		$this->smarty->assign( 'myEmployees',$this->myEmployees );
		$this->output = $this->smarty->fetch('paMyEmployees.html');
	}

	/**
	* displays Member lists
	* template: paMyProoflists.html
	*
	* @access public
 	* @author Florian Bosselmann, <flobo@ultradigital.de>
	*/
	public function showMyMember () {
		$this->requireLogin();
		
		// fetch member from mikos
		$myMember = '';
		
		// load member requests
		$myMemberRequests = $this->parseObjectList($this->call('listMemberRequests',array('partnerBnr' => $this->custInfo->partnerBNR,'mandantId'=> 1)));
		
		$this->smarty->assign('custInfo', $this->custInfo);
		$this->smarty->assign('myMemberRequests',$myMemberRequests);
		$this->smarty->assign('countries',split(",",STR_COUNTRIES));
		$this->output = $this->smarty->fetch('paMyMember.html');
	}

	/**
	* displays proof lists
	* template: paMyProoflists.html
	*
	* @access public
 	* @author Florian Bosselmann, <flobo@ultradigital.de>
	*/
	public function showMyProoflists () {
		$this->requireLogin();
		
		$myProoflist = $this->call('listProoflistsByPartnerIdDateCreated', 
			array('partnerId' => $this->custInfo->id, 'sessionId' => $this->sessionId, 'partnerBnr' => '', 'mandantId' => '1', 'withPDF' => false));
		
		$myProoflist = $this->parseObjectList($myProoflist);
		
		$this->smarty->assign('myProoflist',$myProoflist);
		$this->output = $this->smarty->fetch( 'paMyProoflist.html');
	}



	/**
	* displays all Members
	* template: paDisplayMembers.html
	*
	* @access public
	* @author M. Pobloth, <m.pobloth@missionmedia.de>	
	*/
	public function showMemberList () {
		$this->requireLogin();
  
		// load memberlist				
		$myMemberList = $this->parseObjectList( 
                        $this->call('paLoadMemberList',
                                array(
                                'bnr' => $this->custInfo->partnerBNR,
                                'mandantId' => 1,
                                'sessionId' => $this->sessionId)
                                )
                        );
		    				
		$memberFields = array('salutation', 'frontTitle', 'firstName', 'surname', 'street', 'streetAdd1', 'streetAdd2', 'zip', 'city', 'telephone', 'mobile', 'email', 'birthday', 'contractId', 'memberId', 'carvinNr', 'validFrom', 'totalValidFrom', 'contacts24M');
		
    $jsObject = '{  ';
		foreach($myMemberList as $member) {
			$jsObject .= "member".$member->contractId.":{";
			foreach($memberFields as $field) {
				$jsObject .= $field.":'".str_replace("'", "", $member->$field)."',";
			}
			$jsObject = substr($jsObject,0,-1)."},";			
		}
		$jsObject = substr($jsObject,0,-1).'};';		

		$output[] = "myMemberList=".$jsObject;
		$output[] = "myMemberListApplyActions(); ";	// to activate row buttons
		$output[] = "myInt = setInterval(function() { $('editMember').style.display='none'; $('mikos_editMember').reset(); clearInterval(myInt); },1000);  ";

		$this->smarty->assign('custInfo', $this->custInfo);
		$this->smarty->assign('jsObject', "var myMemberList=".$jsObject);
		$this->smarty->assign('myMemberList', $myMemberList);
		$this->output = $this->smarty->fetch('paMyMembers.html');
	}
	
	/**
	* doEditMemberData($data)
	*
	* @access public
	* @param {Array} $data filled with information of the member to edit
	*/
	public function doEditMemberData($data) {
		$mandatory = split(",",STR_MEMBERLIST_MANDATORY);
		foreach($mandatory as $field) {
			if(!$data[$field]) $output[] = "$('d_".$field."').toggleClass('redBorder');";
		}
  
		// if everything went well, proceed
		if(!$output[0] ) {

      	// prepare MemberDataDetail structure
		$memberDataDetail = array('contractId' => $data['contractId'],
            'salutation' => $data['salutation'],
            'zip' => $data['zip'],
            'country' => 'Deutschland',
            'city' => $data['city'],
            'street' => $data['street'],
            'streetAdd1' => $data['streetAdd1'],
            'streetAdd2' => $data['streetAdd2'],
            'carvinNr' => $data['carvinNr'],
            'telephone' => $data['telephone'],
            'mobile' => $data['mobile'],
            'email' => $data['email']
            );
	
		  $memberDataUpdateResult = $this->call('updateMemberData',
                                  array(
                                    'memberDataDetail' => $memberDataDetail,
                                    'bnr' => $this->custInfo->partnerBNR,
                                    'mandantId' => 1,
                                    'sessionId' => $this->sessionId)
                                  );


				$mailtext = "Success: " . $memberDataUpdateResult->success . "\n" .
                    "Message: " . $memberDataUpdateResult->message . "\n" .                    
                    "Values:  " . $memberDataDetail['contractId'] . "\n\n" .
                    print_r($memberDataUpdateResult, true). "\n" .
                    print_r($memberDataDetail, true) ."\n\n";
                        
		    	mail("m.pobloth@missionmedia.de", "Mitglied bearbeitet von BNR ". $this->custInfo->partnerBNR, $mailtext, "");     
				ob_end_clean();

        if ($memberDataUpdateResult->success != '1') {             
				  $output[] = "$('output').innerHTML='$memberDataUpdateResult->message'; ";
          $output[] = "myInt = setInterval(function() { $('editMember').style.display='none'; $('output').empty(); $$('.redBorder').removeClass('redBorder'); clearInterval(myInt); },2400);  ";          	
        } else {
				  $output[] = "$('output').innerHTML='Änderungen gespeichert'; ";
          $output[] = "myInt = setInterval(function() { $('editMember').style.display='none'; $('output').empty(); $$('.redBorder').removeClass('redBorder'); clearInterval(myInt); },1000);  ";
        }
        

		} else {
			$output[] = "$('output').innerHTML='Bitte korrigieren Sie die rot markierten Felder';";
		}
		
		// output notice
		$this->jsreturn($output);
	}	

	
	/**
	* loads forgotPassword form into output buffer
	* output buffer availdable with $_SESSION['kis']->display();
	* @author Florian Bosselmann, <flobo@ultradigital.de>
	* @access public
	*/
	public function showVerifyEmailForm () {
		$this->newCaptchaCode();
		$this->output = $this->smarty->fetch('paVerifyEmailForm.html');
	}

	/**
	* loads forgotPassword form into output buffer
	* output buffer availdable with $_SESSION['kis']->display();
	* @author Mathias Reisch, <m.reisch@missionmedia.de>
	* @access public
	*/
	public function showForgotPasswordForm () {
		$this->newCaptchaCode();
		$this->smarty->assign('countries',split(",",STR_COUNTRIES));
		$this->output = $this->smarty->fetch('paForgotPassword.html');
	}
	
	/**
	* handle if an user has forgotten his password
	*
	* @param mixed $data data entered into form fields
	* @author Mathias Reisch
	*/
	public function doForgotPassword ($data) {
		
		// check sichtcode
		if( $data['captcha_code'] != $_SESSION['captcha_code'] ) {
			$output[] = "$('captcha_code').addClass('redBorder').addClass('tip').title='Sichtcode :: Bitte geben Sie den Sichtcode exakt ein, bitte beachten Sie groß und Kleinschreibung.';";
		}
		
		// check mandatory data
		if(!$data['partnerBNR'])  $output[] = "$('partnerBNR').addClass('redBorder').addClass('tip').title='Betriebsnummer :: Bitte geben Sie Ihre Betriebsnummer ein.';";	
		if(!$data['firstname'])  $output[] = "$('firstname').addClass('redBorder').addClass('tip').title='Vorname :: Bitte geben Sie Ihren Vornamen ein.';";	
		if(!$data['lastname'])  $output[] = "$('lastname').addClass('redBorder').addClass('tip').title='Nachname :: Bitte geben Sie Ihren Nachnamen ein.';";	

		if(!$output[0]) {
			// check if user is in database
			$query = "SELECT * FROM `cpis_partner` WHERE 
				`partnerBNR` = '".$this->quote_smart($data['partnerBNR'])."'
				 and `firstname` = '".$this->quote_smart($data['firstname'])."'
				 and `lastname` = '".$this->quote_smart($data['lastname'])."'
				LIMIT 1";
			$partner = $this->db->getRow( $query );
			
			if( $partner['ID']) {
				if($partner['email']) {
					
					$newpassword = substr(md5(microtime()),0,7);
					$this->db->execute("update cpis_partner set password = '".md5($newpassword)."' where ID = '$partner[ID]' LIMIT 1");
					
					// create email bodies
					$mailtext = str_replace(array('<username>','<password>'),array($partner['username'],$newpassword), SENDPASSWORD_MAIL_TEXT);
					
					// send mails
					mail($partner['email'],SENDPASSWORD_MAIL_SUBJECT,$mailtext,SENDPASSWORD_MAIL_FROM);
					
					// update Webpage
					$output[] = "$('inputtable').style.display='none';";
					$output[] = "$('output').innerHTML='Ihre Zugangsdaten wurden soeben an die Adresse ".$partner['email']." gesendet.';";

				} else {
					$output[] = "$('output').innerHTML='Sie haben keine Email Adresse hinterlegt, bitte klicken Sie hier: <a href=\"/?page=1029\">Email neu setzen</a>';";
				}
			} else {
				$output[] = "$('output').innerHTML='Es existiert kein Konto mit den angegebenen Daten.';";
			}
		} else {
			$output[] = "updateTips(); ";
		}

		$this->jsreturn($output);
		 
	}

	public function ajax_loadSecretQuestion($data) {
		$output = array();
		if($data['checkPartnerBNR']) {
			if($data = $this->db->getRow("select * from cpis_partner where partnerBNR = '".$this->quote_smart($data['checkPartnerBNR'])."' and status = '2' LIMIT 1")) {
				$output[] = "$('secretQuestion').innerHTML='".$data['secretQuestion']."'; ";
				$output[] = "$('formDetails').style.display='block'; ";
				$output[] = "$('partnerBNR').value='$data[partnerBNR]'; ";
				$_SESSION['cpisdata']['verifyEmailMember'] = $data;
			} else {
				$output[] = "$('output').innerHTML = 'Die angebenene Betriebsnummer ist nicht registriert.';";
				$output[] = "$('output').addClass('response_error');";
				$output[] = "$('formDetails').style.display='none'; ";
			}
		} else {
			$output[] = "$('output').innerHTML = 'Bitte geben Sie Ihre Betriebsnummer ein.';";
			$output[] = "$('output').addClass('response_error');";
			$output[] = "$('formDetails').style.display='none'; ";
		}
		
		$this->jsreturn($output);
	}

	
	/**
	* reset email and send email to member
	*
	* @param array $data containing 
	* @param string $password the password of the customer
	* @author Florian Bosselmann <flobo@ultradigital.de>
	*/
	public function doSetNewMail($data) {
		$output = array();
		$member = $_SESSION['cpisdata']['verifyEmailMember'];
		
		
		if($data['secretanswer'] != $member['secretAnswer']) {
			$output[] = "$('secretanswer').addClass('redBorder');";
			$output[] = "$('secretanswer').title='geheime Antwort :: Die eingebene Antwort stimmt nicht.';";
		}
		if(!$data['newemail']) {
			$output[] = "$('newemail').addClass('redBorder');";
		}
		if(!$data['newemailrepeat']) {
			$output[] = "$('newemailrepeat').addClass('redBorder');";
		}
		if($data['newemail'] != $data['newemailrepeat']) {
			$output[] = "$('newemailrepeat').addClass('redBorder');";
		}
		if($data['captcha_code'] != $_SESSION['captcha_code']) {
			$output[] = "$('captcha_code').addClass('redBorder');";
		}
		
		if($output[0]) {
			// if an error has occured add class change of output field
			$output[] = "$('output').addClass('response_error');";
			$output[] = "$('output').innerHTML = 'Bitte prüfen Sie die markierten Felder';";
		} else {
			// save emailaddress in database
			$this->db->execute("update cpis_partner set email = '$data[newemail]' where ID = '$member[ID]' LIMIT 1");
			
			// and sent email with login data to email adress
			$mailtext = str_replace(array('<username>','<password>'),array($member['username'],$member['password']),SENDPASSWORD_MAIL_TEXT);
			mail($data['newemail'],SENDPASSWORD_MAIL_SUBJECT,$mailtext,SENDPASSWORD_MAIL_FROM);
			
			$output[] = "$('output').innerHTML='Ihre Zugangsdaten wurden soeben an Ihre E-Mail Adresse gesendet.'; ";
		}
		
		$this->jsreturn($output);
	}


	/**
	* displays output buffer
	*/
	public function display() {
		
		if($this->connected) {
			echo $this->output;
		} else {
			echo $this->output = $this->smarty->fetch("notConnected.html");
		}
	}

	/**
	* Prueft $this->loggedIn, wenn false wird per Header-Redirect auf die
	* constant LOGIN_URL verwiesen
	*
	* @access public
	* @author Henrik Westphal, <hwestphal@nwmgbr.de>
	* @return void
	*/
	public function requireLogin() {
		if($this->loggedIn == false) {
			header('Location: '.URL_CPIS_LOGIN);
		}
	}

	/**
	* generates a random string and stores it in session
	* with name "captcha_code"
	* 
	* @access private
	* @author Florian Bosselmann, <flobo@ultradigital.de>
	* @return void
	*/
	private function newCaptchaCode () {
		// create random chaptcha code
		$str = "";
		$length = 5;

		for ($i = 0; $i < $length; $i++) {
			// this numbers refer to numbers of the ascii table (small-caps)
			$str .= chr(rand(97, 122));
		}
		$_SESSION['captcha_code'] = $str;
	}
	
	public function createDebugOutput($o) {
		ob_start();
		print_r($o);
		$result = '<pre>'.ob_get_contents().'</pre>';
		ob_end_clean();
		return $result;
	}

	private function checkMyDate ($date) {
		if (preg_match('/^(\d{2})\.(\d{2})\.(\d{4})$/', $date, $hits)
		     && checkdate($hits[2], $hits[1], $hits[3])) {
		   return true;
		} else {
			return false;
		}
	}
	
	private function jsreturn($array) {
		// output notice
		echo '<script type="text/javascript">';
		if(is_array($array)) foreach($array as $action) { echo $action; }
		echo '</script>'; 
	}
	
	/**
	* This function cast mysql variables 
	* to avoid injections
	* @param: {String} value String to be casted
	*/
	function quote_smart($value)
	{
	    // Stripslashes
	    if (get_magic_quotes_gpc()) {
	        $value = stripslashes($value);
	    }
	    // Quote if not integer
	    if (!is_numeric($value)) {
	        $value = mysql_real_escape_string($value);
	    }
	    return $value;
	}
}

?>