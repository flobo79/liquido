<?php
/**
 * ADOdb Lite Extend Module for Mysqlt
 * 
 */

eval('class mysql_extend_EXTENDER extends mysql_'. $last_module . '_ADOConnection { }');

class mysql_extend_ADOConnection extends mysql_extend_EXTENDER
{
	function &GetAssoc($sql, $inputarr=false, $force_array = false, $first2cols = false)
	{
		$data = false;
		$result =& $this->Execute($sql, $inputarr);
		if ($result) {
			$data =& $result->GetAssoc($force_array, $first2cols);
			$result->Close();
		}
		return $data;
	}

}

eval('class mysql_extend_resultset_EXTENDER extends mysql_'. $last_module . '_ResultSet { }');

class mysql_extend_ResultSet extends mysql_extend_resultset_EXTENDER
{
	function &GetAssoc($force_array = false, $first2cols = false) 
	{
		$results = false;
		
		if ($this->_numOfFields > 1) {
			$numIndex = isset($this->fields[0]);
			$results = array();
			if (!$first2cols && ($this->_numOfFields > 2 || $force_array)) {
				if ($numIndex) {
					while (!$this->EOF) {
						$results[trim($this->fields[0])] = array_slice($this->fields, 1);
						$this->MoveNext();
					}
				} else {
					while (!$this->EOF) {
						$results[trim(reset($this->fields))] = array_slice($this->fields, 1);
						$this->MoveNext();
					}
				}
			} else {
				if ($numIndex) {
					while (!$this->EOF) {
						$results[trim(($this->fields[0]))] = $this->fields[1];
						$this->MoveNext();
					}
				} else {
					while (!$this->EOF) {
						$v1 = trim(reset($this->fields));
						$v2 = ''.next($this->fields); 
						$results[$v1] = $v2;
						$this->MoveNext();
					}
				}
			}
		}
		return $results; 
	}

}
?>