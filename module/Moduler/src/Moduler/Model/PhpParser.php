<?php
namespace Moduler\Model;

use Moduler\Model\Parser\Vector;
use Moduler\Model\Parser\Assign\Variable;
use Moduler\Model\Parser\Comment\CommentBlock;
use Moduler\Model\Parser\Comment\CommentLine;
use Moduler\Model\Parser\Struct\Block;
use Moduler\Model\Parser\Type\ArrayObj;
use Moduler\Model\Parser\Type\DoubleString;
use Moduler\Model\Parser\Type\SingleString;

class PhpParser extends Parser {
	public function __construct() {
		$vector = new Vector( 0, 1 );
		$codeBlocks = array(
			new CommentBlock( '', $vector ),
			new CommentLine( '', $vector ),
			new Variable( '', $vector ),
			new Block( '', $vector ),
			new ArrayObj( '', $vector ),
			new DoubleString( '', $vector ),
			new SingleString( '', $vector )
		);
		$this->setCodeBlocks( $codeBlocks );
	}
}
