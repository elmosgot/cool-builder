<?php
namespace Moduler\Model\Parser\Struct;

use Moduler\Model\Parser\Raw;

class Block extends Raw {
	public function __construct( $code, $vector ) {
		parent::__construct( $code, $vector, 'Block' );
		$this->pattern = array( '{', '}' );
	}
}
