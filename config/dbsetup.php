<?php
/**
 * List of all files to set up the DB in sorted order.
 * Works similar to the DB migration script.
 * The files have to be stored in /config/database/.
 *
 * - Add your entry at the end of this file!
 * - Rule: Every entry uses one line. This is important for merges.
 */
return array (
	// array ('file' => '%required_SQL-or-PHP-file%', 'comment' => 'optional_comment'),
	// Main DB structure (not working yet / to do manually)
	// array ('file' => 'unisportr.sql', 'comment' => 'main data structure'),
	// Basic data
	array ('file' => 'unisportr-basicdata_cities.sql', 'comment' => ''),
	array ('file' => 'unisportr-basicdata_universities.sql', 'comment' => ''),
	array ('file' => 'unisportr-basicdata_universities.city_id-universities.scrape.sql', 'comment' => ''),
	array ('file' => 'unisportr-basicdata_providers.sql', 'comment' => ''),
	array ('file' => 'unisportr-basicdata_weekdays.sql', 'comment' => ''),
	array ('file' => 'unisportr-basicdata_sports_sport.sql', 'comment' => ''),
	array ('file' => 'unisportr-basicdata_sports_dance.sql', 'comment' => ''),
	array ('file' => 'unisportr-basicdata_levels.sql', 'comment' => ''),
	// Stored Procedures (not working yet / to do manually)
	// array ('file' => 'mapCoursesToSport.sql', 'comment' => 'Truncates the courses_sports table and maps sports to courses.'),
	// array ('file' => 'mapCoursesToSports.sql', 'comment' => 'Maps sports to a course.'),
);