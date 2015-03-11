<?php

//
// miscellaneous informal functions
//

// set database for mysql request
function MY_dbSetUser() {
	global $cfg;
	global $CURRENT_DB;
	if ($CURRENT_DB) {
		$cfg['mysql']['database'] = $CURRENT_DB;
	} else {	
		$cfg['mysql']['database'] = $cfg['mysql']['database_prefix'] . intval($_GET['db']);
	}
	$cfg['mysql']['user'] = $cfg['mysql']['user_informal'];
	$cfg['mysql']['pass'] = $cfg['mysql']['pass_informal'];
}

// set database for mysql request
function MY_dbSetInformal() {
	global $cfg;
	$cfg['mysql']['database'] = $cfg['mysql']['database_informal'];
	$cfg['mysql']['user'] = $cfg['mysql']['user_informal'];
	$cfg['mysql']['pass'] = $cfg['mysql']['pass_informal'];
}

// set database for mysql request
function MY_dbSetRoot() {
	global $cfg;
	$cfg['mysql']['user'] = $cfg['mysql']['user_root'];
	$cfg['mysql']['pass'] = $cfg['mysql']['pass_root'];
}

// for requests to the current informal db
function MY_dbArrayUser($query) {
	MY_dbSetUser();
	return MY_dbArray($query);
}

// for requests to the informal main db
function MY_dbArrayInformal($query) {
	MY_dbSetInformal();
	return MY_dbArray($query);
}

function MY_dbQueryUser($query) {
	MY_dbSetUser();
	return MY_dbQuery($query);
}

function MY_dbQueryInformal($query) {
	MY_dbSetInformal();
	return MY_dbQuery($query);
}

function MY_dbQueryRoot($query) {
	MY_dbSetRoot();
	return MY_dbQuery($query);
}

function MY_dbSimpleArrayUser($query) {
	MY_dbSetUser();
	return MY_dbSimpleArray($query);
}

function MY_designSelect($design) {
	global $cfg;
	$cfg['design'] = $design;
}

function MY_errorPage($message) {
	$smarty = new MY_smarty;
	$smarty->assign("message", $message);
	$content = $smarty->fetch('admin/error.tpl');
	print 'MY_errorPage: ' . $message;
	#MY_page('Error','Error',$content);
}

function MY_fetchFormSettings() {
	$query = "SELECT * FROM `entryform_settings`";
	$result = MY_dbArrayUser($query);
	return $result[0];
}

function MY_fetchElementTypeName($id) {
	$query = "
		SELECT
			b.name
		FROM
			`entryform` as a
			,
			`form_element_types` as b
		WHERE
			a.id = " . $id . "
			AND
			b.id = a.type
		LIMIT 1
		";
	$result = MY_dbArrayUser($query);
	$result = $result[0]['name'];
	return $result;
}

function MY_fetchEntryForm($el_id = 0) {
	// fetch all elements or the element with the given id from the database
	if ($el_id != 0) {
		$query = "
			SELECT
				a.*
				,
				b.name as type_name
			FROM
				`entryform` as a
				,
				`form_element_types` as b
			WHERE
				a.`id` = '" . intval($el_id) ."'
				AND
				a.`type` = b.`id`
			LIMIT 1";
		$result = MY_dbArrayUser($query);
		$result = $result[0];
	} else {
		$query = "SELECT * FROM `entryform` ORDER BY `position`";
		$result = MY_dbArrayUser($query);
	}
	return $result;
}

function MY_formInsert() {
	// take $_POST apart
	$keys == "";
	$vals == "";
	foreach ($_POST as $key => $val) {
		// only use the "element" values
		if (substr_count($key, 'element')) {
			$keys .= ', `' . $key . '` ';
			$vals .= ", '" . $val . "' ";
		}
	}
	$query = "
		INSERT INTO `submissions` ( `id` , `timestamp` $keys )
		VALUES (
		'', NOW( ) $vals
		)
	";
	MY_dbQueryUser($query);
}

function MY_formInsertNotification($id) {
	global $cfg;
	$form_email = MY_getFormSetting(1, 'form_email');
	if ($form_email == 'Y') {
		$form_name = MY_getFormSetting(1, 'form_name');
		$to = MY_getFormSetting(1, 'form_email_address');
		$subject = $form_name;
		$from = $to;
		$body .= 'Hello,' . "\n";
		$body .= "\n";
		$body .= 'a new submission has been received by the database.' . "\n";
		// url parameter "ml" here stands for mail link and causes a
		// "go to admin" link to appear on the submission viewing page:
		$body .= 'Go to ' . $cfg['url']['informal'] . '?db=' . $_GET['db'] . '&ml=1&ac=dasv&id=' . $id . "\n";
		$body .= 'to view the new entry.' . "\n";
		$body .= "\n";
		$body .= 'Cheers!' . "\n";
		$header = "From:" . $from . "\n";
		mail($to, $subject, $body, $header);
	}
}

function MY_formMissing($field_values) {
	// create error catch array
	$missing = array();
	// fetch the form elements form database
	$mandatory_elements = MY_dbArrayUser("
		SELECT
			a.`id`
			,
			a.`name`
			,
			a.`position`
			,
			b.`name` as `type`
		FROM
			`entryform` as a
			,
			`form_element_types` as b
		WHERE
			a.`mandatory` = 'Y'
			AND
			b.`id` = a.`type`
			AND
			b.`with_value` = 'Y'
		ORDER BY
			`position`
		");
	// check different elements
	// first add an OK to all completed fields
	for ($i=0; $i < count($mandatory_elements); $i++) {
		foreach ($field_values as $key => $val) {
			$element_name = 'element' . $mandatory_elements[$i]['id'];
			if ($element_name == $key && $val) {
				$mandatory_elements[$i]['ok'] = true;
			}
		}
	}
	// then push all entries without an ok into the missing array
	for ($i=0; $i < count($mandatory_elements); $i++) {
		if (!$mandatory_elements[$i]['ok']) {
			array_push($missing, $mandatory_elements[$i]['id']);
		}
	}
	return $missing;
}

function MY_formRunEmailTest($field_values) {
	// create error catch array
	$result = array();
	// fetch the form elements form database
	$email_elements = MY_dbArrayUser("
		SELECT
			a.`id`
			,
			a.`position`
			,
			a.`test_email`
			,
			b.`name` as `type`
		FROM
			`entryform` as a
			,
			`form_element_types` as b
		WHERE
			a.`test_email` = 'Y'
			AND
			b.`id` = a.`type`
			AND
			b.`with_value` = 'Y'
		ORDER BY
			`position`
		");
	// check different elements
 	// when an email address is entered, check it
	// first add an OK to all correct fields
	for ($i=0; $i < count($email_elements); $i++) {
		foreach ($field_values as $key => $val) {
			$element_name = 'element' . $email_elements[$i]['id'];
			if ($element_name == $key) {
				// if the posted field is not empty run email check
				if ($val) {
					if (MY_check_email($val) == 1) {
						$email_elements[$i]['ok'] = true;
					}
				} else {
					$email_elements[$i]['ok'] = true;
				}
			}
		}
	}
	// then push all entries without an ok into the missing array
	for ($i=0; $i < count($email_elements); $i++) {
		if (!$email_elements[$i]['ok']) {
			array_push($result, $email_elements[$i]['id']);
		}
	}
	return $result;
}

function MY_formSettings($id) {
	// $id not uses yet, in future there will be different entry forms possible
	global $CURRENT_DB_ID;
	// fetch form settings from database
	$query = "SELECT * FROM `entryform_settings` WHERE `id` = '" . $id . "'";
	$settings = MY_dbArrayUser($query);
	$settings = $settings[0];
	// display the form
	$action_url = './?db=' . $CURRENT_DB_ID . '&ac=daus';
	if ($settings['form_email'] == 'Y') $form_email_y_checked = ' checked="checked"';
	if ($settings['form_email'] == 'N') $form_email_n_checked = ' checked="checked"';
	// build the smarty
	$smarty = new MY_smarty;
	$smarty->assign('action_url', $action_url);
	$smarty->assign('form_name', $settings['form_name']);
	$smarty->assign('form_email_y_checked', $form_email_y_checked);
	$smarty->assign('form_email_n_checked', $form_email_n_checked);
	$smarty->assign('form_email_address', $settings['form_email_address']);
	$smarty->assign('form_submit_label', $settings['form_submit_label']);
	$smarty->assign('thank_you_message', $settings['thank_you_message']);
	$smarty->assign('thank_you_url', $settings['thank_you_url']);
	$smarty->assign('id', $id);
	return $smarty->fetch('admin/form_general_settings.tpl');
}

function MY_formShow($field_values, $missing = array(), $email_test_result = array(), $subm_id = 0) {
	// see if in admin mode or not
	global $global_field_values;
	if ($subm_id > 0) {
		//
		// admin "edit submission"
		//
		$form_action = './?ac=dase&db=' . intval($_GET['db']) . '&id=' . $subm_id;
		// we don't want to see text fields when editing a submission
		$where_clause = "AND b.`with_value` = 'Y'";
		$submit_label = 'Update submission';
	} else {
		//
		// public form
		//
		$form_action = './?ac=xf&db=' . intval($_GET['db']);
		// hide non-public fields
		$where_clause = "AND a.`public` = 'Y'";
		$submit_label = MY_getFormSetting(1, 'form_submit_label');
	}

	// fetch the form elements form database
	$form_elements = MY_dbArrayUser("
		SELECT
			a.`id`
			,
			a.`name`
			,
			a.`options`
			,
			a.`options_wddx`
			,
			a.`position`
			,
 			a.`public`
			,
			a.`mandatory`
			,
			b.`name` as `type`
			,
			b.`html`
		FROM
			`entryform` as a
			,
			`form_element_types` as b
		WHERE
			b.`id` = a.`type`
			" . $where_clause . "
		ORDER BY
			a.`position`
		");
		
	function problemField($listProblems, $listElements, $textSingular, $textPlural) {
		if (count($listProblems) > 1) {
			$problem['description'] = $textPlural . ':' . "\n";
		}
		else {
			$problem['description'] = $textSingular . ':' . "\n";
		}
		foreach ($listProblems as $list_id) {
			foreach ($listElements as $el) {
				if ($el[id] == $list_id) {
					$problem['fields'][]['name'] = $el[name];
				}
			}
		}
		return $problem;
	}

	// add an error message if fields are not filled out
	if (count($missing) > 0) {
		$problems[] = problemField($missing, $form_elements, 'Please fill in the following field', 'Please fill in the following fields');
	}
	// add an error message if email fields are not filled out properly
	if (count($email_test_result) > 0) {
		$problems[] = problemField($email_test_result, $form_elements, 'Please enter a valid e-mail address into field', 'Please enter a valid e-mail address into fields');
	}
	// display different elements
	foreach($form_elements as $form_element) {
		$field['name'] = 'element' . $form_element['id'];
		// text block (no input)
		if ($form_element['type'] == 'design_text') {
			$field = MY_fieldTextBlock($form_element);
		}
		// text field 1 line
		if ($form_element['type'] == 'text') {
			$field = MY_fieldText($field_values, $form_element);
		}
		// text field several lines
		if ($form_element['type'] == 'textarea') {
			$field = MY_fieldTextarea($field_values, $form_element);
		}
		if ($form_element['type'] == 'radio') {
			$field = MY_fieldRadio($field_values, $form_element);
		}
		$fields[] = $field;
	}
	// build the smarty
	$smarty = new MY_smarty;
	$smarty->assign('action_url',$form_action);
	$smarty->assign('problems',$problems);
	$smarty->assign('fields',$fields);
	$smarty->assign('elements_html',$elements_content);
	$smarty->assign('referer',$field_values['referer']);
	$smarty->assign('submit_label',$submit_label);
	// return smarty html
	$content = $smarty->fetch('public/form.tpl');
	return $content;
}

function MY_fieldTextBlock($form_element) {
	$text = MY_XmlGetValue($form_element['options'], 'text');
	// transform html special characters into html again
	$text = MY_htmlspecialcharsReverse($text);
	// get values from wddx
	$options_array = MY_WDDX2Array($form_element['options_wddx']);
	if ($options_array['data']['text']) {
		$text = stripslashes($options_array['data']['text']);
	}
	// build field array
	$field['type'] = 'textblock';
	$field['text'] = $text;
	return $field;
}

function MY_fieldText($field_values, $form_element) {
	// build field array
	$field['type'] = 'text';
	$field['title'] = $form_element['name'];
	if ($form_element['mandatory'] == 'Y') {
		$field['mandatory'] = true;
	}
	$field['name'] = 'element' . $form_element['id'];
	$field['size'] = MY_XmlGetValue($form_element['options'], 'size');
	$field['maxlength'] = MY_XmlGetValue($form_element['options'], 'maxlength');
	$field['value'] = $field_values['element' . $form_element['id']];
	return $field;
}

function MY_fieldTextarea($field_values, $form_element) {
	// build field array
	$field['type'] = 'textarea';
	$field['title'] = $form_element['name'];
	if ($form_element['mandatory'] == 'Y') {
		$field['mandatory'] = true;
	}
	$field['name'] = 'element' . $form_element['id'];
	$field['cols'] = MY_XmlGetValue($form_element['options'], 'cols');
	$field['rows'] = MY_XmlGetValue($form_element['options'], 'rows');
	$field['value'] = $field_values['element' . $form_element['id']];
	return $field;
}

function MY_fieldRadio($field_values, $form_element) {
	// first get options and selcted item from db
	$buttons = MY_XmlGetArray($form_element['options'], 'option');
	// check if there is a selected radio button in the post vars
	$selected_value = $field_values['element' . $form_element['id']];
	if ($selected_value) {
		for ($i=0; $i < count($buttons); $i++) {
			if ($buttons[$i] == $selected_value) {
				$selected = $i;
				break;
			}
		}
	} else {
		// get standard selected radio button
		$selected = intval(MY_XmlGetValue($form_element['options'], 'selected')) - 1;
	}
	// loop through options and build options array
	for ($i=0; $i < count($buttons); $i++) {
		// find checked field
		if ($i == $selected) {
			$checked = true;
		} else {
			$checked = false;
		}
		$options[] = array('value' => $buttons[$i], 'label' => $buttons[$i], 'checked' => $checked);
	}

	// build field array
	$field['type'] = 'radio';
	$field['title'] = $form_element['name'];
	if ($form_element['mandatory'] == 'Y') {
		$field['mandatory'] = true;
	}
	$field['name'] = 'element' . $form_element['id'];
	$field['options'] = $options;
	return $field;
}

function MY_formUpdate($subm_id, $field_values) {
	// implode field_values
	foreach ($field_values as $key => $val) {
		// only use "element" fields
		if (substr_count($key , 'element')) {
			$updates[] =  "`" . $key . "` = '" . $val . "'";
		}
	}
	// check if there are fields to be updated first
	if (count($updates)) {
		// update fiels in database
		$updates = implode(', ', $updates);
		$query = "
			UPDATE `submissions`
			SET " . $updates . "
			WHERE
				`id` = " . $subm_id . "
			LIMIT 1
		";
		MY_dbQueryUser($query);
	}
	MY_redirect($field_values['referer']);
}

function MY_getFormSetting($form_id, $setting_name) {
	// fetch form
	$query = "SELECT * FROM `entryform_settings` WHERE `id` = '" . $form_id . "'";
	$settings = MY_dbArrayUser($query);
	$settings = $settings[0];
	return $settings[$setting_name];
}

function MY_listShow($listID, $order_by) {
	global $cfg;
	global $CURRENT_DB_ID;
	//get config
	// fetch list description from database
	$query = "SELECT * FROM `lists` WHERE `id` = " . $listID . " LIMIT 1";
	$list = MY_dbArrayUser($query);
	$list = $list[0];
	// see if list only shows mandatory fields and adjust where clause if so
	if ($list['show_only_mandatory'] == 'Y') {
		$where_addition = " AND `mandatory` = 'Y'";
	}
	// fetch entry form field names from database
	$query = "
		SELECT
			a.`id`,
			a.`name`,
			a.`name_short`,
			a.`type`,
			a.`mandatory`,
			b.`with_value`
		FROM
			`entryform` as a,
			`form_element_types` as b
		WHERE
			a.`type` = b.`id`
		AND
			b.`with_value` = 'Y'
		" . $where_addition . "
		ORDER BY
			`position`,
			`name`
		";
	$formfield_names = MY_dbArrayUser($query);
	// fetch elements to hide from db
	$elements_to_hide = MY_XmlGetArray($list['elements_to_hide'], 'el');
	//build ORDER BY statement
	if ($order_by) {
		$order_by_statement = '`element' . intval($order_by) . '`,';
	}
	// fetch submissions from database
	$query = "
		SELECT
			*,
			UNIX_TIMESTAMP(timestamp) as `timestamp`
		FROM
			`submissions`
		ORDER BY
			" . $order_by_statement . "
			`timestamp`
		";
	$subm = MY_dbArrayUser($query);
	// fetch field names from database
	$query = "DESCRIBE `submissions`";
	$subm_fields = MY_dbSimpleArrayUser($query);
	// build base hyper link
	$base = './?db=' . $_GET['db'] . '&ac=dals&view=' . $listID;
	// define submission rows
	if ($list['show_line_numbering'] == 'Y') {
		$show_line_numbering = "yes";
	}
	if ($list['show_actions'] == 'Y') {
		$show_actions = "yes";
	}
	if ($list['show_timestamp'] == 'Y') {
		$show_timestamp = "yes";
		$th_time_link = $base;
	}
	// header for elements
	foreach ($formfield_names as $f) {
		// clear f_array
		$f_array = '';
		$show = true;
		foreach ($elements_to_hide as $el) {
			if ($el == $f['id']) {
				$show = false;
			}
		}
		if ($show) {
			$f_array['link'] = $base . '&order_by=' . $f['id'];
			// show the short name if present
			if ($f['name_short']) {
				$f_array['element_name'] = $f['name_short'];
			} else {
				$f_array['name'] = $f['name'];
			}
		}
		$formfield_names_array[] = $f_array;
	}
	$line_counter = 0;
	// define table rows and check which elements are to show
	foreach ($subm as $row) {
		// clear row_array
		$row_array = '';
		$line_counter++;
		// define line numbering
		if ($list['show_line_numbering'] == 'Y') {
			$row_array['number'] = $line_counter;
		}
		// define actions
		if ($list['show_actions'] == 'Y') {
			$row_array['link_view'] = './?db=' . $CURRENT_DB_ID . '&ac=dasv&id=' . $row['id'];
			$row_array['link_edit'] = './?db=' . $CURRENT_DB_ID . '&ac=dase&id=' . $row['id'];
			$row_array['link_del'] = './?db=' . $CURRENT_DB_ID . '&ac=dasd&id=' . $row['id'];
		}
		// define timestamp
		if ($list['show_timestamp'] == 'Y') {
			$row_array['timestamp'] = date('d M y\, H:i', $row['timestamp']);
		}
		// define form fields
		foreach ($formfield_names as $f) {
			// clear f_array
			$f_array = '';
			$show = true;
			foreach ($elements_to_hide as $el) {
				if ($el == $f['id']) {
					$show = false;
				}
			}
			if ($show) {
				// strip slashes from text
				$str = stripslashes($row['element' . $f['id']]);
				$jump_destination = '#element' . $f['id'];
				// shorten text if too long
				$max_chars = $cfg['lists']['max_chars'];
				if (strlen($str) > $max_chars) $str = substr($str, 0, $max_chars) . '...';
				$f_array['link'] = './?db=' . $CURRENT_DB_ID . '&ac=dase&id=' . $row['id'] . $jump_destination;
 				$f_array['name'] = $str;
			}
			$row_array['fields'][] = $f_array;
		}
		$subm_array[] = $row_array;
	}
	
	//
	// build smarty
	//
	$smarty = new MY_smarty;
	$smarty->assign('show_line_numbering',$show_line_numbering);
	$smarty->assign('show_actions',$show_actions);
	$smarty->assign('show_timestamp',$show_timestamp);
	$smarty->assign('th_time_link',$th_time_link);
	$smarty->assign('formfields',$formfield_names_array);
	$smarty->assign('submissions',$subm_array);
	// return filled table
	return $smarty->fetch('admin/table_submissions.tpl');
}

function MY_submShow($id) {
	// fetch the form elements form database
	$query = "
		SELECT
			a.`id`
			,
			a.`name`
			,
			a.`position`
			,
			b.`name` as `type`
			,
			b.`with_value`
		FROM
			`entryform` as a
			,
			`form_element_types` as b
		WHERE
			b.`id` = a.`type`
			AND
			`with_value` = 'Y'
		ORDER BY
			a.`position`
	";
	$form_elements = MY_dbArrayUser($query);
	// fetch submission
	$query = "SELECT * FROM `submissions` WHERE `id` = " . $id . " LIMIT 1";
	$submission = MY_dbArrayUser($query);
	$submission = $submission[0];
	// define and format fields
	foreach ($form_elements as $f) {
		$fields[] = array('name' => $f['name'], 'value' => nl2br(stripslashes($submission['element' . $f['id']])));
	}
	// build smarty
	$smarty = new MY_smarty;
	$smarty->assign('fields',$fields);
	return $smarty->fetch('admin/submission_details.tpl');
}

function MY_submDel($id) {
	// delete submission form database
	$query = "DELETE FROM `submissions` WHERE `id` = '" . $id . "' LIMIT 1";
	MY_dbQueryUser($query);
}

?>