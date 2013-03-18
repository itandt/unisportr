<?php
/**
 * One file or list of all files to import dammy data into the DB.
 * Works similar to the DB migration script.
 * The file(-s) has/have to be stored in /data/dumps/.
 *
 * - Add your entry at the end of this file!
 * - Rule: Every entry uses one line. This is important for merges.
 */
return array (
	// array ('file' => '%required_SQL-or-PHP-file%', 'comment' => 'optional_comment'),
	array ('file' => 'dbdummydata.sql', 'comment' => 'dummy data for developing'),
);