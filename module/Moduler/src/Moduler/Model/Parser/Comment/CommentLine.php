<?php
namespace Moduler\Model\Parser\Comment;

use Moduler\Model\Parser\Raw;
use Moduler\Model\Parser\Regex;

class CommentLine extends Raw {
	public function __construct( $code, $vector ) {
		parent::__construct( $code, $vector, 'CommentLine' );
		$this->parsable = false;
		$this->pattern = array( '//', new Regex( '(\r\n|\n|\r)', 1 ) );
	}
}
