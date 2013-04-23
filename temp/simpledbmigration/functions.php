<?php
function executeSQLFiles(array $dbOptions, array $dbFiles) {
	// open connection
	$dbConnection = mysqli_connect($dbOptions['host'], $dbOptions['user'], $dbOptions['password'], $dbOptions['database']);
	if (mysqli_connect_errno($dbConnection)) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error($dbConnection) . PHP_EOL;
	}
	/* change character set to utf8 */
	if (!mysqli_set_charset($dbConnection, "utf8")) {
		printf("Error loading character set utf8: %s\n", mysqli_error($dbConnection));
	} else {
		// printf("Current character set: %s\n", mysqli_character_set_name($dbConnection));
	}
	// db setup
	executeSQLFileList($dbConnection, $dbFiles['setup']);
	// db dummy data
	executeSQLFileList($dbConnection, $dbFiles['dummydata']);
	// db migration
	executeSQLFileList($dbConnection, $dbFiles['migration']);
	// close connection
	mysqli_close($dbConnection);
}

function executeSQLFileList($dbConnection, array $dbFileList) {
	foreach ($dbFileList as $listItem) {
		$query = file_get_contents(__DIR__ . '/../../config/database/' . $listItem['file']);
		if (mysqli_multi_query($dbConnection, $query)) {
			do {
				$result = mysqli_store_result($dbConnection);
				if (mysqli_connect_error($dbConnection)) {
					var_dump($result);
					echo $listItem['file'] . ': ' . mysqli_error($dbConnection) . PHP_EOL;
				} else {
					echo 'query' . ' ' . 'OK' . PHP_EOL;
				}
				if (mysqli_more_results($dbConnection)) {
					echo '-----------------' . PHP_EOL;
				}
			} while (mysqli_next_result($dbConnection));
			echo $listItem['file'] . ' ' . 'OK' . PHP_EOL;
			echo '=================' . PHP_EOL;
		} else {
			echo $listItem['file'] . ': ' . mysqli_error($dbConnection) . PHP_EOL;
		}
	}
}