<?php
return array(
	'controllers' => array(
		'invokables' => array( 
			'Moduler\Controller\Moduler' => 'Moduler\Controller\ModulerController',
		)
	),
	'router' => array(
		'routes' => array(
			'moduler' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/moduler[/:action][/:id]',
					'constraints' => array(
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id'	 => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'Moduler\Controller\Moduler',
						'action'	 => 'index',
					),
				),
			),
		), 
	),
	'view_manager' => array( 
		'template_path_stack' => array( 
			'moduler' => __DIR__ . '/../view',
		)
	)
);