<?php
namespace Moduler\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Moduler\Form\ModulerForm;

class ModulerController extends AbstractActionController {
	public function indexAction() {
		$form = new ModulerForm();
		return new ViewModel( array( 'form' => $form ) );
	}
}
