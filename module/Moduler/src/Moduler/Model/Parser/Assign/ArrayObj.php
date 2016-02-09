<?php
namespace Moduler\Model\Parser\Assign;

use Moduler\Model\Parser\Raw;

class ArrayObj extends Raw {
	public function __construct( $code, $vector, $name = 'Array' ) {
		parent::__construct( $code, $vector, $name );
		$this->pattern = array( '=>', array( '),', ',', ';' ) );
		$this->lookBehind = true;
	}
}
