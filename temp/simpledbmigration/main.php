<?php
$dbOptions = include __DIR__ . '/config.php';
$dbFiles = array();
$dbFiles['setup'] = include __DIR__ . '/../../config/dbsetup.php';
$dbFiles['migration'] = include __DIR__ . '/../../config/dbmigration.php';
include __DIR__ . '/functions.php';

executeSQLFiles($dbOptions, $dbFiles);
?>