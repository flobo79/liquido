<?php
/**
 * Project:     VW Club Community Modul
 * File:        class.KIS.php
 *
 * This library is meant to be a universal Connector to the MIKOS customer
 * Database of Volkswagen and provides functions 
 *
 *
 * @link http://www.vw-club.de/
 * @copyright 2007 mission media
 * @author Florian Bosselmann <flobo@ultradigital.de>
 * @package Kis
 * @version 1.0
 */
 
header('content-type: text/html; charset=utf-8');
require_once (dirname(dirname(__FILE__))."/config.inc.php");	
require_once (dirname(__FILE__).'/class.Mikos.php');
require_once (dirname(__FILE__)."/adodb/adodb.inc.php");


/**
 * @package KIS
 */
class KIS extends Mikos {
	/**
	* output container
	*/
	public $output = "";
	public $custInfo;
	public $myCars;
	public $myDealer;
	
    /**
     * The class constructor.
     */
	public function KIS () {
		// construct Mikos
		$this->Mikos();
		
		$myCars = array();
		
		// path to this class
		$this->classpath = dirname(__FILE__);
		
		
		if(isset($_GET) && isset($_GET['kis']) && $_GET['kis'] == 'logout') {
			$this->doLogout();
			
		}
		
		if($this->loggedIn) $this->smarty->assign('custInfo',$kis->custInfo);
		
		
		if($_COOKIE['kisALID'] && !$this->loggedIn) {
			$this->autologin($_COOKIE['kisALID']);
		}
			
		
		// if kis recieves a do[action] try to execute it
		if($_POST && array_key_exists('kis_action', $_POST) && method_exists($this, "do".$_POST['kis_action'])) {
			$this->$_POST['kis_action']($_POST);
		}
	}
	
	
	/**
	* register a User
	* to Mikos Database.
	*
	* @param string $username the username of the customer
	* @param string $password the password of the customer
	* @author Mathias Reisch
	*/
	public function doRegister ($data) {
		// container for output messages
		$output = array();
		$output[] = "$('output').empty();";	
			
		// check for membernumber
		if (!$data['membernumber'] ) {
			$output[] = "$('membernumber').addClass('redBorder').addClass('tip').title='Mitgliedsnummer : ".REG_MSG_MEMBERID."';";
		} else {
		
		// check if user entered the member number (9-digit) or the card number (19-digit)
		// if card number was entered, extract member number from it
		if (strlen($data['membernumber']) == 19 )
			{ $data['membernumber'] = substr($data['membernumber'],6,9); }
		
		
		if ($this->login_member ($data['membernumber'])) {
				// if member was found data will be stored in $this->custInfo by the login method
			
			} else {
				$output[] = "$('membernumber').addClass('redBorder').addClass('tip').title='Mitgliedsnummer : ".REG_MSG_MEMBERID_UNKNOWN."';";
			}
			unset($this->custInfo);
		}
	
		
		if (!$data['accept']) {
			$output[] = "$('accept').addClass('redBorder').addClass('tip').title='Datenschutz : Sie müssen mit den Datenschutz und Nutzungsbedingungen einverstanden sein.';";
		}
		
		
		if (!$data['wantAccess']) {
			$output[] = "$('wantAccess').addClass('redBorder').addClass('tip').title='Zugang : Aktivieren Sie diesen Häkchen, um zu bestätigen dass Sie Zugang zum Kundencenter beantragen möchten.';";
		}
	
		// check for e-mail
		if (!(ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,4})$",$data['email'] ) ) ) {
			$output[] = "$('email').addClass('redBorder').title='e-Mail : ".REG_MSG_EMAIL_SYNTAX."';";
		}
		
		
		if (!$data['secretQuestion']) {
			$output[] = "$('secretQuestion').addClass('redBorder').title='e-Mail : ".REG_MSG_SECRETQUESTION."';";
		}
		
		
		if (!$data['secretAnswer']) {
			$output[] = "$('secretAnswer').addClass('redBorder').title='e-Mail : ".REG_MSG_SECRETANSWER."';";
		}
		
		// check captcha
		if(!$data['captcha_code'] or $data['captcha_code'] != $_SESSION['captcha_code']) {
			$output[] = "$('captcha_code').addClass('redBorder').title='Sichtcode : Bitte geben sie den Sichtcode ein';";
		}
		
		
		
		// check for username 
		if (!$data['username']) {
			$output[] = "$('username').addClass('redBorder').addClass('tip').title='Benutzername : ".REG_MSG_USERNAME."';";
			$complete = false;
	
		// check if username is already in use by someone else	
		} else {
			$query = "SELECT ID FROM `customer` WHERE STRCMP(`username`,'".$this->quote_smart($data['username'])."')=0 LIMIT 1";
			$user = $this->db->getRow( $query );
			
			if ($user['ID']) {	
				$output[] = "$('username').addClass('redBorder').addClass('tip').title='Benutzername : ".REG_MSG_USERNAME_GONE."';";
				unset($user);
			}
		}

		// no password given
		if(!$data['passwd1']) {
			$output[] = "$('passwd1').addClass('redBorder').addClass('tip').title='Passwort : ".REG_MSG_PASSWORD."';";
		}
		
		// no confirm password given
		if( !$data['passwd2']) {
			$output[] = "$('passwd2').addClass('redBorder').addClass('tip').title='Passwort wiederholen: ".REG_MSG_PASSWORD_TWICE."';";
		}
		
		// password and confirm dont match
		if ($data['passwd1'] && $data['passwd1'] && $data['passwd1'] != $data['passwd2']) {
			$output[] = "$('passwd2').addClass('redBorder').addClass('tip').title='Passwort wiederholen: ".REG_MSG_PASSWORD_TWICE."';";
		}
		
		// if there was an error
		if(count($output)>1) {
			$output[] = "$('output').innerHTML += 'Bitte überprüfen Sie die rot markierten Felder.';";
			$output[] = "$('output').addClass('response_error');";
			$this->jsreturn($output);
			return;
		}
		
		// lets see if the user has signed up already
		$query = "SELECT * FROM `customer` WHERE `membernumber` = '".$this->quote_smart($data['membernumber'])."' LIMIT 1";
		$member = $this->db->getRow( $query );
		if($member['ID'] ) {
			if ($member['pending'] == 1) {
				$output[] = "$('output').innerHTML += '".REG_MSG_ACTIVATE_ACCOUNT."';";
				$output[] = "$('output').addClass('response_error');";

			} else {
				$output[] = "$('output').innerHTML += '".REG_MSG_STILL_REGISTERED."';";
				$output[] = "$('output').addClass('response_error');";
			}
			
			$this->jsreturn($output);
			return;
		}
		unset($member); 
		
		// proceed if everything has been entered correctly
		// generate hashId from timecode, e-mail and secret word
		$secret = "IPeeFreely";
		$timecode = microtime();
		$hashid = md5( "$secret $timecode ".$data['email'] );
	
		// write account to database
		$query = "INSERT INTO
				`customer`
			SET
				`memberNumber` = '".$data['membernumber']."',
				`email` = '".$data['email']."',
				`username` = '".$this->quote_smart($data['username'])."',
				`password` = '".md5($data['passwd1'])."',
				`secretAnswer` = '".$this->quote_smart($data['secretAnswer'])."',
				`secretQuestion` = '".$this->quote_smart($data['secretQuestion'])."',
				`pending` = '1',
				`regTimeout` = '".intval(REGISTER_TIMEOUT + time())."',
				`hashID` = '".$this->quote_smart($hashid)."',
				`regDate` = NOW(),
				`newsletter` = '".$data['newsletter']."'";
		$this->db->execute( $query );

		// send confirmation mail
		mail($data['email'], REG_MAIL_SUBJECT, utf8_decode(str_replace("<hashid>",$hashid, REG_MAIL_TEXT)), REG_MAIL_FROM);
	
		$this->mikos_logout();
	
		$output[] = "$('registerTable').dispose();";
		$output[] = "$('output').innerHTML += '".REG_MSG_COMPLETE."';";
	
		$this->jsreturn($output);
		return;
	}
	
	
	
	
	
	/**
	* shows a welcome message if a member has registered successfully
	*
	* @author Mathias Reisch
	*/
	public function doConfirmation()
	{
		$hashid = $this->quote_smart($_GET['hashid']);
		
		if( $hashid != "" )
		{
			$query = "SELECT * FROM `customer` WHERE `hashID` = '".$hashid."' LIMIT 1";
			$member = $this->db->getRow( $query );	
			
			if(!$member) {
				$this->smarty->assign( 'success', 0 );
				
			} else {
			
			// check if member has already clicked on that confirmation link
			if($member['pending'] != 0) { 
			
				// if time limit of seven days has not yet expired
				if( $member['regTimeout'] > time() ) {
					$query = "UPDATE
								customer
							SET
									pending = '0',
									firstLoginStatus = '1',
									webstatus = '1',
									regTimeout = '0'
							WHERE
									hashID = '".$hashid."'";
					
					$this->db->execute( $query );	
					$this->smarty->assign( 'firstname', $member['firstname'] );
					$this->smarty->assign( 'lastname', $member['lastname'] );
					$this->smarty->assign( 'success', 1 );
					
					if(LIVE) {
						$to = "kontakt@volkswagen-club.de";
						
						$mailtext  = "Das Mitglied mit der Member Nummer ".$member['memberNumber']." hat sich soeben registriert.\n\n";
						$subject = "TP-BONUS: Mitglied hat sich registriert (".$member['memberNumber'].")";
						$from = "no-reply@vw-club.de\n Content-Type: text/plain; charset=UTF-8\n";
						
						require_once(dirname(dirname(dirname(__FILE__))).'/liquido/lib/helper/PGPMail.php');
						$mail = new PGPMail($to, $subject, $mailtext,  $from, PGP_KEY_KONTAKT);
						$mail->send();
						
						mail($to, $subject, $mailtext, 'From: '.$from);
					}
					
				} else {
					// time limit has expired
					$this->smarty->assign( 'success', 0 );
				}
			} else { $this->smarty->assign( 'success', 0 ); } // end: check if member has already been confirmed 
			
			}

			$this->output = $this->smarty->fetch('confirmation.html');
		}
	}
	
	
	

	/**
	* handle if an user has forgotten his password
	*
	* @param mixed $data data entered into form fields
	* @author Mathias Reisch
	*/
	public function doForgotPassword ($data) {

		// indicates whether the user data has been entered entirely or not
		$complete = true;

		// check for membernumber
		if( !$data['membernumber'] ) {
			$output[] = "$('membernumber').addClass('redBorder').addClass('tip').title='Mitgliedsnummer :: Bitte Mitgliedsnummer eingeben';";
			//$complete = false;
		
		} else {
			// Matze 23.01.2008
			//--------------------------
			// check if user entered the member number (9-digit) or the card number (19-digit)
			// if card number was entered, extract member number from it
			if (strlen($data['membernumber']) == 19 )
				{ $data['membernumber'] = substr($data['membernumber'],6,9); }
				
			// check if user is in database
			$query = "SELECT * FROM `customer` WHERE `memberNumber` = '".$this->quote_smart($data['membernumber'])."'";

			$member = $this->db->getRow( $query );

			if( $member['ID']) {
				if( $member['pending'] == 1 ) {
					
					$output[] = "$('output').innerHTML='Bitte aktivieren Sie zunächst Ihren Account, in dem Sie auf den Link in der Aktivierungs-E-Mail klicken!';";
					$complete = false;
				}
			} else {
				$output[] = "$('output').innerHTML='Es existiert kein Kundenkonto mit der angebebenen Mitgliedsnummer.';";
				$output[] = "$('membernumber').addClass('redBorder').addClass('tip').title='Mitgliedsnummer :: Es existiert kein Kundenkonto mit der angebebenen Mitgliedsnummer.';";
				$complete = false;
			}
		}

		//check for firstname
		if(!$data['firstname'] ) {
			$output[] = "$('firstname').addClass('redBorder').addClass('tip').title='Vorname :: Bitte geben Sie Ihren Vornamen an.';";
			$complete = false;
		}

		// check for lastname
		if(!$data['lastname']) {
			$output[] = "$('lastname').addClass('redBorder').addClass('tip').title='Nachname :: Bitte geben Sie Ihren Nachnamen an.';";
			$complete = false;
		}
		
		// check for captcha
		if( $data['captcha_code'] != $_SESSION['captcha_code'] ) {
			$output[] = "$('captcha_code').addClass('redBorder').addClass('tip').title='Sichtcode :: Bitte geben Sie den Sichtcode richtig ein.';";
			$complete = false;
		}

		// if all information are given
		if ($complete) {
			if ( $member['email'] == "" ) {
				$output[] = "$('output').innerHTML='Sie haben keine E-Mail Adresse im System hinterlegt. Bitte verwenden Sie den obigen Link!';";
				$complete = false;
			
			} else {
				
				// fetch data from mikos				
				if($this->login_member ($data['membernumber'])) {
					print_r ($this->custInfo);
					if($this->custInfo->firstName == ($data['firstname']) && $this->custInfo->surname == ($data['lastname']) ) {
						
						$newpassword = substr(md5(microtime()),0,7);
						$this->db->execute("UPDATE `customer` set `password` = '".md5($newpassword)."' WHERE `ID` = '$member[ID]' LIMIT 1");

						// create email bodies
						$mailtext = str_replace(array('<username>','<password>'),array($partner['username'],$newpassword), SENDPASSWORD_MAIL_TEXT);
						
						$mail_password = str_replace(array('<login>','<password>'),array($member['username'],$newpassword),STR_USERDATA_MAIL_PASSWORD);
						$mail_username = str_replace(array('<login>','<password>'),array($member['username'],$newpassword),STR_USERDATA_MAIL_USERNAME);
						
						mail($member['email'], STR_SUBJECT_LOGINDATA_PASSWORD, $mail_password, "from: ".STR_MAIL_FROM." <".STR_MAIL_RETURN.">\n Content-Type: text/plain; charset=UTF-8\n");
						mail($member['email'], STR_SUBJECT_LOGINDATA_USERNAME, $mail_username, "from: ".STR_MAIL_FROM." <".STR_MAIL_RETURN.">\n Content-Type: text/plain; charset=UTF-8\n");
						
						$output[] = "$('output').removeClass('response_error').innerHTML='".STR_USERDATA_SENT."';";
						
						// write data to local database
						$sql = "UPDATE `customer` SET `firstname` = '".$this->custInfo->firstName."', `lastname` = '".$this->custInfo->surname."', `memberID` = '".$this->custInfo->id."' 
						WHERE `ID` = '".$this->quote_smart($member['ID'])."'";
						$this->db->execute($sql);
						
					} else {
						$output[] = "$('output').addClass('response_error').innerHTML='".STR_NO_ACCOUNT_FOUND."';";
					}
				} else {
					$output[] = "$('output').addClass('response_error').innerHTML = '".STR_NO_ACCOUNT_FOUND." (Mikos).';";
				}
				
				$this->mikos_logout();
				unset($this->custInfo);
			}
		} else {
			$output[] = "$('output').addClass('response_error').innerHTML='Bitte überprüfen Sie die rot markierten Felder.';";
		}
		
		if($complete == false) $output[] = "$('output').addClass('response_error');";
		$this->jsreturn($output); 
	}
	
	
	/**
	 * logs a user in automatically by a given session id
	 * if user session is not found, delete cookie
	 * 
	 * @param $sessid
	 * @return unknown_type
	 */
	public function autologin($sessid) {
		// try to find session
		if(is_array($oldsession = $this->db->getRow("select * from login_protocoll where sessid = '".mysql_real_escape_string($sessid)."' LIMIT 1"))) {
			$member = $this->db->getRow("select * from customer where memberNumber = '$oldsession[memberNumber]' LIMIT 1");
			
			if($member['ID']) {
				$this->doLogin(false, $member['memberNumber']);
			} else {
				setcookie('kisALID');
			}
		}
	}
	
	
	/**
	* find user account in local database and uses its information to connect
	* to Mikos Database.
	*
	* @param string $username the username of the customer
	* @param string $password the password of the customer
	*/
	public function doLogin ($data, $memberNumber=false) {
		
		$output = array();
		
		if(!$memberNumber) {
			if($data['username'] != "" && $data['password'] != "") {
				// find user in local database
				$query = "select  *  from  customer  where username = '".$this->quote_smart(($data['username']))."'  LIMIT 1"; 
				$user = $this->db->getRow($query);
				
				if($user['ID']) {
					// if account is blocked
					if($user['timeOut'] > time()) {
						$output[] = "$('output').innerHTML='Benutzerkonto gesperrt für ".round(($user['timeOut'] - time()) / 60)." Minuten.';";
					
					// check if password is correct
					} elseif($user['password'] != md5($data['password'])) {
						
						// if user exeeded allowed login fails - block user for 
						if($user['failedLogins'] == (LOGIN_ATTEMPTS-1)) {
							$this->db->execute("update customer set failedLogins = 0, `timeOut` = '".(time()+LOGIN_TIMEOUT)."' where `ID` = '".$user['ID']."' LIMIT 1");
							$output[] = "$('output').innerHTML='Fehler: Zu viele Fehlversuche. Dieser Zugang wurde für ".round((LOGIN_TIMEOUT / 60))." Minuten gesperrt.';";
							
						} else {
							// write fail to database
							$this->db->execute("update `customer` set `failedLogins` = `failedLogins`+1 where`ID` = '".$user['ID']."' LIMIT 1");
							$output[] = "$('output').innerHTML='Passwort falsch';";
							$output[] = "$('password').setValue = '';";
							$output[] = "$('output').addClass('response_error');";
						}
					
					// seems good
					} else {
						$memberNumber = $user['memberNumber'];	
					}
				} else {
					$output[] = "$('output').innerHTML='Benutzername ".$this->quote_smart($data['username'])." nicht gefunden';";
					$output[] = "$('output').addClass('response_error').removeClass('ajax_wait');";
				}
			} else {
				$output[] = "$('output').innerHTML='Bitte Benutzername und Passwort eingeben';";
				$output[] = "$('output').addClass('response_error');";
			}
		} else {
			$autologin = true;
		}
		
		
		if(!$memberNumber) {
			// somethings is dodgy
		
		} else {
			// login to intrexx
			// clear all previous session ids for this user
			$this->db->execute("update login_protocoll set sessid = '' where memberNumber = $user[memberNumber] and sessid != ''");
			if($this->login_member ($memberNumber)) {
				
				// if autologin has been set
				if(isset($data['autologin']) && $data['autologin']) {
					$mHash = session_id();
		            
		            $mCookieLifetime = time()+60*60*24*30*6;
		            if(setcookie('kisALID', $mHash, $mCookieLifetime, "/")) { 
		            	//FB::log('write autologin cookie');
		            } else { 
		            	//FB::log('could not write cookie');
		            }
				}
				
				
				/**
				Erläuterung zur MandantID:
				mail vom 12.januar von ralf:
				
				ich habe mir gerade noch mal was zentrales vom doc erklären lassen:
				bei der mandantID gibt es einige unterschiede zwischen den möglichen werten:
				-1 = mandantengruppe VW/Audi
				1 = VW
				0 oder 2 oder was immer = Audi
				...

				es kann grundsätzlich X mandantengruppen geben. bei unserem aktuellen fall
				kriegen wir -1 geliefert, weil das mnitglied in dieser gruppe ist. da wir
				jetzt aber nur vw-händler abrufen wollen, können wir nicht die gruppenid -1
				benutzen, auch wenn sie uns vom system geliefert wird. wir müssen diese auf
				1 hardcoden, dann sollte es gehen...
				sagt der doc jedenfalls.                                                  */
				
				// append fields and local user data
				$this->custInfo->mandantId = "1";
				$this->custInfo->mobile = $this->custInfo->mobile;
				$this->custInfo->birthday = $this->custInfo->birthday;
				$this->custInfo->email = $this->custInfo->email;
				$this->custInfo->localID = $user['ID'];
				if(!$this->custInfo->email) $this->custInfo->email = $user['email'];
				
                // load Account Data
				$getAccount = $this->parseObjectList($this->call('getMbAccountsListByMemberAndMandant',  array('memberId' => $this->custInfo->id, 'mandantId' => $this->custInfo->mandantId))); 
				$this->accountInfo = $getAccount[0];
				
				// load all cars of this customer
				$carlist = array();
				$mcs = $this->parseObjectList($this->call('getValidContractsMCListByMemberAndMandant',array('mandantId' => $this->custInfo->mandantId)));
				
				// assume it's only one car in mikos
				foreach ($mcs as $mc) {
					$this->myCars[] = array(
						'carBrand' => $mc->carBrand,
						'carModel' => $mc->carModel,
						'carType' => $mc->carType,
						'carLicenseNr' => $mc->carLicenseNr,
						'nextHU' => $mc->carInspectionGeneralDt,
						'nextAU' => $mc->carInspectionExhaustDt,
						'nextInspection' => $mc->carInspectionDt,
						'kmReading' => $mc->carKmState,
						'carvinNr' => $mc->carvinNr,
						'buildYear' => $mc->carBuildYear,
						'partnerBNR' => $mc->partnerBnr
					);
				}
				
				// ## fetch cars from local database
				$query = "select * from customer_cars where `customerID` = '".$this->custInfo->localID."' order by ID LIMIT 5";        
        foreach($this->db->getArray($query) as $car) { $this->myCars[] = $car; }
                        
				// get customer cards
				$cl = $this->call('getCardsList', array('mandantId' => $this->custInfo->mandantId));
				$this->myCards = $this->parseObjectList($cl);
				
				// get and sort customer voucher points
				$plist = $this->parseObjectList($this->call('getMvBBookingsList', array('memberId' => $this->custInfo->id, 'mandantId' => $this->custInfo->mandantId, 'accountId' => $this->accountInfo->id)));
                        
				// round values for points and euroAmount
				for ($i=0; $i<sizeof($plist); $i++) {
					$plist[$i]->euroAmount = round($plist[$i]->euroAmount,2); 
					$plist[$i]->points = round($plist[$i]->points,2);
				}
				
				krsort($plist);
				$this->myPoints = $plist;
				
				// get myDealer
				$this->myDealer = $this->parseObjectList($this->call('getPartnerListByMemberId',array('memberId' => $this->custInfo->id, 'mandantId' => $this->custInfo->mandantId, 'contractMCisValid' => true)));
				//
				//
				// get Contract Information
				// $this->myContracts = $this->parseObjectList($this->call('getValidContractsMCListByMemberAndPartner'));
				//
				// reset failed login attempts
				$this->db->execute("update customer set failedLogins = 0");
	
				// get webstatus(c)
				foreach($this->myCards as $card) {
					if($card->isValid) {
						$hasValidCard = true;
						break;
					}
				}
				
				if($this->custInfo->isValid) {
					$this->custInfo->webStatus = 1;
				
				} elseif ($hasValidCard) {
					$this->custInfo->webStatus = 2;
					
				} elseif ($this->myPoints[0]->state > 0) {
					$this->custInfo->webStatus = 3;
				
				} else {
					$this->custInfo->webStatus = 0;
				}
	
				// tell frontend whats happening
				if(!$autologin) {
					$output[] = "$('output').innerHTML='Login erfolgreich, bitte warten...';";
					$output[] = "top.location.href='".URL_MYDATA."';";
				}
				
			} else {
				$output[] = "$('output').innerHTML='MIKOS Fehler: Benutzerdaten nicht synchron';";
				$output[] = "$('output').addClass('response_error');";
				
				// send error message to provider
				//mail(MAILTO_ERROR,'mikos error', 'Benutzer versuchte sich einzuloggen, aber Benutzerdaten waren nicht synchron:\n\n memberNumber:'.$user['memberNumber'],"From:mikos client <>\n Content-Type: text/plain; charset=UTF-8\n");
			}
		}
		
		
		$this->jsreturn($output);
	}
	
	/**
	* ends a user session
	*
	*/
	public function doLogout () {
		unset($_GET);
		unset($_COOKIE['kisALID']);
		setcookie('kisALID');
		$_SESSION['kis'] = new $this;
		header("location:".URL_LOGIN);
	}
	
	/**
	* recieves updated user  details and save them to mikos
	* 
	* @access public
	* @parameter $data expects Array containing child Array 'custInfo' containing user data
 	* @author Florian Bosselmann, <flobo@ultradigital.de>
	*/
	public function doEditMyData($data) {
		$output = array();
		$mandatory = split(",",STR_CUSTINFO_MANDATORY);
		foreach($mandatory as $field) {
			if(!$data[$field]) $output[] = "$('".$field."').addClass('redBorder').addClass('tip').title='Pflichtfeld : Bitte füllen Sie dieses Feld aus.';";
		}
		
		if($data['birthday'] && !preg_match("/^[0-9]{2}\.[0-9]{2}\.[0-9]{4}$/", $data['birthday'])) $output[] = "$('birthday').addClass('redBorder').addClass('tip').title = '".('Geburtstag : Format ist DD.MM.YYYY')."';";
		
		if (!(ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-ZäöüÄÖÜ0-9-]+\.)+([a-zA-Z]{2,4})$",$data['email'] ) ) ) {
			$output[] = "$('email').addClass('redBorder').addClass('tip').title='e-Mail :: ".REG_MSG_EMAIL_SYNTAX."';";
		}
		
		if($data['newpassword']) {
			$oldpass = $this->db->getRow("select password from customer where ID = ".$this->custInfo->localID." LIMIT 1");
			if(md5($data['oldpassword']) != $oldpass['password']) {
				$output[] = "$('oldpassword').addClass('redBorder').addClass('tip');";
			} elseif ($data['newpassword'] == "") {
				$output[] = "$('newpassword').addClass('redBorder').addClass('tip');";
			} elseif ($data['newpassword'] != $data['newpassword2']) {
				$output[] = "$('newpassword2').addClass('redBorder').addClass('tip');";
			} else {
				$setnewpassword = true;
			}
		}
		
		if($output[0]) {
			$output[] = "$('output').innerHTML='Bitte korrigieren Sie die rot markierten Felder';";
			$output[] = "$('output').addClass('response_error');";
			
		} else {
			$countries = split(",",STR_COUNTRIES);
			$data['countryName'] = $countries[$data['countryName']];
			
			unset($data['class'], $data['kis_action']);

			$changes = array();
			// append all known attributes to custInfo Object
			foreach ($data as $key => $value) {
				// check for a changed property (needed for mail further down the source code)
				if($this->custInfo->$key != $data[$key]) {
					$changes[$key] = $data[$key];
				}
				
				$this->custInfo->$key = $data[$key];
			}
			
			// is_maa is a checkbox
			$this->custInfo->is_maa = $data['is_maa'] ? 1 : 0;
			
			$update = clone $this->custInfo;
			$update->isValid = 1;
			$update->isActive = 1;

			unset($update->webSite, $update->newpassword2, $update->newpassword, $update->oldpassword, $update->kis_action, $update->class,  $update->webStatus, $update->localID);

			if($this->call('CMUpdateCustomerDetails', array('customer' => $update))) {
				// update local database
				if($setnewpassword) { $sql_password = ", password = '".md5($data['newpassword'])."'"; }
				$query = "UPDATE `customer` SET `email` = '".$this->quote_smart($data['email'])."' $sql_password WHERE `id` = '".$this->custInfo->localID."'";
				$this->db->execute($query);
                
				// send information mail to CSC  !!!!!!!  BITTE  IN  CONFIG  DATEI  VERLEGEN!!!!!!
				$mailtext  = "Das Mitglied ".$this->custInfo->firstName." ".$this->custInfo->surname." (".$this->custInfo->memberNumber.") hat seine Daten wie folgt geändert:\n\n";
				foreach( $changes as $key => $value)
				{
					$mailtext .= $key." = ".$value."\n";
				}
				$mailtext .= "\nBitte überprüfen Sie die Daten auf Logik und Format.\n";
				
				
				if(LIVE) {
					$to = "kontakt@volkswagen-club.de";
					
					$mailtext  = "Das Mitglied mit der Member Nummer ".$member['memberNumber']." hat sich soeben registriert.\n\n";
					$subject = "Das Mitglied ".$this->custInfo->memberNumber." hat seine Daten geändert";
					$from = "no-reply@vw-club.de\n Content-Type: text/plain; charset=UTF-8\n";
					
					require_once(dirname(dirname(dirname(__FILE__))).'/liquido/lib/helper/PGPMail.php');
					$mail = new PGPMail($to, $subject, $mailtext,  $from, PGP_KEY_KONTAKT);
					$mail->send();
					
					// send mail to csc
					mail ($to, $subject, $mailtext, "From: ".$from);
				}

				
				unset($data['class'], $data['kis_action']);
				
				$output[] = "$('output').innerHTML = 'Daten gespeichert.';";
				$output[] = "setTimeout(function() { $('Edit').style.display='none';  $('oldpassword').value=''; $('newpassword').value=''; $('newpassword2').value=''; $('output').innerHTML = ''; }, 1000);  ";
				$output[] = "jsobj = {'street':'".$this->custInfo->street."','houseNumber':'".($this->custInfo->houseNumber)."','zip':'".($this->custInfo->zip)."','city':'".($this->custInfo->city)."','telephone':'".($this->custInfo->telephone)."','fax':'".($this->custInfo->fax)."'};";
				foreach($data as $k => $v) { if ($k != 'is_maa') {  $output[] = "$('d_".$k."').innerHTML='".($v)."'; "; }}
				
			} else {
				$output[] = "$('output').innerHTM='Ihre Angaben konnten nicht gespeichert werden. (mikos)';";
				$output[] = "$('output').addClass('response_error');";
			}
		}
		
		$output[] = "$('output').removeClass('ajax_wait');";
		$this->jsreturn($output);
	}
	
	/**
	* creates a new car in the local database
	*
	* @access public
	* @param array $data filled with information of the car to create
 	* @author Mathias Reisch, <m.reisch@missionmedia.de>
	*/
	
	public function doCreateCar( $data ) {
		// indicates whether the car data has been entered completely or not
		$mandatory = split(",",STR_ADDCAR_MANDATORY);

		// convert possible int or boolean value to string
		$data['kmReading'] = (string) $data['kmReading'];
		
		// exclude field from mandatory list to prevent false boolean result (only if kmReading is 0)
		if( $data['kmReading'] == "0")
		{
			$key = array_search('kmReading', $mandatory);
			unset ( $mandatory[$key] );
		}
		
		foreach($mandatory as $field) {
			if(!$data[$field]) $output[] = "$('".$field."').addClass('redBorder'); \n";
		}
		
		// check license plate
		//if(!eregi("^[a-zA-ZäöüÄÖÜß]{1,3}\-{0,1}[a-zA-Z]{0,2}[ ][0-9]{1,4}[H]{0,1}$",$data['carLicenseNr'])) { $output[] = "$('carLicenseNr').addClass('redBorder').title='Kennzeichen : Bitte geben Sie ein gültiges Kennzeichen ein. (Beispiel: WOB-AB 123)'; "; }
		
		// check buildYear
		if(!ereg("^[0-9]{4}$",$data['buildYear'])) { $output[] = "$('buildYear').addClass('redBorder').title='Baujahr : Bitte geben Sie eine vierstellige Jahreszahl ein.'; "; }

		// check carvinNr
		if(!ereg("^([a-zA-Z0-9])*$",$data['carvinNr'])) { $output[] = "$('carvinNr').addClass('redBorder').title='Fahrgestellnummer : Bitte geben Sie eine korrekte Fahrgestellnummer ein.'; "; }
		
		// check odometer
		if(!ereg("^[0-9]{1,10}$",$data['kmReading'])) { $output[] = "$('kmReading').addClass('redBorder').title='Kilometerstand : Geben Sie bitte nur Zahlen ein.'; "; }

		
		// if everything went well, proceed
		if( !$output[0] ) {
			// maskiere alle Felder mysql confirm
			$query = "INSERT INTO
				`customer_cars`
			SET
				`customerID` = '".$this->custInfo->localID."',
				`carBrand` = '".$this->quote_smart($data['carBrand'])."',
				`carModel` = '".$this->quote_smart($data['carModel'])."',
				`carType` = '".$this->quote_smart($data['carType'])."',
				`carLicenseNr` = '".$this->quote_smart($data['carLicenseNr'])."',
				`kmReading` = '".$this->quote_smart($data['kmReading'])."',
				`carvinNr` = '".$this->quote_smart($data['carvinNr'])."',
				`buildYear` = '".$this->quote_smart($data['buildYear'])."'";

			// write entry to local database
			$this->db->execute($query);
			
			// get number of cars in local db
			$localcars = $this->db->getArray("select carvinNr from `customer_cars` where `customerID` = '".$this->custInfo->localID."'");
			
			// put car into customer data
			$data['ID'] = $this->db->Insert_ID();
			$data['customerID'] = $this->custInfo->localID;
			$this->myCars[] = $data;
			
			$this->smarty->assign('myCars',$this->myCars);
			$newList = $this->smarty->fetch ("myCarsList.html");
		  	$newList = str_replace("\n","",$newList);	// remove all returns for javascript
			
			$output[] = "$('myCars').innerHTML = '$newList'; ";
			$output[] = "myCarsApplyActions(); ";	// to activate row buttons
			$output[] = "$('addCar').style.display='".(count($localcars) < 5   ? 'block' : 'none')."';";
			$output[] = "$('editCar').style.display = 'none'; ";
			$output[] = "$('form_editMyCars').reset(); ";
		
		} else 	{
			$output[] = "$('output').addClass('response_error').set('html','Bitte korrigieren Sie die rot markierten Felder');";
		}

		// output notice
		$this->jsreturn($output);
		
	}


	/**
	* edit a car by id
	* 
	* @access public
	* @param array $input containing car data
	* @return javascript tag containing result message
	* @return htmllist
	* @author Florian Bosselmann, <flobo@ultradigital.de>
	*/
	public function doEditCar($data) {
		$mandatory = split(",",STR_ADDCAR_MANDATORY);
		foreach($mandatory as $field) {
			if(!$data[$field]) $output[] = "$('".$field."').toggleClass('redBorder');";
		}
		
		// check license plate
		//if(!eregi("^[a-zA-ZäÄöÖüÜ]{0,3}\-[a-zA-ZäÄöÖüÜ]{0,3} [0-9]{0,4}",$data['carLicenseNr'])) { $output[] = "$('carLicenseNr').addClass('redBorder'); "; }

		// check buildYear
		if(!ereg("^[0-9]{4}$",$data['buildYear'])) { $output[] = "$('buildYear').addClass('redBorder'); "; }

		// check carvinNr
		if(!ereg("^([a-zA-Z0-9])*$",$data['carvinNr'])) { $output[] = "$('carvinNr').addClass('redBorder'); "; }

		// check odometer
		if(!ereg("^[0-9]{0,10}$",$data['kmReading'])) { $output[] = "$('kmReading').addClass('redBorder'); "; }
			
		// if everything went well, proceed
		if( !$output[0] ) {
			$query = "UPDATE
				customer_cars
			SET
				customerID = '".$this->custInfo->localID."',
				carBrand = '".$this->quote_smart($data['carBrand'])."',
				carModel = '".$this->quote_smart($data['carModel'])."',
				carType = '".$this->quote_smart($data['carType'])."',
				carLicenseNr = '".$this->quote_smart($data['carLicenseNr'])."',
				kmReading = '".$this->quote_smart($data['kmReading'])."',
				carvinNr = '".$this->quote_smart($data['carvinNr'])."',
				buildYear = '".$this->quote_smart($data['buildYear'])."'
			WHERE 
				ID = ".$data['ID'];

			// write entry to local database
			$this->db->execute($query);
			
			// insert into myCars object
			foreach($this->myCars as $k => $car) { if($car['ID'] == $data['ID']) { $this->myCars[$k] = $data; }}
			
			$this->smarty->assign('myCars',$this->myCars);
			$newList = $this->smarty->fetch ("myCarsList.html");
		  	
			$output[] = "$('myCars').innerHTML = '".str_replace("\n","",$newList)."'; ";
			$output[] = "myCarsApplyActions();";	// to activate row buttons
			$output[] = "$('addCar').style.display='".(count($this->myCars) < 5 ? 'block' : 'none')."';";
			$output[] = "$('output').innerHTML='Änderungen gespeichert'; ";
			$output[] = "myInt = setInterval(function() { $('editCar').style.display='none'; clearInterval(myInt); },1000);  ";
			
		} 	else {
			$output[] = "$('output').set('html','Bitte korrigieren Sie die rot markierten Felder');";
		}
		
		// output notice
		$this->jsreturn($output);
		
	}
	
	/**
	* deletes a car by id
	* 
	* @access public
	* @param array $input containing int id
	* @return javascript tag containing result message
	* @author Florian Bosselmann, <flobo@ultradigital.de>
	*/
	public function doDeleteCar ($data) {
		
		if($data['id']) {		
			
			$id = substr($data['id'],4);
			$this->db->execute("delete from customer_cars where id = '".$this->quote_smart($id)."' LIMIT 1");
			
			// delete car from list - for some reason splice() didnt work properly
			// this is called schaebiger hack ;-)
			foreach($this->myCars as $car) {
				if($car['ID'] != $id) $carlist[] = $car;
			}
			
			$this->myCars = $carlist;
			$this->smarty->assign('myCars',$this->myCars);
			$newList = $this->smarty->fetch ("myCarsList.html");
		  	
			$output[] = "$('myCars').innerHTML = '".str_replace("\n","",$newList)."'; ";
			$output[] = "myCarsApplyActions();";	// to activate row buttons
			$output[] = "$('addCar').style.display='".(count($this->myCars) < 6 ? 'block' : 'none')."';";
			
			$this->jsreturn($output);
		}
	}
	
	/**
	* loads registration form into output buffer
	* output buffer availdable with $_SESSION['kis']->display();
	* @author Florian Bosselmann, <flobo@ultradigital.de>
	* @access public
	*/
	public function showRegisterForm () {
		// create random chaptcha code
		$str = "";
		$length = 5;
		
		for ($i = 0; $i < $length; $i++) {
			// this numbers refer to numbers of the ascii table (small-caps)
			$str .= chr(rand(97, 122));
		}
		$_SESSION['captcha_code'] = $str;
		
		$this->smarty->assign('countries',split(",",STR_COUNTRIES));
		$this->output = $this->smarty->fetch('registerForm.html');
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
		$this->output = $this->smarty->fetch('forgotPassword.html');
	}
	
	/**
	* loads forgotPassword form into output buffer
	* output buffer availdable with $_SESSION['kis']->display();
	* @author Florian Bosselmann, <flobo@ultradigital.de>
	* @access public
	*/
	public function showVerifyEmailForm () {
		$this->newCaptchaCode();
		$this->output = $this->smarty->fetch('verifyEmailForm.html');
	}
	
	
	public function ajax_loadSecretQuestion($data) {
		$output = array();
		if($data['checkMemberNumber']) {
			// Matze 22.01.2008
			//--------------------------
			// check if user entered the member number (9-digit) or the card number (19-digit)
			// if card number was entered, extract member number from it

			if (strlen($data['checkMemberNumber']) == 19 )
				{ $data['checkMemberNumber'] = substr($data['checkMemberNumber'],6,9);}

			if($data = $this->db->getRow("select * from customer where memberNumber = '".$this->quote_smart($data['checkMemberNumber'])."' LIMIT 1")) {
				$output[] = "$('secretQuestion').innerHTML='".$data['secretQuestion']."'; ";
				$output[] = "$('formDetails').style.display='block'; ";
				$output[] = "$('memberNumber').value='$data[memberNumber]'; ";
				$_SESSION['kisdata']['verifyEmailMember'] = $data;
			} else {
				$output[] = "$('output').innerHTML = 'Die angebenene Mitgliedsnummer ist nicht registriert.';";
				$output[] = "$('output').addClass('response_error');";
				$output[] = "$('formDetails').style.display='none'; ";
			}
		} else {
			$output[] = "$('output').innerHTML = 'Bitte geben Sie Ihre Mitgliedsnummer ein.';";
			$output[] = "$('output').addClass('response_error');";
			$output[] = "$('formDetails').style.display='none'; ";
		}
		
		$this->jsreturn($output);
	}
	
	/**
	* reset Email and send Email to member
	*
	* @param array $data containing 
	* @param string $password the password of the customer
	* @author Florian Bosselmann <flobo@ultradigital.de>
	*/
	public function doSetNewMail($data) {
		$output = array();
		$member = $_SESSION['kisdata']['verifyEmailMember'];
		
		
		if($data['secretanswer'] != $member['secretAnswer']) {
			$output[] = "$('secretanswer').addClass('redBorder');";
			$output[] = "$('secretanswer').title='geheime Antwort : Die eingebene Antwort stimmt nicht.';";
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
		
		if (!(ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-ZäöüÄÖÜß0-9-]+\.)+([a-zA-Z]{2,4})$",$data['newemail'] ) ) ) {
			$output[] = "$('newemail').addClass('redBorder').title='e-Mail : ".REG_MSG_EMAIL_SYNTAX."';";
		}
		
		if($output[0]) {
			// if an error has occured add class change of output field
			$output[] = "$('output').addClass('response_error');";
			$output[] = "$('output').innerHTML = 'Bitte prüfen Sie die markierten Felder';";
			
		} else {
			// generate new password
			$newpw = substr(md5(microtime()),0,7);
			
			// save emailaddress in database
			$this->db->execute("UPDATE `customer` SET `Email` = '$data[newemail]', `password` = '".md5($newpw)."' where ID = '$member[ID]' LIMIT 1");
			
			// and sent email with login data to email adress
			$mailtext1 = str_replace(array('<username>','<password>'),array($member['username'],$newpw),SENDPASSWORD_MAIL_USERNAME);
			$mailtext2 = str_replace(array('<username>','<password>'),array($member['username'],$newpw),SENDPASSWORD_MAIL_PASSWORD);
			
			mail($data['newemail'],SENDPASSWORD_MAIL_SUBJECT_USERNAME,$mailtext1,SENDPASSWORD_MAIL_FROM);
			mail($data['newemail'],SENDPASSWORD_MAIL_SUBJECT_PASSWORD,$mailtext2,SENDPASSWORD_MAIL_FROM);
			
			$output[] = "$('output').innerHTML='Ihre Zugangsdaten wurden soeben an Ihre E-Mail Adresse gesendet.'; ";
		}
		
		$this->jsreturn($output);
	}
	
	
	/**
	* loads login form into output buffer
	* output buffer availdable with $_SESSION['kis']->display();
	*/
	public function showLoginForm () {
		if($this->loggedIn) header("location:".URL_MYDATA);
		$this->output = $this->smarty->fetch('login.html');
	}
	
	/**
	* displays a list of the customers cars
	* template: myCars.html
	*
	* @access public
 	* @author Florian Bosselmann <flobo@ultradigital.de>
	*/
	public function showMyCars () {
		$this->requireLogin();
		$template = $this->custInfo->webStatus == 1 ? 'myCars.html' : 'webstatus_error.html';
		$this->smarty->assign( 'myCars',$this->myCars );
		$this->smarty->assign( 'numcars', count($this->myCars));
		$this->output = $this->smarty->fetch($template);
	}
	
	/**
	* loads car data into edit form
	* 
	*
	* @access public
 	* @author Florian Bosselmann <flobo@ultradigital.de>
	*/
	public function ajax_loadMyCarDetails ($data) {
		$id = substr($data['id'],5);
		
		foreach($this->myCars as $car) {
			if($car['ID'] == $id) { break; }
		}
		
		$output[] = "$('carBrand').value='".($car['carBrand'])."';";
		$output[] = "$('carModel').value='".($car['carModel'])."';";
		$output[] = "$('carType').value='".($car['carType'])."';";
		$output[] = "$('carLicenseNr').value='".($car['carLicenseNr'])."';";
		$output[] = "$('carvinNr').value='".($car['carvinNr'])."';";
		$output[] = "$('buildYear').value='".($car['buildYear'])."';";
		$output[] = "$('kmReading').value='".($car['kmReading'])."';";
		$output[] = "$('ID').value='".($car['ID'])."';";
		$output[] = "$('submit_form').value='Speichern';";
		$output[] = "$('edit_loading').style.display='none';";
		$output[] = "$('edit_content').style.display='block';";

		$this->jsreturn($output);
	}
	
	/**
	* displays a list of the customers member cards
	* template: myCards.html
	*
	* @access public
 	* @author Florian Bosselmann, <flobo@ultradigital.de>
	*/
	public function showMyCards () {
		$this->requireLogin();
		$template = $this->custInfo->webStatus == 1 ? 'myCards.html' : 'webstatus_error.html';
		$this->smarty->assign('cards',$this->myCards);
		$this->output = $this->smarty->fetch('myCards.html');
	}
	
	/**
	* displays a list of customer points and its conversion
	* template: myPoints.html
	*
	* @access public
 	* @author Florian Bosselmann, <flobo@ultradigital.de>
	*/
	public function showMyPoints () {
		$this->requireLogin();
		$this->smarty->assign('tp',$this->myPoints);
		$this->output = $this->smarty->fetch('myPoints.html');
	}
	
	/**
	* displays the customer details of the current customer 
	* template: myDetails.html
	*
	* @access public
 	* @author Florian Bosselmann, <flobo@ultradigital.de>
	*/
	public function showMyData () {
		$this->requireLogin();
		
		$template = $this->custInfo->webStatus == 1 ? 'myData.html' : 'webstatus_error.html';

		$jsobj = "{'street':'".($this->custInfo->street)."','houseNumber':'".($this->custInfo->houseNumber)."','houseNumberAdd':'".($this->custInfo->houseNumberAdd)."','zip':'".(($this->custInfo->zip))."','city':'".($this->custInfo->city)."','telephone':'".(($this->custInfo->telephone))."','mobile':'".($this->custInfo->mobile)."','fax':'".($this->custInfo->fax)."','birthday':'".($this->custInfo->birthday)."'}";
		
		$this->smarty->assign('custInfo', $this->custInfo);
		$this->smarty->assign("JSobject",$jsobj);
		$this->smarty->assign('countries',split(",",STR_COUNTRIES));
		
		$this->output = $this->smarty->fetch($template);
	}

	/**
	* displays the customers partners 
	* template: myDealer.html
	*
	* @access public
 	* @author Florian Bosselmann, <flobo@ultradigital.de>
	*/
	public function showMyDealer() {
		$template = $this->custInfo->webStatus == 1 ? 'myDealer.html' : 'webstatus_error.html';
		$this->requireLogin();

		// create jsObject of dealer list for geek functions
		$dealerFields = array('name','street','houseNumber','zip','city','telephone','fax','webSite','email');
		$jsDealerObject = 'var myDealer={';
		foreach($this->myDealer as $dealer) {
			$jsDealerObject .= "dealer".$dealer->id.":{";
			foreach($dealerFields as $field) {
				$jsDealerObject .= $field.":'".($dealer->$field)."',";
			}
			$jsDealerObject = substr($jsDealerObject,0,-1)."},";
		}
		$jsDealerObject = substr($jsDealerObject,0,-1).'};'; // cut last comma in object list
		
		
		$this->smarty->assign("jsDealerObject",$jsDealerObject);
		$this->smarty->assign('dealer',$this->myDealer);
		$this->output = $this->smarty->fetch('myDealer.html');
	}

	// /**
	// * displays the customers partners 
	// * template: myDealer.html
	// *
	// * @access public
	//  	* @author Mathias Reisch, <m.reisch@missionmedia.de>
	// */
	// public function showMyDealerDetails() {
	// 	$this->requireLogin();
	// 	
	// 	// flobo: useless query due to the fact that all infos are existing in $this->myDealer
	// 	//$dealer = $this->call('getPartnerById',array('id' => intval($_GET['pid'])));
	// 	
	// 	// flobo: find dealer in dealer list
	// 	foreach($this->myDealer as $thisdealer) {
	// 		if($thisdealer->id == $_GET['pid']) { $dealer = $thisdealer; break; }
	// 	}
	// 	
	// 	$this->smarty->assign('dealer',$dealer);
	// 	$this->output = $this->smarty->fetch('myDealerDetail.html');
	// }

	
	/**
	* displays output buffer
	*/
	public function display() {
		if($this->connected) {
			echo '<div id="floating_background"></div><div id="mikos_content">'.$this->output.'</div>';	
		} else {
			echo $this->output = $this->smarty->fetch("notConnected.html");
		}
	}
	
	 /**
	 * Prueft $this->loggedIn, wenn false wird per Header-Redirect auf die
	 * constant URL_LOGIN verwiesen
	 *
	 * @access public
	 * @author Henrik Westphal, <hwestphal@nwmgbr.de>
	 * @return void
	 */
    public function requireLogin() {
		if($this->loggedIn == false) {
			header('Location: '.URL_LOGIN);
		}
    }
	
	public function createDebugOutput($o) {
		ob_start();
		print_r($o);
		$result = '<pre>'.ob_get_contents().'</pre>';
		ob_end_clean();

		return $result;
	}
	
	/**
	* generates a javascript tag and places javascript commands submitted 
	* by input array inside
	*
	* @param
	*/
	
	private function jsreturn ($array) {
		// output notice
		if(!count($array)) return;
		echo '<script type="text/javascript">';
		if(is_array($array)) foreach($array as $action) { echo $action; }
		echo "updateTips();";
		echo '</script>'; 
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
	
	public function debug($msg) {
		echo "console.log($msg)";
	}
	
	// Quote variable to make safe
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