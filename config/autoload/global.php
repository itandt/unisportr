<?php
$breakpoint = null;
use ITT\Util\Utility;
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
return array(
	'db' => array(
		'driver'         => 'Pdo',
		'driver_options' => array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
		),
		'pdodriver'      => 'mysql',
		// 'driver_options' => array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"),
	),
	'service_manager' => array(
		'factories' => array(
			'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
			'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
			'secondary' => 'ITT\Navigation\Service\SecondaryNavigationFactory',
		),
	),
	'navigation' => array(
		'default' => array(
		),
		'secondary' => array(
			array(
				'label' => Utility::poedit('Catalog'),
				'route' => 'catalog',
			),
			array(
				'label' => 'Search',
				'route' => 'course-search',
			),
			array(
				'label' => Utility::poedit('About unisportr'),
				'route' => 'application/default',
				'action' => 'about'
			),
			array(
				'label' => Utility::poedit('Musthead'),
				'route' => 'application/default',
				'action' => 'musthead'
			),
			array(
				'label' => Utility::poedit('Sitemap'),
				'route' => 'application/default',
				'action' => 'sitemap'
			),
		),
	),
	// ...
	// Environment. Allowed values: development, staging, live.
	'environment' => 'live'
);
