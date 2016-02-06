<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
		public function onBootstrap(MvcEvent $e)

		$e->getApplication()->getServiceManager()->get('viewhelpermanager')->setFactory('renderElements', function($sm) use ($e) {
			$viewHelper = new View\Helper\RenderElements($e->getApplication()->getServiceManager());
			return $viewHelper;
		});
		$e->getApplication()->getServiceManager()->get('viewhelpermanager')->setFactory('getChangeTime', function($sm) use ($e) {
			$viewHelper = new View\Helper\GetChangeTime();
			return $viewHelper;
		});
		$e->getApplication()->getServiceManager()->get('viewhelpermanager')->setFactory('controllerName', function($sm) use ($e) {
			$viewHelper = new View\Helper\ControllerName($e->getRouteMatch());
			return $viewHelper;
		});
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
