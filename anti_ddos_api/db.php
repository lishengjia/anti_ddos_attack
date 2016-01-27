<?php

function db_get_data($sql, $name="default") {
    $result = mysql_query($sql , _db($name));

    if (!$result) {
        error_log(mysql_error() . ': ' . $sql);
        return false;
    }

    $data = Array();
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $data[] = $row;
    }

    mysql_free_result($result); 

    return $data;
}

function db_get_row($sql, $name="default") {
    $data = db_get_data($sql, $name);
    return @reset($data);
}

function db_get_var($sql, $name="default") {
    $data = db_get_row($sql, $name);
    return $data[@reset(@array_keys($data))];
}

function db_run_sql($sql, $name="default") {
    return mysql_query($sql , _db($name));
}

function db_last_id($name="default") {
    return mysql_insert_id(_db($name));
}

function db_affected_rows($name="default") {
    return mysql_affected_rows(_db($name));
}

function db_last_errno($name="default") {
    return mysql_errno(_db($name));
}

function db_last_error($name="default") {
    return mysql_error(_db($name));
}

function db_ping($name="default") {
    $i = _db($name);

    if (mysql_ping($i) == False) {
        mysql_close($i);
        unset($GLOBALS["_db_instance_$name"]);
    }

    return _db($name);
}

function _db($name='default') {
    $i = @$GLOBALS["_db_instance_$name"];
    if (!$i) {
        $c = $GLOBALS['config']['db'][$name];

        if (!$i = &mysql_connect($c['host'], $c['user'], $c['password'], true)) {
            return false;
        }

        mysql_set_charset('utf8', $i);

        if (!mysql_select_db($c['dbname'] , $i)) {
            return false;
        }

        $GLOBALS["_db_instance_$name"] = $i;
    }

    return $i;
}

