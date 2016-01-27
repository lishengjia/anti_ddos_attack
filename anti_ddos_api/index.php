<?php

ini_set('display_errors', 'Off');
ini_set('error_reporting', E_ALL & ~E_NOTICE);

$API_ROOT = dirname(__file__);

define('DEBUG', isset($_REQUEST['debug']));
if (DEBUG) print_r($_REQUEST);

define('CLIENT_ERROR', 1);
define('SERVER_ERROR', 2);

function die_($status, $message=null) {
    header("Content-Type: application/json");

    if ($status) {
        assert(is_string($message));
        echo $rep = json_encode(Array('code' => $status,
                               'message' => $message));
        error_log("REQ: {$_SERVER['REQUEST_URI']} REP: $rep");
    } else {
        echo json_encode(Array('code' => 0,
                               'data' => $message));
    }

    exit(0);
}

$mod = $_REQUEST['mod'];
$action = str_replace('/', '_', $_REQUEST['action']);

if (!$mod || !$action) {
    header("Location: /ui/index.php", True, 301);
    exit(0);
}

$mod_file = "$API_ROOT/$mod.mod.php";

if (!file_exists($mod_file)) {
    die_(1, 'api not found');
}

require_once("$API_ROOT/config.php");

$func = "{$mod}_{$action}";
if (function_exists($func)) die_(1, 'action not allowed');
require($mod_file);

if (function_exists($func)) {
    call_user_func($func);
} else {
    die_(1, 'api not found');
}
