<?php
/**
 * List of all files to set up the DB in sorted order.
 * Works similar to the DB migration script.
 * The Files have to be storen in /config/database/.
 *
 * - Add your entry at the end of this file!
 * - Rule: Every entry uses one line. This is important for merges.
 */
return array (
	// array ('file' => '%required_SQL-or-PHP-file%', 'comment' => 'optional_comment'),
	array ('file' => 'unisportr.sql', 'comment' => 'main data structure'),
	array ('file' => 'unisportr-basicdata_cities.sql', 'comment' => ''),
	array ('file' => 'unisportr-basicdata_universities.sql', 'comment' => ''),
	array ('file' => 'unisportr-basicdata_universities.city_id-universities.scrape.sql', 'comment' => ''),
	array ('file' => 'unisportr-basicdata_providers.sql', 'comment' => ''),
	array ('file' => 'unisportr-basicdata_weekdays.sql', 'comment' => ''),
	array ('file' => 'unisportr-basicdata_sports_sport.sql', 'comment' => ''),
	array ('file' => 'unisportr-basicdata_sports_dance.sql', 'comment' => ''),
	array ('file' => 'unisportr-basicdata_levels.sql', 'comment' => ''),
);