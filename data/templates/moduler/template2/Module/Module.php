<?php
namespace %1$s;

use %1$s\Model\%1$s;
use %1$s\Model\%1$sTable;
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
	public function getServiceConfig() {
		return array(
			'factories' => array(
				'%1$s\Model\%1$sTable' => function( $sm ) {
					$tableGateway = $sm->get('%1$sTableGateway');
					$table = new %1$sTable( $tableGateway );
					return $table;
				},
				'%1$sTableGateway' => function( $sm ) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype( new %1$s() );
					return new TableGateway( '%3$s', $dbAdapter, null, $resultSetPrototype );
				},
			),
		);
	}
}
