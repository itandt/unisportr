SELECT
	courses.id,
	courses.title,
	DATE_FORMAT(courses.startdate, "%e\.%m\.%Y") AS startDate,
	DATE_FORMAT(courses.enddate, "%e\.%m\.%Y") AS endDate,
	DATE_FORMAT(courses.starttime, "%H\:%i") AS startTime,
	DATE_FORMAT(courses.endtime, "%H\:%i") AS endTime,
	allproviders.displayedname AS providerName,
	allproviders.providertype AS providerType,
 	cities.name AS cityName,
 	sports.title AS sportTitle,
	weekdays.labelde AS weekday,
 	levelsmin.usrlevel AS usrLevelMin,
 	levelsmin.unilevel AS uniLevelMin,
 	levelsmax.usrlevel AS usrLevelMax,
 	levelsmax.unilevel AS uniLevelMax
FROM
	courses
JOIN allproviders ON courses.provider_id = allproviders.providerid
JOIN cities ON allproviders.city_id = cities.id
JOIN courses_sports ON courses_sports.course_id = courses.id
JOIN sports ON courses_sports.sport_id = sports.id
JOIN weekdays ON courses.weekday_id = weekdays.id
LEFT JOIN levels AS levelsmin ON courses.levelmin_id = levelsmin.id
LEFT JOIN levels AS levelsmax ON courses.levelmax_id = levelsmax.id
WHERE
	cities.name = 'Berlin' AND
	sports.title = 'Salsa'
GROUP BY
	courses.id