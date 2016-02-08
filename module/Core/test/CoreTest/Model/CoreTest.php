<?php
namespace CoreTest\Model;

use Core\Model\Album;
use PHPUnit_Framework_TestCase;

class CoreTest extends PHPUnit_Framework_TestCase {
	public function testAlbumInitialState() {
		$core = new Core();
		
		$this->assertNull( $core->name, '"name" should inititally be null' );
		$this->assertNull( $core->id, '"id" should inititally be null' );
	}
	public function testExchangeArraySetsPropertiesCorrectly() {
		$core = new Core();
		$data = array( 'name' => 'some name',
					   'id'		=> 123 );
		
		$core->exchangeArray($data);
		
		$this->assertSame($data['name'], $core->name, '"name" was not set correctly');
		$this->assertSame($data['id'], $core->id, '"id" was not set correctly');
	}
	public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent() {
		$core = new Core();
		
		$core->exchangeArray( array( 'name' => 'some name',
									  'id'     => 123));
		
        $core->exchangeArray( array() );
        
		$this->assertNull($core->name, '"name" should have defaulted to null');
		$this->assertNull($core->id, '"id" should have defaulted to null');
	}
}