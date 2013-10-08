-- Adds statuses 'active' and 'inactive' to the table 'partners'.
ALTER TABLE
	`partners`
CHANGE
	`status` `status` ENUM('unknown', 'active', 'inactive')
DEFAULT
	'unknown'
NULL;

-- Adds statuses 'active' and 'inactive' to the table 'universities'.
ALTER TABLE
	`universities`
CHANGE
	`status` `status` ENUM('unknown', 'active', 'inactive')
DEFAULT
	'unknown'
NULL;