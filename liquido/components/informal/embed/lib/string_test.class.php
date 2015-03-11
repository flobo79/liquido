<?php

define('INFORMAL_STRING_TEST_CLASS_PREFIX','string_test_');

class string_test
{
	var $description;
	var $name;

	function string_test()
	{
		$this->all = array('email','number');
	}

	function create($test)
	{
		$class_name = INFORMAL_STRING_TEST_CLASS_PREFIX . $test;
		$class = new $class_name;
		return $class;
	}
}

class string_test_email extends string_test
{
	function string_test_email()
	{
		$this->description = 'Check for valid email address';
		$this->name = 'email';
	}

	function test($string)
	{
		// returns true if valid email, false if not
		// 1st ereg checks if the address matches the user@domain.tld pattern
		// 2nd ereg checks for unwanted spaces
		if(ereg("^.+@.+\\..+$", $string) and !(ereg(" ",$string)))
			return true;
		else
			return false;
	}
}

class string_test_number extends string_test
{
	function string_test_number()
	{
		$this->description = 'Check for number';
		$this->name = 'number';
	}

	function test($string)
	{
		if(ereg("[0123456789]", $string))
			return true;
		else
			return false;
	}
}

?>