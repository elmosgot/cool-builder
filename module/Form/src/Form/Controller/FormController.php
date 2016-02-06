<?php
namespace Form\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Form\Form\ElementForm;

class FormController extends AbstractActionController {
	public function indexAction() {
		$form = new ElementForm();
		return new ViewModel( array( 'form' => $form ) );
	}
}
