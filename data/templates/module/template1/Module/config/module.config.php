<?php
return array(
	'controllers' => array(
		'invokables' => array( 
			'%1$s\Controller\%1$s' => '%1$s\Controller\%1$sController',
		)
	),
	'router' => array(
		'routes' => array(
			'%2$s' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/%2$s[/:action][/:id]',
					'constraints' => array(
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id'	 => '[0-9]+',
					),
					'defaults' => array(
						'controller' => '%1$s\Controller\%1$s',
						'action'	 => 'index',
					),
				),
			),
		), 
	),
	'view_manager' => array( 
		'template_path_stack' => array( 
			'%2$s' => __DIR__ . '/../view',
		)
	)
);