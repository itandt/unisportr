<?php
require('database.config.php');

class DBHandler
{
	private $db;
	
	public function __construct()
	{
		$this->db = new mysqli(DBConfig::server, DBConfig::user, DBConfig::password, DBConfig::database);
		$this->db->query("SET NAMES 'utf8'");
		$this->db->set_charset("utf8");
		#mysql_set_charset('utf8');
	}
	
	// for Table Mapper : Sports & Courses linking
	
	public function GetAllSports()
	{
		$sports = array();
		$result = $this->db->query("SELECT id, title, category, type FROM sports");
		while ($row = $result->fetch_assoc())
		{
			$sports[] = array('id' => $row['id'], 'title' => $row['title'], 'category' => $row['category'], 'type' => $row['type']);
		}
		return $sports;
	}
	
	public function GetAllCourses()
	{
		$courses = array();
		$result = $this->db->query("SELECT id, title, description FROM courses");
		while ($row = $result->fetch_assoc())
		{
			$courses[] = array('id' => $row['id'], 'title' => $row['title'], 'description' => $row['description']);
		}
		return $courses;
	}
	
	public function LinkSportCourse($sportId, $courseId)
	{
		$result = $this->db->query("INSERT into courses_sports(course_id, sport_id) VALUES ('$courseId', '$sportId')");
		return $result;
	}
	
	
}