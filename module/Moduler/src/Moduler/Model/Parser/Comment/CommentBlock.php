<?php
namespace Moduler\Model\Parser\Comment;

use Moduler\Model\Parser\Raw;

class CommentBlock extends Raw {
	public function __construct( $code, $vector ) {
		parent::__construct( $code, $vector, 'CommentBlock' );
		$this->parsable = false;
		$this->pattern = array( '/*', '*/' );
	}
}
