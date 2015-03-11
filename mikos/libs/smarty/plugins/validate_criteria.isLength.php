<?php

/**
 * Project:     SmartyValidate: Form Validator for the Smarty Template Engine
 * File:        validate_criteria.isLength.php
 * Author:      Monte Ohrt <monte at newdigitalgroup dot com>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @link http://www.phpinsider.com/php/code/SmartyValidate/
 * @copyright 2001-2005 New Digital Group, Inc.
 * @author Monte Ohrt <monte at newdigitalgroup dot com>
 * @package SmartyValidate
 * @version 2.4
 */

/**
 * test if a value is a valid range
 *
 * @param string $value the value being tested
 * @param boolean $empty if field can be empty
 * @param array params validate parameter values
 * @param array formvars form var values
 */
function smarty_validate_criteria_isLength($value, $empty, &$params, &$formvars) {

        if(isset($params['field2'])) {
            $_min = $params['field2'];
        } elseif($isset($params['min'])) {
            $_min = $params['min'];   
        } else {
            $_min = -1;   
        }

        if(isset($params['field3'])) {
            $_max = $params['field3'];
        } elseif($isset($params['max'])) {
            $_max = $params['max'];   
        } else {
            $_max = -1;   
        }

        $_length = strlen($value);
                
        if(($_min == -1 || $_length >= $_min) && ($_max == -1 || $_length <= $_max))
            return true;
        elseif($_length == 0)
            return $empty;
        else
            return false;
}

?>
