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
				'type'    => 'segment',
				'options' => array(
					'route'    => '/catalog[/]',
// 					'route'    => '/catalog[/:action][/:id]',
// 					'constraints' => array(
// 						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
// 						'id'     => '[0-9]+',
// 					),
					'defaults' => array(
						'controller' => 'Catalog\Controller\Catalog',
						'action'     => 'index',
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