<?php
namespace Moduler\Model\Parser\Assign;

use Moduler\Model\Parser\Raw;
use Moduler\Model\Parser\Regex;

class Variable extends Raw {
	public function __construct( $code, $vector, $name = 'Variable' ) {
		parent::__construct( $code, $vector, $name );
		$this->pattern = array( array( 'return', new Regex( '[^=\!\<\>]=[^=\>]', 3 ) ), ';' );
		$this->lookBehind = true;
	}
}
