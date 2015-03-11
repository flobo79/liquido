<?php

/** EMAIL CLASS to send PGP encryted Emails **/

class PHPMail {
	var $to = false;
	var $from = false;
	var $frommail = '';
	var $subject = 'subject';
	var $text = '';
	var $html = '';
	var $key = false;
	var $pgppath = '/srv/gnupg/wwwrun';
	
	
	function __construct($to=false, $subject=false, $message=false, $from =false, $key=false) {
		if($to) $this->to = $to;
		if($from) $this->from = $from;
		if($subject) $this->subject = $subject;
		if($message) $this->text = $message;
		if($key) $this->key = $key;
		
		
	}
	
	public function setTo ($var) {
		if($var) {
			$this->to = $var;
		} else {
			throw new Exception('variable must not be empty');
		}
	}
	
	public function setFrom ($var) {
		if($var) {
			$this->from = $var;
		} else {
			throw new Exception('variable must not be empty');
		}
	}
	
	public function setSubject ($var) {
		if($var) {
			$this->subject = $var;
		} else {
			throw new Exception('variable must not be empty');
		}
	}
	
	public function setText ($var) {
		if($var) {
			$this->text = $var;
		} else {
			throw new Exception('variable must not be empty');
		}
	}
	
	public function setHTML ($var) {
		if($var) {
			$this->html = $var;
		} else {
			throw new Exception('variable must not be empty');
		}
	}
	
	public function setKey ($var) {
		if($var) {
			$this->html = $var;
		} else {
			throw new Exception('variable must not be empty');
		}
	}
	
	public function send() {
		
		if(!$this->from) throw new InvalidArgumentException ("From is required");
		if(!$this->to) throw new InvalidArgumentException ("To is required");
		if(!$this->key) throw new InvalidArgumentException ("Key is required");
		
		require(dirname(__FILE__)."/PGPHelper.class.php");
		$pgp = new PGPHelper($this->pgppath);
		
		
		$header = '';
		$header .= 'from:'.$this->from.($this->frommail ? ' <'.$this->frommail.'>' : '').PHP_EOL;
		
		//$header .= 'from:'.$this->from.($this->frommail ? ' <'.$this->frommail.'>' : '')."\n\r";
		
		$body = $this->text;
		
		if($this->html) {
			$random_hash = substr(0,10, md5(microtime()));
			$headers .= "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
			
			
			$body = "--PHP-alt-{$random_hash}
Content-Type: text/plain; charset=\"iso-8859-1\"
Content-Transfer-Encoding: 7bit

$body

--PHP-alt-{$random_hash}
Content-Type: text/html; charset=\"iso-8859-1\"
Content-Transfer-Encoding: 7bit

".$this->html."

--PHP-alt-{$random_hash}--

";			
			
		}
		
		mail('bosselmann@gmail.com', 'test', 'test', '');
		
		
		if(mail($this->to, $this->subject, $pgp->encrypt($this->key, $body), $header)) {
			return true;
		} else {
			throw new InvalidArgumentException('Mail could not be sent X( ');
		}
	}
}