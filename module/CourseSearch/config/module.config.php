<?php
$breakpoint = null;
return array(
	'controllers' => array(
		'invokables' => array(
			'CourseSearch\Controller\CourseSearch' => 'CourseSearch\Controller\CourseSearchController',
		),
	),
	'router' => array(
		'routes' => array(
			/*
			'search' => array(
				'type'	=> 'literal',
				'options' => array(
					'route'	=> '/search',
					'defaults' => array(
						'controller' => 'CourseSearch\Controller\CourseSearch',
						'action'	 => 'search',
					),
				),
				'may_terminate' => true,
			),
			*/
			'course-search' => array(
				'type'	=> 'segment',
				'options' => array(
					'route'	=> '/course-search',
					'defaults' => array(
						'controller' => 'CourseSearch\Controller\CourseSearch',
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
								'controller' => 'CourseSearch\Controller\CourseSearch',
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
			'course-search' => __DIR__ . '/../view',
		),
	),
	'relevance_min' => 2,
	'relevance_min_title' => 1,
	'relevance_min_description' => 5,
	'relevance_min_weightage_title' => 9,
	'relevance_min_weightage_description' => 1,
);