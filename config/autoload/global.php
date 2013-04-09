<?php
$breakpoint = null;
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
		),
	),
	'navigation' => array(
		'default' => array(
			array(
				'label' => 'Catalog',
				'route' => 'catalog',
			),
			array(
				'label' => 'Search',
				'route' => 'search/courses',
// 				'pages' => array(
// 					array(
// 						'label' => 'Courses',
// 						'route' => 'search/courses',
// 					),
// 				),
			),
		),
	),
);
