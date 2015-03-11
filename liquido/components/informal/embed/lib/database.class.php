<?php

class database
{
    var $connection;

    function database()
    {
        $this->connection = ADONewConnection(INFORMAL_DATABASE_DSN)
            or error('Could not establish database connection.');
    }

    function debug()
    {
        $this->connection->debug = true;
    }
    
    function delete_row($table, $id)
    {
        // build query
        $query = "DELETE FROM `" . $this->table_name($table)
            . "` WHERE `id` = " . intval($id) . " LIMIT 1";

        // execute query
        $this->connection->Execute($query);
    }

    function fetch_field($table, $id, $field)
    {
        $query = "SELECT `$field` FROM `" . $this->table_name($table)
            . "` WHERE `id` = '$id' LIMIT 1";
        $row = $this->connection->GetArray($query);
        $field_value = $row[0][$field];
        return $field_value;
    }

    function fetch_rows($table, $columns = false, $sort_column = false, $where_col = false, $where_val = false)
    {
        // build columns string
        if ($columns) {
            $columns_string = implode($columns, ',');
        } else {
            $columns_string = '*';
        }
        
		if($where_col and $where_val) {
			$where = " WHERE ".$where_col." = '$where_val'";
		}
		
        // build sort string
        if ($sort_column) {
            $sort = " ORDER BY `" . $sort_column . "`";
        }
        
        $query = "SELECT $columns_string FROM `"
            . $this->table_name($table) . "`" . $sort.$where;

        $this->connection->SetFetchMode(ADODB_FETCH_ASSOC);
        $rows = $this->connection->GetArray($query);
        return $rows;
    }

    function insert_row($table, $fields)
    {
        // build field name/value strings
        foreach($fields as $key => $value) {
            $field_names .= ", `" . $key . "`";
            $field_values .= ", '" . $value . "'";
        }
        
        // build query string
        $query = "INSERT INTO `"
            . $this->table_name($table)
            . "` (`id`"
            . $field_names
            . ") VALUES (''"
            . $field_values
            . ")";
        
        // execute query
        $this->connection->Execute($query);

        // return last insert id
        return $this->connection->Insert_ID();
    }

    function table_name($table)
    {
        return INFORMAL_DATABASE_TABLE_PREFIX . $table;
    }

    function update_row($table, $id, $fields)
    {
        foreach($fields as $key => $value) {
            $field_values[] = "`" . $key . "` = '" . addslashes($value)
                . "'";
        }
        $field_values = implode($field_values, ', ');
        $query = "UPDATE `" . $this->table_name($table)
            . "` SET " . $field_values . " WHERE `id` = '$id' LIMIT 1";
        $this->connection->Execute($query);
    }

    function write_field($table, $id, $field, $value)
    {
        $query = "UPDATE `" . $this->table_name($table)
            . "` SET `$field` = '$value' WHERE `id` = '$id' LIMIT 1";
        $row = $this->connection->Execute($query);
    }

}

?>
