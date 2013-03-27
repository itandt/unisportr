<?php
return array(
	'controllers' => array(
		'invokables' => array(
			'Catalog\Controller\Catalog' => 'Catalog\Controller\CatalogController',
		),
	),
	'router' => array(
		'routes' => array(
			'catalog' => array(
				'type'	=> 'literal',
				'options' => array(
					'route'	=> '/catalog',
					'defaults' => array(
						'controller' => 'Catalog\Controller\Catalog',
						'action'	 => 'list-cities',
					),
				),
				'may_terminate' => true,
			),
			'city' => array(
				'type'	=> 'ITT\Mvc\Router\Http\UnicodeRegex',
				'options' => array(
					'regex'	=> '/catalog/(?<city>[\p{L}]*)',
					'defaults' => array(
						'controller' => 'Catalog\Controller\Catalog',
						'action'	 => 'list-sports',
					),
					'spec'	=> '/catalog/%city%',
				),
				'may_terminate' => true,
			),
			'sport' => array(
				'type'	=> 'ITT\Mvc\Router\Http\UnicodeRegex',
				'options' => array(
					'regex'	=> '/catalog/(?<city>[\p{L}]*)/(?<sport>[\p{L}]*)',
					'defaults' => array(
						'controller' => 'Catalog\Controller\Catalog',
						'action'	 => 'list-courses',
					),
					'spec'	=> '/catalog/%city%/%sport%',
				),
				'may_terminate' => true,
			),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'catalog' => __DIR__ . '/../view',
		),
	),
);