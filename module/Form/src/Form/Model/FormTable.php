<?php
namespace Form\Model;

use Zend\Db\TableGateway\TableGateway;

class FormTable {
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
	public function getForm( $id ) {
		$id = (int) $id;
		$rowset = $this->tableGateway->select( array( 'id' => $id ) );
		$row = $rowset->current();
		if( !$row ) {
			throw new \Exception( "Could not find row $id" );
		}
		return $row;
	}
	public function saveForm( Form $form ) {
		$data = array(
			'name' => $form->name,
		);
		$id = (int) $form->id;
		if( $id == 0 ) {
			$this->tableGateway->insert( $data );
		} else {
			if( $this->getForm( $id ) ) {
				$this->tableGateway->update( $data, array( 'id' => $id ) );
			}  else {
				throw new \Exception( 'Form id does not exist' );
			}
		}
	}
	public function deleteForm( $id ) {
		$id = (int) $id;
		$this->tableGateway->delete( array( 'id' => $id ) );
	}
}