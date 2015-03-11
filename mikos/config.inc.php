<?php
	
	// set whether it is live system or not
	define('LIVE', true);
	
	// Live System Config

	if(LIVE) {
		define('DEV',true);
		define('LOCALDBHOST','localhost');
		define('LOCALDBUSER','root');
		define('LOCALDBPASS','flobo');
		define('LOCALDBNAME','mikos');
		define('LOCALDBTYPE','mysql');

		define('HOST', 'http://www.vw-club.de');
		define('SECUREHOST','https://www.vw-club.de');
		//define('SOAPWSDLURL','https://192.168.15.14:8443/ClubWs/MembersWsBean?wsdl');		// OLD soap url
		//define('SOAPWSDLURL','https://192.168.55.14:8443/ClubWs/MembersWsBean?wsdl');	// NEW soap url 
		define('SOAPWSDLURL','http://192.168.55.14:8080/ClubWs/MembersWsBean?wsdl');	// NEW soap url WITHOUT SSL
	}
	
	// DEV System Config
	else
	{
		define('DEV',false);
		define('LOCALDBHOST','localhost');
		define('LOCALDBUSER','root');
		define('LOCALDBPASS','flobo');
		define('LOCALDBNAME','mikos_dev');
		define('LOCALDBTYPE','mysql');
		
		define('SOAPWSDLURL','https://85.183.240.114:8443/ClubWs/MembersWsBean?wsdl');
		define('HOST', 'http://www.baggerware.com');
		define('SECUREHOST','http://www.baggerware.com');
	}
	
	define('SMARTY_DIR',str_replace('\\','/',dirname(__FILE__)).'/libs/smarty/');
	define('ADODB_DIR',str_replace('\\','/',dirname(__FILE__)).'/libs/adodb');
	define('WEBPAGE_DIR',str_replace('\\','/',dirname(__FILE__)));
	

	
	define('LOGIN_ATTEMPTS',3);		// number of failed attempts before an account will blocked
	define('LOGIN_TIMEOUT',900);	// time in seconds an account will be blocked after too many fails
	define('REGISTER_TIMEOUT',604800);	// time in seconds the registration link will be valid ( 7 days )
	
	define('URL_MYDATA', SECUREHOST.'/?page=624');		// page to be loaded after successful login
	define('URL_LOGIN', SECUREHOST.'/?page=766');		// page with login formular displayed.
	define('URL_CPIS_LOGIN', SECUREHOST."/?page=1001");	// page for cpis login form
	define('URL_CPIS_START', SECUREHOST.'/?page=709');	// page to be loaded after successful login into cpis
	
	define('STR_COUNTRIES','Deutschland,Österreich,Schweiz');	// to use in templates
	define('STR_CUSTINFO_MANDATORY', 'street,houseNumber,zip,city,email'); // fields to be present when saving user details
	define('STR_PARTNERDATA_MANDATORY', 'telephone,email'); // fields to be present when saving user details
	define('STR_ADDCAR_MANDATORY', 'carBrand,carModel,carType,carLicenseNr,carvinNr,buildYear,kmReading'); // fields to be present when adding a car
	define('STR_EMPLOYEE_MANDATORY', 'firstname,surname,phone,email,secretQuestion,secretAnswer,username');

	define('STR_MEMBER_MANDATORY', 'firstname,surname,street,houseNumber,zip,city,phone,contracttype');
	define('STR_MEMBERCAR_MANDATORY', '');
  define('STR_MEMBERLIST_MANDATORY', 'street,zip,city');	
	define('MAILTO_ERROR','');
	
	// email to sent account data to kis member
	define('SENDPASSWORD_MAIL_USERNAME',"Hier erhalten Sie Ihren Benutzernamen:\n
Ihr Benutzername lautet: <username>\n
Diese E-Mail wurde automatisch generiert. Bitte antworten Sie nicht darauf!");
	
	define('SENDPASSWORD_MAIL_PASSWORD',"Hier erhalten Sie Ihr Passwort:\n
Ihr Passwort lautet: <password>\n
Merken Sie sich dieses Passwort gut und geben Sie es nicht an Dritte weiter. Der Volkswagen Club wird Sie niemals nach Ihrem Passwort fragen!\n
Diese E-Mail wurde automatisch generiert. Bitte antworten Sie nicht darauf!");
	
	define('SENDPASSWORD_MAIL_SUBJECT_PASSWORD','Ihr Passwort');
	define('SENDPASSWORD_MAIL_SUBJECT_USERNAME','Ihr Benutzername');
	define('SENDPASSWORD_MAIL_FROM', "From: Volkswagen Club <no-reply@vw-club.de>\nMime-Version: 1.0\n Content-Type: text/plain; charset=utf-8\n");
	
	// email to sent registration email to kis member
	define('REG_MAIL_FROM', "From: Volkswagen Club <no-reply@vw-club.de>\nMime-Version: 1.0\n Content-Type: text/plain; charset=utf-8\n");
	define('REG_MAIL_SUBJECT', 'Kundenkonto Aktivierung');
	define('REG_MAIL_TEXT', "Vielen Dank, dass Sie sich für den Volkswagen Club registriert haben. 
Um Ihre Registrierung abzuschliessen, klicken Sie bitte auf den nachfolgenden Link. Einige E-Mail Programme brechen lange Zeilen um. 
Sollte dies bei Ihnen der Fall sein, kopieren sie bitte den vollständigen Link in die Adresszeile Ihres Browsers und rufen Sie sie auf.\n\n
".HOST."/?page=997&hashid=<hashid> \n\n
Diese E-Mail wurde automatisch generiert. Bitte antworten Sie nicht darauf!");
	
	// kis register messages
	define('REG_MSG_STILL_REGISTERED','Sie haben sich bereits registriert. Bitte aktivieren Sie Ihren Account, in dem Sie auf den Link in der E-Mail klicken!');
	define('REG_MSG_ACTIVATE_ACCOUNT','Sie haben sich bereits registriert. Bitte aktivieren Sie Ihren Account, in dem Sie auf den Link in der E-Mail klicken!');
	define('REG_MSG_MEMBERID_UNKNOWN', 'Die angegebene Mitgliedsnummer ist nicht registriert.');
	define('REG_MSG_COMPLETE', "Überprüfung abgeschlossen. Sie werden sofort eine Bestätigungs-E-Mail erhalten.");
	define('REG_MSG_MEMBERID','Bitte geben Sie Ihre Mitglieds-Nummer an, Sie finden Sie auf Ihrer Volkswagen Club Karte.');
	define('REG_MSG_EMAIL','Ihre E-Mail Adresse wird für den Anmeldeprozess benötigt');
	define('REG_MSG_EMAIL_SYNTAX','Eine E-Mail-Adresse muss dem regulären Format entsprechen.');
	define('REG_MSG_USERNAME','Bitte verwenden Sie einen eindeutigen Benutzernamen.');
	define('REG_MSG_USERNAME_GONE','Der gewählte Benutzername ist bereits vergeben.');
	define('REG_MSG_PASSWORD','Bitte wählen Sie ein sicheres Password.');
	define('REG_MSG_PASSWORD_TWICE', 'Das bitte geben Sie das Password noch einmal ein.');
	define('REG_MSG_CAPTCHA_INCORRECT','Der eingegebene Sichtcode ist inkorrekt.');
	define('REG_MSG_SECRETQUESTION', 'Bitte geben Sie eine geheime Frage ein.');
	define('REG_MSG_SECRETANSWER', 'Bitte geben Sie eine geheime Antwort ein.');
	
	define('STR_MAIL_FROM','Volkswagen Club');
	define('STR_MAIL_RETURN', "no-reply@vw-club.de");
	define('STR_USERDATA_SENT','Ihre Zugangsdaten wurden soeben an Ihre E-Mail-Adresse gesendet.');
	define('STR_NO_ACCOUNT_FOUND','Es existiert kein Kundenkonto mit den eingegebenen Informationen.');
	define('STR_USERDATA_MAIL_PASSWORD',"Ihr Passwort lautet: <password>\n\nDer Volkswagen Club wird Sie niemals nach Ihrem Passwort fragen!\n\nDiese E-Mail wurde automatisch generiert. Bitte beantworten Sie sie nicht!");
	define('STR_USERDATA_MAIL_USERNAME',"Ihr Benutzername lautet: <login>\n\nDiese E-Mail wurde automatisch generiert. Bitte beantworten Sie sie nicht!");
	define('STR_SUBJECT_LOGINDATA_PASSWORD', 'Ihr Passwort');
	define('STR_SUBJECT_LOGINDATA_USERNAME', 'Ihr Benutzername');
	
	// CPIS doForgotPassword
	define('STR_CPIS_MAIL_PASSWORD',"Ihr Passwort lautet: <password>\n\nDer Volkswagen Club wird Sie niemals nach Ihrem Passwort fragen!\n\nDiese E-Mail wurde automatisch generiert. Bitte beantworten Sie sie nicht!");
	define('STR_CPIS_MAIL_USERNAME',"Ihr Benutzername lautet: <login>\n\nDiese E-Mail wurde automatisch generiert. Bitte beantworten Sie sie nicht!");
	define('SENDPASSWORD_MAIL_TEXT', "Ihre Zugangsdaten lauten:\n\nLogin: <username>\nPasswort: <password>\n\nIhr Volkswagen Club");
	define('SENDPASSWORD_MAIL_SUBJECT', 'Ihre Zugangsdaten');
	define('SENDPASSWORD_MAIL_FROM','From: Volkswagen Club <>');
	
	// CPIS Create Member Notice
	DEV ? define('CPIS_CREATE_MEMBER_NOTICE_TO','kontakt@volkswagen-club.de') : define('CPIS_CREATE_MEMBER_NOTICE_TO','bosselmann@gmail.com');
	define('CPIS_CREATE_MEMBER_NOTICE_SUBJECT','Mitgliedereinmeldung von Händler ');
	define('CPIS_CREATE_MEMBER_NOTICE_TEXT','Bitte aktivieren Sie diese Mitgliedschaft durch Zuordnung der Betreuungsart.');
	define('CPIS_MEMBER_REQUST_DEBUG','bosselmann@gmail.com');
	
	//PGP Encrypted Emails
	define('PGP_KEY_KONTAKT', 'C2F83A1CC414468E9CFCE33B5AC6945568CD683B');
	define('PGP_KEY_PARTNERBETREUUNG', '677BBA517735F48592CCDADC693C1DCBDA8F7F76');
?>