<?php

$PLATFORMPATH = dirname(__FILE__).'/../platform';

$DEFAULTAPPNAME = 'front';
$DEFAULTFCPATH = dirname(__FILE__);

if (!isset($APPNAME)) {
    $APPNAME = $DEFAULTAPPNAME;
}

if (!isset($FCPATH)) {
    $FCPATH = $DEFAULTFCPATH;
}

$PLATFORMRUN = $PLATFORMPATH.'/bootstrap/run.php';
