<?php
namespace Moduler\Model\Parser;

class Raw {
	protected $nodeName;
	protected $nodeCode;
	protected $vector;
	protected $length;
	protected $children;
	protected $pattern;
	protected $parsable;
	protected $lookBehind;

	/**
	 * @param $name string
	 * @param $code string
	 * @param $vector vector
	 */
	public function __construct( $code, $vector, $name = 'Raw' ) {
		$this->nodeCode = $code;
		$this->vector = $vector;
		$this->nodeName = $name;
		$this->parsable = true;
		$this->lookBehind = false;
	}
	/**
	 * @param $value Raw
	 */
	public function setParent( $value ) {
		$this->parent = $value;
	}
	/**
	 * @return Raw
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * @return string
	 */
	public function getNodeCode() {
		return $this->nodeCode;
	}
	/**
	 * @param $raw Raw
	 */
	public function addChild( $raw ) {
		$raw->setParent( $this );
		$this->children[] = $raw;
		$this->length = count( $this->children );
	}
	/**
	 * @return int
	 */
	public function newLines() {
		if( preg_match_all( '/(\r\n\|\r|\n)/', $this->nodeCode, $matches ) ) {
			return count( $matches );
		}
		return 0;
	}
	public function getPattern() {
		return $this->pattern;
	}
	/**
	 * @return Vector
	 */
	public function getVector() {
		return $this->vector;
	}
	/**
	 * @return bool
	 */
	public function isParsable() {
		return $this->parsable;
	}
	/**
	 * @return bool
	 */
	public function lookBehind() {
		return $this->lookBehind;
	}
	public function printClean( $print = true ) {
		$code = $this->nodeCode;
		$this->nodeCode = '';
		if( is_array( $this->children ) ) {
			foreach( $this->children as $child ) {
				$child->printClean( false );
			}
		}
		if( $print ) {
			print_r( $this );
		}
	}
	public function toString() {
		$i = 0;
		$str = '';
		if( is_array( $this->children ) ) {
			foreach( $this->children as $child ) {
				$length = $child->getVector()->getStart() - $i;
				if( $i !== $child->getVector()->getStart() ) {
					$str .= mb_substr( $this->nodeCode, $i, $length );
				}
				$str .= $child->getNodeCode();
				$i = $child->getVector()->getEnd();
			}
		}
		return $str;
	}
}
