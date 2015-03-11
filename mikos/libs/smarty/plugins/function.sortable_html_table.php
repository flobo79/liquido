<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {sortable_html_table} function plugin
 *
 * Type:     function<br>
 * Name:     sortable_html_table<br>
 * Purpose:  make an sortable html table from an array of data<br>
 * Input:<br>
 *         - loop = array to loop through
 *         - cols = number of columns
 *         - rows = number of rows
 *         - table_attr = table attributes
 *         - tr_attr = table row attributes (arrays are cycled)
 *         - td_attr = table cell attributes (arrays are cycled)
 *         - trailpad = value to pad trailing cells with
 *         - vdir = vertical direction (default: "down", means top-to-bottom)
 *         - hdir = horizontal direction (default: "right", means left-to-right)
 *         - inner = inner loop (default "cols": print $loop line by line,
 *                   $loop will be printed column by column otherwise)
 *
 * Examples:
 * <pre>
 * {table loop=$data}
 * {table loop=$data cols=4 tr_attr='"bgcolor=red"'}
 * {table loop=$data cols=4 tr_attr=$colors}
 * </pre>
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @author   Henrik Westphal
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_sortable_html_table($params, &$smarty)
{
    $table_attr = 'border="1"';
    $tr_attr = '';
    $th_attr = '';
    $td_attr = '';
    $table_header = '';
    $cols = 3;
    $rows = 3;
    $trailpad = '&nbsp;';
    $vdir = 'down';
    $hdir = 'right';
    $inner = 'cols';

    if (!isset($params['loop'])) {
        $smarty->trigger_error("sortable_html_table: missing 'loop' parameter");
        return;
    }

    foreach ($params as $_key=>$_value) {
        switch ($_key) {
            case 'loop':
                $$_key = (array)$_value;
                break;

            case 'cols':
            case 'rows':
                $$_key = (int)$_value;
                break;

            case 'table_attr':
            case 'trailpad':
            case 'hdir':
            case 'vdir':
            case 'inner':
                $$_key = (string)$_value;
                break;

            case 'tr_attr':
            case 'td_attr':
            case 'th_attr':
            case 'table_header':
                $$_key = $_value;
                break;
        }
    }

    if(!empty($params['table_header'])) {
	  is_array($table_header) ? $cols = count($table_header) : $cols = 1;
	  $loop = array_merge($table_header,$loop);
	}

    $loop_count = count($loop);
    if (empty($params['rows'])) {
        /* no rows specified */
        $rows = ceil($loop_count/$cols);
    } elseif (empty($params['cols'])) {
        if (!empty($params['rows'])) {
            /* no cols specified, but rows */
            $cols = ceil($loop_count/$rows);
        }
    }
    
    $output = "<table $table_attr>\n";

    for ($r=0; $r<$rows; $r++) {
		$r == 0 ? $celltag = "th" : $celltag = "td";
		$attrarray = $celltag . "_attr";
        $output .= "<tr" . smarty_function_sortable_html_table_cycle($tag, $tr_attr, $r) . ">\n";
        $rx =  ($vdir == 'down') ? $r*$cols : ($rows-1-$r)*$cols;

        for ($c=0; $c<$cols; $c++) {
            $x =  ($hdir == 'right') ? $rx+$c : $rx+$cols-1-$c;
            if ($inner!='cols') {
                /* shuffle x to loop over rows*/
                $x = floor($x/$cols) + ($x%$cols)*$rows;
            }

            if ($x<$loop_count) {
                $output .= "<" . $celltag . smarty_function_sortable_html_table_cycle($celltag, ${$attrarray}, $c) . ">" . $loop[$x] . "</" . $celltag . ">\n";
            } else {
                $output .= "<" . $celltag . smarty_function_sortable_html_table_cycle($celltag, ${$attrarray}, $c) . ">$trailpad</" . $celltag . ">\n";
            }
        }
        $output .= "</tr>\n";
    }
    $output .= "</table>\n";
    
    return $output;
}

function smarty_function_sortable_html_table_cycle($name, $var, $no) {
    if(!is_array($var)) {
        $ret = $var;
    } else {
        $ret = $var[$no % count($var)];
    }
    
    return ($ret) ? ' '.$ret : '';
}


/* vim: set expandtab: */

?>
