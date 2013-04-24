<?php
$breakpoint = null;
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
				'type'	=> 'segment',
				'options' => array(
					'route'	=> '/search/courses',
					'defaults' => array(
						'controller' => 'Search\Controller\Search',
						'action'	 => 'search-courses',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'results' => array(
					'type'	=> 'segment',
						'options' => array(
							'route'	=> '[/page/:page]',
							'defaults' => array(
								'controller' => 'Search\Controller\Search',
								'action'	 => 'search-courses',
							),
						),
						'may_terminate' => true,
					),
				)
			),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'search' => __DIR__ . '/../view',
		),
	),
	'relevance_min' => 2,
	'relevance_min_title' => 1,
	'relevance_min_description' => 5,
	'relevance_min_weightage_title' => 9,
	'relevance_min_weightage_description' => 1,
);