<?php

//
// a smarty class with local configuration
//
class MY_smarty extends Smarty {
    function MY_smarty() {
        // use existing smarty object if present
        $this->Smarty();
		
        $this->compile_dir = INFORMAL_FILEROOT
            . INFORMAL_SMARTY_COMPILE;
        $this->cache_dir = INFORMAL_FILEROOT
            . INFORMAL_SMARTY_CACHE;

        $this->template_dir = INFORMAL_FILEROOT . 'themes/default';
        return $this;
    }
}

//
// reverses the htmlspecialchars effect
//
function MY_htmlspecialcharsReverse($encoded) {
    $trans = array_flip(get_html_translation_table(HTML_ENTITIES));
    $decoded = strtr($encoded, $trans);
    return $decoded;
}

//
// function for checking if an email address is valid
//
// heavily inspired by http://www.phpfreaks.com/quickcode/function_to_check_for_valid_email_address/83.php
// thanks!
//
function MY_check_email($str) {
    // returns 1 if valid email, 0 if not
    // 1st ereg checks if the address matches the user@domain.tld pattern
    // 2nd ereg checks for unwanted spaces
    if(ereg("^.+@.+\\..+$", $str) and !(ereg(" ",$str)))
        return 1;
    else
        return 0;
}

//
// render a page
//
function MY_page($title, $headline, $content) {
    global $cfg;
    // fetch design (admin/public) which has been set by index.php
    // depending on action code in url
    $design = $cfg['design'];
    // append section name to page title
    $title .= $cfg['page']['title_suffix'];
    // build page headline
    if ($headline == "") {
        $headline = MY_getFormSetting(1, 'form_name');
    }
    $css_link = $cfg['path']['webroot'] . 'themes/default/' . $design . '/styles.css';
    //
    // admin specific settings
    //
    if ($design == 'admin') {
        if (AUTH_isLoggedIn()) {
            $username = $_SESSION['username'];
            $logout_link = './?ac=lo';
            if ($_GET['db']) {
                // build admin menu
                $menu_items[] = array('title' => 'Admin Home','link' => './?db=' . $_GET['db'] . '&ac=da');
                $menu_items[] = array('title' => 'View Submissions','link' => './?db=' . $_GET['db'] . '&ac=dapl');
                $menu_items[] = array('title' => 'Form Editor','link' => './?db=' . $_GET['db'] . '&ac=dapf');
                $menu_items[] = array('title' => 'Properties','link' => './?db=' . $_GET['db'] . '&ac=dapp');
                $menu_items[] = array('title' => 'Exit Admin','link' => './');
            }
        } else {
            $login_link = './?ac=li';
        }
    }
    // build smarty
    $smarty = new MY_Smarty;
    $smarty->assign('title',$title);
    $smarty->assign('css_link',$css_link);
    $smarty->assign('headline',$headline);
    $smarty->assign('content', $content);
    $smarty->assign('username',$username);
    $smarty->assign('logout_link', $logout_link);
    $smarty->assign('menu_items', $menu_items);
    $smarty->assign('login_link', $login_link);
    $smarty->display($design . '/page.tpl');
    // end session management if sessions are used
    if ($cfg['sessions']['used']) {
        session_write_close();
    }
    exit();
}

//
// redirect() - redirect browser to an url
// (doesn't work if a header has been sent already)
//
// usage: MY_redirect(<url>)
//
function MY_redirect($url)
{
    header("Location: $url");
}

function MY_Array2WDDX($var) {
    $packet = wddx_packet_start();
    wddx_add_vars($packet,"var");
    $wddx = wddx_packet_end($packet);
    return $wddx;
}

function MY_WDDX2Array($wddx) {
    $var = wddx_deserialize($wddx);
    return $var['var'];
}

//
// MY_XmlGetArray() - transforms parts of an XML stream into an array
//
// usage: MY_XmlGetArray(<XML_stream>, <name_of_array_elements>)
// all "complete" fields named name_of_array_elements will be pushed into
// an array
//
// the xml needs to look like this (name_of_array_elements would be "el"):
// <elements>
// <el>value 1</el>
// <el>value 2</el>
// </elements>
//
function MY_XmlGetArray($xml_input, $name) {
    $xml_parser = xml_parser_create();
    xml_parse_into_struct($xml_parser, $xml_input, $xml_vals, $index);
    xml_parser_free($xml_parser);
    // initialise the return array
    $result = array();
    // transform xml into array (partly)
    foreach ($index as $key => $val) {
        if ($key == strtoupper($name)) {
            foreach ($val as $inner_key => $inner_val) {
                if ($xml_vals[$inner_val]['type'] == 'complete') {
                    array_push($result, $xml_vals[$inner_val]['value']);
                }
            }
        }
    }
    return $result;
}

//
// MY_XmlGetValue() - returns the value of a tag in an XML stream
// (case-insensitive, no levels recognised)
//
// usage: MY_XmlGetValue(<XML_stream>, <tag>)
//
function MY_XmlGetValue($xml_input, $tag) {
    $xml_parser = xml_parser_create();
    xml_parse_into_struct($xml_parser, $xml_input, $xml_vals, $index);
    xml_parser_free($xml_parser);
    foreach ($xml_vals as $xml_val) {
        if ($xml_val['type'] == 'complete' && strtoupper($xml_val['tag']) == strtoupper($tag)) {
            return $xml_val['value'];
        }
    }
}

//
// debug() - prints a variable/array in pretty debug output
//
// usage: debug(<variable/array>)
//
function debug($var)
{
    print '<div style="background-color: #FFCCAA; font-size:10px; padding:3px; margin:2px">' . "\n";
    print "<b>DEBUG OUTPUT</b>\n";
    print "<pre>\n";
    print_r($var);
    print "</pre>\n";
    print "</div>";
}

//
// error() - prints low level error messages
//
// usage: error(<message>)
//
function error($message)
{
    print '<html>' . "\n";
    print '<body>' . "\n";
    print 'Fatal Informal error: ' . $message;
    print "</body>\n";
    print '</html>' . "\n";
    die();
}

?>
