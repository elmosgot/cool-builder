<?php
namespace Moduler;

use Moduler\Model\Moduler;
use Moduler\Model\ModulerTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module {
	public function getAutoloaderConfig() {
		return array(
			'Zend\Loader\ClassMapAutoloader' => array( 
				__DIR__ . '/autoload_classmap.php',
			),
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array( 
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				)
			)
		);
	}
	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}
	public function getServiceConfig() {
		return array(
			'factories' => array(
				'Moduler\Model\ModulerTable' => function( $sm ) {
					$tableGateway = $sm->get('ModulerTableGateway');
					$table = new ModulerTable( $tableGateway );
					return $table;
				},
				'ModulerTableGateway' => function( $sm ) {
					$dbAdapter = $sm->get('Zend\Db\Adapater\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype( new Moduler() );
					return new TableGateway( 'moduler', $dbAdapter, null, $resultSetPrototype );
				},
			),
		);
	}
}