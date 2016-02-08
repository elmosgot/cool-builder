<?php
namespace Moduler\Model\Parser\Assign;

use Moduler\Model\Parser\Raw;

class Variable extends Raw {
	public function __construct( $code, $vector ) {
		parent::__construct( $code, $vector, 'Variable' );
		$this->pattern = array( array( 'return', '=' ), ';' );
		$this->lookBehind = true;
	}
}
