<?php
namespace Form\Form;

use Zend\Form\Form;

class ElementForm extends Form
{
	public function __construct( $name = 'moduler', $data = array(), $method = 'post' )
	{
		parent::__construct( $name );

		$this->setAttribute( 'method', $method );

		$this->add( array(
			'type'  => 'Zend\Form\Element\Text',
			'name' => 'label',
			'options' => array(
				'label' => 'Element label',
			),
			'attributes' => array(
				'required' => true,
				'placeholder' => 'Enter the element label',
				'size' => '30'
			),
		));
		$this->add( array(
			'type'  => 'Zend\Form\Element\Text',
			'name' => 'name',
			'options' => array(
				'label' => 'Element name',
			),
			'attributes' => array(
				'required' => true,
				'placeholder' => 'Enter the element name',
				'size' => '20'
			),
		));
		$this->add( array(
			'type'  => 'Zend\Form\Element\Text',
			'name' => 'default',
			'options' => array(
				'label' => 'Default value',
			),
			'attributes' => array(
				'required' => true,
				'placeholder' => 'Enter the default value',
				'value' => 'NULL',
				'size' => '20'
			),
		));
		$this->add( array(
			'type'  => 'Zend\Form\Element\Select',
			'name' => 'type',
			'options' => array(
				'label' => 'Element type',
				'value_options' => $this->getElementTypes(),
			),
			'attributes' => array(
				'required' => true,
				'value' => '',
				'class' => 'chosen-select'
			),
		));
		$this->add( array(
			'type'  => 'Zend\Form\Element\Text',
			'name' => 'length',
			'options' => array(
				'label' => 'Type length',
			),
			'attributes' => array(
				'placeholder' => 'Enter max. length',
				'size' => '15'
			),
		));
		$this->add( array(
			'type'  => 'Zend\Form\Element\Checkbox',
			'name' => 'required',
			'options' => array(
				'label' => 'Required',
				'checked_value' => '1',
				'unchecked_value' => '0'
			)
		));
		$this->add( array(
			'type'  => 'Zend\Form\Element\Checkbox',
			'name' => 'editable',
			'options' => array(
				'label' => 'Editable',
				'checked_value' => '1',
				'unchecked_value' => '0'
			)
		));
		$this->add( array(
			'type' => 'Zend\Form\Element\Select',
			'name' => 'index',
			'options' => array(
				'label' => 'Index',
				'value_options' => $this->getIndexTypes()
			),
			'attributes' => array(
				'required' => true,
				'value' => '',
				'class' => 'chosen-select'
			),
		));
		$this->add(array(
			'type' => 'Zend\Form\Element\Csrf',
			'name' => 'csrf',
		));
		$this->add(array(
			'type'  => 'Zend\Form\Element\Submit',
			'name' => 'build',
			'attributes' => array(
				'value' => 'Build form',
				'class' => 'btn btn-primary btn-large'
			),
		));
	}
	protected function getElementTypes() {
		$options = array(
			'none' => 'None',
			'primary' => 'Primary',
			'index' => 'Index',
			'unique' => 'Unique',
			'fulltext' => 'Fulltext'
		);
		return $options;
	}
	protected function getIndexTypes() {
		$options = array(
			'none' => 'None',
			'primary' => 'Primary',
			'index' => 'Index',
			'unique' => 'Unique',
			'fulltext' => 'Fulltext'
		);
		return $options;
	}
	protected function getTemplates( $dir ) {
		$templates = array();
		if( is_dir( $dir ) ) {
			$handle = opendir( $dir );
			while( ( $entry = readdir( $handle ) ) !== false ) {
				// Ignore . and .. entries
				if( !preg_match( '/^\.{1,2}$/', $entry ) ) {
					// Accept only directories
					if( is_dir( $dir . DIRECTORY_SEPARATOR . $entry ) ) {
						$templates[$entry] = $entry;
					}
				}
			}
		}
		return $templates;
	}
	protected function getProjects( $dir, $level = 2 ) {
		$projects = array();
		$dir = realpath( $dir );
		if( $level > -1 && is_dir( $dir ) ) {
			// Search for composer file
			$composer = $dir . DIRECTORY_SEPARATOR . 'composer.json';
			if( file_exists( $composer ) ) {
				$metadata = json_decode( file_get_contents( $composer ), true );
				// Detect if ZF2 project
				if( isset( $metadata['require']['zendframework/zendframework'] ) && (float) trim( $metadata['require']['zendframework/zendframework'], '<> ~' ) > 2 ) {
					$projectName = pathinfo( $dir, PATHINFO_FILENAME );
					$projects[$dir] = $projectName;
				}
			}
			$handle = opendir( $dir );
			while( ( $entry = readdir( $handle ) ) !== false ) {
				// Ignore . and .. entries
				if( !preg_match( '/^\.{1,2}$/', $entry ) ) {
					$route = $dir . DIRECTORY_SEPARATOR . $entry;
					// Accept only directories
					if( is_dir( $route ) ) {
						$projects = array_merge( $projects, $this->getProjects( $route, ($level-1) ) );
					}
				}
			}
		}
		return $projects;
	}
}
