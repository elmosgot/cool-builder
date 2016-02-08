<?php
namespace Moduler\Model;

use Moduler\Model\Parser\Raw;
use Moduler\Model\Parser\Vector;

class Parser {
	protected $codeBlocks;
	protected $whitespace = '/ \t/';
	protected $lineEnd = '/\n\r/';

	/**
	 * @param $raw Raw
	 */
	public function parse( &$raw, $forward = 0 ) {
		for( $i = ($forward+1); $i < $raw->getVector()->getEnd(); $i++ ) {
			$search = mb_substr( $raw->getNodeCode(), 0, $i );
			foreach( $this->codeBlocks as $codeBlock ) {
				if( $codeBlock instanceof Raw ) {
					$className = get_class( $codeBlock );
					$pattern = $codeBlock->getPattern();
					// Open
					if( ( $rewind = $this->testPattern( $pattern[0], $search ) ) !== false ) {
						$offset = ($i+1);
						$name = '';
						if( $codeBlock->lookBehind() ) {
							$whitespace = 0;
							for( $j = $i; $j > -1; $j-- ) {
								$char = mb_substr( $search, $j, 1 );
								if( preg_match( '/[\r\n\t ]/', $char ) ) {
									$whitespace++;
									if( $whitespace > 1 ) {
										break;
									}
								}
							}
							$lookBehind = ($j+1);
							$name = mb_substr( $search, $lookBehind, $offset-$lookBehind );
							$offset = $lookBehind;
						}
						echo sprintf( '<b>%s</b>: %s (%s)<br/>', $className, $name, $offset );
						for( $j = 0; $j < $raw->getVector()->getEnd(); $j++ ) {
							$buffer = mb_substr( $raw->getNodeCode(), $offset, $j );
							// Close
							if( $this->testPattern( $pattern[1], $buffer ) ) {
								$className = get_class($codeBlock);
								$vector = new Vector( $i+$rewind, $j+$offset );
								$code = $vector->getPart( $raw->getNodeCode() );
								$child = new $className( $code, $vector );
								$raw->addChild( $child );
								$i = $vector->getEnd();
								if( $child->isParsable() ) {
									$this->parse( $child, (-1*$rewind) );
								}
								break;
							}
						}
					}
				}
			}
		}
	}
	protected function testPattern( $pattern, &$haystack ) {
		if( !is_array( $pattern ) ) {
			$pattern = array( $pattern );
		}
		foreach( $pattern as $patt ) {
			if( $patt === '\n' ) {
				$size = 1;
				$patt = '(\r\n\|\r|\n)';
			} else {
				$size = strlen( $patt );
			}
			$patt = preg_replace( '/([\$\^\.\,\/\{\}\(\)\[\]\*\\\])/', '\\\$1', $patt );
			$rewind = -1*$size;
			$test = mb_substr( $haystack, $rewind );
			$compare = preg_match( sprintf( '/%s/', $patt ), $test );
			if( $compare ) {
				return $rewind;
			}
		}
		return false;
	}
	public function setCodeBlocks( $codeBlocks ) {
		$this->codeBlocks = $codeBlocks;
	}
}
