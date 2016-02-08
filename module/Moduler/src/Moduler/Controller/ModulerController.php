<?php
namespace Moduler\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Moduler\Form\ModulerForm;
use Moduler\Model\Moduler;
use Moduler\Model\Builder;

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
		$buildLog = array();
		if( $request->isPost() ) {
			$moduler = new Moduler();
			$form->bind( $moduler );
			$form->setData( $request->getPost() );
			if( $form->isValid() ) {
				$builder = new Builder( $moduler, $this->getTemplatesDir() );
				$builder->activate();
				die();
				// Verify module doesn't exist
				if( is_dir( $moduler->getModuleDir() ) ) {
					$form->get('csrf')->setMessages( array( 'exists' => 'Module already exists' ) );
				} else {
					$buildLog[] = "Creating new module...";
					// Create module
					$builder = new Builder( $moduler, $this->getTemplatesDir() );
					$buildLog = array_merge( $buildLog, $builder->buildModule() );
					// Activate module
					//$builder->activate();
				}
			}
		}
		return new ViewModel( array( 'form' => $form, 'log' => $buildLog ) );
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
