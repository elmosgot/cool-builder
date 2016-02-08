<?php
namespace Core\Model;

use Zend\Db\TableGateway\TableGateway;

class CoreTable {
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
	public function getCore( $id ) {
		$id = (int) $id;
		$rowset = $this->tableGateway->select( array( 'id' => $id ) );
		$row = $rowset->current();
		if( !$row ) {
			throw new \Exception( "Could not find row $id" );
		}
		return $row;
	}
	public function saveCore( Core $core ) {
		$data = array(
			'name' => $core->name,
		);
		$id = (int) $core->id;
		if( $id == 0 ) {
			$this->tableGateway->insert( $data );
		} else {
			if( $this->getCore( $id ) ) {
				$data['last_updated'] = $core->lastUpdated;
				$this->tableGateway->update( $data, array( 'id' => $id ) );
			}  else {
				throw new \Exception( 'Core id does not exist' );
			}
		}
	}
	public function deleteCore( $id ) {
		$id = (int) $id;
		$this->tableGateway->delete( array( 'id' => $id ) );
	}
}
