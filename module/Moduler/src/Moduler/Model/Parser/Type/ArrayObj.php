<?php
namespace Moduler\Model\Parser\Type;

use Moduler\Model\Parser\Raw;
use Moduler\Model\Parser\Regex;

class ArrayObj extends Raw {
	public function __construct( $code, $vector, $name = 'Array' ) {
		parent::__construct( $code, $vector, $name );
		$this->pattern = array( '=>', array( '),', ';' ) );
		$this->lookBehind = true;
	}
}
