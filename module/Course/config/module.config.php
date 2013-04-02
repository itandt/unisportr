<?php
return array(
	'controllers' => array(
		'invokables' => array(
			'Course\Controller\Course' => 'Course\Controller\CourseController',
		),
	),
	'router' => array(
		'routes' => array(
			'course' => array(
				'type'	=> 'ITT\Mvc\Router\Http\UnicodeRegex',
				'options' => array(
					'regex'	=> '/course/(?<id>[\p{N}]*)-(?<title>[\p{L}\p{Z}\p{P}\p{S}]*)',
					'defaults' => array(
						'controller' => 'Course\Controller\Course',
						'action'	 => 'display-course',
					),
					'spec'	=> '/course/%id%-%title%',
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