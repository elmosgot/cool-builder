<?php
namespace Moduler\Model\Parser\Assign;

use Moduler\Model\Parser\Raw;

class ArrayObj extends Raw {
	public function __construct( $code, $vector ) {
		parent::__construct( $code, $vector, 'Array' );
		$this->pattern = array( '=>', array( '),', ',', ';' ) );
	}
}