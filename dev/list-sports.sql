SELECT
	sports.id,
	sports.title,
	sports.category,
	COUNT(courses.id) AS countCourses
FROM
	sports
	JOIN courses_sports ON courses_sports.sport_id = sports.id
	JOIN courses ON courses_sports.course_id = courses.id
	JOIN allproviders ON courses.provider_id = allproviders.id
	JOIN cities ON cities.id = allproviders.city_id
WHERE
--	courses.startdate < NOW() AND
	courses.enddate > NOW() AND
	cities.name = 'München'
GROUP BY
	sports.id,
	sports.category