<?php
namespace %1$s\Model;

use Zend\Db\TableGateway\TableGateway;

class %1$sTable {
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
	public function get%1$s( $id ) {
		$id = (int) $id;
		$rowset = $this->tableGateway->select( array( 'id' => $id ) );
		$row = $rowset->current();
		if( !$row ) {
			throw new \Exception( "Could not find row $id" );
		}
		return $row;
	}
	public function save%1$s( %1$s $%2$s ) {
		$data = array(
			'name' => $%2$s->name,
		);
		$id = (int) $%2$s->id;
		if( $id == 0 ) {
			$this->tableGateway->insert( $data );
		} else {
			if( $this->get%1$s( $id ) ) {
				$this->tableGateway->update( $data, array( 'id' => $id ) );
			}  else {
				throw new \Exception( '%1$s id does not exist' );
			}
		}
	}
	public function delete%1$s( $id ) {
		$id = (int) $id;
		$this->tableGateway->delete( array( 'id' => $id ) );
	}
}