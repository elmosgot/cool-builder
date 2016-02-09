<?php
namespace Moduler\Model\Parser\Type;

use Moduler\Model\Parser\Raw;
use Moduler\Model\Parser\Regex;

class SingleString extends Raw {
	public function __construct( $code, $vector ) {
		parent::__construct( $code, $vector, 'String' );
		$this->pattern = array( new Regex( '[^\\\]"', 2 ), new Regex( '[^\\\]"', 2 ) );
		$this->lookBehind = true;
		$this->parsable = false;
	}
}
