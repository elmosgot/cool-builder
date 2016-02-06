<?php
namespace Moduler\Form;

use Zend\Form\Form;

class ModulerForm extends Form
{
	public function __construct( $name = 'moduler', $data = array(), $method = 'post' )
	{
		parent::__construct( $name );

		$this->setAttribute( 'method', $method );

		$this->add( array(
			'type'  => 'Zend\Form\Element\Select',
			'name' => 'template',
			'options' => array(
				'label' => 'Select template',
				'value_options' => $this->getTemplates( $data['templates_dir'] ),
			),
			'attributes' => array(
				'required' => true,
				'value' => '',
				'class' => 'chosen-select'
			),
		));
		$this->add( array(
			'type'  => 'Zend\Form\Element\Text',
			'name' => 'name',
			'options' => array(
				'label' => 'Module name',
			),
			'attributes' => array(
				'required' => true,
				'placeholder' => 'Enter the module name',
				'size' => '30'
			),
		));
		$this->add( array(
			'type'  => 'Zend\Form\Element\Text',
			'name' => 'table',
			'options' => array(
				'label' => 'DB Table',
			),
			'attributes' => array(
				'placeholder' => 'Enter table name if needed',
				'size' => '30'
			),
		));
		$this->add( array(
			'type'  => 'Zend\Form\Element\Text',
			'name' => 'unit',
			'options' => array(
				'label' => 'PHPUnit testsuite',
			),
			'attributes' => array(
				'placeholder' => 'Enter testsuite name',
				'size' => '30'
			),
		));
		$this->add( array(
			'type' => 'Zend\Form\Element\Select',
			'name' => 'project',
			'options' => array(
				'label' => 'Project',
				'value_options' => $this->getProjects( $data['projects_dir'] )
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
				'value' => 'Build module',
				'class' => 'btn btn-primary btn-large'
			),
		));
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
				if( isset( $metadata['require']['zendframework/zendframework'] ) && (float) $metadata['require']['zendframework/zendframework'] > 2 ) {
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
