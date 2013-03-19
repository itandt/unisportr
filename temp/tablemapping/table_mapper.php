<?php
// Set MIME type to JSON
// header('Content-type: application/json');

// Remove timeout limit
set_time_limit(0);

// Include the required files
require('base/error_handler.php');
require('base/data_access.php');

// Create DB handler for database maniplation
$db = new DBHandler();

// Get all sports & courses records from tables
$sports = $db->GetAllSports();
$courses = $db->GetAllCourses();

// Output sports linked courses counts stats
$sportsStats = array();

// Search for each sport in courses
foreach($sports as $sport)
{
	foreach($courses as $course)
	{
		// if sport title match with course title or description
		if ( stripos($course['title'], $sport['title']) || stripos($course['description'], $sport['title']) )
		{
			// link the sport with the course
			$db->LinkSportCourse($sport['id'], $course['id']);
			
			// update the counter
			if ( array_key_exists($sport['id'], $sportsStats) )
			{
				$sportsStats[$sport['id']]['count']++;
			}
			else
			{
				$sportsStats[$sport['id']] = array('title' => utf8_encode($sport['title']), 'category' => utf8_encode($sport['category']), 'type' => utf8_encode($sport['type']), 'count' => 1);
			}
		}
	}
}

// return the response as JSON
// echo json_encode($sportsStats);

file_put_contents('mappingresult.txt', json_encode($sportsStats));