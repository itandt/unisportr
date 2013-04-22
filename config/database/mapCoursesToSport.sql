-- DELIMITER $$
-- DROP PROCEDURE IF EXISTS mapCoursesToSport$$
DROP PROCEDURE IF EXISTS mapCoursesToSport;
CREATE PROCEDURE mapCoursesToSport(sport VARCHAR(255))
	BEGIN
	DECLARE relevanceMin FLOAT;
	SET relevanceMin  = 1.000;
	
	-- find relevant courses
	DROP TEMPORARY TABLE IF EXISTS relevantcourses;
	CREATE TEMPORARY TABLE relevantcourses AS (
		SELECT
			sports.id AS sport_id, courses.id AS course_id, MATCH (coursedata.title) AGAINST (sport) AS relevance
			, sports.title AS sportTitle, courses.title AS courseTitle, courses.description AS courseDescription
		FROM
			courses
		JOIN
			coursedata ON coursedata.id = courses.coursedata_id
			AND MATCH (coursedata.title) AGAINST (sport) > relevanceMin
		LEFT JOIN
			sports ON sports.title = sport
		GROUP BY
			course_id, sport_id
	);
	
	-- save relevant courses
	REPLACE INTO
		courses_sports (
			sport_id, course_id, relevance
			, sport_title, course_title, course_description
		)
	SELECT
		sport_id, course_id, relevance
		, sportTitle, courseTitle, courseDescription
	FROM
		relevantcourses
	;

END
-- END$$
-- DELIMITER ;