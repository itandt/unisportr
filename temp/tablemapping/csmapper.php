<?php
$dbOptions = include __DIR__ . '/config.php';

$query =
	'mysql' .
	' --host='		. $dbOptions['host'] .
	' --user='		. $dbOptions['user'] .
	' --password='	. $dbOptions['password'] .
	' --execute='	. '"CALL mapCoursesToSports()"' .
	' '				. $dbOptions['database'] .
	PHP_EOL
;

exec($query);