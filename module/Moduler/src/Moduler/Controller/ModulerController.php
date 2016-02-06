<?php
namespace Moduler\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Moduler\Form\ModulerForm;

class ModulerController extends AbstractActionController {
	protected $templatesDir;
	protected $projectsDir;

	public function indexAction() {
		$data = array(
			'templates_dir' => $this->getTemplatesDir(),
			'projects_dir' => $this->getProjectsDir()
		);
		$form = new ModulerForm( 'moduler', $data );
		$request = $this->getRequest();
		if( $request->isPost() ) {
			$form->setData( $request->getPost() );
			if( $form->isValid() ) {
				echo "Creating new module...";
				echo "<pre>";
				print_r( $form->getData() );
				die();
			}
		}
		return new ViewModel( array( 'form' => $form ) );
	}
	protected function getTemplatesDir() {
		if( !$this->templatesDir ) {
			$config = $this->getServiceLocator()->get('config');
			$this->templatesDir = $config['moduler']['templates_dir'];
		}
		if( !is_dir( $this->templatesDir ) ) {
			throw new \Exception( 'Template dir not found!' );
		}
		return $this->templatesDir;
	}
	protected function getProjectsDir() {
		if( !$this->projectsDir ) {
			$config = $this->getServiceLocator()->get('config');
			$this->projectsDir = $config['projects_dir'];
		}
		if( !is_dir( $this->projectsDir ) ) {
			throw new \Exception( 'Projects dir not found!' );
		}
		return $this->projectsDir;
	}
}
