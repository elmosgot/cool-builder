<?php
namespace Moduler\Model\Parser\Comment;

use Moduler\Model\Parser\Raw;

class CommentLine extends Raw {
	public function __construct( $code, $vector ) {
		parent::__construct( $code, $vector, 'CommentLine' );
		$this->parsable = false;
		$this->pattern = array( '//', '\n' );
	}
}
