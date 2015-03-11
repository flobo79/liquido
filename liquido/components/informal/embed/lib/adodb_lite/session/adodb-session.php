<?php
/*
CREATE TABLE sessions (
	ID INT NOT NULL AUTO_INCREMENT, 
	SessionID VARCHAR(64), 
	session_data TEXT DEFAULT '', 
	expiry INT(11),
	expireref	VARCHAR(64)	DEFAULT '',
	PRIMARY KEY	(ID),
	INDEX SessionID (SessionID)
	INDEX expiry (expiry)
);
*/

if (!defined('_ADODB_LAYER')) {
	require_once realpath(dirname(__FILE__) . '/../adodb.inc.php');
}

if (defined('ADODB_SESSION')) return 1;

define('ADODB_SESSION', dirname(__FILE__));

class ADODB_Session {

	function sess_open($sess_path, $sess_name, $persist = null) {

		$database	= $GLOBALS['ADODB_SESSION_DB'];
		$driver		= $GLOBALS['ADODB_SESSION_DRIVER'];
		$host		= $GLOBALS['ADODB_SESSION_CONNECT'];
		$password	= $GLOBALS['ADODB_SESSION_PWD'];
		$user		= $GLOBALS['ADODB_SESSION_USER'];
		$GLOBALS['ADODB_SESSION_TBL'] = (!empty($GLOBALS['ADODB_SESSION_TBL'])) ? $GLOBALS['ADODB_SESSION_TBL'] : 'sessions';

		$db =& ADONewConnection($driver);

		if ($persist) {
			switch($persist) {
			default:
			case 'P': $result = $db->PConnect($host, $user, $password, $database); break;
			case 'C': $result = $db->Connect($host, $user, $password, $database); break;
			case 'N': $result = $db->NConnect($host, $user, $password, $database); break;
			}
		} else {
			$result = $db->Connect($host, $user, $password, $database);
		}

		if ($result)
			$GLOBALS['ADODB_SESS_CONN'] =& $db;

		return $result;
	}

	function sess_close() {
//		$db = $GLOBALS['ADODB_SESS_CONN'];
//		$db->close();
		return true;
	}

	function sess_read($sess_id) {
		$filter	= ADODB_Session::filter();
		$db = $GLOBALS['ADODB_SESS_CONN'];
		$table = $GLOBALS['ADODB_SESSION_TBL'];
		$binary = $GLOBALS['ADODB_SESSION_DRIVER'] === 'mysql' ? '/*! BINARY */' : '';
		$result = $db->execute("SELECT session_data FROM $table WHERE $binary SessionID = '$sess_id'");
		$CurrentTime = time();
		if (!$result->RecordCount()) {
			$expire_notify = $GLOBALS['ADODB_SESSION_EXPIRE_NOTIFY'];
			$notify = '';
			if (isset($expire_notify)) {
				$var = reset($expire_notify);
				global $$var;
				if (isset($$var)) {
					$notify = $$var;
				}
			}
			$db->execute("INSERT INTO $table (SessionID, expiry, expireref) VALUES ('$sess_id', $CurrentTime, '$notify')");
			return '';
		} else {
			$data = reset($result->fields);
			$filter = array_reverse($filter);
			foreach ($filter as $f) {
				if (is_object($f)) {
					$data = $f->read($data, ADODB_Session::_sessionKey());
				}
			}
			$data = rawurldecode($data);
			$db->execute("UPDATE $table SET expiry = $CurrentTime WHERE SessionID = '$sess_id'");
			return $data;
		}
	}

	function sess_write($sess_id, $data) {
		$filter	= ADODB_Session::filter();
		$db = $GLOBALS['ADODB_SESS_CONN'];
		$table = $GLOBALS['ADODB_SESSION_TBL'];
		$binary = $GLOBALS['ADODB_SESSION_DRIVER'] === 'mysql' ? '/*! BINARY */' : '';

		if (isset($GLOBALS['ADODB_SESS_LIFE'])) {
			$lifetime = $GLOBALS['ADODB_SESS_LIFE'];
		}
		else
		{
			$lifetime = ini_get('session.gc_maxlifetime');
			if ($lifetime <= 1) {
				$lifetime = 1440;
			}
		}

		$expire_notify = $GLOBALS['ADODB_SESSION_EXPIRE_NOTIFY'];
		$notify = '';
		if (isset($expire_notify)) {
			$var = reset($expire_notify);
			global $$var;
			if (isset($$var)) {
				$notify = $$var;
			}
		}

		$CurrentTime = time() + $lifetime;
		$data = rawurlencode($data);
		foreach ($filter as $f) {
			if (is_object($f)) {
				$data = $f->write($data, ADODB_Session::_sessionKey());
			}
		}
		$db->execute("UPDATE $table SET session_data = '$data', expiry = $CurrentTime, expireref = '$notify' WHERE $binary SessionID = '$sess_id'");
		return true;
	}

	function sess_destroy($sess_id) {
		$db = $GLOBALS['ADODB_SESS_CONN'];
		$table = $GLOBALS['ADODB_SESSION_TBL'];
		$binary = $GLOBALS['ADODB_SESSION_DRIVER'] === 'mysql' ? '/*! BINARY */' : '';

		$expire_notify = $GLOBALS['ADODB_SESSION_EXPIRE_NOTIFY'];
		if (isset($expire_notify)) {
			reset($expire_notify);
			$fn = next($expire_notify);
			$result =& $db->Execute("SELECT expireref, SessionID FROM $table WHERE $binary SessionID = '$sess_id'");
			if (!$result) {
				return false;
			}
			if (!$result->EOF) {
				$ref = $result->fields['expireref'];
				$key = $result->fields['SessionID'];
				$fn($ref, $key);
			}
			$result->Close();
		}

		$result =& $db->execute("DELETE FROM $table WHERE SessionID = '$sess_id'");
		if ($result) {
			$result->Close();
		}

		return $result ? true : false;
	}

	function sess_gc($sess_maxlifetime) {
		$db = $GLOBALS['ADODB_SESS_CONN'];
		$table = $GLOBALS['ADODB_SESSION_TBL'];

		$time = (isset($sess_maxlifetime)) ? $sess_maxlifetime : time();

		$expire_notify = $GLOBALS['ADODB_SESSION_EXPIRE_NOTIFY'];
		if (isset($expire_notify)) {
			reset($expire_notify);
			$fn = next($expire_notify);
			$result =& $db->Execute("SELECT expireref, SessionID FROM $table WHERE expiry < $time");
			if ($result) {
				$keys = array();
				while (!$result->EOF) {
					$ref = $result->fields['expireref'];
					$key = $result->fields['SessionID'];
					$fn($ref, $key);
					$del = $db->Execute("DELETE FROM $table WHERE SessionID='$key'");
					$result->MoveNext();
				}
				$result->Close();
			}
		} else {
			$result =& $db->Execute("DELETE FROM $table WHERE expiry < $time");
			if ($result) {
				$result->Close();
			}
		}

		$CurrentTime = time();
		$db->execute("DELETE FROM $table WHERE expiry < $CurrentTime");
		return true;
	}

	function gc($sess_maxlifetime) {
		ADODB_Session::sess_gc($sess_maxlifetime);
	}

	/*
	 * Initialize
	 */
	function _init() {
		session_module_name('user');
		session_set_save_handler(
			array('ADODB_Session', 'sess_open'),
			array('ADODB_Session', 'sess_close'),
			array('ADODB_Session', 'sess_read'),
			array('ADODB_Session', 'sess_write'),
			array('ADODB_Session', 'sess_destroy'),
			array('ADODB_Session', 'sess_gc')
		);
	}

	function filter($filter = null) {
		static $_filter = array();

		if (!is_null($filter)) {
			if (!is_array($filter)) {
				$filter = array($filter);
			}
			$_filter = $filter;
		}
		return $_filter;
	}

	function _sessionKey() {
		return crypt(ADODB_Session::encryptionKey(), session_id());
	}

	function encryptionKey($encryption_key = null) {
		static $_encryption_key = 'ADODB LITE';

		if (!is_null($encryption_key)) {
			$_encryption_key = $encryption_key;
		}
		return $_encryption_key;
	}
}

ADODB_Session::_init();

// for backwards compatability only
function adodb_sess_open($save_path, $session_name, $persist = true) {
	return ADODB_Session::sess_open($save_path, $session_name, $persist);
}

// for backwards compatability only
function adodb_sess_gc($sess_maxlifetime)
{	
	return ADODB_Session::gc($sess_maxlifetime);
}
?>