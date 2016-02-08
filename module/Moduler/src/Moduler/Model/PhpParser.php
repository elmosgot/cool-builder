<?php
namespace Moduler\Model;

use Moduler\Model\Parser\Vector;
use Moduler\Model\Parser\Assign\ArrayObj;
use Moduler\Model\Parser\Assign\Variable;
use Moduler\Model\Parser\Comment\CommentBlock;
use Moduler\Model\Parser\Comment\CommentLine;
use Moduler\Model\Parser\Struct\Block;

class PhpParser extends Parser {
	protected $whitespace = '/ \t/';
	protected $newline = '/(\r\n|\n|\r)/';
	protected $lineEnd = '/;/';

	public function __construct() {
		$vector = new Vector( 0, 1 );
		$codeBlocks = array(
			new CommentBlock( '', $vector ),
			new CommentLine( '', $vector ),
			new ArrayObj( '', $vector ),
			new Variable( '', $vector ),
			new Block( '', $vector )
		);
		$this->setCodeBlocks( $codeBlocks );
	}
}
