SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `levels`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `levels` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `levels` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `unilevel` VARCHAR(50) NOT NULL ,
  `usrlevel` ENUM('1','2','3') NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `unilevel_UNIQUE` (`unilevel` ASC) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `providers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `providers` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `providers` (
  `id` INT NOT NULL ,
  `type` ENUM('university', 'partner') NOT NULL ,
  `providerid` INT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `weekdays`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `weekdays` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `weekdays` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `labelen` VARCHAR(50) NULL ,
  `shortlabelen` VARCHAR(50) NULL ,
  `labelde` VARCHAR(50) NULL ,
  `shortlabelde` VARCHAR(50) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `courses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `courses` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `courses` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(100) NOT NULL ,
  `description` VARCHAR(1000) NULL ,
  `levelmin_id` INT NULL ,
  `levelmax_id` INT NULL ,
  `startdate` DATE NULL ,
  `enddate` DATE NULL ,
  `starttime` TIME NULL ,
  `endtime` TIME NULL ,
  `pricestudent` DECIMAL(4,2) NULL ,
  `priceemployee` DECIMAL(4,2) NULL ,
  `pricenormal` DECIMAL(4,2) NULL ,
  `bookinglink` VARCHAR(500) NULL ,
  `courseid01` VARCHAR(50) NULL ,
  `courseid02` VARCHAR(50) NULL ,
  `location` VARCHAR(250) NULL ,
  `status` ENUM('deleted') NULL ,
  `datetimecreated` TIMESTAMP NULL ,
  `datetimelastupdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
  `url` VARCHAR(1000) NULL ,
  `provider_id` INT NOT NULL ,
  `weekday_id` INT NULL ,
  `coursedata_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_course_levelmin` (`levelmin_id` ASC) ,
  INDEX `fk_course_levelmax` (`levelmax_id` ASC) ,
  INDEX `fk_course_provider` (`provider_id` ASC) ,
  INDEX `fk_course_weekday` (`weekday_id` ASC) ,
  UNIQUE INDEX `u_coursedata_id` (`coursedata_id` ASC) ,
  CONSTRAINT `fk_course_levelmin`
    FOREIGN KEY (`levelmin_id` )
    REFERENCES `levels` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_course_levelmax`
    FOREIGN KEY (`levelmax_id` )
    REFERENCES `levels` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_course_provider`
    FOREIGN KEY (`provider_id` )
    REFERENCES `providers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_course_weekday`
    FOREIGN KEY (`weekday_id` )
    REFERENCES `weekdays` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `cities`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cities` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `cities` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `universities`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `universities` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `universities` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `displayedname` VARCHAR(250) NULL ,
  `formalname` VARCHAR(250) NULL ,
  `type` ENUM('public', 'confessional', 'private') NULL ,
  `datetimecreated` TIMESTAMP NULL ,
  `datetimelastupdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
  `status` ENUM('unknown') NULL DEFAULT 'unknown' ,
  `numupdates` INT NOT NULL DEFAULT 0 ,
  `numcourses` INT NOT NULL DEFAULT 0 ,
  `url` VARCHAR(100) NULL ,
  `urlsport` VARCHAR(100) NULL ,
  `city_id` INT NULL ,
  `sport` TINYINT(1) NULL ,
  `numstudents` INT NULL ,
  `scrape` TINYINT(1) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_universitiy_city` (`city_id` ASC) ,
  CONSTRAINT `fk_universitiy_city`
    FOREIGN KEY (`city_id` )
    REFERENCES `cities` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `trainers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `trainers` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `trainers` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `courses_trainers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `courses_trainers` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `courses_trainers` (
  `course_id` INT NOT NULL ,
  `trainer_id` INT NOT NULL ,
  PRIMARY KEY (`course_id`, `trainer_id`) ,
  INDEX `fk_courseobjecttrainer_trainer` (`trainer_id` ASC) ,
  CONSTRAINT `fk_courseobjecttrainer_courseobject`
    FOREIGN KEY (`course_id` )
    REFERENCES `courses` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_courseobjecttrainer_trainer`
    FOREIGN KEY (`trainer_id` )
    REFERENCES `trainers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `sports`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sports` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `sports` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(50) NOT NULL ,
  `category` VARCHAR(50) NULL ,
  `type` ENUM('sport','dance') NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `courses_sports`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `courses_sports` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `courses_sports` (
  `sport_id` INT NOT NULL ,
  `course_id` INT NOT NULL ,
  `relevance` FLOAT NULL DEFAULT NULL ,
  `sport_title` VARCHAR(50) NULL ,
  `course_title` VARCHAR(100) NULL ,
  `course_description` VARCHAR(1000) NULL ,
  PRIMARY KEY (`sport_id`, `course_id`) ,
  INDEX `fk_coursesport_sport` (`sport_id` ASC) ,
  CONSTRAINT `fk_coursesport_course`
    FOREIGN KEY (`course_id` )
    REFERENCES `courses` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_coursesport_sport`
    FOREIGN KEY (`sport_id` )
    REFERENCES `sports` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `courseurls`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `courseurls` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `courseurls` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `url` VARCHAR(500) NOT NULL ,
  `university_id` INT NOT NULL ,
  `datetimecreated` TIMESTAMP NULL ,
  `datetimelastupdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_courseurl_university` (`university_id` ASC) ,
  CONSTRAINT `fk_courseurl_university`
    FOREIGN KEY (`university_id` )
    REFERENCES `universities` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `tempcourses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tempcourses` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `tempcourses` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `levelminmax` VARCHAR(100) NULL ,
  `weekday` VARCHAR(100) NULL ,
  `startenddate` VARCHAR(100) NULL ,
  `startendtime` VARCHAR(100) NULL ,
  `prices` VARCHAR(100) NULL ,
  `bookinglink` VARCHAR(500) NULL ,
  `courseid` VARCHAR(50) NULL ,
  `location` VARCHAR(250) NULL ,
  `title` VARCHAR(100) NULL ,
  `description1` VARCHAR(1000) NULL ,
  `description2` VARCHAR(1000) NULL ,
  `trainers` VARCHAR(250) NULL ,
  `url` VARCHAR(1000) NULL ,
  `university_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_tempcourse_university` (`university_id` ASC) ,
  CONSTRAINT `fk_tempcourse_university`
    FOREIGN KEY (`university_id` )
    REFERENCES `universities` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `partners`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `partners` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `partners` (
  `id` INT NOT NULL ,
  `displayedname` VARCHAR(250) NOT NULL ,
  `formalname` VARCHAR(250) NULL ,
  `datetimecreated` TIMESTAMP NULL ,
  `datetimelastupdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
  `status` ENUM('unknown') NULL DEFAULT 'unknown' ,
  `numupdates` INT NULL ,
  `city_id` INT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `levelsmap`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `levelsmap` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `levelsmap` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `levelvalue` VARCHAR(100) NULL ,
  `university_id` INT NULL ,
  `levelmin_id` INT NULL ,
  `levelmax_id` INT NULL ,
  `examplelink` VARCHAR(1000) NULL ,
  `status` ENUM('checked', 'new') NULL DEFAULT 'new' ,
  `datetimecreated` TIMESTAMP NULL ,
  `datetimelastupdate` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_levelsmap_university` (`university_id` ASC) ,
  INDEX `fk_levelsmap_levelmin` (`levelmin_id` ASC) ,
  INDEX `fk_levelsmap_levelmax` (`levelmax_id` ASC) ,
  CONSTRAINT `fk_levelsmap_university`
    FOREIGN KEY (`university_id` )
    REFERENCES `universities` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_levelsmap_levelmin`
    FOREIGN KEY (`levelmin_id` )
    REFERENCES `levels` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_levelsmap_levelmax`
    FOREIGN KEY (`levelmax_id` )
    REFERENCES `levels` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `coursedata`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `coursedata` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `coursedata` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(100) NULL ,
  `description` VARCHAR(1000) NULL ,
  PRIMARY KEY (`id`) ,
  FULLTEXT INDEX `searchcoursetitle` (`title` ASC) ,
  FULLTEXT INDEX `searchcoursedescription` (`description` ASC) )
ENGINE = MyISAM;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Placeholder table for view `allproviders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `allproviders` (`id` INT, `providertype` INT, `providerid` INT, `displayedname` INT, `url` INT, `city_id` INT);
SHOW WARNINGS;

-- -----------------------------------------------------
-- View `allproviders`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `allproviders` ;
SHOW WARNINGS;
DROP TABLE IF EXISTS `allproviders`;
SHOW WARNINGS;
-- DELIMITER $$
CREATE OR REPLACE VIEW `allproviders` AS

SELECT
	`providers`.`id`,
	`providers`.`type` AS `providertype`,
	`providers`.`providerid` AS `providerid`,
	`universities`.`displayedname`,
	`universities`.`url`,
	`universities`.`city_id`
FROM
	`providers`
JOIN
	`universities` ON `providers`.`providerid` = `universities`.`id`
UNION
SELECT
	`providers`.`id`,
	`providers`.`type` AS `providertype`,
	`providers`.`providerid` AS `providerid`,
	`partners`.`displayedname`,
	NULL `url`,
	`partners`.`city_id`
FROM
	`providers`
JOIN
	`partners` ON `providers`.`providerid` = `partners`.`id`
-- $$
-- DELIMITER ;

;
SHOW WARNINGS;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
