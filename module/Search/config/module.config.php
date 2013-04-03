<?php
return array(
	'controllers' => array(
		'invokables' => array(
			'Search\Controller\Search' => 'Search\Controller\SearchController',
		),
	),
	'router' => array(
		'routes' => array(
			'search' => array(
				'type'	=> 'literal',
				'options' => array(
					'route'	=> '/search',
					'defaults' => array(
						'controller' => 'Search\Controller\Search',
						'action'	 => 'search',
					),
				),
				'may_terminate' => true,
			),
			'search-courses' => array(
				'type'	=> 'literal',
				'options' => array(
					'route'	=> '/search/courses',
					'defaults' => array(
						'controller' => 'Search\Controller\Search',
						'action'	 => 'search-courses',
					),
				),
				'may_terminate' => true,
			),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'course' => __DIR__ . '/../view',
		),
	),
);