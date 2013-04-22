DELIMITER $$
DROP PROCEDURE IF EXISTS mapCoursesToSports$$
CREATE PROCEDURE mapCoursesToSports()
	BEGIN
	DECLARE sportTitle VARCHAR(255);
	-- DECLARE test VARCHAR(1000000);
	DECLARE sportsFetched BOOLEAN;
	DECLARE cursorSports CURSOR FOR SELECT title FROM sports WHERE title IS NOT NULL;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET sportsFetched = TRUE;
	-- SET test = '';
	SET sportsFetched = FALSE;
	
	TRUNCATE TABLE courses_sports;
	
	OPEN cursorSports;
	sportsLoop: LOOP
		FETCH cursorSports INTO sportTitle;
			-- SET test = CONCAT(test, sportTitle, ',');
			CALL mapCoursesToSport(sportTitle);
		IF sportsFetched THEN
			LEAVE sportsLoop;
		END IF;
	END LOOP sportsLoop;
	CLOSE cursorSports;
	
	-- SELECT test;
	
END$$
DELIMITER ;