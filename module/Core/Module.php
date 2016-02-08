<?php
namespace Core;

use Core\Model\Core;
use Core\Model\CoreTable;
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
				'Core\Model\CoreTable' => function( $sm ) {
					$tableGateway = $sm->get('CoreTableGateway');
					$table = new CoreTable( $tableGateway );
					return $table;
				},
				'CoreTableGateway' => function( $sm ) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype( new Core() );
					return new TableGateway( 'core', $dbAdapter, null, $resultSetPrototype );
				},
			),
		);
	}
}
