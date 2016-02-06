<?php
namespace FormTest\Model;

use Form\Model\Album;
use PHPUnit_Framework_TestCase;

class FormTest extends PHPUnit_Framework_TestCase {
	public function testAlbumInitialState() {
		$form = new Form();
		
		$this->assertNull( $form->name, '"name" should inititally be null' );
		$this->assertNull( $form->id, '"id" should inititally be null' );
	}
	public function testExchangeArraySetsPropertiesCorrectly() {
		$form = new Form();
		$data = array( 'name' => 'some name',
					   'id'		=> 123 );
		
		$form->exchangeArray($data);
		
		$this->assertSame($data['name'], $form->name, '"name" was not set correctly');
		$this->assertSame($data['id'], $form->id, '"id" was not set correctly');
	}
	public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent() {
		$form = new Form();
		
		$form->exchangeArray( array( 'name' => 'some name',
									  'id'     => 123));
		
        $form->exchangeArray( array() );
        
		$this->assertNull($form->name, '"name" should have defaulted to null');
		$this->assertNull($form->id, '"id" should have defaulted to null');
	}
}