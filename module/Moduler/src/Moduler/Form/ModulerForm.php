<?php
namespace Moduler\Form;

use Zend\Form\Form;

class ModulerForm extends Form
{
	public function __construct( $name = 'moduler', $method = 'post' )
	{
		parent::__construct( $name );

		$this->setAttribute( 'method', $method );

		$this->add( array(
			'name' => 'template',
			'type'  => 'Zend\Form\Element\Select',
			'options' => array(
				'label' => 'Select template',
			),
			'attributes' => array(
				'required' => true,
				'size' => '30'
			),
		));
		$this->add( array(
			'name' => 'name',
			'options' => array(
				'label' => 'Module name',
			),
			'attributes' => array(
				'required' => true,
				'type'  => 'text',
				'placeholder' => 'Enter the module name',
				'size' => '30'
			),
		));
		$this->add( array(
			'name' => 'table',
			'options' => array(
				'label' => 'DB Table',
			),
			'attributes' => array(
				'type'  => 'text',
				'placeholder' => 'Enter table name if needed',
				'size' => '30'
			),
		));
		$this->add( array(
			'name' => 'unit',
			'options' => array(
				'label' => 'PHPUnit testsuite',
			),
			'attributes' => array(
				'type'  => 'text',
				'placeholder' => 'Enter testsuite name',
				'size' => '30'
			),
		));
		$this->add( array(
			'name' => 'project',
			'type' => 'Zend\Form\Element\File',
			'options' => array(
				'label' => 'Project',
			),
			'attributes' => array(
				'required' => true,
				'placeholder' => 'Select project folder',
				'size' => '30'
			),
		));
		$this->add(array(
			'name' => 'csrf',
			'type' => 'Zend\Form\Element\Csrf',
		));
		$this->add(array(
			'name' => 'build',
			'attributes' => array(
				'type'  => 'submit',
				'value' => 'Build module',
				'class' => 'btn btn-primary btn-large'
			),
		));
	}
}
