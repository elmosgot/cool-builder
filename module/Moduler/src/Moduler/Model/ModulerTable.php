<?php
namespace Moduler\Model;

use Zend\Db\TableGateway\TableGateway;

class ModulerTable {
	/**
	 * @var TableGateway
	 */
	protected $tableGateway;
	
	public function __construct( $tableGateway ) {
		$this->tableGateway = $tableGateway;
	}
	public function fetchAll() {
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}
	public function getModuler( $id ) {
		$id = (int) $id;
		$rowset = $this->tableGateway->select( array( 'id' => $id ) );
		$row = $rowset->current();
		if( !$row ) {
			throw new \Exception( "Could not find row $id" );
		}
		return $row;
	}
	public function saveModuler( Moduler $moduler ) {
		$data = array(
			'name' => $moduler->name,
		);
		$id = (int) $moduler->id;
		if( $id == 0 ) {
			$this->tableGateway->insert( $data );
		} else {
			if( $this->getModuler( $id ) ) {
				$this->tableGateway->update( $data, array( 'id' => $id ) );
			}  else {
				throw new \Exception( 'Moduler id does not exist' );
			}
		}
	}
	public function deleteModuler( $id ) {
		$id = (int) $id;
		$this->tableGateway->delete( array( 'id' => $id ) );
	}
}