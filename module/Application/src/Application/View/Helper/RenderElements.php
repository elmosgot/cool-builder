<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Form\Form;

class RenderElements extends AbstractHelper {
	protected $format = "<div class=\"row\" data-name=\"%s\">\n\t%s<div class=\"col-xs-12 col-sm-8\">\n\t\t%s\n</div>\n\t<div class=\"col-xs-12 col-sm-offset-4 col-sm-8\">\n\t\t%s\n\t</div>\n\t<div class=\"col-xs-12 col-sm-offset-4 col-sm-8\">\n\t\t%s\n\t</div>\n</div>\n";
	protected $labelBlock = "<div class=\"col-xs-12 col-sm-4\">\n\t\t%s\n\t</div>\n\t";
	protected $showLabel = true;
	/**
	 * @param Form $form
	 * @param array $fields
	 * @param array $overwrite
	 *
	 * @return string
	 */
	public function __invoke( $form, $fields, $overwrite = null ) {
		if( $overwrite === null ) {
			$overwrite = array();
		}
		if( !is_array( $fields ) ) {
			$fields = array( $fields );
		}
		$html = '';
		foreach( $fields as $i => $field ) {
			$addon = '';
			if( !is_int( $i ) ) {
				$addon = $field;
				$field = $i;
			}
			if( !$form->has( $field ) ) {
				throw new \Exception( sprintf( 'Element doesn\'t exists \'%s\'', $field ) );
			}
			$element = $form->get( $field );
			$type = strtolower( $element->getAttribute( 'type' ) );
			if( array_key_exists( $field, $overwrite ) ) {
				if( $type === 'submit' ) {
					$element->setValue( $overwrite[$field] );
				} else {
					$element->setOption( 'label', $overwrite[$field] );
				}
			}
			$plugin = $this->getPlugin( $type );
			$prefix = '';
			$encaps = '%s';
			switch( $type ) {
				case 'checkbox':
					$encaps = sprintf( "<div class=\"checkbox-block\">%s</div><div class=\"col-xs-10\">%s</div>", '%s', $this->getLabel( $element ) );
					break;
				case "textarea":
					if( preg_match( '/readonly/i', $element->getAttribute('class') ) ) {
						$prefix = '<p class="toggle-edit"><a href="#">Edit</a></p><iframe style="width:200px; height:100px; display: none;"></iframe>';
					}
				default:
					$prefix .= $this->getLabel( $element );
					break;
			}
			$input = $plugin( $element );
			if( !empty( $prefix ) ) {
				$prefix = sprintf( $this->labelBlock, $prefix );
			}
			$html .= sprintf( $this->format, $element->getName(), $prefix, sprintf( $encaps, $input ), $addon, $this->buildErrorMessage( $element ) );
		}
		return $html;
	}
	private function getPlugin( $type ) {
		switch( $type ) {
			case "email":
			case "textarea":
			case "select":
			case "submit":
			case "button":
			case "hidden":
			case "checkbox":
			case "radio":
				return $this->getView()->plugin('form' . $type );
				break;
		}
		return $this->getView()->plugin('forminput');
	}
	private function getLabel( $element ) {
		if( !$this->showLabel ) {
			return '';
		}
		$label = $element->getOption( 'label' );
		$required = $element->getAttribute('required') !== null ? '<div class="required"><span>*</span></div>' : '';
		return !empty( $label ) ? sprintf( '<label>%s</label>%s', $label, $required ) : '';
	}
	private function buildErrorMessage( $element ) {
		$plugin = $this->getView()->plugin('formelementerrors');
		$errorFormat = "<div role=\"alert\" class=\"alert alert-danger\"%s>\n\t<span class=\"sr-only\">Error:</span>\n\t%s\n</div>";
		return sprintf( $errorFormat, count( $element->getMessages() ) > 0 ? '' : ' style="display:none;"', str_replace( array( '[', ']', '&quot;' ), array( '<', '>', '"' ), $plugin( $element ) ) );
	}
	public function showLabel( $value = true ) {
		$this->showLabel = $value;
	}
}
