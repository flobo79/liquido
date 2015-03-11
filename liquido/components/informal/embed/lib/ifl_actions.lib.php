<?php

//
// functions corresponding to an action code in the get vars
//

function MY_actionAuthCheck() {
	// check if user is logged in
	if (AUTH_isLoggedIn()) {
		// check if user is allowed to this action code
		// get comma separated allowed actions from session
		$allow = $_SESSION['allow'];
		$allow_array = split(',',$allow);
		// compare allow list with get parameter
		$granted = false;
		foreach ($allow_array as $allow_item) {
			if ($allow_item == $_GET['ac']) {
				$granted = true;
				break;
			}
		}
		if ($granted == false) {
			MY_errorPage('Sorry, but you are not allowed to access this area.');
		} else if ($_GET['db']) {
			// if the user is granted access and a database id is given,
			// check if the user is allowed to access it
			$databases = $_SESSION['databases'];
			$db_array = split(',',$databases);
			// compare db list with get parameter "db"
			$granted = false;
			foreach ($db_array as $db) {
				if ($db == $_GET['db']) {
					$granted = true;
					break;
				}
			}
		}
		// when access is not allowed to this db, give an error
		// root can go ahead
		if ($granted == false && $_SESSION['group'] != 1) {
			MY_errorPage('Sorry, but you are not allowed to access this database.');
		}
	} else {
		// show login page if user is not logged in
		MY_actionLoginForm($_SERVER["HTTP_REFERER"],$_SERVER["REQUEST_URI"]);
	}
}

function MY_actionDefault() {
	// if a db id is given, show the corresponding default submission form
	// otherwise list all databases
	$db_id = intval($_GET['db']);
	if ($db_id) {
		MY_designSelect('public');
		MY_actionShowForm();
	} else {
		MY_designSelect('admin');
		MY_actionListDbs();
	}
}

function MY_actionDbAdmin() {
	// shows the database admin page
	$db_id = intval($_GET['db']);
	if ($db_id) {
		global $CURRENT_DB;
		global $CURRENT_DB_ID;
		global $cfg;
		$CURRENT_DB = $cfg['mysql']['database_prefix'] . $db_id;
		$CURRENT_DB_ID = $db_id;

		// build action urls for forms
		$form_element_add_action = '?db=' . $CURRENT_DB_ID . '&ac=daea';
		$form_element_edit_action = '?db=' . $CURRENT_DB_ID . '&ac=daee';
		$form_element_remove_action = '?db=' . $CURRENT_DB_ID . '&ac=daer';

		//fetch available form element types from database (for "add" form)
		$elements = MY_dbArrayUser("SELECT * FROM `form_element_types`");
		foreach ($elements as $e) {
			$elements_array[] = array('id' => $e['id'], 'long_name' => $e['long_name']);
		}
		
		//fetch entry form from database (for "edit" and "remove" form)
		$form = MY_fetchEntryForm();
		foreach ($form as $e) {
			$form_array[] = array('id' => $e['id'], 'name' => $e['name']);
		}
		
		//
		// build the smarty
		//
		$smarty = new MY_smarty;
		$smarty->assign('form_element_add_action',$form_element_add_action);
		$smarty->assign('available_elements',$elements_array);
		$smarty->assign('form_element_edit_action',$form_element_edit_action);
		$smarty->assign('form_element_remove_action',$form_element_remove_action);
		$smarty->assign('form_elements',$form_array);
		$content = $smarty->fetch('admin/page_start.tpl');
		
		// render the page
		MY_page('Administration Panel','informal',$content);
	} else {
		// return an error message if no database id is given
		MY_errorPage("I am sorry, my responses are limited. You must ask the right questions.");
	}
}

function MY_actionDbAdminFormElAdd() {
	global $CURRENT_DB_ID;
	global $MYSQL_INSERT_ID;
	$CURRENT_DB_ID = $_GET['db'];
	// see if the button "add" was pressed
	if ($_POST['add']) {
		// fetch form_element_types
		$query = "SELECT * FROM `form_element_types` WHERE `id` = '" . $_POST['form_element_id'] . "'";
		$form_element = MY_dbArrayUser($query);
		$form_element = $form_element[0];
		// insert row into entry_form table
		$query = "
			INSERT
				INTO `entryform`
					(`position`,`type`,`name`,`mandatory`,`options`,`public`,`test_email`)
				VALUES
					('" . $_POST['position'] . "','" . $_POST['form_element_id'] . "','" . $_POST['name'] . "','" . $_POST['mandatory'] . "','" . $_POST['options'] . "','" . $_POST['public'] . "','" . $_POST['test_email'] . "')
		";
		MY_dbQueryUser($query);
		// insert column into submissions table if field has value
		if ($form_element['with_value'] == 'Y') {
			$query = $form_element['sql'];
			$query = str_replace('RPL_entry_form_id', $MYSQL_INSERT_ID, $query);
			MY_dbQueryUser($query);
		}
		MY_redirect($_POST['referer']);
	} else if ($_POST['cancel']) {
		MY_redirect($_POST['referer']);
	} else {
		//
		// add form element
		//
		// read id from post request
		$form_element_id = $_POST['element_id'];
		
		//fetch element types from database
		$query = "
			SELECT
				*
			FROM
				`form_element_types`
			WHERE
				`id` = " . $form_element_id . "
			LIMIT 1
			";
		$element = MY_dbArrayUser($query);
		$element = $element[0];
		//
		// build smarty
		//
		$smarty = new MY_smarty;
		$smarty->assign('element_name', $element['long_name']);
		$smarty->assign('action_url', './?db=' . $CURRENT_DB_ID . '&ac=daea');
		$smarty->assign('element_options', $element['options']);
		$smarty->assign('form_element_id', $form_element_id);
		$smarty->assign('referer_url', $_SERVER["HTTP_REFERER"]);
		$content = $smarty->fetch('admin/page_add_element.tpl');
		MY_page('Administration Panel','informal',$content);
	}
}

function MY_actionDbAdminFormElEdit() {
	global $CURRENT_DB_ID;
	$CURRENT_DB_ID = $_GET['db'];
	// read id from post request
	// see if the button "ok" was pressed
	if ($_POST['ok']) {
		// build options_wddx
		$type = MY_fetchElementTypeName($_POST['el_id']);
		if ($type == 'design_text') {
			$options['data'] = array('text' => $_POST['options-text']);
			$options_wddx = MY_Array2WDDX($options);
		}
		// update row in entry_form table
		// FIXME: mysql injection calling!!
		$query = "
			UPDATE `entryform`
			SET
				`name` = '" . $_POST['name'] . "',
				`position` = '" . $_POST['position'] . "',
				`mandatory` = '" . $_POST['mandatory'] . "',
				`public` = '" . $_POST['public'] . "',
				`test_email` = '" . $_POST['test_email'] . "',
				`options_wddx` = '" . addslashes($options_wddx) . "',
				`options` = '" . $_POST['options'] . "'
			WHERE
				`id` = '" . $_POST['el_id'] . "'
			LIMIT 1
		";
		
		MY_dbQueryUser($query);
		MY_redirect($_POST['referer']);
	} else if ($_POST['cancel']) {
		// if cancel was pressed send user back to db admin
		MY_redirect($_POST['referer']);
	} else {
		// show edit form
		//fetch form from database
		$el_id = $_POST['el_id'];
		$element = MY_fetchEntryForm($el_id);
		
		//
		// create checked values
		//
		if ($element['mandatory'] == 'Y') {
			$mandatory_y_checked = ' checked="checked"';
		} else {
			$mandatory_n_checked = ' checked="checked"';
		}
		if ($element['public'] == 'Y') {
			$public_y_checked = ' checked="checked"';
		} else {
			$public_n_checked = ' checked="checked"';
		}
		if ($element['test_email'] == 'Y') {
			$check_email_y_checked = ' checked="checked"';
		} else {
			$check_email_n_checked = ' checked="checked"';
		}

		// parse options wddx
		$options = MY_WDDX2Array(stripslashes($element['options_wddx']));

		//
		// build smarty
		//
		$smarty = new MY_smarty;
		$smarty->assign('action_url','./?db=' . $CURRENT_DB_ID . '&ac=daee');
		$smarty->assign('element_name',htmlentities($element['name']));
		$smarty->assign('element_position',$element['position']);
		$smarty->assign('element_type',$element['type_name']);
		$smarty->assign('mandatory_y_checked',$mandatory_y_checked);
		$smarty->assign('mandatory_n_checked',$mandatory_n_checked);
		$smarty->assign('public_y_checked',$public_y_checked);
		$smarty->assign('public_n_checked',$public_n_checked);
		$smarty->assign('check_email_y_checked',$check_email_y_checked);
		$smarty->assign('check_email_n_checked',$check_email_n_checked);
		$smarty->assign('element_options',$element['options']);
		$smarty->assign('options',$options['data']);
		$smarty->assign('el_id',$el_id);
		$smarty->assign('referer_url',$_SERVER["HTTP_REFERER"]);

		$content = $smarty->fetch('admin/page_edit_element.tpl');
		MY_page('Administration Panel','informal',$content);
	}
}

function MY_actionDbAdminFormElRem() {
	// check if confirmed
	// remove column in submissions table if the field has value
	// fetch form_element_types
	global $CURRENT_DB_ID;
	$CURRENT_DB_ID = $_GET['db'];
	if ($_POST['yes']) {
		$query = "
			SELECT
				a.id,
				b.id,
				b.with_value
			FROM
				`entryform` as a,
				`form_element_types` as b
			WHERE
				a.id = " . $_POST['entryform_id'] . "
			AND
				a.type = b.id
			LIMIT 1
		";
		$form_element = MY_dbArrayUser($query);
		$form_element = $form_element[0];
		
		if ($form_element['with_value'] == 'Y') {
			// remove column from submissions table
			$query = "ALTER TABLE `submissions` DROP `element" . $_POST['entryform_id'] . "`";
			MY_dbQueryUser($query);
		}
		
		// remove row from entryform table
		$query = "
			DELETE
				FROM `entryform`
			WHERE `id` = '" . $_POST['entryform_id'] . "'
			LIMIT 1
		";
		MY_dbQueryUser($query);
		MY_redirect($_POST['referer']);
	} else if ($_POST['cancel']) {
		// if cancel was pressed send user back to db admin
		MY_redirect($_POST['referer']);
	} else {
		//
		// confirmation form
		//

		// build smarty
		$smarty = new MY_smarty;
		$smarty->assign('action_url','./?db=' . $CURRENT_DB_ID . '&ac=daer');
		$smarty->assign('entryform_id',$_POST["entryform_id"]);
		$smarty->assign('referer_url',$_SERVER["HTTP_REFERER"]);

		// render page
		$content = $smarty->fetch('admin/page_remove_element.tpl');
		MY_page('Administration Panel','informal',$content);
	}
}

function MY_actionDbAdminListSubmissions() {
	global $CURRENT_DB_ID;
	$CURRENT_DB_ID = $_GET['db'];
	if ($_GET['view'] != "") {
		$view = $_GET['view'];
	} else {
		$view = 1;
	}
	$order_by = $_GET['order_by'];
	// get the submissions table
	$content .= MY_listShow($view, $order_by);
	// add a back link
	$smarty = new MY_smarty;
	$smarty->assign('link','./?db=' . $CURRENT_DB_ID . '&ac=da');
	$smarty->assign('link_name','Back to admin');
	$content .= $smarty->fetch('admin/par_with_link.tpl');
	// send page to browser
	MY_page('Administration Panel','informal',$content);
}

function MY_actionDbAdminPageLists() {
	// shows the database submission lists page
	$db_id = intval($_GET['db']);
	if ($db_id) {
		global $CURRENT_DB;
		global $CURRENT_DB_ID;
		global $cfg;
		$CURRENT_DB = $cfg['mysql']['database_prefix'] . $db_id;
		$CURRENT_DB_ID = $db_id;

		//
		// collect data for admin front page
		//

		// fetch different submission view lists from db
		$lists = MY_dbArrayUser("SELECT * FROM `lists`");
		foreach ($lists as $l) {
			$link = '?db=' . $CURRENT_DB_ID . '&ac=dals&view=' . $l['id'];
			$lists_array[] = array('name' => $l['name'], 'link' => $link);
		}
		// build smarty
		$smarty = new MY_smarty;
		$smarty->assign('lists',$lists_array);
		$content = $smarty->fetch('admin/page_lists.tpl');
		// send page to browser
		MY_page('Administration Panel','informal',$content);
	} else {
		MY_errorPage('Help, no DB ID received! Someone call the police!');
	}
}

function MY_actionDbAdminPageProperties() {
	$db_id = intval($_GET['db']);
	if ($db_id) {
		global $CURRENT_DB;
		global $CURRENT_DB_ID;
		global $cfg;
		$CURRENT_DB = $cfg['mysql']['database_prefix'] . $db_id;
		$CURRENT_DB_ID = $db_id;
		// fetch form for general settings
		// FIXME: can be included in page template
		$form_general_settings = MY_formSettings(1);

		// build the smarty
		$smarty = new MY_smarty;
		$smarty->assign('form_general_settings',$form_general_settings);
		$content = $smarty->fetch('admin/page_properties.tpl');

		// render the page
		MY_page('Administration Panel','informal',$content);
	} else {
		// return an error message if no database id is given
		MY_errorPage("I am sorry, my responses are limited. You must ask the right questions.");
	}
}

function MY_actionDbAdminSubmDelete() {
	global $CURRENT_DB_ID;
	$CURRENT_DB_ID = $_GET['db'];
	if ($_POST['yes']) {
		MY_submDel(intval($_GET['id']));
		MY_redirect($_POST['referer']);
	} else if ($_POST['no']) {
		MY_redirect($_POST['referer']);
	} else {
		//
		// get user confirmation
		//

		// build smarty
		$smarty = new MY_smarty;
		$smarty->assign('action_link','./?db=' . $CURRENT_DB_ID . '&ac=dasd&id=' . $_GET['id']);
		$smarty->assign('referer_link',$_SERVER["HTTP_REFERER"]);

		// build content
		$content .= $smarty->fetch('admin/page_del_submission_confirm.tpl');
		$content .= MY_submShow(intval($_GET['id']));

		// send page to browser
		MY_page('Delete Submission','informal',$content);
	}
}

function MY_actionDbAdminSubmEdit() {
	// if submit button is pressed on edit form
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// check for missing fields
		$missing = MY_formMissing($_POST);
		$email_test_result = MY_formRunEmailTest($_POST);
		if ($missing || $email_test_result) {
			// build form html
			$form_html .= MY_formShow($_POST, $missing, $email_test_result, intval($_GET['id']));
			// build smarty
			$smarty = new MY_smarty;
			$smarty->assign('form',$form_html);
			// send page to browser
			$content .= $smarty->fetch('admin/page_submission_edit.tpl');
			MY_page('Edit Submission','informal',$content);
		} else {
			MY_formUpdate(intval($_GET['id']), $_POST);
		}
	} else {
		// if edit link has been clicked

		// fetch submission from db
		$query = "SELECT * FROM `submissions` WHERE `id` ='" . intval($_GET['id']) . "'";
		$field_values = MY_dbArrayUser($query);
		$field_values = $field_values[0];
		// pass on referer url for redirect after update
		$field_values['referer'] = $_SERVER['HTTP_REFERER'];
		// build form html
		$form_html .= MY_formShow($field_values, array() ,array() , intval($_GET['id']));
		// build smarty
		$smarty = new MY_smarty;
		$smarty->assign('form',$form_html);
		// FIXME: this would be nicer with a cancel button
		$smarty->assign('go_back_link',$_SERVER["HTTP_REFERER"]);
		$content .= $smarty->fetch('admin/page_submission_edit.tpl');
		// send page to browser
		MY_page('Edit Submission','informal',$content);
	}
}

function MY_actionDbAdminSubmView() {
	$content .= MY_submShow(intval($_GET['id']));
	if ($_GET['ml']) { // ml = mail link ;)
		// build a back link if user got here through a link in an email
		$link = './?db=' . $_GET['db'] . '&ac=da';
		$link_name = "Go to Admin";
	} else {
		$link = $_SERVER["HTTP_REFERER"];
		$link_name = "Go Back";
	}
	// build smarty
	$smarty = new MY_smarty;
	$smarty->assign('link',$link);
	$smarty->assign('link_name',$link_name);
	$content .= $smarty->fetch('admin/par_with_link.tpl');
	// send page to browser
	MY_page('Submission Details','informal',$content);
}

function MY_actionDbAdminUpdateSettings() {
	// check if submit has been pressed
	// TODO: check if all fields are filled out
	if ($_POST) {
		// update form settings
		$query = "
			UPDATE
				`entryform_settings`
			SET
				`form_name` = '" . mysql_escape_string( $_POST['form_name']) . "',
				`form_email` = '" . mysql_escape_string($_POST['form_email']) . "',
				`form_email_address` = '" . mysql_escape_string($_POST['form_email_address']) . "',
				`form_submit_label` = '" . mysql_escape_string($_POST['form_submit_label']) . "',
				`thank_you_message` = '" . mysql_escape_string($_POST['thank_you_message']) . "',
				`thank_you_url` = '" . mysql_escape_string($_POST['thank_you_url']) . "',
				`redirect` = '" . mysql_escape_string($_POST['redirect'] ). "',
				`mail2customer` = '" . mysql_escape_string($_POST['mail2customer']) . "',
				`mail2customer_returnmail` = '" . mysql_escape_string($_POST['mail2customer_returnmail']) . "',
				`mail2customer_subject` = '" . mysql_escape_string($_POST['mail2customer_subject']) . "',
				`mail2customer_sender` = '" . mysql_escape_string($_POST['mail2customer_sender']) . "',
				`mail2customer_addressfieldid` = '" . mysql_escape_string($_POST['mail2customer_addressfieldid']) . "',
				`mail2admin` = '" . mysql_escape_string($_POST['mail2admin']) . "',
				`mail2admin_returnmail` = '" . mysql_escape_string($_POST['mail2admin_returnmail']) . "',
				`mail2admin_sender` = '" . mysql_escape_string($_POST['mail2admin_sender']) . "',
				`mail2admin_subject` = '" . mysql_escape_string($_POST['mail2admin_subject']) . "'
			WHERE
				`id` = '" . intval($_POST['id']) . "'
			LIMIT 1
		";
		
		MY_dbQueryUser($query);
		// update name in db informal table
		$query = "
			UPDATE
				`databases`
			SET
				`name` = '" . mysql_escape_string($_POST['form_name']) . "'
			WHERE
				`id` = '" . $_GET['db'] . "'
			LIMIT 1
		";
		MY_dbQueryInformal($query);
		MY_redirect($_SERVER["HTTP_REFERER"]);
	} else {
		MY_errorPage('Help, I received no Post values! I think we need to talk.');
	}
}

function MY_actionInformalAdmin() {
	// get a list of informal databases on the server
	$query = "SELECT * FROM `databases` ORDER BY `id`";
	$dbs = MY_dbArrayInformal($query);
	// generate the list of databases
	foreach ($dbs as $db) {
		$databases[] = array('id' => $db['id'], 'name' => $db['name']);
	}

	// build smarty
	$smarty = new MY_smarty;
	$smarty->assign('action_url_create', './?ac=iacd');
	$smarty->assign('action_url_drop', './?ac=iadd');
	$smarty->assign('databases', $databases);
	$content = $smarty->fetch('admin/page_informal_admin.tpl');

	// send page to browser
	MY_page('Administration Panel','informal',$content);
}

function MY_actionInformalAdminCreateDb() {
	global $MYSQL_INSERT_ID;
	global $cfg;
	include_once("lib/read_dump.lib.php");
	// create entry in informal db registry
	$query = "	INSERT INTO `databases` ( `id` , `uid`, `name` )
					VALUES (
						'',
						'" . $_POST['db_uid'] . "',
						'" . $_POST['db_name'] . "'
					);";
	MY_dbQueryInformal($query);
	$new_db = $cfg['mysql']['database_prefix'] . $MYSQL_INSERT_ID;
	// create the informal db
	$query = "CREATE DATABASE `" . $new_db . "`";
	MY_dbQueryRoot($query);
	// grant permissions for informal user to new db
	$query = "GRANT SELECT , INSERT , UPDATE , DELETE , CREATE , DROP , ALTER ON `" . $new_db . "` . * TO '" . $cfg['mysql']['user_informal'] . "'@'localhost'";
	MY_dbQueryRoot($query);
	// fill new db with data
	//read sql
	$sql_file = file_get_contents('sql/db_skeleton_mysql-' . $cfg['mysql']['version'] . '.sql');
	// fill form data into sql skeleton
	$sql_file = str_replace('RPL_DATABASE_NAME', $_POST['db_name'], $sql_file);
	$sql_file = str_replace('RPL_DATABASE_EMAIL', $_POST['email'], $sql_file);
    //RPL_database_name, RPL_database_email
	// split lines into individual query strings
	$sql_lines = array();
	PMA_splitSqlFile($sql_lines, $sql_file, "");
	array_unshift($sql_lines, array("query" => "USE " . $new_db));
	// execute queries
	MY_dbQueryRoot($sql_lines);
	// redirect back to admin
	MY_redirect('./?ac=ia');
}

function MY_actionInformalAdminDropDb() {
	global $cfg;
	// confirm dropping
	if ($_POST['db_id'] && $_POST['confirmed']) {
		// drop db if db_id is given and confirmed
		$query = "DELETE FROM `databases` WHERE `id` = '" . intval($_POST['db_id']) . "' LIMIT 1";
		MY_dbQueryInformal($query);
		$old_db = $cfg['mysql']['database_prefix'] . intval($_POST['db_id']);
		// drop the informal db
		$query = "DROP DATABASE `" . $old_db . "`";
		MY_dbQueryRoot($query);
		// revoke privileges from db
		$query = "REVOKE ALL PRIVILEGES ON `" . $old_db . "` . * FROM '" . $cfg['mysql']['user_informal'] . "'@'localhost'";
		MY_dbQueryRoot($query);
		MY_redirect('./?ac=ia');
	} elseif($_POST['db_id'] && !$_POST['cancelled']) {
		// ask for confirmation when db_id is given
		// build smarty
		$smarty = new MY_smarty;
		$smarty->assign ('action_link','./?ac=iadd');
		$smarty->assign ('id',$_POST['db_id']);
		$content = $smarty->fetch('admin/page_drop_db_confirm.tpl');
		MY_page('Administration Panel','informal',$content);
	} else {
		MY_redirect('./?ac=ia');
	}
	
}

function MY_actionListDbs() {
	// get a list of informal databases on the server
	$query = "SELECT * FROM `databases` ORDER BY `id`";
	$dbs = MY_dbArrayInformal($query);
	foreach ($dbs as $db) {
		$databases[] = array('link' => './?db=' . $db['id'], 'name' => $db['name'], 'admin_link' => './?db=' . $db['id'] . '&ac=da');
	}
	// build the smarty
	$smarty = new MY_smarty;
	$smarty->assign('databases',$databases);
	$smarty->assign('informal_admin_link','./?ac=ia');
	$content = $smarty->fetch('admin/page_informal_start.tpl');
	// send page to browser
	MY_page('Show forms','Public submission forms',$content);
}

function MY_actionLogIn() {
	if ($_POST) {
		// check if cancel was pressed
		if ($_POST['cancel']) {
			MY_redirect($_POST['referer']);
		} else {
			MY_dbSetInformal();
			// check if user exists
			$user = AUTH_fetchUserData($_POST['username']);
			if ($user) {
				// check password
				if ($user['password'] == $_POST['password']) {
					// if password is correct login user
					AUTH_logIn($user);
					MY_redirect($_POST['redirect']);
				} else {
					MY_errorPage('The given password is incorrect.');
				}
			} else {
				MY_errorPage('The user name "' . $_POST['username'] . '" could not be found.');
			}
		}
	} else {
		MY_actionLogInForm('./','./');
	}
}

function MY_actionLogOut() {
	// log out a user
	AUTH_logOut($user);
	MY_redirect('./');
}

function MY_actionLoginForm($referer, $redirect) {
	// build smarty
	$smarty = new MY_smarty;
	$smarty->assign('action_link','./?ac=li');
	$smarty->assign('referer',$referer);
	$smarty->assign('redirect',$redirect);
	$content = $smarty->fetch('admin/page_login.tpl');
	// show the auth login form
	MY_page('Login','Login',$content);
}

function MY_actionShowForm() {
	// show the public form
	$content = MY_formShow(array());
	MY_page('View form','',$content);
}

function MY_actionSubmitForm() {
	// see if this request is a submitted form
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// check for missing fields
		$missing = MY_formMissing($_POST);
		$email_test_result = MY_formRunEmailTest($_POST);
		if ($missing || $email_test_result) {
			// show the informal form with errors
			$content = MY_formShow($_POST, $missing, $email_test_result);
			MY_page('Submission','',$content);
		} else {
			// insert into database
			MY_formInsert();
			// send out email if desired
			global $MYSQL_INSERT_ID;
			MY_formInsertNotification($MYSQL_INSERT_ID);
			$settings = MY_fetchFormSettings();
			// build smarty
			$smarty = new MY_smarty;
			$smarty->assign('thank_you_message', $settings['thank_you_message']);
			$smarty->assign('thank_you_url', $settings['thank_you_url']);
			$content = $smarty->fetch('public/form_thankyou.tpl');
			
			// send page to browser
			MY_page('Submission','',$content);			
		}
	} else {
		// execute default action if not post data has been received
		MY_actionDefault();
	}
}

?>
