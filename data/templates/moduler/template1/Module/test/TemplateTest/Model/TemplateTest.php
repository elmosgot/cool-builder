<?php
namespace %1$sTest\Model;

use %1$s\Model\Album;
use PHPUnit_Framework_TestCase;

class %1$sTest extends PHPUnit_Framework_TestCase {
	public function testAlbumInitialState() {
		$%2$s = new %1$s();
		
		$this->assertNull( $%2$s->name, '"name" should inititally be null' );
		$this->assertNull( $%2$s->id, '"id" should inititally be null' );
	}
	public function testExchangeArraySetsPropertiesCorrectly() {
		$%2$s = new %1$s();
		$data = array( 'name' => 'some name',
					   'id'		=> 123 );
		
		$%2$s->exchangeArray($data);
		
		$this->assertSame($data['name'], $%2$s->name, '"name" was not set correctly');
		$this->assertSame($data['id'], $%2$s->id, '"id" was not set correctly');
	}
	public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent() {
		$%2$s = new %1$s();
		
		$%2$s->exchangeArray( array( 'name' => 'some name',
									  'id'     => 123));
		
        $%2$s->exchangeArray( array() );
        
		$this->assertNull($%2$s->name, '"name" should have defaulted to null');
		$this->assertNull($%2$s->id, '"id" should have defaulted to null');
	}
}