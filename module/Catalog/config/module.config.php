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
				'child_routes' => array(
					'city' => array(
						'type'	=> 'segment',
						'options' => array(
							'route'	=> '/:city',
							'constraints' => array(
								'city'  => '[a-zA-Z][a-zA-Z0-9_-]*',
								'sport' => '[a-zA-Z][a-zA-Z0-9_-]*',
							),
							'defaults' => array(
								'controller' => 'Catalog\Controller\Catalog',
								'action'	 => 'list-sports',
							),
						),
						'may_terminate' => true,
						'child_routes' => array(
							'sport' => array(
								'type'	=> 'segment',
								'options' => array(
									'route'	=> '/:sport',
									'constraints' => array(
										'city'  => '[a-zA-Z][a-zA-Z0-9_-]*',
										'sport' => '[a-zA-Z][a-zA-Z0-9_-]*',
									),
									'defaults' => array(
										'controller' => 'Catalog\Controller\Catalog',
										'action'	 => 'list-courses',
									),
								),
								'may_terminate' => true,
							),
						),
					),
				),
			),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'catalog' => __DIR__ . '/../view',
		),
	),
);