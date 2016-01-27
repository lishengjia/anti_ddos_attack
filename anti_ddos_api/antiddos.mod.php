<?php
require("$API_ROOT/db.php");

function antiddos_insert() {
    $appname = @mysql_escape_string($_REQUEST['appname']);
    $accesskey = @mysql_escape_string($_REQUEST['accesskey']);
    if (!$appname || !$accesskey) {
        die_(1, "'appname' and 'accesskey' is required");
    }

    $retval = db_run_sql("insert into anti_ddos(appname, accesskey) values('$appname', '$accesskey')");
    if ($retval === False) {
        die_(1, db_last_error());
    }
    if (db_affected_rows() == 0) {
        die_(1, "no records insert");
    }

    die_(0);
}


function antiddos_search() {
    $appname = @mysql_escape_string($_REQUEST['appname']);
    if (!$appname) {
        die_(1, "'appname' is required");
    }

    $data = db_get_data("select accesskey,service_status,domain_status from anti_ddos where appname='$appname'");
    if ($data === False) {
        die_(1, db_last_error());
    }

    die_(0, $data);
}


function antiddos_updateServiceStatus() {
    $appname = @mysql_escape_string($_REQUEST['appname']);
    $service_status = @mysql_escape_string($_REQUEST['service_status']);
    if (!$appname || $service_status !== "0" && $service_status !== "1") {
        die_(1, "'appname' and 'service_status' is required, 'service_status' value must be 0 or 1");
    }

    $retval = db_run_sql("update anti_ddos set service_status=$service_status where appname='$appname'");
    if ($retval === False) {
        die_(1, db_last_error());
    }
    if (db_affected_rows() == 0) {
        die_(1, "no records updated");
    }


    die_(0);
}


function antiddos_updateDomainStatus() {
    $appname = @mysql_escape_string($_REQUEST['appname']);
    $domain_status = @mysql_escape_string($_REQUEST['domain_status']);
    if (!$appname || $domain_status !== "0" && $domain_status !== "1") {
        die_(1, "'appname' and 'domain_status' is required, 'domain_status' value must be 0 or 1");
    }

    $retval = db_run_sql("update anti_ddos set domain_status=$domain_status where appname='$appname'");
    if ($retval === False) {
        die_(1, db_last_error());
    }
    if (db_affected_rows() == 0) {
        die_(1, "no records updated");
    }

    die_(0);
}

function antiddos_delete() {
    $appname = @mysql_escape_string($_REQUEST['appname']);
    if (!$appname) {
        die_(1, "'appname' is reruired");
    }

    $retval = db_run_sql("delete from anti_ddos where appname='$appname'");
    if ($retval === False){
        die_(1, db_last_error());
    }

    die_(0);
}
