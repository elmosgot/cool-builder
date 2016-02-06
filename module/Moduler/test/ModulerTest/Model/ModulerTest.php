<?php
namespace ModulerTest\Model;

use Moduler\Model\Album;
use PHPUnit_Framework_TestCase;

class ModulerTest extends PHPUnit_Framework_TestCase {
	public function testAlbumInitialState() {
		$moduler = new Moduler();
		
		$this->assertNull( $moduler->name, '"name" should inititally be null' );
		$this->assertNull( $moduler->id, '"id" should inititally be null' );
	}
	public function testExchangeArraySetsPropertiesCorrectly() {
		$moduler = new Moduler();
		$data = array( 'name' => 'some name',
					   'id'		=> 123 );
		
		$moduler->exchangeArray($data);
		
		$this->assertSame($data['name'], $moduler->name, '"name" was not set correctly');
		$this->assertSame($data['id'], $moduler->id, '"id" was not set correctly');
	}
	public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent() {
		$moduler = new Moduler();
		
		$moduler->exchangeArray( array( 'name' => 'some name',
									  'id'     => 123));
		
        $moduler->exchangeArray( array() );
        
		$this->assertNull($moduler->name, '"name" should have defaulted to null');
		$this->assertNull($moduler->id, '"id" should have defaulted to null');
	}
}