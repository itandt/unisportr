<?php
function executeSQLFiles(array $dbOptions, array $dbFiles) {
	$dbConnection = mysql_connect($dbOptions['host'], $dbOptions['user'], $dbOptions['password']);
	if (!$dbConnection) {
		die('Verbindung nicht möglich : ' . mysql_error());
	}
	mysql_select_db($dbOptions['database'], $dbConnection);
	// db setup
	foreach ($dbFiles['setup'] as $listItem) {
		$query = file_get_contents(__DIR__ . '/../../config/database/' . $listItem['file']);
		$result = mysql_query($query);
		if (!$result) {
			die($listItem['file'] . ': ' . 'Ungültige Anfrage: ' . mysql_error() . PHP_EOL);
		} else {
			echo $listItem['file'] . ' ' . 'OK' . PHP_EOL;
		}
	}
	// db migration
}