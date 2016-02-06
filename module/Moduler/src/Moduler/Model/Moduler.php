<?php
namespace Moduler\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

use Application\Model\Convertion;

class Moduler implements InputFilterAwareInterface {
	protected $inputFilter;

	public $template;
	public $name;
	public $table;
	public $unit;
	public $project;

	public function exchangeArray( $data ) {
		$this->template = isset( $data['template'] ) ? $data['template'] : null;
		$this->name = isset( $data['name'] ) ? /*$data['name']*/ 'Moduler' : null;
		$this->table = isset( $data['table'] ) ? $data['table'] : null;
		$this->unit = isset( $data['unit'] ) ? $data['unit'] : null;
		$this->project = isset( $data['project'] ) ? $data['project'] : null;
	}
	public function getArrayCopy() {
		$vars = Convertion::camelCaseToUnderscore( get_object_vars( $this ) );
		$ignore = array( 'input_filter' );
		foreach( $ignore as $del ) {
			unset( $vars[$del] );
		}
		return $vars;
	}
	public function setInputFilter( InputFilterInterface $inputFilter = null ) {
		$this->inputFilter = null;
	}
	public function getInputFilter() {
		if( !$this->inputFilter ) {
			$inputFilter = new InputFilter();
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
	public function getModuleDir() {
		return realpath( $this->project . DIRECTORY_SEPARATOR . 'module' ) . DIRECTORY_SEPARATOR . $this->name;
	}
}
